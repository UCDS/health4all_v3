<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.chained.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript">
$(document).ready(function(){
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
	$('#editModal').on('show.bs.modal', function(e) {
        	var id = $(e.relatedTarget).data('id');
        	var name = $(e.relatedTarget).data('name');
        	var phone = $(e.relatedTarget).data('phone');
        	var email = $(e.relatedTarget).data('email');
        	var role = $(e.relatedTarget).data('role');
        	var note = $(e.relatedTarget).data('note');
         	$(e.currentTarget).find('label[id="name"]').html(name);
         	$(e.currentTarget).find('label[id="phone"]').html(phone);
         	$(e.currentTarget).find('label[id="email"]').html(email);
         	$(e.currentTarget).find('input[id="edit_note"]').val(note);
         	$(e.currentTarget).find('input[id="helpline_session_plan_id"]').attr("value",id);
         	if (role != "0") {		
			 $(e.currentTarget).find('select[id="role"]').val(role).change();
		}
         });
          $("#btEdit").click(function(){
	    //stop submit the form, we will post it manually.
		event.preventDefault();
        // Get form
        //var form =$(event.currentTarget).find('form[id=edit_helpline_sessions]');
	 var form  = $('#editModal').find('form[id=edit_helpline_sessions]');
	
        // disabled the submit button
        $("#btEdit").prop("disabled", true);

        $.ajax({
	        type: "POST",
	        url: $(form).attr('action'),
	        data: $(form).serialize(),
	        success: function (data) {
		        // show success notification here...
		        location.reload()
	        },
    	    error: function (e) {
	    	    // show error notification here...
		        $("#btEdit").prop("disabled", false);
	        }
	     });
	
	});
    });
        
