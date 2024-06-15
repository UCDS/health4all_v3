<?php
class hospital_beds extends CI_Controller{                                           
  function __construct()
  {                                                             
    parent::__construct(); 
    $this->load->model('reports_model');		
    $this->load->model('staff_model');	
    $this->load->model('masters_model');	
    $this->load->model('helpline_model');
    $this->load->model('hospital_model');
    $this->load->model('hospital_beds_model');
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
  }

   function add_hospital_beds($record_id='')
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
                $this->data['title']="Add Bed";
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
                    //$department_id = $this->input->post('department_id');
                    $beds = $this->input->post('bed_name');
                    if(!empty($beds))
                    {
                        //if($this->hospital_beds_model->check_area($beds,$department_id))
                        if($this->hospital_beds_model->check_bed($beds)) 
                        {
                            $this->data['error'] = 'Bed name with hospital already exists';
                        }
                        else
                        {
                            $hospital=$this->session->userdata('hospital');
                            $data_to_insert = array(
                                //'department_id' => $department_id,
                                'bed' => $beds,
                                'hospital_id' => $hospital['hospital_id'],
                            );
                            $this->hospital_beds_model->insert_bed($data_to_insert);
                            $this->data['success'] = 'Bed Added Successfully';
                        }
                    }
                }
                //$this->data['all_departments']=$this->staff_model->get_department();  
                // Fetch all records from primary table
                $this->data['all_beds'] = $this->hospital_beds_model->get_all_beds($this->data['rowsperpage']);
                $this->data['all_beds_count'] = $this->hospital_beds_model->get_all_beds_count();
                //Fetch record to edit
                $this->data['edit_bed'] = $this->hospital_beds_model->get_edit_bed_by_id($record_id);
                $this->load->view('templates/header',$this->data);
                $this->load->view('templates/leftnav',$this->data);
                $this->load->view('pages/hospital_beds_view',$this->data);
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

    function update_hospital_beds() 
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
                $this->data['title']="Add Bed";
                $this->data['userdata']=$this->session->userdata('logged_in');
                $this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
                foreach($this->data['defaultsConfigs'] as $default){		 
                    if($default->default_id=='pagination'){
                            $this->data['rowsperpage'] = $default->value;
                            $this->data['upper_rowsperpage']= $default->upper_range;
                            $this->data['lower_rowsperpage']= $default->lower_range;	 

                        }
                    }
                    $beds = $this->input->post('bed_name');
                    $update_record_id = $this->input->post('record_id');
                    if($this->hospital_beds_model->check_bed($beds)) 
                    {
                        $this->data['error'] = 'Bed name already exists';
                    }
                    else
                    {
                        $update_data = array(
                            'bed' => $beds,
                        );
                        $this->hospital_beds_model->update_beds($update_record_id, $update_data);
                        $this->data['success'] = 'Bed Name Updated Successfully';
                    }
                
                //$this->data['all_departments']=$this->staff_model->get_department();  
                // Fetch all records from primary table
                $this->data['all_beds'] = $this->hospital_beds_model->get_all_beds($this->data['rowsperpage']);
                $this->data['all_beds_count'] = $this->hospital_beds_model->get_all_beds_count();
                $this->load->view('templates/header',$this->data);
                $this->load->view('templates/leftnav',$this->data);
                $this->load->view('pages/hospital_beds_view',$this->data);
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

    function get_all_hospital_beds() 
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
                $this->data['title']="Add Bed";
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
                $this->data['all_beds'] = $this->hospital_beds_model->get_all_beds($this->data['rowsperpage']);
                $this->data['all_beds_count'] = $this->hospital_beds_model->get_all_beds_count();

                $this->load->view('templates/header',$this->data);
                $this->load->view('templates/leftnav',$this->data);
                $this->load->view('pages/hospital_beds_view',$this->data);
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

    function patient_allocate_beds()
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
                $this->data['title']="Allocate Bed";
                $this->data['userdata']=$this->session->userdata('logged_in');
                $this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
                foreach($this->data['defaultsConfigs'] as $default){		 
                    if($default->default_id=='pagination'){
                            $this->data['rowsperpage'] = $default->value;
                            $this->data['upper_rowsperpage']= $default->upper_range;
                            $this->data['lower_rowsperpage']= $default->lower_range;	 

                        }
                    }
                $total_beds = $this->input->post('total_beds');
                for ($i = 0; $i <= $total_beds; $i++) {
                    if ((!empty($this->input->post('patient_id_' . $i)) && !empty($this->input->post('patient_details_' . $i))) || !empty($this->input->post('reserve_details_' . $i))) {
                        $data = array(
                            'hospital_bed_id' => $this->input->post('bed_id_' . $i),
                            'patient_id' => $this->input->post('patient_id_' . $i),
                            'details' => $this->input->post('patient_details_' . $i),
                            'reservation_details' => $this->input->post('reserve_details_' . $i),
                            'created_date' => date('Y-m-d'),
                            'created_time' => date('H:i:s')
                        );
                        $this->hospital_beds_model->insert_allocated_bed($data);
                    }
                }
                // Fetch all records from primary table
                $this->data['all_available_beds'] = $this->hospital_beds_model->get_all_available_beds();

                $this->data['all_allocated_beds'] = $this->hospital_beds_model->get_all_allocated_beds($this->data['rowsperpage']);
                $this->data['all_allocated_beds_count'] = $this->hospital_beds_model->get_all_allocated_beds_count();
                $this->load->view('templates/header',$this->data);
                $this->load->view('templates/leftnav',$this->data);
                $this->load->view('pages/hospital_allocate_bed_view',$this->data);
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

    function discharge_patient_allocated_bed()
    {
        $delete_id = $this->input->post('delete_id');
        $this->hospital_beds_model->delete_allocated_bed($delete_id);
        echo json_encode("success");
    }

    function fetch_patient_details()
    {
        $patient_id = $this->input->post('patient_id');
        $result = $this->hospital_beds_model->fetch_selected_patient_details($patient_id);
        echo(json_encode($result));
    }
}