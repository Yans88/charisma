<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/REST_Controller.php';

class News extends REST_Controller {

    function __construct(){
        parent::__construct();
		$this->load->model('Access','access',true);
    }

    public function index_post(){
		$param = $this->input->post();
		$offset = isset($param['offset']) ? (int)$param['offset'] : 0;
		$limit = isset($param['limit']) ? (int)$param['limit'] : 0;
		// $sort = '',$join_model = '',$group_by ='', $like='', $or_like='',$offset=''
		
		
		$news = $this->access->readtable('news','',array('deleted_at'=>null),'',$limit,'','','','','',$offset)->result_array();
		
		$dt = array();
		$img = '';
		$description = '';
		// error_log($this->db->last_query());
		if(!empty($news)){
			foreach($news as $n){
				$description = preg_replace("/<p[^>]*?>/", "", $n['description']);
				$description = str_replace("</p>", "", $description);
				//$description = str_replace("\r\n","<br />",$description);
				$img = !empty($n['img']) ? base_url('uploads/news/'.$n['img']) : base_url('uploads/no_photo.jpg');
				$dt[] = array(
					"id_news"			=> $n['id_news'],
					"title"				=> $n['judul'],
					"description"		=> $description,
					"img"				=> $img,
					"tgl"				=> date('d-M-Y', strtotime($n['tgl']))
				);
			}
		}
		if (!empty($dt)){
            $this->set_response([
				'err_code' => '00',
                'message' => 'Ok',
				'data'	=> $dt], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $this->set_response([
                'err_code' => '04',
                'message' => 'Data not be found'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
    }

	public function news_detail_post(){
		$param = $this->input->post();
		$id_news = isset($param['id_news']) ? (int)$param['id_news'] : 0;
		
		$p = $this->access->readtable('news','',array('id_news'=>$id_news,'deleted_at'=>null))->row();
		$dt = array();
		$description = '';
		$img = '';
		if(!empty($p)){
			$description = preg_replace("/<p[^>]*?>/", "", $p->description);
			$description = str_replace("</p>", "", $description);
			$img = !empty($p->img) ? base_url('uploads/news/'.$p->img) : base_url('uploads/no_photo.jpg');
			$dt = array(
				"id_news"		=> $p->id_news,
				"title"			=> $p->judul,
				"img"			=> $img,				
				"description"	=> $description,				
				"tgl"			=> date('d-M-Y', strtotime($p->tgl))
				
			);
		}
		if (!empty($dt)){
            $this->set_response([
				'err_code' => '00',
                'message' => 'Ok',
				'data'	=> $dt], REST_Controller::HTTP_OK); // OK (200) being the HTTP response code
        }else{
            $this->set_response([
                'err_code' => '04',
                'message' => 'Data not be found'
            ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
        }
    }

}
