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
	<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<h4>Equipments Summary Report</h4>	
		<?php echo form_open("equipments/view/equipments_summary",array('role'=>'form','class'=>'form-custom'));  ?>
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
					
					<select name="equipment_status" id="equipment" class="form-control" >
					<option value="">All</option>	
					<option value="1" <?php if($this->input->post('equipment_status') == '1') echo "selected";?>>Working</option>
					<option value="0" <?php if($this->input->post('equipment_status') == '0') echo "selected";?>>Not Working</option>
					</select>
					<input class="btn btn-sm btn-primary" type="submit" value="Submit" />
		</form>
	<br />
	<?php if(isset($summary) && count($summary)>0){ ?>
	
		<button type="button" class="btn btn-default btn-md print">
		  <span class="glyphicon glyphicon-print"></span> Print
		</button>
	<table class="table table-bordered table-striped" id="table-sort">
	<thead>
	<tr>
		<td style="text-align:center" >#</th>
		<td style="text-align:center" >Equipment Type</th>
		<td style="text-align:center" >Department</th>
		<td style="text-align:center" >Unit</th>
		<td style="text-align:center" >Area</th>
		<td style="text-align:center" >Working</th>
		<td style="text-align:center" >Not Working</th>
		<td style="text-align:center" >Total</th>
	</tr>

	</thead>
	<tbody>
	<?php 

	$total_working=0;
	$total_not_working=0;
	$total_=0;
	$serial_number =1;

	foreach($summary as $s){
	?>
	<tr>
		<td><?php echo $serial_number++;
			$sub_url="equipments/view/equipments_detailed/";			?></td>
		<td><a href="<?php echo base_url().$sub_url."$s->equipment_type_id/$s->department_id/$s->area_id/$s->unit_id/-1";?>"><?php echo $s->equipment_type;?></a></td>

		<td><a href="<?php echo base_url().$sub_url."$s->equipment_type_id/$s->department_id/$s->area_id/$s->unit_id/-1";?>"><?php echo $s->department;?></a></td>
		<td><a href="<?php echo base_url().$sub_url."$s->equipment_type_id/$s->department_id/$s->area_id/$s->unit_id/-1";?>"><?php echo $s->unit_name;?></td>
		<td><a href="<?php echo base_url().$sub_url."$s->equipment_type_id/$s->department_id/$s->area_id/$s->unit_id/-1";?>"><?php echo $s->area_name;?></td>
		<td class="text-right"><a href="<?php echo base_url().$sub_url."$s->equipment_type_id/$s->department_id/$s->area_id/$s->unit_id/1";?>"><?php echo $s->total_working;?></td>
		<td class="text-right"><a href="<?php echo base_url().$sub_url."$s->equipment_type_id/$s->department_id/$s->area_id/$s->unit_id/0";?>"><?php echo $s->total_not_working;?></td>
		<td class="text-right"><a href="<?php echo base_url().$sub_url."$s->equipment_type_id/$s->department_id/$s->area_id/$s->unit_id/-1";?>"><?php echo $s->total;?></td>

	</tr>
	<?php
	$total_working+=$s->total_working;
	$total_not_working+=$s->total_not_working;
	$total+=$s->total;
	}
	?>
	<tfoot>
		<th>Total </th>
		<th></th>
		<th></th>
		<th></th>
		<th></th>
		<th class="text-right" ><?php echo $total_working;?></th>
		<th class="text-right" ><?php echo $total_not_working;?></th>
		<th class="text-right" ><?php echo $total;?></th>
	</tfoot>
	</tbody>
	</table>
	<?php } else { ?>
	No Equipments are present under given criteria.
	<?php } ?>
	</div>
</div>

