<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript">
$(document).ready(function(){
		var options = {
			widthFixed : true,
			showProcessing: true,
			headerTemplate : '{content} {icon}', // Add icon for jui theme; new in v2.7!

			widgets: [ 'default', 'zebra', 'print', 'stickyHeaders','filter'],

			widgetOptions: {

		  print_title      : 'table',          // this option > caption > table id > "table"
		  print_dataAttrib : 'data-name', // header attrib containing modified header name
		  print_rows       : 'f',         // (a)ll, (v)isible or (f)iltered
		  print_columns    : 's',         // (a)ll, (v)isible or (s)elected (columnSelector widget)
		  print_extraCSS   : '.table{border:1px solid #ccc;} tr,td{background:white}',          // add any extra css definitions for the popup window here
		  print_styleSheet : '', // add the url of your print stylesheet
		  // callback executed when processing completes - default setting is null
		  print_callback   : function(config, $table, printStyle){
			// do something to the $table (jQuery object of table wrapped in a div)
			// or add to the printStyle string, then...
			// print the table using the following code
			$.tablesorter.printTable.printOutput( config, $table.html(), printStyle );
			},
			// extra class name added to the sticky header row
			  stickyHeaders : '',
			  // number or jquery selector targeting the position:fixed element
			  stickyHeaders_offset : 0,
			  // added to table ID, if it exists
			  stickyHeaders_cloneId : '-sticky',
			  // trigger "resize" event on headers
			  stickyHeaders_addResizeEvent : true,
			  // if false and a caption exist, it won't be included in the sticky header
			  stickyHeaders_includeCaption : false,
			  // The zIndex of the stickyHeaders, allows the user to adjust this to their needs
			  stickyHeaders_zIndex : 2,
			  // jQuery selector or object to attach sticky header to
			  stickyHeaders_attachTo : null,
			  // scroll table top into view after filtering
			  stickyHeaders_filteredToTop: true,

			  // adding zebra striping, using content and default styles - the ui css removes the background from default
			  // even and odd class names included for this demo to allow switching themes
			  zebra   : ["ui-widget-content even", "ui-state-default odd"],
			  // use uitheme widget to apply defauly jquery ui (jui) class names
			  // see the uitheme demo for more details on how to change the class names
			  uitheme : 'jui'
			}
		  };
			$("#table-sort").tablesorter(options);
                        
		  
});
</script>


<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<div class="col-md-12 col-md-offset-2">
    <div class="panel-body">
            <?php echo form_open('staff_applicant/evaluate_applicant',array('class'=>'form-horizontal','role'=>'form','id'=>'evaluate_applicant')); ?>
                <div class="form-group">
                    <select class="form-control" id="drive_id" name="drive_id" required >
                        <option value="">Select Recruitment Drive</option>
                        <?php foreach($recruitment_drives as $drive){
                            echo "<option value='".$drive->drive_id."'>".$drive->name.", ".$drive->place."</option>";
                        }?>
                    </select>
                </div><!-- /input-group -->
                <div class='form-group'>
                    <input type="hidden" name="search" value="search" />
                    <button type="submit"  class="btn btn-primary">Search</button>                
                </div>
            <?php echo form_close(); ?>
            <?php if(isset($message)) { ?>
                &nbsp;&nbsp;&nbsp;
                <div class="alert alert-warning" role="alert">
                 <?php echo $message; ?>
                </div>
            <?php } echo validation_errors(); ?>
    </div>
   
