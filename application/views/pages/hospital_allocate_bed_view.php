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
		  $('.print').click(function(){
			$('#table-sort').trigger('printTable');
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
					if (confirm("Are you sure you want to discharge this patient?")) {
						$.ajax({
							type: "POST",
							url: "<?php echo base_url('hospital_beds/discharge_patient_allocated_bed'); ?>",
							data: { delete_id: delete_id },
							dataType: 'json',
							success: function(response) {
								alert("Patient Discharge Successful");
								location.reload();
							},
							error: function(error) {
								console.error("Error discharging patient:", error);
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
				console.log(result);
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
						details += '\n' + formattedDate;
					}
					$('#patient_details_' + bedIndex).val(details); 
					$('#patient_name_' + bedIndex).val(fullName + ' / ' + patientDetails.address);
					$('#address_store_' + bedIndex).val(patientDetails.address);
					$('#patient_name_store_' + bedIndex).val(fullName);
					$('#age_gender_' + bedIndex).val( patientDetails.age_years + ' / ' + patientDetails.gender);
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
		<div class="col-md-5" style="margin-top:10%">
			<h2 style="display: inline-block; margin-top: 8%;"><?php echo $title; ?></h2>&nbsp;&nbsp;&nbsp;
			<a href="#" id="hide-details-link" style="font-size:15px;"> 
				<span style="display: inline-block; float: right;margin-top: 11%;">Hide Patient Details</span>
			</a>
		</div>
		<script>
			document.addEventListener('DOMContentLoaded', function() {
				document.getElementById('hide-details-link').addEventListener('click', function(e) {
					e.preventDefault();
					toggleInputs();
				});

				function toggleInputs() {
					var inputs = document.querySelectorAll('input[type="text"].patient_name');
					inputs.forEach(function(input) {
						input.style.display = input.style.display === 'none' ? '' : 'none';
					});
					var thElements = document.querySelectorAll('th.patient_name');
						thElements.forEach(function(th) {
							th.style.display = th.style.display === 'none' ? '' : 'none';
						});

					var tdElements = document.querySelectorAll('td.patient_name');
						tdElements.forEach(function(td) {
							td.style.display = td.style.display === 'none' ? '' : 'none';
						});
					var linkText = document.querySelector('#hide-details-link span');
					if (linkText.textContent.trim() === 'Hide Patient Details') {
						linkText.textContent = 'Click to View Patient Details';
					} else {
						linkText.textContent = 'Hide Patient Details';
					}
				}
			});
		</script>
		<?php echo form_open('hospital_beds/patient_allocate_beds',array('class'=>'form-group','role'=>'form','id'=>'appointment')); ?> 
		<input type="hidden" name="page_no" id="page_no" value='<?php echo "$page_no"; ?>'>
		<div class="row" style="margin-top:2%;">
			<div class="col-md-12">
			<?php
				if (!empty($all_available_beds['available_beds'])) 
				{
					$count = count($all_available_beds['available_beds']);
					for ($j = 0; $j < $count; $j++) 
					{
						$abc = $all_available_beds['available_beds'][$j];
			?>
					<div class="col-md-4">
						<div class="form-group">
							<label for="inputhospital_name" style="color:red;font-weight:bold;"></label>
							<input type="hidden" name="bed_id_<?php echo $j; ?>" value="<?php echo $abc->hospital_bed_id; ?>"> <!-- Ensure proper index -->
							<input class="form-control" name="bed_name_<?php echo $j; ?>" id="inputbde_name_<?php echo $j; ?>" value="<?php echo $abc->bed ?>" type="text" readonly style="color:#437bba!important;font-size:18px!important;">
							<input type="text" class="form-control" name="patient_id_<?php echo $j; ?>" id="patient_id_<?php echo $j; ?>" value="" placeholder="Enter Patient Id" autocomplete="off" onkeyup="myKeyUp(this)">
							<input type="text" class="form-control patient_name" name="patient_name_<?php echo $j; ?>" id="patient_name_<?php echo $j; ?>" value=""  autocomplete="off" placeholder="Patient Name">
							<input type="hidden" class="form-control" name="patient_name_store_<?php echo $j; ?>" id="patient_name_store_<?php echo $j; ?>" value=""  autocomplete="off" >
							<input type="hidden" class="form-control" name="address_store_<?php echo $j; ?>" id="address_store_<?php echo $j; ?>" value=""  autocomplete="off">
							<input type="hidden" class="form-control" name="age_gender_<?php echo $j; ?>" id="age_gender_<?php echo $j; ?>" value=""  autocomplete="off">
							<textarea style="max-width:100%!important;" name="patient_details_<?php echo $j; ?>" class="form-control" id="patient_details_<?php echo $j; ?>" placeholder="Patient Details" rows="3" cols="12"></textarea>
							<textarea style="max-width:100%!important;" name="reserve_details_<?php echo $j; ?>" id="reserve_details_<?php echo $j; ?>" placeholder="Reservation Patient Details" class="form-control" rows="3" cols="12"></textarea>
							<div id="parameter_div" style="margin-top:2%!important;">
								<?php foreach ($all_bed_parameters as $aabp): ?>
									<div class="row " >
										<div class="col-md-5">
											<input type="text" class="form-control" name="bed_parameter_label_<?php echo $j; ?>[]" value="<?php echo $aabp->bed_parameter_label ?>" readonly autocomplete="off">
										</div>
										<div class="col-md-7" style="margin-left:-30px!important;width:67%!important;">
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
							<div class="row" style="margin-top:2%!important;">
								<div class="col-md-6">
									<input type="checkbox" name="update_bed_<?php echo $j; ?>" id="update_bed_<?php echo $j; ?>" onclick="submitFormAndReload()"> &nbsp;Update Bed <br/><br/>
								</div>
								<div class="col-md-6" style="text-align:right;">
									<input type="checkbox" name="reserve_id_<?php echo $j; ?>" id="reserve_id_<?php echo $j; ?>" value="" onclick="toggleReserveDetails(<?php echo $j; ?>)"> &nbsp;Reserve Bed <br/><br/>
								</div>
							</div>
						</div>
					</div>
			<?php } } else { ?>
				<h4 style="text-align:center;font-size:20px;"> No Beds Available to allocate </h4>
			<?php
			}
			?>
			<script>
				document.addEventListener("DOMContentLoaded", function() {
					var allAvailableBeds = <?php echo $count; ?>; // Use PHP count directly
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
					//var parameterDiv = document.getElementById('parameter_div'); 
					// if (reserveCheckbox.checked) {
					// 	reserveDetailsTextarea.style.display = 'block';
					// 	patientIdInput.style.display = 'none';
					// 	patientDetailsTextarea.style.display = 'none';
					// 	//parameterDiv.style.display = 'none'; // Hide parameter div
					// } else {
					// 	reserveDetailsTextarea.style.display = 'none';
					// 	patientIdInput.style.display = 'block';
					// 	patientDetailsTextarea.style.display = 'block';
					// 	//parameterDiv.style.display = 'block';
					// }
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
			<div class="row">
				<div class="col-md-12">
				<?php		
					if (!empty($all_available_beds['patient_beds'])) 
					{
						foreach ($all_available_beds['patient_beds'] as $aab) 
						{
				?>
						<div class="col-md-4">
							<div class="form-group">
								<input type="hidden" value="<?php echo $aab->hospital_bed_id; ?>" id="bed_no_id_<?php echo $aab->hospital_bed_id; ?>" data-id="<?php echo $aab->hospital_bed_id; ?>">
								<?php if($aab->reservation_details=='') { ?>
									<input type="text" name="" class="form-control bedNameInput" value="<?php echo $aab->bed; ?>" readonly style="font-size:18px;background-color:#5ce35c;color:black;">
									<input type="text" class="form-control patient_id" value="<?php echo $aab->patient_id; ?>" readonly>
									<input type="text" class="form-control patient_name" value="<?php echo $aab->patient_name .' / '.$aab->address ; ?>" readonly>
									<input type="hidden" class="form-control age_gender" value="<?php echo $aab->age_gender; ?>" readonly>
									<textarea name="" class="form-control patient_details" rows="3" cols="12" readonly><?php echo $aab->details; ?></textarea>
								<?php } else { ?>
									<input type="text" name="" class="form-control" value="<?php echo $aab->bed; ?>" 
										readonly style="font-size:18px;background-color:#ffa500a6;color:black;">
									<textarea name="" id="reserve_details" class="form-control" rows="3" cols="12" readonly><?php echo $aab->reservation_details; ?>
										</textarea>
									<?php } ?>
								<div class="bedDataContainer_<?php echo $aab->hospital_bed_id; ?>">
									<!-- Rows will be dynamically added here -->
								</div><br/>
								<input type="checkbox" data-id="<?php echo $aab->hospital_bed_id;?>" class="btn btn-warning discharge-checkbox" >&nbsp;&nbsp;<strong >Discharge Patient</strong>
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
											console.log(response);
											var container = $('.bedDataContainer_' + bedId);
											container.empty();
											$.each(response, function(index, item) {
												var html = '<div class="row">' +
															'<div class="col-md-5">' +
																'<input type="text" class="form-control bed-parameter-label" name="bed_parameter_label[]" value="' + item.bed_parameter_label + '" readonly>' +
															'</div>' +
															
															'<div class="col-md-7">' +
																'<input type="text" class="form-control bed-parameter-value" name="bed_parameter_value[]" value="' + item.bed_parameter_value + '" readonly>' +
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
								var bedId = $('#bed_no_id_<?php echo $aab->hospital_bed_id; ?>').data('id');
								fetchBedData(bedId);
							});
						</script>
				<?php   }  } ?>
				</div>
			</div>
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
	<h5>Data as on <?php echo date("j-M-Y h:i A"); ?></h5>
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
	
	<table class="table table-bordered table-striped" id="table-sort">
	<thead>
		<th style="text-align:center">S.no</th>
		<th style="text-align:center">Bed</th>
		<th style="text-align:center">Patient Id</th>
		<th style="text-align:center">Admit Date</th>
		<th style="text-align:center" class="patient_name">Name / Address</th>
		<th style="text-align:center">Age / Gender / Diagnosis</th>
		<th style="text-align:center">Parameters</th>
		<th style="text-align:center">Update Date / Time</th>
		<th style="text-align:center">Updated by</th>
		<!-- <th style="text-align:center">Actions</th>-->
	</thead>
	<tbody>
	<?php foreach ($all_beds as $sno => $bed): ?>
		<tr>
			<td style="text-align:center"><?php echo $bed['sno']; ?></td>
			<td><?php echo $bed['bed'] ?></td>
			<td><?php echo $bed['occupied'] ? ($bed['patient_details'] ? $bed['patient_details']['patient_id'] : '-') : ' - '; ?></td>
			<td><?php echo $bed['occupied'] ? $bed['patient_details']['admit_date'] : '-'; ?></td>
			<td class="patient_name"><?php echo $bed['occupied'] ? $bed['patient_details']['patient_name'] . ' / ' . $bed['patient_details']['address'] : '-'; ?></td>
			<td><?php echo $bed['occupied'] ? $bed['patient_details']['age_gender'] . ' / ' . $bed['patient_details']['diagnosis'] : '-'; ?></td>
			<td><?php echo $bed['occupied'] ?
						($bed['patient_details']['reservation_details'] ?: 
						(empty($bed['patient_details']['details']) ? '-' : implode(', ', $bed['patient_details']['parameters']))) : '-'; ?></td>
			<td><?php echo $bed['occupied'] ? $bed['patient_details']['created_date'] . ' ' . $bed['patient_details']['created_time'] : '-'; ?></td>
			<td><?php echo $bed['occupied'] ? $bed['patient_details']['updated_by'] : '-'; ?></td>
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
  
