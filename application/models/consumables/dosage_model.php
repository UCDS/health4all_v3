<?php

class dosage_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }		//end of constructor. 

	function check_dosage($dosage,$dosage_unit) 
    {
        $this->db->where('dosage', $dosage);
        $this->db->where('dosage_unit', $dosage_unit);
        $query = $this->db->get('dosage');
        return $query->num_rows() > 0;
    }

    function add_dosage($data) 
    {
        $this->db->insert('dosage', $data);
    }

	function get_all_dosage_type()
    {
		$this->db->select("dosage.dosage,dosage.dosage_id,dosage.dosage_unit,dosage.created_date_time,staff.first_name,
		updated_by.first_name as updated_by_name,dosage.updated_date_time")
		->from("dosage")
		->join('staff','staff.staff_id=dosage.created_by','left')
		->join('staff as updated_by','updated_by.staff_id=dosage.updated_by','left');
		$query = $this->db->get();
		return $query->result();
    }
	function get_all_dosage_type_count()
	{
		$this->db->select("count(*) as count",false)
		->from("dosage");
		$query = $this->db->get();
		return $query->result();
	}
	function get_edit_dosage_type_id($record_id) 
	{
		$this->db->select('dosage,dosage_unit,created_by,updated_by,created_date_time,updated_date_time,dosage_id');
        $query = $this->db->get_where('dosage', array('dosage_id' => $record_id));
        return $query->row_array();
    }

	function update_dosage_type($record_id, $data) {
        $this->db->where('dosage_id', $record_id);
        $this->db->update('dosage', $data);
    }

}			//end of dosage model.
