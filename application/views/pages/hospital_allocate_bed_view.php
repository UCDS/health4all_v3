<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.chained.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript">
$(document).ready(function(){$("#from_date").datepicker({
		dateFormat:"dd-M-yy",changeYear:1,changeMonth:1,onSelect:function(sdt)
		{$("#to_date").datepicker({dateFormat:"dd-M-yy",changeYear:1,changeMonth:1})
		$("#to_date").datepicker("option","minDate",sdt)}})
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
			  // The zIndex of the stickyHeaders, allows the user to adjust this to their needs
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
			$('.hosp_name_id').hide();
		  $('.print').click(function(){
			$('.hosp_name_id').show();
			//$('#table-sort').trigger('printTable'); old changde for improvement 
			$('#table-sort').find('.tablesorter-filter-row').hide();
				var printContent = '<!DOCTYPE html>';
				printContent += '<html>';
				printContent += '<head>';
				printContent += '<title>Print</title>';
				printContent += '<style>';
				printContent += 'table { border-collapse: collapse; width: 95%; }';
				printContent += 'th, td { border: 1px solid #ddd; padding: 8px; }';
				printContent += 'th { background-color: #f2f2f2; }';
				printContent += '</style>';
				printContent += '</head>';
				printContent += '<body>';
				//printContent += document.getElementById("print-container");
				var printContainer = document.getElementById("print-container");
				var printContent = printContainer.innerHTML;
				printContent = '<div style="text-align: center;">' + printContent + '</div>';
				printContent = '<style>table { border-collapse: collapse; } table, th, td { border: 1px solid black; }</style>' + printContent;
				printContent += document.getElementById("table-sort").outerHTML;
				printContent += '</body>';
				printContent += '</html>';
				var printWindow = window.open('', '_blank', 'width=800,height=600');
				printWindow.document.write(printContent);
				printWindow.document.close();
				printWindow.print();
				window.onbeforeunload = function() {
					printWindow.close();
				};
				
				window.location.reload();
		  });
});

</script>
<script type="text/javascript">
$(document).ready(function(){
// find the input fields and apply the time select to them.
$('#from_time').ptTimeSelect();
$('#to_time').ptTimeSelect();
});
</script>
<script>
	$(document).ready(function() {
		$(document).on("change", ".discharge-checkbox", function() {
			if (this.checked) {
				var delete_id = $(this).data("id");
				if (delete_id !== '') {
					if (confirm("Are you sure want to clear this bed?")) {
						$.ajax({
							type: "POST",
							url: "<?php echo base_url('hospital_beds/discharge_patient_allocated_bed'); ?>",
							data: { delete_id: delete_id },
							dataType: 'json',
							success: function(response) {
								alert("Bed Clear Successful");
								location.reload();
							},
							error: function(error) {
								console.error("Error clearing bed:", error);
							}
						});
					} else {
						$(this).prop('checked', false);
					}
				}
			}
		});
	});

	function myKeyUp(inputElement) 
	{
		var inputValue = $(inputElement).val();
		var url = '<?php echo base_url("hospital_beds/fetch_patient_details"); ?>';
		var bedIndex = inputElement.id.split('_')[2]; // Extracting the index from input id
		$.ajax({
			url: url,
			type: 'POST',
			data: { patient_id: inputValue },
			success: function(result) {
				var data = JSON.parse(result);
				if (data.length > 0) {
					var patientDetails = data[0];
					var fullName = patientDetails.first_name + ' ' + patientDetails.last_name;
					var sdg = fullName + ', ' +
								patientDetails.age_years + ' / ' + patientDetails.gender  ;
					var details = '';
					if (patientDetails.age_years) {
						details +=  patientDetails.age_years + ' / ' + patientDetails.gender  ;
					}
					if (patientDetails.diagnosis) {
						details += '\n' + patientDetails.diagnosis;
					}
					if (patientDetails.max_admit_date) {
						var admitDate = new Date(patientDetails.max_admit_date);
            			var formattedDate = formatDate(admitDate);
						
						details += '\n' + 'Admit date : ' + formattedDate;
						//details += '\n' + '<b>' + 'Admit date' + '</b>' + ': ' + formattedDate;
					}
					if (patientDetails.diagnosis !== null && typeof formattedDate !== 'undefined') {
						$('#patient_details_' + bedIndex).val(patientDetails.diagnosis + '\n' + 'Admit date' + formattedDate);
					}
					//$('#patient_details_' + bedIndex).val(patientDetails.diagnosis + '\n' +'Admit Date : ' + formattedDate);
					$('#patient_details_store_' + bedIndex).val(details); 
					$('#patient_name_' + bedIndex).val(fullName + ' , ' + patientDetails.address);
					$('#address_store_' + bedIndex).val(patientDetails.address);
					$('#patient_name_store_' + bedIndex).val(fullName);
					$('#age_gender_' + bedIndex).val( patientDetails.age_years + ' / ' + patientDetails.gender);
					$('#age_gender_store_' + bedIndex).val( patientDetails.age_years + ' / ' + patientDetails.gender);
				}
			},
			error: function(xhr, status, error) {
				console.error(xhr.responseText);
			}
		});
	}
	function formatDate(date) {
		var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
		var day = date.getDate();
		var monthIndex = date.getMonth();
		var year = date.getFullYear();
		return day + ' ' + months[monthIndex] + ' ' + year;
	}
