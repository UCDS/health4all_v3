<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<!-- 204208 -->

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
    width: 10px;
    display: inline-block;
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
    text-align: -webkit-match-parent;
}
.rows_per_page:focus{
    border-color: #66afe9;
    outline: 0;	
}

</style>

<script type="text/javascript">
function doPost(page_no){
	var page_no_hidden = document.getElementById("page_no");
  	page_no_hidden.value=page_no;
        $('#edit_user').submit();
   }
function onchange_page_dropdown(dropdownobj){
   doPost(dropdownobj.value);    
}
</script>

<script type="text/javascript">
$(function(){
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
<script>
$(function(){
	$(".add_all").click(function(){
		if($(this).is(":checked"))
			$(".add").prop('checked',true);
		else
			$(".add").prop('checked',false);
	});
	$(".edit_all").click(function(){
		if($(this).is(":checked"))
			$(".edit").prop('checked',true);
		else
			$(".edit").prop('checked',false);
	});
	$(".view_all").click(function(){
		if($(this).is(":checked"))
			$(".view").prop('checked',true);
		else
			$(".view").prop('checked',false);
	});
	$(".remove_all").click(function(){
		if($(this).is(":checked"))
			$(".remove").prop('checked',true);
		else
			$(".remove").prop('checked',false);
	});
});
</script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<?php if(isset($mode)&& $mode=="select" || $this->input->post('update')){?>
<center> <h3> Edit User</h3></center><br>
<?php echo validation_errors(); echo form_open('user_panel/edit_user',array('role'=>'form','id'=>'user')); ?>

<div class="row col-md-offset-2">
	<?php if(isset($msg)){ ?>
		<div class="alert alert-info"><?php echo $msg;?></div>
	<?php
	}
	?>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Edit User</h4>
		</div>
		<div class="panel-body">
				<p class="lead">Login details</p>	
					<div class="form-group col-md-12">
						<div class="col-md-3">
							<label for="username" class="control-label">Username</label>
						</div>
						<div class="col-md-6">
							<input type="text" class="form-control" placeholder="Username" id="username" name="username" 
							<?php if(isset($user)){
			echo "value='".$user[0]->username."' ";
			}
		?>
	     />
		<?php if(isset($user)) { ?>
		<input type="hidden" value="<?php echo $user[0]->user_id;?>" name="user" />
		
		<?php } ?>
						</div>
					</div>	
					<div class="form-group col-md-12">
					<div class="col-md-3">
					<label for="password" class="control-label">Password</label>
					</div>
					<div class="col-md-6">
					<input type="password" class="form-control" placeholder="Password" id="old_password" value="<?php echo $user[0]->password;?>" readonly />
					<input type="password" class="form-control sr-only new_password" placeholder="Enter New Password" id="new_password" name="password" />
					<button class="btn btn-default btn-md" type="button" onclick="$('.new_password').removeClass('sr-only').attr('required',true);$('#old_password').addClass('sr-only');$(this).addClass('sr-only');">Change Password</button>
					<label class="new_password sr-only"><input type="checkbox" onclick="if($(this).is(':checked')) $('#new_password').attr('type','text'); else $('#new_password').attr('type','password');" />Show Password</label>
					</div>
					</div>
					<div class="form-group col-md-12">
						<div class="col-md-3">
						<label class="control-label">Staff</label>
						</div>
						<div class="col-md-6">						
						<select name="staff" class="form-control" required >
						<option value="">--Select--</option>
						<?php 
						foreach($staff as $s){
						echo "<option value='".$s->staff_id."'"; 
						if($user[0]->staff_id == $s->staff_id) echo " selected ";
						echo ">".$s->staff_name."</option>";	
						}
						?>					
						</select>
						</div>
					</div>					
					<div class="form-group  col-md-12">
						<div class="col-md-3">
							<label for="staff_type" class="control-label">Active</label>
						</div>
						<div class="col-md-6">
							<input type ='radio' id="active" name="active" value ='1' <?php if($user[0]->active== 1) echo "checked"; ?> >Yes</input>
							<input type ='radio' id="active" name="active" value ='0' <?php if($user[0]->active== 0) echo "checked"; ?> >No</input>
						</div>
					</div>
					<div class="col-md-12">
						<table class="table table-bordered table-striped">
							<thead>
								<th>User Function</th>
								<th>Add</th>
								<th>Edit</th>
								<th>View</th>
								<th>Remove</th>
							</thead>
							<tbody>
							<tr>
								<td>All</td>
								<td style="text-align:center;"><input type="checkbox" class="add_all" value="add_all" /></td>
								<td style="text-align:center;"><input type="checkbox" class="edit_all" value="add_all" /></td>
								<td style="text-align:center;"><input type="checkbox" class="view_all" value="add_all" /></td>
								<td style="text-align:center;"><input type="checkbox" class="remove_all" value="add_all" /></td>
							</tr>
							<?php foreach($user_functions as $f){
								
									$add="";
									$edit="";
									$view="";
									$remove="";
								foreach($user as $u){
									if($u->function_id == $f->user_function_id){
										if($u->add==1) $add="checked"; 
										if($u->edit==1) $edit="checked";
										if($u->view==1) $view="checked";
										if($u->remove==1) $remove="checked";
									}
								}
							?>
								<tr>
									<td>
									<div data-toggle="popover" data-placement="bottom" data-content="<?php echo $f->description;?>">
										<?php echo $f->user_function_display;?>&nbsp;&nbsp;( <?php echo $f->user_function;?> )								  
									</div>
									<input type="checkbox" value="<?php echo $f->user_function_id;?>" name="user_function[]" class="sr-only" checked /></td>
									<td style="text-align:center;"><input type="checkbox" class="add" name="<?php echo $f->user_function_id;?>[]" value="add" <?php echo $add;?> /></td>
									<td style="text-align:center;"><input type="checkbox" class="edit" name="<?php echo $f->user_function_id;?>[]" value="edit" <?php echo $edit;?>  /></td>
									<td style="text-align:center;"><input type="checkbox" class="view" name="<?php echo $f->user_function_id;?>[]" value="view" <?php echo $view;?>  /></td>
									<td style="text-align:center;"><input type="checkbox" class="remove" name="<?php echo $f->user_function_id;?>[]" value="remove" <?php echo $remove;?>  /></td>
								</tr>
							<?php } ?>
							</tbody>
							
						</table>
					</div>
		</div>
		
	</div>	
   	<div class="col-md-3 col-md-offset-4">
	<input class="btn btn-lg btn-primary btn-block" type="submit" value="Update" name="update">
	</div>
	</form>
</div>
	<?php } 
	else{ ?>
	<div class="col-md-10 col-md-offset-2">
		<h3><?php if(isset($msg)) echo $msg;?></h3>	


	<?php $page_no = 1;	?>
 <h3 class="col-md-12">List of Users</h3>

<?php echo form_open("user_panel/edit_user",array('role'=>'form','class'=>'form-custom col-md-12','id'=>'edit_user')); ?> 
 <input type="hidden" name="page_no" id="page_no" value='<?php echo "$page_no"; ?>'>
 			Username : <input type="text" class="form-control" placeholder="Username"  style="width:180px"  value="<?php echo $this->input->post('username');?>" name="username" />
 			Phone-no : <input type="text" class="form-control" placeholder="Phone"  style="width:120px"  value="<?php echo $this->input->post('phone');?>" name="phone" />
 			Email : <input type="text" class="form-control" placeholder="Email"  style="width:180px"  value="<?php echo $this->input->post('email');?>" name="email" />
            
            Active Status : <select name="status" id="status" class="form-control">
    			<option value="">Select</option>   
                        <option value="Yes" <?php echo ($this->input->post('status') == 'Yes') ? 'selected' : ''; ?> >Yes</option> 
                        <option value="No" <?php echo ($this->input->post('status') == 'No') ? 'selected' : ''; ?> >No</option>          
                        </select>
			Rows per page : <input type="number" class="rows_per_page form-custom form-control" style="width:50px" name="rows_per_page" id="rows_per_page" min=<?php echo $lower_rowsperpage; ?> max= <?php echo $upper_rowsperpage; ?> step="1" value= <?php if($this->input->post('rows_per_page')) { echo $this->input->post('rows_per_page'); }else{echo $rowsperpage;}  ?> onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" /> 
            
            
 <input type="submit" value="Search" name="submitBtn" class="btn btn-primary btn-sm" /> 
</form>
<br />
<div class="col-md-12">
 <br />
  
       <?php if(isset($user) && count($user)>0)
{ ?> 
<br />
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

<ul class="pagination" style="margin:0;">
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

	<div class="col-md-12 ">
	</div>	
		<table class="table table-bordered table-striped" id="table-sort">
	<thead>
		<th style="text-align:center">S.no</th>
	<!--	<th style="text-align:center">Hospital</th> -->
		<th style="text-align:center">Department</th>
		<th style="text-align:center">Designation</th>
		<th style="text-align:center">Name</th>
		<th style="text-align:center">Gender</th>
		<th style="text-align:center">Specialisation</th>
		<th style="text-align:center">Email</th>
		<th style="text-align:center">User Name</th>
		<th style="text-align:center">Phone</th>
		<th style="text-align:center">Active</th>
		
	</thead>
	<tbody>
	<?php 
	$i=(($page_no - 1) * $total_records_per_page)+1 ;
	foreach($user as $a){ ?>
	<tr onclick="$('#select_user_edit_form_<?php echo $a->user_id;?>').submit();" >
		<td>	
			<?php echo form_open('user_panel/edit_user',array('id'=>'select_user_edit_form_'.$a->user_id,'role'=>'form')); ?>
			<?php echo $i++; ?>
		</td>
	<!--	<td><?php echo $a->hospital;?></td> -->
		<td><?php echo $a->department;?></td>
		<td><?php echo $a->designation;?> </td>
		<td><?php echo  $a->first_name." ".$a->last_name;  ?></td>
		<td><?php echo $a->gender; ?>
		<td><?php echo $a->specialisation; ?>
		<td><?php echo $a->email; ?>
		<td><?php echo $a->username; ?>
		<input type="hidden" value="<?php echo $a->user_id; ?>" name="user_id" />
		<input type="hidden" value="select" name="select" />
		</td>
		<td>
			<?php echo $a->phone;?>		
		</td>
		<td>
			<?php echo $a->active;?>
			</form>
		</td>
	</tr>
	<?php } ?>
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
  <?php } else { 

  	if($this->input->post('phone') || $this->input->post('email') || $this->input->post('status') || $this->input->post('username')){
	
	echo "No users for this search criteria.";
}
 }  ?>
</div>
	<?php } ?>
	</div></div>
