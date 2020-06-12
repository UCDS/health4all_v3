<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Help extends CI_Controller {	

	function __construct(){
		parent::__construct();
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

	public function index()
	{
			$this->data['title']="Help";
			$this->load->view('templates/header',$this->data);

					$this->load->view('pages/help');

		$this->load->view('templates/footer');
	}

}

