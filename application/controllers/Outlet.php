<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Outlet extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {			
		$this->data['judul_browser'] = 'Outlet';
		$this->data['judul_utama'] = 'Outlet';
		$this->data['judul_sub'] = 'List';
		$this->data['type'] = 1;
		$this->data['faq'] = $this->access->readtable('outlet_pabrik','',array('deleted_at'=>null,'type'=>1))->result_array();
		$this->data['isi'] = $this->load->view('outlets/outlet_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function pabrik() {			
		$this->data['judul_browser'] = 'Pabrik';
		$this->data['judul_utama'] = 'Pabrik';
		$this->data['judul_sub'] = 'List';
		$this->data['type'] = 2;
		$this->data['faq'] = $this->access->readtable('outlet_pabrik','',array('deleted_at'=>null,'type'=>2))->result_array();
		$this->data['isi'] = $this->load->view('outlets/pabrik_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	
	public function del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_op' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('outlet_pabrik', $data, $where);
	}
	
	public function simpan(){
		$tgl = date('Y-m-d H:i:s');
		$id_outlet = isset($_POST['id_outlet']) ? (int)$_POST['id_outlet'] : 0;
		$deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';
		$longitude = isset($_POST['longitude']) ? $_POST['longitude'] : '';		
		$latitude = isset($_POST['latitude']) ? $_POST['latitude'] : '';		
		$type = isset($_POST['type']) ? $_POST['type'] : '';		
		$simpan = array(			
			'deskripsi'	=> $deskripsi,
			'longitude'	=> $longitude,
			'latitude'	=> $latitude
		);
		$where = array();
		$save = 0;	
		if($id_outlet > 0){
			$where = array('id_op'=>$id_outlet);
			$save = $this->access->updatetable('outlet_pabrik', $simpan, $where);   
		}else{
			$simpan += array('created_at' => $tgl,'type' => $type);
			$save = $this->access->inserttable('outlet_pabrik', $simpan);   
		}  
		echo $save;	 
	}
	
	public function pabrik_img($id_pabrik=0) {	
		$pabrik = $this->access->readtable('outlet_pabrik','',array('deleted_at'=>null, 'id_op'=>$id_pabrik))->row();
		$this->data['judul_browser'] = 'Pabrik';
		$this->data['judul_utama'] = $pabrik->deskripsi;
		$this->data['judul_sub'] = 'Image';
		$this->data['id_product'] = $id_pabrik;
		$this->data['category'] = $this->access->readtable('pabrik_img','',array('deleted_at'=>null, 'id_pabrik'=>$id_pabrik))->result_array();
		
		$this->data['isi'] = $this->load->view('outlets/pabrik_img', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
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
