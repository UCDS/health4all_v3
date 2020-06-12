<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
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
		$("#from_date,#to_date").Zebra_DatePicker();
	});
</script>

<div class="col-md-10 col-sm-9">
<?php
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date('d-M-Y',strtotime($this->input->post('from_date')));
			$to_date=date('d-M-Y',strtotime($this->input->post('to_date')));
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
		 $this->input->post('from_date')==""?$from_date=date("d-M-Y",strtotime($this->input->post('to_date'))):$from_date=date("d-M-Y",strtotime($this->input->post('from_date')));
		 $to_date=$from_date;
		}
		else if(!!$from_date && !!$to_date){
			$from_date=date('d-M-Y',strtotime($from_date));
			$to_date=date('d-M-Y',strtotime($to_date));
		}
		else if(!!$from_date || !!$to_date){
		 $from_date=="0"?$from_date=$to_date:$to_date=$from_date;
		}
		else{
			$from_date=date('d-M-Y',strtotime('-10 Days'));
			$to_date=date('d-M-Y');
		 }
		if($this->input->post('from_num') && $this->input->post('to_num')){
			$from_num=trim($this->input->post('from_num'));
			$to_num=trim($this->input->post('to_num'));
		}
		else if($this->input->post('from_num') || $this->input->post('to_num')){
		 $this->input->post('from_num')==""?$from_num=$this->input->post('to_num'):$from_num=$this->input->post('from_num');
		 $to_num=$from_num;
		}
		else {
			$from_num="";
			$to_num="";
		}
?>
	<div>
		<?php echo form_open('bloodbank/user_panel/report_donations',array('role'=>'form','class'=>'form-custom')); ?>
		<div>
			<input type="text" placeholder="From date" size="10" class="form-control" name="from_date" value="<?php echo $from_date;?>" id="from_date" />
			<input type="text" placeholder="To date" size="10" class="form-control" value="<?php echo $to_date;?>" name="to_date" id="to_date" />
			<input type="text" placeholder="From Num" size="10" class="form-control" value="<?php echo $from_num;?>" name="from_num" id="from_num" />
			<input type="text" placeholder="To Num" size="10" class="form-control" value="<?php echo $to_num;?>" name="to_num" id="to_num" />
			<select name="camp" class="form-control">
					<option value="" selected>Location</option>
					<?php foreach($camps as $c){
						echo "<option value='$c->camp_id'>$c->camp_name</option>";
					}
					?>
			</select>
			<input type="submit" value="Search" name="search" class='btn btn-primary btn-md' />
		</div>
		</form>
		<hr>
                <button type="button" class="btn btn-default btn-md print">
		  <span class="glyphicon glyphicon-print"></span> Print
		</button>
		<?php
		if(isset($msg)) {
			echo "<div class='alert alert-info'>$msg</div>";
			echo "<br />";
		}
		?>
		<?php if(count($donated)>0){ ?>
		<b>
		<?php
		
		if($this->input->post('from_date') && $this->input->post('to_date')){
			$from_date=date('d-M-Y',strtotime($this->input->post('from_date')));
			$to_date=date('d-M-Y',strtotime($this->input->post('to_date')));
			echo "Donations from ".$from_date." to ".$to_date;
		}
		else if($this->input->post('from_date') || $this->input->post('to_date')){
		 $this->input->post('from_date')==""?$date=$this->input->post('to_date'):$date=$this->input->post('from_date');
		 echo "Donations on $date";
		}
		else{
			echo "Donations report";	
		}
		?>
		</b>
		<table id="header-fixed" class="table-2 table table-striped table-bordered hidden"></table>
		<div class="pull-right">
			<span style="width:10px;background:#C0FAB4;margin:5px;">&nbsp&nbsp&nbsp&nbsp </span> Screened. <br />
			<span style="width:10px;background:#FAB4B4;margin:5px;">&nbsp&nbsp&nbsp&nbsp </span> Screening Positive <br />
			<span style="width:10px;background:#FAEDB4;margin:5px;">&nbsp&nbsp&nbsp&nbsp </span> Grouped waiting for screening <br />
			<span style="width:10px;background:#F9F9F9;margin:5px;">&nbsp&nbsp&nbsp&nbsp </span> Waiting for Grouping
		</div>
		<table class="table table-bordered" id="table-sort">
		<thead><th>S.No</th><th>Date</th><th>Blood Unit No.</th><th>Donor Name</th><th>Blood Group</th><th>Donated at</th></thead>
		<?php 
		$i=1;
		$background="";
		foreach($donated as $row){
		if($row->donation_status_id==6 && $row->screening_result==1){
			$background="style='background:#C0FAB4'";
		}
		else if($row->donation_status_id==6 && $row->screening_result==0){
			$background="style='background:#FAB4B4'";
		}
		else if($row->donation_status_id==5){
			$background="style='background:#FAEDB4'";
		}
		?>
		<tr  <?php echo $background;?>>
			<td><?php echo $i++;?></td>
			<td><?php echo date("d-M-Y",strtotime($row->donation_date));?></td>
			<td><?php echo $row->blood_unit_num;?></td>
			<td><?php echo $row->name;?></td>
			<td><?php echo $row->blood_group;?></td>
			<td style="width:70px;"><?php echo $row->camp_name;?></td>
			</tr>
		<?php 
		}
		?>
		</table>
		<?php }
		else{
			 ?>
			 <p>No donations in the specified period.</p>
		<?php } ?>
	</div>
</div>
