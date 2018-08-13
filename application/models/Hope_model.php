<?php
class Hope_model extends CI_Model {

        public function __construct()
        {
                $this->load->database();
				
        }
		
		
		
		public function get_paginated_events($pageNum, $pageSize){
			$offset = ($pageNum - 1) * $pageSize;
			$this->db->select('tbl_hope_events.*,tbl_hope_services.name');
			$this->db->join('tbl_hope_services', 'tbl_hope_services.id = tbl_hope_events.service_id');
			$this->db->where('tbl_hope_events.deleted', 0);
			$this->db->order_by('tbl_hope_events.id', 'DESC');
			$query =$this->db->get('tbl_hope_events', $pageSize, $offset);
			$events['data']= $query->result_array();	
		 
			$events['iTotalRecords'] =  $this->db->count_all('tbl_hope_events');
			$events['iTotalDisplayRecords']=$events['iTotalRecords'];
			return $events;
		}


		public function get_services(){

			$query = $this->db->get('tbl_hope_services');
			return $query->result_array();
		}


		public function create_event($postData){
			
			$data = array(
			'title' => $postData['title'],
			'service_id' => $postData['service_id'],
			'location' => $postData['location'],
			'date' => $postData['date'],
			'image' => $postData['image'],
			'description' =>$postData['description'],
			'created_date'=>date("Y/m/d")
			);
			$this->db->insert('tbl_hope_events', $data);
			return ($this->db->affected_rows() != 1) ? false : true;
		}

		public function get_event_by_id($eventId){
			$query = $this->db->get_where('tbl_hope_events', array('id' => $eventId));
			return $query->row();
		}

		public function update_event($postData,$eventId){
						
						
			$data = array(
			'title' => $postData['title'],
			'service_id' => $postData['service_id'],
			'location' => $postData['location'],
			'date' => $postData['date'],
			'image' => $postData['image'],
			'description' =>$postData['description']
			);

			/*$image = $postData['image'];
						if(!empty($image)){
							
						  $this->db->set('image', "CONCAT(image,', ','".$postData['image']."')", FALSE);
						}*/


						$this->db->where('id', $eventId);
    					$this->db->update('tbl_hope_events',$data);
    					return ($this->db->affected_rows() != 1) ? false : true;

				}


	public function delete_event($eventId){

		$data = array(
			'deleted'=> 1);
		$this->db->where('id', $eventId);
		$this->db->update('tbl_hope_events',$data);

		return ($this->db->affected_rows() != 1) ? false : true;
	}


}