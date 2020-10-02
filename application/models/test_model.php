<?php
class test_model extends CI_Model{

  function __construct(){
		parent::__construct();
	}

  function appointment(){
		
    $this->db->select("p.patient_id, p.address, hosp_file_no, pv.visit_id, CONCAT(IF(p.first_name=NULL,'',p.first_name),' ',IF(p.last_name=NULL,'',p.last_name)) name,
		p.gender, IF(p.gender='F' AND (father_name IS NULL OR father_name = ''),spouse_name, father_name) parent_spouse, age_years, age_months, age_days,
		p.place, p.phone, department, admit_date, admit_time, CONCAT(doctor.first_name, ' ', doctor.last_name) as doctor, 
		CONCAT(volunteer.first_name, ' ', volunteer.last_name) as volunteer, pv.appointment_with as appointment_with_id,
		IF(pv.signed_consultation=0, CONCAT(appointment_with.first_name, ' ', appointment_with.last_name), '') as appointment_with,
		IF(pv.signed_consultation=0, '', pv.summary_sent_time) as summary_sent_time,
		pv.appointment_time as appointment_date_time,
		IF(pv.signed_consultation=0, DATE(appointment_time), '') as appointment_date,
		IF(pv.signed_consultation=0, TIME(appointment_time), '') as appointment_time,
		CONCAT(appointment_update_by.first_name, ' ', appointment_update_by.last_name) as appointment_update_by,
		appointment_update_time,  
		pv.signed_consultation as signed",false);
		 $this->db->from('patient_visit as pv')
		 ->join('patient as p','pv.patient_id=p.patient_id')
		 ->join('department','pv.department_id=department.department_id','left')
		 ->join('unit','pv.unit=unit.unit_id','left')
		 ->join('area','pv.area=area.area_id','left')
		 ->join('hospital','pv.hospital_id=hospital.hospital_id','left')
		 ->join('staff as doctor','pv.signed_consultation=doctor.staff_id','left')
		 ->join('staff as appointment_with','pv.appointment_with=appointment_with.staff_id','left')
		 ->join('staff as appointment_update_by','pv.appointment_update_by=appointment_update_by.staff_id','left')	 
		 ->join('user as volunteer_user','p.insert_by_user_id = volunteer_user.user_id','left')
		 ->join('staff as volunteer','volunteer_user.staff_id=volunteer.staff_id','left')		
		 ->where('pv.hospital_id',428)
		 ->where('visit_type','OP')
		 ->where("(admit_date BETWEEN '2020-09-26' AND '2020-09-26')"); 
		 $this->db->order_by('admit_date','ASC');
		 $this->db->order_by('admit_time','ASC');
			
		$resource=$this->db->get(); // runs the selection query and returns the result
		return $resource->result();
	}

}
?>
