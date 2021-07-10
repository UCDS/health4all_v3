<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript">
$(function(){

	var staff_category = document.getElementById('staff_category'),
    	designation= document.getElementById('designation');
	
	staff_category.onchange= function () { 
  		designation.value = staff_category.options[staff_category.selectedIndex].text;
	};
});
</script>
<script type="text/javascript">	
	$(function(){
		$("#date_of_birth").Zebra_DatePicker({direction:false});
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
	});
</script>
<div class="row">
<div class="col-md-8 col-md-offset-2">
	
	<center>
		<strong><?php if(isset($msg)){ echo $msg;}?></strong>
		<h3>Add Staff Details</h3>
	</center><br>
	
	<center>
		<?php echo validation_errors(); ?>
	</center>
	<?php 
	echo form_open('staff/add/staff',array('class'=>'form-horizontal','role'=>'form','id'=>'add_staff')); 
	?>
    <input type="hidden" class="form-control" placeholder="First Name" id="staff_id" name="staff_id" required />
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
				<input type="radio" name="gender" value="M" checked />Male
			</label>
			<label class="control-label">
				<input type="radio" name="gender" value="F" />Female
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
			<input type="text" class="form-control date" placeholder="Date of Birth" id="date_of_birth" name="date_of_birth" />
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-3">
			<label for="hospital" class="control-label">Hospital</label>
		</div>
		<div class="col-md-6">
			<select class="form-control" id="hospital" name="hospital" >
				<option value="">Hospital</option>
				<?php foreach($hospital as $d){
				echo "<option value='$d->hospital_id'>$d->hospital</option>";
				}?>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-3">
			<label for="department" class="control-label">Department</label>
		</div>
		<div class="col-md-6">
			<select class="form-control" id="department" name="department" >
				<option value="">Department</option>
				<?php foreach($department as $d){
				echo "<option value='$d->department_id' class='$d->hospital_id'>$d->department</option>";
				}?>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-3">	
			<label for="unit" class="control-label">Unit</label>
		</div>
		<div class="col-md-6">
			<select class="form-control" id="unit" name="unit">
				<option value="">Unit</option>
				<?php foreach($unit as $u){
					echo "<option value='$u->unit_id' class='$u->department_id'>$u->unit_name</option>";
				}?>
			</select>
		</div>			
	</div>
	<div class="form-group">
		<div class="col-md-3">
			<label for="area" class="control-label">Area</label>
		</div>
		<div class="col-md-6">
			<select class="form-control" id="area" name="area">
				<option value="">Area</option>
				<?php foreach($area as $a){
					echo "<option value='$a->area_id' class='$a->department_id'>$a->area_name</option>";
				}?>
			</select>
		</div>	
	</div>
	<div class="form-group">
		<div class="col-md-3">
			<label for="staff_role" class="control-label">Staff Role</label>
		</div>
		<div class="col-md-6">
			<select class="form-control" id="staff_role" name="staff_role" >
				<option value="">Staff Role</option>
				<?php foreach($staff_role as $sr){
				echo "<option value='$sr->staff_role_id'>$sr->staff_role</option>";
				}?>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-3">
			<label for="staff_category" class="control-label">Staff Category</label>
		</div>
		<div class="col-md-6">
			<select class="form-control" id="staff_category" name="staff_category" >
				<option value="">Staff Category</option>
				<?php foreach($staff_category as $sc){
				echo "<option value='$sc->staff_category_id'>$sc->staff_category</option>";
				}?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-3">
			<label for="designation" class="control-label">Designation</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Designation" id="designation" name="designation" />
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-3">
			<label for="staff_type" class="control-label">Staff Type</label>
		</div>
		<div class="col-md-6">
			<select class="form-control" id="staff_type" name="staff_type">
				<option value="">Staff Type</option>
				<option value="On Rolls">On Rolls</option>
				<option value="Contract">Contract</option>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-3">
			<label for="staff_type" class="control-label">MCI</label>
		</div>
		<div class="col-md-6">
			<input type ='radio' id="mci_flag" name="mci_flag" value ='1'>Yes</input>
			<input type ='radio' id="mci_flag" name="mci_flag" value ='0' checked>No</input>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-3">
			<label for="staff_type" class="control-label">Is Doctor ?</label>
		</div>
		<div class="col-md-6">
			<input type ='radio' id="doctor_flag" name="doctor_flag" value ='1'>Yes</input>
			<input type ='radio' id="doctor_flag" name="doctor_flag" value ='0' checked>No</input>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-3">
			<label for="staff_type" class="control-label">IMA Registration Number</label>
		</div>
		<div class="col-md-6">
		<input type="text" class="form-control" placeholder="IMA Registration Number" id="designation" name="ima_registration_number" />
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-3">
			<label for="email" class="control-label">Email</label>
		</div>
		<div class="col-md-6">
			<input type="email" class="form-control" placeholder="Email" id="email" name="email" />
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-3">
			<label for="phone" class="control-label">Phone</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Phone" id="phone" name="phone" />
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-3">
			<label for="specialisation" class="control-label">Specialisation</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Specialisation" id="specialisation" name="specialisation" />
		</div>
	</div>		
	
	<div class="form-group">
		<div class="col-md-3">
			<label for="research_area" class="control-label">Research Areas</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Research Areas" id="research_area" name="research_area" />
		</div>
	</div>		
	
	<div class="form-group">
		<div class="col-md-3">
			<label for="research" class="control-label">Research</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Research" id="research" name="research" />
		</div>
	</div>
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
									<input id="staff_picture" type="hidden" class="sr-only" name="staff_picture" value="staff_id"/>
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
										
										document.getElementById('staff_picture').value = raw_image_data;
										
										// swap buttons back
										document.getElementById('pre_take_buttons').style.display = '';
										document.getElementById('post_take_buttons').style.display = 'none';
									} );
								}
							</script>
							
						</div>
					</div>	
				<!--<fieldset>
                <legend>Upload the image</legend>
                <section>
                    <label>Browse a file</label>
                    <label>
					     <input type="text" class="sr-only" hidden name="staff" form="upload-file-form" />
                        <input type="file" name="upload_file1" id="upload_file1" readonly="true"/>
						
                    </label>
                    <div id="moreImageUpload"></div>
                    <div style="clear:both;"></div>
                  <button type="submit" name="file_upload" value="Upload" class="btn btn-group btn-default btn-animated" >Upload<i class="fa fa-user"></i></button>
                </section>
            </fieldset>-->
		
   	<div class="form-group col-md-9">
		<button class="btn btn-lg btn-primary btn-block" type="submit" value="submit">Submit</button>
	</div>
</form>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("input[id^='upload_file']").each(function() {
            var id = parseInt(this.id.replace("upload_file", ""));
            $("#upload_file" + id).change(function() {
                if ($("#upload_file" + id).val() !== "") {
                    $("#moreImageUploadLink").show();
                }
            });
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var upload_number = 2;
        $('#attachMore').click(function() {
            //add more file
            var moreUploadTag = '';
            moreUploadTag += '<div class="element"><label for="upload_file"' + upload_number + '>Upload File ' + upload_number + '</label>';
            moreUploadTag += '<input type="file" id="upload_file' + upload_number + '" name="upload_file' + upload_number + '"/>';
            moreUploadTag += '&nbsp;<a href="javascript:del_file(' + upload_number + ')" style="cursor:pointer;" onclick="return confirm(\"Are you really want to delete ?\")">Delete ' + upload_number + '</a></div>';
            $('<dl id="delete_file' + upload_number + '">' + moreUploadTag + '</dl>').fadeIn('slow').appendTo('#moreImageUpload');
            upload_number++;
        });
    });
</script>
<script type="text/javascript">
    function del_file(eleId) {
        var ele = document.getElementById("delete_file" + eleId);
        ele.parentNode.removeChild(ele);
    }
</script>
