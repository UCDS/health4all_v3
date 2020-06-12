<?php

class blood_request extends CI_Controller{
    //put your code here
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
            if($f->user_function=="Bloodbank"){
		$access=1;
            }		
        }
        if($access==0){
            show_404();            
        }
        $this->data['op_forms']=$this->staff_model->get_forms("OP");
	$this->data['ip_forms']=$this->staff_model->get_forms("IP");	
    }
    
    function external_patient_blood_request(){
        
    }
    
    function internal_patient_blood_request(){
        $this->data['userdata']=$this->session->userdata('hospital');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['title']="Blood Request";
        $this->load->view('templates/header',$this->data);
        $this->load->view('templates/panel_nav',$this->data);
        $validations=array(
            array(
                'field'=>'visit_id',
                'label'=>'visit_id',
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
        if(($this->input->post('visit_id') && $this->input->post('blood_group')) && 
                ($this->input->post('whole_blood_units') || $this->input->post('packed_cell_units') || $this->input->post('fp_units') ||$this->input->post('ffp_units') ||$this->input->post('prp_units') ||$this->input->post('platelet_concentrate_units') ||$this->input->post('cryoprecipitate_units')))
        {   
            if($this->blood_request_model->add_internal_patient_request()){
                $this->data['message']="Request placed successfully.";                    
            }
            else{
                $this->data['message'] = 'Something went wrong please try again later.';
            }            
        }else if($this->input->post('patient_id')){
            $this->load->model('patient_model');
            $this->data['patient_info'] = $this->patient_model->get_patient_info();     
        }else if($this->input->post('search_patients')){
            $this->load->model('patient_model');
            $this->data['patient_info'] = $this->patient_model->get_patients();     
        }
        $this->load->view('pages/bloodbank/internal_patient_request',$this->data);
        $this->load->view('templates/footer');
    }
    
    //External patient request is in Patient controller as we have to create a patient before the issue can be placed.
    
    function bulk_blood_request_screened(){
        $this->data['userdata']=$this->session->userdata('hospital');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['title']="Blood Request";
        $this->load->view('templates/header',$this->data);
        $this->load->view('templates/panel_nav',$this->data);
        $validations=array(
            array(
                'field'=>'blood_bank_id',
                'label'=>'visit_id',
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
        else if($this->input->post('whole_blood_units') || $this->input->post('packed_cell_units') || $this->input->post('fp_units') || $this->input->post('ffp_units') || $this->input->post('prp_units') || $this->input->post('platelet_concentrate_units') || $this->input->post('cryoprecipitate_units'))
        {   
            if($this->blood_request_model->add_bulk_blood_request_screened()){
                $this->data['message']="Request placed successfully.";
                $this->data['screened_inventory'] = $this->bloodbag_model->get_screened_inventory();
                $this->load->view('pages/bloodbank/bulk_issue_screened',$this->data);
            }
            else{
                $this->data['message']= "Failed to place request. Please try again.";
                $this->load->view('pages/bloodbank/bulk_blood_request_screened',$this->data);
            }            
        }else{
            $this->data['message'] = 'Please input number of units requested.';
            $this->load->view('pages/bloodbank/bulk_blood_request_screened',$this->data);
        }        
        $this->load->view('templates/footer');
    }
    
    function bulk_blood_request_unscreened(){
        $this->data['userdata']=$this->session->userdata('hospital');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['title']="Blood Request";
        $this->load->view('templates/header',$this->data);
        $this->load->view('templates/panel_nav',$this->data);
        $validations=array(
            array(
                'field'=>'blood_bank_id',
                'label'=>'visit_id',
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
        else if($this->input->post('whole_blood_units') || $this->input->post('packed_cell_units') || $this->input->post('fp_units') || $this->input->post('ffp_units') || $this->input->post('prp_units') || $this->input->post('platelet_concentrate_units') || $this->input->post('cryoprecipitate_units'))
        {   
            if($this->blood_request_model->add_bulk_blood_request_unscreened()){
                $this->data['message']="Request placed successfully.";
                $this->data['unscreened_inventory'] = $this->bloodbag_model->get_unscreened_inventory();
                $this->data['message']="Request placed successfully.";
                $this->load->view('pages/bloodbank/bulk_issue_unscreened',$this->data);
            }
            else{
                $this->data['message']= "Failed to place request. Please try again.";
                $this->load->view('pages/bloodbank/bulk_blood_request_unscreened',$this->data);
            }            
        }else{
            $this->data['message'] = 'Please input number of units requested.';
            $this->load->view('pages/bloodbank/bulk_blood_request_unscreened',$this->data);
        }        
        $this->load->view('templates/footer');
    }
}
