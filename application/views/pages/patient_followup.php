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

		function validateInput(event){
		var search_patient_id = document.forms[event.target.id]["healthforall_id"].value;
		var search_phone = document.forms[event.target.id]["phone_num"].value;

		if (search_patient_id.length <=0 && search_phone.length <=0 ){
			bootbox.alert("Please enter a field to search");
			event.preventDefault();
		}  
	
		}
		
	function onAddFollowUpSubmit(){
		
      alert('Add Followup');
	}	

	function onUpdatePatientSubmit(){

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

			patient_id = $('input:text[name=patient_id]').val();
			status_date = $('#status_date').val();
			life_status = $('input:radio[name=life_status]:checked').val();
			diagnosis = $('input:text[name=diagnosis]').val();
			last_visit_type = $('select[name=last_visit_type]').val();
			last_visit_date = $('#last_visit_date').val();
			priority_type = $('select[name=priority_type]').val();
            volunteer = $('select[name=volunteer]').val();
			input_note =  $('input:text[name=input_note]').val();

			$.ajax({
			type: 'POST',
			url: '<?php echo base_url('register/patient_follow_up');?>',
			data: { patient_id:patient_id,status_date:status_date,life_status:life_status,
				diagnosis:diagnosis,last_visit_type:last_visit_type,last_visit_date:last_visit_date,
				priority_type:priority_type,volunteer:volunteer,input_note:input_note},
			success: function(msg){	
				if(msg)
				{
				//alert(msg.update_patient);
				}
			}						
			});
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

	$('form[id="followup_add_details"]').validate({
	
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
	<?php echo validation_errors(); ?>
<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">
		<div class="row">
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
							<div class="col-md-3">
							<div class="form-group">
							Patient ID:  <input type="text" name="patient_id" class="form-control" placeholder="" value="<?php echo $patient->patient_id; ?>" style="background: #ADFF2F; " readonly/>
                            </div>		
							</div>

							<div class="col-md-3">
						    <div class="form-group">
							Name: 	<input type="text" name="patient_name" class="form-control" placeholder="" value="<?php echo $patient->first_name." ".$patient->last_name; ?>" <?php if($f->edit==1 && empty($patient->first_name." ".$patient->last_name)) echo ' required'; else echo ' readonly'; ?> style="background: #ADFF2F;" />
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
						<label>Gender: 	</label>		
						    <div class="form-group">
								<div class="col-md-4 col-xs-4" style="background: #ADFF2F; font-weight: bold;" >

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
					
						<label class="control-label">Address</span></label>
						<textarea name="address" class="form-control"  style="background: #ADFF2F; " readonly/><?php echo $patient->address; ?></textarea>
					
				</div>	

				<div class="col-md-3">
					<label class="control-label">District</label>
					<input type="text" name="district_patient" class="form-control" placeholder="" value="<?php echo $districts->district; ?>"  style="background: #ADFF2F;" readonly/>		
				</div>
			</div>

			<div class="row">			
			<div class="col-md-3">
					<label class="control-label">Phone</label>
					<input type="text" name="phone" class="form-control" value="<?php echo $patient->phone; ?>" style="background: #ADFF2F; " readonly/>
				</div>	
				
				<div class="col-md-3">
								<div class="form-group">
									<label for="inputstatus_date ">Registered On Date  </label>
							 <input type="text" name="dob" class="form-control" value="<?php if($patient) echo date('d/m/Y',strtotime($patient->insert_datetime));?>" style="background: #ADFF2F; " readonly />
						</div>
				</div>
			</div>	
							</form>
			</div>
	</div>
	<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">
		<div class="row">
				<h4 style="color:blue">Patient Follow Up Details</h4>
		</div>
		</div>
	
		
		<?php echo form_open('register/patient_follow_up',array('class'=>'form-custom','role'=>'form', 'id'=>'followup_add_details','onSubmit'=>'onAddFollowUpSubmit()')); ?>
			<input type="hidden" class="sr-only" value="<?php echo $transaction_id;?>" name="transaction_id" />
			<div class="row">
				
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
				        <div class="form-group">
						<label for="inputstatus">Status Date <span class="mandatory" >*</span> </label><br>
					<input class="form-control"  type="date"  name="status_date" id="status_date"  required/>

						</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-6  col-lg-4">
							<div class="form-group">
								<label for="inputstatus ">Life Status <span class="mandatory" >*</span></label><br>
								&nbsp;&nbsp;  <input type="radio" name="life_status" id="life_status_live"  value="1" required >
								<label for="staus_alive">Alive</label>&nbsp;&nbsp;
								<input type="radio" name="life_status" id="life_status_notlive" value="0" required >
								<label for="status_dead">Not Alive</label><br>
								<span style="color:red;" id="error_life_status"></span>

							</div>
				</div>
			
				<div class="col-xs-12 col-sm-12 col-md-6  col-lg-4">
							<div class="form-group">
							<label class="Inputdistrict">  ICD Code    </label>
							<select id="icd_code" class="repositories"  name="icd_code" style=" display: inline-grid;" placeholder="Search ICD codes" >
								<option value="">   --Search ICD codes--   </option>
								<input type='hidden' name='icd_code' id='icd_code_val' class='form-control'/>
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
								<select class="form-control" name="last_visit_type"  required>
									<option value="">Select</option>
									<option value='All'>All</option>
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
								<input class="form-control"  type="date"  name="last_visit_date" id="last_visit_date" required />
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
									 <?php foreach($priority_types as $type){
									echo "<option value='$type->priority_type_id'>$type->priority_type</option>";
									}
									?> 
								</select>
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label">Primary Route</label>
								<input class="form-control"  type="text"  name="primary_route" id="primary_route" placeholder="Enter Latitude,Longitude"/>

							</div>
						</div>

						<div class="col-xs-12 col-sm-12 col-md-6  col-lg-4">
							<div class="form-group">
								<label class="control-label">Secondary Route</label>
								<input class="form-control"  type="text"  name="secondary_route" id="secondary_route" placeholder="Enter Latitude,Longitude"/>

							</div>
						</div>
			</div>

			<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label class="control-label">Volunteer </label>
								<select class="form-control" name="volunteer" >
									<option value="Select">Select</option>
									 <!-- <?php //foreach($helplines as $helpline){
									// echo "<option value='$helpline->helpline_id'>$helpline->helpline - $helpline->note</option>";
									//}
									?>  -->
								</select>
							</div>
						</div>										
											
						
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
						<div class="form-group">
								<label for="Inputdiagnosis">Note</label>
								<input class="form-control" name="input_note"  id="input_note"  placeholder="Enter Note"  type="text" align="middle">
						</div> 
					</div>	
			</div>	&emsp;&emsp;

			<div class="panel-footer">
			<div class="text-center">
				<?php if(isset($patient_followup)  && ($patient_followup->hospital_id == $hospital_id) ) { ?>
				<center><button type="button" class="btn btn-md btn-primary" value="Update" name="update_patient" onclick="onUpdatePatientSubmit()">Update</button></center>&emsp;
				 <?php } ?>
				<?php if(isset($patient->patient_id) && (!$patient_followup->patient_id)){ ?>
					<input class="btn btn-sm btn-primary" name="search_add" type="submit" value="Add For Followup" />

					<!-- <center><button type="button" class="btn btn-md btn-primary" value="Update" name="addfollowup_patient" onclick="onAddFollowUpSubmit()">Add For Followup</button></center>&emsp; -->
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