<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.chained.min.js"></script>

<div class="row col-md-offset-2">
	<?php if(isset($msg)){ ?>
		<div class="alert alert-info"><?php echo $msg;?>
</div>
	<?php
	}
	?>

	<?php echo form_open('leftnav/add_secondary_route',array('role'=>'form','class'=>'form-horizontal','id'=>'create_user')); ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Add Secondary Route</h4>
		</div>
		<div class="panel-body">
				<label>Secondary Route</label>	
                <input type="text" class="form-control" name="secondary_route" id="secondary_route" style="width: 200px;" /> 

            </div>
            <div class="panel-footer">
                    <button class="btn btn-sm btn-primary" type="submit" value="submit">Submit</button>
            </div>
        </div>	
        </form>
    </div>

