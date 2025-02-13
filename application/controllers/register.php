<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// OP and IP registration forms.
class Register extends CI_Controller {
	private function transaction_condition() {
		// Check for transaction ID if none found set one in session, always overrides
		// If transaction ID found remove that transaction, add a new transaction
		// If transaction ID not found do nothing
		$transaction_condition = false;
		if($this->input->post('transaction_id')) {
			$session_data = $this->session->all_userdata();
			$tran_key = 'transaction_key_';
			$tran_key .= $this->input->post('transaction_id');
			if(array_key_exists($tran_key, $session_data)){
				$transaction_value = $session_data[$tran_key];
				$transaction_condition = true;
				$next_transaction = $transaction_value + 1;
				$this->data['transaction_id'] = $next_transaction;
				$transaction_key = 'transaction_key_'.$next_transaction;
				unset($session_data[$tran_key]);
				$session_data[$transaction_key] = $next_transaction;
				$this->session->sess_destroy();
				$this->session->set_userdata($session_data);
			} else {
				$transaction_condition = false;
			}
		}else {
			$transaction_condition = false;
			$this->data['transaction_id'] = 1;
			$transaction = 1;
			$transaction_key = 'transaction_key_'.$transaction;			
			$this->session->set_userdata($transaction_key, $transaction);
		}
		return $transaction_condition;
	}
	function __construct(){
		//Constructor loads the required models for this controller
		//Based on the user_id we get the hospitals,functions and departments the user has access to.
		parent::__construct();
		if($this->session->userdata('logged_in')){
			$userdata=$this->session->userdata('logged_in');
			$this->load->model('register_model');
			$this->load->model('staff_model');
			$this->load->model('masters_model');
			$this->load->model('hospital_model');
			$this->load->model('patient_model');
			$this->load->model('counter_model');
			$this->load->model('gen_rep_model');
			$this->load->model('helpline_model');
			$this->load->model('patient_document_upload_model');
			$user_id = $userdata['user_id'];
			$this->data['hospitals'] = $this->staff_model->user_hospital($user_id);
			$this->data['functions'] = $this->staff_model->user_function($user_id);
			$this->data['departments'] = $this->staff_model->user_department($user_id);
			//The OP and IP forms in the application are loaded into a data variable for the menu.
			$this->data['op_forms'] = $this->staff_model->get_forms("OP");
			$this->data['ip_forms'] = $this->staff_model->get_forms("IP");
			$this->data['custom_patient_visit_form'] = $this->masters_model->get_cust_patient_visit_forms();
		}
	}
	//sairam
	//custom_form() accepts a form ID to display the selected form (OP or IP) 
	//and also an optional visit_id when a patient is selected.
	public function custom_form($form_id="",$visit_id=0)
	{
		if(!$this->session->userdata('logged_in')){
			show_404();
		}
		//Loading the form helper
		$this->load->helper('form');
		
		if($this->session->userdata('hospital')){ //If the user has selected a hospital after log-in.
			if($form_id=="") //Form ID cannot be null, if so show a 404 error.
				show_404();
			else{	
			$access=0;
			$add_sms_access=0;
			$this->data['staff_hospital'] = $hospital = $this->session->userdata('hospital');
			foreach($this->data['functions'] as $f){ 
				if(($f->user_function=="Out Patient Registration" || $f->user_function == "IP Registration")){
					$access = 1;
				}
				if($f->user_function=="sms"){
                		if ($f->add==1 && $this->data['staff_hospital']["helpline"] && $this->data['staff_hospital']["helpline"]!="" && !empty($this->data['staff_hospital']["helpline"])) $add_sms_access=1;
            		}
			}
			if($access==1){
			$transaction = $this->transaction_condition();
			//Load data required for the select options in views.
			$user=$this->session->userdata('logged_in');
			$this->data['user_id']=$user['user_id'];
			$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
			$this->data['id_proof_types']=$this->staff_model->get_id_proof_type();
			$this->data['occupations']=$this->staff_model->get_occupations();
			$this->data['departments']=$this->staff_model->get_department();
			$this->data['helpline_hospitals']=$this->hospital_model->get_hospitals_selectize(true);
			$this->data['all_departments']=$this->data['departments'];
			$this->data['units']=$this->staff_model->get_unit();
			$this->data['areas']=$this->staff_model->get_area();
			$this->data['districts']=$this->staff_model->get_district();
			$this->data['sms_templates']=$this->helpline_model->get_sms_template();
			$this->data['countries']=$this->masters_model->get_data('country_codes');
			$this->data['states_codes']=$this->masters_model->get_data('state_codes');
			$this->data['userdata']=$this->session->userdata('logged_in');//Load the session data into a variable to use in headers and models.
			$this->data['title']="Patient Registration"; //Set the page title to be used by the header.
			$this->data['form_id']=$form_id; //Store the form_id in a variable to access in the views.
			$this->data['fields']=$this->staff_model->get_form_fields($form_id); //Get the form fields based on the form_id
			$user_receiver = $this->helpline_model->getHelplineReceiverByUserId($this->data['user_id']);
			$user_receiver_links = array();
			if($user_receiver){
				$user_receiver_links = $this->helpline_model->getHelplineReceiverLinksById($user_receiver->receiver_id);
			}
			$this->data['user_details']=json_encode(array(
				'receiver' => $user_receiver,
				'receiver_link' => $user_receiver_links
			)); 
			if(count($this->data['fields'])==0){ //if there are no form fields available in the selected form.
				show_404();
			}
			$form=$this->staff_model->get_form($form_id); //Get the form details from database.
			if($form->form_type=="OP")
			{	
				$this->data['visit_names']=$this->staff_model->get_visit_name_op();
			}else if($form->form_type=="IP"){
				$this->data['visit_names']=$this->staff_model->get_visit_name_ip();
			}else{
				$this->data['visit_names']=$this->staff_model->get_visit_name();
			}
			$form_a6=$this->staff_model->get_form_a6($form_id); 
			$this->data['columns']=$form->num_columns;
			$this->data['form_name']=$form->form_name;
			$this->data['form_type']=$form->form_type;
			$this->data['patient']=array();
			$this->data['update']=0;
			$this->data['add_sms_access']=$add_sms_access;
			$print_layout_page=$form->print_layout_page;
			$print_layout_a6=$form_a6->print_layout_page;
			$this->load->view('templates/header',$this->data);
			$this->load->library('form_validation');
			//Set validation rules for the forms
			$this->form_validation->set_rules('form_type','Form Type','trim|xss_clean');
			if ($this->form_validation->run() === FALSE)
			{
				//if the form validation fails, or the form has not been submitted yet
				
				$this->load->view('pages/custom_form',$this->data); //Load the view custom_form
			}
			else{
				if($this->input->post('search_patients')){
					//if the user searches for a patient, get the list of patients that matched the query.
					$this->data['patients']=$this->register_model->search();
					
					//get auto ip number from hospital table - 194214
					$this->data['autoIP']=$this->register_model->get_auto_ip($hospital['hospital_id']);
					
					
					//AutoIP check here - 194214
					if($this->data['autoIP'] == 1)
					{
						$this->data['counter_needed'] = $this->register_model->create_ip_counter($hospital['hospital_id']);
						$this->data['ip_no'] = $this->register_model->assignIP($this->data['patients'][0]->patient_id, $hospital['hospital_id']);
					}
					
					if($this->data['form_type']=="OP") {
                        			$this->data['ip_count'] = $this->counter_model->get_counters("IP");
						if($this->data['patient']->visit_type == "IP") {
                            				$this->data['update']=1;                                                    
                        			}
					}
				}
				else if($this->input->post('select_patient')){
					// for a selected patient - in case of multiple entries - 194214
					$c = $this->input->post('select_patient');

					$this->data['autoIP']=$this->register_model->get_auto_ip($hospital['hospital_id']);

					if($this->data['autoIP'] == 1)
					{

						$this->data['counter_needed'] = $this->register_model->create_ip_counter($hospital['hospital_id']);
						
						$this->data['ip_no'] = $this->register_model->assignIP($c, $hospital['hospital_id']);

					} 
					
					//else if the user has selected a patient after searching, get the patient details.
					$this->data['patient']=$this->register_model->select_patient_from_id($c);
					//$this->data['patient'] = $this->data['patient'][0];
					//echo("<script>console.log('".json_encode($this->data['patient'])."');</script>");
                                         $this->data['ip_count'] = $this->counter_model->get_counters("IP");
					if($this->input->post('visit_type')=="IP"){
						//If the selected visit type is IP, the form only updates the values, else it inserts by default.
						$this->data['update']=1;
					}
				}
				else if($this->input->post('register') && $transaction){
					// if the register button has been clicked, invoke the register function in register_model.
					// Get the inserted patient details from the function and store it in a variable to display
					// in the views.
					
					$this->data['registered']=$this->register_model->register(); 
					if(is_int($this->data['registered']) && $this->data['registered']==2){
						//If register function returns value 2 then we are setting a duplicate ip no error.
						$this->data['duplicate']=1;
					}					
					//Set the print layout page based on the form selected.
					$this->data['print_layout']="pages/print_layouts/$print_layout_page";
					$this->data['print_layout_a6']="pages/print_layouts/$print_layout_a6";
				}
				//load the custom_form page with the data loaded.
				$this->load->view('pages/custom_form',$this->data);
			}
				//Load the footer.
				$this->load->view('templates/footer');
			}
			else {
				$this->data['title']="Patient Registration"; //Set the page title to be used by the header.
				$this->load->view('templates/header',$this->data);
				$this->load->view('pages/error_access');
				$this->load->view('templates/footer');
			}
			}
		}
		else{
			//else if the user hasn't selected a hospital yet, redirect to home page for selection.
			redirect('home','refresh');
		}
		
	}// custom_form
	
