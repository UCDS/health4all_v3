<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_panel extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('reports_model');		
		$this->load->model('staff_model');	
		$this->load->model('masters_model');	
		$this->load->model('helpline_model');	
		$this->load->model('register_model');	
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
		$this->load->view('templates/leftnav',$this->data);
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

	function get_print_layout_file_name()
	{
		$response = $this->input->post();
		$print_layout_id = $response['print_layout_id'];	
		$print_layout_file_name = $this->staff_model->get_print_layout($print_layout_id);		
		echo $print_layout_file_name->print_layout_page;			
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

	function print_layouts()
	{
		if($this->session->userdata('logged_in')){
		$this->load->helper('form');
		$this->data['title']="User Panel";
		$this->data['userdata']=$this->session->userdata('logged_in');
		$this->data['print_layouts']=$this->staff_model->get_print_layouts();
		$this->data['districts']=$this->staff_model->get_district();
		//Updating name
		$update_name = $this->input->post('print_layout_new_name');
		$print_layout_id = $this->input->post('print_layout');
		$update = $this->staff_model->update_new_print_layout_name($update_name,$print_layout_id);
		if($update)
		{
			$this->data['print_layouts']=$this->staff_model->get_print_layouts();
		}
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/leftnav',$this->data);
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
				if ($this->input->post('route_primary')) 
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
			
			$search_route_primary_id = $this->input->post('search_route_primary_id');
			foreach($this->data['defaultsConfigs'] as $default){		 
				if($default->default_id=='pagination'){
						$this->data['rowsperpage'] = $default->value;
						$this->data['upper_rowsperpage']= $default->upper_range;
						$this->data['lower_rowsperpage']= $default->lower_range;	 

					}
				}
				if ($this->input->post('route_primary_id') || $this->input->post('route_secondary')) 
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

	function update_des_user_function($record_id='')
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper('form');
			$this->data['title']="Update Description User Function";
			$this->data['userdata']=$this->session->userdata('logged_in');

			$this->load->view('templates/header',$this->data);
			$this->load->view('templates/leftnav',$this->data);
			
			$this->data["user_functions"]=$this->staff_model->get_user_function();
			$this->data['fetch_user_function_display'] = $this->masters_model->get_user_function_display($record_id);
	
			if($this->input->post())
			{
				$update_record_id = $this->input->post('record_id');
					$data_to_update = array(
						'user_function_display' => $this->input->post('user_function_display'),
						'description' => $this->input->post('description'),
					);
				if($this->masters_model->update_des_user_function($update_record_id,$data_to_update))
				{
					$this->data['msg'] = 'Function Display & Description Updated ';
					$this->data["user_functions"]=$this->staff_model->get_user_function();
				}
			}
				$this->load->view('pages/update_description_user_function',$this->data);	
				$this->load->view('templates/footer');	
		}
	}

	function counseling_type($record_id='')
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper('form');
			$this->data['title']="Counseling Type";
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
					$counseling_type = $this->input->post('counseling_type');
					$added_by = $this->input->post('added_by');
					$insert_datetime = $this->input->post('insert_datetime');
					if($this->masters_model->check_couseling_type($counseling_type)) 
					{
					 	$this->data['error'] = 'Counseling type already exists';
					}
					else
					{
					 	$data_to_insert = array(
					 		//'hospital_id' => $hospital['hospital_id'],
					 		'counseling_type' => $counseling_type,
					 		'created_by' => $added_by,
					 		'created_date_time' => $insert_datetime,
					 	);
					 	$this->masters_model->insert_counseling_type($data_to_insert);
					 	$this->data['success'] = 'Counseling type Added Successfully';
					}
				}
				// Fetch all records from primary table
				$this->data['all_counseling_type'] = $this->masters_model->get_all_counseling_type($this->data['rowsperpage']);
				$this->data['all_counseling_type_count'] = $this->masters_model->get_all_counseling_type_count();

				//Fetch record to edit
				$this->data['edit_counseling_type'] = $this->masters_model->get_edit_counseling_type_by_id($record_id);
			    
				$this->load->view('templates/header',$this->data);
				$this->load->view('templates/leftnav',$this->data);
				$this->load->view('pages/counseling_type',$this->data);
				$this->load->view('templates/footer');		
		}
		else
		{
            show_404();
        }
	}

	function update_counseling_type() 
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper('form');
			$this->data['title']="Counseling Type";
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
				$counseling_type = $this->input->post('counseling_type');
				$updated_by = $this->input->post('updated_by');
				$update_datetime = $this->input->post('updated_datetime');
				if($this->masters_model->check_couseling_type($counseling_type)) 
				{
					$this->data['error'] = 'Counselling Type Cannot Be Updated Combination Already Exists';
				}else
				{
					$update_data = array(
						'counseling_type' => $counseling_type,
						'updated_by' => $updated_by,
						'updated_date_time' => $update_datetime,
					);
					$this->masters_model->update_counseling_type($update_record_id, $update_data);
					$this->data['success'] = 'Counseling Type Updated Successfully';
				}
			// Fetch all records from primary table
			$this->data['all_counseling_type'] = $this->masters_model->get_all_counseling_type($this->data['rowsperpage']);
			$this->data['all_counseling_type_count'] = $this->masters_model->get_all_counseling_type_count();

			$this->load->view('templates/header',$this->data);
			$this->load->view('templates/leftnav',$this->data);
			$this->load->view('pages/counseling_type',$this->data);
			$this->load->view('templates/footer');
		}
		else
		{
			show_404();
		}	
    }

	function counseling_text($record_id='')
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper('form');
			$this->data['title']="Counseling Text";
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

					$counseling_type_id = $this->input->post('counseling_type_id');
					$counseling_text = $this->input->post('counseling_text');
					$language_id = $this->input->post('language');
					$active_text = $this->input->post('status');
					$added_by = $this->input->post('added_by');
					$global_text = $this->input->post('global_text');
					$insert_datetime = $this->input->post('insert_datetime');
					// if($this->masters_model->check_counseling_text($hospital['hospital_id'], $counseling_type_id, $counseling_text)) 
					// {
					// 	$this->data['error'] = 'Counseling text exists with counseling type and hospital';
					// }
					if($counseling_type_id=='0')
					{
						$this->data['error'] = 'Please select counseling type';
					}
					else if($language_id=='0')
					{
						$this->data['error'] = 'Please select language';
					}
					else if($active_text=='0')
					{
						$this->data['error'] = 'Please select active status';
					}
					else
					{
						$data_to_insert = array(
							'hospital_id' => $hospital['hospital_id'],
							'counseling_type_id' => $counseling_type_id,
							'counseling_text' => $counseling_text,
							'language_id' => $language_id,
							'active_text' => $active_text,
							'created_by' => $added_by,
					 		'created_date_time' => $insert_datetime,
					 		'global_text' => $global_text,
						);
						$this->masters_model->insert_counseling_text($data_to_insert);
						$this->data['success'] = 'Counseling text Added Successfully';
					}
				}
				//Fetch all counseling type into dropdown
				$this->data['get_all_counseling_type_dd'] = $this->masters_model->get_all_counseling_type();
				
				//Fetch all language
				$this->data['fetch_all_languages']= $this->masters_model->get_all_language_ct();

				//Fetch all records from primary table
				$this->data['all_counseling_text'] = $this->masters_model->get_all_counseling_text($this->data['rowsperpage']);
				$this->data['all_counseling_text_count'] = $this->masters_model->get_all_counseling_text_count();

				//Fetch record to edit
				$this->data['edit_counseling_text'] = $this->masters_model->get_edit_counseling_text_by_id($record_id);

				$this->load->view('templates/header',$this->data);
				$this->load->view('templates/leftnav',$this->data);
				$this->load->view('pages/counseling_text',$this->data);
				$this->load->view('templates/footer');		
		}
		else
		{
            show_404();
        }
	}

	function update_counseling_text()
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper('form');
			$this->data['title']="Counseling Text";
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
				$counseling_type_id = $this->input->post('counseling_type_id');
				$counseling_text = $this->input->post('counseling_text');
				$language_id = $this->input->post('language');
				$active_text = $this->input->post('status');
				$global_text = $this->input->post('global_text');
				$updated_by = $this->input->post('updated_by');
				$update_datetime = $this->input->post('updated_datetime');
				// if($this->masters_model->check_counseling_text($hospital['hospital_id'], $counseling_type_id, $counseling_text)) 
				// {
				// 	$this->data['error'] = 'Counseling Text Cannot Be Updated Combination Already Exists';
				// }
				if($counseling_type_id=='0')
				{
					$this->data['error'] = 'Please select counseling type';
				}
				else if($language_id=='0')
				{
					$this->data['error'] = 'Please select language';
				}
				else if($active_text=='0')
				{
					$this->data['error'] = 'Please select active status';
				}else
				{
					$update_data = array(
						'counseling_type_id' => $counseling_type_id,
						'counseling_text' => $counseling_text,
						'language_id' => $language_id,
						'active_text' => $active_text,
						'updated_by' => $updated_by,
						'updated_date_time' => $update_datetime,
						'global_text' => $global_text,
					);
					$this->masters_model->update_counseling_text_name($update_record_id,$update_data);
					$this->data['success'] = 'Counseling Text Updated Successfully';
				}
			//Fetch all counseling type into dropdown
			$this->data['get_all_counseling_type_dd'] = $this->masters_model->get_all_counseling_type();
			
			//Fetch all language
			$this->data['fetch_all_languages']= $this->masters_model->get_all_language_ct();

			//Fetch all records from primary table
			$this->data['all_counseling_text'] = $this->masters_model->get_all_counseling_text($this->data['rowsperpage']);
			$this->data['all_counseling_text_count'] = $this->masters_model->get_all_counseling_text_count();

			$this->load->view('templates/header',$this->data);
			$this->load->view('templates/leftnav',$this->data);
			$this->load->view('pages/counseling_text',$this->data);
			$this->load->view('templates/footer');
		}
		else
		{
            show_404();
        }
	}

	function delete_custorm_forms($delete_id='')
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper('form');
			$this->data['title']="Delete Custom Form";
			$this->data['userdata']=$this->session->userdata('logged_in');
			$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
			foreach($this->data['defaultsConfigs'] as $default)
			{		 
				if($default->default_id=='pagination')
				{
					$this->data['rowsperpage'] = $default->value;
					$this->data['upper_rowsperpage']= $default->upper_range;
					$this->data['lower_rowsperpage']= $default->lower_range;	 
				}
			}
				$delete_id = $this->input->post('delete_id');
				$this->masters_model->delete_custom_form($delete_id);
				
				$this->data['all_cutom_forms'] = $this->masters_model->get_all_custom_forms($this->data['rowsperpage']);
				$this->data['all_cutom_forms_count'] = $this->masters_model->get_all_custom_forms_count();

				$this->load->view('templates/header',$this->data);
				$this->load->view('templates/leftnav',$this->data);
				$this->load->view('pages/delete_custom_forms',$this->data);
				$this->load->view('templates/footer');		
		}
		else
		{
            show_404();
        }
	}

	//visit type function starting
	function visit_type($record_id='')
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper('form');
			$this->data['title']="Visit Type";
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
					$visit_name = $this->input->post('visit_name');
					$inuse = $this->input->post('inuse');
					$op_ip = $this->input->post('op_ip');
					$added_by = $this->input->post('added_by');
					$insert_datetime = $this->input->post('insert_datetime');
					if($this->masters_model->check_visit_type($visit_name)) 
					{
					 	$this->data['error'] = 'Visit type already exists';
					}
					else
					{
					 	$data_to_insert = array(
					 		'hospital_id' => $hospital['hospital_id'],
					 		'visit_name' => $visit_name,
					 		'inuse' => $inuse,
					 		'op_ip' => $op_ip,
					 		'created_by' => $added_by,
					 		'created_date_time' => $insert_datetime,
					 	);
					 	$this->masters_model->insert_visit_type($data_to_insert);
					 	$this->data['success'] = 'Visit type Added Successfully';
					}
				}
				// Fetch all records from primary table
				$this->data['all_visit_type'] = $this->masters_model->get_all_visit_type($this->data['rowsperpage']);
				$this->data['all_visit_type_count'] = $this->masters_model->get_all_visit_type_count();

				//Fetch record to edit
				$this->data['edit_visit_type'] = $this->masters_model->get_edit_visit_type_by_id($record_id);
			    
				$this->load->view('templates/header',$this->data);
				$this->load->view('templates/leftnav',$this->data);
				$this->load->view('pages/visit_types',$this->data);
				$this->load->view('templates/footer');		
		}
		else
		{
            show_404();
        }
	}

	function update_visit_type() 
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper('form');
			$this->data['title']="Visit Type";
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
				$visit_name = $this->input->post('visit_name');
				$inuse = $this->input->post('inuse');
				$op_ip = $this->input->post('op_ip');
				$updated_by = $this->input->post('updated_by');
				$update_datetime = $this->input->post('updated_datetime');
				if($this->masters_model->check_visit_type_inuse($visit_name,$inuse,$op_ip)) 
				{
					$this->data['error'] = 'Visit Type Cannot Be Updated Combination Already Exists';
				}else
				{
					$update_data = array(
						'visit_name' => $visit_name,
					 	'inuse' => $inuse,
						'op_ip' => $op_ip,
						'updated_by' => $updated_by,
						'updated_date_time' => $update_datetime,
					);
					$this->masters_model->update_visit_type($update_record_id, $update_data);
					$this->data['success'] = 'Visit Type Updated Successfully';
				}
			// Fetch all records from primary table
			$this->data['all_visit_type'] = $this->masters_model->get_all_visit_type($this->data['rowsperpage']);
			$this->data['all_visit_type_count'] = $this->masters_model->get_all_visit_type_count();

			$this->load->view('templates/header',$this->data);
			$this->load->view('templates/leftnav',$this->data);
			$this->load->view('pages/visit_types',$this->data);
			$this->load->view('templates/footer');
		}
		else
		{
			show_404();
		}	
    }

	//priority type function starting
	function priority_type($record_id='')
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper('form');
			$this->data['title']="Priority Type";
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
					$priority_type = $this->input->post('priority_type');
					$color_code = $this->input->post('color_code');
					$added_by = $this->input->post('added_by');
					$insert_datetime = $this->input->post('insert_datetime');
					if($this->masters_model->check_priority_type($priority_type)) 
					{
					 	$this->data['error'] = 'Priority type already exists';
					}
					else
					{
					 	$data_to_insert = array(
					 		'hospital_id' => $hospital['hospital_id'],
					 		'priority_type' => $priority_type,
					 		'color_code' => $color_code,
					 		'created_by' => $added_by,
					 		'created_date_time' => $insert_datetime,
					 	);
					 	$this->masters_model->insert_priority_type($data_to_insert);
					 	$this->data['success'] = 'Priority type Added Successfully';
					}
				}
				// Fetch all records from primary table
				$this->data['all_priority_type'] = $this->masters_model->get_all_priority_type($this->data['rowsperpage']);
				$this->data['all_priority_type_count'] = $this->masters_model->get_all_priority_type_count();

				//Fetch record to edit
				$this->data['edit_priority_type'] = $this->masters_model->get_edit_priority_type_by_id($record_id);
			    
				$this->load->view('templates/header',$this->data);
				$this->load->view('templates/leftnav',$this->data);
				$this->load->view('pages/priority_type',$this->data);
				$this->load->view('templates/footer');		
		}
		else
		{
            show_404();
        }
	}

	function update_priority_type() 
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper('form');
			$this->data['title']="Priority Type";
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
				$priority_type = $this->input->post('priority_type');
				$color_code = $this->input->post('color_code');
				$updated_by = $this->input->post('updated_by');
				$update_datetime = $this->input->post('updated_datetime');
				if($this->masters_model->check_priority_type($priority_type)) 
				{
					$this->data['error'] = 'Priority Type Cannot Be Updated Combination Already Exists';
				}else
				{
					$update_data = array(
						'priority_type' => $priority_type,
						'color_code' => $color_code,
						'updated_by' => $updated_by,
						'updated_date_time' => $update_datetime,
					);
					$this->masters_model->update_priority_type($update_record_id, $update_data);
					$this->data['success'] = 'Priority Type Updated Successfully';
				}
			// Fetch all records from primary table
			$this->data['all_priority_type'] = $this->masters_model->get_all_priority_type($this->data['rowsperpage']);
			$this->data['all_priority_type_count'] = $this->masters_model->get_all_priority_type_count();

			$this->load->view('templates/header',$this->data);
			$this->load->view('templates/leftnav',$this->data);
			$this->load->view('pages/priority_type',$this->data);
			$this->load->view('templates/footer');
		}
		else
		{
			show_404();
		}	
    }

	function delete_priority_type()
	{
		$priority_type = $this->input->post('priority_type_id');
        $deleted = $this->masters_model->delete_priority($priority_type);
        if($deleted) 
        {
            echo json_encode(['status' => 'success', 'message' => 'Priority deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete priority']);
        }
	}
	//priority type ends here
	
	//Custom Report Name Starts here
	function custom_report_name($record_id='')
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper('form');
			$this->data['title']="Custom Report Name";
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
					$report_name = $this->input->post('report_name');
					$added_by = $this->input->post('added_by');
					$insert_datetime = $this->input->post('insert_datetime');

					if($this->masters_model->check_report_name($hospital['hospital_id'], $report_name)) 
					{
					 	$this->data['error'] = 'Report name already exists with this hospital';
					}
					else
					{
						$data_to_insert = array(
							'hospital_id' => $hospital['hospital_id'],
							'report_name' => $report_name,
							'created_by' => $added_by,
					 		'created_date_time' => $insert_datetime,
						);
						$this->masters_model->insert_report_name($data_to_insert);
						$this->data['success'] = 'Report Name Added Successfully';
					}
				}
				//Fetch all records from primary table
				$this->data['all_report_name'] = $this->masters_model->get_all_report_name($this->data['rowsperpage']);
				$this->data['all_report_name_count'] = $this->masters_model->get_all_report_name_count();
				$this->data['report_layout_report_id_count'] = $this->masters_model->report_layout_report_id_count();
				//Fetch record to edit
				$this->data['edit_report_name'] = $this->masters_model->get_edit_report_name_by_id($record_id);

				$this->load->view('templates/header',$this->data);
				$this->load->view('templates/leftnav',$this->data);
				$this->load->view('pages/custom_report_name',$this->data);
				$this->load->view('templates/footer');		
		}
		else
		{
            show_404();
        }
	}

	public function fetch_saved_custom_layout() 
	{
		$report_id = $this->input->post('report_id');
		$data = $this->masters_model->get_saved_custom_layout($report_id);
		echo json_encode($data);
	}

	function update_custom_report_name()
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper('form');
			$this->data['title']="Custom Report Name";
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
				$report_name = $this->input->post('report_name');
				$updated_by = $this->input->post('updated_by');
				$update_datetime = $this->input->post('updated_datetime');
				if($this->masters_model->check_report_name($hospital['hospital_id'], $report_name)) 
				{
					$this->data['error'] = 'Report name already exists with this hospital';
				}else
				{
					$update_data = array(
						'report_name' => $report_name,
						'updated_by' => $updated_by,
						'updated_date_time' => $update_datetime,
					);
					$this->masters_model->update_report_name($update_record_id,$update_data);
					$this->data['success'] = 'Report Name Updated Successfully';
				}
			//Fetch all records from primary table
			$this->data['all_report_name'] = $this->masters_model->get_all_report_name($this->data['rowsperpage']);
			$this->data['all_report_name_count'] = $this->masters_model->get_all_report_name_count();

			$this->load->view('templates/header',$this->data);
			$this->load->view('templates/leftnav',$this->data);
			$this->load->view('pages/custom_report_name',$this->data);
			$this->load->view('templates/footer');
		}
		else
		{
            show_404();
        }
	}
	// Custom report name end here

	// Custom form layout start here

	function custom_report_layout($form_id='')
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper('form');
			$this->data['title']="Custom Report Layout";
			$this->data['userdata']=$this->session->userdata('logged_in');
			$this->data['form_name']=$this->masters_model->get_edit_report_name_by_id($form_id);
			$this->data['print_layouts']=$this->staff_model->get_print_layouts();
			$this->data['districts']=$this->staff_model->get_district();
			$this->data['all_priority_type'] = $this->masters_model->get_all_priority_type();
			$this->data['all_secondary_routes'] = $this->masters_model->get_all_secondary_routes();
			$this->data['volunteer']=$this->register_model->get_volunteer();
			$this->data['codes'] = $this->register_model->search_icd_codes();
			$this->load->view('templates/header',$this->data);
			$this->load->view('templates/leftnav',$this->data);
			
			//$this->load->view('pages/form_layout',$this->data);
			$this->load->view('pages/custom_report_layout',$this->data);
			$this->load->view('templates/footer');	
		}
		else{
			show_404();
		}
	}

	function custom_report_layout_delt()
	{
		$layout_delt_id = $this->input->post('layout_id');
        $deleted = $this->masters_model->delete_custom_layout_id($layout_delt_id);
        if($deleted) 
        {
            echo json_encode(['status' => 'success', 'message' => 'Custom Report deleted successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to delete bed']);
        }
	}

	function save_custom_form(){
		if($this->session->userdata('logged_in')){
				if($this->masters_model->upload_custom_form()){
					echo 1;
				}
				else echo 0;
		}
	}
	// Custom form layout end here

	public function update_custom_field_col_name() 
	{
		$id = $this->input->post('id');
		$report_id = $this->input->post('report_id');
		$column_name = $this->input->post('column_name');
		$concate = $this->input->post('concate');
	
		if (empty($id) || empty($report_id) || empty($column_name) || empty($concate)) {
			echo json_encode(['success' => false, 'message' => 'Invalid input']);
			return;
		}
		$update = $this->masters_model->update_cst_field_column($id, $report_id, $column_name, $concate);
		if ($update) {
			echo json_encode(['success' => true]);
		} else {
			echo json_encode(['success' => false, 'message' => 'Update failed']);
		}
	}
	
}
