<?php

class Generic_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }	//end of constructor
	//This function is used to take generic item details and insert into generic item table.
	function add_generic(){																	
        $get_generic = array();																
		if($this->input->post('generic_name')){														
            $get_generic['generic_name'] = $this->input->post('generic_name');							
        }
		if($this->input->post('drug_type')){														
            $get_generic['drug_type_id'] = $this->input->post('drug_type');							
        }
		if($this->input->post('item_type')){														
            $get_generic['item_type_id'] = $this->input->post('item_type');							
        }
		   $this->db->trans_start();
		   $this->db->insert('generic_item',$get_generic);
			$this->db->trans_complete();
		if($this->db->trans_status()===FALSE){
			return false;
			}
        else{
           return true;
        }  
	}			//end of add_generic method
	//This get_data method is used to take values from drug_type and item_type tables.
	function get_data($type=""){
		if($type=="drug_type")
		$this->db->select("drug_type_id,drug_type,description")->from("drug_type");
		else if($type=="item_type")
		$this->db->select("item_type_id,item_type")->from("item_type");
		$query=$this->db->get();
		return $query->result();
		
	}		//end of get_data method
	
}		//end of generic_model class