
<head>
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
		$("#approval_date").Zebra_DatePicker({direction:['<?= date("d-M-Y", strtotime($indent_approval[0]->indent_date)); ?>' , '<?= date('d-M-Y'); ?>']});
		$("#approval_time").ptTimeSelect();
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
</script>
<script type="text/javascript">
$(window).load(function() {
	console.log("SAIRAM I EXIST");
	
	let current_quantities = { <?php foreach ($indent_approval as $all_int) {
		echo "$all_int->indent_item_id : {qty: $all_int->quantity_indented, changed: false, rejected: false}, ";
	} ?> 

	};
	console.log(current_quantities);


	let num_changes = 0;
	$('.to-be-hidden-two').hide();
	for(const quantity_name in current_quantities){
		let qty_el = $(`[name=quantity_approved_${quantity_name}]`);
		num_quantities = Object.keys(current_quantities).length;
		console.log(qty_el.val(), current_quantities[quantity_name].qty, num_quantities);
		if(qty_el.val() == current_quantities[quantity_name].qty){
			// $(`.to-be-hidden`).hide();
			// console.log("HIDDEN");
			current_quantities[quantity_name].changed = false;
		}else{
			// $(`.to-be-hidden`).show();
			// console.log("SHOWN");
			current_quantities[quantity_name].changed = true;
		}
		
		qty_el.change((event) => {
				let result = event.target.value;
			
					if(result === null || result === "") // Cancel
						return;
					// console.log(result, typeof(result));
					console.log(num_changes);
					
					let new_quantity = result;

					if(new_quantity != current_quantities[quantity_name].qty){
						current_quantities[quantity_name].changed = true;
					}else{
						current_quantities[quantity_name].changed = false;
					}
					
					let changed = false;
					console.log(current_quantities);

					for(const quantity_name in current_quantities){
						if(current_quantities[quantity_name].changed){
							changed = true;
							$(`.to-be-hidden`).show();
							break;
						}
					}
					if(!changed){
						$(`.to-be-hidden`).hide();
					}
					
			});
		


		$(`[name=indent_status_${quantity_name}]`).change((event) => {
			let indent_status = event.target.value;
			if(indent_status === "Rejected"){
				current_quantities[quantity_name].rejected = true;
			}else if(indent_status === "Approved"){
				current_quantities[quantity_name].rejected = false;
			}

			let rejected = false;
			for(const quantity_name in current_quantities){
				if(current_quantities[quantity_name].rejected){
					rejected = true;
					$('.to-be-hidden-two').show();
					break;
				}
			}
			if(!rejected){
				$('.to-be-hidden-two').hide();
			}
		});



		
	}
	let changed = false;
	console.log(current_quantities);
	for(const quantity_name in current_quantities){
		if(current_quantities[quantity_name].changed){
			changed = true;
			$(`.to-be-hidden`).show();
			break;
		}
	}
	if(!changed){
		$(`.to-be-hidden`).hide();
	}
	
	// $('#approval_form').submit((event) => {
		
	// 		let result = confirm("Are you sure you want to submit ?");
	// 		if(!result){
	// 			event.preventDefault();
	// 		}
			
	// });
	
	});

