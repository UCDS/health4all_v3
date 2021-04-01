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
<script type="text/javascript">
function doPost(page_no){
	var page_no_hidden = document.getElementById("page_no");
  	page_no_hidden.value=page_no;
        $('#appointment').submit();
   }
function onchange_page_dropdown(dropdownobj){
   doPost(dropdownobj.value);    
}
</script>
<style type="text/css">
.page_dropdown{
    position: relative;
    float: left;
    padding: 6px 12px;
    width: auto;
    height: 34px;
    line-height: 1.428571429;
    text-decoration: none;
    background-color: #ffffff;
    border: 1px solid #dddddd;
    margin-left: -1px;
    color: #428bca;
    border-bottom-right-radius: 4px;
    border-top-right-radius: 4px;
    display: inline;
}
.page_dropdown:hover{
    background-color: #eeeeee;
    color: #2a6496;
 }
.page_dropdown:focus{
    color: #2a6496;
    outline:0px;	
}
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
}
.rows_per_page{
    display: inline-block;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.428571429;
    color: #555555;
    vertical-align: middle;
    background-color: #ffffff;
    background-image: none;
    border: 1px solid #cccccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    -webkit-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
}
.rows_per_page:focus{
    border-color: #66afe9;
    outline: 0;	
}
</style>

	<?php 
	$from_date=0;$to_date=0;
	if($this->input->post('from_date')) $from_date=date("Y-m-d",strtotime($this->input->post('from_date'))); else $from_date = date("Y-m-d");
	if($this->input->post('to_date')) $to_date=date("Y-m-d",strtotime($this->input->post('to_date'))); else $to_date = date("Y-m-d");
	$from_time=0;$to_time=0;
	if($this->input->post('from_time')) $from_time=date("H:i",strtotime($this->input->post('from_time'))); else $from_time = date("H:i",strtotime("00:00"));
	if($this->input->post('to_time')) $to_time=date("H:i",strtotime($this->input->post('to_time'))); else $to_time = date("H:i",strtotime("23:59"));
	$page_no = 1;	
	
	?>
<div class="row">
		<h4>Status of Appointments</h4>	
		<?php echo form_open("reports/appointments_status",array('role'=>'form','class'=>'form-custom','id'=>'appointment')); ?> 
			 <input type="hidden" name="page_no" id="page_no" value='<?php echo "$page_no"; ?>'>
                      
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
			  Phone : <input type="number" class="form-custom form-control" placeholder="Phone Number" name="phone" id="phone" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" value="<?php if($this->input->post('phone')) { echo $this->input->post('phone');  } ?>"  /> 
			  H4All ID : <input type="number" class="form-custom form-control" placeholder="Health4All ID" name="h4allid" id="h4allid" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" value="<?php if($this->input->post('h4allid')) { echo $this->input->post('h4allid'); } ?>"   /> 
			  OP No : <input type="number" class="form-custom form-control" name="opno" placeholder="OP Number" id="opno" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" value="<?php if($this->input->post('opno')) { echo $this->input->post('opno'); } ?>" /> 
			  Manual ID : <input type="text" class="form-custom form-control" name="manualid" placeholder="Manual ID" id="manualid" value="<?php if($this->input->post('manualid')) { echo $this->input->post('manualid'); } ?>"  /> 
			  Rows per page : <input type="number" class="rows_per_page form-custom form-control" name="rows_per_page" id="rows_per_page" min=<?php echo $lower_rowsperpage; ?> max= <?php echo $upper_rowsperpage; ?> step="1" value= <?php if($this->input->post('rows_per_page')) { echo $this->input->post('rows_per_page'); }else{echo $rowsperpage;}  ?> onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" /> 
			
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

