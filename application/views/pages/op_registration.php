<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<style>
.row{	
  margin-top:10px;
  margin-bottom:10px;
}
</style>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript">
$(function(){
	$("#dob").Zebra_DatePicker({
		view:"years",
		direction:false,
		onSelect: function(rdate,ydate,date){
				// var year=date.getYear("Y");
				// var current_date=new Date();
				// var current_year=current_date.getYear();
				// var current_month=current_date.getMonth()+1;
				// var today=current_date.getDay();
				// var age_years=current_year-year;
				// var age_months=current_month-month;
				// var age_days=today-day;
				// $("#age").val(age);
				getAge(date);
		}
	});
	$("#date").Zebra_DatePicker({
		direction:false
	});
	$("#spouse").prop('disabled',true);
	$(".gender").change(function(){
		if($(this).val()=="M"){
			$("#spouse").prop('disabled',true);
		}
		else{
			$("#spouse").prop('disabled',false);
		}
	});
});
function DaysInMonth(Y, M) {
    	with (new Date(Y, M, 1, 12)) {
        setDate(0);
        return getDate();
	} 
}	
	
function getAge(dateString) {
    var today = new Date();
    var birthDate = new Date(dateString);
    var age = today.getFullYear() - birthDate.getFullYear();
    var m = today.getMonth() - birthDate.getMonth();
    var d = today.getDate() - birthDate.getDate();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--; m += 12;
	}
	if (d < 0) {
        m--;
        d += DaysInMonth(age, m);
    	}
   document.getElementById("age_years").value=age;
   document.getElementById("age_months").value=m;
   document.getElementById("age_days").value=d;
}
<!-- Scripts for printing output table -->
function printDiv(i)
{
var content = document.getElementById(i);
var pri = document.getElementById("ifmcontentstoprint").contentWindow;
pri.document.open();
pri.document.write(content.innerHTML);
pri.document.close();
pri.focus();
pri.print();
}
</script>

