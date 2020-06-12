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
		$("#from_date,#to_date").Zebra_DatePicker();
	});
</script>

<div class="col-md-10 col-sm-9">

	<div>
		<?php echo form_open('bloodbank/user_panel/appointment_bookings', array('role'=>'form','class'=>'form-custom')); ?>
		<div>
			<input type="text" placeholder="From date" class="form-control" size="10" name="from_date" id="from_date" />
			<input type="text" placeholder="To date" class="form-control" size="10" name="to_date" id="to_date" />
			<input type="submit" class="btn btn-primary btn-md" value="Search" name="search" />
		</div>
		</form><br/>
                <button type="button" class="btn btn-default btn-md print">
		  <span class="glyphicon glyphicon-print"></span> Print
		</button>
		<?php
		if(isset($msg)) {
			echo $msg;
			echo "<br />";
			echo "<br />";
		}
		?>
		<?php if(count($appointments)>0){ ?>
                
                <table class="table table-bordered table-striped" id="table-sort">
			<tr>
				<th colspan="10">
			<?php
			if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date('d-M-Y',strtotime($this->input->post('from_date')));
			$to_date=date('d-M-Y',strtotime($this->input->post('to_date')));
			echo "Appointments from ".$from_date." to ".$to_date;
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
		 $this->input->post('from_date')==""?$date=$this->input->post('to_date'):$date=$this->input->post('from_date');
		 echo "Appointments on $date";
		}
		else{
			$from_date=date('d-M-Y',strtotime('-10 Days'));
			$to_date=date('d-M-Y');
			echo "Appointments in the last 10 days";	
		}
		?>
		</th></tr>
			<tr><th>S.No</th><th>App ID</th><th>Slot date</th><th>Booked On</th><th>Name</th><th>Age</th><th>Blood Group</th><th>Phone</th><th>Status</th></tr>
		<?php 
		$i=1;
		foreach($appointments as $donor){
		?>
		<tr>
		<?php echo form_open('bloodbank/register/appointment_register/'.$donor['donor_id']);?>
			<td><?php echo $i;?></td>
			<td><?php echo $donor['appointment_id'];?></td>
			<td><?php echo date('d-M-Y',strtotime($donor['date']));?></td>
			<td><?php echo date('d-M-Y',strtotime($donor['datetime']));?></td>
			<td><?php echo $donor['name'];?></td>
			<td><?php echo $donor['age'];?></td>
			<td><?php if($donor['blood_group']!="" && $donor['blood_group']!='0'){ echo $donor['blood_group']; }?></td>
			<td><?php echo $donor['phone'];?></td>
			<td><?php echo $donor['status'];?></td>
		</form>
		</tr>
		<?php 
		$i++;
		}
		?>
		</table>
		<?php }
		else{
			 ?>
			 <p>No appointments booked in the specified period.</p>
		<?php } ?>
	</div>
</div>

