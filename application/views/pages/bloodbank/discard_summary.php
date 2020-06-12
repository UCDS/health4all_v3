
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<style>
.table-2 a{                   /*table design*/          
	color:black;
	text-decoration:none;
}
.table-2 td,th{
		width:50px;
		text-align:center;
	}
</style>
<script type="text/javascript"
 src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script>
	$(function(){
		$(".date").Zebra_DatePicker({
			direction:false
		});
	});
</script>


<div class="col-md-10 col-sm-9">  

	<div>                                                     
		<?php echo form_open('bloodbank/user_panel/discard_summary'); ?> 
            <div>
		<input type="text" class="date" size="12" id="from_date" name="from_date" />
		<input type="text" class="date" size="12" name="to_date" />
		<input type="submit" name="submit" value="Search" />
	</div>
	<br />
	<?php
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date('d-M-Y',strtotime($this->input->post('from_date')));
			$to_date=date('d-M-Y',strtotime($this->input->post('to_date')));
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
		 $this->input->post('from_date')==""?$from_date=date("d-M-Y",strtotime($this->input->post('to_date'))):$from_date=date("d-M-Y",strtotime($this->input->post('from_date')));
		 $to_date=$from_date;
		}
		else if(!!$from_date && !!$to_date){
			$from_date=date('d-M-Y',strtotime($from_date));
			$to_date=date('d-M-Y',strtotime($to_date));
		}
		else if(!!$from_date || !!$to_date){
		 $from_date=="0"?$from_date=$to_date:$to_date=$from_date;
		}
		else{
			$from_date=date('d-M-Y',strtotime('-30 Days'));
			$to_date=date('d-M-Y');
		 }
		
?>
                  <h2> Summary of Discarded Blood </h2>   
		
	<br />
	
            
                
                
                
	<?php echo form_open('bloodbank/user_panel/discard_summary'); ?>   
	<table class="table-2 table table-striped table-bordered" style="position:relative;float:left">
	<tr><th colspan="4">Whole Blood & Packed Cells</th></tr>
        <tr><th>Blood Group</th><th>Whole Blood</th><th><div data-toggle="popover" data-content="Packed Cells" >PC</div></th><th>Total</th></tr>
        <?php 
	$blood_groups=array("A+","B+","AB+","O+","A-","B-","AB-","O-");
	$available_groups=array();
	$total=0;
	$group_total=0;
	$wb_total=0;
	$pc_total=0;
	foreach($discard as $s){
	$blood_group=str_replace("+","pos",$s->blood_group);
	$blood_group=str_replace("-","neg",$blood_group);
	?>
	<tr>
		<td><?php echo $s->blood_group;?></td>
		<td><?php echo $s->wb;?></td> 
		<td><?php echo $s->pc;?></td>
		<th><?php $group_total=$s->wb+$s->pc;
			echo $group_total;
			?>
		</th>
	</tr>
        <?php
	$available_groups[]=$s->blood_group;
	$total+=$group_total;
	$wb_total+=$s->wb;
	$pc_total+=$s->pc;
	}
	$remaining=array_diff($blood_groups,$available_groups);
	foreach($remaining as $r){
	?>
	<tr>
		<td><?php echo $r;?></td>
		<td>0</td>
		<td>0</td>
		<th>0</th>
	</tr>
	<?php 
	}
	?>
	<th>Total</th>
	<th><?php echo $wb_total;?></th>
	<th><?php echo $pc_total;?></th>
	<th><?php echo $total;?></th>
	</table>
	<br />
        
        
        
        
        
        
        
        
        <br>
	<table class="table-2 table table-striped table-bordered" style="position:relative;float:left">
	<tr><th colspan="10">Components</th></tr>
        <tr><th>Blood Group</th><th><div data-toggle="popover" data-content="Platelet Rich Plasma" >PRP</div></th><th>Platelet Concentrate</th><th><div data-toggle="popover" data-content="Fresh Frozen Plasma" > FFP</div></th><th><div data-toggle="popover" data-content="Frozen Plasma" >FP</div></th><th>Cryo</th><th>Total</th></tr>
        <?php 
	$blood_groups=array("A+","B+","AB+","O+","A-","B-","AB-","O-");
	$available_groups=array();
	$total=0;
	$group_total=0;
	$prp_total=0;
	$platelet_concentrate_total=0;
	$ffp_total=0;
	$fp_total=0;
	$cryo_total=0;
	foreach($discard as $s){
	$blood_group=str_replace("+","pos",$s->blood_group);
	$blood_group=str_replace("-","neg",$blood_group);
	?>
	<tr>
		<td><?php echo $s->blood_group;?></td>
		<td><?php echo $s->prp;?></td>
		<td><?php echo $s->platelet_concentrate;?></td>
		<td><?php echo $s->ffp;?></td>
		<td><?php echo $s->fp;?></td>
		<td><?php echo $s->cryo;?></td>
		<th><?php $group_total=$s->prp+$s->platelet_concentrate+$s->ffp+$s->fp+$s->cryo;
			echo $group_total;
			?>
		</th>
	</tr>
        <?php
	$available_groups[]=$s->blood_group;
	$total+=$group_total;
	$prp_total+=$s->prp;
	$platelet_concentrate_total+=$s->platelet_concentrate;
	$ffp_total+=$s->ffp;
	$fp_total+=$s->fp;
	$cryo_total+=$s->cryo;
	}
	$remaining=array_diff($blood_groups,$available_groups);
	foreach($remaining as $r){
	?>
	<tr>
		<td><?php echo $r;?></td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<th>0</th>
	</tr>
	<?php 
	}
	?>
	<th>Total</th>
	<th><?php echo $prp_total;?></th>
	<th><?php echo $platelet_concentrate_total;?></th>
	<th><?php echo $ffp_total;?></th>
	<th><?php echo $fp_total;?></th>
	<th><?php echo $cryo_total;?></th>
	<th><?php echo $total;?></th>
	</table>
     </div>
