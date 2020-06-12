<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Staff extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('masters_model');
		$this->load->model('staff_model');
		if($this->session->userdata('logged_in')){
		$userdata=$this->session->userdata('logged_in');
		$user_id=$userdata['user_id'];
		$this->data['hospitals']=$this->staff_model->user_hospital($user_id);
		$this->data['functions']=$this->staff_model->user_function($user_id);
		$this->data['departments']=$this->staff_model->user_department($user_id);
		}
		$this->data['op_forms']=$this->staff_model->get_forms("OP");
		$this->data['ip_forms']=$this->staff_model->get_forms("IP");
	}
	function add($type=""){
        if($this->session->userdata('logged_in'))
		    $this->data['userdata']=$this->session->userdata('logged_in');
        else
            show_404();
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="HR"){
				$access=1;
			}
		}
		if($access==1){
	 	$this->load->helper('form');
		$this->load->library('form_validation');
		$user=$this->session->userdata('logged_in');
		$this->data['user_id']=$user['user_id'];
		switch($type){
			case "staff":
				$title="Add Staff Details";
			
				$config=array(
						array(
						 'field'   => 'first_name',
						 'label'   => 'First Name',
						 'rules'   => 'required|trim|xss_clean'
						),
						array(
						 'field'   => 'gender',
						 'label'   => 'Gender',
						 'rules'   => 'required|trim|xss_clean'
						)
				);
				$this->data['hospital']=$this->masters_model->get_data("hospital");
				$this->data['department']=$this->masters_model->get_data("department");
			
				$this->data['staff_category']=$this->masters_model->get_data("staff_category");
				$this->data['unit']=$this->masters_model->get_data("unit");
				$this->data['area']=$this->masters_model->get_data("area");
				
				$this->data['staff_role']=$this->masters_model->get_data("staff_role");
				break;
			case "staff_role":
				$title="Add Staff Role";
			
				$config=array(
						array(
						 'field'   => 'staff_role',
						 'label'   => 'Staff Role',
						 'rules'   => 'required|trim|xss_clean'
						)
				);
				break;
			case "staff_category":
				$title="Add Staff Category";
			
				$config=array(
						array(
						 'field'   => 'staff_category',
						 'label'   => 'Staff Category',
						 'rules'   => 'required|trim|xss_clean'
						)
				);
				break;
			default: show_404();	
		}
		$page="pages/staff/add_".$type."_form";
		$this->data['title']=$title;
		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/leftnav');
		$this->form_validation->set_rules($config);
 		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view($page,$this->data);
		}
		else{
				if(($this->input->post('submit'))||($this->masters_model->insert_data($type))){
					$this->data['msg']=" Inserted  Successfully";
					$this->load->view($page,$this->data);
				}
					else if ($this->input->post('file_upload')) {
				//file upload destination
				$dir_path = './assets/images/staff/';
				$config['upload_path'] = $dir_path;
				$config['allowed_types'] = '*';
				$config['max_size'] = '0';
				$config['max_filename'] = '255';
				$config['encrypt_name'] = TRUE;
	 
				//upload file
				$i = 0;
				$files = array();
				$is_file_error = FALSE;
	 
				if ($_FILES['upload_file1']['size'] <= 0) {
					$this->handle_error('Select at least one file.');
				} else {
					foreach ($_FILES as $key => $value) {
						if (!empty($value['name'])) {
							$this->load->library('upload', $config);
							if (!$this->upload->do_upload($key)) {
								$this->handle_error($this->upload->display_errors());
								$is_file_error = TRUE;
							} else {
								$files[$i] = $this->upload->data();
								++$i;
							}
						}
					}
				}
	 
				// There were errors, we have to delete the uploaded files
				if ($is_file_error && $files) {
					for ($i = 0; $i < count($files); $i++) {
						$file = $dir_path . $files[$i]['file_name'];
						if (file_exists($file)) {
							unlink($file);
						}
					}
				}
	 
				if (!$is_file_error && $files) {
					$resp = $this->file->save_files_info($files);
					if ($resp === TRUE) {
						$this->data['msg']="<div class='alert alert-danger'>File(s) was/were successfully uploaded..</div>";	
						
					  
					} else {
						for ($i = 0; $i < count($files); $i++) {
							$file = $dir_path . $files[$i]['file_name'];
							if (file_exists($file)) {
								unlink($file);
							}
						}
						$this->data['msg']="<div class='alert alert-danger'>Error while saving file info to Database.</div>";
							
					   
					}
				}
				$this->load->view('pages/create_slots',$this->data);
			}
				
				else{
					$this->data['msg']="Failed";
					$this->load->view($page,$this->data);
				}
				
		}
			
		$this->load->view('templates/footer');
        }else{
            show_404();
        }
  	}	
  	
	function edit($type=""){
        if($this->session->userdata('logged_in'))
		    $this->data['userdata']=$this->session->userdata('logged_in');
        else
            show_404();
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="HR"){
				$access=1;
			}
		}
		if($access==1){
	 	$this->load->helper('form');
		$this->load->library('form_validation');
		$user=$this->session->userdata('logged_in');
		$this->data['user_id']=$user['user_id'];
		$this->data['type']=$type;
		
		if($type=="staff"){
			$title="Edit Staff";
			$config=array(
               array(
                     'field'   => 'staff',
                     'label'   => 'Staff',
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'description',
                     'label'   => 'Description',
                     'rules'   => 'trim|xss_clean'
                  )
		
			);
			$this->data['department']=$this->masters_model->get_data("department");
			$this->data['unit']=$this->masters_model->get_data("unit");
			$this->data['area']=$this->masters_model->get_data("area");
		//	$this->data['staff_category']=$this->masters_model->get_data("staff_category",$mode='all');
			$this->data['staff_role']=$this->masters_model->get_data("staff_role",$mode='all');
			$this->data['staff']=$this->masters_model->get_data('view_staff');
			$this->data['designation']=$this->masters_model->get_designation();
			$this->data['staff_category']=$this->masters_model->get_data("staff_category");
				
		}		
		else if($type == 'staff_role')
		{
			$title = 'Edit Staff Role';
			$config = array(
				array(
						 'field'   => 'staff_role',
						 'label'   => 'Staff Role',
						 'rules'   => 'trim|xss_clean'
				)
			);
			$this->data['staff_role'] = $this->masters_model->get_data('staff_role');			
		}
		else if($type == 'staff_category')
		{
			$title = 'Edit Staff Category';
			//form configuration for staff_category
			$config = array(
				array(
						 'field'   => 'staff_category',
						 'label'   => 'Staff Category',
						 'rules'   => 'trim|xss_clean'
						)
			);
			
		}        
		// if none of the options is selected (i.e. any invalid url modifications) 404 error is shown
		else
		{
			show_404();
		}
		
		$page="pages/staff/edit_".$type."_form";
		$this->data['title']=$title;
		$this->load->view('templates/header',$this->data);
      	$this->load->view('templates/leftnav',$this->data);
		//form configuration is set based on the option selected from the menu
		$this->form_validation->set_rules($config);
		//if the form contains any invalid data same page along with error msg is shown.
		if ($this->form_validation->run() === FALSE)
		{
			$this->data['mode'] = 'mode';
			$this->load->view($page,$this->data);
		}
		//if form does not contain any errors
		else
		{
			//there are 3 steps for updating
			// 1. User searches for the record to be updated.
			//    1.1 User can directly press search button without entering any data.
			// 2. User selects the required record.
			// 3. User enter some data and updates the record.
			
			// step 1. 
			if($this->input->post('search') || $this->input->post('search_staff'))
			{
				//search results are retrieved from the master_model class
				$this->data['mode'] = 'search';
				$this->data[$type]=$this->masters_model->get_data($type);				
				$this->load->view($page,$this->data);
			}
			// step 2.
			else if($this->input->post('select'))
			{
				//selected record's id is taken from  input in master_model
				//all the fields are retrieved and sent to the view
				$this->data['mode'] = 'select';
			   	$this->data[$type]=$this->masters_model->get_data($type);
         		$this->load->view($page,$this->data);
			}
			
			//step 3.
			else if($this->input->post('update'))
			{
				//Data from the input fields are retrieved from view and updates into database
				
				if($this->masters_model->update_data($type))
				{
					$this->data['msg']="Updated Successfully";
					$this->data['mode'] = 'update';
					$this->data[$type]=$this->masters_model->get_data($type);
					$this->load->view($page,$this->data);
				}
				//if any failures occurs Failed msg is shown
				else
				{
					$this->data['msg']="Failed";
					$this->load->view($page,$this->data);
				}
			}
		}
		
		$this->load->view('templates/footer');}
        else{
            show_404();
        }
	}
     
	function view($type=""){
        if($this->session->userdata('logged_in'))
		    $this->data['userdata']=$this->session->userdata('logged_in');
        else
            show_404();
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="HR"){
				$access=1;
			}
		}
		if($access==1){
	 	$this->load->helper('form');
		$this->load->library('form_validation');
		$user=$this->session->userdata('logged_in');
		$this->data['user_id']=$user['user_id'];
		$this->data['type']=$type;
		if($type=="view_staff"){
			$title="View Staff";
			$config=array(
               array(
                     'field'   => 'staff',
                     'label'   => 'Staff',
                     'rules'   => 'trim|xss_clean'
                  ),
               array(
                     'field'   => 'description',
                     'label'   => 'Description',
                     'rules'   => 'trim|xss_clean'
                  )
		
			);
			$this->data['department']=$this->masters_model->get_data("department");
			$this->data['unit']=$this->masters_model->get_data("unit");
			$this->data['area']=$this->masters_model->get_data("area");
			$this->data['staff_category']=$this->masters_model->get_data("staff_category",$mode='all');
			$this->data['staff_role']=$this->masters_model->get_data("staff_role",$mode='all');
			$this->data['designation']=$this->masters_model->get_designation();
			$this->data['staff_category']=$this->masters_model->get_data("staff_category");
			$this->data['transaction'] = $this->masters_model->get_transactions();
		}
		// if none of the options is selected (i.e. any invalid url modifications) 404 error is shown
		else
		{
			show_404();
		}
		
		$page="pages/staff/".$type."_form";
		$this->data['title']=$title;
		$this->load->view('templates/header',$this->data);
      	$this->load->view('templates/leftnav',$this->data);
		//form configuration is set based on the option selected from the menu
		$this->form_validation->set_rules($config);
		//if the form contains any invalid data same page along with error msg is shown.
		if ($this->form_validation->run() === FALSE)
		{
			$this->data['mode'] = 'mode';
			$this->load->view($page,$this->data);
		}
		//if form does not contain any errors
		else
		{
			//there are 3 steps for updating
			// 1. User searches for the record to be updated.
			//    1.1 User can directly press search button without entering any data.
			// 2. User selects the required record.
			// 3. User enter some data and updates the record.
			
			// step 1. 
			if($this->input->post('search') || $this->input->post('search_staff'))
			{
				//search results are retrieved from the master_model class
				$this->data['mode'] = 'search';
				$this->data[$type]=$this->masters_model->get_data($type);
				
				$this->load->view($page,$this->data);
			}
			// step 2.
			else if($this->input->post('select'))
			{
				//selected record's id is taken from  input in master_model
				//all the fields are retrieved and sent to the view
				$this->data['mode'] = 'select';
			   	$this->data[$type]=$this->masters_model->get_data($type);
         		$this->load->view($page,$this->data);
			}
			
			//step 3.
			else if($this->input->post('update'))
			{
				//Data from the input fields are retrieved from view and updates into database
				
				if($this->masters_model->update_data($type))
				{
					$this->data['msg']="Updated Successfully";
					$this->data['mode'] = 'update';
					$this->load->view($page,$this->data);
				}
				//if any failures occurs Failed msg is shown
				else
				{
					$this->data['msg']="Failed";
					$this->load->view($page,$this->data);
				}
			}
		}
		}
	}
    function add_transaction(){
        if($this->session->userdata('logged_in'))
		    $this->data['userdata']=$this->session->userdata('logged_in');
        else
            show_404();
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="HR"){
				$access=1;
			}
		}
		if($access==1){
        $this->load->helper('form');
		$this->load->library('form_validation');
		$user=$this->session->userdata('logged_in');
		$this->data['user_id']=$user['user_id'];
		$this->data['type']='staff_transaction';
        $title = 'Edit Transaction Category';
        $type = 'staff_transaction';
        $config = array(
            array(
                'field' => 'staff_id',
                'label' => 'Staff Name',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'hr_transaction_type_id',
                'label' => 'Transaction type',
                'rules' => 'trim|xss_clean'
            )   
         );
         $this->data['hr_transaction_types'] = $this->masters_model->get_transaction_type();

        $page="pages/staff/add_".$type."_form";
		$this->data['title']=$title;
		$this->load->view('templates/header',$this->data);
      	$this->load->view('templates/leftnav',$this->data);
		//form configuration is set based on the option selected from the menu
		$this->form_validation->set_rules($config);

		//if the form contains any invalid data same page along with error msg is shown.
		if ($this->form_validation->run() === FALSE)
		{
			$this->data['mode'] = 'mode';
			$this->load->view($page,$this->data);
		}
        else
		{
		    //Data from the input fields are retrieved from view and updates into database
			if($this->staff_model->add_data('transaction_type'))
			{
			    $this->data['msg']="Updated Successfully";
				$this->data['mode'] = 'update';
				$this->load->view($page,$this->data);
			}
			//if any failures occurs Failed msg is shown
			else
			{
				$this->data['msg']="Failed";
				$this->load->view($page,$this->data);
			}
		}}else{
		    show_404();
		}
    }

    function search_staff(){
        if($this->session->userdata('logged_in'))
		    $this->data['userdata']=$this->session->userdata('logged_in');
        else
            show_404();
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="HR"){
				$access=1;
			}
		}
		if($access==1){
	    if($doctors = $this->staff_model->search_staff()){
		    $list=array(
			    'doctors'=>$doctors
		    );		
			echo json_encode($list);
	    }
	    else return false;}else{
	        show_404();
	    }
    }
	   function search_doctor(){
        if($this->session->userdata('logged_in'))
		    $this->data['userdata']=$this->session->userdata('logged_in');
        else
            show_404();
		$access=0;
		if($doctors = $this->staff_model->search_doctor()){
			$list=array(
				'doctors'=>$doctors
			);		
			echo json_encode($list);
		}
		else 
			return false;
    }
      function search_hospital(){
        if($this->session->userdata('logged_in'))
		    $this->data['userdata']=$this->session->userdata('logged_in');
        else
            show_404();
		$access=0;
		if($hospital = $this->staff_model->search_hospital()){
			$list=array(
				'hospital'=>$hospital
			);		
			echo json_encode($list);
		}
		else 
			return false;
    }
	
	function summary(){
        if($this->session->userdata('logged_in'))
		    $this->data['userdata']=$this->session->userdata('logged_in');
        else
            show_404();
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="HR"){
				$access=1;
			}
		}
		if($access==1){
        $this->load->helper('form');
		$this->load->library('form_validation');
		$user=$this->session->userdata('logged_in');
		$this->data['user_id']=$user['user_id'];
        $title = 'View Staff Summary';
		$this->data['title']=$title;
		$this->load->view('templates/header',$this->data);
      	$this->load->view('templates/leftnav',$this->data);
		$this->data['summary']=$this->staff_model->get_staff_summary();
		$this->data['department']=$this->masters_model->get_data("department");
		$this->data['staff_category']=$this->masters_model->get_data("staff_category");
		$this->data['unit']=$this->masters_model->get_data("unit");
		$this->data['area']=$this->masters_model->get_data("area");
		$this->data['designation']=$this->masters_model->get_designation();
		//form configuration is set based on the option selected from the menu

		//if the form contains any invalid data same page along with error msg is shown.
			if ($this->form_validation->run() === FALSE)
			{
				$this->load->view('pages/staff/staff_summary',$this->data);
			}
			else
			{
				//Data from the input fields are retrieved from view and updates into database
				if($this->staff_model->add_data('transaction_type'))
				{
					$this->data['msg']="Updated Successfully";
					$this->data['mode'] = 'update';
					$this->load->view($page,$this->data);
				}
				//if any failures occurs Failed msg is shown
				else
				{
					$this->data['msg']="Failed";
					$this->load->view($page,$this->data);
				}
			}
		}else{
		    show_404();
		}
		
	}
	
	
}