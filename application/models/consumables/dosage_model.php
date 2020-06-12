<?php

class dosage_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }		//end of constructor. 
	//This is function used to insert dosage data into dosage table.
	function add_dosage(){																	
        $get_dosage = array();																
		if($this->input->post('dosage')){														
            $get_dosage['dosage'] = $this->input->post('dosage');							
        }
		if($this->input->post('dosage_unit')){														
            $get_dosage['dosage_unit'] = $this->input->post('dosage_unit');							
        }
		   $this->db->trans_start();
		   $this->db->insert('dosage',$get_dosage);
		   //echo "inserted succesfully";
			$this->db->trans_complete();
		if($this->db->trans_status()==FALSE){
			return false;
			}
        else{
           return true;
        }  
}			//end of add_dosage.
}			//end of dosage model.
