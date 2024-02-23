<?php 
class Register_model extends CI_Model{
	private $patient_visit = array(
		'hospital_id','admit_id','visit_type','visit_name_id','patient_id','hosp_file_no',
		'admit_date','admit_time','department_id','unit','area','nurse','insurance_case',
		'insurance_id','insurance_no','presenting_complaints','past_history','family_history','admit_weight',
		'pulse_rate','respiratory_rate','temperature','sbp','dbp','spo2', 'blood_sugar','hb','hb1ac',
		'clinical_findings','cvs','rs','pa','cns','cxr','provisional_diagnosis',
		'final_diagnosis','decision','advise','discharge_weight','outcome','outcome_date',
		'outcome_time','ip_file_received','mlc','arrival_mode','referral_by_hospital_id','insert_by_user_id',
		'update_by_user_id','insert_datetime','update_datetime','temp_visit_id'
	);
	private $patient = array(
		'patient_id_manual','identification_marks','first_name','middle_name','last_name','dob',
		'age_years','age_months','age_days','gender','address','place','country_code','state_code',
		'district_id','phone','alt_phone','father_name','mother_name','spouse_name','id_proof_type_id',
		'id_proof_number','occupation_id','education_level','education_qualification','blood_group','mr_no',
		'bc_no','gestation','gestation_type'
	);
	private $mlc = array(
		'visit_id',  'mlc_number', 'mlc_number_manual', 'ps_name', 'brought_by', 'police_intimation', 'declaration_required', 'pc_number', 'mlc_id'
	);
	private $patient_clinical_notes = array(
		'note_id', 'visit_id', 'clinical_note', 'user_id', 'note_time', 'update_time'
	);
	private $prescription = array(
		'prescription_id',  'visit_id',  'item_id',  'duration',  'frequency',  'morning',  'afternoon',  'evening',  'quantity',  'unit_id',  'status'
	);
	/**
	 * 'delivery_mode','delivery_place','delivery_location',
		'hospital_type','delivery_location_type','hospital_type','delivery_location_type','delivery_plan',
		'birth_weight','congenital_anomalies','insert_by_user_id','update_by_user_id','insert_datetime',
		'update_datetime','temp_patient_id','hospital_id
	 */
	function __construct(){
		parent::__construct();
	}
	function get_summary($summary_link_contents_md5) {
		$this->db->select("summary_link_contents")
			->from("patient_consultation_summary")
			->where('summary_link_contents_md5',$summary_link_contents_md5);
		$query=$this->db->get();
		return $query->result();
	}
	function notify_summary_download(){
		if ($this->input->post('summary_key') && $this->input->post('summary_key')!=""){
			$this->db->set('totaldownloads', 'totaldownloads+1', FALSE);
			$this->db->set('last_download_at', date("Y-m-d H:i:s"));
			$this->db->where('summary_link_contents_md5', $this->input->post('summary_key'));
			$this->db->update('patient_consultation_summary');
		}
	}
	
	function get_upload_link_metadata($key_md5) {
		$array = array('pdu.key_md5' => $key_md5, 'pdu.expires_at >' => date("Y-m-d H:i:s"));
		$this->db->select("pdu.patient_id,CONCAT(IF(p.first_name=NULL,'',p.first_name),' ',IF(p.last_name=NULL,'',p.last_name)) name,pdu.expires_at",false)
		->from("patient_document_upload_key as pdu")
		->join("patient as p","pdu.patient_id=p.patient_id")
		->where($array);
		$query=$this->db->get();
		$result = $query->result();
		if(count($result)>0){
			$this->db->set('no_of_access', 'no_of_access+1', FALSE);
			$this->db->set('last_accessed_time', date("Y-m-d H:i:s"));
			$this->db->where($array);
			$this->db->update('patient_document_upload_key as pdu');
		}
		return $result;
	}
	
	
	function insert_update_patient_document_upload_key($patient_id,$visit_id,$patient_doc_link_expiry){
		$expiry_time = date("Y-m-d H:i:s",strtotime('+'.$patient_doc_link_expiry. ' hour')); 
		$key = md5($patient_id.$visit_id.$expiry_time); 
		$data=array(
	        'patient_id'=>$patient_id,
			'visit_id'=>$visit_id,
			'expires_at'=>$expiry_time,
			'key_md5'=> $key
		);
		$this->db->replace('patient_document_upload_key',$data);
		return $key;
	}
	
	// Added function to get auto_ip_number value for a given patient's hospital - 194214
	
	function get_auto_ip($hospital_id){
		//echo("<script>console.log('inside get_auto_ip: " . $hospital_id . "');</script>");
		$this->db->select("hospital.auto_ip_number")->from("hospital");
		$this->db->where("hospital_id", $hospital_id);
		$query=$this->db->get();
		
		if ($query->num_rows() > 0)
		{
   			foreach ($query->result() as $row)
   			{
      			return $row->auto_ip_number;
      
   			}
		}

	}

	//function ends
	
	// Added function to get check if there is an ip counter and if not, create a new one for a given hospital - 194214
	function create_ip_counter($hospital_id){
		$this->db->select('counter.counter_id')->from('counter')->where('counter_name','IP')->where('hospital_id',$hospital_id);

		$query=$this->db->get();
		$result=$query->row();
		$c = $result->counter_id+1;

		if(isset($result->counter_id) )
			return 0;

		else
		{
			$data = array(
				'counter_name'=> 'IP',
				'count'=>0,
				'hospital_id'=> $hospital_id,
				'counter_id'=> $c

			);
			$this->db->insert('counter',$data);
			return 1;
		}

	}
	//function ends
	
	// function to assign new unique ip number to the patient and then updating it in the controller - 194214

