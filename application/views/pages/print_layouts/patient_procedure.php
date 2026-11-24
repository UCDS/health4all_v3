<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" media="all">
<script type="text/javascript" src="<?php echo base_url();?>assets/js/qrcode.min.js"></script>  
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-barcode.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>

<?php 
    $patient = $patients[0];
    $hospital = $this->session->userdata('hospital');
?>

<style>
    @media all {
        table {
            font-family: "Trebuchet MS", "Sans Serif", Serif;
            border-collapse: collapse;
            border-spacing: 0;
            width: 98%;
            margin: 0 auto;
        }
        tbody {
            border: 1px solid #ccc;
        }
        td {
            padding: 6px 8px;
            vertical-align: top;
        }
        th {
            text-align: center;
            padding: 6px 8px;
        }
        
        .procedure-section-title {
            font-weight: bold;
            font-size: 14px;
            text-decoration: underline;
            margin-bottom: 4px;
        }

        .procedure-body {
            text-align: left;
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
            white-space: normal;
            font-size: 14px;
            line-height: 1.6;
            padding: 4px 0 10px 0;
        }
        .procedure-body p {
            margin: 0 0 8px 0;
        }
        .procedure-body p:last-child {
            margin-bottom: 0;
        }
    }

    @media print {
        body {
            margin: 0;
            padding: 10px;
        }
        table {
            page-break-inside: auto;
        }
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
    }
</style>

<table>
    <!-- Header -->
    <tbody>
        <tr>
            <td colspan="4" style="text-align: center; padding: 10px;">
                <span style="font-size: 16px; font-weight: bold;">
                    <?php echo $hospital['hospital']; if(!empty($hospital['place'])) echo ' - '. $hospital['place']; ?>
                </span><br />
                <span style="font-size: 15px; font-weight: bold;">
                    Procedure Details - <span id="printProcedureTime" style="font-weight: bold; font-size: 14px;"></span>
                </span>
            </td>
        </tr>
    </tbody>

    <!-- Patient Details -->
    <tbody>
        <tr style="text-align: center; font-size: 13px;">
            <td style="width: 25%;"><b>Name: </b><?php echo $patient->name; ?></td>
            <td style="width: 25%;">
                <b>Age/Gender: </b>
                <?php 
                    if ($patient->age_years != 0) { echo $patient->age_years . " Yrs "; } 
                    if ($patient->age_months != 0) { echo $patient->age_months . " Mths "; }
                    if ($patient->age_days != 0) { echo $patient->age_days . " Days "; }
                    if ($patient->age_years == 0 && $patient->age_months == 0 && $patient->age_days == 0) { echo "0 Days "; }
                    echo "/ " . $patient->gender; 
                ?>
            </td>
            <td style="width: 25%;"><b><?php echo $patient->visit_type; ?> No: </b><?php echo $patient->hosp_file_no; ?></td>
            <td style="width: 25%;"><b>Patient ID: </b><?php echo $patient->patient_id; ?></td>
        </tr>
    </tbody>

    <!-- Procedure Metadata (Name & Duration) -->
    <tbody>
        <tr style="font-size: 13px;">
            <td colspan="2" style="width: 50%; text-align: left;">
                <b>Procedure: </b><span id="printProcedureName"></span>
            </td>
            <td colspan="2" style="width: 50%; text-align: right;">
                <b>Duration: </b><span id="printProcedureDuration"></span>
            </td>
        </tr>
    </tbody>

    <!-- Procedure Content Sections -->
    <tbody>
        <tr>
            <td colspan="4" style="padding: 10px;">
                <!-- Procedure Notes -->
                <div id="wrapperPrintProcedureNote" style="margin-bottom: 12px;">
                    <div class="procedure-section-title">Procedure Notes:</div>
                    <div class="procedure-body" id="printProcedureNote"></div>
                </div>

                <!-- Findings -->
                <div id="wrapperPrintProcedureFindings" style="margin-bottom: 12px;">
                    <div class="procedure-section-title">Findings:</div>
                    <div class="procedure-body" id="printProcedureFindings"></div>
                </div>

                <!-- Post Procedure Notes -->
                <div id="wrapperPrintPostProcedureNotes">
                    <div class="procedure-section-title">Post Procedure Notes:</div>
                    <div class="procedure-body" id="printPostProcedureNotes"></div>
                </div>
            </td>
        </tr>
    </tbody>
</table>