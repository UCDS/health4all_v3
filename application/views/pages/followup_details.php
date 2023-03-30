<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.chained.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
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

<style type="text/css">
	.selectize-control.repositories .selectize-dropdown > div {
border-bottom: 1px solid rgba(0,0,0,0.05);
}
.selectize-control {
display: inline-grid;
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
		<h4>Out Patient Detail 3</h4>	
		<?php echo form_open("reports/op_detail_3",array('role'=>'form','class'=>'form-custom','id'=>'appointment')); ?> 
			 <input type="hidden" name="page_no" id="page_no" value='<?php echo "$page_no"; ?>'>

			 		<div class="row">		
					 <div class="col-md-4">
							<div class="form-group">
								<label for="inputstatus ">Life Status <span class="mandatory" >*</span></label><br>
								&nbsp;&nbsp;  <input type="radio" name="life_status" id="life_status_live"  value="1" onchange=lifeStatusUpdate(); >
								<label for="staus_alive">Alive</label>&nbsp;&nbsp;
								<input type="radio" name="life_status" id="life_status_notlive" value="0" onchange=lifeStatusUpdate(); >
								<label for="status_dead">Not Alive</label><br>
								<span style="color:red;" id="error_life_status"></span>

							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label">Last Visit Type <span class="mandatory">*</span> </label>
								<select class="form-control" name="last_visit_type"  onchange="lastVisitType();">
									<option value="Select">Select</option>
									<option value=''>All</option>
								    <option value='IP'>IP</option>
								    <option value='OP'>OP</option>  
									<!-- <?php foreach($helplines as $helpline){
									//echo "<option value='$helpline->helpline_id'>$helpline->helpline - $helpline->note</option>";
									}
									?> -->
								</select>
								<span style="color:red;" id="error_lastvs_type"></span>
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label">Priority Type </label>
								<select class="form-control" name="priority_type" >
									<option value="Select">Select</option>
									 <?php foreach($priority_types as $type){
									echo "<option value='$type->priority_type_id'>$type->priority_type</option>";
									}
									?> 
								</select>
							</div>
						</div>
					</div>

					<div class="row">		
					<div class="col-md-4">
							<div class="form-group">
								<label class="control-label">Volunteer </label>
								<select class="form-control" name="volunteer" >
									<option value="Select">Select</option>
									 <!-- <?php //foreach($helplines as $helpline){
									// echo "<option value='$helpline->helpline_id'>$helpline->helpline - $helpline->note</option>";
									//}
									?>  -->
								</select>
							</div>
						</div>			

						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label">Primary Route</label>
								<input class="form-control"  type="text"  name="primary_route" id="primary_route" placeholder="Enter Latitude,Longitude"/>

							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label">Secondary Route</label>
								<input class="form-control"  type="text"  name="secondary_route" id="secondary_route" placeholder="Enter Latitude,Longitude"/>

							</div>
						</div>
					</div>
					<br>
			
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
		<th>OP No.</th>
		<th>Registered Time</th>
		<th>PatientInfo</th>
		<th>Address</th>
		<th>Phone</th>
		<th>Department</th>
		<th>Visit Type</th>
    		<th>Registered By</th>
		<th>Doctor Consulted</th>
		<th>Appointment With</th>
		<th>Appointment Time</th>
		<th>Final diagnosis</th>
		<th>Decision</th>		
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
		<td><?php echo $s->hosp_file_no;?></td>
		<td><?php echo date("j M Y", strtotime("$s->admit_date")).", ".date("h:i A.", strtotime("$s->admit_time"));?></td>
		<td><?php echo $s->name . ", " . $age . " / " . $s->gender." / ".$s->parent_spouse;?> </td>
		<td><?php if(!!$s->address && !!$s->place) echo $s->address.", ".$s->place; else echo $s->address." ".$s->place;
		if (!!$s->district) echo "<br/>, ".$s->district." District";
		if (!!$s->state) echo ", ".$s->state;   ?></td>
		<td><?php echo $s->phone;?></td>
		<td><?php echo $s->department;?></td>
		<td><?php echo $s->visit_name;?></td>
    		<td><?php echo $s->volunteer;?></td>
		<td><?php echo $s->doctor;?></td>
		<td><?php echo $s->appointment_with;?></td>
		<td><?php if(isset($s->appointment_date_time) && $s->appointment_date_time!="") 
				{echo date("j M Y", strtotime("$s->appointment_date_time")).", ".date("h:i A.", strtotime("$s->appointment_date_time"));} 
				else {echo $s->appointment_date_time="";}?></td>
		<td><?php echo $s->final_diagnosis;?></td>
		<td><?php echo $s->decision;?></td>
		
		
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
	
	No Data to display.
<?php }  ?>
</div>	

  
