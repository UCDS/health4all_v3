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
foreach($this->data['functions'] as $function){
			if($function->user_function=="OP Detail" || $function->user_function=="appointment_by_staff"){
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
				<button class="panel_button"> <a class="anchor_style" href="<?php echo base_url()."reports/op_detail_3";?>">Out Patient Detail 3</a></button>
<?php		 }

if($function->user_function=="appointment_by_staff"){ ?>
				<button class="panel_button"> <a class="anchor_style" href="<?php echo base_url()."reports/appointment_summary_by_volunteer";?>">Appointments by Team Member</a></button>
<?php		 }

		} ?>
</div> <?php
	}
?>
<?php 
foreach($this->data['functions'] as $function){
			if($function->user_function=="completed_calls_report" || $function->user_function=="missed_calls_report"){
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
				<button class="panel_button"> <a class="anchor_style" href="<?php echo base_url()."helpline/missed_calls_report";?>">Missed Calls</a></button>
<?php		 }

		} ?>
</div> <?php
	}
?>

