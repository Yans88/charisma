<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inquiry extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {			
		$this->data['judul_browser'] = 'Inquiry';
		$this->data['judul_utama'] = 'Inquiry';
		$this->data['judul_sub'] = 'List';		
		$select = array('inquiry_sample.*','members.nama','product.nama_product','members.address','members.phone','members.email','admin.fullname');
		$this->data['inquiry_sample'] = $this->access->readtable('inquiry_sample',$select,array('inquiry_sample.deleted_at'=>null,'type_is'=>2),array('members'=>'members.id_member = inquiry_sample.id_member','admin'=>'admin.operator_id = inquiry_sample.status_by','product'=>'product.id_product = inquiry_sample.id_product'),'','','LEFT')->result_array();
		$this->data['isi'] = $this->load->view('inquiry_sample/inquiry_sample_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function sample() {			
		$this->data['judul_browser'] = 'Sample';
		$this->data['judul_utama'] = 'Sample';
		$this->data['judul_sub'] = 'List';		
		$select = array('inquiry_sample.*','members.nama','product.nama_product','members.address','members.phone','members.email','admin.fullname');
		$this->data['inquiry_sample'] = $this->access->readtable('inquiry_sample',$select,array('inquiry_sample.deleted_at'=>null,'type_is'=>1),array('members'=>'members.id_member = inquiry_sample.id_member','admin'=>'admin.operator_id = inquiry_sample.status_by','product'=>'product.id_product = inquiry_sample.id_product'),'','','LEFT')->result_array();
		$this->data['isi'] = $this->load->view('inquiry_sample/inquiry_sample_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	
	public function upd_status(){
		$tgl = date('Y-m-d');
		$val = isset($_POST['id']) ? $_POST['id'] : '';	
		//error_log($val);	
		$_val = explode('_',$val);
		//error_log(serialize($_val));
		$status = $_val[0];
		$id = $_val[1];
		$dt_redeem = '';
		$dt_member = '';
		$id_member = 0;
		$point = 0;
		$total_redeem = 0;
		$upd = array();
		
		$simpan = array(			
			'status'		=> $status,
			'status_by'		=> $this->session->userdata('operator_id'),
			'status_date'	=> date('Y-m-d H:i:s')		
		);
		
		$where = array('id_inquiry'=>$id);
		$this->access->updatetable('inquiry_sample', $simpan, $where); 
		echo $id;
	}
	
	public function simpan_img(){
		$tgl = date('Y-m-d H:i:s');
		$id_img = isset($_POST['id_img']) ? (int)$_POST['id_img'] : 0;		
		$id_product = isset($_POST['id_product']) ? (int)$_POST['id_product'] : 0;		
		$config['upload_path']   = FCPATH.'/uploads/pabrik/';
        $config['allowed_types'] = 'gif|jpg|png|ico';
		$config['max_size']	= '2048';
		$config['encrypt_name'] = TRUE;
        $this->load->library('upload',$config);
		$gambar="";	
		$simpan = array(			
			'id_pabrik'		=> $id_product				
		);
		if(!$this->upload->do_upload('userfile')){
            $gambar="";
        }else{
            $gambar=$this->upload->file_name;
			$simpan += array('img'	=> $gambar);
        }	
		$where = array();
		$save = 0;	
		if($id_img > 0){
			$where = array('id_img'=>$id_img);
			$save = $this->access->updatetable('pabrik_img', $simpan, $where);   
		}else{
			$simpan += array('created_at'	=> $tgl);
			$save = $this->access->inserttable('pabrik_img', $simpan);   
		}  
		if($save > 0){
			redirect(site_url('outlet/pabrik_img/'.$id_product));
		}
	}
	
	public function del_img(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_img' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('pabrik_img', $data, $where);
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
