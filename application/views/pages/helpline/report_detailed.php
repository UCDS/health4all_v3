<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/selectize.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/selectize.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>

<script type="text/javascript">
function doPost(page_no){	
	var page_no_hidden = document.getElementById("page_no");
  	page_no_hidden.value=page_no;
        $('#call_detailed_report').submit();   
   }
function onchange_page_dropdown(dropdownobj){
   doPost(dropdownobj.value);    
}
</script>
<style type="text/css">
.page_dropdown{
    position: relative;
    float: left;
    padding: 6px 12px;
    width: auto;
    height: 34px;
    line-height: 1.428571429;
    text-decoration: none;
    background-color: #ffffff;
    border: 1px solid #dddddd;
    margin-left: -1px;
    color: #428bca;
    border-bottom-right-radius: 4px;
    border-top-right-radius: 4px;
    display: inline;
}
.page_dropdown:hover{
    background-color: #eeeeee;
    color: #2a6496;
 }
.page_dropdown:focus{
    color: #2a6496;
    outline:0px;	
}
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
.rows_per_page{
    display: inline-block;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.428571429;
    color: #555555;
    vertical-align: middle;
    background-color: #ffffff;
    background-image: none;
    border: 1px solid #cccccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    -webkit-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
}
.rows_per_page:focus{
    border-color: #66afe9;
    outline: 0;	
}
</style>
<style>
	.call_now_img{
	    cursor: pointer;
	    padding-top: 5px;
	    color: #5cb85c;
	}
	.call_now_img .fa-phone{
		border: 1px solid #5cb85c;
	    border-radius: 50%;
	    width: 40px;
	    height: 40px;
	    padding: 8px 4px 5px 4px;
	}
	.hidden{
		display: none; 
		visibility: hidden;
	}
	.line-through{
		text-decoration: line-through;
	}
	.error{
		color: red;
		font-size: 12px;
	}
