<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/metallic.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
<script type="text/javascript">
		var rowcount=0;
		$(function(){
		$("#issue_date").Zebra_DatePicker({direction:false});
		$("#issue_time").ptTimeSelect();
		$("#addbutton").click(function(){
			var sno="<td>"+ " " +"</td></br>";
			
			var item ="<td><div class='form-group'><select name='item[]' id='item' class='form-control' required><option value=''>Select</option>";
			<?php foreach($all_item as $t){ ?>
				item +="<option value='<?php echo $t->item_id;?>'><?php echo $t->item_name."-".$t->item_form."-".$t->item_type."-".$t->dosage.$t->dosage_unit;?></option>";
			<?php } ?>
			item += "</select></td>";
			var quantity="<td><input type='number' class='number form-control' name='quantity_indented[]' required /></td></br>";
		    var remove="<td><button value='X' class='btn btn-danger remove show-tip' onclick='$(\"#slot_row_"+rowcount+"\").remove();'><span class='glyphicon glyphicon-trash'></span></button></td>";
			$("#slot_table").append("<tr id='slot_row_"+rowcount+"'>"+sno+item+quantity+remove+"</tr>");
			rowcount++;

		});
	});
	
</script>
<script type='text/javascript'>
$(window).load(function(){<!--from   w  w  w.  ja v a 2s.  c  om-->
$(function () {
    $("table#bootstrap_git_demo").on("click", ".remove", function () {
        $(this).closest('tr').remove();
    });
});
$(function () {
    $(".show_tip").tooltip({
        container: 'body'
    });
});
$(document).click(function () {
    $('.tooltip').remove();
    $('[title]').tooltip();
  });
});
$(window).load(function() {
	console.log("SAIRAM I EXIST");
	
	let current_quantities = { <?php foreach ($indent_issued as $all_int) {
		echo "$all_int->indent_item_id : {qty: $all_int->quantity_approved, changed: false, change_notes: ''}, ";
	} ?> 

	};
	console.log(current_quantities);
	let quantity_changed = false;

	
	
	for(const quantity_name in current_quantities){
		console.log(quantity_name, current_quantities[quantity_name]);
		$(`[name=indent_qty_change_${quantity_name}]`).click((event) => {
			console.log("Quantity change button clicked");
			bootbox.prompt({
				title: 'Change quantity',
				inputType: 'number', 
				value: `${current_quantities[quantity_name].qty}`, 
				callback: function (result) {
					if(result === null || result === "") // Cancel
						return;
					console.log(result, typeof(result));
					let justified = false;
					let new_quantity = result;

					if(new_quantity != current_quantities[quantity_name].qty){
						new_quantity = result;
						bootbox.prompt({
							title: 'Add note to justify change', 
							inputType: 'textarea', 
							value: "", 
							required: true, 
							callback: function (result) {
								if(result === "" || result === null){
									bootbox.alert("Please provide reason for change of quantity.");
									
								}else if(result !== ""){
									current_quantities[quantity_name].change_notes = result;
									let change_note = `Quantity change reason:\n${result}`;
									$(`[name=indent_item_note_${quantity_name}]`).val( change_note
									+ '\n' 
									);
									justified = true;							
								}
								if(justified){
									console.log("New quantity", new_quantity);
									$(`[name=quantity_issued_${quantity_name}]`).val(new_quantity);
									current_quantities[quantity_name].changed = true;
								}
							}
						});
						
					}else{
						bootbox.alert("No change in quantity");
						current_quantities[quantity_name].changed = false;
					}
				}
			});
		});


		

		$(`[name=item_note_change_${quantity_name}]`).click((event) => {
			if(!current_quantities[quantity_name].changed)
				return;
			
			bootbox.prompt({
				title: 'Edit reason', 
				inputType: 'textarea', 
				value: current_quantities[quantity_name].change_notes, 
				required: true, 
				callback: function (result) {
					let res = result;
					if(res === null || res === ""){
						bootbox.alert("Please provide reason");
						return;
					}
					

					current_quantities[quantity_name].change_notes = res;

					$(`[name=indent_item_note_${quantity_name}]`).val(`Quantity change reason:\n${current_quantities[quantity_name].change_notes}`
								+ '\n' );
					



				}
			});
		});
	}

	$('#approval_form').submit((event) => {
		
			let result = confirm("Are you sure you want to submit ?");
			if(!result){
				event.preventDefault();
			}
			
	});
	$('#current_date_check').prop('checked', true);
	if($('#current_date_check').prop('checked') === true){
		$('#approval_date').prop('disabled', true);
		$('#approval_time').prop('disabled', true);
		$('.maybe_hidden').hide();
	}else{
		$('#approval_date').prop('disabled', false);
		$('#approval_time').prop('disabled', false);

		$('.maybe_hidden').show();
	}
	// console.log("INITIAL CHECK VALUE", curr_check_val);

	$('#current_date_check').change((event) => {
		console.log(event.target.checked);
		if(event.target.checked){
			$('#approval_date').prop('disabled', true);
			$('#approval_time').prop('disabled', true);
			$('.maybe_hidden').hide();
		}else{
			$('#approval_date').prop('disabled', false);
			$('#approval_time').prop('disabled', false);
			$('.maybe_hidden').show();
		}
			
	});
});
</script>
<div class="col-xs-1 col-md-offset-1">
    <div class="container">
	<div class="row">
    <div class="col-md-10">
	<div class="panel panel-success">
        <div class="panel-heading" ><center>    
		<h3> Indent </h3><!-- Heading -->
		<?php foreach($indent_issued as $all_int) { ?>
		<p class="panel-title">Indent ID : <?php echo $all_int->indent_id;?>     &nbsp;&nbsp;&nbsp; Indent Date : <?php echo date("d-M-Y g:i A", strtotime($all_int->indent_date)); ?> &nbsp;&nbsp;&nbsp;    Approval Date : <?php echo date("d-M-Y g:i A", strtotime($all_int->approve_date_time)); ?> </p>
		<?php  break; } ?>
		</center>
        </div> 
	</div> 
	</div>
	</div>
	</div>
    <?php echo form_open('consumables/indent_issue/indent_issued',array('class'=>'form-custom','role'=>'form'))?><!-- Issued details from open -->
			<div class="container">
			<div class="row">
					<div class="form-group">
								<label for="current_date_check">Set issue date and time as time of submission</label>
								<input class="form-control" type="checkbox" checked=false value="set_as_current" name="current_date_check" id="current_date_check" size="10"/>
							</div>
					</div>
					<div class="row maybe_hidden">
						<div class="col-md-2">  <!--indent issue date-->
							<div class="form-group">
								<label for="issue_date">Issue Date</label>
								<input class="form-control" type="text" value="<?php echo date("d-M-Y"); ?>" name="issue_date" id="issue_date" size="10"/>
							</div>
						</div>					<!-- end of Indent issue Date-->
						<div class="col-md-2">	<!-- Indent issue Time-->
							<div class="form-group">
								<label for="issue_time">Issue Time</label>
								<input  class="form-control" type="text" style = "background-color:#EEEEEE" value="<?php echo date("h:i A"); ?>" name="issue_time" id="issue_time" size="7px"/>
							</div>
						</div>					<!-- end of Indent approval Time-->
						
				</div>
            	<div class="row" >
			 		<div class = "col-md-4">
						<div class="form-group"><!-- From label-->
						    <b>	From :</b>
								<?php echo  $all_int->from_party; ?>
						</div><!-- End of from label-->
					</div>
					<div class = "col-md-4">
						<div class="form-group"><!-- To label-->
							<b>To :</b>
							<?php echo $all_int->to_party; ?>
						</div><!-- End of to label -->
					</div>
				</div>
				<div class="row" >
					<div class="col-md-10">
						<table class="table table-bordered table-striped"  id="bootstrap_git_demo">
							<thead>
							    <th><center>#</center></th>
								<th><center>Item Name</center></th>
								<th><center>Quantity Approved</center></th>
								<th><center>Approval Note</center></th>
								<th><center>Quantity Issued</center></th>
								<th><center>Issue Note</center></th>
								<th><center>Additional notes</center></th>
							</thead>
				           <tbody>
					            <?php
					                $j=1;
					               foreach($indent_issued as $all_int)
					               {
					               ?>
					               <tr>
								   <div class="form-group">
								    <td align="center"><?php  echo $j++;
									    ?> </td>
									</div>
					                <div class="form-group"> 
					                      <td align="left"><?php echo  $all_int->item_name."-".$all_int->item_type."-".$all_int->item_form."-".$all_int->dosage.$all_int->dosage_unit ;?></td>
					                </div>
					                <div class="form-group">
					                      <td align="right"><?php echo $all_int->quantity_approved;?></td>
					                </div>
									<div class="form-group">
					                      <td align="right"><input type="textarea" name='<?php echo "indent_approved_item_note_$all_int->indent_item_id"; ?>' value='<?php echo $all_int->note; ?>' readonly></td>
					                </div>
					                <div class="form-group">
					                      <td align="right">
											<input type="number" class="form-control" min="1"  step="1"  name="quantity_issued_<?= $all_int->indent_item_id;?>" id="quantity_id" value="<?php echo $all_int->quantity_approved;?>" placeholder="Enter Quantity " required readonly>
											<button type="button" name="indent_qty_change_<?php echo $all_int->indent_item_id ?>" class="btn btn-warning">Change quantity</button>
                                           <input type="hidden" value="<?= $all_int->indent_item_id;?>" class="sr-only" name="indent_item[]" />
					                      </td>
					                </div>
									<div class="form-group">
					                      <td align="right"><input type="textarea" name='<?php echo "indent_item_note_$all_int->indent_item_id" ?>' placeholder="Enter note" readonly></td>
					                </div>
									<div class="form-group">
					                      <td align="right"><input type="textarea" class="form-control" name="item_additional_notes_<?php echo $all_int->indent_item_id ?>" id="item_additional_notes" value="" placeholder="Enter note ">
										  
					                      </td>
					                </div>
                             <?php   } ?> 
								 </tr> 
		              </tbody>
		         </table>
		     </div>
		   </div>
		   </div>
        <div class="container">
		   <div class="row">
			<div class="col-md-10">
				<div class="panel-heading"><p class="panel-title">
					<center>
                        
						<input type="hidden" value="<?= $indent_issued[0]->indent_id;?>" class="sr-only" name="indent" /> 
						<Button type="submit" name="issue" value="submit" id="btn" class="btn btn-success">issued</Button>
						<input type="hidden" name="selected_indent_id" value="<?php echo $all_int->indent_id;?>"/>
						</center></p>
				</div>
			</div>
		</div>
	  </div>
	  <?php echo form_close();?><!-- End of Issued details form -->
    </div>


