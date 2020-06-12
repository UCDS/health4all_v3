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
	<h3>Inventory at Blood Banks <small>as on <?php echo date("d-M-Y, g:iA");?></small></h3>
	<?php 
		$hospitals = array();
		foreach($available as $s){
			if(!in_array($s->hospital, $hospitals)) {
				$hospitals[]=$s->hospital;
			}
		}
	
	?>
	
	<table class="table-2 table table-striped table-bordered" style="position:relative;float:left">
	<?php foreach($hospitals as $h){ ?>
	<tr><th colspan="10" style="background-color:#721818;color:white"><?php echo $h;?></th></tr>
	<tr>
		<th></th>
		<th colspan="3">Whole Blood & Packed Cells</th>
		<th colspan="6">Components</th>
	</tr>
	<tr>
		<th>Blood Group</th>
		<th>Whole Blood</th>
		<th>PC</th>
		<th>Total</th>
		<th>PRP</th>
		<th>Platelet Concentrate</th>
		<th>FFP</th>
		<th>FP</th>
		<th>Cryo</th>
		<th>Total</th>
	</tr>
	<?php 
	$blood_groups=array("A+","B+","AB+","O+","A-","B-","AB-","O-");
	$available_groups=array();
	$total=0;
	$total_comp=0;
	$group_total=0;
	$group_comp_total=0;
	$wb_total=0;
	$pc_total=0;
	$prp_total=0;
	$platelet_concentrate_total=0;
	$ffp_total=0;
	$fp_total=0;
	$cryo_total=0;
	foreach($available as $s){
	if($s->hospital == $h) { 
	$blood_group=str_replace("+","pos",$s->blood_group);
	$blood_group=str_replace("-","neg",$blood_group);
	?>
	<tr>
		<td><?php echo $s->blood_group;?></td>
		<td><?php echo $s->wb;?></td>
		<td><?php echo $s->pc;?></td>
		<th><?php $group_total=$s->wb+$s->pc;
			echo $group_total;
			?>
		</th>
		<td><?php echo $s->prp;?></td>
		<td><?php echo $s->platelet_concentrate;?></td>
		<td><?php echo $s->ffp;?></td>
		<td><?php echo $s->fp;?></td>
		<td><?php echo $s->cryo;?></td>
		<th><?php $group_comp_total=$s->prp+$s->platelet_concentrate+$s->ffp+$s->fp+$s->cryo;
			echo $group_comp_total;
			?>
		</th>
	</tr>

	<?php
	$available_groups[]=$s->blood_group;
	$total+=$group_total;
	$total_comp+=$group_comp_total;
	$wb_total+=$s->wb;
	$pc_total+=$s->pc;
	$prp_total+=$s->prp;
	$platelet_concentrate_total+=$s->platelet_concentrate;
	$ffp_total+=$s->ffp;
	$fp_total+=$s->fp;
	$cryo_total+=$s->cryo;
		}
	}
	$remaining=array_diff($blood_groups,$available_groups);
	foreach($remaining as $r){
	?>
	<tr>
		<td><?php echo $r;?></td>
		<td>0</td>
		<td>0</td>
		<th>0</th>
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
	<th>Hospital Total</th>
	<th><?php echo $wb_total;?></th>
	<th><?php echo $pc_total;?></th>
	<th><?php echo $total;?></th>
	<th><?php echo $prp_total;?></th>
	<th><?php echo $platelet_concentrate_total;?></th>
	<th><?php echo $ffp_total;?></th>
	<th><?php echo $fp_total;?></th>
	<th><?php echo $cryo_total;?></th>
	<th><?php echo $total_comp;?></th>
	</tr>
	<?php 
	}?>
	</table>
	
</div>
