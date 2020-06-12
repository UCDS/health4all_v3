<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript">
</script>
<script type="text/javascript">	
	$(function(){
		$("#date_of_birth").Zebra_DatePicker({direction:false});
                $("#qualification_from_date1, #qualification_from_date2, #qualification_from_date3, #qualification_from_date4, #qualification_from_date5, #qualification_from_date6, #qualification_from_date7, #qualification_from_date8, #qualification_from_date9, #qualification_from_date10").Zebra_DatePicker();
                $("#qualification_to_date1, #qualification_to_date2,  #qualification_to_date3, #qualification_to_date4, #qualification_to_date5, #qualification_to_date6, #qualification_to_date7, #qualification_to_date8, #qualification_to_date9, #qualification_to_date10").Zebra_DatePicker();
                $("#experiance_from_date1, #experiance_from_date2, #experiance_from_date3, #experiance_from_date4, #experiance_from_date5, #experiance_from_date6, #experiance_from_date7, #experiance_from_date8, #experiance_from_date9, #experiance_from_date10").Zebra_DatePicker();
                $("#experiance_to_date1, #experiance_to_date2,  #experiance_to_date3, #experiance_to_date4, #experiance_to_date5, #experiance_to_date6, #experiance_to_date7, #experiance_to_date8, #experiance_to_date9, #experiance_to_date10").Zebra_DatePicker();
		$("#department option").hide().attr('disabled',true);
		$("#hospital").on('change',function(){
			var hospital_id=$(this).val();
			$("#department option").hide().attr('disabled',true);
			$("#department option[class="+hospital_id+"]").show().attr('disabled',false);
		});
		$("#department").on('change',function(){
			var department_id=$(this).val();
			$("#unit option,#area option").hide();
			$("#unit option[class="+department_id+"],#area option[class="+department_id+"]").show();
		});
                
                $("#add_qualification").click(function(){                    
                    var counter = $('#qualification_count').val();                    
                    $("#row"+counter.toString()).removeClass('sr-only');
                    counter++;
                    $('#qualification_count').val(counter);                    
                });
                
                $("#add_experiance").click(function(){                    
                    var counter = $('#experiance_count').val();                    
                    $("#exp_row"+counter.toString()).removeClass('sr-only');
                    counter++;
                    $('#experiance_count').val(counter);                    
                });
	});
</script>

