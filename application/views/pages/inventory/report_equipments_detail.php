<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
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

		  print_title      : 'Equipment',          // this option > caption > table id > "table"
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
	$("#warranty_start_date,#warranty_end_date").Zebra_DatePicker();
	$("#supply_date").Zebra_DatePicker({
		onSelect : function(date){
		$("#warranty_start_date").val(date);
		}
	});
	
	//$("#vendor").on('change',function(){
	//	var vendor_id=$(this).val();
	//	$("#contact_person_id option").hide();
	//	$("#contact_person_id option[class="+vendor_id+"]").show();
	//});
});
</script>
<script>
$("#department").on('change',function(){
		var department_id=$(this).val();
		$("#unit option,#area option").hide();
		$("#unit option[class="+department_id+"],#area option[class="+department_id+"]").show();
	});
</script>
<div class="row">
<center>
<strong><?php if(isset($msg)){ echo $msg;}?></strong></center>
	<div class="col-md-8 col-md-offset-2">
		<h4> Equipments Details</h4>	
		<?php echo form_open("equipments/view/equipments_detail",array('role'=>'form','class'=>'form-custom'));  ?>
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
					<option value="1" <?php if($this->input->post('equipment_status') == '1') ?>>Working</option>
					<option value="0" <?php if($this->input->post('equipment_status') == '0') ;?>>Not Working</option>
					</select>
					<input class="btn btn-sm btn-primary" type="submit" name="filter" value="submit" />
		</form>
	<br />
	</div>
	</div>

<div class="col-md-8 col-md-offset-2">

	



	<button type="button" class="btn btn-default btn-md print">
		  <span class="glyphicon glyphicon-print"></span> Print
		</button>
	
	
	<h3 class="col-md-12">List of Equipments </h3>
	<table class="table table-bordered table-striped" id="table-sort">
	<thead>
	<th>S.No</th><th>Equipment Type </th><th>Make</th><th>Model</th><th>Serial Number</th><th>Asset Number</th><th>Procured By</th><th>Cost</th>
	<th>Supply Date</th><th>Warranty Period</th><th>Service Engineer</th><th>Service Engineer Contact</th><th>Department</th><th>Equipment Status</th></thead>
	<tbody>
	<?php 
	$i=1;
	foreach($summary as $a){ ?>
	<?php echo form_open('equipments/view/equipments_detail',array('id'=>'select_equipment_form_'.$a->equipment_id,'role'=>'form')); ?>
	<tr onclick="$('#select_equipment_form_<?php echo $a->equipment_id;?>').submit();" >
		<td><?php echo $i++; ?></td>
		<td><?php echo $a->equipment_type; ?>
		
		<input type="hidden" value="<?php echo $a->equipment_id; ?>" name="equipment_id" />
		<input type="hidden" value="select" name="select" />
		</td>
			<td><?php echo $a->make; ?></td>
	
		<td><?php echo $a->model; ?></td>
		<td><?php echo $a->serial_number; ?></td>
		<td><?php echo $a->asset_number; ?></td>
		<td><?php echo $a->procured_by; ?></td>
		<td><?php echo $a->cost; ?></td>
		 
		
		<td><?php if($a->supply_date!=0 && $a->supply_date!=0) echo date("d-M-Y", strtotime("$a->supply_date")); ?></td>
		
		<td><?php if($a->warranty_start_date!=0 && $a->warranty_end_date!=0) echo date("d-M-Y", strtotime("$a->warranty_end_date")); ?></td>
		<td><?php echo $a->service_engineer; ?></td>
		<td><?php echo $a->service_engineer_contact; ?></td>
		<!--<td><?php //echo $a->hospital; ?></td>-->
		<td><?php echo $a->department; ?></td>
		<td><?php if($a->equipment_status==1)
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
	



	</div>
</div>
</div>