<?php
class Indent_issue extends CI_Controller{                                                         //create Class with name Indent issue which extends CodeIgniter class controller 
    function __construct(){                                                                       //definition of constructor
        parent::__construct();
        $this->load->model('consumables/indent_model');                                                                //calling Code igniter (parent) constructor
    }// __construct
    function indent_id_check($selected_indent_id)
    {   
        $hospital=$this->session->userdata('hospital');
        $indent = $this->indent_model->get_indent_info($selected_indent_id);

        return $indent && $indent->hospital_id == $hospital['hospital_id'];
    }
    
    function validate_date_time($approve_date_time)
    {
        $f_approve_date_time =strtotime($approve_date_time);
        $f_issue_date_time =strtotime($this->input->post('issue_date') . " " . $this->input->post('issue_time'));
        log_message("info", "SAIRAM: a: $f_approve_date_time, i: $f_issue_date_time ".($f_issue_date_time >= $f_approve_date_time ? "True": "False"));
        return $f_issue_date_time >= $f_approve_date_time;
    }

    function valid_indent_item_id($indent_item_id)
    {   
        // $hospital=$this->session->userdata('hospital');
        // $valid = false;
        log_message("INFO", "SAIRAM FROM ISSUE - $indent_item_id");
        foreach($this->issue_details as $ad){
           if($indent_item_id == $ad->indent_item_id)
            return true; 
        }
        return false;
    }

    function valid_from_party_id($from_party_id)
    {
        return $from_party_id == $this->issue_details[0]->from_party_id;
    }

    function valid_to_party_id($to_party_id)
    {
        return $to_party_id == $this->issue_details[0]->to_party_id;
    }

    function valid_item_id($item_id)
    {   
        // $hospital=$this->session->userdata('hospital');
        // $valid = false;
        log_message("INFO", "SAIRAM FROM ISSUE - $item_id");
        foreach($this->issue_details as $ad){
           if($item_id == $ad->item_id)
            return true; 
        }
        return false;
    }

    function valid_inventory_quantities()
    {
        foreach($this->input->post('indent_item') as $i){
            $sum = 0;
            $quantities = $this->input->post("quantity_$i");
            for($j = 0; $j < count($quantities); $j++){
                $sum += $quantities[$j];
            }
            if($sum != (int)$this->input->post("quantity_issued_$i")){
                
                log_message("info", "SAIRAM: inventory quantities validation failed $sum quantity_issued_$i ".$this->input->post("quantity_issued_$i")." ".json_encode($this->input->post(NULL)));
                return false;
            }

        }
        return true;
    }

    function valid_inventory_dates()
    {
        foreach($this->input->post('indent_item') as $j){
            $mfg_dates = $this->input->post("mfg_date_$j");
            $exp_dates = $this->input->post("exp_date_$j");
            log_message("info", "SAIRAM IN VALID INVENTORY DATES ".json_encode($mfg_dates));
            $n = count($this->input->post("mfg_date_$j"));

            for($i = 0; $i < $n; $i++){
                if($mfg_dates[$i] == null && $exp_dates[$i] == null)
                    continue;
                    
                $mfg_timestamp = strtotime($mfg_dates[$i]);
                $exp_timestamp = strtotime($exp_dates[$i].'+23 hour 59 minute 59 second');
                $call_timestamp = strtotime(date("Y-m-d H:i:s"));
                log_message("info", "SAIRAM from VALID INV DATES $mfg_timestamp $exp_timestamp $call_timestamp");
                if($mfg_timestamp != null && $mfg_timestamp > $call_timestamp){
                    log_message("info", "SAIRAM: inventory dates validation failed");
                    return false;
                }

                if($exp_timestamp != null && $exp_timestamp <= $call_timestamp){
                    log_message("info", "SAIRAM: inventory dates validation failed");
                    return false;
                }
                if($mfg_timestamp != null && $exp_timestamp != null && $exp_timestamp < $mfg_timestamp){
                    log_message("info", "SAIRAM: inventory dates validation failed");
                    return false;
                }
            }
            

        }
        return true;
    }
    function valid_cost($cost)
    {
        
        if(is_numeric($cost) && $cost >= 0.0){
            return true;
        }else{
            log_message("Sairam validation failed for cost $cost ". is_numeric($cost));
            return false;
        }
    }
    function search_selectize_items()
	{
		if($this->session->userdata('logged_in')){                                                //checking whether user is in logging state or not;session:state of a user.
            $this->data['userdata']=$this->session->userdata('logged_in');                        //taking session data into data array of index:userdata                   
        }	
        else{
            show_404();                                                                          //if user is not logged in then this error will be thrown.
        }
		$this->data['userdata'] = $this->session->userdata('logged_in');
		$user_id = $this->data['userdata']['user_id'];
		$this->load->model('staff_model');
		$this->data['functions'] = $this->staff_model->user_function($user_id);
		$access = -1;
		//var_dump($item_type_id);
		foreach ($this->data['functions'] as $function) {
			if ($function->user_function == "Consumables") {
				$access = 1;
				break;
			}
		}
		if ($access != 1) {
			show_404();
		}

		$this->load->model('consumables/indent_issue_model');
		$items = $this->indent_issue_model->search_items_selectize();
		$res = array('items' => $items);
		echo json_encode($res);
	}

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
        $this->data['title']="Indent Issue";                                                      //Store title into data array of title                                                 
        $this->load->view('templates/header',$this->data);                                        //load header(view) file and pass the data array to it
        $this->load->view('templates/leftnav',$this->data);                                       //load leftnav(view) file and pass the data array to it
        $this->load->model('consumables/indent_issue_model');                                                 //load indent_issue model file
	    $this->data['all_item_type']=$this->indent_issue_model->get_supply_chain_party("item_type");  //get item types from get_supply_chain_party method of indent_issue model and store it into data array of index:all_item_types
        $this->data['all_item']=$this->indent_issue_model->get_supply_chain_party("item", 20);            //get items from get_supply_chain_party method of indent_issue model and store it into data array of index:all_items
        $this->data['parties']=$this->indent_issue_model->get_supply_chain_party("party");            //get parties from get_chain_party method of indent_approval model and store it into data array of index:parties
        
