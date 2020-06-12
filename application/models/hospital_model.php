<?php

class Hospital_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    function get_hospitals(){  //Function that returns all the details of the hospitals.
        $filters = array();
        if($this->input->post('hospital_type')){
            $filters['hospital_type'] = $this->input->post('hospital_type');
        }
        $this->db->select('*')
            ->from('hospital_information')
            ->where($filters);
        
        $query = $this->db->get();
        $result = $query->result();
        
        return $result;
    }
    
    function get_hospital_types(){
        $this->db->select('*')
            ->from('hospital_type');
        
        $query = $this->db->get();
        $result = $query->result();
        
        return $result;
    }
    
    function get_hospital_sub_types(){
        $this->db->select('*')
            ->from('hospital_subtypes');
        
        $query = $this->db->get();
        $result = $query->result();
        
        return $result;
    }
    
    function get_ip_op_summary_by_hospital($long_period, $short_period){
        //Set short_period to zero for today.        
        $today = date("Y-m-d");
        $dbdefault = $this->load->database('default',TRUE);
        $hospitals_status = array();
        $this->db->select('hospital_id, host_name,username,database_name,database_password')
        ->from('hospitals');
        $query=$this->db->get();
        $result = $query->result();
        foreach($result as $r){
            $this->db->select('hospital_information.*')
            ->from('hospital_information')               
            ->where('hospital_information.hospital_id',"$r->hospital_id");
            $query2 = $this->db->get();
            
            $current_hospital = $query2->result();
            if(sizeof($current_hospital) == 0){
                continue;
            }
            $current_hospital = $current_hospital[0];
            $config['hostname'] = "$r->host_name";
            $config['username'] = "$r->username";
            $config['password'] = "$r->database_password";
            $config['database'] = "$r->database_name";
            $config['dbdriver'] = 'mysql';
            $config['dbprefix'] = '';
            $config['pconnect'] = TRUE;
            $config['db_debug'] = TRUE;
            $config['cache_on'] = FALSE;
            $config['cachedir'] = '';
            $config['char_set'] = 'utf8';
            $config['dbcollat'] = 'utf8_general_ci';
            $dbt=$this->load->database($config,TRUE);
            $query = $dbt->query("SELECT  total_ip_registrations_long_period, total_op_registrations_long_period,"
                . "total_ip_registrations_short_period, total_op_registrations_short_period,"
                . "'$current_hospital->hospital_id' hospital_id, "
                . "'$current_hospital->hospital_name' hospital_name, '$current_hospital->hospital_short_name' hospital_short_name, '$current_hospital->district' district, '$current_hospital->latitude_n' lattitude, '$current_hospital->longitude_e' longitude FROM (
                SELECT COUNT( * ) total_ip_registrations_long_period
                    FROM  patient_visit
                    WHERE (admit_date = '$today') AND visit_type = 'IP'
                ) AS total_ip_registrations_long_period
                CROSS JOIN (
                SELECT COUNT( * ) total_op_registrations_long_period
                    FROM  patient_visit
                    WHERE (admit_date = '$today') AND visit_type = 'OP'
                ) AS total_op_registrations_long_period
                CROSS JOIN(
                    SELECT COUNT(*) total_ip_registrations_short_period
                    FROM patient_visit
                    WHERE (admit_date = '$today') AND visit_type = 'IP'
                ) AS total_ip_registrations_short_period "  
                . "CROSS JOIN(
                    SELECT COUNT(*) total_op_registrations_short_period
                    FROM patient_visit
                    WHERE (admit_date = '$today') AND visit_type = 'OP'
                ) AS total_op_registrations_short_period");
            
            $hospitals_status[] = $query->row();
        }
        return $hospitals_status;
    }
    
    function add_hospital(){																	//method with name add_hospital
        $get_hospital = array();																//initializing an array with name get_hospital.
        if($this->input->post('hospital')){														//checking whether entered field is hospital or not
            $get_hospital['hospital'] = $this->input->post('hospital');							//if entered field is hospital then it stores the value into array with index hospital.
        }   //if
		 if($this->input->post('place')){														//checking whether entered field is place or not
             $get_hospital['place'] = $this->input->post('place');								//if entered field is place then it stores the value into array with index place.
        } 
        if($this->input->post('hospital_short_name')){											//checking whether entered field is hospital_short_name or not
            $get_hospital['hospital_short_name'] = $this->input->post('hospital_short_name');	//if entered field is hospital_short_name then it stores the value into array with index hospital_short_name.
        }   //if
        
		if($this->input->post('district')){														//checking whether entered field is district or not
             $get_hospital['district'] = $this->input->post('district');						//if entered field is district then it stores the value into array with index district.
        }
		if($this->input->post('state')){														//checking whether entered field is state or not
             $get_hospital['state'] = $this->input->post('state');								//if entered field is state then it stores the value into array with index state.
        }
		
        if($this->input->post('type1')){														//checking whether entered field is type1 or not
             $get_hospital['type1'] = $this->input->post('type1');								//if entered field is type1 then it stores the value into array with index type1.
        }
        if($this->input->post('type2')){														//checking whether entered field is type2 or not
             $get_hospital['type2'] = $this->input->post('type2');								//if entered field is type2 then it stores the value into array with index type2.
        }
        if($this->input->post('type3')){														//checking whether entered field is type3 or not
             $get_hospital['type3'] = $this->input->post('type3');								//if entered field is type3 then it stores the value into array with index type3.
        }
        if($this->input->post('type4')){														//checking whether entered field is type4 or not
             $get_hospital['type4'] = $this->input->post('type4');								//if entered field is type4 then it stores the value into array with index type4.
        }
        if($this->input->post('type5')){														//checking whether entered field is type5 or not
             $get_hospital['type5'] = $this->input->post('type5');								//if entered field is type5 then it stores the value into array with index type5.
        }
        if($this->input->post('type6')){														//checking whether entered field is type6 or not
             $get_hospital['type6'] = $this->input->post('type6');								//if entered field is type6 then it stores the value into array with index type6.
        }
		 if($this->input->post('description')){													//checking whether entered field is description or not
            $get_hospital['description'] = $this->input->post('description');					//if entered field is description then it stores the value into array with index description.
        } 
           $hospital_id='';
           if($this->input->post('hospital_id')){
			   $hospital_id=$this->input->post('hospital_id');
		   }
       
		$this->db->trans_start();
		$this->db->insert('hospital',$get_hospital);	
        $this->db->trans_complete();
        if($this->db->trans_status()==FALSE){
		return false;
		}
        else{
           return true;
        }       
    }
	 function udpate_hospital(){																	//method with name add_hospital
        $get_hospital = array();																//initializing an array with name get_hospital.
        if($this->input->post('hospital')){														//checking whether entered field is hospital or not
            $get_hospital['hospital'] = $this->input->post('hospital');							//if entered field is hospital then it stores the value into array with index hospital.
        }   //if
		 if($this->input->post('place')){														//checking whether entered field is place or not
             $get_hospital['place'] = $this->input->post('place');								//if entered field is place then it stores the value into array with index place.
        } 
        if($this->input->post('hospital_short_name')){											//checking whether entered field is hospital_short_name or not
            $get_hospital['hospital_short_name'] = $this->input->post('hospital_short_name');	//if entered field is hospital_short_name then it stores the value into array with index hospital_short_name.
        }   //if
        
		if($this->input->post('district')){														//checking whether entered field is district or not
             $get_hospital['district'] = $this->input->post('district');						//if entered field is district then it stores the value into array with index district.
        }
		if($this->input->post('state')){														//checking whether entered field is state or not
             $get_hospital['state'] = $this->input->post('state');								//if entered field is state then it stores the value into array with index state.
        }
		
        if($this->input->post('type1')){														//checking whether entered field is type1 or not
             $get_hospital['type1'] = $this->input->post('type1');								//if entered field is type1 then it stores the value into array with index type1.
        }
        if($this->input->post('type2')){														//checking whether entered field is type2 or not
             $get_hospital['type2'] = $this->input->post('type2');								//if entered field is type2 then it stores the value into array with index type2.
        }
        if($this->input->post('type3')){														//checking whether entered field is type3 or not
             $get_hospital['type3'] = $this->input->post('type3');								//if entered field is type3 then it stores the value into array with index type3.
        }
        if($this->input->post('type4')){														//checking whether entered field is type4 or not
             $get_hospital['type4'] = $this->input->post('type4');								//if entered field is type4 then it stores the value into array with index type4.
        }
        if($this->input->post('type5')){														//checking whether entered field is type5 or not
             $get_hospital['type5'] = $this->input->post('type5');								//if entered field is type5 then it stores the value into array with index type5.
        }
        if($this->input->post('type6')){														//checking whether entered field is type6 or not
             $get_hospital['type6'] = $this->input->post('type6');								//if entered field is type6 then it stores the value into array with index type6.
        }
		 if($this->input->post('description')){													//checking whether entered field is description or not
            $get_hospital['description'] = $this->input->post('description');					//if entered field is description then it stores the value into array with index description.
        } 
           $hospital_id='';
           if($this->input->post('hospital_id')){
			   $hospital_id=$this->input->post('hospital_id');
		   }
       
		$this->db->trans_start();
		 $this->db->where('hospital_id', $hospital_);
        $this->db->update('hospital_short_name', $hospital_short_name);   											//inserting get_hospital array values into hospital table 
      //  echo $this->db->last_query()."Test";
		echo "updated succesfully";
        $this->db->trans_complete();
        if($this->db->trans_status()==FALSE){
		return false;
		}
        else{
           return true;
        }       
    }
	
	function add_department(){
        $department_info = array();
        if($this->input->post('hospital_id')){
            $department_info['hospital_id'] = $this->input->post('hospital_id');
        }
        if($this->input->post('department')){
            $department_info['department'] = $this->input->post('department');
        }
        if($this->input->post('description')){
            $department_info['description'] = $this->input->post('description');
        }
         if($this->input->post('lab_report_staff_id')){
            $department_info['lab_report_staff_id'] = $this->input->post('lab_report_staff_id');
        }
         if($this->input->post('department_email')){
            $department_info['department_email'] = $this->input->post('department_email');
        }
        if($this->input->post('number_of_units')){
			$department_info['number_of_units'] = $this->input->post('number_of_units');			    
        }
         if($this->input->post('op_room_no')){
            $department_info['op_room_no'] = $this->input->post('op_room_no');
        }
         if($this->input->post('clinical')){
            $department_info['clinical'] = $this->input->post('clinical');
        }
         if($this->input->post('floor')){
            $department_info['floor'] = $this->input->post('floor');
        }
         if($this->input->post('mon')){
            $department_info['mon'] = $this->input->post('mon');
        }
         if($this->input->post('tue')){
            $department_info['tue'] = $this->input->post('tue');
        }
         if($this->input->post('wed')){
            $department_info['wed'] = $this->input->post('wed');
        }
         if($this->input->post('thr')){
            $department_info['thr'] = $this->input->post('thr');
        }
         if($this->input->post('fri')){
            $department_info['fri'] = $this->input->post('fri');
        }
         if($this->input->post('sat')){
            $department_info['sat'] = $this->input->post('sat');
        }
        $this->db->trans_start();
        $this->db->insert('department', $department_info);
        echo "inserted successfully.";
        $this->db->trans_complete();
        if($this->db->trans_status()==FALSE){
                return false;
        }
        else{
                return true;
        }
    }
	function update_department(){
        $department_info = array();
        if($this->input->post('hospital')){
            $department_info['hospital_id'] = $this->input->post('hospital');
        }
        if($this->input->post('department')){
            $department_info['department'] = $this->input->post('department');
        }
        if($this->input->post('description')){
            $department_info['description'] = $this->input->post('description');
        }
         if($this->input->post('lab_report_staff_id')){
            $department_info['lab_report_staff_id'] = $this->input->post('lab_report_staff_id');
        }
         if($this->input->post('department_email')){
            $department_info['department_email'] = $this->input->post('department_email');
        }
        if($this->input->post('number_of_units')){
			 $this->db->where('number_of_units',$this->input->post('number_of_units'));   
        }
         if($this->input->post('op_room_no')){
            $department_info['op_room_no'] = $this->input->post('op_room_no');
        }
         if($this->input->post('clinical')){
            $department_info['clinical'] = $this->input->post('clinical');
        }
         if($this->input->post('floor')){
            $department_info['floor'] = $this->input->post('floor');
        }
         if($this->input->post('mon')){
            $department_info['mon'] = $this->input->post('mon');
        }
         if($this->input->post('tue')){
            $department_info['tue'] = $this->input->post('tue');
        }
         if($this->input->post('wed')){
            $department_info['wed'] = $this->input->post('wed');
        }
         if($this->input->post('thr')){
            $department_info['thr'] = $this->input->post('thr');
        }
         if($this->input->post('fri')){
            $department_info['fri'] = $this->input->post('fri');
        }
         if($this->input->post('sat')){
            $department_info['sat'] = $this->input->post('sat');
        }
         $this->db->trans_start();
         $this->db->where('department_id',$this->input->post('department_id'));
        $this->db->update('department', $department_info);
        $this->db->trans_complete();
        if($this->db->trans_status()==FALSE){
                return false;
        }
        else{
                return true;
        } 
    }
	function get_department(){   //This for evaluation.
		if($this->input->post('hospital')){
			$this->db->where('department.hospital_id',$this->input->post('hospital'));
		}
		if($this->input->post('department_id')){
			$this->db->where('department.department_id',$this->input->post('department_id'));
		}
        if($this->input->post('department')){
			$this->db->where('department',$this->input->post('department'));
         
        }
        if($this->input->post('description')){
			$this->db->where('description',$this->input->post('description'));
        }
         if($this->input->post('lab_report_staff_id')){		 
			 $this->db->where('lab_report_staff_id',$this->input->post('lab_report_staff_id'));
        }
         if($this->input->post('department_email')){
			 $this->db->where('department_email',$this->input->post('department_email'));
        }
         if($this->input->post('no_of_units')){
			 $this->db->where('no_of_units',$this->input->post('no_of_units'));   
        }
         if($this->input->post('op_room_no')){
			 $this->db->where('op_room_no',$this->input->post('op_room_no'));
            
        }
         if($this->input->post('clinical')){
			 $this->db->where('clinical',$this->input->post('clinical'));
        }
         if($this->input->post('floor')){
			 $this->db->where('floor',$this->input->post('floor'));
        }
         if($this->input->post('mon')){
			 $this->db->where('mon',$this->input->post('mon'));
        }
         if($this->input->post('tue')){
			 $this->db->where('tue',$this->input->post('tue'));
        }
         if($this->input->post('wed')){
			 $this->db->where('wed',$this->input->post('wed'));
		}
         if($this->input->post('thr')){
			 $this->db->where('thr',$this->input->post('thr'));
        }
         if($this->input->post('fri')){
			 $this->db->where('fri',$this->input->post('fri'));
        }
         if($this->input->post('sat')){
			 $this->db->where('sat',$this->input->post('sat'));
        }  
       $this->db->select('department.*,hospital')
          ->from('department')
		  ->join('hospital','department.hospital_id = hospital.hospital_id');                              
       $query = $this->db->get();
       $result = $query->result();
       if($result){
        return $result;       
       }else{
           return false;
       }     
    }	   	

    function add_drug() {
        $generic_item_id = $this->input->post('generic_item_id');
        $hospital_id = $this->session->userdata('hospital')['hospital_id'];
        
        if($hospital_id == '')
            return false;
        $drug_record = array(
            'generic_item_id' => $generic_item_id,
            'hospital_id' => $hospital_id
        );
        $this->db->insert('drug_available', $drug_record);
        $insert_id = $this->db->insert_id();
        return $insert_id;
    }

    function get_drugs() {
        $hospital_id = $this->session->userdata('hospital')['hospital_id'];
        if($hospital_id == '')
            return false;
        $drug_record = array(
            'drug_available.hospital_id' => $hospital_id
        );
        $this->db->select('generic_item.generic_item_id, generic_item.generic_name, item_form.item_form, drug_type.drug_type,drug_available.drug_avl_id')
                ->from('drug_available')
                ->join('generic_item', 'generic_item.generic_item_id = drug_available.generic_item_id', 'left')
                ->join('item_form', 'generic_item.form_id = item_form.item_form_id', 'left')
                ->join('drug_type', 'generic_item.drug_type_id = drug_type.drug_type_id', 'left')
                ->order_by('generic_item.generic_name')
                ->where($drug_record);
        $query = $this->db->get();
        $result = $query->result();
        
        return $result;
    }

    function delete_drug() {
        $hospital_id = $this->session->userdata('hospital')['hospital_id'];
        if($hospital_id == '')
            return false;
        $drug_avl_id = $this->input->post('drug_avl_id');
        $delete_record = array(
            'drug_avl_id' => $drug_avl_id,
            'hospital_id' => $hospital_id
        );
        
        $this->db->delete('drug_available', $delete_record);
        $affected_rows = $this->db->affected_rows();
        
        return $affected_rows;
    }

    function get_masters_drugs() {
        $this->db->select('generic_item.generic_item_id, generic_item.generic_name, item_form.item_form, drug_type.drug_type')
            ->from('generic_item')
            ->join('item_form', 'generic_item.form_id = item_form.item_form_id', 'left')
            ->join('drug_type', 'generic_item.drug_type_id = drug_type.drug_type_id', 'left')
            ->order_by('generic_item.generic_name');
        $query = $this->db->get();
        $result = $query->result();
        
        return $result;
    }
}
