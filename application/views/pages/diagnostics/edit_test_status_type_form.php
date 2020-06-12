<div class="col-md-8 col-md-offset-2">
	<?php if((isset($mode))&&(($mode)=="select")){ ?>
	<center><h3>Edit Test Status Type </h3></center><br>
	<?php echo form_open('diagnostics/edit/test_status_type',array('role'=>'form')); ?>
	
		<div class="form-group">
		<label for="test_status_type" class="col-md-4">Test Status Type<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Sample Status" id="test_status_type" name="test_status_type" 
		<?php if(isset($test_status_types)){
			echo "value='".$test_status_types[0]->test_status_type."' ";
			}
		?>
		/>
		<?php if(isset($test_status_types)) { ?>
		<input type="hidden" value="<?php echo $test_status_type[0]->test_status_type_id;?>" name="test_status_type_id" />
		
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
	<?php echo form_open('diagnostics/edit/test_status_type',array('role'=>'form','id'=>'test_status_type_form','class'=>'form-inline','name'=>'test_status_type'));?>
	<h3> Search Test Status Type</h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td><input type="text" class="form-control" placeholder="Test Status Type" id="test_status_type" name="test_status_type"> 
				<td><input class="btn btn-lg btn-primary btn-block" name="search" id="search" value="Search" type="submit" /></td>
	</tr>
	</tbody>
	</table>
	</form>
<?php if(isset($mode) && $mode=="search"){   ?>

	<h3 class="col-md-12">List of Test Status Types </h3>
	<div class="col-md-12 ">
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th> Test Status Type </th>
	</thead>
	<tbody>
	<?php 
	$j=1;
	foreach($test_status_types as $tg){ ?>

	<?php echo form_open('diagnostics/edit/test_status_type',array('id'=>'test_status_type_form_'.$tg->test_status_type_id,'role'=>'form')); ?>
	<tr onclick="$('#test_status_type_form_<?php echo $tg->test_status_type_id;?>').submit();" >
		<td><?php echo $j++; ?></td>
		<td><?php echo $tg->test_status_type; ?>
		<input type="hidden" value="<?php echo $tg->test_status_type_id; ?>" name="test_status_type_id"/>
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