<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript"
 src="<?php echo base_url();?>assets/js/jquery.mousewheel.js"></script>
<script type="text/javascript">
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

		postPresentation();
	});

	function postPresentation()
	{
		//$("#donor_name").val(unescape("<?php echo rawurlencode($this->input->post('donor_name'))?>"));
	}
	function clearall()
	{
		 document.getElementById("donor_id").value="";
         document.getElementById("donor_name").value="";
		 document.getElementById("donor_email").value="";
		 document.getElementById("donor_mobile").value="";

	}
</script>
<style>
p{
	display:table-row;
}
label{
	display:table-cell;
	padding-left:10px;
	padding-right:5px;
}
select{
	display:table-cell;
}
</style>
<div class="col-md-10 col-sm-9">
	<?php
	if(isset($msg)) { ?>
		<div class="alert alert-info">
			<b><?php echo $msg; ?></b>
		</div>
	<?php
	}
	?>
		<?php
		$from_date=0;$to_date=0;
		if($this->input->post('from_date')) $from_date=date("Y-m-d",strtotime($this->input->post('from_date'))); else $from_date = date("Y-m-d");
		if($this->input->post('to_date')) $to_date=date("Y-m-d",strtotime($this->input->post('to_date'))); else $to_date = date("Y-m-d");
		?>
		<div class="row" style="border:1px solid #dddddd;">
			<div class="panel-default">
				<div class="panel-heading">
					<h4>Search For Donor at
					<?php
						$place=$this->session->userdata('place');
						echo $place['name'];
					?>
					</h4>
				</div>
			</div>
			<div class="panel-body" style="color:black;">

				<?php echo form_open("bloodbank/register/repeat_donor",array('class'=>'form-custom')); ?>
				<p>

					<label for="donor_id">  Donor ID </label> <input class="number" class="form-control"  type="text" value="<?php echo htmlentities($this->input->post('donor_id')); ?>" name="donor_id" id="donor_id" />
				    <label for="donor_name">Donor Name </label> <input class="name" class="form-control"  type="text" name="donor_name" id="donor_name" value="<?php echo htmlentities($this->input->post('donor_name'))?>"  />
					<label for="donor_email">Email </label> <input class="form-control" type="email"  value="<?php echo htmlentities($this->input->post('donor_email')); ?>" name="donor_email" id="donor_email" />

				</p>

				<p>
		            <label for="donor_mobile">Mobile Number </label> <input class="number" class="form-control"  type="text" value="<?php echo htmlentities($this->input->post('donor_mobile')); ?>" name="donor_mobile" id="donor_mobile"/>
					<label for="blood_group">Blood Group </label>
					<select name="blood_group" id="blood_group" class="form-control" >
						<option value="" disabled selected>Blood Group</option>
						<option value="A+" <?php if($this->input->post('blood_group') && $this->input->post('blood_group') == "A+" ) echo "selected"; ?>>A+</option>
						<option value="B+" <?php if($this->input->post('blood_group') && $this->input->post('blood_group') == "B+" ) echo "selected"; ?>>B+</option>
						<option value="O+" <?php if($this->input->post('blood_group') && $this->input->post('blood_group') == "O+" ) echo "selected"; ?>>O+</option>
						<option value="AB+" <?php if($this->input->post('blood_group') && $this->input->post('blood_group') == "AB+" ) echo "selected"; ?>>AB+</option>
						<option value="A-" <?php if($this->input->post('blood_group') && $this->input->post('blood_group') == "A-" ) echo "selected"; ?>>A-</option>
						<option value="B-" <?php if($this->input->post('blood_group') && $this->input->post('blood_group') == "B-" ) echo "selected"; ?>>B-</option>
						<option value="O-" <?php if($this->input->post('blood_group') && $this->input->post('blood_group') == "O-" ) echo "selected"; ?>>O-</option>
						<option value="AB-" <?php if($this->input->post('blood_group') && $this->input->post('blood_group') == "AB-" ) echo "selected"; ?>>AB-</option>
					</select>
					<label for="gender">Gender</label>
					<span >
						<input type="radio" name="gender" id="male" value="m" <?php if($this->input->post('gender') && $this->input->post('gender') == "m" ) echo "checked"; ?> /><label for="male" style="display:inline !important;">Male</label>&nbsp;&nbsp;
						<input type="radio" name="gender" id="female" value="f" <?php if($this->input->post('gender') && $this->input->post('gender') == "f" ) echo "checked"; ?> /><label for="female" style="display:inline !important;">Female</label>
					</span>
				</p>
			</div>

			<div class=" panel-default" style="width:100%;">
				<div class="panel-heading">
					<input class="btn btn-sm btn-primary" type="submit" value="Search" name="search" />
					<input class="btn btn-sm btn-primary" type="reset" value="Reset" onClick="clearall();"/>
				</div>
			</div>
			</form>
		</div>
		<br />
		<?php if(isset($donors) && count($donors)>0){?>

		<table class="table table-bordered table-striped" id="table-sort">
		<thead>
		<tr>
			<td style="text-align:center">Name</th>
			<td style="text-align:center">Spouse</th>
			<td style="text-align:center">Occupation</th>
			<td style="text-align:center">DOB</th>
			<td style="text-align:center">Sex</th>
			<td style="text-align:center">Blood Group</th>
			<td style="text-align:center">Mobile</th>
			<td style="text-align:center">Email</th>
			<td style="text-align:center">Address</th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach($donors as $s){
		?>
		<tr>
                    <td><a href="<?php echo base_url()."bloodbank/register/repeat_donor/$s->donor_id";?>"><?php echo $s->name;?></a></td>
			<td class="text-right"><a href="<?php echo base_url()."bloodbank/register/repeat_donor/$s->donor_id";?>"><?php echo $s->parent_spouse;?></a></td>
			<td class="text-right"><a href="<?php echo base_url()."bloodbank/register/repeat_donor/$s->donor_id";?>"><?php echo $s->occupation;?></td>
			<td class="text-right"><a href="<?php echo base_url()."bloodbank/register/repeat_donor/$s->donor_id";?>"><?php echo $s->dob;?></td>
			<td class="text-right"><a href="<?php echo base_url()."bloodbank/register/repeat_donor/$s->donor_id";?>"><?php echo $s->sex;?></td>
			<td class="text-right"><a href="<?php echo base_url()."bloodbank/register/repeat_donor/$s->donor_id";?>"><?php echo $s->blood_group;?></td>
			<td class="text-right"><a href="<?php echo base_url()."bloodbank/register/repeat_donor/$s->donor_id";?>"><?php echo $s->phone;?></td>
			<td class="text-right"><a href="<?php echo base_url()."bloodbank/register/repeat_donor/$s->donor_id";?>"><?php echo $s->email;?></td>
			<td class="text-right"><a href="<?php echo base_url()."bloodbank/register/repeat_donor/$s->donor_id";?>"><?php echo $s->address;?></td>
		</tr>
		<?php
		}
		?>
		</tbody>
		</table>
		<?php } else if($_SERVER['REQUEST_METHOD'] == "POST"){ ?>
		No donor registrations found for the given criteria.
		<?php } ?>
	</div>
</div>
