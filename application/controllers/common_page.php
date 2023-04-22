<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Common Controller to handled forms & list pages dynamically.
class CommonPageController extends CI_Controller {
	private function checkLoggedInUserPermissionForUserFunctionAndDetail($user_function = ''){
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

	private function prepareFormPageForUserFunction($user_function="", $isEdit=false, $rules=[], $model_class=""){
		$user_function_detail = $this->checkLoggedInUserPermissionForUserFunctionAndDetail($user_function);
		
		$title = $user_function_detail->user_function_display;
		$action = $isEdit ? "edit" : "add";
		$actionTense = $action . "ed";
		$pageTitle = ucwords("$action $title");
		$model_function = "upsert_$user_function";

		$this->data['title'] = $pageTitle;

		$this->load->helper('form');
		$this->load->library('form_validation');

		// validation defaults...
		$this->form_validation->set_message('required', '%s is required.');
    	$this->form_validation->set_error_delimiters('<li>', '</li>');

		if($this->input->post('form_submit')){	
			// set rules....
			$this->form_validation->set_rules($rules);

			if ($this->form_validation->run() === TRUE) {
				if($this->$model_class->$model_function()){
					$this->data['msg'] = "$title $actionTense successfully";
				} else {
					$this->data['msg'] = "$title could not be $actionTense. Please try again.";
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
