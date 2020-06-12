<?php
class Item_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }			//end of constructor
	//This function is used to insert item data into Item master table.
	function add_item(){																	
        $get_item = array();																
		if($this->input->post('item_name')){														
            $get_item['item_name'] = $this->input->post('item_name');							
        }
		if($this->input->post('generic_name')){														
            $get_item['generic_item_id'] = $this->input->post('generic_name');							
        }
		if($this->input->post('item_form')){														
            $get_item['item_form_id'] = $this->input->post('item_form');							
        }
		if($this->input->post('description')){														
            $get_item['description'] = $this->input->post('description');							
        }
				if($this->input->post('model')){														
            $get_item['model'] = $this->input->post('model');							
        }
		
		   $this->db->trans_start();
		   $this->db->insert('item',$get_item);
		   $this->db->trans_complete();
		if($this->db->trans_status()==FALSE){
			return false;
			}
        else{
           return true;
        }  
	}		//end of add_item method.
	//This function is used to get data from Generic_item,Item_form tables.
function get_data($type=""){
		if($type=="generic_name")
		$this->db->select("generic_item_id,generic_name,drug_type_id,item_type_id")->from("generic_item");
		else if($type=="item_form")
		$this->db->select("item_form_id,item_form")->from("item_form");
		$query=$this->db->get();
		return $query->result();
		
	}			//end of get_data function.
	
}				//end of item_model.