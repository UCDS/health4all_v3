<?php
		echo "<b>Available Slots for ".date("D, jS M,Y",strtotime($slots[0]->date))."</b>
		<a href='".base_url()."appointment' style='float:right'><--Select a different date</a><br />";
		foreach ($slots as $row){
			if($row->available==0){
				$pclass="full";
			}
			else if(($row->available/$row->no_appointments)*100<=20){
				$pclass="orange";
			}
			else{
				$pclass="green";
			}
			echo "<div class='slots' id='slot$row->slot_id'>$row->from_time to $row->to_time 
			<p class='$pclass'>Available : $row->available</p></div>
			";
		}
		echo "<script>
		$(function(){
			$('.slots').click(function(){
			var id=this.id
			window.location.href='".base_url()."appointment/register/'+id;
			});
		});
		</script>";
?>
