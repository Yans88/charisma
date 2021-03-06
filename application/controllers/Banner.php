<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banner extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	
	public function index() {			
		$this->data['judul_browser'] = 'Banner';
		$this->data['judul_utama'] = 'List';
		$this->data['judul_sub'] = 'Banner';
		$this->data['category'] = $this->access->readtable('kategori','',array('deleted_at'=>null, 'nama_kategori'=>'Banner'))->result_array();
		$this->data['isi'] = $this->load->view('category/category_banner', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function web() {			
		$this->data['judul_browser'] = 'Banner';
		$this->data['judul_utama'] = 'List';
		$this->data['judul_sub'] = 'Banner';
		$this->data['category'] = $this->access->readtable('kategori','',array('deleted_at'=>null, 'nama_kategori'=>'Banner Web'))->result_array();
		$this->data['isi'] = $this->load->view('category/banner_web', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	
	public function simpan_cat(){
		$tgl = date('Y-m-d H:i:s');
		$id_category = isset($_POST['id_category']) ? (int)$_POST['id_category'] : 0;		
		$type = isset($_POST['type']) ? (int)$_POST['type'] : 2;		
		$category = isset($_POST['category']) ? $_POST['category'] : '';
		$config['upload_path']   = FCPATH.'/uploads/kategori/';
        $config['allowed_types'] = 'gif|jpg|png|ico';
		$config['max_size']	= '2048';
		$config['encrypt_name'] = TRUE;
        $this->load->library('upload',$config);
		$gambar="";	
		$simpan = array(			
			'nama_kategori'		=> $category				
		);
		if(!$this->upload->do_upload('userfile')){
            $gambar="";
        }else{
            $gambar=$this->upload->file_name;
			$simpan += array('img'	=> $gambar);
        }	
		$where = array();
		$save = 0;	
		if($id_category > 0){
			$where = array('id_kategori'=>$id_category);
			$save = $this->access->updatetable('kategori', $simpan, $where);   
		}else{
			$simpan += array('created_at'	=> $tgl,'type'=>$type);
			$save = $this->access->inserttable('kategori', $simpan);   
		}  
		if($save > 0){
			if($category == 'Banner'){
				redirect(site_url('banner'));
			}
			if($category == 'Banner Web'){
				redirect(site_url('banner/web'));
			}
			if($type == 1){
				redirect(site_url('category'));
			}
			if($type == 2){
				redirect(site_url('category/retail'));
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
