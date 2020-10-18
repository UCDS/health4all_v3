<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class documentation extends CI_Controller {
	function __construct(){
		parent::__construct();
        $this->load->model('staff_model');
        $this->load->model('documentation_model');
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
			$this->data['title']="User Documents";
            $this->load->view('templates/header',$this->data);
            $this->load->view('pages/documentation_view');
            $this->load->view('templates/footer');
	}
	public function documents()
	{
            if($this->session->userdata('logged_in')){
                $this->data['userdata']=$this->session->userdata('logged_in');
                $access=0;
                foreach($this->data['functions'] as $function){
                    if($function->user_function=="documentation"){
                            $access=1;
                    }
                }
                if($access==1){
                    $this->data['title']="User Documents";
                    $this->load->view('templates/header',$this->data);
                    $this->load->helper('form');
                    $this->load->library('form_validation');
                    $this->data['report']=$this->documentation_model->get_documentation();
                    $this->load->view('pages/documentation_view',$this->data);
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