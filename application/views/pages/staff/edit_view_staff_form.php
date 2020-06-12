<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>


<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >

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

//create function for  for Excel report
  function fnExcelReport() {
      //created a variable named tab_text where 
      
    var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">';
    //row and columns arrangements
    tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>';
    tab_text = tab_text + '<x:Name>Excel Sheet</x:Name>';

    tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>';
    tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>';

    tab_text = tab_text + "<table border='100px'>";
    //id is given which calls the html table
    tab_text = tab_text + $('#table-excel').html();
    tab_text = tab_text + '</table></body></html>';
    var data_type = 'data:application/vnd.ms-excel';
    $('#test').attr('href', data_type + ', ' + encodeURIComponent(tab_text));
    //downloaded excel sheet name is given here
    $('#test').attr('download', 'staff_detailed.xls');

  }

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
		<?php echo form_open("staff/edit/view_staff",array('role'=>'form','class'=>'form-custom')); ?>
					
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
					
					<select name="staff_category_id" id="staff_category" class="form-control">
					<option value="">Staff Category</option>
					<?php 
					foreach($staff_category as $staff_cat){
						echo "<option value='".$staff_cat.staff_cat_id."'";
						if($this->input->post('staff_category_id') && $this->input->post('staff_category_id') == $staff_cat.staff_category_id) echo "selected ";
						echo ">".$staff_cat->staff_category."</option>";
					}
					?>
					</select>					
					
					<select name="gender" id="gender" class="form-control">
						<option value="">Gender</option>
						<option value ="M">Male</option>
						<option value ="F">Female</option>
					</select>
					
					<select name="mci_flag" id="mci_flag" class="form-control">
						<option value="">MCI</option>
						<option value ="1">Yes</option>
						<option value ="0">No</option>
					</select>
					
					<input name="search" value="true" type="hidden"></input>
					<input class="btn btn-sm btn-primary" type="submit" value="search"/>
		</form>
		</div>
	<br />
	
	
