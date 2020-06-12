<!-- This layout is designed to print the details for three times apart from all other forms. This form also includes MLC Reasons 	-->
<style>
	@media print{
		.column{
			position:relative;float:left;width:33%;margin:5px 0px;
		}
		.row{
			margin-top:auto;
			font-size:16px;
			font-family:"Trebuchet MS",serif;
			height:13%;
			padding:1px;
			margin-bottom:0.0px;
		}
		.column-big{
			width:67%;
		}
		.column-mid{
			width: 40%;
		} 
		.border{
			border:1px solid #ccc;
			border-radius:0.3em;
		}
		.row1{
			height:4%;
		}
		.row2{
			height: 8%;
		}
		.row3{
			height: 12%;
		}
		.row4{
			height: 3%;
		}
		.row5{
			height: 4%;
		}
		.row6{
			height: 10%;
		}
		.heading{
			font-size:14px;
			font-weight:bold;
			width:100%;
			text-align:center;
			font-family:"Trebuchet MS",serif;
			margin:1px; 
		}
	}
	</style>
<div class='border'>
		<div class="row row1">
			<div class="column">
				<b>PatientID:<?php echo $registered->patient_id;?></b><br>
				<b>IP No:<?php echo $registered->hosp_file_no;?></b>
			</div>
			<div  class="column">
				Admit Date:<?php echo date("d-M-Y",strtotime($registered->admit_date)); ?><br>
				Admit Time:<?php echo date("g:ia",strtotime($registered->admit_time)); ?>
			</div>
			<div  class="column">
				Name:<?php echo $registered->name; ?><br>
				Gender/Age:
				<?php echo $registered->gender."/";
				if($registered->age_years!=0) echo $registered->age_years."Y "; 
				if($registered->age_months!=0) echo $registered->age_months."M "; 
				if($registered->age_days!=0) echo $registered->age_days."D "; 
				if($registered->age_years==0 && $registered->age_months == 0 && $registered->age_days==0) echo "0 Days";
				?>
			</div>
		</div>	
		<div class="row row2">
			<div class="column">
				Department: <?php echo $registered->department; ?><br>
				<?php 
				if($registered->unit_name || $registered->area_name) { ?>
				Unit/Area: <?php echo $registered->unit_name." / ".$registered->area_name; 
				}
				?>
				<?php if($registered->mlc==1) { ?>	
				<?php echo "MLC No:";?><?php 
						if(!!trim($registered->mlc_number_manual)) echo $registered->mlc_number_manual; 
						else echo $registered->mlc_number.'<br>';
						?>
						<?php echo "PS Name:" .$registered->ps_name;?>
						<?php } ?>
			</div>
			<div  class="column">
				Parent/Spouse:<?php echo $registered->parent_spouse; ?><br>
				Phone:<?php echo $registered->phone; ?>
			</div>
			<div   class="column">
				Address:<?php echo $registered->address.",".$registered->place.",".$registered->district; ?>							
			</div>
		</div>
		<div class="row row3">
			<div class="column">
			Outcome:
				<br>
				<label>&#10063;Discharge</label><br>
				<label>&#10063;LAMA</label><br>				
				<label>&#10063;_______</label><br>
				<label>Outcome Date:_______</label>
				<br>
				<label>Outcome Time:_______</label>							
			</div>			
			<div class="column .column-big">
					<label>Final Diagnosis:</label>					
					<br><br><br>
					<div style='padding-top: 5px'><label>ICD Code:_______</label></div>					
			</div>
		</div>
		<div class="row row4">
			<div class="column">
				<label>Nurse Signature:_______</label>
			</div>
			<div class="column">
				<label>Doctor Signature:_______</label>			
			</div>			
			<div class="column pull-right">
				MRD Signature:_______					
			</div>
		</div>	
