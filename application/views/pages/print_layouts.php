<style>
	#sortable .control-label{
		font-size:0.8em;
	}
	#footer
	{
		margin-top:31.7%!important;
	}
	.text-muted
	{
		margin-top:25px!important;
	}
	</style>
	<!-- Include scripts for jQuery Sortable -->
	<script src="<?php echo base_url(); ?>assets/js/jquery.ui.core.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.ui.widget.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.ui.mouse.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.ui.sortable.min.js"></script> 
	<script>

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
		<div class="row col-md-offset-2">
			<div class="col-md-10" >
				<h4>Rename Print Layout Name</h4>
				<div class="panel panel-default">
				<div class="panel-heading">
				<div class="row">
			<?php echo form_open("user_panel/print_layouts",array('role'=>'form','class'=>'')); ?>					
					<div class="col-md-4">
						<div class="form-group">
						<label class="control-label">Print Layout(A4) with preview</label>
						<select class="form-control" name="print_layout" id="print_layout" onchange="dispPreview();" required >
						<option value="Select">Select</option>
							<?php foreach($print_layouts as $layout): ?>
								<option value="<?= $layout->print_layout_id ?>"><?= $layout->print_layout_name ?></option>
							<?php endforeach; ?>
						</select>
						
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
					<input type="submit" value="Update" name="submit" class="btn btn-primary btn-sm" />
					<!-- <button type="submit" class="btn btn-primary" id="save-form">Update</button> -->
				</div>
			</form>
				<br/>
				
				<div id="print_preview"  style="width:80%;height:40%;margin-left:50px;" ></div>
				</div>
			</div>
		</div>


