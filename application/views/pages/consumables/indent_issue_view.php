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

 <?php if($mode=='update') { ?>
<iframe id="ifmcontentstoprint" style="height: 0px; width: 0px; position: absolute;display:none"></iframe>
<div id="print-div" class="sr-only" style="width:100%;height:100%;">
	<center>
		<?php  foreach ($issue_details as $all_issue){ ?>
			<h3>
				<?php echo $all_issue->hospital;?> </h3>
				<?php break; } ?>
		        <p><h3>Indent Order </h3></p><!-- Heading -->
	</center>	 
			<hr>
			<center>
				<label style="float:left"><b>Indent Id : </b><?php echo " ".$all_issue->indent_id;?></br></label><!-- Indent_id label -->
				<label style="float:right"><b>From : </b><?php echo " ".$all_issue->from_party;?></label><br><!-- From label-->
				<label style="float:left"><b>Date Time : </b><?php echo " ".date("d-M-Y g:i A", strtotime($all_issue->issue_date_time));?></label><!--Date Time label -->
				<label style="float:right"><b>To : </b><?php echo " ".$all_issue->to_party;?></label><br><!--  To label -->
			</center>
			<br/><br/><br/>
			<table style=" border:1px solid black;width:100%;border-collapse: collapse;">
			    <thead style="height:50px">
					<th style="text-align:center;border:1px solid black;" >#</th>
					<th style="text-align:center;border:1px solid black;" >Items</th>
					<th style="text-align:center;border:1px solid black;" >Quantity Approved</th>
					<th style="text-align:center;border:1px solid black;" >Quantity Issued</th>
				</thead>
				<tbody>
					<?php
						 $i=1;
						 foreach ($issue_details as $all_issue){ ?>
							<tr>
								<td style=" border:1px solid black;  padding: 15px;  height: 50px;"><center><?php echo $i++;?></center></td>
								<td style="border:1px solid black;   padding: 15px;  height: 50px;" align="left"><?php echo $all_issue->item_name."-".$all_issue->item_form."-".$all_issue->item_type.$all_issue->dosage.$all_issue->dosage_unit;?></td>
								<td style="border:1px solid black;  padding: 15px;  height: 50px;" align="right"><?php echo $all_issue->quantity_approved ?></td>
								<td style="border:1px solid black;  padding: 15px;  height: 50px;" align="right"><?php echo $all_issue->quantity_issued ?></td>
							</tr>
			        <?php } ?>
				</tbody>
			</table>
			<br/><br/>
			<b><?php echo "Indented"." "."by :" ;?></b>
				<?php echo $all_issue->order_first." ".$all_issue->order_last;?></br></br>
				<b><?php echo "Approved"." "."by :" ;?></b>
				<?php echo $all_issue->approve_first." ".$all_issue->approve_last;?></br></br>
			<b><?php echo $all_issue->indent_status." "."by :" ;?></b>
				<?php echo $all_issue->issue_first." ".$all_issue->issue_last;?></br></br>
            	<b><?php echo "Issuer Signature :"; ?></b></br></br>			
</div>
<?php echo form_open('consumables/indent_issue/indent_issued',array('class'=>'form-group','role'=>'form'));?> <!-- Issue Print Form opened-->
<div class ="col-md-8 col-md-offset-3"> <div class="alert alert-info"><center> <strong><?php if(isset($msg)){ echo $msg;} ?></strong> </center></div></div>
	<div class="col-xs-4 col-md-offset-2" style="padding:30px" >
		<div class="container">
			<div class="row">
				<div class="col-md-9">
					<div class="panel panel-success">
						<div class="panel-heading">
							<center>
								<p class="panel-title"><h3>Indent Order </h3></p><!-- Heading -->
							</center>
						</div> 							  
						<div class="panel-body">
							<div class="panel-content">
								<div  class="span9">
									<div class="span3">
										<div class="col-md-6"><!--Indent id label-->
											<b>Indent Id : </b><?php echo " ".$all_issue->indent_id;?>
										</div><!-- End of indent_id label-->
										<div class="col-md-6"><!-- From_party label-->
											<b>From Party : </b><?php echo " ".$all_issue->from_party;?>
										</div><!-- End of from_party label -->
									</div>
								</div>
								<div class="span3">
									<div class="col-md-6"><!-- Date Time label -->
										<b>Date Time : </b><?php echo " ".date("d-M-Y g:i A",strtotime($all_issue->issue_date_time));?>
									</div><!-- End of date time label-->
								
								</div>
								<div class="span3">
									<div class="col-md-6"><!-- To party label -->
										<b>To Party : </b><?php echo " ".$all_issue->to_party;?>
									</div><!-- End of to party label-->
								</div>
							</div>
						</div>
						<div class="container">
							<div class="row"> 
								<div class="col-md-8" style="margin-left:33px">
									<div class="form-group">
										<table class="table table-bordered table-striped">
											<thead>
												<th class="col-md-2"style="text-align:center">#</th>
												<th class="col-md-2"style="text-align:center">Items</th>
												<th class="col-md-2"style="text-align:center">Quantity Approved</th>
												<th class="col-md-2"style="text-align:center">Quantity Issued</th>
											</thead>
											<tbody>
												<?php
                                                   $i=1;
													foreach ($issue_details as $all_issue){ ?>
													<tr>
														<td><center><?php echo $i++;?></center></td>
														<td align="left"><?php echo $all_issue->item_name."-".$all_issue->item_form."-".$all_issue->item_type.$all_issue->dosage.$all_issue->dosage_unit;?></td>
														<td align="right"><?php echo $all_issue->quantity_approved ?></td>
														<td align="right"><?php echo $all_issue->quantity_issued ?></td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
						<div class="span9">
								<div class="span3">
									<div class="col-md-12"><!-- Indenter name -->
										<b><?php echo "Indented"." "."by :" ;?></b>
										<?php echo $all_issue->order_first." ".$all_issue->order_last;?></br></br>
									</div><!-- End of indenter name-->
								</div>
								<div class="span3">
									<div class="col-md-12"><!-- Approver name-->
										<b><?php echo "Approved"." "."by :" ;?></b>
										<?php echo $all_issue->approve_first." ".$all_issue->approve_last;?></br></br>
									</div><!-- End of approver name-->
								</div>
								<div class="span3">
									<div class="col-md-12"><!-- Issuer name-->
										<b><?php echo $all_issue->indent_status." "."by :" ;?></b>
										<?php echo $all_issue->issue_first." ".$all_issue->issue_last;?></br></br>
									</div><!-- End of issuer name-->
								</div>
								<div class="span3">
									<div class="col-md-12"><!-- Issuer signature-->
										<b><?php echo "Issuer Signature :" ;?></b></br></br>
									</div><!-- End of issuer signature-->
								</div>
						</div>
						<div class="row">
								<div class="col-md-12">
									<div class="panel-footer">
										<center><button class="btn btn-primary" type="button" name="print" id="print" onclick="printDiv('print-div')">Print</button></center>
									</div>
								</div>
						</div>
					</div>
				</div>
			 </div>
		</div>
    </div>
	<?php echo form_close(); ?><!-- End of  Issue Print form -->
	<?php } ?>
	
	<?php 
				$from_date=0;$to_date=0;$indent_time=0;
				if($this->input->post('from_date')) $from_date=date("Y-m-d",strtotime($this->input->post('from_date'))); else $from_date =date("Y-m-d", strtotime( date( "Y-m-d", strtotime( date("Y-m-d") ) ) . "-1 month" ) );
				if($this->input->post('to_date')) $to_date=date("Y-m-d",strtotime($this->input->post('to_date'))); else $to_date = date("Y-m-d");
            ?>
			<div class="container">
			    <div class="row">
						<div class="col-md-8 col-md-offset-6">
							<h3>Indent Issue </h3><!-- Heading-->
						</div>
				</div>
			</div></br>
			<?php echo form_open('consumables/indent_issue/indent_issued',array('class'=>'form-custom','role'=>'form'))?><!-- Indent Issue form open-->
			<div class="col-xs-4 col-md-offset-2">
				<div class="container">
					<div class="row">
						<form class="form-horizontal">
							<div class="form-group">
								<div class="col-md-3"><!-- From label-->
									<label for="exampleInputdate">From</label>
										<input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($from_date)); ?>" name="from_date" id="from_date" size="12" />
								</div><!-- End of from label-->
							</div>
							<div class="form-group">
								<div class="col-md-3"><!-- to label-->
									<label for="exampleInputdate">To</label>
										<input class="form-control" type="text"  value="<?php echo date("d-M-Y",strtotime($to_date)); ?>" name="to_date" id="to_date" size="12"/>
								</div><!-- End of to label-->
							</div>	
							<div class="form-group">	
								<div class="col-md-4"><!-- From party-->
									<label for="from_id">From Party</label>
										<select name="from_id" id="from_id" class="form-control">
											<option value="">Select</option>
											<?php
												foreach($parties as $fro)
												{
													echo "<option value='".$fro->supply_chain_party_id."'";
													if($this->input->post('from_id') && $this->input->post('from_id') == $fro->supply_chain_party_id && $mode!="auto") echo " selected ";
													echo ">".$fro->supply_chain_party_name."</option>";
												}
											?>
										</select>
								</div><!-- End of from party-->
							</div>
							<div class="form-group">
								<div class="col-md-4"><!-- To party-->
									<label for="inputto_id">To Party</label>
										<select name="to_id" id="to_id" class="form-control" >
											<option value="">Select</option>
												<?php
													foreach($parties as $t)
													{
													echo "<option value='".$t->supply_chain_party_id."'";
													if($this->input->post('to_id') && $this->input->post('to_id') == $t->supply_chain_party_id && $mode!="auto") echo " selected ";
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
							<div class="form-group">
								<div class="col-md-4"><!-- Item type-->
									<label for="inputitem_type" >Item Type</label>
										<select name="item_type" id="item_type" class="form-control">
											<option value="">select</option>
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
							<div class="form-group">
								<div class="col-md-4"><!-- Item-->
									<label for="inputitem" >Item</label>
										<select name="item" id="item" class="form-control" class="col-md-4">
										<option value="">select</option>
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
							<div class="col-md-8 col-md-offset-5">		
								<button type="submit"  name="submit" value="submit" class="btn btn-primary">submit</button>
								<button type="submit"  name="auto_indent" value="auto_indent" class="btn btn-primary">Auto-Indent</button>
								<input type="hidden" name="auto_indent" value="1"/>
								<?php  echo form_close();?>	<!-- End of Indent approval form-->	
							</div> 
						</div> 
					</div>
					<?php 	if(!!$all_indents){ ?> 
						<div class="container">
		                    <div class="row">
								<div class="col-md-11">
									<center><h3>List Of Orders For Issue</h3></center>           
										<table class="table table-bordered table-striped" id="table-sort">
										<thead>
											<tr>
												<th><center>#</center> </th>
												<th><center>Indent Id</center></th>
												<th><center>Indent Date Time</center></th>
												<th><center>From</center></th>
												<th><center>To</center></th>
												<th><center>Status</center></th>
											</tr>
										</thead>
										<tbody>
											<?php
												$i=1;
			                                 foreach($all_indents as $indent){  
											 ?>
											<tr>
												<td><?php  echo $i++; ?> 
													<?php echo form_open('consumables/indent_issue/indent_issued',array('class'=>'form-custom','id'=>'select_'.$indent->indent_id,'role'=>'form'))?><!-- Indent Issue form open-->
													<input type="hidden" name="selected_indent_id" value="<?php echo $indent->indent_id;?>"/>
												</td>
												<td><?php  echo $indent->indent_id; ?> </td>
												<td> <?php echo date("d-M-Y g:i A", strtotime($indent->indent_date)); ?></td>
												<td> <?php echo $indent->from_party; ?></td>
												<td> <?php echo $indent->to_party; ?></td>
												<td><center><input type="submit" class="btn btn-primary"  name="select" id="btn" onclick="$('#select_<?php echo $indent->indent_id;?>').submit();"  value="select" >
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


