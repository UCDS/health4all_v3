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
<script>
	$(document).ready(function() {
		$(document).on("click", ".discharge-btn", function(e) {
			e.preventDefault(); // Prevent the default action of the link
			
			var delete_id = $(this).data("id"); // Fetch the data-id attribute

			if (delete_id !== '') {
				if (confirm("Are you sure you want to discharge this patient?")) {
					$.ajax({
						type: "POST",
						url: "<?php echo base_url('hospital_beds/discharge_patient_allocated_bed'); ?>",
						data: { delete_id: delete_id },
						dataType: 'json',
						success: function(response) {
							alert("Patient Discharge Successful");
							location.reload();
						},
						error: function(error) {
							console.error("Error discharging patient:", error);
						}
					});
				}
			}
		});
	});

	function myKeyUp(inputElement) 
	{
		var inputValue = $(inputElement).val();
		var url = '<?php echo base_url("hospital_beds/fetch_patient_details"); ?>';
		var bedIndex = inputElement.id.split('_')[2]; // Extracting the index from input id
		$.ajax({
			url: url,
			type: 'POST',
			data: { patient_id: inputValue },
			success: function(result) {
				console.log(result);
				var data = JSON.parse(result);
				if (data.length > 0) {
					var patientDetails = data[0];
					var fullName = `${patientDetails.first_name} ${patientDetails.last_name}`;
					var details = `${fullName} / ${patientDetails.age_years} / ${patientDetails.gender} / ${patientDetails.address} / ${patientDetails.diagnosis}`;
					$('#patient_details_' + bedIndex).val(details); // Setting textarea value based on index
				}
			},
			error: function(xhr, status, error) {
				console.error(xhr.responseText);
			}
		});
	}
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
<style>
	#footer { position: fixed; bottom: 0; width: 100%; } 
	.text-muted { margin-top:20px;text-align:center; } 
	.navbar  { position: fixed; top: 0; width: 100%; } 
	.pagination > .active > a, .pagination > .active > span, .pagination > .active > a:hover, .pagination > .active > span:hover, .pagination > .active > a:focus, .pagination > .active > span:focus{
		z-index:0!important;
	}