</script>

<script type="text/javascript">
function doPost(page_no){
	var page_no_hidden = document.getElementById("page_no");
  	page_no_hidden.value=page_no;
        $('#appointment').submit();
   }
function onchange_page_dropdown(dropdownobj){
   doPost(dropdownobj.value);    
}
</script>
<style>
	#footer { position: fixed; bottom: 0; width: 100%; } 
	.text-muted { margin-top:20px;text-align:center; } 
	.navbar  { position: fixed; top: 0; width: 100%; } 
	.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus{
		z-index:0!important;
	}
</style>
<style type="text/css">
.page_dropdown{
    position: relative;
    float: left;
    padding: 6px 12px;
    width: auto;
    height: 34px;
    line-height: 1.428571429;
    text-decoration: none;
    background-color: #ffffff;
    border: 1px solid #dddddd;
    margin-left: -1px;
    color: #428bca;
    border-bottom-right-radius: 4px;
    border-top-right-radius: 4px;
    display: inline;
}
.page_dropdown:hover{
    background-color: #eeeeee;
    color: #2a6496;
 }
.page_dropdown:focus{
    color: #2a6496;
    outline:0px;	
}
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
.rows_per_page{
    display: inline-block;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.428571429;
    color: #555555;
    vertical-align: middle;
    background-color: #ffffff;
    background-image: none;
    border: 1px solid #cccccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    -webkit-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
}
.rows_per_page:focus{
    border-color: #66afe9;
    outline: 0;	
}
</style>

