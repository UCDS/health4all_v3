 <link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
	<script type="text/javascript">
$(function(){
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
		  $('.print').click(function(){
			$('#table-sort').trigger('printTable');
		  });
});
</script>
<style>
.table-2 a{
	color:black;
	text-decoration:none;
}
</style>
<script type="text/javascript"
 src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
 <script>
	$(function(){
		$("#from_date,#to_date").Zebra_DatePicker();
	});
</script>

<div class="col-md-10 col-sm-9">
	
	<h4>Report of Blood Donors at Indian Red Cross Society Bloodbank - Vidyanagar</h4>
	<?php echo form_open('bloodbank/user_panel/issue_summary',array('role'=>'form','class'=>'form-custom')); ?>
	<div>
		<input type="text" class="form-control" size="12" placeholder="From Date" id="from_date" name="from_date" />
		<input type="text" class="form-control" size="12" placeholder="To Date" id="to_date" name="to_date" />
		<input type="submit" name="submit" class='btn btn-primary btn-md' value="Search" />
	</div>
	<br />
	<?php
	 if($this->input->post('from_date') && $this->input->post('to_date')){
		$from_date=$this->input->post('from_date');
		$to_date=$this->input->post('to_date');
		$date=date('d-M-Y',strtotime($this->input->post('from_date')))." to ".date('d-M-Y',strtotime($this->input->post('to_date')));
	 }
	 else if($this->input->post('from_date') || $this->input->post('to_date')){
		 if($this->input->post('from_date')==""){
			$date=$this->input->post('to_date');
			$to_date=$this->input->post('to_date');
		}
		else{
		$date=$this->input->post('from_date');
		$from_date=$this->input->post('from_date');
		}
	 }
	 else{
		$from_date=date("Y-m-d",strtotime("-30 Days"));
		$to_date=date("Y-m-d");
		$date= "Issues in the last 30 days.";
	 }
	 ?>
	 	<button type="button" class="btn btn-default btn-md print">
		  <span class="glyphicon glyphicon-print"></span> Print
		</button>
	<table class="table table-bordered table-striped" id="table-sort">
	<thead><th colspan="20">Blood Issue Report - <?php echo $date; ?></th>
	<thead>
		<th>Issue Date</th>
		<th>Total</th>
		<th>A+</th>
		<th>A-</th>
		<th>B+</th>
		<th>B-</th>
		<th>AB+</th>
		<th>AB-</th>
		<th>O+</th>
		<th>O-</th>
	</thead>
	<?php 
	$Apos=0;$Aneg=0;$Bpos=0;$Bneg=0;$ABpos=0;$ABneg=0;$Opos=0;$Oneg=0;$total=0;
	
	foreach($summary as $s){
		$day_total=0;
		$day_total+=$s->Apos+$s->Aneg+$s->Bpos+$s->Bneg+$s->ABpos+$s->ABneg+$s->Opos+$s->Oneg;
		$s->issue_date=date("Y-m-d",strtotime($s->issue_date));
	?>
	<tr>
		<td><?php if($s->issue_date!=0) echo date("d-M-Y",strtotime($s->issue_date));?></td>
		<th align="right"><a href="<?php echo base_url()."bloodbank/user_panel/report_issue/$s->issue_date/0/$from_date/$to_date";?>"><?php echo $s->total;?></a></th>
		<td align="right"><a href="<?php echo base_url()."bloodbank/user_panel/report_issue/$s->issue_date/Apos/$from_date/$to_date";?>"><?php echo $s->Apos;?></a></td>
		<td align="right"><a href="<?php echo base_url()."bloodbank/user_panel/report_issue/$s->issue_date/Aneg/$from_date/$to_date";?>"><?php echo $s->Aneg;?></a></td>
		<td align="right"><a href="<?php echo base_url()."bloodbank/user_panel/report_issue/$s->issue_date/Bpos/$from_date/$to_date";?>"><?php echo $s->Bpos;?></a></td>
		<td align="right"><a href="<?php echo base_url()."bloodbank/user_panel/report_issue/$s->issue_date/Bneg/$from_date/$to_date";?>"><?php echo $s->Bneg;?></a></td>
		<td align="right"><a href="<?php echo base_url()."bloodbank/user_panel/report_issue/$s->issue_date/ABpos/$from_date/$to_date";?>"><?php echo $s->ABpos;?></a></td>
		<td align="right"><a href="<?php echo base_url()."bloodbank/user_panel/report_issue/$s->issue_date/ABneg/$from_date/$to_date";?>"><?php echo $s->ABneg;?></a></td>
		<td align="right"><a href="<?php echo base_url()."bloodbank/user_panel/report_issue/$s->issue_date/Opos/$from_date/$to_date";?>"><?php echo $s->Opos;?></a></td>
		<td align="right"><a href="<?php echo base_url()."bloodbank/user_panel/report_issue/$s->issue_date/Oneg/$from_date/$to_date";?>"><?php echo $s->Oneg;?></a></td>
	</tr>
	<?php
	$Apos+=$s->Apos;
	$Aneg+=$s->Aneg;
	$Bpos+=$s->Bpos;
	$Bneg+=$s->Bneg;
	$ABpos+=$s->ABpos;
	$ABneg+=$s->ABneg;
	$Opos+=$s->Opos;
	$Oneg+=$s->Oneg;
	$total+=$day_total;
	}
	?>
	
	<tr>
		<th>Total </th>
		<th align="right"><a href="<?php echo base_url()."bloodbank/user_panel/report_issue/0/0/$from_date/$to_date";?>"><?php echo $total;?></a></th>
		<th align="right"><a href="<?php echo base_url()."bloodbank/user_panel/report_issue/0/Apos/$from_date/$to_date";?>"><?php echo $Apos;?></a></th>
		<th align="right"><a href="<?php echo base_url()."bloodbank/user_panel/report_issue/0/Aneg/$from_date/$to_date";?>"><?php echo $Aneg;?></a></th>
		<th align="right"><a href="<?php echo base_url()."bloodbank/user_panel/report_issue/0/Bpos/$from_date/$to_date";?>"><?php echo $Bpos;?></a></th>
		<th align="right"><a href="<?php echo base_url()."bloodbank/user_panel/report_issue/0/Bneg/$from_date/$to_date";?>"><?php echo $Bneg;?></a></th>
		<th align="right"><a href="<?php echo base_url()."bloodbank/user_panel/report_issue/0/ABpos/$from_date/$to_date";?>"><?php echo $ABpos;?></a></th>
		<th align="right"><a href="<?php echo base_url()."bloodbank/user_panel/report_issue/0/ABneg/$from_date/$to_date";?>"><?php echo $ABneg;?></a></th>
		<th align="right"><a href="<?php echo base_url()."bloodbank/user_panel/report_issue/0/Opos/$from_date/$to_date";?>"><?php echo $Opos;?></a></th>
		<th align="right"><a href="<?php echo base_url()."bloodbank/user_panel/report_issue/0/Oneg/$from_date/$to_date";?>"><?php echo $Oneg;?></a></th>
	</tr>
	</table>
	
</div>
