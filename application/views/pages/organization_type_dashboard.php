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
<script type="text/javascript">
    $(function() {
        $("#table-sort").tablesorter({
            headers: {
                0: { sortInitialOrder: 'asc' }
            }
        });
    });
</script>

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
            if(($op->type2!='') && strcmp($op->type2, $ip->type2) == 0) {
                $op->ip_summary = $ip->patient_visits;
                unset($ip_summary[$key]);
            }
        }
        foreach($distinct_patient_summary as $key => $dp) {
            if(($op->type2!='') && strcmp($op->type2, $dp->type2) == 0) {
                $op->rept_summary = $op->patient_visits - $dp->distinct_patient_visits;
                $op->new_visits = $op->patient_visits - $op->rept_summary;
                unset($distinct_patient_summary[$key]);
            }
            else if($op->hospital_id == $dp->hospital_id) {
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

    // Totals
    $new_total = 0;
    $repeat_total = 0;
    $op_total = 0;
    $ip_total = 0;
    foreach($op_summary as $op){
        $new_total += $op->new_visits;
        $repeat_total += $op->rept_summary;
        $op_total += $op->patient_visits;
        $ip_total += $op->ip_summary;
    }
?>

<div class="alert alert-warning" role="alert">
    <h4 class="text-center">Patient Visit Summary Report -&nbsp;<?php echo strtoupper(str_replace("_", " ", $organization_type));?></h4>
</div>
<div class="alert alert-success" role="alert">
<?php 
    echo form_open("dashboard/org_type",array('method'=>'get','role'=>'form','class'=>'form-custom text-center')); 
?>
    From Date : <input class="form-control" type="date" value='<?php echo date("Y-m-d",strtotime($from_date)); ?>' name="from_date" id="from_date" size="15" />
    &emsp;
    To Date : <input class="form-control" type="date" value="<?php echo date("Y-m-d",strtotime($to_date)); ?>" name="to_date" id="to_date" size="15" />
    &emsp;
    <input class="hidden" type="text" name="organization_type" value="<?php echo $organization_type;?>" />
    <input class="btn btn-sm btn-primary" type="submit" value="Submit" />
    
<?php 
    echo form_close();
?>
</div>
<br />
<!--table is displayed only when there is atleast one registration is done-->
<table class="table table-bordered table-striped" id="table-sort">
    <thead>
        <tr class="success">
            <th style="text-align:center">#</th>
            <th style="text-align:center">NPO</th>
            <th style="text-align:center">OP New</th>
            <th style="text-align:center">OP Repeat</th>
            <th style="text-align:center">OP Total</th>
            <th style="text-align:center">IP Visits</th>
        </tr>
    </thead>
    <tbody>
    <?php $sno=1; foreach($op_summary as $op){ ?>
        <tr>
            <!--data is retrieved from database to the html table-->
            <td class="text-right"><?php echo $sno; ?></td>
            <td class="text-left">
            <?php 
            $link = '';
            if($op->type2)
                $link = base_url()."dashboard/org?from_date="
                .$from_date."&to_date=".$to_date
                .'&organization_name='.$op->type2;
            else 
                $link = '#';
             ?>
            <a href="<?=$link ?>"><?php echo $op->type2 ? $op->type2 : $op->hospital ?></a></td>
            <td class="text-right"><?php echo number_format($op->new_visits); ?></td>
            <td class="text-right"><?php echo number_format($op->rept_summary); ?></td>
            <td class="text-right"><?php echo number_format($op->patient_visits); ?></td>
            <td class="text-right"><?php echo number_format($op->ip_summary); ?></td>
        </tr>
    <?php $sno+=1; } ?>
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