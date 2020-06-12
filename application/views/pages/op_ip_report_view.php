<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/Chart.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/export_to_excell.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">  <!--change google map key while push-->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">


<?php 
	$pins = array();
    foreach($report as $pin){
		if($pin->district_id){
			$visitsTotal[] = $pin->total;
			$pins[] = (object) array(
				'district_id' => $pin->district_id,
				'district_name' => $pin->district,
				'latitude' => $pin->latitude,
				'longitude' => $pin->longitude,
				'Visits' => $pin->total
			);
		}
		
    }
	if(isset($visitsTotal))
		$maxVisit = max($visitsTotal);
?>
<script><?php
$visit_type;
if($this->input->post('report_type')==1){
	$visit_type="OP";
}
else {
	$visit_type="IP";
} ?>
</script>

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
		$("#table-sort").tablesorter(options);
		$('.print').click(function(){
		$('#table-sort').trigger('printTable');
		});
		


		var hospitalctx = $("#hospitalChart");
		var myChart = new Chart(hospitalctx, {
			type: 'horizontalBar',
			data: {
					labels: [<?php $i=1; foreach($report as $a) { echo "'".$a->district;if($i<count($report)) echo "' ,"; else echo "'"; $i++; }?>],
				datasets: [
					{
						type: 'horizontalBar',
						label: '<?=$visit_type;?>',
						xAxisID : "A",
						backgroundColor: "rgba(255,102,0,0.6)",
						borderColor: "rgba(255,102,0,0.6)",
						data: [<?php $i=1;foreach($report as $a) { echo $a->total;if($i<count($report)) echo " ,"; $i++; }?>]
					},
				]
			},
			options: {
				scales: {
					xAxes: [{
						id: 'A',
						type: 'linear',
						position: 'bottom',
						ticks: {
							beginAtZero:true
						},
						gridLines : false,
						scaleLabel : {
							display : true,
							labelString : "Patients"
						}
					}],
					yAxes: [{
						stacked: true
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
    $('#test').attr('download', 'op_summary.xls');

  }

			

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
        if($this->input->post('from_time')) $from_time=date("H:i",strtotime($this->input->post('from_time'))); else $from_time = date("00:00");
        if($this->input->post('to_time')) $to_time=date("H:i",strtotime($this->input->post('to_time'))); else $to_time = date("23:59");
	?>
    <h3>
	<CENTER>
		<?php echo "$visit_type - Distrct Wise Summary Report";?>
	  </CENTER></h3><br>
		<?php echo form_open("op_ip_report/op_ip_summary_report",array('role'=>'form','class'=>'form-custom')); ?>
			<div class="container">
				<div class="row">
					<div class="col-md-2">
							<label>Report Type:</label>
							<select name="report_type" id="report_type" class="form-control" style="width:89%">
							<option value="1" <?php if($this->input->post('report_type') == 1) echo " selected ";?>>Out-Patient</option>
							<option value="2" <?php if($this->input->post('report_type') == 2) echo "selected" ;?>>In-Patient</option>
						</select> 
					</div>
				
					<div class="col-md-2">
						<label>From Date :</label> 
						<input class="form-control" type="text" style="width:100%" value="<?php echo date("d-M-Y",strtotime($from_date)); ?>" name="from_date" id="from_date"  />
					</div>
					<div class="col-md-2">
						<label>To Date :</label> 
						<input class="form-control" type="text" style="width:100%" value="<?php echo date("d-M-Y",strtotime($to_date)); ?>" name="to_date" id="to_date" />
					</div>
					<div class="col-md-2">						
						<label>From Time:</label><input  class="form-control" style = "background-color:#EEEEEE;width:100%;" type="text" value="<?php echo date("h:i A",strtotime($from_time)); ?>" name="from_time" id="from_time" size="7px"/>
					</div>
					<div class="col-md-2">
						<label>To Time:</label>
						<input class="form-control" style = "background-color:#EEEEEE;width:100%;" type="text" value="<?php echo date("h:i A",strtotime($to_time)); ?>" name="to_time" id="to_time" />
					</div>
				</div>
			</div>
			
			<div class="container" style="padding-top:20px;">
				<div class="row">
					<div class="col-md-2">
						<select name="district" id="district" class="form-control" >
							<option value="" >District</option>
							<?php 
							foreach($all_districts as $dist){
								echo "<option value='".$dist->district_id."'";
								if($this->input->post('district') && $this->input->post('district') == $dist->district_id) echo " selected ";
								echo ">".$dist->district."</option>";
							}
							?>
						</select>
					</div>
					<div class="col-md-2">
							<select name="department" id="department" class="form-control" style="width:100%">
								<option value="">Department</option>
								<?php 
								foreach($departments as $dept){
									echo "<option value='".$dept->department_id."'";
									if($this->input->post('department') && $this->input->post('department') == $dept->department_id) echo " selected ";
									echo ">".$dept->department."</option>";
								}
								?>
							</select>
						</div>
						<div class="col-md-2">
							<select name="unit" id="unit" class="form-control" style="width:100%">
							<option value="">Unit</option>
							<?php 
							foreach($units as $unit){
								echo "<option value='".$unit->unit_id."' class='".$unit->department_id."'";
								if($this->input->post('unit') && $this->input->post('unit') == $unit->unit_id) echo " selected ";
								echo ">".$unit->unit_name."</option>";
							}
							?>
							</select>
						</div>
						<div class="col-md-2">
							<select name="area" id="area" class="form-control" style="width:100%">
								<option value="">Area</option>
								<?php 
								foreach($areas as $area){
									echo "<option value='".$area->area_id."' class='".$area->department_id."'";
									if($this->input->post('area') && $this->input->post('area') == $area->area_id) echo " selected ";
									echo ">".$area->area_name."</option>";
								}
								?>
							</select>
						</div>
						<div class="col-md-2">
							<select name="visit_name" id="visit_name" class="form-control" style="width:100%" >
								<option value="">Visit Type</option>
								<?php 
								foreach($visit_names as $v){
									echo "<option value='".$v->visit_name_id."'";
									if($this->input->post('visit_name') && $this->input->post('visit_name') == $v->visit_name_id) echo " selected ";
									echo ">".$v->visit_name."</option>";
								}
								?>
							</select>
						</div>
						<div class="col-md-1">
							<div class="form-group">
								<input class="btn btn-sm btn-primary" type="submit" value="Search" />
							</div>
						</div>
					</div> 
			</div>
	<br />
	</form>
        <!--table is displayed only when there is atleast one registration is done-->
       
			<div class="container">
				<div class="row">
					<div class="col-md-1">
						<button type="button" class="btn btn-default btn-md print">
						<span class="glyphicon glyphicon-print"></span> Print
						</button>
						</div>
						<div class="col-md-1">
							<!--frontend-->
							<!--created button which converts html table to Excel sheet-->
						<a href="#" id="test" onClick="javascript:fnExcelReport();">
							<button type="button" class="btn btn-default btn-md excel">
								<i class="fa fa-file-excel-o"ara-hidden="true"></i> Export 
							</button><br><br>
						</a>
					</div>
				</div>
			</div>					
			<table class="table table-bordered table-striped" id="table-sort">
				<?php if(isset($report) && count($report)>0){ ?>
				
				<thead>
					<tr>
						<th style="text-align:center" rowspan="2">S.no</th>
						<th style="text-align:center" rowspan="2">District</th>
						<th style="text-align:center" colspan="3"><=14 Years</th>
						<th style="text-align:center" colspan="3">14 to 30 Years</th>
						<th style="text-align:center" colspan="3">30 to <60 Years</th>
						<th style="text-align:center" colspan="3">>=60 Years</th>
						<th style="text-align:center" rowspan="1" colspan="3">Total  Visits</th>
					</tr>
					<tr>
						<th>Male</th><th>Female</th><th>Total</th>
						<th>Male</th><th>Female</th><th>Total</th>
						<th>Male</th><th>Female</th><th>Total</th>
						<th>Male</th><th>Female</th><th>Total</th>
						<th>Male</th><th>Female</th><th>Total</th> 
					</tr>
            	</thead>
            <tbody>
				<?php 
				$s_no=1;
				$total_mchild=0;
				$total_fchild=0;
				$total_child=0;
				$total_m14to30=0;
				$total_f14to30=0;
				$total_14to30=0;
				$total_m30to60=0;
				$total_f30to60=0;
				$total_30to60=0;
				$total_m60plus=0;
				$total_f60plus=0;
				$total_60plus=0;
				$total_male=0;
				$total_female=0;
				$total=0;
				foreach($report as $s){
				?>
				<tr>
							<!--data is retrieved from database to the html table-->
					<td><?php echo $s_no++; ?></td>
					<td><?php echo $s->district; ?></td>
					<td class="text-right"><?php echo $s->mchild;?></td>
					<td class="text-right"><?php echo $s->fchild;?></td>
					<td class="text-right"><?php echo $s->child;?></td>
					<td class="text-right"><?php echo $s->m14to30;?></td>
					<td class="text-right"><?php echo $s->f14to30;?></td>
					<td class="text-right"><?php echo $s->p14to30;?></td>
					<td class="text-right"><?php echo $s->m30to60;?></td>
					<td class="text-right"><?php echo $s->f30to60;?></td>
					<td class="text-right"><?php echo $s->p30to60;?></td>
					<td class="text-right"><?php echo $s->m60plus;?></td>
					<td class="text-right"><?php echo $s->f60plus;?></td>
					<td class="text-right"><?php echo $s->p60plus;?></td>
					<td class="text-right"><?php echo $s->male;?></td>
					<td class="text-right"><?php echo $s->female;?></td>
					<td class="text-right"><?php echo $s->total;?></td>
				</tr>
				<?php

				$total_mchild+=$s->mchild;
				$total_fchild+=$s->fchild;
				$total_child+=$s->child;
				$total_m14to30+=$s->m14to30;
				$total_f14to30+=$s->f14to30;
				$total_14to30+=$s->p14to30;
				$total_m30to60+=$s->m30to60;
				$total_f30to60+=$s->f30to60;
				$total_30to60+=$s->p30to60;
				$total_m60plus+=$s->m60plus;
				$total_f60plus+=$s->f60plus;
				$total_60plus+=$s->p60plus;
				$total_male+=$s->male;
				$total_female+=$s->female;
				$total+=$s->total;
				}
				?>
					<tfoot>
						<th></th>
						<th>Total </th>
						<th class="text-right" ><?php echo $total_mchild;?></th>
						<th class="text-right" ><?php echo $total_fchild;?></th>
						<th class="text-right" ><?php echo $total_child;?></th>
						<th class="text-right" ><?php echo $total_m14to30;?></th>
						<th class="text-right" ><?php echo $total_f14to30;?></th>
						<th class="text-right" ><?php echo $total_14to30;?></th>
						<th class="text-right" ><?php echo $total_m30to60;?></th>
						<th class="text-right" ><?php echo $total_f30to60;?></th>
						<th class="text-right" ><?php echo $total_30to60;?></th>
						<th class="text-right" ><?php echo $total_m60plus;?></th>
						<th class="text-right" ><?php echo $total_f60plus;?></th>
						<th class="text-right" ><?php echo $total_60plus;?></th>
						<th class="text-right" ><?php echo $total_male;?></th>
						<th class="text-right" ><?php echo $total_female;?></th>
						<th class="text-right" ><?php echo $total;?></th>
					
					</tfoot>
					
			</tbody>
				
		</table>
       		
			
			<!--if no patients are registered in the selected date-->
			<?php } else { ?>
		No patient registrations on the given date.<br>
		<?php } ?>	
		 <div style="width:100%; display:inline-flex;">
		 	<div style="width:50%;">
				<div class="panel-primary col-md-12" >
					<div class="panel-primary-inner-body">
						<div class="panel-heading">
							<h3 class="panel-title"><strong><center>Districts wise patients details</center></strong></h3>
						</div>
						<div id="map" style="height:300px;">  </div>
					</div>
				</div>
			</div>
			<div style="width:50%; padding-top:35px; ">
				<div>
					<div class="panel panel-default">
					<div class="panel-body">
					<canvas id="hospitalChart" width=300" height="150"></canvas>
					</div>
					</div>
				</div>
			</div>
		</div>
            


<script> 
	var map;
	function initMap() {
		var bounds = new google.maps.LatLngBounds();
		map = new google.maps.Map(document.getElementById('map'), {
			zoom: 18,
			mapTypeId: 'terrain'
			}
		);
		<?php 
		if(isset($maxVisit)){
			foreach($pins as $pin){  
				if(!!$pin->latitude) { 
		?>
			
				contentString_<?= $pin->district_id; ?> = "<b><?=$pin->district_name?></b><br/>Visits: <?=$pin->Visits;?>";

				var infowindow_<?= $pin->district_id; ?> = new google.maps.InfoWindow({
					content: contentString_<?= $pin->district_id; ?>
				});
				var location_<?= $pin->district_id; ?> = {lat: <?= $pin->latitude ?>, lng: <?= $pin->longitude ?>};
				<?php if(count($pins)==1) { ?>
				var vRadius_<?=$pin->district_id?> = <?=($pin->Visits/$maxVisit)?>
				<?php } else { ?>
				var vRadius_<?=$pin->district_id?> = <?=($pin->Visits/$maxVisit) * 100 * 500?>
				<?php } ?>
			
				var marker_<?=$pin->district_id?> = new google.maps.Circle({
					
					center: location_<?= $pin->district_id; ?>,
					strokeColor: '#FF0000',
					strokeOpacity: 0.8,
					strokeWeight: 2,
					fillColor: '#FF0000',
					fillOpacity: 0.35,
					map: map,
					radius: vRadius_<?=$pin->district_id?>
					
				});
				console.log(marker_<?=$pin->district_id?>);
				bounds.extend(location_<?= $pin->district_id; ?>);
				
				map.fitBounds(bounds);
				
				marker_<?= $pin->district_id; ?>.addListener('mouseover', function() {
					infowindow_<?= $pin->district_id; ?>.setPosition(marker_<?= $pin->district_id; ?>.getCenter());
					infowindow_<?= $pin->district_id; ?>.open(map, marker_<?= $pin->district_id; ?>);
				});

				marker_<?= $pin->district_id; ?>.addListener('mouseout', function() {
					infowindow_<?= $pin->district_id; ?>.close();
				});
		<?php 
				}
			}
		} 
		?>
	}
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC-1GMntG8XK9s7m4uWyWjhQdTaX-xZxYs&callback=initMap" async defer></script>


