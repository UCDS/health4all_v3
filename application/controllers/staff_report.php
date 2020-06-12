<?php

/**
 * Description of staff_report
 * Captures Staff Activity --> How many records each employee input.
 * patient_record  --> Count the number of patients registered by each employee.
 * @author Gokul -- 28 Jan 17.
 */

class Staff_Report extends CI_Controller {
    function __construct() {
        parent::__construct();
        $this->load->model('reports_model');
        $this->load->model('masters_model');
        $this->load->model('staff_model');
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
    
    // Patient records entry count start.
    
    /* get_patient_records  --> Count the number of patients registered by each employee.
    // filters --> from_date, to_date, visit_type(OP/IP)
    // @author Gokul -- 28 Jan 17.
    */
    
    function get_patient_records(){
        if(!$this->session->userdata('logged_in')){
            show_404();
            return;
        }
        $this->load->helper('form');
	
        $this->data['userdata']=$this->session->userdata('logged_in');
        $this->load->model('staff_report_model');
        $this->data['title']="Staff Activity Report";
        $this->load->view('templates/header',$this->data);
        $this->data['patient_records_by_staff'] = $this->staff_report_model->get_patient_records();        
        $this->load->view('pages/staff/patient_records_by_staff', $this->data);
        $this->load->view('templates/footer');
    }

    function get_doctor_activity(){
        if(!$this->session->userdata('logged_in')){
            show_404();
            return;
        }
        $this->load->helper('form');
	
        $this->data['userdata']=$this->session->userdata('logged_in');
        $this->load->model('staff_report_model');
        $this->data['title']="Doctor Activity Report";
        $this->load->view('templates/header',$this->data);
        $this->data['patient_records_by_doctor'] = $this->staff_report_model->get_doctor_activity();        
        $this->load->view('pages/staff/patient_records_by_doctor', $this->data);
        $this->load->view('templates/footer');
    }

    function get_doc_act_by_institute(){
        if(!$this->session->userdata('logged_in')){
            show_404();
            return;
        }
        $this->load->helper('form');	
        $this->data['userdata']=$this->session->userdata('logged_in');
        $this->load->model('staff_report_model');
        $this->data['title']="Doctor Activity Report";
        $this->load->view('templates/header',$this->data);
        $this->data['doctor_activity_by_institution'] = $this->staff_report_model->get_doctor_activity_by_institution();        
        $this->load->view('pages/staff/doctor_activity_by_institution', $this->data);
        $this->load->view('templates/footer');
    }
    
    //  Patient records entry count end.
    
    //  Lab records entry count starts.
    /* get_patient_records  --> Count the number of patients registered by each employee.
    // filters --> from_date, to_date, lab_id, method_id
    // @author Gokul -- 30 Jan 17.
    */
    function get_lab_records(){
        if(!$this->session->userdata('logged_in')){
            show_404();
            return;
        }
        $this->load->helper('form');
        $this->load->model('masters_model');
	$this->data['lab_departments']=$this->masters_model->get_data('test_area');
        $this->data['test_methods']=$this->masters_model->get_data("test_method");
        $this->data['userdata']=$this->session->userdata('logged_in');
        $this->load->model('staff_report_model');
        $this->data['title']="Staff Reports";
        $this->load->view('templates/header',$this->data);
        $this->data['lab_records_by_staff'] = $this->staff_report_model->get_lab_records();        
        $this->load->view('pages/staff/lab_records_by_staff', $this->data);
        $this->load->view('templates/footer');
    }
    
    //  Lab records entry count end.
}
