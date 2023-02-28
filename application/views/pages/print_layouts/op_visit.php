<link rel="stylesheet"   href="<?php echo base_url();?>assets/css/main.css"  <?php if(!isset($preview_only)) echo "media='print'"; ?> >
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
						<td style="padding-top:20px;padding:5px;"> <b>Name: </b><?php echo $patient->name; ?></td>
						<td style="padding-top:20px;padding:5px;"> <b>Age/Sex: </b><?php 
							if($patient->age_years!=0){ echo $patient->age_years." Yrs "; } 
							if($patient->age_months!=0){ echo $patient->age_months." Mths "; }
							if($patient->age_days!=0){ echo $patient->age_days." Days "; }
							if($patient->age_years==0 && $patient->age_months == 0 && $patient->age_days==0) echo "0 Days";
							echo "/".$patient->gender; ?></td>

						<td></td>
							
						
				</tr>
				<tr width="95%">
						<td style="padding:5px;"><b> Father/Spouse: </b> <?php echo $patient->parent_spouse; ?></td>
						<td style="padding:5px;"> <b>Address: </b><?php echo $patient->address." ".$patient->place; ?></td>
						<td style="padding:5px;"><b> Phone : </b> <?php echo $patient->phone; ?></td>
						<td></td>
				</tr>
				<tr width="95%">
						<td style="padding:5px;" > <?php echo $patient->visit_type;?><b> OP number :</b> <?php echo $patient->hosp_file_no; ?></td>
						<td style="padding:5px;"> <b> Department/Unit:</b> <?php echo $patient->department; ?> </td>
						<td style="padding:5px;"> <b> Room no : </b><?php echo $patient->phone; ?></td>
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