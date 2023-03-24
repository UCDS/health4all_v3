<?php
class Indent_reports extends CI_Controller
{
	function __construct()
	{ //calling constructor.
		parent::__construct(); //calling parent constructor.
		$this->load->model('staff_model');
		if ($this->session->userdata('logged_in')) {
			$userdata = $this->session->userdata('logged_in');
			$user_id = $userdata['user_id'];
			$this->data['hospitals'] = $this->staff_model->user_hospital($user_id);
			$this->data['functions'] = $this->staff_model->user_function($user_id);
			$this->data['departments'] = $this->staff_model->user_department($user_id);
		}
		$this->data['op_forms'] = $this->staff_model->get_forms("OP");
		$this->data['ip_forms'] = $this->staff_model->get_forms("IP");
	}
	//calling method get indent summary.
	function get_indent_summary()
	{
		if($this->session->userdata('logged_in')){                                                //checking whether user is in logging state or not;session:state of a user.
            $this->data['userdata']=$this->session->userdata('logged_in');                        //taking session data into data array of index:userdata                   
        }	
        else{
            show_404();                                                                          //if user is not logged in then this error will be thrown.
        }
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$user_id = $this->data['userdata']['user_id'];
		$this->load->model('staff_model');
		$this->data['functions'] = $this->staff_model->user_function($user_id);
		$access = -1;
		//var_dump($item_type_id);
		foreach ($this->data['functions'] as $function) {
			if ($function->user_function == "Consumables") {
				$access = 1;
				break;
			}
		}
		if ($access != 1) {
			show_404();
		}

		$this->data['userdata'] = $this->session->userdata('indent');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('item', 'required');
		$user = $this->session->userdata('logged_in');
		$this->data['title'] = "Indent Summary Report";
		$this->load->view('templates/header', $this->data);
		$this->load->view('templates/leftnav', $this->data);
		$this->load->model('consumables/indent_report_model');
		$this->data['all_item_type'] = $this->indent_report_model->get_data("item_type");
		$this->data['all_item'] = $this->indent_report_model->get_data("item");
		$this->data['parties'] = $this->indent_report_model->get_data("party");

		$validations = array(
			array(
				'field' => 'item_name',
				'label' => 'Item_name',
				'rules' => 'trim|xss_clean'
			), 
			array(
				'field' => 'indent_id', 
				'rules' => 'trim|xss_clean', 
			), 
			array(
				'field' => 'item_type', 
				'rules' => 'trim|xss_clean', 
			), 
			
			array(
				'field' => 'indent_status', 
				'rules' => 'trim|xss_clean', 
			), 

		);
		$this->form_validation->set_rules($validations);
		$this->form_validation->set_message('message', 'Please input missing details.');
		if ($this->form_validation->run() === FALSE) {
			$this->load->view('pages/consumables/indent_summary_view', $this->data);
		} else if ($this->input->post('search')) {
			$this->data['mode'] = "search";
			$this->data['search_indent_summary'] = $this->indent_report_model->get_indent_summary();
			
			$this->load->view('pages/consumables/indent_summary_view', $this->data);
		} else {
			show_404();
		}
		$this->load->view('templates/footer');
	} //ending of get indent summary method.

	// function get_inventory_summary_bf()
	// {
	// 	if($this->session->userdata('logged_in')){                                                //checking whether user is in logging state or not;session:state of a user.
    //         $this->data['userdata']=$this->session->userdata('logged_in');                        //taking session data into data array of index:userdata                   
    //     }	
    //     else{
    //         show_404();                                                                          //if user is not logged in then this error will be thrown.
    //     }
	// 	$this->data['userdata'] = $this->session->userdata('logged_in');
	// 	$user_id = $this->data['userdata']['user_id'];
	// 	$this->load->model('staff_model');
	// 	$this->data['functions'] = $this->staff_model->user_function($user_id);
	// 	$access = -1;
	// 	//var_dump($item_type_id);
	// 	foreach ($this->data['functions'] as $function) {
	// 		if ($function->user_function == "Consumables") {
	// 			$access = 1;
	// 			break;
	// 		}
	// 	}
	// 	if ($access != 1) {
	// 		show_404();
	// 	}

