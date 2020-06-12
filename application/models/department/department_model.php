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
    
}
