<div class="col-md-8 col-md-offset-2">

	<?php if((isset($mode))&&(($mode)=="select")){ ?>
	<center>	<h3>Edit  Equipment Type </h3></center><br>
	<?php echo form_open('equipments/edit/equipment_type',array('role'=>'form')); ?>
		

		<div class="form-group">
		<label for="equipment_type" class="col-md-4">Equipment  Name<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Equipment Name" id="equipment_type" name="equipment_type" 
		<?php if(isset($equipment_types)){
			echo "value='".$equipment_types[0]->equipment_type."' ";
			}
		?>
		/>
		<?php if(isset($equipment_types)) { ?>
		<input type="hidden" value="<?php echo $equipment_types[0]->equipment_type_id;?>" name="equipment_type_id" />
		
		<?php } ?>
		</div>
	</div>
   	<div class="col-md-3 col-md-offset-4">
	<input class="btn btn-lg btn-primary btn-block" type="submit" value="Update" name="update">
	</div>
	</form>
	<?php } ?>
	<h3><?php if(isset($msg)) echo $msg;?></h3>	
	<div class="col-md-12">
	<?php echo form_open('equipments/edit/equipment_type',array('role'=>'form','id'=>'search_form','class'=>'form-inline','name'=>'search_equipment_type'));?>
	<h3> Search Equipment Type </h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td><input type="text" class="form-control" placeholder="Equipment Type" id="equipment_type" name="equipment_type"> 
		
		
				<td><input class="btn btn-lg btn-primary btn-block" name="search" value="Search" type="submit" /></td></tr>
	</tbody>
	</table>
	</form>
	<?php if(isset($mode)&&$mode=="search"){    ?>

	<h3 class="col-md-12">List of Equipment Types</h3>
	<div class="col-md-12 ">
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th>Equipment Name </th>
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach($equipment_types as $a){ ?>
	<?php echo form_open('equipments/edit/equipment_type',array('id'=>'select_equipment_type_form_'.$a->equipment_type_id,'role'=>'form')); ?>
	<tr onclick="$('#select_equipment_type_form_<?php echo $a->equipment_type_id;?>').submit();" >
		<td><?php echo $i++; ?></td>
		<td><?php echo $a->equipment_type; ?>
		<input type="hidden" value="<?php echo $a->equipment_type_id; ?>" name="equipment_type_id" />
		<input type="hidden" value="select" name="select" />
		</td>
			</tr>
	</form>
	<?php } ?>
	</tbody>
	</table>
	<?php } ?>
	</div></div>
