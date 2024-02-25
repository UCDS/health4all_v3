<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/selectize.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.selectize.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/metallic.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/theme.default.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/zebra_datepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/theme.default.css">
<!--<script type="text/javascript" src="<//?php echo base_url();?>assets/js/zebra_datepicker.js"></script>-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.timeentry.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript">
	$(function () {
		var options = {
			widthFixed: true,
			showProcessing: true,
			headerTemplate: '{content} {icon}', // Add icon for jui theme; new in v2.7!

			widgets: ['default', 'zebra', 'print', 'stickyHeaders', 'filter'],

			widgetOptions: {

				print_title: 'table',          // this option > caption > table id > "table"
				print_dataAttrib: 'data-name', // header attrib containing modified header name
				print_rows: 'f',         // (a)ll, (v)isible or (f)iltered
				print_columns: 's',         // (a)ll, (v)isible or (s)elected (columnSelector widget)
				print_extraCSS: '.table{border:1px solid #ccc;} tr,td{background:white}',          // add any extra css definitions for the popup window here
				print_styleSheet: '', // add the url of your print stylesheet
				// callback executed when processing completes - default setting is null
				print_callback: function (config, $table, printStyle) {
					// do something to the $table (jQuery object of table wrapped in a div)
					// or add to the printStyle string, then...
					// print the table using the following code
					$.tablesorter.printTable.printOutput(config, $table.html(), printStyle);
				},
				// extra class name added to the sticky header row
				stickyHeaders: '',
				// number or jquery selector targeting the position:fixed element
				stickyHeaders_offset: 0,
				// added to table ID, if it exists
				stickyHeaders_cloneId: '-sticky',
				// trigger "resize" event on headers
				stickyHeaders_addResizeEvent: true,
				// if false and a caption exist, it won't be included in the sticky header
				stickyHeaders_includeCaption: false,
				// The zIndex of the stickyHeaders, allows the user to adjust this to their needs
				stickyHeaders_zIndex: 2,
				// jQuery selector or object to attach sticky header to
				stickyHeaders_attachTo: null,
				// scroll table top into view after filtering
				stickyHeaders_filteredToTop: true,

				// adding zebra striping, using content and default styles - the ui css removes the background from default
				// even and odd class names included for this demo to allow switching themes
				zebra: ["ui-widget-content even", "ui-state-default odd"],
				// use uitheme widget to apply defauly jquery ui (jui) class names
				// see the uitheme demo for more details on how to change the class names
				uitheme: 'jui'
			}
		};
		$("#table-sort").tablesorter(options);
		$('.print').click(function () {
			$('#table-sort').trigger('printTable');
		});
	});
</script>
<style>
	.selectize-control.drug_type_repo .selectize-dropdown>div {
		border-bottom: 1px solid rgba(0, 0, 0, 0.05);
	}

	.selectize-control.drug_type_repo .selectize-dropdown .drug_type {
		font-weight: bold;
		margin-right: 5px;
	}

	.selectize-control.drug_type_repo .selectize-dropdown .title {
		display: block;
	}

	.selectize-control.drug_type_repo .selectize-dropdown .meta {
		list-style: none;
		margin: 0;
		padding: 0;
		font-size: 20px;
	}

	.selectize-control.drug_type_repo .selectize-dropdown .meta li {
		margin: 0;
		padding: 0;
		display: inline;
		margin-right: 10px;
	}

	.selectize-control.drug_type_repo .selectize-dropdown .meta li span {
		font-weight: bold;
	}

	/* .selectize-control.drug_type_repo::before {
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
				background: url(<?php echo base_url(); ?>
	assets/images/spinner.gif);
	background-size: 16px 16px;
	opacity: 0;
	}

	*/ .selectize-control.drug_type_repo.loading::before {
		opacity: 0.4;
	}
</style>

<script type="text/javascript">
	function yesnoCheck() {
		if (document.getElementById('yesCheck').checked) {
			document.getElementById('ifYes1').style.display = 'block';
			document.getElementById('ifYes2').style.display = 'block';
			document.getElementById('ifNo').style.display = 'none';

		} 
		else if(document.getElementById('noCheck').checked) {
			document.getElementById('ifNo').style.display = 'block';
			document.getElementById('ifYes1').style.display = 'none';
			document.getElementById('ifYes2').style.display = 'none';

		}


	}
 	window.onload = function() {
		document.getElementById('ifYes1').style.display = 'none';
		document.getElementById('ifYes2').style.display = 'none';
		document.getElementById('ifNo').style.display = 'none';
		yesnoCheck();
	}


</script>





<script>

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

