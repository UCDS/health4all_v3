<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Appointment extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('bloodbank/slots_model');
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
	function index(){
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('hospital');
		}
		$this->data['slot_dates']=$this->slots_model->get_dates();
		$this->data['title']="Book Appointment";
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/donate_nav');
		$this->load->view('pages/bloodbank/appointment',$this->data);
		$this->load->view('templates/footer');
	}
	function show_slots(){
		$slot_id=$this->input->post('slot_id');
		$this->data['slots']=$this->slots_model->get_slots($slot_id);
		$this->load->view('pages/bloodbank/show_slots',$this->data);
	}
	function register($slot_id){
		$slot_id=trim($slot_id,"slot");
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('hospital');
		}
		$this->data['slot']=$this->slots_model->get_slot($slot_id);
		$this->data['title']="Register Appointment";
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/donate_nav');
		$this->form_validation->set_rules('name', 'Name', 
	    'required|xss_clean|trim');
	    $this->form_validation->set_rules('age', 'Age', 
	    'required|xss_clean|trim');
	    $this->form_validation->set_rules('mobile', 'Mobile No.', 
	    'required|xss_clean|trim');
	    $this->form_validation->set_rules('email', 'Email', 
	    'required|xss_clean|trim');
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
				'field'=>'mobile',
				'label'=>'Phone Number',
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
		$this->load->view('pages/bloodbank/register_appointment',$this->data);
		}
		else{
			if($info=$this->slots_model->register_appointment($slot_id)){
				$this->load->library('email');
				foreach($info as $row){
				$to=$row->email;
				$subject="Acknowledgement - Blood Donation slot booked.";
				$body="
				<div style='width:90%;padding:5px;margin:5px;font-style:\"Trebuchet MS\";border:1px solid #eee;'>
				<p>Dear $row->name,</p>
				<p>This is to acknowledge that you have booked an appointment
				to donate blood at the Indian Red Cross Society Blood Bank on $row->date
				 between $row->from_time and $row->to_time. Thank you for 
				 the blood donation offer.</p>
				<p>Your Appointment ID: <b>$row->appointment_id</b></p>
				<p>
				For any further details, you can reply to this email or 
				call us at 040-27633087.
				</p>
				<p>
				From,<br />
				Blood Bank,<br />
				<br />
				Vidyanagar,<br />
				Indian Red Cross Society - AP State Branch, <br />
				Hyderabad - 500013. <br />
				</p>
				</div>";
				$this->data['msg']="Thank you $row->name. 
				You have booked a slot to donate blood on $row->date 
				between $row->from_time and $row->to_time.
				You will recieve an email with the blood donation slot details.
				 Hope to see you at the BloodBank located at Vidyanagar.";
				}
				$this->email->from('redcross.bloodbankhyd@gmail.com', 'Indian Red Cross Society - Vidyanagar Blood Bank');
				$this->email->to($to);
				$this->email->bcc("contact@yousee.in");
				$this->email->subject($subject);
				$this->email->message($body);

				if ( ! $this->email->send()) {
					show_error($this->email->print_debugger());
				} 
				
				
			}
			else{
				$this->data['msg']="Sorry, There was an error in registration. <a href='".base_url()."appointment'>Please retry</a>.";
			}
			$this->load->view('pages/bloodbank/app_registered',$this->data);
		}
		$this->load->view('templates/footer');
	}		
}
