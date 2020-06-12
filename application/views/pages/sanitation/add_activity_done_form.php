	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >

<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript">
$(function(){
    $("#date").Zebra_DatePicker({
        
    });
});
</script>
<?php echo validation_errors(); ?>
	
	<div class="col-md-8 col-md-offset-2">
	<h3><?php if(isset($msg)) echo $msg;?></h3>	
	<center><h3><u>Add Activity done</u></h3></center><br><br>
	<?php echo form_open('sanitation/add/activity_done',array('role'=>'form')); ?>
	<div class="form-group">

	<label for="text" class="col-md-4">First Name</label>
		<div  class="col-md-8">
		<select name="staff" id="first_name" class="form-control">
		<option value="">--SELECT--</option>
		<?php foreach($staff as $d){
			echo "<option value='$d->staff_id'>$d->first_name</option>";
		}
		?>
		</select>
		</div>
		</div>

		<label for="text" class="col-md-4">Activity Name</label>
		<div  class="col-md-8">
		<select name="facility_activity" id="activity_name" class="form-control">
		<option value="">--SELECT--</option>
		<?php foreach($facility_activity as $d){
			echo "<option value='$d->area_activity_id'>$d->activity_name</option>";
		}
		?>
		</select>
		</div>
		
		

	<div class="form-group">
	
		<label for="time" class="col-md-4">Time</label>
		<div  class="col-md-8">
		<input type="time" class="form-control" placeholder="time" id="time" name="time" />
		</div>
	</div>
	
	
	<div class="form-group">

		<label for="date" class="col-md-4">Date</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="date" id="date" name="date" />
		</div>
	</div>
<!--	<div class="form-group">
		<label for="division" class="col-md-4" >Division</label>
		<div  class="col-md-8">
		<select name="division" id="division" class="form-control">
		<option value="">--SELECT--</option>
		<?php foreach($divisions as $d){
			echo "<option value='$d->division_id'>$d->division</option>";
		}
		?>
		</select>
		</div>
	</div>	
	<div class="form-group">
	<label for="longitude" class="col-md-4">Longitude</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Longitude" id="longitude" name="longitude" />
		</div>
	</div>
	<div class="form-group">
	<label for="latitude" class="col-md-4">Latitude</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Latitude" id="latitude" name="latitude" />
		</div>
	</div>

	</div>-->
   	<div class="col-md-3 col-md-offset-4">
	<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
	</div>
	</form>
	</div>