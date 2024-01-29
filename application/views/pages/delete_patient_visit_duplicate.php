<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
<style>
        /* Apply responsive styles for smaller screens */
        @media screen and (max-width: 600px) {
            table {
                width: 100%;
                overflow-x: auto;
                display: block;
            }

            th, td {
                white-space: nowrap;
                max-width: 100%;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        }
    </style>

<h3 class="col-md-12">Delete Patient Visit Duplicate</h3>
<?php echo form_open("patient/delete_patient_visit_duplicate",array('role'=>'form','class'=>'form-custom col-md-12')); ?>   
 	   <div class="form-group">     
          <label for="patient_id">Patient ID:</label>         
          <input type="text" class="form-control" placeholder="Patient ID" id="patient_id" value="<?php echo $this->input->post('patient_id');?>" name="patient_id" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" autocomplete="off" required>  
        </div>
            <input type="submit" value="Get details" name="submitBtn" class="btn btn-primary btn-sm" /> 
</form>
<br>
<br>
<br>
<br>
<?php 
if(isset($patient_visit_data) && count($patient_visit_data)>0)
{
    $prev = $patient_visit_data[0]; $i = 1;
    for($j=0; $j < count($patient_visit_data) ; $j++){
		$p = $patient_visit_data[$j];
		if($j == 0 || $p->patient_id != $prev->patient_id){
?>
			<div class="panel panel-default" style="margin-top:30px;" >
					<div class="panel-heading">
							<h4><b>Search Results</b></h4>
							<?php  echo "| <b>H4A Patient ID</b> : ".$p->patient_id." | ";
							 echo "<b>Patient</b> : ".$p->first_name." | ";
							 echo "<b>Age</b> : ".$p->age_years."Y ".$p->age_months."M ".$p->age_days."D"." | ";
							 if ($p->gender!="0"){							 
							 	echo "<b>Gender</b> : ".$p->gender." | ";			 
							 }
							 echo "<b>Phone</b> : ".$p->phone." | ";
							 echo "<b>Address</b> : ".$p->address. " | ";
							?>
							<br/>
							<table class="table table-striped table-hover">
								<caption><h4><b>Visit History</b></h4></caption>
									<thead>
										<tr>
											<th style="text-align:center">#</th>
											<th style="text-align:center">Date</th>
											<th style="text-align:center">Hospital</th>
											<th style="text-align:center">OP/IP No</th>
											<th style="text-align:center">Department</th>
											<th style="text-align:center">Visit Name</th>
											<th style="text-align:center">Appointment Date</th>
										</tr>
									</thead>
						</div>
						<div class="panel-body">
									<tbody><?php } ?>
										<tr>
											<td><?php echo $i++; ?></td>	
											<td style="text-align:center"><?php echo date("d-M-Y",strtotime($p->admit_date));?></td>
											<td style="text-align:center"><?php echo $p->hospital_name; ?></td>
											<td style="text-align:center"><?php echo $p->visit_type." #".$p->op_ip_no; ?></td>
											<td style="text-align:center"><?php echo $p->dept_name;?></td>
											<td style="text-align:center"><?php echo $p->visit_name;?></td>
											<td style="text-align:center"><?php if(isset($p->appointment_time) && $p->appointment_time!="") {echo date("j M Y", strtotime("$p->appointment_time"));} ?></td>
											<td>
												<a data-id="<?php echo $p->visit_id;?>" class="btn btn-success" id="del" >Delete</a>
											</td>
											</tr>
										<?php $prev = $p;
										} ?>
										</tbody>
								</table>
								<script>
									$(document).on("click",'#del',function(){
										var $btn = $(this);
										var visit_id = $btn.attr("data-id");
										conf = confirm('Are you sure you want to delete this entry?');
										if(conf==true)
										{
											$.ajax({
													type: "POST",
													url: "<?php echo base_url('patient/delete_patient_visit_id'); ?>",
													data: {visit_id:visit_id},
													success: function(response) {
														//console.log(response);
														$btn.closest('tr').remove();
														fetchAndRefreshTable();
													},
													error: function(error) {
														console.error("Error:", error);
													}
												});
										}else
										{
											return false;
										}
									})
									
								</script>
					   </div>
				</div>
        
<?php } ?>

<h2>Delete History</h2>
<table class="table table-bordered table-striped" id="table-sort">
	<thead>
    <tr>
        <th style="text-align:center">S.no</th>
        <th style="text-align:center">Date</th>
        <th style="text-align:center">Hospital</th>
        <th style="text-align:center">OP/IP No</th>
        <th style="text-align:center">Department</th>
        <th style="text-align:center">Visit Name</th>
        <th style="text-align:center">Appointment Date</th>
        <th style="text-align:center">Insert Datetime</th>
        <th style="text-align:center">Deleted by</th>
    </tr>
	</thead>
	<tbody id="tableBody">
		<tr>
			
		</tr>
	</tbody>
	<script>
		// Function to fetch and refresh table data based on patient ID
		function fetchAndRefreshTable() {
			var patient_id = $('#patient_id').val();
			$.ajax({
				url: '<?php echo base_url("patient/refresh_table"); ?>',
				type: 'POST',
				data: { patient_id:patient_id },
				dataType: 'json',
				success: function(response) {
					$('#tableBody').empty();
					i=1;
					$.each(response, function(index, item) {
					 	var row = '<tr><td>' + i++ + '</td>' +
									'<td>' + formatDate(item.admit_date) + '</td>' +
									'<td>' + item.hospital_name + '</td>' +
									'<td>' + item.visit_type + ' #' + item.op_ip_no + '</td>'+
									'<td>' + item.dept_name +'</td>'+
									'<td>' + (item.visit_name ? item.visit_name : '') + '</td>'+
									'<td>' + (item.appointment_time && item.appointment_time !== '0000-00-00' ? item.appointment_time : '') + '</td>' +
									'<td>' + item.delete_datetime +'</td>'+
									'<td>' + item.staff_name +'</td></tr>';
					 	$('#tableBody').append(row);
					 });
				},
				error: function(error) {
					console.log('Error fetching table data:', error);
				}
			});
		}
		$(document).ready(function() {
			fetchAndRefreshTable();
		});

		function formatDate(date) {
			var formattedDate = new Date(date);
			var day = formattedDate.getDate();
			var month = formattedDate.toLocaleString('default', { month: 'short' });
			var year = formattedDate.getFullYear();
			return day + '-' + month + '-' + year;
		}
	</script>
</table>

  
      
