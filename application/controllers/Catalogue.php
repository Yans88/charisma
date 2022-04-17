<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Catalogue extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);	
	}	
	
	public function index() {
		
		if(!$this->session->userdata('login') && !$this->session->userdata('member')){
			$this->no_akses();
			return false;
		}
		
		$this->data['judul_browser'] = 'e-Catalogue';
		$this->data['judul_utama'] = 'e-Catalogue';
		$this->data['judul_sub'] = 'CHARISMA';
		$this->data['title_box'] = 'e-Catalogue';
		$this->data['kat'] = $this->access->readtable('kat_catalogue','',array('deleted_at'=>null))->result_array();
		$this->data['isi'] = $this->load->view('ecatalogue_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function category() {			
		$this->data['judul_browser'] = 'Category';
		$this->data['judul_utama'] = 'Category';
		$this->data['judul_sub'] = 'List';		
		$this->data['isi'] = $this->load->view('cat_catalogue_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function categories_data(){
        $requestData= $_REQUEST;
		    
        $category = array();
        if(!empty($requestData['search']['value'])) {
			$search = $this->db->escape_str($requestData['search']['value']);
			$category = $this->access->readtable('kat_catalogue','',array('deleted_at'=>null, 'nama_kategori !='=>'Banner'),'','','','','',array('nama_kategori'=>$search))->result_array();
		    $totalFiltered=count($category);
		    $totalData=count($category);
        }else{
			$category = $this->access->readtable('kat_catalogue','',array('deleted_at'=>null, 'nama_kategori !='=>'Banner'),'',array($requestData['length'],$requestData['start']))->result_array();
			$totalData = count($category);
			$totalFiltered=count($category);
        }
	
        $data = array();
        $nestedData=array();               
        $view_sub = '';
		$info = '';	
		$path = '';	
        if(!empty($category)){
            $i=1;			
            foreach($category as $c) {
				$nestedData=array();               
                $view_sub = '';
				
				$path = !empty($c['img']) ? base_url('uploads/kategori/'.$c['img']) : base_url('uploads/no_photo.jpg');
				$info = $c['id_kat'].'Þ'.$c['nama_kategori'].'Þ'.$path;
				$nestedData[] = $i;
				$nestedData[] = $c['nama_kategori'];
				$nestedData[] = '<img width="200" height="200" src="'.$path.'">';
				$nestedData[] = '<button title="Edit" class="btn btn-xs btn-success" id="'.$info.'" onclick="return edit_cat(this.id);"><i class="fa fa-edit"></i> Edit</button>
			<button title="Delete" onclick="return del_cat('.$c['id_kat'].');" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</button>';
				
            
				$data[] = $nestedData;
				$i++;
            
            }
        }
        //$totalFiltered=count($data);

        $json_data = array(
            "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval( $totalFiltered ),  // total number of records
            "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
            );

        echo json_encode($json_data);  // send data as json format
    }
	
	function catalogue_data(){
        $requestData= $_REQUEST;
		$select = array('e_catalogue.*','kat_catalogue.nama_kategori');        
        $member = array();
        if(!empty($requestData['search']['value'])) {
			$search = $this->db->escape_str($requestData['search']['value']);
			$member = $this->access->readtable('e_catalogue',$select,array('e_catalogue.deleted_at'=> null),array('kat_catalogue' => 'kat_catalogue.id_kat = e_catalogue.id_kat'),'','LEFT','','',array('judul'=>$search), array('nama_file'=>$search))->result_array();
		    $totalFiltered=count($member);
		    $totalData=count($member);
        }else{
			$member = $this->access->readtable('e_catalogue',$select,array('e_catalogue.deleted_at'=> null),array('kat_catalogue' => 'kat_catalogue.id_kat = e_catalogue.id_kat'),array($requestData['length'],$requestData['start']),'','LEFT')->result_array();
			$members = $this->access->readtable('e_catalogue','',array('deleted_at'=> null))->result_array();
			$totalData = count($members);
			$totalFiltered=count($members);
        }
		
        $data = array();
        $nestedData=array();               
		$info = '';	
        if(!empty($member)){
            $i=1;			
            foreach($member as $row) {
				$nestedData=array();               
                $img = '';
                $info = '';				
				$img = !empty($row['nama_file']) ? base_url('uploads/e_katalog/'.$row['file_attach']) : '';
				
				$info = $row['id_catalogue'].'Þ'.$row['judul'].'Þ'.$row['nama_file'].'Þ'.$img.'Þ'.$row['id_kat'];
				$nestedData[] = $i;
				$nestedData[] = $row['judul'];
				$nestedData[] = $row['nama_kategori'];
				$nestedData[] = '<a href='.site_url('catalogue/downloads/'.$row['id_catalogue']).'>'.$row['nama_file'].'</a>';            
				$nestedData[] = '<button title="Edit" class="btn btn-xs btn-success" id="'.$info.'" onclick="return edit_cat(this.id);"><i class="fa fa-edit"></i> Edit</button>
			<button title="Delete" onclick="return del_cat('.$row['id_catalogue'].');" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</button>';
				
            
				$data[] = $nestedData;
				$i++;
            
            }
        }
        //$totalFiltered=count($data);

        $json_data = array(
            "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
            "recordsTotal"    => intval( $totalFiltered ),  // total number of records
            "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data"            => $data   // total data array
            );

        echo json_encode($json_data);  // send data as json format
    }
	
	public function categories_del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_kat' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('kat_catalogue', $data, $where);
	}
	
	public function simpan_cat(){
		$tgl = date('Y-m-d H:i:s');				
		$id_catalogue = isset($_POST['id_catalogue']) ? (int)$_POST['id_catalogue'] : '';
		$kategori = isset($_POST['kategori']) ? (int)$_POST['kategori'] : '';
		$judul = isset($_POST['judul']) ? $_POST['judul'] : '';
		$config['upload_path']   = FCPATH.'/uploads/e_katalog/';
        $config['allowed_types'] = 'pdf';
		$config['max_size']	= '12048';
		$config['encrypt_name'] = TRUE;
        $this->load->library('upload',$config);
		
		$gambar="";	
		$simpan = array(			
			'id_kat'	=> $kategori,				
			'judul'		=> $judul				
		);
		if(!$this->upload->do_upload('userfile')){
            $gambar="";
        }else{
            $gambar=$this->upload->file_name;
			$simpan += array('file_attach'	=> $gambar, 'nama_file'=>$_FILES['userfile']['name']);
        }	
		$where = array();
		$save = 0;	
		if($id_catalogue > 0){
			$where = array('id_catalogue'=>$id_catalogue);
			$save = $this->access->updatetable('e_catalogue', $simpan, $where);   
		}else{
			$simpan += array('created_at'	=> $tgl);
			$save = $this->access->inserttable('e_catalogue', $simpan);   
		}  
		if($save > 0){
			redirect(site_url('catalogue'));
		}
	}
	
	public function simpan_cat_catalogue(){
		$tgl = date('Y-m-d H:i:s');
		$id_category = isset($_POST['id_category']) ? (int)$_POST['id_category'] : 0;		
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
			$where = array('id_kat'=>$id_category);
			$save = $this->access->updatetable('kat_catalogue', $simpan, $where);   
		}else{
			$simpan += array('created_at'	=> $tgl);
			$save = $this->access->inserttable('kat_catalogue', $simpan);   
		}  
		redirect(site_url('catalogue/category'));
	}
	
	public function downloads($id) {
		$this->load->helper('download');
		$this->db->where('id_catalogue', $id);
		$query = $this->db->get('e_catalogue');
		if ($query->num_rows() == 0) {
		   return false;
		}
		$path = '';
		$file = '';
		$original = '';
		$stored_file_name = '';
		foreach ($query->result_array() as $result) {			
			$file = file_get_contents(base_url('/uploads/e_katalog/'.$result['file_attach']));
			$original = $result['nama_file']; 

		}
		// error_log($original);
		force_download($original,$file);
	}
	
	public function del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_catalogue' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('e_catalogue', $data, $where);
	}
		
	
	
	public function no_akses() {
		if ($this->session->userdata('login') == FALSE) {
			redirect('/');
			return false;
		}
		$this->data['judul_browser'] = 'Tidak Ada Akses';
		$this->data['judul_utama'] = 'Tidak Ada Akses';
		$this->data['judul_sub'] = '';
		$this->data['isi'] = '<div class="alert alert-danger">Anda tidak memiliki Akses.</div>';
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	

}
