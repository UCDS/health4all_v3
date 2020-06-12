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
		<h3><u>Add Districts</u></h3></center><br>
	<?php echo validation_errors(); echo  form_open('sanitation/add/districts',array('role'=>'form')); ?>
	<div class="form-group">
		<label for="district" class="col-md-4" > Districts</label>
		<div  class="col-md-8">
			<input name="district" class="form-control" type="text" />
		</div>
	</div>	
	<div class="form-group">
		<label for="state" class="col-md-4" > state</label>
		<div  class="col-md-8">
		<select name="states" id="state" class="form-control">
		<option value="">--SELECT--</option>
		<?php foreach($states as $d){
			echo "<option value='$d->state_id'>$d->state</option>";
		}
		?>
		</select>
		</div>
	</div>	
	<div class="form-group">
	<label for="latitude" class="col-md-4">Latitude</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Latitude" id="latitude" name="latitude" />
		</div>
	</div>
	<div class="form-group">
		<label for="longitude" class="col-md-4">Longitude</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Logitude" id="longitude" name="longitude" />
		</div>
	</div>	
	<div class="col-md-3 col-md-offset-4">
	<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
	</div></div>