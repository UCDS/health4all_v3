<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class diagnostics extends CI_Controller
{
function __construct(){
parent::__construct();
		$this->load->model('masters_model');
		$this->load->model('staff_model');
		$this->load->model('diagnostics_model');
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

function test_order($departments=0){
	if(!$this->session->userdata('logged_in')){
		show_404();
	}
	$this->load->helper('form');
	$this->load->library('form_validation');
	$user=$this->session->userdata('logged_in');
	$this->data['user_id']=$user['user_id'];	  
	$this->data['title']="Order Test";
	$page="pages/diagnostics/test_order_form";
	$this->load->view('templates/header',$this->data);
	$this->load->view('templates/leftnav');
	$this->form_validation->set_rules('visit_id','Patient','required|trim|xss_clean');
	if($departments==0){
		$this->data['test_areas']=$this->masters_model->get_data('test_area',0,$this->data['departments']);
		$this->data['test_masters']=$this->masters_model->get_data('test_name',0,$this->data['departments']);
		$this->data['test_groups']=$this->masters_model->get_data('test_group',0,$this->data['departments']);
	}
	else{
		$this->data['test_areas']=$this->masters_model->get_data('test_area',0);
		$this->data['test_masters']=$this->masters_model->get_data('test_name',0);
		$this->data['test_groups']=$this->masters_model->get_data('test_group',0);
	}
	$this->data['specimen_types']=$this->masters_model->get_data('specimen_type');
	if ($this->form_validation->run() === FALSE){
		$this->load->view($page,$this->data);
	}
	else{	
		if(($this->input->post('submit'))&&($this->diagnostics_model->order_test())){
		$this->data['msg']="Order has been placed successfully";
		$this->load->view($page,$this->data);
		}
		else{
		$this->data['msg']="Order could not be placed. Please try again.";
		$this->load->view($page,$this->data);
		}
	}
	$this->load->view('templates/footer');
}

function view_orders($access=1){
	if(!$this->session->userdata('logged_in')){
		show_404();
	}
	if($access!="1" && $access != '0') show_404();
	if($access=='0') 
		$this->data['update'] = 0;
	else $this->data['update']=1;
	$this->load->helper('form');
	$this->load->library('form_validation');
	$user=$this->session->userdata('logged_in');
	$this->data['user_id']=$user['user_id'];	  
	$this->data['title']="View Orders";
	$page="pages/diagnostics/test_orders";
	$this->load->view('templates/header',$this->data);
	$this->load->view('templates/leftnav');
	$this->form_validation->set_rules('order_id','Order','trim|xss_clean');
	if($access=='0'){
	$this->data['test_areas']=$this->masters_model->get_data('test_area',0);
	}
	else{
	$this->data['test_areas']=$this->masters_model->get_data('test_area',0,$this->data['departments']);
	}
	$this->data['micro_organisms']=$this->masters_model->get_data('micro_organism');
	$this->data['antibiotics']=$this->masters_model->get_data('antibiotic');
	$this->data['test_methods']=$this->masters_model->get_data("test_method");
	if(count($this->data['test_areas'])>1){
	if ($this->form_validation->run() === FALSE){
		$this->load->view($page,$this->data);
	}
	else{
		if($this->input->post('submit_results')){
			if($this->diagnostics_model->upload_test_results()){
				$this->data['msg']="Test results saved successfully";
			}
			else{
				$this->data['msg']="Test results could not be saved";
			}
			$this->data['orders']=$this->diagnostics_model->get_tests_ordered($this->data['test_areas']);
			$this->load->view($page,$this->data);
		}	
			
		else if($this->input->post('order_id')){
			$this->data['order']=$this->diagnostics_model->get_order();			
			$this->data['all_suggestions']=$this->diagnostics_model->get_test_suggestions();
			$this->load->view($page,$this->data);
		}	
		else{
			$this->data['orders']=$this->diagnostics_model->get_tests_ordered($this->data['test_areas']);
			$this->load->view($page,$this->data);
		}
	}
	}
	else{
		if($this->input->post('submit_results')){
			if($this->diagnostics_model->upload_test_results()){
				$this->data['msg']="Test results saved successfully";
			}
			else{
				$this->data['msg']="Test results could not be saved";
			}
			$this->data['orders']=$this->diagnostics_model->get_tests_ordered($this->data['test_areas']);
			$this->load->view($page,$this->data);
		}	
			
		else if($this->input->post('order_id')){		
			$this->data['order']=$this->diagnostics_model->get_order();
			$this->data['all_suggestions']=$this->diagnostics_model->get_test_suggestions();
			$this->load->view($page,$this->data);
		}	
		else{
			$this->data['orders']=$this->diagnostics_model->get_tests_ordered($this->data['test_areas']);
			$this->load->view($page,$this->data);
		}
	}
		
	$this->load->view('templates/footer');
}

function view_updated_tests(){
	if(!$this->session->userdata('logged_in')){
		show_404();
	}
	$this->load->library('email');
	$this->load->helper('form');
	$this->load->library('form_validation');
	$user=$this->session->userdata('logged_in');
	$this->data['user_id']=$user['user_id'];	  
	$this->data['title']="View Updated Tests";
	$page="pages/diagnostics/view_updated_tests";
	$this->load->view('templates/header',$this->data);
	$this->load->view('templates/leftnav');
	$this->form_validation->set_rules('order_id','Order','trim|xss_clean');
	$this->data['test_areas']=$this->masters_model->get_data('test_area',0,$this->data['departments']);
	$this->data['test_methods']=$this->masters_model->get_data("test_method");
	if(count($this->data['test_areas'])>1){
		if ($this->form_validation->run() === FALSE){
			$this->load->view($page,$this->data);
		}
		else{
			if($this->input->post('select_order')){
				$this->data['order']=$this->diagnostics_model->get_order();
				$this->load->view($page,$this->data);
			}		
			else{
				$this->data['orders']=$this->diagnostics_model->get_tests_completed($this->data['test_areas']);
				$this->load->view($page,$this->data);
			}
		}
	}
	else{
		if($this->input->post('select_order')){
			$this->data['order']=$this->diagnostics_model->get_order();
			$this->load->view($page,$this->data);
		}	
		else{
			$this->data['orders']=$this->diagnostics_model->get_tests_completed($this->data['test_areas']);
			$this->load->view($page,$this->data);
		}
	}
	
	$this->load->view('templates/footer');
    
}

function view_results(){
	if(!$this->session->userdata('logged_in')){
		show_404();
	}
	$this->load->helper('form');
	$this->load->library('form_validation');
	$user=$this->session->userdata('logged_in');
	$this->data['user_id']=$user['user_id'];	  
	$this->data['title']="Test Results";
	$page="pages/diagnostics/test_results";
	$this->load->view('templates/header',$this->data);
	$this->load->view('templates/leftnav');
	$this->form_validation->set_rules('order_id','Order','trim|xss_clean');
	$this->data['test_areas']=$this->masters_model->get_data('test_area',0,$this->data['departments']);
	$this->data['test_methods']=$this->masters_model->get_data("test_method");
	if(count($this->data['test_areas'])>1){
	if ($this->form_validation->run() === FALSE){
		$this->load->view($page,$this->data);
	}
	else{
		if($this->input->post('order_id')){
			$this->data['order']=$this->diagnostics_model->get_order();
			$this->load->view($page,$this->data);
		}	
		else{
			$this->data['orders']=$this->diagnostics_model->get_tests_approved($this->data['test_areas']);
			$this->load->view($page,$this->data);
		}
	}
	}
	else{
		if($this->input->post('order_id')){
			$this->data['order']=$this->diagnostics_model->get_order();
			$this->load->view($page,$this->data);
		}	
		else{
			$this->data['orders']=$this->diagnostics_model->get_tests_approved($this->data['test_areas']);
			$this->load->view($page,$this->data);
		}
	}
		
	$this->load->view('templates/footer');
}

function approve_results(){
	if(!$this->session->userdata('logged_in')){
		show_404();
	}
	$this->load->library('email');
	$this->load->helper('form');
	$this->load->library('form_validation');
	$user=$this->session->userdata('logged_in');
	$this->data['user_id']=$user['user_id'];	  
	$this->data['title']="Approve Results";
	$page="pages/diagnostics/approve_results";
	$this->load->view('templates/header',$this->data);
	$this->load->view('templates/leftnav');
	$this->form_validation->set_rules('order_id','Order','trim|xss_clean');
	$this->data['test_areas']=$this->masters_model->get_data('test_area',0,$this->data['departments']);
	$this->data['test_methods']=$this->masters_model->get_data("test_method");
	if(count($this->data['test_areas'])>1){
		if ($this->form_validation->run() === FALSE){
			$this->load->view($page,$this->data);
		}
		else{
			if($this->input->post('select_order')){
				$this->data['order']=$this->diagnostics_model->get_order();
				$this->load->view($page,$this->data);
			}	
			else if($this->input->post('approve_results')){
				if($result=$this->diagnostics_model->approve_results()){
					if($this->input->post('send_email')==1){
						$this->data['order_mail'] = $this->diagnostics_model->get_order();
						if($result->a_id != NULL && $result->a_id != "") { $email = $result->a_email; $first_name = $result->a_first_name; $phone = $result->a_phone; }
						else if($result->u_id != NULL && $result->u_id != "") { $email = $result->u_email; $first_name = $result->u_first_name; $phone = $result->u_phone; }
						else if($result->d_id != NULL && $result->d_id != "") { $email = $result->d_email; $first_name = $result->d_first_name; $phone = $result->d_phone; }
						else {$email = ""; $first_name = ""; $phone = ""; }
						$this->data['email']=$result->department_email;
						$this->data['name']=$result->department;
						$this->data['phone']=$phone;
						$this->load->view('pages/diagnostics/order_mail',$this->data);
						$this->data['msg']="Results Updated Successfully";
					}
				}
				$this->data['orders']=$this->diagnostics_model->get_tests_completed($this->data['test_areas']);
				$this->load->view($page,$this->data);
			}	
			else{
				$this->data['orders']=$this->diagnostics_model->get_tests_completed($this->data['test_areas']);
				$this->load->view($page,$this->data);
			}
		}
	}
	else{
		if($this->input->post('select_order')){
			$this->data['order']=$this->diagnostics_model->get_order();
			$this->load->view($page,$this->data);
		}	
		else if($this->input->post('approve_results')){
			if($result=$this->diagnostics_model->approve_results()){
				if($this->input->post('send_email')==1){
					$this->data['order_mail'] = $this->diagnostics_model->get_order();
					if($result->a_id != NULL && $result->a_id != "") { $email = $result->a_email; $first_name = $result->a_first_name; $phone = $result->a_phone; }
					else if($result->u_id != NULL && $result->u_id != "") { $email = $result->u_email; $first_name = $result->u_first_name; $phone = $result->u_phone; }
					else if($result->d_id != NULL && $result->d_id != "") { $email = $result->d_email; $first_name = $result->d_first_name; $phone = $result->d_phone; }
					else {$email = ""; $first_name = ""; $phone = ""; }
					$this->data['email']=$result->department_email;
					$this->data['name']=$result->department;
					$this->data['phone']=$phone;
					$this->load->view('pages/diagnostics/order_mail',$this->data);
					$this->data['msg']="Results Updated Successfully";
				}
			}
			$this->data['orders']=$this->diagnostics_model->get_tests_completed($this->data['test_areas']);
			$this->load->view($page,$this->data);
		}
		else{
			$this->data['orders']=$this->diagnostics_model->get_tests_completed($this->data['test_areas']);
			$this->load->view($page,$this->data);
		}
	}
	
	$this->load->view('templates/footer');
}


function edit_order(){
	if(!$this->session->userdata('logged_in')){
		show_404();
	}
	$this->load->helper('form');
	$this->load->library('form_validation');
	$user=$this->session->userdata('logged_in');
	$this->data['user_id']=$user['user_id'];	  
	$this->data['title']="Edit Order";
	$page="pages/diagnostics/edit_order";
	$this->load->view('templates/header',$this->data);
	$this->load->view('templates/leftnav');
	$this->form_validation->set_rules('order_id','Order','trim|xss_clean');
	$this->data['test_areas']=$this->masters_model->get_data('test_area',0,$this->data['departments']);
	$this->data['test_methods']=$this->masters_model->get_data("test_method");
	if(count($this->data['test_areas'])>1){
		if ($this->form_validation->run() === FALSE){
			$this->load->view($page,$this->data);
		}
		else{
			if($this->input->post('select_order')){
				if($this->diagnostics_model->cancel_order())
					$this->data['msg']="Order edited successfully";
				else $this->data['msg']="Order could not be edited";
				$this->data['orders']=$this->diagnostics_model->get_tests($this->data['test_areas']);
				$this->load->view($page,$this->data);
			}	
			else{
				$this->data['orders']=$this->diagnostics_model->get_tests($this->data['test_areas']);
				$this->load->view($page,$this->data);
			}
		}
	}
	else{
		if($this->input->post('select_order')){
			if($this->diagnostics_model->cancel_order())
				$this->data['msg']="Order edited successfully";
			else $this->data['msg']="Order could not be edited";
			$this->data['orders']=$this->diagnostics_model->get_tests($this->data['test_areas']);
			$this->load->view($page,$this->data);
		}	
		else{
			$this->data['orders']=$this->diagnostics_model->get_tests($this->data['test_areas']);
			$this->load->view($page,$this->data);
		}
	}
	
	$this->load->view('templates/footer');
}

function search_patients(){
	if($patients = $this->diagnostics_model->search_patients()){
		$list=array(
			'patients'=>$patients
		);
		
			echo json_encode($list);
	}
	else return false;
}
	
//************************************************************************************//  	
// Function for Add Forms in Diagnostics Module commence here   	
//************************************************************************************//	
function add($type=""){
	if(!$this->session->userdata('logged_in')){
	show_404();
	}
	$this->load->helper('form');
	$this->load->library('form_validation');
	$user=$this->session->userdata('logged_in');
	$this->data['user_id']=$user['user_id'];	
	if($type=="test_method")
	{
		$title="Test Method";
		$config=array(
		array('field' => 'test_method',
		'label' => 'Test Method',
		'rules' => 'required|trim|xss_clean',
		)
		);
	}
	if($type=="test_group"){
			$title="Test Group";
			$config=array(array('field' => 'group_name','label'=>'Group_Name','rules'=>'required|trim|xss_clean' ));
			$this->data['test_methods']=$this->masters_model->get_data("test_method");
			$this->data['test_names']=$this->masters_model->get_data("test_name");

		}
	if($type=="test_status_type"){
			$title="Test Status Type";
			$config=array(array('field' => 'test_status_type','label'=>'Test_Status_Type','rules'=>'required|trim|xss_clean' ));

		}
	if($type=="test_name"){
			$title="Test Name";
			$config=array(
				array(
					'field' => 'test_name',
					'label'=>'Test Name',
					'rules'=>'required|xss_clean' 
				),
				array(
					'field' => 'test_method',
					'label'=>'Test Method',
					'rules'=>'required|xss_clean' 
				),
				array(
					'field' => 'test_area',
					'label'=>'Test Area',
					'rules'=>'required|xss_clean' 
				)
			);
			$this->data['test_methods']=$this->masters_model->get_data("test_method");
			$this->data['test_areas'] = $this->masters_model->get_data("test_area");
			$this->data['lab_units'] = $this->masters_model->get_data("lab_unit");
		}
	if($type=="test_area"){
			$title="Test Area";
			$config=array(array('field' => 'test_area','label'=>'Test Area','rules'=>'required|trim|xss_clean' ));
			$this->data['departments']=$this->staff_model->get_department(-1);
		}
	if($type=="antibiotic"){
			$title="antibiotic";
			$config=array(array('field' => 'antibiotic','label'=>'antibiotic','rules'=>'required|trim|xss_clean' ));

		}
		if($type=="micro_organism"){
			$title="micro_organism";
			$config=array(array('field' => 'micro_organism','label'=>'Micro_Organism','rules'=>'required|trim|xss_clean' ));

		}
	if($type=="specimen_type"){
			$title="Specimen Type";
			$config=array(array('field' => 'specimen_type','label'=>'Specimen_Type','rules'=>'required|trim|xss_clean' ));

		}
	if($type=="sample_status"){
			$title="Sample Status";
			$config=array(array('field' => 'sample_status','label'=>'Sample Status','rules'=>'required|trim|xss_clean' ));

	}
	if($type=="lab_unit"){
			$title="Add Lab Units";
			$config=array(array('field' => 'lab_unit','label'=>'Lab Unit','rules'=>'required|trim|xss_clean' ));

	}
	   $this->data['title']=$title;
	$page="pages/diagnostics/add_".$type."_form";
	$this->load->view('templates/header',$this->data);
	$this->load->view('templates/leftnav');
	$this->form_validation->set_rules($config);
	 
	if ($this->form_validation->run() === FALSE){
	$this->load->view($page,$this->data);
	}
	else{	
	if(($this->input->post('submit'))&&($this->masters_model->insert_data($type))){
	$this->data['msg']=" Inserted Successfully";
	$this->load->view($page,$this->data);
	}
	else{
	$this->data['msg']="Failed";
	$this->load->view($page,$this->data);
	}

	}
	  $this->load->view('templates/footer');
}

function add_assay_name(){
	if(!$this->session->userdata('logged_in')){
		show_404();
	}
	$this->load->helper('form');
	$this->load->library('form_validation');
	$user=$this->session->userdata('logged_in');
	$this->data['user_id']=$user['user_id'];	  
	$this->data['title']="Test Results";
	$page="pages/diagnostics/add_test_assay_form";
	$this->load->view('templates/header',$this->data);
	$this->load->view('templates/leftnav');
	$this->form_validation->set_rules('assay_name','Assay Name','trim|xss_clean');
	if ($this->form_validation->run() === FALSE){
		$this->load->view($page,$this->data);
	}
	else{
		if(($this->masters_model->add_assay())){
			$this->data['msg']="Assay added successfully";
			$this->load->view($page,$this->data);
		}
		else{
			$this->data['msg']="Assay could not be added. Please try again.";
			$this->load->view($page,$this->data);
		}
	}	
}


//************************************************************************************//  	
// Function for Edit Forms in Diagnostics Module commence here   	
//************************************************************************************//
function edit($type="")
{
	$this->load->helper('form');
	$this->load->library('form_validation');
	$user=$this->session->userdata('logged_in');
	$this->data['user_id']=$user['user_id'];	
	if ($type=="test_method")
	{
	$title="Edit Test Method";
	//Defining field,name label and rules for the text field
	$config=array( array(
		   'field' => 'test_method',
		   'label' => 'Test Method',
		   'rules' => 'trim|xss_clean',
			));
			//load model and execute select query in order to populate search results
	$this->data['test_methods']=$this->masters_model->get_data("test_method");
	}
	if ($type=="test_group") {
			$title="Edit Test Group";
			//Defining  field,name label and rules for the text field
			$config=array( array(
		   'field' => 'group_name',
		   'label'   => 'Group Name ',
		   'rules'   => 'trim|xss_clean',
			));
			//load model and execute select query in order to populate search results
			$this->data['test_groups']=$this->masters_model->get_data("test_group");

		}
		
	if ($type=="test_status_type") {
			$title="Edit Test Group";
			//Defining  field,name label and rules for the text field
			$config=array( array(
		   'field' => 'test_status_type',
		   'label'   => 'Test Status Type ',
		   'rules'   => 'trim|xss_clean',
			));
			//load model and execute select query in order to populate search results
			$this->data['test_status_types']=$this->masters_model->get_data("test_status_type");

		}
		
		if ($type=="test_name") {
			$title="Edit Test Name";
			//Defining  field,name label and rules for the text field
			$config=array( array(
		   'field' => 'test_name[]',
		   'label'   => 'Test Name ',
		   'rules'   => 'xss_clean',
			));
			//load model and execute select query in order to populate search results
			$this->data['test_names']=$this->masters_model->get_data("test_name");
			$this->data['test_methods']=$this->masters_model->get_data("test_method");


		}
		if ($type=="test_area") {
			$title="Edit Test Area";
			//Defining  field,name label and rules for the text field
			$config=array( array(
		   'field' => 'test_area',
		   'label'   => 'Test Area ',
		   'rules'   => 'trim|xss_clean',
			));
			//load model and execute select query in order to populate search results
			$this->data['test_areas']=$this->masters_model->get_data("test_area");

		}
		if ($type=="antibiotic") {
			$title="Edit antibiotic";
			//Defining  field,name label and rules for the text field
			$config=array( array(
		   'field' => 'antibiotic',
		   'label'   => 'antibiotic ',
		   'rules'   => 'trim|xss_clean',
			));
			//load model and execute select query in order to populate search results
			$this->data['antibiotics']=$this->masters_model->get_data("antibiotic");

		}
		if ($type=="micro_organism") {
			$title="Edit Micro Organism";
			//Defining  field,name label and rules for the text field
			$config=array( array(
		   'field' => 'micro_organism',
		   'label'   => 'Micro Organism ',
		   'rules'   => 'trim|xss_clean',
			));
			//load model and execute select query in order to populate search results
			$this->data['micro_organisms']=$this->masters_model->get_data("micro_organism");

		}
		if ($type=="specimen_type") {
			$title="Edit Specimen Type";
			//Defining  field,name label and rules for the text field
			$config=array( array(
		   'field' => 'specimen_type',
		   'label'   => 'Specimen Type',
		   'rules'   => 'trim|xss_clean',
			));
			//load model and execute select query in order to populate search results
			$this->data['specimen_types']=$this->masters_model->get_data("specimen_type");

		}
			if ($type=="sample_status") {
			$title="Edit Sample Status";
			//Defining  field,name label and rules for the text field
			$config=array( array(
		   'field' => 'sample_status',
		   'label'   => 'Sample Status',
		   'rules'   => 'trim|xss_clean',
			));
			//load model and execute select query in order to populate search results
			$this->data['sample_statuses']=$this->masters_model->get_data("sample_status");

		}	

	//defining filenname in view and also loading header,left nav bar and footer
	$page="pages/diagnostics/edit_".$type."_form";
	$this->data['title']=$title;
	$this->load->view('templates/header',$this->data);
		$this->load->view('templates/leftnav',$this->data);
	$this->form_validation->set_rules($config);
	if ($this->form_validation->run() === FALSE)
	{
	$this->load->view($page,$this->data);
	}
	else
	{
	if($this->input->post('update')) //when update button is clicked
	{
	if($this->masters_model->update_data($type)){ //if successfull
	$this->data['msg']="Updated Successfully";
	$this->load->view($page,$this->data);
	}
	else //if failed
	{
	$this->data['msg']="Failed";
	$this->load->view($page,$this->data);
	}
	}
	else if($this->input->post('select')) //when some row is selected from the results
	{

	   $this->data['mode']="select";
	   $this->data[$type]=$this->masters_model->get_data($type);
	   $this->load->view($page,$this->data);
	}
	else if($this->input->post('search')) //when user clicks search button
	{
	$this->data['mode']="search";
	$this->data[$type]=$this->masters_model->get_data($type);	
	$this->load->view($page,$this->data);
	}	
	}
	$this->load->view('templates/footer');
	}
	
	
	function edit_assay_name(){
		$this->load->helper('form');
		$this->load->library('form_validation');
		$user=$this->session->userdata('logged_in');
		$this->data['user_id']=$user['user_id'];
		$this->data['title'] ="Edit Assay";
		$this->data['mode'] = "search";
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/leftnav',$this->data);
		$page = "pages/diagnostics/edit_test_assay_form.php";
		
		if($this->input->post('update')) //when update button is clicked
		{
			if($this->masters_model->update_assay()){ //if successfull
				$this->data['msg']="Updated Successfully";
				$this->load->view($page,$this->data);
			}
			else //if failed
			{
				$this->data['msg']="Failed";
				$this->load->view($page,$this->data);
			}
		}	
		if($this->input->post('select')) //when some row is selected from the results
		{
			$this->data['mode']="select";
			$this->data['assays']=$this->masters_model->get_assay();
	   		$this->load->view($page,$this->data);
		}
		else if($this->input->post('search')) //when user clicks search button
		{
			$this->data['mode']="search";
			$this->data['assays']=$this->masters_model->get_assay();	
			$this->load->view($page,$this->data);
		}else{
			$this->load->view($page,$this->data);
		}
		$this->load->view('templates/footer');

	}
    
    function lab_turnaround_time(){
        if(!$this->session->userdata('logged_in')){
            show_404();
	}
        $this->load->helper('form');
        $this->data['user_id']=$user['user_id'];
        $this->data['title'] ="Lab Turn Around Time";
        $this->data['mode'] = "search";
        $this->load->view('templates/header',$this->data);
        $page = "pages/diagnostics/lab_turnaround_time.php";
        $this->data['lab_turnaround_time'] = $this->diagnostics_model->lab_turnaround_time();
        $this->data['all_departments']=$this->staff_model->get_department();
        $this->data['lab_departments']=$this->masters_model->get_data('test_area');
        $this->data['specimen_types']=$this->masters_model->get_data('specimen_type');
        $this->data['test_methods']=$this->masters_model->get_data("test_method");
        $this->data['test_masters']=$this->masters_model->get_data("test_name");
        $this->data['units']=$this->staff_model->get_unit();
        $this->data['areas']=$this->staff_model->get_area();
        $this->load->view($page,$this->data);
        $this->load->view('templates/footer');
    }
}
?>