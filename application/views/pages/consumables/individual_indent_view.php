<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/metallic.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/theme.default.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.ptTimeSelect.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.ptTimeSelect.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript">
	$(function () {
		$("#from_date,#to_date").Zebra_DatePicker({ direction: false });
		$("#indent_time").ptTimeSelect();
	});
	function printDiv(i) {
		var content = document.getElementById(i);
		var pri = document.getElementById("ifmcontentstoprint").contentWindow;
		pri.document.open();
		pri.document.write(content.innerHTML);
		pri.document.close();
		pri.focus();
		pri.print();
	}	
</script>
<script>
	$(function () {
		$('#to_id  option[value="' + $('#from_id').val() + '"]').hide();
		$('#from_id').change(function () {
			$("#to_id option").show();
			var optionval = this.value;
			$('#to_id  option[value="' + optionval + '"]').hide();

		});
	});
	$(function () {
		$('#from_id  option[value="' + $('#to_id').val() + '"]').hide();
		$('#to_id').change(function () {
			$("#from_id option").show();
			var optionval = this.value;
			$('#from_id  option[value="' + optionval + '"]').hide();

		});
	});
</script>
<script type="text/javascript" src="assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="assets/js/jquery.timeentry.min.js"></script>
<script>
	function goBackToList(event)
	{
		window.location.assign('<?php echo base_url()."consumables/indent_reports/indents_list"?>');
	}
