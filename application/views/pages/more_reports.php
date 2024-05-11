<script type="text/javascript" src="<?php echo base_url();?>assets/js/accordion.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/accordion.css">
<style type="text/css">
.anchor_style {
    display: block;
    padding: 3px 20px;
    clear: both;
    font-weight: normal;
    line-height: 1.428571429;
    color: #333333;
    white-space: nowrap;
}
</style>

<title><?php echo $title;?></title>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>
<?php 
$appointments=0;
$helpline=0;
$admin=0;
$followup=0;
$diagnostic=0;
$sanitation=0;
foreach($this->data['functions'] as $function){
			if($function->user_function=="OP Detail" || $function->user_function=="appointment_by_staff" || $function->user_function=="patient_location_report" || $function->user_function=="referral"  
			|| $function->user_function=="issue_list" || $function->user_function=="issue_summary" || $function->user_function=="prescription_report"
			||$function->user_function=="IP Detail" || $function->user_function=="Patient Transport Report" ||
			$function->user_function=="IP Summary" || $function->user_function=="Outcome Summary" ||
			$function->user_function=="Patient Transport Report"
			){
				$appointments=1;
				
				?>
				<button class="accordion">Visits</button>
<?php			break;}
		}
		
if($appointments==1) { ?>
<div class="panel_accordion">
<?php
foreach($this->data['functions'] as $function){
			if($function->user_function=="OP Detail"){ ?>
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."reports/op_detail_3";?>">Out Patient Detail 3</a></button>
				<!-- <button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."reports/op_detail_followup";?>">Out Patient Detail - Followup</a></button> -->
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."reports/op_detail_followup";?>">Visit Type  - Detail Followup</a></button>
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."reports/visit_type_summary";?>">Visit Type Summary</a></button>
<?php		 }

if($function->user_function=="appointment_by_staff"){ ?>
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."reports/appointment_summary_by_staff";?>">Appointments by Team Member</a></button>
<?php		 }

	if($function->user_function== "patient_location_report"){ ?>
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url(). "op_ip_report/op_ip_summary_report";?>">Patient Location Report</a></button>
	<?php		 }
	
	if($function->user_function== "referral"){ ?>
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url(). "reports/referrals";?>">Referrals</a></button>
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url(). "reports/referrals_centers";?>">Referral Centers</a></button>
<?php		 }

 if($function->user_function== "issue_list"){ ?>
		<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"><a class="anchor_style" href="<?php echo base_url()."reports/issue_list";?>">Issue List</a></button>

<?php } if($function->user_function== "issue_summary"){ ?>
	<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"><a class="anchor_style" href="<?php echo base_url()."reports/issue_summary";?>">Issue Summary</a></button>

<?php } if($function->user_function=="prescription_report"){ ?>
	<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
		<a class="anchor_style" href="<?php echo base_url()."report/get/prescription_report";?>">Prescription Report</a>
	</button>
<?php } if($function->user_function=="IP Detail"){ ?>
	<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
		<a class="anchor_style" href="<?php echo base_url()."reports/icd_detail";?>">ICD Code Detail</a>
	</button>
<?php } if($function->user_function=="Patient Transport Report"){ ?>
	<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
		<a class="anchor_style" href="<?php echo base_url()."reports/transport_detail";?>">Transport Detailed</a>
	</button>
<?php	} if($function->user_function=="IP Summary"){ ?>
	<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 	
		<a class="anchor_style" href="<?php echo base_url()."staff_report/get_doc_act_by_institute";?>">Doctor Activity By Institution </a>
	</button>
	<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 
		<a class="anchor_style" href="<?php echo base_url()."patient/casesheet_mrd_status";?>">MRD Report</a>
	</button>
	<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 
		<a class="anchor_style" href="<?php echo base_url()."reports/ip_op_trends";?>">IP/OP Trends</a>
	</button>
	<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 
		<a class="anchor_style" href="<?php echo base_url()."reports/icd_summary";?>">ICD Code Summary</a>
	</button>	
	<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 
		<a class="anchor_style" href="<?php echo base_url()."reports/transfer_summary";?>">Transfers Summary</a>
	</button>
<?php	}  if($function->user_function=="Outcome Summary"){ ?>
	<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 
		<a class="anchor_style" href="<?php echo base_url()."reports/outcome_summary";?>">Outcome Summary - IP</a>
	</button>
<?php } if($function->user_function=="Patient Transport Report"){ ?>
	<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
		<a class="anchor_style" href="<?php echo base_url()."reports/transport_summary";?>">Transport Summary</a>
	</button>
<?php }	} ?>

</div> <?php
	}
