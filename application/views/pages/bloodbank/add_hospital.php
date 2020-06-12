
	<div class="col-md-10 col-sm-9">
		<h4>Add Hospital</h4>
		<?php echo form_open('bloodbank/staff/add_hospital',array('class'=>'form-custom')); ?>
		<div class="col-md-6">
		<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">Hospital name <font color='red'>*</font></span>
		  <input class="form-control"type="text" class="form-control" id="hospital"  name="hospital"  aria-describedby="basic-addon1" required>
		</div>		
		</div>
		<div class="col-md-3">
		<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">	Place <font color='red'>*</font></span>
		  <input class="form-control"type="text" class="form-control" id="location" name="location"   aria-describedby="basic-addon1" required>
		</div>		
		</div>
		<div class="col-md-3">
		<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">	District <font color='red'>*</font></span>
		  <input class="form-control"type="text" class="form-control" id="district" name="district"  aria-describedby="basic-addon1" required>
		</div>		
		</div><br><br><br>
		<div class="col-md-3">
		<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">	State <font color='red'>*</font></span>
		  <input class="form-control"type="text" class="form-control" name="state" id="state"  aria-describedby="basic-addon1" required>
		</div>
		</div>
		
		<input type="submit" value="Add Hospital"   class="btn btn-primary btn-sm"name="add_hospital" />
		</form>
		<br/>
		<?php if(isset($msg)) echo $msg; ?>
                <div class="alert alert-info" role="alert">
                    <ul>
                        <li>Please input Hospital Name and Address to add Hospital to the database.</li>
                        <li>Once a Hospital is added to the database it will always remain in the database.</li>
                        <li>Hospital added here will reflect in the blood request page.</li>
                    </ul>
                </div>
	</div>

	