<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>  
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-barcode.min.js"></script>  
<br>
<table style='border-collapse:collapse;padding-top:0px; vertical-align: top;' width='100%'>
<script>
	$(function(){
	$(".barcode_<?php echo $i; ?>").barcode("<?php echo $registered->patient_id;?>",'int25',{barWidth:2, barHeight:30,showHRI:false});
	});
</script>
<?php $count++;
$hospital=$this->session->userdata('hospital'); ?>
<td bgcolor='#fff' style='padding-left:<?php if($count%2==0) echo "26px"; else echo "6px"; ?>;'>
<span style='font-size:18px;font-weight:bold;margin-left:2.5%;font-family: Calibri, sans-serif;'><?= $hospital['hospital'].", ".$hospital['place'];?></span><br/><br/>
		<table style='border-collapse:collapse;table-layout:auto;font-family: Calibri, sans-serif;' width='100%'>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td colspan="2">
          			<span style='font-size:18px;font-weight:bold;'>Person ID: </span>
					<span style='font-size:18px;font-weight:bold;'><?php echo $registered->patient_id;?></span>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td colspan="2">
          			<span style='font-size:18px;font-weight:bold;'>Name: </span> <!--print age and gender also-->
          			<span style='font-size:18px;font-weight:bold'><?php echo ' '.$registered->name.'/ '.$registered->age_years.'/ '.$registered->gender;?></span>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td>
					<span style='font-size:18px;font-weight:bold;'>Related To: </span>
					<span style='font-size:18px;font-weight:bold'><?php echo $registered->parent_spouse;?></span>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td>
					<span style='font-size:18px;font-weight:bold;'>Address: </span>
					<span style='font-size:18px;font-weight:bold;'> <?php echo $registered->address; ?> </span>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td>
					<span style='font-size:18px;font-weight:bold;'>Phone: </span>
					<span style='font-size:18px;font-weight:bold;'> <?php echo ' '.$registered->phone;?> </span>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td>
					<span style='font-size:18px;font-weight:bold;'>Registration Date: </span>
					<span style='font-size:18px;font-weight:bold'><?php if(!empty($registered->admit_date)){ echo ' '.date("d-M-Y",strtotime($registered->admit_date)); }?></span>
				</td>
      		</tr>
		</table><br/>
		<span style="margin-left:35%;">
			<div class="barcode_<?php echo $i;?>"></div>
		</span><br/>
	</td>
</table>
