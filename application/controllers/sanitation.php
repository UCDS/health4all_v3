<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sanitation extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('masters_model');
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

//************************************************************************************//  	
// Function to score and update the sanitation activities
//************************************************************************************//
	function evaluate(){
		$access=0;
		foreach($this->data['functions'] as $f){
			if($f->user_function=="Sanitation Evaluation" && ($f->add ==1 || $f->edit ==1)){
				$access=1;
			}
		}
		if($access==0) show_404();		
		$this->load->model('sanitation_model');
		$this->data['title']="Evaluate Sanitation Works";
	 	$this->load->helper('form');
		$this->load->library('form_validation');
		$hospitals=$this->data['hospitals'];
		$this->load->model('staff_model');
		$this->data['area']=$this->staff_model->get_areas();
		$this->form_validation->set_rules('area', 'Area', 'trim|xss_clean');
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/leftnav');
		if($this->form_validation->run()==FALSE){
			$this->load->view('pages/sanitation/evaluation_form',$this->data);			
		}
		else{
			if($this->input->post('select_area')){
				$this->data['sanitation_activity']=$this->masters_model->get_data('sanitation_activity');
				$this->load->view('pages/sanitation/evaluation_form',$this->data);
			}
			else if($this->input->post('submit_evaluation')){
				$result=$this->sanitation_model->upload_evaluation();
				if($result){
					$this->data['msg']="Evaluation saved.";
					$this->load->view('pages/sanitation/evaluation_form',$this->data);
				}
				else{
					$this->data['msg']="Evaluation could not be saved. Please retry.";
					$this->load->view('pages/sanitation/evaluation_form',$this->data);
				}
			}
		}
		$this->load->view('templates/footer');				
	}
	
	function view_scores(){
		$access=0;
		foreach($this->data['functions'] as $f){
			if($f->user_function=="Sanitation Evaluation" && $f->view ==1){
				$access=1;
			}
		}
		if($access==0) show_404();		
		$this->load->model('sanitation_model');
		$this->data['title']="Evaluate Sanitation Works";
	 	$this->load->helper('form');
		$this->load->library('form_validation');		
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/leftnav');
		$this->form_validation->set_rules('hospital', 'Hospital', 'trim|xss_clean');
		if($this->form_validation->run()==FALSE){
			$this->load->view('pages/sanitation/scores_detail',$this->data);			
		}
		else{
				$this->data['scores']=$this->sanitation_model->get_scores_detail();
				$this->load->view('pages/sanitation/scores_detail',$this->data);
		}		
	}
	function view_summary(){
		$access=0;
		foreach($this->data['functions'] as $f){
			if(($f->user_function=="Masters - Sanitation" && $f->view ==1) || ($f->user_function=="Sanitation Summary" && $f->view ==1)){
				$access=1;
			}
		}
		if($access==0) show_404();		
		$this->load->model('sanitation_model');
		$this->data['title']="Evaluate Sanitation Works";
	 	$this->load->helper('form');
		$this->load->library('form_validation');		
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/leftnav');
		$this->form_validation->set_rules('hospital', 'Hospital', 'trim|xss_clean');
		if($this->form_validation->run()==FALSE){
			$this->load->view('pages/sanitation/scores',$this->data);			
		}
		else{
				$this->data['scores']=$this->sanitation_model->get_scores_summary();
				$this->load->view('pages/sanitation/scores',$this->data);
		}		
	}
	
