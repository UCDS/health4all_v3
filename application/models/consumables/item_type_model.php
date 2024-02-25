<?php
class Item_type_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }	

	//This function is used to insert item_type data into item_type table.
	function check_item_type($item_type) 
    {
        $this->db->where('item_type', $item_type);
        $query = $this->db->get('item_type');
        return $query->num_rows() > 0;
    }

    function insert_item_type($data) 
    {
        $this->db->insert('item_type', $data);
    }

	function get_all_item_type()
    {
		$this->db->select("item_type.item_type,item_type.item_type_id,item_type.created_date_time,staff.first_name,
		updated_by.first_name as updated_by_name,item_type.updated_date_time")
		->from("item_type")
		->join('staff','staff.staff_id=item_type.created_by','left')
		->join('staff as updated_by','updated_by.staff_id=item_type.updated_by','left');
		$query = $this->db->get();
		return $query->result();
    }
	function get_all_item_type_count()
	{
		$this->db->select("count(*) as count",false)
		->from("item_type");
		$query = $this->db->get();
		return $query->result();
	}
	function get_edit_item_type_id($record_id) 
	{
		$this->db->select('item_type,created_by,updated_by,created_date_time,updated_date_time,item_type_id');
        $query = $this->db->get_where('item_type', array('item_type_id' => $record_id));
        return $query->row_array();
    }

	function update_item_type($record_id, $data) {
        $this->db->where('item_type_id', $record_id);
        $this->db->update('item_type', $data);
    }

}				