<?php
class Test extends CI_Controller{
  
  function __construct(){
		parent::__construct();
		$this->load->model('test_model');
	}
  
  public function appointment()
	{
		
		$this->data['report']=$this->test_model->appointment();
	
		$this->load->view('pages/test_appointment',$this->data);
		
		
	}
  
  public function view($page = 'test_home')
  {
    if(! file_exists(APPPATH.'views/pages/'.$page.'.php'))
    {
      // We don't have a page for that!
      show_404();
    }
    $data['title'] = ucfirst($page); // Capitalise the first letter
    $this->load->view('templates/test_header',$data);
    $this->load->view('pages/' . $page, $data);
    $this->load->view('templates/test_footer',$data);
  }
}
