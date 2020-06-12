
<center>
		<?php
		echo validation_errors();
		if (isset($msg)){?>
		<div class="alert alert-info">
		<?php echo $msg ?>
		</div>
		<?php } ?>
		
		<h3> Add Item Form</h3>
</center></br>
	<?php 
	echo form_open('consumables/item_form/add_item_form',array('class'=>'form-horizontal','role'=>'form','id'=>'add_item_form')); ?></center>
	
	<div class="col-xs-6 col-md-offset-4">			<!--Item form-->
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-3">
					<div class="form-group">
						<label for="item_form"> Item Form<font style="color:red">*</font></label>
						<input type="text" class="form-control" placeholder="Enter Item Form" id="item_form" name="item_form" required>
					</div>
				</div>
			</div>	
		</div>
	</div>											<!--end of Item form-->
	<div class="container">
		<div class="row">
			<div class="col-md-11">
				<center><button class="btn btn-md btn-primary" type="submit" value="submit">Submit</button></center>
			</div>
		</div>
	</div>