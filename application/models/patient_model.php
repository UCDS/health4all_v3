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

    function get_patient_visits_data(){
        $patient_id = '';
        if($this->input->post('patient_id')){
            $patient_id = $this->input->post('patient_id');
        }
        else{
            return;
        }
        
        $this->db->select('patient_visit.patient_id,patient_visit.visit_type,patient.age_years,patient.age_months,patient.age_days,patient.gender,patient.phone,
        patient.address,patient.first_name,patient_visit.hosp_file_no as op_ip_no,patient_visit.admit_date,hospital.hospital as hospital_name,department.department as dept_name,
        visit_name.visit_name,patient_visit.appointment_time,patient_visit.visit_id,patient.last_name,patient_visit.appointment_slot_id,aps.is_default as appointment_status_category ')
                ->from('patient_visit')
                ->join('patient','patient.patient_id=patient_visit.patient_id','left')
                ->join('hospital','hospital.hospital_id=patient_visit.hospital_id','left')
                ->join('department','department.department_id=patient_visit.department_id','left')
                ->join('visit_name','visit_name.visit_name_id=patient_visit.visit_name_id','left')
				->join('appointment_status aps','patient_visit.appointment_status_id=aps.id','left')	
                ->where('patient_visit.patient_id', "$patient_id");
                $this->db->order_by('patient_visit.admit_date','DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
    
    function get_patient_visit_id_details($visit_id)
    {
        $this->db->select("visit_id,pv.hospital_id,admit_id,visit_type,visit_name_id,patient_id,hosp_file_no,admit_date,admit_time,department_id,unit,area,doctor_id,nurse,insurance_case,
        insurance_id,insurance_no,presenting_complaints,past_history,family_history,admit_weight,pulse_rate,respiratory_rate,temperature,sbp,dbp,spo2,blood_sugar,hb,hb1ac,clinical_findings,
        cvs,rs,pa,cns,cxr,provisional_diagnosis,signed_consultation,final_diagnosis,decision,advise,icd_10,icd_10_ext,discharge_weight,outcome,outcome_date,outcome_time,ip_file_received,
        mlc,arrival_mode,referral_by_hospital_id,insert_by_user_id,update_by_user_id,insert_datetime,update_datetime,appointment_with,appointment_time,appointment_update_by,appointment_update_time,
        summary_sent_time,temp_visit_id,appointment_status_id,appointment_status_update_by,appointment_status_update_time,
		IF(aps.is_default IS NULL or aps.is_default = '', 0, aps.is_default) as appointment_status_category,
		IF(pv.appointment_slot_id IS NULL or pv.appointment_slot_id = '', 0, pv.appointment_slot_id) as appointment_slot_id",false)
                ->from('patient_visit pv')
				->join('appointment_status aps','pv.appointment_status_id=aps.id','left')
                ->where('visit_id', $visit_id);
        $this->db->order_by('pv.admit_date','DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function ins_del_ops_duplicate_data($data,$visit_id) 
    {
		$appointment_slot_id = $data[0]->appointment_slot_id;
		$appointment_status_category = $data[0]->appointment_status_category;
        $this->db->trans_start();
        $data = array(
            'visit_id' => $data[0]->visit_id,
            'hospital_id' => $data[0]->hospital_id,
            'admit_id' => $data[0]->admit_id,
            'visit_type' => $data[0]->visit_type,
            'visit_name_id' => $data[0]->visit_name_id,
            'patient_id' => $data[0]->patient_id,
            'hosp_file_no' => $data[0]->hosp_file_no,
            'admit_date' => $data[0]->admit_date,
            'admit_time' => $data[0]->admit_time,
            'department_id' => $data[0]->department_id,
            'unit' => $data[0]->unit,
            'area' => $data[0]->area,
            'doctor_id' => $data[0]->doctor_id,
            'nurse' => $data[0]->nurse,
            'insurance_case' => $data[0]->insurance_case,
            'insurance_id' => $data[0]->insurance_id,
            'insurance_no' => $data[0]->insurance_no,
            'presenting_complaints' => $data[0]->presenting_complaints,
            'past_history' => $data[0]->past_history,
            'family_history' => $data[0]->family_history,
            'admit_weight' => $data[0]->admit_weight,
            'pulse_rate' => $data[0]->pulse_rate,
            'respiratory_rate' => $data[0]->respiratory_rate,
            'temperature' => $data[0]->temperature,
            'sbp' => $data[0]->sbp,
            'dbp' => $data[0]->dbp,
            'spo2' => $data[0]->spo2,
            'blood_sugar' => $data[0]->blood_sugar,
            'hb' => $data[0]->hb,
            'hb1ac' => $data[0]->hb1ac,
            'clinical_findings' => $data[0]->clinical_findings,
            'cvs' => $data[0]->cvs,
            'rs'=> $data[0]->rs,
            'pa' => $data[0]->pa,
            'cns' => $data[0]->cns,
            'cxr' => $data[0]->cxr,
            'provisional_diagnosis' => $data[0]->provisional_diagnosis,
            'signed_consultation' => $data[0]->signed_consultation,
            'final_diagnosis' => $data[0]->final_diagnosis,
            'decision' => $data[0]->decision,
            'advise' => $data[0]->advise,
            'icd_10' => $data[0]->icd_10,
            'icd_10_ext' => $data[0]->icd_10_ext,
            'discharge_weight' => $data[0]->discharge_weight,
            'outcome' => $data[0]->outcome,
            'outcome_date' => $data[0]->outcome_date,
            'outcome_time' => $data[0]->outcome_time,
            'ip_file_received' => $data[0]->ip_file_received,
            'mlc' => $data[0]->mlc,
            'arrival_mode' => $data[0]->arrival_mode,
            'referral_by_hospital_id' => $data[0]->referral_by_hospital_id,
            'insert_by_user_id' => $data[0]->insert_by_user_id,
            'update_by_user_id' => $data[0]->update_by_user_id,
            'insert_datetime' => $data[0]->insert_datetime,
            'update_datetime' => $data[0]->update_datetime,
            'appointment_with' => $data[0]->appointment_with,
            'appointment_time' => $data[0]->appointment_time,
            'appointment_update_by' => $data[0]->appointment_update_by,
            'appointment_update_time' => $data[0]->appointment_update_time,
            'summary_sent_time' => $data[0]->summary_sent_time,
            'temp_visit_id' => $data[0]->temp_visit_id,
            'appointment_status_id' => $data[0]->appointment_status_id,
            'appointment_status_update_by' => $data[0]->appointment_status_update_by,
            'appointment_status_update_time' => $data[0]->appointment_status_update_time,
            'delete_datetime' => date("Y-m-d H:i:s"),
            'staff_id' => $this->session->userdata('logged_in')['staff_id']
        );
        
		//echo("<script>alert('appointment_slot_id: " . $appointment_slot_id . "');</script>");
		//echo("<script>alert('appointment_status_category: " . $appointment_status_category . "');</script>");
		
        $this->db->insert('patient_visit_duplicate', $data);
        $this->db->delete('patient_visit',array('visit_id'=> $visit_id));
		$this->db->query('CALL sp_update_appointment_count_for_slot(?,?,?,?)',[$appointment_slot_id, 0,$appointment_status_category,0]);
        $this->db->trans_complete();
        if($this->db->trans_status()===FALSE)
        {
			return false;
		}
		else return true;
    }

    // function delete_from_patient_visit($visit_id) 
    // {
    //     $this->db->where('visit_id', $visit_id)->delete('patient_visit');
    // }

    function get_patient_visit_id_delete_history($patient_id)
    {
        //$patient = $this->input->post('patient_id');
        $this->db->select('patient_visit_duplicate.patient_id,patient_visit_duplicate.visit_type,patient.age_years,patient.age_months,patient.age_days,patient.gender,patient.phone,
        patient.address,patient.first_name,patient_visit_duplicate.hosp_file_no as op_ip_no,patient_visit_duplicate.admit_date,hospital.hospital as hospital_name,department.department as dept_name,
        visit_name.visit_name,patient_visit_duplicate.appointment_time,patient_visit_duplicate.visit_id,staff.first_name as staff_name,patient_visit_duplicate.delete_datetime,
        patient_visit_duplicate.delete_id')
                ->from('patient_visit_duplicate')
                ->join('patient','patient.patient_id=patient_visit_duplicate.patient_id','left')
                ->join('hospital','hospital.hospital_id=patient_visit_duplicate.hospital_id','left')
                ->join('department','department.department_id=patient_visit_duplicate.department_id','left')
                ->join('visit_name','visit_name.visit_name_id=patient_visit_duplicate.visit_name_id','left')
                ->join('staff','staff.staff_id=patient_visit_duplicate.staff_id','left')
                ->where('patient_visit_duplicate.patient_id', $patient_id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function get_deleted_duplicate_data()
    {
        $from_time = '00:00';	
	    $to_time = '23:59';
        if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')?$from_date=$this->input->post('from_date'):$from_date=$this->input->post('to_date');
			$to_date=$from_date;
		}
		else{
			$from_date=date("Y-m-d");
			$to_date=$from_date;
		}

        $from_timestamp = $from_date." ".$from_time;
		$to_timestamp = $to_date." ".$to_time;
		$this->db->where("(delete_datetime BETWEEN '$from_timestamp' AND '$to_timestamp')");

        $this->db->select('patient.first_name,patient.last_name,patient_visit_duplicate.patient_id,patient_visit_duplicate.visit_type,patient.age_years,patient.age_months,patient.age_days,patient.gender,patient.phone,
        patient.address,patient.first_name,patient_visit_duplicate.hosp_file_no as op_ip_no,patient_visit_duplicate.admit_date,hospital.hospital as hospital_name,department.department as dept_name,
        visit_name.visit_name,patient_visit_duplicate.appointment_time,patient_visit_duplicate.visit_id,staff.first_name as staff_name,patient_visit_duplicate.delete_datetime,
        patient_visit_duplicate.delete_id')
                ->from('patient_visit_duplicate')
                ->join('patient','patient.patient_id=patient_visit_duplicate.patient_id','left')
                ->join('hospital','hospital.hospital_id=patient_visit_duplicate.hospital_id','left')
                ->join('department','department.department_id=patient_visit_duplicate.department_id','left')
                ->join('visit_name','visit_name.visit_name_id=patient_visit_duplicate.visit_name_id','left')
                ->join('staff','staff.staff_id=patient_visit_duplicate.staff_id','left');
                
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function get_patient_edits_info()
    {
        $from_time = '00:00';	
	    $to_time = '23:59';
        if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')?$from_date=$this->input->post('from_date'):$from_date=$this->input->post('to_date');
			$to_date=$from_date;
		}
		else{
			$from_date=date("Y-m-d");
			$to_date=$from_date;
		}

        $from_timestamp = $from_date." ".$from_time;
		$to_timestamp = $to_date." ".$to_time;
		$this->db->where("(edit_date_time BETWEEN '$from_timestamp' AND '$to_timestamp')");

        $this->db->select('patient_info_edit_history.patient_id,patient_info_edit_history.table_name,
        patient_info_edit_history.field_name,patient_info_edit_history.previous_value,patient_info_edit_history.new_value,patient_info_edit_history.edit_date_time,staff.first_name as staff_name,patient.first_name')
                ->from('patient_info_edit_history')
                ->join('patient','patient.patient_id=patient_info_edit_history.patient_id','left')
                ->join('staff','staff.staff_id=patient_info_edit_history.edit_staff_id','left');
                
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function get_patient_edits_info_count()
    {
        $from_time = '00:00';	
	    $to_time = '23:59';
        if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')?$from_date=$this->input->post('from_date'):$from_date=$this->input->post('to_date');
			$to_date=$from_date;
		}
		else{
			$from_date=date("Y-m-d");
			$to_date=$from_date;
		}

        $from_timestamp = $from_date." ".$from_time;
		$to_timestamp = $to_date." ".$to_time;
		$this->db->where("(edit_date_time BETWEEN '$from_timestamp' AND '$to_timestamp')");

        $this->db->select("count(*) as count",false)
                ->from('patient_info_edit_history')
                ->join('staff','staff.staff_id=patient_info_edit_history.edit_staff_id','left');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    //feb 5 to add to live from here
    function get_patient_visits_to_edit()
    {
        $hospital=$this->session->userdata('hospital');
		$hospital_id=$hospital['hospital_id'];
        $patient_id = '';
        if($this->input->post('patient_id')){
            $patient_id = $this->input->post('patient_id');
        }
        else{
            return;
        }
        $this->db->select('patient_visit.visit_id,patient_id,admit_date,admit_time,unit,area,visit_type,presenting_complaints,past_history,family_history,
        admit_weight,pulse_rate,respiratory_rate,temperature,sbp,dbp,spo2,blood_sugar,hb,clinical_findings,cvs,rs,pa,cns,cxr,
        provisional_diagnosis,final_diagnosis,decision,advise,outcome,outcome_date,outcome_time,hosp_file_no,department.department as dname,
        visit_name.visit_name as vn')
                ->from('patient_visit')
                ->join('department','department.department_id=patient_visit.department_id','left')
                ->join('visit_name','visit_name.visit_name_id=patient_visit.visit_name_id','left')
                ->where('patient_visit.patient_id',$patient_id)
                ->where('patient_visit.hospital_id',$hospital_id);
        $this->db->order_by('patient_visit.admit_date','DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function deleteCounseling_visit_text($del_visits_counseling) 
    {
        $patient_id = $this->input->post('patient_id');
        $this->db->where('counseling_id', $del_visits_counseling);
        $this->db->delete('counseling');
        return $this->db->affected_rows() > 0;
    }

    function get_update_clinical_note_edits($edit_clinical_note, $edit_note_id)
    {
        $this->db->where('note_id', $edit_note_id);
        $this->db->update('patient_clinical_notes', array('clinical_note' => $edit_clinical_note));
    }
    
    function get_all_icd_codes_patient_visits()
    {
        $this->db->select('icd_code,icd_10,code_title');
        $this->db->from('icd_code');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function get_clinical_text_to_edit($edit_visit_id)
    {
        $patient_id = $this->input->post('patient_id');
        $this->db->select('pcn.note_id,pcn.clinical_note as c_note');
        $this->db->from('patient_clinical_notes as pcn');
        $this->db->where('pcn.visit_id',$edit_visit_id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function get_patient_visit_details_for_edits($edit_visit_id)
    {
        $this->db->select('patient_visit.admit_date,patient_visit.admit_time,department.department as dnmame,patient_visit.unit,patient_visit.area,
        patient_visit.visit_name_id,patient_visit.presenting_complaints,patient_visit.past_history,patient_visit.family_history,patient_visit.admit_weight,
        patient_visit.pulse_rate,patient_visit.respiratory_rate,temperature,sbp,dbp,spo2,blood_sugar,hb,clinical_findings,cvs,
        rs,pa,cns,cxr,provisional_diagnosis,final_diagnosis,decision,advise,outcome,outcome_date,outcome_time,unit.unit_name,area.area_name,
        visit_name.visit_name,patient_visit.icd_10,counseling_text.counseling_text as c_txt,counseling.counseling_id,patient_visit.visit_type,patient_visit.appointment_status_id,
        patient_visit.signed_consultation,hospital.hospital,hospital.hospital_short_name')
            ->from('patient_visit')
            ->join('department','department.department_id=patient_visit.department_id','left')
            ->join('unit','unit.unit_id=patient_visit.unit','left')
            ->join('area','area.area_id=patient_visit.area','left')
            ->join('visit_name','visit_name.visit_name_id=patient_visit.visit_name_id','left')
            ->join('counseling','counseling.visit_id=patient_visit.visit_id','left')
            ->join('counseling_text','counseling_text.counseling_text_id=counseling.counseling_text_id','left')
            ->join('hospital','hospital.hospital_id=patient_visit.referral_by_hospital_id','left')
            ->where('patient_visit.visit_id',$edit_visit_id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function select_op_ip($edit_visit_id)
    {
        $this->db->select('patient_visit.visit_type')
            ->from('patient_visit')
            ->where('patient_visit.visit_id',$edit_visit_id);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function patient_visits_edits($input_data)
    {
        $patient_id = $input_data['patient_id'];
        $visit_id  = $input_data['visit_id']; // Editing visit id
        $user_id =   $input_data['user_id']; // login user id
	    $edit_time = date("Y-m-d H:i:s");
        $table_name='patient_visit';
        $edit_visit_history = array();
        $patient = array();
        $elements = ['admit_date','admit_time','department_id','unit','area','visit_name_id','presenting_complaints','past_history','family_history','admit_weight','pulse_rate','respiratory_rate','temperature','sbp','dbp',
                    'spo2','blood_sugar','hb','clinical_findings','cvs','rs','pa','cns','cxr','provisional_diagnosis','final_diagnosis','decision','advise','outcome','outcome_date','outcome_time','icd_10','signed_consultation','referral_by_hospital_id'];
        foreach ($elements as $column) {
        	if (array_key_exists($column,$input_data))
            { 
                $edit_data = array();
                $patient[$column] = $input_data[$column]['new'];  
                $edit_data['patient_id'] = $patient_id;
                $edit_data['visit_id'] = $visit_id;
                $edit_data['edit_date_time'] = $edit_time;
                $edit_data['edit_user_id'] = $user_id; 
                $edit_data['previous_value'] = $input_data[$column]['old'];
                $edit_data['new_value'] = $input_data[$column]['new'];
                $edit_data['field_name'] = $column; 
                $edit_data['table_name'] = $table_name;  
                array_push($edit_visit_history,$edit_data);  
        	}
        }
        
        $this->db->trans_start(); 
	    $this->db->insert_batch('patient_visits_edit_history', $edit_visit_history); 

        $this->db->where('visit_id', $visit_id);
        $this->db->update('patient_visit', $patient); 

	    $this->db->trans_complete(); 
        if($visit_id=='')
        {
            $this->db->trans_rollback();
            return 1;
        }
        else if ($this->db->trans_status() === FALSE) 
        {
    		$this->db->trans_rollback();
    		return 2;
        }
        else 
        {
            $this->db->trans_commit();
            return 0;
        }
    }

    function get_patient_visits_edit_history()
    {
        $patient_id = '';
        if($this->input->post('patient_id')){
            $patient_id = $this->input->post('patient_id');
        }
        $this->db->select("table_name,field_name,previous_value,new_value,edit_date_time,user.username,
        (SELECT department FROM department WHERE patient_visits_edit_history.field_name='department_id'
        AND patient_visits_edit_history.new_value = department.department_id) as dname,
        (SELECT unit_name FROM unit WHERE patient_visits_edit_history.field_name='unit'
        AND patient_visits_edit_history.new_value = unit.unit_id) as uname,
        (SELECT area_name FROM area WHERE patient_visits_edit_history.field_name='area'
        AND patient_visits_edit_history.new_value = area.area_id) as aname,
        (SELECT hospital FROM hospital 
        WHERE patient_visits_edit_history.field_name = 'referral_by_hospital_id' 
        AND patient_visits_edit_history.new_value = hospital.hospital_id) AS referral_hospital_name,
        (SELECT visit_name FROM visit_name WHERE patient_visits_edit_history.field_name='visit_name_id'
        AND patient_visits_edit_history.new_value = visit_name.visit_name_id) as vname")
                ->from('patient_visits_edit_history')
                ->join('user','patient_visits_edit_history.edit_user_id=user.user_id','left')
                ->where('patient_visits_edit_history.patient_id',$patient_id);
        $this->db->order_by('patient_visits_edit_history.edit_date_time','DESC');      
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function get_all_patient_visits_edits()
    {
        $from_time = '00:00';	
	    $to_time = '23:59';
        if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')?$from_date=$this->input->post('from_date'):$from_date=$this->input->post('to_date');
			$to_date=$from_date;
		}
		else{
			$from_date=date("Y-m-d");
			$to_date=$from_date;
		}

        $from_timestamp = $from_date." ".$from_time;
		$to_timestamp = $to_date." ".$to_time;
		$this->db->where("(patient_visits_edit_history.edit_date_time BETWEEN '$from_timestamp' AND '$to_timestamp')");

        $this->db->select('patient_visits_edit_history.patient_id,patient_visits_edit_history.table_name,patient_visits_edit_history.visit_id,
        patient_visits_edit_history.field_name,patient_visits_edit_history.previous_value,patient_visits_edit_history.new_value,
        patient_visits_edit_history.edit_date_time,user.username,patient.first_name,
        (SELECT department FROM department WHERE patient_visits_edit_history.field_name="department_id"
        AND patient_visits_edit_history.new_value = department.department_id) as dname,
        (SELECT unit_name FROM unit WHERE patient_visits_edit_history.field_name="unit"
        AND patient_visits_edit_history.new_value = unit.unit_id) as uname,
        (SELECT area_name FROM area WHERE patient_visits_edit_history.field_name="area"
        AND patient_visits_edit_history.new_value = area.area_id) as aname,
        (SELECT visit_name FROM visit_name WHERE patient_visits_edit_history.field_name="visit_name_id"
        AND patient_visits_edit_history.new_value = visit_name.visit_name_id) as vname')
                ->from('patient_visits_edit_history')
                ->join('patient','patient.patient_id=patient_visits_edit_history.patient_id','left')
                ->join('user','user.user_id=patient_visits_edit_history.edit_user_id','left');
        $this->db->order_by('patient_visits_edit_history.edit_date_time','DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function get_all_patient_visits_edits_count()
    {
        $from_time = '00:00';	
	    $to_time = '23:59';
        if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')?$from_date=$this->input->post('from_date'):$from_date=$this->input->post('to_date');
			$to_date=$from_date;
		}
		else{
			$from_date=date("Y-m-d");
			$to_date=$from_date;
		}

        $from_timestamp = $from_date." ".$from_time;
		$to_timestamp = $to_date." ".$to_time;
		$this->db->where("(patient_visits_edit_history.edit_date_time BETWEEN '$from_timestamp' AND '$to_timestamp')");

        $this->db->select("count(*) as count",false)
                ->from('patient_visits_edit_history')
                ->join('patient','patient.patient_id=patient_visits_edit_history.patient_id','left')
                ->join('user','user.user_id=patient_visits_edit_history.edit_user_id','left');
        $this->db->order_by('patient_visits_edit_history.edit_date_time','DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    // Followup Delete Functions
    function get_patient_followup_history()
    {
        $patient_id = '';
        if($this->input->post('patient_id')){
            $patient_id = $this->input->post('patient_id');
        }
        $hospital_id = $this->session->userdata('hospital')['hospital_id'];
        $this->db->select("patient_followup.patient_id,hospital.hospital as hname,patient_followup.life_status,patient_followup.add_time,
        patient.age_years,patient.gender,patient.first_name,patient.last_name")
                ->from('patient_followup')
                ->join('patient','patient.patient_id=patient_followup.patient_id','left')
                ->join('hospital','hospital.hospital_id=patient_followup.hospital_id','left')
                ->where('patient_followup.hospital_id',$hospital_id)
                ->where('patient_followup.patient_id',$patient_id);    
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function delete_patient_followup($patient_id) 
    {
        $this->db->where('patient_id', $patient_id);
        $this->db->delete('patient_followup');
        return $this->db->affected_rows() > 0;
    }

    function get_all_blood_donor_details($default_rowsperpage)
    {
        if ($this->input->post('page_no')) {
			$page_no = $this->input->post('page_no');
		}
		else{
			$page_no = 1;
		}
		if($this->input->post('rows_per_page')) {
			$rows_per_page = $this->input->post('rows_per_page');
		}
		else{
			$rows_per_page = $default_rowsperpage;
		}
		$start = ($page_no -1 )  * $rows_per_page;

        $from_time = '00:00';	
	    $to_time = '23:59';
        if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')?$from_date=$this->input->post('from_date'):$from_date=$this->input->post('to_date');
			$to_date=$from_date;
		}
		else{
			$from_date=date("Y-m-d");
			$to_date=$from_date;
		}

        $from_timestamp = $from_date." ".$from_time;
		$to_timestamp = $to_date." ".$to_time;
		$this->db->where("(edit_date_time BETWEEN '$from_timestamp' AND '$to_timestamp')");

        $this->db->select('donor_id,table_name,field_name,previous_value,new_value,edit_date_time,edit_user_id,user.username')
                ->from('blood_donor_edit_history')
                ->join('user','user.user_id=blood_donor_edit_history.edit_user_id','left');
        $this->db->order_by('blood_donor_edit_history.edit_date_time','DESC');

        if ($default_rowsperpage !=0)
		{
			$this->db->limit($rows_per_page,$start);
		}
        
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function get_all_blood_donor_details_count()
    {
        $from_time = '00:00';	
	    $to_time = '23:59';
        if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')?$from_date=$this->input->post('from_date'):$from_date=$this->input->post('to_date');
			$to_date=$from_date;
		}
		else{
			$from_date=date("Y-m-d");
			$to_date=$from_date;
		}

        $from_timestamp = $from_date." ".$from_time;
		$to_timestamp = $to_date." ".$to_time;
		$this->db->where("(edit_date_time BETWEEN '$from_timestamp' AND '$to_timestamp')");

        $this->db->select("count(*) as count",false)
                ->from('blood_donor_edit_history')
                ->join('user','user.user_id=blood_donor_edit_history.edit_user_id','left');
        $this->db->order_by('blood_donor_edit_history.edit_date_time','DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function get_all_patient_document_delete_count()
    {
        //$from_time = '00:00';	
	    //$to_time = '23:59';
        if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')?$from_date=$this->input->post('from_date'):$from_date=$this->input->post('to_date');
			$to_date=$from_date;
		}
		else{
			$from_date=date("Y-m-d");
			$to_date=$from_date;
		}

       // $from_timestamp = $from_date." ".$from_time;
		//$to_timestamp = $to_date." ".$to_time;
		$this->db->where("(document_date BETWEEN '$from_date' AND '$to_date')");

        $this->db->select("count(*) as count",false)
                ->from('removed_patient_document_upload')
                ->join('user','user.staff_id=removed_patient_document_upload.removed_by_staff_id','left');
        $this->db->order_by('removed_patient_document_upload.removed_datetime','DESC');
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

    function get_all_patient_document_delete($default_rowsperpage)
    {
        if ($this->input->post('page_no')) {
			$page_no = $this->input->post('page_no');
		}
		else{
			$page_no = 1;
		}
		if($this->input->post('rows_per_page')) {
			$rows_per_page = $this->input->post('rows_per_page');
		}
		else{
			$rows_per_page = $default_rowsperpage;
		}
		$start = ($page_no -1 )  * $rows_per_page;

        //$from_time = '00:00';	
	    //$to_time = '23:59';
        if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')?$from_date=$this->input->post('from_date'):$from_date=$this->input->post('to_date');
			$to_date=$from_date;
		}
		else{
			$from_date=date("Y-m-d");
			$to_date=$from_date;
		}

        //$from_timestamp = $from_date." ".$from_time;
		//$to_timestamp = $to_date." ".$to_time;
		$this->db->where("(rpdu.document_date BETWEEN '$from_date' AND '$to_date')");

        $patient_id = $this->input->post('patient_id');

        if (!empty($patient_id) && $patient_id != 0) 
        {
            $this->db->where('rpdu.patient_id', $patient_id);
        }

        $this->db->select('rpdu.document_date,pdt.document_type,rpdu.document_link,rpdu.insert_datetime,rpdu.removed_datetime,
        rpdu.patient_id,user.username')
                ->from('removed_patient_document_upload rpdu')
                ->join('patient_document_type pdt','pdt.document_type_id=rpdu.document_type_id','left')
                ->join('user','user.staff_id=rpdu.removed_by_staff_id','left');
        $this->db->order_by('rpdu.removed_datetime','DESC');

        if ($default_rowsperpage !=0)
		{
			$this->db->limit($rows_per_page,$start);
		}
        
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }
}

?>
