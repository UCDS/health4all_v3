<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/selectize.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>


<style>
	.call_now_img{
	    cursor: pointer;
	    padding-top: 5px;
	    color: #5cb85c;
	}
	.call_now_img .fa-phone{
		border: 1px solid #5cb85c;
	    border-radius: 50%;
	    width: 40px;
	    height: 40px;
	    padding: 8px 4px 5px 4px;
	}
	.hidden{
		display: none; 
		visibility: hidden;
	}
	.line-through{
		text-decoration: line-through;
	}
	.error{
		color: red;
		font-size: 12px;
	}
</style>
<script type="text/javascript">
function doPost(page_no){	
	var page_no_hidden = document.getElementById("page_no");
  	page_no_hidden.value=page_no;
        $('#sms_detailed_report').submit();   
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
<style>
	.call_now_img{
	    cursor: pointer;
	    padding-top: 5px;
	    color: #5cb85c;
	}
	.call_now_img .fa-phone{
		border: 1px solid #5cb85c;
	    border-radius: 50%;
	    width: 40px;
	    height: 40px;
	    padding: 8px 4px 5px 4px;
	}
	.hidden{
		display: none; 
		visibility: hidden;
	}
	.line-through{
		text-decoration: line-through;
	}
	.error{
		color: red;
		font-size: 12px;
	}
</style>
<script type="text/javascript">

$(function(){
	$(".date").Zebra_DatePicker();
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
  });
</script>
<!--
<div class="row">
	<?php // if(!!$msg) { ?>
		<div class="alert alert-info">
			<?php // echo $msg; ?>
		</div>
	<?php // } ?>
	-->

	<?php
			$page_no = 1;
			foreach($defaultsConfigs as $default){		 
		 	if($default->default_id=='pagination'){
		 			$rowsperpage = $default->value;
		 			$upper_rowsperpage = $default->upper_range;
		 			$lower_rowsperpage = $default->lower_range;
		 		}
			}
			if($this->input->post('from_date')){
				$from_date = date("d-M-Y",strtotime($this->input->post('from_date')));
			}
			else $from_date = date("d-M-Y");
			if($this->input->post('to_date')){
				$to_date = date("d-M-Y",strtotime($this->input->post('to_date')));
			}
			else $to_date = date("d-M-Y");
			echo form_open('helpline/sms_detailed_report',array('role'=>'form','class'=>'form-custom','id'=>'sms_detailed_report','name'=>'sms_detailed_report'));
	?>
			<h4>SMS during</h4>
			<input type="text" class="date form-control" value="<?php echo $from_date;?>" name="from_date" /> to 
			<input type="text" class="date form-control" value="<?php echo $to_date;?>" name="to_date" />

			<select name="helpline_id" style="width:150px" class="form-control">
				<option value="">Helpline</option>
				<?php foreach($helpline as $line){ ?>
					<option value="<?php echo $line->helpline_id;?>"
					<?php if($this->input->post('helpline_id') == $line->helpline_id) echo " selected "; ?>
					><?php echo $line->helpline.' - '.$line->note;?></option>
				<?php } ?>
			</select>
			
			<input type="text" class="form-control" placeholder="To Number"  style="width:150px"  value="<?php echo $this->input->post('to_number');?>" name="to_number" />
			<select name="sms_template" style="width:150px" class="form-control">
				<option value="">Template</option>
				<?php foreach($sms_template as $template){ ?>
					<option value="<?php echo $template->sms_template_id;?>"
					<?php if($this->input->post('sms_template') == $template->sms_template_id) echo " selected "; ?>									
					><?php echo $template->template_name;?></option>
				<?php } ?>
			</select>
				<br/>
			<select name="sent_status" style="width:150px" class="form-control">
				<option value="">Status</option>
				<?php foreach($sent_status as $valstatus){ ?>
					<option value="<?php echo $valstatus->status_code;?>"
					<?php if($this->input->post('sent_status') == $valstatus->status_code) echo " selected "; ?>
					><?php echo $valstatus->status_text ." - ". $valstatus->status_code;?></option>
				<?php } ?>
			</select>
			<input type="hidden" name="page_no" id="page_no" value='<?php echo "$page_no"; ?>'>	
			 Rows per page : <input type="number" class="rows_per_page" name="rows_per_page" id="rows_per_page" min=<?php echo $lower_rowsperpage; ?> max= <?php echo $upper_rowsperpage; ?> step="1" value= <?php if($this->input->post('rows_per_page')) { echo $this->input->post('rows_per_page'); }else{echo $rowsperpage;}  ?> onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" /> 
			<input type="submit" value="Go" name="submitBtn" class="btn btn-primary btn-sm" />
		</form>
	<?php
		if(!!$sms_data){
	?>
	<?php 
	$total_records_per_page = $this->input->post('rows_per_page');
	if ($this->input->post('page_no')) { 
		$page_no = $this->input->post('page_no');
	}
	else{
		$page_no = 1;
	}
	$total_records = $sms_count[0]->count;		
	$total_no_of_pages = ceil($total_records / $total_records_per_page);
	if ($total_no_of_pages==0)
		$total_no_of_pages = 1;
	$second_last = $total_no_of_pages - 1; 
	$offset = ($page_no-1) * $total_records_per_page;
	$previous_page = $page_no - 1;
	$next_page = $page_no + 1;
	$adjacents = "2";	
?>
	<br/>
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
		<table class="table table-striped table-bordered" id="table-sort">
			<colgroup>
				<col style="width: 1.3%;">
				<col style="width: 2.1%;">
				<col style="width: 2.2%;">
				<col style="width: 6.2%;">
				<col style="width: 20.1%;">
				<col style="width: 5.6%;">
				<col style="width: 3.8%;">
				<col style="width: 5.8%;">
				<col style="width: 6.7%;">
			</colgroup>
			<thead>
				<th>#</th>
				<th>SMS ID</th>
				<th>To Number</th>
				<th>SMS Template</th>
				<th>SMS Content</th>
				<th>Initiated Time</th>	
				<th>Status Code</th>
				<th>Sent Time</th>				
				<th>Team Member @ Helpline</th>			
				
			</thead>
			<tbody>
			<?php
				$i=1;
				foreach($sms_data as $sms){ ?>
					<tr>
						<td>
							<?php echo $i++;?>
						</td>
						<td>
							<?php echo $sms->id;?>
						</td>
						<td>
							<?php echo $sms->receiver;?>
						</td>
						<td>
							<?php echo $sms->template_name;?>
						</td>
						<td>
							<?php echo $sms->body;?>
						</td>						
						<td>
							<?php echo date("j-M-Y", strtotime("$sms->created_date")).' '.date("h:i A.", strtotime("$sms->created_time"));?>
						</td>
						<td style="text-align:center;">
							<?php echo $sms->status_code;?>
						</td>
						<td>
							<?php  if ($sms->sent_date !== NULL && $sms->sent_time) {
							echo date("j-M-Y", strtotime("$sms->sent_date")).' '.date("h:i A.", strtotime("$sms->sent_time"));
							}?>
						</td>
						<td>
							<?php echo $sms->short_name.' @ '.$sms->helpline;?>
						</td>
						
					</tr>
				<?php }
				?>
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
		<?php
			}
		else{
			echo "No SMS on the given day.";
		}
		?>
</div>

