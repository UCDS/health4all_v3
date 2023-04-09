<script type="text/javascript">
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



<iframe id="ifmcontentstoprint" style="height: 0px; width: 0px; position: absolute;display:none"></iframe>

<?php echo form_open('consumables/indent/add_indent', array('role' => 'form')) ?>
<div class="col-md-12 col-md-offset-1">
	<?php if ($register[0]->indent_status == 'Issued') { ?>
		<center>
			<div class="alert alert-info">
				<h4>Indent added/approved/issued Succesfully</h4>
			</div>
		</center>
	<?php } else { ?>
		<center>
			<div class="alert alert-info">
				<h4>Indent added Succesfully</h4>
			</div>
		</center>
	<?php } ?>
</div>

<div class="col-xs-4 col-md-offset-2">
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<div class="panel panel-success">
					<div class="panel-heading">
						<center>
							<h3>Indent</h3>
						</center>
					</div>
					<div class="panel-body">
						<form class="span9">
							<div class="span3">
								<div class="col-md-6"> <!--Indent Id-->
									<label><b>Indent Id:</b>
										<?php 
										log_message("info", "SAIRAM reg: ".json_encode($register[0]));
										echo $register[0]->indent_id; ?>
									</label>
								</div> <!--end Indent Id-->
								<div class="span3"> <!-- From party-->
									<div class="col-md-6">
										<label><b>Indent From Party:</b>
											<?php echo $register[0]->from_party; ?>
										</label>
									</div>
								</div> <!--end of From party-->
								<div class="col-md-6"> <!--Indent Date-->
									<label><b>Date:</b>
										<?php echo date("d-M-Y g:i A", strtotime($register[0]->indent_date)); ?>
									</label>
								</div> <!--end of Indent Date-->
							</div>
							<div class="span3"> <!-- To party -->
								<div class="col-md-6">
									<label><b>Indent To Party:</b>
										<?php echo $register[0]->to_party; ?>
									</label>
								</div>
							</div> <!--end of To party-->
						</form></br>

						<div class="container">
							<div class="row">
								<center>
									<div class="col-md-8">
										<table class="table table-bordered table-striped">
											<thead>
												<th class="col-md-1" style="text-align:center" rowspan="3">#</th>
												<th class="col-md-3" style="text-align:center" rowspan="3">Items</th>
												<th class="col-md-1" style="text-align:center" rowspan="3">Quantity</th>
												<th class="col-md-2" style="text-align:center" rowspan="3">Note</th>
											</thead>
											<tbody>
												<?php $i = 1;
												$prev = null;
												foreach ($register as $r) { 
													
													?>
													<tr>
														<td align="center">
															<?= $i++; ?>
														</td>
														<td>
															<?php echo $r->item_name . "-" . $r->item_form . "-" . $r->item_type . "-" . $r->dosage . $r->dosage_unit ?>
														</td>
														<td align="right">
															<?php echo $r->quantity_indented ?>
														</td>
														<td align="right">
															<?php echo $r->item_note ?>
														</td>
													</tr>
												<?php 
													
											} ?>
											</tbody>
										</table>
									</div>
								</center>
							</div>
							<div class="row">
								<div class="col-md-9">
									<p><b>Note: </b><br>
										<?php
										echo $register[0]->indent_note
											?>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<div class="panel panel-success">
					<div class="panel-footer">
						<?php if ($register[0]->indent_status == 'Issued') { ?>
							<b>Indented/Approved/Issued by :</b>
							<?php echo $register[0]->order_first . " " . $register[0]->order_last; ?>
						<?php } else { ?>
							<b>Indented by :</b>
							<?php echo $register[0]->order_first . " " . $register[0]->order_last; ?>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-6">

				<center><a
						href="<?= base_url() . "consumables/indent_reports/indents_list_detailed/" . $register[0]->indent_id; ?>"><button
							type="button" class="btn btn-primary " autofocus>View in detail</button></a></center>
			</div>
			<div class="col-md-3">

				<center><button type="button" class="btn btn-primary " onClick="printDiv('print-div-2')"
						autofocus>Print</button></center>
			</div>
		</div>
	</div>
</div>

<?php // } ?>

<?php echo form_close(); ?>