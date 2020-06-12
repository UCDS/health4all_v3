<div class="col-md-8 col-md-offset-2">
	<center>
		<strong><?php if(isset($msg)){ echo $msg;}?></strong>
		<h3>Add Vendor Type Details</h3></center><br>
		<?php echo validation_errors(); echo form_open('vendor/add/vendor_type',array('class'=>'form-horizontal','role'=>'form','id'=>'add_vendor_type')); ?>
	</center>
	<div class="form-group">
		<label for="vendor_type" class="col-md-4">Vendor Type<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Vendor Type" id="vendor_type" name="vendor_type"  required />
		</div>
	</div>
   	<div class="col-md-3 col-md-offset-4">
		<button class="btn btn-lg btn-primary btn-block" type="submit" value="submit">Submit</button>
	</div>
</div>