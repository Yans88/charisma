<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{

	public $data = array();

	public function __construct() {

		parent::__construct();
		

		if ($this->session->userdata('login') == FALSE) {
			redirect('/');
		} else {
			// $level = '';
			$this->data['u_name'] = $this->session->userdata('u_name');
			$this->data['_operator_id'] = $this->session->userdata('operator_id');
			$this->data['l_evel'] = $this->session->userdata('level_name');
			$this->data['isi'] = '';
			$this->data['judul_browser'] = '';
			$this->data['judul_utama'] = '';
			$this->data['judul_sub'] = '';
			$this->data['link_aktif'] = '';
			$this->data['css_files'] = array();
			$this->data['js_files'] = array();
			$this->data['js_files2'] = array();

		}
	}
}


