<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >

<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript">
$(function(){
	$("#agreement_date").Zebra_DatePicker({
		direction:false
	});
	$("#probable_date_of_completion,#agreement_completion_date").Zebra_DatePicker({
		direction:1
	});
});
</script>
		<div class="col-md-8 col-md-offset-2">
		<center>
		<strong><?php if(isset($msg)){ echo $msg;}?></strong>
	    <h3><u>Add Area Activity</u></h3></center><br>
	<?php echo form_open('sanitation/add/area_activity',array('role'=>'form')); ?>
	<div class="form-group">
	<label for="area_type" class="col-md-4">Area type</label>
		<div  class="col-md-8">
		
		<select name="area_type" id="area_type" class="form-control">
		<option value="">--SELECT--</option>
		<?php foreach($area_types as $d){
			echo "<option value='$d->area_type_id'>$d->area_type</option>";
		}
		?>
		</select>
  </div>
	</div>
	<div class="form	-group">
	    <label for="activity_name" class="col-md-4">Activity name</label>
	    <div class="col-md-8">
	    <input type="text" class="form-control" placeholder="Area Activity name" id="activity_name" name="activity_name"/>
	    </div>
	</div>
	
	<div class="form-group">
		<label for="frequency" class="col-md-4">Frequency</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Frequency" id="frequency" name="frequency" />
		</div>
	</div>
	<div class="form-group">
		<label for="weightage" class="col-md-4">Weightage</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Weightage" id="weightage" name="weightage" />
		</div>
	</div>	
   
	<div class="form-group">
		<label for="frequency_type" class="col-md-4">Frequency Type</label>
		<div  class="col-md-8">
		<select class="form-control" name="frequency_type">
			<option value="" selected disabled>Select</option>
			<option value="Weekly">Weekly</option>
			<option value="Monthly">Monthly</option>
		</select>
		</div>
	</div>
	<div class="col-md-3 col-md-offset-4">
	<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
	</div>
	</div>
