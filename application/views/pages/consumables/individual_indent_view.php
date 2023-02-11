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
<!-- <script type="text/javascript">
$(function(){
		var options = {
			widthFixed : true,
			showProcessing: true,
			headerTemplate : '{content} {icon}', // Add icon for jui theme; new in v2.7!

			widgets: [ 'default', 'zebra', 'print', 'stickyHeaders','filter'],

			widgetOptions: {

		  print_title      : 'table',          // this option > caption > table id > "table"
		  print_dataAttrib : 'data-name', // header attrib containing modified header name
		  print_rows       : 'f',         // (a)ll, (v)isible or (f)iltered
		  print_columns    : 's',         // (a)ll, (v)isible or (s)elected (columnSelector widget)
		  print_extraCSS   : '.table{border:1px solid #ccc;} tr,td{background:white}',          // add any extra css definitions for the popup window here
		  print_styleSheet : '', // add the url of your print stylesheet
		  // callback executed when processing completes - default setting is null
		  print_callback   : function(config, $table, printStyle){
			// do something to the $table (jQuery object of table wrapped in a div)
			// or add to the printStyle string, then...
			// print the table using the following code
			$.tablesorter.printTable.printOutput( config, $table.html(), printStyle );
			},
			// extra class name added to the sticky header row
			  stickyHeaders : '',
			  // number or jquery selector targeting the position:fixed element
			  stickyHeaders_offset : 0,
			  // added to table ID, if it exists
			  stickyHeaders_cloneId : '-sticky',
			  // trigger "resize" event on headers
			  stickyHeaders_addResizeEvent : true,
			  // if false and a caption exist, it won't be included in the sticky header
			  stickyHeaders_includeCaption : false,
			  // The zIndex of the stickyHeaders, allows the user to adjust this to their needs
			  stickyHeaders_zIndex : 2,
			  // jQuery selector or object to attach sticky header to
			  stickyHeaders_attachTo : null,
			  // scroll table top into view after filtering
			  stickyHeaders_filteredToTop: true,

			  // adding zebra striping, using content and default styles - the ui css removes the background from default
			  // even and odd class names included for this demo to allow switching themes
			  zebra   : ["ui-widget-content even", "ui-state-default odd"],
			  // use uitheme widget to apply defauly jquery ui (jui) class names
			  // see the uitheme demo for more details on how to change the class names
			  uitheme : 'jui'
			}
		};
		$("#table-sort").tablesorter(options);
		$('.print').click(function(){
			$('#table-sort').trigger('printTable');
		});
	});
</script> -->
<!-- <script>
	$(function () {
		$('[data-toggle="popover"]').popover({trigger:'hover',html:true});
		$("#item").chained("#item_type");
	});
</script> -->

