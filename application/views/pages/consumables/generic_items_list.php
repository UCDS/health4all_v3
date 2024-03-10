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
<style>
		.page_dropdown {
		position: relative;
		float: left;
		padding: 6px 12px;
		width: auto;
		height: 34px;
		line-height: 1.428571429;
		text-decoration: none;
		background-color: #ffffff;
		border: 1px solid #dddddd;
		margin-left: -1px;
		color: #428bca;
		border-bottom-right-radius: 4px;
		border-top-right-radius: 4px;
		display: inline;
	}

	.page_dropdown:hover {
		background-color: #eeeeee;
		color: #2a6496;
	}

	.page_dropdown:focus {
		color: #2a6496;
		outline: 0px;
	}
	.rows_per_page {
		display: inline-block;
		height: 34px;
		padding: 6px 12px;
		font-size: 14px;
		line-height: 1.428571429;
		color: #555555;
		vertical-align: middle;
		background-color: #ffffff;
		background-image: none;
		border: 1px solid #cccccc;
		border-radius: 4px;
		-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		-webkit-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
		transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
	}

	.rows_per_page:focus {
		border-color: #66afe9;
		outline: 0;
	}
	</style>

<?php 
	
$page_no = 1;	

?>


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
function doPost(page_no) {
		
		var page_no_hidden = document.getElementById("page_no");
		page_no_hidden.value = page_no;
		console.log("page number hidden", page_no_hidden.value, $('#generic_items_search'));
		let el = document.createElement('input');
		el.type = "hidden";
		el.name ="search";
		el.value = "search";
		$('#generic_items_search').append(el);
		// alert("Sairam");
		$('#generic_items_search').submit();

	}
	function onchange_page_dropdown(dropdownobj) {
		doPost(dropdownobj.value);
	}
