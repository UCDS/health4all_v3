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
		$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");  
		$this->data['op_forms']=$this->staff_model->get_forms("OP");
		$this->data['ip_forms']=$this->staff_model->get_forms("IP");	
	}

	function form_layout(){
		if($this->session->userdata('logged_in')){
		$this->load->helper('form');
		$this->data['title']="User Panel";
		$this->data['userdata']=$this->session->userdata('logged_in');
		$this->data['print_layouts']=$this->staff_model->get_print_layouts();
		$this->data['districts']=$this->staff_model->get_district();

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

	function form_preview(){
		$response = $this->input->post();
		$print_layout_id = $response['print_layout_id'];	
		 // Load layout data from print_layout table
		$print_layout = $this->staff_model->get_print_layout($print_layout_id);		
		$this->data['preview_only'] = true;
		echo $this->load->view('pages/print_layouts/'.$print_layout->print_layout_page,$this->data);			
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
		$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults"); 
			 	foreach($this->data['defaultsConfigs'] as $default){		 
			 	if($default->default_id=='pagination'){
			 			$this->data['rowsperpage'] = $default->value;
			 			$this->data['upper_rowsperpage']= $default->upper_range;
			 			$this->data['lower_rowsperpage']= $default->lower_range;
			 		}
				}
		$this->data['userdata']=$this->session->userdata('logged_in');
		$this->data['report_count'] = $this->masters_model->get_data("user_count");
		
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/leftnav',$this->data);
		$this->load->library('form_validation');
		$this->form_validation->set_rules('user', 'Username', 'trim|xss_clean');
		if ( $this->input->post('submitBtn')){
			$this->data['user']=$this->masters_model->get_user_details($this->data['rowsperpage']);
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
			//$this->data["user"]=$this->masters_model->get_data("user");
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
			$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults"); 
		 	foreach($this->data['defaultsConfigs'] as $default){		 
		 	if($default->default_id=='pagination'){
		 			$this->data['rowsperpage'] = $default->value;
		 			$this->data['upper_rowsperpage']= $default->upper_range;
		 			$this->data['lower_rowsperpage']= $default->lower_range;
		 		}
			}
			if($this->input->post('submit')){
				$this->data['status'] = $this->staff_model->user_hospital_link();
				$this->data['report_count'] = $this->staff_model->get_user_count();
				$this->data['user'] = $this->staff_model->get_user($this->data['rowsperpage']);
				$this->data['hptls']= false;
			}else if(!$this->input->post('select')){
				$this->data['report_count'] = $this->staff_model->get_user_count();
				$this->data['user'] = $this->staff_model->get_user($this->data['rowsperpage']);
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
	// Newly added on Jan 25 2024
	function user_function_act_list()
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper('form');
			$this->data['title']="User Function Action List";
			$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults"); 
			foreach($this->data['defaultsConfigs'] as $default){		 
			if($default->default_id=='pagination'){
					$this->data['rowsperpage'] = $default->value;
					$this->data['upper_rowsperpage']= $default->upper_range;
					$this->data['lower_rowsperpage']= $default->lower_range;
				}
			}
			$this->load->view('templates/header',$this->data);
			$this->load->view('templates/leftnav',$this->data);
			$this->data['user']=$this->masters_model->get_user_details($this->data['rowsperpage']);
			$this->data["user_functions"]=$this->staff_model->get_user_function();
			$this->data["related_users"]=$this->masters_model->get_functions_related_user($this->data['rowsperpage']);
			$this->data["related_users_count"]=$this->masters_model->get_functions_related_user_count();
			$this->load->view('pages/user_function_act_list',$this->data);
			$this->load->view('templates/footer');	
		}
		else
		{
            show_404();
        }
	}

	function print_layouts(){
		if($this->session->userdata('logged_in')){
		$this->load->helper('form');
		$this->data['title']="User Panel";
		$this->data['userdata']=$this->session->userdata('logged_in');
		$this->data['print_layouts']=$this->staff_model->get_print_layouts();
		$this->data['districts']=$this->staff_model->get_district();
		//Updating name
		$update_name = $this->input->post('print_layout_new_name');
		$print_layout_id = $this->input->post('print_layout_id');
		$update = $this->staff_model->update_new_print_layout_name($update_name,$print_layout_id);
		$this->load->view('templates/header',$this->data);
		$this->load->view('pages/print_layouts',$this->data);
		$this->load->view('templates/footer');	
		}
		else{
			show_404();
		}
	}


	function primary_routes($record_id='')
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper('form');
			$this->data['title']="Routes Primary";
			$this->data['userdata']=$this->session->userdata('logged_in');
			$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
			foreach($this->data['defaultsConfigs'] as $default){		 
				if($default->default_id=='pagination'){
						$this->data['rowsperpage'] = $default->value;
						$this->data['upper_rowsperpage']= $default->upper_range;
						$this->data['lower_rowsperpage']= $default->lower_range;	 

					}
				}
				if ($this->input->post()) 
				{
					$hospital = $this->session->userdata('hospital');
					$route_primary = $this->input->post('route_primary');
					if($this->masters_model->check_route_primary($hospital['hospital_id'], $route_primary)) 
					{
						$this->data['error'] = 'Primary Route already exists';
					}
					else
					{
						$data_to_insert = array(
							'hospital_id' => $hospital['hospital_id'],
							'route_primary' => $route_primary,
						);
						$this->masters_model->insert_route_primary($data_to_insert);
						$this->data['success'] = 'Primary Route Added Successfully';
					}
				}
				// Fetch all records from primary table
				$this->data['all_primary_routes'] = $this->masters_model->get_all_primary_routes($this->data['rowsperpage']);
				$this->data['all_primary_routes_count'] = $this->masters_model->get_all_primary_routes_count();

				//Fetch record to edit
				$this->data['edit_primary_route'] = $this->masters_model->get_edit_primary_route_by_id($record_id);
			
				$this->load->view('templates/header',$this->data);
				$this->load->view('templates/leftnav',$this->data);
				$this->load->view('pages/primary_routes',$this->data);
				$this->load->view('templates/footer');		
		}
		else
		{
            show_404();
        }
	}

    function update_primary_routes() 
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper('form');
			$this->data['title']="Route Primary";
			$this->data['userdata']=$this->session->userdata('logged_in');
			$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
			foreach($this->data['defaultsConfigs'] as $default){		 
				if($default->default_id=='pagination'){
						$this->data['rowsperpage'] = $default->value;
						$this->data['upper_rowsperpage']= $default->upper_range;
						$this->data['lower_rowsperpage']= $default->lower_range;	 

					}
				}
				$hospital = $this->session->userdata('hospital');
				$update_record_id = $this->input->post('record_id');
				$route_primary = $this->input->post('route_primary');
				if($this->masters_model->check_route_primary($hospital['hospital_id'], $route_primary)) 
				{
					$this->data['error'] = 'Primary Route Cannot Be Updated Combination Already Exists';
				}else
				{
					$update_data = array(
						'route_primary' => $route_primary,
					);
					$this->masters_model->update_primary_routes_name($update_record_id, $update_data);
					$this->data['success'] = 'Primary Route Updated Successfully';
				}
			// Fetch all records from primary table
			$this->data['all_primary_routes'] = $this->masters_model->get_all_primary_routes($this->data['rowsperpage']);
			$this->data['all_primary_routes_count'] = $this->masters_model->get_all_primary_routes_count();
			$this->load->view('templates/header',$this->data);
			$this->load->view('templates/leftnav',$this->data);
			$this->load->view('pages/primary_routes',$this->data);
			$this->load->view('templates/footer');
		}
		else
		{
			show_404();
		}	
    }

	function secondary_routes($record_id='')
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper('form');
			$this->data['title']="Route Secondary";
			$this->data['userdata']=$this->session->userdata('logged_in');
			$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
			
			foreach($this->data['defaultsConfigs'] as $default){		 
				if($default->default_id=='pagination'){
						$this->data['rowsperpage'] = $default->value;
						$this->data['upper_rowsperpage']= $default->upper_range;
						$this->data['lower_rowsperpage']= $default->lower_range;	 

					}
				}
				if ($this->input->post()) 
				{
					$hospital = $this->session->userdata('hospital');
					$route_primary = $this->input->post('route_primary_id');
					$route_secondary = $this->input->post('route_secondary');

					if($this->masters_model->check_route_secondary($hospital['hospital_id'], $route_primary, $route_secondary)) 
					{
						$this->data['error'] = 'Secondary route already exists with primary route and hospital';
					}
					else if($route_primary=='0')
					{
						$this->data['error'] = 'Please select primary route';
					}
					else
					{
						$data_to_insert = array(
							'hospital_id' => $hospital['hospital_id'],
							'route_primary_id' => $route_primary,
							'route_secondary' => $route_secondary,
						);
						$this->masters_model->insert_route_secondary($data_to_insert);
						$this->data['success'] = 'Secondary Route Added Successfully';
					}
				}
				//Fetch all primary routes into dropdown
				$this->data['get_all_primary_routes_dd'] = $this->masters_model->get_all_primary_routes();

				//Fetch all records from primary table
				$this->data['all_secondary_routes'] = $this->masters_model->get_all_secondary_routes($this->data['rowsperpage']);
				$this->data['all_secondary_routes_count'] = $this->masters_model->get_all_secondary_routes_count();

				//Fetch record to edit
				$this->data['edit_secondary_route'] = $this->masters_model->get_edit_secondary_route_by_id($record_id);

				$this->load->view('templates/header',$this->data);
				$this->load->view('templates/leftnav',$this->data);
				$this->load->view('pages/secondary_routes',$this->data);
				$this->load->view('templates/footer');		
		}
		else
		{
            show_404();
        }
	}

	function update_secondary_route()
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper('form');
			$this->data['title']="Route Primary";
			$this->data['userdata']=$this->session->userdata('logged_in');
			$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
			foreach($this->data['defaultsConfigs'] as $default){		 
				if($default->default_id=='pagination'){
						$this->data['rowsperpage'] = $default->value;
						$this->data['upper_rowsperpage']= $default->upper_range;
						$this->data['lower_rowsperpage']= $default->lower_range;	 

					}
				}
				$hospital = $this->session->userdata('hospital');
				$update_record_id = $this->input->post('record_id');
				$route_primary = $this->input->post('route_primary_id');
				$route_secondary = $this->input->post('route_secondary');
				if($this->masters_model->check_route_secondary($hospital['hospital_id'], $route_primary, $route_secondary)) 
				{
					$this->data['error'] = 'Secondary Route Cannot Be Updated Combination Already Exists';
				}else
				{
					$update_data = array(
						'route_primary_id' => $route_primary,
						'route_secondary' => $route_secondary,
					);
					$this->masters_model->update_secondary_routes_name($update_record_id,$update_data);
					$this->data['success'] = 'Secondary Route Updated Successfully';
				}
			//Fetch all primary routes into dropdown
			$this->data['get_all_primary_routes_dd'] = $this->masters_model->get_all_primary_routes();

			//Fetch all records from primary table
			$this->data['all_secondary_routes'] = $this->masters_model->get_all_secondary_routes($this->data['rowsperpage']);
			$this->data['all_secondary_routes_count'] = $this->masters_model->get_all_secondary_routes_count();

			$this->load->view('templates/header',$this->data);
			$this->load->view('templates/leftnav',$this->data);
			$this->load->view('pages/secondary_routes',$this->data);
			$this->load->view('templates/footer');
		}
		else
		{
            show_404();
        }
	}
	
}
