<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
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
	if($this->input->post('from_time')) $from_time=date("H:i",strtotime($this->input->post('from_time'))); else $from_time = date("00:00");
	if($this->input->post('to_time')) $to_time=date("H:i",strtotime($this->input->post('to_time'))); else $to_time = date("23:59");
	?>
	<div class="row">
		<h4>In-Patient Summary Report</h4>	
		<?php echo form_open("reports/ip_summary",array('role'=>'form','class'=>'form-custom')); ?>
					From Date : <input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($from_date)); ?>" name="from_date" id="from_date" size="15" />
					To Date : <input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($to_date)); ?>" name="to_date" id="to_date" size="15" />
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
					<input class="btn btn-sm btn-primary" type="submit" value="Submit" />
		</form>
	<br />
	<?php if(isset($report) && count($report)>0){ ?>
	
		<button type="button" class="btn btn-default btn-md print">
		  <span class="glyphicon glyphicon-print"></span> Print
		</button>
	<table class="table table-bordered table-striped" id="table-sort">
	<thead>
	<tr>
		<td style="text-align:center" rowspan="2">Department</th>
		<td style="text-align:center" colspan="3"><=14 Years</th>
		<td style="text-align:center" colspan="3">14 to  < 30 Years</th>
		<td style="text-align:center" colspan="3">30 to < 60 Years</th>
		<td style="text-align:center" colspan="3"> >=60 Years </th>
		<td style="text-align:center" rowspan="1" colspan="3">Total IP Admits</th>
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
	$total_ip=0;
	foreach($report as $s){
	?>
	<tr>
		<td><?php echo $s->department;?></td>
		<td class="text-right"><a href="<?php echo base_url()."reports/ip_detail/$s->department_id/$s->unit/$s->area/M/14/0/$from_date/$to_date";?>"><?php echo $s->ip_mchild;?></a></td>
		<td class="text-right"><a href="<?php echo base_url()."reports/ip_detail/$s->department_id/$s->unit/$s->area/F/14/0/$from_date/$to_date";?>"><?php echo $s->ip_fchild;?></td>
		<td class="text-right"><a href="<?php echo base_url()."reports/ip_detail/$s->department_id/$s->unit/$s->area/0/14/0/$from_date/$to_date";?>"><?php echo $s->ip_child;?></td>
		<td class="text-right"><a href="<?php echo base_url()."reports/ip_detail/$s->department_id/$s->unit/$s->area/M/14/30/$from_date/$to_date";?>"><?php echo $s->ip_m14to30;?></td>
		<td class="text-right"><a href="<?php echo base_url()."reports/ip_detail/$s->department_id/$s->unit/$s->area/F/14/30/$from_date/$to_date";?>"><?php echo $s->ip_f14to30;?></td>
		<td class="text-right"><a href="<?php echo base_url()."reports/ip_detail/$s->department_id/$s->unit/$s->area/0/14/30/$from_date/$to_date";?>"><?php echo $s->ip_14to30;?></td>
		<td class="text-right"><a href="<?php echo base_url()."reports/ip_detail/$s->department_id/$s->unit/$s->area/M/30/50/$from_date/$to_date";?>"><?php echo $s->ip_m30to60;?></td>
		<td class="text-right"><a href="<?php echo base_url()."reports/ip_detail/$s->department_id/$s->unit/$s->area/F/30/50/$from_date/$to_date";?>"><?php echo $s->ip_f30to60;?></td>
		<td class="text-right"><a href="<?php echo base_url()."reports/ip_detail/$s->department_id/$s->unit/$s->area/0/30/50/$from_date/$to_date";?>"><?php echo $s->ip_30to60;?></td>
		<td class="text-right"><a href="<?php echo base_url()."reports/ip_detail/$s->department_id/$s->unit/$s->area/M/0/50/$from_date/$to_date";?>"><?php echo $s->ip_m60plus;?></td>
		<td class="text-right"><a href="<?php echo base_url()."reports/ip_detail/$s->department_id/$s->unit/$s->area/F/0/50/$from_date/$to_date";?>"><?php echo $s->ip_f60plus;?></td>
		<td class="text-right"><a href="<?php echo base_url()."reports/ip_detail/$s->department_id/$s->unit/$s->area/0/0/50/$from_date/$to_date";?>"><?php echo $s->ip_60plus;?></td>
		<td class="text-right"><a href="<?php echo base_url()."reports/ip_detail/$s->department_id/$s->unit/$s->area/M/0/0/$from_date/$to_date";?>"><?php echo $s->ip_male;?></td>
		<td class="text-right"><a href="<?php echo base_url()."reports/ip_detail/$s->department_id/$s->unit/$s->area/F/0/0/$from_date/$to_date";?>"><?php echo $s->ip_female;?></td>
		<td class="text-right"><a href="<?php echo base_url()."reports/ip_detail/$s->department_id/$s->unit/$s->area/0/0/0/$from_date/$to_date";?>"><?php echo $s->ip;?></td>
	</tr>
	<?php
	$total_mchild+=$s->ip_mchild;
	$total_fchild+=$s->ip_fchild;
	$total_child+=$s->ip_child;
	$total_m14to30+=$s->ip_m14to30;
	$total_f14to30+=$s->ip_f14to30;
	$total_14to30+=$s->ip_14to30;
	$total_m30to60+=$s->ip_m30to60;
	$total_f30to60+=$s->ip_f30to60;
	$total_30to60+=$s->ip_30to60;
	$total_m60plus+=$s->ip_m60plus;
	$total_f60plus+=$s->ip_f60plus;
	$total_60plus+=$s->ip_60plus;
	$total_male+=$s->ip_male;
	$total_female+=$s->ip_female;
	$total_ip+=$s->ip;
	}
	?>
	<tfoot>
		<th>Total </th>
		<th class="text-right" ><?php echo $total_mchild;?></th>
		<th class="text-right"><?php echo $total_fchild;?></th>
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
		<th class="text-right" ><?php echo $total_ip;?></th>
	</tfoot>
	</tbody>
	</table>
	<?php } else { ?>
	No patient registrations on the given date.
	<?php } ?>
	</div>