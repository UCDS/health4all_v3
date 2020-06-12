<link rel="stylesheet"  type="text/css" href="<?php echo base_url();?>assets/css/bootstrap_datetimepicker.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css"> 
<script type="text/javascript" src="<?php echo base_url();?>assets/js/moment.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/Chart.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url();?>assets/js/highcharts.js"></script>-->

   
<?php $k=0; ?>        
<script type="text/javascript">
    $(function(){
        
        var hospitalctx = $("#day_before_bar_HospitalWise");
		var myChart = new Chart(hospitalctx, {
			type: 'horizontalBar',
			data: {
					labels: [<?php $i=1; foreach($report as $a) { echo "'".$a->hospital_type;if($i<count($report)) echo "' ,"; else echo "'"; $i++; }?>],
				datasets: [
					{
						type: 'horizontalBar',
						label: 'Ordered',
						xAxisID : "A",
						backgroundColor: "rgba(255,102,0,0.6)",
						borderColor: "rgba(255,102,0,0.6)",
						data: [<?php $i=1;foreach($report as $a) { echo $a->tests_ordered_daybefore;if($i<count($report)) echo " ,"; $i++; }?>]
					},
                    {
						type: 'horizontalBar',
						label: 'Completed',
						xAxisID : "A",
						backgroundColor: "rgba(153,204,0, 0.7)",
							borderColor: "rgba(153,204,0, 0.7)",
						data: [<?php $i=1;foreach($report as $a) { echo $a->tests_completed_daybefore;if($i<count($report)) echo " ,"; $i++; }?>]
					},
                    {
						type: 'horizontalBar',
						label: 'Reported',
						xAxisID : "A",
						backgroundColor: "#428bca",
						borderColor: "#428bca",
						data: [<?php $i=1;foreach($report as $a) { echo $a->tests_reported_daybefore;if($i<count($report)) echo " ,"; $i++; }?>]
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
		});         // end of Day-Before hospital wise bar chart  

        var hospitalctx1 = $("#yesterday_bar_HospitalWise");
		var myChart = new Chart(hospitalctx1, {
			type: 'horizontalBar',
			data: {
					labels: [<?php $i=1; foreach($report as $a) { echo "'".$a->hospital_type;if($i<count($report)) echo "' ,"; else echo "'"; $i++; }?>],
				datasets: [
					{
						type: 'horizontalBar',
						label: 'Ordered',
						xAxisID : "A",
						backgroundColor: "rgba(255,102,0,0.6)",
						borderColor: "rgba(255,102,0,0.6)",
						data: [<?php $i=1;foreach($report as $a) { echo $a->tests_ordered_yesterday;if($i<count($report)) echo " ,"; $i++; }?>]
					},
                    {
						type: 'horizontalBar',
						label: 'Completed',
						xAxisID : "A",
						backgroundColor: "rgba(153,204,0, 0.7)",
							borderColor: "rgba(153,204,0, 0.7)",
						data: [<?php $i=1;foreach($report as $a) { echo $a->tests_completed_yesterday;if($i<count($report)) echo " ,"; $i++; }?>]
					},
                    {
						type: 'horizontalBar',
						label: 'Reported',
						xAxisID : "A",
						backgroundColor: "#428bca",
						borderColor: "#428bca",
						data: [<?php $i=1;foreach($report as $a) { echo $a->tests_reported_yesterday;if($i<count($report)) echo " ,"; $i++; }?>]
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
                // End of Yesterday Hospital Wise Bar Chart

            var hospitalctx2 = $("#today_bar_HospitalWise");
            var myChart = new Chart(hospitalctx2, {
                type: 'horizontalBar',
                data: {
                 	labels: [<?php $i=1; foreach($report as $a) { echo "'".$a->hospital_type;if($i<count($report)) echo "' ,"; else echo "'"; $i++; }?>],
				datasets: [
					{
						type: 'horizontalBar',
						label: 'Ordered',
						xAxisID : "A",
						backgroundColor: "rgba(255,102,0,0.6)",
						borderColor: "rgba(255,102,0,0.6)",
						data: [<?php $i=1;foreach($report as $a) { echo $a->tests_ordered_today;if($i<count($report)) echo " ,"; $i++; }?>]
					},
                    {
						type: 'horizontalBar',
						label: 'Completed',
						xAxisID : "A",
						backgroundColor: "rgba(153,204,0, 0.7)",
							borderColor: "rgba(153,204,0, 0.7)",
						data: [<?php $i=1;foreach($report as $a) { echo $a->tests_completed_today;if($i<count($report)) echo " ,"; $i++; }?>]
					},
                    {
						type: 'horizontalBar',
						label: 'Reported',
						xAxisID : "A",
						backgroundColor: "#428bca",
						borderColor: "#428bca",
						data: [<?php $i=1;foreach($report as $a) { echo $a->tests_reported_today;if($i<count($report)) echo " ,"; $i++; }?>]
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
                    // End of today's tests Hospital Wise Bar chart. 
           
           
           var Day_Before_Lab_Area = $("#day_before_bar_LabAreaWise");
		    var myChart = new Chart(Day_Before_Lab_Area, {
			type: 'horizontalBar',
			data: {
					labels: [<?php $i=1; foreach($report1 as $a) { echo "'".$a->lab_area;if($i<count($report1)) echo "' ,"; else echo "'"; $i++; }?>],
				datasets: [
					{
						type: 'horizontalBar',
						label: 'Ordered',
						xAxisID : "A",
						backgroundColor: "rgba(255,102,0,0.6)",
						borderColor: "rgba(255,102,0,0.6)",
						data: [<?php $i=1;foreach($report1 as $a) { echo $a->tests_ordered_daybefore;if($i<count($report1)) echo " ,"; $i++; }?>]
					},
                    {
						type: 'horizontalBar',
						label: 'Completed',
						xAxisID : "A",
						backgroundColor: "rgba(153,204,0, 0.7)",
							borderColor: "rgba(153,204,0, 0.7)",
						data: [<?php $i=1;foreach($report1 as $a) { echo $a->tests_completed_daybefore;if($i<count($report1)) echo " ,"; $i++; }?>]
					},
                    {
						type: 'horizontalBar',
						label: 'Reported',
						xAxisID : "A",
						backgroundColor: "#428bca",
						borderColor: "#428bca",
						data: [<?php $i=1;foreach($report1 as $a) { echo $a->tests_reported_daybefore;if($i<count($report1)) echo " ,"; $i++; }?>]
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
		}); // Day Before Lab area wise bar chart

                var Yesterday_Lab_Area = $("#Yesterday_bar_LabAreaWise");
                var myChart = new Chart(Yesterday_Lab_Area, {
                type: 'horizontalBar',
                data: {
                        labels: [<?php $i=1; foreach($report1 as $a) { echo "'".$a->lab_area;if($i<count($report1)) echo "' ,"; else echo "'"; $i++; }?>],
				datasets: [
					{
						type: 'horizontalBar',
						label: 'Ordered',
						xAxisID : "A",
						backgroundColor: "rgba(255,102,0,0.6)",
						borderColor: "rgba(255,102,0,0.6)",
						data: [<?php $i=1;foreach($report1 as $a) { echo $a->tests_ordered_yesterday;if($i<count($report1)) echo " ,"; $i++; }?>]
					},
                    {
						type: 'horizontalBar',
						label: 'Completed',
						xAxisID : "A",
						backgroundColor: "rgba(153,204,0, 0.7)",
							borderColor: "rgba(153,204,0, 0.7)",
						data: [<?php $i=1;foreach($report1 as $a) { echo $a->tests_completed_yesterday;if($i<count($report1)) echo " ,"; $i++; }?>]
					},
                    {
						type: 'horizontalBar',
						label: 'Reported',
						xAxisID : "A",
						backgroundColor: "#428bca",
						borderColor: "#428bca",
						data: [<?php $i=1;foreach($report1 as $a) { echo $a->tests_reported_yesterday;if($i<count($report1)) echo " ,"; $i++; }?>]
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
                    // Yesterday Lab Area Wise bar Chart

                    var Today_Lab_Area = $("#Today_bar_LabAreaWise");
                var myChart = new Chart(Today_Lab_Area, {
                type: 'horizontalBar',
                data: {
                  	labels: [<?php $i=1; foreach($report1 as $a) { echo "'".$a->lab_area;if($i<count($report1)) echo "' ,"; else echo "'"; $i++; }?>],
				datasets: [
					{
						type: 'horizontalBar',
						label: 'Ordered',
						xAxisID : "A",
						backgroundColor: "rgba(255,102,0,0.6)",
						borderColor: "rgba(255,102,0,0.6)",
						data: [<?php $i=1;foreach($report1 as $a) { echo $a->tests_ordered_today;if($i<count($report1)) echo " ,"; $i++; }?>]
					},
                    {
						type: 'horizontalBar',
						label: 'Completed',
						xAxisID : "A",
						backgroundColor: "rgba(153,204,0, 0.7)",
							borderColor: "rgba(153,204,0, 0.7)",
						data: [<?php $i=1;foreach($report1 as $a) { echo $a->tests_completed_today;if($i<count($report1)) echo " ,"; $i++; }?>]
					},
                    {
						type: 'horizontalBar',
						label: 'Reported',
						xAxisID : "A",
						backgroundColor: "#428bca",
						borderColor: "#428bca",
						data: [<?php $i=1;foreach($report1 as $a) { echo $a->tests_reported_today;if($i<count($report1)) echo " ,"; $i++; }?>]
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
                    // Today Lab Area Wise bar Chart


    }); 
</script>
        
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3  style="display:inline; padding-left:380px;">Diagnostics Dashboard - <?php echo "$type" ?> </h3>
                </div>
                <div class="panel-body"> 
                    <table class="table table-striped" style="font-size:medium;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-left" style="text-align:center ">Hospital Name</th>
                                <th class="text-left" colspan="3" style="text-align:center; padding-right:35px; color:#0000FF; ">Day Before<?php echo "<br>("; ?><?php echo date('d-M-Y',strtotime("-2 days"));?>)</th>
                                <th class="text-left" colspan="3" style="text-align:center; padding-right:35px; color:#dd4b39; ">Yesterday<?php echo "<br>("; ?><?php echo date('d-M-Y',strtotime("-1 days"));?>)</th>
                                <th class="text-left" colspan="3" style="text-align:center; padding-right:35px; color:#f39c12; ">Today<?php echo "<br>("; ?><?php echo date("d-M-Y");?>)</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th style="color:#0000FF">Ordered</th>
                                <th style="color:#0000FF">Completed</th>
                                <th style="color:#0000FF">Reported</th>
                                <th style="color:#dd4b39">Ordered</th>
                                <th style="color:#dd4b39">Completed</th>
                                <th style="color:#dd4b39">Reported</th>
                                <th style="color:#f39c12">Ordered</th>
                                <th style="color:#f39c12">Completed</th>
                                <th style="color:#f39c12">Reported</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $i=1;
                        $l=0;
                        $q=0;
                          foreach($report as $r){
                        ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td style="text-align:center; "><?php echo $r->hospital; ?></a></td>
                                <td style="text-align:center;"><?php if(isset($r->tests_ordered_daybefore))  echo $r->tests_ordered_daybefore; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($r->tests_completed_daybefore))  echo $r->tests_completed_daybefore; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($r->tests_reported_daybefore))  echo $r->tests_reported_daybefore; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($r->tests_ordered_yesterday))  echo $r->tests_ordered_yesterday; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($r->tests_completed_yesterday))  echo $r->tests_completed_yesterday; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($r->tests_reported_yesterday))  echo $r->tests_reported_yesterday; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($r->tests_ordered_today))  echo $r->tests_ordered_today; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($r->tests_completed_today))  echo $r->tests_completed_today; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($r->tests_reported_today))  echo $r->tests_reported_today; else echo "0"; ?></td>
                                
                            </tr>
                        </tbody>
                        <?php 
                          
                          }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading" >
                    <h4 style="display:inline; color:#0000FF; padding-left:30px; "  font-family:"Helvetica Neue, Helvetica, Arial, sans-serif;">Tests: Day Before<?php echo "("; ?><?php echo date('d-M-Y',strtotime("-2 days"));?>)</h4>
                </div>
                <div class="panel-body">
                    <canvas id="day_before_bar_HospitalWise" style="min-width: 310px; height: 400px; margin:0 auto"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading" >
                    <h4 style="display:inline; color:#dd4b39; padding-left:30px; "  font-family:"Helvetica Neue, Helvetica, Arial, sans-serif;">Tests: Yesterday<?php echo "("; ?><?php echo date('d-M-Y',strtotime("-1 days"));?>)</h4>
                </div>
                <div class="panel-body">
                    <canvas id="yesterday_bar_HospitalWise" style="min-width: 310px; height: 400px; margin:0 auto"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading" >
                    <h4 style="display:inline; color:#f39c12; padding-left:30px; "  font-family:"Helvetica Neue, Helvetica, Arial, sans-serif;">Tests: Today <?php echo "("; ?><?php echo date('d-M-Y');?>)</h4>
                </div>
                <div class="panel-body" style="min-width: 310px;">
                    <canvas id="today_bar_HospitalWise" style="min-width: 310px; height: 400px;  margin:0 auto"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12"> <!-- Table to display tests grouped by dates and Areas-->
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3  style="display:inline; padding-left:380px;">Diagnostics Dashboard Lab Area Wise</h3>
                </div>
                <div class="panel-body"> 
                    <table class="table table-striped" style="font-size:medium;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-left" style="text-align:center">Lab Area</th>
                                <th class="text-left" colspan="3" style="text-align:center; padding-right:35px; color:#0000FF; ">Day Before<?php echo "<br>("; ?><?php echo date('d-M-Y',strtotime("-2 days"));?>)</th>
                                <th class="text-left" colspan="3" style="text-align:center; padding-right:35px; color:#dd4b39; ">Yesterday<?php echo "<br>("; ?><?php echo date('d-M-Y',strtotime("-1 days"));?>)</th>
                                <th class="text-left" colspan="3" style="text-align:center; padding-right:35px; color:#f39c12; ">Today<?php echo "<br>("; ?><?php echo date("d-M-Y");?>)</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th style="color:#0000FF">Ordered</th>
                                <th style="color:#0000FF">Completed</th>
                                <th style="color:#0000FF">Reported</th>
                                <th style="color:#dd4b39">Ordered</th>
                                <th style="color:#dd4b39">Completed</th>
                                <th style="color:#dd4b39">Reported</th>
                                <th style="color:#f39c12">Ordered</th>
                                <th style="color:#f39c12">Completed</th>
                                <th style="color:#f39c12">Reported</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        
                        //var_dump($report1);
                        
                        $i=1;
                        foreach($report1 as $s){
                        ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td style="text-align:left;"><?php echo $s->lab_area; ?></td>
                                <td style="text-align:center;"><?php if(isset($s->tests_ordered_daybefore))  echo $s->tests_ordered_daybefore; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($s->tests_completed_daybefore))  echo $s->tests_completed_daybefore; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($s->tests_reported_daybefore))  echo $s->tests_reported_daybefore; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($s->tests_ordered_yesterday))  echo $s->tests_ordered_yesterday; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($s->tests_completed_yesterday))  echo $s->tests_completed_yesterday; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($s->tests_reported_yesterday))  echo $s->tests_reported_yesterday; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($s->tests_ordered_today))  echo $s->tests_ordered_today; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($s->tests_completed_today))  echo $s->tests_completed_today; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($s->tests_reported_today))  echo $s->tests_reported_today; else echo "0"; ?></td>                            </tr>
                        </tbody>
                        <?php 
                          
                          }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading" >
                    <h4 style="display:inline; color:#0000FF; padding-left:30px; "  font-family:"Helvetica Neue, Helvetica, Arial, sans-serif;">Tests: Day Before<?php echo "("; ?><?php echo date('d-M-Y',strtotime("-2 days"));?>)</h4>
                </div>
                <div class="panel-body">
                    <canvas id="day_before_bar_LabAreaWise" style="min-width: 310px; height: 400px; margin:0 auto"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading" >
                    <h4 style="display:inline; color:#dd4b39; padding-left:30px; "  font-family:"Helvetica Neue, Helvetica, Arial, sans-serif;">Tests: Yesterday<?php echo "("; ?><?php echo date('d-M-Y',strtotime("-1 days"));?>)</h4>
                </div>
                <div class="panel-body">
                    <canvas id="Yesterday_bar_LabAreaWise" style="min-width: 310px; height: 400px; margin:0 auto"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading" >
                    <h4 style="display:inline; color:#f39c12; padding-left:30px; "  font-family:"Helvetica Neue, Helvetica, Arial, sans-serif;">Tests: Today <?php echo "("; ?><?php echo date('d-M-Y');?>)</h4>
                </div>
                <div class="panel-body" style="min-width: 310px;">
                    <canvas id="Today_bar_LabAreaWise" style="min-width: 310px; height: 400px;  margin:0 auto"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!--
Added by: Manish Kumar Sadhu
 -->