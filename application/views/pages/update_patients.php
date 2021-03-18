<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/selectize.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.timeentry.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/moment.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
<!-- <script type="text/javascript" src="<?php echo base_url();?>assets/js/patient_field_validations.js"></script> -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/Chart.min.js"></script>
<link rel="stylesheet"  type="text/css" href="<?php echo base_url();?>assets/css/bootstrap_datetimepicker.css">
<!-- <link rel="stylesheet"  type="text/css" href="<?php echo base_url();?>assets/css/patient_field_validations.css"> -->
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-barcode.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
<style>
	.error {
    	color: red;
  	}
  	input.error, textarea.error, select.error,
  	input.error_field{
  		border: 1px solid red;
  	}
    .obstetric_history_table {  
        border-collapse: collapse; 
    }
    .obstetric_history_table tr{
        display: block; float: left;
    }
    .obstetric_history_table td{
        display: block; 
        border: 1px solid black;
        height: 55px;
    }
    .prescription_table_heading_icons, .prescription_table_heading_info_icons{
    	width: 15px;
    	height: 15px;
    	margin-right: 5px;
    	margin-left: 5px;
    }
    .prescription_warning_i{
    	width: 25px;
    	height: 25px;
    	padding-right: 5px;
    	padding-left: 5px;
    	font-size: 15px;
    }
    .border_bottom_dashed{
    	border-bottom: 1px dashed black;
    }
    .prescription textarea{
        resize: none;
    	width: 100%;
    	margin-top: 10px;
        height: 28px;
        overflow: hidden;
    }
    .prescription .note_tooltip, .prescription .glyphicon-pencil{
    	cursor: pointer;
    	-webkit-user-select: none; /* Safari */
	  	-ms-user-select: none; /* IE 10+ and Edge */
		user-select: none; /* Standard syntax */
    }
    .prescription .drug_available_class{
    	background: #6DF48F;
    	font-weight: bold;
    }
</style>
<style>
	.row{
		margin-bottom: 1.5em;
	}
	.alt{
		margin-bottom:0;
		padding:0.5em;
	}
	.alt:nth-child(odd){
		background:#eee;
	}
		.selectize-control.repositories .selectize-dropdown > div {
			border-bottom: 1px solid rgba(0,0,0,0.05);
		}
		.selectize-control.repositories .selectize-dropdown .by {
			font-size: 11px;
			opacity: 0.8;
		}
		.selectize-control.repositories .selectize-dropdown .by::before {
			content: 'by ';
		}
		.selectize-control.repositories .selectize-dropdown .name {
			font-weight: bold;
			margin-right: 5px;
		}
		.selectize-control.repositories .selectize-dropdown .title {
			display: block;
		}
		.selectize-control.repositories .selectize-dropdown .description {
			font-size: 12px;
			display: block;
			color: #a0a0a0;
			white-space: nowrap;
			width: 100%;
			text-overflow: ellipsis;
			overflow: hidden;
		}
		.selectize-control.repositories .selectize-dropdown .meta {
			list-style: none;
			margin: 0;
			padding: 0;
			font-size: 10px;
		}
		.selectize-control.repositories .selectize-dropdown .meta li {
			margin: 0;
			padding: 0;
			display: inline;
			margin-right: 10px;
		}
		.selectize-control.repositories .selectize-dropdown .meta li span {
			font-weight: bold;
		}
		.selectize-control.repositories::before {
			-moz-transition: opacity 0.2s;
			-webkit-transition: opacity 0.2s;
			transition: opacity 0.2s;
			content: ' ';
			z-index: 2;
			position: absolute;
			display: block;
			top: 12px;
			right: 34px;
			width: 16px;
			height: 16px;
			background: url(<?php echo base_url();?>assets/images/spinner.gif);
			background-size: 16px 16px;
			opacity: 0;
		}
		.selectize-control.repositories.loading::before {
			opacity: 0.4;
		}
</style>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.timeentry.min.js"></script>
<script type="text/javascript">
var smsDetails = {};
var user_details = <?php echo $user_details; ?>;
var receiver = user_details.receiver;
$(function(){
//	$(".date").Zebra_DatePicker();
//	$("#from_date,#to_date").Zebra_DatePicker();
});

<!-- Scripts for printing output table -->
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

function initiateSms(){
	setSmsToNumber();
	if(!smsDetails.to){
		$('.smsModal-customer-error').show();
		return;
	}
	$('.smsModal-customer-error').hide();

	// customer to agent flow...
	// ajax for call...
	$('#initiateSmsButton').val('Sending...').attr('disabled', 'disabled');

	$.ajax({
        url: '<?php echo base_url();?>helpline/initiate_sms',
        type: 'POST',
		dataType : 'JSON',
		data : smsDetails,
        error: function(res) {
            //callback();
			$('#initiateSmsButton').val('Send').removeAttr('disabled');
            bootbox.alert(res.responseText);
        },
        success: function(res) {
			$('#initiateSmsButton').val('Send').removeAttr('disabled');
			$("#SmsModal").modal('hide');
			bootbox.alert("Sms sent successfully");
        }
    });
}


function setSmsToNumber(){
	smsDetails.to = $('#smsModal-customer').val();
}
function sendToChangeReset(){
	$('.smsModal-customer-error').hide();
	$('.smsModal-app_id-error').hide();
	$('.smsModal-template-error').hide(); 

	$('[href="#change_sendto"]').removeAttr("data-hidden").html('Change');
	$('#change_sendto_section').addClass('hidden');
	$('[name=radio_doctor]:checked').removeAttr('checked');

	$('#smsModal_sendto_alternate_section').addClass('hidden');
	$('#smsModal-sendto-alternate option').remove();
	$('#smsModal-sendto-alternate-showmore').removeAttr('checked');
}

function openSmsModal(){
	sendToChangeReset();

	smsDetails.to = '';
	smsDetails.called_id = $('#smsModal-helplinewithname-dropdown').val();
	smsDetails.app_id = receiver.app_id;
	

	for (var key in json) {
		if (json.hasOwnProperty(key)) {
			if (json[key].helpline_id==smsDetails.called_id){
			if ($("select[id$='smsModal-templatewithname-dropdown'] option:contains('" + json[key].template_name + "')").length == 0) {
				$('#smsModal-templatewithname-dropdown').append('<option value="'+json[key].sms_template_id+'">'+json[key].template_name+'</option>');
				document.getElementById("smsModal-template").value=json[key].template;
			}
		    }
		}
	}

	setSmsTemplate(smsDetails.called_id);
	$('#smsModal-customer').removeAttr('readonly');
	$('#smsModal-helplinewithname').hide();
	$('#smsModal-templatewithname').hide();
	$('#smsModal-helplinewithname-dropdown').show();
	$('#smsModal-templatewithname-dropdown').show();	
	$("#smsModal").modal({ keyboard: false, backdrop: 'static' });
}

</script>
<script type="text/javascript">
    $(document).ready(function() {
  $("input:radio[name=mlc_radio]").click(function() {
      if($('input[name=mlc_radio]:checked').val()=='-1'){          
          $("#mlc_number_manual").prop("readonly", true);
          $("#ps_name").prop("readonly", true);
          $("#brought_by").prop("readonly", true);
          $("#police_intimation").prop("readonly", true);
          $("#declaration_required").prop("readonly", true);
          $("#pc_number").prop("readonly", true);
		  $("#mlc_number").val("not_mlc");
		  $("#mlc_number").prop("readonly", true);
      }else if($('input[name=mlc_radio]:checked').val()=='1'){          
          $("#mlc_number_manual").prop("disabled", false);
          $("#ps_name").prop("disabled", false);
          $("#brought_by").prop("disabled", false);
          $("#police_intimation").prop("disabled", false);
          $("#declaration_required").prop("disabled", false);
          $("#pc_number").prop("disabled", false);
		  $("#mlc_number").val("unset");
      }
   });
   
   $('#myModalDelete_').on('show.bs.modal', function(e) {

		//get data-id attribute of the clicked element
		var id = $(e.relatedTarget).data('id');
		//populate the textbox
		$(e.currentTarget).find('input[name="document_link"]').val(id);
	});
	
	 $('#myModalEdit_').on('show.bs.modal', function(e) {

		//get data-id attribute of the clicked element
		var id = $(e.relatedTarget).data('id');
		var note = $(e.relatedTarget).data('note');
		var type = $(e.relatedTarget).data('type');
		var doc_date = $(e.relatedTarget).data('date');
		var record_id = $(e.relatedTarget).data('recordid');
		//populate the textbox
		$(e.currentTarget).find('input[name="edit_document_link"]').val(id);
		$(e.currentTarget).find('label[id="filelink"]').html(id);
		$(e.currentTarget).find('input[id="edit_note"]').val(note);
		$(e.currentTarget).find('input[id="edit_record_id"]').val(record_id);
		
		if (type != "0") {		
			 $(e.currentTarget).find('select[id="edit_document_type"]').val(type).change();
		}
		else {
		 $(e.currentTarget).find('select[id="edit_document_type"]').val($('select[id="edit_document_type"] option:first').val()).change();
		}
		
		if (doc_date != "") {		
		
			$(e.currentTarget).find('input[id="edit_document_date"]').val(doc_date);
		}
	});

   $("#file_upload").click(function (event) {
	    //stop submit the form, we will post it manually.
		event.preventDefault();

        // Get form
        var form = $(event.target).parents('form')[0];

        // Create an FormData object 
        var data = new FormData(form);
        var id = $(this).attr('id')
        // disabled the submit button
        $("#file_upload").prop("disabled", true);

        $.ajax({
	        type: "POST",
	        enctype: 'multipart/form-data',
	        url: $(form).attr('action'),
	        data: data,
	        processData: false,
	        contentType: false,
	        cache: false,
	        success: function (data) {
		        // show success notification here...
		        location.reload()
	        },
    	    error: function (e) {
	    	    // show error notification here...
		        $("#file_upload").prop("disabled", false);
	        }
	     });
   });

   $("#btdelete").click(function(){
	    //stop submit the form, we will post it manually.
		event.preventDefault();

        // Get form
        var form = $(event.target).parents('form')[0];

        // Create an FormData object 
        var data = new FormData(form);

        // disabled the submit button
        $("#btdelete").prop("disabled", true);

        $.ajax({
	        type: "POST",
	        enctype: 'multipart/form-data',
	        url: $(form).attr('action'),
	        data: data,
	        processData: false,
	        contentType: false,
	        cache: false,
	        success: function (data) {
		        // show success notification here...
		        location.reload()
	        },
    	    error: function (e) {
	    	    // show error notification here...
		        $("#btdelete").prop("disabled", false);
	        }
	     });
    });
 $("#btEdit").click(function(){
	    //stop submit the form, we will post it manually.
		event.preventDefault();

        // Get form
        var form = $(event.target).parents('form')[0];

        // Create an FormData object 
        var data = new FormData(form);

        // disabled the submit button
        $("#btEdit").prop("disabled", true);

        $.ajax({
	        type: "POST",
	        enctype: 'multipart/form-data',
	        url: $(form).attr('action'),
	        data: data,
	        processData: false,
	        contentType: false,
	        cache: false,
	        success: function (data) {
		        // show success notification here...
		        location.reload()
	        },
    	    error: function (e) {
	    	    // show error notification here...
		        $("#btEdit").prop("disabled", false);
	        }
	     });
    });
   $("input:radio[name=insurance_case]").click(function() {
      if($('input[name=insurance_case]:checked').val()==0){
          $("#insurance_id").prop("disabled", true);
          $("#insurance_no").prop("disabled", true);
      }else if($('input[name=insurance_case]:checked').val()==1){
          $("#insurance_id").prop("disabled", false);
          $("#insurance_no").prop("disabled", false);
      }
   });
   var counter = 1;
   $("#add_obstetric_history").click(function(){
    var newRow = document.createElement('tr');
    alert('In add');
    newRow.innerHTML = '<td><input type="text" name="pregnancy_number[]" class="form-control pregnancy_number" id="pregnancy_number" placeholder="Pregnancy Number" /></td>'+
            '<td><input type="text" name="conception_type[]" class="form-control conception_type" id="conception_type" placeholder="Conception Type" /></td>'+
            '<td><input type="radio" name="delivered[]" class="form-control delivered" value="1" id="delivered" />Delivered <input type="radio" name="delivered[]" class="form-control delivered" value="-1" id="delivered" />Abortion'+
            '<td><input type="text" name="imp_date[]" class="form-control imp_date" id="imp_date" style="width:150px" /></td>' +
            '<td><input type="text" name="edd_date[]" class="form-control edd_date'+counter.toString()+'" id="edd_date'+counter.toString()+'" style="width:150px" /></td>' +            
            '<td><input type="text" name="delivery_outcome[]" class="form-control delivery_outcome" id="delivery_outcome" placeholder="Delivery Outcome" /></td>'+
            '<td><input type="radio" name="booked[]" class="form-control booked" value="1" id="booked" />Delivered <input type="radio" name="booked[]" class="form-control booked" value="-1" id="booked" />Abortion</td>' +
            '<td><input type="text" name="delivery_mode[]" class="form-control delivery_mode" id="delivery_mode" placeholder="Delivery Mode" /></td>' +
            '<td><input type="text" name="date_of_birth" class="form-control date_of_birth" id="date_of_birth" style="width:150px" /></td>' +
            '<td><input type="radio" name="gender[]" class="form-control gender" value="2" id="gender" />Male <input type="radio" name="gender[]" class="form-control gender" value="1" id="gender" />Female <input type="radio" name="gender[]" class="form-control gender" value="3" id="gender" />Other </td>' +
            '<td><input type="text" name="weight_at_birth[]" class="form-control weight_at_birth" id="weight_at_birth" placeholder="Weight at birth" /></td>'+
            '<td><input type="text" name="apgar[]" class="form-control apgar" id="apgar" placeholder="APGR" /></td>'+
            '<td><input type="radio" name="nicu_admission[]" class="form-control booked" value="1" id="booked" />Yes <input type="radio" name="nicu_admission[]" class="form-control booked" value="-1" id="booked" />No </td>' +
            '<td><input type="text" name="nicu_admission_reason[]" class="form-control nicu_admission_reason" id="nicu_admission_reason" placeholder="NICU Admission Reason" /></td>' +
            '<td><input type="radio" name="alive[]" class="form-control alive" value="1" id="alive" />Alive <input type="radio" name="alive[]" class="form-control alive" value="-1" id="alive" />Dead </td>' +
            '<td><input type="text" name="date_of_death" class="form-control date_of_death" id="date_of_death" style="width:150px" /></td>'+
            '<td><input type="text" name="cause_of_death[]" class="form-control cause_of_death" id="cause_of_death" placeholder="Cause of death" /></td>';
 //   $(".edd_date"+counter.toString()).Zebra_DatePicker();
 //   $('#obstetric_history').append(newRow);    
    counter++;
    document.getElementById('child_count') = counter;
    
   });
   
		$("#transfer_area").chained("#transfer_department");
		$("#from_area").chained("#from_department");
		$("#to_area").chained("#to_department");
});
</script>

<?php
	$patient = $patients[0];
?>

<?php 
	function drug_available($drug, $drugs_available){
		foreach($drugs_available as $drg){
			if($drg->generic_item_id == $drug->generic_item_id){
				return true;
			}
		}
		return false;
	}	
?>
<!-- $("#remove_obstetric_history").click(function(){
       alert('In remove');
       var rowCount = $("#obstetric_history").rows.length;
       var row = $("#obstetric_history").rows.[rowCount - 1];
       $("#obstetric_history").deleteRow(row);
   }); -->
