<div class="col-md-8 col-md-offset-2">
	
	<?php
	 if((isset($mode))&&(($mode)=="select")){ ?>
	<center>	<h3>Edit  Staff </h3></center><br>
	<?php echo form_open('staff/edit/staff_category',array('role'=>'form')); ?>
		

		<div class="form-group">
		<label for="staff" class="col-md-4">Staff Category Name<font color='red'>*</font></label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Staff" id="staff_category" name="staff_category" 
		<?php if(isset($staff_category)){
			echo "value='".$staff_category[0]->staff_category."' ";
			} ?>
		
		/>
		<?php if(isset($staff_category)) { ?>
		<input type="hidden" value="<?php echo $staff_category[0]->staff_category_id;?>" name="staff_category_id" />
		
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
	<?php echo form_open('staff/edit/staff_category',array('role'=>'form','id'=>'search_form','class'=>'form-inline','name'=>'search_staff'));?>
	<h3> Search Staff </h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>
		<td><input type="text" class="form-control" placeholder="Staff Category" id="staff_category" name="staff_category"> 
		
		
				<td><input class="btn btn-lg btn-primary btn-block" name="search" value="Search" type="submit" /></td></tr>
	</tbody>
	</table>
	</form>
	<?php if(isset($mode)&&$mode=="search"){    ?>

	<h3 class="col-md-12">List of Staff Categorys</h3>
	<div class="col-md-12 ">
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th>Staff Category </th>
	</thead>
	<tbody>
	<?php 
	
	$i=1;
	foreach($staff_category as $a){ ?>
	<?php echo form_open('staff/edit/staff_category',array('id'=>'select_staff_category_form_'.$a->staff_category_id,'role'=>'form')); ?>
	<tr onclick="$('#select_staff_category_form_<?php echo $a->staff_category_id;?>').submit();" >
		<td><?php echo $i++; ?></td>
		<td><?php echo $a->staff_category; ?>
		<input type="hidden" value="<?php echo $a->staff_category_id; ?>" name="staff_category_id" />
		<input type="hidden" value="select" name="select" />
		</td>
			</tr>
	</form>
	<?php } ?>
	</tbody>
	</table>
	<?php } ?>
	</div></div>
