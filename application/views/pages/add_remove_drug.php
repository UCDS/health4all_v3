<div class="row">
<div class="col-md-2 col-sm-2">&nbsp;</div>
<div class="col-md-8 col-sm-7">
<?php
	if(isset($msg)) {
		echo $msg;
		echo "<br />";
		echo "<br />";
	}
?>
</div>
</div>
<?php echo form_open("hospital/drugs_available",array('role'=>'form','class'=>'form-custom')); ?> 
<div class="row">
<div class="col-md-2 col-sm-2">&nbsp;</div>
<div class="col-md-8 col-sm-7">
<select name="generic_item_id" id="generic_item_id" class="form-control" >
    <option value="">Generic Drug Name</option>
    <?php 
    foreach($generic_drugs as $gen_m){
        echo "<option value='".$gen_m->generic_item_id."'>".$gen_m->generic_name.' - '.$gen_m->item_form."</option>";
    }
    ?>
</select>
<input class="form-control" type="hidden" value="form_submit" name="form_submit" />
<br/>
<input class="btn btn-sm btn-primary pull-right" type="submit" value="Add Drug" />
</div>
</div>
</form>
<div class="row">
<div class="col-md-2 col-sm-2">&nbsp;</div>
<div class="col-md-8 col-sm-7">
	<div>
		<h3>Drugs Available: </h3>
		<table class="table-2 table table-striped table-bordered">
			<tr>
                <th>S.No</th>
				<th>Drug Type</th>
                <th>Generic Name</th>                
                <th>Drug Form</th>
                <th></th>
            </tr>
		<?php 
		$i=1;
		if(isset($hospital_drugs) && !empty($hospital_drugs)){
		foreach($hospital_drugs as $drug){
		?>
		<tr>
			<td><?php echo $i;?></td>
			<td><?php echo $drug->drug_type;?></td>
			<td><?php echo $drug->generic_name;?></td>			
			<td><?php echo $drug->item_form;?></td>
			<td>
                <?php echo form_open("hospital/delete_drug",array('role'=>'form','class'=>'form-custom')); ?> 
                <input class="form-control" type="hidden" value="<?php echo $drug->drug_avl_id; ?>" name="drug_avl_id" />
				<input class="form-control" type="hidden" value="form_submit" name="form_submit" />
                <input class="btn btn-sm btn-danger" type="submit" value="Remove" />
                </form>
            </td>
		</tr>
		<?php 
		$i++;
		}}
		?>
		</table>
	</div>
</div>
</div>