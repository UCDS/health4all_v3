<?php
// Present
// State -> Hospital Type6 -> Hosptial Type3 -> Hospitals
// Type1{Hard coded} NPO -> Hospitals
// District IP/OP{dashboard/district/dmetelangana} restricted to category type
class Dashboard_model extends CI_Model{
	function __construct(){
		parent::__construct();
    }

    function get_organizations_by_type($select_type=FALSE, $filter_type=FALSE, $filter_value=FALSE) {
        if(!($select_type && is_numeric($select_type) && ($select_type > 0) && ($select_type < 7)))
            return false;
        
        $this->db->select('DISTINCT(type'.$select_type.'), LOWER(REPLACE(type'.$select_type.', " ", "_")) query_string', false)
            ->from('hospital');
        if(($select_type && is_numeric($select_type) && ($select_type > 0) && ($select_type < 7))) {
            $this->db->where("type$filter_type", $filter_value);
        }
        
        $query = $this->db->get();
        $hospital_ownerships = $query->result();
        return $hospital_ownerships;
    }

    //Hospital types - 
    //Visit type OP/IP/COP/REPETE
    function get_hos_summary_by_type_by_visit($visit_type=FALSE, $group_by= FALSE, $type1=FALSE, $type2=FALSE, $type3=FALSE, $type4=FALSE, $type5=FALSE, $type6=FALSE) {
        $this->db->select('hospital.*, COUNT(patient_visit.admit_id) patient_visits', false)
            ->from('hospital')
            ->join('patient_visit', 'hospital.hospital_id=patient_visit.hospital_id', 'left');
        if($type1){

            $this->db->where('LOWER(hospital.type1)', strtolower(str_replace("_", " ",$type1)));
        }else if($type2){
            $this->db->where('LOWER(hospital.type2)', strtolower(str_replace("_", " ",$type2)));
        }else if($type3){
            $this->db->where('LOWER(hospital.type3)', strtolower(str_replace("_", " ",$type3)));
        }else if($type4){
            $this->db->where('LOWER(hospital.type4)', strtolower(str_replace("_", " ",$type4)));
        }else if($type5){
            $this->db->where('LOWER(hospital.type5)', strtolower(str_replace("_", " ",$type5)));
        }else if($type6){
            $this->db->where('LOWER(hospital.type6)', strtolower(str_replace("_", " ",$type6)));
        }
        if($this->input->get_post('state_key')){
            $state_key = $this->input->get_post('state_key');
            $this->db->where('LOWER(hospital.state)', strtolower(str_replace("_", " ",$state_key)));
        }
        if($group_by){
            $this->db->group_by("hospital.$group_by");
        } else {
            $this->db->group_by('patient_visit.hospital_id');
        }
            
        if($this->input->get_post('from_date') && $this->input->get_post('to_date')){
            if($this->input->get_post('from_date')){
                $from_date = date("Y-m-d",strtotime($this->input->get_post('from_date')));
                $to_date = date("Y-m-d",strtotime($this->input->get_post('to_date')));
                $this->db->where('(patient_visit.admit_date BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
            }
        }
        else {
            $date = date("Y-m-d");
            $this->db->where("patient_visit.admit_date <=",$date);
            $fromDate = date("Y-m-d");
            $this->db->where('patient_visit.admit_date >=',$fromDate);
        }
        if($visit_type) {
            $this->db->where('patient_visit.visit_type', $visit_type);
        }           
        $this->db->order_by('patient_visits');
        $query = $this->db->get();
       
        $visit_summary = $query->result();
        return $visit_summary;
    }

    function get_hos_summary_by_type_by_patient($visit_type=FALSE, $group_by= FALSE, $type1=FALSE, $type2=FALSE, $type3=FALSE, $type4=FALSE, $type5=FALSE, $type6=FALSE) {
        $this->db->select('hospital.*, COUNT(DISTINCT patient_id) distinct_patient_visits', false)
            ->from('hospital')
            ->join('patient_visit', 'hospital.hospital_id=patient_visit.hospital_id', 'left')
            ->order_by('distinct_patient_visits');
            if($type1){
    
                $this->db->where('LOWER(hospital.type1)', strtolower(str_replace("_", " ",$type1)));
            }else if($type2){
                $this->db->where('LOWER(hospital.type2)', strtolower(str_replace("_", " ",$type2)));
            }else if($type3){
                $this->db->where('LOWER(hospital.type3)', strtolower(str_replace("_", " ",$type3)));
            }else if($type4){
                $this->db->where('LOWER(hospital.type4)', strtolower(str_replace("_", " ",$type4)));
            }else if($type5){
                $this->db->where('LOWER(hospital.type5)', strtolower(str_replace("_", " ",$type5)));
            }else if($type6){
                $this->db->where('LOWER(hospital.type6)', strtolower(str_replace("_", " ",$type6)));
            }
        if($group_by){
            $this->db->group_by("hospital.$group_by");
        } else {
            $this->db->group_by('patient_visit.hospital_id');
        }
        if($this->input->get_post('state_key')){
            $state_key = $this->input->get_post('state_key');
            $this->db->where('LOWER(REPLACE(hospital.state, " ", "_"))=', $state_key);
        }
        if($this->input->get_post('from_date') && $this->input->get_post('to_date')){
            if($this->input->get_post('from_date')){
                $from_date = date("Y-m-d",strtotime($this->input->get_post('from_date')));
                $to_date = date("Y-m-d",strtotime($this->input->get_post('to_date')));
                $this->db->where('(patient_visit.admit_date BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
            }
        }
        else {
            $date = date("Y-m-d");
            $this->db->where("patient_visit.admit_date <=",$date);
            $fromDate = date("Y-m-d");
            $this->db->where('patient_visit.admit_date >=',$fromDate);
        }
        if($visit_type) {
            $this->db->select('COUNT(admit_id) patient_visits')
                ->where('patient_visit.visit_type', $visit_type);
        }           
        $query = $this->db->get();
        $visit_summary = $query->result();

        return $visit_summary;
    }

    function get_distinct_states() {
        $this->db->select('DISTINCT(state), LOWER(REPLACE(state, " ", "_")) as state_key',false)
            ->from('hospital')
            ->where('state != ""');
        
        $query = $this->db->get();
        $distinct_states = $query->result();
        return $distinct_states;
    }
    // state -> district
    // state -> hospital_type
    // hospital_type -> district
    // district -> hosptial_type
    // hosptial_type -> hospitals
    // Start at any category drill down to any other
    // route definition
    // Simple Join
    // {{table names=> field names}, {selection sequence}, where, group_by}
    // Queries
}
