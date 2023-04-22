<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.chained.min.js"></script>

<div class="row col-md-offset-2">
	<?php if(validation_errors()) { ?>
		<div class="alert alert-danger"><?php echo validation_errors(); ?></div>
	<?php } ?>
	<?php if(isset($msg)){ ?>
		<div class="alert alert-info"><?php echo $msg;?></div>
	<?php } ?>

	<?php echo form_open('register/add_priority_type',array('role'=>'form','class'=>'form-horizontal','id'=>'create_user')); ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Add Priority Type</h4>
			</div>
			<div class="panel-body">
				<label>Priority Type</label>	
				<input type="text" class="form-control" name="priority_type" id="priority_type" style="width: 200px;" /> 

			</div>
			<div class="panel-footer">
				<button name="submit" class="btn btn-sm btn-primary" type="submit" value="submit">Submit</button>
			</div>
		</div>	
    </form>
</div>