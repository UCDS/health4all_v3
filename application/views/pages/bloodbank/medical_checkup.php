<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<script type="text/javascript"
 src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
 <script type="text/javascript"
 src="<?php echo base_url();?>assets/js/jquery.timeentry.min.js"></script>
 <script type="text/javascript"
 src="<?php echo base_url();?>assets/js/jquery.mousewheel.js"></script>
<script>
	$(function(){
		var rowcount=1;
		$("#donation_date").Zebra_DatePicker({
			direction:false
			
		});
		$(".time").timeEntry();
	});
</script>
<div class="col-md-10 col-sm-9">
	<?php 
	echo validation_errors();
	if(isset($msg)) {
		echo $msg;
		echo "<br />";
		echo "<br />";
	}
	?>
	<div class="alert alert-info">
	<?php
	foreach($donor_details as $donor){
		echo "Donation ID: ".$donor->donation_id;
		echo " | Name: ".$donor->name;
		echo " | Age: ".$donor->age;
		echo " | Blood Group: ".$donor->blood_group;
		$donation_id=$donor->donation_id;
	}
	?>
	</div>

	<div class="panel panel-default">
	<div class="panel panel-heading">
	<h4>Medical checkup</h4>
	</div>
	<?php echo form_open("bloodbank/register/medical_checkup/0/$donation_id",array('class'=>'form-custom'));?>
	<div class="panel-body" >
	<label class="col-md-4"> Weight : </label>
	<div class="form-group col-md-8" style="margin-top:5px;margin-bottom:5px;">
			<input type="text" placeholder="Weight" class="form-control" id="weight" name="weight" required />Kgs
		</div><br/>
	<label class="col-md-4" >Pulse : </label>
	<div class="form-group col-md-8" style="margin-top:5px;margin-bottom:5px;">
			<input type="text" placeholder="Pulse" class="form-control" id="pulse" name="pulse" required />/min
	</div><br />
	<label class="col-md-4" >Hb: </label> 
	<div class="form-group col-md-8" style="margin-top:5px;margin-bottom:5px;">
		<input type="text" placeholder="Hb" class="form-control" id="hb" name="hb" required />gm/dL
	</div><br />
		<label class="col-md-4" >Bp: </label>  
	<div class="form-group col-md-8" style="margin-top:5px;margin-bottom:5px;">
		<input type="text" placeholder="SBP" class="form-control" id="sbp" name="sbp" required />/
		<input type="text" placeholder="DBP" id="dbp" class="form-control"name="dbp" required />
	</div><br />
		<label class="col-md-4" >Temperature(Farheit)</label> 
	<div class="form-group col-md-8" style="margin-top:5px;margin-bottom:5px;">
		<input type="text" placeholder="Temperature" class="form-control" id="temperature" name="temperature" required />
	</div><br />
	<label class="col-md-4" >Date of Donation: </label> 
	<div class="form-group col-md-8" style="margin-top:5px;margin-bottom:5px;">
		<input type="text" placeholder="Date of Donation" class="form-control" id="donation_date" name="donation_date" required />
	</div><br />
	<label class="col-md-4" >Donation time: </label> 
	<div class="form-group col-md-8" style="margin-top:5px;margin-bottom:5px;">
		<input type="text" placeholder="Donation time" class="time form-control"  id="donation_time" name="donation_time" required />
	</div><br />
	</div>
	<div class="panel-footer" style="margin-top:5px;margin-bottom:5px;">
		<div class="form-group">
			<input type="submit" value="Submit" class="btn btn-primary" name="update_medical" />
		</div>
	</div>
	</form>
</div>
</div>
