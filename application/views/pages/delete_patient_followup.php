<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootbox.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">

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
              // The zIndex of the stickyHeaders, allows the xuser to adjust this to their needs
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
<h3 class="col-md-12">Delete Patient Followup</h3>
  <?php echo form_open("patient/delete_patient_followup",array('role'=>'form','class'=>'form-custom col-md-12')); ?>   
 	   <div class="form-group">     
 	   <label for="patient_id">Patient ID:</label>         
           <input type="text" class="form-control" placeholder="Patient ID" id="patient_id" value="<?php echo $this->input->post('patient_id');?>" name="patient_id" onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))" required>  
            </div>
            <input type="submit" value="Get details" name="submitBtn" class="btn btn-primary btn-sm" />
  </form>

  <div style="margin-top:11%!important;">
    <?php if(isset($patient_followup_history) && count($patient_followup_history)>0){ ?>
    
    <h4 style="margin-left:13px;">Patient Followups</h4>
    <table class="table table-bordered table-striped" id="table-sort" style="margin-left:13px;">
      <thead>
        <th style="text-align:center;">SNo</th>
        <th style="text-align:center;">Patient id</th>
        <th style="text-align:center;">Hospital</th>
        <th style="text-align:center;">Life Status</th>
        <th style="text-align:center;">Name</th>
        <th style="text-align:center;">Age</th>
        <th style="text-align:center;">Gender</th>
        <th style="text-align:center;">Admit date</th>
        <th style="text-align:center;">Actions</th>
      </thead>
      <tbody>
      <?php 
      $sno=1;
      foreach($patient_followup_history as $pfh){ ?> 
      <tr>
        <td style="text-align:center;"><?php echo $sno;?></td>
        <td style="text-align:center;"><?php echo $pfh->patient_id ?></td>
        <td style="text-align:center;"><?php echo $pfh->hname;?></td>
        <td style="text-align:center;"><?php if($pfh->life_status==1){ echo "Alive"; }elseif($pfh->life_status==2){ echo "Not Alive"; }else{ echo "No Followup"; }?></td>
        <td style="text-align:center;"><?php echo $pfh->first_name.' '.$pfh->last_name;?></td>
        <td style="text-align:right;"><?php echo $pfh->age_years;?></td>
        <td style="text-align:center;"><?php if($pfh->gender=='M'){ echo "Male"; }else{ echo "Female"; }?></td>
        <td style="text-align:center;"><?php echo date("j M Y h:i A.", strtotime("$pfh->add_time"));?></td>
        <td style="text-align:center;">
          <a class="btn btn-danger delete-btn" data-patient-id="<?php echo $pfh->patient_id; ?>"
              style="color:white;text-decoration:none!important;">Delete</a>
        </td>	
      </tr>
      <?php $sno++;} ?>
      </tbody>
    </table>
    <?php }else{ echo "No Data Found"; } ?>
  </div>
  <script>
    $(document).on("click", '.delete-btn', function () 
    {
      var patient_id = $(this).data('patient-id'); 
      var conf = confirm('Are you sure you want to delete this entry?');
      if (conf == true) {
        $.ajax({
          type: "POST",
          url: "<?php echo base_url('patient/delete_followup_patient_id'); ?>",
          data: { patient_id: patient_id },
          dataType: 'json',
          success: function (response) 
          {
            //console.log(response);
            alert("Data Deleted Succesfully");
            location.reload();
          },
          error: function (error) {
            console.error("Error:", error);
          }
        });
      } else {
        return false;
      }
    });
  </script>
