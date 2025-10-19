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
			$this->db->select('helpline_number_id,number,hospital_id,helpline_category_id,caller_type_id,visit_type,resolution_status_id')->from('helpline_numbers')->where('number',$from_number);
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
		$user = $this->session->userdata('logged_in');
		$calls = $this->input->post('call');
		$data=array();
		foreach($calls as $call){
			if(!!$this->input->post('resolution_date_time_'.$call) && !! $this->input->post('resolution_date_time_'.$call)){
				$resolution_date_time = date("Y-m-d H:i:s",strtotime($this->input->post('resolution_date_time_'.$call)));
			}
			else $resolution_date_time = 0;
			$data=array(
				'call_id'=>$call,
				'caller_type_id'=>$this->input->post("caller_type_".$call),
				'language_id'=>$this->input->post("language_".$call),
				'district_id'=>$this->input->post("district_id_".$call),
				'call_category_id'=>$this->input->post("call_category_".$call),
				'resolution_status_id'=>$this->input->post("resolution_status_".$call),
				'hospital_id'=>$this->input->post("hospital_".$call),
				'ip_op'=>$this->input->post("visit_type_".$call),
				'visit_id'=>$this->input->post("visit_id_".$call),
				'note'=>$this->input->post("note_".$call),
				'department_id'=>$this->input->post("department_id_".$call),
				'call_group_id'=>$this->input->post("group_".$call),
				'resolution_date_time'=>$resolution_date_time,
				'updated'=>1
			);
			$this->db->set('update_date_time', date('Y-m-d H:i:s'));
			$this->db->set('updated_user_id',$user['staff_id']);

			$this->db->trans_start();
			$this->db->where('call_id', $call);
			$this->db->update('helpline_call',$data);
			$this->db->trans_complete();
			if($this->db->trans_status()===FALSE){
				$this->db->trans_rollback();
				return false;
			}
		}
		return true;
		
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
		$this->db->select('helpline_email.helpline_email_id,
		helpline_email.call_id,
		helpline_email.to_email,
		helpline_email.cc_email,
		helpline_email.greeting,
		helpline_email.phone_shared,
		helpline_email.note,
		helpline_email.user_id,
		helpline_email.email_date_time
		')->from('helpline_email')->join('helpline_call','helpline_email.call_id = helpline_call.call_id')
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
			$this->db->like('helpline_call.dial_whom_number', $this->input->post('to_number'));
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
		if($this->input->post('language')){
			$this->db->where('helpline_call.language_id',$this->input->post('language'));
		}
		$this->db->select('helpline_call.call_id, 
		helpline_call.callsid, 
		helpline_call.from_number, 
		helpline_call.to_number, 
		helpline_call.direction, 
		helpline_call.dial_call_duration, 
		helpline_call.start_time, 
		helpline_call.current_server_time, 
		helpline_call.end_time, 
		helpline_call.call_type, 
		helpline_call.recording_url, 
		helpline_call.dial_whom_number, 
		helpline_call.caller_type_id, 
		helpline_call.call_category_id, 
		helpline_call.hospital_id, 
		helpline_call.ip_op, 
		helpline_call.visit_id, 
		helpline_call.resolution_status_id, 
		helpline_call.note, 
		helpline_call.updated, 
		helpline_call.resolution_date_time, 
		helpline_call.call_group_id, 
		helpline_call.language_id, 
		helpline_call.district_id, 
		helpline_call.department_id,	
		helpline_receiver.short_name as short_name, group_name,caller_type,call_category,resolution_status,hospital, helpline.note as line_note')->from('helpline_call')
		->join('helpline', 'helpline_call.to_number=helpline.helpline','left')	// 6 Dec 18 -> gokulakrishna@yousee.in
		->join('user_helpline_link', 'helpline.helpline_id = user_helpline_link.helpline_id')
		->join('helpline_receiver','helpline_call.dial_whom_number = helpline_receiver.phone','left')
		->join('helpline_caller_type','helpline_call.caller_type_id = helpline_caller_type.caller_type_id','left')
		->join('helpline_call_category','helpline_call.call_category_id = helpline_call_category.call_category_id','left')
		->join('helpline_call_group','helpline_call.call_group_id = helpline_call_group.call_group_id','left')
		->join('helpline_resolution_status','helpline_call.resolution_status_id = helpline_resolution_status.resolution_status_id','left')
		->join('hospital','helpline_call.hospital_id = hospital.hospital_id','left')
		->join('language','helpline_call.language_id = language.language_id','left')
		->where('from_number NOT IN (SELECT number FROM helpline_numbers)')
		->where('user_helpline_link.user_id', $user['user_id'])
		->where('update_access',1)
		->order_by('start_time','desc')
		->order_by('language', 'asc');
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
		$this->db->select('helpline_call.call_id, 
		helpline_call.callsid, 
		helpline_call.from_number, 
		helpline_call.to_number, 
		helpline_call.direction, 
		helpline_call.dial_call_duration, 
		helpline_call.start_time, 
		helpline_call.current_server_time, 
		helpline_call.end_time, 
		helpline_call.call_type, 
		helpline_call.recording_url, 
		helpline_call.dial_whom_number, 
		helpline_call.caller_type_id, 
		helpline_call.call_category_id, 
		helpline_call.hospital_id, 
		helpline_call.ip_op, 
		helpline_call.visit_id, 
		helpline_call.resolution_status_id, 
		helpline_call.note, 
		helpline_call.updated, 
		helpline_call.resolution_date_time, 
		helpline_call.call_group_id, 
		helpline_call.language_id, 
		helpline_call.district_id, 
		helpline_call.department_id,group_name,caller_type,call_category,resolution_status,hospital')->from('helpline_call')
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
		$this->db->select('caller_type_id,caller_type,note')->from('helpline_caller_type');
		$query = $this->db->get();
		return $query->result();
	}
	function get_language(){
		$this->db->select('language_id,language')->from('language')
		->order_by('language',`asc`);
		$query = $this->db->get();
		return $query->result();
	}
	function get_call_category(){
		$this->db->select('call_category_id,call_category,note,helpline_id,status')->from('helpline_call_category');
		$this->db->order_by('call_category','ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function get_resolution_status(){
		$this->db->select('resolution_status_id,resolution_status,note,helpline_id,status')->from('helpline_resolution_status');
		$this->db->order_by('resolution_status','ASC');
		$query = $this->db->get();
		return $query->result();
	}
	function get_hospital_district(){
		$this->db->select('DISTINCT district',false)->from('hospital')->where('district !=', '')->order_by('district');
		$query = $this->db->get();
		return $query->result();
	}

	function get_detailed_report($default_rowsperpage){
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
		
		$user = $this->session->userdata('logged_in');

		if($this->input->post('caller_type')){
			$this->db->where('helpline_caller_type.caller_type_id',$this->input->post('caller_type'));
		}
		if($this->input->post('language')){
			$this->db->where('helpline_call.language_id',$this->input->post('language'));
		}
		if($this->input->post('helpline_hospital')){
			$this->db->where('helpline_call.hospital_id',$this->input->post('helpline_hospital'));
		}
		if($this->input->post('helpline_department')){
			$this->db->where('helpline_call.department_id',$this->input->post('helpline_department'));
		}
		if($this->input->post('call_category')){
			$this->db->where('helpline_call_category.call_category_id',$this->input->post('call_category'));
		}
		$from_number = trim($this->input->post('from_number'));
		if($from_number){
			$this->db->like('helpline_call.from_number', $this->input->post('from_number'));
		}
		if($this->input->post('to_number')){
			$this->db->like('helpline_call.dial_whom_number', $this->input->post('to_number'));
		}

		if($this->input->post('resolution_status')){
			$this->db->where('helpline_call.resolution_status_id',$this->input->post('resolution_status'));
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

		$from_timestamp = $from_date." ".$from_time;
		$to_timestamp = $to_date." ".$to_time;

		$this->db->where('(start_time BETWEEN "'.$from_timestamp.'" AND "'.$to_timestamp.'")');

		if($this->input->post('helpline_id')){
			$this->db->where('helpline.helpline_id',$this->input->post('helpline_id'));
		}
		if($this->input->post('call_direction')){
			$this->db->where('helpline_call.direction',$this->input->post('call_direction'));
		}
		if($this->input->post('call_type')){
			$this->db->where('helpline_call.call_type',$this->input->post('call_type'));
		}
		if($this->input->post('state')){
			$this->db->where('state.state_id',$this->input->post('state'));
		}		
		if($this->input->post('district')){
			$this->db->where('helpline_call.district_id',$this->input->post('district'));
		}
		$this->db->select("helpline_call.visit_id,helpline_call.to_number,helpline_call.recording_url,helpline_call.ip_op,helpline_call.direction,helpline_call.resolution_date_time,helpline_call.resolution_status_id,helpline_call.call_category_id,helpline_call.department_id,helpline_call.hospital_id,helpline_call.caller_type_id,helpline_call.language_id,helpline_call.dial_whom_number,helpline_call.from_number,helpline_call.call_type as call_type,helpline_call.dial_call_duration as dial_call_duration,helpline_call.start_time,helpline_receiver.short_name as short_name, helpline_call.call_id, helpline_call.call_group_id, helpline_call.note, helpline.note as line_note,helpline.helpline_id,IFNULL(hospital.hospital_short_name,'') as hospital_short_name ,IFNULL(helpline_caller_type.caller_type,'') as caller_type,IFNULL(helpline_call_category.call_category,'') as call_category,
		IFNULL(helpline_resolution_status.resolution_status,'') as resolution_status,IFNULL(language.language,'') as language ,
		IFNULL(department.department,'') as department, IFNULL(district.district_id,'') as district_id,
		IFNULL(district.district,'') as district,IFNULL(state.state,'') as state,helpline_call.update_date_time,
		staff.first_name",FALSE)
		->from('helpline_call')
		->join('helpline', 'helpline_call.to_number=helpline.helpline','left')
		->join('user_helpline_link', 'helpline.helpline_id = user_helpline_link.helpline_id')
		->join('helpline_receiver','helpline_call.dial_whom_number = helpline_receiver.phone','left')
		->join('helpline_caller_type','helpline_call.caller_type_id = helpline_caller_type.caller_type_id','left')
		->join('helpline_call_category','helpline_call.call_category_id = helpline_call_category.call_category_id','left')
		->join('helpline_resolution_status','helpline_call.resolution_status_id = helpline_resolution_status.resolution_status_id','left')
		->join('helpline_call_group','helpline_call.call_group_id = helpline_call_group.call_group_id','left')
		->join('hospital','helpline_call.hospital_id = hospital.hospital_id','left')
		->join('language','helpline_call.language_id = language.language_id','left')
		->join('department', 'department.department_id = helpline_call.department_id','left')
		->join('district', 'district.district_id = helpline_call.district_id','left')
		->join('state', 'district.state_id= state.state_id','left')
		->join('staff', 'staff.staff_id= helpline_call.updated_user_id','left')
		->where('from_number NOT IN (SELECT number FROM helpline_numbers)')			
		->where('user_helpline_link.user_id', $user['user_id'])
		->where('reports_access',1)
		->order_by('start_time','desc');
		$this->db->limit($rows_per_page,$start);	
		$query = $this->db->get();
		return $query->result();
	}

	function get_detailed_report_count(){
		$user = $this->session->userdata('logged_in');

		if($this->input->post('caller_type')){
			$this->db->where('helpline_caller_type.caller_type_id',$this->input->post('caller_type'));
		}
		if($this->input->post('language')){
			$this->db->where('helpline_call.language_id',$this->input->post('language'));
		}
		if($this->input->post('call_category')){
			$this->db->where('helpline_call_category.call_category_id',$this->input->post('call_category'));
		}
		if($this->input->post('from_number')){
			$this->db->like('helpline_call.from_number', $this->input->post('from_number'));
		}
		if($this->input->post('to_number')){
			$this->db->like('helpline_call.dial_whom_number', $this->input->post('to_number'));
			echo("<script>console.log('to_number: " . $this->input->post('to_number') . "');</script>");
		}
		if($this->input->post('helpline_hospital')){
			$this->db->where('helpline_call.hospital_id',$this->input->post('helpline_hospital'));
		}
		if($this->input->post('helpline_department')){
			$this->db->where('helpline_call.department_id',$this->input->post('helpline_department'));
		}
		if($this->input->post('resolution_status')){
			$this->db->where('helpline_call.resolution_status_id',$this->input->post('resolution_status'));
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

		$from_timestamp = $from_date." ".$from_time;
		$to_timestamp = $to_date." ".$to_time;

		$this->db->where('(start_time BETWEEN "'.$from_timestamp.'" AND "'.$to_timestamp.'")');
		if($this->input->post('helpline_id')){
			$this->db->where('helpline.helpline_id',$this->input->post('helpline_id'));
		}
		if($this->input->post('call_direction')){
			$this->db->where('helpline_call.direction',$this->input->post('call_direction'));
		}
		if($this->input->post('call_type')){
			$this->db->where('helpline_call.call_type',$this->input->post('call_type'));
		}
		if($this->input->post('state')){
			$this->db->where('state.state_id',$this->input->post('state'));
		}		
		if($this->input->post('district')){
			$this->db->where('helpline_call.district_id',$this->input->post('district'));
		}
		$this->db->select('count(*) as count')
		->from('helpline_call')
		->join('helpline', 'helpline_call.to_number=helpline.helpline','left')	// 6 Dec 18 -> gokulakrishna@yousee.in
		->join('user_helpline_link', 'helpline.helpline_id = user_helpline_link.helpline_id')
		->join('helpline_receiver','helpline_call.dial_whom_number = helpline_receiver.phone','left')
		->join('helpline_caller_type','helpline_call.caller_type_id = helpline_caller_type.caller_type_id','left')
		->join('helpline_call_category','helpline_call.call_category_id = helpline_call_category.call_category_id','left')
		->join('helpline_resolution_status','helpline_call.resolution_status_id = helpline_resolution_status.resolution_status_id','left')
		->join('helpline_call_group','helpline_call.call_group_id = helpline_call_group.call_group_id','left')
		->join('hospital','helpline_call.hospital_id = hospital.hospital_id','left')
		->join('language','helpline_call.language_id = language.language_id','left')
		->join('department', 'department.department_id = helpline_call.department_id','left')
		->join('district', 'district.district_id = helpline_call.district_id','left')
		->join('state', 'district.state_id= state.state_id','left')
		->where('from_number NOT IN (SELECT number FROM helpline_numbers)')			
		->where('user_helpline_link.user_id', $user['user_id'])
		->where('reports_access',1);
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_completed_calls_report($default_rowsperpage){
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
		
		$user = $this->session->userdata('logged_in');

		if($this->input->post('from_number')){
			$this->db->like('helpline_call.from_number', $this->input->post('from_number'));
		}
		if($this->input->post('to_number')){
			$this->db->like('helpline_call.dial_whom_number', $this->input->post('to_number'));
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
		
		$this->db->select("DATE(helpline_call.start_time) AS date,helpline_receiver.full_name AS receiver,COUNT(DISTINCT helpline_call.from_number ) AS customers,SUM(CASE WHEN helpline_call.direction =  'incoming' THEN 1 ELSE 0 END) AS incoming_calls,
SUM(CASE WHEN helpline_call.direction =  'outbound-dial' THEN 1 ELSE 0 END) AS outboundcalls",FALSE)
		->from('helpline_call')
		->join('helpline', 'helpline_call.to_number=helpline.helpline')
		->join('user_helpline_link', 'helpline.helpline_id = user_helpline_link.helpline_id')
		->join('helpline_receiver','helpline_call.dial_whom_number = helpline_receiver.phone')
		->where('helpline_call.call_type','completed')			
		->where('user_helpline_link.user_id', $user['user_id'])
		->where('from_number NOT IN (SELECT number FROM helpline_numbers)')	
		->group_by('DATE(helpline_call.start_time)')	
		->group_by('helpline_receiver.full_name')	
		->order_by('DATE(helpline_call.start_time)','desc')
		->order_by('helpline_receiver.full_name');
		$this->db->limit($rows_per_page,$start);	
		$query = $this->db->get();
		return $query->result();
	}

	function get_completed_calls_report_count(){
		$user = $this->session->userdata('logged_in');

		if($this->input->post('from_number')){
			$this->db->like('helpline_call.from_number', $this->input->post('from_number'));
		}
		if($this->input->post('to_number')){
			$this->db->like('helpline_call.dial_whom_number', $this->input->post('to_number'));
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
		
		$this->db->select("count(DISTINCT DATE(helpline_call.start_time),helpline_receiver.full_name) as count",FALSE)
		->from('helpline_call')
		->join('helpline', 'helpline_call.to_number=helpline.helpline')
		->join('user_helpline_link', 'helpline.helpline_id = user_helpline_link.helpline_id')
		->join('helpline_receiver','helpline_call.dial_whom_number = helpline_receiver.phone')
		->where('helpline_call.call_type','completed')			
		->where('user_helpline_link.user_id', $user['user_id']);	
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_missed_calls_report($default_rowsperpage){
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
		
		$user = $this->session->userdata('logged_in');
		
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
		$this->db->where('(start_time BETWEEN "'.$from_timestamp.'" AND "'.$to_timestamp.'")');
		
		if($this->input->post('helpline_id')){
			$this->db->where('helpline.helpline_id',$this->input->post('helpline_id'));
		}
		
		if($this->input->post('call_direction')){
			$this->db->where('helpline_call.direction',$this->input->post('call_direction'));
		}
		
		if($this->input->post('call_type')){
			$this->db->where('helpline_call.call_type',$this->input->post('call_type'));
		}
		
		$this->db->select("from_number,SUM(CASE WHEN call_type =  'client-hangup' AND helpline_call.direction = 'incoming' THEN 1 ELSE 0 END) AS InClientHangup, SUM(CASE WHEN call_type =  'call-attempt' AND helpline_call.direction =  'incoming' THEN 1 ELSE 0 END) AS InCallAttempt, SUM(CASE WHEN call_type = 'incomplete' AND helpline_call.direction = 'incoming' THEN 1 ELSE 0 END) AS InIncomplete, SUM(CASE WHEN call_type =  'completed' AND helpline_call.direction = 'incoming' THEN 1 ELSE 0 END) AS InCompleted, SUM(CASE WHEN call_type =  'client-hangup' AND helpline_call.direction =  'outbound-dial' THEN 1 ELSE 0 END) AS OutClientHangup, SUM(CASE WHEN call_type =  'call-attempt' AND helpline_call.direction =  'outbound-dial' THEN 1 ELSE 0 END) AS OutCallAttempt, SUM(CASE WHEN call_type =  'incomplete' AND helpline_call.direction =  'outbound-dial' THEN 1 ELSE 0 END) AS OutIncomplete, SUM(CASE WHEN call_type =  'completed' AND helpline_call.direction = 'outbound-dial' THEN 1 ELSE 0 END) AS OutCompleted",FALSE)
		->from('helpline_call')
		->join('helpline', 'helpline_call.to_number=helpline.helpline')
		->join('user_helpline_link', 'helpline.helpline_id = user_helpline_link.helpline_id')	
		->where('user_helpline_link.user_id', $user['user_id'])
		->group_by('from_number')
		->order_by('InClientHangup','desc');
		$this->db->limit($rows_per_page,$start);	
		$query = $this->db->get();
		return $query->result();
	}

	function get_missed_calls_report_count(){
		$user = $this->session->userdata('logged_in');

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
		$this->db->where('(start_time BETWEEN "'.$from_timestamp.'" AND "'.$to_timestamp.'")');
		
		
		if($this->input->post('helpline_id')){
			$this->db->where('helpline.helpline_id',$this->input->post('helpline_id'));
		}
		
		if($this->input->post('call_direction')){
			$this->db->where('helpline_call.direction',$this->input->post('call_direction'));
		}
		
		if($this->input->post('call_type')){
			$this->db->where('helpline_call.call_type',$this->input->post('call_type'));
		}
		
		$this->db->select("count(DISTINCT from_number) as count",FALSE)
		->from('helpline_call')
		->join('helpline', 'helpline_call.to_number=helpline.helpline')
		->join('user_helpline_link', 'helpline.helpline_id = user_helpline_link.helpline_id')		
		->where('user_helpline_link.user_id', $user['user_id']);	
		$query = $this->db->get();
		return $query->result();
	}
	
	
	function get_sms_sent_report($default_rowsperpage){
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
		$user = $this->session->userdata('logged_in');

		if($this->input->post('to_number')){
			$this->db->like('sms_helpline.to_receiver', $this->input->post('to_number'));
		}

		if($this->input->post('sent_status')){
			$this->db->where('sms_helpline.status_code',$this->input->post('sent_status'));
		}
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date = date("Y-m-d",strtotime($this->input->post("from_date")));
			$to_date = date("Y-m-d",strtotime($this->input->post("to_date")));
			$this->db->where('(date(date_created) BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$from_date;
			$to_date;
			if($this->input->post('from_date')){
				$from_date = date("Y-m-d",strtotime($this->input->post("from_date")));
				$to_date = $this->db->where('date(date_created)',date("Y-m-d"));
			}
			if($this->input->post('to_date')){
				$to_date = date("Y-m-d",strtotime($this->input->post("to_date")));
				$from_date = $this->db->where('date(date_created)',date("Y-m-d"));
			}
			$this->db->where('(date(date_created) BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}
		else{
			$this->db->where('date(date_created)',date("Y-m-d"));
		}
		if($this->input->post('helpline_id')){
			$this->db->where('helpline.helpline_id',$this->input->post('helpline_id'));
		}
		if($this->input->post('sms_template')){
			$this->db->where('sms_template.sms_template_id',$this->input->post('sms_template'));
		}
		
		$this->db->select('user.user_id,helpline_receiver.short_name, helpline_receiver.phone, sms_helpline.id,sms_helpline.from_helpline as from_helpline, sms_helpline.sms_body as body,staff.staff_id,sms_helpline.to_receiver as receiver, sms_helpline.sent_by_staff as user,sms_helpline.from_helpline as from_number,helpline.note as helpline, sms_template.template_name, date(sms_helpline.date_created) as created_date, time(sms_helpline.date_created) as created_time ,sms_helpline.status,date(sms_helpline.date_sent) as sent_date, time(sms_helpline.date_sent) as sent_time, sms_helpline.status_code',false)
		->from('sms_helpline')
		//->join('user_helpline_link', 'sms_helpline.from_helpline = user_helpline_link.helpline_id')
		//->join('helpline', 'sms_helpline.from_helpline = user_helpline_link.helpline_id and user_helpline_link.helpline_id = helpline.helpline_id')
		->join('helpline', 'sms_helpline.from_helpline =  helpline.helpline join user_helpline_link on helpline.helpline_id = user_helpline_link.helpline_id')
		->join('sms_template', 'sms_helpline.sms_template_id = sms_template.sms_template_id')	
		->join('staff', 'sms_helpline.sent_by_staff = staff.staff_id' )
		->join('user', 'sms_helpline.sent_by_staff = user.staff_id' )	
		->join('helpline_receiver', 'helpline_receiver.user_id = user.user_id and staff.staff_id = user.staff_id ' )	
		->where('user_helpline_link.user_id', $user['user_id'])		
		->order_by('date_created','desc');
		$this->db->limit($rows_per_page,$start);	
		$query = $this->db->get();	
		return $query->result();
	}

	function get_sms_sent_report_count(){
		$user = $this->session->userdata('logged_in');

		if($this->input->post('to_number')){
			$this->db->like('sms_helpline.to_receiver', $this->input->post('to_number'));
		}

		if($this->input->post('sent_status')){
			$this->db->where('sms_helpline.status_code',$this->input->post('sent_status'));
		}
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date = date("Y-m-d",strtotime($this->input->post("from_date")));
			$to_date = date("Y-m-d",strtotime($this->input->post("to_date")));
			$this->db->where('(date(date_created) BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$from_date;
			$to_date;
			if($this->input->post('from_date')){
				$from_date = date("Y-m-d",strtotime($this->input->post("from_date")));
				$to_date = $this->db->where('date(date_created)',date("Y-m-d"));
			}
			if($this->input->post('to_date')){
				$to_date = date("Y-m-d",strtotime($this->input->post("to_date")));
				$from_date = $this->db->where('date(date_created)',date("Y-m-d"));
			}
			$this->db->where('(date(date_created) BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}
		else{
			$this->db->where('date(date_created)',date("Y-m-d"));
		}
		if($this->input->post('helpline_id')){
			$this->db->where('helpline.helpline_id',$this->input->post('helpline_id'));
		}
		if($this->input->post('sms_template')){
			$this->db->where('sms_template.sms_template_id',$this->input->post('sms_template'));
		}
		
		$this->db->select('count(*) as count')
		->from('sms_helpline')
		->join('helpline', 'sms_helpline.from_helpline =  helpline.helpline join user_helpline_link on helpline.helpline_id = user_helpline_link.helpline_id')
		->join('sms_template', 'sms_helpline.sms_template_id = sms_template.sms_template_id')	
		->join('staff', 'sms_helpline.sent_by_staff = staff.staff_id' )
		->join('user', 'sms_helpline.sent_by_staff = user.staff_id' )	
		->join('helpline_receiver', 'helpline_receiver.user_id = user.user_id and staff.staff_id = user.staff_id ' )	
		->where('user_helpline_link.user_id', $user['user_id']);		
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
		if($this->input->post('call_direction')){
			$this->db->where('helpline_call.direction',$this->input->post('call_direction'));
		}
		if($this->input->post('call_type')){
			$this->db->where('helpline_call.call_type',$this->input->post('call_type'));
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
			$this->db->where('(summary_calls.date BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
			$from_date;
			$to_date;
			if($this->input->post('from_date')){
				$from_date = date("Y-m-d",strtotime($this->input->post("from_date")));
				$to_date = $this->db->where('summary_calls.date',date("Y-m-d"));
			}
			if($this->input->post('to_date')){
				$to_date = date("Y-m-d",strtotime($this->input->post("to_date")));
				$from_date = $this->db->where('date(start_time)',date("Y-m-d"));
			}
			$this->db->where('(summary_calls.date BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}
		else{
			$from_date = date("Y-m-d",strtotime("-1 months"));
			$to_date = date("Y-m-d");
			$this->db->where('(summary_calls.date BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
		}

		if($this->input->post('trend_type')){
	    	$trend=$this->input->post('trend_type');
			if($trend=="Month"){
				$this->db->select("DATE_FORMAT(summary_calls.date ,\"%b-%Y\") as datefield",false);
				$this->db->group_by('datefield');
			}
			else if($trend=="Year"){
				$this->db->select("DATE_FORMAT(summary_calls.date ,\"%Y\") as datefield",false);
				$this->db->group_by('datefield');
			}
			else{
				$this->db->select("DATE_FORMAT(summary_calls.date ,\"%d-%b-%Y\") as datefield",false);
				$this->db->group_by('datefield');
			}
		}
		else{
			$this->db->select("DATE_FORMAT(summary_calls.date ,\"%d-%b-%Y\") as datefield",false);
			$this->db->group_by('datefield');
		}
		if($this->input->post('helpline')){
			$this->db->where('summary_calls.helpline',$this->input->post('helpline'));
		}
		if($this->input->post('call_direction')){
			$this->db->where('summary_calls.call_direction',$this->input->post('call_direction'));
		}
		if($this->input->post('call_type')){
			$this->db->where('summary_calls.call_type',$this->input->post('call_type'));
		}

		$this->db->select("sum(call_count) as calls")
		->from('summary_calls')
		->order_by('summary_calls.date','asc');

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
			}else if($access == "any"){
				$this->db->where('(update_access = 1 OR reports_access=1)');						
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

	function getHelplineReceiversCount(){		
		
		
		if($this->input->post('helpline_id')){
			$this->db->where('helpline_receiver.helpline_id',$this->input->post('helpline_id'));
		}
		
		if($this->input->post('phone')){
			$this->db->like('helpline_receiver.phone',$this->input->post('phone'));
		}
		
		if($this->input->post('state')){
		 	$this->db->where('state.state_id',$this->input->post('state'));
		}

		if($this->input->post('district')){
		 	$this->db->where('helpline_receiver.district_id',$this->input->post('district'));
		}

		if($this->input->post('isdoctor')){
		    	if($this->input->post('isdoctor')=="Yes"){
				$this->db->like('helpline_receiver.doctor',1);
			}
			else{
				$this->db->like('helpline_receiver.doctor',0);
			}
		}
		
		if($this->input->post('outboundcall')){
		    	if($this->input->post('outboundcall')=="Yes"){
				$this->db->like('helpline_receiver.enable_outbound',1);
			}
			else{
				$this->db->like('helpline_receiver.enable_outbound',0);
			}
		}
		
		if($this->input->post('activitystatus')){
		    	if($this->input->post('activitystatus')=="Yes"){
				$this->db->like('helpline_receiver.activity_status',1);
			}
			else{
				$this->db->like('helpline_receiver.activity_status',0);
			}
		}
		
		$this->db->select("count(*) as count", false)
		->from('helpline_receiver')
		->join('helpline', 'helpline_receiver.helpline_id=helpline.helpline_id','left')
		->join('district', 'helpline_receiver.district_id=district.district_id','left')
		->join('state', 'district.state_id= state.state_id','left');
		$query = $this->db->get();
		return $query->result();
	}
	
	
	function getHelplineReceivers($data=array()){		
		if(isset($data['default_rowsperpage'])){
			$default_rowsperpage=$data['default_rowsperpage'];
		}
		else{
			$default_rowsperpage = 0;
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
		
		if($this->input->post('helpline_id')){
			$this->db->where('helpline_receiver.helpline_id',$this->input->post('helpline_id'));
		}

		if($this->input->post('state')){
		 	$this->db->where('state.state_id',$this->input->post('state'));
		 }		
		if($this->input->post('district')){
		 	$this->db->where('helpline_receiver.district_id',$this->input->post('district'));
			 }
		
		if($this->input->post('phone')){
			$this->db->like('helpline_receiver.phone',$this->input->post('phone'));
		}		
		
		
		if($this->input->post('isdoctor')){
		    	if($this->input->post('isdoctor')=="Yes"){
				$this->db->like('helpline_receiver.doctor',1);
			}
			else{
				$this->db->like('helpline_receiver.doctor',0);
			}
		}
		
		if($this->input->post('outboundcall')){
		    	if($this->input->post('outboundcall')=="Yes"){
				$this->db->like('helpline_receiver.enable_outbound',1);
			}
			else{
				$this->db->like('helpline_receiver.enable_outbound',0);
			}
		}
		
		if($this->input->post('activitystatus')){
		    	if($this->input->post('activitystatus')=="Yes"){
				$this->db->like('helpline_receiver.activity_status',1);
			}
			else{
				$this->db->like('helpline_receiver.activity_status',0);
			}
		}

		if($this->input->post('language')){
			$this->db->like('helpline_receiver_language.language_id',$this->input->post('language'));
		}

		if($this->input->post('proficiency')){
			$this->db->like('helpline_receiver_language.proficiency',$this->input->post('proficiency'));
		}
		
		if(isset($data['phone'])){
			$this->db->where('phone', '0' . $data['phone']);
		}
		$this->db->select("helpline_receiver.receiver_id, full_name, phone, email, CONCAT(district.district, '-' , state.state) as district, category, user_id, doctor, enable_outbound, app_id, activity_status,GROUP_CONCAT(language) AS language,GROUP_CONCAT(proficiency) AS proficiency, CONCAT(helpline.note, ' - ', helpline.helpline) as helpline,helpline_receiver_note", false)
		->from('helpline_receiver')
		->join('helpline', 'helpline_receiver.helpline_id=helpline.helpline_id','left')
		->join('district', 'helpline_receiver.district_id=district.district_id','left')
		->join('helpline_receiver_language', 'helpline_receiver.receiver_id=helpline_receiver_language.receiver_id','left')
		->join('language', 'language.language_id=helpline_receiver_language.language_id','left')
		->join('state', 'district.state_id= state.state_id','left')
		->order_by('full_name', 'asc')
		->group_by('receiver_id,full_name');
		if ($default_rowsperpage !=0){
			$this->db->limit($rows_per_page,$start);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function getHelplineReceiverByUserId($user_id){
		$this->db->select("helpline_receiver.receiver_id,helpline_receiver.phone,helpline_receiver.full_name,helpline_receiver.short_name,helpline_receiver.email,
		helpline_receiver.category,helpline_receiver.user_id,helpline_receiver.doctor,helpline_receiver.enable_outbound,helpline_receiver.enable_sms,helpline_receiver.app_id,helpline_receiver.helpline_id,helpline_receiver.activity_status,
		helpline_receiver.helpline_receiver_note,helpline.helpline,helpline.note")->from("helpline_receiver")->join('helpline','helpline_receiver.helpline_id = helpline.helpline_id')->where('user_id', $user_id);
		$result = $this->db->get()->result();
        return count($result) > 0 ? $result[0] : false;
	}

	function getHelplineReceiverById($receiver_id){
		$this->db->select("receiver_id,phone,full_name,short_name,email,district_id,category,user_id,doctor,enable_outbound,enable_sms,app_id,helpline_id,activity_status,helpline_receiver_note")->from("helpline_receiver")->where('receiver_id', $receiver_id);
        return $this->db->get()->result();
	}

	function getHelplineReceiverLinksById($receiver_id){
		$this->db->select("helpline_receiver_link.id,helpline_receiver_link.receiver_id,helpline_receiver_link.helpline_id,helpline.helpline,helpline.note")->from("helpline_receiver_link")->join('helpline','helpline_receiver_link.helpline_id = helpline.helpline_id')->where('receiver_id', $receiver_id);
        return $this->db->get()->result();
	}

	function get_helplines(){
		$this->db->select("helpline_id, helpline, note")->from("helpline");
        return $this->db->get()->result();
	}

	function get_sms_template($use_status=1){
		$hospitaldata = $this->session->userdata('hospital');	
		$hospital_id = $hospitaldata['hospital_id'];	
		
		$this->db->select("sms_template.helpline_id,helpline.helpline,sms_template_id,dlt_header, dlt_entity_id, template,template_name,sms_type,dlt_tid, use_status, edit_text_area,generate_by_query,generation_method,report_download_url, 
		default_sms",false)->from("sms_template")
		->join("helpline", "sms_template.helpline_id =  helpline.helpline join user_helpline_link on helpline.helpline_id = user_helpline_link.helpline_id")
		->order_by('sms_template.default_sms Desc');

		
		$user = $this->session->userdata('logged_in');
		$this->db->where("user_helpline_link.user_id", $user['user_id']);
		$this->db->where("(user_helpline_link.update_access=1 OR user_helpline_link.reports_access=1)");
		$this->db->where("sms_template.hospital_id", $hospital_id );
	 
		
		if ($use_status == 1){
			$this->db->where("use_status", 1);
		}		
		$this->db->order_by("template_name");
		$query = $this->db->get();
		return $query->result();
	}
	
	/*function get_sms_template_all(){
		$this->db->select('helpline_id,sms_template_id,dlt_header, dlt_entity_id, template,template_name,sms_type,dlt_tid, use_status, edit_text_area,generate_by_query,generation_method,report_download_url',false)->from('sms_template');		
		$this->db->order_by('template_name');
		$query = $this->db->get();
		return $query->result();
	}*/
	function get_sms_sent_status(){
		$this->db->select('status_code,status_text')->from('http_status_code');
		$query = $this->db->get();
		return $query->result();
	}

	function set_sms_helpline($calledId, $from, $template, $templateId, $smstype, $dlttid, $status_code, $status, $sms_id, $detailedStatusCode, $detailedStatus){
		$smshelpline = array();
		$smshelpline['from_helpline']=$calledId;
		$smshelpline['to_receiver']=$from;
		$smshelpline['sms_type']=$smstype;
		$smshelpline['sms_template_id']=$templateId;
		$smshelpline['dlt_tid']=$dlttid;
		$smshelpline['sms_body']=$template;
		$smshelpline['status_code']=$status_code;
		$smshelpline['status']=$status;		
		$smshelpline['sent_by_staff'] = $this->session->userdata('logged_in')['staff_id'];
		$smshelpline['date_sent'] = date("Y-m-d H:i:s");
		$smshelpline['sid']=$sms_id;
		$smshelpline['detailed_status_code']=$detailedStatusCode;
		$smshelpline['detailed_status']=$detailedStatus;

		$this->db->trans_start();
		$this->db->insert('sms_helpline',$smshelpline);
		$this->db->trans_complete();
		if($this->db->trans_status()==FALSE){
			return false;
		}
        else{
            return true;
        }	

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
            $helpline_receiver['phone'] = $this->input->post('phone');							
        }
		if($this->input->post('email')){														
            $helpline_receiver['email'] = $this->input->post('email');							
        }																
		if($this->input->post('category')){														
            $helpline_receiver['category'] = $this->input->post('category');							
        }
        
        	if($this->input->post('helpline_receiver_note')){														
            $helpline_receiver['helpline_receiver_note'] = $this->input->post('helpline_receiver_note');							
        }

        $helpline_receiver['user_id'] = $this->input->post('user_id') ? $this->input->post('user_id') : '0';

        $helpline_receiver['doctor'] = $this->input->post('doctor') ? $this->input->post('doctor') : '0';

        $helpline_receiver['enable_outbound'] = $this->input->post('enable_outbound') ? $this->input->post('enable_outbound') : '0';
        
        $helpline_receiver['app_id'] = $this->input->post('app_id') ? $this->input->post('app_id') : '';
        
        $helpline_receiver['helpline_id'] = $this->input->post('helpline_id') ? $this->input->post('helpline_id') : '0';

        $helpline_receiver['district_id'] = $this->input->post('district_id') ? $this->input->post('district_id') : '0';

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

			if ($this->input->post('mylanguage')){
				if (!($this->update_languages($receiver_id))) {
					return false;
				}
			}	
			return true;
		}  
	}

	function search_helpline_receiver($query=""){
		$search = array(
           'LOWER(full_name)'=>strtolower($query), 
           'phone'=>$query,
        );
		$this->db->select("receiver_id, phone, full_name, email")
			->from("helpline_receiver")
			->where("activity_status",1)
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
	
	function get_helpline_session_role(){
		$user = $this->session->userdata('logged_in');
		$this->db->select("helpline_session_role.helpline_session_role_id, helpline_session_role")
		->from('helpline_session_role');
		$query = $this->db->get();
		return $query->result();
	}

	function get_helpline_session(){
		$user = $this->session->userdata('logged_in');
		$this->db->select("helpline_session.helpline_session_id as helpline_session_id, helpline_session.helpline_id as helpline_id, session_name, monthday, weekday, from_time, to_time, session_status");
		$this->db->from('helpline_session');
		$this->db->join('helpline', 'helpline.helpline_id =  helpline_session.helpline_id');
		$this->db->where('helpline_session.session_status = 1');
		$query = $this->db->get();
		return $query->result();
	}
	
	function get_helpline_session_report_count(){
		if ($this->input->post('weekday')) {
			$this->db->where('hs.weekday',$this->input->post('weekday'));
		} 
		if ($this->input->post('helpline')) {
			$this->db->where('hs.helpline_id',$this->input->post('helpline'));
		}
		if ($this->input->post('role')){
			$this->db->where('hsp.helpline_session_role_id', $this->input->post('role'));
		}
		if ($this->input->post('session_name')){
			$this->db->where('hs.helpline_session_id',$this->input->post('session_name'));
		}

		$this->db->select("count(*) as count");
		$this->db->from('helpline_session_plan as hsp');
		$this->db->join('helpline_session as hs', 'hs.helpline_session_id=hsp.helpline_session_id');
		$this->db->join('helpline_session_role as role', 'hsp.helpline_session_role_id =role.helpline_session_role_id');
		$this->db->join('helpline', 'helpline.helpline_id= hs.helpline_id');
		$this->db->where('hs.session_status = 1');
		$this->db->where('hsp.soft_deleted = 0');
		// $this->db->group_by('hs.helpline_id');
		 $this->db->group_by('hs.helpline_session_id');
		 $this->db->order_by('hs.weekday');
		 $this->db->group_by('hsp.helpline_session_role_id');
		$query = $this->db->get();
		return $query->result();
	}

	function get_helpline_session_report($default_rowsperpage){
	
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
		if ($this->input->post('weekday')) {
	       echo("<script>console.log('PHP: weekday " . json_encode($this->input->post('weekday')) . "');</script>");
			$this->db->where('hs.weekday',$this->input->post('weekday'));
		} 
		if ($this->input->post('helpline')) {
			$this->db->where('hs.helpline_id',$this->input->post('helpline'));
		}
		if ($this->input->post('role')){
			$this->db->where('hsp.helpline_session_role_id', $this->input->post('role'));
		}
		if ($this->input->post('session_name')){
			$this->db->where('hs.helpline_session_id',$this->input->post('session_name'));
		}

		$this->db->select("helpline_session_plan_id, helpline.helpline_id as helpline_id, hs.helpline_session_id as helpline_session_id, weekday, helpline, helpline.note as note, helpline_session_role, session_name, count(hsp.receiver_id) as count_receiver_id");
		$this->db->from('helpline_session_plan as hsp');
		$this->db->join('helpline_session as hs', 'hs.helpline_session_id=hsp.helpline_session_id');
		$this->db->join('helpline_session_role as role', 'hsp.helpline_session_role_id =role.helpline_session_role_id');
		$this->db->join('helpline', 'helpline.helpline_id= hs.helpline_id');
		$this->db->where('hs.session_status = 1');
		$this->db->where('hsp.soft_deleted = 0');
		// $this->db->group_by('hs.helpline_id');
		 $this->db->group_by('hs.helpline_session_id');
		 $this->db->order_by('hs.weekday');
		 $this->db->group_by('hsp.helpline_session_role_id');
		 $this->db->limit($rows_per_page,$start);	
		$query = $this->db->get();
		return $query->result();
	}

	function insert_session_plan() {
		if ($this->input->post('session_role_id')) {
		   $session_role_id= $this->input->post('session_role_id');
		}
		if ($this->input->post('session_name_modal')) {
		 $session_id=$this->input->post('session_name_modal');
		}
		if($this->input->post('receiver_id')){
		 $receiver_id=$this->input->post('receiver_id');
		}

	       echo("<script>console.log('PHP: " . json_encode($this->input->post('session_name_modal')) . "');</script>");

		$this->db->select("helpline_session_plan_id");
		$this->db->where('helpline_session_id', $session_id);
	 	$this->db->where('receiver_id', $receiver_id);
		$this->db->where('helpline_session_role_id', $session_role_id);	
		$this->db->where('soft_deleted = 0');
		$this->db->from('helpline_session_plan');
		$query = $this->db->get();
	       echo("<script>console.log('PHP: " . json_encode($query->result()) . "');</script>");
	       echo("<script>console.log('PHP: num_rows " . json_encode($query->num_rows()) . "');</script>");
	    	if ($query->num_rows() > 0) {
	       echo("<script>console.log('PHP: In num_rows  < 0" . json_encode($query->num_rows()) . "');</script>");
				return false;
		}

		$data=array(
			'receiver_id'=>$this->input->post("receiver_id"),
			'helpline_session_id'=>$this->input->post("session_name_modal"),
			'helpline_session_role_id'=>$this->input->post("session_role_id"),
			'helpline_session_note'=>$this->input->post("session_note"),
			'created_by_staff_id'=>$this->session->userdata("logged_in")['staff_id'],
			'create_date_time'=>date("Y-m-d H:i:s"),
			'soft_deleted'=>0
		);


		// check if the combination of receiver_id and session_id already exists or not.
		$this->db->trans_start();
		$this->db->insert('helpline_session_plan',$data);
		$this->db->trans_complete();
		if($this->db->trans_status()===TRUE){
			return true;
		}
		else {
			$this->db->trans_rollback();
			return false;
		}

	       echo("<script>console.log('PHP: " . json_encode($session_role_id) . "');</script>");
	}

	function get_helpline_receiver_report($helpline_session_id,$default_rowsperpage) {
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
		//echo("<script>console.log('PHP: Query Model " . json_encode($helpline_session_id) . "');</script>");
			$this->db->select("hsp.receiver_id as receiver_id, hsp.helpline_session_id as helpline_session_id, helpline_receiver.full_name as full_name, helpline_receiver.email as email, helpline_receiver.phone as phone, hsp.helpline_session_plan_id as helpline_session_plan_id, hsp.helpline_session_role_id,hsr.helpline_session_role,hsr.helpline_session_role_id,hsp.helpline_session_note");
			$this->db->select("(SELECT GROUP_CONCAT(language.language) as languages FROM helpline_receiver JOIN helpline_receiver_language on helpline_receiver_language.receiver_id = helpline_receiver.receiver_id JOIN language on language.language_id = helpline_receiver_language.language_id WHERE helpline_receiver.receiver_id = hsp.receiver_id ORDER BY helpline_receiver_language.proficiency) as languages ");
			$this->db->from('helpline_session_plan as hsp');
			$this->db->join('helpline_session_role as hsr', 'hsr.helpline_session_role_id=hsp.helpline_session_role_id');
			$this->db->join('helpline_session as hs', 'hs.helpline_session_id=hsp.helpline_session_id');
			$this->db->join('helpline_receiver', 'hsp.receiver_id = helpline_receiver.receiver_id');
			$this->db->where('hs.session_status = 1');
			$this->db->where('hsp.soft_deleted = 0');
			$this->db->where('hs.helpline_session_id', $helpline_session_id);
			$this->db->order_by('hsr.helpline_session_role','asc');
			$this->db->limit($rows_per_page,$start);	
			$query = $this->db->get();

		return $query->result();
	}
	
	function get_helpline_receiver_report_count($helpline_session_id) {
		//echo("<script>console.log('PHP: Query Model " . json_encode($helpline_session_id) . "');</script>");
			$this->db->select("count(*) as count");
			
			$this->db->from('helpline_session_plan as hsp');
			$this->db->join('helpline_session_role as hsr', 'hsr.helpline_session_role_id=hsp.helpline_session_role_id');
			$this->db->join('helpline_session as hs', 'hs.helpline_session_id=hsp.helpline_session_id');
			$this->db->join('helpline_receiver', 'hsp.receiver_id = helpline_receiver.receiver_id');
			$this->db->where('hs.session_status = 1');
			$this->db->where('hsp.soft_deleted = 0');
			$this->db->where('hs.helpline_session_id', $helpline_session_id);
			$this->db->order_by('hsr.helpline_session_role','asc');
			$query = $this->db->get();

		return $query->result();
	}
	
	
	function update_helpline_session_plan_id($helpline_session_plan_id) {
		$helpline_session_plan_id = $this->input->post('helpline_update_session_plan_id');
		$this->db->trans_start();
		$this->db->set('helpline_session_role_id', $this->input->post('role'));
	 	$this->db->set('helpline_session_note', $this->input->post('edit_note'));
		$this->db->where('helpline_session_plan.helpline_session_plan_id', $helpline_session_plan_id);
		$this->db->update('helpline_session_plan');
		$this->db->trans_complete();
		if($this->db->trans_status()===TRUE){
			return true;
		}
		else {
			$this->db->trans_rollback();
			return false;
		}


	}
	
	
	function delete_helpline_session_plan_id($helpline_session_plan_id) {
		$helpline_session_plan_id = $this->input->post('helpline_update_session_plan_id');
		echo("<script>console.log('PHP: Model " . json_encode($helpline_session_plan_id) . "');</script>");
		$this->db->trans_start();
		// UPDATE `helpline_session_plan` SET `soft_deleted` = '1' WHERE `helpline_session_plan`.`helpline_session_plan_id` = 5;
		$this->db->set('helpline_session_plan.soft_deleted', 1);
		$this->db->set('soft_deleted_by_staff_id', $this->session->userdata("logged_in")['staff_id']);
	 	$this->db->set('soft_deleted_by_date_time', date("Y-m-d H:i:s"));
		$this->db->where('helpline_session_plan.helpline_session_plan_id', $helpline_session_plan_id);
		$this->db->update('helpline_session_plan');
		$this->db->trans_complete();
		if($this->db->trans_status()===TRUE){
			return true;
		}
		else {
			$this->db->trans_rollback();
			return false;
		}


	}
	function get_weekdays_array() {
		$data = 	array('0' => 'Sunday',
				'1' => 'Monday' ,
				'2'  => 'Tuesday' ,
				'3' => 'Wednesday',
				'4' => 'Thursday',
				'5' => 'Friday' ,
				'6' => 'Saturday'
				 );
		return $data;
	}
	function get_weekdays() {
		$data = 	array('1' => 'Monday' ,
				'2'  => 'Tuesday' ,
				'3' => 'Wednesday',
				'4' => 'Thursday',
				'5' => 'Friday' ,
				'6' => 'Saturday' ,
				'7' => 'Sunday' );
		return $data;
	}
	function get_helpline_sessions_for_receiver() {
		$receiver_id = $this->input->post('view_receiver_id');
		$this->db->select("hs.session_name,hsr.helpline_session_role,hs.weekday,hs.helpline_id,hsp.helpline_session_note");
		$this->db->where("hsp.receiver_id", $receiver_id);
		$this->db->from('helpline_session_plan as hsp');
		$this->db->join('helpline_session as hs', 'hs.helpline_session_id = hsp.helpline_session_id');
		$this->db->join('helpline_session_role as hsr', 'hsr.helpline_session_role_id=hsp.helpline_session_role_id');
	 	$this->db->where('hs.session_status = 1');
		$this->db->where('hsp.soft_deleted = 0');
		$this->db->order_by('hs.weekday','asc');
		$this->db->order_by('hsr.helpline_session_role','asc');
		$query = $this->db->get();
//			echo("<script>console.log('PHP: report_sessions" . json_encode($query->result()) . "');</script>");
		return $query->result();
	}
	
	function get_proficiency() {
		$data = 	array('1' => 'Expert' ,
				'2'  => 'Intermediate' ,
				'3' => 'Beginner');
		return $data;
	}

	function get_helpline_receiver_languages($receiver_id="") {
		$this->db->select("language.language_id as language_id, language, receiver_id, proficiency");
		$this->db->from("helpline_receiver_language");
		$this->db->join("language", "helpline_receiver_language.language_id = language.language_id");
		$this->db->where("receiver_id", $receiver_id);
		$query = $this->db->get();
		return $query->result();
	}

	function check_language_exists($receiver_id, $language_id) {
		$search = array(
           		'receiver_id'=>$receiver_id, 
           		'language_id'=>$language_id,
        	);
	
		$this->db->select("receiver_id");
		$this->db->from("helpline_receiver_language");
		$this->db->where('receiver_id', $receiver_id);
		$this->db->where('language_id', $language_id);
		$query=$this->db->get();
		$num_rows = $query->num_rows();
	
		// echo("<script>console.log('to_number: proficiency [i] " .$num_rows. "');</script>");
		if ($num_rows > 0) {
			return true;
		}	
		return false;
	}	
	
	function update_languages($receiver_id) {
			// echo("<script>console.log('to_number: Am I here" .$this->input->post('myproficiency'). "');</script>");
		
		$mylanguages = $this->input->post('mylanguage');
		$myproficiency = $this->input->post('myproficiency');
		
	
		$this->db->trans_start();
		for ($i = 0 ; $i < count($mylanguages); $i++) {
			// echo("<script>console.log('to_number: index " .$i. "');</script>");
			// echo("<script>console.log('to_number: languages [i] " .$mylanguages[$i]. "');</script>");
			// echo("<script>console.log('to_number: proficiency [i] " .$myproficiency[$i]. "');</script>");
			
			if ($this->check_language_exists($receiver_id, $mylanguages[$i])) {
				echo("<script>console.log('Language already exists " .$mylanguages[$i]. "');</script>");
				continue;
			}
			$data=array(
				'receiver_id'=>$receiver_id,
				'language_id'=>$mylanguages[$i],
				'proficiency'=>$myproficiency[$i]);
			$this->db->insert('helpline_receiver_language',$data);
		}
		$this->db->trans_complete();
		if($this->db->trans_status()!==TRUE){
			$this->db->trans_rollback();
			// echo("<script>console.log('Language insertion failed " .$mylanguages. "');</script>");
			return false;
		}

		return true;	
	}

	function helpline_trend_unic()
	{
		if($this->input->post('from_date') && $this->input->post('to_date'))
		{
			$from_date = date("Y-m-d",strtotime($this->input->post("from_date")));
			$to_date = date("Y-m-d",strtotime($this->input->post("to_date")));
			$this->db->where('(summary_unique_callers.date BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
			$this->db->group_by('summary_unique_callers.date');
		}
		else if($this->input->post('from_date') || $this->input->post('to_date'))
		{
			$from_date;
			$to_date;
			if($this->input->post('from_date')){
				$from_date = date("Y-m-d",strtotime($this->input->post("from_date")));
				$to_date = $this->db->where('summary_unique_callers.date',date("Y-m-d"));
			}
			if($this->input->post('to_date')){
				$to_date = date("Y-m-d",strtotime($this->input->post("to_date")));
				$from_date = $this->db->where('date(start_time)',date("Y-m-d"));
			}
			$this->db->where('(summary_unique_callers.date BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
			$this->db->group_by('summary_unique_callers.date');
		}
		else{
			$from_date = date("Y-m-d",strtotime("-1 months"));
			$to_date = date("Y-m-d");
			$this->db->where('(summary_unique_callers.date BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
			$this->db->group_by('summary_unique_callers.date');
		}

		if($this->input->post('helpline'))
		{
			$this->db->where("helpline",$this->input->post('helpline'));
		}
		$this->db->select("date,sum(unique_callers) as calls")
		->from('summary_unique_callers')
		->order_by('summary_unique_callers.date','asc');

		$query = $this->db->get();
		return $query->result();
	}
	function get_receiver_activity_report($default_rowsperpage){
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
		
		$user = $this->session->userdata('logged_in');


		if($this->input->post('helpline_id')){
			$this->db->where('helpline.helpline_id',$this->input->post('helpline_id'));
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

		$this->db->where('(start_time BETWEEN "'.$from_date.'" AND "'.$to_date.'")');

		if($this->input->post('helpline_id')){
			$this->db->where('helpline.helpline_id',$this->input->post('helpline_id'));
		}

		if($this->input->post('from_number')){
			$this->db->like('helpline_receiver.phone',$this->input->post('from_number'));
		}
		
		if ($this->input->post('year_month_trend')) {
		
			$this->db->select("helpline_receiver.full_name as Receiver, helpline_receiver.phone as Phone,
			COUNT(DISTINCT (DATE(helpline_call.start_time)) ) AS ActiveDays,
			YEAR(helpline_call.start_time) as Year,
			MONTH(helpline_call.start_time) as Month,
			sum(case when helpline_call.direction='incoming' then 1 else 0 end) as IncomingCalls,
			sum(case when helpline_call.direction='outbound-dial' then 1 else 0 end) as OutgoingCalls,
			COUNT(*) as TotalCalls")
			->from('helpline_call')
			->join('helpline', 'helpline_call.to_number=helpline.helpline','left')
			->join('helpline_receiver','helpline_call.dial_whom_number = helpline_receiver.phone','left')
			->where('helpline_call.call_type ="completed"')
			->group_by('Receiver')
			->group_by('Year')
			->group_by('Month')
			->order_by('Receiver, Year, Month');

		}
		else {
			$this->db->select("helpline_receiver.full_name as Receiver, helpline_receiver.phone as Phone,
		COUNT(DISTINCT (DATE(helpline_call.start_time)) ) AS ActiveDays,
		sum(case when helpline_call.direction='incoming' then 1 else 0 end) as IncomingCalls,
			sum(case when helpline_call.direction='outbound-dial' then 1 else 0 end) as OutgoingCalls,
			COUNT(*) as TotalCalls")
		->from('helpline_call')
		->join('helpline', 'helpline_call.to_number=helpline.helpline','left')
		->join('helpline_receiver','helpline_call.dial_whom_number = helpline_receiver.phone','left')
		->where('helpline_call.call_type ="completed" AND helpline_call.direction = "incoming"')
		->group_by('Receiver')
		->order_by('Receiver');
		}
	
		$this->db->limit($rows_per_page,$start);	
		$query = $this->db->get();
		//echo("<script>console.log('PHP: weekday " . json_encode($query->result()) . "');</script>");

		return $query->result();
	}
	
	function get_receiver_call_activity_report_count(){
		$user = $this->session->userdata('logged_in');

		if($this->input->post('helpline_id')){
			$this->db->where('helpline.helpline_id',$this->input->post('helpline_id'));
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

		$this->db->where('(start_time BETWEEN "'.$from_date.'" AND "'.$to_date.'")');

		if($this->input->post('helpline_id')){
			$this->db->where('helpline.helpline_id',$this->input->post('helpline_id'));
		}

		if($this->input->post('phone')){
			$this->db->like('helpline_receiver.phone',$this->input->post('phone'));
		}

		if ($this->input->post('year_month_trend')) {
		
			$this->db->select('count(DISTINCT helpline_receiver.full_name, YEAR(helpline_call.start_time), MONTH(helpline_call.start_time)) as count')
			->from('helpline_call')
			->join('helpline', 'helpline_call.to_number=helpline.helpline','left')
			->join('helpline_receiver','helpline_call.dial_whom_number = helpline_receiver.phone','left')
			->where('helpline_call.call_type ="completed"');
		}
		else {
			$this->db->select('count(DISTINCT helpline_receiver.full_name) as count')
			->from('helpline_call')
			->join('helpline', 'helpline_call.to_number=helpline.helpline','left')
			->join('helpline_receiver','helpline_call.dial_whom_number = helpline_receiver.phone','left')
			->where('helpline_call.call_type ="completed"');
		}

		/*$this->db->select("count(DISTINCT DATE(helpline_call.start_time),helpline_receiver.full_name) as count",FALSE)
		->from('helpline_call')
		->join('helpline', 'helpline_call.to_number=helpline.helpline')
		->join('user_helpline_link', 'helpline.helpline_id = user_helpline_link.helpline_id')
		->join('helpline_receiver','helpline_call.dial_whom_number = helpline_receiver.phone')
		->where('helpline_call.call_type','completed')			
		->where('user_helpline_link.user_id', $user['user_id']);*/
		
		$query = $this->db->get();
		return $query->result();
	}
	

}
?>
