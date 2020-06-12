<div class="col-md-8 col-md-offset-2">
<?php if((isset($mode))&&(($mode)=="select")){ ?>
<center><h3>Edit Test Method </h3></center><br>
<?php echo form_open('diagnostics/edit/test_method',array('role'=>'form')); ?>
<div class="form-group">
<label for="test_method" class="col-md-4">Test Method<font color='red'>*</font></label>
<div class="col-md-8">
<input type="text" class="form-control" placeholder="Test Method" id="test_method" name="test_method"
<?php if(isset($test_methods)){
echo "value='".$test_methods[0]->test_method."' ";
}
?>
/>
<?php if(isset($test_methods)) { ?>
<input type="hidden" value="<?php echo $test_methods[0]->test_method_id;?>" name="test_method_id" />
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
<?php echo form_open('diagnostics/edit/test_method',array('role'=>'form','id'=>'test_type_form','class'=>'form-inline','name'=>'search_test_type'));?>
<h3> Search Test Method </h3>
<table class="table-bordered col-md-12">
<tbody>
<tr>
<td><input type="text" class="form-control" placeholder="Test Method" id="test_method" name="test_method">
<td><input class="btn btn-lg btn-primary btn-block" name="search" id="search" value="Search" type="submit" /></td>
</tr>
</tbody>
</table>
</form>
<?php if(isset($mode) && $mode=="search"){ ?>

<h3 class="col-md-12">List of Test Method Types </h3>
<div class="col-md-12 ">
</div>
<table class="table-hover table-bordered table-striped col-md-10">
<thead>
<th>S.No</th><th> Test Methods </th>
</thead>
<tbody>
<?php
$j=1;
foreach($test_methods as $tt){ ?>

<?php echo form_open('diagnostics/edit/test_method',array('id'=>'test_method_form_'.$tt->test_method_id,'role'=>'form')); ?>
<tr onclick="$('#test_method_form_<?php echo $tt->test_method_id;?>').submit();" >
<td><?php echo $j++; ?></td>
<td><?php echo $tt->test_method; ?>
<input type="hidden" value="<?php echo $tt->test_method_id; ?>" name="test_method_id"/>
<input type="hidden" value="select" name="select" />
</td>
</tr>
</form>
<?php } ?>
</tbody>
</table>
<?php } ?>
</div>
</div>