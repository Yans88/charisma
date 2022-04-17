<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Verify extends CI_Controller{

	function __construct(){
		parent::__construct();
		$this->load->model('Access', 'access', true);
	}


	public function index(){
		$id	= $this->input->get('id');		
		$result	= array();
		if(!empty($id)){
			// $salt = base_convert(bin2hex($this->security->get_random_bytes(64)), 16, 36);
			// if ($salt === FALSE){
                // $salt = hash('sha256', time() . mt_rand());
            // }
			// $keys = substr($salt, 0, 64);
			// $key = $keys.''.$id;
			$id	= $this->converter->decode($id);	
			$data =array('status' => 1);
			$this->access->updatetable('members',$data, array("id_member" => $id));	
		}
		
		$this->load->view('themes/verify');
	}
	
}

?>