<?php if(isset($mode)&& $mode=="select" || $this->input->post('update')){?>
	<center>	<h3>View Staff </h3></center><br>
	<?php 
    echo validation_errors();
	echo form_open('staff/edit/view_staff',array('class'=>'form-horizontal','role'=>'form','id'=>'staff')); 
	?>
	 <div class="col-md-2 col-xs-2 pull-right">
		
					
							   
							<img  src=" <?php echo base_url().  "assets/images/staff/".$view_staff[0]->staff_id.".jpg";?> ">
						
														
	</div>
<div class="col-md-6 col-md-offset-3 pull-left">
	<?php if(isset($msg)){ ?>
		<div class="alert alert-info"><?php echo $msg;?></div>
	<?php
	}
	?>
	

	<div class="form-group">
		<input type='hidden' name='staff_id' value='<?php echo $view_staff[0]->staff_id; ?>' />
		<div class="col-md-3">
			<label for="first_name" class="control-label">First Name</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="First Name" id="first_name" name="first_name" required 
			value='<?php echo $view_staff[0]->first_name; ?>' readonly/>
		</div>
	</div>
    
	<div class="form-group">
		<div class="col-md-3">
			<label for="last_name" class="control-label">Last Name</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Last Name" id="last_name" name="last_name" 
			value='<?php echo $view_staff[0]->last_name; ?>'readonly/>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-3">
			<label class="control-label">Gender</label>
		</div>
		<?php $gender = $view_staff[0]->gender; ?>
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
			value=<?php echo date("d-M-Y",strtotime($view_staff[0]->date_of_birth)); ?> readonly/>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-3">
			<label for="department" class="control-label">Department</label>
		</div>
		<div class="col-md-6">
			<select class="form-control" id="department" name="department" readonly>
				<option value=""> </option>
				<?php foreach($department as $d){
				echo "<option value='$d->department_id'";
				if($view_staff[0]->department_id == $d->department_id)
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
			<select class="form-control" id="unit" name="unit" readonly>
				<option value=""> </option>
				<?php foreach($unit as $u){
					echo "<option value='$u->unit_id' class='$u->department_id'";
					if($view_staff[0]->unit_id == $u->unit_id)
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
			<select class="form-control" id="area" name="area" readonly>
				<option value=""> </option>
				<?php foreach($area as $a){
					echo "<option value='$a->area_id' class='$a->department_id'";
					if($view_staff[0]->area_id == $a->area_id)
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
			<select class="form-control" id="staff_role" name="staff_role" readonly >
				<option value="">Staff Role</option>
				<?php foreach($staff_role as $sr){
				echo "<option value='$sr->staff_role_id'";
				if($view_staff[0]->staff_role_id == $sr->staff_role_id)
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
			<select class="form-control" id="staff_category" name="staff_category" readonly>
				<option value="">Staff Category</option>
				<?php foreach($staff_category as $sc){
				echo "<option value='$sc->staff_category_id' ";
				
				if($view_staff[0]->staff_category_id == $sc->staff_category_id)
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
			value='<?php echo $view_staff[0]->designation; ?>'
			  readonly/>
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-md-3">
			<label for="staff_type" class="control-label">Staff Type</label>
		</div>
		<div class="col-md-6">
			<select class="form-control" id="staff_type" name="staff_type" readonly>
				<option value="">Staff Type</option>
				<option value="On Rolls">On Rolls</option>
				<option value="Contract">Contract</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-3">
			<label for="email" class="control-label">Email</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Email" id="email" name="email" 
			value='<?php echo $view_staff[0]->email; ?>'readonly/>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-3">
			<label for="phone" class="control-label">Phone</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Phone" id="phone" name="phone" 
			value='<?php echo $view_staff[0]->phone; ?>'readonly/>
		</div>
	</div>

	<div class="form-group">
		<div class="col-md-3">
			<label for="specialisation" class="control-label">Specialisation</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Specialisation" id="specialisation" name="specialisation" 
			value='<?php echo $view_staff[0]->specialisation; ?>' readonly/>
		</div>
	</div>		
	
	<div class="form-group">
		<div class="col-md-3">
			<label for="research_area" class="control-label">Research Areas</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Research Areas" id="research_area" name="research_area" 
			value='<?php echo $view_staff[0]->research_area ?>' readonly/>
		</div>
	</div>		
	
	<div class="form-group">
		<div class="col-md-3">
			<label for="research" class="control-label">Research</label>
		</div>
		<div class="col-md-6">
			<input type="text" class="form-control" placeholder="Research" id="research" name="research" 
			value='<?php echo $view_staff[0]->research ?>' readonly/>
		</div>
	</div>		
	
		
	</form>
	</div>
	
	<?php } 
	else{ ?>
	<div class="col-md-10 col-md-offset-2">
	<h3 class="col-md-12 ">List of Staff</h3>
	<div class="col-md-12 offset-3 ">
	</div>	
		<h3><?php if(isset($msg)) echo $msg;?></h3>	
		<button type="button" class="btn btn-default btn-md print">
		  <span class="glyphicon glyphicon-print"></span> Print
		</button>
                <!--created button which converts html table to Excel sheet-->
        <a href="#" id="test" onClick="javascript:fnExcelReport();">
            <button type="button" class="btn btn-default btn-md excel">
            <i class="fa fa-file-excel-o"ara-hidden="true"></i>Export to Excel</button>
        </a>
		<table class="table table-bordered table-striped" id="table-sort">
	<thead>
		<th style="text-align:center">S.no</th>
		
		<th style="text-align:center">Department</th>
		<th style="text-align:center">Designation</th>
		<th style="text-align:center">Staff category</th>
		<th style="text-align:center">Name</th>
		<th style="text-align:center">Gender</th>
                <th style="text-align:center">DOB</th>
                <th style="text-align:center">Phone</th>
                <th style="text-align:center">Email</th>                		
		<th style="text-align:center">Status</th>
	</thead>
	<tbody>
	<?php 
	$i=1;
        if(isset($view_staff) && $view_staff){
	foreach($view_staff as $a){ ?>
	<tr onclick="$('#select_staff_form_<?php echo $a->staff_id;?>').submit();" >
		<td>	
			<?php echo form_open('staff/edit/view_staff',array('id'=>'select_staff_form_'.$a->staff_id,'role'=>'form')); ?>
			<?php echo $i++; ?>
		</td>
		
		<td><?php echo $a->department;?></td>
		<td><?php echo $a->designation;?> </td>
		<td><?php echo $a->staff_category;?> </td>
		<td><?php echo  $a->first_name." ".$a->last_name;  ?></td>
		<td> <?php echo $a->gender;?>
		<input type="hidden" value="<?php echo $a->staff_id; ?>" name="staff_id" />
		<input type="hidden" value="select" name="select" />
		</td>
		<td><?php echo $a->date_of_birth; ?></td>
                <td><?php echo $a->phone; ?></td>
                <td><?php echo $a->email; ?></td>
		<td><?php echo $a->hr_transaction_type;?></td>
		
	</tr>
	<?php } ?>
	</tbody>
	</table>
	
	

	</div></div>
	
	<div class="col-md-10 col-md-offset-2">
	<h3 class="col-md-12 ">HR Transactions</h3>
	<table class="table table-bordered table-striped">
	<thead>
		<th style="text-align:center">S.no</th>
		<th style="text-align:center">Hr Transcation</th>
		<th style="text-align:center">Date</th>
	</thead>
	<tbody>
	   
	   <tr>
	   	<?php $i = 1;
	   	foreach($transaction as $trans) {?>
	   		<td><?php echo $i;?></td>
	   		<td><?php echo $trans->hr_transaction_type;?></td>
	   		<td><?php echo $trans->hr_transaction_date;?></td>
	   	<?php $i++;} ?>
	   </tr>
	   
	</tbody>
	</table>
        
        <table class="sr-only" id="table-excel">
	<thead>
		<th style="text-align:center">S.no</th>
		
		<th style="text-align:center">Department</th>
		<th style="text-align:center">Designation</th>
		<th style="text-align:center">Staff category</th>
		<th style="text-align:center">Name</th>
		<th style="text-align:center">Gender</th>
                <th style="text-align:center">DOB</th>
                <th style="text-align:center">Phone</th>
                <th style="text-align:center">Email</th>                		
		<th style="text-align:center">Status</th>
	</thead>
	<tbody>
	<?php 
	$i=1;
	foreach($view_staff as $a){ ?>
	<tr onclick="$('#select_staff_form_<?php echo $a->staff_id;?>').submit();" >
		<td>	
			
			<?php echo $i++; ?>
		</td>
		
		<td><?php echo $a->department;?></td>
		<td><?php echo $a->designation;?> </td>
		<td><?php echo $a->staff_category;?> </td>
		<td><?php echo  $a->first_name." ".$a->last_name;  ?></td>
		<td> <?php echo $a->gender;?></td>
		<td><?php echo $a->date_of_birth; ?></td>
                <td><?php echo $a->phone; ?></td>
                <td><?php echo $a->email; ?></td>
		<td><?php echo $a->hr_transaction_type;?></td>
		<td>
		<?php echo $a->phone;?>
		
			
		
	</tr>
        <?php } } } ?>
	</tbody>
	</table>
	
	