<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Master extends REST_Controller {

    function __construct(){        
        parent::__construct();	
		$this->load->library('send_notif');	
		$this->load->model('Api_m');	
		$this->load->model('Access','access',true);		
    }	
    
	public function info_rek_get(){
		$contact = $this->Api_m->get_key_val();
		error_log(serialize($contact));
		$info_rek = isset($contact['info_rek']) ? $contact['info_rek'] : '';	
		$res = array();	
		if(!empty($info_rek)){
			$tc = [
					'info_rek' 	=> $info_rek
			];
			$res = array(
				'err_code' 	=> '00',
                'message' 	=> 'ok',
                'data' 		=> $tc,
			);
			$this->set_response($res, REST_Controller::HTTP_OK);
		}else{
			$this->set_response([
                'err_code' => '04',
                'message' => 'Data not be found'
            ], REST_Controller::HTTP_OK);
		}
	}
	
	
	
	public function ecatalogue_get($id=0) {
		if($id > 0){
		}
		$select = array('e_catalogue.*','kat_catalogue.nama_kategori');
		$catalogue = $this->access->readtable('e_catalogue',$select,array('e_catalogue.deleted_at'=> null,'e_catalogue.id_kat'=>$id),array('kat_catalogue' => 'kat_catalogue.id_kat = e_catalogue.id_kat'),'','','LEFT')->result_array();
		
		if(!empty($catalogue)){
			foreach($catalogue as $c){
				$dt[] = array(
					"id_catalogue"	=> $c['id_catalogue'],
					"id_kategori"	=> $c['id_kat'],
					"kategori"		=> $c['nama_kategori'],
					"judul"			=> $c['judul'],
					"nama_file"		=> $c['nama_file'],
					"file_attach"	=> $c['file_attach']
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
	
	public function download_get($id=0) {
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
	
	public function pabrik_get() {
		$pabrik = $this->access->readtable('outlet_pabrik','',array('deleted_at'=>null,'type'=>2))->result_array();
		
		
		if(!empty($pabrik)){
			foreach($pabrik as $p){
				$img = '';
				$img = $this->access->readtable('pabrik_img','',array('deleted_at'=>null,'id_pabrik'=>$p['id_op']))->result_array();
				$_img = array();
				if(!empty($img)){
					foreach($img as $im){
						array_push($_img, base_url('uploads/pabrik/'.$im['img']));
					}
				}
				$dt[] = array(
					"id_pabrik"	=> $p['id_op'],
					"judul"		=> $p['deskripsi'],
					"img"		=> $_img
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
	
	public function outlet_get() {
		$pabrik = $this->access->readtable('outlet_pabrik','',array('deleted_at'=>null,'type'=>1))->result_array();
		
		if(!empty($pabrik)){
			foreach($pabrik as $p){
				$dt[] = array(
					"id_pabrik"	=> $p['id_op'],
					"judul"		=> $p['deskripsi'],
					"longitude"	=> $p['longitude'],
					"latitude"	=> $p['latitude']
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
