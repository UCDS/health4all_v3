CREATE TABLE `summary_calls` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `helpline` varchar(20) NOT NULL,
 `call_direction` varchar(20) NOT NULL,
 `call_type` varchar(20) NOT NULL,
 `date` date NOT NULL,
 `call_count` int(11) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `summary_unique_callers` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `helpline` varchar(20) NOT NULL,
 `date` text NOT NULL,
 `unique_callers` int(11) NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `user` ADD `active` TINYINT(1) NOT NULL DEFAULT '1'; 

Insert into defaults values ('login_status_deactive','Account Deactivated','','Text','','','','Account has been deactivated. Please contact admin.');

ALTER TABLE `defaults` CHANGE `value` `value` VARCHAR(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL;
Insert into defaults values ('session_timeout_message','Session TimeOut','','Text','','','','Session timed out. Please sign-in again!');

Insert into defaults values ('session_goback_message','Session GoBack','','Text','','','','Go back to home page');

Insert into defaults values ('session_idle_time','Session Iddle Time','','Numeric','','','',15);

ALTER TABLE `sms_template` ADD `hospital_id` int(1) ; 

ALTER TABLE `sms_template` ADD `default_sms` TINYINT(1) DEFAULT 0; 

ALTER TABLE hospital ADD auto_ip_number tinyint(1) DEFAULT 0;

ALTER TABLE `helpline_call` ADD INDEX `start_time_index` (`start_time`);

ALTER TABLE `patient_visit` DROP INDEX `hospital_id`;

ALTER TABLE `patient_visit` DROP INDEX `visit_type`;

ALTER TABLE `patient_visit` ADD INDEX `appointment_time` (`appointment_time`);

ALTER TABLE `indent` CHANGE `insert_user_id` `insert_user_id` INT(11) NOT NULL COMMENT 'staff_id';

ALTER TABLE `indent` CHANGE `update_user_id` `update_user_id` INT(11) NOT NULL COMMENT 'staff_id';

ALTER TABLE `indent_item` ADD `note` TEXT NOT NULL DEFAULT '' AFTER `consumption_status`; 

-- Recent additions as of Jan 26, 2023

ALTER TABLE `vendor_type` CHANGE `vendor_type_id` `vendor_type_id` INT(11) NOT NULL AUTO_INCREMENT; 

ALTER TABLE `vendor` CHANGE `vendor_id` `vendor_id` INT(11) NOT NULL AUTO_INCREMENT; 

ALTER TABLE `supply_chain_party` CHANGE `supply_chain_party_id` `supply_chain_party_id` INT(11) NOT NULL AUTO_INCREMENT; 