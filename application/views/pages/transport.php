<script type="text/javascript" src="<?php echo base_url();?>assets/js/moment.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.js"></script>
<link rel="stylesheet"  type="text/css" href="<?php echo base_url();?>assets/css/bootstrap_datetimepicker.css"></script>


<script type="text/javascript">
$(function(){
  		$("#from_area").chained("#from_department");
		$("#to_area").chained("#to_department");
  		$("#from_area2").chained("#from_department2");
		$("#to_area2").chained("#to_department2");
});
</script>
<br />

	<?php if(isset($msg)) { ?>
		<div class="alert alert-info"><?php echo $msg;?></div>
	<?php } ?>
	<?php 
	$pic_set = 1;
	if(isset($patients) && count($patients)>1){ ?>
	<table class="table table-bordered table-hover table-striped" id="table-sort">
	<thead>
		<th style="text-align:center">#</th>
		<th style="text-align:center">IP/OP No.</th>
		<th style="text-align:center">Patient</th>
		<th style="text-align:center">Admit Date</th>
		<th style="text-align:center">Department</th>
		<th style="text-align:center">Phone</th>
		<th style="text-align:center">Parent/Spouse</th>
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach($patients as $p){
		$age="";
		if($p->age_years!=0) $age.=$p->age_years."Y ";
		if($p->age_months!=0) $age.=$p->age_months."M ";
		if($p->age_days!=0) $age.=$p->age_days."D ";
		if($p->age_days==0 && $p->age_months == 0 && $p->age_years == 0) $age.="0D ";
	?>
	<tr onclick="$('#select_patient_<?php echo $p->visit_id;?>').submit()" style="cursor:pointer">
		<td>
			<?php echo form_open('register/transport',array('role'=>'form','id'=>'select_patient_'.$p->visit_id));?>
			<input type="text" class="sr-only" hidden value="<?php echo $p->visit_id;?>" form="select_patient_<?php echo $p->visit_id;?>" name="selected_patient" />
			</form>
			<?php echo $i++;?>
		</td>
		<td><?php echo $p->visit_type." #".$p->hosp_file_no;?></td>
		<td><?php echo $p->first_name." ".$p->last_name." | ".$age." | ".$p->gender;?></td>
		<td><?php echo date("d-M-Y",strtotime($p->admit_date));?></td>
		<td><?php echo $p->department;?></td>
		<td><?php echo $p->phone;?></td>
		<td><?php echo $p->parent_spouse;?></td>
	</tr>
	<?php
	}
	?>
	</tbody>
	</table>
	<?php } 
	else if(isset($patients) && count($patients)==1){
	?>
	<?php echo form_open('register/transport',array('class'=>'form-custom','role'=>'form')); ?>
	<div class="panel panel-default">
	<div class="panel-body">
	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">
		<?php 
			foreach($functions as $f){ 
				if($f->user_function == "Patient Transport") { ?>
					<li role="presentation"><a href="#patient_transport" aria-controls="patient_transport" role="tab" data-toggle="tab"><i class="fa fa-user"></i> Patient Transport</a></li>
				<?php 
				break;
				} 
			}
		?>
	  </ul>
          <?php
				$patient = $patients[0];
				$age="";
				if($patient->age_years!=0) $age.=$patient->age_years."Y ";
				if($patient->age_months!=0) $age.=$patient->age_months."M ";
				if($patient->age_days!=0) $age.=$patient->age_days."D ";
				if($patient->age_days==0 && $patient->age_months ==0 && $patient->age_years==0) $age.="0D ";
            ?>
	  <!-- Tab panes -->
	  <div class="tab-content">
              <?php 
                foreach($functions as $f){
                    if($f->user_function== "Patient Transport"){
                        ?>
              <div role="tabpanel" class="tab-pane active" id="patient_transport">
                  <div class="row alt">
                                <div class="col-md-4 col-xs-6">
                                    <b>Patient ID: <?php echo $patient->patient_id; ?> </b>
                                </div>
                                <div class="col-md-4 col-xs-6">
                                    <b><?php echo $patient->visit_type; ?> Number: </b><?php echo $patient->hosp_file_no;?>
                                </div>
                                <div class="col-md-4 col-xs-6">
                                    <b><?php if( $patient->visit_type == "IP") echo "Admit Date:"; else echo "Visit Date:";?></b>
                                    <?php echo date("d-M-Y", strtotime($patient->admit_date)).", ".date("g:ia", strtotime($patient->admit_time));?>
                                </div>
                  </div>
                  <div class="row alt">
                                <div class="col-md-4 col-xs-6">
                                    <b>Patient Name: <?php echo $patient->first_name; ?> </b>
                                </div>
                                <div class="col-md-4 col-xs-6">
                                    <b>Age: </b><?php echo $age;?>
                                </div>
                                <div class="col-md-4 col-xs-6">
                                    <b>Gender: </b><?php echo $patient->gender;?>
                                </div>
                  </div>
				  <br />
                  <div class="row alt">
					
					 <!--Patient transfers-->
					 <div class="col-md-12 col-xs-12">
						 <table class="table table-striped table-bordered">
							 <thead>
								<th colspan="4">Patient Transport Information</th>
							 </thead>
							 <tr>
								 <td><b>From Area</b></td>
								 <td><b>To Area</b></td>
								 <td><b>Transported By</b></td>
								 <td><b>Transport Start Date & Time</b></td>
							<?php	if(isset($transport_queue) && $transport_queue!=false){ ?>
								 <td><b>Transport End Date & Time</b></td>
							<?php } ?>
								 <td><b>Note</b></td>
							 </tr>
							 <?php
								if(isset($transport_queue) && $transport_queue!=false){
									foreach($transport_queue as $t){
										?>
							 <tr>
							 <td>
								 <?php 
										echo $t->from_area;
								 ?>
							 </td>            
							 <td>
								 <?php 
										echo $t->to_area;
								 ?>
							 </td>      
							 <td>
								 <?php 
										echo $t->transported_by;
								 ?>
							 </td>
							 <td>
								<?php echo date("d-M-Y",strtotime($t->start_date_time)); ?>
								<?php echo date("g:iA",strtotime($t->start_date_time)); ?>
							 </td>
							 <td>
							 <div class="row">
							 <div class="col-md-12">
							 <input type="text" name="transport_end_date_<?php echo $t->transport_id;?>" class="form-control transport_end_date" value="<?php echo date("d-M-Y g:iA");?>" />
							 <input type="text" name="transport_id[]" class="sr-only form-control" value="<?php echo $t->transport_id;?>" />
							 </div>
							 </div>
							 </td>
							 <td>
							 <textarea type="text" name="note_<?php echo $t->transport_id;?>" class="form-control note" id="note"><?php echo $t->note;?></textarea>
							 </td>
							 </tr>
										<?php
									}
								}
								else{
							 ?>
							  <tr>
							 <td>
								 <select name="from_department" class="form-control from_department" id="from_department">
									<option value="">--Select--</option>
									<?php 
										foreach($all_departments as $department){
										echo "<option value='".$department->department_id."'";
										foreach($defaults as $d) if($d->primary_key == 'from_department_id' && $d->default_value == $department->department_id) echo " selected ";																				
										echo ">".$department->department."</option>";
									}
									?>
								</select>
								 <select name="transport_from_area" class="form-control from_area" id="from_area">
									<option value="">--Select--</option>
									<?php 
										foreach($areas as $area){
										echo "<option value='".$area->area_id."' class='".$area->department_id."' ";
										foreach($defaults as $d) if($d->primary_key == 'from_area_id' && $d->default_value == $area->area_id) echo " selected ";
										echo " >".$area->area_name."</option>";
									}
									?>
								</select>
							 </td>
							 <td>
								 <select name="to_department" class="form-control to_department" id="to_department">
									<option value="">--Select--</option>
									<?php 
										foreach($all_departments as $department){
										echo "<option value='".$department->department_id."'";
										foreach($defaults as $d) if($d->primary_key == 'to_department_id' && $d->default_value == $department->department_id) echo " selected ";										
										echo ">".$department->department."</option>";
									}
									?>
								</select>
								 <select name="transport_to_area" id="to_area" class="form-control to_area">
								<option value="">--Select--</option>
								<?php 
								foreach($areas as $area){
										echo "<option value='".$area->area_id."' class='".$area->department_id."'";
										foreach($defaults as $d) if($d->primary_key == 'to_area_id' && $d->default_value == $area->area_id) echo " selected ";										
										echo ">".$area->area_name."</option>";
								}
								?>
								</select>
							 </td>
							 <td>
								<select name="transported_by" id="transported_by" class="form-control transported_by">
								<option value="">--Select--</option>
								<?php 
								foreach($transporters as $transporter){
										echo "<option value='".$transporter->staff_id."'>".$transporter->staff_name."</option>";
								}
								?>
								</select>					   
							 </td>
							 <td>
							 <div class="row">
							 <div class="col-md-12">
							 <input type="text" name="transport_start_date" class="form-control transport_start_date" value="<?php echo date("d-M-Y g:iA");?>" id="transport_start_date" />
							 </div>
							 </div>
							 </td>
							 <td>
							 <textarea type="text" name="note" class="form-control note" id="note"></textarea>
							 </td>
							 </tr>
							 <?php } ?>
						 </table>
					 </div>
				</div>
              </div>              
                        <?php
                        break;
                    }
                }
              ?>
 

			<div class="col-md-12 text-center">
				<input type="text" name="visit_id" class="sr-only" value="<?php echo $patient->visit_id;?>" hidden readonly />
				<input type="text" name="patient_id" class="sr-only" value="<?php echo $patient->patient_id;?>" hidden readonly />
				<button class="btn btn-md btn-primary" value="Update" name="transport">Transport</button>
			</div>
	</div>
	</div>
	</form>		
	<?php }
	else if(isset($patients)){
		echo "No patients found with the given search terms";
	}
	?>
	</div>
	<br/>