</style>
<script type="text/javascript">
var user_details = <?php echo $user_details; ?>;
var departments = <?php echo json_encode($department); ?>;
var hospitals = <?php echo json_encode($all_hospitals); ?>;
var userHospitals = <?php echo json_encode($user_hospitals); ?>;
var callCategory = <?php echo json_encode($call_category); ?>;
var updatableHelplines = <?php echo json_encode($updatable_helpline); ?>;
var receiver = user_details.receiver;
var callData = <?php echo json_encode($calls); ?>;
var callDetails = {};
var smsDetails = {};

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
<!--
<div class="row">
	<?php // if(!!$msg) { ?>
		<div class="alert alert-info">
			<?php // echo $msg; ?>
		</div>
	<?php // } ?>
	-->

	<?php
			$page_no = 1;
			foreach($defaultsConfigs as $default){	
				// var_dump($default);	 
		 	if($default->default_id=='pagination'){
		 			$rowsperpage = $default->value;
		 			$upper_rowsperpage = $default->upper_range;
		 			$lower_rowsperpage = $default->lower_range;
		 		}
			}	
			if($this->input->post('from_date')){
				$from_date = date("d-M-Y",strtotime($this->input->post('from_date')));
			}
			else $from_date = date("d-M-Y");
			if($this->input->post('to_date')){
				$to_date = date("d-M-Y",strtotime($this->input->post('to_date')));
			}
			else $to_date = date("d-M-Y");
			echo form_open('helpline/detailed_report',array('role'=>'form','class'=>'form-custom','id'=>'call_detailed_report','name'=>'call_detailed_report' ));
	?>
			<h4>Calls during</h4>
			<input type="text" style="width:120px" class="date form-control" value="<?php echo $from_date;?>" name="from_date" /> to 
			<input type="text" style="width:120px" class="date form-control" value="<?php echo $to_date;?>" name="to_date" />

			<select name="helpline_id" id="helplineSelect" style="width:170px" class="form-control">
				<option value="">Helpline</option>
				<?php foreach($helpline as $line){ ?>
					<option value="<?php echo $line->helpline_id;?>"
					<?php if($this->input->post('helpline_id') == $line->helpline_id) echo " selected "; ?>
					><?php echo $line->helpline.' - '.$line->note;?></option>
				<?php } ?>
			</select>
			<select name="call_direction" style="width:130px" class="form-control">
					<option value="">Call Direction</option>
					<option <?php if($this->input->post('call_direction') == "incoming") echo " selected "; ?> value="incoming">Incoming calls</option>
					<option <?php if($this->input->post('call_direction') == "outbound-dial") echo " selected "; ?> value="outbound-dial">Outgoing calls</option>
			</select>
			<select name="call_type" style="width:120px" class="form-control">
					<option value="">Call Type</option>
					<option <?php if($this->input->post('call_type') == "completed") echo " selected "; ?> value="completed">Completed</option>
					<option <?php if($this->input->post('call_type') == "client-hangup") echo " selected "; ?> value="client-hangup">Client Hangup</option>
					<option <?php if($this->input->post('call_type') == "voicemail") echo " selected "; ?> value="voicemail">Voicemail</option>
					<option <?php if($this->input->post('call_type') == "incomplete") echo " selected "; ?> value="incomplete">Incomplete</option>
					<option <?php if($this->input->post('call_type') == "call-attempt") echo " selected "; ?> value="call-attempt">Call Attempt</option>
			</select>
			
			<input type="text" class="form-control" placeholder="From Number" style="width:120px"  value="<?php echo $this->input->post('from_number');?>" name="from_number" />
			<input type="text" class="form-control" placeholder="To Number"  style="width:120px"  value="<?php echo $this->input->post('to_number');?>" name="to_number" />
			<select name="caller_type" style="width:120px" class="form-control">
				<option value="">Caller</option>
				<?php foreach($caller_type as $ct){ ?>
					<option value="<?php echo $ct->caller_type_id;?>"
					<?php if($this->input->post('caller_type') == $ct->caller_type_id) echo " selected "; ?>
					><?php echo $ct->caller_type;?></option>
				<?php } ?>
			</select>
			<select name="language" style="width:120px" class="form-control">
				<option value="">Language</option>
				<?php foreach($language as $lng){ ?>
					<option value="<?php echo $lng->language_id;?>"
					<?php if($this->input->post('language') == $lng->	language_id) echo " selected "; ?>
					><?php echo $lng->language;?></option>
				<?php } ?>
			</select>
			<select name="state" id="state" style="width:120px" class="form-control" onchange='onchange_state_dropdown(this)'>
				<option value="">State</option>
				<?php foreach($all_states as $state){ ?>
					<option value="<?php echo $state->state_id;?>"
					<?php if($this->input->post('state') && $this->input->post('state') == $state->state_id) echo " selected "; ?>
					><?php echo $state->state;?></option>
				<?php } ?>
			</select>
			<select name="district" id="district" style="width:120px" class="form-control">
				<option value="">District</option>
			</select>
			<select id="hospitalSelect" name="helpline_hospital" style="width:100px" class="form-control">
				<option value="">Hospital</option>
			</select>
			<select id="departmentSelect" name="helpline_department" style="width:100px" class="form-control">
				<option value="">Department</option>
			</select>
			<select name="call_category" style="width:150px" class="form-control">
				<option value="">Category</option>
				<?php foreach($call_category as $cc){ ?>
					<option value="<?php echo $cc->call_category_id;?>"
					<?php if($this->input->post('call_category') == $cc->call_category_id) echo " selected "; ?>									
					><?php echo $cc->call_category;?></option>
				<?php } ?>
			</select>
			<select name="resolution_status" style="width:150px" class="form-control">
				<option value="">Status</option>
				<?php foreach($resolution_status as $status){ ?>
					<option value="<?php echo $status->resolution_status_id;?>"
					<?php if($this->input->post('resolution_status') == $status->resolution_status_id) echo " selected "; ?>
					><?php echo $status->resolution_status;?></option>
				<?php } ?>
			</select>
			<input type="hidden" name="page_no" id="page_no" value='<?php echo "$page_no"; ?>'>	
			 Rows per page : <input type="number" class="rows_per_page" name="rows_per_page" id="rows_per_page" min=<?php echo $lower_rowsperpage; ?> max= <?php echo $upper_rowsperpage; ?> step="1" value= <?php if($this->input->post('rows_per_page')) { echo $this->input->post('rows_per_page'); }else{echo $rowsperpage;}  ?> onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" /> 
			 <br />
			<input type="submit" value="Go" name="submitBtn" class="btn btn-primary btn-sm" />
			<button type="button" class="btn btn-primary btn-sm call_button" onclick="openCallModal()" style="display: none;"><i class="fa fa-phone" style="padding-right: 5px;"></i> Call</button>
			<?php if ($add_sms_access==1){ ?>
			<button type="button" class="btn btn-primary btn-sm sms_button" onclick="openSmsModal()" style="display: none;"><i class="fa fa-envelope-o" style="padding-right: 5px;"></i> SMS</button>
			<?php } ?>

		</form></h4><br />
	<?php
		if(!!$calls){
	?>
	<div style='padding: 0px 2px;'>

<h5>Report as on <?php echo date("j-M-Y h:i A"); ?></h5>

</div>
	<?php 
	if ($this->input->post('rows_per_page')){
		$total_records_per_page = $this->input->post('rows_per_page');
	}else{
		$total_records_per_page = $rowsperpage;
	}

	if ($this->input->post('page_no')) { 
		$page_no = $this->input->post('page_no');
	}
	else{
		$page_no = 1;
	}
	$tmp_count = 0;
	foreach($calls_count as $count){
		$tmp_count = $tmp_count + 1;
	}
	$total_records = $tmp_count;		
	$total_no_of_pages = ceil($total_records / $total_records_per_page);
	if ($total_no_of_pages==0)
		$total_no_of_pages = 1;
	$second_last = $total_no_of_pages - 1; 
	$offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2";	
?>

<ul class="pagination" style="margin:0">
<?php if($page_no > 1){
echo "<li><a href=# onclick=doPost(1)>First Page</a></li>";
} ?>

<li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
<a <?php if($page_no > 1){
echo "href=# onclick=doPost($previous_page)";

} ?>>Previous</a>
</li>
<?php
  if ($total_no_of_pages <= 10){  	 
	for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
	if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	        }else{
        echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
                }
        }
}
else if ($total_no_of_pages > 10){
	if($page_no <= 4) {			
 		for ($counter = 1; $counter < 8; $counter++){		 
		if ($counter == $page_no) {
	   		echo "<li class='active'><a>$counter</a></li>";	
		}else{
           		echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
                }
}

echo "<li><a>...</a></li>";
echo "<li><a href=# onclick=doPost($second_last)>$second_last</a></li>";
echo "<li><a href=# onclick=doPost($total_no_of_pages)>$total_no_of_pages</a></li>";
}
elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
echo "<li><a href=# onclick=doPost(1)>1</a></li>";
echo "<li><a href=# onclick=doPost(2)>2</a></li>";
echo "<li><a>...</a></li>";
for (
     $counter = $page_no - $adjacents;
     $counter <= $page_no + $adjacents;
     $counter++
     ) {		
     if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	}else{
        echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
          }                  
       }
