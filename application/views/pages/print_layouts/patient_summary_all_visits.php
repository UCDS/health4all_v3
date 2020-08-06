<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" media="print">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/qrcode.min.js"></script>  
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-barcode.min.js"></script>
<?php $patient_visit=$patients[0];?>
<?php
	
?>
<!-- Extract patient visits from patient -->
<style>
	@media print{
	table{
		font-family: "Trebuchet MS","Sans Serif", Serif;
	}
	tbody{
		border:1px solid #ccc;
	}
	td{
		padding:3px;
	}
	table {
		border-collapse:collapse;
		border-spacing:0;
	}
	#table-prescriptions{
		width:100%;
		position:relative;
	}
	#table-prescriptions td, th{
		border:1px solid black;
		padding:3px;
	}
	#doctor_name {
		padding: 0px,15px;
	}
	}
</style>
<?php foreach($patient_visits as $pvInd => $patient_visit) { ?>
<script type="text/javascript">
	$(function(){
		var settings = {
		barHeight: 20,
		fontSize: 20
		};
		$("#patient_barcode_<?php echo $patient_visit->visit_id;?>").barcode(
			"<?php echo $patient_visit->patient_id;?>",
			"code128",
			settings
		);	// patient->patient_id, done
	});
</script>

<table style="width:98%;padding:5px;">
	<tbody>
		<tr>
			<td colspan="3">
				<span style="position:absolute;" id="patient_barcode_<?php echo $patient_visit->visit_id;?>"></span>
				<div style="float:right; margin-right:10%;">
					<div id="qr_code_<?php echo $patient_visit->visit_id;?>" style="position:absolute;padding-top:2px;"></div>
					<div id="qr_text_<?php echo $patient_visit->visit_id;?>" style="position:absolute;top:75px;font-size:10px;">
					</div>
					<?php
						if($patient_visit->gender == "M"){
							$relation = "S/O";
						} 
						else $relation = "D/O";
						$qr_text = "i:".$patient_visit->patient_id." n:".$patient_visit->name." g:".$patient_visit->gender." a:".$patient_visit->age_years." r:".$relation." s:".$patient_visit->relative." l:".$patient_visit->place." p:".$patient_visit->phone;
					?>
					<script type="text/javascript">
						document.getElementById("qr_code_<?php echo $patient_visit->visit_id;?>").innerHTML="";
						document.getElementById("qr_text_<?php echo $patient_visit->visit_id;?>").innerHTML="<b>ID:</b> <?php echo $patient_visit->patient_id;?>";
						var qrcode = new QRCode(document.getElementById("qr_code_<?php echo $patient_visit->visit_id;?>"), {
							width : 55,
							height : 55
						});
						qrcode.makeCode("<?php echo $qr_text;?>");
					</script>
				</div>
				<div>
					<div style="position:absolute;" id="barcode"></div>
				</div>
				<?php $hospital=$this->session->userdata('hospital');?>
				<div style="float:middle;text-align:center">
				<font size="4"><?php echo $hospital['hospital'];?></font><br />
				<?php if(!!$hospital['description']) echo $hospital['description']."<br />";?>
				@ 
				<?php echo $hospital['place']; ?>, 
				<?php echo $hospital['district']; ?>
				<br />
				<br />
				<span ><b>
					<?php if($patient_visit->visit_type == "OP") echo "CONSULTATION"; else echo "DISCHARGE";?> SUMMARY
				</b></span>
				<br />
		<?php 
				if($patient_visit->visit_type == "OP") 
					echo "Consultation"; 
				else 
					echo "Admit";?> Date: <?php echo date("d-M-Y",strtotime($patient_visit->admit_date)); echo " ".date("g:iA",strtotime($patient_visit->admit_time)); 
				if($patient_visit->visit_type != "OP"){ 
					echo ", ";
					if(!!$patient_visit->outcome) echo $patient_visit->outcome; else echo "Discharge"?> 
						Date: 
						<?php 
						if($patient_visit->outcome_date != 0) echo date("d-M-Y",strtotime($patient_visit->outcome_date)); 
						if($patient_visit->outcome_time != 0) echo " ".date("g:iA",strtotime($patient_visit->outcome_time)); 
				}
		?>
			</div>
		</td>
		</tr>
		</tbody>
		<tbody height="10%">
		<tr width="95%">
				<td style="padding-top:20px"><b>Name: </b><?php echo $patient_visit->name; ?></td>
				<td style="padding-top:20px"><b>Age/Sex: </b><?php 
					if($patient_visit->age_years!=0){ echo $patient_visit->age_years." Yrs "; } 
					if($patient_visit->age_months!=0){ echo $patient_visit->age_months." Mths "; }
					if($patient_visit->age_days!=0){ echo $patient_visit->age_days." Days "; }
					if($patient_visit->age_years==0 && $patient_visit->age_months == 0 && $patient_visit->age_days==0) echo "0 Days";
					echo "/".$patient_visit->gender; ?></td>

				<td>
					
				</td> 
		</tr>
		<tr width="95%">
				<td><b>Father/Spouse: </b> <?php echo $patient_visit->parent_spouse; ?></td>
				<td><b>Address:</b> <?php echo $patient_visit->address." ".$patient_visit->place; ?></td>
				<td></td>
		</tr>
		<tr width="95%">
				<td><b><?php echo $patient_visit->visit_type;?> number : </b><?php echo $patient_visit->hosp_file_no; ?></td>
				<td><b>Department : </b><?php echo $patient_visit->department; ?> </td>
				<td><b>Phone : </b><?php echo $patient_visit->phone; ?></td>
		</tr>
		</tbody>
		<tbody>
		<tr><td colspan="3"></td></tr>
		<tr data-patient-clinical-details data-source="patient_visits" data-index="<?php echo $pvInd; ?>" data-print-mode="true" data-skip-if-no-value="true"></tr>

		<?php if(!!$patient_visit->presenting_complaints) { ?>
		<tr class="print-element">
			<td  style="padding-top:20px" colspan="3">
			<b>Symptoms: </b><?php echo $patient_visit->presenting_complaints;?> 
			</td>
		</tr>
		<?php } ?>
		<?php if(!!$patient_visit->past_history) { ?>
		<tr class="print-element">
			<td colspan="3">
			<b>Past History: </b><?php echo $patient_visit->past_history;?> 
			</td>
		</tr>
		<?php } ?>
		<?php if(!!$patient_visit->family_history) { ?>
		<tr class="print-element">
			<td colspan="3">
			<b>Family History: </b><?php echo $patient_visit->family_history;?> 
			</td>
		</tr>
		<?php } ?>
		</tbody>
		<?php if(!!$patient_visit->clinical_findings) { ?>
		<tr class="print-element" width="95%">
			<td colspan="3"  style="padding-top:20px">
			<b>Clinical Findings</b>: <?php echo $patient_visit->clinical_findings;?>
			</td>
		</tr>
		<?php } ?>
		<?php 
		
		if(isset($clinical_notes) &&  !!$clinical_notes) { ?>
		<?php
			$i=1;
				foreach($clinical_notes as $note){ 
					if($patient_visit->visit_id == $note->visit_id){
					?>
					<?php if($i == 1){ ?>
		<tr class="print-element" width="95%" >				
			<td colspan="3"><b><u>Clinical Notes</u></b></td>
		</tr>
		<tr class="print-element" width="95%" >				
			<td colspan="3">
					<table border=1 cellpadding="5" style="border-collapse:collapse;width:100%;">
					<thead>
						<tr>
							<th>#</th>
							<th>Date</th>
							<th>Note</th>
						</tr>
					</thead>
					<tbody> <?php } ?>					
						<tr>
							<td><?php echo $i++; ?></td>
							<td><?php if($note->note_time!=0) echo date("d-M-Y g:iA",strtotime($note->note_time)); ?></td>
							<td><?php echo $note->clinical_note;?></td>
						</tr>
						<?php  } } ?>
					</tbody>
					</table>
					<br />
			</td>
		</tr>
		<?php } ?>

		<?php if(!!$patient_visit->cvs || !!$patient_visit->rs || !!$patient_visit->pa || !!$patient_visit->cns) { ?>
		<tr class="print-element">
			<td colspan="3">
			<table class="table borderless" style="border:none">
			<tr>
			<?php if(!!$patient_visit->cvs) { ?>
				<td>
					<b>CVS: </b><?php echo $patient_visit->cvs;?> 
				</td>
			<?php } ?>
			<?php if(!!$patient_visit->rs) { ?>
				<td colspan="3">
				<b>RS: </b><?php echo $patient_visit->rs;?> 
				</td>
			<?php } ?>
			<?php if(!!$patient_visit->pa) { ?>
				<td colspan="3">
				<b>PA:</b> <?php echo $patient_visit->pa;?> 
				</td>
			<?php } ?>
			</tr>
			</table>
			</td>
		</tr>
		<?php } ?>
		<?php 
		if(isset($tests_ordered) && count($tests_ordered)>0){ ?>				
		<tr  class="print-element" style="width:100%">
			<td colspan="3"><b><u>Diagnositcs</u></b><br></td>
		</tr>
		<?php
			$count=0;
			$text_result_tests=array();
			foreach($tests_ordered as $test){	
				if($test->text_result==1 && $test->numeric_result == 0 && $test->binary_result == 0) {
					$text_result_tests[] = $test;
					array_splice($all_tests,$count,1);
					$count--;
				}
				$count++;
			}
			if(count($text_result_tests)>0) { 
		?>
		<?php 
					$o=array();
					foreach($text_result_tests as $order){
						$o[]=$order->order_id;
					}
					$o=array_unique($o);
					$i=1;
					foreach($o as $ord){	?>
						<?php
						foreach($text_result_tests as $order) { 
							if($order->order_id == $ord) { ?>
							<tr class="print-element" width="95%" >
								<td colspan="3">
									<span style="float:right"><?php echo $order->order_date_time;?></span>
									<b>Test: </b> <?php echo $order->test_name;?><br />
									<b>Report: </b><?php if($order->test_status==2 && $order->text_result == 1) echo $order->test_result_text; else echo "NA";?>
								</td>
							</tr>
						<?php
						}
						} ?>
					<?php } ?>
		<?php } 
		if(count($all_tests)>0){ ?>
		
		<tr class="print-element" width="95%" >
			<td colspan="3">
			<br>
			<?php 
					$o=array();
					foreach($all_tests as $order){
						$o[]=$order->order_id;
					}
					$o=array_unique($o);
					$i=1;
					foreach($o as $ord){	?>
						<?php
						foreach($all_tests as $order) { 
							
							if($patient_visit->visit_id == $order->visit_id){
							if($order->order_id == $ord) { ?>
				<?php if($i==1){ ?>
				<table id="table-prescriptions">
				<tbody>
					<tr>
					<td style="width:3em">#</td>
					<td style="width:10em">Order Date</td>
					<td style="width:10em">Specimen</td>
					<td style="width:12em">Test</td>
					<td style="width:10em">Value</td>
					<td style="width:5em">Report - Binary</td>
					<td style="width:10em">Report</td>
					</tr>
				<?php } ?>
						<tr <?php if($order->test_status == 2) { ?> onclick="$('#order_<?php echo $ord;?>').submit()" <?php } ?>>
								<td><?php echo $i++;?></td>
								<td>
									<?php echo $order->order_id;?>
									</form>
								</td>
								<td><?php echo $order->specimen_type;?></td>
								<td>
								<?php
									if($order->test_status==1){
										$label="label-warning"; $status="Completed"; }
									else if($order->test_status == 2){ $label = "label-success"; $status = "Approved"; }
									else if($order->test_status == 0){ $label = "label-default"; $status = "Ordered"; }
									echo '<label class="label '.$label.'" title="'.$status.'">'.$order->test_name."</label><br />";
								?>
								</td>
								<td>
									<?php if($order->test_status==2 && $order->numeric_result == 1) echo $order->test_result." ".$order->lab_unit; else echo "NA";?>
								</td>
								<td>
									<?php if($order->test_status==2 && $order->binary_result == 1) echo $order->test_result_binary; else echo "NA";?>
								</td>
								<td>
									<?php if($order->test_status==2 && $order->text_result == 1) echo $order->test_result_text; else echo "NA";?>
								</td>
						</tr>
						<?php
						}}
						} ?>
					<?php } ?>
				</tbody>
				</table>	
			</td>
		</tr>
		<?php }
		} ?>
		<?php if(!!$patient_visit->final_diagnosis) { ?>
		<tr class="print-element" width="95%" >
			<td colspan="3">
			<b>Final Diagnosis</b>: <?php echo $patient_visit->final_diagnosis;?>
			</td>
		</tr>
		<?php } ?>
		<?php 
		if(isset($prescriptions) && !!$prescriptions){ ?>
		<tr class="print-element" width="95%">
			<td  style="padding-top:20px" class="print-text" colspan="3">
				<b><u>Medicines Prescribed: </u></b>
			</td>
		</tr>
		<tr>
		<td colspan="3">		
			<table id="table-prescriptions">
			<thead>
				<tr>
					<th rowspan="2" width="30px">S.no</th>
					<th rowspan="2" width="20%;">
					<img src="<?php echo base_url();?>assets/images/medicines.jpg" width="20px" alt="" />
					Medicine
					<img src="<?php echo base_url();?>assets/images/syrup.jpg" width="20px" alt="" /></th>
				<!--	<th rowspan="2" width="50px">Frequency</th> -->
					<th rowspan="2" width="50px"><img src="<?php echo base_url();?>assets/images/calendar.jpg" width="20px" alt="Days" /><br />Days</th>
					<th colspan="6" align="center" width="300px"><img src="<?php echo base_url();?>assets/images/timings.jpg" width="20px"  alt="Timings" />
					<span style="position:relative;">Timings</span></th>
					<th rowspan="2" width="50px">Issued Quantity</th>
				</tr>
				<tr align="center">
					<th colspan="2" width="30px"><img src="<?php echo base_url();?>assets/images/morning.jpg" width="30px" height="30px" />
					<span style="top:-10px;position:relative;">Morning</span>
					<br />
					<-<img src="<?php echo base_url();?>assets/images/food.jpg" alt="Food" width="30px" height="30px" />-></th>
					<th colspan="2" width="30px"><img src="<?php echo base_url();?>assets/images/afternoon.jpg" width="30px" height="30px" />
					<span style="top:-10px;position:relative;">Afternoon</span>
					<br />
					<-<img src="<?php echo base_url();?>assets/images/food.jpg" alt="Food" width="30px" height="30px" />-></th>
					<th colspan="2" width="30px"><img src="<?php echo base_url();?>assets/images/night.jpg" width="30px" height="30px" />
					<span style="top:-10px;position:relative;">Evening</span>
					<br />
					<-<img src="<?php echo base_url();?>assets/images/food.jpg" alt="Food" width="30px" height="30px" />-></th>
				</tr>
			</thead>
			<tbody>
			<?php 
			$i=1;
			foreach($prescriptions as $pres){
				if($patient_visit->visit_id == $pres->visit_id){ ?>				
			<tr>
				<td width="30px"  style="padding-left:15px"><?php echo $i++;?></td>
				<td><?php echo $pres->item_name.' - '.$pres->item_form;?><br><?php if($pres->note!='') echo '-'.$pres->note;?></td>
				<!--<td><?php echo $pres->frequency;?></td> -->
				<td width="40px" style="padding-left:20px"><?php echo $pres->duration;?></td>
				<td width="30px" style="padding-left:15px"><?php if($pres->morning == 1 || $pres->morning == 3) echo "<i class='fa fa-check'></i>";?></td>
				<td width="30px" style="padding-left:15px"><?php if($pres->morning == 2 || $pres->morning == 3) echo " <i class='fa fa-check'></i>";?></td>
				<td width="30px" style="padding-left:15px"><?php if($pres->afternoon == 1 || $pres->afternoon == 3) echo "<i class='fa fa-check'></i>";?></td>
				<td width="30px" style="padding-left:15px"><?php if($pres->afternoon == 2 || $pres->afternoon == 3) echo "<i class='fa fa-check'></i>";?></td>
				<td width="30px" style="padding-left:15px"><?php if($pres->evening == 1 || $pres->evening == 3) echo "<i class='fa fa-check'></i>";?></td>
				<td width="30px" style="padding-left:15px"><?php if($pres->evening == 2 || $pres->evening == 3) echo "<i class='fa fa-check'></i>";?></td>
				<td><?php if($pres->quantity > 0) echo $pres->quantity;?></td>
			</tr>
			<?php }} ?>
			</tbody>
		</table>
		</td>
		</tr>
		<?php } ?>

		<?php if(!!$patient_visit->advise) { ?>
		<tr class="print-element" width="95%" >
			<td  style="padding-top:20px" colspan="3">
			<b>Advise</b>: <?php echo $patient_visit->advise;?>
			</td>
		</tr>
		<?php } ?>
		<tr class="print-element" width="95%" >
		<?php if(!!$patient_visit->doctor_name){ ?>
			<td colspan="3" style="text-align:right">
			<br />
			<br />
			<b>
				<?php echo $patient_visit->doctor_name."<br />".$patient_visit->designation; ?>
				</b>
			</td>
			<?php } else { ?>
			<td colspan="3" style="text-align:center">
			<br />
			<br />
			<b>
			Doctor:	
			</b>
			</td>
<?php } ?>
		</tr>				
</table>
<p>Note: This is a Healthcare IT System generated document and does not need a signature</p>
<p style="page-break-before: always">
				<?php } ?>
<p style="page-break-before: avoid">