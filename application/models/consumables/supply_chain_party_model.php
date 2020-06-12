<?php
class Supply_chain_party_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }
    function add_supply_chain_party(){
		$hospital=$this->session->userdata('hospital');
        $supply_chain = array();
        if($this->input->post('supply_chain_party_name')){
            $supply_chain['supply_chain_party_name'] = $this->input->post('supply_chain_party_name');
        }
        if($this->input->post('hospital')){
            $supply_chain['hospital_id'] = $this->input->post('hospital');
        }
         if($this->input->post('department')){
            $supply_chain['department_id'] = $this->input->post('department');
        }
         if($this->input->post('area')){
            $supply_chain['area_id'] = $this->input->post('area');
        }
        if($this->input->post('vendor')){
			$supply_chain['vendor_id'] = $this->input->post('vendor');			    
        }
		$supply_chain['hospital_id']=$hospital['hospital_id'];
        $this->db->trans_start();
        $this->db->insert('supply_chain_party', $supply_chain);
        $this->db->trans_complete();
        if($this->db->trans_status()==FALSE){
                return false;
        }
        else{
                return true;
        }
    }
    function get_area($type=""){
		if($type=="area")
		$this->db->select("*")->from("area");
		else if($type=="vendor")
		$this->db->select("*")->from("vendor");
		else if($type=="department")
		$this->db->select("*")->from("department");
		$query=$this->db->get();
		return $query->result();
	}
}
