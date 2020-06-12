<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<div class="col-md-12 col-md-offset-2">
	<center>
		<strong><?php if(isset($msg)){ echo $msg;}?></strong>
		<h3>Add Drive Parameter</h3>
	</center><br>
	
	<center>
		<?php echo validation_errors(); ?>
	</center>
	<?php 
	echo form_open('recruitment_masters/add_selection_parameter',array('class'=>'form-horizontal','role'=>'form','id'=>'add_applicant')); 
	?>
    
	<div class="form-group">
		<div class="col-md-3">
			<label for="first_name" class="control-label">Parameter Label</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Parameter Label" id="parameter_label" name="parameter_label" required />
		</div>
	</div>
        
	<div class="form-group">
            <div class="col-md-3">
                    <label class="control-label">Parameter Value Type</label>
            </div>
            <div class="col-md-6">
                <label class="control-label">
                        <input type="radio" name="parameter_max_value" value="date" checked />Date 
                </label>
                <label class="control-label">
                        <input type="radio" name="parameter_max_value" value="time" checked />Time 
                </label>
                <label class="control-label">
                        <input type="radio" name="parameter_max_value" value="number" />Number
                </label>
                <label class="control-label">
                        <input type="radio" name="parameter_max_value" value="text" />Text
                </label>
            </div>
	</div>	
	       
        <div class="form-group">
            <div class="col-md-3">
                    <label for="drive_id" class="control-label">Recruitment Drive</label>
            </div>
            <div class="col-md-6">
                <select class="form-control" id="drive_id" name="drive_id" >
                    <option value="">Select Recruitment Drive</option>
                    <?php foreach($recruitment_drives as $drive){
                        echo "<option value='".$drive->drive_id."'>".$drive->name.", ".$drive->place."</option>";
                    }?>
                </select>
            </div>
        </div>
	
            
        
        
   	<div class="form-group col-md-9">
            <button class="btn btn-lg btn-primary btn-block" type="submit" value="submit">Submit</button>
	</div>
</form>
</div>
