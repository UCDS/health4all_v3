<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/Chart.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/export_to_excell.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">  <!--change google map key while push-->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">
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
.page_dropdown{
    position: relative;
    float: left;
    padding: 6px 12px;
    width: auto;
    height: 34px;
    line-height: 1.428571429;
    text-decoration: none;
    background-color: #ffffff;
    border: 1px solid #dddddd;
    margin-left: -1px;
    color: #428bca;
    border-bottom-right-radius: 4px;
    border-top-right-radius: 4px;
    display: inline;
}
.page_dropdown:hover{
    background-color: #eeeeee;
    color: #2a6496;
 }
.page_dropdown:focus{
    color: #2a6496;
    outline:0px;	
}

.rows_per_page{
    display: inline-block;
    height: 34px;
    padding: 6px 12px;
    font-size: 14px;
    line-height: 1.428571429;
    color: #555555;
    vertical-align: middle;
    background-color: #ffffff;
    background-image: none;
    border: 1px solid #cccccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    -webkit-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
    transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
}
.rows_per_page:focus{
    border-color: #66afe9;
    outline: 0;	
}

</style>
<?php 
	$pins = array();
    foreach($report as $pin){
		if($pin->district_id){
			$visitsTotal[] = $pin->total;
			$pins[] = (object) array(
				'district_id' => $pin->district_id,
				'district_name' => $pin->district,
				'latitude' => $pin->latitude,
				'longitude' => $pin->longitude,
				'Visits' => $pin->total
			);
		}
		
    }
	if(isset($visitsTotal))
		$maxVisit = max($visitsTotal);
?>
<script>
<?php
$visit_type="OP & IP";
 ?>
</script>
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
			var content = $('#print-container').clone();
			content.find('h5').text("Report as on " + new Date().toLocaleString());
			$('#table-sort').append(content);
			$('#table-sort').trigger('printTable');
			content.remove();
		});
		
  }); 
  //create function for  for Excel report
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
    tab_text = tab_text + $('#table-sort').html();
    tab_text = tab_text + '</table></body></html>';
    var data_type = 'data:application/vnd.ms-excel';
    $('#test').attr('href', data_type + ', ' + encodeURIComponent(tab_text));
    //downloaded excel sheet name is given here
    $('#test').attr('download', 'custom_report.xls');

  }

</script>
<script type="text/javascript">
        $(document).ready(function(){
			// find the input fields and apply the time select to them.
           $('#from_time').ptTimeSelect();
			$('#to_time').ptTimeSelect();
        });
       
        function onchange_state_dropdown(dropdownobj) {       	
		const stateID = dropdownobj.value;
		populateDistricts(stateID);		
	}
	
	function populateDistricts(stateID) {
		var optionsHtml = getDistrictOptionsState(stateID);
		$("#district").html(optionsHtml);
		
	}
	
	function getDistrictOptionsState(stateID) {
		var all_districts = JSON.parse('<?php echo json_encode($all_districts); ?>'); 
		var selected_districts = all_districts.filter(all_districts => all_districts.state_id == stateID);
		let optionsHtml = buildEmptyOption("District");
		if(selected_districts.length > 0) {
			optionsHtml += selected_districts.map(selected_districts => {
					return `	<option value="${selected_districts.district_id}">
							${selected_districts.district}
						</option>`;
		});
			
		}
		return optionsHtml;
	}
	function buildEmptyOption(optionName = "Select") {
		return `<option value="" selected>
					${optionName}
			</option>`;

	}	
	onchange_primary_route_dropdown(document.getElementById("route_primary"));
	var route_secondary = "<?php echo $this->input->post('route_secondary')?>";
	if(route_secondary != ""){
			$("#route_secondary").val(route_secondary);
	}
	function onchange_primary_route_dropdown(dropdownobj) {       	
		const primaryRouteID = dropdownobj.value;
		populatePrimaryRouteID(primaryRouteID);		
	}
		
	function populatePrimaryRouteID(primaryRouteID) {
		var optionsHtml = getSecondaryRoute(primaryRouteID);
		$("#route_secondary").html(optionsHtml);		
	}

	function getSecondaryRoute(primaryRouteID) {
		var all_route_secondary = JSON.parse('<?php echo json_encode($route_secondary); ?>'); 
		var selected_route_secondary = all_route_secondary.filter(all_route_secondary => all_route_secondary.route_primary_id == primaryRouteID);
		let optionsHtml = buildEmptyOption("Secondary Route");
		if(selected_route_secondary.length > 0) {
			optionsHtml += selected_route_secondary.map(selected_route_secondary => {
					return `	<option value="${selected_route_secondary.id}">
							${selected_route_secondary.route_secondary}
						</option>`;
		});
				
			}
		return optionsHtml;
	}
