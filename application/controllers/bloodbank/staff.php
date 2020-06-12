<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Staff extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('bloodbank/register_model');
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
	function detail($hospital_id){
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
		$this->data['title']="Staff List";
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/donate_nav');
		$this->data['staff']=$this->staff_model->staff_list($hospital_id);
		$this->load->view('pages/bloodbank/staff_list',$this->data);
	}
	function login()
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
		$this->data['title']="Staff Login";
		
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/donate_nav');
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('username', 'Username',
		'trim|required|xss_clean');
	    $this->form_validation->set_rules('password', 'Password', 
	    'trim|required|xss_clean|callback_check_database');
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('pages/bloodbank/login');
		}
		else{
			redirect('user_panel/place', 'refresh');
		}
		
		$this->load->view('templates/footer');
		
	}
	
	function set_place(){
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
		$this->data['title']="Place";

		$this->data['userdata']=$this->session->userdata('hospital');
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/panel_nav');
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('camp', 'Camp',
		'trim|xss_clean');
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('pages/bloodbank/place');
		}
		else{
			$hospital_id=$this->data['userdata']['hospital_id'];
			$this->session->unset_userdata('place');
			$sess_array=array(
				'camp_id'=>$this->input->post('camp'),
				'name'=>$this->input->post('camp_name'),
				'location'=>$this->input->post('location')
			);
			$this->session->set_userdata('place',$sess_array);
			redirect('bloodbank/user_panel/place', 'refresh');
		}
		
		$this->load->view('templates/footer');
	}

	function add_camp() {
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
       $this->data['title']="Add Camp";

		$this->data['userdata']=$this->session->userdata('hospital');
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/panel_nav');
		$this->load->helper('form');
		$this->load->library('form_validation');
		// Adding input fields to variable $config for validation
			$config=array(
               array(
                     'field'   => 'camp',
                     'label'   => 'Camp Name',
                     'rules'   => 'required|trim|xss_clean'
                  ),
				 array(
					'field'   => 'location',
                    'label'   => 'Address',
                    'rules'   => 'required|trim|xss_clean'
				 )
			);
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('pages/bloodbank/add_camp');
		}
		else{
			if($this->input->post('add_camp')){
				if($this->staff_model->add_camp()){
					$this->data['msg']="Camp added successfully";
					$this->load->view('pages/bloodbank/add_camp',$this->data);
				}
			}
		}
		
		$this->load->view('templates/footer');
		
	}// add_camp
/*
	function add_hospital() {
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
	     $this->data['title']="Add Hospital";

		$this->data['userdata']=$this->session->userdata('hospital');
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/panel_nav');
		$this->load->helper('form');
		$this->load->library('form_validation');
		// Adding input fields to variable $config for validation
			$config=array(
               array(
                     'field'   => 'hospital',
                     'label'   => 'Hospital Name',
                     'rules'   => 'required|trim|xss_clean'
                  ),
				 array(
					'field'   => 'location',
                    'label'   => 'Place',
                    'rules'   => 'required|trim|xss_clean'
				 ),
				 array(
					'field'   => 'district',
                    'label'   => 'District',
                    'rules'   => 'required|trim|xss_clean'
				 ),
				 array(
					'field'   => 'state',
                    'label'   => 'State',
                    'rules'   => 'required|trim|xss_clean'
				 )
			);
		$this->form_validation->set_rules($config);
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('pages/bloodbank/add_hospital');
		}
		else{
			if($this->input->post('add_hospital')){
				if($this->staff_model->add_hospital()){
					$this->data['msg']="Hospital added successfully";
					$this->load->view('pages/bloodbank/add_hospital',$this->data);
				}
			}
		}
		
		$this->load->view('templates/footer');
		
	}
*/
	function check_database($password){
	   //Field validation succeeded.  Validate against database
	   
	   $username = $this->input->post('username');
	 
	   //query the database
	   $result = $this->staff_model->login($username, $password);
	 
	   if($result)
	   {
	     $sess_array = array();
	     foreach($result as $row)
	     {
	       $sess_array = array(
	         'user_id' => $row->user_id,
	         'username' => $row->username,
			 'hospital_id'=>$row->hospital_id,
			 'hospital_name'=>$row->hospital.", ".$row->place
	       );
	       $this->session->set_userdata('logged_in', $sess_array);
			$this->session->set_userdata('place',array('camp_id'=>0,'name'=>$row->hospital.", ".$row->place));
	     }
	     return TRUE;
	   }
	   else
	   {
	     $this->form_validation->set_message('check_database', 
	     'Invalid username or password');
	     return false;
	   }
	 }
	 
	 function logout()
	 {
	   $this->session->unset_userdata('logged_in');
	   $this->session->unset_userdata('place');
	   $this->session->sess_destroy();
	   redirect('home', 'refresh');
	 }
}