<iframe id="ifmcontentstoprint" style="height: 0px; width: 0px; position: absolute;display:none"></iframe>

		<?php echo validation_errors(); ?>
		<h3>Out-Patient Registration</h3>	
		<?php echo form_open("register/op",array('role'=>'form','class'=>'form-custom')); ?>
		<div class="row small">
		<div class="col-xs-4">
				<div class="col-md-4">
					<label for="date" class='control-label'>Date </label>
				</div>
				<div class="col-md-8">
					<input type="text" value="<?php echo date("d-M-Y"); ?>" name="date" class="form-control input-sm" id="date" />
				</div>
		</div>
		<div class=" col-xs-4">		
				<div class="col-md-4">
				<label for="time" class='control-label'>Time  </label>
				</div>
				<div class="col-md-8">
					<input type="text" value="<?php echo date("g:iA"); ?>" name="time" class="form-control input-sm" id="time" />
				</div>
		</div>
		</div>

		<div class="row small">
		<div class="col-xs-4">
				<div class="col-md-4">
				<label class="control-label">First name* </label>
				</div>
				<div class="col-md-8">
				<input type="text" name="first_name" placeholder="First" class="form-control"  required />
				</div>
		</div>
		<div class="col-xs-4">
			<div class="col-md-4">
			Last name*
			</div>
			<div class="col-md-8">
			<input type="text" name="last_name" placeholder="Last" class="form-control"  required />
			</div>
		</div>
		<div class="col-xs-4">
			<div class="col-md-4">
					Gender*  
			</div>
			<div class="col-md-8 radio">
					<label class="control-label"><input type="radio" value="M" name="gender" id="male" class="gender" required />Male</label>
					<label class="control-label"><input type="radio" value="F" name="gender" id="female" class="gender" required />Female</label>
			</div>
		</div>
		</div>
		<div class="row small">
		<div class="col-xs-4">
			<div class="col-md-4">
					Age  
			</div>
			<div class="col-md-8">
					<input type="text" name="age_years" id="age_years" size="1" class="form-control"  />Y
					<input type="text" name="age_months" id="age_months" size="1" class="form-control"  tabindex="100" />M
					<input type="text" name="age_days" id="age_days" size="1" class="form-control"  tabindex="101" />D
			</div>
		</div>
		<div class="col-xs-4">
			<div class="col-md-4">
			Date of Birth : 
			</div>
			<div class="col-md-8">		
				<input type="text" name="dob" id="dob" size="15" class="form-control" tabindex="102" />
			</div>
		</div>
		<div class="col-xs-4">
			<div class="col-md-4">
					Father Name : 
			</div>
			<div class="col-md-8">
					<input type="text" name="father_name" class="form-control" size="20" />
			</div>
		</div>
		</div>
		<div class="row small">
		<div class="col-xs-4">
			<div class="col-md-4">
					Spouse Name : 
			</div>
			<div class="col-md-8">
					<input type="text" name="spouse_name" class="form-control" size="15" id="spouse" />
			</div>
		</div>
		<div class="col-xs-4">
			<div class="col-md-4">
					Phone : 
			</div>
			<div class="col-md-8">
					<input type="text" name="phone" class="form-control" size="15" />
			</div>
		</div>
		<div class="col-xs-4">
			<div class="col-md-4">
					Place : 
			</div>
			<div class="col-md-8">
					<input type="text" name="place" class="form-control" size="20" />
			</div>
		</div>
		</div>
		<div class="row small">
		<div class="col-xs-4">
			<div class="col-md-4">
					District : 
			</div>
			<div class="col-md-8">
					<select name="district" class="form-control">
					<option value="">--Select--</option>
					<?php 
					foreach($districts as $district){
						echo "<option value='".$district->district_id."'>".$district->district."</option>";
					}
					?>
					</select>	
			</div>
		</div>
		<div class="col-xs-4">
			<div class="col-md-4">
				Department :
			</div>
			<div class="col-md-8">
					<select name="department" required  class="form-control">
					<option value="">--Select--</option>
					<?php 
					foreach($departments as $dept){
						echo "<option value='".$dept->department_id."'>".$dept->department."</option>";
					}
					?>
					</select>
			</div>
		</div>
		</div>
		
		<input type='submit' value='Register' />
		</form>
		<?php if(isset($registered)){ ?>
		<div>
		<table class="table-2" style="float:none;" align="right">
			<th colspan="2">Registered Patient Details</th>
			<?php foreach($registered as $row){ ?>
			<tr><td>Name</td><td><?php echo $row->name;?></td></tr>
			<tr><td>Patient ID</td><td><?php echo $row->patient_id;?></td></tr>
			<tr><td>Visit ID</td><td><?php echo $row->visit_id;?></td></tr>
			<tr><td>Visit Date</td><td><?php echo $row->admit_date;?></td></tr>
			<tr><td>Visit Time</td><td><?php echo $row->admit_time;?></td></tr>
			<tr><td>Age</td><td>
				<?php if($row->age_years!=0){ echo $row->age_years." Yrs"; } 
				if($row->age_months!=0){ echo $row->age_months." Mths"; }if($row->age_days!=0){ echo $row->age_days." Days"; }?></td>
			</tr>
			<tr><td>Gender</td><td><?php echo $row->gender;?></td></tr>
			<tr><td>Place</td><td><?php echo $row->place;?></td></tr>
			<tr><td>Department</td><td><?php echo $row->department;?></td></tr>
			<tr><td colspan="2" align="center"><input type="button" value="Print" onclick="printDiv('print_div')" /></td></tr>
		<?php
		}
		?>
		</table>
		</div>
		
		
		<div id="print_div">
		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/main.css" media="print" >
		<table style="width:98%;padding:5px">

			<?php foreach($registered as $row){ ?>
				<tr>
				<td colspan="3" align="center">
				<img align="left" src="<?php $hospital=$this->session->userdata('hospital');echo $hospital['logo'];?>" width="50px" />
				<font size="3"><?php echo $hospital['hospital'];?></font><br />
					<?php echo $hospital['description'];?> 
					@ 
					<?php echo $hospital['place'];?>, 
					<?php echo $hospital['district'];?>,
					<?php echo date("d-M-Y",strtotime($row->admit_date)); ?>
				</td>
				</tr>
				<tbody height="10%" style="border:1px solid black;">
				<tr width="95%">
						<td style="padding:5px;">Name: <?php echo $row->name; ?></td>
						<td>Gender: <?php echo $row->gender; ?></td>
						<td>Age: 	
							<?php 
							if($row->age_years!=0){ echo $row->age_years." Yrs "; } 
							if($row->age_months!=0){ echo $row->age_months." Mths "; }
							if($row->age_days!=0){ echo $row->age_days." Days "; }
							?>
						</td>
				</tr>
				<tr width="95%">
						<td  style="padding:5px;">Father / Spouse Name :  <?php echo $row->parent_spouse; ?></td>
						<td>Address: <?php echo $row->place; ?></td>
						<td>Phone : <?php echo $row->phone; ?></td>
				</tr>
				<tr width="95%">
						<td  style="padding:5px;">OP number : <?php echo $row->visit_id; ?></td>
						<td>Department : <?php echo $row->department; ?> </td>
						<td></td>
				</tr>
				</tbody>
				<tr style="border:1px solid black" >
						<td style="padding:5px;">Weight : </td>
						<td>Pulse : </td>
						<td> BP : ______ / ______</td>
				</tr>
				<tr class="print-element" width="95%" height="80px">
					<td>
						Chief Complaint:
					</td>
				</tr>
				<tr class="print-element" width="95%" height="80px">
					<td>
						Diagnosis:
					</td>
				</tr>
				<tr class="print-element" width="95%" height="80px">
					<td>
						Investigations:
					</td>
				</tr>
				<tr class="print-element" width="95%">
					<td class="print-text">
						Medicines Prescribed: 
					</td>
				</tr>
				<tr>
				<td colspan="3">
				<table id="table-prescription">
						<tr align="center" >
							<td rowspan="2" width="30px">S.no</td>
							<td rowspan="2" width="45%;">
							<img src="<?php echo base_url();?>assets/images/medicines.jpg" width="30px" alt="" />
							Medicine
							<img src="<?php echo base_url();?>assets/images/syrup.jpg" width="30px" alt="" />
							<br />(CAPITAL LETTERS PLEASE)</td>
							<td rowspan="2" width="50px">Strength</td>
							<td rowspan="2" width="50px"><img src="<?php echo base_url();?>assets/images/calendar.jpg" width="30px" alt="Days" /><br />Days</td>
							<td colspan="10" align="center" width="300px"><img src="<?php echo base_url();?>assets/images/timings.jpg" width="50px" height="40px" alt="Timings" />
							<span style="top:-10px;position:relative;">Timings</span></td>
						</tr>
						<tr align="center">
							<td colspan="2" width="30px"><img src="<?php echo base_url();?>assets/images/morning.jpg" width="30px" height="30px" />
							<span style="top:-10px;position:relative;">Morning</span>
							<br />
							<-<img src="<?php echo base_url();?>assets/images/food.jpg" alt="Food" width="30px" height="30px" />-></td>
							<td colspan="2" width="30px"><img src="<?php echo base_url();?>assets/images/afternoon.jpg" width="30px" height="30px" />
							<span style="top:-10px;position:relative;">Afternoon</span>
							<br />
							<-<img src="<?php echo base_url();?>assets/images/food.jpg" alt="Food" width="30px" height="30px" />-></td>
							<td colspan="2" width="30px"><img src="<?php echo base_url();?>assets/images/night.jpg" width="30px" height="30px" />
							<span style="top:-10px;position:relative;">Evening</span>
							<br />
							<-<img src="<?php echo base_url();?>assets/images/food.jpg" alt="Food" width="30px" height="30px" />-></td>
						</tr>
						<?php for($i=0;$i<5;$i++){ ?>
						<tr height="50px" align="center" valign="center">
							<td><?= $i+1 ?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<?php } ?>
						</table>
				</td>
				</tr>
				<tr class="print-element" width="95%" height="80px">
				<td>
						<br />Follow up advice:
				</td>
				</tr>
				<tr>
				<td colspan="2" align="right">Doctor :</td>
				</tr>
				<?php } ?>	
		</table>
		<?php } ?>	
	</section>