<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript">
$(function(){
	$("#warranty_start_date,#warranty_end_date").Zebra_DatePicker();
	$("#supply_date").Zebra_DatePicker({
		onSelect : function(date){
		$("#warranty_start_date").val(date);
		}
	});
	$("#department").on('change',function(){
		var department_id=$(this).val();
		$("#unit option,#area option").hide();
		$("#unit option[class="+department_id+"],#area option[class="+department_id+"]").show();
	});
	//$("#vendor").on('change',function(){
	//	var vendor_id=$(this).val();
	//	$("#contact_person_id option").hide();
	//	$("#contact_person_id option[class="+vendor_id+"]").show();
	//});
});
</script>
<center>
	<?php
		echo validation_errors();
		if (isset($msg)){?>
		<div class="alert alert-info">
		<?php echo $msg ?>
		</div>
		<?php } ?>
		<h3> Add Drug type</h3>
</center></br>
	<?php 
	echo form_open('consumables/drug_type/add_drug_type',array('class'=>'form-group','role'=>'form','id'=>'add_drug_type')); ?></center>
	
	<div class="col-xs-6 col-md-offset-3">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">		<!--Drug type-->
					<div class="form-group">
						<label for="drug type">Drug Type<font style="color:red">*</font></label>
						<input type="text" class="form-control" placeholder="Enter Drug Type" id="drug_type" name="drug_type" required>
					</div>
				</div>													<!--end of drug type-->
			<div class="col-xs-12 col-sm-12 col-md-6  col-lg-3">		<!--Description-->
				<div class="form-group">
					<label for="Inputdescription">Description</label>
					<textarea class="form-control" name="description" rows="2" placeholder="Enter Description about Drug Type"></textarea>
				</div>
			</div>												<!--end of Description-->
	</div>
</div>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
			<center><button class="btn btn-md btn-primary" type="submit" value="submit">Submit</button></center>
			</div>
		</div>
	</div>
</div>
</div>