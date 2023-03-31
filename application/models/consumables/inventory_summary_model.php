<?php

class Inventory_summary_model extends CI_Model 
{
    function __construct()
	{
		parent::__construct();
	}


    function hashutil($record, $type='')
    {
        if($type == 'array')
            return $record['supply_chain_party_id'].'.'.$record['item_id'];
        else
            return "$record->supply_chain_party_id.$record->item_id";
    }


    function query_latest_records($latest_run_date, $scp_id=null, $as_on_date=null)
    {
        if($scp_id){
            // echo "$as_on_date<br/>";            
            $this->db->select('scp.supply_chain_party_name, item.item_name, inventory.item_id, inventory.supply_chain_party_id, inventory.inward_outward, SUM(inventory.quantity) total_quantity')
            ->from('inventory')
            ->join('item', 'item.item_id = inventory.item_id')
            ->join('supply_chain_party scp', 'scp.supply_chain_party_id = inventory.supply_chain_party_id')
            ->where("inventory.date_time > '$latest_run_date'")
            ->where('scp.supply_chain_party_id', $scp_id)
            ->group_by('inventory.item_id, inventory.supply_chain_party_id, inventory.inward_outward');
            if($as_on_date){
                $this->db->where("inventory.date_time <= '$as_on_date'");
            }
            if($this->input->post('item')){
                $this->db->where('inventory.item_id', $this->input->post('item'));
            }
        } else {

            $this->db->select('inventory.item_id, inventory.supply_chain_party_id, inventory.inward_outward, SUM(inventory.quantity) total_quantity')
            ->from('inventory')
            ->where("inventory.date_time > '$latest_run_date'")
            ->group_by('inventory.item_id, inventory.supply_chain_party_id, inventory.inward_outward');
        }     


        $query = $this->db->get();
        // echo $query_string = $this->db->last_query();
        $records = $query->result();
        return $records;
    }
    function get_latest_records($latest_run_date='', $scp_id = null, $as_on_date=null)
    {
        $ldt = date('Y-m-d H:i:s', strtotime($latest_run_date));
        if($latest_run_date == ''){
            $ldt = date('Y-m-d H:i:s', 0);
        }

       $records = $this->query_latest_records($ldt, $scp_id, $as_on_date);

        $mp = array();

        foreach($records as $record){
            $mpkey = $this->hashutil($record);
            if(isset($mp[$mpkey])){
                if($record->inward_outward == 'inward'){
                    $mp[$mpkey]['inward'] = $record;
                }else{
                    $mp[$mpkey]['outward'] = $record;
                }
            }else{
                $mp[$mpkey] = array('inward' => null, 'outward' => null);
                if($record->inward_outward == 'inward'){
                    $mp[$mpkey]['inward'] = $record;
                }else{
                    $mp[$mpkey]['outward'] = $record;
                }
            }
        }

        $inward_outward_records = array_values($mp);
        return $inward_outward_records;
    }



    function calculate_latest_balance($latest_run_date='', $scp_identifier=null, $as_on_date=null)
    {
        $latest_records = $this->get_latest_records($latest_run_date, $scp_identifier, $as_on_date);

        $call_date = date('Y-m-d H:i:s');
        // echo($call_date);
        $result = array();

        foreach($latest_records as $record){
            
            $transaction_date = $as_on_date ? $as_on_date: $call_date;
            $i_qty = 0;
            $o_qty = 0;
            $scp_id = null;
            $item_id = null;
            $scp_name = null;
            $item_name = null;
            if($record['inward'] != null){
                $scp_id = $record['inward']->supply_chain_party_id;              
                $item_id = $record['inward']->item_id;
                $i_qty = $record['inward']->total_quantity;
                if($scp_id && $scp_identifier){
                    $scp_name = $record['inward']->supply_chain_party_name;
                    $item_name = $record['inward']->item_name;
                }
            }else{
                $item_id = $record['outward']->item_id;
                $scp_id = $record['outward']->supply_chain_party_id;
                if($scp_id && $scp_identifier){
                    $scp_name = $record['outward']->supply_chain_party_name;
                    $item_name = $record['outward']->item_name;
                }
            }

            if($record['outward'] != null){
                $o_qty = $record['outward']->total_quantity;
            }
            $closing_balance = ($i_qty - $o_qty);
            if($scp_identifier){
                $result[] = array(
                    'supply_chain_party_id' => $scp_id, 
                    'supply_chain_party_name' => $scp_name, 
                    'item_id' => $item_id, 
                    'item_name' => $item_name, 
                    
                    'closing_balance' => $closing_balance
                );
            }else{
                $result[] = array(
                    'supply_chain_party_id' => $scp_id, 
                    'item_id' => $item_id, 
                    'transaction_date' => $transaction_date, 
                    'closing_balance' => $closing_balance
                );
            }
        }

        return $result;

    }

    function max_date($latest_summary)
    {
        $latest_run_timestamp = 0;
        foreach($latest_summary as $record){
            if(strtotime($record->latest_transaction_date) > $latest_run_timestamp){
                $latest_run_timestamp = strtotime($record->latest_transaction_date);
            }
        }

        return date('Y-m-d H:i:s', $latest_run_timestamp);
    }


