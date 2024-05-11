<?php
class Departments extends CI_Controller {		
    function __construct() {				
        parent::__construct();					
        $this->load->model('reports_model');		
		$this->load->model('staff_model');	
		$this->load->model('masters_model');	
		$this->load->model('helpline_model');
		$this->load->model('hospital_model');	
		if($this->session->userdata('logged_in')){		
			$userdata=$this->session->userdata('logged_in');      
			$user_id=$userdata['user_id'];      
			$this->data['hospitals']=$this->staff_model->get_hospital();	
			$this->data['functions']=$this->staff_model->user_function($user_id);	
			$this->data['departments']=$this->staff_model->user_department($user_id);	
		}
		$this->data['op_forms']=$this->staff_model->get_forms("OP");		
		$this->data['ip_forms']=$this->staff_model->get_forms("IP");					
	}

	// Newly Modified
	function add_department($record_id='')
	{
		if($this->session->userdata('logged_in'))
		{     
			$access=0;
			$userdata=$this->session->userdata('logged_in');
			$user_id=$userdata['user_id'];
			$this->data['functions']=$this->staff_model->user_function($user_id);
			foreach($this->data['functions'] as $function)
			{
				if($function->user_function=="Admin"){
					$access = 1;
					break;
				}
			}
			if($access==1)
			{
				$this->load->helper('form');
				$this->data['title']="Add Department";
				$this->data['userdata']=$this->session->userdata('logged_in');
				$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
				foreach($this->data['defaultsConfigs'] as $default){		 
					if($default->default_id=='pagination'){
							$this->data['rowsperpage'] = $default->value;
							$this->data['upper_rowsperpage']= $default->upper_range;
							$this->data['lower_rowsperpage']= $default->lower_range;	 

						}
					}
					if (!empty($this->input->post('department')))
					{
						$hospital_id = $this->session->userdata('hospital')['hospital_id'];
						$hospital = $hospital_id;
						$department=$this->input->post('department');
						$description=$this->input->post('description');
						$lab_report_staff_id=$this->input->post('lab_report_staff_id');
						$department_email=$this->input->post('department_email');
						$number_of_units=$this->input->post('number_of_units');
						$op_room_no=$this->input->post('op_room_no');
						$clinical = $this->input->post('optradio');
						$floor=$this->input->post('floor');
						$mon=$this->input->post('mon');
						$tue=$this->input->post('tue');
						$wed=$this->input->post('wed');
						$thr=$this->input->post('thr');
						$fri=$this->input->post('fri');
						$sat=$this->input->post('sat');
						if($this->hospital_model->check_department($department,$hospital)) 
						{
							$this->data['error'] = 'Department already exists';
						}
						else
						{
							$data_to_insert = array(
								'hospital_id' => $hospital,
								'department' => $department,
								'description' => $description,
								'lab_report_staff_id' => $lab_report_staff_id,
								'department_email' => $department_email,
								'number_of_units' => $number_of_units,
								'op_room_no' => $op_room_no,
								'clinical' => $clinical,
								'floor' => $floor,
								'mon' => $mon,
								'tue' => $tue,
								'wed' => $wed,
								'thr' => $thr,
								'fri' => $fri,
								'sat' => $sat,
							);
							$this->hospital_model->insert_department($data_to_insert);
							$this->data['success'] = 'Department Added Successfully';
						}
					}
					// Fetch all records from primary table
					$this->data['get_all_departments']=$this->hospital_model->get_all_departments($this->data['rowsperpage']);
					$this->data['get_all_departments_count']=$this->hospital_model->get_all_departments_count();
					//Fetch record to edit
					$this->data['edit_departments'] = $this->hospital_model->get_edit_departments_by_id($record_id);
					
					$this->load->view('templates/header',$this->data);
					$this->load->view('templates/leftnav',$this->data);
					$this->load->view('pages/department_view',$this->data);
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

	function update_department() 
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
				$this->data['title']="Add Department";
				$this->data['userdata']=$this->session->userdata('logged_in');
				$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
				foreach($this->data['defaultsConfigs'] as $default){		 
					if($default->default_id=='pagination'){
							$this->data['rowsperpage'] = $default->value;
							$this->data['upper_rowsperpage']= $default->upper_range;
							$this->data['lower_rowsperpage']= $default->lower_range;	 

						}
					}
					$hospital_id = $this->session->userdata('hospital')['hospital_id'];
					$hospital = $hospital_id;
					$department=$this->input->post('department');
					$description=$this->input->post('description');
					$lab_report_staff_id=$this->input->post('lab_report_staff_id');
					$department_email=$this->input->post('department_email');
					$number_of_units=$this->input->post('number_of_units');
					$op_room_no=$this->input->post('op_room_no');
					$clinical = $this->input->post('optradio');
					$floor=$this->input->post('floor');
					$mon=$this->input->post('mon');
					$tue=$this->input->post('tue');
					$wed=$this->input->post('wed');
					$thr=$this->input->post('thr');
					$fri=$this->input->post('fri');
					$sat=$this->input->post('sat');
					$update_record_id = $this->input->post('record_id');
					if($this->hospital_model->check_department($department,$hospital)) 
					{
						$this->data['error'] = 'Department already exists';
					}else 
					{
						$update_data = array(
								//'hospital_id' => $hospital,
								'department' => $department,
								'description' => $description,
								'lab_report_staff_id' => $lab_report_staff_id,
								'department_email' => $department_email,
								'number_of_units' => $number_of_units,
								'op_room_no' => $op_room_no,
								'clinical' => $clinical,
								'floor' => $floor,
								'mon' => $mon,
								'tue' => $tue,
								'wed' => $wed,
								'thr' => $thr,
								'fri' => $fri,
								'sat' => $sat,
							);
						$this->hospital_model->update_selected_department($update_record_id, $update_data);
						$this->data['success'] = 'Department Updated Successfully';
					}
					
					
				// Fetch all records from primary table
				$this->data['get_all_departments']=$this->hospital_model->get_all_departments($this->data['rowsperpage']);
				$this->data['get_all_departments_count']=$this->hospital_model->get_all_departments_count();

				$this->load->view('templates/header',$this->data);
				$this->load->view('templates/leftnav',$this->data);
				$this->load->view('pages/department_view',$this->data);
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

	function get_all_department() 
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
				$this->data['title']="Add Department";
				$this->data['userdata']=$this->session->userdata('logged_in');
				$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
				foreach($this->data['defaultsConfigs'] as $default){		 
					if($default->default_id=='pagination'){
							$this->data['rowsperpage'] = $default->value;
							$this->data['upper_rowsperpage']= $default->upper_range;
							$this->data['lower_rowsperpage']= $default->lower_range;	 

						}
					}
				// Fetch all records from primary table
				$this->data['get_all_departments']=$this->hospital_model->get_all_departments($this->data['rowsperpage']);
				$this->data['get_all_departments_count']=$this->hospital_model->get_all_departments_count();

				$this->load->view('templates/header',$this->data);
				$this->load->view('templates/leftnav',$this->data);
				$this->load->view('pages/department_view',$this->data);
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


