<?php
class Jobs_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				
        }
		
		public function get_jobs()
		{		
		 
			$query = $this->db->get('tbl_jobs');
			return $query->result_array();
		}

		public function get_job_categories()
		{		
		 
			$query = $this->db->get('tbl_job_category');
			return $query->result_array();
		}
		
		public function get_paginated_jobs($pageNum, $pageSize){
			$offset = ($pageNum - 1) * $pageSize;
			
			$this->db->select('tbl_jobs.*');
			$this->db->select('tbl_job_category.name');
			$this->db->from('tbl_jobs');
			$this->db->join('tbl_job_category', 'tbl_job_category.id = tbl_jobs.category_id');
			$this->db->order_by('tbl_jobs.id', 'DESC');
			$this->db->limit($pageSize, $offset);  
			$query = $this->db->get();

			$jobs['data']= $query->result_array();	
		 
			$jobs['iTotalRecords'] =  $this->db->count_all('tbl_jobs');
			$jobs['iTotalDisplayRecords']=$jobs['iTotalRecords'];
			return $jobs;
		}

		public function get_paginated_job_categories($pageNum, $pageSize){
			$offset = ($pageNum - 1) * $pageSize;
			
	
			$this->db->select('*');
			$this->db->from('tbl_job_category');
			$this->db->order_by('name', 'ASC');
			$this->db->limit($pageSize, $offset);  
			$query = $this->db->get();

			$categories['data']= $query->result_array();	
		 
			$categories['iTotalRecords'] =  $this->db->count_all('tbl_job_category');
			$categories['iTotalDisplayRecords']=$categories['iTotalRecords'];
			return $categories;
		}


		public function create_jobs($postData){
			
			$data = array(
			'category_id' => $postData['category_id'],
			'title' => $postData['title'],
			'location' => $postData['location'],
			'description' => $postData['description'],
			'created_date'=>date("Y/m/d"),
			'end_date' =>$postData['end_date']
			);
			$this->db->insert('tbl_jobs', $data);
			return ($this->db->affected_rows() != 1) ? false : true;
		}

			public function create_job_category($postData){
			
			$data = array(
			'name' => $postData['name']
				);
			$this->db->insert('tbl_job_category', $data);
			return ($this->db->affected_rows() != 1) ? false : true;
		}

		public function get_job_by_id($jobId){
			$query = $this->db->get_where('tbl_jobs', array('id' => $jobId));
			return $query->row();
		}
	
		public function get_job_category_by_id($catId){
				$query = $this->db->get_where('tbl_job_category', array('id' => $catId));
				return $query->row();
			}

		public function update_job($postData,$jobId){

						$data = array(
						'category_id' => $postData['category_id'],
						'title' => $postData['title'],
						'location' => $postData['location'],
						'description' => $postData['description'],
						'created_date'=>date("Y/m/d"),
						'end_date' =>$postData['end_date']
						);

						$this->db->where('id', $jobId);
    					$this->db->update('tbl_jobs',$data);
    					return ($this->db->affected_rows() != 1) ? false : true;

				}


	public function update_job_category($postData,$catId){

						$data = array(
						'name' => $postData['name']
						);

						  
						$this->db->where('id', $catId);
    					$this->db->update('tbl_job_category',$data);
    					return ($this->db->affected_rows() != 1) ? false : true;

				}


	public function delete_job($jobId){

		$this->db->delete('tbl_jobs', array('id' => $jobId));

		return ($this->db->affected_rows() != 1) ? false : true;
	}

public function delete_job_category($catId){

		$this->db->delete('tbl_job_category', array('id' => $catId));

		return ($this->db->affected_rows() != 1) ? false : true;
	}


}