<?php if (count($issue_details) > 0) { ?>

<iframe id="ifmcontentstoprint" style="height: 0px; width: 0px; position: absolute;display:none"></iframe>
<div id="print-div" class="sr-only" style="width:100%;height:100%;">
	<center>
		<?php foreach ($issue_details as $all_issue) { ?>
			<h3>
				<?php echo $all_issue->hospital; ?>
			</h3>
			<?php break;
		} ?>
		<p>
		<h3>Indent ID <?php echo $all_issue->indent_id; ?></h3>
		</p><!-- Heading -->
		
	</center>
	<hr style="border: 2px solid black">
	<center>
		
		<label style="float:left"><b>From : </b>
			<?php echo " " . $all_issue->from_party; ?>
		</label><!-- From label-->
		<label style="float:right"><b>To : </b>
			<?php echo " " . $all_issue->to_party; ?>
		</label><br><br><!--  To label -->
		<label style="float:left"><b>Indented by : </b>
			<?php echo $all_issue->order_first . " " . $all_issue->order_last." at " . date("d-M-Y g:i A", strtotime($all_issue->indent_date)); ?>
		</label><br><br><!--Date Time label -->
		<label style="float:left"><b>Approval by : </b>
			<?php 
				if ($all_issue->indent_status == "Approved" || $all_issue->indent_status == "Issued") {
					echo $all_issue->approve_first . " " . $all_issue->approve_last." at " . date("d-M-Y g:i A", strtotime($all_issue->approve_date_time));}
				else { 
					echo " NA";
				} ?>
		</label><br><br><!--Date Time label -->
		<label style="float:left"><b>Issued by : </b>
		<?php 
				if ($all_issue->indent_status == "Issued") {
					echo $all_issue->issue_first . " " . $all_issue->issue_last." at " . date("d-M-Y g:i A", strtotime($all_issue->issue_date_time));}
				else { 
					echo " NA";
				} ?>
		</label><br><br><!--Date Time label -->
		
	</center>
	<br /><br /><br />
	<table style=" border:2px solid black;width:100%;border-collapse: collapse;">
		<thead style="height:50px">
			<th style="text-align:center;border:2px solid black;">#</th>
			<th style="text-align:center;border:2px solid black;">Items</th>
			<th style="text-align:center;border:2px solid black;">Quantity indented</th>
			<th style="text-align:center;border:2px solid black;">Quantity Approved</th>
			<th style="text-align:center;border:2px solid black;">Quantity Issued</th>
			<th style="text-align:center;border:2px solid black;">Note</th>	
		</thead>
		<tbody>
			<?php
			$i = 1;
			foreach ($issue_details as $all_issue) { ?>
				<tr>
					<td style="border:2px solid black;  padding: 15px;  height: 50px;">
						<center>
							<?php echo $i++; ?>
						</center>
					</td>
					<td style="border:2px solid black;   padding: 15px;  height: 50px;" align="left">
						<?php echo $all_issue->item_name . "-" . $all_issue->item_form . "-" . $all_issue->item_type . $all_issue->dosage . $all_issue->dosage_unit; ?>
					</td>
					<td style="border:2px solid black;  padding: 15px;  height: 50px;" align="right">
						<?php echo $all_issue->quantity_indented ?>
					</td>
					<td style="border:2px solid black;  padding: 15px;  height: 50px;" align="right">
						<?php echo $all_issue->quantity_approved ?>
					</td>
					<td style="border:2px solid black;  padding: 15px;  height: 50px;" align="right">
						<?php echo $all_issue->quantity_issued ?>
					</td>
					<td style="border:2px solid black;  padding: 15px;  height: 50px;" align="right">
						<?php echo $all_issue->note ?>
					</td>

				</tr>
			<?php } ?>
		</tbody>
	</table>
	<br/><br/>
		<p><b>Note: </b><br> <?php echo $all_issue->indent_note?></p>
	
	<b>
		<?php echo "Issuer Signature :"; ?>
	</b></br></br>
</div>
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
					<?php echo " " . $all_issue->indent_id; ?>
				</div><!-- End of indent_id label-->

			</div>
			<div class="row" style="padding:5px 0px;">
				<div class="col-md-4"><!-- From_party label-->
					<b>From Party : </b>
					<?php echo " " . $all_issue->from_party; ?>
				</div><!-- End of from_party label -->

				<div class="col-md-4" style="padding:5px 0px;"><!-- To party label -->
					<b>To Party : </b>
					<?php echo " " . $all_issue->to_party; ?>
				</div><!-- End of to party label-->
			</div>
			<div class="row">
				<div class="col-md-5"  style="padding:5px 0px; margin-left: 15px;"><!-- Date Time label -->
				<?php
				$status_color = "text-success";
				if ($all_issue->indent_status == "Indented") {
					$status_color = "text-warning";
				} else if ($all_issue->indent_status == "Approved") {
					$status_color = "text-primary";
				} else if ($all_issue->indent_status == "Rejected") {
					$status_color = "text-danger";
				}
				?>
					<b>Approval status : </b>
					<b class="<?php echo $status_color; ?>"><?php echo " ". $all_issue->indent_status; ?></b>
				</div><!-- End of date time label-->
			</div>

			<div class="row">
				<div class="col-md-5"  style="padding:5px 0px; margin-left: 15px;"><!-- Date Time label -->
					<b>Indent Date Time : </b>
					<?php echo " " . date("d-M-Y g:i A", strtotime($all_issue->indent_date)); ?>
				</div><!-- End of date time label-->
			</div>
			<div class="row">
				<div class="col-md-5"  style="padding:5px 0px; margin-left: 15px;"><!-- Date Time label -->
					<b>Approval Date Time : </b>
					<?php 
						if ($all_issue->indent_status == "Approved" || $all_issue->indent_status == "Issued") {
							echo " " . date("d-M-Y g:i A", strtotime($all_issue->approve_date_time));}
						else { 
							echo " NA";
						} ?>
				</div><!-- End of date time label-->
			</div>
			<div class="row">
				<div class="col-md-5"  style="padding:5px 0px; margin-left: 15px;"><!-- Date Time label -->
					<b>Issue Date Time : </b>
					<?php 
						if ($all_issue->indent_status == "Issued") {
							echo " " . date("d-M-Y g:i A", strtotime($all_issue->issue_date_time));}
						else { 
							echo " NA";
						} ?>
				</div><!-- End of date time label-->
			</div>
		</div>

		





		<div class="container">
		<div class="row">
			<div class="col-md-8" style="margin-left:33px">
				<div class="form-group">
					<table class="table table-bordered table-striped">
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
										<?php echo $all_issue->note ?>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		</div>
		<div class="container">
			<div>
				<b>Note:</b>
				<p><?php echo $all_issue->indent_note; ?></p>
			</div>
			<div class="span9">
				<div class="span3">
					<div class="col-md-12"><!-- Indenter name -->
						<b>
							<?php echo "Indented" . " " . "by :"; ?>
						</b>
						<?php echo $all_issue->order_first . " " . $all_issue->order_last; ?></br></br>
					</div><!-- End of indenter name-->
				</div>
				<div class="span3">
					<div class="col-md-12"><!-- Approver name-->
						<b>
							<?php echo "Approved" . " " . "by :"; ?>
						</b>
						<?php echo $all_issue->approve_first . " " . $all_issue->approve_last; ?></br></br>
					</div><!-- End of approver name-->
				</div>
				<div class="span3">
					<div class="col-md-12"><!-- Issuer name-->
						<b>
							<?php echo "Issued" . " " . "by :"; ?>
						</b>
						<?php echo $all_issue->issue_first . " " . $all_issue->issue_last; ?></br></br>
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
							onclick="printDiv('print-div')">Print</button>
				
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