<style>
.sousMenu:hover ul
{
    display:inherit;
}
.sousMenu ul
{
    top: 40px;
    display: none;
    list-style-type: none;
}
</style>
    <link href="<?php echo base_url();?>assets/css/simple-sidebar.css" rel="stylesheet">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
    <li <?php if(current_url()==base_url()."bloodbank/user_panel/donation_summary"){ echo "class='active'";}?>><a href="<?php echo base_url();?>bloodbank/user_panel/donation_summary"><i class="fa fa-user " style="color:#E84F4F"></i>Bloodbank Reports</a></li>            
    <li <?php if(current_url()==base_url()."bloodbank/register/repeat_donor"){ echo "class='active'";}?>><a href="<?php echo base_url();?>bloodbank/register/repeat_donor"><i class="fa fa-user " style="color:#E84F4F"></i> Repeat Donor</a></li>
	<li <?php if(current_url()==base_url()."bloodbank/register"){ echo "class='active'";}?>><a href="<?php echo base_url();?>bloodbank/register"><i class="fa fa-user " style="color:#E84F4F"></i>Step <strong style="color:#E84F4F">2</strong>: Donor Details</a></li>
	<li <?php if(current_url()==base_url()."bloodbank/register/donation"){ echo "class='active'";}?>><a href="<?php echo base_url();?>bloodbank/register/donation"><i class="fa fa-stethoscope " style="color:#E84F4F"></i>Step <strong style="color:#E84F4F">3</strong>: Donor Checkup</a></li>
	<li <?php if(current_url()==base_url()."bloodbank/register/bleeding"){ echo "class='active'";}?>><a href="<?php echo base_url();?>bloodbank/register/bleeding"><i class="fa fa-tint " style="color:#E84F4F" ></i>Step <strong style="color:#E84F4F">4</strong>: Bleeding</a></li>
	<li <?php if(current_url()==base_url()."bloodbank/inventory/blood_grouping"){ echo "class='active'";}?>><a href="<?php echo base_url();?>bloodbank/inventory/blood_grouping"><i class="fa fa-spinner " style="color:#E84F4F"></i>Step <strong style="color:#E84F4F">5</strong>: Grouping</a></li>
	<li <?php if(current_url()==base_url()."bloodbank/inventory/prepare_components"){ echo "class='active'";}?>><a href="<?php echo base_url();?>bloodbank/inventory/prepare_components"><i class="fa fa-crosshairs " style="color:#E84F4F"></i>Component Preparation</a></li>
	<li <?php if(current_url()==base_url()."bloodbank/inventory/screening"){ echo "class='active'";}?>><a href="<?php echo base_url();?>bloodbank/inventory/screening"><i class="fa fa-search " style="color:#E84F4F"></i>Step <strong style="color:#E84F4F">6</strong>: Screening</a></li>
	<li <?php if(current_url()==base_url()."bloodbank/register/request"){ echo "class='active'";}?>><a href="<?php echo base_url();?>bloodbank/register/request"><i class="fa fa-user " style="color:#E84F4F"></i>Step <strong style="color:#E84F4F">7</strong>: Request</a></li>
	<li <?php if(current_url()==base_url()."bloodbank/inventory/issue"){ echo "class='active'";}?>><a href="<?php echo base_url();?>bloodbank/inventory/issue"><i class="fa fa-pencil-square-o " style="color:#E84F4F"></i>Step <strong style="color:#E84F4F">8</strong>: Issue</a></li>
	<li <?php if(current_url()==base_url()."bloodbank/inventory/discard"){ echo "class='active'";}?>><a href="<?php echo base_url();?>bloodbank/inventory/discard"><i class="fa fa-times-circle" style="color:#E84F4F"></i>  Discard</a></li>
	<li <?php if(current_url()==base_url()."bloodbank/user_panel/place"){ echo "class='active'";}?>><a href="<?php echo base_url();?>bloodbank/user_panel/place"><i class="fa fa-map-marker " style="color:#E84F4F"></i>Step <strong style="color:#E84F4F">One</strong>: Set Camp</a></li>	  
	<li <?php if(current_url()==base_url()."bloodbank/staff/add_camp"){ echo "class='active'";}?>><a href="<?php echo base_url();?>bloodbank/staff/add_camp"><i class="fa fa-map-marker " style="color:#E84F4F"></i>Add Camp</a></li>                             
<!--	<li <?php if(current_url()==base_url()."bloodbank/staff/add_hospital"){ echo "class='active'";}?>> <a href="<?php echo base_url();?>bloodbank/staff/add_hospital"><i class="fa fa-map-marker " style="color:#E84F4F"></i>Add Hospital</a></li> -->
	<li <?php if(current_url()==base_url()."bloodbank/donation/get_donation"){ echo "class='active'";}?>><a href="<?php echo base_url();?>bloodbank/donation/get_donation"><i class="fa fa-edit " style="color:#E84F4F"></i>  Edit Donation</a></li>
	<li <?php if(current_url()==base_url()."bloodbank/create_slots"){ echo "class='active'";}?>><a href="<?php echo base_url();?>bloodbank/create_slots"><i class="fa fa-calendar " style="color:#E84F4F"></i>  Create Slots</a></li>
	<li <?php if(current_url()==base_url()."bloodbank/user_panel/invite_donor"){ echo "class='active'";}?>><a href="<?php echo base_url();?>bloodbank/user_panel/invite_donor"><i class="fa fa-phone" style="color:#E84F4F"></i>  Invite Donor's</a></li>
            </ul>
        </div>
<div class="col-sm-3 col-md-2">
  <ul class="nav nav-pills nav-stacked">
  </ul>
  
</div>