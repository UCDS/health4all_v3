	<style>
	#sortable .control-label{
		font-size:0.8em;
	}
	</style>
	<!-- Include scripts for jQuery Sortable -->
	<script src="<?php echo base_url(); ?>assets/js/jquery.ui.core.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.ui.widget.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.ui.mouse.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.ui.sortable.min.js"></script> 
	<script>
	$(function() {
		$( "#sortable" ).sortable();
		$( "#sortable" ).disableSelection();
		$(".checklist").click(function(){
				$(".alert-info").hide();
			var id=$(this).attr('id');
			if($(this).is(":checked")){
				if(id == 'district' || id== 'state' || id == 'country') {
					$('#district,#state,#country').prop("checked",true);
					$('.district,.state,.country').show();
				}else {
					$("."+id).show();
				}
			}
			else{
				if(id == 'district' || id== 'state' || id == 'country') {
					$('#district,#state,#country').prop("checked",false);
					$('.district,.state,.country').hide();
				}else {
					$("."+id).hide();
				}
			}
		});
		$("#save-form").click(function(e){
			e.preventDefault();
			columns=$('input:radio[name=cols]:checked').val();
			form_name=$('input:text[name=form_name]').val();
			form_type=$('select[name=form_type]').val();
			print_layout=$('select[name=print_layout]').val();

			fields={};
			fields['field_name']=[];
			fields['mandatory']=[];
			$(".layout-div:visible").each(function(){
				if($(this).find(".mandatory").is(":checked")){
					fields['mandatory'].push(1);
				}
				else{
					fields['mandatory'].push(0);
				}
				var cname=$(this).attr('class').replace(/col-md-[0-9]+/, "").replace(/layout-div/, "").trim();
				fields['field_name'].push(cname);
			});
			$.ajax({
				type:"POST",
				async:true,
				data : {form_name:form_name,columns:columns,form_type:form_type,print_layout:print_layout,fields:JSON.stringify(fields)},
				url : "<?php echo base_url()."user_panel/create_form"; ?>",
				success : function(returnData){
					if(returnData==1){
						$(".panel").parent().prepend("<div class='alert alert-success'>Form created successfully!</div>");
						$("#save-form").attr('disabled',true);
						window.setTimeout(function(){location.reload()},3000)
					}
					else{
						$(".panel").parent().prepend("<div class='alert alert-danger'>Oops! Some error occured! Please retry.</div>");
					}
				}
			});
		});
		$(".num_cols").click(function(){
			if($(this).val()==1){
				$(".form .layout-div").each(function(){
					$(this).removeClass("col-md-4").removeClass("col-md-6").addClass("col-md-12");
					$(this).css('width','100%');
				});
			}
			if($(this).val()==2){
				$(".layout-div").each(function(){
					$(this).removeClass("col-md-4").removeClass("col-md-12").addClass("col-md-6");
					$(this).css('width','50%');
				});
			}
			if($(this).val()==3){
				$(".form .layout-div").each(function(){
					$(this).removeClass("col-md-4").removeClass("col-md-12").addClass("col-md-6");
					$(this).css('width','33%');
				});
			}
		});
		$(".star").click(function(){
			if($(this).find(".mandatory").is(":checked")){
				$(this).find(".mandatory").prop('checked',false);
				$(this).css('color','#ccc');
			}
			else{
				$(this).find(".mandatory").prop('checked',true);
				$(this).css('color','red');
			}
				
		});
		
	});
  </script>
