<?php
class Item_type_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }			//end of constructor.
	//This function is used to insert item_type data into item_type table.
	function add_item_type(){																	
        $get_item_form = array();																
		if($this->input->post('item_type')){														
            $get_item_type['item_type'] = $this->input->post('item_type');							
        }
		   $this->db->trans_start();
		   $this->db->insert('item_type',$get_item_type);
			$this->db->trans_complete();
		if($this->db->trans_status()==FALSE){
			return false;
			}
        else{
           return true;
        }  
	}			//end of add_item_type.
}				//end of item_type_model.