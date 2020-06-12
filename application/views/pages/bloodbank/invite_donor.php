<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<script type="text/javascript"
 src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
 <script type="text/javascript">
$(function(){
		$("#from_date,#to_date").Zebra_DatePicker();
		
});
</script>

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
	<div class="col-md-10">
<div class="col-md-10 col-sm-9">
	<div style="color:red;padding:5px;font-size:14px;">
	<?php echo validation_errors(); ?></div>
	<?php 
	if(isset($msg)) { ?>
		<div class="alert alert-info">
			<b><?php echo $msg; ?></b>
		</div>
	<?php 
	}
	?>



	<h4 class="text-center">Invite Donor</h4>


	<?php echo form_open("bloodbank/user_panel/invite_donor",array('class'=>'form-custom')); ?>

     	<div class="col-md-5">
		<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">Donate From</span>
		  <input class="form-control"type="text" class="form-control" name="from_date"  id="from_date"  aria-describedby="basic-addon1" required>
		</div>		
		</div>
		<div class="col-md-5">
		<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">Donate To</span>
		  <input class="form-control"type="text" class="form-control" name="to_date"  id="to_date"    aria-describedby="basic-addon1" required>
		</div>		
		</div>
		<br><br><br>
		<div class="col-md-5">
		<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">Group</span>
		  <select class="form-control" name="blood_group">
			<option value="" disabled selected>Blood Group</option>
			<option value="A+">A+</option>
			<option value="B+">B+</option>
			<option value="O+">O+</option>
			<option value="AB+">AB+</option>
			<option value="A-">A-</option>
			<option value="B-">B-</option>
			<option value="O-">O-</option>
			<option value="AB-">AB-</option>
		</select>
		  
		</div>		
		</div>
		<div class="col-md-5">
		<div class="input-group">
		  <span class="input-group-addon" id="basic-addon1">Camp</span>
		  <select name="camp" id="camps" class="form-control" >
				<option value="">--Select Location--</option>
				<?php foreach($camps as $camp){
					echo "<option value='".$camp->camp_id."' id='camp".$camp->camp_id."'>$camp->camp_name, $camp->location</option>";
				?>
					
				<?php
				}
				?>
				</select>
		  
		</div>		
		</div><br><br><br><br>
		<input type="submit" value="Search" name="reset" class="btn btn-primary btn-sm text-center" />
		<br><br><br><br>
	
		<table  class="table table-bordered table-striped" id="table-sort">
		<thead><th>S.no</th><th>Donor Id</th><th>Donor Name</th><th>Gender</th><th>Phone</th><th>Email</th><th>Address</th><th>Date Of Donation</th><th>Select</th></thead>
				<?php if(count($donors)>0){ ?>
			<?php 
	$i=1;
	foreach($donors as $s){
	?>
		<tr>
		<td><?php echo $i++;?></td>
		<td><?php echo $s->donor_id;?></td>
	    <td><?php echo $s->name;?></td>
		<td><?php echo $s->sex;?></td>
		<td><?php echo $s->phone;?></td>
		<td><?php echo $s->email;?></td>
		<td><?php echo $s->address;?></td>
		<td><?php if($s->donation_date!=0) echo date("d-M-y",strtotime($s->donation_date));?></td>
		<td>
				<input type="checkbox"    value="<?php echo $s->donor_id;?>" name="donor_ids[]" /></td>
		</tr>
		
           
	
	<?php
	}
	?></table>
</div>	
	  <div class="well">           
             
			 <input type="checkbox" name="sms" value="sms" class="form-control" />Send SMS </input>					 
			  <input type="checkbox"  name="email"  value="email" class="form-control" />Send Email</input><br><br><br>
			 <input type="submit" value="Submit" name="submit" class="btn btn-primary btn-sm text-center">
	</div>



	</form>
	<?php } 
	else {
	?>
	<h2> No Donors found on the given date</h2>
	<?php } ?>

</div>
