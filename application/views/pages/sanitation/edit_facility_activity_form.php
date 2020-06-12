
	<?php if(isset($mode)&& $mode=="select"){ ?>
	<center>	<h3><u>Edit Facility Activity</u></h3></center><br>
	<?php echo form_open('masters/edit/facility_activity',array('role'=>'form')); ?>
<div class="form-group">
		<label for="facility_activity" class="col-md-4" >Facility_activity</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Facility_activity" id="department_name" name="districts" 
		<?php if(isset($facility_activity)){
			echo "value='".$facility_activity[0]->facility_area."' ";
			}
		?>
		/>
		<?php if(isset($facility_activity)){ ?>
		<input type="hidden" value="<?php echo $facility_activity[0]->activity_id;?>" name="activity_id" />
		
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
	<?php echo form_open('masters/edit/facility_activity',array('role'=>'form','class'=>'form-inline','name'=>'search_facility_activity'));?>
	<h3> Search Facility Activity</h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td>	<input type="text" class="form-control" placeholder="facility_area" id="area_name" name="facility_area" >
	
		
</td>		

		<td><input class="btn btn-lg btn-primary btn-block" name="search" value="Search" type="submit" /></td></tr>
	</tbody>
	</table>
	</form>
	<?php if(isset($mode) && $mode=="search"){ ?>

	<h3 class="col-md-12">List of Facility activity</h3>
	<div class="col-md-12 "><strong>
	<?php if($this->input->post('search_facility_activity')) echo "facility_activity : ".$area_name[0]->area_name; ?>
	<?php if($this->input->post('search_area_name')) echo "Facility_activity starting with : ".$this->input->post('search_area_name'); ?>
	
	</strong>
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th>Facility Activity 
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach($facility_activity as $a){ ?>
	<?php echo form_open('masters/edit/facility_activity',array('id'=>'select_facility_activity_form_'.$a->activity_id,'role'=>'form')); ?>
	<tr onclick="$('#select_facility_activity_form_<?php echo $a->activity_id;?>').submit();" >
		<td><?php echo $i++; ?></td>
		<td><?php echo $a->area_name; ?>
		<input type="hidden" value="<?php echo $a->activity_id; ?>" name="activity_id" />
		<input type="hidden" value="select" name="select" />
		</td>
		<!--<td><?php echo $a->area_name; ?></td>-->
		
	</tr>
	</form>
	<?php } ?>
	</tbody>
	</table>
	<?php } ?>
	</div>