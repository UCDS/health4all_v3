/*Date in table --> Update age years only if Age >= 2years else year, months and days*/

 
UPDATE `patient`
SET dob =  datediff(CURRENT_DATE,dob) DIV 365
WHERE dob != 0 and (datediff(CURRENT_DATE,dob) DIV 365) >= 2 
 
UPDATE `patient`
SET dob = datediff(CURRENT_DATE,dob) DIV 365
WHERE dob != 0 and (datediff(CURRENT_DATE,dob) DIV 365) < 2  /* Year*/

UPDATE `patient`
SET dob =  MOD(datediff(CURRENT_DATE,dob),  365) div 30  
WHERE dob != 0 and (datediff(CURRENT_DATE,dob) DIV 365) < 2 /* Month */

UPDATE `patient`
SET dob = MOD(MOD(datediff(CURRENT_DATE,dob),  365), 30)
WHERE dob != 0 and (datediff(CURRENT_DATE,dob) DIV 365) < 2 /* Days */

 

/*Date NOT in Table*/
UPDATE `patient`
SET age_years = (datediff(CURRENT_DATE,insert_datetime) Div 365) + age_years
WHERE dob = 0 and age_years >= 2  

UPDATE `patient`
SET age_years = (datediff(CURRENT_DATE,insert_datetime) Div 365) + age_years 
WHERE dob = 0 and age_years < 2    /* Year*/

UPDATE `patient`
SET age_months = (MOD(datediff(CURRENT_DATE,insert_datetime),365) div 30) +  age_months 
WHERE dob = 0 and age_years < 2 /* Month */

UPDATE `patient`
SET age_days =(MOD(MOD(datediff(CURRENT_DATE,insert_datetime),  365), 30)) + age_days 
WHERE dob = 0 and age_years < 2 /* Days */
