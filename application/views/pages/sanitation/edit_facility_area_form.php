
	<?php if(isset($mode)&& $mode=="select"){ ?>
	<center>	<h3><u>Edit Facility Area</u></h3></center><br>
	<?php echo form_open('masters/edit/facility_area',array('role'=>'form')); ?>
<div class="form-group">
		<label for="facility_area" class="col-md-4" >Area name</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="facility_area" id="department_name" name="facility_area" 
		<?php if(isset($facility_area)){
			echo "value='".$facility_area[0]->area_name."' ";
			}
		?>
		/>
		<?php if(isset($facility_area)){ ?>
		<input type="hidden" value="<?php echo $facility_area[0]->facility_area_id;?>" name="facility_area_id" />
		
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
	<?php echo form_open('masters/edit/facility_area',array('role'=>'form','class'=>'form-inline','name'=>'search_facility_area'));?>
	<h3> Search Facility Area</h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td>	<input type="text" class="form-control" placeholder="Area Name" id="facility_name" name="area_name" >
	
		
</td>		

		<td><input class="btn btn-lg btn-primary btn-block" name="search" value="Search" type="submit" /></td></tr>
	</tbody>
	</table>
	</form>
	<?php if(isset($mode) && $mode=="search"){ ?>

	<h3 class="col-md-12">List of Facility Area</h3>
	<div class="col-md-12 "><strong>
	<?php if($this->input->post('search_area_name')) echo "Facility Area : ".$area_name[0]->area_name; ?>
	<?php if($this->input->post('search_area_name')) echo "Facility Area starting with : ".$this->input->post('search_area_name'); ?>
	
	</strong>
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th>Area Name 
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach($facility_area as $a){ ?>
	<?php echo form_open('masters/edit/facility_area',array('id'=>'select_facility_area_form_'.$a->facility_area_id,'role'=>'form')); ?>
	<tr onclick="$('#select_facility_area_form_<?php echo $a->facility_area_id;?>').submit();" >
		<td><?php echo $i++; ?></td>
		<td><?php echo $a->area_name; ?>
		<input type="hidden" value="<?php echo $a->facility_area_id; ?>" name="facility_area_id" />
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