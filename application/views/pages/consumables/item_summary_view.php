<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/metallic.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/theme.default.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<!--<script type="text/javascript" src="<//?php echo base_url();?>assets/js/zebra_datepicker.js"></script>-->
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript"  src="<?php echo base_url();?>assets/js/jquery.timeentry.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.mousewheel.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
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
<script>
	$(function(){
	$("#from_date,#to_date, #expiry_date").Zebra_DatePicker({
		direction:false
	});
	});
</script>
<script>
	$(function(){
		$(".time").timeEntry();
	  $("#item_name").chained("#item_type");
	});
</script>
	<?php
	$from_date=0;$to_date=0;
	
	if($this->input->post('to_date')) $to_date=date("d-M-Y",strtotime($this->input->post('to_date'))); else $to_date = date("Y-m-d");
    //     $from_time=0;$to_time=0;
	// if($this->input->post('from_time')) $from_time=date("H:i",strtotime($this->input->post('from_time'))); else $from_time = date("00:00");
	// if($this->input->post('to_time')) $to_time=date("H:i",strtotime($this->input->post('to_time'))); else $to_time = date("23:59");
	if($this->input->post('scp_id')){
		$selected_party = $this->input->post('scp_id');
	}
	else{
		$selected_party = "0";
	}
	
	?>
			   <div class="text-center">
				<h2>Item Summary</h2>
				<?php echo form_open('consumables/indent_reports/get_item_summary',array('class'=>'form-group','role'=>'form','id'=>'evaluate_applicant')); ?>
				<div class="container">
					<div class="row">
						<!-- <div class = "col-xs-12 col-sm-12 col-md-2 col-lg-3 col-md-offset-2">
							<div class="form-group">
							
									From Date<input class="form-control" type="text" value="<?php //echo date("d-M-Y",strtotime($from_date)); ?>" name="from_date" id="from_date" size="15" />
							</div>
						</div> -->
						<!-- <div class = "col-xs-12 col-sm-12 col-md-2 col-lg-3 col-md-offset-3">
							<div class="form-group">
								To Date<input class="form-control" type="text" value="<?php // echo date("d-M-Y",strtotime($to_date)); ?>" name="to_date" id="to_date" size="15" />
							</div>
						</div> -->
						<div class = "col-xs-12 col-sm-12 col-md-2 col-lg-3 col-md-offset-2">
							<div class="form-group">
							<!--input field from party-->
								<label for="scp_id">Supply Chain Party<font style="color:red">*</font></label>
									<select name="scp_id" id="scp_id" class="form-control" required>
									<option value="">Select</option>
										<?php
											foreach($parties as $scp)
											{
												echo "<option value='".$scp->supply_chain_party_id."'";
												if($this->input->post('scp_id') && $this->input->post('scp_id') == $scp->supply_chain_party_id) echo " selected ";
												echo ">".$scp->supply_chain_party_name."</option>";

											}
										?>
									</select>
							</div>
						</div>
											
						<!-- <div class = "col-xs-12 col-sm-12 col-md-2 col-lg-3 col-md-offset-3">
							<div class="form-group">
								<label for="inputitem_type" >Item Type</label>
									<select name="item_type" id="item_type" class="form-control">
									<option value="" selected>Select</option>
										<?php
										/*
											foreach($all_item_type as $it)
												{
													echo "<option value='".$it->item_type_id."'";
												if($this->input->post('item_type') && $this->input->post('item_type') == $it->item_type_id) echo " selected ";
												echo ">".$it->item_type."</option>";
												}
												*/
										?>
									</select>
							</div>
						</div> -->
						<div class = "col-xs-12 col-sm-12 col-md-2 col-lg-3">
							<div class="form-group">
							<!--input field item-->
								<label for="inputitem" >Item<font style="color:red">*</font></label>
									<select name="item" id="item" class="form-control" required>
									<option value="">Select</option>
										<?php
											foreach($all_item as $i)
												{
													//echo"<option class='".$i->item_type_id."' value='".$i->item_id."'>".$i->item_name."-".$i->item_form."-".$i->dosage.$i->dosage_unit."</option>";
													echo "<option class='".$i->item_type_id."' value='".$i->item_id."'";
													if($this->input->post('item') && $this->input->post('item') == $i->item_id) echo " selected ";
													echo ">".$i->item_name."-".$i->item_form."-".$i->item_type."-".$i->dosage.$i->dosage_unit."</option>";
												}
										?>
									</select>
							</div>
						</div>
						<!-- <div class = "col-xs-12 col-sm-12 col-md-2 col-lg-3 col-md-offset-3">
							<div class="form-group">
								Expiry Date<input class="form-control" type="text" value="<?php echo date("d-M-Y"); ?>" name="expiry_date" id="expiry_date" size="15" />
							</div>
						</div> -->
						<!-- 
                        <div class = "col-xs-12 col-sm-12 col-md-2 col-lg-3">
							<div class="form-group">
							
								<label for="inputitem" >Inward/Outward</label>
									<select name="item_inward_outward" id="item_inward_outward" class="form-control">
									<option value="inward">Select</option>	
									<option value="inward">Inward</option>
                                    <option value="outward">Outward</option>
										
									</select>
							</div>
						</div>
											-->

				</div>
		</div>
			<div class="container">
			   <div class="row">
			   <div class="col">
				   <button class="btn btn-primary" type="submit" name="search" value="search" id="btn">Search</button>
				   	<?php echo form_close(); ?>
			   </div>
			   </div>
		   </div>
		   <!--calling isset method-->
		   <?php if(isset($mode)&& ($mode)=="search"){ ?>
		  <?php echo form_open('consumables/indent_reports/get_item_summary',array('role'=>'form'))   ?>
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-md-offset-3">
					<button type="button" class="btn btn-primary btn-md print  ">
						<span class="glyphicon glyphicon-print"></span> Print
					</button>

					 <a href="#" id="test" onClick="javascript:fnExcelReport();">
            <button type="button" class="btn btn-primary btn-md excel">
                <i class="fa fa-file-excel-o"ara-hidden="true"></i> Export to excel</button></a></br>
				</div>
			</div>
		</div>
		</br>
		<!--filters for Add Service Issues view form --->
		<!--when filter is clicked this form will load --->
		 <div class="container">
			<?php if(count($search_inventory_summary) > 0) { 

				?>
			<h2>Item Details - <span class="text text-primary"><?= $search_inventory_summary[0]->item_name; ?></span></h2>
			<h3>Type: <i><?php echo $search_inventory_summary[0]->item_type;?></i></h3>
			<?php } ?>
		 <div class="col-md-offset-2">
					<table class="table table-bordered table-striped" id="table-sort">
						<thead>

							<!-- <th>Supply Chain Party</th> -->
							<th>Indent ID</th>
							<th>Batch</th>
							<th>Manufacturing date</th>
							<th>Expiry date</th>
							<th>Inward/Outward</th>
							<th>Quantity</th>
							<th>Cost</th>
							<th>GTIN code</th>
							<th>Patient ID</th>
							<th>Note</th>
							<!-- <th></th> -->
							<!-- <th>Quantity Inward</th>
							<th>Quantity Outward</th>
							<th>Difference</th> -->
							<!-- <th>Item id</th> -->
						</thead>
						<tbody>
			<?php
				
							
				$i=1;
				$ct = 0;
				
				// $outward = $search
				log_message("info", "SAIRAM VERSION ".$CI_VERSION);
				log_message("info", "SAIRAM WARNING ".json_encode($search_inventory_summary));
				foreach($search_inventory_summary as $inventory_item){?>

					<tr>
						
					<?php
					// echo json_encode($inventory_item); 
					//echo $i++; 
					// $sub_url="consumables/indent_reports/get_item_inventory";
					if(!isset($inventory_item))
						continue;

					$sub_url="consumables/indent_reports/";
					$item_type_id = '0';
					if ($inventory_item->item_id) {
						$item_id = $inventory_item->item_id;

					}
					$manufacture_date = $inventory_item->manufacture_date;
					$expiry_date = $inventory_item->expiry_date;
					// echo strtotime("01-Jan-1970 00:00:00");
					// echo strtotime(date("Y-m-d", strtotime($manufacture_date)));
					log_message("info", "SAIRAM ===> ".$inventory_item->batch);
					if(strtotime(date("d-M-Y", strtotime($manufacture_date))) <= 0){
						$manufacture_date = "";
					}
					if(strtotime(date("d-M-Y", strtotime($expiry_date))) <= 0){
						$expiry_date = "";
					}
					$scp_id = $inventory_item->supply_chain_party_id;
					$qty_outward = 0;
					
					// $item_i = $inventory
					$batch = $inventory_item->batch;
					?>


						
						<td><a href="<?= base_url().$sub_url."indents_list_detailed/$inventory_item->indent_id"; ?>"><?= $inventory_item->indent_id;?></a></td>
						<td><?= $batch == '0' ? "NO BATCH": $batch; ?></td>
						<td><?= $manufacture_date == ""? "": date("d-M-Y", strtotime($manufacture_date)); ?></td>
						<td><?= $expiry_date == ""? "": date("d-M-Y", strtotime($expiry_date)); ?></td>
						<td><?= ($inventory_item->inward_outward === "inward")? "Inward ($inventory_item->to_party)": "Outward ($inventory_item->from_party)"; ?></td>
						<td><?= ($inventory_item->total_quantity);?></td>
						<td><?= $inventory_item->cost; ?></td>
						<td><?= $inventory_item->gtin_code; ?></td>
						<td><?= $inventory_item->patient_id ? $inventory_item->patient_id: ""; ?></td>
						<td><?= $inventory_item->note;?></td>
						<!-- <td><a href="<?php //echo base_url().$sub_url?>"><?php //if ($item_id == '0')
							  //echo "NA"; 
							  //else echo $item_id;?></td> -->
					</tr>
					<?php
					$ct++;
	               
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
