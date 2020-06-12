<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript">
$(function(){
	$("#from_date,#to_date").Zebra_DatePicker();
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

	<?php 
	$from_date=0;$to_date=0;
	if($this->input->post('from_date')) $from_date=date("Y-m-d",strtotime($this->input->post('from_date'))); else $from_date = date("Y-m-d");
	if($this->input->post('to_date')) $to_date=date("Y-m-d",strtotime($this->input->post('to_date'))); else $to_date = date("Y-m-d");
	?>
	<div class="row">
		<h3>Hearing Screening Summary report</h3>	
		<?php echo form_open("reports/audiology_summary",array('role'=>'form','class'=>'form-custom')); ?> 
		           <h4>Filter by Dates </h4>
				
				    <label><input type ="radio" name="date_type" class ="form-control" value="Admit" checked >  Admit/Visit date </label>
               <label><input type="radio" name="date_type" class ="form-control" value="Order" <?php if($this->input->post('date_type') == "Order") echo " checked "; ?> >   Order Date  </label><br>
					From Date : <input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($from_date)); ?>" name="from_date" id="from_date" size="15" />
					To Date : <input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($to_date)); ?>" name="to_date" id="to_date" size="15" />
					<?php if($this->input->post('oae_count')) $oae_count=$this->input->post('oae_count');?>
					<select name="oae_count" id="department" class="form-control">
					<option value="1" <?php if($oae_count == 1) echo "selected";?> >First</option>
					<option value="2" <?php if($oae_count == 2) echo "selected";?> >Second</option>
					<option value="3" <?php if($oae_count == 3) echo "selected";?> >Third</option>
					</select>
					<input class="btn btn-sm btn-primary" type="submit" value="Submit" />
		</form>
	<br />
	<?php if(isset($report) && count($report)>0){
			$visit_id = 0;
			$outcome="";
			$left_refer=0;
			$right_refer=0;
			$bilateral=0;
			$total=0;
			$pass=0;
			foreach($report as $r){
				if($r->visit_id == $visit_id){
					if($outcome==1 && $r->test_result_binary==0) { 
						$bilateral++;
						if($left_outcome == 1) $left_refer--;
						if($right_outcome == 1) $right_refer--;
					}
					else if($r->test_name == "Left OAE" && $r->test_result_binary == 0) { $left_refer++; $outcome = 1;}
					else if($r->test_name == "Right OAE" && $r->test_result_binary == 0) { $right_refer++; $outcome = 1; }
					if($outcome==0) $pass++;
					$total++;
					$outcome="";
					$left_outcome="";
					$right_outcome="";
					$visit_id=0;
				}
				else{
					$visit_id = $r->visit_id;
					if($r->test_name == "Left OAE" && $r->test_result_binary == 0) { $left_refer++; $left_outcome=1; $outcome = 1;}
					else if($r->test_name == "Right OAE" && $r->test_result_binary == 0) { $right_refer++; $right_outcome=1; $outcome = 1; }
					else { $outcome=0;}
				}
			}
	?>
	
		<button type="button" class="btn btn-default btn-md print">
		  <span class="glyphicon glyphicon-print"></span> Print
		</button>
	<table class="table table-bordered table-striped" id="table-sort">
	<thead>
		<th>Outcome</th>
		<th>No. of Babies</th>
	</thead>
	<tbody>
	<tr>
		<td>Pass</td>
		<td><?php echo $pass;?></td>
	</tr>
	<tr>
		<td>Bilateral - Refer</td>
		<td><?php echo $bilateral;?></td>
	</tr>
	<tr>
		<td>Left - Refer</td>
		<td><?php echo $left_refer;?></td>
	</tr>
	<tr>
		<td>Right - Refer</td>
		<td><?php echo $right_refer;?></td>
	</tr>
	<tr>
		<th>Total Tested</th>
		<th><?php echo $total;?></th>
	</tr>
	</tbody>
	</table>
		
	<?php } else { ?>
	No tests on the given date.
	<?php } ?>
	</div>