	// 	$this->data['userdata'] = $this->session->userdata('indent');
	// 	$this->load->helper('form');
	// 	$this->load->library('form_validation');
	// 	$this->form_validation->set_rules('item', 'required');
	// 	$user = $this->session->userdata('logged_in');
	// 	$this->data['title'] = "Inventory Summary Report";
	// 	$this->load->view('templates/header', $this->data);
	// 	$this->load->view('templates/leftnav', $this->data);
	// 	$this->load->model('consumables/indent_report_model');
	// 	$this->data['all_item_type'] = $this->indent_report_model->get_data("item_type");
	// 	$this->data['all_item'] = $this->indent_report_model->get_data("item");
	// 	$this->data['parties'] = $this->indent_report_model->get_data("party");

	// 	$validations = array(
	// 		array(
	// 			'field' => 'item',
	// 			'label' => 'Item',
	// 			'rules' => 'trim|xss_clean'
	// 		), 
	// 		array(
	// 			'field' => 'indent_id', 
	// 			'rules' => 'trim|xss_clean', 
	// 		), 
	// 		array(
	// 			'field' => 'item_type', 
	// 			'rules' => 'trim|xss_clean', 
	// 		), 
	// 		// more validations
			

	// 	);
	// 	$this->form_validation->set_rules($validations);
	// 	$this->form_validation->set_message('message', 'Please input missing details.');
	// 	if ($this->form_validation->run() === FALSE) {
	// 		$this->load->view('pages/consumables/inventory_summary_view', $this->data);
	// 	} else if ($this->input->post('search')) {
	// 		$this->data['mode'] = "search";
	// 		$this->data['search_inventory_summary'] = $this->indent_report_model->get_inventory_summary();
	// 		log_message("info", "SAIRAM ".json_encode($this->data['search_inventory_summary']));
	// 		$this->load->view('pages/consumables/inventory_summary_view', $this->data);
	// 	} else {
	// 		show_404();
	// 	}
	// 	$this->load->view('templates/footer');
	// } //ending of get indent summary method.

	function get_inventory_summary()
	{
		if($this->session->userdata('logged_in')){                                                //checking whether user is in logging state or not;session:state of a user.
            $this->data['userdata']=$this->session->userdata('logged_in');                        //taking session data into data array of index:userdata                   
        }	
        else{
            show_404();                                                                          //if user is not logged in then this error will be thrown.
        }
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$user_id = $this->data['userdata']['user_id'];
		$this->load->model('staff_model');
		$this->data['functions'] = $this->staff_model->user_function($user_id);
		$access = -1;
		//var_dump($item_type_id);
		foreach ($this->data['functions'] as $function) {
			if ($function->user_function == "Consumables") {
				$access = 1;
				break;
			}
		}
		if ($access != 1) {
			show_404();
		}

		$this->data['userdata'] = $this->session->userdata('indent');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('item', 'required');
		$user = $this->session->userdata('logged_in');
		$this->data['title'] = "Inventory Summary Report";
		$this->load->view('templates/header', $this->data);
		$this->load->view('templates/leftnav', $this->data);
		$this->load->model('consumables/indent_report_model');
		$this->data['all_item_type'] = $this->indent_report_model->get_data("item_type");
		$this->data['all_item'] = $this->indent_report_model->get_data("item");
		$this->data['parties'] = $this->indent_report_model->get_data("party");

		$validations = array(
			array(
				'field' => 'item',
				'label' => 'Item',
				'rules' => 'trim|xss_clean'
			), 
			array(
				'field' => 'indent_id', 
				'rules' => 'trim|xss_clean', 
			), 
			array(
				'field' => 'item_type', 
				'rules' => 'trim|xss_clean', 
			), 
			// more validations
			

		);
		$this->form_validation->set_rules($validations);
		$this->form_validation->set_message('message', 'Please input missing details.');
		if ($this->form_validation->run() === FALSE) {
			$this->load->view('pages/consumables/inventory_summary_view_new', $this->data);
		} else if ($this->input->post('search')) {
			$this->data['mode'] = "search";
			$this->load->model('consumables/inventory_summary_model');
			$as_on_date = null;
			if($this->input->post('to_date')){
				$as_on_date = date('Y-m-d H:i:s', strtotime($this->input->post('to_date').' +23 hour 59 min'));
			}
			$this->data['search_inventory_summary'] = $this->inventory_summary_model->show_inventory_summary($this->input->post('scp_id'), $as_on_date);
			log_message("info", "SAIRAM ".json_encode($this->data['search_inventory_summary']));
			$this->load->view('pages/consumables/inventory_summary_view_new', $this->data);
		} else {
			show_404();
		}
		$this->load->view('templates/footer');
	} //ending of get indent summary method.

