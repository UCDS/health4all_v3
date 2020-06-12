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
		$("#indent_date").Zebra_DatePicker({direction:false});
		$("#indent_time").ptTimeSelect();
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
<script>
$(function(){
$('#to_id  option[value="'+$('#from_id').val()+'"]').hide();
$('#from_id').change(function(){
	$("#to_id option").show();
    var optionval = this.value;
    $('#to_id  option[value="'+optionval+'"]').hide();
    
});
});
$(function(){
$('#from_id  option[value="'+$('#to_id').val()+'"]').hide();
$('#to_id').change(function(){
	$("#from_id option").show();
    var optionval = this.value;
    $('#from_id  option[value="'+optionval+'"]').hide();
    
});
});
</script>
<style>
#slot_table
{
    counter-reset: Serial;           /* Set the Serial counter to 0 */
    border-collapse: collapse;
}
#slot_table tr td:first-child:before
{
  counter-increment: Serial;      /* Increment the Serial counter */
  content: "" counter(Serial); /* Display the counter */
}
</style>
<?php
	$indent_date=0;
	if($this->input->post('indent_date')) $indent_date=date("d-M-Y",strtotime($this->input->post('indent_date'))); else $indent_date = date("d-M-Y");
	$indent_time=0;
	if($this->input->post('indent_time')) $indent_time=date("H:i",strtotime($this->input->post('indent_time'))); else $indent_time = date("g:i A
	");
	
?>
<div class="center-block">
<?php if($mode=="auto_indent") { ?>
<h2 align="center">Add Indent/Approve/Issue Form</h2></br>
<?php } else{ ?>
	<h2 align="center">Add Indent Form</h2></br>
<?php }?>
	  <?php echo form_open('consumables/indent/add_indent',array('class'=>'form-group','role'=>'form','id'=>'evaluate_applicant')); ?>
		<div class="col-xs-4 col-md-offset-2">
            <div class="container">
				<div class="row">
                        <div class="col-md-2">  <!--indent date-->
							<div class="form-group">
								<label for="indent_date">Indent Date</label>
							    <input class="form-control" type="text" value="<?php echo date("d-M-Y"); ?>" name="indent_date" id="indent_date" size="10"/>
							</div>
						</div>					<!-- end of Indent Date-->
						<div class="col-md-2">	<!-- Indent Time-->
							<div class="form-group">
								<label for="indent_time">Indent Time</label>
								<input  class="form-control" type="text" style = "background-color:#EEEEEE" value="<?php echo date("h:i A",strtotime($indent_time)); ?>" name="indent_time" id="indent_time" size="7px"/>
							</div>
						</div>					<!-- end of Indent Time-->
						<div class="col-md-3">	<!-- From party-->
							<div class="form-group">
								<label for="from_id">From Party<font color='red'>*</font></label>
								<select name="from_id" id="from_id" class="form-control" required>
								<option value="">Select</option>
								<?php
								foreach($parties as $fro)
									{
										echo"<option value='".$fro->supply_chain_party_id."'>".$fro->supply_chain_party_name."</option>";
									
									}
								?>
								</select>
							</div>	
						</div>					<!--end of From party-->
						<div class="col-md-3">	<!-- To party-->
							<div class="form-group">
								<label for="inputto_id">To Party<font color='red'>*</font></label>
								<select name="to_id" id="to_id" class="form-control" required>
								<option value="">Select</option>
								<?php
								foreach($parties as $t)
									{
										echo"<option value='".$t->supply_chain_party_id."'>".$t->supply_chain_party_name."</option>";
									
									}
								?>
								</select>
							</div>	
						</div>					<!-- end of To party-->
			</div>
		</div></br>
						
		<div class="container">
			<div class="row">
				<div class="col-md-7 col-md-offset-1">
					<table style="width:900px;height:100px;text-align:center;border:2px solid #ccc;background:#f6f6f6;border-spacing:10px;" class="table table-bordered" id="slot_table"> 
						<thead>
							<tr id="slot_row_">
								<th class="col-md-1"><center>#</center></th>
								<th class="col-md-4"><center>Item</center></th>
								<th class="col-md-1"><center>Quantity</center></th>
								<th class="col-md-1"></th>
							</tr>
						 </thead>
							<tr id="slot_row_">
								<td>
								</td>
								<td>
									<div class="form-group">	<!--Item-->
										<select name="item[]" id="item" class="form-control" required>
										<option value="">Select</option>
										<?php
										foreach($all_item as $t)
											{
												echo"<option value='".$t->item_id."'>".$t->item_name."-".$t->item_form."-".$t->dosage.$t->dosage_unit."</option>";
											}
										?>
									   </select>
									 </div>						<!--end of Item-->
								 </td>
			                     <td>
				                       
								<div class="form-group">
										<input type="number" min="1" step="1" class="number form-control" name="quantity_indented[]" required  /></div>
								</td>
								<td><input type="button" id="addbutton" class="btn btn-primary" value="Add+" /></td>
							</tr>
						</table>
					</div>
				 </div>
			</div>
				    
				    <div class="container">						
							<div class="row">
								<div class="col-md-9">
									<center><button class="btn btn-primary" type="submit" name="Submit" value="Submit" id="btn">Submit</button>
									<?php if($mode=="auto_indent") { ?>
									<input type="hidden" name="auto_indent" value="1"/>
									<?php }else { ?>
									<input type="hidden" name="auto_indent" value="0"/>
									<?php } ?>
									</center>
								</div>
								
							</div>
					</div>
			</div>
	     <?php echo form_close(); ?> 
	 </div>
		 
	     










				















