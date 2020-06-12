
	<div class="col-md-10 col-sm-9">
		<div class="well">
			<h4>Blood Bank - <?php echo $hospitaldata['hospital'];?>!</h4>
			<br />
			<br />
                        <div class="alert alert-danger" role="alert">
                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                            <span class="">Current place set to:</span>
                           <?php 
                                $place=$this->session->userdata('place');
                                echo $place['name']; ?>
                        </div>
			<br />
			<br />
		<?php 
		echo form_open('bloodbank/user_panel/place',array('class'=>'form-custom')); ?>
		Change :

			<select name="camp" id="camps" class="form-control" >
				<option value="">--Select Location--</option>
				<?php foreach($camps as $camp){
					echo "<option size='30' value='".$camp->camp_id."' id='camp".$camp->camp_id."'>$camp->camp_name, $camp->location</option>";
				?>
					
				<?php
				}
				?>
				</select>
				<input type="submit" value="Select Camp" name="set_camp"class="btn btn-primary btn-sm" />
				<input type="submit" value="BloodBank" name="reset" class="btn btn-primary btn-sm" />
		</form>
		</div>
		<?php if(isset($msg)) echo $msg; ?>
            <div class="alert alert-info" role="alert">
                <ul>
                    <li>
                        To set the Camp where the blood is being collected please select the camp and click on Select Camp button.
                    </li>
                    <li>
                        If the blood is being collected in the Hospital/BloodBank itself click on BloodBank.
                    </li>
                    <li>
                        Once a Camp is set it remains the same till it is changed or till logout.
                    </li>
                    <li>
                        To add a new camp click <a href="<?php echo base_url();?>bloodbank/staff/add_camp">here</a>.
                    </li>
                    <li>
                        You can start entering Donor data in the Walk In page.
                    </li>
                </ul>
            </div>
</div>