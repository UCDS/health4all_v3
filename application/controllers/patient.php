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
        $this->load->model('bloodbank/register_model');
        $this->data['hospitals']=$this->staff_model->user_hospital($user_id);
        $this->data['functions']=$this->staff_model->user_function($user_id);
        $this->data['departments']=$this->staff_model->user_department($user_id);
        
	foreach ($this->data['functions'] as $f ){
            if($f->user_function=="Bloodbank" || $f->user_function=="IP Summary" || $f->user_function=="Update Patients"){
		$access=1;
            }		
        }
        if($access==0){
            show_404();            
        }
        $this->data['op_forms']=$this->staff_model->get_forms("OP");
	    $this->data['ip_forms']=$this->staff_model->get_forms("IP");
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
}
