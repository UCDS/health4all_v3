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
	$("#from_date,#to_date").Zebra_DatePicker();
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
<script>
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
    $('#test').attr('download', 'list_patient_visit_duplicate.xls');

}
</script>
	<?php 
        
	$from_date=0;$to_date=0;
	if($this->input->post('from_date')) $from_date=date("Y-m-d",strtotime($this->input->post('from_date'))); else $from_date = date("Y-m-d");
	if($this->input->post('to_date')) $to_date=date("Y-m-d",strtotime($this->input->post('to_date'))); else $to_date = date("Y-m-d");
	?>
	<div class="row">
		<h4>List Patient Visit Duplicate</h4>	
		<?php echo form_open("patient/list_patient_visit_duplicate",array('role'=>'form','class'=>'form-custom')); ?>
 
			From Date : <input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($from_date)); ?>" name="from_date" id="from_date" size="15" />
			To Date : <input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($to_date)); ?>" name="to_date" id="to_date" size="15" />
		
			<input class="btn btn-sm btn-primary" type="submit" value="Submit" />
	</form>
	<br />
	<?php if(isset($deleted_duplicate_data) && count($deleted_duplicate_data)>0){ ?>
		<div style='padding: 0px 2px;'>
            <h5>Report as on <?php echo date("j-M-Y h:i A"); ?></h5>
        </div>
                
		<button type="button" class="btn btn-default btn-md print">
		  <span class="glyphicon glyphicon-print"></span> Print
		</button>
        <!--created button which converts html table to Excel sheet-->
        <a href="#" id="test" onClick="javascript:fnExcelReport();">
            <button type="button" class="btn btn-default btn-md excel">
                <i class="fa fa-file-excel-o"ara-hidden="true"></i> Export to excel
			</button>
		</a>
	<table class="table table-bordered table-striped" id="table-sort">
		<thead>
			<tr>
				<th style="text-align:center">S.no</th>
				<th style="text-align:center">Patient id</th>
				<th style="text-align:center">Person</th>
				<th style="text-align:center">Date</th>
				<th style="text-align:center">Hospital</th>
				<th style="text-align:center">OP/IP No</th>
				<th style="text-align:center">Department</th>
				<th style="text-align:center">Visit Name</th>
				<th style="text-align:center">Appointment Date</th>
				<th style="text-align:center">Insert Datetime</th>
				<th style="text-align:center">Deleted by</th>
			</tr>
		</thead>
		<tbody>
			<?php $f=1; foreach($deleted_duplicate_data as $d){ ?>
			<tr>
				<td style="text-align:right"><?php echo $f; ?></td>	
				<td style="text-align:right"><?php echo $d->patient_id; ?></td>	
				<td style="text-align:right"><?php echo $d->first_name." ".$d->last_name; ?></td>	
				<td style="text-align:center"><?php echo date("d-M-Y",strtotime($d->admit_date));?></td>
				<td style="text-align:center"><?php echo $d->hospital_name; ?></td>
				<td style="text-align:center"><?php echo $d->visit_type." #".$d->op_ip_no; ?></td>
				<td style="text-align:center"><?php echo $d->dept_name;?></td>
				<td style="text-align:center"><?php echo $d->visit_name;?></td>
				<td style="text-align:center"><?php if(isset($d->appointment_time) && $d->appointment_time!="") {echo date("j M Y", strtotime("$d->appointment_time"));} ?></td>
				<td style="text-align:center"><?php if(isset($d->delete_datetime) && $d->delete_datetime!="") {echo date("j M Y", strtotime("$d->delete_datetime"));} ?> </td>
				<td style="text-align:center"><?php echo $d->staff_name; ?> </td>
			</tr>
			<?php $f++; } ?>
		</tbody>
	</table>
	<?php } else { ?>
	No patient registrations on the given date.
	<?php } ?>
	</div>
