<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/ckeditor.js"></script>
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
  postData["visit_id"] = $("#visit_id_con").val();
  postData["user_id"] = $("#session_user_id").val();
  postData["patient_id"] = $("#post_patient_id").val();
  
  var updateAlert = "The following data would be changed";
  	
  	if ($('#admit_date_update').is(':checked')){
  		isUpdate = true;
  		if($('#admit_date_update_new_value').val() == $('#admit_date_manual_update_old_value').text())
      {
          bootbox.alert({
          title: "<b>Admit Date</b>",	
          message: "New value should be different than old value.",
          onHidden: function(e) {
            $('#admit_date_update_new_value').focus();
          }
          });
          return;  			 
  		} else {  		
  			postData["admit_date"] = {"old":$('#admit_date_manual_update_old_value').text(),"new":$('#admit_date_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Admit Date</b>: " + $('#admit_date_manual_update_old_value').text() + " -> " + $('#admit_date_update_new_value').val();
  		}	
  	}
  	
  	if ($('#admit_time_update').is(':checked')){
  		isUpdate = true;
  		if($('#admit_time_update_new_value').val() == $('#admit_time_update_old_value').text())
      {
          bootbox.alert({
              title: "<b>Admit Time</b>",	
              message: "New Value Should be different.",
              onHidden: function(e) {
                $('#admit_time_update_new_value').focus();
              }
              });
              return;  			 
  		} else {  		
  			postData["admit_time"] = {"old":$('#admit_time_update_old_value').text(),"new":$('#admit_time_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Admit Time</b>: " + $('#admit_time_update_old_value').text() + " -> " + $('#admit_time_update_new_value').val();
  		}	
  	}
  	
  	if ($('#department_name_update').is(':checked')){
  		isUpdate = true;
      var selectedDepartment = $('#department_name_update_new_value option:selected');
      var selectedDepartmentName = selectedDepartment.text();
      var selectedDepartmentId = selectedDepartment.val();
  		if(selectedDepartmentName == $('#department_update_old_value').text()){
          bootbox.alert({
              title: "<b>Department name</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#department_name_update_new_value').focus();
              }
              });
              return;  			 
  		}
  		  else {  		
  			postData["department_id"] = {"old":$('#department_update_old_value').text(),"new":$('#department_name_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Department name</b>: " + $('#department_update_old_value').text() + " -> " + selectedDepartmentName;
  		}	
  	}
  	
  	if ($('#unit_name_update').is(':checked')){
  		isUpdate = true;
      var selectedUnit = $('#unit_name_update_new_value option:selected');
      var selectedUnitName = selectedUnit.text();
      var selectedUnitId = selectedUnit.val();
  		if(selectedUnitName == $('#unit_update_old_value').text()){
                       bootbox.alert({
                       	    title: "<b>Unit name</b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#unit_name_update_new_value').focus();
                            }
                            });
                            return;  			 
  		}  else {  		
  			postData["unit"] = {"old":$('#unit_update_old_value').text(),"new":$('#unit_name_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Unit</b>: " + $('#unit_update_old_value').text() + " -> " + selectedUnitName;
  		}	
  	}
  	
  	if ($('#area_update').is(':checked')){
  		isUpdate = true;
      var selectedArea = $('#area_update_new_value option:selected');
      var selectedAreaName = selectedArea.text();
      var selectedAreaId = selectedArea.val();
  		if(selectedAreaName == $('#area_update_old_value').text()){
                       bootbox.alert({
                       	    title: "<b>Area Name</b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#area_update_new_value').focus();
                            }
                            });
                            return;  			 
  		} else {  		
  			postData["area"] = {"old":$('#area_update_old_value').text(),"new":$('#area_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Area</b>: " + $('#area_update_old_value').text() + " -> " + selectedAreaName;
  		}	
  	}
  	 	
  	if ($('#visit_type_update').is(':checked')){
  		isUpdate = true;
      var selectedVisit = $('#visit_type_update_new_value option:selected');
      var selectedVisitName = selectedVisit.text();
      var selectedVisitId = selectedVisit.val();
  		if(selectedVisitName == $('#visti_type_update_old_value').text()){
                       bootbox.alert({
                       	    title: "<b>Visit Type</b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#visit_type_update_new_value').focus();
                            }
                            });
                            return;  			 
  		} else {  		
  			postData["visit_name_id"] = {"old":$('#visti_type_update_old_value').text(),"new":$('#visit_type_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Visit Type</b>: " + $('#visti_type_update_old_value').text() + " -> " + selectedVisitName ;
  		}	
  	}
  
    if ($('#presenting_comp_update').is(':checked')){
  		isUpdate = true;  		
  		if($('#presenting_comp_update_new_value').val() == $('#presenting_comp_update_old_value').text()){
                       bootbox.alert({
                       	    title: "<b> Presenting Complaints </b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#presenting_comp_update_new_value').focus();
                            }
                            });
                            return;  			 
  		} else {  		
  			postData["presenting_complaints"] = {"old":$('#presenting_comp_update_old_value').text(),"new":$('#presenting_comp_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Presenting Complaints</b>: " + $('#presenting_comp_update_old_value').text() + " -> " + $('#presenting_comp_update_new_value').val();
  		}	
  	}
  	
  	if ($('#past_history_update').is(':checked')){
  		isUpdate = true;  		
  		if($('#past_history_update_new_value').val() == $('#past_history_update_old_value').text())
      {
          bootbox.alert({
              title: "<b> Past History </b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#past_history_update_new_value').focus();
              }
              });
              return;  			 
  		} else {  		
  			postData["past_history"] = {"old":$('#past_history_update_old_value').text(),"new":$('#past_history_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Past History</b>: " + $('#past_history_update_old_value').text() + " -> " + $('#past_history_update_new_value').val();
  		}	
  	}
  	
  	if ($('#family_history_update').is(':checked')){
  		isUpdate = true;
  		if($('#family_history_update_new_value').val() == $('#family_history_update_old_value').text()){
                       bootbox.alert({
                       	    title: "<b>Family History</b>",	
                            message: "New value should be different than old value.",
                            onHidden: function(e) {
                            	$('#family_history_update_new_value').focus();
                            }
                            });
                            return;  			 
  		} else {  		
  			postData["family_history"] = {"old":$('#family_history_update_old_value').text(),"new":$('#family_history_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Family History</b>: " + $('#family_history_update_old_value').text() + " -> " + $('#family_history_update_new_value').val();
  		}	
  	}
  	
  	if ($('#admit_weight_update').is(':checked')){
  		isUpdate = true;
  		if($('#admit_weight_update_new_value').val() == $('#admit_weight_update_old_value').text())
      {
          bootbox.alert({
              title: "<b>Admit Weight</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#admit_weight_update_new_value').focus();
              }
              });
              return;  			 
  		} else {  		
  			postData["admit_weight"] = {"old":$('#admit_weight_update_old_value').text(),"new":$('#admit_weight_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Admit Weight</b>: " + $('#admit_weight_update_old_value').text() + " -> " + $('#admit_weight_update_new_value').val();
  		}	
  	}
  	
  	if ($('#pulse_rate_update').is(':checked')){
  		isUpdate = true;
  		if($('#pulse_rate_update_new_value').val() == $('#pulse_rate_old_value').text())
      {
          bootbox.alert({
              title: "<b>Pulse Rate</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#pulse_rate_update_new_value').focus();
              }
              });
              return;  			 
  		} else {  		
  			postData["pulse_rate"] = {"old":$('#pulse_rate_old_value').text(),"new":$('#pulse_rate_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Pulse Rate</b>: " + $('#pulse_rate_old_value').text() + " -> " + $('#pulse_rate_update_new_value').val();
  		}	
  	}
  	
  	if ($('#respiratory_rate_update').is(':checked')){
  		isUpdate = true;
  		if($('#respiratory_rate_update_new_value').val() == $('#respiratory_rate_update_old_value').text())
      {
          bootbox.alert({
              title: "<b>PRespiratory Rate</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#respiratory_rate_update_new_value').focus();
              }
              });
              return;  			 
  		} else {  		
  			postData["respiratory_rate"] = {"old":$('#respiratory_rate_update_old_value').text(),"new":$('#respiratory_rate_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Respiratory</b>: " + $('#respiratory_rate_update_old_value').text() + " -> " + $('#respiratory_rate_update_new_value').val();
  		}	
  	}
  	
  	if ($('#temperature_name_update').is(':checked')){
  		isUpdate = true;
  		if($('#temperature_name_update_new_value').val() == $('#temperature_update_old_value').text())
      {
          bootbox.alert({
              title: "<b>Temperature</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#temperature_name_update_new_value').focus();
              }
              });
              return;  			 
  		} else {  		
  			postData["temperature"] = {"old":$('#temperature_update_old_value').text(),"new":$('#temperature_name_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Temperature</b>: " + $('#temperature_update_old_value').text() + " -> " + $('#temperature_name_update_new_value').val();
  		}	
  	}
  	
  	if ($('#sbp_update').is(':checked')){
  		isUpdate = true;
  		if($('#sbp_update_new_value').val() == $('#sbp_update_old_value').text())
      {
          bootbox.alert({
              title: "<b>SBP</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#sbp_update_new_value').focus();
              }
              });
              return;  			 
  		} else {  		
  			postData["sbp"] = {"old":$('#sbp_update_old_value').text(),"new":$('#sbp_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>SBP</b>: " + $('#sbp_update_old_value').text() + " -> " + $('#sbp_update_new_value').val();
  		}	
  	}
  	
  	if ($('#dbp_update').is(':checked')){
  		isUpdate = true;
  		if($('#dbp_update_new_value').val() == $('#dbp_update_old_value').text())
      {
          bootbox.alert({
              title: "<b>DBP</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#dbp_update_new_value').focus();
              }
              });
              return;  			 
  		}  else {  		
  			postData["dbp"] = {"old":$('#dbp_update_old_value').text(),"new":$('#dbp_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>DBP</b>: " + $('#dbp_update_old_value').text() + " -> " + $('#dbp_update_new_value').val();
  		}	
  	}

    if ($('#spo2_update').is(':checked')){
  		isUpdate = true;
  		if($('#spo2_update_new_value').val() == $('#spo2_update_old_value').text())
      {
          bootbox.alert({
              title: "<b>SPO 2</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#spo2_update_new_value').focus();
              }
              });
              return;  			 
  		}  else {  		
  			postData["spo2"] = {"old":$('#spo2_update_old_value').text(),"new":$('#spo2_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Spo 2</b>: " + $('#spo2_update_old_value').text() + " -> " + $('#spo2_update_new_value').val();
  		}	
  	}

    if ($('#blood_sugar_update').is(':checked')){
  		isUpdate = true;
  		if($('#blood_sugar_update_new_value').val() == $('#blood_sugar_update_old_value').text())
      {
          bootbox.alert({
              title: "<b>Blood Sugar</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#blood_sugar_update_new_value').focus();
              }
              });
              return;  			 
  		}  else {  		
  			postData["blood_sugar"] = {"old":$('#blood_sugar_update_old_value').text(),"new":$('#blood_sugar_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Blood Sugar</b>: " + $('#blood_sugar_update_old_value').text() + " -> " + $('#blood_sugar_update_new_value').val();
  		}	
  	}

    if ($('#hb_update').is(':checked')){
  		isUpdate = true;
  		if($('#hb_update_new_value').val() == $('#hb_update_old_value').text())
      {
          bootbox.alert({
              title: "<b>HB</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#hb_update_new_value').focus();
              }
              });
              return;  			 
  		}  else {  		
  			postData["hb"] = {"old":$('#hb_update_old_value').text(),"new":$('#hb_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>HB</b>: " + $('#hb_update_old_value').text() + " -> " + $('#hb_update_new_value').val();
  		}	
  	}

    if ($('#clinical_finding_update').is(':checked')){
  		isUpdate = true;
  		if($('#clinical_finding_update_new_value').val() == $('#clinical_finding_update_old_value').text())
      {
          bootbox.alert({
              title: "<b>Clinical Finding</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#clinical_finding_update_new_value').focus();
              }
              });
              return;  			 
  		}  else {  		
  			postData["clinical_findings"] = {"old":$('#clinical_finding_update_old_value').text(),"new":$('#clinical_finding_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Clinical Finding</b>: " + $('#clinical_finding_update_old_value').text() + " -> " + $('#clinical_finding_update_new_value').val();
  		}	
  	}

    if ($('#cvs_update').is(':checked')){
  		isUpdate = true;
  		if($('#cvs_update_new_value').val() == $('#cvs_update_old_value').text())
      {
          bootbox.alert({
              title: "<b>CVS</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#cvs_update_new_value').focus();
              }
              });
              return;  			 
  		}  else {  		
  			postData["cvs"] = {"old":$('#cvs_update_old_value').text(),"new":$('#cvs_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>CVS</b>: " + $('#cvs_update_old_value').text() + " -> " + $('#cvs_update_new_value').val();
  		}	
  	}

    if ($('#rs_update').is(':checked')){
  		isUpdate = true;
  		if($('#rs_update_new_value').val() == $('#rs_update_old_value').text())
      {
          bootbox.alert({
              title: "<b>RS</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#rs_update_new_value').focus();
              }
              });
              return;  			 
  		}  else {  		
  			postData["rs"] = {"old":$('#rs_update_old_value').text(),"new":$('#rs_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>RS</b>: " + $('#rs_update_old_value').text() + " -> " + $('#rs_update_new_value').val();
  		}	
  	}

    if ($('#pa_update').is(':checked')){
  		isUpdate = true;
  		if($('#pa_update_new_value').val() == $('#pa_update_old_value').text())
      {
          bootbox.alert({
              title: "<b>PA</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#pa_update_new_value').focus();
              }
              });
              return;  			 
  		}  else {  		
  			postData["pa"] = {"old":$('#pa_update_old_value').text(),"new":$('#pa_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>PA</b>: " + $('#pa_update_old_value').text() + " -> " + $('#pa_update_new_value').val();
  		}	
  	}

    if ($('#cns_update').is(':checked')){
  		isUpdate = true;
  		if($('#cns_update_new_value').val() == $('#cns_update_old_value').text())
      {
          bootbox.alert({
              title: "<b>CNS</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#cns_update_new_value').focus();
              }
              });
              return;  			 
  		}  else {  		
  			postData["cns"] = {"old":$('#cns_update_old_value').text(),"new":$('#cns_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>CNS</b>: " + $('#cns_update_old_value').text() + " -> " + $('#cns_update_new_value').val();
  		}	
  	}

    if ($('#cxr_update').is(':checked')){
  		isUpdate = true;
  		if($('#cxr_update_new_value').val() == $('#cxr_update_old_value').text())
      {
          bootbox.alert({
              title: "<b>CXR</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#cxr_update_new_value').focus();
              }
              });
              return;  			 
  		}  else {  		
  			postData["cxr"] = {"old":$('#cxr_update_old_value').text(),"new":$('#cxr_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>CXR</b>: " + $('#cxr_update_old_value').text() + " -> " + $('#cxr_update_new_value').val();
  		}	
  	}

    if ($('#provisional_diagnosis_update').is(':checked')){
  		isUpdate = true;
  		if($('#provisional_diagnosis_update_new_value').val() == $('#provisional_diagnosis_update_old_value').text())
      {
          bootbox.alert({
              title: "<b>Provisional Diagnosis</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#provisional_diagnosis_update_new_value').focus();
              }
              });
              return;  			 
  		}  else {  		
  			postData["provisional_diagnosis"] = {"old":$('#provisional_diagnosis_update_old_value').text(),"new":$('#provisional_diagnosis_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Provisional Diagnosis</b>: " + $('#provisional_diagnosis_update_old_value').text() + " -> " + $('#provisional_diagnosis_update_new_value').val();
  		}	
  	}

    if ($('#fd_update').is(':checked')){
  		isUpdate = true;
  		if($('#fd_update_new_value').val() == $('#fd_update_old_value').text())
      {
          bootbox.alert({
              title: "<b>Final Diagnosis</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#fd_update_new_value').focus();
              }
              });
              return;  			 
  		}  else {  		
  			postData["final_diagnosis"] = {"old":$('#fd_update_old_value').text(),"new":$('#fd_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Final Diagnosis</b>: " + $('#fd_update_old_value').text() + " -> " + $('#fd_update_new_value').val();
  		}	
  	}

    if ($('#decision_update').is(':checked')){
  		isUpdate = true;
  		if($('#decision_update_new_value').val() == $('#decision_update_old_value').text())
      {
          bootbox.alert({
              title: "<b>Decision</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#decision_update_new_value').focus();
              }
              });
              return;  			 
  		}  else {  		
  			postData["decision"] = {"old":$('#decision_update_old_value').text(),"new":$('#decision_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Decision</b>: " + $('#decision_update_old_value').text() + " -> " + $('#decision_update_new_value').val();
  		}	
  	}
    
    if ($('#advise_update').is(':checked')){
  		isUpdate = true;
  		if($('#advise_update_new_value').val() == $('#advise_update_old_value').text())
      {
          bootbox.alert({
              title: "<b>Advise Update</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#advise_update_new_value').focus();
              }
              });
              return;  			 
  		}  else {  		
  			postData["advise"] = {"old":$('#advise_update_old_value').text(),"new":$('#advise_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Advise Update</b>: " + $('#advise_update_old_value').text() + " -> " + $('#advise_update_new_value').val();
  		}	
  	}

    if ($('#outcome_update').is(':checked')){
  		isUpdate = true;
  		if($('#outcome_update_new_value').val() == $('#outcome_update_old_value').text())
      {
          bootbox.alert({
              title: "<b>Outcome</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#outcome_update_new_value').focus();
              }
              });
              return;  			 
  		}  else {  		
  			postData["outcome"] = {"old":$('#outcome_update_old_value').text(),"new":$('#outcome_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Outcome</b>: " + $('#outcome_update_old_value').text() + " -> " + $('#outcome_update_new_value').val();
  		}	
  	}

    if ($('#outcome_date_update').is(':checked')){
  		isUpdate = true;
  		if($('#outcome_date_update_new_value').val() == $('#outcome_date_update_old_value').text())
      {
          bootbox.alert({
              title: "<b>Outcome Date</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#outcome_date_update_new_value').focus();
              }
              });
              return;  			 
  		}  else {  		
  			postData["outcome_date"] = {"old":$('#outcome_date_update_old_value').text(),"new":$('#outcome_date_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Outcome Date</b>: " + $('#outcome_date_update_old_value').text() + " -> " + $('#outcome_date_update_new_value').val();
  		}	
  	}

    if ($('#outcome_time_update').is(':checked')){
  		isUpdate = true;
  		if($('#outcome_time_update_new_value').val() == $('#outcome_time_update_old_value').text())
      {
          bootbox.alert({
              title: "<b> Outcome Time </b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#outcome_time_update_new_value').focus();
              }
              });
              return;  			 
  		}  else {  		
  			postData["outcome_time"] = {"old":$('#outcome_time_update_old_value').text(),"new":$('#outcome_time_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Outcome Time</b>: " + $('#outcome_time_update_old_value').text() + " -> " + $('#outcome_time_update_new_value').val();
  		}	
  	}

    if ($('#icdcode_update').is(':checked')){
  		isUpdate = true;
  		if($('#icdcode_update_new_value').val() == $('#icdcode_update_old_value').text())
      {
          bootbox.alert({
              title: "<b>Icd Code</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#icdcode_update_new_value').focus();
              }
              });
              return;  			 
  		}  else {  		
  			postData["icd_10"] = {"old":$('#icdcode_update_old_value').text(),"new":$('#icdcode_update_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Icd Code</b>: " + $('#icdcode_update_old_value').text() + " -> " + $('#icdcode_update_new_value').val();
  		}	
  	}

    if ($('#signed_consultation').is(':checked')){
  		isUpdate = true;
  		if($('#signed_consultation_new_value').val() == $('#signed_consultation_old_value').text())
      {
          bootbox.alert({
              title: "<b>Signed Consultation Update</b>",	
              message: "New value should be different than old value.",
              onHidden: function(e) {
                $('#signed_consultaion_new_value').focus();
              }
              });
              return;  			 
  		}  else {  		
  			postData["signed_consultation"] = {"old":$('#signed_consultation_old_value').text(),"new":$('#signed_consultation_new_value').val()};
  			updateAlert = updateAlert + "<br> <b>Signed Consultation Update</b>: " + $('#signed_consultation_old_value').text() + " -> " + $('#signed_consultation_new_value').val();
  		}	
  	}

    if ($('#referral_hospital_name_update').is(':checked')) {
        isUpdate = true;

        var selectedHospital = $('#referral_hospital_name_update_new_value option:selected');
        var selectedHospitalName = selectedHospital.text();
        var selectedHospitalId = selectedHospital.val();
        
        if (selectedHospitalName === $('#referral_hospital_update_old_value').text()) {
            bootbox.alert({
                title: "<b>Referral Hospital</b>",
                message: "New value should be different than old value.",
                onHidden: function(e) {
                    $('#referral_hospital_name_update_new_value').focus();
                }
            });
            return;
        } else {
            postData["referral_by_hospital_id"] = {
                "old": $('#referral_hospital_update_old_value').text(),
                "new": selectedHospitalId
            };
            updateAlert += "<br><b>Referral Hospital</b>: " + $('#referral_hospital_update_old_value').text() + " -> " + selectedHospitalName;
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
        url: '<?php echo base_url();?>patient/update_patient_visit_details',
        contentType : "application/json; charset=UTF-8",
                type : "POST",
        success: function (data) {
            var bracetoast = JSON.parse(data);
            var message = bracetoast.Message;
            alert(message);
            location.reload();
        },
        error: function(jqXHR, textStatus, errorThrown) {
          alert('AJAX error occurred: ' + textStatus + ' - ' + errorThrown);
          console.error('Full error response:', jqXHR);
          var responseText = jqXHR.responseText || "No response text";
          bootbox.alert("Error: " + responseText);
        },
        data: JSON.stringify(postData)
        });
      }
    }
	});
  	
}
  
</script>
<h3 class="col-md-12">Edit Patient Visit History</h3>
  <?php echo form_open("patient/edit_patient_visits",array('role'=>'form','class'=>'form-custom col-md-12')); ?>   
 	   <div class="form-group">     
 	   <label for="patient_id">Patient ID:</label>         
           <input type="text" class="form-control" placeholder="Patient ID" id="patient_id" value="<?php echo $this->input->post('patient_id');?>" name="patient_id" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required>  
            </div>
            <input type="submit" value="Get details" name="submitBtn" class="btn btn-primary btn-sm" />
  </form>

<div class="row">
  <div style="margin-top:4%!important;" class="col-md-12">
    <?php if(isset($patient_visits_to_edit) && count($patient_visits_to_edit)>0){ ?>
    
    <h4 style="margin-left:13px;">Available Visits</h4>
    <table class="table table-bordered table-striped" id="table-sort" style="margin-left:13px;">
      <thead>
        <th style="text-align:center;">SNo</th>
        <th style="text-align:center;">Patient id</th>
        <th style="text-align:center;">OP / IP Trends</th>
        <th style="text-align:center;">Visit type</th>
        <th style="text-align:center;">Department</th>
        <th style="text-align:center;">Admit date</th>
        <th style="text-align:center;">Actions</th>
      </thead>
      <tbody>
      <?php 
      $sno=1;
      foreach($patient_visits_to_edit as $avail){ ?> 
      <tr>
        <td style="text-align:center;"><?php echo $sno;?></td>
        <td style="text-align:center;"><?php echo $avail->patient_id ?></td>
        <td style="text-align:center;"><?php echo $avail->visit_type." #".$avail->hosp_file_no;?></td>
        <td style="text-align:center;"><?php echo $avail->vn ?></td>
        <td style="text-align:center;"><?php echo $avail->dname;?></td>
        <td style="text-align:center;"><?php echo date("j M Y", strtotime("$avail->admit_date")).", ".date("h:i A.", strtotime("$avail->admit_time"));?></td>
        <td style="text-align:center;">
          <a data-id="<?php echo $avail->visit_id;?>" class="btn btn-success" id="edit"
          style="color:white;text-decoration:none!important;">Edit</a>
        </td>
      </tr>
      
      <?php $sno++;} ?>
      </tbody>
    </table>
    <script>
      $(document).on("click",'#edit',function(){
        var visit_id = $(this).attr("data-id");
        conf = confirm('Are you sure you want to edit this entry?');
        $('.old-value-container').html('');
        if(conf==true)
        {
          $.ajax({
              type: "POST",
              url: "<?php echo base_url('patient/get_visits_for_edit'); ?>",
              data: {visit_id:visit_id},
              dataType:'json',
              success: function(response) {
                //console.log(response);
                for (i=0;i<response.length;i++)
                {
                  var admit_date = response[i]['admit_date']; var temperature = response[i]['temperature'];
                  var admit_time = response[i]['admit_time']; var sbp = response[i]['sbp'];
                  var dnmame = response[i]['dnmame']; var dbp = response[i]['dbp'];
                  var unit_name = response[i]['unit_name']; var spo2 = response[i]['spo2'];
                  var area_name = response[i]['area_name']; var blood_sugar = response[i]['blood_sugar'];
                  var visit_type = response[i]['visit_name']; var hb = response[i]['hb'];
                  var presenting_complaints = response[i]['presenting_complaints']; var clinical_findings = response[i]['clinical_findings'];
                  var past_history = response[i]['past_history']; var cvs = response[i]['cvs'];
                  var family_history = response[i]['family_history']; var rs = response[i]['rs'];
                  var admit_weight = response[i]['admit_weight']; var pa = response[i]['pa'];
                  var pulse_rate = response[i]['pulse_rate']; var cns = response[i]['cns'];
                  var respiratory_rate = response[i]['respiratory_rate']; var cxr = response[i]['cxr'];
                  var provisional_diagnosis = response[i]['provisional_diagnosis'];
                  var final_diagnosis = response[i]['final_diagnosis'];
                  var decision = response[i]['decision'];
                  var advise = response[i]['advise'];
                  var outcome = response[i]['outcome'];
                  var outcome_date = response[i]['outcome_date'];
                  var outcome_time = response[i]['outcome_time'];
                  var icd_10 = response[i]['icd_10'];
                  var visit_type_op_ip = response[i]['visit_type'];
				  var appointment_slot_id = response[i]['appointment_status_id'];
                  var signed_consult_val = response[i]['signed_consultation'];
                  var hname = response[i]['hospital'];
                }
				//console.log(appointment_slot_id);
				if (appointment_slot_id > 0) {
					$('#tr_department').hide();
					$('#tr_unit').hide();
					$('#tr_area').hide();
					$('#visit_ip').hide();
					$('#alert_appointment_slot').show();
				}
				else {
					$('#tr_department').show();
					$('#tr_unit').show();
					$('#tr_area').show();
					$('#visit_ip').show();
					$('#alert_appointment_slot').hide();
				}
                document.getElementById('visit_id_con').value = visit_id;
                document.getElementById('visit_type_op_ip').value = visit_type_op_ip;
                $('#admit_date_manual_update_old_value').append(admit_date);
                $('#admit_time_update_old_value').append(admit_time);
                $('#department_update_old_value').append(dnmame);
                $('#unit_update_old_value').append(unit_name);
                $('#area_update_old_value').append(area_name);
                $('#visti_type_update_old_value').append(visit_type);
                $('#presenting_comp_update_old_value').append(presenting_complaints);
                $('#past_history_update_old_value').append(past_history);
                $('#family_history_update_old_value').append(family_history);
                $('#admit_weight_update_old_value').append(admit_weight);
                $('#pulse_rate_old_value').append(pulse_rate);
                $('#respiratory_rate_update_old_value').append(respiratory_rate);
                $('#temperature_update_old_value').append(temperature);
                $('#sbp_update_old_value').append(sbp);
                $('#dbp_update_old_value').append(dbp);
                $('#spo2_update_old_value').append(spo2);
                $('#blood_sugar_update_old_value').append(blood_sugar);
                $('#hb_update_old_value').append(hb);
                $('#clinical_finding_update_old_value').append(clinical_findings);
                $('#cvs_update_old_value').append(cvs);
                $('#rs_update_old_value').append(rs);
                $('#pa_update_old_value').append(pa);
                $('#cns_update_old_value').append(cns);
                $('#cxr_update_old_value').append(cxr);
                $('#provisional_diagnosis_update_old_value').append(provisional_diagnosis);
                $('#fd_update_old_value').append(final_diagnosis);
                $('#decision_update_old_value').append(decision);
                $('#advise_update_old_value').append(advise);
                $('#outcome_update_old_value').append(outcome);
                $('#outcome_date_update_old_value').append(outcome_date);
                $('#outcome_time_update_old_value').append(outcome_time);
                $('#icdcode_update_old_value').append(icd_10);
                $('#signed_consultation_old_value').append(signed_consult_val);
                $('#referral_hospital_update_old_value').append(hname);

                var tbody = $('#counseling-table-body');
                tbody.empty();
                for (var i = 0; i < response.length; i++) {
                    var c_txt = response[i]['c_txt'];
                    var counselingId = response[i]['counseling_id'];
                    if (c_txt != null && c_txt !== undefined) {
                        var row = '<tr>' +
                                  '<td style="text-align:right;">' + (i + 1) + '</td>' +
                                  '<td>' + c_txt + '</td>' +
                                  '<td style="text-align:center;">' +
                                  '<button type="button" class="btn btn-danger" onclick="deleteCounseling(' + counselingId + ')">Delete Counseling Text</button>' +
                                  '</td>' +
                                  '</tr>';
                        tbody.append(row);
                    }
                }
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
      function deleteCounseling(counselingId) 
      {
        $.ajax({
            type: "POST",
            url: "<?php echo base_url().'patient/del_visits_counseling_text' ?>",
            data: { counselingId: counselingId },
            dataType: "json",
            success: function(response) {
                console.log('Delete request successful:', response);
                if (response.success) {
                    alert('Counseling text deleted successfully');
                    location.reload();
                } else {
                    alert('No counseling text found for deletion');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error deleting counseling text:', error);
                alert('An error occurred while deleting counseling text');
            }
        });
      }
  </script>
<script>
      $(document).on("click",'#edit',function(){
        var visit_id = $(this).attr("data-id");
          $.ajax({
              type: "POST",
              url: "<?php echo base_url('patient/get_op_ip_visit'); ?>",
              data: {visit_id:visit_id},
              dataType:'json',
              success: function(response) {
                console.log(response);
                var visitTypeSelect = '<select name="visit_type_update_new_value" id="visit_type_update_new_value" class="form-control ip" disabled>' +
                                        '<option>Choose Visit Type</option>';
                $.each(response.visit_types, function(index, vt) {
                    visitTypeSelect += '<option value="' + vt.visit_name_id + '">' + vt.visit_name + '</option>';
                });
                visitTypeSelect += '</select>';
                
                $('#visit_ip select[name="visit_type_update_new_value"]').replaceWith(visitTypeSelect);
            },
            error: function(error) {
                console.error("Error:", error);
            }
            });
      })
</script>
    <?php } ?>
  </div>
<div class="container">
      <input type="hidden" name="visit_id" value="" id="visit_id_con">
      <input type="hidden" name="visit_type_op_ip" value="" id="visit_type_op_ip">
      <input type="hidden" name="post_patient_id" value="<?php echo $this->input->post('patient_id'); ?>" id="post_patient_id">
      <?php $user=$this->session->userdata('logged_in');  ?>
      <input type="hidden" name="sesion_user_id" value="<?php echo $user['user_id']; ?>" id="session_user_id">
  <h2>Edit Details</h2>  
  <div id="alert_appointment_slot" hidden class="alert alert-danger" role="alert">This visit is belonging to an appointment slot. Edit provision for Department,Unit,Area and Visit Type won't be available here. Please check the Registrations/Appointments for the same.</div>  
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
        <td>Admit Date</td>
        <td class="old-value-container" id="admit_date_manual_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="admit_date_update" name="admit_date_manual_update" value="admit_date_manual_update"></td>
        <td><input type="date" class="form-control" id="admit_date_update_new_value" name="admit_date_update_new_value" placeholder="" value="" disabled></td>
      </tr>
      <?php 
        $time_2=date("g:iA");
      ?>
      <tr>
        <td>Admit Time</td>
        <td class="old-value-container" id="admit_time_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="admit_time_update" name="admit_time_update" value="admit_time_update"></td>
        <td><input type="time" class="form-control" id="admit_time_update_new_value" name="admit_time_update_new_value" placeholder="" value="<?php echo $time_2 ?>" disabled></td>
      </tr>
      
      <tr id="tr_department">
        <td>Department</td>
        <td class="old-value-container" id="department_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="department_name_update" name="department_name_update" value="department_name_update"></td>
        <td>
          <select class="form-control" id="department_name_update_new_value" name="department_update_new_value" disabled>
              <option>Choose Department</option>
              <?php foreach($departments as $d){ ?>
							  <option value="<?php echo $d->department_id; ?>"><?php echo $d->department; ?></option>
						  <?php } ?>
          </select>
        </td>
      </tr>
      
      <tr id="tr_unit">
        <td>Unit</td>
        <td class="old-value-container" id="unit_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="unit_name_update" name="unit_name_update" value="unit_name_update"></td>
        <td>
          <select class="form-control" id="unit_name_update_new_value" name="unit_name_update_new_value" disabled>
              <option>Choose Unit</option>
              <?php foreach($units as $u){ ?>
							  <option value="<?php echo $u->unit_id; ?>"><?php echo $u->unit_name; ?></option>
						  <?php } ?>
          </select>
        </td>
      </tr>
      
      <tr id="tr_area">
        <td>Area</td>
        <td class="old-value-container" id="area_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="area_update" name="area_update" value="area_update"></td>
        <td>
          <select class="form-control" id="area_update_new_value" name="area_update_new_value" disabled>
              <option>Choose Area</option>
              <?php foreach($areas as $a){ ?>
							  <option value="<?php echo $a->area_id; ?>"><?php echo $a->area_name; ?></option>
						  <?php } ?>
          </select>
        </td>
      </tr>
      
      <tr id="visit_ip">
        <td>Vist Type</td>
        <td class="old-value-container" id="visti_type_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="visit_type_update" name="visit_type_update" value="visit_type_update"></td>
        <!-- <td><input type="text" class="form-control" id="visit_type_update_new_value" name="visit_type_update_new_value" 
        placeholder="" value="" disabled></td> -->
        <td><select name="visit_type_update_new_value" id="visit_type_update_new_value" class="form-control" disabled>
              <option>Choose Visit Type</option>
              <?php foreach($visit_types as $vt){ ?>
							  <option value="<?php echo $vt->visit_name_id; ?>"><?php echo $vt->visit_name; ?></option>
						  <?php } ?>
        </select></td>
      </tr>
      
      
      <tr>
        <td>Presenting Complaints</td>
        <td class="old-value-container" id="presenting_comp_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="presenting_comp_update" name="presenting_comp_update" value="presenting_comp_update"></td>
        <td><input type="text" class="form-control" id="presenting_comp_update_new_value" name="presenting_comp_update_new_value" placeholder="" value="" disabled></td>
      </tr>
      
      <tr>
        <td>Past History</td>
        <td class="old-value-container" id="past_history_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="past_history_update" name="past_history_update" value="past_history_update"></td>
        <td><input type="text" class="form-control" id="past_history_update_new_value" name="past_history_update_new_value" placeholder="" value="" disabled></td>
      </tr>
      
      
      <tr>
        <td>Family history</td>
        <td class="old-value-container"  id="family_history_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="family_history_update" name="family_history_update" value="family_history_update"></td>
        <td><input type="text" class="form-control" id="family_history_update_new_value" name="family_history_update_new_value" placeholder="" value="" disabled></td>
      </tr>
      
      <tr>
        <td>Admit Weight</td>
        <td class="old-value-container" id="admit_weight_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="admit_weight_update" name="admit_weight_update" value="admit_weight_update"></td>
        <td><input type="text" class="form-control" id="admit_weight_update_new_value" name="admit_weigh_update_new_value" placeholder="" value="" disabled></td>
      </tr>
      
      <tr>
        <td>Pulse Rate</td>
        <td class="old-value-container" id="pulse_rate_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="pulse_rate_update" name="pulse_rate_update" value="pulse_rate_update"></td>
        <td><input type="text" class="form-control" id="pulse_rate_update_new_value" name="pulse_rate_update_new_value" placeholder="" value=""  disabled></td>
      </tr>
      
      
      <tr>
        <td>Respiratory Rate</td>
        <td class="old-value-container" id="respiratory_rate_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="respiratory_rate_update" name="respiratory_rate_update" value="respiratory_rate_update"></td>
        <td><input type="text" class="form-control" id="respiratory_rate_update_new_value" name="respiratory_rate_new_value" placeholder="" value=""  disabled></td>
      </tr>
      
      
      <tr>
        <td>Temperature</td>
        <td class="old-value-container" id="temperature_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="temperature_name_update" name="temperature_name_update" value="temperature_name_update"></td>
        <td><input type="text" class="form-control" id="temperature_name_update_new_value" name="temperature_name_update_new_value" placeholder="" value=""  disabled></td>
      </tr>
      
       <tr>
        <td>sbp</td>
        <td class="old-value-container" id="sbp_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="sbp_update" name="sbp_update" value="sbp_update"></td>
        <td><input type="text" class="form-control" id="sbp_update_new_value" name="sbp_update_new_value" placeholder="" value=""  disabled></td>
      </tr>
      
      
      <tr>
        <td>dbp</td>
        <td class="old-value-container" id="dbp_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="dbp_update" name="dbp_update" value="dbp_update"></td>
        <td><input type="text" class="form-control" id="dbp_update_new_value" name="dbp_update_new_value" placeholder="" value=""  disabled></td>
      </tr>

      <tr>
        <td>spo2</td>
        <td class="old-value-container" id="spo2_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="spo2_update" name="spo2_update" value="spo2_update"></td>
        <td><input type="text" class="form-control" id="spo2_update_new_value" name="spo2_update_new_value" placeholder="" value=""  disabled></td>
      </tr>
      
      <tr>
        <td>blood sugar</td>
        <td class="old-value-container" id="blood_sugar_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="blood_sugar_update" name="blood_sugar_update" value="blood_sugar_update"></td>
        <td><input type="text" class="form-control" id="blood_sugar_update_new_value" name="blood_sugar_update_new_value" placeholder="" value=""  disabled></td>
      </tr>

      <tr>
        <td>hb</td>
        <td class="old-value-container" id="hb_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="hb_update" name="hb_update" value="hb_update"></td>
        <td><input type="text" class="form-control" id="hb_update_new_value" name="hb_update_new_value" placeholder="" value=""  disabled></td>
      </tr>

      <tr>
        <td>clinical findings</td>
        <td class="old-value-container" id="clinical_finding_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="clinical_finding_update" name="clinical_finding_update" value="clinical_finding_update"></td>
        <td><input type="text" class="form-control" id="clinical_finding_update_new_value" name="clinical_finding_update_new_value" placeholder="" value=""  disabled></td>
      </tr>

      <tr>
        <td>cvs</td>
        <td class="old-value-container" id="cvs_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="cvs_update" name="cvs_update" value="cvs_update"></td>
        <td><input type="text" class="form-control" id="cvs_update_new_value" name="cvs_update_new_value" placeholder="" value=""  disabled></td>
      </tr>

      <tr>
        <td>rs</td>
        <td class="old-value-container" id="rs_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="rs_update" name="rs_update" value="rs_update"></td>
        <td><input type="text" class="form-control" id="rs_update_new_value" name="rs_update_new_value" placeholder="" value=""  disabled></td>
      </tr>

      <tr>
        <td>pa</td>
        <td class="old-value-container" id="pa_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="pa_update" name="pa_update" value="pa_update"></td>
        <td><input type="text" class="form-control" id="pa_update_new_value" name="pa_update_new_value" placeholder="" value=""  disabled></td>
      </tr>

      <tr>
        <td>cns</td>
        <td class="old-value-container" id="cns_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="cns_update" name="cns_update" value="cns_update"></td>
        <td><input type="text" class="form-control" id="cns_update_new_value" name="cns_update_new_value" placeholder="" value=""  disabled></td>
      </tr>

      <tr>
        <td>cxr</td>
        <td class="old-value-container" id="cxr_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="cxr_update" name="cxr_update" value="cxr_update"></td>
        <td><input type="text" class="form-control" id="cxr_update_new_value" name="cxr_update_new_value" placeholder="" value=""  disabled></td>
      </tr>

      <tr>
        <td>provisional diagnosis</td>
        <td class="old-value-container" id="provisional_diagnosis_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="provisional_diagnosis_update" name="provisional_diagnosis_update" value="provisional_diagnosis_update"></td>
        <td><input type="text" class="form-control" id="provisional_diagnosis_update_new_value" name="provisional_diagnosis_update_new_value" placeholder="" value=""  disabled></td>
      </tr>

      <tr>
        <td>Final Diagnosis</td>
        <td class="old-value-container" id="fd_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="fd_update" name="fd_update" value="fd_update"></td>
        <td><input type="text" class="form-control" id="fd_update_new_value" name="fd_update_new_value" placeholder="" value=""  disabled></td>
      </tr>

      <tr>
        <td>Decision</td>
        <td class="old-value-container" id="decision_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="decision_update" name="decision_update" value="decision_update"></td>
        <td><input type="text" class="form-control" id="decision_update_new_value" name="decision_update_new_value" placeholder="" value=""  disabled></td>
      </tr>

      <tr>
        <td>Advise</td>
        <td class="old-value-container" id="advise_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="advise_update" name="advise_update" value="advise_update"></td>
        <td><input type="text" class="form-control" id="advise_update_new_value" name="advise_update_new_value" placeholder="" value=""  disabled></td>
      </tr>

      <tr>
        <td>Outcome</td>
        <td class="old-value-container" id="outcome_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="outcome_update" name="outcome_update" value="outcome_update"></td>
        <!-- <td><input type="text" class="form-control" id="outcome_update_new_value" name="outcome_update_new_value" 
        placeholder="" value=""  disabled></td> -->
        <td><select name="outcome_update_new_value" id="outcome_update_new_value" class="form-control" disabled>
              <option value="#">Choose outcome</option>
              <option value="Discharge">Discharge</option>
              <option value="LAMA">LAMA</option>
              <option value="Absconded">LWI</option>
              <option value="Death">Expired</option>
        </select></td>
      </tr>

      <tr>
        <td>Outcome Date</td>
        <td class="old-value-container" id="outcome_date_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="outcome_date_update" name="outcome_date_update" value="outcome_date_update"></td>
        <td><input type="date" class="form-control" id="outcome_date_update_new_value" name="outcome_date_update_new_value" placeholder="" value=""  disabled></td>
      </tr>

      <?php 
        $time=date("g:iA");
      ?>
      <tr>
        <td>Outcome Time</td>
        <td class="old-value-container" id="outcome_time_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="outcome_time_update" name="outcome_time_update" value="outcome_time_update"></td>
        <td><input type="time" class="form-control" id="outcome_time_update_new_value" name="outcome_time_update_new_value" placeholder="" value="<?php echo $time ?>"  disabled></td>
      </tr>
     
      <tr>
        <td>Icd code</td>
        <td class="old-value-container" id="icdcode_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="icdcode_update" name="icdcode_update" value="icdcode_update"></td>
        <td>
          <select name="icdcode_update_new_value" id="icdcode_update_new_value" class="form-control"  style="width:200px!important;" disabled>
              <option value=""> Choose Icd Code </option>
              <?php foreach($icd_codes as $icd) { ?>
                <option value="<?php echo $icd->icd_code ?>"><?php echo $icd->code_title ?></option>
              <?php } ?>
          </select>
        </td>
      </tr>
      
      <tr>
        <td>Signed Consultation</td>
        <td class="old-value-container" id="signed_consultation_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="signed_consultation" name="signed_consultation" value="signed_consultation"></td>
        <td><input type="text" class="form-control" id="signed_consultation_new_value" name="signed_consultation_new_value" placeholder="" value=""  disabled></td>
      </tr>

      <tr id="tr_referral_hospital">
        <td>Referral Hospital</td>
        <td class="old-value-container" id="referral_hospital_update_old_value"></td>
        <td><input type="checkbox" class="form-check-input"  id="referral_hospital_name_update" name="referral_hospital_name_update" 
          value="referral_hospital_name_update"></td>
        <td>
          <select class="form-control" id="referral_hospital_name_update_new_value" name="referral_hospital_update_new_value" disabled>
              <option>Choose Hospital</option>
              <?php foreach($hospitals as $h){ ?>
							  <option value="<?php echo $h->hospital_id; ?>"><?php echo $h->hospital; ?></option>
						  <?php } ?>
          </select>
        </td>
      </tr>

    </tbody>
  </table>
</div>
<center><button class="btn btn-primary btn-sm" id="submitUpdations" onclick="submitUpdations()">Update</button></center>

<!--Counseling Text Part -->
<div style="margin-top:4%!important;" class="col-md-12">
  <h4 style="margin-left:13px;">Available Counseling Text</h4>
  <table class="table table-bordered table-striped" id="ounseling-table-sort" style="margin-left:13px;">
      <thead>
        <tr>
          <th style="text-align:center;">S.no</th>
          <th style="text-align:center;">Counsleing Text</th>
          <th style="text-align:center;">Actions</th>
        </tr>
      </thead>
      <tbody id="counseling-table-body">
        
      </tbody>
  </table>
</div>

<!--Clinical Notes Part -->
<div style="margin-top:4%!important;" class="col-md-12">
  <h4 style="margin-left:13px;">Available Clinical Notes</h4>
    <table class="table table-bordered table-striped" id="clinical-note-table-sort" style="margin-left:13px;">
      <thead>
          <tr>
            <th style="text-align:center;">S.no</th>
            <th style="text-align:center;">Clinical Notes</th>
            <th style="text-align:center;">Actions</th>
          <tr>
      </thead>
      <tbody id="clinical-note-table-sort tbody">
          <tr>
          <tr>
      </tbody>
          <div class="modal fade" id="editClinicalNoteModal" tabindex="-1" role="dialog" aria-labelledby="editClinicalNoteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editClinicalNoteModalLabel">Edit Clinical Note</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-20px!important;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="updateClinicalNoteForm">
                            <div class="form-group">
                                <textarea class="form-control" id="clinical_note" name="clinical_note"></textarea>
                            </div>
                            <input type="hidden" id="noteIdInput" name="note_id">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="updateBtn_one" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </table>
    <script>
      $(document).on("click",'#edit',function(){
        var visit_id = $(this).attr("data-id");
          if (visit_id !== '') {
              $.ajax({
                  type: "POST",
                  url: "<?php echo base_url('patient/get_clinical_text_to_edit'); ?>",
                  data: {visit_id: visit_id},
                  dataType: 'json',
                  success: function(response) {
                    console.log(response);
                      var tbody = $('#clinical-note-table-sort tbody');
                      tbody.empty();
                      for (var i = 0; i < response.length; i++) {
                          var cNote = response[i]['c_note'];
                          var row = '<tr>' +
                                    '<td style="text-align:right;">' + (i + 1) + '</td>' +
                                    '<td class="clinical-note-text">' + cNote + '</td>' +
                                    '<td style="text-align:center;">' +
                                    '<button type="button" class="btn btn-success edit-btn" data-id="' + response[i]['note_id'] + '">Edit</button>' +
                                    '</td>' +
                                    '</tr>';
                          tbody.append(row);
                      }
                  },
                  error: function(error) {
                      console.error("Error fetching clinical notes:", error);
                  }
              });
          }
      });
    </script>
    <script>
        $(document).ready(function() {
              $(document).on("click", ".edit-btn", function() {
                var clinicalNote = $(this).closest("tr").find(".clinical-note-text").text().trim();
                var noteId = $(this).data("id");
                $("#clinical_note").val(clinicalNote);
                $("#noteIdInput").val(noteId);
                $("#editClinicalNoteModal").modal("show");
            });
            // form here 
            $('#updateBtn_one').click(function(){
                var clinicalNote = $('#clinical_note').val();
                var noteId = $('#noteIdInput').val();
                $.ajax({
                    url: '<?php echo base_url()."patient/update_clinical_note_visits" ?>', 
                    method: 'POST',
                    data: { clinicalNote:clinicalNote,noteId:noteId },
                    dataType: 'json',
                    success: function(response) {
                        if(response) {
                            alert('Clinical note updated successfully');
                        } else {
                            console.log('Failed to update clinical note');
                        }
                        $('#editClinicalNoteModal').modal('hide');
                        location.reload();
                    },
                    error: function(xhr, status, error) 
                    {
                        console.error('Error updating clinical note:', error);
                        alert('An error occurred while updating clinical note');
                    }
                });
            }); //till here
        
        });
    </script>
  </div>
</div>


<?php if(isset($patient_visits_edit_history) && count($patient_visits_edit_history)>0){ ?>
<h2>Patient Visit Edit History</h2>
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
	foreach($patient_visits_edit_history as $edit)
  { 
    
  ?> 
	<tr>
		<td><?php echo $sno;?></td>
		<td><?php echo $edit->table_name;?></td>
		<td><?php echo $edit->field_name;?></td>
		<td><?php echo $edit->previous_value;?></td>
		<td>
      <?php 
        if($edit->dname!='')
        { 
          echo $edit->dname; 
        }
        if($edit->referral_hospital_name!='')
        { 
          echo $edit->referral_hospital_name; 
        }
        if($edit->uname!='')
        { 
          echo $edit->uname; 
        }
        if($edit->aname!='')
        { 
          echo $edit->aname; 
        }
        if($edit->vname!='')
        { 
          echo $edit->vname; 
        }
        if(empty($edit->dname) && empty($edit->uname) && empty($edit->aname) && empty($edit->vname))
        { 
          echo $edit->new_value; 
        } 
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
  
      