</style>
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
	
	$page_no = 1;	
	
	?>
		
	<div class="row col-md-offset-2">
	<h2 style="margin-top:12%"><?php echo $title; ?></h2>
		<?php echo form_open('hospital_beds/patient_allocate_beds',array('class'=>'form-group','role'=>'form','id'=>'appointment')); ?> 
		<input type="hidden" name="page_no" id="page_no" value='<?php echo "$page_no"; ?>'>
		<div class="row" style="margin-top:2%;">
			<div class="col-md-12">
			<?php 
			 	if(count($all_available_beds)!='0') 
				{
					foreach ($all_available_beds as $i => $abc) { 
					$bed_number = $i + 1; 
			?>
				<div class="col-md-4">
					<?php $hospital = $this->session->userdata('hospital'); ?>
					<div class="form-group">
						<label for="inputhospital_name" style="color:red;font-weight:bold;"></label>
						<input type="hidden" name="bed_id_<?php echo $i; ?>" value="<?php echo $abc->hospital_bed_id; ?>"> <!-- Index properly -->
						<input class="form-control" name="bed_name" id="inputbde_name" value="Bed <?php echo $bed_number ?>" type="text"  readonly style="color:#437bba!important;font-size:18px!important;">
						<input type="text" class="form-control" name="patient_id_<?php echo $i; ?>" id="patient_id_<?php echo $i; ?>"
    						value="" placeholder="Enter Patient Id" autocomplete="off" onkeyup="myKeyUp(this)">
						<textarea name="patient_details_<?php echo $i; ?>" class="form-control" id="patient_details_<?php echo $i; ?>" placeholder="Enter Patient Details" rows="5" cols="12"></textarea>
						<input type="checkbox" name="reserve_id_<?php echo $i; ?>" id="reserve_id_<?php echo $i; ?>" value="" onclick="toggleReserveDetails(<?php echo $i; ?>)"> &nbsp;Reserve Bed <br/><br/>
						<textarea name="reserve_details_<?php echo $i; ?>" id="reserve_details_<?php echo $i; ?>" placeholder="Patient Details" class="form-control" rows="5" cols="12"></textarea>
					</div>
				</div>
			<?php } } else { ?>
					<h4 style="text-align:center;font-size:20px;"> No Beds Available to allocate </h4>
			<?php } ?>
			<script>
				document.addEventListener("DOMContentLoaded", function() {
					var allAvailableBeds = <?php echo count($all_available_beds); ?>;
					for (var i = 0; i < allAvailableBeds; i++) {
						var reserveDetailsTextarea = document.getElementById('reserve_details_' + i);
						reserveDetailsTextarea.style.display = 'none';
					}
				});
				function toggleReserveDetails(index) {
					var reserveCheckbox = document.getElementById('reserve_id_' + index);
					var reserveDetailsTextarea = document.getElementById('reserve_details_' + index);
					var patientIdInput = document.getElementById('patient_id_' + index);
					var patientDetailsTextarea = document.getElementById('patient_details_' + index);

					if (reserveCheckbox.checked) {
						reserveDetailsTextarea.style.display = 'block';
						patientIdInput.style.display = 'none';
						patientDetailsTextarea.style.display = 'none';
					} else {
						reserveDetailsTextarea.style.display = 'none';
						patientIdInput.style.display = 'block';
						patientDetailsTextarea.style.display = 'block';
					}
				}
			</script>
			<input type="hidden" name="total_beds" value="<?php echo count($all_available_beds); ?>">
			</div>
				<input type="hidden" class="rows_per_page form-custom form-control" name="rows_per_page" id="rows_per_page" min=<?php echo $lower_rowsperpage; ?> max= <?php echo $upper_rowsperpage; ?> step="1" value= <?php if($this->input->post('rows_per_page')) { echo $this->input->post('rows_per_page'); }else{echo $rowsperpage;}  ?> onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" /> 
			    <input type="hidden" name="record_id" value="<?php echo $edit_bed['hospital_bed_id']; ?>" >
				<input class="btn btn-md btn-primary col-md-offset-5" type="submit" value="Submit" style="margin-top:2%;">
			</div>
		</form>
		<div class="container">
			<h3>Allocated Beds </h3>
			<div class="row" style="margin-top:2%;">
				<div class="col-md-12">
					<?php 
						foreach($all_allocated_beds as $aab)
						 {  
							if($aab->reservation_details=='')
							{
					?>
					<div class="col-md-4">
						<div class="form-group">
							<input type="text" name="bed_id" class="form-control" value="Bed No <?php echo $aab->hospital_bed_id; ?>" readonly
							style="font-size:18px;background-color:#5ce35c;color:black;">
							<input type="text" class="form-control" name="patient_id" id="patient_id"
								value="<?php echo $aab->patient_id; ?>" readonly>
							<textarea name="patient_details" class="form-control" id="patient_details"  rows="5" cols="12" readonly><?php echo $aab->details; ?>
							</textarea><br/>
							<a data-id="<?php echo $aab->id;?>" class="btn btn-success discharge-btn"
								style="color:white;text-decoration:none!important;background-color:#3de768!important;margin-left:30%;color:black;">Discharge Patient</a>
						</div>
					</div>
					<?php }else { ?>
						<div class="col-md-4">
							<div class="form-group">
								<input type="text" name="bed_id" class="form-control" value="Reserved Bed No <?php echo $aab->hospital_bed_id; ?>" 
								readonly style="font-size:18px;background-color:#ffa500a6;color:black;">
								<textarea name="reserve_details" id="reserve_details" class="form-control" rows="5" cols="12" readonly><?php echo $aab->reservation_details; ?>
								</textarea><br/>
								<a data-id="<?php echo $aab->id;?>" class="btn btn-warning discharge-btn"
									style="color:white;text-decoration:none!important;margin-left:30%;">Discharge Patient</a>
							</div>
						</div>
					<?php } }?>
				</div>
			</div>
		</div>
		<?php if (!empty($error) || $error!=0): ?>
			<span style="color: red;"><?php echo $error; ?></span>
		<?php elseif (isset($success)): ?>
			<span style="color: green;"><?php echo $success; ?></span>
		<?php endif; ?>
	<br /><br />


