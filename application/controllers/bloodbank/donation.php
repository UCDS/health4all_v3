<?php

class Donation extends CI_Controller{
    //put your code here
    function __construct() {
        parent::__construct();        
	if(!$this->session->userdata('logged_in')){
            show_404();
	}
	$this->data['userdata']=$this->session->userdata('logged_in');
        $user_id=$this->data['userdata']['user_id'];
        $this->load->model('bloodbank/donation_model');
	$this->load->model('staff_model');
        $this->load->model('bloodbank/register_model');
        $this->data['hospitals']=$this->staff_model->user_hospital($user_id);
        $this->data['functions']=$this->staff_model->user_function($user_id);
        $this->data['departments']=$this->staff_model->user_department($user_id);
        
	foreach ($this->data['functions'] as $f ){
            if($f->user_function=="Bloodbank"){
		$access=1;
            }		
        }
        if($access==0){
            show_404();            
        }
        $this->data['op_forms']=$this->staff_model->get_forms("OP");
	$this->data['ip_forms']=$this->staff_model->get_forms("IP");	
    }
    
    function index(){
        $this->data['userdata']=$this->session->userdata('hospital');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['title']="Edit Blood Bag Details";
        $this->load->view('templates/header',$this->data);
        $this->load->view('templates/panel_nav',$this->data);
        $this->load->view('pages/bloodbank/edit_blood_bag_details',$this->data);
    }
    
    function get_donation(){
        $this->data['userdata']=$this->session->userdata('hospital');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['title']="Edit Blood Bag Details";
        $this->load->view('templates/header',$this->data);
        $this->load->view('templates/panel_nav',$this->data);
        $validations=array(
            array(
                'field'=>'blood_unit_num',
                'label'=>'blood_unit_num',
                'rules'=>'required'
            )
        );
        $this->form_validation->set_rules($validations);
	$this->form_validation->set_message('message','Please input Blood Unit Number.');
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('pages/bloodbank/edit_blood_bag_details',$this->data);
        }
        else{            
            if($this->donation_model->get_donation()){
                $this->data['donation']=$this->donation_model->get_donation();
                $this->data['camps']=$this->register_model->get_camps();
                $this->data['staff']=$this->staff_model->staff_list();
                $this->load->view('pages/bloodbank/edit_blood_bag_details.php',$this->data);
            }
            else{
                $this->data['message']= "Bag not found.";
                $this->load->view('pages/bloodbank/edit_blood_bag_details.php',$this->data);
            }
        }
    }
    
    function update_blood_bag_info(){
        $this->data['userdata']=$this->session->userdata('hospital');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['title']="Edit Blood Bag Details";
        $this->load->view('templates/header',$this->data);
        $this->load->view('templates/panel_nav',$this->data);
        $validations=array(
            array(
                'field'=>'donation_id',
                'label'=>'donation id',
                'rules'=>'required'
            )
        );
        $this->form_validation->set_rules($validations);
	$this->form_validation->set_message('message','Invalid Submission.');
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('pages/bloodbank/edit_blood_bag_details',$this->data);
        }
        else{            
            if($this->donation_model->update_blood_bag_info()){
                $this->data['message']="Bloodbag details updated.";                
                $this->load->view('pages/bloodbank/edit_blood_bag_details.php',$this->data);
            }
            else{
                $this->data['message']= "Update failed try again later.";
                $this->load->view('pages/bloodbank/edit_blood_bag_details.php',$this->data);
            }
        }
        
    }
    
    function change_group(){
        $this->data['userdata']=$this->session->userdata('hospital');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['title']="Edit Blood Bag Details";
        $this->load->view('templates/header',$this->data);
        $this->load->view('templates/panel_nav',$this->data);
        $validations=array(
            array(
                'field'=>'donation_id',
                'label'=>'donation id',
                'rules'=>'required'
            )
        );
        $this->form_validation->set_rules($validations);
	$this->form_validation->set_message('message','Invalid Submission.');
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('pages/bloodbank/edit_blood_bag_details',$this->data);
        }
        else{            
            if($this->donation_model->update_blood_group_info()){
                $this->data['message']="Blood group updated.";                
                $this->load->view('pages/bloodbank/edit_blood_bag_details.php',$this->data);
            }
            else{
                $this->data['message']= "Update failed try again later.";
                $this->load->view('pages/bloodbank/edit_blood_bag_details.php',$this->data);
            }
        }
    }
    
    function change_screening_result(){
        $this->data['userdata']=$this->session->userdata('hospital');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['title']="Edit Blood Bag Details";
        $this->load->view('templates/header',$this->data);
        $this->load->view('templates/panel_nav',$this->data);
        $validations=array(
            array(
                'field'=>'donation_id',
                'label'=>'donation id',
                'rules'=>'required'
            )
        );
        $this->form_validation->set_rules($validations);
	$this->form_validation->set_message('message','Invalid Submission.');
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('pages/bloodbank/edit_blood_bag_details',$this->data);
        }
        else{            
            if($this->donation_model->update_screening_info()){
                $this->data['message']="Screening result updated.";                
                $this->load->view('pages/bloodbank/edit_blood_bag_details.php',$this->data);
            }
            else{
                $this->data['message']= "Update failed try again later.";
                $this->load->view('pages/bloodbank/edit_blood_bag_details.php',$this->data);
            }
        }
    }
    
    function revert_to_component_preparation(){
        $this->data['userdata']=$this->session->userdata('hospital');
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->data['title']="Edit Blood Bag Details";
        $this->load->view('templates/header',$this->data);
        $this->load->view('templates/panel_nav',$this->data);
        $validations=array(
            array(
                'field'=>'donation_id',
                'label'=>'donation id',
                'rules'=>'required'
            )
        );
        $this->form_validation->set_rules($validations);
	$this->form_validation->set_message('message','Invalid Submission.');
        if ($this->form_validation->run() === FALSE)
        {
            $this->load->view('pages/bloodbank/edit_blood_bag_details',$this->data);
        }
        else{            
            if($this->donation_model->revert_to_component_preparation()){
                $this->data['message']="Reverted to component preparation.";                
                $this->load->view('pages/bloodbank/edit_blood_bag_details.php',$this->data);
            }
            else{
                $this->data['message']= "Update failed try again later.";
                $this->load->view('pages/bloodbank/edit_blood_bag_details.php',$this->data);
            }
        }
    }
    
    function cancel_donation(){
        
    }
}
