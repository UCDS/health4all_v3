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
		<h3>Add Generic Details</h3></center><br>
	<center><?php echo validation_errors(); echo form_open('consumables/add/generic',array('role'=>'form')); ?></center>
	<div class="form-group">
		<label for="generic" class="col-md-4">Generic Name<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder=" Generic name" id="dosage" name="generic_name" />
		</div>
	</div>
	<div class="form-group">
		<label for="item_type" class="col-md-4"> Item Type<font color='red'>*</font></label>
		<div  class="col-md-8">
		
		<select name="item_type" id="division" class="form-control">
		<option value="">Items</option>
		<?php foreach($item_type as $d){
			echo "<option value='$d->item_type_id'>$d->item_type</option>";
		}
		?>
		</select>
		</div></div>
	<div class="form-group">
		<label for="drug_type" class="col-md-4"> Drug Type</label>
		<div  class="col-md-8">
		
		<select name="drug_type" id="division" class="form-control">
		<option value="">Drugs</option>
		<?php foreach($drug_type as $d){
			echo "<option value='$d->drug_type_id'>$d->drug_type</option>";
		}
		?>
		</select>
</div></div>

		
   	<div class="col-md-3 col-md-offset-4">
	<button class="btn btn-lg btn-primary btn-block" type="submit" value="submit">Submit</button>
	</div>
</div>
