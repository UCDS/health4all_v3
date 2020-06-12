<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<script type="text/javascript"
 src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script>
	$(function(){
		var anti_a,anti_b,anti_ab,anti_d,a_cells,b_cells,o_cells,du;
		$("#grouping_date").Zebra_DatePicker({
			direction:false
		});
		$(".blood_group").on('change',function(){
			var donation_id=$(this).attr('id').substring(12);
			switch($(this).val()){
				case 'A+':
					anti_a='+';
					anti_b='-';
					anti_ab='+';
					anti_d='+';
					a_cells='-';
					b_cells='+';
					o_cells='-';
					du='+';
					$('#sub_group_'+donation_id).removeClass ('sr-only');
					break;
				case 'A-':
					anti_a='+';
					anti_b='-';
					anti_ab='+';
					anti_d='-';
					a_cells='-';
					b_cells='+';
					o_cells='-';
					$('#sub_group_'+donation_id).removeClass('sr-only');
					du='-';
					break;
				case 'B+':
					anti_a='-';
					anti_b='+';
					anti_ab='+';
					anti_d='+';
					a_cells='+';
					b_cells='-';
					o_cells='-';
					du='+';
					$('#sub_group_'+donation_id).addClass('sr-only');
					break;
				case 'B-':
					anti_a='-';
					anti_b='+';
					anti_ab='+';
					anti_d='-';
					a_cells='+';
					b_cells='-';
					o_cells='-';
					du='-';
					$('#sub_group_'+donation_id).addClass('sr-only');
					break;
				case 'AB+':
					anti_a='+';
					anti_b='+';
					anti_ab='+';
					anti_d='+';
					a_cells='-';
					b_cells='-';
					o_cells='-';
					$('#sub_group_'+donation_id).removeClass ('sr-only');
					du='+';
					break;
				case 'AB-':
					anti_a='+';
					anti_b='+';
					anti_ab='+';
					anti_d='-';
					a_cells='-';
					b_cells='-';
					o_cells='-';
					du='-';
					$('#sub_group_'+donation_id).removeClass ('sr-only');
					break;
				case 'O+':
					anti_a='-';
					anti_b='-';
					anti_ab='-';
					anti_d='+';
					a_cells='+';
					b_cells='+';
					o_cells='-';
					du='+';
					$('#sub_group_'+donation_id).removeClass ('sr-only');
					break;
				case 'O-':
					anti_a='-';
					anti_b='-';
					anti_ab='-';
					anti_d='-';
					a_cells='+';
					b_cells='+';
					o_cells='-';
					du='-';
					$('#sub_group_'+donation_id).removeClass ('sr-only');
					break;
				default:
					alert('error');
					break;
			}
		set_defaults(donation_id);	
		});
		function set_defaults(donation_id){
			$('#anti_a_'+donation_id).val(anti_a);
			$('#anti_b_'+donation_id).val(anti_b);
			$('#anti_ab_'+donation_id).val(anti_ab);
			$('#anti_d_'+donation_id).val(anti_d);
			$('#a_cells_'+donation_id).val(a_cells);
			$('#b_cells_'+donation_id).val(b_cells);
			$('#o_cells_'+donation_id).val(o_cells);
			$('#du_'+donation_id).val(du);
		}
		
	});
