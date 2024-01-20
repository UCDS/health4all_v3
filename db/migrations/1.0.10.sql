ALTER TABLE `patient_followup` ADD `ndps` TINYINT NOT NULL AFTER `note`, ADD `drug` TEXT NOT NULL AFTER `ndps`, ADD `dose` TEXT NOT NULL AFTER `drug`, ADD `last_dispensed_date` DATE NULL DEFAULT NULL AFTER `dose`, ADD `last_dispensed_quantity` INT NOT NULL AFTER `last_dispensed_date`;

ALTER TABLE `patient_visit` CHANGE `outcome` `outcome` VARCHAR(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Discharge,LAMA,Absconded,Death';
INSERT INTO `user_function`(`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES ('','issue_list','Issue List','issue list report');
INSERT INTO `user_function`(`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES ('','issue_summary','issue summry','issue summary report');
INSERT INTO `user_function` (`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES ('', 'followup_summary', 'follow summary', 'follow summary');