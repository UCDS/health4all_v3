<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<div class="col-md-10 col-sm-9">
	<?php
	if(isset($msg)) {
		echo "<div class='alert alert-info'>$msg</div>";
		echo "<br />";		
	}
	if(validation_errors()){
		echo "<div class='alert alert-danger'>".validation_errors()."</div>";
	}
	if(count($donors)>0){
	?>
	<div>
            <div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="">Note:</span>
                <ul>
                    <li>Blood Unit is the Blood bag number. It's unique within a Blood Bank for the calendar year.</li>
                    <li>Segment number is the pilot tube number</li>
                    <li>Blood Group selected here is not final, Blood Group selected in Grouping stage is final.</li>
                    <li>Select <strong>UC(Under Collection)</strong> if the volume collected is less than the volume of the bag. Bags selected as UC don't show up in Grouping or Inventory, they are shown in Discard.</li>
                    <li>Staff name can be selected in <strong>Done By</strong> column only if the staff name is added to the database. To add staff <a href="<?php echo base_url()."staff/add/staff";?>">click here.</a>
                        <ul><li>When adding staff make sure you select his/her department as Blood Bank, you get the department after selecting hospital</li></ul>
                        <ul><li>Only fields with a '*' are mandatory</li></ul>
                    </li>
                    <li>The 'X' button below cancels the donation.</li>
                </ul>
             </div>
		<h4>Donors waiting: </h4>

		<table id="header-fixed" class="table-2 table table-striped table-bordered"></table>
		<table class="table-2 table table-striped table-bordered" id="table-1">
		<thead><th>Name</th>
				<th><div data-toggle="popover" data-placement="bottom" data-content="Please enter  Blood group">																  
				Blood Group</div></th>

				<th><div data-toggle="popover" data-placement="bottom" data-content="Please enter  Blood Unit">																  
				Blood Unit</div></th>

				<th><div data-toggle="popover" data-placement="bottom" data-content="Please enter  Segment Number">																  
				Segment</div></th>

				<th><div data-toggle="popover" data-placement="bottom" data-content="Please enter  Bag Type">																  
				Bag Type</div></th>
                                
                                <th><div data-toggle="popover" data-placement="bottom" data-content="Please enter  Bag Volume">
                                Volume</div></th>

				<th><div data-toggle="popover" data-placement="bottom" data-content="Under Collection ">																  
				UC</div></th>

				<th><div data-toggle="popover" data-placement="bottom" data-content="Staff Name ">																  
				Done By</div></th>

                                <th><div  data-toggle="popover" data-placement="bottom" data-content="Update/Cancel">Action</div></th>
				</thead>
		<?php 
		$i=1;
		foreach($donors as $donor){
		?>
		<tr>
		<?php echo form_open("bloodbank/register/bleeding");?>

			<td>
				<input type="text" value="<?php echo $donor->donation_id;?>" size="4" name="donation_id" hidden />
				<span class="blood_donor_name"><?php echo $donor->name;?></span>
			</td>
			<td><div class="form-group"><select name="blood_group" class="form-control" >
			<option value="" selected disabled>----</option>
			<option value="A+" <?php if($donor->blood_group=="A+") echo "selected";?>>A+</option>
			<option value="B+" <?php if($donor->blood_group=="B+") echo "selected";?>>B+</option>
			<option value="O+" <?php if($donor->blood_group=="O+") echo "selected";?>>O+</option>
			<option value="AB+" <?php if($donor->blood_group=="AB+") echo "selected";?>>AB+</option>
			<option value="A-" <?php if($donor->blood_group=="A-") echo "selected";?>>A-</option>
			<option value="B-" <?php if($donor->blood_group=="B-") echo "selected";?>>B-</option>
			<option value="O-" <?php if($donor->blood_group=="O-") echo "selected";?>>O-</option>
			<option value="AB-" <?php if($donor->blood_group=="AB-") echo "selected";?>>AB-</option>
			</select></div></td>
			<td><div class="form-group"><input type="number" class="form-control blood_donor_name" name="blood_unit_num" required /></div></td>
			<td><div class="form-group"><input type="text" class="form-control" name="segment_num" required /></div></td>
			<td>
			<div class="form-group">
				<select name="bag_type" style="width:100px" class="form-control" required >
				<option value="" disabled selected>Bag</option>
				<option value="1">Single</option>
				<option value="2">Double</option>
				<option value="3">Triple</option>
				<option value="4">Quadruple</option>
				<option value="5">Quadruple-Sagm</option>
				</select>
			</div>
                        </td>
                        <td>
			<div class="form-group">
			<select name="volume" class="form-control" required >
			<option value="" disabled selected>Vol</option>
			<option value="350">350ml</option>
			<option value="450">450ml</option>
			</select></div></td>
			<td><div class="checkbox"><input type="checkbox" value="1" name="incomplete" class='under_collection' /></div></td>
			<td><div class="form-group">
			<select name="staff" class="form-control" required >
				<option value="" disabled selected>Done By</option>
				<?php foreach($staff as $s){
					echo '<option value='.$s->staff_id.'>'.$s->first_name." ".$s->last_name." ".$s->name.'</option>';
				}
				?>
			</select></div></td>
			<td><div class="form-group" ><input type="submit" class="btn btn-primary" value="Update" />
                            <input type="button" class="btn btn-primary" value="X" data-toggle="modal" data-target="#myModal" />
                        </form>
		</tr>
		<?php 
		$i++;
		}
		?>
		</table>
			
	</div>
	<?php 
	}
	else if(isset($donor_details)){
	}
	else{
		echo "No donors waiting.";
	}
	?>
    <div class="alert alert-info" role="alert">
        <ul>
            <li>Please input the bleeding details for the patient.</li>
            <li>Only the donors in the current camp show up in this page.</li>
            <li>Please set the camp to see donors of that camp. <a href="<?php echo base_url();?>bloodbank/user_panel/place">Click here.</a></li>
        </ul>
    </div>
    <!-- code for modal popup -->
    <div class="container">
        <div class="modal fade" role="dialog" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <?php echo form_open("bloodbank/register/delete_donor_from_bleeding");?>
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
                    <input type="submit" class="btn btn-primary" value="Submit" name="submit" formaction="<?php echo base_url();?>bloodbank/register/delete_donor_from_bleeding/<?php echo $donor->donation_id;?>"/>
                    </div>
                    </div>
                </form>
        </div>
        </div>
    </div>
</div>
</div>
<script>
    $(".under_collection").change(function(){
	if($(this).is(":checked")){
	    $(this).closest('tr').find(".blood_donor_name").css("text-decoration","line-through");
	    $(this).closest('tr').find("td").css("background-color","#f2dede");
	}else{
	    console.log("unchecked");
	    $(this).closest('tr').find(".blood_donor_name").css("text-decoration","");
	    $(this).closest('tr').find("td").css("background-color","");

	}
    });
</script>