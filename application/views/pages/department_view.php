<?php 
echo validation_errors();

if (isset($msg)){ ?>
	<div class="alert alert-info">
		<?php echo $msg;?>
	</div>
	<?php } ?>
				<h2 align="center">Hospital Departments</h2></br></br>
				<?php echo form_open('departments/add_department',array('class'=>'form-group','role'=>'form','id'=>'evaluate_applicant')); ?>
					<div class="container">
						<div class="row">
							<div class = "col-xs-12 col-sm-12 col-md-6 col-lg-4">
									<div class="form-group">
										<label for="inputhospital_id" >Hospital</label>
											<select name="hospital_id" id="department" class="form-control">
												<option value="">select</option>
													<?php 
														foreach($hospitals as $hosp){
														echo "<option value='".$hosp->hospital_id."'>".$hosp->hospital."</option>";
																						}
													?>
											</select>
									</div>
								</div>
							<div class = "col-xs-12 col-sm-12 col-md-6 col-lg-4">
								<div class="form-group">
									<label for="inputdepartment" >Department Name</label>
									<input type="TEXT" class="form-control" name="department" id="department" placeholder="Enter Department name">						
								</div>
							</div>
								
							<!--<div class = "col-xs-12 col-sm-12 col-md-6 col-lg-4">
								<div class="form-group"> 
									<label for="inputlab_report_staff_id" >Lab Report Staff Id</label>
										<input type="TEXT" class="form-control" name="lab_report_staff_id" id="inputlab_report_staff_id" placeholder="enter Lab repot staff id">
								</div>
							</div>-->
							<div class = "col-xs-12 col-sm-12 col-md-6 col-lg-4">
								<div class="form-group">
									<label for="inputdepartment_email" >Department email</label>
										<input type="TEXT" class="form-control" name="department_email" id="inputdepartment_email" placeholder="Enter department email">
								</div>
							</div>
							<div class = "col-xs-12 col-sm-12 col-md-6 col-lg-4">
								<div class="form-group">
									<label for="inputnumber_of_units" >Number of Units</label>
										<input type="TEXT" class="form-control" name="number_of_units" id="inputnumber_of_units" placeholder="Enter number of units">
								</div>
							</div>
							<div class = "col-xs-12 col-sm-12 col-md-6 col-lg-4">
								<div class="form-group">
									<label for="inputop_room_no" >Op Room No</label>
								        <input type="TEXT" class="form-control" name="op_room_no" id="inputop_room_no" placeholder="Enter the operation room no">
								 </div>
							</div>
							<div class = "col-xs-12 col-sm-12 col-md-6 col-lg-4">
								<div class="form-group">
									<label for="inputfloor" >Floor</label>
										<input type="TEXT" class="form-control" name="floor" id="inputfloor" placeholder="Enter floor">
								</div>
							</div>
			                <div class = "col-xs-12 col-sm-12 col-md-6 col-lg-4">
							    <dl>
									<dt>Description</dt>
										<div class="form-group">
											<dd><label for="description" </label>
												<textarea class="form-control" row="3" name="description"> </textarea>
									</dIv></dd>
								</dl>
							</div>
							<div class="container">
								<div class="row">
									<div class = "col-xs-12 col-sm-12 col-md-6 col-lg-4">
										<div class="form-group">
											<label for = "inputClinical"  name="clinical">Clinical</label>
											    <div class="radio">																
												<label><input type="radio" name="optradio">yes</label>
												</div>
																															
													<div class="radio">
														<label><input type="radio" name="optradio">no</label>														
													</div>																																															
										</div>
									</div>
								</div>
							</div>
																						
																				
							<div class="container">
								<div class="row">
									<div class = "col-xs-12 col-sm-12 col-md-6 col-lg-4">
										<div class="form-group">
											<label for="inputworking days" id="checkBtn">Working days</label></br>
												<label class="checkbox-inline">
                                                    <input name="mon" type="checkbox" value="1"> mon
                                                </label>
                                                <label class="checkbox-inline">
                                                    <input name="tue" type="checkbox"  value="1"> tue
                                                </label>
                                                 <label class="checkbox-inline">
                                                         <input name="wed" type="checkbox"  value="1">wed
                                                </label>
                                                <label class="checkbox-inline">
                                                     <input name="thr" type="checkbox"  value="1"> thr
                                                </label>
						                        <label class="checkbox-inline">
                                                    <input name="fri" type="checkbox"  value="1">fri
                                                </label>
                                                <label class="checkbox-inline">
                                                    <input name="sat" type="checkbox"  value="1"> sat
                                                </label>
																										
									    </div>
			                        </div>
							    </div>
							</div>											     														
				           <div class="container">
					            <div class="row">
									<div class="col-md-12">
										<center><button class="btn btn-default" type="submit" name="Submit" id="btn">Submit</button></center>
									</div>
								</div>
							</div>
						</div>
					</div>
		    </div>
		    <?php echo form_close(); ?>
   
