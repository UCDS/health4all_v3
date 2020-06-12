<script type="text/javascript">
$(function(){
			$("#department option").hide().attr('disabled',true);
		$("#hospital").on('change',function(){
			var hospital_id=$(this).val();
			$("#department option").hide().attr('disabled',true);
			$("#department option[class="+hospital_id+"]").show().attr('disabled',false);
		});
});
</script>
		<div class="col-md-8 col-md-offset-2">
		<center>
		<strong><?php if(isset($msg)){ echo $msg;}?></strong>
		<h3><u>Add Area</u></h3></center><br>
	<?php echo validation_errors(); echo form_open('sanitation/add/area',array('role'=>'form')); ?>
	
	<div class="form-group">
	    <label for="area_name" class="col-md-4">Area Name</label>
	    <div class="col-md-8">
	    <input type="text" class="form-control" placeholder="area name" id="area_name" name="area_name"/>
	    </div>
	</div>
	<div class="form-group">
	    <label for="facility_name" class="col-md-4">Hospital Name</label>
	    <div class="col-md-8">
	   <select name="hospital" id="hospital" class="form-control">
		<option value="">Hospital</option>
		<?php foreach($hospitals as $d){
			echo "<option value='$d->hospital_id'>$d->hospital</option>";
		}
		?>
		</select>
	   </div>
	   <div class="form-group">
	    <label for="department" class="col-md-4">Department</label>
	    <div class="col-md-8">
	   <select name="department" id="department" class="form-control">
		<option value="">department</option>
		<?php foreach($departments as $d){
			echo "<option value='$d->department_id' class='$d->hospital_id'>$d->department</option>";
		}
		?>
		</select>
	   </div>
	</div>
	<div class="form-group">
	    <label for="area_types" class="col-md-4">Area type</label>
	    <div class="col-md-8">
	   <select name="area_type" id="area_type" class="form-control">
		<option value="">area type</option>
		<?php foreach($area_types as $d){
			echo "<option value='$d->area_type_id'>$d->area_type</option>";
		}
		?>
		</select>
	   </div>
	</div>

	<div class="col-md-3 col-md-offset-4">
	<button class="btn btn-lg btn-primary btn-block" type="submit">submit</button>
	</div></div>
	</div>