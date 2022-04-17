<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Access extends CI_Model {
    function __construct()
    {
        // Call the Model constructor
        parent::__construct();	
    }
    function readtable($tablename = '', $select='', $where = '', $join = '', $limit = '',$sort = '',$join_model = '',$group_by ='', $like='', $or_like=''){
		
		if(!empty($like)){
    		$this->db->like($like);
        }
		if(!empty($or_like)){
    		$this->db->or_like($or_like);
        }
        if(!empty($where)){
    		$this->db->where($where);
        }
        if(!empty($group_by)){
            $this->db->group_by($group_by);
        }
        if(is_array($join) AND !empty($join)){
            foreach($join as $key => $data){  
                $this->db->join($key, $data,$join_model);
            }
        }
        if(!empty($limit)){ 
            $this->db->limit($limit[0],$limit[1]);
            
        }
        if(!empty($select)){
            $this->db->select($select);
        }  
		// $cnt = count($sort);
		
		if(!empty($sort)){			
    		$this->db->order_by($sort[0],$sort[1]);
			//$this->db->order_by($sort[2],$sort[3]);		
        }
		
        $query = $this->db->get($tablename);		
        return $query;
    }
    function inserttable($tablename = '', $data = '')
    {
       $this->db->insert($tablename, $data); 
	   return $this->db->insert_id();
    }
    function updatetable($tablename = '', $data = '', $where='')
    {    
        $this->db->where($where);
        return $this->db->update($tablename, $data);
    }
    function deletetable($tablename = '',$where='')
    {
        return $this->db->delete($tablename, $where); 
    }
	
	function get_in($tablename = '', $field = '', $val_field='', $where='', $sort = ''){
		$this->db->where($where);
		$this->db->where_in($field, $val_field);
		if(!empty($sort)){			
    		$this->db->order_by($sort[0],$sort[1]);
			//$this->db->order_by($sort[2],$sort[3]);		
        }
		return $this->db->get($tablename);
	}
	
	function get_optaddon($id_menu='', $tablename){	
		$this->db->where_in('id_menu', $id_menu);
		$this->db->where('deleted_at is null',null);
		return $this->db->get($tablename);
	}
	
	function transaksi_history($id_member=0){
		$this->db->join('merchants', 'merchants.id_merchants = transaksi.id_merchant', 'left');
		$this->db->where('transaksi.id_member', $id_member);
		// $this->db->where_in('transaksi.status', array('3','4'));
		$this->db->where('transaksi.status', 5);
		return $this->db->get('transaksi');
	}
	
	function transaksi_progress($id_member=0){
		$this->db->join('merchants', 'merchants.id_merchants = transaksi.id_merchant', 'left');
		$this->db->where('transaksi.id_member', $id_member);
		$this->db->where_in('transaksi.status', array('1','2','4','6'));
		$this->db->order_by('transaksi.id_transaksi', 'DESC');
		return $this->db->get('transaksi');
	}
	
	function transaksi_progress_merchant($id_merchant = 0){
		$this->db->join('merchants', 'merchants.id_merchants = transaksi.id_merchant', 'left');
		$this->db->where('transaksi.id_merchant', $id_merchant);
		// $this->db->where('transaksi.status', 4);
		$this->db->where_in('transaksi.status', array('4','6'));
		$this->db->order_by('transaksi.id_transaksi', 'DESC');
		return $this->db->get('transaksi');
	}
	
	function transaksi_new_merchant($id_merchant = 0){
		$this->db->join('merchants', 'merchants.id_merchants = transaksi.id_merchant', 'left');
		$this->db->where('transaksi.id_merchant', $id_merchant);
		$this->db->where('transaksi.status', 2);
		$this->db->order_by('transaksi.id_transaksi', 'DESC');
		return $this->db->get('transaksi');
	}
	
	function transaksi_complete_merchant($id_merchant = 0){
		$this->db->join('merchants', 'merchants.id_merchants = transaksi.id_merchant', 'left');
		$this->db->where('transaksi.id_merchant', $id_merchant);
		$this->db->where('transaksi.status', 5);
		$this->db->order_by('transaksi.id_transaksi', 'DESC');
		return $this->db->get('transaksi');
	}
	
	function get_reviews($id_merchants = 0){
		$sql = 'SELECT id_merchant, rating, COUNT(id_transaksi) as cnt_transaksi FROM `transaksi`';
		if($id_merchants > 0){
			$sql .=' where id_merchant =  '.$id_merchants;
		}
		$sql .=' GROUP BY rating';
		return $this->db->query($sql)->result_array();
	}
	
	function chk_sosmed($user_id = 0){
		$sql = 'SELECT * FROM `members` where deleted_at is null AND status = 1 AND (user_id = "'.$user_id.'" or fb_id = "'.$user_id.'")';
		return $this->db->query($sql)->row();
	}
	
	function get_comment($id_merchant=0){
		$sql = 'SELECT * FROM `transaksi` LEFT JOIN `members` ON `members`.`id_member` = `transaksi`.`id_member` WHERE `transaksi`.`id_merchant` = "'.$id_merchant.'" AND (`transaksi`.`status` = 5) AND transaksi.rating > 0 order by transaksi.tgl_rating ASC';
		return $this->db->query($sql)->result_array();
	}
	
	function get_point_downliner($id_member=0){
		$sql = 'SELECT sum(nilai) as nilai_downliner FROM `point_history` WHERE `point_history`.`id_member` = "'.$id_member.'" AND id_downline > 0';
		return $this->db->query($sql)->row();
	}
	
	function get_point_mlm($id_member=0, $id_downliner=0){
		$sql = 'SELECT sum(nilai) as nilai_downliner FROM `point_history` WHERE `point_history`.`id_member` = "'.$id_member.'" AND id_downline ="'.$id_downliner.'"';
		return $this->db->query($sql)->row();
	}
	
	function get_merchant_ll($minLat = 0, $maxLat = 0, $minLon = 0, $maxLon = 0){
		$sql = "SELECT * FROM merchants WHERE (latitude BETWEEN ".$minLat." AND ".$maxLat.") AND (longitude BETWEEN ".$minLon." AND ".$maxLon.")";
		return $this->db->query($sql)->result_array();
	}
	
	function avg_rating($id_merchant=0){
		$sql = 'SELECT AVG(rating) as avg_rating, id_merchant FROM transaksi WHERE id_merchant = '.$id_merchant.' and rating > 0 GROUP by id_merchant';
		return $this->db->query($sql)->row();
	}
	
	function select_sum($field='', $where='', $tablename=''){
		$this->db->select_sum($field);
		if(!empty($where)){
    		$this->db->where($where);
        }
		return $this->db->get($tablename);
	}
	
}