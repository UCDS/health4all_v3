<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript">
$(function(){
	$("#from_date,#to_date").Zebra_DatePicker();
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
</script>
	<?php 
	$from_date=0;$to_date=0;
	if($this->input->post('from_date')) $from_date=date("Y-m-d",strtotime($this->input->post('from_date'))); else $from_date = date("Y-m-d");
	if($this->input->post('to_date')) $to_date=date("Y-m-d",strtotime($this->input->post('to_date'))); else $to_date = date("Y-m-d");
	if($this->input->post('date_type_selection')){
		$date_type = $this->input->post('date_type_selection');
	}
	else{
		$date_type = "admit_date";
	}
	if($this->input->post('visit_name')){
		$visit_name = $this->input->post('visit_name');
	}
	else{
		$visit_name = "0";
	}
	?>
	<div class="row">
		<h4>Outcome- Summary Report</h4>	
		<?php echo form_open("reports/outcome_summary",array('role'=>'form','class'=>'form-custom')); ?>
					From Date : <input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($from_date)); ?>" name="from_date" id="from_date" size="15" />
					To Date : <input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($to_date)); ?>" name="to_date" id="to_date" size="15" />

                    
					<select name="department" id="department" class="form-control">
					<option value="">Department</option>
					<?php 
					foreach($all_departments as $dept){
						echo "<option value='".$dept->department_id."'";
						if($this->input->post('department') && $this->input->post('department') == $dept->department_id) echo " selected ";
						echo ">".$dept->department."</option>";
					}
					?>
					</select>
					<select name="unit" id="unit" class="form-control" >
					<option value="">Unit</option>
					<?php 
					foreach($units as $unit){
						echo "<option value='".$unit->unit_id."' class='".$unit->department_id."'";
						if($this->input->post('unit') && $this->input->post('unit') == $unit->unit_id) echo " selected ";
						echo ">".$unit->unit_name."</option>";
					}
					?>
					</select>
					<select name="area" id="area" class="form-control" >
					<option value="">Area</option>
					<?php 
					foreach($areas as $area){
						echo "<option value='".$area->area_id."' class='".$area->department_id."'";
						if($this->input->post('area') && $this->input->post('area') == $area->area_id) echo " selected ";
						echo ">".$area->area_name."</option>";
					}
					?>
					</select>
					<select name="visit_name" id="visit_name" class="form-control" >
					<option value="">All</option>
					<?php 
					foreach($visit_names as $v){
						echo "<option value='".$v->visit_name_id."'";
						if($this->input->post('visit_name') && $this->input->post('visit_name') == $v->visit_name_id) echo " selected ";
						echo ">".$v->visit_name."</option>";
					}
					?>
					</select>
					<select name="outcome_type" id="outcome_type" class="form-control" >
					<option value="">All</option>
					<option value="Discharge" 
					<?php if($this->input->post('outcome_type') && $this->input->post('outcome_type') == "Discharge") echo " selected ";?>
					>Discharge</option>
					<option value="LAMA"
					<?php if($this->input->post('outcome_type') && $this->input->post('outcome_type') == "LAMA") echo " selected ";?>
					>LAMA</option>
					<option value="Absconded"
					<?php if($this->input->post('outcome_type') && $this->input->post('outcome_type') == "Absconded") echo " selected ";?>					
					>Absconded</option>
					<option value="Death"
					<?php if($this->input->post('outcome_type') && $this->input->post('outcome_type') == "Death") echo " selected ";?>					
					>Death</option>
					<option value="Unupdated"
					<?php if($this->input->post('outcome_type') && $this->input->post('outcome_type') == "Unupdated") echo " selected ";?>					
					>Unupdated</option>
					</select>
                    <select name="date_type_selection" id="date_type_selection" class="form-control">
                        <option value="admit_date" selected>Admit date</option>
                        <option value="outcome_date">Outcome Date</option>
                    </select>
					<input class="btn btn-sm btn-primary" type="submit" value="Submit" />
		</form>
	<br />
	<?php if(isset($report) && count($report)>0){ ?>
	
		<button type="button" class="btn btn-default btn-md print">
		  <span class="glyphicon glyphicon-print"></span> Print
		</button>
	<table class="table table-bordered table-striped" id="table-sort">
	<thead>
	<tr>
		<th style="text-align:center" rowspan="2">Department</th>
		<?php if($this->input->post('outcome_type')){ ?>
        <th style="text-align:center" colspan="3"><?php echo $this->input->post('outcome_type'); ?></th>
		<?php } 
		else { ?>
        <th style="text-align:center" colspan="3">Discharge</th>
        <th style="text-align:center" colspan="3">LAMA</th>
        <th style="text-align:center" colspan="3">Absconded</th>
        <th style="text-align:center" colspan="3">Death</th>
        <th style="text-align:center" colspan="3">Unupdated records</th>
		<?php } ?>
        <th style="text-align:center" colspan="3">Total Visits</th>
    </tr>
    <tr>
		<?php if($this->input->post('outcome_type')){ ?>
        <th>Male</th><th>Female</th><th>Total</th>
		<?php } 
		else { ?>
        <th>Male</th><th>Female</th><th>Total</th>
        <th>Male</th><th>Female</th><th>Total</th>
        <th>Male</th><th>Female</th><th>Total</th>
        <th>Male</th><th>Female</th><th>Total</th>
        <th>Male</th><th>Female</th><th>Total</th>
		<?php } ?>
		<th>Male</th><th>Female</th><th>Total</th>
	</tr>
	
	</thead>
	<tbody>
	<?php 
    $total_female_discharge=0;
    $total_male_discharge=0;
    $total_discharge=0;
    $total_female_lama=0;
    $total_male_lama=0;
    $total_lama=0;
    $total_female_absconded=0;
    $total_male_absconded=0;
    $total_absconded=0;
    $total_female_death=0;
    $total_male_death=0;
    $total_death=0;
    $total_female=0;
    $total_male_unupdated=0;
    $total_female_unupdated=0;
    $total_unupdated=0;
	$total_male=0;	
	$total_outcome=0;
	$outcome_types = array('Discharge','LAMA','Absconded','Death','Unupdated');
	foreach($report as $s){
	?>
	<tr>
		<td><?php echo $s->department;?></td>
		<?php 
			if($this->input->post('outcome_type')){ 
			$outcome = $this->input->post('outcome_type'); 
		?>
        <td class="text-right">
			<a href="<?php echo base_url()."reports/outcome_detail/$s->department_id/$s->unit/$s->area/M/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome"?>">
			<?php echo $s->{'male_'.strtolower($this->input->post('outcome_type'))};?>
			</a>
		</td>
        <td class="text-right">
			<a href="<?php echo base_url()."reports/outcome_detail/$s->department_id/$s->unit/$s->area/F/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome"?>">
			<?php echo $s->{'female_'.strtolower($this->input->post('outcome_type'))};?>
			</a>
		</td>
        <td class="text-right">
			<a href="<?php echo base_url()."reports/outcome_detail/$s->department_id/$s->unit/$s->area/0/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome"?>">
			<?php echo $s->{'total_'.strtolower($this->input->post('outcome_type'))};?>
			</a>
		</td>
		<?php } 
		else {
			foreach($outcome_types as $outcome) { ?>
			
			<td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/$s->department_id/$s->unit/$s->area/M/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome"?>">
				<?php echo $s->{'male_'.strtolower($outcome)};?>
				</a>
			</td>
			<td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/$s->department_id/$s->unit/$s->area/F/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome"?>">
				<?php echo $s->{'female_'.strtolower($outcome)};?>
				</a>
			</td>
			<td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/$s->department_id/$s->unit/$s->area/0/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome"?>">
				<?php echo $s->{'total_'.strtolower($outcome)};?>
				</a>
			</td>
		<?php }
		} ?>
		
		<td class="text-right">
			<a href="<?php echo base_url()."reports/outcome_detail/$s->department_id/$s->unit/$s->area/M/0/0/$from_date/$to_date/$visit_name/$date_type/"?>">
			<?php echo $s->outcome_male;?>
			</a>
		</td>
		<td class="text-right">
			<a href="<?php echo base_url()."reports/outcome_detail/$s->department_id/$s->unit/$s->area/F/0/0/$from_date/$to_date/$visit_name/$date_type/"?>">
			<?php echo $s->outcome_female;?>
			</a>
		</td>
		<td class="text-right">
			<a href="<?php echo base_url()."reports/outcome_detail/$s->department_id/$s->unit/$s->area/0/0/0/$from_date/$to_date/$visit_name/$date_type/"?>">
			<?php echo $s->outcome;?>
			</a>
		</td>
	</tr>
	<?php if($this->input->post('outcome_type')){ 
	${'total_female_'.strtolower($this->input->post('outcome_type'))}+=$s->{'female_'.strtolower($this->input->post('outcome_type'))};
	${'total_male_'.strtolower($this->input->post('outcome_type'))}+=$s->{'male_'.strtolower($this->input->post('outcome_type'))};
	${'total_'.strtolower($this->input->post('outcome_type'))}+=$s->{'total_'.strtolower($this->input->post('outcome_type'))};
	}
	else {
		foreach($outcome_types as $outcome) {			
			${'total_female_'.strtolower($outcome)}+=$s->{'female_'.strtolower($outcome)};
			${'total_male_'.strtolower($outcome)}+=$s->{'male_'.strtolower($outcome)};
			${'total_'.strtolower($outcome)}+=$s->{'total_'.strtolower($outcome)};
		}
	}
    $total_female+=$s->outcome_female;
	$total_male+=$s->outcome_male;	
	$total_outcome+=$s->outcome;
	}
	?>
	</tbody>
	<tbody class="tablesorter-no-sort">
        <tr>
		    <th>Total </th>
			<?php if(strtolower($this->input->post('outcome_type'))){ ?>	
		    <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/0/0/0/M/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome"?>">
				<?php echo ${'total_male_'.strtolower($this->input->post('outcome_type'))};?>
				</a>
			</td>
            <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/0/0/0/F/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome"?>">
				<?php echo ${'total_female_'.strtolower($this->input->post('outcome_type'))};?>
				</a>
			</td>
            <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/0/0/0/0/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome"?>">
				<?php echo ${'total_'.strtolower($this->input->post('outcome_type'))};?>
				</a>
			</td>
			<?php } 
			else { 
				foreach($outcome_types as $outcome) { 
			?>
		    <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/0/0/0/M/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome"?>">
				<?php echo ${'total_male_'.strtolower($outcome)};?>
				</a>
			</td>
            <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/0/0/0/F/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome"?>">
				<?php echo ${'total_female_'.strtolower($outcome)};?>
				</a>
			</td>
            <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/0/0/0/0/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome"?>">
				<?php echo ${'total_'.strtolower($outcome)};?>
				</a>
			</td>
			<?php }
			} ?>
		    <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/0/0/0/M/0/0/$from_date/$to_date/$visit_name/$date_type"?>">
				<?php echo $total_male;?>
				</a>
			</td>
            <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/0/0/0/F/0/0/$from_date/$to_date/$visit_name/$date_type"?>">
				<?php echo $total_female;?>
				</a>
			</td>
            <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/0/0/0/0/0/0/$from_date/$to_date/$visit_name/$date_type"?>">
				<?php echo $total_outcome;?>
				</a>
			</td>
        </tr>
        <tr>
            <th>Percentage of total</th>
			<?php if(strtolower($this->input->post('outcome_type'))){ ?>	
		    <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/0/0/0/M/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome"?>">
				<?php echo round((${'total_male_'.strtolower($this->input->post('outcome_type'))}/$total_outcome)*100)."%";?>
				</a>
			</td>
		    <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/0/0/0/F/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome"?>">
				<?php echo round((${'total_female_'.strtolower($this->input->post('outcome_type'))}/$total_outcome)*100)."%";?>
				</a>
			</td>
		    <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/0/0/0/0/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome"?>">
				<?php echo round((${'total_'.strtolower($this->input->post('outcome_type'))}/$total_outcome)*100)."%";?>
				</a>
			</td>
			<?php } 
			else { 
				foreach($outcome_types as $outcome) { ?>
				<td class="text-right">
					<a href="<?php echo base_url()."reports/outcome_detail/0/0/0/M/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome"?>">
					<?php echo round((${'total_male_'.strtolower($outcome)}/$total_outcome)*100).'%';?>
					</a>
				</td>
				<td class="text-right">
					<a href="<?php echo base_url()."reports/outcome_detail/0/0/0/F/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome"?>">
					<?php echo round((${'total_female_'.strtolower($outcome)}/$total_outcome)*100).'%';?>
					</a>
				</td>
				<td class="text-right">
					<a href="<?php echo base_url()."reports/outcome_detail/0/0/0/0/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome"?>">
					<?php echo round((${'total_'.strtolower($outcome)}/$total_outcome)*100).'%';?>
					</a>
				</td>
			<?php 
				}
			} ?>
		    <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/0/0/0/M/0/0/$from_date/$to_date/$visit_name/$date_type"?>">
				<?php echo round(($total_male/$total_outcome)*100).'%';?>
				</a>
			</td>
		    <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/0/0/0/F/0/0/$from_date/$to_date/$visit_name/$date_type"?>">
				<?php echo round(($total_female/$total_outcome)*100).'%';?>
				</a>
			</td>
		    <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/0/0/0/0/0/0/$from_date/$to_date/$visit_name/$date_type"?>">
				<?php echo round(($total_outcome/$total_outcome)*100).'%';?>
				</a>
			</td>
        </tr>
	</tbody>
	</table>
	<?php } else { ?>
	No patient registrations on the given date.
	<?php } ?>
	</div>