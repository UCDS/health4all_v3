<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Applicant_Qualifications_Model
 *
 * @author gokul
 */
class Applicant_Qualifications_Model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    function get_qualifications(){
       $this->db->select('*')
                ->from('staff_applicant_qualification_master');                      
       $query = $this->db->get();
       $result = $query->result();
       if($result){
        return $result;       
       }else{
           return false;
       }
    }
    
    function add_applicant_qualifications(){
        $applicant_qualification_data = array();
        
        if($this->input->post('qualification')){
            $applicant_qualification_data['qualification'] = $this->input->post('qualification');
        }
        if($this->input->post('qualification_level_id')){
            $applicant_qualification_data['qualification_level_id'] = $this->input->post('qualification_level_id');
        }
        $this->db->trans_start();
        $this->db->insert('staff_applicant_qualification_master', $applicant_qualification_data);
        $this->db->trans_complete();
        if($this->db->trans_status()==FALSE){
                return false;
        }
        else{
                return true;
        }
    }
}
