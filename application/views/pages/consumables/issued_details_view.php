

<script type='text/javascript'>
$(window).load(function(){<!--from   w  w  w.  ja v a 2s.  c  om-->
$(function () {
    $("table#bootstrap_git_demo").on("click", ".remove", function () {
        $(this).closest('tr').remove();
    });
});
$(function () {
    $(".show_tip").tooltip({
        container: 'body'
    });
});
$(document).click(function () {
    $('.tooltip').remove();
    $('[title]').tooltip();
  });
});
</script>
<div class="col-xs-1 col-md-offset-1">
    <div class="container">
	<div class="row">
    <div class="col-md-10">
	<div class="panel panel-success">
        <div class="panel-heading" ><center>    
		<h3> Indent </h3><!-- Heading -->
		<?php foreach($indent_issued as $all_int) { ?>
		<p class="panel-title">Indent ID : <?php echo $all_int->indent_id;?>     &nbsp;&nbsp;&nbsp;      Date : <?php echo date("d-M-Y g:i A", strtotime($all_int->approve_date_time)); ?> </p>
		<?php  break; } ?>
		</center>
        </div> 
	</div> 
	</div>
	</div>
	</div>
    <?php echo form_open('consumables/indent_issue/indent_issued',array('class'=>'form-custom','role'=>'form'))?><!-- Issued details from open -->
			<div class="container">
            	<div class="row" >
			 		<div class = "col-md-4">
						<div class="form-group"><!-- From label-->
						    <b>	From :</b>
								<?php echo  $all_int->from_party; ?>
						</div><!-- End of from label-->
					</div>
					<div class = "col-md-4">
						<div class="form-group"><!-- To label-->
							<b>To :</b>
							<?php echo $all_int->to_party; ?>
						</div><!-- End of to label -->
					</div>
				</div>
				<div class="row" >
					<div class="col-md-10">
						<table class="table table-bordered table-striped"  id="bootstrap_git_demo">
							<thead>
							    <th><center>#</center></th>
								<th><center>Item Name</center></th>
								<th><center>Quantity Approved</center></th>
								<th><center>Quantity Issued</center></th>
							</thead>
				           <tbody>
					            <?php
					                $j=1;
					               foreach($indent_issued as $all_int)
					               {
					               ?>
					               <tr>
								   <div class="form-group">
								    <td align="center"><?php  echo $j++;
									    ?> </td>
									</div>
					                <div class="form-group"> 
					                      <td align="left"><?php echo  $all_int->item_name."-".$all_int->item_type."-".$all_int->item_form."-".$all_int->dosage.$all_int->dosage_unit ;?></td>
					                </div>
					                <div class="form-group">
					                      <td align="right"><?php echo $all_int->quantity_approved;?></td>
					                </div>
					                <div class="form-group">
					                      <td align="right"><input type="number" class="form-control" min="1"  step="1"  name="quantity_issued_<?= $all_int->indent_item_id;?>" id="quantity_id" value="<?php echo $all_int->quantity_approved;?>" placeholder="Enter Quantity " required>
                                           <input type="hidden" value="<?= $all_int->indent_item_id;?>" class="sr-only" name="indent_item[]" />
					                      </td>
					                </div>
                             <?php   } ?> 
								 </tr> 
		              </tbody>
		         </table>
		     </div>
		   </div>
		   </div>
        <div class="container">
		   <div class="row">
			<div class="col-md-10">
				<div class="panel-heading"><p class="panel-title">
					<center>
                        
						<input type="hidden" value="<?= $indent_issued[0]->indent_id;?>" class="sr-only" name="indent" /> 
						<Button type="submit" name="issue" value="submit" id="btn" class="btn btn-success">issued</Button>
						<input type="hidden" name="selected_indent_id" value="<?php echo $all_int->indent_id;?>"/>
						</center></p>
				</div>
			</div>
		</div>
	  </div>
	  <?php echo form_close();?><!-- End of Issued details form -->
    </div>


