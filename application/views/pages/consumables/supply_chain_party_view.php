<center>
<?php
 echo validation_errors();
 if (isset($msg)){ ?>
	<div class="alert alert-info">
		<?php echo $msg;?>
	</div>
	<?php } ?>
	</center>

				<script type="text/javascript">
 window.onload = function() {
    document.getElementById('ifYes1').style.display = 'none';
    document.getElementById('ifYes2').style.display = 'none';
    
    
    document.getElementById('ifNo').style.display = 'none';
}
function yesnoCheck() {
    if (document.getElementById('yesCheck').checked) {
        document.getElementById('ifYes1').style.display = 'block';
        document.getElementById('ifYes2').style.display = 'block';
        document.getElementById('ifNo').style.display = 'none';

    } 
    else if(document.getElementById('noCheck').checked) {
        document.getElementById('ifNo').style.display = 'block';
        document.getElementById('ifYes1').style.display = 'none';
        document.getElementById('ifYes2').style.display = 'none';

   }


}
</script>
	
		<div class="container">
			<h2><center>Create Supply Chain Party</center></h2><br><!--Heading-->
			<?php echo form_open('consumables/supply_chain_party/add_supply_chain_party',array('class'=>'form-group','role'=>'form','id'=>'evaluate_applicant')); ?>
				<div class="col-md-6 col-md-offset-2">
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
							<!--Supply Chain Party Name Field-->
								<label for="Name_supply_chain_party_name">Supply Chain Party	<font style="color:red">*</font></label>
								<input class="form-control" name="supply_chain_party_name" id="supply_chain_party_name" placeholder="Enter Supply Chain Party Name" type="text" align="middle" required>
							</div><!--Supply Chain Party Name Field end-->
						</div>
						<div class="col-md-3">
							<div class="form-group">
							<div class="radio">
								<label  for="yesCheck">
								<input type="radio" onclick="javascript:yesnoCheck();" name="in_house" id="yesCheck" value="in_house"  aria-label="...">In House
								</label>
							</div>
						</div>
						</div>
						<div class="col-md-3">
							<div class="radio">
								<label  class="radio-inline" for="noCheck">
								<input type="radio" onclick="javascript:yesnoCheck();"  name="in_house" id="noCheck" value="external" aria-label="...">External
							</div>
						</div>
						</div>
						</div>
						<div class="col-md-6 col-md-offset-2">
						<div class="row">
						<div class="col-md-4" id="ifYes1" style="display:none">
							<div class="form-group">
								<label for="department">Department</label><!--Department field-->
								<select name="department" id="department" class="form-control">
									<option value="">Select</option>
								<?php
								foreach($departments as $dept)
									{
										echo"<option value='".$dept->department_id."'>".$dept->department."</option>";
									
									}
									?>
								</select>
							</div>	<!--Department field end-->
						</div>		
						<div class="col-md-4" id="ifYes2" style="display:none">
							<div class="form-group">
								<label for="area">Area</label><!--Area field-->
								<select name="area" id="area" class="form-control">
									<option value="">Select</option>
								<?php
								foreach($all_area as $are)
									{
										echo"<option value='".$are->area_id."'  class='".$are->department_id."'>".$are->area_name."</option>";
									
									}
									?>
								</select>
							</div><!--Area field end-->	
						</div>	
						</div>
						</div>	
						<div class="col-md-6 col-md-offset-2">
							<div class="row">
						
						<div class=" col-md-6" id="ifNo" style="display:none">
							<div class="form-group">
								<label for="vendor">Vendor</label><!--Vendor field-->
								<select name="vendor" id="vendor" class="form-control">
									<option value="">Select</option>
								<?php
								foreach($all_vendor as $ven)
									{
										echo"<option value='".$ven->vendor_id."'>".$ven->vendor_name."</option>";
									
									}
									?>
								</select>
							</div>	<!--Vendor field end-->
						</div>
						</div>
						</div>		
					<div class="col-lg-12">
							<center><button class="btn btn-primary" type="submit" name="submit" id="btn">Submit</button></center>
</div>
							</div>
						<?php echo form_close(); ?>
