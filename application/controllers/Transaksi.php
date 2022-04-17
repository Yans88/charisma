<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Transaksi extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);		
			
	}	
	
	public function index() {			
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'List';		
		$this->data['load_data'] = site_url('transaksi/transaksi_data/1');		
		// $this->data['status'] = $this->access->readtable('members','',array('status'=>1))->result_array();
		$this->data['status'] = 1;	
		$this->data['isi'] = $this->load->view('transaksi/transaksi_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function appr() {			
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'List';		
		$this->data['load_data'] = site_url('transaksi/transaksi_data/2');		
		// $this->data['status'] = $this->access->readtable('members','',array('status'=>1))->result_array();
		$this->data['status'] = 2;	
		$this->data['isi'] = $this->load->view('transaksi/transaksi_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function dikirim() {			
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'List';		
		$this->data['load_data'] = site_url('transaksi/transaksi_data/4');		
		// $this->data['status'] = $this->access->readtable('members','',array('status'=>1))->result_array();
		$this->data['status'] = 4;	
		$this->data['isi'] = $this->load->view('transaksi/transaksi_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function reject() {			
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'List';		
		$this->data['load_data'] = site_url('transaksi/transaksi_data/3');		
		// $this->data['status'] = $this->access->readtable('members','',array('status'=>1))->result_array();
		$this->data['status'] = 3;	
		$this->data['isi'] = $this->load->view('transaksi/transaksi_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function bc() {			
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'List';	
		$this->data['load_data'] = site_url('transaksi/bc_data/1');	
		// $this->data['member'] = $this->access->readtable('members','',array('status'=>1))->result_array();	
		$this->data['status'] = 1;
		$this->data['isi'] = $this->load->view('transaksi/transaksi_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function bc_appr() {			
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'List';	
		$this->data['load_data'] = site_url('transaksi/bc_data/2');	
		// $this->data['member'] = $this->access->readtable('members','',array('status'=>1))->result_array();	
		$this->data['status'] = 2;
		$this->data['isi'] = $this->load->view('transaksi/transaksi_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function bc_reject() {			
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'List';	
		$this->data['load_data'] = site_url('transaksi/bc_data/3');	
		// $this->data['member'] = $this->access->readtable('members','',array('status'=>1))->result_array();	
		$this->data['status'] = 3;
		$this->data['isi'] = $this->load->view('transaksi/transaksi_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function bc_dikirim() {			
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'List';	
		$this->data['load_data'] = site_url('transaksi/bc_data/4');	
		// $this->data['member'] = $this->access->readtable('members','',array('status'=>1))->result_array();	
		$this->data['status'] = 4;
		$this->data['isi'] = $this->load->view('transaksi/transaksi_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function transaksi_data($status=0){
        $requestData= $_REQUEST;
		$select = array('transaksi.*','members.nama','admin.fullname');        
        $transaksi = array();
		$sort = array('id_transaksi','DESC');
		$where = array('type_transaksi'=>1,'transaksi.status'=>$status);	
        if(!empty($requestData['search']['value'])) {
			$search = $this->db->escape_str($requestData['search']['value']);
			$transaksi = $this->access->readtable('transaksi',$select,$where,array('members'=>'members.id_member = transaksi.id_member','admin'=>'admin.operator_id = transaksi.status_by'),'',$sort,'LEFT','',array('members.nama'=>$search), array('transaksi.id_transaksi'=>$search))->result_array();
		    $totalFiltered=count($transaksi);
		    $totalData=count($transaksi);
        }else{
			$transaksies = $this->access->readtable('transaksi',$select,$where,array('members'=>'members.id_member = transaksi.id_member','admin'=>'admin.operator_id = transaksi.status_by'),'',$sort,'LEFT')->result_array();
			$transaksi = $this->access->readtable('transaksi',$select,$where,array('members'=>'members.id_member = transaksi.id_member','admin'=>'admin.operator_id = transaksi.status_by'),array($requestData['length'],$requestData['start']),$sort,'LEFT')->result_array();
			
			$totalData = count($transaksies);
			$totalFiltered=count($transaksies);
        }

        $data = array();
        $nestedData=array();               
        $view_sub = '';
		$info = '';	
		$path = '';	
		$service_name = '';	
        if(!empty($transaksi)){
            $i=1;			
            foreach($transaksi as $t) {
				$nestedData=array();               
                $view_sub = '';
                $_alamat = '';
				$view_sub = site_url('transaksi/detail/'.$t['id_transaksi']);
				$no_invoice = '';
				$no_invoice = !empty($t['no_invoice']) ? $t['no_invoice'] : 'INV/'.date('Y/m/d', strtotime($t['created_at'])).'/'.$t['id_transaksi'];
				if($t['courir_service']  == 1){
					$service_name = 'JNE Reg';					
				}
				if($t['courir_service'] == 2){
					$service_name = 'JNE Express';					
				}
				if($t['courir_service'] == 3){
					$service_name = 'Pick Up Store';					
				}
				if(!empty($t['alamat'])){
					$_alamat = $t['alamat'].'<br/>'.$t['nama_kota'].','.$t['nama_provinsi'].' - '.$t['kode_pos'].'<br/>'.$service_name;
				}
				$info = $t['id_transaksi'];
				$nestedData[] = $i;
				$nestedData[] = '<a href="'.$view_sub .'" >'.$no_invoice.'</a>';
				$nestedData[] = $t['nama'];
				$nestedData[] = $_alamat;
				$nestedData[] = number_format($t['total'],2,',','.');
				if($t['status'] == 1){
				$nestedData[] = '<button title="Approve" class="btn btn-xs btn-success" id="'.$info.'" onclick="return appr_trans(this.id);"><i class="glyphicon glyphicon-ok"></i> Approve</button>
			<button title="Reject" onclick="return rej_trans('.$t['id_transaksi'].');" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i> Reject</button>';
				}
				if($t['status'] == 2){
					$nestedData[] = 'Approved by '.$t['fullname'].'<br/> on '.date('d-m-Y H:i', strtotime($t['status_date'])).'<br/><button title="Approve"  class="btn btn-xs btn-warning btn-block" id="'.$info.'" onclick="return send_trans(this.id);"><i class="glyphicon glyphicon-send"></i> &nbsp; Kirim</button>';
				}
				if($t['status'] == 3){
					$nestedData[] = 'Rejected by '.$t['fullname'].'<br/> on '.date('d-m-Y H:i', strtotime($t['status_date']));
				}
				if($t['status'] == 4){
					$nestedData[] = 'Dikirim oleh '.$t['fullname'].'<br/> on '.date('d-m-Y H:i', strtotime($t['status_date']));
				}
            
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
	
	function bc_data($status=0){
        $requestData= $_REQUEST;
		$select = array('transaksi.*','members.nama','admin.fullname');        
        $transaksi = array();
        $sort = array('id_transaksi','DESC');
		$where = array('type_transaksi'=>2,'transaksi.status'=>$status);	
        if(!empty($requestData['search']['value'])) {
			$search = $this->db->escape_str($requestData['search']['value']);
			$transaksi = $this->access->readtable('transaksi',$select,$where,array('members'=>'members.id_member = transaksi.id_member','admin'=>'admin.operator_id = transaksi.status_by'),'',$sort,'LEFT','',array('members.nama'=>$search), array('transaksi.id_transaksi'=>$search))->result_array();
		    $totalFiltered=count($transaksi);
		    $totalData=count($transaksi);
        }else{
			$transaksies = $this->access->readtable('transaksi',$select,$where,array('members'=>'members.id_member = transaksi.id_member','admin'=>'admin.operator_id = transaksi.status_by'),'',$sort,'LEFT')->result_array();
			$transaksi = $this->access->readtable('transaksi',$select,$where,array('members'=>'members.id_member = transaksi.id_member','admin'=>'admin.operator_id = transaksi.status_by'),array($requestData['length'],$requestData['start']),$sort,'LEFT')->result_array();
			
			$totalData = count($transaksies);
			$totalFiltered=count($transaksies);
        }
	
        $data = array();
        $nestedData=array();               
        $view_sub = '';
		$info = '';	
		$path = '';	
		$service_name = '';	
        if(!empty($transaksi)){
            $i=1;			
            foreach($transaksi as $t) {
				$nestedData=array();               
                $view_sub = '';
                $_alamat = '';
				$view_sub = site_url('transaksi/detail/'.$t['id_transaksi']);
				$no_invoice = '';
				$no_invoice = !empty($t['no_invoice']) ? $t['no_invoice'] : 'INV/'.date('Y/m/d', strtotime($t['created_at'])).'/'.$t['id_transaksi'];
				if($t['courir_service']  == 1){
					$service_name = 'JNE Reg';					
				}
				if($t['courir_service'] == 2){
					$service_name = 'JNE Express';					
				}
				if($t['courir_service'] == 3){
					$service_name = 'Pick Up Store';					
				}
				if(!empty($t['alamat'])){
					$_alamat = $t['alamat'].'<br/>'.$t['nama_kota'].','.$t['nama_provinsi'].' - '.$t['kode_pos'].'<br/>'.$service_name;
				}
				$info = $t['id_transaksi'];
				$nestedData[] = $i;
				$nestedData[] = '<a href="'.$view_sub .'" >'.$no_invoice.'</a>';
				$nestedData[] = $t['nama'];
				$nestedData[] = $_alamat;
				$nestedData[] = number_format($t['total'],2,',','.');
				if($t['status'] == 1){
				$nestedData[] = '<button title="Approve" class="btn btn-xs btn-success" id="'.$info.'" onclick="return appr_trans(this.id);"><i class="glyphicon glyphicon-ok"></i> Approve</button>
			<button title="Reject" onclick="return rej_trans('.$t['id_transaksi'].');" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-remove"></i> Reject</button>';
				}
				if($t['status'] == 2){
						$nestedData[] = 'Approved by '.$t['fullname'].'<br/> on '.date('d-m-Y H:i', strtotime($t['status_date'])).'<br/><button title="Approve"  class="btn btn-xs btn-warning btn-block" id="'.$info.'" onclick="return send_trans(this.id);"><i class="glyphicon glyphicon-send"></i> &nbsp; Kirim</button>';
				}
				if($t['status'] == 3){
					$nestedData[] = 'Rejected by '.$t['fullname'].'<br/> on '.date('d-m-Y H:i', strtotime($t['status_date']));
				}
				if($t['status'] == 4){
					$nestedData[] = 'Dikirim oleh '.$t['fullname'].'<br/> on '.date('d-m-Y H:i', strtotime($t['status_date']));
				}
            
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
	
	function detail($id=0){
		$this->data['judul_browser'] = 'Transaksi';
		$this->data['judul_utama'] = 'Transaksi';
		$this->data['judul_sub'] = 'Detail';	
		$select = array('transaksi.*','members.nama','admin.fullname'); 
		$this->data['transaksi'] = $this->access->readtable('transaksi',$select,array('transaksi.id_transaksi'=>$id),array('members'=>'members.id_member = transaksi.id_member','admin'=>'admin.operator_id = transaksi.status_by'),'','','LEFT')->row();
		$this->data['transaksi_detail'] = $this->access->readtable('transaksi_detail','',array('id_trans'=>$id))->result_array();
		$this->data['isi'] = $this->load->view('transaksi/transaksi_detail', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	
	function upd_trans(){
		$id = isset($_POST['id_transaksi']) ? $_POST['id_transaksi'] : 0;
		$status = isset($_POST['status']) ? $_POST['status'] : 0;
		$this->access->updatetable("transaksi",array("status"=>$status,"status_by"=>$this->session->userdata('operator_id'),"status_date"=>date('Y-m-d H:i:s')), array("id_transaksi"=>$id));
		if($status == 2){
			$transaksi = $this->access->readtable('transaksi','',array('transaksi.id_transaksi'=>$id))->row();
			$id_member = $transaksi->id_member;		
			$get_point = $transaksi->get_point;		
			$members = $this->access->readtable('members','',array('members.id_member'=>$id_member,'members.deleted_at'=>null))->row();
			$point = $members->total_point > 0 ? $members->total_point + $get_point : $get_point;
			$this->access->updatetable("members",array("total_point"=>$point),array("id_member"=>$id_member));
			$simpan_history = array(
					"id_member"			=> $id_member,
					"tgl"				=> date('Y-m-d H:i:s'),
					"id_tr"				=> $id,
					"type"				=> 1,
					"description"		=> "Add Points",
					"nilai"				=> (int)$get_point
				);
			$this->access->inserttable("point_history",$simpan_history);
		}	
		echo $id;
	}
	
	function save(){
		$this->load->model('Setting_m','sm',true);
		$rep_uang = array(".", ",", "-", "Rp", ";");
		$id_member = isset($_POST['member']) ? (int)$_POST['member'] : 0;
		$nama_product = isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '';
		$ttl = isset($_POST['amount']) ? $_POST['amount'] : '';
		$member = $this->access->readtable('members','',array('id_member'=>$id_member,'deleted_at'=>null))->row();
		$opsi_val_arr = $this->sm->get_key_val();
		foreach ($opsi_val_arr as $key => $value){
			$out[$key] = $value;
		}
		$setting_point = str_replace($rep_uang,'',$out['point']);
		$ttl = str_replace($rep_uang,'',$ttl);
		$get_point = $ttl / $setting_point;
		
		$this->db->trans_begin();
		$dt_post = array(
			'id_member'			=> $id_member,			
			'nilai_item'		=> $ttl,	
			'total'				=> $ttl,
			'get_point'			=> (int)$get_point,			
			'type_transaksi' 	=> (int)$member->type > 0 ? (int)$member->type : 2,
			'url_invoices'		=> '',
			"status"			=> 2,
			'status_by'			=> $this->session->userdata('operator_id'),
			'status_date'		=> date('Y-m-d H:i:s'),
			'created_at'		=> date('Y-m-d H:i:s')
		);
		$save = $this->access->inserttable('transaksi',$dt_post);
		error_log($this->db->last_query());
		$dt_products = array(
					'nama_product'	=> $nama_product,
					'ttl_item'		=> $ttl,
					'id_trans'		=> $save,
					'created_at'	=> date('Y-m-d H:i:s')
				);	
		$this->access->inserttable('transaksi_detail',$dt_products);
		$members = $this->access->readtable('members','',array('members.id_member'=>$id_member,'members.deleted_at'=>null))->row();
		$point = $members->total_point > 0 ? $members->total_point + $get_point : $get_point;
		$this->access->updatetable("members",array("total_point"=>$point),array("id_member"=>$id_member));
		$simpan_history = array(
				"id_member"			=> $id_member,
				"tgl"				=> date('Y-m-d H:i:s'),
				"id_tr"				=> $save,
				"type"				=> 1,
				"description"		=> "Add Points",
				"nilai"				=> $get_point
			);
		$this->access->inserttable("point_history",$simpan_history);
		$this->db->trans_commit();
		echo $save;
	}


}
