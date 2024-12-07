<?php
class Op_Ip_report extends CI_Controller {    
    function __construct() {
            parent::__construct();
    
        $this->load->model('staff_model');
        $this->load->model('op_ip_model');
		$this->load->model('register_model');
		$this->load->model('reports_model');
		$this->load->model('masters_model');
        if($this->session->userdata('logged_in')){
                    $userdata=$this->session->userdata('logged_in');        
                    $user_id=$userdata['user_id'];                          
                    $this->data['hospitals']=$this->staff_model->user_hospital($user_id);
                    $this->data['functions']=$this->staff_model->user_function($user_id);
                    $this->data['departments']=$this->staff_model->user_department($user_id);
		}
		$this->data['op_forms']=$this->staff_model->get_forms("OP");
		$this->data['ip_forms']=$this->staff_model->get_forms("IP");
        $this->data['custom_patient_visit_form'] = $this->masters_model->get_cust_patient_visit_forms();
    }
    

    function op_ip_summary_report()
	{
		if($this->session->userdata('logged_in')){
			$this->data['userdata']=$this->session->userdata('logged_in');
			$access=0;
			foreach($this->data['functions'] as $function){
				if($function->user_function=="OP Summary"){
						$access=1;
				}
			}
			if($access==1){
				$this->load->helper('form');                
				$this->data['all_districts']=$this->staff_model->get_district();   
				$this->data['all_states']=$this->staff_model->get_states();    
				$this->data['departments']=$this->staff_model->get_department();    
				$this->data['units']=$this->staff_model->get_unit();                
				$this->data['areas']=$this->staff_model->get_area();               
				$this->data['visit_names']=$this->staff_model->get_visit_name();               
				$this->data['title']="District Wise OP/IP Summary";
				$this->load->view('templates/header',$this->data);
				$this->data['report']=$this->op_ip_model->get_dist_summary();
				$this->load->view('pages/op_ip_report_view',$this->data);
				$this->load->view('templates/footer');
			}
			else show_404();
		}   
		else show_404();
    }

	function followup_map()
	{
		if($this->session->userdata('logged_in')){
			$this->data['userdata']=$this->session->userdata('logged_in');
			$access=0;
			foreach($this->data['functions'] as $function){
				if($function->user_function=="followup_map"){
						$access=1;break;
				}
			}
			if($access==1){
				$this->load->helper('form');                
				$this->data['all_districts']=$this->staff_model->get_district();   
				$this->data['all_states']=$this->staff_model->get_states();    
				$this->data['departments']=$this->staff_model->get_department();    
				$this->data['units']=$this->staff_model->get_unit();                
				$this->data['areas']=$this->staff_model->get_area();               
				$this->data['visit_names']=$this->staff_model->get_visit_name();    
				
				$this->data['priority_types']=$this->register_model->get_priority_type();
				$this->data['route_primary']=$this->register_model->get_primary_route();
	    		$this->data['route_secondary']=$this->register_model->get_secondary_route();
				$this->data['volunteer']=$this->register_model->get_volunteer();
				$this->data['icd_chapters']=$this->masters_model->get_data('icd_chapters');	//retrives the values from the function icd_chapter	 in master model
				$this->data['icd_blocks']=$this->masters_model->get_data('icd_blocks');

				$this->data['title']="Followup Map";
				$this->load->view('templates/header',$this->data);
				if($this->input->post('after_initial_load')) {
					$this->data['report']=$this->op_ip_model->get_followup_map();
				}
				$this->load->view('pages/followup_map',$this->data);
				$this->load->view('templates/footer');
			}
			else show_404();
		}   
		else show_404();
    }

	function followup_summary(){
		if($this->session->userdata('logged_in')){
			$this->data['userdata']=$this->session->userdata('logged_in');
			$access=0;
			foreach($this->data['functions'] as $function){
				if($function->user_function=="followup_summary"){
						$access=1;break;
				}
			}
			if($access==1){
				$this->load->helper('form');                
				$this->data['all_districts']=$this->staff_model->get_district();   
				$this->data['all_states']=$this->staff_model->get_states();    
				$this->data['departments']=$this->staff_model->get_department();    
				$this->data['units']=$this->staff_model->get_unit();                
				$this->data['areas']=$this->staff_model->get_area();               
				$this->data['visit_names']=$this->staff_model->get_visit_name();    
				$this->data['priority_types']=$this->register_model->get_priority_type();
				$this->data['route_primary']=$this->register_model->get_primary_route();
	    		$this->data['route_secondary']=$this->register_model->get_secondary_route();
				$this->data['volunteer']=$this->register_model->get_volunteer();
				$this->data['icd_chapters']=$this->masters_model->get_data('icd_chapters');	//retrives the values from the function icd_chapter	 in master model
				$this->data['icd_blocks']=$this->masters_model->get_data('icd_blocks');
				$this->data['title']="Followup Summary";
				$this->load->view('templates/header',$this->data);
				$this->data['priority_types']=$this->op_ip_model->get_hospital_priority();
				$this->data['report']=$this->op_ip_model->get_followup_summary();
				//print_r($this->db->last_query());
				$this->load->view('pages/followup_summary',$this->data);
				$this->load->view('templates/footer');
			}
			else show_404();
		}   
		else show_404();
    }

