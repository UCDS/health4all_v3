<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/zebra_datepicker.js"></script>

<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >


<style>
    .call_now_img{
        width: 30px;
        cursor: pointer;
        padding-top: 5px;
    }
</style>

<script type="text/javascript">
$(function(){
    $(".date").Zebra_DatePicker();
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


<div class="col-md-12">
    <?php if(isset($receivers_exists_msg)) { ?>
        <div class="col-md-12 alert alert-danger"><?php echo $receivers_exists_msg; ?></div>
    <?php } else { ?>
        <h3 class="col-md-12">List of Receivers <a href="<?php echo base_url()."helpline/helpline_receivers_form";?>" class="btn btn-primary">Add</a></h3>
    <?php }?>
    <div class="col-md-12 "></div>	
    <table class="table table-bordered table-striped" id="table-sort">
        <thead>
            <th style="text-align:center">S.no</th>
            <th style="text-align:center">Name</th>
            <th style="text-align:center">Phone</th>            
            <th style="text-align:center">Email</th>
            <th style="text-align:center">Category</th>
            <th style="text-align:center">User</th>      
            <th style="text-align:center">Doctor</th>      
            <th style="text-align:center">OutBound</th>    
            <th style="text-align:center">App ID</th>  
            <th style="text-align:center">Helpline</th>  
            <th style="text-align:center">Activity Status</th>
            <th style="text-align:center">Action</th>            
        </thead>
    <tbody>
    <?php 
    $i=1;
    
    foreach($receivers as $a){ ?>
    <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo $a->full_name;  ?></td>
        <td><?php echo $a->phone;?> </td>        
        <td><?php echo $a->email; ?></td>
        <td><?php echo $a->category; ?></td>
        <td>
            <?php echo $a->user_id ? 'Yes': 'No';?>
        </td>
        <td>
            <?php echo $a->doctor == 1 ? 'Yes': 'No';?>
        </td>
        <td>
            <?php echo $a->enable_outbound == 1 ? 'Yes': 'No';?>
        </td>
        <td><?php echo $a->app_id; ?></td>
        <td><?php echo $a->helpline; ?></td>
        <td>
            <?php echo $a->activity_status == 1 ? 'Yes': 'No';?>
        </td>
        <td><a href="<?php echo base_url()."helpline/helpline_receivers_form/".$a->receiver_id;?>" class="btn btn-primary">Edit</a></td>
    </tr>
    <?php } ?>
    </tbody>
</table>
</div>

