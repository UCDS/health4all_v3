<?php
class Patient extends CI_Controller {    
    function __construct() {
        parent::__construct();
        if(!$this->session->userdata('logged_in')){
            show_404();
	}
	$this->data['userdata']=$this->session->userdata('logged_in');
        $user_id=$this->data['userdata']['user_id'];
        $this->load->model('bloodbank/donation_model');
	$this->load->model('staff_model');
	$this->load->model('masters_model');
    $this->load->model('hospital_model');
        $this->load->model('bloodbank/register_model');
        $this->data['hospitals']=$this->staff_model->user_hospital($user_id);
        $this->data['functions']=$this->staff_model->user_function($user_id);
        $this->data['departments']=$this->staff_model->user_department($user_id);
        
	foreach ($this->data['functions'] as $f ){
            if($f->user_function=="Bloodbank" || $f->user_function=="IP Summary" || $f->user_function=="Update Patients" || $f->user_function=="edit_demographic"){
		$access=1;
		break;
            }		
        }
        if($access==0){
            show_404();            
        }
        $this->data['op_forms']=$this->staff_model->get_forms("OP");
	    $this->data['ip_forms']=$this->staff_model->get_forms("IP");
        $this->data['custom_patient_visit_form'] = $this->masters_model->get_cust_patient_visit_forms();
    }
    
