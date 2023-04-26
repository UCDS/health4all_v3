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
	function edit_item($item_id){																	
		$this->db->trans_start();
		$this->db->where('item_id', $item_id);
		$edit_item = array();																
		if($this->input->post('item_name')){														
            $edit_item['item_name'] = $this->input->post('item_name');							
        }
		if($this->input->post('generic_item')){														
            $edit_item['generic_item_id'] = $this->input->post('generic_item');							
        }
		if($this->input->post('item_form')){														
            $edit_item['item_form_id'] = $this->input->post('item_form');							
        }
		if($this->input->post('description')){														
            $edit_item['description'] = $this->input->post('description');							
        }
		if($this->input->post('model')){														
            $edit_item['model'] = $this->input->post('model');							
        }
		
		   $this->db->update('item',$edit_item);
		   $this->db->trans_complete();
		if($this->db->trans_status()==FALSE){
			return false;
			}
        else{
           return true;
        }  
	}		
	function get_items()
	{

		$this->db->select('generic_item.generic_name,  item_type.item_type, item_form.item_form,
			item.item_id, item.item_name, item.model, item.description')
			->from('item')
			->join('item_form', 'item_form.item_form_id = item.item_form_id')
			->join('generic_item', 'generic_item.generic_item_id = item.generic_item_id')
			->join('item_type', 'item_type.item_type_id = generic_item.item_type_id');
			// ->join('drug_type', 'drug_type.drug_type_id = generic_item.drug_type_id', 'left');

		if($this->input->post('item_id')){
			$this->db->where('item.item_id', $this->input->post('item_id'));

		}else{
			if($this->input->post('item_type')){
				$this->db->where('item_type.item_type_id', $this->input->post('item_type'));
			}
			if($this->input->post('generic_item')){
				$this->db->where('item.generic_item_id', $this->input->post('generic_item'));
			}
			if($this->input->post('item_form')){
				$this->db->where('item_form.item_form_id', $this->input->post('item_form'));
			}
			$this->db->order_by('item.item_name', 'ASC');
		}		

		$query = $this->db->get();
		return $query->result();

	}
	function get_item($item_id)
	{
		$this->db->select('item.item_id, item.item_name, generic_item.generic_name,  generic_item.generic_item_id, 
			item_form.item_form_id, item_form.item_form, item.model, item.description')
			->from('item')
			->join('item_form', 'item_form.item_form_id = item.item_form_id')
			->join('generic_item', 'generic_item.generic_item_id = item.generic_item_id')
			->join('item_type', 'item_type.item_type_id = generic_item.item_type_id');
			$this->db->where('item.item_id', $item_id);

		$query = $this->db->get();
		return $query->result();
	}

	//This function is used to get data from Generic_item,Item_form tables.
function get_data($type=""){
		if($type=="generic_name")
			$this->db->select("generic_item_id,generic_name,drug_type_id,item_type_id")
			->from("generic_item")->order_by('generic_name', 'ASC');
		else if($type=="item_form")
			$this->db->select("item_form_id,item_form")->from("item_form")
			->order_by('item_form', 'ASC');
		else if($type=="item_type")
			$this->db->select("item_type_id, item_type")->from("item_type")
			->order_by('item_type', 'ASC');
		$query=$this->db->get();
		return $query->result();
		
	}			//end of get_data function.

	function check_if_exists($type="", $id){
		if($type=="generic_name")
			$this->db->select("generic_item_id")->from("generic_item")->where('generic_item_id', $id);
		else if($type=="item_form")
			$this->db->select("item_form_id")->from("item_form")->where('item_form_id', $id);
		$query=$this->db->get();
		return $query->result();
		
	}		//end of get_data method
	
}				//end of item_model.