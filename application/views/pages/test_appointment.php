<html>
  <body>
  <table class="table table-bordered table-striped" id="table-sort">
	<thead>
		<th>SNo</th>
		<th>Patient ID</th>
		<th>OP No.</th>
		<th>Consultation Request Time</th>
		<th>PatientInfo</th>
		<th>Related to</th>
		<th>From</th>
		<th>Phone</th>
		<th>Department</th>
    		<th>Request CreatedBy</th>
		<th>Doctor Consulted</th>
		<th>Appointment With</th>
		<th>Appointment Time</th>
		<th>Consultation Summary Sent</th>
		<th>Appointment Update By/Time</th>
    		<th>Update Appointment</th>
	</thead>
	<tbody>
	<?php 
	$sno=1;
	foreach($report as $s){
		$age="";
		if(!!$s->age_years) $age.=$s->age_years."Y ";
		if(!!$s->age_months) $age.=$s->age_months."M ";
		if(!!$s->age_days) $age.=$s->age_days."D ";
		if($s->age_days==0 && $s->age_months==0 && $s->age_years==0) $age.="0D";
	?>
	<tr>
		<td><?php echo $sno;?></td>
		<td><?php echo $s->patient_id;?></td>
		<td><?php echo $s->hosp_file_no;?></td>
		<td><?php echo date("j M Y", strtotime("$s->admit_date")).", ".date("h:i A.", strtotime("$s->admit_time"));?></td>
		<td><?php echo $s->name . ", " . $age . " / " . $s->gender;?></td>
		<td><?php echo $s->parent_spouse;?></td>
		<td><?php if(!!$s->address && !!$s->place) echo $s->address.", ".$s->place; else echo $s->address." ".$s->place;?></td>
		<td><?php echo $s->phone;?></td>
		<td><?php echo $s->department;?></td>
    		<td><?php echo $s->volunteer;?></td>
		<td><?php echo $s->doctor;?></td>
		<td><?php echo $s->appointment_with;?></td>
		<td><?php if(isset($s->appointment_date_time) && $s->appointment_date_time!="") 
				{echo date("j M Y", strtotime("$s->appointment_date_time")).", ".date("h:i A.", strtotime("$s->appointment_date_time"));} 
				else {echo $s->appointment_date_time="";}?></td>
		<td><?php if(isset($s->summary_sent_time) && $s->summary_sent_time!="")
				{echo date("j M Y", strtotime("$s->summary_sent_time")).", ".date("h:i A.", strtotime("$s->summary_sent_time"));}
				else {echo $s->summary_sent_time="";};?></td>
		<td><?php echo $s->appointment_update_by . ", "; 
				if(isset($s->appointment_update_time) && $s->appointment_update_time!="") 
				{echo date("j M Y", strtotime("$s->appointment_update_time")).", ".date("h:i A.", strtotime("$s->appointment_update_time"));} 
				else {echo $s->appointment_update_time="";}?></td>
		<td><?php if($s->signed==0 or $s->summary_sent_time=="") { echo '
		<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal_' . $sno .'">Update</button>
		'; }?></td>
	</tr>
	<?php $sno++;}	?>
	</tbody>
	</table>
  </body>
</html>