	function get_states() {
		$result = json_encode($this->masters_model->get_data('state_codes'));
		print $result;
	}// get_states;
	
	function get_districts() {
		$result = json_encode($this->staff_model->get_district_codes());
		print $result;
	}// get_districts

	function view_patients(){
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="View Patients"){
				$access=1;
				break;
			}
		}
		if($access==1){
		$this->data['title']="View Patients";
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->form_validation->set_rules('patient_number', 'IP/OP Number',
		'trim|xss_clean');
		$this->data['drugs_available'] = $this->hospital_model->get_drugs();
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('pages/view_patients',$this->data);
		}
		else{
			$this->data['patients']=$this->register_model->search();
			if(count($this->data['patients'])==1){
				$this->load->model('diagnostics_model');
				$visit_id = $this->data['patients'][0]->visit_id;
				$patient_id = $this->data['patients']['0']->patient_id;
				$this->data['prescription']=$this->register_model->get_prescription($visit_id);
				$this->data['previous_visits']=$this->register_model->get_visits($patient_id);
				$this->data['tests']=$this->diagnostics_model->get_all_tests($visit_id);
				$this->data['visit_notes']=$this->register_model->get_clinical_notes($visit_id);
				$params = array("patient_visit.patient_id"=>$patient_id);
				$this->data['patient_visits'] = $this->gen_rep_model->simple_join('patient_visits_all', false, $params);
				$this->data['clinical_notes'] = $this->gen_rep_model->simple_join('clinical_notes', false, $params);
				$this->data['all_tests'] = $this->gen_rep_model->simple_join('tests_ordered', false, $params);
				$this->data['prescriptions'] = $this->gen_rep_model->simple_join('prescriptions', false, $params);			
			}
			$this->load->view('pages/view_patients',$this->data);
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
	}
	
	function generate_summary_link(){
	
		if($this->session->userdata('logged_in')){
			$this->data['userdata']=$this->session->userdata('logged_in');
			
			$access=0;
			$patient_document_add_access=0;
			$patient_document_remove_access=0;
			foreach($this->data['functions'] as $function){
				if($function->user_function=="Update Patients"){
					$access=1;
					break;
				}
			}
			if($access==1){
				$downloadurl = $this->input->post('summary_download_link');				
				$key = $this->register_model->insert_update_summary_link($this->input->post('summary_link_patient_id'),$this->input->post('summary_link_patient_visit_id'),$this->input->post('summary_link_contents'));
				$result=$this->register_model->get_patient_visit_details($this->input->post('summary_link_patient_id'),$this->input->post('summary_link_patient_visit_id'));
				$val = $result[0];
				//echo("<script>console.log('PHP: " . json_encode($this->data['result']) . "');</script>");
				$basetemplate = $this->input->post('summary_link_sms');
				$basetemplate = str_replace("{#patient_name#}",$val->name, $basetemplate);			
				$basetemplate = str_replace("{#patient_id#}",$val->patient_id, $basetemplate);
				$basetemplate = str_replace("{#op_number#}",$val->hosp_file_no, $basetemplate);		
				$basetemplate = str_replace("{#hospital#}",$val->hospital_short_name, $basetemplate);
				$basetemplate = str_replace("{#helpline_number#}",$val->helpline, $basetemplate);
				$basetemplate = str_replace("{#map_link#}",$val->map_link, $basetemplate);
				$basetemplate = str_replace("{#download_link#}",$downloadurl.$key, $basetemplate);
				$basetemplate = str_replace("{#keyvariable#}",$key, $basetemplate);
				$basetemplate = str_replace("{#visit_name#}",$val->visit_name, $basetemplate);
				if ($val->signed=="0"){
					$basetemplate = str_replace("{#doctor_name#}","Doctor", $basetemplate);
					$convertedDate = date("j-M-Y", strtotime($val->admit_date));
					$convertedTime = date("h:i A", strtotime($val->admit_time));
					$basetemplate = str_replace("{#appointment_date#}",$convertedDate." ".$convertedTime, $basetemplate);
				}else{
					$basetemplate = str_replace("{#doctor_name#}",$val->doctor, $basetemplate);
					$convertedDateAndTime = date("j-M-Y h:i A", strtotime($val->appointment_date_time));
					$basetemplate = str_replace("{#appointment_date#}",$convertedDateAndTime, $basetemplate);
				}
				echo $basetemplate;
			}		
		}
	}
	
	function generate_appointment_sms(){
	
		if($this->session->userdata('logged_in')){
			$this->data['userdata']=$this->session->userdata('logged_in');
			
			$access=0;
			foreach($this->data['functions'] as $function){
				if($function->user_function=="Update Patients"){
					$access=1;
					break;
				}
			}
			if($access==1){
				$result=$this->register_model->get_patient_visit_details($this->input->post('patient_id'),$this->input->post('visit_id'));
				$val = $result[0];
				$basetemplate = $this->input->post('template');
				$basetemplate = str_replace("{#patient_name#}",$val->name." ", $basetemplate);
				$basetemplate = str_replace("{#hospital#}",$val->hospital_short_name." ", $basetemplate);
				$basetemplate = str_replace("{#helpline_number#}",$val->helpline." ", $basetemplate);
				$basetemplate = str_replace("{#department#}",$val->department." ", $basetemplate);
				$convertedDateAndTime = date("j-M-Y h:i A", strtotime($val->appointment_date_time));
				$basetemplate = str_replace("{#appointment_date#}",$convertedDateAndTime." ", $basetemplate);
				$basetemplate = str_replace("{#op_number#}",$val->hosp_file_no." ", $basetemplate);
				$basetemplate = str_replace("{#visit_name#}",$val->visit_name." ", $basetemplate);
				$basetemplate = str_replace("{#map_link#}",$val->map_link." ", $basetemplate);
				header('Content-type: application/json');
				$result=array();  
            			$result['sms_content'] = $basetemplate; 
				echo(json_encode($result));
			}		
		}
	}
	
	
	function notify_summary_download(){
		$this->load->model('register_model');
		$this->load->helper('form');
		$this->register_model->notify_summary_download();
	}
	function generate_doc_upload_link(){
		if($this->session->userdata('logged_in')){
			$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
			foreach($this->data['defaultsConfigs'] as $default){
				if ($default->default_id == "patient_doc_link_expiry"){
               			$patient_doc_link_expiry = $default->value;
            			}
			}
			$downloadurl = $this->input->post('report_download_url');
			$key = $this->register_model->insert_update_patient_document_upload_key($this->input->post('patient_id'),$this->input->post('visit_id'),(int)$patient_doc_link_expiry);
			$result=$this->register_model->get_patient_visit_details($this->input->post('patient_id'),$this->input->post('visit_id'));
			$val = $result[0];
			$basetemplate = $this->input->post('template');
			$basetemplate = str_replace("{#patient_name#}",$val->name, $basetemplate);	
			$basetemplate = str_replace("{#patient_id#}","ID ".$val->patient_id, $basetemplate);			
			$basetemplate = str_replace("{#hospital#}",$val->hospital_short_name, $basetemplate);
			$basetemplate = str_replace("{#helpline_number#}",$val->helpline, $basetemplate);
			$basetemplate = str_replace("{#op_number#}",$val->hosp_file_no, $basetemplate);
			$basetemplate = str_replace("{#map_link#}",$val->map_link, $basetemplate);
			$basetemplate = str_replace("{#visit_name#}",$val->visit_name, $basetemplate);
			$basetemplate = str_replace("{#upload_link#}",$downloadurl.$key, $basetemplate);
			header('Content-type: application/json');
			$result=array();  
            		$result['sms_content'] = $basetemplate; 
			echo(json_encode($result));
		}
		
		//echo("<script>console.log('PHP: " .$this->input->post('visit_id') . "');</script>");
		
	}
	function get_summary(){
		if (isset($_GET['key']) && $_GET['key']!=""){				
			$this->load->model('register_model');
			$this->load->helper('form');
			$this->data['title']="Consultation Summary";
			$this->data['result']=$this->register_model->get_summary($_GET['key']);
			
		} else {
			$this->data['result'] = [] ;
		}	
		
		if (empty($this->data['result'])){	
			$this->load->view('templates/invalid_page');
		} else {
			$this->load->view('pages/print_layouts/download_summary',$this->data);
		} 
	}
	
	function deleting_documents(){
	if($this->input->post('patient_id') && $this->input->post('patient_id')!="" && $this->input->post('document_link') && $this->input->post('document_link')!=""){ 
		$this->load->model('patient_document_upload_model');
		$this->load->model('masters_model');
		$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
		foreach($this->data['defaultsConfigs'] as $default){
          
            		if ($default->default_id == "pdoc_remove_spaces"){
                		$remove_spaces = $default->value;
            		}
               }
		$patient_id = $this->input->post('patient_id');
		$deleteOk=0;
		$document_link = $this->input->post('document_link');
		if ($remove_spaces == "TRUE"){
			$document_link = str_replace(' ', '_', $document_link);
			
		}
		$document_link = str_replace('<', '_', $document_link);
		$document_link = str_replace('>', '_', $document_link);
		$document_link = str_replace('%', '_', $document_link);
		$document_link = str_replace('#', '_', $document_link);
		$document_link = str_replace('+', '_', $document_link);
		$document_link = str_replace('(', '_', $document_link);
		$document_link = str_replace(')', '_', $document_link);	
		$document_link =  $patient_id."_".$document_link;
		if (($this->patient_document_upload_model->delete_document($patient_id, $document_link)) > 0) {
					$this->delete_document($document_link);
					$deleteOk=1;
				}
				
		}
		if ($deleteOk==1){               
        	header('Content-Type: application/json; charset=UTF-8');
            	header('HTTP/1.1 200 OK');  
            	$result=array();  
            	$result['globalImageIndex'] = $this->input->post('globalImageIndex'); 
            	echo(json_encode($result));
            }
            else{
            	header('Content-Type: application/json; charset=UTF-8');
            	header('HTTP/1.1 500 Internal Server Error');    
            	$result=array();   
            	$result['msg']='Failed';
        	$result['globalImageIndex'] = $this->input->post('globalImageIndex');        
        	echo(json_encode($result));
            }
	}
	function uploading_docs(){
	$this->load->helper('form');
	$this->load->model('masters_model');
	$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
	foreach($this->data['defaultsConfigs'] as $default){
            if ($default->default_id == "pdoc_allowed_types"){
               $allowed_types = $default->value;
            }
            if ($default->default_id == "pdoc_max_size"){
                $max_size = $default->value;
            }
            if ($default->default_id == "pdoc_max_width"){
                $max_width = $default->value;
            }
            if ($default->default_id == "pdoc_max_height"){
                $max_height = $default->value;
            }
            if ($default->default_id == "pdoc_remove_spaces"){
                $remove_spaces = $default->value;
            }
            if ($default->default_id == "pdoc_overwrite"){
                $overwrite = $default->value;
            }                                   
        }
	$files = $_FILES;
	$i = $this->input->post('imageIndex');
	if (count($files["uploadImageFile"]["name"])>0) {
		 set_time_limit(0);
                $dir_path = './assets/patient_documents/';
                $config['upload_path'] = $dir_path;
                $config['allowed_types'] = $allowed_types;
                $config['max_size'] = $max_size;
                $config['max_width'] = $max_width;
                $config['max_height'] = $max_height;
                $config['encrypt_name'] = FALSE;
                $config['overwrite'] = $overwrite;
                $config['remove_spaces'] = $remove_spaces;
 
                // Upload file and add document record
                $msg = "Error: ";
                $uploadOk = 1;
                $target_file = basename($files["uploadImageFile"]["name"][$i]);
                if ($remove_spaces == "TRUE"){
			$target_file = str_replace(' ', '_', $target_file);
			
		}
		$target_file = str_replace('<', '_', $target_file);
		$target_file = str_replace('>', '_', $target_file);
		$target_file = str_replace('%', '_', $target_file);
		$target_file = str_replace('#', '_', $target_file);
		$target_file = str_replace('+', '_', $target_file);
		$target_file = str_replace('(', '_', $target_file);
		$target_file = str_replace(')', '_', $target_file);
		$originalFile = $target_file;	
		$target_file = $dir_path . basename($files["uploadImageFile"]["name"][$i]);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                if ($files['uploadImageFile']['size'][$i] <= 0 && $uploadOk == 1) {
                    $msg = $msg . "Select at least one file.";
                    $uploadOk = 0;
				}


                // Check for upload errors
                if ($uploadOk == 0) {
                    $msg = $msg . " Your file was not uploaded.";
                }
                else {
				    // if everything is ok, try to upload file
				    $new_name = $this->input->post('patient_id').'_'.$originalFile;
				    
                    //$config['file_name'] = $new_name;
                    $this->load->library('upload', $config);
                    $_FILES['uploadImageFile']['name']= $new_name;
        	     $_FILES['uploadImageFile']['type']= $files['uploadImageFile']['type'][$i];
        	     $_FILES['uploadImageFile']['tmp_name']= $files['uploadImageFile']['tmp_name'][$i];
                    $_FILES['uploadImageFile']['error']= $files['uploadImageFile']['error'][$i];
                    $_FILES['uploadImageFile']['size']= $files['uploadImageFile']['size'][$i]; 
                    if (!$this->upload->do_upload('uploadImageFile')) {
                        $msg = $msg . $this->upload->display_errors();
                        $uploadOk = 0;
                    } else {
                        $file = $this->upload->data();
                        $uploadOk = 1;
                        $this->load->model('patient_document_upload_model');
                        $this->patient_document_upload_model->add_document($this->input->post('patient_id'), $file['file_name']);
                    }
                    
                }
            }

            if ($uploadOk==1){               
        	header('Content-Type: application/json; charset=UTF-8');
            	header('HTTP/1.1 200 OK');  
            	$result=array();  
            	$result['globalImageIndex'] = $this->input->post('globalImageIndex'); 
            	echo(json_encode($result));
            }
            else{
            	header('Content-Type: application/json; charset=UTF-8');
            	header('HTTP/1.1 500 Internal Server Error');    
            	$result=array();    	
        	$result['messages'] = $msg;
        	$result['globalImageIndex'] = $this->input->post('globalImageIndex');        
        	echo(json_encode($result));
            }
        }
	
	
	function document_upload(){
	
	if (isset($_GET['key']) && $_GET['key']!=""){	
			$this->load->helper('form');			
			$this->load->model('register_model');
			$this->load->model('masters_model');
			$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
			$this->data['title']="Document Upload";
			foreach($this->data['defaultsConfigs'] as $default){
			    if ($default->default_id == "pdoc_allowed_types"){
			       $this->data['allowed_types'] = $default->value;
			    }
			    if ($default->default_id == "pdoc_max_size"){
				$this->data['max_size'] = $default->value;
			    }
			    if ($default->default_id == "pdoc_max_width"){
				$this->data['max_width'] = $default->value;
			    }
			    if ($default->default_id == "pdoc_max_height"){
				$this->data['max_height'] = $default->value;
			    }
			    if ($default->default_id == "pdoc_remove_spaces"){
				$this->data['remove_spaces'] = $default->value;
			    }
			    if ($default->default_id == "pdoc_overwrite"){
				$this->data['overwrite'] = $default->value;
			    }                                   
			}
			$this->data['result']=$this->register_model->get_upload_link_metadata($_GET['key']);
			
	} else {
			$this->data['result'] = [] ;
	}	
	if (empty($this->data['result'])){	
		$this->load->view('templates/invalid_page');
	} else {
		$this->load->view('pages/doc_upload',$this->data);
	} 
		
		//echo("<script>console.log('PHP: " . json_encode($this->data['result']) . "');</script>");

	
	
	
        	
	}
	function update_patients(){
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$this->data['hospital'] = $hospital = $this->session->userdata('hospital');
		$this->data['staff_hospital'] = $hospital = $this->session->userdata('hospital');
		//echo("<script>console.log('PHP: " . json_encode($this->data['staff_hospital']) . "');</script>");
		$access=0;
		$add_sms_access=0;
		$patient_document_add_access=0;
		$patient_document_remove_access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="Update Patients"){
				$access=1;
			}
			if($function->user_function=="patient_document_upload"){
				if ($function->add==1) $patient_document_add_access=1;
				if ($function->remove==1) $patient_document_remove_access=1;
				if ($function->edit==1) $patient_document_edit_access=1;
			}
			// Fetch user functions and check if the user has 
        		// access to documentation access rights
			if($function->user_function=="sms"){		 
		 
                		if ($function->add==1 && $this->data['staff_hospital']["helpline"] && $this->data['staff_hospital']["helpline"]!="" && !empty($this->data['staff_hospital']["helpline"]))
						{							
						  $add_sms_access=1;
						}
					 
            		}
		}
		if($access==1){
		$transaction = $this->transaction_condition();
		$this->data['title']="Update Patients";
		$this->data['signed_consultation'] = $this->input->post('signed_consultation');
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$user=$this->session->userdata('logged_in');
		$this->data['user_id']=$user['user_id'];	
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->data['districts']=$this->staff_model->get_district();
		$this->data['helpline_hospitals']=$this->hospital_model->get_hospitals_selectize(true);
		$this->data['id_proof_types']=$this->staff_model->get_id_proof_type();
		$this->data['occupations']=$this->staff_model->get_occupations();
		$this->data['lab_units'] = $this->masters_model->get_data("lab_unit");
		$this->data['drugs'] = $this->masters_model->get_data("drugs");
		$this->data['procedures'] = $this->masters_model->get_data("procedure");
		$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
		$this->data['defaults'] = $this->staff_model->get_transport_defaults();
		$this->data['prescription_frequency'] = $this->staff_model->get_prescription_frequency();
		$this->data['drugs_available'] = $this->hospital_model->get_drugs();
		$this->data['sms_templates']=$this->helpline_model->get_sms_template();
		$this->data['patient_document_add_access']=$patient_document_add_access;
		$this->data['patient_document_remove_access']=$patient_document_remove_access;
		$this->data['patient_document_edit_access']=$patient_document_edit_access;
		$this->data['add_sms_access']=$add_sms_access;
		$patient_id = $this->input->post('patient_id');
		$visit_id = $this->input->post('selected_patient');
		$document_link = $this->input->post('document_link');
		if($this->input->post('selected_patient')){
			$this->data['previous_visits']=$this->register_model->get_visits($patient_id);
			$this->data['patient_visits'] = $this->gen_rep_model->simple_join('patient_visits_all', false);
			$this->data['clinical_notes'] = $this->gen_rep_model->simple_join('clinical_notes', false);
			$this->data['all_tests'] = $this->gen_rep_model->simple_join('tests_ordered', false);
			$this->data['prescriptions'] = $this->gen_rep_model->simple_join('prescriptions', false);
			
			// $this->data['previous_prescriptions'] = $this->register_model->get_previous_prescriptions($visit_id);
		}		
		//  $this->data['hospitals'] = $this->hospital_model->get_hospitals();

        // Fetch user document upload defaults
        foreach($this->data['defaultsConfigs'] as $default){
            if ($default->default_id == "pdoc_allowed_types"){
               $allowed_types = $default->value;
            }
            if ($default->default_id == "pdoc_max_size"){
                $max_size = $default->value;
            }
            if ($default->default_id == "pdoc_max_width"){
                $max_width = $default->value;
            }
            if ($default->default_id == "pdoc_max_height"){
                $max_height = $default->value;
            }
            if ($default->default_id == "pdoc_remove_spaces"){
                $remove_spaces = $default->value;
            }
            if ($default->default_id == "pdoc_overwrite"){
                $overwrite = $default->value;
            }                                   
        }
        $user_receiver = $this->helpline_model->getHelplineReceiverByUserId($this->data['user_id']);
			$user_receiver_links = array();
			if($user_receiver){
				$user_receiver_links = $this->helpline_model->getHelplineReceiverLinksById($user_receiver->receiver_id);
			}
			$this->data['user_details']=json_encode(array(
				'receiver' => $user_receiver,
				'receiver_link' => $user_receiver_links
			));        
		//  $this->data['arrival_modes'] = $this->patient_model->get_arrival_modes();
        $this->data['visit_names'] = $this->staff_model->get_visit_name();
		$this->form_validation->set_rules('patient_number', 'IP/OP Number',
		'trim|xss_clean');
		if ($this->form_validation->run() === FALSE)
		{						
			$this->load->view('pages/update_patients',$this->data);

		}
		else{		
			// Patient documents
			if (array_key_exists("upload_file", $_FILES)) 
			{
				$dir_path = './assets/patient_documents/';
				$config['upload_path'] = $dir_path;
				$config['allowed_types'] = $allowed_types;
				$config['max_size'] = $max_size;
				$config['max_width'] = $max_width;
				$config['max_height'] = $max_height;
				$config['encrypt_name'] = FALSE;
				$config['overwrite'] = $overwrite;
				$config['remove_spaces'] = $remove_spaces;
			
				// Upload file and add document record
				$msg = "Error: ";
				$uploadOk = 1;
				$target_file = $dir_path . basename($_FILES["upload_file"]["name"]);
				$imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
			
				if ($_FILES['upload_file']['size'] <= 0 && $uploadOk == 1) {
					$msg = $msg . "Select at least one file.";
					$uploadOk = 0;
				}
			
				// Document type is mandatory
				if (!$this->input->post('document_type')) {
					$uploadOk = 0;
				}
			
				// Check for upload errors
				if ($uploadOk == 0) {
					$this->data['msg'] = $msg . " Your file was not uploaded.";
				} else {
					// Rotate image
					$rotation_angle = $this->input->post('rotation');
					if ($rotation_angle) {
						$rotation_angle = 360 - $rotation_angle;
						$this->load->library('image_lib');
						$config['rotation_angle'] = $rotation_angle;
						$config['source_image'] = $_FILES["upload_file"]["tmp_name"];
						$config['maintain_ratio'] = FAlSE;
            			$config['width'] = 180;
						$config['height'] = 180;
						$this->image_lib->initialize($config);
						if (!$this->image_lib->rotate()) {
							$this->data['msg'] = "Error rotating image: " . $this->image_lib->display_errors();
							$uploadOk = 0;
						} else {
							echo "Image rotated successfully."; // Debugging statement
						}
					} else {
						echo "No rotation angle provided."; // Debugging statement
					}
			
					// Try to upload file
					if ($uploadOk == 1) {
						$new_name = $patient_id . '_' . $_FILES["upload_file"]['name'];
						$config['file_name'] = $new_name;
						$this->load->library('upload', $config);
						if (!$this->upload->do_upload('upload_file')) {
							$msg = $msg . $this->upload->display_errors();
							$uploadOk = 0;
						} else {
							$file = $this->upload->data();
							$uploadOk = 1;
						}
					}
				}
			
				// Add document record
				if ($uploadOk == 1 && $this->patient_document_upload_model->add_document($patient_id, $file['file_name']) ) {
					$this->data['msg'] = "Document Added Successfully";
				}

			}

			if ($document_link){
				if (($this->patient_document_upload_model->delete_document($patient_id, $document_link)) > 0) {
					$this->delete_document($document_link);
				}
			}
			
			if($this->input->post('edit_document_link'))
			{
				$edit_note = $this->input->post('note');
				$edit_patient_id = $this->input->post('edit_patient_id');

				$dir_path = './assets/patient_documents/';
				$config['upload_path'] = $dir_path; // upload directory
				$config['allowed_types'] = 'gif|jpg|png|jpeg'; // Allowed file types
				$config['max_size'] = $max_size;
				$config['max_width'] = $max_width;
				$config['max_height'] = $max_height;
				$config['encrypt_name'] = FALSE;
				$config['overwrite'] = $overwrite;
				$config['remove_spaces'] = $remove_spaces;
				$config['file_ext_tolower'] = true; // Convert extensions to lowercase

				$this->load->library('upload', $config);
				if ($this->upload->do_upload('edit_upload_file')) 
				{
					$upload_data = $this->upload->data();
					$new_name = $edit_patient_id . '_' . $upload_data['file_name'];

					$old_path = $upload_data['full_path'];
					$new_path = $upload_data['file_path'] . $new_name;
					rename($old_path, $new_path);

					$rotation_angle = $this->input->post('rotation');
					if($rotation_angle) 
					{
						$rotation_angle = 360 - $rotation_angle;
						$this->load->library('image_lib');
						$config['rotation_angle'] = $rotation_angle;
						$config['source_image'] = $new_path;
						$config['maintain_ratio'] = FALSE;
						$config['width'] = 180;
						$config['height'] = 180;
						$this->image_lib->initialize($config);
						if (!$this->image_lib->rotate()) {
							$this->data['msg'] = "Error rotating image: " . $this->image_lib->display_errors();
						} else {
							echo "Image rotated successfully."; // Debugging statement
						}
					} else {
						echo "No rotation angle provided."; // Debugging statement
					}
					$this->patient_document_upload_model->update_document_metadata($new_name, $edit_note);
				} else {
					$error = array('error' => $this->upload->display_errors());
					$edit_document_link = $this->input->post('edit_document_link');
					$this->patient_document_upload_model->update_document_metadata($edit_document_link, $edit_note);
				}
			}
					
			$this->data['transporters'] = $this->staff_model->get_staff("Transport");
			if($this->input->post('update_patient') && $transaction){				
				$update = $this->register_model->update();
                if(is_int($update) && $update==2){
					//If register function returns value 2 then we are setting a duplicate ip no error.
					$this->data['duplicate']=1;
				}
				
				$this->data['transfers'] = $this->patient_model->get_transfers_info();
				$this->data['transport'] = $this->staff_model->get_transport_log();
				$this->data['patients']=$this->register_model->search();
				$this->data['registered'] = $this->data['patients'][0];
				$this->data['msg'] = "Patient information has been updated successfully";
				$this->data['previous_visits']=$this->register_model->get_visits($patient_id);
				$this->data['patient_visits'] = $this->gen_rep_model->simple_join('patient_visits_all', false);
				$this->data['clinical_notes'] = $this->gen_rep_model->simple_join('clinical_notes', false);
				$this->data['all_tests'] = $this->gen_rep_model->simple_join('tests_ordered', false);
				$this->data['prescriptions'] = $this->gen_rep_model->simple_join('prescriptions', false);
				if(count($this->data['patients'])==1){
					$this->load->model('diagnostics_model');
					$this->data['vitals'] = $this->gen_rep_model->simple_join('patient_vitals', false, array('patient.patient_id'=>$this->data['patients'][0]->patient_id));
					$visit_id = $this->data['patients'][0]->visit_id;
					if ($patient_id!=0 && $visit_id){
						$previous_visit = $this->register_model->get_previous_visit($visit_id, $patient_id);
					}
					$this->data['prescription_frequency'] = $this->staff_model->get_prescription_frequency();
					$this->data['prescription']=$this->register_model->get_prescription($visit_id);
					$this->data['previous_prescription']=$this->register_model->get_prescription($previous_visit->visit_id);
					$this->data['tests']=$this->diagnostics_model->get_all_tests($visit_id);
					$this->data['visit_notes']=$this->register_model->get_clinical_notes($visit_id);
					$this->data['patient_document_upload'] = $this->patient_document_upload_model->get_patient_documents($this->data['patients'][0]->patient_id);
					$this->data['patient_document_type'] = $this->patient_document_upload_model->get_patient_document_type();
					// start -- 18_02_2023 --- Shruthi S M//
					$pri_patient_id	= $this->data['patients'][0]->patient_id;		   
					$this->data['update_print_layout'] = $this->register_model->get_print_layout($pri_patient_id);
					$print_layout_id = $this->data['update_print_layout'][0]->print_layout_id;
				    $a6_print_layout_id = $this->data['update_print_layout'][0]->a6_print_layout_id;
					
						$print_layout = $this->staff_model->get_print_layout($print_layout_id);
						$a6_print_layout = $this->staff_model->get_print_layout($a6_print_layout_id);					
						$print_layout_page = $print_layout->print_layout_page;
						$print_layout_a6 = $a6_print_layout->print_layout_page;
					$this->data['print_summary_counseling']  = $this->masters_model->get_all_couseling_for_print($this->data['patients'][0]->hosp_file_no);

				}
				 //Set the print layout page based on the form selected.
				 $this->data['update_print_layout']="pages/print_layouts/$print_layout_page";
				 $this->data['update_print_layout_a6']="pages/print_layouts/$print_layout_a6";
       				 //--- end  18_02_2023 --- //
				$this->load->view('pages/update_patients',$this->data);
			}
			else{
				$this->data['patients']=$this->register_model->search();
				$this->data['registered'] = $this->data['patients'][0];
				if(count($this->data['patients'])==1){
					$this->load->model('diagnostics_model');
					$visit_id = $this->data['patients'][0]->visit_id;
					if ($patient_id!=0 && $visit_id){
						$previous_visit = $this->register_model->get_previous_visit($visit_id, $patient_id);
					}	
					$data_array = array('patient_id' => $this->data['patients'][0]->patient_id);				
					$this->data['vitals'] = $this->gen_rep_model->simple_join('patient_vitals', false, array('patient.patient_id'=>$this->data['patients'][0]->patient_id));	
					$this->data['patient_visits'] = $this->gen_rep_model->simple_join('patient_visits_all', $data_array);
					$this->data['clinical_notes'] = $this->gen_rep_model->simple_join('clinical_notes', $data_array);
					$this->data['all_tests'] = $this->gen_rep_model->simple_join('tests_ordered', $data_array);
					$this->data['prescriptions'] = $this->gen_rep_model->simple_join('prescriptions', $data_array);
                    $this->data['transfers'] = $this->patient_model->get_transfers_info($visit_id);
					$this->data['prescription_frequency'] = $this->staff_model->get_prescription_frequency();
					$this->data['transport'] = $this->staff_model->get_transport_log();
					$this->data['prescription']=$this->register_model->get_prescription($visit_id);
					
					$hospital=$this->session->userdata('hospital');
					$hospital_id=$hospital['hospital_id'];
					$this->data['hosp_all_print_layouts']=$this->register_model->get_hosp_all_print_layouts($hospital_id);
					// start -- 18_02_2023 --- Shruthi S M//
					$pri_patient_id	= $this->data['patients'][0]->patient_id;
					$this->data['update_print_layout'] = $this->register_model->get_print_layout($pri_patient_id);
					$print_layout_id = $this->data['update_print_layout'][0]->print_layout_id;
				    $a6_print_layout_id = $this->data['update_print_layout'][0]->a6_print_layout_id;
					
						$print_layout = $this->staff_model->get_print_layout($print_layout_id);
						$a6_print_layout = $this->staff_model->get_print_layout($a6_print_layout_id);					
						$print_layout_page = $print_layout->print_layout_page;
						$print_layout_a6 = $a6_print_layout->print_layout_page;

					if(count($previous_visit)>0)
						$this->data['previous_prescription']=$this->register_model->get_prescription($previous_visit->visit_id);
					$this->data['tests']=$this->diagnostics_model->get_all_tests($visit_id);
					$this->data['visit_notes']=$this->register_model->get_clinical_notes($visit_id);
					$this->data['patient_document_upload'] = $this->patient_document_upload_model->get_patient_documents($this->data['patients'][0]->patient_id);
					$this->data['patient_document_type'] = $this->patient_document_upload_model->get_patient_document_type();
					
					
				}
				 //Set the print layout page based on the form selected.
				 /* Newly added Jan 30 2024 */
				 $print_layout_id = $this->input->post('print_layout_id');
				 $this->data['all_print_layouts'] = $this->staff_model->get_print_layouts();
				 $this->data['new_print_layout'] = $this->staff_model->get_print_layout($print_layout_id);
				 //$this->data['default_layout'] = $this->staff_model->select_default_layout();
				 /*if(!empty($print_layout_id) || $print_layout_id!='0')
				 {
				 	$this->data['update_print_layout'] = $this->staff_model->update_hospital_print_layout($print_layout_id);
				 }*/
				 /* Till here */
				 $this->data['update_print_layout']="pages/print_layouts/$print_layout_page";
				 $this->data['update_print_layout_a6']="pages/print_layouts/$print_layout_a6";
				 //$this->data['print_summary_counseling']  = $this->masters_model->get_all_couseling_for_print($this->data['patients'][0]->hosp_file_no); <!-- changed on 24-07-2024 -->
				 $this->data['print_summary_counseling']  = $this->masters_model->get_all_couseling_for_print($this->data['patients'][0]->visit_id);
        		//--- end  18_02_2023 --- //
				$this->load->view('pages/update_patients',$this->data);
			}
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
	}

	function print_add_on_layouts()
	{
		$selectedValue = $this->input->post('selectedValue');
		$patient_id = $this->input->post('patientId');
		$this->data['registered']=$this->register_model->search_patient_print_layout($patient_id);
		$print_layout_name = $this->staff_model->get_print_layout($selectedValue);
		$page_name = $print_layout_name->print_layout_page;
		$html_content =  $this->load->view('pages/print_layouts/'.$page_name,$this->data,true);
		echo $html_content;
	}

	function get_all_counselingtype() 
	{
        $counselingtypes  = $this->masters_model->get_all_counseling_type();
        echo json_encode($counselingtypes);
    }

	function get_all_languagesct() 
	{
        $all_languagesct  = $this->masters_model->get_all_language_ct();
        echo json_encode($all_languagesct);
    }

	// Newly added
	function getCounselingText()
	{
		$counselingTypeId = $this->input->post("counseling_type");
		$language = $this->input->post('language');
		$counselingTextOptions = $this->masters_model->get_counseling_text_options($counselingTypeId,$language);
		echo json_encode($counselingTextOptions);
	}
	// Newly added
	function counseling_his_table()
    {
        $get_visit_id = $this->input->post('get_visit_id');
        $data = $this->masters_model->get_all_couseling($get_visit_id);
        echo json_encode($data);
    }

	function search_icd_codes(){
		if($icd_codes = $this->register_model->search_icd_codes()){
			$list=array(
				'icd_codes'=>$icd_codes
			);
			
				echo json_encode($list);
		}
		else return false;
	}
	function search_prescription_drugs(){
		if($results = $this->masters_model->get_data("drugs")){
			$list=array(
				'drugs'=> $results,
				'drugs_available'=> $this->hospital_model->get_drugs()
			);
			
			echo json_encode($list);
		}
		else return false;
	}
	
	function transport(){		
		if($this->session->userdata('logged_in')){
		$this->data['userdata']=$this->session->userdata('logged_in');
		$access=0;
		foreach($this->data['functions'] as $function){
			if($function->user_function=="Patient Transport"){
				$access=1;
				break;
			}
		}
		if($access==1){
		$this->data['title']="Patient Transport";
		$this->load->view('templates/header',$this->data);
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->data['all_departments']=$this->staff_model->get_department();
		$this->data['units']=$this->staff_model->get_unit();
		$this->data['areas']=$this->staff_model->get_area();
		$this->data['defaults'] = $this->staff_model->get_transport_defaults();
        $this->data['visit_names'] = $this->staff_model->get_visit_name();
		$this->data['transporters'] = $this->staff_model->get_staff("Transport");
		$this->form_validation->set_rules('patient_number', 'IP/OP Number', 'trim|xss_clean');
		$this->data['transport_queue_np'] = $this->staff_model->get_transport_log("active","np");
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('pages/transport',$this->data);
		}
		else{
		
			if($this->input->post('transport')){
				if($this->register_model->transport()){
					$this->data['msg']="Updated Successfully";
				}
				$this->data['transport_queue'] = $this->staff_model->get_transport_log("active");
				$this->data['patients']=$this->register_model->search();
				if(count($this->data['patients'])==1){
					$visit_id = $this->data['patients'][0]->visit_id;
				}
				$this->load->view('pages/transport',$this->data);
			}
			else if($this->input->post('transport_np')){
				if($this->register_model->transport("np"))
					$this->data['msg']="Updated Successfully";
				$this->data['transport_queue_np'] = $this->staff_model->get_transport_log("active","np");
				$this->load->view('pages/transport',$this->data);
			}
			else{
				$this->data['patients']=$this->register_model->search();
				if(count($this->data['patients'])==1){
					$visit_id = $this->data['patients'][0]->visit_id;
					$this->data['transport_queue'] = $this->staff_model->get_transport_log("active");
				}
				$this->load->view('pages/transport',$this->data);
			}
		}
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
	}
    // Method for displaying single user document
	public function display_document($document_link)
	{
        // Validate user access for this method
        if($this->session->userdata('logged_in')){
            $this->data['userdata']=$this->session->userdata('logged_in');
            $access=0;
            $add_access=0;

            // Fetch user functions and check if the user has 
            // access to documentation access rights
            foreach($this->data['functions'] as $function){
                if($function->user_function=="Update Patients"){
                    $access=1;
                    if ($function->add==1) $add_access=1;
		    if ($function->edit==1) $edit_access=1;
		    break;
		}

                
                }

                // Initialize Model and View for documentation controller
            if($access==1){
                $this->download_file('assets/patient_documents/'.$document_link, $document_link);                    
            }
            else{
                show_404();
            }
        }
        else{
            show_404();
        }
    }
    
    function download_file($path, $name)
    {
        if(is_file($path))
        {
            $this->load->helper('file');
    
            header('Content-Type: '.get_mime_by_extension($path));  
            header('Content-Disposition: inline; filename="'.basename($name).'"');
            header('Content-Transfer-Encoding: binary');
            header('Content-Length: '.filesize($path));
        
            header('Connection: close');
            readfile($path); 
            die();
        }
	}

	
	public function patient_follow_up()
	{
		if($this->session->userdata('logged_in'))
		{
			$this->data['userdata']=$this->session->userdata('logged_in');
			$this->data['hospital'] = $hospital = $this->session->userdata('hospital');

			$access=0;
			foreach($this->data['functions'] as $function){
				if($function->user_function=="patient_follow_up"){
					$access=1;
					break;
				}
			}
			if($access==1){
				$transaction = $this->transaction_condition();
				$this->data['title']="Patients Followup";
			$this->load->view('templates/header',$this->data);
			$this->load->helper('form');
			$this->load->library('form_validation');
			
			
			
			if ($this->form_validation->run() === FALSE)
			{	
				$c_patient = $this->input->post('healthforall_id');
				$this->data['patient_followup']=$this->register_model->select_patient_followup_id($c_patient);
				
				$this->data['hospital_id'] = $this->data['hospital']['hospital_id'];
				
				$this->data['patients']=$this->register_model->get_patient_followup();
				$patient_id = $this->data['patients']['0']->patient_id;
				$this->data['priority_types']=$this->register_model->get_priority_type();
				$this->data['route_primary']=$this->register_model->get_primary_route();
				$this->data['route_secondary']=$this->register_model->get_secondary_route();
				$this->data['volunteer']=$this->register_model->get_volunteer();

				//selecting primary route with secondary route_id
				$this->data['routeprim_secondrouteid']=$this->register_model->primary_route_with_secroute($this->data['patient_followup']->route_secondary_id);
				

				$district_id = $this->data['patients']['0']->district_id;
				$this->data['districts'] = $this->register_model->get_districts($district_id);
				$this->data['codes'] = $this->register_model->search_icd_codes();

				
				
				if($this->input->post('search_add')){
				
				
					$insert_id = $this->register_model->addfor_followup();
					if($insert_id)
					$this->data['msg'] = '<b style="color:#5bff33;">Followup Added Successfully</b>';
				else
					$this->data['msg'] = '<b style="color:#ff4633;">Something went wrong try again</b>';
				//	$this->load->view('pages/patient_followup',$this->data);
			}
			 
			if($this->input->post('search_update_btn'))
			{
	
				$update = $this->register_model->updatefor_followup();
				if($update == true)
					$this->data['msg'] = '<b style="color:#5bff33;">Updated Successfully</b>';
					else
					$this->data['msg'] = '<b style="color:#ff4633;">Something went wrong try again</b>';
			}
			// $response = $this->input->post();
			// $update_patients = array();
			// $update_patients['patient_id'] = $response['patient_id']; 
			// $update_patients['status_date'] = $response['status_date'];
			// $update_patients['life_status'] = $response['life_status']; 
			// $update_patients['icd_code'] = $response['icd_code']; 
			// $update_patients['diagnosis'] = $response['diagnosis'];
			// $update_patients['last_visit_type'] = $response['last_visit_type']; 
			// $update_patients['last_visit_date'] = $response['last_visit_date'];
			// $update_patients['priority_type'] = $response['priority_type']; 
			// $update_patients['volunteer'] = $response['volunteer']; 
			// $update_patients['input_note'] = $response['input_note'];
			
			// $this->data['update_patient'] = $this->register_model->insert_update_followup($update_patients);
			//$this->data['add_followup'] = $this->register_model->insert_add_followup($update_patients);

			
			//if(!$this->data['followups']){
			//$this->data['msg'] = "No patient record found. Register Patient and add for Followup";
			//}
			$this->load->view('pages/patient_followup',$this->data);
			if($this->input->post('search_followup') || $this->input->post('healthforall_id')){
				//priority_types$this->data['patients']=$this->register_model->get_patient_followup();

				$this->load->view('pages/detail_followup',$this->data);

			}
		}	
		//$this->load->view('pages/patient_followup',$this->data);
	
		$this->load->view('templates/footer');
		}
		else{
		show_404();
		}
		}
		else{
		show_404();
		}
	}


	function delete_document($document_link)
	{
		unlink('assets/patient_documents/'.$document_link);
	}

	function update_patient_customised($form_id='')
	{		
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper('form');
			$this->data['title']="Update Patient Custom";
			$this->data['userdata']=$this->session->userdata('logged_in');
			$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
			foreach($this->data['defaultsConfigs'] as $default){		 
				if($default->default_id=='pagination'){
						$this->data['rowsperpage'] = $default->value;
						$this->data['upper_rowsperpage']= $default->upper_range;
						$this->data['lower_rowsperpage']= $default->lower_range;	 

					}
				}
			foreach($this->data['functions'] as $function)
			{
				if($function->user_function=="update_patient_customised"){
					$access=1;break;
				}
			}
			
			if($access==1)
			{
				$this->data['form_id'] = $form_id;
				$this->data['requested_form_id']= $this->input->post('sent_form_id');
				if(!empty($this->input->post('search_patient_id')) || !empty($this->input->post('search_patient_number')) ||
						!empty($this->input->post('search_phone')) || !empty($this->input->post('search_patient_id_manual')))
				{
					$this->data['patients']=$this->register_model->search();
				}
				
			}
				$this->load->view('templates/header',$this->data);
				$this->load->view('templates/leftnav',$this->data);
				$this->load->view('pages/update_patients_custom',$this->data);
				$this->load->view('templates/footer');		
		}
		else
		{
            show_404();
        }
	}

	function generate_table_checkboxes($form_id='')
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper('form');
			$this->data['title']="Select Fields";
			$this->data['userdata']=$this->session->userdata('logged_in');
			$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
			foreach($this->data['defaultsConfigs'] as $default){		 
				if($default->default_id=='pagination'){
						$this->data['rowsperpage'] = $default->value;
						$this->data['upper_rowsperpage']= $default->upper_range;
						$this->data['lower_rowsperpage']= $default->lower_range;	 

					}
				}
			foreach($this->data['functions'] as $function)
			{
				if($function->user_function=="update_patient_customised"){
					$access=1;break;
				}
			}
			if($access==1)
			{
				$this->data['form_id'] = $form_id ;
				$selected_patient = $this->input->post('selected_patient'); 
				$this->session->set_userdata('selected_visit_id', $selected_patient);
				$table_names = ['patient', 'patient_visit', 'patient_followup'];
				$columns = $this->register_model->get_columns_for_multiple_tables($table_names);
				$data['columns'] = $columns;
			}
				$this->load->view('templates/header',$this->data);
				$this->load->view('templates/leftnav',$this->$data);
				$this->load->view('pages/generated_column_checkboxes',$data);
				$this->load->view('templates/footer');
		}
		else
		{
			show_404();
		}
	}

	public function submit_columns() 
	{
		$form_name = $this->input->post('form_name');
		$selected_columns = $this->input->post('selected_columns');
		if ($form_name && !empty($selected_columns)) 
		{
			$data = [
				'form_name' => $form_name,
				'selected_columns' => json_encode($selected_columns)
			];
			
			$form_id = $this->register_model->save_sel_cols_update_patients($form_name, $selected_columns);
			if ($form_id) 
			{
				echo json_encode(['status' => 'success', 'message' => 'Form Created Successfully!']);
			} else 	{
				echo json_encode(['status' => 'error', 'message' => 'Failed to save columns.']);
			}
		} else {
			echo json_encode(['status' => 'error', 'message' => 'Form name or columns not selected.']);
		}
	}

	public function saved_update_patient_custom_form() 
	{
		if($this->session->userdata('logged_in'))
		{
			$this->load->helper('form');
			$this->data['title']="Update Patient Custom";
			$this->data['userdata']=$this->session->userdata('logged_in');
			$this->data['defaultsConfigs'] = $this->masters_model->get_data("defaults");
			$this->data['all_departments']=$this->staff_model->get_department();
			$this->data['units']=$this->staff_model->get_unit();
			$this->data['areas']=$this->staff_model->get_area();
			$this->data['districts']=$this->staff_model->get_district();
			$this->data['states']=$this->masters_model->get_data('states');
			$this->data['priority_types']=$this->register_model->get_priority_type();
			$this->data['route_primary']=$this->register_model->get_primary_route();
			$this->data['route_secondary']=$this->register_model->get_secondary_route();
			$this->data['patients']=$this->register_model->search();

			$hospital=$this->session->userdata('hospital');
			$hospital_id=$hospital['hospital_id'];
			$this->data['hosp_all_print_layouts']=$this->register_model->get_hosp_all_print_layouts($hospital_id);
			foreach($this->data['defaultsConfigs'] as $default){		 
				if($default->default_id=='pagination'){
						$this->data['rowsperpage'] = $default->value;
						$this->data['upper_rowsperpage']= $default->upper_range;
						$this->data['lower_rowsperpage']= $default->lower_range;	 

					}
				}
			foreach($this->data['functions'] as $function)
			{
				if($function->user_function=="update_patient_customised"){
					$access=1;break;
				}
			}
			if($access==1)
			{
				$this->data['visit_id'] = $this->input->post('visit_id');
				$this->data['patient_id'] = $this->input->post('patient_id');
				$this->data['file_no'] = $this->input->post('hosp_file_no');
				$this->data['visit_type_name'] = $this->input->post('visit_type');

				$sent_form_id = $this->input->post('sent_form_id');
				if ($sent_form_id) {
					$this->data['saved_form_id'] = $this->register_model->get_saved_fields_data_up($sent_form_id);
					$combined_array = array();
					foreach ($this->data['saved_form_id'] as $entry) 
					{
						$combined_value = $entry->table_name. '.' .$entry->selected_columns ;
						$combined_array[] = $combined_value;
					}
					$this->data['db_values'] = $this->register_model->get_db_values_selected_fields($combined_array,$this->data['visit_id']);
					//print_r($this->data['db_values']);
				} else {
					$this->data['saved_form_id'] = '';
				}
			}
			$this->load->view('templates/header', $this->data);
			$this->load->view('templates/leftnav', $this->data);
			$this->load->view('pages/saved_update_patient_custom_form', $this->data);
			$this->load->view('templates/footer');
		}
		else
		{
			show_404();
		}
	}

	public function save_custom_patient_visit_details() 
	{
		$this->load->library('session');
		$form_data = $this->input->post();
		$this->session->set_userdata('form_data', $form_data);

		$post_data = $_POST;
		$patient_id = $this->input->post('patient_id');
		$visit_id = $this->input->post('visit_id');
		
		$this->data['patient_details'] = $this->register_model->get_pat_details_custom_print($patient_id,$visit_id);
		$this->session->set_userdata('patient_details', $this->data['patient_details']);

		$fields_to_update = [];
		foreach ($post_data as $field_name => $new_value) 
		{
			$field_name = str_replace('__DOT__', '.', $field_name);
			$dot_position = strpos($field_name, '.');
			if ($dot_position !== false) 
			{
				$column_name = substr($field_name, 0, $dot_position);
				$table_name = substr($field_name, $dot_position + 1);
				$fields_to_update[] = [
					'column_name' => $column_name,
					'table_name'  => $table_name,
					'new_value'   => $new_value
				];
			}
		}
		
		$update_status = $this->register_model->update_patient_visit_data_cus($fields_to_update,$patient_id,$visit_id);
		if ($update_status) {
			$this->session->set_flashdata('success', 'Patient visit details updated successfully.');
		} else {
			$this->session->set_flashdata('error', 'No changes were made or an error occurred.');
		}
		redirect('register/saved_update_patient_custom_form');
	}

	public function print_custom_layout() 
	{
		$form_data = $this->session->userdata('form_data');
		$data['form_data'] = $form_data;
		$this->load->view('pages/print_layouts/patient_summary_custom', $data);
	}
}
