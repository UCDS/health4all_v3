<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.timeentry.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/moment.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
<!-- < <script type="text/javascript" src="<?php echo base_url();?>assets/js/viewer.min.js"></script> -->
<!-- <script type="text/javascript" src="<?php echo base_url();?>assets/js/patient_field_validations.js"></script> -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/Chart.min.js"></script>
<link rel="stylesheet"  type="text/css" href="<?php echo base_url();?>assets/css/bootstrap_datetimepicker.css">
<!-- <link rel="stylesheet"  type="text/css" href="<?php echo base_url();?>assets/css/viewer.min.css"> -->
<!-- <link rel="stylesheet"  type="text/css" href="<?php echo base_url();?>assets/css/patient_field_validations.css"> -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-barcode.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/selectize.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.selectize.js"></script>
<!-- <script type="text/javascript" src="<?php //echo base_url();?>assets/js/patient_followp_validations.js"></script> -->

<style>
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
function initDistrictSelectize(){
        var districts = JSON.parse(JSON.stringify(<?php echo json_encode($districts); ?>));
	var selectize = $('#district_id').selectize({
	    valueField: 'district_id',
	    labelField: 'custom_data',
	    searchField: ['district','district_alias','state'],
	    options: districts,
	    create: false,
	    render: {
	        option: function(item, escape) {
	        	return '<div>' +
	                '<span class="title">' +
	                    '<span class="prescription_drug_selectize_span">'+escape(item.custom_data)+'</span>' +
	                '</span>' +
	            '</div>';
	        }
	    },
	    load: function(query, callback) {
	        if (!query.length) return callback();
		},

	});
	if($('#district_id').attr("data-previous-value")){
		selectize[0].selectize.setValue($('#district_id').attr("data-previous-value"));
	}
}
		function validateInput(event){
		var search_patient_id = document.forms[event.target.id]["healthforall_id"].value;
		var search_phone = document.forms[event.target.id]["phone_num"].value;

		if (search_patient_id.length <=0 && search_phone.length <=0 ){
			bootbox.alert("Please enter a field to search");
			event.preventDefault();
		}  
	
		}
		function statusDateUpdate()
		{    
		   $('#error_status_date').html('');
		}

		function lifeStatusUpdate()
		{    
			$('#error_life_status').html('');
		}
		function lastVisitDateUpdate()
		{
			$('#error_lastvisit_date').html('');
		}
		function lastVisitType()
		{
			$('#error_lastvs_type').html('');
		}
	function onAddFollowUpSubmit(){
		
       var status_date = $('#status_date').val();
	   var last_visit_date = $('#last_visit_date').val();
	  
       if(status_date == '')
	   {
		$('#error_status_date').html('This field is required');
	   }
	   else if(status_date != '')
	   {
		$('#error_status_date').html('');
	   }
       if($('input:radio[name=life_status]:checked').length <= 0)
	   {
		$('#error_life_status').html('This field is required');
	   }
	   else{
		$('#error_life_status').html('');
	   }
	   if(last_visit_date == '')
	   {
		$('#error_lastvisit_date').html('This field is required');
	   }
	   else if(last_visit_date != '')
	   {
		$('#error_lastvisit_date').html('');
	   }

	   if($('select[name=last_visit_type]').val()=="Select"){
		$('#error_lastvs_type').html('This field is required');
		
	   }
		//$("#followup_patient").submit();
		//eve.preventDefault();
	}	
	
	</script>
				<script>
					$(function(){
					<?php if($patient_followup->status_date == 0){ ?>
					$('.status_date').datetimepicker({
						format : "D-MMM-YYYY h:ssA",
						//minDate : "<?php //echo date("Y/m/d ",strtotime($patient->admit_date)).date("g:i A",strtotime($patient->admit_time));?>",
						defaultDate : false
					});
					<?php } ?>
					<?php if($patient_followup->status_date == 0){ ?>
					$('.last_visit_date').datetimepicker({
						format : "D-MMM-YYYY h:ssA",
						//minDate : "<?php //echo date("Y/m/d ",strtotime($patient->admit_date)).date("g:i A",strtotime($patient->admit_time));?>",
						defaultDate : false
					});
					<?php } ?>

		
					});
					
					</script>
<?php

$patient = $patients[0];
  
