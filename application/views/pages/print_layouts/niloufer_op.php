		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/main.css" media="print" >
		<table style="width:98%;padding:5px">
				<tr>
				<td colspan="3">
				<img style="float:right" style="margin-top:-20px" src="<?php echo base_url();?>assets/images/telangana-logo.jpg" width="60px" />
				<img style="float:left" src="<?php echo base_url();?>assets/images/<?php $hospital=$this->session->userdata('hospital'); echo $hospital['logo'];?>" width="60px" />
				<div style="float:middle;text-align:center">
				<!-- <b>Government of Telangana</b><br /> -->
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
						<td style="padding:5px;">Name: <?php echo $registered->name; ?></td>
						<td>Gender: <?php echo $registered->gender; ?></td>
						<td>Age: 	
							<?php 
							if($registered->age_years!=0){ echo $registered->age_years." Yrs "; } 
							if($registered->age_months!=0){ echo $registered->age_months." Mths "; }
							if($registered->age_days!=0){ echo $registered->age_days." Days "; }
							if($registered->age_years==0 && $registered->age_months == 0 && $registered->age_days==0) echo "0 Days";
							?>
						</td>
				</tr>
				<tr width="95%">
						<td  style="padding:5px;">Father / Spouse Name :  <?php echo $registered->parent_spouse; ?></td>
						<td>Address: <?php echo $registered->place; ?></td>
						<td>Phone : <?php echo $registered->phone; ?></td>
				</tr>
				<tr width="95%">
						<td  style="padding:5px;">OP number : <?php echo $registered->hosp_file_no; ?></td>
						<td>Department : <?php echo $registered->department; ?> </td>
						<td> 
						<?php 
						if(!!$registered->unit_name) echo "Unit";
						if(!!$registered->unit_name) echo ": "; 
						if(!!$registered->unit_name) echo $registered->unit_name;
						?>
						</td>
				</tr>
				</tbody>
				<tr class="print-element" width="95%" height="100px">
					<td colspan="2">
						Chief Complaint:
					</td>
					<td style="padding:5px;">Weight : </td>
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