</script>
<script type="text/javascript">
function doPost(page_no){
	var page_no_hidden = document.getElementById("page_no_next");
  	page_no_hidden.value=page_no;
        $('#update_user_helpline_sessionplan_form').submit();
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
	<?php
	$page_no = 1;
	$rowsperpage = 50;
	$remove_access = 0;
	$edit_access = 0;
	foreach($functions as $f) {
		if($f->user_function =="helpline_session_plan"){
		 if ($f->remove==1) {
		 	$remove_access = 1;
		 }
		  if ($f->edit==1) {
		 	$edit_access = 1;
		 }
          }
       }
		 
	
	?>
<div style="text-align:center;">
<h2><?php if($session_name) {echo "Volunteers of the session ".$session_name;} ?></h2>
</div>
<div class="row">

<?php if(isset($report) && count($report)>0)
{ ?>
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




	<table class="table table-bordered table-striped" id="table-sort">
	<thead>
		<th>SNo</th>
		<th>Helpline Receiver Name</th>
		<th>Helpline Receiver Languages</th>
		<th>Role</th>
		<th>Notes</th>
	<?php if($edit_access==1) { ?>
		<th>Helpline Receiver Edit</th>
	<?php } ?>
	<?php if($remove_access==1) { ?>
		<th>Helpline Receiver Delete</th>
	<?php } ?>
		<th>View Other Sessions </th>
	</thead>
	<tbody>
	<?php 
	$sno=(($page_no - 1) * $total_records_per_page)+1 ; 

	foreach($report as $s){
	?>
	<tr>
		<td><?php echo $sno;?></td>
		<td><?php echo $s->full_name.', '.$s->email.', '.$s->phone;?></td>
		<td><?php echo $s->languages;?></td>
		<td><?php echo $s->helpline_session_role;?></td>
		<td><?php echo $s->helpline_session_note; ?></td>
		<?php if($edit_access==1) { ?>
		<td style="text-align:center"><button type="button" class="btn btn-info" autofocus data-id="<?php echo $s->helpline_session_plan_id; ?>" data-name="<?php echo $s->full_name; ?>" data-email="<?php echo $s->email; ?>" data-phone="<?php echo $s->phone; ?>" data-toggle="modal" data-role="<?php echo $s->helpline_session_role_id; ?>"  data-note="<?php echo $s->helpline_session_note; ?>" data-target="#editModal">Edit</button>
		</td> 
	<?php } ?>
	<?php if($remove_access==1) { ?>
		<td style="text-align:center"><button type="button" class="btn btn-info" autofocus data-id="<?php echo $s->helpline_session_plan_id; ?>" onclick="delete_helpline_receiver(event)" >Delete</button>
		<?php echo form_open('helpline/update_user_helpline_sessionplan',array('role'=>'form','id'=>'delete_helpline_'.$s->helpline_session_plan_id));?>
		<input type="text" class="sr-only" hidden value="<?php echo $s->helpline_session_id;?>" name="helpline_session_id" />
		<input type="text" class="sr-only" hidden value="<?php echo $s->helpline_session_plan_id;?>" name="helpline_update_session_plan_id" />
		<input type="hidden" name="rows_per_page_main" id="rows_per_page_main" value='<?php echo $this->input->post('rows_per_page_main');?>'>		
		<input type="hidden" name="page_no" value='<?php echo $this->input->post('page_no');?>'>	
		</form>
		</td> 
	<?php } ?>
		<td style="text-align:center"><button type="button" class="btn btn-info" autofocus data-id="<?php echo $s->receiver_id; ?>" data-fullname="<?php echo $s->full_name; ?>" data-toggle="modal" data-target="#viewModal" onclick="view_helpline_sessions(event)">View</button> 
		<?php echo form_open('helpline/update_user_helpline_sessionplan',array('role'=>'form','id'=>'view_helpline_sessions_'.$s->receiver_id));?>
		<input type="text" class="sr-only" hidden value="<?php echo $s->receiver_id;?>" name="view_receiver_id"/>
		<input type="text" class="sr-only" hidden value="<?php echo $s->full_name;?>" name="name_receiver_id"/>
		</form>
		</td>
	</tr>
	<?php $sno++;}	?>
	</tbody>
	</table>
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

	No Helpline Receivers to delete.
<?php }  ?>
</div>
<div class="row">
		<?php echo form_open('helpline/session_plan',array('role'=>'form','id'=>'back_helpline_session_plan'));?>
		<input type="text" class="sr-only" hidden value="helpline_session_id" name="helpline_session_id" />
		<input type="number" class="sr-only" hidden name="rows_per_page" value='<?php echo $this->input->post('rows_per_page');?>'/> 
				<input type="number" class="sr-only" hidden name="rows_per_page" value='<?php echo $this->input->post('rows_per_page');?>'/> 
				
				
		<input type="hidden" name="page_no" id="page_no" value='<?php echo $this->input->post('rows_per_page_main');?>'>	
		<input class="btn btn-sm btn-primary" type="submit" value="Back"/>
		</form>
		<?php echo form_open('helpline/update_user_helpline_sessionplan',array('role'=>'form','id'=>'update_user_helpline_sessionplan_form'));?>
		<input type="text" class="sr-only" hidden value='<?php echo $this->input->post('helpline_session_id');?>' name="helpline_session_id" />

				<input type="number" class="sr-only" hidden name="rows_per_page" value='<?php echo $this->input->post('rows_per_page');?>'/> 
				
			<input type="hidden" name="rows_per_page_main" id="rows_per_page_main" value='<?php echo $this->input->post('rows_per_page_main');?>'>		
		<input type="hidden" name="page_no" id="page_no_next" value='<?php echo $this->input->post('page_no');?>'>	
		</form>
</div>
<div class="modal fade" id="editModal" role="dialog">
	<div class="modal-dialog">
	 <!-- Modal content-->
	 <div class="modal-content">
		<div class="modal-header bg-primary text-white" id="view_modal_header">
		      <button type="button" class="close" data-dismiss="modal">&times;</button>
		      <h4 class="modal-title">Edit Metadata</h4>
		</div>
		<div class="modal-body">
		<div class="form-group">
		<label><b>Name: &nbsp </b></label><label id="name"></label>
		<label><b>Phone: &nbsp </b></label><label id="phone"></label>
		<label><b>Email: &nbsp </b></label><label id="email"></label>
		</div>
		<?php echo form_open('helpline/update_user_helpline_sessionplan',array('role'=>'form','id'=>'edit_helpline_sessions'));?>
		<input type="text" hidden value="" name="helpline_update_session_plan_id" id="helpline_session_plan_id"/>
		<input type="number" class="sr-only" hidden name="rows_per_page" value='<?php echo $this->input->post('rows_per_page');?>'/> 
				
			<input type="hidden" name="rows_per_page_main" id="rows_per_page_main" value='<?php echo $this->input->post('rows_per_page_main');?>'>		
		<input type="hidden" name="page_no" value='<?php echo $this->input->post('page_no');?>'>	
		<input type="text" class="sr-only" hidden value="Edit" name="helpline_session_plan_operation" />
		<div class="form-group">
			
	        		<label for="role" class="control-label">Helpline Role</label>
	       
				<select name="role" id="role" class="form-control" >
					<?php 
					foreach($helpline_session_role as $role){
					echo "<option value='".$role->helpline_session_role_id."' class='".$role->helpline_session_role_id."'";
					if($this->input->post('role') && $this->input->post('role') == $role->helpline_session_role_id) echo " selected ";
					echo ">".$role->helpline_session_role."</option>";
					}
					?>
				</select>
			
		</div>
		<div class="form-group">
		
	        		<label for="note" class="control-label">Note</label>
	        	
	            		<input type="text" class="form-control" placeholder="note" id="edit_note" name="edit_note"/>
	        	
	        </div>
		</form>
		<br/>
		<div style="text-align:right;">
		<button class="btn btn-danger"  type="button" name="btEdit" id="btEdit" >Update</button>
		<button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
		</div>
		</div>
	 </div>
	 <!-- Modal content-->
	</div>
</div>
<div class="modal fade" id="viewModal" role="dialog">
	<div class="modal-dialog">
	 <!-- Modal content-->
	 <div class="modal-content">
		<div class="modal-header bg-primary text-white" id="view_modal_header">
		      <button type="button" class="close" data-dismiss="modal">&times;</button>
		      <h4 class="modal-title" id="view_modal_title_id"></h4>
		</div>
		<div class="modal-body" id="view">
		<div style="height: 200px; overflow: auto;">
		    <table class="table table-bordered table-striped" id="table-sort">
			<thead style="position: sticky; top: 0; background: #ffff;">
				<th>SNo</th>
				<th>Weekday</th>
				<th>Role</th>				
				<th>Helpline Receiver Session Name</th>
				<th>Notes</th>
				
			</thead>
			<tbody>
			<?php 
			$sno=1 ; 

			foreach($report_sessions as $s){
			?>
			<tr>
				<td><?php echo $sno;?></td>
				<td><?php echo $weekdays[$s->weekday]; ?></td>
				<td><?php echo $s->helpline_session_role; ?></td>				
				<td><?php echo $s->session_name; ?></td>
				<td><?php echo $s->helpline_session_note; ?></td>
				</tr>
			<?php $sno++;}	?>
			</tbody>
		    </table>
		</div>
		<br/>
		<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

		</div>
	 </div>
	 <!-- Modal content-->
	</div>
</div>
<!-- Modal -->

<script type="text/javascript">
/*
document.getElementById("deletebtn").addEventListener("click", function(e) {
	console.log(e);
console.log($(e.target).data('id'));

	alert("I am here");
});
*/
function delete_helpline_receiver(e) {
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
				console.log(event_prop);
				console.log($(event_prop.target).data('id'));
				var id=$(event_prop.target).data('id');
				var form =  document.getElementById("delete_helpline_"+id);
				console.log(form);
				// Create an FormData object 
				var data = new FormData(form);

				// disabled the submit button
				$(event_prop.target).prop("disabled", true);

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

					location.reload()
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

function view_helpline_sessions(e) {
	// e.preventDefault();
	var event_prop = e;
	//console.log(event_prop);
	//console.log($(event_prop.target).data('id'));
	//console.log($(event_prop.target).data('fullname'));
	var name = $(event_prop.target).data('fullname');
	console.log(name);
	var modal = $("#viewModal");
	modal.find("#view_modal_title_id").html(name+"'s Sessions");
	//console.log(modal.find("#view_modal_title_id"));
	var id=$(event_prop.target).data('id');
	var form =  document.getElementById("view_helpline_sessions_"+id);

	// Create an FormData object 
	var data = new FormData(form);
	// var secondfield_value = event_prop.currentTarget[1].value;
	// console.log(secondfield_value);
	console.log("before submit");
	// disabled the submit button
	// $(event_prop.target).prop("disabled", true);
	$.ajax({
type: "POST",
enctype: 'multipart/form-data',
url: $(form).attr('action'),
data: data,
processData: false,
contentType: false,
// contentType: "application/json; charset=utf-8",
//     dataType: "json",
cache: false,
success: function (data) {
// show success notification here...

// Since the data is the full response, parse it and fill the actual page with the 
// html division
const parser = new DOMParser();
let parsed = parser.parseFromString(data, "text/html");
// console.log(parsed.querySelector("#view").innerHTML);
// console.log(parsed.querySelector("#view_modal_title_id").innerHTML);
document.getElementById("view").innerHTML=parsed.querySelector("#view").innerHTML;
document.getElementById("view_modal_header").innerHTML=parsed.querySelector("#view_modal_header").innerHTML;
//$("#view_modal_title_id").val(parsed.querySelector("#view_modal_title_id").innerHTML);
},
error: function (error) {
bootbox.alert('Query Failed');
// show error notification here...
$(event_prop.target).prop("disabled", false);
}
});


}
function goSubmit() {
	$.ajax({
type: 'POST',
url: $("#back_helpline_session_plan").attr("action"),
data: $("#back_helpline_session_plan").serialize(), 
//or your custom data either as object {foo: "bar", ...} or foo=bar&...
success: function(response) { console.log('go submitted'); },
});
}
</script>
