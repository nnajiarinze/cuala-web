<?php
class Transcript_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				
        }
		
		 
		 
		public function get_paginated_transcripts($pageNum, $pageSize){
			$offset = ($pageNum - 1) * $pageSize;
			
			$this->db->select('tbl_transcript_requests.price');
			$this->db->select('tbl_transcript_locations.name as loc_name');
			$this->db->select('tbl_users.name as username');
			$this->db->select('tbl_transcript_requests.last_modified_date');
			$this->db->from('tbl_transcript_requests');
			$this->db->join('tbl_transcript_locations', 'tbl_transcript_locations.id = tbl_transcript_requests.loc_id');
			$this->db->join('tbl_users', 'tbl_users.id = tbl_transcript_requests.user_id');
			$this->db->limit($pageSize, $offset);  
			$query = $this->db->get();

			$transcripts['data']= $query->result_array();	
		 
			$transcripts['iTotalRecords'] =  $this->db->count_all('tbl_transcript_requests');
			$transcripts['iTotalDisplayRecords']=$transcripts['iTotalRecords'];
			return $transcripts;
		}



	 
		public function get_paginated_transcript_locations($pageNum, $pageSize){
			$offset = ($pageNum - 1) * $pageSize;
			
			$this->db->select('tbl_transcript_locations.*');
			$this->db->from('tbl_transcript_locations');
			 
			$this->db->limit($pageSize, $offset);  
			$query = $this->db->get();

			$transcripts['data']= $query->result_array();	
		 
			$transcripts['iTotalRecords'] =  $this->db->count_all('tbl_transcript_locations');
			$transcripts['iTotalDisplayRecords']=$transcripts['iTotalRecords'];
			return $transcripts;
		}







	

		public function create_transcript_location($postData){ 
			
			$data = array(
			'name' => $postData['name'],
			'price' => $postData['price']
			);
			$this->db->insert('tbl_transcript_locations', $data);
			return ($this->db->affected_rows() != 1) ? false : true;
		}


		 


}