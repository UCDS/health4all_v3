<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/metallic.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/theme.default.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<!--<script type="text/javascript" src="<//?php echo base_url();?>assets/js/zebra_datepicker.js"></script>-->
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript"
 src="<?php echo base_url();?>assets/js/jquery.timeentry.min.js"></script>
<script type="text/javascript"
 src="<?php echo base_url();?>assets/js/jquery.mousewheel.js"></script>
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
	$("#from_date,#to_date").Zebra_DatePicker({
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
<div class="col-md-8 col-md-offset-2">
	<?php
	if($from_date==0 && $to_date==0){
	$from_date=0;$to_date=0;
	if($this->input->post('$from_date')) $from_date=date("Y-m-d",strtotime($this->input->post('$from_date'))); else $from_date = date("Y-m-d");
	if($this->input->post('$to_date')) $to_date=date("Y-m-d",strtotime($this->input->post('$to_date'))); else $to_date = date("Y-m-d");
	}
        $from_time=0;$to_time=0;
	if($this->input->post('from_time')) $from_time=date("H:i",strtotime($this->input->post('from_time'))); else $from_time = date("00:00");
	if($this->input->post('to_time')) $to_time=date("H:i",strtotime($this->input->post('to_time'))); else $to_time = date("23:59");
	if($from_party == 0) $from_party = $this->input->post('from_party');
	if($to_party == 0) $to_party = $this->input->post('to_party');
	if($item_type == 0) $item_type = $this->input->post('item_type');
	if($item_name == 0) $item_name = $this->input->post('item_name');
	if($indent_status == '0') $indent_status = $this->input->post('indent_status');
	?>
			   <div class="text-center">
				<div class="row"><center><h2>Indent List</h2></center></div>
				<?php echo form_open('consumables/indent_reports/indents_list',array('class'=>'form-group','role'=>'form','id'=>'evaluate_applicant')); ?>
				<div class="container">
					<div class="row">
						<div class = "col-xs-12 col-sm-12 col-md-2 col-lg-3">
							<div class="form-group">
							<!--Input field From date-->
							<label for="from_date">From Date </label>
								<input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($from_date)); ?>" name="from_date" id="from_date" size="15" />
							</div>
						</div>
						<div class = "col-xs-12 col-sm-12 col-md-2 col-lg-3">
							<div class="form-group">
							<!--Input field To date-->
							<label for="to_date">To Date</label>
								<input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($to_date)); ?>" name="to_date" id="to_date" size="15" />
							</div>
						</div>
						<div class = "col-xs-12 col-sm-12 col-md-2 col-lg-3">
							<div class="form-group">
								<label for="from_id">Indent From Party</label>
								<!--Input field From Party-->
									<select name="from_id" id="from_id" class="form-control">
									<option value="">Select</option>
										<?php
										//foreach loop for displaying all from parties.
											foreach($parties as $fro)
											{
												echo "<option value='".$fro->supply_chain_party_id."'";
												if($from_party == $fro->supply_chain_party_id) echo " selected ";
												echo ">".$fro->supply_chain_party_name."</option>";

											}
										?>
									</select>
							</div>
						    	</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-2 col-lg-3">
								<div class="form-group">
								<!--Input field To party-->
										<label for="to_id">Indent To Party</label>
										<select name="to_id" id="to_id" class="form-control">
											<option value="">Select</option>
											<?php
												foreach($parties as $t)
												{
													//foreach loop for displaying all To parties.
													echo "<option value='".$t->supply_chain_party_id."'";
													if($to_party == $t->supply_chain_party_id) echo " selected ";
													echo ">".$t->supply_chain_party_name."</option>";
												}
											?>
										</select>
								</div>
						       </div>
					     
						
						
								<div class = "col-xs-12 col-sm-12 col-md-2 col-lg-3">
								<div class="form-group">
								<!--Input field Indent Status-->
									<label for="inputindent_status" >Indent Status </label>
									<select class="form-control" name="indent_status">
									<option value="">Select</option>
								                    	<option value="Indented"
														<?php
															if($indent_status == "Indented")
															 echo " selected ";
													    ?>>Indented
														</option>
                                                         <option value="Approved"
														 <?php
															if($indent_status== "Approved")
															 echo " selected ";
													    ?>>Approved
														</option>
														<option value="Issued"
														<?php
															if($indent_status == "Issued")
															 echo " selected ";
													    ?>>Issued
														</option>

      						                    </select>
									<!--<select name="indent_status" id="indent_status" class="form-control">
												<option value="">Select</option>
												<option value="Indented">Indented</option>
												<option value="Approved">Approved</option>
												<option value="Issued">Issued</option>

									</select>-->
								</div>
							</div>
							<div class = "col-xs-12 col-sm-12 col-md-2 col-lg-3">
								<div class="form-group">
									<!--Input field Indent Status-->
									<label for="indent_id" >Indent Id</label>
									<input class="form-control" name="indent_id" placeholder="Indent ID">
								</div>
							</div>
					</div>
					<div class="row">
						<div class="col-md-9">
							<!--button for searching-->
							<center><button class="btn btn-success" type="submit" name="search" value="search" id="btn">Search</button></center>
							<?php echo form_close(); ?>	<!--closing of form-->
						</div>
					</div>
					
							

					</div>
				</div>
			
				<!--set method for hidden the table-->
		   <?php if(isset($search_indent_detailed)){ ?>
		  <?php echo form_open('consumables/indent_detailed/get_indent_detailed',array('role'=>'form'))   ?>
			<div class="container" style="margin-left:14px">
				<div class="row">
					<button type="button" class="btn btn-primary btn-md print  ">
						<span class="glyphicon glyphicon-print"></span> Print
					</button>

					 <a href="#" id="test" onClick="javascript:fnExcelReport();">
            <button type="button" class="btn btn-primary btn-md excel">
                <i class="fa fa-file-excel-o"ara-hidden="true"></i> Export to excel</button></a></br>
				</div>
			</div>
		</br>
		<!--filters for Add Service Issues view form --->
		<!--when filter is clicked this form will load --->
		 <div class="container">
					<table class="table table-bordered table-striped" id="table-sort">
						<thead>
							<th> S.no </th>
							<th>Indent Id</th>
							<!-- <th>Hospital Id</th> -->
							<th>Indent datetime</th>
							<th>Approval datetime</th>
							<th>Issue datetime</th>
							<th>Indent From Party</th>
							<th>Indent To Party</th>
							<th>Ordered by</th>
							<th>Approved by</th>
							<th>Issued by</th>
							<th>Indent Status</th>
							<th>Note</th>
							<th></th>
							<!-- <th>Insertion datetime</th>
							<th>Updation datetime</th> -->


						</thead>
						<tbody>
							<?php
							$total_quantity=0;
							$approved=0;
							$issued=0;

				$i=1;

				foreach($search_indent_detailed as $indent){?>
					<?php
						$f_indent_datetime = date("Y-m-d H:i:s",strtotime($indent->indent_datetime));
						$f_approval_datetime = date("Y-m-d H:i:s",strtotime($indent->approval_datetime));
						$f_issue_datetime = date("Y-m-d H:i:s",strtotime($indent->issue_datetime));
						$f_insert_datetime = date("Y-m-d H:i:s",strtotime($indent->insert_datetime));
						$f_update_datetime = date("Y-m-d H:i:s",strtotime($indent->update_datetime));

					?>

					<tr>
					<td><?php echo $i++; ?></td>

						<td><?php echo $indent->indent_id;?></td>
						
<!-- 
						
						<td><?php //echo $indent->ordered_by_id." - ". $indent->ordered_by_fname." ".$indent->ordered_by_lname." (".$f_indent_datetime.")";	?></td>
						<td><?php //echo $indent->approved_by_id." - ".$indent->approved_by_fname." ".$indent->approved_by_lname." (".$f_approval_datetime.")";	?></td>
						<td><?php //echo $indent->issued_by_id." - ".$indent->issued_by_fname." ".$indent->issued_by_lname." (".$f_issue_datetime.")";?></td>
						<td><?php //echo $indent->indent_status;?></td>
						<td><?php //echo $indent->inserted_by_id." - ".$indent->inserted_by_fname." ".$indent->inserted_by_lname." (".$f_insert_datetime.")";?></td>
						<td><?php //echo $indent->updated_by_id." - ".$indent->updated_by_fname." ".$indent->updated_by_lname." (".$f_update_datetime.")";?></td> -->

						<td><?php echo  $f_indent_datetime; ?></td>
						<td><?php if ($indent->indent_status == "Approved" || $indent->indent_status == "Issued")
							echo $f_approval_datetime;
						else
							echo "NA"; ?></td>
						<td><?php if ($indent->indent_status == "Issued")
							echo $f_issue_datetime;
						else
							echo "NA"; ?></td>
						<td><?php echo $indent->from_party_name;?></td>
						<td><?php echo $indent->to_party_name;?></td>
						<td><?php echo $indent->ordered_by_fname." ".$indent->ordered_by_lname;	?></td>
						<td><?php echo ($indent->indent_status == "Approved" || $indent->indent_status == "Issued") ? $indent->approved_by_fname." ".$indent->approved_by_lname: "NA";	?></td>
						<td><?php echo ($indent->indent_status == "Issued") ? $indent->issued_by_fname . " " . $indent->issued_by_lname : "NA";  ?></td>
						<td><?php echo $indent->indent_status;?></td>
						<td><?php echo $indent->note;?></td>
						<td><a href='<?php echo base_url()."consumables/indent_reports/indents_list_detailed/".$indent->indent_id?>' class="btn btn-success">View detailed</a></td>
					</tr>
					<?php
	                // $total_quantity+=$indent->quantity_indented;
					// $approved+=$indent->quantity_approved;
					// $issued+=$indent->indent_status;
					}
					?>
					<!-- <tfoot>
					<th>Total </th>
					<th colspan="6"> </th>


					<th class="text-left" ><?php // echo $total_quantity;?></th>
					<th class="text-left" ><?php // echo $approved;?></th>
					<th class="text-left" ><?php // echo $issued;?></th>

					</tfoot> -->

					<?php echo form_close(); ?>

				<?php
				}
				?>
				</tbody>
			</table>

			</div>


	</div>
</div>
