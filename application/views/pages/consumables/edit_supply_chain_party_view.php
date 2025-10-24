<center>
	<?php
	
	if (isset($msg)) { ?>
		<div class="alert alert-info">
			<?php echo $msg; ?>
		</div>
	<?php } ?>
</center>
<style>
	#footer{
		position: fixed;  bottom: 0;  width: 100%;  z-index: 1000;
	}
</style>
<div class="container">
	<h2>
		<center>Edit Supply Chain Party</center>
	</h2><br>
	<!--Heading-->
	<?php echo form_open('consumables/supply_chain_party/edit_supply_chain_party', array('class' => 'form-group', 'role' => 'form', 'id' => 'edit_scp')); ?>
	<div class="col-md-12 col-md-offset-2">
		<div class="row">
			<!-- <div class="col-md-6">
				<h4>Supply Chain Party ID: <?php echo $item_result[0]->supply_chain_party_id; ?> -->
				<input type="hidden" class="sr-only" name = "supply_chain_party_id" id = "supply_chain_party_id" 
					value="<?php echo $item_result[0]->supply_chain_party_id ?>"></h4>
			<!-- </div> -->
		</div>
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<!--Supply Chain Party Name Field-->
						<label for="supply_chain_party_name">Supply Chain Party <font style="color:red">*</font></label>
						<input class="form-control" name="supply_chain_party_name" id="supply_chain_party_name"
							placeholder="Enter Supply Chain Party Name" type="text" align="middle" value="<?php echo $item_result[0]->supply_chain_party_name; ?>" required>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="department">Department</label>
						<select name="department" id="department" class="form-control">
							<option value="">Select</option>
							<?php 
							$selectedDept = $item_result[0]->department_id;
							foreach($departments as $dept) {
								$selected = ($selectedDept == $dept->department_id) ? 'selected' : '';
								echo "<option value='{$dept->department_id}' {$selected}>{$dept->department}</option>";
							}
							?>
						</select>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label for="area">Area</label>
						<select name="area" id="area" class="form-control">
							<option value="">Select</option>
							<?php 
							$selectedDept = $item_result[0]->area_id;
							foreach($all_area as $are) {
								$selected = ($selectedDept == $are->area_id) ? 'selected' : '';
								echo "<option value='".$are->area_id."' class='".$are->department_id."' $selected>".$are->area_name."</option>";
							} 
							?>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="vendor">Vendor</label>
						<select name="vendor" id="vendor" class="form-control">
							<option value="">Select</option>
							<?php 
							$selectedDept = $item_result[0]->vendor_id;
							foreach($all_vendor as $ven) {
								$selected = ($selectedDept == $ven->vendor_id) ? 'selected' : '';
								echo "<option value='".$ven->vendor_id."' $selected>".$ven->vendor_name."</option>";
							} 
							?>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<label>Type : </label>
					<div class="form-group">
						<div class="">
							<select name="int_ext" id="int_ext" class="form-control">
								<option value="" > select type </option>
								<option value="1" <?php if($item_result[0]->is_external=='1'){ echo 'selected'; } ?>>Internal</option>
								<option value="2" <?php if($item_result[0]->is_external=='2'){ echo 'selected'; } ?>>External</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script>
			$(document).ready(function() {
				function toggleFields() {
					var type = $('#int_ext').val();
					if (type === '1') {
						$('.col-md-3:has(#vendor)').hide();
						$('.col-md-4:has(#department), .col-md-4:has(#area)').show();
					} 
					else if (type === '2') {
						$('.col-md-3:has(#vendor)').show();
						$('.col-md-4:has(#department), .col-md-4:has(#area)').hide();
					} 
					else {
						$('.col-md-3:has(#vendor), .col-md-4:has(#department), .col-md-4:has(#area)').show();
					}
				}
				toggleFields();
				$('#int_ext').change(function() {
					toggleFields();
				});
			});
		</script>
	<div class="col-lg-12">
		<center><button class="btn btn-success" type="submit" name="submit" id="btn">Update</button></center>
	</div>
</div>
<?php echo form_close(); ?>