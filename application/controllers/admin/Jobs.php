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

class Jobs extends Admin_Controller
{


	/**
	 * Controller constructor sets the login restriction
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		$this->auth->restrict();
		$this->load->model('jobs_model');
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
		
		if($this->session->flashdata('success')) {
			$data['success'] = $this->session->flashdata('success');
		}else if($this->session->flashdata('error')) {
			$data['error'] = $this->session->flashdata('error');
		}
		
				$data['title'] = 'Jobs';
				$this->load->view('admin/templates/header', $data);
				$this->load->view('admin/templates/sidebar');
				$this->load->view('admin/templates/topbar');
				$this->load->view('admin/jobs/index', $data);
				$this->load->view('admin/templates/footer');
				
    }//end index()

     public function categories()
    {
        $this->load->model('roles/role_model');

        $user_role = $this->role_model->find($this->current_user->role_id);
        $default_context = ($user_role !== false && isset($user_role->default_context)) ? $user_role->default_context : '';
		
		if($this->session->flashdata('success')) {
			$data['success'] = $this->session->flashdata('success');
		}else if($this->session->flashdata('error')) {
			$data['error'] = $this->session->flashdata('error');
		}
		
				$data['title'] = 'Job categories';
				$this->load->view('admin/templates/header', $data);
				$this->load->view('admin/templates/sidebar');
				$this->load->view('admin/templates/topbar');
				$this->load->view('admin/jobs/categories', $data);
				$this->load->view('admin/templates/footer');
				
    }

	
	public function paginate(){
		$pageNum = $this->input->get('pageNum');

		$pageSize = $this->input->get('pageSize');
		if(!is_numeric($pageNum)) {
			$pageNum =0;
		}
	
		$pageNum = ($pageNum/$pageSize)+1;



		if($pageSize || !is_numeric($pageSize)){
			$pageSize =10;
		}

		$data= $this->jobs_model->get_paginated_jobs($pageNum, $pageSize);
		echo json_encode($data);
	}


	public function paginate_categories(){
		$pageNum = $this->input->get('pageNum');

		$pageSize = $this->input->get('pageSize');
		if(!is_numeric($pageNum)) {
			$pageNum =0;
		}
	
		$pageNum = ($pageNum/$pageSize)+1;



		if($pageSize || !is_numeric($pageSize)){
			$pageSize =10;
		}

		$data= $this->jobs_model->get_paginated_job_categories($pageNum, $pageSize);
		echo json_encode($data);
	}


	public function create(){
       $data ='';
	  	if($this->input->post('submit')) {
	  	 
	 		  $this->form_validation->set_rules('category_id', 'Category', 'required');
	 		  $this->form_validation->set_rules('title', 'Title', 'required');
	 		  $this->form_validation->set_rules('location', 'Location', 'required');
	 		  $this->form_validation->set_rules('end_date', 'End Date', 'required');
	 		  $this->form_validation->set_rules('description', 'Description', 'required');
	 		  if ($this->form_validation->run() == FALSE){
	 		  	
                     $data['error'] = validation_errors('<div class="error">', '</div>');
                    
                }
                else
                {
			      $insertStatus=  $this->jobs_model->create_jobs($this->input->post());
			     if($insertStatus){
			     		$data['success'] = "Job Successfully Created";
			         }else{
			        	   	  $data['error'] = "Error inserting into the database";
			              }
                }
	  	}
	  	$data['categories'] = $this->jobs_model->get_job_categories();
	  		
	  	$this->load->view('admin/templates/header');
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/templates/topbar');
		$this->load->view('admin/jobs/create',$data);
		$this->load->view('admin/templates/footer');
	}



	public function cat(){
       $data ='';
	  	if($this->input->post('submit')) {
	  	 
	 		  $this->form_validation->set_rules('name', 'Name', 'required');
	 		  
	 		  if ($this->form_validation->run() == FALSE){
	 		  	
                     $data['error'] = validation_errors('<div class="error">', '</div>');
                    
                }
                else
                {
			      $insertStatus=  $this->jobs_model->create_job_category($this->input->post());
			     if($insertStatus){
			     		$data['success'] = "Category Successfully Created";
			         }else{
			        	   	  $data['error'] = "Error inserting into the database";
			              }
                }
	  	}
	  	  		
	  	$this->load->view('admin/templates/header');
		$this->load->view('admin/templates/sidebar');
		$this->load->view('admin/templates/topbar');
		$this->load->view('admin/jobs/cat',$data);
		$this->load->view('admin/templates/footer');
	}
	//--------------------------------------------------------------------

	public function edit($jobId){
		if($this->input->post('submit') && is_numeric($jobId)) {
 
 			  $this->form_validation->set_rules('category_id', 'Category', 'required');
	 		  $this->form_validation->set_rules('title', 'Title', 'required');
	 		  $this->form_validation->set_rules('location', 'Location', 'required');
	 		  $this->form_validation->set_rules('end_date', 'End Date', 'required');
	 		  $this->form_validation->set_rules('description', 'Description', 'required');

	 		    if ($this->form_validation->run() == FALSE){
                     $data['error'] = 'Form validation failed';
                }
                else
                {

			      $updateStatus=  $this->jobs_model->update_job($this->input->post(),$jobId);
			     if($updateStatus){
			     		$data['success'] = "Successfully Updated";
			         }else{
			        	   	  $data['error'] = "Error updating database";
			              }
			              
                }


		}

		$data['categories'] = $this->jobs_model->get_job_categories();
		if(is_numeric($jobId)){
				$data['job'] = $this->jobs_model->get_job_by_id($jobId);
				$this->load->view('admin/templates/header');
				$this->load->view('admin/templates/sidebar');
				$this->load->view('admin/templates/topbar');
				$this->load->view('admin/jobs/edit',$data);
				$this->load->view('admin/templates/footer');
		}
	}


	public function edit_category($catId){
		if($this->input->post('submit') && is_numeric($catId)) {
 
 			
	 		  $this->form_validation->set_rules('name', 'name', 'required');
	 		
	 		    if ($this->form_validation->run() == FALSE){
                     $data['error'] = 'Form validation failed';
                }
                else
                {

			      $updateStatus=  $this->jobs_model->update_job_category($this->input->post(),$catId);
			     if($updateStatus){
			     		$data['success'] = "Successfully Updated";
			         }else{
			        	   	  $data['error'] = "Error updating database";
			              }
			              
                }


		}

	 
		if(is_numeric($catId)){
				$data['category'] = $this->jobs_model->get_job_category_by_id($catId);
				$this->load->view('admin/templates/header');
				$this->load->view('admin/templates/sidebar');
				$this->load->view('admin/templates/topbar');
				$this->load->view('admin/jobs/edit_category',$data);
				$this->load->view('admin/templates/footer');
		}
	}


		public function delete($jobId){
			 $this->load->model('roles/role_model');
			 $user_role = $this->role_model->find($this->current_user->role_id);
       		 $default_context = ($user_role !== false && isset($user_role->default_context)) ? $user_role->default_context : '';
			$deleteStatus= $this->jobs_model->delete_job($jobId);
			  if($deleteStatus){
			     		
			     		$this->session->set_flashdata('success', 'Delete Successful');
			  

			         }else{
			        	   	  $this->session->set_flashdata('error', 'Error deleting job item');
			              }

			  
			            redirect('/admin/jobs', 'refresh');


		
		}


	public function delete_cat($catId){
			 $this->load->model('roles/role_model');
			 $user_role = $this->role_model->find($this->current_user->role_id);
       		 $default_context = ($user_role !== false && isset($user_role->default_context)) ? $user_role->default_context : '';
			$deleteStatus= $this->jobs_model->delete_job_category($catId);
			  if($deleteStatus){
			     		
			     		$this->session->set_flashdata('success', 'Delete Successful');
			  

			         }else{
			        	   	  $this->session->set_flashdata('error', 'Error deleting category');
			              }

			  
			            redirect('/admin/jobs/categories', 'refresh');


		
		}





}//end class