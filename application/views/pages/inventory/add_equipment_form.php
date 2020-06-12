<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<style>

</style>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript">
$(function(){
	$("#warranty_start_date,#warranty_end_date").Zebra_DatePicker();
	$("#supply_date").Zebra_DatePicker({
		onSelect : function(date){
		$("#warranty_start_date").val(date);
		}
	});
	$("#department").on('change',function(){
		var department_id=$(this).val();
		$("#unit option,#area option").hide();
		$("#unit option[class="+department_id+"],#area option[class="+department_id+"]").show();
	});
	//$("#vendor").on('change',function(){
	//	var vendor_id=$(this).val();
	//	$("#contact_person_id option").hide();
	//	$("#contact_person_id option[class="+vendor_id+"]").show();
	//});
});
</script>

<div class="col-md-8 col-md-offset-2">
 
	<center>
		<strong><?php if(isset($msg)){ echo $msg;}?></strong>
		<h3><i class="glyph-icon flaticon-medical-equipment" ></i>  Add Equipment Details</h3>
	</center><br>
	
	<center>
		<?php echo validation_errors(); ?>
	</center>
	<?php 
	echo form_open('equipments/add/equipment',array('class'=>'form-horizontal','role'=>'form','id'=>'add_equipment')); 
	?>
	
	

	<div class="form-group">
		<div class="col-md-3">
			<label for="equpiment" >Equiment Type<font color='red'>*</font></label>
		</div>
		<div class="col-md-6">
			<select name="equipment_type" id="division" class="form-control">
		<option value="">Equipment Type</option>
		<?php foreach($equipment_types as $d){
			echo "<option value='$d->equipment_type_id'>$d->equipment_type</option>";
		}
		?>
		</select>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-3">
			<label for="description" > Make</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder=" Make" id="description" name="make" />
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-3">
			<label for="description" > Model</label>
		</div>
		<div class="col-md-6">
		<input type="text" class="form-control" placeholder=" Model" id="description" name="model" />
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-3">
			<label for="description" > Serial Number</label>
		</div>
		<div class="col-md-6">
		<input type="text" class="form-control" placeholder=" Serial Number" id="description" name="serial_number" />
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-3">
			<label for="description" > Asset Number</label>
		</div>
		<div class="col-md-6">
		<input type="text" class="form-control" placeholder=" Asset Number" id="description" name="asset_number" />
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-3">
			<label for="description"> Procured By</label>
		</div>
		<div class="col-md-6">
		<input type="text" class="form-control" placeholder=" Procured By" id="description" name="procured_by" />
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-3">
			<label for="description" > Cost</label>
		</div>
		<div class="col-md-6">
		<input type="text" class="form-control" placeholder="Cost" id="cost" name="cost" />
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-3">
			<label for="vendor" >Vendor<font color='red'></font></label>
		</div>
		<div class="col-md-6">
			<select name="vendor" id="vendor" class="form-control">
		<option value="">--select--</option>
		<?php foreach($vendors as $d){
			echo "<option value='$d->vendor_id'>$d->vendor_name</option>";
		}
		?>
		</select>
		
		</div>
	</div>
	
		
	
	<div class="form-group">
		<div class="col-md-3">
			<label for="contact_person_id" > Contact Person</label>
		</div>
		<div class="col-md-6">
			<select name="contact_person" id="contact_person_id" class="form-control">
		<option value="">--select--</option>
		<?php foreach($contact_persons as $d){
			echo "<option value='$d->contact_person_id' class='$d->vendor_id' >$d->contact_person_first_name  $d->contact_person_last_name</option>";
		}
		?>
		</select>
		</div>
	</div>
	
		
	<div class="form-group">
	<div class="col-md-3">
		<label for="supply_date" > Supply Date</label>
		</div>
		<div  class="col-md-6">
		<input type="text" class="form-control date" placeholder="Supply Date" id="supply_date" form="add_equipment" name="supply_date" />
		</div>
	</div>
	<div class="form-group">
	<div class="col-md-3">
		<label for="description" > Warranty Period</label>
		</div>
		<div  class="col-md-6">
		<input type="text" class="form-control date" placeholder="Start" form="add_equipment" id="warranty_start_date" name="warranty_start_date" />
		<input type="text" class="form-control date" placeholder="End"  form="add_equipment" id="warranty_end_date" name="warranty_end_date" />
		</div>
	</div>
	<div class="form-group">
	<div class="col-md-3">
		<label for="supply_date" > 	Service Engineer</label>
		</div>
		<div  class="col-md-6">
		<input type="text" class="form-control date" placeholder="Service Engineer" id="service_engineer" form="add_equipment" name="service_engineer" />
		</div>
	</div>
	<div class="form-group">
	<div class="col-md-3">
		<label for="supply_date" > 	Service Engineer Contact</label>
		</div>
		<div  class="col-md-6">
		<input type="text" class="form-control date" placeholder="	Service Engineer Contact" id="service_engineer_contact" form="add_equipment" name="service_engineer_contact" />
		</div>
	</div>
	
	<div class="form-group">
	<div class="col-md-3">
		<label for="agency_contact_name" >Department</label>
		</div>
		<div  class="col-md-6">
		<select name="department" id="department" class="form-control">
		<option value="">Department</option>
		<?php foreach($department as $d){
			echo "<option value='$d->department_id'>$d->department</option>";
		}
		?>
		</select>
		
		</div>
	</div>	
	
	<div class="form-group">
		<div class="col-md-3">
		<label for="area" >Area</label>
		</div>
		<div  class="col-md-6">
		<select name="area" id="area" class="form-control">
		<option value="">Area</option>
		<?php foreach($areas as $a){
			echo "<option value='$a->area_id' class='$a->department_id'>$a->area_name</option>";
		}
		?>
		</select>
		
		</div>
	</div>	
	
	<div class="form-group">
	<div class="col-md-3">
		<label for="unit" >Unit</label>
		</div>
		<div  class="col-md-6">
		<select name="unit" id="unit" class="form-control">
		<option value="">Unit</option>
		<?php foreach($units as $u){
			echo "<option value='$u->unit_id' class='$u->department_id'>$u->unit_name</option>";
		}
		?>
		</select>
		
		</div>
	</div>
	
	<input type="hidden" class="form-control" value='1' placeholder=" Service Engineer Contact" id="description" name="user" />
	
	<div class="form-group">
		<div class="col-md-3">
			<label for="equipment_status" >  Equipment Status</label>
		</div>
		<div class="col-md-6">
			<label class="control-label">
				<input type="radio" name="equipment_status" value="1" checked /> Working      
			</label>
			<label class="control-label">
				<input type="radio" name="equipment_status" value="0" /> Not Working
			</label>
		</div>
	</div>	

   	<div class="col-md-3 col-md-offset-4">
	<button class="btn btn-lg btn-primary btn-block" type="submit" value="submit">Submit</button>
	</div>
	
</i>
</div>