<?php
class Item extends CI_Controller {										
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
    }   //end of constructor.
	function add_item(){
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
			$this->data['title']="Add Item";										
			$this->load->view('templates/header', $this->data);				
			$this->load->view('templates/leftnav');	
			$config=array(
               array(
                     'field'   => 'item_name',
                     'label'   => 'item Name',
                     'rules'   => 'required|trim|xss_clean'
                  ) 	
		     
			);

		$this->load->model('consumables/item_model');
		$this->data['generic_name']=$this->item_model->get_data("generic_name");
		$this->data['item_form']=$this->item_model->get_data("item_form");
		$this->form_validation->set_rules($config);
		
		if($this->form_validation->run()===FALSE) 							
		{
			$this->data['message']="validation failed";				
		}		
		else
		{
		if($this->item_model->add_item()){							
			$this->data['msg']="Item Added Succesfully";					
		}
		}
			$this->load->view('pages/consumables/item_view',$this->data);							
			$this->load->view('templates/footer');								
    }   	//end of add_item method										
	}		//end of item controller
