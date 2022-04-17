<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Redeem extends REST_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Access','access',true);
    }

    public function index_get(){
		$id = $this->get('id');
		$id = (int)$id;
		if($id > 0){
			$product = $this->access->readtable('product_redeem','',array('id_product'=>$id,'deleted_at'=>null))->result_array();
		}else{
			$product = $this->access->readtable('product_redeem','',array('deleted_at'=>null))->result_array();
		}
		$dt = array();
		
		if(!empty($product)){
			foreach($product as $p){
				
				$dt[] = array(
					"id_product"		=> $p['id_product'],
					"nama_produk"		=> $p['nama_barang'],
					"img"				=> !empty($p['img']) ? base_url('uploads/products/'.$p['img']): '',
					"point"				=> $p['point']
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
	
	function index_post(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$id_product = isset($param['id_product']) ? (int)$param['id_product'] : 0;
		$point = isset($param['point']) ? (int)$param['point'] : 0;
		
		$hp = isset($param['hp']) ? $param['hp'] : '';
		$msg = '';
		$err_code = '';
		
		$cnt_member = 1;
		$member = $this->access->readtable('members','',array('id_member'=>$id_member,'deleted_at'=>null))->row();
		
		$tgl = date('Y-m-d');
		if($cnt_member > 0){
			$point_redeem = $member->total_point > 0 ? $member->total_point : 0;
			if($point_redeem < $point){
				$err_code = '03';
				$msg = 'Point tidak cukup';
			}else{
				
				$sisa_point = $point_redeem - $point;
				$ttl_redeem = $member->total_redeem + $point;
				$update_member = array(
					"total_point" => $sisa_point,
					"total_redeem" => $ttl_redeem
				);

				$simpan_redeem = array(
					"id_member"		=> $id_member,
					"id_product"	=> $id_product,
					"point"			=> $point,
					"redeem_point"	=> $point_redeem,
					"tgl"			=> date('Y-m-d H:i:s'),
					"status"		=> 1,
					"sisa_point"	=> $sisa_point,
					"hp_redeem"		=> $hp	
				);
				$save = $this->access->inserttable("redeem",$simpan_redeem);
				$simpan_history = array(
					"id_member"			=> $id_member,
					"tgl"				=> $tgl,
					"id_tr"				=> $save,
					"type"				=> 2,
					"description"		=> "Redeem Points",
					"nilai"				=> '-'.$point
				);
				$this->access->inserttable("point_history",$simpan_history);
				$this->access->updatetable('members',$update_member, array("id_member"=>$id_member));
				$err_code = '00';
				$msg = 'OK';
			}
		}else{
			$err_code = '04';
			$msg = 'Nomor Hp tidak sesuai';
		}
		$this->set_response([
        	'err_code' => $err_code,
          	'message' => $msg
		], REST_Controller::HTTP_OK);
	}
	
}
