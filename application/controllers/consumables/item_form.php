<?php
class Item_form extends CI_Controller {										
    function __construct() {
		   parent::__construct();	
		$this->load->model('staff_model');
		$this->load->model('masters_model');
		if($this->session->userdata('logged_in')){
		$userdata=$this->session->userdata('logged_in');
		$user_id=$userdata['user_id'];
		$this->data['hospitals']=$this->staff_model->user_hospital($user_id);
		$this->data['functions']=$this->staff_model->user_function($user_id);
		$this->data['departments']=$this->staff_model->user_department($user_id);
		}
		$this->data['op_forms']=$this->staff_model->get_forms("OP");
		$this->data['ip_forms']=$this->staff_model->get_forms("IP");
    }   			//end of constructor.

	function item_forms_list($record_id='')
	{
		if($this->session->userdata('logged_in')){  						
            $this->data['userdata']=$this->session->userdata('logged_in');  
			$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
			foreach($this->data['defaultsConfigs'] as $default){		 
				if($default->default_id=='pagination'){
						$this->data['rowsperpage'] = $default->value;
						$this->data['upper_rowsperpage']= $default->upper_range;
						$this->data['lower_rowsperpage']= $default->lower_range;	 
   
					}
			   }
		}	
        else{
            show_404(); 													
        } 
			$access = -1;
		foreach($this->data['functions'] as $function){
            if($function->user_function=="Masters - Consumables"){
                $access = 1;
				break;
            }
		}
		if($access != 1){
			show_404();
		}
			$this->load->helper('form');										
			$this->load->library('form_validation'); 							
			$this->data['title']="Item Form";										
			$this->load->view('templates/header', $this->data);				
			$this->load->view('templates/leftnav');	
			
		$this->load->model('consumables/item_form_model');
		if($this->input->post()) 
		{
			$item_form = $this->input->post('item_form_id');
			$added_by = $this->input->post('added_by');
			$insert_datetime = $this->input->post('insert_datetime');
			if($this->item_form_model->check_item_form($item_form)) 
			{
				$this->data['error'] = 'Item Form already exists';
			}
			else
			{
				$data_to_insert = array(
					'item_form' => $item_form,
					'created_by' => $added_by,
					'created_date_time' => $insert_datetime,
				);
				$this->item_form_model->add_item_form($data_to_insert);
				$this->data['success'] = 'Item Form Added Successfully';
			}
		}
			// Fetch all records from primary table
			$this->data['all_item_form'] = $this->item_form_model->get_all_item_form($this->data['rowsperpage']);
			$this->data['all_item_form_count'] = $this->item_form_model->get_all_item_form_count();

			//Fetch record to edit
			$this->data['edit_item_form'] = $this->item_form_model->get_edit_item_form_id($record_id);	

			$this->load->view('pages/consumables/item_forms_list',$this->data);							
			$this->load->view('templates/footer');	
	}
 	
	function update_item_form()
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper('form');
			$this->load->model('consumables/item_form_model');
			$this->data['title']="Item Form";
			$this->data['userdata']=$this->session->userdata('logged_in');
			$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
			foreach($this->data['defaultsConfigs'] as $default){		 
				if($default->default_id=='pagination'){
						$this->data['rowsperpage'] = $default->value;
						$this->data['upper_rowsperpage']= $default->upper_range;
						$this->data['lower_rowsperpage']= $default->lower_range;	 

					}
				}
				$update_record_id = $this->input->post('record_id');
				$item_form = $this->input->post('item_form_id');
				$updated_by = $this->input->post('updated_by');
				$update_datetime = $this->input->post('updated_datetime');
				if($this->item_form_model->check_item_form($item_form)) 
				{
					$this->data['error'] = 'Item Form Cannot Be Updated Combination Already Exists';
				}else
				{
					$update_data = array(
						'item_form' => $item_form,
						'updated_by' => $updated_by,
						'updated_date_time' => $update_datetime,
					);
					$this->item_form_model->update_item_form($update_record_id, $update_data);
					$this->data['success'] = 'Item Form Updated Successfully';
				}
			// Fetch all records from primary table
			$this->data['all_item_form'] = $this->item_form_model->get_all_item_form($this->data['rowsperpage']);
			$this->data['all_item_form_count'] = $this->item_form_model->get_all_item_form_count();

			$this->load->view('templates/header',$this->data);
			$this->load->view('templates/leftnav',$this->data);
			$this->load->view('pages/consumables/item_forms_list',$this->data);	
			$this->load->view('templates/footer');
		}
		else
		{
			show_404();
		}						
    } 
}		
