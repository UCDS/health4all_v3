<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
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
	<div class="row">
	<div class="col-md-8 col-md-offset-2">
	<h3>Equipments</h3>
	
	<table class="table table-bordered" id="table-sort">
	<thead>
		<th>#</th>
		<th>Equipment</th>
		<th>Make</th>
		<th>Model</th>
		<th>Serial No.</th>
		<th>Asset No.</th>
		<th>Procured By</th>
		<th>Cost</th>
		<th>Vendor (Supplier)</th>
		<th>Supplied Date</th>
		<th>Warranty Period</th>
		<th>Serivce Engineer</th>
		<th>Service Engineer Contact</th>
		<th>Department</th>
		<th>Equipment Status</th>
	</thead>
	<tbody>

	<?php 
	$total_count=0;
	$i=1;
	foreach($equipments as $e){
	?>
	<tr>
		<td><?php echo $i++;?></td>
		<td><?php echo $e->equipment_type;?></td>
		<td><?php echo $e->make;?></td>
		<td><?php echo $e->model;?></td>
		<td><?php echo $e->serial_number;?></td>
		<td><?php echo $e->asset_number;?></td>
		<td><?php echo $e->procured_by;?></td>
		<td><?php echo number_format($e->cost);?></td>
		<td><?php echo $e->vendor_name;?></td>
		<td><?php if($e->supply_date!=0) echo date("d-M-Y",strtotime($e->supply_date));?></td>
		<td><?php if($e->warranty_start_date!=0 && $e->warranty_end_date!=0) echo date("d-M-y",strtotime($e->warranty_start_date))." to ".date("d-M-y",strtotime($e->warranty_end_date));?></td>
		<td><?php echo $e->contact_person_first_name. " " .$e->contact_person_last_name;?></td>
		<td><?php echo $e->contact_person_contact;?></td>
		<td><?php echo $e->department;?></td>
		<td><?php if($e->equipment_status==1) echo "Working"; else echo "Not Working";?></td>
	</tr>
	<?php
	$total_count++;
	}
	?>
	</tbody>
	<tr>
		<th>Total </th>
		<th ><?php echo $total_count;?></th>
	</tr>
	</table>
	</div>
	</div>
