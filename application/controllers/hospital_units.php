<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hospital_units extends CI_Controller
{
    function __construct(){                                                         //__Construct function
		parent::__construct();														//Calling the Parent __construct function
		$this->load->model('staff_model');											//Loading staff_model
		if($this->session->userdata('logged_in')){									//If user logged in successfully
		$userdata=$this->session->userdata('logged_in');                            //Storing user logged in data to $userdata array
		$user_id=$userdata['user_id'];												//Taking user_id from userdata array
		$this->data['hospitals']=$this->staff_model->user_hospital($user_id);		//Calling the user hospital method through the staff model and the result is stored into data array
		$this->data['functions']=$this->staff_model->user_function($user_id);		//Calling the user function method through the staff model and the result is stored into data array
		$this->data['departments']=$this->staff_model->user_department($user_id);	//Calling the user department method through the staff model and the result is stored into data array
		}
		$this->data['op_forms']=$this->staff_model->get_forms("OP");				//Calling op_forms method through the staff model and storing the result into data array
		$this->data['ip_forms']=$this->staff_model->get_forms("IP");				//Calling ip_forms method through the staff model and storing the result into data array
    }//_construct

   function add_unit(){   
		$access = -1;
        foreach($this->data['functions'] as $function){
            if($function->user_function=="Admin"){
                $access = 1;
				break;
            }
		}
		if($access != 1){
			show_404();
		}                                      					//function to add_unit in the hospital database
        $this->data['userdata']=$this->session->userdata('unit');  					//Storing user login data to data array
        $this->load->helper('form');                                   				//Loding helper
        $this->load->library('form_validation');                       				//Loading form_validation library
        $this->data['title']="add unit";                  							//Giving title as add_unit in the data array of title index
        $this->load->view('templates/header',$this->data);             				//Loading view
        $this->load->view('templates/leftnav');                        				//Loading leftnav
        
        $validations=array(                                            				//array of fields for validation
            array(   
                'field'=>'department_id',                                 
                'label'=>'departmentID',                                 
                'rules'=>'required'                                   
            ),
            array(
                'field'=>'unit_name',
                'label'=>'Unit Name',
                'rules'=>'required'
            )
        );
            $this->form_validation->set_rules($validations);                        //Calling form_validation function        
	        $this->form_validation->set_message('message','Please input missing details.');  //Setting message as please input missing details on error. 
         if ($this->form_validation->run() == FALSE)                                          //checking the condition weather it is false or not
          {
             //3$this->data['message']= "Validation failed.";                                  //message is stored into the data array 	 
          }
        else{      
			$this->load->model('hospital_unit_model');               //lodaing the hospital unit model
            if($this->hospital_unit_model->add_unit()){                        //calling the add unit method through the hospital unit model and check
                $this->data['message']= "unit added succesfully.";             //if added showing the message that message is stored into data array
            }
            else{
               $this->data['message']= "Something went wrong please try again.";                
            }            
        }
        $this->load->view('pages/hospital_unit_view',$this->data);
        $this->load->view('templates/footer');
    } 
    function update_unit(){                                                    //creating a method for update unit
		$this->data['userdata']=$this->session->userdata('unit');            //user data is stored into the data array
	 	$this->load->helper('form');                                         //lodaing the form
		$this->load->library('form_validation');                             //lodaing the form validation library
		$this->form_validation->set_rules('unit','required');               //setting the rules for required field
		$user=$this->session->userdata('logged_in');
		$this->data['title']="Update units";                                                     //update units title is stored into the data array
		$this->load->view('templates/header',$this->data);                                        //loading the header view
		$this->load->view('templates/leftnav',$this->data);                                         //loading the left nav view
     // $this->data['unit']=$this->staff_model->get_unit();
		$this->load->model('hospital_unit_model');
		//$this->load->view('pages/update_unit_view',$this->data);                                         //loading the view
		
			$validations=array(                                                                   //creating a variable validations for storing the required field which is in the array array
                         array(
                     'field'   => 'unit_name',
                     'label'   =>  'Unit_name',
                     'rules'   => 'trim|xss_clean'
                       ) 
			);
		$this->form_validation->set_rules($validations);		                                  //load the fields for validation.
	    $this->form_validation->set_message('message','Please input missing details.');           //if any input is missing then display message 'please input missing details.'
        if ($this->form_validation->run() === FALSE)		                                      //checking for validation is successful or not
        {
			$this->load->view('pages/update_unit_view',$this->data);
            //$this->data['message']= "Validation failed.";		                                  // if validation is  unsuccessful then display validation failed.
        }
		else{
			if($this->input->post('update')){
				
				if($this->hospital_unit_model->update_unit()){		
					$this->data['msg']="Updated Successfully";			
					$this->data['unit']=$this->hospital_unit_model->get_unit();   
					$this->load->view('pages/update_unit_view',$this->data)     ;                    //$this->load->view($page,$this->data);
	             }
			else{
					$this->data['msg']="Failed";
					$this->load->view('pages/update_unit_view',$this->data)     ; 
				}
			}
			else if($this->input->post('select')){
				$this->data['mode']="select";
				$this->data['unit']=$this->hospital_unit_model->get_unit();  
				$this->data['unit']=$this->data['unit'][0];
				$this->data['staff']=$this->staff_model->get_staff($this->data['unit']->unit_id);
				
				$this->load->view('pages/Edit_unit',$this->data);
			}
			else if($this->input->post('filter')){
            $this->data['mode']="filter";
			$this->data['unit']=$this->hospital_unit_model->get_unit(); 
			$this->load->view('pages/update_unit_view',$this->data)     ;
			}
			else if($this->input->post('search')){
				$this->data['mode']="search";
				$this->data['unit']=$this->hospital_unit_model->get_unit();
				$this->data['search_units']=$this->hospital_unit_model->get_unit();
				$this->load->view('pages/update_unit_view',$this->data)     ;  
				                      
			}
		}
		$this->load->view('templates/footer');
	}
}
?>

  
