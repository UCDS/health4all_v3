<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" media="all">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/qrcode.min.js"></script>  
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-barcode.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>

		<?php $pat_val=$this->session->userdata('patient_details'); 
				$patient = $pat_val[0];
			  $hosp_data = $this->session->userdata('hospitals');
				$hospitals = $hosp_data[0];
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
					</td>
				</tr>
				</tbody>
				<tbody height="10%">
					<?php if (!empty($form_data)) : ?>
						<?php 
						$form_data_keys = array_keys($form_data);
						$total_data = count($form_data_keys);
						for ($i = 0; $i < $total_data; $i += 2) :
							$key1 = $form_data_keys[$i]; 
							$value1 = $form_data[$key1]; 

							$key2 = ($i + 1 < $total_data) ? $form_data_keys[$i + 1] : '';
							$value2 = ($i + 1 < $total_data) ? $form_data[$key2] : ''; 

							// Skip unwanted keys (Form Header, sequence, Search patient id, form_id)
							if (in_array($key1, ['Form header','sequence', 'Search patient id', 'form_id'])) {
								continue;
							}
							if (in_array($key2, ['sequence', 'Search patient id','Form header'])) {
								continue;
							}

							// Format the key names
							$key1 = strtok($key1, ' DOT');
							$key1 = ucfirst(str_replace('_', ' ', $key1));
							$key2 = strtok($key2, ' DOT');
							$key2 = ucfirst(str_replace('_', ' ', $key2)); 
							if (stripos($key1, 'ndps') !== false) {
								$value1 = ($value1 == '1' || $value1 === 1) ? 'Yes' : 'No';
								$key1 = 'NDPS';
							}
							if ($key2 && stripos($key2, 'ndps') !== false) {
								$value2 = ($value2 == '1' || $value2 === 1) ? 'Yes' : 'No';
								$key2 = 'NDPS';
							}
						
						?>
							<tr width="90%">
								<td><strong><?php echo $key1; ?></strong></td>
								<td><?php echo htmlspecialchars($value1); ?></td>
								<?php if ($key2) : ?>
									<td><strong><?php echo $key2; ?></strong></td>
									<td><?php echo htmlspecialchars($value2); ?></td>
								<?php endif; ?>
							</tr>
						<?php endfor; ?>
					<?php else: ?>
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