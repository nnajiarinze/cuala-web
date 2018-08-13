<?php
class Podcasts_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				
        }
		
		public function get_podcasts()
		{		
		 
			$query = $this->db->get('tbl_podcasts');
			return $query->result_array();
		}
		
		public function get_paginated_podcasts($pageNum, $pageSize){
			$offset = ($pageNum - 1) * $pageSize;
			
			$this->db->order_by('id', 'DESC');
			$query =$this->db->get('tbl_podcasts', $pageSize, $offset);
			$podcasts['data']= $query->result_array();	
		 
			$podcasts['iTotalRecords'] =  $this->db->count_all('tbl_podcasts');
			$podcasts['iTotalDisplayRecords']=$podcasts['iTotalRecords'];
			return $podcasts;
		}


		public function create_podcast($postData){
			
			$data = array(
			'title' => $postData['title'],
			'source' => $postData['source'],
			'author' => $postData['author'],
			'duration' => $postData['duration']			
			);
			$this->db->insert('tbl_podcasts', $data);
			return ($this->db->affected_rows() != 1) ? false : true;
		}

		public function get_podcast_by_id($podcastId){
			$query = $this->db->get_where('tbl_podcasts', array('id' => $podcastId));
			return $query->row();
		}

	
	public function delete_podcast($id){

		$this->db->delete('tbl_podcasts', array('id' => $id));

		return ($this->db->affected_rows() != 1) ? false : true;
	}


}