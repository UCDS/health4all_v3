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
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>

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
		$(document).ready(function() 
		{
			$("#save-form").attr('disabled', true);
			$('select[name=from_table]').on('change', function() {
				var selectedValue = $(this).val();
				if (selectedValue && selectedValue !== '#') { // Check if a value is selected and not '#'
					$("#save-form").attr('disabled', false); // Enable the button
				} else {
					$("#save-form").attr('disabled', true); // Disable the button if no selection or '#'
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
			txtarea = {};
			txtarea['concatination_fields']=[];
			separator = {};
			separator['fields_separator']=[];
			align = {};
			align['alignment'] = [];

			$(".layout-div:visible").each(function(){
				var cname = $(this).attr('class').replace(/col-md-[0-9]+/, "").replace(/layout-div/, "").trim();
				fields['field_name'].push(cname);
				//console.log(cname);
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
				var textareaInput = $(this).find('textarea[name="' + cname + '_concatination_fields"]');
				//alert(textareaInput);
				txtarea['concatination_fields'].push(textareaInput.val());
				
				var separatorInput = $(this).find('input[name="' + cname + '_separator"]').val();
				separator['fields_separator'].push(separatorInput);

				var alignInput = $(this).find('input[name="' + cname + '_alignment"]').val();
				align['alignment'].push(alignInput);
			});
			$.ajax({
				type: "POST",
				async: true,
				data: {form_id: form_id,from_table:from_table,columns: columns, fields: JSON.stringify(fields),wid: JSON.stringify(wid),
					funct: JSON.stringify(funct), field_value: JSON.stringify(field_value), table: JSON.stringify(table), 
					txtarea: JSON.stringify(txtarea),separator: JSON.stringify(separator),align: JSON.stringify(align)},
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
							<input type="text" name="patient_id" value="" class="form-control" placeholder="width" style="width:8%;">	
							<input type="text" class="concatenatebtn btn btn-primary" name="patient_id_concate"  data-field-name="patient_id"
							value="Concatenate Fields" style="font-size:12px;width:16%;">
							<textarea name="patient_id_concatination_fields" rows="2" cols="20" readonly style="height:32px;"></textarea>
							<input type="text" name="patient_id_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">	
							<input type="text" name="patient_id_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">	
						</div>
					</div>
                    <div class="layout-div col-md-12 patient_id_manual">
						<div class="form-group">
							<label class="control-label">   Patient ID Manual  </label>
							<input type="text" name="patient_id_manual" autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
							<input type="hidden" name="" value="patient" class="form-control">	
							<input type="text" name="patient_id_manual_width" value="" class="form-control" placeholder="width" style="width:8%;">
							<input type="text" class="concatenatebtn btn btn-primary" name="patient_id_manual_concate"  data-field-name="patient_id_manual"
							value="Concatenate Fields" style="font-size:12px;width:16%;">
							<textarea name="patient_id_manual_concatination_fields" rows="2" cols="30" readonly></textarea>	
							<input type="text" name="patient_id_manual_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
							<input type="text" name="patient_id_manual_alignment" class="form-control" placeholder="alignment" style="width:10%;" 	autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 first_name">
						<div class="form-group">
							<label class="control-label">   First Name  </label>
							<input type="text" name="first_name" autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
							<input type="hidden" name="" value="patient" class="form-control">	
							<input type="text" name="first_name_width" value="" class="form-control" placeholder="width" style="width:8%;">
							<input type="text" class="concatenatebtn btn btn-primary" name="first_name_concate"  data-field-name="first_name"
							value="Concatenate Fields" style="font-size:12px;width:16%;">
							<textarea name="first_name_concatination_fields" rows="2" cols="30" readonly></textarea>
							<input type="text" name="first_name_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
							<input type="text" name="first_name_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">	
						</div>
					</div>
					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
						<div class="modal-dialog" role="document">
							<div class="modal-content" style="width:max-content!important;">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Select Fields</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-20px;">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body" >
									<div class="row col-md-12">
										<div class="col-md-3" id="checkboxesContainer"></div>
										<div class="col-md-3" id="checkboxesContainer_one"></div>
										<div class="col-md-3" id="checkboxesContainer_two"></div>
										<div class="col-md-3" id="checkboxesContainer_three"></div>
										<div  class="col-md-3" id="checkboxesContainer_four"></div>
									</div>
								</div>
								<div class="modal-footer" style="border-top:none!important;">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
									<button type="button" class="btn btn-primary" id="saveChanges">Save changes</button>
								</div>
							</div>
						</div>
					</div>
					<script>
						$(document).ready(function() {

							$('.concatenatebtn').on('click', function() {
								var fieldName = $(this).data('field-name');
								//alert(fieldName);
								$('#exampleModal').data('currentField', fieldName);
								$('#exampleModal').modal('show');
							});

							$('#exampleModal').on('show.bs.modal', function () {
								$('#checkboxesContainer').empty();
								$('#checkboxesContainer_one').empty();
								$('#checkboxesContainer_two').empty();
								$('#checkboxesContainer_three').empty();
								$('#checkboxesContainer_four').empty();

								$('.checkboxesList li').each(function() {
									var checkbox = $(this).find('input').clone(); 
									var newId = $(this).find('input').attr('id') + '_concate'; 
									checkbox.attr('id', newId); 
									checkbox.prop('checked', false); 
									var label = $('<label></label>').append(checkbox).append($(this).text().trim());
									$('#checkboxesContainer').append(label).append('<br>'); 
								});
								$('.checkboxesList_one li').each(function() {
									var checkbox = $(this).find('input').clone(); 
									var newId = $(this).find('input').attr('id') + '_concate'; 
									checkbox.attr('id', newId); 
									checkbox.prop('checked', false); 
									var label = $('<label></label>').append(checkbox).append($(this).text().trim());
									$('#checkboxesContainer_one').append(label).append('<br>'); 
								});
								$('.checkboxesList_two li').each(function() {
									var checkbox = $(this).find('input').clone(); 
									var newId = $(this).find('input').attr('id') + '_concate'; 
									checkbox.attr('id', newId); 
									checkbox.prop('checked', false); 
									var label = $('<label></label>').append(checkbox).append($(this).text().trim());
									$('#checkboxesContainer_two').append(label).append('<br>'); 
								});
								$('.checkboxesList_three li').each(function() {
									var checkbox = $(this).find('input').clone(); 
									var newId = $(this).find('input').attr('id') + '_concate'; 
									checkbox.attr('id', newId); 
									checkbox.prop('checked', false); 
									var label = $('<label></label>').append(checkbox).append($(this).text().trim());
									$('#checkboxesContainer_three').append(label).append('<br>'); 
								});
								$('.checkboxesList_four li').each(function() {
									var checkbox = $(this).find('input').clone(); 
									var newId = $(this).find('input').attr('id') + '_concate'; 
									checkbox.attr('id', newId); 
									checkbox.prop('checked', false); 
									var label = $('<label></label>').append(checkbox).append($(this).text().trim());
									$('#checkboxesContainer_four').append(label).append('<br>'); 
								});
								
							});

							$('#saveChanges').on('click', function() {
								var selectedFields = [];
								
								$('#checkboxesContainer input:checked').each(function() {
									var originalId = $(this).attr('id').replace('_concate', '');
									//selectedFields.push(originalId);
									var $matchingDiv = $('.' + originalId);
									if ($matchingDiv.length) {
										var hiddenInput = $matchingDiv.find('input[type="hidden"]');
										if (hiddenInput.length) {
											var hiddenValue = hiddenInput.val();
											//alert("Hidden Input Value for " + originalId + ": " + hiddenValue);
											//selectedFields.push(originalId + "." + hiddenValue);
											selectedFields.push(hiddenValue + "." + originalId);
										} else {
											selectedFields.push(originalId);
										}
									} else {
										selectedFields.push(originalId);
									}
								});

								$('#checkboxesContainer_one input:checked').each(function() {
									var originalId = $(this).attr('id').replace('_concate', '');
									//selectedFields.push(originalId);
									var $matchingDiv = $('.' + originalId);
									if ($matchingDiv.length) {
										var hiddenInput = $matchingDiv.find('input[type="hidden"]');
										if (hiddenInput.length) {
											var hiddenValue = hiddenInput.val();
											//alert("Hidden Input Value for " + originalId + ": " + hiddenValue);
											//selectedFields.push(originalId + "." + hiddenValue);
											selectedFields.push(hiddenValue + "." + originalId);
										} else {
											selectedFields.push(originalId);
										}
									} else {
										selectedFields.push(originalId);
									}
								});

								$('#checkboxesContainer_two input:checked').each(function() {
									var originalId = $(this).attr('id').replace('_concate', '');
									//selectedFields.push(originalId);
									var $matchingDiv = $('.' + originalId);
									if ($matchingDiv.length) {
										var hiddenInput = $matchingDiv.find('input[type="hidden"]');
										if (hiddenInput.length) {
											var hiddenValue = hiddenInput.val();
											//alert("Hidden Input Value for " + originalId + ": " + hiddenValue);
											//selectedFields.push(originalId + "." + hiddenValue);
											selectedFields.push(hiddenValue + "." + originalId);
										} else {
											selectedFields.push(originalId);
										}
									} else {
										selectedFields.push(originalId);
									}
								});

								$('#checkboxesContainer_three input:checked').each(function() {
									var originalId = $(this).attr('id').replace('_concate', '');
									//selectedFields.push(originalId);
									var $matchingDiv = $('.' + originalId);
									if ($matchingDiv.length) {
										var hiddenInput = $matchingDiv.find('input[type="hidden"]');
										if (hiddenInput.length) {
											var hiddenValue = hiddenInput.val();
											//alert("Hidden Input Value for " + originalId + ": " + hiddenValue);
											//selectedFields.push(originalId + "." + hiddenValue);
											selectedFields.push(hiddenValue + "." + originalId);
										} else {
											selectedFields.push(originalId);
										}
									} else {
										selectedFields.push(originalId);
									}
								});

								$('#checkboxesContainer_four input:checked').each(function() {
									var originalId = $(this).attr('id').replace('_concate', '');
									//selectedFields.push(originalId);
									var $matchingDiv = $('.' + originalId);
									if ($matchingDiv.length) {
										var hiddenInput = $matchingDiv.find('input[type="hidden"]');
										if (hiddenInput.length) {
											var hiddenValue = hiddenInput.val();
											//alert("Hidden Input Value for " + originalId + ": " + hiddenValue);
											//selectedFields.push(originalId + "." + hiddenValue);
											selectedFields.push(hiddenValue + "." + originalId);
										} else {
											selectedFields.push(originalId);
										}
									} else {
										selectedFields.push(originalId);
									}
								});
								
								var fieldNameorg = $('#exampleModal').data('currentField');
								//alert(fieldNameorg);
								//alert("Selected Fields: " + selectedFields.join(', '));

								// Update the textarea with the selected fields
    							$('textarea[name="' + fieldNameorg + '_concatination_fields"]').val(selectedFields.join(', '));

								//disable the concatenate button
								//$('input[name="' + fieldNameorg + '_concate"]').prop('disabled', true);

								// Hide the concatenate button
								$('input[name="' + fieldNameorg + '_concate"]').hide();

								$.ajax({
									url: 'your_controller/updateSelectedFields',
									type: 'POST',
									data: {
										fields: selectedFields,
										fieldName: fieldNameorg
									},
									success: function(response) {
										//console.log("Selected fields updated successfully:");
										//const inputString = fields;
										//const charactersToRemove = /[!@#$%]/g; 
										//const resultString = inputString.replace(charactersToRemove, "");
										//console.log(resultString); 
										$('#exampleModal').modal('hide');
									},
									error: function(jqXHR, textStatus, errorThrown) {
										console.error("Error updating fields:", textStatus, errorThrown);
									}
								});
							});
						});
					</script>
					<div class="layout-div col-md-12 last_name">
						<div class="form-group">
						<label class="control-label">  Last Name    </label>
							<input type="text" name="last_name" autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
							<input type="hidden" name="" value="patient" class="form-control">	
							<input type="text" name="last_name_width" value="" class="form-control" placeholder="width" style="width:8%;">
							<input type="text" class="concatenatebtn btn btn-primary" name="last_name_concate" data-field-name="last_name"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="last_name_concatination_fields" rows="2" cols="30" readonly></textarea>
							<input type="text" name="last_name_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">	
							<input type="text" name="last_name_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 dob">
						<div class="form-group">
						<label class="control-label">   Date of Birth          </label>
							<input type="text" name="dob" autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
							<input type="hidden" name="" value="patient" class="form-control">
							<input type="text" name="dob_width" value="" class="form-control" placeholder="width" style="width:8%;">
							<input type="text" class="concatenatebtn btn btn-primary" name="dob_concate" data-field-name="dob"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="dob_concatination_fields" rows="2" cols="30" readonly></textarea>
							<input type="text" name="dob_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">	
							<input type="text" name="dob_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">		
						</div>
					</div>
					<div class="layout-div col-md-12 age_years">
						<div class="form-group">
						<label class="control-label">   Age </label>
							<input type="text" name="age_years" autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
							<input type="hidden" name="" value="patient" class="form-control">
							<input type="text" name="age_years_width" value="" class="form-control" placeholder="width" style="width:8%;">
							<input type="text" class="concatenatebtn btn btn-primary" name="age_years_concate" data-field-name="age_years"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="age_years_concatination_fields" rows="2" cols="30" readonly></textarea>
							<input type="text" name="age_years_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
							<input type="text" name="age_years_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">				
						</div>
					</div>
					<div class="layout-div col-md-12 gender">
						<div class="radio ">
						<label class="control-label">Gender</label>
						<input type="text" name="gender" autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">	
						<input type="text" name="gender_width" value="" class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="gender_concate" data-field-name="gender"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="gender_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="gender_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">	
						<input type="text" name="gender_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>					
					</div>
                    <div class="layout-div col-md-12 address">
						<div class="form-group">
						<label class="control-label">    Address    </label>
						<input type="text" name="address"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">	
						<input type="text" name="address_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="address_concate" data-field-name="address"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="address_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="address_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="address_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 place">
						<div class="form-group">
						<label class="control-label">   Place      </label>
							<input type="text" name="place"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
							<input type="hidden" name="" value="patient" class="form-control">	
							<input type="text" name="place_width" value=""  class="form-control" placeholder="width" style="width:8%;">
							<input type="text" class="concatenatebtn btn btn-primary" name="place_concate" data-field-name="place"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="place_concatination_fields" rows="2" cols="30" readonly></textarea>
							<input type="text" name="place_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
							<input type="text" name="place_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 country">
						<div class="form-group">
						<label class="control-label">   Country   </label>
						<input type="text" name="country_code"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">	
						<input type="text" name="country_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="country_code_concate" data-field-name="country_code"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="country_code_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="country_code_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="country_code_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 state">
						<div class="form-group">
						<label class="control-label">   State   </label>
						<input type="text" name="state_code"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">	
						<input type="text" name="state_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="state_code_concate" data-field-name="state_code"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="state_code_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="state_code_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="state_code_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 district_id">
						<div class="form-group">
						<label class="control-label">   District   </label>
						<input type="text" name="district_id"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">	
						<input type="text" name="district_id_width" value=""  class="form-control" placeholder="width" style="width:8%;">	
						<input type="text" class="concatenatebtn btn btn-primary" name="district_id_concate" data-field-name="district_id"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="district_id_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="district_id_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="district_id_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 phone">
						<div class="form-group">
						<label class="control-label">    Phone    </label>
						<input type="text" name="phone"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="phone_width" value=""  class="form-control" placeholder="width" style="width:8%;">	
						<input type="text" class="concatenatebtn btn btn-primary" name="phone_concate" data-field-name="phone"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="phone_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="phone_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="phone_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 alt_phone">
						<div class="form-group">
						<label class="control-label">    Alternate Phone    </label>
						<input type="text" name="alt_phone"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">	
						<input type="text" name="alt_phone_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="alt_phone" data-field-name="alt_phone"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="alt_phone_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="alt_phone_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="alt_phone_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<!-- here we use input type for obtaining textbox for father_name,mother_name-->
					<div class="layout-div col-md-12 father_name">
						<div class="form-group">
						<label class="control-label"> Father Name </label>
						<input type="text" name="father_name"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="father_name_width" value=""  class="form-control" placeholder="width" style="width:8%;">	
						<input type="text" class="concatenatebtn btn btn-primary" name="father_name" data-field-name="father_name"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="father_name_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="father_name_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="father_name_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 mother_name">
						<div class="form-group">
						<label class="control-label"> Mother Name  </label>
						<input type="text" name="mother_name"  autocomplete="off"  class="form-control" placeholder="Enter Column Name" />
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="mother_name_width" value=""  class="form-control" placeholder="width" style="width:8%;">		
						<input type="text" class="concatenatebtn btn btn-primary" name="mother_name" data-field-name="mother_name"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="mother_name_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="mother_name_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="mother_name_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
					</div>
					</div>
					<!-- here spouse_name is display only if the patient is female -->
					<div class="layout-div col-md-12 spouse_name">
						<div class="form-group">
						<label class="control-label"> Spouse Name </label>
						<input type="text" name="spouse_name"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">	
						<input type="text" name="spouse_name_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="spouse_name" data-field-name="spouse_name"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="spouse_name_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="spouse_name_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="spouse_name_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 id_proof_type_id">
					<div class="form-group">
						<label class="control-label"> ID Proof Type</label>
						<input type="text" name="id_proof_type_id"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">	
						<input type="text" name="id_proof_type_id_width" value=""  class="form-control" placeholder="width" style="width:8%;">  
						<input type="text" class="concatenatebtn btn btn-primary" name="id_proof_type_id" data-field-name="id_proof_type_id"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="id_proof_type_id_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="id_proof_type_id_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="id_proof_type_id_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
					</div>
					</div>
					<div class="layout-div col-md-12 id_proof_number">
					    <div class="form-group">
				         <label class="control-label">ID proof No.</label>
							<input type="text" name="id_proof_number" style="width:170px" autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
							<input type="hidden" name="" value="patient" class="form-control">
							<input type="text" name="id_proof_number_width" value=""  class="form-control" placeholder="width" style="width:8%;">
							<input type="text" class="concatenatebtn btn btn-primary" name="id_proof_number" data-field-name="id_proof_number"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="id_proof_number_concatination_fields" rows="2" cols="30" readonly></textarea>
							<input type="text" name="id_proof_number_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">	
							<input type="text" name="id_proof_number_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
						<div class="layout-div col-md-12 occupation_id">
						<label class="control-label"> Occupation: </label>
						<input type="text" name="occupation_id" style="width:170px" autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="occupation_id_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="occupation_id" data-field-name="occupation_id"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="occupation_id_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="occupation_id_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">	
						<input type="text" name="occupation_id_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					<div class="layout-div col-md-12 education_level">
						<div class="form-group">
						<label class="control-label"> Education Level </label>
					    <input type="text" name="education_level"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="education_level_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="education_level" data-field-name="education_level"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="education_level_concatination_fields" rows="2" cols="30" readonly></textarea>	
						<input type="text" name="education_level_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="education_level_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">		
						</div>
					</div>
					<!-- here we use select class in order to obtain a drop-down box for Education Qualification -->
					<div class="layout-div col-md-12 education_qualification">
						<div class="form-group">
						<label class="control-label">Education Qualification</label>
						<input type="text" name="education_qualification" style="width: 150px" autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="education_qualification_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="education_qualification" data-field-name="education_qualification"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="education_qualification_concatination_fields" rows="2" cols="30" readonly></textarea>	
						<input type="text" name="education_qualification_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="education_qualification_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<!-- here we use select class in order to obtain a drop-down box for Blood Group -->
					<div class="layout-div col-md-12 blood_group">
					    <div class="form-group">
						<label class="control-label">Blood Group</label>
						<input type="text" name="blood_group"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="blood_group_width" value=""  class="form-control" placeholder="width" style="width:8%;">	
						<input type="text" class="concatenatebtn btn btn-primary" name="blood_group" data-field-name="blood_group"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="blood_group_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="blood_group_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="blood_group_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
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
						<input type="text" name="gestation_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="gestation" data-field-name="gestation"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="gestation_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="gestation_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="gestation_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<!-- here we use select class in order to obtain a drop-down box for Gestation Type -->
					<div class="layout-div col-md-12 gestation_type">
						<div class="form-group">
						<label class="control-label"> Gestation Type </label>
						<input type="text" name="gestation_type"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="gestation_type_width" value=""  class="form-control" placeholder="width" style="width:8%;">	
						<input type="text" class="concatenatebtn btn btn-primary" name="gestation_type" data-field-name="gestation_type"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="gestation_type_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="gestation_type_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="gestation_type_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<!-- here we use select class in order to obtain a drop-down box for Delivery Mode -->
					<div class="layout-div col-md-12 delivery_mode">
						<div class="form-group">
						<label class="control-label">Delivery Mode</label>
						<input type="text" name="delivery_mode"   autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="delivery_mode_width" value=""  class="form-control" placeholder="width" style="width:8%;">	
						<input type="text" class="concatenatebtn btn btn-primary" name="delivery_mode" data-field-name="delivery_mode"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="delivery_mode_concatination_fields" rows="2" cols="30" readonly></textarea>	
						<input type="text" name="delivery_mode_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="delivery_mode_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 delivery_place">
						<div class="form-group">
						<label class="control-label"> Delivery Place </label>
						<input type="text" name="delivery_place"   autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">	
						<input type="text" name="delivery_place_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="delivery_place" data-field-name="delivery_place"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="delivery_place_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="delivery_place_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="delivery_place_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 delivery_location">
						<div class="form-group">
						<label class="control-label"> Delivery Location </label>
						<input type="text" name="delivery_location"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="delivery_location_width" value=""  class="form-control" placeholder="width" style="width:8%;">	
						<input type="text" class="concatenatebtn btn btn-primary" name="delivery_location" data-field-name="delivery_location"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="delivery_location_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="delivery_location_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="delivery_location_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 delivery_location_type">
						<div class="form-group">
						<label class="control-label">Delivery Location Type</label>
						<input type="text" name="delivery_location_type" style="width: 150px" autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">	
						<input type="text" name="delivery_location_type_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="delivery_location_type" data-field-name="delivery_location_type"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="delivery_location_type_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="delivery_location_type_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="delivery_location_type_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 delivery_plan">
						<div class="form-group">
						<label class="control-label">  Delivery Plan   </label>
						<input type="text" name="delivery_plan"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="delivery_plan_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="delivery_plan" data-field-name="delivery_plan"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="delivery_plan_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="delivery_plan_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="delivery_plan_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 birth_weight">
						<div class="form-group">
						<label class="control-label">   Birth Weight  </label>
						<input type="text" name="birth_weight"  autocomplete="off" class="form-control" placeholder="Enter Column Name" />
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="birth_weight_width" value=""  class="form-control" placeholder="width"  >	
						<input type="text" class="concatenatebtn btn btn-primary" name="birth_weight" data-field-name="birth_weight"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="birth_weight_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="birth_weight_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="birth_weight_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
                    <div class="layout-div col-md-12 visit_type">
						<div class="form-group">
						<label class="control-label"> Visit Type </label>
						<input type="text" name="visit_type"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="visit_type_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="visit_type" data-field-name="visit_type"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="visit_type_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="visit_type_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">		
						<input type="text" name="visit_type_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 visit_name_id">
						<div class="form-group">
						<label class="control-label"> Visit Name </label>
						<input type="text" name="visit_name_id"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="visit_name_id_width" value=""  class="form-control" placeholder="width" style="width:8%;">	
						<input type="text" class="concatenatebtn btn btn-primary" name="visit_name_id" data-field-name="visit_name_id"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="visit_name_id_concatination_fields" rows="2" cols="30" readonly></textarea>	
						<input type="text" name="visit_name_id_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="visit_name_id_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">	
						</div>
					</div>	
					<div class="layout-div col-md-12 hosp_file_no">
						<div class="form-group">
						<label class="control-label"> Hospital File No </label>
						<input type="text" name="hosp_file_no"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="hosp_file_no_width" value=""  class="form-control" placeholder="width" style="width:8%;"> 
						<input type="text" class="concatenatebtn btn btn-primary" name="hosp_file_no" data-field-name="hosp_file_no"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="hosp_file_no_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="hosp_file_no_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="hosp_file_no_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">		
						</div>
					</div>
					<div class="layout-div col-md-12 referral_by_hospital_id">
						<div class="form-group">
						<label class="control-label">   Referred From   </label>
						<input type="text" name="referral_by_hospital_id"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="referral_by_hospital_id_width" value=""  class="form-control" placeholder="width" style="width:8%;">	
						<input type="text" class="concatenatebtn btn btn-primary" name="referral_by_hospital_id" data-field-name="referral_by_hospital_id"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="referral_by_hospital_id_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="referral_by_hospital_id_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="referral_by_hospital_id_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>				
					<div class="layout-div col-md-12 department_id">
						<div class="form-group">
						<label class="control-label">  Department   </label>
						<input type="text" name="department_id"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>	
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="department_id_width" value=""  class="form-control" placeholder="width" style="width:8%;">	
						<input type="text" class="concatenatebtn btn btn-primary" name="referral_by_hospital_id" data-field-name="referral_by_hospital_id"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="referral_by_hospital_id_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="department_id_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="department_id_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 area">
						<div class="form-group">
						<label class="control-label">   Area   </label>
						<input type="text" name="area"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>		
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="area_width" value=""  class="form-control" placeholder="width" style="width:8%;">	
						<input type="text" class="concatenatebtn btn btn-primary" name="area" data-field-name="area"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="area_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="area_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="area_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 insurance_case">
						<div class="radio ">
						<label class="control-label">Insurance Case</label>
						<input type="text" name="insurance_case"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>		
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="insurance_case_width" value=""  class="form-control" placeholder="width" style="width:8%;">	
						<input type="text" class="concatenatebtn btn btn-primary" name="insurance_case" data-field-name="insurance_case"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="insurance_case_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="insurance_case_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">	
						<input type="text" name="insurance_case_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>					
					</div>
					
					<div class="layout-div col-md-12 insurance_no">
						<div class="form-group">
						<label class="control-label">Insurance Number</label>
						<input type="text" name="insurance_no"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="insurance_no_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="insurance_no" data-field-name="insurance_no"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="insurance_no_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="insurance_no_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="insurance_no_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">			
						</div>
					</div>
					<div class="layout-div col-md-12 hospital_type">
						<div class="form-group">
						<label class="control-label">Hospital Type</label>
						<input type="text" name="hospital_type"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="hospital_type_width" value=""  class="form-control" placeholder="width" style="width:8%;">	
						<input type="text" class="concatenatebtn btn btn-primary" name="hospital_type" data-field-name="hospital_type"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="hospital_type_concatination_fields" rows="2" cols="30" readonly></textarea>	
						<input type="text" name="hospital_type_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="hospital_type_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 unit">
						<div class="form-group">
						<label class="control-label">Unit</label>
						<input type="text" name="unit"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="unit_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="unit" data-field-name="unit"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="unit_concatination_fields" rows="2" cols="30" readonly></textarea>	
						<input type="text" name="unit_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="unit_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 mlc_id">
						<div class="radio ">
						<label class="control-label" title="Medico Legal Case">MLC</label>
						<input type="text" name="mlc_id"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="mlc" class="form-control">
						<input type="text" name="mlc_id_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="mlc_id" data-field-name="mlc_id"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="mlc_id_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="mlc_id_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">	
						<input type="text" name="mlc_id_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>					
					</div>
					<div class="layout-div col-md-12 mlc_number_manual">
						<div class="form-group">
						<label class="control-label">Manual MLC Number</label>
						<input type="text" name="mlc_number_manual" style="width: 150px" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="mlc" class="form-control">
						<input type="text" name="mlc_number_manual_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="mlc_number_manual" data-field-name="mlc_number_manual"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="mlc_number_manual_concatination_fields" rows="2" cols="30" readonly></textarea>	
						<input type="text" name="mlc_number_manual_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="mlc_number_manual_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">		
						</div>
					</div>
					<div class="layout-div col-md-12 ps_name">
						<div class="form-group">
						<label class="control-label">PS Name</label>
						<input type="text" name="ps_name"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="mlc" class="form-control">	
						<input type="text" name="ps_name_width" value=""  class="form-control" placeholder="width" style="width:8%;">	
						<input type="text" class="concatenatebtn btn btn-primary" name="ps_name" data-field-name="ps_name"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="ps_name_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="ps_name_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="ps_name_manual_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">	
						</div>
					</div>
					<div class="layout-div col-md-12 pc_number">
						<div class="form-group">
						<label class="control-label">Constable #</label>
						<input type="text" name="pc_number"   autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="mlc" class="form-control">
						<input type="text" name="pc_number_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="pc_number" data-field-name="pc_number"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="pc_number_concatination_fields" rows="2" cols="30" readonly></textarea>	
						<input type="text" name="pc_number_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">	
						<input type="text" name="pc_number_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">	
						</div>
					</div>
					<div class="layout-div col-md-12 brought_by">
						<div class="form-group">
						<label class="control-label">Brought By</label>
						<input type="text" name="brought_by"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="mlc" class="form-control">
						<input type="text" name="brought_by_width" value=""  class="form-control" placeholder="width" style="width:8%;">	
						<input type="text" class="concatenatebtn btn btn-primary" name="brought_by" data-field-name="brought_by"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="brought_by_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="brought_by_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="brought_by_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 police_intimation">
						<div class="radio ">
						<label class="control-label" title="Medico Legal Case">Police Intimation</label>
						<input type="text" name="police_intimation"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="mlc" class="form-control">
						<input type="text" name="police_intimation_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="police_intimation" data-field-name="police_intimation"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="police_intimation_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="police_intimation_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="police_intimation_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>					
					</div>
					<div class="layout-div col-md-12 identification_marks">
						<div class="form-group">
						<label class="control-label">Identification Marks</label>
						<input type="text" name="identification_marks"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="identification_marks_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="identification_marks" data-field-name="identification_marks"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="identification_marks_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="identification_marks_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="identification_marks_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">	
						</div>
					</div>
					<div class="layout-div col-md-12 presenting_complaints">
						<div class="form-group">
						<label class="control-label">Complaint</label>
						<input type="text" name="presenting_complaints"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="presenting_complaints_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="identification_marks" data-field-name="identification_marks"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="identification_marks_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="presenting_complaints_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="presenting_complaints_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 past_history">
						<div class="form-group">
						<label class="control-label">Past history</label>
						<input type="text" name="past_hsitory" class="form-control" autocomplete="off" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="past_history_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="past_hsitory" data-field-name="past_hsitory"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="past_hsitory_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="past_hsitory_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="past_hsitory_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 admit_weight">
						<div class="form-group">
						<label class="control-label">Admit Weight</label>
						<input type="text" name="admit_weight"   autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="admit_weight_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="admit_weight" data-field-name="admit_weight"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="admit_weight_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="admit_weight_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="admit_weight_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 admit_date">
						<div class="form-group">
						<label class="control-label">Admit Date</label>
						<input type="text" name="admit_date"   autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="admit_date_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<select name="admit_date_funct" class="form-control">
							<option value="#">Select Function</option>
							<option value="min">Min</option>
							<option value="max">Max</option>
						</select>
						<input type="text" class="concatenatebtn btn btn-primary" name="admit_date" data-field-name="admit_date"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="admit_date_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="admit_date_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="admit_date_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 admit_time">
						<div class="form-group">
							<label class="control-label">Admit Time</label>
							<input type="text" name="admit_time"   autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
							<input type="hidden" name="" value="patient_visit" class="form-control">
							<input type="text" name="admit_time_width" value=""  class="form-control" placeholder="width" style="width:8%;">
							<input type="text" class="concatenatebtn btn btn-primary" name="admit_time" data-field-name="admit_time"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="admit_time_concatination_fields" rows="2" cols="30" readonly></textarea>
							<input type="text" name="admit_time_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
							<input type="text" name="admit_time_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 insert_datetime">
						<div class="form-group">
						<label class="control-label">Insert Datetime</label>
						<input type="text" name="insert_datetime"   autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="insert_datetime_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<select name="insert_datetime_funct" class="form-control">
							<option value="#">Select Function</option>
							<option value="min">Min</option>
							<option value="max">Max</option>
						</select>
						<input type="text" class="concatenatebtn btn btn-primary" name="insert_datetime" data-field-name="insert_datetime"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="insert_datetime_concatination_fields" rows="2" cols="30" readonly></textarea>
							<input type="text" name="insert_datetime_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
							<input type="text" name="insert_datetime_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 update_datetime">
						<div class="form-group">
						<label class="control-label">Update Datetime</label>
						<input type="text" name="update_datetime"   autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="update_datetime_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<select name="update_datetime_funct" class="form-control">
							<option value="#">Select Function</option>
							<option value="min">Min</option>
							<option value="max">Max</option>
						</select>
						<input type="text" class="concatenatebtn btn btn-primary" name="update_datetime" data-field-name="update_datetime"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="update_datetime_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="update_datetime_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="update_datetime_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 update_time">
						<div class="form-group">
						<label class="control-label">Update Datetime</label>
						<input type="text" name="update_time"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_followup" class="form-control">
						<input type="text" name="update_time_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<select name="update_time_funct" class="form-control">
							<option value="#">Select Function</option>
							<option value="min">Min</option>
							<option value="max">Max</option>
						</select>
						<input type="text" class="concatenatebtn btn btn-primary" name="update_time" data-field-name="update_time"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="update_time_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="update_time_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="update_time_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 p_insert_datetime">
						<div class="form-group">
						<label class="control-label">Insert Datetime</label>
						<input type="text" name="insert_datetime"   autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="p_insert_datetime_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<select name="p_insert_datetime_funct" class="form-control">
							<option value="#">Select Function</option>
							<option value="min">Min</option>
							<option value="max">Max</option>
						</select>
						<input type="text" class="concatenatebtn btn btn-primary" name="p_insert_datetime" data-field-name="p_insert_datetime"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="p_insert_datetime_concatination_fields" rows="2" cols="30" readonly></textarea>
							<input type="text" name="p_insert_datetime_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
							<input type="text" name="insert_datetime_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 insert_by_user_id">
						<div class="form-group">
						<label class="control-label">Insert by userid</label>
						<input type="text" name="insert_by_user_id"   autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="insert_by_user_id_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="insert_by_user_id" data-field-name="insert_by_user_id"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="insert_by_user_id_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="insert_by_user_id_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="insert_by_user_id_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 update_by_user_id">
						<div class="form-group">
						<label class="control-label">Update by userid</label>
						<input type="text" name="update_by_user_id"   autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="update_by_user_id_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="update_by_user_id" data-field-name="update_by_user_id"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="update_by_user_id_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="update_by_user_id_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="update_by_user_id_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 discharge_weight ">
						<div class="form-group">
						<label class="control-label">Discharge Weight</label>
						<input type="text" name="discharge_weight"   autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="discharge_weight_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="discharge_weight" data-field-name="discharge_weight"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="discharge_weight_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="discharge_weight_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="discharge_weight_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
					</div>
					</div>
					<div class="layout-div col-md-12 pulse_rate">
						<div class="form-group">
						<label class="control-label">Pulse Rate</label>
						<input type="text" name="pulse_rate"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">  
						<input type="text" name="pulse_rate_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="pulse_rate" data-field-name="pulse_rate"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="pulse_rate_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="pulse_rate_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="pulse_rate_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 respiratory_rate">
						<div class="form-group">
						<label class="control-label">Respiratory Rate</label>
						<input type="text" name="respiratory_rate"  class="form-control" placeholder="Enter Column Name" />
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="respiratory_rate_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="respiratory_rate" data-field-name="respiratory_rate"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="respiratory_rate_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="respiratory_rate_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="respiratory_rate_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">	
						</div>
					</div>
					<div class="layout-div col-md-12 temperature">
						<div class="form-group">
						<label class="control-label">Temperature</label>
					    <input type="text" name="temperature"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="temperature_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="temperature" data-field-name="temperature"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="temperature_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="temperature_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="temperature_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">			
						</div>
					</div>
					<div class="layout-div col-md-12 spo2">
						<div class="form-group">
						<label class="control-label">SpO2</label>
						<input type="text" name="spo2"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="spo2__width" value=""  class="form-control" placeholder="width" style="width:8%;">	
						<input type="text" class="concatenatebtn btn btn-primary" name="spo2" data-field-name="spo2"
							value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="spo2_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="spo2_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="spo2_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">	
						</div>
					</div>
					<div class="layout-div col-md-12 provisional_diagnosis">
						<div class="form-group">
						<label class="control-label">Provisional Diag.</label>
							<input type="text" name="provisional_diagnosis" autocomplete="off"  class="form-control" placeholder="Enter Column Name"/>
							<input type="hidden" name="" value="patient_visit" class="form-control">
							<input type="text" name="temperature_width" value=""  class="form-control" placeholder="width" style="width:8%;">
							<input type="text" class="concatenatebtn btn btn-primary" name="provisional_diagnosis" data-field-name="provisional_diagnosis"
								value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="provisional_diagnosis_concatination_fields" rows="2" cols="30" readonly></textarea>
							<input type="text" name="provisional_diagnosis_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
							<input type="text" name="provisional_diagnosis_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">	
							</div>
					</div>
					<div class="layout-div col-md-12 outcome">
						<div class="radio ">
						<label class="control-label">Outcome</label>
							<input type="text" name="outcome"  autocomplete="off" placeholder="Enter Column Name" class="form-control">
							<input type="hidden" name="" value="patient_visit" class="form-control">
							<input type="text" name="outcome_width" value=""  class="form-control" placeholder="width" style="width:8%;">
							<input type="text" class="concatenatebtn btn btn-primary" name="outcome" data-field-name="outcome"
								value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="outcome_concatination_fields" rows="2" cols="30" readonly></textarea>
							<input type="text" name="outcome_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
							<input type="text" name="outcome_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>					
					</div>
					<div class="layout-div col-md-12 outcome_date">
						<div class="form-group">
						<label class="control-label">Outcome Date</label>
							<input type="text" name="outcome_date"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
							<input type="hidden" name="" value="patient_visit" class="form-control">
							<input type="text" name="outcome_date_width" value=""  class="form-control" placeholder="width" style="width:8%;">
							<input type="text" class="concatenatebtn btn btn-primary" name="outcome_date" data-field-name="outcome_date"
								value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="outcome_date_concatination_fields" rows="2" cols="30" readonly></textarea>
							<input type="text" name="outcome_date_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
							<input type="text" name="outcome_date_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 outcome_time">
						<div class="form-group">
						<label class="control-label">Outcome Time</label>
						<input type="text" name="outcome_time"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="outcome_time_width" value=""  class="form-control" placeholder="width" style="width:8%;"> 
						<input type="text" class="concatenatebtn btn btn-primary" name="outcome_time" data-field-name="outcome_time"
								value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="outcome_time_concatination_fields" rows="2" cols="30" readonly></textarea>
							<input type="text" name="outcome_time_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
							<input type="text" name="outcome_time_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 final_diagnosis">
						<div class="form-group">
						<label class="control-label">Final Diagnosis</label>
						<input type="text" name="final_diagnosis"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="final_diagnosis_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="final_diagnosis" data-field-name="final_diagnosis"
								value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="final_diagnosis_concatination_fields" rows="2" cols="30" readonly></textarea>
							<input type="text" name="final_diagnosis_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
							<input type="text" name="final_diagnosis_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 decision">
						<div class="form-group">
						<label class="control-label">Decision</label>
						<input type="text" name="decision"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="decision_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="decision" data-field-name="decision"
								value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="decision_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="decision_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="decision_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 advise">
						<div class="form-group">
						<label class="control-label">Advise</label>
						<input type="text" name="advise"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="advise_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="advise" data-field-name="advise"
								value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="advise_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="advise_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="advise_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 blood_sugar">
						<div class="form-group">
						<label class="control-label">Blood Sugar</label>
						<input type="text" name="blood_sugar"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="blood_sugar_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="blood_sugar" data-field-name="blood_sugar"
								value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="blood_sugar_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="blood_sugar_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="blood_sugar_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 family_history">
						<div class="form-group">
						<label class="control-label">Family History</label>
						<input type="text" name="family_history"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="family_history_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="family_history" data-field-name="family_history"
								value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="family_history_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="family_history_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="family_history_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 clinical_findings">
						<div class="form-group">
						<label class="control-label">Clinical Finding</label>
						<input type="text" name="clinical_findings"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="clinical_findings_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="clinical_findings" data-field-name="clinical_findings"
								value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="clinical_findings_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="clinical_findings_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="clinical_findings_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 cvs">
						<div class="form-group">
						<label class="control-label">CVS</label>
						<input type="text" name="cvs"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="cvs_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="cvs" data-field-name="cvs"
								value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="cvs_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="cvs_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="cvs_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 rs">
						<div class="form-group">
						<label class="control-label">RS</label>
						<input type="text" name="rs"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="RS_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="rs" data-field-name="rs"
								value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="rs_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="rs_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="rs_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 pa">
						<div class="form-group">
						<label class="control-label">PA</label>
						<input type="text" name="pa"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="pa_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="pa" data-field-name="pa"
								value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="pa_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="pa_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="pa_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 cns">
						<div class="form-group">
						<label class="control-label">CNS</label>
						<input type="text" name="cns"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="cns_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="cns" data-field-name="cns"
								value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="cns_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="cns_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="cns_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
					<div class="layout-div col-md-12 update_btn">
						<div class="form-group">
						<label class="control-label">Update button</label>
						<input type="text" name="update_btn"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_visit" class="form-control">
						<input type="text" name="update_btn_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 followup_upd_btn">
						<div class="form-group">
						<label class="control-label">Followup Update button</label>
						<input type="text" name="followup_upd_btn"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient_followup" class="form-control">
						<input type="text" name="followup_upd_btn_width" value=""  class="form-control" placeholder="width">
						</div>
					</div>
					<div class="layout-div col-md-12 congenital_anomalies">
						<div class="form-group">
						<label class="control-label">Congenital anomalies</label>
						<input type="text" name="congenital_anomalies"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
						<input type="hidden" name="" value="patient" class="form-control">
						<input type="text" name="congenital_anomalies_width" value=""  class="form-control" placeholder="width" style="width:8%;">
						<input type="text" class="concatenatebtn btn btn-primary" name="congenital_anomalies" data-field-name="congenital_anomalies"
								value="Concatenate Fields" style="font-size:12px;width:16%;">	
							<textarea name="congenital_anomalies_concatination_fields" rows="2" cols="30" readonly></textarea>
						<input type="text" name="congenital_anomalies_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
						<input type="text" name="congenital_anomalies_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
						</div>
					</div>
						<div class="layout-div col-md-12 longitude">
							<div class="form-group">
								<label class="control-label">Longitude</label>
								<input type="text" name="longitude"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="longitude_width" value=""  class="form-control" placeholder="width" style="width:8%;">
								<input type="text" class="concatenatebtn btn btn-primary" name="longitude" data-field-name="longitude"
									value="Concatenate Fields" style="font-size:12px;width:16%;">	
								<textarea name="longitude_concatination_fields" rows="2" cols="30" readonly></textarea>
							<input type="text" name="longitude_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
							<input type="text" name="longitude_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
							</div>
						</div>
						<div class="layout-div col-md-12 latitude">
							<div class="form-group">
								<label class="control-label">Latitude</label>
								<input type="text" name="latitude"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="latitude_width" value=""  class="form-control" placeholder="width" style="width:8%;">
								<input type="text" class="concatenatebtn btn btn-primary" name="latitude" data-field-name="latitude"
									value="Concatenate Fields" style="font-size:12px;width:16%;">	
								<textarea name="latitude_concatination_fields" rows="2" cols="30" readonly></textarea>
								<input type="text" name="latitude_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
								<input type="text" name="latitude_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
							</div>
						</div>
						<div class="layout-div col-md-12 life_status">
							<div class="form-group">
								<label class="control-label">Life Status</label>
								<input type="text" name="life_status"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="life_status_width" value=""  class="form-control" placeholder="width" style="width:8%;">
								<input type="text" class="concatenatebtn btn btn-primary" name="life_status" data-field-name="life_status"
									value="Concatenate Fields" style="font-size:12px;width:16%;">	
								<textarea name="life_status_concatination_fields" rows="2" cols="30" readonly></textarea>
								<input type="text" name="life_status_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
								<input type="text" name="life_status_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
							</div>
						</div>
						<div class="layout-div col-md-12 icd_code">
							<div class="form-group">
								<label class="control-label">ICD Code</label>
								<input type="text" name="icd_code"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="icd_code_width" value=""  class="form-control" placeholder="width" style="width:8%;">
								<input type="text" class="concatenatebtn btn btn-primary" name="icd_code" data-field-name="icd_code"
									value="Concatenate Fields" style="font-size:12px;width:16%;">	
								<textarea name="icd_code_concatination_fields" rows="2" cols="30" readonly></textarea>
								<input type="text" name="icd_code_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
								<input type="text" name="icd_code_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
							</div>
						</div>
						<div class="layout-div col-md-12 diagnosis">
							<div class="form-group">
								<label class="control-label">Diagnosis</label>
								<input type="text" name="diagnosis"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="diagnosis_width" value=""  class="form-control" placeholder="width" style="width:8%;">
								<input type="text" class="concatenatebtn btn btn-primary" name="diagnosis" data-field-name="diagnosis"
									value="Concatenate Fields" style="font-size:12px;width:16%;">	
								<textarea name="diagnosis_concatination_fields" rows="2" cols="30" readonly></textarea>
								<input type="text" name="diagnosis_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
								<input type="text" name="diagnosis_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
							</div>
						</div>
						<div class="layout-div col-md-12 priority_type_id">
							<div class="form-group">
								<label class="control-label">Priority Type</label>
								<input type="text" name="priority_type_id"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="priority_type_id_width" value=""  class="form-control" placeholder="width" style="width:8%;">
								<input type="text" class="concatenatebtn btn btn-primary" name="priority_type_id" data-field-name="priority_type_id"
									value="Concatenate Fields" style="font-size:12px;width:16%;">	
								<textarea name="priority_type_id_concatination_fields" rows="2" cols="30" readonly></textarea>
								<input type="text" name="priority_type_id_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
								<input type="text" name="priority_type_id_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
							</div>
						</div>

						<div class="layout-div col-md-12 route_primary_id">
							<div class="form-group">
								<label class="control-label">Route Primary</label>
								<input type="text" name="route_primary_id"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="route_primary_id_width" value=""  class="form-control" placeholder="width" style="width:8%;">
								<input type="text" class="concatenatebtn btn btn-primary" name="route_primary_id" data-field-name="route_primary_id"
									value="Concatenate Fields" style="font-size:12px;width:16%;">	
								<textarea name="route_primary_id_concatination_fields" rows="2" cols="30" readonly></textarea>
								<input type="text" name="route_primary_id_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
								<input type="text" name="route_primary_id_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
							</div>
						</div>

						<div class="layout-div col-md-12 route_secondary_id">
							<div class="form-group">
								<label class="control-label">Route Secondary</label>
								<input type="text" name="route_secondary_id"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="route_secondary_id_width" value=""  class="form-control" placeholder="width" style="width:8%;">
								<input type="text" class="concatenatebtn btn btn-primary" name="route_secondary_id" data-field-name="route_secondary_id"
									value="Concatenate Fields" style="font-size:12px;width:16%;">	
								<textarea name="route_secondary_id_concatination_fields" rows="2" cols="30" readonly></textarea>
								<input type="text" name="route_secondary_id_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
								<input type="text" name="route_secondary_id_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
							</div>
						</div>
						<div class="layout-div col-md-12 ndps">
							<div class="form-group">
								<label class="control-label">NDPS</label>
								<input type="text" name="ndps"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="ndps_width" value=""  class="form-control" placeholder="width" style="width:8%;">
								<input type="text" class="concatenatebtn btn btn-primary" name="ndps" data-field-name="ndps"
									value="Concatenate Fields" style="font-size:12px;width:16%;">	
								<textarea name="ndps_concatination_fields" rows="2" cols="30" readonly></textarea>
								<input type="text" name="ndps_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
								<input type="text" name="ndps_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
							</div>
						</div>
						<div class="layout-div col-md-12 drug">
							<div class="form-group">
								<label class="control-label">Drug</label>
								<input type="text" name="drug"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="drug_width" value=""  class="form-control" placeholder="width" style="width:8%;">
								<input type="text" class="concatenatebtn btn btn-primary" name="drug" data-field-name="drug"
									value="Concatenate Fields" style="font-size:12px;width:16%;">	
								<textarea name="drug_concatination_fields" rows="2" cols="30" readonly></textarea>
								<input type="text" name="drug_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
								<input type="text" name="drug_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
							</div>
						</div>
						<div class="layout-div col-md-12 dose">
							<div class="form-group">
								<label class="control-label">Dose</label>
								<input type="text" name="dose"  class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="dose_width" value=""  class="form-control" placeholder="width" style="width:8%;">
								<input type="text" class="concatenatebtn btn btn-primary" name="dose" data-field-name="dose"
									value="Concatenate Fields" style="font-size:12px;width:16%;">	
								<textarea name="dose_concatination_fields" rows="2" cols="30" readonly></textarea>
								<input type="text" name="dose_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
								<input type="text" name="dose_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
							</div>
						</div>
						<div class="layout-div col-md-12 last_dispensed_date">
							<div class="form-group">
								<label class="control-label">Last Dispense Date</label>
								<input type="text" name="last_dispensed_date"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="last_dispensed_date_width" value=""  class="form-control" placeholder="width" style="width:8%;">
								<input type="text" class="concatenatebtn btn btn-primary" name="last_dispensed_date" data-field-name="last_dispensed_date"
									value="Concatenate Fields" style="font-size:12px;width:16%;">	
								<textarea name="last_dispensed_date_concatination_fields" rows="2" cols="30" readonly></textarea>
								<input type="text" name="last_dispensed_date_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
								<input type="text" name="last_dispensed_date_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
							</div>
						</div>
						<div class="layout-div col-md-12 last_dispensed_quantity">
							<div class="form-group">
								<label class="control-label">Last Dispense Quantity</label>
								<input type="text" name="last_dispensed_quantity" style="width: 150px" autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="last_dispensed_quantity_width" value=""  class="form-control" placeholder="width" style="width:8%;">
								<input type="text" class="concatenatebtn btn btn-primary" name="last_dispensed_quantity" data-field-name="last_dispensed_quantity"
									value="Concatenate Fields" style="font-size:12px;width:16%;">	
								<textarea name="last_dispensed_quantity_concatination_fields" rows="2" cols="30" readonly></textarea>
								<input type="text" name="last_dispensed_quantity_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
								<input type="text" name="last_dispensed_quantity_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
							</div>
						</div>
						<div class="layout-div col-md-12 map_link">
							<div class="form-group">
								<label class="control-label">Map Link</label>
								<input type="text" name="map_link"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="map_link_width" value=""  class="form-control" placeholder="width" style="width:8%;">
								<input type="text" class="concatenatebtn btn btn-primary" name="map_link" data-field-name="map_link"
									value="Concatenate Fields" style="font-size:12px;width:16%;">	
								<textarea name="map_link_concatination_fields" rows="2" cols="30" readonly></textarea>
								<input type="text" name="map_link_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
								<input type="text" name="map_link_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
							</div>
						</div>
						<div class="layout-div col-md-12 death_date">
							<div class="form-group">
								<label class="control-label">Death Date</label>
								<input type="text" name="death_date"  autocomplete="off" class="form-control" placeholder="Enter Column Name"/>
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="death_date_width" value=""  class="form-control" placeholder="width" style="width:8%;"> 
								<input type="text" class="concatenatebtn btn btn-primary" name="death_date" data-field-name="death_date"
									value="Concatenate Fields" style="font-size:12px;width:16%;">	
								<textarea name="death_date_concatination_fields" rows="2" cols="30" readonly></textarea>
								<input type="text" name="death_date_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
								<input type="text" name="map_link_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
							</div>
						</div>
						<div class="layout-div col-md-12 death_status">
							<div class="form-group">
								<label class="control-label">Death Status</label>
								<input type="text" name="death_status"  autocomplete="off" class="form-control" placeholder="Enter Column Name" />
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="death_status_width" value=""  class="form-control" placeholder="width" style="width:8%;">
								<input type="text" class="concatenatebtn btn btn-primary" name="death_status" data-field-name="death_status"
									value="Concatenate Fields" style="font-size:12px;width:16%;">	
								<textarea name="death_status_concatination_fields" rows="2" cols="30" readonly></textarea>
								<input type="text" name="death_status_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
								<input type="text" name="death_status_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
							</div>
						</div>
						<!-- Newly added -->
						<div class="layout-div col-md-12 note">
							<div class="form-group">
								<label class="control-label">Folloup Note</label>
								<input type="text" name="note"  autocomplete="off" class="form-control" placeholder="Enter Column Name" />
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="note_width" value=""  class="form-control" placeholder="width" style="width:8%;">
								<input type="text" class="concatenatebtn btn btn-primary" name="note" data-field-name="note"
									value="Concatenate Fields" style="font-size:12px;width:16%;">	
								<textarea name="note_concatination_fields" rows="2" cols="30" readonly></textarea>
								<input type="text" name="note_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
								<input type="text" name="note_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
							</div>
						</div>
						<div class="layout-div col-md-12 volunteer_id">
							<div class="form-group">
								<label class="control-label">Volunteer</label>
								<input type="text" name="volunteer_id"  autocomplete="off" class="form-control" placeholder="Enter Column Name" />
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="volunteer_width" value=""  class="form-control" placeholder="width" style="width:8%;">
								<input type="text" class="concatenatebtn btn btn-primary" name="volunteer_id" data-field-name="volunteer_id"
									value="Concatenate Fields" style="font-size:12px;width:16%;">	
								<textarea name="volunteer_id_concatination_fields" rows="2" cols="30" readonly></textarea>
								<input type="text" name="volunteer_id_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
								<input type="text" name="volunteer_id_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
							</div>
						</div>
						<div class="layout-div col-md-12 update_by">
							<div class="form-group">
								<label class="control-label">Updated by</label>
								<input type="text" name="update_by"  autocomplete="off" class="form-control" placeholder="Enter Column Name" />
								<input type="hidden" name="" value="patient_followup" class="form-control">
								<input type="text" name="update_by_width" value=""  class="form-control" placeholder="width" style="width:8%;">
								<input type="text" class="concatenatebtn btn btn-primary" name="volunteer_id" data-field-name="volunteer_id"
									value="Concatenate Fields" style="font-size:12px;width:16%;">	
								<textarea name="volunteer_id_concatination_fields" rows="2" cols="30" readonly></textarea>
								<input type="text" name="update_by_separator" class="form-control" placeholder="separator" style="width:10%;" autocomplete="off">
								<input type="text" name="update_by_alignment" class="form-control" placeholder="alignment" style="width:10%;" autocomplete="off">
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
			  <ul class="nav nav-sidebar checkboxesList">
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
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="insert_datetime" class="checklist" />Insert datetime
						</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="p_insert_datetime" class="checklist" />Registered Datetime
						</label>
					</div>
				</li>
			</ul>
			<strong>Birth Information</strong>
			  <ul class="nav nav-sidebar checkboxesList_one">
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
			  <ul class="nav nav-sidebar checkboxesList_two">
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
						<label><input type="checkbox" value="1" id="hosp_file_no" class="checklist" /> Hospital file no</label>
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
						<label><input type="checkbox" value="1" id="admit_time" class="checklist" />Admit Time</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="insert_datetime" class="checklist" /> Insert Datetime</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="update_datetime" class="checklist" /> Update Datetime</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="insert_by_user_id" class="checklist" /> Insert by userid</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="update_by_user_id" class="checklist" /> Update by userid</label>
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
						<label><input type="checkbox" value="1" id="clinical_findings" class="checklist" />Clinical Findings</label>
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
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="update_btn" class="checklist" />Update Button</label>
					</div>
				</li> 

			</ul>
			<strong>MLC Information</strong>
			  <ul class="nav nav-sidebar checkboxesList_three">
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="mlc_id" class="checklist" />MLC</label>
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
			  <ul class="nav nav-sidebar checkboxesList_four">
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
						<label><input type="checkbox" value="1" id="route_primary_id" class="checklist" /> Route primary id</label>
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
						<label><input type="checkbox" value="1" id="death_date" class="checklist" /> Death Date</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="death_status" class="checklist" /> Death Status</label>
					</div>
				</li>
				<!-- Newly added on 27-08-2024 -->
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="note" class="checklist" /> Followup Note</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="volunteer_id" class="checklist" /> Volunteer </label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="update_by" class="checklist" />  Updated By</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="update_time" class="checklist" /> Update Datetime</label>
					</div>
				</li>
				<li>  
					<div class="checkbox">
						<label><input type="checkbox" value="1" id="followup_upd_btn" class="checklist" /> Followup Update Button</label>
					</div>
				</li>
			</div>

      </form>

