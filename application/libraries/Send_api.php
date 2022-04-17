<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Send_api

{
	protected 	$ci;
	public function __construct() {		
		$this->ci =& get_instance();
	}
	
	
	function send_data($url= '', $data=array(), $auth='', $_id='', $method='POST'){
		
		$fields = array();
		$headers = array(
			"Content-Type:application/json",
			"Authorization:$auth",
			"key:$auth",
			"ID:$_id"
		);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		//error_log(serialize($headers));
		$result = curl_exec($ch);
		if ($result === FALSE) {
			die('Send Error: ' . curl_error($ch));
		}
		curl_close($ch);
		
		return $result;
	}	
	
	function post_data($url= '', $data=array()){
		
		$fields = array();
		$headers = array(
			"cache-control: no-cache",
    		"content-type: multipart/form-data;"
		);
				
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		
		$result = curl_exec($ch);
		if ($result === FALSE) {
			die('Post Error: ' . curl_error($ch));
		}
		curl_close($ch);
		return $result;
	}	
	
	
	
}

?>