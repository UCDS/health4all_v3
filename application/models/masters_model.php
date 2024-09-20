<?php 
class Masters_model extends CI_Model{
	
	
	function get_data($type,$equipment_type=0,$department=0,$area=0,$unit=0,$status=-1,$hospitals=0,$vendor_id=0){
		$hospital=$this->session->userdata('hospital');
		if($type=="equipment_types"){
			$this->db->select("equipment_type_id,equipment_type")->from("equipment_type");
			$this->db->order_by("equipment_type");
		}
		
		else if($type=="hospital"){
			$this->db->select("hospital_id,hospital")->from("hospital")->order_by('hospital');
		}
		else if($type=="department"){
		 $this->db->where('hospital_id',$hospital['hospital_id']);
		$this->db->select("department_id,hospital_id,department")->from("department")
		 ->order_by('department');
		}		
		else if($type=="area"){
			if($hospitals!=0){
				$hosp_id=array();
				foreach($hospitals as $hospital){
					$hosp_id[]=$hospital->hospital_id;
				}
				$this->db->where_in('hospital_id',$hosp_id);
			}
			$this->db->select("area_id,area_name,area.department_id,hospital_id")->from("area")->join('department','area.department_id=department.department_id','left');
		}
		else if($type=="unit"){
			$this->db->select("unit_id,unit_name,department_id")->from("unit");
		}
		else if($type=="icd_chapters"){
			$this->db->select("chapter_id,chapter_title")->from("icd_chapter")->order_by('chapter_id');
		}
		else if($type=="icd_blocks"){
			$this->db->select("*")->from("icd_block")->order_by('block_title');
		}
		else if($type=="icd_codes"){
			$this->db->select("*")->from("icd_code")->order_by('code_title');
		}
		else if($type=="user"){
			$hospital_id = $this->session->userdata('hospital')['hospital_id'];
			if($hospital_id != '')
					$this->db->where('staff.hospital_id', $hospital_id);
			$this->db->select("hospital.hospital,user.user_id,username,password,user.staff_id,user.active,first_name,last_name,gender, specialisation, email, designation,phone,department")
			->from("user")
			->join('staff','user.staff_id=staff.staff_id')
			->join('hospital','staff.hospital_id=hospital.hospital_id')
			->join('department','staff.department_id=department.department_id');
			if($this->input->post('search'))
			{
				$user = strtolower($this->input->post('user'));
				$this->db->like('LOWER(username)',$user,'after');
			}
			if($this->input->post('select') || $this->input->post('update'))
			{
				if($this->input->post('select')) $user_id = $this->input->post('user_id');
				else if($this->input->post('update')) $user_id = $this->input->post('user');
				$this->db->select('function_id,add,edit,view,remove')->where('user.user_id',$user_id)
				->join('user_function_link','user.user_id=user_function_link.user_id');				
			}
		}
		//added by 204208
		else if($type=="user_count"){		
		
		
		if($this->input->post('username')){
			$this->db->where('user.username',$this->input->post('username'));
		}
		
		if($this->input->post('phone')){
			$this->db->where('staff.phone',$this->input->post('phone'));
		}

		if($this->input->post('email')){
			$this->db->where('staff.email',$this->input->post('email'));
		}
		
		
		if($this->input->post('status')){
		    	if($this->input->post('status')=="1"){
				$this->db->like('user.active',1);
			}
			else{
				$this->db->like('user.active',0);
			}
		}
		
		$this->db->select("count(*) as count", false)
		->from('user')
		->join('staff','user.staff_id=staff.staff_id')
		->join('hospital','staff.hospital_id=hospital.hospital_id')
		->join('department','staff.department_id=department.department_id');
		
	}
	// 204208 end
		else if($type=='staff')
		{
			if($this->input->post('search_staff'))
			{
				if($this->input->post('department_id'))
					$this->db->where('staff.department_id',$this->input->post('department_id'));
				if($this->input->post('area_id'))
					$this->db->where('staff.area_id',$this->input->post('area_id'));
				if($this->input->post('designation'))
					$this->db->like('staff.designation',$this->input->post('designation'),'both');
				if($this->input->post('staff_category')){
					$this->db->where('staff.staff_category_id',$this->input->post('staff_category'));
				}
				if($this->input->post('gender'))
					$this->db->where('staff.gender',$this->input->post('gender'));
				if($this->input->post('mci_flag'))
					$this->db->where('staff.mci_flag',$this->input->post('mci_flag'));
				if($this->input->post('ima_registration_number'))
					$this->db->where('staff.ima_registration_number',$this->input->post('ima_registration_number'));
			}
			if($this->input->post('select'))
			{
				$staff_id = $this->input->post('staff_id');
				$this->db->where('staff.staff_id',$staff_id);
			}
			
			
			$this->db->select("staff.staff_id,first_name,last_name,gender,date_of_birth,staff.department_id,staff.area_id, area_name,department,unit_id,staff_role_id,
staff.ima_registration_number, staff.doctor_flag as doctor_flag,			staff_category.staff_category_id,staff_category.staff_category,designation,email,phone,specialisation,research,research_area, mci_flag, hr_transaction_type.hr_transaction_type, MAX(hr_transaction.hr_transaction_date),
			bank,bank_branch,ifsc_code,account_number,account_name")
			->from("staff")
			->join('department','staff.department_id = department.department_id','left')
			->join('area','staff.area_id = area.area_id','left')
			->join('staff_category','staff.staff_category_id=staff_category.staff_category_id','left')
			->join('hr_transaction','staff.staff_id=hr_transaction.staff_id','left')
			->join('hr_transaction_type','hr_transaction.hr_transaction_type_id=hr_transaction_type.hr_transaction_type_id','left')
			->where('staff.hospital_id',$hospital['hospital_id'])
			->group_by('staff.staff_id');
		}
		else if($type=='view_staff')
		{
			if($this->input->post('search_staff'))
			{
				if($this->input->post('department_id')!="")
					$this->db->where('staff.department_id',$this->input->post('department_id'));
				if($this->input->post('area_id')!="")
					$this->db->where('staff.area_id',$this->input->post('area_id'));
				if($this->input->post('unit_id')!="")
					$this->db->where('staff.unit_id',$this->input->post('unit_id'));
				if($this->input->post('designation')!='0'){
					if(!!$this->input->post('designation')){
					$this->db->like('staff.designation',$this->input->post('designation'),'both');
					}
					else
					$this->db->where('staff.designation',$this->input->post('designation'));
				}
				if($this->input->post('staff_category')!="")
					$this->db->where('staff.staff_category_id',$this->input->post('staff_category'));
				if($this->input->post('gender'))
					$this->db->where('staff.gender',$this->input->post('gender'));
				if($this->input->post('mci_flag'))
					$this->db->where('staff.mci_flag',$this->input->post('mci_flag'));
			}
			if($this->input->post('select'))
			{
				$staff_id = $this->input->post('staff_id');
				$this->db->where('staff.staff_id',$staff_id);
			}
			
			
			$this->db->select("staff.staff_id,first_name,last_name,gender,date_of_birth,staff.department_id,staff.area_id, area_name,department,unit_id,staff_role_id,			staff_category.staff_category_id,staff_category.staff_category,designation,email,phone,specialisation,research,research_area, mci_flag, hr_transaction_type.hr_transaction_type, MAX(hr_transaction.hr_transaction_date),
			bank,bank_branch,ifsc_code,account_number,account_name")
			->from("staff")
			->join('department','staff.department_id = department.department_id','left')
			->join('area','staff.area_id = area.area_id','left')
			->join('staff_category','staff.staff_category_id=staff_category.staff_category_id','left')
			->join('hr_transaction','staff.staff_id=hr_transaction.staff_id','left')
			->join('hr_transaction_type','hr_transaction.hr_transaction_type_id=hr_transaction_type.hr_transaction_type_id','left')
			->where('staff.hospital_id',$hospital['hospital_id'])
			->group_by('staff.staff_id');
			
			
		}
		else if($type=="staff_category")
		{	
			if($this->input->post('search'))
			{
				$staff_category = strtolower($this->input->post('staff_category'));
				$this->db->like('LOWER(staff_category)',$staff_category,'after');
			}
			if($this->input->post('staff_category_id'))
			{
				
				$staff_category_id = $this->input->post('staff_category_id');
				$this->db->where('staff_category_id',$staff_category_id);
			}
			
			$this->db->select("staff_category_id,staff_category")->from("staff_category");
		}
		else if($type=="staff_role")
		{
		if($this->input->post('search'))
			{
				$staff_role = strtolower($this->input->post('staff_role'));
				$this->db->like('LOWER(staff_role)',$staff_role,'after');
			}
			if($this->input->post('staff_role_id'))
			{
				$staff_role_id = $this->input->post('staff_role_id');
				$this->db->where('staff_role_id',$staff_role_id);
			}
			
			$this->db->select("staff_role_id,staff_role")->from("staff_role");
		}
		else if($type=="item_type"){
			$this->db->select("item_type_id,item_type")->from("item_type");
		}
		else if($type=="drug_type"){
			$this->db->select("drug_type_id,drug_type,description")->from("drug_type");
		}
		else if($type=="drugs"){
		//	$this->db->select("item_id,item_name")->from("item")->order_by('item_name');
			$this->db->select("generic_item_id,generic_name, item_form.item_form")
					->from("generic_item")
					->join('item_form', 'item_form.item_form_id = generic_item.form_id', 'left')
					->order_by('generic_name');	
		}
		
		else if($type=="dosage"){

			if($this->input->post('search')){
					
			$dosage_type=strtolower($this->input->post('dosage_name'));
				$this->db->like('LOWER(dosage)',$dosage_type,'after');
				}
			if($this->input->post('select')){
					$dosage_id=$this->input->post('dosage_id');

					$this->db->where('dosage_id',$dosage_id);
			}
			$this->db->select("dosage,dosage_id,dosage_unit")->from("dosage");
						
		}
		else if($type=="generics"){
		
			if($this->input->post('select')){
					$generic_id=$this->input->post('generic_item_id');

					$this->db->where('generic_item_id',$generic_id);
					
			}
			if($this->input->post('search')){
				$generic_type=strtolower($this->input->post('generic_name'));
				$this->db->like('LOWER(generic_name)',$generic_type,'after');
				}
				$this->db->select("generic_item_id,generic_name,drug_type,item_type,drug_type.drug_type_id,item_type.item_type_id")->from("generic_item")
				->join('drug_type','generic_item.drug_type_id=drug_type.drug_type_id','left')
				->join('item_type','generic_item.item_type_id=item_type.item_type_id','left')
				->order_by('generic_name');	

			
		}
		
		if($type=="vendor_types"){
			$this->db->select("vendor_type_id,vendor_type")->from("vendor_type");
			$this->db->order_by("vendor_type");
		}
		
		

	
	     	else if($type=="vendor_type"){
			if($this->input->post('select')){
				$vendor_type_id=$this->input->post('vendor_type_id');
				$this->db->where('vendor_type_id',$vendor_type_id);	
			}
			if($this->input->post('search')){
							
						$vendor_type=strtolower($this->input->post('vendor_type'));
						$this->db->like('LOWER(vendor_type)',$vendor_type,'both');
						
			}
					$this->db->select("vendor_type_id,vendor_type")->from("vendor_type")->order_by("vendor_type");
					
		}
		
		else if($type=="vendor"){
			if($this->input->post('select')){
				$vendor_id=$this->input->post('vendor_id');
				$this->db->where('vendor_id',$vendor_id);	
			}
			if($this->input->post('search')){
							
				$vendor_name=strtolower($this->input->post('vendor_name_search'));
				$this->db->like('LOWER(vendor_name)',$vendor_name,'after');
						
			}
			$this->db->select("*")->from("vendor")->order_by("vendor_id");
					
		}
		else if($type=="vendor-all"){
			
			$this->db->select("*")->from("vendor")->order_by("vendor_id");
					
		}
		
		else if($type=="vendor_type"){
			
			$this->db->select("vendor_type_id,vendor_type")->from("vendor_type")->order_by("vendor_type");

		}	

		
		else if($type=="contact_person"){
			if($this->input->post('select')){
				$contact_person_id=$this->input->post('contact_person_id');
				$this->db->where('contact_person_id',$contact_person_id);	
			}
			if($this->input->post('search')){
							
				$contact_person_name=strtolower($this->input->post('contact_person_name_search'));
				$contact_person_name_splitted = explode ( ' ', $contact_person_name);
				if(!isset($contact_person_name_splitted[1]))
				{
					$contact_person_name_splitted[1] = ' ';
				}
				$this->db->like('LOWER(contact_person_first_name)',$contact_person_name_splitted[0],'both');
				$this->db->or_like('LOWER(contact_person_last_name)',$contact_person_name_splitted[0],'both');
				$this->db->or_like('LOWER(contact_person_first_name)',$contact_person_name_splitted[1],'both');
				$this->db->or_like('LOWER(contact_person_last_name)',$contact_person_name_splitted[1],'both');
				
						
			}
			$this->db->select("*")->from("contact_person")->order_by("contact_person_first_name, contact_person_last_name");
					
		}
		
		else if($type=="vendor_specific_contact_person")
		{
			$this->db->where('vendor_id',$vendor_id);	
			$this->db->select("*")->from("contact_person")->order_by("contact_person_first_name, contact_person_last_name");
		}
		else if($type=="unassigned_contact_person")
		{
			$this->db->where('vendor_id','0');	
			$this->db->select("*")->from("contact_person")->order_by("contact_person_first_name, contact_person_last_name");
		}
		else if($type=="drug_type"){
			if($this->input->post('search')){
				$drug_type=strtolower($this->input->post('drug_type'));
				$this->db->like('LOWER(drug_type)',$drug_type,'after');
	
				}
			if($this->input->post('select')){
					
					$drug_id=$this->input->post('drug_type_id');
					$this->db->where('drug_type_id',$drug_id);
			}
			
			$this->db->select("drug_type_id,drug_type,description")->from("drug_type");	

		}	
		else if($type=="test_method")

			{

				if($this->input->post('select'))  //query to retrieve row from table when a result is selected from search results

				{

						$test_id=$this->input->post('test_method_id');

						$this->db->where('test_method_id',$test_id);

				}

		    	if($this->input->post('search') && $this->input->post('test_method')!="")  //query to retrieve matches for the text entered in the field from table test_type

		    	{

		 		 		$search_method=strtolower($this->input->post('test_method'));

			  	    	$this->db->like('LOWER(test_method)',$search_method,'after');

		    	}

				$this->db->select("test_method_id,test_method")->from("test_method")->where('hospital_id',$hospital['hospital_id'])->order_by('test_method');

			}
			elseif ($type=="test_group") 
			{
				if($this->input->post('select'))  //query to retrieve row from table when a result is selected from search results
				{
						$test_id=$this->input->post('test_group_id');
						$this->db->where('group_id',$test_id);
				}
				if($this->input->post('search') && $this->input->post('group_name')!="")  //query to retrieve matches for the text entered in the field from table test_type
				{
						$search_method=strtolower($this->input->post('group_name'));
						$this->db->like('LOWER(group_name)',$search_method,'after');
				}
				if($department!=0 && count($department)>0){
					$deps = array();
					foreach($department as $d){
						$deps[]=$d->department_id;
					}
					$this->db->where_in('department_id',$deps);
				}
				$this->db->select("test_group.group_id,group_name,test_name,test_method,test_master.test_area_id")->from("test_group")
				->join('test_group_link','test_group.group_id = test_group_link.group_id')
				->join('test_master','test_group_link.test_master_id = test_master.test_master_id')
				->join('test_method','test_master.test_method_id=test_method.test_method_id')
				->join('test_area','test_master.test_area_id=test_area.test_area_id')
				->where('test_master.hospital_id',$hospital['hospital_id'])
				->order_by('group_name');
			}
		elseif ($type=="test_status_type") {
			if($this->input->post('select'))  //query to retrieve row from table when a result is selected from search results
			{
					$test_id=$this->input->post('test_status_type_id');
					$this->db->where('test_status_type_id',$test_id);
			}
	    	if($this->input->post('search') && $this->input->post('test_status_type')!="")  //query to retrieve matches for the text entered in the field from table test_type
	    	{
	 		 		$search_method=strtolower($this->input->post('test_status_type'));
		  	    	$this->db->like('LOWER(test_status_type)',$search_method,'after');
	    	}
			$this->db->select("test_status_type_id,test_status_type")->from("test_status_type")->order_by('test_status_type');


		}
		
		elseif ($type=="test_name") {
			if($this->input->post('select'))  //query to retrieve row from table when a result is selected from search results
			{
					$test_id=$this->input->post('test_master_id');
					$this->db->where('test_master_id',$test_id);
			}
	    	if($this->input->post('search') && $this->input->post('test_name')!="")  //query to retrieve matches for the text entered in the field from table test_type
	    	{
	 		 		$search_method=strtolower($this->input->post('test_name'));
		  	    	$this->db->like('LOWER(test_name)',$search_method,'after');
	    	}
			if($department!=0 && count($department)>0){
				$deps = array();
				foreach($department as $d){
					$deps[]=$d->department_id;
				}
				$this->db->where_in('department_id',$deps);
			}
			$this->db->select("test_master_id,test_name,test_master.test_method_id,test_master.test_area_id,test_method")
			->from("test_master")
			->join('test_method','test_master.test_method_id=test_method.test_method_id')
			->join('test_area','test_master.test_area_id=test_area.test_area_id')
			->where('test_master.hospital_id',$hospital['hospital_id'])
			->order_by('test_name');


		}
		elseif ($type=="test_area") {
			if($this->input->post('select'))  //query to retrieve row from table when a result is selected from search results
			{
					$test_id=$this->input->post('test_area_id');
					$this->db->where('test_area_id',$test_id);
			}
	    	if($this->input->post('search') && $this->input->post('test_area')!="")  //query to retrieve matches for the text entered in the field from table test_type
	    	{
	 		 		$search_method=strtolower($this->input->post('test_area'));
		  	    	$this->db->like('LOWER(test_area)',$search_method,'after');
	    	}
			if($department!=0 && count($department)>0){
				$deps = array();
				foreach($department as $d){
					$deps[]=$d->department_id;
				}
				$this->db->where_in('department_id',$deps);
			}
			$this->db->select("test_area_id,test_area")->from("test_area")
			->where('test_area.hospital_id',$hospital['hospital_id'])->order_by('test_area');


		}
		
		elseif ($type=="antibiotic") {
			if($this->input->post('select'))  //query to retrieve row from table when a result is selected from search results
			{
					$test_id=$this->input->post('antibiotic_id');
					$this->db->where('antibiotic_id',$test_id);
			}
	    	if($this->input->post('search') && $this->input->post('antibiotic')!="")  //query to retrieve matches for the text entered in the field from table test_type
	    	{
	 		 		$search_method=strtolower($this->input->post('antibiotic'));
		  	    	$this->db->like('LOWER(antibiotic)',$search_method,'after');
	    	}
			$this->db->select("antibiotic_id,antibiotic")->from("antibiotic")->where('hospital_id',$hospital['hospital_id'])->order_by('antibiotic');
			
			}
			
		elseif ($type=="micro_organism") {
			if($this->input->post('select'))  //query to retrieve row from table when a result is selected from search results
			{
					$test_id=$this->input->post('micro_organism_id');
					$this->db->where('micro_organism_id',$test_id);
			}
	    	if($this->input->post('search') && $this->input->post('micro_organism')!="")  //query to retrieve matches for the text entered in the field from table test_type
	    	{
	 		 		$search_method=strtolower($this->input->post('micro_organism'));
		  	    	$this->db->like('LOWER(micro_organism)',$search_method,'after');
	    	}
			$this->db->select("micro_organism_id,micro_organism")->from("micro_organism")->where('hospital_id',$hospital['hospital_id'])->order_by('micro_organism');
			
			}
		elseif ($type=="specimen_type") {
			if($this->input->post('select'))  //query to retrieve row from table when a result is selected from search results
			{
					$test_id=$this->input->post('specimen_type_id');
					$this->db->where('specimen_type_id',$test_id);
			}
	    	if($this->input->post('search') && $this->input->post('specimen_type')!="")  //query to retrieve matches for the text entered in the field from table test_type
	    	{
	 		 		$search_method=strtolower($this->input->post('specimen_type'));
		  	    	$this->db->like('LOWER(specimen_type)',$search_method,'after');
	    	}
			$this->db->select("specimen_type_id,specimen_type")->from("specimen_type")->where('hospital_id',$hospital['hospital_id'])->order_by('specimen_type');

		}
		elseif ($type=="sample_status") {
			if($this->input->post('select'))  //query to retrieve row from table when a result is selected from search results
			{
					$test_id=$this->input->post('sample_status_id');
					$this->db->where('sample_status_id',$test_id);
			}
	    	if($this->input->post('search') && $this->input->post('sample_status')!="")  //query to retrieve matches for the text entered in the field from table test_type
	    	{
	 		 		$search_method=strtolower($this->input->post('sample_status'));
		  	    	$this->db->like('LOWER(sample_status)',$search_method,'after');
	    	}
			$this->db->select("sample_status_id,sample_status")->from("sample_status")->order_by('sample_status');
		}
		elseif ($type=="lab_unit") {
			if($this->input->post('select'))  //query to retrieve row from table when a result is selected from search results
			{
					$lab_unit_id=$this->input->post('lab_unit_it');
					$this->db->where('lab_unit_id',$lab_unit_id);
			}
	    	if($this->input->post('search') && $this->input->post('lab_unit')!="")  //query to retrieve matches for the text entered in the field from table test_type
	    	{
	 		 		$search_method=strtolower($this->input->post('lab_unit'));
		  	    	$this->db->like('LOWER(lab_unit)',$search_method,'after');
	    	}
			$this->db->select("lab_unit_id,lab_unit")->from("lab_unit")->where('hospital_id',$hospital['hospital_id'])->order_by('lab_unit');

		}
		else if($type=="districts"){
			
			$this->db->select("district_id,district")->from("district");
		}
		else if($type=="states"){
			$this->db->select("state_id,state")->from("state")->order_by('state');
		}
		else if($type=="state_codes"){
			if( $this->input->post('country') != null && strlen($this->input->post('country')) > 0)
				$this->db->where('country_code',$this->input->post('country'));
			else	
				$this->db->where('country_code','IN');
			$this->db->select("state_code,state_name")->from("state_codes");
		}
		else if($type=="countries"){
			$this->db->select("*")->from("country")->from('country_name');
			$this->db-order_by("country_name");
		}

		else if($type=="country_codes"){
			$this->db->select("country,name")->from("country_codes")->order_by('name');;
			//$this->db-order_by("country_name");
		}
		else if($type=="area_types"){
			$this->db->select("area_type_id,area_type")->from("area_types");
		}
		else if($type=="area_activity"){
			$this->db->select("area_activity_id,activity_name")->from("area_activity");
		}
		else if($type=="vendor"){
			$this->db->select("vendor_id,vendor_name")->from("vendor");
		}
		else if($type=="vendors"){
			$this->db->select("vendor_id,vendor_name")->from("vendor");
		}
		else if($type=="contact_persons"){
			$this->db->select("contact_person_id,contact_person_first_name,contact_person_last_name")->from("contact_person");
		}
		else if($type=="vend"){
			$this->db->select("vendor_id,vendor_name")->from("vendor");
		}
		else if($type=="contact"){
			$this->db->select("contact_person_id,contact_person_first_name,contact_person_last_name")->from("contact_person");
		}
		else if($type=="facility_activity"){
			$this->db->select("activity_id")->from("facility_activity");
		}
		else if($type=="activity_done"){
			$this->db->select("*")->from("activity_done");
		}	
		else if($type=="facility_type"){
			$this->db->select("facility_type_id,facility_type")->from("facility_type");
		}
			else if($type=="vendor"){
			$this->db->select("vendor_id,vendor_name")->from("vendor");
		}
		else if($type=="vendor_contracts"){
			
			$this->db->select("contract_id,status")->from("vendor_contracts");

		}
		else if($type=="village_town"){
			$this->db->select("village_town_id,village_town")->from("village_town");
		}
		else if($type=="procedure"){
			$this->db->select("procedure_id,procedure_name")->from("procedure");
		}
		else if($type=="sanitation_activity"){
			$date=date("Y-m-d",strtotime($this->input->post('date')));
			$day = date('w',strtotime($this->input->post('date')));
			if(date("d",strtotime($date))>'28'){
				$week_start = date('Y-m-29', strtotime($date));
			}
			else{
				$week_start = date('Y-m-d', strtotime("$date - 6 days"));
			}
			$week_end = date('Y-m-d', strtotime($date.' +  days'));
			$fortnight_start_date=date("Y-m-1",strtotime($date));
			if($date-$fortnight_start_date>15)
			$fortnight_end_date=date("Y-m-15",strtotime($date));
			else { 
				$fortnight_start_date=date("Y-m-15",strtotime($date));
				$fortnight_end_date=date("Y-m-t",strtotime($date));
			}
			$this->db->select('activity_name,frequency,weightage,frequency_type,activity_id,day_done.*,week_done.*,fortnight_done.*,month_done.*')
			->from('facility_activity')
			->join('area_activity','facility_activity.area_activity_id=area_activity.area_activity_id')
			->join('area','facility_activity.facility_area_id=area.area_id')
			->join("(SELECT activity_id day_activity_done,date day_activity_date,time day_activity_time,score daily_score FROM activity_done JOIN facility_activity USING(activity_id) JOIN area_activity USING(area_activity_id) WHERE frequency_type='Daily' AND date='$date') day_done",'facility_activity.activity_id=day_done.day_activity_done','left')
			->join("(SELECT activity_id week_activity_done,date week_activity_date,time week_activity_time,score weekly_score,comments FROM activity_done JOIN facility_activity USING(activity_id) JOIN area_activity USING(area_activity_id) WHERE frequency_type='Weekly' AND date='$week_start' ) week_done",'facility_activity.activity_id=week_done.week_activity_done','left')
			->join("(SELECT activity_id fortnight_activity_done,date fortnight_activity_date,time fortnight_activity_time,score fortnightly_score FROM activity_done JOIN facility_activity USING(activity_id) JOIN area_activity USING(area_activity_id) WHERE frequency_type='Fortnightly' AND (date BETWEEN '$fortnight_start_date' AND '$fortnight_end_date')) fortnight_done",'facility_activity.activity_id=fortnight_done.fortnight_activity_done','left')
			->join("(SELECT activity_id month_activity_done,date month_activity_date,time month_activity_time,score monthly_score,comments FROM activity_done JOIN facility_activity USING(activity_id) JOIN area_activity USING(area_activity_id) WHERE frequency_type='Monthly' AND MONTH(date)=MONTH('$week_start') AND YEAR(date)=YEAR('$week_start')) month_done",'facility_activity.activity_id=month_done.month_activity_done','left')
			->where('area.area_id',$this->input->post('area'));
		}
		else if($type=="defaults"){
			$this->db->select("*")->from("defaults");
		}
		
		$query=$this->db->get();
		return $query->result();
	
}

function get_transactions(){
    $this->db->select('hr_transaction.hr_transaction_date, hr_transaction_type.hr_transaction_type')
    ->from('hr_transaction')
    ->join('hr_transaction_type', 'hr_transaction.hr_transaction_type_id=hr_transaction_type.hr_transaction_type_id', 'left')
    ->where('hr_transaction.staff_id', $this->input->post('staff_id'));
    $query=$this->db->get();
   
    return $query->result();
}

function get_designation(){
	$this->db->select('DISTINCT(designation)')
	->from('staff');
	$query=$this->db->get();
	
	return $query->result();

}


function update_data($type){
	if($type=="drugs"){
			$data = array(
					  'drug_type'=>$this->input->post('drug_type'),
					  'description'=>$this->input->post('description'),
					  	
				
				);
			$this->db->where('drug_type_id',$this->input->post('drug_type_id'));
			$table="drug_type";
		
		
	}
	else if($type=="user"){
		
		if(trim($this->input->post('password'))!=""){
			$password=$this->input->post('password');
		}
		if(isset($password))
			$data=array(
			'username'=>$this->input->post('username'),
			'password'=>md5($password),
			'staff_id'=>$this->input->post('staff')
			);
		else
			$data=array(
			'username'=>$this->input->post('username'),
			'active' =>$this->input->post('active'),
			'staff_id'=>$this->input->post('staff')
			);
		$this->db->trans_start();
		$this->db->where('user_id',$this->input->post('user'));
		$this->db->update('user',$data);
		$user_functions=$this->input->post('user_function');
		$this->db->select('link_id,user_function.user_function_id')->from('user_function')
		->join('user_function_link','user_function.user_function_id=user_function_link.function_id')
		->where('user_id',$this->input->post('user'));
		$query=$this->db->get();
		$result=$query->result();
		$existing_functions=array();
		$user_functions_data=array();
		$update_functions_data=array();
		foreach($result as $row){                   //Update existing functions
			$add=0;$edit=0;$view=0;$active = 0;$remove=0;
			if($this->input->post($row->user_function_id))
				foreach($this->input->post($row->user_function_id) as $access){
					if($access=="add") $add=1;
					if($access=="edit") $edit=1;
					if($access=="view") $view=1;
					if($access=="remove") $remove=1;
                                        if($access=="add" || $access=="edit" || $access=="view" || $access=="remove") $active = 1;
				}
				$update_functions_data[]=array(
					'link_id'=>$row->link_id,
					'add'=>$add,
					'edit'=>$edit,
					'view'=>$view,
					'remove'=>$remove,
                                        'active'=>$active
				);
			$existing_functions[]=$row->user_function_id;
		}
		foreach($user_functions as $u){             //Add new functions
			if(!in_array($u,$existing_functions)){
				$add=0;
				$edit=0;
				$view=0;
				$remove=0;
				if($this->input->post($u)){
					foreach($this->input->post($u) as $access){
						if($access=="add") $add=1;
						if($access=="edit") $edit=1;
						if($access=="view") $view=1;
						if($access=="remove") $remove=1;
                                                if($access=="add" || $access=="edit" || $access=="view" || $access=="remove") $active = 1;
					}
					$user_functions_data[]=array(
						'user_id'=>$this->input->post('user'),
						'function_id'=>$u,
						'add'=>$add,
						'edit'=>$edit,
						'view'=>$view,
						'remove'=>$remove,
                                                'active'=>$active
					);
				}
			}
		}
                
               
		if(count($update_functions_data)>0) $this->db->update_batch('user_function_link',$update_functions_data,'link_id');
		if(count($user_functions_data)>0) $this->db->insert_batch('user_function_link',$user_functions_data);

		$this->db->trans_complete();
		if($this->db->trans_status()===TRUE) return true; else { $this->db->trans_rollback(); return false; }		
		}
	
	else if($type=="vendor_type"){
			$data = array(
					  'vendor_type'=>$this->input->post('vendor_type')
				);
			$this->db->where('vendor_type_id',$this->input->post('vendor_type_id'));
			$table="vendor_type";
		
		
	}
	
		


else if($type=="generics"){
			$data = array(
					  'generic_name'=>$this->input->post('generic_name'),
					  'item_type_id'=>$this->input->post('item_type'),
					   'drug_type_id'=>$this->input->post('drug_type')
					  );
			$this->db->where('generic_item_id',$this->input->post('generic_item_id'));
			$table="generic_item";
		
		
	}
else if($type=="dosage"){
			$data = array(
					  'dosage'=>$this->input->post('dosage'),
					  'dosage_unit'=>$this->input->post('dosage_unit')
					  );
			$this->db->where('dosage_id',$this->input->post('dosage_id'));
			$table="dosage";
		
		
	}
 

 elseif ($type=="test_method") {      //updating when update button is clicked
	$data=array('test_method'=>$this->input->post('test_method'));

	$this->db->where('test_method_id',$this->input->post('test_method_id'));

   $table="test_method";

 }

 elseif ($type=="test_group") {
 		
    $data=array('group_name'=>$this->input->post('group_name'));
 	$r=$this->input->post('test_group_id');
 	$this->db->where('group_id',$this->input->post('test_group_id'));
   $table="test_group";	
 }
 
 elseif ($type=="test_status_type") {
 		
    $data=array('test_status_type'=>$this->input->post('test_status_type'));
 	$r=$this->input->post('test_status_type_id');
 	$this->db->where('test_status_type_id',$this->input->post('test_status_type_id'));
   $table="test_status_type";	
 }
 elseif ($type=="test_name") {
				
    $data=array(
		'test_name'=>$this->input->post('test_name'),
		'test_method_id'=>$this->input->post('test_method'),
	);
 	
 	$this->db->where('test_master_id',$this->input->post('test_master_id'));
   $table="test_master";
   $this->db->trans_start();
   $this->db->update($table,$data);

   foreach($this->input->post("deactivate") as $deactivate){
       if($deactivate != "active"){
           $flags = array(
                'test_range_id' => $deactivate,
                'range_active' => 0
           );
       }
   }
   $this->db->update_batch('test_range',$flags,'test_range_id');
   $range_data = array();
   
   if($this->input->post("range_items_count")>0){
   for($count =0; $count < $this->input->post("range_items_count");$count++){
                                if($this->input->post("range")[$count]=='3'){
                                    $min = $this->input->post("range_low")[$count];
                                    $max = $this->input->post("range_high")[$count];
                                }
                                elseif($this->input->post("range")[$count]=='1'){
                                    $max = $this->input->post("value_less_than")[$count];
                                    $min = NULL;
                                }elseif($this->input->post("range")[$count]=='2'){
                                    $min = $this->input->post("value_greater_than")[$count];
                                    $max=NULL;
                                }else{
                                    $min = NULL;
                                    $max = NULL;
                                }
                                if($this->input->post("age")[$count]=='3'){
                                    $from_year = $this->input->post("year_low")[$count];
                                    $from_month = $this->input->post("month_low")[$count];
                                    $from_day = $this->input->post("day_low")[$count];
                                    $to_year = $this->input->post("year_high")[$count];
                                    $to_month = $this->input->post("month_high")[$count];
                                    $to_day = $this->input->post("day_high")[$count];
                                   
                                }elseif($this->input->post("age")[$count]=='1'){
                                    $to_year = $this->input->post("upper_age_limit_years")[$count];
                                    $to_month = $this->input->post("upper_age_limit_months")[$count];
                                    $to_day = $this->input->post("upper_age_limit_days")[$count];
                                    $from_year = NULL;
                                    $from_month = NULL;
                                    $from_day = NULL;
                                }elseif($this->input->post("age")[$count]=='2'){
                                    $from_year = $this->input->post("lower_age_limit_years")[$count];
                                    $from_month = $this->input->post("lower_age_limit_months")[$count];
                                    $from_day = $this->input->post("lower_age_limit_days")[$count];
                                    $to_year = NULL;
                                    $to_month = NULL;
                                    $to_day = NULL;                                  
                                }else{
                                    $from_year = NULL;
                                    $from_month = NULL;
                                    $from_day = NULL;
                                    $to_year = NULL;
                                    $to_month = NULL;
                                    $to_day = NULL;
                                }
                                $range_data[]=array(
                                    'test_master_id' => $this->input->post('test_master_id'),
                                    'range_type'=> $this->input->post("range")[$count],
                                    'gender' => $this->input->post("gender")[$count],
                                    'age_type' => $this->input->post("age")[$count], 
                                    'min' => $min,
                                    'max' => $max,
                                    'from_year' => $from_year,
                                    'from_month' => $from_month,
                                    'from_day' => $from_day,
                                    'to_year' => $to_year,
                                    'to_month' => $to_month,
                                    'to_day' => $to_day
                                 );
                         
                            }
                           
                           $this->db->insert_batch('test_range', $range_data);
                       
                        }
                        $this->db->trans_complete();
                       if($this->db->trans_status()===FALSE){
                           
                           $this->db->trans_rollback();
                           return false;
                      }
                       else
                           return true;	
 }
 elseif ($type=="test_area") {
 		
    $data=array('test_area'=>$this->input->post('test_area'));
 	$r=$this->input->post('test_area_id');
 	$this->db->where('test_area_id',$this->input->post('test_area_id'));
   $table="test_area";	
 }
 elseif ($type=="antibiotic") {
 		
    $data=array('antibiotic'=>$this->input->post('antibiotic'));
 	$r=$this->input->post('antibiotic_id');
 	$this->db->where('antibiotic_id',$this->input->post('antibiotic_id'));
   $table="antibiotic";	
 }
 elseif ($type=="micro_organism") {
 		
    $data=array('micro_organism'=>$this->input->post('micro_organism'));
 	$r=$this->input->post('micro_organism_id');
 	$this->db->where('micro_organism_id',$this->input->post('micro_organism_id'));
   $table="micro_organism";	
 }
	elseif ($type=="specimen_type") {
    $data=array('specimen_type'=>$this->input->post('specimen_type'));
 	$r=$this->input->post('specimen_type_id');
 	 $this->db->where('specimen_type_id',$this->input->post('specimen_type_id'));
   $table="specimen_type";	
 }	
 elseif ($type=="sample_status") {
    $data=array('sample_status'=>$this->input->post('sample_status'));
 	 $this->db->where('sample_status_id',$this->input->post('sample_status_id'));
   $table="sample_status";	
 }
 elseif ($type=="lab_unit") {
    $data=array('lab_unit'=>$this->input->post('lab_unit'));
 	 $this->db->where('lab_unit_id',$this->input->post('lab_unit_id'));
   $table="lab_unit";	
 }
		else if($type == 'staff')
		{
			$date = $this->input->post('date_of_birth');
			$date = date("Y-m-d",strtotime($date));
			$data = array(
					  'first_name'=>$this->input->post('first_name'),
					  'last_name'=>$this->input->post('last_name'),
					  'gender'=>$this->input->post('gender'),
					  'date_of_birth'=>$date,
					  'department_id'=>$this->input->post('department'),
					  'unit_id'=>$this->input->post('unit'),
					  'area_id'=>$this->input->post('area'),
					  'staff_role_id'=>$this->input->post('staff_role'),
					  'staff_category_id'=>$this->input->post('staff_category'),
					  'designation'=>$this->input->post('designation'),
					  'mci_flag'=>$this->input->post('mci_flag'),
					  'ima_registration_number'=>$this->input->post('ima_registration_number'),
					  'doctor_flag'=>$this->input->post('doctor_flag'),
					  'staff_type'=>$this->input->post('staff_type'),
					  'email'=>$this->input->post('email'),
					  'phone'=>$this->input->post('phone'),
					  'specialisation'=>$this->input->post('specialisation'),
					  'research_area'=>$this->input->post('research_area'),
					  'research'=>$this->input->post('research'),
					  'bank'=>$this->input->post('bank'),
					  'bank_branch'=>$this->input->post('bank_branch'),
					  'account_name'=>$this->input->post('account_name'),
					  'account_number'=>$this->input->post('account_number'),
					  'ifsc_code'=>$this->input->post('ifsc_code')
					);
					
			//get the patient id from the inserted row.
			$staff_id=$this->input->post('staff_id');
	    	if($this->input->post('staff_picture')){
			$encoded_data = $this->input->post('staff_picture');
			$binary_data = base64_decode( $encoded_data );
            
			 
			// save to server (beware of permissions)
			$result = file_put_contents("assets/images/staff/$staff_id.jpg", $binary_data );
			if (!$result) die("Could not save image!  Check file permissions.");
		}
			$this->db->where('staff_id',$this->input->post('staff_id'));
			$table = 'staff';
		}
		
 		else if($type=='staff_role')
		{
			//cunstructing array for attributes to be updated.
			$data = array(
						'staff_role' => $this->input->post('staff_role'),
						'staff_role_id' => $this->input->post('staff_role_id')
					);
			//setting where condition		
			$this->db->where('staff_role_id',$data['staff_role_id']);
			$table = 'staff_role';
		}
 		
		else if($type=='staff_category')
		{
			//cunstructing array for attributes to be updated.
			$data = array(
						'staff_category_id' => $this->input->post('staff_category_id'),
						'staff_category' => $this->input->post('staff_category')
					);
			//setting where condition		
			$this->db->where('staff_category_id',$data['staff_category_id']);
			$table = 'staff_category';
		}
		else if($type=="vendor"){
			$data = array(
				  //'vendor_id'=>$this->input->post('vendor_id'),
				  'vendor_name'=>$this->input->post('vendor_name'),
				  'vendor_type_id'=>$this->input->post('vendor_type_id'),
				   'vendor_address'=>$this->input->post('vendor_address'),
				   //'village_town_id'=>$this->input->post('village_town_id'),
				   //'vendor_state_id'=>$this->input->post('vendor_state_id'),
				   //'district_id'=>$this->input->post('vendor_state_id'),
				   //'vendor_country_id'=>$this->input->post('vendor_country_id'),
				   'account_no'=>$this->input->post('account_no'),
				   'bank_name'=>$this->input->post('bank_name'),
				   'branch'=>$this->input->post('branch'),
				   'vendor_email'=>$this->input->post('vendor_email'),
				   'vendor_phone'=>$this->input->post('vendor_phone'),
				   'vendor_pan'=>$this->input->post('vendor_pan'),
				   'contact_person_id'=>$this->input->post('contact_person_id')
				  
			);
			$this->db->where('vendor_type_id',$this->input->post('vendor_type_id'));
			$table="vendor";
		}			

			else if($type=="contact_person"){
				$data = array(
					'contact_person_id'=>$this->input->post('contact_person_id'),
					'contact_person_first_name'=>$this->input->post('contact_person_first_name'),
					  'contact_person_last_name'=>$this->input->post('contact_person_last_name'),
					  'contact_person_email'=>$this->input->post('contact_person_email'),
					  'contact_person_contact'=>$this->input->post('contact_person_contact'),
					  'vendor_id'=>$this->input->post('vendor_id'),
					  'gender'=>$this->input->post('gender'),
					  'designation'=>$this->input->post('designation'),
					  
				);
				$this->db->where('contact_person_id',$data['contact_person_id']);
				$table="contact_person";
				
		}
		
		
			$this->db->trans_start();
			$this->db->update($table,$data);

		$this->db->trans_complete();
		if($this->db->trans_status()===FALSE){
			return false;
		}
		else{
		  return true;
		}
	}
	
	function insert_data($type){

		$hospital=$this->session->userdata('hospital');
		$hospital_id=$hospital['hospital_id'];
		if($type=="drug_type"){
		$data = array(	
					  'drug_type'=>$this->input->post('drug_type'),
					 'description'=>$this->input->post('description')
		);

		$table="drug_type";
		}
		elseif($type=="equipment_type")
		{
			
			$data = array('equipment_type'=>$this->input->post('equipment_type'));
			$table="equipment_type";
		}
		
		elseif($type=="dosage"){
		$data = array(
					  'dosage_unit'=>$this->input->post('dosage_unit'),
					 'dosage'=>$this->input->post('dosage')
		);

		$table="dosage";
		}
		elseif($type=="item_type"){
			// Getting item_type value from form and setting it to 'item_type' column and assigning to variable $data  
			$data = array('item_type'=>$this->input->post('item_type'));

			// Setting table name
			$table = "item_type";
		}

		elseif($type=="generic"){
		$data = array(
					  'generic_name'=>$this->input->post('generic_name'),
					 'item_type_id'=>$this->input->post('item_type'),
					 'drug_type_id'=>$this->input->post('drug_type')
		);

		$table="generic_item";
		}
		
	
	
		
		
		elseif($type=="vendor_type")
		{
			$data = array('vendor_type'=>$this->input->post('vendor_type'));
			$table="vendor_type";
		}
		elseif($type=="staff"){			
		$data = array(
		
					  'first_name'=>$this->input->post('first_name'),
					  'last_name'=>$this->input->post('last_name'),
					  'gender'=>$this->input->post('gender'),
					  'date_of_birth'=>date("Y-m-d",strtotime($this->input->post('date_of_birth'))),
					  'hospital_id'=>$this->input->post('hospital'),
					  'department_id'=>$this->input->post('department'),
					  'unit_id'=>$this->input->post('unit'),
					  'area_id'=>$this->input->post('area'),
					  'staff_role_id'=>$this->input->post('staff_role'),
					  'staff_category_id'=>$this->input->post('staff_category'),
					  'designation'=>$this->input->post('designation'),
					  'staff_type'=>$this->input->post('staff_type'),
					  'mci_flag'=>$this->input->post('mci_flag'),
					  'email'=>$this->input->post('email'),
					  'phone'=>$this->input->post('phone'),
					  'specialisation'=>$this->input->post('specialisation'),
					  'research_area'=>$this->input->post('research_area'),
					  'research'=>$this->input->post('research'),
					  'ima_registration_number'=>$this->input->post('ima_registration_number'),
					  'doctor_flag'=>$this->input->post('doctor_flag'),
					  'bank'=>$this->input->post('bank'),
					  'bank_branch'=>$this->input->post('bank_branch'),
					  'account_name'=>$this->input->post('account_name'),
					  'account_number'=>$this->input->post('account_number'),
					  'ifsc_code'=>$this->input->post('ifsc_code')
		);
		    $staff_id = 0 ;
         	
			// else if it's a new patient, insert into the patient table using the data array.
			
			$this->db->insert('staff',$data); 
			//get the patient id from the inserted row.
			$staff_id=$this->db->insert_id();
	    	if($this->input->post('staff_picture')){
			$encoded_data = $this->input->post('staff_picture');
			$binary_data = base64_decode( $encoded_data );
            
			 
			// save to server (beware of permissions)
			// $result = file_put_contents("/assets/images/staff/$staff_id.jpg", $binary_data );
			// if (!$result) die("Could not save image!  Check file permissions.");
		}
	
		
		
		}
		elseif($type=="staff_role"){
		$data = array(
					  'staff_role'=>$this->input->post('staff_role')
		);

		$table="staff_role";
		}
		elseif($type=="staff_category"){
		$data = array(
					  'staff_category'=>$this->input->post('staff_category')
		);

		$table="staff_category";
		}
				

		elseif ($type=="test_method") {

			$data=array(
				'test_method'=>$this->input->post('test_method'),
				'hospital_id'=>$hospital['hospital_id']
			);

		$table="test_method";			

		}
		elseif ($type=="test_group") {
			 $binary=0;
			 $numeric=0;
			 $text=0;
				foreach($this->input->post('output_format') as $output_format){
					if($output_format==1){
						$binary=1;
					}
					if($output_format==2){
						$numeric=1;
					}
					if($output_format==3){
						$text=1;
					}
				}
						
			$data=array(
				'group_name'=>$this->input->post('group_name'),
				'test_method_id'=>$this->input->post('test_method'),
				'binary_result'=>$binary,
				'numeric_result'=>$numeric,
				'text_result'=>$text,
				'binary_positive'=>$this->input->post('binary_pos'),
				'binary_negative'=>$this->input->post('binary_neg'),
				'numeric_result_unit'=>$this->input->post('numeric_result_unit')
			);
			$this->db->trans_start();
			$this->db->insert('test_group',$data);
			$group_id = $this->db->insert_id();
			$data=array();
			foreach($this->input->post('test_name') as $test_name){
				$data[]=array(
					'test_master_id'=>$test_name,
					'group_id'=>$group_id
				);
			}
			$this->db->insert_batch('test_group_link',$data);
			$this->db->trans_complete();
			
			if($this->db->trans_status()===FALSE){
				$this->db->trans_rollback();
				return false;
			}	
			else return true;
		}
		elseif ($type=="test_area") {
			$data=array(
				'test_area'=>$this->input->post('test_area'),
				'department_id'=>$this->input->post('department'),
				'hospital_id' => $hospital['hospital_id']
			);
		$table="test_area";
		}
		elseif ($type=="test_status_type") {
			$data=array('test_status_type'=>$this->input->post('test_status_type'));
		$table="test_status_type";
		}
		elseif ($type=="test_name") {
			 $binary=0;
			 $numeric=0;
			 $text=0;
				foreach($this->input->post('output_format') as $output_format){
					if($output_format==1){
						$binary=1;
					}
					if($output_format==2){
						$numeric=1;
					}
					if($output_format==3){
						$text=1;
					}
				}
						
			$data=array(
				'test_name'=>$this->input->post('test_name'),
				'test_method_id'=>$this->input->post('test_method'),
				'test_area_id'=>$this->input->post('test_area'),
				'binary_result'=>$binary,
				'numeric_result'=>$numeric,
				'text_result'=>$text,
				'binary_positive'=>$this->input->post('binary_pos'),
				'binary_negative'=>$this->input->post('binary_neg'),
				'numeric_result_unit'=>$this->input->post('numeric_result_unit'),
				'hospital_id' => $hospital['hospital_id']
			);
                        $this->db->trans_start();
                        $this->db->insert('test_master', $data);
                       
                        $test_master_id = $this->db->insert_id();
                     

                        $rangeItemsCount = $this->input->post('range_item_count');                        
                        $range_data = array();
                        if(in_array('2',$this->input->post('output_format'))){
                            for($count =1; $count <= $rangeItemsCount;$count++){
                                if($this->input->post('range'.$count)=='3'){
                                    $min = $this->input->post('range_low'.$count);
                                    $max = $this->input->post('range_high'.$count);
                                }
                                elseif($this->input->post('range'.$count)=='1'){
                                    $max = $this->input->post('value_less_than'.$count);
                                    $min = NULL;
                                }elseif($this->input->post('range'.$count)=='2'){
                                    $min = $this->input->post('value_greater_than'.$count);
                                    $max=NULL;
                                }else{
                                    $min = NULL;
                                    $max = NULL;
                                }
                                if($this->input->post('age'.$count)=='3'){
                                    $from_year = $this->input->post('year_low'.$count);
                                    $from_month = $this->input->post('month_low'.$count);
                                    $from_day = $this->input->post('day_low'.$count);
                                    $to_year = $this->input->post('year_high'.$count);
                                    $to_month = $this->input->post('month_high'.$count);
                                    $to_day = $this->input->post('day_high'.$count);
                                }elseif($this->input->post('age'.$count)=='1'){
                                    $to_year = $this->input->post('upper_age_limit_years'.$count);
                                    $to_month = $this->input->post('upper_age_limit_months'.$count);
                                    $to_day = $this->input->post('upper_age_limit_days'.$count);
                                    $from_year = 0;
                                    $from_month = 0;
                                    $from_day = 0;
                                }elseif($this->input->post('age'.$count)=='2'){
                                    $from_year = $this->input->post('lower_age_limit_years'.$count);
                                    $from_month = $this->input->post('lower_age_limit_months'.$count);
                                    $from_day = $this->input->post('lower_age_limit_days'.$count);
                                    $to_year = 0;
                                    $to_month = 0;
                                    $to_day = 0;                                  
                                }else{
                                    $from_year = 0;
                                    $from_month = 0;
                                    $from_day = 0;
                                    $to_year = 0;
                                    $to_month = 0;
                                    $to_day = 0;
                                }
                                $range_data[]=array(
                                    'test_master_id' => $test_master_id,
                                    'range_type'=> $this->input->post('range'.$count),
                                    'gender' => $this->input->post('gender'.$count),
                                    'age_type' => $this->input->post('age'.$count), 
                                    'min' => $min,
                                    'max' => $max,
                                    'from_year' => $from_year,
                                    'from_month' => $from_month,
                                    'from_day' => $from_day,
                                    'to_year' => $to_year,
                                    'to_month' => $to_month,
                                    'to_day' => $to_day
                                 );
                            }
                           $this->db->insert_batch('test_range', $range_data);
                        }
                       $this->db->trans_complete();
                       if($this->db->trans_status()===FALSE){
                           $this->db->trans_rollback();
                           return false;
                      }
                            return true;
                        
		}
		elseif ($type=="antibiotic") {
			$data=array('antibiotic'=>$this->input->post('antibiotic'),
				'hospital_id'=>$hospital['hospital_id']);
		$table="antibiotic";
		}
		elseif ($type=="micro_organism") {
			$data=array('micro_organism'=>$this->input->post('micro_organism'),
				'hospital_id'=>$hospital['hospital_id']);
		$table="micro_organism";
		}
		elseif ($type=="specimen_type") {
			$data=array('specimen_type'=>$this->input->post('specimen_type'),
				'hospital_id'=>$hospital['hospital_id']);
		$table="specimen_type";
		}
		elseif ($type=="sample_status") {
			$data=array('sample_status'=>$this->input->post('sample_status'),
				'hospital_id'=>$hospital['hospital_id']);
		$table="sample_status";
		}
		elseif ($type=="lab_unit") {
			$data=array('lab_unit'=>$this->input->post('lab_unit'),
				'hospital_id'=>$hospital['hospital_id']);
		$table="lab_unit";
		}
		
		if($type=="area_types"){
		$data = array(
					  'area_type'=>$this->input->post('area_type')
			);

		$table="area_types";
		}
		elseif($type=="area_activity"){
		$data = array(
					  'activity_name'=>$this->input->post('activity_name'),
					 'frequency'=>$this->input->post('frequency'),
					   'weightage'=>$this->input->post('weightage'),
					   'area_type_id'=>$this->input->post('area_type'),
					   'frequency_type'=>$this->input->post('frequency_type')
			);

		$table="area_activity";
		}
		elseif($type=="activity_done"){
		$data = array(
					  'date'=>date("Y-m-d",strtotime($this->input->post('date'))),
					 'time'=>$this->input->post('time'),
					 'staff_id'=>$this->input->post('staff'),
					  'activity_id'=>$this->input->post('activity_name'));

		$table="activity_done";
		}
		elseif($type=="department"){
		$data = array(
					  'department'=>$this->input->post('department_name'),
					  'hospital_id'=>$this->input->post('hospital'));

		$table="department";
		}
		elseif($type=="districts"){
		$data = array(
					  'district'=>$this->input->post('district'),
					 'state_id'=>$this->input->post('states'),
					   'longitude'=>$this->input->post('longitude'),
					   'latitude'=>$this->input->post('latitude')
			);

		$table="district";
		}
		elseif($type=="hospital"){
		$data = array(
					  'hospital'=>$this->input->post('hospital_name'),
					 'hospital_type_id'=>$this->input->post('facility_type'),
					   'place'=>$this->input->post('address'),
					   'village_town_id'=>$this->input->post('village_town')
			);

		$table="hospital";
		}
		elseif($type=="facility_activity"){
			$this->db->select('frequency')->from('area_activity')->where('area_activity_id',$this->input->post('area_activity'));
			$query=$this->db->get();
			$result=$query->row();
			$frequency=$result->frequency;
			$data=array();
			for($i=0;$i<$frequency;$i++){
				$data[] = array(
						'facility_area_id'=>$this->input->post('area'),
						'area_activity_id'=>$this->input->post('area_activity')
					);
			}
			$this->db->trans_start();
			$this->db->insert_batch('facility_activity',$data);
			$this->db->trans_complete();
			if($this->db->trans_status()===FALSE)
				return false;
			else return true;
		}
		
		
		
		elseif($type=="facility_type"){
		$data = array(
					  'facility_type'=>$this->input->post('facility_type')
			);

		$table="facility_type";
		}
		
		elseif($type=="area"){
		$data = array(
					  'area_name'=>$this->input->post('area_name'),
					   'department_id'=>$this->input->post('department'),
					   'area_type_id'=>$this->input->post('area_type')
			);

		$table="area";
		}
		elseif($type=="states"){
		$data = array(
					  'state'=>$this->input->post('state'),
					   'longitude'=>$this->input->post('longitude'),
					   'latitude'=>$this->input->post('latitude')
			);

		$table="state";
		}
		elseif($type=="vendor"){
		$data = array(
					  'vendor_name'=>$this->input->post('vendor_name'),
					  'vendor_type_id'=>$this->input->post('vendor_type_id'),
					   'vendor_address'=>$this->input->post('vendor_address'),
					   //'village_town_id'=>$this->input->post('village_town_id'),
					   //'vendor_state_id'=>$this->input->post('vendor_state_id'),
					   //'district_id'=>$this->input->post('vendor_state_id'),
					  // 'vendor_country_id'=>$this->input->post('vendor_country_id'),
					   'account_no'=>$this->input->post('account_no'),
					   'bank_name'=>$this->input->post('bank_name'),
					   'branch'=>$this->input->post('branch'),
					   'vendor_email'=>$this->input->post('vendor_email'),
					   'vendor_phone'=>$this->input->post('vendor_phone'),
					   'vendor_pan'=>$this->input->post('vendor_pan'),
					   'contact_person_id'=>$this->input->post('contact_person_id')
			);
		$table="vendor";
		}
		elseif($type=="contact_person"){
		$data = array(
					  'contact_person_first_name'=>$this->input->post('contact_person_first_name'),
					  'contact_person_last_name'=>$this->input->post('contact_person_last_name'),
					  'contact_person_email'=>$this->input->post('contact_person_email'),
					  'contact_person_contact'=>$this->input->post('contact_person_contact'),
					  'vendor_id'=>$this->input->post('vendor_id'),
					  'gender'=>$this->input->post('gender'),
					  'designation'=>$this->input->post('designation'),
					  
			);

		$table="contact_person";
		}
		
		elseif($type=="vendor_contracts"){
		$data = array(
					  'vendor_name'=>$this->input->post('vendor_name'),
					   'facility_name'=>$this->input->post('facility_name'),
					  'form_date'=>$this->input->post('form_date'),
					  'to_date'=>$this->input->post('to_date'),
					  'status'=>$this->input->post('status'),
			);

		$table="vendor_contracts";
		}
		elseif($type=="village_town"){
		$data = array(
					  'village_town'=>$this->input->post('village_town'),
					   'district_id'=>$this->input->post('district'),
					  'pin_code'=>$this->input->post('pin_code'),
					  'longitude'=>$this->input->post('longitude'),
					  'latitude'=>$this->input->post('latitude'),
			);

		$table="village_town";
		}
		$this->db->trans_start();
         if(isset($table)){
		
		$this->db->insert($table,$data);
		 }
		$this->db->trans_complete();
		if($this->db->trans_status()===FALSE){
			return false;
		}
		else{
		  return true;
		}	
	}
      
    function get_transaction_type(){
        $this->db->select("hr_transaction_type_id, hr_transaction_type")->from("hr_transaction_type");
        return $this->db->get()->result();
    }
    
    function add_assay(){
		$hospital = $this->session->userdata('hospital');
		$assay = $this->input->post('assay_name');
		
		$data = array(
			'assay_id'=> 'NULL',
			'assay'=> $this->input->post('assay_name'),
			'hospital_id' => $hospital['hospital_id']
		);
		$this->db->trans_start();
		$this->db->insert('test_assay', $data);
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			return false;
		}
		else return true;	
   }
   
   
   function get_assay(){
	$hospital = $this->session->userdata('hospital');
   	if($this->input->post('assay_id')!='')
   		$this->db->where('assay_id',$this->input->post('assay_id'));
   	else if ($this->input->post('assay')!='')
   		$this->db->like('assay',$this->input->post('assay'),'both');
   	$this->db->select("*")->from("test_assay")->where('hospital_id',$hospital['hospital_id']);
   	return $this->db->get()->result();
   }
   
   
   function update_assay(){
   	$data = array(
			'assay'=> $this->input->post('assay_name')
		);
   	$this->db->trans_start();
	$this->db->where('assay_id',$this->input->post('assay_id'));
	$this->db->update('test_assay',$data);
	$this->db->trans_complete();
		if($this->db->trans_status() === FALSE){
			return false;
		}
		else return true;
   }

   function add_test_name() {
	   $hospital = $this->session->userdata('hospital');
	   $test_area = $this->input->post('test_area');
	   $test_method = $this->input->post('test_method');
	   $test_name = $this->input->post('test_name');
   }

   function get_users(){
   		$this->db->select("user_id, username")->from("user");
        return $this->db->get()->result();
   }
   
   
	function get_defaultvalue($filter_value) {
		$this->db->select("value")
			->from("defaults")
			->where('default_id',$filter_value);
		$query=$this->db->get();
		return $query->result();
	}

	function get_user_details($default_rowsperpage){
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
		
		$hospital_id = $this->session->userdata('hospital')['hospital_id'];
		if($hospital_id != '')
				$this->db->where('staff.hospital_id', $hospital_id);
		if($this->input->post('username')){
			$this->db->where('user.username',$this->input->post('username'));
		}
		
		if($this->input->post('phone')){
			echo("<script>console.log('searching for phone number');</script>");

			$this->db->where('staff.phone',$this->input->post('phone'));
		}

		if($this->input->post('email')){
			$this->db->where('staff.email',$this->input->post('email'));
		}
		
		if($this->input->post('status')){
		    	if($this->input->post('status')=="Yes"){
				$this->db->like('user.active',1);
			}
			else{
				$this->db->like('user.active',0);
			}
		}

		$this->db->select("hospital.hospital,user.user_id,username,password,user.staff_id,user.active,first_name,last_name,gender, specialisation, email, designation,phone,department")
		->from("user")
		->join('staff','user.staff_id=staff.staff_id')
		->join('hospital','staff.hospital_id=hospital.hospital_id')
		->join('department','staff.department_id=department.department_id');
		if($this->input->post('search'))
		{
			$user = strtolower($this->input->post('user'));
			$this->db->like('LOWER(username)',$user,'after');
		}
		if($this->input->post('select') || $this->input->post('update'))
		{
			if($this->input->post('select')) $user_id = $this->input->post('user_id');
			else if($this->input->post('update')) $user_id = $this->input->post('user');
			$this->db->select('function_id,add,edit,view,remove')->where('user.user_id',$user_id)
			->join('user_function_link','user.user_id=user_function_link.user_id');				
		}
		if ($default_rowsperpage !=0){
			$this->db->limit($rows_per_page,$start);
		}
		$query = $this->db->get();
		return $query->result();
	}

	function get_functions_related_user($default_rowsperpage)
	{
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

		if ($default_rowsperpage !=0){
			$this->db->limit($rows_per_page,$start);
		}

		$this->db->select("user_function_link.user_id,user_function_link.add,user_function_link.view,user_function_link.edit,user_function.user_function,
						   user_function.description,staff.first_name,staff.gender,staff.specialisation,staff.email,staff.phone,staff.status,
						   staff.designation")
				->from("user_function_link")
				->join('user_function','user_function.user_function_id=user_function_link.function_id','left')
				->join('user','user.user_id=user_function_link.user_id','left')
				->join('staff','staff.staff_id=user.staff_id','left')
				->where('user_function_link.function_id',$this->input->post('user_functions'));
		$query = $this->db->get();
		return $query->result();
	}

	function get_functions_related_user_count()
    {
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

		if ($default_rowsperpage !=0){
			$this->db->limit($rows_per_page,$start);
		}

		$this->db->select("count(*) as count",false)
				->from("user_function_link")
				->join('user_function','user_function.user_function_id=user_function_link.function_id','left')
				->join('user','user.user_id=user_function_link.user_id','left')
				->join('staff','staff.staff_id=user.staff_id','left')
				->where('user_function_link.function_id',$this->input->post('user_functions'));
		$query = $this->db->get();
		return $query->result();
    }

	//Newly added on jan 31 2024 - to end
	function check_route_primary($hospital_id, $route_primary) 
    {
        $hospital=$this->session->userdata('hospital');
        $this->db->where('hospital_id', $hospital['hospital_id']);
        $this->db->where('route_primary', $route_primary);
        $query = $this->db->get('route_primary');
        return $query->num_rows() > 0;
    }

    function insert_route_primary($data) 
    {
        $this->db->insert('route_primary', $data);
    }

    function get_all_primary_routes($default_rowsperpage)
    {
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

		if ($default_rowsperpage !=0){
			$this->db->limit($rows_per_page,$start);
		}

		$hospital=$this->session->userdata('hospital');
		$this->db->select("route_primary.route_primary_id,route_primary.route_primary as route_name,hospital.hospital as hospital_name")
		->from("route_primary")
		->join('hospital','hospital.hospital_id=route_primary.hospital_id','left');
		$this->db->where('route_primary.hospital_id', $hospital['hospital_id']);
		$query = $this->db->get();
		return $query->result();
    }

	function get_all_primary_routes_count()
	{
		$hospital=$this->session->userdata('hospital');
		$this->db->select("count(*) as count",false)
		->from("route_primary")
		->join('hospital','hospital.hospital_id=route_primary.hospital_id','left');
		$this->db->where('route_primary.hospital_id', $hospital['hospital_id']);
		$query = $this->db->get();
		return $query->result();
	}

	function get_edit_primary_route_by_id($record_id) 
	{
		$this->db->select('route_primary_id,route_primary');
        $query = $this->db->get_where('route_primary', array('route_primary_id' => $record_id));
        return $query->row_array();
    }

    function update_primary_routes_name($record_id, $data) {
        $this->db->where('route_primary_id', $record_id);
        $this->db->update('route_primary', $data);
    }

	function check_route_secondary($hospital_id, $route_primary, $route_secondary) 
    {
        $hospital=$this->session->userdata('hospital');
        $this->db->where('hospital_id', $hospital['hospital_id']);
        $this->db->where('route_primary_id', $route_primary);
        $this->db->where('route_secondary', $route_secondary);
        $query = $this->db->get('route_secondary');
        return $query->num_rows() > 0;
    }

	function insert_route_secondary($data) 
    {
        $this->db->insert('route_secondary', $data);
    }

	function get_all_secondary_routes($default_rowsperpage)
    {
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

		if ($default_rowsperpage !=0){
			$this->db->limit($rows_per_page,$start);
		}
		$search_route_primary_id = $this->input->post('search_route_primary_id');
		if($this->input->post('search_route_primary_id'))
		{
			$this->db->where('route_secondary.route_primary_id',$search_route_primary_id);
		}

		$hospital=$this->session->userdata('hospital');
		$this->db->select("route_secondary.id,route_secondary.route_secondary as secondary_name, route_primary.route_primary as primary_name, hospital.hospital as hname")
		->from("route_secondary")
		->join("route_primary",'route_primary.route_primary_id=route_secondary.route_primary_id','left')
		->join('hospital','hospital.hospital_id=route_secondary.hospital_id','left');
		$this->db->where('route_secondary.hospital_id', $hospital['hospital_id']);
		$query = $this->db->get();
		return $query->result();
    }

	function get_all_secondary_routes_count()
	{
		$search_route_primary_id = $this->input->post('search_route_primary_id');
		if($this->input->post('search_route_primary_id'))
		{
			$this->db->where('route_secondary.route_primary_id',$search_route_primary_id);
		}
		
		$hospital=$this->session->userdata('hospital');
		$this->db->select("count(*) as count",false)
		->from("route_secondary")
		->join("route_primary",'route_primary.route_primary_id=route_secondary.route_primary_id','left')
		->join('hospital','hospital.hospital_id=route_secondary.hospital_id','left');
		$this->db->where('route_secondary.hospital_id', $hospital['hospital_id']);
		$query = $this->db->get();
		return $query->result();
	}

	function get_edit_secondary_route_by_id($record_id) 
	{
		$this->db->select('id,route_primary_id,hospital_id,route_secondary');
        $query = $this->db->get_where('route_secondary', array('id' => $record_id));
        return $query->row_array();
    }

	function update_secondary_routes_name($record_id, $data) {
        $this->db->where('id', $record_id);
        $this->db->update('route_secondary', $data);
    }

	function get_user_function_display($record_id)
	{
		$this->db->select('user_function_id,user_function,description,user_function_display');
        $query = $this->db->get_where('user_function', array('user_function_id' => $record_id));
        return $query->row_array();
	}

	function update_des_user_function($record_id, $data) 
	{
        $this->db->where('user_function_id', $record_id);
        $query = $this->db->update('user_function', $data);
		return $query ;
    }
	//counseling type functions start
	function check_couseling_type($counseling_type) 
    {
        $this->db->where('counseling_type', $counseling_type);
        $query = $this->db->get('counseling_type');
        return $query->num_rows() > 0;
    }

    function insert_counseling_type($data) 
    {
        $this->db->insert('counseling_type', $data);
    }

    function get_all_counseling_type()
    {
		$hospital=$this->session->userdata('hospital');
		$this->db->select("counseling_type.counseling_type_id,counseling_type.counseling_type, 
		staff.first_name, counseling_type.created_date_time,counseling_type.updated_date_time,updated_by.first_name as updated_by_name")
		->from("counseling_type")
		->join('staff','staff.staff_id=counseling_type.created_by','left')
		->join('staff as updated_by','updated_by.staff_id=counseling_type.updated_by','left');
		$query = $this->db->get();
		return $query->result();
    }
	function get_all_counseling_type_count()
	{
		$hospital=$this->session->userdata('hospital');
		$this->db->select("count(*) as count",false)
		->from("counseling_type")
		->join('staff','staff.staff_id=counseling_type.created_by','left')
		->join('staff as updated_by','updated_by.staff_id=counseling_type.updated_by','left');
		$query = $this->db->get();
		return $query->result();
	}

	function get_edit_counseling_type_by_id($record_id) 
	{
		$this->db->select('counseling_type,created_by,updated_by,created_date_time,updated_date_time,counseling_type_id');
        $query = $this->db->get_where('counseling_type', array('counseling_type_id' => $record_id));
        return $query->row_array();
    }

    function update_counseling_type($record_id, $data) {
        $this->db->where('counseling_type_id', $record_id);
        $this->db->update('counseling_type', $data);
    }
	// conseling type functions end here

	//counseling text function start here
	function check_counseling_text($hospital_id, $counseling_type_id, $counseling_text) 
    {
        $hospital=$this->session->userdata('hospital');
        $this->db->where('hospital_id', $hospital['hospital_id']);
        $this->db->where('counseling_type_id', $counseling_type_id);
        $this->db->where('counseling_text', $counseling_text);
        $query = $this->db->get('counseling_text');
        return $query->num_rows() > 0;
    }

	function insert_counseling_text($data) 
    {
        $this->db->insert('counseling_text', $data);
    }

	function get_all_counseling_text()
    {
		$hospital=$this->session->userdata('hospital');
		$this->db->select("h.hospital as hname,counseling_type.counseling_type,counseling_text.counseling_text,staff.first_name,
		counseling_text.created_date_time,counseling_text.updated_date_time,counseling_text.counseling_text_id,updated_by.first_name as updated_by_name,
		language.language as lname,counseling_text.active_text,counseling_text.global_text,counseling_text.hospital_id")
		->from("counseling_text")
		->join("counseling_type",'counseling_type.counseling_type_id=counseling_text.counseling_type_id','left')
		->join('staff','staff.staff_id=counseling_text.created_by','left')
		->join('staff as updated_by','updated_by.staff_id=counseling_text.updated_by','left')
		->join('language','language.language_id=counseling_text.language_id','left')
		->join('hospital as h','h.hospital_id=counseling_text.hospital_id','left');
		$this->db->where('counseling_text.hospital_id', $hospital['hospital_id']);
		$this->db->or_where("(counseling_text.global_text = 1 AND counseling_text.hospital_id != '".$hospital['hospital_id']."')", null, false);
		$query = $this->db->get();
		return $query->result();
    }
	function get_all_counseling_text_count()
	{
		$hospital=$this->session->userdata('hospital');
		$this->db->select("count(*) as count",false)
		->from("counseling_text")
		->join("counseling_type",'counseling_type.counseling_type_id=counseling_text.counseling_type_id','left')
		->join('hospital','hospital.hospital_id=counseling_text.hospital_id','left')
		->join('staff','staff.staff_id=counseling_text.created_by','left')
		->join('staff as updated_by','updated_by.staff_id=counseling_text.updated_by','left')
		->join('language','language.language_id=counseling_text.language_id','left')
		->join('hospital as h','h.hospital_id=counseling_text.hospital_id','left');
		$this->db->where('counseling_text.hospital_id', $hospital['hospital_id']);
		$this->db->or_where("(counseling_text.global_text = 1 AND counseling_text.hospital_id != '".$hospital['hospital_id']."')", null, false);
		$query = $this->db->get();
		return $query->result();
	}

	function get_edit_counseling_text_by_id($record_id) 
	{
		$this->db->select('counseling_text.language_id,counseling_text_id,counseling_type_id,counseling_text,
		active_text,hospital_id,created_by,updated_by,created_date_time,updated_date_time,counseling_text.global_text');
        $query = $this->db->get_where('counseling_text', array('counseling_text_id' => $record_id));
        return $query->row_array();
    }

	function update_counseling_text_name($record_id, $data) {
         $this->db->where('counseling_text_id', $record_id);
         $this->db->update('counseling_text', $data);
    }

	function get_all_language_ct()
	{
		$this->db->select("language,language_id")
		->from("language");
		$query = $this->db->get();
		return $query->result();
	}
	//counseling text function end here

	/* Custom form function start here */
	function get_all_custom_forms($default_rowsperpage)
    {
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

		if ($default_rowsperpage !=0){
			$this->db->limit($rows_per_page,$start);
		}
		
		$hospital=$this->session->userdata('hospital');
		$this->db->select("form.form_id,form.form_name,form.num_columns,form.form_type,form.print_layout_id,form.a6_print_layout_id")
		->from("form")
		->join('hospital','hospital.hospital_id=form.hospital_id','left');
		$this->db->where('form.hospital_id', $hospital['hospital_id']);
		$query = $this->db->get();
		return $query->result();
    }

	function get_all_custom_forms_count()
	{
		$hospital=$this->session->userdata('hospital');
		$this->db->select("count(*) as count",false)
		->from("form")
		->join('hospital','hospital.hospital_id=form.hospital_id','left');
		$this->db->where('form.hospital_id', $hospital['hospital_id']);
		$query = $this->db->get();
		return $query->result();
	}

	function delete_custom_form($data_to_insert)
	{
		$hospital=$this->session->userdata('hospital');
		$this->db->trans_start();
		$this->db->delete('form',array('form_id' => $data_to_insert,'hospital_id'=>$hospital['hospital_id']));
		$this->db->delete('form_layout',array('form_id' => $data_to_insert));
		$this->db->trans_complete();
		if($this->db->trans_status()===FALSE){
			return false;
		}
		else return true;
	}
	/* Custom Form ends here */

	function get_counseling_text_options($counselingTypeId,$language)
	{
		$hospital=$this->session->userdata('hospital');
		$this->db->select('counseling_text,counseling_text_id,global_text');
        $this->db->from('counseling_text');
        $this->db->where('counseling_type_id', $counselingTypeId);
        $this->db->where('language_id', $language);
        $this->db->where('active_text',1);
		$this->db->where("(global_text = 1 OR (global_text=0 AND hospital_id='".$hospital['hospital_id']."'))");
        $query = $this->db->get();
		return $query->result_array();
	}

	function get_all_couseling($visit_id)
	{
		$this->db->select('counseling.visit_id,counseling_type.counseling_type,counseling.sequence_id,user.username,counseling.updated_by,counseling.created_date_time,counseling.updated_date_time,counseling_text.counseling_text')
        ->from('counseling')
		->join("counseling_text",'counseling_text.counseling_text_id=counseling.counseling_text_id','left')
		->join("counseling_type",'counseling_type.counseling_type_id=counseling_text.counseling_type_id','left')
		->join("user",'user.user_id=counseling.created_by','left');
        $this->db->where('counseling.visit_id', $visit_id);
        $this->db->order_by('counseling.sequence_id', 'ASC');
        $query = $this->db->get();
		return $query->result();
	}

	function get_all_couseling_for_print($hosp_file_no)
	{	
		$this->db->select('counseling_text.counseling_text,counseling_type.counseling_type')
		->from('counseling')
		->join("patient_visit",'patient_visit.visit_id=counseling.visit_id','left')
		->join("counseling_text",'counseling_text.counseling_text_id=counseling.counseling_text_id','left')
		->join("counseling_type",'counseling_type.counseling_type_id=counseling_text.counseling_type_id','left');
       // $this->db->where('patient_visit.hosp_file_no', $hosp_file_no); if below code got any errors remove below code and uncomment it <!-- changed on 24-07-2024 -->
        $this->db->where('patient_visit.visit_id', $hosp_file_no);
        $query = $this->db->get();
		return $query->result();
	}

	//visit type function start here
	function check_visit_type($visit_name) 
    {
		$hospital=$this->session->userdata('hospital');
        $this->db->where('hospital_id', $hospital['hospital_id']);
        $this->db->where('visit_name', $visit_name);
        $query = $this->db->get('visit_name');
        return $query->num_rows() > 0;
    }

	function check_visit_type_inuse($visit_name,$inuse,$op_ip) 
    {
		$hospital=$this->session->userdata('hospital');
        $this->db->where('hospital_id', $hospital['hospital_id']);
        $this->db->where('visit_name', $visit_name);
        $this->db->where('inuse', $inuse);
        $this->db->where('op_ip', $op_ip);
        $query = $this->db->get('visit_name');
        return $query->num_rows() > 0;
    }

    function insert_visit_type($data) 
    {
        $this->db->insert('visit_name', $data);
    }

    function get_all_visit_type($default_rowsperpage)
    {

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

		if ($default_rowsperpage !=0){
			$this->db->limit($rows_per_page,$start);
		}

		$hospital=$this->session->userdata('hospital');
		$this->db->select(" visit_name.visit_name,visit_name.inuse,visit_name.visit_name_id,visit_name.op_ip,
		staff.first_name, visit_name.created_date_time,visit_name.updated_date_time,updated_by.first_name as updated_by_name")
		->from("visit_name")
		->join('staff','staff.staff_id=visit_name.created_by','left')
		->join('staff as updated_by','updated_by.staff_id=visit_name.updated_by','left');
		$this->db->where('visit_name.hospital_id', $hospital['hospital_id']);
		$query = $this->db->get();
		return $query->result();
    }
	function get_all_visit_type_count()
	{
		$hospital=$this->session->userdata('hospital');
		$this->db->select("count(*) as count",false)
		->from("visit_name")
		->join('staff','staff.staff_id=visit_name.created_by','left')
		->join('staff as updated_by','updated_by.staff_id=visit_name.updated_by','left');
		$this->db->where('visit_name.hospital_id', $hospital['hospital_id']);
		$query = $this->db->get();
		return $query->result();
	}

	function get_edit_visit_type_by_id($record_id) 
	{
		$this->db->select('visit_name,inuse,created_by,updated_by,created_date_time,updated_date_time,visit_name_id,op_ip');
        $query = $this->db->get_where('visit_name', array('visit_name_id' => $record_id));
        return $query->row_array();
    }

    function update_visit_type($record_id, $data) {
        $this->db->where('visit_name_id', $record_id);
        $this->db->update('visit_name', $data);
    }
	//visit type function end here
	//priority type function start here
	function check_priority_type($priority_type) 
    {
		$hospital=$this->session->userdata('hospital');
        $this->db->where('hospital_id', $hospital['hospital_id']);
        $this->db->where('priority_type', $priority_type);
        $query = $this->db->get('priority_type');
        return $query->num_rows() > 0;
	}

    function insert_priority_type($data) 
    {
        $this->db->insert('priority_type', $data);
    }

    function get_all_priority_type($default_rowsperpage)
    {

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

		if ($default_rowsperpage !=0){
			$this->db->limit($rows_per_page,$start);
		}

		$hospital=$this->session->userdata('hospital');
		$this->db->select(" priority_type.priority_type,priority_type.priority_type_id,priority_type.color_code,
		staff.first_name, priority_type.created_date_time,priority_type.updated_date_time,updated_by.first_name as updated_by_name")
		->from("priority_type")
		->join('staff','staff.staff_id=priority_type.created_by','left')
		->join('staff as updated_by','updated_by.staff_id=priority_type.updated_by','left');
		$this->db->where('priority_type.hospital_id', $hospital['hospital_id']);
		$query = $this->db->get();
		return $query->result();
    }
	function get_all_priority_type_count()
	{
		$hospital=$this->session->userdata('hospital');
		$this->db->select("count(*) as count",false)
		->from("priority_type")
		->join('staff','staff.staff_id=priority_type.created_by','left')
		->join('staff as updated_by','updated_by.staff_id=priority_type.updated_by','left');
		$this->db->where('priority_type.hospital_id', $hospital['hospital_id']);
		$query = $this->db->get();
		return $query->result();
	}

	function get_edit_priority_type_by_id($record_id) 
	{
		$this->db->select('priority_type,created_by,updated_by,created_date_time,updated_date_time,priority_type_id,color_code');
        $query = $this->db->get_where('priority_type', array('priority_type_id' => $record_id));
        return $query->row_array();
    }

    function update_priority_type($record_id, $data) {
        $this->db->where('priority_type_id', $record_id);
        $this->db->update('priority_type', $data);
    }

	function delete_priority()
    {
        $priority_type = $this->input->post('priority_type_id');
        $hospital=$this->session->userdata('hospital');
        
		$this->db->where('priority_type_id', $priority_type);
		$query = $this->db->get('patient_followup');
		if ($query->num_rows() > 0) 
		{
			$data = array(
				'priority_type_id' => 0,
			);
			$this->db->where('priority_type_id', $priority_type);
			$this->db->update('patient_followup', $data);
		}
        $this->db->where('hospital_id', $hospital['hospital_id']);
        $this->db->where('priority_type_id', $priority_type);
        $res = $this->db->delete('priority_type');

        return $this->db->affected_rows() > 0;
    }

	//priority type function end here

	//custom report name start here
	function check_report_name($hospital_id, $report_name) 
    {
        $hospital=$this->session->userdata('hospital');
        $this->db->where('hospital_id', $hospital['hospital_id']);
        $this->db->where('report_name', $report_name);
        $query = $this->db->get('custom_report');
        return $query->num_rows() > 0;
    }

	function insert_report_name($data) 
    {
        $this->db->insert('custom_report', $data);
    }

	function get_all_report_name()
    {
		$hospital=$this->session->userdata('hospital');
		$this->db->select("h.hospital as hname,staff.first_name,updated_by.first_name as updated_by_name,
		cr.report_name,cr.created_date_time,cr.updated_date_time,cr.report_id,h.hospital_id")
		->from("custom_report cr")
		->join('staff','staff.staff_id=cr.created_by','left')
		->join('staff as updated_by','updated_by.staff_id=cr.updated_by','left')
		->join('hospital as h','h.hospital_id=cr.hospital_id','left');
		$this->db->where('cr.hospital_id', $hospital['hospital_id']);
		$query = $this->db->get();
		return $query->result();
    }

	function get_all_report_name_count()
	{
		$hospital=$this->session->userdata('hospital');
		$this->db->select("count(*) as count",false)
		->from("custom_report cr")
		->join('staff','staff.staff_id=cr.created_by','left')
		->join('staff as updated_by','updated_by.staff_id=cr.updated_by','left')
		->join('hospital as h','h.hospital_id=cr.hospital_id','left');
		$this->db->where('cr.hospital_id', $hospital['hospital_id']);
		$query = $this->db->get();
		return $query->result();
	}

	function get_edit_report_name_by_id($record_id) 
	{
		$this->db->select('report_id,hospital_id,report_name,created_by,updated_by,created_date_time,updated_date_time');
        $query = $this->db->get_where('custom_report', array('report_id' => $record_id));
        return $query->row_array();
    }

	function update_report_name($record_id, $data) {
         $this->db->where('report_id', $record_id);
         $this->db->update('custom_report', $data);
    }
	
	function get_custom_form_name($form_id)
	{
		$this->db->select('report_id,hospital_id,report_name,created_by,updated_by,created_date_time,updated_date_time');
        $query = $this->db->get_where('custom_report', array('report_id' => $record_id));
        return $query->row_array();
	}

	function upload_custom_form()
	{
		$hospital = $this->session->userdata('hospital');

		$fields = json_decode($this->input->post('fields'));
		$width = json_decode($this->input->post('wid'));
		$ft = json_decode($this->input->post('funct'));
		$field_value = json_decode($this->input->post('field_value'));
		$table = json_decode($this->input->post('table'));
		$report_id = $this->input->post('form_id');
		$from_table = $this->input->post('from_table');
		$columns = $this->input->post('columns');
		$count = count($fields->field_name);

		$this->db->trans_start();
		$data_1 =array();
		$data_1= array(
			'main_table' => $from_table,
		);
		$this->db->where('report_id', $report_id);
        $this->db->update('custom_report', $data_1);
		$fields_data = array();
		for ($i = 0; $i < $count; $i++) {
			$fields_data[] = array(
				'report_id' => $report_id,
				'table_name' => $table->table_name[$i], 
				'field_name' => $fields->field_name[$i],
				'width' => $width->def_width[$i],
				'function' => $ft->get_function[$i],
				'column_name' => $field_value->field_values[$i],
				'sequence_id' => $i + 1,
			);
		}

		$this->db->insert_batch('report_layout', $fields_data);
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE) {
			return false;
		} else {
			return true;
		}

	}

	public function get_report_layout_fields($form_id)
	{
		$hospital=$this->session->userdata('hospital');
		$this->db->select("rl.report_id,rl.table_name,rl.field_name,rl.column_name,rl.sequence_id,
		cr.report_name,rl.width,cr.main_table")
		->from("report_layout rl")
		->join('custom_report cr','cr.report_id=rl.report_id','left');
		$this->db->where('cr.hospital_id', $hospital['hospital_id']);
		$this->db->where('rl.report_id', $form_id);
		$query = $this->db->get();
		if(empty($query->result()))
		{
			return 0;
		}else{
			return $query->result();
		}
	}

	public function get_customised_report_data($default_rowsperpage)
	{
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

		$hospital=$this->session->userdata('hospital');
		$this->db->select("rl.table_name,rl.field_name,rl.sequence_id,cr.main_table,rl.function")
		->from("report_layout rl")
		->join('custom_report cr','cr.report_id=rl.report_id','left');
		$this->db->where('cr.hospital_id', $hospital['hospital_id']);
		$this->db->where('cr.report_id', $this->input->post('form_id'));
		$query = $this->db->get();
		$fields_columns = $query->result();
		
		if($this->input->post('from_date') && $this->input->post('to_date'))
		{
			$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));   
		}
		else if($this->input->post('from_date') || $this->input->post('to_date'))
		{
			$this->input->post('from_date')?$from_date=$this->input->post('from_date'):$from_date=$this->input->post('to_date');
			$to_date=$from_date;
		}
	
        if($this->input->post('from_time') && $this->input->post('to_time'))
		{
			$from_time=date("H:i",strtotime($this->input->post('from_time')));
			$to_time=date("H:i",strtotime($this->input->post('to_time')));
				
		}
		else if($this->input->post('from_time') || $this->input->post('to_time'))
		{
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

		if($this->input->post('department')){
			$this->db->where('patient_visit.department_id',$this->input->post('department'));
		}
		if($this->input->post('unit')){
			$this->db->select('IF(unit!="",unit,0) unit',false);
			$this->db->where('patient_visit.unit',$this->input->post('unit'));
		}
		
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('patient_visit.area',$this->input->post('area'));
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
		
		if ($this->input->post('ndps') != 0){ $this->db->where('patient_followup.ndps', $this->input->post('ndps') == 1 ? 1 : 0); }

		if ($this->input->post('sort_by_age')){ $this->db->order_by('patient.age_years', $this->input->post('sort_by_age') == 1 ? 'ASC' : 'DESC'); }

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
		
		if($this->input->post('priority_type')){
			$this->db->where('patient_followup.priority_type_id',$this->input->post('priority_type'));
		}

		if($this->input->post('volunteer')){
			$this->db->where('patient_followup.volunteer_id',$this->input->post('volunteer'));
		}

		if($this->input->post('route_secondary')){
			$this->db->where('patient_followup.route_secondary_id',$this->input->post('route_secondary'));
		}

		if($this->input->post('district')){
			$this->db->where('patient.district_id',$this->input->post('district'));
		}
		
		if($this->input->post('state')){
			$this->db->where('state.state_id',$this->input->post('state'));
		}

		if($this->input->post('visit_name')){
			$this->db->where('patient_visit.visit_name_id',$this->input->post('visit_name'));
		}
		
		$selected_columns = [];
		$admit_date = "MAX(admit_date)";
		foreach($fields_columns as $fc)
		{
			$selected_columns[] = $fc->table_name.'.'.$fc->field_name;
			if($fc->field_name=="admit_date" && $fc->function=="min")
			{
				$admit_date = "MIN(admit_date)";
			}
		}
		$main_table = $fields_columns[0]->main_table;
		$columns_string = implode(', ', $selected_columns);
		if ($main_table == 'patient_followup') 
		{
			$columns_string = str_replace('patient_followup.followup_upd_btn', '', $columns_string);
			if($columns_string!='patient_followup.patient_id')
			{
				$this->db->select("$columns_string,icd_code.code_title,staff.first_name,followup_update_by.first_name as updated_first_name,
				followup_update_by.last_name as updated_last_name,patient_followup.patient_id");
			}else
			{
				$this->db->select("$columns_string,icd_code.code_title,staff.first_name,followup_update_by.first_name as updated_first_name,
				followup_update_by.last_name as updated_last_name");
			}
		} elseif ($main_table == 'patient_visit') {
			$columns_string = str_replace('patient_visit.update_btn', '', $columns_string);
			if($columns_string!='patient_visit.patient_id')
			{
				$this->db->select("$columns_string,department.department,unit.unit_name,area.area_name,
				visit_name.visit_name,icd_code.code_title, volunteer.first_name as vfirst_name, volunteer_updated.first_name as vufirst_name,
				patient_visit.visit_id,patient_visit.patient_id");

			}else{
				$this->db->select("$columns_string,department.department,unit.unit_name,area.area_name,
				visit_name.visit_name,icd_code.code_title, volunteer.first_name as vfirst_name, volunteer_updated.first_name as vufirst_name,
				patient_visit.visit_id");
			}
		} elseif ($main_table == 'patient') {
			$this->db->select("$columns_string,department.department,unit.unit_name,area.area_name,
			visit_name.visit_name, icd_code.code_title");
		}

		switch ($main_table) 
		{
			case 'patient_followup':
			$this->db->from('patient_followup');
			$this->db->join('patient','patient_followup.patient_id=patient.patient_id','left');
			$this->db->join('patient_visit','patient_visit.patient_id=patient.patient_id','left');
			$this->db->join('priority_type','patient_followup.priority_type_id=priority_type.priority_type_id','left');
			$this->db->join('hospital','patient_followup.hospital_id=hospital.hospital_id','left');
			$this->db->join('icd_code','patient_followup.icd_code=icd_code.icd_code','left');
			$this->db->join('icd_block','icd_code.block_id=icd_block.block_id','left');
			$this->db->join('icd_chapter','icd_block.chapter_id=icd_chapter.chapter_id','left');
			$this->db->where('patient_followup.hospital_id',$hospital['hospital_id']);
			$this->db->join('route_secondary','patient_followup.route_secondary_id=route_secondary.id','left');
			$this->db->join('route_primary','route_secondary.route_primary_id=route_primary.route_primary_id','left');
			$this->db->join('district','patient.district_id=district.district_id','left');
			$this->db->join('state','district.state_id=state.state_id','left');
			$this->db->join('mlc','mlc.visit_id=patient_visit.visit_id','left');
			$this->db->join('staff','patient_followup.volunteer_id=staff.staff_id','left');
			$this->db->join('staff as followup_update_by','patient_followup.update_by=followup_update_by.staff_id','left');
			$this->db->where("(patient_followup.add_time BETWEEN '$from_date $from_time' AND '$to_date $to_time')");
			$this->db->group_by("patient_followup.patient_id");
			if($this->input->post('life_status') == 1 || empty($this->input->post('life_status'))){
				$this->db->where('patient_followup.life_status',1);
					}
			else if($this->input->post('life_status')== 2){
				$this->db->where('patient_followup.life_status',0);
			}
			else if($this->input->post('life_status')== 3){
				$this->db->where('patient_followup.life_status',2);
			}         
			$this->db->limit($rows_per_page,$start);	
			$final = $this->db->get();
			$final_result = $final->result();
			break;
		
			case 'patient_visit':
			$this->db->from('patient_visit');
			$this->db->join('patient','patient_visit.patient_id=patient.patient_id');
			$this->db->join('patient_followup','patient_followup.patient_id=patient.patient_id','left');
			$this->db->join('hospital','patient_visit.hospital_id=hospital.hospital_id','left');
			$this->db->join('department','patient_visit.department_id=department.department_id','left');
			$this->db->join('unit','patient_visit.unit=unit.unit_id','left');
			$this->db->join('area','patient_visit.area=area.area_id','left');
			$this->db->join('icd_code','patient_followup.icd_code=icd_code.icd_code','left');
			$this->db->join('icd_block','icd_code.block_id=icd_block.block_id','left');
			$this->db->join('icd_chapter','icd_block.chapter_id=icd_chapter.chapter_id','left');
			$this->db->join('visit_name','patient_visit.visit_name_id=visit_name.visit_name_id','left');	
			$this->db->join('mlc','mlc.visit_id=patient_visit.visit_id','left');
			$this->db->join('user as volunteer_user','patient_visit.insert_by_user_id = volunteer_user.user_id','left');
			$this->db->join('staff as volunteer','volunteer_user.staff_id=volunteer.staff_id','left');
			$this->db->join('user as volunteer_user_updated','patient_visit.insert_by_user_id = volunteer_user_updated.user_id','left');
			$this->db->join('staff as volunteer_updated','volunteer_user_updated.staff_id=volunteer_updated.staff_id','left');
			$this->db->where('patient_visit.hospital_id',$hospital['hospital_id']);
			$this->db->where("(patient_visit.admit_date BETWEEN '$from_date' AND '$to_date')");
			$this->db->where("(patient_visit.admit_time BETWEEN '$from_time' AND '$to_time')");
			$this->db->order_by('patient_visit.admit_date','ASC');
			$this->db->order_by('patient_visit.admit_time','ASC');
			if($this->input->post('op_ip')==1 || empty($this->input->post('op_ip')))
			{
				$this->db->where("patient_visit.visit_type","OP");
			}
			else if($this->input->post('op_ip')==2)
			{
				$this->db->where("patient_visit.visit_type","IP");
			}
			$this->db->limit($rows_per_page,$start);	
			$final = $this->db->get();
			$final_result = $final->result();
			break;	

			case 'patient':
			$this->db->from('patient');
			$this->db->join('patient_visit','patient.patient_id=patient_visit.patient_id','left');
			$this->db->join('patient_followup','patient.patient_id=patient_followup.patient_id','left');
			$this->db->join('department','patient_visit.department_id=department.department_id','left');
			$this->db->join('unit','patient_visit.unit=unit.unit_id','left');
			$this->db->join('area','patient_visit.area=area.area_id','left');
			$this->db->join('icd_code','patient_followup.icd_code=icd_code.icd_code','left');
			$this->db->join('icd_block','icd_code.block_id=icd_block.block_id','left');
			$this->db->join('icd_chapter','icd_block.chapter_id=icd_chapter.chapter_id','left');
			$this->db->join('visit_name','patient_visit.visit_name_id=visit_name.visit_name_id','left');
			$this->db->join('mlc','mlc.visit_id=patient_visit.visit_id','left');	
			$this->db->where('patient_visit.hospital_id',$hospital['hospital_id']);
			$this->db->where("(patient.insert_datetime BETWEEN '$from_date.$from_time' AND '$to_date.$to_time')");
			$this->db->limit($rows_per_page,$start);	
			$final = $this->db->get();
			$final_result = $final->result();
			break;
		}
		
		
		return $final_result;
	}

	function report_layout_report_id_count()
	{
		$this->db->distinct();
		$this->db->select('report_id');
		$this->db->from('report_layout');
		$res = $this->db->get()->result_array();
		return $res;
	}
	
	function delete_custom_layout_id()
    {
        $layout_delt_id = $this->input->post('layout_id');        
        $this->db->where('report_id', $layout_delt_id);
        $result = $this->db->delete('report_layout');
		if($result)
		{
			$this->db->where('report_id', $layout_delt_id);
			$this->db->delete('custom_report');
		}
		return $this->db->affected_rows() > 0;
    }

	function get_saved_custom_layout()
	{
		$report_id = $this->input->post('report_id');
		$this->db->select('rl.field_name,rl.column_name,rl.function,rl.table_name,rl.width,cr.main_table');
		$this->db->from('report_layout rl');
		$this->db->join('custom_report cr','cr.report_id=rl.report_id','left');
		$this->db->where('rl.report_id', $report_id);
		$res = $this->db->get()->result_array();
		return $res;
	}

	public function get_customised_report_data_count()
	{
		$hospital=$this->session->userdata('hospital');
		$this->db->select("rl.table_name,rl.field_name,rl.sequence_id,cr.main_table,rl.function")
		->from("report_layout rl")
		->join('custom_report cr','cr.report_id=rl.report_id','left');
		$this->db->where('cr.hospital_id', $hospital['hospital_id']);
		$this->db->where('cr.report_id', $this->input->post('form_id'));
		$query = $this->db->get();
		$fields_columns = $query->result();
		
		if($this->input->post('from_date') && $this->input->post('to_date'))
		{
			$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
			$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));   
		}
		else if($this->input->post('from_date') || $this->input->post('to_date'))
		{
			$this->input->post('from_date')?$from_date=$this->input->post('from_date'):$from_date=$this->input->post('to_date');
			$to_date=$from_date;
		}
	
        if($this->input->post('from_time') && $this->input->post('to_time'))
		{
			$from_time=date("H:i",strtotime($this->input->post('from_time')));
			$to_time=date("H:i",strtotime($this->input->post('to_time')));
				
		}
		else if($this->input->post('from_time') || $this->input->post('to_time'))
		{
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

		if($this->input->post('department')){
			$this->db->where('patient_visit.department_id',$this->input->post('department'));
		}
		if($this->input->post('unit')){
			$this->db->select('IF(unit!="",unit,0) unit',false);
			$this->db->where('patient_visit.unit',$this->input->post('unit'));
		}
		
		if($this->input->post('area')){
			$this->db->select('IF(area!="",area,0) area',false);
			$this->db->where('patient_visit.area',$this->input->post('area'));
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
		
		if ($this->input->post('ndps') != 0){ $this->db->where('patient_followup.ndps', $this->input->post('ndps') == 1 ? 1 : 0); }

		if ($this->input->post('sort_by_age')){ $this->db->order_by('patient.age_years', $this->input->post('sort_by_age') == 1 ? 'ASC' : 'DESC'); }

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
		
		if($this->input->post('priority_type')){
			$this->db->where('patient_followup.priority_type_id',$this->input->post('priority_type'));
		}

		if($this->input->post('volunteer')){
			$this->db->where('patient_followup.volunteer_id',$this->input->post('volunteer'));
		}

		if($this->input->post('route_secondary')){
			$this->db->where('patient_followup.route_secondary_id',$this->input->post('route_secondary'));
		}

		if($this->input->post('district')){
			$this->db->where('patient.district_id',$this->input->post('district'));
		}
		
		if($this->input->post('state')){
			$this->db->where('state.state_id',$this->input->post('state'));
		}
		if($this->input->post('visit_name')){
			$this->db->where('patient_visit.visit_name_id',$this->input->post('visit_name'));
		}
		
		$selected_columns = [];
		$admit_date = "MAX(admit_date)";
		foreach($fields_columns as $fc)
		{
			$selected_columns[] = $fc->table_name.'.'.$fc->field_name;
			if($fc->field_name=="admit_date" && $fc->function=="min")
			{
				$admit_date = "MIN(admit_date)";
			}
		}
		$main_table = $fields_columns[0]->main_table;
		$columns_string = implode(', ', $selected_columns);
		if ($main_table == 'patient_followup') 
		{
			$this->db->select("count(*) as count",false);
		} elseif ($main_table == 'patient_visit') {
			$this->db->select("count(*) as count",false);
		} elseif ($main_table == 'patient') {
			$this->db->select("count(*) as count",false);
		}

		switch ($main_table) 
		{
			case 'patient_followup':
			$this->db->from('patient_followup');
			$this->db->join('patient','patient_followup.patient_id=patient.patient_id','left');
			$this->db->join('priority_type','patient_followup.priority_type_id=priority_type.priority_type_id','left');
			$this->db->join('hospital','patient_followup.hospital_id=hospital.hospital_id','left');
			$this->db->join('icd_code','patient_followup.icd_code=icd_code.icd_code','left');
			$this->db->join('icd_block','icd_code.block_id=icd_block.block_id','left');
			$this->db->join('icd_chapter','icd_block.chapter_id=icd_chapter.chapter_id','left');
			$this->db->where('patient_followup.hospital_id',$hospital['hospital_id']);
			$this->db->join('route_secondary','patient_followup.route_secondary_id=route_secondary.id','left');
			$this->db->join('route_primary','route_secondary.route_primary_id=route_primary.route_primary_id','left');
			$this->db->join('district','patient.district_id=district.district_id','left');
			$this->db->join('state','district.state_id=state.state_id','left');
			$this->db->where("(patient_followup.add_time BETWEEN '$from_date $from_time' AND '$to_date $to_time')");
			if($this->input->post('life_status') == 1 || empty($this->input->post('life_status'))){
				$this->db->where('patient_followup.life_status',1);
					}
			else if($this->input->post('life_status')== 2){
				$this->db->where('patient_followup.life_status',0);
			}
			else if($this->input->post('life_status')== 3){
				$this->db->where('patient_followup.life_status',2);
			}         
			$final = $this->db->get();
			$final_result = $final->result();
			break;
		
			case 'patient_visit':
			$this->db->from('patient_visit');
			$this->db->join('patient','patient_visit.patient_id=patient.patient_id');
			$this->db->join('patient_followup','patient_followup.patient_id=patient.patient_id','left');
			$this->db->join('hospital','patient_visit.hospital_id=hospital.hospital_id','left');
			$this->db->join('department','patient_visit.department_id=department.department_id','left');
			$this->db->join('unit','patient_visit.unit=unit.unit_id','left');
			$this->db->join('area','patient_visit.area=area.area_id','left');
			$this->db->join('icd_code','patient_followup.icd_code=icd_code.icd_code','left');
			$this->db->join('icd_block','icd_code.block_id=icd_block.block_id','left');
			$this->db->join('icd_chapter','icd_block.chapter_id=icd_chapter.chapter_id','left');
			$this->db->join('visit_name','patient_visit.visit_name_id=visit_name.visit_name_id','left');	
			$this->db->where('patient_visit.hospital_id',$hospital['hospital_id']);
			$this->db->where("(patient_visit.admit_date BETWEEN '$from_date' AND '$to_date')");
			$this->db->where("(patient_visit.admit_time BETWEEN '$from_time' AND '$to_time')");
			$this->db->order_by('patient_visit.admit_date','ASC');
			$this->db->order_by('patient_visit.admit_time','ASC');
			if($this->input->post('op_ip')==1 || empty($this->input->post('op_ip')))
			{
				$this->db->where("patient_visit.visit_type","OP");
			}
			else if($this->input->post('op_ip')==2)
			{
				$this->db->where("patient_visit.visit_type","IP");
			}
			$final = $this->db->get();
			$final_result = $final->result();
			break;	

			case 'patient':
			$this->db->from('patient');
			$this->db->join('patient_visit','patient.patient_id=patient_visit.patient_id','left');
			$this->db->join('patient_followup','patient.patient_id=patient_followup.patient_id','left');
			$this->db->join('department','patient_visit.department_id=department.department_id','left');
			$this->db->join('unit','patient_visit.unit=unit.unit_id','left');
			$this->db->join('area','patient_visit.area=area.area_id','left');
			$this->db->join('icd_code','patient_followup.icd_code=icd_code.icd_code','left');
			$this->db->join('icd_block','icd_code.block_id=icd_block.block_id','left');
			$this->db->join('icd_chapter','icd_block.chapter_id=icd_chapter.chapter_id','left');
			$this->db->join('visit_name','patient_visit.visit_name_id=visit_name.visit_name_id','left');	
			$this->db->where('patient_visit.hospital_id',$hospital['hospital_id']);
			$this->db->where("(patient.insert_datetime BETWEEN '$from_date.$from_time' AND '$to_date.$to_time')");
			$final = $this->db->get();
			$final_result = $final->result();
			break;
		}
		
		
		return $final_result;
	}
}
?>
