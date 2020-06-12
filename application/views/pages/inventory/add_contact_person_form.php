<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >

<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript">
$(function(){
	$("#warranty_start_date,#warranty_end_date").Zebra_DatePicker();
	$("#supply_date").Zebra_DatePicker({
		onSelect : function(date){
		$("#warranty_start_date").val(date);
		}
	});
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
		<h3>Add Contact Person Details</h3>
	</center><br>
	
	<center>
		<?php echo validation_errors(); ?>
	</center>
	<?php 
	echo form_open('vendor/add/contact_person',array('class'=>'form-horizontal','role'=>'form','id'=>'add_contact_person')); 
	?>

	<div class="form-group">
		<div class="col-md-3">
			<label for="contact_person_first_name" class="control-label">First Name<font color='red'>*</font></label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="First Name" id="contact_person_first_name" name="contact_person_first_name" required />
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-3">
			<label for="contact_person_last_name" class="control-label">Last Name</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Last Name" id="contact_person_last_name" name="contact_person_last_name" />
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-3">
			<label for="contact_person_contact" > Contact Number<font color='red'>*</font></label>
		</div>
		<div class="col-md-6">
		<input type="text" class="form-control" placeholder=" Contact Number" id="contact_person_contact" name="contact_person_contact" required />
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-3">
			<label for="contact_person_email" > Email</label>
		</div>
		<div class="col-md-6">
		<input type="text"  class="form-control" placeholder=" Contact Email" id="contact_person_email" name="contact_person_email" />
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-3">
			<label for="vendor" >Vendor</label>
		</div>
		<div class="col-md-6">
			<select name="vendor" id="vendor" class="form-control">
		<option value="">--select--</option>
		<?php foreach($vendors as $d){
			echo "<option value='$d->vendor_id'>$d->vendor_name, $d->vendor_city, $d->vendor_phone</option>";
		}
		?>
		</select>
		
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-3">
			<label class="control-label">Gender</label>
		</div>
		<div class="col-md-6">
			<label class="control-label">
				<input type="radio" name="gender" value="M" checked />Male
			</label>
			<label class="control-label">
				<input type="radio" name="gender" value="F" />Female
			</label>
			<label class="control-label">
				<input type="radio" name="gender" value="O" />Other
			</label>
		</div>
	</div>	
	<div class="form-group">
		<div class="col-md-3">
			<label for="designation" > Designation</label>
		</div>
		<div class="col-md-6">
		<input type="text" class="form-control" placeholder=" Designation" id="designation" name="designation" />
		</div>
	</div>
	
   	<div class="col-md-3 col-md-offset-4">
	<button class="btn btn-lg btn-primary btn-block" type="submit" value="submit">Submit</button>
	</div>
</div>
