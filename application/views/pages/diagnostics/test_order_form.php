<link rel="stylesheet" href="<?php echo base_url();?>assets/css/selectize.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/selectize.css">

		<style type="text/css">
		.selectize-control.repositories .selectize-dropdown > div {
			border-bottom: 1px solid rgba(0,0,0,0.05);
		}
		.selectize-control.repositories .selectize-dropdown .by {
			font-size: 11px;
			opacity: 0.8;
		}
		.selectize-control.repositories .selectize-dropdown .by::before {
			content: 'by ';
		}
		.selectize-control.repositories .selectize-dropdown .name {
			font-weight: bold;
			margin-right: 5px;
		}
		.selectize-control.repositories .selectize-dropdown .title {
			display: block;
		}
		.selectize-control.repositories .selectize-dropdown .description {
			font-size: 12px;
			display: block;
			color: #a0a0a0;
			white-space: nowrap;
			width: 100%;
			text-overflow: ellipsis;
			overflow: hidden;
		}
		.selectize-control.repositories .selectize-dropdown .meta {
			list-style: none;
			margin: 0;
			padding: 0;
			font-size: 10px;
		}
		.selectize-control.repositories .selectize-dropdown .meta li {
			margin: 0;
			padding: 0;
			display: inline;
			margin-right: 10px;
		}
		.selectize-control.repositories .selectize-dropdown .meta li span {
			font-weight: bold;
		}
		.selectize-control.repositories::before {
			-moz-transition: opacity 0.2s;
			-webkit-transition: opacity 0.2s;
			transition: opacity 0.2s;
			content: ' ';
			z-index: 2;
			position: absolute;
			display: block;
			top: 12px;
			right: 34px;
			width: 16px;
			height: 16px;
			background: url(<?php echo base_url();?>assets/images/spinner.gif);
			background-size: 16px 16px;
			opacity: 0;
		}
		.selectize-control.repositories.loading::before {
			opacity: 0.4;
		}
		</style>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.selectize.js"></script>
<script>
	$(function(){
		$(".date").Zebra_DatePicker();
		<?php if(count($test_areas)>1){ ?>
		$(".test_areas").hide();
		$("#test_area").on('change',function(){
			$(".test_areas").hide();
			$("#test_area_"+$(this).val()).show();
		});
		<?php } ?>
	});
</script>
<div class="col-md-8 col-md-offset-2">
<center>
<strong><?php if(isset($msg)){ echo $msg;}?></strong>

