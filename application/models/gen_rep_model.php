<?php
class Gen_rep_Model extends CI_Model {
    private $queries = array(    //'sbp,dbp,rbs,hb,hb1ac'
        'query_name'=>array(
            'filters'=>array(   // set or false

            ),
            'where'=>array(

            ),
            'join_sequence'=>array(

            ),
            'group_by'=>array(

            ),
            'having'=>array(

            )
        ),
        'sbp'=>array(
            'filters'=>array(   // set or false
                '>='=>array('sbp-patient_visit.sbp')
            ),
            'select'=>'COUNT(DISTINCT(patient_id)) as sbp',
            'from'=>'patient_visit',
            'where'=>false,
            'join_sequence'=>false,
            'group_by'=>false,
            'having'=>false
        ),
        'dbp'=>array(
            'filters'=>array(   // set or false
                '>='=>array('dbp-patient_visit.dbp')
            ),
            'select'=>'COUNT(DISTINCT(patient_id)) as dbp',
            'from'=>'patient_visit',
            'where'=>false,
            'join_sequence'=>false,
            'group_by'=>false,
            'having'=>false
        ),
        'rbs'=>array(
            'filters'=>array(           // set or false test.test_result >= post
                '>='=>array('rbs-patient_visit.blood_sugar')
            ),
            'select'=>'COUNT(DISTINCT(patient_id)) as rbs',
            'from'=>'patient_visit',
            'where'=>false,
            'join_sequence'=>false,
            'group_by'=>false,
            'having'=>false
        ),
        'hb'=>array(
            'filters'=>array(           // set or false test.test_result >= post
                '<='=>array('hb-patient_visit.hb')
            ),
            'select'=>'COUNT(DISTINCT(patient_id)) as hb',
            'from'=>'patient_visit',
            'where'=>false,             // test_master.test_name = rbs, 
            'join_sequence'=>false,     // patient_visit -> test -> test_master
            'group_by'=>false,
            'having'=>false
        ),
        'hb1ac'=>array(
            'filters'=>array(           // set or false test.test_result >= post
                '>='=>array('hb1ac-patient_visit.hb1ac')
            ),
            'select'=>'COUNT(DISTINCT(patient_id)) as hb',
            'from'=>'patient_visit',
            'where'=>false,             // test_master.test_name = rbs, 
            'join_sequence'=>false,     // patient_visit -> test -> test_master
            'group_by'=>false,
            'having'=>false
        ),
        'nsbp'=>array(
            'filters'=>array(   // set or false
                '<'=>array('*sbp-patient_visit.sbp')
            ),
            'select'=>'COUNT(DISTINCT(patient_id)) as sbp',
            'from'=>'patient_visit',
            'where'=>false,
            'join_sequence'=>false,
            'group_by'=>false,
            'having'=>false
        ),
        'ndbp'=>array(
            'filters'=>array(   // set or false
                '<'=>array('*dbp-patient_visit.dbp')
            ),
            'select'=>'COUNT(DISTINCT(patient_id)) as dbp',
            'from'=>'patient_visit',
            'where'=>false,
            'join_sequence'=>false,
            'group_by'=>false,
            'having'=>false
        ),
        'nrbs'=>array(
            'filters'=>array(           // set or false test.test_result >= post
                '<'=>array('*rbs-patient_visit.blood_sugar')
            ),
            'select'=>'COUNT(DISTINCT(patient_id)) as rbs',
            'from'=>'patient_visit',
            'where'=>false,             // test_master.test_name = rbs, 
            'join_sequence'=>false,     // patient_visit -> test -> test_master
            'group_by'=>false,
            'having'=>false
        ),
        'nhb'=>array(
            'filters'=>array(           // set or false test.test_result >= post
                '>'=>array('*hb-patient_visit.hb')
            ),
            'select'=>'COUNT(DISTINCT(patient_id)) as hb',
            'from'=>'patient_visit',
            'where'=>false,             // test_master.test_name = rbs, 
            'join_sequence'=>false,     // patient_visit -> test -> test_master
            'group_by'=>false,
            'having'=>false
        ),
        'nhb1ac'=>array(
            'filters'=>array(           // set or false test.test_result >= post
                '<'=>array('*hb1ac-patient_visit.hb1ac')
            ),
            'select'=>'COUNT(DISTINCT(patient_id)) as hb',
            'from'=>'patient_visit',
            'where'=>false,             // test_master.test_name = rbs, 
            'join_sequence'=>false,     // patient_visit -> test -> test_master
            'group_by'=>false,
            'having'=>false
        ),
        'sbp_detail'=>array(
            'filters'=>array(           // set or false test.test_result >= post
                '>='=>array('sbp-patient_visit.sbp')
            ),
            'select'=>"patient.patient_id, patient_visit.hosp_file_no as OP_IP_Number, DATE_FORMAT(patient_visit.admit_date, '%d %b %Y') as date, patient_visit.admit_time as time, patient.gender, CONCAT(patient.first_name,' ', patient.last_name) as name, patient.age_years, CONCAT(patient.father_name,' ', patient.mother_name, ' ', patient.spouse_name) as relative, patient.place, CONCAT(patient.phone, ' ', patient.alt_phone) as phone, department.department, CONCAT(unit.unit_name, '-', area.area_name) as Unit,  GROUP_CONCAT(patient_visit.sbp SEPARATOR ', ') as SBP,GROUP_CONCAT(patient_visit.dbp SEPARATOR ', ') as DBP,GROUP_CONCAT(patient_visit.blood_sugar SEPARATOR ', ') as blood_sugar, GROUP_CONCAT(patient_visit.hb SEPARATOR ', ') as HB,GROUP_CONCAT(patient_visit.hb1ac SEPARATOR ', ') as HB1AC",
            'from'=>'patient',
            'where'=>false,
            'join_sequence'=>array(
                'patient_visit.patient_id=patient.patient_id',
                'department.department_id=patient_visit.department_id',
                'unit.unit_id=patient_visit.unit',
                'area.area_id=patient_visit.area',
            ),     // patient_visit -> test -> test_master
            'group_by'=>array('patient_id'),
            'having'=>false,
            'limit'=>1000
        ),
        'dbp_detail'=>array(
            'filters'=>array(           // set or false test.test_result >= post
                '>='=>array('dbp-patient_visit.dbp')
            ),
            'select'=>"patient.patient_id, patient_visit.hosp_file_no as OP_IP_Number, DATE_FORMAT(patient_visit.admit_date, '%d %b %Y') as date, patient_visit.admit_time as time, patient.gender, CONCAT(patient.first_name,' ', patient.last_name) as name, patient.age_years, CONCAT(patient.father_name,' ', patient.mother_name, ' ', patient.spouse_name) as relative, patient.place, CONCAT(patient.phone, ' ', patient.alt_phone) as phone, department.department, CONCAT(unit.unit_name, '-', area.area_name) as Unit,  GROUP_CONCAT(patient_visit.sbp SEPARATOR ', ') as SBP,GROUP_CONCAT(patient_visit.dbp SEPARATOR ', ') as DBP,GROUP_CONCAT(patient_visit.blood_sugar SEPARATOR ', ') as blood_sugar, GROUP_CONCAT(patient_visit.hb SEPARATOR ', ') as HB,GROUP_CONCAT(patient_visit.hb1ac SEPARATOR ', ') as HB1AC",
            'from'=>'patient',
            'where'=>false,
            'join_sequence'=>array(
                'patient_visit.patient_id=patient.patient_id',
                'department.department_id=patient_visit.department_id',
                'unit.unit_id=patient_visit.unit',
                'area.area_id=patient_visit.area',
            ),     // patient_visit -> test -> test_master
            'group_by'=>array('patient_id'),
            'having'=>false,
            'limit'=>1000
        ),
        'rbs_detail'=>array(
            'filters'=>array(           // set or false test.test_result >= post
                '>='=>array('rbs-patient_visit.blood_sugar')
            ),
            'select'=>"patient.patient_id, patient_visit.hosp_file_no as OP_IP_Number, DATE_FORMAT(patient_visit.admit_date, '%d %b %Y') as date, patient_visit.admit_time as time, patient.gender, CONCAT(patient.first_name,' ', patient.last_name) as name, patient.age_years, CONCAT(patient.father_name,' ', patient.mother_name, ' ', patient.spouse_name) as relative, patient.place, CONCAT(patient.phone, ' ', patient.alt_phone) as phone, department.department, CONCAT(unit.unit_name, '-', area.area_name) as Unit,  GROUP_CONCAT(patient_visit.sbp SEPARATOR ', ') as SBP,GROUP_CONCAT(patient_visit.dbp SEPARATOR ', ') as DBP,GROUP_CONCAT(patient_visit.blood_sugar SEPARATOR ', ') as blood_sugar, GROUP_CONCAT(patient_visit.hb SEPARATOR ', ') as HB,GROUP_CONCAT(patient_visit.hb1ac SEPARATOR ', ') as HB1AC",
            'from'=>'patient',
            'where'=>false,
            'join_sequence'=>array(
                'patient_visit.patient_id=patient.patient_id',
                'department.department_id=patient_visit.department_id',
                'unit.unit_id=patient_visit.unit',
                'area.area_id=patient_visit.area',
            ),     // patient_visit -> test -> test_master
            'group_by'=>array('patient_id'),
            'having'=>false,
            'limit'=>1000
        ),
        'hb_detail'=>array(
            'filters'=>array(           // set or false test.test_result >= post
                '<='=>array('hb-patient_visit.hb')
            ),
            'select'=>"patient.patient_id, patient_visit.hosp_file_no as OP_IP_Number, DATE_FORMAT(patient_visit.admit_date, '%d %b %Y') as date, patient_visit.admit_time as time, patient.gender, CONCAT(patient.first_name,' ', patient.last_name) as name, patient.age_years, CONCAT(patient.father_name,' ', patient.mother_name, ' ', patient.spouse_name) as relative, patient.place, CONCAT(patient.phone, ' ', patient.alt_phone) as phone, department.department, CONCAT(unit.unit_name, '-', area.area_name) as Unit,  GROUP_CONCAT(patient_visit.sbp SEPARATOR ', ') as SBP,GROUP_CONCAT(patient_visit.dbp SEPARATOR ', ') as DBP,GROUP_CONCAT(patient_visit.blood_sugar SEPARATOR ', ') as blood_sugar, GROUP_CONCAT(patient_visit.hb SEPARATOR ', ') as HB,GROUP_CONCAT(patient_visit.hb1ac SEPARATOR ', ') as HB1AC",
            'from'=>'patient',
            'where'=>false,
            'join_sequence'=>array(
                'patient_visit.patient_id=patient.patient_id',
                'department.department_id=patient_visit.department_id',
                'unit.unit_id=patient_visit.unit',
                'area.area_id=patient_visit.area',
            ),     // patient_visit -> test -> test_master
            'group_by'=>array('patient_id'),
            'having'=>false,
            'limit'=>1000
        ),
        'hb1ac_detail'=>array(
            'filters'=>array(           // set or false test.test_result >= post
                '>='=>array('hb1ac-patient_visit.hb1ac')
            ),
            'select'=>"patient.patient_id, patient_visit.hosp_file_no as OP_IP_Number, DATE_FORMAT(patient_visit.admit_date, '%d %b %Y') as date, patient_visit.admit_time as time, patient.gender, CONCAT(patient.first_name,' ', patient.last_name) as name, patient.age_years, CONCAT(patient.father_name,' ', patient.mother_name, ' ', patient.spouse_name) as relative, patient.place, CONCAT(patient.phone, ' ', patient.alt_phone) as phone, department.department, CONCAT(unit.unit_name, '-', area.area_name) as Unit,  GROUP_CONCAT(patient_visit.sbp SEPARATOR ', ') as SBP,GROUP_CONCAT(patient_visit.dbp SEPARATOR ', ') as DBP,GROUP_CONCAT(patient_visit.blood_sugar SEPARATOR ', ') as blood_sugar, GROUP_CONCAT(patient_visit.hb SEPARATOR ', ') as HB,GROUP_CONCAT(patient_visit.hb1ac SEPARATOR ', ') as HB1AC",
            'from'=>'patient',
            'where'=>false,
            'join_sequence'=>array(
                'patient_visit.patient_id=patient.patient_id',
                'department.department_id=patient_visit.department_id',
                'unit.unit_id=patient_visit.unit',
                'area.area_id=patient_visit.area',
            ),     // patient_visit -> test -> test_master
            'group_by'=>array('patient_id'),
            'having'=>false,
            'limit'=>1000
        ),
        'get_patient'=>array(
            'filters'=>array(   // set or false
                '='=>array('patient.patient_id')
            ),
            'select'=>"patient.*",
            'from'=>'patient',
            'where'=>false,
            'join_sequence'=>false,
            'group_by'=>false,
            'having'=>false,
            'limit'=>5000,
            'apply_date'=>false
        ),
        'patient_visits_all'=>array(
            'filters'=>array(   // set or false
                '='=>array('patient.patient_id')
            ),
            'select'=>"patient.patient_id, patient.gender, CONCAT(patient.first_name,' ', patient.last_name) as name, CONCAT(patient.phone,' ', patient.alt_phone) as phone, patient.age_years, patient.age_months, patient.age_days, CONCAT(patient.father_name,' ', patient.mother_name, ' ', patient.spouse_name) as parent_spouse, CONCAT(patient.father_name,' ', patient.mother_name, ' ', patient.spouse_name) as relative, patient.place, patient.address, patient_visit.hosp_file_no, patient_visit.admit_date, patient_visit.visit_type, patient_visit.admit_time, patient_visit.outcome_date, patient_visit.outcome_time, patient_visit.outcome, patient_visit.admit_weight, patient_visit.pulse_rate, patient_visit.temperature, patient_visit.respiratory_rate, patient_visit.presenting_complaints, patient_visit.past_history, patient_visit.family_history, patient_visit.clinical_findings, patient_visit.cvs, patient_visit.rs, patient_visit.pa, patient_visit.cns, patient_visit.final_diagnosis, patient_visit.advise, patient_visit.visit_id, CONCAT(staff.first_name, staff.last_name) as doctor_name, staff.designation, department.department, CONCAT(unit.unit_name, area.area_name) as unit_name, patient_visit.sbp, patient_visit.dbp, patient_visit.blood_sugar, patient_visit.hb, patient_visit.hb1ac, patient_visit.visit_id, patient_visit.signed_consultation",
            'from'=>'patient',
            'where'=>false,
            'join_sequence'=>array(
                'patient_visit.patient_id=patient.patient_id',
                'department.department_id=patient_visit.department_id',
                'unit.unit_id=patient_visit.unit',
                'area.area_id=patient_visit.area',
                'staff.staff_id = patient_visit.signed_consultation'
            ),     // patient_visit -> test -> test_master
            'group_by'=>false,
            'having'=>false,
            'limit'=>5000,
            'apply_date'=>false
        ),
        'clinical_notes'=>array(
            'filters'=>array(   // set or false
                '='=>array('patient.patient_id')
            ),
            'select'=>"patient_clinical_notes.note_time, patient_clinical_notes.clinical_note, patient_clinical_notes.visit_id",
            'from'=>'patient',
            'where'=>false,
            'join_sequence'=>array(
                'patient_visit.patient_id=patient.patient_id',
                'patient_clinical_notes.visit_id=patient_visit.visit_id'
            ),     // patient_visit -> test -> test_master
            'group_by'=>false,
            'having'=>false,
            'limit'=>5000,
            'apply_date'=>false
        ),
        'tests_ordered'=>array(
            'filters'=>array(   // set or false
                '='=>array('patient.patient_id')
            ),
            'select'=>"test_order.order_id, test_order.order_date_time, test_order.visit_id, test.test_result as numeric_result, test.test_result_binary as binary_result, test.test_result_text  as text_result, test.test_status, test_master.test_name, specimen_type.specimen_type,test_order.visit_id",
            'from'=>'patient',
            'where'=>false,
            'join_sequence'=>array(
                'patient_visit.patient_id=patient.patient_id',
                'test_order.visit_id=patient_visit.visit_id',
                'test.order_id = test_order.order_id',
                'test_master.test_master_id = test.test_master_id',
                'test_sample.order_id = test_order.order_id',
                'specimen_type.specimen_type_id = test_sample.specimen_type_id'
            ),     // patient_visit -> test -> test_master
            'group_by'=>false,
            'having'=>false,
            'limit'=>5000,
            'apply_date'=>false,
            'join_type'=>''
        ),
        'prescriptions'=>array(
            'filters'=>array(   // set or false
                '='=>array('patient.patient_id')
            ),
            'select'=>"prescription.frequency, prescription.duration, prescription.morning, prescription.afternoon, prescription.evening, prescription.quantity, prescription.note, generic_item_id, generic_name as item_name, patient_visit.visit_id, item_form",
            'from'=>'patient',
            'where'=>false,
            'join_sequence'=>array(
                'patient_visit.patient_id=patient.patient_id',
                'prescription.visit_id=patient_visit.visit_id',
                'generic_item.generic_item_id = prescription.item_id',
                'item_form.item_form_id = generic_item.form_id'
            ),     // patient_visit -> test -> test_master
            'group_by'=>false,
            'having'=>false,
            'limit'=>5000,
            'apply_date'=>false
        ),
        'Condition_met_detail'=>array(
            'filters'=>array(           // set or false test.test_result >= post
                '>='=>array('hb1ac-patient_visit.hb1ac'),
                '<='=>array('hb1ac-patient_visit.hb'),
                '>='=>array('hb1ac-patient_visit.sbp'),
                '>='=>array('hb1ac-patient_visit.dbp'),
                '>='=>array('hb1ac-patient_visit.blood_sugar')
            ),
            'select'=>"patient.patient_id, CONCAT(patient.first_name,' ', patient.last_name) as name, patient_visit.admit_date,GROUP_CONCAT(patient_visit.hb1ac SEPARATOR ', ') as hb1ac,GROUP_CONCAT(patient_visit.hb SEPARATOR ', ') as HB,GROUP_CONCAT(patient_visit.sbp SEPARATOR ', ') as SBP,GROUP_CONCAT(patient_visit.dbp SEPARATOR ', ') as DBP,GROUP_CONCAT(patient_visit.blood_sugar SEPARATOR ', ') as blood_sugar",
            'from'=>'patient',
            'where'=>false,
            'join_sequence'=>array(
                'patient_visit.patient_id=patient.patient_id'
            ),
            'group_by'=>array('patient_id'),
            'having'=>false,
            'limit'=>1000
        ),
        'vitals_detailed'=>array(
            'filters'=>array(   // set or false
                '>='=>array('sbp-patient_visit.sbp','dbp-patient_visit.dbp','rbs-patient_visit.blood_sugar','hba1c-patient_visit.hb1ac'),
                '<='=>array('hb-patient_visit.hb')
            ),
            'select'=>"patient.patient_id, patient_visit.hosp_file_no as OP_IP_Number, DATE_FORMAT(patient_visit.admit_date, '%d %b %Y') as date, patient_visit.admit_time as time, patient.gender, CONCAT(patient.first_name,' ', patient.last_name) as name, patient.age_years, CONCAT(patient.father_name,' ', patient.mother_name, ' ', patient.spouse_name) as relative, patient.place, CONCAT(patient.phone, ' ', patient.alt_phone) as phone, department.department, CONCAT(unit.unit_name, '-', area.area_name) as Unit, patient_visit.admit_weight, GROUP_CONCAT(patient_visit.sbp SEPARATOR ', ') as SBP,GROUP_CONCAT(patient_visit.dbp SEPARATOR ', ') as DBP,GROUP_CONCAT(patient_visit.blood_sugar SEPARATOR ', ') as blood_sugar, GROUP_CONCAT(patient_visit.hb SEPARATOR ', ') as HB,GROUP_CONCAT(patient_visit.hb1ac SEPARATOR ', ') as HB1AC",
            'from'=>'patient',
            'where'=>false,
            'join_sequence'=>array(
                'patient_visit.patient_id=patient.patient_id',
                'department.department_id=patient_visit.department_id',
                'unit.unit_id=patient_visit.unit',
                'area.area_id=patient_visit.area',
            ),     // patient_visit -> test -> test_master
            'group_by'=>array('patient_id'),
            'having'=>false,
            'limit'=>5000,
            'apply_date'=>true
        ),
        'op_vitals_detailed'=>array(
            'filters'=>array(   // set or false                
                '='=>array('department-department.department_id','unit-unit.unit_id','area-area.area_id','visit_name-visit_name.visit_name_id')
            ),
            'select'=>"patient.patient_id as Patient_ID, patient_visit.hosp_file_no as OP_Number, DATE_FORMAT(patient_visit.admit_date, '%d %b %Y') as date, patient_visit.admit_time as time, CONCAT(patient.first_name,' ', patient.last_name) as name, patient.gender, CONCAT(IF(patient.age_years > 0, CONCAT(patient.age_years, 'Y'), ' '), IF(patient.age_months > 0, CONCAT(patient.age_months, 'M'), ' '), IF(patient.age_days > 0, CONCAT(patient.age_days, 'Y'), ' ')) as age, CONCAT(patient.father_name,' ', patient.mother_name, ' ', patient.spouse_name) as relative, CONCAT(patient.address, '. ', patient.place) as address, CONCAT(IF(patient.phone !=0, patient.phone, ''),', ',IF(patient.alt_phone!=0, patient.alt_phone, '')) as phone, (CASE WHEN (staff.first_name IS NOT NULL OR staff.last_name IS NOT NULL) THEN CONCAT(staff.first_name, ' ', staff.last_name) ELSE ' ' END) as doctor,department.department, (CASE WHEN CONCAT(unit.unit_name, '-', area.area_name) IS NOT NULL THEN CONCAT(unit.unit_name, '-', area.area_name) ELSE ' ' END) as Unit__Area, (IF(patient_visit.admit_weight>0, CONCAT(patient_visit.admit_weight, ', '), '')) as Weight, (IF(patient_visit.sbp>0, CONCAT(patient_visit.sbp, ', '), '')) as SBP,(IF(patient_visit.dbp>0, CONCAT(patient_visit.dbp, ', '), '')) as DBP,(IF(patient_visit.blood_sugar>0,CONCAT(patient_visit.blood_sugar, ', '),'')) as RBS, (if(patient_visit.hb>0,CONCAT(patient_visit.hb, ', '), '')) as Hb,(IF(patient_visit.hb1ac>0,CONCAT(patient_visit.hb1ac, ', '), '')) as Hb1AC, (IF(mlc.mlc_number IS NOT NULL, CONCAT(mlc.mlc_number, ', '), '')) as MLC_Number",
            'from'=>'patient',
            'where'=>array('=' => array('OP-patient_visit.visit_type')),
            'join_sequence'=>array(
                'patient_visit.patient_id=patient.patient_id',
                'staff.staff_id=patient_visit.signed_consultation',
                'department.department_id=patient_visit.department_id',
                'unit.unit_id=patient_visit.unit',
                'area.area_id=patient_visit.area',
                'mlc.visit_id=patient_visit.visit_id',
                'visit_name.visit_name_id = patient_visit.visit_name_id',
            ),     // patient_visit -> test -> test_master
            'group_by'=>false,//array('patient_id'),
            'having'=>false,
            'limit'=>5000,
            'apply_date'=>true,
            'order_by' => 'patient_visit.admit_date asc, patient_visit.admit_time asc',
            'session_filter'=>array('hospital.hospital_id'=>'patient_visit.hospital_id')
        ),
        'patient_id'=>array(
            'filters'=>array(   // set or false
                '='=>array('patient_visit.visit_id')
            ),
            'select'=>"patient.patient_id",
            'from'=>'patient_visit',
            'where'=>false,
            'join_sequence'=>array(
                'patient.patient_id=patient_visit.patient_id'
            ),
            'group_by'=>false,
            'having'=>false,
            'limit'=>1,
            'apply_date'=>false
        ),
        'prescription_report_with_frequency'=>array(
            'filters'=>array(   // set or false
                '='=>array('patient_visit.signed_consultation', 'patient_visit.hospital_id')    //Doctor_id
            ),
            'select'=>"drug_type.drug_type, generic_item.generic_name, SUM(1) prescriptions, 
            ROUND(SUM(CASE item_form.item_form_id WHEN 2 THEN 
            CASE WHEN prescription.frequency ='Daily' THEN 
            prescription.duration*(prescription.morning/2+prescription.afternoon/2+prescription.evening/2) WHEN prescription.frequency ='Alternate Days' THEN prescription.duration*(prescription.morning/2+prescription.afternoon/2+prescription.evening/2)/2 ELSE 0 END ELSE 1 END),2) as quantity",  //ROUND(AVG(prescription.duration),2) as average_duration
            'from'=>'patient_visit',
            'where'=>false,
            'join_sequence'=>array(
                'prescription.visit_id=patient_visit.visit_id',
                'generic_item.generic_item_id=prescription.item_id',
                'item_form.item_form_id=generic_item.form_id',
                'drug_type.drug_type_id=generic_item.drug_type_id'
            ),
            'group_by'=>array('prescription.item_id'),
            'having'=>false,
            'apply_date'=>true,
            'join_type'=>'',
            'session_filter'=>array('hospital.hospital_id'=>'patient_visit.hospital_id')
        ),
        'prescription_report'=>array(
            'filters'=>array(   // set or false
                '='=>array('patient_visit.signed_consultation', 'patient_visit.hospital_id')    //Doctor_id
            ),
            'select'=>"drug_type.drug_type, generic_item.generic_name, SUM(1) prescriptions, 
            ROUND(SUM(if(item_form.item_form_id = 2, (IF(prescription.morning > 0, 1, 0 ) + IF(prescription.afternoon > 0, 1, 0) + IF(prescription.evening > 0, 1, 0))*prescription.duration, 1)), 2) as quantity",  //ROUND(AVG(prescription.duration),2) as average_duration
            'from'=>'patient_visit',
            'where'=>false,
            'join_sequence'=>array(
                'prescription.visit_id=patient_visit.visit_id',
                'generic_item.generic_item_id=prescription.item_id',
                'item_form.item_form_id=generic_item.form_id',
                'drug_type.drug_type_id=generic_item.drug_type_id'
            ),
            'group_by'=>array('prescription.item_id'),
            'having'=>false,
            'apply_date'=>true,
            'join_type'=>'',
            'session_filter'=>array('hospital.hospital_id'=>'patient_visit.hospital_id')
        ),
        'doctors'=>array(
            'filters'=>false,
            'select'=>"DISTINCT(patient_visit.signed_consultation),staff.first_name, staff.last_name",
            'from'=>'patient_visit',
            'where'=>false,
            'join_sequence'=>array(
                'staff.staff_id=patient_visit.signed_consultation'
            ),
            'group_by'=>array('patient_visit.signed_consultation'),
            'having'=>false,
            'apply_date'=>true,
            'join_type'=>'',
            'session_filter'=>array('patient_visit.hospital_id')
        ),
        'department'=>array(
            'filters'=>false,
            'select'=>"*",
            'from'=>'department',
            'where'=>false,
            'join_sequence'=>false,
            'group_by'=>false,
            'having'=>false,
            'apply_date'=>false,
            'join_type'=>false,
            'session_filter'=>array('hospital.hospital_id'=>'hospital_id')
        ), 
        'unit'=>array(
            'filters'=>false,
            'select'=>"*",
            'from'=>'unit',
            'where'=>false,
            'join_sequence'=>array(
                'department.department_id=unit.department_id'
            ),
            'group_by'=>false,
            'having'=>false,
            'apply_date'=>false,
            'join_type'=>false,
            'session_filter'=>array('hospital.hospital_id'=>'department.hospital_id')
        ), 
        'area'=>array(
            'filters'=>false,
            'select'=>"*",
            'from'=>'area',
            'where'=>false,
            'join_sequence'=>array(
                'department.department_id=area.department_id'
            ),
            'group_by'=>false,
            'having'=>false,
            'apply_date'=>false,
            'join_type'=>false,
            'session_filter'=>array('hospital.hospital_id'=>'department.hospital_id')
        ), 
        'visit_name'=>array(
            'filters'=>false,
            'select'=>"*",
            'from'=>'visit_name',
            'where'=>false,
            'join_sequence'=>false,
            'group_by'=>false,
            'having'=>false,
            'apply_date'=>false,
            'join_type'=>false,
            'session_filter'=>false
        ),
        'follow_up_report'=>array(
            'filters'=>array(
                '='=>array('admit_date-patient_visit.admit_date','visit_type-patient_visit.visit_type')
            ),            
            'from'=>false,
            'where'=>false,
            'join_sequence'=>false,
            'group_by'=>array('visit_id'),
            'having'=>false,
            'apply_date'=>false,
            'join_type'=>false,
            'session_filter'=>array('hospital.hospital_id'=>'patient_visit.hospital_id'),
            'order_by'=>'patient.patient_id ASC, patient_visit.admit_date ASC',
            'select'=>"patient.patient_id AS Patient_ID,
            CONCAT(patient.first_name,' ',patient.last_name) AS Name,
            patient.age_years AS Age,
            patient.gender AS Gender,
            patient.address AS Address,
            patient.phone AS Phone,
            patient.father_name AS Father,
            patient.spouse_name AS Spouse,
            patient_visit.hosp_file_no AS OP,
            DATE_FORMAT(patient_visit.admit_date,'%d-%b-%Y')AS Date,
            IF(patient_visit.admit_weight IS NULL OR patient_visit.admit_weight = '', '', patient_visit.admit_weight) AS Weight,
            IF(patient_visit.sbp IS NULL OR patient_visit.sbp = '', '', patient_visit.sbp) AS SBP,
            IF(patient_visit.dbp IS NULL OR patient_visit.dbp = '', '', patient_visit.dbp) AS DBP,
            IF(patient_visit.pulse_rate IS NULL OR patient_visit.pulse_rate = '', '', patient_visit.pulse_rate) AS Pulse,
            IF(patient_visit.blood_sugar IS NULL OR patient_visit.blood_sugar = '', '', patient_visit.blood_sugar) AS RBS,
            IF(patient_visit.hb IS NULL OR patient_visit.hb = '', '', patient_visit.hb) AS Hb,
            IF(patient_visit.hb1ac IS NULL OR patient_visit.hb1ac = '', '', patient_visit.hb1ac) AS HbA1C,
            IF(CONCAT(staff.first_name,' ',staff.last_name) IS NULL OR CONCAT(staff.first_name,' ',staff.last_name) = '', '', CONCAT(staff.first_name,' ',staff.last_name)) AS Doctor,
            CONCAT(IF(patient_visit.presenting_complaints IS NULL OR patient_visit.presenting_complaints = '', '', concat('SYMPTOMS: ', patient_visit.presenting_complaints)),
            IF(patient_visit.past_history IS NULL OR patient_visit.past_history = '', '', concat(', PAST HISTORY: ', patient_visit.past_history)),
            IF(patient_visit.family_history IS NULL OR patient_visit.family_history = '', '', concat(', FAMILY HISTORY: ', patient_visit.family_history)), 
            IF(patient_visit.clinical_findings IS NULL OR patient_visit.clinical_findings = '', '', concat(', CLINICAL FINDINGS: ', patient_visit.clinical_findings)),
            IF(patient_visit.cvs IS NULL OR patient_visit.cvs = '', '', concat(', CVS: ', patient_visit.cvs)),
            IF(patient_visit.rs IS NULL OR patient_visit.rs = '', '', concat(', RS: ', patient_visit.rs)),
            IF(patient_visit.pa IS NULL OR patient_visit.pa = '', '', concat(', PA: ', patient_visit.pa)),
            IF(patient_visit.cns IS NULL OR patient_visit.cns = '', '', concat(', CNS: ', patient_visit.cns)),
            IF(patient_visit.cxr IS NULL OR patient_visit.cxr = '', '', concat(', CXR: ', patient_visit.cxr)),
            IF(add_note.note IS NULL OR add_note.note = '', '', concat(', NOTE: ', add_note.note)),
            IF(patient_visit.final_diagnosis IS NULL OR patient_visit.final_diagnosis = '', '', concat(', DIAGNOSIS: ', patient_visit.final_diagnosis)),
            IF(patient_visit.decision IS NULL OR patient_visit.decision = '', '', concat(', DECISION: ', patient_visit.decision)),
            IF(patient_visit.advise IS NULL OR patient_visit.advise = '', '', concat(', ADVISE: ', patient_visit.advise))) AS Clinical_Notes,
            IF(           
            (GROUP_CONCAT((CONCAT(generic_item.generic_name,' - ',prescription.note,'-',prescription.duration,'Days ', prescription.morning,'-', prescription.afternoon,'-', prescription.evening,' '))SEPARATOR '| ')) IS NULL OR
            (GROUP_CONCAT((CONCAT(generic_item.generic_name,' - ',prescription.note,'-',prescription.duration,'Days ', prescription.morning,'-', prescription.afternoon,'-', prescription.evening,' '))SEPARATOR '| ')) = '','', 
            (GROUP_CONCAT((CONCAT(generic_item.generic_name,' - ',prescription.note,'-',prescription.duration,'Days ', prescription.morning,'-', prescription.afternoon,'-', prescription.evening,' '))SEPARATOR '| '))) AS Prescription 
            FROM patient INNER JOIN patient_visit USING (patient_id)
            LEFT JOIN staff ON patient_visit.signed_consultation = staff.staff_id 
            LEFT JOIN (SELECT patient_clinical_notes.visit_id, GROUP_CONCAT(patient_clinical_notes.clinical_note SEPARATOR ',') AS note FROM patient_clinical_notes GROUP BY patient_clinical_notes.visit_id) AS add_note USING (visit_id) LEFT JOIN prescription USING (visit_id) LEFT JOIN generic_item ON prescription.item_id = generic_item.generic_item_id LEFT JOIN item_form ON generic_item.form_id = item_form.item_form_id"
        ),
        'patient_vitals'=>array(
            'filters'=>false,            
            'from'=>false,
            'where'=>array('='=>array('OP-patient_visit.visit_type')),
            'join_sequence'=>false,
            'group_by'=>array('visit_id'),
            'having'=>false,
            'apply_date'=>false,
            'join_type'=>false,
            'session_filter'=>array('hospital.hospital_id'=>'patient_visit.hospital_id'),
            'order_by'=>'patient_visit.admit_date ASC',
            'select'=>"
            DATE_FORMAT(
                patient_visit.admit_date,
                '%d-%b-%Y'
            ) AS DATE,
            IF(
                patient_visit.admit_weight IS NULL OR patient_visit.admit_weight = '',
                '',
                patient_visit.admit_weight
            ) AS Weight,
            IF(
                patient_visit.sbp IS NULL OR patient_visit.sbp = '',
                '',
                patient_visit.sbp
            ) AS SBP,
            IF(
                patient_visit.dbp IS NULL OR patient_visit.dbp = '',
                '',
                patient_visit.dbp
            ) AS DBP,
            IF(
                patient_visit.pulse_rate IS NULL OR patient_visit.pulse_rate = '',
                '',
                patient_visit.pulse_rate
            ) AS Pulse,
            IF(
                patient_visit.blood_sugar IS NULL OR patient_visit.blood_sugar = '',
                '',
                patient_visit.blood_sugar
            ) AS RBS,
            IF(
                patient_visit.hb IS NULL OR patient_visit.hb = '',
                '',
                patient_visit.hb
            ) AS Hb,
            IF(
                patient_visit.hb1ac IS NULL OR patient_visit.hb1ac = '',
                '',
                patient_visit.hb1ac
            ) AS HbA1C,
            IF(
                CONCAT(
                    staff.first_name,
                    ' ',
                    staff.last_name
                ) IS NULL OR CONCAT(
                    staff.first_name,
                    ' ',
                    staff.last_name
                ) = '',
                '',
                CONCAT(
                    staff.first_name,
                    ' ',
                    staff.last_name
                )
            ) AS Doctor,
            CONCAT(
                IF(
                    patient_visit.presenting_complaints IS NULL OR patient_visit.presenting_complaints = '',
                    '',
                    CONCAT(
                        'SYMPTOMS: ',
                        patient_visit.presenting_complaints
                    )
                ),
                IF(
                    patient_visit.past_history IS NULL OR patient_visit.past_history = '',
                    '',
                    CONCAT(
                        ', PAST HISTORY: ',
                        patient_visit.past_history
                    )
                ),
                IF(
                    patient_visit.family_history IS NULL OR patient_visit.family_history = '',
                    '',
                    CONCAT(
                        ', FAMILY HISTORY: ',
                        patient_visit.family_history
                    )
                ),
                IF(
                    patient_visit.clinical_findings IS NULL OR patient_visit.clinical_findings = '',
                    '',
                    CONCAT(
                        ', CLINICAL FINDINGS: ',
                        patient_visit.clinical_findings
                    )
                ),
                IF(
                    patient_visit.cvs IS NULL OR patient_visit.cvs = '',
                    '',
                    CONCAT(', CVS: ', patient_visit.cvs)
                ),
                IF(
                    patient_visit.rs IS NULL OR patient_visit.rs = '',
                    '',
                    CONCAT(', RS: ', patient_visit.rs)
                ),
                IF(
                    patient_visit.pa IS NULL OR patient_visit.pa = '',
                    '',
                    CONCAT(', PA: ', patient_visit.pa)
                ),
                IF(
                    patient_visit.cns IS NULL OR patient_visit.cns = '',
                    '',
                    CONCAT(', CNS: ', patient_visit.cns)
                ),
                IF(
                    patient_visit.cxr IS NULL OR patient_visit.cxr = '',
                    '',
                    CONCAT(', CXR: ', patient_visit.cxr)
                ),
                IF(
                    add_note.note IS NULL OR add_note.note = '',
                    '',
                    CONCAT(', NOTE: ', add_note.note)
                ),
                IF(
                    patient_visit.final_diagnosis IS NULL OR patient_visit.final_diagnosis = '',
                    '',
                    CONCAT(
                        ', DIAGNOSIS: ',
                        patient_visit.final_diagnosis
                    )
                ),
                IF(
                    patient_visit.decision IS NULL OR patient_visit.decision = '',
                    '',
                    CONCAT(
                        ', DECISION: ',
                        patient_visit.decision
                    )
                ),
                IF(
                    patient_visit.advise IS NULL OR patient_visit.advise = '',
                    '',
                    CONCAT(
                        ', ADVISE: ',
                        patient_visit.advise
                    )
                )
            ) AS Clinical_Notes,
            IF(
                (
                    GROUP_CONCAT(
                        (
                            CONCAT(
                                generic_item.generic_name,
                                ' - ',
                                prescription.note,
                                '-',
                                prescription.duration,
                                'Days ',
                                prescription.morning,
                                '-',
                                prescription.afternoon,
                                '-',
                                prescription.evening,
                                ' '
                            )
                        ) SEPARATOR '| '
                    )
                ) IS NULL OR(
                    GROUP_CONCAT(
                        (
                            CONCAT(
                                generic_item.generic_name,
                                ' - ',
                                prescription.note,
                                '-',
                                prescription.duration,
                                'Days ',
                                prescription.morning,
                                '-',
                                prescription.afternoon,
                                '-',
                                prescription.evening,
                                ' '
                            )
                        ) SEPARATOR '| '
                    )
                ) = '',
                '',
                (
                    GROUP_CONCAT(
                        (
                            CONCAT(
                                generic_item.generic_name,
                                ' - ',
                                prescription.note,
                                '-',
                                prescription.duration,
                                'Days ',
                                prescription.morning,
                                '-',
                                prescription.afternoon,
                                '-',
                                prescription.evening,
                                ' '
                            )
                        ) SEPARATOR '| '
                    )
                )
            ) AS Prescription
        FROM
            patient
        INNER JOIN patient_visit USING(patient_id)
        LEFT JOIN staff ON patient_visit.signed_consultation = staff.staff_id
        LEFT JOIN(
            SELECT
                patient_clinical_notes.visit_id,
                GROUP_CONCAT(
                    patient_clinical_notes.clinical_note SEPARATOR ', '
                ) AS note
            FROM
                patient_clinical_notes
            GROUP BY
                patient_clinical_notes.visit_id
        ) AS add_note USING(visit_id)
        LEFT JOIN prescription USING(visit_id)
        LEFT JOIN generic_item ON prescription.item_id = generic_item.generic_item_id
        LEFT JOIN item_form ON generic_item.form_id = item_form.item_form_id"
        )
    );
    
