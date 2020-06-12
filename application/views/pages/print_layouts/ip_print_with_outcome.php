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
			font-size:18px;
			font-weight:bold;
			width:100%;
			text-align:center;
			font-family:"Trebuchet MS",serif;
			margin:5px; 
		}
	}
	</style>
<div class='border'>
		<div class="row row1">
			<div class="column">
				<b>PatientID:  <?php echo $registered->patient_id;?></b><br>
				<b>IP No: <?php echo $registered->hosp_file_no;?></b>
			</div>
			<div  class="column">
				<b>Admit Date:</b> <?php echo date("d-M-Y",strtotime($registered->admit_date)); ?><br>
				<b>Admit Time:</b> <?php echo date("g:ia",strtotime($registered->admit_time)); ?>
			</div>
			<div  class="column">
				<b>Name:</b> <?php echo $registered->name; ?><br>
				<b>Gender/Age:</b> 
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
				<b>Department:</b> <?php echo $registered->department; ?><br>
				<?php 
				if($registered->unit_name || $registered->area_name) { ?>
				<b>Unit/Area:</b> <?php echo $registered->unit_name." / ".$registered->area_name; 
				}
				?>
				<?php if($registered->mlc==1) { ?>	
				<?php echo "<b>MLC No:</b>";?><?php 
						if(!!trim($registered->mlc_number_manual)) echo $registered->mlc_number_manual; 
						else echo $registered->mlc_number.'<br>';
						?>
						<?php echo "<b>PS Name:</b>" .$registered->ps_name;?>
						<?php } ?>
			</div>
			<div  class="column">
				<b>Parent/Spouse:</b> <?php echo $registered->parent_spouse; ?><br>
				<b>Phone:</b> <?php echo $registered->phone; ?>
			</div>
			<div   class="column">
				<b>Address:</b> <?php echo $registered->address.",".$registered->place.",".$registered->district; ?>							
			</div>
		</div>
		<div class="row row3">
			<div class="column">
			<b>Outcome:</b>
				<br>
				<label><b>&#10063;Discharge</b></label><br>
				<label><b>&#10063;LAMA</b></label><br>				
				<label><b>&#10063;_______</b></label><br>
				<label><b>Outcome Date:_______</b>  </label>
				<br>
				<label><b>Outcome Time:_______</b></label>							
			</div>			
			<div class="column .column-big">
					<label><b>Final Diagnosis:</b></label>					
					<br><br><br>
					<div style='padding-top: 5px'><label><b>ICD Code:</b>_______</label></div>					
			</div>
		</div>
		<div class="row row4">
			<div class="column">
				<label><b>Nurse Signature:_______</b></label>
			</div>
			<div class="column">
				<label><b>Doctor Signature:_______</b></label>			
			</div>			
			<div class="column pull-right">
				<b>MRD Signature:_______</b>					
			</div>
		</div>	
</div>
<div class='border'>
	<div class="row row5">
		<div class="column">
			PatientID:  <?php echo $registered->patient_id;?><br>
			IP No: <?php echo $registered->hosp_file_no;?>
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