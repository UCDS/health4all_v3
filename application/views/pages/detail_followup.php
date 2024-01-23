<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.timeentry.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/moment.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/Chart.min.js"></script>
<link rel="stylesheet"  type="text/css" href="<?php echo base_url();?>assets/css/bootstrap_datetimepicker.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-barcode.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/selectize.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.selectize.js"></script>
<!-- <script type="text/javascript" src="<?php //echo base_url();?>assets/js/patient_followp_validations.js"></script> -->

<style>
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
	.mandatory{
	color:red;
	cursor:default;
	font-size:25px;
	font-weight:bold;
}

.error {
    color: red;
    margin-left: 5px;
  }
  
  label.error {
    display: inline;
  }

	.row{
		margin-bottom: 1.5em;
	}
	.alt{
		margin-bottom:0;
		padding:0.5em;
	}
	.alt:nth-child(odd){
		background:#eee;
	}
		.selectize-control.repositories .selectize-dropdown > div {
			border-bottom: 1px solid rgba(0,0,0,0.05);
		}
		.selectize-control.repositories .selectize-dropdown .by {
			font-size: 11px;
			opacity: 0.8;
		}
		.selectize-control.repositories .selectize-dropdown .by::before {
			content: 'by ';
		}
		.selectize-control.repositories .selectize-dropdown .name {
			font-weight: bold;
			margin-right: 5px;
		}
		.selectize-control.repositories .selectize-dropdown .title {
			display: block;
		}
		.selectize-control.repositories .selectize-dropdown .description {
			font-size: 12px;
			display: block;
			color: #a0a0a0;
			white-space: nowrap;
			width: 100%;
			text-overflow: ellipsis;
			overflow: hidden;
		}
		.selectize-control.repositories .selectize-dropdown .meta {
			list-style: none;
			margin: 0;
			padding: 0;
			font-size: 10px;
		}
		.selectize-control.repositories .selectize-dropdown .meta li {
			margin: 0;
			padding: 0;
			display: inline;
			margin-right: 10px;
		}
		.selectize-control.repositories .selectize-dropdown .meta li span {
			font-weight: bold;
		}
		.selectize-control.repositories::before {
			-moz-transition: opacity 0.2s;
			-webkit-transition: opacity 0.2s;
			transition: opacity 0.2s;
			content: ' ';
			z-index: 2;
			position: absolute;
			display: block;
			top: 12px;
			right: 34px;
			width: 16px;
			height: 16px;
			background: url(<?php echo base_url();?>assets/images/spinner.gif);
			background-size: 16px 16px;
			opacity: 0;
		}
		.selectize-control.repositories.loading::before {
			opacity: 0.4;
		}
		.selectize_district{
			display: inline-grid;
		}
		
		
	
</style>
<script>
$(document).ready(function() {
	onchange_primary_route_dropdown(document.getElementById("route_primary"));
	var route_secondary = "<?php echo $patient_followup->route_secondary_id; ?>";
	if(route_secondary != ""){
			$("#route_secondary").val(route_secondary);
	}
});
function onchange_primary_route_dropdown(dropdownobj) {       	
	const primaryRouteID = dropdownobj.value;
	populatePrimaryRouteID(primaryRouteID);		
}
	
function populatePrimaryRouteID(primaryRouteID) {
	var optionsHtml = getSecondaryRoute(primaryRouteID);
	$("#route_secondary").html(optionsHtml);		
}

function getSecondaryRoute(primaryRouteID) {
	var all_route_secondary = JSON.parse('<?php echo json_encode($route_secondary); ?>'); 
	var selected_route_secondary = all_route_secondary.filter(all_route_secondary => all_route_secondary.route_primary_id == primaryRouteID);
	let optionsHtml = buildEmptyOption("Select");
	if(selected_route_secondary.length > 0) {
		optionsHtml += selected_route_secondary.map(selected_route_secondary => {
				return `	<option value="${selected_route_secondary.id}">
						${selected_route_secondary.route_secondary}
					</option>`;
	   });
			
        }
	return optionsHtml;
}

