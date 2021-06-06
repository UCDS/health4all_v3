<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<!-- Add this for receiver id drop drown list in the add Modal--!>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/selectize.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.selectize.js"></script>
<script type="text/javascript">
$(document).ready(function(){		var options = {
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
	initUserSelectize();
});

function transformUser(res){
	if(res){
		res.map(function(d){
			d.custom_data = d.full_name + ' ' + ' - ' + d.phone + ' - ' + d.email;
		    return d;
		});
	}
	return res;
}

function initUserSelectize(){
	window['userList'] = [];
	var selectize = $('#receiver_id').selectize({
	    valueField: 'receiver_id',
	    labelField: 'custom_data',
	    searchField: 'custom_data',
	    options: window['userList'],
	    create: false,
	    render: {
	        option: function(item, escape) {
			console.log("In render");
	        	console.log(item.custom_data);
			return '<div>' +
	                '<span class="title">' +
	                    '<span class="prescription_drug_selectize_span">' + escape(item.custom_data) + '</span>' +
	                '</span>' 
	            '</div>';
	        }
	    },
	    load: function(query, callback) {
	        if (!query.length) return callback();
	        $.ajax({
	            url: '<?php echo base_url();?>helpline/search_helpline_receiver',
	            type: 'POST',
				dataType : 'JSON',
				data : { query: query },
	            error: function(res) {
			console.log("error");
	                console.log(res);
			callback();
	            },
	            success: function(res) {
	            	res = transformUser(res);
			console.log("after transorm user");
			console.log(res);
	                callback(res.slice(0, 10));
	            }
	        });
		},

	});
}

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
        $('#session_plan').submit();
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
    .selectize-control.repositories .selectize-dropdown > div {
		border-bottom: 1px solid rgba(0,0,0,0.05);
	}
.selectize-control {
	display: inline-grid;
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
	
	?>
<div class="row">
		<h4>Helpline Session</h4>	
		<?php echo form_open("helpline/session_plan",array('role'=>'form','class'=>'form-custom','id'=>'helplineForm')); ?> 
			 <input type="hidden" name="page_no" id="page_no" value='<?php echo "$page_no"; ?>'>
			Search By:
			<select name="helpline" id="helpline" class="form-control">
				<option value="">Helpline</option>
				<?php 
				foreach($helpline as $help){
				echo "<option value='".$help->helpline_id."'";
				if($this->input->post('helpline') && $this->input->post('helpline') == $help->helpline_id) echo " selected "; ?>
					<?php echo ">".$help->helpline.' - '.$help->note;?></option>
				<?php } ?>
			</select>
			<select name="weekday" id="weekday" class="form-control" >
				<option value="">Helpline Weekday</option>
				<?php 
				foreach($weekdays as $key=>$val){
				echo "<option value='".$key."'";
				if ($this->input->post('weekday') && $this->input->post('weekday') == $key) { echo "selected";} 
					echo ">".$val."</option>";
				}
				?>
			</select>
			<select name="role" id="role" class="form-control" >
				<option value="">Helpline Session Role</option>
				<?php 
				foreach($helpline_session_role as $role){
				echo "<option value='".$role->helpline_session_role_id."' class='".$role->helpline_session_role_id."'";
				if($this->input->post('role') && $this->input->post('role') == $role->helpline_session_role_id) echo " selected ";
				echo ">".$role->helpline_session_role."</option>";
				}
				?>
			</select>
			<select name="session_name" id="session_name" class="form-control" >
				<option value="">Helpline Session Name</option>
			</select>
			  Rows per page : <input type="number" class="rows_per_page form-custom form-control" name="rows_per_page" id="rows_per_page" min=<?php echo $lower_rowsperpage; ?> max= <?php echo $upper_rowsperpage; ?> step="1" value= <?php if($this->input->post('rows_per_page')) { echo $this->input->post('rows_per_page'); }else{echo $rowsperpage;}  ?> onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" /> 
			<input class="btn btn-sm btn-primary" type="submit" value="Submit" />
			<!-- <button type="button" class="btn btn-info" required name="submit" onclick="goSubmit()">Submit</button> --!>
		</form>
	<br />
	<?php foreach($functions as $f) {
		if($f->user_function =="helpline_session_plan" && ($f->add==1)) { ?>
	<table>
		<tr>
		<button type="button" class="btn btn-info" data-toggle="modal" data-target="#addModal">ADD</button>
		</tr>
	</table>
	<?php } ?>
	<?php } ?>

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
	$total_records = count($report);
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
		<th>Helpline Name</th>
		<th>Weekday</th>
		<th>Helpline Session Role</th>
		<th>Helpline Session Name</th>
		<th>Count</th>
	</thead>
	<tbody>
	<?php 
	$sno=(($page_no - 1) * $total_records_per_page)+1 ; 
	
	foreach($report as $s){
	?>
	<tr>
		<td><?php echo $sno;?></td>
		<td><?php echo $s->helpline.'-'.$s->note;?></td>
		<td><?php echo $weekdays[$s->weekday]; ?></td>
		<td><?php echo $s->helpline_session_role;?></td>
		<td><?php echo $s->session_name;?></td>
		<td style="text-align:center"><button type="button" class="btn btn-success" autofocus onclick="$('#select_helpline_<?php echo $s->helpline_session_id;?>').submit()"><?php echo $s->count_receiver_id ?></button></td>
		
		<?php echo form_open('helpline/update_user_helpline_sessionplan',array('role'=>'form','id'=>'select_helpline_'.$s->helpline_session_id));?>
		<input type="text" class="sr-only" hidden value="<?php echo $s->count_receiver_id;?>" form="select_helpline_<?php echo $s->helpline_session_id;?>" name="selected_helpline" />
		<input type="text" class="sr-only" hidden value="<?php echo $s->count_receiver_id;?>" name="count_id" />
		<input type="text" class="sr-only" hidden value="<?php echo $s->helpline_id;?>" name="helpline_id" />
		<input type="text" class="sr-only" hidden value="<?php echo $s->helpline_session_id;?>" name="helpline_session_id" />
		<input type="text" class="sr-only" hidden value="<?php echo $s->helpline_session_plan_id;?>" name="helpline_session_plan_id" />
		</form>
	</tr>
	<?php $sno++;}	?>
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
	<?php } else { ?>
	
	No Helpline Sessions.
<?php }  ?>
</div>	

<div class="modal fade" id="addModal" role="dialog">
	<div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header bg-primary text-white">
		      <button type="button" class="close" data-dismiss="modal">&times;</button>
		      <h4 class="modal-title">Update Helpline Session</h4>
		</div>
		<div class="modal-body">
			<div>
			</div>	

			<?php echo form_open("helpline/session_plan",array('role'=>'form','class'=>'form-custom','id'=>'addModalForm')); ?>
			<div class="form-group">
				<label for="receiver">Helpline :</label>
				<select name="helpline_modal" id="helpline_modal" required class="form-control">
					<option value="">Helpline</option>
					<?php 
					foreach($helpline as $help){
					echo "<option value='".$help->helpline_id."'";
					if($this->input->post('helpline') && $this->input->post('helpline') == $help->helpline_id) echo " selected "; ?>
						<?php echo ">".$help->helpline.' - '.$help->note;?></option>
					<?php } ?>
			</select>
				
			</div>	
			<div class="form-group">
				<label for="receiver">Helpline Receiver:</label>
				<select name="receiver_id" id="receiver_id" required class="" placeholder="-Enter User Name/Phone-" style="width:400px"> 
					<option value ="">- Enter Receiver Name</option>
				</select>	                        
			</div>	
			<div class="form-group">
				<label for="helpline_session_role">Helpline Session Role:</label>
				<select name="session_role_id" id="session_role_id" required class="form-control">
				<option value="">Select Session Role</option>
				<?php 
				foreach($helpline_session_role as $session_role){
				echo "<option value='".$session_role->helpline_session_role_id."' class='".$session_role->helpline_session_role_id."'";
				echo ">".$session_role->helpline_session_role."</option>";
				}
				?>
			</select>
			</div>	
			<div class="form-group">
				<label for="helpline_session">Helpline Weekday:</label>
			<select name="weekday_modal" id="weekday_modal" class="form-control" required>
				<option value="">Weekday</option>
			</select>
			</div>	
			<div class="form-group">
				<label for="helpline_session_name">Helpline Session Name:</label>
			<select name="session_name_modal" id="session_name_modal" class="form-control" required>
				<option value="">Helpline Session Name</option>
			</select>
			</div>	
			<div>
			 Helpline Session Note: <input type="text" style="width:300px;" class="form-custom form-control" name="session_note" value="" placeholder="Helpline Session Note"/>
			</div>
			<br/>
			<input type="text" hidden class="sr-only" name="submit_modal" value="submitModal1"/>
			<button type="button" class="btn btn-info" required name="submit_modal" onclick="addModalSubmit()">Submit</button>
			<button type="button" class="btn btn-default" data-dismiss="modal" onclick="addModalClose()">Close</button>

			</form> 
	<!--<div hidden id="success_added" name="success_team_member">
	 "Team Member Successfully Added to the Helpline Session"
	</div> --!>
		</div>
	</div>

	</div>
</div>
<!-- Modal -->
 
<script type="text/javascript">
var helpline_sessions = <?php echo json_encode($helpline_sessions); ?>; 
var weekdays = <?php echo json_encode($weekdays); ?>;
function buildEmptyOption(optionName = "Select") {
	return `<option value="" selected>
					${optionName}
			</option>`;

}

function gethelplineSession(){
	 // console.log(helpline_sessions);
	var weekday_id = document.getElementById("weekday_modal").value;
	const helpline_Sessions = helpline_sessions.filter(session => session.weekday == weekday_id);
	var helpline = document.getElementById("helpline_modal").value;
	// console.log(helpline);
	const helplineSessions = helpline_Sessions.filter(session => session.helpline_id == helpline);
	let optionsHtml = buildEmptyOption("Helpline Session");
	if (helplineSessions.length > 0) {
		optionsHtml += helplineSessions.map(session => {
			return `	<option value="${session.helpline_session_id}">
							${session.session_name}
						</option>`;
		});
	
		return optionsHtml;
	}	
	return optionsHtml;
}

function gethelplineSessionfromHelplineid(){
	 // console.log(helpline_sessions);
	var helpline = document.getElementById("helpline").value;
	console.log(helpline);
	let optionsHtml = buildEmptyOption("Helpline Session");
	var helplineSessions = {};
	if (helpline != "") {
		helplineSessions = helpline_sessions.filter(session => session.helpline_id == helpline);
			
	}
	var weekday_id = document.getElementById("weekday").value;
	
	if (weekday_id != "") {
		if (helplineSessions.length > 0) {
		helplineSessions = helplineSessions.filter(session => session.weekday == weekday_id);
		}
		else{
		helplineSessions = helpline_sessions.filter(session => session.weekday == weekday_id);
		}
			
	}
	if (helplineSessions.length > 0) {
			optionsHtml += helplineSessions.map(session => {
				return `	<option value="${session.helpline_session_id}">
							${session.session_name}
						</option>`;
			});
	
		
		}
	return optionsHtml;
}
function setupSessionNameDropDown(){
	console.log("select changed ");
	//console.log(weekday_id);
	const optionsHtml = gethelplineSession();
	$("#session_name_modal").html(optionsHtml);
}

function setupSessionNameMainFilterDropDown(){
	console.log("select changed ");
	//console.log(weekday_id);
	const optionsHtml = gethelplineSessionfromHelplineid();
	$("#session_name").html(optionsHtml);
}

$("#helpline_modal").on("change", function() {
setupSessionNameDropDown();});

$("#helpline").on("change", function() {
setupSessionNameMainFilterDropDown();});

$("#weekday").on("change", function() {
setupSessionNameMainFilterDropDown();});

function setupDefaultWeekDayDropDown(){
	let optionsHtml = buildEmptyOption("Weekdays");
	var keys = Object.keys(weekdays);
	for (i = 0 ; i < keys.length ; i++) {
		optionsHtml +=  `	<option value="${keys[i]}">
							${weekdays[keys[i]]}
						</option>`; 
	}
	return optionsHtml;
}
function setupWeekdayDropdown(){
	// console.log(weekdays);
	const optionsHtml = setupDefaultWeekDayDropDown();
	$("#weekday_modal").html(optionsHtml);
	$("#weekday_modal").on("change", function() {
		const weekdayId = $(this).val();
		console.log("the value is ",$(this));	
		setupSessionNameDropDown(weekdayId);
	});
	console.log("setupWeekDayDropDown");
	
}
<?php
/*
$("#helpline_modal").on("change", function() {
	const helplineId = $(this).val();
	console.log("the value is ", $(this));
}
*/ ?>
function goSubmit() {
	$.ajax({
type: 'POST',
url: $("#helplineForm").attr("action"),
data: $("#helplineForm").serialize(), 
//or your custom data either as object {foo: "bar", ...} or foo=bar&...
success: function(response) { console.log('go submitted'); },
});
}

function addModalClose() {
		document.getElementById("addModalForm").reset();
		var $select = $("#receiver_id").selectize();
		var control = $select[0].selectize;
		control.clear();
}

function addModalSubmit() {
var helpline = document.getElementById("helpline_modal").value;
var receiver = document.getElementById("receiver_id").value;
var role = document.getElementById("session_role_id").value;
var weekday_modal = document.getElementById("weekday_modal").value;
var session = document.getElementById("session_name_modal").value;


if (helpline.length === 0 || receiver.length === 0 || role.length === 0 || weekday_modal.length === 0 || session.length === 0) {
	bootbox.alert("Please fill all the values");
	return;	
}

	$.ajax({
type: 'POST',
url: $("#addModalForm").attr("action"),
data: $("#addModalForm").serialize(), 
//or your custom data either as object {foo: "bar", ...} or foo=bar&...
success: function(response) { 
		// $("#success_added").attr("hidden",false);
		bootbox.alert('Team Member added successfully'); 
		document.getElementById("addModalForm").reset();
		var $select = $("#receiver_id").selectize();
		var control = $select[0].selectize;
		control.clear();

		},
error: function(response) {
		bootbox.alert('Team Member already exists');
		document.getElementById("addModalForm").reset();
		var $select = $("#receiver_id").selectize();
		var control = $select[0].selectize;
		control.clear();
}
});
}
$('#addModal').on('hidden.bs.modal', function () {
  // do something...
$("#addModalForm").trigger("reset");
	document.getElementById("addModalForm").reset();
		document.getElementById("addModalForm").reset();
		var $select = $("#receiver_id").selectize();
		var control = $select[0].selectize;

});

$(document).ready(function() {
	console.log("document ready");
	setupWeekdayDropdown();
	setupSessionNameMainFilterDropDown();
	var session_name = "<?php echo $this->input->post('session_name')?>";
	if(session_name != ""){
		$("#session_name").val(session_name);
	}
})
</script>
