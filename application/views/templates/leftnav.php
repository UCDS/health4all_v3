<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/fonts/flaticon.css">
<style type="text/css">
	.page_link:hover {
		background-color: blue;
		color: white;
	}
	.nav > li > a:hover, .nav > li > a:focus 
	{
		text-decoration: none;
		background-color: #428bca;
		color: white;
	}
</style>

<?php
	function check_if_group_active($group)
	{
		if($group == "masters"){
			return (preg_match("^item_forms_list^", current_url()) || preg_match("^add_item_form^", current_url()) || 
			preg_match("^drugs_available^", current_url()) || preg_match("^delete_drug^", current_url()) 
			|| preg_match("^generic_items_list^", current_url()) 
			|| preg_match("^add_generic^", current_url()) || preg_match("^items_list^", current_url()) 
			|| preg_match("^add_item^", current_url()) || preg_match("^add_supply_chain_party^", current_url()) 
			|| preg_match("^add_dosage^", current_url()) || preg_match("^add_item_type^", current_url()) 
			|| preg_match("^add_drug_type^", current_url()) || preg_match("^update_item_type^", current_url())
			|| preg_match("^update_item_form^", current_url()) || preg_match("^update_dosage^", current_url())
			|| preg_match("^update_drug_type^", current_url()) || preg_match("^supply_chain_parties_list^", current_url()));
		}else if($group == "reports"){
			return preg_match("^get_indent_summary^", current_url()) 
			|| preg_match("^indents_list^", current_url()) 
			|| preg_match("^get_inventory_summary^", current_url())
			|| preg_match("^get_item_summary^", current_url());
		}
	}
	function activate_item($item_regexp)
	{
		if (preg_match($item_regexp, current_url())){
			return "list-group-item active";
		}else{
			return "list-group-item";
		}
	}
?>

<script>
	
	$(document).ready(() => {
		// let navbar_entries = ['add', 'approve', 'issue', 'masters_div', 'reports_div'];
		// console.log("SAIRAM X", $("#page_link").val());
		// for(let i = 0; i < navbar_entries.length; i++){
		// 	$(`#${navbar_entries[i]}`).hover((e) => {
		// 		console.log('HOVER');
		// 		$(`#${navbar_entries[i]}`).toggleClass('panel-primary');
		// 	});
		// }
		let dropDownState = {
			"masters": '<?php echo check_if_group_active("masters")? 'up':'down';?>', 
			"reports": '<?php echo check_if_group_active("reports")? 'up':'down';?>'
		};
		console.log(dropDownState);
		for(const type in dropDownState){
			const type_str = "" + type;
			console.log(type_str);
			$(`#${type_str}`).click(() => {
				console.log("Clicked");
				$(`#${type_str} span`).removeClass("glyphicon-chevron-up glyphicon-chevron-down");
				dropDownState[type_str] = dropDownState[type_str] == 'up' ? 'down': 'up';
				$(`#${type_str} span`).addClass(dropDownState[type_str] == 'up' ? 'glyphicon-chevron-up': 'glyphicon-chevron-down');
			});
			console.log($('#reports'));
		}
	});


</script>



