	
	<?php if(isset($mode)&& $mode=="select"){ ?>
	<center>	<h3><u>Edit Vendor Contracts</u></h3></center><br>
	<?php echo form_open('masters/edit/vendor_contracts',array('role'=>'form')); ?>





		<div class="form-group">
		<label for="agency_name" class="col-md-4">form_date</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="from_date" id="from_date" name="from_date" 
		<?php if(isset($vendor_contracts)){
			echo "value='".$vendor_contracts[0]->from_date."' ";
			}
		?>
		/>
		<?php if(isset($vendor_contracts)){ ?>
		<input type="hidden" value="<?php echo $vendor_contracts[0]->contracts_id;?>" name="contracts_id" />
		
	 <?php } ?>
		</div>
	</div>

			
	
	</div></div>
   		<div class="col-md-3 col-md-offset-4"><div  class="col-md-8">
	<input class="btn btn-lg btn-primary btn-block" type="submit" value="Update" name="update">
	</div></div>
	
   	</form>
	<?php } ?>
	<h3><?php if(isset($msg)) echo $msg;?></h3>	
	<div class="col-md-12">
	<?php echo form_open('masters/edit/vendor_contracts',array('role'=>'form','id'=>'search_form','class'=>'form-inline','name'=>'search_vendor_contracts'));?>
	<h3> Search Vendor Conteacts </h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>

		<td>
<input type="text" class="form-control" placeholder="Vendor Name " id="vendor_name" name="vendor_name" >
		
<!--	<select name="department_name" id="search_department_name" form='search_form' class="form-control" style="width:180px">
		<option value="" disabled selected>Department</option>
		<?php foreach($department as $department_name){
	echo "<option value='$vendor_name->contrat_id'>$vendor_name->vendor_name</option>";
		}
		?>
		</select>--></td>		
		   	<div class="col-md-3 col-md-offset-4"><div class="col-md-8">

		<td><input class="btn btn-lg btn-primary btn-block" name="search" value="Search" type="submit" /></td></tr>
	</tbody>
	</table>
	</form>
	<?php if(isset($mode) && $mode=="search"){ ?>

	<h3 class="col-md-12">List of Vendor Contracts</h3>
	<div class="col-md-12 "><strong>
	<?php if($this->input->post('vendor_name')) echo "from date starting with : ".$this->input->post('vendor_name'); ?>
	</strong>
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th>Vendor Name </th><th>
	<th>Vendor Name </th><th>
	</thead>
	<?php 
	$i=1;
	foreach($vendor_contracts as $a){ ?>
	<?php echo form_open('masters/edit/vendor_contracts',array('id'=>'select_vendor_contracts_form_'.$a->contract_id,'role'=>'form')); ?>
	<tr onclick="$('#select_vendor_contracts_form_<?php echo $a->contract_id;?>').submit();" >
		<td><?php echo $i++; ?></td>
		<td><?php echo $a->vendor_name; ?>
		<td><?php echo $a->facility_name; ?>
		<input type="hidden" value="<?php echo $a->contract_id; ?>" name="contract_id" />
		<input type="hidden" value="select" name="select" />
		</td>
		<td><?php echo $a->vendor_name; ?></td>
				<td><?php echo $a->facility_name; ?></td>

		
			</tr>
	</form>
	<?php } ?>
	</tbody>
	</table>
	<?php } ?>
	</div></div>