//************************************************************************************//  	
// Function for Add Forms in Sanitation Module commence here   
//************************************************************************************//	
	
	function add($type=""){
		$this->load->helper('form');
		$this->load->library('form_validation');
		$userdata=$this->session->userdata('logged_in');
		$this->data['user_id']=$userdata['user_id'];
	if($type=="area_types"){
		$access=0;
		foreach($this->data['functions'] as $f){
			if($f->user_function=="Masters - Facility" && $f->add ==1){
				$access=1;
			}
		}
		if($access==0) show_404();		
		 	$title="Add Area Type";
		
			$config=array(
               array(
                     'field'   => 'area_type',
                     'label'   => 'area_type',
                     'rules'   => 'required|trim|xss_clean'
                  )
              
			);
}
		else if($type=="area_activity"){
		$access=0;
		foreach($this->data['functions'] as $f){
			if($f->user_function=="Masters - Sanitation" && $f->add ==1){
				$access=1;
			}
		}
		if($access==0) show_404();		
		$title="Add Area Activity";
		$config=array(
        array(
                     'field'   => 'activity_name',
                     'label'   => 'activity_name',
                     'rules'   => 'required|trim|xss_clean'
                  )
			);	
			$this->data['area_types']=$this->masters_model->get_data("area_types");
		}
	else if($type=="department"){
		$access=0;
		foreach($this->data['functions'] as $f){
			if($f->user_function=="Masters - Facility" && $f->add ==1){
				$access=1;
			}
		}
	if($access==0) show_404();		
		$title="Add Department";
		$config=array(
        array(
                     'field'   => 'department_name',
                     'label'   => 'department_name',
                     'rules'   => 'required|trim|xss_clean'
                  )
			);	
			$this->data['hospitals']=$this->masters_model->get_data("hospital");
		}
		else if($type=="districts"){
			$access=0;
			foreach($this->data['functions'] as $f){
				if($f->user_function=="Masters - Application" && $f->add ==1){
					$access=1;
				}
			}
			if($access==0) show_404();
			$title="Add District";
			$config=array(
               array(
                     'field'   => 'district',
                     'label'   => 'district',
                     'rules'   => 'trim|xss_clean'
                  )
			  
			);
			 $this->data['states']=$this->masters_model->get_data("states");
			 $this->data['districts']=$this->masters_model->get_data("districts");
		}
		else if($type=="hospital"){
			$access=0;
			foreach($this->data['functions'] as $f){
				if($f->user_function=="Masters - Facility" && $f->add ==1){
					$access=1;
				}
			}
			if($access==0) show_404();
			$title="Add Hospital";
			$config=array(
               array(
                     'field'   => 'hospital_name',
                     'label'   => 'Hospital Name',
                     'rules'   => 'trim|xss_clean'
                  )
			  
			);
			 $this->data['facility_type']=$this->masters_model->get_data("facility_type");
			 $this->data['village_town']=$this->masters_model->get_data("village_town");
		}
		else if($type=="facility_type"){
			$access=0;
			foreach($this->data['functions'] as $f){
				if($f->user_function=="Masters - Facility" && $f->add ==1){
					$access=1;
				}
			}
			if($access==0) show_404();
			$title="Add Facility Type";
			$config=array(
               array(
                     'field'   => 'facility_types',
                     'label'   => 'facility_types',
                     'rules'   => 'trim|xss_clean'
                  )
			  
			);
			
		}
		else if($type=="facility_activity"){
			$access=0;
			foreach($this->data['functions'] as $f){
				if($f->user_function=="Masters - Sanitation" && $f->add ==1){
					$access=1;
				}
			}
			if($access==0) show_404();
			$title="Add Facility Activity";
			$config=array(
               array(
                     'field'   => 'area_name',
                     'label'   => 'area_name',
                     'rules'   => 'trim|xss_clean'
                  )
			  
			);
			$this->data['area']=$this->staff_model->get_areas();	 			
		 //$this->data['area']=$this->masters_model->get_data("area");
		 $this->data['area_activity']=$this->masters_model->get_data("area_activity");
			 $this->data['hospitals']=$this->masters_model->get_data("hospital");			
		}
		else if($type=="area"){
			$access=0;
			foreach($this->data['functions'] as $f){
				if($f->user_function=="Masters - Facility" && $f->add ==1){
					$access=1;
				}
			}
			if($access==0) show_404();
			$title="Add Area";
			$config=array(
               array(
                     'field'   => 'area_name',
                     'label'   => 'area_name',
                     'rules'   => 'trim|xss_clean'
                  )
			  
			);
			 $this->data['area_types']=$this->masters_model->get_data("area_types");
			 $this->data['hospitals']=$this->masters_model->get_data("hospital");
			$this->data['departments']=$this->masters_model->get_data("department");
			 
		}
		else if($type=="states"){
			$access=0;
			foreach($this->data['functions'] as $f){
				if($f->user_function=="Masters - Application" && $f->add ==1){
					$access=1;
				}
			}
			if($access==0) show_404();
			$title="Add State";
			$config=array(
               array(
                     'field'   => 'state',
                     'label'   => 'state',
                     'rules'   => 'trim|xss_clean'
                  )
			  
			);
			 $this->data['states']=$this->masters_model->get_data("states");
			 
		}
		
		else if($type=="vendor"){
			$access=0;
			foreach($this->data['functions'] as $f){
				if($f->user_function=="Masters - Facility" && $f->add ==1){
					$access=1;
				}
			}
			if($access==0) show_404();
			$title="Add Vendor";
			$config=array(
               array(
                     'field'   => 'vendor_name',
                     'label'   => 'vendor_name',
                     'rules'   => 'trim|xss_clean'
                  )
			  
			);
			 $this->data['vendor']=$this->masters_model->get_data("vendor");
			 
		}
	    else if($type=="vendor_contracts"){
			$access=0;
			foreach($this->data['functions'] as $f){
				if($f->user_function=="Masters - Sanitation" && $f->add ==1){
					$access=1;
				}
			}
			if($access==0) show_404();
			$title="Add Vendor Contract";
			$config=array(
               array(
                     'field'   => 'status',
                     'label'   => 'status',
                     'rules'   => 'trim|xss_clean'
                  )
			  
			);
			 
			 $this->data['vendor_contracts']=$this->masters_model->get_data("vendor_contracts");
			 $this->data['vendor']=$this->masters_model->get_data("vendor");
			 
			 
		}
		 else if($type=="village_town"){
			$access=0;
			foreach($this->data['functions'] as $f){
				if($f->user_function=="Masters - Application" && $f->add ==1){
					$access=1;
				}
			}
			if($access==0) show_404();
			$title="Add Village Town";
			$config=array(
               array(
                     'field'   => 'village_town',
                     'label'   => 'village_town',
                     'rules'   => 'trim|xss_clean'
                  )
			  
			);
			 $this->data['village_town']=$this->masters_model->get_data("village_town");
			 $this->data['districts']=$this->masters_model->get_data("districts");
			
	}
			
		else{
			show_404();
		}
		$page="pages/sanitation/add_".$type."_form";
		$this->data['title']=$title;
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/leftnav');
		$this->form_validation->set_rules($config);
 		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view($page,$this->data);
		}
		else{
				if(($this->input->post('submit'))||($this->masters_model->insert_data($type))){
					$this->data['msg']=" Inserted  Successfully";
					$this->load->view($page,$this->data);
				}
				else{
					$this->data['msg']="Failed";
					$this->load->view($page,$this->data);
				}
		}
		$this->load->view('templates/footer');
  	}	

