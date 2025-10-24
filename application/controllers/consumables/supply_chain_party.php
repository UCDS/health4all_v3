<?php
class Supply_chain_party extends CI_Controller {		//creating controller with name Departments.
    function __construct() {				
        parent::__construct();					//calling parent constructor.
        $this->load->model('staff_model');
        $this->load->model('masters_model');
		//$this->load->model('list_departments');	
		if($this->session->userdata('logged_in')){		// checking for user authentication.
            $userdata=$this->session->userdata('logged_in');      //store the user information into the userdata variable.
            $user_id=$userdata['user_id'];      //store the userid into the userid variable.
            $this->data['hospitals']=$this->staff_model->user_hospital($user_id);	//calling the user_hospital method store the data into the data array with the index of hospitals.
            $this->data['functions']=$this->staff_model->user_function($user_id);	//calling the user_function method store the data into the data array with the index of functions.
            $this->data['departments']=$this->staff_model->user_department($user_id);	//calling the user_department method store the data into the data array with the index of departments.
		}
		$this->data['op_forms']=$this->staff_model->get_forms("OP");		//calling the get_forms method store the data into the data array with the index of op_forms.
		$this->data['ip_forms']=$this->staff_model->get_forms("IP");
        $this->data['custom_patient_visit_form'] = $this->masters_model->get_cust_patient_visit_forms();
        $this->load->model('consumables/supply_chain_party_model');					
	}

    function unique_scp($scp_name)
    {
        return $this->supply_chain_party_model->is_scp_unique($scp_name);
    }
    function department_valid($dep_id)
    {
        $res = $this->supply_chain_party_model->check_if_exists("department", $dep_id);
        return ($dep_id === NULL || count($res) > 0);
    }

    function area_valid($area_id)
    {
        $res = $this->supply_chain_party_model->check_if_exists("area", $area_id);
        return ($area_id === NULL || count($res) > 0);
    }

    function vendor_valid($vendor_id)
    {
        $res = $this->supply_chain_party_model->check_if_exists("vendor", $vendor_id);
        return ($vendor_id === NULL || count($res) > 0);
    }


	function add_supply_chain_party() {		                                  
		 $this->data['userdata']=$this->session->userdata('logged_in');
		 $user_id=$this->data['userdata']['user_id']; 
		 $this->load->model('staff_model');									
		 $this->data['functions']=$this->staff_model->user_function($user_id);
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
        $this->data['userdata']=$this->session->userdata('supply_chain_party');  
        $this->load->helper('form');		    
        $this->load->library('form_validation'); 
        $this->data['title']="Add supply_chain_party";	
        $this->load->view('templates/header',$this->data);		
        $this->load->view('templates/leftnav',$this->data);	
        $this->load->model('consumables/supply_chain_party_model');
        $this->data['hospitals']=$this->staff_model->get_hospital();
		 $this->data['departments']=$this->supply_chain_party_model->get_area("department");
        $this->data['all_area']=$this->supply_chain_party_model->get_area("area");
        $this->data['all_vendor']=$this->supply_chain_party_model->get_area("vendor");
        
        
        
        $config = array(
            array(
                'field'   => 'int_ext',
                'label'   => 'In House or External',
                'rules'   => 'required|trim|xss_clean'
			), 
			array(
                'field'   => 'supply_chain_party_name',
                'label'   => 'Supply Chain Party Name',
                'rules'   => 'required|trim|xss_clean|callback_scp_unique'
			), 
			array(
				'field'   => 'department',
				'label'   => 'Department',
				'rules'   => 'trim|xss_clean|callback_department_valid', 
				
			), 
			array(
				'field'   => 'area',
				'label'   => 'Area',
				'rules'   => 'trim|xss_clean|callback_area_valid',
			),
            array(
				'field'   => 'vendor',
				'label'   => 'Vendor',
				'rules'   => 'trim|xss_clean|callback_vendor_valid',
			) 	
			
	   	);
        $this->form_validation->set_rules($config);
        $this->form_validation->set_message('department_valid','Department entered is not valid.');        
        $this->form_validation->set_message('area_valid','Area entered is not valid.'); 
        $this->form_validation->set_message('vendor_valid','Vendor entered is not valid.'); 
        $this->form_validation->set_message('scp_unique', 'The supply chain party name for the given hospital already exists');
        if ($this->form_validation->run() === FALSE)		
        {
        }
        else{
			$this->load->model('consumables/supply_chain_party_model');           
            if($this->supply_chain_party_model->add_supply_chain_party()){	
               $this->data['msg']= "Supply Chain Party Added Succesfully.";            
            }
		
            else{
              $this->data['msg']= "Something went wrong please try again.";      
            }            
        }
        
        $this->load->view('pages/consumables/supply_chain_party_view',$this->data);			
        $this->load->view('templates/footer');	
        
	}

