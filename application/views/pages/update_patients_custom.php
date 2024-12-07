<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/selectize.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.timeentry.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/moment.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/ckeditor.js"></script>
<!-- < <script type="text/javascript" src="<?php echo base_url();?>assets/js/viewer.min.js"></script> -->
<!-- <script type="text/javascript" src="<?php echo base_url();?>assets/js/patient_field_validations.js"></script> -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/Chart.min.js"></script>
<link rel="stylesheet"  type="text/css" href="<?php echo base_url();?>assets/css/bootstrap_datetimepicker.css">
<!-- <link rel="stylesheet"  type="text/css" href="<?php echo base_url();?>assets/css/viewer.min.css"> -->
<!-- <link rel="stylesheet"  type="text/css" href="<?php echo base_url();?>assets/css/patient_field_validations.css"> -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-barcode.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
<style>
	.error {
    	color: red;
  	}
  	input.error, textarea.error, select.error,
  	input.error_field{
  		border: 1px solid red;
  	}
    .obstetric_history_table {  
        border-collapse: collapse; 
    }
    .obstetric_history_table tr{
        display: block; float: left;
    }
    .obstetric_history_table td{
        display: block; 
        border: 1px solid black;
        height: 55px;
    }
    .prescription_table_heading_icons, .prescription_table_heading_info_icons{
    	width: 15px;
    	height: 15px;
    	margin-right: 5px;
    	margin-left: 5px;
    }
    .prescription_warning_i{
    	width: 25px;
    	height: 25px;
    	padding-right: 5px;
    	padding-left: 5px;
    	font-size: 15px;
    }
    .border_bottom_dashed{
    	border-bottom: 1px dashed black;
    }
    .prescription textarea{
        resize: none;
    	width: 100%;
    	margin-top: 10px;
        height: 28px;
        overflow: hidden;
    }
    .prescription .note_tooltip, .prescription .glyphicon-pencil{
    	cursor: pointer;
    	-webkit-user-select: none; /* Safari */
	  	-ms-user-select: none; /* IE 10+ and Edge */
		user-select: none; /* Standard syntax */
    }
    .prescription .drug_available_class{
    	background: #6DF48F;
    	font-weight: bold;
    }
    .selectize-inline {
    display: inline-grid;
}
   /*   .pictures {
      list-style: none;
      margin: 0;
      padding: 0;
    }

    .pictures > li {
      border: 1px solid transparent;
      float: left;
      height: calc(100% / 3);
      margin: 0 -1px -1px 0;
      overflow: hidden;
      width: calc(100% / 3);
    }

    .pictures > li > img {
      cursor: zoom-in;
      width: 100%;
    }
    .viewer-title {
    	font-weight: bold;
    	color: #fff;
    } */
</style>
<style>
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
		.accordion {
			display: flex;
			justify-content: space-between;
			align-items: center;
			background-color: #eee!important;
			padding: 23px;
			cursor: pointer;
		}

		.accordion-content {
			display: none;
			padding: 10px;
			border-top: 1px solid #ddd;
		}
		
	
</style>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.timeentry.min.js"></script>
<script type="text/javascript">


var smsDetails = {};
var user_details = <?php echo $user_details; ?>;
var receiver = user_details.receiver;
$(function(){
//	$(".date").Zebra_DatePicker();
//	$("#from_date,#to_date").Zebra_DatePicker();
});

<!-- Scripts for printing output table -->
function printDiv(i)
{
var content = document.getElementById(i);
var pri = document.getElementById("ifmcontentstoprint").contentWindow;
pri.document.open();
pri.document.write(content.innerHTML);
pri.document.close();
pri.focus();
pri.print();
}
 
</script>
<?php
	$patient = $patients[0];
