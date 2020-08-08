<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/selectize.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.selectize.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>
<script type="text/javascript">
$(function(){
	$('[data-toggle="tooltip"]').tooltip();

	window['userList'] = [];
	//edit scenario...
	if(window['edit_data']){
		var helpline_receiver = window['edit_data'].helpline_receiver;
		var helpline_receiver_link = window['edit_data'].helpline_receiver_link.map((hrl) => hrl.helpline_id);
		window['userList'] = res = transformUser(window['edit_data']['userList']);

		$.each(Object.keys(helpline_receiver), function(i, k){
			if(helpline_receiver[k]){
				if($('input#' + k).attr('type') == 'checkbox'){
					if(helpline_receiver[k] == "1") $('input#' + k).attr('checked', 'checked');
				} else { // if($('input#' + k).attr('type') == 'text' || $('select#' + k).length > 0){
					$('#' + k).val(helpline_receiver[k]);
				}
			}
		})

		if(helpline_receiver_link && helpline_receiver_link.length > 0){
			$('#helpline_receiver_link').val(helpline_receiver_link);
		}

		$('#phone').attr('disabled', 'disabled');
		$('#user_id').attr("data-previous-value", helpline_receiver['user_id']);

	}
	defaultHelplineOnChange();
	initUserSelectize();
});

function transformUser(res){
	if(res){
		res.map(function(d){
			d.custom_data = d.first_name + ' '+ d.last_name + ' - ' + d.phone + ' - ' + d.username;
		    return d;
		});
	}
	return res;
}

function defaultHelplineOnChange(){
	$('#helpline_receiver_link option').show();
	$('#helpline_receiver_link option[value="'+$('#helpline_id').val()+'"]').removeAttr('selected').hide();
}

function initUserSelectize(){
	var selectize = $('#user_id').selectize({
	    valueField: 'user_id',
	    labelField: 'custom_data',
	    searchField: 'custom_data',
	    options: window['userList'],
	    create: false,
	    render: {
	        option: function(item, escape) {
	        	return '<div>' +
	                '<span class="title">' +
	                    '<span class="prescription_drug_selectize_span">' + escape(item.custom_data) + '</span>' +
	                '</span>' +
	            '</div>';
	        }
	    },
	    load: function(query, callback) {
	        if (!query.length) return callback();
	        $.ajax({
	            url: '<?php echo base_url();?>helpline/search_staff_user',
	            type: 'POST',
				dataType : 'JSON',
				data : { query: query },
	            error: function(res) {
	                callback();
	            },
	            success: function(res) {
	            	res = transformUser(res);
	                callback(res.slice(0, 10));
	            }
	        });
		},

	});
	if($('#user_id').attr("data-previous-value")){
		selectize[0].selectize.setValue($('#user_id').attr("data-previous-value"));
	}
}

</script>
<style type="text/css">
	.form-horizontal{
		margin-bottom: 20px;
	}
	.info_icon{
    	width: 15px;
    	height: 15px;
    	margin-right: 5px;
    	margin-left: 5px;
    }
    .selectize-control.repositories .selectize-dropdown > div {
		border-bottom: 1px solid rgba(0,0,0,0.05);
	}
</style>
<center>
	<?php
		echo validation_errors();
		if (isset($msg)){?>
		<div class="alert alert-info">
		<?php echo $msg ?>
		</div>
		<?php } ?>
		
		
		<?php if(isset($edit_data)) { ?>
			<script> var edit_data = <?php echo $edit_data; ?>; </script>
        	<h3>  Edit Helpline Receivers</h3>
	    <?php } else { ?>
	        <h3>  Add Helpline Receivers</h3>
	    <?php }?>
