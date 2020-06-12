<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >

<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
	<script>
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
	$("#from_date,#to_date").Zebra_DatePicker();
	$("#test_master").chained("#test_method");
		});
	</script>
	<?php 
	?>
	<div class="row">
		<h4>Test Order Detailed report</h4>	
		<?php echo form_open("reports/order_summary/$type",array('role'=>'form','class'=>'form-custom')); ?> 
					From Date : <input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($from_date)); ?>" name="from_date" id="from_date" size="15" />
					To Date : <input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($to_date)); ?>" name="to_date" id="to_date" size="15" />
					<select name="lab_department" class="form-control">
					<option value="">Lab</option>
					<?php 
					foreach($lab_departments as $dept){
						echo "<option value='".$dept->test_area_id."'";
						if($test_area == $dept->test_area_id) echo " selected ";
						echo ">".$dept->test_area."</option>";
					}
					?>
					</select>
					<select name="test_method" id="test_method" class="form-control">
					<option value="">Method</option>
					<?php 
					foreach($test_methods as $method){
						echo "<option value='".$method->test_method_id."'";
						if($test_method == $method->test_method_id) echo " selected ";
						echo ">".$method->test_method."</option>";
					}
					?>
					</select>
					<select name="specimen_type" class="form-control">
					<option value="">Specimen</option>
					<?php 
					foreach($specimen_types as $specimen){
						echo "<option value='".$specimen->specimen_type_id."'";
						if($specimen_type == $specimen->specimen_type_id) echo " selected ";
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
							if($test_master_id == $test_master->test_master_id) echo " selected ";
							echo ">".$test_master->test_name."</option>";
						}
						?>
						</select>
						<select name="department" id="department" class="form-control">
						<option value="">Department</option>
						<?php 
						foreach($all_departments as $dept){
							echo "<option value='".$dept->department_id."'";
							if($department == $dept->department_id) echo " selected ";
							echo ">".$dept->department."</option>";
						}
						?>
						</select>
						<select name="unit" id="unit" class="form-control" >
						<option value="">Unit</option>
						<?php 
						foreach($units as $unit){
							echo "<option value='".$unit->unit_id."' class='".$unit->department_id."'";
							if($unit_id == $unit->unit_id) echo " selected ";
							echo ">".$unit->unit_name."</option>";
						}
						?>
						</select>
						<select name="area" id="area" class="form-control" >
						<option value="">Area</option>
						<?php 
						foreach($areas as $area){
							echo "<option value='".$area->area_id."' class='".$area->department_id."'";
							if($area_id == $area->area_id) echo " selected ";
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
	
	<?php 
	if(isset($report) && count($report)>0){ ?>
		<button type="button" class="btn btn-default btn-md print">
		  <span class="glyphicon glyphicon-print"></span> Print
		</button>
		<a href="" class="btn btn-default btn-md">
		  <span class="glyphicon glyphicon-text"></span> View Report Text
		</a>
		<table class="table table-bordered table-striped table-hover" id="table-sort">
		<thead>
			<th>#</th>
			<th>Order Date</th>
			<th>Patient</th>
			<th>Test</th>
			<th>Report</th>
		</thead>
		<tbody>
				<?php
				$i=1;
				foreach($report as $order) {
				if($order->binary_result == 0 && $order->numeric_result == 0 && $order->text_result==1) {
				?>
				<tr onclick="$('#order_<?php echo $order->test_id;?>').submit()">
						<td>
							<?php echo form_open("register/update_patients",array('role'=>'form','class'=>'form-custom','id'=>'order_'.$order->test_id)); ?>
							<?php echo $i++; ?>
							<input type="hidden" class="sr-only" name="visit_id" value="<?php echo $order->visit_id;?>" />
							</form>
						</td>
						<td>
							<?php echo date("d-M-Y",strtotime($order->order_date_time));?>
						</td>
						<td><?php echo $order->visit_type." #".$order->hosp_file_no;?>, 
						<?php echo $order->first_name." ".$order->last_name;?>,						
						<?php
							$age="";
							if($order->age_years!=0) $age.=$order->age_years."Y ";
							if($order->age_months!=0) $age.=$order->age_months."M ";
							if($order->age_days!=0) $age.=$order->age_days."D ";
							echo $age;
						?>
						</td>
						<td>
							<?php 
											if($order->test_status==1)
												$label="label-warning";
											else if($order->test_status == 3){ $label = "label-danger";}
											else if($order->test_status == 2){ $label = "label-success";}
											else if($order->test_status == 0){ $label = "label-default";}
											echo $order->test_name."<br />";
							?>
						</td>
						<td>
							<?php echo $order->test_result_text;?>
						</td>
				</tr>
			<?php }} ?>
		</tbody>
		</table>
		
	<?php } else { ?>
	No tests on the given date.
	<?php } ?>
	</div>