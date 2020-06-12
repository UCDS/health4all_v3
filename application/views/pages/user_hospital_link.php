<?php 
    //var_dump($hptls);
    //var_dump($user_hptls);
    
    function match_hospital($uh, $hospital_id) {
        foreach($uh as $hptl) {
            if($hospital_id == $hptl->hospital_id) {
                return true;
            }
        }
    }
    if(!!$hptls){ 
?>

<?php 
    echo form_open('user_panel/user_hospital_link',array('role'=>'form','class'=>'',
        'id'=>'create_user')); 
?>
<div class="form-group col-md-12">
    <table class="table table-bordered table-striped" id="table-sort">
        <thead>
            <th colspan="3">Select Hospitals User(<?php echo $user_hptls[0]->username; ?>) Can Access</th>
        </thead>
        <thead>
            <th>#</th>
            <th>Hospital Name</th>
            <th>Description</th>
        </thead>
        <tbody>
        <?php
            $array_size = sizeof($hptls);
            for($j=0; $j < $array_size; $j++){ ?>
            <tr>
                <td><?php echo $j+1; ?></td>
                <td>
                    <label class="control-label">                
                        <input type="checkbox" name="user_hospital[]" value="<?php echo $hptls[$j]->hospital_id;?>" 
                            <?php  echo match_hospital($user_hptls, $hptls[$j]->hospital_id) ? "checked" : ""; ?>                        
                        />
                        <?php echo array_search($hptls[$j]->hospital_id,$user_hptls); ?>
                        <?php echo !!$hptls[$j]->hospital_short_name ? $hptls[$j]->hospital_short_name : $hptls[$j]->hospital; ?>
                    </label>
                </td>
                <td>
                    <?php echo $hptls[$j]->description; ?>
                </td>                
            </tr>
        <?php } ?>
        <tr>
            <td colspan ="4">
                <input type="hidden" value="<?php echo $this->input->post('user_id');?>" name="user_id" />    
	            <input class="btn btn-lg btn-primary btn-block" type="submit" value="Submit" name="submit">	        
            </td>
        </tr>
        </tbody>
    </table>
</div>
<?php echo form_close(); ?>
<?php }else{ ?>
    <div class="col-md-10 col-md-offset-2">
    <h3><?php if(isset($msg)) echo $msg;?></h3>
    <h3 class="col-md-12">List of Users</h3>
    <div class="col-md-12 ">
    </div>	
    <table class="table table-bordered table-striped" id="table-sort">
        <thead>
            <th style="text-align:center">S.no</th>
            <th style="text-align:center">Name</th>
            <th style="text-align:center">Designation</th>            
            <th style="text-align:center">User Name</th>
            <th style="text-align:center">Phone</th>            
        </thead>
    <tbody>
    <?php 
    $i=1;
    
    foreach($user as $a){ ?>
    <tr onclick="$('#select_user_edit_form_<?php echo $a->user_id;?>').submit();" >
        <td>	
            <?php echo form_open('user_panel/user_hospital_link',array('id'=>'select_user_edit_form_'.$a->user_id,'role'=>'form')); ?>
            <?php echo $i++; ?>
        </td>
        <td><?php echo isset($a->first_name) ? $a->first_name : ''.' '.isset($a->last_name) ? $a->last_name: '';  ?></td>
        <td><?php echo $a->designation;?> </td>        
        <td><?php echo $a->username; ?>
            <input type="hidden" value="<?php echo $a->user_id; ?>" name="user_id" />
            <input type="hidden" value="select" name="select" />
        </td>
        <td>
            <?php echo $a->phone;?>
            </form>
        </td>
    </tr>
    <?php } ?>
    </tbody>
</table>
</div>
<?php } ?>

