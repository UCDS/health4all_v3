<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
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
	$(".update_all").click(function(){
		if($(this).is(":checked"))
			$(".update").prop('checked',true);
		else
			$(".update").prop('checked',false);
	});
	$(".reports_all").click(function(){
		if($(this).is(":checked"))
			$(".reports").prop('checked',true);
		else
			$(".reports").prop('checked',false);
	});
});
</script>
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<?php if(isset($mode)&& $mode=="select" || $this->input->post('update')){?>
<center> <h3> Update Helpline Access</h3></center><br>
<?php echo validation_errors(); echo form_open('user_panel/helpline_access',array('role'=>'form','id'=>'user')); ?>

<div class="row col-md-offset-2">
	<?php if(isset($msg)){ ?>
		<div class="alert alert-info"><?php echo $msg;?></div>
	<?php
	}
	?>
	
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Update Helpline Access</h4>
		</div>
		<div class="panel-body">
				<p class="lead">User details</p>	
					<div class="form-group col-md-12">
						<div class="col-md-4">
							<label for="name" class="control-label"><b>Username:</b></label>
							<?php if(isset($user)){
									echo $user[0]->username;
								}
							?>
							<input type="hidden" class="sr-only" name="user" value="<?php echo $user[0]->user_id; ?>" />
						</div>
						<div class="col-md-4">
							<label for="name" class="control-label"><b>Name:</b></label>
							<?php if(isset($user)){
									echo $user[0]->first_name." ".$user[0]->last_name;
								}
							?>
						</div>
						<div class="col-md-4">
							<label for="email" class="control-label"><b>Email:</b></label>
							<?php if(isset($user)){
									echo $user[0]->email;
								}
							?>
						</div>
						<div class="col-md-4">
							<label for="phone" class="control-label"><b>Phone</b></label>
							<?php if(isset($user)){
									echo $user[0]->phone;
								}
							?>
						</div>
						<div class="col-md-4">
							<label for="specialisation" class="control-label"><b>Specialisation:</b></label>
							<?php if(isset($user)){
									echo $user[0]->specialisation;
								}
							?>
						</div>
					</div>	
					</div>
					<div class="col-md-12">
						<table class="table table-bordered table-striped">
							<thead>
								<th>Helpline</th>
								<th>Note</th>
								<th>Reports</th>
								<th>Update</th>
							</thead>
							<tbody>
							<tr>
								<td>All</td>
								<td></td>
								<td><input type="checkbox" class="reports_all" value="reports_all" /></td>
								<td><input type="checkbox" class="update_all" value="update_all" /></td>
							</tr>
							<?php foreach($helpline_numbers as $number){
									$update="";
									$reports="";
								foreach($user_helpline as $u){
									if($u->helpline_id == $number->helpline_id){
										if($u->update_access==1) $update="checked"; 
										if($u->reports_access==1) $reports="checked";
									}
								}
							?>
								<tr>
									<td>
									<div data-toggle="popover" data-placement="bottom" data-content="<?php echo $f->description;?>">
										<?php echo $number->helpline;?>									  
									</div>
									<input type="checkbox" value="<?php echo $number->helpline_id;?>" name="user_helpline_access[]" class="sr-only" checked /></td>
									<td>										
										<?php echo $number->note;?>									  
									</td>
									<td><input type="checkbox" class="reports" name="<?php echo $number->helpline_id;?>[]" value="reports" <?php echo $reports;?>  /></td>
									<td><input type="checkbox" class="update" name="<?php echo $number->helpline_id;?>[]" value="update" <?php echo $update;?> /></td>
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


	<h3 class="col-md-12">List of Users</h3>
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
		
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach($user as $a){ ?>
	<tr onclick="$('#select_user_edit_form_<?php echo $a->user_id;?>').submit();" >
		<td>	
			<?php echo form_open('user_panel/helpline_access',array('id'=>'select_user_edit_form_'.$a->user_id,'role'=>'form')); ?>
			<?php echo $i++; ?>
		</td>
	<!--	<td><?php echo $a->hospital;?></td> -->
		<td><?php echo $a->department;?></td>
		<td><?php echo $a->designation;?> </td>
		<td><?php echo $a->first_name." ".$a->last_name;  ?></td>
		<td><?php echo $a->gender; ?>
		<td><?php echo $a->specialisation; ?>
		<td><?php echo $a->email; ?>
		<td><?php echo $a->username; ?>
		<input type="hidden" value="<?php echo $a->user_id; ?>" name="user_id" />
		<input type="hidden" value="select" name="select" />
		</td>
		<td>
			<?php echo $a->phone;?>
			</form>
		</td>
	</tr>
	<?php } ?>
	</tbody>
	</table>
	<?php } ?>
	</div></div>
