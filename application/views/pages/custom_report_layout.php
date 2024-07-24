	<style>
	#sortable .control-label{
		font-size:0.8em;
	}
	#footer{
		position: fixed;
		bottom: 0px;
		width: 100%;
	}
	</style>
	<!-- Include scripts for jQuery Sortable -->
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>

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
				$("."+id).show();				
			}
			else{				
				$("."+id).hide();				
			}
		});
		$("#save-form").click(function(e){
			e.preventDefault();
			columns = $('input:radio[name=cols]:checked').val();
			form_id = $('input:hidden[name=form_id]').val();
			from_table = $('select[name=from_table]').val();
			fields = {};
			fields['field_name'] = [];
			field_value = {};
			field_value['field_values'] = [];
			table={};
			table['table_name']=[];
			wid = {};
			wid['def_width'] = [];
			funct = {};
			funct['get_function'] = [];

			$(".layout-div:visible").each(function(){
				var cname = $(this).attr('class').replace(/col-md-[0-9]+/, "").replace(/layout-div/, "").trim();
				fields['field_name'].push(cname);
				var widthInput = $(this).find('input[name="' + cname + '_width"]');
				var width = widthInput.length > 0 ? widthInput.val().trim() : null ;
				wid['def_width'].push(width);
				var functInput = $(this).find('select[name="' + cname + '_funct"]');
				var fun = functInput.length > 0 ? functInput.val().trim() : null ;
				funct['get_function'].push(fun);
				var cvalue = $(this).find('input[type=text]').val().trim();
				field_value['field_values'].push(cvalue);
				var hiddenInput = $(this).find('input[type=hidden]');
				var ctable = hiddenInput.length > 0 ? hiddenInput.val().trim() : '';
				table['table_name'].push(ctable);
				//var ctable = $(this).find('.table_name').val().trim(); // Assuming .table_name is the class
        		//table['table_name'].push(ctable);
			});
			$.ajax({
				type: "POST",
				async: true,
				data: {form_id: form_id,from_table:from_table,columns: columns, fields: JSON.stringify(fields),wid: JSON.stringify(wid),funct: JSON.stringify(funct), field_value: JSON.stringify(field_value), table: JSON.stringify(table)},
				url: "<?php echo base_url().'user_panel/save_custom_form'; ?>",
				success: function(returnData){
					//debugger;
					if (returnData == 1){
						$(".panel").parent().prepend("<div class='alert alert-success'>Form created successfully!</div>");
						$("#save-form").attr('disabled', true);
						window.setTimeout(function(){location.reload()}, 3000);
					} else {
						$(".panel").parent().prepend("<div class='alert alert-danger'>Oops! Some error occurred! Please retry.</div>");
					}
				}
			});
		});
		$(".num_cols").click(function(){
			if($(this).val()==1){
				$(".form .layout-div").each(function(){
					$(this).removeClass("col-md-12").removeClass("col-md-6").addClass("col-md-12");
					$(this).css('width','100%');
				});
			}
			if($(this).val()==2){
				$(".layout-div").each(function(){
					$(this).removeClass("col-md-12").removeClass("col-md-12").addClass("col-md-6");
					$(this).css('width','50%');
				});
			}
			if($(this).val()==3){
				$(".form .layout-div").each(function(){
					$(this).removeClass("col-md-12").removeClass("col-md-12").addClass("col-md-6");
					$(this).css('width','33%');
				});
			}
		});		
	});
  </script>