</center>
<br>
<?php echo validation_errors(); echo form_open('diagnostics/test_order',array('role'=>'form','class'=>'form-custom')); ?>
<div class="panel panel-default">
	<div class="panel-heading">
	<div class="row">
		<b>Order a test - </b>
		<?php if(count($test_areas)>1){ ?>
		<div class="form-group">
			<label for="test_area">Test Area<font color='red'>*</font></label>
			<select name="test_area" class="form-control"  id="test_area">
				<option value="" selected disabled>Select Test Area</option>
				<?php
					foreach($test_areas as $test_area){ ?>
						<option value="<?php echo $test_area->test_area_id;?>"><?php echo $test_area->test_area;?></option>
				<?php } ?>
			</select>
		</div>
		<?php } 
		else if(count($test_areas)==1){ ?>
			<input type="text" value="<?php echo $test_areas[0]->test_area_id;?>" name="test_area" class="sr-only" hidden readonly />
			<b><?php echo $test_areas[0]->test_area;?></b>
		<?php } ?>
		<div class="col-md-6 pull-right">
			<label>Order Date-Time</label> <input class="form-control date" name="order_date" value="<?php echo date("d-M-Y");?>" size="10" />
			<input class="form-control time" name="order_time" value="<?php echo date("g:ia");?>"  size="5" /> 
		</div>
	</div>
	</div>
	<div class="panel-body">
		<div class="col-md-12">
			<div class="col-md-6">
			<select class="form-control" id="visit_type" style="width:100px" name="patient_type">
				<option value="" disabled>Select Patient Type</option>
				<option value="OP">OP</option>
				<option value="IP" selected>IP</option>
			</select>
			<select class="form-control" id="year" style="width:100px"  name="year">
				<option value="" disabled>Select Admission Year</option>
				<option value="<?php echo date("Y",strtotime("Last Year"));?>"><?php echo date("Y",strtotime("Last Year"));?></option>
				<option value="<?php echo date("Y");?>" selected><?php echo date("Y");?></option>
			</select>
			<font color='red'>*</font>
			</div>
			<div class="col-md-6">
			<select id="select-patient" class="repositories" placeholder="Select a Patient..." name="visit_id" required ></select>
			</div>
		</div>
		<div class='col-md-12 selected_patient'>
		</div>
		<hr>
		<hr>
		<div class="col-md-12">
		<div class="col-md-6">
			<label>Specimen Type</label>
			<select class="form-control" name="specimen_type" required>
				<option value="" selected disabled>Select</option>
				<?php foreach($specimen_types as $specimen){ ?>
					<option value="<?php echo $specimen->specimen_type_id;?>"><?php echo $specimen->specimen_type;?></option>
				<?php } ?>
			</select><font color='red'>*</font>
		</div>
		<div class="col-md-6">
			<label>Source</label><!--creating a label for the new field specimen_source-->
			<input type="text" placeholder="Specimen source" class="form-control" name="specimen_source" />
		</div>
		</div>
		<!--creating the input field for the specimen_source-->
		<hr>
		<hr>
		<div class="col-md-12">
		<div class="col-md-6">
		<label>Sample ID<font color='red'>*</font></label>
			<input type="text" placeholder="Sample ID" name="sample_id" class="form-control" required />
		</div>
		<div class="col-md-6">
			<label>Container Type</label>
			<input type="text" placeholder="Sample Container Type" name="sample_container" class="form-control" />
		</div>
		</div>	
		<hr>
		<hr>
		<?php
		$test_areas=array();	
	
		foreach($test_masters as $test_master){
			$test_areas[]=$test_master->test_area_id;
		}
		$test_areas=array_unique($test_areas);
		foreach($test_areas as $test_area){ 
		?>
		<div class="form-group test_areas" id="test_area_<?php echo $test_area;?>">
		<?php 
		$test_methods=array();
		foreach($test_masters as $test_master){
			if($test_master->test_area_id == $test_area)
			$test_methods[]=[
				'test_method' => $test_master->test_method,
				'test_area_id' => $test_master->test_area_id
			];
		}
	
		$test_methods=array_unique($test_methods, SORT_REGULAR);
		
		foreach($test_methods as $test_method){ ?>
			<div class="col-md-12 test_method">
				<div class="alert well-sm alert-info"><b><?php echo $test_method['test_method'];?></b></div>
		<?php
			$i=0;
			foreach($test_groups as $test_group){
				if($test_group->test_method == $test_method['test_method'] && $test_group->test_area_id == $test_method['test_area_id']) { ?>
			<div class="col-md-12 well well-sm" >Group tests</div>
			<?php 
			break;}
			}
			?>
		<?php 
		$groups = array();
		$group_ids = array();
		foreach($test_groups as $group){
			if(!in_array($group->group_id,$group_ids)){
				$groups[] = $group;
				$group_ids[] = $group->group_id;
			}
		}
		?>
		<?php foreach($groups as $test_group){
				if($test_group->test_method == $test_method['test_method'] && $test_group->test_area_id == $test_method['test_area_id']) { 
				$tests="";
				$count =1;
				foreach($test_groups as $group){
					if($test_group->group_id == $group->group_id){
						$tests.=$count.". ".$group->test_name."<br />";
						$count++;
					}
				}
				?>
			<div class="col-md-4 panel test_group test_group_<?php echo $test_group->group_id;?>">
				<div class="checkbox" data-toggle="popover" data-placement="bottom" data-content="<?php echo $tests;?>">
					<input class="checkbox form-control" type="checkbox" name="test_group[]" id="group_<?php echo $test_group->group_id;?>" value="<?php echo $test_group->group_id;?>" />
					<label for="group_<?php echo $test_group->group_id;?>"><?php echo $test_group->group_name;?></label>
				</div>
			</div>
		<?php }
		} 
		if(!!$test_masters) { ?>
		<div class="col-md-12 well well-sm">Individual Tests</div>
		<?php 
			foreach($test_masters as $test_master){ 
				if($test_master->test_method == $test_method['test_method'] && $test_master->test_area_id == $test_method['test_area_id']) { ?>
				<div class="col-md-4 panel">
					<div class="checkbox">
						<input class="checkbox form-control" type="checkbox" name="test_master[]" id="<?php echo $test_master->test_name;?>" value="<?php echo $test_master->test_master_id;?>" />
						<label for="<?php echo $test_master->test_name;?>"><?php echo $test_master->test_name;?></label>
					</div>
				</div>
			<?php
				}
			}
		}?>
		</div>		
		<?php } ?>
		</div>
		<?php } ?>
	</div>
	<div class="panel-footer">
		<div class="col-md-offset-4">
		</br><input class="form-control" id="submit" name="submit" value="submit" type="hidden"/>
		<button class="btn btn-lg btn-primary" type="submit" value="submit" name="ta_add">Order</button>
		</div>
	</div>
