
	<?php if(isset($mode)&& $mode=="select"){ ?>
	<center>	<h3><u>Edit Vendor</u></h3></center><br>
	<?php echo form_open('masters/edit/vendor',array('role'=>'form')); ?>
<div class="form-group">
		<label for="states" class="col-md-4" >vendor</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="vendor" id="department_name" name=s"vendor_name" 
		<?php if(isset($vendor)){
			echo "value='".$vendor[0]->vendor_name."' ";
			}
		?>
		/>
		<?php if(isset($vendor)){ ?>
		<input type="hidden" value="<?php echo $vendor[0]->vendor_id;?>" name="vendor_id" />
		
	 <?php } ?>
		</div>
		
	</div>	
	
	<!--<div class="form-group">
		<label for="facility_type" class="col-md-4" >Area Type</label>
		<div  class="col-md-8">
		<select name="facility_type" id="facility_type" class="form-control">
		<option value="">--SELECT--</option>
		<?php /*foreach($facility_types as $facility_type){
			echo "<option value='$facility_type->facility_type_id'";
			if(isset($facility) && $facility[0]->facility_type_id==$facility_type->facility_type_id)
				echo " SELECTED ";
			echo ">$facility_type->facility_type</option>";
		}*/
		?>
		</select>
		</div>
	
		

	</div> -->
   	<div class="col-md-3 col-md-offset-4"><div class="col-md-8">
	<input class="btn btn-lg btn-primary btn-block" type="submit" value="Update" name="update">
	</div>
	</div>
	</form>
	<?php } ?>
	<h3><?php if(isset($msg)) echo $msg;?></h3>	
	<div class="col-md-12">
	<?php echo form_open('masters/edit/vendor',array('role'=>'form','class'=>'form-inline','name'=>'search_vendor'));?>
	<h3> Search vendor</h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td>	<input type="text" class="form-control" placeholder="vendor" id="vendor_name" name="vendor" >
	
		
</td>		

		<td><input class="btn btn-lg btn-primary btn-block" name="search" value="Search" type="submit" /></td></tr>
	</tbody>
	</table>
	</form>
	<?php if(isset($mode) && $mode=="search"){ ?>

	<h3 class="col-md-12">List of Vendor</h3>
	<div class="col-md-12 "><strong>
	<?php if($this->input->post('search_vendor_name')) echo "vendor : ".$vendor[0]->vendor; ?>
	<?php if($this->input->post('search_vendor_name')) echo "vendor starting with : ".$this->input->post('search_vendor_name'); ?>
	
	</strong>
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th>Vendor
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach($vendor as $a){ ?>
	<?php echo form_open('masters/edit/vendor',array('id'=>'select_vendor_form_'.$a->vendor_id,'role'=>'form')); ?>
	<tr onclick="$('#select_vendor_form_<?php echo $a->vendor_id;?>').submit();" >
		<td><?php echo $i++; ?></td>
		<td><?php echo $a->vendor_name; ?>
		<input type="hidden" value="<?php echo $a->vendor_id; ?>" name="vendor_id" />
		<input type="hidden" value="select" name="select" />
		</td>
		<!--<td><?php echo $a->vendor; ?></td>-->
		
	</tr>
	</form>
	<?php } ?>
	</tbody>
	</table>
	<?php } ?>
	</div>a