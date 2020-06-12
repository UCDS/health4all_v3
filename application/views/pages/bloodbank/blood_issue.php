<div class="col-md-10 col-sm-9">
	<?php
	if(isset($msg)) {
		echo $msg;
		echo "<br />";
		echo "<br />";
	}
	?>
	<div>
		<?php if(count($requests)==0){
			echo "No requests.";
		}
		else{
		?>
		<h4>Pending Requests : </h4>
		<table class="table table-striped table-bordered">
			<tr><th>ID</th><th>Date</th><th>Hospital</th><th>Patient Name</th><th>IP No.</th><th>Ward/Unit</th><th>Blood Group</th><th>Units</th><th></th></tr>
		<?php 
		$i=1;
		foreach($requests as $request){
		?>
		<tr>
		<?php echo form_open('bloodbank/inventory/issue/'.$request->request_id);?>
			<td><input type="text" value="<?php echo $request->request_id;?>" readonly name="request_id" size="3" hidden />
			<?php echo $request->request_id;?></td>
			<td><?php echo date("d-M-Y",strtotime($request->request_date));?></td>
			<td <?php if($request->request_type==1) echo "colspan='4'";?>><?php echo $request->hospital;?></td>
			<?php if($request->request_type==0){ ?>
			<td><?php echo $request->first_name." ".$request->last_name." ".$request->patient_name;?></td>
			<td><?php echo $request->hosp_file_no;?></td>
			<td><?php echo $request->ward_unit;
				if(!!$request->unit_name) echo "/ ".$request->unit_name;
				if(!!$request->area_name) echo "/ ".$request->area_name;?>
			</td>
			<?php } ?>
			<td><?php echo $request->blood_group;?>
			<input type="text" value="<?php echo $request->blood_group;?>" hidden name="blood_group" />
			</td>		
			<td>
				<?php 
				if($request->whole_blood_units!=0){
					echo "<label class='label label-success'><b>WB: ".$request->whole_blood_units;
					echo "</b><input type='text' value='\"WB\"' hidden name='components[]' /></label> ";
				}
				if($request->packed_cell_units!=0){
					echo "<label class='label label-info'><b>PC: ".$request->packed_cell_units;
					echo "</b><input type='text' value='\"PC\"' hidden name='components[]' /></label> ";
				}
				if($request->fp_units!=0){
					echo "<label class='label label-warning'><b>FP: ".$request->fp_units;
					echo "</b><input type='text' value='\"FP\"' hidden name='components[]' /></label> ";
				}
				if($request->ffp_units!=0){
					echo "<label class='label label-warning'><b>FFP: ".$request->ffp_units;
					echo "</b><input type='text' value='\"FFP\"' hidden name='components[]' /></label> ";
				}
				if($request->prp_units!=0){
					echo "<label class='label label-warning'><b>PRP : ".$request->prp_units;
					echo "</b><input type='text' value='\"PRP\"' hidden name='components[]' /></label> ";
				}
				if($request->platelet_concentrate_units!=0){
					echo "<label class='label label-warning'><b>Platelet Concentrate: ".$request->platelet_concentrate_units;
					echo "</b><input type='text' value='\"Platelet Concentrate\"' hidden name='components[]' /></label> ";
				}
				if($request->cryoprecipitate_units!=0){
					echo "<label class='label label-warning'><b>Cryo: ".$request->cryoprecipitate_units;
					echo "</b><input type='text' value='\"Cryo\"' hidden name='components[]' /></label> ";
				}
				?></td>		
			<td><input type="submit" value="Issue" class="btn btn-primary btn-sm" name="select_request" /></td>
		</form>
		</tr>
		<?php 
		$i++;
		}
		}
		?>
		</table>
			
	</div>
</div>