<?php if(isset($report) && count($report)>0)
{ ?>
<div style='padding: 0px 2px;'>

<h5>Report as on <?php echo date("j-M-Y h:i A"); ?></h5>

</div>
<?php 
	if ($this->input->post('rows_per_page')){
		$total_records_per_page = $this->input->post('rows_per_page');
	}else{
		$total_records_per_page = $rowsperpage;
	}
	if ($this->input->post('page_no')) { 
		$page_no = $this->input->post('page_no');
	}
	else{
		$page_no = 1;
	}
	$total_records = $report_count[0]->count ;
	$total_no_of_pages = ceil($total_records / $total_records_per_page);
	if ($total_no_of_pages == 0)
		$total_no_of_pages = 1;
	$second_last = $total_no_of_pages - 1; 
	$offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2";	
?>

<ul class="pagination" style="margin:0">
<?php if($page_no > 1){
echo "<li><a href=# onclick=doPost(1)>First Page</a></li>";
} ?>
    
<li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
<a <?php if($page_no > 1){
echo "href=# onclick=doPost($previous_page)";

} ?>>Previous</a>
</li>
<?php
  if ($total_no_of_pages <= 10){  	 
	for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
	if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	        }else{
        echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
                }
        }
}
else if ($total_no_of_pages > 10){
	if($page_no <= 4) {			
 		for ($counter = 1; $counter < 8; $counter++){		 
		if ($counter == $page_no) {
	   		echo "<li class='active'><a>$counter</a></li>";	
		}else{
           		echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
                }
}

echo "<li><a>...</a></li>";
echo "<li><a href=# onclick=doPost($second_last)>$second_last</a></li>";
echo "<li><a href=# onclick=doPost($total_no_of_pages)>$total_no_of_pages</a></li>";
}
elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
echo "<li><a href=# onclick=doPost(1)>1</a></li>";
echo "<li><a href=# onclick=doPost(2)>2</a></li>";
echo "<li><a>...</a></li>";
for (
     $counter = $page_no - $adjacents;
     $counter <= $page_no + $adjacents;
     $counter++
     ) {		
     if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	}else{
        echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
          }                  
       }
echo "<li><a>...</a></li>";
echo "<li><a href=# onclick=doPost($counter) >$counter</a></li>";
echo "<li><a href=# onclick=doPost($total_no_of_pages)>$total_no_of_pages</a></li>";
}
else {
echo "<li><a href=# onclick=doPost(1)>1</a></li>";
echo "<li><a href=# onclick=doPost(2)>2</a></li>";
echo "<li><a>...</a></li>";
for (
     $counter = $total_no_of_pages - 6;
     $counter <= $total_no_of_pages;
     $counter++
     ) {
     if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	}else{
        echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
	}                   
     }
}
}  
?>
<li <?php if($page_no >= $total_no_of_pages){
echo "class='disabled'";
} ?>>
<a <?php if($page_no < $total_no_of_pages) {
echo "href=# onclick=doPost($next_page)";
} ?>>Next</a>
</li>

<?php if($page_no < $total_no_of_pages){
echo "<li><a href=# onclick=doPost($total_no_of_pages)>Last Page</a></li>";
} ?>
<?php if($total_no_of_pages > 0){
echo "<li><select class='page_dropdown' onchange='onchange_page_dropdown(this)'>";
for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                  echo "<option value=$counter ";
                  if ($page_no == $counter){
                   echo "selected";
                  }         
                  echo ">$counter</option>";
	}
echo "</select></li>";
} ?>
</ul>


<div style='padding: 0px 2px;'>
<h5>Page <?php echo $page_no." of ".$total_no_of_pages." (Total ".$total_records.")" ; ?></h5>

