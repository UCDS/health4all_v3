<?php 
class Common_Page_Model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	
	function upsert_form($table, $pk, $fields, $saveHospitalId=true){
        $data=array();

        foreach ($fields as $field) {
            $data[$field] = $this->input->post($field);
        }

        if($saveHospitalId){
            $hospital = $this->session->userdata('hospital');
            $data['hospital_id'] = $hospital['hospital_id'];
        }

		$this->db->trans_start(); //Transaction starts
        if($isEdit){
            $this->db->where($pk, $this->input->post($pk));
            $this->db->update($table, $data);
		} else {
            $this->db->insert($table, $data);	
        }
        $this->db->trans_complete();
        if($this->db->trans_status()==FALSE){
            return false;
        }
		return true;
    }
}
?>
