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
	<script type="text/javascript">
$(function(){

	var staff_category = document.getElementById('staff_category'),
    	designation= document.getElementById('designation');
	
	staff_category.onchange= function () { 
  		designation.value = staff_category.options[staff_category.selectedIndex].text;
	};
});
</script>


	<script type="text/javascript">
	$(function(){
		$("#date_of_birth").Zebra_DatePicker();
		$("#department").on('change',function(){
			var department_id=$(this).val();
			$("#unit option,#area option").hide();
			$("#unit option[class="+department_id+"],#area option[class="+department_id+"]").show();
		});
	});
	</script>
	<div class="col-md-10 col-md-offset-2">
		<h4>Search Staff</h4>	
		<?php echo form_open("staff/edit/staff",array('role'=>'form','class'=>'form-custom')); ?>					
					<select name="department_id" id="department" class="form-control">
					<option value="">Department</option>
					<?php 
					foreach($department as $dept){
						echo "<option value='".$dept->department_id."'";
						if($this->input->post('department_id') && $this->input->post('department_id') == $dept->department_id) echo " selected ";
						echo ">".$dept->department."</option>";
					}
					?>
					</select>
					<select name="area_id" id="area" class="form-control">
					<option value="">Area</option>
					<?php 
					foreach($area as $ar){
						echo "<option value='".$ar->area_id."'";
						if($this->input->post('area_id') && $this->input->post('area_id') == $ar->area_id) echo " selected ";
						echo ">".$ar->area_name."</option>";
					}
					?>
					</select>					
					<select name="designation" id="designation" class="form-control">
					<option value="">Designation</option>
					<?php 					
					foreach($designation as $des){
						echo "<option value='".$des->designation."'";
						if($this->input->post('designation') && $this->input->post('designation') == $des->designation) echo " selected ";
						echo ">".$des->designation."</option>";
					}
					?>
					</select>					
					<select name="staff_category" id="staff_category" class="form-control">
					<option value="">Staff Category</option>
					<?php 
					foreach($staff_category as $staff_cat){
						echo "<option value='".$staff_cat->staff_category_id."'";
						if($this->input->post('staff_category') && $this->input->post('staff_category') == $staff_cat->staff_category_id) echo "selected ";
						echo ">".$staff_cat->staff_category."</option>";
					}
					?>
					</select>										
					<select name="gender" id="gender" class="form-control">
						<option value="">Gender</option>
						<option value ="M" <?php if($this->input->post('gender') && $this->input->post('gender')=='M') echo "selected ";?>>Male</option>
						<option value ="F" <?php if($this->input->post('gender') && $this->input->post('gender')=='F') echo "selected ";?>>Female</option>
					</select>					
					<select name="mci_flag" id="mci_flag" class="form-control">
						<option value="">MCI</option>
						<option value ="1" <?php if($this->input->post('mci_flag') && $this->input->post('mci_flag')==1) echo "selected ";?>>Yes</option>
						<option value ="0" <?php if($this->input->post('mci_flag') && $this->input->post('mci_flag')==0) echo "selected ";?>>No</option>
					</select>					
					<input name="search_staff" value="true" type="hidden"></input>
					<input class="btn btn-sm btn-primary" type="submit" value="search"/>
		</form>
		</div>
	<br />