</div>
	


	<table class="table table-bordered table-striped" id="table-sort">
	<thead>
		<th>SNo</th>
		<th>Patient ID</th>
		<th>Patient ID Manual</th>
		<th>OP No.</th>
		<th>PatientInfo</th>
		<th>Phone</th>
		<th>Department</th>
		<th>Visit Name</th>
		<th>Appointment Time</th>
    		<th>Appointment Status</th>
    		<th>Appointment Status Update By/Time</th>
    		<th>Update Appointment Status</th>			
	</thead>
	<tbody>
	<?php 
	$sno=(($page_no - 1) * $total_records_per_page)+1 ; 
	
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
		<td><?php echo $s->patient_id_manual;?></td>
		<td><?php echo $s->hosp_file_no;?></td>
		<td><?php echo $s->name . ", " . $age . " / " . $s->gender." / ".$s->parent_spouse." / ";?> <?php if(!!$s->address && !!$s->place) echo $s->address.", ".$s->place; else echo $s->address." ".$s->place;   ?></td>
		<td><?php echo $s->phone;?></td>
		<td><?php echo $s->department;?></td>
		<td><?php echo $s->visit_name;?></td>
		<td><?php if(isset($s->appointment_date_time) && $s->appointment_date_time!="") 
				{echo date("j M Y", strtotime("$s->appointment_date_time")).", ".date("h:i A.", strtotime("$s->appointment_date_time"));} 
				else {echo $s->appointment_date_time="";}?></td>
		<td><?php echo $s->appointment_status;?></td>
		<td><?php echo $s->appointment_status_update_by_user . ", ";  if(isset($s->appointment_status_update_time) && $s->appointment_status_update_time!="") 
				{echo date("j M Y", strtotime("$s->appointment_status_update_time")).", ".date("h:i A.", strtotime("$s->appointment_status_update_time"));} 
				else {echo $s->appointment_status_update_time="";}?></td>		
		<td><?php if(((!isset($s->appointment_status) and $s->appointment_status=="" and $s->appointment_status==0) and $appointment_status_add==1) or $appointment_status_edit==1) { echo '
		<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal_' . $sno .'">Update</button>
		'; }?></td>
    		
	</tr>
	<?php $sno++;}	?>
	</tbody>
	</table>
<div style='padding: 0px 2px;'>

<h5>Page <?php echo $page_no." of ".$total_no_of_pages." (Total ".$total_records.")" ; ?></h5>

</div>

<ul class="pagination" style="margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 20px;
    margin-left: 0px;">
<?php if($page_no > 1){
echo "<li><a href=# onclick=doPost(1)>First Page</a></li>";
} ?>
    
<li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
<a <?php if($page_no > 1){
echo "href=# onclick=doPost($previous_page)";

} ?>>Previous</a>
</li>
<?php
  if ($total_no_of_pages <= 10){  	 
	for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
	if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	        }else{
        echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
                }
        }
}
else if ($total_no_of_pages > 10){
	if($page_no <= 4) {			
 		for ($counter = 1; $counter < 8; $counter++){		 
		if ($counter == $page_no) {
	   		echo "<li class='active'><a>$counter</a></li>";	
		}else{
           		echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
                }
}

echo "<li><a>...</a></li>";
echo "<li><a href=# onclick=doPost($second_last)>$second_last</a></li>";
echo "<li><a href=# onclick=doPost($total_no_of_pages)>$total_no_of_pages</a></li>";
}
elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
echo "<li><a href=# onclick=doPost(1)>1</a></li>";
echo "<li><a href=# onclick=doPost(2)>2</a></li>";
echo "<li><a>...</a></li>";
for (
     $counter = $page_no - $adjacents;
     $counter <= $page_no + $adjacents;
     $counter++
     ) {		
     if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	}else{
        echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
          }                  
       }