</div>
<div class='border'>
	<div class="row row5">
		<div class="column">
			<b>PatientID:  <?php echo $registered->patient_id;?></b><br>
			<b>IP No: <?php echo $registered->hosp_file_no;?></b>
		</div>
		<div  class="column">
			Admit Date: <?php echo date("d-M-Y",strtotime($registered->admit_date)); ?><br>
			Admit Time: <?php echo date("g:ia",strtotime($registered->admit_time)); ?>
		</div>
		<div  class="column">
			Name: <?php echo $registered->name; ?><br>
			Gender/Age: 
			<?php echo $registered->gender."/";
			if($registered->age_years!=0) echo $registered->age_years."Y "; 
			if($registered->age_months!=0) echo $registered->age_months."M "; 
			if($registered->age_days!=0) echo $registered->age_days."D "; 
			if($registered->age_years==0 && $registered->age_months == 0 && $registered->age_days==0) echo "0 Days";
			?>
		</div>
	</div>	
	<div class="row row6">
		<div class="column">
			Department: <?php echo $registered->department; ?><br>
			<?php 
			if($registered->unit_name || $registered->area_name) { ?>
			Unit/Area: <?php echo $registered->unit_name." / ".$registered->area_name; 
			}
			?>
			<?php if($registered->mlc==1) { ?>	
			<?php echo "MLC No:";?><?php 
					if(!!trim($registered->mlc_number_manual)) echo $registered->mlc_number_manual; 
					else echo $registered->mlc_number;
					?><br>
					<?php echo "PS Name:" .$registered->ps_name;?>
					<?php } ?>
			Outcome:
			<br>
		</div>
		<div  class="column">
			Parent/Spouse: <?php echo $registered->parent_spouse; ?><br>
			Phone: <?php echo $registered->phone; ?>
		</div>
		<div class="column">
			Address: <?php echo $registered->address.",".$registered->place.",".$registered->district; ?>							
		</div>
	</div>
</div>

<div class='border'>
	<div class="row row4">
		<div class='column heading'>
			<p align='center'>Attendant Pass</p>
		</div>
	</div>
	<div class="row row5">
		<div class="column">
			<b>PatientID:  <?php echo $registered->patient_id;?><br></b>
			<b>IP No: <?php echo $registered->hosp_file_no;?></b>
		</div>
		<div  class="column">
			Admit Date: <?php echo date("d-M-Y",strtotime($registered->admit_date)); ?><br>
			Admit Time: <?php echo date("g:ia",strtotime($registered->admit_time)); ?>
		</div>
		<div  class="column">
			Name: <?php echo $registered->name; ?><br>
			Gender/Age: 
			<?php echo $registered->gender."/";
			if($registered->age_years!=0) echo $registered->age_years."Y "; 
			if($registered->age_months!=0) echo $registered->age_months."M "; 
			if($registered->age_days!=0) echo $registered->age_days."D "; 
			if($registered->age_years==0 && $registered->age_months == 0 && $registered->age_days==0) echo "0 Days";
			?>
		</div>
	</div>	
	<div class="row row6">
		<div class="column">
			Department: <?php echo $registered->department; ?><br>
			<?php 
			if($registered->unit_name || $registered->area_name) { ?>
			Unit/Area: <?php echo $registered->unit_name." / ".$registered->area_name; 
			}
			?>
			<?php if($registered->mlc==1) { ?>	
			<?php echo "MLC No:";?><?php 
					if(!!trim($registered->mlc_number_manual)) echo $registered->mlc_number_manual; 
					else echo $registered->mlc_number;
					?><br>
					<?php echo "PS Name:" .$registered->ps_name;?>
					<?php } ?>
			Outcome:
			<br>
		</div>
		<div  class="column">
			Parent/Spouse: <?php echo $registered->parent_spouse; ?><br>
			Phone: <?php echo $registered->phone; ?>
		</div>
		<div class="column">
			Address: <?php echo $registered->address.",".$registered->place.",".$registered->district; ?>							
		</div>
	</div> 
</div>