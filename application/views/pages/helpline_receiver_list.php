<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >


<style>
    .call_now_img{
        width: 30px;
        cursor: pointer;
        padding-top: 5px;
    }
    .info_icon{
    	width: 20px;
    	height: 20px;
    }
</style>

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
        $('#helpline_receivers').submit();
   }
function onchange_page_dropdown(dropdownobj){
   doPost(dropdownobj.value);    
}
</script>
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

<?php $page_no = 1;	?>
 <h3 class="col-md-12">List of Receivers</h3>
<?php echo form_open("helpline/helpline_receivers",array('role'=>'form','class'=>'form-custom col-md-12','id'=>'helpline_receivers')); ?> 
 <input type="hidden" name="page_no" id="page_no" value='<?php echo "$page_no"; ?>'>
 <select name="helpline_id" id="helplineSelect" style="width:170px" class="form-control">
				<option value="">Helpline</option>
				<?php foreach($helpline as $line){ ?>
					<option value="<?php echo $line->helpline_id;?>"
					<?php if($this->input->post('helpline_id') == $line->helpline_id) echo " selected "; ?>
					><?php echo $line->helpline.' - '.$line->note;?></option>
				<?php } ?>
			</select>
			<input type="text" class="form-control" placeholder="Phone"  style="width:120px"  value="<?php echo $this->input->post('phone');?>" name="phone" />
			  Rows per page : <input type="number" class="rows_per_page form-custom form-control" name="rows_per_page" id="rows_per_page" min=<?php echo $lower_rowsperpage; ?> max= <?php echo $upper_rowsperpage; ?> step="1" value= <?php if($this->input->post('rows_per_page')) { echo $this->input->post('rows_per_page'); }else{echo $rowsperpage;}  ?> onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" /> 
    			Doctor : <select name="isdoctor" id="isdoctor" class="form-control">
    			<option value="">Select</option>   
                        <option value="Yes" <?php echo ($this->input->post('isdoctor') == 'Yes') ? 'selected' : ''; ?> >Yes</option> 
                        <option value="No" <?php echo ($this->input->post('isdoctor') == 'No') ? 'selected' : ''; ?> >No</option>          
                        </select>
                        Out Bound Call : <select name="outboundcall" id="outboundcall" class="form-control">
    			<option value="">Select</option>   
                        <option value="Yes" <?php echo ($this->input->post('outboundcall') == 'Yes') ? 'selected' : ''; ?> >Yes</option> 
                        <option value="No" <?php echo ($this->input->post('outboundcall') == 'No') ? 'selected' : ''; ?> >No</option>          
                        </select>
                        Activity Status : <select name="activitystatus" id="activitystatus" class="form-control">
    			<option value="">Select</option>   
                        <option value="Yes" <?php echo ($this->input->post('activitystatus') == 'Yes') ? 'selected' : ''; ?> >Yes</option> 
                        <option value="No" <?php echo ($this->input->post('activitystatus') == 'No') ? 'selected' : ''; ?> >No</option>          
                        </select>
 <input type="submit" value="Search" name="submitBtn" class="btn btn-primary btn-sm" /> 
</form>
<br />

<div class="col-md-12">
 <br />
    <?php if(isset($receivers_exists_msg)) { ?>
        <div class="col-md-12 alert alert-danger"><?php echo $receivers_exists_msg; ?></div>
    <?php } else { ?>
       
        
        <?php  if($helpline_receiver_add == 1 ) { ?>
         <a href="<?php echo base_url()."helpline/helpline_receivers_form";?>" class="btn btn-primary">Add Helpline Receiver</a>
         <?php } ?>
    <?php }?>
   <br />
  
       <?php if(isset($receivers) && count($receivers)>0)
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
    <div class="col-md-12 "></div>	
    <table class="table table-bordered table-striped" id="table-sort">
        <thead>
            <th style="text-align:center">S.no</th>
            <th style="text-align:center">Name</th>
            <th style="text-align:center">Phone</th>            
            <th style="text-align:center">Email</th>
            <th style="text-align:center">Category</th>
            <th style="text-align:center">User</th>      
            <th style="text-align:center">Doctor</th>      
            <th style="text-align:center">OutBound</th>    
            <th style="text-align:center">App ID</th>  
            <th style="text-align:center">Helpline</th>  
            <th style="text-align:center">Activity Status</th>
            <th style="text-align:center">Helpline Receiver Note</th>
            <?php  if($helpline_receiver_edit == 1 ) { ?>
            	<th style="text-align:center">Action</th>     
            <?php } ?>       
        </thead>   
    <tbody>
    <?php 
    $i=(($page_no - 1) * $total_records_per_page)+1 ; 
    
    foreach($receivers as $a){ ?>
    <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo $a->full_name;  ?></td>
        <td><?php echo $a->phone;?> </td>        
        <td><?php echo $a->email; ?></td>
        <td><?php echo $a->category; ?></td>
        <td>
            <?php echo $a->user_id ? 'Yes': 'No';?>
        </td>
        <td>
            <?php echo $a->doctor == 1 ? 'Yes': 'No';?>
        </td>
        <td>
            <?php echo $a->enable_outbound == 1 ? 'Yes': 'No';?>
        </td>
        <td><?php echo $a->app_id; ?></td>
        <td><?php echo $a->helpline; ?></td>
        <td>
            <?php echo $a->activity_status == 1 ? 'Yes': 'No';?>
        </td>
        <td>
        <?php echo substr($a->helpline_receiver_note, 0, 25); ?>
        <?php if(strlen($a->helpline_receiver_note) > 25) { ?>
        <br/>
          <p title="<?php echo $a->helpline_receiver_note; ?>" data-toggle="tooltip"><u style="color:#428bca">Read More*</u></p>
          <?php } ?>
        </td>
        <?php  if($helpline_receiver_edit == 1 ) { ?>
        	<td><a href="<?php echo base_url()."helpline/helpline_receivers_form/".$a->receiver_id;?>" class="btn btn-primary">Edit</a></td>
        <?php } ?> 
    </tr>
    <?php } ?>
    </tbody>
</table>
<div style='padding: 0px 2px;'>
<h5 style="color:#428bca"><b>*: Hover the mouse to see notes.</b></h5>
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
	
	No Helpline receivers for this search criteria.
<?php }  ?>
</div>

