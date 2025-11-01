<?php
class Indent extends CI_Controller {		
    function __construct() {				
        parent::__construct();	
        error_reporting(1);				
        		$this->load->model('staff_model');
                $this->load->model('masters_model');
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
        $this->data['custom_patient_visit_form'] = $this->masters_model->get_cust_patient_visit_forms();			
	}
    function authorized_party($party_id)
    {

       for($i = 0; $i < count($this->data['parties']); $i++){
            if ($this->data['parties'][$i]->supply_chain_party_id == $party_id)
                return true;
       }
       log_message("error", "Sairam validation failed in authorized_party");
        return false;
    }
    function valid_item($item_id)
    {
        for($i = 0; $i < count($this->data['all_item']); $i++){
            if ($this->data['all_item'][$i]->item_id == $item_id)
                return true;
       }
       log_message("error", "Sairam validation failed in valid_item");
        return false;
    }
    function ne_from($party_id)
    {
        return $this->input->post('from_id') && $party_id != $this->input->post('from_id');
    }

    

    function valid_inventory_quantities()
    {
        $item_ids = $this->input->post('item');
        $quantity_indented = $this->input->post('quantity_indented');
        for($i = 0; $i < count($this->input->post('item')); $i++){
            $item_id = $item_ids[$i];
            $item_quantity = $quantity_indented[$i];
            $sum = 0;
            $inventory_quantities = $this->input->post("quantity_$item_id");
            for($j = 0; $j < count($inventory_quantities); $j++){
                $sum = $sum + (int)$inventory_quantities[$j];
                // log_message("info", "Sairam: $inventory_quantities[$j] $sum");
            }

            if($sum !== (int)$item_quantity){
                log_message("info", "SAIRAM: inventory quantities validation failed $sum quantity_$i ".json_encode($this->input->post("quantity_$item_id"))." ".json_encode($this->input->post(NULL)));
                return false;
            }
            
        }
        return true;
        
    }

    function valid_inventory_dates()
    {
        foreach($this->input->post('item') as $j){
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
                'rules'=>'required|callback_authorized_party'
            ),
			array(
                'field'=>'to_id',			
                'label'=>'To Party',
                'rules'=>'required|callback_ne_from|callback_authorized_party'
            ), 
            array(
                'field'=>'item[]',			
                'label'=>'Item',
                'rules'=>'required|callback_valid_item'
            ), 
            array(
                'field'=>'quantity_indented[]',			
                'label'=>'Item Quantity',
                'rules'=>'required|is_natural_no_zero'
            ),
        );
		
        $this->form_validation->set_rules($validations);		//load the fields for validation.
	    $this->form_validation->set_message('message','Please input missing details.');        //if any input is missing then display message 'please input missing details.'
         $this->data['mode']="search";  
		if ($this->form_validation->run() === FALSE)		//checking for validation is successful or not
        {
			log_message("info", "VAL FAILED ".json_encode($this->input->post(NULL, TRUE)));
            $this->load->view('pages/consumables/indent_view', $this->data);
        }
        else{
			$this->load->model('consumables/indent_model');           //if validation is successful then load the hopital_model.		
            if($this->input->post('Submit')){
			    $output = $this->indent_model->add_indent();
                $this->load->model('consumables/indent_issue_model');
			    $this->data['register']=$this->indent_issue_model->get_single_indent_details($output[0]->indent_id);
                log_message("info", "SAIRAM ".json_encode($output));
                log_message("info", "SAIRAM ".$output[0]->indent_id. " ". json_encode($this->data['register']));
                $this->data['details'] = $this->data['register'];
                $this->data['msg']= "Indent added successfully.";     //if department added successfully then display the message department is added successfully.           
			    $this->load->view('pages/consumables/indent_details_view',$this->data);  
                $this->load->view('pages/consumables/indent_view');
                $this->load->view('pages/consumables/print_indent_detailed_view', $this->data);
			}	
		}	
        

        
		    
		
        $this->load->view('templates/footer');	
        
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

