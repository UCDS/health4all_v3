<script>	
	<!-- Scripts for printing output table -->
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
<iframe id="ifmcontentstoprint" style="height: 0px; width: 0px; position: absolute;display:none"></iframe>
<div class="col-md-8 col-md-offset-2">
	
	
	
	<div class="col-md-8 col-md-offset-2">
	<?php
	if(isset($msg)) {
		echo "<div class='alert alert-info'>$msg</div>";
		echo "<br />";
	}
	?>
		<button type="button" class="btn btn-primary col-md-offset-1" onclick="printDiv('print-div')"> Print</button>
                <br /><br /><br />
                <div class="container">
				<h3> Service issue </h3>
			    <?php
				
				 $i=1;
				foreach ($service as $sr){ ?>
				<table>
				<tr>
				<td>Department</td> 
				<td><?php echo $sr->department_id; ?></td>
				</tr>
				<tr>
				<td>Equipment Type</td> 
				<td><?php echo $sr->equipment_type; ?></td>
				</tr>
				
				<tr>
				<td>Serial Number </td> <td><?php echo $sr->serial_number; ?></td>
				
				</tr>
				<tr><td>Asset Number </td><td><?php echo $sr->asset_number; ?></td>
				</tr>
				<tr>
				<td>Model</td><td><?php ?></td>
				</tr>
				</table>
				<?php } ?>
				 <?php
				 $i=1;
				foreach ($service as $sr){ ?>
				<table class="table-2 table table-striped table-bordered">
				<tr>
				<td>Call Date</td><td> <?php      echo $sr->call_date;
 ?></td>
				</tr>
				<tr>
				<td>Call Time</td><td> <?php      echo $sr->call_time ;
 ?></td>
				</tr>
				<tr>
				<td>Call Information Type</td><td> <?php       echo $sr->call_information_type; 
 ?></td>
				</tr>
				<tr>
				<td>Call Information</td><td> <?php       echo  $sr->call_information;
?></td>
				</tr>
				<tr>
				<td>Working Status</td><td> <?php       echo  $sr->working_status;
?></td>
				</tr>
				<tr>
				<td>Vendor</td><td> <?php ?></td>
				</tr>
				<tr>
				<td>Contact Person</td><td> <?php ?></td>
				</tr>
				<tr>
				<td>Service Person Remarks</td><td> <?php     echo  $sr->service_person_remarks;
 ?></td>
				</tr>
				<tr>
				<td>Service Date</td><td> <?php      echo  $sr->service_date;
?></td>
				</tr>
				<tr>
				<td>Service Time</td><td> <?php      echo   $sr->service_time;
?></td>
				</tr>
				<tr>
				<td>Issue Status</td><td> <?php       echo $sr->problem_status;
 ?></td>
				</tr>
			</table>
				<?php } ?>
		</div>

		<div id="print-div" style="width:100%;height:100%;" hidden>

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
				<h3> Service issue </h3>
			    <?php
				
				 $i=1;
				foreach ($service as $sr){ ?>
			<table class="table-2 table table-striped table-bordered">
		
				
				<tr>
				<td>Serial Number <?php ?>  </td><td>Asset Number <?php ?></td>
				
				</tr>
				<tr>
				<td>Call Date</td><td> <?php      echo $sr->call_date;
 ?></td>
				</tr>
				<tr>
				<td>Call Time</td><td> <?php      echo $sr->call_time ;
 ?></td>
				</tr>
				<tr>
				<td>Call Information Type</td><td> <?php       echo $sr->call_information_type; 
 ?></td>
				</tr>
				<tr>
				<td>Call Information</td><td> <?php       echo  $sr->call_information;
?></td>
				</tr>
				<tr>
				<td>Working Status</td><td> <?php       echo  $sr->working_status;
?></td>
				</tr>
				<tr>
				<td>Vendor</td><td> <?php ?></td>
				</tr>
				<tr>
				<td>Contact Person</td><td> <?php ?></td>
				</tr>
				<tr>
				<td>Service Person Remarks</td><td> <?php     echo  $sr->service_person_remarks;
 ?></td>
				</tr>
				<tr>
				<td>Service Date</td><td> <?php      echo  $sr->service_date;
?></td>
				</tr>
				<tr>
				<td>Service Time</td><td> <?php      echo   $sr->service_time;
?></td>
				</tr>
				<tr>
				<td>Issue Status</td><td> <?php       echo $sr->problem_status;
 ?></td>
				</tr>
			</table>
				<?php } ?>
		
			
		</div>
	
	
		
	</div>
</div>
