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

class Podcasts extends Admin_Controller
{


	/**
	 * Controller constructor sets the login restriction
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		$this->auth->restrict();
		$this->load->model('podcasts_model');
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
		
				$data['title'] = 'Podcasts';
				$this->load->view('admin/templates/header', $data);
				$this->load->view('admin/templates/sidebar');
				$this->load->view('admin/templates/topbar');
				$this->load->view('admin/podcasts/index', $data);
				$this->load->view('admin/templates/footer');
				
    }//end index()

	
	public function paginate(){
		$pageNum = $this->input->get('pageNum');
		$pageSize = $this->input->get('pageSize');
		if(!is_numeric($pageNum)) {
			$pageNum =0;
		}
		$pageNum = round(($pageNum/$pageSize)+1);
			
		
		if($pageSize || !is_numeric($pageSize)){
			$pageSize =10;
		}
		
		$data= $this->podcasts_model->get_paginated_podcasts($pageNum, $pageSize);
		echo json_encode($data);
	}


	public function create(){
       $data ='';

	  	if($this->input->post('submit')) {
	  
	  	
	  	 echo 'got jer';
	  	 exit();
	 		  $this->form_validation->set_rules('title', 'Title', 'required');
	 		  $this->form_validation->set_rules('author', 'Author', 'required');
	 	
	 		  if ($this->form_validation->run() == FALSE){
                     $data['error'] = 'Form validation failed';
                }
                else
                {
                $config['upload_path']          = './uploads/podcasts/';
                $config['allowed_types']        = 'mp3|mp4';
                $config['max_size']             = 200000000000;

                $this->load->library('upload', $config);
				  $source='';
				  $duration =0;
              if(isset($_FILES['source'])){
            
                	 if ( !$this->upload->do_multi_upload('source')){
		                        $error = array('error' => $this->upload->display_errors());
		                   
		                       $data['error'] = $error;
		                       echo 'error';
		                       var_dump($error);
		                       exit();
		                       
		                } else{
		                			$data = $this->upload->data();
		                			 
			                        $source = 'podcasts/'.$data['file_name'];
			                        $mp3file = new MP3File('uploads/'.$source); 
									$duration =$mp3file->getDuration(); 
								   $duration = gmdate("H:i:s", $duration);

								   var_dump($data);
			                }
			       }
			       $_POST['source'] = IMAGES_URI.''.$source;
			       $_POST['duration'] = $duration;
				 
			    
			      $insertStatus=  $this->podcasts_model->create_podcast($this->input->post());
			     if($insertStatus){
			     		$data['success'] = "Podcast Successfully Created";
			         }else{
			        	   	  $data['error'] = "Error inserting into the database";
			              }
                }
	  	}

	
	 
	  	  
	  	$this->load->view('admin/templates/header');
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/templates/topbar');
		$this->load->view('admin/podcasts/create',$data);
		$this->load->view('admin/templates/footer');
	}
	//--------------------------------------------------------------------

	public function edit($id){
		if($this->input->post('submit') && is_numeric($id)) {
 
 
			  $this->form_validation->set_rules('title', 'Title', 'required');
	 		  $this->form_validation->set_rules('source', 'Source', 'required');

	 		    if ($this->form_validation->run() == FALSE){
                     $data['error'] = 'Form validation failed';
                }
                else
                {
                 $config['upload_path']          = './uploads/podcasts/';
                $config['allowed_types']        = 'mp3|mp4';
                $config['max_size']             = 100000;

                $this->load->library('upload', $config);
				  $source='';
              if(isset($_FILES['podcast']) && $_FILES['podcast']['size'][0] > 0){
                	 if ( ! $this->upload->do_upload('podcast')){
		                        $error = array('error' => $this->upload->display_errors());
		                       
		                       $data['error'] = $error;

		                       
		                } else{
			                        $data = $this->upload->get_upload_data();
			                        $source = 'podcast/'.$data['file_name'];
			                       
			                     
			                }
			       }
			       $_POST['source'] = $source;

			      $updateStatus=  $this->podcasts_model->update_podcast($this->input->post(),$id);
			     if($updateStatus){
			     		$data['success'] = "Successfully Updated";
			         }else{
			        	   	  $data['error'] = "Error updating database";
			              }
			              
                }


		}


		if(is_numeric($id)){
				$data['podcast'] = $this->podcasts_model->get_podcast_by_id($id);
				$this->load->view('admin/templates/header');
				$this->load->view('admin/templates/sidebar');
				$this->load->view('admin/templates/topbar');
				$this->load->view('admin/podcasts/edit',$data);
				$this->load->view('admin/templates/footer');
		}
	}






		public function delete($id){
			 $this->load->model('roles/role_model');
			 $user_role = $this->role_model->find($this->current_user->role_id);
       		 $default_context = ($user_role !== false && isset($user_role->default_context)) ? $user_role->default_context : '';
			$deleteStatus= $this->podcasts_model->delete_podcast($id);
			  if($deleteStatus){
			     		
			     		$this->session->set_flashdata('success', 'Delete Successful');
			  

			         }else{
			        	   	  $this->session->set_flashdata('error', 'Error deleting item');
			              }

			  
			            redirect('/admin/podcasts', 'refresh');


		
		}



}//end class