?>


	<?php 
        if(isset($patients) && count($patients)>1){ ?>
		<?php  echo "| <b>H4A Patient ID</b> : ".$patients[0]->patient_id." | ";
			if(isset($patients[0]->patient_id_manual) and $patients[0]->patient_id_manual!="")
			{
				echo "<b>Manual Patient ID</b> : ".$patients[0]->patient_id_manual." | ";
			}
				echo "<b>Patient</b> : ".$patients[0]->first_name.' '.$patients[0]->last_name." | ";
				echo "<b>Age</b> : ".$patients[0]->age_years."Y ".$patients[0]->age_months."M ".$patients[0]->age_days."D"." | ";
			if ($patients[0]->gender!="0"){							 
				echo "<b>Gender</b> : ".$patients[0]->gender." | ";			 
			}
				echo "<b>Phone</b> : ".$patients[0]->phone." | ";
				echo "<b>Address</b> : ".$patients[0]->address. " | ";
			if(isset($patients[0]->district))
			{
				echo "<b>District</b> : ".$patients[0]->district." | ";
				echo "<b>State</b> : ".$patients[0]->state." | ";
			}
				echo "<b>Relative</b> : ".$patients[0]->parent_spouse." | ";
		?>
		<br/>
		<?php
		?>
		<caption><h4 style="text-align:center!important;color:#429ada;"><b>Select Visit </b></h4></caption>
	<table class="table table-hover table-striped" id="table-sort">
	<thead>
		<th style="text-align:center">#</th>
		<th style="text-align:center">Visit Date</th>
		<th style="text-align:center">Hospital</th>
		<th style="text-align:center">OP/IP No</th>
		<th style="text-align:center">Department -- Unit Name</th>
		<th style="text-align:center">Visit Name</th>
		<th style="text-align:center">Discharge Date</th>
		<th style="text-align:center">Appointment Date</th>
	</thead>
	<tbody>
	<?php 
	$i=1;
	
	foreach($patients as $p){ ;
		$age="";
		if($p->age_years!=0) $age.=$p->age_years."Y ";
		if($p->age_months!=0) $age.=$p->age_months."M ";
		if($p->age_days!=0) $age.=$p->age_days."D ";
		if($p->age_days==0 && $p->age_months == 0 && $p->age_years == 0) $age.="0D ";
	?>
	<tr onclick="submitForm(<?php echo $p->visit_id; ?>)" style="cursor:pointer">
		<td>
			<?php echo form_open('register/saved_update_patient_custom_form', array('role' => 'form', 'id' => 'select_patient_' . $p->visit_id)); ?>
			<input type="text" class="sr-only" hidden value="<?php echo $p->visit_id; ?>" form="select_patient_<?php echo $p->visit_id; ?>" name="visit_id" />
			<input type="text" class="sr-only" hidden value="<?php echo $p->patient_id; ?>" name="patient_id" />
			<input type="text" name="sent_form_id" hidden value="<?php echo $requested_form_id; ?>" name="form_id">
			</form>
			<?php echo $i++; ?>
		</td>
		<td style="text-align:center"><?php echo date("d-M-Y", strtotime($p->admit_date)); ?></td>
		<td style="text-align:center"><?php echo $p->hospital; ?></td>
		<td style="text-align:center"><?php echo $p->visit_type . " #" . $p->hosp_file_no; ?></td>
		<td style="text-align:center"><?php echo $p->department; ?> -- <?php echo $p->unit_name; ?></td>
		<td style="text-align:center"><?php echo $p->visit_name; ?></td>
		<td style="text-align:center"><?php if ($p->outcome_date == "0000-00-00" || $p->outcome_date == " ") { echo " "; } else { echo date("d-M-Y", strtotime($p->outcome_date)); } ?></td>
		<td style="text-align:center"><?php if (isset($p->appointment_time) && $p->appointment_time != "") { echo date("j M Y", strtotime($p->appointment_time)); } ?></td>
	</tr>
	<script>
		function submitForm(visitId) 
		{
			var form = document.getElementById('select_patient_' + visitId);
			form.submit();
		}
	</script>
	<?php
	}
	?>
	</tbody>
	</table>
	
	<?php } 
	else if(isset($patients) && count($patients)==1){
            ?>
	<?php if(isset($duplicate)) { ?>
				<div class="alert alert-danger">Entered Patient Manual ID Number already exists.</div>
	<?php } ?>
	<?php if(isset($msg)) { ?>
		<div class="alert alert-info"><?php echo $msg;?></div>
	<?php } ?>
	
		
	<?php }
	else if(isset($patients)){
		echo "No patients found with the given search terms";
	}
	?>
	</div>
	<br/>
	
	
<br>
	<div class="col-md-12">
		<div class="panel panel-default">
		<div class="panel-heading">
		<h4>Search Patients</h4>	
		</div>
		<div class="panel-body">
		<?php echo form_open("register/update_patient_customised",array('role'=>'form','class'=>'form-custom','id'=>'patient_search','onSubmit'=>'validateInput(event)')); ?>
					<div class="row">
					<div class="col-md-10">
						<div class="form-group">
						<label class="control-label">H4A Patient ID</label>
						<input type="text" id="search_patient_id" name="search_patient_id" size="5" class="form-control" />
						<label class="control-label">Year</label>
						<select class="form-control" name="search_year">
							<?php 
								$i=2013;
								$year = date("Y");
								while($year>=$i){ ?>
								<option value="<?php echo $year;?>"><?php echo $year--;?></option>
							<?php
								}
							?>
						</select>
						</div>
						<div class="form-group">
							<label class="control-label">Visit Type</label>
							<select class="form-control" name="search_visit_type">
								<option value=''>All</option>
								<option value='IP'>IP</option>
								<option value='OP'>OP</option>
							</select>
						<label class="control-label">IP/OP Number</label>
						<input type="text" id="search_patient_number" name="search_patient_number" size="5" class="form-control" />
						</div>
					
						<div class="form-group">
						<label class="control-label">Phone Number</label>
						<input type="text" id="search_phone" name="search_phone" class="form-control" />
						</div>
						<div class="form-group">
						<label class="control-label">Patient ID Manual</label>
						<input type="text" id="search_patient_id_manual" name="search_patient_id_manual" size="5" class="form-control" />
						</div>

						<input type="hidden" name="sent_form_id" value="<?php echo $form_id ;?>" name="form_id">

					</div>
				</div>
		</div>
		<div class="panel-footer">
			<div class="text-center">
			<input class="btn btn-sm btn-primary" name="search_patients" type="submit" value="Submit" />
			</div>
			</form>
		</div>
		</div>
	</div>
<br />