		$this->load->model('consumables/indent_model');
		$items = $this->indent_model->search_items_selectize();
		$res = array('items' => $items);
		echo json_encode($res);
	}

    function auto_indent(){		                                  
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
       $this->data['title']="Auto Indent";	
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
               'rules'=>'required|callback_authorized_party'
           ),
           array(
               'field'=>'to_id',			
               'label'=>'To Party',
               'rules'=>'required|callback_ne_from|callback_authorized_party'
           ), 
           array(
               'field'=>'item[]',			
               'label'=>'Item',
               'rules'=>'required|callback_valid_item'
           ), 
           array(
               'field'=>'quantity_indented[]',			
               'label'=>'Item Quantity',
               'rules'=>'required|is_natural_no_zero'
           ),
       );
       
       $this->form_validation->set_rules($validations);		//load the fields for validation.
       $this->form_validation->set_message('message','Please input missing details.');        //if any input is missing then display message 'please input missing details.'
        $this->data['mode']="search";  
    
       

       
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
           
           $this->form_validation->set_rules("quantity_indented[]", "QTY auto indented ", 'required|is_natural_no_zero');
           


           
           

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
           foreach($this->input->post('item') as $indented_item){
               log_message("INFO", "SAIRAM cost_{$indented_item}[]");
               $this->form_validation->set_rules("quantity_{$indented_item}[]", "QTY inventory $indented_item", 'required|is_natural_no_zero');
               $this->form_validation->set_rules("cost_{$indented_item}[]", "COST inventory $indented_item", 'required|callback_valid_cost');
               
               // $this->form_validation->set_rules("cost_{$indented_item}[]", "COST inventory $indented_item", 'is_natural');
           }
           if(!$this->valid_inventory_quantities() || !$this->valid_inventory_dates() || $this->form_validation->run() == False){
                log_message("info", "SAIRAM VALIDATION FAILED");
               $this->data['mode']="auto_indent";
               $this->load->view('pages/consumables/auto_indent_view',$this->data);
           }else{
                
               $this->load->model('consumables/indent_model');
               if($this->input->post('Submit')){
                    $output = $this->indent_model->add_indent();
                    $this->load->model('consumables/indent_issue_model');
                    $this->data['issue_details']=$this->indent_issue_model->get_single_indent_details($output[0]->indent_id);
                    log_message("info", "SAIRAM ".json_encode($output));
                    log_message("info", "SAIRAM ".$output[0]->indent_id. " ". json_encode($this->data['issue_details']));
                    $this->data['details'] = $this->data['issue_details'];
                    $this->data['msg']= "Indent added successfully.";     //if department added successfully then display the message department is added successfully.           
                    $this->data['mode']="update";
                    // $this->load->view('pages/consumables/indent_details_view',$this->data);  
                    $this->load->view('pages/consumables/print_indent_detailed_view', $this->data);
                }else{
                    $this->data['mode']="auto";

                }	

               $this->load->model('consumables/indent_issue_model');
               $this->data['all_item_type']=$this->indent_issue_model->get_supply_chain_party("item_type");  //get item types from get_supply_chain_party method of indent_issue model and store it into data array of index:all_item_types
               $this->data['all_item']=$this->indent_issue_model->get_supply_chain_party("item");            //get items from get_supply_chain_party method of indent_issue model and store it into data array of index:all_items
               $this->data['parties']=$this->indent_issue_model->get_supply_chain_party("party"); 
               $this->data['all_indents']= $this->indent_issue_model->get_approved_indents();  
               $this->load->view('pages/consumables/indent_issue_view',$this->data);
           }
           
           
       
           
       
       $this->load->view('templates/footer');	
       
   }

   public function check_item_balance()
   {
        $this->load->model('consumables/indent_report_model');
        $item_id = $this->input->post('item_id');
        $closing_balance = $this->indent_report_model->get_individual_item_closing_balance($item_id);
        $balance = 0;
        if (!empty($closing_balance)) 
        {
            $balance = $closing_balance[0]->current_balance;
        }
        echo json_encode([
            'balance' => $balance
        ]);
    }

    public function check_party_type()
    {
        $this->load->model('consumables/indent_report_model');
        $party_id = $this->input->post('from_id');
        $res = $this->indent_report_model->get_scp_type($party_id);
        
        if ($res) {
            echo json_encode(['is_external' => $res->is_external]);
        } else {
            echo json_encode(['is_external' => null]);
        }
    }


}
