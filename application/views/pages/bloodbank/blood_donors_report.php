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
	<h4>Donors Report</h4>
	<?php echo form_open('bloodbank/user_panel/blood_donors', array('role'=>'form','class'=>'form-custom')); ?>
	<div>
        <input type="text" placeholder="From date" class="form-control" size="10" name="from_date" id="from_date" />
		<input type="text" placeholder="To date" class="form-control" size="10" name="to_date" id="to_date" />
		<select name="blood_group" class="form-control" style="width:100px;">
			<option value="" selected disabled>----</option>
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
	</div>
	
	
	<?php 
	if($this->input->post('donation_date')) echo "Donors who donated on or before ".date("d-M-y",strtotime($this->input->post('donation_date'))). " | ";
	if($this->input->post('blood_group')) echo "Blood Group : ".$this->input->post('blood_group');
	if(count($donors)>0){ ?>

	<table  class="table table-bordered table-striped"></table>
	<button type="button" class="btn btn-default btn-md print">
		  <span class="glyphicon glyphicon-print"></span> Print
		</button>
	<table class="table table-bordered table-striped" id="table-sort">
		<thead>
			<th>S.No</th>
			<th>Blood Unit No.</th>
			<th>Donation Date</th>
			<th>Name</th>
			<th>Address</th>
			<th>Phone / Email</th>
			<th>Vol./RD</th>
			<th>Age</th>
			<th>Sex</th>
			<th>Weight in Kgs</th>
			<th>BP mm of Hg</th>
			<th>HB gm%</th>
			<th>Medical Exam</th>
			<th width="60px">Reasons for Deferral</th>
			<th>Blood Group</th>
			<th>Segment Number</th>
			<th>Type of Bag</th>
			<th>Volume in ml</th>
			<th width="60px">Sign of Donor</th>
			<th width="60px">Sign of Staff</th>
			<th width="60px">Sign of Medical Officer</th>
		</thead>
	<?php 
	$i=1;
	foreach($donors as $s){
	?>
	<tr>
		<td><?php echo $i++;?></td>
		<td><?php echo $s->blood_unit_num;?></td>
		<td><?php if($s->donation_date!=0) echo date("d-M-y",strtotime($s->donation_date));?></td>
		<td><?php echo $s->name;?></td>
		<td><?php echo $s->address;?></td>
		<td><?php echo $s->phone;?> / <?php echo $s->email;?></td>
		<td><?php echo $s->donor_type;?></td>
		<td><?php echo $s->age;?></td>
		<td><?php echo strtoupper($s->sex);?></td>
		<td><?php echo $s->weight;?></td>
		<td><?php echo $s->sbp;?>/<?php echo $s->dbp;?></td>
		<td><?php echo $s->hb;?></td>
		<td>NAD</td>
		<td></td>
		<td><?php echo $s->blood_group;?></td>
		<td><?php echo $s->segment_num;?></td>
		<td><?php
				switch($s->bag_type){
					case 1 : echo "SB"; break;
					case 2 : echo "DB"; break;
					case 3 : echo "TB"; break;
					case 4 : echo "QB"; break;
					default : break;
				}
			?>
		</td>
		<td><?php echo $s->volume;?></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<?php
	}
	?>
	</table></div>
	<?php } 
	else {
	?>
	<h2> No Donors found</h2>
	<?php } ?>
</div>
