<?php
class Reports_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function get_op_summary(){
		$hospital=$this->session->userdata('hospital');
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')
			?$from_date=$this->input->post('from_date'):$from_date=$this->input->post('to_date');
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
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('patient_visit.area',$this->input->post('area'));
		}
		else{
			$this->db->select('"0" as area',false);
		}
		//moved 30 to 60 interval --> 22 Dec 18 -->gokulakrishna@yousee.in
		$this->db->select("(CASE when `department` IS NULL or department='' then 'Not Set' else department end) as 'department',
          SUM(CASE WHEN 1  THEN 1 ELSE 0 END) 'op',
		SUM(CASE WHEN gender = 'F'  THEN 1 ELSE 0 END) 'op_female',
		SUM(CASE WHEN gender = 'M'  THEN 1 ELSE 0 END) 'op_male',
		SUM(CASE WHEN age_years <= 14 THEN 1 ELSE 0 END) 'op_child',
		  SUM(CASE WHEN gender = 'F' AND age_years <= 14 THEN 1 ELSE 0 END) 'op_fchild',
		  SUM(CASE WHEN gender = 'M' AND age_years <= 14 THEN 1 ELSE 0 END) 'op_mchild',
		  SUM(CASE WHEN age_years > 14 AND age_years <= 30 THEN 1 ELSE 0 END) 'op_14to30',
		  SUM(CASE WHEN gender = 'F' AND age_years > 14 AND age_years < 30 THEN 1 ELSE 0 END) 'op_f14to30',	
		  SUM(CASE WHEN gender = 'M' AND age_years > 14 AND age_years < 30 THEN 1 ELSE 0 END) 'op_m14to30',
		  SUM(CASE WHEN age_years >= 30 AND age_years < 60 THEN 1 ELSE 0 END) 'op_30to60',
		SUM(CASE WHEN gender = 'F' AND age_years >= 30 AND age_years < 60 THEN 1 ELSE 0 END) 'op_f30to60',
		  SUM(CASE WHEN gender = 'M' AND age_years >= 30 AND age_years < 60 THEN 1 ELSE 0 END) 'op_m30to60',
		SUM(CASE WHEN age_years >= 60 THEN 1 ELSE 0 END) 'op_60plus',
		SUM(CASE WHEN gender = 'F' AND age_years >= 60 THEN 1 ELSE 0 END) 'op_f60plus',
		  SUM(CASE WHEN gender = 'M' AND age_years >= 60 THEN 1 ELSE 0 END) 'op_m60plus'");
		 $this->db->from('patient_visit')->join('patient','patient_visit.patient_id=patient.patient_id')
		 ->join('department','patient_visit.department_id=department.department_id','left')
		 ->join('unit','patient_visit.unit=unit.unit_id','left')
		 ->join('area','patient_visit.area=area.area_id','left')
		 ->join('hospital','patient_visit.hospital_id=hospital.hospital_id','left')
		 ->where('patient_visit.hospital_id',$hospital['hospital_id'])
		 ->where('visit_type','OP')
		 ->where("(admit_date BETWEEN '$from_date' AND '$to_date')")
		 ->group_by('department');

		$resource=$this->db->get();
		
		return $resource->result();
	}
	function get_ip_summary(){
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
            $this->db->join('patient_visit pv','patient_visit.patient_id = pv.patient_id');
			$this->db->where('pv.visit_name_id',$this->input->post('visit_name'));
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
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('patient_visit.area',$this->input->post('area'));
		}
		else{
			$this->db->select('"0" as area',false);
		}
		//moved 30 to 60 interval --> 22 Dec 18 -->gokulakrishna@yousee.in
		$this->db->select("department.department_id,patient_visit.visit_name_id, department 'department',
          SUM(CASE WHEN 1  THEN 1 ELSE 0 END) 'ip',
		SUM(CASE WHEN gender = 'F'  THEN 1 ELSE 0 END) 'ip_female',
		SUM(CASE WHEN gender = 'M'  THEN 1 ELSE 0 END) 'ip_male',
		SUM(CASE WHEN age_years <= 14 THEN 1 ELSE 0 END) 'ip_child',
		  SUM(CASE WHEN gender = 'F' AND age_years <= 14 THEN 1 ELSE 0 END) 'ip_fchild',
		  SUM(CASE WHEN gender = 'M' AND age_years <= 14 THEN 1 ELSE 0 END) 'ip_mchild',
		  SUM(CASE WHEN age_years > 14 AND age_years <= 30 THEN 1 ELSE 0 END) 'ip_14to30',
		  SUM(CASE WHEN gender = 'F' AND age_years > 14 AND age_years < 30 THEN 1 ELSE 0 END) 'ip_f14to30',
		  SUM(CASE WHEN gender = 'M' AND age_years > 14 AND age_years < 30 THEN 1 ELSE 0 END) 'ip_m14to30',
		  SUM(CASE WHEN age_years > 30 AND age_years < 60 THEN 1 ELSE 0 END) 'ip_30to60',
		SUM(CASE WHEN gender = 'F' AND age_years >= 30 AND age_years < 60 THEN 1 ELSE 0 END) 'ip_f30to60',
		  SUM(CASE WHEN gender = 'M' AND age_years >= 30 AND age_years < 60 THEN 1 ELSE 0 END) 'ip_m30to60',
		SUM(CASE WHEN age_years >= 60 THEN 1 ELSE 0 END) 'ip_60plus',
		SUM(CASE WHEN gender = 'F' AND age_years >= 60 THEN 1 ELSE 0 END) 'ip_f60plus',
		  SUM(CASE WHEN gender = 'M' AND age_years >= 60 THEN 1 ELSE 0 END) 'ip_m60plus'");
		 $this->db->from('patient_visit')->join('patient','patient_visit.patient_id=patient.patient_id')
		 ->join('department','patient_visit.department_id=department.department_id','left')
		 ->join('unit','patient_visit.unit=unit.unit_id','left')
		 ->join('area','patient_visit.area=area.area_id','left')
		 ->join('visit_name','patient_visit.visit_name_id=visit_name.visit_name_id','left')
		 ->join('hospital','patient_visit.hospital_id=hospital.hospital_id','left')
		 ->where('patient_visit.hospital_id',$hospital['hospital_id'])
		 ->where('patient_visit.visit_type','IP')
		 ->where("(patient_visit.admit_date BETWEEN '$from_date' AND '$to_date')")
		 ->group_by('department');

		$resource=$this->db->get();
		return $resource->result();
	}

	function get_icd_summary(){
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
		if($this->input->post('visit_name')){
			$this->db->where('patient_visit.visit_name_id',$this->input->post('visit_name'));
		}
		if($this->input->post('icd_code')){
			$icd_code = substr($this->input->post('icd_code'),0,strpos($this->input->post('icd_code')," "));
			$this->db->where('icd_code.icd_code',$icd_code);
		}
		if($this->input->post('icd_block')){
			$this->db->where('icd_block.block_id',$this->input->post('icd_block'));
		}
		if($this->input->post('icd_chapter')){
			$this->db->where('icd_chapter.chapter_id',$this->input->post('icd_chapter'));
		}
        //Selection of visit type OP/IP
		if($this->input->post('visit_type')){
			$this->db->where('patient_visit.visit_type',$this->input->post('visit_type'));
		}
		else
			$this->db->where('patient_visit.visit_type','IP');
		if($this->input->post('department')){
			$this->db->select('patient_visit.department_id',false);
			$this->db->where('patient_visit.department_id',$this->input->post('department'));
		}
		else{
			$this->db->select('"-1" as department_id',false);
		}
		if($this->input->post('unit')){
			$this->db->select('IF(unit!="",unit,0) unit',false);
			$this->db->where('patient_visit.unit',$this->input->post('unit'));
		}
		else{
			$this->db->select('"0" as unit',false);
		}
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('patient_visit.area',$this->input->post('area'));
		}
		else{
			$this->db->select('"0" as area',false);
		}
		$this->db->select("patient_visit.icd_10,code_title,icd_code.block_id, block_title,
		icd_block.chapter_id, chapter_title, patient_visit.visit_name_id, department 'department',
                patient.district_id,
          SUM(CASE WHEN 1  THEN 1 ELSE 0 END) 'total',
		SUM(CASE WHEN gender = 'F'  THEN 1 ELSE 0 END) 'female',
		SUM(CASE WHEN gender = 'M'  THEN 1 ELSE 0 END) 'male',
        SUM(CASE WHEN outcome = 'Discharge' THEN 1 ELSE 0 END) 'total_discharge',
        SUM(CASE WHEN outcome = 'LAMA' THEN 1 ELSE 0 END) 'total_lama',
        SUM(CASE WHEN outcome = 'Absconded' THEN 1 ELSE 0 END) 'total_absconded',
        SUM(CASE WHEN outcome = 'Death' THEN 1 ELSE 0 END) 'total_death',
        SUM(CASE WHEN outcome!='Discharge' AND outcome!='LAMA' AND outcome!='Absconded' AND outcome!= 'Death' THEN 1 ELSE 0 END) 'total_unupdated'");
		 $this->db->from('patient_visit')->join('patient','patient_visit.patient_id=patient.patient_id')
		 ->join('department','patient_visit.department_id=department.department_id','left')
		 ->join('unit','patient_visit.unit=unit.unit_id','left')
		 ->join('area','patient_visit.area=area.area_id','left')
		 ->join('visit_name','patient_visit.visit_name_id=visit_name.visit_name_id','left')
		 ->join('icd_code','patient_visit.icd_10=icd_code.icd_code','left')
		 ->join('icd_block','icd_code.block_id=icd_block.block_id','left')
		 ->join('icd_chapter','icd_block.chapter_id=icd_chapter.chapter_id','left')
		 ->join('hospital','patient_visit.hospital_id=hospital.hospital_id','left')
		 ->where('patient_visit.hospital_id',$hospital['hospital_id'])
		 ->where("(admit_date BETWEEN '$from_date' AND '$to_date')")
		 ->group_by('icd_10');
		$resource=$this->db->get();
		return $resource->result();
	}

	function get_order_summary($type){
		$hospital=$this->session->userdata('hospital');
		if($type == "department"){
			$this->db->select('department.department,department.department_id as department_id');
			$this->db->group_by('department.department_id');
		}
		else{
			$this->db->select('test_area as department, test_area.test_area_id as department_id');
		}
		if($this->input->post('visit_type')){
			$this->db->where('patient_visit.visit_type',$this->input->post('visit_type'));
		}
		if($this->input->post('department')){
			$this->db->where('patient_visit.department_id',$this->input->post('department'));
		}
		if($this->input->post('unit')){
			$this->db->select('IF(unit!="",unit,0) unit');
			$this->db->where('patient_visit.unit',$this->input->post('unit'));
		}
		else{
			$this->db->select('"0" as unit',false);
		}
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area');
			$this->db->where('patient_visit.area',$this->input->post('area'));
		}
		else{
			$this->db->select('"0" as area',false);
		}
		if($this->input->post('lab_department')){
			$this->db->where('test_order.test_area_id',$this->input->post('lab_department'));
		}
		if($this->input->post('specimen_type')){
			$this->db->select('test_sample.specimen_type_id');
			$this->db->where('test_sample.specimen_type_id',$this->input->post('specimen_type'));
		}
		else{
			$this->db->select('"0" as specimen_type_id',false);
		}
		if($this->input->post('test_method')){
			$this->db->where('test_method.test_method_id',$this->input->post('test_method'));
		}
		if($this->input->post('patient_number')){
			$this->db->where('patient_visit.hosp_file_no',$this->input->post('patient_number'));
		}
		if($this->input->post('test_master')){
			$this->db->where('test.test_master_id',$this->input->post('test_master'));
		}
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
		$this->db->select("test_method,test_id,
		SUM(CASE WHEN test.test_status IN (0,1,2,3) THEN 1 ELSE 0 END) tests_ordered,
		SUM(CASE WHEN test.test_status IN (1,2,3) THEN 1 ELSE 0 END) tests_completed,
		SUM(CASE WHEN test.test_status = 2 THEN 1 ELSE 0 END) tests_reported,
		SUM(CASE WHEN test.test_status = 3 THEN 1 ELSE 0 END) tests_rejected,
		test_method.test_method_id,test_master.test_master_id,test_master.test_name,test_area.test_area_id",false)
		->from('test_order')
		->join('test_sample','test_order.order_id = test_sample.order_id','left')
		->join('patient_visit','test_order.visit_id = patient_visit.visit_id')
		->join('department','patient_visit.department_id = department.department_id')
		->join('test_area','test_order.test_area_id = test_area.test_area_id')
		->join('test','test_order.order_id = test.order_id','left')
		->join('test_master','test.test_master_id = test_master.test_master_id')
		->join('test_method','test_master.test_method_id = test_method.test_method_id')
		->where("(DATE(order_date_time) BETWEEN '$from_date' AND '$to_date')")
		->where('test_order.hospital_id',$hospital['hospital_id'])
		->group_by('test_method.test_method,test_master.test_master_id');
		$resource=$this->db->get();

		return $resource->result();
	}

	function get_op_detail(){
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
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('patient_visit.area',$this->input->post('area'));
		}
		else{
			$this->db->select('"0" as area',false);
		}

		$this->db->select("patient.patient_id, patient.address, hosp_file_no,patient_visit.visit_id,CONCAT(IF(first_name=NULL,'',first_name),' ',IF(last_name=NULL,'',last_name)) name,
		gender,IF(gender='F' AND (father_name IS NULL OR father_name = ''),spouse_name,father_name) parent_spouse,unit_name,area_name,
		age_years,age_months,age_days,patient.place,phone,department,unit_name,area_name, admit_date, admit_time, mlc_number, mlc_number_manual",false);
		 $this->db->from('patient_visit')
		 ->join('patient','patient_visit.patient_id=patient.patient_id')
		 ->join('mlc','mlc.visit_id=patient_visit.visit_id','left')
		 ->join('department','patient_visit.department_id=department.department_id','left')
		 ->join('unit','patient_visit.unit=unit.unit_id','left')
		 ->join('area','patient_visit.area=area.area_id','left')
		 ->join('hospital','patient_visit.hospital_id=hospital.hospital_id','left')
		 ->where('patient_visit.hospital_id',$hospital['hospital_id'])
		 ->where('visit_type','OP')
		 ->where("(admit_date BETWEEN '$from_date' AND '$to_date')");
		$resource=$this->db->get();
		return $resource->result();
	}

