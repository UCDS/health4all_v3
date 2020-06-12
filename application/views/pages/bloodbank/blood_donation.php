

<div class="col-md-10 col-sm-9">
	<?php
	if(isset($msg)) {
		echo $msg;
		echo "<br />";
		echo "<br />";
	}
	?>
	<div>
		<input type="text" placeholder="slot_date" name="date" /><input type="submit" value="Search" name="search" />
	</div>
	<div>
		<h3>Registered donors : </h3>
		<table class="table-2 table table-striped table-bordered">
			<tr><th>S.No</th><th>Name</th><th>Age</th><th>Blood Group</th><th>Phone</th><th></th></tr>
		<?php 
		$i=1;
		foreach($donors as $donor){
		?>
		<tr>
		<form>
			<td><?php echo $i;?></td>
			<td><?php echo $donor->name;?></td>
			<td><?php echo $donor->age;?></td>
			<td><?php echo $donor->blood_group;?></td>
			<td><?php echo $donor->phone;?></td>
			<td>
				<input type="submit" value="Update" formaction="<?php echo base_url();?>register/medical_checkup/<?php echo $donor->donation_id;?>" />
				<input type="submit" value="X" formaction="<?php echo base_url();?>register/delete_donor/$donation_id"/></td>
		</form>
		</tr>
		<?php 
		$i++;
		}
		?>
		</table>
			
	</div>
</div>

