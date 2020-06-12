<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Faq extends CI_Controller {

	public function index()
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

