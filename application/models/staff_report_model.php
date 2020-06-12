<?php

/**
 * Description of staff_report
 * Captures Staff Activity --> How many records each employee input.
 * get_patient_records  --> Count the number of patients registered by each employee.
 * @author Gokul -- 28 Jan 17.
 */
class Staff_Report_Model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    
    // Patient records counters start.
    
    /* get_patient_records  --> Count the number of patients registered by each employee.
    // filters --> from_date, to_date, visit_type(OP/IP)
    // @author Gokul -- 28 Jan 17.
    */
    function get_patient_records(){
		$hospital=$this->session->userdata('hospital');
		$this->db->where('patient_visit.hospital_id',$hospital['hospital_id']);
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        
        $visit_type = $this->input->post('visit_type');
        
        if(!$to_date){
            $to_date = date("Y-m-d");
        }else{
            $to_date = date("Y-m-d",strtotime($this->input->post('to_date')));
        }
        
        if(!$from_date){
            $from_date = date("Y-m-d");
        }else{
            $from_date = date("Y-m-d",strtotime($this->input->post('from_date')));
        }
        
        if($visit_type){
            $this->db->where('patient_visit.visit_type', $visit_type);
        }
       
        $empty_space = " ";
        $this->db->select("staff.designation, staff.first_name,  staff.last_name, "
            . " COUNT(*) as patient_records")
            ->from('user')
            ->join('staff','user.staff_id = staff.staff_id', 'left')
            ->join('patient_visit','user.user_id = patient_visit.insert_by_user_id', 'left')
            ->where("DATE(insert_datetime) BETWEEN '$from_date' AND '$to_date'")
            ->group_by('patient_visit.insert_by_user_id');
        $response = $this->db->get();
      
        $result = $response->result();
        
        return $result;
    }

    function get_doctor_activity(){
		$hospital=$this->session->userdata('hospital');
		$this->db->where('patient_visit.hospital_id',$hospital['hospital_id']);
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        
        $visit_type = $this->input->post('visit_type');
        
        if(!$to_date){
            $to_date = date("Y-m-d");
        }else{
            $to_date = date("Y-m-d",strtotime($this->input->post('to_date')));
        }
        
        if(!$from_date){
            $from_date = date("Y-m-d");
        }else{
            $from_date = date("Y-m-d",strtotime($this->input->post('from_date')));
        }
        
        if($visit_type){
            $this->db->where('patient_visit.visit_type', $visit_type);
        }
       
        $empty_space = " ";
        $this->db->select("staff.designation, staff.first_name, staff.specialisation, staff.phone, department.department, hospital.*, staff.last_name, COUNT(*) as patient_records")
            ->from('patient_visit')
            ->join('staff','staff.staff_id = patient_visit.signed_consultation', 'left')
            ->join('department','department.department_id = staff.department_id', 'left')
            ->join('hospital','patient_visit.hospital_id = hospital.hospital_id', 'left')
            ->where("admit_date BETWEEN '$from_date' AND '$to_date'")
            ->order_by("hospital.state, hospital.hospital, department.department, staff.first_name", "asc")
            ->group_by('patient_visit.hospital_id, patient_visit.signed_consultation');
        $response = $this->db->get();
        $result = $response->result();
        
        return $result;
    }

    function get_doctor_activity_by_institution(){
		$hospital=$this->session->userdata('hospital');
		//$this->db->where('patient_visit.hospital_id',$hospital['hospital_id']);
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        
        $visit_type = $this->input->post('visit_type');
        
        if(!$to_date){
            $to_date = date("Y-m-d");
        }else{
            $to_date = date("Y-m-d",strtotime($this->input->post('to_date')));
        }
        
        if(!$from_date){
            $from_date = date("Y-m-d");
        }else{
            $from_date = date("Y-m-d",strtotime($this->input->post('from_date')));
        }
        
        if($visit_type){
            if($visit_type!='ALL')
                $this->db->where('patient_visit.visit_type', $visit_type);
        } else {
            $this->db->where('patient_visit.visit_type', 'OP');
        }
       
        $empty_space = " ";
        $this->db->select("staff.designation, staff.first_name, staff.specialisation, staff.phone, department.department, hospital.*, staff.last_name, COUNT(*) as patient_records")
            ->from('patient_visit')
            ->join('staff','staff.staff_id = patient_visit.signed_consultation', 'left')
            ->join('department','department.department_id = staff.department_id', 'left')
            ->join('hospital','patient_visit.hospital_id = hospital.hospital_id', 'left')
            ->where("admit_date BETWEEN '$from_date' AND '$to_date'")
            ->order_by("hospital.state, hospital.hospital, department.department, staff.first_name", "asc")
            ->group_by('patient_visit.hospital_id, patient_visit.signed_consultation');
        $response = $this->db->get();

        $result = $response->result();
        
        return $result;
    }
    
    function get_lab_records(){
		$hospital=$this->session->userdata('hospital');
		$this->db->where('patient_visit.hospital_id',$hospital['hospital_id']);
        $from_date = $this->input->post('from_date');
        $to_date = $this->input->post('to_date');
        
        $test_area_id = $this->input->post('test_area_id');
        $test_method_id = $this->input->post('test_method_id');
        $activity_name = $this->input->post('activity_name'); 
        
        if(!$to_date){
            $to_date = date("Y-m-d");
        }else{
            $to_date = date("Y-m-d",strtotime($this->input->post('to_date')));
        }
        
        if(!$from_date){
            $from_date = date("Y-m-d");
        }else{
            $from_date = date("Y-m-d",strtotime($this->input->post('from_date')));
        }
        
        if($test_area_id){
            $this->db->where('test_order.test_area_id', $test_area_id);
        }
        
        if($test_method_id){
            $this->db->where('test.test_master_id',$test_method_id); 
        }
        
        if($activity_name == 'updated'){
            $this->db->where('test.test_status >= 1')
                ->join('test', 'test.test_done_by = user.user_id', 'left')
                ->group_by('test.test_done_by');
        }else{
            $this->db->where('test.test_status = 2')
                ->join('test', 'test.test_approved_by = user.user_id', 'left')
                ->group_by('test.test_approved_by');
        }
        
        $this->db->select("staff.designation, staff.first_name,  staff.last_name, count(*) as lab_records,"
            . "SUM(CASE WHEN test.test_date_time > 0 THEN TIMESTAMPDIFF( MINUTE, test_order.order_date_time, test.test_date_time ) ELSE 0 END) total_time_minutes")
            ->from("user")
            ->join('staff','user.staff_id = staff.staff_id', 'left')            
            ->join('test_order','test_order.order_id = test.order_id')
            ->where("DATE(order_date_time) BETWEEN '$from_date' AND '$to_date'")
            ->where('test.test_master_id != 0');                                    // Test master id is zero for group test. We are counting only individual tests.
        $response = $this->db->get();
        
        $result = $response->result();
       
        return $result;
    }
    
    // Patient record counters end.
}
