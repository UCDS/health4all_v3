<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/metallic.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/theme.default.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.ptTimeSelect.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.ptTimeSelect.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">
<script type="text/javascript">
	var rowcount = 0;
	$(function () {
		$("#issue_date").Zebra_DatePicker({ direction: ['<?= date("d-M-Y", strtotime($indent_issued[0]->approve_date_time));?>', '<?= date('d-M-Y'); ?>'] });
		// $(".date_picker").Zebra_DatePicker({direction:false});
		$("#issue_time").ptTimeSelect();
		// $("#addbutton").click(function(){
		// 	var sno="<td>"+ " " +"</td></br>";

		// 	var item ="<td><div class='form-group'><select name='item[]' id='item' class='form-control' required><option value=''>Select</option>";
		// <?php // foreach($all_item as $t){ ?>
		// 		item +="<option value='<?php // echo $t->item_id;?>'><?php // echo $t->item_name."-".$t->item_form."-".$t->item_type."-".$t->dosage.$t->dosage_unit;?></option>";
		// 	<?php //} ?>
		// 	item += "</select></td>";
		// 	var quantity="<td><input type='number' class='number form-control' name='quantity_indented[]' required /></td></br>";
		//     var remove="<td><button value='X' class='btn btn-danger remove show-tip' onclick='$(\"#slot_row_"+rowcount+"\").remove();'><span class='glyphicon glyphicon-trash'></span></button></td>";
		// 	$("#slot_table").append("<tr id='slot_row_"+rowcount+"'>"+sno+item+quantity+remove+"</tr>");
		// 	rowcount++;

		// });
	});

