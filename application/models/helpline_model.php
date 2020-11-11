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
			$this->db->select('*')->from('helpline_numbers')->where('number',$from_number);
			$query = $this->db->get();
			$result = $query->row();
			if(!!$result){
				$hospital_id = $result->hospital_id;
				$helpline_category = $result->helpline_category_id;
				$helpline_caller_type = $result->caller_type_id;
				$visit_type = $result->visit_type;
				$resolution_status = $result->resolution_status_id;
				$resolution_date_time = date("Y-m-d H:i:s");
			}
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
		$helpline_to_num = $this->input->post('helpline_to_num');
		$helpline_note = $this->input->post('helpline_note');
		$helpline_to_num = trim($helpline_to_num);
		$helpline_note = trim($helpline_note);
		$from_name = "Hospital Helpline";
		if($to_email!=''){
		$subject="Helpline call #$call_id - ";
		if(!!$call_category) $subject .= $call_category." ";
		if(!!$hospital) $subject .= "from ".$hospital." ";
		if(!!$caller_type) $subject .= "by ".$caller_type." ";
		if(!!$patient) $subject .= "regarding ".$patient." ";
		if(!!$greeting){ $body = $greeting; } else $body = "Hi,";
		$body.="<br /><br />This call information from $helpline_note ($helpline_to_num) is being escalated for your information and intervention.<br /><br />";
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
		$body.="We request you to give your input regarding this call by calling the helpline $helpline_to_num or by replying to this email.<br /><br />";
		$body.="With Regards, <br />$helpline_note Helpline Team";
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
			$from_date = date("Y-m-d",strtotime($this->input->post("from_date")));
			$to_date = date("Y-m-d",strtotime($this->input->post("to_date")));
			$this->db->where('(date(start_time) BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$from_date;
			$to_date;
			if($this->input->post('from_date')){
				$from_date = date("Y-m-d",strtotime($this->input->post("from_date")));
				$to_date = $this->db->where('date(start_time)',date("Y-m-d"));
			}
			if($this->input->post('to_date')){
				$to_date = date("Y-m-d",strtotime($this->input->post("to_date")));
				$from_date = $this->db->where('date(start_time)',date("Y-m-d"));
			}
			$this->db->where('(date(start_time) BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}
		else{
			$this->db->where('date(start_time)',date("Y-m-d"));
		}
		$this->db->select('helpline_email.*')->from('helpline_email')->join('helpline_call','helpline_email.call_id = helpline_call.call_id')
		->order_by('email_date_time','desc');
		$query = $this->db->get();
		return $query->result();
	}

	function get_calls(){
		$user = $this->session->userdata('logged_in');

        if($this->input->post('from_time')) $from_time=date("H:i:s",strtotime($this->input->post('from_time'))); else $from_time = date("00:00");
		if($this->input->post('to_time')) $to_time=date("H:i:s",strtotime($this->input->post('to_time'))); else $to_time = date("23:59");
		if($this->input->post('date')){
			$date = date("Y-m-d",strtotime($this->input->post("date")));
			$this->db->where('date(start_time)',$date);
		}
		else{
			$this->db->where('date(start_time)',date("Y-m-d"));
		}
		if($this->input->post('from_time')){
			$this->db->where('time(helpline_call.start_time) > ', date("H:i:s", strtotime($this->input->post('from_time'))));
		}
		if($this->input->post('to_time')){
			$this->db->where('time(helpline_call.start_time) < ', date("H:i:s", strtotime($this->input->post('to_time'))));
		}
		if($this->input->post('from_number')){
			$this->db->like('helpline_call.from_number', $this->input->post('from_number'));
		}
		if($this->input->post('to_number')){
			$this->db->like('helpline_call.to_number', $this->input->post('to_number'));
		}
		if($this->input->post('caller_type')){
			$this->db->where('helpline_caller_type.caller_type_id',$this->input->post('caller_type'));
		}
		if($this->input->post('call_category')){
			$this->db->where('helpline_call_category.call_category_id',$this->input->post('call_category'));
		}
		if($this->input->post('resolution_status')){
			$this->db->where('helpline_call.resolution_status_id',$this->input->post('resolution_status'));
		}
		if($this->input->post('helpline_id')){
			$this->db->where('helpline.helpline_id',$this->input->post('helpline_id'));
		}
		$this->db->select('helpline_call.*, helpline_receiver.short_name as short_name, group_name,caller_type,call_category,resolution_status,hospital, helpline.note as line_note')->from('helpline_call')
		->join('helpline', 'helpline_call.to_number=helpline.helpline','left')	// 6 Dec 18 -> gokulakrishna@yousee.in
		->join('user_helpline_link', 'helpline.helpline_id = user_helpline_link.helpline_id')
		->join('helpline_receiver','helpline_call.dial_whom_number = helpline_receiver.phone','left')
		->join('helpline_caller_type','helpline_call.caller_type_id = helpline_caller_type.caller_type_id','left')
		->join('helpline_call_category','helpline_call.call_category_id = helpline_call_category.call_category_id','left')
		->join('helpline_call_group','helpline_call.call_group_id = helpline_call_group.call_group_id','left')
		->join('helpline_resolution_status','helpline_call.resolution_status_id = helpline_resolution_status.resolution_status_id','left')
		->join('hospital','helpline_call.hospital_id = hospital.hospital_id','left')
		->where('from_number NOT IN (SELECT number FROM helpline_numbers)')
		->where('user_helpline_link.user_id', $user['user_id'])
		->where('update_access',1)
		->order_by('start_time','desc');
		$query = $this->db->get();
		return $query->result();
	}
	function get_voicemail_calls(){
		$user = $this->session->userdata('logged_in');
		
		if($this->input->post('from_number')){
			$this->db->like('helpline_call.from_number', $this->input->post('from_number'));
		}
		if($this->input->post('to_number')){
			$this->db->like('helpline_call.to_number', $this->input->post('to_number'));
		}
		if($this->input->post('caller_type')){
			$this->db->where('helpline_caller_type.caller_type_id',$this->input->post('caller_type'));
		}
		if($this->input->post('call_category')){
			$this->db->where('helpline_call_category.call_category_id',$this->input->post('call_category'));
		}
		if($this->input->post('resolution_status')){
			$this->db->where('helpline_call.resolution_status_id',$this->input->post('resolution_status'));
		}
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date = date("Y-m-d",strtotime($this->input->post("from_date")));
			$to_date = date("Y-m-d",strtotime($this->input->post("to_date")));
			$this->db->where('(date(start_time) BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$from_date;
			$to_date;
			if($this->input->post('from_date')){
				$from_date = date("Y-m-d",strtotime($this->input->post("from_date")));
				$to_date = $this->db->where('date(start_time)',date("Y-m-d"));
			}
			if($this->input->post('to_date')){
				$to_date = date("Y-m-d",strtotime($this->input->post("to_date")));
				$from_date = $this->db->where('date(start_time)',date("Y-m-d"));
			}
			$this->db->where('(date(start_time) BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}
		else{
			$this->db->where('date(start_time)',date("Y-m-d"));
		}
		if($this->input->post('helpline_id')){
			$this->db->where('helpline.helpline_id',$this->input->post('helpline_id'));
		}
		$this->db->select('helpline_call.*,group_name,caller_type,call_category,resolution_status,hospital')->from('helpline_call')
		->join('helpline', 'helpline_call.to_number=helpline.helpline','left')	// 6 Dec 18 -> gokulakrishna@yousee.in
		->join('user_helpline_link', 'helpline.helpline_id = user_helpline_link.helpline_id')
		->join('helpline_numbers','helpline_call.from_number = helpline_numbers.number')
		->join('helpline_caller_type','helpline_call.caller_type_id = helpline_caller_type.caller_type_id','left')
		->join('helpline_call_category','helpline_call.call_category_id = helpline_call_category.call_category_id','left')
		->join('helpline_call_group','helpline_call.call_group_id = helpline_call_group.call_group_id','left')
		->join('helpline_resolution_status','helpline_call.resolution_status_id = helpline_resolution_status.resolution_status_id','left')
		->join('hospital','helpline_call.hospital_id = hospital.hospital_id','left')
		->where('from_number IN (SELECT number FROM helpline_numbers)')
		->where('user_helpline_link.user_id', $user['user_id'])
		->where('update_access',1)
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
		$user = $this->session->userdata('logged_in');

		if($this->input->post('caller_type')){
			$this->db->where('helpline_caller_type.caller_type_id',$this->input->post('caller_type'));
		}
		if($this->input->post('call_category')){
			$this->db->where('helpline_call_category.call_category_id',$this->input->post('call_category'));
		}
		if($this->input->post('from_number')){
			$this->db->like('helpline_call.from_number', $this->input->post('from_number'));
		}
		if($this->input->post('to_number')){
			$this->db->like('helpline_call.to_number', $this->input->post('to_number'));
		}

		if($this->input->post('resolution_status')){
			$this->db->where('helpline_call.resolution_status_id',$this->input->post('resolution_status'));
		}
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date = date("Y-m-d",strtotime($this->input->post("from_date")));
			$to_date = date("Y-m-d",strtotime($this->input->post("to_date")));
			$this->db->where('(date(start_time) BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$from_date;
			$to_date;
			if($this->input->post('from_date')){
				$from_date = date("Y-m-d",strtotime($this->input->post("from_date")));
				$to_date = $this->db->where('date(start_time)',date("Y-m-d"));
			}
			if($this->input->post('to_date')){
				$to_date = date("Y-m-d",strtotime($this->input->post("to_date")));
				$from_date = $this->db->where('date(start_time)',date("Y-m-d"));
			}
			$this->db->where('(date(start_time) BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}
		else{
			$this->db->where('date(start_time)',date("Y-m-d"));
		}
		if($this->input->post('helpline_id')){
			$this->db->where('helpline.helpline_id',$this->input->post('helpline_id'));
		}
		$this->db->select('*, helpline_receiver.short_name as short_name, helpline_call.call_id, helpline_call.call_group_id, helpline_call.note,count(helpline_email_id) email_count, helpline.note as line_note')
		->from('helpline_call')
		->join('helpline', 'helpline_call.to_number=helpline.helpline','left')	// 6 Dec 18 -> gokulakrishna@yousee.in
		->join('user_helpline_link', 'helpline.helpline_id = user_helpline_link.helpline_id')
		->join('helpline_receiver','helpline_call.dial_whom_number = helpline_receiver.phone','left')
		->join('helpline_caller_type','helpline_call.caller_type_id = helpline_caller_type.caller_type_id','left')
		->join('helpline_call_category','helpline_call.call_category_id = helpline_call_category.call_category_id','left')
		->join('helpline_resolution_status','helpline_call.resolution_status_id = helpline_resolution_status.resolution_status_id','left')
		->join('helpline_call_group','helpline_call.call_group_id = helpline_call_group.call_group_id','left')
		->join('hospital','helpline_call.hospital_id = hospital.hospital_id','left')
		->join('helpline_email','helpline_call.call_id = helpline_email.call_id','left')
		->group_by('helpline_call.call_id')
		->where('from_number NOT IN (SELECT number FROM helpline_numbers)')			
		->where('user_helpline_link.user_id', $user['user_id'])
		->where('reports_access',1)
		->order_by('start_time','desc');
		$query = $this->db->get();
		return $query->result();
	}
	function get_voicemail_detailed_report(){
		$user = $this->session->userdata('logged_in');
		if($this->input->post('caller_type')){
			$this->db->where('helpline_caller_type.caller_type_id',$this->input->post('caller_type'));
		}
		if($this->input->post('call_category')){
			$this->db->where('helpline_call_category.call_category_id',$this->input->post('call_category'));
		}
		if($this->input->post('from_number')){
			$this->db->like('helpline_call.from_number', $this->input->post('from_number'));
		}
		if($this->input->post('to_number')){
			$this->db->like('helpline_call.to_number', $this->input->post('to_number'));
		}
		if($this->input->post('resolution_status')){
			$this->db->where('helpline_call.resolution_status_id',$this->input->post('resolution_status'));
		}
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date = date("Y-m-d",strtotime($this->input->post("from_date")));
			$to_date = date("Y-m-d",strtotime($this->input->post("to_date")));
			$this->db->where('(date(start_time) BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$from_date;
			$to_date;
			if($this->input->post('from_date')){
				$from_date = date("Y-m-d",strtotime($this->input->post("from_date")));
				$to_date = $this->db->where('date(start_time)',date("Y-m-d"));
			}
			if($this->input->post('to_date')){
				$to_date = date("Y-m-d",strtotime($this->input->post("to_date")));
				$from_date = $this->db->where('date(start_time)',date("Y-m-d"));
			}
			$this->db->where('(date(start_time) BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}
		else{
			$this->db->where('date(start_time)',date("Y-m-d"));
		}
			if($this->input->post('helpline_id')){
				$this->db->where('helpline.helpline_id',$this->input->post('helpline_id'));
			}
			$this->db->select('*,helpline_call.call_id,helpline_call.call_group_id, helpline_call.note,count(helpline_email_id) email_count')
			->from('helpline_call')
			->join('helpline', 'helpline_call.to_number=helpline.helpline','left')	// 6 Dec 18 -> gokulakrishna@yousee.in
			->join('user_helpline_link', 'helpline.helpline_id = user_helpline_link.helpline_id')
			->join('helpline_caller_type','helpline_call.caller_type_id = helpline_caller_type.caller_type_id','left')
			->join('helpline_call_category','helpline_call.call_category_id = helpline_call_category.call_category_id','left')
			->join('helpline_resolution_status','helpline_call.resolution_status_id = helpline_resolution_status.resolution_status_id','left')
			->join('helpline_call_group','helpline_call.call_group_id = helpline_call_group.call_group_id','left')
			->join('hospital','helpline_call.hospital_id = hospital.hospital_id','left')
			->join('helpline_email','helpline_call.call_id = helpline_email.call_id','left')
			->where('from_number IN (SELECT number FROM helpline_numbers)')
			->where('user_helpline_link.user_id', $user['user_id'])
			->where('reports_access',1)
			->group_by('helpline_call.call_id')
			->order_by('start_time','desc');
			$query = $this->db->get();
			return $query->result();
	}
	function get_groups(){
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date = date("Y-m-d",strtotime($this->input->post("from_date")));
			$to_date = date("Y-m-d",strtotime($this->input->post("to_date")));
			$this->db->where('(date(start_time) BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$from_date;
			$to_date;
			if($this->input->post('from_date')){
				$from_date = date("Y-m-d",strtotime($this->input->post("from_date")));
				$to_date = $this->db->where('date(start_time)',date("Y-m-d"));
			}
			if($this->input->post('to_date')){
				$to_date = date("Y-m-d",strtotime($this->input->post("to_date")));
				$from_date = $this->db->where('date(start_time)',date("Y-m-d"));
			}
			$this->db->where('(date(start_time) BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}
		else{
			$this->db->where('date(start_time)',date("Y-m-d"));
		}
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
			$this->db->select('direction,count(call_id) as count',false);
			$this->db->group_by('direction');
			$this->db->order_by('count','desc');
		}
		if($type == "customer_distinct"){
			$this->db->select('count(distinct from_number) as count');
		}
		if($type == "call_type_in"){
			$this->db->select('call_type,count(call_id) as count',false);
			$this->db->group_by('call_type');
			$this->db->order_by('count','desc');
			$this->db->where('direction','incoming');
		}	
		if($type == "call_type_out"){
			$this->db->select('call_type,count(call_id) as count',false);
			$this->db->group_by('call_type');
			$this->db->order_by('count','desc');
			$this->db->where('direction','outbound-dial');
		}
		if($type == "to_number"){
			$this->db->select('CONCAT(helpline.note,"-",helpline.helpline) helpline_name,count(call_id) as count',false);
			$this->db->group_by('helpline.helpline');
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
			$from_date = date("Y-m-d",strtotime($this->input->post("from_date")));
			$to_date = date("Y-m-d",strtotime($this->input->post("to_date")));
			$this->db->where('(date(start_time) BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$from_date;
			$to_date;
			if($this->input->post('from_date')){
				$from_date = date("Y-m-d",strtotime($this->input->post("from_date")));
				$to_date = $this->db->where('date(start_time)',date("Y-m-d"));
			}
			if($this->input->post('to_date')){
				$to_date = date("Y-m-d",strtotime($this->input->post("to_date")));
				$from_date = $this->db->where('date(start_time)',date("Y-m-d"));
			}
			$this->db->where('(date(start_time) BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}
		else{
			$this->db->where('date(start_time)',date("Y-m-d"));
		}
			
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
		if($this->input->post('helpline_id')){
			$this->db->where('helpline.helpline_id',$this->input->post('helpline_id'));
		}

		$this->db->from('helpline_call')
		->join('helpline', 'helpline_call.to_number=helpline.helpline','left')	// 6 Dec 18 -> gokulakrishna@yousee.in
		->join('helpline_caller_type','helpline_call.caller_type_id = helpline_caller_type.caller_type_id','left')
		->join('helpline_call_category','helpline_call.call_category_id = helpline_call_category.call_category_id','left')
		->join('helpline_receiver','helpline_call.dial_whom_number = helpline_receiver.phone','left')
		->join('hospital','helpline_call.hospital_id = hospital.hospital_id','left');
		$query = $this->db->get();
		return $query->result();
	}

	function helpline_trend(){
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date = date("Y-m-d",strtotime($this->input->post("from_date")));
			$to_date = date("Y-m-d",strtotime($this->input->post("to_date")));
			$this->db->where('(date(start_time) BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$from_date;
			$to_date;
			if($this->input->post('from_date')){
				$from_date = date("Y-m-d",strtotime($this->input->post("from_date")));
				$to_date = $this->db->where('date(start_time)',date("Y-m-d"));
			}
			if($this->input->post('to_date')){
				$to_date = date("Y-m-d",strtotime($this->input->post("to_date")));
				$from_date = $this->db->where('date(start_time)',date("Y-m-d"));
			}
			$this->db->where('(date(start_time) BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}
		else{
			$from_date = date("Y-m-d",strtotime("-1 months"));
			$to_date = date("Y-m-d");
			$this->db->where('(date(start_time) BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}

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
		if($this->input->post('helpline_id')){
			$this->db->where('helpline.helpline_id',$this->input->post('helpline_id'));
		}

		$this->db->select("count(call_id) calls ")
		->from('helpline_call')
		->join('helpline', 'helpline_call.to_number=helpline.helpline','left')	//20 Dec 18 -> gokulakrishna@yousee.in
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

	function get_helpline($access="all", $user_specific = 1){
		$user = $this->session->userdata('logged_in');
		if($user_specific){
			$this->db->join('user_helpline_link','helpline.helpline_id = user_helpline_link.helpline_id');
			$this->db->where('user_id',$user['user_id']);
			if($access == "report"){
				$this->db->where('reports_access',1);
			}
			else if($access == "update"){
				$this->db->where('update_access',1);
			}
		}
		$this->db->select("helpline.helpline_id, helpline, note", false)
		->from('helpline');
		$query = $this->db->get();
		return $query->result();
	}

	function get_user_access(){
		$this->input->post('user_id') ? $user_id = $this->input->post('user_id') : $user_id = $this->input->post('user');
		if(!!$user_id){
			$user = $this->session->userdata('logged_in');
			$this->db->select('user.user_id, helpline.helpline_id, username, update_access, reports_access')
			->from('user')
			->join('user_helpline_link','user.user_id = user_helpline_link.user_id')
			->join('helpline','user_helpline_link.helpline_id = helpline.helpline_id')
			->where('user.user_id',$user_id);
			$query = $this->db->get();
			return $query->result();
		}
	}

	function update_access(){
		$this->db->trans_start();
		$user_helpline_access=$this->input->post('user_helpline_access');
		$this->db->select('user_helpline_id,helpline.helpline_id')->from('helpline')
		->join('user_helpline_link','helpline.helpline_id=user_helpline_link.helpline_id')
		->where('user_id',$this->input->post('user'));
		$query=$this->db->get();
		$result=$query->result();
		$existing_access=array();
		$user_helpline_data=array();
		$update_helpline_data=array();
		foreach($result as $row){                   //Update existing access
			$update=0;$reports=0;
			if($this->input->post($row->helpline_id))
			foreach($this->input->post($row->helpline_id) as $access){
					if($access=="update") $update=1;
					if($access=="reports") $reports=1;
				}
				$update_helpline_data[]=array(
					'user_helpline_id'=>$row->user_helpline_id,
					'update_access'=>$update,
					'reports_access'=>$reports
				);
			$existing_access[]=$row->helpline_id;
		}
		foreach($user_helpline_access as $u){             //Add new access
			if(!in_array($u,$existing_access)){
				$update=0;
				$reports=0;
				if($this->input->post($u)){
					foreach($this->input->post($u) as $access){
						if($access=="update") $update=1;
						if($access=="reports") $reports=1;
					}
					$user_helpline_data[]=array(
						'user_id'=>$this->input->post('user'),
						'helpline_id'=>$u,
						'update_access'=>$update,
						'reports_access'=>$reports
					);
				}
			}
		}
                
               
		if(count($update_helpline_data)>0) $this->db->update_batch('user_helpline_link',$update_helpline_data,'user_helpline_id');
		if(count($user_helpline_data)>0) $this->db->insert_batch('user_helpline_link',$user_helpline_data);

		$this->db->trans_complete();
		if($this->db->trans_status()===TRUE) return true; else { $this->db->trans_rollback(); return false; }	
	}

	function getHelplineReceivers($data=array()){
		if(isset($data['phone'])){
			$this->db->where('phone', '0' . $data['phone']);
		}
		$this->db->select("receiver_id, full_name, phone, email, category, user_id, doctor, enable_outbound, app_id, activity_status, CONCAT(helpline.note, ' - ', helpline.helpline) as helpline", false)
		->from('helpline_receiver')
		->join('helpline', 'helpline_receiver.helpline_id=helpline.helpline_id','left')
		->order_by('full_name', 'asc');
		$query = $this->db->get();
		return $query->result();
	}

	function getHelplineReceiverByUserId($user_id){
		$this->db->select("*")->from("helpline_receiver")->join('helpline','helpline_receiver.helpline_id = helpline.helpline_id')->where('user_id', $user_id);
		$result = $this->db->get()->result();
        return count($result) > 0 ? $result[0] : false;
	}

	function getHelplineReceiverById($receiver_id){
		$this->db->select("*")->from("helpline_receiver")->where('receiver_id', $receiver_id);
        return $this->db->get()->result();
	}

	function getHelplineReceiverLinksById($receiver_id){
		$this->db->select("*")->from("helpline_receiver_link")->join('helpline','helpline_receiver_link.helpline_id = helpline.helpline_id')->where('receiver_id', $receiver_id);
        return $this->db->get()->result();
	}

	function get_helplines(){
		$this->db->select("helpline_id, helpline, note")->from("helpline");
        return $this->db->get()->result();
	}

	function receiver_phone_exists($phone){
		$this->db->where('phone', $phone);
	    $query = $this->db->get('helpline_receiver');
	    return $query->num_rows() > 0 ? $query->result() : false;
	}

	function save_helpline_receiver($receiver_id=''){
		$helpline_receiver = array();																
		if($this->input->post('full_name')){														
            $helpline_receiver['full_name'] = $this->input->post('full_name');							
        }
		if($this->input->post('short_name')){														
            $helpline_receiver['short_name'] = $this->input->post('short_name');							
        }																
		if($this->input->post('phone')){														
            $helpline_receiver['phone'] = '0' . $this->input->post('phone');							
        }
		if($this->input->post('email')){														
            $helpline_receiver['email'] = $this->input->post('email');							
        }																
		if($this->input->post('category')){														
            $helpline_receiver['category'] = $this->input->post('category');							
        }

        $helpline_receiver['user_id'] = $this->input->post('user_id') ? $this->input->post('user_id') : '0';

        $helpline_receiver['doctor'] = $this->input->post('doctor') ? $this->input->post('doctor') : '0';

        $helpline_receiver['enable_outbound'] = $this->input->post('enable_outbound') ? $this->input->post('enable_outbound') : '0';
        
        $helpline_receiver['app_id'] = $this->input->post('app_id') ? $this->input->post('app_id') : '';
        
        $helpline_receiver['helpline_id'] = $this->input->post('helpline_id') ? $this->input->post('helpline_id') : '0';
		$helpline_receiver['activity_status'] = $this->input->post('activity_status') ? $this->input->post('activity_status') : '0';

	   	$this->db->trans_start();
        if($receiver_id){
        	$this->db->where('receiver_id', $receiver_id);
	   		$this->db->update('helpline_receiver', $helpline_receiver);

	   		$this->db->where('receiver_id', $receiver_id);
	   		$this->db->delete('helpline_receiver_link');
        } else {
        	$this->db->insert('helpline_receiver', $helpline_receiver);
        	$receiver_id = $this->db->insert_id();
        }

        if($this->input->post("helpline_receiver_link")){
        	$helpline_receiver_link = array();
        	foreach($this->input->post("helpline_receiver_link") as $link){
			    $helpline_receiver_link[] = array('receiver_id' => $receiver_id, 'helpline_id' => $link);
			}
			$this->db->insert_batch('helpline_receiver_link', $helpline_receiver_link);
        }
		
		$this->db->trans_complete();
		if($this->db->trans_status()==FALSE){
			return false;
		} else {
           return true;
        }  
	}

	function search_helpline_receiver($query=""){
		$search = array(
           'LOWER(full_name)'=>strtolower($query), 
           'phone'=>$query,
        );
		$this->db->select("receiver_id, phone, full_name")
			->from("helpline_receiver")
			->or_like($search, 'both');
		$query=$this->db->get();
		return $query->result();
	}

	function get_helpline_receiver_by_doctor($doctor="", $helpline=""){
		$query = $this->db->query("SELECT full_name, phone, category, app_id FROM helpline_receiver JOIN helpline ON helpline_receiver.helpline_id = helpline.helpline_id WHERE activity_status = 1 AND helpline.helpline = '".$helpline."' AND doctor = '".($doctor == "1" ? 1 : 0)."' GROUP BY helpline_receiver.receiver_id");
		return $query->result();
	}

	function get_helpline_receiver_links_by_doctor($doctor="", $helpline=""){
		$query = $this->db->query("SELECT full_name, phone, category, app_id FROM helpline_receiver_link JOIN helpline ON helpline_receiver_link.helpline_id = helpline.helpline_id JOIN helpline_receiver ON helpline_receiver.receiver_id = helpline_receiver_link.receiver_id WHERE activity_status = 1 AND helpline.helpline = '".$helpline."' AND doctor = '".($doctor == "1" ? 1 : 0)."' GROUP BY helpline_receiver_link.receiver_id");
		return $query->result();
	}
}
?>
