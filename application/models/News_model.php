<?php
class News_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				
        }
		
		public function get_news()
		{		
			$this->db->where('deleted', 0);
			$query = $this->db->get('tbl_news');
			return $query->result_array();
		}
		
		public function get_paginated_news($pageNum, $pageSize){
			$offset = ($pageNum - 1) * $pageSize;
			$this->db->where('deleted', 0);
			$this->db->order_by('id', 'DESC');
			$query =$this->db->get('tbl_news', $pageSize, $offset);
			$news['data']= $query->result_array();	
		 
			$news['iTotalRecords'] =  $this->db->count_all('tbl_news');
			$news['iTotalDisplayRecords']=$news['iTotalRecords'];
			return $news;
		}


		public function create_news($postData){
			
			$data = array(
			'headline' => $postData['headline'],
			'brief' => $postData['brief'],
			'description' => $postData['description'],
			'publish_date' => $postData['publish_date'],
			'author' =>$postData['author'],
			'image' =>$postData['image'],
			'created_date'=>date("Y/m/d")
			);
			$this->db->insert('tbl_news', $data);
			return ($this->db->affected_rows() != 1) ? false : true;
		}

		public function get_news_by_id($newsId){
			$query = $this->db->get_where('tbl_news', array('id' => $newsId));
			return $query->row();
		}

		public function update_news($postData,$newsId){


						$data = array(
						'headline' => $postData['headline'],
						'brief' => $postData['brief'],
						'description' => $postData['description'],
						'publish_date' => $postData['publish_date'],
						'author' =>$postData['author'],
						'image' =>$postData['image']
						);
						/*$image = $postData['image'];
					if(!empty($image)){

						  $this->db->set('image', "CONCAT(image,', ','".$postData['image']."')", FALSE);
						} */

						$this->db->where('id', $newsId);
    					$this->db->update('tbl_news',$data);
    					return ($this->db->affected_rows() != 1) ? false : true;

				}


	public function delete_news($newsId){

		$data = array(
			'deleted'=> 1);
		$this->db->where('id', $newsId);
		$this->db->update('tbl_news',$data);

		return ($this->db->affected_rows() != 1) ? false : true;
	}


}