    function supply_chain_parties_list()
    {
        $this->data['userdata']=$this->session->userdata('logged_in');
        $user_id=$this->data['userdata']['user_id']; 
        $this->load->model('staff_model');									//instantiating staff_model.
        $this->data['functions']=$this->staff_model->user_function($user_id);
        $access = -1;
        $this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults"); 
        foreach($this->data['defaultsConfigs'] as $default){		 
        if($default->default_id=='pagination'){
                $this->data['rowsperpage'] = $default->value;
                $this->data['upper_rowsperpage']= $default->upper_range;
                $this->data['lower_rowsperpage']= $default->lower_range;
				break;
            }
        }
        foreach($this->data['functions'] as $function){
            if($function->user_function=="Masters - Consumables"){
                $access = 1;
				break;
            }
		}
		if($access != 1){
			show_404();
		}			
        $this->data['userdata']=$this->session->userdata('supply_chain_party');
        $this->load->helper('form');		    
        $this->load->library('form_validation'); 
        $this->data['title']="Supply Chain Party";	
        $this->load->view('templates/header',$this->data);		
        $this->load->view('templates/leftnav',$this->data);	
        $this->load->model('consumables/supply_chain_party_model');
        $this->data['hospitals']=$this->staff_model->get_hospital();
		$this->data['departments']=$this->supply_chain_party_model->get_area("department");
        $this->data['all_area']=$this->supply_chain_party_model->get_area("area");
        $this->data['all_vendor']=$this->supply_chain_party_model->get_area("vendor");
        
        $this->data['search_items'] = $this->supply_chain_party_model->get_scp_parties($this->data['rowsperpage']);
        $this->data['search_items_count'] = $this->supply_chain_party_model->get_scp_parties_count();
        
        $this->load->view('pages/consumables/supply_chain_parties_list_view', $this->data);
        $this->load->view('templates/footer');
    }

    function edit_supply_chain_party()
    {
        $this->data['userdata'] = $this->session->userdata('logged_in');
        $user_id = $this->data['userdata']['user_id']; 
        $this->load->model('staff_model');									
        $this->data['functions'] = $this->staff_model->user_function($user_id);
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
        $this->data['userdata']=$this->session->userdata('supply_chain_party'); 
        $this->load->helper('form');		   
        $this->load->library('form_validation'); 
        $this->data['title']="Add supply_chain_party";	
        $this->load->view('templates/header',$this->data);		
        $this->load->view('templates/leftnav',$this->data);	
        $this->load->model('consumables/supply_chain_party_model');
        $this->data['hospitals']=$this->staff_model->get_hospital();
		$this->data['departments']=$this->supply_chain_party_model->get_area("department");
        $this->data['all_area']=$this->supply_chain_party_model->get_area("area");
        $this->data['all_vendor']=$this->supply_chain_party_model->get_area("vendor");
        
        $scp_id = $this->input->post('navigate_edit');
        $this->data['item_result'] = $this->supply_chain_party_model->get_scp($scp_id);
        if($this->input->post('supply_chain_party_id')) 
        {
            if($this->supply_chain_party_model->edit_scp($this->input->post('supply_chain_party_id')))
            {
                $this->data['msg']= "Supply Chain Party Edited Succesfully.";       
            }else{
                $this->data['msg']= "Failure while editing supply chain party";        
            }
        }
        $this->load->view('pages/consumables/edit_supply_chain_party_view', $this->data);
        $this->load->view('templates/footer');
    }
}
