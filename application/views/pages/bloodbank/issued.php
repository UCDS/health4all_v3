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
<div class="col-md-10 col-sm-9">
	<?php
	if(isset($msg)) {
		echo "<div class='alert alert-info'>$msg</div>";
		echo "<br />";
	}
	?>
	
	
	<div>
		<button type="button" class="btn btn-primary col-md-offset-1" onclick="printDiv('print-div')"> Print</button>
                <br /><br /><br />
                <div class="container">

			<?php $i=1;
				foreach ($donors as $donor){ ?>
			<table class="table-2 table table-striped table-bordered">
				<tr>
					<th colspan="4" align="center">
						<?php $place=$this->session->userdata('place');
							echo $place['name'];
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
					<td><?php echo $donor->issue_id; ?></td>
					<th>Date & Time of Issue</th>
					<td><?php echo date("d-M-Y",strtotime($donor->issue_date));?> <?php echo date("g:ia",strtotime($donor->issue_time));?></td>
				</tr>
				<tr>
					<th>Name of Recipient</th>
					<td><?php echo $donor->first_name." ".$donor->last_name." ".$donor->patient_name;?></td>
					<th>Hospital</th>
					<td><?php echo $donor->hospital;?></td>
				</tr>
				<tr>
					<th>Blood Unit Num.</th>
					<td><?php echo $donor->blood_unit_num;?></td>
					<th>Segment Num</th>
					<td><?php echo $donor->segment_num;?></td>
				</tr>
				<tr>
					<th>Component</th>
					<td><?php echo $donor->component_type;?></td>
					<th>Quantity</th>
					<td><?php echo $donor->volume;?>ml</td>
				</tr>
				<tr>
					<th>Blood Group</th>
					<td><?php echo $donor->blood_group;?></td>
					<th>Recipient Blood Group</th>
					<td><?php echo $donor->recipient_group;?></td>
				</tr>
				<tr>
					<th>Indication for Cross Matching</th>
					<td><?php echo $donor->diagnosis." ".$donor->final_diagnosis;?></td>
					<th>Cross matching No. and Date</th>
					<td><?php echo date("d-M-Y",strtotime($donor->issue_date));?></td>
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
			<?php $i=1;
				foreach ($donors as $donor){ ?>
			<table class="table-2" align="center">
				<tr>
					<th colspan="4" align="center">
						<?php $place=$this->session->userdata('place');
							echo $place['name'];
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
					<td><?php echo $donor->issue_id; ?></td>
					<th>Date & Time of Issue</th>
					<td><?php echo date("d-M-Y",strtotime($donor->issue_date));?> <?php echo date("g:ia",strtotime($donor->issue_time));?></td>
				</tr>
				<tr>
					<th>Name of Recipient</th>
					<td><?php echo $donor->first_name." ".$donor->last_name." ".$donor->patient_name;?></td>
					<th>Hospital</th>
					<td><?php echo $donor->hospital;?></td>
				</tr>
				<tr>
					<th>Blood Unit Num.</th>
					<td><?php echo $donor->blood_unit_num;?></td>
					<th>Segment Num</th>
					<td><?php echo $donor->segment_num;?></td>
				</tr>
				<tr>
					<th>Component</th>
					<td><?php echo $donor->component_type;?></td>
					<th>Quantity</th>
					<td><?php echo $donor->volume;?>ml</td>
				</tr>
				<tr>
					<th>Blood Group</th>
					<td><?php echo $donor->blood_group;?></td>
					<th>Recipient Blood Group</th>
					<td><?php echo $donor->recipient_group;?></td>
				</tr>
				<tr>
					<th>Indication for Cross Matching</th>
					<td><?php echo $donor->diagnosis." ".$donor->final_diagnosis;?></td>
					<th>Cross matching No. and Date</th>
					<td><?php echo date("d-M-Y",strtotime($donor->issue_date));?></td>
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
			<?php } ?>
		</div>
	
	
		<table class="table-2 table table-striped table-bordered">
		<tr><th colspan="10">Issued Blood Donors List</th></tr>
		<tr><th>Name</th><th>Email</th></tr>
 		<?php foreach($donors as $donor){ ?>
 			<td><?php echo $donor->name;?></td>
			<td><?php echo $donor->email;?></td>
		</tr>
		<?php } ?>
		</table>
	</div>
</div>
