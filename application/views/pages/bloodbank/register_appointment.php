<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<script type="text/javascript"
 src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script>
	$(function(){
		var rowcount=1;
		$("#dob").Zebra_DatePicker({
			view:"years",
			direction:0,
			onSelect: function(rdate,ydate,date){
				var year=date.getYear("Y");
				var current_year=new Date().getYear();
				var age=current_year-year;
				$("#age").val(age);
				}
		});
		$("#male").click(function(){
			$("#women").hide();
		});
		$("#female").click(function(){
			$("#women").show();
		});
	});
</script>

<div class="col-md-10 col-sm-9">
	<strong style='color:red'><?php echo validation_errors(); ?></strong><br />
	<?php 
	if(isset($msg)) {
		echo $msg;
		echo "<br />";
		echo "<br />";
	}
	foreach($slot as $row){
		echo "<font size='2' style='background:#eee;padding:5px;'>Blood Donation Slot : ".date("D, jS M",strtotime($row->date))." | ".$row->from_time." to ".$row->to_time." <a href='".base_url()."appointment'>Change</a></font>";
	}
	?>
	<br /><br />
	<h4>Donor Registration</h4>
	<?php echo form_open("appointment/register/slot".$slot[0]->slot_id); ?>
	<font size="2">fields marked with * are mandatory.</font><br />
	<hr>
	<input type="text" placeholder="Full Name" size="20" id="name" name="name" required />*<br />
	<input type="text" placeholder="Date of Birth" size="12" id="dob" name="dob" /><br />
	<input type="text" placeholder="Age" size="8" id="age" name="age" required />*<br />
	Gender: <input type="radio" name="gender" id="male" value="male" required /><label for="male">Male</label>
	<input type="radio" name="gender" id="female" value="female" required /><label for="female">Female</label>*<br />
	Maritial Status: <input type="radio" name="maritial_status" id="single" value="single" /><label for="single">Single</label>
	<input type="radio" name="maritial_status" id="married" value="married" /><label for="married">Married</label><br />
	<input type="text" placeholder="Parent or Spouse Name" size="20" name="parent_spouse" /><br />
	<input type="text" name="occupation" placeholder="Occupation" size="20" id="occupation" /><br />
	<textarea placeholder="Address" cols="40" id="address" name="address" rows="4"></textarea><br />
	<select name="blood_group">
	<option value="" disabled selected>Blood Group</option>
	<option value="A+">A+</option>
	<option value="B+">B+</option>
	<option value="O+">O+</option>
	<option value="AB+">AB+</option>
	<option value="A-">A-</option>
	<option value="B-">B-</option>
	<option value="O-">O-</option>
	<option value="AB-">AB-</option>
	</select><br />
	<input type="text" placeholder="Phone Number" size="16" id="phone" name="mobile" required />*<br />
	<input type="text" placeholder="Email" size="24" id="email" name="email" required />*<br />
	<?php include "med_counselling_table.php"; ?>
	<div style="border:1px solid #eee; padding:5px;">
		<p style="font-size:0.9em;">Note : Your contact information will be used to reach you in case of emergencies. It won't be disclosed to any other entity other than the Blood Bank.</p>
	</div>
	<input type="radio" name="alert" value="1" id="accept" required /><label for="accept">Yes, send me an alert in case of an emergency</label>
	<input type="radio" name="alert" value="0" id="decline" required /><label for="decline">No, I do not wish to recieve any notifications.</label><br />
	<div style="text-align:center" ><input type="submit" value="Submit" name="submit" /></div>
	</form>
</div>
