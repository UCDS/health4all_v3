<?php
class Item extends CI_Controller {										
    function __construct() {
		   parent::__construct();	
		$this->load->model('staff_model');
		$this->load->model('masters_model');
		if($this->session->userdata('logged_in')){
		$userdata=$this->session->userdata('logged_in');
		$user_id=$userdata['user_id'];
		$this->data['hospitals']=$this->staff_model->user_hospital($user_id);
		$this->data['functions']=$this->staff_model->user_function($user_id);
		$this->data['departments']=$this->staff_model->user_department($user_id);
		}
		$this->data['op_forms']=$this->staff_model->get_forms("OP");
		$this->data['ip_forms']=$this->staff_model->get_forms("IP");
		$this->data['custom_patient_visit_form'] = $this->masters_model->get_cust_patient_visit_forms();
    }   //end of constructor.


	function item_form_valid($item_form_id)
	{
		$res = $this->item_model->check_if_exists("item_form", $item_form_id);
		return count($res) > 0;
	}
	function generic_item_valid($generic_item_id)
	{
		$res = $this->item_model->check_if_exists("generic_name", $generic_item_id);
		return count($res) > 0;
	}
	function items_list(){
		if($this->session->userdata('logged_in')){  						
            $this->data['userdata']=$this->session->userdata('logged_in');  
			$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
			foreach($this->data['defaultsConfigs'] as $default){		 
				if($default->default_id=='pagination'){
						$this->data['rowsperpage'] = $default->value;
						$this->data['upper_rowsperpage']= $default->upper_range;
						$this->data['lower_rowsperpage']= $default->lower_range;	 
   
					}
			   }
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
			$this->data['title']="Item";										
			$this->load->view('templates/header', $this->data);				
			$this->load->view('templates/leftnav');	
			
			$config=array(
				array(
					   'field'   => 'item_id',
					   'label'   => 'Item Id',
					   'rules'   => 'trim|xss_clean'
				), 
				array(
				   'field'   => 'item_type',
				   'label'   => 'Item Type',
				   'rules'   => 'trim|xss_clean'
				 ) 	
				
			   );

		$this->load->model('consumables/item_model');
		$this->data['generic_item']=$this->item_model->get_data("generic_name");
		$this->data['item_form']=$this->item_model->get_data("item_form");
		$this->data['item_type']=$this->item_model->get_data("item_type");
		$this->form_validation->set_rules($config);
		
		if($this->form_validation->run()===FALSE) 							
		{
			$this->data['message']="validation failed";	
			$this->data['search_items'] = $this->item_model->get_items($this->data['rowsperpage']);
			$this->data['items_count'] = $this->item_model->list_items_count();
			log_message("INFO", "SAIRAM ".json_encode($this->data['items_count']));
			$this->load->view('pages/consumables/items_list', $this->data);	
		}		
		else if($this->input->post('search'))
		{
			$this->data['search_items'] = $this->item_model->get_items($this->data['rowsperpage']);
			$this->data['items_count'] = $this->item_model->list_items_count();	
			log_message("INFO", "SAIRAM ".json_encode($this->data['items_count']));
			
			
			log_message("INFO", json_encode($this->data['search_items']));
			$this->load->view('pages/consumables/items_list', $this->data);		
		}else{
			show_404();
		}
									
		$this->load->view('templates/footer');								
    }

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
                     'label'   => 'Item Name',
                     'rules'   => 'required|trim|xss_clean|is_unique[item.item_name]', 
					 'errors' => array(
						'is_unique[item.item_name]' => 'Item with same name already exists'
					 )
				), 
				array(
					'field'   => 'generic_name',
					'label'   => 'Generic Name',
					'rules'   => 'required|trim|xss_clean|callback_generic_item_valid', 
					'errors' => array(
						'generic_item_valid' => 'Generic Item entered is not valid'
					)
				), 
				array(
					'field'   => 'item_form',
					'label'   => 'Item Form',
					'rules'   => 'required|trim|xss_clean|callback_item_form_valid', 
					'errors' => array(
					   'item_form_valid' => 'Item Form entered is not valid'
					)
				)   	
		     
			);



		$this->load->model('consumables/item_model');
		$this->data['generic_name']=$this->item_model->get_data("generic_name");
		$this->data['item_form']=$this->item_model->get_data("item_form");
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message("generic_item_valid", "Generic Item entered is not valid");
		$this->form_validation->set_message("item_form_valid", "Item Form entered is not valid");
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
	
	function edit()
	{
		if($this->session->userdata('logged_in')){  						
            $this->data['userdata']=$this->session->userdata('logged_in');  
			$this->data['userdata']=$this->session->userdata('logged_in');  
			$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
			foreach($this->data['defaultsConfigs'] as $default){		 
				if($default->default_id=='pagination'){
						$this->data['rowsperpage'] = $default->value;
						$this->data['upper_rowsperpage']= $default->upper_range;
						$this->data['lower_rowsperpage']= $default->lower_range;	 
	
					}
				}
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
                     'label'   => 'Item Name',
                     'rules'   => 'required|trim|xss_clean'
					 
				), 
				array(
					'field'   => 'generic_item',
					'label'   => 'Generic Name',
					'rules'   => 'required|trim|xss_clean|callback_generic_item_valid', 
					'errors' => array(
						'generic_item_valid' => 'Generic Item entered is not valid'
					)
				), 
				array(
					'field'   => 'item_form',
					'label'   => 'Item Form',
					'rules'   => 'required|trim|xss_clean|callback_item_form_valid', 
					'errors' => array(
					   'item_form_valid' => 'Item Form entered is not valid'
					)
				)   	
		     
			);



		$this->load->model('consumables/item_model');
		$this->data['generic_item']=$this->item_model->get_data("generic_name");
		$this->data['item_type'] = $this->item_model->get_data("item_type");
		$this->data['item_form']=$this->item_model->get_data("item_form");
		$this->form_validation->set_rules($config);
		$this->form_validation->set_message("generic_item_valid", "Generic Item entered is not valid");
		$this->form_validation->set_message("item_form_valid", "Item Form entered is not valid");
		if($this->form_validation->run()===FALSE) 							
		{
			$item_id = null;
			if($this->input->post('navigate_edit')){
				$item_id = $this->input->post('navigate_edit');
			}else{
				$item_id = $this->input->post('item_id');
			}
			$item_result = $this->item_model->get_item($item_id);
			$this->data['item'] = $item_result[0];
			log_message("INFO", "SAIRAM ".json_encode($this->data['item']));
			$this->load->view('pages/consumables/edit_item_view', $this->data);			
		}		
		else
		{
			$item_id = $this->input->post('item_id');
			if($this->item_model->edit_item($item_id)){						
				$this->data['msg']="Item Edited Succesfully";					
			}
			$this->data['search_items'] = $this->item_model->get_items($this->data['rowsperpage']);
			$this->data['items_count'] = $this->item_model->list_items_count();
			$this->load->view("pages/consumables/items_list", $this->data);
		}
			// $this->load->view('pages/consumables/edit_item_view',$this->data);							
			$this->load->view('templates/footer');								
    }   	//end of add_item method
}		//end of item controller
