# "prescription" table column "duration" updated nullable & default is NULL
ALTER TABLE `prescription` CHANGE `duration` `duration` INT(11) DEFAULT NULL NULL; 

# Migrate previous values from 0 to NULL
update `prescription` set `duration` = NULL where `duration` = 0;