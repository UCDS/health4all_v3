<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-barcode.min.js"></script>
<style>
	.row{
		margin-bottom: 1.5em;
	}
	.alt{
		margin-bottom:0;
		padding:0.5em;
	}
	.alt:nth-child(odd){
		background:#eee;
	}
</style>
<?php 
	function drug_available($drug, $drugs_available){
		foreach($drugs_available as $drg){
			if($drg->generic_item_id == $drug->generic_item_id){
				return true;
			}
		}
		return false;
	}	
?>
<script type="text/javascript">
$(function(){
	$("#from_date,#to_date").Zebra_DatePicker();
	$("#unit option,#area option").hide();
	$("#department").on('change',function(){
		var department_id=$(this).val();
		$("#unit option,#area option").hide();
		$("#unit option[class="+department_id+"],#area option[class="+department_id+"]").show();
	});
		var options = {
			widthFixed : true,
			showProcessing: true,
			headerTemplate : '{content} {icon}', // Add icon for jui theme; new in v2.7!

			widgets: [ 'default', 'zebra', 'print', 'stickyHeaders','filter'],

			widgetOptions: {

		  print_title      : 'table',          // this option > caption > table id > "table"
		  print_dataAttrib : 'data-name', // header attrib containing modified header name
		  print_rows       : 'f',         // (a)ll, (v)isible or (f)iltered
		  print_columns    : 's',         // (a)ll, (v)isible or (s)elected (columnSelector widget)
		  print_extraCSS   : '.table{border:1px solid #ccc;} tr,td{background:white}',          // add any extra css definitions for the popup window here
		  print_styleSheet : '', // add the url of your print stylesheet
		  // callback executed when processing completes - default setting is null
		  print_callback   : function(config, $table, printStyle){
			// do something to the $table (jQuery object of table wrapped in a div)
			// or add to the printStyle string, then...
			// print the table using the following code
			$.tablesorter.printTable.printOutput( config, $table.html(), printStyle );
			},
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
		  $('.print').click(function(){
			$('#table-sort').trigger('printTable');
		  });
});

<!-- Scripts for printing output table -->
function printDiv(i)
{
var content = document.getElementById(i);
var pri = document.getElementById("ifmcontentstoprint").contentWindow;
pri.document.open();
pri.document.write(content.innerHTML);
pri.document.close();
pri.focus();
pri.print();
}
</script>
	<?php if(isset($patients) && count($patients)>1){ ?>
	<table class="table table-bordered table-hover table-striped" id="table-sort">
	<thead>
		<th style="text-align:center">#</th>
		<th style="text-align:center">Hospital</th>
		<th style="text-align:center">IP/OP No.</th>
		<th style="text-align:center">Patient</th>
		<th style="text-align:center">Admit Date</th>
		<th style="text-align:center">Department</th>
		<th style="text-align:center">Phone</th>
		<th style="text-align:center">Parent/Spouse</th>
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach($patients as $p){
		$age="";
		if($p->age_years!=0) $age.=$p->age_years."Y ";
		if($p->age_months!=0) $age.=$p->age_months."M ";
		if($p->age_days!=0) $age.=$p->age_days."D ";
	?>
	<tr onclick="$('#select_patient_<?php echo $p->visit_id;?>').submit()" style="cursor:pointer">
		<td>
			<?php echo form_open('register/view_patients',array('role'=>'form','id'=>'select_patient_'.$p->visit_id));?>
			<input type="text" class="sr-only" hidden value="<?php echo $p->visit_id;?>" name="selected_patient" />
			<input type="text" class="sr-only" hidden value="<?php echo $p->patient_id;?>" name="patient_id" />
			</form>
			<?php echo $i++;?>
		</td>
		<td><?php echo $p->hospital;?></td>
		<td><?php echo $p->visit_type." #".$p->hosp_file_no;?></td>
		<td><?php echo $p->first_name." ".$p->last_name." | ".$age." | ".$p->gender;?></td>
		<td><?php echo date("d-M-Y",strtotime($p->admit_date));?></td>
		<td><?php echo $p->department;?></td>
		<td><?php echo $p->phone;?></td>
		<td><?php echo $p->parent_spouse;?></td>
	</tr>
	<?php
	}
	?>
	</tbody>
	</table>
	<?php } 
	else if(isset($patients) && count($patients)==1){ ?>
	<div class="panel panel-default">
	<div class="panel-body">
	  <!-- Nav tabs -->
	  <ul class="nav nav-tabs" role="tablist">
		<li role="presentation" class="active"><a href="#patient" aria-controls="patient" role="tab" data-toggle="tab"><i class="fa fa-user"></i> Patient Info</a></li>
                <li role="presentation"><a href="#patient_visit" aria-controls="patient" role="tab" data-toggle="tab"><i class="fa fa-user"></i> Patient Visit</a></li>
                <li role="presentation"><a href="#mlc" aria-controls="patient" role="tab" data-toggle="tab"><i class="fa fa-user"></i> MLC</a></li>
		<li role="presentation"><a href="#clinical" aria-controls="clinical" role="tab" data-toggle="tab"><i class="fa fa-stethoscope"></i> Clinical</a></li>
		<li role="presentation"><a href="#diagnostics" aria-controls="diagnostics" role="tab" data-toggle="tab"><i class="glyph-icon flaticon-chemistry20"></i> Diagnostics</a></li>
		<li role="presentation"><a href="#procedures" aria-controls="procedures" role="tab" data-toggle="tab"><i class="fa fa-scissors"></i> Procedures</a></li>
		<li role="presentation"><a href="#prescription" aria-controls="prescription" role="tab" data-toggle="tab"><i class="glyph-icon flaticon-drugs5"></i> Prescription</a></li>
		<li role="presentation"><a href="#discharge" aria-controls="discharge" role="tab" data-toggle="tab"><i class="fa fa-sign-out"></i> Discharge</a></li>
	  </ul>
	  <!-- Tab panes -->
	  <div class="tab-content">
		<div role="tabpanel" class="tab-pane active" id="patient">
			<?php
				$patient = $patients[0];
				$age="";
				if($patient->age_years!=0) $age.=$patient->age_years."Y ";
				if($patient->age_months!=0) $age.=$patient->age_months."M ";
				if($patient->age_days!=0) $age.=$patient->age_days."D ";
			?>
			
		<iframe id="ifmcontentstoprint" style="height: 0px; width: 0px; position: absolute;display:none"></iframe>
		<div class="sr-only" id="print-div" style="width:100%;height:100%;"> 
		<?php $this->load->view('pages/print_layouts/patient_summary');?>
		</div>
			<div class="col-md-4 col-lg-3">
				<div class="well well-sm text-center">
				<img src="<?php echo base_url()."assets/images/patients/".$patient->patient_id;?>.jpg" alt="Image" style="width:50%;height:50%" onError="this.onerror=null;this.src='<?php echo base_url()."assets/images/patients/default.png";?>';" />
				</div>
			</div>
			<div class="col-md-8">
			<div class="row alt">
			<div class="col-md-4 col-xs-12 col-lg-3">
				<b><?php echo $patient->visit_type;?> Number: </b><?php echo $patient->hosp_file_no;?>
			</div>
			<div class="col-md-4 col-xs-12 col-lg-3">
				<b>Patient Name: </b><?php echo $patient->first_name." ".$patient->last_name;?>
			</div>
			<div class="col-md-4 col-xs-12 col-lg-3">
				<b>Age/ Gender: </b><?php echo $age."/ ".$patient->gender;?>
			</div>
			</div>
			
			<div class="row alt">
			<div class="col-md-4 col-xs-12 col-lg-3">
				<b>Parent/ Spouse: </b><?php echo $patient->parent_spouse;?>
			</div>
			<div class="col-md-4 col-xs-12 col-lg-3">
				<b>Address: </b><?php 
				if(!!$patient->address) echo $patient->address;
				if(!!$patient->address && !!$patient->place) echo ", ";
				if(!!$patient->place) echo $patient->place;;?>
			</div>
			<div class="col-md-4 col-xs-12 col-lg-3">
				<b>District<?php if(!!$patient->state) echo ", State"?>: </b><?php echo $patient->district; if(!!$patient->state) echo ", ".$patient->state;?>
			</div>
			</div>
			</div>
			<div class="col-md-12">
			<div class="row alt">
			<div class="col-md-4 col-xs-12 col-lg-3">
				<b>Phone: </b><?php if(!!$patient->phone) echo $patient->phone;?>
			</div>
			
			</div>
			<div class="row alt">
			<div class="col-md-4 col-xs-12 col-lg-3">
				<b>ID Proof: </b>
				<?php 
					echo $patient->id_proof_type; if(!!$patient->id_proof_number) $patient->id_proof_number;
				?>
			</div>
			<div class="col-md-4 col-xs-12 col-lg-3">
				<b>Occupation: </b><?php echo $patient->occupation;?>
			</div>
			</div>
			</div>
		</div>
              <div role="tabpanel" class="tab-pane" id="patient_visit">
                  <div class="row alt">
			<div class="col-md-4 col-xs-12 col-lg-3">
				<b><?php if( $patient->visit_type == "IP") echo "Admit Date:"; else echo "Visit Date:";?></b>
				<?php echo date("d-M-Y", strtotime($patient->admit_date)).", ".date("g:ia", strtotime($patient->admit_time));?>
			</div>
			<div class="col-md-4 col-xs-12 col-lg-3">
				<b>Department: </b><?php echo $patient->department;?>
			</div>
			<div class="col-md-4 col-xs-12 col-lg-3">
				<b>Unit/Area: </b><?php echo $patient->unit_name."/".$patient->area_name;?>
			</div>
		  </div>
                  <div class="row alt">
                  <div class="col-md-4 col-xs-12 col-lg-3">
				<b>Presenting Complaint: </b><?php echo $patient->presenting_complaints;?>
                  </div>
                  </div>
              </div>
              <div role="tabpanel" class="tab-pane" id="mlc">
                  <div class="row alt">
                  <div class="col-md-4 col-xs-12 col-lg-3">
				<b>MLC: </b><?php if($patient->mlc) echo "Yes"; else echo "No";?>
			</div>
			<?php if($patient->mlc){ ?>
				<div class="col-md-4 col-xs-12 col-lg-3">
					<b>PS Name: </b><?php if(!!$patient->ps_name) echo $patient->ps_name;?>
				</div>
                <?php } ?>
                  </div>
              </div>
		<div role="tabpanel" class="tab-pane" id="clinical">
			<div class="row alt">
				<div class="col-md-4 col-xs-6">
					<label class="control-label">Admit Weight</label>
					<?php if(!!$patient->admit_weight) echo $patient->admit_weight;?>
				</div>
				<div class="col-md-4 col-xs-6">
					<label class="control-label">Pulse Rate</label>
					<?php if(!!$patient->pulse_rate)  echo $patient->pulse_rate;?>
				</div>
				<div class="col-md-4 col-xs-6">
					<label class="control-label">Temperature</label>
					<?php if(!!$patient->temperature)  echo $patient->temperature;?>
				</div>
			</div>
			<div class="row alt">
				<div class="col-md-4 col-xs-6">
					<label class="control-label">Blood Group</label>					
					<?php if(!!$patient->blood_group)  echo $patient->blood_group;?>

				</div>
				<div class="col-md-4 col-xs-6">
					<label class="control-label">Blood Pressure</label>
					<?php if(!!$patient->sbp) echo $patient->sbp;?>/
					<?php if(!!$patient->dbp) echo $patient->dbp;?>
				</div>
				<div class="col-md-4 col-xs-6">
					<label class="control-label">Respiratory Rate</label>
					<?php if(!!$patient->respiratory_rate) echo $patient->respiratory_rate;?>
				</div>
			</div>
			<div class="row alt">
				<div class="col-md-12 col-xs-12">
					<label class="control-label">
						Symptoms
					</label>
					<?php echo $patient->presenting_complaints;?>
				</div>
			</div>
			<div class="row alt">
				<div class="col-md-12 col-xs-12">
					<label class="control-label">
						Past History
					</label>
					<?php echo $patient->past_history;?>
				</div>
			</div>
			<div class="row alt">
				<div class="col-md-12 col-xs-12">
					<label class="control-label">
						Family History
					</label>
					<?php echo $patient->family_history;?>
				</div>
			</div>
			<div class="row alt">
				<div class="col-md-12 col-xs-12">
					<label class="control-label">
						Clinical Findings
					</label>
					<?php echo $patient->clinical_findings;?>
				</div>
			</div>
			<div class="row alt">
				<div class="col-md-12 col-xs-12">
					<label class="control-label">
						CVS
					</label>
					<?php echo $patient->cvs;?>
				</div>
			</div>
			<div class="row alt">
				<div class="col-md-12 col-xs-12">
					<label class="control-label">
						RS
					</label>
					<?php echo $patient->rs;?>
				</div>
			</div>
			<div class="row alt">
				<div class="col-md-12 col-xs-12">
					<label class="control-label">
						PA
					</label>
					<?php echo $patient->pa;?>
				</div>
			</div>
			<div class="row alt">
				<div class="col-md-12 col-xs-12">
					<label class="control-label">
						CNS
					</label>
					<?php echo $patient->cns;?>
				</div>
			</div>
			<?php 
				if(isset($visit_notes) && !!$visit_notes){ ?>
			<div class="row alt">
					<div class="col-md-12 col-xs-12">
						
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th colspan="4">Clinical Notes</th>
								</tr>
								<tr>
									<th>#</th>
									<th>Date</th>
									<th>Note</th>
									<th>Added by</th>
								</tr>
							</thead>
							<tbody>
							<?php
							$i=1;
							 foreach($visit_notes as $note){ ?>
								<tr>
									<td><?php echo $i++; ?></td>
									<td><?php if($note->note_time!=0) echo date("d-M-Y g:iA",strtotime($note->note_time)); ?></td>
									<td><?php echo $note->clinical_note;?></td>
									<td><?php echo $note->first_name." ".$note->last_name;?></td>
								</tr>
								<?php  } ?>
							</tbody>
						</table>
				</div>
			</div>
				<?php
					}
				?>
			</div>
		<div role="tabpanel" class="tab-pane" id="diagnostics">
			
			<?php 
			if(isset($tests) && count($tests)>0){ ?>
				<table class="table table-bordered table-striped table-hover" id="table-sort">
				<thead>
					<th style="width:3em">#</th>
					<th style="width:10em">Order ID</th>
					<th style="width:10em">Order Date</th>
					<th style="width:10em">Specimen</th>
					<th style="width:12em">Test</th>
					<th style="width:10em">Value</th>
					<th style="width:5em">Report - Binary</th>
					<th style="width:10em">Report</th>
				</thead>
				<tbody>
					<?php 
					$o=array();
					foreach($tests as $order){
						$o[]=$order->order_id;
					}
					$o=array_unique($o);
					$i=1;
					foreach($o as $ord){	?>
						<?php
						foreach($tests as $order) { 
							if($order->order_id == $ord) { ?>
						<tr <?php if($order->test_status == 2) { ?> onclick="$('#order_<?php echo $ord;?>').submit()" <?php } ?>>
								<td><?php echo $i++;?></td>
								<td>
									<?php echo form_open("diagnostics/view_results",array('role'=>'form','class'=>'form-custom','id'=>'order_'.$order->order_id)); ?>
									<?php echo $order->order_id;?>
									<input type="hidden" class="sr-only" name="order_id" value="<?php echo $order->order_id;?>" />
									</form>
								</td>
								<td>
									<?php echo date("d-M-Y",strtotime($order->order_date_time));?>
								</td>
								<td><?php echo $order->specimen_type;?></td>
								<td>
								<?php
													if($order->test_status==1){
														$label="label-warning"; $status="Completed"; }
													else if($order->test_status == 2){ $label = "label-success"; $status = "Approved"; }
													else if($order->test_status == 0){ $label = "label-default"; $status = "Ordered"; }
													echo '<label class="label '.$label.'" title="'.$status.'">'.$order->test_name."</label><br />";									
									?>
								</td>
								<td>
									<?php if($order->test_status==2 && $order->numeric_result == 1) echo $order->test_result." ".$order->lab_unit; else echo "NA";?>
								</td>
								<td>
									<?php if($order->test_status==2 && $order->binary_result == 1) echo $order->test_result_binary; else echo "NA";?>
								</td>
								<td>
									<?php if($order->test_status==2 && $order->text_result == 1) echo $order->test_result_text; else echo "NA";?>
								</td>
						</tr>
						<?php
						}
						} ?>
					<?php } ?>
				</tbody>
				</table>
				
			<?php } else { ?>
			No tests on the given date.
			<?php } ?>
		</div>
		<div role="tabpanel" class="tab-pane" id="prescription">
			<div class="row alt">
				<?php if(isset($prescription) && !!$prescription){ ?>
					<table class="table table-bordered table-striped">
					<thead>
						<tr>
						<th rowspan="3" class="text-center">Drug</th>
						<th rowspan="3" class="text-center">Duration</th>
					<!--	<th rowspan="3" class="text-center">Frequency</th> -->
						<th colspan="6" class="text-center">Timings</th>
						<th rowspan="3" class="text-center">Quantity</th>
						<th rowspan="3" class="text-center"></th>
						</tr>
						<tr>
							<th colspan="2" class="text-center">Morning</th>
							<th colspan="2" class="text-center">Afternoon</th>
							<th colspan="2" class="text-center">Evening</th>
						</tr>
						<tr>
							<th>BB</th>
							<th>AB</th>
							<th>BL</th>
							<th>AL</th>
							<th>BD</th>
							<th>AD</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($prescription as $pres){ ?>
						<?php							
							$available = $pres->item_name.' - '.$pres->item_form;
							$style = '';
							if(drug_available($pres, $drugs_available)){
								$available .= ' - Available';
								$style = "style='background: #6DF48F;'";
							}						
						?>
					<tr>
						<td><?php echo $available;?></td>
						<td><?php echo $pres->duration;?></td>
						<!--<td><?php echo $pres->frequency;?></td>-->
						<td><?php if($pres->morning == 1 || $pres->morning == 3) echo "<i class='fa fa-check'></i>";?></td>
						<td><?php if($pres->morning == 2 || $pres->morning == 3) echo " <i class='fa fa-check'></i>";?></td>
						<td><?php if($pres->afternoon == 1 || $pres->afternoon == 3) echo "<i class='fa fa-check'></i>";?></td>
						<td><?php if($pres->afternoon == 2 || $pres->afternoon == 3) echo "<i class='fa fa-check'></i>";?></td>
						<td><?php if($pres->evening == 1 || $pres->evening == 3) echo "<i class='fa fa-check'></i>";?></td>
						<td><?php if($pres->evening == 2 || $pres->evening == 3) echo "<i class='fa fa-check'></i>";?></td>
						<td><?php echo $pres->quantity;?> <?php echo $pres->lab_unit;?></td>
						<td>
							<?php echo form_open('register/update_patients',array('class'=>'form-custom'));?>
							<input type="text" class="sr-only" value="<?php echo $pres->prescription_id;?>" name="prescription_id" hidden />
							<input type="text" class="sr-only" value="<?php echo $pres->visit_id;?>" name="visit_id" hidden />
							<button type="submit" id="remove_prescription" class="btn btn-danger btn-sm">X</button>
							</form>
						</td>
					</tr>
					<?php } ?>
					</tbody>
				</table>
			<?php }
			else echo "No Prescriptions";?>
			</div>
		</div>
		<div role="tabpanel" class="tab-pane" id="discharge">
			<div class="row">
			<div class="col-md-12 alt">
				<div class="col-md-2">
				<label class="control-label">Outcome</label>
				</div>
				<div class="col-md-8">
					<?php if(!!$patient->outcome) echo $patient->outcome;?>
				</div>
			</div>
			<div class="col-md-12 alt">
				<div class="col-md-2">
				<label>Outcome Date</label>
				</div>
				<div class="col-md-8">
				<?php if($patient->outcome_date!=0) echo date("d-M-Y",strtotime($patient->outcome_date));?>
				</div>
			</div>
			<div class="col-md-12 alt">
				<div class="col-md-2">
				<label class="control-label">Outcome Time</label>
				</div>
				<div class="col-md-8">
				<?php if($patient->outcome_time != 0) echo date("g:ia",strtotime($patient->outcome_time));?>
				</div>
			</div>
			<div class="col-md-12 alt ">
				<div class="col-md-2">
				<label class="control-label">Final Diag.</label>
				</div>
				<div class="col-md-8">
				<?php if(!!$patient->final_diagnosis) echo $patient->final_diagnosis;?>
				</div>
			</div>
			<div class="col-md-12 alt ">
				<div class="col-md-2">
				<label class="control-label">Decision</label>
				</div>
				<div class="col-md-8">
				<?php if(!!$patient->decision) echo $patient->decision;?>
				</div>
			</div>
			<div class="col-md-12 alt ">
				<div class="col-md-2">
				<label class="control-label">Advise</label>
				</div>
				<div class="col-md-8">
				<?php if(!!$patient->advise) echo $patient->advise;?>
				</div>
			</div>
			<div class="col-md-12 alt">	
				<div class="col-md-2">
					<label>ICD Code</label>
				</div>
				<div class="col-md-8">
					<?php if(!!$patient->icd_10) echo $patient->icd_10." - ".$patient->code_title;?>
				</div>
				</div>
			</div>
		</div>
	  </div>
			<div class="col-md-12 text-center">
				<button class="btn btn-md btn-warning" value="Print" type="button" onclick="printDiv('print-div')">Print Summary</button>
				<?php 
			$visits = sizeof($patient_visits);
		?>
		<button class="btn btn-md btn-warning" value="Print" type="button" onclick="printDiv('print-div-all')">(<?php echo $visits; ?>)-Print Summary All Visits</button>
			</div>
		</div>
	</div>
	<?php if(!!$previous_visits){ ?>
		<table class="table table-bordered table-striped">
			<thead>
			<th>Date</th>
			<th>Hospital</th>
			<th>Type</th>
			<th>Number</th>
			<th>Department</th>
			<th>Unit/Area</th>
			<th>Outcome</th>
			<th>Outcome Date</th>
			</thead>
			<tbody>
			<?php foreach($previous_visits as $visit){ ?>
				<tr onclick="$('#select_visit_<?php echo $visit->visit_id;?>').submit()" style="cursor:pointer">
					<td>
						<?php echo form_open('register/view_patients',array('role'=>'form','id'=>'select_visit_'.$visit->visit_id));?>
						<input type="text" class="sr-only" hidden value="<?php echo $visit->visit_id;?>" name="selected_patient" />
						<input type="text" class="sr-only" hidden value="<?php echo $visit->patient_id;?>" name="patient_id" />
						</form>
					<?php 
					if($visit->visit_id == $patient->visit_id) echo "<i class='fa fa-eye'></i> ";?>
					<?php echo date("d-M-Y",strtotime($visit->admit_date));?>
					</td>
					<td><?php echo $visit->hospital;?></td>
					<td><?php echo $visit->visit_type;?></td>
					<td><?php echo $visit->hosp_file_no;?></td>
					<td><?php echo $visit->department;?></td>
					<td><?php echo $visit->unit_name."/".$visit->area_name;?></td>
					<td><?php echo $visit->outcome;?></td>
					<td><?php if($visit->outcome_date!=0) echo date("d-M-Y",strtotime($visit->outcome_date));?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	<?php }
	}
	else if(isset($patients)){
		echo "No patients found with the given search terms";
	}
	?>
	
	<div class="row">
		<div class="panel panel-default">
		<div class="panel-heading">
		<h4>Search Patients</h4>	
		</div>
		<div class="panel-body">
		<?php echo form_open("register/view_patients",array('role'=>'form','class'=>'form-custom')); ?>
					<div class="row">
					<div class="col-md-12 col-xs-12">
						<div class="form-group">

						<label class="control-label">H4A ID</label>
						<input type="text" name="search_patient_id" size="5" class="form-control" />
						<label class="control-label">Year</label>
						<select class="form-control" name="search_year">
							<?php 
								$i=2013;
								$year = date("Y");
								while($year>=$i){ ?>
								<option value="<?php echo $year;?>"><?php echo $year--;?></option>
							<?php
								}
							?>
						</select>
						</div>
						<div class="form-group">
							<label class="control-label">Visit Type</label>
							<select class="form-control" name="search_visit_type">
								<option value=''>All</option>
								<option value='IP'>IP</option>
								<option value='OP'>OP</option>
							</select>
						<label class="control-label">IP/OP Number</label>
						<input type="text" name="search_patient_number" size="5" class="form-control" />
						</div>
					<!--	<div class="form-group">
						<label class="control-label">Patient Name</label>
						<input type="text" name="search_patient_name" class="form-control" />
						</div> -->
						<div class="form-group">
						<label class="control-label">Phone Number</label>
						<input type="text" name="search_phone" class="form-control" />
						</div>
					</div>
				</div>
		</div>
		<div class="panel-footer">
			<div class="text-center">
			<input class="btn btn-sm btn-primary" type="submit" value="Submit" />
			</div>
			</form>
		</div>
		</div>
	</div>
	<br />

<script type="text/javascript">
	$(function(){
		$("#patient_barcode").barcode(
			"<?php echo $patient->patient_id;?>",
			"ean13"
		);
	});
</script>
<div class="sr-only" id="print-div-all" style="width:100%;height:100%;"> 
	<?php $this->load->view('pages/print_layouts/patient_summary_all_visits');?>
</div>
