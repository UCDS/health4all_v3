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
		if(!$this->input->post('navigate_edit')){
			echo validation_errors('<div class="alert alert-danger">', '</div>');
		}
		if(isset($msg)){  ?>
	<div class="alert alert-info"><?php echo $msg; ?></div><?php } ?>
		<h3>Edit Generic Details</h3></center><br>
		
	<center>
	<?php echo form_open('consumables/generic_item/edit',array('class'=>'form-group','role'=>'form','id'=>'edit')); ?></center>
	<div class="col-md-6 col-md-offset-3">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<h4>Generic Item ID: <?= $item->generic_item_id; ?> <input type="hidden" class="sr-only" name="generic_item_id" id="generic_item_id" value="<?= $item->generic_item_id;?>"></h4>
					<br>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">			<!--Generic name-->
					<div class="form-group">
						<label for="generic" class="col-md-6 col-lg-6">Generic Name<font color='red'>*</font></label>
						<input type="text" class="form-control" value="<?= $item->generic_name;?>" placeholder=" Enter Generic Name" id="generic_name" name="generic_name" required />
					</div>
				</div>														<!--end of generic_name-->
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">					<!--Item type-->
			<div class="form-group">
				<label for="item_type" class="col-md-6 col-lg-6"> Item Type<font color='red'>*</font></label>
				<select name="item_type" id="item_type" class="form-control" required>
				<option value="">Select</option>
				<?php foreach($item_type as $d){
					if($d->item_type_id === $item->item_type_id){
						echo "<option value='$d->item_type_id' selected>$d->item_type</option>";
					}else{
						echo "<option value='$d->item_type_id'>$d->item_type</option>";
					}
				}?>
				</select>
			</div>		
		</div>																<!--end of item type-->
		
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">					<!-- Drug type-->
				<label for="drug_type" class="col-md-6 col-lg-6"> Drug Type</label>
			<div class="form-group">
				<select name="drug_type" id="drug_type" class="form-control">
					<option value="">Select</option>
					<?php foreach($drug_type as $d){
						if($item->drug_type_id && $d->drug_type_id === $item->drug_type_id){
							echo "<option value='$d->drug_type_id' selected>$d->drug_type</option>";
						}else{
							echo "<option value='$d->drug_type_id'>$d->drug_type</option>";
						}
					}?>
				</select>
			</div>
		</div>																<!--end of Drug type-->
</div>		
   	<div class="col-md-3 col-md-offset-5">
		<button class="btn btn-primary " type="submit" value="submit">Submit</button><!--Submit button-->
	</div><!--Submit button end-->
</div>
