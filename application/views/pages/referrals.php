<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.chained.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/selectize.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.selectize.js"></script>

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
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
<script type="text/javascript">
function doPost(page_no){
	var page_no_hidden = document.getElementById("page_no");
  	page_no_hidden.value=page_no;
        $('#appointment').submit();
   }
function onchange_page_dropdown(dropdownobj){
   doPost(dropdownobj.value);    
}
</script>
<script type="text/javascript">
function onchange_state_dropdown(dropdownobj) {       	
		const stateID = dropdownobj.value;
		populateDistricts(stateID);		
	}
	
	function populateDistricts(stateID) {
		var optionsHtml = getDistrictOptionsState(stateID);
		$("#district").html(optionsHtml);
		
	}
function getDistrictOptionsState(stateID) {
		var all_districts = JSON.parse('<?php echo json_encode($all_districts); ?>'); 
		var selected_districts = all_districts.filter(all_districts => all_districts.state_id == stateID);
		let optionsHtml = buildEmptyOption("District");
		if(selected_districts.length > 0) {
			optionsHtml += selected_districts.map(selected_districts => {
					return `	<option value="${selected_districts.district_id}">
							${selected_districts.district}
						</option>`;
		});
			
		}
		return optionsHtml;
	}
	function buildEmptyOption(optionName = "Select") {
		return `<option value="" selected>
					${optionName}
			</option>`;

	}	
