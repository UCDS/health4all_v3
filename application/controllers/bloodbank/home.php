<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
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
		$this->load->model('bloodbank/reports_model');
		if($this->session->userdata('logged_in')){
			$this->data['userdata']=$this->session->userdata('hospital');
		}
		$this->data['title']="Home";
		$this->data['available']=$this->reports_model->get_available_blood();
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/donate_nav');
		$this->load->view('pages/bloodbank/home',$this->data);
		$this->load->view('templates/footer');
	}
	public function faq()
	{
		if($this->session->userdata('logged_in')){
			$this->data['userdata']=$this->session->userdata('hospital');
		}
		$this->data['title']="FAQ";
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/donate_nav');
		$this->load->view('pages/bloodbank/faq');
		$this->load->view('templates/footer');
	}
}

