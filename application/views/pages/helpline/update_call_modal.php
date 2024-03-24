<script type="text/javascript" src="<?php echo base_url();?>assets/js/ckeditor.js"></script>
<!-- Modal -->
<div class="modal fade" id="updateCallModal" tabindex="-1" role="dialog" aria-labelledby="updateCallModal">
    <div class="modal-dialog" role="document" style="width:40%">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeUpdateModal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
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
                    <div class="col-md-3">From Number: </div>
                    <div class="col-md-6">
                        <span class="fromnumber"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">Received by: </div>
                    <div class="col-md-6">
                        <span class="receivedby"></span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">Note</div>
                    <div class="col-md-6">
                    <div id="container"></div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-3">Caller Type</div>
                    <div class="col-md-6">
                        <select class="caller_type form-control" name="caller_type_<?php echo $call->call_id;?>"  id="caller_type_<?php echo $call->call_id;?>" style="width:250px" class="form-control">
                            <option value="">Caller Type</option>
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
                        <select class="language form-control"  name="language_<?php echo $call->call_id;?>"  id="language_	<?php echo $call->call_id;?>" style="width:250px">
                            <option value="">Language</option>
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
                    <div class="col-md-3">District</div>
                    <div class="col-md-6">
                       <select name="district_id" id="district_id" class="selectize_district" style="width:250px">
				<option value="">--Enter district-- </option>				
			</select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">Hospital </div>
                    <div class="col-md-6">
                        <select class="updateHospitalSelect form-control" style="width:250px" class="form-control">
                            <option value="">Select</option>
                            <!--
                            <?php foreach($all_hospitals as $hosp){ ?>
                                <option value="<?php echo $hosp->hospital_id;?>"
                                <?php if($call->hospital_id == $hosp->hospital_id) echo " selected "; ?>
                                ><?php echo $hosp->hospital;?></option>
                            <?php } ?>
                            -->
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">Department</div>
                    <div class="col-md-6">
                        <select class="updateDepartmentSelect form-control"  style="width:250px" class="form-control">
                            <option value="">Select</option>
                           <!-- <?php foreach($department as $dept){ ?>
                                <option value="<?php echo $dept->department_id;?>">
                                <?php echo $dept->department;?></option>
                            <?php } ?> -->
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">Call Category</div>
                    <div class="col-md-6">
                        <select class="call_category form-control" name="call_category_<?php echo $call->call_id;?>" id="call_category_<?php echo $call->call_id;?>" style="width:250px" class="form-control">
                            <option value="">Select</option>
                            <!--
                            <?php foreach($call_category as $cc){ ?>
                                <option value="<?php echo $cc->call_category_id;?>"
                                <?php if($call->call_category_id == $cc->call_category_id) echo " selected "; ?>
                                ><?php echo $cc->call_category;?></option>
                            <?php } ?>
                            -->
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">Resolution Status</div>
                    <div class="col-md-6">
                        <select class="resolution_status form-control" name="resolution_status_<?php echo $call->call_id;?>" style="width:250px" class="form-control">
                            <option value="">Select</option>                         
                        </select>
                      <div class="form-group">
				<input name="resolution_update_date_time" id="resolution_update_date_time" type="datetime-local" class="resolution_update_date_time form-control" style="width:250px"/>
			</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">Patient Type</div>
                    <div class="col-md-6">
                        <select class="patient_type form-control" name="visit_type_<?php echo $call->call_id;?>" id="visit_type_<?php echo $call->call_id;?>" style="width:250px" class="form-control">
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
                        <input class="call_id_email form-control" style="width:250px" readonly name="call_id_email" >
                    </div>
                </div>
                <div class="row updateCallStatus alert hidden" style="margin-left: 8px; margin-right: 8px;"></div>
                <div class="row" style="text-align: center">
                    <button class="submit btn btn-primary btn-sm" id="submitmodal">Update</button>
                    <button class="closeUpdateModal btn btn-danger btn-sm"  >Close</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script> 

