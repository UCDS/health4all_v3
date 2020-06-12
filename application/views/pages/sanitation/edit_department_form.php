	
	<?php if(isset($mode)&& $mode=="select"){ ?>
	<center>	<h3><u>Edit Department</u></h3></center><br>
	<?php echo form_open('masters/edit/department',array('role'=>'form')); ?>





		<div class="form-group">
		<label for="agency_name" class="col-md-4">department Name</label>
		<div  class="col-md-8">
		<input type="text" class="form-control" placeholder="Department Name" id="department_name" name="department_name" 
		<?php if(isset($department)){
			echo "value='".$department[0]->department_name."' ";
			}
		?>
		/>
		<?php if(isset($department)){ ?>
		<input type="hidden" value="<?php echo $department[0]->department_id;?>" name="department_id" />
		
	 <?php } ?>
		</div>
	</div>

			
	
	</div></div>
   		<div class="col-md-3 col-md-offset-4"><div  class="col-md-8">
	<input class="btn btn-lg btn-primary btn-block" type="submit" value="Update" name="update">
	</div></div>
	
   	</form>
	<?php } ?>
	<h3><?php if(isset($msg)) echo $msg;?></h3>	
	<div class="col-md-12">
	<?php echo form_open('masters/edit/department',array('role'=>'form','id'=>'search_form','class'=>'form-inline','name'=>'search_department'));?>
	<h3> Search Department </h3>
	<table class="table-bordered col-md-12">
	<tbody>
	<tr>

		<td>
<input type="text" class="form-control" placeholder="Department Name" id="department_name" name="department_name" >
		
<!--	<select name="department_name" id="search_department_name" form='search_form' class="form-control" style="width:180px">
		<option value="" disabled selected>Department</option>
		<?php foreach($department as $department_name){
	echo "<option value='$department_name->department_id'>$department_name->department_name</option>";
		}
		?>
		</select>--></td>		
		   	<div class="col-md-3 col-md-offset-4"><div class="col-md-8">

		<td><input class="btn btn-lg btn-primary btn-block" name="search" value="Search" type="submit" /></td></tr>
	</tbody>
	</table>
	</form>
	<?php if(isset($mode) && $mode=="search"){ ?>

	<h3 class="col-md-12">List of Department</h3>
	<div class="col-md-12 "><strong>
	<?php if($this->input->post('department_name')) echo "department name starting with : ".$this->input->post('department_name'); ?>
	</strong>
	</div>	
	<table class="table-hover table-bordered table-striped col-md-10">
	<thead>
	<th>S.No</th><th>Department Name </th><th>
	</thead>
	<?php 
	$i=1;
	foreach($department as $a){ ?>
	<?php echo form_open('masters/edit/department',array('id'=>'select_department_form_'.$a->department_id,'role'=>'form')); ?>
	<tr onclick="$('#select_department_form_<?php echo $a->department_id;?>').submit();" >
		<td><?php echo $i++; ?></td>
		<td><?php echo $a->department_name; ?>
		<input type="hidden" value="<?php echo $a->department_id; ?>" name="department_id" />
		<input type="hidden" value="select" name="select" />
		</td>
		<td><?php echo $a->department_name; ?></td>
		
			</tr>
	</form>
	<?php } ?>
	</tbody>
	</table>
	<?php } ?>
	</div></div>