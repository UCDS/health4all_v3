<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>  
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-barcode.min.js"></script> 
<style>

  .padding-left{
	padding-left: 5mm;	
  }
</style>

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
<table style='border-collapse:collapse;padding-top:-5px; vertical-align: top;' width='100%'><tr> 

<?php
$count=0;
for($i=1;$i<=2;$i++)
{?>
        <script>
            $(function(){
			$("#barcode_<?php echo $i; ?>").barcode("<?php echo $registered->patient_id;?>",'int25',{barWidth:2, barHeight:30,showHRI:false});
			});
		</script>
<?php $count++; ?>


<td bgcolor='#fff' style='padding-left:<?php if($count%2==0) echo "18px"; else echo "1px"; ?>;' >
	<div style="width: 3.721in;">
		<div>  	
			<div id='barcode_<?php echo $i; ?>' style='display:inline-block;'></div>
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
<?php } ?>
</tr></table>
