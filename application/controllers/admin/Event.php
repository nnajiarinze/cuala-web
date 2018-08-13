<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Bonfire
 *
 * An open source project to allow developers get a jumpstart their development of CodeIgniter applications
 *
 * @package   Bonfire
 * @author    Bonfire Dev Team
 * @copyright Copyright (c) 2011 - 2013, Bonfire Dev Team
 * @license   http://guides.cibonfire.com/license.html
 * @link      http://cibonfire.com
 * @since     Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

class Event extends Admin_Controller
{


	/**
	 * Controller constructor sets the login restriction
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		$this->auth->restrict();
		$this->load->model('event_model');
         $this->load->helper('url_helper');
         $this->load->helper('form');
         $this->load->library('form_validation');
         $this->load->library('session');
         $this->load->helper('url');


	}//end __construct()

	//--------------------------------------------------------------------

    public function index()
    {
        $this->load->model('roles/role_model');
        

        $user_role = $this->role_model->find($this->current_user->role_id);
        $default_context = ($user_role !== false && isset($user_role->default_context)) ? $user_role->default_context : '';
		
		if(!$this->session->flashdata('success')) {
			$data['success'] = $this->session->flashdata('success');
		}else if(!$this->session->flashdata('error')) {
			$data['error'] = $this->session->flashdata('error');
		}
		
				$data['title'] = 'Events';
				$this->load->view('admin/templates/header', $data);
				$this->load->view('admin/templates/sidebar');
				$this->load->view('admin/templates/topbar');
				$this->load->view('admin/event/index', $data);
				$this->load->view('admin/templates/footer');
				
    }//end index()

	
	public function paginate(){
		$pageNum = $this->input->get('pageNum');
		$pageSize = $this->input->get('pageSize');
		if(!is_numeric($pageNum)){
			$pageNum =0;
		}
		
		$pageNum = round(($pageNum/$pageSize)+1);
			
	
		if($pageSize || !is_numeric($pageSize)){
			$pageSize =10;
		}
		
		$data= $this->event_model->get_paginated_events($pageNum, $pageSize);
		echo json_encode($data);
	}


	public function create(){
       $data ='';
	  	if($this->input->post('submit')) {
	  	 
	 		  $this->form_validation->set_rules('title', 'Title', 'required');
	 		  $this->form_validation->set_rules('location', 'Location', 'required');
	 		  $this->form_validation->set_rules('date', ' Date', 'required');
	 		  $this->form_validation->set_rules('description', 'Description', 'required');
	 		  if ($this->form_validation->run() == FALSE){
                     $data['error'] = 'Form validation failed';
                }
                else
                {
                $config['upload_path']          = './uploads/event/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 100000;

                $this->load->library('upload', $config);
				  $image='';
              if(isset($_FILES['image']) && $_FILES['image']['size'][0] > 0){
                	 if ( ! $this->upload->do_multi_upload('image')){
		                        $error = array('error' => $this->upload->display_errors());
		                       
		                       $data['error'] = $error;

		                       
		                } else{
			                        $data = $this->upload->get_multi_upload_data();
			                        for($i=0; $i < sizeof($data); $i++){
			                        	if($i ==0){
			                        		 $image .=   IMAGES_URI.''.'event/'.$data[$i]['file_name'];
			                        		}else{
			                        			 $image .=  ','.IMAGES_URI.''.'event/'.$data[$i]['file_name'];
			                        		}
			                        }
			                     
			                }
			       }


			       $_POST['image'] = $image;
			      $insertStatus=  $this->event_model->create_event($this->input->post());
			     if($insertStatus){
			     		$data['success'] = "Event Successfully Created";
			         }else{
			        	   	  $data['error'] = "Error inserting into the database";
			              }
                }
	  	}
	  		
	  	$this->load->view('admin/templates/header');
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/templates/topbar');
		$this->load->view('admin/event/create',$data);
		$this->load->view('admin/templates/footer');
	}
	//--------------------------------------------------------------------

	public function edit($eventId){
		if($this->input->post('submit') && is_numeric($eventId)) {
 
 
			 
	 		  $this->form_validation->set_rules('title', 'Title', 'required');
	 		  $this->form_validation->set_rules('location', 'Location', 'required');
	 		  $this->form_validation->set_rules('date', ' Date', 'required');
	 		  $this->form_validation->set_rules('description', 'Description', 'required');

	 		    if ($this->form_validation->run() == FALSE){
                     $data['error'] = 'Form validation failed';
                }
                else
                {
                $config['upload_path']          = './uploads/event/';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['max_size']             = 100000;

                $this->load->library('upload', $config);
				  $image='';
              if(isset($_FILES['image']) && $_FILES['image']['size'][0] > 0){
                	 if ( ! $this->upload->do_multi_upload('image')){
		                        $error = array('error' => $this->upload->display_errors());		                       
		                       $data['error'] = $error;		                       
		                } else{
			                        $data = $this->upload->get_multi_upload_data();
			                        for($i=0; $i < sizeof($data); $i++){
			                        	if($i ==0){
			                        		 $image .=  IMAGES_URI.''.'event/'.$data[$i]['file_name'];
			                        		}else{
			                        			 $image .= ','.IMAGES_URI.''.'event/'.$data[$i]['file_name'];
			                        		}
			                        }
			                }
			       }
			       if($image && !$this->input->post('selectedImages')) {
			       		$image =implode(",",  $this->input->post('selectedImages'));
			     
			       }else{
			       	$subString = '';
			    
			       	if(!$this->input->post('selectedImages')) {
			       		$subString =implode(",",  $this->input->post('selectedImages'));
			       		 $image .= ','.$subString;

			       	}
			       }

			         if(isset($_POST['selectedImages'])){
	 		  		$selectedImages = implode(",", $_POST['selectedImages']);
	 		  		if(!empty($selectedImages)){
	 		  			$image .= ','.$selectedImages;
	 		  		}
	 		  }
	 		  
			       $_POST['image'] = $image;
			      $updateStatus=  $this->event_model->update_event($this->input->post(),$eventId);
			     if($updateStatus){
			     		$data['success'] = "Successfully Updated";
			         }else{
			        	   	  $data['error'] = "Error updating database";
			              }
			              
                }


		}


		if(is_numeric($eventId)){
				$data['event'] = $this->event_model->get_event_by_id($eventId);
				$this->load->view('admin/templates/header');
				$this->load->view('admin/templates/sidebar');
				$this->load->view('admin/templates/topbar');
				$this->load->view('admin/event/edit',$data);
				$this->load->view('admin/templates/footer');
		}
	}


		public function delete($eventId){
			 $this->load->model('roles/role_model');
			 $user_role = $this->role_model->find($this->current_user->role_id);
       		 $default_context = ($user_role !== false && isset($user_role->default_context)) ? $user_role->default_context : '';
			$deleteStatus= $this->event_model->delete_event($eventId);
			  if($deleteStatus){
			     		
			     		$this->session->set_flashdata('success', 'Delete Successful');

			         }else{
			        	   	  $this->session->set_flashdata('error', 'Error deleteing event item');
			              }

			  
			            redirect('/admin/event', 'refresh');


		
		}

}//end class