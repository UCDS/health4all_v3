<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/export_to_excell.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >


<?php 
    $from_date=FALSE;
    $to_date=FALSE;
    if($this->input->get_post('from_date')) 
        $from_date=date("Y-m-d",strtotime($this->input->get_post('from_date'))); 
    else 
        $from_date = date("Y-m-d");
    if($this->input->get_post('to_date')) 
        $to_date=date("Y-m-d",strtotime($this->input->get_post('to_date'))); 
    else 
        $to_date = date("Y-m-d");
    $from_time=0;
    $to_time=0;
    if($this->input->get_post('from_time')) 
        $from_time=date("H:i",strtotime($this->input->get_post('from_time'))); 
    else 
        $from_time = date("00:00");
    if($this->input->get_post('to_time')) 
        $to_time=date("H:i",strtotime($this->input->get_post('to_time'))); 
    else 
        $to_time = date("23:59");
?>

<?php
    $all_values = array();
    foreach($op_summary as $op) {
        $op->ip_summary = 0;
        $op->rept_summary = 0;
        $op->new_visits = 0;
        foreach($ip_summary as $key => $ip) {
            if($op->hospital_id == $ip->hospital_id) {
                $op->ip_summary = $ip->patient_visits;
                unset($ip_summary[$key]);
            }
        }
        foreach($distinct_patient_summary as $key => $dp) {
            if($op->hospital_id == $dp->hospital_id) {
                $op->rept_summary = $op->patient_visits - $dp->distinct_patient_visits;
                $op->new_visits = $op->patient_visits - $op->rept_summary;
                unset($distinct_patient_summary[$key]);
            }
        }
    }

    if(sizeof($ip_summary > 0)) {
        foreach($ip_summary as $ip) {
            $ip->ip_summary = $ip->patient_visits;
            $ip->rept_summary = 0;
            $ip->new_visits = 0;
            $ip->patient_visits = 0;
            $op_summary[] = $ip;
        }
    }
    
    // Statewise
    $states = array();
    foreach($op_summary as $op) {
        if($op->state=='')
            array_push($states, 'Not Set');    
        array_push($states, $op->state);
    }
    $states = array_unique($states);
    $state_wide_op_summary=array();
    foreach($states as $state){
        $i =0;
        $state_wide_op_summary[$state] = array();
        foreach($op_summary as $key => $op) {
            if(strcmp($state, $op->state)==0) {
                $state_wide_op_summary[$state][$i++] = $op;
                unset($op_summary[$key]);
            }
        }
    }
?>

<div class="alert alert-warning" role="alert">
    <h4 class="text-center">Patient Visit Summary Report -&nbsp;<?php echo strtoupper(str_replace("_", " ", $organization_name));?></h4>
</div>
<div class="alert alert-success" role="alert">
<?php 
    echo form_open("dashboard/org",array('method'=>'get','role'=>'form','class'=>'form-custom text-center')); 
?>
    From Date : <input class="form-control" type="date" value='<?php echo date("Y-m-d",strtotime($from_date)); ?>' name="from_date" id="from_date" size="15" />
    &emsp;
    To Date : <input class="form-control" type="date" value="<?php echo date("Y-m-d",strtotime($to_date)); ?>" name="to_date" id="to_date" size="15" />
    &emsp;
    <input class="hidden" type="text" name="organization_name" value="<?php echo $organization_name;?>" />
    <select name="state_key" id="state_key" class="form-control" >
        <option value="">States</option>
        <?php 
        foreach($dist_states as $state){
            echo "<option value='".$state->state_key."' class=''";
            if($this->input->get_post('state_key') && $this->input->get_post('state_key') == $state->state_key) 
                echo " selected ";
            echo ">".$state->state."</option>";
        }
        ?>
    </select>
    <input class="btn btn-sm btn-primary" type="submit" value="Submit" />
    
<?php 
    echo form_close();
?>
</div>
<br />
<!--table is displayed only when there is atleast one registration is done-->
<?php 
$grand_new_op=0;
$grand_repeat_op=0;
$grand_op_total=0;
$grand_ip=0;

foreach($state_wide_op_summary as $key=>$op_summary) { ?>
<table class="table table-bordered table-striped" id="table-sort_<?php echo str_replace(" ", "_", $key); ?>" >
    <thead>
        <tr class="success">
            <th style="text-align:center" width="2%">#</th>
            <th style="text-align:center" width="58%"><?php echo $key; ?></th>
            <th style="text-align:center" width="10%">OP New</th>
            <th style="text-align:center" width="10%">OP Repeat</th>
            <th style="text-align:center" width="10%">OP Total</th>
            <th style="text-align:center" width="10%">IP Visits</th>
        </tr>
    </thead>
    <tbody>
    <?php $sno=1; $new_total=0; $repeat_total=0; $op_total=0; $ip_total=0;  
    foreach($op_summary as $op){ ?>
        <tr>
            <!--data is retrieved from database to the html table-->
            <td class="text-right"><?php echo $sno; ?></td>
            <td class="text-left"><?php echo $op->hospital; ?></td>
            <td class="text-right"><?php echo number_format($op->new_visits); ?></td>
            <td class="text-right"><?php echo number_format($op->rept_summary); ?></td>
            <td class="text-right"><?php echo number_format($op->patient_visits) ?></td>
            <td class="text-right"><?php echo number_format($op->ip_summary); ?></td>
        </tr>
    <?php 
        $sno+=1; 
        $new_total += $op->new_visits;
        $repeat_total += $op->rept_summary;
        $op_total += $op->patient_visits;
        $ip_total += $op->ip_summary;
        $grand_new_op += $op->new_visits;
        $grand_repeat_op += $op->rept_summary;
        $grand_op_total += $op->patient_visits;
        $grand_ip += $op->ip_summary;
    } ?>
        <tfoot>
            <th class="text-right">Total</th>
            <th class="text-right" ><?php ?></th>
            <th class="text-right" ><?php echo number_format($new_total);?></th>
            <th class="text-right" ><?php echo number_format($repeat_total); ?></th>
            <th class="text-right" ><?php echo number_format($op_total); ?></th>
            <th class="text-right" ><?php echo number_format($ip_total); ?></th>
        </tfoot>
	</tbody>
</table>
<?php } ?>
<table class="table table-bordered table-striped">
    <thead>
        <tr class="success">
            <th style="text-align:center" width="60%">#</th>
            <th style="text-align:center" width="10%">OP New</th>
            <th style="text-align:center" width="10%">OP Repeat</th>
            <th style="text-align:center" width="10%">OP Total</th>
            <th style="text-align:center" width="10%">IP Visits</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <!--data is retrieved from database to the html table-->
            <td class="text-right">Grand Total</td>
            <th class="text-right" ><?php echo number_format($grand_new_op);?></th>
            <th class="text-right" ><?php echo number_format($grand_repeat_op); ?></th>
            <th class="text-right" ><?php echo number_format($grand_op_total); ?></th>
            <th class="text-right" ><?php echo number_format($grand_ip); ?></th>
        </tr>
    </tbody>
</table>
<script type="text/javascript">
    $(function() {
        <?php foreach($states as $state){ ?>
        $("#table-sort_<?php echo str_replace(" ", "_", $state); ?>").tablesorter({
            headers: {
                0: { sortInitialOrder: 'asc' }
            }
        });
    <?php } ?>
    });
</script>