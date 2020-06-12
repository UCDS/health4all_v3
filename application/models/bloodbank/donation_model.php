<?php

class Donation_Model extends CI_Model{
   
   function __construct() {
       parent::__construct();
   }
   
   function get_donation(){
       
		$hospital=$this->session->userdata('hospital');
		$hospital_id=$hospital['hospital_id'];
		
		$blood_unit_num = "";
		
		if($this->input->post('blood_unit_num')){
			$blood_unit_num = $this->input->post('blood_unit_num');
		}else{
			return false;
		}
       
		$this->db->select('bb_donation.blood_unit_num, bb_donation.segment_num, bb_donation.bag_type, '
               . 'bb_donation.donation_date, bb_donation.donation_time, bb_donation.collected_by, bb_donation.camp_id, bb_donation.status_id,'
               . 'blood_donor.name, blood_donor.phone, blood_donor.email, blood_grouping.*, '
               . 'blood_screening.*,'
               . 'blood_inventory.volume, blood_inventory.status_id as inv_status_id')
            ->from('bb_donation')
            ->join('blood_donor','bb_donation.donor_id = blood_donor.donor_id','left')
            ->join('blood_inventory','bb_donation.donation_id = blood_inventory.donation_id','left')
            ->join('blood_grouping','bb_donation.donation_id = blood_grouping.donation_id','left')
            ->join('blood_screening','bb_donation.donation_id = blood_screening.donation_id','left')
            ->where('bb_donation.blood_unit_num', $blood_unit_num)
            ->where('bb_donation.status_id <','7')
            ->where('blood_inventory.status_id <=','7')
            ->where('MONTH(bb_donation.donation_date) - MONTH(NOW()) < 3')
			/**
			 * Multi hospital support
			 * 
			 * Added By : Pranay On 20170521
			 */
            ->where('bb_donation.hospital_id', $hospital_id);
       
       $query = $this->db->get();
      
       $result = $query->result();
       if($result){
        return $result[0];       
       }else{
           return false;
       }
   }
   
   function update_blood_bag_info(){
		
        $this->db->select('bb_donation.donation_id, bb_donation.blood_unit_num, bb_donation.segment_num, bb_donation.bag_type, bb_donation.camp_id, blood_inventory.volume')
               ->from('bb_donation')
               ->join('blood_inventory','bb_donation.donation_id = blood_inventory.donation_id')
               ->where('bb_donation.donation_id',$this->input->post('donation_id'));
       
        $query = $this->db->get();
        
        $result = $query->result();
       
        $log = 'Update Blood Bag Info-'.$result[0]->donation_id.'-'
               .$result[0]->blood_unit_num.'-'
               .$result[0]->segment_num.'-'
               .$result[0]->bag_type.'-'
               .$result[0]->volume.'-'
               .$result[0]->camp_id;
        $staff_id = $this->session->userdata('staff_id');
       
        $data_trail = array(
           'trail' => $log,
           'staff_id' => $staff_id
        );
       
        $blood_bag_data = array(
            'blood_unit_num' => $this->input->post('blood_unit_num'),
            'segment_num' => $this->input->post('segment_num'),
            'bag_type' => $this->input->post('bag_type'),
            'camp_id' => $this->input->post('camp_id')
        );
       
        $blood_inventory = array(
           'volume' => $this->input->post('volume')
        );
       
        $this->db->trans_start();
        $this->db->insert('bloodbank_edit_log', $data_trail);
		
        $this->db->where('donation_id', $this->input->post('donation_id'));
		$this->db->update('bb_donation', $blood_bag_data);
		
		
        $this->db->where('donation_id', $this->input->post('donation_id'));
		$this->db->update('blood_inventory', $blood_inventory);
		
        $this->db->trans_complete();
        
        return $this->db->trans_status();
   }
   
   function update_blood_group_info(){
        $this->db->select('blood_grouping.*, blood_donor.donor_id')
               ->from('blood_grouping')
               ->join('bb_donation','blood_grouping.donation_id = bb_donation.donation_id')
               ->join('blood_donor','bb_donation.donor_id = blood_donor.donor_id')
               ->where('blood_grouping.donation_id',$this->input->post('donation_id'));
       
        $query = $this->db->get();
        //echo $this->db->last_query();
        $result = $query->result();
        $donor_id='';
        if($result){
            $log = 'Update Blood Bag Info-'.$result[0]->donation_id.'-'
                   .$result[0]->blood_group.'-'
                   .$result[0]->sub_group.'-'
                   .$result[0]->anti_a.'-'
                   .$result[0]->anti_b.'-'
                   .$result[0]->anti_ab.'-'
                   .$result[0]->anti_d.'-'
                   .$result[0]->a_cells.'-'
                   .$result[0]->b_cells.'-'
                   .$result[0]->o_cells.'-'
                   .$result[0]->du.'-';
                   
            $staff_id = $this->session->userdata('staff_id');
            $donor_id=$result[0]->donor_id;
            $data_trail = array(
               'trail' => $log,
               'staff_id' => $staff_id
            );            
        }else{
            return false;
        }     
        
        $blood_group=$this->input->post('blood_group');
        $sub_group=$this->input->post('sub_group');
        $anti_a=$this->input->post('anti_a');
        $anti_b=$this->input->post('anti_b');
        $anti_ab=$this->input->post('anti_ab');
        $anti_d=$this->input->post('anti_d');
        $a_cells=$this->input->post('a_cells');
        $b_cells=$this->input->post('b_cells');
        $o_cells=$this->input->post('o_cells');
        $du=$this->input->post('du');
        $blood_group_data = array();
        if($donor_id!='' && $blood_group !='' && $anti_a!='' && $anti_b!='' && $anti_ab!='' 
                && $anti_d!='' && $a_cells!='' && $b_cells!='' && $o_cells!='' && $du!=''){
             
            $blood_group_data['blood_group']= $blood_group;
            $blood_group_data['sub_group'] = $sub_group;
            $blood_group_data['anti_a'] = $anti_a;
            $blood_group_data['anti_b'] = $anti_b;
            $blood_group_data['anti_ab'] = $anti_ab;
            $blood_group_data['anti_d'] = $anti_d;
            $blood_group_data['a_cells'] = $a_cells;
            $blood_group_data['b_cells'] = $b_cells;
            $blood_group_data['o_cells'] = $o_cells;
            $blood_group_data['du'] = $du; 
        }
        $update_donor_info=array(
            'donor_id'=>$donor_id,
            'blood_group'=>$blood_group,
            'sub_group'=>$sub_group
        );        
        var_dump($blood_group_data);
        $this->db->trans_start();
        $this->db->insert('bloodbank_edit_log', $data_trail); 
        $this->db->where('donation_id', $this->input->post('donation_id'));
        $this->db->update('blood_grouping', $blood_group_data);
        $this->db->where('donor_id', $donor_id);
        $this->db->update('blood_donor',$update_donor_info);
        $this->db->trans_complete();
        
        return $this->db->trans_status();
   }
   
