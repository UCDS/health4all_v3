<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
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
		$("#from_date,#to_date").Zebra_DatePicker();
	});
</script>
<iframe id="ifmcontentstoprint" style="height: 0px; width: 0px; position: absolute;display:none"></iframe>
<div class="col-md-10 col-sm-9">

	<div>
		<?php echo form_open('bloodbank/user_panel/report_issue', array('role'=>'form','class'=>'form-custom')); ?> <!-- To apply the css to input boxes and search boxes -->
		<div>
			<input type="text" placeholder="From date" class="form-control" size="10" name="from_date" id="from_date" />
			<input type="text" placeholder="To date" class="form-control" size="10" name="to_date" id="to_date" />
			<select name="issued_by" class="form-control">
                            <option value="" disabled selected>Issued By</option>
                            <?php foreach($staff as $s){
				echo "<option value='$s->staff_id'>$s->name</option>";
                            }
                            ?>
			</select>
			<input type="submit" value="Search" class='btn btn-primary btn-md' name="search" />
                        
		</div>
		</form>
                <br/>
                <button type="button" class="btn btn-default btn-md print">
		  <span class="glyphicon glyphicon-print"></span> Print
		</button>
                <br/>
		<?php
		if(isset($msg)) {
			echo $msg;
			echo "<br />";
			echo "<br />";
		}
		?>
		<?php if(count($issued)>0){ ?>
		<b>
		<?php
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date('d-M-Y',strtotime($this->input->post('from_date')));
			$to_date=date('d-M-Y',strtotime($this->input->post('to_date')));
			echo "Blood issued from ".$from_date." to ".$to_date;
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
		 $this->input->post('from_date')==""?$date=$this->input->post('to_date'):$date=$this->input->post('from_date');
		 echo "Blood issued on $date";
		}
		else{
			$from_date=date('d-M-Y',strtotime('-10 Days'));
			$to_date=date('d-M-Y');
			echo "Blood issues report";	
		}
		?>
		</b>
         
		<table  class="table-2 table table-striped table-bordered"></table>
		<table class="table table-bordered table-striped" id="table-sort">
		<thead><th>S.No</th><th>Date</th><th>Time</th><th>Blood Unit No.</th><th>Component</th><th>Patient Name</th><th>Patient Blood Group</th><th>Patient Address</th><th>Donor Blood Group</th><th>Donor Name</th><th>Quantity Of Blood</th><th>Diagnosis</th><th>Hospital</th><th>Issued By</th><th>Cross Matched By</th></thead>
		<?php 
		$i=1;
		foreach($issued as $row){
		?>
		<tr>
			<td><?php echo $i++;?></td>
			<td><?php echo date("d-M-Y",strtotime($row->issue_date));?></td>
			<td><?php echo date("g:ia",strtotime($row->issue_time));?></td>
			<td><?php echo $row->blood_unit_num;?></td>
			<td><?php echo $row->component_type;?></td>
			<td><?php echo $row->patient_name." ".$row->first_name." ".$row->last_name;?></td>
			<td><?php echo $row->recipient_blood_group;?></td>
                        <td><?php echo $row->address;?></td>
                        <td><?php echo $row->blood_group;?></td>
                        <td><?php echo $row->name;?></td>
                        <td><?php echo $row->volume;?></td>
			<td><?php echo $row->diagnosis." ".$row->final_diagnosis;?></td>
			<td><?php echo $row->hospital; ?></td>
			<td><?php echo $row->issued_staff_name;?></td>
			<td><?php echo $row->cross_matched_staff_name;?></td>
			<td>
							<button type="button" class="btn btn-primary" onclick="printDiv('print-div<?php echo $i?>')"> Print</button>

				<div id="print-div<?php echo $i?>" style="width:100%;height:50%;" hidden>

				<style>
					@media print{
						table{
							font-size:12px;
							border-collapse:collapse !important;
						}
						td,tr,th{
							text-align:left;
							border:1px solid black !important;
							padding:4px !important;
						}
						th{
							font-weight:bold;
						}
						@page { 
							margin:4em 1em 2em 1em;
						}
					}
				</style>
					<table class="table-2" align="center">
						<tr>
							<th colspan="4" align="center">
								<?php $place=$this->session->userdata('place');
									echo $place->bloodbank;
								?>
							</th>	
						</tr>
						<tr>
							<td colspan="4" align="center">
								Issue Register
							</td>
						</tr>
						<tr>
							<th>Issue ID</th>
							<td><?php echo $row->issue_id; ?></td>
							<th>Date & Time of Issue</th>
							<td><?php echo date("d-M-Y",strtotime($row->issue_date));?> <?php echo date("g:ia",strtotime($row->issue_time));?></td>
						</tr>
						<tr>
							<th>Name of Recipient</th>
							<td><?php echo $row->patient_name;?></td>
							<th>Hospital</th>
							<td><?php echo $row->hospital;?></td>
						</tr>
						<tr>
							<th>Blood Unit Num.</th>
							<td><?php echo $row->blood_unit_num;?></td>
							<th>Segment Num</th>
							<td><?php echo $row->segment_num;?></td>
						</tr>
						<tr>
							<th>Component</th>
							<td><?php echo $row->component_type;?></td>
							<th>Quantity</th>
							<td><?php echo $row->volume;?>ml</td>
						</tr>
						<tr>
							<th>Blood Group</th>
							<td><?php echo $row->blood_group;?></td>
							<th>Recipient Blood Group</th>
							<td><?php echo $row->recipient_blood_group;?></td>
						</tr>
						<tr>
							<th>Indication for Transfusion</th>
							<td><?php echo $row->diagnosis;?></td>
							<th>Cross matching No. and Date</th>
							<td><?php echo date("d-M-Y",strtotime($row->issue_date));?></td>
						</tr>
						<tr>
							<th>Details of Cross Matching</th>
							<td colspan="3">
								<table>
									<tr>
										<td>Saline Technique</td>
										<td width="90px">Compatible</td>
									</tr>
									<tr>
										<td>Bovine Abumin Test</td>
										<td>Compatible</td>
									</tr>
									<tr>
										<td>Gel Technique</td>
										<td>Compatible</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="checkbox">Free <input type="checkbox"> Paid
							</td>
							<td>Amount</td>
							<td></td>
						</tr>
						<tr>
							<th>Signature of Recipient</th>
							<td width="100px"></td>
							<th>Signature of Technician</th>
							<td></td>
						</tr>
						<tr>
							<th>Signature of Medical Officer</th>
							<td colspan="3"></td>
						</tr>
					</table>
				</div>
			</td>
			</tr>
		<?php 
		}
		?>
		</table>
		<?php }
		else{
			 ?>
			 <p>No issues in the specified period.</p>
		<?php } ?>
	</div>
</div>