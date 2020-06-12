<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of staff_recruitment_drive_model
 *
 * @author gokul
 */
class Staff_Recruitment_Drive_Model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    function get_drives(){
       $this->db->select('*')
            ->from('staff_recruitment_drive');                      
       $query = $this->db->get();
       $result = $query->result();
       if($result){
        return $result;       
       }else{
           return false;
       }
    }
    
    function add_recruitment_drive(){
        $recruiment_drive_data = array();
        if($this->input->post('name')){
            $recruiment_drive_data['name'] = $this->input->post('name');
        }
        if($this->input->post('place')){
            $recruiment_drive_data['place'] = $this->input->post('place');
        }
        if($this->input->post('start_date')){
            $recruiment_drive_data['start_date'] = date("Y-m-d",strtotime($this->input->post('start_date')));
        }
        $this->db->trans_start();
        $this->db->insert('staff_recruitment_drive', $recruiment_drive_data);
        $this->db->trans_complete();
        if($this->db->trans_status()==FALSE){
                return false;
        }
        else{
                return true;
        }
    }
}
