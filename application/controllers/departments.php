<?php
class Departments extends CI_Controller {		
    function __construct() {				
        parent::__construct();					
        $this->load->model('staff_model');		
		//$this->load->model('list_departments');	
		if($this->session->userdata('logged_in')){		
			$userdata=$this->session->userdata('logged_in');      
			$user_id=$userdata['user_id'];      
			$this->data['hospitals']=$this->staff_model->get_hospital();	
			$this->data['functions']=$this->staff_model->user_function($user_id);	
			$this->data['departments']=$this->staff_model->user_department($user_id);	
		}
		$this->data['op_forms']=$this->staff_model->get_forms("OP");		
		$this->data['ip_forms']=$this->staff_model->get_forms("IP");					
	}
	function add_department(){		                                  
		$this->data['userdata']=$this->session->userdata('logged_in');
		$user_id=$this->data['userdata']['user_id']; 
		$this->load->model('staff_model');									
		$this->data['functions']=$this->staff_model->user_function($user_id);
		$access = -1;
		//var_dump($user_id);
        foreach($this->data['functions'] as $function){
            if($function->user_function=="Admin"){
                $access = 1;
				break;
            }
		}
		if($access != 1){
			show_404();
		}			
        $this->data['userdata']=$this->session->userdata('department');  
        $this->load->helper('form');		    
        $this->load->library('form_validation'); 
        $this->data['title']="Add department";	
        $this->load->view('templates/header',$this->data);		
        $this->load->view('templates/leftnav',$this->data);	
        //$this->load->view(pages/'department_view',$this->data);
        $this->data['list_departments']=$this->staff_model->get_list_department();	
        
        $validations=array(			
            array(
                'field'=>'department',     		
                'label'=>'Department',
                'rules'=>'required'
            ),
            array(
                'field'=>'hospital_id',			
                'label'=>'Hospital',
                'rules'=>'required'
            )
        );
        $this->form_validation->set_rules($validations);		
	    $this->form_validation->set_message('message','Please input missing details.');        
        if ($this->form_validation->run() === FALSE)		
        {
        }
        else{
			$this->load->model('hospital_model');           
            if($this->hospital_model->add_department()){		
                $this->data['msg']= "department added succesfully.";     
            }
            else{
                $this->data['message']= "Something went wrong please try again.";      
            }            
        }
        
        $this->load->view('pages/department_view',$this->data);			//load the department_view file with data.
        $this->load->view('templates/footer');	
        
	}
	
	function update_department(){
 		$this->data['userdata']=$this->session->userdata('department');
	 	$this->load->helper('form');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('department','required');
		$user=$this->session->userdata('logged_in');
		$this->data['title']="Update departments";
		$this->load->view('templates/header',$this->data);
      $this->load->view('templates/leftnav',$this->data);
      $this->data['hospitals']=$this->staff_model->get_hospital();
	  $this->load->model('hospital_model');
		
			$validations=array(
                         array(
                     'field'   => 'department',
                     'label'   =>  'Department',
                     'rules'   => 'trim|xss_clean'
                  ) 
        
			);
		$this->form_validation->set_rules($validations);		//load the fields for validation.
    	$this->form_validation->set_message('message','Please input missing details.');        //if any input is missing then display message 'please input missing details.'
        if ($this->form_validation->run() === FALSE)		//checking for validation is successful or not
        {
            $this->load->view('pages/depart1',$this->data);
        }
		else{
			if($this->input->post('update')){
				if($this->hospital_model->update_department()){
		
					$this->data['msg']="Updated Successfully";
						
				$this->data['department']=$this->hospital_model->get_department();
					$this->load->view('pages/depart1',$this->data);
				}
				else{
					$this->data['msg']="Failed";
					$this->load->view('pages/depart1',$this->data);
				}
			}
			else if($this->input->post('select')){
            $this->data['mode']="select";
			
		    $this->data['department']=$this->hospital_model->get_department();
		    $this->data['department']=$this->data['department'][0];
		    $this->data['staff']=$this->staff_model->get_staff($this->data['department']->department_id);
		    
		    $this->data['all_hospitals']=$this->hospital_model->get_department();
         
         	$this->load->view('pages/update_view',$this->data);
			}
			else if($this->input->post('filter')){
            $this->data['mode']="filter";
			$this->data['department']=$this->hospital_model->get_department();
         	$this->load->view('pages/depart1',$this->data);
			}
			else if($this->input->post('search')){
				$this->data['mode']="search";
				$this->data['search_departments']=$this->hospital_model->get_department();
				
				$this->load->view('pages/depart1',$this->data);
			}
		}
		//$this->load->view('pages/depart1',$this->data);
		$this->load->view('templates/footer');
	}
}