function get_op_detail_with_idproof(){
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
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('patient_visit.area',$this->input->post('area'));
		}
		else{
			$this->db->select('"0" as area',false);
		}

		$this->db->select("patient.patient_id, patient.address, hosp_file_no,patient_id_manual,id_proof_type,patient.id_proof_number,patient_visit.visit_id,CONCAT(IF(first_name=NULL,'',first_name),' ',IF(last_name=NULL,'',last_name)) name,
		gender,IF(gender='F' AND (father_name IS NULL OR father_name = ''),spouse_name,father_name) parent_spouse,unit_name,area_name,
		age_years,age_months,age_days,patient.place,phone,department,unit_name,area_name, admit_date, admit_time, mlc_number, mlc_number_manual",false);
		 $this->db->from('patient_visit')
		 ->join('patient','patient_visit.patient_id=patient.patient_id')
		 ->join('id_proof_type','patient.id_proof_type_id=id_proof_type.id_proof_type_id','left')
		 ->join('mlc','mlc.visit_id=patient_visit.visit_id','left')
		 ->join('department','patient_visit.department_id=department.department_id','left')
		 ->join('unit','patient_visit.unit=unit.unit_id','left')
		 ->join('area','patient_visit.area=area.area_id','left')
		 ->join('hospital','patient_visit.hospital_id=hospital.hospital_id','left')
		 ->where('patient_visit.hospital_id',$hospital['hospital_id'])
		 ->where('visit_type','OP')
		 ->where("(admit_date BETWEEN '$from_date' AND '$to_date')");
		$resource=$this->db->get();
		return $resource->result();
	}
	
	
	
	function get_helpline_doctor(){
		$hospital=$this->session->userdata('hospital');
		
		$this->db->select("staff.staff_id, CONCAT( department.department, ' - ',staff.first_name, ' ', staff.last_name, ', ', staff.phone) as helpline_doctor,
				department.department as department", false);
		 $this->db->from('helpline_receiver')
		 ->join('hospital','hospital.helpline_id=helpline_receiver.helpline_id','left') 
		 ->join('user','user.user_id=helpline_receiver.user_id','left')
		 ->join('staff','staff.staff_id=user.staff_id','left')
		 ->join('department','department.department_id=staff.department_id','left')	 
		 ->where('hospital.hospital_id',$hospital['hospital_id'])
		 ->where('helpline_receiver.doctor',1);
		 $this->db->order_by('department','ASC');
		 $this->db->order_by('helpline_doctor','ASC');
		
		$resource=$this->db->get();
		return $resource->result();
		
	}
	
	function get_appointment(){
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
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('patient_visit.area',$this->input->post('area'));
		}
		else{
			$this->db->select('"0" as area',false);
		}

		$this->db->select("p.patient_id, p.address, hosp_file_no, pv.visit_id, CONCAT(IF(p.first_name=NULL,'',p.first_name),' ',IF(p.last_name=NULL,'',p.last_name)) name,
		p.gender, IF(p.gender='F' AND (father_name IS NULL OR father_name = ''),spouse_name, father_name) parent_spouse, age_years, age_months, age_days,
		p.place, p.phone, department, admit_date, admit_time, CONCAT(doctor.first_name, ' ', doctor.last_name) as doctor, 
		CONCAT(volunteer.first_name, ' ', volunteer.last_name) as volunteer, pv.appointment_with as appointment_with_id,
		IF(pv.signed_consultation=0, CONCAT(appointment_with.first_name, ' ', appointment_with.last_name), '') as appointment_with,
		IF(pv.signed_consultation=0, '', pv.summary_sent_time) as summary_sent_time,
		pv.appointment_time as appointment_date_time,
		IF(pv.signed_consultation=0, DATE(appointment_time), '') as appointment_date,
		IF(pv.signed_consultation=0, TIME(appointment_time), '') as appointment_time,
		IF(pv.signed_consultation=0, CONCAT(appointment_update_by.first_name, ' ', appointment_update_by.last_name),'') as appointment_update_by,
		IF(pv.signed_consultation=0, appointment_update_time,'') as appointment_update_time,  
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
		 ->where('pv.hospital_id',$hospital['hospital_id'])
		 ->where('visit_type','OP')
		 ->where("(admit_date BETWEEN '$from_date' AND '$to_date')"); 
		 $this->db->order_by('admit_date','ASC');
		 $this->db->order_by('admit_time','ASC');
			
		$resource=$this->db->get();
		return $resource->result();
	}

	function update_appointment(){
        $appointment_info = array();
        if($this->input->post('department_id')){
            $appointment_info['department_id'] = $this->input->post('department_id');
        }
        if($this->input->post('appointment_with')){
            $appointment_info['appointment_with'] = $this->input->post('appointment_with');
        }
        if($this->input->post('appointment_time')){
            $appointment_info['appointment_time'] = $this->input->post('appointment_time');
        }
         if($this->input->post('summary_sent_time')){
            $appointment_info['summary_sent_time'] = $this->input->post('summary_sent_time');
        }
	$appointment_info['appointment_update_by'] = $this->session->userdata('logged_in')['staff_id'];
	$appointment_info['appointment_update_time'] = date("Y-m-d H:i:s");
        $this->db->trans_start();
        $this->db->where('visit_id',$this->input->post('visit_id'));
        $this->db->update('patient_visit', $appointment_info);
        $this->db->trans_complete();
        if($this->db->trans_status()==FALSE){
                return false;
        	}
        else{
                return true;
        	} 
    	}
	
	function get_doctor_patient_list(){
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
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('patient_visit.area',$this->input->post('area'));
		}
		else{
			$this->db->select('"0" as area',false);
		}
						
		$this->db->select("p.patient_id, p.address, hosp_file_no, pv.visit_id, CONCAT(IF(p.first_name=NULL,'',p.first_name),' ',IF(p.last_name=NULL,'',p.last_name)) name,
		p.gender, IF(p.gender='F' AND (father_name IS NULL OR father_name = ''),spouse_name, father_name) parent_spouse, age_years, age_months, age_days,
		p.place, p.phone, department, admit_date, admit_time, CONCAT(doctor.first_name, ' ', doctor.last_name) as doctor, 
		CONCAT(volunteer.first_name, ' ', volunteer.last_name) as volunteer, pv.appointment_with as appointment_with_id,
		IF(pv.signed_consultation=0, CONCAT(appointment_with.first_name, ' ', appointment_with.last_name), '') as appointment_with,
		IF(pv.signed_consultation=0, '', pv.summary_sent_time) as summary_sent_time,
		pv.appointment_time as appointment_date_time,
		IF(pv.signed_consultation=0, DATE(appointment_time), '') as appointment_date,
		IF(pv.signed_consultation=0, TIME(appointment_time), '') as appointment_time,
		IF(pv.signed_consultation=0, CONCAT(appointment_update_by.first_name, ' ', appointment_update_by.last_name),'') as appointment_update_by,
		IF(pv.signed_consultation=0, appointment_update_time,'') as appointment_update_time,  
		pv.signed_consultation as signed",false);
		
		$this->db->from('patient_visit as pv');
		$this->db->join('patient as p','pv.patient_id=p.patient_id');
		$this->db->join('department','pv.department_id=department.department_id','left');
		$this->db->join('unit','pv.unit=unit.unit_id','left');
		$this->db->join('area','pv.area=area.area_id','left');
		$this->db->join('hospital','pv.hospital_id=hospital.hospital_id','left');
		$this->db->join('staff as doctor','pv.signed_consultation=doctor.staff_id','left');
		$this->db->join('staff as appointment_with','pv.appointment_with=appointment_with.staff_id','left');
		$this->db->join('staff as appointment_update_by','pv.appointment_update_by=appointment_update_by.staff_id','left');	 
		$this->db->join('user as volunteer_user','p.insert_by_user_id = volunteer_user.user_id','left');
		$this->db->join('staff as volunteer','volunteer_user.staff_id=volunteer.staff_id','left');
		
		$current_hospital = $hospital['hospital_id'];
		$user_staff_id = $this->session->userdata('logged_in')['staff_id'];
		
		$where = "pv.hospital_id = $current_hospital
			  AND visit_type = 'OP'
			  AND (admit_date BETWEEN '$from_date' AND '$to_date')
			  AND (pv.appointment_with = $user_staff_id OR pv.signed_consultation = $user_staff_id)";
		$this->db->where($where);
		
		$this->db->order_by('admit_date','ASC');
		$this->db->order_by('admit_time','ASC');
		
		$sql = $this->db->get_compiled_select();
		echo $sql;
		
		$resource=$this->db->get();
		return $resource->result();
		
		//$query = $db->query('SELECT name, title, email FROM my_table');
		//$results = $query->getResult();
		
		
	}

	
	function get_ip_detail($department,$unit,$area,$gender,$from_age,$to_age,$from_date,$to_date,$visit_name,$date_type=0,$outcome=0){
		$hospital=$this->session->userdata('hospital');
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')?$from_date=$this->input->post('from_date'):$from_date=$this->input->post('to_date');
			$to_date=$from_date;
		}
		else if($from_date=='0' && $to_date=='0'){
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
		if(($visit_name!='-1' && $visit_name != '0') || $this->input->post('visit_name')){
			if($this->input->post('visit_name')) $visit_name = $this->input->post('visit_name');
			$this->db->where('patient_visit.visit_name_id',$visit_name);
		}
		if($department!='-1' || $this->input->post('department')){
			if($this->input->post('department')) $department=$this->input->post('department');
			$this->db->where('department.department_id',$department);
		}
		if(!!$unit || $this->input->post('unit')){
			if($this->input->post('unit')) $unit=$this->input->post('unit');
			$this->db->select('IF(unit!="",unit,0) unit',false);
			$this->db->where('patient_visit.unit',$unit);
		}
		else{
			$this->db->select('"0" as unit_id',false);
		}
		if(!!$area || $this->input->post('area')){
			if($this->input->post('area')) $area=$this->input->post('area');
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('patient_visit.area',$area);
		}
		else{
			$this->db->select('"0" as area',false);
		}
		if($gender!='0'){
			$this->db->where('gender',$gender);
		}
		if($from_age!='0' && $to_age!='0'){
			$this->db->where('age_years>=',$from_age,false);
			$this->db->where('age_years<=',$to_age,false);
		}
		if($from_age!='0' && $to_age=='0'){
			$this->db->where('age_years<=',$from_age,false);
		}
		if($from_age=='0' && $to_age!='0'){
			$this->db->where('age_years>=',$to_age,false);
		}
		if(!!$outcome || $this->input->post('outcome_type')){
			if($this->input->post('outcome_type')) $outcome = $this->input->post('outcome_type');
			if($outcome == "Unupdated") {
				$this->db->where_not_in('outcome',array('Death','Absconded','Discharge','LAMA'));
			}
			else $this->db->where('outcome', $outcome);
		}
		if($date_type == 0) {
			$this->db->where("(admit_date BETWEEN '$from_date' AND '$to_date')");
		}
		else{
			$this->db->where("($date_type BETWEEN '$from_date' AND '$to_date')");
		}

		$this->db->select("patient.patient_id, hosp_file_no,patient_visit.visit_id,CONCAT(IF(first_name=NULL,'',first_name),' ',IF(last_name=NULL,'',last_name)) name,
		gender,IF(gender='F' AND father_name ='',spouse_name,father_name) parent_spouse,
		age_years,age_months,age_days,patient.place,phone,address,admit_date,admit_time, department,unit_name,area_name,mlc_number,mlc_number_manual,
		outcome,outcome_date,outcome_time",false);
		 $this->db->from('patient_visit')->join('patient','patient_visit.patient_id=patient.patient_id')
		 ->join('department','patient_visit.department_id=department.department_id','left')
		 ->join('unit','patient_visit.unit=unit.unit_id','left')
		 ->join('area','patient_visit.area=area.area_id','left')
		 ->join('mlc','patient_visit.visit_id=mlc.visit_id','left')
		 ->join('hospital','patient_visit.hospital_id=hospital.hospital_id','left')
		 ->where('patient_visit.hospital_id',$hospital['hospital_id'])
		 ->where('visit_type','IP')
		 ->order_by('hosp_file_no','ASC');
		$resource=$this->db->get();
		return $resource->result();
	}

	function get_icd_detail($icd_10,$department,$unit,$area,$gender,$from_age,$to_age,$from_date,$to_date,$visit_name,$visit_type,$outcome){
		$hospital=$this->session->userdata('hospital');
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')?$from_date=$this->input->post('from_date'):$from_date=$this->input->post('to_date');
			$to_date=$from_date;
		}
		else if($from_date=='0' && $to_date=='0'){
			$from_date=date("Y-m-d");
			$to_date=$from_date;
		}
		if($visit_type!='0'){
			$this->db->where('patient_visit.visit_type',$visit_type);
		}
		if(!!$visit_name && $visit_name != "-1"){
			$this->db->where('patient_visit.visit_name_id',$visit_name);
		}
		if($icd_10!="0" && $icd_10 != -1){
			$this->db->where('patient_visit.icd_10',$icd_10);
		}
		if($this->input->post('icd_code')){
			$icd_code = substr($this->input->post('icd_code'),0,strpos($this->input->post('icd_code')," "));
			$this->db->where('icd_code.icd_code',$icd_code);
		}
		if($this->input->post('icd_block')){
			$this->db->where('icd_block.block_id',$this->input->post('icd_block'));
		}
		if($this->input->post('icd_chapter')){
			$this->db->where('icd_chapter.chapter_id',$this->input->post('icd_chapter'));
		}
		if($department!='-1' || $this->input->post('department')){
			if($this->input->post('department')) $department=$this->input->post('department');
			$this->db->where('department.department_id',$department);
		}
		if(!!$unit){
			if($this->input->post('unit')) $unit=$this->input->post('unit');
			$this->db->select('IF(unit!="",unit,0) unit',false);
			$this->db->where('patient_visit.unit',$unit);
		}
		else{
			$this->db->select('"0" as unit_id',false);
		}
		if(!!$area){
			if($this->input->post('area')) $area=$this->input->post('area');
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('patient_visit.area',$area);
		}
		else{
			$this->db->select('"0" as area',false);
		}
		if($gender!='0'){
			$this->db->where('gender',$gender);
		}
		if($from_age!='0' && $to_age!='0'){
			$this->db->where('age_years>=',$from_age,false);
			$this->db->where('age_years<=',$to_age,false);
		}
		if($from_age!='0' && $to_age=='0'){
			$this->db->where('age_years<=',$from_age,false);
		}
		if($from_age=='0' && $to_age!='0'){
			$this->db->where('age_years>=',$to_age,false);
		}
		if(!!$outcome || $this->input->post('outcome_type')){
			if($this->input->post('outcome_type')) $outcome = $this->input->post('outcome_type');
			if($outcome == "Unupdated") {
				$this->db->where_not_in('outcome',array('Death','Absconded','Discharge','LAMA'));
			}
			else $this->db->where('outcome', $outcome);
		}
		$this->db->select("hosp_file_no,patient_visit.visit_id,CONCAT(IF(first_name=NULL,'',first_name),' ',IF(last_name=NULL,'',last_name)) name,
		gender,IF(gender='F' AND father_name ='',spouse_name,father_name) parent_spouse,
		age_years,age_months,age_days,patient.place,phone,address,admit_date,admit_time, department,unit_name,area_name,mlc_number,icd_10,outcome,final_diagnosis,
		outcome_date,outcome_time",false);
		 $this->db->from('patient_visit')->join('patient','patient_visit.patient_id=patient.patient_id')
		 ->join('department','patient_visit.department_id=department.department_id','left')
		 ->join('unit','patient_visit.unit=unit.unit_id','left')
		 ->join('area','patient_visit.area=area.area_id','left')
		 ->join('mlc','patient_visit.visit_id=mlc.visit_id','left')
		 ->join('hospital','patient_visit.hospital_id=hospital.hospital_id','left')
		 ->where('patient_visit.hospital_id',$hospital['hospital_id'])
		 ->where("(admit_date BETWEEN '$from_date' AND '$to_date')")
		 ->order_by('hosp_file_no','ASC');
		$resource=$this->db->get();
		return $resource->result();
	}

	function get_order_detail($test_master,$department,$unit,$area,$test_area,$specimen_type,$test_method,$visit_type,$from_date,$to_date,$status,$type,$number,$antibiotic_id,$micro_organism_id,$sensitive,$outcome_type=0){
		$hospital=$this->session->userdata('hospital');
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')?$from_date=$this->input->post('from_date'):$from_date=$this->input->post('to_date');
			$to_date=$from_date;
		}
		else if($from_date=='0' && $to_date=='0'){
			$from_date=date("Y-m-d");
			$to_date=$from_date;
		}

		if($this->input->post('visit_type')){
			$this->db->where('patient_visit.visit_type',$this->input->post('visit_type'));
		}
		if($department!='-1'){
			if($type=="department"){
				$this->db->where('department.department_id',$department);
			}
			else{
				$areas=array();
				foreach($department as $area){
					$areas[]=$area->test_area_id;
				}
				$this->db->where_in('test_area.test_area_id',$areas);
			}
		}
		if($unit>0){
			$this->db->where('patient_visit.unit',$unit);
		}
		if($area>0){
			$this->db->where('patient_visit.area',$area);
		}
		if($test_area!='-1'){
			$this->db->where('test_area.test_area_id',$test_area);
		}
		if($specimen_type>0){
			$this->db->where('test_sample.specimen_type_id',$specimen_type);
		}
		if($test_method!='-1'){
			$this->db->where('test_method.test_method_id',$test_method);
		}
		if($test_master!='-1'){
			$this->db->where('test_master.test_master_id',$test_master);
		}
		if($visit_type!='0'){
			$this->db->where('patient_visit.visit_type',$visit_type);
		}
		if($number!='0'){
			$this->db->where('patient_visit.hosp_file_no',$number);
		}
		if($status!='-1'){
			if($status == 0) {
				$this->db->where_in('test.test_status',array(0,1,2,3));
			}
			else if($status == 1) {
				$this->db->where_in('test.test_status',array(1,2,3));
			}
			else
			$this->db->where('test.test_status',$status);
		}
		$this->db->select('test.*,test.test_id,test_order.order_id,order_date_time,age_years,age_months,age_days,
		test_sample.sample_id,test_method,test_name,department,patient.first_name, patient.last_name, unit_name, area_name,
		binary_result,numeric_result,text_result,
		test_result_binary,test_result_text,test_result,lab_unit,
		patient_visit.visit_id,staff.first_name staff_name,hosp_file_no,
		visit_type,sample_code,specimen_type,sample_container_type,test_status,binary_positive,binary_negative')
		->from('test_order')
		->join('test','test_order.order_id=test.order_id')
		->join('test_sample','test_order.order_id=test_sample.order_id','left')
		->join('test_master','test.test_master_id=test_master.test_master_id')
		->join('lab_unit','test_master.numeric_result_unit=lab_unit.lab_unit_id','left')
		->join('test_method','test_master.test_method_id=test_method.test_method_id')
		->join('test_area','test_master.test_area_id=test_area.test_area_id')
		->join('staff','test_order.doctor_id=staff.staff_id','left')
		->join('patient_visit','test_order.visit_id=patient_visit.visit_id')
		->join('patient','patient_visit.patient_id=patient.patient_id')
		->join('department','patient_visit.department_id=department.department_id','left')
		->join('unit','patient_visit.unit=unit.unit_id','left')
		->join('area','patient_visit.area=area.area_id','left')
		->join('specimen_type','test_sample.specimen_type_id=specimen_type.specimen_type_id','left')
		->where('test_order.hospital_id',$hospital['hospital_id'])
		 ->where("(DATE(order_date_time) BETWEEN '$from_date' AND '$to_date')")
		 ->group_by('test.test_id');

		if(!!$antibiotic_id){
			$this->db
			->join('micro_organism_test','micro_organism_test.test_id = test.test_id')
			->join('micro_organism','micro_organism_test.micro_organism_id = micro_organism.micro_organism_id')
			->join('antibiotic_test','micro_organism_test.micro_organism_test_id = antibiotic_test.micro_organism_test_id')
			->join('antibiotic','antibiotic_test.antibiotic_id = antibiotic.antibiotic_id');
			$this->db->where('antibiotic.antibiotic_id',$antibiotic_id);
			if(!!$micro_organism_id) {
			$this->db->where('micro_organism.micro_organism_id',$micro_organism_id);
			}
			if(!!$sensitive){
				$this->db->where('antibiotic_test.antibiotic_result',1);
			}
		}
		$query=$this->db->get();
		return $query->result();
	}
	function get_service_records() {
			if($this->input->post('department')){
			$this->db->where('equipment.department_id',$this->input->post('department'));
		}
		if($this->input->post('equipment_type')){
			$this->db->where('equipment.equipment_type_id',$this->input->post('equipment_type'));
		}
		if($this->input->post('working_status')!=NULL){
			$this->db->where('service_record.working_status',$this->input->post('working_status'));
		}
		$this->db->select("equipment.equipment_id,vendor.vendor_id,service_record.vendor_id,contact_person.contact_person_id,equipment.equipment_type_id,equipment_type,equipment.department_id,request_id,call_date,call_time,call_information_type,call_information,service_person_remarks,service_date,vendor_name,contact_person_first_name,service_time,problem_status,working_status
		")
		->from("service_record")
		->join("equipment","service_record.equipment_id=equipment.equipment_id",'left')
		->join("equipment_type","equipment.equipment_type_id=equipment_type.equipment_type_id",'left')
		->join("department","equipment.department_id=department.department_id",'left' )
		->join("vendor","service_record.vendor_id=vendor.vendor_id",'left')
		->join("contact_person","service_record.contact_person_id=contact_person.contact_person_id",'left')
		->order_by("equipment_id");
		$query=$this->db->get();
		return $query->result();

		}
	function get_equipment_summary(){


		if($this->input->post('department')){
			$this->db->where('equipment.department_id',$this->input->post('department'));
		}
		if($this->input->post('unit')){
			$this->db->where('equipment.unit_id',$this->input->post('unit'));
		}
		if($this->input->post('area')){
			$this->db->where('equipment.area_id',$this->input->post('area'));
		}
		if($this->input->post('equipment_status')!=NULL){
			$this->db->where('equipment.equipment_status',$this->input->post('equipment_status'));
		}
		if($this->input->post('equipment_type')){
			$this->db->where('equipment.equipment_type_id',$this->input->post('equipment_type'));
		}
		$this->db->select("equipment.equipment_type_id,equipment_type,equipment.department_id,department,equipment.area_id,area_name,equipment.unit_id,unit_name,equipment_status,equipment_id,make,model,
		SUM(CASE WHEN 1 THEN 1 ELSE 0 END) 'total',
		SUM(CASE WHEN equipment_status=1 THEN 1 ELSE 0 END) 'total_working',
		SUM(CASE WHEN equipment_status=0 THEN 1 ELSE 0 END) 'total_not_working'
		")
		->from("equipment")
		->join("equipment_type","equipment.equipment_type_id=equipment_type.equipment_type_id")
		->join("department","equipment.department_id=department.department_id")
		->join("unit","equipment.unit_id=unit.unit_id","left")
		->join("area","equipment.area_id=area.area_id","left")
		->group_by("equipment_type,department,equipment.area_id,equipment.unit_id")
		->order_by("equipment_type");
		$query=$this->db->get();
		return $query->result();

	}

	function get_sensitivity_summary(){
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
		if($this->input->post('micro_organism')){
			$this->db->where_in('micro_organism.micro_organism_id',$this->input->post('micro_organism'));
		}
		if($this->input->post('antibiotic')){
			$this->db->where_in('antibiotic.antibiotic_id',$this->input->post('antibiotic'));
		}
		if($this->input->post('visit_type')){
			$this->db->where('patient_visit.visit_type',$this->input->post('visit_type'));
		}
		if($this->input->post('department')){
			$this->db->where('patient_visit.department_id',$this->input->post('department'));
		}
		if($this->input->post('unit')){
			$this->db->where('patient_visit.unit',$this->input->post('unit'));
		}
		if($this->input->post('area')){
			$this->db->where('patient_visit.area',$this->input->post('area'));
		}
		if($this->input->post('specimen_type')){
			$this->db->where('test_sample.specimen_type_id',$this->input->post('specimen_type'));
		}

		$this->db->select('antibiotic_test.antibiotic_result,antibiotic,micro_organism,antibiotic.antibiotic_id,micro_organism.micro_organism_id,
			test_area.department_id,unit,area,test_sample.specimen_type_id,test.test_id,test.test_result_binary,test_order.test_area_id',false)
			->from('test')
			->join('test_order',"test.order_id = test_order.order_id AND (DATE(order_date_time) BETWEEN '$from_date' AND '$to_date')",'left')
			->join('micro_organism_test','micro_organism_test.test_id = test.test_id','left')
			->join('test_master','test_master.test_master_id = test.test_master_id')
			->join('test_method','test_method.test_method_id = test_master.test_method_id')
			->join('test_area','test_area.test_area_id = test_master.test_area_id')
			->join('micro_organism','micro_organism_test.micro_organism_id = micro_organism.micro_organism_id')
			->join('antibiotic_test','antibiotic_test.micro_organism_test_id=micro_organism_test.micro_organism_test_id','left')
			->join('antibiotic','antibiotic_test.antibiotic_id = antibiotic.antibiotic_id')
			->join('test_sample','test_order.order_id = test_sample.order_id')
			->join('specimen_type','test_sample.specimen_type_id = specimen_type.specimen_type_id')
			->join('patient_visit','test_order.visit_id = patient_visit.visit_id')
			->join('patient','patient_visit.patient_id = patient.patient_id')
			->where('test_area.test_area','Microbiology')
			->where('test_method.test_method','Culture and Sensitivity')
			->where('test_order.hospital_id',$hospital['hospital_id'])
			->where('test.test_status',2);
			$query=$this->db->get();
		return $query->result();
	}

	function get_audiology_summary(){
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
		if($this->input->post('department')){
			$this->db->where('patient_visit.department_id',$this->input->post('department'));
		}
		if($this->input->post('unit')){
			$this->db->where('patient_visit.unit',$this->input->post('unit'));
		}
		if($this->input->post('area')){
			$this->db->where('patient_visit.area',$this->input->post('area'));
		}
		if($this->input->post('date_type') == 'Order'){
			$this->db->where('(DATE(test_order.order_date_time) BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}
		else{
			$this->db->where('(patient_visit.admit_date BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}

		$this->db->select('test_name,patient_visit.visit_id,test_master.test_master_id,department.department_id,area.area_id,unit.unit_id,area_name,unit.unit_name,test_result_binary',false)
			->from('test')
			->join('test_order','test.order_id = test_order.order_id')
			->join('test_master','test.test_master_id = test_master.test_master_id')
			->join('patient_visit','test_order.visit_id = patient_visit.visit_id')
			->join('patient','patient_visit.patient_id = patient.patient_id')
			->join('department','patient_visit.department_id = department.department_id')
			->join('area','patient_visit.area = area.area_id','left')
			->join('unit','patient_visit.unit = unit.unit_id','left')
			->where('test.test_status',2)
			->where('test_order.hospital_id',$hospital['hospital_id'])
			->where_in('test_name',array('Left OAE','Right OAE'));
			$query=$this->db->get();
		return $query->result();
	}

        // This function is used to build a query from the form sent by ip_op_trend page, and retrive data accordingly.
        // This function is used to get number of OP/IP patients during a specified period, in days, months and years.
        // This function returns an array of objects containing the records from the database.
    function get_ip_op_trends(){
			$hospital=$this->session->userdata('hospital');
            //First time ip_op_trends page is opened all records for today will be opened.
            /*Query is being built from the data input from the user*/

            //Selection of the date field.
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
                //Selection of the visit name.
		if($this->input->post('visit_name')){
			$this->db->where('patient_visit.visit_name_id',$this->input->post('visit_name'));
		}
                //Selection of visit type OP/IP
		if($this->input->post('visit_type')){
			$this->db->where('patient_visit.visit_type',$this->input->post('visit_type'));
                }
                else{
                    $this->db->where('patient_visit.visit_type', 'OP');
                }
                //Report for day or month or year.
		if($this->input->post('trend_type')){
                        $trend = $this->input->post('trend_type');
                        if($trend=="Month"){
                            $this->db->select('patient_visit.admit_date date',false);
                            $this->db->group_by('MONTH(patient_visit.admit_date),YEAR(patient_visit.admit_date)');
                        }
                        else if($trend=="Year"){
                            $this->db->select('YEAR(patient_visit.admit_date) date');
                            $this->db->group_by('YEAR(patient_visit.admit_date)');
                        }
                        else{
                            $this->db->select('patient_visit.admit_date date');
                            $this->db->group_by('patient_visit.admit_date');
                        }
		}
                        else{
                            $this->db->select('patient_visit.admit_date date');
                            $this->db->group_by('patient_visit.admit_date');
                        }
                 //Setting the selected department in the query. First time all the departments are selected.
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
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('patient_visit.area',$this->input->post('area'));
		}
		else{
			$this->db->select('"0" as area',false);
		}
                //Counting the number of patients gender wise.
		$this->db->select("
          SUM(CASE WHEN 1  THEN 1 ELSE 0 END) 'total',
		SUM(CASE WHEN gender = 'F'  THEN 1 ELSE 0 END) 'female',
		SUM(CASE WHEN gender = 'M'  THEN 1 ELSE 0 END) 'male',
		SUM(CASE WHEN signed_consultation > 0 THEN 1 ELSE 0 END) 'signed_consultation',
		");
		 $this->db->from('patient_visit')->join('patient','patient_visit.patient_id=patient.patient_id')
		 ->join('department','patient_visit.department_id=department.department_id','left')
		 ->join('unit','patient_visit.unit=unit.unit_id','left')
		 ->join('area','patient_visit.area=area.area_id','left')
		 ->join('hospital','patient_visit.hospital_id=hospital.hospital_id','left')
		 ->where('patient_visit.hospital_id',$hospital['hospital_id'])
		 ->where("(admit_date BETWEEN '$from_date' AND '$to_date')")
		 ->group_by('patient_visit.signed_consultation');
		$resource=$this->db->get();
		return $resource->result();
        }


	function get_transfers_summary(){
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
        if($this->input->post('date_type_selection')=='transfer_date'){
            $this->db->where("(transfer_date BETWEEN '$from_date' AND '$to_date')");
        }
		else{
            $this->db->where("(admit_date BETWEEN '$from_date' AND '$to_date')");
		}
		if($this->input->post('from_department')){
			$this->db->where_in('it.from_department_id',$this->input->post('from_department'));
		}
		if($this->input->post('to_department')){
			$this->db->where_in('it.department_id',$this->input->post('to_department'));
		}
		$this->db->select("count(transfer_id) transfers, avg(time_in_previous_area) duration, fd.department from_department,fa.area_name from_area,
		td.department to_department,ta.area_name to_area,
		it.department_id to_department_id,it.area_id to_area_id,it.from_department_id,it.from_area_id")
		->from('internal_transfer it')
		->join('department fd','it.from_department_id = fd.department_id')
		->join('area fa','it.from_area_id = fa.area_id','left')
		->join('department td','it.department_id = td.department_id')
		->join('area ta','it.area_id = ta.area_id','left')
		->join('patient_visit','it.visit_id = patient_visit.visit_id')
		->where('patient_visit.hospital_id',$hospital['hospital_id'])
		->group_by('from_department_id,to_department_id,from_area_id,to_area_id');
		$query = $this->db->get();
		return $query->result();

	}

	function get_audiology_detail(){
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
		if($this->input->post('department')){
			$this->db->where('patient_visit.department_id',$this->input->post('department'));
		}
		if($this->input->post('unit')){
			$this->db->where('patient_visit.unit',$this->input->post('unit'));
		}
		if($this->input->post('area')){
			$this->db->where('patient_visit.area',$this->input->post('area'));
		}
		if($this->input->post('date_type') == 'Order'){
			$this->db->where('(DATE(test_order.order_date_time) BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}
		else{
			$this->db->where('(patient_visit.admit_date BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}

		$this->db->select('test_name,patient_visit.visit_id,patient_visit.hosp_file_no,
		test_master.test_master_id,patient.age_years,patient.age_months,patient.age_days,patient_visit.visit_type,
		patient.first_name,patient.last_name,test_order.order_id,test_status,
		binary_positive,binary_negative,numeric_result,text_result,
		test_result,test_result_text,binary_result,numeric_result,text_result,
		patient.mother_name,patient.father_name,patient.dob,
		patient.gender,patient.address,patient.phone,order_date_time,department.department_id,area.area_id,unit.unit_id,
		department,area_name,unit.unit_name,test_result_binary,count_visit',false)
			->from('test')
			->join('test_order','test.order_id = test_order.order_id')
			->join('test_master','test.test_master_id = test_master.test_master_id')
			->join('patient_visit','test_order.visit_id = patient_visit.visit_id')
			->join('patient','patient_visit.patient_id = patient.patient_id')
			->join('department','patient_visit.department_id = department.department_id')
			->join('area','patient_visit.area = area.area_id','left')
			->join('unit','patient_visit.unit = unit.unit_id','left')
			->where('test_order.hospital_id',$hospital['hospital_id'])
			->where('test.test_status',2)
			->where_in('test_name',array('Left OAE','Right OAE'));

		if($this->input->post('oae_count') == 2){
			$this->db->join('(SELECT MAX(order_date_time) max_date, visit_id,COUNT(visit_id) count_visit FROM test_order
			JOIN test USING(order_id) JOIN test_master USING(test_master_id)
			WHERE test_name IN ("LEFT OAE","Right OAE") GROUP BY visit_id) testo','patient_visit.visit_id = testo.visit_id');
			$this->db->where('count_visit',4);
		}
		if($this->input->post('oae_count') == 3){
			$this->db->join('(SELECT MAX(order_date_time) max_date, visit_id,COUNT(visit_id) count_visit FROM test_order
			JOIN test USING(order_id) JOIN test_master USING(test_master_id)
			WHERE test_name IN ("LEFT OAE","Right OAE") GROUP BY visit_id) testo','patient_visit.visit_id = testo.visit_id');
			$this->db->where('count_visit',6);
		}
		if($this->input->post('oae_count') == 1){
			$this->db->join('(SELECT MAX(order_date_time) max_date, visit_id,COUNT(visit_id) count_visit FROM test_order
			JOIN test USING(order_id) JOIN test_master USING(test_master_id)
			WHERE test_name IN ("LEFT OAE","Right OAE") GROUP BY visit_id) testo','patient_visit.visit_id = testo.visit_id');
			$this->db->where('count_visit',2);
		}
		if($this->input->post('outcome_type')=="Left"){
			$this->db->where('test_master.test_name',"Left OAE");
			$this->db->where('test.test_result_binary',0);
		}
		if($this->input->post('outcome_type')=="Right"){
			$this->db->where('test_master.test_name',"Right OAE");
			$this->db->where('test.test_result_binary',0);
		}
		if($this->input->post('outcome_type')=="Bilateral"){
			$this->db->join('(SELECT test_result_binary trb,test_name tn, test_order.order_id FROM test_order
			JOIN test USING(order_id) JOIN test_master USING(test_master_id)
			WHERE test_name IN ("LEFT OAE","Right OAE") GROUP BY visit_id) testbilateral','test_order.order_id = testbilateral.order_id');
			$this->db->where('test.test_result_binary',0);
			$this->db->where('trb',0);
			$this->db->where('(count_visit%2)',0,false);
		}
		$query=$this->db->get();
		return $query->result();
	}

    function get_outcome_summary(){
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
         if($this->input->post('date_type_selection')=='outcome_date'){
            $this->db->where("(outcome_date BETWEEN '$from_date' AND '$to_date')");
        }else{
            $this->db->where("(admit_date BETWEEN '$from_date' AND '$to_date')");
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
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('patient_visit.area',$this->input->post('area'));
		}
		else{
			$this->db->select('"0" as area',false);
		}
		$this->db->select("department 'department', department.department_id,
        SUM(CASE WHEN 1  THEN 1 ELSE 0 END) 'outcome',
        SUM(CASE WHEN gender = 'F'  THEN 1 ELSE 0 END) 'outcome_female',
		SUM(CASE WHEN gender = 'M'  THEN 1 ELSE 0 END) 'outcome_male',
		SUM(CASE WHEN gender = 'F' AND outcome = 'Discharge' THEN 1 ELSE 0 END) 'female_discharge',
        SUM(CASE WHEN gender = 'M' AND outcome = 'Discharge' THEN 1 ELSE 0 END) 'male_discharge',
        SUM(CASE WHEN outcome = 'Discharge' THEN 1 ELSE 0 END) 'total_discharge',
        SUM(CASE WHEN gender = 'F' AND outcome = 'LAMA' THEN 1 ELSE 0 END) 'female_lama',
        SUM(CASE WHEN gender = 'M' AND outcome = 'LAMA' THEN 1 ELSE 0 END) 'male_lama',
        SUM(CASE WHEN outcome = 'LAMA' THEN 1 ELSE 0 END) 'total_lama',
        SUM(CASE WHEN gender = 'F' AND outcome = 'Absconded' THEN 1 ELSE 0 END) 'female_absconded',
        SUM(CASE WHEN gender = 'M' AND outcome = 'Absconded' THEN 1 ELSE 0 END) 'male_absconded',
        SUM(CASE WHEN outcome = 'Absconded' THEN 1 ELSE 0 END) 'total_absconded',
        SUM(CASE WHEN gender = 'F' AND outcome = 'Death' THEN 1 ELSE 0 END) 'female_death',
        SUM(CASE WHEN gender = 'M' AND outcome = 'Death' THEN 1 ELSE 0 END) 'male_death',
        SUM(CASE WHEN outcome = 'Death' THEN 1 ELSE 0 END) 'total_death',
        SUM(CASE WHEN gender = 'F' AND outcome!='Discharge' AND outcome!='LAMA' AND outcome!='Absconded' AND outcome!= 'Death' THEN 1 ELSE 0 END) 'female_unupdated',
        SUM(CASE WHEN gender = 'M' AND outcome!='Discharge' AND outcome!='LAMA' AND outcome!='Absconded' AND outcome!= 'Death' THEN 1 ELSE 0 END) 'male_unupdated',
        SUM(CASE WHEN outcome!='Discharge' AND outcome!='LAMA' AND outcome!='Absconded' AND outcome!= 'Death' THEN 1 ELSE 0 END) 'total_unupdated'");
		 $this->db->from('patient_visit')->join('patient','patient_visit.patient_id=patient.patient_id')
		 ->join('department','patient_visit.department_id=department.department_id','left')
		 ->join('unit','patient_visit.unit=unit.unit_id','left')
		 ->join('area','patient_visit.area=area.area_id','left')
		 ->join('hospital','patient_visit.hospital_id=hospital.hospital_id','left')
		 ->where('patient_visit.hospital_id',$hospital['hospital_id'])
         ->where('visit_type','IP')
		 ->group_by('department');

		$resource=$this->db->get();
		return $resource->result();
    }



	function get_transport_summary($report_type){
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
		if($this->input->post('visit_name')){
			$this->db->where('patient_visit.visit_name_id',$this->input->post('visit_name'));
		}
		if($this->input->post('department')){
			$this->db->where('patient_visit.department_id',$this->input->post('department'));
		}
		if($this->input->post('transport_type')){
			$this->db->where('transport.transport_type',$this->input->post('transport_type'));
		}
		else{
			$this->db->where('transport.transport_type',1);
		}
		if($this->input->post('transport_type')!=2){
			$this->db->where('patient_visit.hospital_id',$hospital['hospital_id']);
			$this->db->where("(admit_date BETWEEN '$from_date' AND '$to_date')");
		}
		else{
			$this->db->where("(DATE(start_date_time) BETWEEN '$from_date' AND '$to_date')");
		}
		if($this->input->post('unit')){
			$this->db->select('IF(unit!="",unit,0) unit',false);
			$this->db->where('patient_visit.unit',$this->input->post('unit'));
		}
		else{
			$this->db->select('"0" as unit',false);
		}
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('patient_visit.area',$this->input->post('area'));
		}
		else{
			$this->db->select('"0" as area',false);
		}
		if($report_type == "area"){
			$this->db->select('ta.area_name to_area');
			$this->db->group_by('ta.area_id');
		}
		else if($report_type == "person"){
			$this->db->select("CONCAT(IF(staff.first_name=NULL,'',staff.first_name),' ',IF(staff.last_name=NULL,'',staff.last_name)) staff_name",false);
			$this->db->group_by('staff.staff_id');
		}

		$this->db->select("ta.area_name to_area,count(transport_id) count_transport, AVG(MINUTE(TIMEDIFF(end_date_time,start_date_time))) avg_time",false);
		 $this->db->from('transport')
		 ->join('patient_visit','transport.visit_id=patient_visit.visit_id','left')
		 ->join('patient','patient_visit.patient_id=patient.patient_id','left')
		 ->join('staff','transport.staff_id=staff.staff_id')
		 ->join('area fa','transport.from_area_id=fa.area_id')
		 ->join('department fd','fa.department_id=fd.department_id')
		 ->join('area ta','transport.to_area_id=ta.area_id')
		 ->join('department td','ta.department_id=td.department_id');
		 $resource=$this->db->get();
		return $resource->result();
	}



	function get_transport_detail(){
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
		if($this->input->post('visit_name')){
			$this->db->where('patient_visit.visit_name_id',$this->input->post('visit_name'));
		}
		if($this->input->post('department')){
			$this->db->where('patient_visit.department_id',$this->input->post('department'));
		}
		if($this->input->post('transport_type')){
			$this->db->where('transport.transport_type',$this->input->post('transport_type'));
		}
		else{
			$this->db->where('transport.transport_type',1);
		}
		if($this->input->post('transport_type')!=2){
			$this->db->where('patient_visit.hospital_id',$hospital['hospital_id']);
		}
		if($this->input->post('unit')){
			$this->db->select('IF(unit!="",unit,0) unit',false);
			$this->db->where('patient_visit.unit',$this->input->post('unit'));
		}
		else{
			$this->db->select('"0" as unit',false);
		}
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('patient_visit.area',$this->input->post('area'));
		}
		else{
			$this->db->select('"0" as area',false);
		}

		$this->db->select("hosp_file_no,patient_visit.visit_id,
		CONCAT(IF(patient.first_name=NULL,'',patient.first_name),' ',IF(patient.last_name=NULL,'',patient.last_name)) patient_name,
		CONCAT(IF(staff.first_name=NULL,'',staff.first_name),' ',IF(staff.last_name=NULL,'',staff.last_name)) staff_name, staff.phone staff_phone,
		patient.gender,patient.age_years, patient.age_months, patient.age_days, patient_visit.visit_type,
		fa.area_name from_area, fd.department from_department, ta.area_name to_area, td.department to_department,
		patient.phone, admit_date, admit_time, staff.phone,start_date_time,end_date_time,note",false);
		 $this->db->from('transport')
		->join('patient_visit','transport.visit_id=patient_visit.visit_id','left')
		->join('patient','patient_visit.patient_id=patient.patient_id','left')
		->join('staff','transport.staff_id=staff.staff_id')
		->join('area fa','transport.from_area_id=fa.area_id')
		->join('department fd','fa.department_id=fd.department_id')
		->join('area ta','transport.to_area_id=ta.area_id')
		->join('department td','ta.department_id=td.department_id')
		->where("(DATE(start_date_time) BETWEEN '$from_date' AND '$to_date')")
		->order_by("start_date_time");
		$resource=$this->db->get();
		return $resource->result();
	}

	// diagnostics dashboard to group data by hospital type
	function diagnostic_dashboard_HospitalWise(){
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

			$this->db->select("test_method,test_id,
		SUM(CASE WHEN test.test_status IN (0,1,2,3) THEN 1 ELSE 0 END) tests_ordered,
		SUM(CASE WHEN test.test_status IN (1,2,3) THEN 1 ELSE 0 END) tests_completed,
		SUM(CASE WHEN test.test_status = 2 THEN 1 ELSE 0 END) tests_reported,
		SUM(CASE WHEN test.test_status = 3 THEN 1 ELSE 0 END) tests_rejected,count(DISTINCT hospital.hospital_id) hospital_count,
		test_method.test_method_id,test_master.test_master_id,hospital.type4 type,count(DISTINCT test_order.visit_id) patient_count,count(DISTINCT test_order.order_id) orders_count,test_master.test_name,test_area.test_area_id",false)
		->from('test_order')
		->join('test_sample','test_order.order_id = test_sample.order_id','left')
		->join('patient_visit','test_order.visit_id = patient_visit.visit_id')
		->join('hospital','patient_visit.hospital_id=hospital.hospital_id')
		->join('department','patient_visit.department_id = department.department_id')
		->join('test_area','test_order.test_area_id = test_area.test_area_id')
		->join('test','test_order.order_id = test.order_id','left')
		->join('test_master','test.test_master_id = test_master.test_master_id')
		->join('test_method','test_master.test_method_id = test_method.test_method_id')
		->where("(DATE(order_date_time) BETWEEN '$from_date' AND '$to_date')")
		->group_by('hospital.type4');
		
		$resource=$this->db->get();
		// echo $this->db->last_query();
		return $resource->result();		
	}
	// Diagnostics dashboard to group data by lab area 
	function diagnostic_dashboard_AreaWise(){
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

			$this->db->select("test_method,test_id,
		SUM(CASE WHEN test.test_status IN (0,1,2,3) THEN 1 ELSE 0 END) tests_ordered,
		SUM(CASE WHEN test.test_status IN (1,2,3) THEN 1 ELSE 0 END) tests_completed,
		SUM(CASE WHEN test.test_status = 2 THEN 1 ELSE 0 END) tests_reported,
		SUM(CASE WHEN test.test_status = 3 THEN 1 ELSE 0 END) tests_rejected,count(DISTINCT hospital.hospital_id) hospital_count,
		test_area.test_area_id,count(DISTINCT test_order.visit_id) patient_count,count(DISTINCT test_order.order_id) orders_count,test_area.test_area",false)
		->from('test_order')
		->join('test_sample','test_order.order_id = test_sample.order_id','left')
		->join('patient_visit','test_order.visit_id = patient_visit.visit_id')
		->join('hospital','patient_visit.hospital_id=hospital.hospital_id')
		->join('department','patient_visit.department_id = department.department_id')
		->join('test_area','test_order.test_area_id = test_area.test_area_id')
		->join('test','test_order.order_id = test.order_id','left')
		->join('test_master','test.test_master_id = test_master.test_master_id')
		->join('test_method','test_master.test_method_id = test_method.test_method_id')
		->where("(DATE(order_date_time) BETWEEN '$from_date' AND '$to_date')")
		->group_by('test_area.test_area');
		
		$resource=$this->db->get();
	//	echo $this->db->last_query();
		return $resource->result();			 	
	}

	/**
    * Added By : Manish Kumar Sadhu
    */
	function diagnostic_board($type=""){
		$to_date=date("Y-m-d");
		//var_dump($to_date);
		//$to_date='2016-01-08';
		$from_date=strtotime( '-2 day' ,strtotime ( $to_date ) );
		$yesterday=strtotime( '-1 day' ,strtotime ( $to_date ) );
		
		$yesterday=date( "Y-m-d" , $yesterday );
		$from_date=date( "Y-m-d" , $from_date );
		//var_dump($yesterday);
		//var_dump($from_date);
		$this->db->select("test_method,test_id,DATE(order_date_time) date,
		SUM(CASE WHEN test.test_status IN (0,1,2,3) THEN 1 ELSE 0 END) tests_ordered,
		SUM(CASE WHEN test.test_status IN (1,2,3) THEN 1 ELSE 0 END) tests_completed,
		SUM(CASE WHEN test.test_status = 2 THEN 1 ELSE 0 END) tests_reported,
		SUM(CASE WHEN test.test_status = 3 THEN 1 ELSE 0 END) tests_rejected,count(DISTINCT hospital.hospital_id) hospital_count,
		test_method.test_method_id,test_master.test_master_id,hospital.type4 type,count(DISTINCT test_order.visit_id) patient_count,count(DISTINCT test_order.order_id) orders_count,test_master.test_name",false)
		->from('test_order')
		->join('test_sample','test_order.order_id = test_sample.order_id','left')
		->join('patient_visit','test_order.visit_id = patient_visit.visit_id')
		->join('hospital','patient_visit.hospital_id=hospital.hospital_id')
		->join('department','patient_visit.department_id = department.department_id')
		->join('test','test_order.order_id = test.order_id','left')
		->join('test_master','test.test_master_id = test_master.test_master_id')
		->join('test_method','test_master.test_method_id = test_method.test_method_id')
		->where("(DATE(order_date_time) BETWEEN '$from_date' AND '$to_date')")
		->group_by('DATE(order_date_time)');
		if($type == ""){
			$this->db->select("hospital.type4 hospital_type")
			->group_by('hospital.type4');
		}
		
		if($type == "lab_area" ){
			$this->db->select("test_area.test_area lab_area,test_area.test_area_id")
			->join('test_area','test_order.test_area_id = test_area.test_area_id')
			->group_by('test_area.test_area_id')
			->order_by('test_area.test_area','asc');
		}			
 		$resource=$this->db->get();
		//echo $this->db->last_query();
		return $resource->result();		
	}
	/**
    * Added By : Manish Kumar Sadhu
    */

	function diagnostic_hospital_board($hospital_type=" " , $type=" "){
		$to_date=date("Y-m-d");
		//var_dump($hospital_type);
		//$to_date='2016-01-08';
		$from_date=strtotime( '-2 day' ,strtotime ( $to_date ) );
		$yesterday=strtotime( '-1 day' ,strtotime ( $to_date ) );
		$yesterday=date( "Y-m-d" , $yesterday );
		$from_date=date( "Y-m-d" , $from_date );
		$this->db->select("test_method,test_id,DATE(order_date_time) date,
		SUM(CASE WHEN test.test_status IN (0,1,2,3) THEN 1 ELSE 0 END) tests_ordered,
		SUM(CASE WHEN test.test_status IN (1,2,3) THEN 1 ELSE 0 END) tests_completed,
		SUM(CASE WHEN test.test_status = 2 THEN 1 ELSE 0 END) tests_reported,
		SUM(CASE WHEN test.test_status = 3 THEN 1 ELSE 0 END) tests_rejected,count(DISTINCT hospital.hospital_id) hospital_count,
		test_method.test_method_id,test_master.test_master_id,hospital.type4 type,hospital.hospital_short_name hospital,
		count(DISTINCT test_order.visit_id) patient_count,count(DISTINCT test_order.order_id) orders_count,
		test_master.test_name",false)
		->from('test_order')
		->join('test_sample','test_order.order_id = test_sample.order_id','left')
		->join('patient_visit','test_order.visit_id = patient_visit.visit_id')
		->join('hospital','patient_visit.hospital_id=hospital.hospital_id')
		->join('department','patient_visit.department_id = department.department_id')
		->join('test','test_order.order_id = test.order_id','left')
		->join('test_master','test.test_master_id = test_master.test_master_id')
		->join('test_method','test_master.test_method_id = test_method.test_method_id')
		->where("(DATE(order_date_time) BETWEEN '$from_date' AND '$to_date')")
		->where("REPLACE(hospital.type4, ' ', '')=" , $hospital_type) 
		//->where('hospital.type3',$hospital_type) 
		->group_by('hospital.hospital_id');
		if($type == "lab_area" ){
			$this->db->select("test_area.test_area lab_area")
			->join('test_area','test_order.test_area_id = test_area.test_area_id')
			->group_by('test_area.test_area_id')
			->order_by('test_area.test_area','asc');
		}			
 		$resource=$this->db->get();
		// echo $this->db->last_query();
		return $resource->result();		
	}
	/**
    * Added By : Manish Kumar Sadhu
    */

	function dashboard($organization="",$type="",$state=""){

		if($type == "state" && $state != "") {
			$this->db->select('organization, short_name, type6, state')->from('dashboards')->where('LOWER(state_alias)', strtolower($state));
			$query = $this->db->get();
			$dashboard = $query->result();
		}
		else {	
		$this->db->select('organization, short_name, type6, state')->from('dashboards')->where('LOWER(short_name)',strtolower($organization));
		$query = $this->db->get();
		$dashboard = $query->result();
		if($query->num_rows()!=1) show_404();

		if(!!$dashboard[0]->state)
				$this->db->where('hospital.state',$dashboard[0]->state);
			for($i=1;$i<7;$i++){
				if(isset($dashboard[0]->{"type".$i}))
					$this->db->where("hospital.type$i",$dashboard[0]->{"type".$i});
			}
		}

		/** query to select patient count by OP, IP and Repeat OP*/
		$this->db->select('SUM(CASE WHEN visit_type = "IP" THEN 1 ELSE 0 END) total_ip,
			SUM(CASE WHEN visit_type = "OP" THEN 1 ELSE 0 END) total_op,
			SUM(CASE WHEN visit_type = "OP" AND pv.patient_id IN ( SELECT p.patient_id FROM patient_visit p WHERE p.admit_date<pv.admit_date AND visit_type="OP" AND hospital_id = hospital.hospital_id ) THEN 1 ELSE 0 END) as repeat_op')
			->from('patient_visit pv')
			->join('hospital','pv.hospital_id = hospital.hospital_id','left')
			->order_by('total_op','desc');

		if($this->input->post('department')){
			$this->db->where('pv.department_id',$this->input->post('department'));
		}

		if($this->input->post('from_date') || $this->input->post('to_date')){
			if($this->input->post('from_date')){
				$date = date("Y-m-d",strtotime($this->input->post('from_date')));
				$this->db->where('pv.admit_date >=',$date);
			}
			if($this->input->post('to_date')){
				$date = date("Y-m-d",strtotime($this->input->post('to_date')));
				$this->db->where('pv.admit_date <=',$date);
			}
		}
		else {
			$date = date("Y-m-d");
			$this->db->where("pv.admit_date <=",$date);
			$fromDate = date("Y-m-d");
			$this->db->where('pv.admit_date >=',$fromDate);
		}

		if($this->input->post('from_time') || $this->input->post('to_time')){
			$from_time=date("H:i",strtotime($this->input->post('from_time')));
			$to_time=date("H:i",strtotime($this->input->post('to_time')));
			$this->db->where("pv.admit_time BETWEEN '$from_time' AND '$to_time'");
		}else{
			$from_time = date("00:00");
			$to_time = date("23:59");
			$this->db->where("pv.admit_time BETWEEN '$from_time' AND '$to_time'");
		}

		if($this->input->post('hospitaltype')){
			$this->db->where('hospital.type4',$this->input->post('hospitaltype') == "Others" ? "" : $this->input->post('hospitaltype'));
		}

		if($type == ""){
			$this->db->select('hospital.type2, hospital.type4, count(DISTINCT hospital.hospital_id) hospital_count');
			$this->db->group_by('hospital.type4');
		}
		if($type == "district"){
			$this->db->select('patient.district_id,district.district')
			->join('patient','pv.patient_id=patient.patient_id')
			->join('district','patient.district_id=district.district_id','left')
			->group_by('patient.district_id');
		}
		if($type == "department"){
			$this->db->select('pv.department_id,department')
			->join('department','pv.department_id=department.department_id')
			->group_by('department');
		}
		if($type == "hospital"){
			$this->db->select('hospital.hospital_short_name')
			->group_by('hospital.hospital_id');
		}
		if($type == "state"){
			$typearray = array();
			for($i=0;$i<sizeof($dashboard);$i++){
				if(isset($dashboard[$i]->type6)){
					array_push($typearray,$dashboard[$i]->type6);
				}
			}
			if(sizeof($typearray) > 0){
				$this->db->where_in("hospital.type6", $typearray);
			}

			$this->db->select('hospital.type6,count(DISTINCT hospital.hospital_id) hospital_count, dashboards.short_name,org_label');
			$this->db->join('dashboards','hospital.type6 = dashboards.type6 AND hospital.state = dashboards.state','left');
			$this->db->where('dashboards.state_alias',$state);
			$this->db->group_by('hospital.type6');
		}

		$query = $this->db->get();
	//	echo $this->db->last_query();
		$resource = $query->result();
		if($type == "state") {
			return array($dashboard[0]->state,$resource);
		}
		else{
			return array($dashboard[0]->organization,$resource);
		}
	}
}
?>