<?php if (preg_match("^equipments/*^", current_url())) {
	$userinfo = $this->session->userdata('logged_in'); // Store the session data in a variable, contains all the functions the user has access to.
	?>
	<div class="col-sm-3 col-md-2 sidebar-left">
		<ul class="nav nav-sidebar">
			<li class="nav-header"> Add</li>
			<li <?php if (preg_match("^add/equipment$^", current_url()))
				echo 'class="active"'; ?>><a
					href="<?php echo base_url(); ?>equipments/add/equipment"><i
						class="glyph-icon flaticon-medical-equipment"></i> Equipment</a></li>
			<li <?php if (preg_match("^add/equipment_type^", current_url()))
				echo 'class="active"'; ?>><a
					href="<?php echo base_url(); ?>equipments/add/equipment_type"><i class="glyph-icon flaticon-id12"></i>
					Equipment Type</a></li>
			<li <?php if (preg_match("^add/service_records^", current_url()))
				echo 'class="active"'; ?>><a
					href="<?php echo base_url(); ?>equipments/add/service_records"><i class="fa fa-cog   "></i></i> Service
					Issue</a></li>

			<li><a href="#"><i class="fa fa-file-text  "></i>&nbsp;&nbsp;&nbsp;AMC/CMC</a></li>
			<li class="nav-header"> Edit </li>
			<li <?php if (preg_match("^edit/equipment$^", current_url()))
				echo 'class="active"'; ?>><a
					href="<?php echo base_url(); ?>equipments/edit/equipment"> <i class="glyph-icon flaticon-id12"></i>
					Equipment </a></li>
			<li <?php if (preg_match("^edit/equipment_type^", current_url()))
				echo 'class="active"'; ?>><a
					href="<?php echo base_url(); ?>equipments/edit/equipment_type"> <i
						class="glyph-icon flaticon-medical-equipment"></i> Equipment Type</a></li>

			<li <?php if (preg_match("^edit/service_records^", current_url()))
				echo 'class="active"'; ?>><a
					href="<?php echo base_url(); ?>equipments/edit/service_records"> <i class="fa fa-cog  "></i></i> Service
					Issue</a></li>
			<li><a href="#"><i class="fa fa-file-text  "></i>&nbsp;&nbsp;&nbsp;AMC/CMC</a></li>
			<li class="nav-header">View</li>
			<li <?php if (preg_match("^view/equipments_summary^", current_url()))
				echo 'class="active"'; ?>><a
					href="<?php echo base_url(); ?>equipments/view/equipments_summary"> <i
						class="glyph-icon flaticon-medical-equipment"></i> Equipment</a></li>
			<li <?php if (preg_match("^view/equipments_detail^", current_url()))
				echo 'class="active"'; ?>><a
					href="<?php echo base_url(); ?>equipments/view/equipments_detail"> <i class="fa fa-cog "></i> Equipment
					Detail</a></li>
			<li <?php if (preg_match("^view/service_record_summary^", current_url()))
				echo 'class="active"'; ?>><a
					href="<?php echo base_url(); ?>equipments/view/service_record_summary"> <i class="fa fa-cog "></i>
					Service Issue</a></li>
			<ul>
	</div>
<?php } ?>
<?php if (preg_match("^vendor/*^", current_url())) {
	$userinfo = $this->session->userdata('logged_in'); // Store the session data in a variable, contains all the functions the user has access to.
	?>
	<div class="col-sm-3 col-md-2 sidebar-left">
		<ul class="nav nav-sidebar">
			<li class="nav-header">Add</li>
			<li <?php if (preg_match("^add/vendor_type^", current_url()))
				echo 'class="active"'; ?>><a
					href="<?php echo base_url(); ?>vendor/add/vendor_type">Vendor Type</a></li>
			<li <?php if (preg_match("^add/vendor$^", current_url()))
				echo 'class="active"'; ?>><a
					href="<?php echo base_url(); ?>vendor/add/vendor">Vendor</a></li>
			<li <?php if (preg_match("^add/contact_person^", current_url()))
				echo 'class="active"'; ?>><a
					href="<?php echo base_url(); ?>vendor/add/contact_person">Contact Person</a></li>

			<li class="nav-header">Edit</li>
			<li <?php if (preg_match("^edit/vendor_type^", current_url()))
				echo 'class="active"'; ?>><a
					href="<?php echo base_url(); ?>vendor/edit/vendor_type">Vendor Type</a></li>
			<li <?php if (preg_match("^edit/vendor$^", current_url()))
				echo 'class="active"'; ?>><a
					href="<?php echo base_url(); ?>vendor/edit/vendor">Vendor</a></li>
			<li <?php if (preg_match("^edit/contact_person^", current_url()))
				echo 'class="active"'; ?>><a
					href="<?php echo base_url(); ?>vendor/edit/contact_person">Contact Person</a></li>

			<ul>
	</div>
<?php } ?>



<?php
	function activate_navbar_main_list($pattern)
	{
		log_message("info", current_url());
		if (preg_match($pattern, current_url())){
			return 'panel-primary';
		}else{
			return 'panel-default';
		}
	}
