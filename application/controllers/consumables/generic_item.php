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


	function item_type_valid($item_type_id)
	{
		$res = $this->generic_model->check_if_exists("item_type", $item_type_id);
		log_message("INFO", "SAIRAM generic item ".json_encode($res));
		return count($res) > 0;
	}
	
	function item_form_valid($item_form_id)
	{
		$res = $this->generic_model->check_if_exists("item_form", $item_form_id);
		return count($res) > 0;
	}
	function drug_type_valid($drug_type_id)
	{
		$res = $this->generic_model->check_if_exists("drug_type", $drug_type_id);
		return ($drug_type_id === null || count($res) > 0);
	}

	function generic_items_list(){
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
		$this->data['title']="Generic item";										
		$this->load->view('templates/header', $this->data);				
		$this->load->view('templates/leftnav');	
		$config=array(
             array(
                    'field'   => 'generic_item_id',
                    'label'   => 'Generic Item Id',
                    'rules'   => 'trim|xss_clean'
			 ), 
			 array(
				'field'   => 'item_type',
				'label'   => 'Item Type',
				'rules'   => 'trim|xss_clean'
			  ) 	
		     
			);

		$this->load->model('consumables/generic_model');
		$this->data['item_type']=$this->generic_model->get_data("item_type");
		$this->data['item_form']=$this->generic_model->get_data("item_form");
		$this->data['drug_type']=$this->generic_model->get_data("drug_type");
		$this->form_validation->set_rules($config);
		
		
		if($this->form_validation->run()===FALSE) 							
		{
			// echo '<p>'.json_encode($this->generic_model->get_generic_items()).'</p>';
			log_message("INFO", "SAIRAM FROM FORM VALIDATION");
			$this->data['search_generic_items'] = $this->generic_model->get_generic_items();
			$this->data['generic_items_count'] = $this->generic_model->list_generic_items_count();
			$this->data['rowsperpage'] = 15;
			$this->data['lower_rowsperpage'] = 1;
			$this->data['upper_rowsperpage'] = 30;	
			log_message("INFO", "SAIRAM ".json_encode($this->data['generic_items_count']));
			$this->load->view('pages/consumables/generic_items_list', $this->data);						
		}		
		else if($this->input->post('search'))
		{
			
			
			$this->data['search_generic_items'] = $this->generic_model->get_generic_items();
			$this->data['generic_items_count'] = $this->generic_model->list_generic_items_count();
			$this->data['rowsperpage'] = 15;
			$this->data['lower_rowsperpage'] = 1;
			$this->data['upper_rowsperpage'] = 30;	
			log_message("INFO", "SAIRAM ".json_encode($this->data['generic_items_count']));
			
			log_message("INFO", json_encode($this->data['search_generic_items']));
			$this->load->view('pages/consumables/generic_items_list', $this->data);		
		}else{
			show_404();
		}
			// $this->load->view('pages/consumables/add_generic_form',$this->data);	
			$this->load->view('templates/footer');								
    }
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
		$this->data['title']="Add generic item";										
		$this->load->view('templates/header', $this->data);				
		$this->load->view('templates/leftnav');	
		$this->load->model('consumables/generic_model');
		$this->data['item_type']=$this->generic_model->get_data("item_type");
		$this->data['drug_type']=$this->generic_model->get_data("drug_type");
		$config=array(
			array(
				   'field'   => 'generic_name',
				   'label'   => 'Generic Name',
				   'rules'   => 'required|trim|xss_clean'
			), 
			array(
				'field'   => 'item_type',
				'label'   => 'Item Type',
				'rules'   => 'required|trim|xss_clean|callback_item_type_valid'
			), 
			array(
				'field'   => 'drug_type',
				'label'   => 'Drug Type',
				'rules'   => 'trim|xss_clean|callback_drug_type_valid'
			), 	
			
	   	);

		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('item_type_valid', "Item type entered is not valid");
		$this->form_validation->set_message('drug_type_valid', "Drug type entered is not valid");
		if($this->form_validation->run()===FALSE) 							
		{
			// echo '<p>'.json_encode($this->generic_model->get_generic_items()).'</p>';
			// $this->data['search_generic_items'] = $this->generic_model->get_generic_items();
			// $this->load->view('pages/consumables/generic_items_list', $this->data);						
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
	function edit(){
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
		$this->data['title']="Edit item";										
		$this->load->view('templates/header', $this->data);				
		$this->load->view('templates/leftnav');	
		

		$this->load->model('consumables/generic_model');
		$this->data['item_type']=$this->generic_model->get_data("item_type");
		$this->data['drug_type']=$this->generic_model->get_data("drug_type");
		
		

		$config=array(
			array(
				   'field'   => 'generic_name',
				   'label'   => 'Generic Name',
				   'rules'   => 'required|trim|xss_clean'
			), 
			array(
				'field'   => 'item_type',
				'label'   => 'Item Type',
				'rules'   => 'required|trim|xss_clean|callback_item_type_valid', 
				
			), 
			array(
				'field'   => 'drug_type',
				'label'   => 'Drug Type',
				'rules'   => 'trim|xss_clean|callback_drug_type_valid',
			), 
			array(
				'field'   => 'generic_item_id',
				'label'   => 'Generic Item',
				'rules'   => 'trim|xss_clean|required'
			)	 	
			
	   	);
		

		$this->form_validation->set_rules($config);
		$this->form_validation->set_message('item_type_valid', "Item type entered is not valid");
		$this->form_validation->set_message('drug_type_valid', "Drug type entered is not valid");
		if($this->form_validation->run() === FALSE) 							
		{
			$generic_item_id = null;
			if($this->input->post('navigate_edit')){
				$generic_item_id = $this->input->post('navigate_edit');
			}else{
				$generic_item_id = $this->input->post('generic_item_id');
			}
			$item_result = $this->generic_model->get_generic_item($generic_item_id);
			// echo '<h3>'."$generic_item_id".json_encode($item_result).'</h3>';
			$this->data['item'] = $item_result[0];
			$this->load->view('pages/consumables/edit_generic_form', $this->data);					
		}		
		else
		{
			$generic_item_id = $this->input->post('generic_item_id');
			if($this->generic_model->edit_generic($generic_item_id)){							
				$this->data['msg']="Generic Item Edited Succesfully";					
					
			}else{
				$this->data['msg']="Failure while editing generic";
			}
			$this->load->view('pages/consumables/generic_items_list',$this->data);
		}
		$this->load->view('templates/footer');								
    }									
}
