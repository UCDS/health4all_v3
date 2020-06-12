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
		
	});
</script>

<center>
<strong><?php if(isset($msg)){ echo $msg;}?></strong>

</center>

<div class="col-md-8 col-md-offset-2">
	
	
	 <center>	<h3>Edit  Staff Transaction</h3></center><br>
	<?php echo form_open('staff/add_transaction',array('role'=>'form')); ?>
	<div class="form-group">
		    <label for="select_doctor" class="col-md-4">Doctor Name<font color='red'>*</font></label>
            <div class="col-md-6">
                <select id="select_doctor" class="repositories" placeholder="Select a Doctor..." name="staff_id" required ></select>
            </div>
            
		    <div class='col-md-10 selected_doctor'>
		    </div>
        <label for="transaction_type" class="col-md-4">Transaction Type<font color='red'>*</font></label>
		<div  class="col-md-6">
		    <select name="hr_transaction_type_id" class="form-control"  id="hr_transaction_type" required>
				<option value="" selected disabled>Select Transaction type</option>
				<?php
					foreach($hr_transaction_types as $hr_transaction_type){ ?>
						<option value="<?php echo $hr_transaction_type->hr_transaction_type_id;?>"><?php echo $hr_transaction_type->hr_transaction_type;?></option>
				<?php } ?>
			</select>            
		</div>
        <div class='col-md-10'>
            
		</div>
        <label class="col-md-4">Transaction Date-Time</label>
        <div class="col-md-6">	            		
            <input class="form-control date" name="hr_transaction_date" value="<?php echo date("d-M-Y");?>" size="10" />			
		</div>
	</div>
    </div>
   	<div class="col-md-2 col-md-offset-5">
    <br /><br />
	<input class="btn btn-lg btn-primary btn-block" type="submit" value="Update" name="update">
	</div>
	</form>
	</div>
	<script>
    
    $(function(){
		selectize = $("#select_doctor")[0].selectize;
		selectize.on('change',function(){
			var test = selectize.getOption(selectize.getValue());
			test.find('.staff_id').text()!=""?$(".selected_doctor").text(test.find('.language').text()+", "+test.find('.staff_id').text()) :  $(".selected_doctor").text("").removeClass('well well-sm');
			$(".selected_doctor").text()!=""?$(".selected_doctor").addClass('well well-sm') : $(".selected_doctor").removeClass('well well-sm');
            
		});
	});

    $('#select_doctor').selectize({
    valueField: 'staff_id',
    labelField: 'first_name',
    searchField: 'first_name',
    create: false,
    render: {
        option: function(item, escape) {

            return '<div>' +                
                '<ul class="meta">' +
                    (item.first_name ? '<li class="language">' + escape(item.first_name) + ' ' : '') +
                    (item.last_name ? '' + escape(item.last_name) + '</li>' : '') +                    
                '</ul>' +
                '<span class="title">' +
                    '<span class="staff_id">' + escape(item.staff_id) + '</span>' +
                '</span>' +
            '</div>';
        }
    },
    load: function(query, callback) {
        if (!query.length) return callback();
		$.ajax({
            url: '<?php echo base_url();?>staff/search_staff',
            type: 'POST',            
			dataType : 'json',
            data : {query:query},			
            error: function(res) {
                callback();
            },
            success: function(res) {
                callback(res.doctors.slice(0, 10));
            }
        });
    }
	});
    </script>