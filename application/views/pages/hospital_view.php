  	<center>	
<?php if(isset($msg)){  ?>
	<div class="alert alert-info"><?php echo $msg; ?>
	</div>
<?php } ?>
	<?php echo validation_errors(); ?>
	</center>
			
			<h2 align="center">Hospital</h2><br>
			<?php echo form_open('hospital/add_hospital',array('class'=>'form-group','role'=>'form','id'=>'add_hospital')); ?>
				<div class="col-md-8 col-md-offset-3">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="inputhospital ">Hospital Name</label>
								<input class="form-control" name="hospital" id="inputhospital" placeholder="enter name" type="TEXT" align="middle">
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="Inputplace">Place</label>
								<input class="form-control" name="place" id="inputplace" placeholder="enter name" type="TEXT" align="middle">
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-6  col-lg-4">
							<div class="form-group">
								<label for="inputhospital_short_name ">Hospital Short Name</label>
								<input class="form-control" name="hospital_short_name" id="inputhospital_short_name" placeholder="enter name" type="text">
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="Inputdistrict" >District</label>
								<input class="form-control" name="district" id="inputdistrict" placeholder="enter name" type="TEXT" align="middle">
							</div>	
						</div>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="Inputstate" >State</label>
								<input class="form-control" name="state" id="inputstate" placeholder="enter name" type="TEXT" align="middle">
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="Inputtype1">Type1</label>
								<select class="form-control" name="type1">
									<option value="" selected="selected">select</option>
									<option value="Private">Private</option>
									<option value="Public">Public</option>
									<option value="Non-profif">Non-Profit</option>
								</select>
							</div>	
						</div>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="Inputtype2" >Type2</label>
								<select class="form-control" name="type2">
									<option value="" selected="selected">select</option>
									<option value="State Govt.">State Government</option>
									<option value="Central Govt.">Central Government</option>
								</select>
							</div>	
						</div>
					   <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="Inputtype3" >Type3</label>
								<select class="form-control" name="type3">
									<option value="" selected="selected">select</option> 
									<option value="Teaching">Teaching</option>
									<option value="Non-Teaching">Non-Teaching</option>
								</select>
							</div>	
						</div>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="Inputtype4">Type4</label>
								<select class="form-control" name="type4">
									<option value="" selected="selected">select</option>
									<option value="District">District</option>
									<option value="Area">Area</option>
									<option value="CHC">CHC</option>
									<option value="PHC">PHC</option>
									<option value="Sub">Sub Centre</option>
								</select>
							</div>	
						</div>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="Inputtype5">Type5</label>
								<select class="form-control" name="type5">
									<option value="" selected="selected">select</option>
									<option value="Urban">Urban</option>
									<option value="Rural">Rural</option>
								</select>
							</div>	
						</div>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="Inputtype6">Type6</label>
								<select class="form-control" name="type6">
									<option value="" selected="selected">select</option>
									<option value="DME">DME</option>
									<option value="VVP">VVP</option>
									<option value="DH">DH</option>
								</select>
							</div>	
						</div>
						<div class="col-xs-12 col-sm-12 col-md-6  col-lg-4">
							<div class="form-group">
								<label for="Inputdescription">Description</label>
								<textarea class="form-control" name="description" rows="3"></textarea>
							</div>
						</div>
						<div class="col-md-12">
							<center><button class="btn btn-default" type="submit" name="Submit" id="btn">Submit</button></center>
						</div>
					</div>
				</div>
            <?php echo form_close(); ?>	
