<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.chained.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/ckeditor.js"></script>
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
#footer {
    height: 60px;
    background-color: #f5f5f5;
    bottom: 0px !important;
    position: fixed;
    width: 100%;
	z-index: 2;
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
	<h3><?php echo $title; ?></h3><br>
		
		<input type="hidden" name="page_no" id="page_no" value='<?php echo "$page_no"; ?>'>
			<div class="col-md-12 row">
				<div class="col-md-4">
					<label class="form-group">Search duplicate patient id  </label><br>
					<input type="text" name="duplicate_patient_id" class="form-control duplicate_patient_id"
						value="" placeholder="Enter patient id" required autocomplete="off">
				</div>
				<div class="col-md-4">
					<button type="button" class="btn btn-primary" style="margin-top:33px;">
						Search Duplicate
					</button>
				</div>
			</div><br /><br />
		
	<br /><br /><br />

		<div id="patient_details_duplicate"></div><br />

	<div id="pagination_info_top"></div>
		<ul class="pagination" id="pagination_top"></ul>
			<table class="table table-bordered table-striped" >
				<thead>
					<tr>
						<th style="text-align:center;">S.no</th>
						<th style="text-align:center">Visit Creation Date</th>
						<th style="text-align:center">Appointment Date</th>
						<th style="text-align:center">Hospital</th>
						<th style="text-align:center">OP/IP No</th>
						<th style="text-align:center">Department - Unite Name</th>
						<th style="text-align:center">Visit - Name</th>
						<th style="text-align:center">Discharge Date</th>
					</tr>
				</thead>

				<tbody id="table_body">
					<tr>
						<td colspan="8" style="text-align:center">No data</td>
					</tr>
				</tbody>
			</table>
	<div id="pagination_info_bottom"></div>
		<ul class="pagination" id="pagination_bottom"></ul>

	<hr>
		<!-- Original patient id search part belo -->

	<h3>Original Patient Id</h3><br>
	<div class="col-md-12 row">
		<div class="col-md-4">
			<label class="form-group">Search original patient id</label><br>
			<input type="text" class="form-control original_patient_id"
				placeholder="Enter original patient id" autocomplete="off">
		</div>
		<div class="col-md-4">
			<button type="button" class="btn btn-success" style="margin-top:33px;">
				Search Original
			</button>
		</div>
	</div>
	<br/><br/><br/><br/><br/>

		<div id="patient_details_original"></div><br />

	<div id="original_pagination_info_top"></div>
		<ul class="pagination" id="original_pagination_top"></ul>

	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th style="text-align:center;">S.no</th>
				<th style="text-align:center">Visit Creation Date</th>
				<th style="text-align:center">Appointment Date</th>
				<th style="text-align:center">Hospital</th>
				<th style="text-align:center">OP/IP No</th>
				<th style="text-align:center">Department - Unite Name</th>
				<th style="text-align:center">Visit - Name</th>
				<th style="text-align:center">Discharge Date</th>
			</tr>
		</thead>

		<tbody id="original_table_body">
			<tr>
				<td colspan="8" style="text-align:center">No data</td>
			</tr>
		</tbody>
	</table>

	<div id="original_pagination_info_bottom"></div>
		<ul class="pagination" id="original_pagination_bottom"></ul>
	<br/>
	<strong><span style="color:green">Note : </span>Merge duplicate patient id visits to original patient id visits</strong>&nbsp;&nbsp;&nbsp;&nbsp;
		<button class="btn btn-danger" style="text-align:center" id="merge_btn" disabled> Merge </button>
		<br/><br/>

		<!-- Archive date -->
			
		<div id="merge_pagination_info_top"></div>
		<ul class="pagination" id="merge_pagination_top"></ul>

			<table class="table table-bordered table-striped">
				<thead>
					<tr>
						<th style='text-align:center;'>S.no</th>
						<th style='text-align:center;'>Original Patient ID</th>
						<th style='text-align:center;'>Duplicate Patient ID</th>
						<th style='text-align:center;'>Visit ID</th>
						<th style='text-align:center;'>Created At</th>
					</tr>
				</thead>
				<tbody id="merge_table_body">
					<tr><td colspan="5" align="center">No data</td></tr>
				</tbody>
			</table>

		<div id="merge_pagination_info_bottom"></div>
		<ul class="pagination" id="merge_pagination_bottom"></ul>