	function run_report_periodic()
	{
		$this->load->model('consumables/inventory_summary_model');
		$this->inventory_summary_model->run_report_periodic();
	}
	function get_item_summary($item_id, $scp_id)
	{
		if($this->session->userdata('logged_in')){                                                //checking whether user is in logging state or not;session:state of a user.
            $this->data['userdata']=$this->session->userdata('logged_in');                        //taking session data into data array of index:userdata                   
        }	
        else{
            show_404();                                                                          //if user is not logged in then this error will be thrown.
        }
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$user_id = $this->data['userdata']['user_id'];
		$this->load->model('staff_model');
		$this->data['functions'] = $this->staff_model->user_function($user_id);
		$access = -1;
		//var_dump($item_type_id);
		foreach ($this->data['functions'] as $function) {
			if ($function->user_function == "Consumables") {
				$access = 1;
				break;
			}
		}
		if ($access != 1) {
			show_404();
		}

		$this->data['userdata'] = $this->session->userdata('indent');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('item', 'required');
		$user = $this->session->userdata('logged_in');
		$this->data['title'] = "Item Summary Report";
		$this->load->view('templates/header', $this->data);
		$this->load->view('templates/leftnav', $this->data);
		$this->load->model('consumables/indent_report_model');
		$this->data['all_item_type'] = $this->indent_report_model->get_data("item_type");
		$this->data['all_item'] = $this->indent_report_model->get_data("item");
		$this->data['parties'] = $this->indent_report_model->get_data("party");
		log_message('info', "SAIRAM FROM GET ITEM $scp_id $item_id");
		$validations = array(
			array(
				'field' => 'item',
				'label' => 'Item',
				'rules' => 'trim|xss_clean'
			), 
			
			array(
				'field' => 'item_type', 
				'rules' => 'trim|xss_clean', 
			), 
			// more validations
			

		);
		$this->form_validation->set_rules($validations);
		// $this->form_validation->set_message('message', 'Please input missing details.');
		if ($this->form_validation->run() === FALSE) {
			if(isset($scp_id) && isset($item_id)){
				$this->data['mode'] = 'search';
				$this->data['search_inventory_summary'] = $this->indent_report_model->get_item_summary($item_id, $scp_id);
				log_message("info", "SAIRAM from URL ".json_encode($this->data['search_inventory_summary']));
				$this->load->view('pages/consumables/item_summary_view', $this->data);
			}else{
				$this->load->view('pages/consumables/item_summary_view', $this->data);
			}
		} else if ($this->input->post('search')) {
			$this->data['mode'] = "search";
			$item_id = $this->input->post('item');
			$scp_id = $this->input->post('scp_id');
			$this->data['search_inventory_summary'] = $this->indent_report_model->get_item_summary($item_id, $scp_id);
			log_message("info", "SAIRAM ".json_encode($this->data['search_inventory_summary']));
			$this->load->view('pages/consumables/item_summary_view', $this->data);
		} else {
			show_404();
		}
		$this->load->view('templates/footer');
	} //ending of get indent summary method.


