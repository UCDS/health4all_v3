<?php 
class Staff_model extends CI_Model{
	function __construct(){
		parent::__construct();
		$this->config->load('ipinfo');
	}
	//login() accepts the username and password, searches the database for match and if found, returns the 
	//query result else returns false
	function login($username, $password){
	   $this -> db -> select('user.*');
	   $this -> db -> from('user');
	   $this -> db -> where('username', $username);
	   $this -> db -> where('password', MD5($password));
	 
	   $query = $this -> db -> get();
	   if($query -> num_rows() > 0)
	   {
	     return $query->result();
	   }
	   else
	   {
	     return false;
	   }
	}
	function get_client_ip(){
		
	}
	//save_user_signin() accepts the username and loginstatus, and store the login activity
	function save_user_signin($username, $loginstatus){
	        $ipaddress = '';
    		if (isset($_SERVER['HTTP_CLIENT_IP'])) {
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
	   	} else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
	    	} else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
	    	} else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
	    	} else if (isset($_SERVER['HTTP_FORWARDED'])) {
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
	    	} else if (isset($_SERVER['REMOTE_ADDR'])) {
        		$ipaddress = $_SERVER['REMOTE_ADDR'];
    		} else {
        		$ipaddress = 'UNKNOWN';
          	}
    		
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$os_platform  = "Unknown OS Platform";

    		$os_array     = array(
                          '/windows nt 10/i'      =>  'Windows 10',
                          '/windows nt 6.3/i'     =>  'Windows 8.1',
                          '/windows nt 6.2/i'     =>  'Windows 8',
                          '/windows nt 6.1/i'     =>  'Windows 7',
                          '/windows nt 6.0/i'     =>  'Windows Vista',
                          '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                          '/windows nt 5.1/i'     =>  'Windows XP',
                          '/windows xp/i'         =>  'Windows XP',
                          '/windows nt 5.0/i'     =>  'Windows 2000',
                          '/windows me/i'         =>  'Windows ME',
                          '/win98/i'              =>  'Windows 98',
                          '/win95/i'              =>  'Windows 95',
                          '/win16/i'              =>  'Windows 3.11',
                          '/macintosh|mac os x/i' =>  'Mac OS X',
                          '/mac_powerpc/i'        =>  'Mac OS 9',
                          '/linux/i'              =>  'Linux',
                          '/ubuntu/i'             =>  'Ubuntu',
                          '/iphone/i'             =>  'iPhone',
                          '/ipod/i'               =>  'iPod',
                          '/ipad/i'               =>  'iPad',
                          '/android/i'            =>  'Android',
                          '/blackberry/i'         =>  'BlackBerry',
                          '/webos/i'              =>  'Mobile'
                    );

    		foreach ($os_array as $regex => $value)
        		if (preg_match($regex, $user_agent))
            			$os_platform = $value;
            	
            	$browser        = "Unknown Browser";

    		$browser_array = array(
                            '/msie/i'      => 'Internet Explorer',
                            '/firefox/i'   => 'Firefox',
                            '/safari/i'    => 'Safari',
                            '/chrome/i'    => 'Chrome',
                            '/edge/i'      => 'Edge',
                            '/opera/i'     => 'Opera',
                            '/netscape/i'  => 'Netscape',
                            '/maxthon/i'   => 'Maxthon',
                            '/konqueror/i' => 'Konqueror',
                            '/mobile/i'    => 'Handheld Browser'
                     );

    		foreach ($browser_array as $regex => $value)
        	if (preg_match($regex, $user_agent))
            		$browser = $value;
            	$token = $this->config->item('ipinfo_api_token');
            	//echo("<script>console.log('IP Info: " . $token . "');</script>");
            	$details = "IP Address: ".$ipaddress;
		$details = $details.", Browser: ".$browser;
		$details = $details.", OS: ".$os_platform;
		if($ipaddress!='127.0.0.1' && $ipaddress!='localhost'){
			$arrContextOptions=array(
      				"ssl"=>array(
           				"verify_peer"=>false,
            				"verify_peer_name"=>false,
        			),
    			); 
            		$json   = file_get_contents("https://ipinfo.io/$ipaddress/geo?token=$token",false, stream_context_create($arrContextOptions));
			$json     = json_decode($json, true);
			if( isset( $json['country'] ) ){
   				$details = $details.", Country: ".$json['country'];
			}
			if( isset( $json['region'] ) ){
   					$details = $details.", Region: ".$json['region'];
			}
			if( isset( $json['city'] ) ){
   				$details = $details.", City: ".$json['city'];
			}
			if( isset( $json['loc'] ) ){
   				$details = $details.", Location: ".$json['loc'];
			}
			if( isset( $json['timezone'] ) ){
   				$details = $details.", Timezone: ".$json['timezone'];
			}
		}
		
		
	
		
	  	$data=array(
			'username'=>$username,
			'signin_date_time'=>date("Y-m-d H:i:s"),
			'is_success'=>$loginstatus,
			'details'=>$details
			);
		$this->db->trans_start();
		$this->db->insert('user_signin',$data);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			return false;
		}
		else return true;
	}
	
	//user_function() takes user ID as parameter and returns a list of all the functions the user has access to.
	function user_function($user_id){
		$this->db->select('user_function_id,user_function,add,edit,view,remove')->from('user')
		->join('user_function_link','user.user_id=user_function_link.user_id')
		->join('user_function','user_function_link.function_id=user_function.user_function_id')
		->where('user_function_link.user_id',$user_id)
                ->where('user_function_link.active','1');
		$query=$this->db->get();
		
		return $query->result();
	}
	
	//user_hospital() takes user ID as parameter and returns a list of all the hospitals the user has access to.	
	function user_hospital($user_id = false){
		if(!!$user_id)
			$this->db->where('user_hospital_link.user_id',$user_id);
		$this->db->select("hospital.hospital_id,hospital,hospital_short_name,description,place,district.district,state.state,logo,telehealth,helpline.helpline as helpline,helpline.note as helpline_note,CONCAT(hospital,' - ',hospital_short_name,IFNULL(CONCAT(' - ',place),''),IFNULL(CONCAT(' - ',district.district ),''),IFNULL(CONCAT(' - ',state.state),'')) as customdata",false)->from('user')
		->join('user_hospital_link','user.user_id=user_hospital_link.user_id')
		->join('hospital','user_hospital_link.hospital_id=hospital.hospital_id')	
		->join('helpline','hospital.helpline_id=helpline.helpline_id','left')
		->join('district','hospital.district_id=district.district_id','left')
		->join('state','state.state_id=district.state_id','left')	
		->group_by('hospital.hospital_id')			
		->order_by('hospital');
		$query=$this->db->get();
		return $query->result();
	}
	//user_department() takes user ID as parameter and returns a list of all the departments the user has access to.
	function user_department($user_id){
		$this->db->select('department.department_id,department,department_email')->from('user')
		->join('user_department_link','user.user_id=user_department_link.user_id')
		->join('department','user_department_link.department_id=department.department_id')
		->where('user_department_link.user_id',$user_id);
		$query=$this->db->get();
		return $query->result();
	}
	//physical_address() takes no parameters; returns a list of all the physcial addresses and the functions they have access to.
	function physical_address(){
		$this->db->select('user_function, physical_address')->from('physical_function_link')
		->join('user_function','physical_function_link.function_id=user_function.user_function_id');
		$query=$this->db->get();
		return $query->result();
	}
	
	//get_department() selects the clinical departments from the database and returns the result
	function get_department($clinical=1){
		$hospital=$this->session->userdata('hospital');
		if(!!$hospital){
			$this->db->where('hospital_id',$hospital['hospital_id']);
		}		
		if($clinical != -1){
			$this->db->where('clinical',$clinical);
		}
		$this->db->select("hospital_id,department_id,department")->from("department")->order_by('department');
		$query=$this->db->get();
		return $query->result();
	}
	
	//get_appointment_status() selects the clinical departments from the database and returns the result
	function get_appointment_status(){
		$hospital=$this->session->userdata('hospital');
		if(!!$hospital){
			$this->db->where('hospital_id',$hospital['hospital_id']);
		}		
		
		$this->db->select("id,appointment_status,is_default")->from("appointment_status");
		$query=$this->db->get();
		return $query->result();
	}
	
	function get_areas(){
		$hospital=$this->session->userdata('hospital');
		if(!!$hospital){
			$this->db->where('hospital_id',$hospital['hospital_id']);
		}
		$this->db->select("department.hospital_id,department.department, area.*")
					->from("area")
					->join("department","department.department_id = area.department_id","left")
					->order_by('department');
		$query=$this->db->get();
		return $query->result();
	}
	//get_department() selects the clinical departments from the database and returns the result
	function get_list_department(){
		$hospital=$this->session->userdata('hospital');
		$this->db->select("list_department_id,department")->from("list_department")->order_by('department');
		$query=$this->db->get();
		return $query->result();
	}
	
	//get_area() selects the areas from the database and returns the result
	function get_area(){
		$hospital=$this->session->userdata('hospital');
		$this->db->where('hospital_id',$hospital['hospital_id']);
		$this->db->select("area_id,area.department_id,area_name")->from("area")->join('department','area.department_id = department.department_id');
		$query=$this->db->get();
		return $query->result();
	}
	//get_unit() selects the units from the database and returns the result
	function get_unit(){
		$hospital=$this->session->userdata('hospital');
		$this->db->where('hospital_id',$hospital['hospital_id']);
		$this->db->select("unit.department_id,unit_id,unit_name")->from("unit")->join('department','unit.department_id = department.department_id');
		$query=$this->db->get();
		return $query->result();
	}
	//get_district() selects the districts from the database and returns the result
	function get_district(){
		$this->db->select("district_id,district,state.state_id,state.state,district_alias,CONCAT(district,'-',state.state) as custom_data",FALSE)
		->from("district")
		->join('state', 'district.state_id=state.state_id');
		$this->db->order_by('district','ASC');
		$query=$this->db->get();
		return $query->result();
	}
	
	//get_states() selects the districts from the database and returns the result
	function get_states(){
		$this->db->select("state_id,state",FALSE)
		->from("state");
		 $this->db->order_by('state','ASC');
		$query=$this->db->get();
		return $query->result();
	}
	function get_district_codes(){
		
		if( $this->input->post('country') != null && strlen($this->input->post('country')) > 0)
			$this->db->where('country_code',$this->input->post('country'));
		else	
			$this->db->where('country_code','IN');
		if( $this->input->post('state') != null && strlen($this->input->post('state')) > 0)
			$this->db->where('state_code',$this->input->post('state'));
		else
			$this->db->where('state_code','AP');
		$this->db->select("place_code,place_name")->from("places_table");
		$query=$this->db->get();
		return $query->result();
	}
	//get_id_proof_type() selects the ID Proof types from the database and returns the result
	function get_id_proof_type(){
		$this->db->select("id_proof_type_id,id_proof_type")->from("id_proof_type");
		$query=$this->db->get();
		return $query->result();
	}
	//get_occupations() selects the occupations from the database and returns the result
	function get_occupations(){
		$this->db->select("occupation_id,occupation")->from("occupation");
		$query=$this->db->get();
		return $query->result();
	}
	//get_user_function() selects the functions from the database and returns the result
	function get_user_function(){
		$this->db->select("user_function_id,user_function,description")->from("user_function");
		$query=$this->db->get();
		return $query->result();
	}
	//get_staff() selects the staff details from the database and returns the result
	function get_staff($department=0){
		if(!!$department)
			$this->db->where('department',$department);
		$this->db->select("staff.staff_id,staff.hospital_id,hospital.hospital, staff.designation, 
			CONCAT(IF(first_name!='',first_name,''),' ',IF(last_name!='',last_name,'')) staff_name,
			department, user.user_id, user.username, staff.phone, staff.mci_flag, staff.specialisation",
			false)
		->from("staff")
		->join('hospital', 'staff.hospital_id=hospital.hospital_id')
		->join('department','staff.department_id=department.department_id', 'left')
		->join('user','staff.staff_id=user.staff_id', 'left');
		$query=$this->db->get();
		return $query->result();
	}
	function get_transport_log($status=0,$transport_type="p"){
		if($status=="active") {
			$this->db->where('end_date_time','0000-00-00 00:00:00');
		}
		if($this->input->post('selected_patient')){
			$this->db->where('visit_id',$this->input->post('selected_patient'));
		}
		else if($this->input->post('visit_id')){
			$this->db->where('visit_id',$this->input->post('visit_id'));
		}
		if($transport_type=="np"){
			$this->db->where('transport_type',2);
		}
		else $this->db->where('transport_type',1);
		$this->db->select("transport.*,fa.area_name from_area, ta.area_name to_area,CONCAT(IF(first_name!='',first_name,''),' ',IF(last_name!='',last_name,'')) transported_by",false)
		->from("transport")
		->join('area fa','transport.from_area_id=fa.area_id')
		->join('area ta','transport.to_area_id=ta.area_id')
		->join('staff','transport.staff_id=staff.staff_id');
		$query=$this->db->get();
		return $query->result();
	}
	function get_transport_defaults(){
		$this->db->select('primary_key,default_value')->from('default_setting')->where_in('primary_key',array('from_area_id','to_area_id','from_department_id','to_department_id'));
		$query = $this->db->get();
		return $query->result();
	}
	//upload_form() takes the post variables and inserts data into the form and form_layout tables
	function upload_form(){
		$hospital = $this->session->userdata('hospital');
		//storing all the post variables and json variables into local variables.
		$fields=json_decode($this->input->post('fields'));
		$form_name=$this->input->post('form_name');
		$form_type=$this->input->post('form_type');
		$columns=$this->input->post('columns');
		$print_layout=$this->input->post('print_layout');
		$print_layout_a6=$this->input->post('print_layout_a6');
    	$count=count($fields->field_name); //count of the number of fields
		//building an array to insert into form table.
		$form_data=array(
			'form_name'=>$form_name,
			'form_type'=>$form_type,
			'num_columns'=>$columns,
			'print_layout_id'=>$print_layout,
			'a6_print_layout_id'=>$print_layout_a6,
			'hospital_id'=>$hospital['hospital_id']
		);
		$this->db->trans_start(); //Transaction starts
		$this->db->insert('form',$form_data); //Insert the form data array into the "form" table
		$form_id=$this->db->insert_id();//get the form_id from the inserted record
		$fields_data=array();
		for($i=0;$i<$count;$i++){ //loop for the number of fields
			//build the fields data as an array of arrays having the column names of "form_layout" table in database.
			$fields_data[]=array(
				'field_name'=>$fields->field_name[$i],
				'mandatory'=>$fields->mandatory[$i],
				'form_id'=>$form_id
			);
		}
		//insert all the fields into form_layout using insert_batch() 
		$this->db->insert_batch('form_layout',$fields_data);
		$this->db->trans_complete(); //Transaction Completed
		if($this->db->trans_status()===FALSE){
			//if the transaction failed,return false.
			return false;
		}
		else return true;
	}
	//get_visit_name() selects the visit names from the database and returns the result
	function get_visit_name($all=0){
		if($all==0){
			$hospital = $this->session->userdata('hospital');
			$this->db->where('hospital_id',$hospital['hospital_id']);
		}
		else {
			$userdata=$this->session->userdata('logged_in');        
                    	$user_id=$userdata['user_id'];  
                    	$this->db->where('user.user_id',$user_id);
                    	$this->db->join('hospital','hospital.hospital_id=visit_name.hospital_id');
                    	$this->db->join('user_hospital_link','user_hospital_link.hospital_id=hospital.hospital_id');
                    	$this->db->join('user','user.user_id=user_hospital_link.user_id');
					
		}
		$this->db->where('inuse',1);
		$this->db->select("visit_name.hospital_id,visit_name_id,visit_name")->from("visit_name");
		$query=$this->db->get();
		return $query->result();
	}
	//get_print_layouts() selects the print layouts from the database and returns the result
	function get_print_layouts(){
		$this->db->select("print_layout_id,print_layout_name,print_layout_page")->from("print_layout");
		$query=$this->db->get();
		return $query->result();
	}

		//get_print_layout() select the print layouts based on print_layout_id from the database and returns the result
		function get_print_layout($print_layout_id){
			$this->db->select("print_layout_id,print_layout_name,print_layout_page")->from("print_layout")->where('print_layout_id',$print_layout_id);
			$query=$this->db->get();
			return $query->row();
		}
		

	//get_forms() takes a parameter $form_type, selects the forms with the given form type 
	//from the database and returns the result
	function get_forms($form_type){
		$hospital = $this->session->userdata('hospital');
		$this->db->select("form_id,form_name")->from("form")->where("form_type",$form_type)->where('hospital_id',$hospital['hospital_id']);
		$query=$this->db->get();
		return $query->result();
	}
	//get_form() selects the form from the database with the $form_id passed and returns the result
	function get_form($form_id){
		$this->db->select("form_id,form_name,num_columns,form_type,print_layout_page")->from("form")->
		join('print_layout','form.print_layout_id=print_layout.print_layout_id')->where("form_id",$form_id);
		$query=$this->db->get();
		return $query->row();
	}
	
	//get_form_a6() selects the form from the database with the $form_id passed and returns the result
	function get_form_a6($form_id){
		$this->db->select("form_id,form_name,num_columns,form_type,print_layout_page")->from("form")->
		join('print_layout','form.a6_print_layout_id=print_layout.print_layout_id')->where("form_id",$form_id);
		$query=$this->db->get();
		return $query->row();
	}

	//get_form_fields() selects the form fields from the database and returns the result
	function get_form_fields($form_id){
		$this->db->select("field_name,mandatory,default_value")->from("form_layout")->where("form_id",$form_id)->order_by("id","asc");
		$query=$this->db->get();
		
		$result=$query->result();
		return $result;
	}
	//create_user() function adds the user details and the user access details into the database.
	function create_user(){
		//building the data array with the column names as keys and post variables as values.
		$data=array(
			'username'=>$this->input->post('username'),
			'password'=>md5($this->input->post('password')),
			'staff_id'=>$this->input->post('staff')
		);
		$this->db->trans_start(); //Transaction begins
		$this->db->insert('user',$data); //Insert into 'user' table the $data array
		$user_id=$this->db->insert_id(); //Get the user ID from the inserted record
		$user_function=$this->input->post('user_function'); //Get the user functions selected for the user.
		$user_function_data=array();
		foreach($user_function as $u){ //loop through the selected user functions
			//defining local variables add,edit and view with default values as 0
			$add=0; 
			$edit=0;
			$view=0;
			if($this->input->post($u)){ 
				//loop through each of the user_function selected, this will loop through the add,edit and view checkboxes
				foreach($this->input->post($u) as $access){
					//based on the access, set the variables.
					if($access=="add") $add=1; 
					if($access=="edit") $edit=1;
					if($access=="view") $view=1;
				}
				//build the user_function_data with the access controls
				$user_function_data[]=array(
				'user_id'=>$user_id,
				'function_id'=>$u,
				'add'=>$add,
				'edit'=>$edit,
				'view'=>$view
				);
			}
		}
		//insert all the user functions into the user_function_link table in the database.
		$this->db->insert_batch('user_function_link',$user_function_data);
		
		//Get the department and hospital ID from staff table, based on the selected staff.
		$this->db->select('department_id,hospital_id')->from('staff')->where('staff_id',$this->input->post('staff'));
		$query=$this->db->get();
		$result=$query->row(); //store the result in a result variable
		if($this->input->post('department')){
			$department=0;
		}
		else
		$department=$result->department_id; //store the department into a variable.
		$hospital=$result->hospital_id; //store the hospital into a variable.
		//insert into user_department_link and user_department_link the user ID, department ID and the hospital ID.
		$this->db->insert('user_department_link',array('user_id'=>$user_id,'department_id'=>$department));
		$this->db->insert('user_hospital_link',array('user_id'=>$user_id,'hospital_id'=>$hospital));
		$this->db->trans_complete(); //Transaction Ends
		if($this->db->trans_status()===TRUE) return true; else return false; //if transaction completed successfully return true, else false.
	}
	//staff_list() selects the staff details from the database and returns the result
	function staff_list($hospital_id=0){
		//Hard coded to get the staff details of the blood bank.
		$userdata=$this->session->userdata('hospital');
		if($hospital_id==0) $hospital_id=$userdata['hospital_id'];
		
		$this->db->select("*")->from("staff")
		->join('department','staff.department_id = department.department_id')
		->where("department","Blood Bank")->where("staff.hospital_id",$hospital_id);
		$query=$this->db->get();
		return $query->result();
	}
	//get_hospital() selects the hospitals from the database and returns the result
	function get_hospital(){
		$this->db->select("*")->from("hospital")->order_by('hospital','asc');
		$query=$this->db->get();
		return $query->result();
	}
	//change_password() takes user ID as a parameter and updates the database with the new password.
	function change_password($user_id){
		//select the old password from the database
		$this->db->select('password')->from('user')->where('user_id',$user_id);
		$query=$this->db->get();
		$password=$query->row();
		$form_password=$this->input->post('old_password'); //get the old password from the form
		if($password->password==md5($form_password)){ //match both the old passwords
			$this->db->where('user_id',$user_id); //search for the user in db
			if($this->db->update('user',array('password'=>md5($this->input->post('password'))))){ 
				//if the user table has been updated successfully, return true else false.
				return true;
				}
			else return false;
		}
		else return false; //if the old password entered doesn't match the database password, return false.
	}
	function add_camp(){
		$hospital = $this->session->userdata('hospital');
		$data=array(
			'camp_name'=>$this->input->post('camp'),
			'location'=>$this->input->post('location'),
			'hospital_id'=>$hospital['hospital_id']
			);
		$this->db->trans_start();
			$this->db->insert('blood_donation_camp',$data);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			return false;
		}
		else return true;
	}
	
	function add_hospital(){
		$hospital = $this->session->userdata('hospital');
		$data=array(
			'hospital'=>$this->input->post('hospital'),
			'place'=>$this->input->post('location'),
			'district'=>$this->input->post('district'),
			'state'=>$this->input->post('state')
			);
		$this->db->trans_start();
			$this->db->insert('hospital',$data);
		$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			return false;
		}
		else return true;
	}
	
    function add_data($type=''){
        if($type = 'transaction_type'){
            $data = array(
                'staff_id' => $this->input->post('staff_id'),
                'hr_transaction_type_id' => $this->input->post('hr_transaction_type_id'),
                'hr_transaction_date' => date("Y-m-d",strtotime($this->input->post('hr_transaction_date')))
            );
            $table = 'hr_transaction';
        }
        $this->db->trans_start();
		$this->db->insert($table,$data);
		$this->db->trans_complete();
		if($this->db->trans_status()===FALSE){
			return false;
		}
		else{
		  return true;
		}
    }

    function search_staff(){
        $name = array(
                   'LOWER(first_name)'=>strtolower($this->input->post('query')), 
                   'LOWER(last_name)'=>strtolower($this->input->post('query'))                           
        );
       
        $this->db->select('staff_id, first_name, last_name ,doctor_reg_no')
            ->from('staff')
            ->or_like($name,'both');
        $query=$this->db->get();
		if($query->num_rows()>0){
		    return $query->result_array();
		}
		else
            return false;
    }
		
		function search_doctor(){
        $name = array(
                   'LOWER(first_name)'=>strtolower($this->input->post('query')), 
                   'LOWER(last_name)'=>strtolower($this->input->post('query')),
				   'LOWER(doctor_reg_no)'=>strtolower($this->input->post('query'))
        );
       
        $this->db->select('staff_id, first_name, last_name ,doctor_reg_no')
            ->from('staff')
            ->or_like($name,'both');
        $query=$this->db->get();
		if($query->num_rows()>0){
		    return $query->result_array();
		}
		else
            return false;
    }
	
    function get_defaults() {
        $this->db->select('primary_key, default_value,default_value_text')
        ->from('default_setting');
        $query=$this->db->get();
        $result = $query->result();
        if($query->num_rows()>0){
            return $query->result();
        }
        else
            return false;
    }
	
		function search_hospital(){
        $name = array(
                   'LOWER(hospital)'=>strtolower($this->input->post('query')), 
                   'LOWER(place)'=>strtolower($this->input->post('query')),
				   //'LOWER(hospital_id)'=>strtolower($this->input->post('query'))
        );
       
        $this->db->select('hospital_id, hospital, place ')
            ->from('hospital')
            ->or_like($name,'both');
        $query=$this->db->get();
		if($query->num_rows()>0){
		    return $query->result_array();
		}
		else
            return false;
    }
	
	function get_staff_summary(){
		if($this->input->post('department_id')){
			$this->db->where('staff.department_id',$this->input->post('department_id'));
		}
		if($this->input->post('area_id')){
			$this->db->where('staff.area_id',$this->input->post('area_id'));
		}
		if($this->input->post('unit_id')){
			$this->db->where('staff.unit_id',$this->input->post('unit_id'));
		}
		if($this->input->post('designation')){
			$this->db->where('staff.designation',$this->input->post('designation'));
		}
		if($this->input->post('staff_category')){
			$this->db->where('staff.staff_category_id',$this->input->post('staff_category'));
		}
		if($this->input->post('gender')){
			$this->db->where('staff.gender',$this->input->post('gender'));
		}
		if($this->input->post('mci_flag')){
			$this->db->where('staff.mci_flag',$this->input->post('mci_flag'));
		}
		if($this->input->post('sub_by')){
			$sub_by = $this->input->post('sub_by');
		}
		else $sub_by = 'area_name';
		$this->db->select('count(staff_id) count,staff.department_id, staff.area_id, staff.unit_id,
					department, area_name,unit_name, designation, staff.staff_category_id,staff_category.staff_category')
		->from('staff')
		->join('department','staff.department_id = department.department_id','left')
		->join('area','staff.area_id = area.area_id','left')
		->join('unit','staff.unit_id = unit.unit_id','left')
		->join('staff_category','staff.staff_category_id = staff_category.staff_category_id','left')
		->group_by('staff.department_id,staff.unit_id,staff.area_id,designation,staff.staff_category_id')
		->order_by("$sub_by,designation,staff_category");
		$query = $this->db->get();
		return $query->result();
	}   
	
	function user_hospital_link() {
		$user_id = $this->input->post('user_id');
		$user_hospital = $this->input->post('user_hospital'); 
		
		$user_hospital_data = array();
		foreach($user_hospital as $uh){ 
			$user_hospital_data[] = array(
				'user_id'=>$user_id,
				'hospital_id'=>$uh
			);
		}
		
		$this->db->trans_start();
		$this->db->delete('user_hospital_link',array('user_id' => $user_id));
		$this->db->insert_batch('user_hospital_link',$user_hospital_data);
		$this->db->trans_complete();
		if($this->db->trans_status()===FALSE){
			//if the transaction failed,return false.
			return false;
		}
		else return true;
	}
	
	function get_user_hospitals() {
		if(!!$this->input->post('user_id')){
			$this->db->where('user.user_id',$this->input->post('user_id'));
		}
		$this->db->select("user.user_id, user.username, hospital.hospital_id, hospital.hospital,
					hospital.hospital_short_name")
				 ->from("user")
				 ->join("user_hospital_link","user_hospital_link.user_id = user.user_id")
				 ->join("hospital","hospital.hospital_id = user_hospital_link.hospital_id")
				 ->order_by('hospital','asc');
		$query=$this->db->get();
		return $query->result();
	}

	function get_user($default_rowsperpage=0) {
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
		
		if($this->input->post('phone')){
			$this->db->like('staff.phone',$this->input->post('phone'));
		}
		
		if($this->input->post('staff_user_name')){
			$this->db->like('lower(user.username)',strtolower($this->input->post('staff_user_name')));
		}
		$this->db->select("staff.staff_id,staff.hospital_id, staff.designation, 
		staff.first_name, staff.last_name,
		user.user_id, user.username, staff.phone, user.active")
			->from("user")
			->join("staff", "user.staff_id = staff.staff_id");
		if($default_rowsperpage!=0){
			$this->db->limit($rows_per_page,$start);
		}	
		$query=$this->db->get();
		return $query->result();
	}

	function get_user_count() {
		
		
		if($this->input->post('phone')){
			$this->db->like('staff.phone',$this->input->post('phone'));
		}
		
		if($this->input->post('staff_user_name')){
			$this->db->like('lower(user.username)',strtolower($this->input->post('staff_user_name')));
		}
		$this->db->select("count(*) as count")
			->from("user")
			->join("staff", "user.staff_id = staff.staff_id");
		$query=$this->db->get();
		return $query->result();
	}
	
	
	function get_prescription_frequency(){

		$this->db->select("frequency")
			->from("prescription_frequency");
		$query=$this->db->get();
		return $query->result();
	}

	function get_staff_details($staff_id=false) {
		if($staff_id==false)
			return false;
		$this->db->select("staff.*")
			->from("staff")
			->where('staff_id', $staff_id);
		$query=$this->db->get();
		$result = $query->result();
		return $result[0];
	}

	function search_staff_user($query="", $user_id=""){
		$search = array(
           'LOWER(first_name)'=>strtolower($query), 
           'LOWER(last_name)'=>strtolower($query),
           'LOWER(username)'=>strtolower($query),
           'phone'=>$query,
        );
		$this->db->select("staff.first_name, staff.last_name, staff.phone, user.user_id, user.username, user.active")
			->from("user")
			->join("staff", "user.staff_id = staff.staff_id")
			->or_like($search, 'both');
		$query=$this->db->get();
		return $query->result();
	}

	function update_new_print_layout_name($update_name,$print_layout_id)
	{
		$this->db->trans_start();
        $this->db->where('print_layout_id',$print_layout_id);
        $this->db->update('print_layout', array('print_layout_name'=>$update_name));
        $this->db->trans_complete();
        if($this->db->trans_status()==FALSE)
		{
			return false;
		}
        else
		{
			return true;
		} 
	}

}
?>
