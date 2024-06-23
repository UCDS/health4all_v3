<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/ckeditor.js"></script>
<style>
	#footer { position: fixed; bottom: 0; width: 100%; } 
	.text-muted { margin-top:20px;text-align:center; } 
	.navbar  { position: fixed; top: 0; width: 100%; } 
</style>
<script type="text/javascript">
$(function(){
        var options = {
            widthFixed : true,
            showProcessing: true,
            headerTemplate : '{content} {icon}', // Add icon for jui theme; new in v2.7!

            widgets: [ 'default', 'zebra', 'print', 'stickyHeaders','filter'],

            widgetOptions: {

          print_title      : 'table',          // this option > caption > table id > "table"
          print_dataAttrib : 'data-name', // header attrib containing modified header name
          print_rows       : 'f',         // (a)ll, (v)isible or (f)iltered
          print_columns    : 's',         // (a)ll, (v)isible or (s)elected (columnSelector widget)
          print_extraCSS   : '.table{border:1px solid #ccc;} tr,td{background:white}',          // add any extra css definitions for the popup window here
          print_styleSheet : '', // add the url of your print stylesheet
          // callback executed when processing completes - default setting is null
          print_callback   : function(config, $table, printStyle){
            // do something to the $table (jQuery object of table wrapped in a div)
            // or add to the printStyle string, then...
            // print the table using the following code
            $.tablesorter.printTable.printOutput( config, $table.html(), printStyle );
            },
            // extra class name added to the sticky header row
              stickyHeaders : '',
              // number or jquery selector targeting the position:fixed element
              stickyHeaders_offset : 0,
              // added to table ID, if it exists
              stickyHeaders_cloneId : '-sticky',
              // trigger "resize" event on headers
              stickyHeaders_addResizeEvent : true,
              // if false and a caption exist, it won't be included in the sticky header
              stickyHeaders_includeCaption : false,
              // The zIndex of the stickyHeaders, allows the xuser to adjust this to their needs
              stickyHeaders_zIndex : 2,
              // jQuery selector or object to attach sticky header to
              stickyHeaders_attachTo : null,
              // scroll table top into view after filtering
              stickyHeaders_filteredToTop: true,

              // adding zebra striping, using content and default styles - the ui css removes the background from default
              // even and odd class names included for this demo to allow switching themes
              zebra   : ["ui-widget-content even", "ui-state-default odd"],
              // use uitheme widget to apply defauly jquery ui (jui) class names
              // see the uitheme demo for more details on how to change the class names
              uitheme : 'jui'
            }
          };
            $("#table-sort").tablesorter(options);
            
$('input[type=checkbox]').change(function() {
    if ($(this).is(':checked')) {
      $("#".concat(this.id,"_new_value")).removeAttr('disabled');
    } else {
      $("#".concat(this.id,"_new_value")).attr('disabled','disabled');		    
    }
    });
});
  
