<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Consumables extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('projects_model');
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
	function add($type=""){
	 	$this->load->helper('form');
		$this->load->library('form_validation');
		$user=$this->session->userdata('logged_in');
		$this->data['user_id']=$user['user_id'];
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function['user_function']=="Consumables" && $function['add']==1){
				$access=1;
			}
		}
		if($access==1){
		if($type=="drug_type"){
			$title="Add Drug";
		
			$config=array(
               array(
                     'field'   => 'drug_type',
                     'label'   => 'Drug Name',
                     'rules'   => 'required|trim|xss_clean'
                  ),
               array(
                     'field'   => 'description',
                     'label'   => 'Description',
                     'rules'   => 'required|trim|xss_clean'
                  )
			);
/*			$this->data['drug_type']=$this->masters_model->insert_data("drug_type");
			$this->data['divisions']=$this->masters_model->get_data("divisions");	
		*/


		}
	else if($type=="dosages"){
		 	$title="Add dosage";
		
			$config=array(
               array(
                     'field'   => 'dosage_unit',
                     'label'   => 'Dosage Name',
                     'rules'   => 'required|trim|xss_clean'
                  ),
               array(
                     'field'   => 'dosage',
                     'label'   => 'Dosage',
                     'rules'   => 'required|trim|xss_clean'
                  )
			);
}
else if($type=="equipment_type"){
		 	$title="Add Equipment Type";
		
			$config=array(
               array(
                     'field'   => 'equipment_name',
                     'label'   => 'Equipment Name',
                     'rules'   => 'required|trim|xss_clean'
                  )
             
			);
}

else if($type=="service"){
		 	$title="Add Service Records";
		
			$config=array(
                         array(
                     'field'   => 'working_status',
                     'label'   =>  'Working Status',
                     'rules'   => 'trim|xss_clean'
                  )
        
      
             
			);
$this->data['service']=$this->masters_model->get_data("service");
     		
}



else if($type=="service_records"){
		 	$title="Add Service Records";
		
			$config=array(
                         array(
                     'field'   => 'working_status',
                     'label'   =>  'Working Status',
                     'rules'   => 'required|trim|xss_clean'
                  )
        
             
             
			);
$this->data['user']=$this->masters_model->get_data("user");
		
}


	else if($type=="equipment"){
		 	$title="Add Equipment";
		
			$config=array(
               array(
                     'field'   => 'make',
                     'label'   => 'Make',
                     'rules'   => 'required|trim|xss_clean'
                  ),
                       array(
                     'field'   => 'equipment_status',
                     'label'   => 'equipment_status',
                     'rules'   => 'required|trim|xss_clean'
                  ),
		);

        $this->data['equipment_types']=$this->masters_model->get_data("equipment_types");
		$this->data['hospital']=$this->masters_model->get_data("hospital");
		$this->data['department']=$this->masters_model->get_data("department");
		$this->data['user']=$this->masters_model->get_data("user");
		

}
	
		else if($type=="generic"){
			$title="Add Generic Details";
			$config=array(
               array(
                     'field'   => 'generic_name',
                     'label'   => 'Generic Name',
                     'rules'   => 'required|trim|xss_clean'
                  ) 	
		     
			);
			$this->data['item_type']=$this->masters_model->get_data("item_type");
		$this->data['drug_type']=$this->masters_model->get_data("drug_type");
		
		}
		else if($type=="division"){
			$title="Add Division";
			$config=array(
               array(
                     'field'   => 'division_name',
                     'label'   => 'Division Name',
                     'rules'   => 'required|trim|xss_clean'
                  )
			);	
			$this->data['district']=$this->masters_model->get_data("districts");
		}
		else if($type=="grant"){
			$title="Add Grant";
			$config=array(
               array(
                     'field'   => 'grant_name',
                     'label'   => 'Grant Name',
                     'rules'   => 'required|trim|xss_clean'
                  ),
			  array(
                     'field'   => 'phase_name[]',
                     'label'   => 'Phase Name',
                     'rules'   => 'required|trim|xss_clean'
               )
			);
			$this->data['grant_sources']=$this->masters_model->get_data("grant_sources");
		}
		else if($type=="user"){
			$title="Add User";
			$config=array(
               array(
                     'field'   => 'user_name',
                     'label'   => 'User Name',
                     'rules'   => 'required|trim|xss_clean'
                  )
			);
		}
			
		else{
			show_404();
		}
		$page="pages/inventory/add_".$type."_form";
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
		else show_404();
  	}	
