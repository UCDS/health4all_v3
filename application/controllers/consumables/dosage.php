<?php
class dosage extends CI_Controller {										
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
    }   		//end of constructor.

	function add_dosage($record_id='')
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
			$this->data['title']="Add Dosage";										
			$this->load->view('templates/header', $this->data);				
			$this->load->view('templates/leftnav');	

			$this->load->model('consumables/dosage_model');
		
		if($this->input->post()) 
		{
			$dosage = $this->input->post('dosage');
			$dosage_unit = $this->input->post('dosage_unit');
			$added_by = $this->input->post('added_by');
			$insert_datetime = $this->input->post('insert_datetime');
			if($this->dosage_model->check_dosage($dosage,$dosage_unit)) 
			{
				if(!empty($this->input->post('dosage'))) 
				{
					$this->data['error'] = 'Dosage and Dosage Unit already exists';
				}
			}
			else
			{
				if(!empty($this->input->post('dosage'))) 
				{
					$data_to_insert = array(
						'dosage' => $dosage,
						'dosage_unit' => $dosage_unit,
						'created_by' => $added_by,
						'created_date_time' => $insert_datetime,
					);
					$this->dosage_model->add_dosage($data_to_insert);
					$this->data['success'] = 'Dosage and Dosage Unit Added Successfully';
				}
			}
		}
		// Fetch all records from primary table
		$this->data['all_dosage_type'] = $this->dosage_model->get_all_dosage_type($this->data['rowsperpage']);
		$this->data['all_dosage_type_count'] = $this->dosage_model->get_all_dosage_type_count();

		//Fetch record to edit
		$this->data['edit_dosage_type'] = $this->dosage_model->get_edit_dosage_type_id($record_id);

		$this->load->view('pages/consumables/dosage_view',$this->data);							
		$this->load->view('templates/footer');								
    } 
	
	function update_dosage()
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper('form');
			$this->load->model('consumables/dosage_model');
			$this->data['title']="Add Dosage";
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
				$dosage = $this->input->post('dosage');
				$dosage_unit = $this->input->post('dosage_unit');
				$updated_by = $this->input->post('updated_by');
				$update_datetime = $this->input->post('updated_datetime');
				if($this->dosage_model->check_dosage($dosage,$dosage_unit)) 
				{
					$this->data['error'] = 'Dosage and Dosage Unit Cannot Be Updated Combination Already Exists';
				}else
				{
					$update_data = array(
						'dosage' => $dosage,
						'dosage_unit' => $dosage_unit,
						'updated_by' => $updated_by,
						'updated_date_time' => $update_datetime,
					);
					$this->dosage_model->update_dosage_type($update_record_id, $update_data);
					$this->data['success'] = 'Dosage and Dosage Unit Updated Successfully';
				}
			// Fetch all records from primary table
			$this->data['all_dosage_type'] = $this->dosage_model->get_all_dosage_type($this->data['rowsperpage']);
			$this->data['all_dosage_type_count'] = $this->dosage_model->get_all_dosage_type_count();

			$this->load->view('templates/header',$this->data);
			$this->load->view('templates/leftnav',$this->data);
			$this->load->view('pages/consumables/dosage_view',$this->data);		
			$this->load->view('templates/footer');
		}
		else
		{
			show_404();
		}						
    }
}				