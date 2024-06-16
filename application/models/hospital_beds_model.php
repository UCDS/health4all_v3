<?php
class Hospital_beds_model extends CI_Model 
{                                          
    function __construct() 
    {                                                           
        parent::__construct();                                                         
    }
    
    function check_bed($bed_name) 
    {
        $hospital=$this->session->userdata('hospital');
        $this->db->where('hospital_id',$hospital['hospital_id']);
        $this->db->where('bed', $bed_name);
        $query = $this->db->get('hospital_bed');
        return $query->num_rows() > 0;
    }

    function insert_bed($data) 
    {
        if(!empty($data['bed']))
        {
            $this->db->insert('hospital_bed', $data);
        }
    }

    function get_all_beds($default_rowsperpage)
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

        $hospital=$this->session->userdata('hospital');
		$this->db->select("hospital_bed_id,hospital_id,bed")
		->from("hospital_bed")
        //->where('department.hospital_id',$hospital['hospital_id']);
        ->where('hospital_id',$hospital['hospital_id']);

        $this->db->order_by('hospital_bed_id',"DESC");
        if ($default_rowsperpage !=0)
		{
			$this->db->limit($rows_per_page,$start);
		}

		$query = $this->db->get();
		return $query->result();
    }

	function get_all_beds_count()
	{
        $hospital=$this->session->userdata('hospital');
		$this->db->select("count(*) as count",false)
		->from("hospital_bed")
        //->where('department.hospital_id',$hospital['hospital_id']);
        ->where('hospital_id',$hospital['hospital_id']);

        $this->db->order_by('hospital_bed_id',"DESC");
		$query = $this->db->get();
		return $query->result();
	}

	function get_edit_bed_by_id($record_id) 
	{
		$this->db->select('hospital_bed_id,hospital_id,bed');
        $query = $this->db->get_where('hospital_bed', array('hospital_bed_id' => $record_id));
        return $query->row_array();
    }

    function update_beds($record_id, $data) {
        $this->db->where('hospital_bed_id', $record_id);
        $this->db->update('hospital_bed', $data);
    }

    function get_all_available_beds()
    {
        $hospital=$this->session->userdata('hospital');
		$this->db->select("hb.hospital_bed_id,hb.hospital_id,bed")
		->from("hospital_bed as hb")
		->join("patient_bed as pb", "pb.hospital_bed_id = hb.hospital_bed_id", "left")
        ->where('hb.hospital_id',$hospital['hospital_id'])
        ->where('pb.hospital_bed_id IS NULL'); 
        $this->db->order_by('hb.hospital_bed_id',"DESC");
        $query = $this->db->get();
		return $query->result();
    }

    function insert_allocated_bed($data)
    {
        $this->db->insert('patient_bed', $data);
    }

    function get_all_allocated_beds($default_rowsperpage)
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

        $hospital=$this->session->userdata('hospital');
		$this->db->select("pb.id,pb.patient_id,pb.hospital_bed_id,pb.details,pb.created_time, pb.created_date,pb.reservation_details")
		->from("patient_bed as pb")
		->join("hospital_bed as hb", "hb.hospital_bed_id = pb.hospital_bed_id")
        ->where('hb.hospital_id',$hospital['hospital_id']);
        $this->db->order_by('hb.hospital_bed_id',"ASC");
        if ($default_rowsperpage !=0)
		{
			$this->db->limit($rows_per_page,$start);
		}

		$query = $this->db->get();
		return $query->result();
    }

	function get_all_allocated_beds_count()
	{
        $hospital=$this->session->userdata('hospital');
		$this->db->select("count(*) as count",false)
		->from("patient_bed as pb")
		->join("hospital_bed as hb", "hb.hospital_bed_id = pb.hospital_bed_id")
        ->where('hb.hospital_id',$hospital['hospital_id']);
        $this->db->order_by('hb.hospital_bed_id',"ASC");
		$query = $this->db->get();
		return $query->result();
	}

    function delete_allocated_bed($delete_id)
    {
        $delete_id = $this->input->post('delete_id');
        $this->db->where('id', $delete_id);
        $this->db->delete('patient_bed');
        return $this->db->affected_rows() > 0;
    }

    function fetch_selected_patient_details()
    {
        $patient_id = $this->input->post('patient_id');
        $this->db->select("patient.first_name,patient.last_name,patient.age_years,patient.gender,patient.address,
        patient_followup.diagnosis")
		->from("patient")
		->join("patient_followup", "patient_followup.patient_id= patient.patient_id")
        ->where('patient.patient_id',$patient_id);
        $query = $this->db->get();
		return $query->result();
    }
}