<script id="ajax2">
	$(document).ready(function(){
	$('.btn-primary').click(function(e){
		e.preventDefault();
		loadData(1);
	});
});

function loadData(page_no){
	var patient_id = $('.duplicate_patient_id').val();
	$.ajax({
		url: "<?= base_url('user_panel/get_duplicate_patient_visit_ajax'); ?>",
		type: "POST",
		data: {page_no: page_no, patient_id: patient_id},
		dataType: "json",
		success: function(res){
			$('#table_body').html(res.table_data);
			$('#pagination_top').html(res.pagination);
			$('#pagination_bottom').html(res.pagination);

			$('#pagination_info_top').html(res.pagination_info);
			$('#pagination_info_bottom').html(res.pagination_info);

			$('#patient_details_duplicate').html(res.patient_details);
		}
	});
}

function doPost(page_no){
	loadData(page_no);
}
</script>

<script>
	$(document).ready(function(){
		$('.btn-success').click(function(e){
			e.preventDefault();
			loadOriginalData(1);
			loadMergeHistory(1);
		});
	});

	function loadOriginalData(page_no){
		var patient_id = $('.original_patient_id').val();
		$.ajax({
			url: "<?= base_url('user_panel/get_original_patient_visit_ajax'); ?>",
			type: "POST",
			data: {page_no: page_no, patient_id: patient_id},
			dataType: "json",
			success: function(res){
				$('#original_table_body').html(res.table_data);
				$('#original_pagination_top').html(res.pagination);
				$('#original_pagination_bottom').html(res.pagination);

				$('#original_pagination_info_top').html(res.pagination_info);
				$('#original_pagination_info_bottom').html(res.pagination_info);
				$('#patient_details_original').html(res.patient_details_org);
			}
		});
	}
	function doOriginalPost(page_no){
		loadOriginalData(page_no);
	}
</script>

<script>
	$('#merge_btn').click(function(){

		var duplicate_id = $('.duplicate_patient_id').val();
		var original_id = $('.original_patient_id').val();

		if(!duplicate_id || !original_id){
			alert("Please search both Duplicate and Original Patient IDs");
			return;
		}

		if(confirm("Do you want to merge duplicate patient into original patient?")){
			
			$.ajax({
				url: "<?= base_url('user_panel/merge_patient_ids'); ?>",
				type: "POST",
				data: {
					duplicate_id: duplicate_id,
					original_id: original_id
				},
				success: function(res){
					var data = JSON.parse(res);

					if(data.status == "success"){
						alert("Merge completed successfully");

						$('.duplicate_patient_id').val('');
						$('#table_body').html("<tr><td colspan='8' align='center'>No data</td></tr>");
						$('#patient_details_duplicate').html('');
						toggleMergeButton(); 

						var original_id = $('.original_patient_id').val().trim();
						if(original_id){
							loadOriginalData(1);
						}

						loadMergeHistory();
					} else if(data.status == "same"){
						alert("Duplicate and Original Patient IDs cannot be same");

					} else if(data.status == "empty"){
						alert("No duplicate visits found");

					} else {
						alert("Merge failed");
					}
				}
			});
		}
	});

	function loadMergeHistory(){
		$.ajax({
			url: "<?= base_url('user_panel/get_merge_history_ajax'); ?>",
			type: "GET",
			success: function(res){
				alert(JSON.stringify(res));
				$('#merge_history').html(res);
			}
		});
	}
	function loadMergeHistory(page_no = 1){
		$.ajax({
			url: "<?= base_url('user_panel/get_merge_history_ajax'); ?>",
			type: "POST",
			data: {page_no: page_no},
			dataType: "json",
			success: function(res){
				$('#merge_table_body').html(res.table_data);
				$('#merge_pagination_top').html(res.pagination);
				$('#merge_pagination_bottom').html(res.pagination);

				$('#merge_pagination_info_top').html(res.pagination_info);
				$('#merge_pagination_info_bottom').html(res.pagination_info);
			}
		});
	}
	function toggleMergeButton() {
		var duplicate_id = $('.duplicate_patient_id').val().trim();
		var original_id  = $('.original_patient_id').val().trim();

		if (duplicate_id && original_id) {
			$('#merge_btn').prop('disabled', false);
		} else {
			$('#merge_btn').prop('disabled', true);
		}
	}

	$(document).ready(function(){
		$('.duplicate_patient_id, .original_patient_id').on('input', function(){
			toggleMergeButton();
		});
		toggleMergeButton();
	});
</script>