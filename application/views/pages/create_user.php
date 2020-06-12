<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.chained.min.js"></script>
<script type="text/javascript">
$(function(){
	$("#staff_id").chained("#hospital_id");
});
</script>
<div class="row col-md-offset-2">
	<?php if(isset($msg)){ ?>
		<div class="alert alert-info"><?php echo $msg;?></div>
	<?php
	}
	?>
	<?php echo form_open('user_panel/create_user',array('role'=>'form','class'=>'form-horizontal','id'=>'create_user')); ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4>Create User</h4>
		</div>
		<div class="panel-body">
				<p class="lead">Login details</p>	
					<div class="form-group col-md-12">
						<div class="col-md-3">
							<label for="username" class="control-label">Username</label>
						</div>
						<div class="col-md-6">
							<input type="text" class="form-control" placeholder="Username" id="username" name="username" />
						</div>
					</div>	
					<div class="form-group col-md-12">
						<div class="col-md-3">
							<label for="password" class="control-label">Password</label>
						</div>
						<div class="col-md-6">
							<input type="password" class="form-control" placeholder="Password" id="password" name="password" />
						</div>
					</div>
					<div class="form-group col-md-12">
						<div class="col-md-3">
						<label class="control-label">Hospital</label>
						</div>
						<div class="col-md-6">						
						<select name="hospital_id" id="hospital_id" class="form-control" >
						<option value="all">--Select--</option>
						<?php 
						foreach($hospital as $h){
							echo "<option value='".$h->hospital_id."' >".$h->hospital."</option>";
						}
						?>
						</select>
						</div>
					</div>
					<div class="form-group col-md-12">
						<div class="col-md-3">
						<label class="control-label">Staff</label>
						</div>
						<div class="col-md-6">						
						<select name="staff" id="staff_id" class="form-control" required >
						<option value="">--Select--</option>
						<?php 
						foreach($staff as $s){
							echo "<option value='".$s->staff_id."' class='".$s->hospital_id." all' >".$s->staff_name."</option>";
						}
						?>
						</select>
						</div>
					</div>
					<div class="col-md-12">
						<table class="table table-bordered table-striped">
							<thead>
								<th>Function</th>
								<th>Add</th>
								<th>Edit</th>
								<th>View</th>
							</thead>
							<tbody>
							<?php foreach($user_functions as $f){ ?>
								<tr>
									<td><?php echo $f->user_function;?>
									<input type="checkbox" value="<?php echo $f->user_function_id;?>" name="user_function[]" class="sr-only" checked /></td>
									<td><input type="checkbox" name="<?php echo $f->user_function_id;?>[]" value="add" /></td>
									<td><input type="checkbox" name="<?php echo $f->user_function_id;?>[]" value="edit" /></td>
									<td><input type="checkbox" name="<?php echo $f->user_function_id;?>[]" value="view" /></td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
					</div>
		</div>
		<div class="panel-footer">
				<button class="btn btn-lg btn-primary btn-block" type="submit" value="submit">Submit</button>
		</div>
	</div>	
	</form>
</div>