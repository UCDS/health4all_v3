<div class="col-md-8 col-md-offset-2">
	<?php if((isset($mode))&&(($mode)=="select")){ ?>
	<center><h3>Edit Group Name </h3></center><br>
	<?php echo form_open('diagnostics/edit/test_group',array('role'=>'form')); ?>
	
		<div class="form-group">
		<label for="test_group" class="col-md-4">Group Name<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Group Name" id="group_name" name="group_name" 
		<?php if(isset($test_groups)){
			echo "value='".$test_groups[0]->group_name."' ";
			}
		?>
		/>
		<?php if(isset($test_groups)) { ?>
		<input type="hidden" value="<?php echo $test_groups[0]->group_id;?>" name="test_group_id" />
		
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
	<?php echo form_open('diagnostics/edit/test_group',array('role'=>'form','id'=>'test_group_form','class'=>'form-inline','name'=>'search_test_group'));?>
	<h3> Search Group Name</h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td><input type="text" class="form-control" placeholder="Group Name" id="group_name" name="group_name"> 
				<td><input class="btn btn-lg btn-primary btn-block" name="search" id="search" value="Search" type="submit" /></td>
	</tr>
	</tbody>
	</table>
	</form>
<?php if(isset($mode) && $mode=="search"){   ?>

	<h3 class="col-md-12">List of Test Method Types </h3>
	<div class="col-md-12 ">
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th> Test Methods </th>
	</thead>
	<tbody>
	<?php 
	$j=1;
	foreach($test_groups as $tg){ ?>

	<?php echo form_open('diagnostics/edit/test_group',array('id'=>'test_group_form_'.$tg->group_id,'role'=>'form')); ?>
	<tr onclick="$('#test_group_form_<?php echo $tg->group_id;?>').submit();" >
		<td><?php echo $j++; ?></td>
		<td><?php echo $tg->group_name; ?>
		<input type="hidden" value="<?php echo $tg->group_id; ?>" name="test_group_id"/>
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