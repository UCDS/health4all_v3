<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class documentation extends CI_Controller {
	function __construct(){
        parent::__construct();
        // Load Models used by documentation Controller
        // staff_model for getting User Credentials
        $this->load->model('staff_model');

        // masters_model for getting default configurations for file uploads
        $this->load->model('masters_model');

        // documentation_model for queries to view, add and edit 
        // user documentation records and files
        $this->load->model('documentation_model');

        // Fetch model data only if user has logged in
		if($this->session->userdata('logged_in')){
		    $userdata=$this->session->userdata('logged_in');
		    $user_id=$userdata['user_id'];
		    $this->data['hospitals']=$this->staff_model->user_hospital($user_id);
		    $this->data['functions']=$this->staff_model->user_function($user_id);
            $this->data['departments']=$this->staff_model->user_department($user_id);
		    $this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");        
		}
	}

    // Method for Index page
	public function index()
	{
			$this->data['title']="User Documents";
            $this->load->view('templates/header',$this->data);
            $this->load->view('pages/documentation_view');
            $this->load->view('templates/footer');
    }
    
    // Method for displaying User Documents
	public function documents()
	{
            // Validate user access for this method
            if($this->session->userdata('logged_in')){
                $this->data['userdata']=$this->session->userdata('logged_in');
                $access=0;
                $add_access=0;

                // Fetch user functions and check if the user has 
                // access to documentation access rights
                foreach($this->data['functions'] as $function){
                    if($function->user_function=="documentation"){
                            $access=1;
                            if ($function->add==1) $add_access=1;
                            
                    }
                
                }

                // Initialize Model and View for documentation controller
                if($access==1){
                    $this->data['title']="User Documents";
                    $this->load->view('templates/header',$this->data);
                    $this->load->helper('form');
                    $this->load->library('form_validation');
                    $this->data['add_access']=$add_access;
                    $this->data['report']=$this->documentation_model->get_documentation();
                    $this->load->view('pages/documentation_view',$this->data);
                    $this->load->view('templates/footer');
                }
                else{
                    show_404();
                }
            }
        else{
            show_404();
        }
    }

    // Method for adding User Documents 
	function add_document(){

        // Validate user access for this method
		if($this->session->userdata('logged_in')){  						
            $this->data['userdata']=$this->session->userdata('logged_in');  
			
		}	
        else{
            show_404(); 													
        } 
		$access = -1;
		foreach($this->data['functions'] as $function){
            if($function->user_function=="documentation" && $function->add == 1 ){
                $access = 1;
				break;
            }
		}
		if ($access != 1){
			show_404();
        }

        // Fetch user document upload defaults
        foreach($this->data['defaultsConfigs'] as $default){
            if ($default->default_id == "udoc_allowed_types"){
               $allowed_types = $default->value;
            }
            if ($default->default_id == "udoc_max_size"){
                $max_size = $default->value;
            }
            if ($default->default_id == "udoc_max_width"){
                $max_width = $default->value;
            }
            if ($default->default_id == "udoc_max_height"){
                $max_height = $default->value;
            }
            if ($default->default_id == "udoc_remove_spaces"){
                $remove_spaces = $default->value;
            }
            if ($default->default_id == "udoc_overwrite"){
                $overwrite = $default->value;
            }                                   
        }        
        $this->load->helper('form');										
		$this->load->library('form_validation'); 							
		$this->data['title']="Add Document";										
		$this->load->view('templates/header', $this->data);				
        $this->load->view('templates/leftnav');
        
        // Set field validation rules
		$config=array(
            array(
                'field'   => 'keyword',
                'label'   => 'keyword',
                'rules'   => 'required|trim|xss_clean'
            ),
            array(
                'field'   => 'topic',
                'label'   => 'topic',
                'rules'   => 'required|trim|xss_clean'
            ),
            array(
                'field'   => 'document_date',
                'label'   => 'document_date',
                'rules'   => 'required|trim|xss_clean'
            )		     
		);

		$this->load->model('documentation_model');
		$this->form_validation->set_rules($config);
		
		if($this->form_validation->run()===FALSE) 							
		{			
		}		
		else
		{        
            $dir_path = './assets/user_documents/';
            $config['upload_path'] = $dir_path;
            $config['allowed_types'] = $allowed_types;
            $config['max_size'] = $max_size;
            $config['max_width'] = $max_width;
            $config['max_height'] = $max_height;
            $config['encrypt_name'] = FALSE;
            $config['overwrite'] = $overwrite;
            $config['remove_spaces'] = $remove_spaces;
 
            // Upload file and add document record
            $msg = "Error: ";
            $uploadOk = 1;
            $target_file = $dir_path . basename($_FILES["upload_file"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            if ($_FILES['upload_file']['size'] <= 0 && $uploadOk == 1) {
                $msg = $msg . "Select at least one file.";
                $uploadOk = 0;
            }

            // Check for upload errors
            if ($uploadOk == 0) {
                $this->data['msg']= $msg . " Your file was not uploaded.";
            }
            else {
                // if everything is ok, try to upload file
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('upload_file')) {
                    $msg = $msg . $this->upload->display_errors();
                    $uploadOk = 0;
                } else {
                    $file = $this->upload->data();
                    $uploadOk = 1;
                }
            }

            // Add document record
		    if ($uploadOk ==1 && $this->documentation_model->add_document($file['file_name'])){							
                $this->data['msg']="Document Added Succesfully";					
            }
            else {
                $this->data['msg'] = $msg;
            }
		}
		$this->load->view('pages/add_document_view',$this->data);							
		$this->load->view('templates/footer');								
    }     
}