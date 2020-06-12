<?php
class Hospital_unit_model extends CI_Model{

    function __construct() {																	//constructor function
        parent::__construct();																	//Parent __construct function						
    }
																								//Function to add_unit
    function add_unit(){
																								//storing fields data into data array
        $data=array();
        if($this->input->post('unit_name')){
            $data['unit_name'] = $this->input->post('unit_name');
        }
        if($this->input->post('department_id')){
           $data['department_id'] = $this->input->post('department_id');
        }
         if($this->input->post('beds')){
            $data['beds'] = $this->input->post('beds');
        }
         if($this->input->post('lab_report_staff_id')){
            $data['lab_report_staff_id'] = $this->input->post('lab_report_staff_id');
        }
        if($this->input->post('unit_head_staff_id')){
            $data['unit_head_staff_id'] = $this->input->post('unit_head_staff_id');
        }
																								//Inserting retrieving data into database
        $this->db->trans_start();
																								//Inserting data to 'unit'table
        $this->db->insert('unit', $data);
        $this->db->trans_complete();
																								//Checking the status of inserting data
        if($this->db->trans_status()==FALSE){
                return false;
        }
        else{
                return true; 
        }
   }
   
   function update_unit(){
		//storing fields data into data array
        $data=array();
        
        if($this->input->post('unit_name')){
           $data['unit_name'] = $this->input->post('unit_name');
        }
        if($this->input->post('department_id')){
           $data['department_id'] = $this->input->post('department_id');
        }
         if($this->input->post('beds')){
            $data['beds'] = $this->input->post('beds');
        }
         if($this->input->post('lab_report_staff_id')){
            $data['lab_report_staff_id'] = $this->input->post('lab_report_staff_id');
        }
        if($this->input->post('unit_head_staff_id')){
            $data['unit_head_staff_id'] = $this->input->post('unit_head_staff_id');
        }
        
        $this->db->trans_start();
         $this->db->where('unit_id',$this->input->post('unit_id'));
        $this->db->update('unit', $data);
        echo "updated successfully.";
        $this->db->trans_complete();
        if($this->db->trans_status()==FALSE){
                return false;
        }
        else{
                return true;
        } 
	}
	function get_unit(){
		if($this->input->post('unit_id')){		                                                                    
			$this->db->where('unit_id',$this->input->post('unit_id'));
		}
		if($this->input->post('unit_name')){		                                                                    
			$this->db->where('unit_name',$this->input->post('unit_name'));
		}
		if($this->input->post('department_id')){		                                                                    
			$this->db->where('department_id',$this->input->post('department_id'));
		}
		if($this->input->post('beds')){		                                                                    
			$this->db->where('beds',$this->input->post('beds'));
		}
		if($this->input->post('lab_report_staff_id')){		                                                                    
			$this->db->where('lab_report_staff_id',$this->input->post('lab_report_staff_id'));
		}
		if($this->input->post('unit_head_staff_id')){		                                                                    
			$this->db->where('unit_head_staff_id',$this->input->post('unit_head_staff_id'));
		}
       
        $this->db->select('unit.*')
          ->from('unit');                              
       $query = $this->db->get();
       $result = $query->result();
       if($result){
        return $result;       
       }else{
           return false;
       }     
    }	
   }
   
