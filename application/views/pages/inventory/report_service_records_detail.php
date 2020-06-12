<div class="col-md-8 col-md-offset-2">
<!--when  clicked  on tr this form will load --->
	
	
	<center>	<h3> Service Issue</h3></center><br>


    
	<input type="hidden" class="form-control"  value='<?php echo $service_summary[0]->request_id; ?>'   name="request_id" />
<div class="col-md-8">
	<div class="form-group">
		<div class="col-md-6">
		<label for="service_summary" >Call Date<font color='red'>*</font></label>
		</div>
		<div  class="col-md-6">
	
		<input readonly type="readonly" class="form-control" placeholder=" Call Date"  id="call_date" name="call_date"
<?php if(isset($service_summary)){
			echo "value='".date("d-M-Y",strtotime($service_summary[0]->call_date))."' ";
			}
		?>		/>
		
		</div>
	</div>
	</div>
	<br><br>
	<div class="col-md-8">
	<div class="form-group">
	<div class="col-md-6">
		<label for="service_summary" >Call Time<font color='red'>*</font></label>
		</div>
		<div  class="col-md-6">
		<input  readonly type="text" class="time form-control"  size="6"  placeholder=" Call Time" id="service_summary" name="call_time"
<?php if(isset($service_summary)){
			echo "value='".$service_summary[0]->call_time."' ";
			}
		?>		/>
		</div>
	</div></div><br><br>
		<div class="col-md-8">
<div class="form-group">
<div class="col-md-6">
		<label for="service_summary" >Call Information Type</label>
		</div>
		<div  class="col-md-6">
		<input readonly  type="text" class="form-control" placeholder=" Call Information Type" id="service_summary" name="call_information_type"
		
		<?php if(isset($service_summary)){
			echo "value='".$service_summary[0]->call_information_type."' ";
			}
		?>/>
		</div>
	</div></div><br><br>
		<div class="col-md-8">
<div class="form-group">
<div class="col-md-6">
		<label for="service_summary" >Call Information</label>
		</div>
		<div  class="col-md-6">
	<textarea  readonly class="form-control" placeholder=" Call Information" id="service_summary" name="call_information">	 
<?php if(isset($service_summary)){
	        
			echo "".$service_summary[0]->call_information." ";
			}
		?>		</textarea>
		</div>
	</div></div><br><br>
	
		<div class="col-md-8">
<div class="form-group">
<div class="col-md-6">
		<label for="description" > Working Status<font color='red'>*</font></label>
		</div>
		<div  class="col-md-6">
	
           <select readonly  id="service_summary" class="form-control" name="working_status" placehoder="working_status">
		     
            <option value="1" <?php echo $service_summary[0]->working_status == 1 ? " selected" : ""; ?>>Working</option>
		   <option value="0" <?php echo  $service_summary[0]->working_status == 0 ? " selected" : ""; ;?>>Not Working</option>
</select>

		</div>
	</div></div><br><br>


	<div class="col-md-8">
<div class="form-group">
		<div class="col-md-6">
			<label for="vendor" >Vendor<font color='red'>*</font></label>
		</div>
			
			<div class="col-md-6">
			<select readonly  class="form-control" id="vendor_id" name="vendor_id">
				<option value=""> </option>
				<?php foreach($vendors as $d){
						echo "<option value='$d->vendor_id'";
			$service_summary[0]->vendor_id==$d->vendor_id;
				echo " SELECTED ";
			echo ">$d->vendor_name</option>";
			
		} ?>
			</select>
		</div>	
	
	</div></div><br><br>
		
		<div class="col-md-8">
	<div class="form-group">
		<div class="col-md-6">
			<label for="contact_person_id" > Contact Person</label>
		</div>
		<div class="col-md-6">
			<select readonly class="form-control" id="contact_person" name="contact_person">
				<option value=""> </option>
				<?php foreach($contact_persons as $d){
						echo "<option value='$d->contact_person_id'";
			$service_summary[0]->contact_person_id==$d->contact_person_id;
				echo " SELECTED ";
			echo ">$d->contact_person_first_name</option>";
			
		} ?>
				
			
			</select>
		</div>	
		
	</div></div><br><br>
	


		<div class="col-md-8">
<div class="form-group">
<div class="col-md-6">
		<label for="service_summary" >Service Person Remarks</label>
		</div>
		<div  class="col-md-6">
		<input  readonly type="text" class="form-control" placeholder="  Service Remarks" id="service_summary" name="service_person_remarks"
<?php if(isset($service_summary)){
			echo "value='".$service_summary[0]->service_person_remarks."' ";
			}
		?>			/>
		</div>
	</div></div><br><br>
		<div class="col-md-8">
	<div class="form-group">
	<div class="col-md-6">
		<label for="service_summary" >Service Date</label>
		</div>
		<div  class="col-md-6">
		<input readonly  type="text" class="form-control" placeholder="Service Date" id="service_date"  name="service_date"
         
		<?php if(isset($service_summary)){
			echo "value='".date("d-M-Y",strtotime($service_summary[0]->service_date))."' ";
			}
		?>		/>
		</div>
	</div></div><br><br>
	<div class="col-md-8">
	<div class="form-group">
	<div class="col-md-6">
		<label for="service_summary" >Service Time</label>
		</div>
		
		<div  class="col-md-6">
		<input  readonly type="text" class=" time form-control" placeholder="   Service Time" id="service_summary" name="service_time" 
		<?php if(isset($service_summary)){
			echo "value='".$service_summary[0]->service_time."' ";
			}
		?>/>
		</div>
		</div>
	</div>
	<div class="col-md-8">
	<div class="form-group">
	<div class="col-md-6">
		<label for="service_summary" >Issue status </label>
		</div>
			<div class="col-md-6">
		
			
<select readonly  name="problem_status" class="form-control">
		<option value="">Select Problem Status</option>
     <option value="Issue Reported" <?php echo  $service_summary[0]->problem_status == 'Issue Reported' ? " selected" : ""; ;?>>Issue Reported</option>
	 <option value="Service Visit Made" <?php echo  $service_summary[0]->problem_status == 'Service Visit Made' ? " selected" : ""; ;?>>Service Visit Made</option>
     <option value="Under Observation" <?php echo  $service_summary[0]->problem_status == 'Under Observation' ? " selected" : ""; ;?>>Under Observation</option>
     <option value="Issue Resolved" <?php echo  $service_summary[0]->problem_status == 'Issue Resolved' ? " selected" : ""; ;?>>Issue Resolved</option>
	



</select>
</div>

		</div>
	</div><br><br>
	</div>