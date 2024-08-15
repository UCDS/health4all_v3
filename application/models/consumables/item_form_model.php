<?php
class Item_form_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }			//end of constructor.

	function check_item_form($item_form) 
    {
        $this->db->where('item_form', $item_form);
        $query = $this->db->get('item_form');
        return $query->num_rows() > 0;
    }

    function add_item_form($data) 
    {
        $this->db->insert('item_form', $data);
    }

	function get_all_item_form($default_rowsperpage)
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

		$this->db->select("item_form.item_form,item_form.item_form_id,item_form.created_date_time,staff.first_name,
		updated_by.first_name as updated_by_name,item_form.updated_date_time")
		->from("item_form")
		->join('staff','staff.staff_id=item_form.created_by','left')
		->join('staff as updated_by','updated_by.staff_id=item_form.updated_by','left');
        $this->db->limit($rows_per_page,$start);
		$query = $this->db->get();
		return $query->result();
    }
	function get_all_item_form_count()
	{
		$this->db->select("count(*) as count",false)
		->from("item_form");
		$query = $this->db->get();
		return $query->result();
	}
	function get_edit_item_form_id($record_id) 
	{
		$this->db->select('item_form,created_by,updated_by,created_date_time,updated_date_time,item_form_id');
        $query = $this->db->get_where('item_form', array('item_form_id' => $record_id));
        return $query->row_array();
    }

	function update_item_form($record_id, $data) {
        $this->db->where('item_form_id', $record_id);
        $this->db->update('item_form', $data);
    }
}				