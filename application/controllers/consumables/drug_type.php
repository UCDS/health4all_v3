<?php
class drug_type extends CI_Controller {										
    function __construct() {
		   parent::__construct();	
		$this->load->model('staff_model');
		if($this->session->userdata('logged_in')){
		$userdata=$this->session->userdata('logged_in');
		$user_id=$userdata['user_id'];
		$this->data['hospitals']=$this->staff_model->user_hospital($user_id);
		$this->data['functions']=$this->staff_model->user_function($user_id);
		$this->data['departments']=$this->staff_model->user_department($user_id);
		}
		$this->data['op_forms']=$this->staff_model->get_forms("OP");
		$this->data['ip_forms']=$this->staff_model->get_forms("IP");
    }   			//end of constructor.
	function add_drug_type(){
		if($this->session->userdata('logged_in')){  						
            $this->data['userdata']=$this->session->userdata('logged_in');  
			
		}	
        else{
            show_404(); 													
        } 
			$access = -1;
		foreach($this->data['functions'] as $function){
            if($function->user_function=="Masters - Consumables"){
                $access = 1;
				break;
            }
		}
		if($access != 1){
			show_404();
		}
			$this->load->helper('form');										
			$this->load->library('form_validation'); 							
			$this->data['title']="Add Drug type";										
			$this->load->view('templates/header', $this->data);				
			$this->load->view('templates/leftnav');	
			$config=array(
               array(
                     'field'   => 'drug_type',
                     'label'   => 'drug type',
                     'rules'   => 'required|trim|xss_clean'
                  ) 	
		     
			);

		$this->load->model('consumables/drug_type_model');
		$this->form_validation->set_rules($config);
		
		if($this->form_validation->run()===FALSE) 							
		{			
		}		
		else
		{
		if($this->drug_type_model->add_drug_type()){							
			$this->data['msg']="Drug Type Added Succesfully";					
		}
		}
			$this->load->view('pages/consumables/drug_type_view',$this->data);							
			$this->load->view('templates/footer');								
    }   		//end of add_drug_type method.					
	}			//end of drug type controller.
