<div class="col-md-8 col-md-offset-2">
	<?php if((isset($mode))&&(($mode)=="select")){ ?>
	<center><h3>Edit Test Area </h3></center><br>
	<?php echo form_open('diagnostics/edit/test_area',array('role'=>'form')); ?>
	
		<div class="form-group">
		<label for="test_area" class="col-md-4">Test Area<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Test Area" id="test_area" name="test_area" 
		<?php if(isset($test_areas)){
			echo "value='".$test_areas[0]->test_area."' ";
			}
		?>
		/>
		<?php if(isset($test_areas)) { ?>
		<input type="hidden" value="<?php echo $test_areas[0]->test_area_id;?>" name="test_area_id" />
		
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
	<?php echo form_open('diagnostics/edit/test_area',array('role'=>'form','id'=>'test_area_form','class'=>'form-inline','name'=>'test_area'));?>
	<h3> Search Test Area</h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td><input type="text" class="form-control" placeholder="Test Area" id="test_area" name="test_area"> 
				<td><input class="btn btn-lg btn-primary btn-block" name="search" id="search" value="Search" type="submit" /></td>
	</tr>
	</tbody>
	</table>
	</form>
<?php if(isset($mode) && $mode=="search"){   ?>

	<h3 class="col-md-12">List of Test Areas </h3>
	<div class="col-md-12 ">
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th> Test Area</th>
	</thead>
	<tbody>
	<?php 
	$j=1;
	foreach($test_areas as $tg){ ?>

	<?php echo form_open('diagnostics/edit/test_area',array('id'=>'test_area_form_'.$tg->test_area_id,'role'=>'form')); ?>
	<tr onclick="$('#test_area_form_<?php echo $tg->test_area_id;?>').submit();" >
		<td><?php echo $j++; ?></td>
		<td><?php echo $tg->test_area; ?>
		<input type="hidden" value="<?php echo $tg->test_area_id; ?>" name="test_area_id"/>
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