        $this->form_validation->set_rules('from_date', 'FROM Date',                               //set form validation rule on from_date
                    'trim|xss_clean');


        $this->form_validation->set_rules("selected_indent_id", "SELECTED INDENT ID", "required|callback_indent_id_check");
        if($this->form_validation->run() == False){                                               //checking whether validation is true or false
            
            $this->data['mode']="search";                                                         //if then save search as mode into data array of index:mode
            $this->data['all_indents']= $this->indent_issue_model->get_approved_indents();        //Store data from get_approved_indents method of indent_issue_model and save it into data array of index:all_indents
            $this->load->view('pages/consumables/indent_issue_view',$this->data);
        }
        else if($this->input->post('submit')){                                                    //it executes when user click on search button
            $this->data['mode']="submit";                                                         //save search in data array of index:mode
            $this->data['all_indents']=$this->indent_issue_model->get_approved_indents(); //get data from get_approved_indents method of indent_issue model and save it into data array on index:search_indent_issue
		    $this->load->view('pages/consumables/indent_issue_view',$this->data);                             //load indent_issue view page and pass data array to it
        }
		
		else if($this->input->post('auto_indent')){                                                    //it executes when user click on search button
            // log_message("info", "SAIRAM: AUTO INDENT REQUESTED");
            $this->data['mode']="auto_indent";                                                         //save search in data array of index:mode
            $this->load->model('consumables/indent_model');
		    $this->load->view('pages/consumables/auto_indent_view',$this->data);                             //load indent_issue view page and pass data array to it
		}
        else if($this->input->post('select')){                                                    //it executes when user click on select button
            $this->data['mode']="select";                                                         //save select in data array of index:mode
            $this->data['indent_issued']=$this->indent_issue_model->display_issue_details();      //get data from display_issue_details method of indent_issue_model and store it into data array of index:indent_issued
            $this->load->view('pages/consumables/issued_details_view',$this->data);                           //load issued_details view page and pass data array to it
        
		} 
        else{
            $this->issue_details = $this->indent_issue_model->display_issue_details();
            log_message("info", "COMING BACK TO ISSUE DETAILS VIEW");
            if($this->issue_details[0]->indent_status == "Issued"){
                $this->data['msg'] = "<b style='color:red' >Issue complete! Cannot do so again.</b>";
                $this->data['mode']="search";                                                         //if then save search as mode into data array of index:mode
                $this->data['all_indents']= $this->indent_issue_model->get_approved_indents();        //Store data from get_approved_indents method of indent_issue_model and save it into data array of index:all_indents
                $this->load->view('pages/consumables/indent_issue_view',$this->data);                             //load the indent_issue_view page and pass data array to it
                $this->load->view('templates/footer');                                                    //load footer(view) file
                $this->issue_details = null;
                return;

            }
            

            // VALIDATIONS
            /* OVERALL
                - from_party_id(h) ==*
                -- required 
                -- check if valid
                - to_party_id(h) 
                -- required
                -- check if valid

                - indent(h) ==*
                -- required
                -- check if id is valid
                - selected_indent_id(h) ==*
                -- required
                -- must match indent

                - issue date ==*
                -- required
                -- >= approve_date_time*
                -- <= current_date_time*
                - issue time ==*
                -- required
                -- >= approve_date_time*
                -- <= current_date_time*
            */
            $this->form_validation->set_rules("from_party_id", "FROM PARTY ID", "required|callback_valid_from_party_id");
            $this->form_validation->set_rules("to_party_id", "TO PARTY ID", "required|callback_valid_to_party_id|differs[to_party_id]");

            $this->form_validation->set_rules("indent", "INDENT ID", "required|matches[selected_indent_id]");
            $this->form_validation->set_rules("issue_date", "ISSUE DATE", "required");
            $this->form_validation->set_rules("issue_time", "ISSUE TIME", "required");

            /* INDENT ITEM:
                - quantity
                -- required
                -- positive (>= 0)
                - indent_item
                -- required
                -- check if valid 
                - item_id(h)
                -- required
                -- check if valid
            */
            foreach($this->issue_details as $issued){
                $this->form_validation->set_rules("quantity_issued_$issued->indent_item_id", "QTY issued $issued->indent_item_id", 'required|is_natural');
                $this->form_validation->set_rules("item_id_$issued->indent_item_id", "ITEM ID", "required|callback_valid_item_id");

            }
            $this->form_validation->set_rules("indent_item[]", "INDENT ITEM ID", "required|callback_valid_indent_item_id");

            /* INVENTORY ITEM:
                - quantity
                -- required
                -- sum(in.quantity) == ii.quantity
                - batch_id
                -- not mandatory
                - mfg date
                -- not mandatory
                -- mfg date <= current_date && mfg date <= expiry_date
                - expiry date
                -- not mandatory
                -- expiry date >(=?) current_date && expiry date >= mfg date
                - cost
                -- not mandatory
                -- positive (>= 0)
                - patient_id
                - note
                - gtin_code
            */
            foreach($this->issue_details as $issued){
                $this->form_validation->set_rules("quantity_$issued->indent_item_id[]", "QTY inventory $issued->indent_item_id", 'required|is_natural_no_zero');
                
                // $this->form_validation->set_rules("cost_$issued->indent_item_id[]", "COST inventory $issued->indent_item_id", 'is_natural');
                $this->form_validation->set_rules("cost_$issued->indent_item_id[]", "COST inventory $issued->indent_item_id", 'required|callback_valid_cost');

                
                
            }


            if(!$this->valid_inventory_quantities() || !$this->valid_inventory_dates() || !$this->validate_date_time($this->issue_details[0]->approve_date_time) || $this->form_validation->run() == False){
                log_message("info", "SAIRAM DID NOT WORK");
                $this->data['mode']="select";                                                         //save select in data array of index:mode
                $this->data['indent_issued']=$this->issue_details;      //get data from display_issue_details method of indent_issue_model and store it into data array of index:indent_issued
                $this->load->view('pages/consumables/issued_details_view',$this->data);
            }else{
                log_message("info", "SAIRAM :=> ".json_encode($this->input->post(NULL, FALSE)));

                $this->data['get_issue']=$this->indent_issue_model->issue_indent();                   //get data from issue_indent method of indent_issue model and store it into data array of index:get_issue
                $this->data['all_indents']= $this->indent_issue_model->get_approved_indents();        //get data from get_approved_indents method of indent_issue model and store it into data array of index:all_indents
                $this->data['msg']= "<b style='color:green' >Issued successfully</b>";
                $this->data['mode']="update";                                                         //store update in data array of index:mode
                $this->data['issue_details']= $this->indent_issue_model->get_single_indent_details($this->input->post('selected_indent_id'));	  //get data from display_issue_details method of indent_issue model and store it into data array of index:issue_detail			
                $this->data['details'] = $this->data['issue_details'];
                $this->load->view('pages/consumables/indent_issue_view',$this->data);                             //load indent_issue view page and pass data array to it
                $this->load->view('pages/consumables/print_indent_detailed_view', $this->data);
            }
		}
        $this->load->view('templates/footer');                                                    //load footer(view) file
        $this->issue_details = null;
    }//indent_issued
}//indent_issue