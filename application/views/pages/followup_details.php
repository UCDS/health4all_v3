<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.chained.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.selectize.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.validate.min.js"></script>
<link rel="stylesheet" type="text/css"href="<?php echo base_url(); ?>assets/css/selectize.css">
<style type="text/css">
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
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
input[type=number] {
  -moz-appearance: textfield;
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

<style type="text/css">
	.selectize-control.repositories .selectize-dropdown > div {
border-bottom: 1px solid rgba(0,0,0,0.05);
}
.selectize-control {
display: inline-grid;
} 
</style>
<script type="text/javascript">

// var selectizes = {};
// 	function initPrioritySelectize(){
//         var priority = JSON.parse(JSON.stringify(<?php echo json_encode($priority); ?>));
// 		selectizes['priority_type'] = $('#priority_type_id').selectize({
// 			valueField: 'priority_type_id',
// 			labelField: 'custom_data',
// 			searchField: ['priority_type'],
// 			options: priority,
// 			create: false,
// 			render: {
// 				option: function(item, escape) {
// 					return '<div>' +
// 						'<span class="title">' +
// 							'<span class="prescription_drug_selectize_span">'+escape(item.custom_data)+'</span>' +
// 						'</span>' +
// 					'</div>';
// 				}
// 			},
// 			load: function(query, callback) {
// 				if (!query.length) return callback();
// 			},

// 		});
// 	}	


$(document).ready(function(){
	// //initPrioritySelectize();
	// $("#from_date").datepicker({
	// 	dateFormat:"dd-M-yy",changeYear:1,changeMonth:1,onSelect:function(sdt)
	// 	{$("#to_date").datepicker({dateFormat:"dd-M-yy",changeYear:1,changeMonth:1})
	// 	$("#to_date").datepicker("option","minDate",sdt)}})
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
			//$('#table-sort').trigger('printTable'); old changde for improvement 
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
    tab_text = tab_text + $('#table-sort').html();
    tab_text = tab_text + '</table></body></html>';
    var data_type = 'data:application/vnd.ms-excel';
    $('#test').attr('href', data_type + ', ' + encodeURIComponent(tab_text));
    //downloaded excel sheet name is given here
    $('#test').attr('download', 'followup_list.xls');

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



	<?php 
	
	$page_no = 1;	
	
	?>
	<div class="row">
	<div class="panel panel-default" >
		<div class="panel-heading">
			<h4>Search follow-Up Details</h4>	
		</div>
		<?php echo form_open("reports/followup_detail",array('role'=>'form','class'=>'form-custom','id'=>'followup_list')); ?> 
		<input type="hidden" name="page_no" id="page_no" value='<?php echo "$page_no"; ?>'>
                <label style=" margin-left: 50px"><b>Life Status:  </b></label>
		<input type ="radio" name="life_status" class ="form-control" value="1" <?php if( empty($this->input->post('life_status')) || ($this->input->post('life_status') == 1))  echo "checked" ; ?> > <label>Alive</label>
		<input type="radio" name="life_status" class ="form-control" value="2" <?php if(!empty($this->input->post('life_status')) && $this->input->post('life_status') == 2) {echo "checked" ;} ?>  ><label>Not Alive </label>
		<input type="radio" name="life_status" class ="form-control" value="3" <?php if(!empty($this->input->post('life_status')) && $this->input->post('life_status') == 3) {echo "checked" ;} ?>  ><label>No Follow up</label>
		<input type="radio" name="life_status" class ="form-control" value="4" <?php if(!empty($this->input->post('life_status')) && $this->input->post('life_status') == 4) {echo "checked" ;} ?>  > <label>All</label>
		<br>
		
		<div class="col-md-5" id="followupadd_date" style=" margin-left: 35px">
		<?php 
			$from_date_1=0;$to_date_1=0;
			if($this->input->post('from_date_1')) $from_date_1=date("Y-m-d",strtotime($this->input->post('from_date_1'))); else $from_date_1 = date("Y-m-d");
			if($this->input->post('to_date_1')) $to_date_1=date("Y-m-d",strtotime($this->input->post('to_date_1'))); else $to_date_1 = date("Y-m-d");
		?>
			Followup Add Date : <input class="form-control" style = "background-color:#EEEEEE" type="date" value="<?php if($this->input->post('from_date_1')) { echo date("Y-m-d",strtotime($from_date_1)); } ?>" name="from_date_1" max="<?php echo date('Y-m-d'); ?>" size="15" />
			To <input class="form-control" type="date" style = "background-color:#EEEEEE" value="<?php if($this->input->post('to_date_1')) { echo date("Y-m-d",strtotime($to_date_1)); } ?>" name="to_date_1" max="<?php echo date('Y-m-d'); ?>" size="15" />
		</div>
		
		<div class="col-md-5" id="death_date">
		<?php 
			$from_date=0;$to_date=0;
			if($this->input->post('from_date')) $from_date=date("Y-m-d",strtotime($this->input->post('from_date'))); else $from_date = date("Y-m-d");
			if($this->input->post('to_date')) $to_date=date("Y-m-d",strtotime($this->input->post('to_date'))); else $to_date = date("Y-m-d");
		?>
			Death Date : <input class="form-control" style = "background-color:#EEEEEE" type="date" value="<?php if($this->input->post('from_date')) { echo date("Y-m-d",strtotime($from_date)); }?>" name="from_date" max="<?php echo date('Y-m-d'); ?>" size="15" />
			To <input class="form-control" style = "background-color:#EEEEEE" type="date"  name="to_date" id="" max="<?php echo date('Y-m-d'); ?>" value="<?php if($this->input->post('to_date')) { echo date("Y-m-d",strtotime($to_date)); } ?>" max="<?php echo date('Y-m-d'); ?>" size="15" />
		</div>
		</br></br>

                &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;

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

      		    <!-- <select name="last_visit_type" id="last_visit_type" class="form-control"> 
						<option value="">Last Visit Type</option>           	
                        <option value="IP" <?php echo ($this->input->post('last_visit_type') == 'IP') ? 'selected' : ''; ?> >IP</option> 
						<option value="OP" <?php echo ($this->input->post('last_visit_type') == 'OP') ? 'selected' : ''; ?> >OP</option>          
                </select> -->

                <select name="volunteer" id="volunteer" class="form-control" >
                <option value="">Volunteer</option>
				<?php foreach($volunteer as $volunteer){
                     echo "<option value='".$volunteer->staff_id."'";
                     if($this->input->post('first_name') && $this->input->post('first_name') == $volunteer->staff_id) echo " selected ";
                     echo ">".$volunteer->first_name."</option>";
                }
                ?>
                </select>
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
		<br>
		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
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

		<!-- Newly added 12-01-2023 (am)-->
		<select id="sort_by_age" name="sort_by_age"  class="form-control">
			<option value="0">Sort by age</option>           	
            <option value="1" <?php echo ($this->input->post('sort_by_age') == '1') ? 'selected' : ''; ?> >Ascending</option> 
			<option value="2" <?php echo ($this->input->post('sort_by_age') == '2') ? 'selected' : ''; ?> >Descending</option>       
		</select>

		<select id="ndps" name="ndps"  class="form-control">
			<option value="0" >NDPS Status</option>           	
            <option value="1" <?php echo ($this->input->post('ndps') == '1') ? 'selected' : ''; ?> >Yes</option> 
			<option value="2" <?php echo ($this->input->post('ndps') == '2') ? 'selected' : ''; ?> >No</option>       
		</select>
		<!-- till here -->

        <!-- Newly Added march 13 2024 -->
		<div class="col-md-3" style="margin-left:30px;">
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
		<div class="col-md-3" style="margin-left:-30px;">
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
		<!-- till here -->                      
					<br>
					<label class="control-label" style="margin-left: 50px; margin-top: 10px;"> Rows per page : </label>
						<input type="number" class="rows_per_page form-custom form-control" name="rows_per_page" id="rows_per_page" min=<?php echo $lower_rowsperpage; ?> max= <?php echo $upper_rowsperpage; ?> step="1" value= <?php if($this->input->post('rows_per_page')) { echo $this->input->post('rows_per_page'); }else{echo $rowsperpage;}  ?> onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" /> 
			<center><input class="btn btn-sm btn-primary" type="submit" value="Submit" style="margin-top: 20px"/></center>
		
	<br />
	 </div>
	 </div>
	 </form>

	<?php if(isset($results) && count($results)>0){ ?>
		<!-- <h5>Data as on <?php echo date("j-M-Y h:i A"); ?></h5> -->

		
<?php 
	if ($this->input->post('rows_per_page')){
		$total_records_per_page = $this->input->post('rows_per_page');
	}else{
		$total_records_per_page = $rowsperpage;
	}
	if ($this->input->post('page_no')) { 
		$page_no = $this->input->post('page_no');
	}
	else{
		$page_no = 1;
	}
	$total_records = $results_count;
	$total_no_of_pages = ceil($total_records / $total_records_per_page);
	if ($total_no_of_pages == 0)
		$total_no_of_pages = 1;
	$second_last = $total_no_of_pages - 1; 
	$offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2";	
?>
<div style='padding: 0px 2px;'>

<h5>Page <?php echo $page_no." of ".$total_no_of_pages." (Total ".$total_records.")" ; ?></h5>

</div>
<td><?php echo $followup->hosp_file_no;?></td>

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
	<div class="container">
		<!-- PDF & Excel Button -->
		<div style='padding: 0px 2px;' id="print-container">
            <h5>Report as on <?php echo date("j-M-Y h:i A"); ?></h5>
        </div>
		
		<button type="button" class="btn btn-default btn-md print">
			<span class="glyphicon glyphicon-print"></span> Print
		</button>
			<!--created button which converts html table to Excel sheet-->
		<a href="#" id="test" onClick="javascript:fnExcelReport();">
			<button type="button" class="btn btn-default btn-md excel">
					<i class="fa fa-file-excel-o"ara-hidden="true"></i> Export to excel
			</button>
		</a>
	</div>

	<table class="table table-bordered table-striped" id="table-sort">
	<thead>
	<th>SNo</th>
		<th>Patient ID</th>
		<th>Registered Date</th>
		<th>Patient Details</th>		
		<th>Phone</th>
		<!-- <th>Latitude</th>
		<th>Longitude</th> -->
		<th>ICD Code</th>
		<th>Diagnosis</th>
		<!-- <th>Status Date</th>
		<th>Last Visit Type</th>
		<th>Last Visit Date</th>		 -->
		<th>Priority</th>
		<th>Note</th>
		<th>Primary Route</th>
		<th>Secondary Route</th>
		<th>Map link</th>
		<th>NDPS</th>
		<th>Volunteer</th>
		<th>Last update by & Time</th>					
		<?php if($this->input->post('life_status') == 2) { ?>
			<th>Death Date</th>
			<th>Death Place</th>
		<?php } ?>
	</thead>
	<tbody>
	<?php
	//print_r($this->db->last_query());die;
	$sno=(($page_no - 1) * $total_records_per_page)+1 ; 
		foreach($results as $followup){
	 ?>
	<tr>
		<td><?php echo $sno;?></td>
		<td><?php echo $followup->patient_id;?></td>
		<td><?php echo date('j M Y',strtotime($followup->insert_datetime));?></td>
		<td><b><?php echo $followup->first_name." ".$followup->last_name ."/".$followup->age_years ."/" .$followup->gender;?></b>
		<?php if (!empty($followup->father_name)) { ?>
			<?php echo "<br> Relative: ".$followup->father_name; ?>			
					<?php } elseif (!empty($followup->mother_name)) { ?>
						<?php echo "<br> Relative: ".$followup->mother_name; ?>	
							<?php } else { ?>
						<?php echo "<br> Relative: ".$followup->spouse_name; ?>	
							<?php } ?>
		
		<br> Address: <?php echo $followup->address;?></td>
		<td><?php echo $followup->phone;?></td>
		<!-- <td><?php echo $followup->latitude;?></td>
		<td><?php echo $followup->longitude;?></td> -->
		<td><?php echo $followup->icd_code." - ".$followup->code_title;?></td>	
		<td><?php echo $followup->diagnosis;?></td>
		<!-- <td><?php echo date('j M Y',strtotime($followup->status_date));?></td>
		<td><?php echo $followup->last_visit_type?></td>
		<td><?php echo date('j M Y',strtotime($followup->last_visit_date));?></td>	 -->
		<td><?php echo $followup->priority_type; ?></td>
		<td><?php echo $followup->note;?></td>
		<td><?php echo $followup->route_primary;?></td>
		<td><?php echo $followup->route_secondary;?></td>
		<td>
		<?php 
		if($followup->map_link) { ?>
			<a href="<?php echo $followup->map_link; ?>" target="_blank" > View</a> <?php echo $followup->latitude." ,".$followup->longitude ?>
		<?php } else { echo "No map link <br>"." ,".$followup->latitude." ,".$followup->longitude; } ?>
		</td>
		<?php if($followup->ndps==1) { ?>
		<td><?php echo $followup->drug." / ".$followup->dose." / ".date('j M Y',strtotime($followup->last_dispensed_date)).' / '.$followup->last_dispensed_quantity; ?></td>  <!--Newly added 12-01-2024 (am) -->
		<?php } else { ?> <td></td> <?php } ?>
		
		<td><?php echo $followup->fname." ".$followup->lname;?></td>
		<td><?php echo $followup->updated_first_name.' '.$followup->updated_last_name." & ".date("j M Y", strtotime("$followup->followup_update_time")).", ".date("h:i A.", strtotime("$followup->followup_update_time")); ?></td>
		
		<?php if($this->input->post('life_status') == 2) { ?>
			<td><?php if($followup->death_date!=''){ echo date('j M Y',strtotime($followup->death_date)); }?></td>
			<td><?php if($followup->death_status==1){ echo 'At Center'; }else if($followup->death_status==2){ echo 'Other Centre'; }else if($followup->death_status==3){ echo 'Home'; }?></td>
		<?php } ?>
		
		<?php $sno++;} ?>
		
	</tr>
	</tbody>
	</table>

	<div style='padding: 0px 2px;'>

<h5>Page <?php echo $page_no." of ".$total_no_of_pages." (Total ".$total_records.")" ; ?></h5>

</div>
<td><?php echo $followup->hosp_file_no;?></td>

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
						<?php } else{ ?>
						
						No Data to display.
					<?php }  ?> 
</div>	 
 

  
