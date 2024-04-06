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
		$this->db->group_by('document_link');

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
	// Method to update patient metadata
	function update_document_metadata($file_name, $edit_note){
		$multiClause = array('patient_id' => $this->input->post('edit_patient_id'), 'document_link' => $this->input->post('edit_document_link'), 'id' => $this->input->post('edit_record_id') );
		$this->db->set('document_date', $this->input->post('document_date'));
		$this->db->set('document_type_id', $this->input->post('document_type'));
		$this->db->set('note', $edit_note);
		$this->db->set('document_link', $file_name);
		$this->db->set('update_by_staff_id', $this->session->userdata('logged_in')['staff_id']);
		$this->db->set('update_datetime', date("Y-m-d H:i:s"));
		$this->db->where($multiClause);
		$this->db->update('patient_document_upload'); 

	}
	// Method to add patient documents	
	function add_document($patient_id, $file_name){
        // Document names are unique. Do not add documents with same name
		$this->db->where('patient_id',$patient_id);
		$this->db->where('document_link',$file_name);
		$this->db->select("id, patient_id, document_link", false);
		$this->db->from('patient_document_upload');
		
		$query=$this->db->get();
		if($query->num_rows()>0)
		{
			return false;
		}

		// Add the new document
		$document = array();	
		$document['patient_id']=$patient_id;															
		if($this->input->post('document_date')){														
            $document['document_date'] = $this->input->post('document_date');							
        }else {
        $document['document_date'] = date("Y-m-d");
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

		// Fetch document details before deleting it and make entry in removed_patient_document_upload table
		$this->db->select("id, patient_id, document_date, document_type_id, note, document_link, insert_datetime, insert_by_staff_id, update_datetime, update_by_staff_id", false);
		$this->db->from('patient_document_upload');
		$this->db->where('patient_id',$patient_id);		
		$this->db->where('document_link',$document_link);
		$query = $this->db->get();
		$result = $query->row();
		$affected_rows = 0;
		if (!!$result){
			$document['id'] = $result->id;
			$document['document_date'] = $result->document_date;
			$document['document_type_id'] = $result->document_type_id;
			$document['note'] = $result->note;
			$document['insert_datetime'] = $result->insert_datetime;
			$document['insert_by_staff_id'] = $result->insert_by_staff_id;
			$document['update_datetime'] = $result->update_datetime;
			$document['update_by_staff_id'] = $result->update_by_staff_id;
			$document['patient_id'] = $patient_id;
			$document['document_link'] = $document_link;
			$document['removed_by_staff_id'] = $this->session->userdata('logged_in')['staff_id'];
			$document['removed_datetime'] = date("Y-m-d H:i:s");
			$this->db->trans_start();
			$this->db->insert('removed_patient_document_upload',$document);
			$this->db->trans_complete();

			// Delete the record
			$delete_record = array(
           			 'patient_id' => $patient_id,
            			'document_link' => $document_link
       		 );

			$this->db->delete('patient_document_upload',$delete_record);
			$affected_rows = $this->db->affected_rows();
		}
		return $affected_rows;
	}
}
