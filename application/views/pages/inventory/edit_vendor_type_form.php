<div class="col-md-8 col-md-offset-2">

	<?php if((isset($mode))&&(($mode)=="select")){ ?>
	<center>	<h3>Edit  Vendor Type </h3></center><br>
	<?php echo form_open('vendor/edit/vendor_type',array('role'=>'form')); ?>
		

		<div class="form-group">
		<label for="vendor_type" class="col-md-4"> Vendor Type  Name<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder=" Vendor Type Name" id="vendor_type" name="vendor_type" 
		<?php if(isset($vendor_types)){
			echo "value='".$vendor_types[0]->vendor_type."' ";
			}
		?>
		/>
		<?php if(isset($vendor_types)) { ?>
		<input type="hidden" value="<?php echo $vendor_types[0]->vendor_type_id;?>" name="vendor_type_id" />
		
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
	<?php echo form_open('vendor/edit/vendor_type',array('role'=>'form','id'=>'search_form','class'=>'form-inline','name'=>'search_vendor_type'));?>
	<h3> Search Vendor Type </h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td><input type="text" class="form-control" placeholder="Vendor Type" id="vendor_type" name="vendor_type"> 
		
		
				<td><input class="btn btn-lg btn-primary btn-block" name="search" value="Search" type="submit" /></td></tr>
	</tbody>
	</table>
	</form>
	<?php if(isset($mode)&&$mode=="search"){    ?>

	<h3 class="col-md-12">List of Vendor Type</h3>
	<div class="col-md-12 ">
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th>Vendor Type Name </th>
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach($vendor_types as $a){ ?>
	<?php echo form_open('vendor/edit/vendor_type',array('id'=>'select_vendor_type_form_'.$a->vendor_type_id,'role'=>'form')); ?>
	<tr onclick="$('#select_vendor_type_form_<?php echo $a->vendor_type_id;?>').submit();" >
		<td><?php echo $i++; ?></td>
		<td><?php echo $a->vendor_type; ?>
		<input type="hidden" value="<?php echo $a->vendor_type_id; ?>" name="vendor_type_id" />
		<input type="hidden" value="select" name="select" />
		</td>
			</tr>
	</form>
	<?php } ?>
	</tbody>
	</table>
	<?php } ?>
	</div></div>