<style type="text/css">
	.selectize-control.repositories .selectize-dropdown > div {
border-bottom: 1px solid rgba(0,0,0,0.05);
}
.selectize-control {
display: inline-grid;
} 
</style>

	<?php 
	
	$page_no = 1;	
	
	?>
		
	<div class="row col-md-offset-2">
		<div class="col-md-8" style="margin-top:10%">
			<h2 style="display: inline-block; margin-top: 4%;"><?php echo $title; ?></h2>&nbsp;&nbsp;&nbsp;
			<a href="#" id="hide-details-link" style="font-size: 15px;text-decoration:none!important;">
				<span id="icon-span">
					<i class="fa fa-user" aria-hidden="true" style="color:red!important"></i>
				</span>
				<span id="text-span" style="margin-top: 6%;">Hide Patient Details</span>
			</a>
			<h5>Data as on <?php echo date("j-M-Y h:i A"); ?></h5>
			<p><input type="checkbox" name="Enable Priority" id="enable_priority"> <b>Enable Priority</b></p>
		</div>
		<style>
			#text-span {
				display: none;
			}
			#hide-details-link:hover #text-span {
				display: inline-block;
			}
			#hide-details-link:hover #icon-span i {
				color: green!important;
			}
		</style>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				var link = document.getElementById('hide-details-link');
				var textSpan = document.getElementById('text-span');

				link.addEventListener('mouseenter', function() {
					textSpan.style.display = 'inline-block';
				});

				link.addEventListener('mouseleave', function() {
					textSpan.style.display = 'none';
				});

				link.addEventListener('click', function(e) {
					e.preventDefault();
					toggleInputs();
				});

				function toggleInputs() {
					var inputs = document.querySelectorAll('input[type="text"].patient_name, textarea.patient_name');
					var thElements = document.querySelectorAll('th.patient_name');
					var tdElements = document.querySelectorAll('td.patient_name');

					inputs.forEach(function(input) {
						input.style.display = input.style.display === 'none' ? '' : 'none';
					});

					thElements.forEach(function(th) {
						th.style.display = th.style.display === 'none' ? '' : 'none';
					});

					tdElements.forEach(function(td) {
						td.style.display = td.style.display === 'none' ? '' : 'none';
					});

					if (textSpan.textContent.trim() === 'Hide Patient Details') {
						textSpan.textContent = 'Click to View Patient Details';
						document.getElementById('icon-span').innerHTML = '<i class="fa fa-user" aria-hidden="true" style="color:green!important"></i>';
					} else {
						textSpan.textContent = 'Hide Patient Details';
						document.getElementById('icon-span').innerHTML = '<i class="fa fa-user" aria-hidden="true" style="color:red!important"></i>';
					}
				}
			});
		</script>
		<?php echo form_open('hospital_beds/patient_allocate_beds',array('class'=>'form-group','role'=>'form','id'=>'appointment')); ?> 
		<input type="hidden" name="page_no" id="page_no" value='<?php echo "$page_no"; ?>'>
		<div class="row" style="margin-top:2%;">
			<div class="col-md-12" >
			<?php
			if (!empty($all_available_beds['available_beds'])) {
				$count = count($all_available_beds['available_beds']);
				for ($j = 0; $j < $count; $j++) {
					$abc = $all_available_beds['available_beds'][$j];
					// Check if current bed is assigned to a patient
					$patient_assigned = false;
					$patient_details = null;
					foreach ($all_available_beds['patient_beds'] as $patient_bed) {
						if ($patient_bed->hospital_bed_id == $abc->hospital_bed_id) {
							$patient_assigned = true;
							$patient_details = $patient_bed;
							break;
						}
					}
					if ($patient_assigned && $patient_details) 
					{
						$lines = explode("\n", $patient_details->details);
						$output_lines = [];
						if (isset($lines[1])) {
							$output_lines[] = $lines[1];
						}
						if (isset($lines[2])) {
							$output_lines[] = $lines[2];
						}
						$patient_details->details = implode("\n", $output_lines);
					}
			?>
			<div class="col-md-4" 
				style="max-height:800px!important;overflow-y:auto;<?php if($patient_details->patient_name == '' && $patient_details->reservation_details!= '' ) echo 'margin-bottom:80px;'; ?>">
            <div class="form-group">
                <label for="inputhospital_name" style="color:red;font-weight:bold;"></label>
                <input type="hidden" name="bed_id_<?php echo $j; ?>" value="<?php echo $abc->hospital_bed_id; ?>">
				<input type="hidden" value="<?php echo $abc->hospital_bed_id; ?>" id="bed_no_id_<?php echo $abc->hospital_bed_id; ?>" data-id="<?php echo $abc->hospital_bed_id; ?>">
			    <?php if ($patient_assigned && $patient_details) { ?>
					<?php if ($patient_details->patient_name != '' && $patient_details->priority_type_id==$patient_details->followup_priority_type && $patient_details->color_code!='') { ?>
						<input type="text" name="" class="form-control bedNameInput_<?php echo $abc->hospital_bed_id; ?>" value="<?php echo $abc->bed; ?>" readonly style="font-size:18px; background-color:#43f243; ?>; color:black">
						<script>
							$(document).ready(function() {
								$('#enable_priority').change(function() {
									if ($(this).is(':checked')) {
										$('.bedNameInput_<?php echo $abc->hospital_bed_id; ?>').css('background-color', '<?php echo $patient_details->color_code; ?>');
									} else {
										$('.bedNameInput_<?php echo $abc->hospital_bed_id; ?>').css('background-color', '#43f243');
									}
								});
							});
						</script>
					<?php } if ($patient_details->patient_name == '' && $patient_details->reservation_details!= '' ) { ?>
						<input type="text" name="" class="form-control" value="<?php echo $abc->bed; ?>" readonly style="font-size:18px;background-color:#f59654;color:black;">
					<?php } if ($patient_details->patient_name != '' && ($patient_details->followup_priority_type=='0' || $patient_details->followup_priority_type==''))  { ?>
						<input type="text" name="" class="form-control bedNameInput" value="<?php echo $abc->bed; ?>" readonly style="font-size:18px;background-color:#43f243;color:black;">
					<?php }?>
					<div class="row">
						<div class="col-md-6">
							<input type="text" class="form-control" name="" id="patient_id_<?php echo $j; ?>" value="<?php if($patient_details->patient_id!=0) { echo $patient_details->patient_id; } ?>" autocomplete="off" readonly style="font-weight: bold;background-color:white!important;">
						</div>
						<div class="col-md-6 custom-responsive-margin">
							<input type="text" class="form-control" name="" id="age_gender_<?php echo $j; ?>" value="<?php echo $patient_details->age_gender; ?>" readonly style="font-weight: bold;background-color:white!important;">
						</div>
					</div>
					<textarea type="text" class="form-control patient_name" name="" id="patient_name_<?php echo $j; ?>" 
						value="" rows="2" cols="12" style="background-color:white!important;"
						autocomplete="off" readonly placeholder="Patient Details"><?php if($patient_details->patient_id!=0) { echo $patient_details->patient_name .' , '. $patient_details->address; } ?></textarea>
					<input type="hidden" class="form-control" name="" id="patient_name_store_<?php echo $j; ?>" value="<?php echo $patient_details->patient_name; ?>" autocomplete="off">
                    <input type="hidden" class="form-control" name="" id="address_store_<?php echo $j; ?>" value="<?php echo $patient_details->address; ?>" autocomplete="off">
                    <input type="hidden" class="form-control" name="" id="age_gender_<?php echo $j; ?>" value="<?php echo $patient_details->age_gender; ?>" autocomplete="off">
					<?php if ($patient_details->patient_name != '') { ?>
						<textarea style="max-width:100%!important;background-color:white!important;font-weight:bold;" name="" class="form-control" id="patient_details_<?php echo $j; ?>" placeholder="Patient Details" rows="2" cols="12" readonly><?php echo $patient_details->details; ?></textarea>
                    <?php } else if ($patient_details->patient_name == '') { ?>
						<textarea style="max-width:100%!important;background-color:white!important;" name="" class="form-control" id="" placeholder="Patient Diagnosis & Admit Date" rows="2" cols="12" readonly ></textarea>
					<?php } ?>
					<div class="bedDataContainer_<?php echo $abc->hospital_bed_id; ?>">
						<!-- Rows will be dynamically added here -->
					</div>
					<?php if ($patient_details->patient_name != '') { ?>
						<textarea style="max-width:100%!important;background-color:white!important;" name="" id="" placeholder="Reservation Details" class="form-control" rows="2" cols="12" readonly></textarea>
                    <?php } else if ($patient_details->patient_name == '') { ?>
						<textarea style="max-width:100%!important;background-color:white!important;" name="" id="reserve_details_<?php echo $j; ?>" placeholder="Reservation Patient Details" class="form-control" rows="2" cols="12" readonly ><?php echo $patient_details->reservation_details; ?></textarea>
					<?php } ?>
					<div class="row" style="margin-top:12%!important;">
						<div class="col-md-6">
							<input type="checkbox" data-id="<?php echo $abc->hospital_bed_id;?>" class="btn btn-warning discharge-checkbox" style="margin-top:-2%!important;">&nbsp;&nbsp;<strong >Clear Bed</strong>
						</div>
						<div class="col-md-5" style="text-align:right;">
							<a href="#" class="btn btn-danger" data-param-id="<?php echo $abc->hospital_bed_id;?>" id="edit_parameter_id_<?php echo $abc->hospital_bed_id;?>" style="text-decoration:none;color:white;">Edit Parameters</a>
						</div>
					</div>
					<div class="modal fade" id="yourModal" tabindex="-1" role="dialog" aria-labelledby="yourModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="yourModalLabel">Edit Bed Parameters</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-21px!important;">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-details" id="modal-details">
									
								</div>
								<div class="modal-param-bed-id" id="modal-param-bed-id">
									
								</div>
								<div class="modal-body" id="modal-body">
									
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="button" class="btn btn-primary" id="updateParametersBtn">Update</button>
								</div>
							</div>
						</div>
					</div>

					<script>
							$(document).ready(function() {
								function fetchBedData(bedId) {
									$.ajax({
										url: '<?php echo base_url("hospital_beds/get_bed_parameters_data"); ?>',
										method: 'post',
										dataType: 'json',
										data: {bedId: bedId},
										success: function(response) {
											var container = $('.bedDataContainer_' + bedId);
											container.empty();
											$.each(response, function(index, item) {
												var html = '<div class="row" >' +
															'<div class="col-md-5">' +
																'<input type="text" style="font-weight: bold;background-color:white!important;" class="form-control bed-parameter-label" name="bed_parameter_label[]" value="' + item.bed_parameter_label + '" readonly>' +
															'</div>' +
															
															'<div class="col-md-7 custom-margin" >' +
																'<input type="text" style="background-color:white!important;" class="form-control bed-parameter-value" name="bed_parameter_value[]" value="' + item.bed_parameter_value + '" readonly>' +
															'</div>' +
														'</div>';
												container.append(html);
											});
										},
										error: function(xhr, status, error) {
											console.error(xhr.responseText);
										}
									});
								}
								var bedId = $('#bed_no_id_<?php echo $abc->hospital_bed_id; ?>').data('id');
								fetchBedData(bedId);
								$('#edit_parameter_id_<?php echo $abc->hospital_bed_id;?>').on('click', function(e) 
								{
									$('#yourModal').modal({
										backdrop: 'static',  
										keyboard: false 
									});
									e.preventDefault();
									if (confirm("Are you sure you want to edit?")) 
									{
										var bed_id = $(this).data('param-id');
										$.ajax({
											type: 'POST',
											url: '<?php echo base_url('hospital_beds/get_bed_params_edit'); ?>',
											data: { bed_id: bed_id },
											dataType: 'json',
											success: function(response) {
												//console.log(response);
												if (response.length > 0) 
												{
													$('#modal-details').empty();
													patient = response[0];
													var patientLabel = '<p style="margin-left:25px;margin-top:5px;">' +
														'<span style="font-weight:bold;">Patient Details:</span> ' + patient.patient_id + ' , ' +
														patient.patient_name + ', ' + patient.age_gender +
														'</p>';
           											$('#modal-details').append(patientLabel);
													
													$('#modal-param-bed-id').empty();
													var bedIdInput  = '<input type="hidden" name="edit_param_bed_id" value="'+ bed_id +'">'
													$('#modal-param-bed-id').append(bedIdInput);

													$('#modal-body').empty();
													$.each(response, function(index, item) {
														var html = '<div class="row mb-3">';
														html += '<div class="col-md-5">';
														html += '<input type="text" class="form-control bed-parameter-edit-label" autocomplete="off" name="bed_parameter_label" value="' + item.bed_parameter_label + '" readonly>';
														html += '</div>';
														html += '<div>';
														html += '<input type="hidden" class="form-control bed-parameter-edit-id" name="bed_parameter_id" value="' + item.id + '" readonly>';
														html += '</div>';
														html += '<div class="col-md-7" style="margin-left:-30px!important;">';
														html += '<input type="text" class="form-control bed-parameter-edit-value" autocomplete="off" name="bed_parameter_value" value="' + item.bed_parameter_value + '">';
														html += '</div>';
														html += '</div>';
														$('#modal-body').append(html);
													});
													$('#yourModal').modal('show');
												} else {
													console.log('No parameters found');
												}
											},
											error: function(xhr, status, error) {
												console.error('Ajax request failed');
											}
										});
									}else {
										 $('#yourModal').modal('hide');
										 alert('edit cancelled');
										 location.reload();
									}
								});

								$('#updateParametersBtn').on('click', function() 
								{
									var bed_id = $('#modal-param-bed-id').find('input[name="edit_param_bed_id"]').val(); // Change here
									var updatedParameters = [];
									$('.bed-parameter-edit-value').each(function(index, element) {
										var parameterValue = $(element).val();
										var parameterId = $(element).closest('.row').find('.bed-parameter-edit-id').val();
										updatedParameters.push({
											bed_parameter_id:	parameterId,
											bed_parameter_value: parameterValue,
										});
									});
									$.ajax({
										type: 'POST',
										url: '<?php echo base_url('hospital_beds/update_edited_bed_params'); ?>',
										data: { parameters: updatedParameters, bed_id: bed_id },
										dataType: 'json',
										success: function(response) {
											//console.log(response);
											location.reload();
										},
										error: function(xhr, status, error) {
											console.error('Ajax request failed');
										}
									});
								});
								
							});
						</script>
				<?php } else { ?>
					<input class="form-control" name="bed_name_<?php echo $j; ?>" id="inputbde_name_<?php echo $j; ?>" value="<?php echo $abc->bed ?>" type="text" readonly style="color:#437bba!important;font-size:18px!important;">
                    <style>
						.custom-responsive-margin {
							margin-left: -30px !important;
							width: 59% !important;
						}


						@media (max-width: 1200px) {
							.custom-responsive-margin {
								width: 75% !important; /* Adjust as needed */
							}
						}

						@media (max-width: 992px) {
							.custom-responsive-margin {
								width: 80% !important; /* Adjust as needed */
							}
						}

						@media (max-width: 768px) {
							.custom-responsive-margin {
								margin-left: 0 !important;
								width: 100% !important;
							}
						}

						@media (max-width: 576px) {
							.custom-responsive-margin {
								margin-left: 0 !important;
								width: 100% !important;
							}
						}
					</style>
					<div class="row">
						<div class="col-md-6">
								<input type="text" class="form-control" name="patient_id_<?php echo $j; ?>" id="patient_id_<?php echo $j; ?>" value="" placeholder="Enter Patient Id" autocomplete="off" onkeyup="myKeyUp(this)">
						</div>
						<div class="col-md-6 custom-responsive-margin" >
							<input type="text" class="form-control" name="" id="age_gender_<?php echo $j; ?>" value="">
						</div>
					</div>
					<input type="text" class="form-control patient_name" name="patient_name_<?php echo $j; ?>" id="patient_name_<?php echo $j; ?>" value="" autocomplete="off" placeholder="Patient Name" style="height:55px!important;">
                    <input type="hidden" class="form-control" name="patient_name_store_<?php echo $j; ?>" id="patient_name_store_<?php echo $j; ?>" value="" autocomplete="off">
                    <input type="hidden" class="form-control" name="address_store_<?php echo $j; ?>" id="address_store_<?php echo $j; ?>" value="" autocomplete="off">
                    <input type="hidden" class="form-control" name="age_gender_store_<?php echo $j; ?>" id="age_gender_store_<?php echo $j; ?>" value="" autocomplete="off">
                    <textarea style="max-width:100%!important;" name="" class="form-control" id="patient_details_<?php echo $j; ?>" placeholder="Patient Details" rows="2" cols="12"></textarea>
                    <textarea style="max-width:100%!important;display:none!important;" name="patient_details_store_<?php echo $j; ?>" class="form-control" id="patient_details_store_<?php echo $j; ?>" placeholder="Patient Details" rows="3" cols="12"></textarea>
					<div id="parameter_div" >
						<?php foreach ($all_bed_parameters as $aabp): ?>
							<div class="row">
								<div class="col-md-5">
									<input type="text" class="form-control" name="bed_parameter_label_<?php echo $j; ?>[]" value="<?php echo $aabp->bed_parameter_label ?>" readonly autocomplete="off">
								</div>
								<style>
									.custom-margin {
									margin-left: -30px !important;
									width: 67% !important;
								}
								@media (max-width: 1200px) {
									.custom-margin {
										width: 75% !important;
									}
								}
								@media (max-width: 992px) {
									.custom-margin {
										width: 80% !important;
									}
								}
								@media (max-width: 768px) {
									.custom-margin {
										margin-left: 0 !important;
										width: 100% !important;
									}
								}
								@media (max-width: 576px) {
									.custom-margin {
										margin-left: 0 !important;
										width: 100% !important;
									}
								}
								</style>
								<div class="col-md-7 custom-margin" >
									<?php if ($edit_access == 1): ?>
										<input type="text" class="form-control" name="bed_parameter_<?php echo $j; ?>[]" value="<?php echo $aabp->bed_parameter; ?>" autocomplete="off">
									<?php else: ?>
										<input type="text" class="form-control" name="bed_parameter_<?php echo $j; ?>[]" value="<?php echo $aabp->bed_parameter; ?>" readonly autocomplete="off">
									<?php endif; ?>
									<input type="hidden" class="form-control" style="text-align:center" name="hospital_bed_parameter_id_<?php echo $j; ?>[]" value="<?php echo $aabp->hospital_bed_parameter_id; ?>" readonly>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
					<textarea style="max-width:100%!important;" name="reserve_details_<?php echo $j; ?>" id="reserve_details_<?php echo $j; ?>" placeholder="Reservation Patient Details" class="form-control" rows="2" cols="12" disabled></textarea>
					<div class="row" style="margin-top:12%!important;">
						<div class="col-md-6">
							<input type="checkbox" name="reserve_id_<?php echo $j; ?>" id="reserve_id_<?php echo $j; ?>" value="" onclick="toggleReserveDetails(<?php echo $j; ?>)"> &nbsp;Reserve Bed <br/><br/>
						</div>
						<div class="col-md-6" style="text-align:right;">
							<button type="button" class="btn btn-success" id="update_bed_<?php echo $j; ?>" onclick="submitFormAndReload()">Update Bed</button>
						</div>
					</div>
					<script>
						document.addEventListener("DOMContentLoaded", function() {
							var allAvailableBeds = <?php echo count($all_available_beds['available_beds']); ?> // Use PHP count directly
							for (var i = 0; i < allAvailableBeds; i++) {
								toggleReserveDetails(i); // Initialize the toggle state
							}
						});
						function toggleReserveDetails(index) {
							var reserveCheckbox = document.getElementById('reserve_id_' + index);
							var reserveDetailsTextarea = document.getElementById('reserve_details_' + index);
							var patientIdInput = document.getElementById('patient_id_' + index);
							var patientDetailsTextarea = document.getElementById('patient_details_' + index);
							var patientNameInput = document.getElementById('patient_name_' + index);
							var ageGenderInput = document.getElementById('age_gender_' + index);
							if (reserveCheckbox.checked) {
								reserveDetailsTextarea.disabled = false;
								patientIdInput.disabled = true;
								patientDetailsTextarea.disabled = true;
								patientNameInput.disabled = true;
								ageGenderInput.disabled = true;
							} else {
								reserveDetailsTextarea.disabled = true;
								patientIdInput.disabled = false;
								patientDetailsTextarea.disabled = false;
								patientNameInput.disabled = false; 
								ageGenderInput.disabled = false; 
							}
						}
					</script>
				<?php } ?>
            </div>
        </div>
			<?php
				}
			} else {
			?>
				<h4 style="text-align:center;font-size:20px;"> No Beds Available to allocate </h4>
			<?php
			}
			?>
			
			<?php 
				 	$user=$this->session->userdata('logged_in'); 
					$user['user_id'];
			?>
			<input type="hidden" name="total_beds" value="<?php echo $count; ?>">
			<input type="hidden" class="form-control" name="updated_by" value="<?php echo $user['staff_id'] ?>">
			</div>
				<input type="hidden" class="rows_per_page form-custom form-control" name="rows_per_page" id="rows_per_page" min=<?php echo $lower_rowsperpage; ?> max= <?php echo $upper_rowsperpage; ?> step="1" value= <?php if($this->input->post('rows_per_page')) { echo $this->input->post('rows_per_page'); }else{echo $rowsperpage;}  ?> onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" /> 
			    <input type="hidden" name="record_id" value="<?php echo $edit_bed['hospital_bed_id']; ?>" >
				<!-- <input class="btn btn-md btn-primary col-md-offset-5" type="submit" value="Submit" style="margin-top:2%;"> -->
			</div>
		</form>
		<script>
			function submitFormAndReload(index) {
				var form = document.getElementById('appointment');
				var formData = new FormData(form);
				$.ajax({
					type: 'POST',
					url: form.action,
					data: formData,
					processData: false,
					contentType: false,
					success: function(response) {
						window.location.reload();
					},
					error: function(xhr, status, error) {
						console.error(error);
					}
				});
			}
		</script>
		<?php if (!empty($error) || $error!=0): ?>
			<span style="color: red;"><?php echo $error; ?></span>
		<?php elseif (isset($success)): ?>
			<span style="color: green;"><?php echo $success; ?></span>
		<?php endif; ?>
	<br /><br />


