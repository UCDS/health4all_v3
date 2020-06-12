<?php
class staff_masters_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    function get_staff_roles(){
       $this->db->select('*')
                ->from('staff_role');                      
       $query = $this->db->get();
       $result = $query->result();
       if($result){
        return $result;       
       }else{
           return false;
       }
    }
}
