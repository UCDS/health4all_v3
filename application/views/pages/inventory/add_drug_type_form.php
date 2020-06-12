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
		<h3>Add Drug Type Details</h3></center><br>
	<center><?php echo validation_errors(); echo form_open('consumables/add/drug_type',array('role'=>'form')); ?></center>
	<div class="form-group">
		<label for="drug_type" class="col-md-4">Drug Type<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Drug Type" id="drug_type" name="drug_type" />
		</div>
	</div>
	<div class="form-group">
		<label for="description" class="col-md-4"> Description<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder=" Description" id="description" name="description" />
		</div>
	</div>
	
   	<div class="col-md-3 col-md-offset-4">
	<button class="btn btn-lg btn-primary btn-block" type="submit" value="submit">Submit</button>
	</div>
</div>