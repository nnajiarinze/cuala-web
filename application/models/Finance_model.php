<?php
class Finance_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				
        }
		
		
		
		public function get_paginated_reports($pageNum, $pageSize){
			$offset = ($pageNum - 1) * $pageSize;
			
			$this->db->order_by('id', 'DESC');
			$query =$this->db->get('tbl_financial_reports', $pageSize, $offset);
			$reports['data']= $query->result_array();	
		 
			$reports['iTotalRecords'] =  $this->db->count_all('tbl_financial_reports');
			$reports['iTotalDisplayRecords']=$reports['iTotalRecords'];
			return $reports;
		}


		public function create_report($postData){
			
			$data = array(
			'title' => $postData['title'],
			'source' => $postData['source'],
			'author' => $postData['author'],
			'upload_date'=>date("Y/m/d"),	
			);
			$this->db->insert('tbl_financial_reports', $data);
			return ($this->db->affected_rows() != 1) ? false : true;
		}

		public function get_report_by_id($id){
			$query = $this->db->get_where('tbl_financial_reports', array('id' => $id));
			return $query->row();
		}

	
	public function delete_report($id){

		$this->db->delete('tbl_financial_reports', array('id' => $id));

		return ($this->db->affected_rows() != 1) ? false : true;
	}


}