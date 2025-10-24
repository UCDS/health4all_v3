<center>
	<?php
	echo validation_errors('<div class="alert alert-danger">', '</div>');
	if (isset($msg)){ ?>
		<div class="alert alert-info">
			<?php echo $msg;?>
		</div>
	<?php } ?>
</center>

<div class="container">
	<h2><center>Create Supply Chain Party</center></h2><br><!--Heading-->
	<?php echo form_open('consumables/supply_chain_party/add_supply_chain_party',array('class'=>'form-group','role'=>'form','id'=>'evaluate_applicant')); ?>
		<div class="col-md-12 col-md-offset-2">
			<div class="row">
				<div class="col-md-3">
					<div class="form-group">
						<!-- Supply Chain Party Name Field -->
						<label for="supply_chain_party_name">Supply Chain Party <font style="color:red">*</font></label>
						<input class="form-control" name="supply_chain_party_name" id="supply_chain_party_name"
							placeholder="Enter Supply Chain Party Name" type="text" required>
					</div>
				</div>

				<div class="col-md-4" id="ifYes1" style="display:none;">
					<div class="form-group">
						<label for="department">Department</label>
						<select name="department" id="department" class="form-control">
							<option value="">Select</option>
							<?php foreach($departments as $dept) {
								echo "<option value='".$dept->department_id."'>".$dept->department."</option>";
							} ?>
						</select>
					</div>
				</div>

				<div class="col-md-4" id="ifYes2" style="display:none;">
					<div class="form-group">
						<label for="area">Area</label>
						<select name="area" id="area" class="form-control">
							<option value="">Select</option>
							<?php foreach($all_area as $are) {
								echo "<option value='".$are->area_id."' class='".$are->department_id."'>".$are->area_name."</option>";
							} ?>
						</select>
					</div>
				</div>

				<div class="col-md-3" id="ifNo" style="display:none;">
					<div class="form-group">
						<label for="vendor">Vendor</label>
						<select name="vendor" id="vendor" class="form-control">
							<option value="">Select</option>
							<?php foreach($all_vendor as $ven) {
								echo "<option value='".$ven->vendor_id."'>".$ven->vendor_name."</option>";
							} ?>
						</select>
					</div>
				</div>

				<div class="col-md-3">
					<div class="form-group">
						<div class="">
							<label class="radio-inline" for="internalCheck">
								<input type="radio" name="int_ext" id="internalCheck" value="1" checked onclick="yesnoCheck();">
								Internal
							</label>
							<label class="radio-inline" for="externalCheck">
								<input type="radio" name="int_ext" id="externalCheck" value="0" onclick="yesnoCheck();">
								External
							</label>
						</div>
					</div>
				</div>
			</div>
			<script>
				function yesnoCheck() {
					const internal = document.getElementById('internalCheck');
					const external = document.getElementById('externalCheck');
					const ifYes1 = document.getElementById('ifYes1');
					const ifYes2 = document.getElementById('ifYes2');
					const ifNo = document.getElementById('ifNo');

					if (internal.checked) {
						ifYes1.style.display = 'block';
						ifYes2.style.display = 'block';
						ifNo.style.display = 'none';
					} else if (external.checked) {
						ifNo.style.display = 'block';
						ifYes1.style.display = 'none';
						ifYes2.style.display = 'none';
					}
				}

				window.onload = function() {
					// Ensure "Internal" is checked by default
					document.getElementById('internalCheck').checked = true;
					yesnoCheck();
				};
			</script>
		</div>
		<div class="col-lg-12">
				<center><button class="btn btn-primary" type="submit" name="submit" id="btn">Submit</button></center>
		</div>
</div>
<?php echo form_close(); ?>
