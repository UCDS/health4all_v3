<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<style>
.mandatory{
	color:red;
	cursor:default;
	font-size:25px;
	font-weight:bold;
}
.form-field{
	min-height:50px;
}
</style>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.timeentry.min.js"></script>
<script type="text/javascript">
$(function(){
	$(".date").Zebra_DatePicker();
	$(".time").timeEntry();
	
	$("#dob").Zebra_DatePicker({
		view:"years",
		direction:false,
		onSelect: function(rdate,ydate,date){
				getAge(date);
		}
	});
	<?php if($patient && $patient->gender != 'F') { ?>
	$("#spouse_name").prop('disabled',true);
	<?php } ?>
	$(".gender").on('change',function(){
		if($(this).val()=="M"){
			$("#spouse_name").prop('disabled',true);
		}
		else{
			$("#spouse_name").prop('disabled',false);
		}
	});
	
	$("#department").on('change',function(){
		var department_id=$(this).val();
		$("#unit option,#area option").hide();
		$("#unit option[class='"+department_id+"'],#area option[class='"+department_id+"']").show();
	});
	if($(".mlc:radio").val()==0)
	$(".mlc:text").parent().parent().hide();
	$(".mlc:radio").on('change',function(){
		if($(this).val()=='1'){
			$(".mlc:text,.mlc_field").parent().parent().show();
		}
		else{
			$(".mlc:text,.mlc_field").parent().parent().hide();
		}
	});
});
function DaysInMonth(Y, M) {
    	with (new Date(Y, M, 1, 12)) {
        setDate(0);
        return getDate();
	} 
}	
	
function getAge(dateString) {
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    var d = today.getDate() - birthDate.getDate();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--; m += 12;
	}
	if (d < 0) {
        m--;
        d += DaysInMonth(age, m);
    	}
   document.getElementsByName("age_years")[0].value=age;
   document.getElementsByName("age_months")[0].value=m;
   document.getElementsByName("age_days")[0].value=d;
}
<!-- Scripts for printing output table -->
function printDiv(i)
{
var content = document.getElementById(i);
var pri = document.getElementById("ifmcontentstoprint").contentWindow;
pri.document.open();
pri.document.write(content.innerHTML);
pri.document.close();
pri.focus();
pri.print();
}

</script>
		<?php if(isset($duplicate)) { ?>
		<!-- If duplicate IP no is found then it displays the error message -->
			<div class="alert alert-danger">Entered IP/Patient Manual ID Number already exists.</div>
		<?php } 
		else if(isset($registered)){ ?>
		<iframe id="ifmcontentstoprint" style="height: 0px; width: 0px; position: absolute;display:none"></iframe>
		<div id="print-div" class="sr-only" style="width:100%;height:100%;"> 
		<?php $this->load->view($print_layout);?>
		</div>
                <!-- Script for printing MLC complaint -->
                <?php
                
                if($registered->mlc==1){ ?>
                <div class="sr-only" id="print-MLC-div" style="width:100%;height:100%;"> 
                    <?php 
						if($registered->visit_type == "OP"){
							$this->load->view("pages/print_layouts/accident_record");
						}
						else
						$this->load->view("pages/print_layouts/MLC_complaint");
                        $offset=4;
                    ?>
				</div>
                <?php }
                else $offset=5;?>
		<!--we divide the form into panel-header,panel-body and panel-footer -->
		<div class="row">
			<div class="panel panel-success col-md-6 col-md-offset-3" >
				<div class="panel-heading">		<h5><?php echo $form_name; ?> - Inserted Successfully</div>
				<div class="panel-body">
					<table class="table table-bordered">
						<tr>
							<th>Patient ID</th>
							<td><?php echo $registered->patient_id;?></td>
							<th><?php echo $form_type;?> No. </th>
							<td><?php echo $registered->hosp_file_no;?></td>
						</tr>
						<tr>
<!-- here we are printing the details of patient -->
							<th>Patient Name</th>
							<td><?php echo $registered->name;?></td>
							<th>Age</th>
							<td>
								<?php
									if($registered->age_years!=0) echo $registered->age_years."Y ";
									if($registered->age_months) echo $registered->age_months."M "; 
									if($registered->age_days) echo $registered->age_days."D "; 
									if($registered->age_years==0 && $registered->age_months == 0 && $registered->age_days==0) echo "0 Days";
								?>
							</td>
						</tr>
						<tr> 
							<th>Gender</th>
							<td><?php echo $registered->gender;?></td>
							<th>Department</th>
							<td><?php echo $registered->department;?></td>
						</tr>
					</table>
				</div>
<!--here in the panel-footer print button is displayed -->				
				<div class="panel-footer">
                                    <button type="button" class="btn btn-primary col-md-offset-<?php echo $offset;?>" onclick="printDiv('print-div')" autofocus>Print</button>
                                        <?php if($registered->mlc==1){?>
                                            <button type="button" class="btn btn-warning" onclick="printDiv('print-MLC-div')" autofocus>Print MLC</button>
                                        <?php }?>
                                <?php        foreach($functions as $f){ 
				if($f->user_function == "Update Patients"  || $f->user_function == "Clinical" || $f->user_function == "Diagnostics" || $f->user_function == "Procedures" || $f->user_function == "Prescription" || $f->user_function == "Discharge") { ?>
                                            <button type="button" class="btn btn-warning" onclick="$('#select_patient_<?php echo $registered->visit_id1;?>').submit()" autofocus>Update Patient Info</button>
                                            <?php echo form_open('register/update_patients',array('role'=>'form','id'=>'select_patient_'.$registered->visit_id1));?>
                                            <input type="text" class="sr-only" hidden value="<?php echo $registered->visit_id1;?>" form="select_patient_<?php echo $registered->visit_id1;?>" name="selected_patient" />
                                </form>
                                <?php break; }}?>                                
				</div>
			</div>
			</div>
		<?php } ?>