<?php if(isset($all_allocated_beds) && count($all_allocated_beds)>0)
{ ?>
<a href="#" id="toggleTable" style="font-size:15px;"> Click here to hide table</a>
<script>
    // JavaScript to toggle visibility and change link text
    document.addEventListener('DOMContentLoaded', function() {
        var toggleLink = document.getElementById('toggleTable');
        var tableContainer = document.getElementById('tableContainer');
		
        // Initial state
        var tableVisible = true;
        toggleLink.addEventListener('click', function(e) {
            e.preventDefault();
            if (tableVisible) {
                tableContainer.style.display = 'none';
                toggleLink.textContent = 'Click here to display data in table';
                tableVisible = false;
            } else {
                tableContainer.style.display = 'block';
                toggleLink.textContent = 'Click here to hide table';
                tableVisible = true;
            }
        });
    });
</script>
<div id="tableContainer">
<div style='padding: 0px 2px;'> 
	<h3>List Allocated Beds</h3>
		<?php  echo form_open('hospital_areas/patient_allocate_beds',array('role'=>'form','class'=>'form-custom','id'=>'appointment')); ?>
				Rows per page : <input type="number" class="rows_per_page form-custom form-control" name="rows_per_page" id="rows_per_page" min=<?php echo $lower_rowsperpage; ?> max= <?php echo $upper_rowsperpage; ?> step="1" value= <?php if($this->input->post('rows_per_page')) { echo $this->input->post('rows_per_page'); }else{echo $rowsperpage;}  ?> onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" /> 
		<input type="submit" value="Search" name="submitBtn" class="btn btn-primary btn-sm" /> 
		</form><br/>
	<!-- <h5>Data as on <?php echo date("j-M-Y h:i A"); ?></h5> -->
</div>
<?php 
	if ($this->input->post('rows_per_page')){
		$total_records_per_page = $this->input->post('rows_per_page');
	}else{
		$total_records_per_page = $rowsperpage;
	}
	if ($this->input->post('page_no')) { 
		$page_no = $this->input->post('page_no');
	}
	else{
		$page_no = 1;
	}
	$total_records = $all_allocated_beds_count[0]->count ;
	$total_no_of_pages = ceil($total_records / $total_records_per_page);
	if ($total_no_of_pages == 0)
		$total_no_of_pages = 1;
	$second_last = $total_no_of_pages - 1; 
	$offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2";	
?>

<ul class="pagination" style="margin:0">
<?php if($page_no > 1){
echo "<li><a href=# onclick=doPost(1)>First Page</a></li>";
} ?>
    
<li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
<a <?php if($page_no > 1){
echo "href=# onclick=doPost($previous_page)";

} ?>>Previous</a>
</li>
<?php
  if ($total_no_of_pages <= 10){   
	for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
	if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	        }else{
        echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
                }
        }
}
else if ($total_no_of_pages > 10){
	if($page_no <= 4) {			
 		for ($counter = 1; $counter < 8; $counter++){		 
		if ($counter == $page_no) {
	   		echo "<li class='active'><a>$counter</a></li>";	
		}else{
           		echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
                }
}

echo "<li><a>...</a></li>";
echo "<li><a href=# onclick=doPost($second_last)>$second_last</a></li>";
echo "<li><a href=# onclick=doPost($total_no_of_pages)>$total_no_of_pages</a></li>";
}
elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
echo "<li><a href=# onclick=doPost(1)>1</a></li>";
echo "<li><a href=# onclick=doPost(2)>2</a></li>";
echo "<li><a>...</a></li>";
for (
     $counter = $page_no - $adjacents;
     $counter <= $page_no + $adjacents;
     $counter++
     ) {		
     if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	}else{
        echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
          }                  
       }
