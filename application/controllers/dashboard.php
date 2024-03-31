<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->dashboard_access=0;
		$this->load->model('staff_model');
		if($this->session->userdata('logged_in')){
		$userdata=$this->session->userdata('logged_in');
			$user_id=$userdata['user_id'];
			$this->data['hospitals']=$this->staff_model->user_hospital($user_id);
			$this->data['functions']=$this->staff_model->user_function($user_id);
			$this->data['departments']=$this->staff_model->user_department($user_id);
                	foreach($this->data['functions'] as $function){
		            if($function->user_function=="dashboard"){
		                    $this->dashboard_access=1;
		            }
                	}
		}
		$this->data['op_forms']=$this->staff_model->get_forms("OP");
		$this->data['ip_forms']=$this->staff_model->get_forms("IP");
		$this->load->model('dashboard_model');
		$this->data['hosptial_ownership_np'] = $this->dashboard_model->get_organizations_by_type('', 'non-profit');
		//$this->load->view('pages/dashboard_refresh');
	}

	public function view($organization="")
	{
		if ($this->dashboard_access == 1) {
			$this->load->model('reports_model');
			if(!!$organization) //if $organization variable is not empty
			{
				$this->load->helper('form');
				$this->data['organization']=$organization;
				$this->data['report']=$this->reports_model->dashboard($organization);
				$this->data['title']=$this->data['report'][0];
				$this->load->view('templates/header',$this->data);
				$this->load->view('pages/dashboard',$this->data);
			}
			else{
				show_404();
			}
			$this->load->view('templates/footer');
		}
		else{
			show_404();
		}
	}

	public function state($state=""){
		if ($this->dashboard_access == 1) {
			$this->load->model('reports_model');
			if(!!$state) //if $organization variable is not empty
			{
				$this->load->helper('form');
				$this->data['state']=$state;
				$this->data['result']=$this->reports_model->dashboard("","state",$state);
				$this->data['title']=$this->data['result'][0];
				$this->data['report']=$this->data['result'][1];
				$this->load->view('templates/header',$this->data);
				$this->load->view('pages/state_dashboard',$this->data);

			}
			else{
			show_404();
			}
			$this->load->view('templates/footer');
		}
		else{
			show_404();
		}
}
public function helpline()
{
	if ($this->dashboard_access == 1) {
		$this->load->helper('form');
		$this->data['title']="Helpline Dashboard";
		$this->load->model('helpline_model');
		$this->load->model('staff_model');
		$this->data['district_report']=$this->helpline_model->dashboard('district');
		$this->data['volunteer_report']=$this->helpline_model->dashboard('volunteer');
		$this->data['call_type_report']=$this->helpline_model->dashboard('call_type');
		$this->data['customer_distinct_report']=$this->helpline_model->dashboard('customer_distinct');
		$this->data['call_type_in_report']=$this->helpline_model->dashboard('call_type_in');
		$this->data['call_type_out_report']=$this->helpline_model->dashboard('call_type_out');
		$this->data['caller_type']=$this->helpline_model->get_caller_type();
		$this->data['call_category']=$this->helpline_model->get_call_category();
		$this->data['all_hospitals']=$this->staff_model->get_hospital();
		$this->data['hospital_districts']=$this->helpline_model->get_hospital_district();
		$this->data['helpline']=$this->helpline_model->get_helpline();
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/helpline/helpline_dashboard',$this->data);
		$this->load->view('templates/footer');
	}
	else{
		show_404();
	}
}

//newly added on march-25-2024
public function caller_type_report()
{
	if ($this->dashboard_access == 1) 
	{
		$this->load->helper('form');
		$this->data['title']="Helpline Dashboard";
		$this->load->model('helpline_model');
		$this->load->model('staff_model');
		$this->data['caller_type_report']=$this->helpline_model->dashboard('caller_type'); //this to move
		$this->data['caller_type']=$this->helpline_model->get_caller_type();
		$this->data['call_category']=$this->helpline_model->get_call_category();
		$this->data['all_hospitals']=$this->staff_model->get_hospital();
		$this->data['hospital_districts']=$this->helpline_model->get_hospital_district();
		$this->data['helpline']=$this->helpline_model->get_helpline();
		$this->load->view('templates/header',$this->data);
		//$this->load->view('pages/helpline/helpline_dashboard',$this->data);
		$this->load->view('pages/helpline/caller_type_report',$this->data);
		$this->load->view('templates/footer');
	}
	else{
		show_404();
	}
}

