<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Test_mail extends CI_Controller
{
function __construct(){
parent::__construct();
}

function index(){
			$this->load->library('email');
			$this->email->from('lab_microbiology@gandhihospital.in', 'MicroBiology - Gandhi Hospital');
			$this->email->to("vivek.chintalapati@gmail.com");
			$this->email->bcc("contact@yousee.in");
			$this->email->subject("Test");
			$this->email->message("TEst");
			if ( ! $this->email->send()) {
				$this->data['msg'] =  "failed".$this->email->print_debugger();
			}
			else{
				$this->data['msg'] =  $this->email->print_debugger();
			}
}
}

?>
