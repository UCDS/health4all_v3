<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<div class="col-md-8 col-md-offset-2">
<center>
<strong><?php if(isset($msg)){ echo $msg;}?></strong>
<h3>Add Test Method</h3>
</center><br>
<center>
<?php echo validation_errors(); echo form_open('diagnostics/add/test_method',array('role'=>'form')); ?>
</center>
<div class="form-group">
<label for="test_type" class="col-md-4">Test Method<font color='red'>*</font></label>
<div class="col-md-8">
<input type="text" class="form-control" placeholder="Test Method" id="test_method" name="test_method" />
</div>
</div>
<div class="col-md-3 col-md-offset-4">
</br>
<button class="btn btn-lg btn-primary btn-block" type="submit" value="submit" name="submit">Submit</button>
</div>
</div>