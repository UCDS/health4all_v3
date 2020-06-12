<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<script>
</script>
<div class="col-md-8 col-md-offset-2">
	<center>
		<strong><?php if(isset($msg)){ echo $msg;}?></strong>
		<h3>Add Assay Name </h3>
	</center><br>
	<center>
		<?php echo validation_errors(); echo form_open('diagnostics/add_assay_name',array('role'=>'form','class'=>'form-custom','id'=>'add_assay_name')); ?>
	</center>
	
	<div class="form-group">
		
		<label for="assay_name" class="col-md-4">Assay Name<font color='red'>*</font></label>
		<div  class="col-md-8 test_name" id="add_test_name" >
			<input type="text" class="form-control" placeholder="Assay Name" id="assay_name" form="add_assay_name" name="assay_name" required />
		</div>
		<br />
		<br />

   	<div class="col-md-3 col-md-offset-4">
	</br>
	<button class="btn btn-lg btn-primary btn-block" type="submit" value="submit" name="submit">Submit</button>
	</div>
</div>