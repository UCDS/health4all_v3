<script>
$(function(){
	$('#change_password').on('submit',function(){
		if($("#password").val()!=$("#confirm_password").val()){
			$(".confirm_error").show();
			return false;
		}
	});
});
			
</script>
<div class="row col-md-8 col-md-offset-2">
	<?php if(isset($msg)){ ?>
		<div class="alert alert-info"><?php echo $msg;?></div>
	<?php
	}
	?>
	<?php echo form_open('user_panel/change_password',array('role'=>'form','class'=>'form-horizontal','id'=>'change_password')); ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Change Password</h4>
		</div>
		<div class="panel-body">
					<div class="form-group col-md-12">
						<div class="col-md-3">
							<label for="old_password" class="control-label">Old Password</label>
						</div>
						<div class="col-md-6">
							<input type="password" class="form-control" placeholder="Old Password" id="old_password" name="old_password" required />
						</div>
					</div>	
					<div class="form-group col-md-12">
						<div class="col-md-3">
							<label for="password" class="control-label">Password</label>
						</div>
						<div class="col-md-6">
							<input type="password" class="form-control" placeholder="Password" id="password" name="password" required />
						</div>
					</div>
					<div class="form-group col-md-12">
						<div class="col-md-3">
							<label for="password" class="control-label">Confirm Password</label>
						</div>
						<div class="col-md-6">
							<input type="password" class="form-control" placeholder="Confirm Password" id="confirm_password" name="confirm_password" required />
							<div class="alert alert-danger confirm_error " hidden >Please re-enter your password correctly</div>
						</div>
					</div>
		</div>
		<div class="panel-footer">
				<button class="btn btn-lg btn-primary btn-block" type="submit" value="submit">Submit</button>
		</div>
	</div>	
	</form>
</div>
</div>