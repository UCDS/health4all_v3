<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Generic_report extends CI_Controller {
    private $logged_in = false;
    private $functions = array();
    private $authorised = false;
	function __construct(){
		parent::__construct();
		if($this->session->userdata('logged_in')){
            $this->logged_in = true;
            $userdata=$this->session->userdata('logged_in');
            $user=$this->session->userdata('logged_in');
            $this->load->model('masters_model');
            $this->load->model('staff_model');
            $this->load->model('reports_model');
            $this->load->model('equipment_model');
            $user_id=$userdata['user_id'];
            $this->data['title']='Report';
            $this->data['hospitals']=$this->staff_model->user_hospital($user_id);
            $this->functions = $this->staff_model->user_function($user_id);
            $this->data['functions']=$this->staff_model->user_function($user_id);
            $this->data['departments']=$this->staff_model->user_department($user_id);
            $this->data['op_forms']=$this->staff_model->get_forms("OP");
            $this->data['ip_forms']=$this->staff_model->get_forms("IP");
            $this->data['user_id']=$user['user_id'];
            $this->load->model('gen_rep_model');
		}		
    }
    
    function gen_rep($route = false) {
        if(!$this->logged_in)
            show_404();

        $this->load->view('templates/header',$this->data);
        $this->load->view("pages/generic_report",$this->data);
        if($route){
            $this->data['doctors'] = $this->gen_rep_model->simple_join('doctors');
            $this->load->view("pages/html_components/$route",$this->data);
        }            
        $this->load->view('templates/footer');
    }

    function json_data() {
        if(!$this->logged_in){
            echo json_encode('false');
            return;
        }        
        foreach($this->functions as $function){
            if($function->user_function == 'Outcome Summary' || $function->user_function =="OP Detail") {
                $authorised = true;
            }
        }
        if(!$authorised)
            return json_encode(false);
        
        $post_data = $this->security->xss_clean($_POST);
        
        $result = array();
        if(array_key_exists('query_strings', $post_data)) {
            $query_strings = explode(',', $post_data['query_strings']);
            foreach($query_strings as $query_string) {
                $result[$query_string] = $this->gen_rep_model->simple_join($query_string, $post_data);
            }
        };
        echo json_encode($result);
    }
}
