<?php
class area_type_model extends CI_Model {                                               //create a model class with name hospital_areas_model which extends CI_model.
    function __construct() {                                                           //constructor definition.
        parent::__construct();                                                         //calling code igniter (parent) constructor.
    }//constructor
    function get_area_type(){                      
        $this->db->select("area_type_id,area_type",false)->from("area_types");    //select query to select area_type_id and area_type from area_types table.
        $query=$this->db->get();
        return $query->result();
    }//get_area_type
}//area_type_model