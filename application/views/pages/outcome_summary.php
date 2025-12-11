<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.selectize.js"></script>
<link rel="stylesheet" type="text/css"href="<?php echo base_url(); ?>assets/css/selectize.css">
<style type="text/css">
	.selectize-control.repositories .selectize-dropdown>div {
	border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.selectize-control.repositories .selectize-dropdown .by {
	font-size: 11px;
	opacity: 0.8;
}

.selectize-control.repositories .selectize-dropdown .by::before {
	content: 'by ';
}

.selectize-control.repositories .selectize-dropdown .name {
	font-weight: bold;
	margin-right: 5px;
}

.selectize-control.repositories .selectize-dropdown .title {
	display: block;
}

.selectize-control.repositories .selectize-dropdown .description {
	font-size: 12px;
	display: block;
	color: #a0a0a0;
	white-space: nowrap;
	width: 100%;
	text-overflow: ellipsis;
	overflow: hidden;
}

.selectize-control.repositories .selectize-dropdown .meta {
	list-style: none;
	margin: 0;
	padding: 0;
	font-size: 10px;
}

.selectize-control.repositories .selectize-dropdown .meta li {
	margin: 0;
	padding: 0;
	display: inline;
	margin-right: 10px;
}

.selectize-control.repositories .selectize-dropdown .meta li span {
	font-weight: bold;
}

.selectize-control.repositories::before {
	-moz-transition: opacity 0.2s;
	-webkit-transition: opacity 0.2s;
	transition: opacity 0.2s;
	content: ' ';
	z-index: 2;
	position: absolute;
	display: block;
	top: 12px;
	right: 34px;
	width: 16px;
	height: 16px;
	background: url(<?php echo base_url(); ?> assets /images/spinner.gif);
	background-size: 16px 16px;
	opacity: 0;
}

.selectize-control.repositories.loading::before {
	opacity: 0.4;
}

.selectize-control.repositories .selectize-dropdown > div {
	border-bottom: 1px solid rgba(0,0,0,0.05);
}
.selectize-control {
	display: inline-grid;
} 
</style>
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

<script>
	$(document).ready(function() {
	
	$("#icd_block").chained("#icd_chapter");
	
	$('#icd_code').selectize({
    valueField: 'code_title',
    labelField: 'code_title',
    searchField: 'code_title',
    create: false,
    render: {
        option: function(item, escape) {

            return '<div>' +
                '<span class="title">' +
                    '<span class="icd_code">' + escape(item.code_title) + '</span>' +
                '</span>' +
            '</div>';
        }
    },
    load: function(query, callback) {
        if (!query.length) return callback();
		$.ajax({
            url: '<?php echo base_url();?>register/search_icd_codes',
            type: 'POST',
			dataType : 'JSON',
			data : {query:query,block:$("#icd_block").val(),chapter:$("#icd_chapter").val()},
            error: function(res) {
                callback();
            },
            success: function(res) {
                callback(res.icd_codes.slice(0, 10));
            }
        });
    }
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
		<h4>Outcome Summary - IP</h4>	
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
					<select name="date_type_selection" id="date_type_selection" class="form-control">
                        <option <?php if($this->input->post('date_type_selection') && $this->input->post('date_type_selection') == "admit_date") echo " selected ";?> value="admit_date" selected>Admit date</option>
                        <option <?php if($this->input->post('date_type_selection') && $this->input->post('date_type_selection') == "outcome_date") echo " selected ";?> value="outcome_date">Outcome Date</option>
                    </select>
					<div style="margin-top:10px;">
						<select name="icd_chapter" id="icd_chapter" class="form-control" style="width:330px;" >
							<option value="">ICD Chapter</option>
							<?php 
								foreach($icd_chapters as $v){
									echo "<option value='".$v->chapter_id."'";
									if($this->input->post('icd_chapter') && $this->input->post('icd_chapter') == $v->chapter_id) echo " selected ";
									echo ">".$v->chapter_id." - ".$v->chapter_title."</option>";
								}
							?>
						</select>
						<select name="icd_block" id="icd_block" class="form-control" style="width:345px;" >
							<option value="">ICD Block</option>
							<?php 
								foreach($icd_blocks as $v){
									echo "<option value='".$v->block_id."' class='".$v->chapter_id."' ";
										if($this->input->post('icd_block') && $this->input->post('icd_block') == $v->block_id) echo " selected ";
										echo ">".$v->block_id." - ".$v->block_title."</option>";
								}
							?>
						</select>

						<select id="icd_code" class="repositories" style="width:345px;display:inline;" placeholder="Select ICD Code.." name="icd_code" >
							<?php if($this->input->post('icd_code')) { ?>
								<option value="<?php echo $this->input->post('icd_code');?>"><?php echo $this->input->post('icd_code');?></option>
							<?php } ?>
						</select>
						<!-- <select name="visit_name" id="visit_name" class="form-control" >
						<option value="">All</option>
						<?php 
						foreach($visit_names as $v){
							echo "<option value='".$v->visit_name_id."'";
							if($this->input->post('visit_name') && $this->input->post('visit_name') == $v->visit_name_id) echo " selected ";
							echo ">".$v->visit_name."</option>";
						}
						?>
						</select> -->
						<select name="outcome_type" id="outcome_type" class="form-control" >
						<option value="">All Outcomes</option>
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
                    </div>
					<div style="margin-top:10px;">
						<input class="btn btn-sm btn-primary" type="submit" value="Submit" />
					</div>
		</form>
	<br />
	<?php if(isset($report) && count($report)>0){ ?>

		<!-- added 23rd January 2023 start-->
		<div style='padding: 0px 2px;'>
		
	    <h5>Report as on <?php echo date("j-M-Y h:i A"); ?></h5>
	    </div>
	    <!-- added 23rd January 2023 end-->
	
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
	$icd_chapter = $this->input->post('icd_chapter'); 
	$icd_block = $this->input->post('icd_block'); 
	$icd_code = $this->input->post('icd_code'); 
	if ($icd_code) {
		$icd_code = strtok($icd_code, " ");
		$this->db->where('icd_code.icd_code', $icd_code);
	}
	foreach($report as $s){
	?>
	<tr>
		<td><?php echo $s->department;?></td>
		<?php 
			if($this->input->post('outcome_type')){ 
			$outcome = $this->input->post('outcome_type'); 
		?>
        <td class="text-right">
			<a href="<?php 
				echo base_url()."reports/outcome_detail/
				$s->department_id/$s->unit/$s->area/M/0/0/$from_date/$to_date/
				$visit_name/$date_type/$outcome/"
				.($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0);
			?>">
				<?php echo $s->{'male_'.strtolower($this->input->post('outcome_type'))};?>
			</a>
		</td>
        <td class="text-right">
			<a href="<?php echo base_url()."reports/outcome_detail/$s->department_id/$s->unit/$s->area/F/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
			<?php echo $s->{'female_'.strtolower($this->input->post('outcome_type'))};?>
			</a>
		</td>
        <td class="text-right">
			<a href="<?php echo base_url()."reports/outcome_detail/$s->department_id/$s->unit/$s->area/0/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
			<?php echo $s->{'total_'.strtolower($this->input->post('outcome_type'))};?>
			</a>
		</td>
		<?php } 
		else {
			foreach($outcome_types as $outcome) { ?>
			
			<td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/$s->department_id/$s->unit/$s->area/M/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
				<?php echo $s->{'male_'.strtolower($outcome)};?>
				</a>
			</td>
			<td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/$s->department_id/$s->unit/$s->area/F/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
				<?php echo $s->{'female_'.strtolower($outcome)};?>
				</a>
			</td>
			<td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/$s->department_id/$s->unit/$s->area/0/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
				<?php echo $s->{'total_'.strtolower($outcome)};?>
				</a>
			</td>
		<?php }
		} ?>
		
		<td class="text-right">
			<a href="<?php echo base_url()."reports/outcome_detail/$s->department_id/$s->unit/$s->area/M/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
			<?php echo $s->outcome_male;?>
			</a>
		</td>
		<td class="text-right">
			<a href="<?php echo base_url()."reports/outcome_detail/$s->department_id/$s->unit/$s->area/F/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
			<?php echo $s->outcome_female;?>
			</a>
		</td>
		<td class="text-right">
			<a href="<?php echo base_url()."reports/outcome_detail/$s->department_id/$s->unit/$s->area/0/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
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
				<a href="<?php echo base_url()."reports/outcome_detail/-1/0/0/M/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
				<?php echo ${'total_male_'.strtolower($this->input->post('outcome_type'))};?>
				</a>
			</td>
            <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/-1/0/0/F/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
				<?php echo ${'total_female_'.strtolower($this->input->post('outcome_type'))};?>
				</a>
			</td>
            <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/-1/0/0/0/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
				<?php echo ${'total_'.strtolower($this->input->post('outcome_type'))};?>
				</a>
			</td>
			<?php } 
			else { 
				foreach($outcome_types as $outcome) { 
			?>
		    <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/-1/0/0/M/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
				<?php echo ${'total_male_'.strtolower($outcome)};?>
				</a>
			</td>
            <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/-1/0/0/F/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
				<?php echo ${'total_female_'.strtolower($outcome)};?>
				</a>
			</td>
            <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/-1/0/0/0/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
				<?php echo ${'total_'.strtolower($outcome)};?>
				</a>
			</td>
			<?php }
			} ?>
		    <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/-1/0/0/M/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
				<?php echo $total_male;?>
				</a>
			</td>
            <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/-1/0/0/F/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
				<?php echo $total_female;?>
				</a>
			</td>
            <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/-1/0/0/0/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
				<?php echo $total_outcome;?>
				</a>
			</td>
        </tr>
        <tr>
            <th>Percentage of total</th>
			<?php if(strtolower($this->input->post('outcome_type'))){ ?>	
		    <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/-1/0/0/M/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
				<?php echo round((${'total_male_'.strtolower($this->input->post('outcome_type'))}/$total_outcome)*100)."%";?>
				</a>
			</td>
		    <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/-1/0/0/F/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
				<?php echo round((${'total_female_'.strtolower($this->input->post('outcome_type'))}/$total_outcome)*100)."%";?>
				</a>
			</td>
		    <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/-1/0/0/0/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
				<?php echo round((${'total_'.strtolower($this->input->post('outcome_type'))}/$total_outcome)*100)."%";?>
				</a>
			</td>
			<?php } 
			else { 
				foreach($outcome_types as $outcome) { ?>
				<td class="text-right">
					<a href="<?php echo base_url()."reports/outcome_detail/-1/0/0/M/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
					<?php echo round((${'total_male_'.strtolower($outcome)}/$total_outcome)*100).'%';?>
					</a>
				</td>
				<td class="text-right">
					<a href="<?php echo base_url()."reports/outcome_detail/-1/0/0/F/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
					<?php echo round((${'total_female_'.strtolower($outcome)}/$total_outcome)*100).'%';?>
					</a>
				</td>
				<td class="text-right">
					<a href="<?php echo base_url()."reports/outcome_detail/-1/0/0/0/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
					<?php echo round((${'total_'.strtolower($outcome)}/$total_outcome)*100).'%';?>
					</a>
				</td>
			<?php 
				}
			} ?>
		    <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/-1/0/0/M/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
				<?php echo round(($total_male/$total_outcome)*100).'%';?>
				</a>
			</td>
		    <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/-1/0/0/F/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
				<?php echo round(($total_female/$total_outcome)*100).'%';?>
				</a>
			</td>
		    <td class="text-right">
				<a href="<?php echo base_url()."reports/outcome_detail/-1/0/0/0/0/0/$from_date/$to_date/$visit_name/$date_type/$outcome/".($icd_chapter ?: 0)."/".($icd_block ?: 0)."/".($icd_code ?: 0)?>">
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
