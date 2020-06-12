<?php
class Item_form_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }			//end of constructor.
	//This function is used to insert item_form data into item_form table.
	function add_item_form(){																	
        $get_item_form = array();																
		if($this->input->post('item_form')){														
            $get_item_form['item_form'] = $this->input->post('item_form');							
        }
		   $this->db->trans_start();
		   $this->db->insert('item_form',$get_item_form);
			$this->db->trans_complete();
		if($this->db->trans_status()==FALSE){
			return false;
			}
        else{
           return true;
        }  
	}			//end of add_item_form.
}				//end of item_form_model.