function buildEmptyOption(optionName = "Select") {
	return `<option value="" selected>
					${optionName}
			</option>`;

}
		
	function onAddFollowUpSubmit(){
		$('#followup_add_details').submit();
	   }	

	function onUpdatePatientSubmit(){

		}
	</script>
				<script>
					$('form[id="followup_add_details"]').validate({
	                      
						
                       });
					$(function(){
						
					<?php if($patient_followup->status_date == 0){ ?>
					$('.status_date').datetimepicker({
						format : "D-MMM-YYYY h:ssA",
						defaultDate : false
					});
					<?php } ?>
					<?php if($patient_followup->status_date == 0){ ?>
					$('.last_visit_date').datetimepicker({
						format : "D-MMM-YYYY h:ssA",
						defaultDate : false
					});
					<?php } ?>

		
					});

	
				
$(document).ready(function(){
	

$('#icd_code').selectize({
valueField: 'icd_code',
labelField: 'code_title',
searchField: 'code_title',
create: false,
render: {
	option: function(item, escape) {

		return '<div>' +
			'<span class="title">' +
				'<span class="icd_code">' + escape(item.code_title) + '</span>' +
			'</span>' +
		'</div>';
	}
},
load: function(query, callback) {
	if (!query.length) return callback();
	$.ajax({
		url: '<?php echo base_url();?>register/search_icd_codes',
		type: 'POST',
		dataType : 'JSON',
		data : {query:query},
		error: function(res) {
			callback();
		},
		success: function(res) {
			callback(res.icd_codes.slice(0, 10));
		}
			});
			}
			});

		 });
      </script>
      

<?php
$patient = $patients[0];
?>

