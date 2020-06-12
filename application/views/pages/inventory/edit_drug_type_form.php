<div class="col-md-8 col-md-offset-2">

	<?php if(isset($mode)&& $mode=="select"){ ?>
	<center>	<h3>Edit  Drug Type Details</h3></center><br>
	<?php echo form_open('consumables/edit/drug_type',array('role'=>'form')); ?>


		<div class="form-group">
		<label for="agency_name" class="col-md-4">Drug Name<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Drug Name" id="agency_name" name="drug_type" 
		<?php if(isset($drug_type)){
			echo "value='".$drug_type[0]->drug_type."' ";
			}
		?>
		/>
		<?php if(isset($drug_type)) { ?>
		<input type="hidden" value="<?php echo $drug_type[0]->drug_type_id;?>" name="drug_type_id" />
		
		<?php } ?>
		</div>
	</div>
<div class="form-group">
		<label for="agency_name" class="col-md-4">Description<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Generic Name" id="agency_name" name="description" 
		<?php if(isset($drug_type)){
			echo "value='".$drug_type[0]->description."' ";
			}
		?>
		/>
		<?php if(isset($drug_type)){ ?>
		<input type="hidden" value="<?php echo $drug_type[0]->drug_type_id;?>" name="drug_type_id" />
		
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
	<?php echo form_open('consumables/edit/drug_type',array('role'=>'form','id'=>'search_form','class'=>'form-inline','name'=>'search_drugs'));?>
	<h3> Search Drug Type </h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td><input type="text" class="form-control" placeholder="Drug type" id="agency_name" name="drug_type"> 
		
</td>		
				<td><input class="btn btn-lg btn-primary btn-block" name="search" value="Search" type="submit" /></td></tr>
	</tbody>
	</table>
	</form>
	<?php if(isset($mode) && $mode=="search"){ ?>

	<h3 class="col-md-12">List of Drug Types</h3>
	<div class="col-md-12 ">
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th>Drug Name </th><th>Description</th>
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach($drug_type as $a){ ?>
	<?php echo form_open('consumables/edit/drug_type',array('id'=>'select_drug_form_'.$a->drug_type_id,'role'=>'form')); ?>
	<tr onclick="$('#select_drug_form_<?php echo $a->drug_type_id;?>').submit();" >
		<td><?php echo $i++; ?></td>
		<td><?php echo $a->drug_type; ?>
		<input type="hidden" value="<?php echo $a->drug_type_id; ?>" name="drug_type_id" />
		<input type="hidden" value="select" name="select" />
		</td>
		<td><?php echo $a->description; ?></td>
			</tr>
	</form>
	<?php } ?>
	</tbody>
	</table>
	<?php } ?>
	</div></div>