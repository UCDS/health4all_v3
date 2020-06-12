<script type="text/javascript">	
	$(function(){
		$("#start_date").Zebra_DatePicker();
        });
</script>
<div class="col-md-12 col-md-offset-2">
<div class="col-md-10 col-sm-9">		
		<hr>
		<h4>Add Recruitment Drive</h4>
		<?php echo form_open('recruitment_masters/add_recruitment_drive',array('class'=>'form-custom')); ?>
				
		<div class="col-md-5">
		<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">Drive Name:<font color='red'>*</font></span>
		  <input class="form-control"type="text" class="form-control" name="name" id="name"  aria-describedby="basic-addon1" required>
		</div>		
		</div>
		<div class="col-md-5">
		<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">Place<font color='red'></font></span>
		  <input class="form-control"type="text" class="form-control"  id="place" name="place"  aria-describedby="basic-addon1">
		</div>                    
		</div>
                <div class="col-md-5">
		<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">Start Date<font color='red'></font></span>
                  <input type="text" class="form-control date" placeholder="Date of Birth" id="start_date" name="start_date" />		  
		</div>
                    
		</div>
		<input type="submit"  class="btn btn-primary btn-sm" value="add_recruitment_drive" name="add_recruitment_drive" />
		</form>
		<br/>
		<?php if(isset($msg)) echo $msg;?>
	</div>

</div>	