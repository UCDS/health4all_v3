<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript">
$(document).ready(function(){$("#from_date").datepicker({
		dateFormat:"dd-M-yy",changeYear:1,changeMonth:1,onSelect:function(sdt)
		{$("#to_date").datepicker({dateFormat:"dd-M-yy",changeYear:1,changeMonth:1})
		$("#to_date").datepicker("option","minDate",sdt)}})
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
        $(document).ready(function(){
	// find the input fields and apply the time select to them.
        $('#from_time').ptTimeSelect();
	$('#to_time').ptTimeSelect();
        });
</script>
	<?php 
	$from_date=0;$to_date=0;
	if($this->input->post('from_date')) $from_date=date("Y-m-d",strtotime($this->input->post('from_date'))); else $from_date = date("Y-m-d");
	if($this->input->post('to_date')) $to_date=date("Y-m-d",strtotime($this->input->post('to_date'))); else $to_date = date("Y-m-d");
	$from_time=0;$to_time=0;
	if($this->input->post('from_time')) $from_time=date("H:i",strtotime($this->input->post('from_time'))); else $from_time = date("H:i",strtotime("00:00"));
	if($this->input->post('to_time')) $to_time=date("H:i",strtotime($this->input->post('to_time'))); else $to_time = date("H:i",strtotime("23:59"));
	$default_appointment_status = "";
	foreach($all_appointment_status as $status){
		if($status->is_default==1){
			$default_appointment_status = $status->appointment_status;
		}					
	}
	?>
<div class="row">
		<h4>Appointment Summary by Team Member</h4>	
		<?php echo form_open("reports/appointment_summary_by_volunteer",array('role'=>'form','class'=>'form-custom','id'=>'appointment')); ?>                      
			From Date : <input class="form-control" style = "background-color:#EEEEEE" type="text" value="<?php echo date("d-M-Y",strtotime($from_date)); ?>" name="from_date" id="from_date" size="15" />
			To Date : <input class="form-control" type="text" style = "background-color:#EEEEEE" value="<?php echo date("d-M-Y",strtotime($to_date)); ?>" name="to_date" id="to_date" size="15" />
	                From Time:<input  class="form-control" style = "background-color:#EEEEEE" type="text" value="<?php echo date("h:i A",strtotime($from_time)); ?>" name="from_time" id="from_time" size="7px"/>
                   	To Time:<input class="form-control" style = "background-color:#EEEEEE" type="text" value="<?php echo date("h:i A",strtotime($to_time)); ?>" name="to_time" id="to_time" size="7px"/>
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
			<select name="visit_name" id="visit_name" class="form-control" >
				<option value="">Visit Type</option>
				<?php 
				foreach($visit_names as $v){
				echo "<option value='".$v->visit_name_id."'";
				if($this->input->post('visit_name') && $this->input->post('visit_name') == $v->visit_name_id)  echo " selected ";
				echo ">".$v->visit_name."</option>";
				}
				?>
			</select>
			<div class="form-group">
				<select name="appointment_status_id" id="appointment_status_id" class="form-control">
					<option value="">Appointment Status</option>
					<?php 
					foreach($all_appointment_status as $status){
						echo "<option value='".$status->id."'";
						if($this->input->post('appointment_status_id') && $this->input->post('appointment_status_id') == $status->id) echo " selected ";
						echo ">".$status->appointment_status."</option>";
					}
					?>
				</select>	                        
			</div>	
			
			<input class="btn btn-sm btn-primary" type="submit" value="Submit" />
		</form>
	<br />


<?php if(isset($report) && count($report)>0)
{ ?>
<div style='padding: 0px 2px;'>

<h5>Report as on <?php echo date("j-M-Y h:i A"); ?></h5>

</div>
	<table class="table table-bordered table-striped" id="table-sort">
	<thead>
		<th style="text-align:center" rowspan="2">Date</th>
		<?php if ($default_appointment_status !=""){ ?>
		<th style="text-align:center" colspan="4">Details</th>
		<?php } else {?>
		<th style="text-align:center" colspan="2">Details</th>
		<?php } ?>
		<tr>
		<th>Volunteer</th><th>Appointments Created</th> 
		<?php if ($default_appointment_status !=""){ ?>
			<th><?php echo $default_appointment_status; ?></th>
			<th style="text-align:center"><?php echo "Percentage (%)"; ?></th>
		<?php } ?>
		</tr>				
 		
	</thead>
	<tbody>
	<?php 
	$sno=1 ; 
	$appointment_date="";
	$appointment_date_count=0;
	$total_appointmnets=0;
	$total_default_status_count=0;
	
	foreach($report as $s){
	 if($s->appointment_date != $appointment_date){
		$appointment_date_count=0;
		foreach($report as $s1){
			if ($s->appointment_date == $s1->appointment_date ){
				$appointment_date_count = $appointment_date_count + 1;
			}
		}
		
		?>
		<tr>      
		<td rowspan="<?php echo $appointment_date_count; ?>" > <?php echo date("d-M-Y", strtotime($s->appointment_date))." - ".$weekdays[date("w", strtotime($s->appointment_date))];  ?></td>		
		<td> <?php echo $s->appointment_update_by;  ?> </td>	
		<td style="text-align:right"> <?php echo $s->patient_count;  $total_appointmnets = $total_appointmnets + $s->patient_count;?></td>
		<?php if ($default_appointment_status !=""){ ?>
		<td style="text-align:right"> <?php echo $s->default_status_count;$total_default_status_count = $total_default_status_count + $s->default_status_count;?></td>
		<td style="text-align:right"> <?php echo round(($s->default_status_count/$s->patient_count)*100,0)."%"; ?></td>
		<?php } ?>		
		</tr>
		<?php  } else { ?>
		<tr>
		<td> <?php echo $s->appointment_update_by; ?> </td>	
		<td style="text-align:right"> <?php echo $s->patient_count;  $total_appointmnets = $total_appointmnets + $s->patient_count; ?></td>
		<?php if ($default_appointment_status !=""){ ?>
		<td style="text-align:right"> <?php echo $s->default_status_count;$total_default_status_count = $total_default_status_count + $s->default_status_count;?></td>
		<td style="text-align:right"> <?php echo round(($s->default_status_count/$s->patient_count)*100,0)."%"; ?></td>
		<?php } ?>	
		</tr>	
		<?php  } 
		$appointment_date = $s->appointment_date; 
		} ?>
		<tr>
		<td></td>
		<td><b>Total</b></td>
		<td style="text-align:right"><b><?php echo $total_appointmnets; ?></b></td>
		<?php if ($default_appointment_status !=""){ ?>
		<td style="text-align:right"><b><?php echo $total_default_status_count; ?></b></td>
		<td style="text-align:right"><b><?php echo round(($total_default_status_count/$total_appointmnets)*100,0)."%"; ?></b></td>
		<?php } ?>
		</tr>
	</tbody>
	</table>
	
	<?php  } else { ?>
	
	No patient registrations on the given date.
<?php }  ?>
</div>	
  
