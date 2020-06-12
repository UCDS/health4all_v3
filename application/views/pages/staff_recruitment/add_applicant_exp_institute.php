<div class="col-md-12 col-md-offset-2">
	<div class="col-md-10 col-sm-9">
		<h4>Add Hospital</h4>
		<?php echo form_open('recruitment_masters/add_prev_institute',array('class'=>'form-custom')); ?>
		<div class="col-md-6">
		<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">Hospital name <font color='red'>*</font></span>
		  <input class="form-control"type="text" class="form-control" id="hospital_name"  name="hospital_name"  aria-describedby="basic-addon1" required>
		</div>		
		</div>
		<div class="col-md-6">
		<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">	Address <font color='red'>*</font></span>
                  <textarea class="form-control" class="form-control" id="location" name="address"  placeholder="Institution address..." aria-describedby="basic-addon1" required>
                      
                  </textarea>
		</div>		
		</div>
		<div class="col-md-6">
		<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">	District <font color='red'>*</font></span>
		  <select class="form-control" id="district_id" name="district_id" >
                        <option value="">District</option>
                        <?php foreach($districts as $district){
                            echo "<option value='".$district->district_id."'>".$district->district."</option>";
                        }?>
                   </select>
		</div>		
		</div>
		<div class="col-md-6">
		<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">	Institution Type <font color='red'>*</font></span>
		  <label class="control-label">
				<input type="radio" name="public_institution_flag" value="1" checked />Public Institution
			</label>
			<label class="control-label">
				<input type="radio" name="public_institution_flag" value="2" />NPO
			</label>
			<label class="control-label">
				<input type="radio" name="public_institution_flag" value="3" />Private Institution
			</label>
		</div>
		</div>
		
		<input type="submit" value="Add Hospital" class="btn btn-primary btn-sm" name="add_hospital" />
		</form>
		<br/>
		<?php if(isset($msg)) echo $msg; ?>
                <div class="alert alert-info" role="alert">
                    <ul>
                        <li>Please input Hospital Name and Address to add Hospital to the database.</li>
                        <li>Once a Hospital is added to the database it will always remain in the database.</li>
                        <li>Hospital added here will reflect in the Add Applicant page.</li>
                    </ul>
                </div>
	</div>
</div>
	