	//calling get indent detailed method.
	function get_indent_detailed($from_date = 0, $to_date = 0, $from_party = 0, $to_party = 0, $indent_status = 0, $item_type = -1, $item_name = -1)
	{
		if($this->session->userdata('logged_in')){                                                //checking whether user is in logging state or not;session:state of a user.
            $this->data['userdata']=$this->session->userdata('logged_in');                        //taking session data into data array of index:userdata                   
        }	
        else{
            show_404();                                                                          //if user is not logged in then this error will be thrown.
        }
		// log_message('info', 'Sairam: First log message');
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$user_id = $this->data['userdata']['user_id'];
		$this->load->model('staff_model'); //instantiating staff_model.
		$this->data['functions'] = $this->staff_model->user_function($user_id);
		$access = -1;
		//var_dump($user_id);
		foreach ($this->data['functions'] as $function) {
			if ($function->user_function == "Consumables") {
				$access = 1;
				break;
			}
		}
		if ($access != 1) {
			show_404();
		}

		$this->data['userdata'] = $this->session->userdata('indent');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('item', 'required');
		$user = $this->session->userdata('logged_in');
		$this->data['title'] = "Indent Detailed Report";
		$this->load->view('templates/header', $this->data);
		$this->load->view('templates/leftnav', $this->data);

		$this->data['from_date'] = $from_date;
		$this->data['to_date'] = $to_date;
		$this->data['from_party'] = $from_party;
		$this->data['to_party'] = $to_party;
		$this->data['indent_status'] = $indent_status;
		$this->data['item_type'] = $item_type;
		$this->data['item_name'] = $item_name;

		$this->load->model('consumables/indent_report_model');
		$this->data['all_item_type'] = $this->indent_report_model->get_data("item_type");
		$this->data['all_item'] = $this->indent_report_model->get_data("item");
		$this->data['parties'] = $this->indent_report_model->get_data("party");

		$validations = array(
			array(
				'field' => 'item_name',
				'label' => 'Item_name',
				'rules' => 'trim|xss_clean'
			), 
			array(
				'field' => 'indent_id', 
				'rules' => 'trim|xss_clean', 
			), 
			array(
				'field' => 'item_type', 
				'rules' => 'trim|xss_clean', 
			), 
			
			array(
				'field' => 'indent_status', 
				'rules' => 'trim|xss_clean', 
			), 

		);
		$this->form_validation->set_rules($validations); //load the fields for validation.
		$this->form_validation->set_message('message', 'Please input missing details.'); //if any input is missing then display message 'please input missing details.'
		if ($this->form_validation->run() === FALSE) //checking for validation is successful or not
		{

			$this->data['search_indent_detailed'] = $this->indent_report_model->get_indent_detailed($from_date, $to_date, $from_party, $to_party, $indent_status, $item_type, $item_name);
			$this->load->view('pages/consumables/indent_detailed_view', $this->data);
		} else if ($this->input->post('search')) {
			$this->data['mode'] = "search";
			$this->data['search_indent_detailed'] = $this->indent_report_model->get_indent_detailed($from_date, $to_date, $from_party, $to_party, $indent_status, $item_type, $item_name);

			$this->load->view('pages/consumables/indent_detailed_view', $this->data);
		} else {
			show_404();
		}
		$this->load->view('templates/footer');
	} //ending of get indent detailed method.



