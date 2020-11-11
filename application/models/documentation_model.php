<?php
class documentation_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	// Method to fetch documentation records
	function get_documentation(){
		$hospital=$this->session->userdata('hospital');
	
		$this->db->select("id, keyword, topic, document_link, document_date, document_created_by, video_link, video_date, documentation.status, note, CONCAT(creator.first_name, ' ', creator.last_name) as creator, CONCAT(modifier.first_name, ' ', modifier.last_name) as modifier, insert_datetime, update_datetime", false);
		$this->db->from('documentation')
		->join('staff as creator','documentation.insert_by_staff_id=creator.staff_id','left')
		->join('staff as modifier','documentation.update_by_staff_id=modifier.staff_id','left');

        $this->db->where('documentation.status', 1);

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
		$get_document['insert_by_staff_id'] = $this->session->userdata('logged_in')['staff_id'];
		$get_document['insert_datetime'] = date("Y-m-d H:i:s");
		
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

	// Method to fetch documentation records
	function get_document_record($id){
		$hospital=$this->session->userdata('hospital');
	
		$this->db->select("id, keyword, topic, document_link, document_date, document_created_by, video_link, video_date, status, note");
        $this->db->from('documentation');
		$this->db->where('id',$id);

		$resource=$this->db->get();
		
		return $resource->result();
	}

	function update_document($document_id, $document_name){
        $document_info = array();
        if($this->input->post('id')){
            $document_info['id'] = $document_id;
        }
        if($this->input->post('keyword')){
            $document_info['keyword'] = $this->input->post('keyword');
        }
        if($this->input->post('topic')){
            $document_info['topic'] = $this->input->post('topic');
        }
        if($this->input->post('document_date')){
            $document_info['document_date'] = $this->input->post('document_date');
		}
        if($this->input->post('status')){
            $document_info['status'] = $this->input->post('status');
		}
        if($this->input->post('notes')){
            $document_info['notes'] = $this->input->post('notes');
		}
		$document_info['update_by_staff_id'] = $this->session->userdata('logged_in')['staff_id'];
		$document_info['update_datetime'] = date("Y-m-d H:i:s");

		$document_info['document_link'] = $document_name;						
        $this->db->trans_start();
        $this->db->where('id',$document_id);
        $this->db->update('documentation', $document_info);
        $this->db->trans_complete();
        if($this->db->trans_status()==FALSE){
                return false;
        }
        else{
                return true;
        } 
    }	

}