<div class="col-md-8 col-md-offset-2">
	<?php if((isset($mode))&&(($mode)=="select")){ ?>
	<center><h3>Edit Sample Status </h3></center><br>
	<?php echo form_open('diagnostics/edit/sample_status',array('role'=>'form')); ?>
	
		<div class="form-group">
		<label for="sample_status" class="col-md-4">Sample Status<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Sample Status" id="sample_status" name="sample_status" 
		<?php if(isset($sample_statuses)){
			echo "value='".$sample_statuses[0]->sample_status."' ";
			}
		?>
		/>
		<?php if(isset($sample_statuses)) { ?>
		<input type="hidden" value="<?php echo $sample_statuses[0]->sample_status_id;?>" name="sample_status_id" />
		
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
	<?php echo form_open('diagnostics/edit/sample_status',array('role'=>'form','id'=>'sample_status_form','class'=>'form-inline','name'=>'sample_status'));?>
	<h3> Search Sample Status</h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td><input type="text" class="form-control" placeholder="Sample Status" id="sample_status" name="sample_status"> 
				<td><input class="btn btn-lg btn-primary btn-block" name="search" id="search" value="Search" type="submit" /></td>
	</tr>
	</tbody>
	</table>
	</form>
<?php if(isset($mode) && $mode=="search"){   ?>

	<h3 class="col-md-12">List of Sample Status </h3>
	<div class="col-md-12 ">
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th> Sample Status </th>
	</thead>
	<tbody>
	<?php 
	$j=1;
	foreach($sample_statuses as $tg){ ?>

	<?php echo form_open('diagnostics/edit/sample_status',array('id'=>'sample_status_form_'.$tg->sample_status_id,'role'=>'form')); ?>
	<tr onclick="$('#sample_status_form_<?php echo $tg->sample_status_id;?>').submit();" >
		<td><?php echo $j++; ?></td>
		<td><?php echo $tg->sample_status; ?>
		<input type="hidden" value="<?php echo $tg->sample_status_id; ?>" name="sample_status_id"/>
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