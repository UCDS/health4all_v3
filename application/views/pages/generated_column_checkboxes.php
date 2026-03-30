<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.chained.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript">
$(document).ready(function(){$("#from_date").datepicker({
		dateFormat:"dd-M-yy",changeYear:1,changeMonth:1,onSelect:function(sdt)
		{$("#to_date").datepicker({dateFormat:"dd-M-yy",changeYear:1,changeMonth:1})
		$("#to_date").datepicker("option","minDate",sdt)}})
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
<script type="text/javascript">
$(document).ready(function(){
// find the input fields and apply the time select to them.
$('#from_time').ptTimeSelect();
$('#to_time').ptTimeSelect();
});
</script>
<script type="text/javascript">
function doPost(page_no){
	var page_no_hidden = document.getElementById("page_no");
  	page_no_hidden.value=page_no;
        $('#appointment').submit();
   }
function onchange_page_dropdown(dropdownobj){
   doPost(dropdownobj.value);    
}
</script>

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
</style>

<style type="text/css">
	.selectize-control.repositories .selectize-dropdown > div {
border-bottom: 1px solid rgba(0,0,0,0.05);
}
.selectize-control {
display: inline-grid;
} 
</style>

	<?php 
	
	$page_no = 1;	
	
	?>
    <form id="columnsForm" method="POST">
        <input type="hidden" name="form_name" value="<?php echo $form_id; ?>">
        <div class="container">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p>
                        <span style="color:blue;">Note</span> : Please use this generate div, when you think to store data in blocks
                    </p>
                </div>

                <div class="col-md-3">
                    <button id="generateDivBtn" class="btn btn-success btn-block" type="button">
                        Generate Div
                    </button>
                </div>

                <div class="col-md-3">
                    <button id="defaultModeBtn" class="btn btn-info btn-block" type="button" style="display:none;">
                        Default Mode
                    </button>
                </div>
            </div>
        </div>
        <div id="defaultCheckboxes">
            <div class="row col-md-offset-2" style="text-align:justify;margin-bottom:100px;">
                <h2><?php echo $title; ?></h2><br/>
                <?php if (isset($columns) && !empty($columns)): ?>

                        <div class="col-md-12">
                            <?php 
                            $exclude_columns = ['gestation_type','gestation','insert_by_user_id','update_by_user_id','insert_datetime','update_datetime',
                                                    'hospital_id','add_by','add_time','update_by','update_time','country_code','state_code'];
                            foreach ($columns as $table => $columns_array): ?>
                                <div class="table-container">
                                    <h3>Table: <?php echo ucfirst($table); ?></h3>
                                    <div class="checkbox-group">
                                        <?php if (!empty($columns_array)): ?>
                                            <?php 
                                            $filtered_columns = array_filter($columns_array, function($column) use ($exclude_columns) {
                                                return !in_array($column, $exclude_columns);
                                            });

                                            $filtered_datatypes = [];
                                            if (!empty($datatype[$table])) {
                                                foreach ($columns_array as $index => $column_name) {
                                                    if (!in_array($column_name, $exclude_columns)) {
                                                        $filtered_datatypes[] = $datatype[$table][$index];
                                                    }
                                                }
                                            }
                                            ?>
                                            
                                            <?php foreach (array_values($filtered_columns) as $i => $column): ?>
                                                <label>
                                                    <input type="checkbox" 
                                                        name="selected_columns[<?php echo $table; ?>][]" 
                                                        value="<?php echo $column.'.'.$table; ?>" 
                                                        class="column-checkbox">
                                                    <?php echo $column; ?>
                                                </label>
                                                
                                                <input type="hidden" 
                                                    name="column_types[<?php echo $table; ?>][]" 
                                                    value="<?php echo (in_array(strtolower($filtered_datatypes[$i]), ['varchar', 'text']) ? 1 : 0); ?>" 
                                                    readonly 
                                                    class="datatype-input">
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p>No columns found for this table.</p>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="col-md-6"></div>
                        
                <?php else: ?>
                    <p>No columns found.</p>
                <?php endif; ?>
            </div>
        </div>
        <div id="divContainer" style="display:none;"></div>
        <div class="col-md-6"></div>
        <div class="col-md-4" style="margin-bottom:30px;margin-top:10px;">
            <input type="submit" class="btn btn-primary" name="submit" value="Submit">
        </div>
        <div class="col-md-2"></div>
    </form>
<!-- <script>
	$(document).ready(function() {
		$("#columnsForm").on("submit", function(event) {
			event.preventDefault();
			var selectedColumns = [];
			var columnTypes = [];

            $("input.column-checkbox:checked").each(function(index) {
                selectedColumns.push($(this).val());
                var datatypeInput = $(this).closest('label').next('.datatype-input').val();
                columnTypes.push(datatypeInput);
            });

			var formData = {
				form_name: $("input[name='form_id']").val(),
				selected_columns: selectedColumns,
                column_types: columnTypes
			};
            //alert(JSON.stringify(formData));
			$.ajax({
				url: '<?php echo base_url('register/submit_columns'); ?>',
				type: 'POST',
				data: formData,
				success: function(response) {
                    var res = JSON.parse(response);
					if (res.status === 'success') {
                        alert(res.message);
                        window.location.href = '<?php echo base_url('user_panel/add_patient_visit_custom'); ?>';
                    } else {
                        alert(res.message);
                    }
				},
				error: function(xhr, status, error) {
					console.log('Error: ' + error);
				}
			});
		});
	});
</script> -->
<script>
    let divCount = 0;

    $(document).ready(function() {

        $("#generateDivBtn").click(function() {
            $("#defaultCheckboxes").hide();
            $("#divContainer").show();
            $("#defaultModeBtn").show();
            divCount++;
            createDiv(divCount);
            toggleRemoveButtons();
        });

        $("#defaultModeBtn").click(function() {
            $("#defaultCheckboxes").show();
            $("#divContainer").hide();
            $("#defaultModeBtn").hide();
            $("#divContainer").html("");
            divCount = 0;
        });

        function createDiv(divNumber) {
            let html = `
                <div class="generatedDiv col-md-offset-2" data-div="${divNumber}" style="border:1px solid #ccc; padding:15px; margin-top:20px;">
                    <h4>Div ${divNumber}</h4>
                    <button type="button" class="btn btn-danger btn-sm removeDiv" data-div="${divNumber}" style="float:right;">
                        Remove
                    </button>
                    <div class="row">
                        <div class="col-md-3">
                            <label><b>Name:</b>
                                <input type="text" name="div_name[]" class="form-control" required autocomplete="off">
                            </label>
                        </div>

                        <div class="col-md-6">
                            <label><b>Column Layout:</b></label><br>

                            <div class="d-flex gap-2">
                                <label class="mb-0">
                                    <input type="radio" name="layout[${divNumber}]" value="1" class="layout-radio" data-div="${divNumber}" checked>
                                    1
                                </label>

                                <label class="mb-0">
                                    <input type="radio" name="layout[${divNumber}]" value="2" class="layout-radio" data-div="${divNumber}">
                                    2
                                </label>

                                <label class="mb-0">
                                    <input type="radio" name="layout[${divNumber}]" value="3" class="layout-radio" data-div="${divNumber}">
                                    3
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- ====== END ADDED ====== -->

                    <!-- ====== UPDATED: Added id and row class ====== -->
                    <div class="checkbox-group row" id="checkboxGroup_${divNumber}" style="padding:20px;">
                        <?php foreach ($columns as $table => $columns_array): ?>
                            <div class="table-container">
                                <h5>Table: <b><?php echo ucfirst($table); ?></b></h5>
                                <div class="checkbox-group">
                                    <?php foreach ($columns_array as $column): ?>
                                        <?php if (!in_array($column, $exclude_columns)): ?>
                                            <label>
                                                <input type="checkbox" class="column-checkbox" 
                                                    name="selected_columns[${divNumber}][]" 
                                                    value="<?php echo $column.'.'.$table; ?>">
                                                <?php echo $column; ?>
                                            </label>

                                            <input type="hidden" 
                                                name="column_types[${divNumber}][]" 
                                                value="<?php echo (in_array(strtolower($datatype[$table][array_search($column,$columns_array)]), ['varchar','text']) ? 1 : 0); ?>">
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            `;

            $("#divContainer").append(html);
        }
        // Submit
        function toggleRemoveButtons() {
            let totalDivs = $('.generatedDiv').length;

            if (totalDivs <= 1) {
                $('.removeDiv').hide(); 
            } else {
                $('.removeDiv').show();
            }
        }

        $(document).on('click', '.removeDiv', function () {
            let divNo = $(this).data('div');

            if (confirm("Are you sure you want to remove this div?")) {
                $('.generatedDiv[data-div="' + divNo + '"]').remove();
                renumberDivs(); 
                toggleRemoveButtons();
            }
        });

        function renumberDivs() {
            $('.generatedDiv').each(function (index) {

                let newNumber = index + 1;

                $(this).attr('data-div', newNumber);

                $(this).find('h4').contents().first()[0].textContent = 'Div ' + newNumber + ' ';

                $(this).find('.removeDiv').attr('data-div', newNumber);

                $(this).find('.layout-radio').each(function () {
                    $(this).attr('name', 'layout[' + newNumber + ']');
                    $(this).attr('data-div', newNumber);
                });

                $(this).find('.checkbox-group.row').attr('id', 'checkboxGroup_' + newNumber);

                $(this).find('.column-checkbox').attr('name', 'selected_columns[' + newNumber + '][]');

                $(this).find('input[type="hidden"]').each(function () {
                    if ($(this).attr('name') && $(this).attr('name').includes('column_types')) {
                        $(this).attr('name', 'column_types[' + newNumber + '][]');
                    }
                });

            });
        }

        $("#columnsForm").on("submit", function(event) {
            event.preventDefault();

            $('.generatedDiv').each(function () {
                let divNo = $(this).data('div');
                let input = $(this).find('input[name="div_name[]"]');

                let currentVal = input.val().trim();

                if (currentVal !== "") {
                    input.val(currentVal + '_' + divNo); // 👉 div_one → div_one_1
                }
            });
            var formData = $(this).serialize();

            $.ajax({
                url: '<?php echo base_url('register/submit_columns'); ?>',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        alert(res.message);
                        window.location.href = '<?php echo base_url('user_panel/add_patient_visit_custom'); ?>';
                    } else {
                        alert(res.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.log('Error: ' + error);
                }
            });
        });

        $(document).on('change', '.layout-radio', function () {
            let divNumber = $(this).data('div');
            let layout = $(this).val();
            let colClass = 'col-md-12';

            if (layout == 2) colClass = 'col-md-6';
            if (layout == 3) colClass = 'col-md-4';

            $('#checkboxGroup_' + divNumber + ' .checkbox-item')
                .removeClass('col-md-12 col-md-6 col-md-4')
                .addClass(colClass);
        });

        // Prevent duplicate column selection across divs
        $(document).on('change', '.column-checkbox', function () {
            if ($(this).is(':checked')) {
                let currentDiv = $(this).closest('.generatedDiv').data('div');
                let columnValue = $(this).val();
                let alreadyFound = false;
                $('.generatedDiv').each(function () {
                    let divNo = $(this).data('div');

                    if (divNo != currentDiv) {
                        $(this).find('.column-checkbox:checked').each(function () {
                            if ($(this).val() === columnValue) {
                                alreadyFound = true;
                                let divName = $(this).closest('.generatedDiv').find('input[name="div_name[]"]').val();
                                alert("Field already selected in (" + divName + ")");
                                return false;
                            }
                        });

                        if (alreadyFound) return false;
                    }
                });
                if (alreadyFound) {
                    $(this).prop('checked', false);
                }
            }
        });
    });
</script>
