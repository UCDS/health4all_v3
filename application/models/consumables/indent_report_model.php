<?php
class Indent_report_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}
	//calling method get indent summary.
	function get_indent_summary()
	{
		$indent = $this->session->userdata('indent');
	    $hospital=$this->session->userdata('hospital');                                                //Storing user data who logged into the hospital into a var:hospital
		if ($this->input->post('from_date') && $this->input->post('to_date')) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));

		} else if ($this->input->post('from_date') || $this->input->post('to_date')) {
			$this->input->post('from_date') ? $from_date = $this->input->post('from_date') : $from_date = $this->input->post('to_date');
			$to_date = $from_date;

		} else {
			$from_date = date("Y-m-d");
			$to_date = $from_date;
		}
		if ($this->input->post('from_id')) {
			$from_party = $this->input->post('from_id');
			$this->db->where('from_party.supply_chain_party_id', $from_party);
		}
		if ($this->input->post('to_id')) {
			$to_party = $this->input->post('to_id');
			$this->db->where('to_party.supply_chain_party_id', $to_party);
		}
		if ($this->input->post('item_type')) {
			$this->db->where('item_type.item_type_id', $this->input->post('item_type'));

		}
		if ($this->input->post('item')) {
			$this->db->where('item.item_id', $this->input->post('item'));

		}

		

		$this->db->select('SUM(indent_item.quantity_indented) total_quantity,SUM(indent_item.quantity_approved) approved,SUM(indent_item.quantity_issued) issued,indent.indent_id,indent.indent_date,item_type.item_type,
		item_type.item_type_id,item.item_id,item.item_name,
		from_party.supply_chain_party_name from_party, to_party.supply_chain_party_name to_party,
		from_party.supply_chain_party_id from_party_id, to_party.supply_chain_party_id to_party_id
		')
			->from('indent')
			->join('indent_item', 'indent.indent_id=indent_item.indent_id', 'left')
			->join('item', 'item.item_id=indent_item.item_id', 'left')
			->join('generic_item', 'item.generic_item_id=generic_item.generic_item_id', 'left')
			->join('item_type', 'generic_item.item_type_id=item_type.item_type_id', 'left')
			->join('supply_chain_party to_party', 'indent.to_id = to_party.supply_chain_party_id', 'left')
			->join('supply_chain_party from_party', 'indent.from_id = from_party.supply_chain_party_id', 'left')
			->group_by('item_type,item_name');
		$this->db->where("(DATE(indent_date) BETWEEN '$from_date' AND '$to_date' )"); //here where condition is for only displaying orders between from_date and to_date
		$this->db->where("indent.hospital_id", $hospital['hospital_id']);
		//$this->db->where('indent.indent_status','Indented');                                             //here it is  for displaying  those orders which has status as indented
		if ($this->input->post('indent_id')) {
			$this->db->where('indent.indent_id', $this->input->post('indent_id'));
		}


		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
		
		if ($result) {
			return $result;
		} else {
			return false;
		}
	} //ending of get indent summary method.




	//calling method get indent detailed by passing parameters.
	function get_indent_detailed($from_date = 0, $to_date = 0, $from_party = 0, $to_party = 0, $indent_status = 0, $item_type = -1, $item_name = -1)
	{
		$indent = $this->session->userdata('indent');
		$hospital=$this->session->userdata('hospital');                                                //Storing user data who logged into the hospital into a var:hospital

		if ($this->input->post('from_date') && $this->input->post('to_date')) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
		} else if ($this->input->post('from_date') || $this->input->post('to_date')) {
			$this->input->post('from_date') ? $from_date = $this->input->post('from_date') : $from_date = $this->input->post('to_date');
			$to_date = $from_date;
		} else if ($from_date == '0' && $to_date == '0') {
			$from_date = date("Y-m-d");
			$to_date = $from_date;
		}
		if (($from_party != '0') || $this->input->post('from_id')) {
			if ($this->input->post('from_id'))
				$from_party = $this->input->post('from_id');
			$this->db->where('from_party.supply_chain_party_id', $from_party);
		}
		if (($to_party != '0') || $this->input->post('to_id')) {
			if ($this->input->post('to_id'))
				$to_party = $this->input->post('to_id');
			$this->db->where('to_party.supply_chain_party_id', $to_party);
		}
		if (($item_type != '-1' && $item_type != '0') || $this->input->post('item_type')) {
			if ($this->input->post('item_type'))
			$item_type = $this->input->post('item_type');
			
			
			$this->db->where('item_type.item_type_id', $item_type);
		}
		log_message("info", "Sairam item name is " . $item_type);
		if (($item_name != '-1' && $item_name != '0') || $this->input->post('item_name')) {
			if ($this->input->post('item_name'))
				$item_name = $this->input->post('item_name');
			$this->db->where('item.item_id', $item_name);
		}
		if (($indent_status != '0') || $this->input->post('indent_status')) {
			if ($this->input->post('indent_status'))
				$indent_status = $this->input->post('indent_status');
			if ($indent_status == "Approved") {
				$this->db->where('indent_item.indent_status', "Approved");
				$this->db->or_where('indent_item.indent_status', "Issued");
			} else if ($indent_status = "Issued")
				$this->db->where('indent_item.indent_status', "Issued");
		}

		$this->db->select('indent.indent_date,indent.indent_id,item_type.item_type,item.item_name,indent_item.quantity_indented,indent_item.quantity_approved,indent_item.quantity_issued,indent_item.indent_status,from_party.supply_chain_party_name from_party,to_party.supply_chain_party_name to_party')
		->from('indent')
			->join('indent_item', 'indent.indent_id=indent_item.indent_id', 'left outer')
			->join('item', 'item.item_id=indent_item.item_id', 'left outer') //This is the select statement which joins all the tables (indent,indent_item,item,generic_item,
			->join('generic_item', 'item.generic_item_id=generic_item.generic_item_id', 'left outer') //item_type,item_form,dosage,supply_chain_party) and getting required field values
			->join('item_type', 'generic_item.item_type_id=item_type.item_type_id', 'left outer')
			//->join('item_form','item.item_form_id=item_form.item_form_id','left')
			//->join('dosage','item.dosage_id=dosage.dosage_id','left')
			->join('supply_chain_party to_party', 'indent.to_id =to_party.supply_chain_party_id ', 'left outer')
			->join('supply_chain_party from_party', 'indent.from_id = from_party.supply_chain_party_id', 'left outer');
		
		$this->db->where("(DATE(indent_date) BETWEEN '$from_date' AND '$to_date' )"); //here where condition is for only displaying orders between from_date and to_date
		$this->db->where('indent.hospital_id', $hospital['hospital_id']);
		if ($this->input->post('indent_id')) {
			$this->db->where('indent.indent_id', $this->input->post('indent_id'));
		}
		log_message('info', "SAIRAM AGAIN Input ".$this->input->post('from_date'));
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();

		if ($result) {
			return $result;
		} else {
			return false;
		}
	} //ending of get indent detailed method.

	function list_indents($from_date = 0, $to_date = 0, $from_party = 0, $to_party = 0, $indent_status = 0)
	{
		$hospital=$this->session->userdata('hospital');                                                //Storing user data who logged into the hospital into a var:hospital

		if ($this->input->post('from_date') && $this->input->post('to_date')) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
		} else if ($this->input->post('from_date') || $this->input->post('to_date')) {
			$this->input->post('from_date') ? $from_date = $this->input->post('from_date') : $from_date = $this->input->post('to_date');
			$to_date = $from_date;
		} else if ($from_date == '0' && $to_date == '0') {
			$from_date = date("Y-m-d");
			$to_date = $from_date;
		}
		if (($from_party != '0') || $this->input->post('from_id')) {
			if ($this->input->post('from_id'))
				$from_party = $this->input->post('from_id');
			$this->db->where('scp_from.supply_chain_party_id', $from_party);
		}
		if (($to_party != '0') || $this->input->post('to_id')) {
			if ($this->input->post('to_id'))
				$to_party = $this->input->post('to_id');
			$this->db->where('scp_to.supply_chain_party_id', $to_party);
		}
		if (($indent_status != '0') || $this->input->post('indent_status')) {
			if ($this->input->post('indent_status'))
				$indent_status = $this->input->post('indent_status');
			if ($indent_status == "Approved") {
				$this->db->where('indent.indent_status', "Approved");
				$this->db->or_where('indent.indent_status', "Issued");
			} else if ($indent_status = "Issued")
				$this->db->where('indent.indent_status', "Issued");
		}


		$this->db->select("indent.indent_id indent_id, indent.hospital_id hospital_id, 
						   indent.from_id from_party_id, indent.to_id to_party_id, 
						   indent.orderby_id ordered_by_id, indent.approver_id approved_by_id, indent.issuer_id issued_by_id,  
						   indent.indent_date indent_datetime, indent.approve_date_time approval_datetime, indent.issue_date_time issue_datetime, 
						   indent.insert_user_id inserted_by_id, indent.update_user_id updated_by_id, 
						   indent.indent_status, 
						   indent.insert_datetime insert_datetime, indent.update_datetime update_datetime, 
						   scp_from.supply_chain_party_name from_party_name, scp_to.supply_chain_party_name to_party_name, 
						   staff_orderer.first_name ordered_by_fname, staff_orderer.last_name ordered_by_lname, 
						   staff_approver.first_name approved_by_fname, staff_approver.last_name approved_by_lname, 
						   staff_issuer.first_name issued_by_fname, staff_issuer.last_name issued_by_lname, 
						   staff_inserted_by.first_name inserted_by_fname, staff_inserted_by.last_name inserted_by_lname, 
						   staff_updated_by.first_name updated_by_fname, staff_updated_by.last_name updated_by_lname");

		$this->db->from('indent')
			->join("supply_chain_party scp_from", "scp_from.supply_chain_party_id = indent.from_id")
			->join("supply_chain_party scp_to", "scp_to.supply_chain_party_id = indent.to_id")
			->join("staff staff_orderer", "staff_orderer.staff_id = indent.orderby_id")
			->join("staff staff_approver", "staff_approver.staff_id = indent.approver_id")
			->join("staff staff_issuer", "staff_issuer.staff_id = indent.issuer_id")
			->join("staff staff_inserted_by", "staff_inserted_by.staff_id = indent.insert_user_id")
			->join("staff staff_updated_by", "staff_updated_by.staff_id = indent.update_user_id");
			
		$this->db->where("(DATE(indent_date) BETWEEN '$from_date' AND '$to_date' )"); //here where condition is for only displaying orders between from_date and to_date
		$this->db->where("indent.hospital_id", $hospital['hospital_id']);
		if ($this->input->post('indent_id')) {
			$this->db->where('indent.indent_id', $this->input->post('indent_id'));
		}
		$query = $this->db->get();
		$query_string = $this->db->last_query();
		log_message('info', $query_string);
		//echo $this->db->last_query();
		return $query->result();
		

	}
	//calling get data method.
	function get_data($type)
	{
		if ($type == "item_type")
			$this->db->select("*")->from("item_type");
		else if ($type == "item")
			$this->db->select('item.item_name,item.item_id,item_type.item_type_id,item_form.item_form_id,item_form.item_form,item_type.item_type,dosage.dosage,dosage.dosage_unit')
				->from("item")
				->join('item_form', 'item_form.item_form_id=item.item_form_id', 'left')
				->join('generic_item', 'generic_item.generic_item_id=item.generic_item_id', 'left')
				->join('item_type', 'item_type.item_type_id=generic_item.item_type_id', 'left')
				->join('dosage', 'dosage.dosage_id=item.dosage_id', 'left');
		else if ($type == "status")
			$this->db->select("indent_status")->from("indent_item");
		else if ($type == "party")
			$this->db->select("supply_chain_party_id,supply_chain_party_name")->from("supply_chain_party");
		$resource = $this->db->get();
		return $resource->result();
	} //ending of get data method.
}