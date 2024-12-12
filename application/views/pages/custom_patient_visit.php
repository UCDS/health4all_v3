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
			<?php echo form_open('user_panel/update_custom_patient_visit',array('class'=>'form-group','role'=>'form','id'=>'appointment')); ?>
		<?php } else { ?>
		<?php echo form_open('user_panel/add_patient_visit_custom',array('class'=>'form-group','role'=>'form','id'=>'appointment')); ?> 
		<?php } ?>
		<input type="hidden" name="page_no" id="page_no" value='<?php echo "$page_no"; ?>'>
		<div class="row" style="margin-top:2%;">
			<div class="col-md-4">
				<div class="form-group">
					<label for="inputrouteprimary ">Enter Form Name <span class="mandatory" style="color:red;">*</span> </label>
					<input type="text" name="report_name" class="form-control" placeholder="Enter Report Name" 
						value="<?php echo $edit_report_name['form_name'] ?>" autocomplete="off" required>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<label>Select Columns</label><br/>
					<label>
						<input type="radio" name="no_of_cols" <?php if($edit_report_name['no_of_cols'] == 1) echo "checked"; ?> value="1"> 1
					</label>
					<label>
						<input type="radio" name="no_of_cols" <?php if($edit_report_name['no_of_cols'] == 2) echo "checked"; ?> value="2"> 2
					</label>
					<label>
						<input type="radio" name="no_of_cols" <?php if($edit_report_name['no_of_cols'] == 3) echo "checked"; ?> value="3"> 3
					</label>
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
				<input type="hidden" name="record_id" value="<?php echo $edit_report_name['id']; ?>" >
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
		<th style="text-align:center">Form Name</th>
		<th style="text-align:center">Selected Cols</th>
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
		<td style="text-align:center"><?php echo $arn->form_name;?></td>	
		<td style="text-align:center"><?php echo $arn->no_of_cols;?></td>	
		<td style="text-align:center"><?php echo $arn->first_name;?></td>	
		<td style="text-align:center"><?php echo date("j M Y h:i A.", strtotime("$arn->created_date_time")); ?></td>	
		<td style="text-align:center"><?php echo $arn->updated_by_name;?></td>	
		<td style="text-align:center"><?php if($arn->updated_date_time!=''){ echo date("j M Y h:i A.", strtotime("$arn->updated_date_time")); } ?></td>
		<?php 
			$hospital=$this->session->userdata('hospital');
			if($arn->hospital_id==$hospital['hospital_id'])
			{
		?>
		<td style="text-align:center">
			<a class="btn btn-success" href="<?php echo base_url('user_panel/add_patient_visit_custom/'.$arn->id); ?>" style="color:white!important;">Edit Label</a>
			<?php $report_id_exists = false; ?>
			<?php foreach ($report_layout_report_id_count as $rl): ?>
				<?php if ($rl['form_id'] == $arn->id): ?>
					<?php $report_id_exists = true; ?>
					<a class="btn btn-danger" data-layout-id="<?php echo $arn->id; ?>" style="color:white!important;" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Layout">
						<i class="fa fa-trash"></i>
					</a>
					<a class="btn btn-warning" data-toggle="modal" data-target="#dataModal" data-view-id="<?php echo $arn->id; ?>" style="color:white!important;" data-bs-toggle="tooltip" data-bs-placement="top" title="View Layout">
						<i class="fa fa-eye"></i>
					</a>
					<?php break; ?>
				<?php endif; ?>
			<?php endforeach; ?>
			<?php if (!$report_id_exists): ?>
				<a class="btn btn-info" href="<?php echo base_url('register/generate_table_checkboxes/'.$arn->id); ?>" style="color:white!important;" data-bs-toggle="tooltip" data-bs-placement="top" title="Add Layout">
					<i class="fa fa-plus"></i>
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
			$('.btn-danger').on('click', function(e) 
			{
				e.preventDefault();
				if (confirm("Are you sure want to delete this custom patient visit layout?")) 
				{
					var layout_id = $(this).data('layout-id');
					$.ajax({
						type: 'POST',
						url: '<?php echo base_url('user_panel/custom_patient_visit_layout_delt'); ?>',
						data: { layout_id: layout_id },
						dataType: 'json',
						success: function(response) {
							if (response.status == "success") {
								alert(response.message);
								location.reload();
							} else {
								alert('Failed to delete custome patient visit');
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
					url: '<?php echo base_url('user_panel/fetch_saved_custom_patient_visit'); ?>',
					type: 'post',
					data: { report_id: report_id },
					dataType: 'json',
					success: function(response) {
						$('#dataBody').empty();
						var rows = '';
						var mainTableSet = new Set();
						var showUpdateButton = false;
						var allValidData = true;
						var editButton = false;

						$.each(response, function(index, data) {
							var sequenceValue = (data.sequence_id == 0 || data.sequence_id === null) ? '' : data.sequence_id;
							var labelValue = data.label || '';

							if (labelValue === '' || sequenceValue === '' || sequenceValue === 0) {
								allValidData = false;
							}

							var labelColumn = labelValue !== '' 
								? '<td>' + labelValue + '</td>' 
								: '<td><input type="text" placeholder="Enter Label" class="form-control label-input" data-id="' + data.main_id + '" value="' + labelValue + '"></td>';

							var sequenceColumn = sequenceValue !== '' && sequenceValue !== 0 
								? '<td>' + sequenceValue + '</td>' 
								: '<td><input type="number" placeholder="Enter Sequence" class="form-control sequence-input" data-id="' + data.main_id + '" value="' + sequenceValue + '"></td>';

							var selectedColumnsColumn = data.selected_columns || '';

							var editButton = labelValue !== '' ? '<td><button class="btn btn-warning btn-sm edit-row" data-id="' + data.main_id + '">Edit</button></td>' : '<td></td>';

							rows += '<tr class="sortable-row" data-id="' + data.main_id + '">' +
										'<td>' + data.table_name + '</td>' +
										'<td>' + selectedColumnsColumn + '</td>' +
										labelColumn +
										sequenceColumn +
										editButton +
									'</tr>';

							if (labelValue === '' || sequenceValue === '' || sequenceValue === 0) {
								showUpdateButton = true;
							}

							mainTableSet.add(data.main_table);
						});

						$('#dataBody').html(rows);

						updateSequenceNumbers();

						if(showUpdateButton)
						{
							$('#dataBody').sortable({
								items: 'tr.sortable-row',
								update: function(event, ui) {
									updateSequenceNumbers();
								}
							});
						}
						if (showUpdateButton && !editButton) {
							$('#updateButton').show();
						} else {
							$('#updateButton').hide();
						}

						if (allValidData) {
							$('#dataModal .table th').eq(2).text('Label');
							$('#dataModal .table th').eq(3).text('Sequence ID');
						} else {
							$('#dataModal .table th').eq(2).text('Add Label');
							$('#dataModal .table th').eq(3).text('Sequence');
						}

						$('#dataModal').modal('show');
					},
					error: function() {
						alert('Error fetching data.');
					}
				});
			});

			function updateSequenceNumbers() {
				var sequence = 1;
				$('#dataBody .sortable-row').each(function() {
					var sequenceInput = $(this).find('.sequence-input');
					if (sequenceInput.length) {
						sequenceInput.val(sequence);
						sequenceInput.prop('readonly', true);
					}
					sequence++;
				});
			}


			$(document).on('click', '.edit-row', function() {
				var main_id = $(this).data('id');
				
				var row = $(this).closest('tr');
				
				var selectedColumns = row.find('td').eq(1).text();
				var label = row.find('td').eq(2).text();
				var sequence = row.find('td').eq(3).text();
				
				row.find('td').eq(1).html('<input type="text" class="form-control selected-columns-input" value="' + selectedColumns + '" data-id="' + main_id + '">');
				row.find('td').eq(2).html('<input type="text" class="form-control label-input" value="' + label + '" data-id="' + main_id + '">');
				row.find('td').eq(3).html('<input type="number" class="form-control sequence-input" value="' + sequence + '" data-id="' + main_id + '" readonly>');
				
				$(this).removeClass('btn-warning').addClass('btn-success').text('Save').removeClass('edit-row').addClass('save-row');
				row.find('td:last').append('<i class="fa fa-times cancel-column" title="Cancel" style="cursor:pointer;"></i>');
			});

			$(document).on('click', '.cancel-column', function() {
				var row = $(this).closest('tr');
				var selectedColumns = row.find('.selected-columns-input').val();
				var label = row.find('.label-input').val();
				var sequence = row.find('.sequence-input').val();
				
				row.find('td').eq(1).text(selectedColumns);
				row.find('td').eq(2).text(label);
				row.find('td').eq(3).text(sequence);
				
				row.find('.save-row')
					.removeClass('btn-success')
					.addClass('btn-warning')
					.text('Edit')
					.removeClass('save-row')
					.addClass('edit-row');
				row.find('.cancel-column').remove();
			});

			$(document).on('click', '.save-row', function() {
				var main_id = $(this).data('id');
				
				var selectedColumns = $(this).closest('tr').find('.selected-columns-input').val();
				var label = $(this).closest('tr').find('.label-input').val();
				var sequence = $(this).closest('tr').find('.sequence-input').val();
				//alert(sequence);
				$.ajax({
					url: '<?php echo base_url('user_panel/update_row_cutom_layout'); ?>', 
					type: 'post',
					data: { main_id: main_id, selected_columns: selectedColumns, label: label, sequence_id: sequence },
					dataType: 'json',
					success: function(response) 
					{
						if (response.success) 
						{
							alert(response.message); 
							location.reload();
						} else 
						{
							alert('Failed to update the row. ' + response.message);
						}
					},
					error: function() {
						alert('Error saving the data.');
					}
				});
			});

			$('#updateButton').click(function() {
				var updates = [];
				
				$('.label-input').each(function() {
					var id = $(this).data('id');
					var label = $(this).val();
					var sequence = $(this).closest('tr').find('.sequence-input').val();

					updates.push({
						id: id,
						label: label,
						sequence: sequence
					});
				});

				// Send the updates to the server
				$.ajax({
					url: '<?php echo base_url('user_panel/save_updated_label_seqeunce'); ?>',
					type: 'post',
					data: { updates: JSON.stringify(updates) },
					dataType: 'json',
					success: function(response) {
						if (response.success) {
							alert('Data updated successfully.');
							$('#dataModal').modal('hide');
							location.reload();
						} else {
							alert('Error updating data.');
						}
					},
					error: function() {
						alert('Error saving data.');
					}
				});
			});
		});

	</script>
	</table>
	<div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
			<div class="modal-header">
				<!-- <p> Sequnce can be added by draging columns<p> -->
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top:-12px!important;">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="table table-bordered">
				<thead>
					<tr>
					<th>Table Name</th>
					<th>Field Name</th>
					<th>Add Label</th>
					<th>Sequence </th>
					</tr>
				</thead>
				<tbody id="dataBody">
				</tbody>
				</table>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="updateButton">Update</button>
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

  
