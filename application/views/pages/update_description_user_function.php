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



<center> <h3> Edit User Funtion Description</h3></center><br>
<div class="row col-md-offset-2">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Edit User Funtion Description</h4>
		</div>
		<?php if($msg){ ?>
		<div class="alert alert-info"><?php echo $msg;?></div>
		<?php } ?>
		<div class="panel-body">
			<?php echo form_open('user_panel/update_des_user_function',array('role'=>'form','id'=>'')); ?>
				<div class="form-group col-md-12">
					<div class="col-md-3">
						<label class="control-label">User Function</label>
					</div>
					<div class="col-md-6">						
						<select name="user_function" class="form-control" disabled >
								<option value="">--Select--</option>
							<?php foreach($user_functions as $uf){ ?>
								<option <?php if($fetch_user_function_display['user_function_id']==$uf->user_function_id) { echo "selected"; } ?> value="<?php echo $uf->user_function_id; ?>"><?php echo $uf->user_function; ?></option>	
							<?php } ?>					
					</select>
					</div>
				</div>
				<div class="form-group col-md-12">
					<div class="col-md-3">
						<label for="username" class="control-label">User Function Display</label>
					</div>
					<div class="col-md-6">
						<input type="text" name="user_function_display" 
						value="<?php if(!empty($fetch_user_function_display)) { echo $fetch_user_function_display['user_function_display']; } ?>" class="form-control" autocomplete="off" required>
					</div>
				</div>	
				<div class="form-group  col-md-12">
					<div class="col-md-3">
						<label for="username" class="control-label">Description</label>
					</div>
					<div class="col-md-6">
						<input type="text" name="description" 
						value="<?php if(!empty($fetch_user_function_display)) { echo $fetch_user_function_display['description']; } ?>" class="form-control" autocomplete="off" required>
					</div>
				</div>
				<input type="hidden" name="record_id" value="<?php echo $fetch_user_function_display['user_function_id']; ?>" >
				<div class="col-md-3 col-md-offset-4">
					<input class="btn btn-lg btn-primary btn-block" type="submit" value="Update">
				</div>
			</form>
		</div>
		<div class="panel-body">
			<div class="col-md-12">
				<table class="table table-bordered table-striped">
					<thead>
						<th>Function</th>
						<th>Function Display</th>
						<th>Description</th>
						<th>Action</th>
					</thead>
					<tbody>
					<?php foreach($user_functions as $f){ ?>
						<tr>
							<td><?php echo $f->user_function;?></td>
							<td><?php echo $f->user_function_display ?></td>
							<td><?php echo $f->description ?></td>
							<td style="text-align:center;">
							<a class="btn btn-success" href="<?php echo base_url('user_panel/update_des_user_function/'.$f->user_function_id); ?>" style="color:white!important;">Edit</a></td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>	
</div>