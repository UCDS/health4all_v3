# Health4All

Contact On [gunaranjan@yousee.one]

Softwares to be installed
    - WAMP / XAMPP Server
    - Recommendation: SQLYog Community IDE [Instead of phpmyadmin if available and familiar for the programmer]


Steps to be followed : 
    1. Create a Github account .
    2. Fork (health4all_v3) from https://github.com/UCDS/health4all_v3.
    3. Clone health4all_v3 from your forked respository to your system 
    4. Move this app to either www folder if you are using WAMP, or to htdocs in case of XAMPP server
    5. Navigate to http://localhost/phpmyadmin/index.php  and create a new database with name 'health4all'.
    6. Import the sql file from health4all_v3/db/health4all.sql into 'health4all' database created in above step.
    7. Run the script SET GLOBAL sql_mode=''; in phpmyadmin sql editor
    8. Open health4all_v3 app in browser (http://localhost/health4all_v3/) and login with below credentials
        credentials-
                username  : admin
                password  : password  

Note :  To hide the errors  , change environment from 'development' to 'production' health4all_v3/index.php line number 20 
    
 

DB Migration,
    - After taking code pull, run all the files after the version mentioned in the table db_version
    - To add new migration, create new version file & at the end of the sql file add db_version update query, rever 1.0.2.sql for reference.
    - NOTE: DO NOT ADD DATABASE IN THE QUERIES.


TODOs,
    - DB Migration needs to be automated --> https://www.youtube.com/watch?v=i07XXM37VFk

References,
    - Database Migrations
        - https://codeinphp.github.io/post/database-migrations-in-codeigniter/
    - 

Joe's Task
    1. Need to freeze patient profile completed fields in revisit for OP or IP. Already Filled value should not be allowed to be updated"
    2. Add SPO2 in custom form feature
    3. Follow-UP Module to be integrated from health4all_v2 repo to current repo. Install & discuss with Guna. Workflow for Followup for Referrals, Follow up to Appointments, Appointments to Visit"
    4. All the fields if invalid should show the field border as red
    5. Move search above the registration form & should be only one line with advanced filter toggle button which when clicked show all the extra search fields. Show fields in one line [H4A, Visit Type, IP/OP Number, Phone Number] & in More search [Year]
    6. Retrieve previous prescription drug drop downs not selected.
    7. Display note in the patient update form itself, about Mandatory requirement for Clinical or Discharge notes for Prescription and Mandatory requirement for Doctor to sign the Prescription. Show Alert message below prescription area with bell icon & left aligned. Message ""Medicine prescription is not permitted without Symptoms or Clinical Notes or Diagnosis being mentioned.
    8. On keypress of clinical notes, show * after label of date field based on content of clinical notes. Show * for date field label if clinical notes is not empty or else remove star
    9. Patient Update alert messages to be taken from the defaults table, instead of hard-coding it.
    10. Center Align additional prescription elements
    11. SPO2 to be added in print summary. Also, order the fields in print summary with displayed fields. Also, do not show empty field labels.
    12. Clinical Note date picker not working in Firefox. Make repository of date pickers in application with dependency on browser and move to a uniform performing date picker resource. Joe will add new sheet with list of pages & date type. Guna will validate