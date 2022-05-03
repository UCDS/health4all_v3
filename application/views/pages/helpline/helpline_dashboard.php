	<link rel="stylesheet"  type="text/css" href="<?php echo base_url();?>assets/css/bootstrap_datetimepicker.css"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/flaticon.css" >
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/flaticon2.css" >

	<script type="text/javascript" src="<?php echo base_url();?>assets/js/moment.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/highcharts.js"></script>

	<style>
		.panel-body { padding-top:0px; }

	</style>

	<?php
		$total=0;
		foreach($hospital_report as $h){
			$total+=$h->count;
		}
		$d_array = array();
		$default_time = strtotime("00:00:00");
		$total_time=0;
		foreach($duration as $d){
			$d_array[]= strtotime($d->dial_call_duration)-$default_time;
			$total_time += strtotime($d->dial_call_duration)-$default_time;
		}

		$average = calculate_average($d_array);
		$median = calculate_median($d_array);
	?>
	<script>
	$(function(){
		$(".date").datetimepicker({
			format : "D-MMM-YYYY"
		});

	Highcharts.chart('hospitalChart', {
		chart : {type:'bar'},
		title: false,
		xAxis: {
			categories: [<?php $i=1;foreach($hospital_report as $a) { echo "'".$a->hospital;if($i<count($hospital_report)) echo "' ,"; else echo "'"; $i++; }?>],
		},
		yAxis: {
			min: 0, title: { text: 'Calls', align: 'high' }, labels: { overflow: 'justify' }
		},
		plotOptions: {bar: { dataLabels: { enabled: true } } },
		legend: {enabled:false},
		credits: {enabled:false},
		series: [{ name: 'Calls', colorByPoint: true,
			data: [<?php $i=1;foreach($hospital_report as $a) { echo $a->count;if($i<count($hospital_report)) echo " ,"; $i++; }?>]
		}]
		<?php
			$total_hospitals=0;
			foreach($hospital_report as $a){
				$total_hospitals +=$a->count;
			}
		?>
	});
	
	Highcharts.chart('districtChart', {
		chart : {type:'bar'},
		title: false,
		xAxis: {
			categories: [<?php $i=1;foreach($district_report as $a) { echo "'".$a->district;if($i<count($district_report)) echo "' ,"; else echo "'"; $i++; }?>],
		},
		yAxis: {
			min: 0, title: { text: 'Calls', align: 'high' }, labels: { overflow: 'justify' }
		},
		plotOptions: {bar: { dataLabels: { enabled: true } } },
		legend: {enabled:false},
		credits: {enabled:false},
		series: [{ name: 'Calls', colorByPoint: true,
			data: [<?php $i=1;foreach($district_report as $a) { echo $a->count;if($i<count($district_report)) echo " ,"; $i++; }?>]
		}]
	});

	Highcharts.chart('durationChart', {
		chart : {type:'column'},
		title: false,
		xAxis: {
			categories: ['Average','Median'],
		},
		yAxis: {
			min: 0, title: { text: 'Time (in seconds)', align: 'high' }, labels: { overflow: 'justify' }
		},
		plotOptions: {bar: { dataLabels: { enabled: true } } },
		legend: {enabled:false},
		credits: {enabled:false},
		series: [{ name: 'Time', colorByPoint: true,
			data: [<?php echo $average;?>, <?php echo $median;?>]
		}]
	});

	var pie_chart = {
		plotBackgroundColor: null,
		plotBorderWidth: null,
		plotShadow: false,
		type: 'pie'
	};
	var pie_credits = {enabled: false};
	var pie_tooltip = {
			pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>, Count: <b>{point.y:>1f}</b>'
	};
	var pie_plotOptions= {
		pie: {
			allowPointSelect: true,
			cursor: 'pointer',
			showInLegend: true,
			dataLabels: {
				enabled: false,
				format: '<b>{point.name}</b>: {point.percentage:.1f} %',
				style: {
					color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
				},
				distance: 0
			}
		}
	};
	pie_legend= {
		align: 'left',
		layout: 'horizontal',
		verticalAlign: 'bottom',
		floating:false,
		itemDistance:10,
		y:10,
		reversed:true
	};

	Highcharts.chart('callCategory', {
		chart: pie_chart,
		credits: pie_credits,
		title: false,
		tooltip: pie_tooltip,
		plotOptions: pie_plotOptions,
		legend: pie_legend,
		series: [{
			name: 'Calls',
			colorByPoint: true,
			data: [<?php $i=1;foreach($call_category_report as $a) { echo "{ name: '$a->call_category', y: $a->count }"; if($i<count($call_category_report)) echo " ,"; $i++; }?>]
		}]
	});
	
	Highcharts.chart('callerType', {
		chart: pie_chart,
		credits: pie_credits,
		title: false,
		tooltip: pie_tooltip,
		plotOptions: pie_plotOptions,
		legend: pie_legend,
		series: [{
			name: 'Calls',
			colorByPoint: true,
			data: [<?php $i=1;foreach($caller_type_report as $a) { echo "{ name: '$a->caller_type', y: $a->count }"; if($i<count($caller_type_report)) echo " ,"; $i++; }?>]
		}]
	});
	
	Highcharts.chart('callType', {
		chart: {plotBackgroundColor: null,plotBorderWidth: 0,plotShadow: false},
		credits: pie_credits,
		title: {text: '<?php echo $total_hospitals; ?> Calls/<br><?php echo $customer_distinct_report[0]->count; ?> Customers', align: 'center',     verticalAlign: 'middle', y: 60},
		tooltip: pie_tooltip,
		plotOptions: {pie: {dataLabels: {enabled: true, distance: -50,
                style: {fontWeight: 'bold', color: 'white'}},
            startAngle: -90, endAngle: 90,center: ['50%', '75%'],size: '130%'}
                    },
		legend: pie_legend,
		series: [{
			type: 'pie',
			name: 'Calls',
			innerSize: '50%',
			colorByPoint: true,
			data: [<?php $i=1;foreach($call_type_report as $a) { echo "{ name: '$a->direction', y: $a->count }"; if($i<count($call_type_report)) echo " ,"; $i++; }?>]
		}]
	});
	
	Highcharts.chart('callTypeIn', {
		chart: {plotBackgroundColor: null,plotBorderWidth: 0,plotShadow: false},
		credits: pie_credits,
		title: {text: '<?php
			$total_incoming=0;
			foreach($call_type_in_report as $a){$total_incoming +=$a->count;}
			echo $total_incoming;?><br>Calls', align: 'center',     verticalAlign: 'middle', y: 60},
		tooltip: pie_tooltip,
		plotOptions: {pie: {dataLabels: {enabled: true, distance: -50,
                style: {fontWeight: 'bold', color: 'white'}},
            startAngle: -90, endAngle: 90,center: ['50%', '75%'],size: '130%'}
                    },
		legend: pie_legend,
		series: [{
			type: 'pie',
			name: 'Calls',
			innerSize: '50%',
			colorByPoint: true,
			data: [<?php $i=1;foreach($call_type_in_report as $a) { echo "{ name: '$a->call_type', y: $a->count }"; if($i<count($call_type_in_report)) echo " ,"; $i++; }?>]
		}]
	});

    Highcharts.chart('callTypeOut', {
		chart: {plotBackgroundColor: null,plotBorderWidth: 0,plotShadow: false},
		credits: pie_credits,
		title: {text: '<?php
			$total_outbound=0;
			foreach($call_type_out_report as $a){$total_outbound +=$a->count;}
			echo $total_outbound;?><br>Calls', align: 'center',     verticalAlign: 'middle', y: 60},
		tooltip: pie_tooltip,
		plotOptions: {pie: {dataLabels: {enabled: true, distance: -50,
                style: {fontWeight: 'bold', color: 'white'}},
            startAngle: -90, endAngle: 90,center: ['50%', '75%'],size: '130%'}
                    },
		legend: pie_legend,
		series: [{
			type: 'pie',
			name: 'Calls',
			innerSize: '50%',
			colorByPoint: true,
			data: [<?php $i=1;foreach($call_type_out_report as $a) { echo "{ name: '$a->call_type', y: $a->count }"; if($i<count($call_type_out_report)) echo " ,"; $i++; }?>]
		}]
	});
	
	Highcharts.chart('volunteerChart', {
		chart : {type:'bar'},
		title: false,
		xAxis: {
			categories: [<?php $i=1;foreach($volunteer_report as $a) { echo "'".$a->short_name;if($i<count($volunteer_report)) echo "' ,"; else echo "'"; $i++; }?>],
		},
		yAxis: {
			min: 0, title: { text: 'Calls', align: 'high' }, labels: { overflow: 'justify' }
		},
		plotOptions: {bar: { dataLabels: { enabled: true } } },
		legend: {enabled:false},
		credits: {enabled:false},
		series: [{ name: 'Calls', colorByPoint: true,
			data: [<?php $i=1;foreach($volunteer_report as $a) { echo $a->count;if($i<count($volunteer_report)) echo " ,"; $i++; }?>]
		}]
	});
	
	Highcharts.chart('op_ip', {
		chart: pie_chart,
		credits: pie_credits,
		title: false,
		tooltip: pie_tooltip,
		plotOptions: pie_plotOptions,
		legend: pie_legend,
		series: [{
			name: 'Calls',
			colorByPoint: true,
			data: [<?php $i=1;foreach($op_ip_report as $a) { echo "{ name: '$a->ip_op', y: $a->count }"; if($i<count($op_ip_report)) echo " ,"; $i++; }?>]
		}]
	});
	
	Highcharts.chart('to_number', {
		chart: pie_chart,
		credits: pie_credits,
		title: false,
		tooltip: pie_tooltip,
		plotOptions: pie_plotOptions,
		legend: pie_legend,
		series: [{
			name: 'Calls',
			colorByPoint: true,
			data: [<?php $i=1;foreach($to_number_report as $a) { echo "{ name: '$a->helpline_name', y: $a->count }"; if($i<count($to_number_report)) echo " ,"; $i++; }?>]
		}]
	});
	
	
	});
	</script>
<div class="row" style="position:relative;">
<?php echo form_open('dashboard/helpline/',array('role'=>'form','class'=>'form-custom')); ?>
	<div class="row">
			<span style="font-size:24px;font-weight:bold"><span class="flaticon-telephone-line-24-hours-service"></span> Helpline <select name="helpline_id" style="width:300px" class="form-control">
				<option value="">Helpline</option>
				<?php foreach($helpline as $line){ ?>
					<option value="<?php echo $line->helpline_id;?>"
					<?php if($this->input->post('helpline_id') == $line->helpline_id) echo " selected "; ?>
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
			</row>
			<?php
			if($this->input->post('from_date')) $from_date = date("d-M-Y",strtotime($this->input->post('from_date'))); else $from_date = date("d-M-Y");
			if($this->input->post('to_date')) $to_date = date("d-M-Y",strtotime($this->input->post('to_date'))); else $to_date = date("d-M-Y");
			?>
		<div class="row">
		<div class="col-md-12">			
			<div style="position:relative;display:inline;">
			<input type="text" class="date form-control" name="from_date" class="form-control" value="<?php echo $from_date;?>" />
			</div>
			<div  style="position:relative;display:inline;">
			<input type="text" class="date form-control" name="to_date" class="form-control" value="<?php echo $to_date;?>" />
			</div>
			<select name="hospital" style="width:100px" class="form-control">
				<option value="">Hospital</option>
				<?php foreach($all_hospitals as $hosp){ ?>
					<option value="<?php echo $hosp->hospital_id;?>"
					<?php if($this->input->post('hospital') == $hosp->hospital_id) echo " selected "; ?>
					><?php echo $hosp->hospital;?></option>
				<?php } ?>
			</select>
			<select name="district" style="width:100px" class="form-control">
				<option value="">District</option>
				<?php foreach($hospital_districts as $district){ ?>
					<option value="<?php echo $district->district;?>"
					<?php if($this->input->post('district') == $district->district) echo " selected "; ?>
					><?php echo $district->district;?></option>
				<?php } ?>
			</select>
			<select name="call_category" style="width:100px" class="form-control">
				<option value="">Category</option>
				<?php foreach($call_category as $cc){ ?>
					<option value="<?php echo $cc->call_category_id;?>"
					<?php if($this->input->post('call_category') == $cc->call_category_id) echo " selected "; ?>
					><?php echo $cc->call_category;?></option>
				<?php } ?>
			</select>
			<select name="caller_type" style="width:100px" class="form-control">
				<option value="">Caller</option>
				<?php foreach($caller_type as $ct){ ?>
					<option value="<?php echo $ct->caller_type_id;?>"
					<?php if($this->input->post('caller_type') == $ct->caller_type_id) echo " selected "; ?>
					><?php echo $ct->caller_type;?></option>
				<?php } ?>
			</select>
			<select name="visit_type" style="width:100px" class="form-control">
				<option value="">Visit Type</option>
					<option value="OP"
					<?php if($this->input->post('visit_type') == "OP") echo " selected "; ?>
					>OP</option>
					<option value="IP"
					<?php if($this->input->post('visit_type') == "IP") echo " selected "; ?>
					>IP</option>
			</select>
			<input type="submit" name="submit" value="Go" class="btn btn-primary btn-sm" />
			<a href="<?php echo base_url()."dashboard/helpline_trend/";?>" class="btn btn-warning btn-sm"><i class="fa fa-line-chart"></i> Trends</a>
			</form>
			<br />
		</div>
		</div>
	</div>	
    
	<div class="row"><!-- this section displays the dashboard panels -->
		
		<div class="col-md-4">
			<div class="panel panel-default">
			    <div class="panel panel-heading">
				    <h4><i class="flaticon-old-telephone-ringing"  aria-hidden="true"></i>&nbsp Calls</h4>
			    </div>
			    <div class="panel-body">
			        <div id="callType" style="width:300px;height:250px"></div>
			    </div>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="panel panel-default">
			    <div class="panel panel-heading">
				    <h4><i class="flaticon-old-telephone-ringing"  aria-hidden="true"></i>&nbsp Incoming</h4>
			    </div>
			    <div class="panel-body">
			        <div id="callTypeIn" style="width:300px;height:250px"></div>
			    </div>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="panel panel-default">
			    <div class="panel panel-heading">
				    <h4><i class="flaticon-old-telephone-ringing"  aria-hidden="true"></i>&nbsp Outbound</h4>
			    </div>
			    <div class="panel-body">
			        <div id="callTypeOut" style="width:300px;height:250px"></div>
			    </div>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="panel panel-default">
		    	<div class="panel panel-heading">
			    	<h4><i class="fa flaticon-telephone-of-old-design" aria-hidden="true"></i>&nbsp Helpline</h4>
    			</div>
		    	<div class="panel-body">
	    	    	<div id="to_number" style="width:300px;height:250px"></div>
			    </div>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="panel panel-default">
			    <div class="panel panel-heading">
				    <h4><i class="fa fa-list-alt" aria-hidden="true"></i>&nbsp Category</h4>
    			</div>
			    <div class="panel-body">
	    		    <div id="callCategory" style="width:300px;height:250px"></div>
			    </div>
			</div>
		</div>
	    
	    <div class="col-md-4">
			<div class="panel panel-default">
			    <div class="panel panel-heading">
				    <h4><i class="fa fa-user" aria-hidden="true"></i>&nbsp Caller</h4>
    			</div>
	    		<div class="panel-body">
		        	<div id="callerType" style="width:300px;height:250px"></div>
			    </div>
			</div>
		</div>
	</div>
	<div class="row">		
	<!-- had to add extra row as panel was left aligned in new line. To test if this additional row can be avoided. Guna -->
	    
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel panel-heading">
					<h4><i class="fa fa-hospital-o fa-1x "  aria-hidden="true"></i>&nbsp Hospital</h4>
				</div>
				<div class="panel-body">
					<div id="hospitalChart" style="width:300px;height:250px"></div>
				</div>
			</div>
		</div>
	    
	    <div class="col-md-4">
			<div class="panel panel-default">
			    <div class="panel panel-heading">
				    <h4><i class="fa fa-stethoscope" aria-hidden="true"></i>&nbsp Patient Type</h4>
    			</div>
		    	<div class="panel-body">
	    	    	<div id="op_ip" style="width:300px;height:250px"></div>
			    </div>
			</div>
		</div>
		
		<div class="col-md-4">
			<div class="panel panel-default">
		    	<div class="panel panel-heading">
			    	<h4><i class="fa fa-clock-o fa-1.5x" aria-hidden="true"></i>&nbsp Call Duration
				    <span style="font-size:15px; float:right;">Total time: <?php echo (int)($total_time/60); ?>mins <?php echo (int)($total_time%60); ?>sec</span></h4>
			    </div>
			    <div class="panel-body">
			        <div id="durationChart" style="width:300px;height:250px">
			        </div>
			    </div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel panel-heading">
					<h4><i class="fa flaticon-map-localization" aria-hidden="true"></i>&nbsp District</h4>
				</div>
				<div class="panel-body">
					<div id="districtChart" style="width:300px;height:245px"></div>
				</div>
			</div>
		</div>

		<div class="col-md-4">
			<div class="panel panel-default">
			    <div class="panel panel-heading">
				    <h4><i class="fa flaticon-call-center-worker-with-headset" aria-hidden="true"></i>&nbsp Receiver</h4>
			    </div>
			    <div class="panel-body">
			        <div id="volunteerChart" style="width:300px;height:250px"></div>
			    </div>
			</div>
		</div>
	</div>
	
</div>


<?php
function calculate_median($arr) {
    $count = count($arr); //total numbers in array
    $middleval = floor(($count-1)/2); // find the middle value, or the lowest middle value
    if($count % 2) { // odd number, middle is the median
        $median = $arr[$middleval];
    } else { // even number, calculate avg of 2 medians
        $low = $arr[$middleval];
        $high = $arr[$middleval+1];
        $median = (($low+$high)/2);
    }
    return $median;
}

function calculate_average($arr) {
	$total = 0;
    $count = count($arr); //total numbers in array
    foreach ($arr as $value) {
        $total = $total + $value; // total value of array numbers
    }
    $average = ($total/$count); // get average value
    return $average;
}

?>
