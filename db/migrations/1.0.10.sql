ALTER TABLE `patient_followup` ADD `ndps` TINYINT NOT NULL AFTER `note`, ADD `drug` TEXT NOT NULL AFTER `ndps`, ADD `dose` TEXT NOT NULL AFTER `drug`, ADD `last_dispensed_date` DATE NULL DEFAULT NULL AFTER `dose`, ADD `last_dispensed_quantity` INT NOT NULL AFTER `last_dispensed_date`;

ALTER TABLE `patient_visit` CHANGE `outcome` `outcome` VARCHAR(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Discharge,LAMA,Absconded,Death';
INSERT INTO `user_function`(`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES ('','issue_list','Issue List','issue list report');
INSERT INTO `user_function`(`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES ('','issue_summary','issue summry','issue summary report');
INSERT INTO `user_function` (`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES ('', 'followup_map', 'followup map', 'followup map');
INSERT INTO `user_function` (`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES ('', 'followup_summary', 'follow summary', 'follow summary');
ALTER TABLE `patient_followup` DROP `status_date`, DROP `last_visit_type`, DROP `last_visit_date`;
INSERT INTO `user_function` (`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES (NULL, 'delete_patient_visit_duplicate', '', 'Delete patient visit deuplicates');
INSERT INTO `user_function` (`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES (NULL, 'list_patient_visit_duplicate', 'list_patient_visit_duplicate', 'list patient visit duplicate');
INSERT INTO `user_function` (`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES (NULL, 'list_patient_edits', 'list_patient_edits', 'list patient edits');
INSERT INTO `print_layout` (`print_layout_id`, `print_layout_name`, `print_layout_page`) VALUES (NULL, 'Sticker Layout 3', 'sticker_layout3');
CREATE TABLE `patient_visit_duplicate` (
  `visit_id` int(7) NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `admit_id` int(7) NOT NULL,
  `visit_type` varchar(8) NOT NULL,
  `visit_name_id` int(11) NOT NULL,
  `patient_id` int(7) NOT NULL,
  `hosp_file_no` int(7) NOT NULL,
  `admit_date` date NOT NULL,
  `admit_time` time NOT NULL,
  `department_id` int(3) NOT NULL,
  `unit` int(11) NOT NULL,
  `area` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL,
  `nurse` varchar(50) NOT NULL,
  `insurance_case` varchar(1) NOT NULL,
  `insurance_id` int(11) NOT NULL,
  `insurance_no` varchar(10) NOT NULL,
  `presenting_complaints` varchar(500) NOT NULL,
  `past_history` varchar(500) NOT NULL,
  `family_history` longtext NOT NULL,
  `admit_weight` int(6) NOT NULL,
  `pulse_rate` int(3) NOT NULL,
  `respiratory_rate` int(3) NOT NULL,
  `temperature` int(3) NOT NULL,
  `sbp` int(3) NOT NULL,
  `dbp` int(3) NOT NULL,
  `spo2` int(3) DEFAULT NULL,
  `blood_sugar` double NOT NULL,
  `hb` double NOT NULL,
  `hb1ac` double NOT NULL,
  `clinical_findings` longtext NOT NULL,
  `cvs` text NOT NULL,
  `rs` text NOT NULL,
  `pa` text NOT NULL,
  `cns` text NOT NULL,
  `cxr` text NOT NULL,
  `provisional_diagnosis` varchar(500) NOT NULL,
  `signed_consultation` int(11) NOT NULL,
  `final_diagnosis` varchar(500) NOT NULL,
  `decision` text NOT NULL,
  `advise` text NOT NULL,
  `icd_10` varchar(4) NOT NULL,
  `icd_10_ext` varchar(1) NOT NULL,
  `discharge_weight` int(6) NOT NULL,
  `outcome` varchar(11) NOT NULL COMMENT 'Discharge,LAMA,Absconded,Death',
  `outcome_date` date NOT NULL,
  `outcome_time` time NOT NULL,
  `ip_file_received` date NOT NULL,
  `mlc` tinyint(1) NOT NULL,
  `arrival_mode` varchar(25) DEFAULT NULL,
  `referral_by_hospital_id` int(11) DEFAULT NULL,
  `insert_by_user_id` int(11) NOT NULL,
  `update_by_user_id` int(11) NOT NULL,
  `insert_datetime` datetime NOT NULL,
  `update_datetime` datetime NOT NULL,
  `appointment_with` int(11) DEFAULT NULL,
  `appointment_time` datetime DEFAULT NULL,
  `appointment_update_by` int(11) DEFAULT NULL,
  `appointment_update_time` datetime DEFAULT NULL,
  `summary_sent_time` datetime DEFAULT NULL,
  `temp_visit_id` int(11) NOT NULL,
  `appointment_status_id` int(11) DEFAULT NULL,
  `appointment_status_update_by` int(11) DEFAULT NULL,
  `appointment_status_update_time` datetime DEFAULT NULL
);
ALTER TABLE `patient_visit_duplicate` ADD `delete_id` INT NOT NULL AUTO_INCREMENT FIRST, ADD PRIMARY KEY (`delete_id`);
ALTER TABLE `patient_visit_duplicate` ADD `delete_datetime` DATETIME NOT NULL AFTER `appointment_status_update_time`, ADD `staff_id` INT NOT NULL AFTER `delete_datetime`;
INSERT INTO `user_function` (`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES (NULL, 'edit_patient_visits', 'edit_patient_visits', 'patient visits edits');
INSERT INTO `user_function` (`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES (NULL, 'list_edit_patient_visits', 'list_edit_patient_visits', 'list edit patient visits');
CREATE TABLE `patient_visits_edit_history` (
  `edit_id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `visit_id` int(11) NOT NULL,
  `table_name` varchar(200) NOT NULL,
  `field_name` varchar(200) NOT NULL,
  `previous_value` varchar(2000) NOT NULL,
  `new_value` varchar(2000) NOT NULL,
  `edit_date_time` datetime NOT NULL,
  `edit_user_id` int(11) NOT NULL
);
CREATE TABLE `counseling` (
  `counseling_id` int(11) NOT NULL,
  `visit_id` int(11) NOT NULL,
  `counseling_text_id` int(11) NOT NULL,
  `sequence_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL
);
CREATE TABLE `counseling_text` (
  `counseling_text_id` int(11) NOT NULL,
  `counseling_type_id` int(11) NOT NULL,
  `language_id` int(11) NOT NULL,
  `global_text` smallint(6) DEFAULT NULL COMMENT '1=>global, 0=>only hospital',
  `counseling_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `active_text` tinyint(4) DEFAULT NULL COMMENT '1=>active, 2=>inactive, ',
  `hospital_id` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL
);
CREATE TABLE `counseling_type` (
  `counseling_type_id` int(11) NOT NULL,
  `counseling_type` varchar(250) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `created_date_time` datetime DEFAULT NULL,
  `updated_date_time` datetime DEFAULT NULL
);

ALTER TABLE patient_visits_edit_history MODIFY COLUMN `edit_id` int(11) NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (`edit_id`); 

ALTER TABLE counseling MODIFY COLUMN `counseling_id` int(11) NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (`counseling_id`); 

ALTER TABLE counseling_text MODIFY COLUMN `counseling_text_id` int(11) NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (`counseling_text_id`); 

ALTER TABLE counseling_type MODIFY COLUMN `counseling_type_id` int(11) NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (`counseling_type_id`); 

ALTER TABLE `item_type` ADD `created_by` INT NOT NULL AFTER `item_type`, ADD `updated_by` INT NOT NULL AFTER `created_by`, ADD `created_date_time` DATETIME NULL DEFAULT NULL AFTER `updated_by`, ADD `updated_date_time` DATETIME NULL DEFAULT NULL AFTER `created_date_time`;

ALTER TABLE `item_form` ADD `created_by` INT NOT NULL AFTER `item_form`, ADD `updated_by` INT NOT NULL AFTER `created_by`, ADD `created_date_time` DATETIME NULL DEFAULT NULL AFTER `updated_by`, ADD `updated_date_time` DATETIME NULL DEFAULT NULL AFTER `created_date_time`;

ALTER TABLE `dosage` ADD `created_by` INT NOT NULL AFTER `dosage`, ADD `updated_by` INT NOT NULL AFTER `created_by`, ADD `created_date_time` DATETIME NULL DEFAULT NULL AFTER `updated_by`, ADD `updated_date_time` DATETIME NULL DEFAULT NULL AFTER `created_date_time`;

ALTER TABLE `drug_type` ADD `created_by` INT NOT NULL AFTER `description`, ADD `updated_by` INT NOT NULL AFTER `created_by`, ADD `created_date_time` DATETIME NULL DEFAULT NULL AFTER `updated_by`, ADD `updated_date_time` DATETIME NULL DEFAULT NULL AFTER `created_date_time`;

INSERT INTO `user_function` (`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES (NULL, 'delete_patient_followup', 'delete_patient_followup', 'Delete Patient Followup');

ALTER TABLE `helpline_call` ADD `updated_user_id` INT NOT NULL AFTER `update_date_time`;

ALTER TABLE `priority_type` ADD `created_by` INT NOT NULL AFTER `priority_type`, ADD `updated_by` INT NOT NULL AFTER `created_by`, ADD `created_date_time` DATETIME NULL DEFAULT NULL AFTER `updated_by`, ADD `updated_date_time` DATETIME NULL DEFAULT NULL AFTER `created_date_time`;

ALTER TABLE `visit_name` ADD `created_by` INT NOT NULL AFTER `inuse`, ADD `updated_by` INT NOT NULL AFTER `created_by`, ADD `created_date_time` DATETIME NULL DEFAULT NULL AFTER `updated_by`, ADD `updated_date_time` DATETIME NULL DEFAULT NULL AFTER `created_date_time`;

ALTER TABLE `patient_followup` CHANGE `note` `note` VARCHAR(1500) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;

ALTER TABLE patient_followup DROP COLUMN `route_primary_id`;

ALTER TABLE `patient_followup` ADD `death_date` DATE NULL DEFAULT NULL AFTER `update_time`, ADD `death_status` INT NOT NULL AFTER `death_date`;

INSERT INTO `user_function` (`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES (NULL, 'followup_summary_route', 'followup_summary_route', '');

INSERT INTO `user_function` (`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES (NULL, 'followup_summary_death_icdcode', 'followup_summary_death_icdcode', 'followup_summary_death_icdcode');

INSERT INTO `user_function` (`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES (NULL, 'followup_summary_death_routes', 'followup_summary_death_routes', 'followup_summary_death_routes');

ALTER TABLE `visit_name` ADD `op_ip` TINYINT NULL DEFAULT NULL AFTER `inuse`;

CREATE TABLE `hospital_print_layout` ( `id` INT NOT NULL AUTO_INCREMENT, `hospital_id` INT NOT NULL, `add_on_print_layout_id` INT NOT NULL, PRIMARY KEY (`id`) );

ALTER TABLE `hospital_print_layout` ADD `a6_print_layout_id` INT NOT NULL AFTER `add_on_print_layout_id`;

CREATE TABLE `hospital_bed` ( `hospital_bed_id` int(11) NOT NULL, `hospital_id` int(11) NOT NULL, `bed` varchar(100) NOT NULL);

CREATE TABLE `blood_donor_edit_history` (
  `edit_id` int(11) NOT NULL,
  `donor_id` int(11) NOT NULL,
  `table_name` varchar(250) NOT NULL,
  `field_name` varchar(250) NOT NULL,
  `previous_value` varchar(250) NOT NULL,
  `new_value` varchar(250) NOT NULL,
  `edit_date_time` datetime NOT NULL,
  `edit_user_id` int(11) NOT NULL
) 

ALTER TABLE `blood_donor_edit_history`
  ADD PRIMARY KEY (`edit_id`);

ALTER TABLE `blood_donor_edit_history`
  MODIFY `edit_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

INSERT INTO `user_function` (`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES (NULL, 'list_blood_donor_details_edit', 'list_blood_donor_details_edit', 'list blood donor details edit');

CREATE TABLE `patient_bed` (
  `id` int(11) NOT NULL,
  `patient_id` int(11) NOT NULL,
  `hospital_bed_id` int(11) NOT NULL,
  `details` text NOT NULL,
  `reservation_details` varchar(250) NOT NULL,
  `created_date` date DEFAULT NULL,
  `created_time` time DEFAULT NULL
)

ALTER TABLE `patient_bed`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `patient_bed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;