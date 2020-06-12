<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>  
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-barcode.min.js"></script>  
<br><table style='border-collapse:collapse;padding-top:0px; vertical-align: top;' width='100%'><tr>
<?php
	if($registered->gender=='M')
		$gender = 'Male';
	else if($registered->gender=='F')
		$gender = 'Female';
	else
		$gender = 'Other';
?>
<?php
$count=0;
for($i=1;$i<=2;$i++)
{?>
        <script>
            $(function(){
			$("#barcode_<?php echo $i; ?>").barcode("<?php echo $registered->patient_id;?>",'int25',{barWidth:2, barHeight:30,showHRI:false});
			});
		</script>
<?php $count++;
$hospital=$this->session->userdata('hospital'); ?>
<td bgcolor='#fff' style='padding-left:<?php if($count%2==0) echo "26px"; else echo "6px"; ?>;'>
		<table style='border-collapse:collapse;table-layout:auto;' width='100%'>
			<tr>
				<td><div id="barcode_<?php echo $i;?>"></div></td>
				<td colspan="2">
					<span style='font-size:10px;font-weight:bold;'><?= $hospital['hospital'].", ".$hospital['place'];?></span>
				</td>
			</tr>
			<tr>
				<td></td>
				<td colspan="2">
					<span style='font-size:12px;' colspan="2">Dt. Of Reg: </span><span style='font-size:10px;font-weight:bold;'><?php echo ' '.date("d-M-Y",strtotime($registered->admit_date));?></span>
				</td>
			</tr>
			<tr >
				<td colspan="3">
                     <span style='font-size:12px;'>Patient ID: </span><span style='font-size:10px;font-weight:bold;'> <?php echo $registered->patient_id;  if($registered->patient_id_manual != '') echo $registered->patient_id_manual; ?></span>
				</td>
			</tr>
			<tr >
				<td colspan="3"> 
                     <span style='font-size:12px;'>OP Number: </span><span style='font-size:10px;font-weight:bold;'> <?php echo $registered->hosp_file_no; ?>, &nbsp</span>
					 <span style='font-size:12px;'>Dept: </span><span style='font-size:10px;font-weight:bold;'> <?php echo $registered->department;?></span>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<span style='font-size:10px;'>Patient Name: </span>
					<span style='font-size:10px;font-weight:bold'> <?php echo ' '.$registered->name;?></span>
				</td>
			</tr>
            <tr>
				<td colspan="3">
					<span style='font-size:10px;'>Age/Gender: </span>
					<span style='font-size:10px;font-weight:bold'><?php echo ' '.$registered->age_years;?>y/<?php echo ' '.$gender; ?></span>
				</td>
            </tr>
			<tr>
				<td colspan="3">
					<span style='font-size:10px;'>S/D/W/O: </span><span style='font-size:10px;font-weight:bold'><?php echo $registered->parent_spouse;?></span>
				</td>
			</tr>
			<tr>
				<td>
					
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<span style='font-size:10px;'>Addr: </span>
					<span style='font-size:10px;font-weight:bold;'><?php echo $registered->address; ?></span>
				</td>
			</tr>
            <tr>
				<td colspan="3">
					<span style='font-size:10px;'>Mobile No: </span>
					<span style='font-size:10px;font-weight:bold'><?php echo ' '.$registered->phone;?></span>
				</td>
            </tr>
		</table><br/><br/><br/><br/>
	</td>
<?php
if($count%2==0){echo "</tr><tr>";}
}
echo "</tr></table>";