?>
<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">
		<div class="row alt">
			<h4>Patient Followup</h4>
			<span style="color:red;">(Search by Patient Id or Phone Number one of them is Mandatory *)	</span>
		</div>
		</div>
		<div class="panel-body">
			<?php echo form_open("register/patient_follow_up",array('role'=>'form','class'=>'form-custom','id'=>'followup_patient','onSubmit'=>'validateInput(event)')); ?>
			<input type="hidden" class="sr-only" value="<?php echo $transaction_id;?>" name="transaction_id" />

				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
						<div class="form-group">
								<label for="Inputtype1">H4A Patient ID</label>					
								<input type='text' name='healthforall_id' id='healthforall_id' class='form-control' />
						</div>	
					</div>
				    
	
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
						<div class="form-group">
							<label for="Inputtype2" >Phone Number</label>
							<input type='text' name='phone_num' id='phone_num' class='form-control' />
						</div>	
					</div>
				</div>
		</div>

		<div class="panel-footer">
			<div class="text-center">
				<input class="btn btn-sm btn-primary" name="search_followup" type="submit" value="Submit" />
			</div>
		</div>
	</div>
	

	
		<?php if(isset($patients) && count($patients)==1){ ?>
			
	
	<div class="col-md-12">
	<div class="panel panel-default">
			<h4 align="center">Patient Follow-up</h4><br>
			<div class="panel-heading">
				<h4 style="color:blue">Patient Details</h4>
			</div>
	
		<div class="panel-body">
			<?php echo form_open('register/patient_follow_up',array('class'=>'form-custom','role'=>'form', 'id'=>'patient_follow_up')); ?>
			<input type="hidden" class="sr-only" value="<?php echo $transaction_id;?>" name="transaction_id" />
			<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
							Patient ID:  <input type="text" name="patient_id" class="form-control" placeholder="" value="<?php echo $patient->patient_id; ?>" style="background: white; font-weight: bold;" readonly/>
                            </div>		
							</div>

							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
				            <div class="form-group">
							Name: 	<input type="text" name="patient_name" class="form-control" placeholder="" value="<?php echo $patient->first_name." ".$patient->last_name; ?>" <?php if($f->edit==1 && empty($patient->first_name." ".$patient->last_name)) echo ' required'; else echo ' readonly'; ?> style="background: white; font-weight: bold;" />
                            </div>
		                    </div>

						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
						<div class="form-group">
						
						<label class="control-label">Age<?php if($field->mandatory) { ?><span class="mandatory" >*</span><?php } ?>/</label>
						<td><label> Gender </label></td>
						<table>
									<tr>
										<td><input type="text" name="age_years" class="form-control" style="background: white;" size="1"  value="<?php echo $patient->age_years; ?>"   readonly/><td>Y</td></td>
										<td><input type="text" name="age_months" class="form-control" style="background: white;" size="1"   value=""  readonly/><td>M</td></td>
										<td><input type="text" name="age_days" class="form-control" style="background: white;"size="1"   value=""  readonly/><td>D</td></td> 
										
										<td></label>/</label></td>
										<td>
										
										
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
										
									</td>
										</tr>
							</table>
						</div>
						</div>				
			</div>

		<div class="row">
		<div class="col-md-4 col-xs-6">			
		<label class="control-label">Relative Name </label>
		<input type="text" name="relative_name" class="form-control" placeholder="" value=""  style="background: white; font-weight: bold;" readonly/>
		</div>	

				<div class="col-md-4 col-xs-6">
					
						<label class="control-label">Address</span></label>
						<input type="text" name="address" class="form-control" value="" style="background: white; font-weight: bold;" readonly/>
					
				</div>	

				<div class="col-md-4 col-xs-6">
					<label class="control-label">District</label>
					<input type="text" name="district_patient" class="form-control" placeholder="" value=""  style="background: white; font-weight: bold;" readonly/>		
				</div>
			</div>

			<div class="row">			
				<div class="col-md-4 col-xs-6">
					<label class="control-label">Phone</label>
					<input type="text" name="phone" class="form-control" value="" style="background: white; font-weight: bold;" readonly/>
				</div>	
				
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
								<div class="form-group">
									<label for="inputstatus_date ">Registered On Date  </label>
									<input class="form-control" style = "background-color: white; font-weight: bold;" type="text" value="" name="register_date" id="register_date" size="15"  readonly />
								</div>
				</div>
			</div>	
	
		
		
		<div class="panel-heading">
		<div class="row alt">
				<h4 style="color:blue">Patient Follow Up Details</h4>
		</div>
		</div>
	
		
			<!-- <?php echo form_open('register/patient_follow_up',array('class'=>'form-custom','role'=>'form', 'id'=>'patient_follow_up')); ?> -->
			<input type="hidden" class="sr-only" value="<?php echo $transaction_id;?>" name="transaction_id" />
			<div class="row">
				
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
				        <div class="form-group">
						<label for="inputstatus">Status Date <span class="mandatory" >*</span> </label><br>
					<input class="form-control"  type="date"  name="status_date" id="status_date" onchange="statusDateUpdate();" />
					<span style="color:red;" id="error_status_date"></span>

						</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-6  col-lg-4">
							<div class="form-group">
								<label for="inputstatus ">Life Status <span class="mandatory" >*</span></label><br>
								&nbsp;&nbsp;  <input type="radio" name="life_status" id="life_status_live"  value="1" onchange=lifeStatusUpdate(); >
								<label for="staus_alive">Alive</label>&nbsp;&nbsp;
								<input type="radio" name="life_status" id="life_status_notlive" value="0" onchange=lifeStatusUpdate(); >
								<label for="status_dead">Not Alive</label><br>
								<span style="color:red;" id="error_life_status"></span>

							</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-6  col-lg-4">
							<div class="form-group">
								<label for="Inputicd_code">ICD Code</label>
                                <select class="form-control" name="icd_code" >
									<option value="Select">Select</option>
									<?php foreach($codes as $icd_code){
									//echo "<option value='$helpline->helpline_id'>$helpline->helpline - $helpline->note</option>";
									}
									?>
								</select>
                            </div>
				</div>

			</div>

			<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
						<div class="form-group">
								<label for="Inputdiagnosis">Diagnosis</label>
								<input class="form-control" name="diagnosis" id="inputdiagnosis" placeholder="Enter Diagnosis" type="TEXT" align="middle">
						</div> 
					</div>								
						
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label">Last Visit Type <span class="mandatory">*</span> </label>
								<select class="form-control" name="last_visit_type"  onchange="lastVisitType();">
									<option value="Select">Select</option>
									<option value=''>All</option>
								    <option value='IP'>IP</option>
								    <option value='OP'>OP</option>  
									<!-- <?php foreach($helplines as $helpline){
									//echo "<option value='$helpline->helpline_id'>$helpline->helpline - $helpline->note</option>";
									}
									?> -->
								</select>
								<span style="color:red;" id="error_lastvs_type"></span>
							</div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="inputstatus_date ">Last Visit Date <span class="mandatory">*</span> </label>
								<input class="form-control"  type="date"  name="last_visit_date" id="last_visit_date" onchange="lastVisitDateUpdate();" />
								<span style="color:red;" id="error_lastvisit_date"></span>

							</div>
						</div>
			</div>	
			
			<div class="row">		
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label class="control-label">Priority Type </label>
								<select class="form-control" name="priority_type" >
									<option value="Select">Select</option>
									<!-- <?php foreach($types as $type){
									//echo "<option value='$type->helpline_id'>$helpline->helpline - $helpline->note</option>";
									}
									?> -->
								</select>
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label">Primary Route</label>
								<select class="form-control" name="primary_route" id="primary_route">
									<option value="Select">Select</option>
									<!-- <?php foreach($primary_routes as $routes){
									//echo "<option value='$layout->print_layout_id'>$layout->print_layout_name</option>";
									}
									?> -->
								</select>
							</div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-6  col-lg-4">
							<div class="form-group">
								<label class="control-label">Secondary Route</label>
								<select class="form-control" name="secondary_route" id="secondary_route">
									<option value="Select">Select</option>
									<!-- <?php foreach($secondary_routes as $routes){
									//echo "<option value='$route->print_layout_id'>$layout->print_layout_name</option>";
									}
									?> -->
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
									 <!-- <?php foreach($helplines as $helpline){
									// echo "<option value='$helpline->helpline_id'>$helpline->helpline - $helpline->note</option>";
									}
									?>  -->
								</select>
							</div>
						</div>										
											
						
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
						<div class="form-group">
								<label for="Inputdiagnosis">Note</label>
								<input class="form-control" name="diagnosis" id="inputdiagnosis" placeholder="Enter Diagnosis" type="TEXT" align="middle">
						</div> 
					</div>	
			</div>	&emsp;&emsp;
			
			<div class="panel-footer">
			<div class="text-center">
				<?php if(isset($patient_followup)  && ($patient_followup->hospital_id == $hospital_id) ) { ?>
				<center><button type="button" class="btn btn-md btn-primary" value="Update" name="update_patient" onclick="onUpdatePatientSubmit(event)">Update</button></center>&emsp;
				 <?php } ?>
				<?php if(isset($patient->patient_id) && (!$patient_followup->patient_id)){ ?>

					<center><button type="button" class="btn btn-md btn-primary" value="Update" name="addfollowup_patient" onclick="onAddFollowUpSubmit()">Add For Followup</button></center>&emsp;
				<?php } ?>
				</div>								
		</div>
		</div>
		</div>
		</form>		
		<?php }
		else if(isset($patients) && count($patients)==0){
			echo "<b>". $msg ."</b>" ;
		}
		?>

	</div>
	</div>