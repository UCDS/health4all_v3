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
		$("#date").Zebra_DatePicker();
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
<iframe id="ifmcontentstoprint" style="height: 0px; width: 0px; position: absolute;display:none"></iframe>
<div class="col-md-10 col-sm-9">
	<h4>Donors Report</h4>
	<?php echo form_open('bloodbank/user_panel/print_certificates',array('role'=>'form','class'=>'form-custom')); ?>
	<div>
		<input type="text" class="form-control" placeholder="Choose Date" id="date" size="12" name="donation_date" />
		<select name="blood_group" class="form-control" style="width:100px;">
			<option value="" selected disabled>Choose</option>
			<option value="A+">A+</option>
			<option value="B+">B+</option>
			<option value="O+">O+</option>
			<option value="AB+">AB+</option>
			<option value="A-">A-</option>
			<option value="B-">B-</option>
			<option value="O-">O-</option>
			<option value="AB-">AB-</option>
		</select>
		<select name="camp_id" id="camps" class="form-control" style="width:150px;">
				<option value="">--Select Location--</option>
				<?php foreach($camps as $camp){
					echo "<option value='".$camp->camp_id."' id='camp".$camp->camp_id."'>$camp->camp_name, $camp->location</option>";
				?>
					
				<?php
				}
				?>
		</select>
		<input type="text" placeholder="From" class="form-control" name="from_num" size=4 />
		<input type="text" placeholder="To" class="form-control" name="to_num" size=4 />
		<input type="submit" name="submit" class='btn btn-primary btn-md' value="Search" />
	</form>
	<input type="button" class="btn btn-default btn-md print" value="Print" onclick="printDiv('print_div')" />
	</div>
	
	<?php 
	if($this->input->post('donation_date')) echo "Donors who donated on or before ".date("d-M-y",strtotime($this->input->post('donation_date'))). " | ";
	if($this->input->post('blood_group')) echo "Blood Group : ".$this->input->post('blood_group');
	if(count($donors)>0){ ?>
	<table  class="table-2 table table-striped table-bordered"></table>
	<table class="table table-bordered table-striped" id="table-sort">
		<thead>
		<th>S.No</th>
		<th>Donor No.</th>
		<th>Name</th>
		<th>Date</th>
		<th>Camp</th>
		<th>Camp Address</th>
		</thead>
	<?php 
	$i=1;
	foreach($donors as $s){
	?>
	<tr>
		<td><?php echo $i++;?></td>
		<td><?php echo $s->blood_unit_num;?></td>
		<td><?php echo $s->name;?></td>
		<td><?php if($s->donation_date!=0) echo date("d-M-y",strtotime($s->donation_date));?></td>
		<td><?php echo $s->camp_name;?></td>
		<td><?php echo $s->location;?></td>
	</tr>
	<?php
	}
	?>
	</table>
	<div id="print_div" style="min-width:100%;min-height:100%;" hidden>
	<?php 
	foreach($donors as $d){
	?>
	<div style="min-width:100%;width:100%;min-height:100%;height:100%;font-size:1.4em;font-family:'Trebuchet MS'">
		<div style="left:20%;top:18%;position:relative;">
			<?php echo strtoupper($d->name); ?>
		</div>
		<div style="left:75%;top:12.5%;position:relative;">
			<?php echo date('d-M-Y',strtotime($d->donation_date)); ?>
		</div>
		<div style="left:22%;top:65%;position:relative;width:25%;">
			<?php echo strtoupper($d->camp_name)."<br />".strtoupper($d->location); ?>
		</div>
	</div>
	<?php 
	}
	?>
	</div>
	<?php
	} 
	else {
	?>
	<h2> No Donors found</h2>
	<?php } ?>
</div>