	function indents_list($from_date = 0, $to_date = 0, $from_party = 0, $to_party = 0, $indent_status = 0)
	{
		if($this->session->userdata('logged_in')){                                                //checking whether user is in logging state or not;session:state of a user.
            $this->data['userdata']=$this->session->userdata('logged_in');                        //taking session data into data array of index:userdata                   
        }	
        else{
            show_404();                                                                          //if user is not logged in then this error will be thrown.
        }
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$user_id = $this->data['userdata']['user_id'];
		$this->load->model('staff_model'); //instantiating staff_model.
		$this->data['functions'] = $this->staff_model->user_function($user_id);
		$access = -1;
		//var_dump($user_id);
		// Checking whether function is applicable for the current staff/user
		foreach ($this->data['functions'] as $function) {
			if ($function->user_function == "Consumables") {
				$access = 1;
				break;
			}
		}
		if ($access != 1) {
			show_404();
		}

		$this->data['userdata'] = $this->session->userdata('indent');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('item', 'required');
		$user = $this->session->userdata('logged_in');
		$this->data['title'] = "Indent List";
		$this->load->view('templates/header', $this->data);
		$this->load->view('templates/leftnav', $this->data);

		$this->data['from_date'] = $from_date;
		$this->data['to_date'] = $to_date;
		$this->data['from_party'] = $from_party;
		$this->data['to_party'] = $to_party;
		$this->data['indent_status'] = $indent_status;
		// $this->data['item_type'] = $item_type;
		// $this->data['item_name'] = $item_name;

		$this->load->model('consumables/indent_report_model');
		// $this->data['all_item_type'] = $this->indent_report_model->get_data("item_type");
		// $this->data['all_item'] = $this->indent_report_model->get_data("item");
		$this->data['parties'] = $this->indent_report_model->get_data("party");

		$validations = array(
			array(
				'field' => 'item_name',
				'label' => 'Item_name',
				'rules' => 'trim|xss_clean'
			), 
			array(
				'field' => 'indent_id', 
				'rules' => 'trim|xss_clean', 
			), 
			array(
				'field' => 'item_type', 
				'rules' => 'trim|xss_clean', 
			), 
			
			array(
				'field' => 'indent_status', 
				'rules' => 'trim|xss_clean', 
			), 

		);
		$this->form_validation->set_rules($validations); //load the fields for validation.
		$this->form_validation->set_message('message', 'Please input missing details.'); //if any input is missing then display message 'please input missing details.'
		if ($this->form_validation->run() === FALSE) //checking for validation is successful or not
		{

			$this->data['search_indent_detailed'] = $this->indent_report_model->list_indents($from_date, $to_date, $from_party, $to_party, $indent_status);
			$this->load->view('pages/consumables/indent_list_view', $this->data);
		} else if ($this->input->post('search')) {
			$this->data['mode'] = "search";
			$this->data['search_indent_detailed'] = $this->indent_report_model->list_indents($from_date, $to_date, $from_party, $to_party, $indent_status);

			$this->load->view('pages/consumables/indent_list_view', $this->data);
		} else {
			show_404();
		}
		$this->load->view('templates/footer');
	}

	function indents_list_detailed($indent_id)
	{
		if($this->session->userdata('logged_in')){                                                //checking whether user is in logging state or not;session:state of a user.
            $this->data['userdata']=$this->session->userdata('logged_in');                        //taking session data into data array of index:userdata                   
        }	
        else{
            show_404();                                                                          //if user is not logged in then this error will be thrown.
        }
        $this->data['userdata']=$this->session->userdata('logged_in');           
        $user_id=$this->data['userdata']['user_id'];                                             //user_id variable is created  and taking user id from user data of data array.
        $this->load->model('staff_model');                                                       //staff_model (model file) is loaded and called from CI_Controller function.
        
        foreach($this->data['functions'] as $function){                                          //for loop that checks for first user_function of functions index is                                                                                                      HR_Recruitment;then make access=1.
            if($function->user_function=="Consumables"){
                $access = 1;
		break;
            }
	 }                                       
        if($access == -1){                                                                       //if there is no user function with HR_Recruitment then error is thrown.
            show_404();
        }                       
		$this->data['userdata']=$this->session->userdata('indent');                               //Store user data into data array of index:userdata
        $this->load->helper('form');                                                              //load form helper
        $this->load->library('form_validation');                                                  //load form_validation from library
        $this->data['title']="Indent $indent_id: Detailed view";                                                      //Store title into data array of title                                                 
        $this->load->view('templates/header',$this->data);                                        //load header(view) file and pass the data array to it
        $this->load->view('templates/leftnav',$this->data);
		                                      //load leftnav(view) file and pass the data array to it
        $this->load->model('consumables/indent_issue_model');                                                 //load indent_issue model file



		$selector_indent_id = 0;
		if(isset($indent_id)){
			$selector_indent_id = $indent_id;
		}
		                                                       
		$this->data['issue_details']= $this->indent_issue_model->get_single_indent_details($selector_indent_id);	  //get data from display_issue_details method of indent_issue model and store it into data array of index:issue_detail			
		$this->data['details'] = $this->data['issue_details'];
		$this->load->view('pages/consumables/individual_indent_view',$this->data);                             //load indent_issue view page and pass data array to it
		$this->load->view('pages/consumables/print_indent_detailed_view', $this->data);
        $this->load->view('templates/footer');
	}
}