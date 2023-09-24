<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
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
  
  
</script>
 <h3 class="col-md-12">Edit Patient Demographic details</h3>
<?php echo form_open("patient/edit_patient_demographic_details",array('role'=>'form','class'=>'form-custom col-md-12')); ?>   
 	   <div class="form-group">     
 	   <label for="patient_id">Patient ID:</label>         
           <input type="text" class="form-control" placeholder="Patient ID" value="<?php echo $this->input->post('patient_id');?>" name="patient_id" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required>  
             <input type="submit" value="Get details" name="submitBtn" class="btn btn-primary btn-sm" /> 
            </div>
</form>
<br />

<div class="col-md-12">
 <br />
    <?php if(isset($receivers_exists_msg)) { ?>
        <div class="col-md-12 alert alert-danger"><?php echo $receivers_exists_msg; ?></div>
    <?php }?>
 <br />
</div>

<?php if(isset($patient_data) && count($patient_data)>0){ ?>
<div class="container">
  <h2>Detals</h2>        
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
        <td><?php if(!!$patient_data[0]->patient_id_manual) {echo $patient_data[0]->patient_id_manual;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="patient_id_manual_update" name="patient_id_manual_update" value="patient_id_manual_update"></td>
        <td><input type="text" class="form-control" id="patient_id_manual_update_new_value" name="patient_id_manual_update_new_value" placeholder="New patient ID manual" value="" disabled></td>
      </tr>
      
      <tr>
        <td>First Name</td>
        <td><?php if(!!$patient_data[0]->first_name) {echo $patient_data[0]->first_name;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="first_name_update" name="first_name_update" value="first_name_update"></td>
        <td><input type="text" class="form-control" id="first_name_update_new_value" name="first_name_update_new_value" placeholder="New first name" value="" disabled></td>
      </tr>
      
      <tr>
        <td>Middle Name</td>
        <td><?php if(!!$patient_data[0]->middle_name) {echo $patient_data[0]->middle_name;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="middle_name_update" name="middle_name_update" value="middle_name_update"></td>
        <td><input type="text" class="form-control" id="middle_name_update_new_value" name="middle_name_update_new_value" placeholder="New middle name" value="" disabled></td>
      </tr>
      
      
      <tr>
        <td>Last Name</td>
        <td><?php if(!!$patient_data[0]->last_name) {echo $patient_data[0]->last_name;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="last_name_update" name="last_name_update" value="last_name_update"></td>
        <td><input type="text" class="form-control" id="last_name_update_new_value" name="last_name_update_new_value" placeholder="New last name" value="" disabled></td>
      </tr>
      
      
      <tr>
        <td>Phone</td>
        <td><?php if(!!$patient_data[0]->phone) {echo $patient_data[0]->phone;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="phone_update" name="phone_update" value="phone_update"></td>
        <td><input type="text" class="form-control" id="phone_update_new_value" name="phone_update_new_value" placeholder="New phone number" value="" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"  disabled></td>
      </tr>
      
      
      <tr>
        <td>Alternate Phone</td>
        <td><?php if(!!$patient_data[0]->alt_phone) {echo $patient_data[0]->alt_phone;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="alt_phone_update" name="alt_phone_update" value="alt_phone_update"></td>
        <td><input type="text" class="form-control" id="alt_phone_update_new_value" name="alt_phone_update_new_value" placeholder="New alternate phone number" value="" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"  disabled></td>
      </tr>
      
      
      <tr>
        <td>Gender</td>
        <td><?php if(!!$patient_data[0]->gender) {if($patient_data[0]->gender=="M"){echo "Male";}
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
        <td><?php if(!!$patient_data[0]->age_years) {echo $patient_data[0]->age_years;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="age_years_update" name="age_years_update" value="age_years_update"></td>
        <td><input type="text" class="form-control" id="age_years_update_new_value" name="age_years_update_new_value" placeholder="New age years" value="" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"  disabled></td>
      </tr>
      
      
      <tr>
        <td>Age Months</td>
        <td><?php if(!!$patient_data[0]->age_months) {echo $patient_data[0]->age_months;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="age_months_update" name="age_months_update" value="age_months_update"></td>
        <td><input type="text" class="form-control" id="age_months_update_new_value" name="age_months_update_new_value" placeholder="New age months" value="" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"  disabled></td>
      </tr>
      
      <tr>
        <td>Age Days</td>
        <td><?php if(!!$patient_data[0]->age_days) {echo $patient_data[0]->age_days;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="age_days_update" name="age_days_update" value="age_days_update"></td>
        <td><input type="text" class="form-control" id="age_days_update_new_value" name="age_days_update_new_value" placeholder="New age days" value="" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"  disabled></td>
      </tr>
      
      <tr>
        <td>Address</td>
        <td><?php if(!!$patient_data[0]->address) {echo $patient_data[0]->address;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="address_update" name="address_update" value="address_update"></td>
        <td><input type="text" class="form-control" id="address_update_new_value" name="address_update_new_value" placeholder="New address" value=""  disabled></td>
      </tr>
      
      
      <tr>
        <td>Place</td>
        <td><?php if(!!$patient_data[0]->place) {echo $patient_data[0]->place;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="place_update" name="place_update" value="place_update"></td>
        <td><input type="text" class="form-control" id="place_update_new_value" name="place_update_new_value" placeholder="New place" value=""  disabled></td>
      </tr>
      
      
      <tr>
        <td>Father Name</td>
        <td><?php if(!!$patient_data[0]->father_name) {echo $patient_data[0]->father_name;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="father_name_update" name="father_name_update" value="father_name_update"></td>
        <td><input type="text" class="form-control" id="father_name_update_new_value" name="father_name_update_new_value" placeholder="New father name" value=""  disabled></td>
      </tr>
      
       <tr>
        <td>Mother Name</td>
        <td><?php if(!!$patient_data[0]->mother_name) {echo $patient_data[0]->mother_name;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="mother_name_update" name="mother_name_update" value="father_name_update"></td>
        <td><input type="text" class="form-control" id="mother_name_update_new_value" name="mother_name_update_new_value" placeholder="New mother name" value=""  disabled></td>
      </tr>
      
      
      <tr>
        <td>Spouse Name</td>
        <td><?php if(!!$patient_data[0]->mother_name) {echo $patient_data[0]->mother_name;}?></td>
        <td><input type="checkbox" class="form-check-input"  id="spouse_name_update" name="spouse_name_update" value="spouse_name_update"></td>
        <td><input type="text" class="form-control" id="spouse_name_update_new_value" name="spouse_name_update_new_value" placeholder="New spouse name" value=""  disabled></td>
      </tr>
      
      
    </tbody>
  </table>
</div>

<?php } else {?>

<div class="col-md-12 alert alert-danger">Patient details not found.</div>

<?php } ?>
  
      
