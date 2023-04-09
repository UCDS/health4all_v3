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

			</div>
			<div class="row" style="padding:5px 0px;">
				<div class="col-md-4"><!-- From_party label-->
					<b>Indent From Party : </b>
					<?php echo " " . $single_issue->from_party; ?>
				</div><!-- End of from_party label -->

				<div class="col-md-4" style="padding:5px 0px;"><!-- To party label -->
					<b>Indent To Party : </b>
					<?php echo " " . $single_issue->to_party; ?>
				</div><!-- End of to party label-->
			</div>
			<div class="row">
				<div class="col-md-5"  style="padding:5px 0px; margin-left: 15px;"><!-- Date Time label -->
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
				</div><!-- End of date time label-->
			</div>

			<div class="row">
				<div class="col-md-5"  style="padding:5px 0px; margin-left: 15px;"><!-- Date Time label -->
					<b>Indent Date Time : </b>
					<?php echo " " . date("d-M-Y g:i A", strtotime($single_issue->indent_date)); ?>
				</div><!-- End of date time label-->
			</div>
			<div class="row">
				<div class="col-md-5"  style="padding:5px 0px; margin-left: 15px;"><!-- Date Time label -->
					<b>Approval Date Time : </b>
					<?php 
						if ($single_issue->indent_status == "Approved" || $single_issue->indent_status == "Issued") {
							echo " " . date("d-M-Y g:i A", strtotime($single_issue->approve_date_time));}
						else { 
							echo " NA";
						} ?>
				</div><!-- End of date time label-->
			</div>
			<div class="row">
				<div class="col-md-5"  style="padding:5px 0px; margin-left: 15px;"><!-- Date Time label -->
					<b>Issue Date Time : </b>
					<?php 
						if ($single_issue->indent_status == "Issued") {
							echo " " . date("d-M-Y g:i A", strtotime($single_issue->issue_date_time));}
						else { 
							echo " NA";
						} ?>
				</div><!-- End of date time label-->
			</div>
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
										<td><?= $all_int->item_note; ?></td>
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
										<td><?= $all_int->batch; ?></td>
										<td><?= strtotime($all_int->manufacture_date) ? date("d-M-Y", strtotime($all_int->manufacture_date)): "NA"; ?></td>
										<td><?= strtotime($all_int->expiry_date) ? date("d-M-Y", strtotime($all_int->expiry_date)): "NA"; ?></td>
										<td><?= $all_int->cost;?></td>

										<td><?= $all_int->patient_id ? $all_int->patient_id: " ";?></td>
										<td><?= $all_int->note; ?></td>
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
										<td><?= $all_int->batch; ?></td>
										<td><?=  strtotime($all_int->manufacture_date)? date("d-M-Y", strtotime($all_int->manufacture_date)): "NA"; ?></td>
										<td><?=  strtotime($all_int->expiry_date)? date("d-M-Y", strtotime($all_int->expiry_date)): "NA"; ?></td>
										<td><?= $all_int->cost;?></td>

										<td><?= $all_int->patient_id ? $all_int->patient_id: " ";?></td>
										<td><?= $all_int->note; ?></td>
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
			<div>
				<b>Note:</b>
				<p><?php echo $single_issue->indent_note; ?></p>
			</div>
			<div class="span9">
				<div class="span3">
					<div class="col-md-12"><!-- Indenter name -->
						<b>
							<?php echo "Indented" . " " . "by :"; ?>
						</b>
						<?php echo $single_issue->order_first . " " . $single_issue->order_last; ?></br></br>
					</div><!-- End of indenter name-->
				</div>
				<div class="span3">
					<div class="col-md-12"><!-- Approver name-->
						<b>
							<?php echo "Approved" . " " . "by :"; ?>
						</b>
						<?php echo $single_issue->approve_first . " " . $single_issue->approve_last; ?></br></br>
					</div><!-- End of approver name-->
				</div>
				<div class="span3">
					<div class="col-md-12"><!-- Issuer name-->
						<b>
							<?php echo "Issued" . " " . "by :"; ?>
						</b>
						<?php echo $single_issue->issue_first . " " . $single_issue->issue_last; ?></br></br>
					</div><!-- End of issuer name-->
				</div>
				<div class="span3">
					<div class="col-md-12"><!-- Issuer signature-->
						<b>
							<?php echo "Issuer Signature :"; ?>
						</b></br></br>
					</div><!-- End of issuer signature-->
				</div>
			</div>
		</div>						
		<div class="row">
			<div class="col-md-4">
				

					<button class="btn btn-primary" type="button" name="print" id="print"
							onclick=goBackToList()>Go to indents list</button>
				
			</div>
			<div class="col-md-4">
					

					<button class="btn btn-primary" type="button" name="back_to_list" id="back_to_list"
							onclick="printDiv('print-div-2')">Print</button>
				
			</div>
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