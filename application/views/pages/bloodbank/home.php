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
		<h4>Welcome to  Blood Bank!</h4>
		
		<p>Why donate blood? Watch a video here:</p>
		<div align="center">
		<iframe width="420" height="315" src="//www.youtube.com/embed/E9QxiGPwab4?rel=0" frameborder="0" allowfullscreen></iframe>
		</div>
		<p>If you would like to donate blood, <a href="<?php echo base_url();?>appointment">click here</a></p>
		<br />
                <p>Staff login, <a href="<?php echo base_url();?>">click here</a></p>
                <br />
		<h4>Our inventory as on <?php echo date("d-M-Y");?> </h4>
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
				<td><?php echo $s->wb;?></td>
				<td><?php echo $s->pc;?></td>
				<th><?php $group_total=$s->wb+$s->pc;
					echo $group_total;
					?>
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
				<td><?php echo $s->prp;?></td>
				<td><?php echo $s->platelet_concentrate;?></td>
				<td><?php echo $s->ffp;?></td>
				<td><?php echo $s->fp;?></td>
				<td><?php echo $s->cryo;?></td>
				<th><?php $group_total=$s->prp+$s->platelet_concentrate+$s->ffp+$s->fp+$s->cryo;
					echo $group_total;
					?>
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
		<p></p>
	</div>
