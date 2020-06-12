
<?php
class Hospital extends CI_Controller {
	private $logged_in = false;										//creating controller with name hospital.
    function __construct() {
		parent::__construct();
		if($this->session->userdata('logged_in')){
            $this->logged_in = true;
            $userdata=$this->session->userdata('logged_in');
            $user=$this->session->userdata('logged_in');
            $this->load->model('masters_model');
            $this->load->model('staff_model');
            $this->load->model('reports_model');
						$this->load->model('equipment_model');
						$this->load->model('hospital_model');
            $user_id=$userdata['user_id'];
            $this->data['title']='Report';
            $this->data['hospitals']=$this->staff_model->user_hospital($user_id);
            $this->functions = $this->staff_model->user_function($user_id);
            $this->data['functions']=$this->staff_model->user_function($user_id);
            $this->data['departments']=$this->staff_model->user_department($user_id);
            $this->data['op_forms']=$this->staff_model->get_forms("OP");
            $this->data['ip_forms']=$this->staff_model->get_forms("IP");
            $this->data['user_id']=$user['user_id'];
            $this->load->model('gen_rep_model');
		}
    }   																	
	function add_hospital(){													
		if(!$this->logged_in){  						
            show_404();
		}
		
		$access = false;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="Diagnostics"){
				$access=true;
			}
		}
		if(!$access)
			show_404();
		$this->load->helper('form');										//loading the 'form' helper .
		$this->load->library('form_validation'); 							//loading library 
		$data['title']="Add Hospital";										//storing value into an array with index title.
		$this->load->view('templates/header', $this->data);				//loading header view.
		$this->load->view('templates/leftnav');								//loading leftnav.
		$this->form_validation->set_rules('hospital','hospital','required');//setting rule for required field.
		if($this->form_validation->run()===FALSE) 							//if validation is false
		{
			
		}
		else																//if validation true then executes below block of code
		{
		$this->load->model('hospital_model');								//instantiating hospital_model.
        if($this->hospital_model->add_hospital()){							//calling add_method 
		$this->data['msg']="Hospital added Succesfully";					//if above condition is true then it displays hospital added succesfully message.
		}
		}
		$this->load->view('pages/hospital_view',$this->data);							//displaying hospitla_view page.
		$this->load->view('templates/footer');								//displaying footer page.
    }   																	//add_hospital
	
	function drugs_available() {
		if(!$this->logged_in){  						
      show_404();
		}
		$access = false;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="consumables_drugs"){
				$access=true;
			}
		}
		if(!$access)
			show_404();

		$this->load->helper('form');										
		$this->load->library('form_validation'); 							
		$data['title']="Add Hospital";										
		if($this->input->post('form_submit')){
			$this->form_validation->set_rules('generic_item_id','required');
			if($this->form_validation->run()===FALSE) 							
			{
				$this->data['msg'] = 'Missing fields in input';
			}
			else																
			{
				$insert_id = $this->hospital_model->add_drug();
				if($insert_id)
					$this->data['msg'] = 'Drug Added Successfully';
				else
					$this->data['msg'] = 'Something went wrong try again';
			}
		}		
		$this->data['hospital_drugs'] = $this->hospital_model->get_drugs();
		$this->data['generic_drugs'] = $this->hospital_model->get_masters_drugs();
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/add_remove_drug', $this->data);
		$this->load->view('templates/leftnav');
	}

	function delete_drug() {
		if(!$this->logged_in){  						
			show_404();
		}
		$access = false;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="consumables_drugs"){
				$access=true;
			}
		}
		if(!$access)
			show_404();

		$this->load->helper('form');										
		$this->load->library('form_validation'); 							
		$data['title']="Add Hospital";										
		if($this->input->post('form_submit')){
		$this->form_validation->set_rules('drug_avl_id','required');
			if($this->form_validation->run()===FALSE) 							
			{
				$this->data['msg'] = 'Missing fields in input';
			}
			else																
			{
				$affected_records = $this->hospital_model->delete_drug();
				if($affected_records)
					$this->data['msg'] = 'Drug Removed Successfully';
				else
					$this->data['msg'] = 'Something went wrong try again';
			}
		}
		$this->data['hospital_drugs'] = $this->hospital_model->get_drugs();
		$this->data['generic_drugs'] = $this->hospital_model->get_masters_drugs();
		$this->load->view('templates/header', $this->data);
		$this->load->view('pages/add_remove_drug', $this->data);
		$this->load->view('templates/leftnav');
	}
}