var modalData;
var isupdatedOnce = false;
var editor ;
function initDistrictSelectize(){
        var districts = JSON.parse('<?php echo json_encode($districts); ?>');
	var selectize = $('#district_id').selectize({
	    valueField: 'district_id',
	    labelField: 'custom_data',
	    searchField: ['district','district_alias','state'],
	    options: districts,
	    create: false,
	    render: {
	        option: function(item, escape) {
	        	return '<div>' +
	                '<span class="title">' +
	                    '<span class="prescription_drug_selectize_span">'+escape(item.custom_data)+'</span>' +
	                '</span>' +
	            '</div>';
	        }
	    },
	    load: function(query, callback) {
	        if (!query.length) return callback();
		},

	});
	selectize[0].selectize.setValue($('#district_id').attr("data-previous-value"));
	
	
}
function setupUpdateCallModalData(callData,hospitalSelect,callCategorySelect,resolutionStatusSelect) {
    const modal = $("#updateCallModal");
    modalData = callData;
    hideUpdateCallStatusMessage();
    modal.find(".callId").html(callData.call_id);

    var callId = callData.call_id;
    var textareaId = 'testCkeditor_' + callId;
    var textarea = $('#' + textareaId);
    var textareaHtml = '<textarea name="note_' + callId + '" class="notes form-control" rows="4" id="' + textareaId + '" style="width:250px">' + callData.note + '</textarea>';
        $('#container').append(textareaHtml);
        ClassicEditor
            .create(document.getElementById(textareaId), {
                toolbar: ['bold', 'italic', 'bulletedList', 'numberedList']
            })
            .then(editor => {
                editor.setData(callData.note);
                editor.model.document.on('change:data', () => {
                    $('#' + textareaId).val(editor.getData());
                });
                textarea.data('ckeditor', editor);
            })
            .catch(error => {
                console.error(error);
            });
    
    modal.find(".fromnumber").html(callData.from_number);
    var recievedby = "";
    if(callData.short_name==null){
    	recievedby =callData.line_note.concat(' - ',callData.to_number);  
    }
    else {
    	recievedby =callData.short_name.concat(' - ',callData.dial_whom_number,' <br />  ',callData.line_note,' - ',callData.to_number);
    }
    modal.find(".receivedby").html(recievedby);
    modal.find(".notes").val(callData.note);
   
    if (callData.caller_type_id!=0){
    	modal.find(".caller_type").val(callData.caller_type_id);
    }else{
    	modalData.caller_type_id = "";
    	modal.find(".caller_type").val("");
    }
    //modal.find(".language").val(callData.language_id); 
    if (callData.language_id!=0){
    	modal.find(".language").val(callData.language_id);
    }
    else{
    	modalData.language_id = "";
    	modal.find(".language").val("");
    }   
    const callCategorySelectVal = buildCallCategoryOptions(callCategorySelect);
    modal.find(".call_category").html(callCategorySelectVal ? callCategorySelectVal: buildEmptyOption("Call Category"));
    modal.find(".call_category").val(callData.call_category_id);
    if (callData.call_category_id!=0){
    	modal.find(".call_category").val(callData.call_category_id);
    }
    else{
    	modalData.call_category_id = "";
    	modal.find(".call_category").val("");
    }
    const callresolutionStatusSelectVal = buildResolutionOptions(resolutionStatusSelect);
    modal.find(".resolution_status").html(callresolutionStatusSelectVal ? callresolutionStatusSelectVal: buildEmptyOption("Resolution Status"));
  
    modal.find(".resolution_status").val(callData.resolution_status_id);
    if (callData.resolution_status_id!=0){
    	modal.find(".resolution_status").val(callData.resolution_status_id);
    }
    else{
    	modalData.resolution_status_id = "";
    	modal.find(".resolution_status").val("");
    }
    //console.log(callData.resolution_date_time);
    var res = callData.resolution_date_time.split(" ");
    var dateval=res[0]+"T"+res[1];
    modal.find("#resolution_update_date_time").val(dateval);
   // $(".resolution_date").Zebra_DatePicker();
   // $(".resolution_time").ptTimeSelect();
    //const resolutionMoment = moment(callData.resolution_date_time)
    //modal.find(".resolution_date").val(resolutionMoment.isValid()? resolutionMoment.format("DD-MMM-YYYY"): "");
    //modal.find(".resolution_time").val(resolutionMoment.isValid()? new Date(callData.resolution_date_time).toLocaleTimeString(): "");
    const hospitals_val = buildHospitalOptions(hospitalSelect);
    modal.find(".updateHospitalSelect").html(hospitals_val ? hospitals_val: buildEmptyOption("Hospital"));
    //modal.find(".updateHospitalSelect").val(callData.hospital_id);	
    //console.log(callData.hospital_id);
    if (callData.hospital_id!=0){
    	modal.find(".updateHospitalSelect").val(callData.hospital_id);
    }
    else{
    	modalData.hospital_id = "";
    	modal.find(".updateHospitalSelect").val("");
    }
    //modal.find(".patient_type").val(callData.ip_op);
    
    if (callData.ip_op!=0){
    	modal.find(".patient_type").val(callData.ip_op);
    }
    else{
    	modalData.ip_op = "";
    	modal.find(".patient_type").val("");
    }
    
    modal.find(".visit_id").val(callData.visit_id);    

    let departmentOptions = getDepartmentOptionsForHospital(callData.hospital_id);
    departmentOptions = departmentOptions? departmentOptions: buildEmptyOption("Department");
    modal.find(".updateDepartmentSelect").html(departmentOptions);
    if (callData.department_id!=0){
    	modal.find(".updateDepartmentSelect").val(callData.department_id);
    }
    else{
    	modalData.department_id = "";
    	modal.find(".updateDepartmentSelect").val("");
    }   
    $('#district_id').attr("data-previous-value", callData.district_id);
    initDistrictSelectize();
    registerHospitalChangeListener();
    var element = document.getElementById("submitmodal");
    element.classList.add("submitmodal"+callData.call_id);
    registerOnUpdateFormSubmitted(callData);
    
}
function dateNow(dateObject){
    const delimiter = "-";
    const set = dateObject; 
    let getDate = set.getDate().toString();
    if (getDate.length == 1){
        getDate = "0"+getDate;
    }
    let getMonth = (set.getMonth()+1).toString();
    if (getMonth.length == 1){
        getMonth = "0"+getMonth;
    }
    let getYear = set.getFullYear().toString();
    const dateNow = getMonth + delimiter + getDate + delimiter + getYear; //today
    console.log(dateNow);
    return dateNow;
}
function formatDate() {

}
function updateCallData(callData) {   
    hideUpdateCallStatusMessage();
    console.log(callData);
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
                    isupdatedOnce = true;
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
    modal.find(".submitmodal"+callData.call_id).on("click", function(e) {
        e.preventDefault();
        var element = document.getElementById("submitmodal");
        if(element.classList.contains("submitmodal"+callData.call_id)) {
		const postData = {};
		const callId = callData.call_id;
		postData["call"] = [callId];
		postData[`caller_type_${callId}`] = modalData.caller_type_id = modal.find(".caller_type").val();
		postData[`language_${callId}`] = modalData.language_id =modal.find(".language").val();
		postData[`call_category_${callId}`] = modalData.call_category_id = modal.find(".call_category").val();
		postData[`resolution_status_${callId}`] = modalData.resolution_status_id = modal.find(".resolution_status").val();
		postData[`hospital_${callId}`] = modalData.hospital_id =modal.find(".updateHospitalSelect").val();
		postData[`visit_type_${callId}`] = modalData.ip_op  = modal.find(".patient_type").val();
		postData[`visit_id_${callId}`] = modalData.visit_id =modal.find(".visit_id").val();
		postData[`note_${callId}`] =  modal.find(".notes").val();
		postData[`group_${callId}`] = modal.find(".language").val();
		postData[`district_id_${callId}`] = modalData.district_id =  modal.find("#district_id").val();
		postData[`resolution_date_time_${callId}`] = modalData.resolution_date_time = modal.find(".resolution_update_date_time").val();
		postData[`department_id_${callId}`] = modalData.department_id = modal.find(".updateDepartmentSelect").val();   
		updateCallData(postData);   
	}
    });
    modal.find(".closeUpdateModal").on("click", function(e) {
    	e.preventDefault();
    	var changed = false;
    	
    	if (modal.find(".notes").val() && (modal.find(".notes").val() !== modalData.note) && !changed){
    		changed = true;
    		console.log("notes");
    	}  
    	
    	if ( modal.find("#district_id").val() &&  (modal.find("#district_id").val() !== modalData.district_id) && !changed){
    		changed = true;
    		console.log("district_id");
    	} 
    	
    	
    	if (modal.find(".caller_type").val() && (modal.find(".caller_type").val() !== modalData.caller_type_id) && !changed){
    		changed = true;    		
    		console.log("caller_type");
    	}
    	
    	 
    
    	if (modal.find(".language").val() && (modal.find(".language").val() !== modalData.language_id) && !changed){
    		changed = true;
    		console.log("language");
    	}  
    	
    	
    	
    	if (modal.find(".call_category").val() && (modal.find(".call_category").val() !== modalData.call_category_id) && !changed){
    		changed = true;
    		console.log("call_category");
    	}  
    	
    	
    	
    	if (modal.find(".resolution_status").val() && (modal.find(".resolution_status").val() !== modalData.resolution_status_id) && !changed){
    		changed = true;
    		console.log("resolution_status");
    		console.log(modal.find(".resolution_status").val());
    	} 
    	
    	
    	if(isupdatedOnce){
    		var dateval=modalData.resolution_date_time;
    	} else { 
    		var res = modalData.resolution_date_time.split(" ");
		var time = res[1].split(":");
		//var dateval=res[0]+"T"+time[0]+":"+time[1]+":00";
    		var dateval=res[0]+"T"+time[0]+":"+time[1];
    		
    	}
    	if (modal.find(".resolution_update_date_time").val() && !changed) {
    		var valModal = modal.find(".resolution_update_date_time").val();
    		if ( valModal !== dateval){
    			changed = true;			
			console.log("resolution_update_date_time");
    		} 
    	}
    	
    	
    	if (modal.find(".updateHospitalSelect").val() && (modal.find(".updateHospitalSelect").val() !== modalData.hospital_id) && !changed){
    		changed = true;
    		console.log("updateHospitalSelect");
    	} 
    	
    	
   
    	if (modal.find(".patient_type").val() && (modal.find(".patient_type").val() !== modalData.ip_op) && !changed){
    		changed = true;
    		console.log("patient_type");
    	} 
    	
    	
    	if (modal.find(".visit_id").val() && !changed) {
    		if (modal.find(".visit_id").val() !== modalData.visit_id){
    			changed = true;
    			console.log("visit_id");
    		} 
    	
    	}
    	
    	
    	if ( modal.find(".updateDepartmentSelect").val() && (modal.find(".updateDepartmentSelect").val() !== modalData.department_id) && !changed){
    		changed = true;
    		console.log("updateDepartmentSelect");
    	} 
    	
    	
    	if(changed){
    		bootbox.confirm({
    		message: "You have not saved changes. Do you want to close this page ? ",
    		buttons: {
        		confirm: {
            		label: 'Yes',
            		className: 'btn-success'
        		},
        		cancel: {
            		label: 'No',
            		className: 'btn-danger'
        		}
    		},
    		callback: function (result) {
    			bootbox.hideAll();
        		if(result){         				 	
        			modal.modal('hide');
        			$(this).data('modal', null);
        			 var element = document.getElementById("submitmodal");
    				element.classList.remove("submitmodal"+callData.call_id);
        			if(isupdatedOnce){    
    	 				window.location.reload();
    				}
        		}
    		}
	});
    	} else {    		
    		modal.modal('hide');
    		$(this).data('modal', null);
    		 var element = document.getElementById("submitmodal");
    		element.classList.remove("submitmodal"+callData.call_id);
    		if(isupdatedOnce){    
    	 		window.location.reload();
    		}
    	}
        window.location.reload();
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
