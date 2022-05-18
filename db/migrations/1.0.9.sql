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