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

class Transcript extends Admin_Controller
{


	/**
	 * Controller constructor sets the login restriction
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		$this->auth->restrict();
		$this->load->model('transcript_model');
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
		
		 
		
				$data['title'] = 'Transcript';
				$this->load->view('admin/templates/header', $data);
				$this->load->view('admin/templates/sidebar');
				$this->load->view('admin/templates/topbar');
				$this->load->view('admin/transcript/index', $data);
				$this->load->view('admin/templates/footer');
				
    }//end index()


 

	
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

		$data= $this->transcript_model->get_paginated_transcripts($pageNum, $pageSize);
		echo json_encode($data);
	}

    public function locations()
    {
        $this->load->model('roles/role_model');

        $user_role = $this->role_model->find($this->current_user->role_id);
        $default_context = ($user_role !== false && isset($user_role->default_context)) ? $user_role->default_context : '';
		 
				$data['title'] = 'Transcript Locations';
				$this->load->view('admin/templates/header', $data);
				$this->load->view('admin/templates/sidebar');
				$this->load->view('admin/templates/topbar');
				$this->load->view('admin/transcript/locations', $data);
				$this->load->view('admin/templates/footer');
				
    }




	public function create(){
       $data ='';
	  	if($this->input->post('submit')) {
	  	 

	 		  $this->form_validation->set_rules('name', 'Name', 'required');
	 		  $this->form_validation->set_rules('price', 'Price', 'required');
	 		  if ($this->form_validation->run() == FALSE){
                     $data['error'] = 'Form validation failed';
                }
                else
                {
                
		
			      $insertStatus=  $this->transcript_model->create_transcript_location($this->input->post());
			     if($insertStatus){
			     		$data['success'] = "Location Successfully Created";
			         }else{
			        	   	  $data['error'] = "Error inserting into the database";
			              }
                }
	  	}
	  		
	  			$data['title'] = 'Transcript Locations';
				$this->load->view('admin/templates/header', $data);
				$this->load->view('admin/templates/sidebar');
				$this->load->view('admin/templates/topbar');
				$this->load->view('admin/transcript/create', $data);
				$this->load->view('admin/templates/footer');
	}


   
	public function paginate_locations(){
		$pageNum = $this->input->get('pageNum');

		$pageSize = $this->input->get('pageSize');
		if(!is_numeric($pageNum)) {
			$pageNum =0;
		}
	
		$pageNum = ($pageNum/$pageSize)+1;



		if($pageSize || !is_numeric($pageSize)){
			$pageSize =10;
		}

		$data= $this->transcript_model->get_paginated_transcript_locations($pageNum, $pageSize);
		echo json_encode($data);
	}


	 
 




}//end class