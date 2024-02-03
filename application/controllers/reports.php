<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('reports_model');
		$this->load->model('masters_model');
		$this->load->model('staff_model');
		$this->load->model('hospital_model');
		$this->load->model('register_model');

		
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
	public function index(){
		if($this->session->userdata('logged_in')){
                    $this->data['userdata']=$this->session->userdata('logged_in');
                    $this->data['title']="Reports";
                    $this->load->view('templates/header',$this->data);
                    $this->load->view('pages/reports');
                    $this->load->view('templates/footer');
		}
		else{
                    show_404();
		}
	}
	public function op_summary()
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
                    $this->data['title']="Out-Patient Summary Report";
                    $this->data['all_departments']=$this->staff_model->get_department();
                    $this->data['units']=$this->staff_model->get_unit();
                    $this->data['areas']=$this->staff_model->get_area();
                    $this->data['visit_names']=$this->staff_model->get_visit_name();
                    $this->load->view('templates/header',$this->data);
                    $this->load->helper('form');
                    $this->load->library('form_validation');
                    $this->data['report']=$this->reports_model->get_op_summary();
                    $this->form_validation->set_rules('from_date', 'From Date',
                    'trim|required|xss_clean');
                    $this->form_validation->set_rules('to_date', 'To Date', 
                    'trim|required|xss_clean');
                    if ($this->form_validation->run() === FALSE)
                    {
                        $this->load->view('pages/op_summary',$this->data);
                    }
                    else{
                        $this->load->view('pages/op_summary',$this->data);
                    }
                    $this->load->view('templates/footer');
                }
                else{
                    show_404();
                }
            }
        else{
            show_404();
        }
    }
	public function ip_summary()
	{
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="IP Summary"){
				$access=1;
			}
		}
		if($access==1){
		$this->data['title']="In-Patient Summary Report";
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->data['visit_names']=$this->staff_model->get_visit_name();
		$this->data['from_date']=$from_date;
		$this->data['to_date']=$to_date;
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['report']=$this->reports_model->get_ip_summary();
		$this->form_validation->set_rules('from_date', 'From Date',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 
	    'trim|required|xss_clean');
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('pages/ip_summary',$this->data);
		}
		else{
			$this->load->view('pages/ip_summary',$this->data);
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
	}
	public function icd_summary()
	{
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="IP Summary"){
				$access=1;
			}
		}
		
		
		if($access==1){                        
			$this->data['title']="ICD 10 Summary Report";
			$this->data['all_departments']=$this->staff_model->get_department();
			$this->data['units']=$this->staff_model->get_unit();
			$this->data['areas']=$this->staff_model->get_area();
			$this->data['visit_names']=$this->staff_model->get_visit_name();
			$this->load->view('templates/header',$this->data);
			$this->load->helper('form');
			$this->data['report']=$this->reports_model->get_icd_summary();
			$this->data['icd_chapters']=$this->masters_model->get_data('icd_chapters');	//retrives the values from the function icd_chapter	 in master model
			$this->data['icd_blocks']=$this->masters_model->get_data('icd_blocks');      //retrives the values from the function icd_block  in master model
			$this->load->view('pages/icd_summary',$this->data);
			$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
	}
	
	public function op_detail($department=0,$unit=0,$area=0,$gender=0,$from_age=0,$to_age=0,$from_date=0,$to_date=0)
	{
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="OP Detail"){
				$access=1;
			}
		}
		if($access==1){
		if($from_date == 0 && $to_date==0) {$from_date=date("Y-m-d");$to_date=$from_date;}
		$this->data['title']="Out-Patient Detailed Report";
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->data['visit_names']=$this->staff_model->get_visit_name();
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['report']=$this->reports_model->get_op_detail($department,$unit,$area,$from_age,$to_age,$from_date,$to_date);
		$this->form_validation->set_rules('from_date', 'From Date',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 
	    'trim|required|xss_clean');
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('pages/op_detailed',$this->data);
		}
		else{
			$this->load->view('pages/op_detailed',$this->data);
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
		
	}	
	
	public function op_detail_2($department=0,$unit=0,$area=0,$gender=0,$from_age=0,$to_age=0,$from_date=0,$to_date=0)
	{
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="OP Detail"){
				$access=1;
			}
		}
		if($access==1){
		if($from_date == 0 && $to_date==0) {$from_date=date("Y-m-d");$to_date=$from_date;}
		$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
		$this->data['title']="Out-Patient Detailed Report - 2";
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->data['visit_names']=$this->staff_model->get_visit_name();
		foreach($this->data['defaultsConfigs'] as $default){		 
		 	if($default->default_id=='pagination'){
		 			$this->data['rowsperpage'] = $default->value;
		 			$this->data['upper_rowsperpage']= $default->upper_range;
		 			$this->data['lower_rowsperpage']= $default->lower_range;	 

		 		}
			}
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['report_count']=$this->reports_model->get_op_detail_with_idproof_count($department,$unit,$area,$from_age,$to_age,$from_date,$to_date);
		$this->data['report']=$this->reports_model->get_op_detail_with_idproof($department,$unit,$area,$from_age,$to_age,$from_date,$to_date,$this->data['rowsperpage']);
		$this->form_validation->set_rules('from_date', 'From Date',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 
	    'trim|required|xss_clean');
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('pages/op_detailed_with_idproof',$this->data);
		}
		else{
			$this->load->view('pages/op_detailed_with_idproof',$this->data);
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
		
	}
	

	public function followup_detail()
	{
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="patient_follow_up"){
				$access=1;
			}
		}
		if($access==1){
		$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
		$this->data['title']="Followup Details";
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['priority_types']=$this->register_model->get_priority_type();
		$this->data['route_primary']=$this->register_model->get_primary_route();
	    	$this->data['route_secondary']=$this->register_model->get_secondary_route();
		$this->data['volunteer']=$this->register_model->get_volunteer();
		$this->data['icd_chapters']=$this->masters_model->get_data('icd_chapters');	//retrives the values from the function icd_chapter	 in master model
		$this->data['icd_blocks']=$this->masters_model->get_data('icd_blocks');      //retrives the values from the function icd_block  in master model

		foreach($this->data['defaultsConfigs'] as $default){		 
		 	if($default->default_id=='pagination'){
		 			$this->data['rowsperpage'] = $default->value;
		 			$this->data['upper_rowsperpage']= $default->upper_range;
		 			$this->data['lower_rowsperpage']= $default->lower_range;	 

		 		}
			}
			$this->data['results_count']=$this->reports_model->get_count_followups();								

			$this->data['results'] = $this->reports_model->search_followups($this->data['rowsperpage']);		
			if(count($this->data['results']) == 0){
				$this->data['msg'] = "No Records found";
			}
			// $filter_names=['life_status','last_visit_type','priority_type','volunteer','primary_route','secondary_route'];
			// $filter_values = [];
			// foreach($filter_names as $filter_name){
			// 	$filter_value = "";
			// 	if($this->input->post($filter_name)){
			// 		$filter_value = $this->input->post($filter_name);
			// 	}
			// 	$filter_values[$filter_name] = $filter_value;
			// }
			// $this->data['filter_values'] = $filter_values;
		
	   $this->load->view('pages/followup_details',$this->data);
		
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
		
	}
	
	public function op_detail_3($department=0,$unit=0,$area=0,$gender=0,$from_age=0,$to_age=0,$from_date=0,$to_date=0)
	{
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="OP Detail"){
				$access=1;
			}
		}
		if($access==1){
		if($from_date == 0 && $to_date==0) {$from_date=date("Y-m-d");$to_date=$from_date;}
		$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
		$this->data['title']="OP Detail 3";
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->data['visit_names']=$this->staff_model->get_visit_name();
		$this->data['helpline_doctor']=$this->reports_model->get_helpline_doctor();
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
		foreach($this->data['defaultsConfigs'] as $default){		 
		 	if($default->default_id=='pagination'){
		 			$this->data['rowsperpage'] = $default->value;
		 			$this->data['upper_rowsperpage']= $default->upper_range;
		 			$this->data['lower_rowsperpage']= $default->lower_range;	 

		 		}
			}
		$this->data['report_count']=$this->reports_model->get_op_detail_3_count($department,$unit,$area,$from_age,$to_age,$from_date,$to_date);
		$this->data['report']=$this->reports_model->get_op_detail_3($this->data['rowsperpage']);		
		$this->form_validation->set_rules('from_date', 'From Date',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 
	    'trim|required|xss_clean');
			
		if ($this->form_validation->run() === FALSE)
		{	
			$this->load->view('pages/op_detail_3',$this->data);
		}
		else{
			$this->load->view('pages/op_detail_3',$this->data);
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
		
	}
	
	public function op_detail_followup($department=0,$unit=0,$area=0,$gender=0,$from_age=0,$to_age=0,$from_date=0,$to_date=0)
	{
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="OP Detail"){
				$access=1;
			}
		}
		if($access==1){
		if($from_date == 0 && $to_date==0) {$from_date=date("Y-m-d");$to_date=$from_date;}
		$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
		$this->data['title']="OP Detail - Follow up";
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->data['visit_names']=$this->staff_model->get_visit_name();
		$this->data['helpline_doctor']=$this->reports_model->get_helpline_doctor();
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
		foreach($this->data['defaultsConfigs'] as $default){		 
		 	if($default->default_id=='pagination'){
		 			$this->data['rowsperpage'] = $default->value;
		 			$this->data['upper_rowsperpage']= $default->upper_range;
		 			$this->data['lower_rowsperpage']= $default->lower_range;	 

		 		}
			}
		$this->data['report_count']=$this->reports_model->get_op_detail_followup_count($department,$unit,$area,$from_age,$to_age,$from_date,$to_date);
		$this->data['report']=$this->reports_model->get_op_detail_followup($this->data['rowsperpage']);		
		$this->form_validation->set_rules('from_date', 'From Date',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 
	    'trim|required|xss_clean');
			
		if ($this->form_validation->run() === FALSE)
		{	
			$this->load->view('pages/op_detail_followup',$this->data);
		}
		else{
			$this->load->view('pages/op_detail_followup',$this->data);
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
		
	}
		
	public function appointment_summary()
	{
            if($this->session->userdata('logged_in')){
                $this->data['userdata']=$this->session->userdata('logged_in');
                $access=0;
                foreach($this->data['functions'] as $function){
                    if($function->user_function=="appointment_status"){
                            $access=1;
                            break;
                    }
                }
                if($access==1){
		$this->data['title']="Appointment Summary";
		$this->load->model('helpline_model');
               $this->data['weekdays']=$this->helpline_model->get_weekdays_array();
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['all_appointment_status']=$this->staff_model->get_appointment_status();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->data['visit_names']=$this->staff_model->get_visit_name();
		$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
	
		$this->data['report']=$this->reports_model->get_appointment_summary();	
			
		if ($this->form_validation->run() === FALSE)
		{	
			$this->load->view('pages/appointment_summary',$this->data);
		}
		else{
			$this->load->view('pages/appointment_summary',$this->data);
		}
		$this->load->view('templates/footer',$this->data);
		}
		else{
                    show_404();
                }
                }
                else{
                    show_404();
                }
        }
        
        public function appointment_summary_by_staff()
	{
            if($this->session->userdata('logged_in')){
                $this->data['userdata']=$this->session->userdata('logged_in');
                $access=0;
                foreach($this->data['functions'] as $function){
                    if($function->user_function=="appointment_by_staff"){
                            $access=1;
                            break;
                    }
                }
                if($access==1){
		$this->data['title']="Appointments Summary by Team Member";
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['all_appointment_status']=$this->staff_model->get_appointment_status();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->data['visit_names']=$this->staff_model->get_visit_name();
		$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
	
		$this->data['report']=$this->reports_model->get_appointment_summary_by_staff();	
			
		if ($this->form_validation->run() === FALSE)
		{	
			$this->load->view('pages/appointment_summary_by_staff',$this->data);
		}
		else{
			$this->load->view('pages/appointment_summary_by_staff',$this->data);
		}
		$this->load->view('templates/footer',$this->data);
		}
		else{
                    show_404();
                }
                }
                
                else{
                    show_404();
                }
        }
        
        public function validate_appointment_slot()
	{
		if($this->session->userdata('logged_in')){
                $this->data['userdata']=$this->session->userdata('logged_in');
                $access=0;
                
                foreach($this->data['functions'] as $function){
                    if($function->user_function=="create_appointment"){
                            $access=1;
                    }
                }
                if($access==1){
                	$val = $this->reports_model->validate_appointment_slot();
              		if ($val==0){               
				header('Content-Type: application/json; charset=UTF-8');
			    	header('HTTP/1.1 200 OK');  
			    	$result=array(); 
			    	$result['Message'] = 'Appointment validation successful'; 
			    	echo(json_encode($result));
		       }
		       else if ($val==2) {
		       	header('Content-Type: application/json; charset=UTF-8');
			    	header('HTTP/1.1 500 Internal Server Error');    
			    	$result=array();    	
				$result['Message'] = 'Selected appointment time is outside of the slot';        
				echo(json_encode($result));	       
		       }
		       else if ($val==3) {
		       	header('Content-Type: application/json; charset=UTF-8');
			    	header('HTTP/1.1 500 Internal Server Error');    
			    	$result=array();    	
				$result['Message'] = 'Appointment limit exceeded';        
				echo(json_encode($result));	       
		       }
		       else if ($val==4) {
		       	header('Content-Type: application/json; charset=UTF-8');
			    	header('HTTP/1.1 500 Internal Server Error');    
			    	$result=array();    	
				$result['Message'] = 'Please enter Department';        
				echo(json_encode($result));	       
		       }
		       else if ($val==5) {
		       	header('Content-Type: application/json; charset=UTF-8');
			    	header('HTTP/1.1 500 Internal Server Error');    
			    	$result=array();    	
				$result['Message'] = 'Please enter Appointment time';        
				echo(json_encode($result));	       
		       }
		       else{
			    	header('Content-Type: application/json; charset=UTF-8');
			    	header('HTTP/1.1 500 Internal Server Error');    
			    	$result=array();    	
				$result['Message'] = 'Error in Appointment slot validation';        
				echo(json_encode($result));
			}
                }
                else {
			header('Content-Type: application/json; charset=UTF-8');
			header('HTTP/1.1 404 Not Found');    
			$result=array();    	
			$result['Message'] = '404 Not Found';        
			echo(json_encode($result));    	
		    }
              }
              else {
		   header('Content-Type: application/json; charset=UTF-8');
		   header('HTTP/1.1 404 Not Found');    
		   $result=array();    	
		   $result['Message'] = '404 Not Found';        
		   echo(json_encode($result));    	
	      }
               
	}
    	public function add_appointment_slot()
	{
		if($this->session->userdata('logged_in')){
                $this->data['userdata']=$this->session->userdata('logged_in');
                $access=0;
                
                foreach($this->data['functions'] as $function){
                    if($function->user_function=="appointment_slot"){
                            $access=1;
                    }
                }
                if($access==1){
                	$val = $this->reports_model->add_appointment_slot();
              		if ($val==0){               
				header('Content-Type: application/json; charset=UTF-8');
			    	header('HTTP/1.1 200 OK');  
			    	$result=array(); 
			    	$result['Message'] = 'Data added succesffuly'; 
			    	echo(json_encode($result));
		       }
		       else if ($val==2) {
		       	header('Content-Type: application/json; charset=UTF-8');
			    	header('HTTP/1.1 500 Internal Server Error');    
			    	$result=array();    	
				$result['Message'] = 'Found conflict slots, please select different time period';        
				echo(json_encode($result));	       
		       }
		       else{
			    	header('Content-Type: application/json; charset=UTF-8');
			    	header('HTTP/1.1 500 Internal Server Error');    
			    	$result=array();    	
				$result['Message'] = 'Data updation failed';        
				echo(json_encode($result));
			}
                }
                else {
			header('Content-Type: application/json; charset=UTF-8');
			header('HTTP/1.1 404 Not Found');    
			$result=array();    	
			$result['Message'] = '404 Not Found';        
			echo(json_encode($result));    	
		    }
              }
              else {
		   header('Content-Type: application/json; charset=UTF-8');
		   header('HTTP/1.1 404 Not Found');    
		   $result=array();    	
		   $result['Message'] = '404 Not Found';        
		   echo(json_encode($result));    	
	      }
               
	}
	public function appointment_slot()
	{
            if($this->session->userdata('logged_in')){
                $this->data['userdata']=$this->session->userdata('logged_in');
                $access=0;
                $add_appointment_access =0;
                $remove_appointment_access =0;
                $edit_appointment_access = 0;
                foreach($this->data['functions'] as $function){
                    if($function->user_function=="appointment_slot"){
                            $access=1;
                            if ($function->add==1) $add_appointment_access=1;
                            if ($function->remove==1) $remove_appointment_access=1;
                            if ($function->edit==1) $edit_appointment_access=1;
                    }
                }
                if($access==1){
                $this->load->model('helpline_model');
                $this->data['weekdays']=$this->helpline_model->get_weekdays_array();
		$this->data['title']="Appointment Slot";
		if($this->input->post('slot_id')){ 
			if($this->input->post('appointment_slot_operation')=="Edit"){
				$this->reports_model->update_appointment_slot();
			}
			else if($this->input->post('appointment_slot_operation')=="Delete"){
				$this->reports_model->delete_appointment_slot();
			}
		}
		$this->data['all_appointment_status']=$this->staff_model->get_appointment_status();
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['add_appointment_access']=$add_appointment_access;
		$this->data['remove_appointment_access']=$remove_appointment_access;
		$this->data['edit_appointment_access']=$edit_appointment_access;
		$this->data['visit_names']=$this->staff_model->get_visit_name();
		$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
		foreach($this->data['defaultsConfigs'] as $default){		 
		 	if($default->default_id=='pagination'){
		 			$this->data['rowsperpage'] = $default->value;
		 			$this->data['upper_rowsperpage']= $default->upper_range;
		 			$this->data['lower_rowsperpage']= $default->lower_range;	 

		 		}
			}
		$this->data['report_count']=$this->reports_model->get_appointment_slot_count();
		$this->data['report']=$this->reports_model->get_appointment_slot($this->data['rowsperpage']);		
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');	
			
		if ($this->form_validation->run() === FALSE)
		{	
			$this->load->view('pages/appointment_slot',$this->data);
		}
		else{
			$this->load->view('pages/appointment_slot',$this->data);
		}
		$this->load->view('templates/footer',$this->data);
		}
                }
                else{
                    show_404();
                }
        }    
	public function appointment($department=0,$unit=0,$area=0,$gender=0,$from_age=0,$to_age=0,$from_date=0,$to_date=0)
	{
	       if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="create_appointment"){
				$access=1;
			}
		}
		if($access==1){
		if($from_date == 0 && $to_date==0) {$from_date=date("Y-m-d");$to_date=$from_date;}
		$this->data['title']="Registrations/Appointments";
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->data['visit_names']=$this->staff_model->get_visit_name();
		$this->data['all_appointment_status']=$this->staff_model->get_appointment_status();
		$this->data['helpline_doctor']=$this->reports_model->get_helpline_doctor();
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['updated']=false;
		$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
		if($this->input->post('visit_id')){ 
			if($this->reports_model->update_appointment()){$this->data['updated']=true;}
		}
		foreach($this->data['defaultsConfigs'] as $default){		 
		 	if($default->default_id=='pagination'){
		 			$this->data['rowsperpage'] = $default->value;
		 			$this->data['upper_rowsperpage']= $default->upper_range;
		 			$this->data['lower_rowsperpage']= $default->lower_range;	 

		 		}
			}
		$this->data['report_count']=$this->reports_model->get_registration_appointment_count($department,$unit,$area,$from_age,$to_age,$from_date,$to_date);
		$this->data['report']=$this->reports_model->get_registration_appointment($this->data['rowsperpage']);		
		$this->form_validation->set_rules('from_date', 'From Date',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 
	    'trim|required|xss_clean');
			
		if ($this->form_validation->run() === FALSE)
		{	
			$this->load->view('pages/appointment',$this->data);
		}
		else{
			$this->load->view('pages/appointment',$this->data);
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
		
	}
	
	public function more_reports()
	{
	       if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="OP Detail" || 
				$function->user_function=="completed_calls_report" || 
				$function->user_function=="missed_calls_report" || 
				$function->user_function=="appointment_by_staff" || 
				$function->user_function=="login_report" || 
				$function->user_function=="patient_location_report" || 
				$function->user_function=="helpline_receiver" || 
				$function->user_function=="dashboard" ||  
				$function->user_function=="referral" || $function->user_function=="patient_follow_up" || 
				$function->user_function=="edit_demographic" || $function->user_function=="issue_list" || $function->user_function=="issue_summary"
				|| $function->user_function=="followup_summary" || $function->user_function=="followup_map" || $function->user_function=="delete_patient_visit_duplicate"
				|| $function->user_function=="list_patient_visit_duplicate"|| $function->user_function=="list_patient_edits"){
				$access=1;
				break;
			}
		}
		if($access==1){
		$this->data['title']="More Reports";
		$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/more_reports',$this->data);	
		$this->load->view('templates/footer');
		}
		else{
			show_404();
		}
		}
		else{
		show_404();
		}
		
	}
	
	///health4all_v3/reports/referrals_detail/Registration/IP/0/0/0/0/M/HospitalReferredby/0/2021-01-01/2021-08-01/25/2/2
	//reports/referrals_detail/$date_filter_field/$visittype/$visit_name/$department_id/$unit/$area/M/$hospitalsearchtype/$hospital/$from_date/$to_date/$from_time/$from_time/$rowsperpage/$s->district_id/$s->state_id/
	public function referrals_detail($date_filter_field,$visittype,$visit_name=0,$department=0,$unit=0,$area=0,$gender=0,$hospitalsearchtype,$hospital,$from_date,$to_date,$rowsperpage,$district_id,$state_id)
	{

	       if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="referral"){
				$access=1;
			}
		}
		if($access==1){
		if($from_date == 0 && $to_date==0) {$from_date=date("Y-m-d");$to_date=$from_date;}
		$this->data['title']=$visittype." Referrals";
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->data['visit_names']=$this->staff_model->get_visit_name();
		$this->data['helpline_doctor']=$this->reports_model->get_helpline_doctor();
		$this->data['helpline_hospitals']=$this->hospital_model->get_hospitals_selectize();
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['updated']=false;
		$this->data['rowsperpage'] = $rowsperpage;
		$this->data['report_count']=$this->reports_model->get_referrals_detail_count($date_filter_field,$visittype,$visit_name,$department,$unit,$area,$gender,$hospitalsearchtype,$hospital,$from_date,$to_date,$district_id,$state_id);
		$this->data['report']=$this->reports_model->get_referrals_detail($date_filter_field,$visittype,$visit_name,$department,$unit,$area,$gender,$hospitalsearchtype,$hospital,$from_date,$to_date,$district_id,$state_id,$rowsperpage);		
		$this->form_validation->set_rules('from_date', 'From Date',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 
	    'trim|required|xss_clean');
		if ($visittype == 'IP'){
			$page_to_be_loaded = 'pages/ip_referrals';
		}
		else{
			$page_to_be_loaded = 'pages/op_referrals';
		}
		if ($this->form_validation->run() === FALSE)
		{	
			$this->load->view($page_to_be_loaded,$this->data);
		}
		else{
			$this->load->view($page_to_be_loaded,$this->data);
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
		
	}
	
	public function referrals($department=0,$unit=0,$area=0,$gender=0,$from_age=0,$to_age=0,$from_date=0,$to_date=0)
	{
	       if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="referral"){
				$access=1;
			}
		}
		if($access==1){
		if($from_date == 0 && $to_date==0) {$from_date=date("Y-m-d");$to_date=$from_date;}
		$this->data['title']="Referrals";
		$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
		foreach($this->data['defaultsConfigs'] as $default){		 
		 	if($default->default_id=='pagination'){
		 		$this->data['rowsperpage'] = $default->value;
		 		$this->data['upper_rowsperpage']= $default->upper_range;
		 		$this->data['lower_rowsperpage']= $default->lower_range;
		 	}
		}
		$this->data['all_districts']=$this->staff_model->get_district();   
		$this->data['all_states']=$this->staff_model->get_states();  
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->data['visit_names']=$this->staff_model->get_visit_name();
		$this->data['helpline_doctor']=$this->reports_model->get_helpline_doctor();
		$this->data['helpline_hospitals']=$this->hospital_model->get_hospitals_selectize();
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');	
		$this->data['report']=$this->reports_model->get_referrals();	
		$this->form_validation->set_rules('from_date', 'From Date',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 
	    'trim|required|xss_clean');
			
		if ($this->form_validation->run() === FALSE)
		{	
			$this->load->view('pages/referrals',$this->data);
		}
		else{
			$this->load->view('pages/referrals',$this->data);
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
		
	}
	//reports/referrals_centers_detail/$date_filter_field/$visittype/$visit_name/$department_id/$unit/$area/M/$hospital/$from_date/$to_date/$rowsperpage/$s->district_id/$s->state_id
	//health4all_v3/reports/referrals_centers_detail/Registration/OP/-1/-1/-1/-1/M/-1/2022-01-30/2022-01-30/5/3/2
	public function referrals_centers_detail($date_filter_field,$visittype,$visit_name=0,$department=0,$unit=0,$area=0,$gender=0,$hospital,$from_date,$to_date,$rowsperpage,$district_id,$state_id)
	{

	       if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="referral"){
				$access=1;
			}
		}
		if($access==1){
		if($from_date == 0 && $to_date==0) {$from_date=date("Y-m-d");$to_date=$from_date;}
		$this->data['title']="Referrals Centers Detail";
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->data['visit_names']=$this->staff_model->get_visit_name();
		$this->data['helpline_doctor']=$this->reports_model->get_helpline_doctor();
		$this->data['helpline_hospitals']=$this->hospital_model->get_hospitals_selectize();
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['updated']=false;
		$this->data['rowsperpage'] = $rowsperpage;
		$this->data['report_count']=$this->reports_model->get_referrals_centers_detail_count($date_filter_field,$visittype,$visit_name,$department,$unit,$area,$gender,$hospitalsearchtype,$hospital,$from_date,$to_date,$district_id,$state_id);
		$this->data['report']=$this->reports_model->get_referrals_centers_detail($date_filter_field,$visittype,$visit_name,$department,$unit,$area,$gender,$hospitalsearchtype,$hospital,$from_date,$to_date,$district_id,$state_id,$rowsperpage);		
		$this->form_validation->set_rules('from_date', 'From Date',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 
	    'trim|required|xss_clean');
	
		if ($this->form_validation->run() === FALSE)
		{	
			$this->load->view('pages/referrals_centers_details',$this->data);
		}
		else{
			$this->load->view('pages/referrals_centers_details',$this->data);
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
		
	}
	public function referrals_centers($department=0,$unit=0,$area=0,$gender=0,$from_age=0,$to_age=0,$from_date=0,$to_date=0)
	{
	       if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="referral"){
				$access=1;
			}
		}
		if($access==1){
		if($from_date == 0 && $to_date==0) {$from_date=date("Y-m-d");$to_date=$from_date;}
		$this->data['title']="Referral Centers";
		$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
		foreach($this->data['defaultsConfigs'] as $default){		 
		 	if($default->default_id=='pagination'){
		 		$this->data['rowsperpage'] = $default->value;
		 		$this->data['upper_rowsperpage']= $default->upper_range;
		 		$this->data['lower_rowsperpage']= $default->lower_range;
		 	}
		}
		$this->data['all_districts']=$this->staff_model->get_district();   
		$this->data['all_states']=$this->staff_model->get_states();  
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->data['visit_names']=$this->staff_model->get_visit_name();
		$this->data['helpline_doctor']=$this->reports_model->get_helpline_doctor();
		$this->data['helpline_hospitals']=$this->hospital_model->get_hospitals_selectize();
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');	
		$this->data['report']=$this->reports_model->get_referrals_centers();	
		$this->form_validation->set_rules('from_date', 'From Date',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 
	    'trim|required|xss_clean');
			
		if ($this->form_validation->run() === FALSE)
		{	
			$this->load->view('pages/referrals_centers',$this->data);
		}
		else{
			$this->load->view('pages/referrals_centers',$this->data);
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
		
	}
	function get_search_helpline_doctor()
	{
		if ($results = $this->reports_model->get_search_helpline_doctor($this->input->post('query'))) {
			echo json_encode($results);
		} else return false;
	}
	
	public function appointments_status($department=0,$unit=0,$area=0,$gender=0,$from_age=0,$to_age=0,$from_date=0,$to_date=0)
	{
	       if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="appointment_status"){
				$access=1;
				
				if($function->add=="1"){
					$this->data['appointment_status_add']=1;
				}
				else{
					$this->data['appointment_status_add']=0;
				}
				if($function->edit=="1"){
					$this->data['appointment_status_edit']=1;					
				}
				else{
					$this->data['appointment_status_edit']=0;
					
				}
			}
		}
		if($access==1){
		if($from_date == 0 && $to_date==0) {$from_date=date("Y-m-d");$to_date=$from_date;}
		$this->data['title']="Appointment Status";
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['all_appointment_status']=$this->staff_model->get_appointment_status();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->data['visit_names']=$this->staff_model->get_visit_name();
		$this->data['helpline_doctor']=$this->reports_model->get_helpline_doctor();
		$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
		$this->load->view('templates/header',$this->data);
	        $this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['updated']=false;		
		if($this->input->post('visit_id')){ 
			if($this->reports_model->update_appointment_status()){$this->data['updated']=true;}
		}
		foreach($this->data['defaultsConfigs'] as $default){		 
		 	if($default->default_id=='pagination'){
		 			$this->data['rowsperpage'] = $default->value;
		 			$this->data['upper_rowsperpage']= $default->upper_range;
		 			$this->data['lower_rowsperpage']= $default->lower_range;	 

		 		}
			}
		$this->data['report_count']=$this->reports_model->get_appointment_status_count($department,$unit,$area,$from_age,$to_age,$from_date,$to_date);
		$this->data['report']=$this->reports_model->get_appointment_status($this->data['rowsperpage']);		
		$this->form_validation->set_rules('from_date', 'From Date',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 
	    'trim|required|xss_clean');
			
		if ($this->form_validation->run() === FALSE)
		{	
			$this->load->view('pages/appointment_status',$this->data);
		}
		else{
			$this->load->view('pages/appointment_status',$this->data);
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
		
	}
	public function doctor_patient_list($department=0,$unit=0,$area=0,$gender=0,$from_age=0,$to_age=0,$from_date=0,$to_date=0)
	{
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="doctor_patient_list"){
				$access=1;
			}
		}
		if($access==1){
		if($from_date == 0 && $to_date==0) {$from_date=date("Y-m-d");$to_date=$from_date;}
		$this->data['title']="Doctor Patient List";
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->data['visit_names']=$this->staff_model->get_visit_name();
		$this->data['helpline_doctor']=$this->reports_model->get_helpline_doctor();
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['report']=$this->reports_model->get_doctor_patient_list($department,$unit,$area,$from_age,$to_age,$from_date,$to_date);
		$this->form_validation->set_rules('from_date', 'From Date',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 
	    'trim|required|xss_clean');
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('pages/doctor_patient_list',$this->data);
		}
		else{
			$this->load->view('pages/doctor_patient_list',$this->data);
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
		
	}
	
	public function ip_detail($department=-1,$unit=0,$area=0,$gender=0,$from_age=0,$to_age=0,$from_date=0,$to_date=0,$visit_name=-1)
	{
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="IP Detail"){
				$access=1;
			}
		}
		if($access==1){
		if($from_date == 0 && $to_date==0) {$from_date=date("Y-m-d");$to_date=$from_date;}
		$this->data['title']="In-Patient Detailed Report";
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->data['visit_names']=$this->staff_model->get_visit_name();
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['from_date']=$from_date;
		$this->data['to_date']=$to_date;

		$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
		foreach ($this->data['defaultsConfigs'] as $default) {
			if ($default->default_id == 'pagination') {
				$this->data['rowsperpage'] = $default->value;
				$this->data['upper_rowsperpage'] = $default->upper_range;
				$this->data['lower_rowsperpage'] = $default->lower_range;
			}
		}
		$this->data['report_count'] = $this->reports_model->get_ip_detail_count($department, $unit, $area, $gender, $from_age, $to_age, $from_date, $to_date, $visit_name);
		$this->data['report'] = $this->reports_model->get_ip_detail($department, $unit, $area, $gender, $from_age, $to_age, $from_date, $to_date, $visit_name,0,0,$this->data['rowsperpage']);

		$this->form_validation->set_rules('from_date', 'From Date',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 
	    'trim|required|xss_clean');
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('pages/ip_detailed',$this->data);
		}
		else{
			$this->load->view('pages/ip_detailed',$this->data);
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
	}
	
	public function outcome_detail($department=-1,$unit=0,$area=0,$gender=0,$from_age=0,$to_age=0,$from_date=0,$to_date=0,$visit_name=-1,$date_type=0,$outcome=0)
	{
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="IP Detail"){
				$access=1;
			}
		}
		if($access==1){
		if($from_date == 0 && $to_date==0) {$from_date=date("Y-m-d");$to_date=$from_date;}
		$this->data['title']="Outcome Detailed Report";
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->data['visit_names']=$this->staff_model->get_visit_name();
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['from_date']=$from_date;
		$this->data['to_date']=$to_date;
		$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
		foreach ($this->data['defaultsConfigs'] as $default) {
			if ($default->default_id == 'pagination') {
				$this->data['rowsperpage'] = $default->value;
				$this->data['upper_rowsperpage'] = $default->upper_range;
				$this->data['lower_rowsperpage'] = $default->lower_range;
			}
		}
		$this->data['report_count'] = $this->reports_model->get_ip_detail_count($department,$unit,$area,$gender,$from_age,$to_age,$from_date,$to_date,$visit_name,$date_type,$outcome);
		$this->data['report']=$this->reports_model->get_ip_detail($department,$unit,$area,$gender,$from_age,$to_age,$from_date,$to_date,$visit_name,$date_type,$outcome,$this->data['rowsperpage']);
		$this->form_validation->set_rules('from_date', 'From Date',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 
	    'trim|required|xss_clean');
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('pages/outcome_detailed',$this->data);
		}
		else{
			$this->load->view('pages/outcome_detailed',$this->data);
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
	}
	
	
	public function icd_detail($icdchapter=-1,$icdblock=-1,$icd_10=0,$department=-1,$unit=0,$area=0,$gender=0,$from_age=0,$to_age=0,$from_date=0,$to_date=0,$visit_name=-1,$visit_type=0,$outcome=0)
	{
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="IP Detail"){
				$access=1;
			}
		}
		if($access==1){
		if($from_date == 0 && $to_date==0) {$from_date=date("Y-m-d");$to_date=$from_date;}
		$this->data['title']="ICD Code Detailed Report";
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->data['visit_names']=$this->staff_model->get_visit_name();
		$this->data['visit_type_param']=$visit_type;
		$this->data['from_date']=$from_date;
		$this->data['to_date']=$to_date;		
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
		foreach ($this->data['defaultsConfigs'] as $default) {
			if ($default->default_id == 'pagination') {
				$this->data['rowsperpage'] = $default->value;
				$this->data['upper_rowsperpage'] = $default->upper_range;
				$this->data['lower_rowsperpage'] = $default->lower_range;
			}
		}
		$this->data['report_count'] = $this->reports_model->get_icd_detail_count($icdchapter,$icdblock,$icd_10,$department,$unit,$area,$gender,$from_age,$to_age,$from_date,$to_date,$visit_name,$visit_type,$outcome);
		$this->data['report']=$this->reports_model->get_icd_detail($icdchapter,$icdblock,$icd_10,$department,$unit,$area,$gender,$from_age,$to_age,$from_date,$to_date,$visit_name,$visit_type,$outcome,$this->data['rowsperpage']);
		$this->load->view('pages/icd_detailed',$this->data);
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
	}
    public function icd_outcome_detail($icd_10=0,$department=-1,$unit=0,$area=0,$gender=0,$from_age=0,$to_age=0,$from_date=0,$to_date=0,$visit_name=-1,$visit_type=0,$outcome_type=0)
	{
	    if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="IP Detail"){
				$access1=1;
			}
            if($function->user_function=="Outcome Summary"){
                $access2=1;
            }
		}
		if($access1==1&&$access2==1){
		if($from_date == 0 && $to_date==0) {$from_date=date("Y-m-d");$to_date=$from_date;}
		$this->data['title']="In-Patient Detailed Report";
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->data['visit_names']=$this->staff_model->get_visit_name();
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->data['report']=$this->reports_model->get_icd_outcome_detail($icd_10,$department,$unit,$area,$gender,$from_age,$to_age,$from_date,$to_date,$visit_name,$visit_type,$outcome_type);
		$this->load->view('pages/icd_detailed',$this->data);
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
	}
	public function order_detail($test_master=-1,$department=-1,$unit=-1,$area=-1,$test_area=-1,$specimen_type=-1,$test_method=-1,$visit_type=0,$from_date=0,$to_date=0,$status=-1,$type="",$number=0,$antibiotic_id=0,$micro_organism_id=0,$sensitive=0)
	{
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="Diagnostics - Detail"){
				$access=1;
			}
		}
		if($access==1){
		$this->data['test_master_id']=$test_master;
		$this->data['department']=$department;
		$this->data['unit_id']=$unit;
		$this->data['area_id']=$area;
		$this->data['test_area']=$test_area;
		$this->data['specimen_type']=$specimen_type;
		$this->data['test_method']=$test_method;
		$this->data['visit_type']=$visit_type;
		$this->data['number']=$number;
		if($from_date == 0 && $to_date==0) {$from_date=date("Y-m-d");$to_date=$from_date;}
		$this->data['from_date']=date("d-M-Y",strtotime($from_date));
		$this->data['to_date']=date("d-M-Y",strtotime($to_date));
		$this->data['title']="Order Detailed Report";
		$this->data['type']=$type;
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['lab_departments']=$this->masters_model->get_data('test_area');
		$this->data['specimen_types']=$this->masters_model->get_data('specimen_type');
		$this->data['test_methods']=$this->masters_model->get_data("test_method");
		$this->data['test_masters']=$this->masters_model->get_data("test_name");
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$test_areas=$this->masters_model->get_data('test_area',0,$this->data['departments']);
		$this->data['report']=$this->reports_model->get_order_detail($test_master,$department,$unit,$area,$test_area,$specimen_type,$test_method,$visit_type,$from_date,$to_date,$status,$type,$number,$antibiotic_id,$micro_organism_id,$sensitive);
		$this->form_validation->set_rules('from_date', 'From Date',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 
	    'trim|required|xss_clean');
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('pages/diagnostics/order_detailed',$this->data);
		}
		else{
			$this->load->view('pages/diagnostics/order_detailed',$this->data);
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
	}

	public function text_result($test_master=-1,$department=-1,$unit=-1,$area=-1,$test_area=-1,$specimen_type=-1,$test_method=-1,$visit_type=0,$from_date=0,$to_date=0,$status=-1,$type="",$number=0)
	{
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="Diagnostics - Detail"){
				$access=1;
			}
		}
		if($access==1){
		$this->data['test_master_id']=$test_master;
		$this->data['department']=$department;
		$this->data['unit_id']=$unit;
		$this->data['area_id']=$area;
		$this->data['test_area']=$test_area;
		$this->data['specimen_type']=$specimen_type;
		$this->data['test_method']=$test_method;
		$this->data['visit_type']=$visit_type;
		$this->data['number']=$number;
		if($from_date == 0 && $to_date==0) {$from_date=date("Y-m-d");$to_date=$from_date;}
		$this->data['from_date']=date("d-M-Y",strtotime($from_date));
		$this->data['to_date']=date("d-M-Y",strtotime($to_date));
		$this->data['title']="Order Detailed Report";
		$this->data['type']=$type;
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['lab_departments']=$this->masters_model->get_data('test_area');
		$this->data['specimen_types']=$this->masters_model->get_data('specimen_type');
		$this->data['test_methods']=$this->masters_model->get_data("test_method");
		$this->data['test_masters']=$this->masters_model->get_data("test_name");
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$test_areas=$this->masters_model->get_data('test_area',0,$this->data['departments']);
		$this->data['report']=$this->reports_model->get_order_detail($test_master,$department,$unit,$area,$test_area,$specimen_type,$test_method,$visit_type,$from_date,$to_date,$status,$type,$number);
		$this->form_validation->set_rules('from_date', 'From Date',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 
	    'trim|required|xss_clean');
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('pages/diagnostics/report_text',$this->data);
		}
		else{
			$this->load->view('pages/diagnostics/report_text',$this->data);
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
	}

	public function order_summary($type="")
	{
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="Diagnostics - Summary"){
				$access=1;
			}
		}
		if($access==1){
		$this->data['type']=$type;
		$this->data['title']="Test Order Summary Report";
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['report']=$this->reports_model->get_order_summary($type);
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['lab_departments']=$this->masters_model->get_data('test_area');
		$this->data['specimen_types']=$this->masters_model->get_data('specimen_type');
		$this->data['test_methods']=$this->masters_model->get_data("test_method");
		$this->data['test_masters']=$this->masters_model->get_data("test_name");
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->form_validation->set_rules('from_date', 'From Date',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 
	    'trim|required|xss_clean');
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('pages/diagnostics/order_summary',$this->data);
		}
		else{
			$this->load->view('pages/diagnostics/order_summary',$this->data);
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
	}
	

	public function transfer_summary()
	{
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="IP Summary"){
				$access=1;
			}
		}
		if($access==1){
		$this->data['title']="Transfers Summary Report";
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['report']=$this->reports_model->get_transfers_summary();
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->form_validation->set_rules('from_date', 'From Date',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 
	    'trim|required|xss_clean');
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('pages/transfers_summary',$this->data);
		}
		else{
			$this->load->view('pages/transfers_summary',$this->data);
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
	}

	public function sensitivity_summary()
	{
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="Diagnostics - Summary"){
				$access=1;
			}
		}
		if($access==1){
		$this->data['title']="Sensitivity Summary Report";
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['report']=$this->reports_model->get_sensitivity_summary();
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->data['micro_organisms']=$this->masters_model->get_data('micro_organism');
		$this->data['antibiotics']=$this->masters_model->get_data('antibiotic');
		$this->data['specimen_types']=$this->masters_model->get_data('specimen_type');
		$this->form_validation->set_rules('from_date', 'From Date',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 
	    'trim|required|xss_clean');
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('pages/diagnostics/sensitivity_summary',$this->data);
		}
		else{
			$this->load->view('pages/diagnostics/sensitivity_summary',$this->data);
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
	}
	// This function is used to get number of audiology tests during a specified period.
        	public function audiology_summary()
	{
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="Audiology Reports"){
				$access=1;
			}
		}
		if($access==1){
		$this->data['title']="Audiology Summary Report";
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('from_date', 'From Date',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 
	    'trim|required|xss_clean');
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('pages/audiology_report',$this->data);
		}
		else{
			$this->data['report']=$this->reports_model->get_audiology_summary();
			$this->load->view('pages/audiology_report',$this->data);
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
	}
        
	// This function is used to get number of audiology tests during a specified period.
    public function audiology_detail()
	{
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="Audiology Reports"){
				$access=1;
			}
		}
		if($access==1){
		$this->data['title']="Audiology Detailed Report";
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('from_date', 'From Date',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 
	    'trim|required|xss_clean');
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('pages/audiology_detail',$this->data);
		}
		else{
			$this->data['report']=$this->reports_model->get_audiology_detail();
			$this->load->view('pages/audiology_detail',$this->data);
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
	}
        
        // This function is used to get number of OP/IP patients during a specified period.
        
        public function ip_op_trends(){ 
            
            if($this->session->userdata('logged_in')){                          //Checking for user login
                $this->data['userdata']=$this->session->userdata('logged_in');
                $access=0;
                foreach($this->data['functions'] as $function){               //Checking if the user has acess to this functionality
                    if($function->user_function=="IP Summary"){
                        $access=1;
                    }
                }
                if($access==1){                                      
                    $this->data['title']="IP/OP Trends";                       //Getting values to populate the selection fields in the query form.
                    $this->data['all_departments']=$this->staff_model->get_department();
                    $this->data['units']=$this->staff_model->get_unit();
                    $this->data['areas']=$this->staff_model->get_area();
                    $this->data['visit_names']=$this->staff_model->get_visit_name(); 
                    $this->load->view('templates/header',$this->data);
                    $this->load->helper('form');
                    $this->load->library('form_validation');
                    $this->data['report']=$this->reports_model->get_ip_op_trends(); //This method gets data from the Database, and puts the data in report variable.
                    //Report variable stores all the data returned by reports_model which is passed to the view.
                    $this->load->view('pages/ip_op_trend',$this->data);
                    $this->load->view('templates/footer');
                }
                else{
                    show_404();
                }
            }
        else{
            show_404();
            
        }
	
    }	

    	public function visit_type_summary(){ 
            
            if($this->session->userdata('logged_in')){                          //Checking for user login
                $this->data['userdata']=$this->session->userdata('logged_in');
                $access=0;
                foreach($this->data['functions'] as $function){               //Checking if the user has acess to this functionality
                    if($function->user_function=="IP Summary"){
                        $access=1;
                    }
                }
                if($access==1){               
                       
                    $this->data['title']="Visit Type Summary";                       //Getting values to populate the selection fields in the query form.
                    $this->data['all_departments']=$this->staff_model->get_department();
                    $this->data['units']=$this->staff_model->get_unit();
                    $this->data['areas']=$this->staff_model->get_area();
                    $this->data['visit_names']=$this->staff_model->get_visit_name(); 
                    $this->load->view('templates/header',$this->data);
                    $this->load->helper('form');
                    $this->load->library('form_validation');
                    $this->data['report']=$this->reports_model->get_visit_type_summary();
                    $json_data = json_encode($this->data['report']);                 

                    //This method gets data from the Database, and puts the data in report variable.
                    //Report variable stores all the data returned by reports_model which is passed to the view.
                    $this->load->view('pages/visit_type_summary',$this->data);
                    $this->load->view('templates/footer');
                }
                else{
                    show_404();
                }
            }
        else{
            show_404();
            
        }
	
    }	
        // This function is used to get login activities in specified period.
        
        public function login_report(){ 
            
            if($this->session->userdata('logged_in')){                          //Checking for user login
                $this->data['userdata']=$this->session->userdata('logged_in');
                $access=0;
                foreach($this->data['functions'] as $function){               //Checking if the user has acess to this functionality
                    if($function->user_function=="login_report"){
                        $access=1;
                    }
                }
                if($access==1){                                      
                    $this->data['title']="Login Activities";                       //Getting values to populate the selection fields in the query form.
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
                    $this->load->library('form_validation');
                    $userdata = $this->session->userdata('logged_in');
		     $user_id = $userdata['user_id'];
                    $this->data['hospitals']=$this->staff_model->user_hospital($user_id);
                    //echo("<script>console.log('hospitals: " .json_encode( $this->data['hospitals']) . "');</script>");
                    $this->data['report']=$this->reports_model->get_login_report(); //This method gets data from the Database, and puts the data in report variable.
                    //Report variable stores all the data returned by reports_model which is passed to the view.
                    $this->load->view('pages/login_report',$this->data);
                    $this->load->view('templates/footer');
                }
                else{
                    show_404();
                }
            }
        else{
            show_404();
            
        }
	
    }	
    
    public function login_activity_detail($trend_type,$datefilter,$login_status,$from_date,$to_date,$rowsperpage,$hospital)
	{
	
	       if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="login_report"){
				$access=1;
			}
		}
		if($access==1){
		if($from_date == 0 && $to_date==0) {$from_date=date("Y-m-d");$to_date=$from_date;}	
    		$this->data['title']="Login Activities - Detail"; 	
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
		$this->load->view('templates/header',$this->data);
		$this->data['rowsperpage'] = $rowsperpage;
		$this->data['report_count']=$this->reports_model->get_login_activity_detail_count($trend_type,$datefilter,$login_status,$from_date,$to_date,$hospital);
		$this->data['report']=$this->reports_model->get_login_activity_detail($trend_type,$datefilter,$login_status,$from_date,$to_date,$rowsperpage,$hospital);		
		$this->form_validation->set_rules('from_date', 'From Date',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 
	    'trim|required|xss_clean');
		
		if ($this->form_validation->run() === FALSE)
		{	
			$this->load->view('pages/login_activity_detail',$this->data);
		}
		else{
			$this->load->view('pages/login_activity_detail',$this->data);
		}
		
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
		
	}
	
	
    public function outcome_summary(){
        if($this->session->userdata('logged_in')){
                $this->data['userdata']=$this->session->userdata('logged_in');
                $access=0;
                foreach($this->data['functions'] as $function){
                    if($function->user_function=="Outcome Summary"){
                            $access=1;
                    }
                }
                if($access==1){
                    $this->data['title']="Outcome Summary Report";
                    $this->data['all_departments']=$this->staff_model->get_department();
                    $this->data['units']=$this->staff_model->get_unit();
                    $this->data['areas']=$this->staff_model->get_area();
                    $this->data['visit_names']=$this->staff_model->get_visit_name();
                    $this->load->view('templates/header',$this->data);
                    $this->load->helper('form');
                    $this->load->library('form_validation');
                    $this->data['report']=$this->reports_model->get_outcome_summary();
                    $this->form_validation->set_rules('from_date', 'From Date',
                    'trim|required|xss_clean');
                    $this->form_validation->set_rules('to_date', 'To Date', 
                    'trim|required|xss_clean');
                    $this->form_validation->set_rules('date_type_selection','Date type selection', 
                    'trim|required|xss_clean');
                    if ($this->form_validation->run() === FALSE)
                    {
                        $this->load->view('pages/outcome_summary',$this->data);
                    }
                    else{
                        $this->load->view('pages/outcome_summary',$this->data);
                    }
                    $this->load->view('templates/footer');
                }
                else{
                    show_404();
                }
            }
        else{
            show_404();
        }
    }
	
	
	public function transport_detail()
	{
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="Patient Transport Report"){
				$access=1;
			}
		}
		if($access==1){
		$this->data['title']="Patient Transport Detailed Report";
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->data['visit_names']=$this->staff_model->get_visit_name();
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['report']=$this->reports_model->get_transport_detail();
		$this->form_validation->set_rules('from_date', 'From Date', 'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 'trim|required|xss_clean');
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('pages/transport_detailed',$this->data);
		}
		else{
			$this->load->view('pages/transport_detailed',$this->data);
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
		
	}
	
		public function transport_summary()
	{
            if($this->session->userdata('logged_in')){
                $this->data['userdata']=$this->session->userdata('logged_in');
                $access=0;
                foreach($this->data['functions'] as $function){
                    if($function->user_function=="Patient Transport Report"){
                            $access=1;
                    }
                }
                if($access==1){
                    $this->data['title']="Transport Summary Report";
                    $this->data['all_departments']=$this->staff_model->get_department();
                    $this->data['units']=$this->staff_model->get_unit();
                    $this->data['areas']=$this->staff_model->get_area();
                    $this->data['visit_names']=$this->staff_model->get_visit_name();
                    $this->load->view('templates/header',$this->data);
                    $this->load->helper('form');
                    $this->load->library('form_validation');
                    $this->data['area_report']=$this->reports_model->get_transport_summary("area");
                    $this->data['person_report']=$this->reports_model->get_transport_summary("person");
                    $this->form_validation->set_rules('from_date', 'From Date',
                    'trim|required|xss_clean');
                    $this->form_validation->set_rules('to_date', 'To Date', 
                    'trim|required|xss_clean');
                    if ($this->form_validation->run() === FALSE)
                    {
                        $this->load->view('pages/transport_summary',$this->data);
                    }
                    else{
                        $this->load->view('pages/transport_summary',$this->data);
                    }
                    $this->load->view('templates/footer');
                }
                else{
                    show_404();
                }
            }
        else{
            show_404();
        }
    }


	public function all_drugs_list_with_availability()
	{
        if($this->session->userdata('logged_in')){
            $this->data['userdata']=$this->session->userdata('logged_in');
            $access=0;
            foreach($this->data['functions'] as $function){
                if($function->user_function=="Update Patients"){
					$access=1;
				}
            }
            if($access==1){
				$this->data['drugs'] = $this->hospital_model->get_masters_drugs();
            	$this->data['drugs_available'] = $this->hospital_model->get_drugs();

                $this->data['title']="All Drugs Report";
                $this->load->view('templates/header',$this->data);
                $this->load->view('pages/all_drugs_list_with_availability', $this->data);
                $this->load->view('templates/footer');
            }
            else{
                show_404();
            }
        } else{
        	show_404();
    	}
    }
	// public function search_followup()
	// {
	// 		if($this->session->userdata('logged_in')){
	// 			$this->data['userdata']=$this->session->userdata('logged_in');
	// 			$access=0;
	// 			foreach($this->data['functions'] as $function){
	// 				 if($function->user_function=="patient_follow_up"){
	// 				 $access=1;
	// 				 }
	// 			}
	// 			if($access==1){
						
	// 					$this->data['title']="Search followup";
	// 					$this->load->helper('form');
	// 					$this->load->library('form_validation');
	// 					$this->load->view('templates/header',$this->data);

	// 					$this->data['priority_types']=$this->register_model->get_priority_type();

	// 					$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
	// 					foreach($this->data['defaultsConfigs'] as $default){		 
	// 						if($default->default_id=='pagination'){
	// 								$this->data['rowsperpage'] = $default->value;
	// 								$this->data['upper_rowsperpage']= $default->upper_range;
	// 								$this->data['lower_rowsperpage']= $default->lower_range;	 
			   
	// 							}
	// 					   }

	// 					//	if($this->input->post('search_hospital')){							
	// 						//if ($this->form_validation->run() === TRUE) {
	// 							//$this->data['results_count']=$this->reports_model->get_count_hospital();								
	// 							$this->data['results']=$this->reports_model->search_followups($this->data['rowsperpage']);
	// 							 if(count($this->data['results']) == 0){
	// 							 	$this->data['msg'] = "No Records found";
	// 							// }
	// 						// }else{
	// 						// 	$this->data['msg'] = "Hospital Name is Required";
	// 					//	}

	// 					//}
						
						
	// 					$this->load->view('pages/followup_details',$this->data);

	// 					$this->load->view('templates/footer');
	// 			} else{
	// 			show_404();
	// 			}
	// 		} else{
	// 		show_404();
	// 		}
 
	public function issue_list($department=0,$unit=0,$area=0,$from_date=0,$to_date=0,$discharge_status=0)
	{
		
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="issue_list"){
				$access=1;break;
			}
		}
		if($access==1){
		if($from_date == 0 && $to_date==0) {$from_date=date("Y-m-d");$to_date=$from_date;}
		$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
		$this->data['title']="Issue List";
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->data['visit_names']=$this->staff_model->get_visit_name();
		$this->data['helpline_doctor']=$this->reports_model->get_helpline_doctor();
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
		foreach($this->data['defaultsConfigs'] as $default){		 
		 	if($default->default_id=='pagination'){
		 			$this->data['rowsperpage'] = $default->value;
		 			$this->data['upper_rowsperpage']= $default->upper_range;
		 			$this->data['lower_rowsperpage']= $default->lower_range;	 

		 		}
			}
		$discharge_status = $this->input->post('discharge_status');
		$this->data['report_count']=$this->reports_model->get_issue_list_count($department,$unit,$area,$from_date,$to_date,$discharge_status);
		$this->data['report']=$this->reports_model->get_issue_list($this->data['rowsperpage']);		
		$this->form_validation->set_rules('from_date', 'From Date',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 
	    'trim|required|xss_clean');
			
		if ($this->form_validation->run() === FALSE)
		{	
			$this->load->view('pages/issue_list',$this->data);
		}
		else{
			$this->load->view('pages/issue_list',$this->data);
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
		
	}


	public function issue_summary()
	{        
		if($this->session->userdata('logged_in')){                          //Checking for user login
			$this->data['userdata']=$this->session->userdata('logged_in');
			$access=0;
			foreach($this->data['functions'] as $function){               //Checking if the user has acess to this functionality
				if($function->user_function=="issue_summary"){
					$access=1;break;
				}
			}
			if($access==1){     
				                             
				$this->data['title']="Issue Summary";                       //Getting values to populate the selection fields in the query form.
				$this->data['all_departments']=$this->staff_model->get_department();
				$this->data['units']=$this->staff_model->get_unit();
				$this->data['areas']=$this->staff_model->get_area();
				$this->data['visit_names']=$this->staff_model->get_visit_name(); 
				$discharge_status = $this->input->post('discharge_status');
				$this->load->view('templates/header',$this->data);
				$this->load->helper('form');
				$this->load->library('form_validation');
				$this->data['report']=$this->reports_model->get_issue_summary(); //This method gets data from the Database, and puts the data in report variable.
				//Report variable stores all the data returned by reports_model which is passed to the view.
				$this->load->view('pages/issue_summary',$this->data);
				$this->load->view('templates/footer');
			}
			else{
				show_404();
			}
		}
		else{
			show_404();
		}
	}
}
