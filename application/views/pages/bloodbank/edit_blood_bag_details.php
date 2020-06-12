<script>
	$(function(){
            $(document).ready(function() {
                var blood_group = $("#blood_group").val();
                switch(blood_group){
				case 'A+':					
					$('#sub_group').removeClass ('sr-only');
					break;
				case 'A-':
					$('#sub_group').removeClass('sr-only');					
					break;								
				case 'AB+':					
					$('#sub_group').removeClass ('sr-only');					
					break;
				case 'AB-':					
					$('#sub_group').removeClass ('sr-only');
					break;
				case 'O+':					
					$('#sub_group').removeClass ('sr-only');
					break;
				case 'O-':					
					$('#sub_group').removeClass ('sr-only');
					break;
				default:					
					break;
			}
            });
		var anti_a,anti_b,anti_ab,anti_d,a_cells,b_cells,o_cells,du;
		$(".blood_group").on('change',function(){
			var donation_id=$(this).attr('id').substring(12);
			switch($(this).val()){
				case 'A+':
					anti_a='+';
					anti_b='-';
					anti_ab='+';
					anti_d='+';
					a_cells='-';
					b_cells='+';
					o_cells='-';
					du='+';
					$('#sub_group').removeClass ('sr-only');
					break;
				case 'A-':
					anti_a='+';
					anti_b='-';
					anti_ab='+';
					anti_d='-';
					a_cells='-';
					b_cells='+';
					o_cells='-';
					$('#sub_group').removeClass('sr-only');
					du='-';
					break;
				case 'B+':
					anti_a='-';
					anti_b='+';
					anti_ab='+';
					anti_d='+';
					a_cells='+';
					b_cells='-';
					o_cells='-';
					du='+';
					$('#sub_group').addClass('sr-only');
					break;
				case 'B-':
					anti_a='-';
					anti_b='+';
					anti_ab='+';
					anti_d='-';
					a_cells='+';
					b_cells='-';
					o_cells='-';
					du='-';
					$('#sub_group').addClass('sr-only');
					break;
				case 'AB+':
					anti_a='+';
					anti_b='+';
					anti_ab='+';
					anti_d='+';
					a_cells='-';
					b_cells='-';
					o_cells='-';
					$('#sub_group').removeClass ('sr-only');
					du='+';
					break;
				case 'AB-':
					anti_a='+';
					anti_b='+';
					anti_ab='+';
					anti_d='-';
					a_cells='-';
					b_cells='-';
					o_cells='-';
					du='-';
					$('#sub_group').removeClass ('sr-only');
					break;
				case 'O+':
					anti_a='-';
					anti_b='-';
					anti_ab='-';
					anti_d='+';
					a_cells='+';
					b_cells='+';
					o_cells='-';
					du='+';
					$('#sub_group').removeClass ('sr-only');
					break;
				case 'O-':
					anti_a='-';
					anti_b='-';
					anti_ab='-';
					anti_d='-';
					a_cells='+';
					b_cells='+';
					o_cells='-';
					du='-';
					$('#sub_group').removeClass ('sr-only');
					break;
				default:
					alert('error');
					break;
			}
		set_defaults(donation_id);	
		});
		function set_defaults(donation_id){
			$('#anti_a').val(anti_a);
			$('#anti_b').val(anti_b);
			$('#anti_ab').val(anti_ab);
			$('#anti_d').val(anti_d);
			$('#a_cells').val(a_cells);
			$('#b_cells').val(b_cells);
			$('#o_cells').val(o_cells);
			$('#du').val(du);
		}
		
	});
