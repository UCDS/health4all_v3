<?php

class department_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    function visit_summary_by_hr(){
        $from_date = '';
        $to_date = '';
        if($this->input->post('from_date') && $this->input->post('to_date')){
            $from_date= strtotime($this->input->post('from_date'));
            $to_date= strtotime($this->input->post('to_date'));           
        }
        else if($this->input->post('from_date') || $this->input->post('to_date')){
            $this->input->post('from_date') ? $from_date = strtotime($this->input->post('from_date')) : strtotime($from_date= $this->input->post('to_date'));
            $to_date=$from_date;
        }
        else{
            $from_date = strtotime(date("Y-m-d"));
            $to_date = $from_date;           
        }
        
        // Setting date_range array
        $date_range = array();
        $output_format = 'Y-m-d';
        $current_date = $from_date;
        $end_date = $to_date;
        $step = '+1 day';
        while( $current_date <= $end_date ) {
            $date_range[] = date($output_format, $current_date);
            $current_date = strtotime($step, $current_date);
        }
        
        
        if($this->input->post('from_time') && $this->input->post('to_time')){
            $from_time=date("H:i",strtotime($this->input->post('from_time')));
            $to_time=date("H:i",strtotime($this->input->post('to_time')));
        //    $this->db->where("(admit_time BETWEEN '$from_time' AND '$to_time')");
        }
        else if($this->input->post('from_time') || $this->input->post('to_time')){
            if($this->input->post('from_time')){
                $from_time=$this->input->post('from_time');
                $to_time = '23:59';
            }else{ 
                $from_time = '00:00';
                $to_time=$this->input->post('to_time');                        
            }			
         //   $this->db->where("(admit_time BETWEEN '$from_time' AND '$to_time')");
        }
        else{
        //    $this->db->where("(admit_time BETWEEN '00:00' AND '23:59')");
        }
        
        
        // Setting time ranges.
        $time_interval_start = array('00:00', '01:00', '02:00', '03:00', '04:00', '05:00',
             '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', 
             '12:00', '13:00', '14:00', '15:00', '16:00', '17:00',
             '18:00', '19:00', '20:00', '21:00', '23:00');
        $time_interval_end = array('00:59', '01:59', '02:59', '03:59', '04:59', '05:59',
             '06:59', '07:59', '08:59', '09:59', '10:59', '11:59', 
             '12:59', '13:59', '14:59', '15:59', '16:59', '17:59',
             '18:59', '19:59', '20:59', '21:59', '23:59');
        
        
        $patient_visit_summary_by_hr = array();
        foreach($date_range as $date){
            $visits_per_day = array();
            for($i = 0; $i < 22; $i++){  
                $interval_start = $time_interval_start[$i];
                $this->db->_protect_identifiers=false;
                $this->db->select("COUNT(*) patient_visits, '$interval_start' time_intreval_start")
                    ->from('patient_visit')
                    ->where("admit_time BETWEEN '$time_interval_start[$i]' AND '$time_interval_end[$i]'")
                    ->where("admit_date", "$date");
                
                $result = $this->db->get();
                $visits = $result->row();
                if(sizeof($visits) > 0){
                    
                }
                else{
                    $visits = (object) array(
                        patient_visits => 0,
                        time_intreval_start => $interval_start
                    );
                }
                $visits_per_day[] = $visits;                
            }
            $patient_visit_summary_by_hr["$date"] = $visits_per_day;
        }
        
        return $patient_visit_summary_by_hr;
    }
    


function add_department(){		//create model add_department.
        $department_info = array();		//initializing the array with name department_info.
        if($this->input->post('hospital_id')){		//checking if the field name is hospital_id or not.
            $department_info['hospital_id'] = $this->input->post('hospital_id');	//store the hospital_id into the department_info array with the index of hospital_id.
        }
        if($this->input->post('department')){		//checking if the field name is department or not.
            $department_info['department'] = $this->input->post('department');		//store the department into the department_info array with the index of deparment.
        }
        if($this->input->post('description')){		//checking if the field name is description or not.
            $department_info['description'] = $this->input->post('description');	//store the description into the department_info array with the index of description.
        }
         if($this->input->post('lab_report_staff_id')){		//checking if the field name is lab_report_staff_id or not.
            $department_info['lab_report_staff_id'] = $this->input->post('lab_report_staff_id');   //store the lab_report_staff_id into the department_info array with the index of lab_report_staff_id.
        }
         if($this->input->post('department_email')){		//checking if the field name is department_email or not.
            $department_info['department_email'] = $this->input->post('department_email');    //store the department_email into the department_info array with the index of department_email.
        }
        if($this->input->post('number_of_units')){		//checking if the field name is number_of_units or not.
            $department_info['number_of_units'] = $this->input->post('number_of_units');	//store the number_of_units into the department_info array with the index of number_of_units.
        }
         if($this->input->post('op_room_no')){		//checking if the field name is op_room_no or not.
            $department_info['op_room_no'] = $this->input->post('op_room_no');		//store the op_room_no into the department_info array with the index of op_room_no.
        }
         if($this->input->post('clinical')){		//checking if the field name is clinical or not.
            $department_info['clinical'] = $this->input->post('clinical');			//store the clinical into the department_info array with the index of clinical.
        }
         if($this->input->post('floor')){			//checking if the field name is floor or not.
            $department_info['floor'] = $this->input->post('floor');		//store the floor into the department_info array with the index of floor.
        }
         if($this->input->post('mon')){			//checking if the field name is mon or not.
            $department_info['mon'] = $this->input->post('mon');		//store the mon into the department_info array with the index of mon.
        }
         if($this->input->post('tue')){			//checking if the field name is tue or not.
            $department_info['tue'] = $this->input->post('tue');		//store the tue into the department_info array with the index of tue.
        }
         if($this->input->post('wed')){			//checking if the field name is wed or not.
            $department_info['wed'] = $this->input->post('wed');	//store the wed into the department_info array with the index of wed.
        }
         if($this->input->post('thr')){			//checking if the field name is thr or not.
            $department_info['thr'] = $this->input->post('thr');		//store the thr into the department_info array with the index of thr.
        }
         if($this->input->post('fri')){			//checking if the field name is fri or not.
            $department_info['fri'] = $this->input->post('fri');		//store the fri into the department_info array with the index of fri.
        }
         if($this->input->post('sat')){			//checking if the field name is sat or not.
            $department_info['sat'] = $this->input->post('sat');		//store the sat into the department_info array with the index of sat.
        }
        
        $this->db->trans_start();		//		calling the trans_start method
        $this->db->insert('department', $department_info);		//store the data in the department_info to the department table.
        $this->db->trans_complete();	//  calling the trans_completed method
        echo "inserted successfully";		//print inserted values
        if($this->db->trans_status()==FALSE){		//checking for inserted values.
                return false;		//if values are not inserted it will return false.
        }
        else{
                return true;		//if values are inserted it will return true.
        }
    }
}