</script>
<div class="col-md-10 col-sm-9">
	<?php
	if(isset($msg)) {
		echo "<div class='alert alert-info'>$msg</div>";
		echo "<br />";
	}
	
	if($this->input->post('year')) $year = $this->input->post('year'); 
	else $year = date("Y");
	?>
	<div>
	
		<?php echo form_open('bloodbank/inventory/blood_grouping');?>
		<div class="form-group col-lg-2">
			<input type="text" id="from_id" value="<?php echo $this->input->post('from_id');?>" placeholder="From Number" class="form-control" name="from_id" />
		</div>
		<div class="form-group col-lg-2">
			<input type="text" id="to_id" value="<?php echo $this->input->post('to_id');?>" placeholder="To Number" class="form-control" name="to_id" />
		</div>
		<div class="form-group col-lg-2">
			<input type="text" id="year" value="<?php echo $year;?>" placeholder="Year" class="form-control" name="year" />
		</div>
		<div class="form-group"><input type="submit" class="btn btn-primary" value="Filter" name="filter" /></div>
		</form>
		<hr>
		<?php if(count($ungrouped_blood)==0){
			echo "<div class='alert alert-info'>No samples available for grouping.</div>";
		}
		else{
		?>
                <div class="alert alert-danger" role="alert">
                        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                        <span class="">Note:</span>
                        <ul>
                            <li>Blood Unit is the Blood bag number</li>
                            <li>Blood Group selected here is final, Blood Group group set here will override group set in previous stages.</li>
                            <li>Staff name shows up in Forward/Reverse done by only if the staff name is added to the database to add staff <a href="<?php echo base_url()."staff/add/staff";?>">click here.</a>
                                <ul><li>When adding staff make sure you select his/her department as Blood Bank, you get the department after selecting hospital</li></ul>
                                <ul><li>Only fields with a '*' are mandatory</li></ul>
                            </li>

                        </ul>
                    </div>
		<div class="panel panel-default">
                    
		<div class="panel-heading">
			<h4>Available samples </h4>
		</div>
		<div class="panel-body">
		<table id="header-fixed" class="table-2 table table-striped table-bordered"></table>
		<table class="table-2 table table-striped table-bordered" id="table-1">
		<thead>
			<th>S.No</th>
			<th>Blood Unit No.</th>
			<th>Blood Group</th>
			<th>Anti A</th>
			<th>Anti B</th>
			<th>Anti AB</th>
			<th>Anti D</th>
			<th>A Cells</th>
			<th>B Cells</th>
			<th>O Cells</th>
			<th>Du</th>
			<th>Grouped</th>
		</thead>
		<?php echo form_open('bloodbank/inventory/blood_grouping',array('id'=>'grouping_form','class'=>'form-custom'));?>
		<?php 
		$i=1;
		foreach($ungrouped_blood as $blood){
		?>
		<tr>
			<td><?php echo $i++;?></td>
			<td>
				<?php echo $blood->blood_unit_num;?>
			</td>
		<td style="min-width:120px">
			<select name="blood_group_<?php echo $blood->donation_id;?>" id="blood_group_<?php echo $blood->donation_id;?>"  class="blood_group form-control">
			<option value="" selected disabled>-------</option>
			<option value="A+">A+</option>
			<option value="B+">B+</option>
			<option value="O+">O+</option>
			<option value="AB+">AB+</option>
			<option value="A-">A-</option>
			<option value="B-">B-</option>
			<option value="O-">O-</option>
			<option value="AB-">AB-</option>
			</select>
			<select name="sub_group_<?php echo $blood->donation_id;?>" style="min-width:150px" class="form-control sr-only" id="sub_group_<?php echo $blood->donation_id;?>">
			<option value="" selected >Sub Group</option>
			<option value="A1" >A1</option>
			<option value="A2" >A2</option>
			<option value="A1B">A1B</option>
			<option value="A2B">A2B</option>
			<option value="Oh" >Oh</option>
			</select>
		</td>
			<td>
			<div class="form-group"><input type='text' name='anti_a_<?php echo $blood->donation_id;?>' class="form-control" id='anti_a_<?php echo $blood->donation_id;?>' /></div>
			</td>
			<td><div class="form-group"><input type='text' class="form-control" name='anti_b_<?php echo $blood->donation_id;?>' id='anti_b_<?php echo $blood->donation_id;?>' /></div></td>
			<td><div class="form-group"><input type='text' class="form-control" name='anti_ab_<?php echo $blood->donation_id;?>' id='anti_ab_<?php echo $blood->donation_id;?>' /></div></td>
			<td><div class="form-group"><input type='text' class="form-control" name='anti_d_<?php echo $blood->donation_id;?>' id='anti_d_<?php echo $blood->donation_id;?>' /></div></td>
			<td><div class="form-group"><input type='text' class="form-control" name='a_cells_<?php echo $blood->donation_id;?>' id='a_cells_<?php echo $blood->donation_id;?>' /></div></td>
			<td><div class="form-group"><input type='text' class="form-control" name='b_cells_<?php echo $blood->donation_id;?>' id='b_cells_<?php echo $blood->donation_id;?>' /></div></td>
			<td><div class="form-group"><input type='text' class="form-control" name='o_cells_<?php echo $blood->donation_id;?>' id='o_cells_<?php echo $blood->donation_id;?>' /></div></td>
			<td><div class="form-group"><input type='text' class="form-control" name='du_<?php echo $blood->donation_id;?>' id='du_<?php echo $blood->donation_id;?>' /></div></td>
			<td>
			<div class="form-group"><input type='hidden' value='<?php echo $blood->donor_id;?>' name='donor_id_<?php echo $blood->donation_id;?>' size='2' />
			<input type="checkbox" value="<?php echo $blood->donation_id;?>" name="donation_id[]"  /></td>
		</tr>
		<?php 
		}
		?>
		<tr>
		
		<td colspan="20" width="18%" >	
			<div class="form-group col-lg-3"><select class="form-control" name="forward_by" required>
				<option value="" disabled selected>Forward Done By</option>
				<?php foreach($staff as $s){
					echo '<option value='.$s->staff_id.'>'.$s->first_name." ".$s->last_name." ".$s->name.'</option>';
				}
				?>
			</select></div>
		
			<div class="form-group col-lg-3"><select name="reverse_by" class="form-control" required>
				<option value="" disabled selected>Reverse Done By</option>
				<?php foreach($staff as $s){
					echo '<option value='.$s->staff_id.'>'.$s->first_name." ".$s->last_name." ".$s->name.'</option>';
				}
				?>
			</select></div>
		
	<div class="form-group col-lg-3"><input type="text" name="grouping_date" placeholder="Date" class="form-control" id="grouping_date" form='grouping_form' required /></div>
	<div class="form-group text-right"><input type="submit" class="btn btn-primary" name="Update" value="Update" /></div>
		</td></tr>
		</form>
		<?php
		}
		?>
</table>
	</div>
</div>	
	</div>
</div>

