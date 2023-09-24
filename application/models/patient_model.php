<?php

class patient_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    
    //Method to get transfer information for a particular visit.
    function get_transfers_info($visit_id_param=0){
        if($this->input->post('selected_patient') || $this->input->post('visit_id') || $visit_id_param!=0){
            $visit_id = $this->input->post('selected_patient') ? $this->input->post('selected_patient') : $this->input->post('visit_id');
            $visit_id = $visit_id > 0 ? $visit_id :  $visit_id_param;
            $this->db->select('*')
                 ->from('internal_transfer')
                 ->where('visit_id',$visit_id);
            $query = $this->db->get();
            return $query->result();
        }
        return false;
    }
    
    //Method to get the arrival modes of patient for a particular visit.
    function get_arrival_modes(){
        $this->db->select('*')
                ->from('patient_arrival_mode');
        $query = $this->db->get();
        return $query->result();
    }
    
    //Method to retrieve visit type.
    function get_visit_types(){
        $this->db->select('*')
                ->from('visit_name');
        $query = $this->db->get();
        return $query->result();
    }
    
    function register_external_patient(){    //Presently used only for bloodbank module to be extended.
        $first_name="";
        $last_name="";
        $patient_age ="";
        $gender = "";
        $phone = "";
        $final_diagnosis ="";
        $ward_unit ="";
        if($this->input->post('first_name')){
            $first_name=$this->input->post('first_name');         
        }
        if($this->input->post('last_name')){ 
            $last_name=$this->input->post('last_name'); 
        }        
        if($this->input->post('patient_age')){
            $patient_age = $this->input->post('patient_age');
        }
        if($this->input->post('gender')){
            $gender=$this->input->post('gender');
        }
        if($this->input->post('phone')){
            $phone = $this->input->post('phone');
        }
        if($this->input->post('patient_diagnosis')){
            $final_diagnosis =$this->input->post('patient_diagnosis');
        }
        if($this->input->post('ward_unit')){
            $ward_unit = $this->input->post('ward_unit');
        }        
        
        $patient_data = array(
            'first_name' => $first_name,
            'last_name' => $last_name,
            'patient_age' => $patient_age,
            'gender' => $gender,
            'phone' => $phone    
        );
        
        $this->db->insert('patient',$patient_data);
        $patient_id=$this->db->insert_id();
        $this->db->select('count')->from('counter')->where('counter_name','OP');
        $query=$this->db->get();
        $result=$query->row();
        $hospital_id = $this->input->post('hospital');
        $hosp_file_no=++$result->count;
        $this->db->where('counter_name','OP');
        $this->db->update('counter',array('count'=>$hosp_file_no));
        
        $patient_visit_data = array(
            'patient_id' => $patient_id,
            'visit_type' => 'OP',
            'hosp_file_no' => $hosp_file_no,
            'unit' => $ward_unit,
            'final_diagnosis' => $final_diagnosis
        );        
        $this->db->insert('patient_visit',$patient_visit_data,false);
	$visit_id = $this->db->insert_id(); //store the visit_id from the inserted record
        return $visit_id;
    }
    
    function get_patient_info(){
        $patient_id = '';
        if($this->input->post('patient_id')){
            $patient_id = $this->input->post('patient_id');
        }
        else{
            return false;
        }
        
        $this->db->select('patient.patient_id, patient.first_name, patient.last_name, patient.phone, patient.blood_group, patient.gender, patient_visit.visit_id, patient_visit.hosp_file_no, patient_visit.provisional_diagnosis, patient_visit.final_diagnosis, patient_visit.hosp_file_no')
                ->from('patient')
                ->join('patient_visit','patient_visit.patient_id = patient.patient_id','left')
                ->where('patient.patient_id', "$patient_id");
        
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    function get_patient_data(){
        $patient_id = '';
        if($this->input->post('patient_id')){
            $patient_id = $this->input->post('patient_id');
        }
        else{
            return;
        }
        
        $this->db->select('patient_id,first_name,middle_name,last_name, phone, alt_phone, gender, age_years,age_months,age_days,address,place,father_name,mother_name,spouse_name,patient_id_manual')
                ->from('patient')
                ->where('patient.patient_id', "$patient_id");
        
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    
    function get_patient_data_edit_history(){
        $patient_id = '';
        if($this->input->post('patient_id')){
            $patient_id = $this->input->post('patient_id');
        }
        else{
            return;
        }
        
        $this->db->select("table_name,field_name,previous_value,new_value,edit_date_time,CONCAT(staff.first_name, ' ', staff.last_name) as edit_staff",false)
                ->from('patient_info_edit_history')
                ->join('staff','patient_info_edit_history.edit_staff_id=staff.staff_id','left')
                ->where('patient_id', "$patient_id");
        $this->db->order_by('edit_date_time','DESC');      
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    
    function update_patient_data($input_data){
        if(!array_key_exists('patient_id',$input_data)){
            return 1;
        }
         
        $patient_id  = $input_data['patient_id'];
        $staff_id = $this->session->userdata('logged_in')['staff_id'];
	$edit_time = date("Y-m-d H:i:s");
        $table_name='patient';
        $edit_history = array();
        $patient = array();
        $elements = ['patient_id_manual','first_name','middle_name','last_name','phone','alt_phone','gender','age_years','age_months','age_days','address','place','father_name','mother_name','spouse_name'];
        foreach ($elements as $column) {
        	if (array_key_exists($column,$input_data)){ 
			$edit_data = array();
			$patient[$column] = $input_data[$column]['new'];  
			$edit_data['patient_id'] = $patient_id;
			$edit_data['edit_date_time'] = $edit_time;
			$edit_data['edit_staff_id'] = $staff_id; 
			$edit_data['previous_value'] = $input_data[$column]['old'];
			$edit_data['new_value'] = $input_data[$column]['new'];
			$edit_data['field_name'] = $column; 
			$edit_data['table_name'] = 'patient';  
			array_push($edit_history,$edit_data);  
        	}
        }
        //echo("<script>console.log('edit_history: " .json_encode($edit_history) . "');</script>");
        $this->db->trans_start(); # Starting Transaction


	$this->db->insert_batch('patient_info_edit_history', $edit_history); # Inserting data


	$this->db->where('patient_id', $patient_id);
	$this->db->update('patient', $patient); 

	$this->db->trans_complete(); # Completing transaction


	if ($this->db->trans_status() === FALSE) {
    		# Something went wrong.
    		$this->db->trans_rollback();
    		return 2;
	} else {
		# Everything is Perfect. 
	    	# Committing data to the database.
	    	$this->db->trans_commit();
	    	return 0;
	}

    }
    
    function get_patients(){
        $year = '';
        $visit_type = '';
        $ip_op_number = '';
        $patient_id = '';
        $patient_name = '';
        $phone_number = '';
        
        if($this->input->post('search_year') || $this->input->post('search_visit_type') || $this->input->post('ip_op_number') || $this->input->post('patient_id') || $this->input->post('patient_name') || $this->input->post('phone_number')){
            
        }else{
            return false;
        }
        
        if($this->input->post('year')){
            $year = $this->input->post('year');
            $this->db->where('YEAR(patient_visit.admit_date)', "$year");
        }
        if($this->input->post('visit_type')){
            $visit_type = $this->input->post('visit_type');
            $this->db->where('patient_visit.visit_type', "$visit_type");
        }
        if($this->input->post('ip_op_number')){
            $ip_op_number = $this->input->post('ip_op_number');
            $this->db->where('patient_visit.hosp_file_no', "$ip_op_number");
        }
        if($this->input->post('patient_id')){
            $patient_id = $this->input->post('patient_id');
            $this->db->where('patient.patient_id', "$patient_id");
        }
        if($this->input->post('patient_name')){
            $patient_name = $this->input->post('patient_name');
            $this->db->or_like('patient.first_name',"$patient_name", 'both');
            $this->db->or_like('patient.last_name',"$patient_name", 'both');
        }
        if($this->input->post('phone_number')){
            $phone_number = $this->input->post('phone_number');
            $this->db->where('patient.phone', "$phone_number");
        }
        
        $this->db->select('patient.patient_id, patient.first_name, patient.last_name, patient.phone, patient.blood_group, patient.gender, patient_visit.visit_id, patient_visit.hosp_file_no, patient_visit.provisional_diagnosis, patient_visit.final_diagnosis')
                ->from('patient')
                ->join('patient_visit','patient_visit.patient_id = patient.patient_id','left')
                ->limit('300');
        
        $query = $this->db->get();        
        $result = $query->result();
        
        return $result;
    }
    
    function casesheet_mrd_status(){
        if($this->input->post('from_ip_number') && $this->input->post('to_ip_number')){
            $from_ip_number = $this->input->post('from_ip_number');
            $to_ip_number = $this->input->post('to_ip_number');
            if($from_ip_number >= $to_ip_number){
                $this->db->where('hosp_file_no <=', $from_ip_number); 
                $this->db->where('hosp_file_no >=', $to_ip_number);
            }else{
                $this->db->where('hosp_file_no >=', $from_ip_number); 
                $this->db->where('hosp_file_no <=', $to_ip_number);
            }
        }else{
            return false;
        }
        $this->db->select('patient_visit.outcome_date, patient_visit.visit_id, patient_visit.hosp_file_no, patient_visit.casesheet_at_mrd_date')
                ->from('patient_visit')
                ->where('visit_type','IP');
        
        $query = $this->db->get();        
        $result = $query->result();
        
        return $result;
    }
    
    function add_obg_history(){
        $patient_obg_data = array();
        
        if($this->input->post('patient_id')){
            $patient_obg_data['patient_id'] = $this->input->post('patient_id');
        }
        if($this->input->post('conception_type')){
            $patient_obg_data['conception_type'] = $this->input->post('conception_type');
        }
        if($this->input->post('pregnancy_number')){
            $patient_obg_data['pregnancy_number'] = $this->input->post('pregnancy_number');
        }
        
        $this->db->insert('patient_obstetric_history',$patient_obg_data,false);
	$visit_id = $this->db->insert_id(); //store the visit_id from the inserted record
        echo $visit_id;
        return $visit_id;
    }
}

?>
