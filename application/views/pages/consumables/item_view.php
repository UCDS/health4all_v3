<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/ckeditor.js"></script>
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
});
</script>
<center>
<?php if(isset($msg)){  ?>
	<div class="alert alert-info"><?php echo $msg; ?>
	</div>
<?php } ?>
			
	<h3>Add Item Details</h3>
</center></br>
<center>
	<?php echo validation_errors('<div class="alert alert-danger">', '</div>'); ?>
</center>
	<?php 
	echo form_open('consumables/item/add_item',array('class'=>'form-group','role'=>'form','id'=>'add_item')); ?></center>
	
	<div class="col-xs-12 col-md-offset-2">
		<div class="container">
			<div class="row">
				<div class="col-md-4">		<!--Item name-->
					<div class="form-group">
						<label for="item_name"> Item name<font style="color:red">*</font></label>
						<input type="text" class="form-control" placeholder="Enter Item Name" id="item_name" name="item_name" required/>
					</div>
				</div>													<!--end of Item name-->
					<!--Generic name-->
				<div class="col-md-4">
					<div class="form-group">
						<label for="generic_name"> Generic name<font color='red'>*</font></label>
						<select name="generic_name" id="generic_name" class="form-control" required>
							<option value="">Select</option>
							<?php foreach($generic_name as $d){
								echo "<option value='$d->generic_item_id'>$d->generic_name</option>";
							}?>
						</select>
					</div>
				</div>														<!--end of Generic name-->
				<div class="col-md-4">			
					<div class="form-group">
						<label for="item_form" >Item form<font style="color:red">*</font></label>
						<select name="item_form" id="item_form" class="form-control" required>
							<option value="">Select</option>
							<?php foreach($item_form as $d){
								echo "<option value='$d->item_form_id'>$d->item_form</option>";
							}?>
						</select>
					</div>
				</div>														<!--end of Item form-->
				<div class="col-md-6">				<!--Description-->
					<div class="form-group">
						<label for="Inputdescription">Description</label>
						<textarea class="form-control" id="desc" name="description" rows="2" placeholder="Enter Description about Item Name"></textarea>
					</div>
				</div>
				<script>
					ClassicEditor
						.create( document.querySelector( '#desc' ), {
							toolbar: [ 'bold', 'italic', 'bulletedList', 'numberedList' ]
						} )
						.catch( error => {
								console.error( error );
						} );
				</script>
				<div class="col-md-4">
					<div class="form-group">
						<label for="model" >Model</label>
						<input type="text" class="form-control" placeholder="Enter Model" id="model" name="model" />
					</div>
				</div>																<!--end of Description-->
			</div>
		</div>
<!--end of Model-->
<div class="container">
	<div class="row">
		<div class="col-md-3"> </div>
		<div class="col-md-6">
			<center><button class="btn btn-md btn-primary" type="submit" value="submit" style="margin-top:30px;">Submit</button></center><!--Submit button-->
		</div><!--Submit button end-->
		<div class="col-md-3"> </div>
	</div>
</div>
</div>
</div>
</div>