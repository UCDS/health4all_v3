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
    $('#test').attr('download', 'issue_summary.xls');

}
</script>
	<?php 
        
	$from_date=0;$to_date=0;
	if($this->input->post('from_date')) $from_date=date("Y-m-d",strtotime($this->input->post('from_date'))); else $from_date = date("Y-m-d");
	if($this->input->post('to_date')) $to_date=date("Y-m-d",strtotime($this->input->post('to_date'))); else $to_date = date("Y-m-d");
        $from_time=0;$to_time=0;
	if($this->input->post('from_time')) $from_time=date("H:i",strtotime($this->input->post('from_time'))); else $from_time = date("H:i",strtotime("00:00"));
	if($this->input->post('to_time')) $to_time=date("H:i",strtotime($this->input->post('to_time'))); else $to_time = date("H:i",strtotime("23:59"));
	?>
	<div class="row">
		<h4> Issue Summary </h4>	
		<?php echo form_open("reports/issue_summary",array('role'=>'form','class'=>'form-custom')); ?>
                <b>Visit Type:  </b>
		<label><input type ="radio" name="visit_type" class ="form-control" value="IP" <?php if($this->input->post('visit_type') == "IP") echo " checked ";?> > IP</label>
                <label><input type="radio" name="visit_type" class ="form-control" value="OP" <?php if($this->input->post('visit_type') != "IP") echo " checked "; ?> > OP </label>
                &nbsp; &nbsp; &nbsp;
                
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
                <!-- <select name="unit" id="unit" class="form-control" >
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
                </select> -->
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
                <!-- Commented for enhancement jan 22 2024 
                    <select name="discharge_status" id="discharge_status" class="form-control" >
                   <option value="">Discharge Status</option>
                   <option value="Discharge">Discharge</option>
                   <option value="LAMA">LAMA</option>
                   <option value="Absconded">Absconded</option>
                   <option value="Death">Death</option>
                </select> -->
                <!-- Add Select Doctor -->
                <input class="btn btn-sm btn-primary" type="submit" value="Submit" />
	</form>
	<br />
	<?php if(isset($report) && count($report)>0){ ?>

                <!-- added 23rd January 2023 start-->
		<div style='padding: 0px 2px;'>
		
                <h5>Report as on <?php echo date("j-M-Y h:i A"); ?></h5>
                </div>
                <!-- added 23rd January 2023 end-->
	
		<button type="button" class="btn btn-default btn-md print">
		  <span class="glyphicon glyphicon-print"></span> Print
		</button>
        <!--created button which converts html table to Excel sheet-->
        <a href="#" id="test" onClick="javascript:fnExcelReport();">
            <button type="button" class="btn btn-default btn-md excel">
                <i class="fa fa-file-excel-o"ara-hidden="true"></i> Export to excel
            </button>
        </a><br><br>
	<table class="table table-bordered table-striped" id="table-sort">
	<thead>
	<tr>
		        <th style="text-align:center">S.no</th>
                <th style="text-align: center">Department</th>
                <th style="text-align: center">Unit</th>
                <th style="text-align: center">Area</th>
                <th style="text-align: center">Discharge</th>
                <th style="text-align: center">LAMA</th>
                <th style="text-align: center">LWI</th>
                <th style="text-align: center">Expired</th>
                <th style="text-align: center">Not Updated</th>
                <th style="text-align: center">Total Count</th>
	</tr>
	</thead>
	<tbody>
	<?php 
	$sno=(($page_no - 1) * $total_records_per_page)+1 ; 
	foreach($report as $s)
    {
	?>
	<tr>
        <?php
            $tot_discharge_count+=$s->dicharge_count;
            $tot_lama_count+=$s->lama_count;
            $tot_absconded_count+=$s->absconded_count;
            $tot_death_count+=$s->death_count;
            $tot_notupdated_count+=$s->notupdated_count;
        ?>
		<td><?php echo $sno;?></td>
        <td><?php echo $s->department_name;?></td>
		<td><?php echo $s->unit_name;?></td>
		<td><?php echo $s->area_name;?></td>
        <td style="text-align:center;"><?php echo $s->dicharge_count ?></td>
        <td style="text-align:center;"><?php echo $s->lama_count ?></td>
        <td style="text-align:center;"><?php echo $s->absconded_count ?></td>
        <td style="text-align:center;"><?php echo $s->death_count ?></td>
        <td style="text-align:center;"><?php echo $s->notupdated_count ?></td>
		<td style="text-align: center"><?php $sum+=$s->issue_count; echo $s->issue_count;?></td>
	</tr>
	<?php $sno++;}	?>
	</tbody>
    <tfoot>
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th style="text-align:right;">Total</th>
        <th style="text-align:center;"><?php echo $tot_discharge_count ?></th>
        <th style="text-align:center;"> <?php echo $tot_lama_count ?></th>
        <th style="text-align:center;"><?php echo $tot_absconded_count ?></th>
        <th style="text-align:center;"><?php echo $tot_death_count ?></th>
        <th style="text-align:center;"><?php echo $tot_notupdated_count ?></th>
        <th style="text-align:center;"><?php echo $sum;?></th>
    </tr>
  </tfoot>
	</table>
	<?php } else { ?>
	No patient registrations on the given date.
	<?php } ?>
	</div>