</script>
<script type="text/javascript">
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
	onchange_primary_route_dropdown(document.getElementById("route_primary"));
	var route_secondary = "<?php echo $this->input->post('route_secondary')?>";
	if(route_secondary != ""){
			$("#route_secondary").val(route_secondary);
	}
});
function onchange_primary_route_dropdown(dropdownobj) {       	
	const primaryRouteID = dropdownobj.value;
	populatePrimaryRouteID(primaryRouteID);		
}
	
function populatePrimaryRouteID(primaryRouteID) {
	var optionsHtml = getSecondaryRoute(primaryRouteID);
	$("#route_secondary").html(optionsHtml);		
}

function getSecondaryRoute(primaryRouteID) {
	var all_route_secondary = JSON.parse('<?php echo json_encode($route_secondary); ?>'); 
	var selected_route_secondary = all_route_secondary.filter(all_route_secondary => all_route_secondary.route_primary_id == primaryRouteID);
	let optionsHtml = buildEmptyOption("Secondary Route");
	if(selected_route_secondary.length > 0) {
		optionsHtml += selected_route_secondary.map(selected_route_secondary => {
				return `	<option value="${selected_route_secondary.id}">
						${selected_route_secondary.route_secondary}
					</option>`;
	   });
			
        }
	return optionsHtml;
}

function buildEmptyOption(optionName = "Select") {
	return `<option value="" selected>
					${optionName}
			</option>`;

}
function doPost(page_no){
	
	var page_no_hidden = document.getElementById("page_no");	
  	page_no_hidden.value=page_no;
        $('#followup_list').submit();
   }
