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