    function calculate_final_balance($latest, $closing_balance, $scp_id=null)
    {
        $mp = array();
      
        foreach($closing_balance as $record){
            $mp[$this->hashutil($record)] = $record;
            // echo json_encode($record);
        }

        $all_summary_records = array();
        // echo '<br/>'.json_encode($latest);
        // $i = 0;
        // echo json_encode($latest).'<br/>';
        // echo json_encode($closing_balance).'<br/>';
        foreach($latest as &$record){
            $mpkey = $this->hashutil($record, 'array');
            if(isset($mp[$mpkey])){
                // echo $mp[$mpkey]->closing_balance." ".json_encode($record).'<br/>';
                $record['closing_balance'] += $mp[$mpkey]->closing_balance;
                // echo json_encode($record, JSON_PRETTY_PRINT).'<br/>';
                unset($mp[$mpkey]);
            }
            $all_summary_records[] = $record;
            // $i++;
        }
        // unset($record);
        // echo json_encode($latest).'<br/>';
        if($scp_id){
            foreach($mp as $k => $record){
                    $all_summary_records[] = array(
                        'supply_chain_party_id' => $scp_id, 
                        'supply_chain_party_name' => $record->supply_chain_party_name, 
                        'item_id' => $record->item_id, 
                        'item_name' => $record->item_name, 
                        
                        'closing_balance' => $record->closing_balance
                    );
                }
        }
        // unset($record);

        if($scp_id){
            // echo json_encode($latest).'<br/>';
            // echo json_encode($all_summary_records).'<br/>';
            return $all_summary_records;
        }else{
            echo json_encode($latest).'<br/>';
            return $latest;
        }
    }
    function get_and_update_balance($latest_summary, $scp_id=null, $as_on_date=null)
    {
        $latest_run_date = $this->max_date($latest_summary);
        // echo "LATEST RUN DATE ".$latest_run_date. "<br/>";
        $latest_balance_records = $this->calculate_latest_balance($latest_run_date, $scp_id, $as_on_date);

        $final_balance_records = $this->calculate_final_balance($latest_balance_records, $latest_summary, $scp_id);
        // echo json_encode($final_balance_records);
        return $final_balance_records;
        
    }
    
    function run_report_periodic()
    {
        $this->db->trans_start();
        // $report_run_date = date('Y-m-d H:i:s');
        $this->db->select('inventory_summary.item_id, inventory_summary.supply_chain_party_id, inventory_summary.closing_balance, summalias.t_date latest_transaction_date')
        ->join('(SELECT s.item_id, s.supply_chain_party_id, MAX(s.transaction_date) t_date FROM inventory_summary s GROUP BY s.item_id, s.supply_chain_party_id) summalias', 
        'summalias.item_id = inventory_summary.item_id AND summalias.supply_chain_party_id = inventory_summary.supply_chain_party_id AND summalias.t_date = inventory_summary.transaction_date')
        ->from('inventory_summary');
        // ->group_by('item_id, supply_chain_party_id');

        $query = $this->db->get();
        $latest_summary = $query->result();
        $final_balance_records = $this->get_and_update_balance($latest_summary);
        if(count($final_balance_records) > 0)
            $this->db->insert_batch('inventory_summary', $final_balance_records);


        $this->db->trans_complete();
        return $final_balance_records;
    }

    function show_inventory_summary($scp_id, $as_on_date=null)
    {
        $this->db->trans_start();
        // $report_run_date = date('Y-m-d H:i:s');
		$hospital=$this->session->userdata('hospital');                                                //Storing user data who logged into the hospital into a var:hospital
        $this->db->select('inventory_summary.item_id, item.item_name, inventory_summary.supply_chain_party_id, scp.supply_chain_party_name, inventory_summary.closing_balance, summalias.t_date latest_transaction_date')
        ->from('inventory_summary')
        ->join("(SELECT s.item_id, s.supply_chain_party_id, MAX(s.transaction_date) t_date FROM inventory_summary s WHERE s.transaction_date <= '$as_on_date' GROUP BY s.item_id, s.supply_chain_party_id) summalias", 
        'summalias.item_id = inventory_summary.item_id AND summalias.supply_chain_party_id = inventory_summary.supply_chain_party_id AND summalias.t_date = inventory_summary.transaction_date')
        ->join('item', 'inventory_summary.item_id = item.item_id')
        ->join('supply_chain_party scp', 'scp.supply_chain_party_id = inventory_summary.supply_chain_party_id')
        ->where('scp.supply_chain_party_id', (int)$scp_id)
        ->where('scp.hospital_id', $hospital['hospital_id']);
        // ->group_by('inventory_summary.item_id, inventory_summary.supply_chain_party_id');
        // if($as_on_date){
        //     $this->db->where("inventory_summary.transaction_date <= '$as_on_date'");
        //     // echo "as on date exists";
        // }
        if($this->input->post('item')){
            $this->db->where('inventory_summary.item_id', $this->input->post('item'));
        }
        $query = $this->db->get();
        $qstring = $this->db->last_query();
        // echo "<p>$qstring</p>";
        $latest_summary = $query->result();
        // echo json_encode($latest_summary);
        $final_balance_records = $this->get_and_update_balance($latest_summary, $scp_id, $as_on_date);
        $this->db->trans_complete();
        // if(count($final_balance_records) == 0)
        //     return $latest_summary;


        return $final_balance_records;
    }
    public function get_inventory_records()
    {
        $this->db->select('*')
        ->from('inventory');
        $query = $this->db->get();
        return $query->result();
    }    
}