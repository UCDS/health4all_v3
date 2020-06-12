	<link rel="stylesheet"  type="text/css" href="<?php echo base_url();?>assets/css/bootstrap_datetimepicker.css"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css"> 
	<script src="<?php echo base_url();?>assets/js/highcharts.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/ajaxcalls.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/moment.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>

	<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/Chart.js"></script>
	<?php
        $from_time=0;$to_time=0;
        if($this->input->post('from_time')) $from_time=date("H:i",strtotime($this->input->post('from_time'))); else $from_time = date("00:00");
        if($this->input->post('to_time')) $to_time=date("H:i",strtotime($this->input->post('to_time'))); else $to_time = date("23:59");
	?>
    	<div class="container">
	<?php
			$total_op=0;
			$total_repeat_op=0;
			$total_ip=0;
		foreach($report as $r) { 
			$total_op=0;
			$total_repeat_op=0;
			$total_ip=0;
			foreach($report as $r) {
				$total_op+=$r->total_op;
				$total_ip+=$r->total_ip;
				$total_repeat_op+=$r->repeat_op;
			}
		}

		
	?>
	<div class="row">  
		<div class="col-md-6">
			<div class="panel panel-info">
				<div class="panel-heading">
					<h5 style="display:inline">Report as on <?php echo date("d-M-Y g:iA");?></small></h5>

					<span class="text-right" style="display:inline">	
						<?php echo form_open("dashboard/state/".$state,array("class"=>"form-custom", "style"=>"text-align:left"));?>
					    	<input type="hidden" name="organization" id="organization" value="<?=$state?>">
                                <label style="width:40px;">From: </label>
                                <input type="text" class="date form-control" style="width:110px" value="<?php if($this->input->post('from_date')) echo date("d-M-Y",strtotime($this->input->post('from_date'))); else echo date("d-M-Y");?>" name="from_date" id="from_date" />
                                <input  class="form-control" style = "background-color:#EEEEEE;" type="text" value="<?php echo date("h:i A",strtotime($from_time)); ?>" name="from_time" id="from_time" size="7px"/>
                                <br/>
                                <label style="width:40px;">To: </label>
                                <input type="text" class="date form-control" style="width:110px; padding-top:5px;" value="<?php if($this->input->post('to_date')) echo date("d-M-Y",strtotime($this->input->post('to_date'))); else echo date("d-M-Y");?>" name="to_date" id="to_date" />
                                <input class="form-control" style = "padding-left:-144px;background-color:#EEEEEE;" type="text" value="<?php echo date("h:i A",strtotime($to_time)); ?>" name="to_time" id="to_time" size="7px" />
                                <input type="submit" style="margin-left:15px;" class="btn btn-sm btn-primary" value="Submit" name="submit" />
                                <?php echo form_close(); ?>
					</span>
				</div>
				<div class="panel-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th></th>
								<th></th>
                                <th></th>
								<th colspan="3" class="text-center"style="color:#ffa366;"><b>OP</b></th>
								<th class="text-right" style="color:#b7db4c;"><b>IP</b></th>
							</tr>
							<tr>
							    <th></th>	
                                <th>Hospital Type</th>
                                <th>Hospital Count</th>
                                <th class="text-right">New</th>
								<th class="text-right">Repeat</th>
								<th class="text-right">OP Total</th>
                            </tr>
							<?php 
												$total_hospital_count=0;
												foreach($report as $r){
													$total_hospital_count+=$r->hospital_count;
												}
										?>

                            <tr>
								<th>#</th>
								<th></th>
								<th class="text-center"><?php echo number_format($total_hospital_count);?></th>
                                <th class="text-right"><?php echo number_format($total_op - $total_repeat_op);?></th>
								<th class="text-right"><?php echo number_format($total_repeat_op);?></th>
								<th class="text-right"><?php echo number_format($total_op);?></th>
								<th class="text-right"><?php echo number_format($total_ip);?></th>
							</tr>
						</thead>
						<tbody>
						<?php 
						$i=1;
						foreach($report as $r) {
						?>
								<tr>
									<td><?php echo $i++;?></td>
									<td><a onClick="gotoStateView('<?=$r->short_name?>')"><?php echo $r->org_label;?></a></td>
									<td class="text-center"><?= $r->hospital_count;?></td>
                                    <td class="text-right"><?php echo number_format($r->total_op - $r->repeat_op);?></td>
									<td class="text-right"><?php echo number_format($r->repeat_op);?></td>
									<td class="text-right"><?php echo number_format($r->total_op);?></td>
									<td class="text-right"><?php echo number_format($r->total_ip);?></td>
								</tr>
						<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>		
		<div class="col-md-6">
			<div class="panel panel-default">
			    <div class="panel-body">
		    	    <canvas id="hospitalChart" width="200" height="150"></canvas>
			    </div>
			</div>
		</div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div id="OPTypePie" style="min-width: 310px; height: 400px; max-width: 600px;margin:0 auto"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div id="IPTypePie" style="min-width: 310px; height: 400px; max-width: 600px;margin:0 auto"></div>
                    </div>
                </div>
            </div>
		</div>
	</div>
    
	</div>

	<script>
	$(function(){
        	$('#from_time').ptTimeSelect();
		$('#to_time').ptTimeSelect();

		$(".date").datetimepicker({
			format : "D-MMM-YYYY"
		});
		
			var hospitalctx = $("#hospitalChart");
			var myChart = new Chart(hospitalctx, {
				type: 'horizontalBar',
				data: {
					labels: [<?php $i=1;foreach($report as $a) { echo "'".$a->org_label;if($i<count($report)) echo "' ,"; else echo "'"; $i++; }?>],
					datasets: [
						{
							type: 'horizontalBar',
							label: 'OP',
							xAxisID : "A",
							backgroundColor: "rgba(255,102,0,0.6)",
							borderColor: "rgba(255,102,0,0.6)",
							data: [<?php $i=1;foreach($report as $a) { echo $a->total_op;if($i<count($report)) echo " ,"; $i++; }?>]
						},
						{
							type: 'horizontalBar',
							label: 'IP',
							xAxisID : "A",
							backgroundColor: "rgba(153,204,0, 0.7)",
							borderColor: "rgba(153,204,0, 0.7)",
						data: [<?php $i=1;foreach($report as $a) { echo $a->total_ip;if($i<count($report)) echo " ,"; $i++; }?>],
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
								labelString : "Patients"
							}
						}],
						yAxes: [{
							stacked: true
						}]
					}
				}
			});

            //optype pie for telangana dashboard (TTVVP, DME....)
            Highcharts.chart('OPTypePie', {
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
					type: 'pie'
				},
				credits: {
						enabled: false
						},
				title: {
					text: 'OP-Patients'
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> , Count: <b>{point.y:>1f}</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							format: '<b>{point.name}</b>: {point.percentage:.1f} %',
							style: {
								color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
							}
						}
					}
				},
				series: [{
					name: 'Patients',
					colorByPoint: true,
					data: [
						<?php 
							$i=1;
							foreach($report as $a) {
						?>
							{
								name:<?="'$a->org_label'"?>,
								y: <?=$a->total_op?>
								
							}
						<?php
								if($i<count($report)) echo ",";	 $i++;
							}
						?>
					]
				}]
		});
        Highcharts.chart('IPTypePie', {
				chart: {
					plotBackgroundColor: null,
					plotBorderWidth: null,
					plotShadow: false,
					type: 'pie'
				},
				credits: {
						enabled: false
						},
				title: {
					text: 'IP-	Patients'
				},
				tooltip: {
					pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b> , Count: <b>{point.y:>1f}</b>'
				},
				plotOptions: {
					pie: {
						allowPointSelect: true,
						cursor: 'pointer',
						dataLabels: {
							enabled: true,
							format: '<b>{point.name}</b>: {point.percentage:.1f} %',
							style: {
								color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
							}
						} 

					}
				},
				series: [{
					name: 'Patients',
					colorByPoint: true,
					data: [
						<?php 
							$i=1;
							foreach($report as $a) {
						?>
							{
								name:<?="'$a->org_label'"?>,
								y: <?=$a->total_ip?>
								
							}
						<?php
								if($i<count($report)) echo ",";	 $i++;
							}
						?>
					]
				}]
		});
		
	});

	function gotoStateView(vState){
		var vstateView = "<form method='post' id='stateViewForm"+vState+"' action='<?php echo base_url()."dashboard/view/"?>"+ vState +"'>";
		vstateView += "<input type='hidden' name='from_date' value='"+ $("#from_date").val() +"'>";
		vstateView += "<input type='hidden' name='from_time' value='"+ $("#from_time").val() +"'>";
		vstateView += "<input type='hidden' name='to_date' value='"+ $("#to_date").val() +"'>";
		vstateView += "<input type='hidden' name='to_time' value='"+ $("#to_time").val() +"'>";
		vstateView += "</form>";
		$("body").append(vstateView);
		$("#stateViewForm"+vState).submit();
			
	}
	</script>
	

























































































































