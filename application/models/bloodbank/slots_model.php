<?php 
class Slots_model extends CI_Model{

	function __construct(){
		parent::__construct();
	}// __construct

	function create(){	
		$userdata=$this->session->userdata('hospital');
		$hospital=$userdata['hospital_id'];
		$data=array();
		$date=$this->input->post('from_date');
		$to_date=$this->input->post('to_date');
		$from_time=$this->input->post('from_time');
		$to_time=$this->input->post('to_time');
		$max_app=$this->input->post('max_app');
		$working_days=$this->input->post('days');
		$schedule_count=count($from_time);
		while(strtotime($date) <= strtotime($to_date)){
			if(!in_array(date("w",strtotime($date)),$working_days)){
			$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
			continue;
			} 
			for($i=0;$i<$schedule_count;$i++){
				$data[]=array(
					'date'=>$date,
					'from_time'=>$from_time[$i],
					'to_time'=>$to_time[$i],
					'no_appointments'=>$max_app[$i],
					'hospital_id'=>$hospital
				);
			}
			$date = date ("Y-m-d", strtotime("+1 day", strtotime($date)));
		}
		$this->db->trans_start();	
		$this->db->insert_batch('bb_slot', $data);  
	    $this->db->trans_complete();
	    
		if ($this->db->trans_status() === FALSE)
		{
			return false;
		}
		else
			return true;
	}// create

	function get_dates($hospital_id){
		$this->db
		->select("slot_id, DATE_FORMAT(date,'%a, %D %b')date, SUM(no_appointments) no_appointments , SUM( count ) no_bookings",FALSE)
		->from("
		(SELECT bb_slot.slot_id, date, no_appointments, count( bb_app_slot_link.slot_id ) count
		FROM `bb_slot`
		LEFT JOIN bb_app_slot_link ON bb_slot.slot_id = bb_app_slot_link.slot_id
		WHERE date>CURDATE() AND hospital_id=$hospital_id
		GROUP BY slot_id,date ) as tab",FALSE)
		->group_by('date');
		$query = $this->db->get();
		return $query->result();
	}// get_dates

	function get_slots($slot_id,$hospital_id){
		$this->db
		->select("bb_slot.slot_id,date,DATE_FORMAT(from_time,'%h:%i%p')from_time,DATE_FORMAT(to_time,'%h:%i%p')to_time,no_appointments,(no_appointments - count(bb_app_slot_link.slot_id))available",FALSE)
		->from("bb_slot")
		->join("bb_app_slot_link","bb_slot.slot_id=bb_app_slot_link.slot_id","left")
		->where("date=(SELECT date FROM bb_slot WHERE slot_id=$slot_id)")
		->where('hospital_id',$hospital_id)
		->group_by("slot_id");
		$query=$this->db->get();
		return $query->result();
	}// get_slots

	function get_slot($slot_id){
		$this->db->select("slot_id,date,DATE_FORMAT(from_time,'%h:%i%p')from_time,DATE_FORMAT(to_time,'%h:%i%p')to_time",FALSE)->from("bb_slot")->where('slot_id',$slot_id)->limit(1);
		$query=$this->db->get();
		return $query->result();
	}// get_slot

	function register_appointment($slot_id){

		$userdata=$this->session->userdata('hospital');
		$hospital=$userdata['hospital_id'];

		$data=array(
			'name'=>$this->input->post('name'),
			'dob'=>$this->input->post('dob'),
			'age'=>$this->input->post('age'),
			'sex'=>$this->input->post('gender'),
			'maritial_status'=>$this->input->post('maritial_status'),
			'occupation'=>$this->input->post('occupation'),
			'parent_spouse'=>$this->input->post('parent_spouse'),
			'blood_group'=>$this->input->post('blood_group'),
			'phone'=>$this->input->post('mobile'),
			'email'=>$this->input->post('email'),
			'address'=>$this->input->post('address'),
			'alerts'=>$this->input->post('alert'),
			'hospital_id'=>$hospital
		);
		$this->db->trans_start();
		$this->db->insert('blood_donor',$data);
		$donor_id=$this->db->insert_id();
		$data=array(
			'donor_id'=>$donor_id,
			'slot_id'=>$slot_id,
			'datetime'=>date('Y-m-d H:m:s'),
			'status'=>'pending',
			'hospital_id'=>$hospital
		);
		$this->db->insert('bb_appointment',$data);
		$appointment_id=$this->db->insert_id();
		$data=array(
			'slot_id'=>$slot_id,
			'appointment_id'=>$appointment_id
		);
		$this->db->insert('bb_app_slot_link',$data);
		if($this->db->trans_complete()){
			$this->db->select('bb_appointment.appointment_id,name,age,sex,blood_group,phone,email,address,DATE_FORMAT(date,"%a, %d %b,%Y")date,DATE_FORMAT(from_time,"%h:%i%p")from_time,DATE_FORMAT(to_time,"%h:%i%p")to_time',FALSE)->from('blood_donor')
				->join('bb_appointment','blood_donor.donor_id=bb_appointment.donor_id')
				->join('bb_app_slot_link','bb_appointment.appointment_id=bb_app_slot_link.appointment_id','left')
				->join('bb_slot','bb_app_slot_link.slot_id=bb_slot.slot_id','left')
				->where('bb_appointment.appointment_id',$appointment_id)
				->limit(1);
			$query=$this->db->get();
			return $query->result();
		}
		else 
			return false;
	}// register_appointment
}// Slots_model
?>
