
		<div class="col-md-8 col-md-offset-2">
		<center>
		<strong><?php if(isset($msg)){ echo $msg;}?></strong>
		<h3><u>Department</u></h3></center><br>
	<?php echo validation_errors(); echo form_open('sanitation/add/department',array('role'=>'form')); ?>

	<div class="form-group">
	    <label for=department_name" class="col-md-4">Department Name</label>
	    <div class="col-md-8">
	    <input type="text" class="form-control" placeholder="Department name" id="department_name" name="department_name"/>
	    </div>
	</div>
	<div class="form-group">
	    <label for="area_activity" class="col-md-4">Hospital</label>
	    <div class="col-md-8">
		<select name="hospital" id="hospital" class="form-control">
		<option value="">Hospital</option>
		<?php foreach($hospitals as $d){
			echo "<option value='$d->hospital_id'>$d->hospital</option>";
		}
		?>
		</select>
			   
	   </div>
	</div>
	<div class="col-md-3 col-md-offset-4">
	<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
</div>	</div>
