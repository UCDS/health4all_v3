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
		<h3><u>Add Village Town</u></h3></center><br>
	<?php echo form_open('sanitation/add/village_town',array('role'=>'form')); ?>
	
	<div class="form-group">
	    <label for="village_town" class="col-md-4">Village/Town</label>
	    <div class="col-md-8">
	    <input type="text" class="form-control" placeholder="Village/Town" id="village_town" name="village_town"/>
	    </div>
	</div>
	
	
	<div class="form-group">
		<label for="pin_code" class="col-md-4">Pin Code</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Pin Code" id="pin_code" name="pin_code" />
		</div>
	</div>	
	<div class="form-group">
		<label for="pin_code" class="col-md-4">District</label>
		<div  class="col-md-8">
		<select name="district" id="district" class="form-control">
		<option value="">--SELECT--</option>
		<?php foreach($districts as $d){
			echo "<option value='$d->district_id'>$d->district</option>";
		}
		?>
		</select>
		</div>
	</div>
	<div class="form_group">
		<label for="latitude" class="col-md-4">Latitude</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Latitude" id="latitude" name="latitude"/>
		</div>
	</div>
	<div class="form_group">
		<label for="longitude" class="col-md-4">Longitude</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Longitude" id="longitude" name="longitude" />
		</div>
	</div>
	<div class="col-md-3 col-md-offset-4">
	<button class="btn btn-lg btn-primary btn-block" type="submit">submit</button>
	</div>
</div>