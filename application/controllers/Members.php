<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Members extends MY_Controller {

	public function __construct() {
		parent::__construct();		
		$this->load->model('Access', 'access', true);	
	}	
	
	public function index() {
		
		if(!$this->session->userdata('login') && !$this->session->userdata('member')){
			$this->no_akses();
			return false;
		}
		
		$this->data['judul_browser'] = 'Member';
		$this->data['judul_utama'] = 'Member';
		$this->data['judul_sub'] = 'CHARISMA';
		$this->data['title_box'] = 'List of Member';
		
		$this->data['isi'] = $this->load->view('member_v', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	function members_data(){
        $requestData= $_REQUEST;
		$select = array('members.*','admin.fullname');        
        $member = array();
        if(!empty($requestData['search']['value'])) {
			$search = $this->db->escape_str($requestData['search']['value']);
			$member = $this->access->readtable('members',$select,'',array('admin'=>'admin.operator_id = members.status_by'),'','','LEFT','',array('members.nama'=>$search), array('members.email'=>$search, 'members.phone'=>$search))->result_array();
		    $totalFiltered=count($member);
		    $totalData=count($member);
        }else{
			$member = $this->access->readtable('members',$select,'',array('admin'=>'admin.operator_id = members.status_by'),array($requestData['length'],$requestData['start']),'','LEFT')->result_array();
			$members = $this->access->readtable('members',$select,'',array('admin'=>'admin.operator_id = members.status_by'),'','','LEFT')->result_array();
			$totalData = count($members);
			$totalFiltered=count($members);
        }
        $data = array();
        $nestedData=array();               
        $img = '';
		$view_member = '';   
		$status = '';
		$_type = '';
        if(!empty($member)){
            $i=1;			
            foreach($member as $row) {
				$nestedData=array();               
                $img = '';
				$view_member = '';
				if($row['status'] == 1){
					$status = '<small class="label label-success bg-green">Active</small>';
				}else if($row['status'] == 0){
					$status = '<small class="label label-danger">Inactive</small>';
				if($row['status_by'] > 0){
					$status .= '<br/> On '.date('d-m-Y', strtotime($row['status_date']));
					$status .= '<br/> By '.$row['fullname'];
				}
				}else{
					$status = '';
				}
				$_type = '';
				$_btn = '';
				$phone = !empty($row['phone']) ? $row['phone'] : '-';
				if($row['type'] == 1){
					$_type = '<small class="label label-warning"><strong>B to B</strong></small>'; 
					$_btn = '<button style="margin-top:4px;" title="Set B to C" onclick="return set_bc('.$row['id_member'].');" class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Set B to C</button>';
				}
				if($row['type'] == 2){
					$_type = '<small class="label label-info"><strong>B to C</strong></small>';
					$_btn = '<button style="margin-top:4px;" onclick="return set_bb('.$row['id_member'].');" title="Set B to B" class="btn btn-xs btn-success"><i class="fa fa-edit"></i> Set B to B</button>';
				}
				$img = !empty($row['photo']) ? $row['photo'] : base_url('uploads/no_photo.jpg');
				$view_member = site_url('members/view_member/'.$row['id_member']);

				$nestedData[] = $i;
				$nestedData[] = $row['nama'].'<br/>'.$_type;
				$nestedData[] = $row['email'].'<br/>Phone : '.$phone;
				$nestedData[] = date('d-M-Y', strtotime($row['dob']));
				$nestedData[] = $status;
				$nestedData[] = '<img width="200" height="200" src="'.$img.'">';
				
             
				$nestedData[] = '<a href="'.$view_member .'"/><button title="View" class="btn btn-xs btn-primary view_member"><i class="fa fa-eye"></i> View</button></a><br/>'.$_btn;
				
            
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
	
	public function view_member($id_member=0){
		$this->data['judul_browser'] = 'Member';
		$this->data['judul_utama'] = 'Member';
		$this->data['judul_sub'] = 'CHARISMA';
		$this->data['member'] = $this->access->readtable('members','',array('id_member'=>$id_member))->row();
		$this->data['point_history'] = $this->access->readtable('point_history','',array('id_member'=>$id_member))->result_array();
		$this->data['transaksi'] = $this->access->readtable('transaksi','',array('id_member'=>$id_member))->result_array();
		$this->data['isi'] = $this->load->view('member_detail', $this->data, TRUE);
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	
	public function inactive(){
		$tgl = date('Y-m-d H:i:s');
		$status = $_POST['status'] > 0 ? 1 : 0;
		$where = array(
			'id_member' => $_POST['id']			
		);
		$key = '';
		if($status > 0){
			$salt = base_convert(bin2hex($this->security->get_random_bytes(64)), 16, 36);
			if ($salt === FALSE){
				$salt = hash('sha256', time() . mt_rand());
			}
			$keys = substr($salt, 0, 64);
			$key = $keys.''.$this->converter->encode($_POST['id']);	
		}
		$data = array(
			'token'			=> $key,
			'status'		=> $status,
			'status_by'		=> $this->session->userdata('operator_id'),
			'status_date'	=> $tgl
		);
		echo $this->access->updatetable('members', $data, $where);
	}
	
	public function set_type(){
		$status = (int)$_POST['status'];
		$where = array(
			'id_member' => $_POST['id']			
		);
		$data = array(
			'type'			=> $status
		);
		echo $this->access->updatetable('members', $data, $where);
	}
	
	public function no_akses() {
		if ($this->session->userdata('login') == FALSE) {
			redirect('/');
			return false;
		}
		$this->data['judul_browser'] = 'Tidak Ada Akses';
		$this->data['judul_utama'] = 'Tidak Ada Akses';
		$this->data['judul_sub'] = '';
		$this->data['isi'] = '<div class="alert alert-danger">Anda tidak memiliki Akses.</div>';
		$this->load->view('themes/layout_utama_v', $this->data);
	}
	

}
