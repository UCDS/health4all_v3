<style>
	.table-2 td,th{
		width:50px;
		text-align:center;
	}
	.table-2 a{
		color:black;
		text-decoration:none;
	}
</style>
<div class="col-md-10 col-sm-9">
        <br/>
        <button type="button" class="btn btn-default btn-md print">
            <span class="glyphicon glyphicon-print"></span> Print
	</button>
        <br/><br/>
	<?php echo form_open('bloodbank/user_panel/available_blood'); ?>
	<table class="table-2 table table-striped table-bordered" style="position:relative;float:left">
	<tr><th colspan="4">Whole Blood & Packed Cells</th></tr>
	<tr><th>Blood Group</th><th>Whole Blood</th><th>PC</th><th>Total</th></tr>
	<?php 
	$blood_groups=array("A+","B+","AB+","O+","A-","B-","AB-","O-");
	$available_groups=array();
	$total=0;
	$group_total=0;
	$wb_total=0;
	$pc_total=0;
	foreach($available as $s){
	$blood_group=str_replace("+","pos",$s->blood_group);
	$blood_group=str_replace("-","neg",$blood_group);
	?>
	<tr>
		<td><?php echo $s->blood_group;?></td>
		<td><a href="<?php echo base_url()."bloodbank/user_panel/report_inventory/$blood_group/WB"; ?>"><?php echo $s->wb;?></a></td>
		<td><a href="<?php echo base_url()."bloodbank/user_panel/report_inventory/$blood_group/PC"; ?>"><?php echo $s->pc;?></a></td>
		<th><a href="<?php echo base_url()."bloodbank/user_panel/report_inventory/$blood_group/0"; ?>"><?php $group_total=$s->wb+$s->pc;
			echo $group_total;
			?></a>
		</th>
	</tr>
	<?php
	$available_groups[]=$s->blood_group;
	$total+=$group_total;
	$wb_total+=$s->wb;
	$pc_total+=$s->pc;
	}
	$remaining=array_diff($blood_groups,$available_groups);
	foreach($remaining as $r){
	?>
	<tr>
		<td><?php echo $r;?></td>
		<td>0</td>
		<td>0</td>
		<th>0</th>
	</tr>
	<?php 
	}
	?>
	<th>Total</th>
	<th><?php echo $wb_total;?></th>
	<th><?php echo $pc_total;?></th>
	<th><?php echo $total;?></th>
	</table>
	<br />
	<table class="table-2 table table-striped table-bordered">
	<tr><th colspan="10">Components</th></tr>
	<tr><th>Blood Group</th><th>PRP</th><th>Platelet Concentrate</th><th>FFP</th><th>FP</th><th>Cryo</th><th>Total</th></tr>
	<?php 
	$blood_groups=array("A+","B+","AB+","O+","A-","B-","AB-","O-");
	$available_groups=array();
	$total=0;
	$group_total=0;
	$prp_total=0;
	$platelet_concentrate_total=0;
	$ffp_total=0;
	$fp_total=0;
	$cryo_total=0;
	foreach($available as $s){
	$blood_group=str_replace("+","pos",$s->blood_group);
	$blood_group=str_replace("-","neg",$blood_group);
	?>
	<tr>
		<td><?php echo $s->blood_group;?></td>
		<td><a href="<?php echo base_url()."bloodbank/user_panel/report_inventory/$blood_group/PRP"; ?>"><?php echo $s->prp;?></a></td>
		<td><a href="<?php echo base_url()."bloodbank/user_panel/report_inventory/$blood_group/Platelet Concentrate"; ?>"><?php echo $s->platelet_concentrate;?></a></td>
		<td><a href="<?php echo base_url()."bloodbank/user_panel/report_inventory/$blood_group/FFP"; ?>"><?php echo $s->ffp;?></a></td>
		<td><a href="<?php echo base_url()."bloodbank/user_panel/report_inventory/$blood_group/FP"; ?>"><?php echo $s->fp;?></a></td>
		<td><a href="<?php echo base_url()."bloodbank/user_panel/report_inventory/$blood_group/Cryo"; ?>"><?php echo $s->cryo;?></a></td>
		<th><a href="<?php echo base_url()."bloodbank/user_panel/report_inventory/$blood_group/1"; ?>"><?php $group_total=$s->prp+$s->platelet_concentrate+$s->ffp+$s->fp+$s->cryo;
			echo $group_total;
			?></a>
		</th>
	</tr>
	<?php
	$available_groups[]=$s->blood_group;
	$total+=$group_total;
	$prp_total+=$s->prp;
	$platelet_concentrate_total+=$s->platelet_concentrate;
	$ffp_total+=$s->ffp;
	$fp_total+=$s->fp;
	$cryo_total+=$s->cryo;
	}
	$remaining=array_diff($blood_groups,$available_groups);
	foreach($remaining as $r){
	?>
	<tr>
		<td><?php echo $r;?></td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<th>0</th>
	</tr>
	<?php 
	}
	?>
	<th>Total</th>
	<th><?php echo $prp_total;?></th>
	<th><?php echo $platelet_concentrate_total;?></th>
	<th><?php echo $ffp_total;?></th>
	<th><?php echo $fp_total;?></th>
	<th><?php echo $cryo_total;?></th>
	<th><?php echo $total;?></th>
	</table>
</div>
