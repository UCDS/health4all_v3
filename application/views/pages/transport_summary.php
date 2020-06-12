<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/Chart.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/export_to_excell.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >

<script type="text/javascript">
$(function(){
	$("#from_date,#to_date").Zebra_DatePicker();
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
			$("#table-sort-area").tablesorter(options);
			$("#table-sort-person").tablesorter(options);
		  $('#area_print').click(function(){
			$('#table-sort-area').trigger('printTable');
		  });
		  $('#person_print').click(function(){
			$('#table-sort-person').trigger('printTable');
		  });
		  
			var areactx = $("#areaChart");
			var myChart = new Chart(areactx, {
				type: 'bar',
				data: {
					labels: [<?php $i=1;foreach($area_report as $a) { echo "'".$a->to_area;if($i<count($area_report)) echo "' ,"; else echo "'"; $i++; }?>],
					datasets: [
						{
							type: 'bar',
							label: 'Area',
							yAxisID : "A",
							backgroundColor: "rgba(75,192,192,0.4)",
							borderColor: "rgba(75,192,192,0.4)",
							data: [<?php $i=1;foreach($area_report as $a) { echo $a->count_transport;if($i<count($area_report)) echo " ,"; $i++; }?>],
						},
						{
							type: 'line',
							label: 'Avg Time (mins)',
							yAxisID : "B",
							backgroundColor: "rgba(0,0,0,1)",
						borderColor: "rgba(0,0,0,1)",				fill:false,
							data: [<?php $i=1;foreach($area_report as $a) { echo $a->avg_time;if($i<count($area_report)) echo " ,"; $i++; }?>],
						}
					]
				},
				options: {
					scales: {
						xAxes: [{
							stacked: true
						}],
						  yAxes: [{
							id: 'A',
							type: 'linear',
							position: 'left',
							ticks: {
								beginAtZero:true
							},
							gridLines : false,
							scaleLabel : {
								display : true,
								labelString : "Count"
							}
						  }, {
							id: 'B',
							type: 'linear',
							position: 'right',
							ticks: {
								beginAtZero:true
							},
							gridLines : false,
							scaleLabel : {
								display : true,
								labelString : "Avg Time (mins)"
							}
						  }]
					}
				}
			});
			var personctx = $("#personChart");
			var myChart = new Chart(personctx, {
				type: 'bar',
				data: {
					labels: [<?php $i=1;foreach($person_report as $a) { echo "'".$a->staff_name;if($i<count($person_report)) echo "' ,"; else echo "'"; $i++; }?>],
					datasets: [
						{
							type: 'bar',
							label: 'Area',
							yAxisID : "A",
							backgroundColor: "rgba(75,192,192,0.4)",
							borderColor: "rgba(75,192,192,0.4)",
							data: [<?php $i=1;foreach($person_report as $a) { echo $a->count_transport;if($i<count($person_report)) echo " ,"; $i++; }?>],
						},
						{
							type: 'line',
							label: 'Avg Time (mins)',
							yAxisID : "B",
							backgroundColor: "rgba(0,0,0,1)",
						borderColor: "rgba(0,0,0,1)",				fill:false,
							data: [<?php $i=1;foreach($person_report as $a) { echo $a->avg_time;if($i<count($person_report)) echo " ,"; $i++; }?>],
						}
					]
				},
				options: {
					scales: {
						xAxes: [{
							stacked: true
						}],
						  yAxes: [{
							id: 'A',
							type: 'linear',
							position: 'left',
							ticks: {
								beginAtZero:true
							},
							gridLines : false,
							scaleLabel : {
								display : true,
								labelString : "Count"
							}
						  }, {
							id: 'B',
							type: 'linear',
							position: 'right',
							ticks: {
								beginAtZero:true
							},
							gridLines : false,
							scaleLabel : {
								display : true,
								labelString : "Avg Time (mins)"
							}
						  }]
					}
				}
			});
  }); 
  //create function for  for Excel report
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
    tab_text = tab_text + $('#myTable').html();
    tab_text = tab_text + '</table></body></html>';
    var data_type = 'data:application/vnd.ms-excel';
    $('#test').attr('href', data_type + ', ' + encodeURIComponent(tab_text));
    //downloaded excel sheet name is given here
    $('#test').attr('download', 'transport_summary.xls');

}

