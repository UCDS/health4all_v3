<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >

<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript">
$(function(){
	$("#agreement_date").Zebra_DatePicker({
		direction:false
	});
	$("#p robable_date_of_completion,#agreement_completion_date").Zebra_DatePicker({
		direction:1
	});
});
</script>
		<div class="col-md-8 col-md-offset-2">
		<center>
		<strong><?php if(isset($msg)){ echo $msg;}?></strong>
		<h3><u>Add Hospital</u></h3></center><br>
	<?php echo validation_errors(); echo form_open('sanitation/add/hospital',array('role'=>'form')); ?>
	<div class="form-group">
		<label for="hospital_name" class="col-md-4">Hospital Name</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Hospital Name" id="hospital_name" name="hospital_name" />
		</div>
	</div>
	<div class="form-group">
	    <label for="facility" class="col-md-4">Facility types</label>
	    <div class="col-md-8">
	   <select name="facility_type" id="district" class="form-control">
		<option value="">Select</option>
		<?php foreach($facility_type as $d){
			echo "<option value='$d->facility_type_id'>$d->facility_type</option>";
		}
		?>
		</select>
	   </div>
	 </div>
	   <div class="form-group">
	    <label for="village_town" class="col-md-4">Village/Town</label>
	    <div class="col-md-8">
	   <select name="village_town" class="form-control">
		<option value="">Select</option>
		<?php foreach($village_town as $d){
			echo "<option value='$d->village_town_id'>$d->village_town</option>";
		}
		?>
		</select>
	   </div>

	<div class="form-group">
	    <label for="address" class="col-md-4">Address</label>
	    <div class="col-md-8">
	    <input type="address" class="form-control" placeholder="Address" id="Address" name="address"/>
	    </div>
	</div>

	<div class="form-group">
	    <label for="latitude" class="col-md-4">Latitude</label>
	    <div class="col-md-8">
	    <input type="text" class="form-control" placeholder="Latitude" id="Latitude" name="latitude"/>
	    </div>
	</div>
	<div class="form-group">
	    <label for="longitude" class="col-md-4">Longitude</label>
	    <div class="col-md-8">
		 <input type="text" class="form-control" placeholder="Longitude" id="Longitude" name="longitude"/>
	    </div>
	</div>
	<div class="col-md-3 col-md-offset-4">
	<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
	</div>
	</div></div>