?>
<?php if (
	preg_match(
		"^consumables/*^",
		current_url()
	) || preg_match(
		"^generic_item/*^",
		current_url()
	)
	|| preg_match(
		"^item/*^",
		current_url()
	) || preg_match(
		"^item_form/*^",
		current_url()
	)
	|| preg_match(
		"^dosage/*^",
		current_url()
	) || preg_match(
		"^drug_typ/*^",
		current_url()
	)
	|| preg_match(
		"^supply_chain_party/*^",
		current_url()
	) || preg_match(
		"^indent/*^",
		current_url()
	)
	|| preg_match(
		"^indent_approve/*^",
		current_url()
	) || preg_match(
		"^indent_issue/*^",
		current_url()
	)
	|| preg_match(
		"^indent_reports/*^",
		current_url()
	) || preg_match(
		"^drugs_available/*^",
		current_url()
	) || preg_match(
		"^delete_drug/*^",
		current_url()
	)
) { ?>



	<div class="col-md-2 sidebar-left">
		<ul class="nav nav-sidebar">
			<div class="panel-group" id="accordion">
				<?php foreach ($functions as $f) {
					if ($f->user_function == "Consumables") { ?>

						<div class="panel <?php echo activate_navbar_main_list("^indent/^") ?>" id="add">
							<div class="panel-heading ">
								<h4 class="panel-title">
									<a href="<?php echo base_url(); ?>consumables/indent/add_indent">Indent</a>
									</h4>
								

							</div>
							<!-- <div class="panel-body">

								</div> -->
						</div>
						
						<div class="panel <?php echo activate_navbar_main_list("^indent_approve/*^") ?>" id="approve">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a href="<?php echo base_url(); ?>consumables/indent_approve/indent_approval">Approval</a>
								</h4>
							</div>
							<!-- <div class="panel-body">

							</div> -->
						</div>

						<div class="panel <?php echo activate_navbar_main_list("^indent_issue/*^") ?>" id="issue">
							<div class="panel-heading">

								<h4 class="panel-title">
									<a href="<?php echo base_url(); ?>consumables/indent_issue/indent_issued">Issue</a>
								</h4>
							</div>
							<!-- <div class="panel-body">

							</div> -->
						</div>


					<?php

					}
				} ?>
				

				<?php foreach ($functions as $f) {

					if ($f->user_function == "Masters - Consumables") { ?>
						<div class="panel panel-default" id="masters_div">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a id="masters" style="display: inline-block;width: 100%;" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" >
										Masters <span style="margin-left: 50%;" class="glyphicon <?php if (check_if_group_active("masters"))
											echo 'glyphicon-chevron-up';
										else
											echo 'glyphicon-chevron-down';?>"></span>
									</a>
								</h4>
							</div>
							

							<div id="collapseOne" class="panel-collapse collapse <?php if(check_if_group_active("masters")) echo 'in'?>">
							<div class="panel-body">
									<ul class="list-group">
										
												<a class="<?php echo (activate_item("^consumables/generic_item/^"))?>" 
													href="<?php echo base_url(); ?>consumables/generic_item/generic_items_list">Generic
												Item</a>
										<a href="<?php echo base_url(); ?>consumables/item/items_list" class="<?php echo (activate_item("^consumables/item/^"))?>">Item</a>
										
										<a class="<?php echo (activate_item("^consumables/item_type/^"))?>" 
													href="<?php echo base_url(); ?>consumables/item_type/add_item_type">Item Type</a>
										
										<a class="<?php echo (activate_item("^consumables/item_form/^")) ?>" 
													href="<?php echo base_url(); ?>consumables/item_form/item_forms_list">Item Form</a>
										
										<a class="<?php echo (activate_item("^add_dosage^")) ?>" 
													href="<?php echo base_url(); ?>consumables/dosage/add_dosage">Dosages</a>
										<a href="<?php echo base_url(); ?>consumables/drug_type/add_drug_type" class="<?php echo (activate_item("^add_drug_type^")) ?>">
												Drug Type</a>
										<a class="<?php echo (activate_item("^consumables/supply_chain_party/^")) ?>" 
													href="<?php echo base_url(); ?>consumables/supply_chain_party/supply_chain_parties_list">Supply
												Chain
												Party</a>


									<?php

					}
				} ?>
								<?php foreach ($functions as $f) {
									if ($f->user_function == "consumables_drugs") { ?>

										<a class="<?php if (preg_match("^drugs_available^", current_url()) || preg_match("^delete_drug^", current_url()))
											echo 'list-group-item active';
										else
											echo 'list-group-item' ?>" href="<?php echo base_url(); ?>hospital/drugs_available">Hospital Drug List</a>
									

					<?php

									}
								} ?>

									</ul>
								</div>
							</div>
						</div>
				<?php foreach ($functions as $f) {
					if ($f->user_function == "Consumables") { ?>
						<div class="panel panel-default" id="reports_div">
							<div class="panel-heading">
								<h4 class="panel-title">
									<a id="reports" style="display: inline-block;width: 100%;" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
										Reports <span style="margin-left: 50%;" class="glyphicon <?php if (check_if_group_active("reports"))
											echo 'glyphicon-chevron-up';
										else
											echo 'glyphicon-chevron-down';?>">
									</a>
								</h4>
							</div>


							<div id="collapseTwo" class="panel-collapse collapse <?php if(check_if_group_active("reports")) echo 'in'?>">
							<div class="panel-body">
									<ul class="list-group">
										<a class="<?php echo (activate_item("^get_indent_summary^"))?>" href="<?php echo base_url(); ?>consumables/indent_reports/get_indent_summary">Indented
												Items </span></a>
										<a class="<?php echo (activate_item("^indents_list^"))?>" href="<?php echo base_url(); ?>consumables/indent_reports/indents_list">Indents
										List </span></a>
										<a class="<?php echo (activate_item("^get_inventory_summary^"))?>" href="<?php echo base_url(); ?>consumables/indent_reports/get_inventory_summary">Inventory 
										Summary </span></a>
										<a class="<?php echo (activate_item("^get_item_summary^"))?>" href="<?php echo base_url(); ?>consumables/indent_reports/get_item_summary">Inventory 
										Item Summary </span></a>
									</ul>
								</div>

							</div>
						</div>

					
				<?php

					}
				} ?>
				</div>
				</ul>
			<ul>
	</div>
<?php } ?>
<?php if (preg_match("^staff/*^", current_url()) || preg_match("^recruitment/*^", current_url())) { ?>

	<div class="col-sm-3 col-md-2 sidebar-left">
		<ul class="nav nav-sidebar">
			<li class="nav-header">Add</li>
			<li <?php if (preg_match("^add/staff$^", current_url()))
				echo 'class="active"'; ?>><a
					href="<?php echo base_url(); ?>staff/add/staff">Staff</a></li>
			<li <?php if (preg_match("^add/staff_role^", current_url()))
				echo 'class="active"'; ?>><a
					href="<?php echo base_url(); ?>staff/add/staff_role">Staff Role</a></li>
			<li <?php if (preg_match("^add/staff_category^", current_url()))
				echo 'class="active"'; ?>><a
					href="<?php echo base_url(); ?>staff/add/staff_category"> Staff Category</a></li>
			<li class="nav-header">Edit</li>
			<li <?php if (preg_match("^edit/staff$^", current_url()))
				echo 'class="active"'; ?>><a
					href="<?php echo base_url(); ?>staff/edit/staff">Staff</a></li>
			<li <?php if (preg_match("^edit/staff_role^", current_url()))
				echo 'class="active"'; ?>><a
					href="<?php echo base_url(); ?>staff/edit/staff_role">Staff Role</a></li>
			<li <?php if (preg_match("^edit/staff_category^", current_url()))
				echo 'class="active"'; ?>><a
					href="<?php echo base_url(); ?>staff/edit/staff_category">Staff Category</a></li>
			<li <?php if (preg_match("^edit/add_transaction^", current_url()))
				echo 'class="active"'; ?>><a
					href="<?php echo base_url(); ?>staff/add_transaction">HR Transaction</a></li>
			<li class="nav-header">View Staff</li>
			<li <?php if (preg_match("^view/view_staff$^", current_url()))
				echo 'class="active"'; ?>><a
					href="<?php echo base_url(); ?>staff/view/view_staff"> View Staff</a></li>
			<li <?php if (preg_match("^summary$^", current_url()))
				echo 'class="active"'; ?>><a
					href="<?php echo base_url(); ?>staff/summary"> Summary</a></li>
			<?php foreach ($functions as $f) {
				if ($f->user_function == "HR-Recruitment") {
					?>
					<li class="nav-header">Recruitment</li>
					<li <?php if (preg_match("^staff_applicant/add_applicant$^", current_url()))
						echo 'class="active"'; ?>><a
							href="<?php echo base_url(); ?>staff_applicant/add_applicant">Add Applicant</a></li>
					<li <?php if (preg_match("^staff_applicant/evaluate_applicant^", current_url()))
						echo 'class="active"'; ?>><a
							href="<?php echo base_url(); ?>staff_applicant/evaluate_applicant">Score Applicants</a></li>
					<li <?php if (preg_match("^staff_applicant/get_applicants_detailed^", current_url()))
						echo 'class="active"'; ?>>
						<a href="<?php echo base_url(); ?>staff_applicant/get_applicants_detailed">Get Applicants Detailed</a></li>
					<li class="nav-header">Recruitment Masters</li>
					<li <?php if (preg_match("^recruitment_masters/add_applicant_college$^", current_url()))
						echo 'class="active"'; ?>>
						<a href="<?php echo base_url(); ?>recruitment_masters/add_applicant_college">Add Applicant College</a>
					</li>
					<li <?php if (preg_match("^recruitment_masters/add_prev_institute$^", current_url()))
						echo 'class="active"'; ?>>
						<a href="<?php echo base_url(); ?>recruitment_masters/add_prev_institute">Add Applicant Prev Hospital</a>
					</li>
					<li <?php if (preg_match("^recruitment_masters/add_qualification$^", current_url()))
						echo 'class="active"'; ?>>
						<a href="<?php echo base_url(); ?>recruitment_masters/add_qualification">Add Qualifications</a></li>
					<li <?php if (preg_match("^recruitment_masters/add_recruitment_drive$^", current_url()))
						echo 'class="active"'; ?>>
						<a href="<?php echo base_url(); ?>recruitment_masters/add_recruitment_drive">Add Recruitment Drive</a>
					</li>
					<li <?php if (preg_match("^recruitment_masters/add_selection_parameter^", current_url()))
						echo 'class="active"'; ?>><a href="<?php echo base_url(); ?>recruitment_masters/add_selection_parameter">Add
							Selection Parameter</a></li>
					<?php break;
				} ?>
			<?php
			}
			?>
		</ul>
	</div>
<?php } ?>

<?php if (preg_match("^sanitation/*^", current_url())) { ?>
	<?php foreach ($functions as $f) {
		if ($f->user_function == "Masters - Sanitation" || $f->user_function == "Masters - Facility" || $f->user_function == "Masters - Application") { ?>
			<div class="col-sm-3 col-md-2 sidebar-left">
				<ul class="nav nav-sidebar">
					<li <?php if (preg_match("^sanitation/evaluate^", current_url()))
						echo 'class="active"'; ?>><a
							href="<?php echo base_url(); ?>sanitation/evaluate">Evaluate</a></li>
					<li class="nav-header">Add</li>
					<?php foreach ($functions as $f) {
						if ($f->user_function == "Masters - Sanitation" && ($f->add == 1 || $f->edit == 1)) { ?>
							<li class="disabled"><a>Sanitation</a></li>
							<li <?php if (preg_match("^add/area_activity^", current_url()))
								echo 'class="active"'; ?>><a
									href="<?php echo base_url(); ?>sanitation/add/area_activity">Area activity</a></li>
							<li <?php if (preg_match("^add/facility_activity^", current_url()))
								echo 'class="active"'; ?>><a
									href="<?php echo base_url(); ?>sanitation/add/facility_activity">Facility Activity</a></li>
							<?php
							break;
						}
					}
					?>

					<?php foreach ($functions as $f) {
						if ($f->user_function == "Masters - Facility" && ($f->add == 1 || $f->edit == 1)) { ?>
							<li class="disabled"><a>Facility</a></li>
							<li <?php if (preg_match("^add/facility_type^", current_url()))
								echo 'class="active"'; ?>><a
									href="<?php echo base_url(); ?>sanitation/add/facility_type">Facility Type</a></li>
							<li <?php if (preg_match("^add/hospital^", current_url()))
								echo 'class="active"'; ?>><a
									href="<?php echo base_url(); ?>sanitation/add/hospital">Hospital</a></li>
							<li <?php if (preg_match("^add/department^", current_url()))
								echo 'class="active"'; ?>><a
									href="<?php echo base_url(); ?>sanitation/add/department">Department</a></li>
							<li <?php if (preg_match("^add/area_types^", current_url()))
								echo 'class="active"'; ?>><a
									href="<?php echo base_url(); ?>sanitation/add/area_types">Area Types</a></li>
							<li <?php if (preg_match("^add/area^", current_url()))
								echo 'class="active"'; ?>><a
									href="<?php echo base_url(); ?>sanitation/add/area">Area</a></li>
							<li <?php if (preg_match("^add/vendor_contracts^", current_url()))
								echo 'class="active"'; ?>><a
									href="<?php echo base_url(); ?>sanitation/add/vendor_contracts">Vendor Contracts</a></li>
							<?php
							break;
						}
					}
					?>

					<?php foreach ($functions as $f) {
						if ($f->user_function == "Masters - Application" && ($f->add == 1 || $f->edit == 1)) { ?>
							<li class="disabled"><a>Application</a></li>
							<li <?php if (preg_match("^add/vendor^", current_url()))
								echo 'class="active"'; ?>><a
									href="<?php echo base_url(); ?>sanitation/add/vendor">Vendor</a></li>
							<li <?php if (preg_match("^add/states^", current_url()))
								echo 'class="active"'; ?>><a
									href="<?php echo base_url(); ?>sanitation/add/states">States</a></li>
							<li <?php if (preg_match("^add/districts^", current_url()))
								echo 'class="active"'; ?>><a
									href="<?php echo base_url(); ?>sanitation/add/districts">Districts</a></li>
							<li <?php if (preg_match("^add/village_town^", current_url()))
								echo 'class="active"'; ?>><a
									href="<?php echo base_url(); ?>sanitation/add/village_town">Village Town</a></li>
							<?php
							break;
						}
					}
					?>

					<li class="divider"></li>
					<ul>
			</div>
			<?php break;
		}
	}
}
?>

<?php if (preg_match("^diagnostics/*^", current_url()) || preg_match("^pacs/*^", current_url())) { ?>
	<div class="col-sm-3 col-md-2 sidebar-left">
		<ul class="nav nav-sidebar">
			<?php

			foreach ($functions as $f) {
				if ($f->user_function == "Diagnostics") { ?>
					<li class="nav-header">Diagnostics</li>
				<?php }
			}
			foreach ($functions as $f) {
				if ($f->user_function == "Diagnostics - Order") { ?>
					<li <?php if (preg_match("^test_order^", current_url()))
						echo 'class="active"'; ?>><a
								href="<?php echo base_url(); ?>diagnostics/test_order">Order Tests</a></li>
				<?php }
			}
			$view_orders = 0;
			foreach ($functions as $f) {
				if ($f->user_function == "Diagnostics - Order All") { ?>
					<li <?php if (preg_match("^view_orders^", current_url()))
						echo 'class="active"'; ?>><a
							href="<?php echo base_url(); ?>diagnostics/view_orders/0">View Tests</a></li>
					<?php
					$view_orders = 1;
				}
			}
			if ($view_orders == 0) {
				foreach ($functions as $f) {
					if ($f->user_function == "Diagnostics") { ?>
						<li <?php if (preg_match("^view_orders^", current_url()))
							echo 'class="active"'; ?>><a
								href="<?php echo base_url(); ?>diagnostics/view_orders">Update Tests</a></li>
						<?php
						$view_orders = 1;
					}
				}
			}
			foreach ($functions as $f) {
				if ($f->user_function == "Diagnostics") { ?>
					<li <?php if (preg_match("^edit_order^", current_url()))
						echo 'class="active"'; ?>><a
							href="<?php echo base_url(); ?>diagnostics/edit_order">Cancel Orders</a></li>
				<?php }
			}
			foreach ($functions as $f) {
				if ($f->user_function == "Diagnostics - Approve") { ?>
					<li <?php if (preg_match("^approve_results^", current_url()))
						echo 'class="active"'; ?>><a
							href="<?php echo base_url(); ?>diagnostics/approve_results">Approve Tests</a></li>
				<?php }
			}
			foreach ($functions as $f) {
				if ($f->user_function == "Diagnostics") { ?>
					<li <?php if (preg_match("^view_results^", current_url()))
						echo 'class="active"'; ?>><a
							href="<?php echo base_url(); ?>diagnostics/view_results">View Results</a></li>
					</li>
				<?php }
			}
			foreach ($functions as $f) {
				if ($f->user_function == "Diagnostics") { ?>
					<li <?php if (preg_match("^pacs^", current_url()))
						echo 'class="active"'; ?>><a
							href="<?php echo base_url(); ?>pacs/import">Import from PACS</a></li>
					</li>
				<?php }
			}

			foreach ($functions as $f) {
				if ($f->user_function == "Masters - Diagnostics") { ?>
					<li class="nav-header">Add</li>

					<li <?php if (preg_match("^add/test_method^", current_url()))
						echo 'class="active"'; ?>
						title="Methods of testing - Serology, Microscopy, etc."><a
							href="<?php echo base_url(); ?>diagnostics/add/test_method">Test Method</a></li>
					<li <?php if (preg_match("^add/test_group^", current_url()))
						echo 'class="active"'; ?>
						title="Standard grouping of tests or test panels - LFT, RFT, etc."><a
							href="<?php echo base_url(); ?>diagnostics/add/test_group">Test Group</a></li>
					<li <?php if (preg_match("^add/test_status_type^", current_url()))
						echo 'class="active"'; ?>
						title="List of status types for a test - Ordered, Approved, etc."><a
							href="<?php echo base_url(); ?>diagnostics/add/test_status_type">Test Status Type</a></li>
					<li <?php if (preg_match("^add/test_name^", current_url()))
						echo 'class="active"'; ?>
						title="List of tests perfored in the labs - ASO, CRP, Blood culture, etc."><a
							href="<?php echo base_url(); ?>diagnostics/add/test_name">Test Name</a></li>
					<li <?php if (preg_match("^add/test_area^", current_url()))
						echo 'class="active"'; ?>
						title="Areas where the tests are done - Pathology, Microbiology, etc."><a
							href="<?php echo base_url(); ?>diagnostics/add/test_area">Test Area</a></li>
					<li <?php if (preg_match("^add/antibiotic^", current_url()))
						echo 'class="active"'; ?>
						title="List of Antibodies">
						<a href="<?php echo base_url(); ?>diagnostics/add/antibiotic">Antibiotic</a>
					</li>
					<li <?php if (preg_match("^add/micro_organism^", current_url()))
						echo 'class="active"'; ?>
						title="List of Micro Organisms"><a href="<?php echo base_url(); ?>diagnostics/add/micro_organism">Micro
							Organism</a></li>
					<li <?php if (preg_match("^add/specimen_type^", current_url()))
						echo 'class="active"'; ?>
						title="List of Specimen types - Blood, Urine, etc."><a
							href="<?php echo base_url(); ?>diagnostics/add/specimen_type">Specimen Type</a></li>
					<li <?php if (preg_match("^add/lab_unit^", current_url()))
						echo 'class="active"'; ?> title="Add lab unit."><a
							href="<?php echo base_url(); ?>diagnostics/add/lab_unit">Units</a></li>

					<li class="nav-header">Edit</li>
					<li <?php if (preg_match("^edit/test_method^", current_url()))
						echo 'class="active"'; ?>><a
							href="<?php echo base_url(); ?>diagnostics/edit/test_method">Test Method</a></li>
					<li <?php if (preg_match("^edit/test_group^", current_url()))
						echo 'class="active"'; ?>><a
							href="<?php echo base_url(); ?>diagnostics/edit/test_group">Test Group</a></li>
					<li <?php if (preg_match("^edit/test_status_type^", current_url()))
						echo 'class="active"'; ?>><a
							href="<?php echo base_url(); ?>diagnostics/edit/test_status_type">Test Status Type</a></li>
					<li <?php if (preg_match("^edit/test_name^", current_url()))
						echo 'class="active"'; ?>><a
							href="<?php echo base_url(); ?>diagnostics/edit/test_name">Test Name</a></li>
					<li <?php if (preg_match("^edit/test_area^", current_url()))
						echo 'class="active"'; ?>><a
							href="<?php echo base_url(); ?>diagnostics/edit/test_area">Test Area</a></li>
					<li <?php if (preg_match("^edit/antibiotic^", current_url()))
						echo 'class="active"'; ?>><a
							href="<?php echo base_url(); ?>diagnostics/edit/antibiotic">Antibiotic</a></li>
					<li <?php if (preg_match("^edit/micro_organism^", current_url()))
						echo 'class="active"'; ?>><a
							href="<?php echo base_url(); ?>diagnostics/edit/micro_organism">Micro Organism</a></li>
					<li <?php if (preg_match("^edit/specimen_type^", current_url()))
						echo 'class="active"'; ?>><a
							href="<?php echo base_url(); ?>diagnostics/edit/specimen_type">Specimen Type</a></li>
					<!--<li <?php if (preg_match("^add/lab_unit^", current_url()))
						echo 'class="active"'; ?> title="Edit lab unit."><a href="<?php echo base_url(); ?>diagnostics/edit/lab_unit">Units</a></li>-->

					<li class="nav-header">View</li>
					<li <?php if (preg_match("^view/master_tests^", current_url()))
						echo 'class="active"'; ?>><a
							href="<?php echo base_url(); ?>diagnostics/view/master_tests">Master Tests</a></li>
				<?php

				}
			} ?>

		</ul>
	</div>
<?php
}
?>

<?php if (preg_match("^user_panel/*^", current_url()) || preg_match("^hospital/add_hospital^", current_url()) || preg_match("^hospital/search_hospital^", current_url()) || preg_match("^departments/*^", current_url()) || preg_match("^hospital_areas/*^", current_url()) || preg_match("^hospital_units/*^", current_url()) || preg_match("^helpline/*^", current_url())) { ?>

	<div class="col-xs-1 col-md-2 sidebar-left">
		<strong>Settings</strong>
		<ul class="nav nav-sidebar nav-stacked" style="margin-left:0px!important;">
			<li class="nav-divider"></li>
			<li>Forms</li>
			<li <?php if (preg_match("^user_panel/form_layout^", current_url()))
				echo 'class="active"'; ?>>
				<a href="<?php echo base_url() . "user_panel/form_layout"; ?>">Add Custom Form</a>
			</li>
			<li <?php if (preg_match("/user_panel\/delete_custorm_forms/", current_url()))
				echo 'class="active"'; ?>>
				<a href="<?php echo base_url() . "user_panel/delete_custorm_forms"; ?>"> Delete Custorm Forms </a>
			</li>
			<li <?php if (preg_match("/user_panel\/print_layouts/", current_url()))
				echo 'class="active"'; ?>>
				<a href="<?php echo base_url() . "user_panel/print_layouts"; ?>">Print Layouts</a>
			</li>
			<li <?php if (preg_match("^add_hospital/hospital_view^", current_url()))
				echo 'class="active"'; ?>>
				<a href="<?php echo base_url(); ?>hospital/add_hospital/hospital_view"> Add Hospital</a>
			</li>
			 <li <?php if (preg_match("^search_hospital/search_hospital_view^", current_url()))
				echo 'class="active"'; ?>>
				<a href="<?php echo base_url(); ?>hospital/search_hospital/search_hospital_view">Edit Hospital</a>
			</li>
			<li <?php if(preg_match("/user_panel\/priority_type/", current_url()) || preg_match("/user_panel\/priority_type\/1/", current_url())){ echo 'class="active"'; }?>>
				<a href="<?php echo base_url() . "user_panel/priority_type"; ?>"> Add / Update Priority Type</a>
			</li>
			<li <?php if(preg_match("/user_panel\/visit_type/", current_url()) || preg_match("/user_panel\/visit_type\/1/", current_url())){ echo 'class="active"'; }?>>
				<a href="<?php echo base_url() . "user_panel/visit_type"; ?>"> Add / Update Visit Type</a>
			</li>
			<li <?php if (preg_match("^add_department/department_view^", current_url()) || preg_match("^add_department^", current_url()))
				echo 'class="active"'; ?>>
				<a href="<?php echo base_url(); ?>departments/add_department/department_view">Add / Update Departments</a>
			</li>
			<li <?php if (preg_match("^hospital_areas/add_area^", current_url()))
				echo 'class="active"'; ?>>
				<a href="<?php echo base_url(); ?>hospital_areas/add_area">Add Areas</a>
			</li>
			<li <?php if (preg_match("^add_unit^", current_url()))
				echo 'class="active"'; ?>>
				<a href="<?php echo base_url(); ?>hospital_units/add_unit">Add Units</a>
			</li>
			<li <?php if (preg_match("/user_panel\/primary_routes/", current_url()))
				echo 'class="active"'; ?>>
				<a href="<?php echo base_url() . "user_panel/primary_routes"; ?>"> Add / Update Primary Routes</a>
			</li>
			<li <?php if (preg_match("/user_panel\/secondary_routes/", current_url()))
				echo 'class="active"'; ?>>
				<a href="<?php echo base_url() . "user_panel/secondary_routes"; ?>"> Add / Update Secondary Routes</a>
			</li>
			<li <?php if (preg_match("/user_panel\/update_des_user_function/", current_url()))
				echo 'class="active"'; ?>>
				<a href="<?php echo base_url() . "user_panel/update_des_user_function"; ?>"> Update User Function Description</a>
			</li>
			<li <?php if (preg_match("/user_panel\/counseling_type/", current_url()))
				echo 'class="active"'; ?>>
				<a href="<?php echo base_url() . "user_panel/counseling_type"; ?>"> Add / Update Counseling Type</a>
			</li>
			<li <?php if (preg_match("/user_panel\/counseling_text/", current_url()))
				echo 'class="active"'; ?>>
				<a href="<?php echo base_url() . "user_panel/counseling_text"; ?>"> Add / Update Counseling Text</a>
			</li>
			

			<li class="nav-divider"></li>

			<li class="navbar-text">User</li>
			<li <?php if (preg_match("^user_panel/create_user^", current_url()))
				echo 'class="active"'; ?>>
				<a href="<?php echo base_url() . "user_panel/create_user"; ?>">Create</a>
			</li>

			<li <?php if (preg_match("^user_panel/edit_user^", current_url()))
				echo 'class="active"'; ?>>
				<a href="<?php echo base_url() . "user_panel/edit_user"; ?>">Edit</a>
			</li>
			<!-- Newly added Jan 25 2024-->
			<li <?php if (preg_match("^user_panel/user_function_act_list^", current_url()))
				echo 'class="active"'; ?>>
				<a href="<?php echo base_url() . "user_panel/user_function_act_list"; ?>">User Function List</a>
			</li>
			<!-- Till here -->
			<li <?php if (preg_match("^user_panel/user_hospital_link^", current_url()))
				echo 'class="active"'; ?>>
				<a href="<?php echo base_url() . "user_panel/user_hospital_link"; ?>">Hospital</a>
			</li>
			<li <?php if (preg_match("^user_panel/helpline_access^", current_url()))
				echo 'class="active"'; ?>>
				<a href="<?php echo base_url() . "user_panel/helpline_access"; ?>">Helpline</a>
			</li>
			<li class="nav-divider"></li>


		</ul>
	</div>
<?php } ?>
