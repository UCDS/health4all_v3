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
		
		if($this->input->post('state')){
				$this->db->where('state.state_id',$this->input->post('state'));
		}
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('patient_visit.area',$this->input->post('area'));
		}
		else{
			$this->db->select('"0" as area',false);
		}
		$this->db->select("state.state,district.state_id as state_id,department 'department', district.district 'district',   district.district_id, district.latitude , district.longitude,
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
		 ->join('state','district.state_id=state.state_id','left')
		 ->where('patient_visit.hospital_id',$hospital['hospital_id'])
		 ->where("(admit_date BETWEEN '$from_date' AND '$to_date')");
		 if ($this->input->post('groupbystate')) {
			$this->db->group_by('state.state_id');
		 }
		 if ($this->input->post('groupbydistrict')) {
			$this->db->group_by('district');
		 }
		 $this->db->order_by('state.state,district.district ','asc');
		 
		$resource=$this->db->get();
		
		return $resource->result();
	}
	
	function get_followup_map(){
		
		$hospital=$this->session->userdata('hospital');
		
		if($this->input->post('route_primary') && empty($this->input->post('route_secondary')))
		{
			$secondary=array();
			$this->db->select('id');
			$this->db->from('route_secondary');
			$this->db->where('route_primary_id',$this->input->post('route_primary'));
			$query = $this->db->get();
			$res = $query->result_array();
			foreach ($res as $row){ $secondary[] = $row['id']; }
			if(!empty($secondary))
			{
				$this->db->where_in('patient_followup.route_secondary_id', $secondary);
			}
		}
		if($this->input->post('life_status')== 3 || empty($this->input->post('life_status'))){
			$this->db->where('patient_followup.life_status',2);
        }
		else if($this->input->post('life_status')== 2){
			$this->db->where('patient_followup.life_status',0);
		}
		else if($this->input->post('life_status') == 1){
			$this->db->where('patient_followup.life_status',1);
		}	
	
		if($this->input->post('priority_type')){
			$this->db->where('patient_followup.priority_type_id',$this->input->post('priority_type'));
		}
		if($this->input->post('volunteer')){
			$this->db->where('patient_followup.volunteer_id',$this->input->post('volunteer'));
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
		
		if($this->input->post('district')){
				$this->db->where('patient.district_id',$this->input->post('district'));
		}
		
		if($this->input->post('state')){
				$this->db->where('state.state_id',$this->input->post('state'));
		}

		$this->db->select("patient_followup.patient_id,state.state,district.state_id as state_id, district.district as dname,   district.district_id, 
		patient_followup.latitude as latitude, patient_followup.longitude as longitude,patient.first_name,patient.last_name,patient.phone,
		patient.age_years,patient.gender,patient_followup.diagnosis");
		
		 $this->db->from('patient_followup')
		 ->join('patient','patient_followup.patient_id=patient.patient_id','left')
		 ->join('priority_type','patient_followup.priority_type_id=priority_type.priority_type_id','left')
		 ->join('staff','patient_followup.volunteer_id=staff.staff_id','left')
		 ->join('icd_code','patient_followup.icd_code=icd_code.icd_code','left')
		 ->join('icd_block','icd_code.block_id=icd_block.block_id','left')
		 ->join('icd_chapter','icd_block.chapter_id=icd_chapter.chapter_id','left')
		 ->join('route_secondary','patient_followup.route_secondary_id=route_secondary.id','left')
		 //->join('route_primary','route_secondary.route_primary_id=route_primary.route_primary_id','left')
		 ->join('district','patient.district_id=district.district_id')
		 ->join('state','district.state_id=state.state_id','left')
		 ->where('patient_followup.hospital_id',$hospital['hospital_id']);
		
		$resource=$this->db->get();
		return $resource->result();
	}
	

	function get_followup_summary()
	{
		$hospital=$this->session->userdata('hospital');

		if($this->input->post('route_primary') && empty($this->input->post('route_secondary')))
		{
			$secondary=array();
			$this->db->select('id');
			$this->db->from('route_secondary');
			$this->db->where('route_primary_id',$this->input->post('route_primary'));
			$query = $this->db->get();
			$res = $query->result_array();
			foreach ($res as $row){ $secondary[] = $row['id']; }
			if(!empty($secondary))
			{
				$this->db->where_in('patient_followup.route_secondary_id', $secondary);
			}
		}

		if($this->input->post('life_status') == 1 || empty($this->input->post('life_status'))){
			$this->db->where('patient_followup.life_status',1);
        }
		else if($this->input->post('life_status')== 2){
			$this->db->where('patient_followup.life_status',0);
		}
		else if($this->input->post('life_status')== 3){
			$this->db->where('patient_followup.life_status',2);
		}

		if($this->input->post('route_secondary')){
			$this->db->where('patient_followup.route_secondary_id',$this->input->post('route_secondary'));
		}
		if($this->input->post('priority_type')){
			$this->db->where('patient_followup.priority_type_id',$this->input->post('priority_type'));
		}
		if($this->input->post('volunteer')){
			$this->db->where('patient_followup.volunteer_id',$this->input->post('volunteer'));
		}
		if($this->input->post('icd_chapter')){
			$this->db->where('icd_chapter.chapter_id',$this->input->post('icd_chapter'));
		}
		if($this->input->post('icd_block')){
			$this->db->where('icd_block.block_id',$this->input->post('icd_block'));
		}
		if($this->input->post('icd_code')){
			$icd_code = substr($this->input->post('icd_code'),0,strpos($this->input->post('icd_code')," "));
			$this->db->where('icd_code.icd_code',$icd_code);
		}
		if($this->input->post('ndps')!=0)
		{
			if($this->input->post('ndps')==1){
				$this->db->where('patient_followup.ndps',1);
			}if($this->input->post('ndps')==2){
				$this->db->where('patient_followup.ndps',0);
			}
		}
		if($this->input->post('state')){
			$this->db->where('state.state_id',$this->input->post('state'));
		}
		if($this->input->post('district')){
			$this->db->where('patient.district_id',$this->input->post('district'));
		}
		
		$this->db->select("icd_block.block_title,icd_chapter.chapter_title,patient_followup.icd_code,patient_followup.priority_type_id,
		icd_code.code_title,
		SUM(CASE WHEN patient_followup.priority_type_id=1 THEN 1 ELSE 0 END) AS highcount,
        SUM(CASE WHEN patient_followup.priority_type_id=2 THEN 1 ELSE 0 END) AS mediumcount,
        SUM(CASE WHEN patient_followup.priority_type_id=3 THEN 1 ELSE 0 END) AS lowcount,
		SUM(CASE WHEN patient_followup.priority_type_id = 0 AND patient_followup.icd_code!= '' THEN 1 ELSE 0 END) AS unupdated_priority,

		(SELECT COUNT(*) FROM patient_followup pf
		JOIN patient p ON pf.patient_id = p.patient_id
		WHERE pf.priority_type_id = 1 AND pf.icd_code = '' AND p.patient_id = p.patient_id) AS icdcode_empty_high,

		(SELECT COUNT(*) FROM patient_followup pf 
		JOIN patient p ON pf.patient_id = p.patient_id
		WHERE pf.priority_type_id = 2 AND pf.icd_code = '' AND p.patient_id = p.patient_id) AS icdcode_empty_medium,
		
		(SELECT COUNT(*) FROM patient_followup pf 
		JOIN patient p ON pf.patient_id = p.patient_id
		WHERE pf.priority_type_id = 3 AND pf.icd_code = '' AND p.patient_id = p.patient_id) AS icdcode_empty_low,
		
		(SELECT COUNT(*) FROM patient_followup pf 
		JOIN patient p ON pf.patient_id = p.patient_id
		WHERE pf.priority_type_id = 0 AND pf.icd_code = '' AND p.patient_id = p.patient_id) AS unupdated_both");

		$this->db->from('patient_followup')
		->join('patient','patient_followup.patient_id=patient.patient_id','left')
		->join('priority_type','patient_followup.priority_type_id=priority_type.priority_type_id','left')
		->join('staff','patient_followup.volunteer_id=staff.staff_id','left')
		->join('icd_code','patient_followup.icd_code=icd_code.icd_code')
		->join('icd_block','icd_code.block_id=icd_block.block_id','left')
		->join('icd_chapter','icd_block.chapter_id=icd_chapter.chapter_id','left')
		->join('route_secondary','patient_followup.route_secondary_id=route_secondary.id','left')
		//->join('route_primary','route_secondary.route_primary_id=route_primary.route_primary_id','left')
		->join('district','district.district_id=patient.district_id','left')
		->join('state','state.state_id=district.state_id','left')
		->where('patient_followup.hospital_id',$hospital['hospital_id']);

		if($this->input->post('groupbyicdcode')) {
			$this->db->group_by('patient_followup.icd_code');
		}
		if($this->input->post('groupbyicdblock')) {
			$this->db->group_by('icd_code.block_id');
		}
		if(!$this->input->post('postback') or $this->input->post('groupbyicdchapter')){
			$this->db->group_by('icd_block.chapter_id');
		}
		$resource = $this->db->get();
		//echo $this->db->last_query();
		return $resource->result();

	}

	function get_hospital_priority()
	{
		$hospital=$this->session->userdata('hospital');
		$this->db->select('priority_type_id,priority_type');
		$this->db->from('priority_type');
		$this->db->where('hospital_id',$hospital['hospital_id']);
		$resource = $this->db->get();
		return $resource->result();
	}

	function get_followup_summary_route()
	{
		$hospital=$this->session->userdata('hospital');

		if($this->input->post('route_primary') && empty($this->input->post('route_secondary')))
		{
			$secondary=array();
			$this->db->select('id');
			$this->db->from('route_secondary');
			$this->db->where('route_primary_id',$this->input->post('route_primary'));
			$query = $this->db->get();
			$res = $query->result_array();
			foreach ($res as $row){ $secondary[] = $row['id']; }
			if(!empty($secondary))
			{
				$this->db->where_in('patient_followup.route_secondary_id', $secondary);
			}
		}

		if($this->input->post('life_status') == 1 || empty($this->input->post('life_status'))){
			$this->db->where('patient_followup.life_status',1);
        }
		else if($this->input->post('life_status')== 2){
			$this->db->where('patient_followup.life_status',0);
		}
		else if($this->input->post('life_status')== 3){
			$this->db->where('patient_followup.life_status',2);
		}

		if($this->input->post('route_secondary')){
			$this->db->where('patient_followup.route_secondary_id',$this->input->post('route_secondary'));
		}
		if($this->input->post('priority_type')){
			$this->db->where('patient_followup.priority_type_id',$this->input->post('priority_type'));
		}
		if($this->input->post('volunteer')){
			$this->db->where('patient_followup.volunteer_id',$this->input->post('volunteer'));
		}
		if($this->input->post('icd_chapter')){
			$this->db->where('icd_chapter.chapter_id',$this->input->post('icd_chapter'));
		}
		if($this->input->post('icd_block')){
			$this->db->where('icd_block.block_id',$this->input->post('icd_block'));
		}
		if($this->input->post('icd_code')){
			$icd_code = substr($this->input->post('icd_code'),0,strpos($this->input->post('icd_code')," "));
			$this->db->where('icd_code.icd_code',$icd_code);
		}
		if($this->input->post('ndps')!=0)
		{
			if($this->input->post('ndps')==1){
				$this->db->where('patient_followup.ndps',1);
			}if($this->input->post('ndps')==2){
				$this->db->where('patient_followup.ndps',0);
			}
		}
		if($this->input->post('state')){
			$this->db->where('state.state_id',$this->input->post('state'));
		}
		if($this->input->post('district')){
			$this->db->where('patient.district_id',$this->input->post('district'));
		}
		
		$this->db->select("route_secondary.route_secondary as secondary_rname,route_primary.route_primary as primary_rname,
		SUM(CASE WHEN patient_followup.priority_type_id=1 THEN 1 ELSE 0 END) AS highcount,
        SUM(CASE WHEN patient_followup.priority_type_id=2 THEN 1 ELSE 0 END) AS mediumcount,
        SUM(CASE WHEN patient_followup.priority_type_id=3 THEN 1 ELSE 0 END) AS lowcount,
		SUM(CASE WHEN patient_followup.priority_type_id = 0  THEN 1 ELSE 0 END) AS unupdated_priority");

		$this->db->from('patient_followup')
		->join('patient','patient_followup.patient_id=patient.patient_id','left')	
		->join('priority_type','patient_followup.priority_type_id=priority_type.priority_type_id','left')
		->join('route_secondary','patient_followup.route_secondary_id=route_secondary.id','left')
		->join('route_primary','route_secondary.route_primary_id=route_primary.route_primary_id','left')
	        ->join('staff','patient_followup.volunteer_id=staff.staff_id','left')
		->join('icd_code','patient_followup.icd_code=icd_code.icd_code','left')
		->join('icd_block','icd_code.block_id=icd_block.block_id','left')	
		->join('icd_chapter','icd_block.chapter_id=icd_chapter.chapter_id','left')
	        ->join('district','district.district_id=patient.district_id','left')
		->join('state','state.state_id=district.state_id','left')
		->where('patient_followup.hospital_id',$hospital['hospital_id']);

		if(!$this->input->post('postback') or $this->input->post('groupbyprimary')) {
			$this->db->group_by('route_secondary.route_primary_id');
		}
		if($this->input->post('groupbysecondary')) {
			$this->db->group_by('patient_followup.route_secondary_id');
		}
		
		$resource = $this->db->get();
		//echo $this->db->last_query();
		return $resource->result();
	}
}	