?>

<!--Followup tab -->
<?php
foreach($this->data['functions'] as $function){
	if( $function->user_function=="patient_follow_up" || $function->user_function=="followup_map" ||
	 $function->user_function=="followup_summary" || $function->user_function=="followup_summary_route" 
	 || $function->user_function=="followup_summary_death_icdcode" || $function->user_function=="followup_summary_death_routes"){
		$followup=1;
		?>
		<button class="accordion">Followup</button>
<?php			break;}
}

if($followup==1) { ?>
<div class="panel_accordion">
<?php
foreach($this->data['functions'] as $function){
	if($function->user_function=="patient_follow_up"){ ?>
<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."reports/followup_detail";?>">Followup List </a></button>
<?php		 }

if($function->user_function== "followup_map"){ ?>
<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url(). "op_ip_report/followup_map";?>">Followup Map</a></button>

<?php }	if($function->user_function== "followup_summary"){ ?>
<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url(). "op_ip_report/followup_summary";?>">Followup Summary - ICD Code</a></button>

<?php } if($function->user_function== "followup_summary_route"){ ?>
<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url(). "op_ip_report/followup_summary_route";?>">Followup Summary - Route</a></button>

<?php }  if($function->user_function== "followup_summary_death_icdcode"){ ?>
<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url(). "op_ip_report/followup_summary_death_icdcode";?>">Followup Summary Death - ICD Code</a></button>

<?php } if($function->user_function== "followup_summary_death_routes"){ ?>
<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url(). "op_ip_report/followup_summary_death_routes";?>">Followup Summary Death - Routes </a></button>

<?php }  } ?>

</div> <?php
}
?>
<!--followup tab ends-->
<?php 
foreach($this->data['functions'] as $function){
			if($function->user_function=="missed_calls_report" || $function->user_function=="completed_calls_report"){
				$helpline=1;
				?>
				
				<button class="accordion">Helpline</button>
				
<?php			break; }


		}
?>
<?php 

if($helpline==1) { ?>
<div class="panel_accordion">
<?php
foreach($this->data['functions'] as $function){
			if($function->user_function=="completed_calls_report"){ ?>
		<!--		<button class="panel_button"> <a class="anchor_style" href="<?php //echo base_url()."helpline/completed_calls_report";?>">Completed Calls - old </a></button> !-->
		<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."helpline/receiver_call_activity_report";?>">Completed calls by receiver</a></button>
<?php 		 }

if($function->user_function=="missed_calls_report"){ ?>
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."helpline/missed_calls_report";?>">Missed Calls</a></button>
<?php		 }

if($function->user_function=="dashboard" ){ ?>
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."dashboard/helpline_trend";?>">Trend - Calls</a></button>
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."dashboard/receiver";?>">Calls Attended - Receivers</a></button>
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."dashboard/helpline";?>">Dashboard</a></button>
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."dashboard/helpline_unique_callers";?>">Trend - Unique Callers</a></button>

				<!-- Newly Added March 25 2024 -->
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 
					<a class="anchor_style" href="<?php echo base_url()."dashboard/caller_type_report";?>">Caller Type Report</a>
				</button>
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 
					<a class="anchor_style" href="<?php echo base_url()."dashboard/call_category_report";?>">Caller Category Report</a>
				</button>
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 
					<a class="anchor_style" href="<?php echo base_url()."dashboard/hospital_report";?>">Hospital Report</a>
				</button>
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 
					<a class="anchor_style" href="<?php echo base_url()."dashboard/to_number_report";?>">To Number Report</a>
				</button>
				<!-- <button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 
					<a class="anchor_style" href="<?php echo base_url()."dashboard/op_ip_report";?>">OP / IP Report</a>
				</button> -->
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 
					<a class="anchor_style" href="<?php echo base_url()."dashboard/duration";?>">Duration Report</a>
				</button>
				<!-- Till here March 25 2024 -->
<?php		 }

	}

 ?>
</div> <?php
	}
?>

<!--Diagnostic tab -->
<?php
foreach($this->data['functions'] as $function){
	if( $function->user_function=="Diagnostics - Summary" || $function->user_function=="Bloodbank" ||
	 $function->user_function=="IP Summary"){
		$Diagnostic=1;
		?>
		<button class="accordion">Diagnostic</button>
<?php			break;}
}

