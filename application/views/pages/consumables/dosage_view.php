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
		
		
		<h3>  Add Dosage</h3>
</center></br>
	<?php 
	echo form_open('consumables/dosage/add_dosage',array('class'=>'form-horizontal','role'=>'form','id'=>'add_dosage')); ?></center>
	
	<div class="col-xs-6 col-md-offset-3">
		<div class="container">
			<div class="row">							<!--Dosage-->
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
					<div class="form-horizontal">
						<label for="dosage">Dosage<font style="color:red">*</font></label>
						<input type="number" min="1" step="1" class="form-control" placeholder="Enter Dosage" id="dosage" name="dosage" required/>
					</div>
				</div>
			<div>										<!--end of Dosage-->
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">	<!--Dosage Unit-->
		<div class="form-group">
			<label for="dosage_unit">Dosage Unit<font style="color:red">*</font></label>
			<input type="text" class="form-control" placeholder="Enter Dosage Unit" id="dosage_unit" name="dosage_unit" required>
		</div>
	</div>												<!--end of dosage unit-->
	</div>	
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
