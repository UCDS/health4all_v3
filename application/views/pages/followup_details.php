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
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
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
<script type="text/javascript">

// var selectizes = {};
// 	function initPrioritySelectize(){
//         var priority = JSON.parse(JSON.stringify(<?php echo json_encode($priority); ?>));
// 		selectizes['priority_type'] = $('#priority_type_id').selectize({
// 			valueField: 'priority_type_id',
// 			labelField: 'custom_data',
// 			searchField: ['priority_type'],
// 			options: priority,
// 			create: false,
// 			render: {
// 				option: function(item, escape) {
// 					return '<div>' +
// 						'<span class="title">' +
// 							'<span class="prescription_drug_selectize_span">'+escape(item.custom_data)+'</span>' +
// 						'</span>' +
// 					'</div>';
// 				}
// 			},
// 			load: function(query, callback) {
// 				if (!query.length) return callback();
// 			},

// 		});
// 	}	


$(document).ready(function(){
	// //initPrioritySelectize();
	// $("#from_date").datepicker({
	// 	dateFormat:"dd-M-yy",changeYear:1,changeMonth:1,onSelect:function(sdt)
	// 	{$("#to_date").datepicker({dateFormat:"dd-M-yy",changeYear:1,changeMonth:1})
	// 	$("#to_date").datepicker("option","minDate",sdt)}})
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
function doPost(page_no){
	var page_no_hidden = document.getElementById("page_no");
  	page_no_hidden.value=page_no;
        $('#followp_list').submit();
   }
function onchange_page_dropdown(dropdownobj){
   doPost(dropdownobj.value);    
}
</script>



	<?php 
	
	$page_no = 1;	
	
	?>
	<div class="row">
	<div class="panel panel-default" >
		<div class="panel-heading">
			<h4>Search follow-Up Details</h4>	
		</div>
		<?php echo form_open("reports/followup_detail",array('role'=>'form','class'=>'form-custom','id'=>'followup_list')); ?> 

                <label style=" margin-left: 50px"><b>Life Status:  </b></label>
				<label><input type="radio" name="life_status" class ="form-control" value="0" <?php if($this->input->post('life_status') == 0)  echo "checked" ; ?>  >Not Alive </label>
				<label><input type ="radio" name="life_status" class ="form-control" value="1" <?php if($this->input->post('life_status') == 1)  echo "checked" ; ?> > Alive</label><br>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

      		    Search by : <select name="last_visit_type" id="last_visit_type" class="form-control"> 
				  <option value="">Last Visit Type</option>  
                        <option value="IP" <?php echo ($this->input->post('last_visit_type') == 'IP') ? 'selected' : ''; ?> >IP</option> 
						<option value="OP" <?php echo ($this->input->post('last_visit_type') == 'OP') ? 'selected' : ''; ?> >OP</option>          
                        </select>
                <select name="priority_type" id="priority_type" class="form-control">
                <option value="">Priority Type</option>
				<?php foreach($priority_types as $type){
                    echo "<option value='".$type->priority_type_id."'";
                    if($this->input->post('priority_type') && $this->input->post('priority_type') == $type->priority_type_id) echo " selected ";
                    echo ">".$type->priority_type."</option>";
                }
                ?>
                </select>

                <select name="volunteer" id="volunteer" class="form-control" >
                <option value="">Volunteer</option>
				<?php foreach($volunteer as $volunteer){
                     echo "<option value='".$volunteer->staff_id."'";
                     if($this->input->post('first_name') && $this->input->post('first_name') == $volunteer->staff_id) echo " selected ";
                     echo ">".$volunteer->first_name."</option>";
                }
                ?>
                </select>

                <select name="route_primary" id="route_primary" class="form-control" >
                    <option value="">Primary Route</option>
					<?php foreach($route_primary as $primary){
						echo "<option value='".$primary->route_primary_id."'";
						if($this->input->post('route_primary') && $this->input->post('route_primary') == $primary->route_primary_id) echo " selected ";
						echo ">".$primary->route_primary."</option>";
                    }
                 ?>
                </select>

                <select name="route_secondary" id="route_secondary" class="form-control" >
                    <option value="">Secondary Route</option>
					<?php foreach($route_secondary as $secondary){
						echo "<option value='".$secondary->id."'";
						if($this->input->post('route_secondary') && $this->input->post('route_secondary') == $secondary->id) echo " selected ";
						echo ">".$secondary->route_secondary."</option>";
                    }
                 ?>
                </select>

               
					<br>
					<label class="control-label" style="margin-left: 50px; margin-top: 10px;"> Rows per page : </label>
						<input type="number" class="rows_per_page form-custom form-control" name="rows_per_page" id="rows_per_page" min=<?php echo $lower_rowsperpage; ?> max= <?php echo $upper_rowsperpage; ?> step="1" value= <?php if($this->input->post('rows_per_page')) { echo $this->input->post('rows_per_page'); }else{echo $rowsperpage;}  ?> onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" /> 
			<center><input class="btn btn-sm btn-primary" type="submit" value="Submit" style="margin-top: 20px"/></center>
		
	<br />
	 </div>
	 </div>
	 </form>

	<?php if(isset($results) && count($results)>0){ ?>
		<!-- <h5>Data as on <?php echo date("j-M-Y h:i A"); ?></h5> -->

		
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
	$total_records = $results_count[0]->count;
	//$total_records = 63;

	//$total_records = count($results);
	$total_no_of_pages = ceil($total_records / $total_records_per_page);
	if ($total_no_of_pages == 0)
		$total_no_of_pages = 1;
	$second_last = $total_no_of_pages - 1; 
	$offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2";	
?>
<div style='padding: 0px 2px;'>

<h5>Page <?php echo $page_no." of ".$total_no_of_pages." (Total ".$total_records.")" ; ?></h5>

</div>
<td><?php echo $followup->hosp_file_no;?></td>

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
	<table class="table table-bordered table-striped" id="table-sort">
	<thead>
	<th>SNo</th>
		<th>Patient ID</th>
		<th>Registered Date</th>
		<th>Patient Name/Age/Gender</th>
		<th>Relative Name</th>
		<th>Phone</th>
		<th>Address</th>
		<th>Status Date</th>
		<th> ICD Code</th>
    	<th>Diagnosis</th>
		<th> Last Visit Type</th>
		<th> Priority</th>
		<th> Primary Route</th>
		<th>SecondaryRoute</th>
		<th>Volunteer</th>			
	</thead>
	<tbody>
	<?php
	//print_r($results);
	$sno=(($page_no - 1) * $total_records_per_page)+1 ; 
		foreach($results as $followup){
	 ?>
	<tr>
		<td><?php echo $sno;?></td>
		<td><?php echo $followup->patient_id;?></td>
		<td><?php echo date('d/m/Y',strtotime($followup->insert_datetime));?></td>
		<td><?php echo $followup->first_name."".$followup->last_name ."/ ".$followup->age_years ."/" .$followup->gender;?></td>
		<?php if (!empty($followup->father_name)) { ?>
			<td><?php echo $followup->father_name; ?></td>			
					<?php } elseif (!empty($followup->mother_name)) { ?>
						<td><?php echo $followup->mother_name; ?>	</td>
							<?php } else { ?>
						<td><?php echo $followup->spouse_name; ?>	</td>
							<?php } ?>
		<td><?php echo $followup->phone;?></td>
		<td><?php echo $followup->address;?></td>
		<td><?php echo date('d/m/Y',strtotime($followup->status_date));?></td>
		<td><?php echo $followup->icd_code;?></td>
		<td><?php echo $followup->diagnosis;?></td>
		<td><?php echo $followup->last_visit_type;?></td>
		<td><?php echo $followup->priority_type; ?></td>
		<td><?php echo $followup->route_primary;?></td>
		<td><?php echo $followup->route_secondary;?></td>
		<td><?php echo $followup->fname." ".$followup->lname;?></td>

		<?php $sno++;} ?>
		
	</tr>
	</tbody>
	</table>

	<div style='padding: 0px 2px;'>

<h5>Page <?php echo $page_no." of ".$total_no_of_pages." (Total ".$total_records.")" ; ?></h5>

</div>
<td><?php echo $followup->hosp_file_no;?></td>

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
						<?php } else{ ?>
						
						No Data to display.
					<?php }  ?> 
</div>	 
 

  
