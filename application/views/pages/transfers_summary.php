<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css">

<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/table2CSV.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/selectize.css">

<style type="text/css">
.selectize-control.repositories .selectize-dropdown>div {
	border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.selectize-control.repositories .selectize-dropdown .by {
	font-size: 11px;
	opacity: 0.8;
}

.selectize-control.repositories .selectize-dropdown .by::before {
	content: 'by ';
}

.selectize-control.repositories .selectize-dropdown .name {
	font-weight: bold;
	margin-right: 5px;
}

.selectize-control.repositories .selectize-dropdown .title {
	display: block;
}

.selectize-control.repositories .selectize-dropdown .description {
	font-size: 12px;
	display: block;
	color: #a0a0a0;
	white-space: nowrap;
	width: 100%;
	text-overflow: ellipsis;
	overflow: hidden;
}

.selectize-control.repositories .selectize-dropdown .meta {
	list-style: none;
	margin: 0;
	padding: 0;
	font-size: 10px;
}

.selectize-control.repositories .selectize-dropdown .meta li {
	margin: 0;
	padding: 0;
	display: inline;
	margin-right: 10px;
}

.selectize-control.repositories .selectize-dropdown .meta li span {
	font-weight: bold;
}

.selectize-control.repositories::before {
	-moz-transition: opacity 0.2s;
	-webkit-transition: opacity 0.2s;
	transition: opacity 0.2s;
	content: ' ';
	z-index: 2;
	position: absolute;
	display: block;
	top: 12px;
	right: 34px;
	width: 16px;
	height: 16px;
	background: url(<?php echo base_url(); ?> assets /images/spinner.gif);
	background-size: 16px 16px;
	opacity: 0;
}

.selectize-control.repositories.loading::before {
	opacity: 0.4;
}
</style>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.selectize.js"></script>

<script type="text/javascript">
$(function(){
	$("#from_date,#to_date").Zebra_DatePicker();
	$("#generate-csv").click(function(){
		$(".table").table2CSV();
	});
		var options = {
			widthFixed : true,
			showProcessing: true,
			headerTemplate : '{content} {icon}', // Add icon for jui theme; new in v2.7!

			widgets: [ 'default', 'zebra', 'print', 'stickyHeaders'],

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
		$('#from_department').selectize({maxItems:20});
		$('#to_department').selectize({maxItems:20});
});

function fnExcelReport() { 
       //created a variable named tab_text where  
     var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">'; 
     //row and columns arrangements 
     tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>'; 
     tab_text = tab_text + '<x:Name>Excel Sheet</x:Name>'; 
  
     tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>'; 
     tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>'; 
  
     tab_text = tab_text + "<table border='100px'>"; 
     //id is given which calls the html table 
     tab_text = tab_text + $('#table-sort').html(); 
     tab_text = tab_text + '</table></body></html>'; 
     var data_type = 'data:application/vnd.ms-excel'; 
     $('#test').attr('href', data_type + ', ' + encodeURIComponent(tab_text)); 
     //downloaded excel sheet name is given here 
     $('#test').attr('download', 'sensitivity-summary.xls');  
 } 

</script>
<div class="row">
	<?php
	$this->input->post ( 'visit_type' ) ? $visit_type = $this->input->post ( 'visit_type' ) : $visit_type = "0";
	$from_date = date ( "Y-m-d" );
	$to_date = $from_date;
	if ($this->input->post ( 'from_date' ))
		$from_date = date ( "Y-m-d", strtotime ( $this->input->post ( 'from_date' ) ) );
	if ($this->input->post ( 'to_date' ))
		$to_date = date ( "Y-m-d", strtotime ( $this->input->post ( 'to_date' ) ) );
	?>
		<h4>Transfers Report</h4>	
		<?php echo form_open("reports/transfer_summary",array('role'=>'form','class'=>'form-custom')); ?>
				<div class="col-md-12">
		From Date : <input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($from_date)); ?>" name="from_date" id="from_date" size="15" /> 
		To Date : <input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($to_date)); ?>" name="to_date" id="to_date" size="15" /> 
		Date Type : 
		<select name="date_type_selection" id="date_type_selection" class="form-control">
			<option value="admit_date" selected>Admit date</option>
			<option value="transfer_date">Transfer Date</option>
		</select>
	</div>
	<br /> <br />
	<div class="row">
		<div class="col-md-4">
			<select name="from_department[]" id="from_department" multiple
				placeholder="Select From Department..">
				<option value="">From Department</option>
						<?php
						foreach ( $all_departments as $department ) {
							echo "<option value='" . $department->department_id . "'";
							if ($this->input->post ( 'department' ) && in_array ( $department->department_id, $this->input->post ( 'department' ) ))
								echo " selected ";
							echo ">" . $department->department . "</option>";
						}
						?>
			</select>
		</div>
		<div class="col-md-4">
			<select name="to_department[]" id="to_department" multiple
				placeholder="Select To Department..">
				<option value="">To Department</option>
						<?php
						foreach ( $all_departments as $department ) {
							echo "<option value='" . $department->department_id . "'";
							if ($this->input->post ( 'department' ) && in_array ( $department->department_id, $this->input->post ( 'department' ) ))
								echo " selected ";
							echo ">" . $department->department . "</option>";
						}
						?>
			</select>
		</div>
	</div>
	<input class="btn btn-sm btn-primary" type="submit" value="Submit" />
	</form>
	<br />
	<?php if(isset($report) && count($report)>0){ ?>
	<?php
		
		$from_departments = array ();
		$to_departments = array ();
		foreach($report as $s) {
			${$s->from_department_id."_areas"} = array();
			${$s->to_department_id."_areas"} = array();
		}
		foreach ( $report as $s ) {
			$from_departments [] = $s->from_department."^".$s->from_department_id;
			$to_departments [] = $s->to_department."^".$s->to_department_id;
			${$s->from_department_id."_areas"} [] = $s->from_area;
			${$s->to_department_id."_areas"} [] = $s->to_area;
		}
		$from_departments = array_unique ( $from_departments );
		sort ( $from_departments );
		if($from_departments [0] == '')
			unset ( $from_departments [0] );
		$to_departments = array_unique ( $to_departments );
		sort ( $to_departments );
		if($to_departments [0] == '')
		unset ( $to_departments [0] );
		foreach($from_departments as $fd) {
			${substr($fd, strpos($fd, "^")+1)."_areas"} = array_unique(${substr($fd, strpos($fd, "^")+1)."_areas"});
		}
		foreach($to_departments as $td) {
			${substr($td, strpos($td, "^")+1)."_areas"} = array_unique(${substr($td, strpos($td, "^")+1)."_areas"});
		}
		?>

	<table class="table table-bordered table-striped" id="table-sort">
	<thead>
	<tr>
		<th rowspan="2" colspan="2">Count (Avg stay in hrs)</th>
		<?php foreach($to_departments as $td){ ?>
			<th colspan="<?php echo count(${substr($td, strpos($td, "^")+1)."_areas"});?>"><?php echo substr($td,0,strpos($td,"^"));?></th>
		<?php } ?>
	</tr>
	<tr>
			<?php foreach($to_departments as $td){
				foreach(${substr($td, strpos($td, "^")+1)."_areas"} as $area) { 
			?> 
					<th><?php echo $area;?></th>
			<?php }
			}?>
	</tr>
				
	</thead>
	<tbody>
		<?php
		foreach($from_departments as $fd) { ?>
				<?php 
					$i=1;
					foreach(${substr($fd, strpos($fd, "^")+1)."_areas"} as $from_area) { 
					if($i==1){ ?>
					<tr>
						<th  rowspan="<?php echo count(${substr($fd, strpos($fd, "^")+1)."_areas"});?>"><?php echo substr($fd,0,strpos($fd,"^"));?></th> 
					<?php $i=0; } ?>
					<?php echo "<th>$from_area</th>";
					foreach($to_departments as $td){
					$flag=0;						
					foreach(${substr($td, strpos($td, "^")+1)."_areas"} as $to_area) { 
							foreach($report as $s){
								if($s->from_area == $from_area && $to_area == $s->to_area && 
								$s->from_department_id == substr($fd,strpos($fd,"^")+1) &&
								$s->to_department_id == substr($td,strpos($td,"^")+1)){
									echo "<td>".$s->transfers." ( ".round($s->duration/60)."hrs )</td>";
									$flag=1;
								}
							}
							if($flag ==0) echo "<td>0</td>";
						}
					}
					echo "</tr>";
				}
			}
		?> 
	</table>
	<?php } else { ?>
	No transfers on the given date.
	<?php } ?>
	</div>