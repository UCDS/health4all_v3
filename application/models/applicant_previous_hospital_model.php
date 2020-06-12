<?php


class Applicant_Previous_Hospital_Model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    function get_hospitals(){
       $this->db->select('*')
                ->from('staff_previous_hospital')
               ->order_by('hospital_name','asc');                      
       $query = $this->db->get();
       $result = $query->result();
       if($result){
        return $result;       
       }else{
           return false;
       }
    }
    
    function add_applicant_previous_hospital(){
        $applicant_hospital_data = array();
        if($this->input->post('hospital_name')){
            $applicant_hospital_data['hospital_name'] = $this->input->post('hospital_name');
        }
        if($this->input->post('address')){
            $applicant_hospital_data['address'] = $this->input->post('address');
        }
        if($this->input->post('district_id')){
            $applicant_hospital_data['district_id'] = $this->input->post('district_id');
        }
        if($this->input->post('public_institution_flag')){
            $applicant_hospital_data['public_institution_flag'] = $this->input->post('public_institution_flag');
        }
        var_dump($applicant_hospital_data);
        $this->db->trans_start();
        $this->db->insert('staff_previous_hospital', $applicant_hospital_data);
        $this->db->trans_complete();
        if($this->db->trans_status()==FALSE){
            return false;
        }
        else{
            return true;
        }
    }
}