<div class="col-md-12 col-md-offset-2"> <!-- col-md-offset-2">	-->
	<center>
		<strong><?php if(isset($msg)){ echo $msg;}?></strong>
		<h3>Add Applicant Details</h3>
	</center><br>
	
	<center>
		<?php echo validation_errors(); ?>
	</center>
	<?php 
	echo form_open('staff_applicant/add_applicant',array('class'=>'form-horizontal','role'=>'form','id'=>'add_applicant')); 
	?>
    
	<div class="form-group">
		<div class="col-md-3">
			<label for="first_name" class="control-label">First Name</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="First Name" id="first_name" name="first_name" required />
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-3">
			<label for="last_name" class="control-label">Last Name</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Last Name" id="last_name" name="last_name" />
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-3">
			<label class="control-label">Gender</label>
		</div>
		<div class="col-md-6">
			<label class="control-label">
				<input type="radio" name="gender" value="M"  />Male
			</label>
			<label class="control-label">
				<input type="radio" name="gender" value="F" checked />Female
			</label>
			<label class="control-label">
				<input type="radio" name="gender" value="O" />Other
			</label>
		</div>
	</div>	
	<div class="form-group">
		<div class="col-md-3">
			<label for="date_of_birth" class="control-label">Date of Birth</label>
		</div>
		<div class="col-md-6">
                <!--    <input type="date" name="date_of_birth" min="1979-12-31"><br> -->
			<input type="text" class="form-control date" placeholder="Date of Birth" id="date_of_birth" name="date_of_birth" /> 
		</div>
	</div>
        <div class="form-group">
		<div class="col-md-3">
			<label for="fathers_name" class="control-label">Father's Name</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Father's Name" id="fathers_name" name="fathers_name" />
		</div>
	</div>
        <div class="form-group">
		<div class="col-md-3">
			<label for="mothers_name" class="control-label">Mother's Name</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Mother's Name" id="mothers_name" name="mothers_name" />
		</div>
	</div>
        <div class="form-group">
		<div class="col-md-3">
			<label for="husbands_name" class="control-label">Husband's Name</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Husband's Name" id="husbands_name" name="husbands_name" />
		</div>
	</div>
        <div class="form-group">
            <div class="col-md-3">
                    <label for="address" class="control-label">Address</label>
            </div>
            <div class="col-md-6">
                <textarea class="form-control date" placeholder="Address" id="address" name="address"></textarea>
            </div>
	</div>
        
        <div class="form-group">
            <div class="col-md-3">
                <label for="place" class="control-label">Place</label>
            </div>
            <div class="col-md-6">
                <input type="text" class="form-control date" placeholder="Place" id="place" name="place" />
            </div>
	</div>
        
        <div class="form-group">
            <div class="col-md-3">
                    <label for="district" class="control-label">District</label>
            </div>
            <div class="col-md-6">
                    <select class="form-control" id="district_id" name="district_id" >
                        <option value="">District</option>
                        <?php foreach($districts as $district){
                            echo "<option value='".$district->district_id."'>".$district->district."</option>";
                        }?>
                    </select>
            </div>
        </div>
        <div class="form-group">
		<div class="col-md-3">
			<label for="phone" class="control-label">Phone</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control date" placeholder="Phone" id="phone" name="phone" />
		</div>
	</div>
        <div class="form-group">
		<div class="col-md-3">
			<label for="phone_alternate" class="control-label">Alternate Phone</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control date" placeholder="Alternate Phone" id="phone_alternate" name="phone_alternate" />
		</div>
	</div>
        <div class="form-group">
		<div class="col-md-3">
			<label for="email" class="control-label">Email</label>
		</div>
		<div class="col-md-6">
			<input type="email" class="form-control date" placeholder="Email" id="email" name="email" />
		</div>
	</div>
        <div class="form-group">
            <div class="col-md-3">
                    <label for="drive_id" class="control-label">Recruitment Drive</label>
            </div>
            <div class="col-md-6">
                    <select class="form-control" id="drive_id" name="drive_id" >
                        <option value="2" selected>Select Recruitment Drive</option>
                        <?php foreach($recruitment_drives as $drive){
                            echo "<option value='".$drive->drive_id."'>".$drive->name.", ".$drive->place."</option>";
                        }?>
                    </select>
            </div>
        </div>
	
        <div class="form-group">
            <div class="col-md-9">
                <table class="table table-striped table-bordered qualifications_table">
                    <thead>
                       <th colspan="5">Qualifications</th>
                    </thead>
                    <tr>
                        <td><b>Qualification</b></td>
                        <td><b>College</b></td>
                        <td><b>Registration Number</b></td>
                        <td><b>From Date</b></td>
                        <td><b>To Date</b></td>
                    </tr>
                    <tr>
                        <td>
                            <select class="form-control" id="qualification_id1" name="qualification_id1" >
                                <option value="300" selected>Qualification</option>
                                    <?php foreach($qualification_master as $qualification){
                                        echo "<option value='".$qualification->qualification_id."'>".$qualification->qualification."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="applicant_college_id1" name="applicant_college_id1" >
                                <option value="">Applicant College</option>
                                    <?php foreach($applicant_colleges as $college){
                                        echo "<option value='".$college->college_id."'>".$college->college_name."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control" placeholder="Regsitration Number" id="registration_number1" name="registration_number1" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="From Date" id="qualification_from_date1" name="qualification_from_date1" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="To Date" id="qualification_to_date1" name="qualification_to_date1" />
                        </td>
                    </tr>
                    <tr class="sr-only" id="row2">
                        <td>
                            <select class="form-control" id="qualification_id2" name="qualification_id2" >
                                <option value="">Select Qualification</option>
                                    <?php foreach($qualification_master as $qualification){
                                        echo "<option value='".$qualification->qualification_id."'>".$qualification->qualification."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="applicant_college_id2" name="applicant_college_id2" >
                                <option value="">Applicant College</option>
                                    <?php foreach($applicant_colleges as $college){
                                        echo "<option value='".$college->college_id."'>".$college->college_name."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control" placeholder="Regsitration Number" id="registration_number2" name="registration_number2" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="From Date" id="qualification_from_date2" name="qualifiction_from_date2" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="To Date" id="qualification_to_date2" name="qualification_to_date2" />
                        </td>
                    </tr>
                    <tr class="sr-only" id="row3">
                        <td>
                            <select class="form-control" id="qualification_id3" name="qualification_id3" >
                                <option value="">Select Qualification</option>
                                    <?php foreach($qualification_master as $qualification){
                                        echo "<option value='".$qualification->qualification_id."'>".$qualification->qualification."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="applicant_college_id3" name="applicant_college_id3" >
                                <option value="">Applicant College</option>
                                    <?php foreach($applicant_colleges as $college){
                                        echo "<option value='".$college->college_id."'>".$college->college_name."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control" placeholder="Regsitration Number" id="registration_number3" name="registration_number3" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="From Date" id="qualification_from_date3" name="qualifiction_from_date3" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="To Date" id="qualification_to_date3" name="qualification_to_date3" />
                        </td>
                    </tr>
                    <tr class="sr-only" id="row4">
                        <td>
                            <select class="form-control" id="qualification_id4" name="qualification_id4" >
                                <option value="">Select Qualification</option>
                                    <?php foreach($qualification_master as $qualification){
                                        echo "<option value='".$qualification->qualification_id."'>".$qualification->qualification."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="applicant_college_id4" name="applicant_college_id4" >
                                <option value="">Applicant College</option>
                                    <?php foreach($applicant_colleges as $college){
                                        echo "<option value='".$college->college_id."'>".$college->college_name."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control" placeholder="Regsitration Number" id="registration_number4" name="registration_number4" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="From Date" id="qualification_from_date4" name="qualifiction_from_date4" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="To Date" id="qualification_to_date4" name="qualification_to_date4" />
                        </td>
                    </tr>
                    <tr class="sr-only" id="row5">
                        <td>
                            <select class="form-control" id="qualification_id5" name="qualification_id5" >
                                <option value="">Select Qualification</option>
                                    <?php foreach($qualification_master as $qualification){
                                        echo "<option value='".$qualification->qualification_id."'>".$qualification->qualification."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="applicant_college_id5" name="applicant_college_id5" >
                                <option value="">Applicant College</option>
                                    <?php foreach($applicant_colleges as $college){
                                        echo "<option value='".$college->college_id."'>".$college->college_name."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control" placeholder="Regsitration Number" id="registration_number5" name="registration_number5" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="From Date" id="qualification_from_date5" name="qualifiction_from_date5" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="To Date" id="qualification_to_date5" name="qualification_to_date5" />
                        </td>
                    </tr>
                    <tr class="sr-only" id="row6">
                        <td>
                            <select class="form-control" id="qualification_id6" name="qualification_id6" >
                                <option value="">Select Qualification</option>
                                    <?php foreach($qualification_master as $qualification){
                                        echo "<option value='".$qualification->qualification_id."'>".$qualification->qualification."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="applicant_college_id6" name="applicant_college_id6" >
                                <option value="">Applicant College</option>
                                    <?php foreach($applicant_colleges as $college){
                                        echo "<option value='".$college->college_id."'>".$college->college_name."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control" placeholder="Regsitration Number" id="registration_number6" name="registration_number6" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="From Date" id="qualification_from_date6" name="qualifiction_from_date6" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="To Date" id="qualification_to_date6" name="qualification_to_date6" />
                        </td>
                    </tr>
                    <tr class="sr-only" id="row7">
                        <td>
                            <select class="form-control" id="qualification_id7" name="qualification_id7" >
                                <option value="">Select Qualification</option>
                                    <?php foreach($qualification_master as $qualification){
                                        echo "<option value='".$qualification->qualification_id."'>".$qualification->qualification."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="applicant_college_id7" name="applicant_college_id7" >
                                <option value="">Applicant College</option>
                                    <?php foreach($applicant_colleges as $college){
                                        echo "<option value='".$college->college_id."'>".$college->college_name."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control" placeholder="Regsitration Number" id="registration_number7" name="registration_number7" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="From Date" id="qualification_from_date7" name="qualifiction_from_date7" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="To Date" id="qualification_to_date7" name="qualification_to_date7" />
                        </td>
                    </tr>
                    <tr class="sr-only" id="row8">
                        <td>
                            <select class="form-control" id="qualification_id8" name="qualification_id8" >
                                <option value="">Select Qualification</option>
                                    <?php foreach($qualification_master as $qualification){
                                        echo "<option value='".$qualification->qualification_id."'>".$qualification->qualification."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="applicant_college_id8" name="applicant_college_id8" >
                                <option value="">Applicant College</option>
                                    <?php foreach($applicant_colleges as $college){
                                        echo "<option value='".$college->college_id."'>".$college->college_name."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control" placeholder="Regsitration Number" id="registration_number8" name="registration_number8" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="From Date" id="qualification_from_date8" name="qualifiction_from_date8" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="To Date" id="qualification_to_date8" name="qualification_to_date8" />
                        </td>
                    </tr>
                    <tr class="sr-only" id="row9">
                        <td>
                            <select class="form-control" id="qualification_id9" name="qualification_id9" >
                                <option value="">Select Qualification</option>
                                    <?php foreach($qualification_master as $qualification){
                                        echo "<option value='".$qualification->qualification_id."'>".$qualification->qualification."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="applicant_college_id9" name="applicant_college_id9" >
                                <option value="">Applicant College</option>
                                    <?php foreach($applicant_colleges as $college){
                                        echo "<option value='".$college->college_id."'>".$college->college_name."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control" placeholder="Regsitration Number" id="registration_number8" name="registration_number8" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="From Date" id="qualification_from_date8" name="qualifiction_from_date8" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="To Date" id="qualification_to_date8" name="qualification_to_date8" />
                        </td>
                    </tr>
                    <tr class="sr-only" id="row10">
                        <td>
                            <select class="form-control" id="qualification_id10" name="qualification_id10" >
                                <option value="">Select Qualification</option>
                                    <?php foreach($qualification_master as $qualification){
                                        echo "<option value='".$qualification->qualification_id."'>".$qualification->qualification."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="applicant_college_id10" name="applicant_college_id10" >
                                <option value="">Applicant College</option>
                                    <?php foreach($applicant_colleges as $college){
                                        echo "<option value='".$college->college_id."'>".$college->college_name."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control" placeholder="Regsitration Number" id="registration_number10" name="registration_number10" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="From Date" id="qualification_from_date10" name="qualifiction_from_date10" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="To Date" id="qualification_to_date10" name="qualification_to_date10" />
                        </td>
                    </tr>
                </table>
                
                <div class="btn-group" role="group">
                   <input type="hidden" name="qualification_count" id="qualification_count" value="2" />
                   <button type="button" id='add_qualification'>Add Qualification</button>                   
                </div>
            </div>
            <div class="col-md-9">
                <div>
                    &nbsp; - <br>
                </div>
            </div>
            <div class="col-md-9">
                <table class="table table-striped table-bordered qualifications_table">
                    <thead>
                       <th colspan="5">Applicant Experiance</th>
                    </thead>
                    <tr>
                        <td><b>Previous Hospiatal</b></td>
                        <td><b>Role</b></td>                        
                        <td><b>From Date</b></td>
                        <td><b>To Date</b></td>
                    </tr>
                    <tr>
                        <td>
                            <select class="form-control" id="hospital_id1" name="hospital_id1" >
                                <option value="300" selected>Select Previous Hospital</option>
                                    <?php foreach($applicant_previous_hospital as $hospital){
                                        echo "<option value='".$hospital->hospital_id."'>".$hospital->hospital_name."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="staff_role_id1" name="staff_role_id1" >
                                <option value="">Applicant Previous Role</option>
                                    <?php foreach($staff_roles as $role){
                                        echo "<option value='".$role->staff_role_id."'>".$role->staff_role."</option>";
                                    }?>
                            </select>
                        </td>
                        
                        <td>
                            <input type="text" class="form-control date" placeholder="From Date" id="experiance_from_date1" name="experiance_from_date1" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="To Date" id="experiance_to_date1" name="experiance_to_date1" />
                        </td>
                    </tr>
                    <tr class="sr-only" id="exp_row2">
                        <td>
                            <select class="form-control" id="hospital_id2" name="hospital_id2" >
                                <option value="">Select Previous Hospital</option>
                                    <?php foreach($applicant_previous_hospital as $hospital){
                                        echo "<option value='".$hospital->hospital_id."'>".$hospital->hospital_name."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="staff_role_id2" name="staff_role_id2" >
                                <option value="">Applicant Previous Role</option>
                                    <?php foreach($staff_roles as $role){
                                        echo "<option value='".$role->staff_role_id."'>".$role->staff_role."</option>";
                                    }?>
                            </select>
                        </td>
                        
                        <td>
                            <input type="text" class="form-control date" placeholder="From Date" id="experiance_from_date2" name="qualifiction_from_date2" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="To Date" id="experiance_to_date2" name="experiance_to_date2" />
                        </td>
                    </tr>
                    <tr class="sr-only" id="exp_row3">
                        <td>
                            <select class="form-control" id="hospital_id3" name="hospital_id3" >
                                <option value="">Select Previous Hospital</option>
                                    <?php foreach($applicant_previous_hospital as $hospital){
                                        echo "<option value='".$hospital->hospital_id."'>".$hospital->hospital_name."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="staff_role_id3" name="staff_role_id3" >
                                <option value="">Applicant Previous Role</option>
                                    <?php foreach($staff_roles as $role){
                                        echo "<option value='".$role->staff_role_id."'>".$role->staff_role."</option>";
                                    }?>
                            </select>
                        </td>
                        
                        <td>
                            <input type="text" class="form-control date" placeholder="From Date" id="experiance_from_date3" name="qualifiction_from_date3" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="To Date" id="experiance_to_date3" name="experiance_to_date3" />
                        </td>
                    </tr>
                    <tr class="sr-only" id="exp_row4">
                        <td>
                            <select class="form-control" id="hospital_id4" name="hospital_id4" >
                                <option value="">Select Previous Hospital</option>
                                    <?php foreach($applicant_previous_hospital as $hospital){
                                        echo "<option value='".$hospital->hospital_id."'>".$hospital->hospital_name."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="staff_role_id4" name="staff_role_id4" >
                                <option value="">Applicant Previous Role</option>
                                    <?php foreach($staff_roles as $role){
                                        echo "<option value='".$role->staff_role_id."'>".$role->staff_role."</option>";
                                    }?>
                            </select>
                        </td>                        
                        <td>
                            <input type="text" class="form-control date" placeholder="From Date" id="experiance_from_date4" name="qualifiction_from_date4" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="To Date" id="experiance_to_date4" name="experiance_to_date4" />
                        </td>
                    </tr>
                    <tr class="sr-only" id="exp_row5">
                        <td>
                            <select class="form-control" id="hospital_id5" name="hospital_id5" >
                                <option value="">Select Previous Hospital</option>
                                    <?php foreach($applicant_previous_hospital as $hospital){
                                        echo "<option value='".$hospital->hospital_id."'>".$hospital->hospital_name."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="staff_role_id5" name="staff_role_id5" >
                                <option value="">Applicant Previous Role</option>
                                    <?php foreach($staff_roles as $role){
                                        echo "<option value='".$role->staff_role_id."'>".$role->staff_role."</option>";
                                    }?>
                            </select>
                        </td>
                        
                        <td>
                            <input type="text" class="form-control date" placeholder="From Date" id="experiance_from_date5" name="qualifiction_from_date5" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="To Date" id="experiance_to_date5" name="experiance_to_date5" />
                        </td>
                    </tr>
                    <tr class="sr-only" id="exp_row6">
                        <td>
                            <select class="form-control" id="hospital_id6" name="hospital_id6" >
                                <option value="">Select Previous Hospital</option>
                                    <?php foreach($applicant_previous_hospital as $hospital){
                                        echo "<option value='".$hospital->hospital_id."'>".$hospital->hospital_name."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="staff_role_id6" name="staff_role_id6" >
                                <option value="">Applicant Previous Role</option>
                                    <?php foreach($staff_roles as $role){
                                        echo "<option value='".$role->staff_role_id."'>".$role->staff_role."</option>";
                                    }?>
                            </select>
                        </td>
                        
                        <td>
                            <input type="text" class="form-control date" placeholder="From Date" id="experiance_from_date6" name="qualifiction_from_date6" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="To Date" id="experiance_to_date6" name="experiance_to_date6" />
                        </td>
                    </tr>
                    <tr class="sr-only" id="exp_row7">
                        <td>
                            <select class="form-control" id="hospital_id7" name="hospital_id7" >
                                <option value="">Select Previous Hospital</option>
                                    <?php foreach($applicant_previous_hospital as $hospital){
                                        echo "<option value='".$hospital->hospital_id."'>".$hospital->hospital_name."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="staff_role_id7" name="staff_role_id7" >
                                <option value="">Applicant Previous Role</option>
                                    <?php foreach($staff_roles as $role){
                                        echo "<option value='".$role->staff_role_id."'>".$role->staff_role."</option>";
                                    }?>
                            </select>
                        </td>
                        
                        <td>
                            <input type="text" class="form-control date" placeholder="From Date" id="experiance_from_date7" name="qualifiction_from_date7" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="To Date" id="experiance_to_date7" name="experiance_to_date7" />
                        </td>
                    </tr>
                    <tr class="sr-only" id="exp_row8">
                        <td>
                            <select class="form-control" id="hospital_id8" name="hospital_id8" >
                                <option value="">Select Previous Hospital</option>
                                    <?php foreach($applicant_previous_hospital as $hospital){
                                        echo "<option value='".$hospital->hospital_id."'>".$hospital->hospital_name."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="staff_role_id8" name="staff_role_id8" >
                                <option value="">Applicant Previous Role</option>
                                    <?php foreach($staff_roles as $role){
                                        echo "<option value='".$role->staff_role_id."'>".$role->staff_role."</option>";
                                    }?>
                            </select>
                        </td>
                        
                        <td>
                            <input type="text" class="form-control date" placeholder="From Date" id="experiance_from_date8" name="qualifiction_from_date8" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="To Date" id="experiance_to_date8" name="experiance_to_date8" />
                        </td>
                    </tr>
                    <tr class="sr-only" id="exp_row9">
                        <td>
                            <select class="form-control" id="hospital_id9" name="hospital_id9" >
                                <option value="">Select Previous Hospital</option>
                                    <?php foreach($applicant_previous_hospital as $hospital){
                                        echo "<option value='".$hospital->hospital_id."'>".$hospital->hospital_name."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="staff_role_id9" name="staff_role_id9" >
                                <option value="">Applicant Previous Role</option>
                                    <?php foreach($staff_roles as $role){
                                        echo "<option value='".$role->staff_role_id."'>".$role->staff_role."</option>";
                                    }?>
                            </select>
                        </td>
                        
                        <td>
                            <input type="text" class="form-control date" placeholder="From Date" id="experiance_from_date8" name="qualifiction_from_date8" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="To Date" id="experiance_to_date8" name="experiance_to_date8" />
                        </td>
                    </tr>
                    <tr class="sr-only" id="exp_row10">
                        <td>
                            <select class="form-control" id="hospital_id10" name="hospital_id10" >
                                <option value="">Select Previous Hospital</option>
                                    <?php foreach($applicant_previous_hospital as $hospital){
                                        echo "<option value='".$hospital->hospital_id."'>".$hospital->hospital_name."</option>";
                                    }?>
                            </select>
                        </td>
                        <td>
                            <select class="form-control" id="staff_role_id10" name="staff_role_id10" >
                                <option value="">Applicant Previous Role</option>
                                    <?php foreach($staff_roles as $role){
                                        echo "<option value='".$role->staff_role_id."'>".$role->staff_role."</option>";
                                    }?>
                            </select>
                        </td>
                        
                        <td>
                            <input type="text" class="form-control date" placeholder="From Date" id="experiance_from_date10" name="qualifiction_from_date10" />
                        </td>
                        <td>
                            <input type="text" class="form-control date" placeholder="To Date" id="experiance_to_date10" name="experiance_to_date10" />
                        </td>
                    </tr>
                </table>
                <div class="btn-group" role="group">
                   <input type="hidden" name="experiance_count" id="experiance_count" value="2" />
                   <button type="button" id='add_experiance'>Add Experiance</button>                   
                </div>
            </div>
        </div>
        
   	<div class="form-group col-md-9">
		<button class="btn btn-lg btn-primary btn-block" type="submit" value="submit">Submit</button>
	</div>
</form>
</div>