	function followup_summary_route()
	{
		if($this->session->userdata('logged_in')){
			$this->data['userdata']=$this->session->userdata('logged_in');
			$access=0;
			foreach($this->data['functions'] as $function){
				if($function->user_function=="followup_summary_route"){
						$access=1;break;
				}
			}
			if($access==1){
				$this->load->helper('form');                
				$this->data['all_districts']=$this->staff_model->get_district();   
				$this->data['all_states']=$this->staff_model->get_states();    
				$this->data['departments']=$this->staff_model->get_department();    
				$this->data['units']=$this->staff_model->get_unit();                
				$this->data['areas']=$this->staff_model->get_area();               
				$this->data['visit_names']=$this->staff_model->get_visit_name();    
				$this->data['priority_types']=$this->register_model->get_priority_type();
				$this->data['route_primary']=$this->register_model->get_primary_route();
	    		$this->data['route_secondary']=$this->register_model->get_secondary_route();
				$this->data['volunteer']=$this->register_model->get_volunteer();
				$this->data['icd_chapters']=$this->masters_model->get_data('icd_chapters');	//retrives the values from the function icd_chapter	 in master model
				$this->data['icd_blocks']=$this->masters_model->get_data('icd_blocks');
				$this->data['title']="Followup Summary Route";
				$this->load->view('templates/header',$this->data);
				$this->data['priority_types']=$this->op_ip_model->get_hospital_priority();
				$this->data['report']=$this->op_ip_model->get_followup_summary_route();
				//print_r($this->db->last_query());
				$this->load->view('pages/followup_summary_route',$this->data);
				$this->load->view('templates/footer');
			}
			else show_404();
		}   
		else show_404();
    }
	
	function followup_summary_death_icdcode()
	{
		if($this->session->userdata('logged_in')){
			$this->data['userdata']=$this->session->userdata('logged_in');
			$access=0;
			foreach($this->data['functions'] as $function){
				if($function->user_function=="followup_summary_death_icdcode"){
						$access=1;break;
				}
			}
			if($access==1){
				$this->load->helper('form');                
				$this->data['all_districts']=$this->staff_model->get_district();   
				$this->data['all_states']=$this->staff_model->get_states();    
				$this->data['departments']=$this->staff_model->get_department();    
				$this->data['units']=$this->staff_model->get_unit();                
				$this->data['areas']=$this->staff_model->get_area();               
				$this->data['visit_names']=$this->staff_model->get_visit_name();    
				$this->data['priority_types']=$this->register_model->get_priority_type();
				$this->data['route_primary']=$this->register_model->get_primary_route();
	    		$this->data['route_secondary']=$this->register_model->get_secondary_route();
				$this->data['volunteer']=$this->register_model->get_volunteer();
				$this->data['icd_chapters']=$this->masters_model->get_data('icd_chapters');	//retrives the values from the function icd_chapter	 in master model
				$this->data['icd_blocks']=$this->masters_model->get_data('icd_blocks');
				$this->data['title']="Followup Summary Death - ICD Code";
				$this->load->view('templates/header',$this->data);
				$this->data['priority_types']=$this->op_ip_model->get_hospital_priority();
				$this->data['report']=$this->op_ip_model->get_followup_summary_death_icdcode();
				//print_r($this->db->last_query());
				$this->load->view('pages/followup_summary_death_icdcode',$this->data);
				$this->load->view('templates/footer');
			}
			else show_404();
		}   
		else show_404();
    }

	function followup_summary_death_routes()
	{
		if($this->session->userdata('logged_in')){
			$this->data['userdata']=$this->session->userdata('logged_in');
			$access=0;
			foreach($this->data['functions'] as $function){
				if($function->user_function=="followup_summary_death_routes"){
						$access=1;break;
				}
			}
			if($access==1){
				$this->load->helper('form');                
				$this->data['all_districts']=$this->staff_model->get_district();   
				$this->data['all_states']=$this->staff_model->get_states();    
				$this->data['departments']=$this->staff_model->get_department();    
				$this->data['units']=$this->staff_model->get_unit();                
				$this->data['areas']=$this->staff_model->get_area();               
				$this->data['visit_names']=$this->staff_model->get_visit_name();    
				$this->data['priority_types']=$this->register_model->get_priority_type();
				$this->data['route_primary']=$this->register_model->get_primary_route();
				$this->data['route_secondary']=$this->register_model->get_secondary_route();
				$this->data['volunteer']=$this->register_model->get_volunteer();
				$this->data['icd_chapters']=$this->masters_model->get_data('icd_chapters');	//retrives the values from the function icd_chapter	 in master model
				$this->data['icd_blocks']=$this->masters_model->get_data('icd_blocks');
				$this->data['title']="Followup Summary Death - Route";
				$this->load->view('templates/header',$this->data);
				$this->data['priority_types']=$this->op_ip_model->get_hospital_priority();
				$this->data['report']=$this->op_ip_model->get_followup_summary_death_routes();
				//print_r($this->db->last_query());
				$this->load->view('pages/followup_summary_death_route',$this->data);
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