</script>
<script type='text/javascript'>
	// $(window).load(function(){<!--from   w  w  w.  ja v a 2s.  c  om-->
	// $(function () {
	//     $("table#bootstrap_git_demo").on("click", ".remove", function () {
	//         $(this).closest('tr').remove();
	//     });
	// });
	// $(function () {
	//     $(".show_tip").tooltip({
	//         container: 'body'
	//     });
	// });
	// $(document).click(function () {
	//     $('.tooltip').remove();
	//     $('[title]').tooltip();
	//   });

	// });

	function sum_quantities(elements, attribute) {
		let ans = 0;
		for (let i = 0; i < elements.length; i++) {
			ans += Number(elements[i][attribute]);
		}
		return ans;
	}

	function display_message(message, timeout = null) {
		$('#error-message').html(message);
		if (!timeout)
			$('#error-alerts').show();
		else {
			$('#error-alerts').show(100, () => {
				setTimeout(() => $('#error-alerts').hide(), timeout);
			});
		}

	}
	$(window).load(function () {
		// console.log("SAIRAM I EXIST");

		let current_items = { <?php foreach ($indent_issued as $all_int) {
			echo "$all_int->indent_item_id : {qty: $all_int->quantity_approved, changed: false, current_num: 0}, ";
		} ?>

		};
		console.log(current_items);

		let quantity_elements = $(`[name = 'quantity_indented[]']`);

		let i = 0;
		$('#error-alerts').hide();
		for (const item_name in current_items) {
			console.log(item_name, current_items[item_name]);


			$(`[name=add_${item_name}]`).click((e) => {
				let proposed_sum = sum_quantities($(`[name="quantity_${item_name}[]"]`), 'value');
				console.log(proposed_sum);
				let current_quantity = $(`[name=quantity_issued_${item_name}]`);
				console.log(current_quantity[0].value);
				if (proposed_sum >= Number(current_quantity[0].value)) {
					console.log("Cannot add more quantity than specified");
					display_message("Cannot add more quantity than specified");
					return;

				} else {
					$('#error-alerts').hide();
				}
				console.log("clicked");
				console.log($(`[name=inventory_item_${item_name}]`));
				let inventory_items = $(`[name=inventory_item_${item_name}]`);
				let n = inventory_items.length;
				let selector = `[name=indent_item_${item_name}]`;
				if(n > 0){
					selector = inventory_items[n - 1];
				}
				let balance = Number(current_quantity[0].value) - proposed_sum;
				$(selector).after(
					`<tr name="inventory_item_${item_name}">\
		  <td><center><button name="remove_${item_name}[]" class="btn btn-danger item"><span class="glyphicon glyphicon-trash"> </span></button></center></td>\
			  <td>\
				<div class="col">\
					${$(`[name=indent_item_${item_name}]`).find('.item_name').html()}\
				</div>\
			</td>\
			  <td>\
				<div class="col">\
					<input type="number"  class="form-control qty narrow"  name="quantity_${item_name}[]" min="0" step="1" placeholder="Quantity" value="${balance}" /></td>\
				</div>\
			  <td>\
				<div class="col">\
					<input type="text"  class="form-control narrow" placeholder="Batch ID" name="batch_${item_name}[]" maxlength="10" minlength="1"  pattern="[0-9a-zA-Z]*" />\
				</div>\
			  </td>\
			  <td>\
				 <div class="col">\
					<input type="text"  class="form-control mfg_date_picker narrow" placeholder="Mfg. Date" name="mfg_date_${item_name}[]" />\
				</div>\
			  </td>\
			  <td>\
				  <div class="col">\
					<input type="text"  class="form-control exp_date_picker narrow" placeholder="Expiry Date"  name="exp_date_${item_name}[]"/>\
				</div>\
			  </td>\
			 
			  <td>\
				  <div class="col">\
					<input type="text" name="cost_${item_name}[]" class="form-control narrow" placeholder="Cost" value="0.0"/>\
				</div>\ 
			  </td>\
			  <td>\
				  <div class="col">\
					<input type="text" name="patient_id_${item_name}[]" class="form-control narrow" placeholder="Patient ID" />\
				</div>\ 
			  </td>\
			  <td>\
				 <div class="col">\
					<textarea name="note_${item_name}[]" class="form-control" placeholder="Note" maxlength="2000"></textarea>
				</div>\
			  </td>\
			  
			  <td>\
				 <div class="col">\
					<input type="text" name="gtin_${item_name}[]"  class="form-control" placeholder="Barcode no." minlength="8" maxlength="14" pattern="[0-9]*" />
				</div>\
			  </td>\
			  
		  </tr>`);
				console.log(current_items);

				$(`[name="quantity_${item_name}[]"]`).change((e) => {
					let proposed_sum = sum_quantities($(`[name="quantity_${item_name}[]"]`), 'value');
					let current_quantity = $(`[name=quantity_issued_${item_name}]`);
					console.log(proposed_sum, current_quantity, current_quantity[0].value);
					if (proposed_sum > Number(current_quantity[0].value)) {
						console.log("Cannot add more quantity than specified");
						display_message("Cannot add more quantity than specified");
						e.target.value = 0;

					} else {
						$('#error-alerts').hide();
					}
				});
				$(`[name="remove_${item_name}[]"]`).click((e) => {
					console.log("clicked danger", `"remove_${item_name}[]"]`);
					//   $(e.target).parents('tr').children(`cost_${item_name}`)
					$(e.target).parents('tr').remove();
					let proposed_sum = sum_quantities($(`[name="quantity_${item_name}[]"]`), 'value');
					let current_quantity = $(`[name=quantity_issued_${item_name}]`);
					if (proposed_sum > Number(current_quantity[0].value)) {
						console.log("Cannot add more quantity than specified");
						display_message("Cannot add more quantity than specified");
						e.target.value = 0;

					} else {
						$('#error-alerts').hide();
					}


					//   current_items[item_name].current_num--	;
				});
				$(".mfg_date_picker").Zebra_DatePicker({ direction: false, format: 'd-M-Y' });
				$(".exp_date_picker").Zebra_DatePicker({ direction: true, format: 'd-M-Y' });
				// current_items[item_name].current_num++;	
			});

			$(`[name=quantity_issued_${item_name}]`).change(e => {
				let proposed_sum = sum_quantities($(`[name="quantity_${item_name}[]"]`), 'value');
				let current_quantity = $(`[name=quantity_issued_${item_name}]`);
				console.log(proposed_sum, current_quantity, current_quantity[0].value);
				if (proposed_sum > Number(current_quantity[0].value)) {
					console.log("Cannot add more quantity than specified");
					display_message("Cannot add more quantity than specified");
					e.target.value = 0;

				} else {
					$('#error-alerts').hide();
				}
				
			});

		}
		// let changed = false;
		// console.log(current_quantities);
		// for(const quantity_name in current_quantities){
		// 	if(current_quantities[quantity_name].changed){
		// 		changed = true;
		// 		$(`.to-be-hidden`).show();
		// 		break;
		// 	}
		// }
		// if(!changed){
		// 	$(`.to-be-hidden`).hide();
		// }

		$('#issue_form').submit(e => {
			
			console.log("Trying to submit");

			for (const item_name in current_items) {
				let qty_elements = $(`[name='quantity_${item_name}[]']`);
				let proposed_sum = sum_quantities(qty_elements, 'value');
				let current_quantity_issued = $(`[name=quantity_issued_${item_name}]`)[0].value;
				console.log(current_quantity_issued, proposed_sum);
				if(proposed_sum !== Number(current_quantity_issued)){
					display_message("Quantities of different items must match the number that have been issued.")
					e.preventDefault();
					return;
				}
				let costs = $(`[name='cost_${item_name}[]']`);
				for(let j = 0; j < qty_elements.length; j++){
					console.log(qty_elements[j].value);
					if(qty_elements[j].value == 0){
						display_message("Quantity cannot be 0");
						e.preventDefault();
						return;
					}
				}
				for(let i = 0; i < costs.length; i++){
					if(costs[i].value.length == 0){
						costs[i].value = '0.0';
					}
					if(isNaN(Number(costs[i].value)) || Number(costs[i].value) < 0.0){
						display_message("Cost has to be a number which is not negative");
						e.preventDefault();
						return;
					}
				}
			}
			// e.preventDefault();


		});

	});


