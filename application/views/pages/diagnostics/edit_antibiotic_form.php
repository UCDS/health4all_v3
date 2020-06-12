<div class="col-md-8 col-md-offset-2">
	<?php if((isset($mode))&&(($mode)=="select")){ ?>
	<center><h3>Edit Antibiotic </h3></center><br>
	<?php echo form_open('diagnostics/edit/antibiotic',array('role'=>'form')); ?>
	
		<div class="form-group">
		<label for="antibiotic" class="col-md-4">Antibiotic<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Antibiotic" id="antibiotic" name="antibiotic" 
		<?php if(isset($antibiotics)){
			echo "value='".$antibiotics[0]->antibiotic."' ";
			}
		?>
		/>
		<?php if(isset($antibiotics)) { ?>
		<input type="hidden" value="<?php echo $antibiotics[0]->antibiotic_id;?>" name="antibiotic_id" />
		
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
	<?php echo form_open('diagnostics/edit/antibiotic',array('role'=>'form','id'=>'antibiotic_form','class'=>'form-inline','name'=>'antibiotic'));?>
	<h3> Search Antibiotic</h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td><input type="text" class="form-control" placeholder="Antibiotic" id="antibiotic" name="antibiotic"> 
				<td><input class="btn btn-lg btn-primary btn-block" name="search" id="search" value="Search" type="submit" /></td>
	</tr>
	</tbody>
	</table>
	</form>
<?php if(isset($mode) && $mode=="search"){   ?>

	<h3 class="col-md-12">List of Antibodies </h3>
	<div class="col-md-12 ">
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th> Antibiotic</th>
	</thead>
	<tbody>
	<?php 
	$j=1;
	foreach($antibiotics as $tg){ ?>

	<?php echo form_open('diagnostics/edit/antibiotic',array('id'=>'antibiotic_form_'.$tg->antibiotic_id,'role'=>'form')); ?>
	<tr onclick="$('#antibiotic_form_<?php echo $tg->antibiotic_id;?>').submit();" >
		<td><?php echo $j++; ?></td>
		<td><?php echo $tg->antibiotic; ?>
		<input type="hidden" value="<?php echo $tg->antibiotic_id; ?>" name="antibiotic_id"/>
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