   function update_screening_info(){
        $donation_id = $this->input->post('donation_id');
        $this->db->select('blood_screening.screening_id, blood_screening.donation_id, blood_screening.test_hiv, blood_screening.test_hbsag, blood_screening.test_hcv, blood_screening.test_vdrl, blood_screening.test_mp,'
                . 'blood_screening.test_irregular_ab')
               ->from('blood_screening')               
               ->where('blood_screening.donation_id',$donation_id);
       
        $query = $this->db->get();
        
        $result = $query->result();
       
        $log = 'Update Blood Bag Info-'.$result[0]->donation_id.'-'
               .$result[0]->screening_id.'-'
               .$result[0]->test_hiv.'-'
               .$result[0]->test_hbsag.'-'
               .$result[0]->test_hcv.'-'
               .$result[0]->test_vdrl.'-'
               .$result[0]->test_mp.'-'
               .$result[0]->test_irregular_ab;
        $staff_id = $this->session->userdata('staff_id');
       
        $data_trail = array(
           'trail' => $log,
           'staff_id' => $staff_id
        );
       
        $hiv=$this->input->post('test_hiv');
        $hbsag=$this->input->post('test_hbsag');
        $hcv=$this->input->post('test_hcv');
        $vdrl=$this->input->post('test_vdrl');
        $mp=$this->input->post('test_mp');
        $irregular_ab=$this->input->post('test_irregular_ab');
        $screening_result ='';
        if($hiv == 1 || $hbsag == 1 || $hcv == 1 || $vdrl == 1 || $mp == 1 ||  $irregular_ab == 1){
            $screening_result = 0;     // Screening Positive.
        }
        else{
            $screening_result=1;       // Screening Negative.
        }
        $screening_results=array(
            'donation_id'=>$donation_id,
            'test_hiv'=>$hiv,
            'test_hbsag'=>$hbsag,
            'test_hcv'=>$hcv,
            'test_vdrl'=>$vdrl,
            'test_mp'=>$mp,
            'test_irregular_ab'=>$irregular_ab            
        );
        $screening_status_data=array(
            'donation_id'=>$donation_id,
            'status_id'=>6,
            'screening_result'=>$screening_result
        );
        $this->db->trans_start();
        $this->db->insert('bloodbank_edit_log', $data_trail);
        $this->db->where('donation_id', $donation_id);
        $this->db->update('blood_screening',$screening_results);
        $this->db->where('donation_id', $donation_id);
        $this->db->update('bb_donation',$screening_status_data);
        $this->db->trans_complete();
        return $this->db->trans_status();
   }
   
   function revert_to_component_preparation(){
       $donation_id = $this->input->post('donation_id');
       $this->db->select('blood_inventory.*')
               ->from('blood_inventory')               
               ->where('blood_inventory.donation_id', $donation_id);
       
       $query = $this->db->get();        
       $results = $query->result();
       
       $staff_id = $this->session->userdata('staff_id');
       $component_log = array();
       $i = 0;
       $inventory_id = '';
       $inventory_ids = array();       
       if(sizeof($results) > 1){
           foreach($results as $result){
               if($i == 0){
                   $inventory_id = $result->inventory_id;           // Update this id
               }else{
                   $inventory_ids[] = $result->inventory_id;        // Disable these ids
               }
               $single_component = 'Reverted to component preparation- '
                       . $result->donation_id.'-'
                       . $result->inventory_id.'-'
                       . $result->component_type.'-'
                       . $result->inv_status.'-'
                       . $result->status_id.'-'
                       . $result->volume.'-'
                       . $result->expiry_date.'-';
               $component_log[] = array(
                   'trail' => $single_component,
                   'staff_id' => $staff_id
               );
               $i++;
           }            
       }else{
            return false;
       }
       
        $blood_inventory = array(
            'component_type' => 'WB',
            'volume' => $this->input->post('volume'),
            'status_id' => '7'
        );
        
        $donation_id = array(
            'donation_id' => '-1'
        );
        
        $this->db->trans_start();
        $this->db->insert_batch('bloodbank_edit_log', $component_log);        
        $this->db->where('inventory_id', $inventory_id);        
        $this->db->update('blood_inventory', $blood_inventory);
        $this->db->where_in('inventory_id', $inventory_ids);
        $this->db->update('blood_inventory', $donation_id);
        $this->db->trans_complete();
        
        return $this->db->trans_status();
   }
   
}

?>