<?php if(isset($mode)&& $mode=="select" || $this->input->post('update')){?>
	<center>	<h3>Edit  Staff </h3></center><br>
	<?php 
    echo validation_errors();
	echo form_open('staff/edit/staff',array('class'=>'form-horizontal','role'=>'form','id'=>'edit_staff')); 
	?>
	 <div class="col-md-2 col-xs-2 pull-right">
		
							
							
							<img  src=" <?php echo base_url().  "assets/images/staff/".$staff[0]->staff_id.".jpg";?> ">
						
													
	</div>
<div class="col-md-6 col-md-offset-3 pull-left">
	<?php if(isset($msg)){ ?>
		<div class="alert alert-info"><?php echo $msg;?></div>
	<?php
	}
	?>
	

<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">General</a></li>
    <li role="presentation"><a href="#bank" aria-controls="bank" role="tab" data-toggle="tab">Bank</a></li>
  </ul>
  
  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
	<div class="form-group">
		<input type='hidden' name='staff_id' value='<?php echo $staff[0]->staff_id; ?>' />
		<div class="col-md-3">
			<label for="first_name" class="control-label">First Name</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="First Name" id="first_name" name="first_name" required 
			value='<?php echo $staff[0]->first_name; ?>'/>
		</div>
	</div>
    
	<div class="form-group">
		<div class="col-md-3">
			<label for="last_name" class="control-label">Last Name</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Last Name" id="last_name" name="last_name" 
			value='<?php echo $staff[0]->last_name; ?>'/>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-3">
			<label class="control-label">Gender</label>
		</div>
		<?php $gender = $staff[0]->gender; ?>
		<div class="col-md-6">
			<label class="control-label">
				<input type="radio" name="gender" value="M" 
				<?php 
				if($gender == 'M')
				{
					echo 'checked';
				}?> 
			/>Male
			</label>
			<label class="control-label">
				<input type="radio" name="gender" value="F" 
				<?php 
				if($gender == 'F')
				{
					echo 'checked';
				}?> 
				/>Female
			</label>
			<label class="control-label">
				<input type="radio" name="gender" value="O" 
				<?php 
				if($gender == '')
				{
					echo 'checked';
				}?> 
				/>Other
			</label>
		</div>
	</div>	
	<div class="form-group">
		<div class="col-md-3">
			<label for="date_of_birth" class="control-label" > Date of Birth</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control date" placeholder="Date of Birth" id="date_of_birth" name="date_of_birth" 
			value=<?php echo date("d-M-Y",strtotime($staff[0]->date_of_birth)); ?> />
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-3">
			<label for="department" class="control-label">Department</label>
		</div>
		<div class="col-md-6">
			<select class="form-control" id="department" name="department" >
				<option value=""> </option>
				<?php foreach($department as $d){
				echo "<option value='$d->department_id'";
				if($staff[0]->department_id == $d->department_id)
				{
					echo ' selected';
				}
				echo ">$d->department";
				
				echo "</option>";
				}?>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-3">	
			<label for="unit" class="control-label">Unit</label>
		</div>
		<div class="col-md-6">
			<select class="form-control" id="unit" name="unit">
				<option value=""> </option>
				<?php foreach($unit as $u){
					echo "<option value='$u->unit_id' class='$u->department_id'";
					if($staff[0]->unit_id == $u->unit_id)
					{
						echo ' selected';
					}
					echo ">$u->unit_name</option>";
				}?>
			</select>
		</div>			
	</div>
	<div class="form-group">
		<div class="col-md-3">
			<label for="area" class="control-label">Area</label>
			<?php //var_dump($area); ?>
		</div>
		<div class="col-md-6">
			<select class="form-control" id="area" name="area">
				<option value=""> </option>
				<?php foreach($area as $a){
					echo "<option value='$a->area_id' class='$a->department_id'";
					if($staff[0]->area_id == $a->area_id)
					{
						echo ' selected';
					}
					echo ">$a->area_name</option>";
				}?>
			</select>
		</div>	
	</div>
	<div class="form-group">
		<div class="col-md-3">
			<label for="staff_role" class="control-label">Staff Role</label>
		</div>
		<div class="col-md-6">
			<select class="form-control" id="staff_role" name="staff_role" >
				<option value="">Staff Role</option>
				<?php foreach($staff_role as $sr){
				echo "<option value='$sr->staff_role_id'";
				if($staff[0]->staff_role_id == $sr->staff_role_id)
				{
					echo ' selected';
				}
				echo ">$sr->staff_role</option>";
				}?>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-3">
			<label for="staff_category" class="control-label">Staff Category</label>
		</div>
		<div class="col-md-6">
			<select class="form-control" id="staff_category" name="staff_category" >
				<option value="">Staff Category</option>
				<?php foreach($staff_category as $sc){
				echo "<option value='$sc->staff_category_id' ";
				
				if($staff[0]->staff_category_id == $sc->staff_category_id)
				{
					echo 'selected';
				}
				echo ">$sc->staff_category</option>";
				}?>
			</select>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-3">
			<label for="designation" class="control-label">Designation</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Designation" id="designation" name="designation"
			value='<?php echo $staff[0]->designation; ?>'
			  />
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-3">
			<label for="staff_type" class="control-label">Staff Type</label>
		</div>
		<div class="col-md-6">
			<select class="form-control" id="staff_type" name="staff_type">
				<option value="">Staff Type</option>
				<option value="On Rolls">On Rolls</option>
				<option value="Contract">Contract</option>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-3">
			<label for="staff_type" class="control-label">MCI</label>
		</div>
		<div class="col-md-6">
			<input type ='radio' id="mci_flag" name="mci_flag" value ='1' <?php if($staff[0]->mci_flag== 1) echo "checked"; ?> >Yes</input>
			<input type ='radio' id="mci_flag" name="mci_flag" value ='0' <?php if($staff[0]->mci_flag== 0) echo "checked"; ?> >No</input>
		</div>
	</div>	
	
	
	<div class="form-group">
		<div class="col-md-3">
			<label for="email" class="control-label">Email</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Email" id="email" name="email" 
			value='<?php echo $staff[0]->email; ?>'/>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-3">
			<label for="phone" class="control-label">Phone</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Phone" id="phone" name="phone" 
			value='<?php echo $staff[0]->phone; ?>'/>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-3">
			<label for="specialisation" class="control-label">Specialisation</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Specialisation" id="specialisation" name="specialisation" 
			value='<?php echo $staff[0]->specialisation; ?>'/>
		</div>
	</div>		
	
	<div class="form-group">
		<div class="col-md-3">
			<label for="research_area" class="control-label">Research Areas</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Research Areas" id="research_area" name="research_area" 
			value='<?php echo $staff[0]->research_area ?>'/>
		</div>
	</div>		
	
	<div class="form-group">
		<div class="col-md-3">
			<label for="research" class="control-label">Research</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Research" id="research" name="research" 
			value='<?php echo $staff[0]->research ?>'/>
		</div>
	</div>		
	
		<div class="col-md-12">
						<div class="form-group well well-sm">
						<div class="row">
							<div class="col-md-12">
							<p class="col-md-6" id="results-text">Captured image will appear here..</p>
							<p class="col-md-6">Camera View</p>
							<div id="results" class="col-md-6 results"></div>
							
							<div id="my_camera" class="col-md-6"></div>
							</div>
						</div>
							<div class="col-md-offset-6" style="position:relative;top:5px">
							 
							<!-- A button for taking snaps -->
								<div id="button">
									<input id="staff_picture" type="hidden" class="sr-only" name="staff_picture" value="staff_id"/>
									<button class="btn btn-default btn-sm" type="button" onclick="save_photo()"><i class="fa fa-camera"></i> Take Picture</button>
								</div>
							</div>
							<!-- First, include the Webcam.js JavaScript Library -->
							<script type="text/javascript" src="<?php echo base_url();?>assets/js/webcam.min.js"></script>
							
							<!-- Configure a few settings and attach camera -->
							<script language="JavaScript">
								Webcam.set({
									width: 320,
									height: 240,
									// device capture size
									dest_width: 320,
									dest_height: 240,
									// final cropped size
									crop_width: 200,
									crop_height: 240,											
									image_format: 'jpeg',
									jpeg_quality: 90
								});
								Webcam.attach( '#my_camera' );
							</script>
							
							<!-- Code to handle taking the snapshot and displaying it locally -->
							<script language="JavaScript">
								
								function save_photo() {
									// actually snap photo (from preview freeze) and display it
									Webcam.snap( function(data_uri) {
										// display results in page
										document.getElementById('results').innerHTML = 
											'<img src="'+data_uri+'"/>';
										document.getElementById('results-text').innerHTML = 
											'Captured Image';
										//Store image data in input field.
										var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
										
										document.getElementById('staff_picture').value = raw_image_data;
										
										// swap buttons back
										document.getElementById('pre_take_buttons').style.display = '';
										document.getElementById('post_take_buttons').style.display = 'none';
									} );
								}
							</script>
							
						</div>
		</div>	
	</div>
    <div role="tabpanel" class="tab-pane" id="bank">
		
		<div class="form-group">
			<div class="col-md-3">
				<label for="account_name" class="control-label">Account Name</label>
			</div>
			<div class="col-md-6">
				<input type="text" class="form-control" placeholder="Bank Account Name" id="account_name" name="account_name" value="<?php echo $staff[0]->account_name ?>" />
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-3">
				<label for="bank" class="control-label">Bank Name</label>
			</div>
			<div class="col-md-6">
				<input type="text" class="form-control" placeholder="Bank" id="bank" name="bank" value="<?php echo $staff[0]->bank ?>" />
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-3">
				<label for="bank_branch" class="control-label">Branch</label>
			</div>
			<div class="col-md-6">
				<input type="text" class="form-control" placeholder="Branch" id="bank_branch" name="bank_branch" value="<?php echo $staff[0]->bank_branch ?>" />
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-3">
				<label for="account_number" class="control-label">Account Number</label>
			</div>
			<div class="col-md-6">
				<input type="text" class="form-control" placeholder="Account Number" id="account_number" name="account_number" value="<?php echo $staff[0]->account_number ?>" />
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-3">
				<label for="ifsc_code" class="control-label">IFSC Code</label>
			</div>
			<div class="col-md-6">
				<input type="text" class="form-control" placeholder="IFSC Code" id="ifsc_code" name="ifsc_code" value="<?php echo $staff[0]->ifsc_code ?>" />
			</div>
		</div>
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
    <?php 
    if(isset($staff) && $staff){ ?>
	<div class="col-md-10 col-md-offset-2">
	<h3 class="col-md-12 ">List of Staff</h3>
	<div class="col-md-12 offset-3 ">
	</div>	
		<h3><?php if(isset($msg)) echo $msg;?></h3>	
		<button type="button" class="btn btn-default btn-md print">
		  <span class="glyphicon glyphicon-print"></span> Print
		</button>
		<table class="table table-bordered table-striped" id="table-sort">
<thead>
		<th style="text-align:center">S.no</th>
		
		<th style="text-align:center">Department</th>
		<th style="text-align:center">Area</th>
		<th style="text-align:center">Designation</th>
		<th style="text-align:center">Staff category</th>
		<th style="text-align:center">Name</th>
		<th style="text-align:center">Gender</th>
		<th style="text-align:center">Specialisation</th>
		<th style="text-align:center">DOB</th>
		<th style="text-align:center">Phone</th>
		<th style="text-align:center">Email</th>                		
		<th style="text-align:center">Status</th>
		<th style="text-align:center">MCI</th>
	</thead>
	<tbody>
	<?php 
	$i=1;
	
	foreach($staff as $a){ ?>
	<tr onclick="$('#select_staff_form_<?php echo $a->staff_id;?>').submit();" >
		<td>	
			<?php echo form_open('staff/edit/staff',array('id'=>'select_staff_form_'.$a->staff_id,'role'=>'form')); ?>
			<?php echo $i++; ?>
		</td>
		
		<td><?php echo $a->department;?></td>
		<td><?php echo $a->area_name;?></td>
		<td><?php echo $a->designation;?> </td>
		<td><?php echo $a->staff_category;?> </td>
		<td><?php echo  $a->first_name." ".$a->last_name;  ?></td>
		<td> <?php echo $a->gender;?>
		<td><?php echo $a->specialisation; ?> </td>
		<input type="hidden" value="<?php echo $a->staff_id; ?>" name="staff_id" />
		<input type="hidden" value="select" name="select" />
		</td>
		<td><?php echo date("d-M-Y",strtotime($a->date_of_birth)); ?></td>
                <td><?php echo $a->phone; ?></td>
                <td><?php echo $a->email; ?></td>
		<td><?php echo $a->hr_transaction_type;?></form></td>
		<td><?php echo ($a->mci_flag==1 ? "Yes" : "No"); ?> </td>
	</tr>
	<?php } } ?>
	</tbody>
	</table>
	
	<?php } ?>

	</div></div>