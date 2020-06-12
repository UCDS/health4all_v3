<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<div class="col-md-8 col-md-offset-2">
	<center>
		<strong><?php if(isset($msg)){ echo $msg;}?></strong>
		<h3>Add Specimen Type</h3>
	</center><br>
	<center>
		<?php  echo validation_errors(); echo form_open('diagnostics/add/specimen_type',array('role'=>'form')); ?>
	</center>
	
	<div class="form-group">
		<label for="specimen_type" class="col-md-4">Specimen Type<font color='red'>*</font></label>
		<div  class="col-md-8">
			<input type="text" class="form-control" placeholder="Specimen Type" id="specimen_type" name="specimen_type" />
		</div>
	
	</div>
   	<div class="col-md-3 col-md-offset-4">
		</br>
	<button class="btn btn-lg btn-primary btn-block" type="submit" value="submit" name="submit">Submit</button>
	</div>
</div>
