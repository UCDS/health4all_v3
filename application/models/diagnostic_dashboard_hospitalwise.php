<link rel="stylesheet"  type="text/css" href="<?php echo base_url();?>assets/css/bootstrap_datetimepicker.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css"> 
<script type="text/javascript" src="<?php echo base_url();?>assets/js/moment.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/Chart.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url();?>assets/js/highcharts.js"></script>-->

<style>
tbody > tr:nth-child(odd) {background-color: #f2f2f2;}
</style>

<?php         
            // To create a associated array of hospital types , dates and tests 

            $hospitals = array();
            foreach($report as $r) {                    
                
                if(array_key_exists($r->hospital,$hospitals)) {
                    
                    $hospitals[$r->hospital][$r->date] = array("tests_ordered"=>$r->number_format(tests_ordered),
                    "tests_completed"=>number_format($r->tests_completed), "tests_reported"=>$r->number_format(tests_reported),
                     "hospital_count"=>number_format($r->hospital_count), "patients_count"=>number_format($r->patient_count) ,
                     "orders_count"=>number_format($r->orders_count));
                }else{
                    $unique_hospitals=array();
                    $unique_hospitals[$r->date] = array("tests_ordered"=>number_format($r->tests_ordered),
                    "tests_completed"=>$r->number_format(tests_completed), "tests_reported"=>number_format($r->tests_reported) ,
                     "hospital_count"=>$r->number_format(hospital_count),"patients_count"=>number_format($r->patient_count) ,
                     "orders_count"=>number_format($r->orders_count)); 
                    $hospitals[$r->hospital] = $unique_hospitals;
                }
            }
            // $unique_hospitals_type= array_unique($hospitals_type);
               //var_dump($hospitals);
            $lab_areas = array();
            foreach($report1 as $r){
                if(array_key_exists($r->lab_area,$lab_areas)){
                    $lab_areas[$r->lab_area][$r->date] = array("tests_ordered"=>number_format($r->tests_ordered),
                    "tests_completed"=>number_format($r->tests_completed), "tests_reported"=>number_format($r->tests_reported) ,
                     "hospital_count"=>number_format($r->hospital_count),"patients_count"=>number_format($r->patient_count) ,
                     "orders_count"=>number_format($r->orders_count));
                }
                else{
                    $lab_areas_type=array();
                    $lab_areas_type[$r->date] = array("tests_ordered"=>number_format($r->tests_ordered),
                    "tests_completed"=>number_format($r->tests_completed), "tests_reported"=>number_format($r->tests_reported) ,
                     "hospital_count"=>number_format($r->hospital_count),"patients_count"=>number_format($r->patient_count) ,
                     "orders_count"=>number_format($r->orders_count)); 
                    $lab_areas[$r->lab_area] = $lab_areas_type;
                }
            }
                //var_dump($lab_areas);
               //var_dump($lab_areas_type);
            //  foreach($lab_areas as )
              $k=0;
        ?>
   
<script type="text/javascript">
    $(function(){
        
        var hospitalctx = $("#day_before_bar_HospitalWise");
		var myChart = new Chart(hospitalctx, {
			type: 'horizontalBar',
			data: {
                labels: [<?php $i=1; foreach($hospitals as $key=>$value) { echo "'".$key;if($i<count($hospitals)) echo "' ,"; else echo "'"; $i++; }?>],
				datasets: [
					{
						type: 'horizontalBar',
						label: 'Ordered',
						xAxisID : "A",
						backgroundColor: "rgba(255,102,0,0.6)",
						borderColor: "rgba(255,102,0,0.6)",
						data:[<?php $i=1; foreach($hospitals as $key=>$value) { if(isset($value[date('Y-m-d',strtotime("-2 days"))]['tests_ordered'])) echo $value[date('Y-m-d',strtotime("-2 days"))]['tests_ordered']; else echo $k ; if($i<count($hospitals)) echo ",";  $i++; } ?>],
					},
                    {
						type: 'horizontalBar',
						label: 'Completed',
						xAxisID : "A",
						backgroundColor: "rgba(153,204,0, 0.7)",
							borderColor: "rgba(153,204,0, 0.7)",
						data: [<?php $i=1; foreach($hospitals as $key=>$value) { if(isset($value[date('Y-m-d',strtotime("-2 days"))]['tests_completed'])) echo $value[date('Y-m-d',strtotime("-2 days"))]['tests_completed']; else echo $k ; if($i<count($hospitals)) echo ",";  $i++; } ?>],
					},
                    {
						type: 'horizontalBar',
						label: 'Reported',
						xAxisID : "A",
						backgroundColor: "#428bca",
						borderColor: "#428bca",
						data:[<?php $i=1; foreach($hospitals as $key=>$value) { if(isset($value[date('Y-m-d',strtotime("-2 days"))]['tests_reported'])) echo $value[date('Y-m-d',strtotime("-2 days"))]['tests_reported']; else echo $k ; if($i<count($hospitals)) echo ",";  $i++; } ?>],
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
                labels: [<?php $i=1; foreach($hospitals as $key=>$value) { echo "'".$key;if($i<count($hospitals)) echo "' ,"; else echo "'"; $i++; }?>],
				datasets: [
					{
						type: 'horizontalBar',
						label: 'Ordered',
						xAxisID : "A",
						backgroundColor: "rgba(255,102,0,0.6)",
						borderColor: "rgba(255,102,0,0.6)",
						data:[<?php $i=1; foreach($hospitals as $key=>$value) { if(isset($value[date('Y-m-d',strtotime("-1 days"))]['tests_ordered'])) echo $value[date('Y-m-d',strtotime("-2 days"))]['tests_ordered']; else echo $k ; if($i<count($hospitals)) echo ",";  $i++; } ?>],
					},
                    {
						type: 'horizontalBar',
						label: 'Completed',
						xAxisID : "A",
						backgroundColor: "rgba(153,204,0, 0.7)",
							borderColor: "rgba(153,204,0, 0.7)",
						data: [<?php $i=1; foreach($hospitals as $key=>$value) { if(isset($value[date('Y-m-d',strtotime("-1 days"))]['tests_completed'])) echo $value[date('Y-m-d',strtotime("-2 days"))]['tests_completed']; else echo $k ; if($i<count($hospitals)) echo ",";  $i++; } ?>],
					},
                    {
						type: 'horizontalBar',
						label: 'Reported',
						xAxisID : "A",
						backgroundColor: "#428bca",
						borderColor: "#428bca",
						data:[<?php $i=1; foreach($hospitals as $key=>$value) { if(isset($value[date('Y-m-d',strtotime("-1 days"))]['tests_reported'])) echo $value[date('Y-m-d',strtotime("-2 days"))]['tests_reported']; else echo $k ; if($i<count($hospitals)) echo ",";  $i++; } ?>],
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
                    labels: [<?php $i=1; foreach($hospitals as $key=>$value) { echo "'".$key;if($i<count($hospitals)) echo "' ,"; else echo "'"; $i++; }?>],
                    datasets: [
                        {
                            type: 'horizontalBar',
                            label: 'Ordered',
                            xAxisID : "A",
                            backgroundColor: "rgba(255,102,0,0.6)",
                            borderColor: "rgba(255,102,0,0.6)",
                            data:[<?php $i=1; foreach($hospitals as $key=>$value) { if(isset($value[date('Y-m-d')]['tests_ordered'])) echo $value[date('Y-m-d')]['tests_ordered']; else echo $k ; if($i<count($hospitals)) echo ",";  $i++; } ?>],
                        },
                        {
                            type: 'horizontalBar',
                            label: 'Completed',
                            xAxisID : "A",
                            backgroundColor: "rgba(153,204,0, 0.7)",
                                borderColor: "rgba(153,204,0, 0.7)",
                            data: [<?php $i=1; foreach($hospitals as $key=>$value) { if(isset($value[date('Y-m-d')]['tests_completed'])) echo $value[date('Y-m-d')]['tests_completed']; else echo $k ; if($i<count($hospitals)) echo ",";  $i++; } ?>],
                        },
                        {
                            type: 'horizontalBar',
                            label: 'Reported',
                            xAxisID : "A",
                            backgroundColor: "#428bca",
                            borderColor: "#428bca",
                            data:[<?php $i=1; foreach($hospitals as $key=>$value) { if(isset($value[date('Y-m-d')]['tests_reported'])) echo $value[date('Y-m-d')]['tests_reported']; else echo $k ; if($i<count($hospitals)) echo ",";  $i++; } ?>],
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
                labels:[<?php $i=1; foreach($lab_areas as $key=>$value) { echo "'".$key;if($i<count($lab_areas)) echo "' ,"; else echo "'"; $i++; }?>],
				datasets: [
					{
						type: 'horizontalBar',
						label: 'Ordered',
						xAxisID : "A",
						backgroundColor: "rgba(255,102,0,0.6)",
						borderColor: "rgba(255,102,0,0.6)",
						data:[<?php $i=1; foreach($lab_areas as $key=>$value) { if(isset($value[date('Y-m-d',strtotime("-2 days"))]['tests_ordered'])) echo $value[date('Y-m-d',strtotime("-2 days"))]['tests_ordered']; else echo $k ; if($i<count($lab_areas)) echo ",";  $i++; } ?>],
					},
                    {
						type: 'horizontalBar',
						label: 'Completed',
						xAxisID : "A",
						backgroundColor: "rgba(153,204,0, 0.7)",
							borderColor: "rgba(153,204,0, 0.7)",
						data: [<?php $i=1; foreach($lab_areas as $key=>$value) { if(isset($value[date('Y-m-d',strtotime("-2 days"))]['tests_completed'])) echo $value[date('Y-m-d',strtotime("-2 days"))]['tests_completed']; else echo $k ; if($i<count($lab_areas)) echo ",";  $i++; } ?>],
					},
                    {
						type: 'horizontalBar',
						label: 'Reported',
						xAxisID : "A",
						backgroundColor: "#428bca",
						borderColor: "#428bca",
						data:[<?php $i=1; foreach($lab_areas as $key=>$value) { if(isset($value[date('Y-m-d',strtotime("-2 days"))]['tests_reported'])) echo $value[date('Y-m-d',strtotime("-2 days"))]['tests_reported']; else echo $k ; if($i<count($lab_areas)) echo ",";  $i++; } ?>],
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
                    labels:[<?php $i=1; foreach($lab_areas as $key=>$value) { echo "'".$key;if($i<count($lab_areas)) echo "' ,"; else echo "'"; $i++; }?>],
                    datasets: [
                        {
                            type: 'horizontalBar',
                            label: 'Ordered',
                            xAxisID : "A",
                            backgroundColor: "rgba(255,102,0,0.6)",
                            borderColor: "rgba(255,102,0,0.6)",
                            data:[<?php $i=1; foreach($lab_areas as $key=>$value) { if(isset($value[date('Y-m-d',strtotime("-1 days"))]['tests_ordered'])) echo $value[date('Y-m-d',strtotime("-2 days"))]['tests_ordered']; else echo $k ; if($i<count($lab_areas)) echo ",";  $i++; } ?>],
                        },
                        {
                            type: 'horizontalBar',
                            label: 'Completed',
                            xAxisID : "A",
                            backgroundColor: "rgba(153,204,0, 0.7)",
                                borderColor: "rgba(153,204,0, 0.7)",
                            data: [<?php $i=1; foreach($lab_areas as $key=>$value) { if(isset($value[date('Y-m-d',strtotime("-1 days"))]['tests_completed'])) echo $value[date('Y-m-d',strtotime("-2 days"))]['tests_completed']; else echo $k ; if($i<count($lab_areas)) echo ",";  $i++; } ?>],
                        },
                        {
                            type: 'horizontalBar',
                            label: 'Reported',
                            xAxisID : "A",
                            backgroundColor: "#428bca",
                            borderColor: "#428bca",
                            data:[<?php $i=1; foreach($lab_areas as $key=>$value) { if(isset($value[date('Y-m-d',strtotime("-1 days"))]['tests_reported'])) echo $value[date('Y-m-d',strtotime("-2 days"))]['tests_reported']; else echo $k ; if($i<count($lab_areas)) echo ",";  $i++; } ?>],
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
                    labels:[<?php $i=1; foreach($lab_areas as $key=>$value) { echo "'".$key;if($i<count($lab_areas)) echo "' ,"; else echo "'"; $i++; }?>],
                    datasets: [
                        {
                            type: 'horizontalBar',
                            label: 'Ordered',
                            xAxisID : "A",
                            backgroundColor: "rgba(255,102,0,0.6)",
                            borderColor: "rgba(255,102,0,0.6)",
                            data:[<?php $i=1; foreach($lab_areas as $key=>$value) { if(isset($value[date('Y-m-d')]['tests_ordered'])) echo $value[date('Y-m-d')]['tests_ordered']; else echo $k ; if($i<count($lab_areas)) echo ",";  $i++; } ?>],
                        },
                        {
                            type: 'horizontalBar',
                            label: 'Completed',
                            xAxisID : "A",
                            backgroundColor: "rgba(153,204,0, 0.7)",
                                borderColor: "rgba(153,204,0, 0.7)",
                            data: [<?php $i=1; foreach($lab_areas as $key=>$value) { if(isset($value[date('Y-m-d')]['tests_completed'])) echo $value[date('Y-m-d')]['tests_completed']; else echo $k ; if($i<count($lab_areas)) echo ",";  $i++; } ?>],
                        },
                        {
                            type: 'horizontalBar',
                            label: 'Reported',
                            xAxisID : "A",
                            backgroundColor: "#428bca",
                            borderColor: "#428bca",
                            data:[<?php $i=1; foreach($lab_areas as $key=>$value) { if(isset($value[date('Y-m-d')]['tests_reported'])) echo $value[date('Y-m-d')]['tests_reported']; else echo $k ; if($i<count($lab_areas)) echo ",";  $i++; } ?>],
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
                    <div class="panel-heading" style="text-align:center;">
                        <h3  style="display:inline;">Diagnostics Dashboard - <?php echo $type;?></h3>
                    </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">
            <div class="panel panel-info">
                <div class="panel-heading" style="text-align:center;">
                    <h3  style="display:inline; padding-left:0px;">Tests:Day Before<?php echo "("; ?><?php echo date('d-M-Y',strtotime("-2 days"));?>)</h3>
                </div>
                <div class="panel-body" > 
                    <table class="table " style="font-size:medium;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-left" style="text-align:center ">Hospital Type</th>
                                <th></th>
                                <th class="text-left" colspan="5" style="text-align:center;  color:#0000FF; padding-left:150px;">Tests</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Hospitals</th>
                                <th>Patients</th>
                                <th>Orders</th>
                                <th style="color:#0000FF">Ordered</th>
                                <th style="color:#0000FF">Completed</th>
                                <th style="color:#0000FF">Reported</th> 
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $i=1;
                        foreach($hospitals as $key=>$value){
                        ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td style="text-align:center;"><?php echo $key; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d',strtotime("-2 days"))]['hospital_count']))  echo $value[date('Y-m-d',strtotime("-2 days"))]['hospital_count']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d',strtotime("-2 days"))]['patients_count']))  echo $value[date('Y-m-d',strtotime("-2 days"))]['patients_count']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d',strtotime("-2 days"))]['orders_count']))  echo $value[date('Y-m-d',strtotime("-2 days"))]['orders_count']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d',strtotime("-2 days"))]['tests_ordered']))  echo $value[date('Y-m-d',strtotime("-2 days"))]['tests_ordered']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d',strtotime("-2 days"))]['tests_completed']))  echo $value[date('Y-m-d',strtotime("-2 days"))]['tests_completed']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d',strtotime("-2 days"))]['tests_reported']))  echo $value[date('Y-m-d',strtotime("-2 days"))]['tests_reported']; else echo "0"; ?></td>
                                
                            </tr>                        
                        <?php 
                          
                          }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="panel panel-default" ">
                <div class="panel-heading" >
                    <h4 style="display:inline; color:#0000FF; padding-left:30px; "  font-family:"Helvetica Neue, Helvetica, Arial, sans-serif;">Tests: Day Before<?php echo "("; ?><?php echo date('d-M-Y',strtotime("-2 days"));?>)</h4>
                </div>
                <div class="panel-body">
                    <canvas id="day_before_bar_HospitalWise" style="min-width: 310px; height: 400px; margin:0 auto"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">
            <div class="panel panel-info">
                <div class="panel-heading" style="text-align:center;">
                    <h3  style="display:inline; padding-left:0px;">Tests:Yesterday<?php echo "("; ?><?php echo date('d-M-Y',strtotime("-1 days"));?>)</h3>
                </div>
                <div class="panel-body" > 
                    <table class="table  " style="font-size:medium;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-left" style="text-align:center ">Hospital Type</th>
                                <th></th>
                                <th class="text-left" colspan="5" style="text-align:center;  color:#0000FF; padding-left:150px;">Tests</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Hospitals</th>
                                <th>Patients</th>
                                <th>Orders</th>
                                <th style="color:#0000FF">Ordered</th>
                                <th style="color:#0000FF">Completed</th>
                                <th style="color:#0000FF">Reported</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $i=1;
                        foreach($hospitals as $key=>$value){
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td style="text-align:center;"><?php echo $key; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d',strtotime("-1 days"))]['hospital_count']))  echo $value[date('Y-m-d',strtotime("-1 days"))]['hospital_count']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d',strtotime("-1 days"))]['patients_count']))  echo $value[date('Y-m-d',strtotime("-1 days"))]['patients_count']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d',strtotime("-1 days"))]['orders_count']))  echo $value[date('Y-m-d',strtotime("-1 days"))]['orders_count']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d',strtotime("-1 days"))]['tests_ordered']))  echo $value[date('Y-m-d',strtotime("-1 days"))]['tests_ordered']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d',strtotime("-1 days"))]['tests_completed']))  echo $value[date('Y-m-d',strtotime("-1 days"))]['tests_completed']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d',strtotime("-1 days"))]['tests_reported']))  echo $value[date('Y-m-d',strtotime("-1 days"))]['tests_reported']; else echo "0"; ?></td>
                                
                            </tr>    
                        <?php     
                          }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading" >
                    <h4 style="display:inline; color:#dd4b39; padding-left:30px; "  font-family:"Helvetica Neue, Helvetica, Arial, sans-serif;">Tests: Yesterday<?php echo "("; ?><?php echo date('d-M-Y',strtotime("-1 days"));?>)</h4>
                </div>
                <div class="panel-body">
                    <canvas id="yesterday_bar_HospitalWise" style="min-width: 310px; height: 400px; margin:0 auto"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">
            <div class="panel panel-info">
                <div class="panel-heading" style="text-align:center;">
                    <h3  style="display:inline; padding-left:0px;">Tests:Today<?php echo "("; ?><?php echo date("d-M-Y");?>)</h3>
                </div>
                <div class="panel-body" > 
                    <table class="table  " style="font-size:medium;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-left" style="text-align:center ">Hospital Type</th>
                                <th></th>
                                <th class="text-left" colspan="5" style="text-align:center;  color:#0000FF; padding-left:150px;">Tests</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Hospitals</th>
                                <th>Patients</th>
                                <th>Orders</th>
                                <th style="color:#0000FF">Ordered</th>
                                <th style="color:#0000FF">Completed</th>
                                <th style="color:#0000FF">Reported</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $i=1;
                        foreach($hospitals as $key=>$value){
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td style="text-align:center;"><?php echo $key; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d')]['hospital_count']))  echo $value[date('Y-m-d')]['hospital_count']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d')]['patients_count']))  echo $value[date('Y-m-d')]['patients_count']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d')]['orders_count']))  echo $value[date('Y-m-d' )]['orders_count']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d')]['tests_ordered']))  echo $value[date('Y-m-d')]['tests_ordered']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d')]['tests_completed']))  echo $value[date('Y-m-d')]['tests_completed']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d')]['tests_reported']))  echo $value[date('Y-m-d')]['tests_reported']; else echo "0"; ?></td>
                            </tr>    
                        <?php     
                          }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-5">
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
            </div>                  
        </div>
    </div>
    <div class="row">
        <div class="col-md-7"> <!-- Table to display tests grouped by dates and Areas-->
            <div class="panel panel-info">
                <div class="panel-heading" style="text-align:center;">
                    <h3  style="display:inline;  padding-left:0px;">Tests:Day Before<?php echo "("; ?><?php echo date('d-M-Y',strtotime("-2 days"));?>)</h3>
                </div>
                <div class="panel-body"> 
                    <table class="table " style="font-size:medium;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-left" style="text-align:center ">Lab Area</th>
                                <th></th>
                                <th class="text-left" colspan="5" style="text-align:center;  color:#0000FF; padding-left:150px;">Tests</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Hospitals</th>
                                <th>Patients</th>
                                <th>Orders</th>
                                <th style="color:#0000FF">Ordered</th>
                                <th style="color:#0000FF">Completed</th>
                                <th style="color:#0000FF">Reported</th> 
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        //var_dump($report1);
                        $i=1;
                        foreach($lab_areas as $key=>$value){
                        ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td style="text-align:left; "><?php echo $key; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d',strtotime("-2 days"))]['hospital_count']))  echo $value[date('Y-m-d',strtotime("-2 days"))]['hospital_count']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d',strtotime("-2 days"))]['patients_count']))  echo $value[date('Y-m-d',strtotime("-2 days"))]['patients_count']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d',strtotime("-2 days"))]['orders_count']))  echo $value[date('Y-m-d',strtotime("-2 days"))]['orders_count']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d',strtotime("-2 days"))]['tests_ordered']))  echo $value[date('Y-m-d',strtotime("-2 days"))]['tests_ordered']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d',strtotime("-2 days"))]['tests_completed']))  echo $value[date('Y-m-d',strtotime("-2 days"))]['tests_completed']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d',strtotime("-2 days"))]['tests_reported']))  echo $value[date('Y-m-d',strtotime("-2 days"))]['tests_reported']; else echo "0"; ?></td>
                            </tr>
                        <?php 
                          }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading" >
                    <h4 style="display:inline; color:#0000FF; padding-left:30px; "  font-family:"Helvetica Neue, Helvetica, Arial, sans-serif;">Tests: Day Before<?php echo "("; ?><?php echo date('d-M-Y',strtotime("-2 days"));?>)</h4>
                </div>
                <div class="panel-body">
                    <canvas id="day_before_bar_LabAreaWise" style="min-width: 310px; height: 400px; margin:0 auto"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7">
            <div class="panel panel-info">
                <div class="panel-heading" style="text-align:center;">
                    <h3  style="display:inline; padding-left:0px;">Tests:Yesterday<?php echo "("; ?><?php echo date('d-M-Y',strtotime("-1 days"));?>)</h3>
                </div>
                <div class="panel-body" > 
                    <table class="table  " style="font-size:medium;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-left" style="text-align:center ">Lab Area</th>
                                <th></th>
                                <th class="text-left" colspan="5" style="text-align:center;  color:#0000FF; padding-left:150px;">Tests</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Hospitals</th>
                                <th>Patients</th>
                                <th>Orders</th>
                                <th style="color:#0000FF">Ordered</th>
                                <th style="color:#0000FF">Completed</th>
                                <th style="color:#0000FF">Reported</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $i=1;
                        $l=0;
                        $q=0;
                        foreach($lab_areas as $key=>$value){
                        ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td style="text-align:left;"><?php echo $key; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d',strtotime("-1 days"))]['hospital_count']))  echo $value[date('Y-m-d',strtotime("-1 days"))]['hospital_count']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d',strtotime("-1 days"))]['patients_count']))  echo $value[date('Y-m-d',strtotime("-1 days"))]['patients_count']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d',strtotime("-1 days"))]['orders_count']))  echo $value[date('Y-m-d',strtotime("-1 days"))]['orders_count']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d',strtotime("-1 days"))]['tests_ordered']))  echo $value[date('Y-m-d',strtotime("-1 days"))]['tests_ordered']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d',strtotime("-1 days"))]['tests_completed']))  echo $value[date('Y-m-d',strtotime("-1 days"))]['tests_completed']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d',strtotime("-1 days"))]['tests_reported']))  echo $value[date('Y-m-d',strtotime("-1 days"))]['tests_reported']; else echo "0"; ?></td>
                            </tr>
                        <?php     
                          }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="panel panel-default">
                <div class="panel-heading" >
                    <h4 style="display:inline; color:#dd4b39; padding-left:30px; "  font-family:"Helvetica Neue, Helvetica, Arial, sans-serif;">Tests: Yesterday<?php echo "("; ?><?php echo date('d-M-Y',strtotime("-1 days"));?>)</h4>
                </div>
                <div class="panel-body">
                    <canvas id="Yesterday_bar_LabAreaWise" style="min-width: 310px; height: 400px; margin:0 auto"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
       <div class="col-md-7"> 
           <div class="panel panel-info">
                <div class="panel-heading" style="text-align:center;">
                    <h3  style="display:inline; padding-left:0px;">Tests:Today<?php echo "("; ?><?php echo date("d-M-Y");?>)</h3>
                </div>
                <div class="panel-body" > 
                    <table class="table  " style="font-size:medium;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-left" style="text-align:center ">Lab Area</th>
                                <th></th>
                                <th class="text-left" colspan="5" style="text-align:center;  color:#0000FF; padding-left:150px;">Tests</th>
                            </tr>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Hospitals</th>
                                <th>Patients</th>
                                <th>Orders</th>
                                <th style="color:#0000FF">Ordered</th>
                                <th style="color:#0000FF">Completed</th>
                                <th style="color:#0000FF">Reported</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        $i=1;
                        foreach($lab_areas as $key=>$value){
                        ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td style="text-align:left;"><?php echo $key; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d')]['hospital_count']))  echo $value[date('Y-m-d')]['hospital_count']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d')]['patients_count']))  echo $value[date('Y-m-d')]['patients_count']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d')]['orders_count']))  echo $value[date('Y-m-d' )]['orders_count']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d')]['tests_ordered']))  echo $value[date('Y-m-d')]['tests_ordered']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d')]['tests_completed']))  echo $value[date('Y-m-d')]['tests_completed']; else echo "0"; ?></td>
                                <td style="text-align:center;"><?php if(isset($value[date('Y-m-d')]['tests_reported']))  echo $value[date('Y-m-d')]['tests_reported']; else echo "0"; ?></td>
                            </tr>
                        <?php     
                          }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
       </div>
        <div class="col-md-5">
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