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

            $supply_chain['is_external'] = $this->input->post('int_ext');			    
            
            if ($supply_chain['is_external']==1) { //Internal
		    $supply_chain['vendor_id']=0;	
	    }

	    if ($supply_chain['is_external']==2) { //Extrnal
		    $supply_chain['department_id']=0;
		    $supply_chain['area_id']=0;
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

    function edit_scp($scp_id)
    {
		$hospital=$this->session->userdata('hospital');
        $edit_supply_chain = array();
        $this->db->where('supply_chain_party_id', $scp_id);
        if($this->input->post('supply_chain_party_name')){
            $edit_supply_chain['supply_chain_party_name'] = $this->input->post('supply_chain_party_name');
        }
        if($this->input->post('department')){
            $edit_supply_chain['department_id'] = $this->input->post('department');
        }
        if($this->input->post('area')){
            $edit_supply_chain['area_id'] = $this->input->post('area');
        }
        if($this->input->post('vendor')){
            $edit_supply_chain['vendor_id'] = $this->input->post('vendor');			    
        }
        if($this->input->post('int_ext')){
            $edit_supply_chain['is_external'] = $this->input->post('int_ext');			    
	}
	if ($edit_supply_chain['is_external']==1) { //Internal
	    $edit_supply_chain['vendor_id']=0;
	}

	if ($supply_chain['is_external']==2) { //Extrnal
            $edit_supply_chain['department_id']=0;
	    $edit_supply_chain['area_id']=0;
	}
	
	$edit_supply_chain['hospital_id']=$hospital['hospital_id'];
        $this->db->trans_start();
        $this->db->update('supply_chain_party', $edit_supply_chain);
        $this->db->trans_complete();
        if($this->db->trans_status()==FALSE){
                return false;
        }else{
                return true;
        }
    }

    function get_scp_parties($default_rowsperpage)
    {
        if ($this->input->post('page_no')) {
			$page_no = $this->input->post('page_no');
		}
		else{
			$page_no = 1;
		}
		if($this->input->post('rows_per_page')) {
			$rows_per_page = $this->input->post('rows_per_page');
		}
		else{
			$rows_per_page = $default_rowsperpage;
		}
		$start = ($page_no -1 )  * $rows_per_page;

		if ($default_rowsperpage !=0){
			$this->db->limit($rows_per_page,$start);
		}
        
        $hospital=$this->session->userdata('hospital');   
        $this->db->select('scp.supply_chain_party_id, scp.supply_chain_party_name, department.department, vendor.vendor_name, area.area_name,scp.is_external')
        ->from('supply_chain_party scp')
        ->join('area', 'area.area_id = scp.area_id', 'left')
        ->join('vendor', 'vendor.vendor_id = scp.vendor_id', 'left')
        ->join('department', 'department.department_id = scp.department_id', 'left')
        ->where('scp.hospital_id', $hospital['hospital_id']);

            if($this->input->post('int_ext')){
                $this->db->where('scp.is_external', $this->input->post('int_ext'));
            }
            if($this->input->post('department')){
                $this->db->where('department.department_id', $this->input->post('department'));
            }
            if($this->input->post('area')){
                $this->db->where('area.area_id', $this->input->post('area'));
            }
        
            if($this->input->post('vendor')){
                $this->db->where('vendor.vendor_id', $this->input->post('vendor'));
            }
            
        $query = $this->db->get();
        $query_string = $this->db->last_query();
        return $query->result();
    }

    function get_scp_parties_count()
    {
       
        $hospital=$this->session->userdata('hospital');   
        $this->db->select('count(*) as count',false)
        ->from('supply_chain_party scp')
        ->join('area', 'area.area_id = scp.area_id', 'left')
        ->join('vendor', 'vendor.vendor_id = scp.vendor_id', 'left')
        ->join('department', 'department.department_id = scp.department_id', 'left')
        ->where('scp.hospital_id', $hospital['hospital_id']);

            if($this->input->post('int_ext')){
                $this->db->where('scp.is_external', $this->input->post('int_ext'));
            }
            if($this->input->post('department')){
                $this->db->where('department.department_id', $this->input->post('department'));
            }
            if($this->input->post('area')){
                $this->db->where('area.area_id', $this->input->post('area'));
            }
        
            if($this->input->post('vendor')){
                $this->db->where('vendor.vendor_id', $this->input->post('vendor'));
            }
           
        $query = $this->db->get();
        return $query->result();
    }

    function get_scp($scp_id)
    {
      $hospital=$this->session->userdata('hospital');   
      $this->db->select('scp.supply_chain_party_id, scp.supply_chain_party_name, scp.department_id, scp.area_id, scp.vendor_id,scp.is_external')
      ->from('supply_chain_party scp')
      ->where('scp.hospital_id', $hospital['hospital_id'])
      ->where('scp.supply_chain_party_id', $scp_id);

      $query = $this->db->get();
      return $query->result();
    }

    function check_if_exists($type="", $id)
    {
        $hospital=$this->session->userdata('hospital');   
        if($type == "area")
            $this->db->select("area_id")->from("area")->where("area_id", $id);
        else if($type == "vendor")
            $this->db->select("vendor_id")->from("vendor")->where("vendor_id", $id);
        else if($type == "department")
            $this->db->select("department_id")->from("department")->where("department_id", $id)->where('hospital_id', $hospital['hospital_id']);
        
        $query = $this->db->get();
        return $query->result();
    }

    function is_scp_unique($scp_name)
    {
        $hospital=$this->session->userdata('hospital');   
        $this->db->select("supply_chain_party_name")
        ->from("supply_chain_party")->where("supply_chain_party_name", $scp_name)
        ->where('hospital_id', $hospital['hospital_id']);

        $query = $this->db->get();
        return (count($query->result()) === 0);
    }

    function get_area($type=""){
        $hospital=$this->session->userdata('hospital');   
		if($type=="area")
		$this->db->select("*")->from("area")->order_by('area_name', 'ASC');
		else if($type=="vendor")
		$this->db->select("*")->from("vendor")->order_by('vendor_name', 'ASC');
		else if($type=="department")
		$this->db->select("*")->from("department")->where('hospital_id', $hospital['hospital_id'])->order_by('department', 'ASC');
		$query=$this->db->get();
		return $query->result();
	}
}
