<?php
class Generic_item extends CI_Controller {										
    function __construct() {
		parent::__construct();	
			$this->load->model('staff_model');
				if($this->session->userdata('logged_in')){
					$userdata=$this->session->userdata('logged_in');
					$user_id=$userdata['user_id'];
					$this->data['hospitals']=$this->staff_model->user_hospital($user_id);
					$this->data['functions']=$this->staff_model->user_function($user_id);
					$this->data['departments']=$this->staff_model->user_department($user_id);
				}//end of if
			$this->data['op_forms']=$this->staff_model->get_forms("OP");
			$this->data['ip_forms']=$this->staff_model->get_forms("IP");
    } 		//end of constructor	
	function add_generic(){
		if($this->session->userdata('logged_in')){  						
            $this->data['userdata']=$this->session->userdata('logged_in');  
			
		}	//end of if
        else{
            show_404(); 													
        } 	//end of else
			$access = -1;
		foreach($this->data['functions'] as $function){
            if($function->user_function=="Masters - Consumables"){
                $access = 1;
				break;
            }		//end of if
		}	//end of foreach
		if($access != 1){
			show_404();
		}		//end of if.
		$this->load->helper('form');										
		$this->load->library('form_validation'); 							
		$this->data['title']="Add generic_item";										
		$this->load->view('templates/header', $this->data);				
		$this->load->view('templates/leftnav');	
		$config=array(
             array(
                    'field'   => 'generic_name',
                    'label'   => 'Generic Name',
                    'rules'   => 'required|trim|xss_clean'
                  ) 	
		     
			);

		$this->load->model('consumables/generic_model');
		$this->data['item_type']=$this->generic_model->get_data("item_type");
		$this->data['drug_type']=$this->generic_model->get_data("drug_type");
		$this->form_validation->set_rules($config);
		
		if($this->form_validation->run()===FALSE) 							
		{
		}		
		else
		{
		if($this->generic_model->add_generic()){							
			$this->data['msg']="Generic Added Succesfully";					
		}
		}
			$this->load->view('pages/consumables/add_generic_form',$this->data);							
			$this->load->view('templates/footer');								
    }   											
	}