if($Diagnostic==1) { ?>
<div class="panel_accordion">
<?php
foreach($this->data['functions'] as $function){
	if($function->user_function=="Diagnostics - Summary"){ ?>
<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 
	<a class="anchor_style" href="<?php echo base_url()."staff_report/get_lab_records";?>">Diagnostics Staff Activity</a>
</button>
<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
	<a class="anchor_style" href="<?php echo base_url()."reports/order_summary/department";?>">Orders Summary</a>
</button>
<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
	<a class="anchor_style" href="<?php echo base_url()."reports/sensitivity_summary";?>">Sensitivity Report</a>
</button>
<?php		 }

if($function->user_function== "Bloodbank"){ ?>
<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 
	<a class="anchor_style" href="<?php echo base_url()."reports/audiology_summary";?>">Diagnostics Audiology Report</a>
</button>

<?php }	if($function->user_function== "IP Summary"){ ?>
<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 
	<a class="anchor_style" href="<?php echo base_url()."diagnostics/lab_turnaround_time";?>">Diagnostics Turn Around Time</a>
</button>

<?php }  } ?>

</div> <?php
}
?>
<!--Diagnostic tab ends-->

<!--Sanitation tab -->
<?php
foreach($this->data['functions'] as $function){
	if( $function->user_function=="Sanitation Evaluation"  || $function->user_function=="Masters - Sanitation" 
	|| $function->user_function=="Sanitation Summary"){
		$sanitation=1;
		?>
		<button class="accordion">Sanitation</button>
<?php			break;}
}

if($sanitation==1) { ?>
<div class="panel_accordion">
<?php
foreach($this->data['functions'] as $function){
	if($function->user_function=="Sanitation Evaluation"){ ?>
<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 
	<a class="anchor_style"href="<?php echo base_url()."sanitation/view_scores";?>">Sanitation Evaluation - Scores </a>
</button>
<?php } 
	if($function->user_function=="Masters - Sanitation" || $function->user_function == "Sanitation Summary"){ ?>
<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> 
	<a class="anchor_style" href="<?php echo base_url()."sanitation/view_summary";?>">Sanitation Evaluation - Summary</a>
</button>
<?php } } ?>

</div> <?php
}
?>
<!--sanitation tab ends-->

<?php 
foreach($this->data['functions'] as $function){
			if($function->user_function=="login_report" || $function->user_function=="helpline_receiver" || $function->user_function=="dashboard" 
			 || $function->user_function=="edit_demographic" || $function->user_function=="delete_patient_visit_duplicate" 
			 || $function->user_function=="list_patient_visit_duplicate" || $function->user_function=="list_patient_edits" 
			 || $function->user_function=="edit_patient_visits" || $function->user_function=="list_edit_patient_visits"
			 || $function->user_function=="delete_patient_followup"){
				$admin=1;
				?>
				<button class="accordion">Admin</button>
<?php			break; }
		}
?>

<?php 

if($admin==1) { ?>
<div class="panel_accordion">
<?php
foreach($this->data['functions'] as $function){

if($function->user_function=="login_report" ){ ?>
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."reports/login_report";?>">Login Report</a></button>
<?php		 }

if($function->user_function=="helpline_receiver" ){ ?>
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."helpline/helpline_receivers";?>">Helpline Reciever</a></button>
<?php		 }

if($function->user_function=="edit_demographic" ){ ?>
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."patient/edit_patient_demographic_details";?>">Edit patient details</a></button>
<?php		 } 

if($function->user_function=="delete_patient_visit_duplicate"){ ?>
	<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."patient/delete_patient_visit_duplicate";?>">Delete patient visit duplicate</a></button>
<?php		 }

if($function->user_function=="list_patient_visit_duplicate"){ ?>
	<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."patient/list_patient_visit_duplicate";?>">List patient visit duplicate</a></button>
<?php		 }

if($function->user_function=="list_patient_edits"){ ?>
	<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."patient/list_patient_edits";?>">List patient edits</a></button>
<?php		 }

if($function->user_function=="edit_patient_visits"){ ?>
	<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."patient/edit_patient_visits";?>">Edit patient visit</a></button>
<?php		 }

if($function->user_function=="list_edit_patient_visits"){ ?>
	<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."patient/list_edit_patient_visits";?>">List patient visit edits</a></button>
<?php		 }

if($function->user_function=="delete_patient_followup"){ ?>
	<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."patient/delete_patient_followup";?>">Delete Patient Followup</a></button>
<?php		 }

		} ?>
</div> <?php
	}
?>