echo "<li><a>...</a></li>";
echo "<li><a href=# onclick=doPost($counter) >$counter</a></li>";
echo "<li><a href=# onclick=doPost($total_no_of_pages)>$total_no_of_pages</a></li>";
}
else {
echo "<li><a href=# onclick=doPost(1)>1</a></li>";
echo "<li><a href=# onclick=doPost(2)>2</a></li>";
echo "<li><a>...</a></li>";
for (
     $counter = $total_no_of_pages - 6;
     $counter <= $total_no_of_pages;
     $counter++
     ) {
     if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	}else{
        echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
	}                   
     }
}
}  
?>
<li <?php if($page_no >= $total_no_of_pages){
echo "class='disabled'";
} ?>>
<a <?php if($page_no < $total_no_of_pages) {
echo "href=# onclick=doPost($next_page)";
} ?>>Next</a>
</li>

<?php if($page_no < $total_no_of_pages){
echo "<li><a href=# onclick=doPost($total_no_of_pages)>Last Page</a></li>";
} ?>
<?php if($total_no_of_pages > 0){
echo "<li><select class='page_dropdown' onchange='onchange_page_dropdown(this)'>";
for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                  echo "<option value=$counter ";
                  if ($page_no == $counter){
                   echo "selected";
                  }         
                  echo ">$counter</option>";
	}
echo "</select></li>";
} ?>
</ul>


<div style='padding: 0px 2px;'>

<h5>Page <?php echo $page_no." of ".$total_no_of_pages." (Total ".$total_records.")" ; ?></h5>

</div>
		<table class="table table-striped table-bordered" id="table-sort">
			<colgroup>
				<col style="width: 1.3%;">
				<col style="width: 3.1%;">
				<col style="width: 3.7%;">
				<col style="width: 6.2%;">
				<col style="width: 29.1%;">
				<col style="width: 15%;">
				<col style="width: 3.8%;">
				<col style="width: 5.8%;">
				<col style="width: 6.7%;">
				<col style="width: 6.7%;">
				<col style="width: 2.7%;">
			</colgroup>
			<thead>
				<th>#</th>
				<th>Call ID</th>
				<th>Call</th>
				<th>Customer</th>
				<th>Team Member @ Helpline</th>
				<th>Caller Type</th>
				<th>Language</th>
				<th>District, State</th>
				<th>Hospital</th>
				<th>Department</th>
				<th>Call Category</th>
				<th>Resolution Status</th>
				<!-- <th class="hidden">Resolution Time</th>
				<th class="hidden">TAT</th> -->
				<!-- <th>Hospital</th>
				<th>Patient</th> -->
				<th>Emails</th>
			</thead>
			<tbody>
			<?php
				$i=(($page_no - 1)* $total_records_per_page) + 1;
				foreach($calls as $call){ ?>
					<tr>
						<td>
							<?php echo $i++;?>
						</td>
						<td>
							<?php echo $call->call_id;?>
							<?php 
							foreach($updatable_helpline as $updatable)
							{ 							
								if($updatable->helpline_id == $call->helpline_id) { ?>
									<button class="editCall btn btn-primary btn-sm" onClick="openEditModal(this)" data-id="<?php echo $call->call_id;?>" style="margin-bottom: 8px">Update</button>
							<?php
									break;
								}
							} ?>
							<button class="sendEmail btn btn-primary btn-sm" onClick="openSendEmailModal(this)" disabled data-id="<?php echo $call->call_id;?>">Email</button>
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
								<span class="glyphicon glyphicon-arrow-right" style="color:orange" title="Outgoing"></span>
							<?php } ?>
							<small>
								<?php echo $call->dial_call_duration;?><br />
								<?php echo date("d-M-Y g:iA",strtotime($call->start_time));?>
							</small>
						</td>
						<td class="text-center">
							<small><?php echo $call->from_number;?></small>
							<p class="call_now_img call_button" onclick="openCallModalOnRowClick('<?php echo $call->from_number;?>', '<?php echo $call->to_number;?>', '<?php echo $call->line_note; ?>', '<?php echo $call->note;?>')" title="Click to Initiate Call" data-toggle="tooltip" style="display: none;"><i class="fa fa-phone fa-2x"></i></p>
						</td>
						<td><small><?php echo $call->short_name.'&nbsp;-&nbsp;'.$call->dial_whom_number;?>&nbsp;@&nbsp;<?php echo $call->line_note; ?> - <?php echo $call->to_number;?>
							<audio controls preload="none">
								<source src="<?php echo $call->recording_url;?>" type="audio/mpeg">
								Your browser does not support the audio element.
							</audio>
							</small>
							<?php echo $call->note;?>
						</td>						
						<td>
							<?php echo $call->caller_type;?>
						</td>
						<td >
							<?php echo $call->language;?>
						</td>
						<td >
						
							<?php if($call->district && $call->state) {
							echo $call->district.", ".$call->state;
							}
							 ?>
						</td>
						<td >
							<?php echo $call->hospital_short_name;?>
						</td>
						<td >
							<?php echo $call->department;?>
						</td>
						<td >
							<?php echo $call->call_category;?>
						</td>
						<td >
							<?php echo $call->resolution_status;?>
						</td>
						<td class="hidden">
							<small>
							<?php if($call->resolution_date_time != 0) echo date("d-M-Y g:i A",strtotime($call->resolution_date_time)); else echo '';?>
							</small>
						</td>
						<td class="hidden">
							<small>
								<?php 
								
								
								if($call->resolution_date_time != 0){
									$diff = date_diff(date_create($call->resolution_date_time),date_create($call->start_time));
									if($diff->y != 0) echo $diff->y." Y, ".$diff->m." Months";
									else if($diff->m != 0) echo $diff->m." Months, ".$diff->d." Days";
									else if($diff->d != 0) echo $diff->d." Days, ".$diff->h." Hours";
									else if($diff->h != 0) echo $diff->h." Hours, ".$diff->i." Mins";
									else if($diff->i != 0) echo $diff->i." Mins";
									}
								?>
							</small>
						</td class="hospital">
						<!-- <td>
							<?php echo $call->hospital;?>
						</td>
						<td>
							<?php echo $call->ip_op;?> <?php if($call->visit_id !=0) echo "#".$call->visit_id;?>
						</td> -->
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
				<?php }
				?>
				</tbody>
			</table>
			<div style='padding: 0px 2px;'>

