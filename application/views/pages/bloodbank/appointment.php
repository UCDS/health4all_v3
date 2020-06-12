<style>
	.slots{
		border:1px solid #999;
		border-radius:0.2em;
		padding:5px;
		background:#f6f6f6;
		margin:5px;
		position:relative;
		font-size:12px;
		display:inline-block;
		transition:all 0.3s;
	}
	.slots:hover{
		background:#eee;
		border-radius:0.2em;
		cursor:pointer;
	}
	#container{
		border:1px solid #ccc;
		margin:5px;
		padding:10px;
		position:relative;
		cursor: default;
	}
	.days{
		width:75px;
		padding:5px;
		margin:5px;
		border:1px solid #ccc;
		background:#f6f6f6;
		display:inline-block;
		font-size:12px;
		text-align:center
	}
	.dates{
		position:relative;
		display:inline-block;
		border:1px solid #ccc;
		padding:5px;
		margin:5px;
		width:75px;
		background:#f6f6f6;
		font-size:11px;
		transition:all 0.2s
	}
	.dates:hover{
		background:#eee;
		cursor:pointer;
	}
	.disabled,.disabled:hover{
		opacity:0.4;
		cursor:default;
	}
	.green{
		color:green;
	}
	.orange{
		color:#D47D04;
	}
</style>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<script type="text/javascript"
 src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript">
$(function(){
	$("#date").Zebra_DatePicker({
		direction:1,
	});
});
function get_slots(slot_id){
	$.ajax({
				type : "POST",
				data : {slot_id:slot_id},
				url : "<?php echo base_url();?>appointment/show_slots",
				success:function(data){
					$("#container").show();
					 $("#container").children().remove();
					 $("#container").append(data);
					 history.pushState({}, '', "appointment/slots");
				}
		});
}
</script>
<div class="col-md-10 col-sm-9">
	<h4>Book an appointment to donate blood</h4>
	<p>You can book an appointment to donate blood at Indian Red Cross Blood Bank, Vidyanagar.
	Although you can walk in directly to the blood bank and donate,
	 we encourage you to book an appointment before you come. 
	</p>
	<br />
	<div id="container" style='width:800px;'>
	<?php
	$days=array(
	"slot_id"=>array(),
	"date"=>array(),
	"no_appointments"=>array(),
	"no_bookings"=>array()
	);
	foreach($slot_dates as $day){
	$days['slot_id'][]=$day['slot_id'];
	$days['date'][]=$day['date'];
	$days['no_appointments'][]=$day['no_appointments'];
	$days['no_bookings'][]=$day['no_bookings'];
	
	}
	$date=date("Y-m-d");
	$limit=date("Y-m-d",strtotime("+30 days"));
	
	$day_of_week=date("w");
	for($i=0;$i<7;$i++){
	?>
	<div class="days">
		<p><?php echo date("D",strtotime("last sunday + $i days"));?></p>
	</div>
	<?php 
	}
	for($i=0;$i<$day_of_week;$i++){
	?>
	<div class="dates  disabled">
	
	<?php echo date("jS M",strtotime("last sunday +$i days")); ?>
	
	<p>Past Dates</p>
	</div>
	<?php
	}
	while($date<$limit){
	if(!in_array(date("D, jS M",strtotime($date)),$days['date'])) {
		$date_classes="disabled";
		$index="";
		$no_appointments="";
		$no_bookings="";
		$pclass="";
		$date_id="";
		$on_click="";
	}
	else{
		$date_classes="";
		$index=array_search(date("D, jS M",strtotime($date)),$days['date']);
		$no_appointments=$days['no_appointments'][$index];
		$no_bookings=$days['no_bookings'][$index];
		$date_id=$days['date'][$index];
		$on_click="onclick=\"get_slots(".$days['slot_id'][$index].")\"";
		if($days['no_appointments'][$index]==$days['no_bookings'][$index]){
			$pclass="disabled";
		}
		else if(($days['no_bookings'][$index]/$days['no_appointments'][$index])*100>80){
			$pclass="orange";
		}
		else{
			$pclass="green";
		}
	}

	?>
	<div class="dates <?php echo $date_classes; ?>" <?php echo $on_click;?>>
	
	<?php echo date("jS M",strtotime($date)); 
	if($pclass==""){
	?>
	<p>Holiday</p>
	<?php } else { ?>
	<p class="<?php echo $pclass;?>">Available: <?php echo $no_appointments - $no_bookings;?></p>
	<?php } ?>
	</div>
	<?php
	$date=date ("Y-m-d", strtotime("+1 day", strtotime($date)));
	}
	?>
	</div>
</div>
