<?php 
class Diagnostics_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function order_test() {
		//Input fields
		$doctor_id=$this->input->post('order_by');
		$test_area_id=$this->input->post('test_area');
		$order_date_time=date("Y-m-d H:i:s",strtotime($this->input->post('order_date')." ".$this->input->post('order_time')));
		$order_status=0;

		//Sample fields
		$sample_code=$this->input->post('sample_id');
		$sample_date_time = date("Y-m-d H:i:s");
		$specimen_type_id=$this->input->post('specimen_type');
		$specimen_source=$this->input->post('specimen_source');//--adding an extra field specimen source in order form
		$sample_container_type=$this->input->post('sample_container');
		$sample_status_id=1;

		//Getting patient ID to retrive patient DOB and gender. Tested
		$hospital = $this->session->userdata('hospital');
		$hospital_id = $hospital['hospital_id'];
		$this->db->select('visit_id, patient.patient_id, gender, 
							dob, age_years, age_months, age_days')
			->from('patient_visit')
			->join('patient', 'patient_visit.patient_id=patient.patient_id')
			->where('hosp_file_no',$this->input->post('visit_id'))
			->where('visit_type',$this->input->post('patient_type'))
			->where('YEAR(admit_date)',$this->input->post('year'),false)
			->where('patient_visit.hospital_id',$hospital_id); 
		$query=$this->db->get();
		$row=$query->row();
		$visit_id=$row->visit_id;
		$patient_id = $row->patient_id;
		$gender = $row->gender = 'M' ? 1 : 2;
		$dob = $row->dob;
		$age_years = $row->age_years;
		$age_months = $row->age_months;
		$age_days = $row->age_days;
		$this->db->select('MIN(admit_date) admit_date')
			->from('patient_visit')
			->where('patient_visit.patient_id',$patient_id)
			->group_by('patient_visit.patient_id');
		$query = $this->db->get();
		$row = $query->row();
		$admit_date = $row->admit_date;
		if($dob != strtotime(0)){
			$now = strtotime(date("D M d, Y G:i"));
			$diff = abs($now - $dob);
			$age_years = floor($diff / (365*60*60*24));
			$age_months = floor(($diff - $age_years * 365*60*60*24) / (30*60*60*24));
			$age_days = floor(($diff - $age_years * 365*60*60*24 - $age_months*30*60*60*24)/ (60*60*24));
		}else{
			$now = strtotime(date("D M d, Y G:i"));
			$diff = abs($now - $admit_date);
			$age_years = $age_years + floor($diff / (365*60*60*24));
			$age_months = $age_months + floor(($diff - $age_years * 365*60*60*24) / (30*60*60*24));
			$age_days = $age_days + floor(($diff - $age_years * 365*60*60*24 - $age_months*30*60*60*24)/ (60*60*24));
		}

		//Getting test data
		$test_groups = $this->input->post('test_group');
		$test_master = $this->input->post('test_master');
		$test_data=array();
		if(!!$test_groups){
			foreach($test_groups as $test_group_id) {
				$this->db->select('test_master.test_master_id,has_result')->from('test_master')
				->join('test_group_link','test_master.test_master_id=test_group_link.test_master_id')
				->join('test_group','test_group_link.group_id=test_group.group_id')
				->where('hospital_id',$hospital['hospital_id'])
				->where('test_group.group_id',$test_group_id);
				$query=$this->db->get();
				$results = $query->result();
				foreach($results as $result){
					$test_data[] = array(
						'order_id'=>'',					
						'sample_id'=>'',				
						'test_master_id'=>$result->test_master_id,	
						'group_id'=>$test_group_id,							
						'test_range_id'=>''									
					);
				}
			}
		}
		if(!!$test_master){
			foreach($test_master as $test_id){
				$test_data[] = array(
					'order_id'=>'',					
					'sample_id'=>'',				
					'test_master_id'=>$test_id,			
					'group_id'=>0,						
					'test_range_id'=>''
				);
			}
		}
		//Getting range data
		for($i=0; $i<sizeof($test_data); $i++){
			$this->db->select('test_range_id')
				->from('test_range')
				->where('test_master_id', $test_data[$i]['test_master_id'])
				->where("(($age_years BETWEEN from_year AND to_year) AND ($age_months BETWEEN from_month AND to_month) AND ($age_days BETWEEN from_day AND to_day)
					OR age_type = 4)")
				->where("(gender = 0 OR gender = 3 OR gender = $gender)")
				->limit(1);
			$query = $this->db->get();
			$row = $query->row();
			
			if(sizeof($row) > 0){
				$test_data[$i]['test_range_id'] = $row->test_range_id;
			}			
		}
		//Setting test_master_id = 0 where group set
		if(!!$test_groups){
			foreach($test_groups as $test_group_id) {
				$test_data[] = array(
					'order_id'=>'',					
					'sample_id'=>'',				
					'test_master_id'=>0,			
					'group_id'=>$test_group_id,						
					'test_range_id'=>''
				);
			}
		}
		
		//test_order_data array
		$data=array(
			'visit_id'=>$visit_id,					//Got
			'doctor_id'=>$doctor_id,				//Got
			'test_area_id'=>$test_area_id,			//Got
			'order_date_time'=>$order_date_time,	//Got
			'order_status'=>$order_status,			//Got
			'hospital_id'=>$hospital_id				//Got
		);		
		//Insert test_order
		$this->db->trans_start();
		$this->db->insert('test_order',$data);
		$order_id=$this->db->insert_id();

		//sample_data
		$data=array(
			'sample_code'=>$sample_code,			//Got
			'sample_date_time'=>$sample_date_time,	//Got
			'order_id'=>$order_id,					//Got
			'specimen_type_id'=>$specimen_type_id,	//Got
			'specimen_source'=>$specimen_source,	//Got//including source field in the array containing the fields present in the order form
			'sample_container_type'=>$sample_container_type,//Got
			'sample_status_id'=>$sample_status_id	//Got
		);
		//Insert test_sample
		$this->db->insert('test_sample',$data);
		$sample_id=$this->db->insert_id();
		unset($data);
		//test_data
		for($i = 0; $i < sizeof($test_data); $i++){
			$test_data[$i]['order_id'] = $order_id;
			$test_data[$i]['sample_id'] = $sample_id;
		}
		
		$this->db->insert_batch('test',$test_data);
		
		$this->db->trans_complete();
		if($this->db->trans_status()===FALSE){
			$this->db->trans_rollback();
			return false;
		}
		else 
			return true;
	}