</center></br>
	<?php echo form_open($submitLink, array('class'=>'form-horizontal','role'=>'form','id'=>'add_form')); ?>
	
	<div class="col-xs-12">
		<div class="container">
			<div class="row">							
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
					<div class="form-horizontal">
						<label for="full_name">Full Name<font style="color:red">*</font></label>
						<input type="text" class="form-control" placeholder="Enter Full Name" id="full_name" name="full_name" required/>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
					<div class="form-horizontal">
						<label for="short_name">Display Name<font style="color:red">*</font></label>
						<input type="text" class="form-control" placeholder="Enter Display Name" id="short_name" name="short_name" required/>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
					<div class="form-horizontal">
						<label for="phone">Phone<font style="color:red">*</font><img src="<?php echo base_url();?>assets/images/information-icon.png" class="info_icon" title="If Mobile, Please input only 10 digit mobile number. If Landline, then ignore initial zero & enter following digits" data-toggle="tooltip"/></label>
						<input type="text" maxlength="10" class="form-control" placeholder="Enter Phone (10 Digits)" id="phone" name="phone" required/>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
					<div class="form-horizontal">
						<label for="email">Email<font style="color:red">*</font></label>
						<input type="email" class="form-control" placeholder="Enter Email" id="email" name="email" required/>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
					<div class="form-horizontal">
						<label for="category">Category<font style="color:red">*</font></label>
						<input type="text" class="form-control" placeholder="Enter Category" id="category" name="category" required/>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
					<div class="form-horizontal">
						<label for="user_id">User</label>
						<select id="user_id" name="user_id" class="" placeholder="-Enter User Name/Phone-">
							<option value="">-Enter User Name/Phone-</option>
						</select>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
					<div class="form-horizontal">
						<label></label>
						<div class="form-control" style="box-shadow: none; border: 0;padding-left: 0;"><label for="doctor"><input type="checkbox" id="doctor" name="doctor" value="1" /> Is Doctor?</label></div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
					<div class="form-horizontal">
						<label></label>
						<div class="form-control" style="box-shadow: none; border: 0;padding-left: 0;"><label for="enable_outbound"><input type="checkbox" id="enable_outbound" name="enable_outbound" value="1" /> Enable Outbound Calls?</label></div>
					</div>
				</div>

				<div class="clearfix"></div>

				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
					<div class="form-horizontal">
						<label for="app_id">App ID</label>
						<input type="text" class="form-control" placeholder="Enter App Id" id="app_id" name="app_id" />
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
					<div class="form-horizontal">
						<label for="helpline_id">Default Helpline</label>
						<select id="helpline_id" name="helpline_id" class="form-control" onchange="defaultHelplineOnChange()">
							<option value="">Select Helpline</option>
							<?php 
								foreach($helplines as $helpline){
									echo "<option value='".$helpline->helpline_id."'";
									// if($this->input->post('helpline_id') && $this->input->post('helpline_id') == $helpline->helpline_id) echo " selected ";
									echo ">".$helpline->note. " - " .$helpline->helpline."</option>";
								}
								?>
						</select>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
					<div class="form-horizontal">
						<label></label>
						<div class="form-control" style="box-shadow: none; border: 0;padding-left: 0;"><label for="activity_status"><input type="checkbox" id="activity_status" name="activity_status" value="1" /> Enable Activity Status?</label></div>
					</div>
				</div>

				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
					<div class="form-horizontal">
						<label for="helpline_receiver_link">Helpline Links<img src="<?php echo base_url();?>assets/images/information-icon.png" class="info_icon" title="Hold CTRL key and Click for multiple selections" data-toggle="tooltip"/></label>
						<select id="helpline_receiver_link" name="helpline_receiver_link[]" class="form-control" multiple="">
							<?php 
								foreach($helplines as $helpline){
									echo "<option value='".$helpline->helpline_id."'";
									// if($this->input->post('helpline_id') && $this->input->post('helpline_id') == $helpline->helpline_id) echo " selected ";
									echo ">".$helpline->note. " - " .$helpline->helpline."</option>";
								}
								?>
						</select>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<center><button class="btn btn-md btn-primary" type="submit" value="submit">Submit</button></center>
				</div>
			</div>
		</div>
	</div>
</div>
