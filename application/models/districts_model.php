<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of districts_model
 *
 * @author gokul
 */
class Districts_Model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    function get_districts(){
       $this->db->select('*')
                ->from('district');                      
       $query = $this->db->get();
       $result = $query->result();
       if($result){
        return $result;       
       }else{
           return false;
       }
    }
}
