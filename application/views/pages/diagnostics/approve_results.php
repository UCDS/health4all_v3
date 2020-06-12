<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<style>
.modal-body,.modal-header{
	background:#111;
}
</style>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/theme.default.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script>
	$(function(){	
		$(".date").Zebra_DatePicker();
	})
</script>
	<script>
		$(function(){ 
		var options = {
			widthFixed : true,
			showProcessing: true,
			headerTemplate : '{content} {icon}', // Add icon for jui theme; new in v2.7!

			widgets: [ 'default', 'zebra', 'stickyHeaders' ],

			widgetOptions: {

			// extra class name added to the sticky header row
			  stickyHeaders : '',
			  // number or jquery selector targeting the position:fixed element
			  stickyHeaders_offset : 0,
			  // added to table ID, if it exists
			  stickyHeaders_cloneId : '-sticky',
			  // trigger "resize" event on headers
			  stickyHeaders_addResizeEvent : true,
			  // if false and a caption exist, it won't be included in the sticky header
			  stickyHeaders_includeCaption : false,
			  // The zIndex of the stickyHeaders, allows the user to adjust this to their needs
			  stickyHeaders_zIndex : 2,
			  // jQuery selector or object to attach sticky header to
			  stickyHeaders_attachTo : null,
			  // scroll table top into view after filtering
			  stickyHeaders_filteredToTop: true,

			  // adding zebra striping, using content and default styles - the ui css removes the background from default
			  // even and odd class names included for this demo to allow switching themes
			  zebra   : ["ui-widget-content even", "ui-state-default odd"],
			  // use uitheme widget to apply defauly jquery ui (jui) class names
			  // see the uitheme demo for more details on how to change the class names
			  uitheme : 'jui'
			}
		  };
			$("#table-sort").tablesorter(options);
		});
	</script>
<div class="col-md-10 col-md-offset-2">
<?php
	echo validation_errors(); ?>
<?php if(isset($msg)){ ?> 
	<div class="alert alert-info"> <?php echo $msg;?>
	</div>
	<?php  }?>