<?php if(isset($patients) && count($patients)>=1){ ?>
	<?php 
							foreach($functions as $f){
								if($f->user_function=="patient_follow_up") { }}?>	
	<div class="col-md-12">
	<div class="panel panel-default">
			<!-- <h4 align="center">Patient Follow-up</h4><br> -->
			<div class="panel-heading">
				<h4 style="color:blue">Patient Details</h4>
			</div>
	
		<div class="panel-body">
		<?php echo form_open('register/patient_follow_up',array('class'=>'form-custom','role'=>'form', 'id'=>'followup_add_details','onSubmit'=>'onAddFollowUpSubmit()')); ?>
			<input type="hidden" class="sr-only" value="<?php echo $transaction_id;?>" name="transaction_id" />
			<div class="row">
							<div class="col-md-3">
							<div class="form-group">
							<label class="control-label">Patient ID:</label>
							  <input type="text" name="patient_id" class="form-control" placeholder="" value="<?php echo $patient->patient_id; ?>" style="background: #ADFF2F; " readonly/>
                            </div>		
							</div>

							<div class="col-md-3">
						    <div class="form-group">
							<label class="control-label">Name: 	</label>
							<br><input type="text" name="patient_name" class="form-control" placeholder="" value="<?php echo $patient->first_name." ".$patient->last_name; ?>" <?php if($f->edit==1 && empty($patient->first_name." ".$patient->last_name)) echo ' required'; else echo ' readonly'; ?> style="background: #ADFF2F;" />
                            </div>
		                    </div>

						<div class="col-md-3">
						<div class="form-group">
						
							<label class="control-label">Age<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?></label>
							<table>
										<tr>
											<td><input type="text" name="age_years" class="form-control" style="background: #ADFF2F;" size="1"  value="<?php echo $patient->age_years; ?>"   readonly/><td>Y</td></td>
											<td><input type="text" name="age_months" class="form-control" style="background: #ADFF2F;" size="1"   value="<?php echo $patient->age_months; ?>"  readonly/><td>M</td></td>
											<td><input type="text" name="age_days" class="form-control" style="background: #ADFF2F;"size="1"   value="<?php echo $patient->age_days; ?>"  readonly/><td>D</td></td> 
										</tr>
							</table>
						</div>
						</div>	
						
						<div class="col-md-3">
						<div class="form-group">
						<label class="control-label">Gender: </label>
					
								<div class="col-md-12 col-xs-12" style="background: #ADFF2F; font-weight: bold;" >

								<?php if(!empty($patient->gender)) { ?> 
												
												<label> 
												<?php 
													if($patient->gender == 'M')
														echo "Male";
													else if($patient->gender == 'F')
														echo "Female";
													else 
														echo "Other";
												?>
												</label> 
												<?php } else { ?>
													
												<label class="control-label"><input type="radio" class="gender" value="M" name="gender" />Male</label>
												<label class="control-label"><input type="radio" class="gender" value="F" name="gender" />Female</label>
												<label class="control-label"><input type="radio" class="gender" value="O" name="gender" />Others</label>
												<?php } ?>
								</div>
						    </div>
		        		 </div>

			
			</div>		

			<div class="row">
					<div class="col-md-3">						
							<label class="control-label">Relative Name </label>
							<?php if (!empty($patient->father_name)) { ?>
								<input type="text" name="relative_name" class="form-control" placeholder="" value="<?php echo $patient->father_name; ?>"  style="background: #ADFF2F; " readonly/>
							<?php } elseif (!empty($patient->mother_name)) { ?>
								<input type="text" name="mother_name" class="form-control" placeholder="" value="<?php echo $patient->mother_name; ?>"  style="background: #ADFF2F; " readonly/>
							<?php } else { ?>
								<input type="text" name="spouse_name" class="form-control" placeholder="" value="<?php echo $patient->spouse_name; ?>"  style="background: #ADFF2F; " readonly/>
							<?php } ?>
					</div>	

					<div class="col-md-3">
					
						<label class="control-label">Address</span></label><br>
						<textarea name="address" class="form-control"  style="background: #ADFF2F; " readonly/><?php echo $patient->address; ?></textarea>
					
					</div>	

				<div class="col-md-3">
					<label class="control-label">District</label>
					<input type="text" name="district_patient" class="form-control" placeholder="" value="<?php echo $districts->district; ?>"  style="background: #ADFF2F;" readonly/>		
				</div>
			</div>

			<div class="row">			
				<div class="col-md-3">
				<div class="form-group">
					<label class="control-label">Phone</label><br>
					<input type="text" name="phone" class="form-control" value="<?php echo $patient->phone; ?>" style="background: #ADFF2F; " readonly/>
				</div>	
				</div>	

				
				<div class="col-md-3">
						<div class="form-group">
							<label for="inputstatus_date ">Registered On Date  </label>
							<input type="text" name="dob" class="form-control" value="<?php if($patient) echo date('d/m/Y',strtotime($patient->insert_datetime));?>" style="background: #ADFF2F; " readonly />
						</div>
				</div>
			</div>	
		</div>
							
	</div>
	</div>

	
	<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">
				<h4 style="color:blue">Patient Follow Up Details</h4>
		</div>
	
		<div class="panel-body">
			<input type="hidden" class="sr-only" value="<?php echo $transaction_id;?>" name="transaction_id" />
			<div class="row">
				
				<!-- newly commented on 12-01-2024 -->
				<!-- <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
				        <div class="form-group">
							<label for="inputstatus">Status Date <span class="mandatory" >*</span> </label><br> -->
							<!-- <input class="form-control"  type="date"  name="status_date" id="status_date" value=<?php if($patient_followup) echo $patient_followup->status_date;  ?>  required/> -->
							<!-- Commenting for improvment Jan 22 2024
								<input class="form-control"  type="hidden"  name="status_date" id="status_date" 
							value=<?php echo date("Y-m-d"); ?>  readonly/> -->
						<!-- </div>
				</div> -->
				<div class="col-xs-12 col-sm-12 col-md-6  col-lg-4">
							<div class="form-group">
								<label for="inputstatus ">Life Status <span class="mandatory" >*</span></label><br>
								
						
								&nbsp;&nbsp;  <input type="radio" name="life_status" id="life_status_live"  value="1" <?php if($patient_followup->life_status == "1")  echo "checked" ; ?> required >
								<label for="staus_alive">Alive</label>&nbsp;&nbsp;
								<input type="radio" name="life_status" id="life_status_notlive" <?php if($patient_followup->life_status == "0")  echo "checked" ; ?> value="0" required >
								<label for="status_dead">Not Alive</label>&nbsp;&nbsp;								
								<input type="radio" name="life_status" id="life_status_nofollowup" <?php if($patient_followup->life_status == "2")  echo "checked" ; ?> value="2" required >
								<label for="status_no_followup">No Followup</label><br>

							</div>
				</div>
			
				<div class="col-xs-12 col-sm-12 col-md-6  col-lg-4">
				<div class="form-group">
							<label class="Inputdistrict">  ICD Code    </label>
							<?php if(!empty($patient->icd_10)){?>
					<label><?php echo $patient->icd_10." ".$patient->code_title;?></label>
				 <?php } else {?>
					<select id="icd_code" class="repositories" placeholder="Search ICD codes" name="icd_code" >
					<?php if(!!$patient_followup->icd_code){ ?>
						<option value="<?php echo $patient_followup->icd_code;?>"><?php echo $patient_followup->icd_code." ".$patient_followup->code_title;?></option>
					<?php } ?>
					</select>
					<?php } ?>	
                </div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
					<div class="form-group">
							<label for="Inputdiagnosis">Diagnosis</label>
							<input class="form-control" name="diagnosis" id="inputdiagnosis" placeholder="Enter Diagnosis" type="TEXT" value="<?php if($patient_followup) echo $patient_followup->diagnosis;  ?>" align="middle">
					</div> 
				</div>

			</div>

			<div class="row">
						<!-- Commenting for Improvement Jan 22 2024
							<div class="col-md-4">
							<div class="form-group">
								<label class="control-label">Last Visit Type <span class="mandatory">*</span> </label>
								<select class="form-control" name="last_visit_type"   required>
									<option value="">Last Visit Type</option>  
                        			<option value="IP" <?php echo ($patient_followup->last_visit_type == 'IP') ? 'selected' : ''; ?> >IP</option> 
									<option value="OP" <?php echo ($patient_followup->last_visit_type == 'OP') ? 'selected' : ''; ?> >OP</option>   								
								</select>
							</div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="inputstatus_date ">Last Visit Date <span class="mandatory">*</span> </label>
								<input class="form-control"  type="date"  name="last_visit_date" id="last_visit_date" value=<?php if($patient_followup) echo $patient_followup->last_visit_date;  ?>  required />

							</div>
						</div> -->
			</div>	
			
			<div class="row">		
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label class="control-label">Priority Type </label>
								<select class="form-control" name="priority_type" >
									<option value="Select">Select</option>
									 <?php foreach($priority_types as $type){
									 echo "<option value='".$type->priority_type_id."'";
									 if($patient_followup->priority_type_id && $patient_followup->priority_type_id == $type->priority_type_id) echo " selected ";
				echo ">".$type->priority_type."</option>";
				}
									?> 
								</select>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label">Primary Route</label>
								<select class="form-control" id="route_primary" onchange='onchange_primary_route_dropdown(this)' name="route_primary" >
									<option value="Select">Select</option>
									
									<?php foreach($route_primary as $primary){
									 echo "<option value='".$primary->route_primary_id."'";
									 if($patient_followup->route_primary_id && $patient_followup->route_primary_id == $primary->route_primary_id) echo " selected ";
				echo ">".$primary->route_primary."</option>";
				}
									?>
								</select>
							</div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-6  col-lg-4">
							<div class="form-group">
								<label class="control-label">Secondary Route</label>
								<select class="form-control" name="route_secondary" id="route_secondary">
									<option value="Select">Select</option> 
								</select>							
							</div>
						</div>
			</div>

			<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label class="control-label">Volunteer </label>
								<select class="form-control" name="volunteer" >
									<option value="Select">Select</option>
										
									<?php foreach($volunteer as $volunt){
									 echo "<option value='".$volunt->staff_id."'";
									 if($patient_followup->volunteer_id && $patient_followup->volunteer_id == $volunt->staff_id) echo " selected ";
				echo ">".$volunt->first_name." ".$volunt->last_name."</option>";
				}
									?>
								</select>
							</div>
						</div>	

						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
						<div class="form-group">
								<label for="input_longitude">Longitude</label>
								<input class="form-control" name="input_longitude"  id="input_longitude"  placeholder="Enter Longitude"  type="number" step="any" value="<?php if($patient_followup) echo $patient_followup->longitude;  ?>" align="middle">
						</div> 
						</div>					
						
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
						<div class="form-group">
								<label for="input_map_link">Map link</label>
								<input class="form-control" name="input_map_link"  id="input_map_link"  placeholder="Enter Map link"  type="text" value="<?php if($patient_followup) echo $patient_followup->map_link;  ?>" align="middle">
						</div> 
						</div>
						
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
						<div class="form-group">
								<label for="input_latitude">Latitude</label>
								<input class="form-control" name="input_latitude"  id="input_latitude"  placeholder="Enter Latitude"  type="number" step="any" value="<?php if($patient_followup) echo $patient_followup->latitude;  ?>" align="middle">
						</div> 
						</div>
						
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
						<div class="form-group">
								<label for="Inputdiagnosis">Note</label>
								<textarea class="form-control" name="input_note"  id="input_note" rows="1" placeholder="Enter Note" value="<?php if($patient_followup) echo $patient_followup->note;  ?>"> <?php echo $patient_followup->note; ?> </textarea>
								<!-- Commented and changed to textarea for improvement
									<input class="form-control" name="input_note"  id="input_note"  placeholder="Enter Note"  type="textarea" value="<?php if($patient_followup) echo $patient_followup->note;  ?>" align="middle"> -->
						</div> 
						</div>

						<!-- Newly added 12-01-2024 (am)-->
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
						<div class="form-group">
							<label for="input_ndps">NDPS <span class="mandatory">*</span></label><br>
							<input type ="radio" name="ndps_status"  value="1" id="chkYes" > <label>Yes</label>
							<input type="radio" name="ndps_status"  value="0"  id="chkNo" > <label>No</label>
							<input type="hidden" name="edit_ndps" id="edit_ndps" value="<?php echo $patient_followup->ndps ?>" >
						</div> 
						</div>

						<script>
							$(document).ready(function(e) {
								var getValue= $("#edit_ndps").val();
								if(getValue==1)
								{
									$('#chkYes').prop('checked', true);
								}else{
									var def = $('#chkNo').prop('checked', true);
									var ndps = $('input[name="ndps_status"]:checked').val();
									if(ndps==0)
									{
										$("#dvPinNo").hide();
									}
								}
								$('input[name="ndps_status"]').on("click",function() {
									var ndps_status = $('input[name="ndps_status"]:checked').val();
									if(ndps_status==1)
									{
										$("#dvPinNo").show();
										$('input[name="drug"]').attr('required', true);
										$('input[name="dose"]').attr('required', true);
										$('input[name="last_dispensed_date"]').attr('required', true);
										$('input[name="last_dispensed_quantity"]').attr('required', true);
									}
									else{
										$("#dvPinNo").hide();
										$('input[name="drug"]').removeAttr('required');
										$('input[name="dose"]').removeAttr('required');
										$('input[name="last_dispensed_date"]').removeAttr('required');
										$('input[name="last_dispensed_quantity"]').removeAttr('required');
									}
								});
							});
						</script>
						<div id="dvPinNo">
						<div class="row container">
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
						<div class="form-group">
								<label for="input_longitude">Drug <span class="mandatory">*</span></label>
								<input class="form-control" name="drug"  id="drug" placeholder="Enter Drug" autocomplete="OFF" type="text" value="<?php if($patient_followup) echo $patient_followup->drug;  ?>" align="middle" >
						</div> 
						</div>

						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
						<div class="form-group">
								<label for="input_longitude">Dose <span class="mandatory">*</span> </label>
								<input class="form-control" name="dose"  id="dose"  placeholder="Enter Dose" autocomplete="OFF" type="text" value="<?php if($patient_followup) echo $patient_followup->dose;  ?>" align="middle" >
						</div> 
						</div>

						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
						<div class="form-group">
								<label for="input_longitude">Last Dispensary Date <span class="mandatory">*</span> </label>
								<input class="form-control" name="last_dispensed_date"  id="last_dispensed_date" autocomplete="OFF" placeholder="Enter Last Dispensary Date"  type="date" value="<?php if($patient_followup) echo $patient_followup->last_dispensed_date;  ?>" align="middle" >
						</div> 
						</div>

						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
						<div class="form-group">
								<label for="input_longitude">Last Dispensary Quantity <span class="mandatory">*</span></label>
								<input class="form-control" name="last_dispensed_quantity"  id="last_dispensed_quantity" autocomplete="OFF" placeholder="Enter Last Dispensary Quantity"  type="text" value="<?php if($patient_followup) echo $patient_followup->last_dispensed_quantity;  ?>" align="middle" >
						</div> 
						</div>
						</div>
						</div>

						<!-- till here (am)-->
			</div>	
		</div>    
            &emsp;&emsp;

			<div class="panel-footer">
			<div class="text-center">
				<?php if(isset($patient_followup)  && ($patient_followup->hospital_id == $hospital_id) ) { ?>
				<input class="btn btn-sm btn-primary" name="search_update_btn" type="submit" value="Update" />

				<?php } ?>
				<?php if(isset($patient->patient_id) && (!$patient_followup->patient_id)){ ?>
					<input class="btn btn-sm btn-primary" name="search_add" type="submit" value="Add For Followup" />

				<?php } ?>
			</div>								
			</div>
			</form>
		
				
		<?php }
		
		?>

	</div>
	</div>
