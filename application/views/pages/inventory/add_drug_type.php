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
		<h3><u>ADD DRUG TYPE DETAILS</u></h3></center><br>
	<?php echo form_open('masters/add/drug_type',array('role'=>'form')); ?>
	<div class="form-group">
		<label for="drug_type" class="col-md-4">Drug Name<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Drug Name" id="drug_name" name="drug_name" />
		</div>
	</div>
	<div class="form-group">
		<label for="description" class="col-md-4"> Description<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder=" Description" id="description" name="description" />
		</div>
	</div>
	
	<!--<div class="form-group">
		<label for="agency_address" class="col-md-4">Agency Address</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Agency Address" id="agency_address" name="agency_address" />
		</div>
	</div>
	<div class="form-group">
		<label for="agency_contact_name" class="col-md-4">Agency Contact Name</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Agency Contact Name" id="agency_contact_name" name="agency_contact_name" />
		</div>
	</div>	
	<div class="form-group">
		<label for="agency_designation" class="col-md-4">Agency Designation</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Agency Designation" id="agency_designation" name="agency_designation" />
		</div>
	</div>		
	<div class="form_group">
		<label for="agency_contact_no" class="col-md-4">Agency Contact No</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Agency Contact No" id="agency_contact_no" name="agency_contact_no" />
		</div>
	</div>
	<div class="form_group">
		<label for="agency_email_id" class="col-md-4">Agency Email Id</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Agency Email Id" id="agency_email_id" name="agency_email_id" />
		</div>
	</div>

	<div class="form_group">
		<label for="account_no" class="col-md-4">Account No</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Account No" id="account_no" name="account_no" />
		</div>
	</div>
	<div class="form_group">
		<label for="bank_name" class="col-md-4">Bank Name</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Bank Name" id="bank_name" name="bank_name" />
		</div>
	</div>
		<div class="form_group">
		<label for="branch" class="col-md-4">Branch</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Branch" id="branch" name="branch" />
		</div>
	</div>
		<div class="form_group">
		<label for="pan" class="col-md-4">Pan</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Pan" id="pan" name="pan" />
		</div>
	</div>
-->		
   	<div class="col-md-3 col-md-offset-4">
	<button class="btn btn-lg btn-primary btn-block" type="submit" value="submit">Submit</button>
	</div>
