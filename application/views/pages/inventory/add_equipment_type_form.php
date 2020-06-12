
<div class="col-md-8 col-md-offset-2">
	<center>
		<strong><?php if(isset($msg)){ echo $msg;}?></strong>
		<h3>Add Equipment Type Details</h3></center><br>
		<?php echo validation_errors(); echo form_open('equipments/add/equipment_type',array('class'=>'form-horizontal','role'=>'form','id'=>'add_equipment_type')); ?>
	</center>
	<div class="form-group">
		<label for="equipment_type" class="col-md-4">Equipment Type<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Equipment Type" id="equipment_type" name="equipment_type"  required />
		</div>
	</div>
   	<div class="col-md-3 col-md-offset-4">
		<button class="btn btn-lg btn-primary btn-block" type="submit" value="submit">Submit</button>
	</div>
</div>
