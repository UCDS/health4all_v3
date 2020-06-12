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
<center>
<strong><?php if(isset($msg)){ echo $msg;}?></strong></center>
	<div class="col-md-8 col-md-offset-2">
		<h4> Service Issue</h4>	
		<?php echo form_open("equipments/edit/service_records",array('role'=>'form','class'=>'form-custom'));  ?>
				      
		           
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
<!--when  clicked  on tr this form will load --->
	<?php if(isset($mode)&& $mode=="select"){ ?>
	<center>	<h3>Edit  Service Issue</h3></center><br>
	<?php echo validation_errors(); echo form_open('equipments/edit/service_records',array('role'=>'form','id'=>'edit_service_record')); ?>

    
	<input type="hidden" class="form-control"  value='<?php echo $service_records[0]->request_id; ?>'   name="request_id" />
<div class="col-md-8">
	<div class="form-group">
		<div class="col-md-6">
		<label for="service_records" >Call Date<font color='red'>*</font></label>
		</div>
		<div  class="col-md-6">
	
		<input type="text" class="form-control" placeholder=" Call Date"  id="call_date" name="call_date"
<?php if(isset($service_records)){
			echo "value='".date("d-M-Y",strtotime($service_records[0]->call_date))."' ";
			}
		?>		/>
		
		</div>
	</div>
	</div>
	<br><br>
	<div class="col-md-8">
	<div class="form-group">
	<div class="col-md-6">
		<label for="service_records" >Call Time<font color='red'>*</font></label>
		</div>
		<div  class="col-md-6">
		<input type="text" class="time form-control"  size="6"  placeholder=" Call Time" id="service_records" name="call_time"
<?php if(isset($service_records)){
			echo "value='".$service_records[0]->call_time."' ";
			}
		?>		/>
		</div>
	</div></div><br><br>
		<div class="col-md-8">
<div class="form-group">
<div class="col-md-6">
		<label for="service_records" >Call Information Type</label>
		</div>
		<div  class="col-md-6">
		<input type="text" class="form-control" placeholder=" Call Information Type" id="service_records" name="call_information_type"
		
		<?php if(isset($service_records)){
			echo "value='".$service_records[0]->call_information_type."' ";
			}
		?>/>
		</div>
	</div></div><br><br>
		<div class="col-md-8">
<div class="form-group">
<div class="col-md-6">
		<label for="service_records" >Call Information</label>
		</div>
		<div  class="col-md-6">
	<textarea class="form-control" placeholder=" Call Information" id="service_records" name="call_information">	 
<?php if(isset($service_records)){
	        
			echo "".$service_records[0]->call_information." ";
			}
		?>		</textarea>
		</div>
	</div></div><br><br>
	
		<div class="col-md-8">
<div class="form-group">
<div class="col-md-6">
		<label for="description" > Working Status<font color='red'>*</font></label>
		</div>
		<div  class="col-md-6">
	
           <select id="service_records" class="form-control" name="working_status" placehoder="working_status">
		     
            <option value="1" <?php echo $service_records[0]->working_status == 1 ? " selected" : ""; ?>>Working</option>
		   <option value="0" <?php echo  $service_records[0]->working_status == 0 ? " selected" : ""; ;?>>Not Working</option>
</select>

		</div>
	</div></div><br><br>


	<div class="col-md-8">
<div class="form-group">
		<div class="col-md-6">
			<label for="vendor" >Vendor<font color='red'>*</font></label>
		</div>
			
			<div class="col-md-6">
			<select class="form-control" id="vendor_id" name="vendor_id">
				<option value=""> </option>
				<?php foreach($vendors as $d){
						echo "<option value='$d->vendor_id'";
			$service_records[0]->vendor_id==$d->vendor_id;
				echo " SELECTED ";
			echo ">$d->vendor_name</option>";
			
		} ?>
			</select>
		</div>	
	
	</div></div><br><br>
		
		<div class="col-md-8">
	<div class="form-group">
		<div class="col-md-6">
			<label for="contact_person_id" > Contact Person</label>
		</div>
		<div class="col-md-6">
			<select class="form-control" id="contact_person" name="contact_person">
				<option value=""> </option>
				<?php foreach($contact_persons as $d){
						echo "<option value='$d->contact_person_id'";
			$service_records[0]->contact_person_id==$d->contact_person_id;
				echo " SELECTED ";
			echo ">$d->contact_person_first_name</option>";
			
		} ?>
				
			
			</select>
		</div>	
		
	</div></div><br><br>
	


		<div class="col-md-8">
<div class="form-group">
<div class="col-md-6">
		<label for="service_records" >Service Person Remarks</label>
		</div>
		<div  class="col-md-6">
		<input type="text" class="form-control" placeholder="  Service Remarks" id="service_records" name="service_person_remarks"
<?php if(isset($service_records)){
			echo "value='".$service_records[0]->service_person_remarks."' ";
			}
		?>			/>
		</div>
	</div></div><br><br>
		<div class="col-md-8">
	<div class="form-group">
	<div class="col-md-6">
		<label for="service_records" >Service Date</label>
		</div>
		<div  class="col-md-6">
		<input type="text" class="form-control" placeholder="Service Date" id="service_date"  name="service_date"
         
		<?php if(isset($service_records)){
			echo "value='".date("d-M-Y",strtotime($service_records[0]->service_date))."' ";
			}
		?>		/>
		</div>
	</div></div><br><br>
	<div class="col-md-8">
	<div class="form-group">
	<div class="col-md-6">
		<label for="service_records" >Service Time</label>
		</div>
		
		<div  class="col-md-6">
		<input type="text" class=" time form-control" placeholder="   Service Time" id="service_records" name="service_time" 
		<?php if(isset($service_records)){
			echo "value='".$service_records[0]->service_time."' ";
			}
		?>/>
		</div>
		</div>
	</div>
	<div class="col-md-8">
	<div class="form-group">
	<div class="col-md-6">
		<label for="service_records" >Issue status </label>
		</div>
			<div class="col-md-6">
		
			
<select name="problem_status" class="form-control">
		<option value="">Select Problem Status</option>
     <option value="Issue Reported" <?php echo  $service_records[0]->problem_status == 'Issue Reported' ? " selected" : ""; ;?>>Issue Reported</option>
	 <option value="Service Visit Made" <?php echo  $service_records[0]->problem_status == 'Service Visit Made' ? " selected" : ""; ;?>>Service Visit Made</option>
     <option value="Under Observation" <?php echo  $service_records[0]->problem_status == 'Under Observation' ? " selected" : ""; ;?>>Under Observation</option>
     <option value="Issue Resolved" <?php echo  $service_records[0]->problem_status == 'Issue Resolved' ? " selected" : ""; ;?>>Issue Resolved</option>
	



</select>
</div>

		</div>
	</div><br><br>
	</div>

</div>
	
   	<div class="col-md-3 col-md-offset-4">
	<input class="btn btn-lg btn-primary btn-block" type="submit" value="Update" name="update">
	</div>
	</form>
	<?php } 
	if(isset($mode)&&($mode)== "filter"){ ?>
	 <!--when filter is clicked this form will load --->
	<h3 class="col-md-12">List of Service Records </h3>
	<div class="col-md-12 ">
	</div>	
<button type="button" class="btn btn-default btn-md print">
		  <span class="glyphicon glyphicon-print"></span> Print
		</button>
		<table class="table table-bordered table-striped" id="table-sort">
	<thead>
	<th>S.No</th><th>Equipment type</th><th>Call Date </th><th>Call Time</th><th>Call Information Type</th><th>Call Information</th><th>Vendor</th><th>Contact Person</th><th>Service Person Remarks</th>
	<th>Service Date</th><th>Service Time</th><th>Problem Status</th><th>Working Status</th></thead>
	<tbody>
	<?php 
	$i=1;
	foreach($service_summary as $a){ ?>
	<?php echo form_open('equipments/edit/service_records',array('id'=>'select_service_records_form_'.$a->request_id,'role'=>'form')); ?>
	<tr onclick="$('#select_service_records_form_<?php echo $a->request_id;?>').submit();" >
		<td><?php echo $i++; ?></td>
		<td> <?php echo $a->equipment_type; ?></td>
		<td><?php echo date("d-M-Y", strtotime("$a->call_date"));   ?>
		
		<input type="hidden" value="<?php echo $a->request_id; ?>" name="request_id" />
		<input type="hidden" value="select" name="select" />
		</td>
	
	     
		<td><?php echo date("h:i A", strtotime("$a->call_time"));  ?></td>
		<td><?php echo $a->call_information_type; ?></td>
		<td><?php echo $a->call_information; ?></td>
		<td><?php echo $a->vendor_name; ?></td>
	
		<td><?php echo $a->contact_person_first_name; ?>
		</td>
		<td><?php echo $a->service_person_remarks; ?></td>
		<td><?php  echo date("d-M-Y", strtotime("$a->service_date"));  ?></td>
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
	<?php } ?>
	</div></div>