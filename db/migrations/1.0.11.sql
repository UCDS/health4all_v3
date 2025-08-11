ALTER TABLE `helpline_receiver` CHANGE `app_id` `app_id` VARCHAR(8) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'app_id of telecom provider';

ALTER TABLE `update_patient_custom_form_fields` ADD `text_box` TINYINT NOT NULL AFTER `selected_columns`;