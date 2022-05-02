ALTER TABLE `user` ADD `active` TINYINT(1) NOT NULL DEFAULT '1'; 

Insert into defaults values ('Login_Status_Deactive','Account Deactivated','','Text','','','','Account has been deactivated. Please contact admin.');

Insert into defaults values ('Session_Timeout_Message','Session TimeOut','','Text','','','','Session timed out. Please sign-in again!');

Insert into defaults values ('Session_GoBack_Message','Session GoBack','','Text','','','','Go back to home page');

Insert into defaults values ('Session_Iddle_Time','Session Iddle Time','','Numeric','','','',15);
