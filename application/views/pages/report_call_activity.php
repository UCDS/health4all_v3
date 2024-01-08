<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/selectize.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/selectize.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/selectize.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.selectize.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>

<script type="text/javascript">
function doPost(page_no){	
	var page_no_hidden = document.getElementById("page_no");
  	page_no_hidden.value=page_no;
        $('#call_detailed_report').submit();   
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

<script type="text/javascript">
        $(document).ready(function(){
			// find the input fields and apply the time select to them.
        $('#from_time').ptTimeSelect();
        $('#to_time').ptTimeSelect();
		$('#from_date').Zebra_DatePicker();
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
			if($this->input->post('from_date')){
				$from_date = date("d-M-Y",strtotime(($this->input->post('from_date'))));
			}
			else $from_date = date("d-M-Y");
			if($this->input->post('to_date')){
				$to_date = date("d-M-Y",strtotime($this->input->post('to_date')));
			}
			else $to_date = date("d-M-Y");
			echo form_open('helpline/receiver_call_activity_report',array('role'=>'form','class'=>'form-custom','id'=>'call_detailed_report','name'=>'call_detailed_report' ));
			
	?>
			<h4>Receiver Call Activity</h4>
			<input class="form-control date" type="text" style="width:120px" value="<?php echo $from_date;?>" name="from_date" />
			<input type="text" style="width:120px" class="date form-control" value="<?php echo $to_date;?>" name="to_date" />


			<input type="checkbox" id="year_month_trend" name="year_month_trend" value="1" <?php if($this->input->post('year_month_trend')) echo "checked"; ?> onclick="handleClick();">

			<label for="year_month_trend">Year Month Trend:</label>

			<select name="helpline_id" id="helplineSelect" style="width:170px" class="form-control">
				<option value="">Helpline</option>
				<?php foreach($helpline as $line){ ?>
					<option value="<?php echo $line->helpline_id;?>"
					<?php if($this->input->post('helpline_id') == $line->helpline_id) echo " selected "; ?>
					><?php echo $line->helpline.' - '.$line->note;?></option>
				<?php } ?>
			</select>
			
			<input type="text" class="form-control" placeholder="Phone Number" style="width:120px"  value="<?php echo $this->input->post('from_number');?>" name="from_number" />			
			<input type="hidden" name="page_no" id="page_no" value='<?php echo "$page_no"; ?>'>	
			 Rows per page : <input type="number" class="rows_per_page" name="rows_per_page" id="rows_per_page" min=<?php echo $lower_rowsperpage; ?> max= <?php echo $upper_rowsperpage; ?> step="1" value= <?php if($this->input->post('rows_per_page')) { echo $this->input->post('rows_per_page'); }else{echo $rowsperpage;}  ?> onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" /> 
			 <br />
			<input type="submit" value="Go" name="submitBtn" class="btn btn-primary btn-sm" />

		</form></h4><br />
	<?php
		if(!!$calls){
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
	//$tmp_count = 0;
	//foreach($calls_count as $count){
	//	$tmp_count = $tmp_count + 1;
	//}
	//$total_records = $tmp_count;
	//echo("<script>console.log('PHP: " . json_encode($calls_count) . "');</script>");
	$total_records = $calls_count[0]->count ;		
	$total_no_of_pages = ceil($total_records / $total_records_per_page);
	if ($total_no_of_pages==0)
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
		<table class="table table-striped table-bordered" id="table-sort">
			<colgroup>
				<col style="width: 1.3%;">
				<col style="width: 3.1%;">
				<col style="width: 3.7%;">
				<col style="width: 4.2%;">
				<col style="width: 4.1%;">
				<col style="width: 4.1%;">
			</colgroup>
			<thead>
				<th>#</th>
				<th>Receiver</th>	
				<th>Phone</th>
				<th>Active Days </th>
				<th>Year </th>
				<th>Month </th>
				<th>Incoming Calls</th>
				<th>Outgoing Calls</th>
				<th>Total Calls</th>
				<!-- <th class="hidden">Resolution Time</th>
				<th class="hidden">TAT</th> -->
				<!-- <th>Hospital</th>
				<th>Patient</th> -->
			</thead>
			<tbody>
			<?php
				$i=(($page_no - 1)* $total_records_per_page) + 1;
				foreach($calls as $call){ ?>
					<tr>
						<td style="text-align:right">
							<?php echo $i++;?>
						</td>
						<td>
							<?php echo $call->Receiver;?>
						</td>
						<td>
							<?php echo $call->Phone; ?>
						</td>
						<td style="text-align:right"> <?php echo $call->ActiveDays; ?>
						</td>
						<td style="text-align:right"> <?php if ($this->input->post('year_month_trend')) echo $call->Year; else echo "==="; ?>
						</td>
						<td style="text-align:right"> <?php if ($this->input->post('year_month_trend')) echo $call->Month; else echo "===";?> </td>
						<td style="text-align:right"> <?php echo $call->IncomingCalls; ?>
						<td style="text-align:right"> <?php echo $call->OutgoingCalls; ?>
						<td style="text-align:right"> <?php echo $call->TotalCalls; ?>

						
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
			echo form_close();
			}
		else{
			echo "No calls on the given day.";
		}
		?>
</div>


<script type="text/javascript">



function setFromNumber(){
	callDetails.from = $('#callModal-customer').val();
}

function setSmsToNumber(){
	smsDetails.to = $('#smsModal-customer').val();
}

function setHelplineNumber(){
	callDetails.called_id = $('#callModal-helplinewithname-dropdown').val();
}

function connectToChangeReset(){
	$('.callModal-customer-error').hide();
	$('.callModal-app_id-error').hide();

	$('[href="#change_connectto"]').removeAttr("data-hidden").html('Change');
	$('#change_connectto_section').addClass('hidden');
	$('[name=radio_doctor]:checked').removeAttr('checked');

	$('#callModal_connectto_alternate_section').addClass('hidden');
	$('#callModal-connectto-alternate option').remove();
	$('#callModal-connectto-alternate-showmore').removeAttr('checked');
}

function sendToChangeReset(){
	$('.smsModal-customer-error').hide();
	$('.smsModal-app_id-error').hide();
	$('.smsModal-template-error').hide(); 

	$('[href="#change_sendto"]').removeAttr("data-hidden").html('Change');
	$('#change_sendto_section').addClass('hidden');
	$('[name=radio_doctor]:checked').removeAttr('checked');

	$('#smsModal_sendto_alternate_section').addClass('hidden');
	$('#smsModal-sendto-alternate option').remove();
	$('#smsModal-sendto-alternate-showmore').removeAttr('checked');
}

function initiateCall(){
	if(!callDetails.from){
		$('.callModal-customer-error').show();
		return;
	}
	$('.callModal-customer-error').hide();
	
	if(!callDetails.app_id){
		$('.callModal-app_id-error').show();
		return;
	}
	$('.callModal-app_id-error').hide();


	// customer to agent flow...
	// ajax for call...
	$('#initiateCallButton').val('Calling...').attr('disabled', 'disabled');

	$.ajax({
        url: '<?php echo base_url();?>helpline/initiate_call',
        type: 'POST',
		dataType : 'JSON',
		data : callDetails,
        error: function(res) {
            //callback();
            $('#initiateCallButton').val('Call').removeAttr('disabled');
            bootbox.alert("Call failed: " + JSON.stringify(res));
        },
        success: function(res) {
			$('#initiateCallButton').val('Call').removeAttr('disabled');
			$("#callModal").modal('hide');
			bootbox.alert("Call initiated successfully");
        }
    });
}

function initiateSms(){
	if(!smsDetails.to){
		$('.smsModal-customer-error').show();
		return;
	}
	$('.smsModal-customer-error').hide();

	// customer to agent flow...
	// ajax for call...
	$('#initiateSmsButton').val('Calling...').attr('disabled', 'disabled');

	$.ajax({
        url: '<?php echo base_url();?>helpline/initiate_sms',
        type: 'POST',
		dataType : 'JSON',
		data : smsDetails,
        error: function(res) {
            //callback();
			$('#initiateSmsButton').val('Send').removeAttr('disabled');
            bootbox.alert(res.responseText);
        },
        success: function(res) {
			$('#initiateSmsButton').val('Send').removeAttr('disabled');
			$("#SmsModal").modal('hide');
			bootbox.alert("Sms sent successfully");
        }
    });
}

function initAgentSelectize(){
	var selectize = $('#callModal-agent').selectize({
	    valueField: 'receiver_id',
	    labelField: 'custom_data',
	    searchField: 'custom_data',
	    options: [],
	    create: false,
	    render: {
	        option: function(item, escape) {
	        	return '<div>' +
	                '<span class="title">' +
	                    '<span class="">' + escape(item.custom_data) + '</span>' +
	                '</span>' +
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
	                callback();
	            },
	            success: function(res) {
	            	res = transformAgent(res);
	                callback(res.slice(0, 10));
	            }
	        });
		},

	});
	if($('#callModal-agent').attr("data-previous-value")){
		selectize[0].selectize.setValue($('#callModal-agent').attr("data-previous-value"));
	}
}

function transformAgent(res){
	if(res){
		res.map(function(d){
			d.custom_data = d.full_name + ' - ' + d.phone;
		    return d;
		});
	}
	return res;
}

function loadReceivers(links){
	revertConnecto()

	$.ajax({
        url: '<?php echo base_url();?>helpline/get_helpline_receiver_by_doctor',
        type: 'POST',
		dataType : 'JSON',
		data : { doctor: $('[name=radio_doctor]:checked').val(), helpline: callDetails.called_id, links: links },
        error: function(res) {
            //callback();
        },
        success: function(res) {
			$('#callModal_connectto_alternate_section').removeClass('hidden');
			$('#callModal-connectto-alternate').append('<option value="">Select alternate connect</option>');

			if(res){
				$.each(res, function(i, d){
					$('#callModal-connectto-alternate').append('<option value="'+d.app_id+'">'+d.full_name+', '+d.phone+', '+d.category+'</option>');
				})
			}
        }
    });
}
					
function updateConnectto(){
	revertConnecto();

	if($('#callModal-connectto-alternate').val()){
		callDetails.app_id = $('#callModal-connectto-alternate').val();
		var display_text = $('#callModal-connectto-alternate option[value="'+$('#callModal-connectto-alternate').val()+'"]').html();
		$("#callModal-connectto").addClass('line-through');
		$("#callModal-connectto-updated").html(display_text + ', ' + receiver.note + ', ' + receiver.helpline);
	}
}


function openEditModal(e) {
	const callId = $(e).attr('data-id');
	var callArray = callData.filter((call) => call.call_id == callId);
	var hospitalSelect = hospitals.filter((hospital) =>  hospital.helpline_id == callArray[0].helpline_id);
	var callCategorySelect = callCategory.filter((callCategory) =>  callCategory.helpline_id == callArray[0].helpline_id && callCategory.status == 1);
	var resolutionStatusSelect = resolutionStatus.filter((resolutionStatus) =>  resolutionStatus.helpline_id == callArray[0].helpline_id && resolutionStatus.status == 1);
	if(callArray.length > 0) {
		$('#updateCallModal').modal({backdrop: 'static', keyboard: false});  
		setupUpdateCallModalData(callArray[0],hospitalSelect,callCategorySelect,resolutionStatusSelect);
	}
}
function openSendEmailModal(e) {
	const callId = $(this).attr('data-id');
	// $("#updateCallModal").modal("show");

}

function revertConnecto(){
	callDetails.app_id = receiver.app_id;
	$("#callModal-connectto").removeClass('line-through');
	$("#callModal-connectto-updated").html('');	
}

$(function(){
	$('[data-toggle="tooltip"]').tooltip();


	$('[name=radio_doctor]').on('click', function(e){

		$('#callModal_connectto_alternate_section').addClass('hidden');
		$('#callModal-connectto-alternate option').remove();
		$('#callModal-connectto-alternate-showmore').removeAttr('checked');

		loadReceivers("0");
		
	});

	$('#callModal-connectto-alternate-showmore').on('click', function(e){
		$('#callModal-connectto-alternate option').remove();

		loadReceivers($('#callModal-connectto-alternate-showmore:checked').length > 0 ? "1" : "0");
		
	});
});
function handleClick() {
  var yearmonthtrend = document.getElementById("year_month_trend");
  console.log(yearmonthtrend.checked);

}
</script>