echo "<li><a>...</a></li>";
echo "<li><a href=# onclick=doPost($counter) >$counter</a></li>";
echo "<li><a href=# onclick=doPost($total_no_of_pages)>$total_no_of_pages</a></li>";
}
else {
echo "<li><a href=# onclick=doPost(1)>1</a></li>";
echo "<li><a href=# onclick=doPost(2)>2</a></li>";
echo "<li><a>...</a></li>";
for (
     $counter = $total_no_of_pages - 6;
     $counter <= $total_no_of_pages;
     $counter++
     ) {
     if ($counter == $page_no) {
	echo "<li class='active'><a>$counter</a></li>";	
	}else{
        echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
	}                   
     }
}
}  
?>
<li <?php if($page_no >= $total_no_of_pages){
echo "class='disabled'";
} ?>>
<a <?php if($page_no < $total_no_of_pages) {
echo "href=# onclick=doPost($next_page)";
} ?>>Next</a>
</li>

<?php if($page_no < $total_no_of_pages){
echo "<li><a href=# onclick=doPost($total_no_of_pages)>Last Page</a></li>";
} ?>
<?php if($total_no_of_pages > 0){
echo "<li><select class='page_dropdown' onchange='onchange_page_dropdown(this)'>";
for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
                  echo "<option value=$counter ";
                  if ($page_no == $counter){
                   echo "selected";
                  }         
                  echo ">$counter</option>";
	}
echo "</select></li>";
} ?>
</ul>
	<?php } else { ?>
	
	No patient registrations on the given date.
<?php }  ?>
</div>	

<?php if(isset($report) && count($report)>0){ ?>
<?php $sno=(($page_no - 1) * $total_records_per_page)+1;
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

			<?php echo form_open("reports/appointments_status",array('role'=>'form','class'=>'form-custom')); ?>
			<input type="hidden" name="appointment" value="true">
			<input type="hidden" name="visit_id" value="<?php echo $s->visit_id;?>">
			<input type="hidden" name="from_date" value="<?php echo $this->input->post('from_date');?>">
			<input type="hidden" name="to_date" value="<?php echo $this->input->post('to_date');?>">
			<input type="hidden" name="from_time" value="<?php echo $this->input->post('from_time');?>">
			<input type="hidden" name="to_time" value="<?php echo $this->input->post('to_time');?>">
			<input type="hidden" name="dateby" value="<?php echo $this->input->post('dateby');?>">	
			<input type="hidden" name="page_no" id="page_no" value='<?php echo $this->input->post('page_no');?>'>	
			<input type="hidden" name="rows_per_page" id="rows_per_page" value='<?php echo $this->input->post('rows_per_page');?>'>	
			<input type="hidden" name="phone" id="phone" value='<?php echo $this->input->post('phone');?>'>		
			<input type="hidden" name="h4allid" id="h4allid" value='<?php echo $this->input->post('h4allid');?>'>				
			<input type="hidden" name="opno" id="opno" value='<?php echo $this->input->post('opno');?>'>				
			<input type="hidden" name="manualid" id="manualid" value='<?php echo $this->input->post('manualid');?>'>						
			<div class="form-group">
				<label for="Appointment Status">Appointment Status*:</label>
				<select name="appointment_status_id_val" id="appointment_status_id" required class="form-control">
					<option value="">Select Appointment Status</option>
					<?php 
					foreach($all_appointment_status as $status){
						echo "<option value='".$status->id."'";
						if($s->appointment_status_id == $status->id) echo " selected ";
						echo ">".$status->appointment_status."</option>";
					}
					?>
				</select>	                        
			</div>				
				
			<div class="form-group">
				<label for="appointment_status_time">Appointment Status Date-Time*:</label>
				<input name="appointment_status_time" type="datetime-local" required
				       value="<?php if(isset($s->appointment_status_update_time) && $s->appointment_status_update_time!="") 
						{echo date("Y-m-d\TH:i", strtotime("$s->appointment_status_update_time"));} 
						else {echo date("Y-m-d\TH:i");}?>" 
				       		class="form-control">
			</div>

<div style="text-align:center;margin-top:5px">
			<button type="submit" class="btn btn-primary btn-sm"">Submit</button>
			<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Close</button>
</div>
			</form> 
		</div>
	</div>

	</div>
</div>
<?php $sno++;}?>
<?php }?>
 <!-- Modal -->
  
