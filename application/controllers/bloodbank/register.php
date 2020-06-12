<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {
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
	public function index($donor_id=""){
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
		$this->data['userdata']=$this->session->userdata('hospital');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['title']="Register Blood Donation";
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/panel_nav',$this->data);
		$validations=array(
			array(
				'field'=>'name',
				'label'=>'name',
				'rules'=>'required'
			),
			array(
				'field'=>'age',
				'label'=>'Age',
				'rules'=>'required'
			),
			array(
				'field'=>'gender',
				'label'=>'Gender',
				'rules'=>'required'
			),
			array(
				'field'=>'question1',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[3]',
			),
			array(
				'field'=>'question2',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[3]'
			),
			array(
				'field'=>'question3',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[3]'
			),
			array(
				'field'=>'question4',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[2]'
			),
			array(
				'field'=>'question5',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[2]'
			),
			array(
				'field'=>'question6',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[2]'
			),
			array(
				'field'=>'question7',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[2]'
			),
			array(
				'field'=>'question8',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[2]'
			),
			array(
				'field'=>'question9',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[2]'
			),
			array(
				'field'=>'question10',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[2]'
			),
			array(
				'field'=>'question11',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[2]'
			)
		);
		if($this->input->post('gender')=="Female"){
			$female_validations=array(
				array(
				'field'=>'question12',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[2]'
				),
				array(
				'field'=>'question13',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[2]'
				),
				array(
				'field'=>'question14',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[2]'
				),
				array(
				'field'=>'question15',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[2]'
				)
			);
			$this->form_validation->set_rules($female_validations);
		}
		$this->form_validation->set_rules($validations);
		$this->form_validation->set_message('exact_length','Questionaire failed.');
		if ($this->form_validation->run() === FALSE)
		{
			$this->data['camps']=$this->register_model->get_camps();
			/**
			* If donor id is available, query donor details form db
			*/
			$this->load->view('pages/bloodbank/walk_in_registration',$this->data);
		}
		else{
			if($this->register_model->donor_register()){
				$this->data['msg']="Donor registration successful!";
				$this->load->view('pages/bloodbank/walk_in_registration.php',$this->data);
			}
			else{
				$this->data['msg']="Error in storing data. Please retry. ";
				$this->load->view('pages/bloodbank/walk_in_registration.php',$this->data);
			}
		}
		
		$this->load->view('templates/footer');
	}
	public function repeat_donor($donor_id=0)
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
	    $this->data['userdata']=$this->session->userdata('hospital');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['title']="Repeat Blood Donation";
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/panel_nav',$this->data);
		$validations=array(
			array(
				'field'=>'name',
				'label'=>'name',
				'rules'=>'required'
			),
			array(
				'field'=>'age',
				'label'=>'Age',
				'rules'=>'required'
			),
			array(
				'field'=>'gender',
				'label'=>'Gender',
				'rules'=>'required'
			),
			array(
				'field'=>'question1',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[3]',
			),
			array(
				'field'=>'question2',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[3]'
			),
			array(
				'field'=>'question3',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[3]'
			),
			array(
				'field'=>'question4',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[2]'
			),
			array(
				'field'=>'question5',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[2]'
			),
			array(
				'field'=>'question6',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[2]'
			),
			array(
				'field'=>'question7',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[2]'
			),
			array(
				'field'=>'question8',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[2]'
			),
			array(
				'field'=>'question9',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[2]'
			),
			array(
				'field'=>'question10',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[2]'
			),
			array(
				'field'=>'question11',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[2]'
			)
		);
		if($this->input->post('gender')=="Female"){
			$female_validations=array(
				array(
				'field'=>'question12',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[2]'
				),
				array(
				'field'=>'question13',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[2]'
				),
				array(
				'field'=>'question14',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[2]'
				),
				array(
				'field'=>'question15',
				'label'=>'Questionaire',
				'rules'=>'required|exact_length[2]'
				)
			);
			$this->form_validation->set_rules($female_validations);
		}
		$this->form_validation->set_rules($validations);
		$this->form_validation->set_message('exact_length','Questionaire failed.');
		if ($this->form_validation->run() === FALSE && !$this->input->post('search'))
		{
                    if($donor_id !=0 || $donor_id != '0'){
                        $this->data['donor_details'] = $this->register_model->get_donor_details($donor_id);
                        $this->load->view('pages/bloodbank/repeat_donor_form',$this->data);
                    }else{
                        $this->data['camps']=$this->register_model->get_camps();
                        $this->load->view('pages/bloodbank/repeat_donor',$this->data);
                    }
                }else if($this->input->post("repeat_donor")){
                    if($this->register_model->donor_register()){
                        $this->data['msg']="Donor registration successful!";
                        $this->data['camps']=$this->register_model->get_camps();
                        $this->load->view('pages/bloodbank/repeat_donor',$this->data);
                    }
                    else{
                        $this->data['msg']="Error in storing data. Please retry. ";
                        $this->data['donor_details'] = $this->register_model->get_donor_details($donor_id);
                        $this->load->view('pages/bloodbank/repeat_donor_form',$this->data);
                    }
                }
		else if($this->input->post('search')){
                    $this->data['donors']=$this->register_model->get_donors();
                    $this->load->view('pages/bloodbank/repeat_donor',$this->data);
		}else{
                    $this->data['camps']=$this->register_model->get_camps();
                    $this->load->view('pages/bloodbank/repeat_donor',$this->data);
                }
		$this->load->view('templates/footer');
		
	}

        
	public function donation()
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
		$this->data['userdata']=$this->session->userdata('hospital');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['title']="Register Blood Donation";
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/panel_nav',$this->data);
		$donors=$this->register_model->get_registered_donors();
		$appointments=$this->register_model->get_appointments();
		$this->form_validation->set_rules('search', 'Search by',
		'trim|required|xss_clean');
		if ($this->form_validation->run() === FALSE)
		{
			$this->data['donors']=$donors;
			$this->data['appointments']=$appointments;
			$this->load->view('pages/bloodbank/registered_donors',$this->data);
		}
		else if($this->input->post('search')) {
			$this->data['donors']=$donors;
			$this->data['appointments']=$appointments;
			if(count($this->data['appointments'])==0){
				$this->data['msg']="No appointments found for the selected options.";
			}
			$this->load->view('pages/bloodbank/registered_donors',$this->data);
		}
		
		$this->load->view('templates/footer');
		
	}
	
	function appointment_register($donor_id)
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
		$this->data['userdata']=$this->session->userdata('hospital');
		$donation_id=$this->register_model->register_donation($donor_id);
		if($donation_id){
			$this->medical_checkup($donation_id);
		}
		
	}
        
	public function medical_checkup($donor_id=0,$donation_id=""){
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
		$this->data['userdata']=$this->session->userdata('hospital');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['title']="Register Blood Donation";
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/panel_nav',$this->data);
		$this->form_validation->set_rules('weight', 'Weight',
		'trim|required|xss_clean');
		if ($this->form_validation->run() === FALSE){
		if($donor_id!=0 && $donor_id!='0'){
			$donation_id=$this->register_model->register_donation($donor_id);	
		}
		$this->data['donor_details']=$this->register_model->get_registered_donors($donation_id);
		$this->load->view('pages/bloodbank/medical_checkup',$this->data);
		}
		else{
			if($this->register_model->update_medical($donation_id)){
			$this->data['msg']="<font color='green'>Updated Successfully.</font>";
			$this->data['donors']=$this->register_model->get_registered_donors();
			$this->data['appointments']=$this->register_model->get_appointments();
			$this->load->view('pages/bloodbank/registered_donors',$this->data);
			}
			else{
			$this->data['msg']="<font color='red'>Update Failed.</font>";
			$this->load->view('pages/bloodbank/registered_donors',$this->data);
			}
		}
		$this->load->view('templates/footer');
	}
	
	public function bleeding(){
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
		$this->data['userdata']=$this->session->userdata('hospital');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['title']="Bleeding";
		$this->data['staff']=$this->staff_model->staff_list();
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/panel_nav',$this->data);
		$this->form_validation->set_rules('donation_id', 'Donation ID',
		'trim|required|xss_clean');
		$this->form_validation->set_rules('blood_unit_num','Donation ID',
		'trim|required|xss_clean|callback_check_unique');
		if ($this->form_validation->run() === FALSE){
			$this->data['donors']=$this->register_model->get_checked_donors();
			$this->load->view('pages/bloodbank/bleeding',$this->data);
		}
		else{
			$donation_id=$this->input->post('donation_id');
			if($email=$this->register_model->update_bleeding($donation_id)){
				if($email !=2){
					$this->data['msg']="<font color='green'>Updated Successfully.</font>";
					$this->data['donors']=$this->register_model->get_checked_donors();
					$this->data['email']=$email;
					$this->load->view('pages/bloodbank/bleeding',$this->data);
				}
				else if($email==2){
					$this->data['msg']="<font color='red'>Blood unit number already exists in database, please try again.</font>";
					$this->data['donors']=$this->register_model->get_checked_donors();					
					$this->load->view('pages/bloodbank/bleeding',$this->data);
				}
			}
			else{
			$this->data['msg']="<font color='red'>Update Failed.</font>";
			$this->load->view('pages/bloodbank/bleeding',$this->data);
			}
		}
		$this->load->view('templates/footer');
		
	}		
	
	
		
	public function search()
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
		$this->load->helper('form');
		$this->load->library('form_validation');

		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('pages/bloodbank/blood_donation');
		}
		
	}
	
	function check_unique($blood_unit_num){
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
	   $result=$this->register_model->check_unique($blood_unit_num);
		if($result->num_rows()>0){
	     $this->form_validation->set_message('check_unique','Number already exists in database.');
	     return false;
		}
	   else
	   {
		 return true;
	   }	
	}
	
	public function request(){
        if($this->session->userdata('logged_in')){
			$this->data['userdata']=$this->session->userdata('hospital');
			$this->load->helper('form');
			$this->load->library('form_validation');
			$this->data['hospitals']=$this->staff_model->get_hospital();
			$this->data['title']="Request Form";
			$this->load->view('templates/header',$this->data);
			$this->load->view('templates/panel_nav',$this->data);
			$this->form_validation->set_rules('blood_group[]', 'Blood Group',
			'trim|required|xss_clean');
			if ($this->form_validation->run() === FALSE){
				$this->load->view('pages/bloodbank/request');
			}
			else{
				if($this->register_model->make_request()){
					$this->data['msg']='success';
					$this->load->view('pages/bloodbank/request',$this->data);
				}
				else{
					$this->data['msg']='failed';
					$this->load->view('pages/bloodbank/request',$this->data);        
				}
				$this->load->view('templates/footer');
			}
        }
        else 
			show_404();
    }
	
	function search_patients(){
		if($patients = $this->register_model->search_patients()){
			$list=array(
				'patients'=>$patients
			);
        
            echo json_encode($list);
    }
    else return false;
}

    function delete_donor($donor_id=0){
        if(!$this->session->userdata('logged_in')){
            show_404();
        }
       $this->data['userdata']=$this->session->userdata('logged_in');
       foreach ($this->data['functions'] as $f ){
            if($f->user_function=="Bloodbank"){
                $access=1;
            }		
        }
        if($access==0){
            show_404();
        }
		$this->data['userdata']=$this->session->userdata('hospital');
        $this->load->helper('form');
        $this->load->library('form_validation');
        if($donor_id!=0 && $donor_id!='0'){
            $donation_id=$this->register_model->remove_donation($donor_id);
        }
        $this->data['title']="Register Blood Donation";
        $this->load->view('templates/header',$this->data);
        $this->load->view('templates/panel_nav',$this->data);
        $donors=$this->register_model->get_registered_donors();
        $appointments=$this->register_model->get_appointments();
        $this->data['donors']=$donors;
        $this->data['appointments']=$appointments;
        $this->load->view('pages/bloodbank/registered_donors',$this->data);
        $this->load->view('templates/footer');
    }
    
    /* Controller for deleting donor from bleeding*/
    function delete_donor_from_bleeding($donor_id=0){
        if(!$this->session->userdata('logged_in')){
            show_404();
        }
       $this->data['userdata']=$this->session->userdata('logged_in');
       foreach ($this->data['functions'] as $f ){
            if($f->user_function=="Bloodbank"){
                $access=1;
            }		
        }
        if($access==0){
            show_404();
        }
        $this->data['userdata']=$this->session->userdata('hospital');
        $this->load->helper('form');
        $this->load->library('form_validation');
        if($donor_id!=0 && $donor_id!='0'){
            $this->register_model->remove_donation_from_bleeding($donor_id); //calling this method from resiter model.
        }
        else{
            if($this->register_model->remove_donation_from_bleeding($donor_id)){
                $this->data['msg']="<font color='green'>Cancelled successfully.</font>";
            }
            else{
                $this->data['msg']="<font color='green'>Cancellation failed</font>";
            }
        }
        $this->data['title']="Donors waiting:";
        $this->load->view('templates/header',$this->data);
        $this->load->view('templates/panel_nav',$this->data);
        $donors=$this->register_model->get_checked_donors();
        $this->data['donors']=$donors;
        $this->load->view('pages/bloodbank/bleeding',$this->data);
        $this->load->view('templates/footer');
    }
}