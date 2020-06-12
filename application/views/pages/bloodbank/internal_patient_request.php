<?php ?>
<div class="col-md-10 col-sm-9">
    <div class="panel panel-primary">        
            <!-- Default panel contents -->
            <?php if(isset($patient_info)) {  ?>
            <div class="panel-heading">Patient Details</div>            
            <div class="panel-body">
                <table class="table table-striped table-bordered" id="table-1">
                    <thead>
                        <th>
                          <div data-toggle="popover" data-placement="bottom" data-content="Patient ID">Patient ID</div>
                        </th>
                        <th>
                          <div data-toggle="popover" data-placement="bottom" data-content="IP/OP Number">IP/OP Number</div>
                        </th>
                        <th>
                          <div data-toggle="popover" data-placement="bottom" data-content="Patient Name">Patient Name</div>
                        </th>
                        <th>
                          <div data-toggle="popover" data-placement="bottom" data-content="Patient Gender">Patient Gender</div>
                        </th>
                        <th>
                          <div data-toggle="popover" data-placement="bottom" data-content="Blood Group">Blood Group</div>
                        </th>
                        <th>
                          <div data-toggle="popover" data-placement="bottom" data-content="Phone Number">Phone Number</div>
                        </th>
                        <th>
                          <div data-toggle="popover" data-placement="bottom" data-content="Patient Final Diagnosis">Patient Final Diagnosis</div>
                        </th>
                        <th>&nbsp;</th>
                    </thead>
                    
                    <?php if(sizeof($patient_info) == 1) { ?>
                    <tr>
                        <td> <?php echo $patient_info[0]->patient_id; ?></td>
                        <td> <?php echo $patient_info[0]->hosp_file_no; ?></td>
                        <td> <?php echo $patient_info[0]->first_name." ".$patient_info[0]->last_name; ?></td>
                        <td> <?php echo $patient_info[0]->gender; ?></td>
                        <td> <?php echo $patient_info[0]->blood_group; ?></td>
                        <td> <?php echo $patient_info[0]->phone; ?></td>
                        <td> <?php echo $patient_info[0]->final_diagnosis; ?></td>
                        <td>&nbsp;</td>
                    </tr>
                    <?php } else if(sizeof($patient_info) > 1) {
                        foreach($patient_info as $info){ ?>
                    <tr>
                        <td> <?php echo $info->patient_id; ?></td>
                        <td> <?php echo $info->hosp_file_no; ?></td>
                        <td> <?php echo $info->first_name." ".$info->last_name; ?></td>
                        <td> <?php echo $info->gender; ?></td>
                        <td> <?php echo $info->blood_group; ?></td>
                        <td> <?php echo $info->phone; ?></td>
                        <td> <?php echo $info->hosp_file_no; ?></td>
                        <td><?php echo form_open('bloodbank/blood_request/internal_patient_blood_request',array('class'=>'form-inline')); ?>
                            <input type="text" value="<?php echo $info->patient_id; ?>" name="patient_id" hidden />
                            <input type="submit" class="btn btn-primary" value="Select" />
                            <?php echo form_close();?>
                        </td>
                    </tr>
                        <?php }                        
                        } ?>
                </table>
            </div>
        <?php } ?>
        <?php if(isset($patient_info) && sizeof($patient_info) == 1) { ?>
        <div class="panel-heading">Blood Requested</div>            
        <div class="panel-body">
            <?php echo form_open('bloodbank/blood_request/internal_patient_blood_request',array('class'=>'form-inline')); ?>
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
        <?php } ?>
        <div class="panel-heading">Search for Patient</div>            
        <div class="panel-body">
            <?php echo form_open('bloodbank/blood_request/internal_patient_blood_request',array('class'=>'form-inline')); ?>
            <table class="table table-striped table-bordered">
                <thead>
                <th>
                    Year
                </th>
                <th>
                    Visit_type
                </th>
                <th>
                    IP/OP Number
                </th>
                <th>
                    Patient ID
                </th>
                <th>
                    Patient Name
                </th>
                <th>
                    Phone Number
                </th>
                </thead>
                <tr>
                    <td>
                        <select class="form-control" name="search_year">
                            <?php 
                                $i=2013;
                                $year = date("Y");
                                while($year>=$i){ ?>
                                <option value="<?php echo $year;?>"><?php echo $year--;?></option>
                            <?php
                                }
                            ?>
                        </select>		
                    </td>
                    <td>
                        <select class="form-control" name="search_visit_type">
                            <option value=''>All</option>
                            <option value='IP'>IP</option>
                            <option value='OP'>OP</option>
			</select>		
                    </td>
                    <td>
                        <input type="text" name="ip_op_number" size="5" class="form-control" />
                    </td>
                    <td>
                        <input type="text" name="patient_id" size="5" class="form-control" />
                    </td>
                    <td>
                        <input type="text" name="patient_name" size="10" class="form-control" />
                    </td>
                    <td>
                        <input type="text" name="phone_number" size="5" class="form-control" />
                    </td>
                </tr>
                <tr>
                    <td colspan="5">
                         <input type="text" name="search_patients" value='1' hidden />
                    </td>                    
                    <td colspan="1">
                        <input class="btn btn-sm btn-primary" type="submit" value="Search" />
                    </td>
                </tr>
            </table>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

