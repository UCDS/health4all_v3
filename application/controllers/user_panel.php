<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_panel extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('reports_model');		
		$this->load->model('staff_model');	
		$this->load->model('masters_model');	
		$this->load->model('helpline_model');	
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

	function form_layout(){
		if($this->session->userdata('logged_in')){
		$this->load->helper('form');
		$this->data['title']="User Panel";
		$this->data['userdata']=$this->session->userdata('logged_in');
		$this->data['print_layouts']=$this->staff_model->get_print_layouts();
                // $this->load->library('dummy_data');
                // $this->data['registered']=new Dummy_data();
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/form_layout',$this->data);
		$this->load->view('templates/footer');	
		}
		else{
			show_404();
		}
	}

	function create_user(){
		if($this->session->userdata('logged_in')){
			$this->load->helper('form');
			$this->data['title']="Create User";
			$this->data['userdata']=$this->session->userdata('logged_in');
			$this->data['user_functions']=$this->staff_model->get_user_function();
			$this->data['hospital']=$this->staff_model->get_hospital();
			$this->data['staff']=$this->staff_model->get_staff();
			$this->load->view('templates/header',$this->data);
			$this->load->view('templates/leftnav',$this->data);
			$this->load->library('form_validation');
			$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
			if ($this->form_validation->run() === FALSE){
				$this->load->view('pages/create_user',$this->data);
			}
			else{
				if($this->staff_model->create_user()){
					$this->data['msg']="User created successfully";
					$this->load->view('pages/create_user',$this->data);
				}
				else{
					$this->data['msg']="Error creating user. Please retry.";
					$this->load->view('pages/create_user',$this->data);
				}
			}
			$this->load->view('templates/footer');	
		}
		else{
			show_404();
		}
	}

	function edit_user(){
		if($this->session->userdata('logged_in')){
		$this->load->helper('form');
		$this->data['title']="Edit User";
		$this->data['userdata']=$this->session->userdata('logged_in');
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/leftnav',$this->data);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user', 'Username', 'trim|xss_clean');
		if ($this->form_validation->run() === FALSE){
			$this->data['user']=$this->masters_model->get_data("user");
			$this->data["staff"]=$this->staff_model->get_staff();
			$this->load->view('pages/edit_user',$this->data);
		}
		else{
			if($this->input->post('update')){
				if($this->masters_model->update_data("user")){
					$this->data['msg']="Updated Successfully";
					$this->data["user_functions"]=$this->staff_model->get_user_function();
					$this->data["staff"]=$this->staff_model->get_staff();
				}
				else{
					$this->data['msg']="Failed";
					$this->load->view('pages/edit_user',$this->data);
				}
			}
			else if($this->input->post('select')){
            $this->data['mode']="select";
			$this->data["user_functions"]=$this->staff_model->get_user_function();
			$this->data["staff"]=$this->staff_model->get_staff();
			$this->data['user']=$this->masters_model->get_data("user");
   			}
			$this->data["user"]=$this->masters_model->get_data("user");
			$this->load->view('pages/edit_user',$this->data);	
			}
		 $this->load->view('templates/footer');	
		}
	}

	function create_form(){
		if($this->session->userdata('logged_in')){
				if($this->staff_model->upload_form()){
					echo 1;
				}
				else echo 0;
		}
	}

	function settings(){
		if($this->session->userdata('logged_in')){
		$this->load->helper('form');
		$this->data['title']="User Panel";
		$this->data['userdata']=$this->session->userdata('logged_in');
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/leftnav',$this->data);
		$this->load->view('pages/settings',$this->data);
		$this->load->view('templates/footer');	
		}
		else{
			show_404();
		}
	}	
	
	function change_password(){
		if($this->session->userdata('logged_in')){
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['title']="Change password";
		$this->data['userdata']=$this->session->userdata('logged_in');
		$user_id=$this->data['userdata']['user_id'];
		$this->load->view('templates/header',$this->data);
		$this->form_validation->set_rules('password','Password','required|trim|xss_clean');
 		if ($this->form_validation->run() === FALSE)
		{
		$this->load->view('pages/change_password',$this->data);
		}
		else{
			if($this->staff_model->change_password($user_id)){
				$this->data['msg']="Password has been changed successfully";
			}
			else{
				$this->data['msg']="Password could not be changed";
			}
		$this->load->view('pages/change_password',$this->data);
		}
		$this->load->view('templates/footer');	
		}
		else{
			show_404();
		}
	}

	function user_hospital_link() {
		if($this->session->userdata('logged_in')){
			$this->load->helper('form');
			$this->data['title']="Link User To Hospitals";
			$this->data['userdata']=$this->session->userdata('logged_in');
			if($this->input->post('submit')){
				$this->data['status'] = $this->staff_model->user_hospital_link();
				$this->data['user'] = $this->staff_model->get_user();
				$this->data['hptls']= false;
			}else if(!$this->input->post('select')){
				$this->data['user'] = $this->staff_model->get_user();
				$this->data['hptls']= false;
			}else {
				$this->data['hptls'] = $this->staff_model->get_hospital();
				$this->data['user_hptls'] = $this->staff_model->get_user_hospitals();
			}			
			$this->load->view('templates/header',$this->data);
			$this->load->view('templates/leftnav',$this->data);			
			$this->load->view('pages/user_hospital_link',$this->data);
			$this->load->view('templates/footer');
		}
		else{
			show_404();
		}
	}

	function helpline_access(){
		if($this->session->userdata('logged_in')){
		$this->load->helper('form');
		$this->data['title']="User Helpline Access";
		$this->data['userdata']=$this->session->userdata('logged_in');
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/leftnav',$this->data);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user', 'User ID', 'trim|xss_clean');
		if ($this->form_validation->run() === FALSE){
			$this->data['user']=$this->masters_model->get_data("user");
			$this->load->view('pages/helpline/edit_helpline_access',$this->data);
		}
		else{
			if($this->input->post('update')){
				if($this->helpline_model->update_access()){
					$this->data['msg']="Updated Successfully";
					$this->data["helpline_numbers"]=$this->helpline_model->get_helpline("all", 0);
					$this->data['user_helpline']=$this->helpline_model->get_user_access();
				}
				else{
					$this->data['msg']="Failed";
					$this->load->view('pages/helpline/edit_helpline_access',$this->data);
				}
			}
			else if($this->input->post('select')){
				$this->data['mode']="select";
				$this->data["helpline_numbers"]=$this->helpline_model->get_helpline("all", 0);
				$this->data['user_helpline']=$this->helpline_model->get_user_access();
			}
			$this->data["user"]=$this->masters_model->get_data("user");
			$this->load->view('pages/helpline/edit_helpline_access',$this->data);	
		}
		 $this->load->view('templates/footer');	
		}
	}

	
}
