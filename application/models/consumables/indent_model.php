<?php
class Indent_model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
	} //end of constructor.
	//this method is used to insert data into indent and indent item tables and return post values into array which is in controller.

	function get_indent_info($indent_id, $type = "")
	{
		$hospital = $this->session->userdata('hospital'); //function definition with name :get_data
		$this->db->select('indent.indent_id, indent.hospital_id')->from('indent')->where('indent.indent_id', $indent_id);
		$query = $this->db->get();
		$res = $query->row();
		return $res;

	}

	function add_indent()
	{
		$hospital = $this->session->userdata('hospital');
		$user_data = $this->session->userdata('logged_in');
		$this->db->select('staff_id')->from('user')
			->where('user.user_id', $user_data['user_id']);
		$query = $this->db->get();
		$staff = $query->row();

		$call_date = date("Y-m-d H:i:s");
		$input_indent_date = $this->input->post('indent_date');
		$input_indent_time = $this->input->post('indent_time');
		$final_indent_datetime = $call_date;
		if ($input_indent_date && $input_indent_time) {
			//https://stackoverflow.com/questions/19375184/merge-date-time
			$final_indent_datetime = date("Y-m-d H:i:s", strtotime("$input_indent_date $input_indent_time"));

		}
		if (strtotime($final_indent_datetime) > strtotime($call_date)) {
			$final_indent_datetime = $call_date;
		}
		// log_message("info", "SAIRAM FROM ADD INDENT " . $final_indent_datetime);
		$order = array();

		if ($this->input->post('from_id')) {
			$order['from_id'] = $this->input->post('from_id');
		}
		if ($this->input->post('to_id')) {
			$order['to_id'] = $this->input->post('to_id');
		}
		$auto_indent = $this->input->post('auto_indent');
		log_message("info", "SAIRAM inside indent model " . $this->input->post(NULL, TRUE));
		if ($auto_indent) {
			$order['indent_status'] = 'Issued';
			$order['hospital_id'] = $hospital['hospital_id'];
			$order['orderby_id'] = $staff->staff_id;
			$order['approver_id'] = $staff->staff_id;
			$order['issuer_id'] = $staff->staff_id;
			$order['indent_date'] = $final_indent_datetime;
			$order['approve_date_time'] = $final_indent_datetime;
			$order['issue_date_time'] = $final_indent_datetime;
		} else {
			$order['indent_date'] = $final_indent_datetime;
			$order['indent_status'] = 'Indented';
			$order['hospital_id'] = $hospital['hospital_id'];
			$order['orderby_id'] = $staff->staff_id;

		}
		$order['insert_user_id'] = $order['update_user_id'] = $staff->staff_id;
		// $current_datetime = date("Y-m-d H:i:s");
		$order['insert_datetime'] = $order['update_datetime'] = $call_date;
		$order['note'] = $this->input->post('indent_note') ? $this->input->post('indent_note') : "";
		$this->db->trans_start();
		$this->db->insert('indent', $order);
		$indent_id = $this->db->insert_id();

		$get_item = array();
		$item = $this->input->post('item');
		$data_inventory_in = array();
		$data_inventory_out = array();
		$quantity_indented = $this->input->post('quantity_indented');
		$item_notes = $this->input->post('item_note');
		$row_count = count($item);
		log_message("info", "SAIRAM :=> " . json_encode($this->input->post(NULL, TRUE)));
		for ($i = 0; $i < $row_count; $i++) {
			if ($auto_indent) {
				$get_item[] = array(
					'item_id' => $item[$i],
					'quantity_indented' => $quantity_indented[$i],
					'quantity_approved' => $quantity_indented[$i],
					'quantity_issued' => $quantity_indented[$i],
					'indent_status' => 'Issued',
					'indent_id' => $indent_id,
					'hospital_id' => $hospital['hospital_id'],
					'issue_date' => $final_indent_datetime,
					'note' => $item_notes[$i]

				);
				$quantities = $this->input->post("quantity_" . $item[$i]);
				$mfg_dates = $this->input->post("mfg_date_" . $item[$i]);
				$exp_dates = $this->input->post('exp_date_' . $item[$i]);
				$batch_ids = $this->input->post('batch_' . $item[$i]);
				$patient_ids = $this->input->post('patient_id_' . $item[$i]);
				$costs = $this->input->post('cost_' . $item[$i]);
				$notes = $this->input->post('note_' . $item[$i]);
				$gtins = $this->input->post('gtin_' . $item[$i]);

				for ($j = 0; $j < count($this->input->post("quantity_" . $item[$i])); $j++) {
					array_push($data_inventory_in, array(
						'inward_outward' => 'inward',
						'supply_chain_party_id' => $this->input->post('from_id'),
						'item_id' => $item[$i],
						'quantity' => $quantities[$j],
						'date_time' => $final_indent_datetime,
						'inward_outward_type' => '',
						'manufacture_date' => date("Y-m-d H:i:s", strtotime($mfg_dates[$j])),
						'expiry_date' => date("Y-m-d H:i:s", strtotime($exp_dates[$j])),
						'batch' => $batch_ids[$j],
						'cost' => $costs[$j],
						'patient_id' => $patient_ids[$j],
						'indent_id' => $indent_id,
						'gtin_code' => $gtins[$j],
						'note' => $notes[$j]

					)
					);
					array_push($data_inventory_out, array(
						'inward_outward' => 'outward',
						'supply_chain_party_id' => $this->input->post('to_id'),
						'item_id' => $item[$i],
						'quantity' => $quantities[$j],
						'date_time' => $final_indent_datetime,
						'inward_outward_type' => '',
						'manufacture_date' => date("Y-m-d H:i:s", strtotime($mfg_dates[$j])),
						'expiry_date' => date("Y-m-d H:i:s", strtotime($exp_dates[$j])),
						'batch' => $batch_ids[$j],
						'cost' => $costs[$j],
						'patient_id' => $patient_ids[$j],
						'indent_id' => $indent_id,
						'gtin_code' => $gtins[$j],
						'note' => $notes[$j]

					)
					);
				}

			} else {
				$get_item[] = array(
					'item_id' => $item[$i],
					'quantity_indented' => $quantity_indented[$i],
					'indent_status' => 'Indented',
					'indent_id' => $indent_id,
					'hospital_id' => $hospital['hospital_id'],
					'note' => $item_notes[$i]
				);
			}
		}
		if ($auto_indent) {
			log_message("info", "SAIRAM " . json_encode($data_inventory_in));
			log_message("info", "SAIRAM " . json_encode($data_inventory_out));
			$this->db->insert_batch('inventory', $data_inventory_in);
			$this->db->insert_batch('inventory', $data_inventory_out);
		}
		$this->db->insert_batch('indent_item', $get_item);
		$this->db->trans_complete();
		if ($this->db->trans_status() == FALSE) {
			$this->db->trans_rollback();
			return false;
		} else {
			$this->db->select('hospital.hospital,dosage.dosage,dosage.dosage_unit,item_form.item_form,item_type.item_type,indent.indent_id,indent.indent_status,indent_date,item_name,quantity_indented,from_party.supply_chain_party_name from_party_name,to_party.supply_chain_party_name to_party_name,staff.first_name,staff.last_name,indent_item.note, indent.note indent_note')
				->from('indent')
				->join('indent_item', 'indent.indent_id=indent_item.indent_id', 'left')
				->join('item', 'item.item_id=indent_item.item_id', 'left')
				->join('item_form', 'item_form.item_form_id=item.item_form_id', 'left')
				->join('dosage', 'dosage.dosage_id=item.dosage_id', 'left')
				->join('generic_item', 'item.generic_item_id=generic_item.generic_item_id', 'left')
				->join('item_type', 'generic_item.item_type_id=item_type.item_type_id', 'left')
				->join('supply_chain_party to_party', 'indent.to_id = to_party.supply_chain_party_id', 'left')
				->join('supply_chain_party from_party', 'indent.from_id = from_party.supply_chain_party_id', 'left')
				->join('hospital', 'hospital.hospital_id=indent.hospital_id', 'left')
				->join('staff', 'staff.staff_id=indent.orderby_id', 'left')
				->where('indent.hospital_id', $hospital['hospital_id'])
				->where('indent.indent_id', $indent_id);
			$query = $this->db->get();
			return $query->result();

		}
	}

	function search_items_selectize()
	{
		$this->db->select('item.item_name,item.item_id,item_form.item_form_id,item_form.item_form,item_type.item_type,dosage.dosage,dosage.dosage_unit')
			->from("item")
			->join('item_form', 'item_form.item_form_id=item.item_form_id', 'left')
			->join('generic_item', 'generic_item.generic_item_id=item.generic_item_id', 'left')
			->join('item_type', 'item_type.item_type_id=generic_item.item_type_id', 'left')
			->join('dosage', 'dosage.dosage_id=item.dosage_id', 'left')
			->order_by('item.item_name', 'ASC');
		if($this->input->post('query')){
			$this->db->like('item.item_name', $this->input->post('query'));
		}
		$query = $this->db->get();
		return $query->result();

	}
	//This is a method used to retreive data from supply_chain_party,item tables depend upon type.
	function get_supply_chain_party($type = "", $limit=-1)
	{
		$hospital = $this->session->userdata('hospital');
		if ($type == "party")
			$this->db->select("supply_chain_party_id,supply_chain_party_name")->from("supply_chain_party")
			->where("supply_chain_party.hospital_id ", $hospital['hospital_id'])
			->order_by('supply_chain_party_name', 'ASC');
		else if ($type == "item"){
			$this->db->select('item.item_name,item.item_id,item_form.item_form_id,item_form.item_form,item_type.item_type,dosage.dosage,dosage.dosage_unit')
				->from("item")
				->join('item_form', 'item_form.item_form_id=item.item_form_id', 'left')
				->join('generic_item', 'generic_item.generic_item_id=item.generic_item_id', 'left')
				->join('item_type', 'item_type.item_type_id=generic_item.item_type_id', 'left')
				->join('dosage', 'dosage.dosage_id=item.dosage_id', 'left')
				->order_by('item.item_name', 'ASC');
			
		}

		if($limit != -1){
			$this->db->limit($limit);
		}
		$query = $this->db->get();
		return $query->result();
	}
}