    function __construct() {
        parent::__construct();
    }

    function simple_join($query, $post_data=false, $params=false) {
        // Failure condition
        if(!array_key_exists($query, $this->queries))
            return false;
        if(!$post_data){
            $post_data = $this->security->xss_clean($_POST);
        }
        
        //var_dump($post_data);
        // Filters{operator=>array(input_key-table_name.column_name)}
        $filters = $this->queries[$query]['filters'] ? $this->queries[$query]['filters'] : array();
        foreach($filters as $op => $filters) {
            foreach($filters as $filter){
                $temp = explode('-', $filter);      // Filter name to input field name
                $column = '';
                $input = '';
                $mandatory = false;                 // Mandatory filter
                if(sizeof($temp)>1){
                    $input = $temp[0];
                    $column = $temp[1];
                    if(strpos($input, '*', 0) === 0){
                        $mandatory = true;
                        $temp = substr($input, 1);
                        $input = $temp;
                    }
                } else {
                    $temp = explode('.', $filter);
                    $input = $temp[1];
                    $column = $filter;
                }
                
                if(array_key_exists($input, $post_data)) { //EMPTY IS TEMPORARY FIX ONLY
                    $value = $post_data[$input];
        
                    if($value != ''){
                        $value = $post_data[$input];
                        $this->db->where("$column ".$op, "$value");
                        
                //        $this->db->where("$column IS NOT NULL AND $column != '' AND $column!=0");
                    } else if($mandatory){
                      //  return array(0);
                    } else{
                     //   $this->db->where("$column IS NOT NULL AND $column != '' AND $column!=0");
                    }                    
                }
            }
        }

        // query extraction
        $select = $this->queries[$query]['select'] ? $this->queries[$query]['select'] : array();
        $from = $this->queries[$query]['from'] ? $this->queries[$query]['from'] : array();
        $where = $this->queries[$query]['where'] ? $this->queries[$query]['where'] : array();
        $join_sequence = $this->queries[$query]['join_sequence'] ? $this->queries[$query]['join_sequence'] : array();
        $group_by = $this->queries[$query]['group_by'] ? $this->queries[$query]['group_by'] : array();
        $having = $this->queries[$query]['having'] ? $this->queries[$query]['having'] : array();
        $limit = array_key_exists('limit', $this->queries[$query]) ? $this->queries[$query]['limit'] : 1000;
        $apply_date = array_key_exists('apply_date', $this->queries[$query]) ? $this->queries[$query]['apply_date'] : true;
        $join_type = array_key_exists('join_type', $this->queries[$query]) ? $this->queries[$query]['join_type'] : 'left';
        $order_by = array_key_exists('order_by', $this->queries[$query]) ? $this->queries[$query]['order_by'] : false;
        $session_filter = array_key_exists('session_filter', $this->queries[$query]) && sizeof($this->queries[$query]['session_filter']) > 0 && $this->queries[$query]['session_filter']? true : false;
        $this->db->select($select, false);
        $this->db->from($from);
        
        // Additional params
        if($params){
            foreach($params as $key=>$param){
                $this->db->where($key, $param);
            }            
        }

        // Default where condition // Date
        // Set to today and submit by default
        if($apply_date && array_key_exists('from_date', $post_data) && array_key_exists('to_date', $post_data)){
            if($post_data['from_date']){
                $from_date = date("Y-m-d",strtotime($post_data['from_date']));
                $to_date = date("Y-m-d",strtotime($post_data['to_date']));
                $this->db->where('(patient_visit.admit_date BETWEEN "'.$from_date.'" AND "'.$to_date.'")');
            }
        }
        else if($apply_date){
            $date = date("Y-m-d");
            $this->db->where('(patient_visit.admit_date BETWEEN "'.$date.'" AND "'.$date.'")');
        }
        // Session filters
        if($session_filter){    // key.key => table_name.column_name
            foreach($this->queries[$query]['session_filter'] as $session_keys => $column){
                $temp = explode('.', $session_keys);
                if(sizeof($temp) > 1){
                    $filter = $this->session->userdata($temp[0])[$temp[1]];
                    $this->db->where("$column", "$filter");
                } else{
                    $filter = $this->session->userdata($temp[0]);
                    $this->db->where("$column", "$filter");
                }                
            }
        }
        
        // Where conditions{string}{(operator=>value-table_name.column_name)}
        foreach($where as $op => $columns) {
            foreach($columns as $column){
                $value_table_column = explode('-', $column);
                if($op != ''){
                    $this->db->where("$value_table_column[1] ".$op, "$value_table_column[0]");
                }else {
                    $this->db->where("$column");
                }                
            }
        }

        // Join conditions{join_from_table_name.column_name, join_to_table_name.column_name}
        foreach($join_sequence as $join) {
            $tables = explode('=', $join);
            $temp = explode('.', $tables[0]);
            $table_one = $temp[0];
            $this->db->join("$table_one", "$join", $join_type);
        }
        // Group by conditions{table_name.column_name, table_name.column_name}{string}
        foreach($group_by as $group) {
            $this->db->group_by("$group");
        }
        // Order by conditions- {Column name asc/desc, ...}
        if($order_by)
            $this->db->order_by($order_by);

        // Having conditions{$op=>value-table_name.column_name}
        foreach($having as $op => $column) {
            $value = explode('-', $column);
            $value = $value[0];
            $this->db->having("$column $op $value");
        }
        // Execute query
        $this->db->limit($limit);
        $query = $this->db->get();
        // echo $this->db->last_query();
        $result = $query->result();    
        return $result;
    }
}