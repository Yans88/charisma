<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
		$this->load->model('Setting_m','sm', true);
		$this->load->library('converter');	
	}	
	
	public function index($referal_code=0) {			
		$this->data['judul_browser'] = 'Register';
		$this->data['judul_utama'] = 'Register';
		$this->data['judul_sub'] = 'Register'; 
		$this->data['msg'] = '';
		$this->data['upline'] = $this->converter->decode($referal_code);
		$this->load->view('themes/register_form_v', $this->data);
	}
	
	public function action_reg(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$nama_member = isset($param['nama_member']) ? $param['nama_member'] : '';
		$gcm_token = isset($param['gcm_token']) ? $param['gcm_token'] : '';
		$password = isset($param['password']) ? $this->converter->encode($param['password']) : '';
		$email = isset($param['email']) ? $param['email'] : '';
    	$dob = isset($param['dob']) ? date('Y-m-d', strtotime($param['dob'])) : '';
		$jk = isset($param['jk']) ? $param['jk'] : '';
		$alamat = isset($param['alamat']) ? $param['alamat'] : '';
		$kota = isset($param['kota']) ? $param['kota'] : '';
		$kode_pos = isset($param['kode_pos']) ? $param['kode_pos'] : '';
		$phone = isset($param['phone']) ? $param['phone'] : '';
		$tgl_reg = date('Y-m-d H:i:s');
		$upline = isset($param['upline']) ? $param['upline'] : '';
		$type = isset($param['type']) ? $param['type'] : '';
		$user_id = isset($param['user_id']) ? $param['user_id'] : '';
		$device = isset($param['device']) ? $param['device'] : '';
		
		$photo = isset($param['photo']) ? $param['photo'] : '';
		$upl = '';
		$upload = array();
		$config['upload_path'] = "./uploads/member/";
		$config['allowed_types'] = "jpg|png|jpeg|";
		$config['max_size']	= '1048';
		$name = $_FILES['photo']['name'];
		$config['file_name'] = date('YmdHis').$name;
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload',$config);
		$chk_email = $this->access->readtable('members','',array('email'=>$email,'deleted_at'=>null))->row();
		$ketemu = count($chk_email);
		error_log($this->db->last_query());
		error_log($ketemu);
		$login = '';
		$jk = '';
		$lang = 'Bahasa';
		$details = '';
		$msg = '';
		if($ketemu > 0){
			$msg = 'Email already exist';
			$this->data['msg'] = $msg;
			$this->data['judul_browser'] = 'Register';
			$this->data['judul_utama'] = 'Register';
			$this->data['judul_sub'] = 'Register'; 
			$this->load->view('themes/register_form_v', $this->data);
		}else{
			$simpan = array(
				"nama"     	=> $nama_member,
				"dob"		=> $dob,
				"jk	"		=> $jk,
				"email"	   	=> $email,
				"address"	=> $alamat,
				"kota"		=> $kota,
				"phone"		=> $phone,
				"kode_pos"	=> $kode_pos,
				"upline"	=> $upline,
				"tgl_reg" 	=> $tgl_reg
			);
			
			if(!empty($password)){
				$simpan += array("pass"	=> $password);
			}

			if(!empty($_FILES['photo'])){
				if($this->upload->do_upload('photo')){
					$upl = $this->upload->data();
					$simpan += array("photo"	=> base_url('uploads/member/'.$upl['file_name']));
				}
			}
			$save = $this->access->inserttable('members',$simpan);
			$opsi_val_arr = $this->sm->get_key_val();
			foreach ($opsi_val_arr as $key => $value){
				$out[$key] = $value;
			}
	
			$this->load->library('send_notif');
			$from = $out['email'];
			$pass = $out['pass'];
			$to = $email;
			$subject = $out['subj_email_register'];
			$content_member = $out['content_verifyReg'];
			$content = str_replace('[#name#]', $nama_member, $content_member);
			if($save){
				$msg = 'Register success ...';
				$id = $this->converter->encode($save);
				$link = VERIFY_REGISTER_LINK.'='.$id;
				$href = '<a href="'.$link.'">'.$link.'</a>';
				$content = str_replace('[#verify_link#]', $href, $content);
				$this->send_notif->send_email($from,$pass, $to,$subject, $content);
				$this->load->view('themes/success_register');
			}
		}
		
	}
	
	public function no_akses() {
		if ($this->session->userdata('login') == FALSE) {
			redirect('/');
			return false;
		}
		$this->data['judul_browser'] = 'Tidak Ada Akses';
		$this->data['judul_utama'] = 'Tidak Ada Akses';
		$this->data['judul_sub'] = '';
		$this->data['isi'] = '<div class="alert alert-danger">Anda tidak memiliki Akses.</div><div class="error-page">
        <h3 class="text-red"><i class="fa fa-warning text-yellow"></i> Oops! No Akses.</h3></div>';
		$this->load->view('themes/layout_utama_v', $this->data);
	}


}
