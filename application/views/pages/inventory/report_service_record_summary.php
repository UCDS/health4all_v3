<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >

<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
    <script type="text/javascript"
 src="<?php echo base_url();?>assets/js/jquery.timeentry.min.js"></script>
<script type="text/javascript"
 src="<?php echo base_url();?>assets/js/jquery.mousewheel.js"></script>
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

<script type="text/javascript">
$(function(){
	$("#call_date").Zebra_DatePicker({
			});
	
});
</script>
<script type="text/javascript">
$(function(){
	$("#service_date").Zebra_DatePicker({
			});
	
});
</script>
<script>
	$(function(){
		
		$(".time").timeEntry();
	
	});
</script>
<div class="row">
	<div class="col-md-10 col-md-offset-2">
		<h4> Service Issue</h4>	
		<?php echo form_open("equipments/view/service_record_summary",array('role'=>'form','class'=>'form-custom'));  ?>
				
		          
					
					<select name="equipment_type" id="equipment_type" class="form-control">
					<option value="">Equipment Type</option>
					<?php 
					foreach($equipment_types as $e){
						echo "<option value='".$e->equipment_type_id."'";
						if($this->input->post('equipment_type') && $this->input->post('equipment_type') == $e->equipment_type_id) echo " selected ";
						echo ">".$e->equipment_type."</option>";
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
					<label> Working Status</label>
					<select name="working_status" id="service_records" class="form-control" >
					<option value="">All</option>	
					<option value="1" <?php if($this->input->post('working_status') == '1') ?>>Working</option>
					<option value="0" <?php if($this->input->post('working_status') == '0') ;?>>Not Working</option>
					</select>
					
					
					<input class="btn btn-sm btn-primary" type="submit" name="filter" value="submit" />
		</form>
	<br />
	</div>




<div class="col-md-8 col-md-offset-2">

	
<?php if(isset($service_summary) && count($service_summary)>0){ ?>
	 
	<h3 class="col-md-12">List of Service Records </h3>
	<div class="col-md-12 ">
	</div>	
<button type="button" class="btn btn-default btn-md print">
		  <span class="glyphicon glyphicon-print"></span> Print
		</button>
		<table class="table table-bordered table-striped" id="table-sort">
	<thead>
	<th>S.No</th><th>equipment type</th><th>Call Date </th><th>Call Time</th><th>Call Information Type</th><th>Call Information</th><th>Vendor</th><th>Contact Person</th><th>Service Person Remarks</th>
	<th>Service Date</th><th>Service Time</th><th>Problem Status</th><th>Working Status</th></thead>
	<tbody>
	<?php 
	$i=1;
	foreach($service_summary as $a){ ?>
		<?php echo form_open('equipments/view/service_records_detail',array('id'=>'select_service_records_form_'.$a->request_id,'role'=>'form')); ?>
	<tr onclick="$('#select_service_records_form_<?php echo $a->request_id;?>').submit();" >
		<td><?php echo $i++; ?></td>
		<td> <?php echo $a->equipment_type?></td>
		<td><?php echo date("d-M-Y", strtotime("$a->call_date"));    ?>
		
		<input type="hidden" value="<?php echo $a->request_id; ?>" name="request_id" />
		<input type="hidden" value="select" name="select" />
		</td>
	
	
		<td><?php echo date("h:i A", strtotime("$a->call_time")); ?></td>
		<td><?php echo $a->call_information_type; ?></td>
		<td><?php echo $a->call_information; ?></td>
		<td><?php foreach($vendors as $d){
			echo "<option value='$d->vendor_id'>$d->vendor_name</option>";
		}
		?></td>
		<td><?php foreach($contact_persons as $d){
			echo "<option value='$d->contact_person_id' class='$d->contact_person_id' >$d->contact_person_first_name  </option>";
		}
		?></td>
		<td><?php echo $a->service_person_remarks; ?></td>
		<td><?php echo date("d-M-Y", strtotime("$a->service_date"));   ?></td>
		<td><?php  echo date("h:i A", strtotime("$s->service_time"));  ?></td>
		<td><?php echo $a->problem_status; ?></td>
		<td><?php
				if($a->working_status==1)
				{
					echo "Working";
				}
						else{
                        echo "Not working";	}?></td>
		                
		


			</tr>
	</form>
	<?php } ?>
	</tbody>
	</table>
<?php } else { ?>
	No service records found  are present under given criteria.
	<?php } ?>
	</div></div>