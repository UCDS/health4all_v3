<?php

class drug_type_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }		//end of constructor.
	//This is function that is used to insert drug_type data into drug_type table.
	function add_drug_type(){																	
        $get_drug_type = array();																
		if($this->input->post('drug_type')){														
            $get_drug_type['drug_type'] = $this->input->post('drug_type');							
        }
		if($this->input->post('description')){														
            $get_drug_type['description'] = $this->input->post('description');							
        }
		   $this->db->trans_start();
		   $this->db->insert('drug_type',$get_drug_type);
			$this->db->trans_complete();
		if($this->db->trans_status()==FALSE){
			return false;
			}
        else{
           return true;
        }  
}				//end of add_drug-type method.
}				//end of drug_type model.