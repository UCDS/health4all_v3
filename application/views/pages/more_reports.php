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
foreach($this->data['functions'] as $function){
			if($function->user_function=="OP Detail" || $function->user_function=="appointment_by_staff" || $function->user_function=="patient_location_report" || $function->user_function=="referral" || $function->user_function=="patient_follow_up"
			|| $function->user_function=="issue_list" || $function->user_function=="issue_summary" || $function->user_function=="followup_summary" || $function->user_function=="followup_map"){
				$appointments=1;
				
				?>
				<button class="accordion">Patients</button>
<?php			break;}
		}
		
if($appointments==1) { ?>
<div class="panel_accordion">
<?php
foreach($this->data['functions'] as $function){
			if($function->user_function=="OP Detail"){ ?>
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."reports/op_detail_3";?>">Out Patient Detail 3</a></button>
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."reports/op_detail_followup";?>">Out Patient Detail - Followup</a></button>
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."reports/visit_type_summary";?>">Visit Type Summary</a></button>
<?php		 }

if($function->user_function=="patient_follow_up"){ ?>
	<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."reports/followup_detail";?>">Followup List </a></button>
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

if($function->user_function== "followup_summary"){ ?>
		<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url(). "op_ip_report/followup_summary";?>">Followup Summary</a></button>
	
<?php } if($function->user_function== "issue_list"){ ?>
		<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"><a class="anchor_style" href="<?php echo base_url()."reports/issue_list";?>">Issue List</a></button>

<?php } if($function->user_function== "issue_summary"){ ?>
	<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"><a class="anchor_style" href="<?php echo base_url()."reports/issue_summary";?>">Issue Summary</a></button>

<?php } 

if($function->user_function== "followup_map"){ ?>
		<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url(). "op_ip_report/followup_map";?>">Followup Map</a></button>

<?php } } ?>
</div> <?php
	}
?>

<?php 
foreach($this->data['functions'] as $function){
			if($function->user_function=="missed_calls_report"){
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
		//	if($function->user_function=="completed_calls_report"){ ?>
		<!--		<button class="panel_button"> <a class="anchor_style" href="<?php echo base_url()."helpline/completed_calls_report";?>">Completed Calls</a></button> !-->
<?php //		 }

if($function->user_function=="missed_calls_report"){ ?>
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."helpline/missed_calls_report";?>">Missed Calls</a></button>
	<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."helpline/receiver_call_activity_report";?>">Receiver Call Activity Report</a></button>
<?php		 }


if($function->user_function=="dashboard" ){ ?>
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."dashboard/helpline_trend";?>">Trend</a></button>
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."dashboard/receiver";?>">Receivers</a></button>
				<button class="col-xs-12 col-sm-4 col-md-4 col-lg-4"> <a class="anchor_style" href="<?php echo base_url()."dashboard/helpline";?>">Dashboard</a></button>
				
				


<?php		 }

	}

 ?>
</div> <?php
	}
?>


<?php 
foreach($this->data['functions'] as $function){
			if($function->user_function=="login_report" || $function->user_function=="helpline_receiver" || $function->user_function=="dashboard" || $function->user_function=="edit_demographic"){
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


		} ?>
</div> <?php
	}
?>