</div>
</div>
<script>
		var $year=$("#year").val();
		var $visit_type=$("#visit_type").val();
	$(function(){
		$("#visit_type").change(function(){
			$visit_type=$(this).val();
			selectize = $("#select-patient")[0].selectize;
			selectize.clear();
			selectize.clearOptions();
			selectize.clearCache();
			selectize.renderCache={};
		});
		$("#year").change(function(){
			$year=$(this).val();
			selectize = $("#select-patient")[0].selectize;
			selectize.clear();
			selectize.clearOptions();
			selectize.clearCache();
			selectize.renderCache={};
		});
		selectize = $("#select-patient")[0].selectize;
		selectize.on('change',function(){
			var test = selectize.getOption(selectize.getValue());
			test.find('.hosp_file_no').text()!=""?$(".selected_patient").text(test.find('.hosp_file_no').text()+", "+test.find('.language').text()+", Age : "+test.find('.watchers').text()):$(".selected_patient").text("").removeClass('well well-sm');
			$(".selected_patient").text()!=""?$(".selected_patient").addClass('well well-sm') : $(".selected_patient").removeClass('well well-sm');
		});
	});
	$('#select-patient').selectize({
    valueField: 'hosp_file_no',
    labelField: 'hosp_file_no',
    searchField: 'hosp_file_no',
    create: false,
    render: {
        option: function(item, escape) {

            return '<div>' +
                '<span class="title">' +
                    '<span class="hosp_file_no">' + escape(item.hosp_file_no) + '</span>' +
                '</span>' +
                '<ul class="meta">' +
                    (item.first_name ? '<li class="language">' + escape(item.first_name) + ' ' : '') +
                    (item.last_name ? '' + escape(item.last_name) + '</li>' : '') +
                    '<li class="watchers"><span>' + escape(item.age_years) + '</span> yrs<span>' + 
					(item.age_months!=0 ? escape(item.age_months) + '</span> months<span>' : '') + 
					(item.age_days!=0 ? escape(item.age_days) + '</span> days</li>' : '') +
                '</ul>' +
            '</div>';
        }
    },
    load: function(query, callback) {
        if (!query.length) return callback();
		$.ajax({
            url: '<?php echo base_url();?>diagnostics/search_patients',
            type: 'POST',
			dataType : 'json',
			data : {visit_type:$visit_type,year:$year,query:query},
            error: function(res) {
                callback();
            },
            success: function(res) {
                callback(res.patients.slice(0, 10));
            }
        });
    }
	});
</script>