</script>
<div class="col-md-10 col-sm-9">
<div class="panel panel-primary">    
    <?php if(isset($donation) && $donation->status_id >= 3){ ?> 
        <div class="panel-heading">
            <h3 class="panel-title">Edit Blood Bag details, Donor: <?php echo $donation->name;?></h3>
        </div>
        <div class="panel-body">
            <table class="table-2 table table-striped table-bordered" id="table-1">
		<thead>
                    <th><div data-toggle="popover" data-placement="bottom" data-content="Please enter  Blood group">																  
                    Blood Group</div></th>

                    <th><div data-toggle="popover" data-placement="bottom" data-content="Please enter  Blood Unit">																  
                    Blood Unit</div></th>

                    <th><div data-toggle="popover" data-placement="bottom" data-content="Please enter  Segment Number">																  
                    Segment</div></th>

                    <th><div data-toggle="popover" data-placement="bottom" data-content="Please enter  Bag Type">																  
                    Bag Type</div></th>

                    <th><div data-toggle="popover" data-placement="bottom" data-content="Please enter  Bag Volume">
                    Volume</div></th>
                    
                </thead>
		<tr>
		<?php echo form_open('bloodbank/donation/update_blood_bag_info',array('class'=>'form-inline')); ?>

			<input type="text" value="<?php echo $donation->donation_id; ?>" name="donation_id" hidden />
			
			<td><div class="form-group">
			<?php echo $donation->blood_group; ?>
			</div></td>
			<td><div class="form-group"><input type="number" class="form-control" name="blood_unit_num" value="<?php echo $donation->blood_unit_num; ?>" required /></div></td>
			<td><div class="form-group"><input type="text" class="form-control" name="segment_num" value="<?php echo $donation->segment_num; ?>" required /></div></td>
			<td>
			<div class="form-group">
				<select name="bag_type" style="width:100px" class="form-control" required >
				<option value="" disabled>Bag</option>
				<option value="1" <?php if($donation->bag_type == "1") echo "selected";?> >Single</option>
				<option value="2" <?php if($donation->bag_type == "2") echo "selected";?> >Double</option>
				<option value="3" <?php if($donation->bag_type == "3") echo "selected";?> >Triple</option>
				<option value="4" <?php if($donation->bag_type == "4") echo "selected";?> >Quadruple</option>
				<option value="5" <?php if($donation->bag_type == "5") echo "selected";?> >Quadruple-Sagm</option>
				</select>
			</div>
                        </td>
                        <td>
			<div class="form-group">
			<select name="volume" class="form-control" required >
			<option value="" disabled>Vol</option>
			<option value="350" <?php if($donation->volume == "350") echo "selected";?> >350ml</option>
			<option value="450" <?php if($donation->volume == "450") echo "selected";?> >450ml</option>
			</select></div></td>			                        
		</tr>
                <tr>
                    <td colspan="5">
                        <select name="camp_id" id="camp_id" class="form-control" >
                            <option value="">--Select Location--</option>
                            <?php                            
                            foreach($camps as $camp){
                                    $option = "<option size='30' value='";
                                    $option .= $camp->camp_id."'";
                                    if($camp->camp_id == $donation->camp_id){
                                        $option .= " selected ";
                                    }
                                    echo $option.">".$camp->camp_name.", ".$camp->location."</option>";
                                    $option = '';
                            ?>                                    
                            <?php
                            }
                            ?>
			</select>
			
                    </td>
                </tr>
                <tr>
                    <td colspan="1">Collected By:</td>
                    <td colspan="4">
                        <?php 
                        $collected_by = '';
                        foreach($staff as $s){
                            if($s->staff_id == $donation->collected_by){
                                $collected_by = $s->first_name." ".$s->last_name." ".$s->name;
                            }
                        } ?>
                        <input type="text" name="grouping_date" placeholder="Staff Name" class="form-control" id="grouping_date" value="<?php echo $collected_by; ?>" form='grouping_form' readonly />
                    </td>
                </tr>
                <tr>
                    <td colspan="1">Donation Date: </td>
                    <td colspan="3"><input type="text" name="grouping_date" placeholder="Date" class="form-control" id="grouping_date" value="<?php echo $donation->donation_date.'/'.$donation->donation_time; ?>" form='grouping_form' readonly /></td>
                    <td colspan="1"><input type="submit" class="btn btn-primary" value="Update" /></td>
                </tr>
		<?php 
		
		?>
            </table>
           
            <?php echo form_close(); ?>
        </div>
        <?php if($donation->status_id > 4){ ?>
        <div class="panel-heading">
            <h3 class="panel-title">Edit Blood Grouping Details, Donor: <?php echo $donation->name;?></h3>
        </div>
        <div class="panel-body"> <!-- Begining of change blood group -->          
          <?php echo form_open('bloodbank/donation/change_group',array('class'=>'form-inline')); ?>
            <table class="table-2 table table-striped table-bordered" id="table-1">
		<thead>
			<th>Blood Unit No.</th>
			<th>Blood Group</th>
			<th>Anti A</th>
			<th>Anti B</th>
			<th>Anti AB</th>
			<th>Anti D</th>
			<th>A Cells</th>
			<th>B Cells</th>
			<th>O Cells</th>
			<th>Du</th>
			
		</thead>
		<tr>
			
			<td>
                            <?php echo $donation->blood_unit_num;?>
                            <input type="text" value="<?php echo $donation->donation_id; ?>" name="donation_id" hidden />
			</td>
		<td style="min-width:120px">
			<select name="blood_group" id="blood_group"  class="blood_group form-control">
			<option value="" disabled>-------</option>
			<option value="A+" <?php if($donation->blood_group == 'A+') echo "selected" ?> >A+</option>
			<option value="B+" <?php if($donation->blood_group == 'B+') echo "selected" ?> >B+</option>
			<option value="O+" <?php if($donation->blood_group == 'O+') echo "selected" ?> >O+</option>
			<option value="AB+"  <?php if($donation->blood_group == 'AB+') echo "selected" ?> >AB+</option>
			<option value="A-" <?php if($donation->blood_group == 'A-') echo "selected" ?> >A-</option>
			<option value="B-" <?php if($donation->blood_group == 'B-') echo "selected" ?> >B-</option>
			<option value="O-" <?php if($donation->blood_group == 'O-') echo "selected" ?> >O-</option>
			<option value="AB-" <?php if($donation->blood_group == 'AB-') echo "selected" ?> >AB-</option>
			</select>
			<select name="sub_group" style="min-width:150px" class="form-control sr-only" id="sub_group">
			<option value="" >Sub Group</option>
			<option value="A1" <?php if($donation->sub_group == 'A1') echo "selected" ?> >A1</option>
			<option value="A2" <?php if($donation->sub_group == 'A2') echo "selected" ?> >A2</option>
			<option value="A1B" <?php if($donation->sub_group == 'A1B') echo "selected" ?> >A1B</option>
			<option value="A2B" <?php if($donation->sub_group == 'A2B') echo "selected" ?> >A2B</option>
			<option value="Oh" <?php if($donation->sub_group == 'Oh') echo "selected" ?> >Oh</option>
			</select>
		</td>
                        <td><div class="form-group"><input type='text' name='anti_a' class="form-control" id='anti_a' value='<?php echo $donation->anti_a ?>' /></div></td>
			<td><div class="form-group"><input type='text' class="form-control" name='anti_b' id='anti_b' value='<?php echo $donation->anti_b ?>' /></div></td>
			<td><div class="form-group"><input type='text' class="form-control" name='anti_ab' id='anti_ab' value='<?php echo $donation->anti_ab ?>' /></div></td>
			<td><div class="form-group"><input type='text' class="form-control" name='anti_d' id='anti_d' value='<?php echo $donation->anti_d ?>' /></div></td>
			<td><div class="form-group"><input type='text' class="form-control" name='a_cells' id='a_cells' value='<?php echo $donation->a_cells ?>' /></div></td>
			<td><div class="form-group"><input type='text' class="form-control" name='b_cells' id='b_cells' value='<?php echo $donation->b_cells ?>' /></div></td>
			<td><div class="form-group"><input type='text' class="form-control" name='o_cells' id='o_cells' value='<?php echo $donation->o_cells ?>' /></div></td>
			<td><div class="form-group"><input type='text' class="form-control" name='du' id='du' value='<?php echo $donation->du ?>' /></div></td>
			
			
		</tr>
		<tr>		
		<td colspan="10">	
			<div class="form-group col-lg-3">
				Forward by: 
				<?php
                                $forward_done_by ='';
                                foreach($staff as $s){                                    
                                    if($donation->forward_done_by == $s->staff_id){
                                        $forward_done_by = $s->first_name." ".$s->last_name." ".$s->name;
                                    }                                    
				}
                                
				?>
                                <input type="text" name="grouping_date" placeholder="Staff Name" class="form-control" id="grouping_date" value="<?php echo $forward_done_by; ?>" form='grouping_form' readonly />
			</div>
                </td>
                </tr>
                <tr>
                <td colspan="10">
			<div class="form-group col-lg-3">
                            Reverse by: 
				<?php   
                                $reverse_done_by = '';
                                foreach($staff as $s){                                   
                                    if($donation->reverse_done_by == $s->staff_id){
                                        $reverse_done_by = $s->first_name." ".$s->last_name." ".$s->name;
                                    }                                    
				}
                                
				?>
                            <input type="text" name="grouping_date" placeholder="Staff Name" class="form-control" id="grouping_date" value="<?php echo $reverse_done_by; ?>" form='grouping_form' readonly />
                        </div>
                </tr>
                <tr>
                <td colspan="5">                     
                    <div class="form-group">Grouping Date<input type="text" name="grouping_date" placeholder="Grouping Date" class="form-control" id="grouping_date" value="<?php echo $donation->grouping_date; ?>" form='grouping_form' readonly /></div>
                </td>
                <td colspan="5">
	<div class="form-group text-right"><input type="submit" class="btn btn-primary" name="Update" value="Update" /></div>
		</td></tr>
		<?php echo form_close(); ?>
        </table>   <!-- End of change bloodgroup --> 
        </div>
        <?php } ?>
        <?php if($donation->status_id > 5) { ?>
        <div class="panel-heading">
            <h3 class="panel-title">Edit Blood Screening details, Donor: <?php echo $donation->name;?></h3>
        </div>
        <div class="panel-body"> <!-- Beginning of change_screening_result -->
             <?php echo form_open('bloodbank/donation/change_screening_result',array('class'=>'form-inline')); ?>
            <div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="">Alert:</span>
                            <ul>
                                <li>
                                    Please select the check mark against a condition only if the sample tests positive. 
                                    If every condition is negative select only Tested and click on update.
                                </li>
                                <li>
                                    Only Blood bags that clear screening will be shown in inventory.
                                </li>                                
                            </ul>
                    
                </div>
		<h4>Sample : </h4>

		<table id="header-fixed" class="table-2 table table-striped table-bordered"></table>
		<table class="table-2 table table-striped table-bordered" id="table-1">
		<thead>
			
			<th><div data-toggle="popover" data-placement="bottom" data-content="Blood Unit No.">
																  
				Blood Unit No.</div></th>
			<th><div data-toggle="popover" data-placement="bottom" data-content="Human Immunodeficiency Virus">
																  
				HIV</div></th>	
			<th><div data-toggle="popover" data-placement="bottom" data-content="Hepatitis B Surface Antigen">
																  
				HBSAG</div></th>
			<th><div data-toggle="popover" data-placement="bottom" data-content="Hepatitis C Virus">
																  
				HCV</div></th>
			<th><div data-toggle="popover" data-placement="bottom" data-content="Venereal Disease Research Laboratory">
																  
				VDRL</div></th>
			<th><div data-toggle="popover" data-placement="bottom" data-content=" Metabolic panel">
																  
				MP</div></th> 
			<th>
                            <div data-toggle="popover" data-placement="bottom" data-content=" Irregular Antibody Screening">																  
				Irregular AB</div></th>
			<th>Tested</th>
		</thead>
		<?php 
		
		echo form_open('bloodbank/inventory/screening',array('id'=>'screening_form'));
		
		?>
		<tr>                    
                    <td><?php echo $donation->blood_unit_num;?></td>
                    <td><input type="checkbox" name="test_hiv" value="1" <?php if($donation->test_hiv == 1) echo "checked='checked'"; ?> /></td>
                    <td><input type="checkbox" name="test_hbsag" value="1" <?php if($donation->test_hbsag == 1) echo "checked='checked'"; ?> /></td>
                    <td><input type="checkbox" name="test_hcv" value="1"  <?php if($donation->test_hcv == 1) echo "checked='checked'"; ?> /></td>
                    <td><input type="checkbox" name="test_vdrl" value="1"  <?php if($donation->test_vdrl == 1) echo "checked='checked'"; ?> /></td>
                    <td><input type="checkbox" name="test_mp" value="1"  <?php if($donation->test_mp == 1) echo "checked='checked'"; ?> /></td>
                    <td><input type="checkbox" name="test_irregular_ab" value="1"  <?php if($donation->test_irregular_ab == 1) echo "checked='checked'"; ?> /></td>
                    <td><input type="checkbox" name="donation_id" value="<?php echo $donation->donation_id;?>" /></td>
                </tr>
		
		<tr>
                    <td colspan="3" align="right">
                        <div class="form-group col-lg-8">
                            <?php $screening_done_by =''; 
                                foreach($staff as $s){
                                    if($donation->screened_by == $s->staff_id){
                                        $screening_done_by = $s->first_name." ".$s->last_name." ".$s->name;
                                    }
                                }
                            ?>
                            <input type="text" name="grouping_date" placeholder="Staff Name" class="form-control" id="grouping_date" value="<?php echo $screening_done_by; ?>" form='grouping_form' readonly />
                        </div>
                    </td>
                    <td colspan="3" align="right">
                        <div class="form-group col-lg-7"><input type="text" name="screened_date" class="form-control" placeholder="Screened Date" form='screening_form' id="screened_date" value="<?php echo $donation->screening_datetime; ?>" readonly/></div>
                    </td>
                    <td colspan="3" align="right">
                        <div class="form-group"><input type="submit"  class="btn btn-primary" name="submit" value="Update"  /></div>
                    </td>
		</tr>
		</table><?php echo form_close(); ?>
        </div> <!-- End of change_screening_result -->
        <?php } ?>
        <div class="panel-heading">
            <h3 class="panel-title">Revert to component Preparation, Donor: <?php echo $donation->name;?></h3>
        </div>
        <div class="panel-body">
            <?php echo form_open('bloodbank/donation/revert_to_component_preparation',array('class'=>'form-inline')); ?>
                <div class="form-group">
                    
                    <div class="form-group">
                        <label>Please input bag volume: &nbsp;</label>
			<select name="volume" class="form-control" required >
			<option value="" disabled>Vol</option>
			<option value="350" <?php if($donation->volume == "350") echo "selected";?> >350ml</option>
			<option value="450" <?php if($donation->volume == "450") echo "selected";?> >450ml</option>
			</select>
                    </div>
                    <input type="submit"  class="btn btn-primary" name="submit" value="Revert to Component Preparation"  />
                    <input type="text" value="<?php echo $donation->donation_id; ?>" name="donation_id" hidden />
                </div>
            <?php echo form_close(); ?>
        </div>
    <?php }?>
        <div class="panel-heading">
            <h3 class="panel-title">Search for Blood bag</h3>
        </div>
        <div class="panel-body">
            <?php echo form_open('bloodbank/donation/get_donation',array('class'=>'form-inline')); ?>
                <div class="form-group">
                    <input type="text" name ="blood_unit_num" class="form-control" placeholder="Search for Blood Unit Number" required>                    
                </div><!-- /input-group -->
                <div class='form-group'>
                    <button type="submit" class="btn btn-primary">Search</button>                
                </div>
            <?php echo form_close(); ?>
            <?php if(isset($message)) { ?>
                &nbsp;&nbsp;&nbsp;
                <div class="alert alert-warning" role="alert">
                 <?php echo $message; ?>
                </div>
            <?php } echo validation_errors(); ?>
        </div>
   
</div>
</div>