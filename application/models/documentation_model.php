<?php
class documentation_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function get_documentation(){
		$hospital=$this->session->userdata('hospital');
	
		$this->db->select("id, keyword, topic, document_link, document_date, document_created_by, video_link, video_date, status, note");
        $this->db->from('documentation');
        $this->db->where('status', 1);

		$resource=$this->db->get();
		
		return $resource->result();
	}
}