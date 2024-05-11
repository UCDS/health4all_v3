<?php
class Hospital_unit_model extends CI_Model{

    function __construct() {																	
        parent::__construct();																						
    }
																								
	function check_unit_department($unit_name,$department_id) 
    {
        $this->db->where('unit_name', $unit_name);
        $this->db->where('department_id', $department_id);
        $query = $this->db->get('unit');
        return $query->num_rows() > 0;
    }

	function check_unit_name($unit_name) 
    {
        $this->db->where('unit_name', $unit_name);
        $query = $this->db->get('unit');
        return $query->num_rows() > 0;
    }
	
    function add_unit($data) 
    {
        $this->db->insert('unit', $data);
    }

    function get_all_unit_name($default_rowsperpage)
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
		$this->db->select("u.unit_name,u.department_id,u.unit_id,u.beds,u.unit_head_staff_id,u.lab_report_staff_id,
        department.department as dname,staff.first_name as fname")
		->from("unit as u")
		->join('department','u.department_id=department.department_id','left')
		->join('staff','u.lab_report_staff_id=staff.staff_id','left')
		->where('department.hospital_id',$hospital['hospital_id']);

		$this->db->order_by('u.unit_id',"DESC");
		if ($default_rowsperpage !=0)
		{
			$this->db->limit($rows_per_page,$start);
		}
		$query = $this->db->get();
		return $query->result();
    }
	function get_all_unit_name_count()
	{
		$hospital=$this->session->userdata('hospital');
		$this->db->select("count(*) as count",false)
		->from("unit as u")
		->join('department','u.department_id=department.department_id','left')
		->join('staff','u.lab_report_staff_id=staff.staff_id','left')
		->where('department.hospital_id',$hospital['hospital_id']);
		$this->db->order_by('u.unit_id',"DESC");
		$query = $this->db->get();
		return $query->result();
	}

	function get_edit_unit_name_by_id($record_id) 
	{
		$this->db->select('unit_name,department_id,unit_id,beds,unit_head_staff_id,lab_report_staff_id');
        $query = $this->db->get_where('unit', array('unit_id' => $record_id));
        return $query->row_array();
    }

    function update_unit($record_id, $data) {
        $this->db->where('unit_id', $record_id);
        $this->db->update('unit', $data);
    }

	function get_unit(){
		if($this->input->post('unit_id')){		                                                                    
			$this->db->where('unit_id',$this->input->post('unit_id'));
		}
		if($this->input->post('unit_name')){		                                                                    
			$this->db->where('unit_name',$this->input->post('unit_name'));
		}
		if($this->input->post('department_id')){		                                                                    
			$this->db->where('department_id',$this->input->post('department_id'));
		}
		if($this->input->post('beds')){		                                                                    
			$this->db->where('beds',$this->input->post('beds'));
		}
		if($this->input->post('lab_report_staff_id')){		                                                                    
			$this->db->where('lab_report_staff_id',$this->input->post('lab_report_staff_id'));
		}
		if($this->input->post('unit_head_staff_id')){		                                                                    
			$this->db->where('unit_head_staff_id',$this->input->post('unit_head_staff_id'));
		}
       
        $this->db->select('unit.*')
          ->from('unit');                              
       $query = $this->db->get();
       $result = $query->result();
       if($result){
        return $result;       
       }else{
           return false;
       }     
    }	
   }
   
