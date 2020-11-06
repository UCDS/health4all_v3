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
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.in.css" >
<script type="text/javascript">
$(document).ready(function(){$("#from_date").datepicker({
		dateFormat:"dd-M-yy",changeYear:1,changeMonth:1,onSelect:function(sdt)
		{$("#to_date").datepicker({dateFormat:"dd-M-yy",changeYear:1,changeMonth:1})
		$("#to_date").datepicker("option","minDate",sdt)}})
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
        $('#from_time').ptTimeSelect();
	$('#to_time').ptTimeSelect();
        });
</script>
<div class="row">

<?php if(isset($report)) { ?>

	<h3 class="col-md-12">List of Documents 
	<?php if($add_access==1){ ?>
	<a href="<?php echo base_url()."documentation/add_document";?>" class="btn btn-primary">Add</a>
	<?php } ?></h3>

	<table class="table table-bordered table-striped" id="table-sort">
	<thead>
		<th>SNo</th>
		<th>Keyword</th>
		<th>Topic</th>
		<th>Document</th>
		<th>Document Date</th>
		<?php if($edit_access==1){ ?>
		    <th>Added by</th>
			<th>Edited by</th>		
	    	<th>Edit</th>
		<?php } ?>		
	</thead>
	<tbody>
	<?php 
	$sno=1;
	foreach($report as $s){
	?>
	<tr>
		<td><?php echo $sno;?></td>
		<td><?php echo $s->keyword;?></td>
		<td><?php echo $s->topic;?></td>
		<td style="text-align:center;">
			<?php 
			// Display document icon with document hyper link only if document link is available in DB
			if(isset($s->document_link) && $s->document_link!="") {echo "<a href=" . base_url() . "documentation/display_document/" . $s->document_link . 
			" target=\"_blank\"><i class=\"fa fa-file\" style=\"font-size:24px;color:rgb(236, 121, 121)\"></i></a>";}
			  else {echo "";}
			?>
		</td>
		<td><?php echo date("j M Y", strtotime("$s->document_date"));?></td>
		<?php if($edit_access==1){ ?>		
			<td><?php echo $s->creator . ", "; 
				if(isset($s->insert_datetime) && $s->insert_datetime!="" 
				   && strtotime($s->insert_datetime)!=strtotime('0000-00-00 00:00:00')) 
				{echo date("j M Y", strtotime("$s->insert_datetime")).", ".date("h:i A.", strtotime("$s->insert_datetime"));} 
				else {echo $s->insert_datetime="";}?>
			</td>
			<td><?php echo $s->modifier . ", "; 
				if(isset($s->update_datetime) && $s->update_datetime!=""
				&& strtotime($s->update_datetime)!=strtotime('0000-00-00 00:00:00')) 
				{echo date("j M Y", strtotime("$s->update_datetime")).", ".date("h:i A.", strtotime("$s->update_datetime"));} 
				else {echo $s->update_datetime="";}?>
			</td>			
	    	<td>
	            <a href="<?php echo base_url()."documentation/edit_document/".$s->id;?>" class="btn btn-primary">Edit</a>
	    	</td>
		<?php } ?>		
	</tr>
	<?php $sno++;}	?>
	</tbody>
	</table>	
	<?php } else { ?>
	     No documents available.
<?php } ?>
</div>	
