<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/selectize.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.selectize.js"></script>

<style>
table, th, td {
  border:1px solid black;
  margin: 30px;
  padding: 20px;
}
</style>

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

		var filter_values = JSON.parse(JSON.stringify(<?php echo json_encode($filter_values); ?>)); 
		var dropdowns = ['district'];
		console.log(filter_values);
		filter_values.forEach((filter_value) => {
			const { name, value } = filter_value;
			if(dropdowns.includes(name)){
				selectizes[name][0].selectize.setValue(value);
			} else {
				$('[name="'+name+'"]').val(value);
			}
		});
	});
</script>

<div class="col-md-12">
	<div class="panel panel-default">
		<div class="panel-heading">
		<h4>Search Hospital</h4>	
		</div>
		<div class="panel-body">
        <?php echo form_open('hospital/search_hospital',array('class'=>'form-group','role'=>'form','id'=>'search_hospital')); ?>
				<div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
						<div class="form-group">
                            <label class="control-label">Hospital Name</label>
                            <input type="text" id="hospital" name="hospital" size="5" class="form-control" />   
                        </div>
                        </div>

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
						<div class="form-group">
                            <label class="control-label">Hospital Short Name</label>
						    <input type="text" id="hospital_short_name" name="hospital_short_name" size="5" class="form-control" />
                        </div>
                        </div>
				

					<div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">		
						<div class="form-group">
							<label class="Inputdistrict">  District    </label>
							<select id="district_id"  name="district" style=" display: inline-grid;" placeholder="Enter district" <?php if($field->mandatory) echo "required"; ?>>
								<option value="">   --Enter district--   </option>
								<input type='hidden' name='district_id' id='district_id_val' class='form-control'/>
		
							</select>
						</div>
					</div>
				</div>
                <br>

                <div class="row">
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
                </div>
                <br>
                
                <div class="row">
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
				</div>
        </div>
		<div class="panel-footer">
			<div class="text-center">
			<input class="btn btn-sm btn-primary" name="search_hospital" type="submit" value="Search" />
			</div>
			</form>
		</div>
	</div>
	<?php if(isset($msg)) {?>
		<div class="alert alert-info">
			<?php echo $msg; ?>
	</div>
	<?php } else { ?>
	<?php if(isset($results) && count($results)>0){ ?>
<div>

<h5>Records Found </h5>

</div>
	<table  >
  	<tr >
		<th >Hospital Name</th>
		<th>Hospital Short Name</th>
		<th>District</th>
		<th>Type1</th>
		<th>Type2</th>
		<th>Type3</th>
		<th>type4</th>
		<th>Type5</th>
		<th>Type6</th>
		<th>Action</th>
    </tr>
	<?php
		foreach($results as $hospital){
	 ?>
  <tr>
   <td><?php echo $hospital->hospital; ?></td>
   <td><?php echo $hospital->hospital_short_name; ?></td>
   <td><?php echo $hospital->district; ?></td>
   <td><?php echo $hospital->type1; ?></td>
   <td><?php echo $hospital->type2; ?></td>
   <td><?php echo $hospital->type3; ?></td>
   <td><?php echo $hospital->type4; ?></td>
   <td><?php echo $hospital->type5; ?></td>
   <td><?php echo $hospital->type6; ?></td>
   <td><a class="btn btn-outline-success" href="<?php echo base_url() ?>"> Edit</a></td>
                    
  </tr>
  <?php }?>
</table>

	<?php } ?>   
	<?php } ?>   




   