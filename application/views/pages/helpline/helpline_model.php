<?php
class Helpline_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function insert_call(){
		$callsid=$this->input->get('CallSid');
		$from_number = $this->input->get('From');
		$to_number = $this->input->get('To');
		$direction = $this->input->get('Direction');
		$dial_call_duration = $this->input->get('DialCallDuration');
		$start_time = $this->input->get('StartTime');
		$current_server_time = $this->input->get('CurrentTime');
		$end_time = $this->input->get('EndTime');
		$call_type = $this->input->get('CallType');
		$recording_url = $this->input->get('RecordingUrl');
		$dial_whom_number = $this->input->get('DialWhomNumber');

		$hospital_id = 0;
		$helpline_category = 0;
		$helpline_caller_type = 0;
		$visit_type = "";
		$resolution_status = 0;
		$resolution_date_time = 0;
		if($call_type == 'voicemail'){
			$this->db->select('*')->from('helpline_numbers')->where('number',$to_number);
			$query = $this->db->get();
			$result = $query->row();
			$hospital_id = $result->hospital_id;
			$helpline_category = $result->helpline_category;
			$helpline_caller_type = $result->caller_type;
			$visit_type = $result->visit_type;
			$resolution_status = $result->resolution_status;
			$resolution_date_time = date("Y-m-d H:i:s");
		}
		$data = array(
			'callsid'=>$callsid,
			'from_number' => $from_number,
			'to_number' => $to_number,
			'direction' => $direction,
			'dial_call_duration' => $dial_call_duration,
			'start_time' => $start_time,
			'current_server_time' => $current_server_time,
			'end_time' => $end_time,
			'call_type' => $call_type,
			'recording_url' => $recording_url,
			'dial_whom_number' => $dial_whom_number,
			'create_date_time' => date("Y-m-d H:i:s"),
			'hospital_id' => $hospital_id,
			'call_category_id' => $helpline_category,
			'caller_type_id' => $helpline_caller_type,
			'ip_op' => $visit_type,
			'resolution_status_id' => $resolution_status,
			'resolution_date_time' => $resolution_date_time
		);

