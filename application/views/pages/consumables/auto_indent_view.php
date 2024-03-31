<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/selectize.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/metallic.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/theme.default.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.ptTimeSelect.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.ptTimeSelect.css">
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">

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
	/* 
	td#change {
		padding: 0%;
	} */

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

	.wide {
		min-width: 200px;
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

<script type="text/javascript">
	var rowcount = 0;
	$(function () {
		$("#indent_date").Zebra_DatePicker({ direction: false });
		// $(".date_picker").Zebra_DatePicker({direction:false});
		$("#indent_time").ptTimeSelect();
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

	function add_inventory_item_element(selector, item_id, item_elements, current_items, index) {
		let quantity_indented = $(`[name = 'quantity_indented[]']`);
		let current_sum = sum_quantities($(`[name="quantity_${item_id}[]"]`), 'value');
		//console.log("SAIRAM FROM ADDINVITELEMENT", Number(quantity_indented[index].value), current_sum);
		let balance = Number(quantity_indented[index].value) - current_sum;
		current_items[index].quantity_added_inventory = Number(quantity_indented[index].value);
		// console.log($(item_elements[index]).selectize()[0].selectize.getValue());
		let sel = $(item_elements[index]).selectize()[0].selectize;
		//console.log(sel.options, Number(sel.getValue()));
		let option_text = sel.options[Number(sel.getValue())].item_name;
		$(selector).after(
			`<tr name="inventory_item_${item_id}[]">\
						<td><center><button name="remove_inventory_item_${item_id}[]" class="btn btn-danger item"><span class="glyphicon glyphicon-trash"> </span></button></center></td>\
							<td>\
								<div class="col">\
								${ option_text.length > 20 ? option_text.slice(0, 20) + "...": option_text}\
								</div>\
							</td>\
							<td>\
								<div class="col">\
									<input type="number"  class="form-control qty narrow"  name="quantity_${item_id}[]" min="0" step="1" placeholder="Quantity" value="${balance}" required /></td>\
								</div>\
							<td>\
								<div class="col">\
									<input type="text"  class="form-control narrow" placeholder="Batch ID" name="batch_${item_id}[]"  maxlength="10" pattern="[0-9a-zA-Z]*" />\
								</div>\
							</td>\
							<td>\
								<div class="col">\
									<input type="text"  class="form-control mfg_date_picker narrow" placeholder="Mfg. Date" name="mfg_date_${item_id}[]" />\
								</div>\
							</td>\
							<td>\
								<div class="col">\
									<input type="text"  class="form-control exp_date_picker narrow" placeholder="Expiry Date"  name="exp_date_${item_id}[]"/>\
								</div>\
							</td>\
							
							<td>\
								<div class="col">\
									<input type="text"  name="cost_${item_id}[]" class="form-control narrow" placeholder="Cost" value="0.0"/>\
								</div>\ 
							</td>\
							<td>\
								<div class="col">\
									<input type="text" name="patient_id_${item_id}[]" class="form-control narrow" placeholder="Patient ID" />\
								</div>\ 
							</td>\
							<td>\
								<div class="col">\
									<textarea name="note_${item_id}[]" class="form-control" placeholder="Note" maxlength="2000" ></textarea>
								</div>\
							</td>\
							
							<td>\
								<div class="col">\
									<input type="text" name="gtin_${item_id}[]"  class="form-control" placeholder="Barcode no." minlength="8" maxlength="14" pattern="[0-9]*" />
								</div>\
							</td>\
				  
			  </tr>`);
		//console.log($(`[name="quantity_${item_id}[]"]`));
		$('.mfg_date_picker').Zebra_DatePicker({ direction: false, format: 'd-M-Y' });
		$(".exp_date_picker").Zebra_DatePicker({ direction: true, format: 'd-M-Y' });
	}
	$(window).load(function () {
		// console.log("SAIRAM I EXIST");
		let curr_id = 0;
		let current_items = [
			{
				array_id: curr_id,
				item_id: null,
				quantity_added_inventory: 0

			}
		];
		//console.log(current_items);
		$('#error-alerts').hide();



		let item_elements = $(`[name = 'item[]']`);
		let add_inventory_item_buttons = $(`[name="add_inventory_item[]"]`);
		let quantity_elements = $(`[name = 'quantity_indented[]']`);
		let remove_inventory_item_buttons = null;

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
				//console.log('loading', $('.selectize-control.items'));
				$($('.selectize-control.items')[curr_id]).addClass('loading');
				$.ajax({
					url: '<?php echo base_url(); ?>consumables/indent_reports/search_selectize_items',
					type: 'POST',
					dataType: 'JSON', 
					data: {query: query, item_type: $('#item_type').val()},
					error: function(res) {
						
						callback();
						$($('.selectize-control.items')[curr_id]).addClass('loading');
						setTimeout(() => {

							$($('.selectize-control.items')[curr_id]).removeClass('loading');
						}, 500);
					},
					success: function(res) {
						
						callback(res.items);
						$($('.selectize-control.items')[curr_id]).addClass('loading');
						setTimeout(() => {
							//console.log('delayed loading');
							$($('.selectize-control.items')[curr_id]).removeClass('loading');
						}, 500);
					}
				});
			}
		});

		let idx = current_items.length - 1;
		$(item_elements[idx]).prop('title', $(item_elements[idx]).find('[value="' + item_elements[idx].value + '"]').html());
		let last_item_id = item_elements[idx].value;
		//console.log(last_item_id);
		if (last_item_id) {
			current_items[idx].item_id = last_item_id;
			remove_inventory_item_buttons = $(`[name="remove_inventory_item_${last_item_id}[]"]`);
			//console.log(remove_inventory_item_buttons);
		}

		$(item_elements[idx]).change(e => {
			//console.log(e.target);
			$(`[name='inventory_item_${last_item_id}[]']`).remove();
			//console.log("Toooltop", $(item_elements[idx]));
			$(item_elements[idx]).prop('title', $(item_elements[idx]).find('[value="' + item_elements[idx].value + '"]').html());
			let selected = current_items.findIndex(item => item.array_id === curr_id);
			let itemExists = current_items.findIndex(item => item.item_id == e.target.value);
			if(itemExists != -1 && itemExists !== selected){
				// e.target.value = "";
				//console.log("FIRST DUPLICATE")
				$selectize[idx].selectize.setValue("");
				return;
			}
			//console.log(selected, current_items, curr_id);
			current_items[selected].item_id = e.target.value;
			current_items[selected].quantity_added_inventory = 0;
			//console.log(current_items);
			last_item_id = current_items.find(item => item.array_id === curr_id).item_id;
			remove_inventory_item_buttons = $(`[name='remove_inventory_item_${last_item_id}[]']`);
			//console.log(remove_inventory_item_buttons);
		});

		$(add_inventory_item_buttons[idx]).click((e) => {
			// e.target.style = "background-color: red";
			//console.log(current_items);
			if (last_item_id === '' || last_item_id === null) {
				//console.log("No item selected");
				display_message("No item selected");
				return;
			}
			//console.log(item_elements[idx].value);
			if (current_items[idx].quantity_added_inventory >= Number(quantity_elements[idx].value)) {
				display_message("Quantity already satisfied.", 4000);
				return;
			}
			let specific_inventory_items = $(`[name="inventory_item_${last_item_id}[]"]`);
			let selector = null;
			if (specific_inventory_items.length === 0) {
				selector = $(add_inventory_item_buttons[idx]).parents('tr')
			} else {
				let i = specific_inventory_items.length - 1;
				//console.log(i);
				selector = specific_inventory_items[i];
			}

			add_inventory_item_element(selector, last_item_id, item_elements, current_items, idx);

			remove_inventory_item_buttons = $(`[name='remove_inventory_item_${last_item_id}[]']`);


			// Handlers
			// Remove item buttons
			$(remove_inventory_item_buttons).click(e => {
				//console.log(e.target);
				$(e.target).parents('tr').remove();
				let proposed_sum = sum_quantities($(`[name="quantity_${last_item_id}[]"]`), 'value');
				if (proposed_sum <= Number(quantity_elements[idx].value)) {
					$('#error-alerts').hide();

				}
				current_items[idx].quantity_added_inventory = Number(proposed_sum);
				//console.log(current_items);
			});


			//console.log("SAIRAM", $(`[name="quantity_${last_item_id}[]"]`));


			// Quantity field changed 
			$(`[name="quantity_${last_item_id}[]"]`).change(e => {
				//console.log("onchange fired");
				// console.log("SAIRAM", $(`[name="quantity_${last_item_id}[]"]`));
				let idx = current_items.findIndex(item => item.item_id === last_item_id);
				let proposed_sum = sum_quantities($(`[name="quantity_${last_item_id}[]"]`), 'value');
				if (proposed_sum > Number(quantity_elements[idx].value)) {
					//console.log("Cannot add more quantity than specified");
					display_message("Cannot add more quantity than specified");
					e.target.value = 0;

				} else {
					$('#error-alerts').hide();
				}
				current_items[idx].quantity_added_inventory = sum_quantities($(`[name="quantity_${last_item_id}[]"]`), 'value');
				//console.log(current_items);
			});



		});

		$('#add_item').click((e) => {
			let n = current_items.length;
			let last_item_id = current_items[n - 1].item_id;
			//console.log("LID", last_item_id);
			let current_item_array_id = curr_id + 1;
			let item_elements = $(`[name = 'item[]']`);
			let specific_inventory_items = $(`[name="inventory_item_${last_item_id}[]"]`);
			let selector = null;
			if (specific_inventory_items.length === 0) {
				selector = $(item_elements[n - 1]).parents('tr');

			} else {
				selector = specific_inventory_items[specific_inventory_items.length - 1];
			}
			$(selector).after(`
				<tr name="indent_item" class="warning indent_item indent_item_delimiter inventory_item_delimiter_">
					<td id="change">
						<center><button type='button' name="add_inventory_item[]" class="btn item"><span
									class="glyphicon glyphicon-plus"></span></button></center>
					</td>
					<td class="item_name" colspan="5">
					<select name="item[]" id="item" class="items"  data-toggle="tooltip" data-placement="bottom" title="" required>
						<option value="">Select</option>
						
					</select>
					</td>
					<td><input class="form-control narrow" type="number" min="0"
							value="0"
							name="quantity_indented[]" /></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>

					<td></td>
					<td><textarea
							name="item_note[]" placeholder="Note"></textarea>
					</td>
					<td><button type="button" name="remove_item_${current_item_array_id}" id="remove_item_${current_item_array_id}" class="btn btn-danger" ><span class="glyphicon glyphicon-trash"></span></button></td>
					
					

					<!-- name="add_$indent_item->id" -->

				</tr>
				`);

			current_items.push({
				array_id: ++curr_id,
				item_id: null
			});

		item_elements = $(`[name = 'item[]']`);
		let quantity_elements = $(`[name = 'quantity_indented[]']`);
		let add_inventory_item_buttons = $(`[name="add_inventory_item[]"]`);
		let remove_inventory_item_buttons = null;

		let current_item_id = null;
		let idx = current_items.length - 1;
		//console.log("IEIDX", idx, $(item_elements[idx]));
		// let $selectize = $('[name="item[]"]').selectize({
		// 	maxOptions: 10
		// });
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
		//console.log(options);
		// let temp = [];
		
		$selectize = $('[name="item[]"]').selectize({
			labelField: "item_name",
			searchField: "item_name",
			valueField: "item_id",
			options: options,
			// allowEmptyOption: true, 
			// showEmptyOptionInDropdown: true, 
			maxOptions: 10,
			load: function(query, callback) {
				if(!query.length) return callback();
				//console.log('loading', $('.selectize-control.items'));
				$($('.selectize-control.items')[idx]).addClass('loading');
				$.ajax({
					url: '<?php echo base_url(); ?>consumables/indent/search_selectize_items',
					type: 'POST',
					dataType: 'JSON', 
					data: {query: query, item_type: $('#item_type').val()},
					error: function(res) {
						
						callback();
						$($('.selectize-control.items')[idx]).addClass('loading');
						setTimeout(() => {

							$($('.selectize-control.items')[idx]).removeClass('loading');
						}, 500);
					},
					success: function(res) {
						
						callback(res.items);
						$($('.selectize-control.items')[idx]).addClass('loading');
						setTimeout(() => {
							//console.log('delayed loading');
							$($('.selectize-control.items')[idx]).removeClass('loading');
						}, 500);
					}
				});
			}
		});
			$(item_elements[idx]).change(e => {
				$(`[name="inventory_item_${current_item_id}[]"]`).remove();
				//console.log("Toooltop", $(item_elements[idx]));
				$(item_elements[idx]).prop('title', $(item_elements[idx]).find('[value="' + item_elements[idx].value + '"]').html());
				let selected = current_items.findIndex(item => item.array_id === current_item_array_id);
				let itemExists = current_items.findIndex(item => item.item_id == e.target.value);
				if(itemExists != -1 && itemExists !== selected){
					//console.log("SAIRRRRRRRRRRAM item exists");
					// console.log(e);
					// e.target.value = "";
					//console.log($selectize);
					//console.log("second duplicate");
					$selectize[idx].selectize.setValue("");
					return;
				}
				//console.log(selected, current_items, current_item_array_id);
				current_items[selected].item_id = e.target.value;
				current_items[selected].quantity_added_inventory = 0;
				current_item_id = current_items[idx].item_id;
				remove_inventory_item_buttons = $(`[name="remove_inventory_item_${current_item_id}[]"]`)
				//console.log(current_item_id);
			});
			//console.log(current_items);

			$(`[name="remove_item_${current_item_array_id}"]`).click((e) => {
				//console.log("FLAG", e);
				current_items = current_items.filter(item => item.array_id !== current_item_array_id);
				$(`[name="remove_item_${current_item_array_id}"]`).parents('tr').remove();
				$(`[name="inventory_item_${current_item_id}[]"]`).remove();
				//console.log(current_items);

			});




			$(add_inventory_item_buttons[idx]).click((e) => {
				// e.target.style = "background-color: red";

				if (current_item_id === '' || current_item_id === null) {
					//console.log("No item selected");
					display_message("No item selected");
					return;
				}

				if (current_items[idx].quantity_added_inventory >= Number(quantity_elements[idx].value)) {
					//console.log("Quantity already satisfied.");
					display_message("Quantity already satisfied.");
					return;
				}
				//console.log($(item_elements[idx]));
				let specific_inventory_items = $(`[name="inventory_item_${current_item_id}[]"]`);
				let selector = null;
				if (specific_inventory_items.length === 0) {
					selector = $(add_inventory_item_buttons[idx]).parents('tr')
				} else {
					let i = specific_inventory_items.length - 1;
					//console.log(i);
					selector = specific_inventory_items[i];
				}
				add_inventory_item_element(selector, current_item_id, item_elements, current_items, idx);
				remove_inventory_item_buttons = $(`[name="remove_inventory_item_${current_item_id}[]"]`);



				$(remove_inventory_item_buttons).click(e => {
					$(e.target).parents('tr').remove();
					let proposed_sum = sum_quantities($(`[name="quantity_${current_item_id}[]"]`), 'value');
					if (proposed_sum <= Number(quantity_elements[idx].value)) {
						$('#error-alerts').hide();

					}
					current_items[idx].quantity_added_inventory = Number(proposed_sum);
					//console.log(current_items);

				});

				// Quantity integrity

				$(`[name="quantity_${current_item_id}[]"]`).change(e => {
					//console.log("SAIRAM ")
					let idx = current_items.findIndex(item => item.item_id === current_item_id);
					let proposed_sum = sum_quantities($(`[name="quantity_${current_item_id}[]"]`), 'value');
					if (proposed_sum > Number(quantity_elements[idx].value)) {
						//console.log("Requirement satisfied");
						display_message("Requirement satisfied");
						e.target.value = 0;

					} else {
						$('#error-alerts').hide();
					}
					current_items[idx].quantity_added_inventory = proposed_sum;
					//console.log("SAIRAM QTIES", current_items);
				});

			});



		});


		$('#auto_indent_form').submit(e => {
			//console.log("Trying to submit");
			let quantity_elements = $(`[name = 'quantity_indented[]']`);
			console.log(current_items);
			console.log();
			for (let i = 0; i < current_items.length; i++) {

				if (current_items[i].quantity_added_inventory != quantity_elements[i].value) {
					display_message("Quantities of different items must match the number that have been issued.")
					e.preventDefault();
					return;
				}

				let cost_elements = $(`[name = 'cost_${current_items[i].item_id}[]']`);
				let qty_elements = $(`[name = 'quantity_${current_items[i].item_id}[]']`);
				//console.log(cost_elements);
				//console.log(`[name = 'quantity_${current_items[i].item_id}[]']`, qty_elements);
				// alert();
				// e.preventDefault();
				// return;
				for(let j = 0; j < qty_elements.length; j++){
					//console.log(qty_elements[j].value);
					if(qty_elements[j].value == 0){
						display_message("Quantity cannot be 0");
						e.preventDefault();
						return;
					}
				}
				for(let j = 0; j < cost_elements.length; j++){
					//console.log(cost_elements[j].value, isNaN(Number(cost_elements[j].value)));
					// alert("");
					if(cost_elements[j].value.length == 0){
						cost_elements[j].value = '0.0';
					}
					if(isNaN(Number(cost_elements[j].value)) || Number(cost_elements[j].value) < 0.0){
						display_message("Cost has to be a number");
						e.preventDefault();
						return;
					}
				}
			}

		})
	});

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
<script>
	