    function external_patient_blood_request(){  ////Presently used only for bloodbank module. Also registers a external patient.
        $this->data['userdata']=$this->session->userdata('hospital');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['title']="Blood Request";
        $this->load->view('templates/header',$this->data);
        $this->load->view('templates/panel_nav',$this->data);
        $validations=array(
            array(
                'field'=>'first_name',
                'label'=>'First Name',
                'rules'=>'required'
            ),
            array(
                'field'=>'blood_group',
                'label'=>'Blood Group',
                'rules'=>'required'
            )            
        );
        $this->form_validation->set_rules($validations);
	$this->form_validation->set_message('message','Invalid Submission, Patient name and request blood group required.');
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('pages/bloodbank/external_patient_request',$this->data);
        }
        else if($this->input->post('whole_blood_units') || $this->input->post('packed_cell_units') || $this->input->post('fp_units') ||$this->input->post('ffp_units') ||$this->input->post('prp_units') ||$this->input->post('platelet_concentrate_units') ||$this->input->post('cryoprecipitate_units'))
        {   
            $patient_visit_id = $this->patient_model->register_external_patient();
            if($patient_visit_id){
                if($this->blood_request_model->add_external_patient_request($patient_visit_id)){
                    $this->data['message']="Request placed successfully.";            
                }
                else{
                    $this->data['message']= "Failed to place request. Please search for patient in internal patient and place request again.";                 
                }
            }else{
                $this->data['message']= "Failed to add patient please try again.";
            }
        }else{
            $this->data['message'] = 'Please input number of units requested.';            
        }
        $this->load->view('pages/bloodbank/external_patient_request',$this->data);
        $this->load->view('templates/footer');
    }
    
    function edit_patient_demographic_details(){
    	$this->data['title']="Edit Patient Demographic details";
    	$this->load->model('masters_model');
    	$this->load->model('patient_model');
    	$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
	$this->load->view('templates/header',$this->data);
	$this->load->helper('form');
	$this->data['patient_data'] = $this->patient_model->get_patient_data();
	$this->data['patient_data_edit_history'] = $this->patient_model->get_patient_data_edit_history();
	
	if (count($this->data['patient_data']) == 0 && $this->input->post('patient_id')){
		$this->data['error']="No details found";
	}
	$this->load->view('pages/edit_patient_demographic_details',$this->data);	
	$this->load->view('templates/footer');
    	
    }
    
    
    function update_patient_demographic_details(){
    	$input_data = json_decode(trim(file_get_contents('php://input')), true);
    	$this->load->model('patient_model');
    	$result = $this->patient_model->update_patient_data($input_data);
    	if ($result == 1) {
    		header('Content-Type: application/json; charset=UTF-8');
	    	header('HTTP/1.1 500 Internal Server Error');    
	    	$result=array();    	
		$result['Message'] = 'Patient ID is missing!';        
		echo(json_encode($result));
    	
    	}  else if ($result == 2) {
		header('Content-Type: application/json; charset=UTF-8');
		header('HTTP/1.1 500 Internal Server Error');    
	        $result=array();    	
		$result['Message'] = 'Error in transaction!';        
		echo(json_encode($result));
	} else {
		header('Content-Type: application/json; charset=UTF-8');
		header('HTTP/1.1 200 OK');  
	    	$result=array(); 
	    	$result['Message'] = 'Patient data updated successfully!'; 
	    	echo(json_encode($result));
	}
	    	
    	
    }
    function casesheet_mrd_status(){
        $this->data['userdata']=$this->session->userdata('hospital');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['title']="Blood Request";
        $this->load->view('templates/header',$this->data);
        $this->load->model('patient_model');
        $validations=array(
            array(
                'field'=>'from_ip_number',
                'label'=>'From number',
                'rules'=>'required'
            ),
            array(
                'field'=>'to_ip_number',
                'label'=>'To number',
                'rules'=>'required'
            )            
        );
        $this->form_validation->set_rules($validations);
	$this->form_validation->set_message('message','Invalid Submission, Please input both IP and OP number.');
        if ($this->form_validation->run() === FALSE)
        {
            $this->data['from_ip_number'] = '';
            $this->data['to_ip_number'] = '';
        }else{
            $this->data['patient_record_status'] = $this->patient_model->casesheet_mrd_status();
            $this->data['from_ip_number'] = $this->input->post('from_ip_number');
            $this->data['to_ip_number'] = $this->input->post('to_ip_number');
        }        
        $this->load->view('pages/casesheet_mrd_status',$this->data);
    }
    
    function get_obg_history($patient_id){
        $obg_history = $this->patient_model->get_obg_history($patient_id);
        echo json_encode($obg_history);
    }
    
    function get_obg_summary($patient_id){
        $obg_summary = $this->patient_model->get_obg_summary();
        echo json_encode("Work in progress");
    }
    
    function add_child(){
        $this->load->model('patient_model');
        $child_added = $this->patient_model->add_child();
        echo json_encode($child_added);
    }
    
    function get_patients_summary(){                            // Patients basic info and current visit info in the selected period.
        $this->load->model('patient_model');
        $patients_summary = $this->patient_model->get_patients_summary();
        echo json_encode($patients_summary);
    }
    
    function get_patient_personal_info(){
        $this->load->model('patient_model');
        $patient_information = $this->patient_model->get_patient_personal_info();
        echo json_encode($patient_information);
    }
    
    function get_patient_visits_info(){
        $this->load->model('patient_model');
        $patient_visits = $this->patient_model->get_patient_visits_info();
        echo json_encode($patient_visits);
    }
    
    function get_patient_diagnostics_info(){
        $this->load->model('patient_model');
        $patient_diagnostics = $this->patient_model->get_patient_diagnostics();
        echo json_encode($patient_diagnostics);
    }
    
    function get_patient_mlc(){
        $patient_mlc = $this->patient_model->get_patient_mlc();
        echo json_encode($patient_mlc);
    }
    
    function get_patient_procedures(){
        $patient_procedures = $this->patient_model->get_patient_procedures();
        echo json_encode($patient_procedures);
    }
    
    function get_clinical_info(){
        $this->load->model('patient_model');
        $patient_prescriptions = $this->patient_model->get_patient_prescriptions();
        echo json_encode($patient_prescriptions);
    }
    
    function get_patient_mlc_info(){
        $this->load->model('patient_model');
        $patient_prescriptions = $this->patient_model->get_patient_mlc_info();
        echo json_encode($patient_prescriptions);
    }
    
    function get_patient_obg_info(){
        $this->load->model('patient_model');
        $patient_obg = $this->patient_model->get_patient_obg_info();
        echo json_encode($patient_obg);
    }
    
    function get_patient_procedures_info(){
        $this->load->model('patient_model');
        $patient_procedures = $this->patient_model->get_patient_procedures_info();
        echo json_encode($patient_procedures);
    }
    
