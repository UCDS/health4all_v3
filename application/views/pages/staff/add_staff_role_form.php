<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>

<script type="text/javascript">
	$(function(){
		$("#date_of_birth").Zebra_DatePicker();
		$("#department").on('change',function(){
			var department_id=$(this).val();
			$("#unit option,#area option").hide();
			$("#unit option[class="+department_id+"],#area option[class="+department_id+"]").show();
		});
	});
</script>

<div class="col-md-8 col-md-offset-2">
	
	<center>
		<strong><?php if(isset($msg)){ echo $msg;}?></strong>
		<h3>Add Staff Role</h3>
	</center><br>
	
	<center>
		<?php echo validation_errors(); ?>
	</center>
	<?php 
	//What is form_open ?
	echo form_open('staff/add/staff_role',array('class'=>'form-horizontal','role'=>'form','id'=>'add_staff_role')); 
	?>

	<div class="form-group">
		<div class="col-md-3">
			<label for="first_name" class="control-label">Staff Role</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Staff Role" id="staff_role" name="staff_role" required />
		</div>
	</div>

   	<div class="form-group col-md-9">
		<button class="btn btn-lg btn-primary btn-block" type="submit" value="submit">Submit</button>
	</div>
</form>
</div>
