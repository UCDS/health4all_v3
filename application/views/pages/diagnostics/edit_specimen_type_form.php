<div class="col-md-8 col-md-offset-2">
	<?php if((isset($mode))&&(($mode)=="select")){ ?>
	<center><h3>Edit Specimen Type </h3></center><br>
	<?php echo form_open('diagnostics/edit/specimen_type',array('role'=>'form')); ?>
	
		<div class="form-group">
		<label for="specimen_type" class="col-md-4">Specimen Type<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Specimen Type" id="specimen_type" name="specimen_type" 
		<?php if(isset($specimen_types)){
			echo "value='".$specimen_types[0]->specimen_type."' ";
			}
		?>
		/>
		<?php if(isset($specimen_types)) { ?>
		<input type="hidden" value="<?php echo $specimen_types[0]->speciment_type_id;?>" name="specimen_type_id" />
		
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
	<?php echo form_open('diagnostics/edit/specimen_type',array('role'=>'form','id'=>'specimen_type_form','class'=>'form-inline','name'=>'search_specimen_type'));?>
	<h3> Search Specimen Type</h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td><input type="text" class="form-control" placeholder="Specimen Type" id="specimen_type" name="specimen_type"> 
				<td><input class="btn btn-lg btn-primary btn-block" name="search" id="search" value="Search" type="submit" /></td>
	</tr>
	</tbody>
	</table>
	</form>
<?php if(isset($mode) && $mode=="search"){   ?>

	<h3 class="col-md-12">List of Specimen Types </h3>
	<div class="col-md-12 ">
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th> Specimen Types </th>
	</thead>
	<tbody>
	<?php 
	$j=1;
	foreach($specimen_types as $tg){ ?>

	<?php echo form_open('diagnostics/edit/specimen_type',array('id'=>'specimen_type_form_'.$tg->speciment_type_id,'role'=>'form')); ?>
	<tr onclick="$('#specimen_type_form_<?php echo $tg->speciment_type_id;?>').submit();" >
		<td><?php echo $j++; ?></td>
		<td><?php echo $tg->specimen_type; ?>
		<input type="hidden" value="<?php echo $tg->speciment_type_id; ?>" name="specimen_type_id"/>
		<input type="hidden" value="select" name="select" />
		</td>
	</tr>
	</form>
	<?php } ?>
	</tbody>
	</table>
		<?php } ?>
</div>
</div>