<div class="col-md-12 col-md-offset-2">
<div class="col-md-10 col-sm-9">		
		<hr>
		<h4>Add Qualification</h4>
		<?php echo form_open('recruitment_masters/add_qualification',array('class'=>'form-custom')); ?>
				
		<div class="col-md-5">
		<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">Qualification<font color='red'>*</font></span>
		  <input class="form-control"type="text" class="form-control" name="qualification" id="qualification"  aria-describedby="basic-addon1" required>
		</div>		
		</div>
		<div class="col-md-5">
		<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">Qualification Level <font color='red'></font></span>
		  <input class="form-control"type="text" class="form-control"  id="qualification_level_id" name="qualification_level_id"  aria-describedby="basic-addon1">
		</div>		
		</div>
		<input type="submit"  class="btn btn-primary btn-sm" value="add_qualification" name="add_qualification" />
		</form>
		<br/>
		<?php if(isset($msg)) echo $msg;?>
	</div>

</div>