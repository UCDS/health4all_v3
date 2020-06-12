<?php ?>
<?php ?>
<div class="col-md-10 col-sm-9">
    <div class="panel panel-primary">        
            <!-- Default panel contents -->            
            <div class="panel-heading">Patient Details</div>            
            <div class="panel-body">
                <?php echo form_open('patient/external_patient_blood_request',array('class'=>'form-inline')); ?>
                <table class="table table-striped table-bordered" id="table-1">
                    <thead>
                        <th>
                          <div data-toggle="popover" data-placement="bottom" data-content="First Name">First Name</div>
                        </th>
                        <th>
                          <div data-toggle="popover" data-placement="bottom" data-content="Last Name">Last Name</div>
                        </th>
                        <th>
                          <div data-toggle="popover" data-placement="bottom" data-content="Patient Gender">Gender</div>
                        </th>
                        <th>
                          <div data-toggle="popover" data-placement="bottom" data-content="Patient Age">Age</div>
                        </th>
                        <th>
                          <div data-toggle="popover" data-placement="bottom" data-content="Blood Group">Blood Group</div>
                        </th>
                        <th>
                          <div data-toggle="popover" data-placement="bottom" data-content="Donation ID">Replacement Donation ID</div>
                        </th>
                        <th>
                          <div data-toggle="popover" data-placement="bottom" data-content="Phone Number">Phone Number</div>
                        </th>
                        <th>
                          <div data-toggle="popover" data-placement="bottom" data-content="Patient Final Diagnosis">Patient Final Diagnosis</div>
                        </th>
                        <th>&nbsp;</th>
                    </thead>                   
                   
                    <tr>
                        <td><input type="text" class="form-control" name="first_name" size="3" /></td>
                        <td><input type="text" class="form-control" name="last_name" size="3" /></td>
                        <td><input type="text" class="form-control" name="gender" size="3" /></td>
                        <td><input type="text" class="form-control" name="blood_group" size="3" /></td>
                        <td><input type="text" class="form-control" name="donation_id" size="3" /></td>
                        <td><input type="text" class="form-control" name="phone" size="3" /></td>
                        <td><input type="text" class="form-control" name="whole_blood_units" size="3" /></td>
                        <td><input type="text" class="form-control" name="whole_blood_units" size="3" /></td>
                    </tr>                   
                </table>
            </div>        
        <div class="panel-heading">Blood Requested</div>            
        <div class="panel-body">            
            <table class="table table-striped table-bordered">
                <thead>
                    <th>Blood Group</th>
                    <th>Whole Blood</th>
                    <th>Packed Cells</th>
                    <th>Frozen Plasma</th>
                    <th>Fresh Frozen Plasma</th>
                    <th>Platelet Rich Plasma</th>
                    <th>Platelet Concentrate</th>
                    <th>Cryoprecipitate</th>
                    <td></td>
                </thead>
                <tr>
                    <td>
                        <select name="blood_group" class="form-control" required>
                            <option value="" disabled selected>Select</option>
                            <option value="A+">A+</option>
                            <option value="B+">B+</option>
                            <option value="O+">O+</option>
                            <option value="AB+">AB+</option>
                            <option value="A-">A-</option>
                            <option value="B-">B-</option>
                            <option value="O-">O-</option>
                            <option value="AB-">AB-</option>
                        </select>
                    </td>
                    <td><input type="text" class="form-control" name="whole_blood_units" size="3" /></td>
                    <td><input type="text" class="form-control" name="packed_cell_units" size="3" /></td>
                    <td><input type="text" class="form-control" name="fp_units" size="3" /></td>
                    <td><input type="text" class="form-control" name="ffp_units" size="3" /></td>
                    <td><input type="text" class="form-control" name="prp_units" size="3" /></td>
                    <td><input type="text" class="form-control" name="platelet_concentrate_units" size="3" /></td>
                    <td><input type="text" class="form-control" name="cryoprecipitate_units" size="3" /></td>
                    <td>
                        <input type="text" value="<?php echo $patient_info[0]->patient_id; ?>" name="patient_id" hidden />
                        <input type="text" value="<?php echo $patient_info[0]->visit_id; ?>" name="visit_id" hidden />
                        <input type="submit" class="btn btn-primary" value="Request" />
                    </td>
                </tr>
            </table>
            <?php echo form_close(); ?>
        </div>        
    </div>
</div>

