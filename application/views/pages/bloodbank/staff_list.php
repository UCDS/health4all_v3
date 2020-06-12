<div class="col-md-10 col-sm-9">
	<a href="<?php echo base_url();?>staff/login" style="float:right;" >Staff Panel</a>

	<table class="table-2 table table-striped table-bordered">
		<th colspan="4">Staff List</th>
		<tr><th>S.No</th><th>Name</th><th>Designation</th></tr>
		<?php 
		$i=1;
		foreach($staff as $s){ ?>
		<tr><td><?php echo $i; ?></td><td><?php echo $s->name;?></td><td><?php echo $s->staff_category; ?></td></tr>
		<?php
		$i++;
		} ?>
	</table>
</div>
