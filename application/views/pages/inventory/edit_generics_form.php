<div class="col-md-8 col-md-offset-2">
	
	<?php if(isset($mode)&& $mode=="select"){ ?>
	<center>	<h3>Edit Generic</h3></center><br>
	<?php echo validation_errors(); echo form_open('consumables/edit/generics',array('role'=>'form')); ?>





		<div class="form-group">
		<label for="agency_name" class="col-md-4">Generic Name</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Generic Name" id="agency_name" name="generic_name" 
		<?php if(isset($generic)){
			echo "value='".$generic[0]->generic_name."' ";
			}
		?>
		/>
		<?php if(isset($generic)){ ?>
		<input type="hidden" value="<?php echo $generic[0]->generic_item_id;?>" name="generic_item_id" />
		
		<?php } ?>
		</div>
	</div>
	<div class="form-group">
		<label for="item_type" class="col-md-4" >Item Type</label>
		<div  class="col-md-8">
		<select name="item_type" id="item_type" class="form-control">
		<option value="">--SELECT--</option>
		<?php foreach($item_type as $e){
			echo "<option value='$e->item_type_id'";
			if(isset($generic) && $generic[0]->item_type_id==$e->item_type_id)
				echo " SELECTED ";
			echo ">$e->item_type</option>";
		}
		?>
		</select>
		</div>
	</div>	
				

			<div class="form-group">
		<label for="drug_type" class="col-md-4">Drug Type</label>
		<div  class="col-md-8">
	<select name="drug_type" id="drug_type" class="form-control">
		<option value="">Drugs</option>
		<?php foreach($drug_type as $d){
			echo "<option value='$d->drug_type_id'";
		if(isset($generic) && $generic[0]->drug_type_id==$d->drug_type_id)
				echo "SELECTED";
			echo ">$d->drug_type</option>";
		
			
		}
		?>
		</select>
			
	
	</div></div>
   		<div class="col-md-3 col-md-offset-4"><div  class="col-md-8">
	<input class="btn btn-lg btn-primary btn-block" type="submit" value="Update" name="update">
	</div></div>
	
   	</form>
	<?php } ?>
	<h3><?php if(isset($msg)) echo $msg;?></h3>	
	<div class="col-md-12">
	<?php echo form_open('consumables/edit/generics',array('role'=>'form','id'=>'search_form','class'=>'form-inline','name'=>'search_generic'));?>
	<h3> Search Generic </h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>

		<td>
<input type="text" class="form-control" placeholder="Generic Name" id="agency_name" name="generic_name" >
		
</td>		
		<td><input class="btn btn-lg btn-primary btn-block" name="search" value="Search" type="submit" /></td></tr>
	</tbody>
	</table>
	</form>
	<?php if(isset($mode) && $mode=="search"){ ?>

	<h3 class="col-md-12">List of Generic Types</h3>
	<div class="col-md-12 "><strong>
	<?php if($this->input->post('generic_name')) echo "generic name starting with : ".$this->input->post('generic_name'); ?>
	</strong>
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th>Generic Name </th><th>Item Type</th><th>Drug Type</th>
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach($generic as $a){ ?>
	<?php echo form_open('consumables/edit/generics',array('id'=>'select_generic_form_'.$a->generic_item_id,'role'=>'form')); ?>
	<tr onclick="$('#select_generic_form_<?php echo $a->generic_item_id;?>').submit();" >
		<td><?php echo $i++; ?></td>
		<td><?php echo $a->generic_name; ?>
		<input type="hidden" value="<?php echo $a->generic_item_id; ?>" name="generic_item_id" />
		<input type="hidden" value="select" name="select" />
		</td>
		<td><?php echo $a->item_type; ?>



		</td>
		
		<td><?php echo $a->drug_type; ?></td>
		
			</tr>
	</form>
	<?php } ?>
	</tbody>
	</table>
	<?php } ?>
	</div></div></div>