public function call_category_report()
{
	if ($this->dashboard_access == 1) 
	{
		$this->load->helper('form');
		$this->data['title']="Helpline Dashboard";
		$this->load->model('helpline_model');
		$this->load->model('staff_model');
		$this->data['call_category_report']=$this->helpline_model->dashboard('call_category'); //this to move
		$this->data['caller_type']=$this->helpline_model->get_caller_type();
		$this->data['call_category']=$this->helpline_model->get_call_category();
		$this->data['all_hospitals']=$this->staff_model->get_hospital();
		$this->data['hospital_districts']=$this->helpline_model->get_hospital_district();
		$this->data['helpline']=$this->helpline_model->get_helpline();
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/helpline/call_category_report',$this->data);
		$this->load->view('templates/footer');
	}
	else{
		show_404();
	}
}

public function hospital_report()
{
	if ($this->dashboard_access == 1) 
	{
		$this->load->helper('form');
		$this->data['title']="Helpline Dashboard";
		$this->load->model('helpline_model');
		$this->load->model('staff_model');
		$this->data['hospital_report']=$this->helpline_model->dashboard('hospital'); //this to move
		$this->data['caller_type']=$this->helpline_model->get_caller_type();
		$this->data['call_category']=$this->helpline_model->get_call_category();
		$this->data['all_hospitals']=$this->staff_model->get_hospital();
		$this->data['hospital_districts']=$this->helpline_model->get_hospital_district();
		$this->data['helpline']=$this->helpline_model->get_helpline();
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/helpline/hospital_report',$this->data);
		$this->load->view('templates/footer');
	}
	else{
		show_404();
	}
}

public function to_number_report()
{
	if ($this->dashboard_access == 1) 
	{
		$this->load->helper('form');
		$this->data['title']="Helpline Dashboard";
		$this->load->model('helpline_model');
		$this->load->model('staff_model');
		$this->data['to_number_report']=$this->helpline_model->dashboard('to_number'); //this to move
		$this->data['caller_type']=$this->helpline_model->get_caller_type();
		$this->data['call_category']=$this->helpline_model->get_call_category();
		$this->data['all_hospitals']=$this->staff_model->get_hospital();
		$this->data['hospital_districts']=$this->helpline_model->get_hospital_district();
		$this->data['helpline']=$this->helpline_model->get_helpline();
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/helpline/to_number_report',$this->data);
		$this->load->view('templates/footer');
	}
	else{
		show_404();
	}
}

public function op_ip_report()
{
	if ($this->dashboard_access == 1) 
	{
		$this->load->helper('form');
		$this->data['title']="Helpline Dashboard";
		$this->load->model('helpline_model');
		$this->load->model('staff_model');
		$this->data['op_ip_report']=$this->helpline_model->dashboard('op_ip'); //this to move
		$this->data['caller_type']=$this->helpline_model->get_caller_type();
		$this->data['call_category']=$this->helpline_model->get_call_category();
		$this->data['all_hospitals']=$this->staff_model->get_hospital();
		$this->data['hospital_districts']=$this->helpline_model->get_hospital_district();
		$this->data['helpline']=$this->helpline_model->get_helpline();
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/helpline/op_ip_report_helpline',$this->data);
		$this->load->view('templates/footer');
	}
	else{
		show_404();
	}
}

public function duration()
{
	if ($this->dashboard_access == 1) 
	{
		$this->load->helper('form');
		$this->data['title']="Helpline Dashboard";
		$this->load->model('helpline_model');
		$this->load->model('staff_model');
		$this->data['duration']=$this->helpline_model->dashboard('duration'); //this to move
		$this->data['caller_type']=$this->helpline_model->get_caller_type();
		$this->data['call_category']=$this->helpline_model->get_call_category();
		$this->data['all_hospitals']=$this->staff_model->get_hospital();
		$this->data['hospital_districts']=$this->helpline_model->get_hospital_district();
		$this->data['helpline']=$this->helpline_model->get_helpline();
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/helpline/duration',$this->data);
		$this->load->view('templates/footer');
	}
	else{
		show_404();
	}
}

