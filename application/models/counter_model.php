<?php

class counter_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    function get_counters($counter_name='0'){
        if($counter_name != '0'){
            $this->db->where('counter_name', $counter_name);
        }
        $this->db->select('*')
                ->from('counter');
        $query = $this->db->get();      
        $result = $query->result();
        
        return $result;
    }
}