	function assignIP($patient_id, $hospital_id){

		$this->db->select("counter.count")->from("counter");
		$this->db->where("hospital_id", $hospital_id);
		$this->db->where("counter_name", "IP");
		$query=$this->db->get();

		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $row)
   			{
   				$t = $row->count;
      			$n = $row->count;
      
   			}

		}
		echo("<script>console.log('ip num after retreiving from db t " . $t . "');</script>");
		echo("<script>console.log('ip num after retreiving from db n " . $n . "');</script>");

		$this->db->select("patient_visit.hosp_file_no")->from("patient_visit");
		$this->db->where("hospital_id", $hospital_id);
		$this->db->where("visit_type", "IP");

		$query=$this->db->get();
		
		if ($query->num_rows() > 0)
		{
			//$res = 0;
			foreach ($query->result() as $row)
   			{
   				
      			if ($n == $row->hosp_file_no){
      				$n++;
      				echo("<script>console.log('comparing $n with : " . $row->hosp_file_no . "');</script>");
      				//$n = $row->hosp_file_no;
      				
      			}

      
   			}
   			//if($res > 0)
   				//$n++;
   			
		}

		echo("<script>console.log('ip num after if: " . $n . "');</script>");

		$data = array(
    		'count' => $n,
    		'counter_name' => 'IP'
			
		);

		$this->db->where('counter_name', 'IP');
		$this->db->where('hospital_id', $hospital_id);
		$this->db->update('counter', $data); // updating the db with new count value

		return $n;
	}

	// function ends

	
	function select_patient_from_id($c){

		$this->db->select("patient.*")->from("patient");
		$this->db->where("patient_id", $c);
		$resource=$this->db->get();
		return $resource->row();
	}
	

	
	function insert_update_summary_link($summary_link_patient_id,$summary_link_patient_visit_id,$summary_link_contents){
		$base64_encode_summary_link_contents = base64_encode($summary_link_contents);
		$summary_link_contents_md5 = base64_encode(md5($base64_encode_summary_link_contents,True));
		$summary_link_contents_md5 = str_replace("+","sai",$summary_link_contents_md5);
		$data=array(
	        'summary_link_patient_id'=>$summary_link_patient_id,
			'summary_link_patient_visit_id'=>$summary_link_patient_visit_id,
			'summary_link_contents'=>$base64_encode_summary_link_contents,
			'summary_link_contents_md5'=> $summary_link_contents_md5
		);
		$this->db->replace('patient_consultation_summary',$data);
		return $summary_link_contents_md5;
	}
	
	function get_patient_visit_details($summary_link_patient_id,$summary_link_patient_visit_id){
		$this->db->select("p.patient_id, p.address, hosp_file_no, pv.visit_id, CONCAT(IF(p.first_name=NULL,'',p.first_name),' ',IF(p.last_name=NULL,'',p.last_name)) name, CONCAT(doctor.first_name, ' ', doctor.last_name) as doctor, pv.department_id,department.department,pv.hosp_file_no,
		CONCAT(volunteer.first_name, ' ', volunteer.last_name) as volunteer, pv.appointment_with as appointment_with_id,
		IF(pv.signed_consultation=0, CONCAT(appointment_with.first_name, ' ', appointment_with.last_name), '') as appointment_with,hospital.hospital_short_name	,helpline.helpline,
		pv.appointment_time as appointment_date_time,
		pv.admit_date as admit_date,pv.admit_time as admit_time,
		pv.signed_consultation as signed,hospital.map_link as map_link,visit_name.visit_name as visit_name",false);
		 $this->db->from('patient_visit as pv')
		 ->join('patient as p','pv.patient_id=p.patient_id')
		 ->join('department','pv.department_id=department.department_id','left')
		 ->join('unit','pv.unit=unit.unit_id','left')
		 ->join('visit_name','pv.visit_name_id=visit_name.visit_name_id','left')
		 ->join('area','pv.area=area.area_id','left')
		 ->join('hospital','pv.hospital_id=hospital.hospital_id','left')
		 ->join('helpline','hospital.helpline_id=helpline.helpline_id','left')
		 ->join('staff as doctor','pv.signed_consultation=doctor.staff_id','left')
		 ->join('staff as appointment_with','pv.appointment_with=appointment_with.staff_id','left')
		 ->join('staff as appointment_update_by','pv.appointment_update_by=appointment_update_by.staff_id','left')	 
		 ->join('user as volunteer_user','p.insert_by_user_id = volunteer_user.user_id','left')
		 ->join('staff as volunteer','volunteer_user.staff_id=volunteer.staff_id','left')
		 ->where('visit_type','OP');
		$this->db->where('p.patient_id', $summary_link_patient_id);	
		$this->db->where('pv.visit_id', $summary_link_patient_visit_id);			
		$resource=$this->db->get();
		return $resource->result();
	}
	//register() function does the patient registration or updating the existing patient records.
	function register(){
		//All the post variables are stored in local variables; 
		//based on the field type we modify the data as required before storing in the variables.
		$date=date("Y-m-d",strtotime($this->input->post('date')));
		$time=date_format(date_create_from_format('h:ia', $this->input->post('time')),'H:i:s');
		if($this->input->post('first_name')) $first_name=$this->input->post('first_name'); else $first_name="";
		if($this->input->post('last_name')) $last_name=$this->input->post('last_name'); else $last_name="";
		$age_years=$this->input->post('age_years');
		$age_months=$this->input->post('age_months');
		$age_days=$this->input->post('age_days');
		$gender=$this->input->post('gender');
                $userdata = $this->session->userdata('logged_in');
                $user_id = $userdata['user_id'];
		if($this->input->post('dob'))$dob=date("Y-m-d",strtotime($this->input->post('dob'))); else $dob=0;
		if($this->input->post('spouse_name'))$spouse_name=$this->input->post('spouse_name'); else $spouse_name="";
		if($this->input->post('father_name'))$father_name=$this->input->post('father_name'); else $father_name="";
		if($this->input->post('mother_name'))$mother_name=$this->input->post('mother_name'); else $mother_name="";
		if($this->input->post('id_proof_type'))$id_proof_type=$this->input->post('id_proof_type'); else $id_proof_type="";
		if($this->input->post('id_proof_no'))$id_proof_no=$this->input->post('id_proof_no'); else $id_proof_no="";
		if($this->input->post('occupation'))$occupation=$this->input->post('occupation'); else $occupation=0;
		if($this->input->post('referral_by_hospital_id'))$referral_by_hospital_id=$this->input->post('referral_by_hospital_id'); else $referral_by_hospital_id=0;
		if($this->input->post('education_level'))$education_level=$this->input->post('education_level'); else $education_level="";
		if($this->input->post('education_qualification'))$education_qualification=$this->input->post('education_qualification'); else $education_qualification="";
		if($this->input->post('blood_group'))$blood_group=$this->input->post('blood_group'); else $blood_group="";
		if($this->input->post('gestation'))$gestation=$this->input->post('gestation'); else $gestation="";
		if($this->input->post('gestation_type'))$gestation_type=$this->input->post('gestation_type'); else $gestation_type=""; 
		if($this->input->post('delivery_mode'))$delivery_mode=$this->input->post('delivery_mode'); else $delivery_mode="";
		if($this->input->post('delivery_place'))$delivery_place=$this->input->post('delivery_place'); else $delivery_place="";
		if($this->input->post('delivery_location'))$delivery_location=$this->input->post('delivery_location'); else $delivery_location="";
		if($this->input->post('hospital_type'))$hospital_type=$this->input->post('hospital_type'); else $hospital_type="";
		if($this->input->post('delivery_location_type'))$delivery_location_type=$this->input->post('delivery_location_type'); else $delivery_location_type="";
		if($this->input->post('delivery_plan'))$delivery_plan=$this->input->post('delivery_plan'); else $delivery_plan="";
		if($this->input->post('birth_weight'))$birth_weight=$this->input->post('birth_weight'); else $birth_weight="";
		if($this->input->post('congenial_anamalies'))$congenial_anamalies=$this->input->post('congenial_anamalies'); else $congenial_anamalies="";
		if($this->input->post('address')) $address=$this->input->post('address'); else $address="";
		if($this->input->post('place')) $place=$this->input->post('place'); else $place="";
                if($this->input->post('doctor_Id')) $doctor_id=$this->input->post('doctor_id'); else $doctor_id="";
		if($this->input->post('nurse')) $nurse=$this->input->post('nurse'); else $nurse="";
		if($this->input->post('insurance_case')) $insurance_case=$this->input->post('insurance_case'); else $insurance_case="";
		if($this->input->post('insurance_no')) $insurance_no=$this->input->post('insurance_no'); else $insurance_no="";
                if($this->input->post('insurance_id')) $insurance_id=$this->input->post('insurance_id'); else $insurance_id="";
		if($this->input->post('sbp')) $sbp=$this->input->post('sbp'); else $sbp="";
		if($this->input->post('dbp')) $dbp=$this->input->post('dbp'); else $dbp="";
		if($this->input->post('pulse_rate')) $pulse_rate=$this->input->post('pulse_rate'); else $pulse_rate="";
		if($this->input->post('respiratory_rate')) $respiratory_rate=$this->input->post('respiratory_rate'); else $respiratory_rate="";
		if($this->input->post('temperature')) $temperature=$this->input->post('temperature'); else $temperature="";
		if($this->input->post('spo2')) $spo2=$this->input->post('spo2'); else $spo2="";
		if($this->input->post('admit_weight')) $admit_weight=$this->input->post('admit_weight'); else $admit_weight="";
		if($this->input->post('discharge_weight')) $discharge_weight=$this->input->post('discharge_weight'); else $discharge_weight="";
		$phone=$this->input->post('phone');
		$alt_phone=$this->input->post('alt_phone');
		$country_code=$this->input->post('country');
		$state_code=$this->input->post('state');
		$district=$this->input->post('district');
		$department=$this->input->post('department');
		$unit=$this->input->post('unit');
		$area=$this->input->post('area');
		if($this->input->post('presenting_complaints')) $presenting_complaints=$this->input->post('presenting_complaints'); else $presenting_complaints="";
		if($this->input->post('provisional_diagnosis')) $provisional_diagnosis=$this->input->post('provisional_diagnosis'); else $provisional_diagnosis="";
        if($this->input->post('past_history')) $past_history=$this->input->post('past_history'); else $past_history="";
		
		$hospital=$this->session->userdata('hospital');
		$hospital_id=$hospital['hospital_id'];
		$form_type=$this->input->post('form_type');
                $mlc = $this->input->post('mlc');
		if(($this->input->post('mlc')=='1' || $this->input->post('mlc')=='0')) $mlc= $this->input->post('mlc'); else $mlc=-1;
		//check if it is an mlc case
		if($this->input->post('mlc')==1){
			//if a manual mlc number has been entered, use it and ignore the auto counter		
			$mlc_number_manual=$this->input->post('mlc_number_manual');
			$this->db->select('count')->from('counter')->where('counter_name','MLC')->where('hospital_id',$hospital['hospital_id']);
			$query = $this->db->get();
			$result = $query->row();
			$mlc_number = ++$result->count;
			$this->db->where('counter_name','MLC')->where('hospital_id',$hospital['hospital_id']);
			$this->db->update('counter',array('count'=>$mlc_number));

			$ps_name=$this->input->post('ps_name');
			$pc_number=$this->input->post('pc_number');
			$brought_by=$this->input->post('brought_by');
			$police_intimation=$this->input->post('police_intimation');
			$declaration_required=$this->input->post('declaration_required');
		}
		else {
                    $mlc_number = "";
                    $mlc_number_manual = "";
		}
		$identification_marks=$this->input->post('identification_marks');
		$outcome=$this->input->post('outcome');
		if($this->input->post('outcome_date')) $outcome_date=date("Y-m-d",strtotime($this->input->post('outcome_date'))); else $outcome_date = 0;
		if($this->input->post('outcome_time')) $outcome_time=date("h:i:s",strtotime($this->input->post('outcome_time'))); else $outcome_time = 0;
		if($this->input->post('final_diagnosis')) $final_diagnosis=$this->input->post('final_diagnosis'); else $final_diagnosis="";
		if($this->input->post('congenital_anomalies')) $congenital_anomalies=$this->input->post('congenital_anomalies'); else $congenital_anomalies="";
		if($this->input->post('visit_name')) $visit_name_id=$this->input->post('visit_name'); else $visit_name_id=0;
		if($form_type=="IP"){
			$hosp_file_no=$this->input->post('hosp_file_no');                        
			if(!$this->input->post('visit_id') && !$this->input->post('auto_increment')){
			//If it's an IP form, get the hospital file number from the input field.
			$this->db->select('hosp_file_no,admit_date'); //Here we are selecting hosp_file_no and admit_date with year for match  from the database
			$this->db->from('patient_visit');
			$this->db->where('hosp_file_no',$hosp_file_no);
			$this->db->where('YEAR(admit_date)',date("Y",strtotime($date)));
			$this->db->where('visit_type',$form_type);
			$this->db->where('hospital_id',$hospital_id);
			$query=$this->db->get();
			if($query->num_rows()>0)
			{
				//If the given IP no is matched in same year then this function returns 2;
				return 2; 
			}	
			}
		}
		else{
			//else, select the counter from the database to check the last OP number, increment it and 
			//use it as the hospital file number for out patients.
			$this->db->select('count')->from('counter')->where('counter_name',$form_type)->where('hospital_id',$hospital['hospital_id']);
			$query=$this->db->get();
			$result=$query->row();
			$hosp_file_no=++$result->count;
		}
		//Creating an array with the database column names as keys and the post values as values. 
		$data=array(
	        'first_name'=>$first_name,
			'last_name'=>$last_name,
			'age_years'=>$age_years,
			'age_months'=>$age_months,
			'age_days'=>$age_days,
			'gender'=>$gender,
			'spouse_name'=>$spouse_name,
			'father_name'=>$father_name,
			'mother_name'=>$mother_name,
			'id_proof_type_id'=>$id_proof_type,
			'id_proof_number'=>$id_proof_no,
			'occupation_id'=>$occupation,
			'education_level'=>$education_level,
			'education_qualification'=>$education_qualification,
			'blood_group'=>$blood_group,
			'gestation'=>$gestation, 
			'gestation_type'=>$gestation_type,
			'hospital_type'=>$hospital_type,
			'delivery_location_type'=>$delivery_location_type,
			'delivery_mode'=>$delivery_mode,
			'delivery_place'=>$delivery_place,
			'delivery_plan'=>$delivery_plan,
			'delivery_location'=>$delivery_location,
			'congenital_anomalies'=>$congenital_anomalies,
			'birth_weight'=>$birth_weight,
			'dob'=>$dob,
			'address'=>$address,
			'place'=>$place,
			'phone'=>$phone,
			'alt_phone'=>$alt_phone,
			'country_code'=>$country_code,
			'state_code'=>$state_code,
			'district_id'=>$district,
			'identification_marks'=>$identification_marks,

			'insert_by_user_id'=>$user_id,
			'insert_datetime'=>date("Y-m-d H:i:s")
		);		
        	if($form_type != "IP"){
			if($this->input->post('patient_id_manual')) $patient_id_manual=$this->input->post('patient_id_manual'); else $patient_id_manual="";
			$data['patient_id_manual'] = $patient_id_manual;
		}
                if(!$this->input->post('patient_id') && $this->input->post('patient_id_manual')){
                    $patient_id_manual = $this->input->post('patient_id_manual');
                    $this->db->select('patient_id_manual'); //Here we are selecting hosp_file_no and admit_date with year for match  from the database
                    $this->db->from('patient');
                    $this->db->where('patient_id_manual',$patient_id_manual);                    
                    $query=$this->db->get();
                    if($query->num_rows()>0)
                    {
                        //If there is a dupilcate patient ID.
                        return 2; 
                    }
                    
                    $data['patient_id_manual'] = $patient_id_manual;
                }
                
		//Start a mysql transaction.
		$this->db->trans_start();

		if($this->input->post('patient_id')){
			//if the patient id is received in the post variables, use it to update the particular patient.
			unset($data['insert_datetime']);
			$patient_id=$this->input->post('patient_id');
			$this->db->where('patient_id',$patient_id);
			$this->db->update('patient',$data);
		}
		else{
			// else if it's a new patient, insert into the patient table using the data array.
			$this->db->insert('patient',$data);
			//get the patient id from the inserted row.
			$patient_id=$this->db->insert_id();
		}
		if($this->input->post('patient_picture')){
			$encoded_data = $this->input->post('patient_picture');
			$binary_data = base64_decode( $encoded_data );

			// save to server (beware of permissions)
			$result = file_put_contents("assets/images/patients/$patient_id.jpg", $binary_data );
			if (!$result) die("Could not save image!  Check file permissions.");
		}
		//Creating an array with the database column names as keys and the post values as values. 
		$visit_data=array( 
		    'hospital_id'=>$hospital_id,
			'department_id'=>$department,
			'insurance_case'=>$insurance_case,
			'insurance_no'=>$insurance_no,
                        'insurance_id'=>$insurance_id,
			'sbp'=>$sbp,
			'dbp'=>$dbp,
			'pulse_rate'=>$pulse_rate,
			'respiratory_rate'=>$respiratory_rate,
			'temperature'=>$temperature,
			'spo2'=>$spo2,
			'admit_weight'=>$admit_weight,
			'discharge_weight'=>$discharge_weight,
			'visit_type'=>$form_type,
			'visit_name_id'=>$visit_name_id,
			'patient_id'=>$patient_id,
			'hosp_file_no'=>$hosp_file_no,
			'unit'=>$unit,
			'area'=>$area,
			'provisional_diagnosis'=>$provisional_diagnosis,
			'presenting_complaints'=>$presenting_complaints,
			'past_history'=>$past_history,
			'admit_date'=>$date,
			'admit_time'=>$time,
			'mlc'=>$mlc,
			'outcome'=>$outcome,
			'outcome_date'=>$outcome_date,
			'outcome_time'=>$outcome_time,
			'final_diagnosis'=>$final_diagnosis,
                        'insert_by_user_id'=>$user_id,
                        'referral_by_hospital_id'=>$referral_by_hospital_id,
                        'insert_datetime'=>date("Y-m-d H:i:s")
		);
		if($this->input->post('visit_id')){
			//if it's an update form, use the visit id from the post variables and update the record in the patient_visit table
			$visit_id=$this->input->post('visit_id');
			$this->db->where('visit_id',$visit_id);
			$this->db->update('patient_visit',$visit_data);
		}
		else{
			//else use the visit_data array and insert a new record into the patient visit table.
		$this->db->insert('patient_visit',$visit_data,false);
		$visit_id=$this->db->insert_id(); //store the visit_id from the inserted record
		}
		if($mlc==1 || $this->input->post('visit_id')){
			// if the mlc field is selected as "Yes"
			if($this->input->post('visit_id')){
				//if it's an update form, use the visit id to update the mlc record in the databse - mlc table.
			$this->db->where('visit_id',$visit_id);
			if($mlc==1)
			$this->db->update('mlc',array('mlc_number'=>$mlc_number,'ps_name'=>$ps_name));
			}
			else{
				//if it's a new entry, store the mlc data from the post variables.
			$mlc_data=array(
				'visit_id'=>$visit_id,
				'mlc_number'=>"A".$mlc_number,
				'mlc_number_manual'=>$mlc_number_manual,
				'ps_name'=>$ps_name,
				'pc_number'=>$pc_number,
				'brought_by'=>$brought_by,
				'police_intimation'=>$police_intimation,
				'declaration_required'=>$declaration_required
			);
			//insert into the mlc table.
			$this->db->insert('mlc',$mlc_data);
			}
		}
		//update the admit id, setting it equal to the visit id, only changes for transfer cases.
		$this->db->where('visit_id',$visit_id);
		$this->db->update('patient_visit',array('admit_id'=>$visit_id));
		//update the counter table with the new hospital file number.
		$this->db->where('counter_name',$form_type)->where('hospital_id',$hospital['hospital_id']);
                if($this->input->post('auto_increment') && !$this->input->post('visit_id')){
                    $hosp_file_no++;
                    $this->db->update('counter',array('count'=>$hosp_file_no));        
                }else{
                    $this->db->update('counter',array('count'=>$hosp_file_no));
                }
		
		
		//Transaction ends here.
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		}
		else {
		//Select the inserted or updated patient record with the visit_id 
		$this->db->select('patient.*,patient_visit.*,
		patient.patient_id,patient_visit.visit_id visit_id1,
		CONCAT(IF(patient.first_name=NULL,"",patient.first_name)," ",IF(patient.last_name=NULL,"",patient.last_name)) name,
		IF(father_name=NULL OR father_name="",spouse_name,father_name) parent_spouse,visit_name,visit_name.visit_name_id,
		department,unit_name,unit.unit_head_staff_id,id_proof_type,patient.address,
		CONCAT(staff.first_name," ",staff.last_name) as unit_head_name ,area_name,district,op_room_no,mlc.*,occupation',false)
		->from('patient')->join('patient_visit','patient.patient_id=patient_visit.patient_id')
		->join('department','patient_visit.department_id=department.department_id','left')
		->join('unit','patient_visit.unit=unit.unit_id','left')
		->join('staff','unit.unit_head_staff_id=staff.staff_id','left')
		->join('area','patient_visit.area=area.area_id','left')
		->join('district','patient.district_id=district.district_id','left')
		->join('mlc','patient_visit.visit_id=mlc.visit_id','left')
		->join('visit_name','patient_visit.visit_name_id=visit_name.visit_name_id','left')
		->join('occupation','patient.occupation_id=occupation.occupation_id','left')
		->join('id_proof_type','patient.id_proof_type_id=id_proof_type.id_proof_type_id','left')
		->where('patient_visit.visit_id',$visit_id);
		$resource=$this->db->get();
		//return the result array to the controller
		return $resource->row();
		}
	}

	function update(){
		$visit_data = array();
		$patient_data = array();
		$mlc_data = array();
		$user_data=$this->session->userdata('logged_in');
		foreach($this->patient_visit as $column){
			if($this->input->post($column)){
				$visit_data[$column] = $this->input->post($column);
				$visit_data['update_datetime']=date("Y-m-d H:i:s");
				$visit_data['update_by_user_id']=$user_data['staff_id'];
			}
		}
		if($this->input->post('icd_code')){
			$visit_data['icd_10'] = $this->input->post('icd_code');
		}			
		$signed_consultation = $this->input->post('signed_consultation');
		if($signed_consultation==1){
			$staff_id = $this->session->userdata('logged_in')['user_id'];//all_userdata();
			$this->db->select('user.staff_id')
				->from('user')
				->where('user.user_id', $staff_id);
			$query = $this->db->get();
			$result = $query->row();
			if(!!$result) {
				$visit_data['signed_consultation'] = $result->staff_id;
			}
		}
		foreach($this->patient as $column){
			if($this->input->post($column)){
				$patient_data[$column] = $this->input->post($column);
			}
		}		
		$mlc_duplicate = '';
		foreach($this->mlc as $column){
			if($this->input->post($column)){
				$mlc_data[$column] = $this->input->post($column);
				if($column == 'visit_id')
					continue;
				$mlc_duplicate .= "$column".'='."'$mlc_data[$column]'".', ';
			}
		}
		$mlc_str = rtrim($mlc_duplicate,", ");
		if(!!$this->input->post('clinical_note')) {			
			$clinical_note = $this->input->post('clinical_note');
			$note_date = $this->input->post('note_date');
			$clinical_data = array();
			for($i=0;$i<count($clinical_note);$i++){
				if(!!$note_date[$i] && !!$clinical_note[$i])
				// if(!!$note_date[$i]) { $note_date[$i]=date("Y-m-d H:i:s",strtotime($note_date[$i]));}
				// else $note_date[$i] = 0;
				// if($note_date[$i]!=0 && !!$clinical_note[$i])
				{
					$note_date[$i]=date("Y-m-d H:i:s",strtotime($note_date[$i]));
					$clinical_data[]=array(
						'clinical_note' => $clinical_note[$i],
						'note_time' => $note_date[$i],
						'visit_id' => $this->input->post('visit_id')
					);
				}
			}
		}
		if($this->input->post('prescription')){
			$prescription = $this->input->post('prescription');
			$prescription_data = array();
			foreach($prescription as $pre) {
				if($this->input->post('drug_'.$pre)){
					$duration=$this->input->post('duration_'.$pre);
					$frequency=$this->input->post('frequency_'.$pre);
					$bb=$this->input->post('bb_'.$pre);
					$ab=$this->input->post('ab_'.$pre);
					$bl=$this->input->post('bl_'.$pre);
					$al=$this->input->post('al_'.$pre);
					$bd=$this->input->post('bd_'.$pre);
					$ad=$this->input->post('ad_'.$pre);
					$note = $this->input->post('note_'.$pre);
					$quantity=$this->input->post('quantity_'.$pre);
					$drug = $this->input->post('drug_'.$pre);
					$morning=0;$afternoon=0;$evening=0;
					if(!!$bb && !!$ab) 
						$morning = 3;
					else if(!!$bb) 
						$morning = 1;
					else if(!!$ab) 
						$morning = 2;
					if(!!$bl && !!$al) 
						$afternoon = 3;
					else if(!!$bl) 
						$afternoon = 1;
					else if(!!$al) 
						$afternoon = 2;
					if(!!$bd && !!$ad) 
						$evening = 3;
					else if(!!$bd) 
						$evening = 1;
					else if(!!$ad) 
						$evening = 2;
					$prescription_data[] = array(
						'visit_id'=>$this->input->post('visit_id'),
						'item_id'=>$drug,
						'duration'=>empty($duration) ? NULL : $duration,
						'frequency'=>$frequency,
						'morning'=>$morning,
						'afternoon'=>$afternoon,
						'evening'=>$evening,
						'quantity'=>$quantity,
						'note'=>$note
					);
				}
			}
		}
		
		if($this->input->post('counseling_text_id')!='')
		{
			$this->db->select("sequence_id");
			$this->db->from("counseling");
			$this->db->where("visit_id",$this->input->post('visit_id'));
			$this->db->order_by("counseling_id",'DESC');
			$query = $this->db->get();
			$result = $query->row();
			if($result->sequence_id=='')
			{
				$seq=1;
			}else{
				$seq=$result->sequence_id+1;
			}
			$counseling_text_id = array();
			$counseling_text_id[] = array(
				'visit_id'=>$this->input->post('visit_id'),
				'counseling_text_id'=> $this->input->post('counseling_text_id'),
				'sequence_id'=> $seq,
				'created_by'=> $this->input->post('created_by'),
				'created_date_time'=> $this->input->post('created_date_time')
			);
			$this->db->insert_batch('counseling',$counseling_text_id);
		}
		
		
		$outcome = $this->input->post('outcome');              
		if(!!$outcome) {
			if(!!$this->input->post('outcome_date') != 0) 
				$visit_data['outcome_date'] = date("Y-m-d",strtotime($this->input->post('outcome_date'))); 
			else 
				$visit_data['outcome_date'] = 0;
			if(!!$this->input->post('outcome_time'))
				$visit_data['outcome_time'] = date("H:i:s",strtotime($this->input->post('outcome_time'))); 
			else 
				$visit_data['outcome_time'] = 0;
		}

		if(!$this->input->post('visit_id')){
			return false;
		}
		$visit_id = $this->input->post('visit_id');
		$this->db->trans_start();
		// Patient details
		if($this->input->post('patient_id') && sizeof($patient_data) > 0){
			$patient_id = $this->input->post('patient_id');
			$this->db->where('patient_id', $patient_id);
			$this->db->update('patient', $patient_data);
		}
		// MLC Details
		if($mlc_str != '' && sizeof($mlc_data) > 0){
			$mlc_insert = $this->db->insert_string('mlc', $mlc_data).' ON DUPLICATE KEY UPDATE '.$mlc_str;
			$this->db->query($mlc_insert);
		}
		if(sizeof($visit_data) > 0){
			$this->db->where('visit_id',$visit_id);
			$this->db->update('patient_visit', $visit_data);
		}		
		// Clinical Data
		if(sizeof($clinical_data) > 0)
			$this->db->insert_batch('patient_clinical_notes',$clinical_data);
		// Prescription Data
		if(sizeof($prescription_data) > 0)
			$this->db->insert_batch('prescription',$prescription_data);
		//Transaction ends here.
		$this->db->trans_complete();
			if($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
			return false;
		}
		else {
			return true;
		}
	}
	

	//update() function for updating the existing patient records.
	function update_old(){		
		$userdata = $this->session->userdata('logged_in');
		$user_id = $userdata['user_id'];
		//// All the post variables are stored in local variables; 
		// based on the field type we modify the data as required before storing in the variables.
		if($this->input->post('patient_id_manual')) $patient_id_manual=$this->input->post('patient_id_manual'); else $patient_id_manual="";
		if($this->input->post('first_name')) $first_name=$this->input->post('first_name'); else $first_name="";
        if($this->input->post('middle_name')) $middle_name=$this->input->post('middle_name'); else $middle_name="";
		if($this->input->post('last_name')) $last_name=$this->input->post('last_name'); else $last_name="";
		$age_years=$this->input->post('age_years');
		$age_months=$this->input->post('age_months');
		$age_days=$this->input->post('age_days');
		$gender=$this->input->post('gender');
		if($this->input->post('dob'))$dob=date("Y-m-d",strtotime($this->input->post('dob'))); else $dob=0;
		if($this->input->post('spouse_name'))$spouse_name=$this->input->post('spouse_name'); else $spouse_name="";
		if($this->input->post('father_name'))$father_name=$this->input->post('father_name'); else $father_name="";
		if($this->input->post('mother_name'))$mother_name=$this->input->post('mother_name'); else $mother_name="";
		if($this->input->post('id_proof_type'))$id_proof_type=$this->input->post('id_proof_type'); else $id_proof_type="";
		if($this->input->post('id_proof_no'))$id_proof_no=$this->input->post('id_proof_no'); else $id_proof_no="";
		if($this->input->post('occupation'))$occupation=$this->input->post('occupation'); else $occupation=0;
		if($this->input->post('education_level'))$education_level=$this->input->post('education_level'); else $education_level="";
		if($this->input->post('education_qualification'))$education_qualification=$this->input->post('education_qualification'); else $education_qualification="";
        if($this->input->post('identification_marks'))$identification_marks=$this->input->post('identification_marks'); else $identification_marks="";
		if($this->input->post('blood_group'))$blood_group=$this->input->post('blood_group'); else $blood_group="";
		// if($this->input->post('gestation'))$gestation=$this->input->post('gestation'); else $gestation="";
		// if($this->input->post('gestation_type'))$gestation_type=$this->input->post('gestation_type'); else $gestation_type=""; 
		// if($this->input->post('delivery_mode'))$delivery_mode=$this->input->post('delivery_mode'); else $delivery_mode="";
		// if($this->input->post('delivery_place'))$delivery_place=$this->input->post('delivery_place'); else $delivery_place="";
		// if($this->input->post('delivery_location'))$delivery_location=$this->input->post('delivery_location'); else $delivery_location="";
		// if($this->input->post('hospital_type'))$hospital_type=$this->input->post('hospital_type'); else $hospital_type="";
		// if($this->input->post('delivery_location_type'))$delivery_location_type=$this->input->post('delivery_location_type'); else $delivery_location_type="";
		// if($this->input->post('delivery_plan'))$delivery_plan=$this->input->post('delivery_plan'); else $delivery_plan="";
		// if($this->input->post('birth_weight'))$birth_weight=$this->input->post('birth_weight'); else $birth_weight="";
		// if($this->input->post('congenial_anamalies'))$congenial_anamalies=$this->input->post('congenial_anamalies'); else $congenial_anamalies="";
		if($this->input->post('address')) $address=$this->input->post('address'); else $address="";
		if($this->input->post('place')) $place=$this->input->post('place'); else $place="";
	    if($this->input->post('doctor_id')) $doctor_id=$this->input->post('doctor_id'); else $doctor_id="";
		if($this->input->post('nurse')) $nurse=$this->input->post('nurse'); else $nurse="";
        if($this->input->post('visit_name_id')) $visit_name_id=$this->input->post('visit_name_id'); else $visit_name_id="";
		if($this->input->post('insurance_case')) $insurance_case=$this->input->post('insurance_case'); else $insurance_case="";
		if($this->input->post('insurance_no')) $insurance_no=$this->input->post('insurance_no'); else $insurance_no="";
        if($this->input->post('referral_by_hospital_id')) $referral_by_hospital_id=$this->input->post('referral_by_hospital_id'); else $referral_by_hospital_id="";
        if($this->input->post('arrival_mode')) $arrival_mode=$this->input->post('arrival_mode'); else $arrival_mode="";
		if($this->input->post('sbp')) $sbp=$this->input->post('sbp'); else $sbp="";
		if($this->input->post('dbp')) $dbp=$this->input->post('dbp'); else $dbp="";
		if($this->input->post('pulse_rate')) $pulse_rate=$this->input->post('pulse_rate'); else $pulse_rate="";
		if($this->input->post('respiratory_rate')) $respiratory_rate=$this->input->post('respiratory_rate'); else $respiratory_rate="";
		if($this->input->post('temperature')) $temperature=$this->input->post('temperature'); else $temperature="";
		if($this->input->post('spo2')) $spo2=$this->input->post('spo2'); else $spo2="";
		if($this->input->post('admit_weight')) $admit_weight=$this->input->post('admit_weight'); else $admit_weight="";
		if($this->input->post('blood_sugar')) $blood_sugar=$this->input->post('blood_sugar'); else $blood_sugar="";
		if($this->input->post('hb')) $hb=$this->input->post('hb'); else $hb="";
		if($this->input->post('hb1ac')) $hb1ac=$this->input->post('hb1ac'); else $hb1ac="";
		// if($this->input->post('discharge_weight')) $discharge_weight=$this->input->post('discharge_weight'); else $discharge_weight="";
		if($this->input->post('phone')) $phone=$this->input->post('phone'); else $phone="";
		if($this->input->post('alt_phone')) $alt_phone=$this->input->post('alt_phone'); else $alt_phone="";
		$district=$this->input->post('district');
		$department=$this->input->post('department');
		$unit=$this->input->post('unit');
		$area=$this->input->post('area');
		if($this->input->post('presenting_complaints')) $presenting_complaints=$this->input->post('presenting_complaints'); else $presenting_complaints="";
		// if($this->input->post('provisional_diagnosis')) $provisional_diagnosis=$this->input->post('provisional_diagnosis'); else $provisional_diagnosis="";
	    if($this->input->post('past_history')) $past_history=$this->input->post('past_history'); else $past_history="";
	    if($this->input->post('family_history')) $family_history=$this->input->post('family_history'); else $family_history="";
	    if($this->input->post('clinical_findings')) $clinical_findings=$this->input->post('clinical_findings'); else $clinical_findings="";
	    if($this->input->post('cvs')) $cvs=$this->input->post('cvs'); else $cvs="";
	    if($this->input->post('rs')) $rs=$this->input->post('rs'); else $rs="";
	    if($this->input->post('pa')) $pa=$this->input->post('pa'); else $pa="";
		if($this->input->post('cns')) $cns=$this->input->post('cns'); else $cns="";
		if(!!$this->input->post('clinical_note')) {			
			$clinical_note = $this->input->post('clinical_note');
			$note_date = $this->input->post('note_date');
			$clinical_data = array();
			for($i=0;$i<count($clinical_note);$i++){
				if(!!$note_date[$i]) { $note_date[$i]=date("Y-m-d H:i:s",strtotime($note_date[$i]));}
				else $note_date[$i] = 0;
				if($note_date[$i]!=0 && !!$clinical_note[$i])
				{
					$clinical_data[]=array(
						'clinical_note' => $clinical_note[$i],
						'note_time' => $note_date[$i],
						'user_id' => $user_id,
						'visit_id' => $this->input->post('visit_id')
					);
				}
			}
			if(!!$clinical_data)
			$this->db->insert_batch('patient_clinical_notes',$clinical_data);
		}
		if($this->input->post('signed_consultation')) $signed_consultation=$user_id; else $signed_consultation=0;
		$ip_file_received = 0;
		if($this->input->post('ip_file_received')){
			$ip_file_received = date("Y-m-d",strtotime($this->input->post('ip_file_received')));
		}
		$hospital=$this->session->userdata('hospital');
		$hospital_id=$hospital['hospital_id'];
		// $form_type=$this->input->post('form_type');                
		
		$outcome=$this->input->post('outcome');
        if(($this->input->post('mlc_radio')=='1' || $this->input->post('mlc_radio')=='-1')) $mlc_radio= $this->input->post('mlc_radio'); else $mlc_radio=0;                
		if(!!$outcome) {
			if(!!$this->input->post('outcome_date') != 0) $outcome_date=date("Y-m-d",strtotime($this->input->post('outcome_date'))); else $outcome_date = 0;
			if(!!$this->input->post('outcome_date')) $outcome_time=date("H:i:s",strtotime($this->input->post('outcome_date'))); else $outcome_time = 0;
		}
		else { $outcome_date = 0; $outcome_time = 0; }
		if($this->input->post('final_diagnosis')) $final_diagnosis=$this->input->post('final_diagnosis'); else $final_diagnosis="";
		if($this->input->post('decision')) $decision=$this->input->post('decision'); else $decision="";
		if($this->input->post('advise')) $advise=$this->input->post('advise'); else $advise="";
		if($this->input->post('icd_code')) $icd_code=$this->input->post('icd_code'); else $icd_code="";
		if($this->input->post('congenital_anomalies')) $congenital_anomalies=$this->input->post('congenital_anomalies'); else $congenital_anomalies="";

		//Creating an array with the database column names as keys and the post values as values. 
		$data=array(
			'patient_id_manual'=>$patient_id_manual,
			'first_name'=>$first_name,
            		'middle_name'=>$middle_name,
			'last_name'=>$last_name,
			'age_years'=>$age_years,
			'age_months'=>$age_months,
			'age_days'=>$age_days,
                        'dob'=>$dob,
			'gender'=>$gender,
			'spouse_name'=>$spouse_name,
			'father_name'=>$father_name,
			'mother_name'=>$mother_name,
			'id_proof_type_id'=>$id_proof_type,
			'id_proof_number'=>$id_proof_no,
			'occupation_id'=>$occupation,
			'education_level'=>$education_level,
			'education_qualification'=>$education_qualification,
                        'identification_marks'=>$identification_marks,
			'blood_group'=>$blood_group,
			// 'gestation'=>$gestation, 
			// 'gestation_type'=>$gestation_type,
			// 'hospital_type'=>$hospital_type,
			// 'delivery_location_type'=>$delivery_location_type,
			// 'delivery_mode'=>$delivery_mode,
			// 'delivery_place'=>$delivery_place,
			// 'delivery_plan'=>$delivery_plan,
			// 'delivery_location'=>$delivery_location,
			// 'congenital_anomalies'=>$congenital_anomalies,
			// 'birth_weight'=>$birth_weight,
			// 'dob'=>$dob,
			'address'=>$address,
			'place'=>$place,
			'phone'=>$phone,
                        'alt_phone'=>$alt_phone,
			'district_id'=>$district,
                        
		);
		  

                if($this->input->post('patient_id_manual')){
                    $patient_id_manual = $this->input->post('patient_id_manual');
                    $this->db->select('patient_id_manual'); //Here we are selecting hosp_file_no and admit_date with year for match  from the database
                    $this->db->from('patient');
                    $this->db->where('patient_id_manual',$patient_id_manual);                    
                    $query=$this->db->get();
                    if($query->num_rows()>0)
                    {
                        //If there is a dupilcate patient ID.
                        return 2; 
                    }
                    
                    $data['patient_id_manual'] = $patient_id_manual;
                }
                
		//Start a mysql transaction.
		$this->db->trans_start();

		if($this->input->post('patient_id')){
			//if the patient id is received in the post variables, use it to update the particular patient.
			$patient_id=$this->input->post('patient_id');
			$this->db->where('patient_id',$patient_id);
			$this->db->update('patient',$data);
		}
		// Update photograph
                if($this->input->post('patient_picture')){
			$encoded_data = $this->input->post('patient_picture');
			$binary_data = base64_decode( $encoded_data );

			// save to server (beware of permissions)
			$result = file_put_contents("assets/images/patients/$patient_id.jpg", $binary_data );
			if (!$result) die("Could not save image!  Check file permissions.");
		}
		//Creating an array with the database column names as keys and the post values as values. 
		$visit_data=array( 
		    'hospital_id'=>$hospital_id,
			'department_id'=>$department,
			 'insurance_case'=>$insurance_case,
			 'insurance_no'=>$insurance_no,
			'sbp'=>$sbp,
			'dbp'=>$dbp,
			'pulse_rate'=>$pulse_rate,
			'respiratory_rate'=>$respiratory_rate,
			'temperature'=>$temperature,
			'spo2'=>$spo2,
			'admit_weight'=>$admit_weight,
			'blood_sugar'=>$blood_sugar,
			'hb'=>$hb,
			'hb1ac'=>$hb1ac,
			// 'discharge_weight'=>$discharge_weight,
			// 'visit_type'=>$form_type,
			// 'patient_id'=>$patient_id,
			// 'hosp_file_no'=>$hosp_file_no,
			'unit'=>$unit,
			'area'=>$area,
			// 'provisional_diagnosis'=>$provisional_diagnosis,
			'presenting_complaints'=>$presenting_complaints,
			'past_history'=>$past_history,
			'family_history'=>$family_history,
			'clinical_findings'=>$clinical_findings,
			'cvs'=>$cvs,
			'rs'=>$rs,
			'pa'=>$pa,
			'cns'=>$cns,
			'signed_consultation'=>$signed_consultation,
			// 'admit_date'=>$date,
			// 'admit_time'=>$time,
			'mlc'=>$mlc_radio,
			'visit_name_id'=>$visit_name_id,
			'insurance_case'=>$insurance_case,
			'insurance_no'=>$insurance_no,
			'referral_by_hospital_id'=>$referral_by_hospital_id,
			'arrival_mode' => $arrival_mode,
			'outcome'=>$outcome,
			'outcome_date'=>$outcome_date,
			'outcome_time'=>$outcome_time,
			'final_diagnosis'=>$final_diagnosis,
			'decision'=>$decision,
			'advise'=>$advise,
			'icd_10'=>$icd_code,
			 'ip_file_received' => $ip_file_received,
			 'update_by_user_id' => $user_id,
			 'update_datetime' => date("Y-m-d H:i:s")
		);
                $visit_id = '';
		if($this->input->post('visit_id')){
			//if it's an update form, use the visit id from the post variables and update the record in the patient_visit table
			$visit_id=$this->input->post('visit_id');
			$this->db->where('visit_id',$visit_id);
			$this->db->update('patient_visit',$visit_data);
			if($this->input->post('transfer_department'))
				$transfer_department_id=$this->input->post('transfer_department'); 
			else 
				$transfer_department_id="";
				if($this->input->post('transfer_area'))$transfer_area_id=$this->input->post('transfer_area'); else $transfer_area_id="";
				if($this->input->post('transfer_date')) $transfer_date=date("Y-m-d",strtotime($this->input->post('transfer_date'))); else $transfer_date=0;
				if($this->input->post('transfer_date'))$transfer_time=date("H:i:s",strtotime($this->input->post('transfer_date'))); else $transfer_time="";
				if((!empty($transfer_department_id)||!empty($transfer_area_id)) && $this->input->post('transfer_date')){
					$this->db->select('department_id,area_id,transfer_date,transfer_time')->from('internal_transfer')->where('visit_id',$visit_id)->order_by('transfer_id','desc')->limit(1);
					$query = $this->db->get();
					$result = $query->row();
					if(!!$result) {
						$from_department = $result->department_id;
						$from_area = $result->area_id;
						$from_time = $result->transfer_time;
						$from_date = $result->transfer_date;
					}
					else{	
						$from_department = $department;
						$from_area = $area;
						$this->db->select('admit_date,admit_time')->from('patient_visit')->where('visit_id',$visit_id);
						$query = $this->db->get();
						$result=$query->row();
						$from_date = $result->admit_date;
						$from_time = $result->admit_time;
					}
					$from = strtotime("$from_date $from_time");
					$to = strtotime("$transfer_date $transfer_time");
					$duration = ($to - $from)/60; 
					$transfer_info = array(
						'visit_id'=>$visit_id,
						'department_id'=>$transfer_department_id,
						'area_id'=>$transfer_area_id,
						'transfer_date'=>$transfer_date,
						'transfer_time'=>$transfer_time,
						'department_id'=>$from_department,
						'area_id'=>$from_area,
						'user_id'=>$user_id,
						'transfer_time'=>$duration
					);
					$this->db->insert('internal_transfer',$transfer_info);
				}
				
		}
                //check if it is an mlc case, i.e mlc is being updated.
                //if mlc_number value is 'unset', it means mlc has not be added while creating patient_visit, we need to add now.
                //if mlc_number has a value then it means the exisiting record needs to be updated with whatever values have been set.
                $mlc_number_manual='';
                $mlc_number = "";
                $ps_name = "";
                $pc_number= "";
                $brought_by = "";
                $police_intimation = "";
                $declaration_required= "";
                
		if($this->input->post('mlc_radio')=='1'){
                    $this->db->select('count')->from('counter')->where('counter_name','MLC');
                    $query = $this->db->get();
                    $result = $query->row();
                    $mlc_number = ++$result->count;
                    $this->db->where('counter_name','MLC')->where('hospital_id',$hospital['hospital_id']);
                    $this->db->update('counter',array('count'=>$mlc_number));
                    $mlc_number_manual=$this->input->post('mlc_number_manual');
                    $ps_name=$this->input->post('ps_name');
                    $pc_number=$this->input->post('pc_number');
                    $brought_by=$this->input->post('brought_by');
                    $police_intimation=$this->input->post('police_intimation');
                    $declaration_required=$this->input->post('declaration_required');
		}
		else {
                    $mlc_number = "";
                    $mlc_number_manual = "";
		}
                $mlc_data=array(
                    'visit_id'=>$visit_id,
                    'mlc_number'=>"A".$mlc_number,
                    'mlc_number_manual'=>$mlc_number_manual,
                    'ps_name'=>$ps_name,
                    'pc_number'=>$pc_number,
                    'brought_by'=>$brought_by,
                    'police_intimation'=>$police_intimation,
                    'declaration_required'=>$declaration_required
                );
              
                if($this->input->post('mlc_radio')=='1'){
                    // if the mlc field is selected as "Yes", and mlc_number is not set.
                    if( $this->input->post('mlc_number')=="unset"){
                        $this->db->insert('mlc',$mlc_data);                            
                    }
                    else{
                        //if it's an update form, use the visit id to update the mlc record in the databse - mlc table.
                        $this->db->where('visit_id',$visit_id);
                        $this->db->update('mlc',$mlc_data);
                    }
		}
		
		if($this->input->post('prescription')){
			$prescription = $this->input->post('prescription');
			$prescription_data = array();
			foreach($prescription as $pre) {
			if($this->input->post('drug_'.$pre)){
			$duration=$this->input->post('duration_'.$pre);
			$frequency=$this->input->post('frequency_'.$pre);
			$bb=$this->input->post('bb_'.$pre);
			$ab=$this->input->post('ab_'.$pre);
			$bl=$this->input->post('bl_'.$pre);
			$al=$this->input->post('al_'.$pre);
			$bd=$this->input->post('bd_'.$pre);
			$ad=$this->input->post('ad_'.$pre);
			$quantity=$this->input->post('quantity_'.$pre);
			$drug = $this->input->post('drug_'.$pre);
				$morning=0;$afternoon=0;$evening=0;
				if(!!$bb && !!$ab) $morning = 3;
				else if(!!$bb) $morning = 1;
				else if(!!$ab) $morning = 2;
				if(!!$bl && !!$al) $afternoon = 3;
				else if(!!$bl) $afternoon = 1;
				else if(!!$al) $afternoon = 2;
				if(!!$bd && !!$ad) $evening = 3;
				else if(!!$bd) $evening = 1;
				else if(!!$ad) $evening = 2;
				$prescription_data[] = array(
					'visit_id'=>$visit_id,
					'item_id'=>$drug,
					'duration'=>empty($duration) ? NULL : $duration,
					'frequency'=>$frequency,
					'morning'=>$morning,
					'afternoon'=>$afternoon,
					'evening'=>$evening,
					'quantity'=>$quantity,
				);
				}
			}
			if(!!$prescription_data)
			$this->db->insert_batch('prescription',$prescription_data);
		}
		/*
		if($this->input->post('procedure')){
			$procedure_id = $this->input->post('procedure');
			if($this->input->post('procedure_date') $procedure_date = date("Y-m-d",strtotime($this->input->post('procedure_date')));
			else $procedure_date=0;
			if($this->input->post('procedure_time') $procedure_time = date("h:i:s",strtotime($this->input->post('procedure_time')));
			else $procedure_time=0;
			$duration = $this->input->post('duration');
			$procedure_note = $this->input->post('procedure_note');
			$procedure_findings = $this->input->post('procedure_findings');
			$post_procedure_note = $this->input->post('post_procedure_note');
			
				$prescription_data[] = array(
					'visit_id'=>$visit_id,
					'item_id'=>$drug,
					'duration'=>$duration,
					'frequency'=>$frequency,
					'morning'=>$morning,
					'afternoon'=>$afternoon,
					'evening'=>$evening,
					'quantity'=>$quantity,
					'unit_id'=>$unit
				);
				}
			}
			if(!!$prescription_data)
			$this->db->insert_batch('prescription',$prescription_data);
		}
		*/
		//Transaction ends here.
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			return false;
		}
		else {
			return true;
		}

	}
	function select_patient_followup_id($c){
		$hospital=$this->session->userdata('hospital');
		if($this->input->post('healthforall_id')){
			$this->db->where('patient_followup.patient_id',$this->input->post('healthforall_id'));
		}
		$this->db->select("patient_followup_id,
		patient_id,
		hospital_id,
		longitude,
		latitude,
		map_link,
		life_status,
		patient_followup.icd_code,
		icd_code.code_title,
		diagnosis,
		priority_type_id,
		route_primary_id,
		route_secondary_id,
		volunteer_id,
		note,
		ndps,
		drug,
		dose,
		last_dispensed_date,
		last_dispensed_quantity")->from("patient_followup");
		$this->db->join('icd_code','patient_followup.icd_code=icd_code.icd_code','left');
		$this->db->where('hospital_id',$hospital['hospital_id']);
		$resource=$this->db->get();
		return $resource->row();
	}

	function get_priority_type()
	{
		$hospital=$this->session->userdata('hospital');
		$this->db->select("priority_type_id,
		hospital_id,
		priority_type")->from('priority_type');
		$this->db->where('hospital_id',$hospital['hospital_id']);
		$query = $this->db->get();
        	$result = $query->result();
		return $result;
	}

	
	function get_primary_route()
	{
		$hospital=$this->session->userdata('hospital');
		$this->db->select("route_primary_id,
		hospital_id,
		route_primary")->from('route_primary');
		$this->db->where('hospital_id',$hospital['hospital_id']);
		$this->db->order_by('route_primary','ASC');
		$query = $this->db->get();
        	$result = $query->result();
		return $result;
	}
 
	function get_secondary_route(){
		$hospital=$this->session->userdata('hospital');
		$this->db->select("id,
		hospital_id,
		route_primary_id,
		route_secondary")->from('route_secondary');
		$this->db->where('hospital_id',$hospital['hospital_id']);
		$this->db->order_by('route_secondary','ASC');
		$query = $this->db->get();
        	$result = $query->result();
		return $result;
	}

	function get_volunteer(){
		$hospital=$this->session->userdata('hospital');
		$this->db->select("staff.staff_id,first_name,last_name")->from('staff')
		->join('user','user.staff_id=staff.staff_id')
		->join('user_hospital_link','user.user_id=user_hospital_link.user_id');
		$this->db->where('user_hospital_link.hospital_id',$hospital['hospital_id']);
		$this->db->order_by('first_name,last_name','ASC');
		$query = $this->db->get();
        	$result = $query->result();
		return $result;
	}

	function addfor_followup(){
        $followup_info = array();
		
		$hospital=$this->session->userdata('hospital');
		$hospital_id=$hospital['hospital_id'];
		if($this->input->post('patient_id')){
            $followup_info['patient_id'] = $this->input->post('patient_id');
        }
		if($hospital_id){
            $followup_info['hospital_id'] = $hospital_id;
        }
        if($this->input->post('input_map_link')){
            $followup_info['map_link'] = $this->input->post('input_map_link');
        }
        if($this->input->post('life_status')){
            $followup_info['life_status'] = $this->input->post('life_status');
        }
        if($this->input->post('icd_code')){
            $followup_info['icd_code'] = $this->input->post('icd_code');
        }
         if($this->input->post('diagnosis')){
            $followup_info['diagnosis'] = $this->input->post('diagnosis');
        }
        if($this->input->post('priority_type')){
            $followup_info['priority_type_id'] = $this->input->post('priority_type');
        }
         if($this->input->post('route_primary')){
            $followup_info['route_primary_id'] = $this->input->post('route_primary');
        }
         if($this->input->post('route_secondary')){
            $followup_info['route_secondary_id'] = $this->input->post('route_secondary');
        }
         if($this->input->post('volunteer')){
            $followup_info['volunteer_id'] = $this->input->post('volunteer');
        }
         if($this->input->post('input_note')){
            $followup_info['note'] = $this->input->post('input_note');
        }
        
        if($this->input->post('input_latitude')){
            $followup_info['latitude'] = $this->input->post('input_latitude');
        }
        
        if($this->input->post('input_longitude')){
            $followup_info['longitude'] = $this->input->post('input_longitude');
        }
		
		if($this->input->post('ndps_status')=='1')
		{
			$followup_info['ndps']= $this->input->post('ndps_status');
			$followup_info['drug']= $this->input->post('drug');
			$followup_info['dose']= $this->input->post('dose');
			$followup_info['last_dispensed_date']= $this->input->post('last_dispensed_date');
			$followup_info['last_dispensed_quantity']= $this->input->post('last_dispensed_quantity');  
		}

        $followup_info['add_by'] = $followup_info['update_by'] = $this->session->userdata('logged_in')['staff_id'];
		$followup_info['add_time'] = $followup_info['update_time'] = date("Y-m-d H:i:s");
	
	
      //  $this->db->trans_start();
		//print_r($this->input->post('status_date'));die;
        $this->db->insert('patient_followup', $followup_info);
		$insert_id = $this->db->insert_id();
		return $insert_id;
		// $this->db->trans_complete();
        // if($this->db->trans_status()==FALSE){
        //         return false;
        // }
        // else{
		// 	return $insert_id;
        // }
    }


	function updatefor_followup(){
			$this->db->set('life_status', $this->input->post('life_status'));	
			$this->db->set('icd_code', $this->input->post('icd_code'));
			$this->db->set('diagnosis', $this->input->post('diagnosis'));
			$this->db->set('priority_type_id', $this->input->post('priority_type'));
			$this->db->set('route_primary_id', $this->input->post('route_primary'));
			$this->db->set('route_secondary_id', $this->input->post('route_secondary'));
			$this->db->set('volunteer_id', $this->input->post('volunteer'));
			$this->db->set('note', $this->input->post('input_note'));
			$this->db->set('map_link', $this->input->post('input_map_link'));
			$this->db->set('update_by', $this->session->userdata('logged_in')['staff_id']);
			$this->db->set('update_time', date("Y-m-d H:i:s"));
			$this->db->set('latitude', $this->input->post('input_latitude'));
			$this->db->set('longitude', $this->input->post('input_longitude'));
			
			//Newly added on 12-01-2024
			$this->db->set('ndps', $this->input->post('ndps_status'));
			if($this->input->post('ndps_status')=='1')
			{
				$this->db->set('drug', $this->input->post('drug'));
				$this->db->set('dose', $this->input->post('dose'));
				$this->db->set('last_dispensed_date', $this->input->post('last_dispensed_date'));
				$this->db->set('last_dispensed_quantity', $this->input->post('last_dispensed_quantity'));  
			}else
			{
				$this->db->set('drug', '');
				$this->db->set('dose', '');
				$this->db->set('last_dispensed_date', NULL);
				$this->db->set('last_dispensed_quantity', '');
			}
			
			//till here

			$this->db->where('patient_id', $this->input->post('patient_id'));
			if($this->db->update('patient_followup'))
			
				return true;
			
			else
				return false;
			
			
         	}

         function get_districts($district_id){
			$this->db->select("district_id,district,district_alias,latitude,
			longitude,state,state_id")->from('district');
			$this->db->where('district_id', $district_id);
			$query = $this->db->get();
			$result = $query->row();
			return $result;
		    }
			

	  function get_patient_followup(){		   		
		$hospital=$this->session->userdata('hospital');
		if($this->input->post('healthforall_id')){
			$this->db->where('patient.patient_id',$this->input->post('healthforall_id'));
		}
		else{
			return;
		}
         	
	    
		$this->db->select("patient_id,first_name,last_name,age_years,age_months
		,age_days,
		gender,
		father_name,
		mother_name,
		spouse_name,
		address,
		insert_datetime,
		phone")->from('patient');
        $query = $this->db->get();
        $result = $query->result();
		return $result;
	}
	
	function search(){
		$hospital=$this->session->userdata('hospital');
		$hospital_id=$hospital['hospital_id'];
		//Build the where conditions based on the input given by the user.
		if($this->input->post('search_patient_id')){
			$this->db->where('patient.patient_id',$this->input->post('search_patient_id'));
		} else {
			if ($this->input->post('search_patient_id_manual')) {
				$this->db->where('patient.patient_id_manual', $this->input->post('search_patient_id_manual'));
			}
			if($this->input->post('search_patient_name')){
				$name=$this->input->post('search_patient_name');
				$this->db->like("LOWER(CONCAT(patient.first_name,' ',patient.last_name))",strtolower($name),'after');
			}
			if($this->input->post('search_visit_type')){
				$this->db->where('visit_type',$this->input->post('search_visit_type'));
			}
			if($this->input->post('search_patient_number')){
				$this->db->where('hosp_file_no',$this->input->post('search_patient_number'));
			}
			if($this->input->post('search_op_number')){
				$this->db->where('hosp_file_no',$this->input->post('search_op_number'));
				$this->db->where('visit_type','OP');
			}
			if($this->input->post('search_ip_number')){
				$this->db->where('hosp_file_no',$this->input->post('search_ip_number'));
				$this->db->where('visit_type','IP');
			}
			if($this->input->post('search_phone')){
			    $search_phone_withoutzero = ltrim($this->input->post('search_phone'), '0');
			    $this->db->where("(patient.phone='0".$search_phone_withoutzero."' OR patient.phone='".$search_phone_withoutzero."')");
				
							}
			if($this->input->post('selected_patient')){
				$this->db->where('patient_visit.visit_id',$this->input->post('selected_patient'));
			}
			if($this->input->post('visit_id')){
				$this->db->where('patient_visit.visit_id',$this->input->post('visit_id'));
			}
			if($this->input->post('search_year')){
				$this->db->where("(patient_visit.admit_date IS NULL OR YEAR(patient_visit.admit_date)='".$this->input->post('search_year')."')");
			}
			if(!$this->input->post('load_other_hospitals')){
				$this->db->where("(patient_visit.hospital_id IS NULL OR patient_visit.hospital_id='".$hospital['hospital_id']."')");
			}
		}
		//Build the query to retrieve the patient records based on the search query.
		$this->db->select("patient.patient_id,
		patient.patient_id_manual,
		patient.identification_marks,
		patient.first_name,
		patient.middle_name,
		patient.last_name,
		patient.dob,
		patient.age_years,
		patient.age_months,
		patient.age_days,
		patient.gender,
		patient.address,
		patient.place,
		patient.country_code,
		patient.state_code,
		patient.district_id,
		patient.phone,
		patient.alt_phone,
		patient.father_name,
		patient.mother_name,
		patient.spouse_name,
		patient.id_proof_type_id,
		patient.id_proof_number,
		patient.occupation_id,
		patient.education_level,
		patient.education_qualification,
		patient.blood_group,
		patient.mr_no,
		patient.bc_no,
		patient.gestation,
		patient.gestation_type,
		patient.delivery_mode,
		patient.delivery_place,
		patient.delivery_location,
		patient.hospital_type,
		patient.delivery_location_type,
		patient.delivery_plan,
		patient.birth_weight,
		patient.congenital_anomalies,
		patient.temp_patient_id,
		patient_visit.visit_id,
		patient_visit.hospital_id,
		patient_visit.admit_id,
		patient_visit.visit_type,
		patient_visit.visit_name_id,
		patient_visit.hosp_file_no,
		patient_visit.admit_date,
		patient_visit.admit_time,
		patient_visit.department_id,
		patient_visit.unit,
		patient_visit.area,
		patient_visit.doctor_id,
		patient_visit.nurse,
		patient_visit.insurance_case,
		patient_visit.insurance_id,
		patient_visit.insurance_no,
		patient_visit.presenting_complaints,
		patient_visit.past_history,
		patient_visit.family_history,
		patient_visit.admit_weight,
		patient_visit.pulse_rate,
		patient_visit.respiratory_rate,
		patient_visit.temperature,
		patient_visit.sbp,
		patient_visit.dbp,
		patient_visit.spo2,
		patient_visit.blood_sugar,
		patient_visit.hb,
		patient_visit.hb1ac,
		patient_visit.clinical_findings,
		patient_visit.cvs,
		patient_visit.rs,
		patient_visit.pa,
		patient_visit.cns,
		patient_visit.cxr,
		patient_visit.provisional_diagnosis,
		patient_visit.signed_consultation,
		patient_visit.final_diagnosis,
		patient_visit.decision,
		patient_visit.advise,
		patient_visit.icd_10,
		patient_visit.icd_10_ext,
		patient_visit.discharge_weight,
		patient_visit.outcome,
		patient_visit.outcome_date,
		patient_visit.outcome_time,
		patient_visit.ip_file_received,
		patient_visit.mlc,
		patient_visit.arrival_mode,
		patient_visit.referral_by_hospital_id,
		patient_visit.appointment_with,
		patient_visit.appointment_time,
		patient_visit.summary_sent_time,
		patient_visit.temp_visit_id,
		CONCAT(patient.first_name,' ',patient.last_name) name,
		IF(father_name IS NULL OR father_name='',spouse_name,father_name) parent_spouse, mlc.visit_id,
		mlc.mlc_number,mlc.mlc_number_manual,mlc.ps_name,mlc.brought_by,mlc.police_intimation,mlc.declaration_required,mlc.pc_number,mlc.mlc_id,occupation.occupation,id_proof_type, area_name,state.state_id,state.state,mainhospital.hospital,unit_name,unit.unit_id,code_title,area.area_id,district.district,department,patient.patient_id,patient_visit.visit_id, 		patient_procedure.procedure_duration, patient_procedure.procedure_note, patient_procedure.procedure_findings, visit_name.visit_name, CONCAT(staff.first_name,' ',staff.last_name) doctor_name,staff.ima_registration_number as ima_registration_number, staff.doctor_flag as doctor_flag, designation,IFNULL(visit_name.summary_header,0) as summary_header,visit_name.visit_name,referral.hospital as referral_by_hospital_name, appointment_time",false)
		->from('patient')
		->join('patient_visit','patient.patient_id=patient_visit.patient_id','left')
                ->join('visit_name','patient_visit.visit_name_id=visit_name.visit_name_id','left')
                ->join('patient_procedure','patient_procedure.visit_id = patient_visit.visit_id','left')
		->join('department','patient_visit.department_id=department.department_id','left')
		->join('district','patient.district_id=district.district_id','left')
		->join('state','district.state_id=state.state_id','left')
		->join('unit','patient_visit.unit=unit.unit_id','left')
		->join('area','patient_visit.area=area.area_id','left')
		->join('mlc','patient_visit.visit_id=mlc.visit_id','left')
		->join('occupation','patient.occupation_id=occupation.occupation_id','left')
		->join('id_proof_type','patient.id_proof_type_id=id_proof_type.id_proof_type_id','left')
		->join('icd_code','patient_visit.icd_10=icd_code.icd_code','left')
		->join('hospital as referral','patient_visit.referral_by_hospital_id=referral.hospital_id','left')
		->join('hospital as mainhospital','patient_visit.hospital_id=mainhospital.hospital_id','left')
		->join('staff','patient_visit.signed_consultation = staff.staff_id','left')
		//->order_by('name','ASC');
		->order_by('patient_visit.admit_date','DESC');
		$query=$this->db->get();
		
		//return the search results
		return $query->result();
	}
	function select($visit_id=0){
		if($visit_id!=0) //if the visit_id is true, select the patient where visit_id equals the given visit id
			$this->db->where('patient_visit.visit_id',$visit_id);
		else return false; 
		$this->db->select('patient.patient_id,
		patient.patient_id_manual,
		patient.identification_marks,
		patient.first_name,
		patient.middle_name,
		patient.last_name,
		patient.dob,
		patient.age_years,
		patient.age_months,
		patient.age_days,
		patient.gender,
		patient.address,
		patient.place,
		patient.country_code,
		patient.state_code,
		patient.district_id,
		patient.phone,
		patient.alt_phone,
		patient.father_name,
		patient.mother_name,
		patient.spouse_name,
		patient.id_proof_type_id,
		patient.id_proof_number,
		patient.occupation_id,
		patient.education_level,
		patient.education_qualification,
		patient.blood_group,
		patient.mr_no,
		patient.bc_no,
		patient.gestation,
		patient.gestation_type,
		patient.delivery_mode,
		patient.delivery_place,
		patient.delivery_location,
		patient.hospital_type,
		patient.delivery_location_type,
		patient.delivery_plan,
		patient.birth_weight,
		patient.congenital_anomalies,
		patient.temp_patient_id,
		patient_visit.visit_id,
		patient_visit.hospital_id,
		patient_visit.admit_id,
		patient_visit.visit_type,
		patient_visit.visit_name_id,
		patient_visit.hosp_file_no,
		patient_visit.admit_date,
		patient_visit.admit_time,
		patient_visit.department_id,
		patient_visit.unit,
		patient_visit.area,
		patient_visit.doctor_id,
		patient_visit.nurse,
		patient_visit.insurance_case,
		patient_visit.insurance_id,
		patient_visit.insurance_no,
		patient_visit.presenting_complaints,
		patient_visit.past_history,
		patient_visit.family_history,
		patient_visit.admit_weight,
		patient_visit.pulse_rate,
		patient_visit.respiratory_rate,
		patient_visit.temperature,
		patient_visit.sbp,
		patient_visit.dbp,
		patient_visit.spo2,
		patient_visit.blood_sugar,
		patient_visit.hb,
		patient_visit.hb1ac,
		patient_visit.clinical_findings,
		patient_visit.cvs,
		patient_visit.rs,
		patient_visit.pa,
		patient_visit.cns,
		patient_visit.cxr,
		patient_visit.provisional_diagnosis,
		patient_visit.signed_consultation,
		patient_visit.final_diagnosis,
		patient_visit.decision,
		patient_visit.advise,
		patient_visit.icd_10,
		patient_visit.icd_10_ext,
		patient_visit.discharge_weight,
		patient_visit.outcome,
		patient_visit.outcome_date,
		patient_visit.outcome_time,
		patient_visit.ip_file_received,
		patient_visit.mlc,
		patient_visit.arrival_mode,
		patient_visit.referral_by_hospital_id,
		patient_visit.appointment_with,
		patient_visit.appointment_time,
		patient_visit.summary_sent_time,
		patient_visit.temp_visit_id,
hospital,department.department,unit.unit_id,unit.unit_name,area.area_id,area.area_name,mlc.mlc_number,mlc.mlc_number_manual,mlc.ps_name')
		->from('patient')->join('patient_visit','patient.patient_id=patient_visit.patient_id','left')
		->join('department','patient_visit.department_id=department.department_id','left')
		->join('unit','patient_visit.unit=unit.unit_id','left')
		->join('area','patient_visit.area=area.area_id','left')
		->join('mlc','patient_visit.visit_id=mlc.visit_id','left')
		->join('hospital','patient_visit.hospital_id=hospital.hospital_id','left');
	    $query=$this->db->get();
		//return the patient details in a single row.
		return $query->row();
	}
	
	function get_visits($patient_id=0){
		if($patient_id!=0) //if the visit_id is true, select the patient where visit_id equals the given visit id
			$this->db->where('patient_visit.patient_id',$patient_id);
		else return false; 
		
		$this->db->select('patient.patient_id,
		patient.patient_id_manual,
		patient.identification_marks,
		patient.first_name,
		patient.middle_name,
		patient.last_name,
		patient.dob,
		patient.age_years,
		patient.age_months,
		patient.age_days,
		patient.gender,
		patient.address,
		patient.place,
		patient.country_code,
		patient.state_code,
		patient.district_id,
		patient.phone,
		patient.alt_phone,
		patient.father_name,
		patient.mother_name,
		patient.spouse_name,
		patient.id_proof_type_id,
		patient.id_proof_number,
		patient.occupation_id,
		patient.education_level,
		patient.education_qualification,
		patient.blood_group,
		patient.mr_no,
		patient.bc_no,
		patient.gestation,
		patient.gestation_type,
		patient.delivery_mode,
		patient.delivery_place,
		patient.delivery_location,
		patient.hospital_type,
		patient.delivery_location_type,
		patient.delivery_plan,
		patient.birth_weight,
		patient.congenital_anomalies,
		patient.temp_patient_id,
		patient_visit.visit_id,
		patient_visit.hospital_id,
		patient_visit.admit_id,
		patient_visit.visit_type,
		patient_visit.visit_name_id,
		patient_visit.hosp_file_no,
		patient_visit.admit_date,
		patient_visit.admit_time,
		patient_visit.department_id,
		patient_visit.unit,
		patient_visit.area,
		patient_visit.doctor_id,
		patient_visit.nurse,
		patient_visit.insurance_case,
		patient_visit.insurance_id,
		patient_visit.insurance_no,
		patient_visit.presenting_complaints,
		patient_visit.past_history,
		patient_visit.family_history,
		patient_visit.admit_weight,
		patient_visit.pulse_rate,
		patient_visit.respiratory_rate,
		patient_visit.temperature,
		patient_visit.sbp,
		patient_visit.dbp,
		patient_visit.spo2,
		patient_visit.blood_sugar,
		patient_visit.hb,
		patient_visit.hb1ac,
		patient_visit.clinical_findings,
		patient_visit.cvs,
		patient_visit.rs,
		patient_visit.pa,
		patient_visit.cns,
		patient_visit.cxr,
		patient_visit.provisional_diagnosis,
		patient_visit.signed_consultation,
		patient_visit.final_diagnosis,
		patient_visit.decision,
		patient_visit.advise,
		patient_visit.icd_10,
		patient_visit.icd_10_ext,
		patient_visit.discharge_weight,
		patient_visit.outcome,
		patient_visit.outcome_date,
		patient_visit.outcome_time,
		patient_visit.ip_file_received,
		patient_visit.mlc,
		patient_visit.arrival_mode,
		patient_visit.referral_by_hospital_id,
		patient_visit.appointment_with,
		patient_visit.appointment_time,
		patient_visit.summary_sent_time,
		patient_visit.temp_visit_id,hospital,department.department,unit.unit_id,unit.unit_name,area.area_id,area.area_name,mlc.mlc_number,mlc.ps_name')
		->from('patient')->join('patient_visit','patient.patient_id=patient_visit.patient_id')
		->join('department','patient_visit.department_id=department.department_id','left')
		->join('unit','patient_visit.unit=unit.unit_id','left')
		->join('area','patient_visit.area=area.area_id','left')
		->join('mlc','patient_visit.visit_id=mlc.visit_id','left')
		->join('hospital','patient_visit.hospital_id=hospital.hospital_id','left')
		->order_by('admit_date','desc')
		->order_by('admit_time','desc');
	    $query=$this->db->get();
		//return the patient details in a single row.
		return $query->result();
	}
	
	function search_icd_codes(){
		if($this->input->post('block')){
			$this->db->where('icd_block.block_id',$this->input->post('block'));
		}
		if($this->input->post('chapter')){
			$this->db->where('icd_block.chapter_id',$this->input->post('chapter'));
		}
		$this->db->select('icd_code, CONCAT(icd_code," ",code_title) as code_title',false)
		->from('icd_code')
		->join('icd_block','icd_code.block_id = icd_block.block_id')
		->order_by('code_title')
		->where("(code_title LIKE '%".$this->input->post('query')."%' OR icd_code LIKE '%".$this->input->post('query')."%')");
		$query=$this->db->get();
		return $query->result_array();
	}
	
	function get_prescription($visit_id){
		$this->db->select("prescription.prescription_id,
		prescription.visit_id,
		prescription.item_id,
		prescription.note,
		prescription.duration,
		prescription.frequency,
		prescription.morning,
		prescription.afternoon,
		prescription.evening,
		prescription.quantity,
		prescription.unit_id,
		prescription.status,
		, generic_item_id, generic_name as item_name, item_form.item_form")
			->from("prescription")
			->join('generic_item','generic_item.generic_item_id = prescription.item_id','left')
			->join('item_form','generic_item.form_id = item_form.item_form_id','left')
			->where('visit_id',$visit_id)->where('status',1);
		$query=$this->db->get();
		return $query->result();
	}
	
	function get_previous_visit($visit_id, $patient_id){
		$this->db->select("visit_id")
			->from("patient_visit")
			->where('patient_id',$patient_id)
			->where('visit_id <',$visit_id)
			->order_by('visit_id','desc')
			->limit(1);
		$query=$this->db->get();
		return $query->row();
	}

	function get_clinical_notes($visit_id){
		$this->db->select('patient_clinical_notes.note_id,
		patient_clinical_notes.visit_id,
		patient_clinical_notes.clinical_note,
		patient_clinical_notes.user_id,
		patient_clinical_notes.note_time,
		patient_clinical_notes.update_time
		,staff.first_name, staff.last_name')->from('patient_clinical_notes')
		->join('user','patient_clinical_notes.user_id = user.user_id','left')
		->join('staff','user.staff_id = staff.staff_id','left')
		->where('visit_id',$visit_id)
		->order_by('note_time','desc');
		$query = $this->db->get();
		return $query->result();
	}
	
	function transport(){
        if($this->input->post('transport_from_area')) $transport_from_area=$this->input->post('transport_from_area'); else $transport_from_area="";
        if($this->input->post('transport_to_area')) $transport_to_area=$this->input->post('transport_to_area'); else $transport_to_area="";
        if($this->input->post('transported_by')) $transported_by=$this->input->post('transported_by'); else $transported_by="";
        if($this->input->post('transport_start_date')) $transport_start_date=$this->input->post('transport_start_date'); else $transport_start_date=0;
        if($this->input->post('transport_end_date')) $transport_end_date=$this->input->post('transport_end_date'); else $transport_end_date=0;
        if($this->input->post('note')) $note=$this->input->post('note'); else $note=0;
        if($this->input->post('transport_type')) $transport_type=$this->input->post('transport_type'); else $transport_type=1;
        if($this->input->post('transport_id')) $transport_id=$this->input->post('transport_id'); else $transport_id=0;
        if($this->input->post('visit_id')) $visit_id=$this->input->post('visit_id'); else $visit_id = 0;
        if($this->input->post('transport_complete')) $transport_complete=$this->input->post('transport_complete'); else $transport_complete = 0;
		if(!!$transport_id) {
			$transport_data = array();
			$i=count($transport_id);
			foreach($transport_id as $t){
			$transport_data []= array(
				'transport_id' => $t,
				'end_date_time' => date('Y-m-d H:i:s',strtotime($this->input->post("transport_end_date_$t"))),
				'note' => $this->input->post("note_$t")
			);
			$i--;
			}
			if($this->db->update_batch('transport',$transport_data,'transport_id'))
				return true;
			else return false;
		}
		else if(!!$transport_from_area && !!$transport_to_area && !!$transported_by && !!$transport_start_date) {
			$transport_data = array(
				'visit_id' => $visit_id,
				'from_area_id' => $transport_from_area,
				'to_area_id' => $transport_to_area,
				'staff_id' => $transported_by,
				'start_date_time' => date("Y-m-d H:i:s",strtotime($transport_start_date)),
				'note' => $note,
				'transport_type' => $transport_type,
				'entry_date_time' => date("Y-m-d H:i:s")
			);
			if($this->db->insert('transport',$transport_data))
				return true;
			else return false;

		}
	}
	
	// To get print Layouts dynamically for update_patients page --- added by Shruthi S M on 18_02_2023
	function get_print_layout($patient_id){
	$this->db->where('patient.patient_id',$patient_id);
	$this->db->select("hospital.print_layout_id,
		hospital.a6_print_layout_id")
			->from("hospital")
			->join('patient_visit','patient_visit.hospital_id = hospital.hospital_id','left')
			->join('patient','patient.patient_id = patient_visit.patient_id','left');
			// ->where('patient_id',$patient_id);
		$query=$this->db->get();
		return $query->result();
	}
}
?>