function onchange_page_dropdown(dropdownobj){
   doPost(dropdownobj.value);    
}
</script>

    <h3>
	<CENTER>
		<?php echo $fields[0]->report_name; ?>
	  </CENTER></h3><br>
	 
	<div class="row col-md-offset-2">
		<div class="col-md-12">
		<?php
			$from_date=0;$to_date=0;
			if($this->input->post('from_date')) $from_date=date("Y-m-d",strtotime($this->input->post('from_date'))); else $from_date = date("Y-m-d");
			if($this->input->post('to_date')) $to_date=date("Y-m-d",strtotime($this->input->post('to_date'))); else $to_date = date("Y-m-d");
			$from_time=0;$to_time=0;
			if($this->input->post('from_time')) $from_time=date("H:i",strtotime($this->input->post('from_time'))); else $from_time = date("H:i",strtotime("00:00"));
			if($this->input->post('to_time')) $to_time=date("H:i",strtotime($this->input->post('to_time'))); else $to_time = date("H:i",strtotime("23:59"));
			$page_no = 1;	
		?>
			<div class="row">	
				<?php echo form_open("reports/custom_generated_report/" . $form_id, array('role' => 'form', 'class' => 'form-custom', 'id' => '')); ?>Choose OP / IP : &nbsp;&nbsp;
				<input type="radio" name="op_ip" class ="form-control" value="1" <?php if(empty($this->input->post('op_ip')) || $this->input->post('op_ip')==1){ echo "checked"; }  ?>> &nbsp;OP&nbsp;
				<input type="radio" name="op_ip" class ="form-control" value="2" <?php if(!empty($this->input->post('op_ip')) && $this->input->post('op_ip')==2 ){ echo "checked"; } ?>> &nbsp;IP&nbsp; </br>
				<label><b>Life Status:  </b></label>
				<input type ="radio" name="life_status" class ="form-control" value="1" <?php if( empty($this->input->post('life_status')) || ($this->input->post('life_status') == 1))  echo "checked" ; ?> > <label> Alive</label>
				<input type="radio" name="life_status" class ="form-control" value="2" <?php if(!empty($this->input->post('life_status')) && $this->input->post('life_status') == 2) {echo "checked" ;} ?>  > <label> Not Alive </label>
				<input type="radio" name="life_status" class ="form-control" value="3" <?php if(!empty($this->input->post('life_status')) && $this->input->post('life_status') == 3) {echo "checked" ;} ?>  > <label> No Follow up</label>
				<input type="radio" name="life_status" class ="form-control" value="4" <?php if(!empty($this->input->post('life_status')) && $this->input->post('life_status') == 4) {echo "checked" ;} ?>  > <label> All</label>
				<br/>
				From Date : <input class="form-control" style = "background-color:#EEEEEE" type="text" value="<?php echo date("d-M-Y",strtotime($from_date)); ?>" name="from_date" id="from_date" size="15" />
				To Date : <input class="form-control" type="text" style = "background-color:#EEEEEE" value="<?php echo date("d-M-Y",strtotime($to_date)); ?>" name="to_date" id="to_date" size="15" />
				From Time:<input  class="form-control" style = "background-color:#EEEEEE" type="text" value="<?php echo date("h:i A",strtotime($from_time)); ?>" name="from_time" id="from_time" size="7px"/>
				To Time:<input class="form-control" style = "background-color:#EEEEEE" type="text" value="<?php echo date("h:i A",strtotime($to_time)); ?>" name="to_time" id="to_time" size="7px"/>	
				<select name="department" id="department" class="form-control" style="margin-top:2%;">
					<option value="">Department</option>
					<?php 
					foreach($all_departments as $dept){
					echo "<option value='".$dept->department_id."'";
					if($this->input->post('department') && $this->input->post('department') == $dept->department_id) echo " selected ";
					echo ">".$dept->department."</option>";
					}
					?>
				</select>
				<select name="unit" id="unit" class="form-control" style="margin-top:2%;">
					<option value="">Unit</option>
					<?php 
					foreach($units as $unit){
					echo "<option value='".$unit->unit_id."' class='".$unit->department_id."'";
					if($this->input->post('unit') && $this->input->post('unit') == $unit->unit_id) echo " selected ";
					echo ">".$unit->unit_name."</option>";
					}
					?>
				</select>
				<select name="area" id="area" class="form-control" style="margin-top:2%;">
					<option value="">Area</option>
					<?php 
					foreach($areas as $area){
					echo "<option value='".$area->area_id."' class='".$area->department_id."'";
					if($this->input->post('area') && $this->input->post('area') == $area->area_id) echo " selected ";
					echo ">".$area->area_name."</option>";
					}
					?>
				</select>
				<select name="route_primary" id="route_primary" class="form-control" onchange='onchange_primary_route_dropdown(this)' style="margin-top:2%;">
					<option value="">Primary Route</option>
					<?php foreach($route_primary as $primary){
						echo "<option value='".$primary->route_primary_id."'";
						if($this->input->post('route_primary') && $this->input->post('route_primary') == $primary->route_primary_id) echo " selected ";
						echo ">".$primary->route_primary."</option>";
					}
					?>
				</select>

				<select name="route_secondary" id="route_secondary" class="form-control" style="margin-top:2%;">
					<option value="">Secondary Route</option>
				</select>
                
				<select name="priority_type" id="priority_type" class="form-control" style="margin-top:2%;">
					<option value="">Priority Type</option>
					<?php foreach($priority_types as $type){
					echo "<option value='".$type->priority_type_id."'";
					if($this->input->post('priority_type') && $this->input->post('priority_type') == $type->priority_type_id) echo " selected ";
					echo ">".$type->priority_type."</option>";
					}
					?>
				</select>

				<select name="volunteer" id="volunteer" class="form-control" style="margin-top:2%;">
					<option value="">Volunteer</option>
					<?php foreach($volunteer as $volunteer){
							echo "<option value='".$volunteer->staff_id."'";
							if($this->input->post('first_name') && $this->input->post('first_name') == $volunteer->staff_id) echo " selected ";
							echo ">".$volunteer->first_name."</option>";
					}
					?>
				</select>
				<select name="icd_chapter" id="icd_chapter" class="form-control" style="width:230px;margin-top:2%;" >
					<option value="">ICD Chapter</option>
					<?php 
						foreach($icd_chapters as $v){
							echo "<option value='".$v->chapter_id."'";
							if($this->input->post('icd_chapter') && $this->input->post('icd_chapter') == $v->chapter_id) echo " selected ";
							echo ">".$v->chapter_id." - ".$v->chapter_title."</option>";
						}
					?>
				</select>
				<select name="icd_block" id="icd_block" class="form-control" style="width:345px;margin-top:2%;" >
					<option value="">ICD Block</option>
					<?php 
						foreach($icd_blocks as $v){
							echo "<option value='".$v->block_id."' class='".$v->chapter_id."' ";
								if($this->input->post('icd_block') && $this->input->post('icd_block') == $v->block_id) echo " selected ";
								echo ">".$v->block_id." - ".$v->block_title."</option>";
						}
					?>
				</select>
				<select id="icd_code" class="repositories" style="width:245px;margin-top:2%;display:inline;" placeholder="Select ICD Code.." name="icd_code" >
					<?php if($this->input->post('icd_code')) { ?>
						<option value="<?php echo $this->input->post('icd_code');?>"><?php echo $this->input->post('icd_code');?></option>
					<?php } ?>
				</select>

				<select id="sort_by_age" name="sort_by_age"  class="form-control" style="margin-top:2%;">
					<option value="0">Sort by age</option>           	
					<option value="1" <?php echo ($this->input->post('sort_by_age') == '1') ? 'selected' : ''; ?> >Ascending</option> 
					<option value="2" <?php echo ($this->input->post('sort_by_age') == '2') ? 'selected' : ''; ?> >Descending</option>       
				</select>

				<select id="ndps" name="ndps"  class="form-control" style="margin-top:2%;">
					<option value="0" >NDPS Status</option>           	
					<option value="1" <?php echo ($this->input->post('ndps') == '1') ? 'selected' : ''; ?> >Yes</option> 
					<option value="2" <?php echo ($this->input->post('ndps') == '2') ? 'selected' : ''; ?> >No</option>       
				</select>
				
				<select name="state" id="state" style="margin-top:2%;" class="form-control" onchange='onchange_state_dropdown(this)'>
					<option value="" >State</option>
					<?php 
					foreach($all_states as $state){
						echo "<option value='".$state->state_id."'";
						if($this->input->post('state') && $this->input->post('state') == $state	->state_id) echo " selected ";
						echo ">".$state->state."</option>";
					}
					?>
				</select>
				<select name="district" style="margin-top:2%;" id="district" class="form-control" >
					<option value="" >District</option>
				</select>
				<script>
					onchange_state_dropdown(document.getElementById("state"));
					var district = "<?php echo $this->input->post('district')?>";
					if(district != ""){
						$("#district").val(district);
					}
					function onchange_state_dropdown(dropdownobj) {       	
						const stateID = dropdownobj.value;
						populateDistricts(stateID);		
					}
					
					function populateDistricts(stateID) {
						var optionsHtml = getDistrictOptionsState(stateID);
						$("#district").html(optionsHtml);
						
					}
					function getDistrictOptionsState(stateID) {
						var all_districts = JSON.parse('<?php echo json_encode($all_districts); ?>'); 
						var selected_districts = all_districts.filter(all_districts => all_districts.state_id == stateID);
						let optionsHtml = buildEmptyOption("District");
						if(selected_districts.length > 0) {
							optionsHtml += selected_districts.map(selected_districts => {
									return `	<option value="${selected_districts.district_id}">
											${selected_districts.district}
										</option>`;
						});
							
						}
						return optionsHtml;
					}
				</script>
				<input type="hidden" name="form_id" value="<?php echo $form_id;?>">
				<input type="hidden" name="page_no" id="page_no" value='<?php echo "$page_no"; ?>'>	
			 	<span>Rows per page : </span><input type="number" class="form-control rows_per_page" name="rows_per_page" id="rows_per_page" style="margin-top:2%;"
			 	min=<?php echo $lower_rowsperpage; ?> max= <?php echo $upper_rowsperpage; ?> step="1" 
				value= <?php if($this->input->post('rows_per_page')) { echo $this->input->post('rows_per_page'); }else{echo $rowsperpage;}  ?> onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" /> 
				
			</div></br>
			<input class="btn btn-sm btn-primary" type="submit" value="Submit" />
		</form>
		</div>
	</div><br/>
