<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
 <script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>  
<script type="text/javascript">
$(function(){
	$("#from_date,#to_date").Zebra_DatePicker({direction:false});
	 $("#indent_time").ptTimeSelect();
	});
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
<script type="text/javascript" src="assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="assets/js/jquery.timeentry.min.js"></script>
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
<script>
	$(function () {
	  $('[data-toggle="popover"]').popover({trigger:'hover',html:true});
		$("#item").chained("#item_type");
	});
	</script>
	<script>
$(function(){
if($('#from_id').val() !== ''){
	$('#to_id  option[value="'+$('#from_id').val()+'"]').hide();
}
$('#from_id').change(function(){
	$("#to_id option").show();
    var optionval = this.value;
	if(optionval !== ''){
    	$('#to_id  option[value="'+optionval+'"]').hide();
	}

});
});
$(function(){
	if($('#to_id').val() !== ''){
		$('#from_id  option[value="'+$('#to_id').val()+'"]').hide();
	}
$('#to_id').change(function(){
	$("#from_id option").show();
    var optionval = this.value;
	if(optionval !== ''){
		$('#from_id  option[value="'+optionval+'"]').hide();
	}

});
});
</script>
<?php if($mode=='update') { 
	$single_approve = $approve_detail[0];
	?>
<iframe id="ifmcontentstoprint" style="height: 0px; width: 0px; position: absolute;display:none"></iframe>

			<?php echo form_open('consumables/indent_approve/indent_approval',array('class'=>'form-group','role'=>'form'));?> <!-- Indent Approval print form open-->
		   <div class ="col-md-8 col-md-offset-3"> <div class="alert alert-info"><center> <strong><?php if(isset($msg)){ echo $msg;} ?></strong> </center></div></div>
		    <div class="col-xs-4 col-md-offset-2" style="padding:30px" >
				<div class="container">
					<div class="row">
						<div class="col-md-10">
							<div class="panel panel-success">
								<div class="panel-heading">
									<center>
										<p class="panel-title"><h3>Indent</h3></p><!-- Heading-->
									</center>
								</div> 							  
								<div class="panel-body">
									<div class="panel-content">
											<div  class="span9">
												<div class="span3">
													<div class="col-md-4"><!-- Indent id -->
														<b>Indent Id :</b><?php  echo " ".$single_approve->indent_id;?>
													</div><!-- End of indent_id -->
												</div>
												<div class="span3">
													<div class="col-md-4"><!-- from party-->
													    <b>From Party : </b><?php echo " ".$single_approve->from_party;?>
													</div><!-- End of from party-->
													<div class="col-md-4"><!-- To party-->
														<b>To Party : </b><?php echo " ".$single_approve->to_party;?>
													</div><!-- End of to party-->
												</div>
											</div>
												<div class="span3">
														<div class="col-md-6"><!-- Date time-->
															<b>Indent Date Time : </b><?php echo " ".date("d-M-Y g:i A",strtotime($single_approve->indent_date));?>
														</div><!-- End of date time-->
												</div>
												<div class="span3">
													<div class="col-md-6"><!-- Date time-->
														<b>Approval Date Time : </b><?php echo " ".date("d-M-Y g:i A",strtotime($single_approve->approve_date_time));?>
													</div><!-- End of date time-->
												</div>
												
											
									</div>
								</div>
								<div class="container">
									<div class="row"> 
										<div class="col-md-9" style="margin-left:33px">
											<div class="form-group">
												<table class="table table-bordered table-striped">
													<thead>
														<th class="col-md-2"style="text-align:center">#</th>
														<th class="col-md-2"style="text-align:center">Items</th>
														<th class="col-md-2"style="text-align:center">Quantity Indented</th>
														<th class="col-md-2"style="text-align:center">Quantity Approved</th>
														<th class="col-md-2"style="text-align:center">Notes</th>
													</thead>
													<tbody>
													<?php
														$i=1;
														foreach ($approve_detail as $all_approve){
															log_message("info", "SAIRAM:::: ".json_encode($all_approve)); ?>
														<tr>
															<td><center><?php echo $i++;?></center></td>
															<td align="left"><?php echo $all_approve->item_name."-".$all_approve->item_form."-".$all_approve->item_type."-".$all_approve->dosage.$all_approve->dosage_unit;?></td>
															<td  align="right"><?php echo $all_approve->quantity_indented;?></td>
															<?php if($get_approve==1){ 
															if($all_approve->indent_status=='Approved'){?>
															<td align="right"><?php echo $all_approve->quantity_approved;?></td>
															<?php } else{ ?>
															<td align="right"><?php echo "0";?></td>
															<?php } } else { ?>
															<td align="right"><?php echo "0";?></td>
															<?php } ?>
															<td  align="right"><?php echo $all_approve->item_note;?></td>
														</tr>
													<?php } ?>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-md-9">
											<p><b>Note: </b><br> <?php 
												echo $all_approve->indent_note
											?></p>
										</div>
									</div>
								</div>
								<div class="span9">
									<div class="span3">
										<div class="col-md-12">
									   <b><?php echo "Indented"." "."by :" ;?></b><!-- Display indenter name-->
											<?php echo $all_approve->order_first." ".$all_approve->order_last;?></br></br>
										</div>
									</div>
										<div class="span3">
										<div class="col-md-12">
										<?php if($get_approve==1){  ?>
										<b><?php echo "Approved"." "."by :" ;?></b>
										<?php  }else { ?>
										<b><?php echo "Rejected"." "."by :" ;?></b>
										<?php } ?> 
											<?php echo $all_approve->approve_first." ".$all_approve->approve_last;?></br></br><!-- Display approver or rejector name based on status-->
										</div>
										</div>
										<div class="span3">
										<div class="col-md-12"><!-- Approver signature-->
										<b><?php echo "Approver Signature :" ;?></b></br></br>
										</div><!-- End of approver signature-->
								    </div>
								</div>
								<div class="row">
									<div class="col-md-12">
										<div class="panel-footer">
											<?php if($get_approve==1) { ?>
												<center><a href="<?= base_url()."consumables/indent_reports/indents_list_detailed/".$single_approve->indent_id;?>"><button type="button" class="btn btn-primary " autofocus>View in detail</button></a></center>
											<center><button class="btn btn-primary" type="button" name="print" id="print" onclick="printDiv('print-div-2')">Print</button></center>
											<?php } else { ?>
											<center></center>		
											<?php } ?>									
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
            </div>
			<?php echo form_close(); ?><!-- Indent approval print form close-->
			<?php } ?>
			<?php 
				$from_date=0;$to_date=0;$indent_time=0;
				if($this->input->post('from_date')) $from_date=date("Y-m-d",strtotime($this->input->post('from_date'))); else $from_date =date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) );
				if($this->input->post('to_date')) $to_date=date("Y-m-d",strtotime($this->input->post('to_date'))); else $to_date = date("Y-m-d");
            ?>
			<div class="container">
			    <div class="row">
						<div class="col-md-8 col-md-offset-5">
							<h3>Indent Approval</h3><!-- Heading-->
						</div>
				</div>
			</div></br>
			<?php echo form_open('consumables/indent_approve/indent_approval',array('class'=>'form-custom','role'=>'form'))?><!-- Indent Approval form open-->
			<div class="col-xs-4 col-md-offset-2">
				<div class="container">
					<div class="row">
						<form class="form-horizontal">
							<div class="col-md-2">
								<div class="form-group"><!-- From label-->
									<label for="from_date">From</label>
										<input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($from_date)); ?>" name="from_date" id="from_date" size="10" />
								</div><!-- End of from label-->
							</div>
							<div class="col-md-2">
								<div class="form-group"><!-- to label-->
									<label for="to_date">To</label>
										<input class="form-control" type="text"  value="<?php echo date("d-M-Y",strtotime($to_date)); ?>" name="to_date" id="to_date" size="10"/>
								</div><!-- End of to label-->
							</div>
							<div class="col-md-3" style="width: 27%;">
								<div class="form-group"><!-- From party-->
									<label for="from_id">Indent From Party</label>
										<select name="from_id" id="from_id" class="form-control">
											<option value="">Select</option>
											<?php
												foreach($parties as $fro)
												{
													echo "<option value='".$fro->supply_chain_party_id."'";
													if($this->input->post('from_id') && $this->input->post('from_id') == $fro->supply_chain_party_id) echo " selected ";
													echo ">".$fro->supply_chain_party_name."</option>";
												}
											?>
										</select>
								</div><!-- End of from party-->
							</div>
							<div class="col-md-4">							
								<div class="form-group"><!-- To party-->
									<label for="inputto_id">Indent To Party</label>
										<select name="to_id" id="to_id" class="form-control" >
											<option value="">Select</option>
												<?php
													foreach($parties as $t)
													{
													echo "<option value='".$t->supply_chain_party_id."'";
													if($this->input->post('to_id') && $this->input->post('to_id') == $t->supply_chain_party_id) echo " selected ";
													echo ">".$t->supply_chain_party_name."</option>";
													}
												?>
										</select>
								</div><!-- End of to party-->
							</div>
						</form>
					</div>
				</div></br>
					<div class="container">
						<div class="row">
							<div class="col-md-4">							
								<div class="form-group"><!-- Item type-->
									<label for="item_type" >Item Type</label>
										<select name="item_type" id="item_type" class="form-control" style="width:280px">
											<option value="">Select</option>
												<?php 
													foreach($all_item_type as $it)
													{
													echo "<option value='".$it->item_type_id."'";
													if($this->input->post('item_type') && $this->input->post('item_type') == $it->item_type_id) echo " selected ";
													echo ">".$it->item_type."</option>";
													}
												?>
										</select>
								</div><!-- End of item type-->
							</div>
							<div class="col-md-4">							
								<div class="form-group"><!-- Item-->
									<label for="item" >Item</label>
										<select name="item" id="item" class="form-control" style="width:305px">
										<option value="">Select</option>
											<?php 
												foreach($all_item as $i)
												{
													echo "<option class='".$i->item_type_id."' value='".$i->item_id."'";
													if($this->input->post('item') && $this->input->post('item') == $i->item_id) echo " selected ";
													echo ">".$i->item_name."-".$i->item_form."-".$i->dosage."-".$i->dosage_unit ;"</option>";
												}
										   ?>
										</select>
								</div><!-- End of item-->
							</div>
						</div>
					</div>
					</br>
					<div class="container">
						<div class="row">
							<div class="col-md-8 col-md-offset-3">		
								<button type="submit"  name="submit" value="submit" class="btn btn-primary">Submit</button>
								<?php  echo form_close();?>	<!-- End of Indent approval form-->	
							</div> 
						</div> 
					</div>
					<?php 	if(!!$all_indents){ ?> 
						<div class="container">
		                    <div class="row">
								<div class="col-md-11">
									<center><h3>List Of Orders For Approval</h3></center>           
										<table class="table table-bordered table-striped" id="table-sort">
										<thead>
											<tr>
												<th><center>#</center> </th>
												<th><center>Indent Id</center></th>
												<th><center>Indent Date Time</center></th>
												<th><center>Indent From Party</center></th>
												<th><center>Indent To Party</center></th>
												<th><center></center></th>
											</tr>
										</thead>
										<tbody>
											<?php
												$i=1;
			                                 foreach($all_indents as $indent){  
											 ?>
											<tr>
												<td><?php  echo $i++; ?> 
													<?php echo form_open('consumables/indent_approve/indent_approval',array('class'=>'form-custom','id'=>'select_'.$indent->indent_id,'role'=>'form'))?><!-- Indent Approval form open-->
													<input type="hidden" name="selected_indent_id" value="<?php echo $indent->indent_id;?>"/>
												</td>
												<td><?php  echo $indent->indent_id; ?> </td>
												<td> <?php echo date("d-M-Y g:i A", strtotime($indent->indent_date)); ?></td>
												<td> <?php echo $indent->from_party; ?></td>
												<td> <?php echo $indent->to_party; ?></td>
												<td><center><input type="submit" class="btn btn-primary"  name="select" id="btn" onclick="$('#select_<?php echo $indent->indent_id;?>').submit();"  value="Select" >
												</center>	<?php echo form_close();?></td><!-- End of indent approval form-->
											</tr>
											<?php } ?>
										</tbody>
										</table>
								</div>
							</div>
					
			
							<?php }
							else { ?>
							No orders are available
							<?php }   ?>
						</div>
			</div>

