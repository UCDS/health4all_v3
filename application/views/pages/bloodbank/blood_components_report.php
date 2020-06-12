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
<script>
	$(function(){
		$("#from_date,#to_date").Zebra_DatePicker({
			direction:false
		});
	});
	
	
</script>
	<div class="col-md-10">
<div class="col-md-10 col-sm-9">

	
	<?php echo form_open('bloodbank/user_panel/blood_components', array('role'=>'form','class'=>'form-custom')); ?>
	<div>
		<input type="text" class="date" size="12" name="from_date" placeholder="From Date" />
		<input type="text" class="date" size="12" name="to_date"  placeholder="To Date" />
		<select name="blood_group">
			<option value="" selected disabled>Blood Group</option>
			<option value="A+">A+</option>
			<option value="B+">B+</option>
			<option value="O+">O+</option>
			<option value="AB+">AB+</option>
			<option value="A-">A-</option>
			<option value="B-">B-</option>
			<option value="O-">O-</option>
			<option value="AB-">AB-</option>
		</select>
		<input type="submit" name="submit" class='btn btn-primary btn-md' value="Search" />
		<button type="button" class="btn btn-default btn-md print">
          <span class="glyphicon glyphicon-print"></span> Print
        </button>
	</div>
	
	<?php 
	if($this->input->post('blood_group')) echo "Blood Group : ".$this->input->post('blood_group');
	if($this->input->post('from_date') && $this->input->post('to_date')) echo "From : ".date("d-M-Y",strtotime($this->input->post('from_date')))." To : ".date("d-M-Y",strtotime($this->input->post('to_date')));
	else if($this->input->post('from_date') || $this->input->post('to_date')) if($this->input->post('from_date')) echo date("d-M-Y",strtotime($this->input->post('from_date'))); else echo date("d-M-Y",strtotime($this->input->post('to_date')));
	if(count($donors)>0){ ?>
	<table id="header-fixed" class="table-2"></table>
	<div id="print-div"  style="width:100%;height:100%;">

	<table class="table table-bordered table-striped" id="table-sort">
		<thead>
		<tr>
			<tr>
				<th colspan="100" style="text-align:center">Master Record for Blood & it's Components</th>
			</tr>
			<tr>
				<th rowspan="2">S.No</th>
				<th rowspan="2">Blood Unit No.</th>
				<th rowspan="2">Name</th>
				<th rowspan="2">Date of Collection</th>
				<th rowspan="2">Date of Expiry</th>
				<th rowspan="2">Segment Number</th>
				<th rowspan="2">Quantity in ml</th>
				<th rowspan="2">Blood Group</th>
				<th rowspan="2">Date of testing</th>
				<th colspan="6">Tests</th>
				<th rowspan="2">Status</th>
				<th rowspan="2">WB/Components prepared & Date</th>
				<th rowspan="2">Issue No & Date</th>
				<th rowspan="2">Staff Sign</th>
				<th rowspan="2">Medical Officer Sign</th>
			</tr>
			<tr>
				<th>HIV</th><th>HBSAG</th><th>HCV</th><th>VDRL</th><th>MP</th><th>Irregular Antibodies</th>
			</tr>
		</thead>
	<?php 
	$i=1;
	foreach($donors as $s){
	?>
	<tr>
		<td><?php echo $i++;?></td>
		<td><?php echo $s->blood_unit_num;?></td>
		<td><?php echo $s->name;?></td>
		<td><?php if($s->donation_date!=0) echo date("d-M-Y",strtotime($s->donation_date));?></td>
		<td><?php if($s->expiry_date!=0) echo date("d-M-Y",strtotime($s->expiry_date));?></td>
		<td><?php echo $s->segment_num;?></td>
		<td><?php echo $s->volume;?></td>
		<td><?php echo $s->blood_group;?></td>
		<td><?php if($s->screening_datetime!=0) echo date("d-M-Y",strtotime($s->screening_datetime));?></td>
		<td><?php if($s->test_hiv!=NULL) {if($s->test_hiv==1) echo "Yes"; else echo "NR"; } ?></td>
		<td><?php if($s->test_hbsag!=NULL) {if($s->test_hbsag==1) echo "Yes"; else echo "Neg"; } ?></td>
		<td><?php if($s->test_hcv!=NULL) {if($s->test_hcv==1) echo "Yes"; else echo "NR"; } ?></td>
		<td><?php if($s->test_vdrl!=NULL) {if($s->test_vdrl==1) echo "Yes"; else echo "NR"; } ?></td>
		<td><?php if($s->test_mp!=NULL) {if($s->test_mp==1) echo "Yes"; else echo "NF"; } ?></td>
		<td><?php if($s->test_irregular_ab!=NULL) {if($s->test_irregular_ab==1) echo "Yes"; else echo "Nil"; } ?></td>
		<td><?php if($s->status=="Archived") echo "Components Prepared"; else echo $s->status;?></td>
		<td><?php if($s->component_type=='Components Prepared') { ?> Components Prepared /<?php echo date("d-M-Y",strtotime($s->components_date)); } 
		else if($s->component_type=='WB') { echo "WB / ".date("d-M-Y",strtotime($s->donation_date));}
		else  { echo $s->component_type." / "; if($s->components_date!=0) echo date("d-M-Y",strtotime($s->components_date)); }?></td>
		<td><?php if($s->issue_date!=0) { ?><?php echo $s->issue_id;?>/<?php echo date("d-M-Y",strtotime($s->issue_date)); }?></td>
		<td></td>
		<td></td>
	</tr>
	<?php
	}
	?>
	</table>
	</div>
	<?php } 
	else {
	?>
	<h2> No Donors found</h2>
	<?php } ?>

</div>