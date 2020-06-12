<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >

<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript">
$(function(){
	$("#date").Zebra_DatePicker({
		
	});
	
});
</script>

<div class="col-md-8 col-md-offset-2">

	<?php if(isset($mode)&& $mode=="select"){ ?>
	<center>	<h3>Add  Service Issue</h3></center><br>
	<?php echo validation_errors(); echo form_open('equipments/edit/service',array('role'=>'form','id'=>'edit_equipment')); ?>


	<div class="form-group">
		<label for="equipment_type" class="col-md-4" >Equipment Type</label>
		<div  class="col-md-8">
		<select name="equipment_name" id="equipment_type" class="form-control">
		<option value="">--SELECT--</option>
		<?php foreach($equipment_type as $e){
			echo "<option value='$e->equipment_type_id'";
			if(isset($equipments) && $equipments[0]->equipment_type_id==$e->equipment_type_id)
				echo " SELECTED ";
			echo ">$e->equipment_name</option>";
		}
		?>
		</select>
<?php if(isset($equipments)) { ?>
		<input type="hidden" value="<?php echo $equipments[0]->equipment_id;?>" name="equipment_id" />
		
		<?php } ?> 	 	 	
		</div>
	</div>	




		<div class="form-group">
		<label for="make" class="col-md-4">Make<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Make " id="make" name="make" 
		<?php if(isset($equipments)){
			echo "value='".$equipments[0]->make."' ";
			}
		?>
		/>
		<?php if(isset($equipments)) { ?>
		<input type="hidden" value="<?php echo $equipments[0]->equipment_id;?>" name="equipment_id" />
		
		<?php } ?>
		</div>
	</div>
<div class="form-group">
		<label for="model" class="col-md-4">Model<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder=" Model" id="model" name="model" 
		<?php if(isset($equipments)){
			echo "value='".$equipments[0]->model."' ";
			}
		?>
		/>
		
		</div>
	</div>



		<div class="form-group">
		<label for="agency_contact_name" class="col-md-4">Serial Number  </label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Serial Number" id="agency_contact_name" name="serial_number" 
		<?php if(isset($equipments)){
			echo "value='".$equipments[0]->serial_number."' ";
			}
		?>/>
		</div></div>
		<div class="form-group">
		<label for="agency_address" class="col-md-4"> Asset Number</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Asset Number " id="agency_address" name="asset_number" 
		<?php if(isset($equipments)){
			echo "value='".$equipments[0]->asset_number."' ";
			}
		?>
		/>
</div></div>
</div></div>


	</div> 
   	<div class="col-md-2 col-md-offset-5">
	<input class="btn btn-lg btn-primary btn-block" type="submit" value="Submit" name="update">
	</div>
	</form>
	<?php } ?>
	<h3><?php if(isset($msg)) echo $msg;?></h3>	
	<div class="col-md-12">
	<?php echo form_open('equipments/edit/service',array('role'=>'form','id'=>'search_form','class'=>'form-inline','name'=>'search_equipment'));?>
	<h3> Search Equipment </h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td><input type="text" class="form-control" placeholder="Equipment Name	" id="equipment Name" name="equipment_name"> 
		
		
				<td><input class="btn btn-lg btn-primary btn-block" name="search" value="Search" type="submit" /></td></tr>
	</tbody>
	</table>
	</form>
	<?php if(isset($mode) && $mode=="search"){ ?>
	
	<h3 class="col-md-12">List of Equipments </h3>
	<div class="col-md-12 ">
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th>Equipment Type </th><th>Make</th><th>Model</th><th>Serial Number</th><th>Asset Number</th><th>Procured By</th><th>Cost</th><th>Supplier</th>
	<th>Supply Date</th><th>Warranty Period</th><th>Service Engineer</th><th>Service Engineer Contact</th><th>Hospital</th><th>Department</th><th>Equipment Status</th></thead>
	<tbody>
	<?php 
	$i=1;
	foreach($equipments as $a){ ?>
	<?php echo form_open('equipments/edit/service',array('id'=>'select_equipment_form_'.$a->equipment_id,'role'=>'form')); ?>
	<tr onclick="$('#select_equipment_form_<?php echo $a->equipment_id;?>').submit();" >
		<td><?php echo $i++; ?></td>
		<td><?php echo $a->equipment_name; ?>
		
		<input type="hidden" value="<?php echo $a->equipment_id; ?>" name="equipment_id" />
		<input type="hidden" value="select" name="select" />
		</td>
			<td><?php echo $a->make; ?></td>
	
		<td><?php echo $a->model; ?></td>
		<td><?php echo $a->serial_number; ?></td>
		<td><?php echo $a->asset_number; ?></td>
		<td><?php echo $a->procured_by; ?></td>
		<td><?php echo $a->cost; ?></td>
		<td><?php echo $a->supplier; ?></td>
		<td><?php echo $a->supply_date; ?></td>
		<td><?php echo $a->warranty_period; ?></td>
		<td><?php echo $a->service_engineer; ?></td>
		<td><?php echo $a->service_engineer_contact; ?></td>
		<td><?php echo $a->hospital; ?></td>
		<td><?php echo $a->department; ?></td>
		<td><?php  $i=$a->equipment_status;
if($i==1){
	echo "In Use";
}
else
	echo "Removed";

		 ?></td>
		


			</tr>
	</form>
	<?php } ?>
	</tbody>
	</table>
	<?php } ?>
	</div></div>