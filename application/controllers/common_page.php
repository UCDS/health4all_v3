<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Common Controller to handled forms & list pages dynamically.
class CommonPageController extends CI_Controller {
	function checkLoggedInUserPermissionForUserFunctionAndDetail($user_function = ''){
		if($this->session->userdata('logged_in')){
			$this->data['userdata']=$this->session->userdata('logged_in');
			$access=0;
			foreach($this->data['functions'] as $function){
				if($function->user_function==$user_function){
					return $function;
				}
			}
		}
		show_404();
		return false;
	}

	function getvalueFromObject($obj, $key, $default){
		return isset($obj[$key]) ? $obj[$key] : $default;
	}

	function prepareFormPageForUserFunction($user_function="", $pageType=1, $rules=[], $model_class="", $options=array()){
		// pageType => 1=Add, 2=Edit, 3=Search
		/*
			// To re-use in most of places, follow this rules...
			1. table name say "priority_type" with primary_key as "priority_type_id"
			2. place controller & model into respective files like controller/register & model/register_model
			3. user_function table should have the table_name as user_function field => "priority_type"
			4. Mention the table fields in the rules array.
			5. [TODO] This logic works only for single table, we need to add logic to handled multiple tables...
			6. [TODO] In the common model logic, session hospital id is considered by default, if this is not needed we need to handle the same
			7. IF you get "The page you requested was not found.", make sure to verify if the user_function is added and user_funcion_link is added
			8. [TODO] on error form data needs to be retained.
			9. [TODO] check if the form data is filled and selected in edit mode.
		*/
		$user_function_detail = $this->checkLoggedInUserPermissionForUserFunctionAndDetail($user_function);
		
		// $title = $user_function_detail->user_function_display; // TODO: THIS NEEDS TO BE FROM DB...
		$title = ucwords(str_replace("_", " ", $user_function));
		$isAdd = $pageType === 1;
		$isEdit = $pageType === 2;
		$isSearch = $pageType === 3;

		$action = $isEdit ? "edit" : "add";
		$model_function = "upsert_$user_function";
		if($isSearch){
			$action = "search";
			$model_function = "search_$user_function";
		}
		$actionTense = $action . "ed";

		$pageTitle = ucwords("$action $title");

		$this->data['title'] = $pageTitle;
		$this->data['primary_key'] = $user_function;
		$this->data['form_action'] = $model_class."/".$action."_".$user_function;
		$this->data['fields'] = $rules;

		$this->load->helper('form');
		$this->load->library('form_validation');

		// validation defaults...
		$this->form_validation->set_message('required', '%s is required.');
    	$this->form_validation->set_error_delimiters('<li>', '</li>');

		// pre-load dropdowns...
		foreach ($this->data['fields'] as $index=>$field) {
			$type = isset($field['type']) ? $field['type'] : "text";
			$field['isText'] = $isText = $type === 'text';
			$field['isDropdown'] = $isDropdown = $type === 'dropdown';
			$pre_load_dropdown = isset($field['pre_load']) ? $field['pre_load'] : null;
			if($isDropdown && $pre_load_dropdown){
				$dropdown_model_class = $pre_load_dropdown['model_class'];
				$dropdown_model_function = $pre_load_dropdown['model_function'];
				$field['options'] = $this->{$dropdown_model_class."_model"}->$dropdown_model_function();
			}
			$field['value'] = $this->input->post($field['field']);
			$this->data['fields'][$index] = $field;
		}

		if($this->input->post('common_page_form_submit')){	
			// set rules....
			$this->form_validation->set_rules($rules);

			if ($this->form_validation->run() === TRUE) {
				if($isSearch){
					if($this->{$model_class."_model"}->$model_function()){
						$this->data['success'] = $this->getvalueFromObject($options, "success", "Record found.");
					} else {
						$this->data['failure'] = $this->getvalueFromObject($options, "failure", "No record found.");
					}
				} else {
					if($this->{$model_class."_model"}->$model_function($isEdit)){
						$this->data['success'] = $this->getvalueFromObject($options, "success", "$title $actionTense successfully");
					} else {
						$this->data['failure'] = $this->getvalueFromObject($options, "failure", "$title could not be $actionTense. Please try again.");
					}
				}
				if(!$this->getvalueFromObject($options, "displaySuccessMessage", true)){
					$this->data['success'] = null;
				}
				if(!$this->getvalueFromObject($options, "displayFailureMessage", true)){
					$this->data['failure'] = null;
				}
			}else{
				// $this->data['msg'] = "SOMEFIELDHERE is Required";
				// https://stackoverflow.com/questions/11031596/how-to-show-validation-errors-using-redirect-in-codeigniter
				// validation_errors will show the error in the page above the form
				// TODO: Should move the validate_errors() into generic page...
			}
		}

		$this->load->view('templates/header',$this->data);
		$this->load->view('templates/leftnav',$this->data);
		$this->load->view('pages/common_page_form', $this->data);
		$this->load->view('templates/footer');
	}
}