</script>
<script type="text/javascript">
	function enableDateTimeEdit(fieldId, indentId) {
		
		var dateTimeField = document.getElementById(fieldId);
		var currentDateTime = dateTimeField.innerText;

		// Store the previous value
		dateTimeField.dataset.previousValue = currentDateTime;
		dateTimeField.dataset.indentId = indentId;
		// Hide the edit icon for the corresponding field
		var editIcon = document.querySelector(`.${fieldId}-edit-icon`);
		if (editIcon) {
			editIcon.style.display = 'none';
		}

		// Replace the content with an input field for editing
		dateTimeField.innerHTML = `<input type="datetime-local" id="${fieldId}-editDateTime" value="${currentDateTime}">&nbsp;
									<button class="btn btn-primary save-button" onclick="saveDateTime('${fieldId}')">Save</button>
									<button class="btn btn-secondary cancel-button" onclick="cancelDateTimeEdit('${fieldId}')">Cancel</button>`;
		document.getElementById(`${fieldId}-editDateTime`).focus();
	}

	function saveDateTime(fieldId) 
	{
		var editedDateTime = document.getElementById(`${fieldId}-editDateTime`).value;
		// Parse the input date
		var parsedDate = new Date(editedDateTime);

		// Format the date to "yyyy-MM-dd hh:mm:ss"
		var formattedDateTime = parsedDate.getFullYear() + '-' +
			('0' + (parsedDate.getMonth() + 1)).slice(-2) + '-' +
			('0' + parsedDate.getDate()).slice(-2) + ' ' +
			('0' + parsedDate.getHours()).slice(-2) + ':' +
			('0' + parsedDate.getMinutes()).slice(-2) + ':00';

		var indentId = document.getElementById(fieldId).dataset.indentId;

		// Update the displayed Date Time for the corresponding field
		var dateTimeField = document.getElementById(fieldId);
		dateTimeField.innerText = formattedDateTime;

		// Remove the input field and Save/Cancel buttons for the corresponding field
		cleanUpDateTimeEdit(fieldId);

		// Call the updatedb function with the formatted date
		updatedb(fieldId, formattedDateTime, indentId);
	}

	function cancelDateTimeEdit(fieldId) {
		// Restore the previous value for the corresponding field
		var dateTimeField = document.getElementById(fieldId);
		var previousValue = dateTimeField.dataset.previousValue;
		dateTimeField.innerText = previousValue;

		// Remove the input field and Save/Cancel buttons for the corresponding field
		cleanUpDateTimeEdit(fieldId);
	}

	function cleanUpDateTimeEdit(fieldId) {
		// Show the edit icon for the corresponding field
		var editIcon = document.querySelector(`.${fieldId}-edit-icon`);
		if (editIcon) {
			editIcon.style.display = 'inline';
		}

		// Remove the input field and Save/Cancel buttons for the corresponding field
		var inputField = document.getElementById(`${fieldId}-editDateTime`);
		if (inputField) {
			inputField.parentNode.removeChild(inputField);
		}

		var saveButton = document.querySelector(`.${fieldId}-save-button`);
		if (saveButton) {
			saveButton.parentNode.removeChild(saveButton);
		}

		var cancelButton = document.querySelector(`.${fieldId}-cancel-button`);
		if (cancelButton) {
			cancelButton.parentNode.removeChild(cancelButton);
		}
	}

	function enableDateEdit(fieldId, indentId, itemId) 
	{
		var dateField = document.getElementById(`${fieldId}_${indentId}_${itemId}`);
		var currentDate = dateField.innerText;
		dateField.dataset.previousValue = currentDate;
		dateField.dataset.indentId = indentId;
		var editIcon = document.querySelector(`.${fieldId}_${indentId}_${itemId}-edit-icon`);
		if (editIcon) {
			editIcon.style.display = 'none';
		}
		dateField.innerHTML = `<input type="date" id="${fieldId}_${indentId}_${itemId}-editDate" value="${currentDate}">
								<button class="btn btn-primary save-button" onclick="savedate('${fieldId}','${indentId}','${itemId}')">Save</button>
								<button class="btn btn-secondary cancel-button" onclick="canceldateedit('${fieldId}','${indentId}','${itemId}')">Cancel</button>`;
		document.getElementById(`${fieldId}_${indentId}_${itemId}-editInput`).focus();
	}
	function savedate(fieldId, indentId, itemId) 
	{
		var editedDate = document.getElementById(`${fieldId}_${indentId}_${itemId}-editDate`).value;
		var indentId = document.getElementById(`${fieldId}_${indentId}_${itemId}`).dataset.indentId;
		var dateField = document.getElementById(`${fieldId}_${indentId}_${itemId}`);
		dateField.innerText = editedDate;
		cleanupdateedit(fieldId, indentId, itemId);
		updatedbitemid(fieldId, editedDate, indentId,itemId);
	}
	function canceldateedit(fieldId, indentId, itemId) 
	{
		var dateField = document.getElementById(`${fieldId}_${indentId}_${itemId}`);
		var previousValue = dateField.dataset.previousValue;
		dateField.innerText = previousValue;
		cleanupdateedit(fieldId, indentId, itemId);
	}
	function cleanupdateedit(fieldId, indentId, itemId)
	{
		var editIcon = document.querySelector(`.${fieldId}_${indentId}_${itemId}-edit-icon`);
		if (editIcon) {
			editIcon.style.display = 'inline';
		}
		var inputField = document.getElementById(`${fieldId}_${indentId}_${itemId}-editDate`);
		if (inputField) {
			inputField.parentNode.removeChild(inputField);
		}

		var saveButton = document.querySelector(`.${fieldId}_${indentId}_${itemId}-save-button`);
		if (saveButton) {
			saveButton.parentNode.removeChild(saveButton);
		}

		var cancelButton = document.querySelector(`.${fieldId}_${indentId}_${itemId}-cancel-button`);
		if (cancelButton) {
			cancelButton.parentNode.removeChild(cancelButton);
		}
	}
	function enableEdit(fieldId, indentId, itemId) 
	{
        var field = document.getElementById(`${fieldId}_${indentId}_${itemId}`);
		var currentText = field.innerText;
        field.dataset.previousValue = currentText;
        field.dataset.indentId = indentId;
        field.dataset.itemId = itemId;
        var editIcon = document.querySelector(`.${fieldId}_${indentId}_${itemId}-edit-icon`);
        if (editIcon) {
            editIcon.style.display = 'none';
        }
        field.innerHTML = `<input type="text" id="${fieldId}_${indentId}_${itemId}-editInput" value="${currentText}">
                            <button class="btn btn-primary save-button" onclick="saveedit('${fieldId}', '${indentId}', '${itemId}')">Save</button>
                            <button class="btn btn-secondary cancel-button" onclick="canceledit('${fieldId}', '${indentId}' ,'${itemId}')">Cancel</button>`;
        document.getElementById(`${fieldId}_${indentId}_${itemId}-editInput`).focus();
    }
    function saveedit(fieldId, indentId, itemId) 
	{
        var editedText = document.getElementById(`${fieldId}_${indentId}_${itemId}-editInput`).value;
        var indentId = document.getElementById(`${fieldId}_${indentId}_${itemId}`).dataset.indentId;
        var field = document.getElementById(`${fieldId}_${indentId}_${itemId}`);
        field.innerText = editedText;
        cleanupedit(fieldId, indentId, itemId);
        updatedbitemid(fieldId, editedText, indentId, itemId);
    }
    function canceledit(fieldId, indentId, itemId) 
	{
        var field = document.getElementById(`${fieldId}_${indentId}_${itemId}`);
        var previousValue = field.dataset.previousValue;
        field.innerText = previousValue;
        cleanupedit(fieldId, indentId, itemId);
    }
    function cleanupedit(fieldId, indentId, itemId) 
	{
        var editIcon = document.querySelector(`.${fieldId}_${indentId}_${itemId}-edit-icon`);
        if (editIcon) {
            editIcon.style.display = 'inline';
        }
        var inputField = document.getElementById(`${fieldId}_${indentId}_${itemId}-editInput`);
        if (inputField) {
            inputField.parentNode.removeChild(inputField);
        }
        var saveButton = document.querySelector('.save-button');
        if (saveButton) {
            saveButton.parentNode.removeChild(saveButton);
        }
        var cancelButton = document.querySelector('.cancel-button');
        if (cancelButton) {
            cancelButton.parentNode.removeChild(cancelButton);
        }
    }