		if($this->db->insert('helpline_call',$data)){
			return true;
		}
		else return false;
	}
	function insert_outbound_call(){
		$callsid=$this->input->post('CallSid');
		$from_number = $this->input->post('From');
		$to_number = $this->input->post('To');
		$direction = $this->input->post('Direction');
		$dial_call_duration = $this->input->post('Duration');
		$start_time = $this->input->post('StartTime');
		$end_time = $this->input->post('EndTime');
		$call_type = "Out-going";
		$recording_url = $this->input->post('RecordingUrl');
		$dial_whom_number = $this->input->post('DialWhomNumber');
		$data = array(
			'callsid'=>$callsid,
			'from_number' => $from_number,
			'to_number' => $to_number,
			'direction' => $direction,
			'dial_call_duration' => $dial_call_duration,
			'start_time' => $start_time,
			'end_time' => $end_time,
			'call_type' => $call_type,
			'recording_url' => $recording_url,
			'dial_whom_number' => $from,
			'create_date_time' => date("Y-m-d H:i:s")
		);

		if($this->db->insert('helpline_call',$data)){
			return true;
		}
		else return false;
	}

	function update_call(){
		$calls = $this->input->post('call');
		$data=array();
		foreach($calls as $call){
			if(!!$this->input->post('resolution_date_'.$call) && !! $this->input->post('resolution_time_'.$call)){
				$resolution_date_time = date("Y-m-d H:i:s",strtotime($this->input->post('resolution_date_'.$call)." ".$this->input->post('resolution_time_'.$call)));
			}
			else $resolution_date_time = 0;
			echo $this->input->post('group_'.$call);
			$data[]=array(
				'call_id'=>$call,
				'caller_type_id'=>$this->input->post("caller_type_".$call),
				'call_category_id'=>$this->input->post("call_category_".$call),
				'resolution_status_id'=>$this->input->post("resolution_status_".$call),
				'hospital_id'=>$this->input->post("hospital_".$call),
				'ip_op'=>$this->input->post("visit_type_".$call),
				'visit_id'=>$this->input->post("visit_id_".$call),
				'note'=>$this->input->post("note_".$call),
				'call_group_id'=>$this->input->post("group_".$call),
				'resolution_date_time'=>$resolution_date_time,
				'updated'=>1
			);
		}
		$this->db->trans_start();
			$this->db->update_batch('helpline_call',$data,'call_id');
		$this->db->trans_complete();
		if($this->db->trans_status()===TRUE){
			return true;
		}
		else {
			$this->db->trans_rollback();
			return false;
		}

	}
	function send_email(){
		$this->load->library('email');
		$user = $this->session->userdata('logged_in');
		$call_date = $this->input->post('call_date');
		$to_email = $this->input->post('to_email');
		$cc_email = $this->input->post('cc_email');
		$greeting = $this->input->post('greeting');
		$phone_shared = $this->input->post('phone_shared');
		$note = $this->input->post('note');
		$call_id = $this->input->post('call_id_email');
		$patient = $this->input->post('patient');
		$caller_type = $this->input->post('caller_type');
		$from_number = $this->input->post('from_number');
		$call_category = $this->input->post('call_category');
		$hospital = $this->input->post('hospital');
		$recording = $this->input->post('recording');
		$from_name = "Hospital Helpline";
		if($to_email!=''){
		$subject="Helpline call #$call_id - ";
		if(!!$call_category) $subject .= $call_category." ";
		if(!!$hospital) $subject .= "from ".$hospital." ";
		if(!!$caller_type) $subject .= "by ".$caller_type." ";
		if(!!$patient) $subject .= "regarding ".$patient." ";
		if(!!$greeting){ $body = $greeting; } else $body = "Hi,";
		$body.="<br /><br />This call information from Hospital Helpline (040 - 39 56 53 39) is being escalated for your information and intervention.<br /><br />";
		$body.="<b>Call ID</b>: $call_id <br />";
		$body.="<b>Call Time</b>: ".date("d-M-Y, g:iA",strtotime($call_date))." <br />";
		$body.="<b>Call</b>: ";
		if(!!$call_category) $body .= $call_category." ";
		if(!!$hospital) $body .= "from ".$hospital." ";
		if(!!$caller_type) $body .= "by ".$caller_type." ";
		if(!!$phone_shared) $body.="(".$from_number.") ";
		if(!!$patient) $body .= "regarding ".$patient." ";
		$body.="<br />";
		$body.="<b>Call Information</b>: $note <br />";
		$body.="<b>Recording</b>: <a href=\"$recording\">Click Here</a><br /><br />";
		$body.="We request you to give your input regarding this call by calling the helpline 040 - 39 56 53 39 or by replying to this email.<br /><br />";
		$body.="With Regards, <br />Hospital Helpline Team";
		$mailbody="
		<div style='width:90%;padding:5px;margin:5px;font-style:\"Trebuchet MS\";border:1px solid #eee;'>
		<br />$body
		</div>";
		}
		$from = 'helpline@health4all.online';
		if(!!$from){
		$this->email->from("$from", "Hospital Helpline");
		$this->email->to($to_email);
		$this->email->cc($cc_email);
		$this->email->subject($subject);
		$this->email->message($mailbody);
		if ( ! $this->email->send()) {
			$this->email->print_debugger();
		}
		else{
			$this->email->clear(TRUE);
		}
		}
		$data=array(
			'call_id'=>$call_id,
			'to_email'=>$this->input->post("to_email"),
			'cc_email'=>$this->input->post("cc_email"),
			'greeting'=>$this->input->post("greeting"),
			'phone_shared'=>$this->input->post("phone_shared"),
			'note'=>$this->input->post("note"),
			'user_id'=>$user['user_id'],
			'email_date_time'=>date("Y-m-d H:i:s")
		);
		$this->db->trans_start();
			$this->db->insert('helpline_email',$data);
		$this->db->trans_complete();
		if($this->db->trans_status()===TRUE){
			return true;
		}
		else {
			$this->db->trans_rollback();
			return false;
		}

	}

	function get_emails(){
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$this->db->where('(DATE(start_time) BETWEEN "'.date("Y-m-d",strtotime($this->input->post('from_date'))).'" AND "'.date("Y-m-d",strtotime($this->input->post('to_date'))).'")');
		}
		else
			$this->db->where('DATE(start_time)',date("Y-m-d"));
		$this->db->select('helpline_email.*')->from('helpline_email')->join('helpline_call','helpline_email.call_id = helpline_call.call_id')
		->order_by('email_date_time','desc');
		$query = $this->db->get();
		return $query->result();
	}
	function get_calls(){
		if($this->input->post('date')){
			$this->db->where('DATE(start_time)',date("Y-m-d",strtotime($this->input->post('date'))));
		}
		else
			$this->db->where('DATE(start_time)',date("Y-m-d"));
		$this->db->select('helpline_call.*,group_name,caller_type,call_category,resolution_status,hospital')->from('helpline_call')
		->join('helpline_caller_type','helpline_call.caller_type_id = helpline_caller_type.caller_type_id','left')
		->join('helpline_call_category','helpline_call.call_category_id = helpline_call_category.call_category_id','left')
		->join('helpline_call_group','helpline_call.call_group_id = helpline_call_group.call_group_id','left')
		->join('helpline_resolution_status','helpline_call.resolution_status_id = helpline_resolution_status.resolution_status_id','left')
		->join('hospital','helpline_call.hospital_id = hospital.hospital_id','left')
		->where('from_number NOT IN (SELECT number FROM helpline_numbers)')
		->order_by('start_time','desc');
		$query = $this->db->get();
		return $query->result();
	}
	function get_voicemail_calls(){
		if($this->input->post('date')){
			$this->db->where('DATE(start_time)',date("Y-m-d",strtotime($this->input->post('date'))));
		}
		else
			$this->db->where('DATE(start_time)',date("Y-m-d"));
		$this->db->select('helpline_call.*,group_name,caller_type,call_category,resolution_status,hospital')->from('helpline_call')
		->join('helpline_numbers','helpline_call.from_number = helpline_numbers.number')
		->join('helpline_caller_type','helpline_call.caller_type_id = helpline_caller_type.caller_type_id','left')
		->join('helpline_call_category','helpline_call.call_category_id = helpline_call_category.call_category_id','left')
		->join('helpline_call_group','helpline_call.call_group_id = helpline_call_group.call_group_id','left')
		->join('helpline_resolution_status','helpline_call.resolution_status_id = helpline_resolution_status.resolution_status_id','left')
		->join('hospital','helpline_call.hospital_id = hospital.hospital_id','left')
		->where('from_number IN (SELECT number FROM helpline_numbers)')
		->order_by('start_time','desc');
		$query = $this->db->get();
		return $query->result();
	}
	function get_caller_type(){
		$this->db->select('*')->from('helpline_caller_type');
		$query = $this->db->get();
		return $query->result();
	}
	function get_call_category(){
		$this->db->select('*')->from('helpline_call_category');
		$query = $this->db->get();
		return $query->result();
	}
	function get_resolution_status(){
		$this->db->select('*')->from('helpline_resolution_status');
		$query = $this->db->get();
		return $query->result();
	}
	function get_hospital_district(){
		$this->db->select('DISTINCT district',false)->from('hospital')->order_by('district');
		$query = $this->db->get();
		return $query->result();
	}

	function get_detailed_report(){
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$this->db->where('(DATE(start_time) BETWEEN "'.date("Y-m-d",strtotime($this->input->post('from_date'))).'" AND "'.date("Y-m-d",strtotime($this->input->post('to_date'))).'")');
		}
		else
			$this->db->where('DATE(start_time)',date("Y-m-d"));
		$this->db->select('*,helpline_call.call_id,helpline_call.call_group_id, helpline_call.note,count(helpline_email_id) email_count')->from('helpline_call')
		->join('helpline_caller_type','helpline_call.caller_type_id = helpline_caller_type.caller_type_id','left')
		->join('helpline_call_category','helpline_call.call_category_id = helpline_call_category.call_category_id','left')
		->join('helpline_resolution_status','helpline_call.resolution_status_id = helpline_resolution_status.resolution_status_id','left')
		->join('helpline_call_group','helpline_call.call_group_id = helpline_call_group.call_group_id','left')
		->join('hospital','helpline_call.hospital_id = hospital.hospital_id','left')
		->join('helpline_email','helpline_call.call_id = helpline_email.call_id','left')
		->group_by('helpline_call.call_id')
		->where('from_number NOT IN (SELECT number FROM helpline_numbers)')		
		->order_by('start_time','desc');
		$query = $this->db->get();
		return $query->result();
	}
	function get_voicemail_detailed_report(){
			if($this->input->post('from_date') && $this->input->post('to_date')){
				$this->db->where('(DATE(start_time) BETWEEN "'.date("Y-m-d",strtotime($this->input->post('from_date'))).'" AND "'.date("Y-m-d",strtotime($this->input->post('to_date'))).'")');
			}
			else
				$this->db->where('DATE(start_time)',date("Y-m-d"));
			$this->db->select('*,helpline_call.call_id,helpline_call.call_group_id, helpline_call.note,count(helpline_email_id) email_count')->from('helpline_call')
			->join('helpline_caller_type','helpline_call.caller_type_id = helpline_caller_type.caller_type_id','left')
			->join('helpline_call_category','helpline_call.call_category_id = helpline_call_category.call_category_id','left')
			->join('helpline_resolution_status','helpline_call.resolution_status_id = helpline_resolution_status.resolution_status_id','left')
			->join('helpline_call_group','helpline_call.call_group_id = helpline_call_group.call_group_id','left')
			->join('hospital','helpline_call.hospital_id = hospital.hospital_id','left')
			->join('helpline_email','helpline_call.call_id = helpline_email.call_id','left')
			->where('from_number IN (SELECT number FROM helpline_numbers)')
			->group_by('helpline_call.call_id')
			->order_by('start_time','desc');
			$query = $this->db->get();
			return $query->result();
	}
	function get_groups(){
				if($this->input->post('from_date') && $this->input->post('to_date')){
					$this->db->where('(DATE(start_time) BETWEEN "'.date("Y-m-d",strtotime($this->input->post('from_date'))).'" AND "'.date("Y-m-d",strtotime($this->input->post('to_date'))).'")');
				}
				else
					$this->db->where('DATE(start_time)',date("Y-m-d"));
				$this->db->select('helpline_call.call_group_id,group_name')->from('helpline_call')
				->join('helpline_call_group','helpline_call.call_group_id = helpline_call_group.call_group_id','left')
				->group_by('helpline_call.call_group_id')
				->order_by('start_time','desc');
				$query = $this->db->get();
				return $query->result();
			}

	function dashboard($type="", $call_type = 0){
		if($call_type == 1){
			$this->db->where('from_number IN (select number FROM helpline_numbers)');
		}
		else{
			$this->db->where('from_number NOT IN (select number FROM helpline_numbers)');			
		}
		if($type == "caller_type"){
			$this->db->select('caller_type,count(call_id) as count');
			$this->db->group_by('helpline_caller_type.caller_type_id');
			$this->db->order_by('count','desc');
		}
		if($type == "call_category"){
			$this->db->select('call_category,count(call_id) as count');
			$this->db->group_by('helpline_call_category.call_category_id');
			$this->db->order_by('count','desc');
		}
		if($type == "hospital"){
			$this->db->select('hospital_short_name hospital,count(call_id) as count');
			$this->db->group_by('hospital.hospital_id');
			$this->db->order_by('count','desc');
		}
		if($type == "district"){
			$this->db->select('district,count(call_id) as count');
			$this->db->group_by('hospital.district');
			$this->db->order_by('count','desc');
		}
		if($type == "volunteer"){
			$this->db->select('short_name,count(call_id) as count');
			$this->db->group_by('dial_whom_number');
			$this->db->order_by('count','desc');
		}
		if($type == "call_type"){
			$this->db->select('CONCAT(direction," ",call_type) call_type,count(call_id) as count',false);
			$this->db->group_by('call_type,direction');
			$this->db->order_by('count','desc');
		}
		if($type == "to_number"){
			$this->db->select('to_number,count(call_id) as count');
			$this->db->group_by('to_number');
			$this->db->order_by('count','desc');
		}
		if($type == "op_ip"){
			$this->db->select('ip_op,count(call_id) as count');
			$this->db->group_by('ip_op');
			$this->db->order_by('count','desc');
		}
		if($type == "duration"){
			$this->db->select('dial_call_duration');
			$this->db->order_by('dial_call_duration');
			$this->db->where('call_type','completed');
		}
		if($type == "resolution_status"){
			$this->db->select('
			SUM(CASE WHEN resolution_status_id != 1 THEN 1 ELSE 0 END) as open,
			SUM(CASE WHEN resolution_status_id = 1 THEN 1 ELSE 0 END) as closed
			');
			$this->db->where('call_type','completed');
		}
		if($type == "closed_tat"){
			$this->db->select('
			SUM(CASE WHEN resolution_status_id = 1 AND TIMESTAMPDIFF(HOUR,start_time,resolution_date_time) < 24 THEN 1 ELSE 0 END) count24hrs,
			SUM(CASE WHEN resolution_status_id = 1 AND TIMESTAMPDIFF(HOUR,start_time,resolution_date_time) >= 24 AND  TIMESTAMPDIFF(HOUR,start_time,resolution_date_time) < 48  THEN 1 ELSE 0 END) count24_48hrs,
			SUM(CASE WHEN resolution_status_id = 1 AND TIMESTAMPDIFF(HOUR,start_time,resolution_date_time) >=48  AND TIMESTAMPDIFF(HOUR,start_time,resolution_date_time) < 168 THEN 1 ELSE 0 END) count3_7days,
			SUM(CASE WHEN resolution_status_id = 1 AND TIMESTAMPDIFF(HOUR,start_time,resolution_date_time) >= 168 THEN 1 ELSE 0 END) count7plus,
			',false);
			$this->db->where('call_type','completed');
		}
		if($type == "open_tat"){
			$this->db->select('
			SUM(CASE WHEN resolution_status_id != 1 AND TIMESTAMPDIFF(HOUR,start_time,NOW()) < 24 THEN 1 ELSE 0 END) count24hrs,
			SUM(CASE WHEN resolution_status_id != 1 AND TIMESTAMPDIFF(HOUR,start_time,NOW()) >= 24 AND  TIMESTAMPDIFF(HOUR,start_time,NOW()) < 48  THEN 1 ELSE 0 END) count24_48hrs,
			SUM(CASE WHEN resolution_status_id != 1 AND TIMESTAMPDIFF(HOUR,start_time,NOW()) >=48  AND TIMESTAMPDIFF(HOUR,start_time,NOW()) < 168 THEN 1 ELSE 0 END) count3_7days,
			SUM(CASE WHEN resolution_status_id != 1 AND TIMESTAMPDIFF(HOUR,start_time,NOW()) >= 168 THEN 1 ELSE 0 END) count7plus,
			',false);
			$this->db->where('call_type','completed');
		}

		if($this->input->post('from_date') && $this->input->post('to_date')){
			$this->db->where('date(start_time) >=',date("Y-m-d",strtotime($this->input->post('from_date'))));
			$this->db->where('date(start_time) <=',date("Y-m-d",strtotime($this->input->post('to_date'))));
		}
		else if($this->input->post('from_date')){
			$this->db->where('date(start_time) >=',date("Y-m-d",strtotime($this->input->post('from_date'))));
		}
		else if($this->input->post('to_date')){
			$this->db->where('date(start_time) <=',date("Y-m-d",strtotime($this->input->post('to_date'))));
		}
		else
			$this->db->where('date(start_time)',date("Y-m-d"));

		if($this->input->post('caller_type')){
			$this->db->where('helpline_caller_type.caller_type_id',$this->input->post('caller_type'));
		}
		if($this->input->post('call_category')){
			$this->db->where('helpline_call_category.call_category_id',$this->input->post('call_category'));
		}
		if($this->input->post('hospital')){
			$this->db->where('hospital.hospital_id',$this->input->post('hospital'));
		}
		if($this->input->post('district')){
			$this->db->where('hospital.district',$this->input->post('district'));
		}
		if($this->input->post('visit_type')){
			$this->db->where('helpline_call.ip_op',$this->input->post('visit_type'));
		}

		$this->db->from('helpline_call')
		->join('helpline_caller_type','helpline_call.caller_type_id = helpline_caller_type.caller_type_id','left')
		->join('helpline_call_category','helpline_call.call_category_id = helpline_call_category.call_category_id','left')
		->join('helpline_receiver','helpline_call.dial_whom_number = helpline_receiver.phone','left')
		->join('hospital','helpline_call.hospital_id = hospital.hospital_id','left');
		$query = $this->db->get();

		return $query->result();
	}

	function helpline_trend(){
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$this->db->where('date(start_time) >=',date("Y-m-d",strtotime($this->input->post('from_date'))));
			$this->db->where('date(start_time) <=',date("Y-m-d",strtotime($this->input->post('to_date'))));
		}
		else if($this->input->post('from_date')){
			$this->db->where('date(start_time) >=',date("Y-m-d",strtotime($this->input->post('from_date'))));
		}
		else if($this->input->post('to_date')){
			$this->db->where('date(start_time) <=',date("Y-m-d",strtotime($this->input->post('to_date'))));
		}
		else
			$this->db->where('date(start_time) >= ',date("Y-m-d",strtotime("-1 months")));

		if($this->input->post('caller_type')){
			$this->db->where('helpline_caller_type.caller_type_id',$this->input->post('caller_type'));
		}
		if($this->input->post('call_category')){
			$this->db->where('helpline_call_category.call_category_id',$this->input->post('call_category'));
		}
		if($this->input->post('hospital')){
			$this->db->where('hospital.hospital_id',$this->input->post('hospital'));
		}
		if($this->input->post('district')){
			$this->db->where('hospital.district',$this->input->post('district'));
		}
		if($this->input->post('visit_type')){
			$this->db->where('helpline_call.ip_op',$this->input->post('visit_type'));
		}
		if($this->input->post('trend_type')){
	    	$trend=$this->input->post('trend_type');
			if($trend=="Month"){
			$this->db->select("DATE_FORMAT(helpline_call.start_time ,\"%b-%Y\") as date",false);
			$this->db->group_by('date','desc');
			}
			else if($trend=="Year"){
			$this->db->select("DATE_FORMAT(helpline_call.start_time ,\"%Y\") as date",false);
			$this->db->group_by('date','desc');
			}
			else{
			$this->db->select("DATE_FORMAT(helpline_call.start_time ,\"%d-%b-%Y\") as date",false);
			$this->db->group_by('date','desc');
			}
		}
		else{
			$this->db->select("DATE_FORMAT(helpline_call.start_time ,\"%d-%b-%Y\") as date",false);
			$this->db->group_by('date','desc');
		}


		$this->db->select("count(call_id) calls ")
		->from('helpline_call')
		->join('helpline_caller_type','helpline_call.caller_type_id = helpline_caller_type.caller_type_id','left')
		->join('helpline_call_category','helpline_call.call_category_id = helpline_call_category.call_category_id','left')
		->join('helpline_receiver','helpline_call.dial_whom_number = helpline_receiver.phone','left')
		->join('hospital','helpline_call.hospital_id = hospital.hospital_id','left')
		->order_by('start_time','asc');

		$query = $this->db->get();
		return $query->result();
	}

	function get_call_groups(){
		$this->db->select("call_group_id,group_name,DATE_FORMAT(group_datetime,\"%d-%b-%Y, %h:%i %p\") as group_datetime", false)
		->from('helpline_call_group')
		->like('LOWER(group_name)',strtolower($this->input->post('query')));
		$query = $this->db->get();
		return $query->result();
	}
}
?>
