<div class="col-md-8 col-md-offset-2">
	<?php if((isset($mode))&&(($mode)=="select")){ ?>
	<center><h3>Edit Test Name </h3></center><br>
	<?php echo form_open('diagnostics/edit/test_name',array('role'=>'form')); ?>
		<div class="form-group">
		<label for="test_method" class="col-md-4" >Test Method</label>
		<div  class="col-md-8">
		<select name="test_method" id="test_method" class="form-control">
		<option value="">--SELECT--</option>
		<?php foreach($test_methods as $e){
			echo "<option value='$e->test_method_id'";
			if(isset($test_names) && $test_names[0]->test_method_id==$e->test_method_id)
				echo " SELECTED ";
			echo ">$e->test_method</option>";
		}
		?>
		</select>
		</div>
			</br>
	</br>

		<label for="test_name" class="col-md-4">Test Name<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Test Name" id="test_name" name="test_name" 
		<?php if(isset($test_names)){
			echo "value='".$test_names[0]->test_name."' ";
			}
		?>
		/>
		<?php if(isset($test_names)) { ?>
		<input type="hidden" value="<?php echo $test_names[0]->test_master_id;?>" name="test_master_id" />
		
		<?php } ?>
		</div>
	</div>
   	<div class="col-md-3 col-md-offset-4">
	</br>
	<input class="btn btn-lg btn-primary btn-block" type="submit" value="Update" name="update">
	</div>
	</form>
	<?php } ?>
	
	<h3><?php if(isset($msg)) echo $msg;?></h3>	
	<div class="col-md-12">
	<?php echo form_open('diagnostics/edit/test_name',array('role'=>'form','id'=>'test_name_form','class'=>'form-inline','name'=>'test_name'));?>
	<h3> Search Test Name</h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td><input type="text" class="form-control" placeholder="Test Name" id="test_name" name="test_name"> 
				<td><input class="btn btn-lg btn-primary btn-block" name="search" id="search" value="Search" type="submit" /></td>
	</tr>
	</tbody>
	</table>
	</form>
<?php if(isset($mode) && $mode=="search"){   ?>

	<h3 class="col-md-12">List of Test Names </h3>
	<div class="col-md-12 ">
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th> Test Name</th>
	</thead>
	<tbody>
	<?php 
	$j=1;
	foreach($test_names as $tg){ ?>

	<?php echo form_open('diagnostics/edit/test_name',array('id'=>'test_name_form_'.$tg->test_master_id,'role'=>'form')); ?>
	<tr onclick="$('#test_name_form_<?php echo $tg->test_master_id;?>').submit();" >
		<td><?php echo $j++; ?></td>
		<td><?php echo $tg->test_name; ?>
		<input type="hidden" value="<?php echo $tg->test_master_id; ?>" name="test_master_id"/>
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