</script>
<script type="text/javascript">
    function updatedb(fieldId, newValue, indentId) 
	{
        $.ajax({
            url: '<?php echo base_url("consumables/indent_reports/save_data"); ?>',
            type: 'POST',
            data: {
                fieldId: fieldId,
                newValue: newValue,
                indentId: indentId
            },
            success: function(response) {
                //console.log(response);
				location.reload();
            },
            error: function(error) {
                console.error(error);
            }
        });
    }
	function updatedbitemid(fieldId, newValue, indentId, itemId) 
	{
        $.ajax({
            url: '<?php echo base_url("consumables/indent_reports/save_item_data"); ?>',
            type: 'POST',
            data: {
                fieldId: fieldId,
                newValue: newValue,
                indentId: indentId,
                itemId: itemId
            },
            success: function(response) {
                //console.log(response);
				location.reload();
            },
            error: function(error) {
                console.error(error);
            }
        });
    }
</script>
<style type="text/css">
	#details_container {
		max-width: 900px;
		overflow-y: auto;
		max-height: 700px;

		overflow-x: scroll;
	}

	#details_table {
		width: 1000px;
		min-width: 950px;

		/* overflow-y: auto; */
	}
	.issue_invoice {
		max-width: 900px;
		overflow-y: auto;
		max-height: 700px;

		overflow-x: scroll;
	}

	#issue_invoice_table {
		width: 1000px;
		min-width: 950px;

		/* overflow-y: auto; */
	}
	#footer { position: fixed; bottom: 0; width: 100%; } 
	#footer p {
		text-align: center;
		margin-top: 2%;
	}
</style>

