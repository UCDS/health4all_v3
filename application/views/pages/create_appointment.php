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
	?>
<div class="row">
		<h4>Create Appointment</h4>	
		<?php echo form_open("reports/create_appointment",array('role'=>'form','class'=>'form-custom')); ?> 
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
				if($this->input->post('visit_name') && $this->input->post('visit_name') == $v->visit_name_id) echo " selected ";
				echo ">".$v->visit_name."</option>";
				}
				?>
			</select>
			<input class="btn btn-sm btn-primary" type="submit" value="Submit" />
		</form>
	<br />
<?php if($this->input->post('visit_id')) { ?>
<?php if($updated) { ?>
<div class="alert alert-success" role="alert">Updated Patient Record!</div>
<?php } else {?>
<div class="alert alert-danger" role="alert">Something went wrong</div>
<?php } ?>
<?php } ?>

<?php if(isset($report) && count($report)>0){ ?>
	<table class="table table-bordered table-striped" id="table-sort">
	<thead>
		<th>SNo</th>
		<th>Patient ID</th>
		<th>OP No.</th>
		<th>Consultation Request Time</th>
		<th>PatientInfo</th>
		<th>Related to</th>
		<th>From</th>
		<th>Phone</th>
		<th>Department</th>
    		<th>Request CreatedBy</th>
		<th>Doctor Consulted</th>
		<th>Appointment With</th>
		<th>Appointment Time</th>
		<th>Consultation Summary Sent</th>
		<th>Appointment Update By/Time</th>
    		<th>Update Appointment</th>
	</thead>
	<tbody>
	<?php 
	$sno=1;
	foreach($report as $s){
		$age="";
		if(!!$s->age_years) $age.=$s->age_years."Y ";
		if(!!$s->age_months) $age.=$s->age_months."M ";
		if(!!$s->age_days) $age.=$s->age_days."D ";
		if($s->age_days==0 && $s->age_months==0 && $s->age_years==0) $age.="0D";
	?>
	<tr>
		<td><?php echo $sno;?></td>
		<td><?php echo $s->patient_id;?></td>
		<td><?php echo $s->hosp_file_no;?></td>
		<td><?php echo date("j M Y", strtotime("$s->admit_date")).", ".date("h:i A.", strtotime("$s->admit_time"));?></td>
		<td><?php echo $s->name . ", " . $age . " / " . $s->gender;?></td>
		<td><?php echo $s->parent_spouse;?></td>
		<td><?php if(!!$s->address && !!$s->place) echo $s->address.", ".$s->place; else echo $s->address." ".$s->place;?></td>
		<td><?php echo $s->phone;?></td>
		<td><?php echo $s->department;?></td>
    		<td><?php echo $s->volunteer;?></td>
		<td><?php echo $s->doctor;?></td>
		<td><?php echo $s->appointment_with;?></td>
		<td><?php if(isset($s->appointment_date_time) && $s->appointment_date_time!="") 
				{echo date("j M Y", strtotime("$s->appointment_date_time")).", ".date("h:i A.", strtotime("$s->appointment_date_time"));} 
				else {echo $s->appointment_date_time="";}?></td>
		<td><?php if(isset($s->summary_sent_time) && $s->summary_sent_time!="")
				{echo date("j M Y", strtotime("$s->summary_sent_time")).", ".date("h:i A.", strtotime("$s->summary_sent_time"));}
				else {echo $s->summary_sent_time="";};?></td>
		<td><?php echo $s->appointment_update_by . ", "; 
				if(isset($s->appointment_update_time) && $s->appointment_update_time!="") 
				{echo date("j M Y", strtotime("$s->appointment_update_time")).", ".date("h:i A.", strtotime("$s->appointment_update_time"));} 
				else {echo $s->appointment_update_time="";}?></td>
		<td><?php if($s->signed==0 or $s->summary_sent_time=="") { echo '
		<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal_' . $sno .'">Update</button>
		'; }?></td>
	</tr>
	<?php $sno++;}	?>
	</tbody>
	</table>	
	<?php } else { ?>
	No patient registrations on the given date.
<?php } ?>
</div>	

<?php if(isset($report) && count($report)>0){ ?>
<?php $sno=1;
	foreach($report as $s){
	$age="";
	if(!!$s->age_years) $age.=$s->age_years."Y ";
	if(!!$s->age_months) $age.=$s->age_months."M ";
	if(!!$s->age_days) $age.=$s->age_days."D ";
	if($s->age_days==0 && $s->age_months==0 && $s->age_years==0) $age.="0D"; ?>

<div class="modal fade" id="myModal_<?php echo $sno; ?>" role="dialog">
	<div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header bg-primary text-white">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Update Appointment</h4>
		</div>
		<div class="modal-body">
			<div>
				<p>
				<span><b>Patient ID:</b> <?php echo $s->patient_id;?>,&nbsp;</span>
				<span><b>OP#:</b> <?php echo $s->hosp_file_no;?>,&nbsp;</span>
				<span><b>Date:</b> <?php echo date("j M Y", strtotime("$s->admit_date"));?>&nbsp;
				<?php echo date("h:i A.", strtotime("$s->admit_time"));?>,&nbsp;</span>
				</p>
				<p class="bg-primary text-white">
				<span><b>Patient:</b> <?php echo $s->name;?>,&nbsp;<?php echo $age;?>&nbsp;/&nbsp;
				<?php echo $s->gender;?>, &nbsp;<b>Related to:</b> <?php echo $s->parent_spouse;?>,&nbsp;</span>
				<span><b>From:</b> <?php if(!!$s->address && !!$s->place) echo $s->address.", ".$s->place; else echo $s->address." ".$s->place;?>,&nbsp;</span>
				<span><b>Ph:</b> <?php echo $s->phone;?>, &nbsp;</span>
				</p>
				<p>
				<span><b>OP Created By:</b> <?php echo $s->volunteer;?>,&nbsp;</span>
				<span><b>Doctor Consulted:</b> <?php echo $s->doctor;?></span>
				</p>	
			</div>	

			<?php echo form_open("reports/create_appointment",array('role'=>'form','class'=>'form-custom')); ?>
			<input type="hidden" name="create_appointment" value="true">
			<input type="hidden" name="visit_id" value="<?php echo $s->visit_id;?>">
			<input type="hidden" name="from_date" value="<?php echo $this->input->post('from_date');?>">
			<input type="hidden" name="to_date" value="<?php echo $this->input->post('to_date');?>">
			<input type="hidden" name="from_time" value="<?php echo $this->input->post('from_time');?>">
			<input type="hidden" name="to_time" value="<?php echo $this->input->post('to_time');?>">
						
			<div class="form-group">
				<label for="department">Department:</label>
				<select name="department_id" id="department" class="form-control">
					<option>Select Department</option>
					<?php 
					foreach($all_departments as $dept){
						echo "<option value='".$dept->department_id."'";
						if($s->department == $dept->department) echo " selected ";
						echo ">".$dept->department."</option>";
					}
					?>
				</select>
			</div>
				
			<div class="form-group">
				<label for="helpline_doctor">Appointment With:</label>
				<?php //var_dump($helpline_doctor); ?>
				<select name="appointment_with" id="helpline_doctor" class="form-control">
					<option value="NULL">Select Doctor</option>
					<?php 
					foreach($helpline_doctor as $doctor){
						echo "<option value='".$doctor->staff_id."'";
						if($s->appointment_with_id == $doctor->staff_id) echo " selected ";
						echo ">".$doctor->helpline_doctor."</option>";
					}
					?>
				</select>
			</div>
				
			<div class="form-group">
				<label for="appointment_time">Appointment Date-Time:</label>
				<input name="appointment_time" type="datetime-local" 
				       value="<?php if(isset($s->appointment_date_time) && $s->appointment_date_time!="") 
						{echo date("Y-m-d\TH:i", strtotime("$s->appointment_date_time"));} 
						else {echo $s->appointment_date_time="";}?>" 
				       		class="form-control">
			</div>
			
			<div class="form-group">
				<label for="summary_sent_time">Summary Sent Date-Time:</label>
				<input name="summary_sent_time" type="datetime-local" class="form-control" >
			</div>

			<button type="submit" class="btn btn-default">Submit</button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

			</form> 
		</div>
	</div>

	</div>
</div>
<?php $sno++;}?>
<?php }?>
 <!-- Modal -->
  
