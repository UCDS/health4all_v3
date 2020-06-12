<center>
	<?php
echo validation_errors();
if (isset($message)){?>
	<div class="alert alert-info">
	<?php echo $message;?>
	</div>	
	</center>	
	<?php }?>		
				
				
				<h2 align="center">UNIT DETAILS</h2><br>

					
						<?php   echo form_open('hospital_units/add_unit',array('class'=>'form-group','role'=>'form')); ?>
						<div class = "col-md-8 col-md-offset-3">
					    	<div class="row">
								<div class = "col-xs-12 col-sm-12 col-md-6 col-lg-4">
									<div class="form-group">
										<label for="inputunit_head_staff_id" >Unit Head Staff</label>
										<input type="TEXT" class="form-control" placeholder="unit head staff id"name="unit_head_staff_id" id="inputunit_head_staff_id" >
									</div>
								</div>
								<div class = "col-xs-12 col-sm-12 col-md-6 col-lg-4">
									<div class="form-group">
										<label for="inputunit_name" >Unit Name</label>
										<input type="TEXT" class="form-control" placeholder="unit name"name="unit_name" id="unit_name">
									</div>
								</div>
								<div class = "col-xs-12 col-sm-12 col-md-6 col-lg-4">
									<div class="form-group">
										<label for="inputdepartment_id" >Department</label>
										<input type="TEXT" class="form-control" placeholder="department id"name="department_id" id="inputdepartment_id">
									</div>
							   </div>
								<div class = "col-xs-12 col-sm-12 col-md-6 col-lg-4">
									<div class="form-group">
										<label for="beds" >Beds</label>
										<input type="TEXT" class="form-control" placeholder="bed id"name="beds" id="beds">
									</div>
								</div>
							
				        		<div class = "col-xs-12 col-sm-12 col-md-6 col-lg-4">
									<div class="form-group">
										<label for="inputop_room_no" >Lab Report Staff</label>
										<input type="TEXT" class="form-control" placeholder="lab report staff id"name="lab_report_staff_id" id="inputlab_report_staff_id">
									</div>
								</div>
							</div>
							<div class = "col-md-4 col-md-offset-3">
								<div class="row">
									<div class="col-md-12">
										<center><button class="btn btn-default" type="submit" name="Submit" id="btn">Submit</button></center>
									</div>
								</div>
							</div>
						</div>
						<?php echo form_close(); ?>
				</div>
					
					
					