<h5>Page <?php echo $page_no." of ".$total_no_of_pages." (Total ".$total_records.")" ; ?></h5>

</div>

<ul class="pagination" style="margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 20px;
    margin-left: 0px;">
<?php if($page_no > 1){
echo "<li><a href=# onclick=doPost(1)>First Page</a></li>";
} ?>

<li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
<a <?php if($page_no > 1){
echo "href=# onclick=doPost($previous_page)";

} ?>>Previous</a>
</li>
<?php
  if ($total_no_of_pages <= 10){  	 
	for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
	if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	        }else{
        echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
                }
        }
}
else if ($total_no_of_pages > 10){
	if($page_no <= 4) {			
 		for ($counter = 1; $counter < 8; $counter++){		 
		if ($counter == $page_no) {
	   		echo "<li class='active'><a>$counter</a></li>";	
		}else{
           		echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
                }
}

echo "<li><a>...</a></li>";
echo "<li><a href=# onclick=doPost($second_last)>$second_last</a></li>";
echo "<li><a href=# onclick=doPost($total_no_of_pages)>$total_no_of_pages</a></li>";
}
elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
echo "<li><a href=# onclick=doPost(1)>1</a></li>";
echo "<li><a href=# onclick=doPost(2)>2</a></li>";
echo "<li><a>...</a></li>";
for (
     $counter = $page_no - $adjacents;
     $counter <= $page_no + $adjacents;
     $counter++
     ) {		
     if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	}else{
        echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
          }                  
       }
echo "<li><a>...</a></li>";
echo "<li><a href=# onclick=doPost($counter) >$counter</a></li>";
echo "<li><a href=# onclick=doPost($total_no_of_pages)>$total_no_of_pages</a></li>";
}
else {
echo "<li><a href=# onclick=doPost(1)>1</a></li>";
echo "<li><a href=# onclick=doPost(2)>2</a></li>";
echo "<li><a>...</a></li>";
for (
     $counter = $total_no_of_pages - 6;
     $counter <= $total_no_of_pages;
     $counter++
     ) {
     if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	}else{
        echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
	}                   
     }
}
}  
?>
<li <?php if($page_no >= $total_no_of_pages){
echo "class='disabled'";
} ?>>
<a <?php if($page_no < $total_no_of_pages) {
echo "href=# onclick=doPost($next_page)";
} ?>>Next</a>
</li>

<?php if($page_no < $total_no_of_pages){
echo "<li><a href=# onclick=doPost($total_no_of_pages)>Last Page</a></li>";
} ?>
<?php if($total_no_of_pages > 0){
echo "<li><select class='page_dropdown' onchange='onchange_page_dropdown(this)'>";
for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                  echo "<option value=$counter ";
                  if ($page_no == $counter){
                   echo "selected";
                  }         
                  echo ">$counter</option>";
	}
echo "</select></li>";
} ?>
</ul>
		<?php
			echo form_close();
			}
		else{
			echo "No calls on the given day.";
		}
		?>
</div>


<!-- Modal -->
<div class="modal fade" id="emailModal" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel">
  <div class="modal-dialog" role="document" style="width:90%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="emailModalLabel">Email</h4>
      </div>
      <div class="modal-body" id="emailModalBody"></div>
	 </div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="callModal" tabindex="-1" role="dialog" aria-labelledby="callModalLabel">
  <div class="modal-dialog" role="document" style="width:90%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="callModalLabel">Call</h4>
      </div>
      <div class="modal-body" id="callModalBody">
      	<div class="row">							
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
				<div class="form-horizontal">
					<label for="callModal-customer">Call<font style="color:red">*</font></label>
					<input type="text" class="form-control" id="callModal-customer" placeholder="Enter '0' followed by 10 digit phone number" required readonly onblur="setFromNumber()" />
					<p class="error callModal-customer-error">This field is required</p>
				</div>
			</div>		

			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
				<div class="form-horizontal">
					<label for="callModal-helplinewithname">Through Helpline<font style="color:red">*</font></label>
					<input type="text" class="form-control" id="callModal-helplinewithname" required readonly />
					<select class="form-control" id="callModal-helplinewithname-dropdown" style="display: none" onchange="setHelplineNumber()"></select>
					<input type="hidden" id="callModal-helpline" />
				</div>
			</div>
		</div>
		<div class="row" style="margin-top: 20px;">
			<div class="col-xs-12">
				<div class="form-horizontal">
					<label for="callModal-connectto">Connect to<font style="color:red">*</font></label>
					<p id="callModal-connectto"></p>
					<p id="callModal-connectto-updated"></p>
					<a href="#change_connectto">Change</a>

					<div id="change_connectto_section" class="hidden">
						<input type="radio" id="callModal-connectto-radio-doctor" name="radio_doctor" value="1" />
						<label for="callModal-connectto-radio-doctor" style="margin-right: 20px;">Doctor</label>

						<input type="radio" id="callModal-connectto-radio-nondoctor" name="radio_doctor" value="0" />
						<label for="callModal-connectto-radio-nondoctor">Non-Doctor</label>
					</div>

					<div id="callModal_connectto_alternate_section">
						<select id="callModal-connectto-alternate" required style="margin-right: 20px;" onchange="updateConnectto()"></select>
						<input type="checkbox" id="callModal-connectto-alternate-showmore" value="1" />
						<label for="callModal-connectto-alternate-showmore">Show More</label>
					</div>
				</div>
				<p class="error callModal-app_id-error">Call cannot be placed without app id</p>
			</div>
		</div>
		<div class="row" style="margin-top: 20px;">
			<div class="col-xs-12">
				<input id="initiateCallButton" type="button" value="Call" class="btn btn-primary btn-sm" onclick="initiateCall()" />
			</div>
		</div>
      </div>
	 </div>
	</div>
