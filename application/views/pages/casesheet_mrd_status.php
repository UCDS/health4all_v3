<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >

	
	<div class="row">
            
		<h4>Out-Patient Summary Report</h4>	
		<?php echo form_open("patient/casesheet_mrd_status",array('role'=>'form','class'=>'form-custom')); ?>
                    From IP Number : <input class="form-control" type="text" value="<?php echo $from_ip_number; ?>" name="from_ip_number" placeholder="From IP Number" size="15" />
                    To IP Number : <input class="form-control" type="text" value="<?php echo $to_ip_number; ?>" name="to_ip_number" placeholder="To IP Number" size="15" />
                    <input class="btn btn-sm btn-primary" type="submit" value="Submit" />
		</form>
	<br />
	<?php if(isset($patient_record_status) && count($patient_record_status)>0){ ?>	
        <?php 
            $mrd_status = array();
            
            foreach($patient_record_status as $pr_status){
                $mrd_status["$pr_status->hosp_file_no"] = array(
                    "outcome_date" => $pr_status->outcome_date,
                    "casesheet_at_mrd_date" => $pr_status->casesheet_at_mrd_date,
                    "visit_id" => $pr_status->visit_id
                );
            }
        ?>
		<button type="button" class="btn btn-default btn-md print">
		  <span class="glyphicon glyphicon-print"></span> Print
		</button>
        <table class='table'> 
            <tr>
                <td bgcolor='green'>Data Input Done</td>
            </tr>
            <tr>
                <td bgcolor='yellow'>MRD Date not set</td>
            </tr>
            <tr>
                <td bgcolor='brown'>Outcome Date not set</td>
            </tr>
            <tr>
                <td bgcolor='orange'>MRD and Outcome not set</td>
            </tr>
            <tr>
                <td bgcolor='gray'>Unused Hospital file number</td>
            </tr>              
        </table>
	<table class="table table-bordered table-striped" id="table-sort">
	<thead>
	<tr>
            <?php 
                $j = 1;
                for($i = $from_ip_number; $i<=$to_ip_number; $i++){
                    if($j == 11){
                    ?>
                    <tr>
                    <?php
                     $j = 1;
                    }
                ?>                
                        <td style="text-align:center" bgcolor="<?php 
                        if(array_key_exists($i, $mrd_status))
                        {                             
                            if($mrd_status[$i]['outcome_date'] != '0000-00-00' && $mrd_status[$i]['casesheet_at_mrd_date'] != '0000-00-00')
                            { 
                                echo 'green';                                    
                            }else if($mrd_status[$i]['outcome_date'] != '0000-00-00' && $mrd_status[$i]['casesheet_at_mrd_date'] == '0000-00-00')
                            { 
                                echo 'yellow';                                    
                            }else if($mrd_status[$i]['outcome_date'] == '0000-00-00' && $mrd_status[$i]['casesheet_at_mrd_date'] != '0000-00-00')
                            { 
                                echo 'brown';                                     
                            }else if($mrd_status[$i]['outcome_date'] == '0000-00-00' && $mrd_status[$i]['casesheet_at_mrd_date'] == '0000-00-00'){
                                echo 'orange';
                            }
                        }else
                        { 
                            echo 'gray';
                        } ?>" <?php if(array_key_exists($i, $mrd_status)) { ?> onclick="$('#select_patient_<?php echo $mrd_status[$i]['visit_id'];?>').submit()" <?php } ?> > 
                            <?php if(array_key_exists($i, $mrd_status)) { echo form_open('register/update_patients',array('role'=>'form','id'=>'select_patient_'.$mrd_status[$i]['visit_id']));?>
			<input type="text" class="sr-only" hidden value="<?php echo $mrd_status[$i]['visit_id'];?>" form="select_patient_<?php echo $mrd_status[$i]['visit_id'];?>" name="selected_patient" />
			</form>
                            <?php } echo $i; ?></td>
                    <?php                    
                    if($j == 10) {
                        ?>
                    </tr>    
                        <?php
                    }
                    $j++;
        }
        
                    }
            ?>
		
	<tbody>	
	</table>	
	</div>