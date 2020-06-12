<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript">
$(function(){
	$("#hospital").on('change',function(){
		var hospital_id=$(this).val();
		$("#area option").hide().attr('disabled',true);
		$("#area option[class="+hospital_id+"]").show().attr('disabled',false);
	});
});
</script>
		<div class="col-md-8 col-md-offset-2">
		<center>
		<strong><?php if(isset($msg)){ echo $msg;}?></strong>
		<h3><u>Add Facility Activity</u></h3></center><br>
	<?php echo validation_errors(); echo form_open('sanitation/add/facility_activity',array('role'=>'form')); ?>
	
	<div class="form-group">
	    <label for="facility_area" class="col-md-4"> Area Activity</label>
	    <div class="col-md-8">
	    <select name="area_activity" id="district" class="form-control">
		<option value="">Area Activity</option>
		<?php foreach($area_activity as $d){
			echo "<option value='$d->area_activity_id'>$d->activity_name</option>";
		}
		?>
		</select>
		
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
	<div class="form-group">
	    <label for="area_activity" class="col-md-4">Area</label>
	    <div class="col-md-8">
		<select name="area" id="area" class="form-control">
		<option value="">Area</option>
		<?php foreach($area as $d){
			echo "<option value='$d->area_id' class='$d->hospital_id'>$d->area_name - $d->department</option>";
		}
		?>
		</select>
			   
	   </div>
	</div>
	<div class="col-md-3 col-md-offset-4">
	<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
	</div>
</div></div>