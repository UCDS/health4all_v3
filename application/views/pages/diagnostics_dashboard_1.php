	<link rel="stylesheet"  type="text/css" href="<?php echo base_url();?>assets/css/bootstrap_datetimepicker.css"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css"> 
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/moment.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/Chart.js"></script>
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.js"></script>

<style>
tbody > tr:nth-child(odd) {background-color: #f2f2f2;}
</style>
    <script type="text/javascript">
    $(function(){
        $('#from_time').ptTimeSelect();
		$('#to_time').ptTimeSelect();

		$(".date").datetimepicker({
			format : "D-MMM-YYYY"
		});
        $("#report_date").text('From '+$("#from_date").val()+' '+$('#from_time').val()+' To '+$("#to_date").val()+' '+$('#to_time').val()+'  '+$('#current_date').val());
   
        //bar chart hospital wise
        var hospitalctx = $("#hospital_wise_chart");
		var myChart = new Chart(hospitalctx, {
			type: 'horizontalBar',
			data: {
					labels: [<?php $i=1; foreach($report as $a) { echo "'".$a->type;if($i<count($report)) echo "' ,"; else echo "'"; $i++; }?>],
				datasets: [
					{
						type: 'horizontalBar',
						label: 'Tests Ordered',
						xAxisID : "A",
						backgroundColor: "rgba(255,102,0,0.6)",
						borderColor: "rgba(255,102,0,0.6)",
						data: [<?php $i=1;foreach($report as $a) { echo $a->tests_ordered;if($i<count($report)) echo " ,"; $i++; }?>]
					},
                    {
						type: 'horizontalBar',
						label: 'Tests Completed',
						xAxisID : "A",
						backgroundColor: "rgba(153,204,0, 0.7)",
							borderColor: "rgba(153,204,0, 0.7)",
						data: [<?php $i=1;foreach($report as $a) { echo $a->tests_completed;if($i<count($report)) echo " ,"; $i++; }?>]
					},
                    {
						type: 'horizontalBar',
						label: 'Tests Reported',
						xAxisID : "A",
						backgroundColor: "#428bca",
						borderColor: "#428bca",
						data: [<?php $i=1;foreach($report as $a) { echo $a->tests_reported;if($i<count($report)) echo " ,"; $i++; }?>]
					}
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
							labelString : "Tests"
						}
					}],
					yAxes: [{
						stacked: true
					}]
				}
			}
		});
   
        // lab area wise chart
        //bar chart hospital wise
        var hospitalctx = $("#LabArea_wise_chart");
		var myChart = new Chart(hospitalctx, {
			type: 'horizontalBar',
			data: {
					labels: [<?php $i=1; foreach($report1 as $a) { echo "'".$a->test_area;if($i<count($report1)) echo "' ,"; else echo "'"; $i++; }?>],
				datasets: [
					{
						type: 'horizontalBar',
						label: 'Tests Ordered',
						xAxisID : "A",
						backgroundColor: "rgba(255,102,0,0.6)",
						borderColor: "rgba(255,102,0,0.6)",
						data: [<?php $i=1;foreach($report1 as $a) { echo $a->tests_ordered;if($i<count($report1)) echo " ,"; $i++; }?>]
					},
                    {
						type: 'horizontalBar',
						label: 'Tests Completed',
						xAxisID : "A",
						backgroundColor: "rgba(153,204,0, 0.7)",
							borderColor: "rgba(153,204,0, 0.7)",
						data: [<?php $i=1;foreach($report1 as $a) { echo $a->tests_completed;if($i<count($report1)) echo " ,"; $i++; }?>]
					},
                    {
						type: 'horizontalBar',
						label: 'Tests Reported',
						xAxisID : "A",
						backgroundColor: "#428bca",
						borderColor: "#428bca",
						data: [<?php $i=1;foreach($report1 as $a) { echo $a->tests_reported;if($i<count($report1)) echo " ,"; $i++; }?>]
					}
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
							labelString : "Tests"
						}
					}],
					yAxes: [{
						stacked: true
					}]
				}
			}
		});
   
   
    });

    </script>
    <?php
        $from_time=0;$to_time=0;
        if($this->input->post('from_time')) $from_time=date("H:i",strtotime($this->input->post('from_time'))); else $from_time = date("00:00");
        if($this->input->post('to_time')) $to_time=date("H:i",strtotime($this->input->post('to_time'))); else $to_time = date("23:59");
	?>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-info">
                <div class="panel-heading">
                 <h5 style="display:inline; padding-bottom:15px;">
                        Report as on <span id="current_date"><?php echo date("d-M-Y g:iA");?></span> 
                    </h5><br/>
                    <h5 id = "report_date" style="display:inline;  padding-bottom:15px;"></h5>
                    <?php echo form_open('dashboard/diagnostics_dashboard_1/',array('role'=>'form','class'=>'form-custom')); ?> 
                        <!--<input type="hidden" name="organization" id="organization" value="<?=$organization?>">-->
                        <label style="padding-left:15px;">From: </label>
                        <input type="text" class="date form-control" style="width:110px" value="<?php if($this->input->post('from_date')) echo date("d-M-Y",strtotime($this->input->post('from_date'))); else echo date("d-M-Y");?>" name="from_date" id="from_date" />
                        <input  class="form-control" style = "background-color:#EEEEEE;" type="text" value="<?php echo date("h:i A",strtotime($from_time)); ?>" name="from_time" id="from_time" size="7px"/>
                        <br/>
                        <label style="padding-left:34px;">To: </label>
                        <input type="text" class="date form-control" style="width:110px; padding-top:5px;" value="<?php if($this->input->post('to_date')) echo date("d-M-Y",strtotime($this->input->post('to_date'))); else echo date("d-M-Y");?>" name="to_date" id="to_date" />
                        <input class="form-control" style = "background-color:#EEEEEE;" type="text" value="<?php echo date("h:i A",strtotime($to_time)); ?>" name="to_time" id="to_time" size="7px" />
                        <input type="submit" style="margin-left:15px;" class="btn btn-sm btn-primary" value="Submit" name="submit" />
                    <?php echo form_close(); ?>
                </div><!--panel heading-->
                <div class="panel-body"> 
                    <table class="table " style="font-size:medium;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-left" style="text-align:center;">Hospital Type</th>
                                <th class="text-left" style="text-align:center;">Hospitals</th>
                                <th class="text-left" style="text-align:center;">Patients</th>
                                <th class="text-left" style="text-align:center;">Orders</th>
                       <!--         <th colspan="3" style="padding-left:120px; font-size:medium;">Yesterday</th>-->
                                <th colspan="3" style="padding-left:70px;">Tests</th>
                            </tr>
                            <tr style="font-size:10px;">
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                             <!--   <th style="text-align:center;">Ordered</th>
                                <th style="text-align:center;">Completed</th>
                                <th style="text-align:center;">Reported</th>-->
                                <th style="text-align:center;">Ordered</th>
                                <th style="text-align:center;">Completed</th>
                                <th style="text-align:center;"> Reported</th>
                            </tr>
                        </thead>
                        <tbody>  
                            <?php 
                                $i=1;
                                foreach($report as $r) {
                            ?>
                            <tr>
                            <td><?php echo $i++;?></td>
                            <td style="text-align:center;"><?php echo $r->type;?></td>
                            <td style="text-align:center;"><?php echo number_format($r->hospital_count);?></td>
                            <td style="text-align:center;"><?php echo number_format($r->patient_count);?></td>
                            <td style="text-align:center;"><?php echo number_format($r->orders_count);?></td>
                          <!--  <td></td>
                            <td></td>
                            <td></td>-->
                            <td class="text-right"  style="text-align:center;"><?php echo number_format($r->tests_ordered);?></td>
                            <td class="text-right" style="text-align:center;"><?php echo number_format($r->tests_completed);?></td>
                            <td class="text-right" style="text-align:center;"><?php echo number_format($r->tests_reported);?></td>
                            </tr>
                                <?php }
                                ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <canvas id="hospital_wise_chart" width="200" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table " style="font-size:medium;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-left" style="text-align:center;">Lab Area</th>
                                <th class="text-left" style="text-align:center;">Hospitals</th>
                                <th class="text-left" style="text-align:center;">Patients</th>
                                <th class="text-left" style="text-align:center;">Orders</th>
                       <!--         <th colspan="3" style="padding-left:120px; font-size:medium;">Yesterday</th>-->
                                <th colspan="3" style="padding-left:70px;">Tests</th>
                            </tr>
                            <tr style="font-size:10px;">
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th style="text-align:center;">Ordered</th>
                                <th style="text-align:center;">Completed</th>
                                <th style="text-align:center;">Reported</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $i=1;
                                foreach($report1 as $r) {
                            ?>
                            <tr>
                            <td><?php echo $i++;?></td>
                            <td style="text-align:center;font-size:13px; "><?php echo $r->test_area;?></td>
                            <td style="text-align:center;"><?php echo number_format($r->hospital_count);?></td>
                            <td style="text-align:center;"><?php echo number_format($r->patient_count);?></td> 
                            <td style="text-align:center;"><?php echo number_format($r->orders_count);?></td>
                            <td class="text-right"  style="text-align:center;"><?php echo number_format($r->tests_ordered);?></td>
                            <td class="text-right" style="text-align:center;"><?php echo number_format($r->tests_completed);?></td>
                            <td class="text-right" style="text-align:center;"><?php echo number_format($r->tests_reported);?></td>
                            </tr>
                                <?php }
                                ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <canvas id="LabArea_wise_chart" width="200" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>   
</div>

<!--
Added by: Manish Kumar Sadhu
 -->