echo "<li><a>...</a></li>";
echo "<li><a href=# onclick=doPost($counter) >$counter</a></li>";
echo "<li><a href=# onclick=doPost($total_no_of_pages)>$total_no_of_pages</a></li>";
}
else {
echo "<li><a href=# onclick=doPost(1)>1</a></li>";
echo "<li><a href=# onclick=doPost(2)>2</a></li>";
echo "<li><a>...</a></li>";
for (
     $counter = $total_no_of_pages - 6;
     $counter <= $total_no_of_pages;
     $counter++
     ) {
     if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	}else{
        echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
	}                   
     }
}
}  
?>
<li <?php if($page_no >= $total_no_of_pages){
echo "class='disabled'";
} ?>>
<a <?php if($page_no < $total_no_of_pages) {
echo "href=# onclick=doPost($next_page)";
} ?>>Next</a>
</li>

<?php if($page_no < $total_no_of_pages){
echo "<li><a href=# onclick=doPost($total_no_of_pages)>Last Page</a></li>";
} ?>
<?php if($total_no_of_pages > 0){
echo "<li><select class='page_dropdown' onchange='onchange_page_dropdown(this)'>";
for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                  echo "<option value=$counter ";
                  if ($page_no == $counter){
                   echo "selected";
                  }         
                  echo ">$counter</option>";
	}
