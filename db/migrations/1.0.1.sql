# DB VERSION CREATED FOR TRACKING THE SCHEMA CHANGES

CREATE TABLE `db_version` (  
  `version` VARCHAR(10) NOT NULL
);


INSERT INTO `db_version` (`version`) VALUES ('1.0.1'); 




# "prescription" table column "duration" updated nullable & default is NULL
ALTER TABLE `prescription` CHANGE `duration` `duration` INT(11) DEFAULT NULL NULL; 

# Migrate previous values from 0 to NULL
update `prescription` set `duration` = NULL where `duration` = 0;


update `db_version` set `version` = '1.0.1';