</div>
<?php include_once("update_call_modal.php") ?>
<!-- Modal -->
<div class="modal fade" id="smsModal" tabindex="-1" role="dialog" aria-labelledby="smsModalLabel">
  <div class="modal-dialog" role="document" style="width:90%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="smsModalLabel">SMS</h4>
      </div>
      <div class="modal-body" id="smsModalBody">
      	<div class="row">							
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
				<div class="form-horizontal">
					<label for="smsModal-customer">SMS To<font style="color:red">*</font></label>
					<input type="text" class="form-control" id="smsModal-customer" placeholder="Enter '0' followed by 10 digit phone number" required readonly onblur="setSmsToNumber()" />
					<p class="error smsModal-customer-error">This field is required</p>
				</div>
			</div>		

			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
				<div class="form-horizontal">
					<label for="smsModal-helplinewithname">Through Helpline<font style="color:red">*</font></label>
					<input type="text" class="form-control" id="smsModal-helplinewithname" required readonly />
					<select class="form-control" id="smsModal-helplinewithname-dropdown" style="display: none" onchange="setSmsHelplineNumber()"></select>
					<input type="hidden" id="smsModal-helpline" />
				</div>
			</div>
			<!--<?php
				echo("<script>console.log('PHP: " . json_encode($sms_templates) . "');</script>");
			?>-->
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
				<div class="form-horizontal">
					<label for="smsModal-templatewithname">Template<font style="color:red">*</font></label>
					<input type="text" class="form-control" id="smsModal-templatewithname" required readonly />
					<select class="form-control" id="smsModal-templatewithname-dropdown" style="display: none" onchange="setSmsTemplateName()"></select>
					<input type="hidden" id="smsModal-helpline" />
				</div>
			</div>			
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
				<div class="form-horizontal">
					<label for="smsModal-template">SMS Content<font style="color:red">*</font></label>
					<textarea class="form-control" id="smsModal-template"  required rows="8" onblur=smsTemplate()></textarea>
					<p class="error smsModal-template-error">This field is required</p>
				</div>
			</div>	
			<script type="text/javascript">

			var smstemplate='<?php echo json_encode($sms_templates); ?>';
			var inputF = document.getElementById("smsModal-template");
			var json=JSON.parse(smstemplate);

			function setSmsTemplate(helpline_id){
				smsDetails.templateName=$('#smsModal-templatewithname-dropdown').val();
				document.getElementById('smsModal-template').readOnly = false;
				for (var key in json) {
					if (json.hasOwnProperty(key)) {
						if(json[key].helpline_id==helpline_id&& json[key].sms_template_id == smsDetails.templateName){
							if (json[key].edit_text_area==0){
								document.getElementById('smsModal-template').readOnly = true;
							}
							inputF.value=json[key].template;
							smsDetails.template=json[key].template;
							smsDetails.sms_type=json[key].sms_type;
							smsDetails.template_name=json[key].sms_template_id;
							smsDetails.dlt_tid=json[key].dlt_tid;
							smsDetails.dlt_entity_id=json[key].dlt_entity_id;
						}
					}
				}
			}

			function setSmsTemplateWithName(helpline_id, templateName){
				document.getElementById('smsModal-template').readOnly = false;
				for (var key in json) {
					if (json.hasOwnProperty(key)) {
						if(json[key].helpline_id==helpline_id && json[key].sms_template_id == templateName ){
							document.getElementById("smsModal-template").value=json[key].template;
							if (json[key].edit_text_area==0){
								document.getElementById('smsModal-template').readOnly = true;
							}
							smsDetails.template=json[key].template;
							smsDetails.sms_type=json[key].sms_type;
							smsDetails.template_name=json[key].sms_template_id;
							smsDetails.dlt_tid=json[key].dlt_tid;
							smsDetails.dlt_entity_id=json[key].dlt_entity_id;
							smsDetails.dlt_header = json[key].dlt_header;
						}
					}
				}				
			}

			function setSmsTemplateName(){
				smsDetails.templateName = $('#smsModal-templatewithname-dropdown').val();
				smsDetails.called_id = $('#smsModal-helplinewithname-dropdown').val();
				setSmsTemplateWithName(smsDetails.called_id, smsDetails.templateName);
			}

			function smsTemplate(){
			    smsDetails.template=$('#smsModal-template').val();
			}

			function setSmsHelplineNumber(){
				smsDetails.called_id = $('#smsModal-helplinewithname-dropdown').val();
				document.getElementById("smsModal-templatewithname-dropdown").innerHTML = null; 
				for (var key in json) {
					if (json.hasOwnProperty(key)) {
						if(json[key].helpline_id==smsDetails.called_id){
						if ($("select[id$='smsModal-templatewithname-dropdown'] option:contains('" + json[key].template_name + "')").length == 0) {
                $('#smsModal-templatewithname-dropdown').append('<option value="'+json[key].sms_template_id+'">'+json[key].template_name+'</option>');
            }
														
						}
					}
				}
				setSmsTemplateName();
			}
			</script>
		</div>
		<div class="row" style="margin-top: 20px;">
			<div class="col-xs-12">
				<input id="initiateSmsButton" type="button" value="Send" class="btn btn-primary btn-sm" onclick="initiateSms()" />
			</div>
		</div>
      </div>
	 </div>
	</div>
