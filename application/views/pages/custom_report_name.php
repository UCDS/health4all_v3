<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.chained.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/ckeditor.js"></script>
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
		
	<div class="row col-md-offset-2">
	<h2><?php echo $title; ?></h2>
		<?php if(!empty($edit_report_name)) { ?>
			<?php echo form_open('user_panel/update_custom_report_name',array('class'=>'form-group','role'=>'form','id'=>'appointment')); ?>
		<?php } else { ?>
		<?php echo form_open('user_panel/custom_report_name',array('class'=>'form-group','role'=>'form','id'=>'appointment')); ?> 
		<?php } ?>
		<input type="hidden" name="page_no" id="page_no" value='<?php echo "$page_no"; ?>'>
		<div class="row" style="margin-top:2%;">
			<div class="col-md-4">
				<div class="form-group">
					<label for="inputrouteprimary ">Enter Report Name <span class="mandatory" style="color:red;">*</span> </label>
					<input type="text" name="report_name" class="form-control" placeholder="Enter Report Name" 
						value="<?php echo $edit_report_name['report_name'] ?>" autocomplete="off" required>
				</div>
			</div>
				<?php 
				 	$user=$this->session->userdata('logged_in'); 
					$user['user_id'];
					$user_data=$this->session->userdata('logged_in');
					$user_data['staff_id'];
					if(!empty($edit_report_name))
					{
				?>
					<input type="hidden" class="form-control" name="updated_by" value="<?php echo $user['staff_id'] ?>">
					<input type="hidden" class="form-control" name="updated_datetime" value="<?php echo date('Y-m-d H:i:s') ?>">
				<?php } else { ?>
					<input type="hidden" class="form-control" name="added_by" value="<?php echo $user['staff_id'] ?>">
					<input type="hidden" class="form-control" name="insert_datetime" value="<?php echo date('Y-m-d H:i:s') ?>">
				<?php } ?>
				<input type="hidden" class="rows_per_page form-custom form-control" name="rows_per_page" id="rows_per_page" min=<?php echo $lower_rowsperpage; ?> max= <?php echo $upper_rowsperpage; ?> step="1" value= <?php if($this->input->post('rows_per_page')) { echo $this->input->post('rows_per_page'); }else{echo $rowsperpage;}  ?> onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" /> 
				<input type="hidden" name="record_id" value="<?php echo $edit_report_name['report_id']; ?>" >
				<?php if(!empty($edit_report_name)) { ?>
					<input class="btn btn-md btn-success" type="submit" value="Update" style="margin-top:24px;margin-left:20px;">
				<?php } else { ?>
				<input class="btn btn-md btn-primary" type="submit" value="Submit" style="margin-top:24px;margin-left:20px;">
				<?php } ?>
		</div>
		</form>
		<?php if (!empty($error) || $error!=0): ?>
			<span style="color: red;"><?php echo $error; ?></span>
		<?php elseif (isset($success)): ?>
			<span style="color: green;"><?php echo $success; ?></span>
		<?php endif; ?>
	<br />