echo "</select></li>";
} ?>
</ul>


<div style='padding: 0px 2px;'>
	<h5>Page <?php echo $page_no." of ".$total_no_of_pages." (Total ".$total_records.")" ; ?></h5>
</div>

	<div class="container-fluid">	
		<!-- PDF & Excel Button -->
		<div style='padding: 0px 2px;' id="print-container">
			<h5 class="hosp_name_id" style="margin-bottom:0px!important;"><?php $hospital=$this->session->userdata('hospital'); echo $hospital['hospital']; ?>
            <h5 style="margin-top:0px!important;">Report as on <?php echo date("j-M-Y h:i A"); ?></h5>
        </div>
		<button type="button" class="btn btn-default btn-md print">
			<span class="glyphicon glyphicon-print"></span> Print
		</button>
			<!--created button which converts html table to Excel sheet-->
		<!-- <a href="#" id="test" onClick="javascript:fnExcelReport();">
			<button type="button" class="btn btn-default btn-md excel">
					<i class="fa fa-file-excel-o"ara-hidden="true"></i> Export to excel
			</button>
		</a> -->
	</div>

	<table class="table table-bordered table-striped" id="table-sort">
	<thead>
		<th style="text-align:center">S.no</th>
		<th style="text-align:center">Bed</th>
		<th style="text-align:center">Patient Id</th>
		<th style="text-align:center;width:9%;">Admit Date</th>
		<th style="text-align:center" class="patient_name">Name / Address</th>
		<th style="text-align:center;">Age / Gender / Diagnosis</th>
		<th style="text-align:center;width:19%;">Parameters</th>
		<th style="text-align:center;width:11%;">Update Date</th>
		<th style="text-align:center">Updated by</th>
		<!-- <th style="text-align:center">Actions</th>-->
	</thead>
	<tbody>
	<?php $i = 1; ?>
	<?php foreach ($all_beds['available_beds'] as $bed): ?>
		<tr>
			<td style="text-align:center;"><?php echo $i++; ?></td>
			<td><?php echo $bed->bed; ?></td>
			<?php
			$patient_found = false;
			foreach ($all_beds['patient_beds'] as $patient_bed) 
			{ 
				$details_lines = explode("\n", $patient_bed->details);
				$diagnosis = isset($details_lines[1]) ? trim($details_lines[1]) : '';
				$admit_date = isset($details_lines[2]) ? trim(substr($details_lines[2], strpos($details_lines[2], ':') + 1)) : ' - ';
				if ($patient_bed->hospital_bed_id == $bed->hospital_bed_id) {
					$patient_found = true;
					echo '<td>' . ($patient_bed->patient_id != 0 ? $patient_bed->patient_id : '-') . '</td>';
					echo '<td>' . $admit_date . '</td>';
					echo '<td class="patient_name"><b>';
						if (!empty($patient_bed->patient_name)) {
							echo $patient_bed->patient_name;
						} 
						echo '</b>';
						if (!empty($patient_bed->patient_name) && !empty($patient_bed->address)) {
							echo ' , ';
						}
						if (empty($patient_bed->patient_name) && empty($patient_bed->address)) {
							echo ' - ';
						}
						if (!empty($patient_bed->address)) {
							echo $patient_bed->address;
						} 
					echo '</td>';
					echo '<td>';
						if (!empty($patient_bed->age_gender) && !empty($diagnosis)) {
							echo '<b>'.$patient_bed->age_gender . ' / ' . $diagnosis.'</b>';
						} elseif (!empty($patient_bed->age_gender)) {
							echo '<b>'.$patient_bed->age_gender.'</b>';
						} elseif (!empty($diagnosis)) {
							echo '<b>'.$diagnosis.'</b>';
						} else {
							echo '-';
						}
					echo '</td>';
					$matched_parameters = array_filter($all_beds['bed_parameters'], function($param) use ($bed) {
						return $param->hospital_bed_id == $bed->hospital_bed_id;
					});
					
					if (!empty($matched_parameters) && empty($patient_bed->reservation_details)) {
						echo '<td>';
						foreach ($matched_parameters as $param) {
							echo '<b>'.$param->bed_parameter_label.'</b>'. ' : ' . $param->bed_parameter_value . '<br>';
						}
						echo '</td>';
					} else {
						echo '<td>'. $patient_bed->reservation_details .'</td>';
					}
					echo '<td>' . date("j M Y ", strtotime("$patient_bed->created_date")). date("h:i A.", strtotime("$patient_bed->created_time")) . '</td>';
					echo '<td>' . $patient_bed->updated_by_name . '</td>';
					break;
				}
			}
			if (!$patient_found) {
				echo '<td> - </td>';
				echo '<td> - </td>';
				echo '<td> - </td>';
				echo '<td> - </td>';
				echo '<td> - </td>';
				echo '<td> - </td>';
				echo '<td> - </td>';
			}
			?>
		</tr>
        <?php endforeach; ?>
	</tbody>
	</table>
