<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/export_to_excell.js"></script>
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
<script>
function fnExcelReport() {
      //created a variable named tab_text where 
    var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    //row and columns arrangements
    tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
    tab_text = tab_text + '<x:Name>Excel Sheet</x:Name>';

    tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
    tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';

    tab_text = tab_text + "<table border='100px'>";
    //id is given which calls the html table
    tab_text = tab_text + $('#myTable').html();
    tab_text = tab_text + '</table></body></html>';
    var data_type = 'data:application/vnd.ms-excel';
    $('#test').attr('href', data_type + ', ' + encodeURIComponent(tab_text));
    //downloaded excel sheet name is given here
    $('#test').attr('download', 'icd_detailed.xls');

}
</script>

	<?php 
	$from_date=0;$to_date=0;
	if($this->input->post('from_date')) $from_date=date("Y-m-d",strtotime($this->input->post('from_date'))); else $from_date = date("Y-m-d");
	if($this->input->post('to_date')) $to_date=date("Y-m-d",strtotime($this->input->post('to_date'))); else $to_date = date("Y-m-d");
	?>
	<div class="row">
		<h4>ICD Code - Detailed report</h4>	
		<?php echo form_open("reports/icd_detail",array('role'=>'form','class'=>'form-custom')); ?> 
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
					<br />
					<br />
					
					<div class="col-md-12">
					<div class="col-md-4">
					<select name="icd_chapter" id="icd_chapter" class="form-control" style="width:300px;" >
					<option value="">ICD Chapter</option>
					<?php 
					foreach($icd_chapters as $v){
						echo "<option value='".$v->chapter_id."'";
						if($this->input->post('icd_chapter') && $this->input->post('icd_chapter') == $v->chapter_id) echo " selected ";
						echo ">".$v->chapter_id." - ".$v->chapter_title."</option>";
					}
					?>
					</select>
					</div>
					<div class="col-md-4">
					<select name="icd_block" id="icd_block" class="form-control" style="width:300px;" >
					<option value="">ICD Block</option>
					<?php 
					foreach($icd_blocks as $v){
						echo "<option value='".$v->block_id."' class='".$v->chapter_id."' ";
						if($this->input->post('icd_block') && $this->input->post('icd_block') == $v->block_id) echo " selected ";
						echo ">".$v->block_id." - ".$v->block_title."</option>";
					}
					?>
					</select>	
					</div>
					<div class="col-md-4">
					<select id="icd_code" class="repositories" style="width:300px;display:inline;" placeholder="Select ICD Code.." name="icd_code" >
						<?php if($this->input->post('icd_code')) { ?>
							<option value="<?php echo $this->input->post('icd_code');?>"><?php echo $this->input->post('icd_code');?></option>
						<?php } ?>
					</select>	
					</div>
					</div>
					<br />
					<div class="col-md-4 col-md-offset-3">
					<input class="btn btn-sm btn-primary" type="submit" value="Submit" />
					</div>
		</form>
	<br />
	
	<?php 
	if(isset($report) && count($report)>0){ ?>
		<button type="button" class="btn btn-default btn-md print">
		  <span class="glyphicon glyphicon-print"></span> Print
		</button>
              <!--created button which converts html table to Excel sheet-->
        <a href="#" id="test" onClick="javascript:fnExcelReport();">
            <button type="button" class="btn btn-default btn-md excel">
                <i class="fa fa-file-excel-o"ara-hidden="true"></i> Export to excel</button></a>
	<table class="table table-bordered table-striped" id="table-sort">
	<thead>
		<th>Sno</th>
		<th>Admit Date</th>
		<th>Admit Time</th>
		<th>IP No.</th>
		<th>Gender</th>
		<th>Name</th>
		<th>Age</th>
		<th>Parent / Spouse</th>
		<th>Address</th>
		<th>Phone</th>
		<th>Department</th>
		<th>Unit/ Area</th>
		<th>MLC Number</th>
		<th>Outcome</th>
		<th>Outcome Date & Time</th>
		<th>ICD Code</th>
		<th>Final Diagnosis</th>
	</thead>
	<tbody>
	<?php 
	$total_count=0;
	$i=1;
	foreach($report as $s){
		$age="";
		if($s->age_years!=0) $age.=$s->age_years."Y ";
		if($s->age_months!=0) $age.=$s->age_months."M ";
		if($s->age_days!=0) $age.=$s->age_days."D ";
		if($s->age_days==0 && $s->age_months==0 && $s->age_years==0) $age.="0D";
	?>
	<tr>
		<td><?php echo $i++;?></td>
		<td><?php if($s->admit_date!=0) echo date("d-M-Y",strtotime($s->admit_date));?></td>
		<td><?php if($s->admit_time!=0) echo date("g:iA",strtotime($s->admit_time));?></td>
		<td><?php echo $s->hosp_file_no;?></td>
		<td><?php echo $s->gender;?></td>
		<td><?php echo $s->name;?></td>
		<td><?php echo $age;?></td>
		<td><?php echo $s->parent_spouse;?></td>
		<td><?php if($s->address!="") echo $s->address.", "; if($s->place!="") echo $s->place;?></td>
		<td><?php echo $s->phone;?></td>
		<td><?php echo $s->department;?></td>
		<td>
			<?php echo $s->unit_name;
				if(!!$s->unit_name && !!$s->area_name) echo  "/ ";
				echo $s->area_name;
			?>
		</td>
		<td><?php echo $s->mlc_number;?></td>
		<td><?php echo $s->outcome;?></td>
		<td><?php if($s->outcome_date!=0) echo date("d-M-Y",strtotime($s->outcome_date))." ".date("g:iA",strtotime($s->outcome_time));?></td>
		<td><?php echo $s->icd_10;?></td>
		<td><?php echo $s->final_diagnosis;?></td>
	</tr>
	<?php
	$total_count++;
	}
	?>
	</tbody>
	</table>
		
	<?php } else { ?>
	No patient registrations on the given date.
	<?php } ?>
	</div>