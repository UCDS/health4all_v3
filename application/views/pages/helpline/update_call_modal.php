<!-- Modal -->
<div class="modal fade" id="updateCallModal" tabindex="-1" role="dialog" aria-labelledby="updateCallModal">
    <div class="modal-dialog" role="document" style="width:90%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="updateCallModalLabel">Update Call</h4>
            </div>
            <div class="modal-body" style="Padding: 16px" id="emailModalBody">
                <div class="row">
                    <div class="col-md-3">Call ID: </div>
                    <div class="col-md-6">
                        <span class="callId"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">Note</div>
                    <div class="col-md-6">
                        <textarea name="note_<?php echo $call->call_id;?>" class="notes" rows="4" class="form-control"><?php echo $call->note;?></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">Caller Type</div>
                    <div class="col-md-6">
                        <select class="caller_type" name="caller_type_<?php echo $call->call_id;?>"  id="caller_type_<?php echo $call->call_id;?>" style="width:100px" class="form-control">
                            <option value="">Select</option>
                            <?php foreach($caller_type as $ct){ ?>
                                <option value="<?php echo $ct->caller_type_id;?>"
                                <?php if($call->caller_type_id == $ct->caller_type_id) echo " selected "; ?>
                                ><?php echo $ct->caller_type;?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">Language</div>
                    <div class="col-md-6">
                        <select class="language" name="language_<?php echo $call->call_id;?>"  id="language_	<?php echo $call->call_id;?>" style="width:100px" class="form-control">
                            <option value="">Select</option>
                            <?php foreach($language as $lng){ ?>
                                <option value="<?php echo $lng->language_id;?>"
                                    <?php if($call->language_id == $lng->language_id) echo " selected "; ?>
                                    ><?php echo $lng->language;?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">Hospital </div>
                    <div class="col-md-6">
                        <select class="updateHospitalSelect" style="width:100px" class="form-control">
                            <option value="">Select</option>
                            <?php foreach($all_hospitals as $hosp){ ?>
                                <option value="<?php echo $hosp->hospital_id;?>"
                                <?php if($call->hospital_id == $hosp->hospital_id) echo " selected "; ?>
                                ><?php echo $hosp->hospital;?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">Department</div>
                    <div class="col-md-6">
                        <select class="updateDepartmentSelect"  style="width:100px" class="form-control">
                            <option value="">Select</option>
                            <?php foreach($department as $dept){ ?>
                                <option value="<?php echo $dept->department_id;?>">
                                <?php echo $dept->department;?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">Caller Category</div>
                    <div class="col-md-6">
                        <select class="call_category" name="call_category_<?php echo $call->call_id;?>" id="call_category_<?php echo $call->call_id;?>" style="width:100px" class="form-control">
                            <option value="">Select</option>
                            <?php foreach($call_category as $cc){ ?>
                                <option value="<?php echo $cc->call_category_id;?>"
                                <?php if($call->call_category_id == $cc->call_category_id) echo " selected "; ?>
                                ><?php echo $cc->call_category;?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">Resolution Status</div>
                    <div class="col-md-6">
                        <select class="resolution_status" name="resolution_status_<?php echo $call->call_id;?>" style="width:100px" class="form-control">
                            <option value="">Select</option>
                            <?php foreach($resolution_status as $rs){ ?>
                                <option value="<?php echo $rs->resolution_status_id;?>"
                                <?php if($call->resolution_status_id == $rs->resolution_status_id) echo " selected "; ?>
                                ><?php echo $rs->resolution_status;?></option>
                            <?php } ?>
                        </select>
                        <input class="date form-control" class="resolution_date" name="resolution_date_<?php echo $call->call_id;?>" value="<?php if($call->resolution_date_time != 0) echo date("d-M-Y",strtotime($call->resolution_date_time)); else echo '';?>" placeholder="Resolution Date" />
                        <input class="time form-control" class="resolution_time" name="resolution_time_<?php echo $call->call_id;?>" value="<?php if($call->resolution_date_time != 0) echo date("g:i A",strtotime($call->resolution_date_time)); else echo '';?>" placeholder="Resolution Time" />                    
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">Patient Type</div>
                    <div class="col-md-6">
                        <select class="patient_type" name="visit_type_<?php echo $call->call_id;?>" id="visit_type_<?php echo $call->call_id;?>" style="width:100px" class="form-control">
                            <option value="">Select</option>
                                <option value="OP"
                                <?php if($call->ip_op == "OP") echo " selected "; ?>
                                >OP</option>
                                <option value="IP"
                                <?php if($call->ip_op == "IP") echo " selected "; ?>
                                >IP</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">Visit ID</div>
                    <div class="col-md-6">
                        <input class="call_id_email form-control" readonly name="call_id_email" >
                    </div>
                </div>
                <div class="row updateCallStatus alert hidden" style="margin-left: 8px; margin-right: 8px;"></div>
                <div class="row" style="text-align: center">
                    <button class="submit btn btn-primary btn-sm"  >Update</button>
                    <button class="closeUpdateModal btn btn-danger btn-sm"  >Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script> 
function setupUpdateCallModalData(callData) {
    console.log(callData);
    const modal = $("#updateCallModal");
    hideUpdateCallStatusMessage();
    modal.find(".callId").html(callData.call_id);
    modal.find(".notes").val(callData.notes);
    modal.find(".caller_type").val(callData.caller_type_id);
    modal.find(".language").val(callData.language_id);    
    modal.find(".call_category").val(callData.call_category_id);
    modal.find(".resolution_status").val(callData.resolution_status_id);
    modal.find(".resolution_date").val(callData.resolution_date_time.getDate());
    modal.find(".resolution_time").val(callData.resolution_date_time.getDate());
    const hospitals = buildHospitalOptions(userHospitals)
    modal.find(".updateHospitalSelect").html(hospitals? hospitals: buildEmptyOption("Hospital"));
    modal.find(".updateHospitalSelect").val(callData.hospital_id)
    modal.find(".patient_type").val(callData.ip_op);
    modal.find(".visit_id").val(callData.visit_id);    

    let departmentOptions = getDepartmentOptionsForHospital(callData.hospital_id);
    departmentOptions = departmentOptions? departmentOptions: buildEmptyOption("Department");
    modal.find(".updateDepartmentSelect").html(departmentOptions);
    registerHospitalChangeListener();
    registerOnUpdateFormSubmitted(callData);
}

function updateCallData(callData) {
    hideUpdateCallStatusMessage();
    $.ajax({
        url: 'update_call_api',
        data: callData,
        method: 'POST',
        success: (data) => {
            if(data)  {
                data = JSON.parse(data);
                if(data.status) {
                    $(".updateCallStatus").html(data.msg);
                    $(".updateCallStatus").removeClass("hidden").addClass("alert-info");
                } else {
                    $(".updateCallStatus").html(data.msg);
                    $(".updateCallStatus").removeClass("hidden").addClass("alert-danger");
                }
            }
        },
        error: (error) => {
            console.log("failed");
        }
    })
}

function hideUpdateCallStatusMessage() {
    $(".updateCallStatus").html("");
    $(".updateCallStatus").addClass("hidden");
}
function registerOnUpdateFormSubmitted(callData) {
    const modal = $("#updateCallModal");
    modal.find(".submit").on("click", function(e) {
        e.preventDefault();
        const postData = {};
        const callId = callData.call_id;
        postData["call"] = [callId];
        postData[`caller_type_${callId}`] = modal.find(".caller_type").val();
        postData[`language_${callId}`] = modal.find(".language").val();
        postData[`call_category_${callId}`] = modal.find(".call_category").val();
        postData[`resolution_status_${callId}`] = modal.find(".resolution_status").val();
        postData[`hospital_${callId}`] = modal.find(".hospital").val();
        postData[`visit_type_${callId}`] = modal.find(".patient_type").val();
        postData[`visit_id_${callId}`] = modal.find(".visit_id").val();
        postData[`note_${callId}`] = modal.find(".notes").val();
        postData[`group_${callId}`] = modal.find(".language").val();
        postData[`resolution_time_${callId}`] = modal.find(".language").val();
        postData[`resolution_date_${callId}`] = modal.find(".language").val();
        updateCallData(postData);   
    });
    modal.find(".closeUpdateModal").on("click", function() {
        modal.modal('hide');
    })
}

function registerHospitalChangeListener() {
    $(".updateHospitalSelect").off("change").on("change", function() {
		const hostpitalId = $(this).val();
		let optionsHtml = getDepartmentOptionsForHospital(hostpitalId);
        if(optionsHtml == null) {
            optionsHtml = buildEmptyOption("Department");
        }
		$(".updateDepartmentSelect").html(optionsHtml);
	})

}
</script>
<style>
    .row {
        padding-top: 8px;
        padding-bottom: 8px;
    }
</style>