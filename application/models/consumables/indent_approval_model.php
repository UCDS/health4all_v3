<?php
class Indent_approval_model extends CI_Model {                                                        //create a model class with name :Indent_approval_model which extends CogeIgniter model                                   
	function __construct() {                                                                          //constructor definition
        parent::__construct();                                                                        //calling CodeIgniter (parent) constructor
  	}//constructor
    function get_indents(){                                                                           //definition of a function with name:get_indents
	    $hospital=$this->session->userdata('hospital');                                               //Storing user data who logged into the hospital into a var:hospital
		if($this->input->post('from_date') && $this->input->post('to_date')){                         //checking whether from and to dates which we get from user are valid or not
			$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));                      //get from date from the user with input->post method and store it into a var:from_date
			$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));                          //get to date from the user with input->post method and store it into a var:to_date
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){                    //checking whether any one of them(from date or to date) are valid
			$this->input->post('from_date')?$from_date=$this->input->post('from_date'):$from_date=$this->input->post('to_date');  //if from_date valid it will be stored else to_date will be stored
			$to_date=$from_date;                                                                      //to_date is same as from_date
		} 
		else{
			$from_date=date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) );  //by default setting from_date as 1 month back
			$to_date=date("Y-m-d");                                                                   //by default setting to date as current date
		}
		if($this->input->post('item_type')){                                                          //all the below four if conditions are about checking and getting the particular values from user 
			$this->db->where('item_type.item_type_id',$this->input->post('item_type'));               
		}
		if($this->input->post('item')){
			$this->db->where('item.item_id',$this->input->post('item'));
		}
		if($this->input->post('from_id')){
			$this->db->where('from_party.supply_chain_party_id',$this->input->post('from_id'));
		}
		if($this->input->post('to_id')){
			$this->db->where('to_party.supply_chain_party_id',$this->input->post('to_id'));
		}  
	    $this->db->select('indent.*,item_type.item_type_id,item_type,item_form,dosage_unit,dosage,item_name,from_party.supply_chain_party_name from_party,to_party.supply_chain_party_name to_party')->from('indent')
	    ->join('indent_item','indent.indent_id=indent_item.indent_id','left')
		->join('item','item.item_id=indent_item.item_id','left')                                        //This is the select statement which joins all the tables (indent,indent_item,item,generic_item,
        ->join('generic_item','item.generic_item_id=generic_item.generic_item_id','left')               //item_type,item_form,dosage,supply_chain_party) and getting required field values
		->join('item_type','generic_item.item_type_id=item_type.item_type_id','left')
		->join('item_form','item.item_form_id=item_form.item_form_id','left')
		->join('dosage','item.dosage_id=dosage.dosage_id','left')
	    ->join('supply_chain_party to_party','indent.to_id =to_party.supply_chain_party_id ','left')
	    ->join('supply_chain_party from_party','indent.from_id = from_party.supply_chain_party_id','left')
	    ->where('indent.hospital_id',$hospital['hospital_id'])
	    ->group_by('indent_id')
	    ->order_by('indent_date','desc')
	    ->where("(DATE(indent_date) BETWEEN '$from_date' AND '$to_date' )");                                   //here where condition is for only displaying orders between from_date and to_date
	    $this->db->where('indent.indent_status','Indented');                                             //here it is  for displaying  those orders which has status as indented
	    if($this->input->post('indent_id')){
			$this->db->where('indent.indent_id',$this->input->post('indent_id'));
	    }
        $query=$this->db->get();
	    return $query->result();   
    }//get_indents
	
	function display_approve_details(){                                                                       //definition of a function :display_approve_details
		$hospital=$this->session->userdata('hospital'); 	                                                  //Storing user data who logged into the hospital into a var:hospital
		$this->db->select('indent.indent_status,indent_item.indent_item_id,indent.indent_date,indent_item.quantity_indented,indent.indent_id,indent.approver_id,indent.approve_date_time,hospital.hospital,item_type,item_form,dosage_unit,dosage,from_party.supply_chain_party_name from_party,to_party.supply_chain_party_name to_party ,orderby.first_name as order_first,orderby.last_name as order_last,approve.first_name as approve_first,approve.last_name as approve_last,item_name,indent_item.quantity_approved,indent_item.indent_status')->from('indent')
		->join('indent_item','indent.indent_id = indent_item.indent_id' ,'left')
		->join('item','item.item_id=indent_item.item_id','left')                                              //this is the select query to get field values by joining all the  tables(indent,indent_item,item,generic_item,
		->join('generic_item','item.generic_item_id=generic_item.generic_item_id','left')                     //item_type,item_form,dosage,supply_chain_party,staff,hospital)
		->join('item_type','generic_item.item_type_id=item_type.item_type_id','left')
		->join('item_form','item.item_form_id=item_form.item_form_id','left')
		->join('dosage','item.dosage_id=dosage.dosage_id','left')
		->join('supply_chain_party  to_party','indent.to_id =to_party.supply_chain_party_id ','left')
		->join('supply_chain_party  from_party','indent.from_id = from_party.supply_chain_party_id','left')
		->join('hospital','indent.hospital_id = hospital.hospital_id','left')
		->join('staff orderby','indent.orderby_id= orderby.staff_id','left')
		->join('staff approve','indent.approver_id=approve.staff_id','left');
		if($this->input->post('selected_indent_id')){
			$this->db->where('indent.indent_id',$this->input->post('selected_indent_id'));
		}
		$query=$this->db->get();
		return $query->result();   
	}//display_approve_details
	
	 function get_supply_chain_party($type=""){                                                                            //function definition with name :get_data
	    if($type=="item_type")                                                                               //all these are if conditions to select particular data from database
		$this->db->select("*")->from("item_type")->order_by('item_type');
		else if($type=="item")
		  $this->db->select('item.item_name,item.item_id,item_form.item_form_id,item_form.item_form,item_type.item_type_id,item_type.item_type,dosage.dosage,dosage.dosage_unit')
		->from("item")
		->join('item_form','item_form.item_form_id=item.item_form_id','left')
		->join('generic_item','generic_item.generic_item_id=item.generic_item_id','left')
		->join('item_type','item_type.item_type_id=generic_item.item_type_id','left')
		->join('dosage','dosage.dosage_id=item.dosage_id','left');
		else if($type=="party")
		$this->db->select("supply_chain_party_id,supply_chain_party_name")->from("supply_chain_party")->order_by('supply_chain_party_name');
		$resource=$this->db->get();
		return $resource->result();
	}//get_data
    
	function approve_indent(){                                                                               //function definition with name:approve_indent
		$user_data=$this->session->userdata('logged_in');                                                    //get user data and store it in a var:user_data
		$this->db->select('staff_id')->from('user')                                                          //select  staff_id of the particular user who logged in
		->where('user.user_id',$user_data['user_id']);
		$query=$this->db->get();
		$staff=$query->row();

		if($this->input->post('indent_item')){                                                               //indent_item is an array which contains indent_item_id values and checking whether it is valid or not
		    $data = array();                                                                                 //declaring an array with name data
			foreach($this->input->post('indent_item') as $i){                                                //foreach loop for storing indent_item_id,approved quantity,indent status into data array
				$data[]=array(
					'indent_item_id'=>$i,
					'quantity_approved'=>$this->input->post('quantity_approved_'.$i),
					'indent_status'=>$this->input->post('indent_status_'.$i),
					
				);
			}
			$approve=0;
			foreach($this->input->post('indent_item') as $i){                                                //this foreach loop is for checking whether atleast one item in total order has approved or not
				if($this->input->post('indent_status_'.$i)=='Approved')                                      
					$approve++;
			}
			if($approve==0){                                                                                 //if approve value still 0 means there is no single item which is approved
				$data_d=array(
				'indent_status'=>'Rejected'                                                                  //set status as 'Rejected'
			);
			}else{
			$data_d=array(
				'indent_status'=>'Approved'                                                                   //set status as 'Approved'
			);
			}
			$array_d=array(
                    'approver_id'=>$staff->staff_id                                                           //get staff_id in an array
			);
				$call_date = date("Y-m-d H:i:s");
				$date_time = array ( "approve_date_time" => $call_date, ); 
			$this->db->trans_start();
			$this->db->update_batch('indent_item',$data,'indent_item_id');                                     //all these are update queries to store values in arrays into database
		    $this->db->where('indent_id', $this->input->post('indent'));
            $this->db->update('indent', $data_d); 
			$this->db->where('indent_id', $this->input->post('indent'));
           $this->db->update('indent', $date_time);
		   $this->db->where('indent_id', $this->input->post('indent'));
           $this->db->update('indent', $array_d);
		    $this->db->trans_complete();                                               
            if($approve==0){                                                                                   //if there is no item in order whose status is approved then return 0 else return 1
				return 0;
			}
			else{
				return 1;
			}//else
			
		
		}//end_if
	}//approve_indent
}//indent_approval model


	


		