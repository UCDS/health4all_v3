
	<?php if(isset($mode)&& $mode=="select"){ ?>
	<center>	<h3><u>Edit Area activity</u></h3></center><br>
	<?php echo form_open('masters/edit/area_activity',array('role'=>'form')); ?>
<div class="form-group">
		<label for="area_activity" class="col-md-4" >Activity name</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Area Activity" id="department_name" name="area_activity" 
		<?php if(isset($area_activity)){
			echo "value='".$area_activity[0]->activity_name."' ";
			}
		?>
		/>
		<?php if(isset($area_activity)){ ?>
		<input type="hidden" value="<?php echo $area_activity[0]->area_activity_id;?>" name="area_activity_id" />
		
	 <?php } ?>
		</div>
		
	</div>	
	
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
	<?php echo form_open('masters/edit/area_activity',array('role'=>'form','class'=>'form-inline','name'=>'search_area_activity'));?>
	<h3> Search Area activity </h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td>	<input type="text" class="form-control" placeholder="  Activity Name" id="facility_name" name="activity_name" >
	
		
</td>		

		<td><input class="btn btn-lg btn-primary btn-block" name="search" value="Search" type="submit" /></td></tr>
	</tbody>
	</table>
	</form>
	<?php if(isset($mode) && $mode=="search"){ ?>

	<h3 class="col-md-12">List of Area Activity</h3>
	<div class="col-md-12 "><strong>
	<?php if($this->input->post('search_activity_name')) echo "Area activity : ".$activity_name[0]->activity_name; ?>
	<?php if($this->input->post('search_activity_name')) echo "Area Activity starting with : ".$this->input->post('search_activity_name'); ?>
	
	</strong>
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th>Activity Name 
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach($area_activity as $a){ ?>
	<?php echo form_open('masters/edit/area_activity',array('id'=>'select_area_activity_form_'.$a->area_activity_id,'role'=>'form')); ?>
	<tr onclick="$('#select_area_activity_form_<?php echo $a->area_activity_id;?>').submit();" >
		<td><?php echo $i++; ?></td>
		<td><?php echo $a->activity_name; ?>
		<input type="hidden" value="<?php echo $a->area_activity_id; ?>" name="area_activity_id" />
		<input type="hidden" value="select" name="select" />
		</td>
		<!--<td><?php echo $a->activity_name; ?></td>-->
		
	</tr>
	</form>
	<?php } ?>
	</tbody>
	</table>
	<?php } ?>
	</div>