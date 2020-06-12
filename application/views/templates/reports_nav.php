  <link href="<?php echo base_url();?>assets/css/simple-sidebar.css" rel="stylesheet">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                
	<!--	<li <?php if(current_url()==base_url()."bloodbank/user_panel/appointment_bookings"){ echo "class='active'";}?>><a href='<?php echo base_url();?>bloodbank/user_panel/appointment_bookings'><i class="fa fa-newspaper-o  " style="color:#E84F4F"></i> Appointment Report</a></li>  -->
<li <?php if(current_url()==base_url()."bloodbank/register"){ echo "class='active'";}?>><a href="<?php echo base_url();?>bloodbank/register"><i class="fa fa-user " style="color:#E84F4F"></i>  Back to Bloodbank</a></li>
		<li <?php if(current_url()==base_url()."bloodbank/user_panel/donation_summary"){ echo "class='active'";}?>><a href='<?php echo base_url();?>bloodbank/user_panel/donation_summary'><i class="fa fa-file-text " style="color:#E84F4F"></i> Donations Summary</a></li> 
		<li <?php if(current_url()==base_url()."bloodbank/user_panel/report_donations"){ echo "class='active'";}?>><a href='<?php echo base_url();?>bloodbank/user_panel/report_donations'><i class="fa fa-spinner " style="color:#E84F4F"></i> Donations Detailed</a></li> 
		<li <?php if(current_url()==base_url()."bloodbank/user_panel/issue_summary"){ echo "class='active'";}?>><a href='<?php echo base_url();?>bloodbank/user_panel/issue_summary'><i class="fa fa-clipboard " style="color:#E84F4F"></i> Issue Summary</a></li> 
		<li <?php if(current_url()==base_url()."bloodbank/user_panel/hospital_issues"){ echo "class='active'";}?>><a href='<?php echo base_url();?>bloodbank/user_panel/hospital_issues'><i class="fa fa-hospital-o  " style="color:#E84F4F"></i> Hospital Wise Issues</a></li> 
		<li <?php if(current_url()==base_url()."bloodbank/user_panel/report_issue"){ echo "class='active'";}?>><a href='<?php echo base_url();?>bloodbank/user_panel/report_issue'><i class="fa fa-tint " style="color:#E84F4F"></i> Issue Report</a></li>
		<li <?php if(current_url()==base_url()."bloodbank/user_panel/available_blood"){ echo "class='active'";}?>><a href='<?php echo base_url();?>bloodbank/user_panel/available_blood'><i class="fa fa-cubes " style="color:#E84F4F"></i> Available Blood</a></li> 
		<li <?php if(current_url()==base_url()."bloodbank/user_panel/report_inventory"){ echo "class='active'";}?>><a href='<?php echo base_url();?>bloodbank/user_panel/report_inventory'><i class="fa fa-database  " style="color:#E84F4F"></i> Inventory Detailed</a></li> 
		<li <?php if(current_url()==base_url()."bloodbank/user_panel/blood_donors"){ echo "class='active'";}?>><a href='<?php echo base_url();?>bloodbank/user_panel/blood_donors'><i class="fa fa-file-text " style="color:#E84F4F"></i> Donors report</a></li> 
		<li <?php if(current_url()==base_url()."bloodbank/user_panel/report_screening"){ echo "class='active'";}?>><a href='<?php echo base_url();?>bloodbank/user_panel/report_screening'><i class="fa fa-search  " style="color:#E84F4F"></i> Screening Report</a></li>
		<li <?php if(current_url()==base_url()."bloodbank/user_panel/blood_components"){ echo "class='active'";}?>><a href='<?php echo base_url();?>bloodbank/user_panel/blood_components'><i class="fa fa-search  " style="color:#E84F4F"></i> Blood Components</a></li> 
		<li <?php if(current_url()==base_url()."bloodbank/user_panel/report_grouping"){ echo "class='active'";}?>><a href='<?php echo base_url();?>bloodbank/user_panel/report_grouping'><i class="fa fa-spinner " style="color:#E84F4F"></i> Grouping Report</a></li>
		<li <?php if(current_url()==base_url()."bloodbank/user_panel/discard_report"){ echo "class='active'";}?>><a href='<?php echo base_url();?>bloodbank/user_panel/discard_report'><i class="fa fa-times-circle " style="color:#E84F4F"></i> Discard Detail</a></li>
			<!--	<li <?php if(current_url()==base_url().""){ echo "class='active'";}?>><a href='<?php echo base_url();?>'><i class="fa fa-times-circle " style="color:#E84F4F"></i> Discard Summary</a></li> -->
		<li <?php if(current_url()==base_url()."bloodbank/user_panel/print_certificates"){ echo "class='active'";}?>><a href='<?php echo base_url();?>bloodbank/user_panel/print_certificates'><i class="fa fa-print " style="color:#E84F4F"></i> Print Certificates</a></li>
	  </ul>
        </div>
<div class="col-sm-3 col-md-2">
  <ul class="nav nav-pills nav-stacked">
  </ul>
  
</div>