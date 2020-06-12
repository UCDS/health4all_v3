
	<?php if(isset($mode)&& $mode=="select"){ ?>
	<center>	<h3><u>Edit Activity done</u></h3></center><br>
	<?php echo form_open('masters/edit/activity_done',array('role'=>'form')); ?>
	
	<div class="form-group">
		<label for="agency_name" class="col-md-4">Date</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Date" id="date" name="date" 
		<?php if(isset($date)){
			echo "value='".$activity_done[0]->date."' ";
			}
		?>
		/>
		<?php if(isset($activity_done)){ ?>
		<input type="hidden" value="<?php echo $activity_done[0]->activity_done_id;?>" name="activity_done_id" />
		
	 <?php } ?>
		</div>
	</div>

	
	
<!--<div class="form-group">
		<label for="facility_type" class="col-md-4" >Date</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="  date" id="facility_name" name="date" 
		<?php if(isset($date)){
		echo "value='".$date."'";
		}
		?>
		/>
<?php if(isset($date)){?>

	<input type="hidden" class="form-control" placeholder="  Date" id="facility_name" name="activity_done_id" value="<?php echo $date[0]->activity_done_id;?>" />
	<?php }?>
</div>	
</div>-->
		<!--<select name="date" class="form-control">
		<option value="">--SELECT--</option>
		<?php foreach($date as $activity_done){
			echo "<option value='$date->activity_done_id'";
			if(isset($date) && $date[0]->activity_done_id==$activity_done->activity_done_id)
				echo " SELECTED ";
			echo ">$activity_done->date</option>";
		}
		?>
		</select>-->
	
	<!--<div class="form-group">
		<label for="facility_type" class="col-md-4" >Area Type</label>
		<div  class="col-md-8">
		<select name="facility_type" id="facility_type" class="form-control">
		<option value="">--SELECT--</option>
		<?php /*foreach($facility_types as $facility_type){
			echo "<option value='$facility_type->facility_type_id'";
			if(isset($facility) && $facility[0]->facility_type_id==$facility_type->facility_type_id)
				echo " SELECTED ";
			echo ">$facility_type->facility_type</option>";
		}*/
		?>
		</select>
		</div>
	
		

	</div> -->
   	<div class="col-md-3 col-md-offset-4"><div class="col-md-8">
	<input class="btn btn-lg btn-primary btn-block" type="submit" value="Update" name="update">
	</div>
	</div>
	</form>
	<?php } ?>
	<h3><?php if(isset($msg)) echo $msg;?></h3>	
	<div class="col-md-12">
	<?php echo form_open('masters/edit/activity_done',array('role'=>'form','class'=>'form-inline','name'=>'search_activity_done'));?>
	<h3> Search Activity Done </h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td>	<input type="text" class="form-control" placeholder="Date" id="facility_name" name="date" >
	
		<!--<select name="search_area_types" id="search_area_types" class="form-control" style="width:180px">
		<option value="" disabled selected>Type</option>
		<?php foreach($activity_done as $activity_done){
			echo "<option value='$activity_done->activity_done_id'>$activity_done->date</option>";
		}
		?>
		</select>-->
</td>		

		<td><input class="btn btn-lg btn-primary btn-block" name="search" value="Search" type="submit" /></td></tr>
	</tbody>
	</table>
	</form>
	<?php if(isset($mode) && $mode=="search"){ ?>

	<h3 class="col-md-12">List of activity done</h3>
	<div class="col-md-12 "><strong>
	<?php if($this->input->post('search_activity_done')) echo "Activity Done : ".$date[0]->date; ?>
	<?php if($this->input->post('search_date')) echo "Activity Done starting with : ".$this->input->post('search_date'); ?>
	
	</strong>
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th>Date
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach($activity_done as $a){?>
	<?php echo form_open('masters/edit/activity_done',array('id'=>'select_activity_done_form_'.$a->activity_done_id,'role'=>'form')); ?>
	<tr onclick="$('#select_activity_done_form_<?php echo $a->activity_done_id;?>').submit();" >
		<td><?php echo $i++; ?></td>
		<td><?php echo $a->date; ?>
		<input type="hidden" value="<?php echo $a->activity_done_id; ?>" name="activity_done_id" />
		<input type="hidden" value="select" name="select" />
		</td>
		<?php echo $a->date; ?></td>
		
	</tr>
	</form>
	<?php } ?>
	</tbody>
	</table>
	<?php } ?>
	</div>