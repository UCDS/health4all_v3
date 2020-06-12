<?php
class Indent extends CI_Controller {		
    function __construct() {				
        parent::__construct();					
        		$this->load->model('staff_model');
		//$this->load->model('consumables/list_departments');	
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
	function add_indent(){		                                  
		 $this->data['userdata']=$this->session->userdata('logged_in');
		 $user_id=$this->data['userdata']['user_id']; 
		 $this->load->model('staff_model');									
		 $this->data['functions']=$this->staff_model->user_function($user_id);
		 $access = -1;
		//var_dump($user_id);
        foreach($this->data['functions'] as $function){
            if($function->user_function=="Consumables"){
                $access = 1;
				break;
            }
		}
		if($access != 1){
			show_404();
		}			
        $this->data['userdata']=$this->session->userdata('indent');  
		$this->data['hosp']=$this->session->userdata('hospital');
        $this->load->helper('form');		    
        $this->load->library('form_validation'); 
        $this->data['title']="Add Indent";	
        $this->load->view('templates/header',$this->data);	
        $this->load->view('templates/leftnav',$this->data);	
        $this->load->model('consumables/indent_model');
        
        $this->data['parties']=$this->indent_model->get_supply_chain_party("party");
        $this->data['all_item']=$this->indent_model->get_supply_chain_party("item");
        
        
        
        
        $validations=array(			
            array(
                'field'=>'indent_date',     		
                'label'=>'Indent_date',
                'rules'=>'required'
            ),
            array(
                'field'=>'from_id',			
                'label'=>'From Party',
                'rules'=>'required'
            ),
			array(
                'field'=>'to_id',			
                'label'=>'To Party',
                'rules'=>'required'
            )
        );
		
        $this->form_validation->set_rules($validations);		//load the fields for validation.
	    $this->form_validation->set_message('message','Please input missing details.');        //if any input is missing then display message 'please input missing details.'
         $this->data['mode']="search";  
		if ($this->form_validation->run() === FALSE)		//checking for validation is successful or not
        {
			
        }
        else{
			$this->load->model('consumables/indent_model');           //if validation is successful then load the hopital_model.		
            if($this->input->post('Submit')){
			    $output = $this->indent_model->add_indent();
			    $this->data['register']=$output;
                $this->data['msg']= "Indent added succesfully.";     //if department added successfully then display the message department is added successfully.           
			    $this->load->view('pages/consumables/indent_details_view',$this->data);  
			}	
		}			
		        if($this->input->post('auto_indent')==1){
			        $this->load->model('consumables/indent_issue_model');
					$this->data['all_item_type']=$this->indent_issue_model->get_supply_chain_party("item_type");  //get item types from get_supply_chain_party method of indent_issue model and store it into data array of index:all_item_types
                    $this->data['all_item']=$this->indent_issue_model->get_supply_chain_party("item");            //get items from get_supply_chain_party method of indent_issue model and store it into data array of index:all_items
                    $this->data['parties']=$this->indent_issue_model->get_supply_chain_party("party"); 
			        $this->data['all_indents']= $this->indent_issue_model->get_approved_indents();  
					$this->data['mode']="auto";
			        $this->load->view('pages/consumables/indent_issue_view',$this->data);
					
					
		        }else{
                    $this->load->view('pages/consumables/indent_view',$this->data);			//load the department_view file with data.
		        }
		    
		
             $this->load->view('templates/footer');	
        
	}
}
