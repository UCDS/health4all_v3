		<link rel="stylesheet" href="<?php echo base_url();?>assets/css/main.css" media="print" >
		<table style="width:98%;padding:5px">
				<tr>
				<td colspan="3">
				<img style="float:right" style="margin-top:-20px" src="<?php echo base_url();?>assets/images/ap-logo.png" alt="" width="60px" />
				<img style="float:left" src="<?php echo base_url();?>assets/images/<?php $hospital=$this->session->userdata('hospital');echo $hospital['logo'];?>" alt="" width="60px" />
				<div style="float:middle;text-align:center">
				<b>Government of Telangana</b><br />
				<font size="4"><?php echo $hospital['hospital'];?></font>
					<?php echo $hospital['description'];?> 
					@ 
					<?php echo $hospital['district'];?>
					<br />
					<br />
				<span style="padding:5px;margin:5px;font-size:1.5em"><u><b>Accident Register</b></u></span>
				<br />
				<br />
				</div>
				</td>
				</tr>
				<tbody height="10%">
				<tr width="95%">
						<td width="30%" style="padding:5px;">MLC Number: <?php if(!!$registered->mlc_number_manual) echo $registered->mlc_number_manual; else echo $registered->mlc_number; ?></td>
						<td style="padding:5px;">Date, Time:  
							<?php echo date("d-M-Y",strtotime($registered->admit_date)); ?>,
							<?php echo date("g:iA",strtotime($registered->admit_time)); ?>
						</td>
						<td></td>
				</tr>
				<tr width="95%">
						<td style="padding:5px;">Name: <?php echo $registered->name; ?></td>
						<td>Age/ Sex: 	
							<?php 
							if($registered->age_years!=0){ echo $registered->age_years." Years "; } 
							if($registered->age_months!=0){ echo $registered->age_months." Months "; }
							if($registered->age_days!=0){ echo $registered->age_days." Days "; }
							if($registered->age_years==0 && $registered->age_months == 0 && $registered->age_days==0) echo "0 Days ";
							?>/ <?php echo $registered->gender; ?>
						</td>
						<td></td>
				</tr>
				<tr width="95%">
						<td  style="padding:5px;">Caste :</td>
						<td style="padding:5px;">Occupation : <?php echo $registered->occupation; ?></td>
						<td></td>
				</tr>
				<tr width="95%">
					<td colspan="3">Address : <?php echo $registered->address;?> </td>
				</tr>
				<tr>
					<td>
						<br />
						<br />
						<br />
						<br />
					</td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td colspan = "3">
						Signature/ Thumb Impression of the Injured<br ><br >
					</td>
				</tr>
				<tr>
					<td>
						Identification Marks :
					</td>
					<td colspan="2">
						<?php echo $registered->identification_mark_1;?> <br />
						<?php echo $registered->identification_mark_2;?> <br /> <br />
					</td>
				</tr>
				<tr>
					<td>Brought By :</td>
					<td><?php echo $registered->brought_by;?></td>
					<td><br /><br /></td>
				</tr>
				<tr>
					<td>Police Informed or not :</td>
					<td><?php if($registered->police_intimation) { echo "Yes"; } else echo "No"; ?></td>
					<td><br /><br /></td>
				</tr>
				<tr>
					<td>Declaration Required or not :</td>
					<td><?php if($registered->declaration_required) { echo "Yes"; } else echo "No"; ?></td>
					<td><br /><br /></td>
				</tr>
				<tr>
					<td>Name of Injury :</td>
					<td><?php echo $registered->presenting_complaints;?></td>
					<td><br /><br /><br /><br /></td>
				</tr>
				<tr>
					<td colspan="3" align="right">
					<br /><br />
					<br /><br />
					<br /><br />
						Signature of Casualty Medical Officer</td>
				</tr>
						

		</table>