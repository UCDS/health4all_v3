<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.chained.min.js"></script>

<div class="row col-md-offset-2">
	<?php if(validation_errors()) { ?>
		<div class="alert alert-danger"><?php echo validation_errors(); ?></div>
	<?php } ?>
	<?php if(isset($success)){ ?>
		<div class="alert alert-success"><?php echo $success;?></div>
	<?php } ?>
	<?php if(isset($failure)){ ?>
		<div class="alert alert-danger"><?php echo $failure;?></div>
	<?php } ?>

	<?php echo form_open($form_action,array('role'=>'form','class'=>'form-horizontal','id'=>'common_page_form')); ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4><?php echo $title;?></h4>
			</div>
			<div class="panel-body">
				<div class="row">
					<?php foreach ($fields as $field) { ?>
						<div class="col-lg-4">
						<label><?php echo $field['label']; ?></label>	
						<?php if($field['isText']) {?>
							<input type="text" class="form-control" name="<?php echo $field['field']; ?>" id="<?php echo $field['field']; ?>" /> 
						<?php } else if($field['isDropdown']) {?>
							<select class="form-control" name="<?php echo $field['field']; ?>" id="<?php echo $field['field']; ?>" > 
								<option value="">Select</option>
								<?php foreach($field['options'] as $option){ ?>
									<option value="<?php echo $option['value']; ?>"><?php echo $option['label']; ?></option>
								<?php } ?>
							</select>
						<?php } ?>
						</div>
					<?php } ?>
				</div>
			</div>
			<div class="panel-footer">
				<button name="common_page_form_submit" class="btn btn-sm btn-primary" type="submit" value="submit">Submit</button>
			</div>
		</div>	
    </form>
</div>