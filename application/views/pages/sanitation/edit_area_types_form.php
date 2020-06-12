
	<?php if(isset($mode)&& $mode=="select"){ ?>
	<center>	<h3><u>Edit Area Types</u></h3></center><br>
	<?php echo form_open('masters/edit/area_types',array('role'=>'form')); ?>
	
	<div class="form-group">
		<label for="agency_name" class="col-md-4">Area Type</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Area Type" id="department_name" name="area_type" 
		<?php if(isset($area_types)){
			echo "value='".$area_types[0]->area_type."' ";
			}
		?>
		/>
		<?php if(isset($area_types)){ ?>
		<input type="hidden" value="<?php echo $area_types[0]->area_type_id;?>" name="area_type_id" />
		
	 <?php } ?>
		</div>
	</div>

	
	
<!--<div class="form-group">
		<label for="facility_type" class="col-md-4" >Area Type</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="  Area Type" id="facility_name" name="area_type" 
		<?php if(isset($area_type)){
		echo "value='".$area_type."'";
		}
		?>
		/>
<?php if(isset($area_type)){?>

	<input type="hidden" class="form-control" placeholder="  Area Type" id="facility_name" name="area_type_id" value="<?php echo $area_type[0]->area_type_id;?>" />
	<?php }?>
</div>	
</div>-->
		<!--<select name="area_type" class="form-control">
		<option value="">--SELECT--</option>
		<?php foreach($area_type as $area_types){
			echo "<option value='$area_type->area_type_id'";
			if(isset($area_type) && $area_type[0]->area_type_id==$area_types->area_type_id)
				echo " SELECTED ";
			echo ">$area_types->area_type</option>";
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
	<?php echo form_open('masters/edit/area_types',array('role'=>'form','class'=>'form-inline','name'=>'search_area_types'));?>
	<h3> Search Area Types </h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td>	<input type="text" class="form-control" placeholder="  Area Type" id="facility_name" name="area_type" >
	
</td>		

		<td><input class="btn btn-lg btn-primary btn-block" name="search" value="Search" type="submit" /></td></tr>
	</tbody>
	</table>
	</form>
	<?php if(isset($mode) && $mode=="search"){ ?>

	<h3 class="col-md-12">List of Area Types</h3>
	<div class="col-md-12 "><strong>
	<?php if($this->input->post('search_area_type')) echo "Area Types : ".$area_type[0]->area_type; ?>
	<?php if($this->input->post('search_area_type')) echo "Area Types starting with : ".$this->input->post('search_area_type'); ?>
	
	</strong>
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th>Area Type 
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach($area_types as $a){?>
	<?php echo form_open('masters/edit/area_types',array('id'=>'select_area_types_form_'.$a->area_type_id,'role'=>'form')); ?>
	<tr onclick="$('#select_area_types_form_<?php echo $a->area_type_id;?>').submit();" >
		<td><?php echo $i++; ?></td>
		<td><?php echo $a->area_type; ?>
		<input type="hidden" value="<?php echo $a->area_type_id; ?>" name="area_type_id" />
		<input type="hidden" value="select" name="select" />
		</td>
		<!--<td><?php echo $a->area_type; ?></tds>-->
		
	</tr>
	</form>
	<?php } ?>
	</tbody>
	</table>
	<?php } ?>
	</div>