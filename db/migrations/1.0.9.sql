ALTER TABLE `user` ADD `active` TINYINT(1) NOT NULL DEFAULT '1'; 

Insert into defaults values ('Login_Status_Deactive','Account Deactivated','','Text','','','','Account has been deactivated. Please contact admin.');

