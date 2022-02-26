<link rel="stylesheet"  type="text/css" href="<?php echo base_url();?>assets/css/bootstrap_datetimepicker.css"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/flaticon.css" >
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/flaticon2.css" >
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script src="<?php echo base_url();?>assets/js/highcharts.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
--><script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/moment.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.js"></script>

	<style>
		.panel-body { padding-top:0px; }
		
	</style>
<?php 
	$total_calls = 0;
	foreach($report as $r) { 
		$total_calls += $r->calls;
	}
?>
<script>
	$(function(){
		$(".date").datetimepicker({
			format : "D-MMM-YYYY"
		});
        $('#table-sort').hide();
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

        Highcharts.chart('calls_chart', {

                        title: {
                            text: 'Total Calls (<?=$total_calls;?>)'
                        },
                        xAxis: {
							
								plotBands: [{ // visualize the weekend
									from: 4.5,
									to: 6.5,
									color: 'rgba(68, 170, 213, .2)'
								}],
								categories: [<?php $i=1;foreach($report as $a)  { echo "'".$a->datefield;if($i<count($report)) echo "' ,"; else echo "'"; $i++; }?>]
								},
                        yAxis: {
                            title: {
                                text: 'Number of calls'
                            }
                        },
                        legend: {
                            layout: 'vertical',
                            align: 'right',
                            verticalAlign: 'middle'
                        },

                        plotOptions: {
                            series: {
                               // pointStart: 2010
                            }
                        },
                        	credits: {
						enabled: false
						},
			
                        series:[ {
                            name:'calls',
							data: [
                                   
                            <?php 
                                $i=1; $data='';
                                foreach($report as $a) {
                                     $data .=  $a->calls.",";
                                }
                                $data = substr($data,0,strlen($data)-1);
                                echo $data;
                            ?>
                            ]
							
	                        }]

                    });
   
    });
</script>
<?php 
			if($this->input->post('from_date')) $from_date = date("d-M-Y",strtotime($this->input->post('from_date'))); else $from_date = date("d-M-Y",strtotime("-1 months"));
			if($this->input->post('to_date')) $to_date = date("d-M-Y",strtotime($this->input->post('to_date'))); else $to_date = date("d-M-Y");
			?>
			<div class="row" >
			

        	<?php echo form_open('dashboard/helpline_trend/',array('role'=>'form','class'=>'form-custom')); ?>
			<div style="position:relative;display:inline;">
            <span style="font-size:24px;font-weight:bold"><span class="flaticon-telephone-line-24-hours-service"></span> Helpline <select name="helpline" style="width:300px" class="form-control">
				<option value="">Helpline</option>
				<?php foreach($helpline as $line){ ?>
					<option value="<?php echo $line->helpline;?>"
					<?php if($this->input->post('helpline') == $line->helpline) echo " selected "; ?>
					><?php echo $line->helpline.' - '.$line->note;?></option>
				<?php } ?>
			</select></span>
			<select name="call_direction" style="width:150px" class="form-control">
					<option value="">Call Direction</option>
					<option <?php if($this->input->post('call_direction') == "incoming") echo " selected "; ?> value="incoming">Incoming calls</option>
					<option <?php if($this->input->post('call_direction') == "outbound-dial") echo " selected "; ?> value="outbound-dial">Outgoing calls</option>
			</select>
			<select name="call_type" style="width:150px" class="form-control">
					<option value="">Call Type</option>
					<option <?php if($this->input->post('call_type') == "completed") echo " selected "; ?> value="completed">Completed</option>
					<option <?php if($this->input->post('call_type') == "client-hangup") echo " selected "; ?> value="client-hangup">Client Hangup</option>
					<option <?php if($this->input->post('call_type') == "voicemail") echo " selected "; ?> value="voicemail">Voicemail</option>
					<option <?php if($this->input->post('call_type') == "incomplete") echo " selected "; ?> value="incomplete">Incomplete</option>
					<option <?php if($this->input->post('call_type') == "call-attempt") echo " selected "; ?> value="call-attempt">Call Attempt</option>
			</select>
            <br>
			<input type="text" class="date form-control" name="from_date" class="form-control" value="<?php echo $from_date;?>" />
			</div>
			<div  style="position:relative;display:inline;">
			<input type="text" class="date form-control" name="to_date" class="form-control" value="<?php echo $to_date;?>" />	
			</div>	
			<label><input type ="radio" name="trend_type" class ="form-control" value="Day" checked > Daily</label>
            <label><input type="radio" name="trend_type" class ="form-control" value="Month" <?php if($this->input->post('trend_type') == "Month") echo " checked "; ?> > Monthly </label>
            <label><input type="radio" name="trend_type" class ="form-control" value="Year" <?php if($this->input->post('trend_type') == "Year") echo " checked "; ?> > Yearly </label>
			<input type="submit" name="submit" value="Go" class="btn btn-primary btn-sm" style="align:left" />
			<a href="<?php echo base_url()."dashboard/helpline/";?>" class="btn btn-warning btn-sm"><i class="fa fa-pie-chart"></i> Dashboard</a>
            <?php  echo form_close();?>
            
    		<hr>
		</div>
	<div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
				<div class="panel-body">
			        <div id="calls_chart" style=" height: 400px; margin:0 auto">
                </div>
            </div>
        </div>
    </div>
	<br />
	<br />
	<button type="button" class="btn btn-primary" style="margin:15px;" onClick="$('#table-sort').toggle();window.scroll($('#table-sort').offset().left, $('#table-sort').offset().top);">View Table</button>
    <div class="row">
    <div class="col-md-6">
	<table class="table table-bordered table-striped" id="table-sort" style="width:500px;">
	    <thead>
            <tr>
                		<th style="text-align:center; width:150px;">Date</th>
                        <th style="text-align:center; width:150px;">Calls Count</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $total_calls=0;
                foreach($report as $s){
                    $total_calls +=$s->calls;
                    if($this->input->post('trend_type')){
                        $trend_type=$this->input->post('trend_type');
                        if($trend_type == "Month"){
                            $date = date("M, Y",strtotime($s->datefield));
                        }
                        else if($trend_type == "Year"){
                            $date = $s->date;
                        }
                        else{
                            $date = date("d-M-Y",strtotime($s->datefield));
                        }
                    }
                    else{
                        $date = date("d-M-Y",strtotime($s->datefield));
                    }
                
            ?>
            <tr>
            	<td class="text-right"><?php echo $s->datefield;?></td>
	        	<td class="text-right"><?php echo $s->calls;?></td>
	        </tr>
            <?php 
            } 
            ?>
            <tr>
                <th class="text-right">Grand Total</th>
	        	<th class="text-right"><?php echo $total_calls ?></th>
            </tr>
        </tbody>
    </table>
    </div>
    </div>
    
