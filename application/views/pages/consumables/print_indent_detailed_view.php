<style>
    #print-div-2 table {
        border: 2px solid black;
        width: 100%;
        border-collapse: collapse;
    }
    /* #print-div-2 thead th td tbody tr {
        border-collapse: collapse;
    } */
    #print-div-2 thead {
        height: 50px;
    }

    #print-div-2 th {
        text-align: center;
        border: 2px solid black;
    }

    #print-div-2 td {
        border: 2px solid black;
        padding: 3px;
        height: 50px;
    }


    #print-div-2 table {
        font-size: small;
    }
    
</style>

<div id="print-div-2" class="sr-only" style="width:100%;height:100%;">
    <center>
        <?php foreach ($details as $all_issue) { ?>
            <h3>
                <?php echo $all_issue->hospital; ?>
            </h3>
            <?php break;
        } ?>
        <p>
        <h3>Indent ID
            <?php echo $all_issue->indent_id; ?>
        </h3>
        </p><!-- Heading -->

    </center>
    <hr style="border: 2px solid black">
    <center>

        <label style="float:left"><b>From : </b>
            <?php echo " " . $all_issue->from_party; ?>
        </label><!-- From label-->
        <label style="float:right"><b>To : </b>
            <?php echo " " . $all_issue->to_party; ?>
        </label><br><br><!--  To label -->
        <label style="float:left"><b>Indented by : </b>
            <?php echo $all_issue->order_first . " " . $all_issue->order_last . " at " . date("d-M-Y g:i A", strtotime($all_issue->indent_date)); ?>
        </label><br><br><!--Date Time label -->
        <label style="float:left"><b>Approval by : </b>
            <?php
            if ($all_issue->indent_status == "Approved" || $all_issue->indent_status == "Issued") {
                echo $all_issue->approve_first . " " . $all_issue->approve_last . " at " . date("d-M-Y g:i A", strtotime($all_issue->approve_date_time));
            } else {
                echo " NA";
            } ?>
        </label><br><br><!--Date Time label -->
        <label style="float:left"><b>Issued by : </b>
            <?php
            if ($all_issue->indent_status == "Issued") {
                echo $all_issue->issue_first . " " . $all_issue->issue_last . " at " . date("d-M-Y g:i A", strtotime($all_issue->issue_date_time));
            } else {
                echo " NA";
            } ?>
        </label><br><br><!--Date Time label -->

    </center>
    <br /><br /><br />
    <table style=" border:2px solid black;width:100%;border-collapse: collapse;">

        <?php
        $i = 1;
        if ($details[0]->indent_status === "Issued") {
            $prev = null;
            ?>
            <?php 
					$total_costs = array();
					foreach($issue_details as $all_issue){
						if(isset($total_costs[$all_issue->indent_item_id])){
							$total_costs[$all_issue->indent_item_id] += $all_issue->cost;
						}else{
							$total_costs[$all_issue->indent_item_id] = $all_issue->cost;
						}
					}
					
					?>
            <thead style="height:50px">

                <th style="text-align:center;border:2px solid black;">Item Name</th>
                <th style="text-align:center;border:2px solid black;">Indented</th>
                <th style="text-align:center;border:2px solid black;">Approved</th>
                <th style="text-align:center;border:2px solid black;">Issued</th>

                <th style="text-align:center;border:2px solid black;">Batch</th>
                <th style="text-align:center;border:2px solid black;">Manufacture Date</th>
                <th style="text-align:center;border:2px solid black;">Expiry Date</th>

                <th style="text-align:center;border:2px solid black;">Cost(Rs.)</th>
                <th style="text-align:center;border:2px solid black;">Patient ID</th>

                <th style="text-align:center;border:2px solid black;">Note</th>
                <th style="text-align:center;border:2px solid black;">GTIN Code</th>
            </thead>

            <tbody>
                <?php
                foreach ($details as $all_issue) {
                    

                    if ($prev !== $all_issue->indent_item_id) {
                        ?>
                        <tr>

                            <td style="border:2px solid black;  padding: 3px;">
                                <b>
                                    <?php echo $all_issue->item_name . "-" . $all_issue->item_type . "-" . $all_issue->item_form . "-" . $all_issue->dosage . $all_issue->dosage_unit; ?>
                                </b>
                            </td>
                            <td style="border:2px solid black;  padding: 3px;"><b>
                                    <?= $all_issue->quantity_indented; ?>
                                </b></td>
                            <td style="border:2px solid black;  padding: 3px;"><b>
                                    <?= $all_issue->quantity_approved; ?>
                                </b></td>
                            <td style="border:2px solid black;  padding: 3px;"><b>
                                    <?= $all_issue->quantity_issued; ?></b>
                            </td>
                            
                            <td style="border:2px solid black;  padding: 3px;"></td>
                            <td style="border:2px solid black;  padding: 3px;"></td>
                            <td style="border:2px solid black;  padding: 3px;"></td>
                            <td style="border:2px solid black;  padding: 3px;"><b><span id=<?php echo "total_cost_$all_issue->indent_item_id"; ?>><?= $total_costs[$all_issue->indent_item_id];?></span></b></td>

                            <td style="border:2px solid black;  padding: 3px;"></td>
                            <td style="border:2px solid black;  padding: 3px;">
                                <?= $all_issue->item_note; ?>
                            </td>
                            <td style="border:2px solid black;  padding: 3px;"></td>


                            <!-- name="add_$indent_item->id" -->

                        </tr>
                        
                        <tr name="<?php echo "indent_item_" . $all_issue->indent_item_id; ?>" class="warning indent_item">

                            <td style="border:2px solid black;  padding: 3px;">
                                <i>
                                    <?php echo $all_issue->item_name . "-" . $all_issue->item_type . "-" . $all_issue->item_form . "-" . $all_issue->dosage . $all_issue->dosage_unit; ?>
                                </i>
                            </td>
                            <td style="border:2px solid black;  padding: 3px;"></td>
                            <td style="border:2px solid black;  padding: 3px;"></td>
                            <td style="border:2px solid black;  padding: 3px;">
                                <?= $all_issue->quantity; ?>
                            </td>
                            <td style="border:2px solid black;  padding: 3px;">
                                <?= $all_issue->batch; ?>
                            </td>
                            <td style="border:2px solid black;  padding: 3px;">
                                <?= strtotime($all_issue->manufacture_date)? date("d-M-Y", strtotime($all_issue->manufacture_date)): "NA"; ?>
                            </td>
                            <td style="border:2px solid black;  padding: 3px;">
                                <?= strtotime($all_issue->expiry_date)? date("d-M-Y", strtotime($all_issue->expiry_date)): "NA"; ?>
                            </td>
                            <td style="border:2px solid black;  padding: 3px;">
                                <?= $all_issue->cost; ?>
                            </td>

                            <td style="border:2px solid black;  padding: 3px;"><?= $all_issue->patient_id; ?></td>
                            <td style="border:2px solid black;  padding: 3px;"><?= $all_issue->note; ?></td>
                            <td style="border:2px solid black;  padding: 3px;"><?= $all_issue->gtin_code; ?></td>


                            <!-- name="add_$indent_item->id" -->

                        </tr>

                    <?php } else { ?>
                        <tr>

                            <td style="border:2px solid black;  padding: 3px;">
                                <i>
                                    <?php echo $all_issue->item_name . "-" . $all_issue->item_type . "-" . $all_issue->item_form . "-" . $all_issue->dosage . $all_issue->dosage_unit; ?>
                                </i>
                            </td>
                            <td style="border:2px solid black;  padding: 3px;"></td>
                            <td style="border:2px solid black;  padding: 3px;"></td>
                            <td style="border:2px solid black;  padding: 3px;">
                                <?= $all_issue->quantity; ?>
                            </td>
                            <td style="border:2px solid black;  padding: 3px;">
                                <?= $all_issue->batch; ?>
                            </td>
                            <td style="border:2px solid black;  padding: 3px;">
                                <?= strtotime($all_issue->manufacture_date) ? date("d-M-Y", strtotime($all_issue->manufacture_date)): "NA"; ?>
                            </td>
                            <td style="border:2px solid black;  padding: 3px;">
                                <?= strtotime($all_issue->expiry_date) ? date("d-M-Y", strtotime($all_issue->expiry_date)): "NA"; ?>
                            </td>
                            <td style="border:2px solid black;  padding: 3px;">
                                <?= $all_issue->cost; ?>
                            </td>

                            <td style="border:2px solid black;  padding: 3px;"><?= $all_issue->patient_id; ?></td>
                            <td style="border:2px solid black;  padding: 3px;"><?= $all_issue->note; ?></td>
                            <td style="border:2px solid black;  padding: 3px;"><?= $all_issue->gtin_code; ?></td>


                            <!-- name="add_$indent_item->id" -->

                        </tr>
                    <?php
                    }
                    $prev = $all_issue->indent_item_id;
                }

        } else { ?>

                <thead>
                    <th style="text-align:center;border:2px solid black;">#</th>
                    <th style="text-align:center;border:2px solid black;">Items</th>
                    <th style="text-align:center;border:2px solid black;">Quantity indented</th>
                    <th style="text-align:center;border:2px solid black;">Quantity Approved</th>
                    <th style="text-align:center;border:2px solid black;">Quantity Issued</th>
                    <th style="text-align:center;border:2px solid black;">Note</th>
                </thead>
            <tbody>
                <?php foreach ($details as $all_issue) {
                    ?>

                    <tr>
                        <td style="border:2px solid black;  padding: 10px;">
                            <center>
                                <?php echo $i++; ?>
                            </center>
                        </td>
                        <td align="left" style="border:2px solid black;  padding: 10px;">
                            <?php echo $all_issue->item_name . "-" . $all_issue->item_form . "-" . $all_issue->item_type . $all_issue->dosage . $all_issue->dosage_unit; ?>
                        </td>
                        <td align="right" style="border:2px solid black;  padding: 10px;">
                            <?php echo $all_issue->quantity_indented ?>
                        </td>
                        <td align="right" style="border:2px solid black;  padding: 10px;">
                            <?php echo $all_issue->quantity_approved ?>
                        </td>
                        <td align="right" style="border:2px solid black;  padding: 10px;">
                            <?php echo $all_issue->quantity_issued ?>
                        </td>
                        <td align="right" style="border:2px solid black;  padding: 10px;">
                            <?php echo $all_issue->item_note ?>
                        </td>

                    </tr>
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
    <br /><br />
    <p><b>Note: </b><br>
        <?php echo $all_issue->indent_note ?>
    </p>

    <b>
        <?php echo "Issuer Signature :"; ?>
    </b></br></br>
</div>