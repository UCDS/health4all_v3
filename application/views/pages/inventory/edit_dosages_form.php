<div class="col-md-8 col-md-offset-2">

	<?php if(isset($mode)&& $mode=="select"){ ?>
	<center>	<h3>Edit  Dosage Details</h3></center><br>
	<?php echo form_open('consumables/edit/dosages',array('role'=>'form')); ?>


		<div class="form-group">
		<label for="agency_name" class="col-md-4">Dosage<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Dosage " id="agency_name" name="dosage" 
		<?php if(isset($dosage)){
			echo "value='".$dosage[0]->dosage."' ";
			}
		?>
		/>
		<?php if(isset($dosage)) { ?>
		<input type="hidden" value="<?php echo $dosage[0]->dosage_id;?>" name="dosage_id" />
		
		<?php } ?>
		</div>
	</div>
	<div class="form-group">
		<label for="agency_name" class="col-md-4">Dosage Unit<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder=" Dosage Unit" id="agency_name" name="dosage_unit" 
		<?php if(isset($dosage)){
			echo "value='".$dosage[0]->dosage_unit."' ";
			}
		?>
		/>
		<?php if(isset($dosage)){ ?>
		<input type="hidden" value="<?php echo $dosage[0]->dosage_id;?>" name="dosage_id" />
		
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
	<?php echo form_open('consumables/edit/dosages',array('role'=>'form','id'=>'search_form','class'=>'form-inline','name'=>'search_dosages'));?>
	<h3> Search Dosage Type </h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td><input type="text" class="form-control" placeholder=" Dosage" id="agency_name" name="dosage_name"> 
		
				<td><input class="btn btn-lg btn-primary btn-block" name="search" value="Search" type="submit" /></td></tr>
	</tbody>
	</table>
	</form>
	<?php if(isset($mode) && $mode=="search"){ ?>

	<h3 class="col-md-12">List of Dosages </h3>
	<div class="col-md-12 ">
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th>Dosage </th><th>Dosage Unit</th>
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach($dosage as $a){ ?>
	<?php echo form_open('consumables/edit/dosages',array('id'=>'select_dosages_form_'.$a->dosage_id,'role'=>'form')); ?>
	<tr onclick="$('#select_dosages_form_<?php echo $a->dosage_id;?>').submit();" >
		<td><?php echo $i++; ?></td>
		<td><?php echo $a->dosage; ?>
		<input type="hidden" value="<?php echo $a->dosage_id; ?>" name="dosage_id" />
		<input type="hidden" value="select" name="select" />
		</td>
		<td><?php echo $a->dosage_unit; ?></td>
			</tr>
	</form>
	<?php } ?>
	</tbody>
	</table>
	<?php } ?>
	</div></div>	