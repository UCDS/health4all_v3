<?php

class drug_type_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }		
	
    function check_drug_type($drug_type,$description) 
    {
        $this->db->where('drug_type', $drug_type);
        $this->db->where('description', $description);
        $query = $this->db->get('drug_type');
        return $query->num_rows() > 0;
    }

    function add_drug_type($data) 
    {
        $this->db->insert('drug_type', $data);
    }

	function get_all_drug_type($default_rowsperpage)
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

		$this->db->select("drug_type.drug_type,drug_type.drug_type_id,drug_type.created_date_time,staff.first_name,
		updated_by.first_name as updated_by_name,drug_type.updated_date_time,drug_type.description")
		->from("drug_type")
		->join('staff','staff.staff_id=drug_type.created_by','left')
		->join('staff as updated_by','updated_by.staff_id=drug_type.updated_by','left');
        $this->db->limit($rows_per_page,$start);
		$query = $this->db->get();
		return $query->result();
    }
	function get_all_drug_type_count()
	{
		$this->db->select("count(*) as count",false)
		->from("drug_type");
		$query = $this->db->get();
		return $query->result();
	}
	function get_edit_drug_type_id($record_id) 
	{
		$this->db->select('drug_type,description,created_by,updated_by,created_date_time,updated_date_time,drug_type_id');
        $query = $this->db->get_where('drug_type', array('drug_type_id' => $record_id));
        return $query->row_array();
    }

	function update_drug_type($record_id, $data) {
        $this->db->where('drug_type_id', $record_id);
        $this->db->update('drug_type', $data);
    }			
}				