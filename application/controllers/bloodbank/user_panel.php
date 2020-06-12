<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_panel extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('bloodbank/reports_model');		
		$this->load->model('bloodbank/register_model');	
        $this->load->model('bloodbank/inventory_model');		
		$this->load->model('staff_model');	
        $this->load->library('pagination');
		$this->load->library('table');		
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
	function place(){
		if($this->session->userdata('logged_in')){
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['title']="Places";
		$this->data['userdata']=$this->session->userdata('logged_in');
		$this->data['hospitaldata']=$this->session->userdata('hospital');
		$this->data['camps']=$this->register_model->get_camps();
		if($this->input->post('add_camp')){
				if($this->staff_model->add_camp()){
					$this->data['camps']=$this->register_model->get_camps();
					$this->data['msg']="Camp added successfully";

					$this->load->view('templates/header',$this->data);
					$this->load->view('templates/panel_nav',$this->data);
					$this->load->view('pages/bloodbank/place',$this->data);
				}
		}
		else if($this->input->post('reset')){
			$this->session->unset_userdata('place');
				$this->session->set_userdata('place',array('camp_id'=>0,'name'=>'Blood Bank'));

				$this->load->view('templates/header',$this->data);
				$this->load->view('templates/panel_nav',$this->data);
				$this->load->view('pages/bloodbank/place');
		}
		else if($this->input->post('set_camp')){
			$this->session->unset_userdata('place');
			$camp=$this->register_model->get_camps($this->input->post('camp'));
			$sess_array=array(
				'camp_id'=>$camp[0]->camp_id,
				'name'=>$camp[0]->camp_name,
				'location'=>$camp[0]->location
			);
			$this->session->set_userdata('place',$sess_array);

			$this->load->view('templates/header',$this->data);
			$this->load->view('templates/panel_nav',$this->data);
			$this->load->view('pages/bloodbank/place',$this->data);
		}
		else{
			$this->load->view('templates/header',$this->data);
			$this->load->view('templates/panel_nav',$this->data);
			$this->load->view('pages/bloodbank/place',$this->data);
		}
		$this->load->view('templates/footer');	
		}
		else{
			show_404();
		}
	}
	function blood_donors(){
		if($this->session->userdata('logged_in')){
		$this->load->helper('form');
		$this->data['title']="Blood Donors";
		$this->data['userdata']=$this->session->userdata('logged_in');
		$this->data['donors']=$this->reports_model->get_donors();
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/reports_nav',$this->data);
		$this->load->view('pages/bloodbank/blood_donors_report',$this->data);
		$this->load->view('templates/footer');	
		}
		else{
			show_404();
		}
	}
	function blood_components(){
		if($this->session->userdata('logged_in')){
		$this->load->helper('form');
		$this->data['title']="Blood & Components";
		$this->data['userdata']=$this->session->userdata('logged_in');
		$this->data['donors']=$this->reports_model->get_components();
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/reports_nav',$this->data);
		$this->load->view('pages/bloodbank/blood_components_report',$this->data);
		$this->load->view('templates/footer');	
		}
		else{
			show_404();
		}
	}
	function donation_summary(){
		if($this->session->userdata('logged_in')){
			$this->load->helper('form');
			$this->data['title']="Donations Summary";
			$this->data['userdata']=$this->session->userdata('logged_in');
			$this->data['hospitaldata']=$this->session->userdata('hospital');
			$this->data['summary']=$this->reports_model->get_donation_summary();
			$this->load->view('templates/header',$this->data);
			$this->load->view('templates/reports_nav',$this->data);
			$this->load->view('pages/bloodbank/panel_index',$this->data);
			$this->load->view('templates/footer');	
		}
		else{
			show_404();
		}
	}
	function issue_summary(){
		if($this->session->userdata('logged_in')){
		$this->load->helper('form');
		$this->data['title']="Issues Summary";
		$this->data['userdata']=$this->session->userdata('logged_in');
		$this->data['summary']=$this->reports_model->get_issue_summary();
		$this->data['staff']=$this->staff_model->staff_list();
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/reports_nav',$this->data);
		$this->load->view('pages/bloodbank/report_issues_summary',$this->data);
		$this->load->view('templates/footer');	
		}
		else{
			show_404();
		}
	}
		function invite_donor(){
		if($this->session->userdata('logged_in')){
		$this->load->helper('form');
		$this->load->library('email');
		$this->data['title']="Invite Donor";
		$this->data['userdata']=$this->session->userdata('logged_in');
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/panel_nav',$this->data);
		$this->data['camps']=$this->register_model->get_camps();
		if($this->input->post('submit')){
			$this->data['donors']=$this->reports_model->send_sms_email_invite();
          $this->data['msg']="Sms Sent.";			
		}
		$this->data['donors']=$this->reports_model->get_invite_donors();
		$this->load->view('pages/bloodbank/invite_donor',$this->data);
		$this->load->view('templates/footer');	
		}
		
		else {
			show_404();
		}
		
	}
	function available_blood(){
		if($this->session->userdata('logged_in')){
		$this->load->helper('form');
		$this->data['title']="Available Blood";
		$this->data['userdata']=$this->session->userdata('logged_in');
		$this->data['available']=$this->reports_model->get_available_blood();
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/reports_nav',$this->data);
		$this->load->view('pages/bloodbank/available_blood_report',$this->data);
		$this->load->view('templates/footer');	
		}
		else{
			show_404();
		}
	}
	function appointment_bookings(){
		if($this->session->userdata('logged_in')){
		$this->load->helper('form');
		$this->data['title']="User Panel";
		$this->data['userdata']=$this->session->userdata('logged_in');
		$this->data['appointments']=$this->reports_model->get_booked_appointments();
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/reports_nav',$this->data);
		$this->load->view('pages/bloodbank/appointment_bookings',$this->data);
		$this->load->view('templates/footer');	
		}
		else{
			show_404();
		}
	}

	function report_donations($camp="t",$blood_group=0,$sex=0,$donation_date=0,$from_date=0,$to_date=0,$from_num=0,$to_num=0){
		if($this->session->userdata('logged_in')){
		$this->load->helper('form');
		$this->data['title']="Donations detailed report";
		$this->data['userdata']=$this->session->userdata('logged_in');
		$this->data['camps']=$this->register_model->get_camps();
		$this->data['from_date']=$from_date;
		$this->data['to_date']=$to_date;
		$this->data['from_num']=$from_num;
		$this->data['to_num']=$to_num;
		$this->data['donated']=$this->reports_model->get_donated_blood($camp,$blood_group,$sex,$donation_date,$from_date,$to_date,$from_num=0,$to_num=0);
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/reports_nav',$this->data);
		$this->load->view('pages/bloodbank/report_donations',$this->data);
		$this->load->view('templates/footer');	
		}
		else{
			show_404();
		}
	}
	function report_inventory($blood_group=0,$component_type=0,$from_date=0,$to_date=0,$from_num=0,$to_num=0){
		if($this->session->userdata('logged_in')){
		$this->load->helper('form');
		$this->data['title']="Inventory detailed report";
		$this->data['userdata']=$this->session->userdata('logged_in');
		$this->data['from_date']=$from_date;
		$this->data['to_date']=$to_date;
		$this->data['from_num']=$from_num;
		$this->data['to_num']=$to_num;
		$this->data['inventory']=$this->reports_model->get_inventory($blood_group,$component_type,$from_date=0,$to_date=0,$from_num=0,$to_num=0);
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/reports_nav',$this->data);
		$this->load->view('pages/bloodbank/report_inventory',$this->data);
		$this->load->view('templates/footer');	
		}
		else{
			show_404();
		}
	}
	function report_screening($staff=-1,$from_date=0,$to_date=0,$screened_by=-1,$offset=1){
		
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');		
	  if($from_date == 0 && $to_date==0) {$from_date=date('Y-m-d',strtotime('-90 Days'));$to_date=date('Y-m-d');}
		$this->load->helper('form');
		$this->data['title']="User Panel";
		$this->data['staff']=$this->staff_model->staff_list();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$screening_result = $this->reports_model->get_screened_blood($staff,$from_date,$to_date,$screened_by,$offset);
		//To get total records
		$this->data['screened']= $screening_result;
		$this->form_validation->set_rules('from_date', 'From Date',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To Date', 
	    'trim|required|xss_clean');
		if($this->input->post('staff')) $department=$this->input->post('staff');
		if($this->input->post('from_date')) $from_date=date("Y-m-d",strtotime($this->input->post('from_date')));		
		if($this->input->post('to_date')) $to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
		if($this->input->post('screened_by')) $screened_by=$this->input->post('screened_by');
		$limit=500;
		$num_links=7/2;
		//To Get Number of records total count 
	//	$counttotal= $screening_result['rows'];
	/*	$search=$this->input->post('search');
		 $this->data['from_date']=$from_date;
		$this->data['to_date']=$to_date;
                $uri_segment=8;
                $offset= $this->uri->segment(8);
                if(!$offset){
                    $offset = 1;                
                } */
		$base_url = base_url()."bloodbank/user_panel/report_screening/"."$staff/$from_date/$to_date/$screened_by/";
	//	$this->pagination_string($offset,$base_url,$counttotal,$limit,$uri_segment,$num_links);
	//	$this->data['initial'] = ($offset-1)*$limit+1;
	//	$this->data['offset']=$offset;
	//	$this->data['counttotal']=$counttotal;
	//	$this->data['limit']=$limit;
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/reports_nav',$this->data);
		$this->load->view('pages/bloodbank/report_screening',$this->data);
		$this->load->view('templates/footer');	
		}
		else{
			show_404();
		}
		}
                
		// To implement Pagination Function separately 
		private function pagination_string($offset,$base_url,$counttotal,$limit,$uri_segment,$num_links)
		{
		$config = array();
		$page_url=$config['base_url'] = $base_url;
		$counttotal=$counttotal;
		$config['total_rows'] = $counttotal;
		$config['per_page'] = $limit;
		$config['uri_segment'] = $uri_segment;
		$config['use_page_numbers'] = TRUE;
		$config['num_links'] =$num_links;
		$config['cur_tag_open'] = '&nbsp;<a class="current" href="'.$page_url.'">';
        $config['cur_tag_close'] = '</a>';
		$config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
		 $this->pagination->initialize($config);
		 if($offset){
        $page = ($offset) ;
          }
        else{
			
               $page = $limit;
			
        }
		$str_links = $this->pagination->create_links();
		$this->data['page1'] = explode('&nbsp;',$str_links );
		}
                
	function report_issue($issue_date=0,$blood_group=0,$from_date=0,$to_date=0,$hospital=0){
		if($this->session->userdata('logged_in')){
		$this->load->helper('form');
		$this->data['staff']=$this->staff_model->staff_list();
		$this->data['staff']=$this->staff_model->staff_list();
		$this->data['title']="Issue Report";
		$this->data['userdata']=$this->session->userdata('logged_in');
		$this->data['issued']=$this->reports_model->get_issues($issue_date,$blood_group,$from_date,$to_date,$hospital);
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/reports_nav',$this->data);
		$this->load->view('pages/bloodbank/report_issue',$this->data);
		$this->load->view('templates/footer');	
		}
		else{
			show_404();
		}
	}
	function report_grouping(){
		if($this->session->userdata('logged_in')){
		$this->load->helper('form');
		$this->data['staff']=$this->staff_model->staff_list();
		$this->data['title']="User Panel";
		$this->data['userdata']=$this->session->userdata('logged_in');
		$this->data['grouped']=$this->reports_model->get_grouped_blood();
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/reports_nav',$this->data);
		$this->load->view('pages/bloodbank/report_grouping',$this->data);
		$this->load->view('templates/footer');	
		}
		else{
			show_404();
		}
	}
	function discard_report(){
		if($this->session->userdata('logged_in')){
		$this->load->helper('form');
		$this->data['title']="User Panel";
		$this->data['userdata']=$this->session->userdata('logged_in');
		$this->data['inventory']=$this->reports_model->get_discard_report();
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/reports_nav',$this->data);
		$this->load->view('pages/bloodbank/discard_report',$this->data);
		$this->load->view('templates/footer');	
		}
		else{
			show_404();
		}
	}
	function print_certificates(){
		if($this->session->userdata('logged_in')){
		if($to_date==0) {$to_date=date('Y-m-d');}	
		$this->load->helper('form');
		$this->data['title']="User Panel";
		$this->data['userdata']=$this->session->userdata('logged_in');
		$this->data['camps']=$this->register_model->get_camps();
		$this->data['donors']=$this->reports_model->get_donors();
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/reports_nav',$this->data);
		$this->load->view('pages/bloodbank/print_certificates',$this->data);
		$this->load->view('templates/footer');	
		}
		else{
			show_404();
		}
	}
	
	function hospital_issues(){
		if($this->session->userdata('logged_in')){
		$this->load->helper('form');
		$this->data['title']="Issues - Hospital wise";
		$this->data['userdata']=$this->session->userdata('logged_in');
		$this->data['summary']=$this->reports_model->get_hospital_issue_summary();
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/reports_nav',$this->data);
		$this->load->view('pages/bloodbank/hospital_issues',$this->data);
		$this->load->view('templates/footer');	
		}
		else{
			show_404();
		}
	}
         function discard_summary($from_date=0,$to_date=0){     /*discard summary function*/
        {
	if(!$this->session->userdata('logged_in')){                                         
		show_404();
                
        }
	$this->data['userdata']=$this->session->userdata('logged_in');
	foreach ($this->data['functions'] as $f ){
		if($f->user_function=="Bloodbank"){
		$access=1;
		}		
		}
		if ($access == 0) {
                show_404();
            }
            $this->load->helper('form');
		$this->data['title']="Discarded Blood";
                $this->data['from_date']=$from_date;
		$this->data['to_date']=$to_date;
		$this->data['userdata']=$this->session->userdata('hospital');
		$this->data['discard']=$this->reports_model->get_discard_inventory_detail($from_date=0,$to_date=0);   /*model call in reports model*/
		$this->load->view('templates/header',$this->data);                           /*loading header*/
                $this->load->view('templates/reports_nav',$this->data);                     /*loading reports nav*/
		$this->load->view('pages/bloodbank/discard_summary',$this->data);         /*loading page discard_summary in views*/
                $this->load->view('templates/footer');		                         /*loading footer*/
        }
	
	}
}
