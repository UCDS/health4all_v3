<?php
class Indent_issue extends CI_Controller{                                                         //create Class with name Indent issue which extends CodeIgniter class controller 
    function __construct(){                                                                       //definition of constructor
        parent::__construct();                                                                    //calling Code igniter (parent) constructor
    }// __construct

 function indent_issued(){                                                                        //definition of a method :indent_approval
        if($this->session->userdata('logged_in')){                                                //checking whether user is in logging state or not;session:state of a user.
            $this->data['userdata']=$this->session->userdata('logged_in');                        //taking session data into data array of index:userdata                   
        }	
        else{
            show_404();                                                                          //if user is not logged in then this error will be thrown.
        }
        $this->data['userdata']=$this->session->userdata('logged_in');           
        $user_id=$this->data['userdata']['user_id'];                                             //user_id variable is created  and taking user id from user data of data array.
        $this->load->model('staff_model');                                                       //staff_model (model file) is loaded and called from CI_Controller function.
        $this->data['hospitals']=$this->staff_model->user_hospital($user_id);                    //storing hospital's user_id into data array of index:hospitals.
        $this->data['functions']=$this->staff_model->user_function($user_id);                    //storing user_id of function into data array index of functions(Authorizatio
        $this->data['departments']=$this->staff_model->user_department($user_id);  
        $this->data['op_forms']=$this->staff_model->get_forms("OP");                             //stroing op form details into data array of index:op_forms.
        $this->data['ip_forms']=$this->staff_model->get_forms("IP");                             //storing ip form details into data array of ip_forms.
        $access = -1;
        foreach($this->data['functions'] as $function){                                          //for loop that checks for first user_function of functions index is                                                                                                      HR_Recruitment;then make access=1.
            if($function->user_function=="Consumables"){
                $access = 1;
		break;
            }
	 }                                       
        if($access == -1){                                                                       //if there is no user function with HR_Recruitment then error is thrown.
            show_404();
        }                       
		$this->data['userdata']=$this->session->userdata('indent');                               //Store user data into data array of index:userdata
        $this->load->helper('form');                                                              //load form helper
        $this->load->library('form_validation');                                                  //load form_validation from library
        $this->data['title']="Indent_issue";                                                      //Store title into data array of title                                                 
        $this->load->view('templates/header',$this->data);                                        //load header(view) file and pass the data array to it
        $this->load->view('templates/leftnav',$this->data);                                       //load leftnav(view) file and pass the data array to it
        $this->load->model('consumables/indent_issue_model');                                                 //load indent_issue model file
	    $this->data['all_item_type']=$this->indent_issue_model->get_supply_chain_party("item_type");  //get item types from get_supply_chain_party method of indent_issue model and store it into data array of index:all_item_types
        $this->data['all_item']=$this->indent_issue_model->get_supply_chain_party("item");            //get items from get_supply_chain_party method of indent_issue model and store it into data array of index:all_items
        $this->data['parties']=$this->indent_issue_model->get_supply_chain_party("party");            //get parties from get_chain_party method of indent_approval model and store it into data array of index:parties
        $this->form_validation->set_rules('from_date', 'FROM Date',                               //set form validation rule on from_date
                    'trim|xss_clean');
        if($this->form_validation->run() == False){                                               //checking whether validation is true or false
            $this->data['mode']="search";                                                         //if then save search as mode into data array of index:mode
		    $this->data['all_indents']= $this->indent_issue_model->get_approved_indents();        //Store data from get_approved_indents method of indent_issue_model and save it into data array of index:all_indents
            $this->load->view('pages/consumables/indent_issue_view',$this->data);                             //load the indent_issue_view page and pass data array to it
        }
        else if($this->input->post('submit')){                                                    //it executes when user click on search button
            $this->data['mode']="submit";                                                         //save search in data array of index:mode
            $this->data['all_indents']=$this->indent_issue_model->get_approved_indents(); //get data from get_approved_indents method of indent_issue model and save it into data array on index:search_indent_issue
		    $this->load->view('pages/consumables/indent_issue_view',$this->data);                             //load indent_issue view page and pass data array to it
        }
		
		else if($this->input->post('auto_indent')){                                                    //it executes when user click on search button
            $this->data['mode']="auto_indent";                                                         //save search in data array of index:mode
            $this->load->model('consumables/indent_model');
		    $this->load->view('pages/consumables/indent_view',$this->data);                             //load indent_issue view page and pass data array to it
		}
        else if($this->input->post('select')){                                                    //it executes when user click on select button
            $this->data['mode']="select";                                                         //save select in data array of index:mode
            $this->data['indent_issued']=$this->indent_issue_model->display_issue_details();      //get data from display_issue_details method of indent_issue_model and store it into data array of index:indent_issued
            $this->load->view('pages/consumables/issued_details_view',$this->data);                           //load issued_details view page and pass data array to it
        
		} 
        else{
	        $this->data['get_issue']=$this->indent_issue_model->issue_indent();                   //get data from issue_indent method of indent_issue model and store it into data array of index:get_issue
			$this->data['all_indents']= $this->indent_issue_model->get_approved_indents();        //get data from get_approved_indents method of indent_issue model and store it into data array of index:all_indents
			$this->data['msg']= "<b style='color:green' >Issued successfully</b>";
			$this->data['mode']="update";                                                         //store update in data array of index:mode
            $this->data['issue_details']= $this->indent_issue_model->display_issue_details();	  //get data from display_issue_details method of indent_issue model and store it into data array of index:issue_detail			
            $this->load->view('pages/consumables/indent_issue_view',$this->data);                             //load indent_issue view page and pass data array to it
		}
        $this->load->view('templates/footer');                                                    //load footer(view) file
    }//indent_issued
}//indent_issue