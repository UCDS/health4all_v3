<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.timeentry.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/moment.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/Chart.min.js"></script>
<link rel="stylesheet"  type="text/css" href="<?php echo base_url();?>assets/css/bootstrap_datetimepicker.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-barcode.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
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
		$('#followup_add_details').submit();
        //alert('Add Followup');
	}	

	function onUpdatePatientSubmit(){

	//    var status_date = $('#status_date').val();
	//    var last_visit_date = $('#last_visit_date').val();	  
    //    if(status_date == '')
	//     {
	// 	$('#error_status_date').html('This field is required');
	//     }
	//    else if(status_date != '')
	//    {
	// 	$('#error_status_date').html('');
	//    }
    //    if($('input:radio[name=life_status]:checked').length <= 0)
	//    {
	// 	$('#error_life_status').html('This field is required');
	//    }
	//    else{
	// 	$('#error_life_status').html('');
	//    }
	//    if(last_visit_date == '')
	//    {
	// 	$('#error_lastvisit_date').html('This field is required');
	//    }
	//    else if(last_visit_date != '')
	//    {
	// 	$('#error_lastvisit_date').html('');
	//    }

	//    if($('select[name=last_visit_type]').val()=="Select"){
	// 	$('#error_lastvs_type').html('This field is required');		
	//    }

	// 		patient_id = $('input:text[name=patient_id]').val();
	// 		status_date = $('#status_date').val();
	// 		life_status = $('input:radio[name=life_status]:checked').val();
	// 		diagnosis = $('input:text[name=diagnosis]').val();
	// 		last_visit_type = $('select[name=last_visit_type]').val();
	// 		last_visit_date = $('#last_visit_date').val();
	// 		priority_type = $('select[name=priority_type]').val();
    //         volunteer = $('select[name=volunteer]').val();
	// 		input_note =  $('input:text[name=input_note]').val();

	// 		$.ajax({
	// 		type: 'POST',
	// 		url: '<?php echo base_url('register/patient_follow_up');?>',
	// 		data: { patient_id:patient_id,status_date:status_date,life_status:life_status,
	// 			diagnosis:diagnosis,last_visit_type:last_visit_type,last_visit_date:last_visit_date,
	// 			priority_type:priority_type,volunteer:volunteer,input_note:input_note},
	// 		success: function(msg){	
	// 			if(msg)
	// 			{
	// 			//alert(msg.update_patient);
	// 			}
	// 		}						
	// 		});
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
				    
				<!--
				Commenting for improvement 
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
						<div class="form-group">
							<label for="Inputtype2" >Phone Number</label>
							<input type='text' name='phone_num' id='phone_num' class='form-control' />
						</div>	
					</div>
				-->
				</div>
		</div>

		<div class="panel-footer">
			<div class="text-center">
				<input class="btn btn-sm btn-primary" name="search_followup" type="submit" value="Submit" />
			</div>
		</div>

	
			</form>
			
	</div>
	</div>
	<?php if(count($patients)==0){
			echo "<b>". "No patient record found. Register Patient and add for Followup" ."</b>" ;
		}
		else {
			echo "<b>". $msg ."</b>";

		} ?>
