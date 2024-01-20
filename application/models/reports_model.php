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
		 ->where("(admit_date BETWEEN '$from_date' AND '$to_date')");
		 if(!$this->input->post('postback') or $this->input->post('groupbyicdchapter')) {
		 	$this->db->group_by('icd_block.chapter_id');
		 }
		 
		 if($this->input->post('groupbyicdblock')) {
		 	$this->db->group_by('icd_code.block_id');
		 }
		 if($this->input->post('groupbyicdcode')){
		 	$this->db->group_by('icd_10');
		 }
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
		gender,IF(gender='F' AND (father_name IS NULL OR father_name = ''),spouse_name,father_name) parent_spouse,
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

function get_op_detail_with_idproof($department,$unit,$area,$from_age,$to_age,$from_date,$to_date,$default_rowsperpage){
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
		$this->db->limit($rows_per_page,$start);	
		$resource=$this->db->get();
		return $resource->result();
	}
	
	function get_op_detail_with_idproof_count($department,$unit,$area,$from_age,$to_age,$from_date,$to_date){		
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
		
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('patient_visit.area',$this->input->post('area'));
		}
		

		$this->db->select("count(*) as count",false);
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

	function get_search_helpline_doctor($query = "")
	{
		$hospital = $this->session->userdata('hospital');
		$search = "(LOWER(first_name) like '%" . strtolower($query) . "%' 
			 OR replace(replace(replace(lower(first_name), 'dr', ''), '.', ''),' ','') like '%" . strtolower($query) . "%'
			 OR replace(LOWER(last_name),' ','') like '%" . strtolower($query) . "%'
			 OR LOWER(department)  like '%" . strtolower($query) . "%')";
		

		$this->db->select("staff.staff_id, staff.first_name as first_name, replace(replace(replace(lower(first_name), 'dr', ''), '.', ''),' ','') as first_name_check ,staff.last_name as last_name, replace(LOWER(last_name),' ','') as last_name_check ,CONCAT( department.department, ' - ',staff.first_name, ' ', staff.last_name) as helpline_doctor,
				department.department as department", false);
		$this->db->from('staff')
		->join('user', 'user.staff_id=staff.staff_id')
		->join('user_hospital_link', 'user.user_id=user_hospital_link.user_id')
		->join('department', 'department.department_id=staff.department_id','left')
		->where('user_hospital_link.hospital_id', $hospital['hospital_id'])
		->where('staff.doctor_flag', 1)
		->where($search);
		
		$this->db->order_by('department', 'ASC');
		$this->db->order_by('helpline_doctor', 'ASC');
		$resource = $this->db->get();
		return $resource->result();
	}
	
	function get_referrals(){		
		
	        $inner_query = "(select DISTINCT pv.patient_id,p.gender,state.state as state,state.state_id as state_id,district.district as district,district.district_id as district_id from patient_visit pv join patient p on pv.patient_id=p.patient_id left join district on p.district_id = district.district_id left join state on district.state_id=state.state_id where ";
	        $date_filter_field="Registration";
		if($this->input->post('dateby') && $this->input->post('dateby')=="Appointment"){
			$date_filter_field="Appointment";
		}	
		$inner_query = $inner_query . "  pv.referral_by_hospital_id=pv.referral_by_hospital_id AND pv.hospital_id=pv.hospital_id  ";
		$hospital_refer = $this->input->post('hospital');		
		$hospital=$this->session->userdata('hospital');
		$hospitalsearchtype="HospitalReferredto";
		if($this->input->post('hospitalsearchtype')=="HospitalReferredby"){
			$hospitalsearchtype="HospitalReferredby";
		 }
		if($hospitalsearchtype=="HospitalReferredto"){
			//$this->db->where('pv.referral_by_hospital_id',$hospital['hospital_id']);
			$inner_query = $inner_query . " AND pv.referral_by_hospital_id=".$hospital['hospital_id'];
			if($hospital_refer){
				//$this->db->where('pv.hospital_id',$hospital_refer);	
				$inner_query = $inner_query . " AND pv.hospital_id=".$hospital_refer;
			}
			
		} else if($hospitalsearchtype=="HospitalReferredby"){			
			
			//$this->db->where('pv.hospital_id',$hospital['hospital_id']);
			$inner_query = $inner_query . "  AND pv.hospital_id=".$hospital['hospital_id'];
			if($hospital_refer){
				//$this->db->where('pv.referral_by_hospital_id',$hospital_refer);
				$inner_query = $inner_query . " AND pv.referral_by_hospital_id=".$hospital_refer;	
			}
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
	
                if($this->input->post('from_time') && $this->input->post('to_time')){
			$from_time=date("H:i",strtotime($this->input->post('from_time')));
			$to_time=date("H:i",strtotime($this->input->post('to_time')));
				
		}
		else if($this->input->post('from_time') || $this->input->post('to_time')){
			if($this->input->post('from_time')){
                            $from_time=$this->input->post('from_time');
                            $to_time = '23:59';
                        }else{
                            $from_time = '00:00';
                            $to_time=$this->input->post('to_time');
                        }				
		}		
		else{
			$to_time = '23:59';
		 	$from_time = '00:00';
		}
		
		if($this->input->post('visittype')){
				//$this->db->where('patient.district_id',$this->input->post('district'));
				$inner_query = $inner_query . " AND pv.visit_type='".$this->input->post('visittype')."'";
		}
		else{
			$inner_query = $inner_query . " AND pv.visit_type='OP'";
		}
		if($this->input->post('district')){
				//$this->db->where('patient.district_id',$this->input->post('district'));
				$inner_query = $inner_query . " AND p.district_id=".$this->input->post('district');
		}
		
		if($this->input->post('state')){
				//$this->db->where('state.state_id',$this->input->post('state'));
				$inner_query = $inner_query . " AND state.state_id=".$this->input->post('state');
		}
		if($date_filter_field=="Registration"){
			//$this->db->where("(admit_date BETWEEN '$from_date' AND '$to_date')");
			//$this->db->where("(admit_time BETWEEN '$from_time' AND '$to_time')");
			//$this->db->order_by('admit_date','ASC');
		 	//$this->db->order_by('admit_time','ASC');
		 	$inner_query = $inner_query ." AND (pv.admit_date BETWEEN '$from_date' AND '$to_date') AND ". "(pv.admit_time BETWEEN '$from_time' AND '$to_time') "; 
		} 
		else if($date_filter_field=="Appointment"){
			//$this->db->where("(appointment_time IS NOT NULL)");				
			$from_timestamp = $from_date." ".$from_time;
			$to_timestamp = $to_date." ".$to_time;
			//$this->db->where("(appointment_time BETWEEN '$from_timestamp' AND '$to_timestamp')");
			//$this->db->order_by('UNIX_TIMESTAMP(appointment_time)','ASC');
			$inner_query = $inner_query . "AND (pv.appointment_time BETWEEN '$from_timestamp' AND '$to_timestamp') ";
		}
		
		if($this->input->post('visit_name')){
			//$this->db->where('pv.visit_name_id',$this->input->post('visit_name'));
			$inner_query = $inner_query . " AND pv.visit_name_id=".$this->input->post('visit_name');
		}
		if($this->input->post('department')){
			//$this->db->where('pv.department_id',$this->input->post('department'));
			$inner_query = $inner_query . " AND pv.department_id=".$this->input->post('department');
		}
		if($this->input->post('unit')){
			//$this->db->where('pv.unit',$this->input->post('unit'));
			$inner_query = $inner_query . " AND pv.unit=".$this->input->post('unit');
		}
		
		if($this->input->post('area')){
			//$this->db->where('pv.area',$this->input->post('area'));
			$inner_query = $inner_query . " AND pv.area=".$this->input->post('area');
		}
		
		$inner_query = $inner_query . " ) as patient_sub ";
		$query= $this->db->query("select patient_sub.state,patient_sub.district,patient_sub.state_id,patient_sub.district_id,
sum(case when 1 then 1 else 0 end) as total,
sum(case when patient_sub.gender='0' then 1 else 0 end) as not_specified,
sum(case when patient_sub.gender='O' then 1 else 0 end) as others,
sum(case when patient_sub.gender='M' then 1 else 0 end) as male,
sum(case when patient_sub.gender='F' then 1 else 0 end) as female  from ".$inner_query."  GROUP by patient_sub.state,patient_sub.district",false);		 			
		return $query->result();
	}
	function get_referrals_centers(){		
		
	        $inner_query = "(select pv.patient_id,hospital.hospital_id as hospital_id ,hospital.type1 as type1 ,ifnull(hospital.hospital_short_name,'NA') as hospital_short_name,ifnull(hospital.hospital,'Not Assigned') as hospital,p.gender,state.state as state,state.state_id as state_id,district.district as district,district.district_id as district_id from patient_visit pv join patient p on pv.patient_id=p.patient_id left join hospital on pv.referral_by_hospital_id=hospital.hospital_id left join district on hospital.district_id = district.district_id left join state on district.state_id=state.state_id where ";
	        $date_filter_field="Registration";
		if($this->input->post('dateby') && $this->input->post('dateby')=="Appointment"){
			$date_filter_field="Appointment";
		}	
		$inner_query = $inner_query . " 1=1 ";
		$hospital_refer = $this->input->post('hospital');		
		if($hospital_refer){
			$inner_query = $inner_query . " AND pv.referral_by_hospital_id=".$hospital_refer;	
		}
		
		$hospital=$this->session->userdata('hospital');
		if($hospital){
			$inner_query = $inner_query . "  AND pv.hospital_id=".$hospital['hospital_id'];
			
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
	
                if($this->input->post('from_time') && $this->input->post('to_time')){
			$from_time=date("H:i",strtotime($this->input->post('from_time')));
			$to_time=date("H:i",strtotime($this->input->post('to_time')));
				
		}
		else if($this->input->post('from_time') || $this->input->post('to_time')){
			if($this->input->post('from_time')){
                            $from_time=$this->input->post('from_time');
                            $to_time = '23:59';
                        }else{
                            $from_time = '00:00';
                            $to_time=$this->input->post('to_time');
                        }				
		}		
		else{
			$to_time = '23:59';
		 	$from_time = '00:00';
		}
		
		if($this->input->post('visittype')){
				//$this->db->where('patient.district_id',$this->input->post('district'));
				$inner_query = $inner_query . " AND pv.visit_type='".$this->input->post('visittype')."'";
		}
		else{
			$inner_query = $inner_query . " AND pv.visit_type='OP'";
		}
		if($this->input->post('district')){
				//$this->db->where('patient.district_id',$this->input->post('district'));
				$inner_query = $inner_query . " AND hospital.district_id=".$this->input->post('district');
		}
		
		if($this->input->post('state')){
				//$this->db->where('state.state_id',$this->input->post('state'));
				$inner_query = $inner_query . " AND state.state_id=".$this->input->post('state');
		}
		if($date_filter_field=="Registration"){
		 	$inner_query = $inner_query ." AND (pv.admit_date BETWEEN '$from_date' AND '$to_date') AND ". "(pv.admit_time BETWEEN '$from_time' AND '$to_time') "; 
		} 
		else if($date_filter_field=="Appointment"){
			$inner_query = $inner_query . "AND (pv.appointment_time BETWEEN '$from_timestamp' AND '$to_timestamp') ";
		}
		
		if($this->input->post('visit_name')){
			//$this->db->where('pv.visit_name_id',$this->input->post('visit_name'));
			$inner_query = $inner_query . " AND pv.visit_name_id=".$this->input->post('visit_name');
		}
		if($this->input->post('department')){
			//$this->db->where('pv.department_id',$this->input->post('department'));
			$inner_query = $inner_query . " AND pv.department_id=".$this->input->post('department');
		}
		if($this->input->post('unit')){
			//$this->db->where('pv.unit',$this->input->post('unit'));
			$inner_query = $inner_query . " AND pv.unit=".$this->input->post('unit');
		}
		
		if($this->input->post('area')){
			//$this->db->where('pv.area',$this->input->post('area'));
			$inner_query = $inner_query . " AND pv.area=".$this->input->post('area');
		}
		
		$inner_query = $inner_query . " ) as patient_sub ";
		$query= $this->db->query("select patient_sub.hospital_id,patient_sub.hospital_short_name,patient_sub.hospital,patient_sub.type1,patient_sub.state,patient_sub.district,patient_sub.state_id,patient_sub.district_id,
sum(case when 1 then 1 else 0 end) as total,
sum(case when patient_sub.gender='0' then 1 else 0 end) as not_specified,
sum(case when patient_sub.gender='O' then 1 else 0 end) as others,
sum(case when patient_sub.gender='M' then 1 else 0 end) as male,
sum(case when patient_sub.gender='F' then 1 else 0 end) as female  from ".$inner_query."  GROUP by patient_sub.hospital_id",false);		 			
		return $query->result();
	}
	function get_referrals_centers_detail_count($date_filter_field_param,$visittype,$visit_name,$department,$unit,$area,$gender,$hospitalsearchtype_param,$hospital_param,$from_date_param,$to_date_param,$district_id,$state_id,$default_rowsperpage){
		
	     
	        $date_filter_field="Registration";
		if($date_filter_field_param){
			$date_filter_field=$date_filter_field_param;
		}
			
		if($hospital_param !=-1){
			$this->db->where('pv.referral_by_hospital_id',$hospital_param);	
		}else if($hospital_param ==0) {
			$this->db->where('pv.referral_by_hospital_id',0);
		}
		
			
	
		$hospital=$this->session->userdata('hospital');
		if($hospital){
			$this->db->where('pv.hospital_id',$hospital['hospital_id']);				
		}

		if($from_date_param && $to_date_param){
			$from_date=date("Y-m-d",strtotime($from_date_param));
			$to_date=date("Y-m-d",strtotime($to_date_param));
		}
		else if($from_date_param || $to_date_param){
			$from_date_param?$from_date=$from_date_param:$from_date=$to_date_param;
			$to_date=$from_date;
		}
		else{
			$from_date=date("Y-m-d");
			$to_date=$from_date;
		}
	
               $to_time = '23:59';
	       $from_time = '00:00';
		
		if($date_filter_field=="Registration"){
			$this->db->where("(admit_date BETWEEN '$from_date' AND '$to_date')");
			$this->db->where("(admit_time BETWEEN '$from_time' AND '$to_time')");
			$this->db->order_by('admit_date','ASC');
		 	$this->db->order_by('admit_time','ASC'); 
		 
		} 
		else if($date_filter_field=="Appointment"){
			$this->db->where("(appointment_time IS NOT NULL)");				
			$from_timestamp = $from_date." ".$from_time;
			$to_timestamp = $to_date." ".$to_time;
			$this->db->where("(appointment_time BETWEEN '$from_timestamp' AND '$to_timestamp')");
			$this->db->order_by('UNIX_TIMESTAMP(appointment_time)','ASC');
		}
		
		if($visit_name != -1){
			$this->db->where('pv.visit_name_id',$visit_name);			
		}
		if($department != -1){
			$this->db->where('pv.department_id',$department );			
		}
		if($unit != -1){
			$this->db->where('pv.unit',$unit);			
		}
		
		if($area !=-1){
			$this->db->where('pv.area',$area);
		}
		
		if($gender !=-1){
			$this->db->where('p.gender',$gender);
		}
		
		
		if($district_id != -1 && $district_id!=""){
			$this->db->where('hospital_referral_by_district.district_id',$district_id );				
		}
		
		if($district_id==""){
			$this->db->where('hospital_referral_by_district.district_id IS NULL');
			
		}
		
		if($state_id != -1 && $state_id!=""){
			$this->db->where('hospital_referral_by_state.state_id',$state_id);
				
		}
		
	
		
		$this->db->select("count(*) as count" ,false);
		 $this->db->from('patient_visit as pv')
		 ->join('patient as p','pv.patient_id=p.patient_id')
		 ->join('district','p.district_id=district.district_id','left')
		 ->join('state','district.state_id=state.state_id','left')
		 ->join('unit','pv.unit=unit.unit_id','left')
		 ->join('area','pv.area=area.area_id','left')
		 ->join('icd_code','pv.icd_10=icd_code.icd_code','left')
		 ->join('visit_name','pv.visit_name_id=visit_name.visit_name_id','left')
		 ->join('department','pv.department_id=department.department_id','left')
		 ->join('hospital','pv.hospital_id=hospital.hospital_id','left')
		 ->join('mlc','pv.visit_id=mlc.visit_id','left')
		 ->join('appointment_status aps','pv.appointment_status_id=aps.id','left')	
		 ->join('hospital as hospital_referral_by','pv.referral_by_hospital_id=hospital_referral_by.hospital_id','left')
		 ->join('district as hospital_referral_by_district','hospital_referral_by.district_id=hospital_referral_by_district.district_id','left')
		 ->join('state as hospital_referral_by_state','hospital_referral_by_district.state_id=hospital_referral_by_state.state_id','left');
		$this->db->where('pv.visit_type',$visittype);		
		$resource=$this->db->get();
		return $resource->result();
	}
	
	function get_referrals_centers_detail($date_filter_field_param,$visittype,$visit_name,$department,$unit,$area,$gender,$hospitalsearchtype_param,$hospital_param,$from_date_param,$to_date_param,$district_id,$state_id,$default_rowsperpage){
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
		
		
	      
	        $date_filter_field="Registration";
		if($date_filter_field_param){
			$date_filter_field=$date_filter_field_param;
		}
			
		if($hospital_param !=-1){
			$hospital_refer = $hospital_param;
			$this->db->where('pv.referral_by_hospital_id',$hospital_param);	
		}else if($hospital_param ==0) {
			$this->db->where('pv.referral_by_hospital_id',0);
		}
			
		$hospital=$this->session->userdata('hospital');
		if($hospital){
			$this->db->where('pv.hospital_id',$hospital['hospital_id']);				
		}
		

		if($from_date_param && $to_date_param){
			$from_date=date("Y-m-d",strtotime($from_date_param));
			$to_date=date("Y-m-d",strtotime($to_date_param));
		}
		else if($from_date_param || $to_date_param){
			$from_date_param?$from_date=$from_date_param:$from_date=$to_date_param;
			$to_date=$from_date;
		}
		else{
			$from_date=date("Y-m-d");
			$to_date=$from_date;
		}
	
               $to_time = '23:59';
	       $from_time = '00:00';
		
		if($date_filter_field=="Registration"){
			$this->db->where("(admit_date BETWEEN '$from_date' AND '$to_date')");
			$this->db->where("(admit_time BETWEEN '$from_time' AND '$to_time')");
			$this->db->order_by('admit_date','ASC');
		 	$this->db->order_by('admit_time','ASC'); 
		 
		} 
		else if($date_filter_field=="Appointment"){
			$this->db->where("(appointment_time IS NOT NULL)");				
			$from_timestamp = $from_date." ".$from_time;
			$to_timestamp = $to_date." ".$to_time;
			$this->db->where("(appointment_time BETWEEN '$from_timestamp' AND '$to_timestamp')");
			$this->db->order_by('UNIX_TIMESTAMP(appointment_time)','ASC');
		}
		
		if($visit_name != -1){
			$this->db->where('pv.visit_name_id',$visit_name);			
		}
		if($department != -1){
			$this->db->where('pv.department_id',$department );			
		}
		if($unit != -1){
			$this->db->where('pv.unit',$unit);			
		}
		
		if($area !=-1){
			$this->db->where('pv.area',$area);
		}
		
		if($gender !=-1){
			$this->db->where('p.gender',$gender);
		}
		if($district_id != -1 && $district_id!=""){
			$this->db->where('hospital_referral_by_district.district_id',$district_id );				
		}
		
		if($district_id==""){
			$this->db->where('hospital_referral_by_district.district_id IS NULL');
			
		}
		
		if($state_id != -1 && $state_id!=""){
			$this->db->where('hospital_referral_by_state.state_id',$state_id);
				
		}
		
		
	
		
		$this->db->select("p.patient_id,p.patient_id_manual, CONCAT(IF(p.first_name=NULL,'',p.first_name),' ',IF(p.last_name=NULL,'',p.last_name)) as name,department.department,
		p.gender, IF(p.gender='F' AND (father_name IS NULL OR father_name = ''),spouse_name, father_name) as parent_spouse, age_years, age_months, age_days,pv.hosp_file_no,p.phone,p.address,state.state,district.district,hospital.hospital_short_name as referred_to,hospital_referral_by.hospital_short_name as hospital_referral_by,mlc_number,pv.final_diagnosis,pv.icd_10 as pv_icd_code,icd_code.code_title,pv.appointment_status_id,aps.appointment_status,p.place, p.phone,visit_name.visit_name,admit_date, admit_time" ,false);
		 $this->db->from('patient_visit as pv')
		 ->join('patient as p','pv.patient_id=p.patient_id')
		 ->join('district','p.district_id=district.district_id','left')
		 ->join('state','district.state_id=state.state_id','left')
		 ->join('unit','pv.unit=unit.unit_id','left')
		 ->join('area','pv.area=area.area_id','left')
		 ->join('icd_code','pv.icd_10=icd_code.icd_code','left')
		 ->join('visit_name','pv.visit_name_id=visit_name.visit_name_id','left')
		 ->join('department','pv.department_id=department.department_id','left')
		 ->join('hospital','pv.hospital_id=hospital.hospital_id','left')
		 ->join('mlc','pv.visit_id=mlc.visit_id','left')
		 ->join('appointment_status aps','pv.appointment_status_id=aps.id','left')	
		 ->join('hospital as hospital_referral_by','pv.referral_by_hospital_id=hospital_referral_by.hospital_id','left')
		 ->join('district as hospital_referral_by_district','hospital_referral_by.district_id=hospital_referral_by_district.district_id','left')
		 ->join('state as hospital_referral_by_state','hospital_referral_by_district.state_id=hospital_referral_by_state.state_id','left');
		$this->db->where('pv.visit_type',$visittype);
		$this->db->limit($rows_per_page,$start);			
		$resource=$this->db->get();
		return $resource->result();
	}
	function get_referrals_detail($date_filter_field_param,$visittype,$visit_name,$department,$unit,$area,$gender,$hospitalsearchtype_param,$hospital_param,$from_date_param,$to_date_param,$district_id,$state_id,$default_rowsperpage){
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
		
		
	        $max_query = "select max(cast(concat(pv2.admit_date, ' ', pv2.admit_time) as datetime)) from patient_visit pv2 join patient p on p.patient_id=pv2.patient_id left join district d1 on p.district_id=d1.district_id left join state s1 on d1.state_id= s1.state_id where ";
	        $date_filter_field="Registration";
		if($date_filter_field_param){
			$date_filter_field=$date_filter_field_param;
		}
		$hospital_refer=0;	
		if($hospital_param !=-1){
			$hospital_refer = $hospital_param;
		}
				
		$hospital=$this->session->userdata('hospital');
		$hospitalsearchtype="HospitalReferredto";
		if($hospitalsearchtype_param=="HospitalReferredby"){
			$hospitalsearchtype="HospitalReferredby";
		 }
		 
		if($hospitalsearchtype=="HospitalReferredto"){
			$this->db->where('pv.referral_by_hospital_id',$hospital['hospital_id']);
			$this->db->where('pv.referral_by_hospital_id IS NOT NULL');
			$max_query = $max_query . "  pv2.referral_by_hospital_id=".$hospital['hospital_id']." AND";
			$max_query = $max_query . "  pv2.referral_by_hospital_id IS NOT NULL AND";
			if($hospital_refer){
				$this->db->where('pv.hospital_id',$hospital_refer);
			}
			
		} else if($hospitalsearchtype=="HospitalReferredby"){			
			$this->db->where('pv.hospital_id',$hospital['hospital_id']);
			$this->db->where('pv.referral_by_hospital_id IS NOT NULL');
			$max_query = $max_query . "  pv2.hospital_id=".$hospital['hospital_id']." AND";
			$max_query = $max_query . "  pv2.referral_by_hospital_id IS NOT NULL AND";
			if($hospital_refer){
				$this->db->where('pv.referral_by_hospital_id',$hospital_refer);
				$max_query = $max_query . "  pv2.referral_by_hospital_id=".$hospital_refer." AND";
				
			}
		}

		if($from_date_param && $to_date_param){
			$from_date=date("Y-m-d",strtotime($from_date_param));
			$to_date=date("Y-m-d",strtotime($to_date_param));
		}
		else if($from_date_param || $to_date_param){
			$from_date_param?$from_date=$from_date_param:$from_date=$to_date_param;
			$to_date=$from_date;
		}
		else{
			$from_date=date("Y-m-d");
			$to_date=$from_date;
		}
	
               $to_time = '23:59';
	       $from_time = '00:00';
		
		if($date_filter_field=="Registration"){
			$this->db->where("(admit_date BETWEEN '$from_date' AND '$to_date')");
			$this->db->where("(admit_time BETWEEN '$from_time' AND '$to_time')");
			$this->db->order_by('admit_date','ASC');
		 	$this->db->order_by('admit_time','ASC'); 
		 	$max_query = $max_query . " (admit_date BETWEEN '$from_date' AND '$to_date')"." AND";
		 	$max_query = $max_query . " (admit_time BETWEEN '$from_time' AND '$to_time')"." AND";
		} 
		else if($date_filter_field=="Appointment"){
			$this->db->where("(appointment_time IS NOT NULL)");				
			$from_timestamp = $from_date." ".$from_time;
			$to_timestamp = $to_date." ".$to_time;
			$this->db->where("(appointment_time BETWEEN '$from_timestamp' AND '$to_timestamp')");
			$max_query = $max_query . " (appointment_time BETWEEN '$from_timestamp' AND '$to_timestamp')"." AND";
			$this->db->order_by('UNIX_TIMESTAMP(appointment_time)','ASC');
		}
		
		if($visit_name != -1){
			$this->db->where('pv.visit_name_id',$visit_name);
			$max_query = $max_query . "  pv2.visit_name_id=".$visit_name." AND";
			
		}
		if($department != -1){
			$this->db->where('pv.department_id',$department );
			$max_query = $max_query . "  pv2.department_id=".$department." AND";
		}
		if($unit != -1){
			$this->db->where('pv.unit',$unit);
			$max_query = $max_query . "  pv2.unit=".$unit." AND";
			
		}
		
		if($area !=-1){
			$this->db->where('pv.area',$area);
			$max_query = $max_query . "  pv2.area=".$area." AND";
		}
		
		if($gender !=-1){
			$this->db->where('p.gender',$gender);
			$max_query = $max_query . "  p.gender='".$gender."' AND";
		}
		if($district_id != -1 && $district_id!=""){
				$this->db->where('p.district_id',$district_id );
				$max_query = $max_query . "  p.district_id=".$district_id." AND";
				
		}
		
		if($district_id==""){
			$this->db->where('p.district_id',0 );
			$max_query = $max_query . "  p.district_id=0 AND";
		}
		
		if($state_id != -1 && $state_id!=""){
			$this->db->where('state.state_id',$state_id);
			$max_query = $max_query . "  s1.state_id=".$state_id." AND";
				
		}
		
		
		$max_query = $max_query." pv2.visit_type='".$visittype."' AND pv2.patient_id= pv.patient_id";
		if ($visittype == 'IP'){
			$select_fields=" pv.hosp_file_no as latest_ip_no,pv.admit_date,pv.admit_time,pv.decision,pv.outcome,pv.outcome_date,pv.outcome_time,department.department as ip_department,pv.final_diagnosis ";
		
		} else if($visittype == 'OP'){
			$select_fields=" pv.hosp_file_no as latest_op_no,pv.admit_date as admit_date,pv.admit_time as admit_time,pv.icd_10 as op_icd_code,icd_code.code_title,pv.final_diagnosis,pv.appointment_time,visit_name.visit_name,department.department as op_department";
		}
		$this->db->select("p.patient_id, CONCAT(IF(p.first_name=NULL,'',p.first_name),' ',IF(p.last_name=NULL,'',p.last_name)) as name,
		p.gender, IF(p.gender='F' AND (father_name IS NULL OR father_name = ''),spouse_name, father_name) as parent_spouse, age_years, age_months, age_days,p.address,state.state,district.district,hospital.hospital_short_name as referred_to,hospital_referral_by.hospital_short_name as  hospital_referral_by,
		p.place, p.phone ".",".$select_fields ,false);
		 $this->db->from('patient_visit as pv')
		 ->join('patient as p','pv.patient_id=p.patient_id')
		 ->join('district','p.district_id=district.district_id','left')
		 ->join('state','district.state_id=state.state_id','left')
		 ->join('unit','pv.unit=unit.unit_id','left')
		 ->join('area','pv.area=area.area_id','left')
		 ->join('icd_code','pv.icd_10=icd_code.icd_code','left')
		 ->join('visit_name','pv.visit_name_id=visit_name.visit_name_id','left')
		 ->join('department','pv.department_id=department.department_id','left')
		 ->join('hospital','pv.hospital_id=hospital.hospital_id','left')
		 ->join('hospital as hospital_referral_by','pv.referral_by_hospital_id=hospital_referral_by.hospital_id','left');
		$this->db->where('pv.visit_type',$visittype);
		//$this->db->group_by('pv.patient_id,pv.admit_date,pv.admit_time,pv.department_id'); 
		//$this->db->having("cast(concat(pv.admit_date, ' ', pv.admit_time) as datetime)  = (".$max_query.")"); 
		$this->db->where("cast(concat(pv.admit_date, ' ', pv.admit_time) as datetime)  = (".$max_query.")"); 
		$this->db->limit($rows_per_page,$start);			
		$resource=$this->db->get();
		return $resource->result();
	}
	function get_referrals_detail_count($date_filter_field_param,$visittype,$visit_name,$department,$unit,$area,$gender,$hospitalsearchtype_param,$hospital_param,$from_date_param,$to_date_param,$district_id,$state_id){
		
		
	   
	        $date_filter_field="Registration";
		if($date_filter_field_param){
			$date_filter_field=$date_filter_field_param;
		}
		$hospital_refer=0;	
		if($hospital_param !=-1){
			$hospital_refer = $hospital_param;
		}
				
		$hospital=$this->session->userdata('hospital');
		$hospitalsearchtype="HospitalReferredto";
		if($hospitalsearchtype_param=="HospitalReferredby"){
			$hospitalsearchtype="HospitalReferredby";
		 }
		if($hospitalsearchtype=="HospitalReferredto"){
			$this->db->where('pv.referral_by_hospital_id',$hospital['hospital_id']);
			$this->db->where('pv.referral_by_hospital_id IS NOT NULL');
			if($hospital_refer){
				$this->db->where('pv.hospital_id',$hospital_refer);
			}
			
		} else if($hospitalsearchtype=="HospitalReferredby"){			
			
			$this->db->where('pv.hospital_id',$hospital['hospital_id']);
			$this->db->where('pv.referral_by_hospital_id IS NOT NULL');
			if($hospital_refer){
				$this->db->where('pv.referral_by_hospital_id',$hospital_refer);
				
			}
		}
		
		if($from_date_param && $to_date_param){
			$from_date=date("Y-m-d",strtotime($from_date_param));
			$to_date=date("Y-m-d",strtotime($to_date_param));
		}
		else if($from_date_param || $to_date_param){
			$from_date_param?$from_date=$from_date_param:$from_date=$to_date_param;
			$to_date=$from_date;
		}
		else{
			$from_date=date("Y-m-d");
			$to_date=$from_date;
		}
	
              
		$to_time = '23:59';
		$from_time = '00:00';
		
	
		if($date_filter_field=="Registration"){
			$this->db->where("(admit_date BETWEEN '$from_date' AND '$to_date')");
			$this->db->where("(admit_time BETWEEN '$from_time' AND '$to_time')");
		} 
		else if($date_filter_field=="Appointment"){
			$this->db->where("(appointment_time IS NOT NULL)");				
			$from_timestamp = $from_date." ".$from_time;
			$to_timestamp = $to_date." ".$to_time;
			$this->db->where("(appointment_time BETWEEN '$from_timestamp' AND '$to_timestamp')");
		}
		
		if($visit_name != -1){
			$this->db->where('pv.visit_name_id',$visit_name);
			
		}
		if($department != -1){
			$this->db->where('pv.department_id',$department );
		}
		if($unit != -1){
			$this->db->where('pv.unit',$unit);
			
		}
		
		if($area !=-1){
			$this->db->where('pv.area',$area);
		}
		
		if($gender !=-1){
			$this->db->where('p.gender',$gender);
		}
		if($district_id != -1 && $district_id!=""){
				$this->db->where('p.district_id',$district_id );
				
		}
		
		if($district_id==""){
			$this->db->where('p.district_id',0 );
			
		}
		
		if($state_id != -1 && $state_id!=""){
			$this->db->where('state.state_id',$state_id);
				
		}
		
		
		
		$this->db->select("count(DISTINCT pv.patient_id) as count" ,false);
		 $this->db->from('patient_visit as pv')
		 ->join('patient as p','pv.patient_id=p.patient_id')
		 ->join('district','p.district_id=district.district_id','left')
		 ->join('state','district.state_id=state.state_id','left')
		 ->join('unit','pv.unit=unit.unit_id','left')
		 ->join('area','pv.area=area.area_id','left')
		 ->join('hospital','pv.hospital_id=hospital.hospital_id','left')
		 ->join('hospital as hospital_referral_by','pv.referral_by_hospital_id=hospital_referral_by.hospital_id','left');
		$this->db->where('pv.visit_type',$visittype);			
		$resource=$this->db->get();
		return $resource->result();
	}
	function get_login_activity_detail_count($trend_type,$datefilter,$login_status,$from_date_param,$to_date_param,$hospital){
		
		if($login_status != -1){
			$this->db->where('is_success', $login_status);
		}
		
	   	if($from_date_param != -1 && $to_date_param != -1){
	   	
	   		if($from_date_param && $to_date_param){
				$from_date=date("Y-m-d",strtotime($from_date_param));
				$to_date=date("Y-m-d",strtotime($to_date_param));
			}
			else if($from_date_param || $to_date_param){
				$from_date_param?$from_date=$from_date_param:$from_date=$to_date_param;
				$to_date=$from_date;
			}
			else{
				$from_date=date("Y-m-d");
				$to_date=$from_date;
			}
	
              
			$to_time = '23:59';
			$from_time = '00:00';
			$from_timestamp = $from_date." ".$from_time;
			$to_timestamp = $to_date." ".$to_time;
			$this->db->where("(signin_date_time BETWEEN '$from_timestamp' AND '$to_timestamp')");	
	   	
	   	}
	   	//Report for day or month or year.
		if($trend_type !=-1){
			$dateValue = strtotime($datefilter); 
                        if($trend_type=="Month"){
                        	$val = date("m-Y", $dateValue); 
                            	$this->db->where("DATE_FORMAT(signin_date_time,'%m-%Y')",$val);
                        }
                        else if($trend_type=="Year"){
                        	$val = date("Y", $dateValue); 
                        	$this->db->where("DATE_FORMAT(signin_date_time,'%Y')",$val);
                        }
                        else{
                        	$val = date("d-m-Y", $dateValue); 
                   		$this->db->where("DATE_FORMAT(signin_date_time,'%d-%m-%Y')",$val);
                      	}
		}
               
	   	if($hospital!=-1){
			$this->db->where("hospital.hospital_id",$hospital);
		}	
	   			
		$this->db->select("count(*) as count",false);
		$this->db->from("user_signin")
		->join('user','user_signin.username = user.username')
		->join('staff','user.staff_id = staff.staff_id')
		->join('hospital','staff.hospital_id = hospital.hospital_id')		
		->join('department','staff.department_id = department.department_id','left');
		$this->db->where("staff.hospital_id in (select us1.hospital_id from user_hospital_link as us1 where us1.user_id='". $this->session->userdata('logged_in')['user_id']."')");			
		$resource=$this->db->get();
		return $resource->result();
	}
	function get_login_activity_detail($trend_type,$datefilter,$login_status,$from_date_param,$to_date_param,$default_rowsperpage,$hospital){
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
		
		if($login_status != -1){
			$this->db->where('is_success', $login_status);
		}
		
	   	if($from_date_param != -1 && $to_date_param != -1){
	   	
	   		if($from_date_param && $to_date_param){
				$from_date=date("Y-m-d",strtotime($from_date_param));
				$to_date=date("Y-m-d",strtotime($to_date_param));
			}
			else if($from_date_param || $to_date_param){
				$from_date_param?$from_date=$from_date_param:$from_date=$to_date_param;
				$to_date=$from_date;
			}
			else{
				$from_date=date("Y-m-d");
				$to_date=$from_date;
			}
	
              
			$to_time = '23:59';
			$from_time = '00:00';
			$from_timestamp = $from_date." ".$from_time;
			$to_timestamp = $to_date." ".$to_time;
			$this->db->where("(signin_date_time BETWEEN '$from_timestamp' AND '$to_timestamp')");	
	   	
	   	} 
	   	//Report for day or month or year.
		if($trend_type !=-1){
			$dateValue = strtotime($datefilter); 
                        if($trend_type=="Month"){
                        	$val = date("m-Y", $dateValue); 
                        	$this->db->where("DATE_FORMAT(signin_date_time,'%m-%Y')",$val);
                        }
                        else if($trend_type=="Year"){
                        	$val = date("Y", $dateValue); 
                            	$this->db->where("DATE_FORMAT(signin_date_time,'%Y')",$val);
                        }
                        else{
                        	$val = date("d-m-Y", $dateValue); 
                            	$this->db->where("DATE_FORMAT(signin_date_time,'%d-%m-%Y')",$val);
                        }
		  }
	   		
	   	if($hospital!=-1){
			$this->db->where("hospital.hospital_id",$hospital);
		}
				
		$this->db->select("user_signin.username as username,CONCAT(staff.first_name,'  ',staff.last_name) as name, (case when staff.gender = 'M' then 'Male' when staff.gender = 'F' then 'Female' when staff.gender = 'O' then 'Others' end) as gender,hospital.hospital_short_name as hospital,department.department,signin_date_time,(case when is_success = 1 then 'Success' else 'Failed' end) as status,details",false);
		$this->db->from("user_signin")
		->join('user','user_signin.username = user.username')
		->join('staff','user.staff_id = staff.staff_id')
		->join('hospital','staff.hospital_id = hospital.hospital_id')		
		->join('department','staff.department_id = department.department_id','left');
		$this->db->where("staff.hospital_id in (select us1.hospital_id from user_hospital_link as us1 where us1.user_id='". $this->session->userdata('logged_in')['user_id']."')");
		$this->db->limit($rows_per_page,$start);
		$this->db->order_by('UNIX_TIMESTAMP(signin_date_time)','ASC');			
		$resource=$this->db->get();
		return $resource->result();
	}
	
	function get_appointment_slot_count(){
	
		
		
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
	
                
		
		$this->db->where("(date BETWEEN '$from_date' AND '$to_date')");
		
		
		
		if($this->input->post('visit_name')){
			$this->db->where('aps.visit_name_id',$this->input->post('visit_name'));
		}
		if($this->input->post('department')){
			$this->db->where('aps.department_id',$this->input->post('department'));
		}
		
	        $hospital=$this->session->userdata('hospital');
		if(!!$hospital){
			$this->db->where('hospital.hospital_id',$hospital['hospital_id']);
		}
		
		$this->db->select("count(*) as count",false);
		$this->db->from('appointment_slot as aps');
		$this->db->join('department as d','aps.department_id=d.department_id','left');
		$this->db ->join('hospital','d.hospital_id=hospital.hospital_id','left');		
		$resource=$this->db->get();
		return $resource->result();
	}
	
	
	function get_appointment_slot($default_rowsperpage){
		$hospital=$this->session->userdata('hospital');
		
		$default_appointment_status_add = "";
		
		$this->db->select('id');
        $this->db->from('appointment_status aps');
		$this->db->where('aps.is_default',1);
		$this->db->where('aps.hospital_id',$hospital['hospital_id']);
		$query = $this->db->get();
        $result = $query->result_array();
		//echo("<script>console.log('default_appointment_status_add: " . json_encode($result) . "');</script>");
		if (count($result)==1){
			$default_appointment_status_add = " SUM(case when pv.appointment_status_id = ". $result[0]['id'] ." then 1 else 0 end) as default_appointment_status_add ";
		}

		$default_appointment_status_remove = "";
		$this->db->select('id');
        $this->db->from('appointment_status aps');
		$this->db->where('aps.is_default',2);
		$this->db->where('aps.hospital_id',$hospital['hospital_id']);
		$query = $this->db->get();
        $result = $query->result_array();
		//echo("<script>console.log('default_appointment_status_remove: " . json_encode($result) . "');</script>");
		if (count($result)==1){
			$default_appointment_status_remove = " SUM(case when pv.appointment_status_id = ". $result[0]['id'] ." then 1 else 0 end) as default_appointment_status_remove ";
		}

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
	
                
		
		$this->db->where("(date BETWEEN '$from_date' AND '$to_date')");
		
		
		
		if($this->input->post('visit_name')){
			$this->db->where('aps.visit_name_id',$this->input->post('visit_name'));
		}
		if($this->input->post('department')){
			$this->db->where('aps.department_id',$this->input->post('department'));
		}
		
		
		
		$this->db->where('hospital.hospital_id',$hospital['hospital_id']);
		
		
		$taken_appointments = "SUM(case when pv.visit_id is null then 0 else 1 end) as taken_appointments ";
		
		$this->db->select("aps.slot_id,aps.date,aps.from_time,aps.to_time,aps.department_id,aps.visit_name_id,aps.appointment_update_by,aps.appointment_update_time,
		d.department,CONCAT(staff.first_name, ' ', staff.last_name) as appointment_update_by_name,vn.visit_name,aps.appointments_limit ,".$taken_appointments.", ".$default_appointment_status_add.",".$default_appointment_status_remove,false);
		 $this->db->from('appointment_slot as aps')
		 ->join('department as d','aps.department_id=d.department_id','left')
		 ->join('hospital','d.hospital_id=hospital.hospital_id','left')
		 ->join('staff','aps.appointment_update_by=staff.staff_id','left')
		 ->join('visit_name vn','aps.visit_name_id=vn.visit_name_id','left')
		 ->join('patient_visit as pv',"aps.department_id=pv.department_id and pv.hospital_id = hospital.hospital_id and pv.visit_name_id = aps.visit_name_id and ifnull(date(pv.appointment_time),'')  = aps.date and ifnull(time(pv.appointment_time),'')  between aps.from_time and aps.to_time",'left');
		 $this->db->order_by('aps.department_id','ASC');
		 $this->db->order_by('aps.visit_name_id','ASC');
		 $this->db->order_by('aps.date','ASC');
		 $this->db->order_by('aps.from_time','ASC');	
		 $this->db->order_by('aps.to_time','ASC');
		 $this->db->group_by('aps.slot_id');
		 $this->db->limit($rows_per_page,$start);		
		$resource=$this->db->get();
		return $resource->result();
	}
	
	
	
	
	function get_registration_appointment($default_rowsperpage){
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
		
		
	        
	        $date_filter_field="Registration";
		if($this->input->post('dateby') && $this->input->post('dateby')=="Appointment"){
			$date_filter_field="Appointment";
		}	
					
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
		if($this->input->post('myactivity')) {		
			if($date_filter_field=="Appointment") {
				$this->db->where('pv.appointment_update_by',$this->session->userdata('logged_in')['staff_id']);
			}else if($date_filter_field=="Registration") {
				$this->db->where("p.insert_by_user_id",$this->session->userdata('logged_in')['user_id']);		
			}		
		}			
                if($this->input->post('from_time') && $this->input->post('to_time')){
			$from_time=date("H:i",strtotime($this->input->post('from_time')));
			$to_time=date("H:i",strtotime($this->input->post('to_time')));
				
		}
		else if($this->input->post('from_time') || $this->input->post('to_time')){
			if($this->input->post('from_time')){
                            $from_time=$this->input->post('from_time');
                            $to_time = '23:59';
                        }else{
                            $from_time = '00:00';
                            $to_time=$this->input->post('to_time');
                        }				
		}		
		else{
			$to_time = '23:59';
		 	$from_time = '00:00';
		}
		
		if($date_filter_field=="Registration"){
			$this->db->where("(admit_date BETWEEN '$from_date' AND '$to_date')");
			$this->db->where("(admit_time BETWEEN '$from_time' AND '$to_time')");
			$this->db->order_by('admit_date','ASC');
		 	$this->db->order_by('admit_time','ASC');
		} 
		else if($date_filter_field=="Appointment"){
			$this->db->where("(appointment_time IS NOT NULL)");				
			$from_timestamp = $from_date." ".$from_time;
			$to_timestamp = $to_date." ".$to_time;
			$this->db->where("(appointment_time BETWEEN '$from_timestamp' AND '$to_timestamp')");
			$this->db->order_by('UNIX_TIMESTAMP(appointment_time)','ASC');
		}
		if($this->input->post('appointment_status_id')){
			if($this->input->post('appointment_status_id') == -1){
				$this->db->where('pv.appointment_status_id IS NULL');
			} else {
				$this->db->where('pv.appointment_status_id',$this->input->post('appointment_status_id'));
			}
		}		
		if($this->input->post('visit_name')){
			$this->db->where('pv.visit_name_id',$this->input->post('visit_name'));
		}
		if($this->input->post('department')){
			$this->db->where('pv.department_id',$this->input->post('department'));
		}
		
		if($this->input->post('phone')){
			$search_phone_withoutzero = ltrim($this->input->post('phone'), '0');
			$this->db->where("(p.phone='0".$search_phone_withoutzero."' OR p.phone='".$search_phone_withoutzero."')");
		}
		
		if($this->input->post('patientid')){
			$this->db->where('p.patient_id',$this->input->post('patientid'));
		}
		
		if($this->input->post('opno')){
			$this->db->where('pv.hosp_file_no',$this->input->post('opno'));
		}
		
		if($this->input->post('manualid')){
			$this->db->where('p.patient_id_manual',$this->input->post('manualid'));
		}		
		
		
		if($this->input->post('unit')){
			$this->db->select('IF(unit!="",unit,0) unit',false);
			$this->db->where('pv.unit',$this->input->post('unit'));
		}
		else{
			$this->db->select('"0" as unit',false);
		}
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('pv.area',$this->input->post('area'));
		}
		else{
			$this->db->select('"0" as area',false);
		}

		$this->db->select("p.patient_id,p.patient_id_manual,p.address, hosp_file_no, pv.visit_id, CONCAT(IF(p.first_name=NULL,'',p.first_name),' ',IF(p.last_name=NULL,'',p.last_name)) name,
		p.gender, IF(p.gender='F' AND (father_name IS NULL OR father_name = ''),spouse_name, father_name) parent_spouse, age_years, age_months, age_days,
		p.place, p.phone, pvd.department, admit_date, admit_time, CONCAT(doctor.first_name, ' ', doctor.last_name) as doctor, 
		CONCAT(volunteer.first_name, ' ', volunteer.last_name) as volunteer, pv.appointment_with as appointment_with_id,
		IF(pv.signed_consultation=0, CONCAT(appointment_with.first_name, ' ', appointment_with.last_name), '') as appointment_with,
		IF(pv.signed_consultation=0, '', pv.summary_sent_time) as summary_sent_time,
		pv.appointment_time as appointment_date_time,pv.appointment_status_update_time,
		IF(pv.signed_consultation=0, DATE(appointment_time), '') as appointment_date,
		IF(pv.signed_consultation=0, TIME(appointment_time), '') as appointment_time,
		CONCAT(appointment_update_by.first_name, ' ', appointment_update_by.last_name) as appointment_update_by,
		appointment_update_time,
		pv.signed_consultation as signed,pv.appointment_status_update_by as appointment_status_update_by_id,CONCAT(appointment_status_update_by_staff.first_name, ' ', appointment_status_update_by_staff.last_name) as appointment_status_update_by_user,pv.appointment_status_id,aps.appointment_status,district.district,state.state,
		IF(pv.signed_consultation=0, sd.department, sd_doctor.department) as doctor_department,vn.visit_name,pv.visit_name_id",false);
		 $this->db->from('patient_visit as pv')
		 ->join('patient as p','pv.patient_id=p.patient_id')
		 ->join('department as pvd','pv.department_id=pvd.department_id','left')
		 ->join('district','p.district_id=district.district_id','left')
		 ->join('state','district.state_id=state.state_id','left')
		 ->join('unit','pv.unit=unit.unit_id','left')
		 ->join('area','pv.area=area.area_id','left')
		 ->join('hospital','pv.hospital_id=hospital.hospital_id','left')
		 ->join('staff as doctor','pv.signed_consultation=doctor.staff_id','left')
		 ->join('staff as appointment_with','pv.appointment_with=appointment_with.staff_id','left')
		 ->join('department as sd', 'appointment_with.department_id=sd.department_id','left')
		 ->join('department as sd_doctor', 'doctor.department_id=sd_doctor.department_id','left')
		 ->join('staff as appointment_update_by','pv.appointment_update_by=appointment_update_by.staff_id','left')	 
		 ->join('user as volunteer_user','pv.insert_by_user_id = volunteer_user.user_id','left')
		 ->join('staff as volunteer','volunteer_user.staff_id=volunteer.staff_id','left')	
		 ->join('staff as appointment_status_update_by_staff','pv.appointment_status_update_by=appointment_status_update_by_staff.staff_id','left')
		 ->join('appointment_status aps','pv.appointment_status_id=aps.id','left')	
		 ->join('visit_name vn','pv.visit_name_id=vn.visit_name_id','left')		
		 ->where('pv.hospital_id',$hospital['hospital_id'])
		 ->where('visit_type','OP');
		$this->db->limit($rows_per_page,$start);			
		$resource=$this->db->get();
		return $resource->result();
	}	
	
	function get_registration_appointment_count(){
	        $date_filter_field="Registration";
		if($this->input->post('dateby') && $this->input->post('dateby')=="Appointment"){
			$date_filter_field="Appointment";
		}
				
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
		if($this->input->post('myactivity')) {		
			if($date_filter_field=="Appointment") {
				$this->db->where('pv.appointment_update_by',$this->session->userdata('logged_in')['staff_id']);
			}else if($date_filter_field=="Registration") {
				$this->db->where("p.insert_by_user_id",$this->session->userdata('logged_in')['user_id']);		
			}		
		}	
                if($this->input->post('from_time') && $this->input->post('to_time')){
			$from_time=date("H:i",strtotime($this->input->post('from_time')));
			$to_time=date("H:i",strtotime($this->input->post('to_time')));
				
		}
		else if($this->input->post('from_time') || $this->input->post('to_time')){
			if($this->input->post('from_time')){
                            $from_time=$this->input->post('from_time');
                            $to_time = '23:59';
                        }else{
                            $from_time = '00:00';
                            $to_time=$this->input->post('to_time');
                        }				
		}		
		else{
			$to_time = '23:59';
		 	$from_time = '00:00';
		}
		
		if($date_filter_field=="Registration"){
			$this->db->where("(admit_date BETWEEN '$from_date' AND '$to_date')");
			$this->db->where("(admit_time BETWEEN '$from_time' AND '$to_time')");
		} 
		else if($date_filter_field=="Appointment"){
			$this->db->where("(appointment_time IS NOT NULL)");				
			$from_timestamp = $from_date." ".$from_time;
			$to_timestamp = $to_date." ".$to_time;
			$this->db->where("(appointment_time BETWEEN '$from_timestamp' AND '$to_timestamp')");
		}
		if($this->input->post('appointment_status_id')){
			if($this->input->post('appointment_status_id') == -1){
				$this->db->where('pv.appointment_status_id IS NULL');
			} else {
				$this->db->where('pv.appointment_status_id',$this->input->post('appointment_status_id'));
			}
		}
		if($this->input->post('visit_name')){
			$this->db->where('pv.visit_name_id',$this->input->post('visit_name'));
		}
		if($this->input->post('department')){
			$this->db->where('pv.department_id',$this->input->post('department'));
		}
		if($this->input->post('unit')){			
			$this->db->where('pv.unit',$this->input->post('unit'));
		}
		
		if($this->input->post('area')){			
			$this->db->where('pv.area',$this->input->post('area'));
		}
		
		if($this->input->post('phone')){
			$search_phone_withoutzero = ltrim($this->input->post('phone'), '0');
			$this->db->where("(p.phone='0".$search_phone_withoutzero."' OR p.phone='".$search_phone_withoutzero."')");
		}
		
		if($this->input->post('patientid')){
			$this->db->where('p.patient_id',$this->input->post('patientid'));
		}
		
		if($this->input->post('opno')){
			$this->db->where('pv.hosp_file_no',$this->input->post('opno'));
		}
		
		if($this->input->post('manualid')){
			$this->db->where('p.patient_id_manual',$this->input->post('manualid'));
		}
		
		$this->db->select("count(*) as count",false);
		 $this->db->from('patient_visit as pv')
		 ->join('patient as p','pv.patient_id=p.patient_id')
		 ->join('district','p.district_id=district.district_id','left')
		 ->join('state','district.state_id=state.state_id','left')
		 ->join('department','pv.department_id=department.department_id','left')
		 ->join('unit','pv.unit=unit.unit_id','left')
		 ->join('area','pv.area=area.area_id','left')
		 ->join('hospital','pv.hospital_id=hospital.hospital_id','left')
		 ->join('staff as doctor','pv.signed_consultation=doctor.staff_id','left')
		 ->join('staff as appointment_with','pv.appointment_with=appointment_with.staff_id','left')
		 ->join('staff as appointment_update_by','pv.appointment_update_by=appointment_update_by.staff_id','left')	 
		 ->join('user as volunteer_user','pv.insert_by_user_id = volunteer_user.user_id','left')
		 ->join('staff as volunteer','volunteer_user.staff_id=volunteer.staff_id','left')
		 ->join('staff as appointment_status_update_by_staff','pv.appointment_status_update_by=appointment_status_update_by_staff.staff_id','left')
		 ->join('appointment_status aps','pv.appointment_status_id=aps.id','left')	
		 ->join('visit_name vn','pv.visit_name_id=vn.visit_name_id','left')		
		 ->where('pv.hospital_id',$hospital['hospital_id'])
		 ->where('visit_type','OP');			
		$resource=$this->db->get();
		return $resource->result();
	}
	
	function get_op_detail_3($default_rowsperpage){
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
		
		
	        
	        $date_filter_field="Registration";
		if($this->input->post('dateby') && $this->input->post('dateby')=="Appointment"){
			$date_filter_field="Appointment";
		}	
					
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
				
		}
		else if($this->input->post('from_time') || $this->input->post('to_time')){
			if($this->input->post('from_time')){
                            $from_time=$this->input->post('from_time');
                            $to_time = '23:59';
                        }else{
                            $from_time = '00:00';
                            $to_time=$this->input->post('to_time');
                        }				
		}		
		else{
			$to_time = '23:59';
		 	$from_time = '00:00';
		}
		
		if($date_filter_field=="Registration"){
			$this->db->where("(admit_date BETWEEN '$from_date' AND '$to_date')");
			$this->db->where("(admit_time BETWEEN '$from_time' AND '$to_time')");
			$this->db->order_by('admit_date','ASC');
		 	$this->db->order_by('admit_time','ASC');
		} 
		else if($date_filter_field=="Appointment"){
			$this->db->where("(appointment_time IS NOT NULL)");				
			$from_timestamp = $from_date." ".$from_time;
			$to_timestamp = $to_date." ".$to_time;
			$this->db->where("(appointment_time BETWEEN '$from_timestamp' AND '$to_timestamp')");
			$this->db->order_by('UNIX_TIMESTAMP(appointment_time)','ASC');
		}
		
		if($this->input->post('visit_name')){
			$this->db->where('pv.visit_name_id',$this->input->post('visit_name'));
		}
		if($this->input->post('department')){
			$this->db->where('pv.department_id',$this->input->post('department'));
		}
		if($this->input->post('unit')){
			$this->db->select('IF(unit!="",unit,0) unit',false);
			$this->db->where('pv.unit',$this->input->post('unit'));
		}
		else{
			$this->db->select('"0" as unit',false);
		}
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('pv.area',$this->input->post('area'));
		}
		else{
			$this->db->select('"0" as area',false);
		}

		$this->db->select("p.patient_id, p.address, hosp_file_no, pv.visit_id, CONCAT(IF(p.first_name=NULL,'',p.first_name),' ',IF(p.last_name=NULL,'',p.last_name)) name,
		p.gender, IF(p.gender='F' AND (father_name IS NULL OR father_name = ''),spouse_name, father_name) parent_spouse, age_years, age_months, age_days,
		p.place, p.phone, pvd.department, admit_date, admit_time, CONCAT(doctor.first_name, ' ', doctor.last_name) as doctor, 
		CONCAT(volunteer.first_name, ' ', volunteer.last_name) as volunteer, pv.appointment_with as appointment_with_id,
		IF(pv.signed_consultation=0, CONCAT(appointment_with.first_name, ' ', appointment_with.last_name), '') as appointment_with,
		IF(pv.signed_consultation=0, DATE(appointment_time), '') as appointment_date,
		IF(pv.signed_consultation=0, TIME(appointment_time), '') as appointment_time,
		pv.signed_consultation as signed,district.district,state.state,vn.visit_name,pv.visit_name_id,pv.decision,pv.final_diagnosis",false);
		 $this->db->from('patient_visit as pv')
		 ->join('patient as p','pv.patient_id=p.patient_id')
		 ->join('department as pvd','pv.department_id=pvd.department_id','left')
		 ->join('district','p.district_id=district.district_id','left')
		 ->join('state','district.state_id=state.state_id','left')
		 ->join('unit','pv.unit=unit.unit_id','left')
		 ->join('area','pv.area=area.area_id','left')
		 ->join('hospital','pv.hospital_id=hospital.hospital_id','left')
		 ->join('staff as doctor','pv.signed_consultation=doctor.staff_id','left')
		 ->join('staff as appointment_with','pv.appointment_with=appointment_with.staff_id','left')
		 ->join('department as sd', 'appointment_with.department_id=sd.department_id','left')
		 ->join('user as volunteer_user','p.insert_by_user_id = volunteer_user.user_id','left')
		 ->join('staff as volunteer','volunteer_user.staff_id=volunteer.staff_id','left')
		 ->join('visit_name vn','pv.visit_name_id=vn.visit_name_id','left')		
		 ->where('pv.hospital_id',$hospital['hospital_id'])
		 ->where('visit_type','OP');
		$this->db->limit($rows_per_page,$start);			
		$resource=$this->db->get();
		return $resource->result();
	}	
	
	function get_op_detail_3_count(){
	        $date_filter_field="Registration";
		if($this->input->post('dateby') && $this->input->post('dateby')=="Appointment"){
			$date_filter_field="Appointment";
		}
				
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
				
		}
		else if($this->input->post('from_time') || $this->input->post('to_time')){
			if($this->input->post('from_time')){
                            $from_time=$this->input->post('from_time');
                            $to_time = '23:59';
                        }else{
                            $from_time = '00:00';
                            $to_time=$this->input->post('to_time');
                        }				
		}		
		else{
			$to_time = '23:59';
		 	$from_time = '00:00';
		}
		
		if($date_filter_field=="Registration"){
			$this->db->where("(admit_date BETWEEN '$from_date' AND '$to_date')");
			$this->db->where("(admit_time BETWEEN '$from_time' AND '$to_time')");
		} 
		else if($date_filter_field=="Appointment"){
			$this->db->where("(appointment_time IS NOT NULL)");				
			$from_timestamp = $from_date." ".$from_time;
			$to_timestamp = $to_date." ".$to_time;
			$this->db->where("(appointment_time BETWEEN '$from_timestamp' AND '$to_timestamp')");
		}
		
		if($this->input->post('visit_name')){
			$this->db->where('pv.visit_name_id',$this->input->post('visit_name'));
		}
		if($this->input->post('department')){
			$this->db->where('pv.department_id',$this->input->post('department'));
		}
		if($this->input->post('unit')){			
			$this->db->where('pv.unit',$this->input->post('unit'));
		}
		
		if($this->input->post('area')){			
			$this->db->where('pv.area',$this->input->post('area'));
		}
		

		$this->db->select("count(*) as count",false);
		 $this->db->from('patient_visit as pv')
		 ->join('patient as p','pv.patient_id=p.patient_id')
		 ->join('department as pvd','pv.department_id=pvd.department_id','left')
		 ->join('district','p.district_id=district.district_id','left')
		 ->join('state','district.state_id=state.state_id','left')
		 ->join('unit','pv.unit=unit.unit_id','left')
		 ->join('area','pv.area=area.area_id','left')
		 ->join('hospital','pv.hospital_id=hospital.hospital_id','left')
		 ->join('staff as doctor','pv.signed_consultation=doctor.staff_id','left')
		 ->join('staff as appointment_with','pv.appointment_with=appointment_with.staff_id','left')
		 ->join('department as sd', 'appointment_with.department_id=sd.department_id','left')
		 ->join('user as volunteer_user','p.insert_by_user_id = volunteer_user.user_id','left')
		 ->join('staff as volunteer','volunteer_user.staff_id=volunteer.staff_id','left')
		 ->join('visit_name vn','pv.visit_name_id=vn.visit_name_id','left')		
		 ->where('pv.hospital_id',$hospital['hospital_id'])
		 ->where('visit_type','OP');			
		$resource=$this->db->get();
		return $resource->result();
	}
	
	function get_op_detail_followup_count(){
	        $date_filter_field="Registration";
		if($this->input->post('dateby') && $this->input->post('dateby')=="Appointment"){
			$date_filter_field="Appointment";
		}
				
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
				
		}
		else if($this->input->post('from_time') || $this->input->post('to_time')){
			if($this->input->post('from_time')){
                            $from_time=$this->input->post('from_time');
                            $to_time = '23:59';
                        }else{
                            $from_time = '00:00';
                            $to_time=$this->input->post('to_time');
                        }				
		}		
		else{
			$to_time = '23:59';
		 	$from_time = '00:00';
		}
		
		if($date_filter_field=="Registration"){
			$this->db->where("(admit_date BETWEEN '$from_date' AND '$to_date')");
			$this->db->where("(admit_time BETWEEN '$from_time' AND '$to_time')");
		} 
		else if($date_filter_field=="Appointment"){
			$this->db->where("(appointment_time IS NOT NULL)");				
			$from_timestamp = $from_date." ".$from_time;
			$to_timestamp = $to_date." ".$to_time;
			$this->db->where("(appointment_time BETWEEN '$from_timestamp' AND '$to_timestamp')");
		}
		
		if($this->input->post('visit_name')){
			$this->db->where('pv.visit_name_id',$this->input->post('visit_name'));
		}
		if($this->input->post('department')){
			$this->db->where('pv.department_id',$this->input->post('department'));
		}
		if($this->input->post('unit')){			
			$this->db->where('pv.unit',$this->input->post('unit'));
		}
		
		if($this->input->post('area')){			
			$this->db->where('pv.area',$this->input->post('area'));
		}
		

		$this->db->select("count(*) as count",false);
		 $this->db->from('patient_visit as pv')
		 ->join('patient as p','pv.patient_id=p.patient_id')
		 ->join('department as pvd','pv.department_id=pvd.department_id','left')
		 ->join('district','p.district_id=district.district_id','left')
		 ->join('state','district.state_id=state.state_id','left')
		 ->join('unit','pv.unit=unit.unit_id','left')
		 ->join('area','pv.area=area.area_id','left')
		 ->join('hospital','pv.hospital_id=hospital.hospital_id','left')
		 ->join('staff as appointment_with','pv.appointment_with=appointment_with.staff_id','left')
		 ->join('department as sd', 'appointment_with.department_id=sd.department_id','left')
		 ->join('user as volunteer_user','p.insert_by_user_id = volunteer_user.user_id','left')
		 ->join('staff as volunteer','volunteer_user.staff_id=volunteer.staff_id','left')
		 ->join('visit_name vn','pv.visit_name_id=vn.visit_name_id','left')		
		 ->where('pv.hospital_id',$hospital['hospital_id'])
		 ->where('visit_type','OP');			
		$resource=$this->db->get();
		return $resource->result();
	}
	
	function get_op_detail_followup($default_rowsperpage){
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
		
		
	        
	        $date_filter_field="Registration";
		if($this->input->post('dateby') && $this->input->post('dateby')=="Appointment"){
			$date_filter_field="Appointment";
		}	
					
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
				
		}
		else if($this->input->post('from_time') || $this->input->post('to_time')){
			if($this->input->post('from_time')){
                            $from_time=$this->input->post('from_time');
                            $to_time = '23:59';
                        }else{
                            $from_time = '00:00';
                            $to_time=$this->input->post('to_time');
                        }				
		}		
		else{
			$to_time = '23:59';
		 	$from_time = '00:00';
		}
		
		if($date_filter_field=="Registration"){
			$this->db->where("(admit_date BETWEEN '$from_date' AND '$to_date')");
			$this->db->where("(admit_time BETWEEN '$from_time' AND '$to_time')");
			$this->db->order_by('admit_date','ASC');
		 	$this->db->order_by('admit_time','ASC');
		} 
		else if($date_filter_field=="Appointment"){
			$this->db->where("(appointment_time IS NOT NULL)");				
			$from_timestamp = $from_date." ".$from_time;
			$to_timestamp = $to_date." ".$to_time;
			$this->db->where("(appointment_time BETWEEN '$from_timestamp' AND '$to_timestamp')");
			$this->db->order_by('UNIX_TIMESTAMP(appointment_time)','ASC');
		}
		
		if($this->input->post('visit_name')){
			$this->db->where('pv.visit_name_id',$this->input->post('visit_name'));
		}
		if($this->input->post('department')){
			$this->db->where('pv.department_id',$this->input->post('department'));
		}
		if($this->input->post('unit')){
			$this->db->select('IF(unit!="",unit,0) unit',false);
			$this->db->where('pv.unit',$this->input->post('unit'));
		}
		else{
			$this->db->select('"0" as unit',false);
		}
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('pv.area',$this->input->post('area'));
		}
		else{
			$this->db->select('"0" as area',false);
		}

		$this->db->select("p.patient_id, p.address, hosp_file_no, pv.visit_id, CONCAT(IF(p.first_name=NULL,'',p.first_name),' ',IF(p.last_name=NULL,'',p.last_name)) name,
		p.gender, IF(p.gender='F' AND (father_name IS NULL OR father_name = ''),spouse_name, father_name) parent_spouse, age_years, age_months, age_days,
		p.place, p.phone, pvd.department, admit_date, admit_time, 
		CONCAT(volunteer.first_name, ' ', volunteer.last_name) as volunteer, pv.appointment_with as appointment_with_id,
		pv.signed_consultation as signed,district.district,state.state,vn.visit_name,pv.visit_name_id,pf.diagnosis,pt.priority_type,pf.note",false);
		 $this->db->from('patient_visit as pv')
		 ->join('patient as p','pv.patient_id=p.patient_id')
		 ->join('patient_followup as pf','pf.patient_id=p.patient_id','left')
		 ->join('priority_type as pt','pt.priority_type_id=pf.priority_type_id','left')
		 ->join('department as pvd','pv.department_id=pvd.department_id','left')
		 ->join('district','p.district_id=district.district_id','left')
		 ->join('state','district.state_id=state.state_id','left')
		 ->join('unit','pv.unit=unit.unit_id','left')
		 ->join('area','pv.area=area.area_id','left')
		 ->join('hospital','pv.hospital_id=hospital.hospital_id','left')
		 ->join('staff as appointment_with','pv.appointment_with=appointment_with.staff_id','left')
		 ->join('department as sd', 'appointment_with.department_id=sd.department_id','left')
		 ->join('user as volunteer_user','p.insert_by_user_id = volunteer_user.user_id','left')
		 ->join('staff as volunteer','volunteer_user.staff_id=volunteer.staff_id','left')
		 ->join('visit_name vn','pv.visit_name_id=vn.visit_name_id','left')		
		 ->where('pv.hospital_id',$hospital['hospital_id'])
		 ->where('visit_type','OP');
		$this->db->limit($rows_per_page,$start);			
		$resource=$this->db->get();
		return $resource->result();
	}
	
	function get_appointment_status($default_rowsperpage){
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
				
		}
		else if($this->input->post('from_time') || $this->input->post('to_time')){
			if($this->input->post('from_time')){
                            $from_time=$this->input->post('from_time');
                            $to_time = '23:59';
                        }else{
                            $from_time = '00:00';
                            $to_time=$this->input->post('to_time');
                        }				
		}		
		else{
			$to_time = '23:59';
		 	$from_time = '00:00';
		}
						
		$from_timestamp = $from_date." ".$from_time;
		$to_timestamp = $to_date." ".$to_time;
		$this->db->where("(appointment_time BETWEEN '$from_timestamp' AND '$to_timestamp')");
		$this->db->order_by('UNIX_TIMESTAMP(appointment_time)','ASC');
		
		
		if($this->input->post('visit_name')){
			$this->db->where('pv.visit_name_id',$this->input->post('visit_name'));
		}
		
		if($this->input->post('appointment_status_id')){
			$this->db->where('pv.appointment_status_id',$this->input->post('appointment_status_id'));
		}		
	
		if($this->input->post('phone')){
			$search_phone_withoutzero = ltrim($this->input->post('phone'), '0');
			$this->db->where("(p.phone='0".$search_phone_withoutzero."' OR p.phone='".$search_phone_withoutzero."')");
		}
		
		if($this->input->post('h4allid')){
			$this->db->where('p.patient_id',$this->input->post('h4allid'));
		}
		
		if($this->input->post('opno')){
			$this->db->where('hosp_file_no',$this->input->post('opno'));
		}
		
		if($this->input->post('manualid')){
			$this->db->where('p.patient_id_manual',$this->input->post('manualid'));
		}		
		
		if($this->input->post('department')){
			$this->db->where('pv.department_id',$this->input->post('department'));
		}
		if($this->input->post('unit')){
			$this->db->select('IF(unit!="",unit,0) unit',false);
			$this->db->where('pv.unit',$this->input->post('unit'));
		}
		else{
			$this->db->select('"0" as unit',false);
		}
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('pv.area',$this->input->post('area'));
		}
		else{
			$this->db->select('"0" as area',false);
		}

		$this->db->select("p.patient_id, p.address,p.patient_id_manual, hosp_file_no, pv.visit_id, pv.visit_name_id,vs.visit_name, CONCAT(IF(p.first_name=NULL,'',p.first_name),' ',IF(p.last_name=NULL,'',p.last_name)) name,
		p.gender, IF(p.gender='F' AND (father_name IS NULL OR father_name = ''),spouse_name, father_name) parent_spouse, age_years, age_months, age_days,
		p.place, p.phone, department,pv.appointment_time as appointment_date_time,
pv.appointment_status_update_time,pv.appointment_status_update_by as appointment_status_update_by_id,CONCAT(appointment_status_update_by_staff.first_name, ' ', appointment_status_update_by_staff.last_name) as appointment_status_update_by_user,pv.appointment_status_id,aps.appointment_status",false);
		 $this->db->from('patient_visit as pv')
		 ->join('patient as p','pv.patient_id=p.patient_id')
		 ->join('visit_name vs','pv.visit_name_id=vs.visit_name_id','left')
		 ->join('department','pv.department_id=department.department_id','left')
		 ->join('unit','pv.unit=unit.unit_id','left')
		 ->join('area','pv.area=area.area_id','left')
		 ->join('hospital','pv.hospital_id=hospital.hospital_id','left')	 
		 ->join('staff as appointment_status_update_by_staff','pv.appointment_status_update_by=appointment_status_update_by_staff.staff_id','left')
		 ->join('appointment_status aps','pv.appointment_status_id=aps.id','left')		
		 ->where('pv.hospital_id',$hospital['hospital_id'])
		 ->where('visit_type','OP');
		$this->db->limit($rows_per_page,$start);			
		$resource=$this->db->get();
		return $resource->result();
	}

	function get_appointment_status_count(){			
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
				
		}
		else if($this->input->post('from_time') || $this->input->post('to_time')){
			if($this->input->post('from_time')){
                            $from_time=$this->input->post('from_time');
                            $to_time = '23:59';
                        }else{
                            $from_time = '00:00';
                            $to_time=$this->input->post('to_time');
                        }				
		}		
		else{
			$to_time = '23:59';
		 	$from_time = '00:00';
		}
		
				
		$from_timestamp = $from_date." ".$from_time;
		$to_timestamp = $to_date." ".$to_time;
		$this->db->where("(appointment_time BETWEEN '$from_timestamp' AND '$to_timestamp')");
		
		
		if($this->input->post('visit_name')){
			$this->db->where('pv.visit_name_id',$this->input->post('visit_name'));
		}
		
		if($this->input->post('appointment_status_id')){
			$this->db->where('pv.appointment_status_id',$this->input->post('appointment_status_id'));
		}
		
		if($this->input->post('phone')){
			$search_phone_withoutzero = ltrim($this->input->post('phone'), '0');
			$this->db->where("(p.phone='0".$search_phone_withoutzero."' OR p.phone='".$search_phone_withoutzero."')");
		}
		
		if($this->input->post('h4allid')){
			$this->db->where('p.patient_id',$this->input->post('h4allid'));
		}
		
		if($this->input->post('opno')){
			$this->db->where('hosp_file_no',$this->input->post('opno'));
		}
		
		if($this->input->post('manualid')){
			$this->db->where('p.patient_id_manual',$this->input->post('manualid'));
		}
		
		if($this->input->post('department')){
			$this->db->where('pv.department_id',$this->input->post('department'));
		}
		if($this->input->post('unit')){			
			$this->db->where('pv.unit',$this->input->post('unit'));
		}
		
		if($this->input->post('area')){			
			$this->db->where('pv.area',$this->input->post('area'));
		}
		

		$this->db->select("count(*) as count",false);
		 $this->db->from('patient_visit as pv')
		 ->join('patient as p','pv.patient_id=p.patient_id')
		 ->join('visit_name vs','pv.visit_name_id=vs.visit_name_id','left')
		 ->join('department','pv.department_id=department.department_id','left')
		 ->join('unit','pv.unit=unit.unit_id','left')
		 ->join('area','pv.area=area.area_id','left')
		 ->join('hospital','pv.hospital_id=hospital.hospital_id','left')	 
		 ->join('staff as appointment_status_update_by_staff','pv.appointment_status_update_by=appointment_status_update_by_staff.staff_id','left')
		 ->join('appointment_status aps','pv.appointment_status_id=aps.id','left')		
		 ->where('pv.hospital_id',$hospital['hospital_id'])
		 ->where('visit_type','OP');			
		$resource=$this->db->get();
		return $resource->result();
	}
	
	function get_appointment_summary(){		
	       	
					
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
				
		}
		else if($this->input->post('from_time') || $this->input->post('to_time')){
			if($this->input->post('from_time')){
                            $from_time=$this->input->post('from_time');
                            $to_time = '23:59';
                        }else{
                            $from_time = '00:00';
                            $to_time=$this->input->post('to_time');
                        }				
		}		
		else{
			$to_time = '23:59';
		 	$from_time = '00:00';
		}
		
	
		$this->db->where("(pv1.appointment_time IS NOT NULL)");				
		$from_timestamp = $from_date." ".$from_time;
		$to_timestamp = $to_date." ".$to_time;
		$this->db->where("(pv1.appointment_time BETWEEN '$from_timestamp' AND '$to_timestamp')");
		$this->db->order_by('UNIX_TIMESTAMP(pv1.appointment_time)','ASC');
		
		$extraWhere = "";
		$extraSlotWhere = "";
		if($this->input->post('visit_name')){
			$this->db->where('pv1.visit_name_id',$this->input->post('visit_name'));
			$this->db->where("pv1.visit_name_id is not null");
			$this->db->where("pv1.visit_name_id != ",0);	
			$extraWhere = $extraWhere ." AND pv2.visit_name_id=pv1.visit_name_id";
			$extraSlotWhere = $extraSlotWhere ." AND aps.visit_name_id=pv1.visit_name_id";		
		}
		
		if($this->input->post('appointment_status_id')){
			$this->db->where('pv1.appointment_status_id',$this->input->post('appointment_status_id'));
			$extraWhere = $extraWhere  ." AND pv2.appointment_status_id=pv1.appointment_status_id";
		}			
		
		if($this->input->post('department')){
			$this->db->where('pv1.department_id',$this->input->post('department'));			
		}
		
		if($this->input->post('unit')){
			$this->db->select('IF(unit!="",unit,0) unit',false);
			$this->db->where('pv1.unit',$this->input->post('unit'));
			$extraWhere = $extraWhere ." AND pv2.unit=pv1.unit ";
		}
		
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('pv1.area',$this->input->post('area'));
			$extraWhere = $extraWhere ." AND pv2.area=pv1.area ";
		}
		
		$slots_alloted = "(Select sum(appointments_limit) from appointment_slot aps where aps.department_id = pv1.department_id and aps.date = ifnull(date(pv1.appointment_time),'')  ". $extraSlotWhere .") as slots_alloted";
		
		$this->db->select("DATE(pv1.appointment_time) as appointment_date, COUNT(*) AS patient_count, 
SUM(CASE WHEN aps.is_default =  1 THEN 1 ELSE 0 END) AS default_status_count_add,SUM(CASE WHEN aps.is_default =  2 THEN 1 ELSE 0 END) AS default_status_count_remove,IFNULL(d.department,'Not set') as department_name,IFNULL(d.department_id,'Not set') as department_id, ".$slots_alloted,false);
		 $this->db->from('patient_visit as pv1')
		 ->join('visit_name vs','pv1.visit_name_id=vs.visit_name_id','left')
		 ->join('department d','pv1.department_id=d.department_id','left')
		 ->join('unit','pv1.unit=unit.unit_id','left')
		 ->join('area','pv1.area=area.area_id','left')
		 ->join('appointment_status aps','pv1.appointment_status_id=aps.id','left')		
		 ->where('pv1.hospital_id',$hospital['hospital_id'])
		 ->where('pv1.visit_type','OP');
		$this->db->group_by(array("DATE(pv1.appointment_time)", "pv1.department_id"));			
		$resource=$this->db->get();
		return $resource->result();
	}
	
	function get_appointment_summary_by_staff(){		
	       	
					
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
				
		}
		else if($this->input->post('from_time') || $this->input->post('to_time')){
			if($this->input->post('from_time')){
                            $from_time=$this->input->post('from_time');
                            $to_time = '23:59';
                        }else{
                            $from_time = '00:00';
                            $to_time=$this->input->post('to_time');
                        }				
		}		
		else{
			$to_time = '23:59';
		 	$from_time = '00:00';
		}
		
	
		$this->db->where("(pv1.appointment_time IS NOT NULL)");				
		$from_timestamp = $from_date." ".$from_time;
		$to_timestamp = $to_date." ".$to_time;
		$this->db->where("(pv1.appointment_time BETWEEN '$from_timestamp' AND '$to_timestamp')");
		$this->db->order_by('UNIX_TIMESTAMP(pv1.appointment_time)','ASC');
		
		$extraWhere = "";
		$extraSlotWhere = "";
		if($this->input->post('visit_name')){
			$this->db->where('pv1.visit_name_id',$this->input->post('visit_name'));
			$this->db->where("pv1.visit_name_id is not null");
			$this->db->where("pv1.visit_name_id != ",0);	
			$extraWhere = $extraWhere ." AND pv2.visit_name_id=pv1.visit_name_id";
			$extraSlotWhere = $extraSlotWhere ." AND aps.visit_name_id=pv1.visit_name_id";		
		}
		
		if($this->input->post('appointment_status_id')){
			$this->db->where('pv1.appointment_status_id',$this->input->post('appointment_status_id'));
			$extraWhere = $extraWhere  ." AND pv2.appointment_status_id=pv1.appointment_status_id";
		}			
		
		if($this->input->post('department')){
			$this->db->where('pv1.department_id',$this->input->post('department'));			
		}
		
		if($this->input->post('unit')){
			$this->db->select('IF(unit!="",unit,0) unit',false);
			$this->db->where('pv1.unit',$this->input->post('unit'));
			$extraWhere = $extraWhere ." AND pv2.unit=pv1.unit ";
		}
		
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('pv1.area',$this->input->post('area'));
			$extraWhere = $extraWhere ." AND pv2.area=pv1.area ";
		}
		
	
		
		$this->db->select("CONCAT(appointment_update_by.first_name, ' ', appointment_update_by.last_name) AS appointment_update_by, COUNT(*) AS patient_count, 
SUM(CASE WHEN aps.is_default =  1 THEN 1 ELSE 0 END) AS default_status_count",false);
		 $this->db->from('patient_visit as pv1')
		 ->join('visit_name vs','pv1.visit_name_id=vs.visit_name_id','left')
		 ->join('staff as appointment_update_by','pv1.appointment_update_by=appointment_update_by.staff_id','left')	 
		 ->join('unit','pv1.unit=unit.unit_id','left')
		 ->join('area','pv1.area=area.area_id','left')
		 ->join('appointment_status aps','pv1.appointment_status_id=aps.id','left')		
		 ->where('pv1.hospital_id',$hospital['hospital_id'])
		 ->where('pv1.visit_type','OP');
		$this->db->group_by("pv1.appointment_update_by");			
		$resource=$this->db->get();
		return $resource->result();
	}
	
		
	function validate_appointment_slot(){
	
	$this->db->select('count(*) as count');
        $this->db->from('appointment_slot');
        
        if($this->input->post('department_id')){
            $this->db->where('department_id',$this->input->post('department_id'));
        }
        else {
        	return 4;
        }
 
        if($this->input->post('visit_name_id')){
            $this->db->where('visit_name_id',$this->input->post('visit_name_id'));
        }
        else {
        	return 0;
        }
        if($this->input->post('appointment_time')){
            $date = date("Y-m-d", strtotime($this->input->post('appointment_time')));
            $this->db->where('date',$date);
        }
        else {
        	return 5;
        }
       
        $query = $this->db->get();
        $result = $query->result_array();
        if ($result[0]['count'] > 0){
        	$this->db->select('appointments_limit as appointments_limit,from_time as from_time,to_time as to_time');
        	$this->db->from('appointment_slot');
        
		$this->db->where('department_id',$this->input->post('department_id'));
		
		
		$this->db->where('visit_name_id',$this->input->post('visit_name_id'));
		
		
		$date = date("Y-m-d", strtotime($this->input->post('appointment_time')));
		$time = date("H:i:s", strtotime($this->input->post('appointment_time')));
		$this->db->where('date',$date);
		$this->db->where('from_time <=',$time);
		$this->db->where('to_time >=',$time);
		
		$query = $this->db->get();
        	$result = $query->result_array();
        	if (count($result)==1){
        		$appointments_limit = $result[0]['appointments_limit'];
        		$from_time = $result[0]['from_time'];
        		$to_time = $result[0]['to_time'];
        		
        		$this->db->select('count(*) as count',false);
        		$this->db->from('patient_visit');
        
			
			$this->db->where('department_id',$this->input->post('department_id'));
			
			
			$this->db->where('visit_name_id',$this->input->post('visit_name_id'));
			
			
			$date = date("Y-m-d", strtotime($this->input->post('appointment_time')));
			$from_timestamp = $date." ".$from_time;
			$to_timestamp = $date." ".$to_time;

			$this->db->where("(appointment_time BETWEEN '$from_timestamp' AND '$to_timestamp')");
			$this->db->where("(ifnull(appointment_status_id,'') not in (select id from appointment_status where is_default=2 and hospital_id=(select hospital_id from department where department_id=". $this->input->post('department_id').") ) )"); 
        		$query = $this->db->get();
        		$result = $query->result_array();
        		$appoints_taken = $result[0]['count'];
        		
        		$operation="add";
        		$curr_appointment_time="";
        		$this->db->select("ifnull(appointment_time,'') as appointment_time,ifnull(department_id,'') as department_id,ifnull(visit_name_id,'') as visit_name_id",false);
        		$this->db->from('patient_visit');
        		 if($this->input->post('visit_id')){
            			$this->db->where('visit_id',$this->input->post('visit_id'));
        		}
        		else {
        			return 1;
        		}
        				
			
			
        		$query = $this->db->get();
        		$result = $query->result_array();
        		if (count($result) > 0) {
				$curr_appointment_time = $result[0]['appointment_time'];
				$department_id = $result[0]['department_id'];
				$visit_name_id = $result[0]['visit_name_id'];
				//echo("<script>console.log('from_timestamp: " . $from_timestamp . "');</script>");
				//echo("<script>console.log('curr_appointment_time: " . $curr_appointment_time . "');</script>");
				//echo("<script>console.log('to_timestamp: " . $to_timestamp . "');</script>");
				if($curr_appointment_time!=""){
					if( strtotime($curr_appointment_time) >= strtotime($from_timestamp) && strtotime($curr_appointment_time)<= strtotime($to_timestamp) && $department_id==$this->input->post('department_id') && $visit_name_id==$this->input->post('visit_name_id'))
					{
						$operation="update";	
					}
				}
        		}
        		//echo("<script>console.log('operation: " . $operation . "');</script>");
        		
        		if($appoints_taken < $appointments_limit) {
        			return 0;
        		}
        		else{
        			if ($operation=="update"){
        				return 0;
        			}
        			else {
        				return 3;
        			}
        		}
        	}
        	else {
        		return 2;
        	}
      		
      	}
       else{
       
        	return 0;
        }
        
    	}
	function add_appointment_slot(){
	
	$this->db->select('count(*) as count');
        $this->db->from('appointment_slot');
        
        $appointment_info = array();
        
        if($this->input->post('department')){
            $appointment_info['department_id'] = $this->input->post('department');
            $this->db->where('department_id',$this->input->post('department'));
        }
        if($this->input->post('visit')){
            $appointment_info['visit_name_id'] = $this->input->post('visit');
            $this->db->where('visit_name_id',$this->input->post('visit'));
        }
        if($this->input->post('date')){
            $date = date("Y-m-d", strtotime($this->input->post('date')));
            $appointment_info['date'] =  $date;
            $this->db->where('date',$date);
        }
        $from_time_filter = '';
        if($this->input->post('from_time')){
            $from_time = date("H:i:s", strtotime($this->input->post('from_time')));
            $from_time_filter = $from_time_filter ." (from_time >= '". $from_time."'";
            $from_time_filter = $from_time_filter ."  or to_time >= '".$from_time."')";
            $appointment_info['from_time'] = $from_time;
        }
        $to_time_filter = '';        
        if($this->input->post('to_time')){
            $to_time = date("H:i:s", strtotime($this->input->post('to_time')));
            $to_time_filter = $to_time_filter ." (from_time <= '". $to_time."'";
            $to_time_filter = $to_time_filter ."  or to_time <= '".$to_time."')";
            $appointment_info['to_time'] = $to_time;
        }
        $this->db->where('( '.$from_time_filter. ' and '.$to_time_filter.')');
        $query = $this->db->get();
        $result = $query->result_array();
      	if ($result[0]['count'] > 0){
      		return 2;
      	}
       
        if($this->input->post('appointments')){
            $appointment_info['appointments_limit'] = $this->input->post('appointments');
        }
        
        
	$appointment_info['appointment_update_by'] = $this->session->userdata('logged_in')['staff_id'];
	$appointment_info['appointment_update_time'] = date("Y-m-d H:i:s");
        $this->db->trans_start();
        $this->db->insert('appointment_slot',$appointment_info);
        $this->db->trans_complete();
        if($this->db->trans_status()==FALSE){
                return 1;              
        	}
        else{
                return 0;
        	} 
    	}
    	function update_appointment_slot(){
    	$appointment_info = array();
        if($this->input->post('slot_id')){
           $this->db->where('slot_id', $this->input->post('slot_id'));
        }
        else {
        	return true;
        }
        if($this->input->post('appointments_limit')!=""){
            $appointment_info['appointments_limit'] = $this->input->post('appointments_limit');
        }
        $appointment_info['appointment_update_by'] = $this->session->userdata('logged_in')['staff_id'];
	$appointment_info['appointment_update_time'] = date("Y-m-d H:i:s");
        $this->db->trans_start();
        $this->db->update('appointment_slot',$appointment_info);
        $this->db->trans_complete();
        if($this->db->trans_status()==FALSE){
                return false;
                
        	}
        else{
                return true;
        	} 
    	}
    	
    	function delete_appointment_slot(){
        if($this->input->post('slot_id')){
           $this->db->where('slot_id', $this->input->post('slot_id'));
        }
        else {
        	return true;
        }
       
        $this->db->trans_start();
        $this->db->delete('appointment_slot');
        $this->db->trans_complete();
        if($this->db->trans_status()==FALSE){
                return false;
                
        	}
        else{
                return true;
        	} 
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
    	
    	function update_appointment_status(){
        $appointment_info = array();
        if($this->input->post('appointment_status_id_val')){
            $appointment_info['appointment_status_id'] = $this->input->post('appointment_status_id_val');
        }
     
        if($this->input->post('appointment_status_time')){
            $appointment_info['appointment_status_update_time'] = $this->input->post('appointment_status_time');
        }
	$appointment_info['appointment_status_update_by'] = $this->session->userdata('logged_in')['staff_id'];
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
		$date_filter_field="Appointment";
		if($this->input->post('dateby') && $this->input->post('dateby')=="Registration"){
			$date_filter_field="Registration";
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
	
                if($this->input->post('from_time') && $this->input->post('to_time')){
			$from_time=date("H:i",strtotime($this->input->post('from_time')));
			$to_time=date("H:i",strtotime($this->input->post('to_time')));
				
		}
		else if($this->input->post('from_time') || $this->input->post('to_time')){
			if($this->input->post('from_time')){
                            $from_time=$this->input->post('from_time');
                            $to_time = '23:59';
                        }else{
                            $from_time = '00:00';
                            $to_time=$this->input->post('to_time');
                        }				
		}		
		else{
			$to_time = '23:59';
		 	$from_time = '00:00';
		}
		
		if($date_filter_field=="Registration"){
			$this->db->where("(admit_date BETWEEN '$from_date' AND '$to_date')");
			$this->db->where("(admit_time BETWEEN '$from_time' AND '$to_time')");
		} 
		else if($date_filter_field=="Appointment"){
			$this->db->where("(appointment_time IS NOT NULL)");				
			$from_timestamp = $from_date." ".$from_time;
			$to_timestamp = $to_date." ".$to_time;
			$this->db->where("(appointment_time BETWEEN '$from_timestamp' AND '$to_timestamp')");
			$this->db->order_by('UNIX_TIMESTAMP(appointment_time)','ASC');
		}
		
		if($this->input->post('visit_name')){
			$this->db->where('pv.visit_name_id',$this->input->post('visit_name'));
		}
		if($this->input->post('department')){
			$this->db->where('pv.department_id',$this->input->post('department'));
		}
		if($this->input->post('unit')){
			$this->db->select('IF(unit!="",unit,0) unit',false);
			$this->db->where('pv.unit',$this->input->post('unit'));
		}
		else{
			$this->db->select('"0" as unit',false);
		}
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('pv.area',$this->input->post('area'));
		}
		else{
			$this->db->select('"0" as area',false);
		}
						
		$this->db->select("p.patient_id, p.address, hosp_file_no, pv.visit_id, CONCAT(IF(p.first_name=NULL,'',p.first_name),' ',IF(p.last_name=NULL,'',p.last_name)) name,
		p.gender, IF(p.gender='F' AND (father_name IS NULL OR father_name = ''),spouse_name, father_name) parent_spouse, age_years, age_months, age_days,
		p.place, p.phone, department, admit_date, admit_time, CONCAT(doctor.first_name, ' ', doctor.last_name) as doctor, 
		CONCAT(volunteer.first_name, ' ', volunteer.last_name) as volunteer, pv.appointment_with as appointment_with_id,
		IF(pv.signed_consultation=0, CONCAT(appointment_with.first_name, ' ', appointment_with.last_name), '') as appointment_with,
		appointment_time, summary_sent_time, appointment_update_time,   
		CONCAT(appointment_update_by.first_name, ' ', appointment_update_by.last_name) as appointment_update_by,
		pv.signed_consultation as signed,vn.visit_name",false);
		
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
		$this->db->join('visit_name vn','pv.visit_name_id=vn.visit_name_id','left');	
		$current_hospital = $hospital['hospital_id'];
		$user_staff_id = $this->session->userdata('logged_in')['staff_id'];
		
		$where = "pv.hospital_id = $current_hospital
			  AND visit_type = 'OP'
			  AND (pv.appointment_with = $user_staff_id OR pv.signed_consultation = $user_staff_id)";
		$this->db->where($where);
		
		//$this->db->order_by('admit_date','ASC');
		//$this->db->order_by('admit_time','ASC');
		
		$resource=$this->db->get();
		return $resource->result();

    
	}

	function get_ip_detail_count($department, $unit, $area, $gender, $from_age, $to_age, $from_date, $to_date, $visit_name, $date_type = 0, $outcome = 0)
	{
		$hospital = $this->session->userdata('hospital');
		if ($this->input->post('from_date') && $this->input->post('to_date')) {
			$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
		} else if ($this->input->post('from_date') || $this->input->post('to_date')) {
			$this->input->post('from_date') ? $from_date = $this->input->post('from_date') : $from_date = $this->input->post('to_date');
			$to_date = $from_date;
		} else if ($from_date == '0' && $to_date == '0') {
			$from_date = date("Y-m-d");
			$to_date = $from_date;
		}
		if ($this->input->post('from_time') && $this->input->post('to_time')) {
			$from_time = date("H:i", strtotime($this->input->post('from_time')));
			$to_time = date("H:i", strtotime($this->input->post('to_time')));
			$this->db->where("(admit_time BETWEEN '$from_time' AND '$to_time')");
		} else if ($this->input->post('from_time') || $this->input->post('to_time')) {
			if ($this->input->post('from_time')) {
				$from_time = $this->input->post('from_time');
				$to_time = '23:59';
			} else {
				$from_time = '00:00';
				$to_time = $this->input->post('to_time');
			}
			$this->db->where("(admit_time BETWEEN '$from_time' AND '$to_time')");
		} else {
			$this->db->where("(admit_time BETWEEN '00:00' AND '23:59')");
		}
		if (($visit_name != '-1' && $visit_name != '0') || $this->input->post('visit_name')) {
			if ($this->input->post('visit_name')) $visit_name = $this->input->post('visit_name');
			$this->db->where('patient_visit.visit_name_id', $visit_name);
		}
		if ($department != '-1' || $this->input->post('department')) {
			if ($this->input->post('department')) $department = $this->input->post('department');
			$this->db->where('department.department_id', $department);
		}
		if (!!$unit || $this->input->post('unit')) {
			if ($this->input->post('unit')) $unit = $this->input->post('unit');
			$this->db->select('IF(unit!="",unit,0) unit', false);
			$this->db->where('patient_visit.unit', $unit);
		} else {
			$this->db->select('"0" as unit_id', false);
		}
		if (!!$area || $this->input->post('area')) {
			if ($this->input->post('area')) $area = $this->input->post('area');
			$this->db->select('IF(area!="",area,0) area', false);
			$this->db->where('patient_visit.area', $area);
		} else {
			$this->db->select('"0" as area', false);
		}
		if ($gender != '0') {
			$this->db->where('gender', $gender);
		}
		if ($from_age != '0' && $to_age != '0') {
			$this->db->where('age_years>=', $from_age, false);
			$this->db->where('age_years<=', $to_age, false);
		}
		if ($from_age != '0' && $to_age == '0') {
			$this->db->where('age_years<=', $from_age, false);
		}
		if ($from_age == '0' && $to_age != '0') {
			$this->db->where('age_years>=', $to_age, false);
		}
		if (!!$outcome || $this->input->post('outcome_type')) {
			if ($this->input->post('outcome_type')) $outcome = $this->input->post('outcome_type');
			if ($outcome == "Unupdated") {
				$this->db->where_not_in('outcome', array('Death', 'Absconded', 'Discharge', 'LAMA'));
			} else $this->db->where('outcome', $outcome);
		}
		if ($date_type == 0) {
			$this->db->where("(admit_date BETWEEN '$from_date' AND '$to_date')");
		} else {
			$this->db->where("($date_type BETWEEN '$from_date' AND '$to_date')");
		}

		$this->db->select("count(*) as count", false);
		$this->db->from('patient_visit')->join('patient', 'patient_visit.patient_id=patient.patient_id')
		->join('department', 'patient_visit.department_id=department.department_id', 'left')
		->join('unit', 'patient_visit.unit=unit.unit_id', 'left')
		->join('area', 'patient_visit.area=area.area_id', 'left')
		->join('mlc', 'patient_visit.visit_id=mlc.visit_id', 'left')
		->join('hospital', 'patient_visit.hospital_id=hospital.hospital_id', 'left')
		->where('patient_visit.hospital_id', $hospital['hospital_id'])
		->where('visit_type', 'IP');
		$resource = $this->db->get();
		return $resource->result();
	}

	function get_ip_detail($department, $unit, $area, $gender, $from_age, $to_age, $from_date, $to_date, $visit_name, $date_type = 0, $outcome = 0,$default_rowsperpage=0){
		if ($this->input->post('page_no')) {
			$page_no = $this->input->post('page_no');
		} else {
			$page_no = 1;
		}
		if ($this->input->post('rows_per_page')) {
			$rows_per_page = $this->input->post('rows_per_page');
		} else {
			$rows_per_page = $default_rowsperpage;
		}
		$start = ($page_no - 1)  * $rows_per_page;

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
		 ->where('visit_type','IP');
		 //Commented temporarily for improving the query performance
		 //->order_by('hosp_file_no','ASC');
		if ($rows_per_page>0) {
			$this->db->limit($rows_per_page, $start);
		}
		$resource=$this->db->get();
		return $resource->result();
	}

	function get_icd_detail($icdchapter,$icdblock,$icd_10,$department,$unit,$area,$gender,$from_age,$to_age,$from_date,$to_date,$visit_name,$visit_type,$outcome,$default_rowsperpage=0){
		$hospital=$this->session->userdata('hospital');
		if ($this->input->post('page_no')) {
			$page_no = $this->input->post('page_no');
		} else {
			$page_no = 1;
		}
		if ($this->input->post('rows_per_page')) {
			$rows_per_page = $this->input->post('rows_per_page');
		} else {
			$rows_per_page = $default_rowsperpage;
		}
		$start = ($page_no - 1)  * $rows_per_page;
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
		} else {		
			if($icdblock != "-1") {
				$this->db->where('icd_block.block_id',$icdblock );
			}
		}
		if($this->input->post('icd_chapter')){
			$this->db->where('icd_chapter.chapter_id',$this->input->post('icd_chapter'));
		}
		else {		
			
			if($icdchapter != "-1") {
				if ($icdchapter == "0") {
					$this->db->where('icd_chapter.chapter_id IS NULL');
				} else {
					$this->db->where('icd_chapter.chapter_id',$icdchapter);
				}
			}
		}
		if($department!='-1' || $this->input->post('department')){
			if($this->input->post('department')) $department=$this->input->post('department');
			$this->db->where('department.department_id',$department);
		}
		if(!!$unit && $unit != "-1"){
			if($this->input->post('unit')) $unit=$this->input->post('unit');
			$this->db->select('IF(unit!="",unit,0) unit',false);
			$this->db->where('patient_visit.unit',$unit);
		}
		else{
			$this->db->select('"0" as unit_id',false);
		}
		if(!!$area && $area != "-1"){
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
		age_years,age_months,age_days,patient.place,phone,address,admit_date,admit_time, department,unit_name,area_name,mlc_number,patient_visit.icd_10,icd_code.code_title,outcome,final_diagnosis,
		outcome_date,outcome_time",false);
		 $this->db->from('patient_visit')->join('patient','patient_visit.patient_id=patient.patient_id')
		 ->join('department','patient_visit.department_id=department.department_id','left')
		 ->join('unit','patient_visit.unit=unit.unit_id','left')
		 ->join('area','patient_visit.area=area.area_id','left')
		 ->join('mlc','patient_visit.visit_id=mlc.visit_id','left')
		 ->join('icd_code','patient_visit.icd_10=icd_code.icd_code','left')
		 ->join('icd_block','icd_code.block_id=icd_block.block_id','left')
		 ->join('icd_chapter','icd_block.chapter_id=icd_chapter.chapter_id','left')
		 ->join('hospital','patient_visit.hospital_id=hospital.hospital_id','left')
		 ->where('patient_visit.hospital_id',$hospital['hospital_id'])
		 ->where("(admit_date BETWEEN '$from_date' AND '$to_date')")
		 ->order_by('hosp_file_no','ASC');
		 if ($rows_per_page>0) {
			$this->db->limit($rows_per_page, $start);
		}
		$resource=$this->db->get();
		return $resource->result();
	}

function get_icd_detail_count($icdchapter,$icdblock,$icd_10,$department,$unit,$area,$gender,$from_age,$to_age,$from_date,$to_date,$visit_name,$visit_type,$outcome){
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
		} else {		
			if($icdblock != "-1") {
				$this->db->where('icd_block.block_id',$icdblock );
			}
		}
		if($this->input->post('icd_chapter')){
			$this->db->where('icd_chapter.chapter_id',$this->input->post('icd_chapter'));
		}
		else {		
			if($icdchapter != "-1") {
				if ($icdchapter == "0") {
					$this->db->where('icd_chapter.chapter_id IS NULL');
				} else {
					$this->db->where('icd_chapter.chapter_id',$icdchapter);
				}
			}
		}
		if($department!='-1' || $this->input->post('department')){
			if($this->input->post('department')) $department=$this->input->post('department');
			$this->db->where('department.department_id',$department);
		}
		if(!!$unit && $unit != "-1"){
			if($this->input->post('unit')) $unit=$this->input->post('unit');
			$this->db->select('IF(unit!="",unit,0) unit',false);
			$this->db->where('patient_visit.unit',$unit);
		}
		else{
			$this->db->select('"0" as unit_id',false);
		}
		if(!!$area && $area != "-1"){
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
		$this->db->select("count(*) as count",false);
		 $this->db->from('patient_visit')->join('patient','patient_visit.patient_id=patient.patient_id')
		 ->join('department','patient_visit.department_id=department.department_id','left')
		 ->join('unit','patient_visit.unit=unit.unit_id','left')
		 ->join('area','patient_visit.area=area.area_id','left')
		 ->join('mlc','patient_visit.visit_id=mlc.visit_id','left')
		 ->join('icd_code','patient_visit.icd_10=icd_code.icd_code','left')
		 ->join('icd_block','icd_code.block_id=icd_block.block_id','left')
		 ->join('icd_chapter','icd_block.chapter_id=icd_chapter.chapter_id','left')
		 ->join('hospital','patient_visit.hospital_id=hospital.hospital_id','left')
		 ->where('patient_visit.hospital_id',$hospital['hospital_id'])
		 ->where("(admit_date BETWEEN '$from_date' AND '$to_date')");
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
            
             $date_filter_field="Registration";
	     if($this->input->post('dateby') && $this->input->post('dateby')=="Appointment"){
			$date_filter_field="Appointment";
	     }	
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
                        if($date_filter_field=="Registration"){
                        	if($trend=="Month"){
                            		$this->db->select('patient_visit.admit_date date',false);
                            		$this->db->group_by('MONTH(patient_visit.admit_date)');
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
			else if($date_filter_field=="Appointment"){
				if($trend=="Month"){
                            		$this->db->select('patient_visit.appointment_time date',false);
                            		$this->db->group_by('MONTH(patient_visit.appointment_time)');
                        	}
                        	else if($trend=="Year"){
                            		$this->db->select('YEAR(patient_visit.appointment_time) date');
                            		$this->db->group_by('YEAR(patient_visit.appointment_time)');
                        	}
                        	else{
                            		$this->db->select('patient_visit.appointment_time date');
                           		$this->db->group_by('patient_visit.appointment_time');
                        	}
			}
		  }
                 else{
                 	if($date_filter_field=="Registration"){	
                               $this->db->select('patient_visit.admit_date date');
                               $this->db->group_by('patient_visit.admit_date');
                  	}
                  	else if($date_filter_field=="Appointment"){
                  		$this->db->select('patient_visit.appointment_time date');
                               $this->db->group_by('patient_visit.appointment_time');
                  	}
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
		if($date_filter_field=="Registration"){
			$this->db->where("(admit_date BETWEEN '$from_date' AND '$to_date')");
		} 
		else if($date_filter_field=="Appointment"){
			$this->db->where("(appointment_time IS NOT NULL)");				
			$from_timestamp = $from_date." ".$from_time;
			$to_timestamp = $to_date." ".$to_time;
			$this->db->where("(appointment_time BETWEEN '$from_timestamp' AND '$to_timestamp')");
		}
                //Counting the number of patients gender wise.
		$this->db->select("
		SUM(CASE WHEN 1 THEN 1 ELSE 0 END) 'total',
          SUM(CASE WHEN gender = '0'  THEN 1 ELSE 0 END) 'not_specified',
           SUM(CASE WHEN gender = 'O'  THEN 1 ELSE 0 END) 'others',
		SUM(CASE WHEN gender = 'F'  THEN 1 ELSE 0 END) 'female',
		SUM(CASE WHEN gender = 'M'  THEN 1 ELSE 0 END) 'male',
		SUM(CASE WHEN signed_consultation > 0 THEN 1 ELSE 0 END) 'signed_consultation',
		");
		 $this->db->from('patient_visit')->join('patient','patient_visit.patient_id=patient.patient_id')
		 ->join('department','patient_visit.department_id=department.department_id','left')
		 ->join('unit','patient_visit.unit=unit.unit_id','left')
		 ->join('area','patient_visit.area=area.area_id','left')
		 ->join('hospital','patient_visit.hospital_id=hospital.hospital_id','left')
		 ->where('patient_visit.hospital_id',$hospital['hospital_id']);
		$resource=$this->db->get();
		return $resource->result();
        }

    function get_visit_type_summary(){
			$hospital=$this->session->userdata('hospital');
            //First time ip_op_trends page is opened all records for today will be opened.
            /*Query is being built from the data input from the user*/

            //Selection of the date field.
            
             $date_filter_field="Registration";
	     if($this->input->post('dateby') && $this->input->post('dateby')=="Appointment"){
			$date_filter_field="Appointment";
	     }	
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
		if($date_filter_field=="Registration"){
			$this->db->where("(admit_date BETWEEN '$from_date' AND '$to_date')");
		} 
		else if($date_filter_field=="Appointment"){
			$this->db->where("(appointment_time IS NOT NULL)");				
			$from_timestamp = $from_date." ".$from_time;
			$to_timestamp = $to_date." ".$to_time;
			$this->db->where("(appointment_time BETWEEN '$from_timestamp' AND '$to_timestamp')");
		}
                //Counting the number of patients gender wise.
		$this->db->select(" visit_name.visit_name,
		SUM(CASE WHEN 1 THEN 1 ELSE 0 END) 'total',
          SUM(CASE WHEN gender = '0'  THEN 1 ELSE 0 END) 'not_specified',
           SUM(CASE WHEN gender = 'O'  THEN 1 ELSE 0 END) 'others',
		SUM(CASE WHEN gender = 'F'  THEN 1 ELSE 0 END) 'female',
		SUM(CASE WHEN gender = 'M'  THEN 1 ELSE 0 END) 'male',
		SUM(CASE WHEN signed_consultation > 0 THEN 1 ELSE 0 END) 'signed_consultation',
		");
		 $this->db->from('patient_visit')->join('patient','patient_visit.patient_id=patient.patient_id')
		 ->join('department','patient_visit.department_id=department.department_id','left')
		 ->join('unit','patient_visit.unit=unit.unit_id','left')
		 ->join('area','patient_visit.area=area.area_id','left')
		 ->join('hospital','patient_visit.hospital_id=hospital.hospital_id','left')
		 ->join('visit_name','patient_visit.visit_name_id=visit_name.visit_name_id','left')
		 ->where('patient_visit.hospital_id',$hospital['hospital_id'])
		 ->where("(admit_date BETWEEN '$from_date' AND '$to_date')")
		 ->group_by('visit_name');
		$resource=$this->db->get();
		return $resource->result();
        }

	function get_login_report(){	
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
               
                //Report for day or month or year.
		if($this->input->post('trend_type')){
                        $trend = $this->input->post('trend_type');
                        if($trend=="Month"){                            
                            	$this->db->group_by('MONTH(signin_date_time),YEAR(signin_date_time)');
                        }
                        else if($trend=="Year"){                          
                            	$this->db->group_by('YEAR(signin_date_time)');
                        }
                        else{                    
                           	$this->db->group_by('date(signin_date_time)');
                        }
		  }
                 else{
                 
                  	$this->db->select('signin_date_time date');
                       $this->db->group_by('date(signin_date_time)');                  	
                 }
               
		if($this->input->post('hospital')){
			$this->db->where("hospital.hospital_id",$this->input->post('hospital'));
		}
		
		$from_timestamp = $from_date." ".$from_time;
		$to_timestamp = $to_date." ".$to_time;
		$this->db->where("(signin_date_time BETWEEN '$from_timestamp' AND '$to_timestamp')");
		
                //Counting the number of patients gender wise.
		$this->db->select("signin_date_time 'date',
		SUM(CASE WHEN 1 THEN 1 ELSE 0 END) 'total',
          SUM(CASE WHEN is_success = 1  THEN 1 ELSE 0 END) 'no_of_success',
           SUM(CASE WHEN is_success = 0  THEN 1 ELSE 0 END) 'no_of_un_success',
		")	
		->join('user','user_signin.username = user.username')
		->join('staff','user.staff_id = staff.staff_id')
		->join('hospital','staff.hospital_id = hospital.hospital_id')		
		->join('department','staff.department_id = department.department_id','left');
		$this->db->where("staff.hospital_id in (select us1.hospital_id from user_hospital_link as us1 where us1.user_id='". $this->session->userdata('logged_in')['user_id']."')");
		$this->db->from('user_signin');
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

	function get_count_followups(){  
		/*$filters = array();
		$filter_names_aliases = ['priority_type' => 'patient_followup.priority_type_id','volunteer' => 'patient_followup.volunteer_id',
		'primary_route' => 'patient_followup.route_primary_id','secondary_route' => 'patient_followup.route_secondary_id'];
		$filter_names=['life_status','last_visit_type','priority_type','volunteer','primary_route','secondary_route'];

		foreach($filter_names as $filter_name){
            if($this->input->post($filter_name)){
                $filter_name_query = $filter_name;
                if(isset($filter_names_aliases[$filter_name])){
                    $filter_name_query =  $filter_names_aliases[$filter_name];
                }
                $filters[$filter_name_query] = $this->input->post($filter_name);
            }
        }*/
        
        	if($this->input->post('life_status') == 1 || empty($this->input->post('life_status'))){
			$this->db->where('patient_followup.life_status',1);
                }
		else if($this->input->post('life_status')== 2){
			$this->db->where('patient_followup.life_status',0);
		}
		else if($this->input->post('life_status')== 3){
			$this->db->where('patient_followup.life_status',2);
		}		
		if($this->input->post('last_visit_type')){
			$this->db->where('patient_followup.last_visit_type',$this->input->post('last_visit_type'));
		}
		
		if($this->input->post('priority_type')){
			$this->db->where('patient_followup.priority_type_id',$this->input->post('priority_type'));
		}
		if($this->input->post('volunteer')){
			$this->db->where('patient_followup.volunteer_id',$this->input->post('volunteer'));
		}
		if($this->input->post('route_primary')){
			$this->db->where('patient_followup.route_primary_id',$this->input->post('route_primary'));
		}		
							
		if($this->input->post('route_secondary')){
			$this->db->where('patient_followup.route_secondary_id',$this->input->post('route_secondary'));
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

		if($this->input->post('ndps')!=0)
		{
			if($this->input->post('ndps')==1){
				$this->db->where('patient_followup.ndps',1);
			}if($this->input->post('ndps')==2){
				$this->db->where('patient_followup.ndps',0);
			}
		}
		if($this->input->post('sort_by_age')==1){
			$this->db->order_by('patient.age_years',ASC);
		}else{
			$this->db->order_by('patient.age_years',DESC);
		}
      
        $this->db->select("count(*) as count",false)
        ->from('patient_followup')
        ->join('patient','patient_followup.patient_id=patient.patient_id','left')
		->join('priority_type','patient_followup.priority_type_id=priority_type.priority_type_id','left')
		->join('staff','patient_followup.volunteer_id=staff.staff_id','left')
		->join('route_primary','patient_followup.route_primary_id=route_primary.route_primary_id','left')
		->join('icd_code','patient_followup.icd_code=icd_code.icd_code','left')
		->join('icd_block','icd_code.block_id=icd_block.block_id','left')
		->join('icd_chapter','icd_block.chapter_id=icd_chapter.chapter_id','left')
		->join('route_secondary','patient_followup.route_secondary_id=route_secondary.id','left');
        //->where($filters);
        //$this->db->limit($rows_per_page,$start);
        $query = $this->db->get();
        $result = $query->result();
        return $result; 

	}
	function search_followups($default_rowsperpage){       
        //Function that returns all the details of the Followup table.

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
		$hospital=$this->session->userdata('hospital');

        // $filters = array();
		// $filter_names_aliases = ['priority_type' => 'patient_followup.priority_type_id','volunteer' => 'patient_followup.volunteer_id',
		// 'primary_route' => 'patient_followup.route_primary_id','secondary_route' => 'patient_followup.route_secondary_id'];
		// $filter_names=['life_status','last_visit_type','priority_type','volunteer','primary_route','secondary_route'];

		// foreach($filter_names as $filter_name){
        //     if($this->input->post($filter_name)){
        //         $filter_name_query = $filter_name;
        //         if(isset($filter_names_aliases[$filter_name])){
        //             $filter_name_query =  $filter_names_aliases[$filter_name];
        //         }
        //         $filters[$filter_name_query] = $this->input->post($filter_name);
        //     }
        // }
        //$this->db->select("count(*) as count",false);
		//Selection of Life Status
		
		if($this->input->post('life_status') == 1 || empty($this->input->post('life_status'))){
			$this->db->where('patient_followup.life_status',1);
                }
		else if($this->input->post('life_status')== 2){
			$this->db->where('patient_followup.life_status',0);
		}
		else if($this->input->post('life_status')== 3){
			$this->db->where('patient_followup.life_status',2);
		}
				
		if($this->input->post('last_visit_type')){
			$this->db->where('patient_followup.last_visit_type',$this->input->post('last_visit_type'));
		}
		
		if($this->input->post('priority_type')){
			$this->db->where('patient_followup.priority_type_id',$this->input->post('priority_type'));
		}
		if($this->input->post('volunteer')){
			$this->db->where('patient_followup.volunteer_id',$this->input->post('volunteer'));
		}
		if($this->input->post('route_primary')){
			$this->db->where('patient_followup.route_primary_id',$this->input->post('route_primary'));
		}		
							
		if($this->input->post('route_secondary')){
			$this->db->where('patient_followup.route_secondary_id',$this->input->post('route_secondary'));
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
		// Newly added 12-01-2023 (am)
		if($this->input->post('ndps')!=0)
		{
			if($this->input->post('ndps')==1){
				$this->db->where('patient_followup.ndps',1);
			}if($this->input->post('ndps')==2){
				$this->db->where('patient_followup.ndps',0);
			}
		}
		if($this->input->post('sort_by_age')==1){
			$this->db->order_by('patient.age_years',ASC);
		}else{
			$this->db->order_by('patient.age_years',DESC);
		}
		//till here
        $this->db->select("patient_followup.patient_id,
        patient.insert_datetime,
        patient.first_name,
        patient.last_name,
        patient.age_years,
        patient.gender,
        patient.father_name,
        patient.mother_name,
        patient.spouse_name,
        patient.phone,
        patient.address,
        patient_followup.status_date,
        patient_followup.icd_code,
        icd_code.code_title,
        patient_followup.diagnosis,
        patient_followup.map_link,
        patient_followup.last_visit_type,
        patient_followup.last_visit_date,
        patient_followup.latitude,
        patient_followup.longitude,
        patient_followup.note,
        priority_type.priority_type,
        route_primary.route_primary,
        route_secondary.route_secondary,
        staff.first_name as fname,
        staff.last_name as lname,
        patient_followup.update_time as followup_update_time,
		patient_followup.ndps,
		patient_followup.drug,
		patient_followup.dose,
		patient_followup.last_dispensed_date,
		patient_followup.last_dispensed_quantity,
		CONCAT(patient_followup.drug,' / ',patient_followup.dose,' / ',patient_followup.last_dispensed_date,' / ',patient_followup.last_dispensed_quantity) as ndps_status, 
		CONCAT(followup_update_by.first_name, ' ', followup_update_by.last_name) as followup_update_by",false)
        ->from('patient_followup')
        ->join('patient','patient_followup.patient_id=patient.patient_id','both')
		->join('priority_type','patient_followup.priority_type_id=priority_type.priority_type_id','left')
		->join('staff','patient_followup.volunteer_id=staff.staff_id','left')
		->join('staff as followup_update_by','patient_followup.update_by=followup_update_by.staff_id','left')
		->join('icd_code','patient_followup.icd_code=icd_code.icd_code','left')
		->join('icd_block','icd_code.block_id=icd_block.block_id','left')
		->join('icd_chapter','icd_block.chapter_id=icd_chapter.chapter_id','left')
		->join('route_primary','patient_followup.route_primary_id=route_primary.route_primary_id','left')
		->join('route_secondary','patient_followup.route_secondary_id=route_secondary.id','left')
       // ->where($filters);
	   ->where('patient_followup.hospital_id',$hospital['hospital_id']);

        $this->db->limit($rows_per_page,$start);
        $query = $this->db->get();
        $result = $query->result();
        return $result;
    }

	function get_priority_type_input($priority_id)
	{
		$this->db->select("priority_type")->from('priority_type');
		$this->db->where('priority_type_id',$priority_id);
		$query = $this->db->get();
        $result = $query->result();
		return $result;
	}

	// Newly added functions jan 17 2024

	function get_issue_list_count(){
	    
		$hospital=$this->session->userdata('hospital');
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
			$this->db->where("(pv.admit_date BETWEEN '$from_date' AND '$to_date')");
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')?$from_date=$this->input->post('from_date'):$from_date=$this->input->post('to_date');
			$to_date=$from_date;
			$this->db->where("(pv.admit_date BETWEEN '$from_date' AND '$to_date')");
		}
		else{
			$from_date=date("Y-m-d");
			$to_date=$from_date;
			$this->db->where("(pv.admit_date BETWEEN '$from_date' AND '$to_date')");
		}
	
        if($this->input->post('from_time') && $this->input->post('to_time')){
			$from_time=date("H:i",strtotime($this->input->post('from_time')));
			$to_time=date("H:i",strtotime($this->input->post('to_time')));
			$this->db->where("(pv.admit_time BETWEEN '$from_time' AND '$to_time')");
		}
		else if($this->input->post('from_time') || $this->input->post('to_time'))
		{
			if($this->input->post('from_time')){
                            $from_time=$this->input->post('from_time');
                            $to_time = '23:59';
                        }else{
                            $from_time = '00:00';
                            $to_time=$this->input->post('to_time');
                        }
			$this->db->where("(pv.admit_time BETWEEN '$from_time' AND '$to_time')");				
		}		
		else{
			$to_time = '23:59';
		 	$from_time = '00:00';
			 $this->db->where("(pv.admit_time BETWEEN '$from_time' AND '$to_time')");
		}

		
		
		if($this->input->post('visit_name')){
			$this->db->where('pv.visit_name_id',$this->input->post('visit_name'));
		}
		if($this->input->post('department')){
			$this->db->where('pv.department_id',$this->input->post('department'));
		}
		if($this->input->post('unit')){			
			$this->db->where('pv.unit',$this->input->post('unit'));
		}
		
		if($this->input->post('area')){	
			$this->db->where('pv.area',$this->input->post('area'));
		}

		if($this->input->post('discharge_status')){	
			$this->db->where('pv.outcome',$this->input->post('discharge_status'));
		}
		

		$this->db->select("count(*) as count",false);
		 $this->db->from('patient_visit as pv')
		 ->join('patient as p','pv.patient_id=p.patient_id')
		 ->join('department as pvd','pv.department_id=pvd.department_id','left')
		 ->join('district','p.district_id=district.district_id','left')
		 ->join('state','district.state_id=state.state_id','left')
		 ->join('unit','pv.unit=unit.unit_id','left')
		 ->join('area','pv.area=area.area_id','left')
		 ->join('hospital','pv.hospital_id=hospital.hospital_id','left')
		 ->join('staff as appointment_with','pv.appointment_with=appointment_with.staff_id','left')
		 ->join('department as sd', 'appointment_with.department_id=sd.department_id','left')
		 ->join('user as volunteer_user','p.insert_by_user_id = volunteer_user.user_id','left')
		 ->join('staff as volunteer','volunteer_user.staff_id=volunteer.staff_id','left')
		 ->join('visit_name vn','pv.visit_name_id=vn.visit_name_id','left')		
		 ->where('pv.hospital_id',$hospital['hospital_id'])
		 ->where('visit_type','OP');			
		$resource=$this->db->get();
		return $resource->result();
	}

	function get_issue_list($default_rowsperpage){
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
				
		$hospital=$this->session->userdata('hospital');
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
			$this->db->where("(pv.admit_date BETWEEN '$from_date' AND '$to_date')");
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')?$from_date=$this->input->post('from_date'):$from_date=$this->input->post('to_date');
			$to_date=$from_date;
			$this->db->where("(pv.admit_date BETWEEN '$from_date' AND '$to_date')");
		}
		else{
			$from_date=date("Y-m-d");
			$to_date=$from_date;
			$this->db->where("(pv.admit_date BETWEEN '$from_date' AND '$to_date')");
		}
	
        if($this->input->post('from_time') && $this->input->post('to_time')){
			$from_time=date("H:i",strtotime($this->input->post('from_time')));
			$to_time=date("H:i",strtotime($this->input->post('to_time')));
			$this->db->where("(pv.admit_time BETWEEN '$from_time' AND '$to_time')");
		}
		else if($this->input->post('from_time') || $this->input->post('to_time')){
			if($this->input->post('from_time')){
                            $from_time=$this->input->post('from_time');
                            $to_time = '23:59';
                        }else{
                            $from_time = '00:00';
                            $to_time=$this->input->post('to_time');
                        }
						$this->db->where("(pv.admit_time BETWEEN '$from_time' AND '$to_time')");				
		}		
		else{
			$to_time = '23:59';
		 	$from_time = '00:00';
			 $this->db->where("(pv.admit_time BETWEEN '$from_time' AND '$to_time')");
		}
		

		if($this->input->post('visit_name')){
			$this->db->where('pv.visit_name_id',$this->input->post('visit_name'));
		}
		if($this->input->post('department')){
			$this->db->where('pv.department_id',$this->input->post('department'));
		}
		if($this->input->post('unit')){
			$this->db->select('IF(unit!="",unit,0) unit',false);
			$this->db->where('pv.unit',$this->input->post('unit'));
		}
		else{
			$this->db->select('"0" as unit',false);
		}
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('pv.area',$this->input->post('area'));
		}
		else{
			$this->db->select('"0" as area',false);
		}
		
		if($this->input->post('discharge_status')){	
			$this->db->where('pv.outcome',$this->input->post('discharge_status'));
		}

		$this->db->select("p.patient_id, p.address, hosp_file_no, pv.visit_id, CONCAT(IF(p.first_name=NULL,'',p.first_name),' ',IF(p.last_name=NULL,'',p.last_name)) name,
		p.gender, IF(p.gender='F' AND (father_name IS NULL OR father_name = ''),spouse_name, father_name) parent_spouse, age_years, age_months, age_days,
		p.place, p.phone, pvd.department, admit_date, admit_time, p.patient_id_manual,pv.outcome,pv.outcome_date,pv.decision as decision_note,updated.first_name as updatedby,
		CONCAT(volunteer.first_name, ' ', volunteer.last_name) as volunteer, pv.appointment_with as appointment_with_id,area.*,unit.*,volunteer_user.username,registered.first_name as registeredby,
		pv.signed_consultation as signed,district.district,state.state,vn.visit_name,pv.visit_name_id,pf.diagnosis,pt.priority_type,pf.note,pv.final_diagnosis as final_diagnosis",false);
		 $this->db->from('patient_visit as pv')
		 ->join('patient as p','pv.patient_id=p.patient_id')
		 ->join('patient_followup as pf','pf.patient_id=p.patient_id','left')
		 ->join('priority_type as pt','pt.priority_type_id=pf.priority_type_id','left')
		 ->join('department as pvd','pv.department_id=pvd.department_id','left')
		 ->join('district','p.district_id=district.district_id','left')
		 ->join('state','district.state_id=state.state_id','left')
		 ->join('unit','pv.unit=unit.unit_id','left')
		 ->join('area','pv.area=area.area_id','left')
		 ->join('hospital','pv.hospital_id=hospital.hospital_id','left')
		 ->join('staff as appointment_with','pv.appointment_with=appointment_with.staff_id','left')
		 ->join('department as sd', 'appointment_with.department_id=sd.department_id','left')
		 ->join('user as volunteer_user','p.insert_by_user_id = volunteer_user.user_id','left')
		 ->join('staff as volunteer','volunteer_user.staff_id=volunteer.staff_id','left')
		 ->join('staff as updated','pf.update_by=updated.staff_id','left')
		 ->join('staff as registered','pf.add_by=registered.staff_id','left')
		 ->join('visit_name vn','pv.visit_name_id=vn.visit_name_id','left')		
		 ->where('pv.hospital_id',$hospital['hospital_id'])
		 ->where('visit_type','OP');
		$this->db->limit($rows_per_page,$start);			
		$resource=$this->db->get();
		return $resource->result();
	}

	function get_issue_summary()
	{
		$hospital=$this->session->userdata('hospital');
		$from_time = '00:00';	
		$to_time = '23:59';
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
			$this->db->where("(patient_visit.admit_date BETWEEN '$from_date' AND '$to_date')");
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')?$from_date=$this->input->post('from_date'):$from_date=$this->input->post('to_date');
			$to_date=$from_date;
			$this->db->where("(patient_visit.admit_date BETWEEN '$from_date' AND '$to_date')");
		}
		else{
			$from_date=date("Y-m-d");
			$to_date=$from_date;
			$this->db->where("(patient_visit.admit_date BETWEEN '$from_date' AND '$to_date')");
		}

		if($this->input->post('from_time') && $this->input->post('to_time')){
			$from_time=date("H:i",strtotime($this->input->post('from_time')));
			$to_time=date("H:i",strtotime($this->input->post('to_time')));
			$this->db->where("(patient_visit.admit_time BETWEEN '$from_time' AND '$to_time')");
		}
		else if($this->input->post('from_time') || $this->input->post('to_time')){
			if($this->input->post('from_time'))
			{
				$from_time=$this->input->post('from_time');
				$to_time = '23:59';
			}else{
				$from_time = '00:00';
				$to_time=$this->input->post('to_time');
			}
			$this->db->where("(patient_visit.admit_time BETWEEN '$from_time' AND '$to_time')");				
		}		
		else{
			$to_time = '23:59';
		 	$from_time = '00:00';
			 $this->db->where("(patient_visit.admit_time BETWEEN '$from_time' AND '$to_time')");
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

		//Setting the selected department in the query. First time all the departments are selected.
		if($this->input->post('department')){
			$this->db->where('patient_visit.department_id',$this->input->post('department'));
		}
		
		if($this->input->post('discharge_status')){	
			$this->db->where('patient_visit.outcome',$this->input->post('discharge_status'));
		}
		
			//Counting the number of patients gender wise.
		$this->db->select("count(department.department_id) as issue_count,area.area_name,department.department as department_name,unit.unit_name");
		$this->db->from('patient_visit')->join('patient','patient_visit.patient_id=patient.patient_id')
		->join('patient_followup','patient_visit.patient_id=patient_followup.patient_id','left')
		->join('department','patient_visit.department_id=department.department_id','left')
		->join('unit','patient_visit.unit=unit.unit_id','left')
		->join('area','patient_visit.area=area.area_id','left')
		->join('hospital','patient_visit.hospital_id=hospital.hospital_id','left')
		->group_by('patient_visit.department_id')
		->group_by('patient_visit.unit')
		->group_by('patient_visit.area')
		->where('patient_visit.hospital_id',$hospital['hospital_id']);
		$resource=$this->db->get();
		return $resource->result();
	}
		
}
?>