<br>
<?php if(isset($order)){ 
	$age="";
	if($order[0]->age_years!=0) $age.=$order[0]->age_years."years ";
	if($order[0]->age_months!=0) $age.=$order[0]->age_months."months ";
	if($order[0]->age_days!=0) $age.=$order[0]->age_days."days ";
	?>
	<?php echo form_open('diagnostics/approve_results',array('role'=>'form','class'=>'form-custom'));?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Order #<?php echo $order[0]->order_id;?>
			<small>
					<b>Order placed at : </b>
					<?php echo date("g:ia, d-M-Y",strtotime($order[0]->order_date_time));?>
			</small>
			</h4>
		</div>
		<div class="panel-body">
			<div class="row col-md-12">
				<div class="col-md-4">
					<b>Patient : </b>
					<?php echo $order[0]->first_name." ".$order[0]->last_name." | ".$age." | ".$order[0]->gender; ?>
				</div>
				<div class="col-md-4">
					<b>Type : </b>
					<?php echo $order[0]->visit_type; ?>
				</div>
				<div class="col-md-4">
					<b><?php echo $order[0]->visit_type;?> Number : </b>
					<?php echo $order[0]->hosp_file_no;?>
				</div>
			</div>
			<div class="row col-md-12">
				<div class="col-md-4">
					<b>Department : </b>
					<?php echo $order[0]->department;?>
				</div>
				<div class="col-md-4">
					<b>Unit/Area : </b>
					<?php echo $order[0]->unit_name." / ".$order[0]->area_name;?>
				</div>
				<div class="col-md-4">
					<b>Provisional Diagnosis : </b>
					<?php echo $order[0]->provisional_diagnosis;?>
				</div>
			</div>
			<br />
			<br />
			<br />
			<table class="table table-bordered">
				<th>Test</th>
				<th>Value</th>
				<th colspan="2">Report</th>				
			<?php foreach($order as $test){ 
					$positive="";$negative="";
				 if($test->test_status==1){ $readonly = "disabled"; }else $readonly="";
			?>
			<tr>
					<td>
						<?php echo $test->test_name;if($test->nabl == 0) echo "<b style='color:red'>*</b>"?>
					</td>
					<td>
					<?php if($test->numeric_result==1){ 

							if($test->test_status == 0) { 
								$result="Test not done";
							} 
							else{
								if($test->test_result!=NULL)
								$result=$test->test_result." ".$test->lab_unit; 
								else $result ="";
							}
							echo $result;
						}
								else echo "-";
					 ?>
					</td>
					<td>
					<?php if($test->binary_result==1){ ?>
						<?php 
							if($test->test_status == 0) { 
								$result="Test not done.";
							} 
							else{	
								if($test->test_result_binary == 1 ) $result=$test->binary_positive ; 
								else if($test->test_result_binary == 0) $result=$test->binary_negative ; 
								else $result = "";
							}
						echo $result;
						?>
					<?php 
					}						
					else echo "-";
					?>
					
						<?php if($test->test_status == 1 && $test->test_result_binary==1 && preg_match("^Culture*^",$test->test_method)) { 
						$micro_organism_test_ids = array();
						$res = explode("^",trim($test->micro_organism_test,"^"));
						$k=0;
						foreach($res as $r) {
							$temp=explode(",",trim($r," ,"));
							$temp[3]==1?$temp[3]="<b>Sensitive</b>":$temp[3]="Resistant";
							if(!in_array($temp[0],$micro_organism_test_ids)){
								if(count($micro_organism_test_ids)>0) echo "</tr></tbody></table>"
								?>
								<table class='table table-bordered table-striped'><thead><th colspan="2" style="text-align:center"><?php echo $temp[1];?></th></thead>
								<tbody>
								<tr>
									<td><?php echo $temp[2]." - ".$temp[3];?>	</td>
							<?php 
								foreach($temp as $t){?>
							<?php 
								}
								$micro_organism_test_ids[]=$temp[0];
							}
							else echo "<td>$temp[2] - $temp[3]</td>";
							if($k%2==1) echo "</tr>";
							$k++;
							if($k==count($res))
								echo "</tr></tbody></table>";													
							}
						} ?>
					 </td>
					 <td>
					<?php if($test->text_result==1){ 

						if($test->test_status == 0) { 
							$result="Test not done";
							echo $result;
						} 
						else{	
							$result = $test->test_result_text;
						?>
							<textarea name="text_result_<?=$test->test_id;?>" class="form-control"><?php echo $result;?></textarea>
						<?php
						}
					 }
								else echo "-"; ?>
								
	
					<?php if($test->test_area=="Radiology"){
							if($test->study_id != "") { ?>
								&nbsp &nbsp <a data-toggle="modal" data-target="#myModal" href="#" ><span  class="glyphicon glyphicon-eye-open" ></span> View Image</a>
								<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
								  <div class="modal-dialog" role="document" style="width:90%">
									<div class="modal-content">
									  <div class="modal-body">
									  <button type="button" class="close" data-dismiss="modal" style="color:white;opacity:0.8" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<object type="text/html" data="http://localhost/dwv/viewers/simplistic/index.php?input=http%3A%2F%2Flocalhost%2F<?php echo $test->filepath;?>" width="100%" height="800px" style="overflow:auto;border:3px ridge #ccc"></object>
									  </div>
									</div>
								  </div>
								</div>
					<?php	}
						} ?>
					 </td>
					 <td>
					<?php if($test->test_status == 2){ ?>
						<label class="label label-success">Approved</label>
					<?php } 
					else if($test->test_status==3){ ?>
						<label class="label label-danger">Rejected</label>
					<?php } else { ?>	
						<label class="btn btn-success btn-sm">
						<input type="radio" value="1" name='approve_test_<?php echo $test->test_id;?>' checked required /> Approve
						</label>
						<label class="btn btn-danger btn-sm">
						<input type="radio" value="0" name='approve_test_<?php echo $test->test_id;?>' required /> Reject
						</label>
						<label class="btn btn-warning btn-sm">
						<input type="radio" value="2" name='approve_test_<?php echo $test->test_id;?>' required /> Not Completed
						</label>
					<input type="text" value="<?php echo $test->test_id;?>" name="test[]" class="sr-only hidden" />
					<?php } ?>
					</td>
				</tr>
			<?php } ?>
			
		</table>
		</div>
		<div class="panel-footer">
		<input type="text" class="sr-only" value="<?php echo $this->input->post('test_area');?>"  name="test_area" readonly /> 
		<input type="text" class="sr-only" value="<?php echo $this->input->post('patient_type_search');?>"  name="patient_type_search" readonly /> 
		<input type="text" class="sr-only" value="<?php echo $this->input->post('hosp_file_no_search');?>"  name="hosp_file_no_search" readonly /> 
		<input type="text" class="sr-only" value="<?php echo $this->input->post('test_method_search');?>"  name="test_method_search" readonly /> 
		<input type="text" class="sr-only" value="<?php echo $this->input->post('from_date');?>"  name="from_date" readonly /> 
		<input type="text" class="sr-only" value="<?php echo $this->input->post('to_date');?>"  name="to_date" readonly /> 			
		<input type="text" value="<?php echo $test->order_id;?>" name="order_id" class="sr-only hidden" />
			<div style="text-align:center">
			<?php 
			if($test->a_id != NULL && $test->a_id != "") { $email = $test->a_email; $first_name = $test->a_first_name; $phone = $test->a_phone; }
			else if($test->u_id != NULL && $test->u_id != "") { $email = $test->u_email; $first_name = $test->u_first_name; $phone = $test->u_phone; }
			else if($test->d_id != NULL && $test->d_id != "") { $email = $test->d_email; $first_name = $test->d_first_name; $phone = $test->d_phone; }
			$email = $test->department_email; $first_name = $test->department; $phone = "-";  ?>
				<div>Department  : <?php echo $first_name;?> |  Email : <?php echo $email;?> | Phone : <?php echo $phone;?></p>
			<div class="well well-sm text-center"><label class="label label-warning"><input type="checkbox" name="send_email" value="1" checked /> Send Email to Department</label></div>
			<input type="submit" value="Submit" class="btn btn-primary btn-md" name="approve_results" />
			</div>
		</div>
	</div>
	</form>
		
<?php	
	}
	else{
?>
<?php echo form_open('diagnostics/approve_results',array('role'=>'form','class'=>'form-custom'));
if(isset($orders)){ ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			Search
		</div>
		<div class="panel-body">
			<input type="text" class="sr-only" value="<?php echo $this->input->post('test_area');?>"  name="test_area" readonly /> 
			<label>Order Dates</label> 
			<input type="text" class="date form-control" placeholder="From Date" value="<?php if($this->input->post('from_date')) $from_date=$this->input->post('from_date'); else $from_date = date("d-M-Y"); echo $from_date;?>" name="from_date" /> 
			<input type="text" class="date form-control" placeholder="To Date" value="<?php if($this->input->post('to_date')) $to_date=$this->input->post('to_date'); else $to_date = date("d-M-Y"); echo $to_date?>"  name="to_date" /> 
			<br />
			<br />
			<label>Test Method</label>
			<select name="test_method_search" class="form-control">
			<option value="" selected>Select</option>
			<?php foreach($test_methods as $test_method){ ?>
				<option value="<?php echo $test_method->test_method_id;?>" <?php if($this->input->post('test_method_search')==$test_method->test_method_id) echo " selected ";?>><?php echo $test_method->test_method;?></option>
			<?php } ?>
			</select>
			<label>Patient Type : </label>
			<select name="patient_type_search" class="form-control">
			<option value="" selected>Select</option>
			<option value="OP" <?php if($this->input->post('patient_type_search')=="OP") echo " selected ";?>>OP</option>
			<option value="IP" <?php if($this->input->post('patient_type_search')=="IP") echo " selected ";?>>IP</option>
			</select>
			<label>Patient #</label>
			<input type="text" class="form-control" name="hosp_file_no_search" value="<?php echo $this->input->post('hosp_file_no_search');?>" />			
		</div>
		<div class="panel-footer">
			<input type="submit" value="Search" name="submit" class="btn btn-primary btn-md" /> 
		</div>
	</div>
	</form>
<?php 
if(count($orders)>0){ ?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h4>Test Orders</h4>
	</div>
	<div class="panel-body">
		<table class="table table-bordered table-striped" id="table-sort">
		<thead>
			<th>#</th>
			<th>Order ID</th>
			<th>Sample Code</th>
			<th>Specimen</th>
			<th>IP/OP #</th>
			<th>Patient Name</th>
			<th>Department</th>
			<th>Tests</th>
		</thead>
		<tbody>
			<?php 
			$o=array();
			foreach($orders as $order){
				$o[]=$order->order_id;
			}
			$o=array_unique($o);
			$i=1;
			foreach($o as $ord){	?>
				<tr>
				<?php
				foreach($orders as $order) { 
					if($order->order_id==$ord){ ?>
						<td><?php echo $i++;?></td>
						<td>
							<?php echo form_open('diagnostics/approve_results',array('role'=>'form','class'=>'form-custom')); ?>
							<?php echo $order->order_id;?>
							<input type="hidden" class="sr-only" name="order_id" value="<?php echo $order->order_id;?>" />
						</td>
						<td><?php echo $order->sample_code;?></td>
						<td><?php echo $order->specimen_type; if($order->specimen_source!="") echo " - ".$order->specimen_source;?> </td><!--printing the specimen source in the update tests beside the specimen type if the specimen type is not null-->
						<td><?php echo $order->visit_type." #".$order->hosp_file_no;?></td>
						<td><?php echo $order->first_name." ".$order->last_name;?></td>
						<td><?php echo $order->department;?></td>
						<td>
							<?php foreach($orders as $order){
										if($order->order_id == $ord) {
											if($order->test_status==1) 
												$label="label-warning";
											else if($order->test_status == 3){ $label = "label-danger";}
											else if($order->test_status == 2){ $label = "label-success";}
											else if($order->test_status == 0){ $label = "label-default";}
											echo "<div class='label $label'>".$order->test_name.(($order->nabl == 0)? "<b style='color:red'>*</b>":"")."</div><br />";
										}
									} 
							?>
						</td>
						<td>
							<input type="text" class="sr-only" value="<?php echo $this->input->post('test_area');?>"  name="test_area" readonly /> 
							<input type="text" class="sr-only" value="<?php echo $this->input->post('patient_type_search');?>"  name="patient_type_search" readonly /> 
							<input type="text" class="sr-only" value="<?php echo $this->input->post('hosp_file_no_search');?>"  name="hosp_file_no_search" readonly /> 
							<input type="text" class="sr-only" value="<?php echo $this->input->post('test_method_search');?>"  name="test_method_search" readonly /> 
							<input type="text" class="sr-only" value="<?php echo $this->input->post('from_date');?>"  name="from_date" readonly /> 
							<input type="text" class="sr-only" value="<?php echo $this->input->post('to_date');?>"  name="to_date" readonly /> 
							<button class="btn btn-sm btn-primary" type="submit" value="submit" name="select_order">Select</button></form></td>
				<?php break;
					}
				} ?>
				</tr>
			<?php } ?>
		</tbody>
		</table>
	</div>
	<div class="panel-footer">
		<div class="col-md-offset-4">
		</br>
		
		</div>
	</div>
</div>
<?php 
	}
	else if(count($orders)==0){
		echo "No orders to update";
	}
}
	else if(count($test_areas)>1){ ?> 
	<?php echo form_open('diagnostics/approve_results',array('role'=>'form','class'=>'form-custom')); ?>
		<div class="form-group">
			<label for="test_area">Test Area<font color='red'>*</font></label>
			<select name="test_area" class="form-control"  id="test_area">
				<option value="" selected disabled>Select Test Area</option>
				<?php
					foreach($test_areas as $test_area){ ?>
						<option value="<?php echo $test_area->test_area_id;?>" <?php if($this->input->post('test_area')==$test_area->test_area_id) echo " selected ";?>><?php echo $test_area->test_area;?></option>
				<?php } ?>
			</select>
			<input type="submit" class="btn btn-primary btn-md" name="submit_test_area" value="Select" />
		</div>
	</form>
<?php 
	}
} 
?>
<!--<p><b style="color:red">*</b>Not under NABL</p>-->
</div>