<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hospital_units extends CI_Controller
{
    function __construct(){                                                         
		parent::__construct();														
		$this->load->model('staff_model');	
		$this->load->model('hospital_unit_model');
		$this->load->model('reports_model');		
		$this->load->model('staff_model');	
		$this->load->model('masters_model');	
		$this->load->model('helpline_model');
		$this->load->model('hospital_model'); 										
		if($this->session->userdata('logged_in')){									
		$userdata=$this->session->userdata('logged_in');                            
		$user_id=$userdata['user_id'];												
		$this->data['hospitals']=$this->staff_model->user_hospital($user_id);		
		$this->data['functions']=$this->staff_model->user_function($user_id);		
		$this->data['departments']=$this->staff_model->user_department($user_id);	
		}
		$this->data['op_forms']=$this->staff_model->get_forms("OP");				
		$this->data['ip_forms']=$this->staff_model->get_forms("IP");				
    }

	function add_unit($record_id='')
	{
		if($this->session->userdata('logged_in'))
		{
			$access=0;
			$userdata=$this->session->userdata('logged_in');
			$user_id=$userdata['user_id'];
			$this->data['functions']=$this->staff_model->user_function($user_id);
			foreach($this->data['functions'] as $function){
				if($function->user_function=="Admin"){
					$access = 1;
					break;
				}
			}
			if($access==1)
			{
				$this->load->helper('form');
				$this->data['title']="Unit Details";
				$this->data['userdata']=$this->session->userdata('logged_in');
				$this->data['all_departments']=$this->staff_model->get_department(); 
				$this->data['lab_report_staff']=$this->staff_model->get_staff();
				$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
				foreach($this->data['defaultsConfigs'] as $default){		 
					if($default->default_id=='pagination'){
							$this->data['rowsperpage'] = $default->value;
							$this->data['upper_rowsperpage']= $default->upper_range;
							$this->data['lower_rowsperpage']= $default->lower_range;	 

						}
					}
					if ($this->input->post()) 
					{
						$unit_name = $this->input->post('unit_name');
						$department_id = $this->input->post('department_id');
						$beds = $this->input->post('beds');
						$lab_report_staff_id = $this->input->post('lab_report_staff_id');
						$unit_head_staff_id = $this->input->post('unit_head_staff_id');
						if($this->hospital_unit_model->check_unit_department($unit_name,$department_id)) 
						{
							$this->data['error'] = 'Unit name with department already exists';
						}
						else
						{
							$data_to_insert = array(
								'unit_name' => $unit_name,
								'department_id' => $department_id,
								'beds' => $beds,
								'lab_report_staff_id' => $lab_report_staff_id,
								'unit_head_staff_id' => $unit_head_staff_id,
							);
							$this->hospital_unit_model->add_unit($data_to_insert);
							$this->data['success'] = 'Unit name added succesfully';
						}
					}
					// Fetch all records from primary table
					$this->data['all_unit_name'] = $this->hospital_unit_model->get_all_unit_name($this->data['rowsperpage']);
					$this->data['all_unit_name_count'] = $this->hospital_unit_model->get_all_unit_name_count();

					//Fetch record to edit
					$this->data['edit_unit_name'] = $this->hospital_unit_model->get_edit_unit_name_by_id($record_id);
					
					$this->load->view('templates/header',$this->data);
					$this->load->view('templates/leftnav',$this->data);
					$this->load->view('pages/hospital_unit_view',$this->data);
					$this->load->view('templates/footer');	
			}
			else
			{
				show_404();
			}	
		}
		else
		{
            show_404();
        }
	}

	function update_unit() 
	{
		if($this->session->userdata('logged_in'))
		{
			$access=0;
			$userdata=$this->session->userdata('logged_in');
			$user_id=$userdata['user_id'];
			$this->data['functions']=$this->staff_model->user_function($user_id);
			foreach($this->data['functions'] as $function){
				if($function->user_function=="Admin"){
					$access = 1;
					break;
				}
			}
			if($access==1)
			{
				$this->load->helper('form');
				$this->data['title']="Unit Details";
				$this->data['userdata']=$this->session->userdata('logged_in');
				$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
				foreach($this->data['defaultsConfigs'] as $default){		 
					if($default->default_id=='pagination'){
							$this->data['rowsperpage'] = $default->value;
							$this->data['upper_rowsperpage']= $default->upper_range;
							$this->data['lower_rowsperpage']= $default->lower_range;	 

						}
					}
					$unit_name = $this->input->post('unit_name');
					$beds = $this->input->post('beds');
					$lab_report_staff_id = $this->input->post('lab_report_staff_id');
					$unit_head_staff_id = $this->input->post('unit_head_staff_id');
					$update_record_id = $this->input->post('record_id');
					if($this->hospital_unit_model->check_unit_name($unit_name)) 
					{
						$this->data['error'] = 'Unit name already exists';
					}
					else
					{
						$update_data = array(
							'unit_name' => $unit_name,
							'beds' => $beds,
							'lab_report_staff_id' => $lab_report_staff_id,
							'unit_head_staff_id' => $unit_head_staff_id,
						);
						$this->hospital_unit_model->update_unit($update_record_id, $update_data);
						$this->data['success'] = 'Unit name Updated Successfully';
					}
				// Fetch all records from primary table
				$this->data['all_unit_name'] = $this->hospital_unit_model->get_all_unit_name($this->data['rowsperpage']);
				$this->data['all_unit_name_count'] = $this->hospital_unit_model->get_all_unit_name_count();

				$this->load->view('templates/header',$this->data);
				$this->load->view('templates/leftnav',$this->data);
				$this->load->view('pages/hospital_unit_view',$this->data);
				$this->load->view('templates/footer');
			}
			else
			{
				show_404();
			}
		}
		else
		{
			show_404();
		}	
    }
}
?>

  
