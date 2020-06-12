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
		<h3><u>Vendor Contracts</u></h3></center><br>
	<?php echo validation_errors(); echo form_open('sanitation/add/vendor_contracts',array('role'=>'form')); ?>
	
	<div class="form-group">
		<label for="vendor_name" class="col-md-4">Vendor Name</label>
		<div  class="col-md-8">
<select name="vendor_contracts" id="vendor_name" class="form-control">
		<option value="">--SELECT--</option>
		<?php foreach($vendor as $d){
			echo "<option value='$d->vendor_id'>$d->vendor_name</option>";
		}
		?>
		</select>	
	</div>
	</div>
	<div class="form-group">
		<label for="facility_name" class="col-md-4">Facility Name</label>
		<div  class="col-md-8">
<select name="facility_name" id="facility_name" class="form-control">
		<option value="">--SELECT--</option>

		<?php foreach($facility_name as $d){

			echo "<option value='$d->facility_id'>$d->facility_name</option>";
		}
		?>
		</select>	
	</div>
	</div>
	<div class="form-group">

		<label for="from_date" class="col-md-4">From Date</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="From Date" id="from_date" name="from_date" />
		</div>
	</div>
	<div class="form_group">
		<label for="to_date" class="col-md-4">To Date</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="To Date" id="to_date" name="to_date"/>
		</div>
	</div>
	<div class="form_group">
		<label for="status" class="col-md-4">Status</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="status" id="status" name="status" />
		</div>
	</div>
	<div class="col-md-3 col-md-offset-4">
	<button class="btn btn-lg btn-primary btn-block" type="submit">submit</button>
</div>	</div>
