<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
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
<?php echo validation_errors(); ?>
<?php if(isset($msg)){ ?> 
	<div class="alert alert-info"> <?php echo $msg;?>
	</div>
	<?php  }?>
<br>
<?php if(isset($order)){
	$age="";
	if($order[0]->age_years!=0) $age.=$order[0]->age_years."Y ";
	if($order[0]->age_months!=0) $age.=$order[0]->age_months."M ";
	if($order[0]->age_days!=0) $age.=$order[0]->age_days."D ";
	?>
	<?php echo form_open('diagnostics/edit_order',array('role'=>'form','class'=>'form-custom','id'=>'order_submit'));?>
		
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Order #<?php $order_id = $order[0]->order_id; echo $order_id;?>
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
					<b>Patient Number : </b>
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
			</div>
			<br />
			<br />
			<br />
			<?php 
			$groups=array();
			$group_tests=array();
			$i=0;
			foreach($order as $test){
				if($test->group_id!=0){
					if(!in_array($test->group_id,$groups)){
						$groups[]=$test->group_id;
					}
					$group_tests[]=array(
						'group_id'=>$test->group_id,
						'test_master_id'=>$test->test_master_id,
						'test_id'=>$test->test_id,
						'test_name'=>$test->test_name,
						'test_status'=>$test->test_status,
						'binary_result'=>$test->binary_result,
						'numeric_result'=>$test->numeric_result,
						'text_result'=>$test->text_result,
						'test_result_binary'=>$test->test_result_binary,
						'test_result'=>$test->test_result,
						'test_result_text'=>$test->test_result_text,
						'binary_positive'=>$test->binary_positive,
						'binary_negative'=>$test->binary_negative,
						'lab_unit'=>$test->lab_unit
					);
					array_splice($order,$i,1);
					$i--;
				}
				$i++;
			}
			foreach($groups as $group){
				foreach($group_tests as $test){
					if($test['test_master_id']==0){ ?>
						<div class="panel panel-info">
							<div class="panel-heading">
								<span> 
								<div class="row" style="padding-left:15px"><h4><?php echo $test['test_name'];?></h4></div>
								<div class="row">
			<?php 				
				$positive="";$negative="";
				if($test['test_status']==1){ $readonly = "disabled"; }else $readonly="";
			?>
					<?php if($test['binary_result']==1){ ?>
					<div class="col-md-4">
						<?php if($test['test_status'] == 1) { if($test['test_result_binary'] == 1 ) $positive="checked" ; else $negative = "checked" ; } ?>
							<label><input type="radio" value="1" form='order_submit' name="binary_result_<?php echo $test['test_id'];?>" <?php echo $readonly." ".$positive;?> />
							<?php echo $test['binary_positive'];?></label>
							<label>
								<input type="radio" value="0" form='order_submit'  name="binary_result_<?php echo $test['test_id'];?>" <?php echo $readonly." ".$negative;?> />
							<?php echo $test['binary_negative'];?></label>
					</div>
					<?php } ?>
					<?php if($test['numeric_result']==1){ ?>
					<div class="col-md-4" class="form-group">
							<input type="number" class="form-control" placeholder="Numeric" style="width:100px" form='order_submit' name="numeric_result_<?php echo $test['test_id'];?>" step="any" value="<?php echo $test['test_result'];?>" <?php echo $readonly;?> />
							<label class="control-label"><?php echo $test['lab_unit'];?></label>
					</div>
					<?php } ?>
					<?php if($test['text_result']==1){ ?>
					<div class="col-md-4">
							<textarea name="text_result_<?php echo $test['test_id'];?>" class="form-control" form='order_submit' placeholder="Descriptive result" value="<?php echo $test['test_result_text'];?>"  <?php echo $readonly;?>></textarea>
					</div>
					<?php } ?>
			<input type="text" value="<?php echo $test['test_id'];?>" name="test[]" class="sr-only hidden" />
			</div>
			</span>
			</div>
			
					<?php 	
					}
				}
				?>
				<div class="panel panel-body">
					<?php foreach($group_tests as $test) { 
					if($test['test_master_id']!=0){
					$positive="";$negative="";
				 if($test['test_status']==1){ $readonly = "disabled"; }else $readonly="";
			?>
				<div class="panel panel-warning col-md-12">
					<h4>
						<?php echo $test['test_name'];?>
					</h4>
					<?php if($test['binary_result']==1){ ?>
					<div class="col-md-4">
						<?php if($test['test_status'] == 1) { if($test['test_result_binary'] == 1 ) $positive="checked" ; else $negative = "checked" ; } ?>
							<label>
							<input type="radio" value="1" id="binary_result_pos" form='order_submit' name="binary_result_<?php echo $test['test_id'];?>" <?php echo $readonly." ".$positive;?> />
							<?php echo $test['binary_positive'];?>
							</label>
							<label>
							<input type="radio" value="0"form='order_submit'  name="binary_result_<?php echo $test['test_id'];?>" <?php echo $readonly." ".$negative;?> />
							<?php echo $test['binary_negative'];?>
							</label>
					</div>
					<?php } ?>
					<?php if($test['numeric_result']==1){ ?>
					<div class="col-md-4" class="form-group">
							<input type="number" class="form-control" placeholder="Numeric" style="width:100px" form='order_submit' name="numeric_result_<?php echo $test['test_id'];?>" step="any" value="<?php echo $test['test_result'];?>" <?php echo $readonly;?> />
							<label class="control-label"><?php echo $test['lab_unit'];?></label>
					</div>
					<?php } ?>
					<?php if($test['text_result']==1){ ?>
					<div class="col-md-4">
							<textarea name="text_result_<?php echo $test['test_id'];?>" class="form-control" form='order_submit' placeholder="Descriptive result" value="<?php echo $test['test_result_text'];?>"  <?php echo $readonly;?>></textarea>
					</div>
					<?php } ?>
			<input type="text" value="<?php echo $test['test_id'];?>" name="test[]" class="sr-only hidden" />
				</div>
			<?php }
				} ?>
				</div>
			</div>
			<?php 
			}
			foreach($order as $test){ 
					$positive="";$negative="";
				 if($test->test_status==1){ $readonly = "disabled"; }else $readonly="";
			?>
				<div class="panel panel-warning col-md-12">
					<h4>
						<?php echo $test->test_name;?>
					</h4>
					<?php if($test->binary_result==1){ ?>
					<div class="col-md-4">
						<?php if($test->test_status == 1) { if($test->test_result_binary == 1 ) $positive="checked" ; else $negative = "checked" ; } ?>
							<label>
							<input type="radio" value="1" id="binary_positive_<?php echo $test->test_id;?>" form='order_submit' name="binary_result_<?php echo $test->test_id;?>" <?php echo $readonly." ".$positive;?> />
							<?php echo $test->binary_positive;?>
							</label>
							<label>
							<input type="radio" value="0" id="binary_negative_<?php echo $test->test_id;?>" form='order_submit'  name="binary_result_<?php echo $test->test_id;?>" <?php echo $readonly." ".$negative;?> />
							<?php echo $test->binary_negative;?>
							</label>
					</div>
						<?php if(preg_match("^Culture*^",$test->test_method)) { ?>
						<script type="text/javascript">
								var ab_num=0,i=0,j=0;
							$(function(){
								$("input:radio[name=binary_result_<?php echo $test->test_id;?>]").parent().find("input:radio").change(function(){
									if($(this).val()==1){
										$(".micro_organism_<?php echo $test->test_id;?>").show();
										$(".add_organism_<?php echo $test->test_id;?>").show();
										$(".remove_organism_<?php echo $test->test_id;?>").show();
									}
									else {
										$(".micro_organism_<?php echo $test->test_id;?>").hide();
										$(".add_organism_<?php echo $test->test_id;?>").hide();
										$(".remove_organism_<?php echo $test->test_id;?>").hide();
									}
										
								});
								$("#add_organism_<?php echo $test->test_id;?>").click(function(){
									var new_organism = '<div class="col-md-10 well micro_organism_<?php echo $test->test_id;?>" id="micro_organism_row_'+j+'" style="padding:5px 0px;">';
									new_organism += '<select name="micro_organisms_<?php echo $test->test_id;?>[]" form="order_submit" class="form-control">';
									new_organism += '<option value="" selected disabled>Select Micro Organism</option>';
							<?php foreach($micro_organisms as $micro_organism){ ?>
									new_organism += '<option value="<?php echo $micro_organism->micro_organism_id;?>"><?php echo $micro_organism->micro_organism;?></option>';
							<?php } ?>
									new_organism += '</select>';
									new_organism += '<div class="col-md-12 well antibiotic antibiotic_<?php echo $test->test_id;?>" hidden style="background-color:#F8FCC2">';
									new_organism += '<div class="col-md-10"><select name="antibiotics_<?php echo $test->test_id;?>_0"  form="order_submit" class="form-control">';
									new_organism += '<option value="" selected disabled>Select Antibiotic</option>';
									<?php foreach($antibiotics as $antibiotic){ ?>
										new_organism +="<option value='<?php echo $antibiotic->antibiotic_id;?>'><?php echo $antibiotic->antibiotic;?></option>";
									<?php } ?>
									new_organism += "</select>";
									new_organism += " <label><input type='radio' form='order_submit' name='antibiotic_results_<?php echo $test->test_id;?>_0' value='1' />Sensitive</label>";
									new_organism += " <label><input type='radio' form='order_submit' name='antibiotic_results_<?php echo $test->test_id;?>_0' value='0' />Resistant</label>";
									new_organism += " <input type='text' value='1' name='antibiotics_<?php echo $test->test_id;?>_"+$(this).val()+"[]'  form='order_submit' hidden />";
									new_organism += '</div>';
									new_organism += '</div><div class="col-md-12"><button type="button" class="btn btn-primary btn-md add_antibiotic_<?php echo $test->test_id;?>" id="add_antibiotic_<?php echo $test->test_id;?>" style="background-color:#F8FCC2;color:black;border:1px solid #ccc;">+</button></div></div>';
									new_organism += '<div class="col-md-2 remove_organism_<?php echo $test->test_id;?> remove_'+j+'"><button type="button" class="btn btn-danger btn-md" onclick="removeRow(2,'+j+')">X</button>';
									$(this).parent().parent().append(new_organism);
									j++;
								initialize_<?php echo $test->test_id;?>();

								});
								initialize_<?php echo $test->test_id;?>();
							});
							function initialize_<?php echo $test->test_id;?>(){
								$(".micro_organism_<?php echo $test->test_id;?> select[name*=micro]").change(function(){
									ab_num=0;
									$(this).parent().find($(".antibiotic_<?php echo $test->test_id;?> select")).prop('name','antibiotics_<?php echo $test->test_id;?>_'+$(this).val()+'_'+ab_num).parent().parent().show();
									$(this).parent().find($(".antibiotic_<?php echo $test->test_id;?> input:radio")).prop('name','antibiotic_results_<?php echo $test->test_id;?>_'+$(this).val()+'_'+ab_num);
									$(this).parent().find($(".antibiotic_<?php echo $test->test_id;?> input:text")).prop('name','antibiotics_<?php echo $test->test_id;?>_'+$(this).val()+'[]');
									$(this).parent().find('.add_antibiotic_<?php echo $test->test_id;?>').attr('id',$(this).val());
								});
								$(".add_antibiotic_<?php echo $test->test_id;?>").off();
								$(".add_antibiotic_<?php echo $test->test_id;?>").click(function(){
									antibiotic_num = $(this).parent().parent().find('select:last').prop('name');
									antibiotic_num=antibiotic_num.split('_');
									antibiotic_num=antibiotic_num[3].replace('[]','');
									ab_num = parseInt(antibiotic_num)+1;
									console.log(ab_num);
									new_row = "<div style='padding:5px 0px;' id='antibiotic_row_"+i+"'><select name='antibiotics_<?php echo $test->test_id;?>_"+$(this).attr('id')+"_"+ab_num+"' form='order_submit' class='form-control'>";
									new_row += "<option value='' selected disabled>Select Antibiotic</option>";
									<?php foreach($antibiotics as $antibiotic){ ?>
										new_row +="<option value='<?php echo $antibiotic->antibiotic_id;?>'><?php echo $antibiotic->antibiotic;?></option>";
									<?php } ?>
									new_row += "</select>";
									new_row += " <label><input type='radio' name='antibiotic_results_<?php echo $test->test_id;?>_"+$(this).attr('id')+"_"+ab_num+"' form='order_submit' value='1' />Sensitive</label>";
									new_row += " <label><input type='radio' name='antibiotic_results_<?php echo $test->test_id;?>_"+$(this).attr('id')+"_"+ab_num+"' form='order_submit' value='0' />Resistant</label>";
									new_row += " <input type='text' form='order_submit'  value='1' name='antibiotics_<?php echo $test->test_id;?>_"+$(this).attr('id')+"[]' hidden />";
									new_row+=" &nbsp<input type='button' value='X' class='btn btn-danger btn-sm'  onclick='removeRow(1,"+i+")' /></div>";
									$(this).parent().parent().find($(".col-md-10")).append(new_row);
									i++;
								});
							}
						</script>
						<?php if($test->test_status == 1 && $test->binary_result==1) { 
						$micro_organism_test_ids = array();
						// echo $test->micro_organism_test_id;
						$res = explode("^",trim($test->micro_organism_test,"^"));
						$k=0;
						foreach($res as $r) {
							$temp=explode(",",trim($r," ,"));
							$temp[3]==1?$temp[3]="Sensitive":$temp[3]="Resistant";
							if(!in_array($temp[0],$micro_organism_test_ids)){
								if(count($micro_organism_test_ids)>0) echo "</div></div></div>"
								?>
								<div class="col-md-12"><div class="well" style="background:white;font-size:0.7em;">
									<b><?php echo $temp[1];?></b>
									<div class='row'>
									<div class='col-md-6'><?php echo $temp[2]." - ".$temp[3];?>	</div>
							<?php 
								foreach($temp as $t){?>
							<?php 
								}
								$micro_organism_test_ids[]=$temp[0];
							}
							else echo "<div class='col-md-6'>$temp[2] - $temp[3]</div>";	
							$k++;
							if($k==count($res))
								echo "</div></div></div>";
							}
							
						} ?>
						<div class="col-md-10 well micro_organism_<?php echo $test->test_id;?>" hidden style='padding:5px 0px;'>
							<select name="micro_organisms_<?php echo $test->test_id;?>[]" form='order_submit' class="form-control">
							<option value="" selected disabled>Select Micro Organism</option>
							<?php foreach($micro_organisms as $micro_organism){ ?>
								<option value="<?php echo $micro_organism->micro_organism_id;?>"><?php echo $micro_organism->micro_organism;?></option>
							<?php } ?>
							</select>

							<div class="col-md-12 well antibiotic antibiotic_<?php echo $test->test_id;?>" hidden style="background-color:#F8FCC2">
							<div class='col-md-10'>
								<select name="antibiotics_<?php echo $test->test_id;?>_0[]" form='order_submit' class="form-control">
								<option value="" selected disabled>Select Antibiotic</option>
								<?php foreach($antibiotics as $antibiotic){ ?>
									<option value="<?php echo $antibiotic->antibiotic_id;?>"><?php echo $antibiotic->antibiotic;?></option>
								<?php } ?>
								</select>
								<label><input type="radio" name="antibiotic_results_<?php echo $test->test_id;?>_0" form='order_submit' value="1" />Sensitive</label>
								<label><input type="radio" name="antibiotic_results_<?php echo $test->test_id;?>_0" form='order_submit' value="0" />Resistant</label>
								<input type='text' value='1' name='antibiotics_'  form='order_submit' readonly hidden />
							</div>
							<div class="col-md-2"><button type="button" class="btn btn-primary btn-md add_antibiotic_<?php echo $test->test_id;?>" id="add_antibiotic_<?php echo $test->test_id;?>" style="background-color:#F8FCC2;color:black;border:1px solid #ccc;">+</button></div>
							</div>
						</div>
						<div class="col-md-2 add_organism_<?php echo $test->test_id;?>" hidden><button type="button" class="btn btn-primary btn-md" id="add_organism_<?php echo $test->test_id;?>">+</button></div>
						<?php } ?>
					<?php } ?>
					<?php if($test->numeric_result==1){ ?>
					<div class="col-md-4" class="form-group">
							<input type="number" class="form-control" placeholder="Numeric" style="width:100px" form='order_submit' name="numeric_result_<?php echo $test->test_id;?>" step="any" value="<?php echo $test->test_result;?>" <?php echo $readonly;?> />
							<label class="control-label"><?php echo $test->lab_unit;?></label>
					</div>
					<?php } ?>
					<?php if($test->text_result==1){ ?>
					<div class="col-md-4">
							<textarea name="text_result_<?php echo $test->test_id;?>" class="form-control" form='order_submit' placeholder="Descriptive result" value="<?php echo $test->test_result_text;?>"  <?php echo $readonly;?>></textarea>
					</div>
					<?php } ?>
			<input type="text" value="<?php echo $test->test_id;?>" name="test[]" class="sr-only hidden" />
				</div>
			<?php } ?>
			
		</div>
		<div class="panel-footer">
		<input type="text" class="sr-only" value="<?php echo $this->input->post('test_area');?>"  name="test_area" readonly /> 
		<input type="text" class="sr-only" value="<?php echo $this->input->post('patient_type_search');?>"  name="patient_type_search" readonly /> 
		<input type="text" class="sr-only" value="<?php echo $this->input->post('hosp_file_no_search');?>"  name="hosp_file_no_search" readonly /> 
		<input type="text" class="sr-only" value="<?php echo $this->input->post('test_method_search');?>"  name="test_method_search" readonly /> 
		<input type="text" class="sr-only" value="<?php echo $this->input->post('from_date');?>"  name="from_date" readonly /> 
		<input type="text" class="sr-only" value="<?php echo $this->input->post('to_date');?>"  name="to_date" readonly /> 	
			<input type="text" value="<?php echo $order_id;?>" form='order_submit' name="order_id" class="sr-only hidden" />
			<input type="submit" value="Submit" class="btn btn-primary btn-md col-md-offset-5" form='order_submit'  name="submit_results" />
		</div>
	</div>
		
<?php	
	}
	else{
?>
<?php echo form_open('diagnostics/edit_order',array('role'=>'form','class'=>'form-custom'));
if(isset($orders)){ ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			Search
		</div>
		<div class="panel-body">
			<input type="text" class="sr-only" value="<?php echo $this->input->post('test_area');?>"  name="test_area" /> 
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
			<th>Patient ID</th>
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
							<?php echo form_open('diagnostics/edit_order',array('role'=>'form','class'=>'form-custom')); ?>
							<?php echo $order->order_id;?>
							<input type="hidden" class="sr-only" name="order_id" value="<?php echo $order->order_id;?>" />
						</td>
						<td><?php echo $order->sample_code;?></td>
						<td><?php echo $order->specimen_type; if($order->specimen_source!="") echo " - ".$order->specimen_source;?> </td><!--mentioning the specimen source beside the specimen type if the specimen type is not null-->
						<td><?php echo $order->visit_type." #".$order->hosp_file_no;?></td>
						<td><?php echo $order->first_name." ".$order->last_name;?></td>
						<td><?php echo $order->department;?></td>
						<td>
							<?php foreach($orders as $order){
										if($order->order_id == $ord) {
											if($order->test_status==1) 
												$label="label-success";
											else $label = "label-danger";
											echo "<div class='label $label'>".$order->test_name."</div><br />";
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
						<button class="btn btn-sm btn-danger" type="submit" name="select_order" value="submit">Cancel</button></form></td>
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
	<?php echo form_open('diagnostics/edit_order',array('role'=>'form','class'=>'form-custom')); ?>
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
</div>
<script>
	function removeRow(type,i){
		if(type==1)
		$("#antibiotic_row_"+i).remove();
		else if(type==2){
		$("#micro_organism_row_"+i).remove();
		$(".remove_"+i).remove();
		}
	}
</script>