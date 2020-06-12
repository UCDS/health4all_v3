<?php

class department extends CI_Controller{         // 28 October 2016 -- gokulakrishna@yousee.in
    
    private $logged_in = -1;
    
    function __construct() {
        parent::__construct();
        $this->load->model('reports_model');
        $this->load->model('masters_model');
        $this->load->model('staff_model');
        $this->load->model('department/department_model');
        if($this->session->userdata('logged_in')){
            $userdata=$this->session->userdata('logged_in');        
            $user_id=$userdata['user_id'];                          
            $this->data['hospitals']=$this->staff_model->user_hospital($user_id);
            $this->data['functions']=$this->staff_model->user_function($user_id);
            $this->data['departments']=$this->staff_model->user_department($user_id);
            $this->data['op_forms']=$this->staff_model->get_forms("OP");
            $this->data['ip_forms']=$this->staff_model->get_forms("IP");
            
            $this->logged_in = 1;
        }else{
            show_404();
        }
    }
    
    function visit_summary_by_hour(){        // 28 October 2016 -- gokulakrishna@yousee.in
        $access = -1;
        foreach($this->data['functions'] as $function){
            if($function->user_function=="visit_summary"){
                $access = 1;
            }
        }
        if($this->logged_in == 1 && $access == 1){
            
        }else{
            show_404();
        }
        
        //Filter out the input
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['all_departments']=$this->staff_model->get_department();
        $this->data['units']=$this->staff_model->get_unit();
        $this->data['areas']=$this->staff_model->get_area();
        $this->data['visit_names']=$this->staff_model->get_visit_name();
         $this->form_validation->set_rules('from_date', 'From Date',
                    'trim|required|xss_clean');
                    $this->form_validation->set_rules('to_date', 'To Date', 
                    'trim|required|xss_clean');
                    
        //Get hour wise summary from departments.
        if ($this->form_validation->run() === FALSE)
        {
            $this->data['validation_message'] = "Please set a date range.";
        }
        else{
            $this->data['patient_visit_summary_by_hr'] = $this->department_model->visit_summary_by_hr();
        }
        
        //Executing views.
        $this->data['title']="Reports";
        $this->load->view('templates/header',$this->data);
        $this->load->view('pages/department_reports/patient_visit_summary_by_hr');
        $this->load->view('templates/footer');
    }
    
}
