<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<script type="text/javascript"
 src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script>
	$(function(){
		$("#slot_date").Zebra_DatePicker();
	});
</script>

<div class="col-md-10 col-sm-9" style="padding:5px;">

		<?php
		if(isset($msg)) {
			echo "<div class='alert alert-info'>$msg</div>";
		}
		?>	<div>
		<h4>Registered donors : </h4>
		<table class="table-2 table table-striped table-bordered">
			<tr><th>S.No</th><th>Name</th><th>Age</th><th>Blood Group</th><th>Phone</th><th></th></tr>
		<?php 
		$i=1;
		foreach($donors as $donor){
		?>
		<tr>
		<form>
			<td><?php echo $i;?></td>
			<td><?php echo $donor->name;?></td>
			<td><?php echo $donor->age;?></td>
			<td><?php if($donor->blood_group!='' && $donor->blood_group!='0'){  echo $donor->blood_group;}?></td>
			<td><?php echo $donor->phone;?></td>
			<td>
				<input type="submit" class="btn btn-primary btn-md" value="Update" formaction="<?php echo base_url();?>bloodbank/register/medical_checkup/0/<?php echo $donor->donation_id;?>" />
				<input type="button" class="btn btn-primary" value="X" data-toggle="modal" data-target="#myModal" />
		</form>
		</tr>
		<?php 
		$i++;
		}
		?>
		</table>
		<?php if(count($appointments)>0){ ?>
		<table class='table-2'>
			<tr><th colspan="10">Appointments for current slot</th></tr>
			<tr><th>App ID</th><th>Name</th><th>Age</th><th>Blood Group</th><th>Phone</th><th></th></tr>
		<?php 
		$i=1;
		foreach($appointments as $donor){
		?>
		<tr>
		<?php echo form_open('bloodbank/register/medical_checkup/'.$donor->donor_id);?>
			<td><?php echo $donor->appointment_id;?>
			<input type="text" value="<?php echo $donor->appointment_id;?>" name="appointment_id" hidden /></td>
			<td><?php echo $donor->name;?></td>
			<td><?php echo $donor->age;?></td>
			<td><?php if($donor->blood_group!="" && $donor->blood_group!='0'){ echo $donor->blood_group; }?></td>
			<td><?php echo $donor->phone;?></td>
			<td>
				<div class="form-group">
					<input type="submit" class="btn btn-link" value="Update" name="update" />
				</div>
				<div class="form-group">
					<input type="button" class="btn btn-primary" value="X"  name="x" /></div>
			</td>
		</form>
		</tr>
		<?php 
		$i++;
		}
		?>
		</table>
		<?php } ?>	
				<hr>

		<?php echo form_open('bloodbank/register/donation',array('class'=>'form-custom')); ?>
		<h5>Search for Appointments</h5> 
		<div class="form-group">
			<input type="text" placeholder="Slot date" class="form-control" name="slot_date" id="slot_date" />
		</div>
		<div class="form-group" style="text-indent:4cm;">
			<input type="text" placeholder="Appointment ID" class="form-control" name="app_id" />
		</div>
		<div class="form-group">		
			<input type="submit" value="Search" class="btn btn-primary btn-md" name="search" />
		</div>
		</form><br />
	</div>
    <div class="alert alert-info" role="alert">
        <ul>
            <li>The 'X' button above cancels the donation.</li>
            <li>Please input the medical check up details for the patient.</li>
            <li>Only the donors in the current camp show up in this page.</li>
            <li>Please set the camp to see donors of that camp. <a href="<?php echo base_url();?>bloodbank/user_panel/place">Click here.</a></li>
        </ul>
    </div>
     <!-- code for modal popup -->
    <div class="container">
        <div class="modal fade" role="dialog" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo form_open("bloodbank/register/delete_donor");?>
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Cancel donor</h4>
                    </div>
                    <div class="modal-body">
                    Are you sure want to cancel ?
                    <br/><br/>
                    <div class="form-group">
                        <label for="reason">Enter reason:</label>
                        <textarea class="form-control" rows="5" id="reason" placeholder="Enter reason for cancelling" name="reason_for_cancel" required ></textarea>
                    </div>
                    <div class="modal-footer">
                    <button class="btn btn-default" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-primary" value="Submit" name="submit" formaction="<?php echo base_url();?>bloodbank/register/delete_donor/<?php echo $donor->donation_id;?>"/>
                    </div>
                    </div>
                </form>
        </div>
        </div>
    </div>
</div>
</div>
