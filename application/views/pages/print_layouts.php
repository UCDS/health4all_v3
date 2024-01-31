	<style>
	#sortable .control-label{
		font-size:0.8em;
	}
	</style>
	<!-- Include scripts for jQuery Sortable -->
	<script src="<?php echo base_url(); ?>assets/js/jquery.ui.core.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.ui.widget.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.ui.mouse.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.ui.sortable.min.js"></script> 
	<script>
	function submitForm() 
	{
		var print_layout_new_name = $('#print_layout_new_name').val();
    	var print_layout_id = $('#print_layout_id').val();
		$.ajax({
			type: "POST",
			data: { print_layout_new_name:print_layout_new_name, print_layout_id:print_layout_id },
			url: "<?php echo base_url('user_panel/print_layouts'); ?>",
			success: function(response) {
				//alert(response);
				window.location.href = "<?php echo base_url('user_panel/print_layouts'); ?>";
			},
			error: function(error) {
				console.log('Error fetching table data:', error);
			}
		});
	}

	function dispPreview()
	{
		$.ajax({
			type: 'POST',
			url: '<?php echo base_url('user_panel/form_preview');?>',
			data: { print_layout_id: $('select[name=print_layout]').val() },
			success: function(data){	
			$("#print_preview").html(data);					
			}						
			});
	}
	
  </script>

			<div class="col-md-10" >
				<h4>Rename Print Layout Name</h4>
				<div class="panel panel-default">
				<div class="panel-heading">
				<div class="row">
										
					<div class="col-md-4">
						<div class="form-group">
						<label class="control-label">Print Layout(A4) with preview</label>
						<select class="form-control" name="print_layout" id="print_layout" onchange="dispPreview();" required >
						<option value="Select">Select</option>
							<?php foreach($print_layouts as $layout): ?>
								<option value="<?= $layout->print_layout_id ?>"><?= $layout->print_layout_name ?></option>
							<?php endforeach; ?>
						</select>
						<input type="hidden" value="<?php echo $layout->print_layout_id; ?>" name="print_layout_id" id="print_layout_id">
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
						<label class="control-label">Update Print Layout Name</label>
							<input type="text" class="form-control" name="print_layout_new_name" value="" 
							placeholder="New Print Layout Name" id="print_layout_new_name" autocomplete="off">
						</div>
					</div>
				</div>
				
				<div class="panel-footer" style="border-top:none!important;">
					<button class="btn btn-primary" id="save-form" onclick="submitForm()">Update</button>
					<!-- <button type="submit" class="btn btn-primary" id="save-form">Update</button> -->
				</div>
				<br/>
				
				<div id="print_preview"  style="width:80%;height:40%;margin-left:50px;" ></div>
				</div>
			</div>


