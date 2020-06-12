
		<div class="col-md-8 col-md-offset-2">
		<center>
		<strong><?php if(isset($msg)){ echo $msg;}?></strong>
		<h3><u>Area Types</u></h3></center><br>
	<?php echo form_open('sanitation/add/area_types',array('role'=>'form')); ?>
	
	<div class="form-group">
	    <label for="area_type" class="col-md-4">Area Type</label>
	    <div class="col-md-8">
	    <input type="text" class="form-control" placeholder="area type" id="area_type" name="area_type"/>
	    </div>
	</div>
	<div class="col-md-3 col-md-offset-4">
	<button class="btn btn-lg btn-primary btn-block" type="submit">submit</button>
	</div>
	</div>