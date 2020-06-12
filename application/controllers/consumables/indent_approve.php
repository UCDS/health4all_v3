<?php 
class Indent_approve extends CI_Controller{                                                 //create Class with name Indent_approve which extends CodeIgniter class controller             
    function __construct(){                                                                 //definition of constructor
    parent::__construct();                                                                  //calling Code igniter (parent) constructor
    }// __construct

    function indent_approval(){                                                             //definition of a method :indent_approval
        if($this->session->userdata('logged_in')){                                          //checking whether user is in logging state or not;session:state of a user.
            $this->data['userdata']=$this->session->userdata('logged_in');                  //taking session data into data array of index:userdata                   
        }	
        else{
            show_404();                                                                     //if user is not logged in then this error will be thrown.
        }
        $this->data['userdata']=$this->session->userdata('logged_in');           
        $user_id=$this->data['userdata']['user_id'];                                       //user_id variable is created  and taking user id from user data of data array.
        $this->load->model('staff_model');                                                 //staff_model (model file) is loaded and called from CI_Controller function.
        $this->data['hospitals']=$this->staff_model->user_hospital($user_id);              //storing hospital's user_id into data array of index:hospitals.
        $this->data['functions']=$this->staff_model->user_function($user_id);              //storing user_id of function into data array index of functions(Authorizatio
        $this->data['departments']=$this->staff_model->user_department($user_id);  
        $this->data['op_forms']=$this->staff_model->get_forms("OP");                       //stroing op form details into data array of index:op_forms.
        $this->data['ip_forms']=$this->staff_model->get_forms("IP");                       //storing ip form details into data array of ip_forms.
        $access = -1;
        foreach($this->data['functions'] as $function){                                    //for loop that checks for first user_function of functions index is                                                                                                      HR_Recruitment;then make access=1.
            if($function->user_function=="Consumables"){
                $access = 1;
		break;
            }
	 }                                       
        if($access == -1){                                                          //if there is no user function with HR_Recruitment then error is thrown.
            show_404();
        }                       
		$this->data['userdata']=$this->session->userdata('indent');                         //Store user data into data array of index:userdata
        $this->load->helper('form');                                                        //load form helper
        $this->load->library('form_validation');                                            //load form_validation from library
        $this->data['title']="Indent_approval";                                             //Store title into data array of title                                                            
        $this->load->view('templates/header',$this->data);                                  //load header(view) file and pass the data array to it
        $this->load->view('templates/leftnav',$this->data);                                 //load leftnav(view) file and pass the data array to it
        $this->load->model('consumables/indent_approval_model');                                        //load indent_approval model file
        $this->data['all_item_type']=$this->indent_approval_model->get_supply_chain_party("item_type"); //get item types from get_supply_chain_party method of indent_approval model and store it into data array of index:all_item_types
        $this->data['all_item']=$this->indent_approval_model->get_supply_chain_party("item");           //get items from get_supply_chain_party method of indent_approval model and store it into data array of index:all_items
        $this->data['parties']=$this->indent_approval_model->get_supply_chain_party("party");           //get parties from get_supply_chain_party method of indent_approval model and store it into data array of index:parties
        $this->form_validation->set_rules('from_date', 'FROM Date',                         //set form validation rule on from_date
                    'trim|xss_clean');
        if($this->form_validation->run() == False){                                         //checking whether validation is true or false
			$this->data['mode']="search";                                                   //if then save search as mode into data array of index:mode
            $this->data['all_indents']= $this->indent_approval_model->get_indents();        //Store data from get_indents method of indent_approval_model and save it into data array of index:all_indents
            $this->load->view('pages/consumables/indent_approval_view',$this->data);                    //load the indent_approval_view page and pass data array to it
		}
        else if($this->input->post('submit')){                                              //it executes when user click on submit button
            $this->data['mode']="submit";                                                   //save submit in data array of index:mode
            $this->data['all_indents']= $this->indent_approval_model->get_indents();        //get data from get_indents method of indent_approval model and save it into data array on index:all_indents
            $this->load->view('pages/consumables/indent_approval_view',$this->data);                    //load indent_aproval view page and pass data array to it
        }
        else if($this->input->post('select')){                                              //it executes when user click on select button
            $this->data['mode']="select";                                                   //save select in data array of index:mode
            $this->data['indent_approval']=$this->indent_approval_model->display_approve_details();//get data from display_approve_details method of indent_approval_model and store it into data array of index:indent_approval
            $this->load->view('pages/consumables/approval_details_view',$this->data);                   //load approval_details view page and pass data array to it
        } 
        else{
	        $this->data['get_approve']=$this->indent_approval_model->approve_indent();      //get data from approve_indent method of indent_approval model and store it into data array of index:get_approve
			$this->data['all_indents']= $this->indent_approval_model->get_indents();        //get data from get_indents method of indent_approval model and store it into data array of index:all_indents
			if($this->data['get_approve']==1){
			$this->data['msg']= "<b style='color:green' >Approved succesfully</b>";
			}else {
				$this->data['msg']= "<b style='color:green' >Order is rejected</b>";
			}
			$this->data['mode']="update";                                                   //store update in data array of index:mode
            $this->data['approve_detail']= $this->indent_approval_model->display_approve_details();//get data from display_approve_details method of indent_approval model and store it into data array of index:approve_detail		
            $this->load->view('pages/consumables/indent_approval_view',$this->data);                    //load indent_approval view page and pass data array to it
		}
        $this->load->view('templates/footer');                                               //load footer(view) file
    }//indent_approval_end
 } //indent_approve_end
  