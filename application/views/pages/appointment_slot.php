<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.chained.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
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
<script type="text/javascript">
$(document).ready(function(){$("#from_date").datepicker({
		dateFormat:"dd-M-yy",changeYear:1,changeMonth:1,onSelect:function(sdt)
		{$("#to_date").datepicker({dateFormat:"dd-M-yy",changeYear:1,changeMonth:1,beforeShow: function (input) {
                    $(input).css({
                        "position": "relative",
                        "z-index": 1
                    });
                },onClose: function () { $('.ui-datepicker').css({ 'z-index': 0  } ); } })
		$("#to_date").datepicker("option","minDate",sdt)},beforeShow: function (input) {
                    $(input).css({
                        "position": "relative",
                        "z-index": 1
                    });
                },
                onClose: function () { $('.ui-datepicker').css({ 'z-index': 0  } ); } 
                })
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
var is_updated = false;
function doPost(page_no){
	var page_no_hidden = document.getElementById("page_no");
  	page_no_hidden.value=page_no;
        $('#appointment').submit();
   }
function onchange_page_dropdown(dropdownobj){
   doPost(dropdownobj.value);    
}


function delete_appointment_slot(e) {
	e.preventDefault();
	var event_prop = e;
	bootbox.confirm({
    		message: "Do you really want to delete the Receiver ?" ,
    		buttons: {
        		confirm: {
            		label: 'Yes',
            		className: 'btn-success'
        		},
        		cancel: {
            		label: 'No',
            		className: 'btn-danger'
        		}
    		},
    		callback: function (result) {
        		if(result){      
        		var id=$(event_prop.target).data('id');
        		console.log(id);  		 	
				var form =  document.getElementById("delete_appointment_slot_"+id);
				var data = new FormData(form);


			$.ajax({
				type: "POST",
				enctype: 'multipart/form-data',
				url: $(form).attr('action'),
				data: data,
				processData: false,
				contentType: false,
				cache: false,
				success: function (data) {
					// show success notification here...

					location.reload();
				},
			    error: function (error) {
				   bootbox.alert('Deletion Failed');
				    // show error notification here...
					$(event_prop.target).prop("disabled", false);
				}
			     });
        		}
    		}
	});

}

function addModalClose() {
	var dom = document.getElementById("no_of_appointments");
	dom.value = dom.min; 
	if (is_updated){
		location.reload();
	}
}
function addModalSubmit() {
	var department_modal = document.getElementById("department_modal").value;
	var visit_modal = document.getElementById("visit_modal").value;
	var date_modal = document.getElementById("date_modal").value;
	var from_time_modal = document.getElementById("from_time_modal").value;
	var to_time_modal = document.getElementById("to_time_modal").value;
	var no_of_appointments = document.getElementById("no_of_appointments").value;
	
	var from_time = new Date(date_modal+' '+from_time_modal);
	var to_time = new Date(date_modal+' '+to_time_modal);

	
	if (department_modal.length === 0 || visit_modal.length === 0 || from_time_modal.length === 0 || to_time_modal.length === 0 || date_modal.length === 0 || no_of_appointments.length === 0 ) {
		bootbox.alert("Please fill all the values");
		return;	
	}
	
	if (from_time > to_time){
		bootbox.alert("End time should be greater than Start time");
		return;
	}	
	
	if (no_of_appointments <= -1 ){
		bootbox.alert("No of Appointments should be greater than or equal to zero");
		return;
	}
	
	$('#modalSubmit').prop("disabled", true);
	var addModalForm = document.getElementById("addModalForm");
	var data = new FormData(addModalForm);
	$.ajax({
			type: "POST",
			enctype: 'multipart/form-data',
			url: $(addModalForm).attr('action'),
			data: data,
			processData: false,
			contentType: false,
			cache: false,
			success: function (data) {
				bootbox.alert(data.Message);
				is_updated = true;
				$('#modalSubmit').prop("disabled", false);
			},
			error: function (error) {
				bootbox.alert(error.responseJSON.Message);
				$('#modalSubmit').prop("disabled", false);
			}
		});
        		
	
}

$(document).ready(function(){
	// find the input fields and apply the time select to them.
	$(".date").Zebra_DatePicker();
        $('#from_time').ptTimeSelect();
	$('#to_time').ptTimeSelect();
	$('#from_time_modal').ptTimeSelect({zIndex:9999});
	$('#to_time_modal').ptTimeSelect({zIndex:9999});
	
});
$(function() {
  	$('#date_modal').keydown(function(event) {
       	event.preventDefault();
       	return false;
   	});
   	$('#from_time_modal').keydown(function(event) {
       	event.preventDefault();
       	
       	return false;
   	});
   	$('#to_time_modal').keydown(function(event) {
       	event.preventDefault();
       	return false;
   	});
});
</script>
<script type="text/javascript">
        $(document).ready(function(){
	// find the input fields and apply the time select to them.
	$('#editModal').on('show.bs.modal', function(e) {
        	var slot_id = $(e.relatedTarget).data('id');
        	var department = $(e.relatedTarget).data('department');
        	var visitname = $(e.relatedTarget).data('visitname');
        	var date = $(e.relatedTarget).data('date');
        	var from = $(e.relatedTarget).data('from');
        	var to = $(e.relatedTarget).data('to');
        	var appointments_limit = $(e.relatedTarget).data('limit');
         	$(e.currentTarget).find('label[id="department"]').html(department);
         	$(e.currentTarget).find('label[id="visitname"]').html(visitname);
         	$(e.currentTarget).find('label[id="date"]').html(date);
         	$(e.currentTarget).find('label[id="time"]').html(from+" - "+to);
         	$(e.currentTarget).find('input[id="slot_id"]').attr("value",slot_id);
         	$(e.currentTarget).find('input[id="no_of_appointments"]').attr("value",appointments_limit);
         });
          $("#btEdit").click(function(){
	    //stop submit the form, we will post it manually.
		event.preventDefault();
		 var no_of_appointments  = $('#editModal').find('input[id=no_of_appointments]').val();
		if (no_of_appointments <= -1 ||  no_of_appointments.length === 0 ){
			bootbox.alert("No of Appointments should be greater than or equal to zero");
			return;
		}

	
	
   	$('#edit_appointment_slot').submit();
	
	});
    });
        
</script>
	<?php 
	$from_date=0;$to_date=0;
	if($this->input->post('from_date')) $from_date=date("Y-m-d",strtotime($this->input->post('from_date'))); else $from_date = date("Y-m-d");
	if($this->input->post('to_date')) $to_date=date("Y-m-d",strtotime($this->input->post('to_date'))); else $to_date = date("Y-m-d");
	$from_time=0;$to_time=0;
	if($this->input->post('from_time')) $from_time=date("H:i",strtotime($this->input->post('from_time'))); else $from_time = date("H:i",strtotime("00:00"));
	if($this->input->post('to_time')) $to_time=date("H:i",strtotime($this->input->post('to_time'))); else $to_time = date("H:i",strtotime("23:59"));
	$page_no = 1;
	$default_appointment_status_add = "";
	$default_appointment_status_remove = "";
	foreach($all_appointment_status as $status){
		if($status->is_default==1){
			$default_appointment_status_add = $status->appointment_status;
		}
		
		if($status->is_default==2){
			$default_appointment_status_remove = $status->appointment_status;
		}					
	}
	?>
<div class="row">
		<h4>Appointment Slot</h4>	
		<?php echo form_open("reports/appointment_slot",array('role'=>'form','class'=>'form-custom','id'=>'appointment')); ?>                      <input type="hidden" name="page_no" id="page_no" value='<?php echo "$page_no"; ?>'>
			From Date : <input class="form-control" style = "background-color:#EEEEEE" type="text" value="<?php echo date("d-M-Y",strtotime($from_date)); ?>" name="from_date" id="from_date" size="15" />
			To Date : <input class="form-control" type="text" style = "background-color:#EEEEEE" value="<?php echo date("d-M-Y",strtotime($to_date)); ?>" name="to_date" id="to_date" size="15" />	
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
			<select name="visit_name" id="visit_name" class="form-control" >
				<option value="">Visit Type</option>
				<?php 
				foreach($visit_names as $v){
				echo "<option value='".$v->visit_name_id."'";
				if($this->input->post('visit_name') && $this->input->post('visit_name') == $v->visit_name_id)  echo " selected ";
				echo ">".$v->visit_name."</option>";
				}
				?>
			</select>
			 Rows per page : <input type="number" class="rows_per_page form-custom form-control" name="rows_per_page" id="rows_per_page" min=<?php echo $lower_rowsperpage; ?> max= <?php echo $upper_rowsperpage; ?> step="1" value= <?php if($this->input->post('rows_per_page')) { echo $this->input->post('rows_per_page'); }else{echo $rowsperpage;}  ?> onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" /> 
			<input class="btn btn-sm btn-primary" type="submit" value="Submit" />
		</form>
		<?php if ($add_appointment_access == 1) { ?>
		<br />
		<button type="button" class="btn btn-info" data-toggle="modal" data-target="#addModal">ADD</button>
		<?php } ?> 
	<br />
<!-- Modal Start -->
<div class="modal fade" id="addModal" role="dialog">
	<div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header bg-primary text-white">
		      <button type="button" class="close" data-dismiss="modal">&times;</button>
		      <h4 class="modal-title">Add Appointment Slots</h4>
		</div>
		<div class="modal-body">
			<?php echo form_open("reports/add_appointment_slot",array('role'=>'form','class'=>'form-horizontal','id'=>'addModalForm','enctype'=>'multipart/form-data')); ?>		
			<div class="form-group">
				<label for="department_modal" class="control-label col-sm-4">Department: </label>
				<div class="col-sm-8">
				<select name="department" id="department_modal" required class="form-control">
				<?php 
				foreach($all_departments as $dept){
				echo "<option value='".$dept->department_id."'";
				if($this->input->post('department') && $this->input->post('department') == $dept->department_id) echo " selected ";
				echo ">".$dept->department."</option>";
				}
				?>
				</select>
				</div>				
			</div>	
			<div class="form-group">
				<label for="visit_modal" class="control-label col-sm-4">Department: </label>
				<div class="col-sm-8">
				<select name="visit" id="visit_modal" required class="form-control">
				<?php 
				foreach($visit_names as $v){
				echo "<option value='".$v->visit_name_id."'";
				if($this->input->post('visit_name') && $this->input->post('visit_name') == $v->visit_name_id)  echo " selected ";
				echo ">".$v->visit_name."</option>";
				}
				?>
				</select>
				</div>				
			</div>	
			<div class="form-group">
				<label for="date_modal" class="control-label col-sm-4">Date: </label>
				<div class="col-sm-8">
				<input type="text" style="width:120px" class="date form-control"  id="date_modal" value="<?php echo  date("d-M-Y");?>" name="date" />
				</div>
			</div>	
			<div class="form-group">
				<label for="from_time_modal" class="control-label col-sm-4">Start Time: </label>
				<div class="col-sm-8">
				 <input  class="form-control" style = "width:120px;background-color:#EEEEEE;" type="text" value="<?php echo date("h:i A",strtotime($from_time)); ?>" name="from_time" id="from_time_modal" size="7px"/>
				</div>
			</div>	
			  
                   	<div class="form-group">
				<label for="to_time_modal" class="control-label col-sm-4">End Time: </label>
				<div class="col-sm-8">
				 <input  class="form-control" style = "width:120px;background-color:#EEEEEE" type="text" value="<?php echo date("h:i A",strtotime($to_time)); ?>" name="to_time" id="to_time_modal" size="7px"/>
				</div>
			</div>
			<div class="form-group">
				<label for="no_of_appointments" class="control-label col-sm-4">No of Appointments: </label>
				<div class="col-sm-8">
				<input type="number" style="width:120px" class="form-control"  id="no_of_appointments" value="0" name="appointments" min="0" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"/>
				</div>
			</div>		
			<br/>
			<div style="text-align:right;">
			<button type="button" class="btn btn-info" required name="submit_modal" id='modalSubmit' onclick="addModalSubmit()">Submit</button>
			<button type="button" class="btn btn-default" data-dismiss="modal" onclick="addModalClose()">Close</button>
			</div>	
			</form> 
	<!--<div hidden id="success_added" name="success_team_member">
	 "Team Member Successfully Added to the Helpline Session"
	</div> --!>
		</div>
	</div>

	</div>
</div>
<!-- Modal End -->
<div class="modal fade" id="editModal" role="dialog">
	<div class="modal-dialog">
	 <!-- Modal content-->
	 <div class="modal-content" style="width:450px; margin: auto;">
		<div class="modal-header bg-primary text-white" id="view_modal_header">
		      <button type="button" class="close" data-dismiss="modal">&times;</button>
		      <h4 class="modal-title">Edit Appointment slot</h4>
		</div>
		<div class="modal-body">
		<label><b>Department: &nbsp </b></label><label style="font-weight: normal" id="department"></label>
		<label><b>Visit Name: &nbsp </b></label><label style="font-weight: normal" id="visitname"></label>
		<br/>
		<label><b>Date: &nbsp </b></label><label style="font-weight: normal" id="date"></label>
		<label><b>Time: &nbsp </b></label><label style="font-weight: normal" id="time"></label>
		
		<?php echo form_open('reports/appointment_slot',array('role'=>'form','id'=>'edit_appointment_slot','class'=>'form-horizontal'));?>
		<input type="text" hidden value="" name="slot_id" id="slot_id"/>
		<input type="text" class="sr-only" hidden value="Edit" name="appointment_slot_operation" />
		<input type="hidden" name="from_date" value="<?php echo $this->input->post('from_date');?>">
	        <input type="hidden" name="to_date" value="<?php echo $this->input->post('to_date');?>">
	        <input type="hidden" name="page_no" id="page_no" value='<?php echo $this->input->post('page_no');?>'>
	        <input type="hidden" name="visit_name" value="<?php echo $this->input->post('visit_name');?>">
	        <input type="hidden" name="department" value="<?php echo $this->input->post('department');?>">
	        <input type="hidden" name="rows_per_page" id="rows_per_page" value='<?php echo $this->input->post('rows_per_page');?>'>	
	        <br/>	
		<div class="form-group">
		
	        		<label for="no_of_appointments" class="control-label col-sm-5">Appointment Limit</label>
	  			<div class="col-sm-5">
	            		<input type="number" style="width:120px" class="form-control" name="appointments_limit" id="no_of_appointments" value="0" name="appointments" min="0" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"/>
	            		</div>
			
	        </div>	
	        </div>
		</form>
		<div style="text-align:center;padding-bottom: 20px;">
			<button class="btn btn-danger"  type="button" name="btEdit" id="btEdit" >Update</button>
			<button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
		
	 </div>
	 <!-- Modal content-->
	</div>
</div>
<?php if(isset($report) && count($report)>0)
{

 ?>
 <div style='padding: 0px 2px;'>

<h5>Report as on <?php echo date("j-M-Y h:i A"); ?></h5>

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
	$total_records = $report_count[0]->count ;
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

	<table class="table table-bordered table-striped" id="table-sort">
	<thead>
		<th>SNo</th>
		<th>Slot ID</th>
		<th>Department</th>
		<th>Visit Name</th>
		<th>Date</th>
		<th>From Time</th>
		<th>To Time</th>		
		<th>Max Appointments</th>
		<th>Appointments Created - Total </th>
		<?php if ($default_appointment_status_remove !=""){ ?>
			<th><?php echo $default_appointment_status_remove; ?></th>
			<th>Appointments Created - Effective </th>
		<?php } ?>		
		<th>Appointments Remaining</th>
		<?php if ($default_appointment_status_add !=""){ ?>
			<th><?php echo $default_appointment_status_add; ?></th>
		<?php } ?>
    		<th>Updated By/Time</th>
    		<?php if($edit_appointment_access==1) { ?>
		<th>Edit Appointment Slot</th>
		<?php } ?>
    		<?php if($remove_appointment_access==1) { ?>
		<th>Delete Appointment Slot</th>
		<?php } ?>		
 		
	</thead>
	<tbody>
	<?php 
	$sno=(($page_no - 1) * $total_records_per_page)+1 ;
	foreach($report as $s){ ?>
		
		<tr>
		<?php  $effective_appointments =$s->taken_appointments; $date=date("j M Y", strtotime("$s->date"))." - ".$weekdays[date("w", strtotime("$s->date"))]; $from = date("h:i A", strtotime("$s->from_time"));  $to =date("h:i A", strtotime("$s->to_time"));  ?>
		<td><?php echo $sno;?></td>		
		<td><?php echo $s->slot_id;?></td>
		<td><?php echo $s->department;?></td>
		<td><?php echo $s->visit_name;?></td>		
		<td><?php echo  $date;?></td>
		<td><?php echo  $from;?></td>
		<td><?php echo  $to;?></td>		
		<td class="text-right"><?php echo $s->appointments_limit;?></td>
		<td class="text-right"><?php echo $s->taken_appointments;?></td>
		<?php if ($default_appointment_status_remove !=""){ ?>
			<td class="text-right"><?php echo $s->default_appointment_status_remove; ?></td>
			<td class="text-right"><?php echo ($s->taken_appointments-$s->default_appointment_status_remove); ?></td>
			
		<?php } 
			$effective_appointments = $effective_appointments - $s->default_appointment_status_remove;
		?>
		<td class="text-right"><?php 
		$remaining_appointments = $s->appointments_limit - $effective_appointments;
		
		if ($remaining_appointments >= 0) { echo $remaining_appointments;} else {echo 0;} ?></td>
		<?php if ($default_appointment_status_add !=""){ ?>
			<td class="text-right"><?php echo $s->default_appointment_status_add; ?></td>
		<?php } ?>
		<td><?php echo $s->appointment_update_by_name;?> , <?php echo date("j M Y", strtotime("$s->appointment_update_time")).", ".date("h:i A.", strtotime("$s->appointment_update_time"));?></td>
		<?php if($edit_appointment_access==1) { ?>
		<td style="text-align:center"><button type="button" class="btn btn-info" autofocus data-id="<?php echo $s->slot_id; ?>" data-department="<?php echo $s->department; ?>" data-visitname="<?php echo $s->visit_name; ?>" data-date="<?php echo $date; ?>" data-toggle="modal" data-from="<?php echo $from; ?>"  data-to="<?php echo date('h:i A', strtotime($s->to_time)); ?>" data-limit="<?php echo $s->appointments_limit; ?>" data-target="#editModal">Edit</button>
		</td> 
	<?php } ?>
		<?php if($remove_appointment_access==1) { ?>
		<td style="text-align:center"><button type="button" class="btn btn-info" autofocus data-id="<?php echo $s->slot_id; ?>" onclick="delete_appointment_slot(event)" >Delete</button>
		<?php echo form_open('reports/appointment_slot',array('role'=>'form','id'=>'delete_appointment_slot_'.$s->slot_id));?>
		<input type="text" class="sr-only" hidden value="Delete" name="appointment_slot_operation" />
		<input type="text" class="sr-only" hidden value="<?php echo $s->slot_id;?>" name="slot_id" />
		</form>
		</td> 
	<?php } ?>
		</tr>
	<?php $sno++; 	} ?>
	</tbody>
	</table>
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
	<?php  } else { ?>
	
	No Appointment slot found.
<?php }  ?>
</div>	
  
