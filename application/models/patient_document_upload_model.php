<?php
class patient_document_upload_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}

	// Method to fetch patient documents
	function get_patient_documents($patient_id){
        if($patient_id!=0) //if the visit_id is true, select the patient where visit_id equals the given visit id
            $this->db->where('patient_visit.patient_id',$patient_id);
        else return false; 
	
		$this->db->select("id, patient_document_upload.patient_id, document_date, patient_document_upload.document_type_id, document_type, patient_document_upload.note, document_link, CONCAT(creator.first_name, ' ', creator.last_name) as creator, CONCAT(modifier.first_name, ' ', modifier.last_name) as modifier, patient_document_upload.insert_datetime, patient_document_upload.update_datetime", false);
        $this->db->from('patient_document_upload')
        ->join('patient_document_type', 'patient_document_upload.document_type_id=patient_document_type.document_type_id', 'left')
		->join('staff as creator','patient_document_upload.insert_by_staff_id=creator.staff_id','left')
        ->join('staff as modifier','patient_document_upload.update_by_staff_id=modifier.staff_id','left')
        ->join('patient_visit','patient_document_upload.patient_id=patient_visit.patient_id');

        $this->db->order_by('document_date', 'DESC');

		$resource=$this->db->get();
		
		return $resource->result();
    }
    
    function get_patient_document_type(){
	
		$this->db->select("document_type_id, document_type, note", false);
        $this->db->from('patient_document_type');

        $this->db->order_by('document_type', 'ASC');

		$resource=$this->db->get();
		
		return $resource->result();
	}

	// Method to add patient documents	
	function add_document($patient_id, $file_name){
		$document = array();	
		$document['patient_id']=$patient_id;															
		if($this->input->post('document_date')){														
            $document['document_date'] = $this->input->post('document_date');							
        }
		if($this->input->post('document_type')){														
            $document['document_type_id'] = $this->input->post('document_type');							
		}
																
        $document['document_link'] = $file_name;							
        
		if($this->input->post('document_date')){														
            $document['document_date'] = $this->input->post('document_date');							
        }
		if($this->input->post('note')){														
            $document['note'] = $this->input->post('note');							
		}
		$document['insert_by_staff_id'] = $this->session->userdata('logged_in')['staff_id'];
		$document['insert_datetime'] = date("Y-m-d H:i:s");
		
		$this->db->trans_start();
		$this->db->insert('patient_document_upload',$document);
		$this->db->trans_complete();
		if($this->db->trans_status()==FALSE){
			return false;
		}
        else{
            return true;
        }		
	}

	function delete_document($patient_id, $document_link){
		$delete_record = array(
            'patient_id' => $patient_id,
            'document_link' => $document_link
        );

		$this->db->delete('patient_document_upload',$delete_record);
		$affected_rows = $this->db->affected_rows();
        
        return $affected_rows;
	}
}