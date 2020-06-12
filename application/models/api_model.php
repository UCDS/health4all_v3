<?php
class api_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function get_data_aushadi($patient_id){
        //$this->db->select("*")->from("api_updates")->where('api_name','aushadi');
        //$query=$this->db->get();
        //$result = $query->row();
        if($patient_id!=0){
        $this->db->select('visit_id "Visit ID", patient_visit.patient_id "Patient ID", visit_type "Visit Type", first_name "First Name",
        last_name "Last Name",
        IF(age_years < 12, IF(gender="M", "Male Child", "Female Child") , IF(gender="M", "Male", "Female") ) as "Gender",
        father_name "Father Name", mother_name "Mother Name", spouse_name "Spouse Name",
        (CASE WHEN dob != 0 THEN dob ELSE DATE_SUB(DATE_SUB(DATE_SUB(admit_date,INTERVAL age_years YEAR), INTERVAL age_months MONTH), INTERVAL age_days DAY) END) as "DOB",
        address "Address", district_id "District ID"',false)
        ->from('patient_visit')->join('patient','patient_visit.patient_id = patient.patient_id')->join('hospital','patient_visit.hospital_id = hospital.hospital_id')
        ->where('hospital.type6','VVP')
        ->where('hospital.state','Telangana')
        ->where('patient_visit.patient_id',$patient_id)
        ->order_by('visit_id','desc')
        ->limit('1');
        $query = $this->db->get();
        $result = $query->row();
        // $count = count($result)-1;
        // if($count!=-1){
        // $last_retrieved_id = $result[$count]->{"Visit ID"};
        // $this->db->trans_start();
        // $this->db->where('api_name','aushadi');
        // $this->db->update('api_updates',array('last_updated_id'=>$last_retrieved_id));
    		$this->db->trans_complete();
    		if($this->db->trans_status()===FALSE){
    				$this->db->trans_rollback();
    				return false;
    		}
        else return $result;
        }
        else return false;
    }
}
