<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<script type="text/javascript"
 src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script>
	$(function(){
		$(".date").Zebra_DatePicker({
			direction:false
		});
	});
</script>

<div class="col-md-10 col-sm-9">
	<h4>Screened Inventory at Gandhi Hospital</h4>
	<?php echo form_open('bloodbank/user_panel/inventory_summary'); ?>
	<div>
		<input type="text" class="date" size="12" name="from_date" />
		<input type="text" class="date" size="12" name="to_date" />
		<input type="submit" name="submit" value="Search" />
	</div>
	<table class="table-2 table table-striped table-bordered">
	<tr><th>Status</th><th>A+</th><th>A-</th><th>B+</th><th>B-</th><th>AB+</th><th>AB-</th><th>O+</th><th>O-</th><th>Total</th></tr>
	<?php 
	$Apos=0;
	$Aneg=0;
	$Bpos=0;
	$Bneg=0;
	$ABpos=0;
	$ABneg=0;
	$Opos=0;
	$Oneg=0;
	$total=0;
	foreach($summary as $s){
		$day_total=0;
		$day_total+=$s['A+']+$s['A-']+$s['B+']+$s['B-']+$s['AB+']+$s['AB-']+$s['O+']+$s['O-'];
	?>
	<tr>
		<td><?php echo ucwords($s['inv_status']);?></td>
		<td><?php echo $s['A+'];?></td>
		<td><?php echo $s['A-'];?></td>
		<td><?php echo $s['B+'];?></td>
		<td><?php echo $s['B-'];?></td>
		<td><?php echo $s['AB+'];?></td>
		<td><?php echo $s['AB-'];?></td>
		<td><?php echo $s['O+'];?></td>
		<td><?php echo $s['O-'];?></td>
		<th><?php echo $day_total;?></th>
	</tr>
	<?php
	$Apos+=$s['A+'];
	$Aneg+=$s['A-'];
	$Bpos+=$s['B+'];
	$Bneg+=$s['B-'];
	$ABpos+=$s['AB+'];
	$ABneg+=$s['AB-'];
	$Opos+=$s['O+'];
	$Oneg+=$s['O-'];
	$total+=$day_total;
	}
	?>
	<tr><b>
		<th>Total </th>
		<th ><?php echo $Apos;?></th>
		<th ><?php echo $Aneg;?></th>
		<th ><?php echo $Bpos;?></th>
		<th ><?php echo $Bneg;?></th>
		<th ><?php echo $ABpos;?></th>
		<th ><?php echo $ABneg;?></th>
		<th ><?php echo $Opos;?></th>
		<th ><?php echo $Oneg;?></th>
		<th ><?php echo $total;?></th>
	</tr>
	</table>
</div>
