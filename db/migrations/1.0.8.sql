CREATE TABLE `http_status_code` (
  `status_code` int(11) NOT NULL,
  `status_text` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `http_status_code`
--

INSERT INTO `http_status_code` (`status_code`, `status_text`) VALUES
(200, 'Success'),
(400, 'Failed');
COMMIT;

CREATE TABLE `sms_helpline` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `from_helpline` varchar(20) NOT NULL,
 `to_receiver` varchar(20) NOT NULL,
 `date_created` datetime NOT NULL DEFAULT current_timestamp(),
 `date_updated` datetime DEFAULT NULL,
 `date_sent` datetime DEFAULT NULL,
 `sms_type` varchar(20) NOT NULL,
 `dlt_tid` varchar(20) NOT NULL,
 `sms_body` text NOT NULL,
 `sent_by_staff` int(11) NOT NULL,
 `status` varchar(50) NOT NULL,
 `status_code` varchar(20) NOT NULL,
 `detailed_status` varchar(100) NOT NULL,
 `detailed_status_code` varchar(10) DEFAULT NULL,
 `price` decimal(3,2) NOT NULL,
 `direction` varchar(10) NOT NULL,
 `sid` varchar(1000) NOT NULL COMMENT 'Unique SMS Id returned by telecom provider',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `sms_template` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `helpline_id` varchar(20) NOT NULL,
 `dlt_entity_id` varchar(20) NOT NULL,
 `dlt_tid` varchar(20) NOT NULL,
 `dlt_header` varchar(10) NOT NULL,
 `dlt_header_id` varchar(20) NOT NULL,
 `sms_type` varchar(50) NOT NULL,
 `template_name` varchar(150) NOT NULL,
 `template` text NOT NULL,
 `sms_default_id` int(11) NOT NULL,
 `sms_query_id` int(11) NOT NULL,
 `use_status` tinyint(4) NOT NULL COMMENT '1 for active and 0 for inactive. Only records with use_status=1 should be displayed in send SMS Modal',
 `edit_text_area` tinyint(4) NOT NULL COMMENT '1 for edit and 0 for diable edit. Only records with edit_text_area=1 can be allowed to edit in SMS Content text area in send SMS Modal. If edit_text_area=0 text area for sms content should be read only.',
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


ALTER TABLE `helpline_receiver` ADD `enable_sms` TINYINT(1) NULL AFTER `enable_outbound`;

INSERT INTO `user_function` (`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES (NULL, 'sms', 'SMS', '');

ALTER TABLE `sms_template` CHANGE `id` `sms_template_id` INT(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `sms_helpline` ADD `sms_template_id` INT NOT NULL AFTER `sms_type`;

ALTER TABLE `sms_template` CHANGE `template` `template` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `sms_helpline` CHANGE `sms_body` `sms_body` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `hospital` ADD `telehealth` TINYINT(1) NOT NULL DEFAULT '0' COMMENT 'Determine whether hospital is running as telemedicine (1) or not ' AFTER `helpline_id`;

CREATE TABLE `patient_consultation_summary` (
 `summary_link_patient_id` int(11) NOT NULL,
 `summary_link_patient_visit_id` int(11) NOT NULL,
 `summary_link_contents` text NOT NULL,
 `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `summary_link_contents_md5` varchar(50) NOT NULL,
 `last_download_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `totaldownloads` int(11) NOT NULL DEFAULT '0',
 PRIMARY KEY (`summary_link_patient_id`,`summary_link_patient_visit_id`),
 UNIQUE KEY `summary_link_contents_index` (`summary_link_contents_md5`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `sms_template` ADD `generate_by_query` TINYINT NOT NULL DEFAULT '0' COMMENT 'Check whether to generate sms content through method or not' AFTER `edit_text_area`;

ALTER TABLE `sms_template` ADD `generation_method` VARCHAR(100) NOT NULL AFTER `generate_by_query`;

ALTER TABLE `sms_template`
  DROP `sms_default_id`,
  DROP `sms_query_id`;

ALTER TABLE `sms_template` ADD `report_download_url` VARCHAR(100) NOT NULL AFTER `generation_method`;

ALTER TABLE `helpline_resolution_status` CHANGE `resolution_status` `resolution_status` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

CREATE TABLE `patient_document_upload_key` (
 `patient_id` int(11) NOT NULL,
 `visit_id` int(11) NOT NULL,
 `created_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `expires_at` datetime NOT NULL,
 `last_accessed_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
 `key_md5` varchar(50) NOT NULL,
 `no_of_access` int(11) NOT NULL DEFAULT '0',
 PRIMARY KEY (`patient_id`),
 UNIQUE KEY `index_md5` (`key_md5`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `defaults` (`default_id`, `default_tilte`, `default_description`, `default_type`, `default_unit`, `lower_range`, `upper_range`, `value`) VALUES ('patient_doc_link_expiry', 'Number of hours in which Patient summary will be available for users ', 'Number of hours in which Patient summary will be available for users ', 'Numeric', 'hours', NULL, NULL, '2');

ALTER TABLE `patient_document_upload` CHANGE `insert_by_staff_id` `insert_by_staff_id` INT(11) NULL;

ALTER TABLE `removed_patient_document_upload` CHANGE `insert_by_staff_id` `insert_by_staff_id` INT(11) NULL;

ALTER TABLE `removed_patient_document_upload` CHANGE `removed_by_staff_id` `removed_by_staff_id` INT(11) NULL;

ALTER TABLE `helpline_call`
  ADD COLUMN `department_id` INT(3);

ALTER TABLE `helpline_call_category`
  ADD COLUMN `helpline_id` INT(3),
  ADD COLUMN `status` TINYINT;
  
  
ALTER TABLE `visit_name` ADD `hospital_id` INT NULL AFTER `visit_name`, ADD `inuse` TINYINT(1) NULL COMMENT 'Value 1 indicates that visit type in use and 0 indicates value not in use' AFTER `hospital_id`;

CREATE TABLE `appointment_status` ( `id` INT NOT NULL AUTO_INCREMENT , `hospital_id` INT NOT NULL , `appointment_status` VARCHAR(50) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

ALTER TABLE `patient_visit` ADD `appointment_status_id` INT NULL AFTER `temp_visit_id`, ADD `appointment_status_update_by` INT NULL AFTER `appointment_status_id`, ADD `appointment_status_update_time` DATETIME NULL AFTER `appointment_status_update_by`;

INSERT INTO `user_function` (`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES (NULL, 'appointment_status', 'appointment_status', 'Status of the appointments');
