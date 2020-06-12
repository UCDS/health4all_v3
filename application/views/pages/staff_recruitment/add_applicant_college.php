<div class="col-md-12 col-md-offset-2">
	<div class="col-md-10 col-sm-9">
		<h4>Add College</h4>
		<?php echo form_open('recruitment_masters/add_applicant_college',array('class'=>'form-custom')); ?>
		<div class="col-md-6">
		<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">College Name <font color='red'>*</font></span>
		  <input class="form-control"type="text" class="form-control" id="hospital"  name="college_name"  aria-describedby="basic-addon1" required>
		</div>		
		</div>
                <div class="col-md-6">
		<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">Affiliated to: <font color='red'>*</font></span>
		  <select class="form-control" id="affiliated_to" name="affiliated_to" >
                        <option value="">University</option>
                        <?php foreach($universities as $university){
                            echo "<option value='".$university->college_id."'>".$university->college_name."</option>";
                        }?>
                   </select>
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
                        <label for="email" class="control-label">University Email</label>
                        <input type="email" class="form-control date" placeholder="Email" id="email" name="email" />
                    </div>			
		</div>
                <div class="col-md-6">
		<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">University<font color='red'>*</font></span>
		  <label class="control-label">
				<input type="radio" name="university_flag" value="1" checked />Yes
			</label>
			<label class="control-label">
				<input type="radio" name="university_flag" value="2" />No
			</label>			
		</div>
		</div>
		<div class="col-md-6">
		<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">Institution Type <font color='red'>*</font></span>
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
		
		<input type="submit" value="Add Hospital" class="btn btn-primary btn-sm" name="add_applicant_college" />
		</form>
		<br/>
		<?php if(isset($msg)) echo $msg; ?>
                <div class="alert alert-info" role="alert">
                    <ul>
                        <li>Please input Institution Name and Address to add Institution to the database.</li>
                        <li>Once a Institution is added to the database it will always remain in the database.</li>
                        <li>Institution added here will reflect in the Add Applicant page.</li>
                    </ul>
                </div>
	</div>
</div>

	