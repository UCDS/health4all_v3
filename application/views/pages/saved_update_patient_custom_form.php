<!-- <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.chained.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" > -->


<script src="<?php echo base_url(); ?>assets/js/jquery.ui.core.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.ui.widget.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.ui.mouse.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.ui.sortable.min.js"></script>
<script type="text/javascript">
function printDiv(i)
{
var content = document.getElementById(i);
var pri = document.getElementById("ifmcontentstoprint").contentWindow;
pri.document.open();
pri.document.write(content.innerHTML);
pri.document.close();
pri.focus();
pri.print();
}

function printDiv_2(i)
{
var content = document.getElementById(i);
var pri = document.getElementById("ifmcontentstoprint_2").contentWindow;
pri.document.open();
pri.document.write(content.innerHTML);
pri.document.close();
pri.focus();
pri.print();
}

</script>

<?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('success'); ?>
    </div>
<?php elseif ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
        <?php echo $this->session->flashdata('error'); ?>
    </div>
<?php endif; ?>

<div class="row" style="overflow-x:hidden;">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
              <div class="col-md-6">
                 <h4> Form name - <span style="font-weight:bold;"><?php echo $saved_form_id[0]->form_name; ?></span></h4>
              </div>
              <div class="col-md-3">
                 <h4> Patient id - <span style="font-weight:bold;"><?php echo $patient_id; ?></span></h4>
              </div>
              <div class="col-md-3">
                 <!-- <h4> Visit id - <span style="font-weight:bold;"><?php echo $visit_id; ?></span></h4> -->
                 <h4> <span style="font-weight:bold;"><?php echo $visit_type_name; ?></span> - <span style="font-weight:bold;"><?php echo $file_no; ?></span></h4>
              </div>
            </div>
        </div>
        <?php echo form_open('register/save_custom_patient_visit_details',array('role'=>'form','class'=>'','id'=>'')); ?>

        <input type="hidden" name="patient_id" id="patient_id" value="<?php echo $patient_id; ?>" class="form-control" readonly>
        <input type="hidden" name="visit_id" value="<?php echo $visit_id; ?>" class="form-control" readonly>
        <input type="hidden" name="form_id" value="<?php echo $saved_form_id[0]->id; ?>" class="form-control" readonly>
        <input type="hidden" name="search_patient_id" value="<?php echo $patient_id; ?>" class="form-control" readonly>
        <input type="hidden" name="form_header" class="form-control" value="<?php echo $saved_form_id[0]->form_header ?>">
        <div class="panel-body">
        <?php if (!empty($saved_form_id)) { ?>
                <!-- <div class="sortable-container" style="width: 100%; padding: 15px 0;"> --> <!-- If needed activate sortable container -->
                <div class="" style="width: 100%; padding: 15px 0;">
                    <?php $counter = 1; ?>
                    <?php foreach ($saved_form_id as $sfi) { 
                        if ($sfi->no_of_cols == 1) {
                            $col = '12';
                        }
                        if ($sfi->no_of_cols == 2) {
                            $col = '6';
                        }
                        if ($sfi->no_of_cols == 3) {
                            $col = '4';
                        }
                    ?>
                    <div class="col-md-<?php echo $col; ?> sortable-item" >
                        <div class="form-group row myrow" style="padding-top:5px;padding-bottom:5px;">
                            <input type="hidden" name="sequence[]" class="sequence-input" value="<?php echo $counter; ?>" data-counter="<?php echo $counter; ?>" />
                            <!-- <label for="<?php echo $sfi->selected_columns; ?>" class="col-md-5 col-form-label">
                                <?php echo str_replace('_', ' ', $sfi->selected_columns); ?>
                            </label> -->
                            <label for="<?php echo $sfi->label; ?>" class="col-md-5 col-form-label">
                                <?php echo $sfi->label; ?>
                            </label>
                            <div class="col-md-12">
                                <?php if($sfi->selected_columns=='patient_id')
                                    {
                                ?>
                                    <input type="text" name="<?php echo $sfi->selected_columns . '.' . $sfi->table_name; ?>" 
                                    value="<?php echo $patient_id; ?>" class="form-control" readonly>
                                <?php }else if($sfi->selected_columns=='visit_id')
                                    {
                                ?>
                                    <input type="text" name="<?php echo $sfi->selected_columns . '.' . $sfi->table_name; ?>" 
                                    value="<?php echo $visit_id; ?>" class="form-control" readonly>
                                <?php } else if($sfi->selected_columns=='district_id' || $sfi->selected_columns=='state_id' )
                                    { 
                                ?>
                                    <select name="<?php echo $sfi->selected_columns . '.' . $sfi->table_name; ?>" id="district" class="form-control" <?php if((!empty($db_values[0]->district_id)) && $db_values[0]->district_id!='0') { echo "readonly"; } ?>>
                                        <option value="#">Select Distrcit</option>
                                        <?php foreach ($districts as $dis){ ?>
                                            <option <?php if($db_values[0]->district_id==$dis->district_id){ echo "selected" ; } ?>
                                                value="<?php echo $dis->district_id; ?>" data-state-id="<?php echo $dis->state_id; ?>"><?php echo $dis->district; ?></option>
                                        <?php } ?>
                                    </select>
                                <?php } else if($sfi->selected_columns=='department_id')
                                    {  
                                ?>
                                    <select name="<?php echo $sfi->selected_columns . '.' . $sfi->table_name; ?>" id="department" class="form-control mydeptunit" <?php if(!empty($db_values[0]->department_id)) { echo "readonly"; } ?>>
                                        <option value="#">Select Department</option>
                                        <?php foreach ($all_departments as $ald){ ?>
                                            <option <?php if($db_values[0]->department_id==$ald->department_id){ echo "selected" ; } ?>
                                            value="<?php echo $ald->department_id; ?>"><?php echo $ald->department; ?></option>
                                        <?php } ?>
                                    </select>
                                <?php } else if($sfi->selected_columns=='priority_type_id')
                                    {  
                                ?>
                                    <select name="<?php echo $sfi->selected_columns . '.' . $sfi->table_name; ?>" id="prority_type" class="form-control mydeptunit" <?php if(!empty($db_values[0]->priority_type_id)) { echo "readonly"; } ?>>
                                        <option value="#">Select Priority</option>
                                        <?php foreach ($priority_types as $pts){ ?>
                                            <option <?php if($db_values[0]->priority_type_id==$pts->priority_type_id){ echo "selected" ; } ?>
                                            value="<?php echo $pts->priority_type_id; ?>"><?php echo $pts->priority_type; ?></option>
                                        <?php } ?>
                                    </select>
                                <?php } else if($sfi->selected_columns=='route_secondary_id')
                                    {  
                                ?>
                                    <select name="<?php echo $sfi->selected_columns . '.' . $sfi->table_name; ?>" id="route_secondary" class="form-control mydeptunit" <?php if(!empty($db_values[0]->route_secondary_id)) { echo "readonly"; } ?>>
                                        <option value="#">Select Route Secondary</option>
                                        <?php foreach ($route_secondary as $rs){ ?>
                                            <option <?php if($db_values[0]->route_secondary_id==$rs->id){ echo "selected" ; } ?>
                                            value="<?php echo $rs->id; ?>"><?php echo $rs->route_secondary; ?></option>
                                        <?php } ?>
                                    </select>
                                <?php } else if($sfi->selected_columns=='outcome')
                                    {
                                ?>
                                    <label><input type="radio" <?php if($db_values[0]->outcome=='Discharge'){ echo 'checked'; } ?> value="Discharge" name="<?php echo $sfi->selected_columns . '.' . $sfi->table_name; ?>">&nbsp;Discharge</label>&nbsp;
                                    <label><input type="radio" <?php if($db_values[0]->outcome=='LAMA'){ echo 'checked'; } ?> value="LAMA" name="<?php echo $sfi->selected_columns . '.' . $sfi->table_name; ?>">&nbsp;LAMA</label>&nbsp;
                                    <label><input type="radio" <?php if($db_values[0]->outcome=='Absconded'){ echo 'checked'; } ?> value="Absconded" name="<?php echo $sfi->selected_columns . '.' . $sfi->table_name; ?>">&nbsp;Absconded</label>&nbsp;
                                    <label><input type="radio" <?php if($db_values[0]->outcome=='Death'){ echo 'checked'; } ?> value="Death" name="<?php echo $sfi->selected_columns . '.' . $sfi->table_name; ?>">&nbsp;Death</label>

                                <?php } else if (strpos($sfi->selected_columns, 'date') !== false) 
                                            { 
                                                 $column_name = $sfi->selected_columns;
                                                 $value = isset($db_values[0]->$column_name) ? $db_values[0]->$column_name : '';
                                    ?>
                                    <input type="date" name="<?php echo $sfi->selected_columns . '.' . $sfi->table_name; ?>" 
                                        value="<?php echo $value; ?>" class="form-control" id="<?php echo $sfi->selected_columns; ?>" autocomplete="off" <?php if($db_values[0]->$column_name!='0000-00-00') { echo "readonly"; } ?>>
                                <?php } else if (strpos($sfi->selected_columns, 'time') !== false) {
                                        $column_name = $sfi->selected_columns;
                                        $value = isset($db_values[0]->$column_name) ? $db_values[0]->$column_name : '';
                                    ?>
                                    <input type="time" name="<?php echo $sfi->selected_columns . '.' . $sfi->table_name; ?>" 
                                        value="<?php echo $value; ?>" class="form-control" id="<?php echo $sfi->selected_columns; ?>" autocomplete="off" <?php if($db_values[0]->$column_name!='00:00') { echo "readonly"; }?>>
                                <?php } else {  $column_name = $sfi->selected_columns?>
                                    <input type="text" name="<?php echo $sfi->selected_columns . '.' . $sfi->table_name; ?>" 
                                        value="<?php if(!empty($db_values[0]->$column_name) || $db_values[0]->$column_name!='0') { echo $db_values[0]->$column_name; }?>" class="form-control" id="<?php echo $sfi->selected_columns; ?>" 
                                            autocomplete="off" <?php if(!empty($db_values[0]->$column_name)) { echo "readonly"; } ?>>
                                <?php } ?>
                                
                            </div>
                        </div>
                    </div>
                    <?php $counter++; } ?>
                    <div class="row col-md-12" style="margin-left:5px;"><br/>
                        <div class="row container col-md-4" id="state-container" style="display:none;">
                            <label for="state" class="col-md-4 col-form-label">
                                State
                            </label>
                            <div class="col-md-3">
                                <select name="<?php echo 'state_code' . '.' . 'patient'; ?>" id="state" class="form-control" style="width:195px;">
                                    <option value="#">Select State</option>
                                    <?php foreach ($states as $sts){ ?>
                                        <option value="<?php echo $sts->state_id; ?>"><?php echo $sts->state; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" style="margin-left:5px;">
                            <div class="row container" id="area-container" >
                                <label for="area_con" class="col-md-1 col-form-label">
                                    Area
                                </label>
                                <div class="col-md-3">
                                    <select name="<?php echo 'area' . '.' . 'patient_visit'; ?>" id="area_con" class="form-control" style="width:195px;">
                                        <option value="#">Select Area</option>
                                        <?php foreach($areas as $a){ print_r($db_values); ?>
                                            <option  <?php if($db_values[0]->area==$a->area_id) { echo "selected"; } ?>
                                            
                                            value="<?php echo $a->area_id; ?>" data-department-id="<?php echo $a->department_id; ?>">
                                                <?php echo $a->area_name; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row container" id="unit-container">
                                <label for="unit_con" class="col-md-1 col-form-label">
                                    Unit
                                </label>
                                <div class="col-md-3">
                                    <select name="<?php echo 'unit' . '.' . 'patient_visit'; ?>" id="unit_con" class="form-control" style="width:195px;">
                                        <option value="#">Select Unit</option>
                                        <?php foreach($units as $us){ ?>
                                            <option <?php if($db_values[0]->unit==$us->unit_id) { echo "selected"; } ?>
                                            
                                            value="<?php echo $us->unit_id; ?>" data-department-id="<?php echo $us->department_id; ?>">
                                                <?php echo $us->unit_name; ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
                        $(document).ready(function() {
                            $('#state-container').hide();
                            $('#area-container').hide();
                            $('#unit-container').hide();
                            var selectedDistrict = $('#district').val();
                            if (selectedDistrict && selectedDistrict !== '#') {
                                var state_id = $('#district').find('option:selected').data('state-id');
                                $('#state-container').show();
                                $('#state').val(state_id);
                            }
                            var selectedDepartment = $('#department').val();
                            if (selectedDepartment && selectedDepartment !== '#') {
                                $('#area-container').show();
                                $('#unit-container').show();

                                $('#area_con option').each(function() {
                                    var optionDepartmentId = $(this).data('department-id');
                                    if (optionDepartmentId == selectedDepartment) {
                                        $(this).show();
                                    } else {
                                        $(this).hide();
                                    }
                                });

                                $('#unit_con option').each(function() {
                                    var optionDepartmentId = $(this).data('department-id');
                                    if (optionDepartmentId == selectedDepartment) {
                                        $(this).show();
                                    } else {
                                        $(this).hide();
                                    }
                                });
                            }

                            $('#district').change(function() {
                                var district_id = $(this).val();
                                if (district_id !== '#') {
                                    $('#state-container').show();
                                    var state_id = $(this).find('option:selected').data('state-id');
                                    $('#state').val(state_id);
                                } else {
                                    $('#state-container').hide();
                                }
                            });

                            $('#department').change(function() {
                                var department_id = $(this).val();
                                
                                $('#area_con').val('');
                                $('#unit_con').val('');
                                $('#area-container').hide();
                                $('#unit-container').hide();

                                if (department_id !== '#') {
                                    $('#area-container').show();
                                    $('#unit-container').show();

                                    $('#area_con option').each(function() {
                                        var optionDepartmentId = $(this).data('department-id');
                                        if (optionDepartmentId == department_id) {
                                            $(this).show();
                                        } else {
                                            $(this).hide();
                                        }
                                    });

                                    $('#unit_con option').each(function() {
                                        var optionDepartmentId = $(this).data('department-id');
                                        if (optionDepartmentId == department_id) {
                                            $(this).show();
                                        } else {
                                            $(this).hide();
                                        }
                                    });
                                } else {
                                    $('#area-container').hide();
                                    $('#unit-container').hide();
                                }
                            });
                            $('#area_con').change(function() {
                                var area_id = $(this).val();
                                if (area_id !== '#') {
                                }
                            });
                            $('#unit_con').change(function() {
                                var unit_id = $(this).val();
                                if (unit_id !== '#') {
                                }
                            });
                        });
                        
                    </script>
                </div>
            <?php } ?>
        </div>
        <iframe id="ifmcontentstoprint" style="height: 0px; width: 0px; position: absolute;" class="sr-only"></iframe>
        <div class="sr-only" id="print-div"> 
			<?php $this->load->view('pages/print_layouts/patient_summary');?>
		</div>
        <iframe id="ifmcontentstoprint_2" style="height: 0px; width: 0px; position: absolute;" class="sr-only"></iframe>
        <div class="sr-only" id="print-div-2"> 
			<?php $this->load->view('pages/print_layouts/patient_summary_custom');?>
		</div>
        <div class="panel-footer" style="display: flex;justify-content: center; align-items: center; gap: 10px;">
            <button type="submit" class="btn btn-primary btn-md" name="search_patients" value="1">Update</button>
            <button class="btn btn-md btn-warning" value="Print" type="button" onclick="printDiv('print-div')">Print Summary</button>
            <button type="button" class="btn btn-md btn-warning" id="printButton">Print Selected Format</button>
            <select class="form-control" name="add_on_print_layout_id" id="add_on_print_layout_id" style="width: 265px;">
                <option value="Select">Select Format</option>
                <?php foreach($hosp_all_print_layouts as $layout_name) { ?>
                    <option value="<?php echo $layout_name->add_on_print_layout_id; ?>"><?php echo $layout_name->print_layout_name; ?></option>
                <?php } ?>
            </select>
            <button class="btn btn-md btn-warning" value="Print" type="button" id="printButtonsss">Print Custom</button>
        </div>
        </form>
        <script>
            $(document).ready(function() {
                $('#printButtonsss').click(function() {
                    var formData = {};
                    $('.form-group.row.myrow').each(function() {
                        var label = $(this).find('label').text().trim();
                        var field = $(this).find('input[type="text"], select, textarea');
                        var value = '';
                        if (field.is('input[type="text"]') || field.is('textarea')) {
                            value = field.val().trim();
                        } else if (field.is('select')) {
                            value = field.find('option:selected').text().trim();
                        }
                        //alert("Label: " + label + "\nValue: " + value);
                        if (field.is('input[type="hidden"]')) {
                            return true;
                        }
                        label = label.replace(/[^a-zA-Z0-9]/g, '_');
                        value = value.replace(/[^a-zA-Z0-9]/g, '_');
                        formData[label] = value;
                        
                    });
                    var patientId = $('#patient_id').val().trim();
                    var visitId = $('input[name="visit_id"]').val().trim();
                    var form_header_value = $('input[name="form_header"]').val().trim();
                    if(form_header_value)
                    {
                        formData['form_header'] = form_header_value;
                    }
                    if (patientId) {
                        formData['patient_id'] = patientId;
                    }
                    if (visitId) {
                        formData['visit_id'] = visitId;
                    }
                    // var formHeaderValue = $('input[name="form_header"]').val().trim();
                    // if (formHeaderValue) {
                    //     var formHeaderLabel = 'form_header'; 
                    //     formHeaderValue = formHeaderValue.replace(/[^a-zA-Z0-9]/g, '_');
                    //     formData[formHeaderLabel] = formHeaderValue;
                    // }
                    var stateValue = $('#state').find('option:selected').text().trim();
                    if (stateValue && stateValue !== 'Select State') {
                        var stateLabel = 'state';
                        stateValue = stateValue.replace(/[^a-zA-Z0-9]/g, '_');
                        formData[stateLabel] = stateValue;
                    }
                    var areaValue = $('#area_con').find('option:selected').text().trim();
                    if (areaValue && areaValue !== 'Select Area') {
                        var areaLabel = 'area';
                        areaValue = areaValue.replace(/[^a-zA-Z0-9]/g, '_');
                        formData[areaLabel] = areaValue;
                    }
                    var unitValue = $('#unit_con').find('option:selected').text().trim();
                    if (unitValue && unitValue !== 'Select Unit') {
                        var unitLabel = 'unit';
                        unitValue = unitValue.replace(/[^a-zA-Z0-9]/g, '_');
                        formData[unitLabel] = unitValue;
                    }
                    console.log("Processed Form Data:", formData);
                    $.ajax({
                        url: "<?php echo site_url('register/store_form_data'); ?>", 
                        type: "POST",
                        data: { formData: formData },
                        dataType: 'json',
                        success: function(response) {
                            //console.log("Server Response:", response);
                            if (response.status === 'success') {
                                window.open("<?php echo site_url('register/print_custom_layout'); ?>", "_blank");
                            } else {
                                alert("There was an error saving the form data.");
                            }
                        },
                        error: function(xhr, status, error) {
                            //console.log("AJAX Error:", xhr.responseText);
                            alert('Error: ' + error);
                        }
                    });
                });
            });
        </script>
        <script>
			$(document).ready(function(){
				$('#printButton').click(function(){
					var selectedValue = $('#add_on_print_layout_id').val();
					var patientId = $('#patient_id').val(); // Get the patient_id value
					if(selectedValue != 'Select') {
						$.ajax({
							url: '<?php echo base_url();?>register/print_add_on_layouts',
							type: 'POST',
							data: {selectedValue: selectedValue, patientId: patientId},
							success: function(response) {
								var printWindow = window.open('', '_blank');
								printWindow.document.write('<style>.row { height: 20% !important; } body { padding-left: 20px; }</style>');								printWindow.document.write(response);
								printWindow.document.close();
								printWindow.print();
								printWindow.close();
							},
							error: function(xhr, status, error) {
								console.log(xhr.responseText);
							}
						});
					} else {
						alert("Please select a format.");
					}
				});
			});
		</script>
        <script>
            document.querySelector('form').addEventListener('submit', function(event) {
                // Loop through all the form inputs
                var formElements = this.elements;
                for (var i = 0; i < formElements.length; i++) {
                    var name = formElements[i].name;
                    
                    // Replace periods (.) with a placeholder string (__DOT__)
                    if (name.indexOf('.') !== -1) {
                        formElements[i].name = name.replace(/\./g, '__DOT__');
                    }
                }
            });
        </script>
    </div>
</div>

<script>
$(document).ready(function() {
    $(".sortable-container").sortable({
        items: ".sortable-item",
        handle: ".form-group",
        update: function(event, ui) {
            console.log("Order Updated");
            $(".sortable-item").each(function(index) {
                $(this).find(".sequence-input").val(index + 1);
            });
        }
    });
});
</script>

