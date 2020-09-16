#New user function to create appointments
INSERT INTO `user_function` (`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES (NULL, 'create_appointment', 'Create Appointment', ''); 

#Appointment related fields created in patient_visit table to include appointments data
ALTER TABLE `patient_visit` ADD `appointment_with` INT NULL AFTER `update_datetime`, ADD `appointment_time` DATETIME NULL AFTER `appointment_with`, ADD `appointment_update_by` INT NULL AFTER `appointment_time`, ADD `appointment_update_time` DATETIME NULL AFTER `appointment_update_by`; 

#helpline_id field added to hospital table
ALTER TABLE `hospital` ADD `helpline_id` INT NULL AFTER `type6`; 

#adding field to patient_visit table to capture time when the doctor consultation summary has been sent to patient, especially in cases of teleconsultation
ALTER TABLE `patient_visit` ADD `summary_sent_time` DATETIME NULL AFTER `appointment_update_time`; 

# New user function for Doctors to view their list of Patients
INSERT INTO `user_function` (`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES (NULL, 'doctor_patient_list', 'Doctor Patient List', 'To provide list of Patients Visits assigned to a Doctor, both waiting and completed consultations. '); 
