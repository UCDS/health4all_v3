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
			//$('#table-sort').trigger('printTable');
			var to_date = "<?php echo $this->input->post('to_date'); ?>";
			var scp_name = "<?php echo $search_inventory_summary[0]['supply_chain_party_name']; ?>";
			$('#table-sort').find('.tablesorter-filter-row').hide();
				var printContent = '<!DOCTYPE html>';
				printContent += '<html>';
				printContent += '<head>';
				printContent += '<title>Print</title>';
				printContent += '<style>';
				printContent += 'table { border-collapse: collapse; width: 95%; }';
				printContent += 'th, td { border: 1px solid #ddd; padding: 8px; }';
				printContent += 'th { background-color: #f2f2f2; }';
				printContent += '</style>';
				printContent += '</head>';
				printContent += '<body>';
				printContent += '<h3 style="text-align:center;">Showing balance as on ' + to_date + ' for SCP: <span style="color: green;">' + scp_name + '</span></h3>';				printContent += document.getElementById("table-sort").outerHTML;
				printContent += '</body>';
				printContent += '</html>';
				var printWindow = window.open('', '_blank', 'width=800,height=600');
				printWindow.document.write(printContent);
				printWindow.document.close();
				printWindow.print();
				window.onbeforeunload = function() {
					printWindow.close();
				};
				window.location.reload();
		});
	});
