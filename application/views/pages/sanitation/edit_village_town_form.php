
	<?php if(isset($mode)&& $mode=="select"){ ?>
	<center>	<h3><u>Edit Village Town</u></h3></center><br>
	<?php echo form_open('masters/edit/village_town',array('role'=>'form')); ?>
<div class="form-group">
		<label for="village_town" class="col-md-4" >Village Town</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="village_town" id="department_name" name="village_town" 
		<?php if(isset($village_town)){
			echo "value='".$village_town[0]->village_town."' ";
			}
		?>
		/>
		<?php if(isset($village_town)){ ?>
		<input type="hidden" value="<?php echo $village_town[0]->village_town_id;?>" name="village_town_id" />
		
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
	<?php echo form_open('masters/edit/village_town',array('role'=>'form','class'=>'form-inline','name'=>'search_village_town'));?>
	<h3> Search Village Town </h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td>	<input type="text" class="form-control" placeholder="village_town" id="village_town" name="village_town" >
	
		
</td>		

		<td><input class="btn btn-lg btn-primary btn-block" name="search" value="Search" type="submit" /></td></tr>
	</tbody>
	</table>
	</form>
	<?php if(isset($mode) && $mode=="search"){ ?>

	<h3 class="col-md-12">List of Village Town</h3>
	<div class="col-md-12 "><strong>
	<?php if($this->input->post('search_village_town')) echo "village_town : ".$village_town[0]->village_town; ?>
	<?php if($this->input->post('search_village_town')) echo "village_town starting with : ".$this->input->post('search_village_town'); ?>
	
	</strong>
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th>village_town
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach($village_town as $a){ ?>
	<?php echo form_open('masters/edit/village_town',array('id'=>'select_village_town_form_'.$a->village_town_id,'role'=>'form')); ?>
	<tr onclick="$('#select_village_town_form_<?php echo $a->village_town_id;?>').submit();" >
		<td><?php echo $i++; ?></td>
		<td><?php echo $a->village_town; ?>
		<input type="hidden" value="<?php echo $a->village_town_id; ?>" name="village_town_id" />
		<input type="hidden" value="select" name="select" />
		</td>
		<!--<td><?php echo $a->village_town; ?></td>-->
		
	</tr>
	</form>
	<?php } ?>
	</tbody>
	</table>
	<?php } ?>
	</div>