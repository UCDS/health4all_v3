<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Report extends CI_Controller {
    private $logged_in = false;    
    private $functions = false;
    private $dps = array(
        'dp_name'=>array(
            'acl' => array('')
        ),
        'prescription_report'=> array(
            'acl' => array('prescription_report')
        ),
        'op_vitals_detailed'=> array(
            'acl' => array('OP Detail')
        ),
        'follow_up_report'=> array(
            'acl' => array('follow_up_report')
        )
    );
    private $routes = array(
        'template_route_name'=> array(
                    'acl' => array(),               // User functions need to access this route
                    'dps' => array(),       // data_points All the queries we wish to execute
                    'dma' => array(     // data_manipulation_array
                        'php_function_name' => array(   // Like Map function
                            'data_point'=>array('field list')
                        )      // The php function expects array as parameter
                        ),
                    'component' => array()
                ),
        'prescription_report'=> array(
            'acl' => array('prescription_report'),
            'dps' => array(
                'doctors'
            ),
            'dma'=> false,
            'component' => array('prescription_report')
        ),
        'op_vitals_detailed'=> array(
            'acl' => array('OP Detail'),
            'dps' => array(
                'department', 'unit', 'area', 'visit_name'
            ),
            'dma'=> false,
            'component' => array('op_vitals_detailed')
        ),
        'follow_up_report'=> array(
            'acl' => array('follow_up_report'),
            'dps' => array(
                'visit_name'
            ),
            'dma'=> false,
            'component' => array('follow_up_report')
        ),
    );
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
    
    function get($route = false) {
        if(!$this->logged_in || !$route || !array_key_exists($route, $this->routes)){
            show_404();            
        }
        
        $authorised = false;                
        foreach($this->functions as $function){            
            $user_function = $function->user_function;
            $acl = $this->routes["$route"]['acl'];
            $search = array_search($user_function, $acl);
            if(is_int($search)){
                $authorised = true;
                break;
            }
        }        
        if(!$authorised){
            show_404();
        }

        foreach($this->routes["$route"]['dps'] as $dp){
            $this->data["$dp"] = $this->gen_rep_model->simple_join($dp); 
        }            

        $this->load->view('templates/header',$this->data);
        $this->load->view("pages/generic_report",$this->data);
        foreach($this->routes["$route"]['component'] as $component) {
            $this->load->view("pages/html_components/$component",$this->data);
        }        
        $this->load->view('templates/footer');
    }

    function json_data() {
        if(!$this->logged_in){
            echo json_encode('false');
            return;
        }        
                
        $post_data = $this->security->xss_clean($_POST);
        
        $result = array();
        if(array_key_exists('query_strings', $post_data)) {
            $query_strings = explode(',', $post_data['query_strings']);
            foreach($query_strings as $query_string) {
                $authorised = false;                
                foreach($this->functions as $function){            
                    $user_function = $function->user_function;
                    $acl = $this->dps["$query_string"]['acl'];
                    $search = array_search($user_function, $acl);
                    if(is_int($search)){
                        $authorised = true;
                        break;
                    }
                }        
                if(!$authorised){
                    echo false;
                }
                $result[$query_string] = $this->gen_rep_model->simple_join($query_string, $post_data);
            }
        };
        echo json_encode($result);
    }
}