//************************************************************************************//  	
// Function for Edit Forms in Sanitation Module commence here  	
//************************************************************************************//

function edit($type=""){
	 	$this->load->helper('form');
		$this->load->library('form_validation');
		$userdata=$this->session->userdata('logged_in');
		$this->data['user_id']=$userdata[0]['user_id'];
	if($type=="area_types"){
			$access=0;
			foreach($this->data['functions'] as $f){
				if($f->user_function=="Masters - Facility" && $f->edit ==1){
					$access=1;
				}
			}
			if($access==0) show_404();
			$title="Edit area_types";
			$config=array(
               array(
                     'field'   => 'area_type',
                     'label'   => 'area_type',
                     'rules'   => 'trim|xss_clean'
                  )
               
		
			);
		$this->data['area_types']=$this->masters_model->get_data("area_types");

		}
		else if($type=="area_activity"){
			$access=0;
			foreach($this->data['functions'] as $f){
				if($f->user_function=="Masters - Sanitation" && $f->edit ==1){
					$access=1;
				}
			}
			if($access==0) show_404();
			$title="Edit Area Activity";
			$config=array(
               array(
                     'field'   => 'search_agency_name',
                     'label'   => 'Agency Name',
                     'rules'   => 'trim|xss_clean'
                  ),
				   array(
                     'field'   => 'search_frequency',
                     'label'   => 'Frequency',
                     'rules'   => 'trim|xss_clean'
                  ),
				   array(
                     'field'   => 'search_weightage	',
                     'label'   => 'Weightage',
                     'rules'   => 'trim|xss_clean'
                  ),
				   array(
                     'field'   => 'search_area_type',
                     'label'   => 'Area type',
                     'rules'   => 'trim|xss_clean'
                  ),
				   array(
                     'field'   => 'search_frequency_type',
                     'label'   => 'Frequency Type',
                     'rules'   => 'trim|xss_clean'
                  )
			);
			$this->data['area_activity']=$this->masters_model->get_data("area_activity");
			$this->data['area_types']=$this->masters_model->get_data("area_types");

		}
		else if($type=="department"){
			$access=0;
			foreach($this->data['functions'] as $f){
				if($f->user_function=="Masters - Facility" && $f->edit ==1){
					$access=1;
				}
			}
			if($access==0) show_404();
			$title="Edit Department";
			$config=array(
               array(
                     'field'   => 'department_name',
                     'label'   => 'Department Name',
                     'rules'   => 'trim|xss_clean'
                  )
			);

		}
		else if($type=="districts"){
			$access=0;
			foreach($this->data['functions'] as $f){
				if($f->user_function=="Masters - Application" && $f->edit ==1){
					$access=1;
				}
			}
			if($access==0) show_404();
			$title="Edit Districts";
			$config=array(
               array(
                     'field'   => 'district',
                     'label'   => 'District',
                     'rules'   => 'trim|xss_clean'
                  ),
                array(
                     'field'   => 'longitude',
                     'label'   => 'Longitude',
                     'rules'   => 'trim|xss_clean'
                  ),
				  array(
                     'field'   => 'state',
                     'label'   => 'state',
                     'rules'   => 'trim|xss_clean'
                  ),
				  array(
                     'field'   => 'latitude',
                     'label'   => 'Latitude',
                     'rules'   => 'trim|xss_clean'
                  ),
		
			);
			$this->data['districts']=$this->masters_model->get_data("districts");
			$this->data['states']=$this->masters_model->get_data("states");
		}
		else if($type=="hospital"){
			$access=0;
			foreach($this->data['functions'] as $f){
				if($f->user_function=="Masters - Facility" && $f->edit ==1){
					$access=1;
				}
			}
			if($access==0) show_404();
			$title="Edit Hospital";
			$config=array(
               array(
                     'field'   => 'hospital_name',
                     'label'   => 'Hospital Name',
                     'rules'   => 'trim|xss_clean'
                  ),
                array(
                     'field'   => 'longitude',
                     'label'   => 'Longitude',
                     'rules'   => 'trim|xss_clean'
                  ),
				  array(
                     'field'   => 'address',
                     'label'   => 'address',
                     'rules'   => 'trim|xss_clean'
                  ),
				   array(
                     'field'   => 'village_town',
                     'label'   => 'village_town',
                     'rules'   => 'trim|xss_clean'
                  ),
				  array(
                     'field'   => 'latitude',
                     'label'   => 'Latitude',
                     'rules'   => 'trim|xss_clean'
                  ),
		
			);
			$this->data['facility']=$this->masters_model->get_data("facility");
			$this->data['village_town']=$this->masters_model->get_data("village_town");
		}
		
		else if($type=="facility_activity"){
			$access=0;
			foreach($this->data['functions'] as $f){
				if($f->user_function=="Masters - Sanitation" && $f->edit ==1){
					$access=1;
				}
			}
			if($access==0) show_404();
			$title="Edit Facility Activity";
			$config=array(
               array(
                     'field'   => 'area_name',
                     'label'   => 'Area name',
                     'rules'   => 'required|trim|xss_clean'
                  ),
				  array(
                     'field'   => 'activity_name',
                     'label'   => 'Activity name',
                     'rules'   => 'required|trim|xss_clean'
                  ),
			);	
			$this->data['facility_activity']=$this->masters_model->get_data("facility_activity");
			$this->data['area_activity']=$this->masters_model->get_data("area_activity");	
		}
		else if($type=="area"){
			$access=0;
			foreach($this->data['functions'] as $f){
				if($f->user_function=="Masters - Facility" && $f->edit ==1){
					$access=1;
				}
			}
			if($access==0) show_404();
			$title="Edit Area";
			$config=array(
               array(
                     'field'   => 'area_name',
                     'label'   => 'Area Name',
                     'runles'   => 'trim|xss_clean'
                  )
			);
			$this->data['area']=$this->masters_model->get_data("area");
			$this->data['area_types']=$this->masters_model->get_data("area_types");
		}

		
		else if($type=="facility_type"){
			$access=0;
			foreach($this->data['functions'] as $f){
				if($f->user_function=="Masters - Facility" && $f->edit ==1){
					$access=1;
				}
			}
			if($access==0) show_404();
			$title="Edit Facility Type";
			$config=array(
               array(
                     'field'   => 'facility_type',
                     'label'   => 'facility name',
                     'rules'   => 'trim|xss_clean'
                  ),
				 
			);	
			$this->data['facility_type']=$this->masters_model->get_data("facility_type");
				
		}
		
	else if($type=="states"){
			$access=0;
			foreach($this->data['functions'] as $f){
				if($f->user_function=="Masters - Application" && $f->edit ==1){
					$access=1;
				}
			}
			if($access==0) show_404();
			$title="Edit States";
			$config=array(
               array(
                     'field'   => 'states',
                     'label'   => 'states',
                     'rules'   => 'trim|xss_clean'
                  ),
				 
			);	
			$this->data['states']=$this->masters_model->get_data("states");
				
		}
		else if($type=="vendor"){
			$access=0;
			foreach($this->data['functions'] as $f){
				if($f->user_function=="Masters - Facility" && $f->edit ==1){
					$access=1;
				}
			}
			if($access==0) show_404();
			$title="Edit vendor";
			$config=array(
               array(
                     'field'   => 'vendor',
                     'label'   => 'vendor Name',
                     'rules'   => 'trim|xss_clean'
                  ),
				 
			);	
			$this->data['vendor']=$this->masters_model->get_data("vendor");
				
		}
		else if($type=="vendor_contracts"){
			$access=0;
			foreach($this->data['functions'] as $f){
				if($f->user_function=="Masters - Facility" && $f->edit ==1){
					$access=1;
				}
			}
			if($access==0) show_404();
			$title="Edit Vendor contracts";
			$config=array(
               array(
                     'field'   => 'vendor_contracts',
                     'label'   => 'vendor_name',
                     'label'   => 'facility_name',
                     'rules'   => 'trim|xss_clean'
                  ),
				 
			);	
			$this->data['vendor_contracts']=$this->masters_model->get_data("vendor_contracts");	
		}
		else if($type=="village_town"){
			$access=0;
			foreach($this->data['functions'] as $f){
				if($f->user_function=="Masters - Application" && $f->edit ==1){
					$access=1;
				}
			}
			if($access==0) show_404();
			$title="Edit Village Town";
			$config=array(
               array(
                     'field'   => 'village_town',
                     'label'   => 'village_town',
                     'rules'   => 'trim|xss_clean'
                  ),
			);	
			$this->data['village_town']=$this->masters_model->get_data("village_town");
				
		}
		else{
			show_404();
		}
		
		$page="pages/sanitation/edit_".$type."_form";
		$this->data['title']=$title;
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/left_nav');
		$this->form_validation->set_rules($config);

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view($page,$this->data);
		}
		else{
			if($this->input->post('update')){
				if($this->masters_model->update_data($type)){
					$this->data['msg']="Updated Successfully";
					$this->load->view($page,$this->data);
				}
				else{
					$this->data['msg']="Failed";
					$this->load->view($page,$this->data);
				}
			}
			else if($this->input->post('select')){
				$this->data[$type]=$this->masters_model->get_data($type);
				$this->data['mode']="select";
				$this->load->view($page,$this->data);
			}
			else if($this->input->post('search')){
				$this->data['mode']="search";
				$this->data[$type]=$this->masters_model->get_data($type);
				$this->load->view($page,$this->data);
			}
		}
		$this->load->view('templates/footer');
	}
	
}

