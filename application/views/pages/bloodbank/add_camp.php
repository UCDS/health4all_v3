
	<div class="col-md-10 col-sm-9">
		
		<hr>
		<h4>Add Camp</h4>
		<?php echo form_open('bloodbank/staff/add_camp',array('class'=>'form-custom')); ?>
				
		<div class="col-md-5">
		<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">Camp Name<font color='red'>*</font></span>
		  <input class="form-control"type="text" class="form-control" name="camp" id="camp"  aria-describedby="basic-addon1" required>
		</div>		
		</div>
		<div class="col-md-5">
		<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">Address <font color='red'>*</font></span>
		  <input class="form-control"type="text" class="form-control"  id="location" name="location"  aria-describedby="basic-addon1" required>
		</div>		
		</div>
		<input type="submit"  class="btn btn-primary btn-sm" value="Add Camp" name="add_camp" />
		</form>
		<br/>
		<?php if(isset($msg)) echo $msg;?>
                
                <div class="alert alert-info" role="alert">
                    <ul>
                        <li>Please input Camp Name and Address to add Camp to the database.</li>
                        <li>Once a Camp is added to the database it will always remain in the database.</li>
                        <li>Camp added here will reflect in the Place page.</li>
                    </ul>
                </div>
	</div>

	