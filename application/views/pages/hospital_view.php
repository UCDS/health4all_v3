<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/selectize.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.selectize.js"></script>
<style>
	.mandatory{
		color:red;
		cursor:default;
		font-size:15px;
		font-weight:bold;
	}

</style>
	<center>	
<?php if(isset($msg)){  ?>
	<div class="alert alert-info"><?php echo $msg; ?>
	</div>
<?php } ?>
	<?php echo validation_errors(); ?>
	</center>

<script>
	var selectizes = {};
	function initDistrictSelectize(){
        var districts = JSON.parse(JSON.stringify(<?php echo json_encode($districts); ?>));
		selectizes['district'] = $('#district_id').selectize({
			valueField: 'district_id',
			labelField: 'custom_data',
			searchField: ['district','district_alias','state'],
			options: districts,
			create: false,
			render: {
				option: function(item, escape) {
					return '<div>' +
						'<span class="title">' +
							'<span class="prescription_drug_selectize_span">'+escape(item.custom_data)+'</span>' +
						'</span>' +
					'</div>';
				}
			},
			load: function(query, callback) {
				if (!query.length) return callback();
			},

		});
	}	

	$(document).ready(function(){
		initDistrictSelectize();

		<?php if(isset($filter_values)) { ?>
		var filter_values = JSON.parse(JSON.stringify(<?php echo json_encode($filter_values); ?>)); 
		var dropdowns = ['district'];
		var radios = ['auto_ip_number'];
		 filter_values['district'] = filter_values['district_id'];
		// filter_values['helpline'] = filter_values['helpline_id'];
		// filter_values['print_layout'] = filter_values['print_layout_id'];
		// filter_values['print_layout_a6'] = filter_values['a6_print_layout_id'];
		console.log(filter_values);
		Object.keys(filter_values).forEach((name) => {
			const value = filter_values[name];
			if(dropdowns.includes(name)){
				selectizes[name][0].selectize.setValue(value);
			}  else if(radios.includes(name)){
				$('input[name="'+name+'"][value="'+value+'"]').prop('checked', true);
				//$("input[name="'+name+'"][value="'+value+'"]").prop('checked',true);
			} else {
				$('[name="'+name+'"]').val(value);
			}
		});
		<?php } ?>
	});
	
	function previewLogo(){
		$("#preview_logo_img").show();
		 var logo_preview = $('select[name=logo]').val();
		 var path = '<?php echo base_url('assets/logos');?>'+"/"+logo_preview;
		  $("#preview_logo_img").attr("src",path);
		
	}