<?php if (count($issue_details) > 0) { 
	$single_issue = $issue_details[0];
	?>

<iframe id="ifmcontentstoprint" style="height: 0px; width: 0px; position: absolute;display:none"></iframe>

<?php echo form_open('consumables/indent_issue/indent_issued', array('class' => 'form-group', 'role' => 'form')); ?>
<!-- Issue Print Form opened-->


	<div class="col-md-4 col-md-offset-3">
	<div class="container">
		<div class="container">

			<div class="row bg-success">
				<div class="col-md-8 bg-success"  style="background-color: #d6e9c6; color: green;">
					<h1>Indent</h1><!-- Heading -->
				</div>
			</div>
		</div>		
				
		<div class="container" style="padding: 5px 5px; margin: 20px 5px;">
			<div class="row" style="padding: 5px 0px;">
				<div class="col-md-4"><!--Indent id label-->
					<b>Indent Id : </b>
					<?php echo " " . $single_issue->indent_id; ?>
				</div><!-- End of indent_id label-->
				<div class="col-md-4"><!--Indent id label-->
					<?php
					$status_color = "text-success";
					if ($single_issue->indent_status == "Indented") {
						$status_color = "text-warning";
					} else if ($single_issue->indent_status == "Approved") {
						$status_color = "text-primary";
					} else if ($single_issue->indent_status == "Rejected") {
						$status_color = "text-danger";
					}
					?>
						<b>Approval status : </b>
						<b class="<?php echo $status_color; ?>"><?php echo " ". $single_issue->indent_status; ?></b>
				</div>
			</div>
			<div class="row" style="padding:5px 0px;">
				<div class="col-md-4"><!-- From_party label-->
					<b>Indent From Party : </b>
					<?php echo " " . $single_issue->from_party; ?>
				</div><!-- End of from_party label -->

				<div class="col-md-4"><!-- To party label -->
					<b>Indent To Party : </b>
					<?php echo " " . $single_issue->to_party; ?>
				</div><!-- End of to party label-->
			</div>
			<?php
				$f = $functions;
				$access = 0;
				foreach($f as $function)
				{
					if($function->user_function=='Consumables')
					{
						$access = $function->edit;
						break;
					} 
				}
			?>
		</div>

		<div class="container">
		<div class="row">
			<?php if($single_issue->indent_status != "Issued") {?>
			<div class="col-md-8" style="margin-left:33px">
				<div class="form-group" id="details_container">
					<table id="details_table" class="table table-bordered table-striped">
						<thead>
							<th class="col-md-1" style="text-align:center">#</th>
							<th class="col-md-3" style="text-align:center">Items</th>
							<th class="col-md-1" style="text-align:center">Quantity Ordered</th>
							<th class="col-md-1" style="text-align:center">Quantity Approved</th>
							<th class="col-md-1" style="text-align:center">Quantity Issued</th>
							<th class="col-md-5" style="text-align:center">Notes</th>
						</thead>
						<tbody>
							<?php
							$i = 1;
							foreach ($issue_details as $all_issue) { ?>
								<tr>
									<td>
										<center>
											<?php echo $i++; ?>
										</center>
									</td>
									<td align="left">
										<?php echo $all_issue->item_name . "-" . $all_issue->item_form . "-" . $all_issue->item_type . $all_issue->dosage . $all_issue->dosage_unit; ?>
									</td>
									<td align="right">
										<?php echo $all_issue->quantity_indented ?>
									</td>
									<td align="right">
										<?php echo $all_issue->quantity_approved ?>
									</td>
									<td align="right">
										<?php echo $all_issue->quantity_issued ?>
									</td>
									<td align="right">
										<?php echo $all_issue->item_note ?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
			<?php } else { ?>

				<?php 
					$total_costs = array();
					foreach($issue_details as $all_issue){
						if(isset($total_costs[$all_issue->indent_item_id])){
							$total_costs[$all_issue->indent_item_id] += $all_issue->cost;
						}else{
							$total_costs[$all_issue->indent_item_id] = $all_issue->cost;
						}
					}
					
					?>
				<div class="issue_invoice">
					<?php
						$f = $functions;
						$access = 0;
						foreach($f as $function)
						{
							if($function->user_function=='Consumables')
							{
								$access = $function->edit;
        						break;
							} 
						}
					?>
					    
						<table id="issue_invoice_table" class="table" style="border: 2px solid #ccc;">
							<thead>
								
								<th>Item Name</th>
								<th>Indented</th>
								<th>Approved</th>
								<th>Issued</th>
								
								<th>Batch</th>
								<th>Mfg. Date</th>
								<th>Expiry Date</th>

								<th>Cost(Rs.)</th>
								<th>Patient ID</th>

								<th>Note</th>
								<th>GTIN Code</th>
							</thead>

							<tbody id="table-body">
								<!-- name="indent_item_$indent_item->id" -->
								<?php
								$prev = null;
								$i = 1;
								foreach ($issue_details as $all_int) {
								if($prev !== $all_int->indent_item_id){ ?>
									<tr name="<?php echo "indent_item_" . $all_int->indent_item_id; ?>"
										class="warning indent_item">
										
										<td class="item_name">
											<b><?php echo $all_int->item_name . "-" . $all_int->item_type . "-" . $all_int->item_form . "-" . $all_int->dosage . $all_int->dosage_unit;?></b>
										</td>
										<td><b><?= $all_int->quantity_indented; ?></b></td>
										<td><b><?= $all_int->quantity_approved; ?></b></td>
										<td><b><?= $all_int->quantity_issued; ?></td>
										<!-- <td></td> -->
										<td></td>
										<td></td>
										<td></td>
										<td><b><span id=<?php echo "total_cost_$all_int->indent_item_id"; ?>><?= $total_costs[$all_int->indent_item_id]; ?></span></b></td>

										<td></td>
										<td></td>
										<td></td>
										

										<!-- name="add_$indent_item->id" -->

									</tr>
									<tr name="<?php echo "indent_item_" . $all_int->indent_item_id; ?>"
										class="warning indent_item">
										
										<td class="item_name">
											<i><?php echo $all_int->item_name . "-" . $all_int->item_type . "-" . $all_int->item_form . "-" . $all_int->dosage . $all_int->dosage_unit;?></i>
										</td>
										<td></td>
										<td></td>
										<td><?= $all_int->quantity; ?></td>
										<td>
											<span id="batch_<?php echo $single_issue->indent_id; ?>_<?php echo $all_int->item_id; ?>">
												<?= $all_int->batch; ?>
											</span>
											<?php if($access==1)
											{
											?>
    										<i class="fa fa-pencil batch_<?php echo $single_issue->indent_id; ?>_<?php echo $all_int->item_id; ?>-edit-icon" onclick="enableEdit('batch','<?php echo $single_issue->indent_id; ?>','<?php echo $all_int->item_id; ?>')"></i>
											<?php } ?>
										</td>
										<td>
											<span id="mfgDate_<?php echo $single_issue->indent_id; ?>_<?php echo $all_int->item_id; ?>">
												<?= strtotime($all_int->manufacture_date) ? date("d-M-Y", strtotime($all_int->manufacture_date)): "NA"; ?>
											</span>
											<?php if($access==1)
											{
											?>
    										<i class="fa fa-pencil mfgDate_<?php echo $single_issue->indent_id; ?>_<?php echo $all_int->item_id; ?>-edit-icon" onclick="enableDateEdit('mfgDate', '<?php echo $single_issue->indent_id; ?>','<?php echo $all_int->item_id; ?>')"></i>
											<?php } ?>
										</td>
										<td>
											<span id="expiryDate_<?php echo $single_issue->indent_id; ?>_<?php echo $all_int->item_id; ?>">
												<?= strtotime($all_int->expiry_date) ? date("d-M-Y", strtotime($all_int->expiry_date)): "NA"; ?>
											</span>
											<?php if($access==1)
											{
											?>	
    										<i class="fa fa-pencil expiryDate_<?php echo $single_issue->indent_id; ?>_<?php echo $all_int->item_id; ?>-edit-icon" onclick="enableDateEdit('expiryDate', '<?php echo $single_issue->indent_id; ?>','<?php echo $all_int->item_id; ?>')"></i>
											<?php } ?>
										</td>
										<td>
											<span id="cost_<?php echo $single_issue->indent_id; ?>_<?php echo $all_int->item_id; ?>">
												<?= $all_int->cost;?>
											</span>
											<?php if($access==1)
											{
											?>
    										<i class="fa fa-pencil cost_<?php echo $single_issue->indent_id; ?>_<?php echo $all_int->item_id; ?>-edit-icon" onclick="enableEdit('cost', '<?php echo $single_issue->indent_id; ?>','<?php echo $all_int->item_id; ?>')"></i>
											<?php } ?>
										</td>

										<td><?= $all_int->patient_id ? $all_int->patient_id: " ";?></td>
										<td>
											<span id="note_<?php echo $all_int->indent_item_id; ?>_<?php echo $all_int->item_id; ?>">
												<?php echo $all_int->item_note;?>
											</span>
											<?php if($access==1)
											{
											?>
    										<i class="fa fa-pencil note_<?php echo $all_int->indent_item_id; ?>_<?php echo $all_int->item_id; ?>-edit-icon" onclick="enableEdit('note', '<?php echo $all_int->indent_item_id; ?>','<?php echo $all_int->item_id; ?>')"></i>
											<?php } ?>
											<!-- <?= $all_int->note; ?> -->
										</td>
										<td><?= $all_int->gtin_code;?></td>
										

										<!-- name="add_$indent_item->id" -->

									</tr>
									
									<?php } else { ?>
										<tr name="<?php echo "indent_item_" . $all_int->indent_item_id; ?>"
										class="warning indent_item">
										
										<td class="item_name">
											<i><?php echo $all_int->item_name . "-" . $all_int->item_type . "-" . $all_int->item_form . "-" . $all_int->dosage . $all_int->dosage_unit;?></i>
										</td>
										<td></td>
										<td></td>
										<td><?= $all_int->quantity; ?></td>
										<td>
											<span id="batch_<?php echo $single_issue->indent_id; ?>_<?php echo $all_int->item_id; ?>">
												<?= $all_int->batch; ?>
											</span>
											<?php if($access==1)
											{
											?>
    										<i class="fa fa-pencil batch_<?php echo $single_issue->indent_id; ?>_<?php echo $all_int->item_id; ?>-edit-icon" onclick="enableEdit('batch', '<?php echo $single_issue->indent_id; ?>', '<?php echo $all_int->item_id; ?>')"></i>
											<?php } ?>
										</td>
										<td>
											<span id="mfgDate_<?php echo $single_issue->indent_id; ?>_<?php echo $all_int->item_id; ?>">
												<?= strtotime($all_int->manufacture_date) ? date("d-M-Y", strtotime($all_int->manufacture_date)): "NA"; ?>
											</span>
											<?php if($access==1)
											{
											?>
    										<i class="fa fa-pencil mfgDate_<?php echo $single_issue->indent_id; ?>_<?php echo $all_int->item_id; ?>-edit-icon" onclick="enableDateEdit('mfgDate', '<?php echo $single_issue->indent_id; ?>','<?php echo $all_int->item_id; ?>')"></i>
											<?php } ?>
										</td>
										<td>
											<span id="expiryDate_<?php echo $single_issue->indent_id; ?>_<?php echo $all_int->item_id; ?>">
												<?= strtotime($all_int->expiry_date) ? date("d-M-Y", strtotime($all_int->expiry_date)): "NA"; ?>
												</span>
											<?php if($access==1)
											{
											?>
    										<i class="fa fa-pencil expiryDate_<?php echo $single_issue->indent_id; ?>_<?php echo $all_int->item_id; ?>-edit-icon" onclick="enableDateEdit('expiryDate', '<?php echo $single_issue->indent_id; ?>','<?php echo $all_int->item_id; ?>')"></i>
											<?php } ?>
										</td>
										<td>
											<span id="cost_<?php echo $single_issue->indent_id; ?>_<?php echo $all_int->item_id; ?>">
												<?= $all_int->cost;?>
											</span>
											<?php if($access==1)
											{
											?>
    										<i class="fa fa-pencil cost_<?php echo $single_issue->indent_id; ?>_<?php echo $all_int->item_id; ?>-edit-icon" onclick="enableEdit('cost', '<?php echo $single_issue->indent_id; ?>','<?php echo $all_int->item_id; ?>')"></i>
											<?php } ?>
										</td>

										<td><?= $all_int->patient_id ? $all_int->patient_id: " ";?></td>
										<td>
											<span id="note_<?php echo $all_int->indent_item_id; ?>_<?php echo $all_int->item_id; ?>">
												<?php echo $all_int->item_note;?>
											</span>
											<?php if($access==1)
											{
											?>
    										<i class="fa fa-pencil note_<?php echo $all_int->indent_item_id; ?>_<?php echo $all_int->item_id; ?>-edit-icon" onclick="enableEdit('note', '<?php echo $all_int->indent_item_id; ?>','<?php echo $all_int->item_id; ?>')"></i>
											<?php } ?>
											<!-- <?= $all_int->note; ?> -->
										</td>
										<td><?= $all_int->gtin_code;?></td>
										

										<!-- name="add_$indent_item->id" -->

									</tr>



									<?php } 
										$prev = $all_int->indent_item_id;

									
									?>

									<?php
									$i++;
								} ?>


							</tbody>

						</table>
					</div>


				<?php } ?>
		</div>
		</div>
		<div class="container">
			<div></br>
				<b style="float:left;">Note:</b><p style="float:right;margin-right:70%!important;"><?php echo $single_issue->indent_note; ?></p>
			</div></br></br>
			<div class="span9">
				<div class="span3">
					<div class="col-md-12"><!-- Indenter name -->
						<b style="margin-left:-15px;">
							<?php echo "Indented" . " " . "by :"; ?>
						</b>
						<?php echo $single_issue->order_first . " " . $single_issue->order_last; ?> at
						<span id="indentDateTime">
							<?php echo " " . date("d-M-Y g:i A", strtotime($single_issue->indent_date)); ?>
						</span>&nbsp;&nbsp;
						<?php if($access==1)
							{
						?>
							<i class="fa fa-pencil indentDateTime-edit-icon" onclick="enableDateTimeEdit('indentDateTime','<?php echo $single_issue->indent_id; ?>')"></i>
						<?php } ?></br></br>
					</div><!-- End of indenter name-->
				</div>
				<div class="span3">
					<div class="col-md-12"><!-- Approver name-->
						<b style="margin-left:-15px;">
							<?php echo "Approved" . " " . "by :"; ?>
						</b>
						<?php echo $single_issue->approve_first . " " . $single_issue->approve_last; ?> at
						<span id="approvalDateTime">
							<?php 
								if ($single_issue->indent_status == "Approved" || $single_issue->indent_status == "Issued") {
									echo " " . date("d-M-Y g:i A", strtotime($single_issue->approve_date_time));}
								else { 
									echo " NA";
								} ?>
						</span>&nbsp;&nbsp;
						<?php if($access==1)
							{
						?>
							<i class="fa fa-pencil approvalDateTime-edit-icon" onclick="enableDateTimeEdit('approvalDateTime','<?php echo $single_issue->indent_id; ?>')"></i>
						<?php } ?></br></br>
					</div><!-- End of approver name-->
				</div>
				<div class="span3">
					<div class="col-md-12"><!-- Issuer name-->
						<b style="margin-left:-15px;">
							<?php echo "Issued" . " " . "by :"; ?>
						</b>
						<?php echo $single_issue->issue_first . " " . $single_issue->issue_last; ?> at
						<span id="issueDateTime">
						<?php 
							if ($single_issue->indent_status == "Issued") {
								echo " " . date("d-M-Y g:i A", strtotime($single_issue->issue_date_time));}
							else { 
								echo " NA";
							} ?>
						</span>&nbsp;&nbsp;
						<?php if($access==1)
							{
						?>
							<i class="fa fa-pencil issueDateTime-edit-icon" onclick="enableDateTimeEdit('issueDateTime', '<?php echo $single_issue->indent_id; ?>')"></i>
						<?php } ?></br></br>
					</div><!-- End of issuer name-->
				</div>
				<!-- <div class="span3">
					<div class="col-md-12">
						<b>
							<?php echo "Issuer Signature :"; ?>
						</b></br></br>
					</div>
				</div> -->
			</div>
		</div>						
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
					<button class="btn btn-primary" type="button" name="print" id="print"
							onclick=goBackToList()>Go to indents list</button>
					<button class="btn btn-primary" type="button" name="back_to_list" id="back_to_list"
							onclick="printDiv('print-div-2')">Print</button>
			<?php 
				foreach ($functions as $f) 
				  {
					if ($f->user_function == "delete_indent") 
					{ 
			?>
					<a data-id="<?php echo $single_issue->indent_id; ?>" class="btn btn-danger" id="del" >Delete Indent</a>
					<input type="hidden" value="<?php echo $single_issue->indent_status; ?>" name="post_indent_status" id="post_indent_status">
			<?php } } ?>

			</div>
			<div class="col-md-4"></div>
			<script>
				$(document).on("click",'#del',function(){
					var $btn = $(this);
					var indent_id = $btn.attr("data-id");
					var indent_status = $("#post_indent_status").val();
					conf = confirm('Are you sure you want to delete this indent?');
					if(conf==true)
					{
						$.ajax({
								type: "POST",
								url: "<?php echo base_url('consumables/indent_reports/delete_indent_id'); ?>",
								data: {indent_id:indent_id,indent_status:indent_status},
								success: function(response) 
								{
									alert("Indent deleted successfully");
									window.location.href = '<?php echo base_url('consumables/indent_reports/indents_list'); ?>';
								},
								error: function(error) {
									//console.error("Error:", error);
								}
							});
					}else
					{
						return false;
					}
				})
			</script>
		</div>
	</div>
</div>
</div>
</div>
</div>

<?php echo form_close(); ?><!-- End of  Issue Print form -->

<?php } else { ?>


	<div class="container" style="margin: 20vw 10vw">
		<div class="row">
			<div class="col-md col-md-offset-2">
				<p class="text-muted" style="font-size:2vw;">No indent corresponding to provided ID.</p>
			</div>
		</div>
	</div>

<?php } ?>