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

	Highcharts.chart('callerTypeBargraph', {
		chart : {type:'column'},
		title: false,
		xAxis: {
			categories: ['Calls','New Patient','Attendant','Revisit Patient','General','Helpdesk','Doctor','Nurse'],
		},
		yAxis: {
			min: 0, 
		},
		plotOptions: {bar: { dataLabels: { enabled: true } } },
		legend: {enabled:false},
		credits: {enabled:false},
		series: [{ name: 'Count', colorByPoint: true,
			data: [<?php $i=1;foreach($caller_type_report as $a) { echo "{ name: '$a->caller_type', y: $a->count }"; if($i<count($caller_type_report)) echo " ,"; $i++; }?>]
		}]
	});
	
	});
	</script>
<div class="row" style="position:relative;">
<?php echo form_open('dashboard/caller_type_report/',array('role'=>'form','class'=>'form-custom')); ?>
	<div class="col-md-12">
			<span style="font-size:24px;font-weight:bold"><span class="flaticon-telephone-line-24-hours-service"></span> Helpline - Caller Type <br/>
			<div class="col-md-3">
				<select name="helpline_id" class="form-control" style="width:100%">
					<option value="">Helpline</option>
					<?php foreach($helpline as $line){ ?>
						<option value="<?php echo $line->helpline_id;?>"
						<?php if($this->input->post('helpline_id') == $line->helpline_id) echo " selected "; ?>
						><?php echo $line->helpline.' - '.$line->note;?></option>
					<?php } ?>
				</select></span>
			</div>
			<div class="col-md-3">
				<select name="call_direction" class="form-control" style="width:100%">
						<option value="">Call Direction</option>
						<option <?php if($this->input->post('call_direction') == "incoming") echo " selected "; ?> value="incoming">Incoming calls</option>
						<option <?php if($this->input->post('call_direction') == "outbound-dial") echo " selected "; ?> value="outbound-dial">Outgoing calls</option>
				</select>
			</div>
			<div class="col-md-3">
				<select name="call_type" class="form-control" style="width:100%">
						<option value="">Call Type</option>
						<option <?php if($this->input->post('call_type') == "completed") echo " selected "; ?> value="completed">Completed</option>
						<option <?php if($this->input->post('call_type') == "client-hangup") echo " selected "; ?> value="client-hangup">Client Hangup</option>
						<option <?php if($this->input->post('call_type') == "voicemail") echo " selected "; ?> value="voicemail">Voicemail</option>
						<option <?php if($this->input->post('call_type') == "incomplete") echo " selected "; ?> value="incomplete">Incomplete</option>
						<option <?php if($this->input->post('call_type') == "call-attempt") echo " selected "; ?> value="call-attempt">Call Attempt</option>
				</select>
			</div>
			<div class="col-md-3">
				<select name="hospital" style="width:100%" class="form-control">
					<option value="">Hospital</option>
					<?php foreach($all_hospitals as $hosp){ ?>
						<option value="<?php echo $hosp->hospital_id;?>"
						<?php if($this->input->post('hospital') == $hosp->hospital_id) echo " selected "; ?>
						><?php echo $hosp->hospital;?></option>
					<?php } ?>
				</select>
			</div>
			<br>
			</row>
			<?php
			if($this->input->post('from_date')) $from_date = date("d-M-Y",strtotime($this->input->post('from_date'))); else $from_date = date("d-M-Y");
			if($this->input->post('to_date')) $to_date = date("d-M-Y",strtotime($this->input->post('to_date'))); else $to_date = date("d-M-Y");
			?>
		<div class="row">
			<div class="col-md-12" style="padding-top:10px;">		
				<div class="col-md-3">
					<div style="position:relative;display:inline;width:100%!important;">
						<input type="text" class="date form-control" name="from_date" class="form-control" style="width:100%!important;" value="<?php echo $from_date;?>" />
					</div>
				</div>
				<div class="col-md-3">
					<div  style="position:relative;display:inline;">
						<input type="text" class="date form-control" name="to_date" class="form-control" style="width:100%!important;" value="<?php echo $to_date;?>" />
					</div>
				</div>
			    <div class="col-md-3" >
					<select name="district" style="width:100%" class="form-control">
						<option value="">District</option>
						
						<?php foreach($hospital_districts as $district){  ?>
							<option value="<?php echo $district->district;?>"
							<?php if($this->input->post('district') == $district->district) echo " selected "; ?>
							><?php echo $district->district;?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-3" >
					<select name="call_category" style="width:100%" class="form-control">
						<option value="">Category</option>
						<?php foreach($call_category as $cc){ ?>
							<option value="<?php echo $cc->call_category_id;?>"
							<?php if($this->input->post('call_category') == $cc->call_category_id) echo " selected "; ?>
							><?php echo $cc->call_category;?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-3" style="padding-top:10px;">
					<select name="caller_type" style="width:100%" class="form-control">
						<option value="">Caller</option>
						<?php foreach($caller_type as $ct){ ?>
							<option value="<?php echo $ct->caller_type_id;?>"
							<?php if($this->input->post('caller_type') == $ct->caller_type_id) echo " selected "; ?>
							><?php echo $ct->caller_type;?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-3" style="padding-top:10px;">
					<select name="visit_type" style="width:100%" class="form-control">
						<option value="">Visit Type</option>
							<option value="OP"
							<?php if($this->input->post('visit_type') == "OP") echo " selected "; ?>
							>OP</option>
							<option value="IP"
							<?php if($this->input->post('visit_type') == "IP") echo " selected "; ?>
							>IP</option>
					</select>
				</div>
				<div class="col-md-3" style="padding-top:10px;">
					<input type="submit" name="submit" value="Go" class="btn btn-primary btn-sm" />
				</div><br/>
				</form>
				<br/><br/>
		</div>
		</div>
	</div>	
    <br/>
	
	<div class="row"><!-- this section displays the dashboard panels -->
	    <div class="col-md-6">
			<div class="panel panel-default">
			    <div class="panel panel-heading">
				    <h4><i class="fa fa-user" aria-hidden="true"></i>&nbsp Caller</h4>
    			</div>
	    		<div class="panel-body" style="margin-left:3%;">
		        	<div id="callerType" style=""></div>
			    </div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel panel-heading">
					<h4><i class="fa fa-user" aria-hidden="true"></i>&nbsp Caller</h4>
				</div>
				<div class="panel-body">
					<div id="callerTypeBargraph" >
					</div>
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