function escapeSpecialChars(str) {
    return str.replace(/\n/g, "\\n").replace(/\r/g, "\\r").replace(/\t/g, "\\t");
}
function initHospitalSelectize(){
	var helpline_hospitals = JSON.parse(escapeSpecialChars('<?php echo json_encode($helpline_hospitals); ?>'));

	var selectize = $('#hospital_id').selectize({
	    valueField: 'hospital_id',
	    labelField: 'customdata',
	    searchField: ['hospital_short_name', 'place', 'district','state'],
		options: helpline_hospitals,
	    create: false,
	    render: {
	        option: function(item, escape) {
	        	return '<div>' +
	                '<span class="title">' +
	                    '<span class="prescription_drug_selectize_span">' + escape(item.customdata) + '</span>' +
	                '</span>' +
	            '</div>';
	        }
	    },
	    load: function(query, callback) {
	      if (!query.length) return callback();
		},
	});
	var selected_hospital = '<?php echo $this->input->post('hospital'); ?>';
	if(selected_hospital){
		selectize[0].selectize.setValue(selected_hospital);
	}
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

<style type="text/css">
	.selectize-control.repositories .selectize-dropdown > div {
border-bottom: 1px solid rgba(0,0,0,0.05);
}
.selectize-control {
display: inline-grid;
} 
</style>

	<?php 
	$from_date=0;$to_date=0;
	if($this->input->post('from_date')) $from_date=date("Y-m-d",strtotime($this->input->post('from_date'))); else $from_date = date("Y-m-d");
	if($this->input->post('to_date')) $to_date=date("Y-m-d",strtotime($this->input->post('to_date'))); else $to_date = date("Y-m-d");	
	?>
<div class="row">
		<h4>Referrals</h4>	
		<?php echo form_open("reports/referrals",array('role'=>'form','class'=>'form-custom','id'=>'appointment')); ?> 
                        Search by : <select name="dateby" id="dateby" class="form-control">   
                        <option value="Registration" <?php echo ($this->input->post('dateby') == 'Registration') ? 'selected' : ''; ?> >Registration</option> 
                        <option value="Appointment" <?php echo ($this->input->post('dateby') == 'Appointment') ? 'selected' : ''; ?> >Appointment</option>          
                        </select>
                      
			From Date : <input class="form-control" style = "background-color:#EEEEEE" type="text" value="<?php echo date("d-M-Y",strtotime($from_date)); ?>" name="from_date" id="from_date" size="15" />
			To Date : <input class="form-control" type="text" style = "background-color:#EEEEEE" value="<?php echo date("d-M-Y",strtotime($to_date)); ?>" name="to_date" id="to_date" size="15" />
			<select name="department" id="department" class="form-control">
				<option value="">Department</option>
				<?php 
				foreach($all_departments as $dept){
				echo "<option value='".$dept->department_id."'";
				if($this->input->post('department') && $this->input->post('department') == $dept->department_id) echo " selected ";
				echo ">".$dept->department."</option>";
				}
				?>
			</select>
			<select name="unit" id="unit" class="form-control" >
				<option value="">Unit</option>
				<?php 
				foreach($units as $unit){
				echo "<option value='".$unit->unit_id."' class='".$unit->department_id."'";
				if($this->input->post('unit') && $this->input->post('unit') == $unit->unit_id) echo " selected ";
				echo ">".$unit->unit_name."</option>";
				}
				?>
			</select>
			<select name="area" id="area" class="form-control" >
				<option value="">Area</option>
				<?php 
				foreach($areas as $area){
				echo "<option value='".$area->area_id."' class='".$area->department_id."'";
				if($this->input->post('area') && $this->input->post('area') == $area->area_id) echo " selected ";
				echo ">".$area->area_name."</option>";
				}
				?>
			</select>
			<select name="visit_name" id="visit_name" class="form-control" >
				<option value="">Visit Type</option>
				<?php 
				foreach($visit_names as $v){
				echo "<option value='".$v->visit_name_id."'";
				if($this->input->post('visit_name') && $this->input->post('visit_name') == $v->visit_name_id)  echo " selected ";
				echo ">".$v->visit_name."</option>";
				}
				?>
			</select>
			  <select name="hospitalsearchtype" id="hospitalsearchtype" class="form-control">   
			  <option value="HospitalReferredto" <?php echo ($this->input->post('hospitalsearchtype') == 'HospitalReferredto') ? 'selected' : ''; ?> >Hospital Referred to</option> 
                        <option value="HospitalReferredby" <?php echo ($this->input->post('hospitalsearchtype') == 'HospitalReferredby') ? 'selected' : ''; ?> >Hospital Referred by</option>                                  
                        </select>
                        <select id="hospital_id" name="hospital" style="width: 340px;display: inline-grid;" class="" placeholder="       --Enter hospital--                      ">
							<option value="">        --Enter hospital--                       </option>
						
						</select>
						<script>
						
						initHospitalSelectize();
	
						</script>
			<select name="state" id="state"  class="form-control" onchange='onchange_state_dropdown(this)'>
							<option value="" >State</option>
							<?php 
							foreach($all_states as $state){
								echo "<option value='".$state->state_id."'";
								if($this->input->post('state') && $this->input->post('state') == $state	->state_id) echo " selected ";
								echo ">".$state->state."</option>";
							}
							?>
							
			</select>
			<select name="district" id="district" class="form-control" >
					<option value="" >District</option>
			</select>
			<script>
					
					onchange_state_dropdown(document.getElementById("state"));
					var district = "<?php echo $this->input->post('district')?>";
					if(district != ""){
						$("#district").val(district);
					}
					
			</script>
			<select name="visittype" id="visittype" class="form-control">   
                        <option value="OP" <?php echo ($this->input->post('visittype') == 'OP') ? 'selected' : ''; ?> >OP</option> 
                        <option value="IP" <?php echo ($this->input->post('visittype') == 'IP') ? 'selected' : ''; ?> >IP</option>          
                        </select>						   
			<input class="btn btn-sm btn-primary" type="submit" value="Submit" />
		</form>
	<br />

<?php if(isset($report) && count($report)>0)
{ ?>
<div style='padding: 0px 2px;'>

<h5>Report as on <?php echo date("j-M-Y h:i A"); ?></h5>

</div>

	


	<table class="table table-bordered table-striped" id="table-sort">
	<thead>
		<tr>
			<th style="text-align:center" rowspan="2">S.no</th>
		 	<th style="text-align:center" rowspan="2">State</th>
			<th style="text-align:center" rowspan="2">District</th>
			<th style="text-align:center" colspan="5"><?php  if($this->input->post('visittype')){ echo $this->input->post('visittype');} else {echo 'OP';} ?></th>
			</tr>
		<tr>
			<th>Male</th><th>Female</th><th>Others</th><th>Not Specified</th><th>Total</th> 
		</tr>
		
	</thead>
	<tbody>
	<?php 
	$sno=1 ;
	$total_m=0;
	$total_f=0;
	$total_other=0;
	$total_not_specified= 0;
	$total_grand= 0;
	$hospitalsearchtype="HospitalReferredto";
	if($this->input->post('hospitalsearchtype')=="HospitalReferredby"){
			$hospitalsearchtype="HospitalReferredby";
	}
	$date_filter_field="Registration";
	if($this->input->post('dateby') && $this->input->post('dateby')=="Appointment"){
		$date_filter_field="Appointment";
	}
	$visittype='OP'; 
	if($this->input->post('visittype') && $this->input->post('visittype')){
		$visittype=$this->input->post('visittype');
	}
	$department_id=-1; 
	if($this->input->post('department') && $this->input->post('department')){
		$department_id=$this->input->post('department');
	}
	$unit=-1; 
	if($this->input->post('unit') && $this->input->post('unit')){
		$unit=$this->input->post('unit');
	}
	$area=-1; 
	if($this->input->post('area') && $this->input->post('area')){
		$unit=$this->input->post('area');
	}
	$visit_name=-1;
	if($this->input->post('visit_name') && $this->input->post('visit_name')){
		$visit_name=$this->input->post('visit_name');
	}
	$hospital=-1; 
	if($this->input->post('hospital') && $this->input->post('hospital')){
		$hospital=$this->input->post('hospital');
	}
	$district=-1; 
	if($this->input->post('district') && $this->input->post('district')){
		$district=$this->input->post('district');
	}
	$state=-1; 
	if($this->input->post('state') && $this->input->post('state')){
		$state=$this->input->post('state');
	}
	foreach($report as $s){	
	?>
	<tr>
		<td><?php echo $sno;?></td>
		<td><?php echo $s->state;?></td>
		<td><?php echo $s->district;?> </td>
		<?php if ($s->male > 0) { ?>
		<td class="text-right"><a href="<?php echo base_url()."reports/referrals_detail/$date_filter_field/$visittype/$visit_name/$department_id/$unit/$area/M/$hospitalsearchtype/$hospital/$from_date/$to_date/$s->district_id/$s->state_id";?>"><?php echo $s->male;?> </td>		
		<?php } else { ?>
		<td class="text-right"><?php echo $s->male;?> </td>
		<?php }  ?>
		
		<?php if ($s->female > 0) { ?>
		<td class="text-right"><a href="<?php echo base_url()."reports/referrals_detail/$date_filter_field/$visittype/$visit_name/$department_id/$unit/$area/F/$hospitalsearchtype/$hospital/$from_date/$to_date/$s->district_id/$s->state_id";?>"><?php echo $s->female;?> </td>
		<?php } else { ?>
		<td class="text-right"><?php echo $s->female;?> </td>
		<?php }  ?>
		
		<?php if ($s->others > 0) { ?>
		<td class="text-right"><a href="<?php echo base_url()."reports/referrals_detail/$date_filter_field/$visittype/$visit_name/$department_id/$unit/$area/O/$hospitalsearchtype/$hospital/$from_date/$to_date/$s->district_id/$s->state_id";?>"><?php echo $s->others;?> </td>
		<?php } else { ?>
		<td class="text-right"><?php echo $s->others;?> </td>
		<?php }  ?>
		
		<?php if ($s->not_specified > 0) { ?>
		<td class="text-right"><a href="<?php echo base_url()."reports/referrals_detail/$date_filter_field/$visittype/$visit_name/$department_id/$unit/$area/0/$hospitalsearchtype/$hospital/$from_date/$to_date/$s->district_id/$s->state_id";?>"><?php echo $s->not_specified;?> </td>
		<?php } else { ?>
		<td class="text-right"><?php echo $s->not_specified;?> </td>
		<?php }  ?>
		
		<?php if ($s->total > 0) { ?>	
		<td class="text-right"><a href="<?php echo base_url()."reports/referrals_detail/$date_filter_field/$visittype/$visit_name/$department_id/$unit/$area/-1/$hospitalsearchtype/$hospital/$from_date/$to_date/$s->district_id/$s->state_id";?>"><?php echo $s->total;?>
		<?php } else { ?>
		<td class="text-right"><?php echo $s->total;?> </td>
		<?php }  ?>
		 
	</tr>
	<?php 
	$total_m=$total_m + $s->male;
	$total_f=$total_f + $s->female;
	$total_other=$total_other + $s->others;
	$total_not_specified= $total_not_specified + $s->not_specified;
	$total_grand= $total_grand + $s->total;
	$sno++;}	?>
	<tfoot>
	 	<th> </th>
	 	<th> </th>
		<th>Total </th>
		<?php if ($total_m > 0) { ?>
		<td class="text-right"><a href="<?php echo base_url()."reports/referrals_detail/$date_filter_field/$visittype/$visit_name/$department_id/$unit/$area/M/$hospitalsearchtype/$hospital/$from_date/$to_date/$district/$state";?>"><?php echo $total_m;?> </td>		
		<?php } else { ?>
		<td class="text-right"><?php echo $total_m;?> </td>
		<?php }  ?>
		
		<?php if ($total_f > 0) { ?>
		<td class="text-right"><a href="<?php echo base_url()."reports/referrals_detail/$date_filter_field/$visittype/$visit_name/$department_id/$unit/$area/F/$hospitalsearchtype/$hospital/$from_date/$to_date/$district/$state";?>"><?php echo $total_f;?> </td>
		<?php } else { ?>
		<td class="text-right"><?php echo $total_f?> </td>
		<?php }  ?>
		
		<?php if ($total_other > 0) { ?>
		<td class="text-right"><a href="<?php echo base_url()."reports/referrals_detail/$date_filter_field/$visittype/$visit_name/$department_id/$unit/$area/O/$hospitalsearchtype/$hospital/$from_date/$to_date/$district/$state";?>"><?php echo $total_other;?> </td>
		<?php } else { ?>
		<td class="text-right"><?php echo $total_other;?> </td>
		<?php }  ?>
		
		<?php if ($total_not_specified > 0) { ?>
		<td class="text-right"><a href="<?php echo base_url()."reports/referrals_detail/$date_filter_field/$visittype/$visit_name/$department_id/$unit/$area/0/$hospitalsearchtype/$hospital/$from_date/$to_date/$district/$state";?>"><?php echo $total_not_specified;?> </td>
		<?php } else { ?>
		<td class="text-right"><?php echo $total_not_specified;?> </td>
		<?php }  ?>
		
		<?php if ($total_grand > 0) { ?>	
		<td class="text-right"><a href="<?php echo base_url()."reports/referrals_detail/$date_filter_field/$visittype/$visit_name/$department_id/$unit/$area/-1/$hospitalsearchtype/$hospital/$from_date/$to_date/$district/$state";?>"><?php echo $total_grand;?>
		<?php } else { ?>
		<td class="text-right"><?php echo $total_grand;?> </td>
		<?php }  ?>
		
	</tfoot>
	</tbody>
	
	</table>

	<?php } else { ?>
	
	No patient registrations on the given date.
<?php }  ?>
</div>	
  
