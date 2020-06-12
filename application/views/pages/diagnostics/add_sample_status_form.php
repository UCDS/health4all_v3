<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<div class="col-md-8 col-md-offset-2">
	<center>
		<strong><?php if(isset($msg)){ echo $msg;}?></strong>
		<h3>Add Sample Status</h3>
	</center><br>
	<center>
		<?php  echo validation_errors(); echo form_open('diagnostics/add/sample_status',array('role'=>'form')); ?>
	</center>
	
	<div class="form-group">
		<label for="sample_status" class="col-md-4">Sample Status<font color='red'>*</font></label>
		<div  class="col-md-8">
			<input type="text" class="form-control" placeholder="Sample Status" id="sample_status" name="sample_status" />
		</div>
	
	</div>
   	<div class="col-md-3 col-md-offset-4">
	</br>
	<button class="btn btn-lg btn-primary btn-block" type="submit" value="submit" name="sample_status_add">Submit</button>
	</div>
</div>
