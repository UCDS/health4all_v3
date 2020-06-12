<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Create_slots extends CI_Controller {
	function __construct(){
		parent::__construct();
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
	public function index()
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
		if($access==0)
		show_404();
		$this->data['userdata']=$this->session->userdata('hospital');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['title']="Create Slots";
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/panel_nav',$this->data);
	    $this->form_validation->set_rules('from_date', 'From Date', 
	    'required|xss_clean');
	    $this->form_validation->set_rules('to_date', 'To date', 
	    'required|xss_clean');
	    $this->form_validation->set_rules('days', 'Working Days', 
	    'required|xss_clean');
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('pages/bloodbank/create_slots');
		}
		else{
			$this->load->model('bloodbank/slots_model');
			if($this->slots_model->create()){
				$this->data['msg']="<b style='color:green'>Slots have been created.</b>";
				$this->load->view('pages/bloodbank/create_slots',$this->data);
			}
			else{
				$this->data['msg']="<b style='color:red'>There was an error in creating the slots. Please retry.</b>";
				$this->load->view('pages/bloodbank/create_slots',$this->data);
			}
		}
		
		$this->load->view('templates/footer');
		
	}
}
