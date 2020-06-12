<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >

<script type="text/javascript">
$(function(){
	$(".date").Zebra_DatePicker();
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
  });
</script>

<div class="row">
	<?php if(isset($msg) && !!$msg) { ?>
		<div class="alert alert-info">
			<?php echo $msg; ?>
		</div>
	<?php } ?>

	<?php
			if($this->input->post('from_date')){
				$from_date = date("d-M-Y",strtotime($this->input->post('from_date')));
			}
			else $from_date = date("d-M-Y");
			if($this->input->post('to_date')){
				$to_date = date("d-M-Y",strtotime($this->input->post('to_date')));
			}
			else $to_date = date("d-M-Y");
			echo form_open('helpline/report_groupwise',array('role'=>'form','class'=>'form-custom'));
	?>
			<h4>Calls Group during
				<input type="text" class="date form-control" value="<?php echo $from_date;?>" name="from_date" /> to 
				<input type="text" class="date form-control" value="<?php echo $to_date;?>" name="to_date" />
				<select name="helpline_id" style="width:300px" class="form-control">
					<option value="">Helpline</option>
					<?php foreach($helpline as $line){ ?>
						<option value="<?php echo $line->helpline_id;?>"
						<?php if($this->input->post('helpline_id') == $line->helpline_id) echo " selected "; ?>
						><?php echo $line->helpline.' - '.$line->note;?></option>
					<?php } ?>
				</select>
			<input type="submit" value="Go" name="submit" class="btn btn-primary btn-sm" /></form></h4>
	<?php
		if(!!$calls){
	?>
		<table class="table table-striped table-bordered" id="table-sort">
			<thead>
				<th>#</th>
				<th>Call ID</th>
				<th>Call</th>
				<th>From-To</th>
				<th>Recording</th>
				<th>Caller Type</th>
				<th>Call Category</th>
				<th>Call Group</th>
				<th>Resolution Status</th>
				<th>Resolution Time</th>
				<th>TAT</th>
				<th>Hospital</th>
				<th>Patient</th>
				<th>Note</th>
				<th>Emails</th>
			</thead>
			<?php
				foreach($groups as $group){ ?>
				<thead>
					<th colspan="20"><h4><?php if(!!$group->group_name) echo $group->group_name; else echo "Ungrouped Calls";?></h4></th>
				</thead>
				<?php
				$i=1;
				foreach($calls as $call){
					if($call->call_group_id == $group->call_group_id) {?>
					<tbody>
					<tr>
						<td>
							<?php echo $i++;?>
						</td>
						<td>
							<?php echo $call->call_id;?>
						</td>
						<td>
							<?php if($call->call_type == "incomplete") { ?>
								<span class="glyphicon glyphicon-arrow-left" style="color:red" title="Missed Call"></span>
							<?php }
							else if($call->call_type == "client-hangup"){ ?>
								<span class="glyphicon glyphicon-arrow-left" style="color:red" title="Client Hangup"></span>
							<?php }
							else if($call->direction == "incoming"){ ?>
								<span class="glyphicon glyphicon-arrow-left" style="color:green" title="Incoming"></span>
							<?php }
							else if($call->direction == "outbound-dial"){ ?>
								<span class="glyphicon glyphicon-arrow-right" style="color:green" title="Outgoing"></span>
							<?php } ?>
							<small>
								<?php echo $call->dial_call_duration;?><br />
								<?php echo date("d-M-Y g:iA",strtotime($call->start_time));?>
							</small>
						</td>
						<td>
							<small><?php echo $call->from_number;?><br />
							<?php echo $call->to_number;?>
							</small>
						</td>
						<td><small><?php echo $call->dial_whom_number;?>
							<audio controls preload="none">
								<source src="<?php echo $call->recording_url;?>" type="audio/mpeg">
								Your browser does not support the audio element.
							</audio>
							</small>
						</td>
						<td>
							<?php echo $call->caller_type;?>
						</td>
						<td>
							<?php echo $call->call_category;?>
						</td>
						<td>
								<?php echo $call->group_name; ?>
						</td>
						<td>
							<?php echo $call->resolution_status;?>
						</td>
						<td>
							<small>
							<?php if($call->resolution_date_time != 0) echo date("d-M-Y g:i A",strtotime($call->resolution_date_time)); else echo '';?>
							</small>
						</td>
						<td>
							<small>
								<?php if($call->resolution_date_time != 0){
									$diff = date_diff(date_create($call->resolution_date_time),date_create($call->start_time));
									if($diff->y != 0) echo $diff->y." Y, ".$diff->m." Months";
									else if($diff->m != 0) echo $diff->m." Months, ".$diff->d." Days";
									else if($diff->d != 0) echo $diff->d." Days, ".$diff->h." Hours";
									else if($diff->h != 0) echo $diff->h." Hours, ".$diff->i." Mins";
									else if($diff->i != 0) echo $diff->i." Mins";
									}
								?>
							</small>
						</td>
						<td>
							<?php echo $call->hospital;?>
						</td>
						<td>
							<?php echo $call->ip_op;?> <?php if($call->visit_id !=0) echo "#".$call->visit_id;?>
						</td>
						<td>
							<?php echo $call->note;?>
						</td>
						<td>
							<?php if($call->email_count > 0) { ?>
							<a href="#" onclick="display_emails(<?= $call->call_id;?>)"  data-toggle="modal" data-target="#emailModal"><i class="fa fa-envelope"></i> (<?= $call->email_count;?>)</a>
							<div class="emails_sent_<?= $call->call_id;?> sr-only">
							<?php foreach($emails_sent as $email) {
								if($email->call_id == $call->call_id) {
								$to_email = $email->to_email;
								$cc_email = $email->cc_email;
								$from_name = "Hospital Helpline";
								$subject="Helpline call #$email->call_id - ";
								if(!!$call->call_category) $subject .= $call->call_category." ";
								if(!!$call->hospital) $subject .= "from ".$call->hospital." ";
								if(!!$call->caller_type) $subject .= "by ".$call->caller_type." ";
								if(!!$call->ip_op && $call->visit_id !=0 ) $subject .= "regarding ".$call->ip_op." #".$call->visit_id." ";
								$body = date("d-M-Y g:iA",strtotime($email->email_date_time))."<br /><br />";
								$body.="
								<b>To: </b>$to_email
								<br />
								<b>Cc: </b>$cc_email
								<br />
								<b>Subject: </b>$subject <br /> <br />";
								if(!!$email->greeting){ $body .= $email->greeting; } else $body .= "Hi,";
								$body.="<br /><br />This call information from Hospital Helpline (040 - 39 56 53 39) is being escalated for your information and intervention.<br /><br />";
								$body.="<b>Call ID:</b> $email->call_id <br />";
								$body.="<b>Call Time:</b> ".date("d-M-Y, g:iA",strtotime($call->start_time))." <br />";
								$body.="<b>Call:</b> ";
								if(!!$call->call_category) $body .= $call->call_category." ";
								if(!!$call->hospital) $body .= "from ".$call->hospital." ";
								if(!!$call->caller_type) $body .= "by ".$call->caller_type." ";
								if(!!$email->phone_shared) $body.="(".$call->from_number.") ";
								if(!!$call->ip_op && $call->visit_id !=0) $body .= "regarding ".$call->ip_op." #".$call->visit_id." ";
								$body.="<br />";
								$body.="<b>Call Information:</b> $email->note <br />";
								$body.="<b>Recording:</b> <a href=\"$call->recording_url\">Click Here</a><br /><br />";
								$body.="We request you to give your input regarding this call by calling the helpline 040 - 39 56 53 39 or by replying to this email.<br /><br />";
								$body.="With Regards, <br />Hospital Helpline Team";
								$mailbody="
								<div style='width:90%;padding:5px;margin:5px;font-style:\"Trebuchet MS\";border:1px solid #eee;'>
								<br />$body
								</div>";
								echo $mailbody;
								}
							}
							?>
							</div>
							<?php } ?>
						</td>
					</tr>
				</tbody>
				<?php }
				}
			}
				?>
			</table>
		<?php
			echo form_close();
			}
		else{
			echo "No calls on the given day.";
		}
		?>
</div>


<!-- Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document" style="width:90%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Email</h4>
      </div>
      <div class="modal-body">
	  </div>
	 </div>
	</div>
</div>

<script type="text/javascript">
function display_emails(callId){
	$(".modal-body").html($(".emails_sent_"+callId).html());
}
</script>