</div>

<script type="text/javascript">


function onchange_state_dropdown(dropdownobj) {       	
	const stateID = dropdownobj.value;
	populateDistricts(stateID);		
}
	
function populateDistricts(stateID) {
	var optionsHtml = getDistrictOptionsState(stateID);
	$("#district").html(optionsHtml);		
}
	
function getDistrictOptionsState(stateID) {
	var all_districts = JSON.parse('<?php echo json_encode($districts); ?>'); 
	var selected_districts = all_districts.filter(all_districts => all_districts.state_id == stateID);
	let optionsHtml = buildEmptyOption("District");
	if(selected_districts.length > 0) {
		optionsHtml += selected_districts.map(selected_districts => {
				return `	<option value="${selected_districts.district_id}">
						${selected_districts.district}
					</option>`;
	   });
			
        }
	return optionsHtml;
}
function display_emails(callId){
	$("#emailModalBody").html($(".emails_sent_"+callId).html());
}

async function openCallModalOnRowClick(from, to, to_name, note){
	if(!note){
		let flag = await new Promise((resolve) => {
			bootbox.confirm({
			    message: "Please update Note to make this call?",
			    buttons: {
			        confirm: {
			            label: 'Ignore',
			            className: 'btn-warning'
			        },
			        cancel: {
			            label: 'OK',
			            className: 'btn-success'
			        }
			    },
			    callback: function (result) {
			        resolve(result)
			    }
			});
      	});
      	if(!flag){
      		return;
      	}
	}

	connectToChangeReset();

	callDetails.from = from;
	callDetails.called_id = to;
	callDetails.app_id = receiver.app_id;


	$('#callModal-customer').val(from).attr('readonly', 'readonly');
	$('#callModal-helplinewithname-dropdown').hide();
	$('#callModal-helplinewithname').val(to_name + ' - ' + to).show();
	$('#callModal-connectto').html(receiver.full_name + ', ' + receiver.phone +  ', '  + receiver.category + ', ' + receiver.note + ', ' + receiver.helpline);

	// TODO: Default to be done...

	$("#callModal").modal({ keyboard: false, backdrop: 'static' });
}

function openCallModal(){
	connectToChangeReset();

	callDetails.from = '';
	callDetails.called_id = $('#callModal-helplinewithname-dropdown').val();
	callDetails.app_id = receiver.app_id;

	$('#callModal-customer').val('').removeAttr('readonly');
	$('#callModal-helplinewithname').hide();
	$('#callModal-helplinewithname-dropdown').show();
	$('#callModal-connectto').html(receiver.full_name + ', ' + receiver.phone +  ', '  + receiver.category + ', ' + receiver.note + ', ' + receiver.helpline);

	// TODO: Default to be done...

	$("#callModal").modal({ keyboard: false, backdrop: 'static' });
}

function openSmsModal(){
	sendToChangeReset();

	smsDetails.to = '';
	smsDetails.called_id = $('#smsModal-helplinewithname-dropdown').val();
	smsDetails.app_id = receiver.app_id;
	

	for (var key in json) {
		if (json.hasOwnProperty(key)) {
			if (json[key].helpline_id==smsDetails.called_id){
			if ($("select[id$='smsModal-templatewithname-dropdown'] option:contains('" + json[key].template_name + "')").length == 0) {
				$('#smsModal-templatewithname-dropdown').append('<option value="'+json[key].sms_template_id+'">'+json[key].template_name+'</option>');
				document.getElementById("smsModal-template").value=json[key].template;
			}
		    }
		}
	}

	setSmsTemplate(smsDetails.called_id);

	$('#smsModal-customer').val('').removeAttr('readonly');
	$('#smsModal-helplinewithname').hide();
	$('#smsModal-templatewithname').hide();
	$('#smsModal-helplinewithname-dropdown').show();
	$('#smsModal-templatewithname-dropdown').show();

	$("#smsModal").modal({ keyboard: false, backdrop: 'static' });
}

function setFromNumber(){
	callDetails.from = $('#callModal-customer').val();
}

function setSmsToNumber(){
	smsDetails.to = $('#smsModal-customer').val();
}

function setHelplineNumber(){
	callDetails.called_id = $('#callModal-helplinewithname-dropdown').val();
}

function connectToChangeReset(){
	$('.callModal-customer-error').hide();
	$('.callModal-app_id-error').hide();

	$('[href="#change_connectto"]').removeAttr("data-hidden").html('Change');
	$('#change_connectto_section').addClass('hidden');
	$('[name=radio_doctor]:checked').removeAttr('checked');

	$('#callModal_connectto_alternate_section').addClass('hidden');
	$('#callModal-connectto-alternate option').remove();
	$('#callModal-connectto-alternate-showmore').removeAttr('checked');
}

function sendToChangeReset(){
	$('.smsModal-customer-error').hide();
	$('.smsModal-app_id-error').hide();
	$('.smsModal-template-error').hide(); 

	$('[href="#change_sendto"]').removeAttr("data-hidden").html('Change');
	$('#change_sendto_section').addClass('hidden');
	$('[name=radio_doctor]:checked').removeAttr('checked');

	$('#smsModal_sendto_alternate_section').addClass('hidden');
	$('#smsModal-sendto-alternate option').remove();
	$('#smsModal-sendto-alternate-showmore').removeAttr('checked');
}

