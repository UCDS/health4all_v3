<?php
class Indent_issue_model extends CI_Model{                                                             //create a model class with name indent_issue_model which extends CI_model.
	function __construct() {                                                                           //constructor definition.
        parent::__construct();                                                                         //calling code igniter (parent) constructor.
  	}//constructor
    function get_approved_indents(){                                                                   //definition of a function to get_approved_details
	    $hospital=$this->session->userdata('hospital');                                                //Storing user data who logged into the hospital into a var:hospital
        $indent=$this->session->userdata('indent');                                                    //Storing user data who logged into indent into a var:indent
		if($this->input->post('from_date') && $this->input->post('to_date')){                          //checking whether from and to dates which we get from user are valid or not
			$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));                       //get from date from the user with input->post method and store it into a var:from_date
			$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));                           //get to date from the user with input->post method and store it into a var:to_date
		} 
		else if($this->input->post('from_date') || $this->input->post('to_date')){                     //checking whether any one of them(from date or to date) are valid
			$this->input->post('from_date')?$from_date=$this->input->post('from_date'):$from_date=$this->input->post('to_date');  //if from_date valid it will be stored else to_date will be stored
			$to_date=$from_date;                                                                       //to_date is same as from_date
		}
		else{                                                      
			$from_date=date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) ); //by default setting from_date as 1 month back
			$to_date=date("Y-m-d");                                                                           //by default setting to date as current date
		}
		if($this->input->post('auto_indent')!=1){
		if($this->input->post('item_type')){                                                            //all the below four if conditions are about checking and getting the particular values from user 
			$this->db->where('item_type.item_type_id',$this->input->post('item_type'));
		}
		if($this->input->post('item')){
			$this->db->where_in('item.item_id',$this->input->post('item'));
		}
		    if($this->input->post('from_id')){
			    $this->db->where('from_party.supply_chain_party_id',$this->input->post('from_id'));
		    }
		    if($this->input->post('to_id')){
			    $this->db->where('to_party.supply_chain_party_id',$this->input->post('to_id'));
		    }  
		}
	    $this->db->select('indent.approve_date_time,item_type.item_type_id,indent_item.quantity_approved,indent.*,item_type,item_name,from_party.supply_chain_party_name from_party,to_party.supply_chain_party_name to_party')->from('indent')
	    ->join('indent_item','indent.indent_id=indent_item.indent_id','left')
		->join('item','item.item_id=indent_item.item_id','left')
        ->join('generic_item','item.generic_item_id=generic_item.generic_item_id','left')                //This is the select statement which joins all the tables (indent,indent_item,item,generic_item,
		->join('item_type','generic_item.item_type_id=item_type.item_type_id','left')                    //item_type,supply_chain_party) and getting required field values
	    ->join('supply_chain_party to_party','indent.to_id =to_party.supply_chain_party_id ','left')
	    ->join('supply_chain_party from_party','indent.from_id = from_party.supply_chain_party_id','left')
	    ->where('indent.hospital_id',$hospital['hospital_id'])
	    ->group_by('indent_id')
	    ->order_by('indent_date','desc');
	    $this->db->where("(DATE(indent_date) BETWEEN '$from_date' AND '$to_date' )");                        //here where condition is for only displaying orders between from_date and to_date
	    $this->db->where('indent.indent_status','Approved');                                           //here it is  for displaying  those orders which has status as Approved
	    if($this->input->post('indent_id')){
		    $this->db->where('indent.indent_id',$this->input->post('indent_id'));
	    }
		
		$query=$this->db->get();
	  	return $query->result();   
    }//get_approved_indents
   
	function display_issue_details(){                                                              //definition of a function :display_issue_details
		$hospital=$this->session->userdata('hospital');                                            //Storing user data who logged into the hospital into a var:hospital
		$this->db->select('quantity_approved,indent.approve_date_time,indent_item.indent_item_id,indent_item.quantity_approved,indent.indent_id,indent.issuer_id,indent.issue_date_time,hospital.hospital,item_type,item_form,dosage_unit,dosage,from_party.supply_chain_party_name from_party,to_party.supply_chain_party_name to_party,orderby.first_name as order_first,orderby.last_name as order_last,approve.first_name as approve_first,approve.last_name as approve_last,issue.first_name as issue_first,issue.last_name as issue_last,item_name,indent_item.quantity_issued,indent.indent_status')->from('indent')
		->join('indent_item','indent.indent_id = indent_item.indent_id' ,'left')
		->join('item','item.item_id=indent_item.item_id','left')                                   //this is the select query to get field values by joining all the  tables(indent,indent_item,item,generic_item,
		->join('generic_item','item.generic_item_id=generic_item.generic_item_id','left')          //item_type,item_form,dosage,supply_chain_party,staff,hospital)
		->join('item_type','generic_item.item_type_id=item_type.item_type_id','left')
		->join('item_form','item.item_form_id=item_form.item_form_id','left')
		->join('dosage','item.dosage_id=dosage.dosage_id','left')
		->join('supply_chain_party  to_party','indent.to_id =to_party.supply_chain_party_id ','left')
		->join('supply_chain_party  from_party','indent.from_id = from_party.supply_chain_party_id','left')
		->join('hospital','indent.hospital_id = hospital.hospital_id','left')
		->join('staff orderby','indent.orderby_id= orderby.staff_id','left')
		->join('staff approve','indent.approver_id= approve.staff_id','left')
		->join('staff issue','indent.issuer_id= issue.staff_id','left');
		if($this->input->post('selected_indent_id')){
			$this->db->where('indent.indent_id',$this->input->post('selected_indent_id'));
		}
	    $query=$this->db->get();
		return $query->result();   
	}//display_issue_details

    function get_supply_chain_party($type=""){                                                                  //function definition with name :get_data
	    if($type=="item_type")                                                                    //all these are if conditions to select particular data from database
			$this->db->select("*")->from("item_type")->order_by('item_type');
		else if($type=="item")
			$this->db->select('item.item_name,item_type.item_type_id,item.item_id,item_form.item_form_id,item_form.item_form,item_type.item_type,dosage.dosage,dosage.dosage_unit')
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
    
	function issue_indent(){                                                                      //function definition with name:issue_indent
		$user_data=$this->session->userdata('logged_in');                                         //get user data and store it in a var:user_data
		$this->db->select('staff_id')->from('user')                                               //select  staff_id of the particular user who logged in
		->where('user.user_id',$user_data['user_id']);
		$query=$this->db->get();
		$staff=$query->row();
		if($this->input->post('indent_item')){                                                    //indent_item is an array which contains indent_item_id values and checking whether it is valid or not
		    $data = array();                                                                      //declaring an array with name data
			foreach($this->input->post('indent_item') as $i){                                     //foreach loop for storing indent_item_id,issued quantity,indent status into data array
				$data[]=array(
					'indent_item_id'=>$i,
					'quantity_issued'=>$this->input->post('quantity_issued_'.$i),
					'indent_status'=>"Issued"
				);
			}
			$data_d=array(                                                                          //Set indent_status as Issued in indent table
				'indent_status'=>'Issued'
			);
			$array=array(                                                                           //get staff_id in an array
                    'issuer_id'=>$staff->staff_id
			);
			$call_date = date("Y-m-d H:i:s");
			$this->db->trans_start();
			$this->db->update_batch('indent_item',$data,'indent_item_id');                         //all these are update queries to store values in arrays into database
		    $this->db->where('indent_id', $this->input->post('indent'));
            $this->db->update('indent', $data_d); 
			$date_time = array ( "issue_date_time" => $call_date, ); 
			$this->db->where('indent_id', $this->input->post('indent'));
            $this->db->update('indent', $date_time);
		    $this->db->where('indent_id', $this->input->post('indent'));
            $this->db->update('indent', $array);
		    $this->db->trans_complete();                                                   
            if($this->db->trans_status()==FALSE){                                          
                return false;
            }//if
             else{
                return true;
            }//else			
		}//end_if
	}//issue_indent
}//indent_issue_model


	


		