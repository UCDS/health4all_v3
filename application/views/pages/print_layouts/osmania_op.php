		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/main.css" media="print" >
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/qrcode.min.js"></script>  
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-barcode.min.js"></script>  

        <script>
            $(function(){
				$("#barcode").barcode("<?php echo $registered->patient_id;?>",'codabar',{barWidth:2, barHeight:30,showHRI:false});
			});
		</script>
		<table style="width:98%;padding:5px;">
				<tr>
				<td colspan="3">
				<div>
					<div style="position:absolute;" id="barcode"></div>
				</div>
				<?php $hospital=$this->session->userdata('hospital');?>
				<div style="float:middle;text-align:center">
				<font size="4"><?php echo $hospital['hospital'];?></font><br />
					<?php echo $hospital['description'];?> 
					@ 
					<?php echo $hospital['place']; ?>, 
					<?php echo $hospital['district']; ?>,
					<?php echo date("d-M-Y",strtotime($registered->admit_date)); ?>,
					<?php echo date("g:iA",strtotime($registered->admit_time)); ?>
				</div>
				</td>
				</tr>
				<tbody height="10%" style="border:1px solid black;">
				<tr width="95%">
						<td style="padding:5px;"><b>Name:</b> <?php echo $registered->name; ?></td>
						<td><b>Sex/Age:</b> <?php echo $registered->gender."/"; 
								if($registered->age_years!=0){ echo $registered->age_years." Yrs "; } 
								if($registered->age_months!=0){ echo $registered->age_months." Mths "; }
								if($registered->age_days!=0){ echo $registered->age_days." Days "; }
								if($registered->age_years==0 && $registered->age_months == 0 && $registered->age_days==0) echo "0 Days";
						 ?></td>
						<td rowspan="4">
							<div id="qr_code" style="position:absolute;padding-top:5px;"></div>
							<div style="position:absolute;top:120px;"><b>ID:</b> <?php echo $registered->patient_id;?></div>

							<?php
								if($registered->gender == "M"){
									$relation = "S/O";
								} 
								else $relation = "D/O";
								$qr_text = "i:".$registered->patient_id." n:".$registered->name." g:".$registered->gender." a:".$registered->age_years." r:".$relation." s:".$registered->parent_spouse." l:".$registered->place." p:".$registered->phone;
							?>
							<script type="text/javascript">
								document.getElementById("qr_code").innerHTML="";
								var qrcode = new QRCode(document.getElementById("qr_code"), {
									width : 75,
									height : 75
								});
								qrcode.makeCode("<?php echo $qr_text;?>");
							</script>
						</td> 
				</tr>
				<tr width="95%">
						<td style="padding:5px;"><b>Father/Spouse:</b>  <?php echo $registered->parent_spouse; ?></td>
						<td><b>Address:</b> <?php if(!!$registered->address) echo $registered->address.", "; echo $registered->place; ?></td>
				</tr>
				<tr width="95%">
						<td style="padding:5px;">
							<b>OP number:</b> <?php echo $registered->hosp_file_no; ?> 
						</td>
						<td><b>Phone:</b> <?php echo $registered->phone; ?></td>
				</tr>
				<tr>
						<td style="padding:5px;">
							<b>Department 
							<?php if(!!$registered->unit_name) echo "/Unit:"; else echo ":"; ?>
							</b>
							<?php 
								echo $registered->department; 
								if(!!$registered->unit_name) echo "/".$registered->unit_name;
							?> 
						</td>
						<td><b>Room No:</b> <?php echo $registered->op_room_no; ?></td>
				</tr>
				</tbody>
				<tr class="print-element" width="95%" height="100px">
					<td style="padding-top:10px;">
						Chief Complaint:
					</td>
					<td style="adding-top:10px;">
						BP: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;/ &nbsp; &nbsp;
					</td>
					<td style="adding-top:10px;">Weight : </td>
				</tr>
				<tr class="print-element" width="95%" height="120px">
					<td>
						Examination:
					</td>
				</tr>
				<tr class="print-element" width="95%" height="70px">
					<td>
						Provisional Diagnosis:
					</td>
				</tr>
				<tr class="print-element" width="95%" height="70px">
					<td>
						Investigations:
					</td>
				</tr>
				<tr class="print-element" width="95%">
					<td class="print-text">
						Medicines Prescribed: 
					</td>
				</tr>
				<tr>
				<td colspan="3">
				<table id="table-prescription">
						<tr align="center" >
							<td rowspan="2" width="30px">S.no</td>
							<td rowspan="2" width="45%;">
							<img src="<?php echo base_url();?>assets/images/medicines.jpg" width="30px" alt="" />
							Medicine
							<img src="<?php echo base_url();?>assets/images/syrup.jpg" width="30px" alt="" />
							<br />(CAPITAL LETTERS PLEASE)</td>
							<td rowspan="2" width="50px">Strength</td>
							<td rowspan="2" width="50px"><img src="<?php echo base_url();?>assets/images/calendar.jpg" width="30px" alt="Days" /><br />Days</td>
							<td colspan="10" align="center" width="300px"><img src="<?php echo base_url();?>assets/images/timings.jpg" width="50px" height="40px" alt="Timings" />
							<span style="top:-10px;position:relative;">Timings</span></td>
						</tr>
						<tr align="center">
							<td width="30px"><img src="<?php echo base_url();?>assets/images/morning.jpg" width="30px" height="20px" />
							<span style="top:-10px;position:relative;">Morning</span></td>
							<td width="30px"><img src="<?php echo base_url();?>assets/images/afternoon.jpg" width="30px" height="20px" />
							<span style="top:-10px;position:relative;">Afternoon</span></td>
							<td width="30px"><img src="<?php echo base_url();?>assets/images/night.jpg" width="30px" height="20px" />
							<span style="top:-10px;position:relative;">Evening</span></td>
						</tr>
						<?php for($i=0;$i<5;$i++){ ?>
						<tr height="40px" align="center" valign="center">
							<td><?= $i+1 ?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
						<?php } ?>
						</table>
				</td>
				</tr>
				<tr class="print-element" width="95%" height="80px">
				<td>
						<br />Follow up advice:
				</td>
				</tr>
				<tr>
				<td colspan="2" align="right">Doctor :</td>
				</tr>
		</table>