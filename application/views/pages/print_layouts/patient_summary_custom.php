<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" media="all">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/qrcode.min.js"></script>  
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-barcode.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>

		<?php  
			$patient = $patient_details[0];
			$hospitals = $hospital_details[0];
		?>

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
		<script>
			let patient = <?php echo json_encode($patient); ?>;
			//console.log(patient);
			let details = <?php echo json_encode($hospitals); ?>;
			//console.log(details);
		</script>

		<style>
			@media all{
			table{
				font-family: "Trebuchet MS","Sans Serif", Serif;

			}
			tbody{
				border:1px solid #ccc;
			}
			td{
				padding:3px;
			}
			th{
				text-align:center;
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
		
		
		<table style="width:98%;padding:5px;margin-left:10px;">
				<tbody>
					<tr>
						<td colspan="3"> 
						<div style="float:left;text-align:left;left:auto;width:75%;">
							<?php if ($hospitals->telehealth == "0") {?>
							<font size="4"><?php echo $hospitals->hospital;?></font><br />
								<?php if(!empty($hospitals->description)){ echo $hospitals->description."<br />"; }?>
								<!--<?php echo $hospitals->place; ?>, 
								<?php echo $hospitals->district; ?>-->
							<br />
							<?php } else {?>
							<?php if(!!$patient->doctor_name) {?> 
							<font size="4">Teleconsultation with <?php echo $patient->doctor_name; ?></font><br />
							<?php } else {?>
							<font size="4">Teleconsultation with Doctor</font><br />
							<?php } ?>
							
									<?php echo "Facilitated by  ".$hospitals->hospital."<br />";?>
								<?php if(!!$hospitals->description) echo $hospitals->description."<br />";?>
							<?php } ?>
						</div>			
						<div style="float:right;margin-right:10;margin-top:5px;">			
							<img src="<?php echo base_url()."assets/logos/".$hospitals->logo;?>" width="65px" height="65px" />
						</div>
						</td>
					</tr>
				<tr>
					<td colspan="3">
						<div style="float:middle;text-align:center;margin-top:-4%!important;">
						<span ><b>
						<?php 
								if (!empty($form_data['form_header'])) {
									echo $form_data['form_header'];
								} else {
									if ($patient->summary_header == 0) { 
										if ($patient->visit_type == "OP") {
											echo "CONSULTATION"; 
										} else {
											echo "DISCHARGE"; 
										}
										echo " SUMMARY";
										if (!empty($patient->visit_name)) {
											echo ' - ' . $patient->visit_name;
										}
									} else {
										echo $patient->visit_name;
									}
								}
							?>
						</b></span>
						</div>
					</td>
			    </tr>
				<tr>
					<td colspan="3"><?php $hospital=$this->session->userdata('hospital');?>
						<div style="float:left;text-align:left;left:auto;">
						<b><?php 
							if($patient->visit_type == "OP") 
								if($patient->summary_header == 1) {
									echo "Date:";
								} else {	
									echo "Consultation Date:"; 
								}
							else {
								echo "Admit Date:"; 
								
								}
								?>  </b> <?php 
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
						<b> Person ID: <?php echo $patient->patient_id ?></b>
						</div>
						<tbody height="10%">
						<tr width="95%">
								<td style="padding-top:20px"><b>Name: </b><?php echo $patient->first_name.' '.$patient->last_name; ?></td>
								<td style="padding-top:20px"><b>Age/Sex: </b><?php 
									if($patient->age_years!=0){ echo $patient->age_years." Yrs "; } 
									if($patient->age_months!=0){ echo $patient->age_months." Mths "; }
									if($patient->age_days!=0){ echo $patient->age_days." Days "; }
									if($patient->age_years==0 && $patient->age_months == 0 && $patient->age_days==0) echo "0 Days";
									echo "/".$patient->gender; ?></td>

								<td></td>
									
								
						</tr>
						<tr width="95%">
								<td><b>Father/Spouse: </b> <?php echo $patient->spouse_name; ?></td>
								<td><b>Address:</b> <?php echo $patient->address." ".$patient->place; ?></td>
								<td></td>
						</tr>
						<tr width="95%">
								<td><b><?php echo $patient->visit_type;?> number : </b><?php echo $patient->hosp_file_no; ?></td>
								<td><b>Department : </b><?php echo $patient->department; ?> </td>
								<td><b>Phone : </b><?php echo $patient->phone; ?></td>
						</tr>
						</tbody>
					</td>
				</tr>
				</tbody>
				<tbody height="10%">
					<?php if (!empty($form_data)) : ?>
					<?php	$form_data_keys = array_keys($form_data);
					$total_data = count($form_data_keys);

					// Define the keys to skip
					$skip_keys = ['form_header', 'sequence', 'Search patient id', 'form_id', 'patient_id', 'visit_id', 'Form Header','address'];

					// Re-adjust the loop to process keys individually to avoid unwanted skipping
					for ($i = 0; $i < $total_data; $i++) {
						$key = $form_data_keys[$i];
						$value = $form_data[$key];
						
						// Check if the current key should be skipped. If so, continue to the next iteration.
						if (in_array($key, $skip_keys)) {
							continue;
						}
						// Initialize display variables for the current pair
						$display_key1 = '';
						$display_value1 = '';
						$display_key2 = '';
						$display_value2 = '';

						// First element of the pair
						$display_key1 = $key;
						$display_value1 = $value;
						if ($display_key1 === 'appointment_time' && !empty($display_value1)) {
							$datetime = new DateTime($display_value1);
							$display_value1 = $datetime->format('Y-m-d H:i'); // Format as 'YYYY-MM-DD HH:MM'
						}
						if (preg_match('/^Select/i', $display_value1)) {
							$display_value1 = '';
						}
						$display_key1 = strtok($display_key1, ' DOT');
						$display_key1 = ucfirst(str_replace('_', ' ', $display_key1));
						if (stripos($display_key1, 'ndps') !== false) {
							$display_value1 = ($display_value1 == '1' || $display_value1 === 1) ? 'Yes' : 'No';
							$display_key1 = 'NDPS';
						}

						// Check for a second element in the pair
						if ($i + 1 < $total_data) {
							$key2 = $form_data_keys[$i + 1];
							if (!in_array($key2, $skip_keys)) {
								$value2 = $form_data[$key2];
								$display_key2 = $key2;
								$display_value2 = $value2;

								if (preg_match('/^Select/i', $display_value2)) {
									$display_value2 = '';
								}
								$display_key2 = strtok($display_key2, ' DOT');
								$display_key2 = ucfirst(str_replace('_', ' ', $display_key2));
								if (stripos($display_key2, 'ndps') !== false) {
									$display_value2 = ($display_value2 == '1' || $display_value2 === 1) ? 'Yes' : 'No';
									$display_key2 = 'NDPS';
								}
								// Increment the main loop counter to skip the next iteration
								$i++;
							}
						}

						// Display the data in table rows
						?>
						<!-- old one with coming for 2 rows -->
						<!-- <tr width="90%">
							<td><strong><?php echo $display_key1; ?></strong></td>
							<td><?php echo htmlspecialchars($display_value1); ?></td>
							<?php if (!empty($display_key2)) : ?>
								<td><strong><?php echo $display_key2; ?></strong></td>
								<td><?php echo htmlspecialchars($display_value2); ?></td>
							<?php endif; ?>
						</tr> -->
						<tr width="90%">
							<td><strong><?php echo $display_key1; ?></strong></td>
							<td><?php echo htmlspecialchars($display_value1); ?></td>
						</tr>
						<tr width="90%">
							<?php if (!empty($display_key2)) : ?>
								<td><strong><?php echo $display_key2; ?></strong></td>
								<td><?php echo htmlspecialchars($display_value2); ?></td>
							<?php endif; ?>
						</tr>
					<?php } else: ?>
						<tr>
							<td colspan="4">No form data available</td>
						</tr>
					<?php endif; ?>
				</tbody>
					<style>
						.print-element p, .print-element ul, .print-element ol {
							margin: 0;
							padding: 0;
							line-height: 1.2;
						}
					</style>
					<br />
					<br />
				</tbody>


				
		</table>
<p>Note: This is a Healthcare IT System generated document and does not need a signature. <br>Report generated on <?php echo date("j-M-Y h:i A"); ?>.</p>
<style>
     
	 .btns {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            display: inline-block;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s;
        }
        .btns:hover {
            background-color: #0056b3;
        }
		@media print {
            .btns {
                display: none;
            }
        }
    </style>
<button class="btns" onclick="window.print()">Print</button>