<?php echo form_open('user_panel/form_layout',array('role'=>'form','class'=>'form-custom','id'=>'new-form')); ?>
			<div class="col-md-12" >
				<h4>Custom fields for <?php echo $form_name['report_name']; ?> Report</h4><br/>
				<div class="panel panel-default">
				<div class="panel-heading">
				<div class="row">
					<!-- <div class="col-md-4">
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
					</div>					 -->
					<div class="col-md-4">
						<div class="form-group">
						<label class="control-label">Form Name</label>
							<input type="text" name="form_name" class="form-control" value="<?php echo $form_name['report_name']; ?>" readonly />
							<input type="hidden" name="form_id" class="form-control" value="<?php echo $form_name['report_id']; ?>">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
						<label class="control-label">From Table</label>&nbsp;&nbsp;
							<select id="from_table" name="from_table" class="form-control" onchange="checkSelection(this)" required>								<option value="#">Select From Table</option>
								<option value="patient">Patient</option>
								<option value="patient_visit">Patient Visit</option>
								<option value="patient_followup">Patient Followup</option>
							</select>
						</div>
					</div>
					<div id="requiredMessage" style="color: red;text-align:left;margin-bottom:10px;"></div>
					<script>
						document.addEventListener('DOMContentLoaded', function() {
							var messageElement = document.getElementById('requiredMessage');
							messageElement.textContent = 'Required: Please select an table from the list.';
						});
						function checkSelection(selectElement) {
							var messageElement = document.getElementById('requiredMessage');
							var selectedValue = selectElement.value;
							
							if (selectedValue === '#') {
								messageElement.textContent = 'Required: Please select an option from the list.';
							} else {
								messageElement.textContent = '';
							}
						}
					</script>
				</div>
				
				<div class="panel-body">
				<div class="alert alert-info">Select fields from the right menu to start creating the report! >></div>
				<div class="form row" id="sortable">
					<div class="layout-div col-md-12 patient_id">
						<div class="form-group">
							<label class="control-label"> Patient ID </label>
							<input type="text" name="patient_id"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
							<input type="hidden" name="" value="patient" class="form-control">	
							<input type="text" name="patient_id" value="" class="form-control" placeholder="width">	
						</div>
					</div>
                    <div class="layout-div col-md-12 patient_id_manual">
						<div class="form-group">
							<label class="control-label">   Patient ID Manual  </label>
							<input type="text" name="patient_id_manual" autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
							<input type="hidden" name="" value="patient" class="form-control">	
							<input type="text" name="patient_id_manual_width" value="" class="form-control" placeholder="width">	
						</div>
					</div>
					<div class="layout-div col-md-12 first_name">
						<div class="form-group">
							<label class="control-label">   First Name  </label>
							<input type="text" name="first_name" autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
							<input type="hidden" name="" value="patient" class="form-control">	
							<input type="text" name="first_name_width" value="" class="form-control" placeholder="width">	
						</div>
					</div>
					<div class="layout-div col-md-12 last_name">
						<div class="form-group">
						<label class="control-label">  Last Name    </label>
							<input type="text" name="last_name" autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
							<input type="hidden" name="" value="patient" class="form-control">	
							<input type="text" name="last_name_width" value="" class="form-control" placeholder="width">	
						</div>
					</div>
					<div class="layout-div col-md-12 dob">
						<div class="form-group">
						<label class="control-label">   Date of Birth          </label>
							<input type="text" name="dob" autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
							<input type="hidden" name="" value="patient" class="form-control">
							<input type="text" name="dob_width" value="" class="form-control" placeholder="width">		
						</div>
					</div>
					<div class="layout-div col-md-12 age_years">
						<div class="form-group">
						<label class="control-label">   Age </label>
							<input type="text" name="age_years" autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
							<input type="hidden" name="" value="patient" class="form-control">
							<input type="text" name="age_years_width" value="" class="form-control" placeholder="width">	
						</div>
					</div>
					<div class="layout-div col-md-12 gender">
						<div class="radio ">
						<label class="control-label">Gender</label>
						<input type="text" name="gender" autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">	
						<input type="text" name="gender_width" value="" class="form-control" placeholder="width">
						</div>					
					</div>
                    <div class="layout-div col-md-12 address">
						<div class="form-group">
						<label class="control-label">    Address    </label>
						<input type="text" name="address"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">	
						<input type="text" name="address_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 place">
						<div class="form-group">
						<label class="control-label">   Place      </label>
							<input type="text" name="place"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
							<input type="hidden" name="" value="patient" class="form-control">	
							<input type="text" name="place_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 country">
						<div class="form-group">
						<label class="control-label">   Country   </label>
						<input type="text" name="country_code"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">	
						<input type="text" name="country_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 state">
						<div class="form-group">
						<label class="control-label">   State   </label>
						<input type="text" name="state_code"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">	
						<input type="text" name="state_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 district_id">
						<div class="form-group">
						<label class="control-label">   District   </label>
						<input type="text" name="district_id"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">	
						<input type="text" name="district_id_width" value=""  class="form-control" placeholder="width">	
						</div>
					</div>
					<div class="layout-div col-md-12 phone">
						<div class="form-group">
						<label class="control-label">    Phone    </label>
						<input type="text" name="phone"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="phone_width" value=""  class="form-control" placeholder="width">	
						</div>
					</div>
					<div class="layout-div col-md-12 alt_phone">
						<div class="form-group">
						<label class="control-label">    Alternate Phone    </label>
						<input type="text" name="alt_phone"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">	
						<input type="text" name="alt_phone_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<!-- here we use input type for obtaining textbox for father_name,mother_name-->
					<div class="layout-div col-md-12 father_name">
						<div class="form-group">
						<label class="control-label"> Father Name </label>
						<input type="text" name="father_name"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="father_name_width" value=""  class="form-control" placeholder="width">	
						</div>
					</div>
					<div class="layout-div col-md-12 mother_name">
						<div class="form-group">
						<label class="control-label"> Mother Name  </label>
						<input type="text" name="mother_name"  autocomplete="off"  class="form-control" placeholder="Enter Column Name" />
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="mother_name_width" value=""  class="form-control" placeholder="width">		
					</div>
					</div>
					<!-- here spouse_name is display only if the patient is female -->
					<div class="layout-div col-md-12 spouse_name">
						<div class="form-group">
						<label class="control-label"> Spouse Name </label>
						<input type="text" name="spouse_name"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">	
						<input type="text" name="spouse_name_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 id_proof_type_id">
					<div class="form-group">
						<label class="control-label"> ID Proof Type</label>
						<input type="text" name="id_proof_type_id"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">	
						<input type="text" name="id_proof_type_id_width" value=""  class="form-control" placeholder="width">  
					</div>
					</div>
					<div class="layout-div col-md-12 id_proof_number">
					    <div class="form-group">
				         <label class="control-label">ID proof No.</label>
							<input type="text" name="id_proof_number" style="width:170px" autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
							<input type="hidden" name="" value="patient" class="form-control">
							<input type="text" name="id_proof_number_width" value=""  class="form-control" placeholder="width">	
						</div>
					</div>
						<div class="layout-div col-md-12 occupation_id">
						<label class="control-label"> Occupation: </label>
						<input type="text" name="occupation_id" style="width:170px" autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="occupation_id_width" value=""  class="form-control" placeholder="width">	
						</div>
					<div class="layout-div col-md-12 education_level">
						<div class="form-group">
						<label class="control-label"> Education Level </label>
					    <input type="text" name="education_level"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="education_level_width" value=""  class="form-control" placeholder="width">			
						</div>
					</div>
					<!-- here we use select class in order to obtain a drop-down box for Education Qualification -->
					<div class="layout-div col-md-12 education_qualification">
						<div class="form-group">
						<label class="control-label">Education Qualification</label>
						<input type="text" name="education_qualification" style="width: 150px" autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="education_qualification_width" value=""  class="form-control" placeholder="width">	
						</div>
					</div>
					<!-- here we use select class in order to obtain a drop-down box for Blood Group -->
					<div class="layout-div col-md-12 blood_group">
					    <div class="form-group">
						<label class="control-label">Blood Group</label>
						<input type="text" name="blood_group"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="blood_group_width" value=""  class="form-control" placeholder="width">	
						</div>
					</div>
					<div class="layout-div col-md-12 birth_information">
						<div class="form-group">
						<label class="control-label">Birth Information</label>
						<input type="text" name="birth_information"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						</div>
					</div>
					<div class="layout-div col-md-12 gestation">
						<div class="form-group">
						<label class="control-label">Gestation</label>
						<input type="text" name="gestation"   autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">	
						<input type="text" name="gestation_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<!-- here we use select class in order to obtain a drop-down box for Gestation Type -->
					<div class="layout-div col-md-12 gestation_type">
						<div class="form-group">
						<label class="control-label"> Gestation Type </label>
						<input type="text" name="gestation_type"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="gestation_type_width" value=""  class="form-control" placeholder="width">	
						</div>
					</div>
					<!-- here we use select class in order to obtain a drop-down box for Delivery Mode -->
					<div class="layout-div col-md-12 delivery_mode">
						<div class="form-group">
						<label class="control-label">Delivery Mode</label>
						<input type="text" name="delivery_mode"   autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="delivery_mode_width" value=""  class="form-control" placeholder="width">		
						</div>
					</div>
					<div class="layout-div col-md-12 delivery_place">
						<div class="form-group">
						<label class="control-label"> Delivery Place </label>
						<input type="text" name="delivery_place"   autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">	
						<input type="text" name="delivery_place_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 delivery_location">
						<div class="form-group">
						<label class="control-label"> Delivery Location </label>
						<input type="text" name="delivery_location"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="delivery_location_width" value=""  class="form-control" placeholder="width">	
						</div>
					</div>
					<div class="layout-div col-md-12 delivery_location_type">
						<div class="form-group">
						<label class="control-label">Delivery Location Type</label>
						<input type="text" name="delivery_location_type" style="width: 150px" autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">	
						<input type="text" name="delivery_location_type_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 delivery_plan">
						<div class="form-group">
						<label class="control-label">  Delivery Plan   </label>
						<input type="text" name="delivery_plan"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="delivery_plan_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 birth_weight">
						<div class="form-group">
						<label class="control-label">   Birth Weight  </label>
						<input type="text" name="birth_weight"  autocomplete="off" class="form-control" placeholder="Enter Column Name" />
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="birth_weight_width" value=""  class="form-control" placeholder="width">	
						</div>
					</div>
                    <div class="layout-div col-md-12 visit_type">
						<div class="form-group">
						<label class="control-label"> Visit Type </label>
						<input type="text" name="visit_type"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="visit_type_width" value=""  class="form-control" placeholder="width">		
						</div>
					</div>
					<div class="layout-div col-md-12 visit_name_id">
						<div class="form-group">
						<label class="control-label"> Visit Name </label>
						<input type="text" name="visit_name_id"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="visit_name_id_width" value=""  class="form-control" placeholder="width">		
						</div>
					</div>	
					<div class="layout-div col-md-12 referral_by_hospital_id">
						<div class="form-group">
						<label class="control-label">   Referred From   </label>
						<input type="text" name="referral_by_hospital_id"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="referral_by_hospital_id_width" value=""  class="form-control" placeholder="width">	
						</div>
					</div>				
					<div class="layout-div col-md-12 department_id">
						<div class="form-group">
						<label class="control-label">  Department   </label>
						<input type="text" name="department_id"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>	
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="department_id_width" value=""  class="form-control" placeholder="width">	
						</div>
					</div>
					<div class="layout-div col-md-12 area">
						<div class="form-group">
						<label class="control-label">   Area   </label>
						<input type="text" name="area"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>		
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="area_width" value=""  class="form-control" placeholder="width">	
						</div>
					</div>
					<div class="layout-div col-md-12 insurance_case">
						<div class="radio ">
						<label class="control-label">Insurance Case</label>
						<input type="text" name="insurance_case"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>		
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="insurance_case_width" value=""  class="form-control" placeholder="width">		
						</div>					
					</div>
					
					<div class="layout-div col-md-12 insurance_no">
						<div class="form-group">
						<label class="control-label">Insurance Number</label>
						<input type="text" name="insurance_no"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="insurance_no_width" value=""  class="form-control" placeholder="width">		
						</div>
					</div>
					<div class="layout-div col-md-12 hospital_type">
						<div class="form-group">
						<label class="control-label">Hospital Type</label>
						<input type="text" name="hospital_type"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="hospital_type_width" value=""  class="form-control" placeholder="width">		
						</div>
					</div>
					<div class="layout-div col-md-12 unit">
						<div class="form-group">
						<label class="control-label">Unit</label>
						<input type="text" name="unit"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="unit_width" value=""  class="form-control" placeholder="width">	
						</div>
					</div>
					<div class="layout-div col-md-12 mlc">
						<div class="radio ">
						<label class="control-label" title="Medico Legal Case">MLC</label>
						<input type="text" name="mlc"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="mlc" class="form-control">
						<input type="text" name="mlc_width" value=""  class="form-control" placeholder="width">	
						</div>					
					</div>
					<div class="layout-div col-md-12 mlc_number_manual">
						<div class="form-group">
						<label class="control-label">Manual MLC Number</label>
						<input type="text" name="mlc_number_manual" style="width: 150px" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="mlc" class="form-control">
						<input type="text" name="mlc_number_manual_width" value=""  class="form-control" placeholder="width">		
						</div>
					</div>
					<div class="layout-div col-md-12 ps_name">
						<div class="form-group">
						<label class="control-label">PS Name</label>
						<input type="text" name="ps_name"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="mlc" class="form-control">	
						<input type="text" name="ps_name_width" value=""  class="form-control" placeholder="width">	
						</div>
					</div>
					<div class="layout-div col-md-12 pc_number">
						<div class="form-group">
						<label class="control-label">Constable #</label>
						<input type="text" name="pc_number"   autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="mlc" class="form-control">
						<input type="text" name="pc_number_width" value=""  class="form-control" placeholder="width">		
						</div>
					</div>
					<div class="layout-div col-md-12 brought_by">
						<div class="form-group">
						<label class="control-label">Brought By</label>
						<input type="text" name="brought_by"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="mlc" class="form-control">
						<input type="text" name="brought_by_width" value=""  class="form-control" placeholder="width">	
						</div>
					</div>
					<div class="layout-div col-md-12 police_intimation">
						<div class="radio ">
						<label class="control-label" title="Medico Legal Case">Police Intimation</label>
						<input type="text" name="police_intimation"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="mlc" class="form-control">
						<input type="text" name="police_intimation_width" value=""  class="form-control" placeholder="width">
						</div>					
					</div>
					<div class="layout-div col-md-12 identification_marks">
						<div class="form-group">
						<label class="control-label">Identification Marks</label>
						<input type="text" name="identification_marks"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="identification_marks_width" value=""  class="form-control" placeholder="width">	
						</div>
					</div>
					<div class="layout-div col-md-12 presenting_complaints">
						<div class="form-group">
						<label class="control-label">Complaint</label>
						<input type="text" name="presenting_complaints"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="presenting_complaints_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 past_history">
						<div class="form-group">
						<label class="control-label">Past history</label>
						<input type="text" name="past_hsitory" class="form-control" autocomplete="off" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="past_history_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 admit_weight">
						<div class="form-group">
						<label class="control-label">Admit Weight</label>
						<input type="text" name="admit_weight"   autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="admit_weight_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 admit_date">
						<div class="form-group">
						<label class="control-label">Admit Date</label>
						<input type="text" name="admit_date"   autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="admit_date_width" value=""  class="form-control" placeholder="width">
						<select name="admit_date_funct" class="form-control">
							<option value="#">Select Function</option>
							<option value="min">Min</option>
							<option value="max">Max</option>
						</select>
						</div>
					</div>
					<div class="layout-div col-md-12 discharge_weight ">
						<div class="form-group">
						<label class="control-label">Discharge Weight</label>
						<input type="text" name="discharge_weight"   autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="discharge_weight_width" value=""  class="form-control" placeholder="width">
					</div>
					</div>
					<div class="layout-div col-md-12 pulse_rate">
						<div class="form-group">
						<label class="control-label">Pulse Rate</label>
						<input type="text" name="pulse_rate"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="pulse_rate_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 respiratory_rate">
						<div class="form-group">
						<label class="control-label">Respiratory Rate</label>
						<input type="text" name="respiratory_rate"  class="form-control" placeholder="Enter Column Name" />
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="respiratory_rate_width" value=""  class="form-control" placeholder="width">	
						</div>
					</div>
					<div class="layout-div col-md-12 temperature">
						<div class="form-group">
						<label class="control-label">Temperature</label>
					    <input type="text" name="temperature"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="temperature_width" value=""  class="form-control" placeholder="width">		
						</div>
					</div>
					<div class="layout-div col-md-12 spo2">
						<div class="form-group">
						<label class="control-label">SpO2</label>
						<input type="text" name="spo2"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="spo2__width" value=""  class="form-control" placeholder="width">	
						</div>
					</div>
					<div class="layout-div col-md-12 provisional_diagnosis">
						<div class="form-group">
						<label class="control-label">Provisional Diag.</label>
							<input type="text" name="provisional_diagnosis" autocomplete="off"  class="form-control" placeholder="Enter Column Name"/>
							<input type="hidden" name="" value="patient_visit" class="form-control">
							<input type="text" name="temperature_width" value=""  class="form-control" placeholder="width">
							</div>
					</div>
					<div class="layout-div col-md-12 outcome">
						<div class="radio ">
						<label class="control-label">Outcome</label>
							<input type="text" name="outcome"  autocomplete="off" placeholder="Enter Column Name" class="form-control">
							<input type="hidden" name="" value="patient_visit" class="form-control">
							<input type="text" name="outcome_width" value=""  class="form-control" placeholder="width">
						</div>					
					</div>
					<div class="layout-div col-md-12 outcome_date">
						<div class="form-group">
						<label class="control-label">Outcome Date</label>
							<input type="text" name="outcome_date"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
							<input type="hidden" name="" value="patient_visit" class="form-control">
							<input type="text" name="outcome_date_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 outcome_time">
						<div class="form-group">
						<label class="control-label">Outcome Time</label>
						<input type="text" name="outcome_time"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="outcome_time_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 final_diagnosis">
						<div class="form-group">
						<label class="control-label">Final Diagnosis</label>
						<input type="text" name="final_diagnosis"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="final_diagnosis_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 decision">
						<div class="form-group">
						<label class="control-label">Decision</label>
						<input type="text" name="decision"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="decision_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 advise">
						<div class="form-group">
						<label class="control-label">Advise</label>
						<input type="text" name="advise"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="advise_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 blood_sugar">
						<div class="form-group">
						<label class="control-label">Blood Sugar</label>
						<input type="text" name="blood_sugar"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="blood_sugar_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 family_history">
						<div class="form-group">
						<label class="control-label">Family History</label>
						<input type="text" name="family_history"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="family_history_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 clinical_finding">
						<div class="form-group">
						<label class="control-label">Clinical Finding</label>
						<input type="text" name="clinical_finding"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="clinical_finding_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 cvs">
						<div class="form-group">
						<label class="control-label">CVS</label>
						<input type="text" name="cvs"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="cvs_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 rs">
						<div class="form-group">
						<label class="control-label">RS</label>
						<input type="text" name="rs"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="RS_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 pa">
						<div class="form-group">
						<label class="control-label">PA</label>
						<input type="text" name="pa"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="pa_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 cns">
						<div class="form-group">
						<label class="control-label">CNS</label>
						<input type="text" name="cns"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="cns_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 congenital_anomalies">
						<div class="form-group">
						<label class="control-label">Congenital anomalies</label>
						<input type="text" name="congenital_anomalies"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="congenital_anomalies_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
						<div class="layout-div col-md-12 longitude">
							<div class="form-group">
								<label class="control-label">Longitude</label>
								<input type="text" name="longitude"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="longitude_width" value=""  class="form-control" placeholder="width">
							</div>
						</div>
						<div class="layout-div col-md-12 latitude">
							<div class="form-group">
								<label class="control-label">Latitude</label>
								<input type="text" name="latitude"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="latitude_width" value=""  class="form-control" placeholder="width">
							</div>
						</div>
						<div class="layout-div col-md-12 life_status">
							<div class="form-group">
								<label class="control-label">Life Status</label>
								<input type="text" name="life_status"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="life_status_width" value=""  class="form-control" placeholder="width">
							</div>
						</div>
						<div class="layout-div col-md-12 icd_code">
							<div class="form-group">
								<label class="control-label">ICD Code</label>
								<input type="text" name="icd_code"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="icd_code_width" value=""  class="form-control" placeholder="width">
							</div>
						</div>
						<div class="layout-div col-md-12 diagnosis">
							<div class="form-group">
								<label class="control-label">Diagnosis</label>
								<input type="text" name="diagnosis"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="diagnosis_width" value=""  class="form-control" placeholder="width">
							</div>
						</div>
						<div class="layout-div col-md-12 priority_type_id">
							<div class="form-group">
								<label class="control-label">Priority Type</label>
								<input type="text" name="priority_type_id"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="priority_type_id_width" value=""  class="form-control" placeholder="width">
							</div>
						</div>
						<div class="layout-div col-md-12 route_secondary_id">
							<div class="form-group">
								<label class="control-label">Route Secondary</label>
								<input type="text" name="route_secondary_id"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="route_secondary_id_width" value=""  class="form-control" placeholder="width">
							</div>
						</div>
						<div class="layout-div col-md-12 ndps">
							<div class="form-group">
								<label class="control-label">NDPS</label>
								<input type="text" name="ndps"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="ndps_width" value=""  class="form-control" placeholder="width">
							</div>
						</div>
						<div class="layout-div col-md-12 drug">
							<div class="form-group">
								<label class="control-label">Drug</label>
								<input type="text" name="drug"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="drug_width" value=""  class="form-control" placeholder="width">
							</div>
						</div>
						<div class="layout-div col-md-12 dose">
							<div class="form-group">
								<label class="control-label">Dose</label>
								<input type="text" name="dose"  class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="dose_width" value=""  class="form-control" placeholder="width">
							</div>
						</div>
						<div class="layout-div col-md-12 last_dispensed_date">
							<div class="form-group">
								<label class="control-label">Last Dispense Date</label>
								<input type="text" name="last_dispensed_date"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="last_dispensed_date_width" value=""  class="form-control" placeholder="width">
							</div>
						</div>
						<div class="layout-div col-md-12 last_dispensed_quantity">
							<div class="form-group">
								<label class="control-label">Last Dispense Quantity</label>
								<input type="text" name="last_dispensed_quantity" style="width: 150px" autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="last_dispensed_quantity_width" value=""  class="form-control" placeholder="width">
							</div>
						</div>
						<div class="layout-div col-md-12 map_link">
							<div class="form-group">
								<label class="control-label">Map Link</label>
								<input type="text" name="map_link"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="map_link_width" value=""  class="form-control" placeholder="width">
							</div>
						</div>
						<div class="layout-div col-md-12 death_date">
							<div class="form-group">
								<label class="control-label">Death Date</label>
								<input type="text" name="death_date"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="death_date_width" value=""  class="form-control" placeholder="width">
							</div>
						</div>
						<div class="layout-div col-md-12 death_status">
							<div class="form-group">
								<label class="control-label">Death Status</label>
								<input type="text" name="death_status"  autocomplete="off" class="form-control" placeholder="Enter Column Name" />
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="death_status_width" value=""  class="form-control" placeholder="width">
							</div>
						</div>
			        </div>
					
				</div>
				<div class="panel-footer">
					<button type="submit" class="btn btn-primary" id="save-form">Save</button>
				</div>
				<br/>
				<!-- <p id="show_print" style="padding-left:100px;">  </p>
				<br/>
				<br/> -->
				<div id="print_preview"  style="width:80%;height:40%;margin-left:50px;" ></div>
				</div>
			</div>
			
			
			<div class="col-sm-3 col-md-2 sidebar">
			<strong>Patient Information</strong>
			  <ul class="nav nav-sidebar">
			  <!--here we are labelling the field_name on the left side of the form-->
			  	<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="patient_id" class="checklist" />Patient ID
						</label>
					</div>
				</li>
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
						<label><input type="checkbox" value="1" id="dob" class="checklist" />Date of Birth</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="age_years" class="checklist" />Age</label>
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
						<label><input type="checkbox" value="1" id="district_id" class="checklist" />District</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="phone" class="checklist" />Phone</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="alt_phone" class="checklist" />Alternate Phone</label>
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
						<label><input type="checkbox" value="1" id="id_proof_type_id" class="checklist" />ID Proof Type</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="id_proof_number" class="checklist" />ID Proof NO.</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="occupation_id" class="checklist" />Occupation</label>
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
						<label><input type="checkbox" value="1" id="visit_type" class="checklist" />Visit Type</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="visit_name_id" class="checklist" />Visit Name</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="referral_by_hospital_id" class="checklist" />Referred From</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="department_id" class="checklist" />Department</label>
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
						<label><input type="checkbox" value="1" id="admit_date" class="checklist" />Admit Date</label>
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
						<label><input type="checkbox" value="1" id="spo2" class="checklist" />SpO2</label>
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
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="decision" class="checklist" />Decision</label>
					</div>
				</li> 
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="advise" class="checklist" />Advise</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="blood_sugar" class="checklist" />Blood Sugar</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="family_history" class="checklist" />Family History</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="clinical_finding" class="checklist" />Clinical Findings</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="cvs" class="checklist" />CVS</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="rs" class="checklist" />RS</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="pa" class="checklist" />PA</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="cns" class="checklist" />CNS</label>
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
			  </ul>
			  		<strong>Patient Followup Information</strong>
			  <ul class="nav nav-sidebar">
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="longitude" class="checklist" /> Longitude</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="latitude" class="checklist" /> Latitude</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="life_status" class="checklist" /> Life Status</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="icd_code" class="checklist" /> ICD Code</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="diagnosis" class="checklist" /> Diagnosis</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="priority_type_id" class="checklist" /> Priority type id</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="route_secondary_id" class="checklist" /> Route secondary id</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="ndps" class="checklist" /> NDPS</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="drug" class="checklist" /> Drug</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="dose" class="checklist" /> Dose</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="last_dispensed_date" class="checklist" /> Last dispensed date</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="last_dispensed_quantity" class="checklist" /> Last dispensed quantity</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="map_link" class="checklist" /> Map Link</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="death_date" class="checklist" /> Death Date</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="death_status" class="checklist" /> Death Status</label>
					</div>
				</li>
			</div>
			
      </form>

