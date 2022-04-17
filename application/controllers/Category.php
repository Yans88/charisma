<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {			
		$this->data['judul_browser'] = 'Category';
		$this->data['judul_utama'] = 'Category';
		$this->data['judul_sub'] = 'List';		
		$this->data['type'] = 1;		
		$this->data['isi'] = $this->load->view('category/category_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function retail() {			
		$this->data['judul_browser'] = 'Category';
		$this->data['judul_utama'] = 'Category';
		$this->data['judul_sub'] = 'List';	
		$this->data['type'] = 2;		
		$this->data['isi'] = $this->load->view('category/category_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function product($id_sub=0) {			
		$this->data['judul_browser'] = 'Product';
		$this->data['judul_utama'] = 'Product';
		$this->data['judul_sub'] = 'List';		
		$this->data['id_sub'] = $id_sub;		
		$this->data['isi'] = $this->load->view('category/product_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function products_data($id_sub=0){
        $requestData= $_REQUEST;
		$select = array('product.*','kategori.nama_kategori','sub_kategori.nama_sub');   
		$where = array('product.deleted_at'=>null);
		if($id_sub > 0){
			$where += array('product.id_subkategori'=>$id_sub);
		}
        $category = array();
        if(!empty($requestData['search']['value'])) {
			$search = $this->db->escape_str($requestData['search']['value']);
			$product = $this->access->readtable('product',$select,$where,array('kategori'=>'kategori.id_kategori = product.id_kategori','sub_kategori'=>'sub_kategori.id_sub = product.id_subkategori'),'','','LEFT','',array('product.nama_product'=>$search), array('product.harga'=>$search,'kategori.nama_kategori'=>$search,'sub_kategori.nama_sub'=>$search))->result_array();		
		    $totalFiltered=count($product);
		    $totalData=count($product);
        }else{
			$product = $this->access->readtable('product',$select,$where,array('kategori'=>'kategori.id_kategori = product.id_kategori','sub_kategori'=>'sub_kategori.id_sub = product.id_subkategori'),array($requestData['length'],$requestData['start']),'','LEFT','','','')->result_array();
			$products = $this->access->readtable('product',$select,$where,array('kategori'=>'kategori.id_kategori = product.id_kategori','sub_kategori'=>'sub_kategori.id_sub = product.id_subkategori'),'','','LEFT','','','')->result_array();
			$totalData = count($products);
			$totalFiltered=count($products);
        }	
		
        $data = array();
        $nestedData=array();               
        $view_sub = '';
        $view_img = '';
		$info = '';	
		$path = '';	
        if(!empty($product)){
            $i=1;			
            foreach($product as $p) {
				$nestedData=array();               
                $view_sub = '';
                $view_img = '';
				if($p['deleted_at'] == null){
					$view_sub = site_url('category/add_prod/'.$p['id_product']);
					$view_img = site_url('category/banner_product/'.$p['id_product']);
					$path = !empty($p['img']) ? base_url('uploads/kategori/products/'.$p['img']) : base_url('uploads/no_photo.jpg');				
					$nestedData[] = $i;
					$nestedData[] = $p['nama_product'];
					// $nestedData[] = $p['nama_kategori'].' - '.$p['nama_sub'];
					$nestedData[] = $p['crazy_sale'] == 'crazy_sale' ? '<i class="glyphicon glyphicon-ok"></i>' : '';
					$nestedData[] = number_format($p['harga'],2,',','.');
					$nestedData[] = '<img width="200" height="200" src="'.$path.'">';
					$nestedData[] = '<a href='.$view_sub.' title="View"><button title="View" class="btn btn-xs btn-success"><i class="fa fa-eye"></i> View</button></a>
									<button title="Delete" onclick="return del_prod('.$p['id_product'].');" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</button><br>
									<a href='.$view_img.' title="View"><button title="View more image" class="btn btn-xs btn-primary" style="margin-top:4px;"><i class="fa fa-tags"></i> View more image</button></a>';
					
					$data[] = $nestedData;				
					$i++;
				}
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
	
	function categories_data($type=0){
        $requestData= $_REQUEST;
		        
        $category = array();
        if(!empty($requestData['search']['value'])) {
			$search = $this->db->escape_str($requestData['search']['value']);
			$category = $this->access->readtable('kategori','',array('deleted_at'=>null, 'nama_kategori !='=>'Banner','type'=>$type),'','','','','',array('nama_kategori'=>$search))->result_array();
		    $totalFiltered=count($category);
		    $totalData=count($category);
        }else{
			$categories = $this->access->readtable('kategori','',array('deleted_at'=>null, 'nama_kategori !='=>'Banner','type'=>$type))->result_array();
			$category = $this->access->readtable('kategori','',array('deleted_at'=>null, 'nama_kategori !='=>'Banner','type'=>$type),'',array($requestData['length'],$requestData['start']))->result_array();
			$totalData = count($categories);
			$totalFiltered=count($categories);
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
				if($c['deleted_at'] == null){
					$view_sub = site_url('category/subcategory/'.$c['id_kategori']);
					$path = !empty($c['img']) ? base_url('uploads/kategori/'.$c['img']) : base_url('uploads/no_photo.jpg');
					$info = $c['id_kategori'].'Þ'.$c['nama_kategori'].'Þ'.$path;
					$nestedData[] = $i;
					$nestedData[] = $c['nama_kategori'];
					$nestedData[] = '<img width="200" height="200" src="'.$path.'">';
					$nestedData[] = '<a href="'.$view_sub .'" ><button title="View Sub Category" class="btn btn-xs btn-primary view_member"><i class="fa fa-eye"></i> View Sub Category</button></a>
				<button title="Edit" class="btn btn-xs btn-success" id="'.$info.'" onclick="return edit_cat(this.id);"><i class="fa fa-edit"></i> Edit</button>
				<button title="Delete" onclick="return del_cat('.$c['id_kategori'].');" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</button>';
					
				
					$data[] = $nestedData;				
					$i++;
				}
            
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
	
	public function banner() {			
		$this->data['judul_browser'] = 'Banner';
		$this->data['judul_utama'] = 'List';
		$this->data['judul_sub'] = 'Banner';
		$this->data['category'] = $this->access->readtable('kategori','',array('deleted_at'=>null, 'nama_kategori'=>'Banner'))->result_array();
		$this->data['isi'] = $this->load->view('category/category_banner', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function banner_product($id_product=0) {	
		$product = $this->access->readtable('product','',array('deleted_at'=>null, 'id_product'=>$id_product))->row();
		$this->data['judul_browser'] = 'Product';
		$this->data['judul_utama'] = $product->nama_product;
		$this->data['judul_sub'] = 'Image';
		$this->data['id_product'] = $id_product;
		$this->data['category'] = $this->access->readtable('product_img','',array('deleted_at'=>null, 'id_product'=>$id_product))->result_array();
		
		$this->data['isi'] = $this->load->view('category/banner_product', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function subcategory($id_kategori=0) {			
		$this->data['judul_browser'] = 'Sub Category';
		$this->data['judul_sub'] = 'Sub Category';
		$category = $this->access->readtable('kategori','',array('deleted_at'=>null, 'id_kategori'=>$id_kategori))->row();
		$this->data['judul_utama'] = $category->nama_kategori;
		$this->data['id_kategori'] = $id_kategori;		
		$this->data['isi'] = $this->load->view('category/sub_cat', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function subcategory_data($id_kategori=0){
        $requestData= $_REQUEST;
		$select = '';        
        $category = array();
        if(!empty($requestData['search']['value'])) {
			$search = $this->db->escape_str($requestData['search']['value']);
			$sub_kategori = $this->access->readtable('sub_kategori',$select,array('deleted_at'=>null, 'sub_kategori.id_kategori'=>$id_kategori),'','','','','',array('sub_kategori.nama_sub'=>$search), '')->result_array();
			$totalFiltered=count($sub_kategori);
		    $totalData=count($sub_kategori);
        }else{
			$sub_kategoris = $this->access->readtable('sub_kategori','',array('deleted_at'=>null, 'sub_kategori.id_kategori'=>$id_kategori))->result_array();
			$sub_kategori = $this->access->readtable('sub_kategori','',array('deleted_at'=>null, 'sub_kategori.id_kategori'=>$id_kategori),'',array($requestData['length'],$requestData['start']))->result_array();
			$totalData = count($sub_kategoris);
			$totalFiltered=count($sub_kategoris);
        }
		
		
        $data = array();
        $nestedData=array();               
        $view_sub = '';
		$info = '';	
		$path = '';	
	
        if(!empty($sub_kategori)){
            $i=1;			
            foreach($sub_kategori as $s) {
				$nestedData=array();               
                $view_sub = '';
                $view_sub = site_url('category/product/'.$s['id_sub']);
				$path = '';
				$path = !empty($s['img']) ? base_url('uploads/sub_kategori/'.$s['img']) : base_url('uploads/no_photo.jpg');
				$info = $s['id_sub'].'Þ'.$s['id_kategori'].'Þ'.$s['nama_sub'].'Þ'.$path;
				
				$nestedData[] = $i;
				$nestedData[] = $s['nama_sub'];
				$nestedData[] = '<img width="200" height="200" src="'.$path.'">';
				$nestedData[] = '<a href="'.$view_sub .'" ><button title="View Product" class="hide btn btn-xs btn-primary"><i class="fa fa-eye"></i> View Product</button></a>
				<button title="Edit" class="btn btn-xs btn-success" id="'.$info.'" onclick="return edit_cat(this.id);"><i class="fa fa-edit"></i> Edit</button>
			<button title="Delete" onclick="return del_cat('.$s['id_sub'].');" class="btn btn-xs btn-danger"><i class="fa fa-trash-o"></i> Delete</button>';
				
            
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
	
	public function add_prod($id_product=0){
		$this->data['judul_browser'] = 'Product';
		$this->data['judul_utama'] = 'Add';
		$this->data['judul_sub'] = 'Product';
		$category = $this->access->readtable('kategori','',array('deleted_at'=>null, 'nama_kategori !='=>'Banner','type'=>1))->result_array();
		$category2 = $this->access->readtable('kategori','',array('deleted_at'=>null, 'nama_kategori !='=>'Banner','type'=>2))->result_array();
		$sub_cat = '';
		$product = '';
		$variant = '';
		if($id_product > 0){
			$this->data['judul_utama'] = 'Edit';
			$product = $this->access->readtable('product','',array('deleted_at'=>null, 'id_product'=>$id_product))->row();
			$sub_cat = $this->access->readtable('sub_kategori','',array('deleted_at'=>null, 'id_kategori'=>$product->id_kategori))->result_array();
			$sub_cat2 = $this->access->readtable('sub_kategori','',array('deleted_at'=>null, 'id_kategori'=>$product->id_kategori2))->result_array();
			$variant = $this->access->readtable('product_variant','',array('deleted_at'=>null, 'id_product'=>$id_product))->result_array();
		}		
		$this->data['kat'] = $category;
		$this->data['kat2'] = $category2;
		$this->data['sub_kat'] = $sub_cat;
		$this->data['sub_cat2'] = $sub_cat2;
		$this->data['products'] = $product;
		$this->data['id_product'] = $id_product;
		$this->data['variant'] = $variant;
		$this->data['isi'] = $this->load->view('category/product_frm', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function simpan_product(){
		$id_product = isset($_POST['id_product']) ? (int)$_POST['id_product'] : 0;
		$nama_product = isset($_POST['nama_product']) ? $_POST['nama_product'] : '';
		$harga = isset($_POST['harga']) ? str_replace('.','',$_POST['harga']) : '';
		$harga_crazysale = isset($_POST['harga_crazysale']) ? str_replace('.','',$_POST['harga_crazysale']) : '';
		$deskripsi = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';		
		$kategori = isset($_POST['kategori']) ? (int)$_POST['kategori'] : '0';		
		$sub_kategori = isset($_POST['sub_kategori']) ? (int)$_POST['sub_kategori'] : '0';		
		$kategori_retail = isset($_POST['kategori_retail']) ? (int)$_POST['kategori_retail'] : '0';		
		$sub_kategori_retail = isset($_POST['sub_kategori_retail']) ? (int)$_POST['sub_kategori_retail'] : '0';
		$weight = isset($_POST['weight']) ? str_replace('.','',$_POST['weight']) : 1000;		
		$crazy_sale = isset($_POST['crazy_sale']) ? 'crazy_sale' : '';		
		$type_trans = isset($_POST['type_trans']) ? 1 : 0;		
		$type_sample = isset($_POST['type_sample']) ? 1 : 0;		
	
		$config['upload_path']   = './uploads/kategori/products/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	= '2048';
		$config['encrypt_name'] = TRUE;
        $this->load->library('upload',$config);
		$gambar="";	
		$simpan = array(			
			'nama_product'		=> $nama_product,			
			'harga'				=> $harga,
			'harga_crazysale'	=> $harga_crazysale,
			'deskripsi'			=> $deskripsi,
			'id_kategori'		=> $kategori,
			'id_subkategori'	=> $sub_kategori,
			'id_kategori2'		=> $kategori_retail,
			'id_subkategori2'	=> $sub_kategori_retail,
			'crazy_sale'		=> $crazy_sale,
			'type_trans'		=> $type_trans,
			'type_sample'		=> $type_sample,
			'weight'			=> (int)$weight
		);
		if(!$this->upload->do_upload('userfile')){
            $gambar="";
        }else{
            $gambar=$this->upload->file_name;
			$simpan += array('img'	=> $gambar);
        }	
		$save = 0;
		if($id_product > 0){
			$save = $this->access->updatetable('product', $simpan, array('id_product' => $id_product));
			$save = $id_product;
		}else{
			$simpan += array('created_at' => date('Y-m-d H:i:s'));
			$save = $this->access->inserttable('product', $simpan);
		}
		if($save > 0){
			redirect(site_url('category/product'));
		}
	}
	
	function save_variant(){
		$id_product = isset($_POST['id_product']) ? (int)$_POST['id_product'] : 0;
		$nama_variant = isset($_POST['nama_variant']) ? $_POST['nama_variant'] : '';
		$stok = isset($_POST['stok']) ? str_replace('.','',$_POST['stok']) : '999';
		$id_variant = isset($_POST['id_variant']) ? str_replace('.','',$_POST['id_variant']) : '';
		$save = 0;
		$simpan = array(			
			'nama_variant'	=> $nama_variant,			
			'id_product'	=> $id_product,
			'stok'			=> (int)$stok
		);
		if($id_variant > 0){
			$save = $this->access->updatetable('product_variant', $simpan, array('id_variant' => $id_variant));
			$save = $id_product;
		}else{
			$simpan += array('created_at' => date('Y-m-d H:i:s'));
			$save = $this->access->inserttable('product_variant', $simpan);
		}
		
		echo $save;
	}
	
	function get_sub(){
		$kategori = isset($_POST['kategori']) ? $_POST['kategori'] : '0';
		$sub_cat = $this->access->readtable('sub_kategori','',array('deleted_at'=>null, 'id_kategori'=>$kategori))->result_array();
		$_dt = array();
		if(!empty($sub_cat)){
			foreach($sub_cat as $sc){
				$_dt[] = array('id_sub' => $sc['id_sub'], 'nama_sub' => $sc['nama_sub']);
			}
		}
		echo json_encode($_dt);
	}
	
	public function del(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_kategori' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('kategori', $data, $where);
	}
	
	public function del_sub(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_sub' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('sub_kategori', $data, $where);
	}
	
	public function del_prod(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_product' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('product', $data, $where);
	}
	
	public function del_variant(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_variant' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('product_variant', $data, $where);
	}
	
	public function del_img(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_img' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('product_img', $data, $where);
	}
	
	public function simpan_img(){
		$tgl = date('Y-m-d H:i:s');
		$id_img = isset($_POST['id_img']) ? (int)$_POST['id_img'] : 0;		
		$id_product = isset($_POST['id_product']) ? (int)$_POST['id_product'] : 0;		
		$config['upload_path']   = FCPATH.'/uploads/kategori/products/';
        $config['allowed_types'] = 'gif|jpg|png|ico';
		$config['max_size']	= '2048';
		$config['encrypt_name'] = TRUE;
        $this->load->library('upload',$config);
		$gambar="";	
		$simpan = array(			
			'id_product'		=> $id_product				
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
			$save = $this->access->updatetable('product_img', $simpan, $where);   
		}else{
			$simpan += array('created_at'	=> $tgl);
			$save = $this->access->inserttable('product_img', $simpan);   
		}  
		if($save > 0){
			redirect(site_url('category/banner_product/'.$id_product));
		}
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
				redirect(site_url('category/banner'));
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
	
	public function simpan_sub(){
		$tgl = date('Y-m-d H:i:s');
		$id_sub = isset($_POST['id_sub']) ? (int)$_POST['id_sub'] : 0;
		$id_category = isset($_POST['id_category']) ? (int)$_POST['id_category'] : 0;		
		$sub_category = isset($_POST['sub_category']) ? $_POST['sub_category'] : '';
		$config['upload_path']   = FCPATH.'/uploads/sub_kategori/';
        $config['allowed_types'] = 'gif|jpg|png|ico';
		$config['max_size']	= '2048';
		$config['encrypt_name'] = TRUE;
        $this->load->library('upload',$config);
		$gambar="";	
		$simpan = array(			
			'nama_sub'		=> $sub_category,
			'id_kategori'	=> $id_category			
		);
		if(!$this->upload->do_upload('userfile')){
            $gambar="";
        }else{
            $gambar=$this->upload->file_name;
			$simpan += array('img'	=> $gambar);
        }	
		$where = array();
		$save = 0;	
		if($id_sub > 0){
			$where = array('id_sub'=>$id_sub);
			$save = $this->access->updatetable('sub_kategori', $simpan, $where);   
		}else{
			$simpan += array('created_at'	=> $tgl);
			$save = $this->access->inserttable('sub_kategori', $simpan);   
		}
		
		if($save > 0){
			redirect(site_url('category/subcategory/'.$id_category));
		}
	}
	
	public function type(){
		$this->data['judul_browser'] = 'Type';
		$this->data['judul_utama'] = 'Type';
		$this->data['judul_sub'] = 'List';
		$this->data['type'] = $this->access->readtable('type','',array('type.deleted_at'=>null))->result_array();
		$this->data['isi'] = $this->load->view('category/type_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function simpan_type(){
		$tgl = date('Y-m-d H:i:s');
		$id_type = isset($_POST['id_type']) ? (int)$_POST['id_type'] : 0;		
		$type = isset($_POST['type']) ? $_POST['type'] : '';
		$simpan = array(			
			'nama_type'	=> $type			
		);
		$where = array();
		$save = 0;	
		if($id_type > 0){
			$where = array('id_type'=>$id_type);
			$save = $this->access->updatetable('type', $simpan, $where);   
		}else{
			$simpan += array('created_at'	=> $tgl);
			$save = $this->access->inserttable('type', $simpan);   
		}  
		echo $save;	 
	}
	
	public function del_type(){
		$tgl = date('Y-m-d H:i:s');
		$where = array(
			'id_type' => $_POST['id']
		);
		$data = array(
			'deleted_at'	=> $tgl
		);
		echo $this->access->updatetable('type', $data, $where);
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
