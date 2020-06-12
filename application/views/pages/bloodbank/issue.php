<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<script type="text/javascript"
 src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
 <script type="text/javascript"
 src="<?php echo base_url();?>assets/js/jquery.timeentry.min.js"></script>
<script>
	$(function(){
		$("#issue_date").Zebra_DatePicker({
			direction:false
		});
		$("#issue_time").timeEntry();
		$("#show_universal").click(function(){
			$('.universal').toggle('slow');
		});
		$(".select_component").click(function(){
		var blood_unit=[];
			$(".select_component").each(function(){
				if($(this).is(":checked")){
					blood_unit.push($(this).parent().parent().find("td:eq(0)").text()+" - "+$(this).parent().parent().find("td:eq(1)").text());
				}
				$(".selected_components").text("");
				for($i=0;$i<blood_unit.length;$i++){
					$(".selected_components").append("<div class='well well-sm col-md-3'><b>"+blood_unit[$i]+"</b></div>");
				}
			});			
		});
	});
</script>

<div class="col-md-10 col-sm-9">
	<?php
	if(isset($msg)) {
		echo $msg;
		echo "<br />";
		echo "<br />";
	}
	?>
	<div>
	<div class="panel panel-default">
		<div class="panel-heading">
		<?php
		echo form_open('bloodbank/inventory/issue',array('id'=>'issue_form'));
		foreach($request as $request){
				echo "<input type='text' value='$request->request_id' hidden name='request_id' />";
				echo "Request ID: ".$request->request_id."<br />Requested for ";
				echo "Blood Group: <label class='label label-default'><b>$request->blood_group</b></label> ";
				if($request->whole_blood_units!=0){
					echo "<label class='label label-success'><b>WB: ".$request->whole_blood_units;
					echo "</b><input type='text' value='WB' hidden name='components[]' /></label> ";
				}
				if($request->packed_cell_units!=0){
					echo "<label class='label label-info'>PC: ".$request->packed_cell_units;
					echo "</b><input type='text' value='PC' hidden name='components[]' /></label> ";
				}
				if($request->fp_units!=0){
					echo "<label class='label label-warning'>FP: ".$request->fp_units;
					echo "</b><input type='text' value='FP' hidden name='components[]' /></label> ";
				}
				if($request->ffp_units!=0){
					echo "<label class='label label-warning'>FFP: ".$request->ffp_units;
					echo "</b><input type='text' value='FFP' hidden name='components[]' /></label> ";
				}
				if($request->prp_units!=0){
					echo "<label class='label label-warning'>PRP : ".$request->prp_units;
					echo "</b><input type='text' value='PRP' hidden name='components[]' /></label> ";
				}
				if($request->platelet_concentrate_units!=0){
					echo "<label class='label label-warning'>Platelet Concentrate: ".$request->platelet_concentrate_units;
					echo "</b><input type='text' value='Platelet Concentrate' hidden name='components[]' /></label> ";
				}
				if($request->cryoprecipitate_units!=0){
					echo "<label class='label label-warning'>Cryo: ".$request->cryoprecipitate_units;
					echo "</b><input type='text' value='Cryo' hidden name='components[]' /></label> ";
				}
				echo "</b><br />";
		}
		?>
		</div>
	<div class="panel-body">
	<?php
	if(count($inv)>0){
	?>
	
	<table class='table table-bordered table-striped'>
		<tr><th colspan="10">Inventory</th></tr>
	<tr><th>Blood Unit No.</th><th>Component</th><th>Blood Group</th><th>Expiry Date</th></tr>
	<?php
	foreach($inv as $i){
	?>
		<tr class="universal">
			<td><?php echo $i->blood_unit_num;?></td>
			<td><?php echo $i->component_type;?></td>
			<td><?php echo $i->blood_group;?></td>
			<td><?php echo date("d-M-Y",strtotime($i->expiry_date));;?></td>
			<td><input type="checkbox" value="<?php echo $i->inventory_id;?>" name="inventory_id[]" class="select_component" /></td>
		</tr>
	<?php
	}
	?>
	<tr>
		<td colspan="10">
		<br />
		<br />
		<br />
		<br />
			<div class="panel panel-success">
				<div class="panel-heading">
				Selected : 
				<div class="row">
					<div class="selected_components col-md-12">
					</div>
				</div>
				</div>
				<div class="panel-body">
					<table class="table table-bordered table-striped">
					<tr>
						<td>
								<select name="staff" class="form-control" required >
									<option value="" disabled selected>Issued By</option>
									<?php foreach($staff as $s){
										echo '<option value='.$s->staff_id.'>'.$s->first_name." ".$s->last_name." ".$s->name.'</option>';
									}
									?>
								</select><br />
								<select name="cross_matched_by" class="form-control" required>
									<option value="" disabled selected>Cross Matched By</option>
									<?php foreach($staff as $s){
										echo '<option value='.$s->staff_id.'>'.$s->first_name." ".$s->last_name." ".$s->name.'</option>';
									}
									?>
								</select>
						</td>
						<td colspan="2">
						<input type="text" size="12" name="issue_date" class="form-control" placeholder="Date" id="issue_date" form="issue_form" required /><br />
						<input type="text" size="12" name="issue_time" class="form-control" placeholder="Time" id="issue_time" form="issue_form" required />
						</td>
						
					</tr>
					<tr>
						<td colspan="3" align="middle">
						<input type="submit" class="btn btn-primary btn-md" value="Issue" name="issue_request" />
						</td>
					</tr>
					</table>
				</div>
			</div>
		</td>
	</tr>
	</table>
	</form>
	<?php
	}
	else{
		echo "Required components are not available in inventory!";
	}
	?>
	</div>
	</div>
</div>
    <div class="alert alert-info" role="alert">
        <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
        <span class="">Note:</span>
        <ul>
            <li>Blood Unit is the Blood bag number</li>            
            <li>Staff name shows up in Forward/Reverse done by only if the staff name is added to the database. To add staff <a href="<?php echo base_url()."staff/add/staff";?>">click here.</a>
                <ul><li>When adding staff make sure you select his/her department as Blood Bank, you get the department after selecting hospital</li></ul>
                <ul><li>Only fields with a '*' are mandatory</li></ul>
            </li>

        </ul>
    </div>
</div>

