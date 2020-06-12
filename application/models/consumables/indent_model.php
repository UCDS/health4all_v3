<?php
class Indent_model extends CI_Model {
    
    function __construct() {
        parent::__construct();
    }		//end of constructor.
	//this method is used to insert data into indent and indent item tables and return post values into array which is in controller.
    function add_indent(){
		 $hospital=$this->session->userdata('hospital');
		  $user_data=$this->session->userdata('logged_in');
		  $this->db->select('staff_id')->from('user')
		  ->where('user.user_id',$user_data['user_id']);
		  $query=$this->db->get();
		  $staff=$query->row();
		
		$call_date = date("Y-m-d H:i:s");
        $order= array();
       
        if($this->input->post('from_id')){
            $order['from_id'] = $this->input->post('from_id');
        }
         if($this->input->post('to_id')){
            $order['to_id'] = $this->input->post('to_id');
        }
		$auto_indent=$this->input->post('auto_indent');
		if($auto_indent){
		$order['indent_status']='Issued';
		$order['hospital_id']=$hospital['hospital_id'];
		$order['orderby_id']=$staff->staff_id;
		$order['approver_id']=$staff->staff_id;
		$order['issuer_id']=$staff->staff_id;
		$order['indent_date']=$call_date;
		$order['approve_date_time']=$call_date;
		$order['issue_date_time']=$call_date;
		} else {
			$order['indent_date']=$call_date;
		$order['indent_status']='Indented';
		$order['hospital_id']=$hospital['hospital_id'];
		$order['orderby_id']=$staff->staff_id;
		}
		$this->db->trans_start();
        $this->db->insert('indent', $order);
        $indent_id = $this->db->insert_id();
            
        $get_item=array();
		$item=$this->input->post('item');
		
		$quantity_indented=$this->input->post('quantity_indented'); 
		$row_count=count($item); 
		for($i=0;$i<$row_count;$i++){
			if($auto_indent){
			$get_item[]=array(
				'item_id'=>$item[$i],
				'quantity_indented'=>$quantity_indented[$i],
				'quantity_approved'=>$quantity_indented[$i],
				'quantity_issued'=>$quantity_indented[$i],
				'indent_status' => 'Issued',
				'indent_id' => $indent_id
				
			);
			}else{
				$get_item[]=array(
				'item_id'=>$item[$i],
			    'quantity_indented'=>$quantity_indented[$i],
				'indent_status' => 'Indented',
				'indent_id' => $indent_id
				);
			}
		}
        $this->db->insert_batch('indent_item' ,$get_item);
        $this->db->trans_complete();
        if($this->db->trans_status()==FALSE){
				$this->db->trans_rollback();
                return false;
        }
        else{
			$this->db->select('hospital.hospital,dosage.dosage,dosage.dosage_unit,item_form.item_form,item_type.item_type,indent.indent_id,indent.indent_status,indent_date,item_name,quantity_indented,from_party.supply_chain_party_name from_party_name,to_party.supply_chain_party_name to_party_name,staff.first_name,staff.last_name')
		->from('indent')
		->join('indent_item','indent.indent_id=indent_item.indent_id','left')
		->join('item','item.item_id=indent_item.item_id','left')
		->join('item_form','item_form.item_form_id=item.item_form_id','left')
		->join('dosage','dosage.dosage_id=item.dosage_id','left')
		->join('generic_item','item.generic_item_id=generic_item.generic_item_id','left')
		->join('item_type','generic_item.item_type_id=item_type.item_type_id','left')
		->join('supply_chain_party to_party','indent.to_id = to_party.supply_chain_party_id','left')
		->join('supply_chain_party from_party','indent.from_id = from_party.supply_chain_party_id','left')
		->join('hospital','hospital.hospital_id=indent.hospital_id','left')
		->join('staff','staff.staff_id=indent.orderby_id','left')
		 ->where('indent.hospital_id',$hospital['hospital_id'])
		->where('indent.indent_id',$indent_id);
						$query=$this->db->get();
						return $query->result();
		
        }
    }
	//This is a method used to retreive data from supply_chain_party,item tables depend upon type.
    function get_supply_chain_party($type=""){
		if($type=="party")
		$this->db->select("supply_chain_party_id,supply_chain_party_name")->from("supply_chain_party");
		else if($type=="item")
		$this->db->select('item.item_name,item.item_id,item_form.item_form_id,item_form.item_form,item_type.item_type,dosage.dosage,dosage.dosage_unit')
		->from("item")
		->join('item_form','item_form.item_form_id=item.item_form_id','left')
		->join('generic_item','generic_item.generic_item_id=item.generic_item_id','left')
		->join('item_type','item_type.item_type_id=generic_item.item_type_id','left')
		->join('dosage','dosage.dosage_id=item.dosage_id','left');
		$query=$this->db->get();
		return $query->result();
	}
}
