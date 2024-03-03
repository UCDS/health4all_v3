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
	function edit_generic($generic_item_id){																	
		$this->db->trans_start();
        $edit_generic = array();		
		$this->db->where('generic_item_id', $generic_item_id);														
		if($this->input->post('generic_name')){														
            $edit_generic['generic_name'] = $this->input->post('generic_name');							
        }
		
		if($this->input->post('item_type')){														
            $edit_generic['item_type_id'] = $this->input->post('item_type');							
        }

		if($this->input->post('drug_type')){														
            $edit_generic['drug_type_id'] = $this->input->post('drug_type');							
        }else{
			$edit_generic['drug_type_id'] = '0';
		}
		// echo json_encode($edit_generic);
		$this->db->set($edit_generic);
		$this->db->update('generic_item');
		$this->db->trans_complete();

		if($this->db->trans_status()===FALSE){
			return false;
		}else{
           return true;
        }  
	}			//end of add_generic method
	//This get_data method is used to take values from drug_type and item_type tables.

	function get_generic_items($default_rowsperpage)
	{
		if ($this->input->post('page_no')) {
			$page_no = $this->input->post('page_no');
		}
		else{
			$page_no = 1;
		}
		if($this->input->post('rows_per_page')) {
			$rows_per_page = $this->input->post('rows_per_page');
		}
		else{
			$rows_per_page = $default_rowsperpage;
		}
		$start = ($page_no -1 )  * $rows_per_page;

		$this->db->select('generic_item.generic_item_id, generic_item.generic_name,  item_type.item_type, 
			drug_type.drug_type, generic_item.note, generic_item.side_effect')
			->from('generic_item')
			// ->join('item_form', 'item_form.item_form_id = generic_item.form_id')
			->join('item_type', 'item_type.item_type_id = generic_item.item_type_id', 'left')
			->join('drug_type', 'drug_type.drug_type_id = generic_item.drug_type_id', 'left');

		if($this->input->post('generic_item_id')){
			$this->db->where('generic_item.generic_item_id', $this->input->post('generic_item_id'));

		}else{
			if($this->input->post('item_type')){
				$this->db->where('item_type.item_type_id', $this->input->post('item_type'));
			}
			
			if($this->input->post('drug_type')){
				$this->db->where('drug_type.drug_type_id', $this->input->post('drug_type'));
			}
			//$this->db->order_by('generic_item.generic_name', 'ASC'); old
			$this->db->order_by('generic_item.generic_item_id', 'ASC');
		}	
		
		if ($default_rowsperpage !=0)
		{
			$this->db->limit($rows_per_page,$start);
		}
		$query = $this->db->get();
		return $query->result();

	}

	function list_generic_items_count()
	{
		$this->db->select('COUNT(generic_item.generic_item_id) count, generic_item.generic_name,  item_type.item_type, 
			drug_type.drug_type, generic_item.note, generic_item.side_effect')
			->from('generic_item')
			// ->join('item_form', 'item_form.item_form_id = generic_item.form_id')
			->join('item_type', 'item_type.item_type_id = generic_item.item_type_id', 'left')
			->join('drug_type', 'drug_type.drug_type_id = generic_item.drug_type_id', 'left');

		if($this->input->post('generic_item_id')){
			$this->db->where('generic_item.generic_item_id', $this->input->post('generic_item_id'));

		}else{
			if($this->input->post('item_type')){
				$this->db->where('item_type.item_type_id', $this->input->post('item_type'));
			}
			
			if($this->input->post('drug_type')){
				$this->db->where('drug_type.drug_type_id', $this->input->post('drug_type'));
			}
			//$this->db->order_by('generic_item.generic_name', 'ASC'); old
			$this->db->order_by('generic_item.generic_item_id', 'ASC');
		}

		$query = $this->db->get();
		return $query->result();
	}
	
	function get_generic_item($generic_item_id)
	{
		$this->db->select('generic_item.generic_item_id, generic_item.drug_type_id, generic_item.item_type_id, generic_item.generic_name,  item_type.item_type, 
			drug_type.drug_type,  generic_item.note, generic_item.side_effect')
			->from('generic_item')
			// ->join('item_form', 'item_form.item_form_id = generic_item.form_id')
			->join('item_type', 'item_type.item_type_id = generic_item.item_type_id')
			->join('drug_type', 'drug_type.drug_type_id = generic_item.drug_type_id', 'left');
			$this->db->where('generic_item.generic_item_id', $generic_item_id);

		$query = $this->db->get();
		return $query->result();
	}
	function get_data($type=""){
		if($type=="drug_type")
		$this->db->select("drug_type_id,drug_type,description")->from("drug_type")->order_by('drug_type', 'ASC');
		else if($type=="item_type")
		$this->db->select("item_type_id,item_type")->from("item_type")->order_by('item_type', 'ASC');
		else if($type=="item_form")
		$this->db->select("item_form_id, item_form")->from("item_form")->order_by('item_form', 'ASC');
		$query=$this->db->get();
		return $query->result();
		
	}		//end of get_data method

	function check_if_exists($type="", $id){
		if($type=="drug_type")
			$this->db->select("drug_type_id")->from("drug_type")->where('drug_type_id', $id);
		else if($type=="item_type")
			$this->db->select("item_type_id")->from("item_type")->where('item_type_id', $id);
		else if($type=="item_form")
			$this->db->select("item_form_id")->from("item_form")->where('item_form_id', $id);
		$query=$this->db->get();
		return $query->result();
		
	}		//end of get_data method
	
}		//end of generic_model class