<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.timeentry.min.js"></script>
<script type="text/javascript">
$(function(){
	$('.date').Zebra_DatePicker({
	  disabled_dates : ['* * * *'],
	  enabled_dates: ['7,14,21,28,29,30,31 * * *']
	});
	$(".time").timeEntry();
	$("#select_form").on('submit',function(e){
		if($('#date').val()==""){
			alert('Please select a date');
			e.preventDefault();
		}
		else{
			return true;
		}
	});
	$(".submit").on('click',function(e){
		
		var scores_table = '<table class="table table-bordered table-striped"><thead><th>Activity</th><th>Score</th><th>Comment</th></thead><tbody>';
		$(".activity").each(function(){
			scores_table+='<tr><td>'+$(this).find('.activity_name').text()+'</td><td>'+$(this).find('.score').val()+'</td><td>'+$(this).find('.comment').val()+'</td></tr>';
		});
		scores_table+='</tbody></table>';
		$('.modal-body').text('');
		$('.modal-body').append(scores_table);
		console.log(scores_table);
		
	});
	$('.confirm').click(function(){
		$('#myModal').modal('hide');
		$('#evaluation_form').submit();
	});
	$("#hospital").on('change',function(){
		$(".area").show();
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
	<?php echo validation_errors();
		echo form_open('sanitation/evaluate',array('role'=>'form','class'=>'form-custom','id'=>'select_form')); ?>
		<?php if(count($hospitals)==1){ ?>
			<input name="hospital" class="sr-only" value="<?php echo $hospitals[0]->hospital_id;?>" hidden />
			|||| Hospital : <b><?php echo $hospitals[0]->hospital;?></b>
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
		
		<?php if(count($area)==1){ ?>
			<input name="area" class="sr-only" value="<?php echo $area[0]->area_id;?>" hidden />
			|||| Area : <b><?php echo $area[0]->area_name;?></b> ||||
		<?php } 
		else { 
		?>
		<span class="area">
	    <label for="area_activity">Area</label>
		<select name="area" id="area" class="form-control" required >
		<option value="">Select Area</option>
		<?php foreach($area as $d){
			echo "<option value='$d->area_id' class='$d->hospital_id' hidden disabled>$d->area_name</option>";
		}
		?>
		</select>
		</span>
		<?php } ?>
		<hr>
		<label for="date">Select week ending date : </label>
		<input type="text" class="date form-control" name="date" id="date" form="select_form" required />
		<input type="submit" value="Select" name="select_area" class="btn btn-primary btn-sm" />
	</form>
	<?php if($this->input->post('select_area')){ 
	echo form_open('sanitation/evaluate',array('role'=>'form','class'=>'form-custom','id'=>'evaluation_form')); ?>
	<br />
	<br />
	<div class="panel panel-default">
		<div class="panel panel-heading">
		<?php if($this->input->post('date')){ ?>
			<div class="pull-right">
				From Date : 
				<?php if(date("d",strtotime($this->input->post('date')))>'28'){
							$from_date=date("29-M-Y",strtotime($this->input->post('date')));
							$to_date=date("t-M-Y",strtotime($this->input->post('date')));
						}
						else {
							$from_date = date("d-M-Y",strtotime($this->input->post('date')." - 6 days"));
							$to_date = date("d-M-Y",strtotime($this->input->post('date')));
						}
				?>
				<input type="text" value="<?php echo $from_date;?>" class="form-control" name="evaluation_date" readonly />
				To Date : 
				<input type="text" value="<?php echo $to_date;?>" class="form-control" readonly />
				
			</div>
		<?php } ?>
			<div class=""><h4>Evaluation Form</h4></div>
		</div>
		<div class="panel-body">
			<?php
				$daily_activities=array();
				$weekly_activities=array();
				$fortnightly_activities=array();
				$monthly_activities=array();
				foreach($sanitation_activity as $a){
					if(!in_array($a->activity_name,$daily_activities) && !in_array($a->activity_name,$weekly_activities) && !in_array($a->activity_name,$fortnightly_activities) && !in_array($a->activity_name,$monthly_activities)){
						if($a->frequency_type=="Daily")
							$daily_activities[]=$a->activity_name; 
						else if($a->frequency_type=="Weekly")
							$weekly_activities[]=$a->activity_name;
						else if($a->frequency_type=="Fortnightly")
							$fortnightly_activities[]=$a->activity_name;
						else if($a->frequency_type=="Monthly")
							$monthly_activities[]=$a->activity_name;
					}
				}
			?>
			
			
			<?php if(count($daily_activities)>0){ ?>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th colspan="100">Daily</th>
					<tr>
						<th>#</th>
						<th>Activity</th>
					</tr>
				</thead>
				<tbody>
				<?php $i=1;
				foreach($daily_activities as $activity){?>
					<tr>
						<td><?php echo $i++;?></td>
						<td><?php echo $activity;?></td>
						<?php foreach($sanitation_activity as $a){
								if($a->activity_name == $activity){
						?>
						<td>
							<input type="checkbox" value="<?php echo $a->activity_id;?>" name="activity_id[]"  />
							<input type="text" class="time form-control" value="<?php echo $a->day_activity_time;?>" name="activity_<?php echo $a->activity_id;?>" size="7" /></td>
						<?php }
						} ?>
					</tr>
				<?php } ?>
				</tbody>
			</table>
			<?php } ?>
			
			
			<?php if(count($weekly_activities)>0){ ?>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th colspan="100">Weekly</th>
					<tr>
						<th>#</th>
						<th>Activity</th>
					</tr>
				</thead>
				<tbody>
				<?php $i=1;
				foreach($weekly_activities as $activity){?>
					<tr class="activity">
						<td><?php echo $i++;?></td>
						<td class="activity_name"><?php echo $activity;?></td>
						<?php foreach($sanitation_activity as $a){
								if($a->activity_name == $activity){
						?>
						<td>
							<input type="checkbox" value="<?php echo $a->activity_id;?>" checked name="weekly_activity_id[]" hidden />
							<input type="number" class="form-control score" placeholder="Score" min=0 max="<?php echo $a->weightage;?>" value="<?php echo $a->weekly_score;?>" name="activity_score_<?php echo $a->activity_id;?>" size="3" required <?php if($a->weekly_score) echo "disabled";?> />
							  <textarea class="form-control comment" placeholder="Comments" name="comments_<?php echo $a->activity_id;?>" <?php if($a->weekly_score) echo "disabled";?>><?php echo $a->comments;?></textarea>
							  <br />(Max score : <?php echo $a->weightage;?>)
						</td>
						<?php }
						} ?>
					</tr>
				<?php } ?>
				</tbody>
			</table>
			<?php } ?>
			<?php if(count($fortnightly_activities)>0){ ?>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th colspan="100">Fortnightly</th>
					<tr>
						<th>#</th>
						<th>Activity</th>
					</tr>
				</thead>
				<tbody>
				<?php $i=1;
				foreach($fortnightly_activities as $activity){?>
					<tr>
						<td><?php echo $i++;?></td>
						<td><?php echo $activity;?></td>
						<?php foreach($sanitation_activity as $a){
								if($a->activity_name == $activity){
						?>
						<td>
							<input type="checkbox" value="<?php echo $a->activity_id;?>" name="fortnightly_activity_id[]"  />
							<input type="text" class="date form-control" value="<?php if($a->fortnight_activity_date) echo date("d-M-Y",strtotime($a->fortnight_activity_date));?>" name="activity_date_<?php echo $a->activity_id;?>" />
							<input type="text" class="time form-control" value="<?php echo $a->fortnight_activity_time;?>" name="other_activity_<?php echo $a->activity_id;?>" size="7" /></td>
						<?php }
						} ?>
					</tr>
				<?php } ?>
				</tbody>
			</table>
			<?php } ?>
			<?php if(count($monthly_activities)>0){ ?>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th colspan="100">Monthly activities for the month of <?php echo date("M, Y",strtotime($this->input->post('date')));?></th>
					<tr>
						<th>#</th>
						<th>Activity</th>
					</tr>
				</thead>
				<tbody>
				<?php $i=1;
				foreach($monthly_activities as $activity){?>
					<tr>
						<td><?php echo $i++;?></td>
						<td><?php echo $activity;?></td>
						<?php foreach($sanitation_activity as $a){
								if($a->activity_name == $activity){
						?>
						<td>
							<input type="checkbox" value="<?php echo $a->activity_id;?>" name="monthly_activity_id[]"  checked hidden class="sr-only" />

							  <textarea class="form-control comment" placeholder="Comments" name="comments_<?php echo $a->activity_id;?>" <?php if($a->monthly_score!=NULL) echo "disabled";?>><?php echo $a->comments;?></textarea>
						<?php }
						} ?>
					</tr>
				<?php } ?>
				</tbody>
			</table>
			<?php } ?>
		</div>
		<div class="panel-footer">
			<button class="btn btn-primary btn-lg submit col-md-offset-5" data-toggle="modal" data-target="#myModal" form="evaluation_form" value="Submit">
			  Submit
			</button>

			<!-- Modal -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Cancel</span></button>
					<h4 class="modal-title" id="myModalLabel">Confirm Scores</h4>
				  </div>
				  <div class="modal-body">
					
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
					<input type="submit" class="btn btn-primary confirm" form="evaluation_form" name="submit_evaluation" value="Confirm" />
				  </div>
				</div>
			  </div>
			</div>
		</div>
	</div>
	</form>
	<?php } ?>
</div>
