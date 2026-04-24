ALTER TABLE `helpline_receiver` CHANGE `app_id` `app_id` VARCHAR(8) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL DEFAULT NULL COMMENT 'app_id of telecom provider';

ALTER TABLE `update_patient_custom_form_fields` ADD `text_box` TINYINT NOT NULL AFTER `selected_columns`;

INSERT INTO `user_function` (`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES (NULL, 'list_patient_document_delete', 'list_patient_document_delete', 'list patient document delete');

ALTER TABLE `supply_chain_party` ADD `is_external` SMALLINT(2) NOT NULL COMMENT '1=>internal 2=>external ' AFTER `vendor_id`;

ALTER TABLE `inventory_summary` ADD PRIMARY KEY( `supply_chain_party_id`, `item_id`);

ALTER TABLE update_patient_custom_form_fields ADD COLUMN div_name VARCHAR(100);

ALTER TABLE update_patient_custom_form_fields ADD COLUMN div_column_count INT(11);

ALTER TABLE patient_bed DROP COLUMN patient_name;

ALTER TABLE patient_bed DROP COLUMN age_gender;

ALTER TABLE patient_bed DROP COLUMN address;

CREATE TABLE `followup_types` (
  `id` int(11) NOT NULL,
  `type_name` varchar(255) NOT NULL,
  `hospital_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE `followup_types` ADD PRIMARY KEY (`id`);

ALTER TABLE `followup_types` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `patient_followup` ADD `nxt_followup_date` DATE NOT NULL AFTER `death_status`, ADD `followup_type` INT NOT NULL AFTER `nxt_followup_date`;

INSERT INTO `user_function` (`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES (NULL, 'duplicate_patient_id_merge', 'duplicate_patient_id_merge', '');

CREATE TABLE patient_merge_archive (
    id INT AUTO_INCREMENT PRIMARY KEY,
    original_patient_id INT,
    duplicate_patient_id INT,
    visit_id INT,
    created_at DATETIME,
    created_by INT
);

ALTER TABLE patient_merge_archive ADD hospital_id INT;

ALTER TABLE `followup_types` ADD `created_by` INT NOT NULL AFTER `created_at`;

ALTER TABLE `followup_types` ADD `updated_by` INT NOT NULL AFTER `created_by`, ADD `updated_date_time` DATETIME NULL DEFAULT NULL AFTER `updated_by`;