</script>	
			<h2 align="center"><?php echo $title; ?></h2><br>
			<?php echo form_open('hospital/add_hospital',array('class'=>'form-group','role'=>'form','id'=>'add_hospital')); ?>
	<div class="col-md-8 col-md-offset-3">
		<input type="hidden" name="hospital_id" />
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="inputhospital ">Hospital Name <span class="mandatory">*</span> </label>
								<input class="form-control" name="hospital" id="inputhospital" placeholder="Enter Hospital name" type="TEXT" align="middle">
							</div>
						</div>
						
						<div class="col-xs-12 col-sm-12 col-md-6  col-lg-4">
							<div class="form-group">
								<label for="inputhospital_short_name ">Hospital Short Name</label>
								<input class="form-control" name="hospital_short_name" id="inputhospital_short_name" placeholder="Enter Hospital short name" type="text">
							</div>
						</div>
						
						<div class="col-xs-12 col-sm-12 col-md-6  col-lg-4">
							<div class="form-group">
								<label for="Inputdescription">Description</label>
								<textarea class="form-control" name="description" id="description" rows="2" cols="6" >
									<?php echo $filter_values->description; ?>
								</textarea>
							</div>
						</div>
						<script>
							ClassicEditor
								.create( document.querySelector( '#description' ), {
									toolbar: [ 'bold', 'italic', 'bulletedList', 'numberedList' ]
								} )
								.catch( error => {
										console.error( error );
								} );
						</script>
					</div>

				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
						<div class="form-group">
								<label for="Inputplace">Place</label>
								<input class="form-control" name="place" id="inputplace" placeholder="Enter Place" type="TEXT" align="middle">
						</div> 
					</div>
						<!-- <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="Inputstate" >State</label>
								<input class="form-control" name="state" id="inputstate" placeholder="Enter State" type="TEXT" align="middle">
							</div>
						</div> -->
					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">		
						<div class="form-group">
							<label class="Inputdistrict">  District    </label>
							<select id="district_id"  name="district_id" style=" display: inline-grid;" placeholder="Enter district" <?php if($field->mandatory) echo "required"; ?>>
								<option value="Select">   --Enter district--   </option>
								<input type='hidden' name='district_id_val' id='district_id_val' class='form-control'/>
							</select>						
						</div>
					</div>
				
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="Inputtype1">Type1</label>
								<select class="form-control" name="type1">
									<option value="" selected="selected">select</option>
									<option value="Private">Private</option>
									<option value="Public">Public</option>
									<option value="Non-profif">Non-Profit</option>
								</select>
							</div>	
						</div>
				</div>

				<div class="row">	
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="Inputtype2" >Type2</label>
								<select class="form-control" name="type2">
									<option value="" selected="selected">select</option>
									<option value="State Govt.">State Government</option>
									<option value="Central Govt.">Central Government</option>
								</select>
							</div>	
						</div>

					   <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="Inputtype3" >Type3</label>
								<select class="form-control" name="type3">
									<option value="" selected="selected">select</option> 
									<option value="Teaching">Teaching</option>
									<option value="Non-Teaching">Non-Teaching</option>
								</select>
							</div>	
						</div>
					
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="Inputtype4">Type4</label>
								<select class="form-control" name="type4">
									<option value="" selected="selected">select</option>
									<option value="District">District</option>
									<option value="Area">Area</option>
									<option value="CHC">CHC</option>
									<option value="PHC">PHC</option>
									<option value="Sub">Sub Centre</option>
								</select>
							</div>	
						</div>
				</div>

				<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="Inputtype5">Type5</label>
								<select class="form-control" name="type5">
									<option value="" selected="selected">select</option>
									<option value="Urban">Urban</option>
									<option value="Rural">Rural</option>
								</select>
							</div>	
						</div>
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="Inputtype6">Type6</label>
								<select class="form-control" name="type6">
									<option value="" selected="selected">select</option>
									<option value="DME">DME</option>
									<option value="VVP">VVP</option>
									<option value="DH">DH</option>
								</select>
							</div>	
						</div>
												

						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label class="control-label">Helpline </label>
								<select class="form-control" name="helpline_id" >
									<option value="Select">Select</option>
									<?php foreach($helplines as $helpline){
									echo "<option value='$helpline->helpline_id'>$helpline->helpline - $helpline->note</option>";
									}
									?>
								</select>
							</div>
						</div>
				</div>

				<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="Inputauto_ip_number" >Auto IP Number</label><br>
								<input type="radio" name="auto_ip_number" value="1">
								<label for="auto_ip_number_yes">Yes</label>
								<input type="radio" name="auto_ip_number" value="0" checked>
								<label for="auto_ip_number_no" checked>No</label><br>
							</div>
						</div>
					
											
						<div class="col-md-4">
							<div class="form-group">
								 <label class="control-label">Logo</label> 
								 <select class="form-control" name="logo" id="logo" onchange="previewLogo()" >
								 <option value="">Select</option>
								 <?php
									$extensions = ['jpg', 'jpeg', 'png'];
									$path = 'assets/logos/*.{'.implode(',', $extensions).'}';	
									foreach (glob($path, GLOB_BRACE) as $filename) 
									{ 
										$filename = basename($filename);
										echo "<option value='" . $filename . "'>".$filename."</option>";
									}
								 ?>
								 </select>

						</div>
						</div>

					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
					 <div class="form-group">
					 <img id="preview_logo_img"  width="100" height="100" alt="Preview of selected Logo" hidden>
					 </div>
					</div>
				</div>
					
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label">Print Layout(A4)</label>
								<select class="form-control" name="print_layout_id" id="print_layout" onchange="dispPreview();">
									<option value="Select">Select</option>
									<?php foreach($print_layouts as $layout){
									echo "<option value='$layout->print_layout_id'>$layout->print_layout_name</option>";
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label">Print Layout(A6)</label>
								<select class="form-control" name="a6_print_layout_id" id="print_layout_a6">
									<option value="Select">Select</option>
									<?php foreach($print_layouts as $layout){
										echo "<option value='$layout->print_layout_id'>$layout->print_layout_name</option>";
									}
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-12" >
					<center><button type="submit" class="btn btn-primary" name="Submit" id="btn">Submit</button></center>
				</div>					
				</div>
			
	
            <?php echo form_close(); ?>	

			