function initiateCall(){
	if(!callDetails.from){
		$('.callModal-customer-error').show();
		return;
	}
	$('.callModal-customer-error').hide();
	
	if(!callDetails.app_id){
		$('.callModal-app_id-error').show();
		return;
	}
	$('.callModal-app_id-error').hide();


	// customer to agent flow...
	// ajax for call...
	$('#initiateCallButton').val('Calling...').attr('disabled', 'disabled');

	$.ajax({
        url: '<?php echo base_url();?>helpline/initiate_call',
        type: 'POST',
		dataType : 'JSON',
		data : callDetails,
        error: function(res) {
            //callback();
            $('#initiateCallButton').val('Call').removeAttr('disabled');
            bootbox.alert("Call failed: " + JSON.stringify(res));
        },
        success: function(res) {
			$('#initiateCallButton').val('Call').removeAttr('disabled');
			$("#callModal").modal('hide');
			bootbox.alert("Call initiated successfully");
        }
    });
}

function initiateSms(){
	if(!smsDetails.to){
		$('.smsModal-customer-error').show();
		return;
	}
	$('.smsModal-customer-error').hide();

	// customer to agent flow...
	// ajax for call...
	$('#initiateSmsButton').val('Calling...').attr('disabled', 'disabled');

	$.ajax({
        url: '<?php echo base_url();?>helpline/initiate_sms',
        type: 'POST',
		dataType : 'JSON',
		data : smsDetails,
        error: function(res) {
            //callback();
			$('#initiateSmsButton').val('Send').removeAttr('disabled');
            bootbox.alert(res.responseText);
        },
        success: function(res) {
			$('#initiateSmsButton').val('Send').removeAttr('disabled');
			$("#SmsModal").modal('hide');
			bootbox.alert("Sms sent successfully");
        }
    });
}

function initAgentSelectize(){
	var selectize = $('#callModal-agent').selectize({
	    valueField: 'receiver_id',
	    labelField: 'custom_data',
	    searchField: 'custom_data',
	    options: [],
	    create: false,
	    render: {
	        option: function(item, escape) {
	        	return '<div>' +
	                '<span class="title">' +
	                    '<span class="">' + escape(item.custom_data) + '</span>' +
	                '</span>' +
	            '</div>';
	        }
	    },
	    load: function(query, callback) {
	        if (!query.length) return callback();
	        $.ajax({
	            url: '<?php echo base_url();?>helpline/search_helpline_receiver',
	            type: 'POST',
				dataType : 'JSON',
				data : { query: query },
	            error: function(res) {
	                callback();
	            },
	            success: function(res) {
	            	res = transformAgent(res);
	                callback(res.slice(0, 10));
	            }
	        });
		},

	});
	if($('#callModal-agent').attr("data-previous-value")){
		selectize[0].selectize.setValue($('#callModal-agent').attr("data-previous-value"));
	}
}

function transformAgent(res){
	if(res){
		res.map(function(d){
			d.custom_data = d.full_name + ' - ' + d.phone;
		    return d;
		});
	}
	return res;
}

function loadReceivers(links){
	revertConnecto()

	$.ajax({
        url: '<?php echo base_url();?>helpline/get_helpline_receiver_by_doctor',
        type: 'POST',
		dataType : 'JSON',
		data : { doctor: $('[name=radio_doctor]:checked').val(), helpline: callDetails.called_id, links: links },
        error: function(res) {
            //callback();
        },
        success: function(res) {
			$('#callModal_connectto_alternate_section').removeClass('hidden');
			$('#callModal-connectto-alternate').append('<option value="">Select alternate connect</option>');

			if(res){
				$.each(res, function(i, d){
					$('#callModal-connectto-alternate').append('<option value="'+d.app_id+'">'+d.full_name+', '+d.phone+', '+d.category+'</option>');
				})
			}
        }
    });
}
					
function updateConnectto(){
	revertConnecto();

	if($('#callModal-connectto-alternate').val()){
		callDetails.app_id = $('#callModal-connectto-alternate').val();
		var display_text = $('#callModal-connectto-alternate option[value="'+$('#callModal-connectto-alternate').val()+'"]').html();
		$("#callModal-connectto").addClass('line-through');
		$("#callModal-connectto-updated").html(display_text + ', ' + receiver.note + ', ' + receiver.helpline);
	}
}
function setupHospitalDropdown() {
	console.log("setupHospitalDropdown");
	const selectedHelpline = $("#helplineSelect").val();
	if(selectedHelpline > 0) {
		onHelplineDropdownChanged(selectedHelpline);
	}
	
	$("#helplineSelect").on("change", function() {	
		const helplineId = $(this).val();
		onHelplineDropdownChanged(helplineId);
	})
}
function onHelplineDropdownChanged(helplineId) {
	console.log("select changed");
	const optionsHtml = getHospitalsForHelpline(helplineId);
	$("#hospitalSelect").html(optionsHtml);	
	onHospitalDropdownChanged();
}

function setupDepartmentDropdown() {
	const selectedHospital = $("#hospitalSelect").val();
	if(selectedHospital > 0) {
		onHospitalDropdownChanged(selectedHospital);
	}

	
	console.log("setupDepartmentDropdown");
	$("#hospitalSelect").on("change", function() {
		console.log("select changed");
		const hospitalId = $(this).val();
		onHospitalDropdownChanged(hospitalId);
	})
}

function onHospitalDropdownChanged(hospitalId) {
	const optionsHtml = getDepartmentOptionsForHospital(hospitalId);
	$("#departmentSelect").html(optionsHtml);
		
}
function getDepartmentOptionsForHelpline(helplineId) {
	const helplineHospital = hospitals.filter(hospital => hospital.helpline_id == helplineId);
	let optionsHtml = buildEmptyOption("Department");
	if(helplineHospital.length > 0) {
		const hospitalId = helplineHospital[0].hospital_id;
		const deptOptions = getDepartmentOptionsForHospital(hospitalId);
		deptOptions? optionsHtml = deptOptions: "";		
	}
	return optionsHtml;
}

