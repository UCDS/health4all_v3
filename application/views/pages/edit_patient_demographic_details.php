<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">

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
  function submitUpdations(){
  
        let isUpdate = false;
        
        
        var postData = {};
  	postData["patient_id"] = $('#patient_id').val();
  	var updateAlert = "The following data would be changed";
  	
  	
  	if ($('#patient_id_manual_update').is(':checked')){
  		isUpdate = true;
  		if($('#patient_id_manual_update_new_value').val() == $('#patient_id_manual_update_old_value').text()){
                       bootbox.alert({
                       	    title: "<b>Patient id manual</b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#patient_id_manual_update_new_value').focus();
                            }
                            });
                            return;  			 
  		} else {  		
  			postData["patient_id_manual"] = {"old":$('#patient_id_manual_update_old_value').text(),"new":$('#patient_id_manual_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Patient ID manual</b>: " + $('#patient_id_manual_update_old_value').text() + " -> " + $('#patient_id_manual_update_new_value').val();
  		}	
  	}
  	
  	if ($('#first_name_update').is(':checked')){
  		isUpdate = true;
  		if($('#first_name_update_new_value').val() == $('#first_name_update_old_value').text()){
                       bootbox.alert({
                       	    title: "<b>First name</b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#first_name_update_new_value').focus();
                            }
                            });
                            return;  			 
  		} else {  		
  			postData["first_name"] = {"old":$('#first_name_update_old_value').text(),"new":$('#first_name_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>First name</b>: " + $('#first_name_update_old_value').text() + " -> " + $('#first_name_update_new_value').val();
  		}	
  	}
  	
  	if ($('#middle_name_update').is(':checked')){
  		isUpdate = true;
  		if($('#middle_name_update_new_value').val() == $('#middle_name_update_old_value').text()){
                       bootbox.alert({
                       	    title: "<b>Middle name</b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#middle_name_update_new_value').focus();
                            }
                            });
                            return;  			 
  		}
  		  else {  		
  			postData["middle_name"] = {"old":$('#middle_name_update_old_value').text(),"new":$('#middle_name_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Middle name</b>: " + $('#middle_name_update_old_value').text() + " -> " + $('#middle_name_update_new_value').val();
  		}	
  	}
  	
  	if ($('#last_name_update').is(':checked')){
  		isUpdate = true;
  		if($('#last_name_update_new_value').val() == $('#last_name_update_old_value').text()){
                       bootbox.alert({
                       	    title: "<b>Last name</b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#last_name_update_new_value').focus();
                            }
                            });
                            return;  			 
  		}  else {  		
  			postData["last_name"] = {"old":$('#last_name_update_old_value').text(),"new":$('#last_name_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Last name</b>: " + $('#last_name_update_old_value').text() + " -> " + $('#last_name_update_new_value').val();
  		}	
  	}
  	
  	if ($('#phone_update').is(':checked')){
  		isUpdate = true;
  		if($('#phone_update_new_value').val() == $('#phone_update_old_value').text()){
                       bootbox.alert({
                       	    title: "<b>Phone</b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#phone_update_new_value').focus();
                            }
                            });
                            return;  			 
  		} else {  		
  			postData["phone"] = {"old":$('#phone_update_old_value').text(),"new":$('#phone_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Phone</b>: " + $('#phone_update_old_value').text() + " -> " + $('#phone_update_new_value').val();
  		}	
  	}
  	
  	
  	if ($('#alt_phone_update').is(':checked')){
  		isUpdate = true;
  		if($('#alt_phone_update_new_value').val() == $('#alt_phone_update_old_value').text()){
                       bootbox.alert({
                       	    title: "<b>Alternate phone</b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#alt_phone_update_new_value').focus();
                            }
                            });
                            return;  			 
  		} else {  		
  			postData["alt_phone"] = {"old":$('#alt_phone_update_old_value').text(),"new":$('#alt_phone_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Alternate Phone</b>: " + $('#alt_phone_update_old_value').text() + " -> " + $('#alt_phone_update_new_value').val();
  		}	
  	}
  
  	if ($('#gender_update').is(':checked')){
  		isUpdate = true;
  		if($('#gender_update_new_value option:selected').text() == $('#gender_update_old_value').text()){
                       bootbox.alert({
                       	    title: "<b>Gender</b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#gender_update_new_value').focus();
                            }
                            });
                            return;  			 
  		} else {  		
  			postData["gender"] = {"old":$('#gender_update_old_value').text()[0],"new":$('#gender_update_new_value option:selected').val()};
  			updateAlert = updateAlert + "<br> <b>Gender</b>: " + $('#gender_update_old_value').text() + " -> " + $('#gender_update_new_value option:selected').text();
  		}	
  	}
  	
  	if ($('#age_years_update').is(':checked')){
  		isUpdate = true;  		
  		if($('#age_years_update_new_value').val() == $('#age_years_update_old_value').text()){
                       bootbox.alert({
                       	    title: "<b>Age years</b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#age_years_update_new_value').focus();
                            }
                            });
                            return;  			 
  		} else {  		
  			postData["age_years"] = {"old":$('#age_years_update_old_value').text(),"new":$('#age_years_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Age years</b>: " + $('#age_years_update_old_value').text() + " -> " + $('#age_years_update_new_value').val();
  		}	
  	}
  	
  	if ($('#age_months_update').is(':checked')){
  		isUpdate = true;
  		if($('#age_months_update_new_value').val() == $('#age_months_update_old_value').text()){
                       bootbox.alert({
                       	    title: "<b>Age months</b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#age_months_update_new_value').focus();
                            }
                            });
                            return;  			 
  		} else {  		
  			postData["age_months"] = {"old":$('#age_months_update_old_value').text(),"new":$('#age_months_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Age months</b>: " + $('#age_months_update_old_value').text() + " -> " + $('#age_months_update_new_value').val();
  		}	
  	}
  	
  	
  	if ($('#age_days_update').is(':checked')){
  		isUpdate = true;
  		if($('#age_days_update_new_value').val() == $('#age_days_update_old_value').text()){
                       bootbox.alert({
                       	    title: "<b>Age days</b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#age_days_update_new_value').focus();
                            }
                            });
                            return;  			 
  		} else {  		
  			postData["age_days"] = {"old":$('#age_days_update_old_value').text(),"new":$('#age_days_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Age days</b>: " + $('#age_days_update_old_value').text() + " -> " + $('#age_days_update_new_value').val();
  		}	
  	}
  	
  	
  	if ($('#address_update').is(':checked')){
  		isUpdate = true;
  		if($('#address_update_new_value').val() == $('#address_update_old_value').text()){
                       bootbox.alert({
                       	    title: "<b>Address</b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#address_update_new_value').focus();
                            }
                            });
                            return;  			 
  		} else {  		
  			postData["address"] = {"old":$('#address_update_old_value').text(),"new":$('#address_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Address</b>: " + $('#address_update_old_value').text() + " -> " + $('#address_update_new_value').val();
  		}	
  	}
  	
  	if ($('#place_update').is(':checked')){
  		isUpdate = true;
  		if($('#place_update_new_value').val() == $('#place_update_old_value').text()){
                       bootbox.alert({
                       	    title: "<b>Place</b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#place_update_new_value').focus();
                            }
                            });
                            return;  			 
  		} else {  		
  			postData["place"] = {"old":$('#place_update_old_value').text(),"new":$('#place_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Place</b>: " + $('#place_update_old_value').text() + " -> " + $('#place_update_new_value').val();
  		}	
  	}
  	
  	
  	if ($('#father_name_update').is(':checked')){
  		isUpdate = true;
  		if($('#father_name_update_new_value').val() == $('#father_name_update_old_value').text()){
                       bootbox.alert({
                       	    title: "<b>Father name</b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#father_name_update_new_value').focus();
                            }
                            });
                            return;  			 
  		} else {  		
  			postData["father_name"] = {"old":$('#father_name_update_old_value').text(),"new":$('#father_name_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Father name</b>: " + $('#father_name_update_old_value').text() + " -> " + $('#father_name_update_new_value').val();
  		}	
  	}
  	
  	if ($('#mother_name_update').is(':checked')){
  		isUpdate = true;
  		if($('#mother_name_update_new_value').val() == $('#mother_name_update_old_value').text()){
                       bootbox.alert({
                       	    title: "<b>Mother name</b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#mother_name_update_new_value').focus();
                            }
                            });
                            return;  			 
  		} else {  		
  			postData["mother_name"] = {"old":$('#mother_name_update_old_value').text(),"new":$('#mother_name_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Mother name</b>: " + $('#mother_name_update_old_value').text() + " -> " + $('#mother_name_update_new_value').val();
  		}	
  	}
  	
  	if ($('#spouse_name_update').is(':checked')){
  		isUpdate = true;
  		if($('#spouse_name_update_new_value').val() == $('#spouse_name_update_old_value').text()){
                       bootbox.alert({
                       	    title: "<b>Spouse name</b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#spouse_name_update_new_value').focus();
                            }
                            });
                            return;  			 
  		}  else {  		
  			postData["spouse_name"] = {"old":$('#spouse_name_update_old_value').text(),"new":$('#spouse_name_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Spouse name</b>: " + $('#spouse_name_update_old_value').text() + " -> " + $('#spouse_name_update_new_value').val();
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
		    
		    if (result) {		      
		  	$.ajax({
			    url: '<?php echo base_url();?>patient/update_patient_demographic_details',
			    contentType : "application/json; charset=UTF-8",
          		    type : "POST",
			    success: function (data) {	    
				bootbox.alert({
                       	  		message: data.Message,
                            		onHidden: function(e) {
                            			location.reload();
                            		}
                            	 });				
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
 <h3 class="col-md-12">Edit Patient Demographic details</h3>
<?php echo form_open("patient/edit_patient_demographic_details",array('role'=>'form','class'=>'form-custom col-md-12')); ?>   
 	   <div class="form-group">     
 	   <label for="patient_id">Patient ID:</label>         
           <input type="text" class="form-control" placeholder="Patient ID" id="patient_id" value="<?php echo $this->input->post('patient_id');?>" name="patient_id" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required>  
            </div>
            <input type="submit" value="Get details" name="submitBtn" class="btn btn-primary btn-sm" /> 
</form>
<br>
<br>
<br>
<br>
<?php if(isset($patient_data) && count($patient_data)>0){ 
?>
<div class="container">
  
  <h2>Details</h2>        
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
        <td>Patient ID manual</td>
        <td id="patient_id_manual_update_old_value"><?php if(!!$patient_data[0]->patient_id_manual) {echo $patient_data[0]->patient_id_manual;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="patient_id_manual_update" name="patient_id_manual_update" value="patient_id_manual_update"></td>
        <td><input type="text" class="form-control" id="patient_id_manual_update_new_value" name="patient_id_manual_update_new_value" placeholder="New patient ID manual" value="" disabled></td>
      </tr>
      
      <tr>
        <td>First Name</td>
        <td id="first_name_update_old_value"><?php if(!!$patient_data[0]->first_name) {echo $patient_data[0]->first_name;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="first_name_update" name="first_name_update" value="first_name_update"></td>
        <td><input type="text" class="form-control" id="first_name_update_new_value" name="first_name_update_new_value" placeholder="New first name" value="" disabled></td>
      </tr>
      
      <tr>
        <td>Middle Name</td>
        <td id="middle_name_update_old_value"><?php if(!!$patient_data[0]->middle_name) {echo $patient_data[0]->middle_name;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="middle_name_update" name="middle_name_update" value="middle_name_update"></td>
        <td><input type="text" class="form-control" id="middle_name_update_new_value" name="middle_name_update_new_value" placeholder="New middle name" value="" disabled></td>
      </tr>
      
      
      <tr>
        <td>Last Name</td>
        <td id="last_name_update_old_value"><?php if(!!$patient_data[0]->last_name) {echo $patient_data[0]->last_name;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="last_name_update" name="last_name_update" value="last_name_update"></td>
        <td><input type="text" class="form-control" id="last_name_update_new_value" name="last_name_update_new_value" placeholder="New last name" value="" disabled></td>
      </tr>
      
      
      <tr>
        <td>Phone</td>
        <td id="phone_update_old_value"><?php if(!!$patient_data[0]->phone) {echo $patient_data[0]->phone;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="phone_update" name="phone_update" value="phone_update"></td>
        <td><input type="text" class="form-control" id="phone_update_new_value" name="phone_update_new_value" placeholder="New phone number" value="" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"  disabled></td>
      </tr>
      
      
      <tr>
        <td>Alternate Phone</td>
        <td id="alt_phone_update_old_value"><?php if(!!$patient_data[0]->alt_phone) {echo $patient_data[0]->alt_phone;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="alt_phone_update" name="alt_phone_update" value="alt_phone_update"></td>
        <td><input type="text" class="form-control" id="alt_phone_update_new_value" name="alt_phone_update_new_value" placeholder="New alternate phone number" value="" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"  disabled></td>
      </tr>
      
      
      <tr>
        <td>Gender</td>
        <td id="gender_update_old_value" value="<?php echo ($patient_data[0]->gender); ?>"><?php if(!!$patient_data[0]->gender) {if($patient_data[0]->gender=="M"){echo "Male";}
        if($patient_data[0]->gender=="F"){echo "Female";}
        if($patient_data[0]->gender=="O"){echo "Others";}
        }?></td>
        <td><input type="checkbox" class="form-check-input"  id="gender_update" name="gender_update" value="gender_update"></td>
        <td>   
        	<select name="gender_update_new_value" id="gender_update_new_value" class="form-control"  disabled>
				<option value="M">Male</option>
				<option value="F">Female</option>
				<option value="O">Others</option>
		</select>
        </td>
      </tr>
      
      <tr>
        <td>Age Years</td>
        <td id="age_years_update_old_value"><?php if(!!$patient_data[0]->age_years) {echo $patient_data[0]->age_years;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="age_years_update" name="age_years_update" value="age_years_update"></td>
        <td><input type="text" class="form-control" id="age_years_update_new_value" name="age_years_update_new_value" placeholder="New age years" value="" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"  disabled></td>
      </tr>
      
      
      <tr>
        <td>Age Months</td>
        <td id="age_months_update_old_value"><?php if(!!$patient_data[0]->age_months) {echo $patient_data[0]->age_months;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="age_months_update" name="age_months_update" value="age_months_update"></td>
        <td><input type="text" class="form-control" id="age_months_update_new_value" name="age_months_update_new_value" placeholder="New age months" value="" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"  disabled></td>
      </tr>
      
      <tr>
        <td>Age Days</td>
        <td id="age_days_update_old_value"><?php if(!!$patient_data[0]->age_days) {echo $patient_data[0]->age_days;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="age_days_update" name="age_days_update" value="age_days_update"></td>
        <td><input type="text" class="form-control" id="age_days_update_new_value" name="age_days_update_new_value" placeholder="New age days" value="" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"  disabled></td>
      </tr>
      
      <tr>
        <td>Address</td>
        <td id="address_update_old_value"><?php if(!!$patient_data[0]->address) {echo $patient_data[0]->address;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="address_update" name="address_update" value="address_update"></td>
        <td><input type="text" class="form-control" id="address_update_new_value" name="address_update_new_value" placeholder="New address" value=""  disabled></td>
      </tr>
      
      
      <tr>
        <td>Place</td>
        <td id="place_update_old_value"><?php if(!!$patient_data[0]->place) {echo $patient_data[0]->place;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="place_update" name="place_update" value="place_update"></td>
        <td><input type="text" class="form-control" id="place_update_new_value" name="place_update_new_value" placeholder="New place" value=""  disabled></td>
      </tr>
      
      
      <tr>
        <td>Father Name</td>
        <td id="father_name_update_old_value"><?php if(!!$patient_data[0]->father_name) {echo $patient_data[0]->father_name;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="father_name_update" name="father_name_update" value="father_name_update"></td>
        <td><input type="text" class="form-control" id="father_name_update_new_value" name="father_name_update_new_value" placeholder="New father name" value=""  disabled></td>
      </tr>
      
       <tr>
        <td>Mother Name</td>
        <td id="mother_name_update_old_value"><?php if(!!$patient_data[0]->mother_name) {echo $patient_data[0]->mother_name;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="mother_name_update" name="mother_name_update" value="father_name_update"></td>
        <td><input type="text" class="form-control" id="mother_name_update_new_value" name="mother_name_update_new_value" placeholder="New mother name" value=""  disabled></td>
      </tr>
      
      
      <tr>
        <td>Spouse Name</td>
        <td id="spouse_name_update_old_value"><?php if(!!$patient_data[0]->spouse_name) {echo $patient_data[0]->spouse_name;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="spouse_name_update" name="spouse_name_update" value="spouse_name_update"></td>
        <td><input type="text" class="form-control" id="spouse_name_update_new_value" name="spouse_name_update_new_value" placeholder="New spouse name" value=""  disabled></td>
      </tr>
      
      
    </tbody>
  </table>
</div>
<center><button class="btn btn-primary btn-sm" id="submitUpdations" onclick="submitUpdations()">Update</button></center>
<?php } ?>
<?php if(isset($patient_data_edit_history) && count($patient_data_edit_history)>0){ ?>
<h2>Edit History</h2>
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
	foreach($patient_data_edit_history as $edit){ ?> 
	<tr>
		<td><?php echo $sno;?></td>
		<td><?php echo $edit->table_name;?></td>
		<td><?php echo $edit->field_name;?></td>
		<td><?php echo $edit->previous_value;?></td>
		<td><?php echo $edit->new_value;?></td>		
		<td><?php echo date("j M Y", strtotime("$edit->edit_date_time")).", ".date("h:i A.", strtotime("$edit->edit_date_time"));?></td>
		<td><?php echo $edit->edit_staff;?></td>	
		
		
	</tr>
	<?php $sno++;} ?>
	</tbody>
	
</table>

<?php } else {?>
<?php if(isset($error)) {?>
<div class="col-md-12 alert alert-danger"><?php echo $error;?></div>
<?php } ?>
<?php } ?>
  
      
