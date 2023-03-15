
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
		$this->data['title']="Add Hospital";								//storing value into an array with index title.
		
		$isUpdate = false;
		if($this->input->get('hospital_id')){
			$isUpdate = true;
			$this->data['title']="Edit Hospital";	
			$this->data['filter_values']=$this->hospital_model->get_hospital($this->input->get('hospital_id'));
			if(!$this->data['filter_values']){
				$this->data['filter_values'] = [];
				$this->data['msg']="Hospital id is invalid";
			
		}
		}
		$this->load->view('templates/header', $this->data);				    //loading header view.
		$this->load->view('templates/leftnav');								//loading leftnav.
		$this->form_validation->set_rules('hospital','hospital','required');//setting rule for required field.
		
		

		
		if($this->form_validation->run()===FALSE) 							//if validation is false
		{
			
		}
		else																//if validation true then executes below block of code
		{
		$this->load->model('hospital_model');								//instantiating hospital_model.
        if($this->hospital_model->upsert_hospital()){							//calling add_method 
		$this->data['msg']="Hospital added/updated Succesfully";					//if above condition is true then it displays hospital added succesfully message.
		}
		}
		$this->data['print_layouts']=$this->staff_model->get_print_layouts();
		$this->data['districts']=$this->staff_model->get_district();
		$this->load->model('hospital_model');	 							//instantiating hospital_model.
		$this->data['helplines']=$this->hospital_model->get_helpline();
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

	public function search_hospital()
	{
			if($this->session->userdata('logged_in')){
				$this->data['userdata']=$this->session->userdata('logged_in');
				$access=0;
				foreach($this->data['functions'] as $function){
					 if($function->user_function=="OP Detail"){
					 $access=1;
					 }
				}
				if($access==1){
						
						$this->data['title']="Search Hospital";
						$this->data['districts']=$this->staff_model->get_district();
						$this->load->view('templates/header',$this->data);
						$this->load->helper('form');
						$this->load->library('form_validation');
						// $this->form_validation->set_rules('hospital', 'Hospital', 'trim|required|xss_clean');
						// print_r ($_POST);die;
						$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
						foreach($this->data['defaultsConfigs'] as $default){		 
							if($default->default_id=='pagination'){
									$this->data['rowsperpage'] = $default->value;
									$this->data['upper_rowsperpage']= $default->upper_range;
									$this->data['lower_rowsperpage']= $default->lower_range;	 
			   
								}
						   }
						//if($this->input->post('search_hospital')){							
							//if ($this->form_validation->run() === TRUE) {
								$this->data['results_count']=$this->hospital_model->get_count_hospital();								
								$this->data['results']=$this->hospital_model->search_hospitals($this->data['rowsperpage']);
								if(count($this->data['results']) == 0){
									$this->data['msg'] = "No Records found";
								}
							// }else{
							// 	$this->data['msg'] = "Hospital Name is Required";
						//	}

						//}
						
						$filter_names=['hospital','hospital_short_name','district','type1','type2','type3','type4','type5','type6'];
						$filter_values = [];
						foreach($filter_names as $filter_name){
							$filter_value = "";
							if($this->input->post($filter_name)){
								$filter_value = $this->input->post($filter_name);
							}
							$filter_values[$filter_name] = $filter_value;
						}
						$this->data['filter_values'] = $filter_values;

						$this->load->view('pages/search_hospital_view',$this->data);
						$this->load->view('templates/footer');
				} else{
				show_404();
				}
			} else{
			show_404();
			}
 }

}