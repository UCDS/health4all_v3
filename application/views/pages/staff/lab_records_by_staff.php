<?php /**
 * Description of staff_report
 * Captures Staff Activity --> How many patient records each employee input.
 * staff_report(controller)->staff_report_model
 * @author Gokul -- 28 Jan 17.
 */
?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
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
			$("#table-sort").tablesorter(options);
		  $('.print').click(function(){
			$('#table-sort').trigger('printTable');
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
    tab_text = tab_text + $('#table-sort').html();
    tab_text = tab_text + '</table></body></html>';
    var data_type = 'data:application/vnd.ms-excel';
    $('#test').attr('href', data_type + ', ' + encodeURIComponent(tab_text));
    //downloaded excel sheet name is given here
    $('#test').attr('download', 'staff_activity-lab_registration.xls');

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
	
    <h4><CENTER>Staff Activity - Lab Updates</CENTER></h4>	
    <?php echo form_open("staff_report/get_lab_records",array('role'=>'form','class'=>'form-custom')); ?>
        From Date : <input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($from_date)); ?>" name="from_date" id="from_date" size="15" />
        To Date : <input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($to_date)); ?>" name="to_date" id="to_date" size="15" />

        <select name="activity_name" id="activity_name" class="form-control">
            <option value="approved" <?php if($this->input->post('activity_name')=='approved' || !$this->input->post('activity_name')) echo 'selected'; ?> >Approved</option>
            <option value="updated" <?php if($this->input->post('activity_name')=='updated') echo 'selected'; ?> >Updated</option>
        </select>
        <select name="test_area_id" id="test_area_id" class="form-control">
        <option value="">Lab</option>
        <?php 
        foreach($lab_departments as $dept){
                echo "<option value='".$dept->test_area_id."'";
                if($this->input->post('test_area_id') && $this->input->post('test_area_id') == $dept->test_area_id) echo " selected ";
                echo ">".$dept->test_area."</option>";
        }
        ?>
        </select>
        <select name="test_method_id" id="test_method_id" class="form-control">
        <option value="">Method</option>
        <?php 
        foreach($test_methods as $method){
                echo "<option value='".$method->test_method_id."'";
                if($this->input->post('test_method_id') && $this->input->post('test_method_id') == $method->test_method_id) echo " selected ";
                echo ">".$method->test_method."</option>";
        }
        ?>
        </select>
        <input class="btn btn-sm btn-primary" type="submit" value="Submit" />
    </form>
<br />
        <!--table is displayed only when there is atleast one registration is done-->

        <?php 
            if(isset($lab_records_by_staff) && count($lab_records_by_staff) > 0){
        
        ?>
        <button type="button" class="btn btn-default btn-md print">
           <span class="glyphicon glyphicon-print"></span> Print
		</button>
        <!--frontend-->
        <!--created button which converts html table to Excel sheet-->
        <a href="#" id="test" onClick="javascript:fnExcelReport();">
            <button type="button" class="btn btn-default btn-md excel">
                <i class="fa fa-file-excel-o"ara-hidden="true"></i> Export to excel
            </button>
        </a>
        <table class="table table-bordered table-striped" id="table-sort">
            <thead>
	  <tr>
                <th style="text-align:center">#</th>
                <th style="text-align:center">Staff Name</th>
                <th style="text-align:center">Designation</th>
                <th style="text-align:center"># Tests</th>
                <th style="text-align:center">Avg Turn Around Time(Minutes)</th>
          </tr>
            </thead>
            <tbody>
                <?php 
                    $total_entries = 0;
                    $total_time = 0;
                    $index = 1;
                    foreach($lab_records_by_staff as $records){
                ?>
                <tr>
                    <td class="text-right"><?php echo $index; ?></td>
                    <td><?php echo $records->first_name." ".$records->last_name; ?></td>
                    <td><?php echo $records->designation; ?></td>
                    <td class="text-right"><?php echo $records->lab_records; ?></td>
                    <td class="text-right"><?php if(!!$records->total_time_minutes) {$time = convertTime(round($records->total_time_minutes/$records->lab_records)); if(!!$time['hours']) echo $time['hours']."hrs "; echo $time['mins']."mins";}?></td>
                </tr>                
                <?php 
                    $total_entries += $records->lab_records;
                    $total_time += $records->total_time_minutes;
                    $index++;
                }
                    ?>
                <tr>
                    <td class="text-right" colspan="3">Total Tests</td>
                    <td class="text-right"><?php echo $total_entries; ?></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="text-right" colspan="4">Average of Averages</td>
                    <td class="text-right"><?php if(!!$total_time) {$time = convertTime(round($total_time/$total_entries)); if(!!$time['hours']) echo $time['hours']."hrs "; echo $time['mins']."mins";}?></td>
                </tr>
            </tbody>
        </table>
        <?php
            }
        
        ?>
<?php

function convertTime() {
$args = func_get_args();
switch (count($args)) {
    case 1:     //total minutes was passed so output hours, minutes
        $time = array();

        $time['hours'] = intval($args[0]/60);

        $time['mins'] = ($args[0]%60);
        return $time;
        break;
    case 2:     //hours, minutes was passed so output total minutes
        return ($args[0] * 60) + $args[1];
}
}

?>