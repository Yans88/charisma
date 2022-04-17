<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class Member extends REST_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Access','access',true);
		$this->load->model('Setting_m','sm', true);
		$this->load->library('converter');
    }

    public function index_get(){
		$id = $this->get('id');
		$id = (int)$id;
		if($id > 0){
			$member = $this->access->readtable('members','',array('id_member'=>$id,'deleted_at'=>null))->result_array();
		}else{
			$member = $this->access->readtable('members','',array('deleted_at'=>null))->result_array();
		}
		$dt = array();
		$_type = '';
		$m_chat = '';
		if(!empty($member)){
			foreach($member as $e){
				$_type = '';
				if($e['type'] == 1){
					$_type = 'B to B';
				}
				if($e['type'] == 2){
					$_type = 'B to C';
				}
				if($id > 0){
					$m_chat = $this->access->readtable('master_chat','',array('id_member'=>$id))->row();
					$dt = array(
						"id_member"			=> $e['id_member'],
						"nama"				=> $e['nama'],
						"dob"				=> date("d-m-Y", strtotime($e['dob'])),
						"email"				=> $e['email'],
						"phone"				=> $e['phone'],					
						"alamat"			=> $e['address'],										
						"type"				=> $e['type'],
						"type_name"			=> $_type,
						"current_pass"		=> $this->converter->decode($e['pass']),
						"photo"				=> !empty($e['photo']) ? $e['photo'] : null,					
						"total_point"		=> $e['total_point'] > 0 ? $e['total_point'] : '0',
						"total_redeemed"	=> $e['total_redeem'] > 0 ? $e['total_redeem'] : '0',
						"unread"			=> (int)$m_chat->status_member > 0 ? (int)$m_chat->status_member : 0,
						"tgl_reg"			=> date('d-M-Y', strtotime($e['tgl_reg']))
						
					);
				}else{					
					$dt[] = array(
						"id_member"			=> $e['id_member'],
						"nama"				=> $e['nama'],
						"dob"				=> date("d-m-Y", strtotime($e['dob'])),
						"email"				=> $e['email'],
						"phone"				=> $e['phone'],					
						"alamat"			=> $e['address'],										
						"type"				=> $e['type'],
						"type_name"			=> $_type,
						"current_pass"		=> $this->converter->decode($e['pass']),
						"photo"				=> !empty($e['photo']) ? $e['photo'] : null,					
						"total_point"		=> $e['total_point'] > 0 ? (int)$e['total_point'] : '0',
						"total_redeemed"	=> $e['total_redeem'] > 0 ? $e['total_redeem'] : '0',
						"tgl_reg"			=> date('d-M-Y', strtotime($e['tgl_reg']))
						
					);
				}
			}
		}
		// error_log(serialize($dt));
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

	public function reg_post(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
		$nama_member = isset($param['nama_member']) ? $param['nama_member'] : '';
		$gcm_token = isset($param['gcm_token']) ? $param['gcm_token'] : '';
		
		$password = isset($param['password']) ? $this->converter->encode($param['password']) : '';
		$email = isset($param['email']) ? $param['email'] : '';
    	$dob = isset($param['dob']) ? date('Y-m-d', strtotime($param['dob'])) : '';
    	$type = isset($param['type']) ? (int)$param['type'] : 1;
		
		
		$alamat = isset($param['alamat']) ? $param['alamat'] : '';
		
		$phone = isset($param['phone']) ? $param['phone'] : '';
		$tgl_reg = date('Y-m-d H:i:s');
		
		$pertanyaan1 = isset($param['pertanyaan1']) ? $param['pertanyaan1'] : '';
		$pertanyaan2 = isset($param['pertanyaan2']) ? $param['pertanyaan2'] : '';
		$produk_biasa_dipakai = isset($param['produk_biasa_dipakai']) ? $param['produk_biasa_dipakai'] : '';
		$bergerak_dibidang = isset($param['bergerak_dibidang']) ? $param['bergerak_dibidang'] : '';
		
		$photo = isset($param['photo']) ? $param['photo'] : '';
		$upl = '';
		$upload = array();
		$config['upload_path'] = "./uploads/member/";
		$config['allowed_types'] = "jpg|png|jpeg|";
		$config['max_size']	= '1048';
		$name = $_FILES['photo']['name'];
		$config['file_name'] = date('YmdHis').$name;
		$config['encrypt_name'] = TRUE;
		$this->load->library('upload',$config);
		$chk_email = $this->access->readtable('members','',array('email'=>$email,'deleted_at'=>null))->row();
		$ketemu = count($chk_email);
		$login = '';
		$data = array();
		$lang = 'Bahasa';
		$details = '';
		$message = '';
		if($ketemu > 0 && ($id_member == '' || $id_member == 0)){
			$this->set_response([
                'err_code' => '04',
                'message' => 'Email already exist'
            ], REST_Controller::HTTP_OK);
		}else{
			$simpan = array(
				"nama"     	=> $nama_member,
				"dob"		=> $dob,				
				"email"	   	=> $email,
				"address"	=> $alamat,
				"phone"		=> $phone,
				
			);
			
			$save = 0;
			if($id_member == 0 || $id_member ==  ''){
				if(empty($password)){
					$this->set_response([
						'err_code' => '05',
						'message' => 'Password is required'
					], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
					return false;
				}
			}
			if(!empty($password)){
				$simpan += array("pass"	=> $password);
			}

			if(!empty($_FILES['photo'])){
				if($this->upload->do_upload('photo')){
					$upl = $this->upload->data();
					$simpan += array("photo"	=> base_url('uploads/member/'.$upl['file_name']));
				}
			}

			if($id_member > 0){
				$message = 'Profile updated';
				$this->access->updatetable('members',$simpan, array("id_member"=>$id_member));
				$save = $id_member;
				$login = $this->access->readtable('members','',array('id_member'=>$save))->row();
			}else{
				$message = 'Ok';
				$simpan +=array(
						"tgl_reg" 				=> $tgl_reg,
						"type"					=> $type,
						"pertanyaan1"			=> $pertanyaan1,
						"pertanyaan2"			=> $pertanyaan2,
						"produk_biasa_dipakai"	=> $produk_biasa_dipakai,
						"bergerak_dibidang"		=> $bergerak_dibidang
					);
				$save = $this->access->inserttable('members',$simpan);
				$opsi_val_arr = $this->sm->get_key_val();
				foreach ($opsi_val_arr as $key => $value){
					$out[$key] = $value;
				}
	
				$this->load->library('send_notif');
				$from = $out['email'];
				$pass = $out['pass'];
				$to = $email;
				$subject = $out['subj_email_register'];
				$content_member = $out['content_verifyReg'];
				$content = str_replace('[#name#]', $nama_member, $content_member);
				$_type = '';
				if($save && !empty($type)){		
					
					$login = $this->access->readtable('members','',array('id_member'=>$save))->row();
					
				}
				if($save){
					$id = $this->converter->encode($save);
					$link = VERIFY_REGISTER_LINK.'='.$id;
					$href = '<a href="'.$link.'">'.$link.'</a>';
					$content = str_replace('[#verify_link#]', $href, $content);
					$this->send_notif->send_email($from,$pass, $to,$subject, $content);
				}
			}
			
			if(!empty($login)){
				$_type = '';
				if($login->type == 1){
					$_type = 'B to B';
				}
				if($login->type == 2){
					$_type = 'B to C';
				}
				$details = [
					"id_member"			=> $login->id_member,
					"nama"				=> $login->nama,
					"dob"   			=> date("d-m-Y", strtotime($login->dob)),
					"email"				=> $login->email,
					"phone"				=> $login->phone,							
					"alamat"			=> $login->address,							
					"type"				=> $login->type,
					"total_point"		=> (int)$login->total_point,
							
					"type_name"			=> $_type,
					"current_pass"		=> $this->converter->decode($login->pass),
					"photo"				=> !empty($login->photo) ? $login->photo : null,
					"bergerak_dibidang"				=> $login->bergerak_dibidang,
					"produk_biasa_dipakai"				=> $login->produk_biasa_dipakai,
					"tgl_reg"			=> date('d-M-Y', strtotime($login->tgl_reg))
							
				];
			}
			
			if($save){
				$this->set_response([
					'err_code' => '00',
					'message' => $message,
					'data' => $details
				], REST_Controller::HTTP_OK);
			}else{
				$this->set_response([
					'err_code' => '03',
					'message' => 'Insert has problem'
				], REST_Controller::HTTP_OK);
			}
		}
	}

	function login_post(){
		$result = array();
		$login = '';
		$param = $this->input->post();
		$email = isset($param['email']) ? $param['email'] : '';
		$password = isset($param['password']) ? $this->converter->encode($param['password']) : '';
		if(!empty($email) && !empty($password)){
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$result = [
					'err_code'	=> '06',
					'err_msg'	=> 'Email invalid format'
				];
				$this->set_response($result, REST_Controller::HTTP_OK);
				return false;
			}else{
				$login = $this->access->readtable('members','',array('email'=>$email,'pass'=>$password,'deleted_at'=>null))->row();

			}
		}else{
			$result = array( 'err_code'	=> '01',
                             'err_msg'	=> 'Param Email or Password can\'t empty.' );
			$this->set_response($result, REST_Controller::HTTP_OK);
			return false;
		}
		$_type = '';
		if(!empty($login)){
			if($login->status > 0){
				$_type = '';
				if($login->type == 1){
					$_type = 'B to B';
				}
				if($login->type == 2){
					$_type = 'B to C';
				}
				$details = [
					"id_member"			=> $login->id_member,
					"nama"				=> $login->nama,
					"dob"   			=> date("d-m-Y", strtotime($login->dob)),
					"email"				=> $login->email,
					"phone"				=> $login->phone,					
					"alamat"			=> $login->address,
					"total_point"		=> $login->total_point,	
					"type"				=> $login->type,
					"type_name"			=> $_type,
					"total_point"		=> (int)$login->total_point,
					"current_pass"		=> $this->converter->decode($password),
					"photo"				=> !empty($login->photo) ? $login->photo : null,
					"bergerak_dibidang"				=> $login->bergerak_dibidang,
					"produk_biasa_dipakai"				=> $login->produk_biasa_dipakai,
					"tgl_reg"			=> date('d-M-Y', strtotime($login->tgl_reg))					
				];
				$result = [
					'err_code'		=> '00',
					'err_msg'		=> 'OK',
					'data'	=> $details
				];
			}else{
				$result = [
					'err_code'		=> '06',
					'err_msg'		=> 'Account unverified'
				];
			}
			$this->set_response($result, REST_Controller::HTTP_OK);
		}else{
			$result = [
					'err_code'	=> '04',
					'err_msg'	=> 'Login failed'
				];
			$this->set_response($result, REST_Controller::HTTP_OK);
		}

	}
	
	function point_history_post(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? $param['id_member'] : '';
		$id_member= (int)$id_member;
		$filter_by = isset($param['filter_by']) ? (int)$param['filter_by'] : 0;
		$point_history = array();
		$where = array();
		if($id_member > 0){
			$where += array('id_member'=>$id_member);	
		}
		$now = date('Y-m-d');
		$date = new DateTime($now);
		$last_date = '';
		
		if($filter_by == 1){
			$where += array('tgl'=>$now);	
		}
		if($filter_by == 2){
			$date->modify('-7 day');
			$last_date = $date->format('Y-m-d');
			$where += array('tgl >='=>$last_date, 'tgl <= '=>$now);	
		}
		if($filter_by == 3){
			$date->modify('-1 month');
			$last_date = $date->format('Y-m-d');
			$where += array('tgl >='=>$last_date, 'tgl <= '=>$now);	
		}
		if($filter_by == 4){
			$date->modify('-3 month');
			$last_date = $date->format('Y-m-d');
			$where += array('tgl >='=>$last_date, 'tgl <= '=>$now);	
		}
		if($filter_by == 5){
			$date->modify('-6 month');
			$last_date = $date->format('Y-m-d');
			$where += array('tgl >='=>$last_date, 'tgl <= '=>$now);	
		}
		$point_history = $this->access->readtable('point_history','',$where)->result_array();
		
		$dt = array();
		$date_point = '';
		$type = '';
		if(!empty($point_history)){
			foreach($point_history as $ph){
				$date_point = '';
				$date_point = date("d/m/y", strtotime($ph['tgl']));
				if($ph['type'] == 1){
					$type = 'point';
				}
				if($ph['type'] == 2){
					$type = 'redeem';
				}
				$dt[] = array(
					"id_member"			=> $ph['id_member'],
					"description"		=> ucwords($ph['description']),
					"type"				=> $type,
					"tgl"				=> $date_point,
					"point"				=> (int)$ph['nilai'].' Points'
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

	function forgot_post(){

		$result = array();
		$nama = '';
		$new_pass = '';
		$save = 0;
		$param = $this->input->post();
		$email = isset($param['email']) ? $param['email'] : '';

		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$result = [
				'err_code'	=> '06',
				'err_msg'	=> 'Email invalid format'
			];
			$this->set_response($result, REST_Controller::HTTP_OK);
			return false;
		}
		$chk_email = $this->access->readtable('members','',array('email'=>$email,'deleted_at'=>null))->row();
		$ketemu = count($chk_email);
		if($ketemu > 0){
			$new_pass = $this->converter->random(8);
			$data = array("pass" => $this->converter->encode($new_pass));
			$this->access->updatetable('members',$data, array("id_member" => $chk_email->id_member));
			$save = $email;
		}else{
			$result = [
				'err_code'	=> '07',
				'err_msg'	=> 'Email Not Registered'
			];
			$this->set_response($result, REST_Controller::HTTP_OK);
			return false;
		}

		if($save == $email){

			$opsi_val_arr = $this->sm->get_key_val();
			foreach ($opsi_val_arr as $key => $value){
				$out[$key] = $value;
			}

			$nama = $chk_email->nama;

			// $this->load->library('email');
			$this->load->library('send_notif');
			$from = $out['email'];
			$pass = $out['pass'];
			$to = $email;
			$subject = $out['subj_email_forgot'];
			$content_member = $out['content_forgotPass'];

			$content = str_replace('[#name#]', $nama, $content_member);
			$content = str_replace('[#new_pass#]', $new_pass, $content);
			$content = str_replace('[#email#]', $email, $content);

			$result = [
				'err_code'	=> '00',
				'err_msg'	=> 'OK, New password was send to your email'
			];
			$this->send_notif->send_email($from,$pass, $to,$subject, $content);
			$this->set_response($result, REST_Controller::HTTP_OK);
		}else{

			$result = [
				'err_code'	=> '05',
				'err_msg'	=> 'Insert has problem'
			];
			$this->set_response($result, REST_Controller::HTTP_INTERNAL_SERVER_ERROR);

		}

	}

	
	function chat_post(){
		$param = $this->input->post();
		$user_id_form = isset($param['user_id_member']) ? (int)$param['user_id_member'] : 0;
		$user_id_to = 'admin';
		$content = isset($param['content']) ? $param['content'] : '';
		$datas = array();
		$master_chat = '';
		$members = $this->access->readtable('members','',array('members.id_member'=>$user_id_form))->row();
		
		$master_chat = $this->access->readtable('master_chat','',array('id_member'=>$user_id_form))->row();
		$id_chat = !empty($master_chat) ? (int)$master_chat->id_chat : 0;
		if($id_chat > 0){
			$datas = array('content'=>$content,'status_count'=>1);
			$this->access->updatetable('master_chat', $datas, array('id_chat'=>$master_chat->id_chat));
			$id_chat = $master_chat->id_chat;
		}else{
			$datas = array('id_member'=>$user_id_form,'content'=>$content,'status_count'=>1);
			$save_chat = $this->access->inserttable('master_chat', $datas);
			$id_chat = $save_chat;
		}
		
		$data = array(	
			'user_id_from'	=> $user_id_form,
			'user_id_to'	=> $user_id_to,
			'content'		=> $content,
			'date_create'	=> date('Y-m-d H:i:s'),				
			'dari'			=> $members->nama,
			'ke'			=> 'Admin',
			'status'		=> 1,
			'id_chat'		=> $id_chat			
		);
		$save = $this->access->inserttable('messages', $data);
		if($save){
			$this->set_response([
				'err_code' => '00',
				'message' => 'Ok'
			], REST_Controller::HTTP_OK);
		}else{
			$this->set_response([
				'err_code' => '03',
				'message' => 'Insert has problem'
			], REST_Controller::HTTP_OK);
		}
	}
	
	
	
	function list_chat_detail_post(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;
				
		$m_chat = $this->access->readtable('master_chat','',array('id_member'=>$id_member))->row();		
		$datas = array();
		$members = '';
		$merchants = '';		
		$chats = $this->access->readtable('messages','',array('id_chat'=>$m_chat->id_chat))->result_array();		
		if(!empty($chats)){
			foreach($chats as $c){			
				$dt[] = array(
					'user_id_from'	=> $c['user_id_from'],
					'user_id_to'	=> $c['user_id_to'],
					'dari'			=> $c['dari'],
					'ke'			=> $c['ke'],
					'content'		=> $c['content'],
					'chat_dari'		=> 'Admin',
					'unread'		=> (int)$m_chat->status_member > 0 ? (int)$m_chat->status_member : 0,
					'tgl'			=> date('d-m-Y H:i', strtotime($c['date_create']))
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
	
	function unread_post(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;		
		$datas = array('status_member'=>0);
		$this->access->updatetable('master_chat', $datas, array('id_member'=>$id_member));
		$res = array(
				'err_code' 	=> '00',
                'message' 	=> 'ok'
		);
        $this->set_response($res, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
	}
	
	function status_unread_post(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;		
		$m_chat = $this->access->readtable('master_chat','',array('id_member'=>$id_member))->row();	
		$res = array(
				'err_code' 	=> '00',
                'message' 	=> 'ok',
				'data'		=> array('unread' => (int)$m_chat->status_member > 0 ? (int)$m_chat->status_member : 0)
		);
        $this->set_response($res, REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
	}
	
	public function upd_account_post(){
		$param = $this->input->post();
		$id_member = isset($param['id_member']) ? (int)$param['id_member'] : 0;		
    	$type = isset($param['type']) ? (int)$param['type'] : 1;
		$pertanyaan1 = isset($param['pertanyaan1']) ? $param['pertanyaan1'] : '';
		$pertanyaan2 = isset($param['pertanyaan2']) ? $param['pertanyaan2'] : '';
		$produk_biasa_dipakai = isset($param['produk_biasa_dipakai']) ? $param['produk_biasa_dipakai'] : '';
		$bergerak_dibidang = isset($param['bergerak_dibidang']) ? $param['bergerak_dibidang'] : '';
		$save = 0;	
		$simpan = array(			
			"type"					=> $type,
			"pertanyaan1"			=> $pertanyaan1,
			"pertanyaan2"			=> $pertanyaan2,
			"produk_biasa_dipakai"	=> $produk_biasa_dipakai,
			"bergerak_dibidang"		=> $bergerak_dibidang
		);
		$this->access->updatetable('members',$simpan, array("id_member"=>$id_member));
		$save = $id_member;
		

		if($save){
			$this->set_response([
				'err_code' => '00',
				'message' => 'Ok'
			], REST_Controller::HTTP_OK);
		}else{
			$this->set_response([
				'err_code' => '03',
				'message' => 'Insert has problem'
			], REST_Controller::HTTP_OK);
		}		
	}

}