</script>
<style>
	.btn-circle {
		width: 30px;
		height: 30px;
		text-align: center;
		padding: 6px 0;
		font-size: 12px;
		line-height: 1.42;
		border-radius: 15px;
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

<style type="text/css">
.selectize-control.items .selectize-dropdown>div {
	border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.selectize-control.items .selectize-dropdown .by {
	font-size: 11px;
	opacity: 0.8;
}

.selectize-control.items .selectize-dropdown .by::before {
	content: 'by ';
}

.selectize-control.items .selectize-dropdown .name {
	font-weight: bold;
	margin-right: 5px;
}

.selectize-control.items .selectize-dropdown .title {
	display: block;
}

.selectize-control.items .selectize-dropdown .description {
	font-size: 12px;
	display: block;
	color: #a0a0a0;
	white-space: nowrap;
	width: 100%;
	text-overflow: ellipsis;
	overflow: hidden;
}

.selectize-control.items .selectize-dropdown .meta {
	list-style: none;
	margin: 0;
	padding: 0;
	font-size: 10px;
}

.selectize-control.items .selectize-dropdown .meta li {
	margin: 0;
	padding: 0;
	display: inline;
	margin-right: 10px;
}

.selectize-control.items .selectize-dropdown .meta li span {
	font-weight: bold;
}

.selectize-control.items::before {
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
}

.selectize-control.items.loading::before {
	opacity: 0.4;
}
</style>
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
<script>
	$(function () {
		if ($('#from_id').val() !== '') {
			$('#to_id  option[value="' + $('#from_id').val() + '"]').hide();
		}
		$('#from_id').change(function () {
			$("#to_id option").show();
			var optionval = this.value;
			if (optionval !== '') {
				$('#to_id  option[value="' + optionval + '"]').hide();
			}

		});
	});
	$(function () {
		if ($('#to_id').val() !== '') {
			$('#from_id  option[value="' + $('#to_id').val() + '"]').hide();
		}
		$('#to_id').change(function () {
			$("#from_id option").show();
			var optionval = this.value;
			if (optionval !== '') {
				$('#from_id  option[value="' + optionval + '"]').hide();
			}

		});
	});

</script>
<script>
	const onLoadFunction = function(query, callback) {
		if(!query.length) callback();
		$('.selectize-control.items').addClass('loading');
		console.log('loading', $('.selectize-control.items'));
		$.ajax({
			url: '<?php echo base_url(); ?>consumables/indent_reports/search_selectize_items',
			type: 'POST',
			dataType: 'JSON', 
			data: {query: query, item_type: $('#item_type').val()},
			error: function(res) {
				callback();
				setTimeout(() => {

					// $('.selectize-control.items').removeClass('loading');
				}, 1000);
			},
			success: function(res) {
				callback(res.items);
				setTimeout(() => {
					// $('.selectize-control.items').removeClass('loading');
				}, 1000);
			}
		});
	};
	$(function () {
		// if($('#item_type').val === ''){
		// 	return;
		// }

		let options = <?= json_encode($all_item); ?>;
		options = options.map(opt => {
			let ans = `${opt.item_name}-${opt.item_form}-`;
			if (opt.dosage) {
				ans += opt.dosage;
			}
			if (opt.dosage_unit) {
				ans += opt.dosage_unit;
			}
			return {
				...opt,
				item_name: ans
			};
		});
		console.log(options);
		// let temp = [];
		
		$selectize = $("#item").selectize({
			labelField: "item_name",
			searchField: "item_name",
			valueField: "item_id",
			options: options,
			// allowEmptyOption: true, 
			// showEmptyOptionInDropdown: true, 
			maxOptions: 10,
			load: function(query, callback) {
				if(!query.length) return callback();
				console.log('loading', $('.selectize-control.items'));
				$('.selectize-control.items').addClass('loading');
				$.ajax({
					url: '<?php echo base_url(); ?>consumables/indent_reports/search_selectize_items',
					type: 'POST',
					dataType: 'JSON', 
					data: {query: query, item_type: $('#item_type').val()},
					error: function(res) {
						
						callback();
						$('.selectize-control.items').addClass('loading');
						setTimeout(() => {

							$('.selectize-control.items').removeClass('loading');
						}, 500);
					},
					success: function(res) {
						
						callback(res.items);
						$('.selectize-control.items').addClass('loading');
						setTimeout(() => {
							console.log('delayed loading');
							$('.selectize-control.items').removeClass('loading');
						}, 500);
					}
				});
			}
		});
		let sel = $selectize[0].selectize;
		sel.setValue(<?= $this->input->post("item") ? $this->input->post("item") : ""; ?>);

		$('#item_type').change(function () {
			let optionval = this.value;
			console.log("Optionval", optionval);
			console.log("changed item_type");
			// $('#item').val('');
			sel.setValue('');
			sel.clearOptions();
			$('.selectize-control.items').addClass('loading');
			
			$.ajax({
				url: '<?php echo base_url(); ?>consumables/indent_reports/search_selectize_items',
				type: 'POST',
				dataType: 'JSON', 
				data: {query: null, item_type: $('#item_type').val()},
				error: function(res) {
					
					setTimeout(() => {
						$('.selectize-control.items').removeClass('loading');
					}, 500);
				},
				success: function(res) {
					let options = res.items.map(opt => {
						let ans = `${opt.item_name}-${opt.item_form}-`;
						if (opt.dosage) {
							ans += opt.dosage;
						}
						if (opt.dosage_unit) {
							ans += opt.dosage_unit;
						}
						return {
							...opt,
							item_name: ans
						};
					});
					sel.addOption(options);
					setTimeout(() => {
						$('.selectize-control.items').removeClass('loading');
					}, 500);
					// $('.selectize-control.items').removeClass('loading');
				}
			});

		});

		
		


	})
</script>
<script>
	$(function () {
		$("#from_date,#to_date").Zebra_DatePicker({
			direction: false
		});
	});
</script>
<script>
	$(function () {
		$(".time").timeEntry();
		$("#item_name").chained("#item_type");
	});

	function doPost(page_no) {

		var page_no_hidden = document.getElementById("page_no");
		page_no_hidden.value = page_no;
		console.log("page number hidden", page_no_hidden.value, $('#inventory_summary_search'));
		let el = document.createElement('input');
		el.type = "hidden";
		el.name = "search";
		el.value = "search";
		$('#inventory_summary_search').append(el);
		// alert("Sairam");
		$('#inventory_summary_search').submit();

	}
	function onchange_page_dropdown(dropdownobj) {
		doPost(dropdownobj.value);
	}
</script>
<?php
$from_date = 0;
$to_date = 0;

if ($this->input->post('to_date'))
	$to_date = date("d-M-Y", strtotime($this->input->post('to_date')));
else
	$to_date = date("Y-m-d");
//     $from_time=0;$to_time=0;
// if($this->input->post('from_time')) $from_time=date("H:i",strtotime($this->input->post('from_time'))); else $from_time = date("00:00");
// if($this->input->post('to_time')) $to_time=date("H:i",strtotime($this->input->post('to_time'))); else $to_time = date("23:59");
if ($this->input->post('from_id')) {
	$from_party = $this->input->post('from_id');
} else {
	$from_party = "0";
}
if ($this->input->post('to_id')) {
	$to_party = $this->input->post('to_id');
} else {
	$to_party = "0";
}
?>
<div class="text-center">
	<h2>Inventory Summary</h2>
	<?php echo form_open('consumables/indent_reports/get_inventory_summary', array('class' => 'form-group', 'role' => 'form', 'id' => 'inventory_summary_search')); ?>
	<div class="container">
		<div class="row">
			
			<div class="col-xs-12 col-sm-12 col-md-2 col-lg-3 col-md-offset-3">
				<div class="form-group">

					<!--input field to date-->
					<label for="to_date">Inventory Date </label>
					<input class="form-control" type="text" value="<?php echo date("d-M-Y", strtotime($to_date)); ?>"
						name="to_date" id="to_date" size="15" />
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-2 col-lg-3">
				<div class="form-group">
					<!--input field from party-->
					<label for="scp_id">Supply Chain Party<font color="red">*</font></label>
					<select name="scp_id" id="scp_id" class="form-control" required>
						<option value="">Select</option>
						<?php
						foreach ($parties as $scp) {
							echo "<option value='" . $scp->supply_chain_party_id . "'";
							if ($this->input->post('scp_id') && $this->input->post('scp_id') == $scp->supply_chain_party_id)
								echo " selected ";
							echo ">" . $scp->supply_chain_party_name . "</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-2 col-lg-3">
				<div class="form-group">
					<!--input field item-->
					<label for="item_type">Item Type<font color="red">*</font></label>
					<select name="item_type" id="item_type" class="form-control">
						<option value="">Select</option>
						<?php
						foreach ($all_item_type as $i) {
							//echo"<option class='".$i->item_type_id."' value='".$i->item_id."'>".$i->item_name."-".$i->item_form."-".$i->dosage.$i->dosage_unit."</option>";
							echo "<option class='" . $i->item_type_id . "' value='" . $i->item_type_id . "'";
							if ($this->input->post('item_type') && $this->input->post('item_type') == $i->item_type_id)
								echo " selected ";
							echo ">" . $i->item_type . "</option>";
						}
						?>
					</select>
				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-2 col-lg-3   col-md-offset-3">
				<div class="form-group">
					<!--input field item-->
					<label for="item">Item<font color="red">*</font></label>
					<select name="item" id="item" class="items">
						<option value="">Select</option>
					</select>
				</div>
			</div>
			<div class = "col-xs-12 col-sm-12 col-md-2 col-lg-3">
				<div class="form-group">
					<label for="item_form" >Item Form</label>
						<select name="item_form" id="item_form" class="form-control">
						<option value="">Select</option>
							<?php
							foreach($item_form as $i)
								{
									echo "<option class='".$i->item_form_id."' value='".$i->item_form_id."'";
									echo $item_form_selected == $i->item_form_id ? " selected": "";
									echo ">".$i->item_form."</option>";
								}
							?>
						</select>
				</div>
			</div>
			<div class = "col-xs-12 col-sm-12 col-md-2 col-lg-3">
				<div class="form-group">
				<label for="generic_item" >Generic Item</label>
					<select name="generic_item" id="generic_item" class="form-control" placeholder="Select">
						<option value="">Select</option>
						<?php
						foreach ($generic_item as $i) {
							echo "<option class='" . $i->generic_item_id . "' value='" . $i->generic_item_id . "'";
							echo $generic_item_selected == $i->generic_item_id ? " selected" : "";
							echo ">" . $i->generic_name . "</option>";
						}
						?>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-2 col-lg-3 col-md-offset-3">

				<!--Input field To party-->
				Rows per page :
				<input type="number" class="rows_per_page form-custom form-control" name="rows_per_page"
					id="rows_per_page" min=<?php echo $lower_rowsperpage; ?> max=<?php echo $upper_rowsperpage; ?>
					step="1" value=<?php if ($this->input->post('rows_per_page')) {
						echo $this->input->post('rows_per_page');
					} else {
						echo $rowsperpage;
					} ?> />

			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col">
				<input type="hidden" name="page_no" id="page_no" value='<?php echo "$page_no"; ?>'>
				<button class="btn btn-primary" type="submit" name="search" value="search" id="btn">Search</button>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
	<!--calling isset method-->
	<?php if (isset($mode) && ($mode) == "search") { ?>
		<?php echo form_open('consumables/indent_reports/get_inventory_summary', array('role' => 'form')) ?>
		<div class="container">
			<div class="row">
				<div class="col-md-3 col-md-offset-3">
					<button type="button" class="btn btn-primary btn-md print  ">
						<span class="glyphicon glyphicon-print"></span> Print
					</button>

					<a href="#" id="test" onClick="javascript:fnExcelReport();">
						<button type="button" class="btn btn-primary btn-md excel">
							<i class="fa fa-file-excel-o" ara-hidden="true"></i> Export to excel</button></a></br>
				</div>
			</div>
		</div>
		</br>
		<!--filters for Add Service Issues view form --->
	<!--when filter is clicked this form will load --->
	<div class="container">
		<?php if (count($search_inventory_summary) > 0) {
			//echo json_encode($search_inventory_summary[0]->supply_chain_party_name);
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

			$total_records = isset($summary_count) ? $summary_count: 10000;
			
			$total_no_of_pages = ceil($total_records / $total_records_per_page);
			if ($total_no_of_pages == 0)
				$total_no_of_pages = 1;
			$second_last = $total_no_of_pages - 1;
			$offset = ($page_no - 1) * $total_records_per_page;
			$previous_page = $page_no - 1;
			$next_page = $page_no + 1;
			$adjacents = "2";
			?>
		
		<div class="container" style="margin-left:14px;">
			<div class="row">
				<ul class="pagination" style="margin:0">
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
		<div class="col-md-offset-2">
			<div id="print-container">
				<?php if(count($search_inventory_summary) > 0) { ?>
					<h3>Showing balance as on 
				<?= $to_date; ?>
			 for SCP: <span style="color: green;">
				<?= $search_inventory_summary[0]['supply_chain_party_name']; ?>
			</span></h3>
				<?php } ?>
			</div>
			<table class="table table-bordered table-striped" id="table-sort">
				<thead>
					<th>#</th>
					<th>Item Type</th>
					<th>Item Name</th>
					<!-- <th>Supply Chain Party</th> -->
						<th>Current balance</th>
						<!-- <th></th> -->
						<!-- <th></th> -->
						<!-- <th>Quantity Inward</th>
							<th>Quantity Outward</th>
							<th>Difference</th> -->
						<!-- <th>Item id</th> -->
					<th></th>
					</thead>
					<tbody>
						<?php


						$i = $offset + 1;


						// $outward = $search
						log_message("info", "SAIRAM VERSION " . $CI_VERSION);
						log_message("info", "SAIRAM WARNING " . json_encode($search_inventory_summary));
						// echo '<h1>'.json_encode($search_inventory_summary).'</h1>';
						foreach ($search_inventory_summary as $inventory_item) { ?>

							<tr>
								<?php
								// echo $i++; 
								$sub_url = "consumables/indent_reports/get_item_summary";
								$quantity = $inventory_item['closing_balance'];


								// $item_type_id = '0';
								$item_id = $inventory_item['item_id'];
								$item_name = $inventory_item['item_name'];
								$scp_id = $inventory_item['supply_chain_party_id'];
								log_message("info", "SAIRAM LKDJJLDJ " . $inventory_item);
								?>



								<!-- <td><?php //echo $inventory_item['inward'] ? $inventory_item['inward']->item_type: $inventory_item['outward']->item_type;?></td> -->
								<td>
									<?= $i++; ?>
								</td>
								<td style="width: 20%;">
									<?= $inventory_item['item_type']; ?>
								</td>
								<td><b>
										<?php echo $item_name; ?>
									</b></td>

								<td style="width: 15%;">
									<center>
										<?php echo $quantity; ?>
									</center>
								</td>
								<td style="width: 15%;"><a href="<?php echo base_url() . $sub_url . "/$item_id/$scp_id"; ?>"><button
											class="btn btn-primary" type="button">View Detailed</button></a></td>

							</tr>
							<?php


						}
						?>
					<tfoot>
						<!-- <th>Total </th>
					<th> </th> -->
						<!-- <th> </th> -->



					</tfoot>
					<?php echo form_close(); ?>
					<!--ending of isset method-->
					<?php
	}
	?>
				</tbody>
			</table>
		</div>
	</div>
</div>