</script>

<style>
	/* #add_item {
		width: 50%;
	} */
</style>

<div class="col-md-11 col-md-offset-2">
	<?php echo form_open('consumables/indent/auto_indent', array('class' => 'form-custom', 'role' => 'form', 'id' => 'auto_indent_form')) ?><!-- Issued details from open -->
	<input type="hidden" name="auto_indent" value="1" />
	<div class="row">
		<div class="col-md-12">

			<div class="panel panel-success">
				<div class="panel-heading">


					<center>
						<h1>Indent Add/Approve/Issue</h1>
					</center>
				</div>
				<div class="panel-body">

					<div class="row">

						<div class="col-md-2"> <!--indent date-->
							<div class="form-group">
								<label for="indent_date">Indent Date</label>
								<input class="form-control" type="text" value="<?php echo date("d-M-Y"); ?>"
									name="indent_date" id="indent_date" size="10" required />
							</div>
						</div> <!-- end of Indent Date-->
						<div class="col-md-2"> <!-- Indent Time-->
							<div class="form-group">
								<label for="indent_time">Indent Time</label>
								<input class="form-control" type="text" style="background-color:#EEEEEE"
									value="<?php echo date("h:i A"); ?>" name="indent_time" id="indent_time"
									size="7px" />
							</div>
						</div> <!-- end of Indent Time-->
						<div class="col-md-3"> <!-- From party-->
							<div class="form-group">
								<label for="from_id">Indent From Party<font color='red'>*</font></label>
								<select name="from_id" id="from_id" class="form-control wide" required>
									<option value="">Select</option>
									<?php
									foreach ($parties as $fro) {
										echo "<option value='" . $fro->supply_chain_party_id . "'>" . $fro->supply_chain_party_name . "</option>";

									}
									?>

								</select>
							</div>
						</div> <!--end of From party-->
						<div class="col-md-3"> <!-- To party-->
							<div class="form-group">
								<label for="to_id">Indent To Party<font color='red'>*</font></label>
								<select name="to_id" id="to_id" class="form-control wide" required>
									<option value="">Select</option>
									<?php
									foreach ($parties as $t) {
										echo "<option value='" . $t->supply_chain_party_id . "'>" . $t->supply_chain_party_name . "</option>";

									}
									?>
								</select>
							</div>
						</div>




					</div>
					<br>
					<br>

					<div class="row">
						<div class="col-md-2">
							<button type="button" name="add_item" id="add_item" class="btn btn-primary">Add Item
								+</button>
						</div>
					</div>
					<br>
					<div class="row">



						<div>
							<div id="error-alerts" style="max-width: 25%; margin: auto;">
								<div class="alert alert-danger">
									<center>
										<p id="error-message"></p>
									</center>
								</div>
							</div>
							<div class="issue_invoice">
								<table id="issue_invoice_table" class="table" style="border: 2px solid #ccc;">
									<thead>
										<th></th>
										<th>Item Name<font color="red">*</font>
										</th>
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

									<tbody id="table-body" style="height:160px!important;">
										<!-- name="indent_item_$indent_item->id" -->
										<tr name="indent_item" class="warning indent_item indent_item_delimiter inventory_item_delimiter_">
											<td id="change">
												<center><button type='button' name="add_inventory_item[]"
														class="btn item"><span
															class="glyphicon glyphicon-plus"></span></button></center>
											</td>
											<td class="item_name" colspan="5">
												<select name="item[]" id="item" class="items" data-toggle="tooltip" data-placement="bottom" title="" required>
													<option value="">Select</option>
													
												</select>
											</td>
											<td><input class="form-control narrow" type="number" min="0" value=""
													name="quantity_indented[]" placeholder="Quantity"/></td>
											<td></td>
											<td></td>
											<td></td>
											<!-- <td>Current Cost: <span id="cost_total">0</span></td> -->
											<td></td>
											<td></td>
											<td><textarea name="item_note[]" placeholder="Note" value=""></textarea>
											</td>
											<!-- <td><button type="button" name="add_item" id="add_item"
													class="btn btn-primary">Add +</button></td> -->

											<td></td>

											<!-- name="add_$indent_item->id" -->

										</tr>






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
								placeholder="Add a note for the indent"></textarea>
						</div>

					</div>
				</div>
				<div class="row">
					<div class="col-md-8">
						<div class="panel-heading">
							<p class="panel-title">
								<center>


									<Button type="submit" name="Submit" value="submit" id="btn"
										class="btn btn-success">Issue</Button>


								</center>
							</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php echo form_close(); ?><!-- End of Issued details form -->

	</div>


</div>