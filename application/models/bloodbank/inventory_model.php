<?php 
class Inventory_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function get_ungrouped_blood(){
		$userdata=$this->session->userdata('hospital');
		$hospital=$userdata['hospital_id'];
		if($this->input->post('from_id') && $this->input->post('to_id')){
			$from=$this->input->post('from_id');
			$to=$this->input->post('to_id');
			$this->db->where("(blood_unit_num BETWEEN $from AND $to)");
		}
		else if($this->input->post('from_id') || $this->input->post('to_id')){
			$this->input->post('from_id')!=""?$id=$this->input->post('from_id'):$id=$this->input->post('to_id');
			$this->db->where('blood_unit_num',$id);
		}
		if($this->input->post('year')) $year = $this->input->post('year'); 
		else $year = date("Y");
		$this->db->select('*')
		->from('blood_inventory')
		->join('bb_donation','blood_inventory.donation_id=bb_donation.donation_id')
		->join('blood_donor','bb_donation.donor_id=blood_donor.donor_id')
		->where('bb_donation.status_id',4)
		->where('bb_donation.hospital_id',$hospital)
		->where('YEAR(donation_date)',$year)
		->order_by('blood_unit_num');
		$query=$this->db->get();
		return $query->result();
	}
	function group_blood(){
		$userdata=$this->session->userdata('hospital');
		$hospital=$userdata['hospital_id'];
		
		$donation_ids=$this->input->post('donation_id');
		$data=array();
		$update_data=array();
		$grouping_date=date("Y-m-d",strtotime($this->input->post('grouping_date')));
		$forward_by=$this->input->post('forward_by');
		$reverse_by=$this->input->post('reverse_by');
		foreach($donation_ids as $donation_id){
			$donor_id=$this->input->post('donor_id_'.$donation_id);
			$blood_group=$this->input->post('blood_group_'.$donation_id);
			$sub_group=$this->input->post('sub_group_'.$donation_id);
			$anti_a=$this->input->post('anti_a_'.$donation_id);
			$anti_b=$this->input->post('anti_b_'.$donation_id);
			$anti_ab=$this->input->post('anti_ab_'.$donation_id);
			$anti_d=$this->input->post('anti_d_'.$donation_id);
			$a_cells=$this->input->post('a_cells_'.$donation_id);
			$b_cells=$this->input->post('b_cells_'.$donation_id);
			$o_cells=$this->input->post('o_cells_'.$donation_id);
			$du=$this->input->post('du_'.$donation_id);
			if($donor_id!='' && $blood_group !='' && $anti_a!='' && $anti_b!='' && $anti_ab!='' && $anti_d!='' && $a_cells!='' && $b_cells!='' && $o_cells!='' && $du!=''){
			$data[]=array(
			'donation_id'=>$donation_id,
			'blood_group'=>$blood_group,
			'sub_group'=>$sub_group,
			'anti_a'=>$anti_a,
			'anti_b'=>$anti_b,
			'anti_ab'=>$anti_ab,
			'anti_d'=>$anti_d,
			'a_cells'=>$a_cells,
			'b_cells'=>$b_cells,
			'o_cells'=>$o_cells,
			'du'=>$du,
			'grouping_date'=>$grouping_date,
			'forward_done_by'=>$forward_by,
			'reverse_done_by'=>$reverse_by,
			/**
			 * Multi hospital support
			 * 
			 * Added By : Pranay On 20170521
			 */
			'hospital_id'=>$hospital
			);
			$update_data[]=array(
			'donor_id'=>$donor_id,
			'blood_group'=>$blood_group,
			'sub_group'=>$sub_group
			);
			$update_status_data[]=array(
			'donation_id'=>$donation_id,
			'status_id'=>5
			);
			}
		}
		if(count($data)>0){
		$this->db->trans_start();
		$this->db->insert_batch('blood_grouping',$data);
		$this->db->update_batch('blood_donor',$update_data,'donor_id');
		$this->db->update_batch('bb_donation',$update_status_data,'donation_id');
		
		$this->db->trans_complete();
		return $this->db->trans_status();
		}
		else{
			return false;
		}
	}

	function get_unprepared_blood(){

		$userdata=$this->session->userdata('hospital');
		$hospital=$userdata['hospital_id'];
		if($this->input->post('from_id') && $this->input->post('to_id')){
			$from=$this->input->post('from_id');
			$to=$this->input->post('to_id');
			$this->db->where("(blood_unit_num BETWEEN $from AND $to)");
			
		}
		else if($this->input->post('from_id') || $this->input->post('to_id')){
			$this->input->post('from_id')!=""?$id=$this->input->post('from_id'):$id=$this->input->post('to_id');
			$this->db->where('blood_unit_num',$id);
		}
		if($this->input->post('bag_type')){
			$this->db->where('bag_type',$this->input->post('bag_type'));
		}
		if($this->input->post('year')) $year = $this->input->post('year'); 
		else $year = date("Y");
		$this->db->select('*')
		->from('blood_inventory')
		->join('bb_donation','blood_inventory.donation_id=bb_donation.donation_id')
		->join('blood_donor','bb_donation.donor_id=blood_donor.donor_id')
		->where('bb_donation.status_id >=',5,false)
		->where('blood_inventory.status_id <',8,false)
		->where('component_type','WB')
		->where('bb_donation.hospital_id',$hospital)
		->where('YEAR(donation_date)',$year)
		->order_by('blood_unit_num')
                ->limit('500');
		$query=$this->db->get();

		return $query->result();
	}	
	
	function prepare_components(){
		$userdata=$this->session->userdata('hospital');
		$hospital=$userdata['hospital_id'];
		$donation_ids=$this->input->post('donation_id');
		$data=array();
		$update_data=array();
		foreach($donation_ids as $donation_id){
		$components=$this->input->post($donation_id);
		$this->db->trans_start();
		$this->db->select('
		DATE_ADD(donation_date,INTERVAL 35 DAY) expiry_35,
		DATE_ADD(donation_date,INTERVAL 42 DAY) expiry_42,
		DATE_ADD(donation_date,INTERVAL 5 DAY) expiry_5,
		DATE_ADD(donation_date,INTERVAL 365 DAY) expiry_365,
		DATE_ADD(donation_date,INTERVAL 1825 DAY) expiry_1825,
		blood_inventory.*,bb_donation.*',FALSE)->from('blood_inventory')
		->join('bb_donation','blood_inventory.donation_id=bb_donation.donation_id')
		->where('bb_donation.donation_id',$donation_id);
		$query=$this->db->get();
		$result=$query->result();
		$inventory=$result[0];
		
		foreach($components as $component){
			if($component=="WB"){
				$volume=$inventory->volume;
				$expiry_date=$inventory->expiry_35;
			}
			else if($component=='PC'){
				if($inventory->volume==350){
					$volume='100';
				}
				else{
					$volume='150';
				}
				if($inventory->bag_type==5){
					$expiry_date=$inventory->expiry_42;
				}
				else{
					$expiry_date=$inventory->expiry_35;
				}
			}
			else if($component=='FFP'){
				if($inventory->volume==350){
					$volume='40';
				}
				else{
					$volume='60';
				}
				$expiry_date=$inventory->expiry_365;
			}
			else if($component=='FP'){
				if($inventory->volume==350){
					$volume='40';
				}
				else{
					$volume='60';
				}
					$expiry_date=$inventory->expiry_1825;
			}
			else if($component=='PRP'){
				if($inventory->volume==350){
					$volume='100';
				}
				else{
					$volume='120';
				}
					$expiry_date=$inventory->expiry_5;
			}
			else if($component=='Platelet Concentrate'){
				if($inventory->volume==350){
					$volume='100';
				}
				else{
					$volume='120';
				}
				$expiry_date=$inventory->expiry_5;
			}
			else if($component=='Cryo'){
				if($inventory->volume==350){
					$volume='80';
				}
				else{
					$volume='100';
				}
				$expiry_date=$inventory->expiry_5;
			}
			$userdata=$this->session->userdata('hospital');
			$data[]=array(
				'component_type'=>$component,
				'status_id'=>7,
				'donation_id'=>$inventory->donation_id,
				'volume'=>$volume,
				'created_by'=>$this->input->post('staff'),
				'expiry_date'=>$expiry_date,
				'component_perparation_time'=>$this->input->post($inventory->donation_id.'com_prep_time'),
				'datetime'=>date("Y-m-d",strtotime($this->input->post('preparation_date'))),
				/**
				 * Multi hospital support
				 * 
				 * Added By : Pranay On 20170521
				 */
				'hospital_id'=>$hospital
			);
			$update_data[]=array(
			'inventory_id'=>$inventory->inventory_id,
			'status_id'=>10,
			'component_type'=>'Components Prepared'
			);
		}
		}
		
		$this->db->insert_batch('blood_inventory',$data);
		$this->db->update_batch('blood_inventory',$update_data,'inventory_id');
		
		$this->db->trans_complete();
		return $this->db->trans_status();
	}
	
	function get_unscreened_blood(){
		$userdata=$this->session->userdata('hospital');
		$hospital=$userdata['hospital_id'];
		if($this->input->post('from_id') && $this->input->post('to_id')){
			$from=$this->input->post('from_id');
			$to=$this->input->post('to_id');
			$this->db->where("(blood_unit_num BETWEEN $from AND $to)");
		}
		else if($this->input->post('from_id') || $this->input->post('to_id')){
			$this->input->post('from_id')!=""?$id=$this->input->post('from_id'):$id=$this->input->post('to_id');
			$this->db->where('blood_unit_num',$id);
		}
		$this->db->select('*')
		->from('blood_inventory')
		->join('bb_donation','blood_inventory.donation_id=bb_donation.donation_id')
		->join('blood_donor','bb_donation.donor_id=blood_donor.donor_id')
		->where('bb_donation.status_id',5)
		->where('bb_donation.hospital_id',$hospital)
		->group_by('blood_inventory.donation_id')
		->order_by('blood_unit_num');
		$query=$this->db->get();
		return $query->result();
	}
	
	function blood_screening(){
		$tested=$this->input->post('test');
		$date=date("Y-m-d",strtotime($this->input->post('screened_date')));
		$staff=$this->input->post('staff');
		$data=array();
		$status_data=array();
		$this->db->trans_start();
		
		foreach($tested as $donation_id){
			$hiv=$this->input->post('test_hiv_'.$donation_id);
			$hbsag=$this->input->post('test_hbsag_'.$donation_id);
			$hcv=$this->input->post('test_hcv_'.$donation_id);
			$vdrl=$this->input->post('test_vdrl_'.$donation_id);
			$mp=$this->input->post('test_mp_'.$donation_id);
			$irregular_ab=$this->input->post('test_irregular_ab_'.$donation_id);
			if($hiv == 1 || $hbsag == 1 ||
			 $hcv == 1 ||  $vdrl == 1 ||
			   $mp == 1 ||  $irregular_ab == 1){
				$screening_result = 0;
			}
			else{
				$screening_result=1;
			}
			$data[]=array(
			'donation_id'=>$donation_id,
			'test_hiv'=>$hiv,
			'test_hbsag'=>$hbsag,
			'test_hcv'=>$hcv,
			'test_vdrl'=>$vdrl,
			'test_mp'=>$mp,
			'test_irregular_ab'=>$irregular_ab,
			'screening_datetime'=>$date,
			'screened_by'=>$staff
			);
			$status_data[]=array(
			'donation_id'=>$donation_id,
			'status_id'=>6,
			'screening_result'=>$screening_result
			);
		}
		$this->db->update_batch('bb_donation',$status_data,'donation_id');
		$this->db->update_batch('blood_screening',$data,'donation_id');
		
		$this->db->trans_complete();
		
		$this->db->select('blood_donor.phone, blood_donor.name, blood_donor.blood_group, bb_donation.donation_date')
		->from('blood_donor')
		->join('bb_donation','bb_donation.donor_id = blood_donor.donor_id','left')
		->join('blood_screening','blood_screening.donation_id = bb_donation.donation_id AND blood_screening.screening_result!=1','left')
		->where_in('bb_donation.donation_id',$tested);
		$donor_info_query = $this->db->get();
                $donor_info = $donor_info_query->result();
                
		$number_message = array();
		foreach($donor_info as $donor)
		{
			if($donor->phone!='')
			{
				$donation_date = date("j F Y", strtotime($donor->donation_date));
				$number_message[]=$number_message[]=$donor->phone.'^'
					."Thank you $donor->name for donating your $donor->blood_group blood to IRCS on ".$donation_date.".";
				
			}
		}
               if(sizeof($number_message) > 1)
		       $number_message_string = implode('~',$number_message);
               else
		       $number_message_string = implode('',$number_message);                   
		//Send SMS
		$url = "http://www.smsstriker.com/API/multi_messages.php?";
		$data = array(
                    'username'=>'ucdsyousee',
                    'password'=>'SMS4UCDS',
                    'from'=>'IRCS',
                    'mno_msg'=>$number_message_string,
                    'type'=>1,
                    'dnd_check'=>0
		);
		$options = array(
				'http' => array(
						'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
						'method'  => 'POST',
						'content' => http_build_query($data)
				)
		);
		$context  = stream_context_create($options);
		$result = file_get_contents($url, false, $context);
		//End of send SMS.
		return $this->db->trans_status();
	}
	
	function get_requests(){
		$userdata=$this->session->userdata('hospital');
		$hospital=$userdata['hospital_id'];
		if($this->input->post('request_id')){
		$this->db->where('request_id',$this->input->post('request_id'));
		}
		$this->db->select('blood_request.*, patient_visit.hosp_file_no, patient.first_name, patient.last_name, hospital, department.department, unit_name, area_name')
		->from('blood_request')
		->join('patient_visit','blood_request.patient_id = patient_visit.patient_id','left')
		->join('patient','patient_visit.patient_id = patient.patient_id','left')
		->join('department','patient_visit.department_id = department.department_id','left')
		->join('unit','patient_visit.unit = unit.unit_id','left')
		->join('area','patient_visit.area = area.area_id','left')
		->join('hospital','blood_request.request_hospital_id=hospital.hospital_id','left')
		->where('request_status','Pending')
	//	->where('blood_request.bloodbank_id',$hospital)
		/**
		 * Multi hospital support
		 * 
		 * Added By : Pranay On 20170521
		 */
		->where('blood_request.hospital_id', $hospital)
		->order_by('blood_transfusion_required desc,request_id asc');
		$query=$this->db->get();
		return $query->result();
	}
	
	function check_inventory(){
		$userdata=$this->session->userdata('hospital');
		$hospital=$userdata['hospital_id'];
		
		$components=implode($this->input->post('components'),",");
		$units=$this->input->post('units');
		$blood_group=$this->input->post('blood_group');
		
		$result=$this->db->query('
		SELECT * FROM blood_inventory
		JOIN bb_donation ON blood_inventory.donation_id=bb_donation.donation_id AND bb_donation.hospital_id='.$hospital.'
		JOIN blood_donor ON bb_donation.donor_id=blood_donor.donor_id
		WHERE ("WB" IN ('.$components.')) AND component_type="WB" AND bb_donation.status_id=6 AND screening_result=1 AND blood_inventory.status_id=7 AND blood_group="'.$blood_group.'" AND blood_inventory.hospital_id="'.$hospital.'" 
		UNION
		SELECT * FROM blood_inventory
		JOIN bb_donation ON blood_inventory.donation_id=bb_donation.donation_id AND bb_donation.hospital_id='.$hospital.'
		JOIN blood_donor ON bb_donation.donor_id=blood_donor.donor_id
		WHERE ("FP" IN ('.$components.') OR "FFP" IN ('.$components.') OR "PC" IN ('.$components.')) AND component_type IN ("PC","FP","FFP") AND bb_donation.status_id=6 AND screening_result=1 AND blood_inventory.status_id=7  AND blood_group LIKE "'.trim($blood_group,'+-').'%" AND blood_inventory.hospital_id="'.$hospital.'" 
		UNION
		SELECT * FROM blood_inventory
		JOIN bb_donation ON blood_inventory.donation_id=bb_donation.donation_id AND bb_donation.hospital_id='.$hospital.' 
		JOIN blood_donor ON bb_donation.donor_id=blood_donor.donor_id
		WHERE ("Cryo" IN ('.$components.') OR "PRP" IN ('.$components.') OR "Platelet Concentrate" IN ('.$components.'))
		AND component_type IN ("Cryo","PRP","Platelet Concentrate") 
		AND bb_donation.status_id=6  AND screening_result=1 AND blood_inventory.status_id=7 AND blood_inventory.hospital_id="'.$hospital.'" 
		ORDER BY component_type,blood_unit_num ASC,expiry_date ASC
		LIMIT 1000
		'); //AND bb_donation.hospital_id='.$hospital.'
		$data[]=$result->result();
		$data[]=$result->num_rows();
		return $data;
	}
	
	function issue(){
		$inventory=$this->input->post('inventory_id');

		$userdata=$this->session->userdata('hospital');
		$hospital_id=$userdata['hospital_id'];

		$data=array(
			'request_id'=>$this->input->post('request_id'),
			'issued_by'=>$this->input->post('staff'),
			'cross_matched_by'=>$this->input->post('cross_matched_by'),
			'issue_date'=>date("Y-m-d",strtotime($this->input->post('issue_date'))),
			'issue_time'=>date("h:i:s",strtotime($this->input->post('issue_time'))),
			'hospital_id'=>$hospital_id
		);
        $issued_inventory = array();

		$this->db->trans_start();

		$this->db->insert('blood_issue',$data);
		$issue_id=$this->db->insert_id();

		foreach($inventory as $inventory_id){
			$issued_inventory[]=array(
			'issue_id'=>$issue_id,
			'inventory_id'=>$inventory_id
			);
		}

		$this->db->insert_batch('bb_issued_inventory',$issued_inventory);

		$this->db->where_in('inventory_id',$inventory);
		$this->db->update('blood_inventory',array('status_id'=>8));

		$this->db->where('request_id',$this->input->post('request_id'));
		$this->db->update('blood_request',array('request_status'=>'issued'));

		$this->db->trans_complete();

		if($this->db->trans_status()==FALSE){
			return false;
		}
		else{
			$this->db->select('blood_donor.donor_id,blood_donor.blood_group,blood_donor.sub_group,name,email,blood_request.diagnosis,donation_date,blood_issue.issue_id, issue_date,issue_time,request_type,patient.first_name,patient.last_name,blood_request.patient_name, patient_visit.final_diagnosis ,bb_donation.blood_unit_num, bb_donation.segment_num, blood_inventory.component_type, blood_inventory.volume, blood_request.blood_group "recipient_group", MAX(patient_visit.admit_date), hospital.hospital')
                ->from('blood_donor')
				->join('bb_donation','blood_donor.donor_id=bb_donation.donor_id','left')
				->join('blood_inventory','bb_donation.donation_id=blood_inventory.donation_id','left')
				->join('bb_issued_inventory','blood_inventory.inventory_id=bb_issued_inventory.inventory_id','left')
				->join('blood_issue','bb_issued_inventory.issue_id=blood_issue.issue_id','left')
				->join('blood_request','blood_issue.request_id=blood_request.request_id','left')
				->join('patient','patient.patient_id=blood_request.patient_id','left')
				->join('patient_visit','patient_visit.patient_id=patient.patient_id','left')
				->join('hospital','hospital.hospital_id=blood_request.request_hospital_id','left')
				->where_in('blood_inventory.inventory_id',$inventory)
				->group_by('blood_donor.donor_id, patient_visit.patient_id');
			$query=$this->db->get();
			return $query->result();
		}
	}
	
	function get_inventory(){
		$userdata=$this->session->userdata('hospital');
		$hospital=$userdata['hospital_id'];
		
		if($this->input->post('blood_unit_num')){
			$this->db->where('blood_unit_num',$this->input->post('blood_unit_num'));
		}
		else{
			$this->db->where('blood_inventory.status_id',7);
		}
		
		$this->db->select('blood_unit_num,component_type,blood_group,expiry_date,bb_donation.donation_id,blood_unit_num,bb_donation.status_id as donation_status,d_status.status as don_status,i_status.status as inv_status,screening_result,inventory_id')
			->from('blood_inventory')
			->join('bb_donation','blood_inventory.donation_id=bb_donation.donation_id')
			->join('blood_donor','bb_donation.donor_id=blood_donor.donor_id')
			->join('bb_status d_status','bb_donation.status_id=d_status.status_id')
			->join('bb_status i_status','blood_inventory.status_id=i_status.status_id')
			->where('blood_inventory.status_id !=',10)//displays screening failed and under collection
			->where('blood_inventory.discarded_by =',0)//displays screening failed and under collection and also which are not disarded
		//	->where('bb_donation.hospital_id',$hospital)
			/**
			 * Multi hospital support
			 * 
			 * Added By : Pranay On 20170521
			 */
            ->where('blood_inventory.hospital_id', $hospital)
			->order_by('component_type')
			->limit(500);
		$query=$this->db->get();
		return $query->result();
	}
	
	function discard_inventory(){
		$this->db->trans_start();
		$inv_id=$this->input->post('inventory_id');
		$data=array(
			'status_id'=>9,
			'notes'=>$this->input->post('notes'),
            'discarded_by'=>$this->input->post('staff_id')//posts discarded staff_id to blood_inventory[database]
		);
		$this->db->where('inventory_id',$inv_id);
		$this->db->update('blood_inventory',$data);
		$this->db->trans_complete();

		return $this->db->trans_status();
	}
	
}
?>
