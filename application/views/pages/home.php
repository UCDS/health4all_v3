<style>
	.alert a{
		color:black;
	}
	.fa{
		font-size:1.5em;
	}
</style>
	<div class="row">

	    <h2>Welcome to Health4All <small>- a Free and Open Source application developed and supported by <a href="http://www.yousee.in/c4c" target="_blank">YouSee</a></small></h2>
		<br />
		<div class="col-md-6">
			<div class="alert alert-info" role="alert">
					<h5>Health4all has the following modules</h5>
                    <ul>
                        <li>
                            <i class="fa fa-user"></i> Patients
                            <ul>
                                <li>Out Patient Registration: Input the Out Patient details.<br> Note: You need to create an Out Patient Form in 'Settings' to be able to see this page.</li>
                                <li>In Patient Registration: Input the In Patient details. <br> Note: You need to create an In Patient Form in 'Settings' to be able to see this page.</li>
                                <li>View Patients: View the list of patients already registered with the hospital.</li>
                                <li>Update Patients: Update the information of existing patients. <br> Note: Fields that already have data cannot be edited.</li>
                            </ul>
                        </li>
                        <li>
                            <i class="fa flaticon-chemistry20"></i> Services
                            <ul>
                                <li>Diagnostics: Here we capture various diagnostic tests that were performed by the hospital on each patient.</li>
                                <li>BloodBank: Here we capture all the Blood donations that were done in the hospital along with the Blood issues done to various patients.</li>
                                <li>Sanitation</li>
                            </ul>
                        </li>
                        <li>
                            <i class="fa fa-medkit"></i> Resources
                            <ul>
                                <li>HR: Here we capture hospital staff information.</li>
                                <li>Equipment: Here we capture the hospital equipment information.</li>
                                <li>Consumables: Work in progress.</li>
                                <li>Vendor: Here we capture vendor information.</li>
                            </ul>
                        </li>
                        <li>
                           <i class="fa fa-bar-chart"></i>  Reports
                            <ul>
                                <li>
                                    Summary Reports
                                    <ul>
                                        <li>OP Summary: Report showing number of Out Patient visits per department, in a given age group.</li>
                                        <li>IP Summary: Report showing number of In Patient visits per department, in a given age group.</li>
                                        <li>IP/OP Trends: Report showing number of Patient visits by Day/Month/Year in the selected period.</li>
                                        <li>ICD Code Summary: Report summary categorizing the diagnosis of each patient visit by ICD code.</li>
                                        <li>Outcome Summary: Report summary categorizing the final outcome(Dischage/LAMA/Absconded/Death) of each visit</li>
                                        <li>BloodBank Reports: Contains various BloodBank reports.</li>
                                        <li>Audiology Report: Summary of new born hearing screening results.</li>
                                        <li>Sanitation Evaluation</li>
                                        <li>Orders Summary: Summary of diagnostics tests ordered by department. </li>
                                        <li>Sensitivity Report: Summary of reactivity of Culture Sensitivity tests, by Antibiotic, and by Organism.</li>
                                    </ul>
                                </li>
                                <li>Detailed Reports
                                    <ul>
                                        <li>OP Detail: Report listing out Out Patient visits during a period, with all Patient Details.</li>
                                        <li>IP Detail: Report listing out In Patient visits during a period, with all Patient Details.</li>
                                        <li>ICD Code Detail: Report listing out Patient visits during a period, with all Patient Details along with ICD code.</li>
                                        <li>Sanitation Evaluation</li>
                                    </ul>
                                </li>
                            </ul>
                    </ul>
                </div>

		    <div class="alert alert-danger" role="alert">
                    <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                    <span class="">Note:</span>
                    Each of the above modules has User Access Control. Contact Administrator for access.
            </div>
		</div>
		<div class="col-md-6">
		<div class="panel panel-info">
			<div class="panel-heading"><h4><i class="fa fa-bar-chart"></i> Dashboards</h4></div>
			<div class="panel-body">
				<a href="<?= base_url()."dashboard/helpline";?>"><div class="alert alert-success col-md-4 col-md-offset-1"><i class="fa fa-phone"></i> Helpline</div></a>
				<a href="<?= base_url()."dashboard/state/telangana";?>"><div class="alert alert-success col-md-4 col-md-offset-1"><i class="fa fa-line-chart"></i> Telangana</div></a>
				<a href="<?= base_url()."dashboard/view/tvvp";?>"><div class="alert alert-success col-md-4 col-md-offset-1"><i class="fa fa-pie-chart"></i> TVVP</div></a>
				<a href="<?= base_url()."dashboard/view/dmetelangana";?>"><div class="alert alert-success col-md-4 col-md-offset-1"><i class="fa fa-bar-chart"></i> DME Telangana</div></a>
				<a href="<?= base_url()."dashboard/view/dmeap";?>"><div class="alert alert-success col-md-4 col-md-offset-1"><i class="fa fa-area-chart"></i> DME AP</div></a>
				<a href="<?= base_url()."dashboard/bloodbanks";?>"><div class="alert alert-success col-md-4 col-md-offset-1"><i class="fa fa-tint"></i> Blood Banks</div></a>
				<a href="<?= base_url()."dashboard/view/npo";?>"><div class="alert alert-success col-md-4 col-md-offset-1"><i class="fa fa-bar-chart"></i> NPOs</div></a>
                <a href="<?= base_url()."dashboard/diagnostics_dashboard_1";?>"><div class="alert alert-success col-md-4 col-md-offset-1"><i class="fa flaticon-chemistry20"></i> Diagnostics - 1</div></a>
                <a href="<?= base_url()."dashboard/diagnostics_dashboard_2";?>"><div class="alert alert-success col-md-4 col-md-offset-1"><i class="fa flaticon-chemistry20"></i> Diagnostics - 2</div></a>
			</div>
		</div>
	</div>
