<?php
class Hospital_areas_model extends CI_Model 
{                                          
    function __construct() 
    {                                                           
        parent::__construct();                                                         
    }
    
    function check_area($area_name,$department_id) 
    {
        $this->db->where('area_name', $area_name);
        $this->db->where('department_id', $department_id);
        $query = $this->db->get('area');
        return $query->num_rows() > 0;
    }

    function check_area_name($area_name) 
    {
        $this->db->where('area_name', $area_name);
        $query = $this->db->get('area');
        return $query->num_rows() > 0;
    }

    function insert_area($data) 
    {
        if(!empty($data['area_name']) || !empty($data['department_id']) || !empty($data['beds']) || !empty($data['area_type_id']) || !empty($data['lab_report_staff_id']) )
        {
            $this->db->insert('area', $data);
        }
    }

    function get_all_areas($default_rowsperpage)
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
		$this->db->select("area.area_id,area.area_name,area.department_id,area.beds,area.area_type_id,area.lab_report_staff_id,
        department.department as dname,area_types.area_type as atype,staff.first_name")
		->from("area")
        ->join('department','area.department_id=department.department_id','left')
        ->join('area_types','area.area_type_id=area_types.area_type_id','left')
        ->join('staff','area.lab_report_staff_id=staff.staff_id','left')
        ->where('department.hospital_id',$hospital['hospital_id']);

        $this->db->order_by('area.area_id',"DESC");
        if ($default_rowsperpage !=0)
		{
			$this->db->limit($rows_per_page,$start);
		}

		$query = $this->db->get();
		return $query->result();
    }
	function get_all_areas_count()
	{
        $hospital=$this->session->userdata('hospital');
		$this->db->select("count(*) as count",false)
		->from("area")
        ->join('department','area.department_id=department.department_id','left')
        ->join('area_types','area.area_type_id=area_types.area_type_id','left')
        ->join('staff','area.lab_report_staff_id=staff.staff_id','left')
        ->where('department.hospital_id',$hospital['hospital_id']);

        $this->db->order_by('area.area_id',"DESC");
		$query = $this->db->get();
		return $query->result();
	}

	function get_edit_edit_area_by_id($record_id) 
	{
		$this->db->select('area_id,area_name,department_id,beds,area_type_id,lab_report_staff_id');
        $query = $this->db->get_where('area', array('area_id' => $record_id));
        return $query->row_array();
    }

    function update_area($record_id, $data) {
        $this->db->where('area_id', $record_id);
        $this->db->update('area', $data);
    }
}

