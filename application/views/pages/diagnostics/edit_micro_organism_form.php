<div class="col-md-8 col-md-offset-2">
	<?php if((isset($mode))&&(($mode)=="select")){ ?>
	<center><h3>Edit Micro Organism </h3></center><br>
	<?php echo form_open('diagnostics/edit/micro_organism',array('role'=>'form')); ?>
	
		<div class="form-group">
		<label for="micro_organism" class="col-md-4">Micro Organism<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Micro Organism" id="micro_organism" name="micro_organism" 
		<?php if(isset($micro_organisms)){
			echo "value='".$micro_organisms[0]->micro_organism."' ";
			}
		?>
		/>
		<?php if(isset($micro_organisms)) { ?>
		<input type="hidden" value="<?php echo $micro_organisms[0]->micro_organism_id;?>" name="micro_organism_id" />
		
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
	<?php echo form_open('diagnostics/edit/micro_organism',array('role'=>'form','id'=>'micro_organism_form','class'=>'form-inline','name'=>'micro_organism'));?>
	<h3> Search Micro Organism</h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td><input type="text" class="form-control" placeholder="Micro Organismm" id="micro_organism" name="micro_organism"> 
				<td><input class="btn btn-lg btn-primary btn-block" name="search" id="search" value="Search" type="submit" /></td>
	</tr>
	</tbody>
	</table>
	</form>
<?php if(isset($mode) && $mode=="search"){   ?>

	<h3 class="col-md-12">List of Micro Organisms </h3>
	<div class="col-md-12 ">
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th> Micro Organism</th>
	</thead>
	<tbody>
	<?php 
	$j=1;
	foreach($micro_organisms as $tg){ ?>

	<?php echo form_open('diagnostics/edit/micro_organism',array('id'=>'micro_organism_form_'.$tg->micro_organism_id,'role'=>'form')); ?>
	<tr onclick="$('#micro_organism_form_<?php echo $tg->micro_organism_id;?>').submit();" >
		<td><?php echo $j++; ?></td>
		<td><?php echo $tg->micro_organism; ?>
		<input type="hidden" value="<?php echo $tg->micro_organism_id; ?>" name="micro_organism_id"/>
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