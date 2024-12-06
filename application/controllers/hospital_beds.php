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
    $this->data['custom_patient_visit_form'] = $this->masters_model->get_cust_patient_visit_forms();                                                        
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

    function update_bed_sequence() 
    {
        $this->db->trans_start();
        $sequence = $this->input->post('sequence');
        $transaction_success = true;
        foreach ($sequence as $item) 
        {
            $bedId = $item['bedId'];
            $newSequence = $item['sequence'];
            $success = $this->hospital_beds_model->update_bed_sequence_db($bedId, $newSequence);
            if($success=== 0) 
            {
                $transaction_success = false;
                break;
            }
        }
        if ($transaction_success) 
        {
            $this->db->trans_commit();
            echo json_encode(array('message' => 'Sequence updated successfully'));
        } else 
        {
            $this->db->trans_rollback();
            echo json_encode(array('message' => 'Sequence update failed'));
        }
    }

    function update_bed_parameter_sequence() 
    {
        $this->db->trans_start();
        $sequence = $this->input->post('sequence');
        $transaction_success = true;
        foreach ($sequence as $item) 
        {
             $hospital_bed_parameter_id = $item['hospital_bed_parameter_id'];
             $newSequence = $item['sequence'];
             $success = $this->hospital_beds_model->update_bed_param_sequence_db($hospital_bed_parameter_id, $newSequence);
             if($success=== 0) 
             {
                $transaction_success = false;
                break;
             }
         }
         if ($transaction_success===true) 
         {
             $this->db->trans_commit();
             echo json_encode(array('message' => 'Sequence updated successfully'));
         } else 
         {
             $this->db->trans_rollback();
             echo json_encode(array('message' => 'Sequence update failed'));
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

    public function delete_bed() 
    {
        $bed_id = $this->input->post('bed_id');
        $deleted = $this->hospital_beds_model->delete_bed($bed_id);
        if ($deleted) 
        {
            echo json_encode(['status' => 'success', 'message' => 'Bed deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete bed']);
        }
    }

    public function delete_hospital_bed_parameters() 
    {
        $bed_id = $this->input->post('bed_parameter_id');
        $deleted = $this->hospital_beds_model->delete_bed_parameter_id($bed_id);
        if($deleted) 
        {
            echo json_encode(['status' => 'success', 'message' => 'Bed Parameter deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete bed']);
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
				if($function->user_function=="allocate_beds"){
					$access = 1;
                    if ($function->edit==1) $edit_access=1;
					break;
				}
			}
			if($access==1)
			{
                $this->load->helper('form');
                $this->data['title']="Update Bed";
                $this->data['edit_access']=$edit_access;
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
                $allocated_bed_data = array();
                $bed_parameter_data = array();
                // Loop through each bed
                for ($i = 0; $i < $total_beds; $i++) {
                    if ((!empty($this->input->post('patient_id_' . $i))) || (!empty($this->input->post('reserve_details_' . $i)))) 
                    {
                        if(!empty($this->input->post('reserve_details_' . $i)))
                        {
                            $allocated_bed_data[] = array(
                                'hospital_bed_id' => $this->input->post('bed_id_' . $i),
                                'reservation_details' => $this->input->post('reserve_details_' . $i),
                                'created_date' => date('Y-m-d'),
                                'created_time' => date('H:i:s'),
                                'updated_by' => $this->input->post('updated_by'),
                            );
                            $bed_parameter_labels = $this->input->post('bed_parameter_label_' . $i);
                            $hospital_bed_parameter_ids = $this->input->post('hospital_bed_parameter_id_' . $i);
                            $bed_parameters = $this->input->post('bed_parameter_' . $i);

                            foreach ($bed_parameter_labels as $key => $label) {
                                $bed_parameter_data[] = array(
                                    'hospital_bed_id' => $this->input->post('bed_id_' . $i),
                                    'hospital_bed_parameter_id' => $hospital_bed_parameter_ids[$key],
                                    'bed_parameter_value' => $bed_parameters[$key]
                                );
                            }
                        }
                        else
                        {
                            $allocated_bed_data[] = array(
                                'hospital_bed_id' => $this->input->post('bed_id_' . $i),
                                'patient_id' => $this->input->post('patient_id_' . $i),
                                'details' => $this->input->post('patient_details_store_' . $i),
                                'patient_name' => $this->input->post('patient_name_store_' . $i),
                                'age_gender' => $this->input->post('age_gender_store_' . $i),
                                'address' => $this->input->post('address_store_' . $i),
                                'created_date' => date('Y-m-d'),
                                'created_time' => date('H:i:s'),
                                'updated_by' => $this->input->post('updated_by'),
                            );
                            $bed_parameter_labels = $this->input->post('bed_parameter_label_' . $i);
                            $hospital_bed_parameter_ids = $this->input->post('hospital_bed_parameter_id_' . $i);
                            $bed_parameters = $this->input->post('bed_parameter_' . $i);

                            foreach ($bed_parameter_labels as $key => $label) {
                                $bed_parameter_data[] = array(
                                    'hospital_bed_id' => $this->input->post('bed_id_' . $i),
                                    'hospital_bed_parameter_id' => $hospital_bed_parameter_ids[$key],
                                    'bed_parameter_value' => $bed_parameters[$key]
                                );
                            }
                        }
                        
                        $this->hospital_beds_model->insert_allocated_bed($allocated_bed_data);
                        $this->hospital_beds_model->save_patient_bed_parameter($bed_parameter_data);
                    }
                }
                // Fetch all records from primary table
                $this->data['all_available_beds'] = $this->hospital_beds_model->get_all_avnall_beds();
                $this->data['all_bed_parameters'] = $this->hospital_beds_model->get_all_bed_parameters();
                $this->data['all_allocated_beds'] = $this->hospital_beds_model->get_all_allocated_beds($this->data['rowsperpage']);
                $this->data['all_allocated_beds_count'] = $this->hospital_beds_model->get_all_allocated_beds_count();
                $this->data['all_beds'] = $this->hospital_beds_model->combined_tabluar_view();
                $this->load->view('templates/header',$this->data);
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

    public function get_bed_params_edit() 
    {
        $bed_id = $this->input->post('bed_id');
        $edit_details = $this->hospital_beds_model->bed_params_edit($bed_id);
        echo json_encode($edit_details);
    }

    public function update_edited_bed_params() 
    {
        $updated_parameters = $this->input->post('parameters');
        $bed_id = $this->input->post('bed_id');
        $success = $this->hospital_beds_model->edited_bed_parameters($updated_parameters, $bed_id);
        echo json_encode(['success' => $success]);
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

    function get_bed_parameters_data()
    {
        $bedId = $this->input->post('bedId');
        $result = $this->hospital_beds_model->fetch_selected_bed_parameters($bedId);
        echo(json_encode($result));
    }

    function hospital_bed_parameters($record_id='')
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
                $this->data['title']="Add Bed Parameters";
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
                    //$bed_parameter = $this->input->post('bed_parameter');
                    $bed_parameter_label = $this->input->post('bed_parameter_label');
                    // if (!preg_match('/^[a-z0-9_]+$/', $bed_parameter_label)) 
                    // {
                    //     $this->data['error'] = 'Bed Parameter Label should contain only lowercase alphanumeric characters and underscores.';
                    // }
                    if(!empty($bed_parameter_label))
                    {
                        if($this->hospital_beds_model->check_bed_parameter($bed_parameter_label)) 
                        {
                            $this->data['error'] = 'Bed parameters with hospital already exists';
                        }
                        else
                        {
                            $hospital=$this->session->userdata('hospital');
                            $data_to_insert = array(
                                'hospital_id' => $hospital['hospital_id'],
                               // 'bed_parameter' => $this->input->post('bed_parameter'),
                                'bed_parameter_label' => $this->input->post('bed_parameter_label'),
                            );
                            $this->hospital_beds_model->insert_bed_parameter($data_to_insert);
                            $this->data['success'] = 'Bed Parameters Added Successfully';
                        }
                    }
                }
                // Fetch all records from primary table
                $this->data['all_bed_parameters'] = $this->hospital_beds_model->get_all_bed_parameters($this->data['rowsperpage']);
                $this->data['all_bed_parameters_count'] = $this->hospital_beds_model->get_all_bed_parameters_count();
                //Fetch record to edit
                $this->data['edit_bed_parameters'] = $this->hospital_beds_model->get_edit_bed_parameters($record_id);
                $this->load->view('templates/header',$this->data);
                $this->load->view('templates/leftnav',$this->data);
                $this->load->view('pages/hospital_bed_parameters_view',$this->data);
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

    function update_hospital_bed_parameters() 
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
                $this->data['title']="Add Bed Parameters";
                $this->data['userdata']=$this->session->userdata('logged_in');
                $this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
                foreach($this->data['defaultsConfigs'] as $default){		 
                    if($default->default_id=='pagination'){
                            $this->data['rowsperpage'] = $default->value;
                            $this->data['upper_rowsperpage']= $default->upper_range;
                            $this->data['lower_rowsperpage']= $default->lower_range;	 

                        }
                    }
                    //$bed_parameter = $this->input->post('bed_parameter');
                    $bed_parameter_label = $this->input->post('bed_parameter_label');
                    $update_record_id = $this->input->post('record_id');
                    if($this->hospital_beds_model->check_bed_parameter($bed_parameter_label)) 
                    {
                        $this->data['error'] = 'Bed parameters with hospital already exists';
                    }
                    else
                    {
                        $update_data = array(
                            //'bed_parameter' => $this->input->post('bed_parameter'),
                            'bed_parameter_label' => $this->input->post('bed_parameter_label'),
                        );
                        $this->hospital_beds_model->update_bed_parameter($update_record_id, $update_data);
                        $this->data['success'] = 'Bed parameters Updated Successfully';
                    }
                // Fetch all records from primary table
                $this->data['all_bed_parameters'] = $this->hospital_beds_model->get_all_bed_parameters($this->data['rowsperpage']);
                $this->data['all_bed_parameters_count'] = $this->hospital_beds_model->get_all_bed_parameters_count();
                $this->load->view('templates/header',$this->data);
                $this->load->view('templates/leftnav',$this->data);
                $this->load->view('pages/hospital_bed_parameters_view',$this->data);
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