<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/metallic.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/theme.default.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<!--<script type="text/javascript" src="<//?php echo base_url();?>assets/js/zebra_datepicker.js"></script>-->
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript"
 src="<?php echo base_url();?>assets/js/jquery.timeentry.min.js"></script>
<script type="text/javascript"
 src="<?php echo base_url();?>assets/js/jquery.mousewheel.js"></script>
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
	<style>
	.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.42;
  border-radius: 15px;
}
	</style>
	<script>
function printDiv(i)
{
var content = document.getElementById(i);
var pri = document.getElementById("ifmcontentstoprint").contentWindow;
pri.document.open();
pri.document.write(content.innerHTML);
pri.document.close();
pri.focus();
pri.print();
}
</script>
<script>
$(function(){
$('#to_id  option[value="'+$('#from_id').val()+'"]').hide();
$('#from_id').change(function(){
	$("#to_id option").show();
    var optionval = this.value;
    $('#to_id  option[value="'+optionval+'"]').hide();

});
});
$(function(){
$('#from_id  option[value="'+$('#to_id').val()+'"]').hide();
$('#to_id').change(function(){
	$("#from_id option").show();
    var optionval = this.value;
    $('#from_id  option[value="'+optionval+'"]').hide();

});
});
</script>
<script>
	$(function(){
	$("#from_date,#to_date").Zebra_DatePicker({
		direction:false
	});
	});
</script>
<script>
	$(function(){
		$(".time").timeEntry();
	  $("#item_name").chained("#item_type");
	});
