<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript">
$(function(){
	$("#from_date").Zebra_DatePicker({
	  disabled_dates : ['* * * *'],
	  enabled_dates: ['1,8,15,22,29 * * *']
	});
	$("#to_date").Zebra_DatePicker({
	  disabled_dates : ['* * * *'],
	  enabled_dates: ['7,14,21,28-31 * * *']
	});
	$("#hospital").on('change',function(){
		var hospital_id=$(this).val();
		$("#area option").hide().attr('disabled',true);
		$("#area option[class="+hospital_id+"]").show().attr('disabled',false);
	});
});
</script>
<div class="col-md-10 col-md-offset-2">
	<?php if(isset($msg)){ ?>
		<div class="alert alert-info"><?php echo $msg;?></div>
	<?php } ?>
	<?php echo validation_errors();?>
	<?php echo form_open('sanitation/view_summary',array('role'=>'form','class'=>'form-custom')); ?>
	<label for="from_date">From Date</label>
	<input class="date form-control" name="from_date" id="from_date" type="text" /> 
	<label for="to_date">To Date</label>
	<input class="date form-control" name="to_date" id="to_date" type="text" /> 
	<input type="submit" class="btn btn-primary btn-md" name="submit" value="Submit" />
	</form>
	<?php if(isset($scores) && count($scores)>0) {
		$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
		$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
		?>
	<div class="panel">Sanitation scores for the period : <b><?php echo $this->input->post('from_date');?></b> to <b><?php echo $this->input->post('to_date');?></b></div>
	<table class="table table-bordered table-hover table-striped">
		<thead>
			<tr>
			<th colspan="4" class="text-center">Summary Report</th>
			</tr>
			<th>#</th>
			<th>Hospital</th>
			<th>Score</th>
			<th>%</th>
		</thead>
	<?php $i=1; foreach($scores as $s){ 
			$total_score=$s->daily_score+$s->weekly_score+$s->fortnightly_score+$s->monthly_score;
			$total=$s->daily_total+$s->weekly_total+$s->fortnightly_total+$s->monthly_total;
			?>
			<tr onclick="$('#select_hospital_<?php echo $s->hospital_id;?>').submit();">
				<td>
					<?php echo form_open('sanitation/view_scores',array('role'=>'form','id'=>'select_hospital_'.$s->hospital_id));?>
					<?php echo $i++; ?>
					<input type="text" name="hospital" form="select_hospital_<?php echo $s->hospital_id;?>" value="<?php echo $s->hospital_id;?>" class="sr_only" hidden />
					<input type="text" name="from_date" form="select_hospital_<?php echo $s->hospital_id;?>" value="<?php echo $from_date;?>" class="sr_only" hidden />
					<input type="text" name="to_date" form="select_hospital_<?php echo $s->hospital_id;?>" value="<?php echo $to_date;?>" class="sr_only" hidden />
					</form>
				</td>
				<td><?php echo $s->hospital;?></td>
				<td><?php echo number_format($s->weekly_score);?>/<?php echo number_format($s->weekly_total);?></td>
				<td><?php echo number_format(($total_score/$total)*100,2);?>%</td>	
			</tr>
		<?php } ?>
	</table>
	<?php } ?>
		
</div>