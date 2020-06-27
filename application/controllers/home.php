<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('staff_model');
		if($this->session->userdata('logged_in')){
			$userdata = $this->session->userdata('logged_in');
			$user_id = $userdata['user_id'];
			$this->data['hospitals']=$this->staff_model->user_hospital($user_id);
			$this->data['functions']=$this->staff_model->user_function($user_id);
			$this->data['departments']=$this->staff_model->user_department($user_id);
			$this->data['op_forms']=$this->staff_model->get_forms("OP");
			$this->data['ip_forms']=$this->staff_model->get_forms("IP");
		}
	}
	public function index(){
		$this->data['title']="Home";
		$this->load->helper('form');
		if($this->session->userdata('logged_in')){
			$this->data['title']="Home";
			if(count($this->data['hospitals'])>1){
			$this->load->library('form_validation');
				$this->form_validation->set_rules('organisation', 'Organisation',
				'trim|required|xss_clean');
				if ($this->form_validation->run() === FALSE)
				{
					$this->load->view('templates/header',$this->data);
					$this->load->view('pages/user_home',$this->data);
				}
				else{
					if($this->input->post('organisation')){
						foreach($this->data['hospitals'] as $row){
							if($row->hospital_id==$this->input->post('organisation')){
								$sess_array = array(
								 'hospital_id' => $row->hospital_id,
								 'hospital' => $row->hospital,
								 'hospital_short_name' => $row->hospital_short_name,
								 'description' => $row->description,
								 'place' => $row->place,
								 'district' => $row->district,
								 'state' => $row->state,
								 'logo' => $row->logo
								);
								$this->session->set_userdata('hospital',$sess_array);
								break;
							}
						}
						$this->data['op_forms']=$this->staff_model->get_forms("OP");
						$this->data['ip_forms']=$this->staff_model->get_forms("IP");
						$this->load->view('templates/header',$this->data);
						$this->load->view('pages/user_home',$this->data);
					}
				}
			}
			else{
				foreach($this->data['hospitals'] as $row){
					$sess_array = array(
						'hospital_id' => $row->hospital_id,
						'hospital' => $row->hospital,
						'hospital_short_name' => $row->hospital_short_name,
						'description' => $row->description,
						'place' => $row->place,
						'district' => $row->district,
						'state' => $row->state,
						'logo' => $row->logo
					);
					$this->session->set_userdata('hospital',$sess_array);
					$this->session->set_userdata('place',array('camp_id'=>0,'name'=>'Blood Bank'));
					break;
				}
				$this->data['op_forms']=$this->staff_model->get_forms("OP");
				$this->data['ip_forms']=$this->staff_model->get_forms("IP");
				$this->load->view('templates/header',$this->data);
				$this->load->view('pages/user_home',$this->data);
			}
		}
		else{ 
			$this->load->view('templates/header',$this->data);
			$this->load->view('pages/home',$this->data);
		}
		$this->load->view('templates/footer');
	}
	public function login()
	{
		$this->load->helper('form');
		if($this->session->userdata('logged_in')){
			$this->data['title']="Home";
			if(count($this->data['hospitals'])>1){
				$this->load->library('form_validation');
				$this->form_validation->set_rules('organisation', 'Organisation',
				'trim|required|xss_clean');
				if ($this->form_validation->run() === FALSE)
				{
					$this->load->view('templates/header',$this->data);
					$this->load->view('pages/user_home',$this->data);
				}
				else{
					if($this->input->post('organisation')){
						foreach($this->data['hospitals'] as $row){
							if($row->hospital_id==$this->input->post('organisation')){
								$sess_array = array(
								 'hospital_id' => $row->hospital_id,
								 'hospital' => $row->hospital,
								 'hospital_short_name' => $row->hospital_short_name,
								 'description' => $row->description,
								 'place' => $row->place,
								 'district' => $row->district,
								 'state' => $row->state,
								 'logo' => $row->logo
								);
								$this->session->set_userdata('hospital',$sess_array);
								break;
							}
						}
						$this->data['op_forms']=$this->staff_model->get_forms("OP");
						$this->data['ip_forms']=$this->staff_model->get_forms("IP");
						$this->load->view('templates/header',$this->data);
						$this->load->view('pages/user_home',$this->data);
					}
				}
			}
			else{
				foreach($this->data['hospitals'] as $row){
					$sess_array = array(
						'hospital_id' => $row->hospital_id,
						'hospital' => $row->hospital,
						'hospital_short_name' => $row->hospital_short_name,
						'description' => $row->description,
						'place' => $row->place,
						'district' => $row->district,
						'state' => $row->state,
						'logo' => $row->logo
					);
					$this->session->set_userdata('hospital',$sess_array);
					$this->session->set_userdata('place',array('camp_id'=>0,'name'=>'Blood Bank'));
					break;
				}
				$this->data['op_forms']=$this->staff_model->get_forms("OP");
				$this->data['ip_forms']=$this->staff_model->get_forms("IP");
				$this->load->view('templates/header',$this->data);
				$this->load->view('pages/user_home',$this->data);
			}
		}		
		else{
			if(!$this->session->userdata('logged_in')){
				$captcha_word = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);			
				$this->load->helper('captcha');
				$captcha_config = array(   
					'word'          => $captcha_word,
					'img_path'	=> './assets/captcha/',
					'font_path' => './assets/fonts/extraBoldItalic.ttf',
					'img_url'	=> base_url().'assets/captcha/',                
					'img_width'	=> '150',
					'img_height'    => 30,
					'expiration'    => 300
				);				
				$cap_link = create_captcha($captcha_config);
				$this->data['image'] = $cap_link['image'];
				$this->session->set_userdata(strtoupper($captcha_word), true);

				$this->data['title']="Login";
				$this->load->view('templates/header',$this->data);
				$this->load->helper('form');
				$this->load->library('form_validation');				
				$this->form_validation->set_rules('username', 'Username', 'trim|required|xss_clean');
				$this->form_validation->set_rules('captcha_text', 'Captcha', 'trim|required|xss_clean');
				$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');
				if ($this->form_validation->run() === FALSE)
				{
					$this->load->view('pages/login');
				}
				else{
					$defaults = $this->staff_model->get_defaults();
					 if($defaults != false) {
						foreach($defaults as $def) {
							$this->session->set_userdata($def->primary_key, $def->default_value_text);
						}
					 }
					redirect('home', 'refresh');
				}
				
				$this->load->view('templates/footer');
			}
			else {
				redirect('home','refresh');
			}
		}
		$this->load->view('templates/footer');		
	}

	
	
	function check_database($password){
		$this->load->model('staff_model');
	   //Field validation succeeded.  Validate against database
	   $username = $this->input->post('username');
	   $captcha_text = $this->input->post('captcha_text');
	   
	   if(!strtoupper($this->session->userdata(strtoupper($captcha_text)))){
		   $this->session->unset_userdata(strtoupper($captcha_text));
			$this->form_validation->set_message('check_database','Invalid Username or Password or Captcha');
			return false;
	   }
	   //query the database
	   $result = $this->staff_model->login($username, $password);
	   if($result)
	   {
	     foreach($result as $row)
	     {
			 $staff_details = $this->staff_model->get_staff_details($row->staff_id);
	         $sess_array = array(
	         'user_id' => $row->user_id,
			 'username' => $row->username,
			 'staff_id' => $row->staff_id,
			 'staff_first_name' => $staff_details->first_name,
			 'staff_last_name' => $staff_details->last_name
			 );
		   $this->session->set_userdata('logged_in', $sess_array);		   
		   break;
	     }
	     return TRUE;
	   }
	   else
	   {
	     $this->form_validation->set_message('check_database','Invalid Username or Password or Captcha');
	     return false;
	   }
	 }
	 
	 function logout()
	 {
	   $this->session->sess_destroy();
	   redirect('home', 'refresh');
	 }
}

