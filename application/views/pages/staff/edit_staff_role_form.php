<div class="col-md-8 col-md-offset-2">
	
	<?php
	 if((isset($mode))&&(($mode)=="select")){ ?>
	<center>	<h3>Edit  Staff </h3></center><br>
	<?php echo form_open('staff/edit/staff_role',array('role'=>'form')); ?>
		

		<div class="form-group">
		<label for="staff" class="col-md-4">Staff Role Name<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Staff" id="staff_role" name="staff_role" 
		<?php if(isset($staff_role)){
			echo "value='".$staff_role[0]->staff_role."' ";
			} ?>
		
		/>
		<?php if(isset($staff_role)) { ?>
		<input type="hidden" value="<?php echo $staff_role[0]->staff_role_id;?>" name="staff_role_id" />
		
		<?php } ?>
		</div>
	</div>
   	<div class="col-md-3 col-md-offset-4">
	<input class="btn btn-lg btn-primary btn-block" type="submit" value="Update" name="update">
	</div>
	</form>
	<?php } ?>
	<h3><?php if(isset($msg)) echo $msg;?></h3>	
	<div class="col-md-12">
	<?php echo form_open('staff/edit/staff_role',array('role'=>'form','id'=>'search_form','class'=>'form-inline','name'=>'search_staff'));?>
	<h3> Search Staff </h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td><input type="text" class="form-control" placeholder="Staff Role" id="staff_role" name="staff_role"> 
		
		
				<td><input class="btn btn-lg btn-primary btn-block" name="search" value="Search" type="submit" /></td></tr>
	</tbody>
	</table>
	</form>
	<?php if(isset($mode)&&$mode=="search"){    ?>

	<h3 class="col-md-12">List of Staff Roles</h3>
	<div class="col-md-12 ">
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th>Staff Role </th>
	</thead>
	<tbody>
	<?php 
	
	$i=1;
	foreach($staff_role as $a){ ?>
	<?php echo form_open('staff/edit/staff_role',array('id'=>'select_staff_role_form_'.$a->staff_role_id,'role'=>'form')); ?>
	<tr onclick="$('#select_staff_role_form_<?php echo $a->staff_role_id;?>').submit();" >
		<td><?php echo $i++; ?></td>
		<td><?php echo $a->staff_role; ?>
		<input type="hidden" value="<?php echo $a->staff_role_id; ?>" name="staff_role_id" />
		<input type="hidden" value="select" name="select" />
		</td>
			</tr>
	</form>
	<?php } ?>
	</tbody>
	</table>
	<?php } ?>
	</div></div>
