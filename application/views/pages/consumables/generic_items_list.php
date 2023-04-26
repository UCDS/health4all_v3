<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/selectize.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.selectize.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/metallic.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/theme.default.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/zebra_datepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/theme.default.css" >
<!--<script type="text/javascript" src="<//?php echo base_url();?>assets/js/zebra_datepicker.js"></script>-->
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript"
 src="<?php echo base_url(); ?>assets/js/jquery.timeentry.min.js"></script>
<script type="text/javascript"
 src="<?php echo base_url(); ?>assets/js/jquery.mousewheel.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.tablesorter.widgets.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.tablesorter.colsel.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.tablesorter.print.js"></script>
	<script type="text/javascript">
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
</script>
<style>
		.selectize-control.drug_type_repo .selectize-dropdown > div {
				border-bottom: 1px solid rgba(0,0,0,0.05);
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
				background: url(<?php echo base_url(); ?>assets/images/spinner.gif);
				background-size: 16px 16px;
				opacity: 0;
			} */
			.selectize-control.drug_type_repo.loading::before {
				opacity: 0.4;
			}
</style>
<script>
	// $(function(){
	// 	let _selectize_handle = $('#drug_type').selectize({
	// 		plugins: ["restore_on_backspace"],
	// 		valueField: 'drug_type_id',
	// 		labelField: 'drug_type',
	// 		searchField: 'drug_type',
	// 		// options: options,
	// 		create: false,
	// 		render: {
	// 			option: function (item, escape) {
					
	// 				return '<div>' +
	// 					'<span class="title">' +
	// 					'<span>' + escape(item.drug_type) + '</span>' +
	// 					'</span>' +
	// 					'</div>';
	// 			}
	// 		}, 
	// 		load: function(query, callback){
	// 			console.log("loading");
	// 			callback();
	// 		}
	// 	});
	// 	if($('#drug_type').attr("data-previous-value")){
	// 		_selectize_handle.selectize.setValue($(this).attr("data-previous-value"));
	// 	}
	// })
</script>




<script>

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
</script>

<div class="col-md-8 col-md-offset-1">
	<?php
	// echo "<h1>Sairam world</h1>";
	$generic_item_id_input = $this->input->post('generic_item_id') ? $this->input->post('generic_item_id') : "";
	$item_type_selected = $this->input->post('item_type') ? $this->input->post('item_type') : "";
	$item_form_selected = $this->input->post('item_form') ? $this->input->post('item_form') : "";
	$drug_type_selected = $this->input->post('drug_type') ? $this->input->post('drug_type') : "";

	// echo $item_type_selected. " Sairam";

	?>
	
			   <div class="text-center">
			   <center>
				<?php
				echo validation_errors();
				if (isset($msg)) { ?>
				<div class="alert alert-info"><?php echo $msg; ?></div><?php } ?>
				<h3>Generic Item</h3></center><br>
			<center>
				<?php echo form_open('consumables/generic_item/generic_items_list', array('class' => 'form-group', 'role' => 'form', 'id' => 'generic_items_search')); ?>
				<div class="container">
					<div class="row">
						<div class = "col-xs-12 col-sm-12 col-md-2 col-lg-3 col-md-offset-2">
							<div class="form-group">
							<!--Input field From date-->
							<label for="generic_item_id" >Generic Item ID: </label>
							 <input class="form-control" type="text" value="<?= $generic_item_id_input; ?>" placeholder="Generic Item ID" name="generic_item_id" id="generic_item_id" size="15" />
							</div>
						</div>
						
						<div class = "col-xs-12 col-sm-12 col-md-2 col-lg-3">
							<div class="form-group">
							<!--Input field Item Type-->
								<label for="item_type" >Item Type</label>
									<select name="item_type" id="item_type" class="form-control">
									<option value="" selected>Select</option>
										<?php
										//foreach loop for displaying all item types.
										foreach ($item_type as $i) {
											echo "<option value='" . $i->item_type_id . "'";
											echo $item_type_selected == $i->item_type_id ? " selected" : "";
											echo ">" . $i->item_type . "</option>";
										}
										?>
									</select>
							</div>
						</div>
						<!-- <div class = "col-xs-12 col-sm-12 col-md-2 col-lg-3">
							<div class="form-group">
							
								<label for="item_form" >Item Form</label>
									<select name="item_form" id="item_form" class="form-control">
									<option value="">Select</option>

										<?php
										//foreach loop for displaying all item types.
										// foreach($item_form as $i)
										// 	{
										// 		echo "<option class='".$i->item_form_id."' value='".$i->item_form_id."'";
										// 		echo $item_form_selected == $i->item_form_id ? " selected": "";
										// 		echo ">".$i->item_form."</option>";
										// 	}
										?>
									</select>
							</div>
						</div> -->
						
						<div class = "col-xs-12 col-sm-12 col-md-2 col-lg-3 col-md-offset-2">
							<div class="form-group">
							<!--Input field From date-->
							<label for="drug_type" >Drug Type</label>
								<select name="drug_type" id="drug_type" class="form-control" placeholder="Select">
									<option value="">Select</option>

									<?php
									//foreach loop for displaying all item types.
									foreach ($drug_type as $i) {
										echo "<option class='" . $i->drug_type_id . "' value='" . $i->drug_type_id . "'";
										echo $drug_type_selected == $i->drug_type_id ? " selected" : "";
										echo ">" . $i->drug_type . "</option>";
									}
									?>
								</select>
							</div>
							
						</div>
								

							

					</div>
					
					<div class="row">
						<div class="col-md-1 col-md-offset-4">
						<!--button for searching-->
						<center><button class="btn btn-primary" type="submit" name="search" value="search" id="btn">Search</button></center>
					</div>
					<?php echo form_close(); ?>	<!--closing of form-->
					<div class="col-md-1">
						<center><a href="<?= base_url() . "consumables/generic_item/add_generic" ?>"><button class="btn btn-success" type="button">Add Generic Item</button></a></center>
					</div>
				</div>
				
			</div>
			<!--set method for hidden the table-->
			
			
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-md-offset-2">
						<button type="button" class="btn btn-primary btn-md print  ">
							<span class="glyphicon glyphicon-print"></span> Print
						</button>
						
						<a href="#" id="test" onClick="javascript:fnExcelReport();">
							<button type="button" class="btn btn-primary btn-md excel">
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
							<th>Item Type</th>
							<!-- <th>Item Form</th> -->
							<th>Drug Type</th>
							<th>Generic Name</th>
							<th>Note</th>
							<th>Side Effects</th>
							<th></th>


						</thead>
						<tbody>
							<?php


							$i = 1;

							foreach ($search_generic_items as $gitem) { ?>

						<tr>
						<!-- <td><?php //echo $i++; ?></td> -->

							<td><?php echo $gitem->generic_item_id; ?></td>
						
							<td><?php echo $gitem->item_type; ?></td>
							<!-- <td><?php //echo $gitem->item_form;	?></td> -->
							<td><?php echo $gitem->drug_type; ?></td>
							<td><?php echo $gitem->generic_name; ?></td>
						
							<td style="width: 20%;"><?php echo $gitem->note; ?></td>
							<td style="width: 20%;"><?php echo $gitem->side_effect; ?></td>
							<td>
								<?php echo form_open("consumables/generic_item/edit", array('role' => 'form')) ?>	
								<button type="submit" value="<?= $gitem->generic_item_id; ?>" name="navigate_edit" class="btn btn-warning">Edit</button>
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
