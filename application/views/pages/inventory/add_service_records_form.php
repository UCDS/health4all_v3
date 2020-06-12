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
	<style>
	.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.42;
  border-radius: 15px;
}
	</style>
	<script>
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
<script type="text/javascript">
$(function(){
	$("#service_date,#calldate").Zebra_DatePicker({
			});
	
});
</script>
<script>
	$(function(){
		
		$(".time").timeEntry();
	
	});
</script>
<!--filters for Add Service Issues view form --->
<div class="row">
<center>
<strong><?php if(isset($msg)){ echo $msg;}?></strong></center>
	<div class="col-md-8 col-md-offset-2">
		<h4> Service Issue</h4>	
		<?php echo form_open("equipments/add/service_records",array('role'=>'form','class'=>'form-custom'));  ?>
		    
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
		<?php

	if(isset($mode)&& $mode=="select" || isset($mode)&& $mode=="submit" ){ ?>
	 <?php echo validation_errors(); echo form_open('equipments/add/service_records',array('role'=>'form','id'=>'add_service_record')); ?>


	<center>
	<!--when add is clicked this form is displayed  --->	
	<h3>Add Service Issue Details</h3>
	</center><br>
	
	    <div class="col-md-12">
		
		<div class="panel panel-default">
  <div class="panel-heading"></div>
  <div class="panel-body">

  
  
     <input type='hidden' class="form-control" name='equipment_type' value="equipment_type" />
     <input type='hidden' class="form-control" name='equipment_id' value='<?php  echo $equipments[0]->equipment_id; ?>' />
	     <table class="table">
		 <tr>
		<td><label><b>Equipment Type</b></label> </td>  <td> <?php  echo $equipments[0]->equipment_type; ?><br></td></tr>
		<tr><td><label><b>Model</b></label>  </td><td><?php echo $equipments[0]->model; ?><br></td></tr>
	    <tr><td><label><b>Serial Number</b></label> </td> <td>  <?php echo $equipments[0]->serial_number; ?><br></td></tr>
		<tr><td><label><b>Asset Number</b></label> </td> <td>  <?php echo $equipments[0]->asset_number; ?><br></td></tr>
		<tr><td><label><b>Department</b></label> </td> <td> <?php echo $equipments[0]->department; ?><br></td></tr>
		</table>
       </div>
	   </div>
 
  
  

		  <div class="col-md-12">
	<div class="form-group">
		<div class="col-md-3">
		<label for="drug_type" >Call Date<font color='red'>*</font></label>
		</div>
		<div  class="col-md-6">
		<input type="text" class="form-control" placeholder=" Call Date" form="add_service_record" id="calldate" name="call_date" required/>
		</div>
	</div><br><br>
	<div class="form-group">
	<div class="col-md-3">
		<label for="drug_type" >Call Time<font color='red'>*</font></label>
		</div>
		<div  class="col-md-6">
		<input type="text" class="time form-control" placeholder=" Call Time"  name="call_time" required/>
		</div>
	</div><br><br><br><br>
<div class="form-group">
<div class="col-md-3">
		<label for="drug_type" >Call Information Type</label>
		</div>
		<div  class="col-md-6">
		 <textarea class="form-control" placeholder=" Call Information Type"  name="call_information_type"></textarea>
		
		</div>
	</div><br><br><br><br>
<div class="form-group">
<div class="col-md-3">
		<label for="drug_type" >Call Information</label>
		</div>
		<div  class="col-md-6">
		<input type="textbox" class="form-control" placeholder=" Call Information" name="call_information" />
		</div>
	</div><br><br>
<div class="form-group">
<div class="col-md-3">
		<label for="description" > Working Status<font color='red'>*</font></label>
		</div>
		<div  class="col-md-6">
			<select name="working_status" id="division" class="form-control" required>
	<option	value="">Select Working Status</option>		
	<option	value="1">Working</option>		
	<option	value="0">Not Working</option>
</select>

		</div>
	</div><br><br>



<div class="form-group">
		<div class="col-md-3">
			<label for="vendor" >Vendor<font color='red'></font></label>
		</div>
		<div class="col-md-6">
			<select name="vendor_id" id="vendor_id" class="form-control">
		<option value="">--select--</option>
		
		<?php foreach($vendors as $d){
			echo "<option value='$d->vendor_id'>$d->vendor_name</option>";
			
		}
		?>
		</select>
		
		</div>
	</div><br><br>
		
	
	<div class="form-group">
		<div class="col-md-3">
			<label for="contact_person_id" > Contact Person</label>
		</div>
		<div class="col-md-6">
			<select name="contact_person" id="contact_person_id" class="form-control">
		<option value="">--select--</option>
		<?php foreach($contact_persons as $d){
			echo "<option value='$d->contact_person_id' class='$d->vendor_id' >$d->contact_person_first_name  $d->contact_person_last_name</option>";
		}
		?>
		</select>
		</div>
	</div><br><br>
	

	
	
<div class="form-group">
<div class="col-md-3">
		<label for="drug_type" >Service Person Remarks</label>
		</div>
		<div  class="col-md-6">
		<input type="text" class="form-control" placeholder="  Service Remarks"  name="service_person_remarks" />
		</div>
	</div><br><br>
	<div class="form-group">
	<div class="col-md-3">
		<label for="drug_type" >Service Date</label>
		</div>
		<div  class="col-md-6">
		<input type="text" class="form-control" placeholder="   Service Date"  form="add_service_record" id="service_date" name="service_date" />
		</div>
	</div><br><br>

	<div class="form-group">
	<div class="col-md-3">
		<label for="drug_type" >Service Time</label>
		</div>
		<div  class="col-md-6">
		<input type="text" class=" time form-control" placeholder="   Service Time"  name="service_time" />
		</div>
	</div><br><br><br><br>

	<div class="form-group">
	<div class="col-md-3">
		<label for="description" class="col-md-3"> Issue Status</label>
		</div>
		<div class="col-md-6">
		
<select name="problem_status" class="form-control">
		<option value="">Select Problem Status</option>

	<option value="Issue Reported">Issue Reported</option>
	<option value="Service Visit Made">Service Visit Made</option>
	<option value="Under Observation">Under Observation</option>
	<option value="Issue Resolved">Issue Resolved</option>



</select>


		</div>
	</div><br><br>
	
<br>

   	<div class="col-md-3 col-md-offset-4">
	<button class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="submit">Submit</button>
	
	</div>

	</div>
	</form>
		</div>
	  
			


	<?php }  ?>


		<?php  if(isset($mode)&& $mode=="filter")  { ?>
		
		<?php

	$equipment = array();
	$equipment_with_service_records = array();

	foreach($summary as $equipment){
		$service_record_status = array();
		foreach($service_records as $service_record){			
			if($equipment->equipment_id == $service_record->equipment_id){
				if($service_record->working_status==1){
					$service_record_status[] = [
						
						'service_record_id'=>$service_record->request_id,
						'status' => 'Closed'
						
					];
				}
				else{
					$service_record_status[] = [
						'service_record_id'=>$service_record->request_id,
						'status' => 'Existing'
					];
				}
				
			}
				
		}
		
		$equipment_with_service_records[] = ['equipment'=>$equipment,
				'service_record'=>$service_record_status
			]; 
	}
		
	?>
			<h3 class="col-md-12">List of Equipments </h3>
<!--when filter is clicked this form will load --->

	<table class="table table-bordered table-striped" id="table-sort">
	<thead>
	<th>S.No</th><th>Equipment Type </th><th>Make</th><th>Model</th><th>Serial Number</th><th>Asset Number</th><!--<th>Procured By</th><th>Cost</th><th>Supplier</th>-->
	<!--<th>Supply Date</th><th>Warranty Period</th><th>Service Engineer</th><th>Service Engineer Contact</th><th>Hospital</th>--><th>Department</th><th>Equipment Status</th><th>Add Service</th></thead>
	<tbody>
	<?php 
	$i=1;
	foreach($equipment_with_service_records as $equipment){ ?>
	<?php echo form_open('equipments/add/service_records',array('id'=>'select_equipment_form_'.$equipment['equipment']->equipment_id,'role'=>'form')); ?>
	<tr>
		<td><?php echo $i++; ?></td>
		<td><?php echo $equipment['equipment']->equipment_type; ?>
		
		
		</td>
			<td><?php echo $equipment['equipment']->make; ?></td>
	
		<td><?php echo $equipment['equipment']->model; ?></td>
		<td><?php echo $equipment['equipment']->serial_number; ?></td>
		<td><?php echo $equipment['equipment']->asset_number; ?></td>
		<!--<td><?php //echo $equipment->procured_by; ?></td>-->
		<!--<td><?php// echo $equipment->cost; ?></td>-->
		<!--<td><?php //echo $equipment->supplier; ?></td>-->
		
		<!--<td><?php //if($a->supply_date!=0 && $equipment->supply_date!=0) echo date("d-M-Y",strtotime($a->supply_date))." - ".date("d-M-Y",strtotime($a->supply_date)); ?></td>
		<td><?php //if($a->warranty_start_date!=0 && $equipment->warranty_end_date!=0) echo date("d-M-Y",strtotime($a->warranty_start_date))." - ".date("d-M-Y",strtotime($a->warranty_end_date)); ?></td>
		<td><?php //echo $equipment->service_engineer; ?></td>
		<td><?php //echo $equipment->service_engineer_contact; ?></td>
		<td><?php //echo $equipment->hospital; ?></td>-->
		<td><?php echo $equipment['equipment']->department; ?></td>
		<td><?php if($equipment['equipment']->equipment_status==1)
				{
					echo "Working";
				}
						else{
                        echo "Not working";	}?></td>
		
	
		<td>
		<button class='btn btn-danger btn-sm' value="<?php echo $equipment['equipment']->equipment_id;?>" type="submit" onclick="$('#select_equipment_form_<?php echo $equipment['equipment']->equipment_id;?>').submit();">Add </button>
		    <input type='hidden' class="form-control" name='equipment_type' value="equipment_type" />
		   <input type="hidden" value="<?php echo $equipment['equipment']->equipment_id; ?>" form="select_equipment_form_<?php echo $equipment['equipment']->equipment_id;?>" name="equipment_id" />
		
		<input type="hidden" value="select" form="select_equipment_form_<?php echo $equipment['equipment']->equipment_id;?>" name="select" />
		</form>
		           <br><br>
			      <?php foreach($equipment['service_record'] as $s){ ?>
				   <?php echo form_open('equipments/edit/service_records',array('id'=>'select_service_records_form_'.$service_record->request_id,'role'=>'form')); ?>
						<?php if($s['status']== 'Closed') {?>
						
						 <button class='btn btn-success btn-sm' value="<?php echo $s['service_record_id'];?>" type="submit" onclick="$('#select_service_records_form_<?php echo $s['service_record_id'];?>').submit();" >Closed</button>					
					    <input type="hidden" value="<?php echo $s['service_record_id']; ?>" name="request_id" />
		                            <input type="hidden" value="select" name="select"/>
					          
					</form>
				  <?php }} ?><br>
				  <?php foreach($equipment['service_record'] as $s){ ?>
				   <?php echo form_open('equipments/edit/service_records',array('id'=>'select_service_records_form_'.$s['service_record_id'],'role'=>'form')); ?>
						<?php		if($s['status']== 'Existing') {?>
									<button class='btn btn-warning btn-sm' value="<?php echo $s['service_record_id'];?>" type="submit"  value="<?php echo $s['service_record_id'];?>" type="submit" onclick="$('#select_service_records_form_<?php echo $s['service_record_id'];?>').submit();" >Existing</button>					
									<input type="hidden" value="<?php echo $s['service_record_id']; ?>" name="request_id" />
		                            <input type="hidden" value="select" name="select" />
									</form>
				  <?php }} ?>
							
						
		</td>	
	    
						</td></tr>			
	<?php } 
	 }?>
	 </div>
	</tbody>
	</table>
	