<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access','access',true);
	}	
	
	public function members() {
		$member = $this->access->readtable('members','',array('members.deleted_at'=>null,'status'=>1,'token'=>null),'',20)->result_array();
		$ql = $this->db->last_query();
		if(!empty($member)){
			foreach($member as $m){
				$salt = base_convert(bin2hex($this->security->get_random_bytes(64)), 16, 36);
				if ($salt === FALSE){
					$salt = hash('sha256', time() . mt_rand());
				}
				$keys = substr($salt, 0, 64);
				$key = $keys.''.$this->converter->encode($m['id_member']);
				$data =array('token'=>$key);
				$this->access->updatetable('members',$data, array("id_member" => $m['id_member']));	
			}
			echo 'Silahkan direload lagi <br/>';
		}else{
			echo 'Semua sudah di update <br/>';
			echo $ql;
		}
	}
	
	public function merchants() {
		$merchants = $this->access->readtable('merchants','',array('merchants.deleted_at'=>null,'token'=>null),'',20)->result_array();
		$data_simpan = array();
		$_merchants = '';
		if(!empty($merchants)){
			foreach($merchants as $m){
				$salt = base_convert(bin2hex($this->security->get_random_bytes(64)), 16, 36);
				if ($salt === FALSE){
					$salt = hash('sha256', time() . mt_rand());
				}
				$keys = substr($salt, 0, 64);
				$key = $keys.''.$this->converter->encode($m['id_merchants']);
				$data =array('token'=>$key);
				$this->access->updatetable('merchants',$data, array("id_merchants" => $m['id_merchants']));	
				$_merchants = $this->access->readtable('employee','',array('employee.deleted_at'=>null,'employee.id_merchant'=>$m['id_merchants'], 'type'=>1))->row();
				if(count($_merchants) > 0){
					$data_simpan = array(
						'id_merchant'	=> $m['id_merchants'],
						'type'			=> 1
					);
					$this->access->inserttable('employee', $data_simpan);
				}
			}
			echo 'Silahkan direload lagi <br/>';
		}else{
			echo 'Semua sudah di update <br/>';
			echo $ql;
		}
	}


}
