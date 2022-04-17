<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';


class Category extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();       
		$this->load->model('Access','access',true);	
		$this->load->model('Setting_m','sm', true);
		// $this->load->library('converter');
    }

    public function index_get(){
        $type = $this->get('type');	
		$type = (int)$type;
		$kategori = '';
		$sort = array('nama_kategori','ASC');
		$kategori = $this->access->readtable('kategori','',array('deleted_at'=>null,'type'=>$type),'','',$sort)->result_array();
		$dt = array();
		$path = '';
		if(!empty($kategori)){
			foreach($kategori as $k){
				$path = !empty($k['img']) ? base_url('uploads/kategori/'.$k['img']) : base_url('uploads/no_photo.jpg');
				if($k['nama_kategori'] != 'Banner'){
					$dt[] = array(
						"id_kategori"		=> $k['id_kategori'],
						"nama_kategori"		=> $k['nama_kategori'],
						'image'				=> $path
					);
				}
			}
		}
		if (!empty($dt)){
            $res = array(
				'err_code' 	=> '00',
                'message' 	=> 'ok',
                'data' 		=> $dt,
			);
            $this->set_response($res, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $this->set_response([
                'err_code' => '04',
                'message' => 'Data not be found'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
    }	
	
	public function catalogue_get(){
        $type = $this->get('type');	
		$type = (int)$type;
		$kategori = '';
		$sort = array('nama_kategori','ASC');
		$kategori = $this->access->readtable('kat_catalogue','',array('deleted_at'=>null),'','',$sort)->result_array();
		$dt = array();
		$path = '';
		if(!empty($kategori)){
			foreach($kategori as $k){
				$path = !empty($k['img']) ? base_url('uploads/kategori/'.$k['img']) : base_url('uploads/no_photo.jpg');
				if($k['nama_kategori'] != 'Banner'){
					$dt[] = array(
						"id_kategori"		=> $k['id_kat'],
						"nama_kategori"		=> $k['nama_kategori'],
						'image'				=> $path
					);
				}
			}
		}
		if (!empty($dt)){
            $res = array(
				'err_code' 	=> '00',
                'message' 	=> 'ok',
                'data' 		=> $dt,
			);
            $this->set_response($res, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $this->set_response([
                'err_code' => '04',
                'message' => 'Data not be found'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
    }	
	
	public function banner_get(){
		$_banner = $this->access->readtable('kategori','',array('nama_kategori'=>'Banner','deleted_at'=>null))->result_array();
		$dataku = array();
		$path = '';
		if(!empty($_banner)){
			foreach($_banner as $banner){
				$path = '';
				$path = !empty($banner['img']) ? base_url('uploads/kategori/'.$banner['img']) : '';
				$dataku[] = $path;
			}
		}
		$dt_banner =  array();
		if (!empty($dataku)){
			$dt_banner = array(
				'err_code' 	=> '00',
                'message' 	=> 'ok',
                'data' 		=> $dataku,			);
			
            $this->set_response($dt_banner, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $this->set_response([
                'err_code' => '04',
                'message' => 'Data not be found'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
	}
	
	public function banner_web_get(){
		$_banner = $this->access->readtable('kategori','',array('nama_kategori'=>'Banner Web','deleted_at'=>null))->result_array();
		$dataku = array();
		$path = '';
		if(!empty($_banner)){
			foreach($_banner as $banner){
				$path = '';
				$path = !empty($banner['img']) ? base_url('uploads/kategori/'.$banner['img']) : '';
				$dataku[] = $path;
			}
		}
		$dt_banner =  array();
		if (!empty($dataku)){
			$dt_banner = array(
				'err_code' 	=> '00',
                'message' 	=> 'ok',
                'data' 		=> $dataku,			);
			
            $this->set_response($dt_banner, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $this->set_response([
                'err_code' => '04',
                'message' => 'Data not be found'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
	}
	
	public function index_post(){
		$param = $this->input->post();
		$id = isset($param['id_kategori']) ? $param['id_kategori'] : 0;
		$id = (int)$id;
		$sub = '';
		$sort = array('sub_kategori.nama_sub','ASC');
		$select = array('kategori.nama_kategori','sub_kategori.* ');
		if($id > 0){
			$sub = $this->access->readtable('sub_kategori',$select,array('sub_kategori.id_kategori'=>$id,'sub_kategori.deleted_at'=>null),array('kategori' => 'kategori.id_kategori = sub_kategori.id_kategori'),'',$sort, 'LEFT')->result_array();
		}else{
			$sub = $this->access->readtable('sub_kategori',$select,array('sub_kategori.deleted_at'=>null),array('kategori' => 'kategori.id_kategori = sub_kategori.id_kategori'),'',$sort, 'LEFT')->result_array();
		}
		$dt = array();
		$path = '';
		if(!empty($sub)){
			foreach($sub as $s){
				$path = '';
				$path = !empty($s['img']) ? base_url('uploads/sub_kategori/'.$s['img']) : base_url('uploads/no_photo.jpg');
				$dt[] = array(
					"id_kategori"		=> $s['id_kategori'],
					"nama_kategori"		=> $s['nama_kategori'],
					"id_subcategory"	=> $s['id_sub'],
					"nama_sub"			=> $s['nama_sub'],
					"image_sub"			=> $path
				);
				
			}
		}
		if (!empty($dt)){
			$res = array(
				'err_code' 	=> '00',
                'message' 	=> 'ok',
                'data' 		=> $dt,
			);
            $this->set_response($res, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $this->set_response([
                'err_code' => '04',
                'message' => 'Data not be found'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
    }	
	
	public function new_product_get($type_product=0){
		$dt = array();
		$sort = array('product.id_product','DESC');
		$select = array('MAX(product.id_product) as id_product');
		$where = array('product.deleted_at'=>null);		
		if($type_product == 1){
			$where += array('product.type_trans'=>1);
		}
		if($type_product == 2){
			$where += array('product.type_sample'=>1);
		}
		$product = $this->access->readtable('product',$select,$where,'','',$sort,'','id_kategori')->result_array();
		
		$id_products = array();
		$products = array();
		
		if(!empty($product)){
			foreach($product as $p){
				array_push($id_products, $p['id_product']);
			}
			$products = $this->access->get_in('product','product.id_product',$id_products, $where,$sort)->result_array();
		}
	
		if(!empty($products)){
			foreach($products as $p){
				$path = '';
				$path = !empty($p['img']) ? base_url('uploads/kategori/products/'.$p['img']) : base_url('uploads/no_photo.jpg');
				$dt[] = array(
					"id_product"		=> $p['id_product'],
					"id_kategori"		=> $p['id_kategori'],					
					"id_subcategory"	=> $p['id_subkategori'],					
					"nama_product"		=> $p['nama_product'],
					"harga"				=> $p['harga'] > 0 ? $p['harga'] : 0,
					"weight"			=> $p['weight'],
					"deskripsi"			=> $p['deskripsi'],
					"type_trans"		=> $p['type_trans'],
					"type_sample"		=> $p['type_sample'],
					"img"				=> $path
				);
				
			}
		}
		if(!empty($dt)){
			$res = array(
				'err_code' 	=> '00',
                'message' 	=> 'ok',
                'data' 		=> $dt,
			);
            $this->set_response($res, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $this->set_response([
                'err_code' => '04',
                'message' => 'Data not be found'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
	}
	
	public function product_crazy_get(){
		$dt = array();
		$products = $this->access->readtable('product','',array('deleted_at'=>null,'crazy_sale'=>'crazy_sale'),'','','','','')->result_array();	
		if(!empty($products)){
			foreach($products as $p){
				$path = '';
				$path = !empty($p['img']) ? base_url('uploads/kategori/products/'.$p['img']) : base_url('uploads/no_photo.jpg');
				$dt[] = array(
					"id_product"		=> $p['id_product'],
					"id_kategori"		=> $p['id_kategori'],					
					"id_subcategory"	=> $p['id_subkategori'],					
					"nama_product"		=> $p['nama_product'],
					"harga"				=> $p['harga'] > 0 ? $p['harga'] : 0,
					"harga_crazysale"	=> $p['harga_crazysale'] > 0 ? $p['harga_crazysale'] : 0,
					"weight"			=> $p['weight'],
					"deskripsi"			=> $p['deskripsi'],
					"type_trans"		=> $p['type_trans'],
					"type_sample"		=> $p['type_sample'],
					"img"				=> $path
				);
				
			}
		}
		if(!empty($dt)){
			$res = array(
				'err_code' 	=> '00',
                'message' 	=> 'ok',
                'data' 		=> $dt,
			);
            $this->set_response($res, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $this->set_response([
                'err_code' => '04',
                'message' => 'Data not be found'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
	}
	
	function product_subcategory_post(){
		$param = $this->input->post();
		$id_sub = isset($param['id_subcategory']) ? (int)$param['id_subcategory'] : '';
		$type = isset($param['type']) ? (int)$param['type'] : 1;
		$select = array('product.*','kategori.nama_kategori','sub_kategori.nama_sub');   
		$where = array('product.deleted_at'=>null);
		$type_product = isset($param['type_product']) ? (int)$param['type_product'] : '';
		if($id_sub > 0){
			if($type == 1){
				$where += array('product.id_subkategori2'=>$id_sub);
			}
			if($type == 2){
				$where += array('product.id_subkategori'=>$id_sub);
			}
		}
		if($type_product == 1){
			$where += array('product.type_trans'=>1);
		}
		if($type_product == 2){
			$where += array('product.type_sample'=>1);
		}
		$join = array('kategori'=>'kategori.id_kategori = product.id_kategori','sub_kategori'=>'sub_kategori.id_sub = product.id_subkategori');
		if($type == 1){
			$join = array('kategori'=>'kategori.id_kategori = product.id_kategori2','sub_kategori'=>'sub_kategori.id_sub = product.id_subkategori2');
		}
		$products = $this->access->readtable('product',$select,$where,$join,'','','LEFT','','','')->result_array();
		
		if(!empty($products)){
			foreach($products as $p){
				$path = '';
				$path = !empty($p['img']) ? base_url('uploads/kategori/products/'.$p['img']) : base_url('uploads/no_photo.jpg');
				$dt[] = array(
					"id_product"		=> $p['id_product'],
					"id_kategori"		=> $p['id_kategori'],					
					"id_subcategory"	=> $p['id_subkategori'],					
					"nama_kategori"		=> $p['nama_kategori'],					
					"nama_subkategori"	=> $p['nama_sub'],					
					"nama_product"		=> $p['nama_product'],
					"harga"				=> $p['harga'] > 0 ? $p['harga'] : 0,
					"weight"			=> $p['weight'],
					"deskripsi"			=> $p['deskripsi'],
					"type_trans"		=> $p['type_trans'],
					"type_sample"		=> $p['type_sample'],
					"img"				=> $path
				);
				
			}
		}
		if(!empty($dt)){
			$res = array(
				'err_code' 	=> '00',
                'message' 	=> 'ok',
                'data' 		=> $dt,
			);
            $this->set_response($res, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $this->set_response([
                'err_code' => '04',
                'message' => 'Data not be found'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
	}
	
	function product_detail_post(){
		$param = $this->input->post();
		$id_product = isset($param['id_product']) ? (int)$param['id_product'] : '';
		$select = array('product.*','kategori.nama_kategori','sub_kategori.nama_sub');   
		$where = array('product.deleted_at'=>null);
		if($id_product > 0){
			$where += array('product.id_product'=>$id_product);
		}else{
			$this->set_response([
                'err_code' => '05',
                'message' => 'id product is required'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
			return false;
		}
		$p = $this->access->readtable('product',$select,$where,array('kategori'=>'kategori.id_kategori = product.id_kategori','sub_kategori'=>'sub_kategori.id_sub = product.id_subkategori'),'','','LEFT','','','')->row();
		$path = '';
		$_img1 = '';
		$img_detail = array();
		$dt = array();
		if(!empty($p)){
			$path = '';
			$_img1 = '';
			$path = !empty($p->img) ? base_url('uploads/kategori/products/'.$p->img) : base_url('uploads/no_photo.jpg');
			$imgs = $this->access->readtable('product_img','',array('deleted_at'=>null,'id_product'=>$id_product))->result_array();
			if(!empty($imgs)){
				$_img1 = !empty($p->img) ? base_url('uploads/kategori/products/'.$p->img) : '';
				if(!empty($_img1)){
					$img_detail[] = $_img1;
				}
				foreach($imgs as $im){
					$_img2 = '';
					$_img2 = !empty($im['img']) ? base_url('uploads/kategori/products/'.$im['img']) : '';
					if(!empty($_img2)){
						$img_detail[] = $_img2;
					}					
				}
				
			}
			$dt = array(
				"id_product"		=> $p->id_product,
				"id_kategori"		=> $p->id_kategori,					
				"id_subcategory"	=> $p->id_subkategori,					
				"nama_kategori"		=> $p->nama_kategori,					
				"nama_subkategori"	=> $p->nama_sub,					
				"nama_product"		=> $p->nama_product,
				"harga"				=> $p->harga > 0 ? $p->harga : 0,
				"weight"			=> $p->weight,
				"deskripsi"			=> $p->deskripsi,
				"type_trans"		=> $p->type_trans,
				"type_sample"		=> $p->type_sample,
				"img"				=> $path,
				"img_detail"		=> $img_detail
			);
		}
		if(!empty($dt)){
			$res = array(
				'err_code' 	=> '00',
                'message' 	=> 'ok',
                'data' 		=> $dt,
			);
            $this->set_response($res, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $this->set_response([
                'err_code' => '04',
                'message' => 'Data not be found'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
	}
	
	function product_variant_post(){
		$param = $this->input->post();
		$dt = array();
		$id_product = isset($param['id_product']) ? (int)$param['id_product'] : '';
		$where = array('deleted_at'=>null);
		if($id_product > 0){
			$where += array('id_product'=>$id_product);
		}else{
			$this->set_response([
                'err_code' => '05',
                'message' => 'id product is required'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
			return false;
		}
		$pv = $this->access->readtable('product_variant','',$where)->result_array();
		if(!empty($pv)){
			foreach($pv as $p){
				$dt[] = array(									
					"id_variant"		=> $p['id_variant'],					
					"nama_variant"		=> $p['nama_variant']
				);				
			}
		}
		if(!empty($dt)){
			$res = array(
				'err_code' 	=> '00',
                'message' 	=> 'ok',
                'data' 		=> $dt,
			);
            $this->set_response($res, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $this->set_response([
                'err_code' => '04',
                'message' => 'Data not be found'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
	}
	
	function all_product_post(){
		$param = $this->input->post();
		$type_product = isset($param['type_product']) ? (int)$param['type_product'] : '';
		$type = isset($param['type']) ? (int)$param['type'] : 2;
		$keyword = isset($param['keyword']) ? $param['keyword'] : '';
		$select = array('product.*','kategori.nama_kategori','sub_kategori.nama_sub');   
		$where = array('product.deleted_at'=>null);
		$like = array();
		if($type_product == 1){
			$where += array('product.type_trans'=>1);
		}
		if($type_product == 2){
			$where += array('product.type_sample'=>1);
		}
		if(!empty($keyword)){
			$like = array('product.nama_product'=>$keyword);
		}
		$join = array('kategori'=>'kategori.id_kategori = product.id_kategori','sub_kategori'=>'sub_kategori.id_sub = product.id_subkategori');
		if($type == 1){
			$join = array('kategori'=>'kategori.id_kategori = product.id_kategori2','sub_kategori'=>'sub_kategori.id_sub = product.id_subkategori2');
		}
		$products = $this->access->readtable('product',$select,$where,$join,'','','LEFT','',$like,'')->result_array();
		
		if(!empty($products)){
			foreach($products as $p){
				$path = '';
				$path = !empty($p['img']) ? base_url('uploads/kategori/products/'.$p['img']) : base_url('uploads/no_photo.jpg');
				$dt[] = array(
					"id_product"		=> $p['id_product'],
					"id_kategori"		=> $p['id_kategori'],					
					"id_subcategory"	=> $p['id_subkategori'],					
					"nama_kategori"		=> $p['nama_kategori'],					
					"nama_subkategori"	=> $p['nama_sub'],					
					"nama_product"		=> $p['nama_product'],
					"harga"				=> $p['harga'] > 0 ? $p['harga'] : 0,
					"weight"			=> $p['weight'],
					"deskripsi"			=> $p['deskripsi'],
					"type_trans"		=> $p['type_trans'],
					"type_sample"		=> $p['type_sample'],
					"img"				=> $path
				);
				
			}
		}
		if(!empty($dt)){
			$res = array(
				'err_code' 	=> '00',
                'message' 	=> 'ok',
                'data' 		=> $dt,
			);
            $this->set_response($res, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $this->set_response([
                'err_code' => '04',
                'message' => 'Data not be found'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
	}
	
	
}
