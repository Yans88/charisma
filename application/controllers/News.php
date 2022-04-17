<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {			
		$this->data['judul_browser'] = 'News';
		$this->data['judul_utama'] = 'News';
		$this->data['judul_sub'] = 'List';
		$this->data['news'] = $this->access->readtable('news','',array('deleted_at'=>null))->result_array();
		$this->data['isi'] = $this->load->view('news/news_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	
	public function del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_news' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('news', $data, $where);
	}
	
	public function simpan(){
		$tgl = date('Y-m-d');
		$id_news = isset($_POST['id_news']) ? (int)$_POST['id_news'] : 0;
		$judul = isset($_POST['judul']) ? $_POST['judul'] : '';
		$content = isset($_POST['content']) ? $_POST['content'] : '';
		$config['upload_path']   = './uploads/news/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '2048';
		$config['encrypt_name'] = TRUE;
        $this->load->library('upload',$config);
		
		$simpan = array(			
			'judul'			=> $judul,
			'description'	=> $content
		);
		if(!$this->upload->do_upload('userfile')){
            $gambar="";
        }else{
            $gambar=$this->upload->file_name;
			$simpan += array('img'	=> $gambar);
        }	
		$where = array();
		$save = 0;	
		if($id_news > 0){
			$where = array('id_news'=>$id_news);
			$save = $this->access->updatetable('news', $simpan, $where);   
		}else{
			$simpan += array('tgl'	=> $tgl);
			$save = $this->access->inserttable('news', $simpan);   
		}  
		if($save > 0){
			redirect(site_url('news'));
		}	 
	}
	
	public function add($id_news=0){
		$this->data['judul_browser'] = 'News';
		$this->data['judul_utama'] = 'Add';
		$this->data['judul_sub'] = 'News';
		
		$news = '';		
		if($id_news > 0){
			$this->data['judul_utama'] = 'Edit';
			$news = $this->access->readtable('news','',array('deleted_at'=>null, 'id_news'=>$id_news))->row();			
		}		
		
		$this->data['news'] = $news;
		$this->data['isi'] = $this->load->view('news/news_frm', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
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
