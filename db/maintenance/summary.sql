/* These scripts are meant for Database maintenance purpose */

/* Inserting into DB Summary Table: summary_calls */
INSERT into summary_calls (helpline, call_direction, call_type, date, call_count) 
SELECT to_number as helpline, direction as call_direction, call_type as call_type, date(start_time) as date, count(*) as call_count FROM helpline_call  
WHERE DATE(start_time) < CURRENT_DATE()
GROUP by helpline, call_direction, call_type, date;

/* Inserting into DB Summary Table: summary_unique_callers */
INSERT into summary_unique_callers (helpline, date, unique_callers) 
SELECT to_number as helpline,date(start_time) as date, count(DISTINCT(from_number)) as unique_callers FROM helpline_call  
WHERE DATE(start_time) < CURRENT_DATE()
GROUP by helpline, date;
