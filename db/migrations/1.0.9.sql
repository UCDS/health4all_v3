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















CREATE TABLE `patient_followup` (
  `patient_followup_id` int(11) NOT NULL,
  `patient_id` int(8) NOT NULL,
  `hospital_id` int(8) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `life_status` tinyint(4) NOT NULL COMMENT '''0'' - death ''1'' - Alive',
  `status_date` datetime NOT NULL,
  `icd_code` varchar(200) NOT NULL,
  `diagnosis` varchar(200) NOT NULL,
  `last_visit_type` varchar(60) NOT NULL,
  `last_visit_date` datetime NOT NULL,
  `priority_type_id` int(8) NOT NULL,
  `route_primary_id` int(8) NOT NULL,
  `route_secondary_id` int(8) NOT NULL,
  `volunteer_id` int(8) NOT NULL,
  `note` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `patient_followup`
  ADD PRIMARY KEY (`patient_followup_id`),
  ADD UNIQUE KEY `patient_id` (`patient_id`);
  ALTER TABLE `patient_followup`
  MODIFY `patient_followup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

CREATE TABLE `priority_type` (
  `priority_type_id` int(11) NOT NULL,
  `hospital_id` int(8) NOT NULL,
  `priority_type` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `priority_type`
  ADD PRIMARY KEY (`priority_type_id`);
  ALTER TABLE `priority_type`
  MODIFY `priority_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;


CREATE TABLE `route_primary` (
  `route_primary_id` int(11) NOT NULL,
  `hospital_id` int(8) NOT NULL,
  `route_primary` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `route_primary`
  ADD PRIMARY KEY (`route_primary_id`);
  ALTER TABLE `route_primary`
  MODIFY `route_primary_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;
CREATE TABLE `route_secondary` (
  `id` int(11) NOT NULL,
  `hospital_id` int(8) NOT NULL,
  `route_primary_id` int(8) NOT NULL,
  `route_secondary` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `route_secondary`
  ADD PRIMARY KEY (`id`);
  ALTER TABLE `route_secondary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;
CREATE TABLE `hospital` (
  `hospital_id` int(3) NOT NULL,
  `hospital_type_id` int(6) NOT NULL,
  `hospital` varchar(200) NOT NULL,
  `hospital_short_name` varchar(25) NOT NULL,
  `description` varchar(200) NOT NULL,
  `place` varchar(50) NOT NULL,
  `village_town_id` int(6) NOT NULL,
  `district` varchar(50) NOT NULL,
  `district_id` int(3) NOT NULL,
  `state` varchar(50) NOT NULL,
  `map_link` varchar(500) NOT NULL,
  `logo` varchar(200) NOT NULL,
  `type1` varchar(50) NOT NULL COMMENT 'Private, Public, Non-Profit',
  `type2` varchar(50) NOT NULL COMMENT 'State Govt., Central Govt.',
  `type3` varchar(50) NOT NULL COMMENT 'Teaching, Non-Teaching',
  `type4` varchar(50) NOT NULL COMMENT 'District, Area, CHC, PHC, Sub Centre',
  `type5` varchar(50) NOT NULL COMMENT 'Urban, Rural',
  `type6` varchar(50) NOT NULL COMMENT 'DME, VVP, DH',
  `helpline_id` int(11) DEFAULT NULL,
  `telehealth` tinyint(1) NOT NULL DEFAULT 0 COMMENT 'Determine whether hospital is running as telemedicine (1) or not ',
  `auto_ip_number` tinyint(1) DEFAULT 0,
  `print_layout_id` int(6) NOT NULL,
  `a6_print_layout_id` int(6) NOT NULL,
  `update_date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by_id` int(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='List of hospitals';

ALTER TABLE `hospital`
  ADD PRIMARY KEY (`hospital_id`),
  ADD KEY `hospital_id` (`hospital_id`);
COMMIT;



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

ALTER TABLE `indent` ADD `note` TEXT NOT NULL COMMENT 'a note for the entire indent' AFTER `indent_status`; 
-- additions as of feb 14, 2023
CREATE TABLE `inventory` ( `inventory_id` INT NOT NULL AUTO_INCREMENT , `inward_outward` VARCHAR(50) NOT NULL , `item_id` INT NOT NULL , `quantity` INT NOT NULL , `date_time` DATETIME NOT NULL , `inward_outward_type` VARCHAR(50) NOT NULL , `manufacture_date` DATETIME NOT NULL , `expiry_date` DATETIME NOT NULL , `batch` INT NOT NULL , `cost` INT NOT NULL , `patient_id` INT NOT NULL , `indent_id` INT NOT NULL , `gtin_code` VARCHAR(20) NOT NULL , PRIMARY KEY (`inventory_id`)) ENGINE = InnoDB; 

ALTER TABLE `inventory` ADD `supply_chain_party_id` INT NOT NULL AFTER `inventory_id`; 


ALTER TABLE `inventory` ADD `note` TEXT NOT NULL AFTER `indent_id`; 
ALTER TABLE `inventory` CHANGE `batch` `batch` VARCHAR(10) NOT NULL; 
CREATE TABLE `inventory_summary` ( `supply_chain_party_id` INT NOT NULL , `item_id` INT NOT NULL , `transaction_date` DATETIME NOT NULL , `closing_balance` INT NOT NULL ) ENGINE = InnoDB; 
ALTER TABLE `inventory` CHANGE `cost` `cost` FLOAT(11) NOT NULL; 


drop table `item_master`; 
drop table `item_batch`;
ALTER TABLE `item`
  DROP `lot_batch_id`,
  DROP `warranty_period`,
  DROP `manufacturing_date`,
  DROP `expire_date`;

--adding district_id column in helpline_receiver table
ALTER TABLE `helpline_receiver` ADD `district_id` INT(3) NOT NULL AFTER email;

INSERT INTO `user_function` (`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES

(72, 'patient_follow_up', 'Patient Follow Up', 'Patient Follow Up Module');

INSERT INTO `user_function_link` (`link_id`, `user_id`, `function_id`, `add`, `edit`, `view`, `remove`, `active`) VALUES
(5926, 1, 72, 1, 1, 1, 0, 1);
