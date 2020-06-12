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
	<center>	<h3>Edit  Contact Person </h3></center><br>
	
<div class="col-md-8 col-md-offset-2">
	
	<center>
		<?php echo validation_errors(); ?>
	</center>
	<?php 
	//$staff = $staff[0]; 
	//What is form_open ?
	echo form_open('vendor/edit/contact_person',array('class'=>'form-horizontal','role'=>'form','id'=>'edit_contact_person')); 
	?>

	<div class="form-group">
		<input type='hidden' name='contact_person_id' value='<?php echo $contact_persons[0]->contact_person_id; ?>' />
		<div class="col-md-3">
			<label for="contact_person_first_name" class="control-label">First Name<font color='red'>*</font></label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="First Name" id="contact_person_first_name"  name="contact_person_first_name" required 
			value="<?php echo $contact_persons[0]->contact_person_first_name; ?>"/>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-3">
			<label for="contact_person_last_name" class="control-label">Last Name</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder=" Last Name" id="contact_person_last_name" name="contact_person_last_name" required 
			value="<?php echo $contact_persons[0]->contact_person_last_name; ?>"/>
		</div>
	</div>

	
	<div class="form-group">
		<div class="col-md-3">
			<label class="control-label">Gender</label>
		</div>
		<?php $gender = $contact_persons[0]->gender; ?>
		<div class="col-md-6">
			<label class="control-label">
				<input type="radio" name="gender" value="M" 
				<?php 
				if($gender == 'M')
				{
					echo 'checked';
				} ?> 
			/> Male
			</label>
			<label class="control-label">
				<input type="radio" name="gender" value="F" 
				<?php 
				if($gender == 'F')
				{
					echo 'checked';
				} ?> 
				/> Female
			</label>
			<label class="control-label">
				<input type="radio" name="gender" value="O" 
				<?php 
				if($gender == '')
				{
					echo 'checked';
				} ?> 
				/> Other
			</label>
		</div>
	</div>	
	
	<div class="form-group">
		<div class="col-md-3">
			<label for="contact_person_email" class="control-label">Email</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder=" Email" id="contact_person_" name="contact_person_email"  
			value="<?php echo $contact_persons[0]->contact_person_email; ?>"/>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-3">
			<label for="contact_person_contact" class="control-label">Phone Number<font color='red'>*</font></label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder=" Email" id="contact_person_contact" name="contact_person_contact" required
			value="<?php echo $contact_persons[0]->contact_person_contact; ?>"/>
		</div>
	</div>
	
	
	<div class="form-group">
		<div class="col-md-3">
			<label for="contact_person_designation" class="control-label">Designation</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder=" Email" id="contact_person_designation" name="contact_person_designation"  
			value="<?php echo $contact_persons[0]->designation; ?>"/>
		</div>
	</div>
	
	<div class="form-group">
	<?php //echo var_dump($vendors); ?>
		<div class="col-md-3">
			<label for="vendor_id" >Vendor</label>
		</div>
	
		<div class="col-md-6">
			<select name="vendor_id" id="vendor_id" class="form-control">
		<option value="">--select--</option>
		<?php foreach($vendors as $d){
			echo " <option value=' $d->vendor_id'   ";
			if($contact_persons[0]->vendor_id == $d->vendor_id)
			{
				echo "selected";
			}
			echo " >$d->vendor_name</option>";
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
	<?php echo form_open('vendor/edit/contact_person',array('role'=>'form','id'=>'search_form','class'=>'form-inline','name'=>'search_contact_person'));?>
	<h3> Search Contact person</h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td><input type="text" class="form-control" placeholder=" Name " id="contact_person_name" name="contact_person_name_search"> 
		
		
				<td><input class="btn btn-lg btn-primary btn-block" name="search" value="Search" type="submit" /></td></tr>
	</tbody>
	</table>
	</form>
	<?php if(isset($mode)&&$mode=="search"){    ?>

	<h3 class="col-md-12">List of Contact Persons</h3>
	<div class="col-md-12 ">
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th>Name </th>
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach($contact_persons as $a){ ?>
	<?php echo form_open('vendor/edit/contact_person',array('id'=>'select_contact_person_form_'.$a->contact_person_id,'role'=>'form')); ?>
	<tr onclick="$('#select_contact_person_form_<?php echo $a->contact_person_id;?>').submit();" >
		<td><?php echo $i++; ?></td>
		<td><?php echo $a->contact_person_first_name. " ". $a->contact_person_last_name; ?>
		<input type="hidden" value="<?php echo $a->contact_person_id; ?>" name="contact_person_id" />
		<input type="hidden" value="select" name="select" />
		</td>
			</tr>
	</form>
	<?php } ?>
	</tbody>
	</table>
	<?php } ?>
	</div></div>
