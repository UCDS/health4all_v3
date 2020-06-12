<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>

<div class="col-md-8 col-md-offset-2">
	
	
	<script type="text/javascript">
	$(function(){
		$("#date_of_birth").Zebra_DatePicker();
		$("#department").on('change',function(){
			var department_id=$(this).val();
			$("#unit option,#area option").hide();
			$("#unit option[class="+department_id+"],#area option[class="+department_id+"]").show();
		});
	});
	</script>
	<?php
	 
	 if((isset($mode))&&(($mode)=="select")){ 
	 //var_dump($unit);
	 //($area); ?>
	<center>	<h3>Edit  Vendor </h3></center><br>
	
<div class="col-md-8 col-md-offset-2">
	
	<center>
		<?php echo validation_errors(); ?>
	</center>
	<?php 
	//$staff = $staff[0]; 
	//What is form_open ?
	echo form_open('vendor/edit/vendor',array('class'=>'form-horizontal','role'=>'form','id'=>'edit_vendor')); 
	?>

	<div class="form-group">
		<input type='hidden' name='vendor_id' value='<?php echo $vendors[0]->vendor_id; ?>' />
		<div class="col-md-3">
			<label for="vendor_name" class="control-label">Vendor Name<font color='red'>*</font></label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Vendor Name" id="vendor_name" name="vendor_name" required 
			value="<?php echo $vendors[0]->vendor_name; ?>"/>
		</div>
	</div>
	<div class="form-group">
		<label for="equipment_type_id" class="col-md-3"> City<font color='red'>*</font></label>

		<div class="col-md-6">
			<select name="equipment_type_id" id="equipment_type_id" class="form-control">
			<option value="">--select--</option>
			<?php foreach($equipment_types as $d){
				echo "<option value='$d->equipment_type_id'";
				if($vendors[0]->equipment_type_id == $d->equipment_type_id) {
					echo " selected ";
				}				
				echo ">$d->equipment_type</option>";
			}
			?>
			</select>		

		</div>
	</div>
	<div class="form-group">
		<div class="col-md-3">
			<label for="vendor_address" class="control-label">Address<font color='red'>*</font></label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder=" Address" id="vendor_address" name="vendor_address" required 
			value="<?php echo $vendors[0]->vendor_address; ?>"/>
		</div>
	</div>
	<div class="form-group">
		<label for="village_town_id" class="col-md-3"> City<font color='red'>*</font></label>

		<div class="col-md-6">
			<select name="village_town_id" id="village_town_id" class="form-control">
			<option value="">--select--</option>
			<?php foreach($village_towns as $d){
				echo "<option value='$d->village_town_id'";
				if($vendors[0]->village_town_id == $d->village_town_id) {
					echo " selected ";
				}				
				echo ">$d->village_town</option>";
			}
			?>
			</select>		

		</div>
	</div>
	<div class="form-group">
		<label for="vendor_state_id" class="col-md-3"> State<font color='red'>*</font></label>
		<div class="col-md-6">
			<select name="vendor_state_id" id="vendor_state_id" class="form-control">
			<option value="">--select--</option>
			<?php foreach($states as $d){
				echo "<option value='$d->state_id'";
				if($vendors[0]->vendor_state_id == $d->state_id) {
					echo " selected ";
				}			
				echo ">$d->state</option>";
			}
			?>
			</select>		

		</div>
	</div>
	<div class="form-group">
		<label for="vendor_country_id" class="col-md-3"> Country</label>
		<div class="col-md-6">

			<select name="vendor_country_id" id="vendor_country_id" class="form-control">
			<option value="">--select--</option>
			<?php 
			foreach($countries as $d){
				echo "<option value='$d->id'";

				if($d->id == $vendor[0]->vendor_country_id)
				{
					echo " selected ";
				}
				echo ">$d->country_name</option>";
			}
			?>
			</select>		
		</div>
	</div>

	<div class="form-group">
		<label for="account_no" class="col-md-3"> Bank Account Number</label>
		<div  class="col-md-6">
		<input type="text" class="form-control" placeholder=" Bank Account Number" id="account_no" name="account_no" 
		value="<?php echo $vendors[0]->account_no; ?>" />
		</div>
	</div>
	
	<div class="form-group">
		<label for="bank_name" class="col-md-3"> Bank Account Number</label>
		<div  class="col-md-6">
		<input type="text" class="form-control" placeholder=" Bank Name" id="bank_name" name="bank_name" 
		value="<?php echo $vendors[0]->bank_name; ?>" />
		</div>
	</div>
	<div class="form-group">
		<label for="branch" class="col-md-3"> Bank Branch</label>
		<div  class="col-md-6">
		<input type="text" class="form-control" placeholder=" Bank Branch" id="branch" name="branch" 
		value="<?php echo $vendors[0]->branch; ?>" />
		</div>
	</div>
	
	<div class="form-group">
		<label for="vendor_email" class="col-md-3"> Email</label>
		<div  class="col-md-6">
		<input type="text" class="form-control" placeholder=" Email" id="vendor_email" name="vendor_email" 
		value="<?php echo $vendors[0]->vendor_email; ?>" />
		</div>
	</div>
	
	<div class="form-group">
		<label for="vendor_phone" class="col-md-3"> Phone Number<font color='red'>*</font></label>
		<div  class="col-md-6">
		<input type="text" class="form-control" placeholder=" Phone Number" id="vendor_phone" name="vendor_phone" required
		value="<?php echo $vendors[0]->vendor_phone; ?>" />
		</div>
	</div>

	<div class="form-group">
		<label for="vendor_pan" class="col-md-3"> PAN</label>
		<div  class="col-md-6">
		<input type="text" class="form-control" placeholder=" PAN" id="vendor_pan" name="vendor_pan" 
		value="<?php echo $vendors[0]->vendor_pan; ?>" />
		</div>
	</div>
	
	<div class="form-group">
	<?php //echo var_dump($vendors); ?>
		<div class="col-md-3">
			<label for="contact_person_id" >Primary Contact Person<font color='red'>*</font></label>
		</div>
	
		<div class="col-md-6">
			<select name="contact_person_id" id="contact_person_id" class="form-control">

		<?php
		$size = sizeof($contact_persons);
		if( $size <= 0 )
			echo "<option value='0'>Please add atleast one contact person for this vendor</option>";
		else
		{
			echo "<option value=''>--select--</option>";
			foreach($contact_persons as $d){
				echo " <option value=' $d->contact_person_id'   ";
				if($contact_persons[0]->contact_person_id == $d->contact_person_id)
				{
					echo "selected";
				}
				echo ' > '. $d->contact_person_first_name .' '.  $d->contact_person_last_name .' </option>';
			}
		}
		?>
		</select>
		
		</div>
	</div>
	
	
	
   	<div class="col-md-3 col-md-offset-4">
	<input class="btn btn-lg btn-primary btn-block" type="submit" value="Update" name="update">
	</div>

	
   	
	</form>
	<?php } ?>
	<h3><?php if(isset($msg)) echo $msg;?></h3>	
	<div class="col-md-12">
	<?php echo form_open('vendor/edit/vendor',array('role'=>'form','id'=>'search_form','class'=>'form-inline','name'=>'search_vendor'));?>
	<h3> Search Vendor</h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td><input type="text" class="form-control" placeholder=" Name " id="vendor_name" name="vendor_name_search"> 
		
		
				<td><input class="btn btn-lg btn-primary btn-block" name="search" value="Search" type="submit" /></td></tr>
	</tbody>
	</table>
	</form>
	<?php if(isset($mode)&&$mode=="search"){    ?>

	<h3 class="col-md-12">List of Vendors</h3>
	<div class="col-md-12 ">
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th>Name </th>
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach($vendors as $a){ ?>
	<?php echo form_open('vendor/edit/vendor',array('id'=>'select_vendor_form_'.$a->vendor_id,'role'=>'form')); ?>
	<tr onclick="$('#select_vendor_form_<?php echo $a->vendor_id;?>').submit();" >
		<td><?php echo $i++; ?></td>
		<td><?php echo $a->vendor_name; ?>
		<input type="hidden" value="<?php echo $a->vendor_id; ?>" name="vendor_id" />
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














