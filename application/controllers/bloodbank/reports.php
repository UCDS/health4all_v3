<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reports extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('bloodbank/reports_model');		
		$this->load->model('staff_model');
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$user_id=$this->data['userdata']['user_id'];
		$this->data['hospitals']=$this->staff_model->user_hospital($user_id);
		$this->data['functions']=$this->staff_model->user_function($user_id);
		$this->data['departments']=$this->staff_model->user_department($user_id);
		}
		$this->data['op_forms']=$this->staff_model->get_forms("OP");
		$this->data['ip_forms']=$this->staff_model->get_forms("IP");		
	}
	function blood_donors(){
		if(!$this->session->userdata('logged_in')){
		show_404();
	  }
	 $this->data['userdata']=$this->session->userdata('logged_in');
	 foreach ($this->data['functions'] as $f ){
		if($f->user_function=="Bloodbank"){
		$access=1;
		}		
		}
		if($access==0)
		show_404();
		$this->load->helper('form');
		$this->data['title']="Blood Donors";
		$this->data['userdata']=$this->session->userdata('hospital');
		$this->data['donors']=$this->reports_model->get_donors();
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/bloodbank/blood_donors_report',$this->data);
		$this->load->view('templates/footer');	
		
	}
	function donation_summary(){
		if(!$this->session->userdata('logged_in')){
		show_404();
	 }
	 $this->data['userdata']=$this->session->userdata('logged_in');
	 foreach ($this->data['functions'] as $f ){
		if($f->user_function=="Bloodbank"){
		$access=1;
		}		
		}
		if($access==0)
		show_404();
		$this->load->helper('form');
		$this->data['title']="Donations Summary";
		$this->data['userdata']=$this->session->userdata('hospital');
		$this->data['summary']=$this->reports_model->get_donation_summary();
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/bloodbank/panel_index',$this->data);
		$this->load->view('templates/footer');	
		
	}
	function issue_summary(){
		if(!$this->session->userdata('logged_in')){
		show_404();
	}
	$this->data['userdata']=$this->session->userdata('logged_in');
	foreach ($this->data['functions'] as $f ){
		if($f->user_function=="Bloodbank"){
		$access=1;
		}		
		}
		if($access==0)
		show_404();
		$this->load->helper('form');
		$this->data['title']="Issues Summary";
		$this->data['userdata']=$this->session->userdata('hospital');
		$this->data['summary']=$this->reports_model->get_issue_summary();
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/bloodbank/report_issues_summary',$this->data);
		$this->load->view('templates/footer');	
		
	}
	function available_blood(){
	if(!$this->session->userdata('logged_in')){
		show_404();
	}
	$this->data['userdata']=$this->session->userdata('logged_in');
	foreach ($this->data['functions'] as $f ){
		if($f->user_function=="Bloodbank"){
		$access=1;
		}		
		}
		if($access==0)
		show_404();
		$this->load->helper('form');
		$this->data['title']="Available Blood";
		$this->data['userdata']=$this->session->userdata('hospital');
		$this->data['available']=$this->reports_model->get_available_blood();
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/bloodbank/available_blood_report',$this->data);
		$this->load->view('templates/footer');	
		
	}
	function appointment_bookings(){
		if(!$this->session->userdata('logged_in')){
		show_404();
	}
	$this->data['userdata']=$this->session->userdata('logged_in');
	foreach ($this->data['functions'] as $f ){
		if($f->user_function=="Bloodbank"){
		$access=1;
		}		
		}
		if($access==0)
		show_404();
		$this->load->helper('form');
		$this->data['title']="User Panel";
		$this->data['userdata']=$this->session->userdata('hospital');
		$this->data['appointments']=$this->reports_model->get_booked_appointments();
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/bloodbank/appointment_bookings',$this->data);
		$this->load->view('templates/footer');	
		
	}

	function report_donations($camp="t",$blood_group=0,$sex=0,$donation_date=0,$from_date=0,$to_date=0){
		if(!$this->session->userdata('logged_in')){
		show_404();
	}
	$this->data['userdata']=$this->session->userdata('logged_in');
	foreach ($this->data['functions'] as $f ){
		if($f->user_function=="Bloodbank"){
		$access=1;
		}		
		}
		if($access==0)
		show_404();
		$this->load->helper('form');
		$this->data['title']="Donations detailed report";
		$this->data['userdata']=$this->session->userdata('hospital');
		$this->data['donated']=$this->reports_model->get_donated_blood($camp,$blood_group,$sex,$donation_date,$from_date,$to_date);
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/bloodbank/report_donations',$this->data);
		$this->load->view('templates/footer');	
		
	}
	function report_inventory($blood_group=0,$component_type=0){
		if(!$this->session->userdata('logged_in')){
		show_404();
	}
	$this->data['userdata']=$this->session->userdata('logged_in');
	foreach ($this->data['functions'] as $f ){
		if($f->user_function=="Bloodbank"){
		$access=1;
		}		
		}
		if($access==0)
		show_404();
		$this->load->helper('form');
		$this->data['title']="Inventory detailed report";
		$this->data['userdata']=$this->session->userdata('hospital');
		$this->data['inventory']=$this->reports_model->get_inventory($blood_group,$component_type);
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/bloodbank/report_inventory',$this->data);
		$this->load->view('templates/footer');	
		
	}
	function report_screening(){
		if(!$this->session->userdata('logged_in')){
		show_404();
	}
	$this->data['userdata']=$this->session->userdata('logged_in');
	foreach ($this->data['functions'] as $f ){
		if($f->user_function=="Bloodbank"){
		$access=1;
		}		
		}
		if($access==0)
		show_404();
		$this->load->helper('form');
		$this->data['staff']=$this->staff_model->staff_list();
		$this->data['title']="User Panel";
		$this->data['userdata']=$this->session->userdata('hospital');
		$this->data['screened']=$this->reports_model->get_screened_blood();
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/bloodbank/report_screening',$this->data);
		$this->load->view('templates/footer');	
		
	}
	function report_issue($issue_date=0,$blood_group=0,$from_date=0,$to_date=0){
		if(!$this->session->userdata('logged_in')){
		show_404();
	}
	$this->data['userdata']=$this->session->userdata('logged_in');
	foreach ($this->data['functions'] as $f ){
		if($f->user_function=="Bloodbank"){
		$access=1;
		}		
		}
		if($access==0)
		show_404();
		$this->load->helper('form');
		$this->data['staff']=$this->staff_model->staff_list();
		$this->data['title']="Issue Report";
		$this->data['userdata']=$this->session->userdata('hospital');
		$hospital=$this->data['userdata']['hospital_id'];
		$this->data['issued']=$this->reports_model->get_issues($issue_date,$blood_group,$from_date,$to_date,$hospital);
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/bloodbank/report_issue',$this->data);
		$this->load->view('templates/footer');	
		
	}
	function report_grouping(){
		if(!$this->session->userdata('logged_in')){
		show_404();
	}
	$this->data['userdata']=$this->session->userdata('logged_in');
	foreach ($this->data['functions'] as $f ){
		if($f->user_function=="Bloodbank"){
		$access=1;
		}		
		}
		if($access==0)
		show_404();
		$this->load->helper('form');
		$this->data['staff']=$this->staff_model->staff_list();
		$this->data['title']="User Panel";
		$this->data['userdata']=$this->session->userdata('hospital');
		$this->data['grouped']=$this->reports_model->get_grouped_blood();
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/bloodbank/report_grouping',$this->data);
		$this->load->view('templates/footer');	
		
	}
	
	function print_certificates(){
		if(!$this->session->userdata('logged_in')){
		show_404();
	}
	$this->data['userdata']=$this->session->userdata('logged_in');
	foreach ($this->data['functions'] as $f ){
		if($f->user_function=="Bloodbank"){
		$access=1;
		}		
		}
		if($access==0)
		show_404();
		$this->load->helper('form');
		$this->data['title']="User Panel";
		$this->data['userdata']=$this->session->userdata('hospital');
		$this->data['camps']=$this->register_model->get_camps();
		$this->data['donors']=$this->reports_model->get_donors();
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/bloodbank/print_certificates',$this->data);
		$this->load->view('templates/footer');	
		
	}
	
	function hospital_issues(){
    if(!$this->session->userdata('logged_in')){
		show_404();
	}
	$this->data['userdata']=$this->session->userdata('logged_in');
	foreach ($this->data['functions'] as $f ){
		if($f->user_function=="Bloodbank"){
		$access=1;
		}		
		}
		if($access==0)
		show_404();
		$this->load->helper('form');
		$this->data['title']="Issues - Hospital wise";
		$this->data['userdata']=$this->session->userdata('hospital');
		$this->data['summary']=$this->reports_model->get_hospital_issue_summary();
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/bloodbank/hospital_issues',$this->data);
		$this->load->view('templates/footer');	
	}
}
?>