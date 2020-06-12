<?php 
/*
	Contains queries to generate reports from the database.
*/
class Reports_model extends CI_Model{
	
	function __construct(){
		parent::__construct();
	}
	
	/* get_donation_summary() : Generate the summary report of the donations made in a given period of time. Defaults to last 30 days. */
	function get_donation_summary() {
		$userdata=$this->session->userdata('hospital');
		$hospital=$userdata['hospital_id'];

		if($this->input->post('from_date') && $this->input->post('to_date')){
			 $this->db->where('(donation_date BETWEEN "'.date("Y-m-d",strtotime($this->input->post('from_date'))).'" AND "'.date("Y-m-d",strtotime($this->input->post('to_date'))).'")');
		 }
		 else if($this->input->post('from_date') || $this->input->post('to_date')){
			 $this->input->post('from_date')==""?$date=date("Y-m-d",strtotime($this->input->post('to_date'))):$date=date("Y-m-d",strtotime($this->input->post('from_date')));
			 $this->db->where('donation_date',$date);
		 }
		 else{
			$from_date=date('Y-m-d',strtotime('-30 Days'));
			$to_date=date('Y-m-d');
			$this->db->where("(donation_date BETWEEN '$from_date' AND '$to_date')");
		 }

		 $this->db->select('
				donation_date,
				bb_donation.camp_id,camp_name,
				SUM(CASE WHEN sex="m" THEN 1 ELSE 0 END) "male",
				SUM(CASE WHEN sex="f" THEN 1 ELSE 0 END) "female",
				SUM(CASE WHEN 1 THEN 1 ELSE 0 END) "total",
				SUM(CASE WHEN blood_group="A+" THEN 1 ELSE 0 END) "Apos",
				SUM(CASE WHEN blood_group="A-" THEN 1 ELSE 0 END) "Aneg",
				SUM(CASE WHEN blood_group="B+" THEN 1 ELSE 0 END) "Bpos",
				SUM(CASE WHEN blood_group="B-" THEN 1 ELSE 0 END) "Bneg",
				SUM(CASE WHEN blood_group="AB+" THEN 1 ELSE 0 END) "ABpos",
				SUM(CASE WHEN blood_group="AB-" THEN 1 ELSE 0 END) "ABneg",
				SUM(CASE WHEN blood_group="O+" THEN 1 ELSE 0 END) "Opos",
				SUM(CASE WHEN blood_group="O-" THEN 1 ELSE 0 END) "Oneg"
			')
			->from('blood_donor')
			->join('bb_donation','blood_donor.donor_id=bb_donation.donor_id')
			->join('blood_donation_camp','bb_donation.camp_id=blood_donation_camp.camp_id','left')
			->where('status_id >=',5)//->where('bb_donation.hospital_id',$hospital)
			/**
			 * Multi hospital support
			 * 
			 * Added By : Pranay On 20170521
			 */
			->where('blood_donor.hospital_id',$hospital)
			->group_by('donation_date,bb_donation.camp_id')
			->order_by('donation_date','desc');
		 if($query=$this->db->get()){
//			echo $this->db->last_query();
			return $query->result();
		}else {
			return false;	
		}
	}// get_donation_summary
	
	
	/* get_issue_summary() : Generate the summary report of the issues in a given period of time. Defaults to last 30 days. */

	function get_issue_summary(){
		$userdata=$this->session->userdata('hospital');
		$hospital=$userdata['hospital_id'];
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$this->db->where('(issue_date BETWEEN "'.date("Y-m-d",strtotime($this->input->post('from_date'))).'" AND "'.date("Y-m-d",strtotime($this->input->post('to_date'))).'")');
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')==""?$date=date("Y-m-d",strtotime($this->input->post('to_date'))):$date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$this->db->where('issue_date',$date);
		}
		else{
			$from_date=date('Y-m-d',strtotime('-30 Days'));
			$to_date=date('Y-m-d');
			$this->db->where("(issue_date BETWEEN '$from_date' AND '$to_date')");
		}
		$this->db->select('
			issue_date,issue_time,
			SUM(CASE WHEN 1 THEN 1 ELSE 0 END) "total",
			SUM(CASE WHEN blood_group="A+" THEN 1 ELSE 0 END) "Apos",
			SUM(CASE WHEN blood_group="A-" THEN 1 ELSE 0 END) "Aneg",
			SUM(CASE WHEN blood_group="B+" THEN 1 ELSE 0 END) "Bpos",
			SUM(CASE WHEN blood_group="B-" THEN 1 ELSE 0 END) "Bneg",
			SUM(CASE WHEN blood_group="AB+" THEN 1 ELSE 0 END) "ABpos",
			SUM(CASE WHEN blood_group="AB-" THEN 1 ELSE 0 END) "ABneg",
			SUM(CASE WHEN blood_group="O+" THEN 1 ELSE 0 END) "Opos",
			SUM(CASE WHEN blood_group="O-" THEN 1 ELSE 0 END) "Oneg"
		')
		->from('blood_donor')
		->join('bb_donation','blood_donor.donor_id=bb_donation.donor_id')
		->join('blood_inventory','bb_donation.donation_id=blood_inventory.donation_id')
		->join('bb_issued_inventory','blood_inventory.inventory_id=bb_issued_inventory.inventory_id')
		->join('blood_issue','bb_issued_inventory.issue_id=blood_issue.issue_id')
		->where('blood_inventory.status_id',8)
		// ->where('bb_donation.hospital_id',$hospital)
		/**
		* Multi hospital support
		* 
		* Added By : Pranay On 20170521
		*/
		->where('blood_donor.hospital_id', $hospital)
		->group_by('issue_date')
		->order_by('issue_date','desc');

		if($query=$this->db->get()){
			return $query->result();
		}
		else{
			return false;	
		}
	}// get_issue_summary
	
	/* get_available_blood() : Generate the report of the available stock at the present time. */

	function get_available_blood($hospitals=0){
		$userdata=$this->session->userdata('hospital');
		$hospital=$userdata['hospital_id'];
		if($hospitals=='0'){
			$this->db->where('blood_donor.hospital_id', $hospital);
		}
		else{
			$this->db->group_by('blood_donor.hospital_id');
			$this->db->order_by('hospital,blood_group');
			$this->db->join('hospital','blood_donor.hospital_id = hospital.hospital_id');
			$this->db->select('hospital');
		}
		$this->db->select("
			blood_group,
			SUM(CASE WHEN component_type='PRP' THEN 1 ELSE 0 END) prp,
			SUM(CASE WHEN component_type='Platelet Concentrate' THEN 1 ELSE 0 END) platelet_concentrate,
			SUM(CASE WHEN component_type='PC' THEN 1 ELSE 0 END) pc,
			SUM(CASE WHEN component_type='WB' THEN 1 ELSE 0 END) wb,
			SUM(CASE WHEN component_type='Cryo' THEN 1 ELSE 0 END) cryo,
			SUM(CASE WHEN component_type='FP' THEN 1 ELSE 0 END) fp,
			SUM(CASE WHEN component_type='FFP' THEN 1 ELSE 0 END) ffp"
			)
		->from('blood_donor')
		->join('bb_donation','blood_donor.donor_id=bb_donation.donor_id')
		->join('blood_inventory','bb_donation.donation_id=blood_inventory.donation_id')
		->where('bb_donation.status_id',6)
		->where('bb_donation.screening_result',1)
		->where('blood_inventory.status_id',7)
		// ->where('bb_donation.hospital_id',$hospital)
		/**
		* Multi hospital support
		* 
		* Added By : Pranay On 20170521
		*/
		->where('expiry_date>=',date("Y-m-d"),false)
		->group_by('blood_group');

		if($query=$this->db->get()){
			return $query->result();
		}
		else
		{
			return false;	
		}
	}// get_available_blood
	
	/* get_donors() : Generate the report of the donors that have donated at the blood bank or at one of the camps. 
	Selection options include blood group, donated before given date, donated at camp, donor number range. */

	function get_donors(){
		$userdata=$this->session->userdata('hospital');
		$hospital=$userdata['hospital_id'];
		if($this->input->post('blood_group')){
			$this->db->where('blood_group',$this->input->post('blood_group'));
		}
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$this->db->where('(donation_date BETWEEN "'.date("Y-m-d",strtotime($this->input->post('from_date'))).'" AND "'.date("Y-m-d",strtotime($this->input->post('to_date'))).'")');
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')==""?$date=date("Y-m-d",strtotime($this->input->post('to_date'))):$date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$this->db->where('donation_date',$date);
		}
		else if($this->input->post('donation_date')){
			$from_donation_date = date("Y-m-d",strtotime($this->input->post('donation_date')));
			$to_donation_day = date( 'Y-m-d', strtotime($this->input->post('donation_date') . ' +30 day' ) );
			$this->db->where("donation_date BETWEEN '$from_donation_date' AND '$to_donation_day'");
		}
		else{
			$from_date=date('Y-m-d',strtotime('-30 Days'));
			$to_date=date('Y-m-d');
			$this->db->where("(donation_date BETWEEN '$from_date' AND '$to_date')");
		}
		if($this->input->post('camp_id')!=""){
			$this->db->where('bb_donation.camp_id',$this->input->post('camp_id'));
		}
		if($this->input->post('from_num') && $this->input->post('to_num')){
			$from_num=trim($this->input->post('from_num'));
			$to_num=trim($this->input->post('to_num'));
			$this->db->where("(blood_unit_num BETWEEN $from_num AND $to_num)");
		}
		else if($this->input->post('from_num') || $this->input->post('to_num')){
			$this->input->post('from_num')==""?$num=$this->input->post('to_num'):$num=$this->input->post('from_num');
			$this->db->where('blood_unit_num',$num);
		}	
	
		$this->db->select("
			blood_unit_num,blood_donor.donor_id,name,age,blood_group,phone,email,bag_type,volume,
			sex,weight,sbp,dbp,hb,address,donation_date,camp_name,location,bb_status.status,segment_num,
			(CASE WHEN replacement_patient_id = 0 THEN 'Vol' ELSE 'RD' END) donor_type "
		)
		->from('blood_donor')
		->join('bb_donation','blood_donor.donor_id=bb_donation.donor_id','left')
		->join('blood_donation_camp','bb_donation.camp_id=blood_donation_camp.camp_id','left')
		->join('blood_inventory','bb_donation.donation_id=blood_inventory.donation_id','left')
		->join('bb_status','blood_inventory.status_id=bb_status.status_id','left')
	   //     ->where('YEAR(bb_donation.donation_date)', date('Y'))
		/**
		* Multi hospital support
		* 
		* Added By : Pranay On 20170521
		*/
		->where('blood_donor.hospital_id', $hospital)
		->group_by('bb_donation.donation_id')
		->order_by('donation_date ASC,blood_unit_num ASC')
        ->limit(1000);
		if($query=$this->db->get()){
			return $query->result();
		}
		else
		{
			return false;	
		}
	}// get_donors
		
		
    function get_invite_donors() {

		//$userdata=$this->session->userdata('hospital');
		//$hospital=$userdata['hospital_id'];
		if($this->input->post('blood_group')){
			$this->db->where('blood_group',$this->input->post('blood_group'));
		}
		if($this->input->post('donation_date')){
			$this->db->where('donation_date <=',$this->input->post('donation_date'));
		}
		if($this->input->post('camp_id')!=""){
			$this->db->where('bb_donation.camp_id',$this->input->post('camp_id'));
		}
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$this->db->where('(donation_date BETWEEN "'.date("Y-m-d",strtotime($this->input->post('from_date'))).'" AND "'.date('Y-m-d',strtotime($this->input->post('to_date'))).'")');
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')==""?$date=date("Y-m-d",strtotime($this->input->post('to_date'))):$date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$this->db->where('donation_date',$date);

		}
		$hospital=$this->session->userdata('hospital');
		$hospital_id=$hospital['hospital_id'];
		