function getHospitalsForHelpline(helplineId) {
	const helplineHospitals = hospitals.filter(hospital => hospital.helpline_id == helplineId);
	let optionsHtml = buildEmptyOption("Hospitals"); 
	if(helplineHospitals.length > 0) {		
		optionsHtml += helplineHospitals.map(hospital => {
			return `	<option value="${hospital.hospital_id}">
							${hospital.hospital_short_name}
						</option>`;
		});
		return optionsHtml;
	}
	return optionsHtml;
}
function getDepartmentOptionsForHospital(hospitalId) {
	const helplineDepartments = departments.filter(dept => dept.hospital_id == hospitalId);
	let optionsHtml = buildEmptyOption("Department"); 
	if(helplineDepartments.length > 0) {		
		optionsHtml += helplineDepartments.map(dept => {
			return `	<option value="${dept.department_id}">
							${dept.department}
						</option>`;
		});
		return optionsHtml;
	}
	return optionsHtml;
}
function buildHospitalOptions(hospitals = []) {
	if(hospitals && hospitals.length > 0) {
		let optionsHtml = buildEmptyOption("Select"); 
		optionsHtml += hospitals.map(hospital => {
			return `	<option value="${hospital.hospital_id}">
							${hospital.hospital_short_name}
						</option>`;
		});
		return optionsHtml;
	} else {
		return null;
	}
}

function buildCallCategoryOptions(callCategory = []) {
	if(callCategory && callCategory.length > 0) {
		let optionsHtml = buildEmptyOption("Select"); 
		optionsHtml += callCategory.map(callCategory => {
			return `	<option value="${callCategory.call_category_id}">
							${callCategory.call_category}
						</option>`;
		});
		return optionsHtml;
	} else {
		return null;
	}
}
function buildEmptyOption(optionName = "Select") {
	return `<option value="" selected>
					${optionName}
			</option>`;

}
function openEditModal(e) {
	const callId = $(e).attr('data-id');
	var callArray = callData.filter((call) => call.call_id == callId);
	var hospitalSelect = hospitals.filter((hospital) =>  hospital.helpline_id == callArray[0].helpline_id);
	var callCategorySelect = callCategory.filter((callCategory) =>  callCategory.helpline_id == callArray[0].helpline_id);
	if(callArray.length > 0) {
		$('#updateCallModal').modal({backdrop: 'static', keyboard: false});  
		setupUpdateCallModalData(callArray[0],hospitalSelect,callCategorySelect);
	}
}
function openSendEmailModal(e) {
	const callId = $(this).attr('data-id');
	// $("#updateCallModal").modal("show");

}

function revertConnecto(){
	callDetails.app_id = receiver.app_id;
	$("#callModal-connectto").removeClass('line-through');
	$("#callModal-connectto-updated").html('');	
}

$(function(){
	$('[data-toggle="tooltip"]').tooltip();

	if(receiver && receiver.enable_outbound == "1"){
		$('.call_button').show();
		$('.sms_button').show();

		// initAgentSelectize();
		
		if(receiver.helpline){
			$('#callModal-helplinewithname-dropdown').append('<option value="'+receiver.helpline+'">'+receiver.note+' - '+receiver.helpline+'</option>');
			$('#smsModal-helplinewithname-dropdown').append('<option value="'+receiver.helpline+'">'+receiver.note+' - '+receiver.helpline+'</option>');
		}
		if(user_details.receiver_link){
			$.each(user_details.receiver_link, function(i, d){
				$('#callModal-helplinewithname-dropdown').append('<option value="'+d.helpline+'">'+d.note+' - '+d.helpline+'</option>');
				$('#smsModal-helplinewithname-dropdown').append('<option value="'+d.helpline+'">'+d.note+' - '+d.helpline+'</option>');
			})
		}
	}

	$('#callModal').on('click', '[href="#change_connectto"]', function(e){
		e.preventDefault();

		$('[name=radio_doctor]:checked').removeAttr('checked');
		$('#callModal_connectto_alternate_section').addClass('hidden');
		$('#callModal-connectto-alternate option').remove();
		$('#callModal-connectto-alternate-showmore').removeAttr('checked');
		revertConnecto();

		if($(this).attr("data-hidden")){
			callDetails.app_id = receiver.app_id;
			$(this).removeAttr("data-hidden").html('Change');
			$('#change_connectto_section').addClass('hidden');
		} else  {
			callDetails.app_id = '';
			$(this).attr("data-hidden", "true").html('Cancel');
			$('#change_connectto_section').removeClass('hidden');
		}
	});

	$('[name=radio_doctor]').on('click', function(e){

		$('#callModal_connectto_alternate_section').addClass('hidden');
		$('#callModal-connectto-alternate option').remove();
		$('#callModal-connectto-alternate-showmore').removeAttr('checked');

		loadReceivers("0");
		
	});

	$('#callModal-connectto-alternate-showmore').on('click', function(e){
		$('#callModal-connectto-alternate option').remove();

		loadReceivers($('#callModal-connectto-alternate-showmore:checked').length > 0 ? "1" : "0");
		
	});
});
$(document).ready(function() {
	setupHospitalDropdown();
	setupDepartmentDropdown();
	var hospital = "<?php echo $this->input->post('helpline_hospital')?>";
	if(hospital != ""){
		$("#hospitalSelect").val(hospital);
		setupDepartmentDropdown();
	}
	var department = "<?php echo $this->input->post('helpline_department')?>";
	if(department != ""){
		$("#departmentSelect").val(department);
	}
})

	onchange_state_dropdown(document.getElementById("state"));
	var district = "<?php echo $this->input->post('district')?>";
	if(district != ""){
			$("#district").val(district);
	}
</script>
