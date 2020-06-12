<?php

class Recruitment_Masters extends CI_Controller {
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
        $this->data['universities'] = $this->applicant_colleges_model->get_universities();
    }
    
    function add_recruitment_drive(){
        $this->data['userdata']=$this->session->userdata('hospital');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['title']="Add Applicant Details";
        $this->load->view('templates/header',$this->data);
        
        $this->load->view('templates/leftnav');
        
        $validations=array(
            array(
                'field'=>'name',
                'label'=>'Name',
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
            if($this->staff_recruitment_drive_model->add_recruitment_drive()){
                $this->data['message']= "Drive added succesfully.";                
            }
            else{
                $this->data['message']= "Something went wrong please try again.";                
            }            
        }
        $this->load->view('pages/staff_recruitment/add_recruitment_drive',$this->data);
        $this->load->view('templates/footer');
    }
    
    function add_qualification(){
        $this->data['userdata']=$this->session->userdata('hospital');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['title']="Add Applicant Details";
        $this->load->view('templates/header',$this->data);
        $this->load->view('templates/leftnav');
        
        $validations=array(
            array(
                'field'=>'qualification',
                'label'=>'qualification',
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
            if($this->applicant_qualifications_model->add_applicant_qualifications()){
                $this->data['message']= "Qualification added succesfully.";                
            }
            else{
                $this->data['message']= "Something went wrong please try again.";                
            }            
        }
        $this->load->view('pages/staff_recruitment/add_qualification',$this->data);
        $this->load->view('templates/footer');
    } 
    
    function add_applicant_college(){
        $this->data['userdata']=$this->session->userdata('hospital');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['title']="Add Applicant Details";
        $this->load->view('templates/header',$this->data);
        $this->load->view('templates/leftnav');
        
        $validations=array(
            array(
                'field'=>'college_name',
                'label'=>'college_name',
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
            if($this->applicant_colleges_model->add_applicant_college()){
                $this->data['message']= "College added succesfully.";                
            }
            else{
                $this->data['message']= "Something went wrong please try again.";                
            }            
        }
        $this->load->view('pages/staff_recruitment/add_applicant_college',$this->data);
        $this->load->view('templates/footer');
    } 
    
    function add_prev_institute(){
        $this->data['userdata']=$this->session->userdata('hospital');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['title']="Add Applicant Details";
        $this->load->view('templates/header',$this->data);
        $this->load->view('templates/leftnav');
        
        $validations=array(
            array(
                'field'=>'hospital_name',
                'label'=>'hospital_name',
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
            if($this->applicant_previous_hospital_model->add_applicant_previous_hospital()){
                $this->data['message']= "Hospital added succesfully.";                
            }
            else{
                $this->data['message']= "Something went wrong please try again.";                
            }            
        }
        $this->load->view('pages/staff_recruitment/add_applicant_exp_institute',$this->data);
        $this->load->view('templates/footer');
    }
    
    function add_selection_parameter(){
        $this->data['userdata']=$this->session->userdata('hospital');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['title']="Add Applicant Details";
        $this->load->view('templates/header',$this->data);
        $this->load->view('templates/leftnav');
        
        $validations=array(
            array(
                'field'=>'parameter_label',
                'label'=>'parameter_label',
                'rules'=>'required'
            ),
            array(
                'field'=>'drive_id',
                'label'=>'drive_id',
                'rules'=>'required'
            ),
            array(
                'field'=>'parameter_max_value',
                'label'=>'parameter_max_value',
                'rules'=>'required'
            )
        );
        $this->form_validation->set_rules($validations);
	$this->form_validation->set_message('message','Please input missing details.'); 
        $this->load->model('staff_recruitment_parameter_model');
        if ($this->form_validation->run() === FALSE)
        {
            $this->data['message']= "Validation failed.";
        }
        else{            
            if($this->staff_recruitment_parameter_model->add_parameter()){
                $this->data['message']= "Hospital added succesfully.";                
            }
            else{
                $this->data['message']= "Something went wrong please try again.";                
            }            
        }
        $this->load->view('pages/staff_recruitment/add_drive_parameter',$this->data);
        $this->load->view('templates/footer');
    }
}
