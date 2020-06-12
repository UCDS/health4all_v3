<?php
class Hospital_areas_model extends CI_Model {                                          
    function __construct() {                                                           
        parent::__construct();                                                         
    }//constructor
     function add_area(){                                                              
        $area=array();                                                                 
        
        if($this->input->post('area_name')){                                           
            $area['area_name'] = $this->input->post('area_name');                      
        }//if
        if($this->input->post('department_id')){                                       
            $area['department_id'] = $this->input->post('department_id');               
        }//if
        if($this->input->post('beds')){                                              
            $area['beds'] = $this->input->post('beds');                                
        }//if
        if($this->input->post('area_type_id')){                                      
            $area['area_type_id'] = $this->input->post('area_type_id');                 
        }//if
        if($this->input->post('lab_report_staff_id')){                               
            $area['lab_report_staff_id'] = $this->input->post('lab_report_staff_id');   
        }//if
          
        $this->db->trans_start();                                                      
        $this->db->insert('area', $area); 
        $this->db->trans_complete();                                                   
        if($this->db->trans_status()==FALSE){                                          
            return false;
        }//if
        else{
            return true;
        }//else
  }//add_area
}//hospital_areas_model

