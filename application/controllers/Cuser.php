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

class Cuser extends MX_Controller
{


	/**
	 * Controller constructor sets the login restriction
	 *
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->model('cuser_model');
         $this->load->helper('url_helper');
         $this->load->helper('form');
         $this->load->library('form_validation');
         $this->load->library('session');
         $this->load->helper('url');


	}//end __construct()

	//--------------------------------------------------------------------

    public function index()
    {

      if($this->input->post('base64_file') && $this->input->post('uid') && is_numeric($this->input->post('uid'))) {
      
        $filename = trim(date('Y-m-d-H-i-s').'.jpg');
       

      	$image = $this->base64_to_jpeg($_POST['base64_file'],$filename,$this->input->post('uid'));
      	echo $image;
      	exit();
      }
				
    }//end index()


   public function createImage(){
    echo 'got here';
      echo $_POST['dat'];
   }


    function base64_to_jpeg( $base64_string, $output_file ,$uid) {

      if (!file_exists('uploads/users/'.$uid)) {
        mkdir('uploads/users/'.$uid, 0777, true);
        }

    $ifp = fopen( 'uploads/users/'.$uid.'/'.$output_file, "wb" ); 
    fwrite( $ifp, base64_decode( $base64_string) ); 
    fclose( $ifp ); 
    //move_uploaded_file($output_file, 'uploads/'.$output_file);
    return( 'users/'.$uid.'/'.$output_file ); 
	}


    

}//end class