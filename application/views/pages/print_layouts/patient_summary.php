		<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" media="print">
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/qrcode.min.js"></script>  
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-barcode.min.js"></script>
		<?php $patient=$patients[0];?>
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
			#table-prescription{
				width:100%;
				position:relative;
			}
			#table-prescription td, th{
				border:1px solid black;
				padding:3px;
			}

			}
		</style>
		<script type="text/javascript">
			$(function(){
				var settings = {
				barHeight: 20,
				fontSize: 20
				};
				$("#patient_barcode").barcode(
					"<?php echo $patient->patient_id;?>",
					"code128",
					settings
				);
			});
		</script>
		<table style="width:98%;padding:5px;">
				<tbody>
				<tr>
				<td colspan="3"><?php $hospital=$this->session->userdata('hospital');?>
				<div style="float:left;text-align:left;left:auto;">
				<font size="4"><?php echo $hospital['hospital'];?></font><br />
					<?php if(!!$hospital['description']) echo $hospital['description']."<br />";?>
					<?php echo $hospital['place']; ?>, 
					<?php echo $hospital['district']; ?>
				<br />
				</div>			
				<div style="float:right;margin-right:10;">			
				<img src="<?php echo base_url()."assets/logos/".$hospital['logo'];?>" width="65px" height="65px" />
				</div>
				</td>
				</tr>
				<tr>
				<td colspan="3">
				<div style="float:middle;text-align:center">
				<span ><b>
					<?php if($patient->visit_type == "OP") echo "CONSULTATION"; else echo "DISCHARGE";?> SUMMARY</b></span>
					
				</div>
				
				</td></tr>
				<tr>
				<td colspan="3"><?php $hospital=$this->session->userdata('hospital');?>
				<div style="float:left;text-align:left;left:auto;">
				<b><?php 
					if($patient->visit_type == "OP") 
						echo "Consultation"; 
					else 
						echo "Admit";?> Date: </b> <?php 
						if($patient->appointment_time === NULL){
						echo date("d-M-Y",strtotime($patient->admit_date)); echo " ".date("g:i A",strtotime($patient->admit_time));
						}else{
						echo date("d-M-Y", strtotime("$patient->appointment_time"))." ".date("h:i A", strtotime("$patient->appointment_time"));
						
						}
						?>
						<br/>
						<?php
					if($patient->visit_type != "OP"){ ?>
						<b> <?php if(!!$patient->outcome) echo $patient->outcome; else echo "Discharge"?> 
							Date:</b>
							<?php 
							if($patient->outcome_date != 0) echo date("d-M-Y",strtotime($patient->outcome_date)); 
							if($patient->outcome_time != 0) echo " ".date("g:i A",strtotime($patient->outcome_time)); 
					}
					
					?>
					
				</div>							
				<div style="float:right;">
				
				<span  id="patient_barcode"></span>
				<div id="barcode"></div>
				</div>
				<div style="float:right;">
				<b> Person ID: </b>
				</div>
				</td>
				</tr>
				</tbody>
				<tbody height="10%">
				<tr width="95%">
						<td style="padding-top:20px"><b>Name: </b><?php echo $patient->name; ?></td>
						<td style="padding-top:20px"><b>Age/Sex: </b><?php 
							if($patient->age_years!=0){ echo $patient->age_years." Yrs "; } 
							if($patient->age_months!=0){ echo $patient->age_months." Mths "; }
							if($patient->age_days!=0){ echo $patient->age_days." Days "; }
							if($patient->age_years==0 && $patient->age_months == 0 && $patient->age_days==0) echo "0 Days";
							echo "/".$patient->gender; ?></td>

						<td></td>
							
						
				</tr>
				<tr width="95%">
						<td><b>Father/Spouse: </b> <?php echo $patient->parent_spouse; ?></td>
						<td><b>Address:</b> <?php echo $patient->address." ".$patient->place; ?></td>
						<td></td>
				</tr>
				<tr width="95%">
						<td><b><?php echo $patient->visit_type;?> number : </b><?php echo $patient->hosp_file_no; ?></td>
						<td><b>Department : </b><?php echo $patient->department; ?> </td>
						<td><b>Phone : </b><?php echo $patient->phone; ?></td>
				</tr>
				</tbody>
				<tbody>
				<tr><td colspan="3"></td></tr>
				<tr data-patient-clinical-details data-source="patient" data-print-mode="true" data-skip-if-no-value="true"></tr>

				<?php if(!!$patient->presenting_complaints) { ?>
				<tr class="print-element">
					<td  style="padding-top:20px" colspan="3">
					<b>Symptoms: </b><?php echo $patient->presenting_complaints;?> 
					</td>
				</tr>
				<?php } ?>
				<?php if(!!$patient->past_history) { ?>
				<tr class="print-element">
					<td colspan="3">
					<b>Past History: </b><?php echo $patient->past_history;?> 
					</td>
				</tr>
				<?php } ?>
				<?php if(!!$patient->family_history) { ?>
				<tr class="print-element">
					<td colspan="3">
					<b>Family History: </b><?php echo $patient->family_history;?> 
					</td>
				</tr>
				<?php } ?>

				<?php if(!!$patient->cvs || !!$patient->rs || !!$patient->pa || !!$patient->cns) { ?>
				<tr class="print-element">
					<td colspan="3">
					<table>
					<tbody style="border:0px">
						<tr >
						<?php if(!!$patient->cvs) { ?>
							<td>
								<b>CVS: </b><?php echo $patient->cvs;?> 
							</td>
						<?php } ?>
						<?php if(!!$patient->rs) { ?>
							<td colspan="3">
							<b>RS: </b><?php echo $patient->rs;?> 
							</td>
						<?php } ?>					
						<td colspan="3">
							<?php if(!!$patient->pa) { ?>
								<b>PA:</b> <?php echo $patient->pa;?> &nbsp;
							<?php } ?>
							<?php if(!!$patient->cns) { ?>
								<b>CNS</b>: <?php echo $patient->cns;?>
							<?php } ?>
						</td>
						
						</tr>
					</tbody>
					</table>
					</td>
				</tr>
				<?php } ?>
				</tbody>
				<?php if(!!$patient->clinical_findings) { ?>
				<tr class="print-element" width="95%">
					<td colspan="3"  style="padding-top:20px">
					<b>Clinical Findings</b>: <?php echo $patient->clinical_findings;?>
					</td>
				</tr>
				<?php } ?>
				<?php if(isset($visit_notes) &&  !!$visit_notes) { ?>
				<tr class="print-element" width="95%" >				
					<td colspan="3"><b><u>Clinical Notes</u></b></td>
				</tr>
				<tr class="print-element" width="95%" >				
					<td colspan="3">
							<table border=1 cellpadding="5" style="border-collapse:collapse;width:100%;">
							<thead>
								<tr>
									<th>#</th>
									<th width="150px">Date</th>
									<th>Note</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$i=1;
							 foreach($visit_notes as $note){ ?>
								<tr>
									<td><?php echo $i++; ?></td>
									<td width="150px"><?php if($note->note_time!=0) echo date("d-M-Y g:iA",strtotime($note->note_time)); ?></td>
									<td><?php echo $note->clinical_note;?></td>
								</tr>
								<?php  } ?>
							</tbody>
							</table>
							<br />
					</td>
				</tr>
				<?php } ?>
				<?php 
				if(isset($tests) && count($tests)>0){ ?>				
				<tr  class="print-element" style="width:100%">
					<td colspan="3"><b><u>Diagnositcs</u></b><br></td>
				</tr>
				<?php
					$count=0;
					$text_result_tests=array();
					foreach($tests as $test){	
						if($test->text_result==1 && $test->numeric_result == 0 && $test->binary_result == 0) {
							$text_result_tests[] = $test;
							array_splice($tests,$count,1);
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
				if(count($tests)>0){?>
				
				<tr class="print-element" width="95%" >
					<td colspan="3">
					<br>
						<table id="table-prescription">
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
							<?php 
							$o=array();
							foreach($tests as $order){
								$o[]=$order->order_id;
							}
							$o=array_unique($o);
							$i=1;
							foreach($o as $ord){	?>
								<?php
								foreach($tests as $order) { 
									if($order->order_id == $ord) { ?>
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
								}
								} ?>
							<?php } ?>
						</tbody>
						</table>	
					</td>
				</tr>
				<?php }
				} ?>
				<?php if(!!$patient->final_diagnosis) { ?>
				<tr class="print-element" width="95%" >
					<td colspan="3">
					<b>Final Diagnosis</b>: <?php echo $patient->final_diagnosis;?>
					</td>
				</tr>
				<?php } ?>
				<?php if(isset($prescription) && !!$prescription){ ?>
				<tr class="print-element" width="95%">
					<td  style="padding-top:20px" class="print-text" colspan="3">
						<b><u>Medicines Prescribed: </u></b>
					</td>
				</tr>
				<tr>
				<td colspan="3">
				
					<table id="table-prescription">
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
					foreach($prescription as $pres){ ?>					
					<tr>
						<td width="30px"  style="padding-left:15px"><?php echo $i++;?></td>
						<td><?php echo $pres->item_name.' - '.$pres->item_form;?><br><?php if($pres->note!='') echo '-'.$pres->note;?></td>
					<!--	<td><?php echo $pres->frequency;?></td> -->
						<td width="40px" style="padding-left:20px"><?php echo $pres->duration;?></td>
						<td width="30px" style="padding-left:15px"><?php if($pres->morning == 1 || $pres->morning == 3) echo "<i class='fa fa-check'></i>";?></td>
						<td width="30px" style="padding-left:15px"><?php if($pres->morning == 2 || $pres->morning == 3) echo " <i class='fa fa-check'></i>";?></td>
						<td width="30px" style="padding-left:15px"><?php if($pres->afternoon == 1 || $pres->afternoon == 3) echo "<i class='fa fa-check'></i>";?></td>
						<td width="30px" style="padding-left:15px"><?php if($pres->afternoon == 2 || $pres->afternoon == 3) echo "<i class='fa fa-check'></i>";?></td>
						<td width="30px" style="padding-left:15px"><?php if($pres->evening == 1 || $pres->evening == 3) echo "<i class='fa fa-check'></i>";?></td>
						<td width="30px" style="padding-left:15px"><?php if($pres->evening == 2 || $pres->evening == 3) echo "<i class='fa fa-check'></i>";?></td>
						<td><?php if($pres->quantity > 0) echo $pres->quantity;?></td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
				</td>
				</tr>
				<?php } ?>

				<?php if(!!$patient->advise || !!$patient->decision) { ?>
				<tr class="print-element" width="95%" >
					<td  style="padding-top:20px" colspan="3">
					<?php if(!!$patient->decision) { ?>
					<b>Decision</b>: <?php echo $patient->decision;?><br />
					<?php } ?>
					<?php if(!!$patient->advise) { ?>
					<b>Advise</b>: <?php echo $patient->advise;?>
					<?php } ?>
					</td>
				</tr>
				<?php } ?>
				<tr class="print-element" width="95%" >
				<?php if(!!$patient->doctor_name){ ?>
			<td colspan="3" style="text-align:right">
			<br />
			<br />
				<b>
				<?php echo $patient->doctor_name."<br />".$patient->designation; ?>
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
