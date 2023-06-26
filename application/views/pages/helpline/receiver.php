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
	
	
	
	});
	</script>
<div class="row" style="position:relative;">
<?php echo form_open('dashboard/receiver/',array('role'=>'form','class'=>'form-custom')); ?>
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
			
			</form>
			<br />
		</div>
		</div>
	</div>	
    
	<div class="row"><!-- this section displays the dashboard panels -->
		<br>
		<div >
			<div class="panel panel-default">
			    <div class="panel panel-heading">
				    <h4><i class="fa flaticon-call-center-worker-with-headset" aria-hidden="true"></i>&nbsp Receiver</h4>
			    </div>
			    <div class="panel-body">
			        <div id="volunteerChart" style="height:800px"></div>
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
