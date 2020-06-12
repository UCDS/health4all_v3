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
		<h3>Add Dosage Details</h3></center><br>
	<center><?php echo validation_errors(); echo form_open('consumables/add/dosages',array('role'=>'form')); ?></center>
	<div class="form-group">
		<label for="dosages" class="col-md-4">Dosage<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder=" Dosage" id="dosage" name="dosage" />
		</div>
	</div>
	<div class="form-group">
		<label for="dosage_unit" class="col-md-4"> Dosage Unit</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder=" Dosage unit" id="dosage_unit" name="dosage_unit" />
		</div>
	</div>
	
		
   	<div class="col-md-3 col-md-offset-4">
	<button class="btn btn-lg btn-primary btn-block" type="submit" value="submit">Submit</button>
	</div>
</div>