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
});
</script>
<div class="col-md-10 col-md-offset-2">
	<?php if(isset($msg)){ ?>
		<div class="alert alert-info"><?php echo $msg;?></div>
	<?php } ?>
	<?php echo validation_errors();?>	
	<?php echo form_open('sanitation/view_scores',array('role'=>'form','class'=>'form-custom')); ?>		
	<?php if(count($hospitals)==1){ ?>
			<input name="hospital" class="sr-only" value="<?php echo $hospitals[0]->hospital_id;?>" hidden />
			Hospital : <b><?php echo $hospitals[0]->hospital;?></b>&nbsp&nbsp&nbsp&nbsp&nbsp
		<?php } 
		else { 
		?>
	    <label for="hospital">Hospital</label>
		<select name="hospital" id="hospital" class="form-control" required >
		<option value="">Hospital</option>
		<?php foreach($hospitals as $d){
			echo "<option value='$d->hospital_id'>$d->hospital</option>";
		}
		?>
		</select>
		<?php } ?>
	<label for="from_date">From Date</label>
	<input class="date form-control" name="from_date" id="from_date" type="text" /> 
	<label for="to_date">To Date</label>
	<input class="date form-control" name="to_date" id="to_date" type="text" /> 
	<input type="submit" class="btn btn-primary btn-md" name="submit" value="Submit" />
	<?php if(isset($scores) && count($scores)>0) { 
	$activities=array();
	$dates=array();
	$week_total_score=0;
	$total_score=0;
	$week_total_weightage=0;
	$total_weightage=0;
	$total_days=0;
	foreach($scores as $s){
		if($s->frequency_type == "Weekly") 
		$activities[]=$s->activity_name;
	}
	
	$activities=array_unique($activities);
	$from_date=date("Y-m-d",strtotime($this->input->post('from_date')));
	$to_date=date("Y-m-d",strtotime($this->input->post('to_date')));
	$i=0;
	$date=$from_date;
	$dates[]=$date;
	while($i==0){
		$date=date("Y-m-d",strtotime($date."+7 days"));	
		if($date>$to_date){
			$i++;
			break;
		}	
		$dates[]=$date;

		if(date("d",strtotime($date))>28){
			$date=date("Y-m-d",strtotime($date."+7 days"));
			$date=date("Y-m-1",strtotime($date));
			if(date("U",strtotime($date))>date("U",strtotime($to_date))){
				$i++;
				break;
			}	
			$dates[]=$date;
		}
	}
	$dates=array_unique($dates);
	$months=array();
	foreach($dates as $date){
		if(!in_array(date("M,Y",strtotime($date)),$months)){
			$months[]=date("M,Y",strtotime($date));
		}
	}
	?>
	<br />
	<br />
	<div class="panel">Sanitation scores for the period : <b><?php echo $this->input->post('from_date');?></b> to <b><?php echo $this->input->post('to_date');?></b></div>
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
			<th colspan="100" class="text-center"><?php echo $scores[0]->hospital;?> - Detailed Report </th>
			</tr>
			<tr>
			<th rowspan="2" class="text-center">From</th>
			<th rowspan="2" class="text-center">To</th>
			<th rowspan="2" class="text-center">No. Days</th>
			<?php foreach($activities as $activity){ ?>
				<th colspan="2" class="text-center"><?php echo $activity;?></th>
			<?php } ?>
			<th colspan="2" class="text-center">Overall</th>
			</tr>
			<tr>
			<?php foreach($activities as $activity){ ?>
				<th class="text-center">Score</th>
				<th class="text-center">Max. Marks</th>
			<?php } ?>
				<th class="text-center">Score</td>
				<th class="text-center">Max. Marks</td>
				<th class="text-center">%</td>
			</tr>
		</thead>
	<?php $i=1;
		foreach($dates as $d){ 
			?>
			<tr>
				<td class="text-center"><?php $from_date=date("d-M-Y",strtotime($d)); echo $from_date ?></td>
				<td class="text-center">
					<?php if(date('d',strtotime($d))>28){ $to_date=date("t-M-Y",strtotime($d)); } else $to_date = date("d-M-Y",strtotime($d.'+6 days'));
					echo $to_date;
					?>
				</td>
				<td class="text-center"><?php $days= (date("U",strtotime($to_date)) - date("U",strtotime($from_date)))/60/60/24+1;echo $days;?></td>
				<?php 
				$j=0;
				foreach($activities as $activity){
					$i=0; 
					foreach($scores as $s){
						if(date("Y-m-d",strtotime($d))==date('Y-m-d',strtotime($s->date)) && $s->activity_name==$activity){
						if($s->score==0 || $s->score == NULL) { $background_color = "#FFA3A3"; } else $background_color = "#99FF99"; ?>					
						<td class="text-center" style="background-color : <?php echo $background_color;?> !important"><b><?php echo $s->score;?></b></td>
						<td class="text-center"><?php echo $s->weightage;?></td>
						<?php
						$week_total_score+=$s->score;
						$week_total_weightage+=$s->weightage;
						break;
						}
						else if($s->score == NULL && $s->activity_name==$activity){
							  ?>
							<td class="text-center" style="background-color : #FFA3A3"><b>0</b></td>
							<td class="text-center"><?php echo $s->weightage;?></td>
						<?php 
						
						$week_total_weightage+=$s->weightage;
						break; 
						}
						$i++;
					if(($i>count($scores)-count($activities) && $s->activity_name==$activity)){
						 ?>
						<td class="text-center" style="background-color :#FFA3A3 !important"><b>0</b></td>
						<td class="text-center"><?php echo $s->weightage;?></td>
					<?php 
						$week_total_weightage+=$s->weightage;
						} 
					?>
				<?php }
				$j++;
				}
				
				if($s->score==0 || $s->score == NULL) { $background_color = "#FFA3A3"; } else $background_color = "#99FF99"; ?>
				<td class="text-center"  style="background-color : <?php echo $background_color;?> !important"><b><?php echo $week_total_score;?></b></td>
				<td class="text-center"><?php echo $week_total_weightage;?></td>
				<td class="text-center" style="background-color : <?php echo $background_color;?> !important"><?php echo number_format(($week_total_score/$week_total_weightage)*100,2);
				$total_score+=$week_total_score; $week_total_score=0;
				$total_weightage+=$week_total_weightage; $week_total_weightage=0;?>%</td>
			</tr>
		<?php $total_days+=$days; } ?>
			<tfoot><th colspan="2" class="text-center">Total No. of Days</th><th class="text-center"><?php echo $total_days;?></th><th colspan="<?php echo $j*2;?>" class="text-right">	Total</th><th class="text-center"><?php echo $total_score;?></th><th class="text-center"><?php echo $total_weightage;?></th><th class="text-center"><?php echo number_format(($total_score/$total_weightage)*100,2);?>%</th></tr>
	</table>
	<?php } ?>
	
	<table class="table table-bordered table-striped">
		<thead>
			<tr>
				<th colspan="100">Monthly</th>
			</tr>
			<tr>
				<th>#</th>
				<th>Month</th>
				<th>Activity</th>
				<th>Comment</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$i=1;
			foreach($scores as $s){
						foreach($months as $m){

				if($s->frequency_type == "Monthly" && in_array(date("M,Y",strtotime($s->date)),$months)){ ?>
					<tr>
						<td><?php echo $i++;?></td>
						<td><?php echo date("M, Y",strtotime($s->date));?></td>
						<td><?php echo $s->activity_name;?></td>
						<td><?php echo $s->comments;?></td>
					</tr>
				<?php break;}
			}
		}
			?>
		</tbody>
	</table>
		
</div>
