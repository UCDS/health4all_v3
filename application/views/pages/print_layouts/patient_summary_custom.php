<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" media="all">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/qrcode.min.js"></script>  
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-barcode.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>

		<?php  
			$patient = $patient_details[0];
			$hospitals = $hospital_details;
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
							<?php if ($hospitals['telehealth'] == "0") {?>
							<font size="4"><?php echo $hospitals['hospital'];?></font><br />
								<?php if(!empty($hospitals['description'])){ echo $hospitals['description']."<br />"; }?>
								<!--<?php echo $hospitals['place']; ?>, 
								<?php echo $hospitals['district']; ?>-->
							<br />
							<?php } else {?>
							<?php if(!!$patient->doctor_name) {?> 
							<font size="4">Teleconsultation with <?php echo $patient->doctor_name; ?></font><br />
							<?php } else {?>
							<font size="4">Teleconsultation with Doctor</font><br />
							<?php } ?>
							
									<?php echo "Facilitated by  ".$hospitals['hospital']."<br />";?>
								<?php if(!!$hospitals['description']) echo $hospitals['description']."<br />";?>
							<?php } ?>
						</div>			
						<div style="float:right;margin-right:10;margin-top:5px;">			
							<img src="<?php echo base_url()."assets/logos/".$hospitals['logo'];?>" width="65px" height="65px" />
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
				<tbody>
					<?php
						$form_data = $this->session->userdata('form_data');
						$divData   = $this->session->userdata('divData');
						$layoutMap = [];
						if (!empty($divData)) {
							foreach ($divData as $div) {
								$layoutMap[$div['div_name']] = $div['layout'];
							}
						}

						$skip_keys = ['form_header', 'sequence', 'Search patient id', 'form_id', 'patient_id', 'visit_id','address'];

						$grouped = [];

						if (!empty($form_data)) {
							foreach ($form_data as $divName => $fields) {

								if (in_array($divName, ['form_header','patient_id','visit_id'])) continue;

								if (!is_array($fields)) continue;

								foreach ($fields as $key => $value) {

									if (in_array($key, $skip_keys)) continue;

									$grouped[$divName][$key] = $value;
								}
							}
						}
					?>
					<?php if (!empty($grouped)) : ?>
					<?php foreach ($grouped as $divName => $fields) : 

						$columns = isset($layoutMap[$divName]) ? $layoutMap[$divName] : 1;


						if ($columns == 1) $width = "100%";
						elseif ($columns == 2) $width = "50%";
						elseif ($columns == 3) $width = "33.33%";
						else $width = "100%";

					?>
					<tr>
						<td colspan="3" style="background:#d9edf7;text-align:center;">
							<strong><?php $cleanName = preg_replace('/_\d+$/', '', $divName); echo str_replace('_',' ', $cleanName); ?></strong>
						</td>
					</tr>

					<tr>
						<td colspan="3">
							<div style="display:flex; flex-wrap:wrap; width:100%;">

							<?php foreach ($fields as $key => $value):

								$label = ucfirst(str_replace('_',' ', $key));

								if ($key == 'appointment_time' && !empty($value)) {
									$value = (new DateTime($value))->format('Y-m-d H:i');
								}

								if (preg_match('/^Select/i', $value)) {
									$value = '';
								}

								if (stripos($key, 'ndps') !== false) {
									$value = ($value == '1') ? 'Yes' : 'No';
									$label = 'NDPS';
								}
							?>

								<div style="width:<?php echo $width; ?>; padding:5px; box-sizing:border-box;">
									<strong><?php echo $label; ?>:</strong>
									<?php echo htmlspecialchars($value); ?>
								</div>

							<?php endforeach; ?>

							</div>
						</td>
					</tr>
					<?php endforeach; ?>
					<?php else: ?>
						<tr>
							<td colspan="3">No form data available</td>
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