<link rel="stylesheet"
	href="<?php echo base_url();?>assets/css/metallic.css">
<link rel="stylesheet"
	href="<?php echo base_url();?>assets/css/theme.default.css">

<script type="text/javascript"
	src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript"
	src="<?php echo base_url();?>assets/js/table2CSV.js"></script>
<script type="text/javascript"
	src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>

<script type="text/javascript"
	src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript"
	src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript"
	src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<link rel="stylesheet" type="text/css"
	href="<?php echo base_url(); ?>assets/css/selectize.css">

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
<script type="text/javascript"
	src="<?php echo base_url();?>assets/js/jquery.selectize.js"></script>

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
		$('#micro_organism').selectize({maxItems:20});
		$('#antibiotic').selectize({maxItems:20});
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
		<h4>Sensitivity Report</h4>	
		<?php echo form_open("reports/sensitivity_summary",array('role'=>'form','class'=>'form-custom')); ?>
				<div class="col-md-12">
		From Date : <input class="form-control" type="text"
			value="<?php echo date("d-M-Y",strtotime($from_date)); ?>"
			name="from_date" id="from_date" size="15" /> To Date : <input
			class="form-control" type="text"
			value="<?php echo date("d-M-Y",strtotime($to_date)); ?>"
			name="to_date" id="to_date" size="15" /> <select name="department"
			id="department" class="form-control">
			<option value="">Department</option>
						<?php
						foreach ( $all_departments as $dept ) {
							echo "<option value='" . $dept->department_id . "'";
							if ($this->input->post ( 'department' ) && $this->input->post ( 'department' ) == $dept->department_id)
								echo " selected ";
							echo ">" . $dept->department . "</option>";
						}
						?>
						</select> <select name="unit" id="unit" class="form-control">
			<option value="">Unit</option>
						<?php
						foreach ( $units as $unit ) {
							echo "<option value='" . $unit->unit_id . "' class='" . $unit->department_id . "'";
							if ($this->input->post ( 'unit' ) && $this->input->post ( 'unit' ) == $unit->unit_id)
								echo " selected ";
							echo ">" . $unit->unit_name . "</option>";
						}
						?>
						</select> <select name="area" id="area" class="form-control">
			<option value="">Area</option>
						<?php
						foreach ( $areas as $area ) {
							echo "<option value='" . $area->area_id . "' class='" . $area->department_id . "'";
							if ($this->input->post ( 'area' ) && $this->input->post ( 'area' ) == $area->area_id)
								echo " selected ";
							echo ">" . $area->area_name . "</option>";
						}
						?>
						</select> Visit Type : <select class="form-control"
			name="visit_type">
			<option value="" selected>All</option>
			<option value="OP" <?php if($visit_type == "OP") echo " selected ";?>>OP</option>
			<option value="IP" <?php if($visit_type == "IP") echo " selected ";?>>IP</option>
		</select>
	</div>
	<br /> <br />
	<div class="row">
		<div class="col-md-2">
			<select name="specimen_type" class="form-control">
				<option value="">Specimen</option>
					<?php
					foreach ( $specimen_types as $specimen ) {
						echo "<option value='" . $specimen->specimen_type_id . "'";
						if ($this->input->post ( 'specimen_type' ) && $this->input->post ( 'specimen_type' ) == $specimen->specimen_type_id)
							echo " selected ";
						echo ">" . $specimen->specimen_type . "</option>";
					}
					?>
					</select>
		</div>
		<div class="col-md-4">
			<select name="micro_organism[]" id="micro_organism" multiple
				placeholder="Select Micro Organisms..">
				<option value="">Micro Organism</option>
						<?php
						foreach ( $micro_organisms as $micro_organism ) {
							echo "<option value='" . $micro_organism->micro_organism_id . "'";
							if ($this->input->post ( 'micro_organism' ) && in_array ( $micro_organism->micro_organism_id, $this->input->post ( 'micro_organism' ) ))
								echo " selected ";
							echo ">" . $micro_organism->micro_organism . "</option>";
						}
						?>
						</select>
		</div>
		<div class="col-md-4">
			<select name="antibiotic[]" id="antibiotic" multiple
				placeholder="Select Antibiotics..">
				<option value="">Antibiotics</option>
						<?php
						foreach ( $antibiotics as $antibiotic ) {
							echo "<option value='" . $antibiotic->antibiotic_id . "'";
							if ($this->input->post ( 'antibiotic' ) && in_array ( $antibiotic->antibiotic_id, $this->input->post ( 'antibiotic' ) ))
								echo " selected ";
							echo ">" . $antibiotic->antibiotic . "</option>";
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
		
		$micro_organisms = array ();
		$antibiotics = array ();
		$tests_reported = array ();
		foreach ( $report as $s ) {
			$micro_organisms [] = $s->micro_organism;
			$antibiotics [] = $s->antibiotic;
			$tests_reported [] = $s->test_id;
		}
		
		$tests_reported = array_unique ( $tests_reported );
		
		$micro_organisms = array_unique ( $micro_organisms );
		sort ( $micro_organisms );
		if($micro_organisms [0] == '')
			unset ( $micro_organisms [0] );
		$antibiotics = array_unique ( $antibiotics );
		sort ( $antibiotics );
		if($antibiotics [0] == '')
			unset ( $antibiotics [0] );
		
		?>
	<?php
		$reports = array ();
		foreach ( $antibiotics as $a )
			foreach ( $micro_organisms as $m )
				$reports [] = ( object ) array (
						'antibiotic' => $a,
						'micro_organism' => $m,
						'sensitive' => 0,
						'nbg' => 0,
						'total_antibiotic' => 0,
						'antibiotic_id' => 0,
						'micro_organism_id' => 0 
				);
		
		$nbg = 0;
		$total_growth = 0;
		$total_samples_tested = 0;
		foreach ( $report as $r ) {
			if (! is_null ( $r->micro_organism ) && ! is_null ( $r->antibiotic )) {
				foreach ( $reports as $ro )
					if ($ro->micro_organism == $r->micro_organism && $ro->antibiotic == $r->antibiotic) {
						if ($r->antibiotic_result == 1) {
							$ro->sensitive ++;
							$ro->total_antibiotic ++;
						} else if ($r->antibiotic_result == 0) {
							$ro->nbg ++;
							$ro->total_antibiotic ++;
						}
						
						$ro->antibiotic_id = $r->antibiotic_id;
						$ro->micro_organism_id = $r->micro_organism_id;
						$total_samples_tested ++;
					}
			}
		}
		
		foreach ( $tests_reported as $test ) {
			$prev_test_id = 0;
			foreach ( $report as $r ) {
				if ($prev_test_id == $r->test_id)
					continue;
				if ($r->test_id == $test)
					if ($r->test_result_binary == 1) {
						$total_growth ++;
						$prev_test_id = $r->test_id;
					} else {
						$nbg ++;
						$prev_test_id = $r->test_id;
					}
			}
		}
		
		$total_nbg = array ();
		
		$bacteria_sensitivity = 0;
		foreach ( $micro_organisms as $m ) {
                        $unique_microbe = array();
				foreach ( $report as $r ) {
					if (in_array ( $r->test_id, $unique_microbe ))
						continue;
					if ($m == $r->micro_organism){
						$bacteria_sensitivity++;				    
						$unique_microbe[] = $r->test_id;
					}
			}			
			$total_nbg [] = $bacteria_sensitivity;
			$bacteria_sensitivity = 0;
		}
		?>
		<button type="button" class="btn btn-default btn-md print">
		<span class="glyphicon glyphicon-print"></span> Print
	</button>
        <a href="#" id="test" onClick="javascript:fnExcelReport();"> 
             <button type="button" class="btn btn-default btn-md excel"> 
                <i class="fa fa-file-excel-o"ara-hidden="true"></i> Export</button></a>
	<div>
		<h3> Total Samples Tested: <?php echo sizeof($tests_reported);?></h3>
		<h4>NBG: <?php echo $nbg." (".number_format(($nbg/sizeof($tests_reported))*100).'%)';?> and, Growth: <?php echo $total_growth.' ('.number_format(($total_growth/sizeof($tests_reported))*100).'%).';?></h4>
	</div>
	<table class="table table-bordered table-striped" id="table-sort">
		<thead>
			<tr>
				<th style="text-align: center"></th>
		
		<?php
		
$i = 0;
		foreach ( $micro_organisms as $m ) {
			echo "<th colspan='3'>$m <br/> isolated: " . $total_nbg [$i] . " (" . number_format ( ($total_nbg [$i] / $total_growth) * 100 ) . "%)</th>";
			$i ++;
		}
		?>
		</tr>
			<tr>
				<th></th>
		<?php
		
foreach ( $micro_organisms as $m ) {
			echo "<th>S</th><th>T</th><th>%</th>";
		}
		?>
		</tr>
		</thead>
		<tbody>
	
		<?php
		if ($this->input->post ( 'department' ))
			$department_id = $this->input->post ( 'department' );
		else
			$department_id = - 1;
		if ($this->input->post ( 'unit' ))
			$unit_id = $this->input->post ( 'unit' );
		else
			$unit_id = - 1;
		if ($this->input->post ( 'area' ))
			$area_id = $this->input->post ( 'area' );
		else
			$area_id = - 1;
		if ($this->input->post ( 'specimen_type' ))
			$specimen_type_id = $this->input->post ( 'specimen_type' );
		else
			$specimen_type_id = - 1;
		foreach ( $antibiotics as $a ) {
			$mo = array ();
			echo "<tr><td>$a</td>";
			$i = 0;
			foreach ( $micro_organisms as $m ) {
				foreach ( $reports as $r ) {
					if (($r->antibiotic == $a && $r->micro_organism == $m)) {
						?>
								<td class="text-right"><a
				href="<?php echo base_url()."reports/order_detail/-1/$department_id/$unit_id/$area_id/-1/$specimen_type_id/-1/$visit_type/$from_date/$to_date/2/department/0/$r->antibiotic_id/$r->micro_organism_id/1";?>">
									<?php echo $r->sensitive;?>
									</a></td>
			<td class="text-right"><a
				href="<?php echo base_url()."reports/order_detail/-1/$department_id/$unit_id/$area_id/-1/$specimen_type_id/-1/$visit_type/$from_date/$to_date/2/department/0/$r->antibiotic_id/$r->micro_organism_id/0";?>">
									<?php echo $r->total_antibiotic;?>
									</a></td>
			<td class="text-right"><?php if($r->total_antibiotic==0) echo 'NA'; else echo number_format(($r->sensitive/$r->total_antibiotic)*100).'%';?></td>
								<?php
						$mo [] = $m;
					}
				}
				
				if (! in_array ( $m, $mo )) {
					$mo [] = $m;
					echo "<td>0</td><td>0</td><td>NA</td>";
				}
				$i ++;
			}
			echo "</tr>";
		}
		?>
	</tbody>
	</table>
        <p class="bg-primary"><font size="3" color="red">*&nbsp;</font>Percentage for each micro-organism is calculated against total growth of micro-organism(Growth).</p>
	<?php } else { ?>
	No Orders on the given date.
	<?php } ?>
	</div>