function update_patient(){
        $this->data['userdata']=$this->session->userdata('hospital');
        $this->load->helper('form');
        $this->data['title']="Blood Request";
        $this->load->view('templates/header',$this->data);
        $this->load->view('pages/patients/update_patients',$this->data);
        $this->load->view('templates/footer');
    }
    
    function delete_patient_visit_duplicate()
    {
        $this->input->post('patient_id');
    	$this->data['title']="Delete Patient Visit Duplicate";
    	$this->load->model('masters_model');
    	$this->load->model('patient_model');
    	$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
	    $this->load->view('templates/header',$this->data);
	    $this->load->helper('form');
        //get data from Original table
	    $this->data['patient_visit_data'] = $this->patient_model->get_patient_visits_data();
        
        $this->load->view('pages/delete_patient_visit_duplicate',$this->data);	
        $this->load->view('templates/footer');
    }
    
    function refresh_table()
    {
        $this->load->model('masters_model');
        $this->load->model('patient_model');
        $patient_id = $this->input->post('patient_id');
        $data = $this->patient_model->get_patient_visit_id_delete_history($patient_id);
        echo json_encode($data);
    }

    function delete_patient_visit_id()
    {
        $this->data['title']="Delete Patient Visit Duplicate";
    	$this->load->model('masters_model');
    	$this->load->model('patient_model');
    	$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
	    $this->load->view('templates/header',$this->data);
	    $this->load->helper('form');
        $visit_id = $this->input->post('visit_id');
        $original_data = $this->patient_model->get_patient_visit_id_details($visit_id);
		//echo("<script>alert('appointment_slot_id: " . $$this->input->post('appointment_slot_id') . "');</script>");
		//echo("<script>alert('appointment_status_category: " . $$this->input->post('appointment_status_category') . "');</script>");
        $this->patient_model->ins_del_ops_duplicate_data($original_data,$visit_id);
        //$this->patient_model->delete_from_patient_visit($visit_id);
        $this->load->view('pages/delete_patient_visit_duplicate',$this->data);	
        $this->load->view('templates/footer');
    }
    
    function list_patient_visit_duplicate()
    {
        if($this->session->userdata('logged_in')){                          //Checking for user login
            $this->data['userdata']=$this->session->userdata('logged_in');
            $access=0;
            foreach($this->data['functions'] as $function){               //Checking if the user has acess to this functionality
                if($function->user_function=="list_patient_visit_duplicate"){
                    $access=1;break;
                }
            }
            if($access==1){ 
                $this->data['title']="List Patient Visit Duplicate";
                $this->load->model('masters_model');
                $this->load->model('patient_model');
                $this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
                $this->load->view('templates/header',$this->data);
                $this->load->helper('form');
                $this->data['deleted_duplicate_data'] = $this->patient_model->get_deleted_duplicate_data();
                $this->load->view('pages/list_patient_visit_duplicate',$this->data);	
                $this->load->view('templates/footer');
            }else{
                show_404();
            }
        }
        else{
            show_404();
            }
    }

    function list_patient_edits()
    {
        if($this->session->userdata('logged_in')){                          //Checking for user login
            $this->data['userdata']=$this->session->userdata('logged_in');
            $access=0;
            foreach($this->data['functions'] as $function){               //Checking if the user has acess to this functionality
                if($function->user_function=="list_patient_edits"){
                    $access=1;break;
                }
            }
            if($access==1){ 
                if($from_date == 0 && $to_date==0) {$from_date=date("Y-m-d");$to_date=$from_date;}
                $this->data['title']="List Patient Edits";
                $this->load->model('masters_model');
                $this->load->model('patient_model');
                $this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
                foreach($this->data['defaultsConfigs'] as $default){		 
                    if($default->default_id=='pagination'){
                            $this->data['rowsperpage'] = $default->value;
                            $this->data['upper_rowsperpage']= $default->upper_range;
                            $this->data['lower_rowsperpage']= $default->lower_range;	 
       
                        }
                   }
                $this->load->view('templates/header',$this->data);
                $this->load->helper('form');
                $this->data['patient_edits_count']=$this->patient_model->get_patient_edits_info_count($from_date,$to_date);
                $this->data['patient_edits'] = $this->patient_model->get_patient_edits_info($this->data['rowsperpage']);
                $this->load->view('pages/list_patient_edits',$this->data);	
                $this->load->view('templates/footer');
            }else{
                show_404();
            }
        }
        else{
            show_404();
            }
    }

    function edit_patient_visits()
    {
        if($this->session->userdata('logged_in'))
        {
            $this->data['title']="Edit Patient Visit History";
            $this->load->model('masters_model');
            $this->load->model('patient_model');
            $this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
            $this->data['departments'] = $this->staff_model->get_department();
            $this->data['units'] = $this->staff_model->get_unit();
            $this->data['areas'] = $this->staff_model->get_area();
            $this->data['visit_types'] = $this->staff_model->get_visit_name();
            $this->data['hospitals']=$this->hospital_model->get_hospitals_selectize(true);
            $this->data['icd_codes'] = $this->patient_model->get_all_icd_codes_patient_visits();
            $this->load->view('templates/header',$this->data);
            $this->load->helper('form');
            $this->data['patient_visits_to_edit'] = $this->patient_model->get_patient_visits_to_edit();
            if($this->input->post('patient_id'))
            {
                $this->data['patient_visits_edit_history'] = $this->patient_model->get_patient_visits_edit_history();
                
            }
            $this->load->view('pages/edit_patient_visits',$this->data);	
            $this->load->view('templates/footer');
        }
        else
        {
            show_404();
        }
    }

    function get_clinical_text_to_edit()
    {
        $this->load->model('patient_model');
        $edit_visit_id = $this->input->post('visit_id');
        $this->data['get_clinical_text'] = $this->patient_model->get_clinical_text_to_edit($edit_visit_id);
        echo json_encode($this->data['get_clinical_text']);
    }

    function del_visits_counseling_text() {
        $this->load->model('patient_model');
        $del_visits_counseling = $this->input->post('counselingId');
        $deleted = $this->patient_model->deleteCounseling_visit_text($del_visits_counseling);
        echo json_encode(array("success" => $deleted));
    }

    function get_visits_for_edit()
    {
        $this->load->model('patient_model');
        $edit_visit_id = $this->input->post('visit_id');
        $this->data['patient_visit_details'] = $this->patient_model->get_patient_visit_details_for_edits($edit_visit_id);
        echo json_encode($this->data['patient_visit_details']);
    }

    function get_op_ip_visit()
    {
        $this->load->model('patient_model');
        $edit_visit_id = $this->input->post('visit_id');
        $op_or_ip = $this->patient_model->select_op_ip($edit_visit_id);
        $visit_types = [];
        if($op_or_ip[0]->visit_type=="OP")
        {
            $visit_types = $this->staff_model->get_visit_name_op();
        }else if($op_or_ip[0]->visit_type=="IP"){
            $visit_types = $this->staff_model->get_visit_name_ip();
        }
        echo json_encode(['visit_types' => $visit_types]);
    }

    function update_clinical_note_visits()
    {
        $this->load->model('patient_model');
        $clinical_note = $this->input->post('clinicalNote');
        $note_id = $this->input->post('noteId');
        $this->patient_model->get_update_clinical_note_edits($clinical_note, $note_id);
        echo json_encode("success");
    }
    
    function update_patient_visit_details()
    {
    	$input_data = json_decode(trim(file_get_contents('php://input')), true);
    	$this->load->model('patient_model');
    	$result = $this->patient_model->patient_visits_edits($input_data);
    	if($result == 1)
        {
            $result=array();    	
            $result['Message'] = 'Visit id missing';        
            echo(json_encode($result));
        }
        else if($result == 2) 
        {
            $result=array();    	
            $result['Message'] = 'Error in transaction!';        
            echo(json_encode($result));
        } 
        else 
        {
            $result=array(); 
            $result['Message'] = 'Patient visit data updated successfully!'; 
            echo(json_encode($result));	
        }
    }

    function list_edit_patient_visits()
    {
        if($this->session->userdata('logged_in'))
        {                          
            $this->data['userdata']=$this->session->userdata('logged_in');
            $access=0;
            foreach($this->data['functions'] as $function){               //Checking if the user has acess to this functionality
                if($function->user_function=="list_edit_patient_visits"){
                    $access=1;break;
                }
            }
            if($access==1)
            { 
                if($from_date == 0 && $to_date==0) {$from_date=date("Y-m-d");$to_date=$from_date;}
                $this->data['title']="List Patient Edits";
                $this->load->model('masters_model');
                $this->load->model('patient_model');
                $this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
                foreach($this->data['defaultsConfigs'] as $default){		 
                    if($default->default_id=='pagination'){
                            $this->data['rowsperpage'] = $default->value;
                            $this->data['upper_rowsperpage']= $default->upper_range;
                            $this->data['lower_rowsperpage']= $default->lower_range;	 
                        }
                   }
                $this->load->view('templates/header',$this->data);
                $this->load->helper('form');
                $this->data['all_patient_visits_edits_count']=$this->patient_model->get_all_patient_visits_edits_count($from_date,$to_date);
                $this->data['all_patient_visits_edits'] = $this->patient_model->get_all_patient_visits_edits($this->data['rowsperpage']);
                $this->load->view('pages/list_edit_patient_visits',$this->data);	
                $this->load->view('templates/footer');
            }else{
                show_404();
            }
        }
        else{
            show_404();
            }
    }

    function delete_patient_followup()
    {
        if($this->session->userdata('logged_in'))
        {
            $this->data['userdata']=$this->session->userdata('logged_in');
            $access=0;
            foreach($this->data['functions'] as $function){               //Checking if the user has acess to this functionality
                if($function->user_function=="delete_patient_followup"){
                    $access=1;
                    break;
                }
            }
            if($access==1)
            {
                $this->data['title']="Delete Patient Followup";
                $this->load->model('masters_model');
                $this->load->model('patient_model');
                $this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
                $this->data['departments'] = $this->staff_model->get_department();
                $this->data['units'] = $this->staff_model->get_unit();
                $this->data['areas'] = $this->staff_model->get_area();
                $this->data['visit_types'] = $this->staff_model->get_visit_name();
                $this->load->view('templates/header',$this->data);
                $this->load->helper('form');
                if($this->input->post('patient_id'))
                {
                    $this->data['patient_followup_history'] = $this->patient_model->get_patient_followup_history();
                }
                $this->load->view('pages/delete_patient_followup',$this->data);	
                $this->load->view('templates/footer');
            }else{
                show_404();
            }
        }
        else
        {
            show_404();
        }
    }

    function delete_followup_patient_id() 
    {
        if($this->session->userdata('logged_in'))
        {
            $this->data['userdata']=$this->session->userdata('logged_in');
            $access=0;
            foreach($this->data['functions'] as $function){               //Checking if the user has acess to this functionality
                if($function->user_function=="delete_patient_followup"){
                    $access=1;
                    break;
                }
            }
            if($access==1)
            {
                $patient_id = $this->input->post('patient_id');
                $this->load->model('Patient_model');
                $result = $this->Patient_model->delete_patient_followup($patient_id);
                echo json_encode(['success' => $result]);
            }else{
                show_404();
            }
        }
        else
        {
            show_404();
        }
    } 

    function list_blood_donor_details_edit()
    {
        if($this->session->userdata('logged_in'))
        {                          
            $this->data['userdata']=$this->session->userdata('logged_in');
            $access=0;
            foreach($this->data['functions'] as $function){               //Checking if the user has acess to this functionality
                if($function->user_function=="list_blood_donor_details_edit"){
                    $access=1;break;
                }
            }
            if($access==1)
            { 
                if($from_date == 0 && $to_date==0) {$from_date=date("Y-m-d");$to_date=$from_date;}
                $this->data['title']="List Blood Donor Details Edits";
                $this->load->model('masters_model');
                $this->load->model('patient_model');
                $this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
                foreach($this->data['defaultsConfigs'] as $default){		 
                    if($default->default_id=='pagination'){
                            $this->data['rowsperpage'] = $default->value;
                            $this->data['upper_rowsperpage']= $default->upper_range;
                            $this->data['lower_rowsperpage']= $default->lower_range;	 
                        }
                   }
                $this->load->view('templates/header',$this->data);
                $this->load->helper('form');
                $this->data['all_blood_donor_details_count']=$this->patient_model->get_all_blood_donor_details_count($from_date,$to_date);
                $this->data['all_blood_donor_details'] = $this->patient_model->get_all_blood_donor_details($this->data['rowsperpage']);
                $this->load->view('pages/list_blood_donor_details_edit',$this->data);	
                $this->load->view('templates/footer');
            }else{
                show_404();
            }
        }
        else{
            show_404();
            }
    }

    function list_patient_document_delete()
    {
        if($this->session->userdata('logged_in'))
        {                          
            $this->data['userdata']=$this->session->userdata('logged_in');
            $access=0;
            foreach($this->data['functions'] as $function){
                if($function->user_function=="list_patient_document_delete"){
                    $access=1;break;
                }
            }
            if($access==1)
            { 
                if($from_date == 0 && $to_date==0) {$from_date=date("Y-m-d");$to_date=$from_date;}
                $this->data['title']="List Patient Document Delete";
                $this->load->model('masters_model');
                $this->load->model('patient_model');
                $this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
                foreach($this->data['defaultsConfigs'] as $default){		 
                    if($default->default_id=='pagination'){
                            $this->data['rowsperpage'] = $default->value;
                            $this->data['upper_rowsperpage']= $default->upper_range;
                            $this->data['lower_rowsperpage']= $default->lower_range;	 
                        }
                   }
                $this->load->view('templates/header',$this->data);
                $this->load->helper('form');
                $this->data['all_patient_document_delete_count']=$this->patient_model->get_all_patient_document_delete_count($from_date,$to_date);
                $this->data['all_patient_document_delete'] = $this->patient_model->get_all_patient_document_delete($this->data['rowsperpage']);
                $this->load->view('pages/list_patient_document_delete',$this->data);	
                $this->load->view('templates/footer');
            }else{
                show_404();
            }
        }
        else{
            show_404();
            }
    }
}
