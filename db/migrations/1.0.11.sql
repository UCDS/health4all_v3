ALTER TABLE `patient_visit` CHANGE `outcome` `outcome` VARCHAR(11) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL COMMENT 'Discharge,LAMA,Absconded,Death';


INSERT INTO `user_function`(`user_function_id`, `user_function`, `user_function_display`, `description`) VALUES ('','issue_list','Issue List','issue list report')


Table  -  user_function_link => make link_id ( column auto increment )