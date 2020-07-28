ALTER TABLE `helpline_receiver` ADD `user_id` INT NOT NULL AFTER `category`, ADD `doctor` TINYINT NOT NULL COMMENT '1 for True and 0 for False' AFTER `user_id`, ADD `enable_outbound` TINYINT NOT NULL COMMENT '1 for True and 0 for False' AFTER `doctor`, ADD `app_id` VARCHAR(6) NOT NULL COMMENT 'app_id of telecom provider' AFTER `enable_outbound`, ADD `helpline_id` INT NOT NULL COMMENT 'caller_id of telecom provider' AFTER `app_id`;

ALTER TABLE `helpline_receiver` CHANGE `user_id` `user_id` INT(11) NULL, CHANGE `doctor` `doctor` TINYINT(4) NULL COMMENT '1 for True and 0 for False', CHANGE `enable_outbound` `enable_outbound` TINYINT(4) NULL COMMENT '1 for True and 0 for False', CHANGE `helpline_id` `helpline_id` INT(11) NULL COMMENT 'caller_id of telecom provider'; 

ALTER TABLE `helpline_receiver` ADD `activity_status` TINYINT NULL COMMENT '1 for active and 0 for inactive' AFTER `helpline_id`; 

ALTER TABLE `helpline_receiver` CHANGE `app_id` `app_id` VARCHAR(6) NULL COMMENT 'app_id of telecom provider';

CREATE TABLE `helpline_receiver_link` ( `id` INT NOT NULL AUTO_INCREMENT, `receiver_id` INT NOT NULL, `helpline_id` INT NOT NULL, PRIMARY KEY (`id`) ); 



ALTER TABLE `helpline_receiver`   
	CHANGE `doctor` `doctor` TINYINT(4) DEFAULT 0 NULL COMMENT '1 for True and 0 for False',
	CHANGE `enable_outbound` `enable_outbound` TINYINT(4) DEFAULT 0 NULL COMMENT '1 for True and 0 for False',
	CHANGE `activity_status` `activity_status` TINYINT(4) DEFAULT 0 NULL COMMENT '1 for active and 0 for inactive';
