# DB VERSION CREATED FOR TRACKING THE SCHEMA CHANGES

CREATE TABLE `db_version` (  
  `version` VARCHAR(10) NOT NULL
);


INSERT INTO `db_version` (`version`) VALUES ('1.0.1'); 




# "prescription" table column "duration" updated nullable & default is NULL
ALTER TABLE `prescription` CHANGE `duration` `duration` INT(11) DEFAULT NULL NULL; 

# Migrate previous values from 0 to NULL
update `prescription` set `duration` = NULL where `duration` = 0;


# DEFAULTS TABLE ADDED...
CREATE TABLE `defaults` (  
  `default_id` VARCHAR(50) NOT NULL,
  `default_tilte` VARCHAR(100) NOT NULL,
  `default_description` MEDIUMTEXT,
  `default_type` VARCHAR(100) NOT NULL,
  `default_unit` VARCHAR(50),
  `lower_range` VARCHAR(10),
  `upper_range` VARCHAR(10),
  `value` VARCHAR(10),
  PRIMARY KEY (`default_id`)
);

# DATA FOR DEFAULTS TABLE COPIED FROM UC ACTIVITY EXCEL Defaults Table TAB
Insert into defaults values ('SBP','Systolic Blood Pressure','Pressure in the arteries during the compression phase of the heart','Numeric','','50','300','');
Insert into defaults values ('DBP','Diastolic Blood Pressure','Pressure in the arteries during the relaxation phase of the heart','Numeric','','40','200','');
Insert into defaults values ('SPO2','Oxygen Saturation','Measure of how much oxygen your blood is carrying as a % of the maximum it could carry.','Numeric','%','0','100','');
Insert into defaults values ('WT','Weight','','Numeric','Kg','0.1','300','');
Insert into defaults values ('HR','Pulse','Heart Rate','Numeric','','30','300','');
Insert into defaults values ('TEMP','Temperature','','Numeric','F','90','120','');
Insert into defaults values ('RR','Respiratory Rate','','Numeric','','2','200','');
Insert into defaults values ('RBS','Blood Sugar','','Numeric','','30','800','');
Insert into defaults values ('HB','Hb','Haemoglobin','Numeric','','1','20','');
Insert into defaults values ('HBAIC','HbA1c','Glycated Haemoglobin: measures average sugar levels(glycation of the haemoglobin molecule) over a three month average','Numeric','','3','10','');
Insert into defaults values ('SYMPTOMSALERT','Mandatory Symptoms for Prescription','Medicine prescription is not permitted without Symptoms or Clinical Notes or Diagnosis being mentioned','Text','','','','');
Insert into defaults values ('SIGNOFFALERT','Mandatory Doctor sign off for Prescription','Medicine prescription is not permitted without Doctor sign off. Please ensure treating Doctor signs off this consultation','Text','','','','');
Insert into defaults values ('RANGEALERT','Outside of Range','Out of Range','Text','','','','');

ALTER TABLE `patient_visit` ADD COLUMN `spo2` INT(3) NULL AFTER `dbp`;


update `db_version` set `version` = '1.0.1';