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
$(function(){
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
//create function for  for Excel report 
   function fnExcelReport() { 
       //created a variable named tab_text where  
     var tab_text = '<html xmlns:x="urn:schemas-microsoft-com:office:excel">'; 
     //row and columns arrangements 
     tab_text = tab_text + '<head><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet>'; 
     tab_text = tab_text + '<x:Name>Excel Sheet</x:Name>'; 
  
     tab_text = tab_text + '<x:WorksheetOptions><x:Panes></x:Panes></x:WorksheetOptions></x:ExcelWorksheet>'; 
     tab_text = tab_text + '</x:ExcelWorksheets></x:ExcelWorkbook></xml></head><body>'; 
  
     tab_text = tab_text + "<table border='100px'>"; 
     //id is given which calls the html table 
     tab_text = tab_text + $('#myTable').html(); 
     tab_text = tab_text + '</table></body></html>'; 
     var data_type = 'data:application/vnd.ms-excel'; 
     $('#test').attr('href', data_type + ', ' + encodeURIComponent(tab_text)); 
     //downloaded excel sheet name is given here 
     $('#test').attr('download', 'applicants_detailed.xls'); 
  
 } 

</script>


<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();   
});
</script>
<div class="col-md-12 col-md-offset-2">
    <div class="panel-body">
            <?php echo form_open('staff_applicant/get_applicants_detailed',array('class'=>'form-horizontal','role'=>'form','id'=>'evaluate_applicant')); ?>
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
                'phone' => $applicant->phone.", ".$applicant->phone_alternate,
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
<!--created button which converts html table to Excel sheet--> 
         <a href="#" id="test" onClick="javascript:fnExcelReport();"> 
             <button type="button" class="btn btn-default btn-md excel"> 
                <i class="fa fa-file-excel-o"ara-hidden="true"></i> Export</button></a> 

		<?php if(isset($parameters)) { ?>
		<table class="table table-striped table-bordered" id="table-sort">
		<thead>  
                    <th>SNo</th>
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
                    <th>Total</th>
                    <th>Update</th>
                    </thead>
		<?php
                $i = 1;
		foreach($applicants_info as $applicant){
		?>
		<tr>
                    <td>
                        <?php echo $i++; ?>
                    </td>                        
                        <td>
                            <?php echo $applicant['applicant_name'];?>
			</td>
                        <td>
                            
                           <?php echo $applicant['applicant_id']; ?>
                        </td>
                        <td>
                            <?php echo $applicant['phone']; ?>
                        </td>
                        <?php                         
                        $total=0;
                        foreach($parameters as $parameter){
                            
                        ?>
                        <td>
                            <?php if($parameter->parameter_max_value == 'date'){ 
                                 if(array_key_exists("$parameter->parameter_id",$applicant)) echo $applicant["$parameter->parameter_id"];                                                            
                            } ?>
                            <?php if($parameter->parameter_max_value == 'time'){ 
                                 if(array_key_exists("$parameter->parameter_id",$applicant)) echo $applicant["$parameter->parameter_id"];
                            } ?>
                            <?php if($parameter->parameter_max_value == 'number'){ ?>
                                <?php if(array_key_exists("$parameter->parameter_id",$applicant)){ echo $applicant["$parameter->parameter_id"]; $total+=$applicant["$parameter->parameter_id"];  }
                            } ?>
                            <?php if($parameter->parameter_max_value == 'text'){ ?>
                                <?php if(array_key_exists("$parameter->parameter_id",$applicant)) echo $applicant["$parameter->parameter_id"];                                                                
                            } ?>                                                     
			</td>
                        <?php } ?>			
                        <td> <?php echo $total; ?> </td>
                        <td>
                            <?php echo form_open('staff_applicant/update_applicant',array('id'=>'update_applicant_'.$applicant['applicant_id'],'role'=>'form')); ?>
                            <input type='text' value="<?php echo $applicant['applicant_id']; ?>" id="applicant_id" name="applicant_id" hidden />
                            <input type="submit" class="btn btn-primary" value="Update" />
                            </form>
                        </td>
		
		</tr>
		<?php 
		;
		}
		?>
		</table>

		<table class="table table-striped table-bordered" id="myTable" hidden>
		<thead>  
                    <th class="text-right">SNo</th>
                    <th class="text-right">Name</th>
                    <th class="text-right">ID</th>
                    <th class="text-right">Phone</th>                    
                    <?php 
                        foreach($parameters as $parameter){
                    ?>
                        <th><?php echo $parameter->parameter_label; ?></th>
                    <?php       
                    }
                    ?>
                    <th class="text-right">Total</th>
                    </thead>
		<?php
                $i = 1;
		foreach($applicants_info as $applicant){
		?>
		<tr>	
                    <td class="text-right"><?php echo $i++; ?></td>
                        
                        <td class="text-right">
                            <?php echo $applicant['applicant_name'];?>
			</td>
                        <td class="text-right">
                            <?php echo $applicant['applicant_id']; ?>
                        </td>
                        <td class="text-right">
                            <?php echo $applicant['phone']; ?>
                        </td>
                        <?php 
                        
                        $total=0;
                        foreach($parameters as $parameter){
                            
                        ?>
                        <td class="text-right">
                            <?php if($parameter->parameter_max_value == 'date'){ 
                                 if(array_key_exists("$parameter->parameter_id",$applicant)) echo $applicant["$parameter->parameter_id"];                                                            
                            } ?>
                            <?php if($parameter->parameter_max_value == 'time'){ 
                                 if(array_key_exists("$parameter->parameter_id",$applicant)) echo $applicant["$parameter->parameter_id"];
                            } ?>
                            <?php if($parameter->parameter_max_value == 'number'){ ?>
                                <?php if(array_key_exists("$parameter->parameter_id",$applicant)){ echo $applicant["$parameter->parameter_id"]; $total+=$applicant["$parameter->parameter_id"];  }
                            } ?>
                            <?php if($parameter->parameter_max_value == 'text'){ ?>
                                <?php if(array_key_exists("$parameter->parameter_id",$applicant)) echo $applicant["$parameter->parameter_id"];                                                                
                            } ?>                                                     
			</td>
                        <?php } ?>			
			<td class="text-right"> <?php echo $total; ?></td>
		
		</tr>
		<?php 
		
		}
		?>
		</table>
	
	</div>
    <?php } ?>
</div>       
<?php } ?>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             