</script>

<style>
	.qty {
		width: 2vw;

	}

	.form-control {
		height: 2vw;
		min-height: 30px;
		width: 120px;
	}

	.btn.item {
		width: 2vw;
		height: 2vw;
		padding: 15%;

	}

	.glyphicon {
		width: 1vw;
		min-width: 20px;
		height: 1vw;
		min-height: 20px;
		margin: auto;
	}

	td#change {
		padding: 0%;
	}

	.issue_invoice {
		/* max-width: 915; */
		overflow-y: auto;
		max-height: 450px;

	}

	#issue_invoice_table {
		overflow-x: scroll;
		width: 1000px;
		min-width: 950px;

		/* overflow-y: auto; */
	}

	#table-body {
		max-height: 100px;
		/* overflow-y:auto; */
		/* position: absolute; */
		/* top: 20vw; */
		/* overflow-y: auto; */
		/* height: 100px; */
		/* min-height: 100px; */
	}

	.mfg_date_picker {
		max-width: 115px;
	}

	.exp_date_picker {
		max-width: 115px;
	}

	.narrow {
		max-width: 115px;
	}
</style>

<div class="col-md-11 col-md-offset-2">
	<?php echo form_open('consumables/indent_issue/indent_issued', array('class' => 'form-custom', 'role' => 'form', 'id' => 'issue_form')) ?><!-- Issued details from open -->
	<div class="row">
		<div class="col-md-12">

			<div class="panel panel-success">
				<div class="panel-heading">


					<center>
						<h1>Indent</h1>
					</center>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-md-6">
							<b>Indent ID:</b>
							<?php echo $all_int->indent_id; ?>
						</div>

					</div>
					<div class="row">

						<div class="col-md-6">
							<b>Indent From Party:</b>
							<?php echo $all_int->from_party; ?>

						</div>
						<div class="col-md-6">
							<b>Indent To Party: </b>
							<?php echo $all_int->to_party; ?>

						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<b>Indent Date:</b>
							<?php echo date("d-M-Y h:i A", strtotime($all_int->indent_date)); ?>
						</div>
						<div class="col-md-6">
							<b>Approval Date: </b>
							<?php echo date("d-M-Y h:i A", strtotime($all_int->approve_date_time)); ?>
						</div>
					</div>



					<div class="row">
						<div class="col-md-6">

							<b>Issue Date:<font color="red">*</font></b>
							<input type="text" value="<?php echo date("d-M-Y"); ?>" name="issue_date" id="issue_date" />
						</div>
						<div class="col-md-6">
							<b>Issue Time: </b>
							<input type="text" value="<?php echo date("h:i A"); ?>" name="issue_time" id="issue_time" />
						</div>
						<input class="sr-only" type="hidden" id="from_party_id" name="from_party_id"
							value="<?= $all_int->from_party_id; ?>" readonly>
						<input class="sr-only" type="hidden" id="to_party_id" name="to_party_id"
							value="<?= $all_int->to_party_id; ?>" readonly>
					</div>
				</div>

			</div>
			<div class="row">
				<div id="error-alerts" style="max-width: 40%; margin: auto;">
					<div class="alert alert-danger">
						<center>
							<p id="error-message"></p>
						</center>
					</div>
				</div>
				<div class="col">
					<div class="issue_invoice">
						<table id="issue_invoice_table" class="table" style="border: 2px solid #ccc;">
							<thead>
								<th></th>
								<th>Item Name</th>
								<th>Qty<font color="red">*</font>
								</th>
								<th>Batch</th>
								<th>Mfg. Date</th>
								<th>Expiry Date</th>

								<th>Cost</th>
								<th>Patient ID</th>

								<th>Note</th>
								<th>GTIN Code</th>
							</thead>

							<tbody id="table-body">
								<!-- name="indent_item_$indent_item->id" -->
								<?php
								$i = 1;
								foreach ($indent_issued as $all_int) { ?>
									<tr name="<?php echo "indent_item_" . $all_int->indent_item_id; ?>"
										class="warning indent_item">
										<td id="change">
											<center><button type='button' name=<?php echo "add_" . $all_int->indent_item_id; ?> class="btn item"><span
														class="glyphicon glyphicon-plus"></span></button></center>
										</td>
										<td class="item_name">
											<?php echo $all_int->item_name . "-" . $all_int->item_type . "-" . $all_int->item_form . "-" . $all_int->dosage . $all_int->dosage_unit;
											; ?>
										</td>
										<td><input class="form-control narrow" type="number" min="0"
												value="<?php echo $all_int->quantity_approved; ?>"
												name="quantity_issued_<?= $all_int->indent_item_id; ?>" required /></td>
										<td></td>
										<td></td>
										<td></td>
										<!-- <td>Current Cost: <span id=<?php //echo "total_cost_$all_int->indent_item_id"; ?>>0</span></td> -->
										<td></td>

										<td></td>
										<td><textarea
												name="indent_item_note_<?= $all_int->indent_item_id; ?>"><?= $all_int->note; ?></textarea>
										</td>
										<td></td>
										<input class="sr-only" type="hidden" value="<?php echo $all_int->indent_item_id; ?>"
											name="indent_item[]" readonly>
										<input class="sr-only" type="hidden" value="<?php echo $all_int->item_id; ?>"
											name=<?="item_id_$all_int->indent_item_id"; ?> readonly>

										<!-- name="add_$indent_item->id" -->

									</tr>

									<?php
									$i++;
								} ?>


							</tbody>

						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group form-group-lg">
					<label for="indent_note">Note </label><br>
					<textarea class="form-control" name="indent_note" id="indent_note"
						placeholder="Add a note for the indent"><?php echo $all_int->indent_note; ?></textarea>
				</div>

			</div>
		</div>
		<div class="row">
			<div class="col-md-10">
				<div class="panel-heading">
					<p class="panel-title">
						<center>

							<input type="hidden" value="<?= $indent_issued[0]->indent_id; ?>" class="sr-only"
								name="indent" />
							<Button type="submit" name="issue" value="submit" id="btn"
								class="btn btn-success">Issue</Button>
							<input type="hidden" name="selected_indent_id" value="<?php echo $all_int->indent_id; ?>" />
							
						</center>
					</p>
				</div>
			</div>
		</div>
	</div>
	<?php echo form_close(); ?><!-- End of Issued details form -->

</div>


</div>