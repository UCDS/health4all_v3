<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<script type="text/javascript"
 src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script>
	$(function(){
		$("#from_date,#to_date").Zebra_DatePicker();
	});
</script>

<div class="col-md-10 col-sm-9">

	<div>
		<?php echo form_open('bloodbank/user_panel/discard_report', array('role'=>'form','class'=>'form-custom')); ?>
		<div>
			<input type="text" placeholder="From date" class="form-control" size="10" name="from_date" id="from_date" />
			<input type="text" placeholder="To date" class="form-control" size="10" name="to_date" id="to_date" />
			<input type="submit" name="submit" class='btn btn-primary btn-md' value="Search" />
		</div>
		</form>
			<?php
	$search="";
	$expired="";
	$expiring="";
	$under_collection="";
	$screening_failed="";
	if(isset($msg)) {
		echo $msg;
		echo "<br />";
		echo "<br />";
	}
	?>
		<?php if(count($inventory)>0){ ?>
		<b>
		<?php
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date('d-M-Y',strtotime($this->input->post('from_date')));
			$to_date=date('d-M-Y',strtotime($this->input->post('to_date')));
			echo "Discard report from ".$from_date." to ".$to_date;
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
		 $this->input->post('from_date')==""?$date=$this->input->post('to_date'):$date=$this->input->post('from_date');
		 echo "Blood grouped on $date";
		}
		
		?>
		</b>
         
		<table id="header-fixed" class="table-2 table table-striped table-bordered"></table>
		<table class="table-2 table table-striped table-bordered" id="table-1">
		<thead><th>Blood Unit number</th><th>Component Type</th><th>Blood Group</th><th>Expiry Date</th><th>Reason</th></thead>
		<?php 
		foreach($inventory as $inv){
                        if($inv->expiry_date<date('Y-m-d')&&$inv->notes=="") 
                             $notes= "Expired"; 
                        else 
                             $notes= $inv->notes;
			if($this->input->post('from_date') && $this->input->post('to_date')){
				$search.="<tr>";
				$search.=form_open('bloodbank/inventory/discard');
				$search.="<input type='text' value='$inv->inventory_id' readonly name='inventory_id' size='3' hidden />
					<td>$inv->blood_unit_num</td>		
					<td>$inv->component_type</td>
					<td>$inv->blood_group</td>		
					<td>".date('d-M-Y',strtotime($inv->expiry_date))."</td>";
				
				$search.="<td><input type='text' name='notes' value=".$notes." readonly required /></td>
				
				</form>
				</tr>";
			}
			else{
		
			 if($inv->donation_status==6 && $inv->screening_result==0){
				$screening_failed.="<tr>";
				$screening_failed.=form_open('bloodbank/inventory/discard');
				$screening_failed.="<input type='text' value='$inv->inventory_id' readonly name='inventory_id' size='3' hidden />
					<td>$inv->blood_unit_num</td>		
					<td>$inv->component_type</td>
					<td>$inv->blood_group</td>		
					<td>".date('d-M-Y',strtotime($inv->expiry_date))."</td>";
			
				$screening_failed.="<td><input  readonly type='text' value='Screening failed.' name='notes' required /></td>
					
				</form>
				</tr>";
			}
			else if($inv->expiry_date>date('Y-m-d',strtotime("+7 Days"))){
				continue;
			}
			else if($inv->expiry_date>=date('Y-m-d')){
				$expiring.="<tr>";
				$expiring.=form_open('bloodbank/inventory/discard');
				$expiring.="<input type='text' value='$inv->inventory_id' readonly name='inventory_id' size='3' hidden />
					<td>$inv->blood_unit_num</td>		
					<td>$inv->component_type</td>
					<td>$inv->blood_group</td>		
					<td>".date('d-M-Y',strtotime($inv->expiry_date))."</td>";
			
				$expiring.="<td></td>
					
				</form>
				</tr>";			
			}
			else if($inv->expiry_date<date('Y-m-d')){
				$expired.="<tr>";
				$expired.=form_open('bloodbank/inventory/discard');
				$expired.="<input type='text' value='$inv->inventory_id readonly name='inventory_id' size='3' hidden />
					<td>$inv->blood_unit_num</td>		
					<td>$inv->component_type</td>
					<td>$inv->blood_group</td>		
					<td>".date('d-M-Y',strtotime($inv->expiry_date))."</td>";
				
				$expired.="<td><input value='Expired' name='notes' readonly required /></td>
					
				</form>
				</tr>";
			}
			}
		}?>
		<?php
		
			if($expired!=""){
			?>
			
			<tr><th colspan="10" style="background-color:#333;color:white;"><font size="3">Expired Blood</font></th></tr>
			<?php
				echo $expired;
			}
			if($under_collection!=""){
			?>
			
			<tr><th colspan="10" style="background-color:#333;color:white;"><font size="3">Under Collection</font></th></tr>
			<?php
				echo $under_collection;
			}
			if($screening_failed!=""){
			?>
			
			<tr><th colspan="10" style="background-color:#333;color:white;"><font size="3">Screening failed</font></th></tr>
			<?php
				echo $screening_failed;
			}
			if($search!=""){
			?>
			
			<tr><th colspan="10" style="background-color:#333;color:white;"><font size="3">Searched for..</font></th></tr>
			<?php
				echo $search;
				
			}
		
		?>
		</table>
		<?php }
		else{
			 ?>
			 <p>No Discard records are specified period.</p>
		<?php } ?>
	</div>
</div>