<?php echo form_open('user_panel/form_layout',array('role'=>'form','class'=>'form-custom','id'=>'new-form')); ?>
			<div class="col-md-10" >
				<h4>Create Form for Patient Registration</h4>
				<div class="panel panel-default">
				<div class="panel-heading">
				<div class="row">
					<div class="col-md-4">
						<label class="control-label">Select number of columns :</label>
						<div class="radio">
							<label class="control-label"><input type="radio" value="1" name="cols" class="num_cols" />1</label>
						</div>
						<div class="radio">
							<label class="control-label"><input type="radio" value="2" name="cols" class="num_cols" />2</label>
						</div>
						<div class="radio">
							<label class="control-label"><input type="radio" value="3" name="cols" class="num_cols" checked />3</label>
						</div>
					</div>					
					<div class="col-md-4">
						<div class="form-group">
						<label class="control-label">Select form type</label>
						<select class="form-control" name="form_type" id="form-type" required >
							<option value="">Select</option>
							<option value="OP">OP</option>
							<option value="IP">IP</option>
						</select>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
						<label class="control-label">Form Name</label>
						<input type="text" name="form_name" class="form-control" required />
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
						<label class="control-label">Print Layout</label>
						<select class="form-control" name="print_layout" id="print_layout" required >
							<option value="">Select</option>
							<?php foreach($print_layouts as $layout){
								echo "<option value='$layout->print_layout_id'>$layout->print_layout_name</option>";
							}
							?>
						</select>
						</div>
					</div>
				</div>
				</div>
				<div class="panel-body">
				<div class="alert alert-info">Select fields from the right menu to start creating the form! >></div>
				<div class="form row" id="sortable">
                                        <div class="layout-div col-md-4 patient_id_manual">
						<div class="form-group">
						<label class="control-label">   Patient ID Manual  </label>
							<input type="text" name="patient_id_manual" style="width: 170px" class="form-control"/>
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 first_name">
						<div class="form-group">
						<label class="control-label">   First Name  </label>
							<input type="text" name="first_name" style="width: 170px" class="form-control"/>
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<!-- here we use input type for obtaining textbox for first_name,last_name,age, place, Phone-->
					<div class="layout-div col-md-4 last_name">
						<div class="form-group">
						<label class="control-label">  Last Name    </label>
							<input type="text" name="last_name" style="width: 170px" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 age">
						<div class="form-group">
						<label class="control-label">   Age          </label>
						<input type="text" name="age" style="width: 170px" class="form-control"/>
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 gender">
						<div class="radio ">
						<label class="control-label">
							<input type="radio" name="gender" value="1" checked />Male
						</label>
						<label class="control-label">
							<input type="radio" name="gender" value="1" />Female
						</label>
						<label class="control-label">
							<input type="radio" name="gender" value="1" />Other
						</label>
						</div>					
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
					</div>
                    <div class="layout-div col-md-4 address">
						<div class="form-group">
						<label class="control-label">    Address    </label>
						<input type="text" name="address" style="width: 170px" class="form-control"/>
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 place">
						<div class="form-group">
						<label class="control-label">   Place      </label>
							<input type="text" name="place" style="width: 170px" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 country">
						<div class="form-group">
						<label class="control-label">   Country   </label>
						<select name="country" class="form-control">
						<option value="">--Select--</option>
						<?php 
						foreach($states as $state){
							echo "<option value='".$state->state_id."'>".$state->state."</option>";
						}
						?>
						</select>
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 state">
						<div class="form-group">
						<label class="control-label">   State   </label>
						<select name="state" class="form-control">
						<option value="">--Select--</option>
						<?php 
						foreach($states as $state){
							echo "<option value='".$state->state_id."'>".$state->state."</option>";
						}
						?>
						</select>
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 district">
						<div class="form-group">
						<label class="control-label">   District   </label>
						<select name="district" class="form-control">
						<option value="">--Select--</option>
						<?php 
						foreach($districts as $district){
							echo "<option value='".$district->district_id."'>".$district->district."</option>";
						}
						?>
						</select>
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 phone">
						<div class="form-group">
						<label class="control-label">    Phone    </label>
						<input type="text" name="phone" style="width: 170px" class="form-control"/>
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<!-- here we use input type for obtaining textbox for father_name,mother_name-->
					<div class="layout-div col-md-4 father_name">
						<div class="form-group">
						<label class="control-label"> Father Name </label>
						<input type="text" name="father_name" style="width: 170px" class="form-control"/>
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 mother_name">
						<div class="form-group">
						<label class="control-label"> Mother Name  </label>
						<input type="text" name="mother_name" style="width: 170px"  class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<!-- here spouse_name is display only if the patient is female -->
					<div class="layout-div col-md-4 spouse_name">
						<div class="form-group">
						<label class="control-label"> Spouse Name </label>
						<input type="text" name="spouse_name" style="width: 170px"  class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 id_proof_type">
					<div class="form-group">
						<label class="control-label"> ID Proof Type</label>
						<select class="form-control" name="id_proof_type" id="id_proof_type" required >
							<option value="">Select</option>				
							<option value="id type1">Pan Card</option>
							<option value="id type2">Aadhar Card</option>
							<option value="id type3">Voter Card</option>
                        </select>
				       <span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
				      </div>
					</div>
					<div class="layout-div col-md-4 id_proof_no">
					    <div class="form-group">
				         <label class="control-label">ID proof No.</label>
							<input type="text" name="id_proof_no" style="width:170px" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
						<div class="layout-div col-md-4 occupation">
						<label class="control-label"> Occupation: </label>
						<select class="form-control" name="occupation" id="occupation" >
							<option value="">Select</option>
							<option value="private">Private</option>
							<option value="government">Government</option>
						</select>
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
					    </div>
					<div class="layout-div col-md-4 education_level">
						<div class="form-group">
						<label class="control-label"> Education Level </label>
					    <input type="text" name="education_level" style="width: 170px" class="form-control" />
					<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
					 </div>
					</div>
					<!-- here we use select class in order to obtain a drop-down box for Education Qualification -->
					<div class="layout-div col-md-4 education_qualification">
						<div class="form-group">
						<label class="control-label">Education Qualification</label>
						<select class="form-control" name="education_qualification" id="education_qualification" required >
							<option value="">Select</option>
							<option value="SSC">ssc</option>
							<option value="INTERMEDIATE">Intermediate</option>
							<option value="B.TECH">B.tech</option>
							<option value="M.TECH">M.tech</option>
				            <option value="M.Sc">M.Sc</option>
							<option value="Undergraduate">Undergraduate</option>
						</select>
					<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<!-- here we use select class in order to obtain a drop-down box for Blood Group -->
					<div class="layout-div col-md-4 blood_group">
					    <div class="form-group">
						<label class="control-label">Blood Group</label>
						<select class="form-control" name="blood_group" id="blood_group" required >
							<option value="">Select</option>
							<option value="A+">A+</option>
							<option value="A-">A-</option>
							<option value="B+">B+</option>
							<option value="B-">B-</option>
				            <option value="AB+">AB+</option>
							<option value="AB-">AB-</option>
							<option value="O+">O+</option>
							<option value="O-">O-</option>
						</select>
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 birth_information">
						<div class="form-group">
						<label class="control-label">Birth Information</label>
						<input type="text" name="birth_information" style="width: 170px"  class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 gestation">
						<div class="form-group">
						<label class="control-label">Gestation</label>
						<input type="text" name="gestation" style="width: 170px"  class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<!-- here we use select class in order to obtain a drop-down box for Gestation Type -->
					<div class="layout-div col-md-4 gestation_type">
						<div class="form-group">
						<label class="control-label"> Gestation Type </label>
						<select class="form-control" name="gestation_type" id="gestation_type" required >
							<option value="">Select</option>
							<option value="long_peroid">Long Peroid</option>
							<option value="short_peroid">Short Period</option>
                        </select>
						</div>
					</div>
					<!-- here we use select class in order to obtain a drop-down box for Delivery Mode -->
					<div class="layout-div col-md-4 delivery_mode">
						<div class="form-group">
						<label class="control-label">Delivery Mode</label>
						<select class="form-control" name="delivery_mode" id="delivery_mode" required >
							<option value="">Select</option>
							<option value="normal">Normal</option>
							<option value="surgical">Surgical</option>
                        </select>
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 delivery_place">
						<div class="form-group">
						<label class="control-label"> Delivery Place </label>
						<input type="text" name="delivery_place" style="width: 170px" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 delivery_location">
						<div class="form-group">
						<label class="control-label"> Delivery Location </label>
						<input type="text" name="delivery_location" style="width: 170px" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 delivery_location_type">
						<div class="form-group">
						<label class="control-label">Delivery Location Type</label>
						<select class="form-control" name="delivery_location_type" id="delivery_location_type" required >
							<option value="">Select</option>
							<option value="private">Private</option>
							<option value="government">Government</option>
						</select>
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
					    </div>
					</div>
					<div class="layout-div col-md-4 delivery_plan">
						<div class="form-group">
						<label class="control-label">  Delivery Plan   </label>
						<input type="text" name="delivery_plan" style="width: 170px" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 birth_weight">
						<div class="form-group">
						<label class="control-label">   Birth Weight  </label>
						<input type="text" name="birth_weight" style="width: 170px" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
                    <div class="layout-div col-md-4 visit_name">
						<div class="form-group">
						<label class="control-label"> Visit Type </label>
						<input type="text" name="visit_name" style="width: 170px" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
						</div>
						<div class="layout-div col-md-4 hospital">
						<div class="form-group">
						<label class="control-label">   Hospital   </label>
						<input type="text" name="hospital" style="width: 170px" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>				
					<div class="layout-div col-md-4 department">
						<div class="form-group">
						<label class="control-label">  Department   </label>
						<select name="department" style="width: 170px" class="form-control">
						<option value="">--Select--</option>
						<?php 
						foreach($departments as $department){
							echo "<option value='".$department->department_id."'>".$department->department."</option>";
						}
						?>
						</select>	
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 area">
						<div class="form-group">
						<label class="control-label">   Area   </label>
						<select name="area" class="form-control">
						<option value="">--Select--</option>
						<?php 
						foreach($areas as $area){
							echo "<option value='".$area->area_id."'>".$area->area_name."</option>";
						}
						?>
						</select>	
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 insurance_case">
						<div class="radio ">
						<label class="control-label">
							<input type="radio" name="insurance_case" value="1" checked />No
						</label>
						<label class="control-label">
							<input type="radio" name="insurance_case" value="1" />Yes
						</label>
						</div>					
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
					</div>
					
					<div class="layout-div col-md-4 insurance_no">
						<div class="form-group">
						<label class="control-label">Insurance Number</label>
						<input type="text" name="insurance_no" style="width: 170px" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 hospital_type">
						<div class="form-group">
						<label class="control-label">Hospital Type</label>
						<select class="form-control" name="hospital_type id="hospital_type" required >
							<option value="">Select</option>
							<option value="private">PRIVATE</option>
							<option value="government">GOVERNMENT</option>
						</select>
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 unit">
						<div class="form-group">
						<label class="control-label">Unit</label>
						<select name="unit" class="form-control">
						<option value="">--Select--</option>
						<?php 
						foreach($units as $unit){
							echo "<option value='".$unit->unit_id."'>".$unit->unit_id."</option>";
						}
						?>
						</select>	
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 mlc">
						<div class="radio ">
						<label class="control-label" title="Medico Legal Case">MLC</label>
						<label class="control-label">
							<input type="radio" name="mlc" value="1" />Yes
						</label>
						<label class="control-label">
							<input type="radio" name="mlc" value="0" checked />No
						</label>
						</div>					
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
					</div>
					<div class="layout-div col-md-4 mlc_number_manual">
						<div class="form-group">
						<label class="control-label">Manual MLC Number</label>
						<input type="text" name="mlc_number_manual" style="width: 170px" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 ps_name">
						<div class="form-group">
						<label class="control-label">PS Name</label>
						<input type="text" name="ps_name" style="width: 170px" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 pc_number">
						<div class="form-group">
						<label class="control-label">Constable #</label>
						<input type="text" name="pc_number" style="width: 170px" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 brought_by">
						<div class="form-group">
						<label class="control-label">Brought By</label>
						<input type="text" name="brought_by" style="width: 170px" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 police_intimation">
						<div class="radio ">
						<label class="control-label" title="Medico Legal Case">Police Intimation</label>
						<label class="control-label">
							<input type="radio" name="police_intimation" value="1" />Yes
						</label>
						<label class="control-label">
							<input type="radio" name="police_intimation" value="0" checked />No
						</label>
						</div>					
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
					</div>
					<div class="layout-div col-md-4 declaration_required">
						<div class="radio ">
						<label class="control-label" title="Medico Legal Case">Declaration Req?</label>
						<label class="control-label">
							<input type="radio" name="declaration_required" value="1" />Yes
						</label>
						<label class="control-label">
							<input type="radio" name="declaration_required" value="0" checked />No
						</label>
						</div>					
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
					</div>
					<div class="layout-div col-md-4 identification_marks">
						<div class="form-group">
						<label class="control-label">Identification Marks</label>
						<input type="text" name="identification_marks" style="width: 170px" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 presenting_complaints">
						<div class="form-group">
						<label class="control-label">Complaint</label>
						<input type="text" name="presenting_complaints" style="width: 170px" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 past_history">
						<div class="form-group">
						<label class="control-label">Past history</label>
						<input type="text" name="" class="past_history" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 admit_weight">
						<div class="form-group">
						<label class="control-label">Admit Weight</label>
						<input type="text" name="" class="admit_weight" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 discharge_weight ">
						<div class="form-group">
						<label class="control-label">Discharge Weight</label>
						<input type="text" name="" class="discharge_weight" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 pulse_rate">
						<div class="form-group">
						<label class="control-label">Pulse Rate</label>
						<input type="text" name=" control-label" style="width: 170px" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 respiratory_rate">
						<div class="form-group">
						<label class="control-label">Respiratory Rate</label>
						<input type="text" name="id_no" style="width: 170px" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 temperature">
						<div class="form-group">
						<label class="control-label">Temperature</label>
					    <input type="text" name="temperature" style="width: 170px" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 blood_pressure">
						<div class="form-group">
						<label class="control-label">BP</label>
							<input type="text" name="sbp" style="width: 50px" class="form-control"/>/
							<input type="text" name="dbp" style="width: 50px" class="form-control"/>
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 provisional_diagnosis">
						<div class="form-group">
						<label class="control-label">Provisional Diag.</label>
						<input type="text" name="provisional_diagnosis" style="width: 170px" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 outcome">
						<div class="radio ">
						<label class="control-label">
							<input type="radio" name="outcome" value="Discharge" checked />Discharge
						</label>
						<label class="control-label">
							<input type="radio" name="outcome" value="LAMA" checked />LAMA
						</label>
						<label class="control-label">
							<input type="radio" name="outcome" value="Absconded" checked />Absconded
						</label>
						<label class="control-label">
							<input type="radio" name="outcome" value="Death" checked />Death
						</label>
						</div>					
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
					</div>
					<div class="layout-div col-md-4 outcome_date">
						<div class="form-group">
						<label class="control-label">Outcome Date</label>
							<input type="text" name="outcome_date" style="width: 170px" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 outcome_time">
						<div class="form-group">
						<label class="control-label">Outcome Time</label>
						<input type="text" name="outcome_time" style="width: 170px" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 congenital_anomalies">
						<div class="form-group">
						<label class="control-label">Congenital anomalies</label>
						<input type="text" name="congenital_anomalies" style="width: 170px" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					<div class="layout-div col-md-4 final_diagnosis">
						<div class="form-group">
						<label class="control-label">Final Diag.</label>
						<input type="text" name="final_diag." style="width: 170px" class="form-control" />
						<span class="star" title="Click to toggle mandatory">*<input type="checkbox" value="1" class="mandatory" hidden /></span>
						</div>
					</div>
					
					<div class="layout-div col-md-12 patient_picture">
						<div class="form-group well well-sm">
						<div class="row">
							<div class="col-md-12">
							<p class="col-md-6" id="results-text">Captured image will appear here..</p>
							<p class="col-md-6">Camera View</p>
							<div id="results" class="col-md-6 results"></div>
							
							<div id="my_camera" class="col-md-6"></div>
							</div>
						</div>
							<div class="col-md-offset-6" style="position:relative;top:5px">
							
							<!-- A button for taking snaps -->
								<div id="button">
									<input id="patient_picture" type="hidden" class="sr-only" name="patient_picture" value=""/>
									<button class="btn btn-default btn-sm" type="button" onclick="save_photo()"><i class="fa fa-camera"></i> Take Picture</button>
								</div>
							</div>
							<!-- First, include the Webcam.js JavaScript Library -->
							<script type="text/javascript" src="<?php echo base_url();?>assets/js/webcam.min.js"></script>
							
							<!-- Configure a few settings and attach camera -->
							<script language="JavaScript">
								Webcam.set({
									width: 320,
									height: 240,
									// device capture size
									dest_width: 320,
									dest_height: 240,
									// final cropped size
									crop_width: 200,
									crop_height: 240,											
									image_format: 'jpeg',
									jpeg_quality: 90
								});
								Webcam.attach( '#my_camera' );
							</script>
							
							<!-- Code to handle taking the snapshot and displaying it locally -->
							<script language="JavaScript">
								
								function save_photo() {
									// actually snap photo (from preview freeze) and display it
									Webcam.snap( function(data_uri) {
										// display results in page
										document.getElementById('results').innerHTML = 
											'<img src="'+data_uri+'"/>';
										document.getElementById('results-text').innerHTML = 
											'Captured Image';
										//Store image data in input field.
										var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
										
										document.getElementById('patient_picture').value = raw_image_data;
										
										// swap buttons back
										document.getElementById('pre_take_buttons').style.display = '';
										document.getElementById('post_take_buttons').style.display = 'none';
									} );
								}
							</script>
							
						</div>
					</div>
			        </div>
					
				</div>
				<div class="panel-footer">
					<button type="submit" class="btn btn-primary" id="save-form">Save</button>
				</div>
				</div>
			</div>
			<div class="col-sm-3 col-md-2 sidebar">
			<strong>Patient Information</strong>
			  <ul class="nav nav-sidebar">
			  <!--here we are labelling the field_name on the left side of the form-->
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="patient_id_manual" class="checklist" />Patient ID Manual</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="first_name" class="checklist" />First name</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="last_name" class="checklist" />Last name</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="age" class="checklist" />Age</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="gender" class="checklist" />Gender</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="address" class="checklist" />Address</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="place" class="checklist" />Place</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="country" class="checklist" />Country</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="district" class="checklist" />District</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="state" class="checklist" />State</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="phone" class="checklist" />Phone</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="father_name" class="checklist" />Father's Name</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="mother_name" class="checklist" />Mother's Name</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="spouse_name" class="checklist" />Spouse Name</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="id_proof_type" class="checklist" />ID Proof Type</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="id_proof_no " class="checklist" />ID Proof NO.</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="occupation" class="checklist" />Occupation</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="education_level" class="checklist" />Education Level</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="education_qualification" class="checklist" />Education Qualification</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="blood_group" class="checklist" />Blood Group</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="identification_mark_1" class="checklist" />Identification Mark 1</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="identification_mark_2" class="checklist" />Identification Mark 2</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="patient_picture" class="checklist" />Picture</label>
					</div>
				</li>
			</ul>
			<strong>Birth Information</strong>
			  <ul class="nav nav-sidebar">
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="gestation" class="checklist" />Gestation</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="gestation_type" class="checklist" />Gestation Type</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="delivery_mode" class="checklist" />Delivery Mode</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="delivery_place" class="checklist" />Delivery Place</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="delivery_location" class="checklist" />Delivery Location</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="hospital_type" class="checklist" />Hospital Type</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="delivery_location_type" class="checklist" />Delivery Location Type</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="delivery_plan" class="checklist" />Delivery Plan</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="birth_weight" class="checklist" />Birth Weight</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="congenital_anomalies" class="checklist" />Congenital Anomalies</label>
					</div>
				</li>     
			  </ul>
			<strong>Visit Information</strong>
			  <ul class="nav nav-sidebar">
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="visit_name" class="checklist" />Visit Type</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="hospital" class="checklist" />Hospital</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="department" class="checklist" />Department</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="unit" class="checklist" />Unit</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="area" class="checklist" />Area</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="insurance_case" class="checklist" />Insurance Case</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="insurance_no" class="checklist" />Insurance No.</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="presenting_complaints" class="checklist" />Presenting Complaint</label>
					</div>
				</li>  
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="past_history" class="checklist" />Past History</label>
					</div>
				</li>  
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="admit_weight" class="checklist" />Admit Weight</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="discharge_weight" class="checklist" />Discharge Weight </label>
					</div>
				</li>				
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="pulse_rate" class="checklist" />Pulse Rate</label>
					</div>
				</li>  
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="respiratory_rate" class="checklist" />Respiratory Rate</label>
					</div>
				</li>  
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="temperature" class="checklist" />Temperature</label>
					</div>
				</li> 
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="blood_pressure" class="checklist" />Blood Pressure</label>
					</div>
				</li> 
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="provisional_diagnosis" class="checklist" />Provisional Diagnosis</label>
					</div>
				</li> 
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="outcome" class="checklist" />Outcome</label>
					</div>
				</li> 
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="outcome_date" class="checklist" />Outcome Date</label>
					</div>
				</li> 
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="outcome_time" class="checklist" />Outcome Time</label>
					</div>
				</li> 
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="final_diagnosis" class="checklist" />Final Diagnosis</label>
					</div>
				</li> 
			</ul>
			<strong>MLC Information</strong>
			  <ul class="nav nav-sidebar">
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="mlc" class="checklist" />MLC</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="mlc_number_manual" class="checklist" />Manual MLC Number</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="ps_name" class="checklist" />PS Name</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="pc_number" class="checklist" />Constable #</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="brought_by" class="checklist" />Brought By</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="police_intimation" class="checklist" />Police Intimation</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="declaration_required" class="checklist" />Declaration Required</label>
					</div>
				</li>
			</div>
      </form>

