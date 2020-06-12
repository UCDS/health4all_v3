
	<?php if(isset($mode)&& $mode=="select"){ ?>
	<center>	<h3><u>Edit States</u></h3></center><br>
	<?php echo form_open('masters/edit/states',array('role'=>'form')); ?>
<div class="form-group">
		<label for="states" class="col-md-4" >States</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="States" id="department_name" name=s"states" 
		<?php if(isset($states)){
			echo "value='".$states[0]->state."' ";
			}
		?>
		/>
		<?php if(isset($states)){ ?>
		<input type="hidden" value="<?php echo $states[0]->state_id;?>" name="states_id" />
		
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
	<?php echo form_open('masters/edit/states',array('role'=>'form','class'=>'form-inline','name'=>'search_states'));?>
	<h3> Search States </h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td>	<input type="text" class="form-control" placeholder="states" id="facility_name" name="states" >
	
		
</td>		

		<td><input class="btn btn-lg btn-primary btn-block" name="search" value="Search" type="submit" /></td></tr>
	</tbody>
	</table>
	</form>
	<?php if(isset($mode) && $mode=="search"){ ?>

	<h3 class="col-md-12">List of States</h3>
	<div class="col-md-12 "><strong>
	<?php if($this->input->post('search_state')) echo "states : ".$states[0]->states; ?>
	<?php if($this->input->post('search_state')) echo "states starting with : ".$this->input->post('search_state'); ?>
	
	</strong>
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th>States
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach($states as $a){ ?>
	<?php echo form_open('masters/edit/states',array('id'=>'select_states_form_'.$a->state_id,'role'=>'form')); ?>
	<tr onclick="$('#select_states_form_<?php echo $a->state_id;?>').submit();" >
		<td><?php echo $i++; ?></td>
		<td><?php echo $a->state; ?>
		<input type="hidden" value="<?php echo $a->state_id; ?>" name="state_id" />
		<input type="hidden" value="select" name="select" />
		</td>
		<!--<td><?php echo $a->state; ?></td>-->
		
	</tr>
	</form>
	<?php } ?>
	</tbody>
	</table>
	<?php } ?>
	</div>a