<?php 
    if(isset($applicants)){
?>
<?php    
    $applicant_info = array();
    $applicant_ids_param_ids = array();
    $applicants_info = array();
    $i=0;
    foreach($applicants as $applicant){
        $keys = $applicant->applicant_id;
        if(in_array($keys, $applicant_ids_param_ids)){            
            $applicants_info[$i]["$applicant->parameter_id"]  = $applicant->score;
        }else{            
           $applicant_ids_param_ids[] = $applicant->applicant_id;
            $i++;
            $applicants_info[$i] = array(
                'applicant_name' => $applicant->first_name." ".$applicant->last_name,
                'phone' => $applicant->phone,
                'applicant_id'=> $applicant->applicant_id,
                'drive_id'=>$applicant->drive_id,
                "$applicant->parameter_id" => $applicant->score);
        }
    }
    
?>


<div class="col-md-10 col-sm-9">
	<?php
	if(isset($msg)) {
		echo "<div class='alert alert-info'>$msg</div>";
		echo "<br />";		
	}
	if(validation_errors()){
		echo "<div class='alert alert-danger'>".validation_errors()."</div>";
	}
	
	?>
	<div>
            	<h4>Applicants: </h4>

		
		<table class="table table-striped table-bordered" id="#table-sort">
		<thead>                             
                    <th>Name</th>
                    <th>ID</th>
                    <th>Phone</th>
                    <?php 
                        foreach($parameters as $parameter){
                    ?>
                        <th><div data-toggle="popover" data-placement="bottom"><?php echo $parameter->parameter_label; ?></div></th>
                    <?php       
                    }
                    ?>
                    <th></th>
                    </thead>
		<?php 		
		foreach($applicants_info as $applicant){
		?>
		<tr>
		<?php echo form_open('staff_applicant/evaluate_applicant',array('class'=>'form-horizontal','role'=>'form','id'=>'evaluate_applicant')); ?>
                        <td>                            
                            <input type="hidden" value="<?php echo sizeof($parameters); ?>" size="4" name="parameter_size" />
                            <input type="hidden" value="<?php echo $applicant['drive_id']; ?>" size="4" name="drive_id" />
                            <?php echo $applicant['applicant_name'];?>
			</td>
                        <td>
                            <input type="text" value="<?php echo $applicant['applicant_id']; ?>" size="4" name="applicant_id" readonly />
                        </td>
                        <td>
                            <input type="text" value="<?php echo $applicant['phone']; ?>" name='phone' <?php if($applicant['phone'] != '2147483647' && $applicant['phone'] != '0') echo 'disabled'; ?>  />
                        </td>
                        <?php 
                        $i =1;
                        foreach($parameters as $parameter){
                            
                        ?>
                        <td>
                            <?php if($parameter->parameter_max_value == 'date'){ ?>
                                <input type="date" name="value_<?php echo $applicant['applicant_id']."-".$i;?> " value="<?php if(array_key_exists("$parameter->parameter_id",$applicant)) echo $applicant["$parameter->parameter_id"]; ?>" <?php if(array_key_exists("$parameter->parameter_id",$applicant)) echo "disabled"; ?> min="1979-12-31"><br>
                            <?php 
                                if(!array_key_exists("$parameter->parameter_id",$applicant)){
                            ?>
                                <input type="hidden" name="parameter_<?php echo $applicant['applicant_id']."-".$i; ?>" value="<?php echo $parameter->parameter_id; ?>" />
                            <?php    }
                            ?>
                            <?php 
                                $i++;                                
                            } ?>
                            <?php if($parameter->parameter_max_value == 'time'){ ?>
                                <input type="time" name="value_<?php echo $applicant['applicant_id']."-".$i;?> " value="<?php if(array_key_exists("$parameter->parameter_id",$applicant)) echo $applicant["$parameter->parameter_id"]; ?>" <?php if(array_key_exists("$parameter->parameter_id",$applicant)) echo "disabled"; ?> ><br>
                                <?php 
                                if(!array_key_exists("$parameter->parameter_id",$applicant)){
                            ?>
                                <input type="hidden" name="parameter_<?php echo $applicant['applicant_id']."-".$i; ?>" value="<?php echo $parameter->parameter_id; ?>" />
                            <?php    }
                            ?>
                            <?php 
                                $i++;                              
                            } ?>
                            <?php if($parameter->parameter_max_value == 'number'){ ?>
                                <input type="text" name="value_<?php echo $applicant['applicant_id']."-".$i;?>" value="<?php if(array_key_exists("$parameter->parameter_id",$applicant)) echo $applicant["$parameter->parameter_id"]; ?>" <?php if(array_key_exists("$parameter->parameter_id",$applicant)) echo "disabled"; ?> ><br>
                                <?php 
                                if(!array_key_exists("$parameter->parameter_id",$applicant)){
                            ?>
                                <input type="hidden" name="parameter_<?php echo $applicant['applicant_id']."-".$i; ?>" value="<?php echo $parameter->parameter_id; ?>" />
                            <?php    }
                            ?>
                            <?php 
                                $i++;                                
                            } ?>
                            <?php if($parameter->parameter_max_value == 'text'){ ?>
                                <textarea name="value_<?php echo $applicant['applicant_id']."-".$i;?>" value="<?php if(array_key_exists("$parameter->parameter_id",$applicant)) echo $applicant["$parameter->parameter_id"]; ?>" <?php if(array_key_exists("$parameter->parameter_id",$applicant)) echo "disabled"; ?> ></textarea><br>
                                <?php 
                                if(!array_key_exists("$parameter->parameter_id",$applicant)){
                            ?>
                                <input type="hidden" name="parameter_<?php echo $applicant['applicant_id']."-".$i; ?>" value="<?php echo $parameter->parameter_id; ?>" />
                            <?php    }
                            ?>
                            <?php 
                                $i++;                                
                            } ?>                                                     
			</td>
                        <?php } ?>			
			<td><div class="form-group"><input type="hidden" name="update" value="update" />
                                <input type="submit" class="btn btn-primary" value="update" /></div></td>
		</form>
		</tr>
		<?php 
		$i++;
		}
		?>
		</table>
			
	</div>
    <?php } ?>

</div>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    