</script>
	<?php
	$from_date=0;$to_date=0;
	if($this->input->post('from_date')) $from_date=date("Y-m-d",strtotime($this->input->post('from_date'))); else $from_date = date("Y-m-d");
	if($this->input->post('to_date')) $to_date=date("Y-m-d",strtotime($this->input->post('to_date'))); else $to_date = date("Y-m-d");
        $from_time=0;$to_time=0;
	if($this->input->post('from_time')) $from_time=date("H:i",strtotime($this->input->post('from_time'))); else $from_time = date("00:00");
	if($this->input->post('to_time')) $to_time=date("H:i",strtotime($this->input->post('to_time'))); else $to_time = date("23:59");
	if($this->input->post('from_id')){
		$from_party = $this->input->post('from_id');
	}
	else{
		$from_party = "0";
	}
	if($this->input->post('to_id')){
		$to_party = $this->input->post('to_id');
	}
	else{
		$to_party = "0";
	}
	?>
			   <div class="text-center">
				<h2> Indent Summary</h2>
				<?php echo form_open('consumables/indent_reports/get_indent_summary',array('class'=>'form-group','role'=>'form','id'=>'evaluate_applicant')); ?>
				<div class="container">
					<div class="row">
						<div class = "col-xs-12 col-sm-12 col-md-2 col-lg-3 col-md-offset-2">
							<div class="form-group">
							<!--input field from date-->
									From Date<input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($from_date)); ?>" name="from_date" id="from_date" size="15" />
							</div>
						</div>
						<div class = "col-xs-12 col-sm-12 col-md-2 col-lg-3">
							<div class="form-group">
							<!--input field to date-->
								To Date<input class="form-control" type="text" value="<?php echo date("d-M-Y",strtotime($to_date)); ?>" name="to_date" id="to_date" size="15" />
							</div>
						</div>
						<div class = "col-xs-12 col-sm-12 col-md-2 col-lg-3">
							<div class="form-group">
							<!--input field from party-->
								<label for="from_id">From Party</label>
									<select name="from_id" id="from_id" class="form-control">
									<option value="">Select</option>
										<?php
											foreach($parties as $fro)
											{
												echo "<option value='".$fro->supply_chain_party_id."'";
												if($this->input->post('from_id') && $this->input->post('from_id') == $fro->supply_chain_party_id) echo " selected ";
												echo ">".$fro->supply_chain_party_name."</option>";

											}
										?>
									</select>
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-2 col-lg-3 col-md-offset-2">
							<div class="form-group">
							<!--input field to party-->
									<label for="inputto_id">To Party</label>
									<select name="to_id" id="to_id" class="form-control">
										<option value="">Select</option>
										<?php
											foreach($parties as $t)
											{
												echo "<option value='".$t->supply_chain_party_id."'";
												if($this->input->post('to_id') && $this->input->post('to_id') == $t->supply_chain_party_id) echo " selected ";
												echo ">".$t->supply_chain_party_name."</option>";
											}
										?>
									</select>
							</div>
					</div>
						<div class = "col-xs-12 col-sm-12 col-md-2 col-lg-3">
							<div class="form-group">
							<!--input field item type-->
								<label for="inputitem_type" >Item Type</label>
									<select name="item_type" id="item_type" class="form-control">
									<option value="">Select</option>
										<?php
											foreach($all_item_type as $it)
												{
													echo "<option value='".$it->item_type_id."'";
												if($this->input->post('item_type') && $this->input->post('item_type') == $it->item_type_id) echo " selected ";
												echo ">".$it->item_type."</option>";
												}
										?>
									</select>
							</div>
						</div>
						<div class = "col-xs-12 col-sm-12 col-md-2 col-lg-3">
							<div class="form-group">
							<!--input field item-->
								<label for="inputitem" >Item</label>
									<select name="item" id="item" class="form-control">
									<option value="">Select</option>
										<?php
											foreach($all_item as $i)
												{
													//echo"<option class='".$i->item_type_id."' value='".$i->item_id."'>".$i->item_name."-".$i->item_form."-".$i->dosage.$i->dosage_unit."</option>";
													echo "<option class='".$i->item_type_id."' value='".$i->item_id."'";
													if($this->input->post('item') && $this->input->post('item') == $i->item_id) echo " selected ";
													echo ">".$i->item_name."-".$i->item_form."-".$i->item_type."-".$i->dosage.$i->dosage_unit."</option>";
												}
										?>
									</select>
							</div>
						</div>

				</div>
		</div>
			<div class="container">
			   <div class="row">
			   <div class="col-md-offset-1">
				   <button class="btn btn-primary" type="submit" name="search" value="search" id="btn">Search</button>
				   	<?php echo form_close(); ?>
			   </div>
			   </div>
		   </div>
		   <!--calling isset method-->
		   <?php if(isset($mode)&& ($mode)=="search"){ ?>
		  <?php echo form_open('consumables/indent_reports/get_indent_summary',array('role'=>'form'))   ?>
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-md-offset-2">
					<button type="button" class="btn btn-primary btn-md print  ">
						<span class="glyphicon glyphicon-print"></span> Print
					</button>

					 <a href="#" id="test" onClick="javascript:fnExcelReport();">
            <button type="button" class="btn btn-primary btn-md excel">
                <i class="fa fa-file-excel-o"ara-hidden="true"></i> Export to excel</button></a></br>
				</div>
			</div>
		</div>
		</br>
		<!--filters for Add Service Issues view form --->
		<!--when filter is clicked this form will load --->
		 <div class="container">
		 <div class="col-md-offset-2">
					<table class="table table-bordered table-striped" id="table-sort">
						<thead>
							<th> #</th>
							<th>Item Type</th>
							<th>Item Name</th>
							<th>Quantity Indented</th>
							<th>Quantity Approved</th>
							<th>Quantity Issued</th>
						</thead>
						<tbody>
							<?php
							$total_quantity=0;
							$approved=0;
							$issued=0;
				$i=1;
				foreach($search_indent_summary as $indent){?>

					<tr>
					<td><?php echo $i++; $sub_url="consumables/indent_reports/get_indent_detailed/";?></td>


						<td><a href="<?php echo base_url().$sub_url."$from_date/$to_date/$from_party/$to_party/0/$indent->item_type_id/$indent->item_id";?>"><?php echo $indent->item_type;?></td>
						<td><a href="<?php echo base_url().$sub_url."$from_date/$to_date/$from_party/$to_party/0/$indent->item_type_id/$indent->item_id";?>"><?php echo $indent->item_name;?></td>
						<td><a href="<?php echo base_url().$sub_url."$from_date/$to_date/$from_party/$to_party/Indented/$indent->item_type_id/$indent->item_id";?>"><?php echo $indent->total_quantity;?></td>
						<td><a href="<?php echo base_url().$sub_url."$from_date/$to_date/$from_party/$to_party/Approved/$indent->item_type_id/$indent->item_id";?>"><?php echo $indent->approved;	?></td>
						<td><a href="<?php echo base_url().$sub_url."$from_date/$to_date/$from_party/$to_party/Issued/$indent->item_type_id/$indent->item_id";?>"><?php echo $indent->issued;?></td>
					</tr>
					<?php
	                $total_quantity+=$indent->total_quantity;
					$approved+=$indent->approved;
					$issued+=$indent->issued;
					}
					?>
					<tfoot>
					<th>Total </th>
					<th> </th>
					<th> </th>


					<th class="text-left" ><?php echo $total_quantity;?></th>
					<th class="text-left" ><?php echo $approved;?></th>
					<th class="text-left" ><?php echo $issued;?></th>

					</tfoot>
					<?php echo form_close(); ?>
				<!--ending of isset method-->
				<?php
				}
				?>
				</tbody>
			</table>
			</div>
			</div>
	</div>