</script>
	<?php 
	$from_date=0;$to_date=0;
	if($this->input->post('from_date')) $from_date=date("Y-m-d",strtotime($this->input->post('from_date'))); else $from_date = date("Y-m-d");
	if($this->input->post('to_date')) $to_date=date("Y-m-d",strtotime($this->input->post('to_date'))); else $to_date = date("Y-m-d");
        $from_time=0;$to_time=0;
	if($this->input->post('from_time')) $from_time=date("H:i",strtotime($this->input->post('from_time'))); else $from_time = date("00:00");
	if($this->input->post('to_time')) $to_time=date("H:i",strtotime($this->input->post('to_time'))); else $to_time = date("23:59");
	?>
	
		<h4><CENTER>Transport Summary Report</CENTER></h4>	
		<?php echo form_open("reports/transport_summary",array('role'=>'form','class'=>'form-custom')); ?>
					From Date : <input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($from_date)); ?>" name="from_date" id="from_date" size="15" />
					To Date : <input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($to_date)); ?>" name="to_date" id="to_date" size="15" />
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
					<select name="transport_type" id="transport_type" class="form-control" >
					<option value="">Transport Type</option>
					<option value='1' <?php if($this->input->post('transport_type') && $this->input->post('transport_type') == 1) echo " selected ";?>>Patient</option>
					<option value='2' <?php if($this->input->post('transport_type') && $this->input->post('transport_type') == 2) echo " selected ";?>>Non Patient</option>
					</select>
					<input class="btn btn-sm btn-primary" type="submit" value="Submit" />
		</form>
	<br />
	<?php if(isset($area_report) && count($area_report)>0){ ?>
	
	<button type="button" class="btn btn-default btn-md print" id="area_print">
           <span class="glyphicon glyphicon-print"></span> Print
		</button>
        <!--frontend-->
        <!--created button which converts html table to Excel sheet-->
        <a href="#" id="test" onClick="javascript:fnExcelReport();">
            <button type="button" class="btn btn-default btn-md excel">
                <i class="fa fa-file-excel-o"ara-hidden="true"></i> Export to excel</button></a>
<div class="panel panel-default">
<div class="panel-body">
	<div class="col-md-6">
	<table class="table table-bordered table-striped" id="table-sort-area">
	 <thead>
	  <tr>
		<th style="text-align:center" >Area</th>
		<th style="text-align:center" >Count</th>
		<th style="text-align:center" >Avg Time</th>
		
	</tr>
	</thead>
	<tbody>
	<?php 
	$i=1;
	$total_area = 0;
	$total_time = 0;
	foreach($area_report as $s){
	?>
	<tr>
                <!--data is retrieved from database to the html table-->
		<td><?php echo $s->to_area;?></td>
		<td class="text-right"><?php echo $s->count_transport;?></td>
		<td class="text-right"><?php echo round($s->avg_time);?></td>
	</tr>
	<?php
	$total_area +=$s->count_transport;
	$total_time += $s->avg_time;
	$i++;
	}
	?>
	<tfoot>
		<th>Total </th>
		<th class="text-right"><?php echo $total_area;?></th>
		<th class="text-right"><?php echo $total_time/($i-1);?></th>
	</tbody>

</head>
</table>
</div>

	<div class="col-md-6">
		<canvas id="areaChart" width="200" height="100"></canvas>
	</div>
    </div>
    </div>
        <!--if no patients are transported in the selected date-->
        <?php }
	if(isset($person_report) && count($person_report)>0){ ?>
	
	<button type="button" class="btn btn-default btn-md print" id="person_print">
           <span class="glyphicon glyphicon-print"></span> Print
		</button>
        <!--frontend-->
        <!--created button which converts html table to Excel sheet-->
        <a href="#" id="test" onClick="javascript:fnExcelReport();">
            <button type="button" class="btn btn-default btn-md excel">
                <i class="fa fa-file-excel-o" ara-hidden="true"></i> Export to excel</button></a>
<div class="panel panel-default">
<div class="panel-body">
	<div class="col-md-6">
	<table class="table table-bordered table-striped" id="table-sort-person">
	 <thead>
	  <tr>
		<th style="text-align:center" >Staff Name</th>
		<th style="text-align:center" >Count</th>
		<th style="text-align:center" >Avg Time</th>
		
	</tr>
	</thead>
	<tbody>
	<?php 
	$i=1;
	$total_area = 0;
	$total_time = 0;
	foreach($person_report as $s){
	?>
	<tr>
                <!--data is retrieved from database to the html table-->
		<td><?php echo $s->staff_name;?></td>
		<td class="text-right"><?php echo $s->count_transport;?></td>
		<td class="text-right"><?php echo round($s->avg_time);?></td>
	</tr>
	<?php
	$total_area +=$s->count_transport;
	$total_time += $s->avg_time;
	$i++;
	}
	?>
	<tfoot>
		<th>Total </th>
		<th class="text-right"><?php echo $total_area;?></th>
		<th class="text-right"><?php echo $total_time/($i-1);?></th>
	</tbody>

</head>
</table>
</div>

	<div class="col-md-6">
		<canvas id="personChart" width="200" height="100"></canvas>
	</div>
    </div>
    </div>
        <!--if no patients are transported in the selected date-->
        <?php }
		else { ?>
	No patient transports on the given date.
	<?php } ?>
	</div>