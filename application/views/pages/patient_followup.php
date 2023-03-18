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


<script>

		function validateInput(event){
		var search_patient_id = document.forms[event.target.id]["healthforall_id"].value;
		var search_phone = document.forms[event.target.id]["phone_num"].value;

		if (search_patient_id.length <=0 && search_phone.length <=0 ){
			bootbox.alert("Please enter a field to search");
			event.preventDefault();
		}
		}
	
	</script>

<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">
		<h4>Patient Followup</h4>
		<span style="color:red;">(Search by Patient Id or Phone Number one of them is Mandatory *)	</span>
		</div>
		<div class="panel-body">
		<?php echo form_open("register/patient_follow_up",array('role'=>'form','class'=>'form-custom','id'=>'followup_patient','onSubmit'=>'validateInput(event)')); ?>
	
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
			</form>		
		</div>

		</div>
		</div>
		</div>



  
