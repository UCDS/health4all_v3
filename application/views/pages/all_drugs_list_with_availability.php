<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/export_to_excell.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >

<style>
	.tablesorter thead .disabled {display: none}

    .drug_available_class td{
    	background: #6DF48F !important;
    	font-weight: bold;
    }
</style>
<script type="text/javascript">
$(function(){
	mergeDrugsAvailableToDrugsAndRender({drugs: JSON.parse('<?php echo json_encode($drugs); ?>'), drugs_available: JSON.parse('<?php echo json_encode($drugs_available); ?>')});



	var options = {
			widthFixed : true,
			showProcessing: true,
			headers: { 0: { filter: false} },
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
    tab_text = tab_text + $('#myTable').html();
    tab_text = tab_text + '</table></body></html>';
    var data_type = 'data:application/vnd.ms-excel';
    $('#test').attr('href', data_type + ', ' + encodeURIComponent(tab_text));
    //downloaded excel sheet name is given here
    $('#test').attr('download', 'all_drugs_list.xls');

  }

  	var prescriptionDrugs = null;
	function mergeDrugsAvailableToDrugsAndRender(res){
		var drugsAvailable = {};
		res.drugs_available.forEach(function(da){
		    drugsAvailable[da.generic_item_id] = da;
		})

		res.drugs = res.drugs.map(function(d){
			d.available = 'No';
		    if(drugsAvailable[d.generic_item_id]){
		    	// d.custom_name += ' - Available';
		    	d.available = 'Yes';
		        d.drugs_available = drugsAvailable[d.generic_item_id];
		    }
		    return d;
		});
    	prescriptionDrugs = res.drugs;

    	$.each(prescriptionDrugs, function(i, d){
    		var drugsAvailableClass = '';
    		if(d.available == 'Yes'){
    			drugsAvailableClass = 'drug_available_class';
    		}
    		var row = '<tr class="'+drugsAvailableClass+'">'+
    			'<td>'+(i+1)+'</td>'+
    			'<td>'+d.drug_type+'</td>'+
    			'<td>'+d.generic_name+'</td>'+
    			'<td>'+d.item_form+'</td>'+
    			'<td>'+d.available+'</td>'+
    		'</tr>';
    		$('#table-sort tbody').append(row);
    		$('#myTable tbody').append(row);
    	});

    	$('.print').show();
    	$('#test').show();
	}

	function filterResults(){

	}

</script>
	
	
		<h4><CENTER><?php echo $title; ?></CENTER></h4>	
		<!-- <form role="form" class="form-custom">
			Drug Category : <input class="form-control" type="text" value="" id="drug_category" />
			Drug Name : <input class="form-control" type="text" id="drug_name" />
            Drug Form : <input class="form-control" type="text" id="drug_form" />
            Availability : <select class="form-control" id="drug_form"><option value=""></option><option value="yes">Yes</option><option value="no">No</option></select>
			<input class="btn btn-sm btn-primary" type="button" onclick="filterResults()" value="Submit" />
		</form> -->
	<br />
    
    <!--table is displayed only when there is atleast one registration is done-->	
	<button type="button" class="btn btn-default btn-md print" style="display: none;">
       <span class="glyphicon glyphicon-print"></span> Print
	</button>
    <!--frontend-->

    <!--created button which converts html table to Excel sheet-->
    <a href="#" id="test" onClick="javascript:fnExcelReport();" style="display: none;"><button type="button" class="btn btn-default btn-md excel"><i class="fa fa-file-excel-o"ara-hidden="true"></i> Export to excel</button></a>

 	<table class="table table-bordered table-striped" id="table-sort">
		<thead>
			<tr>
				<th style="text-align:center">S. No.</th>
				<th style="text-align:center">Drug Category</th>
				<th style="text-align:center">Drug Name</th>
				<th style="text-align:center">Drug Form</th>
				<th style="text-align:center">Available</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>

    <table class="table table-bordered table-striped" id="myTable" hidden>
		<thead>
			<tr>
				<th style="text-align:center">S. No.</th>
				<th style="text-align:center">Drug Category</th>
				<th style="text-align:center">Drug Name</th>
				<th style="text-align:center">Drug Form</th>
				<th style="text-align:center">Available</th>
			</tr>
		</thead>
		<tbody></tbody>
	</table>
</div>