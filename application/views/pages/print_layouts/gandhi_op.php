		<div style="position:absolute;top:0%;left:47%">
			<?php echo $registered->hosp_file_no; ?>
		</div>
		<div style="position:absolute;top:0.1%;left:81%">
			<?php echo date("d-M-Y",strtotime($registered->admit_date)); ?>
		</div>
		<div style="position:absolute;top:2.35%;left:36.08%">
			<?php echo $registered->name; ?>
		</div>
		<div style="position:absolute;top:2.65%;left:82%">
			<?php echo date("g:ia",strtotime($registered->admit_time)); ?>
		</div>
		<div style="position:absolute;top:4.9%;left:34%">
			<?php if($registered->age_years!=0) echo $registered->age_years."y "; ?>
			<?php if($registered->age_months!=0) echo $registered->age_months."m "; ?>
			<?php if($registered->age_days!=0) echo $registered->age_days."d "; ?>
		</div>
		<div style="position:absolute;top:4.9%;left:58.4%">
			<?php echo $registered->gender; ?>
		</div>
		<div  style="position:absolute;top:4.9%;left:84.7%;">
			<?php echo $registered->department; ?><br />
			<?php echo $registered->op_room_no; ?>
			
		</div>
		<div style="position:absolute;top:11.1%;left:49.4%">
			<?php echo $registered->presenting_complaints; ?>
		</div>
