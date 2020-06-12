<?php
class Indent_reports extends CI_Controller {
    function __construct() {																		//calling constructor.
        parent::__construct();																		//calling parent constructor.
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
		//calling method get indent summary.
	      function get_indent_summary(){
		  $this->data['userdata']=$this->session->userdata('logged_in');
		 $user_id=$this->data['userdata']['user_id'];
		$this->load->model('staff_model');
		$this->data['functions']=$this->staff_model->user_function($user_id);
		$access = -1;
		//var_dump($item_type_id);
        foreach($this->data['functions'] as $function){
            if($function->user_function=="Consumables"){
                $access = 1;
				break;
            }
		}
		if($access != 1){
			show_404();
		}

 		$this->data['userdata']=$this->session->userdata('indent');
	 	$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('item','required');
		$user=$this->session->userdata('logged_in');
		$this->data['title']="Indent Summary Report";
		$this->load->view('templates/header',$this->data);
        $this->load->view('templates/leftnav',$this->data);
	         $this->load->model('consumables/indent_report_model');
	         $this->data['all_item_type']=$this->indent_report_model->get_data("item_type");
             $this->data['all_item']=$this->indent_report_model->get_data("item");
             $this->data['parties']=$this->indent_report_model->get_data("party");

			$validations=array(
                         array(
                     'field'   => 'item_name',
                     'label'   =>  'Item_name',
                     'rules'   => 'trim|xss_clean'
                  )

			);
		$this->form_validation->set_rules($validations);
    	$this->form_validation->set_message('message','Please input missing details.');
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('pages/consumables/indent_summary_view',$this->data);
        }
			else if($this->input->post('search')){
				$this->data['mode']="search";
				$this->data['search_indent_summary']=$this->indent_report_model->get_indent_summary();

				$this->load->view('pages/consumables/indent_summary_view',$this->data);
			}
			else{
				show_404();
			}
			$this->load->view('templates/footer');
		} //ending of get indent summary method.

		//calling get indent detailed method.
	function get_indent_detailed($from_date=0,$to_date=0,$from_party=0,$to_party=0,$indent_status=0,$item_type=-1,$item_name=-1){
		  $this->data['userdata']=$this->session->userdata('logged_in');
		 $user_id=$this->data['userdata']['user_id'];
		$this->load->model('staff_model');									//instantiating staff_model.
		$this->data['functions']=$this->staff_model->user_function($user_id);
		$access = -1;
		//var_dump($user_id);
        foreach($this->data['functions'] as $function){
            if($function->user_function=="Consumables"){
                $access = 1;
				break;
            }
		}
		if($access != 1){
			show_404();
		}

 		$this->data['userdata']=$this->session->userdata('indent');
	 	$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('item','required');
		$user=$this->session->userdata('logged_in');
		$this->data['title']="Indent Detailed Report";
		$this->load->view('templates/header',$this->data);
        $this->load->view('templates/leftnav',$this->data);

			$this->data['from_date']=$from_date;
			$this->data['to_date']=$to_date;
			$this->data['from_party']=$from_party;
			$this->data['to_party']=$to_party;
			$this->data['indent_status']=$indent_status;
			$this->data['item_type']=$item_type;
			$this->data['item_name']=$item_name;

			$this->load->model('consumables/indent_report_model');
	         $this->data['all_item_type']=$this->indent_report_model->get_data("item_type");
             $this->data['all_item']=$this->indent_report_model->get_data("item");
             $this->data['parties']=$this->indent_report_model->get_data("party");

			$validations=array(
                         array(
                     'field'   => 'item_name',
                     'label'   =>  'Item_name',
                     'rules'   => 'trim|xss_clean'
                  )

			);
		$this->form_validation->set_rules($validations);		//load the fields for validation.
    	$this->form_validation->set_message('message','Please input missing details.');        //if any input is missing then display message 'please input missing details.'
        if ($this->form_validation->run() === FALSE)		//checking for validation is successful or not
        {

			$this->data['search_indent_detailed']=$this->indent_report_model->get_indent_detailed($from_date,$to_date,$from_party,$to_party,$indent_status,$item_type,$item_name);
            $this->load->view('pages/consumables/indent_detailed_view',$this->data);
        }
			else if($this->input->post('search')){
				$this->data['mode']="search";
				$this->data['search_indent_detailed']=$this->indent_report_model->get_indent_detailed($from_date,$to_date,$from_party,$to_party,$indent_status,$item_type,$item_name);

				$this->load->view('pages/consumables/indent_detailed_view',$this->data);
			}
			else{
				show_404();
			}
			$this->load->view('templates/footer');
		}	//ending of get indent detailed method.

		}