<!--the form is partitioned based on the no. of columns -->
		<?php 
			if($columns==1){ $class="col-md-12";}
			else if($columns==2){$class="col-md-6";}
			else if($columns==3){$class="col-md-4";}
			$class.=" form-field";
		?>
		<?php echo validation_errors(); ?>
		<?php if($form_type=="OP" || count($patient)>0){ ?>
		<?php echo form_open("register/custom_form/$form_id",array('role'=>'form','class'=>'form-custom')); ?>
		<input type="text" class="sr-only" value="<?php echo $form_type;?>" name="form_type" />
		<div class="row">
		<div class="panel panel-default">
		<div class="panel-heading">
			<div class="pull-right">
				<div class="form-group">
				<?php if($patient){ ?>
				<label class="control-label">Patient ID</label>
				<input type="text" name="patient_id" class="form-control" size="5" value="<?php echo $patient->patient_id;?>" readonly />
				<?php } ?>
				<?php if($form_type=="IP"){ ?>
				<label class="control-label">IP No</label>
				<?php if($update){ ?>
				<input type="text" name="visit_id" class="form-control sr-only" size="3" value="<?php echo $patient->visit_id;?>" readonly />
				<?php } ?>
                                <input type="text" name="hosp_file_no" <?php if(!$update){ ?> value='<?php //echo $ip_count[0]->count; ?>' <?php } ?><?php if($update){?> readonly value="<?php echo $patient->hosp_file_no;?>" <?php } ?> class="form-control" size="5" required />
                               
				<?php } 
                                    foreach($fields as $field){
					if($field->field_name == "patient_id_manual")
					{
					
                                    ?>
						<label class="control-label">Patient ID Manual<?php if($field->mandatory) { ?><span class="mandatory">*</span><?php } ?></label>
						<input type="text" name="patient_id_manual" class="form-control" placeholder="Patient ID Manual" value="<?php if($patient) echo $patient->patient_id_manual;?>" <?php if($field->mandatory) echo "required"; if($form_type=="IP") echo "disabled";?> />
						
                                    <?php 
						break;
					}
                                    }?>
                                
				<label class="control-label">Date</label>
				<?php 
					if($update) $date = date("d-M-Y",strtotime($patient->admit_date));
					else $date=date("d-M-Y");
				?>
				<input type="text" name="date" class="form-control date" style="width:150px"  value="<?php echo $date;?>" required />
				</div>
				<div class="form-group">
				<label class="control-label">Time</label>
				<?php 
					if($update) $time = date("g:iA",strtotime($patient->admit_time));
					else $time=date("g:iA");
				?>
				<input type="text" name="time" class="form-control time" style="width:100px" value="<?php echo $time;?>"  required />
				</div>
			</div>
			<h4><?php echo $form_name; ?></h4>
		</div>
		<div class="panel-body">
			<?php
			foreach($fields as $field){
				switch($field->field_name){
				case "first_name": ?>   
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">First Name<?php if($field->mandatory) { ?><span class="mandatory">*</span><?php } ?></label>
						<input type="text" name="first_name" class="form-control" placeholder="First" value="<?php if($patient) echo $patient->first_name;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
				<?php 
					break;
					
					case "last_name": ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Last Name<?php if($field->mandatory) { ?><span class="mandatory">*</span><?php } ?></label>
						<input type="text" name="last_name" class="form-control" placeholder="Last" value="<?php  if($patient) echo $patient->last_name;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
				<?php 
					break;
					
					case "dob":?>
					
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Birth Date<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="dob" class="form-control" id="dob" value="<?php if($update) echo $patient->dob;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
					
					<div class="<?php echo $class;?> sr-only">
						<div class="form-group">
						<label class="control-label">Age<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="age_years" class="form-control" size="1"  value="<?php if($patient)  echo $patient->age_years;?>" <?php if($field->mandatory) echo "required"; ?> />Y
						<input type="text" name="age_months" class="form-control" size="1" value="<?php if($patient)  echo $patient->age_months;?>" <?php if($field->mandatory) echo "required"; ?> />M
						<input type="text" name="age_days" class="form-control" size="1"  value="<?php if($patient)  echo $patient->age_days;?>" <?php if($field->mandatory) echo "required"; ?> />D
						</div>
					</div>
				<?php 
					break;
					
					case "age":?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Age<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="age_years" class="form-control" size="1"  value="<?php if($patient)  echo $patient->age_years;?>" <?php if($field->mandatory) echo "required"; ?> />Y
						<input type="text" name="age_months" class="form-control" size="1" tabindex="1000"  value="<?php if($patient)  echo $patient->age_months;?>" <?php if($field->mandatory) echo "required"; ?> />M
						<input type="text" name="age_days" class="form-control" size="1"  tabindex="1001" value="<?php if($patient)  echo $patient->age_days;?>" <?php if($field->mandatory) echo "required"; ?> />D
						</div>
					</div>
				<?php 
					break; 					
					case "gender" : ?>
					<div class="<?php echo $class;?>">
						<div class="radio">
						<label class="control-label"><input type="radio" class="gender" value="M" name="gender" <?php if($patient)  if($patient->gender=="M") echo " checked ";?> <?php if($field->mandatory) echo "required"; ?> />Male</label>
						<label class="control-label"><input type="radio" class="gender" value="F" name="gender" <?php if($patient)  if($patient->gender=="F") echo " checked ";?> <?php if($field->mandatory) echo "required"; ?> />Female</label>
						<label class="control-label"><input type="radio" class="gender" value="O" name="gender" <?php if($patient)  if($patient->gender=="O") echo " checked ";?> <?php if($field->mandatory) echo "required"; ?> />Others</label>
						<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?>
						</div>
					</div>
				<?php 
					break;					
					case "address" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Address<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<textarea rows="1" cols="30" name="address" class="form-control" <?php if($field->mandatory) echo "required"; ?>><?php if($patient) echo $patient->address;?></textarea>
						</div> 
					</div>
				<?php 
					break;
					case "place":?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Place<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="place" class="form-control" value="<?php if($patient) echo $patient->place;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
				<?php 
					break;
					case "country" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Country<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<select name="country" id="country" onchange="getStates()" class="form-control" <?php if($field->mandatory) echo "required"; ?> style="max-width:200px !important;">
						<option value="">--Select--</option>
						<?php  						
						foreach($countries as $country){
							echo "<option value='".$country->country."'";
							if($_SERVER['REQUEST_METHOD'] != "POST") if($country->country==$this->session->userdata('country_id')) echo " selected ";
							//if($patient) if($state->state_id==$patient->state_id) echo " selected ";
							echo ">".$country->name."</option>";
						}
						?>
						</select>
						</div>
					</div>
				<?php 
					break;
					case "state" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">State<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<select id="state" name="state" onchange="getDistrict()" class="form-control" <?php if($field->mandatory) echo "required"; ?> style="width:250px;">
						<option value="">--Select--</option>
						<?php
						foreach($states_codes as $state){
							echo "<option value='".$state->state_code."'";
							if($state->state_code==$this->session->userdata('state_id')) echo " selected ";
							echo ">".$state->state_name."</option>";
						}
						?>
						</select>
						</div>
					</div>
				<?php 
					break;
					case "district" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">District<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<select name="district" id="district" class="form-control" <?php if($field->mandatory) echo "required"; ?> style="width:200px;">
						<option value="">--Select--</option>
						<?php  						
						foreach($districts as $district){
							echo "<option value='".$district->district_id."'";
							if($district->district_id==$this->session->userdata('district_id')) echo " selected ";
							echo ">".$district->district."</option>";
						}
						?>
						</select>
						</div>
					</div>
				<?php 
					break;
					case "phone" :  ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Phone<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="phone" class="form-control" value="<?php if($patient) echo $patient->phone;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
				<?php 
					break;
					case "alt_phone" :  ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Alt. Phone<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="alt_phone" class="form-control" value="<?php if($patient) echo $patient->alt_phone;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
				<?php 
					break;
					case "father_name": ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Father's Name<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="father_name" class="form-control" value="<?php if($patient) echo $patient->father_name;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
				
				<?php 
					break;
					case "mother_name" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Mother's Name<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="mother_name" class="form-control" value="<?php if($patient) echo $patient->mother_name;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
				<?php 
					break;
					case "spouse_name" :  ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Spouse Name<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="spouse_name" id="spouse_name" class="form-control" value="<?php if ($patient) echo $patient->spouse_name;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
				<?php 
					break;				
					case "id_proof_type" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Id Proof Type<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<select name="id_proof_type" class="form-control" <?php if($field->mandatory) echo "required"; ?>>
						<option value="">--Select--</option>
						<?php 
						foreach($id_proof_types as $id_proof_type){
							echo "<option value='".$id_proof_type->id_proof_type_id."'";
							if($patient) if($id_proof_type->id_proof_type_id==$patient->id_proof_type_id) echo " selected ";
							echo ">".$id_proof_type->id_proof_type."</option>";
						}
						?>
						</select>
						</div>
					</div>
				<?php 
					break;
				    case "id_proof_no" :  ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Id Proof No<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="id_proof_no" id="id_proof_no" class="form-control" value="<?php if($patient) echo $patient->id_proof_number;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>	
				<?php 
					break;		
					case "occupation" :  ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Occupation<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<select name="occupation" class="form-control" <?php if($field->mandatory) echo "required"; ?>>
						<option value="">--Select--</option>
						<?php 
						foreach($occupations as $occupation){
							echo "<option value='".$occupation->occupation_id."'";
							if($patient) if($occupation->occupation_id==$patient->occupation_id) echo " selected ";
							echo ">".$occupation->occupation."</option>";
						}
						?>
						</select>
						</div>
					</div>
				<?php 
					break;			
					case "gestation_type" :  ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
					    <label class="control-label">Gestation Type<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<select name="gestation_type" class="form-control" <?php if($field->mandatory) echo "required"; ?>>
							<option value="select">--select--</option>
							<option value="long_peroid">Long Period</option>
							<option value="short_period">Short Period</option>
						</select>
						<?php if($patient) echo $patient->occupation;?>
						<?php if($field->mandatory)?> 
						</div>
					</div>
				<?php 
					break;					
					case "education_level" :  ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Education Level<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="education_level" id="education_level" class="form-control" value="<?php if($patient) echo $patient->educational_level;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>	
				
				<?php 
					break;			
					case "blood_group" :  ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Blood Group<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<select name="blood_group" class="form-control">
							<option value="">--Select--</option> 
							<option value="A+" <?php if($patient->blood_group == "A+") echo " selected ";?>>A+</option>
							<option value="A-" <?php if($patient->blood_group == "A-") echo " selected ";?>>A-</option>
							<option value="B+" <?php if($patient->blood_group == "B+") echo " selected ";?>>B+</option>
							<option value="B-" <?php if($patient->blood_group == "B-") echo " selected ";?>>B-</option>
							<option value="AB+" <?php if($patient->blood_group == "AB+") echo " selected ";?>>AB+</option>
							<option value="AB-" <?php if($patient->blood_group == "AB-") echo " selected ";?>>AB-</option>
							<option value="O+" <?php if($patient->blood_group == "O+") echo " selected ";?>>O+</option>
							<option value="O-" <?php if($patient->blood_group == "O-") echo " selected ";?>>O-</option>
						</select>
						<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?>
						</div>
					</div>
				<?php 
					break;					
					case "education_qualification" :  ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Education Qualification <?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<select name="education_qualification" class="form-control" <?php if($field->mandatory) echo "required"; ?>>
							<option value="">Select</option>
							<option value="SSC">ssc</option>
							<option value="INTERMEDIATE">Intermediate</option>
							<option value="B.TECH">B.tech</option>
							<option value="M.TECH">M.tech</option>
				            <option value="M.Sc">M.Sc</option>
							<option value="Undergraduate">Undergraduate</option>
						</select> 
						<?php if($patient) echo $patient->education_qualification ;?>
						<?php if($field->mandatory) echo "required"; ?>
						</div>
					</div>
				<?php 
					break;			
					case "gestation" :  ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Gestation<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="gestation" class="form-control" value="<?php if($patient) echo $patient->gestation ;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
				<?php 
					break;
						case "insurance_case" : ?>
					<div class="<?php echo $class;?>">
						<div class="radio">
						<label class="control-label">Insurance Case<input type="radio" class="insurance_case" value="Yes" name="insurance_case" <?php if($patient)  if($patient->insurance_case=="Yes") echo " checked ";?> <?php if($field->mandatory) echo "required"; ?> />Yes</label>
						<label class="control-label"><input type="radio" class="insurance_case" value="No" name="insurance_case" <?php if($patient)  if($patient->insurance_case=="No") echo " checked ";?> <?php if($field->mandatory) echo "required"; ?> />No</label>
						<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?>
						</div>
					</div>
				<?php 
					break;
					case "insurance_no" :  ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Insurance No.<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="insurance_no" class="form-control" value="<?php if($patient) echo $patient->insurance_no ;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>	
					</div>
				<?php 
					break;		
					case "delivery_mode" :  ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
					    <label class="control-label">Delivery Mode <?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<select name="delivery_mode" class="form-control" <?php if($field->mandatory) echo "required"; ?>>
							<option value="">Select</option>
							<option value="normal">Normal</option>
							<option value="surgical">Surgical</option>
                        </select>
						<?php if($patient) echo $patient->delivery_mode ;?>
						<?php if($field->mandatory) echo "required"; ?> 
						</div>
					</div>
				<?php 
					break;				
					case "delivery_place" :  ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Delivery Place<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="delivery_place" class="form-control" value="<?php if($patient) echo $patient->delivery_place ;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
				<?php 
					break;
					case "delivery_location" :  ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Delivery Location<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="delivery_location" class="form-control" value="<?php if($patient) echo $patient->delivery_location ;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
				<?php 
					break;
					case "delivery_type" :  ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Delivery type<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="delivery_type" class="form-control" value="<?php if($patient) echo $patient->delivery_typedelivery_type ;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
				<?php 
					break;				
					case "delivery_location_type" :  ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
                        <label class="control-label">Delivery Location Type <?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<select name="delivery_location_type" class="form-control" <?php if($field->mandatory) echo "required"; ?>>
							<option value="">Select</option>
							<option value="private">Private</option>
							<option value="government">Government</option>
						</select>
						<?php if($patient) echo $patient->delivery_location_type ;?>
						<?php if($field->mandatory)?> 
						</div>
					</div>
				<?php 
					break;
					case "delivery_plan" :  ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Deliver Plan<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="delivery_plan" class="form-control" value="<?php if($patient) echo $patient->delivery_plan ;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
				<?php 
					break;
					case "birth_weight" :  ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Birth Weight<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="birth_weight" class="form-control" value="<?php if($patient) echo $patient->birth_weight ;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
				<?php 
					break;
					case "congenial_anomalies" :  ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Congenital Anomalies<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="congenital_anomalies" class="form-control" value="<?php if($patient) echo $patient->congential_anomalies ;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
				<?php 
					break;
					
					
					case "presenting_complaints" :  ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Presenting Complaint<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
                            <textarea rows="1" cols="30" name="presenting_complaints" class="form-control" <?php if($field->mandatory) echo "required"; ?>><?php if($patient) echo $patient->presenting_complaints;?></textarea>
						</div>
					</div>
				<?php 
					break;					
					case "department" :  ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Department<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<select name="department" class="form-control" id="department"  <?php if($field->mandatory) echo "required"; ?> >
						<option value="">--Select--</option>
						<?php 
						foreach($departments as $department){
							echo "<option value='".$department->department_id."'";
							if($update){ 
                                                          if($department->department_id==$patient->department_id) 
                                                            echo " selected ";                                                           
                                                        }
                                                        else if($department->department_id == (int)$field->default_value)
                                                                echo " selected ";
							echo ">".$department->department."</option>";
						}
						?>
						</select>
						</div>
					</div>
				<?php 
					break;					
				    case "hospital_type" :  ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Hospital Type <?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<select name="hospital_type" class="form-control" <?php if($field->mandatory) echo "required"; ?>>
							<option value="">Select</option>
							<option value="private">Private</option>
							<option value="government">Government</option>
						</select>
						<?php if($patient) echo $patient->hospital_type;?>
						<?php if($field->mandatory)?> 
						</div>
					</div>
				<?php 
					break;					
					case "hospital" :  ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Hospital<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="hospital" class="form-control" value="<?php if($patient) echo $patient->hospital ;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
					<?php
					break;				
					case "unit" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Unit<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<select name="unit" id="unit" class="form-control"  <?php if($field->mandatory) echo "required"; ?> >
						<option value="">--Select--</option>
						<?php 
						foreach($units as $unit){
							echo "<option value='".$unit->unit_id."' class='".$unit->department_id."'";
							if($update){ if($unit->department_id!=$patient->department_id) echo " hidden ";}
							if($update){ if($unit->unit_id==$patient->unit_id) echo " selected ";} else echo " hidden ";
							echo ">".$unit->unit_name."</option>";
						}
						?>
						</select>
						</div>
					</div>
				<?php 
					break;					
				    case "area" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Area<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<select name="area" id="area" class="form-control"  <?php if($field->mandatory) echo "required"; ?> >
						<option value="">--Select--</option>
						<?php 
						foreach($areas as $area){
							echo "<option value='".$area->area_id."' class='".$area->department_id."'";
							if($update){ if($area->department_id!=$patient->department_id) echo " hidden ";}
							if($update){ if($area->area_id==$patient->area_id) echo " selected ";} else echo " hidden ";
							echo ">".$area->area_name."</option>";
						}
						?>
						</select>
						</div>
					</div>
				<?php 
					break;			
					case "mlc" : ?>
					<div class="<?php echo $class;?>">
						<div class="radio">
						<label class="control-label">MLC</label>
						<label class="control-label"><input type="radio" value="1" class="mlc" name="mlc" <?php if($update)  if($patient->mlc=='1') echo " checked ";?> <?php if($field->mandatory) echo "required"; ?> />Yes</label>
						<label class="control-label"><input type="radio" value="-1" class="mlc" name="mlc" <?php if($update) if($patient->mlc=='-1') echo " checked ";?>  <?php if($field->mandatory) echo "required"; ?> />No</label>
						<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?>
						</div>
					</div>
				<?php 
					break;
					
					case "mlc_number_manual" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">MLC Number<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="mlc_number_manual" class="form-control mlc" value="<?php if($update) echo $patient->mlc_number_manual;?>"  <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
					<?php 
					break;
					
					case "ps_name" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">PS Name<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="ps_name" class="form-control mlc" value="<?php if($update) echo $patient->ps_name;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
					<?php 
					break;
					
					case "pc_number" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Constable #<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="pc_number" class="form-control mlc" value="<?php if($update) echo $patient->pc_number;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
					<?php 
					break;
					
					case "brought_by" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Brought By<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="brought_by" class="form-control mlc" value="<?php if($update) echo $patient->brought_by;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
					<?php 
					break;
					
					case "police_intimation" : ?>
					<div class="<?php echo $class;?>">
						<div class="radio">
						<label class="control-label">Police Intimation</label>
						<label class="control-label"><input type="radio" value="1" class="mlc_field" name="police_intimation" <?php if($update)  if($patient->police_intimation==1) echo " checked ";?> <?php if($field->mandatory) echo "required"; ?> />Yes</label>
						<label class="control-label"><input type="radio" value="0" class="mlc_field" name="police_intimation" <?php if($update) if($patient->police_intimation==0) echo " checked ";?>  <?php if($field->mandatory) echo "required"; ?> />No</label>
						<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?>
						</div>
					</div>
					<?php 
					break;
					
					case "declaration_required" : ?>
					<div class="<?php echo $class;?>">
						<div class="radio">
						<label class="control-label">Declaration Req?</label>
						<label class="control-label"><input type="radio" value="1" class="mlc_field" name="declaration_required" <?php if($update)  if($patient->declaration_required==1) echo " checked ";?> <?php if($field->mandatory) echo "required"; ?> />Yes</label>
						<label class="control-label"><input type="radio" value="0" class="mlc_field" name="declaration_required" <?php if($update) if($patient->declaration_required==0) echo " checked ";?>  <?php if($field->mandatory) echo "required"; ?> />No</label>
						<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?>
						</div>
					</div>
					<?php 
					break;
					
					case "identification_marks" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Identification Marks<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="identification_marks" class="form-control mlc" value="<?php if($update) echo $patient->identification_marks;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
					<?php 
					break;
					
					
					case "past_history" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Past history<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="past_history" class="form-control past_history" value="<?php if($update) echo $patient->past_history;?>"  <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
				<?php 
					break;
					case "admit_weight" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Admit Weight<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="admit_weight" class="form-control mlc" value="<?php if($update) echo $patient->admit_weight;?>"  <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
					<?php 
					break;
					case "discharge_weight" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Discharge Weight<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="discharge_weight" class="form-control mlc" value="<?php if($update) echo $patient->discharge_weight;?>"  <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
					<?php 
					break;
					case "pulse_rate" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Pulse Rate<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="pulse_rate" class="form-control pulse_rate" value="<?php if($update) echo $patient->pulse_rate;?>"  <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
					<?php 
					break;
					case "temperature" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Temperature<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="temperature" class="form-control temperature" value="<?php if($update) echo $patient->temperature;?>"  <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
					<?php 
					break;
                    case "blood_pressure" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Blood Pressure<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="sbp" style="width:50px" class="form-control blood_pressure" value="<?php if($update) echo $patient->sbp;?>"  <?php if($field->mandatory) echo "required"; ?> />/
	                    <input type="text" name="dbp"  style="width:50px" class="form-control blood_pressure" value="<?php if($update) echo $patient->dbp;?>"  <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
					<?php 
					break;
					case "respiratory_rate" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Respiratory Rate<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="respiratory_rate" class="form-control mlc" value="<?php if($update) echo $patient->respiratory_rate;?>"  <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
				<?php 
					break;
					case "outcome" : ?>
					<div class="<?php echo $class;?>">
						<div class="radio">
						<label class="control-label">Outcome</label>
						<label class="control-label"><input type="radio" value="Discharge" name="outcome" <?php if($update) if($patient->outcome=="Discharge") echo " checked ";?> <?php if($field->mandatory) echo "required"; ?> />Discharge</label>
						<label class="control-label"><input type="radio" value="LAMA" name="outcome" <?php if($update) if($patient->outcome=="LAMA") echo " checked ";?> <?php if($field->mandatory) echo "required"; ?> />LAMA</label>
						<label class="control-label"><input type="radio" value="Absconded" name="outcome" <?php if($update) if($patient->outcome=="Absconded") echo " checked ";?>  <?php if($field->mandatory) echo "required"; ?> />Absconded</label>
						<label class="control-label"><input type="radio" value="Death" name="outcome" <?php if($update) if($patient->outcome=="Death") echo " checked ";?> <?php if($field->mandatory) echo "required"; ?> />Death</label>
						<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?>
						</div>
					</div>
				<?php 
					break;
					case "outcome_date" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Outcome Date<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="outcome_date" class="form-control date" value="<?php if($update) echo $patient->outcome_date;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
				<?php 
					break;
					case "outcome_time" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Outcome Time<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="outcome_time" class="form-control time" value="<?php if($update) echo $patient->outcome_time;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
				<?php 
					break;
					case "final_diagnosis" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Final Diag.<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="final_diagnosis" class="form-control" value="<?php if($update) echo $patient->final_diagnosis;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
				<?php 
					break;
				    case "provisional_diagnosis" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Provisional Diag.<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="provisional_diagnosis" class="form-control" value="<?php if($update) echo $patient->provisional_diagnosis;?>" <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
				<?php 
					break;
                case "congenital_anomalies" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label"> Congenital Anomalies<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<input type="text" name="congenital_anomalies" class="form-control mlc" value="<?php if($update) echo $patient->congenital_anomalies;?>"  <?php if($field->mandatory) echo "required"; ?> />
						</div>
					</div>
				<?php 
					break;
                case "visit_name" : ?>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Visit Name<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
						<select name="visit_name" class="form-control" <?php if($field->mandatory) echo "required"; ?>>
						<?php foreach($visit_names as $visit_name){ ?>
						<option value="<?php echo $visit_name->visit_name_id;?>"
                                                <?php if($update && $patient->visit_name_id == $visit_name->visit_name_id){ 
                                                    echo " selected ";                                                    
                                                }else if($visit_name->visit_name_id == (int)$field->default_value){
                                                    echo " selected ";                                                    
                                                }                                                
                                                ?>>
						<?php echo $visit_name->visit_name;?></option>
						<?php } ?>
						</select>
						</div>
					</div>
				<?php 
					break;
                case "patient_picture" : ?>
				<?php 
					break;
					}
			}
			foreach($fields as $field){
				if($field->field_name=="patient_picture"){?>
				
					<div class="col-md-12">
						<div class="form-group well well-sm">
						<div class="row">
							<div class="col-md-12">
							<p class="col-md-6" id="results-text">Captured image will appear here..</p>
							<p class="col-md-6">Camera View</p>
							<div id="results" class="col-md-6 results"></div>
							
							<div id="my_camera" class="col-md-6"></div>
							</div>
						</div>
							<div class="col-md-offset-6" style="position:relative;top:5px">
							
							<!-- A button for taking snaps -->
								<div id="button">
									<input id="patient_picture" type="hidden" class="sr-only" name="patient_picture" value=""/>
									<button class="btn btn-default btn-sm" type="button" onclick="save_photo()"><i class="fa fa-camera"></i> Take Picture</button>
								</div>
							</div>
							<!-- First, include the Webcam.js JavaScript Library -->
							<script type="text/javascript" src="<?php echo base_url();?>assets/js/webcam.min.js"></script>
							
							<!-- Configure a few settings and attach camera -->
							<script language="JavaScript">
								Webcam.set({
									width: 320,
									height: 240,
									// device capture size
									dest_width: 320,
									dest_height: 240,
									// final cropped size
									crop_width: 200,
									crop_height: 240,											
									image_format: 'jpeg',
									jpeg_quality: 90
								});
								Webcam.attach( '#my_camera' );
							</script>
							
							<!-- Code to handle taking the snapshot and displaying it locally -->
							<script language="JavaScript">
								
								function save_photo() {
									// actually snap photo (from preview freeze) and display it
									Webcam.snap( function(data_uri) {
										// display results in page
										document.getElementById('results').innerHTML = 
											'<img src="'+data_uri+'"/>';
										document.getElementById('results-text').innerHTML = 
											'Captured Image';
										//Store image data in input field.
										var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
										
										document.getElementById('patient_picture').value = raw_image_data;
										
										// swap buttons back
										document.getElementById('pre_take_buttons').style.display = '';
										document.getElementById('post_take_buttons').style.display = 'none';
									} );
								}
							</script>
							
						</div>
					</div>
			<?php } 
			}
			?>
			</div>
			<div class="panel-footer">
				<button class="btn btn-primary btn-lg col-md-offset-5" name="register" value="1" ><?php if($update) echo "Update"; else echo "Submit";?></button>
			</div>
			</div>
		</div>
		</form>	
		<?php } ?>
		<div class="row">
			<?php echo form_open("register/custom_form/$form_id",array('role'=>'form','class'=>'form-custom')); ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<?php echo $form_name;?> - Search for a patient
				</div>
				<div class="panel-body">
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Year</label>
						<select class="form-control" name="search_year">
							<?php 
								$i=2013;
								$year = date("Y");
								while($year>=$i){ ?>
								<option value="<?php echo $year;?>"><?php echo $year--;?></option>
							<?php
								}
							?>
						</select>
						</div>
					</div>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">OP Number</label>
						<input type="text" name="search_op_number" class="form-control" />
						</div>
					</div>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">IP Number</label>
						<input type="text" name="search_ip_number" class="form-control" />
						</div>
					</div>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Patient ID</label>
						<input type="text" name="search_patient_id" class="form-control" />
						</div>
					</div>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Patient Name</label>
						<input type="text" name="search_patient_name" class="form-control" />
						</div>
					</div>
					<div class="<?php echo $class;?>">
						<div class="form-group">
						<label class="control-label">Phone Number</label>
						<input type="text" name="search_phone" class="form-control" />
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<button type="submit" class="btn btn-primary btn-sm" name="search_patients" value="1" >Search</button>
				</div>
			</div>
			</form>
			<?php if(isset($patients) && count($patients)!=1){ 
			?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4>Search Results</h4> | 
							<?php if($this->input->post('search_patient_id')) echo "Patient ID : ".$this->input->post('search_patient_id')." | "; ?>
							<?php if($this->input->post('search_patient_name')) echo "Patient name starting with : ".$this->input->post('search_patient_name')." | "; ?>
							<?php if($this->input->post('search_op_number')) echo "OP Number : ".$this->input->post('search_op_number')." | "; ?>
							<?php if($this->input->post('search_phone')) echo "Phone Number : ".$this->input->post('search_phone')." | "; ?>
						</div>
						<div class="panel-body">
							<?php if(count($patients)>1){ ?>
								<table class="table table-striped table-hover">
									<thead>
										<tr>
											<th>#</th>
											<th>Hospital</th>
											<th>Visit Type</th>
											<th>Name</th>
											<th>Age</th>
											<th>Sex</th>
											<th>Department</th>
											<th>Date</th>
											<th>Phone</th>
											<th>Parent/Spouse</th>
										</tr>
									</thead>
									<tbody>
									<?php 
										$i=1;
										foreach($patients as $patient){ ?>
										<tr onclick="$('#form_<?php echo $patient->visit_id;?>').submit()">
											<td>
												<?php echo form_open("register/custom_form/$form_id/$patient->visit_id",array("role"=>"form","id"=>"form_$patient->visit_id"));?>
												<input type="text" class="sr-only" value="1" name="select_patient" />
												<input type="text" class="sr-only" value="<?php echo $patient->visit_type;?>" name="visit_type" />
												</form>
												<?php echo $i++; ?>
											</td>
											<td><?php echo $patient->hospital; ?></td>
											<td><?php echo $patient->visit_type; ?></td>
											<td><?php echo $patient->name; ?></td>
											<td>
												<?php 
													if($patient->age_years!=0) echo $patient->age_years."Y ";
													if($patient->age_months) echo $patient->age_months."M "; 
													if($patient->age_days) echo $patient->age_days."D "; 
													if($patient->age_years==0 && $patient->age_months == 0 && $patient->age_days==0) echo "0 Days";
												?>
											</td>
											<td><?php echo $patient->gender;?></td>
											<td><?php echo $patient->department;?></td>
											<td><?php echo date("d-M-Y",strtotime($patient->admit_date));?></td>
											<td><?php echo $patient->phone;?></td>
											<td><?php echo $patient->parent_spouse;?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
								<div class="row text-center">
									<?php echo form_open("register/custom_form/$form_id",array("role"=>"form","class"=>"form-custom")) ?>
									<input type="text" class="sr-only" value="<?php echo $this->input->post('search_patient_id');?>" name="search_patient_id" />
									<input type="text" class="sr-only" value="<?php echo $this->input->post('search_patient_name');?>" name="search_patient_name" />
									<input type="text" class="sr-only" value="<?php echo $this->input->post('search_op_number');?>" name="search_op_number" />
									<input type="text" class="sr-only" value="<?php echo $this->input->post('search_ip_number');?>" name="search_ip_number" />
									<input type="text" class="sr-only" value="<?php echo $this->input->post('search_phone');?>" name="search_phone" />
									<input type="text" class="sr-only" value="<?php echo $this->input->post('search_year');?>" name="search_year" />
									<input type="text" class="sr-only" value="1" name="load_other_hospitals" />
									<input type="submit" value="Search All Hospitals" name="search_patients" class="btn btn-primary btn-sm text-center">
									</form>
							<?php }  else echo "No patients matched your search.";?>
						</div>
					</div>
				<?php } ?>
				</div>
<script type="text/javascript">
function getStates()
{
    var data = {
      "country": $("#country").val()
    };

    $.ajax({
      type: "POST",
      dataType: "json",
      url: "<?= base_url()?>register/get_states", //Relative or absolute path to response.php file
      data: data,
      success: function(data) {
		$("#state").html("<option value=''>--Select--</option>");
		for(i=0;i<data.length;i++) {
			$("#state").append("<option value='"+data[i].state_code+"'>"+data[i].state_name+"</option>");
		}
		$("#district").html("<option value=''>--Select--</option>")
      }
    });
    return false;
}// getStates

function getDistrict() {
	
    var data = {
      "country": $("#country").val(),
	  "state" : $("#state").val()
    };

    $.ajax({
      type: "POST",
      dataType: "json",
      url: "<?= base_url()?>register/get_districts", //Relative or absolute path to response.php file
      data: data,
      success: function(data) {
		$("#district").html("<option value=''>--Select--</option>");
		for(i=0;i<data.length;i++) {
			$("#district").append("<option value='"+data[i].place_code+"'>"+data[i].place_name+"</option>");
		}
      }
    });
    return false;
}// getDistrict
</script>