</script>
<script>
function fnExcelReport() {
      //created a variable named tab_text where 
    var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    //row and columns arrangements
    tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
    tab_text = tab_text + '<x:Name>Excel Sheet</x:Name>';

    tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
    tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';

    tab_text = tab_text + "<table border='100px'>";
    //id is given which calls the html table
    tab_text = tab_text + $('#table-sort').html();
    tab_text = tab_text + '</table></body></html>';
    var data_type = 'data:application/vnd.ms-excel';
    $('#test').attr('href', data_type + ', ' + encodeURIComponent(tab_text));
    //downloaded excel sheet name is given here
    $('#test').attr('download', 'generic_items_list.xls');

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
						<div class = "col-md-4">
							<div class="form-group">
							<!--Input field From date-->
							<label for="generic_item_id" >Generic Item ID: </label>
							 <input class="form-control" type="text" value="<?= $generic_item_id_input; ?>" placeholder="Generic Item ID" name="generic_item_id" id="generic_item_id" size="15" />
							</div>
						</div>
						
						<div class = "col-md-4">
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
						
						<div class = "col-md-4">
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
						<div class = "col-sm-2 ">
						&nbsp;Rows per page : <input type="number" class="rows_per_page form-custom form-control" name="rows_per_page" id="rows_per_page" min=<?php echo $lower_rowsperpage; ?> max= <?php echo $upper_rowsperpage; ?> step="1" value= <?php if($this->input->post('rows_per_page')) { echo $this->input->post('rows_per_page'); }else{echo $rowsperpage;}  ?> onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" /> 
							
						</div>		
					</div>
					
					<div class="row">
						<div class="col-md-1 col-md-offset-4">
						<input type="hidden" name="page_no" id="page_no" value='<?php echo "$page_no"; ?>'>
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
			
			<h5 style="margin-left:-58%!important;">Data as on <?php echo date("j-M-Y h:i A"); ?></h5>
			<div class="container">
				<div class="row">
					<div class="col-md-3" style="padding-left:30px;">
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
				
				<?php if(count($search_generic_items) > 0) { ?>
				<?php
					if ($this->input->post('rows_per_page')) {
						$total_records_per_page = $this->input->post('rows_per_page');
					} else {
						$total_records_per_page = $rowsperpage;
					}
					if ($this->input->post('page_no')) {
						$page_no = $this->input->post('page_no');
					} else {
						$page_no = 1;
					}
					$total_records = $generic_items_count[0]->count;
					$total_no_of_pages = ceil($total_records / $total_records_per_page);
					if ($total_no_of_pages == 0)
						$total_no_of_pages = 1;
					$second_last = $total_no_of_pages - 1;
					$offset = ($page_no - 1) * $total_records_per_page;
					$previous_page = $page_no - 1;
					$next_page = $page_no + 1;
					$adjacents = "2";
				?>
				<div class="container-fluid" >
					<div class="row">
					<ul class="pagination" style="margin:0px -55px 0px -25%">
					<?php if ($page_no > 1) {
						echo "<li><a href=# onclick=doPost(1)>First Page</a></li>";
					} ?>

					<li <?php if ($page_no <= 1) {
						echo "class='disabled'";
					} ?>>
					<a <?php if ($page_no > 1) {
							echo "href=# onclick=doPost($previous_page)";
						} ?>>Previous</a>
					</li>
		<?php
			if ($total_no_of_pages <= 10) {
				for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
					if ($counter == $page_no) {
						echo "<li class='active'><a>$counter</a></li>";
					} else {
						echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
					}
				}
			} else if ($total_no_of_pages > 10) {
				if ($page_no <= 4) {
					for ($counter = 1; $counter < 8; $counter++) {
						if ($counter == $page_no) {
							echo "<li class='active'><a>$counter</a></li>";
							} else {
								echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
						}
					}

					echo "<li><a>...</a></li>";
					echo "<li><a href=# onclick=doPost($second_last)>$second_last</a></li>";
					echo "<li><a href=# onclick=doPost($total_no_of_pages)>$total_no_of_pages</a></li>";
				} elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {
					echo "<li><a href=# onclick=doPost(1)>1</a></li>";
					echo "<li><a href=# onclick=doPost(2)>2</a></li>";
					echo "<li><a>...</a></li>";
					for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
						if ($counter == $page_no) {
							echo "<li class='active'><a>$counter</a></li>";
						} else {
							echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
						}
					}
					echo "<li><a>...</a></li>";
					echo "<li><a href=# onclick=doPost($counter) >$counter</a></li>";
					echo "<li><a href=# onclick=doPost($total_no_of_pages)>$total_no_of_pages</a></li>";
				} else {
					echo "<li><a href=# onclick=doPost(1)>1</a></li>";
					echo "<li><a href=# onclick=doPost(2)>2</a></li>";
					echo "<li><a>...</a></li>";
					for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
						if ($counter == $page_no) {
							echo "<li class='active'><a>$counter</a></li>";
						} else {
							echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
						}
					}
				}
			}
		?>
		<li <?php if ($page_no >= $total_no_of_pages) {
			echo "class='disabled'";
		} ?>>
		<a <?php if ($page_no < $total_no_of_pages) {
				echo "href=# onclick=doPost($next_page)";
			} ?>>Next</a>
		</li>

		<?php if ($page_no < $total_no_of_pages) {
			echo "<li><a href=# onclick=doPost($total_no_of_pages)>Last Page</a></li>";
		} ?>
		<?php if ($total_no_of_pages > 0) {
			echo "<li><select class='page_dropdown' onchange='onchange_page_dropdown(this)'>";
			for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
				echo "<option value=$counter ";
				if ($page_no == $counter) {
					echo "selected";
				}
				echo ">$counter</option>";
			}
			echo "</select></li>";
		} ?>
	</ul>
					</div>
				</div>
			<?php } ?>	
		<div style='margin-left:-60%!important;'>
			<h5>Page <?php echo $page_no." of ".$total_no_of_pages." (Total ".$total_records.")" ; ?></h5>
		</div>
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
		<div style='margin-left:-60%!important;'>
			<h5>Page <?php echo $page_no." of ".$total_no_of_pages." (Total ".$total_records.")" ; ?></h5>
		</div>
	    <?php if(count($search_generic_items) > 0) { ?>
				<?php
					if ($this->input->post('rows_per_page')) {
						$total_records_per_page = $this->input->post('rows_per_page');
					} else {
						$total_records_per_page = $rowsperpage;
					}
					if ($this->input->post('page_no')) {
						$page_no = $this->input->post('page_no');
					} else {
						$page_no = 1;
					}
					$total_records = $generic_items_count[0]->count;
					$total_no_of_pages = ceil($total_records / $total_records_per_page);
					if ($total_no_of_pages == 0)
						$total_no_of_pages = 1;
					$second_last = $total_no_of_pages - 1;
					$offset = ($page_no - 1) * $total_records_per_page;
					$previous_page = $page_no - 1;
					$next_page = $page_no + 1;
					$adjacents = "2";
				?>
				<div class="container-fluid" >
					<div class="row">
					<ul class="pagination" style="margin:0px -55px 0px -25%">
					<?php if ($page_no > 1) {
						echo "<li><a href=# onclick=doPost(1)>First Page</a></li>";
					} ?>

					<li <?php if ($page_no <= 1) {
						echo "class='disabled'";
					} ?>>
					<a <?php if ($page_no > 1) {
							echo "href=# onclick=doPost($previous_page)";
						} ?>>Previous</a>
					</li>
		<?php
			if ($total_no_of_pages <= 10) {
				for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
					if ($counter == $page_no) {
						echo "<li class='active'><a>$counter</a></li>";
					} else {
						echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
					}
				}
			} else if ($total_no_of_pages > 10) {
				if ($page_no <= 4) {
					for ($counter = 1; $counter < 8; $counter++) {
						if ($counter == $page_no) {
							echo "<li class='active'><a>$counter</a></li>";
							} else {
								echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
						}
					}

					echo "<li><a>...</a></li>";
					echo "<li><a href=# onclick=doPost($second_last)>$second_last</a></li>";
					echo "<li><a href=# onclick=doPost($total_no_of_pages)>$total_no_of_pages</a></li>";
				} elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {
					echo "<li><a href=# onclick=doPost(1)>1</a></li>";
					echo "<li><a href=# onclick=doPost(2)>2</a></li>";
					echo "<li><a>...</a></li>";
					for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
						if ($counter == $page_no) {
							echo "<li class='active'><a>$counter</a></li>";
						} else {
							echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
						}
					}
					echo "<li><a>...</a></li>";
					echo "<li><a href=# onclick=doPost($counter) >$counter</a></li>";
					echo "<li><a href=# onclick=doPost($total_no_of_pages)>$total_no_of_pages</a></li>";
				} else {
					echo "<li><a href=# onclick=doPost(1)>1</a></li>";
					echo "<li><a href=# onclick=doPost(2)>2</a></li>";
					echo "<li><a>...</a></li>";
					for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
						if ($counter == $page_no) {
							echo "<li class='active'><a>$counter</a></li>";
						} else {
							echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
						}
					}
				}
			}
		?>
		<li <?php if ($page_no >= $total_no_of_pages) {
			echo "class='disabled'";
		} ?>>
		<a <?php if ($page_no < $total_no_of_pages) {
				echo "href=# onclick=doPost($next_page)";
			} ?>>Next</a>
		</li>

		<?php if ($page_no < $total_no_of_pages) {
			echo "<li><a href=# onclick=doPost($total_no_of_pages)>Last Page</a></li>";
		} ?>
		<?php if ($total_no_of_pages > 0) {
			echo "<li><select class='page_dropdown' onchange='onchange_page_dropdown(this)'>";
			for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
				echo "<option value=$counter ";
				if ($page_no == $counter) {
					echo "selected";
				}
				echo ">$counter</option>";
			}
			echo "</select></li>";
		} ?>
	</ul>
					</div>
				</div>
			<?php } ?>	<br/>
	</div>
</div>