		$this->db->select("
			blood_unit_num,blood_donor.donor_id,name,age,blood_group,phone,email,sex,address,donation_date,camp_name,location"
		)
		->from('blood_donor')
		->join('bb_donation','blood_donor.donor_id=bb_donation.donor_id','left')
		->join('blood_donation_camp','bb_donation.camp_id=blood_donation_camp.camp_id','left')
		/**
		* Multi hospital support
		* 
		* Added By : Pranay On 20170521
		*/
		->where('blood_donor.hospital_id', $hospital_id)
		->limit(60);
	
		if($query=$this->db->get())
		{
			return $query->result();		
		}
		
		else
		{
			return false;
			
		}
		
	}// get_invite_donors
	function get_components() {
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$this->db->where('(donation_date BETWEEN "'.date("Y-m-d",strtotime($this->input->post('from_date'))).'" AND "'.date("Y-m-d",strtotime($this->input->post('to_date'))).'")');
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')==""?$date=date("Y-m-d",strtotime($this->input->post('to_date'))):$date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$this->db->where('donation_date',$date);
		}
		else{
			$from_date=date('Y-m-1');
			$to_date=date('Y-m-d');
			$this->db->where("(donation_date BETWEEN '$from_date' AND '$to_date')");
		}
		if($this->input->post('blood_group')){
			$this->db->where('blood_group',$this->input->post('blood_group'));
		}
		if($this->input->post('from_num') && $this->input->post('to_num')){
			$from_num=trim($this->input->post('from_num'));
			$to_num=trim($this->input->post('to_num'));
			$this->db->where("(blood_unit_num BETWEEN $from_num AND $to_num)");
		}
		else if($this->input->post('from_num') || $this->input->post('to_num')){
			$this->input->post('from_num')==""?$num=$this->input->post('to_num'):$num=$this->input->post('from_num');
			$this->db->where('blood_unit_num',$num);
		}
	
		$hospital=$this->session->userdata('hospital');
		$hospital_id=$hospital['hospital_id'];
		$this->db->select("
			blood_unit_num,blood_donor.donor_id,name,blood_group,donation_date,bb_status.status,expiry_date,component_type,blood_inventory.datetime components_date,
			(CASE WHEN bb_donation.status_id=6 THEN test_hiv ELSE NULL END) test_hiv,
			(CASE WHEN bb_donation.status_id=6 THEN test_hbsag ELSE NULL END) test_hbsag,
			(CASE WHEN bb_donation.status_id=6 THEN test_vdrl ELSE NULL END) test_vdrl,
			(CASE WHEN bb_donation.status_id=6 THEN test_hcv ELSE NULL END) test_hcv,
			(CASE WHEN bb_donation.status_id=6 THEN test_mp ELSE NULL END) test_mp,
			(CASE WHEN bb_donation.status_id=6 THEN test_irregular_ab ELSE NULL END) test_irregular_ab,
			volume,segment_num,DATE(screening_datetime)screening_datetime,blood_issue.issue_id,issue_date"
		)
		->from('blood_donor')
		->join('bb_donation','blood_donor.donor_id=bb_donation.donor_id','left')
		->join('blood_donation_camp','bb_donation.camp_id=blood_donation_camp.camp_id','left')
		->join('blood_inventory','bb_donation.donation_id=blood_inventory.donation_id','left')
		->join('blood_screening','bb_donation.donation_id=blood_screening.donation_id','left')
		->join('bb_issued_inventory','blood_inventory.inventory_id=bb_issued_inventory.inventory_id','left')
		->join('blood_issue','bb_issued_inventory.issue_id=blood_issue.issue_id','left')
		->join('bb_status','blood_inventory.status_id=bb_status.status_id','left')
		/**
		* Multi hospital support
		* 
		* Added By : Pranay On 20170521
		*/
		->where('blood_donor.hospital_id', $hospital_id)
		->group_by('blood_inventory.inventory_id')
		->order_by('donation_date asc,blood_unit_num ASC');
		if($query=$this->db->get()){
			return $query->result();
		}	
		else
		{
			return false;
		}
	}// get_components

	function send_sms_email_invite() {
		$sms = $this->input->post('sms');
	    $email = $this->input->post('email');
		$donor_ids=$this->input->post('donor_ids');
	
		$this->db->trans_start();
		$this->db->select('blood_donor.phone, blood_donor.name, blood_donor.blood_group, blood_donor.email, bb_donation.donation_date')
			->from('blood_donor')
			->join('bb_donation','bb_donation.donor_id = blood_donor.donor_id','left')
			->where_in('bb_donation.donation_id',$donor_ids);
		$query = $this->db->get();
		$donor_info = $query->result();
		$this->db->trans_complete();
		$number_message = array();
		if($sms=='sms'){

			foreach($donor_info as $donor)
			{
				if($donor->phone!='')
				{
					$number_message[]=$donor->phone.'^'
						."Requesting donation of  $donor->blood_group blood for a patient in need. Please call IRCS(040-27633087) to donate.";
				}
			}

			$number_message_string = implode('~',$number_message);
			//Send SMS
			$url = "http://www.smsstriker.com/API/multi_messages.php?";
			$data = array('username'=>'ucdsyousee',
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
		
		}
		/*
			if($email=='email'){
				
				$this->load->library('email');
				foreach($donor_info as $row){
				$to=$row->email;
				$subject="Acknowledgement - Blood Donation slot booked.";
				$body="
				<div style='width:90%;padding:5px;margin:5px;font-style:\"Trebuchet MS\";border:1px solid #eee;'>
				<p>Dear $row->name,</p>
				<p></p>
				
				<p>
				For any further details, you can reply to this email or 
				call us at 040-27633087.
				</p>
				<p>
				From,<br />
				Blood Bank,<br />
				<br />
				Warangal,<br />
				Indian Red Cross Society - AP State Branch.<br />
				</p>
				</div>";
				$data['msg']="Thank you $row->name. 
				You will recieve an email with the blood donation slot details.
				Hope to see you at the BloodBank located at Warangal.";
				}
				$this->email->from('gokulakrishna@yousee.in', 'Indian Red Cross Society - Warangal Blood Bank');
				$config['smtp_pass'] = "gokul@Yousee";
				$this->email->to($to);
				$this->email->bcc("contact@yousee.in");
				$this->email->subject($subject);
				$this->email->message($body);
				$this->email->initialize($config);

				if ( ! $this->email->send()) {
					show_error($this->email->print_debugger());
				} 
				
				
			
				
			} */
	}// send_sms_email_invite
	
	/* get_booked_appointments() : Generate the report of the appointments booked in a given period of time. Defaults to last 10 days. */

    function get_booked_appointments() {

		$userdata=$this->session->userdata('hospital');
		$hospital=$userdata['hospital_id'];
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date('Y-m-d',strtotime($this->input->post('from_date')));
			$to_date=date('Y-m-d',strtotime($this->input->post('to_date')));
			$this->db->where("(bb_slot.date BETWEEN '$from_date' AND '$to_date')");
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')==""?$date=date("Y-m-d",strtotime($this->input->post('to_date'))):$date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$this->db->where('bb_slot.date',$date);
		}
		else{
			$from_date=date('Y-m-d',strtotime('-10 Days'));
			$to_date=date('Y-m-d');
			$this->db->where("(bb_slot.date BETWEEN '$from_date' AND '$to_date')");	
		}		
		$this->db->select('*')
			->from('bb_appointment')
			->join('bb_slot','bb_appointment.slot_id=bb_slot.slot_id')
			->join('blood_donor','bb_appointment.donor_id=blood_donor.donor_id')
			->where('bb_appointment.hospital_id',$hospital)
			->order_by('bb_slot.date');
		$query=$this->db->get();
		return $query->result();
	}// get_booked_appointments
	
	/* get_donated_blood() : Generate the detailed report of the donations made in a given period of time. Defaults to last 30 days. */

	function get_donated_blood($camp="t",$blood_group=0,$sex=0,$donation_date=0,$from_date=0,$to_date=0){

		$userdata=$this->session->userdata('hospital');
		$hospital=$userdata['hospital_id'];
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from=date('Y-m-d',strtotime($this->input->post('from_date')));
			$to=date('Y-m-d',strtotime($this->input->post('to_date')));
			$this->db->where("(DATE(bb_donation.donation_date) BETWEEN '$from' AND '$to')");
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
		 $this->input->post('from_date')==""?$date=date("Y-m-d",strtotime($this->input->post('to_date'))):$date=date("Y-m-d",strtotime($this->input->post('from_date')));
		 $this->db->where('DATE(bb_donation.donation_date)',$date);
		}
		else if($from_date!="0" && $to_date!="0"){
			$from_date=date('Y-m-d',strtotime($from_date));
			$to_date=date('Y-m-d',strtotime($to_date));
			$this->db->where("(DATE(bb_donation.donation_date) BETWEEN '$from_date' AND '$to_date')");
		}
		else if($from_date!="0" || $to_date!="0"){
		 $from_date=="0"?$date=$to_date:$date=$from_date;
		 $this->db->where('DATE(bb_donation.donation_date)',$date);
		}
		else{
			$from=date('Y-m-d',strtotime('-10 Days'));
			$to=date('Y-m-d');
			$this->db->where("(donation_date BETWEEN '$from' AND '$to')");
		 }
		if($this->input->post('from_num') && $this->input->post('to_num')){
			$from_num=trim($this->input->post('from_num'));
			$to_num=trim($this->input->post('to_num'));
			$this->db->where("(blood_unit_num BETWEEN '$from_num' AND '$to_num')");
		}
		else if($this->input->post('from_num') || $this->input->post('to_num')){
		 $this->input->post('from_num')==""?$num=$this->input->post('to_num'):$num=$this->input->post('from_num');
		 $this->db->where('blood_unit_num',$num);
		}
		if($camp!="t"){
			if($camp=="c"){
				$this->db->where('bb_donation.camp_id !=',0);
			}
			else{
			$this->db->where('bb_donation.camp_id',$camp);
			}
		}
		if($this->input->post('camp')){
			$this->db->where('bb_donation.camp_id',$this->input->post('camp'));
		}
		if($blood_group!="0"){
			$blood_group=str_replace("pos","+",$blood_group);
			$blood_group=str_replace("neg","-",$blood_group);
			$this->db->where('blood_group',$blood_group);
		}
		if($sex!="0"){
			$this->db->where('sex',$sex);
		}
		if($donation_date!="0"){
			$this->db->where('donation_date',$donation_date);
		}
		$this->db->select('blood_unit_num,donation_date,name,blood_group,screening_result,camp_name,d_status.status_id as donation_status_id, d_status.status as donation_status,i_status.status_id as inv_status_id, i_status.status as inv_status')
		->from('bb_donation')
		->join('blood_inventory','bb_donation.donation_id=blood_inventory.donation_id')
		->join('blood_donor','bb_donation.donor_id=blood_donor.donor_id')
		->join('blood_donation_camp','bb_donation.camp_id=blood_donation_camp.camp_id','left')
		->join('bb_status d_status','bb_donation.status_id=d_status.status_id')
		->join('bb_status i_status','blood_inventory.status_id=i_status.status_id')
		->where('bb_donation.status_id >=',5)
	//	->where('bb_donation.hospital_id',$hospital)
		/**
		* Multi hospital support
		* 
		* Added By : Pranay On 20170521
		*/
		->where('bb_donation.hospital_id', $hospital)
		->group_by('bb_donation.donation_id')
		->order_by('blood_unit_num','desc');
		$query=$this->db->get();
		return $query->result();
	}// get_donated_blood

	/* get_inventory() : Generate the report of the inventory at a given period of time or a range of donor numbers. */
	
	function get_inventory($blood_group=0,$component_type=0){

		$userdata=$this->session->userdata('hospital');
		$hospital=$userdata['hospital_id'];
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from=date('Y-m-d',strtotime($this->input->post('from_date')));
			$to=date('Y-m-d',strtotime($this->input->post('to_date')));
			$this->db->where("(DATE(bb_donation.donation_date) BETWEEN '$from' AND '$to')");
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')==""?$date=date("Y-m-d",strtotime($this->input->post('to_date'))):$date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$this->db->where('DATE(bb_donation.donation_date)',$date);
		}	
		if($this->input->post('from_num') && $this->input->post('to_num')){
			$from_num=trim($this->input->post('from_num'));
			$to_num=trim($this->input->post('to_date'));
			$this->db->where("blood_unit_num BETWEEN '$from_num' AND '$to_num'");
		}
		else if($this->input->post('from_num') || $this->input->post('to_num')){
			$this->input->post('from_num')==""?$num=$this->input->post('to_num'):$num=$this->input->post('from_num');
			$this->db->where('blood_unit_num',$num);
		}
		else{
			$this->db->where('bb_donation.status_id',6);
			$this->db->where('bb_donation.screening_result',1);
			$this->db->where('blood_inventory.status_id',7);
		}
		if($blood_group!="0"){
			$blood_group=str_replace("pos","+",$blood_group);
			$blood_group=str_replace("neg","-",$blood_group);
			$this->db->where('blood_group',$blood_group);
		}
		if($component_type=="1"){
			$this->db->where_in('component_type',array("FFP","FP","Platelet Concentrate","PRP","Cryo"));
		}			
		else if($component_type!="0"){
			$this->db->where('component_type',$component_type);
		}
		else{
			$this->db->where_in('component_type',array("WB","PC"));
		}
		$this->db->select('blood_unit_num,donation_date,expiry_date,component_type,bag_type,blood_group,screening_result,d_status.status_id as donation_status_id, d_status.status as donation_status,i_status.status_id as inv_status_id, i_status.status as inv_status')
			->from('bb_donation')
			->join('blood_inventory','bb_donation.donation_id=blood_inventory.donation_id','left')
			->join('blood_donor','bb_donation.donor_id=blood_donor.donor_id','left')
			->join('blood_donation_camp','bb_donation.camp_id=blood_donation_camp.camp_id','left')
			->join('bb_status d_status','bb_donation.status_id=d_status.status_id','left')
			->join('bb_status i_status','blood_inventory.status_id=i_status.status_id','left')
			->where('blood_inventory.status_id !=',10)
				/**
				* Multi hospital support
				* 
				* Added By : Pranay On 20170521
				*/
			->where('bb_donation.hospital_id',$hospital)
			->group_by('blood_inventory.inventory_id')
			->order_by('blood_unit_num');
		$query=$this->db->get();
		return $query->result();
	}// get_inventory

	/* get_screened_blood() : Generate the report of the screening done in a given period of time or a donor number range. */
    function get_discard_report(){
		$userdata=$this->session->userdata('hospital');
		$hospital=$userdata['hospital_id'];
			
		if($this->input->post('blood_unit_num')){
			$this->db->where('blood_unit_num',$this->input->post('blood_unit_num'));
		}
		else{
			$this->db->where('blood_inventory.status_id',7);
		}
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from=date('Y-m-d',strtotime($this->input->post('from_date')));
			$to=date('Y-m-d',strtotime($this->input->post('to_date')));
			$this->db->where("(DATE(blood_inventory.expiry_date) BETWEEN '$from' AND '$to')");
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
		 $this->input->post('from_date')==""?$date=date("Y-m-d",strtotime($this->input->post('to_date'))):$date=date("Y-m-d",strtotime($this->input->post('from_date')));
		 $this->db->where('DATE(blood_inventory.expiry_date)',$date);
		}
		$this->db->select('blood_unit_num,component_type,blood_group,expiry_date,bb_donation.donation_id,blood_unit_num,bb_donation.status_id as donation_status,d_status.status as don_status,i_status.status as inv_status,screening_result,inventory_id, blood_inventory.notes')
			->from('blood_inventory')
			->join('bb_donation','blood_inventory.donation_id=bb_donation.donation_id')
			->join('blood_donor','bb_donation.donor_id=blood_donor.donor_id')
			->join('bb_status d_status','bb_donation.status_id=d_status.status_id')
			->join('bb_status i_status','blood_inventory.status_id=i_status.status_id')
			->where('blood_inventory.status_id !=',10)
		//	->where('bb_donation.hospital_id',$hospital)
			/**
			* Multi hospital support
			* 
			* Added By : Pranay On 20170521
			*/
			->where('blood_inventory.hospital_id', $hospital)
			->order_by('component_type, blood_inventory.expiry_date')
			->limit(3000);
		$query=$this->db->get();
		return $query->result();
	}// get_discard_report

	function get_screened_blood(){

		$userdata=$this->session->userdata('hospital');
		$hospital=$userdata['hospital_id'];
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date('Y-m-d',strtotime($this->input->post('from_date')));
			$to_date=date('Y-m-d',strtotime($this->input->post('to_date')));
			$this->db->where("(DATE(blood_screening.screening_datetime) BETWEEN '$from_date' AND '$to_date')");
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
		 $this->input->post('from_date')==""?$date=date("Y-m-d",strtotime($this->input->post('to_date'))):$date=date("Y-m-d",strtotime($this->input->post('from_date')));
		 $this->db->where('DATE(blood_screening.screening_datetime)',$date);
		}
		if($this->input->post('from_num') && $this->input->post('to_num')){
			$from_num=trim($this->input->post('from_num'));
			$to_num=trim($this->input->post('to_date'));
			$this->db->where("blood_unit_num BETWEEN '$from_num' AND '$to_num')");
		}
		else if($this->input->post('from_num') || $this->input->post('to_num')){
			$this->input->post('from_num')==""?$num=$this->input->post('to_num'):$num=$this->input->post('from_num');
			$this->db->where('blood_unit_num',$num);
		}	
		if($this->input->post('screened_by')){
			$this->db->where('staff_id',$this->input->post('screened_by'));
		}
		$this->db->select('*')
		->from('bb_donation')
		->join('blood_screening','bb_donation.donation_id=blood_screening.donation_id')
		->join('blood_donor','bb_donation.donor_id=blood_donor.donor_id')
		->join('(SELECT staff_id,CONCAT(first_name," ",last_name) AS staff_name FROM staff) staff','blood_screening.screened_by=staff.staff_id')
		->where('status_id',6)
	//	->where('bb_donation.hospital_id',$hospital)
		/**
		* Multi hospital support
		* 
		* Added By : Pranay On 20170521
		*/
		->where('bb_donation.hospital_id', $hospital)
		->order_by('screening_datetime','desc')
		->limit('300');
		$query=$this->db->get();
		return $query->result();
	}// get_screened_blood
	
	/* get_issues() : Generate the report of the issues made in a given period of time. Defaults to last 10 days. */
        // user panel controller is calling this method
	function get_issues($issue_date,$blood_group,$from_date,$to_date,$hospital=0){

		$userdata=$this->session->userdata('hospital');
		$hospital_id=$userdata['hospital_id'];
		if(empty($from_date))
			$from_date = $this->input->post('from_date');
		if(empty($to_date))
			$to_date = $this->input->post('to_date');
		if(!empty($from_date) && !empty($to_date)){
			$from_date=date('Y-m-d',strtotime($from_date));
			$to_date=date('Y-m-d',strtotime($to_date));
			$this->db->where("(DATE(blood_issue.issue_date) BETWEEN '$from_date' AND '$to_date')");
		}
		else if(!empty($from_date) || !empty($to_date)){
			empty($from_date)?$date=date("Y-m-d",strtotime($to_date)):$date=date("Y-m-d",strtotime($from_date));
			$this->db->where('DATE(blood_issue.issue_date)',$date);
		}
		else{
			$from_date=date("Y-m-d",strtotime("-10 Days"));
			$this->db->where("DATE(blood_issue.issue_date) > '$from_date'");
		}
        if($hospital!="0"){
			$this->db->having("blood_request_hospital = $hospital");
		}
		if($this->input->post('from_num') && $this->input->post('to_num')){
			$from_num=trim($this->input->post('from_num'));
			$to_num=trim($this->input->post('to_date'));
			$this->db->where("blood_unit_num BETWEEN '$from_num' AND '$to_num')");
		}
		else if($this->input->post('from_num') || $this->input->post('to_num')){
		 $this->input->post('from_num')==""?$num=$this->input->post('to_num'):$num=$this->input->post('from_num');
		 $this->db->where('blood_unit_num',$num);
		}	
		if($this->input->post('issued_by')){
			$this->db->where('issued_staff.staff_id',$this->input->post('issued_by'));
		}
		if($issue_date!='0'){
			$this->db->where('issue_date',$issue_date);
		}
			
		if($blood_group!='0'){
			$blood_group=str_replace("pos","+",$blood_group);
			$blood_group=str_replace("neg","-",$blood_group);
			$this->db->where('blood_donor.blood_group',$blood_group);
		}
		$this->db->select('blood_donor.donor_id,blood_donor.name,blood_donor.blood_group,blood_donor.sub_group,patient.address,blood_request.diagnosis,donation_date,blood_issue.issue_id, issue_date,issue_time,request_type,patient.first_name,patient.last_name,blood_request.patient_name, bb_donation.blood_unit_num, bb_donation.segment_num, blood_inventory.component_type, blood_inventory.volume, blood_request.blood_group as recipient_blood_group, issued_staff_name, cross_matched_staff_name, patient_visit.final_diagnosis,
		(CASE WHEN out_hosptial.hospital_id !="" THEN out_hosptial.hospital_id ELSE in_hosptial.hospital_id END) as hosptial_id,
		(CASE WHEN out_hosptial.hospital_id !="" THEN out_hosptial.hospital ELSE in_hosptial.hospital END) as hosptial,
		 issued_staff_name, cross_matched_staff_name, patient_visit.final_diagnosis,
		 (CASE WHEN blood_request.request_hospital_id != 0 THEN blood_request.request_hospital_id ELSE patient_visit.hospital_id END) as blood_request_hospital')
		->from('blood_inventory')
		->join('bb_donation','blood_inventory.donation_id=bb_donation.donation_id','left')
		->join('blood_donor','bb_donation.donor_id=blood_donor.donor_id','left')
		->join('bb_issued_inventory','blood_inventory.inventory_id=bb_issued_inventory.inventory_id','left')
		->join('blood_issue','bb_issued_inventory.issue_id=blood_issue.issue_id','left')
		->join('blood_request','blood_issue.request_id=blood_request.request_id','left')
		->join('patient_visit','patient_visit.patient_id=blood_request.patient_id','left')
        ->join('patient','patient.patient_id=blood_request.patient_id','left')                
		->join('hospital out_hosptial','blood_request.request_hospital_id=out_hosptial.hospital_id','left')
		->join('hospital in_hosptial','patient_visit.hospital_id=in_hosptial.hospital_id','left')
		->join('(SELECT staff_id,CONCAT(first_name," ",last_name) AS issued_staff_name FROM staff) issued_staff','blood_issue.issued_by=issued_staff.staff_id', 'left')
		->join('(SELECT staff_id,CONCAT(first_name," ",last_name) AS cross_matched_staff_name FROM staff) cross_matched_staff','blood_issue.cross_matched_by=cross_matched_staff.staff_id', 'left') 
		->where('blood_inventory.status_id',8)
	/*	->where('bb_donation.hospital_id',$hospital) */
        /**
		* Multi hospital support
		* 
		* Added By : Pranay On 20170521
		*/
		->where('blood_inventory.hospital_id', $hospital_id)
		->order_by('issue_date DESC,issue_time DESC')
                 ->limit(3000);
		$query=$this->db->get();

		return $query->result();
	}// get_issues
	
	/* get_grouped_blood() : Generate the report of the blood grouping done in a given period of time or a range of donor numbers.*/
	
	function get_grouped_blood(){

		$userdata=$this->session->userdata('hospital');
		$hospital=$userdata['hospital_id'];

		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date('Y-m-d',strtotime($this->input->post('from_date')));
			$to_date=date('Y-m-d',strtotime($this->input->post('to_date')));
			$this->db->where("grouping_date BETWEEN '$from_date' AND '$to_date'");
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')==""?$date=date("Y-m-d",strtotime($this->input->post('to_date'))):$date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$this->db->where('grouping_date',$date);
		}
		if($this->input->post('from_num') && $this->input->post('to_num')){
			$from_num=trim($this->input->post('from_num'));
			$to_num=trim($this->input->post('to_date'));
			$this->db->where("blood_unit_num BETWEEN '$from_num' AND '$to_num')");
		}
		else if($this->input->post('from_num') || $this->input->post('to_num')){
			$this->input->post('from_num')==""?$num=$this->input->post('to_num'):$num=$this->input->post('from_num');
			$this->db->where('blood_unit_num',$num);
		}	
		if($this->input->post('grouped_by')){
			$this->db->where('foward_done_by',$this->input->post('grouped_by'));
			$this->db->or_where('reverse_done_by',$this->input->post('grouped_by'));
		}
		$this->db->select('*')
		->from('bb_donation')
		->join('blood_grouping','bb_donation.donation_id=blood_grouping.donation_id')
		->join('blood_donor','bb_donation.donor_id=blood_donor.donor_id')
		->join('(SELECT staff_id as forward_staff_id,CONCAT(first_name," ",last_name) as forward_done_by FROM staff) as forward_staff','blood_grouping.forward_done_by=forward_staff.forward_staff_id')
		->join('(SELECT staff_id as reverse_staff_id, CONCAT(first_name," ",last_name) as reverse_done_by FROM staff) as reverse_staff','blood_grouping.reverse_done_by=reverse_staff.reverse_staff_id')
	//	->where('bb_donation.hospital_id',$hospital)
		/**
		* Multi hospital support
		* 
		* Added By : Pranay On 20170521
		*/
		->where('bb_donation.hospital_id', $hospital)
		->order_by('grouping_date','DESC')
        ->limit(1200);
		$query=$this->db->get();
		return $query->result();
	}// get_grouped_blood
	
	/* get_hospital_issue_summary() : Generate the summary report of the issues made to different hospital in a given period of time. Defaults to last 30 days. */

	function get_hospital_issue_summary() {

		$userdata=$this->session->userdata('hospital');
		$hospital=$userdata['hospital_id'];

		//If from date and to date are given, get the values between those dates.
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$this->db->where('(issue_date BETWEEN "'.date("Y-m-d",strtotime($this->input->post('from_date'))).'" AND "'.date("Y-m-d",strtotime($this->input->post('to_date'))).'")');
		}
		//If from date OR to date are given, get the values on the given date.
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->db->where('issue_date',$date);
			$this->input->post('from_date')==""?$date=date("Y-m-d",strtotime($this->input->post('to_date'))):$date=date("Y-m-d",strtotime($this->input->post('from_date')));
		}
		//Default : Last 30 days.
		 else{
			$from_date=date('Y-m-d',strtotime('-30 Days'));
			$to_date=date('Y-m-d');
			$this->db->where("(issue_date BETWEEN '$from_date' AND '$to_date')");
		 }
		$this->db->select('
			(CASE WHEN out_hospital.hospital_id != "" THEN out_hospital.hospital_id ELSE in_hospital.hospital_id END) "hospital_id",
			(CASE WHEN out_hospital.hospital_id != "" THEN out_hospital.hospital ELSE in_hospital.hospital END) "hospital",
			SUM(CASE WHEN sex="m" THEN 1 ELSE 0 END) "male",
			SUM(CASE WHEN sex="f" THEN 1 ELSE 0 END) "female",
			SUM(CASE WHEN 1 THEN 1 ELSE 0 END) "total",
			SUM(CASE WHEN blood_donor.blood_group="A+" THEN 1 ELSE 0 END) "Apos",
			SUM(CASE WHEN blood_donor.blood_group="A-" THEN 1 ELSE 0 END) "Aneg",
			SUM(CASE WHEN blood_donor.blood_group="B+" THEN 1 ELSE 0 END) "Bpos",
			SUM(CASE WHEN blood_donor.blood_group="B-" THEN 1 ELSE 0 END) "Bneg",
			SUM(CASE WHEN blood_donor.blood_group="AB+" THEN 1 ELSE 0 END) "ABpos",
			SUM(CASE WHEN blood_donor.blood_group="AB-" THEN 1 ELSE 0 END) "ABneg",
			SUM(CASE WHEN blood_donor.blood_group="O+" THEN 1 ELSE 0 END) "Opos",
			SUM(CASE WHEN blood_donor.blood_group="O-" THEN 1 ELSE 0 END) "Oneg"
		')
		->from('blood_donor')
		->join('bb_donation','blood_donor.donor_id=bb_donation.donor_id','left')
		->join('blood_inventory','bb_donation.donation_id=blood_inventory.donation_id','left')
		->join('bb_issued_inventory','blood_inventory.inventory_id=bb_issued_inventory.inventory_id','left')
		->join('blood_issue','bb_issued_inventory.issue_id=blood_issue.issue_id','left')
		->join('blood_request','blood_issue.request_id=blood_request.request_id','left')
		->join('hospital out_hospital','blood_request.request_hospital_id=out_hospital.hospital_id','left')
		->join('patient_visit','patient_visit.patient_id = blood_request.patient_id','left')
		->join('hospital in_hospital','patient_visit.hospital_id=in_hospital.hospital_id','left')
		->where('blood_inventory.status_id',8)
	   // ->where('bb_donation.hospital_id',$hospital)
		/**
		* Multi hospital support
		* 
		* Added By : Pranay On 20170521
		*/
		->where('blood_donor.hospital_id', $hospital)
		->group_by("hospital_id")
		->order_by('hospital','asc');

		if($query=$this->db->get()){
			return $query->result();
		}
	   else
	   {
	     return false;	
	   }
	}// get_hospital_issue_summary

	function get_discard_inventory_detail($from_date=0,$to_date=0){                /*Model function for discard summary*/                             

		$userdata=$this->session->userdata('hospital');         
		$hospital=$userdata['hospital_id']; 
        if($this->input->post('from_date') && $this->input->post('to_date')){
			$from=date('Y-m-d',strtotime($this->input->post('from_date')));
			$to=date('Y-m-d',strtotime($this->input->post('to_date')));
			$this->db->where("(DATE(blood_inventory.expiry_date) BETWEEN '$from' AND '$to')");
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$this->input->post('from_date')==""?$date=date("Y-m-d",strtotime($this->input->post('to_date'))):$date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$this->db->where('DATE(blood_inventory.expiry_date)',$date);
		}
		else if($from_date!="0" && $to_date!="0"){
			$from_date=date('Y-m-d',strtotime($from_date));
			$to_date=date('Y-m-d',strtotime($to_date));
			$this->db->where("(DATE(blood_inventory.expiry_date) BETWEEN '$from_date' AND '$to_date')");
		}
		else if($from_date!="0" || $to_date!="0"){
			$from_date=="0"?$date=$to_date:$date=$from_date;
			$this->db->where('DATE(blood_inventory.expiry_date)',$date);
		}
		else{
			$from=date('Y-m-d',strtotime('-30 Days'));
			$to=date('Y-m-d');
			$this->db->where("(donation_date BETWEEN '$from' AND '$to')");
		 }
       
		$this->db->select("                                 
			blood_group,
			SUM(CASE WHEN component_type='PRP' THEN 1 ELSE 0 END) prp, 
			SUM(CASE WHEN component_type='Platelet Concentrate' THEN 1 ELSE 0 END) platelet_concentrate,
			SUM(CASE WHEN component_type='PC' THEN 1 ELSE 0 END) pc,
			SUM(CASE WHEN component_type='WB' THEN 1 ELSE 0 END) wb,
			SUM(CASE WHEN component_type='Cryo' THEN 1 ELSE 0 END) cryo,
			SUM(CASE WHEN component_type='FP' THEN 1 ELSE 0 END) fp,
			SUM(CASE WHEN component_type='FFP' THEN 1 ELSE 0 END) ffp"
		)                                       /*selecting the component types*/
		->from('bb_donation')                           /*query for discarded blood*/
        ->join('blood_grouping', 'blood_grouping.donation_id = bb_donation.donation_id')
		->join('blood_inventory','bb_donation.donation_id=blood_inventory.donation_id') 
		->where('blood_inventory.status_id',9)       /*status id =9 for discarded blood*/
        ->where('bb_donation.screening_result',0) 
		//->where('bb_donation.hospital_id',$hospital)
		/**
		* Multi hospital support
		* 
		* Added By : Pranay On 20170521
		*/
		->where('bb_donation.hospital_id', $hospital)
		->where('expiry_date>=',date("Y-m-d"),false)
		->group_by('blood_group');
		if($query=$this->db->get()){
			return $query->result();      /*returning result for query*/
		}
		else
	   {
	     return false;	
	   }
	}// get_discard_inventory_detail
}// Reports_model
?>