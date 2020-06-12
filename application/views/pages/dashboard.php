	<link rel="stylesheet"  type="text/css" href="<?php echo base_url();?>assets/css/bootstrap_datetimepicker.css"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css"> 
	<script src="<?php echo base_url();?>assets/js/highcharts.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/ajaxcalls.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/moment.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
	
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/Chart.js"></script>
	<style>  /* style for the loader gif  */
		.BusyLoopHide{
			display: none;
		}
		.BusyLoopShow{
			display: initial;
		}
		.PageLoadImg{
			position: fixed;
			background-color: black;
			opacity: 0.5;
			top:0;
			height: 100%;
			width: 100%;
			z-index: 9999;
		}
		.LoadingImg{
			width : 100%;
			top : 45%;
			position: fixed;
			opacity: 1;
			z-index: 9999;
		}
		.LoadingImg>div{
			margin:0 auto; width: 100px;
		}
	
	</style>

		<?php
        	$from_time=0;$to_time=0;
        if($this->input->post('from_time')) $from_time=date("H:i",strtotime($this->input->post('from_time'))); else $from_time = date("00:00");
        if($this->input->post('to_time')) $to_time=date("H:i",strtotime($this->input->post('to_time'))); else $to_time = date("23:59");
	?>


		<input type="hidden" name="HospitalType" id="HospitalType"/><!-- to display the loader gif-->
		<div class="BusyLoopMain PageLoadImg BusyLoopHide">
		</div>
		<div class="BusyLoopMain LoadingImg BusyLoopHide">
			<div>
			  <img width="100px" height="100px" src="<?php echo base_url();?>assets/images/loader.gif" />
			</div>
		</div>
			<div  class="container"  id="Hospitaltable" style="display:none;">
				
		
				<!--table and charts hospital type wise CHC,AH,DH -->
				<div class="row" >  
					<div class="col-md-6">	
						<div class="panel panel-info">
							<div class="panel-heading">
								<h5  id="HospitalTypeLabel" style="display:inline;font-weight: bold;"></h5>
								<small id = "report_date"></small>
								<input type="button" style="float:right; margin-botton:5px;" class="btn btn-sm btn-primary" value="Back" name="Back" onClick="ShowMainStats();"/>
						
							</div>
							<div class="panel-body">
								<table class="table table-striped" id="HospitalsTypewise">
									<thead>
										<tr>
											<th></th>
											<th>Hospitals</th>
											<th colspan="3" class="text-center" style="color:#ffa366;">OP</th>
											<th class="text-right" style="color:#b7db4c;">IP</th>
										</tr>
										<tr>
											<th></th>
											<th></th>
											<th class="text-right">New</th>
											<th class="text-right">Repeat</th>
											<th class="text-right">OP Total</th>
										</tr>
										<tr>
								<!--			<th>#</th>
											<th>Total</th>
											<th class="text-right"><?php echo number_format($total_op - $total_repeat_op);?></th>
											<th class="text-right"><?php echo number_format($total_repeat_op);?></th>
											<th class="text-right"><?php echo number_format($total_op);?></th>
											<th class="text-right"><?php echo number_format($total_ip);?></th> -->
										</tr>
									</thead>
									<tbody>
							<!--		<?php 
									$i=1;
									foreach($report[1] as $r) {
									?>
											<tr>
												<td><?php echo $i++;?></td>
												<td onClick="getHospitalSubStats('<?=$r->type4;?>')" style="cursor:pointer; color:#0000FF; text-decoration:underline;"><?php echo $r->type4;?></td>
												<td class="text-right"><?php echo number_format($r->total_op - $r->repeat_op);?></td>
												<td class="text-right"><?php echo number_format($r->repeat_op);?></td>
												<td class="text-right"><?php echo number_format($r->total_op);?></td>
												<td class="text-right"><?php echo number_format($r->total_ip);?></td>
											</tr>
									<?php } ?>   -->
									</tbody>   
								</table>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-default ">
							<div class="panel-body">
								<canvas id="TypehospitalChart" width="200" height="150"></canvas>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-body">
								<div id="OPHospPie" style="min-width: 310px; height: 400px; max-width: 600px;margin:0 auto"></div> 
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-body">
								<div id="IPHospPie" style="min-width: 310px; height: 400px; max-width: 600px;margin:0 auto"></div> 
							</div>
						</div>
					</div>
				</div>		
			</div><!--hospitals table end-->
			<div id="HospitalTypeWisetable" class="container">
				<?php
					$total_op=0;
					$total_repeat_op=0;
					$total_ip=0;
						
					foreach($report[1] as $r) { 
					//	$total_op=0;
					//	$total_repeat_op=0;
					//	$total_ip=0;
					//	foreach($report[1] as $r) {
							$total_op+=$r->total_op;
							$total_ip+=$r->total_ip;
							$total_repeat_op+=$r->repeat_op;
							
					//	}
					}
				?>
				<!--table and charts hospital type wise -->
				<div class="row">  
					<div class="col-md-6">	
						<div class="panel panel-info">
							<div class="panel-heading">
								<h5 style="display:inline">
									Report as on <span id="current_date"><?php echo date("d-M-Y g:iA");?></span>
								</h5>
								<span class="text-right" style="display:inline; text-align:left;">	
									<?php echo form_open("dashboard/view/".$organization,array("class"=>"form-custom"));?>
									<input type="hidden" name="organization" id="organization" value="<?=$organization?>">
									<label style="padding-left:15px;">From: </label>
									<input type="text" class="date form-control" style="width:110px" value="<?php if($this->input->post('from_date')) echo date("d-M-Y",strtotime($this->input->post('from_date'))); else echo date("d-M-Y");?>" name="from_date" id="from_date" />
									<input  class="form-control" style = "background-color:#EEEEEE;" type="text" value="<?php echo date("h:i A",strtotime($from_time)); ?>" name="from_time" id="from_time" size="7px"/>
									<br/>
									<label style="padding-left:34px;">To: </label>
									<input type="text" class="date form-control" style="width:110px; padding-top:5px;" value="<?php if($this->input->post('to_date')) echo date("d-M-Y",strtotime($this->input->post('to_date'))); else echo date("d-M-Y");?>" name="to_date" id="to_date" />
									<input class="form-control" style = "background-color:#EEEEEE;" type="text" value="<?php echo date("h:i A",strtotime($to_time)); ?>" name="to_time" id="to_time" size="7px" />
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
											<th colspan="3" class="text-center" style="color:#ffa366;"><b>OP</b></th>
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
												foreach($report[1] as $r){
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
									$j=0;

									foreach($report[1] as $r) {
									?>
										<tr>
											<td><?php echo $i++;?></td>
											<td onClick="getHospitalSubStats('<?=$r->type4 ? $r->type4 : "Others";?>')" style="cursor:pointer; color:#0000FF; text-decoration:underline;">
												<?php echo $r->type4 ? $r->type4 : "Others";?>
											</td>
											<td class="text-center"><?= $r->hospital_count; ?></td>
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
						<div class="panel panel-default ">
							<div class="panel-body">
								<canvas id="hospitalChart" width="200" height="150"></canvas>
							</div>
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
			<div class="container">
				<div class="row">
					<div class="col-md-6">
						<div class="panel-body" style="text-align:center;">
							<button class="btn btn-primary"  style="width:148px;" onclick="getDistrictStats();">Toggle District</button>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel-body" style="text-align:center;">
							<button class="btn btn-primary"  onclick="getDepartmentStats();">Toggle Department</button>
						</div>
					</div>
				</div>
			</div><!--hospitals type wise table end-->
			<!-- table and panel for bar and pie chart-->
			<div id="Department" class="container" style="display:none;">
				<div class="row " style="padding-top:25px;">  
					<div class="col-md-6">	
						<div class="panel panel-info">
							<div class="panel-heading">
								<h5 style="display:inline;"><center>Report by Department</center> </h5>

							<!--	<span class="text-right" style="display:inline">	
									<?php echo form_open("dashboard/view/".$organization,array("class"=>"form-custom"));?>
									<input type="text" class="date form-control" style="width:150px" value="<?php if($this->input->post('date')) echo date("d-M-Y",strtotime($this->input->post('date'))); else echo date("d-M-Y");?>" name="departmentdate" id="departmentdate" />
									<input type="button" class="btn btn-sm btn-primary" value="Submit" name="submit"onClick="getDepartmentStats(true);"/>
									<?php echo form_close(); ?>
								</span>-->
							</div>
							<div class="panel-body">
								<table class="table table-striped" id="departmentwise">
									<thead>
										<tr>
											<th></th>
											<th></th>
											<th colspan="3" class="text-center" style="color:#ffa366;"><b>OP</b></th>
											<th class="text-right" style="color:#b7db4c;"><b>IP</b></th>
										</tr>
										<tr>
											<th></th>
											<th>Department</th>
											<th class="text-right">New</th>
											<th class="text-right">Repeat</th>
											<th class="text-right">OP Total</th>
										</tr>
									</thead>
									<tbody>
									
									</tbody>
								</table>
							</div>
						</div>
					</div>		
					<div class="col-md-6" > <!--horizontal bar chart with respect to  departments -->
						<div class="panel panel-default">
							<div class="panel-body">
								<canvas id="hospitalChart1" width="200" height="250"></canvas>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6"><!-- pie chart of out-patients with respect to departments -->
						<div class="panel panel-default">
							<div class="panel-body">
								<div id="OPDeptPie" style="min-width: 310px; height: 400px; max-width: 600px;margin:0 auto"></div>
							</div>
						</div>
					</div>
					<div class="col-md-6"><!-- pie chart of in-patients with respect to departments -->
						<div class="panel panel-default">
							<div class="panel-body">
								<div id="IPDeptPie" style="min-width: 310px; height: 400px; max-width: 600px;margin:0 auto"></div>
							</div>
						</div>
					</div>
				</div>
			</div><!--departments tables end-->
				<!-- table and panels for bar and pie charts wrt District -->
			<div id="District" class="container" style="display:none;">
				<div class="row"  style="padding-top:25px;">  
					<div class="col-md-6">	
						<div class="panel panel-info">
							<div class="panel-heading">
								<h5 style="display:inline"><center>Report By District</center></h5>
								
							<!--	<span class="text-right" style="display:inline">	
									<?php echo form_open("dashboard/view/".$organization,array("class"=>"form-custom"));?>
									<input type="text" class="date form-control" style="width:150px" value="<?php if($this->input->post('date')) echo date("d-M-Y",strtotime($this->input->post('date'))); else echo date("d-M-Y");?>" name="districtdate" id="districtdate"/>
									<input type="button" class="btn btn-sm btn-primary" value="Submit" name="submit" onClick="getDistrictStats(true);" />
									<?php form_close(); ?>
								</span>-->
							</div>
							<div class="panel-body">
								<table class="table table-striped" id="districtwise">
									<thead>
										<tr>
											<th></th>
											<th></th>
											<th colspan="3" class="text-center" style="color:#ffa366;"><b>OP</b></th>
											<th class="text-right" style="color:#b7db4c;"><b>IP</b></th>
										</tr>
										<tr>
											<th></th>
											<th>District</th>
											<th class="text-right">New</th>
											<th class="text-right">Repeat</th>
											<th class="text-right">OP Total</th>
											
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							</div>
						</div>
					</div>		
					<div class="col-md-6"> <!--horizontal bar chart with respect to  departments -->
						<div class="panel panel-default">
							<div class="panel-body">
								<canvas id="hospitalChart2" width="200" height="250"></canvas>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6"><!-- pie chart of out-patients with respect to departments -->
						<div class="panel panel-default">
							<div class="panel-body">
								<div id="OPDistPie" style="min-width: 310px; height: 400px; max-width: 600px;margin:0 auto"></div>
							</div>
						</div>
					</div>
					<div class="col-md-6"><!-- pie chart of in-patients with respect to departments -->
						<div class="panel panel-default">
							<div class="panel-body">
								<div id="IPDistPie" style="min-width: 310px; height: 400px; max-width: 600px;margin:0 auto"></div>
							</div>
						</div>
					</div>
				</div>
			</div>

<script>
	function ShowMainStats(){
		$("#Hospitaltable").hide();
		$("#HospitalTypeWisetable").show();
		$("#District").hide();
		$("#Department").hide();
		$("#HospitalType").val('');
	}
	$(function(){
		$('#from_time').ptTimeSelect();
		$('#to_time').ptTimeSelect();

		$(".date").datetimepicker({
			format : "D-MMM-YYYY"
		});
		//chart wrt hospital type
		var hospitalctx = $("#hospitalChart");
		var myChart = new Chart(hospitalctx, {
			type: 'horizontalBar',
			data: {
				labels: [<?php $i=1;foreach($report[1] as $a) { echo "'".$a->type4;if($i<count($report[1])) echo "' ,"; else echo "'"; $i++; }?>],
				datasets: [
					{
						type: 'horizontalBar',
						label: 'OP',
						xAxisID : "A",
						backgroundColor: "rgba(255,102,0,0.6)",
						borderColor: "rgba(255,102,0,0.6)",
						data: [<?php $i=1;foreach($report[1] as $a) { echo $a->total_op;if($i<count($report[1])) echo " ,"; $i++; }?>]
					},
					{
						type: 'horizontalBar',
						label: 'IP',
						xAxisID : "A",
						backgroundColor: "rgba(153,204,0, 0.7)",
						borderColor: "rgba(153,204,0, 0.7)",
					data: [<?php $i=1;foreach($report[1] as $a) { echo $a->total_ip;if($i<count($report[1])) echo " ,"; $i++; }?>],
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

			//pie chart wrt hospital type  OP-patient
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
					pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
							foreach($report[1] as $a) {
						?>
							{
								name:<?="'$a->type4'"?>,
								y: <?=$a->total_op?>
								
							}
						<?php
								if($i<count($report[1])) echo ",";	 $i++;
							}
						?>
					]
				}]
		});

		//piechart wrt hospital type  IP-patient
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
					pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
							foreach($report[1] as $a) {
						?>
							{
								name:<?="'$a->type4'"?>,
								y: <?=$a->total_ip?>
								
							}
						<?php
								if($i<count($report[1])) echo ",";	 $i++;
							}
						?>
					]
				}]
		});
		
		// setTimeout(function(){$("#District,#Department").hide()},500);;
	});

 var HospChart;
	function getHospitalSubStats(vType){
		$("#HospitalTypeLabel").text(vType || '');
		$("#report_date").text('Report from '+$("#from_date").val()+' '+$('#from_time').val()+' to '+$("#to_date").val()+' '+$('#to_time').val()+' as on '+$("#current_date").text());
		$(".BusyLoopMain").removeClass("BusyLoopHide").addClass("BusyLoopShow");
		jqueryPostAjaxCall("<?php echo base_url();?>dashboard/hospital/"+$("#organization").val(),{"from_date":$("#from_date").val(),"to_date":$("#to_date").val(),"hospitaltype":vType, "from_time":$("#from_time").val(), "to_time":$("#to_time").val()},function(data){
			$(".BusyLoopMain").removeClass("BusyLoopShow").addClass("BusyLoopHide");

				$("#HospitalsTypewise tbody tr").remove();
					var Total;
					var T_total_op=0;
					var T_total_repeat_op=0;
					var T_total_ip=0;
					$.each(data[1],function(i,v){
						T_total_op += parseInt(v.total_op);
						T_total_repeat_op +=parseInt(v.repeat_op);
						T_total_ip +=parseInt(v.total_ip);

					});
					var vRow = "<tr>";
					vRow += "<th>"+"#"+"</th>";
					vRow += "<th>"+"Total"+"</th>";
					vRow += "<th class='text-right'>"+(T_total_op - T_total_repeat_op);
					vRow += "<th class='text-right'>"+T_total_repeat_op+"</th>";
					vRow += "<th class='text-right'>"+T_total_op+"</th>";
					vRow += "<th class='text-right'>"+T_total_ip+"</th>";
					vRow += "</tr>";
					$("#HospitalsTypewise tbody").append(vRow);
					
					var vHospNames = [];
					var vHospOp = [];
					var vHospIp = [];
					var vHospOpPie = [];
					var vHospIpPie = [];

				
				$.each(data[1], function(i,v){
					vHospNames.push(v.hospital_short_name);
					vHospOp.push(v.total_op); 
					vHospIp.push(v.total_ip);
					vHospOpPie.push({"name":v.hospital_short_name,"y":parseInt(v.total_op)});
					vHospIpPie.push({"name":v.hospital_short_name,"y":parseInt(v.total_ip)}); 

					var vRow = "<tr>";
	
					vRow += "<td>"+ (i+1) +"</td>";
					vRow += "<td>"+v.hospital_short_name+"</td>";
					vRow += "<td class='text-right'>"+(v.total_op - v.repeat_op)+"</td>";
					vRow += "<td class='text-right'>"+v.repeat_op+"</td>";
					vRow += "<td class='text-right'>"+v.total_op+"</td>";
					vRow += "<td class='text-right'>"+v.total_ip+"</td>";
					vRow += "</tr>";
					$("#HospitalsTypewise tbody").append(vRow);				
				});
				$("#Hospitaltable").show();
				$("#HospitalTypeWisetable").hide();
				$("#District").hide();
				$("#Department").hide();
				
				$("#HospitalType").val(vType);
				var ctx = $("#TypehospitalChart");
				
				if(HospChart) HospChart.destroy();
				HospChart = new Chart(ctx, {
					type: 'horizontalBar',
					data: {
						labels: vHospNames,
						datasets: [
							{
								type: 'horizontalBar',
								label: 'OP',
								xAxisID : "A",
								backgroundColor: "rgba(255,102,0,0.6)",
								borderColor: "rgba(255,102,0,0.6)",
								data: vHospOp
							},
							{
								type: 'horizontalBar',
								label: 'IP',
								xAxisID : "A",
								backgroundColor: "rgba(153,204,0, 0.7)",
								borderColor: "rgba(153,204,0, 0.7)",
								data: vHospIp
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
					//pie chart of all hospital of one type  -  OP-patient
			Highcharts.chart('OPHospPie', {
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
						pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
						data: vHospOpPie
					}]
			});

			//pie chart of all hospital of one type  -  IP-patient
			Highcharts.chart('IPHospPie', {
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
						text: 'IP-Patients '
					},
					tooltip: {
						pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
						data: vHospIpPie
					}]
			});


		},{EncodeDataFlag:false})
	}
	
/*	function DeptFunction() {
		var x = document.getElementById('Department');
		if (x.style.display === 'none') {
			x.style.display = 'block';
		} else {
			x.style.display = 'none';
		}
	}*/
var departmentChart;
	function getDepartmentStats(vShow){
		if($('#Department').is(":visible") && !vShow){
			$('#Department').hide();
		}else{
			jqueryPostAjaxCall("<?php echo base_url();?>dashboard/department/"+$("#organization").val(),{"from_date":$("#from_date").val(),
				"to_date":$("#to_date").val(),
				'hospitaltype':$("#HospitalType").val(), "from_time":$("#from_time").val(), "to_time":$("#to_time").val()},function(data){
				
					$('#Department').show();
				

				$("#departmentwise tbody tr").remove();
						var Total;
						var T_total_op=0;
						var T_total_repeat_op=0;
						var T_total_ip=0;
						$.each(data[1],function(i,v){
							T_total_op += parseInt(v.total_op);
							T_total_repeat_op +=parseInt(v.repeat_op);
							T_total_ip +=parseInt(v.total_ip);

						});
						var vRow = "<tr>";
						vRow += "<th>"+"#"+"</th>";
						vRow += "<th>"+"Total"+"</th>";
						vRow += "<th class='text-right'>"+(T_total_op - T_total_repeat_op);
						vRow += "<th class='text-right'>"+T_total_repeat_op+"</th>";
						vRow += "<th class='text-right'>"+T_total_op+"</th>";
						vRow += "<th class='text-right'>"+T_total_ip+"</th>";
						vRow += "</tr>";
						$("#departmentwise tbody").append(vRow);
						var vDepartmentNames = [];
						var vDepartmentOp = [];
						var vDepartmentIp = [];
						var vDepartmentIpPie =[];
						var vDepartmentOpPie = [];

						$.each(data[1], function(i,v){
							vDepartmentOpPie.push({"name":v.department,"y":parseInt(v.total_op)});
							vDepartmentIpPie.push({"name":v.department,"y":parseInt(v.total_ip)});
							vDepartmentNames.push(v.department);
							vDepartmentOp.push(parseInt(v.total_op));
							vDepartmentIp.push(parseInt(v.total_ip));
							var vRow = "<tr>";
			
							vRow += "<td>"+ (i+1) +"</td>";
							vRow += "<td>"+v.department+"</td>";
							vRow += "<td class='text-right'>"+(v.total_op - v.repeat_op)+"</td>";
							vRow += "<td class='text-right'>"+v.repeat_op+"</td>";
							vRow += "<td class='text-right'>"+v.total_op+"</td>";
							vRow += "<td class='text-right'>"+v.total_ip+"</td>";
							vRow += "</tr>";
							$("#departmentwise tbody").append(vRow);				
						});

					
					var ctx = $("#hospitalChart1");
					
					if(departmentChart) departmentChart.destroy();
					departmentChart = new Chart(ctx, {
						type: 'horizontalBar',
						data: {
							labels: vDepartmentNames,
							datasets: [
								{
									type: 'horizontalBar',
									label: 'OP',
									xAxisID : "A",
									backgroundColor: "rgba(255,102,0,0.6)",
									borderColor: "rgba(255,102,0,0.6)",
									data: vDepartmentOp
								},
								{
									type: 'horizontalBar',
									label: 'IP',
									xAxisID : "A",
									backgroundColor: "rgba(153,204,0, 0.7)",
									borderColor: "rgba(153,204,0, 0.7)",
									data: vDepartmentIp
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

					//pie chart wrt department  -  OP-patient
				Highcharts.chart('OPDeptPie', {
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
							text: 'OP-Patients Department Wise'
						},
						tooltip: {
							pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
							data: vDepartmentOpPie
						}]
				});

				//piechart wrt department wise  IP-patient
				Highcharts.chart('IPDeptPie', {
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
							text: 'IP-Patients Department Wise'
						},
						tooltip: {
							pointFormat: '{series.vDepartmentName}: <b>{point.percentage:.1f}%</b>'
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
							data: vDepartmentIpPie
						}]
				});
					$("#District").hide();
			},{EncodeDataFlag:false});
		} 
	}
	var DistrictChart;
	function getDistrictStats(vShow){
		if($('#District').is(":visible") && !vShow){
			$('#District').hide();
		}else{
			jqueryPostAjaxCall("<?php echo base_url();?>dashboard/district/"+$("#organization").val(),{"from_date":$("#from_date").val(),"to_date":$("#to_date").val(),'hospitaltype':$("#HospitalType").val(), "from_time":$("#from_time").val(), "to_time":$("#to_time").val()},function(data){
				console.log(data);
				
					$('#District').show();
				
				$("#districtwise tbody tr").remove();
						var Total;
						var T_total_op=0;
						var T_total_repeat_op=0;
						var T_total_ip=0;
						$.each(data[1],function(i,v){
							T_total_op += parseInt(v.total_op);
							T_total_repeat_op +=parseInt(v.repeat_op);
							T_total_ip +=parseInt(v.total_ip);

						});
						var vRow = "<tr>";
						vRow += "<th>"+"#"+"</th>";
						vRow += "<th>"+"Total"+"</th>";
						vRow += "<th class='text-right'>"+(T_total_op - T_total_repeat_op);
						vRow += "<th class='text-right'>"+T_total_repeat_op+"</th>";
						vRow += "<th class='text-right'>"+T_total_op+"</th>";
						vRow += "<th class='text-right'>"+T_total_ip+"</th>";
						vRow += "</tr>";
						$("#districtwise tbody").append(vRow);
						var vDistNames = [];
						var vDistOp = [];
						var vDistIp = [];
						var vDistOpPie = [];
						var vDistIpPie = [];

						$.each(data[1], function(i,v){
							vDistNames.push(v.district);
							vDistOp.push(parseInt(v.total_op));
							vDistIp.push(parseInt(v.total_ip));
							vDistOpPie.push({"name":v.district,"y":parseInt(v.total_op)});
							vDistIpPie.push({"name":v.district,"y":parseInt(v.total_ip)})

							
							var vRow = "<tr>";
			
							vRow += "<td>"+ (i+1) +"</td>";
							vRow += "<td>"+v.district+"</td>";
							vRow += "<td class='text-right'>"+(v.total_op - v.repeat_op)+"</td>";
							vRow += "<td class='text-right'>"+v.repeat_op+"</td>";
							vRow += "<td class='text-right'>"+v.total_op+"</td>";
							vRow += "<td class='text-right'>"+v.total_ip+"</td>";
							vRow += "</tr>";
							$("#districtwise tbody").append(vRow);				
						});


						var ctx1 = $("#hospitalChart2");

						if(DistrictChart) DistrictChart.destroy();
						
						DistrictChart = new Chart(ctx1, {
							type: 'horizontalBar',
							data: {
								labels: vDistNames,
								datasets: [
									{
										type: 'horizontalBar',
										label: 'OP',
										xAxisID : "A",
										backgroundColor: "rgba(255,102,0,0.6)",
										borderColor: "rgba(255,102,0,0.6)",
										data: vDistOp
									},
									{
										type: 'horizontalBar',
										label: 'IP',
										xAxisID : "A",
										backgroundColor: "rgba(153,204,0, 0.7)",
										borderColor: "rgba(153,204,0, 0.7)",
										data:vDistIp 
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

					//pie chart wrt district wise  OP-patient
				Highcharts.chart('OPDistPie', {
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
							pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
							data: vDistOpPie
						}]
				});
				
				//pie chart wrt district wise  OP-patient
				Highcharts.chart('IPDistPie', {
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
							text: 'IP-Patients'
						},
						tooltip: {
							pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
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
							data:vDistIpPie
						}]
					});


					$('#Department').hide();
			},{EncodeDataFlag:false});
		}
	}
</script>
