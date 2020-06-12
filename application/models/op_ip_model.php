<?php 
class op_ip_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
function get_dist_summary(){
		
		$hospital=$this->session->userdata('hospital');
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
                if($this->input->post('from_time') && $this->input->post('to_time')){
			$from_time=date("H:i",strtotime($this->input->post('from_time')));
			$to_time=date("H:i",strtotime($this->input->post('to_time')));
				$this->db->where("(admit_time BETWEEN '$from_time' AND '$to_time')");
		}
		else if($this->input->post('from_time') || $this->input->post('to_time')){
			if($this->input->post('from_time')){
                            $from_time=$this->input->post('from_time');
                            $to_time = '23:59';
                        }else{ 
                            $from_time = '00:00';
                            $to_time=$this->input->post('to_time');                        
                        }			
			$this->db->where("(admit_time BETWEEN '$from_time' AND '$to_time')");
		}
		else{
			$this->db->where("(admit_time BETWEEN '00:00' AND '23:59')");
		}
		if($this->input->post('visit_name')){
			$this->db->where('patient_visit.visit_name_id',$this->input->post('visit_name'));
		}
		
		if($this->input->post('department')){
			$this->db->where('patient_visit.department_id',$this->input->post('department'));
		}
		if($this->input->post('unit')){
			$this->db->select('IF(unit!="",unit,0) unit',false);
			$this->db->where('patient_visit.unit',$this->input->post('unit'));
		}
		else{
			$this->db->select('"0" as unit',false);
		}
		if($this->input->post('report_type')==1){
				$this->db->where('visit_type','OP');
		}
		else{
			$this->db->where('visit_type','IP');
		}
		if($this->input->post('district')){
				$this->db->where('patient.district_id',$this->input->post('district'));
		}
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('patient_visit.area',$this->input->post('area'));
		}
		else{
			$this->db->select('"0" as area',false);
		}
		$this->db->select("          department 'department', district.district 'district',   district.district_id, district.latitude , district.longitude,
          SUM(CASE WHEN 1  THEN 1 ELSE 0 END) 'total',
		SUM(CASE WHEN gender = 'F'  THEN 1 ELSE 0 END) 'female',
	    SUM(CASE WHEN gender = 'M'  THEN 1 ELSE 0 END) 'male',	
		SUM(CASE WHEN age_years <= 14 THEN 1 ELSE 0 END) 'child',	
		  SUM(CASE WHEN gender = 'F' AND age_years <= 14 THEN 1 ELSE 0 END) 'fchild',
		  SUM(CASE WHEN gender = 'M' AND age_years <= 14 THEN 1 ELSE 0 END) 'mchild',
		  SUM(CASE WHEN age_years > 14 AND age_years <= 30 THEN 1 ELSE 0 END) 'p14to30',
		  SUM(CASE WHEN gender = 'F' AND age_years > 14 AND age_years <= 30 THEN 1 ELSE 0 END) 'f14to30',
		  SUM(CASE WHEN gender = 'M' AND age_years > 14 AND age_years <= 30 THEN 1 ELSE 0 END) 'm14to30', 
		  SUM(CASE WHEN age_years > 30 AND age_years < 60 THEN 1 ELSE 0 END) 'p30to60',
		SUM(CASE WHEN gender = 'F' AND age_years > 30 AND age_years < 60 THEN 1 ELSE 0 END) 'f30to60',
		  SUM(CASE WHEN gender = 'M' AND age_years > 30 AND age_years < 60 THEN 1 ELSE 0 END) 'm30to60', 
		SUM(CASE WHEN age_years >= 60 THEN 1 ELSE 0 END) 'p60plus',
		SUM(CASE WHEN gender = 'F' AND age_years >= 60 THEN 1 ELSE 0 END) 'f60plus',
		  SUM(CASE WHEN gender = 'M' AND age_years > 60 THEN 1 ELSE 0 END) 'm60plus'");
		 $this->db->from('patient_visit')->join('patient','patient_visit.patient_id=patient.patient_id')
		 ->join('department','patient_visit.department_id=department.department_id')
		 ->join('unit','patient_visit.unit=unit.unit_id','left')
		 ->join('area','patient_visit.area=area.area_id','left')
		 ->join('hospital','patient_visit.hospital_id=hospital.hospital_id','left')
		 ->join('district','patient.district_id=district.district_id','left')
		 ->where('patient_visit.hospital_id',$hospital['hospital_id'])
		 ->where("(admit_date BETWEEN '$from_date' AND '$to_date')")
		 ->group_by('district')->order_by('total','desc');
		 
		$resource=$this->db->get();
		
		return $resource->result();
	}
}	