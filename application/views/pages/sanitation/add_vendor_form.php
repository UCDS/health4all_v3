 <link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >

<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript">
$(function(){
	$("#agreement_date").Zebra_DatePicker({
	
	});
	$("#probable_date_of_completion,#agreement_completion_date").Zebra_DatePicker({
	
	});
});
</script>
		<div class="col-md-8 col-md-offset-2">
		<center>
		<strong><?php if(isset($msg)){ echo $msg;}?></strong>
		<h3><u>Vendor</u></h3></center><br>
	<?php echo validation_errors(); echo form_open('sanitation/add/vendor',array('role'=>'form')); ?>
	
	<div class="form-group">
	    <label for="vendor_name" class="col-md-4">Vendor name</label>
	    <div class="col-md-8">
	    <input type="text" class="form-control" placeholder="Vendor_name" id="vendor_name" name="vendor_name"/>
	    </div>
	</div>
	
	<div class="form-group">
		<label for="vendor_address" class="col-md-4">Vendor Address</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Vendor Address" id="vendor_address" name="vendor_address" />
		</div>
	</div>
	<div class="form-group">
		<label for="contact_name" class="col-md-4">Contact Name</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Contact Name" id="contact_name" name="contact_name" />
		</div>
	</div>	
	<div class="form_group">
		<label for="contact_number" class="col-md-4">Contact Number</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="contact number" id="contact_number" name="contact_number" />
		</div>
	</div>
	<div class="form_group">
		<label for="contact_email" class="col-md-4">Contact email</label>
		<div  class="col-md-8">
		<input type="email" class="form-control" placeholder="contact Email" id="contact_email" name="contact_email" />
		</div>
	</div>
    <div class="col-md-3 col-md-offset-4">
	<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
	</div></div>