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
	<div class="row">
		<h4><b>Login Activities</b></h4>	
		<?php echo form_open("reports/login_report",array('role'=>'form','class'=>'form-custom')); ?>
                <b>Trend:  </b>
				<label><input type ="radio" name="trend_type" class ="form-control" value="Day" checked > Daily</label>
                <label><input type="radio" name="trend_type" class ="form-control" value="Month" <?php if($this->input->post('trend_type') == "Month") echo " checked "; ?> > Monthly </label>
                <label><input type="radio" name="trend_type" class ="form-control" value="Year" <?php if($this->input->post('trend_type') == "Year") echo " checked "; ?> > Yearly </label><br/>
            
                From Date : <input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($from_date)); ?>" name="from_date" id="from_date" size="15" />
                To Date : <input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($to_date)); ?>" name="to_date" id="to_date" size="15" />
               Rows per page (For Detail) : <input type="number" class="rows_per_page form-custom form-control" name="rows_per_page" id="rows_per_page" min=<?php echo $lower_rowsperpage; ?> max= <?php echo $upper_rowsperpage; ?> step="1" value= <?php if($this->input->post('rows_per_page')) { echo $this->input->post('rows_per_page'); }else{echo $rowsperpage;}  ?> onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" /> 
                <input class="btn btn-sm btn-primary" type="submit" value="Submit" />
	</form>
	<br />
	<?php if(isset($report) && count($report)>0){ ?>
	
	<table class="table table-bordered table-striped" id="table-sort">
	<thead>
	<tr>
		<th style="text-align:center" rowspan="2">Date</th>
		<th style="text-align:center" rowspan="1" colspan="3">Login Attempts</th>
	</tr>
	<tr>
		<th style="text-align:center">Success</th>
                <th style="text-align: center">Fail</th>            
                <th style="text-align: center">Total</th>
	</tr>
	</thead>
	<tbody>
	<?php 
        // Simple total
	$total_success=0;
	$total_fail=0;
	$total=0;
        if($this->input->post('rows_per_page')){
        	$rowsperpage = $this->input->post('rows_per_page');
        }
	foreach($report as $s){
		if($this->input->post('trend_type')){
			$trend_type=$this->input->post('trend_type');
			if($trend_type == "Month"){
				$date = date("M, Y",strtotime($s->date));
			
			}
			else if($trend_type == "Year"){
				$date = date("Y",strtotime($s->date));
			}
			else{
				$date = date("d-M-Y",strtotime($s->date));
				$trend_type="Date";
				
			}
		}
		else{
			$date = date("d-M-Y",strtotime($s->date));
			$trend_type="Date";
		}
		$datefilter = date("d-m-Y",strtotime($s->date));
		
	?>
	<tr>
		<td><?php echo $date;?></td>
		<?php if ($s->no_of_success > 0) { ?>
		<td class="text-right"><a href="<?php echo base_url()."reports/login_activity_detail/$trend_type/$datefilter/1/$from_date/$to_date/$rowsperpage/";?>"><?php echo $s->no_of_success;?> </td>
		<?php } else { ?>
			<td class="text-right"><?php echo $s->no_of_success;?></td>
		<?php }  ?>
		
		<?php if ($s->no_of_un_success > 0) { ?>
		<td class="text-right"><a href="<?php echo base_url()."reports/login_activity_detail/$trend_type/$datefilter/0/$from_date/$to_date/$rowsperpage";?>"><?php echo $s->no_of_un_success;?> </td>
		<?php } else { ?>
			<td class="text-right"><?php echo $s->no_of_un_success;?></td>
		<?php }  ?>
		<td class="text-right"><a href="<?php echo base_url()."reports/login_activity_detail/$trend_type/$datefilter/-1/$from_date/$to_date/$rowsperpage/";?>"><?php echo $s->total;?> </td>
	</tr>
	<?php
	$total_success += $s->no_of_success;
        $total_fail += $s->no_of_un_success;
	$total += $s->total;       
	}
	?>
	</tbody>
        <tbody class="tablesorter-no-sort">
	<tr>
		<th>Total </th>
		<th class="text-right" ><a href="<?php echo base_url()."reports/login_activity_detail/$trend_type/-1/1/$from_date/$to_date/$rowsperpage/";?>"><?php echo number_format($total_success);?></th>
		<th class="text-right" ><a href="<?php echo base_url()."reports/login_activity_detail/$trend_type/-1/0/$from_date/$to_date/$rowsperpage/";?>"><?php echo number_format($total_fail);?></th>
		<th class="text-right" ><a href="<?php echo base_url()."reports/login_activity_detail/$trend_type/-1/-1/$from_date/$to_date/$rowsperpage/";?>"><?php echo number_format($total);?></th>
	</tr>
        </tbody>
	</table>
	<?php } else { ?>
	No Activities found.
	<?php } ?>
	</div>