	function get_tests_ordered($test_areas){
		$hospital = $this->session->userdata('hospital');
		if($this->input->post('test_area')){
			$test_area=$this->input->post('test_area');
		}
		else if(count($test_areas)==1){
			$test_area = $test_areas[0]->test_area_id;
		}
		else $test_area="";
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date = date("Y-m-d",strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d",strtotime($this->input->post('to_date')));
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')?$from_date=date("Y-m-d",strtotime($this->input->post('from_date'))):$from_date=date("Y-m-d",strtotime($this->input->post('to_date')));
			$to_date=$from_date;
		}
		else{
			$from_date = date("Y-m-d");
			$to_date=date("Y-m-d");
		}
		if($this->input->post('test_method_search') != ""){
			$this->db->where('tms.test_method_id',$this->input->post('test_method_search'));
		}
		if($this->input->post('hosp_file_no_search') && $this->input->post('patient_type_search')){
			$this->db->where('hosp_file_no',$this->input->post('hosp_file_no_search'));
			$this->db->where('visit_type',$this->input->post('patient_type_search'));
		}
		$this->db->select('test.test_id,test_order.order_id,test_sample.sample_id,test_method,
		test_name,department,visit_type,patient.first_name, patient.last_name,
		staff.first_name staff_name,hosp_file_no,sample_code,specimen_type,
		specimen_source,sample_container_type,test_status, ts.nabl',false)
		->from('test_order')
		->join('test','test_order.order_id=test.order_id')
		->join('test_sample','test_order.order_id=test_sample.order_id','left')
		->join('test_group','test.group_id=test_group.group_id','left')
		->join('test_master as ts','test.test_master_id=ts.test_master_id','left')		
		->join('test_method tms','ts.test_method_id=tms.test_method_id','left')
		->join('staff','test_order.doctor_id=staff.staff_id','left')
		->join('patient_visit','test_order.visit_id=patient_visit.visit_id')
		->join('patient','patient_visit.patient_id=patient.patient_id')
		->join('department','patient_visit.department_id=department.department_id')
		->join('specimen_type','test_sample.specimen_type_id=specimen_type.specimen_type_id','left')
		->where("(DATE(order_date_time) BETWEEN '$from_date' AND '$to_date')") 
		->where('order_status <',2)
		->where('test_order.test_area_id',$test_area)
		->where('test_order.hospital_id',$hospital['hospital_id']);
		$query=$this->db->get();
		
		return $query->result();
	}
	
	function get_tests_completed($test_areas){
		$hospital = $this->session->userdata('hospital');
		$this->input->post('test_area')?$test_area=$this->input->post('test_area'):$test_area="";
		if(count($test_areas)==1){
			$test_area = $test_areas[0]->test_area_id;// test_area will be updated if condition is satisfied i.e. if the value is one
		}
		//if both the fields that is "from_date" & "to_date" are entered than if condition would be executed  
		if($this->input->post('from_date') && $this->input->post('to_date')){ 
			$from_date = date("Y-m-d",strtotime($this->input->post('from_date')));  
			$to_date = date("Y-m-d",strtotime($this->input->post('to_date')));//
			}
		//if anyone of the fields either "from_date" or "to_date" are entered in this condition
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')?$from_date=date("Y-m-d",strtotime( $this->input->post('from_date'))):$from_date=date("Y-m-d",strtotime($this->input->post('to_date')));
			$to_date=$from_date;
		}
		//if both the fields (from_date and to_date) are not entered then default values would be assigned in this condition
		else{
			$from_date = date("Y-m-d"); 
			$to_date=date("Y-m-d");
		}
		//test_method_search searches out the test_method_id 
		if($this->input->post('test_method_search') != ""){
			$this->db->where('test_method.test_method_id',$this->input->post('test_method_search'));
		}
		//patient_type_search would search weather the patient is inpatient or outpatient
		if($this->input->post('hosp_file_no_search') && $this->input->post('patient_type_search')){
			$this->db->where('hosp_file_no',$this->input->post('hosp_file_no_search'));
			$this->db->where('visit_type',$this->input->post('patient_type_search'));
		}
		//the above searches will get the details of the patient
		$this->db->select('test.test_id,test_order.order_id,test_sample.sample_id,test_method,test_name,department,visit_type,patient.first_name, patient.last_name,
							staff.first_name staff_name,hosp_file_no,sample_code,specimen_type,specimen_source,sample_container_type,test_status,test_master.nabl,study_id,filepath')//adding the specimen source in the update tests
		->from('test_order')
		->join('test','test_order.order_id=test.order_id')
		->join('dicom','test.test_id = dicom.test_id','left')
		->join('test_sample','test_order.order_id=test_sample.order_id','left')
		->join('test_master','test.test_master_id=test_master.test_master_id')
		->join('test_method','test_master.test_method_id=test_method.test_method_id')
		->join('staff','test_order.doctor_id=staff.staff_id','left')
		->join('patient_visit','test_order.visit_id=patient_visit.visit_id'	)
		->join('patient','patient_visit.patient_id=patient.patient_id')
		->join('department','patient_visit.department_id=department.department_id')
		->join('specimen_type','test_sample.specimen_type_id=specimen_type.specimen_type_id','left')
		
		->where("(DATE(order_date_time) BETWEEN '$from_date' AND '$to_date')") 
		->where('test_master.test_area_id',$test_area)
        ->where('test.test_status',1)
		->where('test_order.hospital_id',$hospital['hospital_id']);//the orders will be approve if their value is 1. So we verify the condition to display the outcome
		$query=$this->db->get(); 
		return $query->result();
	}
	
	function get_tests($test_areas){
		$hospital = $this->session->userdata('hospital');
		$this->input->post('test_area')?$test_area=$this->input->post('test_area'):$test_area="";
		if(count($test_areas)==1){
			$test_area = $test_areas[0]->test_area_id;// test_area will be updated if condition is satisfied i.e. if the value is one
		}
		//if both the fields that is "from_date" & "to_date" are entered than if condition would be executed  
		if($this->input->post('from_date') && $this->input->post('to_date')){ 
			$from_date = date("Y-m-d",strtotime($this->input->post('from_date')));  
			$to_date = date("Y-m-d",strtotime($this->input->post('to_date')));//
			}
		//if anyone of the fields either "from_date" or "to_date" are entered in this condition
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')?$from_date=date("Y-m-d",strtotime( $this->input->post('from_date'))):$from_date=date("Y-m-d",strtotime($this->input->post('to_date')));
			$to_date=$from_date;
		}
		//if both the fields (from_date and to_date) are not entered then default values would be assigned in this condition
		else{
			$from_date = date("Y-m-d"); 
			$to_date=date("Y-m-d");
		}
		//test_method_search searches out the test_method_id 
		if($this->input->post('test_method_search') != ""){
			$this->db->where('test_method.test_method_id',$this->input->post('test_method_search'));
		}
		//patient_type_search would search weather the patient is inpatient or outpatient
		if($this->input->post('hosp_file_no_search') && $this->input->post('patient_type_search')){
			$this->db->where('hosp_file_no',$this->input->post('hosp_file_no_search'));
			$this->db->where('visit_type',$this->input->post('patient_type_search'));
		}
		//the above searches will get the details of the patient
		$this->db->select('test.test_id,test_order.order_id,test_sample.sample_id,test_method,test_name,department,visit_type,patient.first_name, patient.last_name,
							staff.first_name staff_name,hosp_file_no,sample_code,specimen_type,specimen_source,sample_container_type,test_status,study_id,filepath')//adding the specimen source in the update tests
		->from('test_order')
		->join('test','test_order.order_id=test.order_id')
		->join('dicom','test.test_id = dicom.test_id','left')
		->join('test_sample','test_order.order_id=test_sample.order_id','left')
		->join('test_master','test.test_master_id=test_master.test_master_id')
		->join('test_method','test_master.test_method_id=test_method.test_method_id')
		->join('staff','test_order.doctor_id=staff.staff_id','left')
		->join('patient_visit','test_order.visit_id=patient_visit.visit_id'	)
		->join('patient','patient_visit.patient_id=patient.patient_id')
		->join('department','patient_visit.department_id=department.department_id')
		->join('specimen_type','test_sample.specimen_type_id=specimen_type.specimen_type_id','left')
		->where("(DATE(order_date_time) BETWEEN '$from_date' AND '$to_date')") 
		->where('test_master.test_area_id',$test_area)
		->where('test_order.hospital_id',$hospital['hospital_id'])
        ->where_in('test.test_status',array(0,1));
		$query=$this->db->get(); 
		return $query->result();
	}
	
	function get_tests_approved($test_areas){
		$hospital = $this->session->userdata('hospital');
		$this->input->post('test_area')?$test_area=$this->input->post('test_area'):$test_area="";
		if(count($test_areas)==1){
			$test_area = $test_areas[0]->test_area_id;
		}
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date = date("Y-m-d",strtotime($this->input->post('from_date')));
			$to_date = date("Y-m-d",strtotime($this->input->post('to_date')));
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')?$from_date=date("Y-m-d",strtotime($this->input->post('from_date'))):$from_date=date("Y-m-d",strtotime($this->input->post('to_date')));
			$to_date=$from_date;
		}
		else{
			$from_date = date("Y-m-d");
			$to_date=date("Y-m-d");
		}
		if($this->input->post('test_method_search') != ""){
			$this->db->where('test_method.test_method_id',$this->input->post('test_method_search'));
		}
		if($this->input->post('hosp_file_no_search') && $this->input->post('patient_type_search')){
			$this->db->where('hosp_file_no',$this->input->post('hosp_file_no_search'));
			$this->db->where('visit_type',$this->input->post('patient_type_search'));
		}
		$this->db->select('test.test_id,test_order.order_id,test_sample.sample_id,test_method,test_name,department,visit_type,patient.first_name, patient.last_name,
							staff.first_name staff_name,hosp_file_no,sample_code,specimen_type,specimen_source,sample_container_type,test_status,test_master.nabl,study_id,filepath')//adding the specimen source in the update tests
		->from('test_order')
		->join('test','test_order.order_id=test.order_id')
		->join('dicom','test.test_id = dicom.test_id','left')
		->join('test_sample','test_order.order_id=test_sample.order_id','left')
		->join('test_master','test.test_master_id=test_master.test_master_id')
		->join('test_method','test_master.test_method_id=test_method.test_method_id')
		->join('staff','test_order.doctor_id=staff.staff_id','left')
		->join('patient_visit','test_order.visit_id=patient_visit.visit_id')
		->join('patient','patient_visit.patient_id=patient.patient_id')
		->join('department','patient_visit.department_id=department.department_id')
		->join('specimen_type','test_sample.specimen_type_id=specimen_type.specimen_type_id','left')
		->where("(DATE(order_date_time) BETWEEN '$from_date' AND '$to_date')") 
		->where('test_status',2)
		->where('test_master.test_area_id',$test_area)
		->where('test_order.hospital_id',$hospital['hospital_id']);
		$query=$this->db->get();
		return $query->result();
	}
	
	function get_order(){
		$hospital = $this->session->userdata('hospital');
		$order_id=$this->input->post('order_id');
		$this->db->select('test.test_id,test.test_master_id,test_group.group_id,test_order.order_id,test_order.order_date_time,test.reported_date_time,test_sample.sample_id,test_method,accredition_logo,
		IFNULL(test_name,group_name)test_name,department.department,unit_name,area_name,age_years,age_months,age_days,patient.gender,patient.first_name, patient.last_name,visit_type,
		order_date_time,hosp_file_no,sample_code,specimen_type,sample_container_type,
		department.department_email,
		a_staff.staff_id a_id,a_staff.email a_email,a_staff.first_name a_first_name,a_staff.phone a_phone,
		u_staff.staff_id u_id,u_staff.email u_email,u_staff.first_name u_first_name,u_staff.phone u_phone,
		d_staff.staff_id d_id,d_staff.email d_email,d_staff.first_name d_first_name,d_staff.phone d_phone,
		IFNULL(ts.binary_result,test_group.binary_result) binary_result,
		IFNULL(ts.numeric_result,test_group.numeric_result) numeric_result,
		IFNULL(ts.text_result,test_group.text_result) text_result,
		IFNULL(ts.binary_positive,test_group.binary_positive) binary_positive,
		IFNULL(ts.binary_negative,test_group.binary_negative) binary_negative,
		IFNULL(lus.lab_unit,lug.lab_unit) lab_unit,
		IF(tms.test_method = "Culture%",1,0) culture, 
		test_status,
		test_result_binary,
		test_result,
		test_result_text,hospital,hospital.logo,hospital.place,district,state,test_area,provisional_diagnosis,
		IF(micro_organism_test.micro_organism_test_id!="",GROUP_CONCAT(DISTINCT CONCAT(micro_organism_test.micro_organism_test_id,",",micro_organism,",",antibiotic),",",antibiotic_result,"^"),0) micro_organism_test,
		approved_by.first_name approved_first,approved_by.last_name approved_last,approved_by.designation approved_by_designation,
		done_by.first_name done_first,done_by.last_name done_last,done_by.designation done_by_designation,ts.text_range,test_range.min,test_range.max,test_range.range_text,test_range.range_type,  test_range.range_text, test_sample.specimen_source, test_sample.sample_id, test_assay.assay, ts.nabl,
         ts.interpretation test_master_interpretation, test_group.interpretation test_group_interpretation, study_id,filepath',false)
		->from('test_order')->join('test','test_order.order_id=test.order_id','left')->join('test_sample','test_order.order_id=test_sample.order_id','left')		
		->join('test_group','test.group_id=test_group.group_id','left')
		->join('test_master as ts','test.test_master_id=ts.test_master_id','left')
		->join('test_assay','test_assay.assay_id = ts.assay_id','left')
		->join('dicom','test.test_id=dicom.test_id','left')
		->join('test_range','test.test_range_id=test_range.test_range_id','left')
		->join('lab_unit lus','ts.numeric_result_unit=lus.lab_unit_id','left')
		->join('lab_unit lug','test_group.numeric_result_unit=lug.lab_unit_id','left')
		->join('test_method tms','ts.test_method_id=tms.test_method_id','left')
		->join('test_area tas','ts.test_area_id=tas.test_area_id','left')
		->join('micro_organism_test','test.test_id = micro_organism_test.test_id','left')
		->join('antibiotic_test','micro_organism_test.micro_organism_test_id = antibiotic_test.micro_organism_test_id','left')
		->join('antibiotic','antibiotic_test.antibiotic_id = antibiotic.antibiotic_id','left')
		->join('micro_organism','micro_organism_test.micro_organism_id = micro_organism.micro_organism_id','left')
		->join('user approved_user','test.test_approved_by = approved_user.user_id','left')
		->join('staff approved_by','approved_user.staff_id = approved_by.staff_id','left')
		->join('user done_user','test.test_done_by = done_user.user_id','left')
		->join('staff done_by','done_user.staff_id = done_by.staff_id','left')
		->join('patient_visit','test_order.visit_id = patient_visit.visit_id','left')
		->join('patient','patient_visit.patient_id = patient.patient_id','left')
		->join('department','patient_visit.department_id = department.department_id','left')
		->join('staff d_staff','department.lab_report_staff_id=d_staff.staff_id','left')
		->join('unit','patient_visit.unit=unit.unit_id','left')
		->join('staff u_staff','unit.lab_report_staff_id=u_staff.staff_id','left')
		->join('area','patient_visit.area=area.area_id','left')
		->join('staff a_staff','area.lab_report_staff_id=a_staff.staff_id','left')
		->join('department test_dept','tas.department_id=test_dept.department_id','left')
		->join('hospital','test_dept.hospital_id=hospital.hospital_id','left')
		->join('specimen_type','test_sample.specimen_type_id=specimen_type.specimen_type_id','left')
		->where('test_order.hospital_id',$hospital['hospital_id'])
		->group_by('test_id');
		$this->db->where('test_order.order_id',$order_id);
		$query=$this->db->get();
		
		return $query->result();
	}		
	
	
	function get_test_suggestions(){
		$hospital = $this->session->userdata('hospital');
		$order_id=$this->input->post('order_id');
		$this->db->select('test_master_id, suggestion')
		->from('test_result_suggestion');
		
		
		$query=$this->db->get();
		
		return $query->result();
		
	}
	
	function upload_test_results(){
		$hospital = $this->session->userdata('hospital');
		$tests=$this->input->post('test');
		$userdata=$this->session->userdata('logged_in');
		$data=array();
		$antibiotics_data=array();
		$this->db->trans_start();
		if(!!$tests){
		foreach($tests as $test){
			if($this->input->post('binary_result_'.$test)!=NULL || $this->input->post('numeric_result_'.$test)!=NULL || $this->input->post('text_result_'.$test)!=NULL){
				if(!is_null($this->input->post('binary_result_'.$test))) 
					$binary_result=$this->input->post('binary_result_'.$test);
				else 
                                    $binary_result=NULL;
				$numeric_result=$this->input->post('numeric_result_'.$test);
                                $numeric_result  = empty($numeric_result) ? NULL : $numeric_result;
				$text_result=$this->input->post('text_result_'.$test);
				$data[]=array(
					'test_id'=>$test,
					'test_result_binary'=>$binary_result,
					'test_result'=>$numeric_result,
					'test_result_text'=>$text_result,
					'test_date_time'=>date("Y-m-d H:i:s"),
					'test_status'=>1,
					'test_done_by'=>$userdata['user_id']
				);
				
				if($binary_result == 1 && !!$this->input->post('micro_organisms_'.$test)){
					$micro_organisms = $this->input->post('micro_organisms_'.$test);
					$m=0;
					foreach($micro_organisms as $mo){
						$this->db->insert('micro_organism_test',array('test_id'=>$test,'micro_organism_id'=>$mo));
						$micro_organism_test_id = $this->db->insert_id();
						if(count($this->input->post('antibiotics_'.$test."_".$mo))>0){
							$antibiotics=$this->input->post('antibiotics_'.$test.'_'.$mo);
							$i=0;
							$antibiotic_array=array();
							foreach($antibiotics as $ab){
								if(!in_array($this->input->post('antibiotics_'.$test.'_'.$mo.'_'.$i),$antibiotic_array)){
								$antibiotics_data[] = array(
									'antibiotic_id'=>$this->input->post('antibiotics_'.$test.'_'.$mo.'_'.$i),
									'micro_organism_test_id'=>$micro_organism_test_id,
									'antibiotic_result'=>$this->input->post('antibiotic_results_'.$test.'_'.$mo.'_'.$i),
								);
								$antibiotic_array[]=$this->input->post('antibiotics_'.$test.'_'.$mo.'_'.$i);
								}
							$i++;
							}
						}
						else{
							$this->db->trans_rollback();
							return false;
						}
						$m++;
					}
				}
			}
		}
		}
		if(!!$antibiotics_data)
		$this->db->insert_batch('antibiotic_test',$antibiotics_data);
		$this->db->update_batch('test',$data,'test_id');
		$this->db->select('test_status,test_master_id')
		->from('test')
		->join('test_order','test.order_id=test_order.order_id')
		->where('test_order.order_id',$this->input->post('order_id'))
		->where('test_order.hospital_id',$hospital['hospital_id']);
		$query=$this->db->get();
		$result=$query->result();
		$order_status=2;
		foreach($result as $row){
			if($row->test_status == 0 && $row->test_master_id != 0) $order_status = 1;
		}
		if($order_status==2){
			$this->db->where('order_id',$this->input->post('order_id'));
			$this->db->update('test_order',array('order_status'=>$order_status));
		}
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
					$this->db->trans_rollback();
					return false;
		}
		else return true;			
	}
	
	function approve_results(){
		$hospital = $this->session->userdata('hospital');
		$this->db->trans_start();
		$userdata = $this->session->userdata('logged_in');
		$order_approved = 1;
		foreach($this->input->post('test') as $test){
			if($this->input->post('approve_test_'.$test)==1){
				$status =2;
			}
			else if($this->input->post('approve_test_'.$test)==0){
				$status =3;
			}
			else if($this->input->post('approve_test_'.$test)==2){
				$status=1;
				$order_approved=0;
			}				
			$this->db->where('test_id',$test);
			if($this->input->post('text_result')){
				$this->db->update('test',array('test_status'=>$status,'test_approved_by'=>$userdata['user_id'],'reported_date_time'=>date("Y-m-d H:i:s"),'test_result_text'=>$this->input->post('text_result_'.$test)));
			}
			else{
			$this->db->update('test',array('test_status'=>$status,'test_approved_by'=>$userdata['user_id'],'reported_date_time'=>date("Y-m-d H:i:s")));
			}
		}
		if($order_approved==1){
			$this->db->where('order_id',$this->input->post('order_id'));
			$this->db->update('test_order',array('order_status'=>2));
		}
		$this->db->select('department,department_email,
		a_staff.staff_id a_id,a_staff.email a_email,a_staff.first_name a_first_name,a_staff.phone a_phone,
		u_staff.staff_id u_id,u_staff.email u_email,u_staff.first_name u_first_name,u_staff.phone u_phone,
		d_staff.staff_id d_id,d_staff.email d_email,d_staff.first_name d_first_name,d_staff.phone d_phone',false)
		->from('test_order')->join('patient_visit','test_order.visit_id = patient_visit.visit_id')
		->join('area','patient_visit.area = area.area_id','left')
		->join('staff a_staff','area.lab_report_staff_id = a_staff.staff_id','left')
		->join('unit','patient_visit.unit = unit.unit_id','left')
		->join('staff u_staff','unit.lab_report_staff_id = u_staff.staff_id','left')
		->join('department','patient_visit.department_id = department.department_id','left')
		->join('staff d_staff','department.lab_report_staff_id = d_staff.staff_id','left')
		->where('order_id',$this->input->post('order_id'))
		->where('test_order.hospital_id',$hospital['hospital_id']);
		$query=$this->db->get();
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		else{
			return $query->row();
		}	
	}
	
	function cancel_order(){
		$hospital = $this->session->userdata('hospital');
		$this->db->trans_start();
		$userdata = $this->session->userdata('logged_in');
		$this->db->where('order_id',$this->input->post('order_id'));
		$this->db->update('test_order',array('order_status'=>3));
		$this->db->where('order_id',$this->input->post('order_id'));
		$this->db->update('test',array('test_status'=>4));
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}
		else{
			return true;
		}	
	}
	
	function search_patients(){
		$hospital = $this->session->userdata('hospital');
		$this->db->select('first_name,last_name,hosp_file_no,patient.patient_id,age_years,age_months,age_days')
		->from('patient')
		->join('patient_visit','patient.patient_id = patient_visit.patient_id')
		->like('hosp_file_no',$this->input->post('query'),'after')
		->where('YEAR(admit_date)',$this->input->post('year'))
		->where('visit_type',$this->input->post('visit_type'))
		->where('patient_visit.hospital_id',$hospital['hospital_id']);
		$query=$this->db->get();
		if($query->num_rows()>0){
		return $query->result_array();
		}
		else return false;
	}
	
	
	function get_all_tests($visit_id){
		$hospital = $this->session->userdata('hospital');
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')?$from_date=$this->input->post('from_date'):$from_date=$this->input->post('to_date');
			$to_date=$from_date;
		}
		if($this->input->post('visit_type')){
			$this->db->where('patient_visit.visit_type',$this->input->post('visit_type'));
		}
		if(!!$visit_id){
			$this->db->where('patient_visit.visit_id',$visit_id);
		}
		$this->db->select('test.test_id,test_order.order_id,order_date_time,age_years,age_months,age_days,test_sample.sample_id,test_method,test_name,
							department,patient.first_name, patient.last_name,hosp_file_no,visit_type,sample_code,
							specimen_type,sample_container_type,test_status,test_result,test_result_text,numeric_result,lab_unit,
							(CASE WHEN binary_result = 1 AND test_result_binary = 1 THEN binary_positive ELSE binary_negative END) test_result_binary, binary_result,
							text_result,study_id,filepath')
		->from('test_order')
		->join('test','test_order.order_id=test.order_id')
		->join('dicom','test.test_id = dicom.test_id','left')
		->join('test_sample','test.sample_id=test_sample.sample_id','left')
		->join('test_master','test.test_master_id=test_master.test_master_id')
		->join('lab_unit','test_master.numeric_result_unit=lab_unit.lab_unit_id','left')
		->join('test_method','test_master.test_method_id=test_method.test_method_id')
		->join('test_area','test_master.test_area_id=test_area.test_area_id')
		->join('patient_visit','test_order.visit_id=patient_visit.visit_id')
		->join('patient','patient_visit.patient_id=patient.patient_id')
		->join('department','patient_visit.department_id=department.department_id')
		->join('specimen_type','test_sample.specimen_type_id=specimen_type.specimen_type_id','left')
		->where('test_order.hospital_id',$hospital['hospital_id'])
		->group_by('test.test_id')
		->order_by('order_date_time','desc');	  
		$query=$this->db->get();
		return $query->result();
	}
        
    function tests_info($type){
		$hospital = $this->session->userdata('hospital');
        if($type=='master_tests'){
            $this->db->select("test_master.test_master_id,test_method,test_name, binary_result, numeric_result, text_result,test_area,comments,COUNT(test_range_id) ranges_count, lab_unit")
                    ->from("test_master")            
                    ->join('test_area','test_master.test_area_id=test_area.test_area_id')
                    ->join('test_method','test_master.test_method_id=test_method.test_method_id','left')
                    ->join('test_range','test_master.test_master_id = test_range.test_master_id','left')
                    ->join('lab_unit','test_master.numeric_result_unit=lab_unit.lab_unit_id')
					->where('test_master.hospital_id',$hospital['hospital_id'])
                    ->group_by('test_master.test_master_id');
            $query = $this->db->get();
            return $query->result();
        }
    }
    
    function test_range_info($type){
		$hospital = $this->session->userdata('hospital');
        if($type=='master_tests'){
            $this->db->select("test_range.test_master_id,gender, min, max, from_year, to_year, from_month, to_month, from_day, to_day, age_type, range_type")
                    ->from("test_range")
					->join('test_master','test_range.test_master_id = test_master.test_master_id')
					->where('test_master.hospital_id',$hospital['hospital_id']);
            $query = $this->db->get();
            return $query->result();
        }
    }
	
	function get_new_dicoms(){
		$hospital = $this->session->userdata('hospital');
		$config['hostname'] = "localhost";
		$config['username'] = "root";
		$config['password'] = "password";
		$config['database'] = "pacsdb";
		$config['dbdriver'] = 'mysql';
		$config['dbprefix'] = '';
		$config['pconnect'] = TRUE;
		$config['db_debug'] = TRUE;
		$config['cache_on'] = FALSE;
		$config['cachedir'] = '';
		$config['char_set'] = 'utf8';
		$config['dbcollat'] = 'utf8_general_ci';
		$dbt=$this->load->database($config,TRUE);
		
		$dbt->select('study.study_id,num_series series_count,pat_id,TIMESTAMPDIFF(MONTH,pat_birthdate,CURDATE()) age,pat_sex,pat_name,modality,study_datetime,body_part,filepath')
		->from('study')
		->join('patient','patient.pk = study.patient_fk')
		->join('series','study.pk = series.study_fk')
		->join('instance','series.pk = instance.series_fk')
		->join('files','instance.pk = files.instance_fk')
		->where('patient.hospital_id',$hospital['hospital_id'])
		->group_by('study.study_id')
		->where('stored','0');
		$query = $dbt->get();
		return $query->result();
	}
	
	
	
	
	function get_test_masters_radiology(){
		$hospital = $this->session->userdata('hospital');
		$this->db->select("test_master_id,test_name,test_master.test_method_id,test_master.test_area_id,test_method")
			->from("test_master")
			->join('test_method','test_master.test_method_id=test_method.test_method_id')
			->join('test_area','test_master.test_area_id=test_area.test_area_id')
			->where('test_area.test_area','Radiology')
			->where('test_master.hospital_id',$hospital['hospital_id'])
			->order_by('test_name');
		$query=$this->db->get();
		return $query->result();
	}
	
	
	function import_dicom(){
	$hospital = $this->session->userdata('hospital');
	$userdata = $this->session->userdata('logged_in');
	$this->db->select('visit_id')->from('patient_visit')
		->where('hosp_file_no',$this->input->post('visit_id'))
		->where('visit_type',$this->input->post('patient_type'))
		->where('YEAR(admit_date)',$this->input->post('year'),false); 
		$query=$this->db->get();
		$row=$query->row();
		$visit_id=$row->visit_id;
		if($this->input->post('study_id')){
			$order_status = 1;
			$test_status = 0;
			if($this->input->post('emergency')){
				$order_status = 2;
				$test_status = 2;
			}
			$order = array(
				'visit_id' => $visit_id,
				'test_area_id' => $this->input->post('test_area_id'),
				'order_date_time'=>$this->input->post('study_datetime'),
				'order_status'=>$order_status,
				'hospital_id'=>$hospital['hospital_id']
			);
			$this->db->insert('test_order',$order);
			$order_id = $this->db->insert_id();
			if($this->input->post('emergency')){
				$test = array(
					'order_id'=>$order_id,
					'test_master_id'=>$this->input->post('test_master'),
					'test_status'=>$test_status,
					'test_date_time'=>$this->input->post('study_datetime'),
					'reported_date_time'=>date("Y-m-d H:i:s"),
					'test_done_by'=>$userdata['user_id']
				);
			}
			else{
				$test = array(
					'order_id'=>$order_id,
					'test_master_id'=>$this->input->post('test_master'),
					'test_status'=>$test_status
				);
			}
			$this->db->insert('test',$test);
			$test_id = $this->db->insert_id();
					$studies=array(
					'study_id'=>$this->input->post('study_id'),
					'visit_id'=>$visit_id,
					'modality'=>$this->input->post('study_modality'),
					'study_datetime'=>$this->input->post('study_datetime'),
					'filepath'=>$this->input->post('filepath'),
					'test_id'=>$test_id
					);
			if($this->db->insert('dicom',$studies)){
			
				$config['hostname'] = "localhost";
				$config['username'] = "root";
				$config['password'] = "password";
				$config['database'] = "pacsdb";
				$config['dbdriver'] = 'mysql';
				$config['dbprefix'] = '';
				$config['pconnect'] = TRUE;
				$config['db_debug'] = TRUE;
				$config['cache_on'] = FALSE;
				$config['cachedir'] = '';
				$config['char_set'] = 'utf8';
				$config['dbcollat'] = 'utf8_general_ci';
				$dbt=$this->load->database($config,TRUE);
				$studystatus = array(
					'stored'=>1
				);
				$dbt->where('study_id',$this->input->post('study_id'));
				$dbt->update('study',$studystatus);
			}
			return true;
		}
	}
	function get_dicom_images($study){
		$hospital = $this->session->userdata('hospital');
	
		$config['hostname'] = "localhost";
		$config['username'] = "root";
		$config['password'] = "password";
		$config['database'] = "pacsdb";
		$config['dbdriver'] = 'mysql';
		$config['dbprefix'] = '';
		$config['pconnect'] = TRUE;
		$config['db_debug'] = TRUE;
		$config['cache_on'] = FALSE;
		$config['cachedir'] = '';
		$config['char_set'] = 'utf8';
		$config['dbcollat'] = 'utf8_general_ci';
		$dbt=$this->load->database($config,TRUE);
		$dbt->select("filepath")->from('study')->join('series','study.pk = series.study_fk')
		->join('instance','series.pk=instance.series_fk')
		->join('files','instance.pk=files.instance_fk')
		->where('study.hospital_id',$hospital['hospital_id'])
		->where('study.study_id',$study);
		$query = $dbt->get();
		return $query->result();
		
	}
	
        function lab_turnaround_time(){
		$hospital = $this->session->userdata('hospital');
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
            /*  SELECT test_master.test_name, 
                SUM( CASE WHEN test_status =0 THEN 1 ELSE 0 END ) AS ordered,
                SUM( CASE WHEN test_status =0 THEN TIMESTAMPDIFF(MINUTE, reported_date_time, test_date_time) ELSE 0 END ) AS ordered_to_update,
                SUM( CASE WHEN test_status =1 THEN 1 ELSE 0 END ) AS updated,
                SUM( CASE WHEN test_status =1 THEN TIMESTAMPDIFF(MINUTE, reported_date_time, test_date_time) ELSE 0 END ) AS update_to_approve,
                SUM( CASE WHEN test_status =2 THEN 1 ELSE 0 END ) AS approved
                FROM  `test` 
                JOIN test_master ON test_master.test_master_id = test.test_master_id
                JOIN test_order ON test_order.order_id = test.order_id 
                WHERE test_order.order_date_time BETWEEN '2017-01-11' AND '2017-01-12'
                GROUP BY  `test`.`test_master_id` ORDER BY ordered

            
            
            $this->db->select("test_master.test_name, "
                . "SUM(CASE WHEN test.test_status IN (0,1,2,3) THEN 1 ELSE 0 END) AS ordered,"
                . "SUM(CASE WHEN test.test_status IN (0,1,2,3) THEN TIMESTAMPDIFF( MINUTE, test_order.order_date_time, test.test_date_time ) ELSE 0 END) ordered_to_update,"
                . "SUM( CASE WHEN test.test_status IN (1,2,3) THEN 1 ELSE 0 END ) updated,"
                . "SUM( CASE WHEN test_status IN (1,2,3) THEN TIMESTAMPDIFF( MINUTE, reported_date_time, test_date_time ) ELSE 0 END ) AS update_to_approve,"
                . "SUM( CASE WHEN test_status = 2 THEN 1 ELSE 0 END ) approved",false)
                ->from("test")
                ->join('test_master','test_master.test_master_id=test.test_master_id')
                ->join('test_order','test_order.order_id=test.order_id')
                ->where("DATE( test_order.order_date_time ) BETWEEN '$from_date' AND '$to_date'")
                ->group_by('test.test_master_id');
             * 
             * 
             */
            
            $this->db->select("test_master.test_name, "
                . "SUM(CASE WHEN test.test_status IN (0,1,2,3) THEN 1 ELSE 0 END) AS ordered,"
                . "SUM(CASE WHEN test.test_status IN (0,1,2,3) AND test_date_time>0 THEN TIMESTAMPDIFF( MINUTE, test_order.order_date_time, test.test_date_time ) ELSE 0 END) ordered_to_update,"
                . "SUM( CASE WHEN test.test_status IN (1,2,3) THEN 1 ELSE 0 END ) updated,"
                . "SUM( CASE WHEN test_status IN (1,2,3) AND reported_date_time>0 THEN TIMESTAMPDIFF( MINUTE,test_date_time, reported_date_time ) ELSE 0 END ) AS update_to_approve,"
                . "SUM( CASE WHEN test_status IN (1,2,3) AND reported_date_time>0 THEN TIMESTAMPDIFF( MINUTE,order_date_time, reported_date_time ) ELSE 0 END ) AS ordered_to_approve,"
                . "SUM( CASE WHEN test_status = 2 THEN 1 ELSE 0 END ) approved",false)
		->from('test_order')
		->join('test_sample','test_order.order_id = test_sample.order_id')
		->join('patient_visit','test_order.visit_id = patient_visit.visit_id')
		->join('department','patient_visit.department_id = department.department_id')
		->join('test_area','test_order.test_area_id = test_area.test_area_id')
		->join('test','test_order.order_id = test.order_id','left')
		->join('test_master','test.test_master_id = test_master.test_master_id')
		->join('test_method','test_master.test_method_id = test_method.test_method_id')
		->where("(DATE(order_date_time) BETWEEN '$from_date' AND '$to_date')")
		->where('test_order.hospital_id',$hospital['hospital_id'])
		->group_by('test_method.test_method,test_master.test_master_id');
            
            $query=$this->db->get();
            return $query->result();
        }
}
?>