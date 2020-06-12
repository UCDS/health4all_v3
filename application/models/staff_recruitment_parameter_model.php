<?php


class staff_recruitment_parameter_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    function add_parameter(){
        $recruiment_parameter = array();
        if($this->input->post('drive_id')){
            $recruiment_parameter['drive_id'] = $this->input->post('drive_id');
        }
        if($this->input->post('parameter_label')){
            $recruiment_parameter['parameter_label'] = $this->input->post('parameter_label');
        }
        if($this->input->post('parameter_max_value')){
            $recruiment_parameter['parameter_max_value'] = $this->input->post('parameter_max_value');
        }
        if($this->input->post('parameter_rank')){
            $recruiment_parameter['parameter_rank'] = $this->input->post('parameter_rank');
        }
        $this->db->trans_start();
        $this->db->insert('staff_selection_parameter', $recruiment_parameter);
        $this->db->trans_complete();
        if($this->db->trans_status()==FALSE){
                return false;
        }
        else{
                return true;
        }
    }
    
    function get_parameters(){
       if($this->input->post('drive_id')){
            $this->db->where('drive_id', $this->input->post('drive_id'));
       }
       $this->db->select('*')
           ->from('staff_selection_parameter');                      
       $query = $this->db->get();
       $result = $query->result();
       if($result){
            return $result;       
       }else{
           return false;
       }
    }
    
}
