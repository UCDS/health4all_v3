
	<?php if(isset($mode)&& $mode=="select"){ ?>
	<center>	<h3><u>Edit Districts</u></h3></center><br>
	<?php echo form_open('masters/edit/districts',array('role'=>'form')); ?>
<div class="form-group">
		<label for="districts" class="col-md-4" >District</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Districts" id="department_name" name="districts" 
		<?php if(isset($districts)){
			echo "value='".$districts[0]->district."' ";
			}
		?>
		/>
		<?php if(isset($districts)){ ?>
		<input type="hidden" value="<?php echo $districts[0]->district_id;?>" name="district_id" />
		
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
	<?php echo form_open('masters/edit/districts',array('role'=>'form','class'=>'form-inline','name'=>'search_districts'));?>
	<h3> Search Districts </h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td>	<input type="text" class="form-control" placeholder="District" id="facility_name" name="district" >
	
		
</td>		

		<td><input class="btn btn-lg btn-primary btn-block" name="search" value="Search" type="submit" /></td></tr>
	</tbody>
	</table>
	</form>
	<?php if(isset($mode) && $mode=="search"){ ?>

	<h3 class="col-md-12">List of Districts</h3>
	<div class="col-md-12 "><strong>
	<?php if($this->input->post('search_district')) echo "districts : ".$district[0]->district; ?>
	<?php if($this->input->post('search_district')) echo "Districts starting with : ".$this->input->post('search_district'); ?>
	
	</strong>
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th>District 
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach($districts as $a){ ?>
	<?php echo form_open('masters/edit/districts',array('id'=>'select_districts_form_'.$a->district_id,'role'=>'form')); ?>
	<tr onclick="$('#select_districts_form_<?php echo $a->district_id;?>').submit();" >
		<td><?php echo $i++; ?></td>
		<td><?php echo $a->district; ?>
		<input type="hidden" value="<?php echo $a->district_id; ?>" name="district_id" />
		<input type="hidden" value="select" name="select" />
		</td>
		<!--<td><?php echo $a->district; ?></td>-->
		
	</tr>
	</form>
	<?php } ?>
	</tbody>
	</table>
	<?php } ?>
	</div>