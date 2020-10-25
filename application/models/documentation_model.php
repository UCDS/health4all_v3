<?php
class documentation_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	// Method to fetch documentation records
	function get_documentation(){
		$hospital=$this->session->userdata('hospital');
	
		$this->db->select("id, keyword, topic, document_link, document_date, document_created_by, video_link, video_date, status, note");
        $this->db->from('documentation');
        $this->db->where('status', 1);

		$resource=$this->db->get();
		
		return $resource->result();
	}

	// Method to add documentation records	
	function add_document($file_name){
		$hospital=$this->session->userdata('hospital');
	
        $get_document = array();																
		if($this->input->post('keyword')){														
            $get_document['keyword'] = $this->input->post('keyword');							
        }
		if($this->input->post('topic')){														
            $get_document['topic'] = $this->input->post('topic');							
		}
																
        $get_document['document_link'] = $file_name;							
        
		if($this->input->post('document_date')){														
            $get_document['document_date'] = $this->input->post('document_date');							
        }
		if($this->input->post('status')){														
            $get_document['status'] = $this->input->post('status');							
		}
		if($this->input->post('note')){														
            $get_document['note'] = $this->input->post('note');							
        }				
		$this->db->trans_start();
		$this->db->insert('documentation',$get_document);
		$this->db->trans_complete();
		if($this->db->trans_status()==FALSE){
			return false;
		}
        else{
            return true;
        }
	}	
}