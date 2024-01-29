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