function edit($type=""){
	 	$this->load->helper('form');
		$this->load->library('form_validation');
		$user=$this->session->userdata('logged_in');
		$this->data['user_id']=$user['user_id'];
	if($type=="drug_type"){
			$title="Edit Drugs";
			$config=array(
               array(
                     'field'   => 'drug_type',
                     'label'   => 'Drugs',
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'description',
                     'label'   => 'Description',
                     'rules'   => 'trim|xss_clean'
                  )
		
			);
$this->data['drug_type']=$this->masters_model->get_data("drug_type");

		/*	$this->data['facility_types']=$this->masters_model->get_data("facility_types");
			$this->data['divisions']=$this->masters_model->get_data("divisions");	
		*/}
		else if($type=="agency"){
			$title="Edit Agency";
			$config=array(
               array(
                     'field'   => 'search_agency_name',
                     'label'   => 'Agency',
                     'rules'   => 'trim|xss_clean'
                  )
			);
			$this->data['agency']=$this->masters_model->get_data("agency");

		}
		else if($type=="service"){
		 	$title="Edit Service Records";
		
			$config=array(
                         array(
                     'field'   => 'working_status',
                     'label'   =>  'Working Status',
                     'rules'   => 'trim|xss_clean'
                  )
        
             
             
			);
$this->data['equipments']=$this->masters_model->get_data("equipments");
		
}

		else if($type=="equipment_type"){
		 	$title="Edit Equipment Type";
		
			$config=array(
               array(
                     'field'   => 'equipment_name',
                     'label'   => 'Equipment Name',
                     'rules'   => 'trim|xss_clean'
                  )
             
			);
      
$this->data['equipment_types']=$this->masters_model->get_data("equipment_type");

}

else if($type=="equipments"){
		 	$title="Edit Equipment Details";
		
			$config=array(
               array(
                     'field'   => 'equipment_name',
                     'label'   => 'Equipment Name ',
                     'rules'   => 'trim|xss_clean'
                  )
             
			);
$this->data['equipments']=$this->masters_model->get_data("equipments");

$this->data['equipment_type']=$this->masters_model->get_data("equipment_types");
$this->data['hospital']=$this->masters_model->get_data("hospital");
$this->data['department']=$this->masters_model->get_data("department");
$this->data['user']=$this->masters_model->get_data("user");
 }

		else if($type=="generics"){
			$title="Edit Generic";
			$config=array(
               array(
                     'field'   => 'generic_name',
                     'label'   => 'Generic',
                     'rules'   => 'trim|xss_clean'
                  )
			);
		$this->data['generic']=$this->masters_model->get_data("generics");
		$this->data['item_type']=$this->masters_model->get_data("item_type");
		$this->data['drug_type']=$this->masters_model->get_data("drug_type");
		
		}
		else if($type=="dosages"){
			$title="Edit Dosage";
			$config=array(
               array(
                     'field'   => 'dosage_unit',
                     'label'   => 'Dosage Unit',
                     'rules'   => 'trim|xss_clean'
                  ),
                array(
                     'field'   => 'dosage',
                     'label'   => 'Dosage',
                     'rules'   => 'trim|xss_clean'
                  )
		
			);
			$this->data['dosage']=$this->masters_model->get_data("dosages");
/*$this->data['generic']=$this->masters_model->get_data("generics");
$this->data['item_type']=$this->masters_model->get_data("item_type");
*/
		}
		
		else if($type=="division"){
			$title="Edit Division";
			$config=array(
               array(
                     'field'   => 'search_division',
                     'label'   => 'Division',
                     'rules'   => 'required|trim|xss_clean'
                  )
			);	
			$this->data['district']=$this->masters_model->get_data("districts");
			$this->data['divisions']=$this->masters_model->get_data("division");	
		}
		else if($type=="grant"){
			$title="Edit Grant";
			$config=array(
               array(
                     'field'   => 'grant_phase_id',
                     'label'   => 'Grant',
                     'runles'   => 'required|trim|xss_clean'
                  )
			);
			$this->data['grant_sources']=$this->masters_model->get_data("grant_sources");
		}
		else if($type=="user"){
			$title="Edit User";
			$config=array(
               array(
                     'field'   => 'user_id',
                     'label'   => 'Username',
                     'rules'   => 'required|trim|xss_clean'
                  )
			);
				$this->data['users']=$this->masters_model->get_data("user");
		}
			
		else{
			show_404();
		}
		
		$page="pages/inventory/edit_".$type."_form";
		$this->data['title']=$title;
		$this->load->view('templates/header',$this->data);
      $this->load->view('templates/leftnav',$this->data);
		
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
            $this->data['mode']="select";
			   $this->data[$type]=$this->masters_model->get_data($type);
         
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