<br />
	<?php 
        $pic_set = 1;
        if(isset($patients) && count($patients)>1){ ?>
	<table class="table table-bordered table-hover table-striped" id="table-sort">
	<thead>
		<th style="text-align:center">#</th>
		<th style="text-align:center">IP/OP No.</th>
		<th style="text-align:center">Patient</th>
		<th style="text-align:center">Admit Date</th>
		<th style="text-align:center">Department</th>
		<th style="text-align:center">Phone</th>
		<th style="text-align:center">Parent/Spouse</th>
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach($patients as $p){
		$age="";
		if($p->age_years!=0) $age.=$p->age_years."Y ";
		if($p->age_months!=0) $age.=$p->age_months."M ";
		if($p->age_days!=0) $age.=$p->age_days."D ";
		if($p->age_days==0 && $p->age_months == 0 && $p->age_years == 0) $age.="0D ";
	?>
	<tr onclick="$('#select_patient_<?php echo $p->visit_id;?>').submit()" style="cursor:pointer">
		<td>
			<?php echo form_open('register/update_patients',array('role'=>'form','id'=>'select_patient_'.$p->visit_id));?>
			<input type="text" class="sr-only" hidden value="<?php echo $p->visit_id;?>" form="select_patient_<?php echo $p->visit_id;?>" name="selected_patient" />
			<input type="text" class="sr-only" hidden value="<?php echo $p->patient_id;?>" name="patient_id" />
			</form>
			<?php echo $i++;?>
		</td>
		<td><?php echo $p->visit_type." #".$p->hosp_file_no;?></td>
		<td><?php echo $p->first_name." ".$p->last_name." | ".$age." | ".$p->gender;?></td>
		<td><?php echo date("d-M-Y",strtotime($p->admit_date));?></td>
		<td><?php echo $p->department;?></td>
		<td><?php echo $p->phone;?></td>
		<td><?php echo $p->parent_spouse;?></td>
	</tr>
	<?php
	}
	?>
	</tbody>
	</table>
	<?php } 
	else if(isset($patients) && count($patients)==1){
            ?>
<?php if(isset($duplicate)) { ?>
		<!-- If duplicate IP no is found then it displays the error message -->
			<div class="alert alert-danger">Entered Patient Manual ID Number already exists.</div>
<?php } ?>
	<?php if(isset($msg)) { ?>
		<div class="alert alert-info"><?php echo $msg;?></div>
	<?php } ?>
	<?php echo form_open('register/update_patients',array('class'=>'form-custom','role'=>'form', 'id'=>'update_patients')); ?>
	<input type="hidden" class="sr-only" value="<?php echo $transaction_id;?>" name="transaction_id" />
	<div class="panel panel-default">
	<div class="panel-body">
	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">
		<?php 
			foreach($functions as $f){ 
				if($f->user_function == "Update Patients"  || $f->user_function == "Clinical" || $f->user_function == "Diagnostics" || $f->user_function == "Procedures" || $f->user_function == "Prescription" || $f->user_function == "Discharge") { ?>
					<li role="presentation" <?php if(count($previous_visits) <= 1) echo "class='active'"; ?>><a href="#patient" aria-controls="patient" role="tab" data-toggle="tab"><i class="fa fa-user"></i> Patient Info</a></li>
				<?php 
				break;
				} 
			}
		?>
		<?php 
			foreach($functions as $f){ 
				if($f->user_function == "Update Patients") { ?>
					<li role="presentation"><a href="#patient_visit" aria-controls="patient_visit" role="tab" data-toggle="tab"><i class="fa fa-user"></i> Patient Visit</a></li>
				<?php 
				break;
				} 
			}
		?>
		<?php 
			foreach($functions as $f){ 
				if($f->user_function == "Patient Transport") { ?>
					<li role="presentation"><a href="#patient_transport" aria-controls="patient_transport" role="tab" data-toggle="tab"><i class="fa fa-user"></i> Patient Transport</a></li>
				<?php 
				break;
				} 
			}
		?>
                <?php 
			foreach($functions as $f){ 
				if($f->user_function == "mlc") { ?>
					<li role="presentation"><a href="#mlc" aria-controls="mlc" role="tab" data-toggle="tab"><i class="fa fa-user"></i> MLC Details</a></li>
				<?php 
				break;
				} 
			}
		?>
                       
                <?php 
			foreach($functions as $f){ 
				if($f->user_function == "obg" && ($f->add==1 || $f->edit==1) && $patient->gender != 'M') { ?>
					<li role="presentation"><a href="#obg" aria-controls="obg" role="tab" data-toggle="tab"><i class="fa fa-stethoscope"></i>OBG</a></li>
				<?php 
				break;
				 } 
			}
		?>                      
		<?php 
			foreach($functions as $f){ 
				if($f->user_function == "Clinical" && ($f->add==1 || $f->edit==1)) { ?>
					<li role="presentation"><a href="#clinical" aria-controls="clinical" role="tab" data-toggle="tab"><i class="fa fa-stethoscope"></i>Clinical</a></li>
				<?php 
				break;
				 } 
			}
		?>
		<?php 
			foreach($functions as $f){ 
				if($f->user_function == "View Diagnostics") { ?>
					<li role="presentation"><a href="#diagnostics" aria-controls="diagnostics" role="tab" data-toggle="tab"><i class="glyph-icon flaticon-chemistry20"></i> Diagnostics</a></li>
				<?php 
				break;
				 } 
			}
		?>
		<?php 
			foreach($functions as $f){ 
				if($f->user_function == "Procedures" && ($f->add==1 || $f->edit==1)) { ?>
					<li role="presentation"><a href="#procedures" aria-controls="procedures" role="tab" data-toggle="tab"><i class="fa fa-scissors"></i> Procedures</a></li>
				<?php 
				break;
				 } 
			}
		?>
		<?php 
			foreach($functions as $f){ 
				if($f->user_function == "Prescription" && ($f->add==1 || $f->edit==1)) { ?>
					<li role="presentation"><a href="#prescription" aria-controls="prescription" role="tab" data-toggle="tab"><i class="glyph-icon flaticon-drugs5"></i> Prescription</a></li>
				<?php 
				break;
				 } 
			}
		?>
		<?php 
			foreach($functions as $f){ 
				if($f->user_function == "Discharge" && ($f->add==1 || $f->edit==1)) { ?>
					<li role="presentation"><a href="#discharge" aria-controls="discharge" role="tab" data-toggle="tab"><i class="fa fa-sign-out"></i> Discharge</a></li>
				<?php 
				break;
				 } 
			}
		?>
		<?php 
			foreach($functions as $f){ 
				if($f->user_function == "Discharge" && ($f->add==1 || $f->edit==1)) { ?>
					<li role="presentation" <?php if(count($previous_visits) > 1) echo "class='active'"; ?>><a href="#vitals" aria-controls="discharge" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-signal" aria-hidden="true">&nbsp;</span>Vitals Trend</a></li>
				<?php 
				break;
				 } 
			}
		?>
		<?php 
			foreach($functions as $f){ 
				if($f->user_function == "patient_document_upload" && ($f->add==1 || $f->view ==1 || $f->edit==1 || $f->remove==1)) { ?>
					<li role="presentation" <?php if(count($previous_visits) > 1) echo "class='active'"; ?>><a href="#docupload" aria-controls="docupload" role="tab" data-toggle="tab"><span class="glyphicon glyphicon-file" aria-hidden="true">&nbsp;</span>Patient Documents</a></li>
				<?php 
				break;
				 } 
			}
		?>
	  </ul>
          <?php
				$age="";
				if($patient->age_years!=0) $age.=$patient->age_years."Y ";
				if($patient->age_months!=0) $age.=$patient->age_months."M ";
				if($patient->age_days!=0) $age.=$patient->age_days."D ";
				if($patient->age_days==0 && $patient->age_months ==0 && $patient->age_years==0) $age.="0D ";
            ?>
	  <!-- Tab panes -->
	  <div class="tab-content">
		<?php 
			foreach($functions as $f){ 
				if($f->user_function == "Update Patients" || $f->user_function == "Clinical" || $f->user_function == "Diagnostics" || $f->user_function == "Procedures" || $f->user_function == "Prescription" || $f->user_function == "Discharge") { ?>
		<div role="tabpanel" class="tab-pane <?php if(count($previous_visits) <= 1) echo "active"; ?>" id="patient">			
                <div class="col-md-4 col-lg-3">
                    <div class="well well-sm text-center">
                        <img src="<?php echo base_url()."assets/images/patients/".$patient->patient_id;?>.jpg" alt="Image" style="width:50%;height:50%" onError="this.onerror=null;this.src='<?php echo base_url()."assets/images/patients/default.png";?>';" />
                    </div>
                </div>
		<iframe id="ifmcontentstoprint" style="height: 0px; width: 0px; position: absolute;display:none"></iframe>
		<div class="sr-only" id="print-div" style="width:100%;height:100%;"> 
			<?php $this->load->view('pages/print_layouts/patient_summary');?>
		</div>
                <div class="col-md-8"  >
			<div class="row alt">
                            <div class="col-md-4 col-xs-12 col-lg-3"  style="background: #FFA500;">
                                <b>Patient ID: <?php echo $patient->patient_id; ?> </b>
                            </div>
			<div class="col-md-4 col-xs-12 col-lg-4">
				<b><?php echo $patient->visit_type; ?> Number: </b><?php echo $patient->hosp_file_no;?>
			</div>
			<div class="col-md-4 col-xs-12 col-lg-5">
				<b><?php if( $patient->visit_type == "IP") echo "Admit Date:"; else echo "Visit Date:";?></b>
				<?php echo date("d-M-Y", strtotime($patient->admit_date)).", ".date("g:ia", strtotime($patient->admit_time));?>
			</div>
			</div>
			<div class="row alt">
                        <div class="col-md-4 col-xs-12 col-lg-4">
				<label class="control-label">Patient ID Manual
				<input type="text" name="patient_id_manual" class="form-control" placeholder="Patient ID Manual" value="<?php if($patient) echo $patient->patient_id_manual;?>" <?php if($f->edit==1 && empty($patient->patient_id_manual)) echo ''; else echo ' readonly'; ?>  style="background: #ADFF2F; font-weight: bold;"/>
				</label>
			</div>
			<div class="col-md-4 col-xs-12 col-lg-4">
				<label class="control-label">First Name
				<input type="text" name="first_name" class="form-control" placeholder="First" value="<?php if($patient) echo $patient->first_name;?>" <?php if($f->edit==1 && empty($patient->first_name)) echo ' required'; else echo ' readonly'; ?> style="background: #ADFF2F; font-weight: bold;" />
				</label>
			</div>
                        <div class="col-md-4 col-xs-12 col-lg-4">
				<label class="control-label">Middle Name
				<input type="text" name="middle_name" class="form-control" placeholder="Middle" value="<?php if($patient) echo $patient->middle_name;?>" <?php if($f->edit==1 && empty($patient->middle_name)) echo ''; else echo ' readonly'; ?> style="background: #ADFF2F; font-weight: bold;" />
				</label>
			</div>
			<div class="col-md-4 col-xs-12 col-lg-4">
				<label class="control-label">Last Name
				<input type="text" name="last_name" class="form-control" placeholder="Last" value="<?php  if($patient) echo $patient->last_name;?>" <?php if($f->edit==1 && empty($patient->last_name)) echo ''; else echo ' readonly'; ?> style="background: #ADFF2F; font-weight: bold;"/>
				</label>
			</div>
			
			</div>
                        <div class="row alt">
			<div class="col-md-4 col-xs-4" style="background: #ADFF2F; font-weight: bold;" >
				<?php if(!empty($patient->gender)) { ?> 
					<label>
					<?php 
						if($patient->gender == 'M')
							echo "Male";
						else if($patient->gender == 'F')
							echo "Female";
						else 
							echo "Other";
					?>
					</label>
				<?php } else { ?>
				<label class="control-label"><input type="radio" class="gender" value="M" name="gender" />Male</label>
				<label class="control-label"><input type="radio" class="gender" value="F" name="gender" />Female</label>
				<label class="control-label"><input type="radio" class="gender" value="O" name="gender" />Others</label>
				<?php } ?>
			</div>			
			<div class="col-md-6 col-xs-12">
				<label class="control-label">Age</label>
				<input type="text" name="age_years" class="form-control" maxlength="3" size="3"  value="<?php if($patient)  echo $patient->age_years;?>" <?php if($f->edit==1 && empty($patient->age_years)) echo ''; else echo ' readonly'; ?>  style="background: #ADFF2F; font-weight: bold;"/>Y
				<input type="text" name="age_months" class="form-control" maxlength="2" size="2" value="<?php if($patient)  echo $patient->age_months;?>" <?php if($f->edit==1 && empty($patient->age_moths)) echo ''; else echo ' readonly'; ?>  style="background: #ADFF2F; font-weight: bold;"/>M
				<input type="text" name="age_days" class="form-control" maxlength="2" size="2"  value="<?php if($patient)  echo $patient->age_days;?>" <?php if($f->edit==1 && empty($patient->age_days)) echo ''; else echo ' readonly'; ?>  style="background: #ADFF2F; font-weight: bold;"/>D
			</div>			
			</div>
                    <div class ="row alt">
                        <div class="col-md-12 col-xs-12">
                                <label class="control-label">Date of Birth</label>
                                <input type="date" name="dob" class="form-control dob" value="<?php if($patient->dob!='0000-00-00') echo date("d-M-Y",strtotime($patient->dob)); else echo ""; ?>" <?php if($f->edit==1&& empty($patient->dob)) echo ''; else echo ' readonly'; ?>  />
                             <!--   <input type="date" name="dob" class="form-control" value="<?php if($patient)  echo $patient->dob;?>" <?php if($f->edit==1 && empty($patient->dob)) echo ''; else echo ' readonly'; ?>/> -->
                        </div>
                    </div>
                 </div>
               <div class="col-md-12">
			
                        <div class="row alt">
                            <div class="col-md-4 col-xs-6">
				<label class="control-label">Father's Name</label>
				<input type="text" name="father_name" class="form-control" value="<?php if($patient) echo $patient->father_name;?>" <?php if($f->edit==1 && empty($patient->father_name)) echo ''; else echo ' readonly'; ?>/>				
                            </div>
                            <div class="col-md-4 col-xs-6">
				<label class="control-label">Mother's Name</label>
				<input type="text" name="mother_name" class="form-control" value="<?php if($patient) echo $patient->mother_name;?>" <?php if($f->edit==1 && empty($patient->mother_name)) echo ''; else echo ' readonly'; ?>/>				
                            </div>
                            <div class="col-md-4 col-xs-6">
				<label class="control-label">Spouse Name</label>
				<input type="text" name="spouse_name" class="form-control" value="<?php if($patient) echo $patient->spouse_name;?>" <?php if($f->edit==1 && empty($patient->spouse_name)) echo ''; else echo ' readonly'; ?>/>				
                            </div>
                        </div>
			<div class="row alt">
			
			<div class="col-md-4 col-xs-6">
				<label class="control-label">Address</span></label>
				<input type="text" name="address" class="form-control" value="<?php if($patient) echo $patient->address;?>" <?php if($f->edit==1 && empty($patient->address)) echo ''; else echo ' readonly'; ?>/>
			</div>
			<div class="col-md-4 col-xs-6">
				<label class="control-label">Place</label>
				<input type="text" name="place" class="form-control" value="<?php if($patient) echo $patient->place;?>" <?php if($f->edit==1 && empty($patient->place)) echo ''; else echo ' readonly'; ?>/>
			</div>
                        <div class="col-md-4 col-xs-6">
				<label class="control-label">District</label>
                                <?php if($f->edit==1 && empty($patient->district_id)) { ?>
				<select name="district" class="form-control">
				<option value="">--Select--</option>
				<?php  						
				foreach($districts as $district){
					echo "<option value='".$district->district_id."'";
					if($patient) if($district->district_id==$patient->district_id) echo " selected ";
					echo ">".$district->district."</option>";
				}
				?>
				</select>
                                <?php }else{
                                    foreach($districts as $district){
                                        if($district->district_id==$patient->district_id){
                                            echo "<input type='text' id='district' class='form-control' value='$district->district' disabled/>";
                                            echo "<input type='hidden' name='district' id='district' class='form-control' value='$district->district_id'/>";
                                        }
                                    }
                                } ?>
			</div>
			</div>
			<div class="row alt">
			
			<div class="col-md-4 col-xs-6">
				<label class="control-label">Phone</label>
				<input type="text" name="phone" class="form-control" value="<?php if($patient) echo $patient->phone;?>" <?php if($f->edit==1 && empty($patient->phone)) echo ''; else echo ' readonly'; ?>/>
			</div>
                        <div class="col-md-4 col-xs-6">
				<label class="control-label">Alt Phone</label>
				<input type="text" name="alt_phone" class="form-control" value="<?php if($patient) echo $patient->alt_phone;?>" <?php if($f->edit==1 && empty($patient->phone)) echo ''; else echo ' readonly'; ?>/>
			</div>
                        </div>
			<div class="row alt">
			<div class="col-md-4 col-xs-6">
				<label class="control-label">Id Proof Type</label>
                                <?php if($f->edit==1 && empty($patient->id_proof_type_id)){ ?>
				<select name="id_proof_type" class="form-control">
				<option value="">--Select--</option>
				<?php 
				foreach($id_proof_types as $id_proof_type){
					echo "<option value='".$id_proof_type->id_proof_type_id."'";
					if($id_proof_type->id_proof_type_id==$patient->id_proof_type_id) echo " selected ";
					echo ">".$id_proof_type->id_proof_type."</option>";
				}
				?>
				</select>
                                <?php }else {
                                    foreach($id_proof_types as $id_proof_type){
                                        if($id_proof_type->id_proof_type_id==$patient->id_proof_type_id){
                                            echo "<input type='text' id='id_proof_type' class='form-control' value='$id_proof_type->id_proof_type' disabled/>";
                                            echo "<input type='hidden' name='id_proof_type' id='id_proof_type' class='form-control' value='$id_proof_type->id_proof_type_id'/>";
                                        }
                                    }
                                }?>
			</div>
			<div class="col-md-4 col-xs-6">
				<label class="control-label">Id Proof No</label>
				<input type="text" name="id_proof_no" id="id_proof_no" class="form-control" value="<?php if($patient) echo $patient->id_proof_number;?>" <?php if($f->edit==1 && empty($patient->id_proof_type_id)) echo ''; else echo ' readonly'; ?>/>				
			</div>
			<div class="col-md-4 col-xs-6">
				<label class="control-label">Occupation</label>
                                <?php if($f->edit==1 && empty($patient->occupation_id)){?>
				<select name="occupation" class="form-control">
				<option value="">--Select--</option>
				<?php 
				foreach($occupations as $occupation){
					echo "<option value='".$occupation->occupation_id."'";
					if($patient) if($occupation->occupation_id==$patient->occupation_id) echo " selected ";
					echo ">".$occupation->occupation."</option>";
				}
				?>
				</select>
                                <?php } else { 
                                    foreach($occupations as $occupation){
                                        if($occupation->occupation_id==$patient->occupation_id){
                                            echo "<input type='text' id='occupation' class='form-control' value='$occupation->occupation' disabled/>";
                                            echo "<input type='hidden' name='occupation' id='occupation_id' class='form-control' value='$occupation->occupation_id'/>";
                                        }
                                    }
                                     } ?>
			</div>
			</div>
                <div class="row alt">
                    <div class="col-md-4 col-xs-6">
                        <label class="control-label">Education Level</label>
                        <input type="text" name="education_level" id="education_level" class="form-control" value="<?php if($patient) echo $patient->education_level;?>" <?php if($f->edit==1 && empty($patient->education_level)) echo ''; else echo ' readonly'; ?>/>
                    </div>
                    <div class="col-md-4 col-xs-6">
                        <label class="control-label">Edu. Qualification</label>
                        <input type="text" name="education_qualification" id="education_qualification" class="form-control" value="<?php if($patient) echo $patient->education_qualification;?>" <?php if($f->edit==1 && empty($patient->education_qualification)) echo ''; else echo ' readonly'; ?>/>
                    </div>
                    <div class="col-md-4 col-xs-6">
                        <label class="control-label">Identification Marks</label>
                        <input type="text" name="identification_marks" id="identification_marks" class="form-control" value="<?php if($patient) echo $patient->identification_marks;?>" <?php if($f->edit==1 && empty($patient->identification_marks)) echo ''; else echo ' readonly'; ?>/>
                    </div>
                </div>
                <div class="row alt">                    
                    <div class="col-md-4 col-xs-6">
                        <label class="control-label">Blood Group</label>
                        <?php if($f->edit==1  && empty($patient->blood_group)){ ?>
					<label class="control-label">Blood Group</label>
					<select name="blood_group" class="form-control">
						<option value="">--Select--</option> 
						<option value="A+" <?php if($patient->blood_group == "A+") echo " selected ";?>>A+</option>
						<option value="A-" <?php if($patient->blood_group == "A-") echo " selected ";?>>A-</option>
						<option value="B+" <?php if($patient->blood_group == "B+") echo " selected ";?>>B+</option>
						<option value="B-" <?php if($patient->blood_group == "B-") echo " selected ";?>>B-</option>
						<option value="AB+" <?php if($patient->blood_group == "AB+") echo " selected ";?>>AB+</option>
						<option value="AB-" <?php if($patient->blood_group == "AB-") echo " selected ";?>>AB-</option>
						<option value="O+" <?php if($patient->blood_group == "O+") echo " selected ";?>>O+</option>
						<option value="O-" <?php if($patient->blood_group == "O-") echo " selected ";?>>O-</option>
					</select>
                        <?php } else {?>
                            <input type="text" name="blood_group" id="blood_group" class="form-control" value="<?php if($patient) echo $patient->blood_group;?>" readonly/>
                        <?php } ?>
                    </div>
                </div>
                </div>
                <?php if(!(file_exists("assets/images/patients/".$patient->patient_id.".jpg"))){ ?>
               <div class="row alt">
                <div class="col-md-12">
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
                <?php } ?>
                </div>
		<?php 
				break;
				 }}?>
		
              <?php 
                    foreach($functions as $f){
                        if($f->user_function == "patient_visit"){
                            ?>
                             <div role="tabpanel" class="tab-pane" id="patient_visit">
                                 <div data-patient-quick-info></div>
                                 <div class="row alt">
                              <div class="col-md-4 col-xs-6">
				<label class="control-label">Department<span class="mandatory" >*</span></label>
                                <?php if($f->edit==1 && empty($patient->department_id)){ ?>
				<select name="department" class="form-control department" id="department">
				<option value="">--Select--</option>
				<?php 
				foreach($all_departments as $department){
					echo "<option value='".$department->department_id."'";
						if($department->department_id==$patient->department_id) echo " selected ";
					echo ">".$department->department."</option>";
				}
				?>
				</select>
                                <?php 
                                    }else{
                                    foreach($all_departments as $department){
                                        if($department->department_id==$patient->department_id){
                                            echo "<input type='text' id='department' class='form-control' value='$department->department' disabled/>";
                                            echo "<input type='text' name='department' id='department' class='form-control sr-only' readonly value='$department->department_id'/>";
                                        }
                                    }
                                }
                                ?>
                            </div>
                                 
                            <div class="col-md-4 col-xs-6">
				<label class="control-label">Unit</label>
                                <?php if($f->edit==1 && empty($patient->unit_id)){ ?>
				<select name="unit" id="unit" class="form-control unit">
				<option value="">--Select--</option>
				<?php 
				foreach($units as $unit){
					echo "<option value='".$unit->unit_id."' class='".$unit->department_id."'";
					if($unit->unit_id==$patient->unit_id) echo " selected ";
					echo ">".$unit->unit_name."</option>";
				}
				?>
				</select>
                                <?php 
                                }else{
                                    foreach($units as $unit){
                                        if($unit->unit_id==$patient->unit_id){
                                            echo "<input type='text' id='unit_id' class='form-control' value='$unit->unit_name' disabled/>";
                                            echo "<input type='hidden' name='unit' id='unit_id' class='form-control' value='$unit->unit_id'/>";
                                        }
                                    }
                                }
                                ?>
			</div>
                                     <div class="col-md-4 col-xs-6">
				<label class="control-label">Area</label>
                                <?php if($f->edit==1 && empty($patient->area_id)){ ?>
				<select name="area" id="area" class="form-control area">
				<option value="">--Select--</option>
				<?php 
				foreach($areas as $area){
					echo "<option value='".$area->area_id."' class='".$area->department_id."'";
					if($area->area_id==$patient->area_id) echo " selected ";
					echo ">".$area->area_name."</option>";
				}
				?>
				</select>
                                <?php 
                                }else{
                                    foreach($areas as $area){
                                        if($area->area_id==$patient->area_id){
                                            echo "<input type='text' id='area_id' class='form-control' value='$area->area_name' disabled/>";
                                            echo "<input type='hidden' name='area' id='area_id' class='form-control' value='$area->area_id'/>";
                                        }
                                    }
                                }
                                ?>
                                </div>
                                 </div>
			<div class="row alt">
                            <div class="col-md-4 col-xs-6">
                                <label class="control-label">Visit Name</label>
                                <?php if($f->edit==1 && empty($patient->visit_name_id)){ ?>
                                <select name="visit_name_id" id="visit_name_id" class="form-control visit_name">
                                    <option value="">--Select--</option>
                                    <?php 
                                    foreach($visit_names as $visit_name){
                                        echo "<option value='".$visit_name->visit_name_id."' class='".$visit_name->visit_name_id."'";
					if($visit_name->visit_name_id==$patient->visit_name_id) echo " selected ";
					echo ">".$visit_name->visit_name."</option>";
                                    }
                                    ?>
                                </select>
                                <?php 
                                }else{
                                    foreach($visit_names as $visit_name){
                                        if($visit_name->visit_name_id==$patient->visit_name_id){
                                            echo "<input type='text' id='visit_name' class='form-control' value='$visit_name->visit_name' disabled/>";
                                            echo "<input type='text' name='visit_name_id' id='visit_name' class='form-control sr-only' value='$patient->visit_name_id'/>";
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <div class="col-md-4 col-xs-6">
                                <label class="control-label">Doctor</label>
								
                                <?php if($f->edit==1 && empty($patient->doctor_id)){ ?>
                      <!--          <select name="doctor_id" id="doctor_id" class="form-control doctor">
                                    <option value="">--Select--</option>
                                    <?php 
                                    foreach($doctors as $doctor){
                                        echo "<option value='".$doctor->staff_id."' class='".$doctor->staff_id."'";
					if($doctor->staff_id==$patient->doctor_id) echo " selected ";
					echo ">".$doctor->first_name." ".$doctor->last_name."</option>";
                                    }
                                    ?>
                                </select> -->
                                <?php 
                                }else{
                                    foreach($doctors as $doctor){
                                        if($doctor->staff_id==$patient->doctor_id){
                                            echo "<input type='text' id='doctor_id' class='form-control' value='".$doctor->first_name." ".$doctor->last_name."' disabled/>";
                                            echo "<input type='hidden' name='doctor_id' id='doctor_id' class='form-control' value='$doctor->staff_id'/>";
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <div class="col-md-4 col-xs-6">
                                <label class="control-label">Nurse</label>
                                <input type="text" name="nurse" class="form-control" value="<?php if($patient) echo $patient->nurse;?>" <?php if($f->edit==1 && empty($patient->nurse)) echo ''; else echo ' readonly'; ?>/>
                            </div>
                        </div>
                                 <div class="row alt">
                                     <div class="col-md-4 col-xs-6">
                                         <label class="control-label">Insurance Case: </label>
                                         <input type="radio" name="insurance_case" class="form-control" value="1" <?php if($patient){ if($patient->insurance_case=='1') echo "checked";};?> <?php if($f->edit==1 && empty($patient->insurance_case)) echo ''; else echo ' readonly'; ?>/>Yes
                                         <input type="radio" name="insurance_case" class="form-control" value="0" <?php if($patient){ if($patient->insurance_case=='0') echo "checked";};?> <?php if($f->edit==1 && empty($patient->insurance_case)) echo ''; else echo ' readonly'; ?>/>No
                                     </div>
                                     <div class="col-md-4 col-xs-6">
                                         <label class="control-label">Insurance ID</label>
                                         <input type="text" name="insurance_id" id="insurance_id" class="form-control" value="<?php if($patient) echo $patient->insurance_id;?>" <?php if($f->edit==1 && empty($patient->insurance_id)) echo ''; else echo ' readonly'; ?>/>
                                     </div>
                                     <div class="col-md-4 col-xs-6">
                                         <label class="control-label">Insurance Number</label>
                                         <input type="text" name="insurance_no" id="insurance_no" class="form-control" value="<?php if($patient) echo $patient->insurance_no;?>" <?php if($f->edit==1 && empty($patient->insurance_no)) echo ''; else echo ' readonly'; ?>/>
                                     </div>
                                 </div>
                                 <div class="row alt">                                     
                                     <div class="col-md-4 col-xs-6">
                                         <label class="control-label">Arrival Mode</label>
                                         <?php if($f->edit==1 && empty($patient->arrival_mode)){?>
                                  <!--       <select name="arrival_mode" id="arrival_mode" class="form-control arrival_mode">
                                            <option value="">--Select--</option>
                                            <?php 
                                            foreach($arrival_modes as $arrival_mode){
                                                echo "<option value='".$arrival_mode->arrival_mode."' class='".$arrival_mode->arrival_mode."'";
                                                if($arrival_mode->arrival_mode==$patient->arrival_mode) echo " selected ";
                                                echo ">".$arrival_mode->arrival_mode."</option>";
                                            }
                                            ?>
                                        </select> -->
                                         <?php 
                                            }else{
                                                foreach($arrival_modes as $arrival_mode){
                                                    if($arrival_mode->arrival_mode==$patient->arrival_mode){
                                                        echo "<input type='text' id='arrival_mode' class='form-control' value='$arrival_mode->arrival_mode' disabled/>";
                                                        echo "<input type='hidden' name='arrival_mode' id='arrival_mode' class='form-control' value='$arrival_mode->arrival_mode'/>";
                                                    }
                                                }
                                            }
                                            ?>
                                     </div>                                     
                                     <div class="col-md-8 col-xs-6">
                                        <label class="control-label">Referral Hospital</label>
                                        <?php if($f->edit==1 && empty($patient->refereal_hospital_id)){ ?>
                                        <select name="refereal_hospital_id" id="refereal_hospital_id" class="form-control refereal_hospital_id">
                                            <option value="">--Select--</option>
                                            <?php 
                                            foreach($hospitals as $hospital){
                                                echo "<option value='".$hospital->hospital_id."' class='".$hospital->hospital_id."'";
                                                if($hospital->hospital_id==$patient->refereal_hospital_id) echo " selected ";
                                                echo ">".$hospital->hospital."</option>";
                                            }
                                            ?>
                                        </select>
                                        <?php 
                                            }else{
                                                foreach($hospitals as $hospital){
                                                    if($hospital->hospital_id==$patient->refereal_hospital_id){
                                                        echo "<input type='text' id='hospital_id' class='form-control' value='$hospital->hospital' disabled/>";
                                                        echo "<input type='hidden' name='refereal_hospital_id' id='hospital_id' class='form-control' value='$hospital->hospital_id'/>";
                                                    }
                                                }
                                            }
                                            ?>
                                     </div>                                     
                                 </div>
                                 <div class="row alt">
                                     &nbsp;
                                 </div>
                                 <div class="row">
                                 <!--Patient transfers-->
                                 <div class="col-md-12 col-xs-12">
                                     <table class="table table-striped table-bordered">
                                         <thead>
                                            <th colspan="4">Patient Transfer Information</th>
                                         </thead>
                                         <tr>
                                             <td><b>Department</b></td>
                                             <td><b>Area</b></td>
                                             <td><b>Transfer Date & Time</b></td>
                                         </tr>
                                         <?php
                                            if(isset($transfers) && $transfers!=false){
                                                foreach($transfers as $transfer){
                                                    ?>
                                         <tr>
                                         <td>
                                             <?php 
                                             foreach($all_departments as $department){ 
                                                 if($department->department_id == $transfer->department_id){
                                                    echo $department->department;
                                                    break;
                                                 }
                                             }?>
                                         </td>            
                                         <td>
                                             <?php 
                                             foreach($areas as $area){ 
                                                 if($area->area_id == $transfer->area_id){
                                                    echo $area->area_name;
                                                    break;
                                                 }
                                             }
                                             ?>
                                         </td>
                                         <td>
                                            <?php echo date("d-M-Y",strtotime($transfer->transfer_date)); ?>
                                             <?php echo date("g:iA",strtotime($transfer->transfer_time)); ?>
                                         </td>
                                                    <?php
                                                }
                                            }
                                         ?>
                                         </tr>
                                         <tr>
                                         <td>
                                             <select name="transfer_department" class="form-control transfer_department" id="transfer_department">
                                                <option value="">--Select--</option>
                                                <?php 
                                                    foreach($all_departments as $department){
                                                    echo "<option value='".$department->department_id."'>".$department->department."</option>";
                                                }
                                                ?>
                                            </select>
                                         </td>
                                         <td>
                                             <select name="transfer_area" id="transfer_area" class="form-control transfer_area">
                                            <option value="">--Select--</option>
                                            <?php 
                                            foreach($areas as $area){
                                                    echo "<option value='".$area->area_id."' class='".$area->department_id."'>".$area->area_name."</option>";
                                            }
                                            ?>
                                            </select>
                                         </td>
                                         <td>
                                         <input type="datetime-local" name="transfer_date" class="form-control transfer_date" value="<?php echo date("d-M-Y g:iA");?>" id="transfer_date" />
                                   
                                         </td>
                                         </tr>
                                     </table>
                                 </div>
                                 </div>
                             </div>
                            <?php
                            break;
                        }
                    }
              ?>
              <?php 
                foreach($functions as $f){
                    if($f->user_function== "Patient Transport"){
                        ?>
              <div role="tabpanel" class="tab-pane" id="patient_transport">
                  <div data-patient-quick-info></div>
                  <div class="row alt">
					
					 <!--Patient transfers-->
					 <div class="col-md-12 col-xs-12">
						 <table class="table table-striped table-bordered">
							 <thead>
								<th colspan="4">Patient Transport Information</th>
							 </thead>
							 <tr>
								 <td><b>From Area</b></td>
								 <td><b>To Area</b></td>
								 <td><b>Transported By</b></td>
								 <td><b>Transport Start Date & Time</b></td>
								 <td><b>Transport End Date & Time</b></td>
							 </tr>
							 <?php
								if(isset($transport) && $transport!=false){
									foreach($transport as $t){
										?>
							 <tr>
							 <td>
								 <?php 
										echo $t->from_area;
								 ?>
							 </td>            
							 <td>
								 <?php 
										echo $t->to_area;
								 ?>
							 </td>      
							 <td>
								 <?php 
										echo $t->transported_by;
								 ?>
							 </td>
							 <td>
								<?php echo date("d-M-Y",strtotime($t->start_date_time)); ?>
								 <?php echo date("g:iA",strtotime($t->start_date_time)); ?>
							 </td>
							 <td>
								<?php echo date("d-M-Y",strtotime($t->end_date_time)); ?>
								 <?php echo date("g:iA",strtotime($t->end_date_time)); ?>
							 </td>
							 </tr>
										<?php
									}
								}
							 ?>
						 </table>
					 </div>
				</div>
              </div>              
                        <?php
                        break;
                    }
                }
              ?>
              <?php 
                foreach($functions as $f){
                    if($f->user_function== "mlc"){
                        ?>
              <div role="tabpanel" class="tab-pane" id="mlc">
                  <div data-patient-quick-info></div>
                  <div class="row alt">
                        <div class="col-md-4 col-xs-6">
				<label class="control-label">MLC</label>
					<?php if($patient->mlc_number!='not_mlc'){ ?> 
					<?php if(!empty($patient->mlc_number_manual)){ ?>
						<label>: Yes</label>
					<?php  } else {?>
				<label class="control-label"><input type="radio" value="1" class="mlc" name="mlc_radio" id="mlc_radio" />Yes</label>
				<label class="control-label"><input type="radio" value="-1" class="mlc" name="mlc_radio" id="mlc_radio"/>No</label>
					<?php if($patient->mlc!=0) { ?><input type="hidden" value=<?php echo $patient->mlc; ?> name="mlc_radio" /> <?php } } }else{?> 
						<label class="control-label">: NOT MLC </label>
					<?php }  ?>
			
			</div>
                      <div class="col-md-4 col-xs-6">
                          <label class="control-label">MLC Number- System</label>
						  <?php if($patient->mlc_number!='not_mlc'){ ?> 
                          <input name="mlc_number" class="form-control mlc" id="mlc_number" value="<?php if(!empty($patient->mlc_number)) echo $patient->mlc_number; else echo ""?>" type="text" readonly/>
						  <?php } ?>                       </div>
                        <div class="col-md-4 col-xs-6">
                                <label class="control-label">MLC Number Manual</label>
								<?php if($patient->mlc_number!='not_mlc'){ ?> 
								<?php if(!empty($patient->mlc_number_manual)) { ?>
									<label><?php echo $patient->mlc_number_manual; ?></label>
								<?php } else {?>
                                <input type="text" name="mlc_number_manual" class="form-control mlc" id="mlc_number_manual" />
								<?php } }?>
                        </div>
                      
		</div>
                  <div class="row alt">
                      <div class="col-md-4 col-xs-6">
                                <label class="control-label">PS Name</label>
								<?php if($patient->mlc_number!='not_mlc'){ ?> 
								<?php if(!empty($patient->ps_name)) {?> 
									<label><?php echo ': '.$patient->ps_name; ?> </label>
								<?php } else { ?>
                                <input type="text" name="ps_name" class="form-control mlc" id="ps_name"/>
								<?php } ?>
								<?php } ?>
                        </div>
                      
                      <div class="col-md-4 col-xs-6">
                          <label class="control-label">Police Intimation</label>
						  <?php if($patient->mlc_number!='not_mlc'){ ?> 
						  <?php if(!empty($patient->police_intimation) && $patient->police_intimation == 1){ ?> 
							<label>: Yes</label>
						  <?php } else {?>
							<label class="control-label"><input type="radio" value="1" class="mlc" name="police_intimation" id="police_intimation" />Yes</label>
							<label class="control-label"><input type="radio" value="-1" class="mlc" name="police_intimation" id="police_intimation"/>No</label>
						  <?php } }?>
                      </div>
                      <div class="col-md-4 col-xs-6">
                          <label class="control-label">PC Number</label>
						  <?php if($patient->mlc_number!='not_mlc'){ ?>
						  <?php if(!empty($patient->pc_number)) {?>
							<label> <?php echo ': '.$patient->pc_number; ?></label>
						  <?php } else { ?>
                          <input type="text" name="pc_number" class="form-control mlc" id="pc_number" />
						  <?php } } ?>
                      </div>
                  </div>
                  <div class="row alt">
                      <div class="col-md-4 col-xs-6">
                          <label class="control-label">Brought By</label>
						  <?php if($patient->mlc_number!='not_mlc'){ ?> 
							<?php if(!empty($patient->brought_by)) {?>
							<label><?php echo ': '.$patient->brought_by; ?></label>
						  <?php } else { ?>
                          <input type="text" name="brought_by" class="form-control mlc" id="brought_by" />
						  <?php } } ?>
                      </div>
                      <div class="col-md-4 col-xs-6">
                          <label class="control-label">Declaration Required</label>
						  <?php if($patient->mlc_number!='not_mlc'){ ?> 
							<?php if(!empty($patient->declaration_required)){ ?> 
							<label><?php if($patient->declaration_required == 1) echo ': '.'Yes'; else echo ': '.'No'; ?></label>
						  <?php } else {?>
							<label class="control-label"><input type="radio" value="1" class="mlc" name="declaration_required" id="declaration_required" />Yes</label>
							<label class="control-label"><input type="radio" value="-1" class="mlc" name="declaration_required" id="declaration_required"/>No</label>
						  <?php } } ?>
                      </div>                                            
                  </div>
              </div>              
					<?php 
                        break;
                    }
                }
              ?>
              <?php 
                foreach($functions as $f){
                    if($f->user_function== "obg"){
                        ?>
              <div role="tabpanel" class="tab-pane" id="obg">
                  <div data-patient-quick-info></div>
                  <div class="row alt">
                            <!--OBG-->
                                 <div class="col-md-12 col-xs-12">
                                     <table class="table table-striped table-bordered">
                                         <thead>
                                            <th colspan="5">Summary</th>
                                         </thead>
                                         <tr>
                                             <td><b>Gravida</b></td>
                                             <td><b>Para</b></td>
                                             <td><b>Abortions</b></td>
                                             <td><b>Live Births</b></td>
                                             <td><b>Living Children</b></td>
                                         </tr>
                                         
                                         <tr>
                                         <td>
                                         </td>            
                                         <td>                                             
                                         </td>
                                         <td>                                            
                                         </td>
                                         <td>                                             
                                         </td>
                                         <td>                                             
                                         </td>
                                         
                                                 
                                         </tr>
                                         
                                     </table>
                                 </div>    
                  </div>
                  <div class="row alt">
                      <!--OBG, table transpose has been applied on the table class obstetric_history, check in style sheets. -->
                                 <div class="col-md-12 col-xs-12">
                                     <table class="table table-striped table-bordered obstetric_history_table" id="obstetric_history">
                                         <thead>
                                            <th colspan="17">Table (obstetric_history)</th>
                                         </thead>
                                         <tr>
                                             <td><b>Conception ( pregnancy_number )</b></td>
                                             <td><b>conception_type (1,2,3,4)</b></td>
                                             <td><b>Delivery(1) / Abortion(0) - add field</b></td>
                                             <td><b>LMP (date)</b></td>
                                             <td><b>EDD (date)</b></td>
                                             <td><b>Live Birth (1) / Still Birth (0) - change field to delivery_outcome</b></td>
                                             <td><b>Booked (1) / Unbooked (0)</b></td>
                                             <td><b>Delivery Mode (lov)</b></td>
                                             <td><b>Date of Birth</b></td>
                                             <td><b>Girl (1) / Boy (0) / Other ( 2)</b></td>
                                             <td><b>Birth Weight</b></td>
                                             <td><b>APGAR</b></td>
                                             <td><b>NICU Admission Y-1, N-0</b></td>NICU Admission reason
                                             <td><b>NICU Admission reason</b></td>
                                             <td><b>Alive (1) / Dead (0) - add field living_status</b></td>
                                             <td><b>Date of Death</b></td>
                                             <td><b>Cause of Death</b></td>
                                         </tr>
                                         <?php if(isset($obstetric_history)){ 
                                             foreach($obstetric_history as $history){ ?>
                                         <tr>
                                         <td>
                                             <?php echo $history->pregnancy_number ; ?>
                                         </td>
                                         <td>
                                             <?php echo $history->conception_type ; ?>
                                         </td>                                         
                                         <td>
                                             <?php if($history->delivered == '1') echo "Delivered"; else echo "Abortion"; ?>
                                         </td>
                                         <td>
                                             <?php echo Date('d-M-Y',strtotime($history->imp_date)); ?>
                                         </td>
                                         <td>
                                             <?php echo Date('d-M-Y',strtotime($history->edd_date)); ?>
                                         </td>
                                         <td>
                                             <?php echo $history->delivery_outcome ; ?>
                                         </td>
                                         <td>
                                             <?php if($history->booked == '1') echo "Booked"; else echo "Unbooked"; ?>
                                         </td>
                                         <td>
                                             <?php echo $history->delivery_mode ; ?>
                                         </td>
                                         <td>
                                             <?php echo Date('d-M-Y',strtotime($history->date_of_birth)); ?> 
                                         </td>
                                         <td>
                                             <?php if($history->gender == '1') echo "Female"; else if($history->gender =='2') echo "Male"; else echo "Other";?>
                                         </td>
                                         <td>
                                             <?php echo $history->weight_at_birth ; ?>
                                         </td>
                                         <td>
                                             <?php echo $history->apgar ; ?>
                                         </td>
                                         <td>
                                             <?php if($history->nicu_admission == '1') echo "Yes"; else echo "No"; ?>
                                         </td>
                                         <td>
                                             <?php echo $history->nicu_admission_reason; ?>
                                         </td>
                                         <td>
                                             <?php if($history->alive == '1') echo "Alive"; else echo "Dead"; ?> 
                                         </td>
                                         <td>
                                             <?php echo Date('d-M-Y',strtotime($history->date_of_death)); ?> 
                                         </td>
                                         <td>
                                             <?php echo $history->cause_of_death; ?>
                                         </td>   
                                         </tr>
                                         <?php }                                         
                                         } ?>
                                         <?php if($f->edit==1){ ?>
                                         <tr>
                                         <td>
                                             <input type="text" name="pregnancy_number[]" class="form-control pregnancy_number" id="pregnancy_number" placeholder="Pregnancy Number" />
                                         </td>
                                         <td>
                                             <input type="text" name="conception_type[]" class="form-control conception_type" id="conception_type" placeholder="Conception Type" />                                             
                                         </td>                                                     
                                         <td>
                                             <input type="radio" name="delivered[]" class="form-control delivered" value="1" id="delivered" />Delivered
                                             <input type="radio" name="delivered[]" class="form-control delivered" value="-1" id="delivered" />Abortion                                             
                                         </td>
                                         <td>
                                             <input type="text" name="imp_date[]" class="form-control imp_date" id="imp_date" style="width:150px" />                                             
                                         </td>
                                         <td>
                                             <input type="text" name="edd_date[]" class="form-control edd_date" id="edd_date" style="width:150px" />                                             
                                         </td>
                                         <td>
                                             <input type="text" name="delivery_outcome[]" class="form-control delivery_outcome" id="delivery_outcome" placeholder="Delivery Outcome" />                                             
                                         </td>
                                         <td>
                                             <input type="radio" name="booked[]" class="form-control booked" value="1" id="booked" />Delivered
                                             <input type="radio" name="booked[]" class="form-control booked" value="-1" id="booked" />Abortion                                             
                                         </td>
                                         <td>
                                             <input type="text" name="delivery_mode[]" class="form-control delivery_mode" id="delivery_mode" placeholder="Delivery Mode" />
                                         </td>
                                         <td>
                                             <input type="text" name="date_of_birth" class="form-control date_of_birth" id="date_of_birth" style="width:150px" />                                             
                                         </td>
                                         <td>
                                             <input type="radio" name="gender[]" class="form-control gender" value="2" id="gender" />Male
                                             <input type="radio" name="gender[]" class="form-control gender" value="1" id="gender" />Female
                                             <input type="radio" name="gender[]" class="form-control gender" value="3" id="gender" />Other                                             
                                         </td>
                                         <td>
                                             <input type="text" name="weight_at_birth[]" class="form-control weight_at_birth" id="weight_at_birth" placeholder="Weight at birth" />                                             
                                         </td>
                                         <td>
                                             <input type="text" name="apgar[]" class="form-control apgar" id="apgar" placeholder="APGR" />                                             
                                         </td>
                                         <td>
                                             <input type="radio" name="nicu_admission[]" class="form-control booked" value="1" id="booked" />Yes
                                             <input type="radio" name="nicu_admission[]" class="form-control booked" value="-1" id="booked" />No                                             
                                         </td>
                                         <td>
                                             <input type="text" name="nicu_admission_reason[]" class="form-control nicu_admission_reason" id="nicu_admission_reason" placeholder="NICU Admission Reason" />                                                                                          
                                         </td>
                                         <td>
                                             <input type="radio" name="alive[]" class="form-control alive" value="1" id="alive" />Alive
                                             <input type="radio" name="alive[]" class="form-control alive" value="-1" id="alive" />Dead                                             
                                         </td>
                                         <td>
                                             <input type="text" name="date_of_death" class="form-control date_of_death" id="date_of_death" style="width:150px" />                                             
                                         </td>
                                         <td>
                                             <input type="text" name="cause_of_death[]" class="form-control cause_of_death" id="cause_of_death" placeholder="Cause of death" />                                             
                                         </td>   
                                         </tr>
                                         <?php } ?>
                                     </table>
                                     <?php if($f->edit==1) { ?>
                                     <div class="btn-group" role="group">
                                         <input type="hidden" name="child_count" id="child_count" value="1" />
                                        <button type="button" id='add_obstetric_history'>Add</button>
                                        <button type="button" id='remove_obstetric_history'>Remove Last</button>
                                    </div>
                                     <?php } ?>
                                 </div>
		</div>
                  <div class="row alt">
                                            
                  </div>
              </div>              
                        <?php
                        break;
                    }
                }
              ?>
		<?php 
			foreach($functions as $f){ 
				if($f->user_function == "Clinical" && ($f->add==1 || $f->edit==1)) { ?>
		<div role="tabpanel" class="tab-pane" id="clinical">
            <div data-patient-quick-info></div>
            
            <div data-patient-clinical-details data-source="patient" data-edit-privilege="<?php echo $f->edit==1; ?>" data-readonly-if-not-empty="true"></div>

			<div class="row alt">
				<div class="col-md-12 col-xs-12">
					<label class="control-label">
						Symptoms
					</label>
					<textarea name="presenting_complaints" cols="60" class="form-control" placeholder="Symptoms/ Presenting Complaints" <?php if($f->edit==1  && empty($patient->presenting_complaints)) echo ''; else echo ' readonly'; ?> ><?php echo $patient->presenting_complaints;?></textarea>
				</div>
			</div>
			<div class="row alt">
				<div class="col-md-12 col-xs-12">
					<label class="control-label">
						Past History
					</label>
					<textarea name="past_history" cols="60" class="form-control" placeholder="Past History" <?php if($f->edit==1  && empty($patient->past_history)) echo ''; else echo ' readonly'; ?> ><?php echo $patient->past_history;?></textarea>
				</div>
			</div>
			<div class="row alt">
				<div class="col-md-12 col-xs-12">
					<label class="control-label">
						Family History
					</label>
					<textarea name="family_history" cols="60" class="form-control" placeholder="Family History" <?php if($f->edit==1  && empty($patient->family_history)) echo ''; else echo ' readonly'; ?> ><?php echo $patient->family_history;?></textarea>
				</div>
			</div>
			<div class="row alt">
				<div class="col-md-12 col-xs-12">
					<label class="control-label">
						Clinical Findings
					</label>
					<textarea name="clinical_findings" cols="60" class="form-control" placeholder="Clinical Findings" <?php if($f->edit==1 && empty($patient->clinical_findings)) echo ''; else echo ' readonly'; ?> ><?php echo $patient->clinical_findings;?></textarea>
				</div>
			</div>
			<div class="row alt">
				<div class="col-md-12 col-xs-12">
					<label class="control-label">
						CVS<img src="<?php echo base_url();?>assets/images/information-icon.png" class="prescription_table_heading_info_icons" title="Cardio Vascular System" data-toggle="tooltip"/>
					</label>
					<textarea name="cvs" cols="60" class="form-control" placeholder="Cardio Vascular System" <?php if($f->edit==1 && empty($patient->cvs)) echo ''; else echo ' readonly'; ?> ><?php echo $patient->cvs;?></textarea>
				</div>
			</div>
			<div class="row alt">
				<div class="col-md-12 col-xs-12">
					<label class="control-label">
						RS<img src="<?php echo base_url();?>assets/images/information-icon.png" class="prescription_table_heading_info_icons" title="Respiratory System" data-toggle="tooltip"/>
					</label>
					<textarea name="rs" cols="40" class="form-control" placeholder="Respiratory System" <?php if($f->edit==1  && empty($patient->rs)) echo ''; else echo ' readonly'; ?> ><?php echo $patient->rs;?></textarea>
				</div>
			</div>
			<div class="row alt">
				<div class="col-md-12 col-xs-12">
					<label class="control-label">
						PA<img src="<?php echo base_url();?>assets/images/information-icon.png" class="prescription_table_heading_info_icons" title="Per Abdomen" data-toggle="tooltip"/>
					</label>
					<textarea name="pa" cols="60" class="form-control" placeholder="Per Abdomen" <?php if($f->edit==1 && empty($patient->pa)) echo ''; else echo ' readonly'; ?> ><?php echo $patient->pa;?></textarea>
				</div>
			</div>
			<div class="row alt">
				<div class="col-md-12 col-xs-12">
					<label class="control-label">
						CNS<img src="<?php echo base_url();?>assets/images/information-icon.png" class="prescription_table_heading_info_icons" title="Central Nervous System" data-toggle="tooltip"/>
					</label>
					<textarea name="cns" cols="40" class="form-control" placeholder="Central Nervous System" <?php if($f->edit==1 && empty($patient->cns)) echo ''; else echo ' readonly'; ?> ><?php echo $patient->cns;?></textarea>
				</div>
			</div>
			<div class="row alt">
					<div class="col-md-12 col-xs-12">
						<?php 
							if(isset($visit_notes) && !!$visit_notes){ ?>
						
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th colspan="4">Clinical Notes</th>
								</tr>
								<tr>
									<th>#</th>
									<th>Date</th>
									<th>Note</th>
									<th>Added by</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$i=1;
							 foreach($visit_notes as $note){ ?>
								<tr>
									<td><?php echo $i++; ?></td>
									<td><?php if($note->note_time!=0) echo date("d-M-Y g:iA",strtotime($note->note_time)); ?></td>
									<td><?php echo $note->clinical_note;?></td>
									<td><?php echo $note->first_name." ".$note->last_name;?></td>
								</tr>
								<?php  } ?>
							</tbody>
						</table>
						<?php
							}
						?>
						<table class="table table-bordered table-striped clinical-notes-table">
							<thead>
								<tr>
									<th colspan="4">Add Clinical Notes</th>
								</tr>
							</thead>
							<tbody class="daily_notes dynamic-row">
								<tr>
									<td><textarea rows="4" cols="60" name="clinical_note[]"  class="form-control"></textarea></td>
									<td><span class="note_date_label">Select Date and Time to save the note</span> <br /> <input type="datetime-local" class="daily_notes_date form-control" name="note_date[]" /> </td>
									<td>
										<button  type="button" class="btn btn-sm btn-primary add_daily_note">Add</button>
										<button  type="button" class="btn btn-sm btn-danger remove_daily_note">X</button>
									</td>
								</tr>
							</tbody>
						</table>
				</div>
				<script>
					$(function(){
						var toggleAddRemoveButton = function(parent){
							$(parent).find(".add_daily_note").hide();
							$(parent).find(".add_daily_note:first").show();
							$(parent).find(".remove_daily_note").show();
							$(parent).find(".remove_daily_note:first").hide();
						}
						$(document).on('click', ".add_daily_note", function(){
							var row = $(this).parents('tr:eq(0)').clone(false);
							row.find('input,textarea').each(function(){
								$(this).val('').removeClass('error_field');
							});
							row.find('span.error').remove();
							$(this).parents('tbody.daily_notes').append(row);
							toggleAddRemoveButton($('tbody.daily_notes'));
						});
						$(document).on('click', ".remove_daily_note", function(){
							$(this).parents('tr').remove();
							toggleAddRemoveButton($('tbody.daily_notes'));
						});
						toggleAddRemoveButton($('tbody.daily_notes'));
					});
				</script>
			</div>
		</div>
		<?php 
				break;
				 } } ?>
		
		<?php 
			foreach($functions as $f){ 
				if($f->user_function == "View Diagnostics") { ?>
		<div role="tabpanel" class="tab-pane" id="diagnostics">
			<div data-patient-quick-info></div>
			<?php 
			if(isset($tests) && count($tests)>0){ ?>
				<table class="table table-bordered table-striped table-hover" id="table-sort">
				<thead>
					<th style="width:3em">#</th>
					<th style="width:10em">Order ID</th>
					<th style="width:10em">Order Date</th>
					<th style="width:10em">Specimen</th>
					<th style="width:12em">Test</th>
					<th style="width:10em">Value</th>
					<th style="width:5em">Report - Binary</th>
					<th style="width:10em">Report</th>
				</thead>
				<tbody>
					<?php 
					$o=array();
					foreach($tests as $order){
						$o[]=$order->order_id;
					}
					$o=array_unique($o);
					$i=1;
					foreach($o as $ord){	?>
						<?php
						foreach($tests as $order) { 
							if($order->order_id == $ord) { ?>
						<tr <?php if($order->test_status == 2) { ?> onclick="$('#order_<?php echo $ord;?>').submit()" <?php } ?>>
								<td><?php echo $i++;?></td>
								<td>
									<?php echo form_open("diagnostics/view_results",array('role'=>'form','class'=>'form-custom','id'=>'order_'.$order->order_id)); ?>
									<?php echo $order->order_id;?>
									<input type="hidden" class="sr-only" name="order_id" value="<?php echo $order->order_id;?>" />
									</form>
								</td>
								<td>
									<?php echo date("d-M-Y",strtotime($order->order_date_time));?>
								</td>
								<td><?php echo $order->specimen_type;?></td>
								<td>
								<?php
													if($order->test_status==1){
														$label="label-warning"; $status="Completed"; }
													else if($order->test_status == 2){ $label = "label-success"; $status = "Approved"; }
													else if($order->test_status == 0){ $label = "label-default"; $status = "Ordered"; }
													echo '<label class="label '.$label.'" title="'.$status.'">'.$order->test_name."</label><br />";									
									?>
								</td>
								<td>
									<?php if($order->test_status==2 && $order->numeric_result == 1) echo $order->test_result." ".$order->lab_unit; else echo "NA";?>
								</td>
								<td>
									<?php if($order->test_status==2 && $order->binary_result == 1) echo $order->test_result_binary; else echo "NA";?>
								</td>
								<td>
									<?php if($order->test_status==2 && $order->text_result == 1) echo $order->test_result_text; else echo "NA";?>
								</td>
						</tr>
						<?php
						}
						} ?>
					<?php } ?>
				</tbody>
				</table>
				
			<?php } else { ?>
			No tests on the given date.
			<?php } ?>
		</div>
		<?php 
				break;
				 } }?>
		<?php 
			foreach($functions as $f){ 
				if($f->user_function == "Procedures" && ($f->add==1 || $f->edit==1)) { ?>
		<div role="tabpanel" class="tab-pane" id="procedures">
                    <div data-patient-quick-info></div>
			<div class="row alt">
				<div class="col-md-4">
					<label class="control-label">Procedure</label>
				</div>
				<div class="col-md-8">
                                    <?php if($f->edit==1 && empty($patient->procedure_name)){ ?>
					<select name="procedure" class="form-control">
					<option value="" selected>--SELECT--</option>
					<?php foreach($procedures as $procedure){ ?>
						<option value="<?php echo $procedure->procedure_id;?>"><?php echo $procedure->procedure_name;?></option>
					<?php } ?>
					</select>
                                    <?php }else{
                                    foreach($procedures as $procedure){
                                        if($procedure->procedure_id==$patient->procedure_id){
                                            echo "<input type='text' id='procedure_id' class='form-control' value='$procedure->procedure_name' disabled/>";
                                            echo "<input type='hidden' name='procedure' id='procedure_id' class='form-control' value='$procedure->procedure_name'/>";
                                        }
                                    }
                                } ?>
				</div>
			</div>
			<div class="row alt">
				<div class="col-md-4">
					<label class="control-label">Date, Time</label>
				</div>
				<div class="col-md-8">
					<input type="text" class="form-control date" name="procedure_date"  <?php if($f->edit==1 && empty($patient->procedure_date)) echo ''; else echo ' readonly'; ?> />
					<input type="text" class="form-control time" name="procedure_time"  <?php if($f->edit==1 && empty($patient->procedure_time)) echo ''; else echo ' readonly'; ?> />
				</div>
			</div>
			<div class="row alt">
				<div class="col-md-4">
					<label class="control-label">Duration</label>
				</div>
				<div class="col-md-8">
					<input type="text" class="form-control" name="procedure_duration" value=<?php echo '"'.$patient->procedure_duration.'"';?> <?php if($f->edit==1 && empty($patient->procedure_duration)) echo ''; else echo ' readonly'; ?>  />
				</div>
			</div>
			<div class="row alt">
				<div class="col-md-4">
					<label class="control-label">Notes</label>
				</div>
				<div class="col-md-8">
					<textarea type="text" class="form-control" name="procedure_note" value=<?php echo '"'.$patient->procedure_note.'"';?><?php if($f->edit==1 && empty($patient->procedure_note)) echo ''; else echo ' readonly'; ?> ></textarea>
				</div>
			</div>
			<div class="row alt">
				<div class="col-md-4">
					<label class="control-label">Findings</label>
				</div>
				<div class="col-md-8">
					<textarea type="text" class="form-control" name="procedure_findings" value=<?php echo '"'.$patient->procedure_findings.'"';?> <?php if($f->edit==1 && empty($patient->procedure_findings)) echo ''; else echo ' readonly'; ?> ></textarea>
				</div>
			</div>
			<div class="row alt">
				<div class="col-md-4">
					<label class="control-label">Post Procedure Notes</label>
				</div>
				<div class="col-md-8">
					<textarea type="text" class="form-control" name="post_procedure_notes" <?php if($f->edit==1 && empty($patient->post_procedure_notes)) echo ''; else echo ' readonly'; ?> ></textarea>
				</div>
			</div>
			<?php 
			if(isset($tests) && count($tests)>0){ ?>
				<table class="table table-bordered table-striped table-hover" id="table-sort">
				<thead>
					<th style="width:3em">#</th>
					<th style="width:10em">Order ID</th>
					<th style="width:10em">Order Date</th>
					<th style="width:10em">Specimen</th>
					<th style="width:12em">Test</th>
					<th style="width:10em">Value</th>
					<th style="width:5em">Report - Binary</th>
					<th style="width:10em">Report</th>
				</thead>
				<tbody>
					<?php 
					$o=array();
					foreach($tests as $order){
						$o[]=$order->order_id;
					}
					$o=array_unique($o);
					$i=1;
					foreach($o as $ord){	?>
						<?php
						foreach($tests as $order) { 
							if($order->order_id == $ord) { ?>
						<tr <?php if($order->test_status == 2) { ?> onclick="$('#order_<?php echo $ord;?>').submit()" <?php } ?>>
								<td><?php echo $i++;?></td>
								<td>
									<?php echo form_open("diagnostics/view_results",array('role'=>'form','class'=>'form-custom','id'=>'order_'.$order->order_id)); ?>
									<?php echo $order->order_id;?>
									<input type="hidden" class="sr-only" name="order_id" value="<?php echo $order->order_id;?>" />
									</form>
								</td>
								<td>
									<?php echo date("d-M-Y",strtotime($order->order_date_time));?>
								</td>
								<td><?php echo $order->specimen_type;?></td>
								<td>
								<?php
													if($order->test_status==1){
													$label="label-warning"; $status="Completed"; }
													else if($order->test_status == 2){ $label = "label-success"; $status = "Approved"; }
													else if($order->test_status == 0){ $label = "label-default"; $status = "Ordered"; }
													echo '<label class="label '.$label.'" title="'.$status.'">'.$order->test_name."</label><br />";									
								?>
								</td>
								<td>
									<?php if($order->test_status==2 && $order->numeric_result == 1) echo $order->test_result." ".$order->lab_unit; else echo "NA";?>
								</td>
								<td>
									<?php if($order->test_status==2 && $order->binary_result == 1) echo $order->test_result_binary; else echo "NA";?>
								</td>
								<td>
									<?php if($order->test_status==2 && $order->text_result == 1) echo $order->test_result_text; else echo "NA";?>
								</td>
						</tr>
						<?php
						}
						} ?>
					<?php } ?>
				</tbody>
				</table>
				
			<?php } ?>
		</div>
		<?php  
				break;
				} }?>
		<?php 
			foreach($functions as $f){ 
				if($f->user_function == "Prescription" && ($f->add==1 || $f->edit==1)) { ?>
		<div role="tabpanel" class="tab-pane" id="prescription">
                    <div data-patient-quick-info></div>
			<div class="row alt">
			<div class="col-md-12 alt">

					<?php if(count($previous_visits) > 1) { ?>
								<button type="button" class="btn btn-success btn-md" id="retrieve_prescription">Retrieve previous prescription</button> 
								<br />
								<br />
						
					<?php } ?>
					<table class="table table-striped table-bordered" id="prescription_table">
					<thead>
						<tr>
						<th rowspan="3" class="text-center"><img src="<?php echo base_url();?>assets/images/medicines.jpg" class="prescription_table_heading_icons" alt="" />Drug<img src="<?php echo base_url();?>assets/images/syrup.jpg" class="prescription_table_heading_icons" alt="" />
						<a href="<?php echo base_url();?>reports/all_drugs_list_with_availability" style="display: block" target="_blank">[Click to view all the drugs]</a>
						</th>
						<th rowspan="3" class="text-center"><img src="<?php echo base_url();?>assets/images/calendar.jpg" class="prescription_table_heading_icons" alt="Days" />Duration <br /> (in Days)</th>
					<!--	<th rowspan="3" class="text-center">Frequency</th> -->
						<th colspan="6" class="text-center"><img src="<?php echo base_url();?>assets/images/timings.jpg" class="prescription_table_heading_icons"  alt="Timings" />Timings</th>
					<!--	<th rowspan="3" class="text-center">Issued Quantity</th> -->
						</tr>
						<tr>
							<th colspan="2" class="text-center"><img src="<?php echo base_url();?>assets/images/morning.jpg" class="prescription_table_heading_icons" />Morning</th>
							<th colspan="2" class="text-center"><img src="<?php echo base_url();?>assets/images/afternoon.jpg" class="prescription_table_heading_icons" />Afternoon</th>
							<th colspan="2" class="text-center"><img src="<?php echo base_url();?>assets/images/night.jpg" class="prescription_table_heading_icons" />Evening</th>
						</tr>
						<tr>
							<th class="text-center"><span>BF</span><img src="<?php echo base_url();?>assets/images/information-icon.png" class="prescription_table_heading_info_icons" title="Before Food" data-toggle="tooltip"/></th>

							<th class="text-center"><span>AF</span><img src="<?php echo base_url();?>assets/images/information-icon.png" class="prescription_table_heading_info_icons" title="After Food" data-toggle="tooltip"/></th>

							<th class="text-center"><span>BF</span><img src="<?php echo base_url();?>assets/images/information-icon.png" class="prescription_table_heading_info_icons" title="Before Food" data-toggle="tooltip"/></th>

							<th class="text-center"><span>AF</span><img src="<?php echo base_url();?>assets/images/information-icon.png" class="prescription_table_heading_info_icons" title="After Food" data-toggle="tooltip"/></th>

							<th class="text-center"><span>BF</span><img src="<?php echo base_url();?>assets/images/information-icon.png" class="prescription_table_heading_info_icons" title="Before Food" data-toggle="tooltip"/></th>
							
							<th class="text-center"><span>AF</span><img src="<?php echo base_url();?>assets/images/information-icon.png" class="prescription_table_heading_info_icons" title="After Food" data-toggle="tooltip"/></th>
						</tr>
					</thead>
					<tbody>
						<tr class="prescription">
							<td style="width:500px;">
								<select name="drug_0" class="repositories" placeholder="-Enter Generic Drug Name-">
									<option value="">-Enter Generic Drug Name-</option>
								</select>
								<i class="glyphicon glyphicon-pencil"></i>
								<span class="note_tooltip">[Click to Add Note]</span>
								<textarea name="note_0" rows="5" placeholder="Enter note here" style="border: 0px;background: transparent;" hidden></textarea>
							</td>
							<td class="text-center">
								<input type="text" name="duration_0" placeholder="Days" style="width:60px" class="form-control" />
							</td>
						<!--	<td>
								<select name="frequency_0" class="form-control" >
									<?php foreach($prescription_frequency as $freq){ ?>
										
										<option value="<?php echo $freq->frequency;?>"><?php echo $freq->frequency;?></option>
									<?php } ?>
								</select>
							</td> -->
							<td class="text-center">
								<label><input type="checkbox" name="bb_0" value="1"  /></label>
							</td>
							<td class="text-center">
								<label><input type="checkbox" name="ab_0" value="1"  /></label>
							</td>
							<td class="text-center">
								<label><input type="checkbox" name="bl_0" value="1" /></label>
							</td>
							<td class="text-center">
								<label><input type="checkbox" name="al_0" value="1" /></label>
							</td>
							<td class="text-center">
								<label><input type="checkbox" name="bd_0" value="1" /></label>
							</td>
							<td class="text-center">
								<label><input type="checkbox" name="ad_0" value="1" /></label>
								<input type="text" name="prescription[]" class="sr-only" value="0"  />
							</td>
						<!--	<td>
								<input type="text" name="quantity_0" style="width:100px" class="form-control" />
								
							</td> -->
							<td>
								<button type="button" class="btn btn-primary btn-sm" id="prescription_add" >Add</button>
							</td>
						</tr>
					</tbody>
				</table>
				<div style="font-size: 12px;">
					<div style="margin-bottom: 5px;"><i style="color: orange" class="fa fa-bell prescription_warning_i" title="Alert" data-toggle="tooltip"></i><span data-defaults-config="PRESCRIPTIONALERT"></span></div>
					<div><i style="color: red" class="fa fa-bell prescription_warning_i"  title="Mandatory" data-toggle="tooltip"></i><span data-defaults-config="SYMPTOMSALERT"></span></div>
				</div>
			</div>
			</div>
			<div class="row alt">
				<?php if(isset($prescription) && !!$prescription){ ?>
					<table class="table table-bordered table-striped">
					<thead>
						<tr>
						<th rowspan="3" class="text-center"><img src="<?php echo base_url();?>assets/images/medicines.jpg" class="prescription_table_heading_icons" alt="" />Drug<img src="<?php echo base_url();?>assets/images/syrup.jpg" class="prescription_table_heading_icons" alt="" /></th>
						<th rowspan="3" class="text-center"><img src="<?php echo base_url();?>assets/images/calendar.jpg" class="prescription_table_heading_icons" alt="Days" />Duration<br /> (in Days)</th>
					<!--	<th rowspan="3" class="text-center">Frequency</th> -->
						<th colspan="6" class="text-center"><img src="<?php echo base_url();?>assets/images/timings.jpg" class="prescription_table_heading_icons"  alt="Timings" />Timings</th>
					<!--	<th rowspan="3" class="text-center">Quantity</th> -->
						</tr>
						<tr>
							<th colspan="2" class="text-center"><img src="<?php echo base_url();?>assets/images/morning.jpg" class="prescription_table_heading_icons" />Morning</th>
							<th colspan="2" class="text-center"><img src="<?php echo base_url();?>assets/images/afternoon.jpg" class="prescription_table_heading_icons" />Afternoon</th>
							<th colspan="2" class="text-center"><img src="<?php echo base_url();?>assets/images/night.jpg" class="prescription_table_heading_icons" />Evening</th>
						</tr>
						<tr>
							<th class="text-center"><span>BF</span><img src="<?php echo base_url();?>assets/images/information-icon.png" class="prescription_table_heading_info_icons" title="Before Food" data-toggle="tooltip"/></th>

							<th class="text-center"><span>AF</span><img src="<?php echo base_url();?>assets/images/information-icon.png" class="prescription_table_heading_info_icons" title="After Food" data-toggle="tooltip"/></th>

							<th class="text-center"><span>BF</span><img src="<?php echo base_url();?>assets/images/information-icon.png" class="prescription_table_heading_info_icons" title="Before Food" data-toggle="tooltip"/></th>

							<th class="text-center"><span>AF</span><img src="<?php echo base_url();?>assets/images/information-icon.png" class="prescription_table_heading_info_icons" title="After Food" data-toggle="tooltip"/></th>

							<th class="text-center"><span>BF</span><img src="<?php echo base_url();?>assets/images/information-icon.png" class="prescription_table_heading_info_icons" title="Before Food" data-toggle="tooltip"/></th>

							<th class="text-center"><span>AF</span><img src="<?php echo base_url();?>assets/images/information-icon.png" class="prescription_table_heading_info_icons" title="After Food" data-toggle="tooltip"/></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($prescription as $pres){ ?>						
					<tr>
						<td><?php echo $pres->item_name.' - '.$pres->item_form;?><br><?php if($pres->note!='') echo '-'.$pres->note;?></td>
						<td class="text-center"><?php echo $pres->duration;?></td>
					<!--	<td><?php echo $pres->frequency;?></td> -->
						<td class="text-center"><?php if($pres->morning == 1 || $pres->morning == 3) echo "<i class='fa fa-check'></i>";?></td>
						<td class="text-center"><?php if($pres->morning == 2 || $pres->morning == 3) echo " <i class='fa fa-check'></i>";?></td>
						<td class="text-center"><?php if($pres->afternoon == 1 || $pres->afternoon == 3) echo "<i class='fa fa-check'></i>";?></td>
						<td class="text-center"><?php if($pres->afternoon == 2 || $pres->afternoon == 3) echo "<i class='fa fa-check'></i>";?></td>
						<td class="text-center"><?php if($pres->evening == 1 || $pres->evening == 3) echo "<i class='fa fa-check'></i>";?></td>
						<td class="text-center"><?php if($pres->evening == 2 || $pres->evening == 3) echo "<i class='fa fa-check'></i>";?></td>
					<!--	<td><?php echo $pres->quantity;?> </td> -->
					<!--	<td>
							<?php echo form_open('register/update_patients',array('class'=>'form-custom'));?>
							<input type="text" class="sr-only" value="<?php echo $pres->prescription_id;?>" name="prescription_id" hidden />
							<input type="text" class="sr-only" value="<?php echo $pres->visit_id;?>" name="visit_id" hidden />
							<button type="submit" id="remove_prescription" class="btn btn-danger btn-sm">X</button>
							</form>
						</td> -->
					</tr>
					<?php } ?>
					</tbody>
				</table>
			<?php } ?>
			</div>
		</div>
		<?php 
				break;
				 }} ?>
		<?php 
			foreach($functions as $f){ 
				if($f->user_function == "Discharge" && ($f->add==1 || $f->edit==1)) { ?>
		<div role="tabpanel" class="tab-pane" id="discharge">
                    <div data-patient-quick-info></div>
			<div class="row">
			<div class="col-md-12 alt">
				<div class="col-md-2">
				<label class="control-label">Outcome</label>
				</div>
				<div class="col-md-8">
				<?php if(!!$patient->outcome) { ?> 
					<p><?php echo $patient->outcome; ?></p>
				<?php } else {?>
				<label><input type="radio" value="Discharge" name="outcome" />Discharge</label>
				<label><input type="radio" value="LAMA" name="outcome" />LAMA</label>
				<label><input type="radio" value="Absconded" name="outcome" />Absconded</label>
				<label><input type="radio" value="Death" name="outcome" />Death</label>
				<?php } ?>
				</div>
			</div>
                            <script>
				$(function(){
		/*			$(".ip_file_received").Zebra_DatePicker({
						direction:[false,'<?php echo date("d-M-Y",strtotime($patient->ip_file_received));?>']
					}); */
				});
                            </script>
                        <div class="col-md-12 alt">
						<div class="col-md-2">	<!-- here -->
				<script>
				$(function(){
					<?php if($patient->outcome_date == 0){ ?>
					$('.outcome_date').datetimepicker({
						format : "D-MMM-YYYY h:ssA",
						minDate : "<?php echo date("Y/m/d ",strtotime($patient->admit_date)).date("g:i A",strtotime($patient->admit_time));?>",
						defaultDate : false
					});
					<?php } ?>
					$(".transfer_date").datetimepicker({
						format : "D-MMM-YYYY h:ssA",
                        minDate:'<?php if(isset($transfers) && sizeof($transfers) !=0) echo date("Y/m/d ",strtotime($transfers[sizeof($transfers)-1]->transfer_date)).date("g:i A",strtotime($transfers[sizeof($transfers)-1]->transfer_time)); else echo date("Y/m/d ",strtotime($patient->admit_date)).date("g:i A",strtotime($patient->admit_time));?>',
						defaultDate : false
                    });
					$(".transport_start_date,.transport_end_date").datetimepicker({
						format : "D-MMM-YYYY h:ssA",
						defaultDate : false
                    });
			//		$(".imp_date").Zebra_DatePicker();
			//		$(".edd_date").Zebra_DatePicker();
			//		$(".date_of_birth").Zebra_DatePicker();
			//		$(".date_of_death").Zebra_DatePicker();
			//		$(".dob").Zebra_DatePicker({
			//			direction:[false,'<?php echo date("d-M-Y",strtotime($patient->dob));?>']
			//		});
                                $(".transfer_time").timeEntry();
					$(".time").timeEntry({minTime: new Date(<?php echo date("Y,m,d",strtotime($patient->admit_date)).date(",h,i,s",strtotime($patient->admit_time));?>)});
				});
				</script>
				<label>Outcome Date & Time</label>
				</div> 
				<div class="col-md-4">
				<?php if($patient->outcome_date=='0000-00-00'){ ?>
				<input type="date" name="outcome_date" class="form-control" />
				<input type="time" name="outcome_time" class="form-control" />
				<?php } else { ?>
					<p><?php echo date("d-M-Y",strtotime($patient->outcome_date)).' '.date("g:iA",strtotime($patient->outcome_time)); ?></p>
				<?php } ?>
				</div>
                            <div class="col-md-2">
                                <label class="control-label">Case Sheet Recieved at MRD on </label>
                            </div>
                            <div class="col-md-4">
							<?php if($patient->ip_file_received =='0000-00-00') {?>
                                <input type="date" name="ip_file_received" class="form-control" />
							<?php }	else { ?>
								<p><?php echo date("d-M-Y",strtotime($patient->ip_file_received)); ?></p>
							<?php } ?>
                            </div>			
				
			</div>
			<div class="col-md-12 alt ">
				<div class="col-md-2">
				<label class="control-label">Final Diag.</label>
				</div>
				<div class="col-md-8">
				<textarea name="final_diagnosis" class="form-control" cols="40" <?php if($f->edit==1&& empty($patient->final_diagnosis)) echo ''; else echo ' readonly'; ?> ><?php if(!!$patient->final_diagnosis) echo $patient->final_diagnosis;?></textarea>
				</div>
			</div>
			<div class="col-md-12 alt ">
				<div class="col-md-2">
				<label class="control-label">Decision</label>
				</div>
				<div class="col-md-8">
				<textarea name="decision" class="form-control" cols="40" <?php if($f->edit==1&& empty($patient->decision)) echo ''; else echo ' readonly'; ?> ><?php if(!!$patient->decision) echo $patient->decision;?></textarea>
				</div>
			</div>
			<div class="col-md-12 alt ">
				<div class="col-md-2">
				<label class="control-label">Advise</label>
				</div>
				<div class="col-md-8">
				<textarea name="advise" class="form-control" cols="40" <?php if($f->edit==1&& empty($patient->advise)) echo ''; else echo ' readonly'; ?> ><?php if(!!$patient->advise) echo $patient->advise;?></textarea>
				</div>
			</div>
			<div class="col-md-12 alt">	
				<div class="col-md-2">
					<label>ICD Code</label>
				</div>
				<div class="col-md-8">
				<?php if(!empty($patient->icd_10)){?>
					<label><?php echo $patient->icd_10." ".$patient->code_title;?></label>
				 <?php } else {?>
					<select id="icd_code" class="repositories" placeholder="Search ICD codes" name="icd_code" >
					<?php if(!!$patient->icd_10){ ?>
						<option value="<?php echo $patient->icd_10;?>"><?php echo $patient->icd_10." ".$patient->code_title;?></option>
					<?php } ?>
					</select>
				<?php } ?>
				</div>
				</div>
			</div>
		</div>
		<?php 
				break;
		}} ?>
		<!-- Insert New Tab here -->
		<div role="tabpanel" class="tab-pane  <?php if(count($previous_visits) > 1) echo "active"; ?>" id="vitals">
			<div data-patient-quick-info></div>
			<div class="row">
				<div class="col-md-4">
					<canvas id="sbp_dbp" width="100" height="100"></canvas>
				</div>
				<div class="col-md-4">
					<canvas id="rbs" width="100" height="100"></canvas>
				</div>
				<div class="col-md-4">
					<canvas id="hb" width="100" height="100"></canvas>
				</div>				
			</div>
			<div class="row">
			<div class="col-md-12">
			<table class="table table-striped table-bordered" id="detailed_table" >
				<thead>
					<tr>
						<th>#</th>
						<th>Date</th>
						<th>Wt-Kg</th>
						<th>SBP</th>
						<th>DBP</th>
						<th>Pulse</th>
						<th>RBS</th>
						<th>Hb</th>
						<th>HbA1C</th>
						<th>Doctor</th>
						<th>Clinical Notes</th>
						<th>Prescription</th>
					</tr>
				</thead>
				<tbody><!-- tr td -->
					<?php $i=1; foreach($vitals as $vital){ ?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $vital->DATE; ?></td>
						<td><?php echo $vital->Weight; ?></td>
						<td><?php echo $vital->SBP; ?></td>
						<td><?php echo $vital->DBP; ?></td>
						<td><?php echo $vital->Pulse; ?></td>
						<td><?php echo $vital->RBS; ?></td>
						<td><?php echo $vital->Hb; ?></td>
						<td><?php echo $vital->HbA1C; ?></td>
						<td><?php echo $vital->Doctor; ?></td>	
						<td><?php echo $vital->Clinical_Notes; ?></td>		
						<td><?php echo $vital->Prescription; ?></td>		
					</tr>
					<?php $i++; } ?>
				</tbody>
				<tfoot><!-- tr td -->
					
				</tfoot>
			</table>
			</div>
			</div>			
		</div>
		<!-- Insert New Tab here for Patient documents upload -->
		<div role="tabpanel" class="tab-pane  <?php if(count($previous_visits) > 1) echo "active"; ?>" id="docupload">
			<div data-patient-quick-info></div>

			<div class="row">
			<div class="col-md-12">
			<h4 class="col-md-12">List of Documents 
			<?php if($patient_document_add_access==1) echo '
		<button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal_' . $patient->patient_id .'">Add</button>
		'; ?>
	        </h4>			
			<table class="table table-striped table-bordered" id="detailed_table" >
				<thead>
					<tr>
						<th>#</th>
						<th>Document Date</th>
						<th>Document Type</th>
						<th>Note</th>
						<th>Document</th>
						<?php if($patient_document_edit_access==1) echo "<th>Edit</th>" ?>
						<?php if($patient_document_remove_access==1) echo "<th>Delete</th>" ?>
					</tr>
				</thead>
				<tbody><!-- tr td -->
					<?php $i=1; foreach($patient_document_upload as $document){ ?>
					<tr id="<?php echo $patient->patient_id; ?>">
						<td><?php echo $i; ?></td>
						<td><?php echo date("d-M-Y",strtotime($document->document_date)); ?></td>
						<td><?php echo $document->document_type; ?></td>
						<td><?php echo $document->note; ?></td>
						<td style="text-align:center;">
						
		                	<?php 
		                    	// Display document icon with document hyper link only if document link is available in DB
		                    	if(isset($document->document_link) && $document->document_link!="") {echo "<a href=" . base_url() . "register/display_document/".$document->document_link . 
		                    	" target=\"_blank\"><i class=\"fa fa-file\" style=\"font-size:24px;color:rgb(236, 121, 121)\"></i></a>";}
		                        else {echo "";}
			                ?>
		                </td>
					    <!--<td>
						    <a href="<?php echo base_url()."register/edit_document/".$patient->patient_id."/". $document->document_link;?>" class="btn btn-primary">Edit</a>
	    	            </td> -->
	    	            <?php if($patient_document_edit_access==1) echo "
						<td style=\"text-align:center;\">

						<button type=\"button\" id=\"editButton\" class=\"btn btn-info\" data-target=\"#myModalEdit_\" data-toggle=\"modal\" data-recordid=$document->id data-id=$document->document_link data-note=\"$document->note\" data-date=$document->document_date data-type=$document->document_type_id>Edit </button>
						</td>"
						?>
						<?php if($patient_document_remove_access==1) echo "
						<td style=\"text-align:center;\">

						<button type=\"button\" id=\"deleteButton\" class=\"btn btn-info\" data-target=\"#myModalDelete_\" data-toggle=\"modal\" data-id=$document->document_link >Delete </button>
						</td>"
						?>

					</tr>
					<?php $i++; } ?>
				</tbody>
				<tfoot><!-- tr td -->
					
				</tfoot>
			</table>
			</div>
			</div>			
		</div> <!--Patient Document Upload -->
			
	  </div>	

	<div class="col-md-4 text-right">
			<label class="control-label">
				<input type="text" name="selected_tab" id="selected_tab" class="sr-only" hidden value="" />
				Signed Consultation? 
				<?php if(!empty($patient->signed_consultation) && $patient->signed_consultation > 0) { ?>
					<span class="fa fa-check"></span>
					<input type="checkbox" class="sr-only" value="1" readonly checked />
				<?php }
				else{ ?>
 				<input type="checkbox"  class="form-control checkbox-big" name="signed_consultation" value = "1" />
				<?php } ?>
			</label><br>
			<b><?php echo $patient->doctor_name; ?></b>
			&emsp;
		</div>
		<div class="col-md-8">
		<input type="text" name="visit_id" class="sr-only" value="<?php echo $patient->visit_id;?>" hidden readonly />
		<input type="text" name="patient_id" class="sr-only" value="<?php echo $patient->patient_id;?>" hidden readonly />
		<input type="text" name="patient_number" class="sr-only" value="patient_number" hidden readonly />
		<button type="button" class="btn btn-md btn-primary" value="Update" name="update_patient" onclick="onUpdatePatientSubmit(event)">Update</button>&emsp;
		<button class="btn btn-md btn-warning" value="Print" type="button" onclick="printDiv('print-div')">Print Summary</button>
		<?php 
			$visits = sizeof($patient_visits);
		?>
		<button class="btn btn-md btn-warning" value="Print" type="button" onclick="printDiv('print-div-all')">(<?php echo $visits; ?>)-Print Summary All Visits</button>
		<?php if ($add_sms_access==1){ ?>			
		<button class="btn btn-md btn-warning" value="Print" type="button" onclick="openSmsModal()">Send SMS</button> 
		<?php } ?>
	</div>
	</div>
	</div>
	</form>
	<?php echo form_open("register/generate_summary_link",array('id'=>'generate_summary_link')); ?>
							
					<input type="hidden" name="summary_link_patient_id" id="summary_link_patient_id" value="<?php echo $patient->patient_id;?>" />
						<input type="hidden" name="summary_link_patient_visit_id" id="summary_link_patient_visit_id" value="<?php echo $patient->visit_id;?>" />	
						<input type="hidden" name="summary_link_contents" id="summary_link_contents"  />			
		<input type="hidden" name="summary_link_sms" id="summary_link_sms"  />	
		<input type="hidden" name="summary_download_link" id="summary_download_link"  />			
	</form>		
	<?php }
	else if(isset($patients)){
		echo "No patients found with the given search terms";
	}
	?>
	</div>
	<br/>
	
	<?php if(!!isset($previous_visits)){ ?>
	<div class="container">
	<table class="table table-bordered table-striped">
		<thead>
		<th>Date</th>
		<th>Hospital</th>
		<th>Type</th>
		<th>Number</th>
		<th>Department</th>
		<th>Unit/Area</th>
		<th>Outcome</th>
		<th>Outcome Date</th>
		</thead>
		<tbody>
		<?php foreach($previous_visits as $visit){ ?>
			<tr onclick="$('#select_visit_<?php echo $visit->visit_id;?>').submit()" style="cursor:pointer">
				<td>
					<?php echo form_open('register/view_patients',array('role'=>'form','id'=>'select_visit_'.$visit->visit_id));?>
					<input type="text" class="sr-only" hidden value="<?php echo $visit->visit_id;?>" name="selected_patient" />
					<input type="text" class="sr-only" hidden value="<?php echo $visit->patient_id;?>" name="patient_id" />
					</form>
				<?php 
				if($visit->visit_id == $patient->visit_id) echo "<i class='fa fa-eye'></i> ";?>
				<?php echo date("d-M-Y",strtotime($visit->admit_date));?>
				</td>
				<td><?php echo $visit->hospital;?></td>
				<td><?php echo $visit->visit_type;?></td>
				<td><?php echo $visit->hosp_file_no;?></td>
				<td><?php echo $visit->department;?></td>
				<td><?php echo $visit->unit_name."/".$visit->area_name;?></td>
				<td><?php echo $visit->outcome;?></td>
				<td><?php if($visit->outcome_date!=0) echo date("d-M-Y",strtotime($visit->outcome_date));?></td>
			</tr>
		<?php } ?>
		</tbody>
	</table>
	</div>
<?php } ?>
<br>
<div class="col-md-12">
		<div class="panel panel-default">
		<div class="panel-heading">
		<h4>Search Patients</h4>	
		</div>
		<div class="panel-body">
		<?php echo form_open("register/update_patients",array('role'=>'form','class'=>'form-custom')); ?>
					<div class="row">
					<div class="col-md-10">
						<div class="form-group">
						<label class="control-label">H4A ID</label>
						<input type="text" name="search_patient_id" size="5" class="form-control" />
						<label class="control-label">Year</label>
						<select class="form-control" name="search_year">
							<?php 
								$i=2013;
								$year = date("Y");
								while($year>=$i){ ?>
								<option value="<?php echo $year;?>"><?php echo $year--;?></option>
							<?php
								}
							?>
						</select>
						</div>
						<div class="form-group">
							<label class="control-label">Visit Type</label>
							<select class="form-control" name="search_visit_type">
								<option value=''>All</option>
								<option value='IP'>IP</option>
								<option value='OP'>OP</option>
							</select>
						<label class="control-label">IP/OP Number</label>
						<input type="text" name="search_patient_number" size="5" class="form-control" />
						</div>
					<!--	<div class="form-group">
						<label class="control-label">Patient Name</label>
						<input type="text" name="search_patient_name" class="form-control" />
						</div> -->
						<div class="form-group">
						<label class="control-label">Phone Number</label>
						<input type="text" name="search_phone" class="form-control" />
						</div>
					</div>
				</div>
		</div>
		<div class="panel-footer">
			<div class="text-center">
			<input class="btn btn-sm btn-primary" name="search_patients" type="submit" value="Submit" />
			</div>
			</form>
		</div>
		</div>
</div>

<!--kchintak-->
<br />
<!-- Modal -->
<div class="modal fade" id="smsModal" tabindex="-1" role="dialog" aria-labelledby="smsModalLabel">
  <div class="modal-dialog" role="document" style="width:90%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="smsModalLabel">SMS</h4>
      </div>
      <div class="modal-body" id="smsModalBody">
      	<div class="row">							
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
				<div class="form-horizontal">
					<label for="smsModal-customer">SMS To<font style="color:red">*</font></label>
					<input type="text" class="form-control" id="smsModal-customer" placeholder="Enter '0' followed by 10 digit phone number" value='<?php echo $patient->phone;?>' required" />
					 <p class="error smsModal-customer-error">This field is required</p> 

				</div>
			</div>		

			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
				<div class="form-horizontal">
					<label for="smsModal-helplinewithname">Through Helpline<font style="color:red">*</font></label>
					<input type="text" class="form-control" id="smsModal-helplinewithname" required readonly />
					<select class="form-control" id="smsModal-helplinewithname-dropdown" style="display: none" onchange="setSmsHelplineNumber()" disabled></select>
					<input type="hidden" id="smsModal-helpline" />
				</div>
			</div>
			<!--<?php
				echo("<script>console.log('PHP: " . json_encode($sms_templates) . "');</script>");
			?>-->
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
				<div class="form-horizontal">
					<label for="smsModal-templatewithname">Template<font style="color:red">*</font></label>
					<input type="text" class="form-control" id="smsModal-templatewithname" required readonly />
					<select class="form-control" id="smsModal-templatewithname-dropdown" style="display: none" onchange="setSmsTemplateName()"></select>
					<input type="hidden" id="smsModal-helpline" />
				</div>
			</div>			
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
				<div class="form-horizontal">
					<label for="smsModal-template">SMS Content<font style="color:red">*</font></label>
					<textarea class="form-control" id="smsModal-template"  required rows="8" onblur=smsTemplate()></textarea>
					<p class="error smsModal-template-error">This field is required</p>
				</div>
			</div>	
			<script type="text/javascript">
		
			var smstemplate='<?php echo json_encode($sms_templates); ?>';
			var inputF = document.getElementById("smsModal-template");
			var json=JSON.parse(smstemplate);

			function setSmsTemplate(helpline_id){	
				smsDetails.templateName=$('#smsModal-templatewithname-dropdown').val();
				document.getElementById('smsModal-template').readOnly = false;
				for (var key in json) {
					if (json.hasOwnProperty(key)) {
						if(json[key].helpline_id==helpline_id && json[key].sms_template_id == smsDetails.templateName){
							if (json[key].edit_text_area==0){
								document.getElementById('smsModal-template').readOnly = true;
							}
							
							
							inputF.value=json[key].template;
							smsDetails.sms_type=json[key].sms_type;
							smsDetails.template_name=json[key].sms_template_id;
							smsDetails.dlt_tid=json[key].dlt_tid;
							smsDetails.dlt_entity_id=json[key].dlt_entity_id;
							if(json[key].generate_by_query==1){
							var target = '<?php echo base_url();?>'+ json[key].generation_method;
							switch (json[key].generation_method) {
								case 'register/generate_summary_link':
									var content = document.getElementById('print-div');
									var template = '';
									$('#summary_link_contents').val(content.innerHTML); 
									$('#summary_link_sms').val(json[key].template);
									$('#summary_download_link').val(json[key].report_download_url);
									$.ajax({
  										type: 'POST',
  										url: target,
  										data: $("#generate_summary_link").serialize(), 
  										success: function(response) { smsDetails.template = response; document.getElementById("smsModal-template").value = response;},
   										error : function(response) {  bootbox.alert("Link Generation failed"); }
   									});
   									break;
   								case 'register/generate_doc_upload_link':
   									var jsonData = {};
   									jsonData.patient_id = "<?php echo $patient->patient_id;?>";
   									jsonData.visit_id = "<?php echo $patient->visit_id;?>";
   									jsonData.report_download_url = json[key].report_download_url;
   									jsonData.template = json[key].template;
   									$.ajax({
   										url: target,
  										type: 'POST',					
  										dataType: "JSON",
  										data: jsonData, 
  										success: function(response) { smsDetails.template = response.sms_content; document.getElementById("smsModal-template").value = response.sms_content;},
   										error : function(response) {  bootbox.alert("Link Generation failed"); }
   									});
   									break;
   								
							      }
							}							
							else{
								smsDetails.template=json[key].template;
							}
						}
					}
				}
			}

			function setSmsTemplateWithName(helpline_id, templateName){
				document.getElementById('smsModal-template').readOnly = false;
				for (var key in json) {
					if (json.hasOwnProperty(key)) {
						if(json[key].helpline_id==helpline_id && json[key].sms_template_id == templateName ){
							document.getElementById("smsModal-template").value=json[key].template;
							if (json[key].edit_text_area==0){
								document.getElementById('smsModal-template').readOnly = true;
							}							
							smsDetails.sms_type=json[key].sms_type;
							smsDetails.template_name=json[key].sms_template_id;
							smsDetails.dlt_tid=json[key].dlt_tid;
							smsDetails.dlt_entity_id=json[key].dlt_entity_id;
							smsDetails.dlt_header = json[key].dlt_header;
							if(json[key].generate_by_query==1){
							var target = '<?php echo base_url();?>'+ json[key].generation_method;
							switch (json[key].generation_method) {
								case 'register/generate_summary_link':
									var content = document.getElementById('print-div');
									var template = '';
									$('#summary_link_contents').val(content.innerHTML); 
									$('#summary_link_sms').val(json[key].template);
									$('#summary_download_link').val(json[key].report_download_url);
									$.ajax({
  										type: 'POST',
  										url: target,
  										data: $("#generate_summary_link").serialize(), 
  										success: function(response) { smsDetails.template = response; document.getElementById("smsModal-template").value = response;},
   										error : function(response) {  bootbox.alert("Link Generation failed"); }
   									});
   									break;
   								case 'register/generate_doc_upload_link':
   									var jsonData = {};
   									jsonData.patient_id = "<?php echo $patient->patient_id;?>";
   									jsonData.visit_id = "<?php echo $patient->visit_id;?>";
   									jsonData.report_download_url = json[key].report_download_url;
   									jsonData.template = json[key].template;
   									$.ajax({
   										url: target,
  										type: 'POST',					
  										dataType: "JSON",
  										data: jsonData, 
  										success: function(response) { smsDetails.template = response.sms_content; document.getElementById("smsModal-template").value = response.sms_content;},
   										error : function(response) {  bootbox.alert("Link Generation failed"); }
   									});
   									break;
   								
							       }
							}							
							else{
								smsDetails.template=json[key].template;
							}
						}
					}
				}				
			}

			function setSmsTemplateName(){
				smsDetails.templateName = $('#smsModal-templatewithname-dropdown').val();
				smsDetails.called_id = $('#smsModal-helplinewithname-dropdown').val();
				setSmsTemplateWithName(smsDetails.called_id, smsDetails.templateName);
			}

			function smsTemplate(){
			    smsDetails.template=$('#smsModal-template').val();
			}

			function setSmsHelplineNumber(){
				smsDetails.called_id = $('#smsModal-helplinewithname-dropdown').val();
				document.getElementById("smsModal-templatewithname-dropdown").innerHTML = null; 
				for (var key in json) {
					if (json.hasOwnProperty(key)) {
						if(json[key].helpline_id==smsDetails.called_id){
						if ($("select[id$='smsModal-templatewithname-dropdown'] option:contains('" + json[key].template_name + "')").length == 0) {
                $('#smsModal-templatewithname-dropdown').append('<option value="'+json[key].sms_template_id+'">'+json[key].template_name+'</option>');
            }
														
						}
					}
				}
				setSmsTemplateName();
			}
			</script>
		</div>
		<div class="row" style="margin-top: 20px;">
			<div class="col-xs-12">
				<input id="initiateSmsButton" type="button" value="Send" class="btn btn-primary btn-sm" onclick="initiateSms()" />
			</div>
		</div>
      </div>
	 </div>
	</div>
</div>
<?php if(isset($patients) && count($patients)>0){ ?>
<div class="modal fade" id="myModalDelete_" tabindex="-1" role="dialog">
	<div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header bg-primary text-white">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Do you want to delete this record</h4>
		</div>
        <div class="modal-body">
		
		  	<?php echo form_open("register/update_patients",array('class'=>'form-horizontal','role'=>'form','id'=>'select_patient_'.$patient->visit_id, 'method'=>'POST')); ?>
		    <input type="text" hidden name="document_link" id="document_link" value=""/>
			<input type="text" class="sr-only" hidden value="<?php echo $patient->visit_id;?>" form="select_patient_<?php echo $patient->visit_id;?>" name="selected_patient" />
			<input type="text" class="sr-only" hidden value="<?php echo $patient->patient_id;?>" name="patient_id" />
			<div class="form-group">						
	    	   <div class="col-md-6">
				   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				   <button class="btn btn-danger"  type="button" name="btdelete" id="btdelete" >Delete</button>
		    	</div>
		    </div>

			</form> 
	    </div>
	</div>
	</div>
</div>

<div class="modal fade" id="myModalEdit_" tabindex="-1" role="dialog">
	<div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header bg-primary text-white">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Edit Metadata</h4>
		</div>
        <div class="modal-body">
		<label><b>File Name: &nbsp </b></label><label id="filelink"></label>
		  	<?php echo form_open("register/update_patients",array('class'=>'form-horizontal','role'=>'form','id'=>'select_patient_'.$patient->visit_id, 'method'=>'POST')); ?>
		  	<input type="text" hidden name="edit_record_id" id="edit_record_id"  value=""/>	
		    <input type="text" hidden name="edit_document_link" id="edit_document_link" value=""/>
		    
			<input type="text" class="sr-only" hidden value="<?php echo $patient->visit_id;?>" form="select_patient_<?php echo $patient->visit_id;?>" name="selected_patient" />
			<input type="text" class="sr-only" hidden value="<?php echo $patient->patient_id;?>" id="edit_patient_id" name="edit_patient_id" />
			<div class="form-group">
                <div class="col-md-3">
		        	<label for="document_date" class="control-label">Document Date*</label>
		        </div>
		        <div class="col-md-6">
		        	<input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" id="edit_document_date" name="document_date" required />
		        </div>
        	</div>						
			<div class="form-group">
		    	<div class="col-md-3">			
			    	<label for="document_type">Document Type*</label>
				</div>
		        <div class="col-md-6">				
				<select required name="document_type" id="edit_document_type" class="form-control">
					<option selected disabled value="">Select Document Type</option>
					<?php 
					foreach($patient_document_type as $type){
						echo "<option value='".$type->document_type_id."'";
						if($this->input->post('document_type') && $this->input->post('document_type') == $type->document_type_id) echo " selected ";
						echo ">".$type->document_type."</option>";
					}
					?>
				</select>
				</div>
			</div>
			<div class="form-group">
		        <div class="col-md-3">
	        		<label for="note" class="control-label">Note</label>
	        	</div>
	        	<div class="col-md-6">
	            	<input type="text" class="form-control" placeholder="note" id="edit_note" name="note"/>
	        	</div>
	        </div>	
			<div class="form-group">						
	    	   <div class="col-md-6">
				   <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				   <button class="btn btn-danger"  type="button" name="btEdit" id="btEdit" >Update</button>
		    	</div>
		    </div>

			</form> 
	    </div>
	</div>
	</div>
</div>
		<?php } ?>

<script>
	$(function(){
		selectize = $("#icd_code")[0].selectize;
		selectize.on('change',function(){
			var test = selectize.getOption(selectize.getValue());
			console.log(test);
		});
		$i=1;
		$("#retrieve_prescription").click(function(){
			<?php if(count($previous_prescription)==0) echo "alert('No prescriptions in the previous visit'); return;"; ?>
			$row = "";
			<?php foreach($previous_prescription as $prev) { ?>
				$row += '<tr class="prescription">'+
						'	<td style="width:500px;">'+
								'<select name="drug_'+$i+'" class="repositories" placeholder="-Enter Generic Drug Name-" data-previous-value="<?php echo $prev->item_id;?>">'+
								'<option value="">-Enter Generic Drug Name-</option>'+
								'</select>'+'<i class="glyphicon glyphicon-pencil active"></i><span class="note_tooltip">[Click to Add Note]</span>'+'<textarea name="note_'+$i+'" cols="30" rows="10" placeholder="Enter note here" style="border: 0px;background: transparent;"';
							<?php if(trim($prev->note) == "") { ?> $row += " hidden "; <?php } ?>
							$row += '><?php echo $prev->note;?></textarea>'+
							'</td>'+
							'<td class="text-center">'+
								'<input type="text" name="duration_'+$i+'" placeholder="Days" value="<?php echo $prev->duration;?>" style="width:60px" class="form-control" />'+
							'</td>'+
							'<!-- <td>'+
								'<select name="frequency_'+$i+'" class="form-control">'+
								<?php foreach($prescription_frequency as $freq){ ?>
									'<option value="<?php echo $freq->frequency;?>"><?php echo $freq->frequency;?></option>'+
								<?php } ?>
								'</select>'+
							'</td> -->'+
							'<td class="text-center">'+
								'<label><input type="checkbox" name="bb_'+$i+'" <?php if($prev->morning == 1 || $prev->morning == 3) echo " checked ";?> value="1" /></label>'+
							'</td>'+
							'<td class="text-center">'+
								'<label><input type="checkbox" name="ab_'+$i+'" <?php if($prev->morning == 2 || $prev->morning == 3) echo " checked ";?> value="1" /></label>'+
							'</td>'+
							'<td class="text-center">'+
								'<label><input type="checkbox" name="bl_'+$i+'" <?php if($prev->afternoon == 1 || $prev->afternoon == 3) echo " checked ";?> value="1" /></label>'+
							'</td>'+
							'<td class="text-center">'+
								'<label><input type="checkbox" name="al_'+$i+'" <?php if($prev->afternoon == 2 || $prev->afternoon == 3) echo " checked ";?> value="1" /></label>'+
							'</td>'+
							'<td class="text-center">'+
								'<label><input type="checkbox" name="bd_'+$i+'" <?php if($prev->evening == 1 || $prev->evening == 3) echo " checked ";?> value="1" /></label>'+
							'</td>'+
							'<td class="text-center">'+
								'<label><input type="checkbox" name="ad_'+$i+'" <?php if($prev->evening == 2 || $prev->evening == 3) echo " checked ";?> value="1" /></label>'+
							'</td>'+
							'<!--<td>'+
								'<input type="text" name="quantity_'+$i+'" style="width:100px" class="form-control" />'+
							'</td>-->'+
							'<td><input type="text" name="prescription[]" class="sr-only" value="'+$i+'" />'+
								'<button type="button" class="btn btn-danger btn-sm" onclick="$(this).parent().parent().remove()">X</button>'+
							'</td>'+
						'</tr>';
				$i++;
			<?php } ?>
			$(".prescription").parent().prepend($row);
			initPrescriptionDrugSelectize();

			// TODO: CHANGE PHP CODE TO JSON BASED UI RENDERING...
			$('[name^=note_]').each(function(){
				if($(this).attr('hidden')){
					$(this).prev().prev().removeClass('active');
				} else {
					$(this).prev().html('[Click to Delete Note]');
				}
			})
		});
		$("#prescription_add").click(function(){
			$row = '<tr class="prescription">'+
						'	<td style="width:500px;">'+
								'<select name="drug_'+$i+'" class="repositories" placeholder="-Enter Generic Drug Name-">'+
								'<option value="">-Enter Generic Drug Name-</option>'+
								'</select>'+'<i class="glyphicon glyphicon-pencil"></i><span class="note_tooltip">[Click to Add Note]</span>'+'<textarea name="note_'+$i+'" cols="30" rows="10" placeholder="Enter note here" style="border: 0px;background: transparent;" hidden></textarea>'+
							'</td>'+
							'<td class="text-center">'+
								'<input type="text" name="duration_'+$i+'" placeholder="Days" style="width:60px" class="form-control" />'+
							'</td>'+
							'<!-- <td>'+
								'<select name="frequency_'+$i+'" class="form-control">'+
								<?php foreach($prescription_frequency as $freq){ ?>
									'<option value="<?php echo $freq->frequency;?>"><?php echo $freq->frequency;?></option>'+
								<?php } ?>
								'</select>'+
							'</td> -->'+
							'<td class="text-center">'+
								'<label><input type="checkbox" name="bb_'+$i+'" value="1" /></label>'+
							'</td>'+
							'<td class="text-center">'+
								'<label><input type="checkbox" name="ab_'+$i+'" value="1" /></label>'+
							'</td>'+
							'<td class="text-center">'+
								'<label><input type="checkbox" name="bl_'+$i+'" value="1" /></label>'+
							'</td>'+
							'<td class="text-center">'+
								'<label><input type="checkbox" name="al_'+$i+'" value="1" /></label>'+
							'</td>'+
							'<td class="text-center">'+
								'<label><input type="checkbox" name="bd_'+$i+'" value="1" /></label>'+
							'</td>'+
							'<td class="text-center">'+
								'<label><input type="checkbox" name="ad_'+$i+'" value="1" /></label>'+
							'</td>'+
							'<!--<td>'+
								'<input type="text" name="quantity_'+$i+'" style="width:100px" class="form-control" />'+
							'</td>-->'+
							'<td><input type="text" name="prescription[]" class="sr-only" value="'+$i+'" />'+
								'<button type="button" class="btn btn-danger btn-sm" onclick="$(this).parent().parent().remove()">X</button>'+
							'</td>'+
						'</tr>';
			$i++;
			$(".prescription").parent().append($row);
			initPrescriptionDrugSelectize();
		});
	});
	$('#icd_code').selectize({
    valueField: 'icd_code',
    labelField: 'code_title',
    searchField: 'code_title',
    create: false,
    render: {
        option: function(item, escape) {

            return '<div>' +
                '<span class="title">' +
                    '<span class="icd_code">' + escape(item.code_title) + '</span>' +
                '</span>' +
            '</div>';
        }
    },
    load: function(query, callback) {
        if (!query.length) return callback();
		$.ajax({
            url: '<?php echo base_url();?>register/search_icd_codes',
            type: 'POST',
			dataType : 'JSON',
			data : {query:query},
            error: function(res) {
                callback();
            },
            success: function(res) {
                callback(res.icd_codes.slice(0, 10));
            }
        });
	}
	});

	async function onUpdatePatientSubmit(event){
		var flag = true;

		$('.form-control.error').each(function(){
			if(flag){
				flag = false;
				$('a[href="#'+$(this).parents('[role="tabpanel"]').attr('id')+'"]').click();
				$(this).get(0).scrollIntoView({ behavior: 'smooth', block: 'center' });
			}
		})

		// mandator fields check...
		$(this).find("[name^=note_date]").removeClass('error_field');
		$(".clinical-notes-table tbody.daily_notes tr span.error").remove();
		$(".clinical-notes-table tbody.daily_notes tr").each(function(){
		    if(flag && $(this).find("[name^=clinical_note]").val() && !$(this).find("[name^=note_date]").val()){
	        	flag = false;
	            $('a[href="#clinical"]').click();
	            $(this).find("[name^=note_date]").addClass('error_field').after('<span class="error" style="display: block;">This field is required</span>');
	            $(this).find("[name^=note_date]").get(0).scrollIntoView({ behavior: 'smooth', block: 'center' });
		    }
		});

		// if prescription selected & any of the 12 notes fields is not mentioned. [CLINICAL TAB + discharge tab]
		if(flag && $("#prescription_table [name^=drug_]").filter(function() {return !!$(this).val()}).length > 0){
			var optionalFlag = false;
			$("[name=presenting_complaints],[name=past_history],[name=family_history],[name=clinical_findings],[name=cvs],[name=rs],[name=pa],[name=cns],[name=final_diagnosis],[name=decision],[name=advise],[name=icd_code]").each(function(){
				if(!optionalFlag && $(this).val()){
					optionalFlag = true;
				}
			});
			if(!optionalFlag){
				flag = false;
				await new Promise((resolve) => {
					bootbox.alert(defaultsConfigsObj['SYMPTOMSALERT'].default_description, function(){ 
					    resolve(false);
					});
				})
			}
		}

		
		// signed consultation checkbox is mandatory if any prescription is given...
		if(flag && $("#prescription_table [name^=drug_]").filter(function() {return !!$(this).val()}).length > 0 && $('[name=signed_consultation]').length > 0 && $('[name=signed_consultation]:checked').length == 0){
			flag = false;
			await new Promise((resolve) => {
				bootbox.alert(defaultsConfigsObj['SIGNOFFALERT'].default_description, function(){ 
				    $('[name=signed_consultation]').get(0).scrollIntoView({ behavior: 'smooth', block: 'center' });
				    resolve(false);
				});
			})
		}

		// prescription validation...
		if(flag && $("#prescription_table [name^=drug_]").filter(function() {return !!$(this).val()}).length > 0){
			// if any drug dropdown is selected then check for the duration & timings...
			var prescriptionError = false;
			
			$("#prescription_table tbody tr.prescription").each(function(){
				if($(this).find("[name^=drug_]").val()){
					// check if duration is available...
					if(!$(this).find("[name^=duration_]").val() || $(this).find("[type=checkbox]:checked").length == 0){
						prescriptionError = true;
					}
				}
			})

			if(prescriptionError){
				flag = await new Promise((resolve) => {
					bootbox.confirm({
					    message: "Would you like to mention number of DAYS and/or TIMING for the Prescribed Medicine(s)?",
					    buttons: {
					        confirm: {
					            label: 'Ignore and proceed',
					            className: 'btn-success'
					        },
					        cancel: {
					            label: 'Go back and update',
					            className: 'btn-warning'
					        }
					    },
					    callback: function (result) {
					        if(!result){
					        	$('a[href="#prescription"]').click()
					        }
					        resolve(result)
					    }
					});
		      	})
			}
		}	

		if(flag){
			$('form#update_patients').append('<input type="hidden" value="Update" name="update_patient" />').submit();
		}

	}

	var defaultsConfigs = JSON.parse('<?php echo (isset($defaultsConfigs) && count($defaultsConfigs) > 0) ? json_encode($defaultsConfigs) : 'null'; ?>');
	var defaultsConfigsObj = {};
	defaultsConfigs.map(function(dc){
		defaultsConfigsObj[dc.default_id] = dc;
	});

	function initDefaultsConfigsElements(){
		$('[data-defaults-config]').each(function(){
			if($(this).attr('data-defaults-config') && defaultsConfigsObj[$(this).attr('data-defaults-config')]){
				$(this).html(defaultsConfigsObj[$(this).attr('data-defaults-config')].default_description);
			}
		});
	}

	function initUpdatePatientValidations(){
		if(!defaultsConfigs){
			bootbox.alert("Defaults configurations are missing, Kindly contact admin regarding this.");
			return;
		}

		var validatiorRules = {
            age_years: {
                range: [0, 200],
                digits: true
            },
            age_months: {
                range: [0, 11],
                digits: true
            },
            age_days: {
                range: [0, 31],
                digits: true
            }
        };

        var validationConfigs = [
        	{ field: 'sbp', target: 'SBP', range: true,  },
        	{ field: 'dbp', target: 'DBP', range: true },
        	{ field: 'spo2', target: 'SPO2', range: true },
        	{ field: 'admit_weight', target: 'WT', range: true, digits: false },
        	{ field: 'pulse_rate', target: 'HR', range: true },
        	{ field: 'temperature', target: 'TEMP', range: true },
        	{ field: 'respiratory_rate', target: 'RR', range: true },
        	{ field: 'blood_sugar', target: 'RBS', range: true },
        	{ field: 'hb', target: 'HB', range: true },
        	{ field: 'hb1ac', target: 'HBAIC', range: true },
        ];

        var validationMessages = {};

        validationConfigs.map(function(vc){
        	if(defaultsConfigsObj[vc.target]){
        		if(vc.range){
	        		validatiorRules[vc.field] = {
	        			range: [defaultsConfigsObj[vc.target]['lower_range'], defaultsConfigsObj[vc.target]['upper_range']],
	        			digits: true
	        		}
	        		if(!vc.digits){
	        			delete validatiorRules[vc.field]['digits'];
	        		}

	        		validationMessages[vc.field] = {
	                	range: "Please enter a valid value.&nbsp;"
	            	}
        		}
        	}
        });
            

		$('form[id="update_patients"]').validate({
	        rules: validatiorRules,
	        messages: validationMessages,
	        errorPlacement: function( label, element ) {
	        	if( ["sbp", "dbp"].indexOf(element.attr( "name" )) == -1 ) {
	        		label.css({display: 'block'});
	        	}
	        	element.parent().append( label ); 
				/*if( ["age_years", "age_months", "age_days", "sbp", "dbp"].indexOf(element.attr( "name" )) > -1 ) {
					// this would append the label after all your checkboxes/labels (so the error-label will be the last element in <div class="controls"> )
					element.parent().append( label ); 
				} else {
					label.insertAfter( element ); // standard behaviour
				}*/
			}
	        /*ignore: ".date_custom",
	        submitHandler: function (form) {
	            form.submit();
	        }*/
	    });

	    /*$.validator.addMethod("oneormorechecked", function(value, element) {
		  return $('input[name="' + element.name + '"]:checked').length > 0;
		}, "Atleast 1 must be selected");

		$('.validate').validate();*/
	}

	var prescriptionDrugs = null;
	function initPrescriptionDrugSelectize(){
		$('[name^=drug_]').each(function(){
			if(!$(this).get(0).selectize){
				var selectize = $(this).selectize({
				    valueField: 'generic_item_id',
				    labelField: 'custom_name',
				    searchField: 'custom_name',
				    options: prescriptionDrugs,
				    create: false,
				    render: {
				        option: function(item, escape) {
				        	var drugsAvailableClass = "";
				        	if(item.custom_name.indexOf(' - Available') > -1){
				        		drugsAvailableClass = "drug_available_class";
				        	}
				            return '<div class="'+drugsAvailableClass+'">' +
				                '<span class="title">' +
				                    '<span class="prescription_drug_selectize_span">' + escape(item.custom_name) + '</span>' +
				                '</span>' +
				            '</div>';
				        }
				    },
				    load: function(query, callback) {
				        if (!query.length) return callback();
				        /*if(prescriptionDrugs){
				        	callback(prescriptionDrugs.slice(0, 10));
				        	return;
				        }
						$.ajax({
				            url: '<?php echo base_url();?>register/search_prescription_drugs',
				            type: 'POST',
							dataType : 'JSON',
							data : {query:query},
				            error: function(res) {
				                callback();
				            },
				            success: function(res) {
				            	// merge drugs_available into respective item in drugs...
				            	var drugsAvailable = {};
								res.drugs_available.forEach(function(da){
								    drugsAvailable[da.generic_item_id] = da;
								})

								res.drugs.map(function(d){
									d.custom_name = d.generic_name + ' - ' + d.item_form;
								    if(drugsAvailable[d.generic_item_id]){
								    	d.custom_name += ' - Available';
								        d.drugs_available = drugsAvailable[d.generic_item_id];
								    }
								    return d;
								});
				            	prescriptionDrugs = res.drugs;
				                callback(prescriptionDrugs.slice(0, 10));
				            }
				        });*/
				        callback(prescriptionDrugs.slice(0, 10));
					},

				});
				if($(this).attr("data-previous-value")){
					selectize[0].selectize.setValue($(this).attr("data-previous-value"));
				}
			}
		})
	}

	function mergeDrugsAvailableToDrugs(res){
		var drugsAvailable = {};
		res.drugs_available.forEach(function(da){
		    drugsAvailable[da.generic_item_id] = da;
		})

		res.drugs.map(function(d){
			d.custom_name = d.generic_name + ' - ' + d.item_form;
		    if(drugsAvailable[d.generic_item_id]){
		    	d.custom_name += ' - Available';
		        d.drugs_available = drugsAvailable[d.generic_item_id];
		    }
		    return d;
		});
    	prescriptionDrugs = res.drugs;
	}

	function performTemplateReplacement(){
		$("[data-patient-quick-info]").replaceWith($('#template-patient-quick-info').html());
	}

	var patient = <?php echo json_encode((isset($patient) && count($patient) > 0) ? $patient : array()); ?>;
	var patient_visits = <?php echo json_encode((isset($patient_visits) && count($patient_visits) > 0) ? $patient_visits : array()); ?>;

	function constructPatientDetails(){
		jQuery.fn.tagNameLowerCase = function() {
		  return this.prop("tagName").toLowerCase();
		};

		var prescriptionElements = [
			{'label': 'Admit Weight', 'value': ['admit_weight'], 'delimiter': '/', 'suffix': 'kgs'},
			{'label': 'Blood Pressure', 'value': ['sbp', 'dbp'], 'delimiter': '/', 'suffix': '', 'labelTooltip': 'SBP - Systolic Blood Pressure / DBP- Diastolic Blood Pressure', 'fieldAttributes': ['maxlength="3" size="3" placeholder="SBP" style="width: 60px"', 'maxlength="3" size="3" placeholder="DBP" style="width: 60px"']},
			{'label': 'Pulse Rate', 'value': ['pulse_rate'], 'delimiter': '/', 'suffix': ''},
			{'label': 'SpO2', 'value': ['spo2'], 'delimiter': '/', 'suffix': '%', 'labelTooltip': 'Oxygen Saturation', 'fieldAttributes': ['maxlength="3" size="3" style="width: 50px"']},
			{'label': 'Respiratory Rate', 'value': ['respiratory_rate'], 'delimiter': '/', 'suffix': ''},
			{'label': 'Temperature', 'value': ['temperature'], 'delimiter': '/', 'suffix': 'F'},
			{'label': 'Blood Sugar', 'value': ['blood_sugar'], 'delimiter': '/', 'suffix': 'mg/dL', 'fieldAttributes': ['maxlength="3" size="3" style="width: 50px"']},
			{'label': 'Hb', 'value': ['hb'], 'delimiter': '/', 'suffix': 'g/dL', 'labelTooltip': 'Haemoglobin', 'fieldAttributes': ['maxlength="4" size="4" style="width: 50px"']},
			{'label': 'HbA1c', 'value': ['hb1ac'], 'delimiter': '/', 'suffix': '%', 'labelTooltip': 'Glycated Haemoglobin', 'fieldAttributes': ['maxlength="3" size="3" style="width: 50px"']}
		];

		$('[data-patient-clinical-details]').each(function(i, pe){
			var source = $(this).attr('data-source');
			var index = $(this).attr('data-index');
			var editPrivilege = $(this).attr('data-edit-privilege');
			var readonlyIfNotEmpty = $(this).attr('data-readonly-if-not-empty');
			var printMode = $(this).attr('data-print-mode');
			var skipIfNoValue = $(this).attr('data-skip-if-no-value');
			
			// <input <?php if($f->edit==1  && empty($patient->admit_weight)) echo ''; else echo ' readonly'; ?> />

			var rowWrapper = '<div class="row alt"></div>';
			var fieldWrapper = '<div class="col-md-4 col-xs-6"></div>';
			var labelWrapper = '<label class="control-label"></label>';
			if(printMode){
				rowWrapper = '<tr class="print-element"></tr>';
				fieldWrapper = '<td></td>';
				labelWrapper = '<b></b>';
			}

			var wrapper = $('<div></div>');
			var row = $(rowWrapper);
			var data = window[source];
			if(index){
				data = data[index];
			}
			$.each(prescriptionElements, function(i, d){
				var field = $(fieldWrapper);
				var label = $(labelWrapper);

				var fieldValue = d.value.map((d) => {
					if(data[d] == "0") data[d] = "";
					return data[d];
				}).join(d.delimiter);
				if(fieldValue == "/") fieldValue = "";
				// TODO: THIS NEEDS TO BE FIXED AT BACKEND...
				
				// for print, skip the display if no value... this has been negated to continue without adding for last item
				if(!(printMode && skipIfNoValue && !fieldValue)){
					label.append(d.label + (printMode ? ':' : ''));
					if(!printMode && d.labelTooltip){
						label.append('<img src="<?php echo base_url();?>assets/images/information-icon.png" class="prescription_table_heading_info_icons" title="'+d.labelTooltip+'" data-toggle="tooltip"/>');
					}
					label.append('&nbsp;');
					field.append(label);
					if(printMode){
						field.append(fieldValue);
					} else {
						field.append(d.value.map((df, i) => { 
							var placeholder = (d.placeholder && d.placeholder[i]) ? 'placeholder="'+d.placeholder[i]+'"' : '';
						    return '<input type="text" name="'+df+'" '+placeholder+' '+d.fieldAttributes+' class="form-control" value="'+data[df]+'" '+(!editPrivilege || (readonlyIfNotEmpty && data[df]) ? 'readonly' : '')+' />';
						}).join(d.delimiter));
					}
					if(d.suffix){
						field.append(' ' + d.suffix);
					}
					row.append(field);
				}


				if(
					// to append the row, column has to be there...
					row.find(field.tagNameLowerCase()).length > 0 && (
						// if for ui, append the row for every 3 fields...
						(!printMode && ((i+1) % 3 == 0)) || 
						// if for print, append the row only when there are 3 fields...
						(printMode && row.find(field.tagNameLowerCase()).length == 3) || 
						// if this is the last element of the iteration, then append the row...
						(i == prescriptionElements.length - 1)
					)
				){
					if(printMode && (i == prescriptionElements.length - 1) && row.find(field.tagNameLowerCase()).length < 3){
						const missingColumns = 3 - row.find(field.tagNameLowerCase()).length;
						for(var pmi = 0; pmi < missingColumns; pmi++){
							row.append($(fieldWrapper))
						}
					}
					wrapper.append(row);
					row = $(rowWrapper);
				}
			});
			$(this).replaceWith(wrapper.html());
		})
	}

	$(document).ready(function(){
		// TODO: ADD OTHER FIELDS TO THE LIST...
		constructPatientDetails();


		performTemplateReplacement();

		$('[data-toggle="tooltip"]').tooltip();

		var textareaResizeHeight = function(e){
			var $this = e.target;
			$($this).css("height", "28px");
			$($this).css("overflow", 'hidden');
			if($($this).get(0).scrollHeight > 104){
				$($this).css("height", '104px');
				$($this).css("overflow", 'scroll');
			} else if($($this).get(0).scrollHeight > 0){
				$($this).css("height", $($this).get(0).scrollHeight+'px');
			}
		}

		var textareaResizeHeightDelayed = function(e){
			setTimeout(textareaResizeHeight(e), 0);
		}

		$(document).on('cut', '.prescription textarea', textareaResizeHeightDelayed);
		$(document).on('paste', '.prescription textarea', textareaResizeHeightDelayed);
		$(document).on('keydown', '.prescription textarea', textareaResizeHeightDelayed);
		$(document).on('keyup', '.prescription textarea', textareaResizeHeightDelayed);


		// keypress for clinical notes...
		var clinicalDateRequiredIfNotesNotEmpty = function(e){
			$(this).parents('tr').find('.note_date_label b').remove();
			if($(this).val()){
				$(this).parents('tr').find('.note_date_label').append('<b class="error">*</b>');
			}
		}
		$(document).on('cut', '[name^=clinical_note]', clinicalDateRequiredIfNotesNotEmpty);
		$(document).on('paste', '[name^=clinical_note]', clinicalDateRequiredIfNotesNotEmpty);
		$(document).on('keydown', '[name^=clinical_note]', clinicalDateRequiredIfNotesNotEmpty);
		$(document).on('keyup', '[name^=clinical_note]', clinicalDateRequiredIfNotesNotEmpty);
		

		$('#prescription_table').click(function(event){
			var noteToggleFunction = function(target){
				if($(target).hasClass('active')){
					$(target).removeClass('active')
					$(target).parents('td').find('textarea').attr("hidden", "");
					$(target).parents('td').find('.note_tooltip').html('[Click to Add Note]');
				} else {
					$(target).addClass('active')
					$(target).parents('td').find('textarea').removeAttr("hidden");
					$(target).parents('td').find('.note_tooltip').html('[Click to Delete Note]');
					$(target).parents('td').find('textarea').val("");
				}
			}
			if($(event.target).hasClass('note_tooltip')){
				noteToggleFunction($(event.target).prev().get(0))
			}
			if($(event.target).hasClass('glyphicon-pencil')){
				noteToggleFunction(event.target)
			}			
		});

		// prescription dropdown selectize
		mergeDrugsAvailableToDrugs({drugs: JSON.parse('<?php echo json_encode($drugs); ?>'), drugs_available: JSON.parse('<?php echo json_encode($drugs_available); ?>')});
		initPrescriptionDrugSelectize();

		initUpdatePatientValidations();
		initDefaultsConfigsElements();

		// Goto line no 2144
		$SBP = '';
		$DBP = '';
		$HB = '';
		$RBS = '';
		$dates = '';
		<?php foreach($vitals as $vital){
			$tmp = $vital->SBP;
			$SBP .=  !empty($tmp) ? $vital->SBP.',' : 'null,';
			$tmp = $vital->DBP;
			$DBP .= !empty($tmp) ? $vital->DBP.',' : 'null,';
			$tmp = $vital->Hb;
			$HB .= !empty($tmp) ? $vital->Hb.',' : 'null,';
			$tmp = $vital->RBS;
			$RBS .= !empty($tmp) ? $vital->RBS.',' : 'null,';
			$dates .= "'".$vital->DATE."'".',';
		} 
		$SBP = rtrim($SBP, ",");
		$DBP = rtrim($DBP, ",");
		$HB = rtrim($HB, ",");
		$RBS = rtrim($RBS, ",");
		$dates = rtrim($dates, ",");		
		?>
		
		var sbpdbp = $('#sbp_dbp');
		var sbp_dbp = new Chart(sbpdbp, {
    		type: 'line',
    		data: {
				datasets: [{
					label: 'SBP',
					data: [null, <?php echo $SBP; ?>],
					borderColor: 'red',
					fill: false,
					lineTension: 0
				}, {
					label: 'DBP',
					data: [null, <?php echo $DBP; ?>],
					// Changes this dataset to become a line
					borderColor: 'blue',
					fill: false,
					lineTension: 0
				}],
				labels: ['', <?php echo $dates; ?>]        		
    		}
		});
		var rbs_ctx = $('#rbs');
		var rbs = new Chart(rbs_ctx, {
    		type: 'line',
    		data: {
				datasets: [{
					label: 'RBS',
					data: [null, <?php echo $RBS; ?>],
					borderColor: 'blue',
					fill: false,
					lineTension: 0
				}],
				labels: ['',<?php echo $dates; ?>]        		
    		}
		});
		var hb_ctx = $('#hb');
		var hb = new Chart(hb_ctx, {
    		type: 'line',
    		data: {
				datasets: [{
					label: 'HB',
					data: [null, <?php echo $HB; ?>],
					borderColor: 'red',
					fill: false,
					lineTension: 0
				}],
				labels: ['',<?php echo $dates; ?>]        		
    		}
		});
	});
	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		var target = $(e.target).attr("href");
		$("#selected_tab").val(target);
	});
	<?php if($this->input->post('selected_tab')) { ?>
	$(function(){
		$('.nav-tabs a[href="<?php echo $this->input->post('selected_tab'); ?>"]').tab('show');
	});
	<?php } ?>
</script>
	
<div class="sr-only" id="print-div-all" style="width:100%;height:100%;"> 
			<?php $this->load->view('pages/print_layouts/patient_summary_all_visits');?>
</div>
<?php if(isset($patients) && count($patients)>0){ ?>
<div class="modal fade" id="myModal_<?php echo $patient->patient_id; ?>" tabindex="-1" role="dialog">
	<div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header bg-primary text-white">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Add Document</h4>
		</div>
		<div class="modal-body">
			<div>
			    <p class="bg-primary text-white">
				<span><b>Patient ID:</b> <?php echo $patient->patient_id;?>,&nbsp;</span>
				<span><b>Patient:</b> <?php echo $patient->first_name.$patient->last_name;?>,&nbsp;<?php echo $patient->age_years;?>&nbsp;/&nbsp;
				<?php echo $patient->gender;?>, &nbsp;<b>Related to:</b> <?php echo $patient->father_name.','.$patient->mother_name.','.$patient->spouse_name;?>,&nbsp;</span>
				<span><b>From:</b> <?php if(!!$patient->address && !!$patient->place) echo $patient->address.", ".$patient->place; else echo $patient->address." ".$patient->place;?>,&nbsp;</span>
				<span><b>Ph:</b> <?php echo $patient->phone;?>, &nbsp;</span>
				</p>	
			</div>	
			<?php echo form_open_multipart("register/update_patients",array('class'=>'form-horizontal','role'=>'form','id'=>'select_patient_'.$patient->visit_id, 'method'=>'POST')); ?>

			<input type="hidden" name="update_patients" value="true">
			<input type="text" class="sr-only" hidden value="<?php echo $patient->visit_id;?>" form="select_patient_<?php echo $patient->visit_id;?>" name="selected_patient" />
			<input type="text" class="sr-only" hidden value="<?php echo $patient->patient_id;?>" name="patient_id" />	
								
			<div class="form-group">
                <div class="col-md-3">
		        	<label for="document_date" class="control-label">Document Date*</label>
		        </div>
		        <div class="col-md-6">
		        	<input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" id="document_date" name="document_date" required />
		        </div>
        	</div>						
			<div class="form-group">
		    	<div class="col-md-3">			
			    	<label for="document_type">Document Type*</label>
				</div>
		        <div class="col-md-6">				
				<select required name="document_type" id="document_type" class="form-control">
					<option selected disabled value="">Select Document Type</option>
					<?php 
					foreach($patient_document_type as $type){
						echo "<option value='".$type->document_type_id."'";
						if($this->input->post('document_type') && $this->input->post('document_type') == $type->document_type_id) echo " selected ";
						echo ">".$type->document_type."</option>";
					}
					?>
				</select>
				</div>
			</div>
			<div class="form-group">
		        <div class="col-md-3">
	        		<label for="note" class="control-label">Note</label>
	        	</div>
	        	<div class="col-md-6">
	            	<input type="text" class="form-control" placeholder="note" id="note" name="note"/>
	        	</div>
	        </div>				
            <div class="form-group">
   	            <div class="col-md-3">
			        <label for="note" class="control-label">Upload Document*</label>
	        	</div>
	    	<div class="col-md-6">
	    		<input type="text" class="sr-only" hidden name="document_link"/>
                <input type="file" name="upload_file" id="upload_file" readonly="true"/>
            </div>
	        <div class="col-md-6">
		    <?php 
		    // Add text Tip for defaults
	        foreach($defaultsConfigs as $default){
	     	    if ($default->default_id=="pdoc_max_size"){
					$max_size = "Max Size " . $default->value . " " . $default->default_unit;
				}
				if ($default->default_id=="pdoc_allowed_types"){
	    		    $allowed_types = $default->default_unit ." " . $default->value;
				 }
	     	    if ($default->default_id=="pdoc_max_width"){
					$max_width = "Max Width " . $default->value . " " . $default->default_unit;
				}
				if ($default->default_id=="pdoc_max_height"){
	    		    $max_height = "Max Height " . $default->value ." " . $default->default_unit;
	         	}			  
			}
			echo nl2br($max_size . " : " . $allowed_types . "\n(If image is allowed: " . $max_width . " : " . $max_height . ")");
	        ?>
	     	</div>
	    	<div class="col-md-6">
                    <div id="moreImageUpload"></div>
                    <div style="clear:both;"></div><br>
                  <button class="btn btn-lg btn-primary btn-block"  type="submit" name="file_upload" value="Upload" class="btn btn-group btn-default btn-animated"  id="file_upload" >Submit</button>
            </div>

			</form> 
	    </div>
	</div>
	</div>
</div>
<?php } ?>
<template id="template-patient-quick-info" type="text/html">
    <div class="row alt">
        <div class="col-md-4 col-xs-6">
            <b>Patient ID: <?php echo $patient->patient_id; ?> </b>
            <b>
                <?php 
                    echo $patient->first_name." ".$patient->last_name.", "; 
                    if($patient->age_years!=0){ echo $patient->age_years." Yrs "; } 
                    if($patient->age_months!=0){ echo $patient->age_months." Mths "; }
                    if($patient->age_days!=0){ echo $patient->age_days." Days "; }
                    if($patient->age_years==0 && $patient->age_months == 0 && $patient->age_days==0) echo "0 Days";
                    echo "/".$patient->gender; 
                ?> 
            </b>
        </div>
        <div class="col-md-4 col-xs-6">
            <b><?php echo $patient->visit_type; ?> Number: </b><?php echo $patient->hosp_file_no;?>
        </div>
        <div class="col-md-4 col-xs-6">
            <b><?php if( $patient->visit_type == "IP") echo "Admit Date:"; else echo "Visit Date:";?></b>
            <?php echo date("d-M-Y", strtotime($patient->admit_date)).", ".date("g:ia", strtotime($patient->admit_time));?>
        </div>
    </div>
</template>
<script>
$(function(){
	$('[data-toggle="tooltip"]').tooltip();

	if(receiver && receiver.enable_outbound == "1"){
		$('.sms_button').show();
		var helpline = '<?php echo $hospital->helpline;?>';
		if(receiver.helpline){
			if (receiver.helpline == helpline) {
				$('#smsModal-helplinewithname-dropdown').append('<option value="'+receiver.helpline+'">'+receiver.note+' - '+receiver.helpline+'</option>');
			}
		}
		
		if(user_details.receiver_link){					
			$.each(user_details.receiver_link, function(i, d){
				if (d.helpline == helpline) {
					$('#smsModal-helplinewithname-dropdown').append('<option value="'+d.helpline+'">'+d.note+' - 				'+d.helpline+'</option>');					
				}
			})
			
		}
		
	}

	


	
});
</script>



