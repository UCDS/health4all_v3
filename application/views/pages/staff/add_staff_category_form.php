
<div class="col-md-8 col-md-offset-2">
	
	<center>
		<strong><?php if(isset($msg)){ echo $msg;}?></strong>
		<h3>Add Staff Category</h3>
	</center><br>
	
	<center>
		<?php echo validation_errors(); ?>
	</center>
	<?php 
	//What is form_open ?
	echo form_open('staff/add/staff_category',array('class'=>'form-horizontal','role'=>'form','id'=>'add_staff_category')); 
	?>

	<div class="form-group">
		<div class="col-md-3">
			<label for="first_name" class="control-label">Staff Category</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Staff Category" id="staff_category" name="staff_category" required />
		</div>
	</div>

   	<div class="form-group col-md-9">
		<button class="btn btn-lg btn-primary btn-block" type="submit" value="submit">Submit</button>
	</div>
</form>
</div>
