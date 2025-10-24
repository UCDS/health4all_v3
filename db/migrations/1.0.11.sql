ALTER TABLE `helpline_receiver` CHANGE `app_id` `app_id` VARCHAR(8) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'app_id of telecom provider';

ALTER TABLE `update_patient_custom_form_fields` ADD `text_box` TINYINT NOT NULL AFTER `selected_columns`;

INSERT INTO `user_function` (`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES (NULL, 'list_patient_document_delete', 'list_patient_document_delete', 'list patient document delete');

ALTER TABLE `supply_chain_party` ADD `is_external` SMALLINT(2) NOT NULL COMMENT '1=>internal 2=>external ' AFTER `vendor_id`;
