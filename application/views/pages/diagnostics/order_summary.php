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
	$("#generate-csv").click(function(){
		$(".table").table2CSV();
	});	
	$("#unit option,#area option").hide();
	$("#department").on('change',function(){
		var department_id=$(this).val();
		$("#unit option,#area option").hide();
		$("#unit option[class="+department_id+"],#area option[class="+department_id+"]").show();
	});
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
	$("#test_master").chained("#test_method");
});
</script>
	<div class="row">
	<?php 
	$this->input->post('visit_type')?$visit_type = $this->input->post('visit_type'): $visit_type = "0";
	$from_date=date("Y-m-d");$to_date=$from_date;
	if($this->input->post('from_date')) $from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
	if($this->input->post('to_date')) $to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
	if($this->input->post('patient_number')) $number = $this->input->post('patient_number'); else $number=0;
	?>
		<h4>Test Orders Summary Report</h4>	
		<?php echo form_open("reports/order_summary/$type",array('role'=>'form','class'=>'form-custom')); ?>
					From Date : <input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($from_date)); ?>" name="from_date" id="from_date" size="15" />
					To Date : <input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($to_date)); ?>" name="to_date" id="to_date" size="15" />
					<select name="lab_department" class="form-control">
					<option value="">Lab</option>
					<?php 
					foreach($lab_departments as $dept){
						echo "<option value='".$dept->test_area_id."'";
						if($this->input->post('lab_department') && $this->input->post('lab_department') == $dept->test_area_id) echo " selected ";
						echo ">".$dept->test_area."</option>";
					}
					?>
					</select>
					<select name="test_method" id="test_method" class="form-control">
					<option value="">Method</option>
					<?php 
					foreach($test_methods as $method){
						echo "<option value='".$method->test_method_id."'";
						if($this->input->post('test_method') && $this->input->post('test_method') == $method->test_method_id) echo " selected ";
						echo ">".$method->test_method."</option>";
					}
					?>
					</select>
					<select name="specimen_type" class="form-control">
					<option value="">Specimen</option>
					<?php 
					foreach($specimen_types as $specimen){
						echo "<option value='".$specimen->specimen_type_id."'";
						if($this->input->post('specimen_type') && $this->input->post('specimen_type') == $specimen->specimen_type_id) echo " selected ";
						echo ">".$specimen->specimen_type."</option>";
					}
					?>
					</select>
					
					<br />
					<br />	
						<select name="test_master" id="test_master" class="form-control" title="Select Test Method to enable">
						<option value="">Test</option>
						<?php 
						foreach($test_masters as $test_master){
							echo "<option value='".$test_master->test_master_id."' class='".$test_master->test_method_id."'";
							if($this->input->post('test_master') && $this->input->post('test_master') == $test_master->test_master_id) echo " selected ";
							echo ">".$test_master->test_name."</option>";
						}
						?>
						</select>
						<select name="department" id="department" class="form-control">
						<option value="">Department</option>
						<?php 
						foreach($all_departments as $dept){
							echo "<option value='".$dept->department_id."'";
							if($this->input->post('department') && $this->input->post('department') == $dept->department_id) echo " selected ";
							echo ">".$dept->department."</option>";
						}
						?>
						</select>
						<select name="unit" id="unit" class="form-control" >
						<option value="">Unit</option>
						<?php 
						foreach($units as $unit){
							echo "<option value='".$unit->unit_id."' class='".$unit->department_id."'";
							if($this->input->post('unit') && $this->input->post('unit') == $unit->unit_id) echo " selected ";
							echo ">".$unit->unit_name."</option>";
						}
						?>
						</select>
						<select name="area" id="area" class="form-control" >
						<option value="">Area</option>
						<?php 
						foreach($areas as $area){
							echo "<option value='".$area->area_id."' class='".$area->department_id."'";
							if($this->input->post('area') && $this->input->post('area') == $area->area_id) echo " selected ";
							echo ">".$area->area_name."</option>";
						}
						?>
						</select>
					Visit Type : <select class="form-control" name="visit_type">
									<option value="" selected>All</option>
									<option value="OP" <?php if($visit_type == "OP") echo " selected ";?>>OP</option>
									<option value="IP" <?php if($visit_type == "IP") echo " selected ";?>>IP</option>
								</select>
						<input type="text" name="patient_number" class="form-control" value="<?php if(!!$this->input->post('patient_number')) echo $this->input->post('patient_number');?>" placeholder="IP/OP Number" />
					<input class="btn btn-sm btn-primary" type="submit" value="Submit" />
		</form>
	<br />
	<?php if(isset($report) && count($report)>0){ ?>

		<button type="button" class="btn btn-default btn-md print">
		  <span class="glyphicon glyphicon-print"></span> Print
		</button>
		<table class="table table-bordered table-striped" id="table-sort">
	<thead>
		<th style="text-align:center">Department</th>
		<th style="text-align:center">Area</th>
		<th style="text-align:center">Test</th>
		<th style="text-align:center">Ordered</th>
		<th style="text-align:center">Completed</th>
		<th style="text-align:center">Reported</th>
		<th style="text-align:center">Rejected</th>
	</thead>
	<tbody>
	<?php 
	$tests_ordered=0;
	$tests_completed=0;
	$tests_reported=0;
	$tests_rejected=0;
	foreach($report as $s){
	?>
	<tr>
		<td><a href="<?php echo base_url()."reports/order_detail/$s->test_master_id/$s->department_id/$s->unit/$s->area/$s->test_area_id/$s->specimen_type_id/$s->test_method_id/$visit_type/$from_date/$to_date/-1/$type/$number";?>"><?php echo $s->department;?></a></td>
		<td><a href="<?php echo base_url()."reports/order_detail/$s->test_master_id/$s->department_id/$s->unit/$s->area/$s->test_area_id/$s->specimen_type_id/$s->test_method_id/$visit_type/$from_date/$to_date/-1/$type/$number";?>"><?php echo $s->test_method;?></a></td>
		<td><a href="<?php echo base_url()."reports/order_detail/$s->test_master_id/$s->department_id/$s->unit/$s->area/$s->test_area_id/$s->specimen_type_id/$s->test_method_id/$visit_type/$from_date/$to_date/-1/$type/$number";?>"><?php echo $s->test_name;?></a></td>
		<td><a href="<?php echo base_url()."reports/order_detail/$s->test_master_id/$s->department_id/$s->unit/$s->area/$s->test_area_id/$s->specimen_type_id/$s->test_method_id/$visit_type/$from_date/$to_date/0/$type/$number";?>"><?php echo $s->tests_ordered;?></a></td>
		<td><a href="<?php echo base_url()."reports/order_detail/$s->test_master_id/$s->department_id/$s->unit/$s->area/$s->test_area_id/$s->specimen_type_id/$s->test_method_id/$visit_type/$from_date/$to_date/1/$type/$number";?>"><?php echo $s->tests_completed;?></a></td>
		<td><a href="<?php echo base_url()."reports/order_detail/$s->test_master_id/$s->department_id/$s->unit/$s->area/$s->test_area_id/$s->specimen_type_id/$s->test_method_id/$visit_type/$from_date/$to_date/2/$type/$number";?>"><?php echo $s->tests_reported;?></a></td>
		<td><a href="<?php echo base_url()."reports/order_detail/$s->test_master_id/$s->department_id/$s->unit/$s->area/$s->test_area_id/$s->specimen_type_id/$s->test_method_id/$visit_type/$from_date/$to_date/3/$type/$number";?>"><?php echo $s->tests_rejected;?></a></td>
	</tr>
	<?php
	$tests_ordered+=$s->tests_ordered;
	$tests_completed+=$s->tests_completed;
	$tests_reported+=$s->tests_reported;
	$tests_rejected+=$s->tests_rejected;
	}
	if($this->input->post('test_master')) $test_master = $this->input->post('test_master'); else $test_master=-1;
	if($this->input->post('department')) $department = $this->input->post('department'); else $department=-1;
	if($this->input->post('unit')) $unit = $this->input->post('unit'); else $unit=-1;
	if($this->input->post('area')) $area = $this->input->post('area'); else $area=-1;
	if($this->input->post('lab_department')) $test_area = $this->input->post('lab_department'); else $test_area=-1;
	if($this->input->post('specimen_type')) $specimen_type = $this->input->post('specimen_type'); else $specimen_type=-1;
	if($this->input->post('test_method')) $test_method = $this->input->post('test_method'); else $test_method=-1;
	?>
	<tfoot>
		<th colspan="3">Total </th>
		<th ><a href="<?php echo base_url()."reports/order_detail/$test_master/$department/$unit/$area/$test_area/$specimen_type/$test_method/$visit_type/$from_date/$to_date/0/$type/$number";?>"><?php echo $tests_ordered;?></a></th>
		<th ><a href="<?php echo base_url()."reports/order_detail/$test_master/$department/$unit/$area/$test_area/$specimen_type/$test_method/$visit_type/$from_date/$to_date/1/$type/$number";?>"><?php echo $tests_completed;?></a></th>
		<th ><a href="<?php echo base_url()."reports/order_detail/$test_master/$department/$unit/$area/$test_area/$specimen_type/$test_method/$visit_type/$from_date/$to_date/2/$type/$number";?>"><?php echo $tests_reported;?></a></th>
		<th ><a href="<?php echo base_url()."reports/order_detail/$test_master/$department/$unit/$area/$test_area/$specimen_type/$test_method/$visit_type/$from_date/$to_date/3/$type/$number";?>"><?php echo $tests_rejected;?></a></th>
	</tfoot>
	</tbody>
	</table>
	<?php } else { ?>
	No Orders on the given date.
	<?php } ?>
	</div>