</script>
</head>
<body>
<div class="col-xs-1 col-md-offset-2">
    <div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-success">
					<div class="panel-heading" ><center> 
					
					<h3> Indent </h3><!-- Heading -->
					<?php foreach($indent_approval as $all_int) { ?>
					<p class="panel-title">Indent ID : <?php echo $all_int->indent_id;?>     &nbsp;&nbsp;&nbsp;     Indent Date :  <?php echo date("d-M-Y g:i A", strtotime($all_int->indent_date)); ?> </p>
					<?php  break; } ?>
					</center>
					</div> 
				</div> 
			</div>
			
		</div>
		<!-- <hr style="border: 2px solid black;"> -->
		<?php echo form_open('consumables/indent_approve/indent_approval',array('class'=>'form-custom','role'=>'form', 'id' => 'approval_form'))?> <!-- Approval details form open-->
				<div class="container">
					<div class="row">
						<div class="col">
							<div class="alert alert-warning to-be-hidden">
								It is advisable to enter a reason for changing quantity.
							</div>
							<div class="alert alert-warning to-be-hidden-two">
								It is advisable to enter a reason for rejecting item.
							</div>
						</div>
					</div>
					<div class="row" style="margin: 1% 0%;">
						<div class="col-md-2">  <!--indent approval date-->
							<div class="form-group">
								<label for="approval_date">Approval Date</label>
								<input class="form-control" type="text" value="<?php echo date("d-M-Y"); ?>" name="approval_date" id="approval_date" size="10"/>
							</div>
						</div>					<!-- end of Indent approval Date-->
						<div class="col-md-2">	<!-- Indent approval Time-->
							<div class="form-group">
								<label for="approval_time">Approval Time</label>
								<input  class="form-control" type="text" style = "background-color:#EEEEEE" value="<?php echo date("h:i A"); ?>" name="approval_time" id="approval_time" size="7px"/>
							</div>
						</div>					<!-- end of Indent approval Time-->
						
				</div>
			<!-- </div> -->
            	<div class="row" >
			 		<div class = "col-md-4">
						<div class="form-group"><!-- From label-->
						    <b>Indent From Party:</b>
								<?php echo  $all_int->from_party; ?>
						</div><!-- End of from label-->
					</div>
					<div class = "col-md-4">
						<div class="form-group"><!-- To label-->
							<b>Indent To Party:</b>
							<?php echo $all_int->to_party; ?>
						</div><!-- End of to label-->
					</div>
				</div>
				<div class="row" >
					<div class="col-md-11">
						<table class="table table-bordered table-striped"  id="bootstrap_git_demo">
							<thead>
							    <th><center>SNO</center></th>
								<th><center>Items</center></th>
								<th><center>Quantity Indented</center></th>
								<th><center>Quantity Approved</center></th>
								<th><center>Note</center></th>
								<th><center>Indent Status</center></th>
							</thead>
				           <tbody>
					            <?php
					               $i=1; $j=1;
					               foreach($indent_approval as $all_int)
					               {
					               ?>
					               <tr>
								   <div class="form-group">
								    <td align="center"><?php  echo $j++; ?>
									     </td>
									</div>
					                <div class="form-group"> 
					                      <td align="left"><?php echo  $all_int->item_name."-".$all_int->item_type."-".$all_int->item_form."-".$all_int->dosage.$all_int->dosage_unit ;?></td>
										 
					                </div>
					                <div class="form-group">
					                      <td align="right"><?php echo $all_int->quantity_indented;?></td>
					                </div>
					                <div class="form-group">
					                      <td align="right"><input type="number" class="form-control" min="1"  step="1"  name="quantity_approved_<?= $all_int->indent_item_id;?>" id="quantity_id" value="<?php echo $all_int->quantity_indented;?>" placeholder="Enter Quantity " required> 
										  
					                      </td>
										  
					                </div>
									<div class="form-group">
					                      <td align="right">
											<!-- <input type="textarea" class="form-control" name="indent_item_note_<?php // echo $all_int->indent_item_id ?>" id="indent_item_note" value="<?php // echo $all_int->note;?>" placeholder="Enter reason for change"> -->
											<textarea name="indent_item_note_<?php echo $all_int->indent_item_id ?>" id="indent_item_note"  placeholder="Enter reason for change"><?php echo $all_int->note;?></textarea>
										</td>
					                </div>
									
					                <td align="center">
						              <label class="btn btn-success active">  
						                <input type='radio'	 value='Approved'  name='indent_status_<?= $all_int->indent_item_id;?>'  checked />Approved
						              </label>
						              <label class="btn btn-danger active">
									    
						                <input type='radio' value='Rejected'  name='indent_status_<?= $all_int->indent_item_id;?>'   />Rejected
						                <input type="hidden" value="<?= $all_int->indent_item_id;?>" class="sr-only" name="indent_item[]" />
				                      </label>
						              <?php  $i++; } ?>
                                   </td>   
								 </tr> 
		              </tbody>
		         </table>
		     </div>
		   </div>
		   </div>
        <div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group form-group-lg">
					<label for="indent_note">Note </label><br>
					<textarea class="form-control" name="indent_note" id="indent_note" placeholder="Add a note for the indent"><?php echo $all_int->indent_note?></textarea>
				</div>

			</div>
		</div>	
		   <div class="row">
			<div class="col-md-12">
				<div class="panel-heading"><p class="panel-title">
					<center>
						<input type="hidden" value="<?= $indent_approval[0]->indent_id;?>" class="sr-only" name="indent" /> 
						<Button type="submit" name="approve" value="submit" id="btn" class="btn btn-success">submit</Button>
						 <input type="hidden" name="selected_indent_id" value="<?php echo $all_int->indent_id;?>"/>
						</center></p>
				</div>
			</div>
		</div>
	  </div>
	  <?php echo form_close();?><!-- End of approval details form -->
    </div>
</body>


