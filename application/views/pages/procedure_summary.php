<!--This page is used to generate a trend report of IP and OP patient.
This report is generated in response to the query submitted on this page.
This view is called in reports.php ip_op_trends method-->

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/export_to_excell.js"></script>
<script type="text/javascript">
$(function(){
	var today = new Date();

var todayString =
    String(today.getDate()).padStart(2, '0') + '-' +
    String(today.getMonth() + 1).padStart(2, '0') + '-' +
    today.getFullYear();

$('#from_date').Zebra_DatePicker({
    direction: false,
    pair: $('#to_date')
});

$('#to_date').Zebra_DatePicker({
    format: 'd-m-Y',
    direction: [true, todayString]
});
			var options = {
			widthFixed : true,
			showProcessing: true,
			headerTemplate : '{content} {icon}', // Add icon for jui theme; new in v2.7!
                        cssInfoBlock : "tablesorter-no-sort",
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
<style type="text/css">
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
	?>
	<?php $userdata=$this->session->userdata('hospital'); ?>
	<div class="row">
		<h4><b>Login Activities</b></h4>	
		<?php echo form_open("reports/procedure_summary",array('role'=>'form','class'=>'form-custom')); ?>
                <b>Trend:  </b>
				<label><input type="radio" name="visit_type" class ="form-control" value="All" checked  > All </label>
				<label><input type ="radio" name="visit_type" class ="form-control" value="OP" <?php if($this->input->post('visit_type') == "OP") echo " checked "; ?> > OP</label>
                <label><input type="radio" name="visit_type" class ="form-control" value="IP" <?php if($this->input->post('visit_type') == "IP") echo " checked "; ?> > IP </label><br/>
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
				if($this->input->post('unit') == $unit->unit_id) echo " selected ";
				echo ">".$unit->unit_name."</option>";
				}
				?>
			</select>
			<select name="area" id="area" class="form-control" >
				<option value="">Area</option>
				<?php 
				foreach($areas as $area){
				echo "<option value='".$area->area_id."' class='".$area->department_id."'";
				if($this->input->post('area') == $area->area_id) echo " selected ";
				echo ">".$area->area_name."</option>";
				}
				?>
			</select>
			<select name="visit_name" id="visit_name" class="form-control" >
				<option value="">Visit Type</option>
				<?php 
				foreach($visit_names as $v){
				echo "<option value='".$v->visit_name_id."'";
				if($this->input->post('visit_name') == $v->visit_name_id)  echo " selected ";
				echo ">".$v->visit_name."</option>";
				}
				?>
			</select>
			<select class="form-control" name="procedure" id="procedure">
							<option value="" selected>Procedure</option>
									<?php foreach($procedures as $procedure){ ?>
											<option value="<?php echo $procedure->procedure_id;?>" <?php if ($procedure->procedure_id == $this->input->post('procedure')) echo "selected" ?>><?php echo $procedure->procedure_name; ?></option>
									<?php } ?>
						</select>
			H4All ID : <input type="number" class="form-custom form-control" placeholder="Health4All ID" name="patient_id" id="h4allid" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" value="<?php if($this->input->post('patient_id')) { echo $this->input->post('patient_id'); } ?>"   />  			
                <input class="btn btn-sm btn-primary" type="submit" value="Submit" />
	</form>
	<br />
	<?php if(isset($report) && count($report)>0){ ?>
	
	<table class="table table-bordered table-striped" id="table-sort">
	<thead>
	<tr>
		<th style="text-align:center">Department</th>
		<th style="text-align:center">Procedure</th>
		<th style="text-align:center">#</th>
	</tr>
	</thead>
	<tbody>
	<?php 

	$total=0;
        if($this->input->post('rows_per_page')){
        	$rowsperpage = $this->input->post('rows_per_page');
        }
		foreach($report as $s){
	?>
	<tr>
		<td><?php echo $s->department;?></td>
		<td><?php echo $s->procedure_name;?></td>
		<td style="text-align:right"><?php echo $s->total_procedures;?></td>		
	</tr>
	<?php
		$total += $s->total_procedures;
          
	}
	?>
	</tbody>
        <tbody class="tablesorter-no-sort">
	<tr>
		<th>Total </th>
		<th colspan="2" style="text-align:right"><?php echo $total;?></th>
	</tr>
        </tbody>
	</table>
	<?php } else { ?>
	No Procedure found.
	<?php } ?>
	</div>