<div style='padding: 0px 2px;'>

<h5>Page <?php echo $page_no." of ".$total_no_of_pages." (Total ".$total_records.")" ; ?></h5>

</div>

<ul class="pagination" style="margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 20px;
    margin-left: 0px;">
<?php if($page_no > 1){
echo "<li><a href=# onclick=doPost(1)>First Page</a></li>";
} ?>
    
<li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
<a <?php if($page_no > 1){
echo "href=# onclick=doPost($previous_page)";

} ?>>Previous</a>
</li>
<?php
  if ($total_no_of_pages <= 10){  	 
	for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
	if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	        }else{
        echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
                }
        }
}
else if ($total_no_of_pages > 10){
	if($page_no <= 4) {			
 		for ($counter = 1; $counter < 8; $counter++){		 
		if ($counter == $page_no) {
	   		echo "<li class='active'><a>$counter</a></li>";	
		}else{
           		echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
                }
}

echo "<li><a>...</a></li>";
echo "<li><a href=# onclick=doPost($second_last)>$second_last</a></li>";
echo "<li><a href=# onclick=doPost($total_no_of_pages)>$total_no_of_pages</a></li>";
}
elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
echo "<li><a href=# onclick=doPost(1)>1</a></li>";
echo "<li><a href=# onclick=doPost(2)>2</a></li>";
echo "<li><a>...</a></li>";
for (
     $counter = $page_no - $adjacents;
     $counter <= $page_no + $adjacents;
     $counter++
     ) {		
     if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	}else{
        echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
          }                  
       }