// 204208 start
public function receiver(){
	if ($this->dashboard_access == 1) {
		$this->load->helper('form');
		$this->data['title']="Receiver Dashboard";
		$this->load->model('helpline_model');
		$this->load->model('staff_model');
		$this->data['caller_type_report']=$this->helpline_model->dashboard('caller_type');
		$this->data['call_category_report']=$this->helpline_model->dashboard('call_category');
		$this->data['hospital_report']=$this->helpline_model->dashboard('hospital');
		$this->data['district_report']=$this->helpline_model->dashboard('district');
		$this->data['volunteer_report']=$this->helpline_model->dashboard('volunteer');
		$this->data['call_type_report']=$this->helpline_model->dashboard('call_type');
		$this->data['customer_distinct_report']=$this->helpline_model->dashboard('customer_distinct');
		$this->data['call_type_in_report']=$this->helpline_model->dashboard('call_type_in');
		$this->data['call_type_out_report']=$this->helpline_model->dashboard('call_type_out');
		$this->data['to_number_report']=$this->helpline_model->dashboard('to_number');
		$this->data['op_ip_report']=$this->helpline_model->dashboard('op_ip');
		$this->data['duration']=$this->helpline_model->dashboard('duration');
		$this->data['caller_type']=$this->helpline_model->get_caller_type();
		$this->data['call_category']=$this->helpline_model->get_call_category();
		$this->data['all_hospitals']=$this->staff_model->get_hospital();
		$this->data['hospital_districts']=$this->helpline_model->get_hospital_district();
		$this->data['helpline']=$this->helpline_model->get_helpline();
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/helpline/receiver',$this->data);
		$this->load->view('templates/footer');
	}
	else{
		show_404();
	}
}
//204208 end
public function helpline_voicemail(){
	if ($this->dashboard_access == 1) {
		$this->load->helper('form');
		$this->data['title']="Helpline Services Dashboard";
		$this->load->model('helpline_model');
		$this->load->model('staff_model');
		$this->data['caller_type_report']=$this->helpline_model->dashboard('caller_type',1);
		$this->data['call_category_report']=$this->helpline_model->dashboard('call_category',1);
		$this->data['hospital_report']=$this->helpline_model->dashboard('hospital',1);
		$this->data['district_report']=$this->helpline_model->dashboard('district',1);
		$this->data['volunteer_report']=$this->helpline_model->dashboard('volunteer',1);
		$this->data['call_type_report']=$this->helpline_model->dashboard('call_type',1);
		$this->data['to_number_report']=$this->helpline_model->dashboard('to_number',1);
		$this->data['op_ip_report']=$this->helpline_model->dashboard('op_ip',1);
		$this->data['duration']=$this->helpline_model->dashboard('duration',1);
		$this->data['resolution_status']=$this->helpline_model->dashboard('resolution_status',1);
		$this->data['closed_tat']=$this->helpline_model->dashboard('closed_tat',1);
		$this->data['open_tat']=$this->helpline_model->dashboard('open_tat',1);
		$this->data['caller_type']=$this->helpline_model->get_caller_type();
		$this->data['call_category']=$this->helpline_model->get_call_category();
		$this->data['all_hospitals']=$this->staff_model->get_hospital();
		$this->data['hospital_districts']=$this->helpline_model->get_hospital_district();
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/helpline/helpline_voicemail_dashboard',$this->data);
		$this->load->view('templates/footer');
	}
	else{
		show_404();
	}
}
	public function diagnostics_dashboard_1(){
		if ($this->dashboard_access == 1) {
			$this->data['title']="Diagnostics Dashboard - 1";
			$this->load->model('reports_model');
			$this->data['report']=$this->reports_model->diagnostic_dashboard_HospitalWise();
			$this->data['report1']=$this->reports_model->diagnostic_dashboard_AreaWise();
			$this->load->view('templates/header',$this->data);
			$this->load->helper('form');
			$this->load->view('pages/diagnostics_dashboard_1',$this->data);
			$this->load->view('templates/footer');
		} else{
			show_404();
		}
	}

	public function diagnostics_dashboard_2(){
		if ($this->dashboard_access == 1) {
			$this->data['title']="Diagnostics Board - 2";
			$this->load->model('reports_model');
			$this->data['report']=$this->reports_model->diagnostic_board();
			$this->data['report1']=$this->reports_model->diagnostic_board('lab_area');
			$this->load->view('templates/header',$this->data);
			$this->load->view('pages/diagnostics_dashboard_2',$this->data);
			$this->load->view('templates/footer');
		}else{
			show_404();
		}
	}

	public function diagnostic_dashboard_hospitalwise($hospital_type=" "){
		$this->data['title']="Diagnostics Board";
		$this->data['type']="$hospital_type";
		$this->load->model('reports_model');
		$this->data['report']=$this->reports_model->diagnostic_hospital_board($hospital_type);
		$this->data['report1']=$this->reports_model->diagnostic_hospital_board($hospital_type,'lab_area');
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/diagnostic_dashboard_hospitalwise',$this->data);
		$this->load->view('templates/footer');
	}
	/**
	* diagnostics_dashboard_1
	* diagnostics_dashboard_2
	* diagnostic_board_hospital
	* Added by : Manish Kumar
	*
	**/

	public function helpline_trend(){
		$this->load->helper('form');
		$this->data['title']="Helpline Trend Dashboard";
		$this->load->model('helpline_model');
		$this->load->model('staff_model');
		$this->data['caller_type']=$this->helpline_model->get_caller_type();
		$this->data['call_category']=$this->helpline_model->get_call_category();
		$this->data['resolution_status']=$this->helpline_model->get_resolution_status();
		$this->data['all_hospitals']=$this->staff_model->get_hospital();
		$this->data['hospital_districts']=$this->helpline_model->get_hospital_district();
		$this->data['report']=$this->helpline_model->helpline_trend();
		$this->data['helpline']=$this->helpline_model->get_helpline();
		//var_dump($this->data['report']);
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/helpline/helpline_trend',$this->data);
		$this->load->view('templates/footer');
	}

	public function bloodbanks(){
		if ($this->dashboard_access == 1) {
			$this->load->helper('form');
			$this->data['title']="Blood Banks Dashboard";
			$this->load->model('bloodbank/reports_model');
			$this->data['available']=$this->reports_model->get_available_blood(1);
			$this->load->view('templates/header',$this->data);
			$this->load->view('pages/bloodbank/bloodbank_dashboard',$this->data);
			$this->load->view('templates/footer');
		}
		else{
			show_404();
		}
	}
	public function hospital($organization=""){		//$organization==$organization_type dashboard/hospital/npo
		$this->load->model('reports_model');
		$hospitalstarts=$this->reports_model->dashboard($organization,'hospital');
		$this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($hospitalstarts));
	}
	public function department($organization=""){
		$this->load->model('reports_model');
		$deptstarts=$this->reports_model->dashboard($organization,'department');
		$this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($deptstarts));

	}
	public function district($organization=""){
		$this->load->model('reports_model');
		$diststarts=$this->reports_model->dashboard($organization,'district');
		$this->output
        ->set_content_type('application/json')
        ->set_output(json_encode($diststarts));

	}
	public function org($organization_name=FALSE) {
		if ($this->dashboard_access == 1) {
			$organization_name = $this->uri->segment(3);
			$this->data['title']="Summary By Organization";
			if(!$organization_name)
				$organization_name = $this->input->get_post('organization_name') ? $this->input->get_post('organization_name') : FALSE;
			if(!$organization_name)
				show_404();
			
			//$this->load->model('dashboard_model');
			$this->data['op_summary'] = $this->dashboard_model->get_hos_summary_by_type_by_visit('OP', false, false, $organization_name, false, false, false, false);
			$this->data['ip_summary'] = $this->dashboard_model->get_hos_summary_by_type_by_visit('IP', false, false, $organization_name, false, false, false, false);
			$this->data['distinct_patient_summary'] = $this->dashboard_model->get_hos_summary_by_type_by_patient('OP', false, false, $organization_name, false, false, false, false);
			$this->data['organization_name'] = $organization_name;
			$this->data['dist_states'] = $this->dashboard_model->get_distinct_states();
			$this->load->helper('form');
			$this->load->view('templates/header',$this->data);
			$this->load->view('pages/organization_wise_dashboard',$this->data);
			$this->load->view('templates/footer');
		}
		else{
			show_404();
		}
	}

	public function org_type($organization_type=FALSE) {
		if ($this->dashboard_access == 1) {
			$organization_type = $this->uri->segment(3);
			$this->data['title']="Summary By Organization";
			if(!$organization_type)
				$organization_type = $this->input->get_post('organization_type') ? $this->input->get_post('organization_type') : FALSE;
			if(!$organization_type)
				show_404();
			
			//$this->load->model('dashboard_model');
			$this->data['op_summary'] = $this->dashboard_model->get_hos_summary_by_type_by_visit('OP', 'type2', $organization_type, false, false, false, false, false);
			$this->data['ip_summary'] = $this->dashboard_model->get_hos_summary_by_type_by_visit('IP', 'type2', $organization_type, false, false, false, false, false, false);
			$this->data['distinct_patient_summary'] = $this->dashboard_model->get_hos_summary_by_type_by_patient('OP', 'type2', $organization_type, false, false, false, false, false, false);
			$this->data['organization_type'] = $organization_type;
			$this->load->helper('form');
			$this->load->view('templates/header',$this->data);
			$this->load->view('pages/organization_type_dashboard',$this->data);
			$this->load->view('templates/footer');
		}
		else{
			show_404();
		}
	}

	function helpline_unique_callers()
	{
		if ($this->dashboard_access == 1) 
		{
			$this->load->helper('form');
			$this->data['title']="Helpline Trend Unique Callers";
			$this->load->model('helpline_model');
			$this->load->model('staff_model');
			
			$this->data['all_hospitals']=$this->staff_model->get_hospital();
			$this->data['hospital_districts']=$this->helpline_model->get_hospital_district();
			$this->data['report']=$this->helpline_model->helpline_trend_unic();
			$this->data['helpline']=$this->helpline_model->get_helpline();
			
			$this->load->view('templates/header',$this->data);
			$this->load->view('pages/helpline/helpline_trend_unique_callers',$this->data);
			$this->load->view('templates/footer');
		}
		else
		{
			show_404();
		}
	}
}
