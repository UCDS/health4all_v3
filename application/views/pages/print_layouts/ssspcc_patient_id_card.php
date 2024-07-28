<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>  
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-barcode.min.js"></script>  
<script>
  $(function(){
    $("#barcode")
      .barcode("<?php echo $registered->patient_id;?>",'code128',{barWidth:2, barHeight:20,showHRI:false});
  });
</script>
<style>

  .padding-left{
	padding-left: 5mm;	
  }
</style>
<table style='border-collapse:collapse;padding-top:-5px; vertical-align: top;' width='100%'><tr>
<?php
	if($registered->gender=='M')
		 $gender = 'Male';
	else if($registered->gender=='F')
		 $gender = 'Female';
	else
		 $gender = 'Other';
	
	$relative = '';
	if($registered->parent_spouse != '')
		$relative = $registered->parent_spouse;
    else if($registered->mother_name != '')
		$relative = $registered->mother_name;

?>

<td bgcolor='#fff' style='padding-left:"3px";text-align: center; vertical-align: middle;' >
	<b>Sri Sathya Sai Palliative Care Centre</b><br>1-235, Sai Nagar, Puttaparthi-515134<br><b>శ్రీ సత్యసాయి పాలియేటివ్ కేర్ సెంటర్</b><br>1-235, సాయి నగర్, పుట్టపర్తి-515134<br><b>Website:</b> https://ssspcc.in/ <br> <b>Mob:</b> 9391190375 <b>Ph:</b> 080-4710-3700
</td>

<td bgcolor='#fff' style='padding-left:"26px";'>
		<div style="width: 3.721in;">
		<div>  	
			<div id='barcode' style='display:inline-block;'></div>
			<div style='display:inline-block;'><b><?php echo $registered->hospital_short_name; ?> </b></div>
		</div>
		<div class='padding-left'> 
			<div><b>ID: </b> <?php echo $registered->patient_id; ?> </div>
			<div><b>Name: </b> <?php echo $registered->name; ?> </div> 	
			<div><b>Age/Gender: </b> <?php echo $registered->age_years.'Y/'.$gender; ?> </div>
			<div><b>S/D/W/O: </b> <?php echo $relative; ?> </div>
			<div style='word-break: break-all;'><b>Address: </b> <?php echo $registered->address; ?> </div>	
			<div><b>Phone: </b> <?php echo $registered->phone; ?> </div>
			<div><b>Reg date: </b> <?php echo date('d-M-Y',strtotime($registered->patient_reg_date_time)); ?> &emsp; <b>Print date: </b><?php echo date('d-M-Y'); ?></div>			
		</div>
		</div>
</td>
</tr></table>
