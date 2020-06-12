
	<div class="row">
            
	    <h1>Welcome to Health4All- <small><font color="green">Helpline Number(080-47103744)</font></small><br/>
        <small>A Free and Open Source application supported by <a href="http://www.yousee.in" target="_blank">YouSee</a></small></h1>
		
		<br />
		<?php 
		if($this->session->userdata('hospital')){
				$hospital=$this->session->userdata('hospital');
				echo "<div class='well'><b>Current Hospital set to</b> : $hospital[hospital], Place: $hospital[place], District: $hospital[district]</div>";
			}
		?>
			
		<p>
		<br />
		<?php
		if(count($hospitals)>1){
		echo form_open('home',array('role'=>'form','class'=>'form-custom')); ?>
		<label class="control-label"> Select a Hospital  - 
		<select name="organisation" class="form-control">
		<option value="--Select--" selected disabled >--Select--</option>
		<?php 
			$i=0;
			foreach($hospitals as $row){
				echo "<option id='hospital_$i' value='$row->hospital_id'>$row->hospital, $row->place, $row->district</option>";
			}
		?>
		</select>
 		 <input class="btn btn-primary " type="submit" value="Submit" />
		</form>
		<?php } ?>

		<br />
		<br />
		<br />
		</p>
                <div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="">Note:</span>
                    Each of the below modules has User Access Control, you will be able to access modules to which you have permission. Contact Administrator for access.
                </div>
                <div class="alert alert-info" role="alert">
                    <ul>
                        <li>
                            Patients(Module)
                            <ul>
                                <li>Out Patient Registration: Input the Out Patient details.<br> Note: You need to create an Out Patient Form in 'Settings' to be able to see this page.</li>
                                <li>In Patient Registration: Input the In Patient details. <br> Note: You need to create an In Patient Form in 'Settings' to be able to see this page.</li>
                                <li>View Patients: View the list of patients already registered with the hospital.</li>
                                <li>Update Patients: Update the information of existing patients. <br> Note: Fields that already have data cannot be edited.</li>
                            </ul>
                        </li>
                        <li>
                            Services(Module)
                            <ul>
                                <li>Diagnostics(Module): Here we capture various diagnostic tests that were performed by the hospital on each patient.</li>
                                <li><strong>BloodBank</strong>(Module): Here we capture all the Blood donations that were done in the hospital along with the Blood issues done to various patients.</li>
                                <li>Sanitation(Module)</li>
                            </ul>
                        </li>
                        <li>
                            Resources(Module)
                            <ul>
                                <li>HR(Module): Here we capture hospital staff information.</li>
                                <li>Equipment(Module): Here we capture the hospital equipment information.</li>
                                <li>Consumables(Module): Work in progress.</li>
                                <li>Vendor(Module): Here we capture vendor information.</li>
                            </ul>
                        </li>
                        <li>
                            Reports(Module)
                            <ul>
                                <li>
                                    Summary Reports
                                    <ul>
                                        <li>OP Summary: Report showing number of Out Patient visits per department, in a given age group.</li>
                                        <li>IP Summary: Report showing number of In Patient visits per department, in a given age group.</li>
                                        <li>IP/OP Trends: Report showing number of Patient visits by Day/Month/Year in the selected period.</li>
                                        <li>ICD Code Summary: Report summary categorizing the diagnosis of each patient visit by ICD code.</li>
                                        <li>Outcome Summary: Report summary categorizing the final outcome(Dischage/LAMA/Absconded/Death) of each visit</li>
                                        <li><strong>BloodBank</strong> Reports(Module): Contains various BloodBank reports.</li>
                                        <li>Audiology Report: Summary of new born hearing screening results.</li>
                                        <li>Sanitation Evaluation</li>
                                        <li>Orders Summary: Summary of diagnostics tests ordered by department. </li>
                                        <li>Sensitivity Report: Summary of reactivity of Culture Sensitivity tests, by Antibiotic, and by Organism.</li>
                                    </ul>
                                </li>
                                <li>Detailed Reports
                                    <ul>
                                        <li>OP Detail: Report listing out Out Patient visits during a period, with all Patient Details.</li>
                                        <li>IP Detail: Report listing out In Patient visits during a period, with all Patient Details.</li>
                                        <li>ICD Code Detail: Report listing out Patient visits during a period, with all Patient Details along with ICD code.</li>
                                        <li>Sanitation Evaluation</li>
                                    </ul>
                                </li>
                            </ul>
                    </ul>
                </div>
                <div class="alert alert-success" role="alert">
                    <ul>
                        <li>Settings
                            <ul>
                                <li>Forms
                                <ul>
                                    <li>Create New: In this page you can create a custome OP/IP form.</li>
                                </ul>
                                </li>
                                <li>
                                    Users
                                    <ul>
                                        <li>
                                            Create New: In this page you can create a new user to the application and also define his UAC for this application.
                                            <br> Note: To add a new user the user must first be added as staff in HR(Module).
                                        </li>
                                        <li>
                                            Edit User: Here we can edit the exisiting user add or remove access to various modules.
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
                    
	</div>