<?php if(!empty($report) && count($report)>0){ ?>
	<div class="row col-md-offset-2">
		
		<div style='padding: 0px 2px;' id="print-container">
            <h5>Report as on <?php echo date("j-M-Y h:i A"); ?></h5>
        </div>

		<?php 
			$total_records_per_page = $this->input->post('rows_per_page');
			if ($this->input->post('page_no')) { 
				$page_no = $this->input->post('page_no');
			}
			else{
				$page_no = 1;
			}
			$total_records = count($report);
			if ($this->input->post('rows_per_page')){
				$total_records_per_page = $this->input->post('rows_per_page');
			}else{
				$total_records_per_page = $rowsperpage;
			}		
			$total_no_of_pages = ceil($total_records / $total_records_per_page);
			if ($total_no_of_pages==0)
				$total_no_of_pages = 1;
			$second_last = $total_no_of_pages - 1; 
			$offset = ($page_no-1) * $total_records_per_page;
			$previous_page = $page_no - 1;
			$next_page = $page_no + 1;
			$adjacents = "2";	
		?>
			<br/>
		<ul class="pagination" style="margin:0">
		<?php if($page_no > 1){
		echo "<li><a href=# onclick=doPost(1)>First Page</a></li>";
		} ?>

		<li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
		<a <?php if($page_no > 1){
		echo "href=# onclick=doPost($previous_page)";

		} ?>>Previous</a>
		</li>
		<?php
		if ($total_no_of_pages <= 10){  	 
			for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
			if ($counter == $page_no) {
			echo "<li class='active'><a>$counter</a></li>";	
					}else{
				echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
						}
				}
		}
		else if ($total_no_of_pages > 10){
			if($page_no <= 4) {			
				for ($counter = 1; $counter < 8; $counter++){		 
				if ($counter == $page_no) {
					echo "<li class='active'><a>$counter</a></li>";	
				}else{
						echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
						}
		}

		echo "<li><a>...</a></li>";
		echo "<li><a href=# onclick=doPost($second_last)>$second_last</a></li>";
		echo "<li><a href=# onclick=doPost($total_no_of_pages)>$total_no_of_pages</a></li>";
		}
		elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
		echo "<li><a href=# onclick=doPost(1)>1</a></li>";
		echo "<li><a href=# onclick=doPost(2)>2</a></li>";
		echo "<li><a>...</a></li>";
		for (
			$counter = $page_no - $adjacents;
			$counter <= $page_no + $adjacents;
			$counter++
			) {		
			if ($counter == $page_no) {
			echo "<li class='active'><a>$counter</a></li>";	
			}else{
				echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
				}                  
			}
		echo "<li><a>...</a></li>";
		echo "<li><a href=# onclick=doPost($counter) >$counter</a></li>";
		echo "<li><a href=# onclick=doPost($total_no_of_pages)>$total_no_of_pages</a></li>";
		}
		else {
		echo "<li><a href=# onclick=doPost(1)>1</a></li>";
		echo "<li><a href=# onclick=doPost(2)>2</a></li>";
		echo "<li><a>...</a></li>";
		for (
			$counter = $total_no_of_pages - 6;
			$counter <= $total_no_of_pages;
			$counter++
			) {
			if ($counter == $page_no) {
			echo "<li class='active'><a>$counter</a></li>";	
			}else{
				echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
			}                   
			}
		}
		}  
		?>
		<li <?php if($page_no >= $total_no_of_pages){
		echo "class='disabled'";
		} ?>>
		<a <?php if($page_no < $total_no_of_pages) {
		echo "href=# onclick=doPost($next_page)";
		} ?>>Next</a>
		</li>

		<?php if($page_no < $total_no_of_pages){
		echo "<li><a href=# onclick=doPost($total_no_of_pages)>Last Page</a></li>";
		} ?>
		<?php if($total_no_of_pages > 0){
		echo "<li><select class='page_dropdown' onchange='onchange_page_dropdown(this)'>";
		for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
						echo "<option value=$counter ";
						if ($page_no == $counter){
						echo "selected";
						}         
						echo ">$counter</option>";
			}
		echo "</select></li>";
		} ?>
		</ul>


		<div style='padding: 0px 2px;'>

		<h5>Page <?php echo $page_no." of ".$total_no_of_pages." (Total ".$total_records.")" ; ?></h5>

		</div>    
		<button type="button" class="btn btn-default btn-md print">
		  <span class="glyphicon glyphicon-print"></span> Print
		</button>
        
        <a href="#" id="test" onClick="javascript:fnExcelReport();">
            <button type="button" class="btn btn-default btn-md excel">
                <i class="fa fa-file-excel-o"ara-hidden="true"></i> Export to excel
            </button>
        </a><br><br>
	
		<table class="table table-bordered table-striped col-md-12" id="table-sort">
			<thead>
				<tr>
					<th style="text-align:center;">S.no</th>
					<!--<th style="text-align:center;">Patient Id</th>-->
					<?php 
						foreach($fields as $fd) 
						{ 
							$column_width = ($fd->width != 0) ? $fd->width.'px' : 'auto';
					?>
						<th style="text-align:center;width: <?php echo $column_width; ?>"><?php echo $fd->column_name?></th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php $sno = 1; ?>
				<?php foreach($report as $r): ?>
					<tr>
						<td style="text-align:right;"><?php echo $sno; ?></td>
						<!--<td style="text-align:center;"><?php echo $r->patient_id; ?></td>-->
						<?php foreach($fields as $fd): ?>
							<?php switch ($fd->field_name) {
								case 'icd_code':
									echo '<td style="text-align:center;">' . $r->code_title . '</td>';
									break;
								case 'visit_name_id':
									echo '<td style="text-align:center;">' . $r->visit_name . '</td>';
									break;
								case 'area':
									echo '<td style="text-align:center;">' . $r->area . '</td>';
									break;
								case 'unit':
									echo '<td style="text-align:center;">' . $r->unit_name . '</td>';
									break;
								case 'department_id':
									echo '<td style="text-align:center;">' . $r->department . '</td>';
									break;
								case 'life_status':
									if ($fd->field_name == 'life_status' && $r->life_status == 1) {
										echo '<td style="text-align:center;">Alive</td>';
									} elseif ($fd->field_name == 'life_status' && $r->life_status == 2) {
										echo '<td style="text-align:center;">Not Alive</td>';
									}
									break;
								default:
									echo '<td style="text-align:center;">' . $r->{$fd->field_name} . '</td>';
									break;
							} ?>
						<?php endforeach; ?>
					</tr>
					<?php $sno++; ?>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
	<div class="col-md-offset-2">
		<ul class="pagination" style="margin-top: 0px;
				margin-right: 0px;
				margin-bottom: 20px;
				margin-left: 0px;">
			<?php if($page_no > 1){
			echo "<li><a href=# onclick=doPost(1)>First Page</a></li>";
			} ?>

			<li <?php if($page_no <= 1){ echo "class='disabled'"; } ?>>
			<a <?php if($page_no > 1){
			echo "href=# onclick=doPost($previous_page)";

			} ?>>Previous</a>
			</li>
			<?php
			if ($total_no_of_pages <= 10){  	 
				for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
				if ($counter == $page_no) {
				echo "<li class='active'><a>$counter</a></li>";	
						}else{
					echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
							}
					}
			}
			else if ($total_no_of_pages > 10){
				if($page_no <= 4) {			
					for ($counter = 1; $counter < 8; $counter++){		 
					if ($counter == $page_no) {
						echo "<li class='active'><a>$counter</a></li>";	
					}else{
							echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
							}
			}

			echo "<li><a>...</a></li>";
			echo "<li><a href=# onclick=doPost($second_last)>$second_last</a></li>";
			echo "<li><a href=# onclick=doPost($total_no_of_pages)>$total_no_of_pages</a></li>";
			}
			elseif($page_no > 4 && $page_no < $total_no_of_pages - 4) {		 
			echo "<li><a href=# onclick=doPost(1)>1</a></li>";
			echo "<li><a href=# onclick=doPost(2)>2</a></li>";
			echo "<li><a>...</a></li>";
			for (
				$counter = $page_no - $adjacents;
				$counter <= $page_no + $adjacents;
				$counter++
				) {		
				if ($counter == $page_no) {
				echo "<li class='active'><a>$counter</a></li>";	
				}else{
					echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
					}                  
				}
			echo "<li><a>...</a></li>";
			echo "<li><a href=# onclick=doPost($counter) >$counter</a></li>";
			echo "<li><a href=# onclick=doPost($total_no_of_pages)>$total_no_of_pages</a></li>";
			}
			else {
			echo "<li><a href=# onclick=doPost(1)>1</a></li>";
			echo "<li><a href=# onclick=doPost(2)>2</a></li>";
			echo "<li><a>...</a></li>";
			for (
				$counter = $total_no_of_pages - 6;
				$counter <= $total_no_of_pages;
				$counter++
				) {
				if ($counter == $page_no) {
				echo "<li class='active'><a>$counter</a></li>";	
				}else{
					echo "<li><a href=# onclick=doPost($counter)>$counter</a></li>";
				}                   
				}
			}
			}  
			?>
			<li <?php if($page_no >= $total_no_of_pages){
			echo "class='disabled'";
			} ?>>
			<a <?php if($page_no < $total_no_of_pages) {
			echo "href=# onclick=doPost($next_page)";
			} ?>>Next</a>
			</li>

			<?php if($page_no < $total_no_of_pages){
			echo "<li><a href=# onclick=doPost($total_no_of_pages)>Last Page</a></li>";
			} ?>
			<?php if($total_no_of_pages > 0){
			echo "<li><select class='page_dropdown' onchange='onchange_page_dropdown(this)'>";
			for ($counter = 1; $counter <= $total_no_of_pages; $counter++){
							echo "<option value=$counter ";
							if ($page_no == $counter){
							echo "selected";
							}         
							echo ">$counter</option>";
				}
			echo "</select></li>";
			} ?>
		</ul>
	</div>
	<?php } else { ?>
			<p class="col-md-offset-2"> No custom layout had been added for this report. </p>
	<?php } ?>