function submitUpdations()
{
  let isUpdate = false;
  var postData = {};
  postData["donor_id"] = $("#donor_id_con").val();
  postData["user_id"] = $("#session_user_id").val();
  
  var updateAlert = "The following data would be changed";
  	
  	if ($('#full_name_update').is(':checked')){
  		isUpdate = true;
  		if($('#full_name_update_new_value').val() == $('#full_name_old_value').text())
      {
          bootbox.alert({
          title: "<b>Full Name</b>",	
          message: "New value should be different than old value.",
          onHidden: function(e) {
            $('#full_name_update_new_value').focus();
          }
          });
          return;  			 
  		} else {  		
  			postData["name"] = {"old":$('#full_name_old_value').text(),"new":$('#full_name_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Full Name</b>: " + $('#full_name_old_value').text() + " -> " + $('#full_name_update_new_value').val();
  		}	
  	}
  	
  	if ($('#dob_update').is(':checked')){
  		isUpdate = true;
  		if($('#dob_update_new_value').val() == $('#dob_old_value').text())
      {
          bootbox.alert({
              title: "<b>DOB</b>",	
              message: "New Value Should be different.",
              onHidden: function(e) {
                $('#dob_update_new_value').focus();
              }
              });
              return;  			 
  		} else {  		
  			postData["dob"] = {"old":$('#dob_old_value').text(),"new":$('#dob_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>DOB</b>: " + $('#dob_old_value').text() + " -> " + $('#dob_update_new_value').val();
  		}	
  	}

	if ($('#age_update').is(':checked')){
  		isUpdate = true;
  		if($('#age_update_new_value').val() == $('#age_old_value').text())
      {
          bootbox.alert({
              title: "<b>Age</b>",	
              message: "New Value Should be different.",
              onHidden: function(e) {
                $('#dob_update_new_value').focus();
              }
              });
              return;  			 
  		} else {  		
  			postData["age"] = {"old":$('#age_old_value').text(),"new":$('#age_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Age</b>: " + $('#age_old_value').text() + " -> " + $('#age_update_new_value').val();
  		}	
  	}
  	
  	if ($('#gender_update').is(':checked')){
  		isUpdate = true;
      var selectedDepartment = $('#gender_update_new_value option:selected');
      var selectedDepartmentName = selectedDepartment.text();
      var selectedDepartmentId = selectedDepartment.val();
  		if(selectedDepartmentName == $('#gender_old_value').text()){
          bootbox.alert({
              title: "<b>Gender</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#gender_update_new_value').focus();
              }
              });
              return;  			 
  		}
  		  else {  		
  			postData["sex"] = {"old":$('#gender_old_value').text(),"new":$('#gender_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Gender</b>: " + $('#gender_old_value').text() + " -> " + selectedDepartmentName;
  		}	
  	}
  	
  	if ($('#marital_status_update').is(':checked')){
  		isUpdate = true;
      var selectedUnit = $('#marital_status_update_new_value option:selected');
      var selectedUnitName = selectedUnit.text();
      var selectedUnitId = selectedUnit.val();
  		if(selectedUnitName == $('#marital_status_old_value').text()){
                       bootbox.alert({
                       	    title: "<b>Marital Status</b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#marital_status_update_new_value').focus();
                            }
                            });
                            return;  			 
  		}  else {  		
  			postData["maritial_status"] = {"old":$('#marital_status_old_value').text(),"new":$('#marital_status_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Marital Status</b>: " + $('#marital_status_old_value').text() + " -> " + selectedUnitName;
  		}	
  	}

  	if ($('#parent_spouse_update').is(':checked')){
  		isUpdate = true;  		
  		if($('#parent_spouse_update_new_value').val() == $('#parent_spouse_old_value').text()){
                       bootbox.alert({
                       	    title: "<b> Parent or Spouse </b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#parent_spouse_update_new_value').focus();
                            }
                            });
                            return;  			 
  		} else {  		
  			postData["parent_spouse"] = {"old":$('#parent_spouse_old_value').text(),"new":$('#parent_spouse_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Parent or Spouse</b>: " + $('#parent_spouse_old_value').text() + " -> " + $('#parent_spouse_update_new_value').val();
  		}	
  	}

	if ($('#occupation_update').is(':checked')){
  		isUpdate = true;  		
  		if($('#occupation_update_new_value').val() == $('#occupation_old_value').text()){
                       bootbox.alert({
                       	    title: "<b> Occupation </b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#occupation_update_new_value').focus();
                            }
                            });
                            return;  			 
  		} else {  		
  			postData["occupation"] = {"old":$('#occupation_old_value').text(),"new":$('#occupation_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Occupation</b>: " + $('#occupation_old_value').text() + " -> " + $('#occupation_update_new_value').val();
  		}	
  	}

	if ($('#address_update').is(':checked')){
  		isUpdate = true;  		
  		if($('#address_update_new_value').val() == $('#address_old_value').text()){
                       bootbox.alert({
                       	    title: "<b> Address </b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#address_update_new_value').focus();
                            }
                            });
                            return;  			 
  		} else {  		
  			postData["address"] = {"old":$('#address_old_value').text(),"new":$('#address_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Address</b>: " + $('#address_old_value').text() + " -> " + $('#address_update_new_value').val();
  		}	
  	}

  	if ($('#blood_group_update').is(':checked')){
  		isUpdate = true;
      var selectedArea = $('#blood_group_update_new_value option:selected');
      var selectedAreaName = selectedArea.text();
      var selectedAreaId = selectedArea.val();
  		if(selectedAreaName == $('#blood_group_old_value').text()){
                       bootbox.alert({
                       	    title: "<b>Blood Group</b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#blood_group_update_new_value').focus();
                            }
                            });
                            return;  			 
  		} else {  		
  			postData["blood_group"] = {"old":$('#blood_group_old_value').text(),"new":$('#blood_group_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Blood Group</b>: " + $('#blood_group_old_value').text() + " -> " + selectedAreaName;
  		}	
  	}

	if ($('#phone_update').is(':checked')){
  		isUpdate = true;  		
  		if($('#phone_update_new_value').val() == $('#phone_old_value').text()){
                       bootbox.alert({
                       	    title: "<b> Phone </b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#phone_update_new_value').focus();
                            }
                            });
                            return;  			 
  		} else {  		
  			postData["phone"] = {"old":$('#phone_old_value').text(),"new":$('#phone_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Phone</b>: " + $('#phone_old_value').text() + " -> " + $('#phone_update_new_value').val();
  		}	
  	}

	if ($('#email_update').is(':checked')){
  		isUpdate = true;  		
  		if($('#email_update_new_value').val() == $('#email_old_value').text()){
                       bootbox.alert({
                       	    title: "<b> Email </b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#email_update_new_value').focus();
                            }
                            });
                            return;  			 
  		} else {  		
  			postData["email"] = {"old":$('#email_old_value').text(),"new":$('#email_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Email</b>: " + $('#email_old_value').text() + " -> " + $('#email_update_new_value').val();
  		}	
  	}
  	
  	
if (!isUpdate) {
  bootbox.alert("There are nothing to update!");
  return;
}  	
        
bootbox.confirm({
    title: "<b>Please confirm the updates!</b>",	
    message: updateAlert,
    buttons: {
      confirm: {
        label: 'Yes',
        className: 'btn btn-success'
      },
      cancel: {
        label: 'No',
        className: 'btn btn-danger'
      }
    },
    callback: function (result) {
      if(result) 
      {		      
        $.ajax({
        url: '<?php echo base_url();?>bloodbank/register/update_selected_donor_details',
        contentType : "application/json; charset=UTF-8",
                type : "POST",
        success: function (data) {	
            var bracetoast = JSON.parse(data);
            var message = bracetoast.Message;
            alert(message);
            location.reload();
        },
        error: function(data){
          bootbox.alert(data.Message);
        },
        data: JSON.stringify(postData)
        });
      }
    }
	});
  	
}
  
</script>
<div class="container col-md-offset-2">
<h3 class="col-md-12 " style="margin-top:7%">Edit Blood Donor Details</h3>
  <?php echo form_open("bloodbank/register/update_register_donor_details",array('role'=>'form','class'=>'form-custom col-md-12')); ?>   
 	   <div class="form-group">     
 	   		<label for="donor_id">Donor ID:</label>         
           	<input type="text" class="form-control" placeholder="Donor Id" id="donor_id" 
		   		value="<?php echo $this->input->post('donor_id');?>" name="donor_id" autocomplete="off"
		   			onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required>  
        </div>
        <input type="submit" value="Get details" name="submitBtn" class="btn btn-primary btn-sm" />
  </form>
</div>
<div class="row col-md-offset-2" >
  <div style="margin-top:4%!important;" class="col-md-12">
    <?php if(isset($get_donor_details_to_edit) && count($get_donor_details_to_edit)>0){ ?>
    
    <h4 style="margin-left:13px;">Available Details</h4>
    <table class="table table-bordered table-striped" id="table-sort" style="margin-left:13px;">
      <thead>
        <th style="text-align:center;">SNo</th>
        <th style="text-align:center;">Full Name</th>
        <th style="text-align:center;">Blood Group</th>
        <th style="text-align:center;">Age</th>
        <th style="text-align:center;">Gender</th>
        <th style="text-align:center;">Actions</th>
      </thead>
      <tbody>
      <?php 
      $sno=1;
      foreach($get_donor_details_to_edit as $avail){ ?>
      <tr>
        <td style="text-align:center;"><?php echo $sno;?></td>
        <td style="text-align:center;"><?php echo $avail->name ?></td>
        <td style="text-align:center;"><?php echo $avail->blood_group ?></td>
        <td style="text-align:center;"><?php echo $avail->age?></td>
        <td style="text-align:center;"><?php if($avail->sex=='m'){ echo "Male"; }else if($avail->sex=='f'){ echo "Female"; }else{ echo "others"; } ?></td>
        <td style="text-align:center;">
          <a data-id="<?php echo $avail->donor_id;?>" class="btn btn-success" id="edit"
          style="color:white;text-decoration:none!important;">Edit</a>
        </td>
      </tr>
      
      <?php $sno++;} ?>
      </tbody>
    </table>
<script>
      $(document).on("click",'#edit',function(){
        var donor_id = $(this).attr("data-id");
        conf = confirm('Are you sure you want to edit this entry?');
        $('.old-value-container').html('');
        if(conf==true)
        {
          $.ajax({
              type: "POST",
              url: "<?php echo base_url('bloodbank/register/get_donor_details_for_edit'); ?>",
              data: {donor_id:donor_id},
              dataType:'json',
              success: function(response) {
                //console.log(response);
                for (i=0;i<response.length;i++)
                {
                  var name = response[i]['name']; 
				  var dob = response[i]['dob'];
                  var age = response[i]['age']; 
				  var sex = response[i]['sex'];
                  var maritial_status = response[i]['maritial_status']; 
				  var parent_spouse = response[i]['parent_spouse'];
                  var occupation = response[i]['occupation']; 
				  var address = response[i]['address'];
                  var blood_group = response[i]['blood_group']; 
				  var phone = response[i]['phone'];
                  var email = response[i]['email']; 
                }
                document.getElementById('donor_id_con').value = donor_id;
                $('#full_name_old_value').append(name);
                $('#dob_old_value').append(dob);
                $('#age_old_value').append(age);
                $('#gender_old_value').append(sex);
                $('#marital_status_old_value').append(maritial_status);
                $('#parent_spouse_old_value').append(parent_spouse);
                $('#occupation_old_value').append(occupation);
                $('#address_old_value').append(address);
                $('#blood_group_old_value').append(blood_group);
                $('#phone_old_value').append(phone);
                $('#email_old_value').append(email);
              },
              error: function(error) {
                console.error("Error:", error);
              }
            });
        }else
        {
          return false;
        }
      })
</script>
<?php } ?>
</div>
<div class="container">
      <input type="hidden" name="donor_id" value="" id="donor_id_con">
      <input type="hidden" name="post_donor_id" value="<?php echo $this->input->post('donor_id'); ?>" id="post_donor_id">
      <?php $user=$this->session->userdata('logged_in');  ?>
      <input type="hidden" name="sesion_user_id" value="<?php echo $user['user_id']; ?>" id="session_user_id"><br/>       
  <table class="table">
    <thead>
      <tr>
        <th>Field Name</th>
        <th>Current Value</th>
        <th>Need update ?</th>
        <th>New Value</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Full Name</td>
        <td class="old-value-container" id="full_name_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="full_name_update" name="full_name_update" value="full_name_update"></td>
        <td><input type="text" class="form-control" id="full_name_update_new_value" name="full_name_update_new_value" placeholder="" 
		autocomplete="off" value="" disabled></td>
      </tr>

      <tr>
        <td>Date of Birth</td>
        <td class="old-value-container" id="dob_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="dob_update" name="dob_update" value="dob_update"></td>
        <td><input type="date" class="form-control" id="dob_update_new_value" name="dob_update_new_value" placeholder="" 
		autocomplete="off" value="" disabled></td>
      </tr>
      
      <tr>
        <td>Age</td>
        <td class="old-value-container" id="age_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="age_update" name="age_update" value="age_update"></td>
		<td><input type="text" class="form-control" id="age_update_new_value" name="age_update_new_value" placeholder="" 
		autocomplete="off" value="" disabled></td>
      </tr>
      
      <tr>
        <td>Gender </td>
        <td class="old-value-container" id="gender_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="gender_update" name="gender_update" value="gender_update"></td>
        <td>
			<select class="form-control" name="gender_update_new_value" id="gender_update_new_value" disabled>
				<option value="" disabled selected>Select Gender</option>
				<option value="male">Male</option>
				<option value="female">Female</option>
				<option value="other">Others</option>
			</select>
		</td>
      </tr>
      
	  <tr>
        <td>Marital Status</td>
        <td class="old-value-container" id="marital_status_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="marital_status_update" name="marital_status_update" value="marital_status_update"></td>
        <td>
          <select class="form-control" id="marital_status_update_new_value" name="marital_status_update_new_value" disabled>
		  	<option value="">Select  Marital Status</option>
			<option value="single">Single</option>
			<option value="married">Married</option>
			<option value="divorced">Divorced</option>
			<option value="separated">Separated</option>
			<option value="widowed">Widowed</option>
          </select>
        </td>
      </tr>

      <tr>
        <td>Parent (or) Spouse name </td>
        <td class="old-value-container" id="parent_spouse_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="parent_spouse_update" name="parent_spouse_update" value="parent_spouse_update"></td>
        <td><input type="text" class="form-control" id="parent_spouse_update_new_value" name="parent_spouse_update_new_value" placeholder="" 
		autocomplete="off" value="" disabled></td>
      </tr>
      
      <tr>
        <td>Occupation </td>
        <td class="old-value-container"  id="occupation_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="occupation_update" name="occupation_update" value="occupation_update"></td>
        <td><input type="text" class="form-control" id="occupation_update_new_value" name="occupation_update_new_value" placeholder="" 
		autocomplete="off" value="" disabled></td>
      </tr>
      
      <tr>
        <td>Address </td>
        <td class="old-value-container" id="address_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="address_update" name="address_update" value="address_update"></td>
        <td><input type="text" class="form-control" id="address_update_new_value" name="address_update_new_value" placeholder="" 
		autocomplete="off" value="" disabled></td>
      </tr>
      
      <tr>
        <td>Blood Group</td>
        <td class="old-value-container" id="blood_group_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="blood_group_update" name="blood_group_update" value="blood_group_update"></td>
        <td>
			<select class="form-control" name="blood_group_update_new_value" id="blood_group_update_new_value" disabled>
				<option value="" disabled selected>Blood Group</option>
				<option value="A+">A+</option>
				<option value="B+">B+</option>
				<option value="O+">O+</option>
				<option value="AB+">AB+</option>
				<option value="A-">A-</option>
				<option value="B-">B-</option>
				<option value="O-">O-</option>
				<option value="AB-">AB-</option>
			</select>
		</td>
      </tr>
      
      <tr>
        <td>Phone.no </td>
        <td class="old-value-container" id="phone_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="phone_update" name="phone_update" value="phone_update"></td>
        <td><input type="text" class="form-control" id="phone_update_new_value" name="phone_update_new_value" placeholder="" 
		autocomplete="off" value=""  disabled></td>
      </tr>
      
      
      <tr>
        <td>Email Id</td>
        <td class="old-value-container" id="email_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="email_update" name="email_update" value="email_update"></td>
        <td><input type="text" class="form-control" id="email_update_new_value" name="email_update_new_value" placeholder="" 
		autocomplete="off" value=""  disabled></td>
      </tr>
      
    </tbody>
  </table>
</div>
<center><button class="btn btn-primary btn-sm" id="submitUpdations" onclick="submitUpdations()">Update</button></center>

<?php if(isset($donor_details_edit_history) && count($donor_details_edit_history)>0){ ?>
<h2>Donor Details Edit History</h2>
<table class="table table-bordered table-striped" id="table-sort">
	<thead>
		<th>SNo</th>
		<th>Table name</th>
		<th>Field name</th>
		<th>Previous value</th>
		<th>New value</th>
		<th>Edit date & time</th>
		<th>Edited by</th>
	</thead>
	<tbody>
	<?php 
	$sno=1;
	foreach($donor_details_edit_history as $edit)
  { 
    
  ?> 
	<tr>
		<td><?php echo $sno;?></td>
		<td><?php echo $edit->table_name;?></td>
		<td><?php echo $edit->field_name;?></td>
		<td><?php echo $edit->previous_value;?></td>
		<td>
      <?php 
       
          echo $edit->new_value; 
         
      ?>
    </td>		
		<td><?php echo date("j M Y", strtotime("$edit->edit_date_time")).", ".date("h:i A.", strtotime("$edit->edit_date_time"));?></td>
		<td><?php echo $edit->username;?></td>	
	</tr>
	<?php $sno++;} ?>
	</tbody>
</table>
<?php } else {?>
<?php if(isset($error)) {?>
<div class="col-md-12 alert alert-danger"><?php echo $error;?></div>
<?php } ?>
<?php } ?>