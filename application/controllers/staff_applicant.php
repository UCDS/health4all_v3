<?php

class Staff_Applicant extends CI_Controller{
    
    function __construct() {
        parent::__construct();
        if($this->session->userdata('logged_in')){
            $this->data['userdata']=$this->session->userdata('logged_in');
        }	
        else{
            show_404();
        }
        $this->data['userdata']=$this->session->userdata('logged_in');
        $user_id=$this->data['userdata']['user_id'];        
	$this->load->model('staff_model');        
        $this->data['hospitals']=$this->staff_model->user_hospital($user_id);
        $this->data['functions']=$this->staff_model->user_function($user_id);
        $this->data['op_forms']=$this->staff_model->get_forms("OP");
        $this->data['ip_forms']=$this->staff_model->get_forms("IP");
        
	$access = -1;
	foreach($this->data['functions'] as $function){
            if($function->user_function=="HR-Recruitment"){
                $access = 1;
		break;
            }
	}
        if($access == -1){
            show_404();
        }
        $this->load->model('applicant_qualifications_model');
        $this->load->model('applicant_colleges_model');
        $this->load->model('applicant_previous_hospital_model');
        $this->load->model('staff_recruitment_drive_model');
        $this->load->model('districts_model');
        $this->load->model('staff_applicant_model');
        $this->load->model('staff_masters_model');
        $this->data['qualification_master']=$this->applicant_qualifications_model->get_qualifications();
        $this->data['applicant_colleges']=$this->applicant_colleges_model->get_colleges();
        $this->data['applicant_previous_hospital']=$this->applicant_previous_hospital_model->get_hospitals();
        $this->data['recruitment_drives']=$this->staff_recruitment_drive_model->get_drives();
        $this->data['districts'] =$this->districts_model->get_districts();
        $this->data['staff_roles'] = $this->staff_masters_model->get_staff_roles();
    }
    
    function add_applicant(){
        $this->data['userdata']=$this->session->userdata('hospital');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['title']="Add Applicant Details";
        $this->load->view('templates/header',$this->data);
        $this->load->view('templates/leftnav');
        
        $validations=array(
            array(
                'field'=>'first_name',
                'label'=>'First Name',
                'rules'=>'required'
            ),
            array(
                'field'=>'gender',
                'label'=>'Gender',
                'rules'=>'required'
            )
        );
        $this->form_validation->set_rules($validations);
	$this->form_validation->set_message('message','Please input missing details.');        
        if ($this->form_validation->run() === FALSE)
        {
            $this->data['message']= "Validation failed.";
        }
        else{            
            if($this->staff_applicant_model->add_applicant()){
                $this->data['message']= "Applicant added succesfully.";                
            }
            else{
                $this->data['message']= "Something went wrong please try again.";                
            }            
        }
        $this->load->view('pages/staff_recruitment/add_staff_applicant_details',$this->data);
        $this->load->view('templates/footer');
    }
    
    function update_applicant(){
        $this->data['userdata']=$this->session->userdata('hospital');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['title']="Add Applicant Details";
        $this->load->view('templates/header',$this->data);
        $this->load->view('templates/leftnav');
        
        $validations=array(
            array(
                'field'=>'applicant_id',
                'label'=>'applicant_id',
                'rules'=>'required'
            )
        );
        $this->form_validation->set_rules($validations);
	$this->form_validation->set_message('message','Please input missing details.');
        if ($this->form_validation->run() === FALSE)
        {
            $this->data['message']= "Validation failed.";
        }else if($this->input->post('update')){            
            if($this->staff_applicant_model->update_applicant()){
                $this->data['message']= "Applicant updated succesfully.";
            }
            else{
                $this->data['message']= "Something went wrong please try again.";                
            }
            $this->load->model('staff_recruitment_parameter_model');
            $this->data['parameters'] = $this->staff_recruitment_parameter_model->get_parameters();
            $applicants = $this->staff_applicant_model->get_applicants_detailed();           
            if($applicants){
                $this->data['applicants'] = $applicants;
            }else{
                $this->data['message']= "No Applicants found.";
            }
            $this->load->view('pages/staff_recruitment/applicants_detailed_report',$this->data);
        }   
        else if($this->input->post('applicant_id')){
            $applicant = $this->staff_applicant_model->get_applicants_detailed();
            if($applicant){
                $this->data['applicant'] = $applicant[0];
                $this->data['applicant_qualifications'] = $this->staff_applicant_model->get_qualifications();
                $this->data['applicant_experiance'] = $this->staff_applicant_model->get_experiance();
                $this->load->view('pages/staff_recruitment/edit_staff_applicant_details',$this->data);
            }else{
                $this->data['message']= "Applicant not found.";
                $this->load->view('pages/staff_recruitment/applicants_detailed_report',$this->data);
            }            
        }    
        $this->load->view('templates/footer');
    }
    
    function evaluate_applicant(){
        $this->data['userdata']=$this->session->userdata('hospital');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['title']="Add Applicant Details";
        $this->load->view('templates/header',$this->data);
        $this->load->view('templates/leftnav');
        $this->load->model('staff_recruitment_parameter_model');
        $this->data['parameters'] = $this->staff_recruitment_parameter_model->get_parameters();
        if($this->input->post('search')){
            $applicants = $this->staff_applicant_model->get_applicant();
           
            if($applicants){
                $this->data['applicants'] = $applicants;
            }else{
                $this->data['message']= "No Applicants found.";
            }
        }else if($this->input->post('update')){
            if($this->staff_applicant_model->add_evaluation()){
                $this->data['message']= "Update successful.";
            }else{
                $this->data['message']= "Something went wrong try again.";
            }
            $applicants = $this->staff_applicant_model->get_applicant();
            if($applicants){
                $this->data['applicants'] = $applicants;
            }
        }   
        $this->load->view('pages/staff_recruitment/applicant_evaluation',$this->data);
        $this->load->view('templates/footer');
    }
    
    function get_applicants_detailed(){
        $this->data['userdata']=$this->session->userdata('hospital');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['title']="Add Applicant Details";
        $this->load->view('templates/header',$this->data);
        $this->load->view('templates/leftnav');
        $this->load->model('staff_recruitment_parameter_model');
        $this->data['parameters'] = $this->staff_recruitment_parameter_model->get_parameters();
        if($this->input->post('search')){
            $applicants = $this->staff_applicant_model->get_applicants_detailed();
           
            if($applicants){
                $this->data['applicants'] = $applicants;
            }else{
                $this->data['message']= "No Applicants found.";
            }
        }
        $this->load->view('pages/staff_recruitment/applicants_detailed_report',$this->data);
        $this->load->view('templates/footer');
    }
    
}
