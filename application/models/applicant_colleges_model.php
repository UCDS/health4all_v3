<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of applicant_colleges_model
 *
 * @author gokul
 */
class Applicant_Colleges_Model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    function get_colleges(){
       $this->db->select('*')
                ->from('staff_applicant_college')
                ->order_by('college_name','asc') ;                      
       $query = $this->db->get();
       $result = $query->result();
       if($result){
        return $result;       
       }else{
           return false;
       }
    }
    
    function get_universities(){
        $this->db->select('*')
                ->from('staff_applicant_college')
                ->where('university_flag','1');                      
       $query = $this->db->get();
       $result = $query->result();
       if($result){
        return $result;       
       }else{
           return false;
       }
    }
    
    function add_applicant_college(){
        $applicant_college_data = array();
        if($this->input->post('college_name')){
            $applicant_college_data['college_name'] = $this->input->post('college_name');
        }
        if($this->input->post('affiliated_to')){
            $applicant_college_data['affiliated_to'] = $this->input->post('affiliated_to');
        }
        if($this->input->post('address')){
            $applicant_college_data['address'] = $this->input->post('address');
        }
        if($this->input->post('district_id')){
            $applicant_college_data['district_id'] = $this->input->post('district_id');
        }
        if($this->input->post('email')){
            $applicant_college_data['email'] = $this->input->post('email');
        }
        if($this->input->post('university_flag')){
            $applicant_college_data['university_flag'] = $this->input->post('university_flag');
        }
        if($this->input->post('public_institution_flag')){
            $applicant_college_data['public_institution_flag'] = $this->input->post('public_institution_flag');
        }
        if($this->input->post('public_institution_flag')){
            $applicant_college_data['public_institution_flag'] = $this->input->post('public_institution_flag');
        }
        $this->db->trans_start();
        $this->db->insert('staff_applicant_college', $applicant_college_data);
        $this->db->trans_complete();
        if($this->db->trans_status()==FALSE){
                return false;
        }
        else{
                return true;
        }
    }
}
