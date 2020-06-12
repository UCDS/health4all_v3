<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class issue_tracker extends CI_Controller {	

	function __construct(){
		parent::__construct();
		$this->load->model('staff_model');
                $this->load->helper(array('form', 'url')); 
		if($this->session->userdata('logged_in')){
		$userdata=$this->session->userdata('logged_in');
		$user_id=$userdata['user_id'];
		$this->data['hospitals']=$this->staff_model->user_hospital($user_id);
		$this->data['functions']=$this->staff_model->user_function($user_id);
		$this->data['departments']=$this->staff_model->user_department($user_id);
		}
		$this->data['op_forms']=$this->staff_model->get_forms("OP");
		$this->data['ip_forms']=$this->staff_model->get_forms("IP");
                 parent::__construct(); 
                 $this->load->helper(array('form', 'url'));
	}

 // issue_tracker controller is calling the do upload method for upload the files   
        public function index()
	{
			$this->data['title']="issue_tracker";
			$this->load->view('templates/header',$this->data);
                        $this->load->view('pages/issue_tracker');
                        $this->load->view('templates/footer');
        }
       public function do_upload() { 
		 
		  
         $config['upload_path']   = './uploads/' ; 
         $config['allowed_types'] = 'gif|jpg|png|jpeg|txt';
         $config['overwrite']   = FALSE;
         $config['max_size']      = 4000*20; 
         $config['max_width']     = 1024; 
         $config['max_height']    = 768;
		
		
		
         $this->load->library('upload', $config);
			
         if ( ! $this->upload->do_upload('userfile')) {
            $error = array('error' => $this->upload->display_errors()); 
            $this->load->view('issue_tracker', $error); 
         }
			
         else { 
            $data = array('upload_data' => $this->upload->data());
            $this->load->view('templates/header',$this->data);
            $this->load->view('pages/upload_success', $data); 
            $this->load->view('templates/footer');
         } 
      }   
        
}