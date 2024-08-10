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

        $this->db->order_by('sequence',"ASC");
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

        $this->db->order_by('sequence',"ASC");
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
        $this->db->order_by('hb.hospital_bed_id',"ASC");
        $query = $this->db->get();
		return $query->result();
    }

    function insert_allocated_bed($data)
    {
       
        $this->db->insert_batch('patient_bed', $data);
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
		$this->db->select("pb.id,pb.patient_id,pb.hospital_bed_id,pb.details,pb.created_time, pb.created_date,pb.reservation_details,hb.bed,
        updated_by.first_name as updated_by_name, MAX(pv.admit_date) as max_admit_date,pb.patient_name,pb.age_gender,pb.address")
		->from("patient_bed as pb")
		->join("hospital_bed as hb", "hb.hospital_bed_id = pb.hospital_bed_id")
        ->join('staff as updated_by','updated_by.staff_id=pb.updated_by','left')
        ->join('patient_visit as pv', 'pv.patient_id = pb.patient_id AND pv.visit_type = "IP"', 'left')
        ->where('hb.hospital_id',$hospital['hospital_id']);
        $this->db->group_by('pb.id');
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
        $this->db->where('hospital_bed_id', $delete_id);
        $this->db->delete('patient_bed');
        
        $this->db->where('hospital_bed_id', $delete_id);
        $this->db->delete('patient_bed_parameter');
        return $this->db->affected_rows() > 0;
    }

    function fetch_selected_patient_details()
    {
        $patient_id = $this->input->post('patient_id');
        $this->db->select("patient.first_name,patient.last_name,patient.age_years,patient.gender,patient.address,
        patient_followup.diagnosis, , MAX(pv.admit_date) as max_admit_date")
		->from("patient")
		->join("patient_followup", "patient_followup.patient_id= patient.patient_id",'left')
        ->join('patient_visit as pv', 'pv.patient_id = patient.patient_id AND pv.visit_type = "IP"', 'left')
        ->where('patient.patient_id',$patient_id);
        $query = $this->db->get();
		return $query->result();
    }

    function delete_bed()
    {
        $bed_id = $this->input->post('bed_id');
        $hospital=$this->session->userdata('hospital');
        $this->db->where('hospital_id', $hospital['hospital_id']);
        $this->db->where('hospital_bed_id', $bed_id);
        $this->db->delete('hospital_bed');
        return $this->db->affected_rows() > 0;
    }

    function delete_bed_parameter_id()
    {
        $bed_id = $this->input->post('bed_parameter_id');
        $hospital=$this->session->userdata('hospital');
        
        $this->db->select('hospital_bed_parameter_id');
        $this->db->from("patient_bed_parameter");
        $this->db->where('hospital_bed_parameter_id', $bed_id);
        $query = $this->db->get()->row();
        if($query)
        {
            $this->db->where('hospital_bed_parameter_id', $bed_id);
            $this->db->delete('patient_bed_parameter');
        }

        $this->db->where('hospital_id', $hospital['hospital_id']);
        $this->db->where('hospital_bed_parameter_id', $bed_id);
        $res = $this->db->delete('hospital_bed_parameter');

        return $this->db->affected_rows() > 0;
    }

    public function edited_bed_parameters($updated_parameters, $bed_id) 
    {
	$this->db->trans_begin();    
        $success = true;
        $user=$this->session->userdata('logged_in'); 
        $data_2 = array(
            'created_date' => date('Y-m-d'),
            'created_time' => date('H:i:s'),
            'updated_by' => $user['staff_id']
        );
        $this->db->where('hospital_bed_id', $bed_id);
        $this->db->update('patient_bed', $data_2);

        if ($this->db->affected_rows() === 0) {
            $success = false;
	
	}

        
        foreach ($updated_parameters as $parameter) 
	{
	    	
	    //echo("<script>console.log('PHP: " . $parameter['bed_parameter_id'] . "');</script>");
            $data_null = array(
                'bed_parameter_value' => NULL
            );
            $this->db->where('id', $parameter['bed_parameter_id']);
	    $this->db->update('patient_bed_parameter', $data_null);
	    //Commenting because $this->db->affected_rows() is returing 0 always
            /*if ($this->db->affected_rows() == 0) {
		$success = false;
                break;
	    }
	    echo("<script>console.log('PHP: " . $parameter['bed_parameter_id'] . "');</script>");*/
            $data = array(
                'bed_parameter_value' => $parameter['bed_parameter_value']
            );
            $this->db->where('id', $parameter['bed_parameter_id']);
	    $this->db->update('patient_bed_parameter', $data);
	    //Commenting because $this->db->affected_rows() is returing 0 always
            /*if ($this->db->affected_rows() == 0) {
                $success = false;
                break;
	    }*/
	}
	if ($success == false){
		$this->db->trans_rollback();
		return $success;
	}
	if ($this->db->trans_status() === FALSE)
	{
		$this->db->trans_rollback();
		return false;
	}
	else
	{
		$this->db->trans_commit();
		return true;
	}
   
    }

    public function bed_params_edit()
    {
        $bed_id = $this->input->post('bed_id');
        $hospital=$this->session->userdata('hospital');
        $this->db->select('pbp.id,pbp.hospital_bed_id,pbp.hospital_bed_parameter_id,pbp.bed_parameter_value,hbp.bed_parameter_label,
        pbed.patient_name,pbed.age_gender,pbed.details,pbed.patient_id');
        $this->db->from('patient_bed_parameter as pbp');
        $this->db->join("patient_bed as pbed", "pbed.hospital_bed_id = pbp.hospital_bed_id");
        $this->db->join("hospital_bed_parameter as hbp", "hbp.hospital_bed_parameter_id = pbp.hospital_bed_parameter_id");
        $this->db->where('pbp.hospital_bed_id', $bed_id);
        $this->db->where('hbp.hospital_id', $hospital['hospital_id']);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_bed_sequence_db($bedId, $newSequence) 
    {
        $this->db->where('hospital_bed_id', $bedId);
        $this->db->update('hospital_bed', array('sequence' => $newSequence));
        return $this->db->affected_rows() > 0;
    }

    public function update_bed_param_sequence_db($hospital_bed_parameter_id, $newSequence) 
    {
        $this->db->where('hospital_bed_parameter_id', $hospital_bed_parameter_id);
        $this->db->update('hospital_bed_parameter', array('sequence' => $newSequence));
        return $this->db->affected_rows() > 0;
    }

    function check_bed_parameter($bed_parameter_label) 
    {
        $hospital=$this->session->userdata('hospital');
        $this->db->where('hospital_id',$hospital['hospital_id']);
        $this->db->where('bed_parameter_label', $bed_parameter_label);
        $query = $this->db->get('hospital_bed_parameter');
        return $query->num_rows() > 0;
    }

    function get_all_bed_parameters($default_rowsperpage)
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
		$this->db->select("bed_parameter_label,hospital_id,hospital_bed_parameter_id,sequence")
		->from("hospital_bed_parameter")
        ->where('hospital_id',$hospital['hospital_id']);
        $this->db->order_by('sequence',"ASC");
        if ($default_rowsperpage !=0)
		{
			$this->db->limit($rows_per_page,$start);
		}

		$query = $this->db->get();
		return $query->result();
    }

	function get_all_bed_parameters_count()
	{
        $hospital=$this->session->userdata('hospital');
		$this->db->select("count(*) as count",false)
		->from("hospital_bed_parameter")
        ->where('hospital_id',$hospital['hospital_id']);
        $this->db->order_by('sequence',"ASC");
		$query = $this->db->get();
		return $query->result();
	}

    function get_edit_bed_parameters($record_id) 
	{
		$this->db->select('bed_parameter_label,hospital_id,hospital_bed_parameter_id');
        $query = $this->db->get_where('hospital_bed_parameter', array('hospital_bed_parameter_id' => $record_id));
        return $query->row_array();
    }

    function insert_bed_parameter($data) 
    {
        if(!empty($data['bed_parameter_label']))
        {
            $this->db->insert('hospital_bed_parameter', $data);
        }
    }

    function update_bed_parameter($record_id, $data) {
        $this->db->where('hospital_bed_parameter_id', $record_id);
        $this->db->update('hospital_bed_parameter', $data);
    }

    function get_all_avnall_beds()
    {
        $this->db->select("pb.id,pb.patient_id, pb.hospital_bed_id, pb.details,pb.reservation_details, pb.created_date, pb.created_time,
        hba.bed,pb.patient_name,pb.age_gender,pb.address,hba.sequence,pt.priority_type_id,pt.color_code,pf.priority_type_id as followup_priority_type")
         ->from("patient_bed as pb")
         ->join("hospital_bed as hba", "hba.hospital_bed_id= pb.hospital_bed_id")
         ->join("patient_followup as pf", "pf.patient_id= pb.patient_id",'left')
         ->join("priority_type as pt", "pt.priority_type_id= pf.priority_type_id",'left')
         ->order_by('hba.sequence', "ASC");
        $query = $this->db->get();
        $patient_beds = $query->result();

        $hospital = $this->session->userdata('hospital');
        $this->db->select("hb.hospital_bed_id, hb.hospital_id, hb.bed,hb.sequence")
                ->from("hospital_bed as hb")
                ->where('hb.hospital_id', $hospital['hospital_id']);
            $this->db->order_by('hb.sequence', "ASC");
            $query = $this->db->get();
            $available_beds = $query->result();
        
        return array('patient_beds' => $patient_beds, 'available_beds' => $available_beds);
    }

    function save_patient_bed_parameter($data) 
    {
        $this->db->insert_batch('patient_bed_parameter', $data);
    }

    function fetch_selected_bed_parameters()
    {
        $bedId = $this->input->post('bedId');
        $this->db->select("pbp.id, pbp.hospital_bed_id, pbp.hospital_bed_parameter_id, pbp.bed_parameter_value, hbp.bed_parameter_label")
		->from("patient_bed_parameter as pbp")
        ->join("hospital_bed_parameter as hbp", "hbp.hospital_bed_parameter_id = pbp.hospital_bed_parameter_id", "left")
        ->where('hospital_bed_id',$bedId);
        $query = $this->db->get();
		return $query->result();
    }

    function combined_tabluar_view()
    {
            $hospital = $this->session->userdata('hospital');
            $this->db->select("pb.id, pb.patient_id, pb.hospital_bed_id, pb.details, pb.reservation_details,
                   pb.created_date, pb.created_time, hba.bed, pb.patient_name, pb.age_gender, pb.address,
                    updated_by.first_name as updated_by_name,hba.hospital_bed_id,hba.sequence")
                    ->from("patient_bed as pb")
                    ->join('hospital_bed as hba', 'hba.hospital_bed_id = pb.hospital_bed_id','left')
                    ->join('staff as updated_by', 'updated_by.staff_id = pb.updated_by', 'left')
                    ->where('hba.hospital_id', $hospital['hospital_id'])
                    ->order_by('hba.sequence', "ASC");
            $query_patient_beds = $this->db->get();
            $patient_beds = $query_patient_beds->result();
            
            $this->db->select("hb.hospital_bed_id, hb.hospital_id, hb.bed,hb.sequence")
                    ->from("hospital_bed as hb")
                    ->where('hb.hospital_id', $hospital['hospital_id']);
                    $this->db->order_by('hb.sequence', "ASC");
            $query_available_beds = $this->db->get();
            $available_beds = $query_available_beds->result();

            $this->db->select("pbp.hospital_bed_id, pbp.bed_parameter_value, pbp.hospital_bed_parameter_id,hbp.bed_parameter_label")
                    ->from("patient_bed_parameter as pbp")
                    ->join('hospital_bed_parameter as hbp', 'hbp.hospital_bed_parameter_id = pbp.hospital_bed_parameter_id', 'left')
                    ->where('hbp.hospital_id', $hospital['hospital_id']);
            $hospital_bed_parameter = $this->db->get();
            $bed_parameters = $hospital_bed_parameter->result();

            return array('patient_beds' => $patient_beds, 'available_beds' => $available_beds, 'bed_parameters' => $bed_parameters);
    }
    
}

