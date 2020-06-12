<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.ptTimeSelect.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.widgets.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.colsel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery.tablesorter.print.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/custom/js_functions.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/custom/jquery_form_post.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/custom/common_on_load_functions.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery-ui.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.ptTimeSelect.css">
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/metallic.css" >
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/theme.default.css" >

<script type="text/javascript">
$(document).ready(
    function(){
        $("#from_date,#to_date").Zebra_DatePicker({
            dateFormat:"dd-M-yy",
            changeYear:1,
            changeMonth:1
        });
//    $("#detailed_table").tablesorter(options);
    $('.print').click(function(){
        $('#table-sort').trigger('printTable');
    });
});
</script>
