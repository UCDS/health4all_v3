<?php
class drug_type extends CI_Controller {										
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
    }   			

	function add_drug_type($record_id='')
	{
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
			$this->data['title']="Drug Type";										
			$this->load->view('templates/header', $this->data);				
			$this->load->view('templates/leftnav');	
			$this->load->model('consumables/drug_type_model');
		if($this->input->post()) 
		{
			$drug_type = $this->input->post('drug_type');
			$description = $this->input->post('description');
			$added_by = $this->input->post('added_by');
			$insert_datetime = $this->input->post('insert_datetime');
			if($this->drug_type_model->check_drug_type($drug_type,$description)) 
			{
				if(!empty($this->input->post('drug_type')))
				{
					$this->data['error'] = 'Drug Type already exists';
				}
			}
			else
			{
				if(!empty($this->input->post('drug_type')))
				{
					$data_to_insert = array(
						'drug_type' => $drug_type,
						'description' => $description,
						'created_by' => $added_by,
						'created_date_time' => $insert_datetime,
					);
					$this->drug_type_model->add_drug_type($data_to_insert);
					$this->data['success'] = 'Drug Type Added Succesfully';
				}
			}
		}
			// Fetch all records from primary table
			$this->data['all_drug_type'] = $this->drug_type_model->get_all_drug_type($this->data['rowsperpage']);
			$this->data['all_drug_type_count'] = $this->drug_type_model->get_all_drug_type_count();
			//Fetch record to edit
			$this->data['edit_drug_type'] = $this->drug_type_model->get_edit_drug_type_id($record_id);
		
			$this->load->view('pages/consumables/drug_type_view',$this->data);							
			$this->load->view('templates/footer');								
    }  
	
	function update_drug_type()
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper('form');
			$this->load->model('consumables/drug_type_model');
			$this->data['title']="Drug Type";
			$this->data['userdata']=$this->session->userdata('logged_in');
			$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
			foreach($this->data['defaultsConfigs'] as $default){		 
				if($default->default_id=='pagination'){
						$this->data['rowsperpage'] = $default->value;
						$this->data['upper_rowsperpage']= $default->upper_range;
						$this->data['lower_rowsperpage']= $default->lower_range;	 

					}
				}
				$update_record_id = $this->input->post('record_id');
				$drug_type = $this->input->post('drug_type');
				$description = $this->input->post('description');
				$updated_by = $this->input->post('updated_by');
				$update_datetime = $this->input->post('updated_datetime');
				if($this->drug_type_model->check_drug_type($drug_type,$description)) 
				{
					$this->data['error'] = 'Drug Type Cannot Be Updated Combination Already Exists';
				}else
				{
					$update_data = array(
						'drug_type' => $drug_type,
						'description' => $description,
						'updated_by' => $updated_by,
						'updated_date_time' => $update_datetime,
					);
					$this->drug_type_model->update_drug_type($update_record_id, $update_data);
					$this->data['success'] = 'Drug Type Updated Successfully';
				}
			// Fetch all records from primary table
			$this->data['all_drug_type'] = $this->drug_type_model->get_all_drug_type($this->data['rowsperpage']);
			$this->data['all_drug_type_count'] = $this->drug_type_model->get_all_drug_type_count();

			$this->load->view('templates/header',$this->data);
			$this->load->view('templates/leftnav',$this->data);
			$this->load->view('pages/consumables/drug_type_view',$this->data);	
			$this->load->view('templates/footer');
		}
		else
		{
			show_404();
		}						
    }  

}			
