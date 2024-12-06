<?php
class hospital_areas extends CI_Controller{                                           
  function __construct()
  {                                                             
    parent::__construct(); 
    $this->load->model('reports_model');		
    $this->load->model('staff_model');	
    $this->load->model('masters_model');	
    $this->load->model('helpline_model');
    $this->load->model('hospital_model');
    $this->load->model('hospital_model');
    $this->load->model('hospital_areas_model');
    $this->load->model('area_type_model');
        if($this->session->userdata('logged_in'))
        {
            $userdata=$this->session->userdata('logged_in');
            $user_id=$userdata['user_id'];
            $this->data['hospitals']=$this->staff_model->user_hospital($user_id);
            $this->data['functions']=$this->staff_model->user_function($user_id);
            $this->data['departments']=$this->staff_model->user_department($user_id);
        }  
    $this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
    $this->data['op_forms']=$this->staff_model->get_forms("OP");                  //stroing op form details into data array of index:op_forms.
    $this->data['ip_forms']=$this->staff_model->get_forms("IP");  
    $this->data['custom_patient_visit_form'] = $this->masters_model->get_cust_patient_visit_forms();                                                       
  }

   function add_area($record_id='')
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
                $this->data['title']="Add Area";
                $this->data['userdata']=$this->session->userdata('logged_in');
                $this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
                foreach($this->data['defaultsConfigs'] as $default)
                {		 
                    if($default->default_id=='pagination'){
                            $this->data['rowsperpage'] = $default->value;
                            $this->data['upper_rowsperpage']= $default->upper_range;
                            $this->data['lower_rowsperpage']= $default->lower_range;	 

                        }
                }
                if($this->input->post()) 
                {
                    $area_name = $this->input->post('area_name');
                    $department_id = $this->input->post('department_id');
                    $beds = $this->input->post('beds');
                    $area_type_id = $this->input->post('area_type_id');
                    $lab_report_staff_id = $this->input->post('lab_report_staff_id');
                    if(!empty($area_name))
                    {
                        
                        if($this->hospital_areas_model->check_area($area_name,$department_id)) 
                        {
                            $this->data['error'] = 'Area name with department already exists';
                        }
                        else
                        {
                            $data_to_insert = array(
                                'area_name' => $area_name,
                                'department_id' => $department_id,
                                'beds' => $beds,
                                'area_type_id' => $area_type_id,
                                'lab_report_staff_id' => $lab_report_staff_id,
                            );
                            $this->hospital_areas_model->insert_area($data_to_insert);
                            $this->data['success'] = 'Area Added Successfully';
                        }
                    }
                }
                $this->data['all_departments']=$this->staff_model->get_department();  
                $this->data['area_types']=$this->area_type_model->get_area_type();  
                $this->data['lab_report_staff']=$this->staff_model->get_staff();
                // Fetch all records from primary table
                $this->data['all_areas'] = $this->hospital_areas_model->get_all_areas($this->data['rowsperpage']);
                $this->data['all_areas_count'] = $this->hospital_areas_model->get_all_areas_count();

                //Fetch record to edit
                $this->data['edit_area'] = $this->hospital_areas_model->get_edit_edit_area_by_id($record_id);
                
                $this->load->view('templates/header',$this->data);
                $this->load->view('templates/leftnav',$this->data);
                $this->load->view('pages/hospital_area_view',$this->data);
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

    function update_area() 
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
                $this->data['title']="Add Area";
                $this->data['userdata']=$this->session->userdata('logged_in');
                $this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
                foreach($this->data['defaultsConfigs'] as $default){		 
                    if($default->default_id=='pagination'){
                            $this->data['rowsperpage'] = $default->value;
                            $this->data['upper_rowsperpage']= $default->upper_range;
                            $this->data['lower_rowsperpage']= $default->lower_range;	 

                        }
                    }
                    $area_name = $this->input->post('area_name');
                    $beds = $this->input->post('beds');
                    $area_type_id = $this->input->post('area_type_id');
                    $lab_report_staff_id = $this->input->post('lab_report_staff_id');
                    $update_record_id = $this->input->post('record_id');
                    if($this->hospital_areas_model->check_area_name($area_name)) 
                    {
                        $this->data['error'] = 'Area name already exists';
                    }
                    else
                    {
                        $update_data = array(
                            'area_name' => $area_name,
                            'beds' => $beds,
                            'area_type_id' => $area_type_id,
                            'lab_report_staff_id' => $lab_report_staff_id,
                        );
                        $this->hospital_areas_model->update_area($update_record_id, $update_data);
                        $this->data['success'] = 'Area Updated Successfully';
                    }
                
                $this->data['all_departments']=$this->staff_model->get_department();  
                $this->data['area_types']=$this->area_type_model->get_area_type();  
                $this->data['lab_report_staff']=$this->staff_model->get_staff();
                // Fetch all records from primary table
                $this->data['all_areas'] = $this->hospital_areas_model->get_all_areas($this->data['rowsperpage']);
                $this->data['all_areas_count'] = $this->hospital_areas_model->get_all_areas_count();

                $this->load->view('templates/header',$this->data);
                $this->load->view('templates/leftnav',$this->data);
                $this->load->view('pages/hospital_area_view',$this->data);
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

    function get_all_area() 
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
                $this->data['title']="Add Area";
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
                $this->data['all_areas'] = $this->hospital_areas_model->get_all_areas($this->data['rowsperpage']);
                $this->data['all_areas_count'] = $this->hospital_areas_model->get_all_areas_count();

                $this->load->view('templates/header',$this->data);
                $this->load->view('templates/leftnav',$this->data);
                $this->load->view('pages/hospital_area_view',$this->data);
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