<?php if(isset($all_allocated_beds) && count($all_allocated_beds)>0)
{ ?>
<a href="#" id="toggleTable" style="font-size:15px;"> Click here to hide table</a>
<script>
    // JavaScript to toggle visibility and change link text
    document.addEventListener('DOMContentLoaded', function() {
        var toggleLink = document.getElementById('toggleTable');
        var tableContainer = document.getElementById('tableContainer');
		tableContainer.style.display = 'none';
		toggleLink.textContent = 'Click here to display data in table';
        // Initial state
        var tableVisible = true;
        toggleLink.addEventListener('click', function(e) {
            e.preventDefault();
            if (tableVisible) {
                tableContainer.style.display = 'none';
                toggleLink.textContent = 'Click here to display data in table';
                tableVisible = false;
            } else {
                tableContainer.style.display = 'block';
                toggleLink.textContent = 'Click here to hide table';
                tableVisible = true;
            }
        });
    });
</script>
<div id="tableContainer">
<div style='padding: 0px 2px;'> 
	<h3>List Allocated Beds</h3>
		<?php  echo form_open('hospital_areas/patient_allocate_beds',array('role'=>'form','class'=>'form-custom','id'=>'appointment')); ?>
				Rows per page : <input type="number" class="rows_per_page form-custom form-control" name="rows_per_page" id="rows_per_page" min=<?php echo $lower_rowsperpage; ?> max= <?php echo $upper_rowsperpage; ?> step="1" value= <?php if($this->input->post('rows_per_page')) { echo $this->input->post('rows_per_page'); }else{echo $rowsperpage;}  ?> onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" /> 
		<input type="submit" value="Search" name="submitBtn" class="btn btn-primary btn-sm" /> 
		</form><br/>
	<h5>Data as on <?php echo date("j-M-Y h:i A"); ?></h5>
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
	$total_records = $all_allocated_beds_count[0]->count ;
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
		<th style="text-align:center">#</th>
		<th style="text-align:center">Patient Id</th>
		<th style="text-align:center">Hospital Bed Id</th>
		<th style="text-align:center">Details</th>
		<th style="text-align:center">Reservation Details</th>
		<th style="text-align:center">Created Date / Time</th>
		<!-- <th style="text-align:center">Actions</th>				 -->
	</thead>
	<tbody>
	<?php 
	$sno=(($page_no - 1) * $total_records_per_page)+1 ; 
	
	foreach($all_allocated_beds as $aa) { 
	?>
	<tr>
		<td style="text-align:center"><?php echo $sno;?></td>	
		<td style="text-align:right"><?php echo $aa->patient_id; ?></td>
		<td style="text-align:right"><?php echo $aa->hospital_bed_id; ?></td>
		<td style="text-align:center"><?php echo $aa->details; ?></td>
		<td style="text-align:center"><?php echo $aa->reservation_details; ?></td>
		<td style="text-align:center"><?php echo date("j M Y", strtotime("$aa->created_date")); ?></td>
		<!-- <td style="text-align:center;">
			<a data-id="<?php echo $aa->id;?>" class="btn btn-warning discharge-btn"
			style="color:white;text-decoration:none!important;">Discharge Patient</a>
		</td> -->
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
	<?php }  ?>
	
</div>	
</div>
  
