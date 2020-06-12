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
		<h3><u>Add Facility Type</u></h3></center><br>
	<?php echo validation_errors(); echo form_open('sanitation/add/facility_type',array('role'=>'form')); ?>
	
	<div class="form-group">
	    <label for="facility_types" class="col-md-4">Facility Types</label>
	    <div class="col-md-8">
	    <input type="text" class="form-control" placeholder="Facility Types" id="facility_types" name="facility_type" />
	    </div>
	</div>

	</div>
	<div class="col-md-3 col-md-offset-4">
	<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
	</div>
	</div>