<div class="col-md-12">

	  <ul class="nav nav-tabs" role="tablist">
					<li role="presentation" class="active"><a href="#patient_transport" aria-controls="patient_transport" role="tab" data-toggle="tab"><i class="fa fa-user"></i> Patient Transport</a></li>
					<li role="presentation"><a href="#transport" aria-controls="patient_transport" role="tab" data-toggle="tab">Other Transport</a></li>
	  </ul>
	  
	  <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="patient_transport">
		<div class="panel panel-default">
		<div class="panel-heading">
		<h4>Search Patients</h4>	
		</div>
		<div class="panel-body">
		<?php echo form_open("register/transport",array('role'=>'form','class'=>'form-custom')); ?>
					<div class="row">
					<div class="col-md-10">
						<div class="form-group">
						<label class="control-label">Year</label>
						<select class="form-control" name="search_year">
							<?php 
								$i=2013;
								$year = date("Y");
								while($year>=$i){ ?>
								<option value="<?php echo $year;?>"><?php echo $year--;?></option>
							<?php
								}
							?>
						</select>
						</div>
						<div class="form-group">
							<label class="control-label">Visit Type</label>
							<select class="form-control" name="search_visit_type">
								<option value=''>All</option>
								<option value='IP'>IP</option>
								<option value='OP'>OP</option>
							</select>
						<label class="control-label">IP/OP Number</label>
						<input type="text" name="search_patient_number" size="5" class="form-control" />
						</div>
						<div class="form-group">
						<label class="control-label">Patient Name</label>
						<input type="text" name="search_patient_name" class="form-control" />
						</div>
						<div class="form-group">
						<label class="control-label">Phone Number</label>
						<input type="text" name="search_phone" class="form-control" />
						</div>
					</div>
				</div>
		</div>
		<div class="panel-footer">
			<div class="text-center">
			<input class="btn btn-sm btn-primary" name="search_patients" type="submit" value="Submit" />
			</div>
			</form>
		</div>
		</div>
		</div>
		
        <div role="tabpanel" class="tab-pane" id="transport">
		<table class="table table-bordered">
					
							 <thead>
								<th colspan="6">Transport Information</th>
							 </thead>
							 <tr>
								 <td><b>From Area</b></td>
								 <td><b>To Area</b></td>
								 <td><b>Transported By</b></td>
								 <td><b>Transport Start Date & Time</b></td>
								 <td><b>Note</b></td>
							 </tr>
							  <tr>
							 <td>
								<?php echo form_open('register/transport',array('role'=>'form','id'=>'non-patient'));?>
								 <select name="from_department" class="form-control from_department" id="from_department2">
									<option value="">--Select--</option>
									<?php 
										foreach($all_departments as $department){
										echo "<option value='".$department->department_id."'";
										foreach($defaults as $d) if($d->primary_key == 'from_department_id' && $d->default_value == $department->department_id) echo " selected ";																				
										echo ">".$department->department."</option>";
									}
									?>
								</select>
								 <select name="transport_from_area" class="form-control from_area" id="from_area2">
									<option value="">--Select--</option>
									<?php 
										foreach($areas as $area){
										echo "<option value='".$area->area_id."' class='".$area->department_id."' ";
										foreach($defaults as $d) if($d->primary_key == 'from_area_id' && $d->default_value == $area->area_id) echo " selected ";
										echo " >".$area->area_name."</option>";
									}
									?>
								</select>
							 </td>
							 <td>
								 <select name="to_department" class="form-control to_department" id="to_department2">
									<option value="">--Select--</option>
									<?php 
										foreach($all_departments as $department){
										echo "<option value='".$department->department_id."'";
										foreach($defaults as $d) if($d->primary_key == 'to_department_id' && $d->default_value == $department->department_id) echo " selected ";										
										echo ">".$department->department."</option>";
									}
									?>
								</select>
								 <select name="transport_to_area" id="to_area2" class="form-control to_area">
								<option value="">--Select--</option>
								<?php 
								foreach($areas as $area){
										echo "<option value='".$area->area_id."' class='".$area->department_id."'";
										foreach($defaults as $d) if($d->primary_key == 'to_area_id' && $d->default_value == $area->area_id) echo " selected ";										
										echo ">".$area->area_name."</option>";
								}
								?>
								</select>
							 </td>
							 <td>
								<select name="transported_by" id="transported_by" class="form-control transported_by">
								<option value="">--Select--</option>
								<?php 
								foreach($transporters as $transporter){
										echo "<option value='".$transporter->staff_id."'>".$transporter->staff_name."</option>";
								}
								?>
								</select>					   
							 </td>
							 <td>
							 <div class="row">
							 <div class="col-md-12">
							 <input type="text" name="transport_start_date" class="form-control transport_start_date" value="<?php echo date("d-M-Y g:iA");?>" id="transport_start_date" />
							 </div>
							 </div>
							 </td>
							 <td>
							 <textarea type="text" name="note" class="form-control note" id="note"></textarea>
							 </td>
							 </tr>
							 <tr>
							<td colspan="6">
							 <input type="text" name="transport_type" class="form-control sr-only" value="2" id="transport_type" />
								<input type="submit" class="btn btn-primary btn-sm" name="transport_np" value="Transport" />
								</form>
							</td>
				</table>
				
			<?php if(!!$transport_queue_np) { ?>
			<table class="table table-bordered">
				<thead>
					<tr><th colspan="5">Non Patient Transport Queue</th></tr>
					<tr>
						<th></th>
						<th>								
							<?php echo form_open('register/transport',array('role'=>'form','id'=>'non-patient'));?>
							From Area
						</th>
						<th>To Area</th>
						<th>Transported By</th>
						<th>Start Date & Time</th>
						<th>End Date & Time</th>
						<th>Note</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($transport_queue_np as $tq){ ?>
						<tr>
							<td>
								<input type="checkbox" class="form-control" name="transport_id[]" value="<?php echo $tq->transport_id;?>" />
							</td>
							<td>
								<?php echo $tq->from_area; ?>
							</td>
							<td><?php echo $tq->to_area; ?></td>
							<td><?php echo $tq->transported_by; ?></td>
							<td><?php echo date("d-M-Y g:iA",strtotime($tq->start_date_time)); ?></td>
							<td>
							<div class="row">
							<div class="col-md-12">
								<input type="text" name="transport_end_date_<?php echo $tq->transport_id;?>" class="form-control transport_end_date" value="<?php echo date("d-M-Y g:iA");?>" />
							</div>
							</div>
							</td>
							<td>
								<textarea type="text" name="note_<?php echo $tq->transport_id;?>" class="form-control note" id="note"><?php echo $tq->note;?></textarea>
							</td>
						</tr>
					<?php } ?>
					<tr>
						<td colspan="5">
							<input type="submit" value="Update" class="btn btn-primary btn-sm" name="transport_np" />
							</form>
						</td>
					</tr>
				</tbody>
				</table>
			<?php } ?>		
				
		</div>
</div>
<br />

				<script>
				$(function(){
					$(".transport_start_date,.transport_end_date").datetimepicker({
						format : "D-MMM-YYYY h:ssA",
						defaultDate : false
                    });
				});
				</script>