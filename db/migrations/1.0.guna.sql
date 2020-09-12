#New user function to create appointments
INSERT INTO `user_function` (`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES (NULL, 'create_appointment', 'Create Appointment', ''); 

#Additional fields created in patient_visit table to include appointments data and link to helpline
ALTER TABLE `patient_visit` ADD `appointment_with` INT NULL AFTER `update_datetime`, ADD `appointment_time` DATETIME NULL AFTER `appointment_with`, ADD `appointment_update_by` INT NULL AFTER `appointment_time`, ADD `appointment_update_time` DATETIME NULL AFTER `appointment_update_by`, ADD `helpline_id` VARCHAR(20) NULL AFTER `appointment_update_time`; 
