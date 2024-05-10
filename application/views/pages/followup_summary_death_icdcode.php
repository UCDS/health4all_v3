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
			$('#table-sort').find('.tablesorter-filter-row').hide();
				var printContent = '<!DOCTYPE html>';
				printContent += '<html>';
				printContent += '<head>';
				printContent += '<title>Print</title>';
				printContent += '<style>';
				printContent += 'table { border-collapse: collapse; width: 95%; }';
				printContent += 'th, td { border: 1px solid #ddd; padding: 8px; }';
				printContent += 'th { background-color: #f2f2f2; }';
				printContent += '</style>';
				printContent += '</head>';
				printContent += '<body>';
				//printContent += document.getElementById("print-container");
				var printContainer = document.getElementById("print-container");
				var printContent = printContainer.innerHTML;
				printContent = '<div style="text-align: center;">' + printContent + '</div>';
				printContent = '<style>table { border-collapse: collapse; } table, th, td { border: 1px solid black; }</style>' + printContent;
				printContent += document.getElementById("table-sort").outerHTML;
				printContent += '</body>';
				printContent += '</html>';
				var printWindow = window.open('', '_blank', 'width=800,height=600');
				printWindow.document.write(printContent);
				printWindow.document.close();
				printWindow.print();
				window.onbeforeunload = function() {
					printWindow.close();
				};
				window.location.reload();
		});
		

		
		var hospitalctx = $("#hospitalChart");
		var myChart = new Chart(hospitalctx, {
			type: 'horizontalBar',
			data: {
					labels: [<?php echo count($report) ?>],
				datasets: [
					{
						type: 'horizontalBar',
						label: '<?=$visit_type;?>',
						xAxisID : "A",
						backgroundColor: "rgba(255,102,0,0.6)",
						borderColor: "rgba(255,102,0,0.6)",
						data: [<?php echo count($report)?>]
					},
				]
			},
			options: {
				scales: {
					xAxes: [{
						id: 'A',
						type: 'linear',
						position: 'bottom',
						ticks: {
							beginAtZero:true
						},
						gridLines : false,
						scaleLabel : {
							display : true,
							labelString : "Patients"
						}
					}],
					yAxes: [{
						stacked: true
					}]
				}
			}
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
    $('#test').attr('download', 'followup_summary.xls');

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
		Followup Summary Death - ICD Code
	  </CENTER></h3><br>
		<?php echo form_open("op_ip_report/followup_summary_death_icdcode",array('role'=>'form','class'=>'form-custom','onsubmit'=>'return validateForm()')); ?>
			<div class="container">
				<div class="row">
					<div class="col-md-4">
						Filter By : <input type="radio" name="death_followup" value="1" <?php if(empty($this->input->post('death_followup')) || $this->input->post('death_followup') == 1) {echo "checked" ;} ?>> Death Date
						<input type="radio" name="death_followup" value="2" <?php if($this->input->post('death_followup') == 2) {echo "checked" ;} ?>> Followup Add Date
					</div>
					<script>
						document.addEventListener("DOMContentLoaded", function() {
						document.getElementById('followupadd_date').style.display = 'none';
						document.querySelectorAll('input[name="death_followup"]').forEach(function(radio) {
							radio.addEventListener('change', function() {
								if (this.value == 1) {
									document.getElementById('death_date').style.display = 'block';
									document.getElementById('followupadd_date').style.display = 'none';
								}
								else if (this.value == 2) {
									document.getElementById('death_date').style.display = 'none';
									document.getElementById('followupadd_date').style.display = 'block';
								}
							});
						});
					});
					function validateForm() {
						var fromDate = document.getElementById("from_date").value;
						var toDate = document.getElementById("to_date").value;
						if (fromDate.trim() == "") {
							alert("Please select from date.");
							return false;
						}
						if (toDate.trim() == "") {
							alert("Please select To Date.");
							return false;
						}
						var fromDateObj = new Date(fromDate);
						var toDateObj = new Date(toDate);
						var tomorrowDate = new Date();
						tomorrowDate.setDate(tomorrowDate.getDate() + 1);
						if (toDateObj >= tomorrowDate) {
							alert("To Date should be before tomorrow's date.");
							return false;
						}
						return true;
					}
					</script>
					<div class="col-md-5" id="death_date" <?php if(empty($this->input->post('death_followup')) || $this->input->post('death_followup') == 1) {echo 'style="display:block;"';} else {echo 'style="display:none;"';} ?>>
					<?php 
						$from_date = "";
						$to_date = "";
						if ($this->input->post('from_date')) {
							$from_date = date("Y-m-d", strtotime($this->input->post('from_date')));
						}
						if ($this->input->post('to_date')) {
							$to_date = date("Y-m-d", strtotime($this->input->post('to_date')));
						}
						if ($from_date == "" && $to_date == "") {
							$from_date_placeholder = "Select Date";
							$to_date_placeholder = "Select Date";
						} else {
							$from_date_placeholder = date("d-M-Y", strtotime($from_date));
							$to_date_placeholder = date("d-M-Y", strtotime($to_date));
						}
					?>
						Death Date : <input class="form-control" type="text" placeholder="<?php echo $from_date_placeholder; ?>" name="from_date"  id="from_date" value="<?php if($this->input->post('from_date')){ echo date("d-M-Y",strtotime($from_date)); }?>" size="15"/>
						To <input class="form-control" type="text" placeholder="<?php echo $to_date_placeholder; ?>" name="to_date" id="to_date" value="<?php if($this->input->post('to_date')){ echo date("d-M-Y",strtotime($to_date)); } ?>" size="15" />
					</div>
					</br></br>
					<div class="col-md-2" style="margin-top:10px;">
						<label><b>Life Status:  </b></label>
						<input type="radio" name="life_status" class ="form-control" value="2" <?php if(empty($this->input->post('life_status')) || $this->input->post('life_status') == 2) {echo "checked" ;} ?>  > <label>Not Alive </label>
					</div>

					<div class="col-md-10" id="followupadd_date" style="margin-top:10px;" <?php if($this->input->post('death_followup') == 2) {echo 'style="display:block;"';} else {echo 'style="display:none;"';} ?>>
					<?php 
						$from_date_1=0;$to_date_1=0;
						if($this->input->post('from_date_1')) $from_date_1=date("Y-m-d",strtotime($this->input->post('from_date_1'))); else $from_date_1 = date("Y-m-d");
						if($this->input->post('to_date_1')) $to_date_1=date("Y-m-d",strtotime($this->input->post('to_date_1'))); else $to_date_1 = date("Y-m-d");
					?>
						Followup Add Date : <input class="form-control" style = "background-color:#EEEEEE" type="text" value="<?php echo date("d-M-Y",strtotime($from_date_1)); ?>" name="from_date_1" id="from_date" size="15" />
						To <input class="form-control" type="text" style = "background-color:#EEEEEE" value="<?php echo date("d-M-Y",strtotime($to_date_1)); ?>" name="to_date_1" id="to_date" size="15" />
	                </div>

					<div class="col-md-12" style="margin-top:10px;">
					Search by : 
						<select name="route_primary" id="route_primary" class="form-control" onchange='onchange_primary_route_dropdown(this)'>
							<option value="">Primary Route</option>
							<?php foreach($route_primary as $primary){
								echo "<option value='".$primary->route_primary_id."'";
								if($this->input->post('route_primary') && $this->input->post('route_primary') == $primary->route_primary_id) echo " selected ";
								echo ">".$primary->route_primary."</option>";
							}
						?>
						</select>

						<select name="route_secondary" id="route_secondary" class="form-control" >
							<option value="">Secondary Route</option>
						</select>
                
						<select name="priority_type" id="priority_type" class="form-control">
							<option value="">Priority Type</option>
							<?php foreach($priority_types as $type){
								echo "<option value='".$type->priority_type_id."'";
								if($this->input->post('priority_type') && $this->input->post('priority_type') == $type->priority_type_id) echo " selected ";
								echo ">".$type->priority_type."</option>";
							}
							?>
						</select>
						<select name="volunteer" id="volunteer" class="form-control" >
							<option value="">Volunteer</option>
							<?php foreach($volunteer as $volunteer){
									echo "<option value='".$volunteer->staff_id."'";
									if($this->input->post('first_name') && $this->input->post('first_name') == $volunteer->staff_id) echo " selected ";
									echo ">".$volunteer->first_name."</option>";
							}
							?>
						</select>
						<input type="hidden" id="1" name="postback" value="1">
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
						<div class="col-md-4"></div>
						<div class="col-md-3"></div>
						<div class="col-md-4">
							<?php if(!$this->input->post('postback')) { ?>				  
							<input type="checkbox" id="groupbyicdchapter" name="groupbyicdchapter" value="1" checked onclick="handleClick();">
							<?php } else { ?>
							<input type="checkbox" id="groupbyicdchapter" name="groupbyicdchapter" value="1" <?php if($this->input->post('groupbyicdchapter')) echo "checked"; ?> onclick="handleClick();">
							<?php } ?>
							<label for="groupbyicdchapter"> Group by ICD Chapter</label><br>
						</div>
					</div>
					
					<div class="col-md-12" style="padding-top:15px;">
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
	
						<select id="ndps" name="ndps"  class="form-control">
							<option value="0" >NDPS Status</option>           	
							<option value="1" <?php echo ($this->input->post('ndps') == '1') ? 'selected' : ''; ?> >Yes</option> 
							<option value="2" <?php echo ($this->input->post('ndps') == '2') ? 'selected' : ''; ?> >No</option>       
						</select>
					</div>

					<div class="col-md-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<input type="checkbox" id="groupbyicdblock" name="groupbyicdblock" value="1" <?php if($this->input->post('groupbyicdblock')) echo "checked"; ?> onclick="handleClick();">
						<label for="groupbyicdblock"> Group by ICD Block</label><br>
					</div>
					<div class="col-md-4">
					  	<input type="checkbox" id="groupbyicdcode" name="groupbyicdcode" value="1" <?php if($this->input->post('groupbyicdcode')) echo "checked"; ?> onclick="handleClick();">
						<label for="groupbyicdcode"> Group by ICD Code</label><br>
					</div>
					<script>
						function handleClick() {
							var groupbyicdchapter = document.getElementById("groupbyicdchapter");
							var groupbyicdblock = document.getElementById("groupbyicdblock");
							var groupbyicdcode = document.getElementById("groupbyicdcode");
							if ( !groupbyicdchapter.checked && !groupbyicdblock.checked && !groupbyicdcode.checked ){
								groupbyicdchapter.checked = true;
							}
						}
					</script>
				</div>
			</div>
			
			<div class="container" style="padding-top:20px;">
				<div class="row">
					<div class="col-md-2">
						<select name="state" id="state" style="width: 100%;" class="form-control" onchange='onchange_state_dropdown(this)'>
							<option value="" >State</option>
							<?php 
							foreach($all_states as $state){
								echo "<option value='".$state->state_id."'";
								if($this->input->post('state') && $this->input->post('state') == $state	->state_id) echo " selected ";
								echo ">".$state->state."</option>";
							}
							?>
							
						</select>
					</div>
					<div class="col-md-2">
						<select name="district" style="width: 100%;" id="district" class="form-control" >
							<option value="" >District</option>
						</select>
					</div>
					<script>
					onchange_state_dropdown(document.getElementById("state"));
					var district = "<?php echo $this->input->post('district')?>";
					if(district != ""){
						$("#district").val(district);
					}
					</script>
				</div> 
			</div>
			<div class="container" style="padding-top:20px;">
				<div class="row">
					<div class="col-md-1">
						<div class="form-group">
						
							<input class="btn btn-sm btn-primary" type="submit" value="Submit" />
						</div>
					</div>
				</div>
			</div>				
				
	<br />
</form>
<?php if(isset($report) && count($report)>0){ ?>

		<div style='padding: 0px 2px;' id="print-container">
            <h5>Report as on <?php echo date("j-M-Y h:i A"); ?></h5>
        </div>
               
		<button type="button" class="btn btn-default btn-md print">
		  <span class="glyphicon glyphicon-print"></span> Print
		</button>
        
        <a href="#" id="test" onClick="javascript:fnExcelReport();">
            <button type="button" class="btn btn-default btn-md excel">
                <i class="fa fa-file-excel-o"ara-hidden="true"></i> Export to excel
            </button>
        </a><br><br>

		<div style='padding: 0px 2px;' id="print-container">
            <h4><span style="color:black;">Note : </span> <span style="color:red;">Below Data May Vary If Filters Applied </span> </h4>
        </div>
		<table class="table table-bordered table-striped" id="table-sort">
			<thead>
				<tr>
					<th style="text-align:center;">S.no</th>
					<th style="text-align:center;">ICD Chapter</th>
					<?php if(!empty($this->input->post('groupbyicdblock')) ) {?>
					<th style="text-align:center;">ICD Block</th>
					<?php } if(!empty($this->input->post('groupbyicdcode'))) {?>
						<th style="text-align:center;">ICD Code</th>
					<?php } ?>
					<th style="text-align:center;">At Centre</th>
					<th style="text-align:center;">Other Center</th>
					<th style="text-align:center;">Home</th>
					<th style="text-align:center;">Unupdated Status</th>
					<th style="text-align:center;">Total Count</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$sno=(($page_no - 1) * $total_records_per_page)+1 ;
				foreach($report as $s)
				{
					$total_centre+=$s->centre;
					$total_otherCentre+=$s->otherCentre;
					$total_home+=$s->home;
					$total_unupdated_death_status+=$s->unupdated_death_status;
				?>
				<tr>
					<td style="text-align:right;" ><?php echo $sno;?></td>
						<td><?php echo $s->chapter_title;?></td>
					<?php if(!empty($this->input->post('groupbyicdblock')) ) {?>
						<td><?php echo $s->block_title;?></td>
					<?php } if(!empty($this->input->post('groupbyicdcode'))) {?>
						<td><?php echo $s->code_title;?></td>
					<?php } ?>
					<td style="text-align:right;"><?php echo $s->centre;?></td>
					<td style="text-align:right;"><?php echo $s->otherCentre;?></td>
					<td style="text-align:right;"><?php echo $s->home;?></td>
					<td style="text-align:right;">
						<?php echo $s->unupdated_death_status; ?>
					</td>
					<td style="text-align: center">
						<?php echo $tot = $s->centre+$s->otherCentre+$s->home+$s->unupdated_death_status; ?>
					</td>
				</tr>
				<?php $sno++;} 	?>
			</tbody>
			<tfoot>
				<tr>
					<th></th>
					<?php if(!empty($this->input->post('groupbyicdblock')) ) {?>
					<th></th>
					<?php } if(!empty($this->input->post('groupbyicdcode'))) {?>
					<td ></td>
					<?php } ?>
					<th style="text-align:right;">Total</th>
					<th style="text-align:right;"><?php echo $total_centre ?></th>
					<th style="text-align:right;"><?php echo $total_otherCentre ?></th>
					<th style="text-align:right;"><?php echo $total_home ?></th>
					<th style="text-align:right;"><?php echo $total_unupdated_death_status ?></th>
					<th style="text-align:center;">
						<?php echo $total_centre+$total_otherCentre+$total_home+$total_unupdated_death_status ?>
					</th>
				</tr>
			</tfoot>
	</table>
	<?php } else { ?>
	No patient registrations on the given date.
	<?php } ?>