echo "<li><a>...</a></li>";
echo "<li><a href=# onclick=doPost($counter) >$counter</a></li>";
echo "<li><a href=# onclick=doPost($total_no_of_pages)>$total_no_of_pages</a></li>";
}
else {
echo "<li><a href=# onclick=doPost(1)>1</a></li>";
echo "<li><a href=# onclick=doPost(2)>2</a></li>";
echo "<li><a>...</a></li>";
for (
     $counter = $total_no_of_pages - 6;
     $counter <= $total_no_of_pages;
     $counter++
     ) {
     if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	}else{
        echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
	}                   
     }
}
}  
?>
<li <?php if($page_no >= $total_no_of_pages){
echo "class='disabled'";
} ?>>
<a <?php if($page_no < $total_no_of_pages) {
echo "href=# onclick=doPost($next_page)";
} ?>>Next</a>
</li>

<?php if($page_no < $total_no_of_pages){
echo "<li><a href=# onclick=doPost($total_no_of_pages)>Last Page</a></li>";
} ?>
<?php if($total_no_of_pages > 0){
echo "<li><select class='page_dropdown' onchange='onchange_page_dropdown(this)'>";
for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                  echo "<option value=$counter ";
                  if ($page_no == $counter){
                   echo "selected";
                  }         
                  echo ">$counter</option>";
	}
echo "</select></li>";
} ?>
</ul>
	<?php }  ?>
	
</div>	
</div>
  