<?php if(isset($all_report_name) && count($all_report_name)>0)
{ ?>
<div style='padding: 0px 2px;'>

<h5>Data as on <?php echo date("j-M-Y h:i A"); ?></h5>

</div>
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
	$total_records = $all_report_name_count[0]->count ;
	$total_no_of_pages = ceil($total_records / $total_records_per_page);
	if ($total_no_of_pages == 0)
		$total_no_of_pages = 1;
	$second_last = $total_no_of_pages - 1; 
	$offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2";	
?>

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
	
	<table class="table table-bordered table-striped" id="table-sort" style="width:100%">
	<thead>
		<th style="text-align:center">#</th>
		<th style="text-align:center">Report Name</th>
		<th style="text-align:center">Created by</th>
		<th style="text-align:center">Created Datetime</th>
		<th style="text-align:center">Updated by</th>
		<th style="text-align:center">Updated Datetime</th>		
		<th style="text-align:center">Actions</th>		
	</thead>
	<tbody>
	<?php 
	$sno=(($page_no - 1) * $total_records_per_page)+1 ; 
	
	foreach($all_report_name as $arn) 
	{ 
	?>
	<tr>
		<td style="text-align:right"><?php echo $sno;?></td>
		<td style="text-align:center"><?php echo $arn->report_name;?></td>	
		<td style="text-align:center"><?php echo $arn->first_name;?></td>	
		<td style="text-align:center"><?php echo date("j M Y h:i A.", strtotime("$arn->created_date_time")); ?></td>	
		<td style="text-align:center"><?php echo $arn->updated_by_name;?></td>	
		<td style="text-align:center"><?php if($arn->updated_date_time!=''){ echo date("j M Y h:i A.", strtotime("$arn->updated_date_time")); } ?></td>
		<?php 
			$hospital=$this->session->userdata('hospital');
			if($arn->hospital_id==$hospital['hospital_id'])
			{
		?>
		<td style="text-align:center" >
			<a class="btn btn-primary" href="<?php echo base_url('user_panel/custom_report_name/'.$arn->report_id); ?>" style="color:white!important;">Edit Label</a>
			
			<?php $report_id_exists = false; ?>
			<?php foreach ($report_layout_report_id_count as $rl): ?>
				<?php if ($rl['report_id'] == $arn->report_id): ?>
					<?php $report_id_exists = true; ?>
					<a class="btn btn-danger" data-layout-id="<?php echo $arn->report_id; ?>" style="color:white!important;" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Layout">
						<i class="fa fa-trash"></i>
					</a>
					<a class="btn btn-warning" data-toggle="modal" data-target="#dataModal" data-view-id="<?php echo $arn->report_id; ?>" style="color:white!important;" data-bs-toggle="tooltip" data-bs-placement="top" title="View Layout">
						<i class="fa fa-eye"></i>
					</a>
					<?php break; ?>
				<?php endif; ?>
			<?php endforeach; ?>
			<?php if (!$report_id_exists): ?>
				<a class="btn btn-info" href="<?php echo base_url('user_panel/custom_report_layout/'.$arn->report_id); ?>" style="color:white!important;" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Layout">
					Add Layout
				</a>
			<?php endif; ?>
		</td>
		<?php } ?>
	</tr>
	<?php $sno++;}	?>
	</tbody>
	<script>
		$(document).ready(function() {
			$('#dataModal').modal('hide');
			$('#updateSequenceBtn').hide();
			$('#enableSortingCheckbox').change(function() {
				if ($(this).prop('checked')) {
					$('#dataBody').sortable({
						items: 'tr',
						update: function(event, ui) {
							$('#dataBody tr').each(function(index) {
								$(this).find('.sequence-id').text(index + 1); 
								$(this).data('sequence-id', index + 1);
							});
						}
					});
					$('#updateSequenceBtn').show();
				} else {
					$('#dataBody').sortable('destroy');
					$('#updateSequenceBtn').hide();
				}
			});
			if ($('#enableSortingCheckbox').prop('checked')) {
				$('#dataBody').sortable({
					items: 'tr',
					update: function(event, ui) {
						$('#dataBody tr').each(function(index) {
							$(this).find('.sequence-id').text(index + 1); 
							$(this).data('sequence-id', index + 1);
						});
					}
				});
				$('#updateSequenceBtn').show(); 
			}
			$('#updateSequenceBtn').click(function() {
				var newSequence = [];

				$('#dataBody tr').each(function() {
					var id = $(this).data('id');
					var sequenceId = $(this).data('sequence-id');
					newSequence.push({ id: id, sequence_id: sequenceId });
				});

				$.ajax({
					url: '<?php echo base_url('user_panel/update_sequence_custom_report'); ?>',
					type: 'POST',
					data: { sequence: newSequence },
					dataType: 'json',
					success: function(response) {
						console.log("Response from server:", response);
						if (response.status == 'success') {
							alert('Sequence updated successfully!');
							location.reload();
						} else {
							alert('Error updating sequence: ' + response.message);
						}
					},
					error: function(xhr, status, error) {
						console.error("AJAX Error:", error);
						alert('An error occurred while updating the sequence.');
					}
				});
			});
			$('.btn-danger').on('click', function(e) 
			{
				e.preventDefault();
				if (confirm("Are you sure you want to delete this custom report?")) 
				{
					var layout_id = $(this).data('layout-id');
					$.ajax({
						type: 'POST',
						url: '<?php echo base_url('user_panel/custom_report_layout_delt'); ?>',
						data: { layout_id: layout_id },
						dataType: 'json',
						success: function(response) {
							if (response.status == "success") {
								alert(response.message);
								location.reload();
							} else {
								alert('Failed to delete custome layout');
							}
						},
						error: function(xhr, status, error) {
							console.error('Ajax request failed');
						}
					});
				}
			});
			$('.btn-warning').click(function() {
				var report_id = $(this).data('view-id');
				$.ajax({
					url: '<?php echo base_url('user_panel/fetch_saved_custom_layout'); ?>',
					type: 'post',
					data: { report_id: report_id },
					dataType: 'json',
					success: function(response) {
						$('#dataBody').empty();
						var rows = '';
						var mainTableSet = new Set();
						$.each(response, function(index, data) {
							var concate = data.concate;
							if (concate) {
								concate = concate.split(',').join('<br>');
							}
							rows += '<tr data-id="' + data.id + '">' +
									'<td class="column-name">' + data.column_name + '</td>' +
									'<td class="table-name-field">' + data.table_name + '.' + data.field_name + 
									(data.concate ? ', ' + data.concate.replace(/,/g, ',<br>') : '') + '</td>' + 
									'<td class="function">' + data.function + '</td>' +
									'<td class="width">' + (data.width != 0 ? data.width : '') + '</td>' +
									'<td class="field-sep">' + data.fields_sep + '</td>' +
									'<td class="sequence-id">' + data.sequence_id + '</td>' +
									'<td>' +
											'<button class="btn btn-edits btn-warning edit-column" data-report-id="' + report_id + '" title="Edit">' +
												'<i class="fa fa-edit"></i>' +
											'</button>' +
											'&nbsp;' +  // Adds space between icons
											'<button class="btn btn-danger delete-column" data-id="' + data.id + '" title="Delete">' +
												'<i class="fa fa-trash"></i>' +
											'</button>' +
										'</td>' + '</tr>';
							mainTableSet.add(data.main_table);
						});
						$('#dataBody').html(rows);
						var modalTitle = 'Layout Fields';
						if (mainTableSet.size > 0) {
							modalTitle += ' - primary table : ' + Array.from(mainTableSet).join(', ');
						}
						$('#dataModalLabel').html(modalTitle);
						$('#dataModal').modal('show');
					},
					error: function() {
						alert('Error fetching data.');
					}
				});
			});
		});

		$(document).on('click', '.btn-warning.edit-column', function() {
			var row = $(this).closest('tr');

			row.find('.delete-column').hide();

			var columnNameCell = row.find('.column-name');
			var tableNameFieldCell = row.find('.table-name-field');
			var functionCell = row.find('.function');
			var widthCell = row.find('.width');
			var fieldsSepCell = row.find('.field-sep');

			var columnName = columnNameCell.text();
			var tableNameField = tableNameFieldCell.text();
			var functionName = functionCell.text();
			var width = widthCell.text();
			var fieldsSep = fieldsSepCell.text();

			row.data('original-column-name', columnName);
			row.data('original-table-name-field', tableNameField);
			row.data('original-function', functionName);
			row.data('original-width', width);
			row.data('original-fields-sep', fieldsSep);

			columnNameCell.html('<input type="text" class="form-control" value="' + columnName + '" />');
			tableNameFieldCell.html('<input type="text" class="form-control" value="' + tableNameField + '" />');

			widthCell.html('<input type="text" class="form-control" value="' + width + '" />');
			fieldsSepCell.html('<input type="text" class="form-control" value="' + fieldsSep + '" />');

			if (functionName === '#') {
				functionCell.html('<select class="form-control"><option value="Selection" ' + (functionName === 'Selection' ? 'selected' : '') + '>Select</option><option value="min" ' + (functionName === 'min' ? 'selected' : '') + '>Min</option><option value="max" ' + (functionName === 'max' ? 'selected' : '') + '>Max</option></select>');
			} else if (functionName) {
				functionCell.html('<input type="text" class="form-control" value="' + functionName + '" />');
			} else {
				functionCell.html('');
			}

			$(this).replaceWith('<button class="btn btn-success save-column" data-report-id="' + $(this).data('report-id') + '"><i class="fa fa-check"></i></button>');
			row.find('td:last').append('<i class="fa fa-times cancel-column" title="Cancel" style="cursor:pointer;"></i>');
		});

		$(document).on('click', '.save-column', function() {
			var row = $(this).closest('tr');
			var id = row.data('id');
			var reportId = $(this).data('report-id');
			var columnName = row.find('.column-name input').val();
			var tableNameField = row.find('.table-name-field input').val();
			var functionName = row.find('.function select').val() || row.find('.function input').val();  // Get selected value from dropdown or input
			var width = row.find('.width input').val();
			var fieldsSep = row.find('.field-sep input').val();
			var btn = $(this);

			$.ajax({
				url: '<?php echo base_url('user_panel/update_custom_field_col_name'); ?>',
				type: 'post',
				data: {
					id: id,
					report_id: reportId,
					column_name: columnName,
					table_name_field: tableNameField,
					function_name: functionName,
					width: width,
					fields_sep: fieldsSep
				},
				dataType: 'json',
				success: function(response) {
					if (response.success) {
						row.find('.column-name').text(columnName);
						row.find('.table-name-field').html(tableNameField);
						row.find('.function').html(functionName);
						row.find('.width').html(width);
						row.find('.field-sep').html(fieldsSep);

						btn.removeClass('btn-success').addClass('btn-warning').text('Edit');
						row.find('.cancel-column').remove();
						alert('Data updated successfully.');

						location.reload();

						$('#dataModal').modal('hide');
					} else {
						alert('Error updating the record.');
					}
				},
				error: function() {
					alert('Error sending data to the server.');
				}
			});
		});

		$(document).on('click', '.btn.btn-primary[data-dismiss="modal"]', function() {
			location.reload();
		});
		
		$(document).on('click', '.cancel-column', function() {
			var row = $(this).closest('tr');
			var columnNameCell = row.find('.column-name');
			var tableNameFieldCell = row.find('.table-name-field');
			var functionCell = row.find('.function');
			var widthCell = row.find('.width');
			var fieldsSepCell = row.find('.field-sep');

			columnNameCell.text(row.data('original-column-name'));
			tableNameFieldCell.text(row.data('original-table-name-field'));
			functionCell.text(row.data('original-function'));
			widthCell.text(row.data('original-width'));
			fieldsSepCell.text(row.data('original-fields-sep'));

			row.find('.btn-success').remove();
			row.find('.cancel-column').remove();

			var editButton = '<button class="btn btn-warning edit-column" data-report-id="' + row.find('.edit-column').data('report-id') + '" title="Edit"><i class="fa fa-edit"></i></button>';
			
			var deleteButton = '<button class="btn btn-danger delete-column" data-id="' + row.find('.delete-column').data('id') + '" title="Delete"><i class="fa fa-trash"></i></button>';

			row.find('td:last').append(editButton);
			row.find('td:last').append('&nbsp;');     
    		row.find('td:last').append(deleteButton);
			
		});

		$(document).on('click', '.delete-column', function() {
			var row = $(this).closest('tr');
			var reportId = $(this).data('id');
			if (confirm('Are you sure you want to delete this item?')) {
				$.ajax({
					url: '<?php echo base_url('user_panel/delete_custom_field_cols'); ?>',
					method: 'POST',
					data: {
						id: reportId,
						action: 'delete'
					},
					dataType: 'json',
					success: function(response) {
						console.log(response);
						console.log("Success value: ", response.success);
						if (response.success === true) {
							row.remove();
							alert('Item deleted successfully!');
						} else {
							alert('Error deleting item!');
						}
					},
					error: function() {
						alert('An error occurred while deleting.');
					}
				});
			}
		});
		
	</script>
	</table>
	<div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true" >
		<div class="modal-dialog" role="document" style="width:55%;">
			<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="dataModalLabel"></h5><br/>
				<input type="checkbox" id="enableSortingCheckbox" style="margin-left: 10px;">
                <label for="enableSortingCheckbox" style="margin-left: 5px;">Enable Sorting</label>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-19px!important;">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
				<thead>
					<tr>
					<th>Column Name</th>
					<th>Field Name</th>
					<th>Function</th>
					<th>Width</th>
					<th>Separator</th>
					<th>Sequence</th>
					</tr>
				</thead>
				<tbody id="dataBody">
				</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-link" id="updateSequenceBtn"><strong>Update Sequence</strong></button>
				<button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
			</div>
			</div>
		</div>
	</div>
<div style='padding: 0px 2px;'>

<h5>Page <?php echo $page_no." of ".$total_no_of_pages." (Total ".$total_records.")" ; ?></h5>

</div>

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
	<?php } else { ?>
	No data to display
<?php }  ?>
</div>	

  
