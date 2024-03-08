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
	<center>
		<?php 
		echo validation_errors('<div class="alert alert-danger">', '</div>');
		if(isset($msg)){  ?>
	<div class="alert alert-info"><?php echo $msg; ?></div><?php } ?>
		<h3>Add Generic Details</h3></center><br>
	<center>
	<?php echo form_open('consumables/generic_item/add_generic',array('class'=>'form-group','role'=>'form','id'=>'add_generic')); ?></center>
		<div class="col-md-12 col-md-offset-2">
			<div class="row">
				<div class="col-md-4">			<!--Generic name-->
					<div class="form-group">
						<label for="generic" class="col-md-6 col-lg-6">Generic Name<font color='red'>*</font></label>
						<input type="text" class="form-control" placeholder=" Enter Generic Name" id="generic_name" name="generic_name" required />
					</div>
				</div>														<!--end of generic_name-->
				<div class="col-md-4">					<!--Item type-->
					<div class="form-group">
						<label for="item_type" class="col-md-6 col-lg-6"> Item Type<font color='red'>*</font></label>
						<select name="item_type" id="item_type" class="form-control" required>
						<option value="">Select</option>
						<?php foreach($item_type as $d){
							echo "<option value='$d->item_type_id'>$d->item_type</option>";
						}?>
						</select>
					</div>		
				</div>																<!--end of item type-->
		
				<div class="col-md-4">					<!-- Drug type-->
						<label for="drug_type" class="col-md-6 col-lg-6"> Drug Type</label>
					<div class="form-group">
						<select name="drug_type" id="drug_type" class="form-control">
							<option value="">Select</option>
							<?php foreach($drug_type as $d){
								echo "<option value='$d->drug_type_id'>$d->drug_type</option>";
							}?>
						</select>
					</div>
				</div>																<!--end of Drug type-->
</div>		
   	<div class="col-md-3 col-md-offset-5">
		<button class="btn btn-primary " type="submit" value="submit">Submit</button><!--Submit button-->
	</div><!--Submit button end-->
</div>
