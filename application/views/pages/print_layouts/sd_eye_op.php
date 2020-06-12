<link rel="stylesheet" href="<?php echo base_url();?>assets/css/main.css" media="print" >
		<style>
				 #div1 {
					 width:100%;
					 height:70px;
				 }
				 #picture {
					 position:absolute;
					 top:100px;
					 left:540px;
				 }
				 .verticalLine {
                border-right: 1px;
                 }
				
				  </style>
<table style="width:98%;padding:5px" >
        <tr>
	       <td colspan="3">
			<div style="float:middle;text-align:center">
			   <b>Government of TELANGANA</b><br />
				<b>	<font size="4"><?php $hospital=$this->session->userdata('hospital'); echo $hospital['hospital'];?></font> </b>
					<font size="3"><?php // echo $registered->description; ?> </font>
					<font size="2"><?php echo $registered->district; ?><font>
					<br>
					<br>
					<span style="border:1px solid #ccc;padding:5px;margin:5px;"><u><b>OUT PATIENT CARD <?php if(!!$registered->visit_name) echo "- ".$registered->visit_name;?></b></u></span>
                    <br>
                    <br>
			</div>
			</td>
		</tr>
		<tr>
		<td>&nbsp
		</tr>
		<tr>
		<td>&nbsp
		</tr>
		<tr>
			<td><b>OP Registration No:</b><?php echo $registered->hosp_file_no; ?></td>
			<td><b>Date & Time:</b> 
				<?php echo date("d-M-Y",strtotime($registered->admit_date)); ?> &
				<?php echo date("g:iA",strtotime($registered->admit_time)); ?>
			</td>
			<td><div id="picture"><img alt="Patient Photograph"  src="<?php echo base_url();?>assets/images/patients/<?php echo $registered->patient_id.'.jpg'; ?>" width="150px" height="150px" /></div></td>
		</tr>
		<tr>
		<td>&nbsp
		</tr>
		<tr>
			<td ><b>Name:</b> <?php echo $registered->name; ?></td>
			<td><b>Age/Sex:</b> 	
				<?php 
					if($registered->age_years!=0){ echo $registered->age_years." Years "; } 
					if($registered->age_months!=0){ echo $registered->age_months." Months "; }
					if($registered->age_days!=0){ echo $registered->age_days." Days "; }
					if($registered->age_years==0 && $registered->age_months == 0 && $registered->age_days==0) echo "0 Days ";
				?>/<?php echo $registered->gender; ?>
			</td>
		</tr>
		<tr>
		<td>&nbsp
		</tr>
		<tr>
			<td> <b>Address: </b><?php echo $registered->address; ?></td>
			<td><b>Occupation:</b><?php echo $registered->occupation; ?></td>
		</tr>
		<tr>
		<td>&nbsp
		</tr>
		<tr>
			<td> <b>Department:</b> <?php echo $registered->department; ?></td>
			<td><b>Unit/Area:</b><?php 
				if(!!$registered->unit_name);
				if(!!$registered->unit_name) echo ": "; 
				if(!!$registered->unit_name) echo $registered->unit_name;
				?>/<?php echo $registered->area_name; ?>
			</td>	
        </tr>
		<tr>
		<td>&nbsp
		</tr>
			<td colspan="3">
				<div style="float:middle;text-align:center">
				<font size="3"><b><u>Diagnosis</u></b><br/></font>
				</div>
				<br>
				<div>  
				<font size="2" align="left">Complaints & History</font><br><br><br><br>
				<font size="2" align="left">Clinical Findings<font>
				</div>
			</td>
		</tr>
		<tr>
		<td>&nbsp
		</tr>
		<tr>
		<td>&nbsp
		</tr>
		<tr>
		 <tr>
			<table class="table-2" style="width:98%;padding:5px" border="1">
			
		 <tr ><td ><font size="3" align="left"></font></td><td colspan="3">RIGHT EYE</td><td colspan="3">LEFT EYE</td></tr>
			 	<tr ><td ><font size="3" align="left">Visual aculty</font></td><td colspan="3"></td><td colspan="3"></td></tr>
				<tr><td><font size="3" align="left">Lids :</font></td>
				<td colspan="3" ></td><td colspan="3"></td></tr>
				<tr><td ><font size="3" align="left">Conj :</font></td><td colspan="3"></td><td colspan="3"></td></tr>
				<tr><td><font size="3" align="left">Cornea :</font></td><td colspan="3"></td><td colspan="3"></td></tr>
				<tr><td ><font size="3" align="left">Ac :</font></td><td colspan="3"></td><td colspan="3"></td></tr>
				<tr><td><font size="3" align="left">Pupil :</font></td><td colspan="3"></td><td colspan="3"></td></tr>
				<tr><td><font size="3" align="left">Lens : </font></td><td colspan="3"></td><td colspan="3"></td> </tr>
		    </table>
			</tr>
			<div class="vr">
			</div>
		<tr>
		<td>&nbsp
		</tr>
		<tr>		  
			<td colspan="3">
			<div id="div1">
			<font size="3" align="left"><b>Fundus:</b></font>
			</div>
			</td>
		</tr>
		<tr>
			<td>
				<font size="3" align="left"><u><b>Investigation:<b></u></font>
			</td>
		</tr>
	    <tr>
		<td>
		<br><font size="3" align="left">ROOM:Syringing RE/LE</font></br><br>
		<font size="3" align="left">ROOM:FBS/RBS</font></br><br>
		<font size="3" align="left">ROOM:B.P.</font></br><br>
		<font size="3" align="left">ROOM:IOP(ANT) RE/RE</font></br><br>
		</td>
		</tr>
		</table>
		