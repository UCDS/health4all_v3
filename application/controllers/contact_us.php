<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class contact_us extends CI_Controller {	

	function __construct(){
		parent::__construct();
		$this->load->model('staff_model');
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
		$this->data['defaultsConfigs']=$this->masters_model->get_data("defaults");
	}

	public function index()
	{
			$this->data['title']="Contact us";
			$this->load->view('templates/header',$this->data);

					$this->load->view('pages/contact_us');

		$this->load->view('templates/footer');
	}
        
        }

