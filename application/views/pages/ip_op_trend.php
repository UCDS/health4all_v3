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
    tab_text = tab_text + $('#myTable').html();
    tab_text = tab_text + '</table></body></html>';
    var data_type = 'data:application/vnd.ms-excel';
    $('#test').attr('href', data_type + ', ' + encodeURIComponent(tab_text));
    //downloaded excel sheet name is given here
    $('#test').attr('download', 'ip_op_trend.xls');

}
</script>
	<?php 
        
	$from_date=0;$to_date=0;
	if($this->input->post('from_date')) $from_date=date("Y-m-d",strtotime($this->input->post('from_date'))); else $from_date = date("Y-m-d");
	if($this->input->post('to_date')) $to_date=date("Y-m-d",strtotime($this->input->post('to_date'))); else $to_date = date("Y-m-d");
	?>
	<div class="row">
		<h4>IP/OP Trend Report</h4>	
		<?php echo form_open("reports/ip_op_trends",array('role'=>'form','class'=>'form-custom')); ?>
                <b>Visit Type:  </b>
				<label><input type ="radio" name="visit_type" class ="form-control" value="IP" <?php if($this->input->post('visit_type') == "IP") echo " checked ";?> > IP</label>
                <label><input type="radio" name="visit_type" class ="form-control" value="OP" <?php if($this->input->post('visit_type') != "IP") echo " checked "; ?> > OP </label>
                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                <b>Trend:  </b>
				<label><input type ="radio" name="trend_type" class ="form-control" value="Day" checked > Daily</label>
                <label><input type="radio" name="trend_type" class ="form-control" value="Month" <?php if($this->input->post('trend_type') == "Month") echo " checked "; ?> > Monthly </label>
                <label><input type="radio" name="trend_type" class ="form-control" value="Year" <?php if($this->input->post('trend_type') == "Year") echo " checked "; ?> > Yearly </label><br>
                Search by : <select name="dateby" id="dateby" class="form-control">   
                        <option value="Registration" <?php echo ($this->input->post('dateby') == 'Registration') ? 'selected' : ''; ?> >Registration</option> 
                        <option value="Appointment" <?php echo ($this->input->post('dateby') == 'Appointment') ? 'selected' : ''; ?> >Appointment</option>          
                        </select>
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
                <!-- Add Select Doctor -->
                <input class="btn btn-sm btn-primary" type="submit" value="Submit" />
	</form>
	<br />
	<?php if(isset($report) && count($report)>0){ ?>
	
		<button type="button" class="btn btn-default btn-md print">
		  <span class="glyphicon glyphicon-print"></span> Print
		</button>
        <!--created button which converts html table to Excel sheet-->
        <a href="#" id="test" onClick="javascript:fnExcelReport();">
            <button type="button" class="btn btn-default btn-md excel">
                <i class="fa fa-file-excel-o"ara-hidden="true"></i> Export to excel</button></a>
	<table class="table table-bordered table-striped" id="table-sort">
	<thead>
	<tr>
		<th style="text-align:center" rowspan="2">Date</th>
		<th style="text-align:center" rowspan="1" colspan="6">Total Visits</th>
	</tr>
	<tr>
		<th style="text-align:center">Male</th>
                <th style="text-align: center">Female</th>
                <th style="text-align: center">Others</th>
                <th style="text-align: center">Not Specified</th>
                <th style="text-align: center">Total</th>
                <th style="text-align: center">Signed Consultation</th>
	</tr>
	</thead>
	<tbody>
	<?php 
        // Simple total
	$total_male=0;
	$total_female=0;
	$total_others=0;
	$total_notspecified=0;
	$total=0;
        $total_signed_consultation = 0;
        // To calculate average of visits made by patients in the given date range.
        $number_of_records = 0;
        $average = 0;
        
        // To calculate median of visits made by patients in the given date range.
        $male_count_per_day = array();
        $female_count_per_day = array();
        $total_signed_consultation_per_day= array();
        $median_count_per_day = array();
        $median_male = 0;
        $median_female = 0;
        $median_others=0;
	$median_notspecified=0;
        $median_total = 0;
        $median_signed_consultation = 0;
        
	foreach($report as $s){
		if($this->input->post('trend_type')){
			$trend_type=$this->input->post('trend_type');
			if($trend_type == "Month"){
				$date = date("M, Y",strtotime($s->date));
			}
			else if($trend_type == "Year"){
				$date = $s->date;
			}
			else{
				$date = date("d-M-Y",strtotime($s->date));
			}
		}
		else{
			$date = date("d-M-Y",strtotime($s->date));
		}
	?>
	<tr>
		<td><?php echo $date;?></td>
		<td class="text-right"><?php echo $s->male;?></td>
		<td class="text-right"><?php echo $s->female;?></td>
		<td class="text-right"><?php echo $s->others;?></td>
		<td class="text-right"><?php echo $s->not_specified;?></td>
		<td class="text-right"><?php echo $s->total;?></td>
                <td class="text-right"><?php echo $s->signed_consultation;?></td>
	</tr>
	<?php
	$total_male += $s->male;
        $total_female += $s->female;
        $total_others += $s->others;
        $total_notspecified += $s->not_specified; 
        $total_signed_consultation += $s->signed_consultation;
	$total += $s->total; 
        // Preparing an array of number of visits per day to sort and find the median.
        $male_count_per_day[$number_of_records] = $s->male;
        $female_count_per_day[$number_of_records] = $s->female;
        $others_count_per_day[$number_of_records] = $s->others;
        $not_specified_count_per_day[$number_of_records] = $s->not_specified;
        $total_count_per_day[$number_of_records] = $s->total;
        $total_signed_consultation_per_day[$number_of_records] = $s->signed_consultation;
        $number_of_records++;        
	}
	?>
	</tbody>
        <tbody class="tablesorter-no-sort">
	<tr>
		<th>Total </th>
		<th class="text-right" ><?php echo number_format($total_male);?></th>
		<th class="text-right" ><?php echo number_format($total_female);?></th>
		<th class="text-right" ><?php echo number_format($total_others);?></th>
		<th class="text-right" ><?php echo number_format($total_notspecified);?></th>
		<th class="text-right" ><?php echo number_format($total);?></th>
               <th class="text-right" ><?php echo number_format($total_signed_consultation);?></th>
	</tr>
        <tr>
            <?php
            //This function is used to calculate the median of a given array.
            //It first sorts the array and then finds the element midway in the sorted array.
                function median($list){
                    sort($list);
                    if(sizeof($list) == 0){
                     return 0;
                    }
                    elseif(sizeof($list)== 1){
                        return $list[0];
                    }
                    elseif(sizeof($list)%2 == 0){
                        $middle = sizeof($list)/2;
                        
                        return ($list[$middle-1] + $list[$middle])/2;
                    }
                    else{
                        $middle = (sizeof($list) - 1)/2 + 1;
                        
                        return $list[$middle-1];
                    }
                }
            ?>
                <th>Median</th>
                <th class="text-right"><?php echo round(median($male_count_per_day)); ?></th>
                <th class="text-right"><?php echo round(median($female_count_per_day)); ?></th>
                <th class="text-right"><?php echo round(median($others_count_per_day)); ?></th>
                <th class="text-right"><?php echo round(median($not_specified_count_per_day)); ?></th>
                <th class="text-right"><?php echo round(median($total_count_per_day)); ?></th>
                <th class="text-right"><?php echo round(median($total_signed_consultation_per_day)); ?></th>
        </tr>
        <tr>
                <th>Average</th>
                <th class="text-right"><?php echo round(($total_male/$number_of_records)); ?></th>
                <th class="text-right"><?php echo round(($total_female/$number_of_records));?></th>
                <th class="text-right"><?php echo round(($total_others/$number_of_records));?></th>
                <th class="text-right"><?php echo round(($total_notspecified/$number_of_records));?></th>
                <th class="text-right"><?php echo round(($total/$number_of_records));?></th>
                <th class="text-right"><?php echo round(($total_signed_consultation/$number_of_records));?></th>
        </tr>
        </tbody>
	</table>
         <table class="table table-bordered table-striped" id="myTable"  hidden>
	<thead>
	<tr>
		<th style="text-align:center" rowspan="2">Date</th>
		<th style="text-align:center" rowspan="1" colspan="6">Total Visits</th>
	</tr>
	<tr>
		<th style="text-align:center">Male</th><th style="text-align: center">Female</th><th style="text-align: center">Others</th><th style="text-align: center">Not Specified</th><th style="text-align: center">Total</th><th style="text-align: center">Signed Consultation</th>
	</tr>
	</thead>
	<tbody>
	<?php 
        // Simple total
	$total_male=0;
	$total_female=0;
	$total=0;
        $total_signed_consultation = 0;
        // To calculate average of visits made by patients in the given date range.
        $number_of_records = 0;
        $average = 0;
        
        // To calculate median of visits made by patients in the given date range.
        $male_count_per_day = array();
        $female_count_per_day = array();
        $others_count_per_day = array();
        $not_specified_count_per_day = array();
        $total_signed_consultation_per_day= array();
        $total_count_per_day= array();
        $median_male = 0;
        $median_female = 0;
        $median_others = 0;
        $median_not_specified = 0;
        $median_total = 0;
        $median_signed_consultation = 0;

	foreach($report as $s){
		if($this->input->post('trend_type')){
			$trend_type=$this->input->post('trend_type');
			if($trend_type == "Month"){
				$date = date("M, Y",strtotime($s->date));
			}
			else if($trend_type == "Year"){
				$date = $s->date;
			}
			else{
				$date = date("d-M-Y",strtotime($s->date));
			}
		}
		else{
			$date = date("d-M-Y",strtotime($s->date));
		}
	?>
	<tr>
		<td><?php echo $date;?></td>
		<td class="text-right"><?php echo $s->male;?></td>
		<td class="text-right"><?php echo $s->female;?></td>
		<td class="text-right"><?php echo $s->others;?></td>
		<td class="text-right"><?php echo $s->not_specified;?></td>
		<td class="text-right"><?php echo $s->total;?></td>
                <td class="text-right"><?php echo $s->signed_consultation;?></td>
	</tr>
	<?php
        
	$total_male+=$s->male;
	$total_female+=$s->female;
	$total_others+=$s->others;
	$total_notspecified+=$s->not_specified;
	$total+=$s->total; 
        // Preparing an array of number of visits per day to sort and find the median.
        $male_count_per_day[$number_of_records] = $s->male;
        $female_count_per_day[$number_of_records] = $s->female;
        $others_count_per_day[$number_of_records] = $s->others;
        $not_specified_count_per_day[$number_of_records] = $s->not_specified;
        $total_count_per_day[$number_of_records] = $s->total;
        $total_signed_consultation_per_day[$number_of_records] = $s->signed_consultation;
        $number_of_records++;        
	}
	?>
	</tbody>
        <tbody class="tablesorter-no-sort">
	<tr>
		<th>Total </th>
		<th class="text-right" ><?php echo number_format($total_male);?></th>
		<th class="text-right" ><?php echo number_format($total_female);?></th>
		<th class="text-right" ><?php echo number_format($total_others);?></th>
		<th class="text-right" ><?php echo number_format($total_notspecified);?></th>
		<th class="text-right" ><?php echo number_format($total);?></th>
                <th class="text-right" ><?php echo number_format($total_signed_consultation);?></th>
	</tr>
        <tr>
                <th>Median</th>
                <th class="text-right"><?php echo round(median($male_count_per_day)); ?></th>
                <th class="text-right"><?php echo round(median($female_count_per_day)); ?></th>
                <th class="text-right"><?php echo round(median($others_count_per_day)); ?></th>
                <th class="text-right"><?php echo round(median($not_specified_count_per_day)); ?></th>
                <th class="text-right"><?php echo round(median($total_count_per_day)); ?></th>
                <th class="text-right"><?php echo round(median($total_signed_consultation_per_day)); ?></th>
        </tr>
        <tr>
                <th>Average</th>
                <th class="text-right"><?php echo round(($total_male/$number_of_records)); ?></th>
                <th class="text-right"><?php echo round(($total_female/$number_of_records));?></th>
                <th class="text-right"><?php echo round(($total_others/$number_of_records));?></th>
                <th class="text-right"><?php echo round(($total_notspecified/$number_of_records));?></th>
                <th class="text-right"><?php echo round(($total/$number_of_records));?></th>
                <th class="text-right"><?php echo round(($total_signed_consultation/$number_of_records));?></th>
        </tr>
        </tbody>
	</table>
	<?php } else { ?>
	No patient registrations on the given date.
	<?php } ?>
	</div>
