<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Transaksi extends REST_Controller {

    function __construct(){
        parent::__construct();
		$this->load->library('send_notif');
		$this->load->library('send_api');
		$this->load->model('Setting_m','sm',true);
		$this->load->model('Access','access',true);
    }

   
	function index_post(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		// $id_provinsi = isset($param['id_provinsi']) ? (int)$param['id_provinsi'] : 0;
		$id_city = isset($param['id_city']) ? (int)$param['id_city'] : 0;
		$courir_service = isset($param['courir_service']) ? (int)$param['courir_service'] : 0;
		$ongkir = isset($param['ongkir']) ? $param['ongkir'] : 0;
		$alamat = isset($param['alamat']) ? $param['alamat'] : '';
		$notes = isset($param['notes']) ? $param['notes'] : '';
		$items = isset($param['items']) ? json_decode($param['items']) : '';
		$rep_uang = array(".", ",", "-", "Rp", ";");
		$service_name = '';
		if($courir_service == 1){
			$service_name = 'JNE Reg';
		}
		
		if($courir_service == 2){
			$service_name = 'JNE Express';
		}
		
		if($courir_service == 3){
			$service_name = 'Pick Up Store';
		}
		
		$dt_post = array();
		$dt_product = array();
		$id_product = '';
		$id_variant = '';
		$quantity = '';
		$products = '';
		$ttl_item = 0;
		$ttl_weight = 0;
		$ttl_weights = 0;
		$ttl = 0;
		$total = 0;
		$harga = 0;
		$member = $this->access->readtable('members','',array('id_member'=>$id_member,'deleted_at'=>null))->row();
		$email = $member->email;
		$nama_member = $member->nama;
		$np = '';
		$pict = '';
		if(!empty($items)){
			for($i=0;$i<count($items);$i++){
				$id_product = $items[$i]->id_product;
				$id_variant = $items[$i]->id_variant;
				$quantity = (int)$items[$i]->quantity;
				$products = '';
				$select = array('product.*','product_variant.nama_variant','kategori.nama_kategori','sub_kategori.nama_sub');
				$products = $this->access->readtable('product_variant',$select,array('product_variant.id_variant'=>$id_variant, 'product_variant.id_product'=>$id_product, 'product_variant.deleted_at'=>null, 'product.deleted_at'=>null),array('product'=>'product.id_product =  product_variant.id_product','kategori'=>'kategori.id_kategori = product.id_kategori','sub_kategori'=>'sub_kategori.id_sub = product.id_subkategori'),'','','LEFT')->row();
				// error_log($this->db->last_query());
				// $dt_product = array();
				if(!empty($products)){				
					$ttl_weight = (int)$quantity * $products->weight;
					$harga = 0;
					if($products->crazy_sale == 'crazy_sale'){
						$harga = $products->harga_crazysale;
					}else{
						$harga = $products->harga;
					}
					if($i==0){
						$np = '';
						$pict = '';
						$np = $products->nama_product;
						$pict = $products->img;
					}
					$ttl_item = (int)$quantity * $harga;
					$dt_product[$i] = array(
						'id_product'		=> $products->id_product,
						'id_kategori'		=> $products->id_kategori,
						'id_subkategori'	=> $products->id_subkategori,
						'id_variant'		=> $id_variant,
						'type'				=> $products->crazy_sale,
						'nama_product'		=> $products->nama_product,
						'nama_kategori'		=> $products->nama_kategori,
						'nama_subkategori'	=> $products->nama_sub,
						'nama_variant'		=> $products->nama_variant,
						'img'				=> $products->img,
						'harga'				=> $harga,
						'weight'			=> $products->weight,
						'ttl_weight'		=> $ttl_weight,
						'quantity'			=> $quantity,						
						'ttl_item'			=> $ttl_item
											
					);					
					
					$ttl += $ttl_item;
					$ttl_weights += $ttl_weight;
				}else{
					$dt_product = array($items[$i]);
					$this->set_response([
						'err_code' 	=> '04',
						'message' 	=> 'Data product not found',
						'data'		=> $dt_product
					], REST_Controller::HTTP_OK);
					return false;
				}
			}
		}else{
			$this->set_response([
				'err_code' 	=> '03',
				'message' 	=> 'Items required',
				'data'		=> null
			], REST_Controller::HTTP_OK);
			return false;
		}
		
		$url = URL_ONGKIR.'city?id='.$id_city;
		$auth = KEY_ONGKIR;
		$provinces = $this->send_api->send_data($url, '', $auth,'', 'GET');
		$dt_provinces = json_decode($provinces);
		$dt_city = $dt_provinces->rajaongkir->results;
		$province_id = (int)$dt_city->province_id;
		$nama_provinsi = $dt_city->province;
		$nama_kota = $dt_city->city_name;
		$kode_pos = $dt_city->postal_code;
		$ongkir = str_replace($rep_uang,'',$ongkir);
		$no_invoice = date('Y/m/d');
		
		$opsi_val_arr = $this->sm->get_key_val();
		foreach ($opsi_val_arr as $key => $value){
			$out[$key] = $value;
		}
		$setting_point = str_replace($rep_uang,'',$out['point']);
		$get_point = $ttl / $setting_point;
		
		$members = '';
		$point = 0;
		$total = 0;
		$total = $ttl + $ongkir;
		$this->db->trans_begin();
		$dt_post = array(
			'id_member'			=> $id_member,
			'id_provinsi'		=> $province_id,
			'id_city'			=> $id_city,
			'kode_pos'			=> $kode_pos,
			'alamat'			=> $alamat,
			'courir_service'	=> $courir_service,
			'ongkir'			=> $ongkir,
			'notes'				=> $notes,
			'nama_provinsi'		=> $nama_provinsi,
			'nama_kota'			=> $nama_kota,
			'nilai_item'		=> $ttl,
			'total'				=> $total,
			'get_point'			=> (int)$get_point,
			'weight'			=> $ttl_weights,
			'type_transaksi' 	=> (int)$member->type > 0 ? (int)$member->type : 2,
			'url_invoices'		=> '',
			'np'				=> $np,
			'pict'				=> $pict,
			'created_at'		=> date('Y-m-d H:i:s')
		);
		$save = $this->access->inserttable('transaksi',$dt_post);
		$no_invoice = 'INV/'.$no_invoice.'/'.$save;
		$this->access->updatetable('transaksi', array('no_invoice' => $no_invoice), array('id_transaksi'=>$save));	
		$array1 = array();
		$array2 = array();
		$dt_products = array();
		$items = array();
		$_tbl = '';
		$_tbl ='<table border="1" cellpadding="1" cellspacing="1" style="width: 500px;">
	<tbody>
		<tr>
			<td>No</td>
			<td>Item</td>
			<td>Variant</td>
			<td>Type</td>
			<td>Harga</td>
			<td>Quantity</td>
			<td>Total</td>
		</tr>';
		if($save > 0 && count($dt_product) > 0){
			for($n=0; $n<count($dt_product); $n++){
				$no = 1 + $n;
				$array1 = array();
				$array2 = array();
				// $dt_products = array();
				$array1 = array('id_trans' => $save,'created_at' => date('Y-m-d H:i:s'));
				$array2 = $dt_product[$n];				
				$dt_products = $array2 + $array1;	
				$this->access->inserttable('transaksi_detail',$dt_products);
				$this->access->updatetable("product_variant",array("stok"=>999999999), array("id_product"=>$dt_products['id_product'], "id_variant"=>$dt_products['id_variant']));	
				unset($dt_products['created_at']);
				$items[] = array_merge($dt_products, array('img'=>base_url('uploads/kategori/products/'.$dt_products['img'])));
				$_tbl .='<tr>
					<td>'.$no.'</td>
					<td>'.$dt_product[$n]['nama_product'].'</td>
					<td>'.$dt_product[$n]['nama_variant'].'</td>
					<td>'.ucwords(str_replace('_', ' ',$dt_product[$n]['type'])).'</td>
					<td>'.number_format($dt_product[$n]['harga'],2,',','.').'</td> 
					<td>'.$dt_product[$n]['quantity'].'</td>
					<td>'.number_format($dt_product[$n]['ttl_item'],2,',','.').'</td>
				</tr>';
			}
			$dt_post += array('no_invoice'=>$no_invoice,'service_charisma'=>$service_name,'id_transaksi'=>$save,'items'=>$items);
			
			$this->db->trans_commit();
			$res = array(
				'err_code' 	=> '00',
                'message' 	=> 'Your transaction have been submited',
                'data' 		=> $dt_post
			);
			$opsi_val_arr = $this->sm->get_key_val();
			foreach ($opsi_val_arr as $key => $value){
				$out[$key] = $value;
			}
			
		
		$_tbl .='<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>Biaya Kirim</td>
			<td>'.number_format($ongkir,2,',','.').'</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>Total</td>
			<td>'.number_format($total,2,',','.').'</td>
		</tr>
	</tbody>
</table>';
// error_log($_tbl);
			$from = $out['email'];
			$pass = $out['pass'];
			$to = $email;
			$subject = 'New Order #'.$no_invoice;
			$content_member = $out['content_order_member'];
			$content = str_replace('[#name#]', $nama_member, $content_member);
			$content = str_replace('[#no_transaksi#]', $no_invoice, $content);
			$content = str_replace('[#total#]', number_format($total,0,',','.'), $content); 
			$content = str_replace('[#get_point#]', (int)$get_point, $content);
			$content = str_replace('[#item#]', $_tbl, $content);
			$this->send_notif->send_email($from,$pass, $to,$subject, $content, 1);
            $this->set_response($res, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		}else{
			$this->db->trans_rollback();
			$this->set_response([
                'err_code' => '04',
                'message' => 'Data not be found'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
		}	
		
	}
	
	function cek_ongkir_post(){
		$url = URL_ONGKIR.'cost';
		$auth = KEY_ONGKIR;		
		$param = $this->input->post();
		$id_city = isset($param['id_city']) ? (int)$param['id_city'] : 0;
		$weight = isset($param['weight']) ? str_replace('.','',$param['weight']) : 1000; 
		$dt_post = array(
			'origin'		=> 152,
			'destination'	=> $id_city,
			'weight'		=> (int)$weight,
			'courier'		=> 'jne'
		);
		$costs = '';
		$service_name = '';
		$service = '';
		$id_service = '';
		$cek_ongkirs = $this->send_api->send_data($url, $dt_post, $auth,'', 'POST');
		$cek_ongkir = json_decode($cek_ongkirs);		
		$dt = array();
		if(!empty($cek_ongkir->rajaongkir->results)){
			$costs = $cek_ongkir->rajaongkir->results[0]->costs;			
			foreach($costs as $pr){
				$service = '';
				$service_name = '';
				$id_service = '';
				$service = $pr->service;				
				if($service == 'CTC'){
					$service_name = 'JNE Reg';
					$id_service = 1;
				}
				if($service == 'CTCYES'){
					$service_name = 'JNE Express';
					$id_service = 2;
				}
				
				if($service == 'CTC' || $service == 'CTCYES'){					
					$dt[] = array(
						'service' 				=> $service,
						'id_service_charisma'	=> $id_service,
						'service_charisma'		=> $service_name,
						'biaya' 				=> $pr->cost[0]->value,
						'etd'					=> $pr->cost[0]->etd,
						'description'			=> $pr->description
					);
				}
			}
		}
		if (!empty($dt)){
			// error_log(serialize($dt));
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

	function province_get(){
		$url = URL_ONGKIR.'province';
		$auth = KEY_ONGKIR;
		$dt_provinces = '';
		$dt = array();
		$provinces = $this->send_api->send_data($url, '', $auth,'', 'GET');
		$dt_provinces = json_decode($provinces);
		if(!empty($dt_provinces->rajaongkir->results)){
			foreach($dt_provinces->rajaongkir->results as $pr){
				$dt[] = array('id_provinsi' => $pr->province_id, 'nama_provinsi' => $pr->province);
			}
		}
		if (!empty($dt)){
			// error_log(serialize($dt));
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
	
	function city_get(){
		$url = URL_ONGKIR.'city';
		$auth = KEY_ONGKIR;
		$province = (int)$this->input->get('province');
		if($province > 0){
			$url .='?province='.$province;
		}
		$dt_provinces = '';
		$dt = array();
		$provinces = $this->send_api->send_data($url, '', $auth,'', 'GET');
		$dt_provinces = json_decode($provinces);
		if(!empty($dt_provinces->rajaongkir->results)){
			foreach($dt_provinces->rajaongkir->results as $pr){
				$dt[] = array('id_provinsi'=>$pr->province_id,'id_city' => $pr->city_id, 'nama_city' => $pr->city_name,'type' => $pr->type, 'postal_code' => $pr->postal_code);
			}
		}
		if (!empty($dt)){
			// error_log(serialize($dt));
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
	
	function transaksi_history_post(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$status = isset($param['status']) ? (int)$param['status'] : 0;
		$sort = array('transaksi.id_transaksi','ASC');
		$select = array('transaksi.*');
		$where = array('transaksi.id_member'=>$id_member, 'transaksi.status'=>$status);
		$transaksi = $this->access->readtable('transaksi',$select, $where, array('members'=>'members.id_member =  transaksi.id_member'),'',$sort,'LEFT')->result_array();
		if(!empty($transaksi)){
			foreach($transaksi as $t){
			    $np = '';
				$pict = '';
				$np = $t['np'];
				$pict = base_url('uploads/kategori/products/'.$t['pict']);
				if(empty($t['np']) || empty($t['pict'])){
					$sort = array('id_trans_detail','ASC');
					$trans_detail = $this->access->readtable('transaksi_detail','', array('id_trans'=>$t['id_transaksi']), '','',$sort,'')->row();
					$np = $trans_detail->nama_product != '' ? $trans_detail->nama_product : '';
					$pict = $trans_detail->img != '' ? base_url('uploads/kategori/products/'.$trans_detail->img) : '';
				}
				$dt[] = array(
					'id_member'		=> $t['id_member'],
					'id_transaksi'	=> $t['id_transaksi'],
					'no_invoice'	=> !empty($t['no_invoice']) ? $t['no_invoice'] : 'INV/'.date('Y/m/d', strtotime($t['created_at'])).'/'.$t['id_transaksi'],
					'tgl'		=> date('d M Y', strtotime($t['created_at'])),
					'total'			=> $t['total'],
					'status'		=> $t['status'],
					'type_transaksi'		=> $t['type_transaksi'],
					'get_point'		=> (int)$t['get_point'],
					'nama_product'	=> $np,
					'img'			=> $pict
				);
			}
			$res = array(
				'err_code' 	=> '00',
                'message' 	=> 'ok',
                'data' 		=> $dt,
			);
			$this->set_response($res, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		}else{
			$this->set_response([
                'err_code' => '04',
                'message' => 'Data not found'
            ], REST_Controller::HTTP_OK);
		}
	}
	
	function transaksi_detail_post(){
		$param = $this->input->post();
		$id_transaksi = isset($param['id_transaksi']) ? (int)$param['id_transaksi'] : 0;
			
		$select = array('transaksi.*');
		$where = array('transaksi.id_transaksi'=>$id_transaksi);
		$transaksi = $this->access->readtable('transaksi',$select, $where, array('members'=>'members.id_member =  transaksi.id_member'),'','','LEFT')->row();
		$service_name = '';
		$nama_status = '';
		$list_item = array();
		if(!empty($transaksi)){
			if($transaksi->courir_service  == 1){
				$service_name = 'JNE Reg';					
			}
			if($transaksi->courir_service == 2){
				$service_name = 'JNE Express';					
			}
			if($transaksi->courir_service == 3){
				$service_name = 'Pick Up Store';					
			}
			if($transaksi->status == 1){
				$nama_status = 'Waiting';
			}
			if($transaksi->status == 2){
				$nama_status = 'Approve';
			}
			if($transaksi->status == 3){
				$nama_status = 'Reject';
			}
			if($transaksi->status == 4){
				$nama_status = 'Dikirimkan';
			}
			$trans_detail = $this->access->readtable('transaksi_detail','', array('id_trans'=>$id_transaksi), '','','','')->result_array();
			if(!empty($trans_detail)){
				$pict = '';
				foreach($trans_detail as $td){
					$pict = $td['img'] != '' ? base_url('uploads/kategori/products/'.$td['img']) : '';
					$list_item[] = array(
						'nama_product'	=> $td['nama_product'],
						'kategori'		=> $td['nama_kategori'],
						'subkategori'	=> $td['nama_subkategori'],
						'variant'		=> $td['nama_variant'],
						'harga'			=> $td['harga'],
						'jml'			=> $td['quantity'],
						'weight'		=> $td['weight'],
						'img'			=> $pict
					);
				}
			}
			$dt = array(
				'id_member'			=> $transaksi->id_member,
				'id_transaksi'		=> $transaksi->id_transaksi,
				'no_invoice'		=> !empty($transaksi->no_invoice) ? $transaksi->no_invoice : 'INV/'.date('Y/m/d', strtotime($transaksi->created_at)).'/'.$transaksi->id_transaksi,
				'tgl'				=> date('d M Y H:i', strtotime($transaksi->created_at)),
				'total'				=> $transaksi->total,
				'status'			=> $transaksi->status,
				'type_transaksi'			=> $transaksi->type_transaksi,
				'nama_status'		=> $nama_status,
				'courir_service'	=> $service_name,
				'alamat'			=> $transaksi->alamat,
				'kota'				=> $transaksi->nama_kota,
				'provinsi'			=> $transaksi->nama_provinsi,
				'list_item'			=> $list_item
			);
			
			$res = array(
				'err_code' 	=> '00',
                'message' 	=> 'ok',
                'data' 		=> $dt,
			);
			$this->set_response($res, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
		}else{
			$this->set_response([
                'err_code' => '04',
                'message' => 'Data not found'
            ], REST_Controller::HTTP_OK);
		}
	}
	
	function inquiry_sample_post(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$type_request = isset($param['type_request']) ? (int)$param['type_request'] : 0;
		$id_product = isset($param['id_product']) ? (int)$param['id_product'] : 0;
		$product = $this->access->readtable('product','',array('id_product'=>$id_product,'deleted_at'=>null))->row();
		$nama_product = $product->nama_product;
		$member = $this->access->readtable('members','',array('id_member'=>$id_member,'deleted_at'=>null))->row();
		$email = $member->email;
		$nama_member = $member->nama;
		$save = 0;
		$dt_post = array(
			'id_member'			=> $id_member,
			'type_is'			=> $type_request,
			'id_product'		=> $id_product,
			'nama_product'		=> $nama_product,
			'status'			=> 1,
			'created_at'		=> date('Y-m-d H:i:s')
		);
		$save = $this->access->inserttable('inquiry_sample',$dt_post);
		$opsi_val_arr = $this->sm->get_key_val();
		foreach ($opsi_val_arr as $key => $value){
			$out[$key] = $value;
		}
	
		$from = $out['email'];
		$pass = $out['pass'];
		$to = $email;
		$_type = '';
		if($type_request == 1){
			$_type = 'Request Sample';
		}
		if($type_request == 2){
			$_type = 'Inquiry';
		}
		$subject = $_type;
		$content_member = $out['content_request_sample'];
		$content = str_replace('[#name#]', $nama_member, $content_member);
		$content = str_replace('[#nama_brg#]', $nama_product, $content);
		$content = str_replace('[#type#]', $_type, $content); 
		$this->send_notif->send_email($from,$pass, $to,$subject, $content, 1);
		if($save > 0){
			$this->set_response([
				'err_code' => '00',
				'message' => 'Your Request have been submited'
			], REST_Controller::HTTP_OK);
		}else{
			$this->set_response([
				'err_code' => '03',
				'message' => 'insert has problem'
			], REST_Controller::HTTP_OK);
		}
	}
	
}