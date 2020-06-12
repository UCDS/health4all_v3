<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<div class="col-md-8 col-md-offset-2">
	<center>
		<strong><?php if(isset($msg)){ echo $msg;}?></strong>
		<h3>Add Lab Units</h3>
	</center><br>
	<center>
		<?php  echo validation_errors(); echo form_open('diagnostics/add/lab_unit',array('role'=>'form')); ?>
	</center>
	
	<div class="form-group">
		<label for="lab_unit" class="col-md-4">Lab Unit<font color='red'>*</font></label>
		<div  class="col-md-8">
			<input type="text" class="form-control" placeholder="Lab Unit" id="lab_unit" name="lab_unit" />
		</div>
			<input class="form-control" id="submit" name="submit" value="submit" type="hidden"/>
	</div>
   	<div class="col-md-3 col-md-offset-4">
	</br>
	<button class="btn btn-lg btn-primary btn-block" type="submit" value="submit" name="lab_unit_add">Submit</button>
	</div>
</div>