<div class="col-md-8 col-md-offset-1">
	<?php
	$item_id_input = $this->input->post('item_id') ? $this->input->post('item_id') : "";
	$item_type_selected = $this->input->post('item_type') ? $this->input->post('item_type') : "";
	$item_form_selected = $this->input->post('item_form') ? $this->input->post('item_form') : "";
	$generic_item_selected = $this->input->post('generic_item') ? $this->input->post('generic_item') : "";

	?>

	<div class="text-center">
		<center>
			<?php
			echo validation_errors();
			if (isset($msg)) { ?>
				<div class="alert alert-info">
					<?php echo $msg; ?>
				</div>
			<?php } ?>
			<h3>Supply Chain Party</h3>
		</center><br>
		<center>
			<?php echo form_open('consumables/supply_chain_party/supply_chain_parties_list', array('class' => 'form-group', 'role' => 'form', 'id' => 'scp_search')); ?>
			<div class="container">

				<div class="col-md-12">
					<div class="row">
						<div class="col-md-3" id="ifYes1" style="display:none">
							<div class="form-group">
								<label for="department">Department</label>
								<select name="department" id="department" class="form-control">
									<option value="">Select</option>
									<?php
									foreach ($departments as $dept) {
										echo "<option value='" . $dept->department_id . "'>" . $dept->department . "</option>";
									}
									?>
								</select>
							</div>
						</div>
						<div class="col-md-3" id="ifYes2" style="display:none">
							<div class="form-group">
								<label for="area">Area</label>
								<select name="area" id="area" class="form-control">
									<option value="">Select</option>
									<?php
									foreach ($all_area as $are) {
										echo "<option value='" . $are->area_id . "'  class='" . $are->department_id . "'>" . $are->area_name . "</option>";

									}
									?>
								</select>
							</div>
						</div>
						<div class=" col-md-3" id="ifNo" style="display:none">
							<div class="form-group">
								<label for="vendor">Vendor</label>
								<!--Vendor field-->
								<select name="vendor" id="vendor" class="form-control">
									<option value="">Select</option>
									<?php
									foreach ($all_vendor as $ven) {
										echo "<option value='" . $ven->vendor_id . "'>" . $ven->vendor_name . "</option>";

									}
									?>
								</select>
							</div>
							<!--Vendor field end-->
						</div>
						<div style="margin-top:30px;">
							<div class="col-md-2">
								<label class="radio-inline" for="yesCheck"></label>
								<input type="radio" onclick="javascript:yesnoCheck();" name="in_house" id="yesCheck" value="in_house" aria-label="..." checked> In House
							</div>
							<div class="col-md-2">
								<label class="radio-inline" for="noCheck"></label>
									<input type="radio" onclick="javascript:yesnoCheck();" name="in_house" id="noCheck" value="external" aria-label="..."> External
							</div>
						</div>
					</div>
				</div>
				
				<div class="row">
					<div class="col-md-1 col-md-offset-4">
						<!--button for searching-->
						<center><button class="btn btn-primary" type="submit" name="search" value="search"
								id="btn">Search</button></center>
					</div>
					<?php echo form_close(); ?>
					<!--closing of form-->
					<div class="col-md-1">
						<center><a href="<?= base_url() . "consumables/supply_chain_party/add_supply_chain_party" ?>"><button
									class="btn btn-success" type="button">Add Supply Chain Party</button></a></center>
					</div>
				</div>

			</div>
			<!--set method for hidden the table-->


			<div class="container">
				<div class="row">
					<div class="col-md-3">
						<button type="button" class="btn btn-default btn-md print  ">
							<span class="glyphicon glyphicon-print"></span> Print
						</button>

						<a href="#" id="test" onClick="javascript:fnExcelReport();">
							<button type="button" class="btn btn-default btn-md excel">
								<i class="fa fa-file-excel-o" aria-hidden="true"></i> Export to excel</button></a></br>
					</div>
				</div>
			</div>
			</br>
			<!--filters for Add Service Issues view form --->
			<!--when filter is clicked this form will load --->



			<div class="container">
				<table class="table table-bordered table-striped" id="table-sort">
					<thead>
						<!-- <th>#</th> -->
						<th>ID</th>
						<th>Name</th>
						<th>Department</th>
						<th>Area</th>
						<th>Vendor</th>
						<th></th>


					</thead>
					<tbody>
						<?php


						$i = 1;

						foreach ($search_items as $item) { ?>

							<tr>
								<!-- <td><?php //echo $i++; ?></td> -->

								<td>
									<?php echo $item->supply_chain_party_id; ?>
								</td>

								<td>
									<?php echo $item->supply_chain_party_name; ?>
								</td>
								<td>
									<?php echo $item->department; ?>
								</td>
								<td>
									<?php echo $item->area_name; ?>
								</td>
								<td>
									<?php echo $item->vendor_name; ?>
								</td>

								<td>
									<?php echo form_open("consumables/supply_chain_party/edit", array('role' => 'form')) ?>
									<button type="submit" value="<?= $item->supply_chain_party_id; ?>" name="navigate_edit"
										class="btn btn-warning">Edit</button>
									<?php echo form_close(); ?>
								</td>


							</tr>
							<?php

						}
						?>










					</tbody>
				</table>

			</div>


	</div>
</div>