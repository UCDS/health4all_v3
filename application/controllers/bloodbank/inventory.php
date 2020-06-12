<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventory extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('bloodbank/inventory_model');
		$this->load->model('masters_model');
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
	
	public function discard(){
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
		$this->data['title']="Inventory";
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/panel_nav',$this->data);
                $this->data['staff']=$this->staff_model->staff_list();//posting staff details to discard[view]
		$this->form_validation->set_rules('inventory_id', 'Inventory ID',
		'required|xss_clean');
		if ($this->form_validation->run() === FALSE)
		{
			$this->data['inventory']=$this->inventory_model->get_inventory();
			$this->load->view('pages/bloodbank/discard',$this->data);
		}
		else{
			if($this->input->post('discard')){
                            if($this->inventory_model->discard_inventory()){
                                    $this->data['msg']="Discarded Successfully. ";
                                    $this->data['inventory']=$this->inventory_model->get_inventory();
                                    $this->load->view('pages/bloodbank/discard',$this->data);
                            }
                            else{
                                    $this->data['inventory']=$this->inventory_model->get_inventory();
                                    $this->data['msg']="Error in storing data. Please retry. ";
                                    $this->load->view('pages/bloodbank/discard',$this->data);
                            }
			}
			else if($this->input->post('search')){
				$this->data['inventory']=$this->inventory_model->get_inventory();
				$this->load->view('pages/bloodbank/discard',$this->data);
			}
		}
		
		$this->load->view('templates/footer');
		
	}
	public function blood_grouping(){
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
		$this->data['title']="Blood Grouping";
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/panel_nav',$this->data);
		$this->data['staff']=$this->staff_model->staff_list();
		$this->form_validation->set_rules('donation_id', 'Donation ID',
		'required|xss_clean');
		if ($this->form_validation->run() === FALSE)
		{
			$this->data['ungrouped_blood']=$this->inventory_model->get_ungrouped_blood();
			$this->load->view('pages/bloodbank/blood_grouping',$this->data);
		}
		else{
			if($this->input->post('filter')){
				$this->data['ungrouped_blood']=$this->inventory_model->get_ungrouped_blood();
				$this->load->view('pages/bloodbank/blood_grouping',$this->data);
			}
			else{
				if($this->inventory_model->group_blood()){
					$this->data['msg']="Updated Successfully. ";
					$this->data['ungrouped_blood']=$this->inventory_model->get_ungrouped_blood();
					$this->load->view('pages/bloodbank/blood_grouping',$this->data);
				}
				else{
					$this->data['msg']="Error in storing data. Please check all fields and try again. ";
					$this->data['ungrouped_blood']=$this->inventory_model->get_ungrouped_blood();
					$this->load->view('pages/bloodbank/blood_grouping',$this->data);
				}
			}
		}
		
		$this->load->view('templates/footer');
	}
	
	public function prepare_components(){
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
		$this->data['title']="Prepare Components";
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/panel_nav',$this->data);
		$this->data['staff']=$this->staff_model->staff_list();
		$this->form_validation->set_rules('donation_id', 'Donation ID',
		'required|xss_clean');
		if ($this->form_validation->run() === FALSE)
		{
			$this->data['inventory']=$this->inventory_model->get_unprepared_blood();
			$this->load->view('pages/bloodbank/component_preparation',$this->data);
		}
		else{
			if($this->input->post('filter')){
				$this->data['inventory']=$this->inventory_model->get_unprepared_blood();
				$this->load->view('pages/bloodbank/component_preparation',$this->data);
			}
                        else if(!$this->input->post('donation_id')){
                            $this->data['inventory']=$this->inventory_model->get_unprepared_blood();
                            $this->load->view('pages/bloodbank/component_preparation',$this->data);
                        }
                        else{
                            if($this->inventory_model->prepare_components()){
                                    $this->data['msg']="Updated Successfully. ";
                                    $this->data['inventory']=$this->inventory_model->get_unprepared_blood();
                                    $this->load->view('pages/bloodbank/component_preparation',$this->data);
                            }
                            else{
                                    $this->data['msg']="Error in storing data. Please retry. ";
                                    $this->data['inventory']=$this->inventory_model->get_unprepared_blood();
                                    $this->load->view('pages/bloodbank/component_preparation',$this->data);
                            }
			}
		}
		
		$this->load->view('templates/footer');
    }
	public function screening(){
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
		$this->data['title']="Blood Screening";		
		$this->data['staff']=$this->staff_model->staff_list();
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/panel_nav',$this->data);
		
		$this->form_validation->set_rules('test[]', 'Blood Sample',
		'xss_clean');
		if ($this->form_validation->run() === FALSE)
		{
			$this->data['inventory']=$this->inventory_model->get_unscreened_blood();
			$this->load->view('pages/bloodbank/blood_screening',$this->data);
		}
		else{
			if($this->input->post('submit')){
			if($this->inventory_model->blood_screening()){
				$this->data['msg']="Updated Successfully. ";
				$this->data['inventory']=$this->inventory_model->get_unscreened_blood();
				$this->load->view('pages/bloodbank/blood_screening',$this->data);
			}
			else{
				$this->data['msg']="Error in storing data. Please retry. ";		
				$this->data['inventory']=$this->inventory_model->get_unscreened_blood();
				$this->load->view('pages/bloodbank/blood_screening',$this->data);
			}
			}
			else{
				$this->data['inventory']=$this->inventory_model->get_unscreened_blood();
				$this->load->view('pages/bloodbank/blood_screening',$this->data);
			}
		}
		
		$this->load->view('templates/footer');
	}
	
	public function issue(){
		if(count(func_get_args())>0){
			$request_id=func_get_arg(0);
		}
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
		$this->data['title']="Blood Issuance";
		$this->data['staff']=$this->staff_model->staff_list();
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/panel_nav',$this->data);
		
		$this->form_validation->set_rules('request_id', 'Request ID',
		'required|xss_clean');
                
		if ($this->form_validation->run() === FALSE)
		{
			$this->data['requests']=$this->inventory_model->get_requests();
			$this->load->view('pages/bloodbank/blood_issue',$this->data);
		}
		else{
				if($this->input->post('select_request')){
					$this->data['request']=$this->inventory_model->get_requests();
					
					$this->data['inventory']=$this->inventory_model->check_inventory();
										$inventory = $this->data['inventory'];
										
										
					$this->data['inv']=$this->data['inventory'][0];
					$this->data['count_inv']=$this->data['inventory'];
					$this->load->view('pages/bloodbank/issue',$this->data);
				}
				else if($this->input->post('issue_request') && $this->input->post('inventory_id')){
					
					if($this->data['donors']=$this->inventory_model->issue()){
					$this->data['msg']="Issued Successfully.";
					$this->load->library('email');
	
					$this->load->view('pages/bloodbank/issued',$this->data);
					}
					else{
					$this->data['msg']="Issue failed. Please retry.";
					$this->load->view('pages/bloodbank/issue',$this->data);
					}	
                                } else{
                                    $this->data['requests']=$this->inventory_model->get_requests();
                                    $this->load->view('pages/bloodbank/blood_issue',$this->data);
                                }
					
		}
		
		$this->load->view('templates/footer');
		
	}

}