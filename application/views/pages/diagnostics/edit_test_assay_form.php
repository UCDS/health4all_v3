<div class="col-md-8 col-md-offset-2">
	<?php if((isset($mode))&&(($mode)=="select")){ ?>
	<center><h3>Edit Assay </h3></center><br>
	<?php echo form_open('diagnostics/edit_assay_name',array('role'=>'form')); ?>
	
		<div class="form-group">
		<label for="assay" class="col-md-4">Assay Name<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Test Area" id="assay" name="assay" 
		<?php if(isset($assays)){
			echo "value='".$assays[0]->assay."' ";
			}
		?>
		/>
		<?php if(isset($assays)) { ?>
		<input type="hidden" value="<?php echo $assays[0]->assay_id;?>" name="assay_id" />
		
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
	<?php echo form_open('diagnostics/edit_assay_name',array('role'=>'form','id'=>'test_area_form','class'=>'form-inline','name'=>'edit_assay_name'));?>
	<h3> Search Assay</h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td><input type="text" class="form-control" placeholder="Assay" id="assay" name="assay"> 
		<td><input class="btn btn-lg btn-primary btn-block" name="search" id="search" value="Search" type="submit" /></td>
	</tr>
	</tbody>
	</table>
	</form>
<?php if(isset($mode) && $mode=="search"){   ?>

	<h3 class="col-md-12">List of Assays </h3>
	<div class="col-md-12 ">
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th> Assay</th>
	</thead>
	<tbody>
	<?php 
	$j=1;
	if(isset($assays))
	foreach($assays as $assay){ ?>

	<?php echo form_open('diagnostics/edit/test_area',array('id'=>'test_area_form_'.$assay->assay_id,'role'=>'form')); ?>
	<tr onclick="$('#test_assay_form_<?php echo $assay->assay_id;?>').submit();" >
		<td><?php echo $j++; ?></td>
		<td><?php echo $assay->assay; ?>
		<input type="hidden" value="<?php echo $assay->assay_id; ?>" name="assay_id"/>
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