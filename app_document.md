# Planning participants for Helpline Session 
    https://health4all.online/helpline/session_plan
    Method to be avalaible only with those having view acces for user_function -> helpline_session_plan
    Diplay view access to this method in Header under "Help" Menu with sub menu "Helpline Plan"
  
## DB
    INSERT INTO user_function(user_function) VALUE user_function (helpline_session_plan)
    In settings: let users add, delete or view based on user access set
    CREATE Tables -> helpline_session, helpline_session_role, helpline_receiver_language, helpline_session_plan
  
## Form selection fields (Placeholder - Field -> Display List)
    Helpline - helpline.helpline_id -> helpline.helpline
    Weekday - 1 to 7 -> Monday to Sunday
    Role - helpline_session_role.helpline_session_role_id -> helpline_session_role.helpline_session_role
    Session - helpline_session.helpline_session_id -> helpline_session.session_name (WHERE helpline_session.session_status = 1)
     
    Load report on click of "Go" Button -> Display report run date and time below Go Button
  
    Provide "Add" button next to Form "Go" Button for those with user_function->helpline_session_splan->add = 1
    On Click of "Add" button open modal to add receiver_id and additional details  to helpline_session_plan table
      
### Report Fields (Column Heading - Display Field) (apply default sort and filter)
    Serial number displayed as #
    Helpline - helpline.helpline
    Weekday  - helpline_session.weekday (1 to 7 AS Monday to Sunday)
    Role - helpline_session_role.helpline_session_role
    Session - helpline_session.session_name (WHERE helpline_session.session_status = 1)
    Team Count - Count of helpline_session_plan.receiver_id 
        -> WHERE helpline_session_plan.soft_deleted = 0
        -> GROUP BY helpline.helpline, weekday, helpline_session_role.helpline_session_role, helpline_session.session_name 
        -> ORDER BY helpline.helpline, weekday, helpline_session_role.helpline_session_role
        
#### On click of Team Count Value, show below the clicked row (Column Heading - Display Field) 
     Serial number displayed as #
     Team Member - helpline_receiver.full_name
     Languages - concacted with comma seperator (ORDER BY helpline_receiver_language.proficiency DESC)
     Delete Button (for those with user_function->helpline_session_splan->delete = 1)
        SELECT helpline_receiver.full_name, GROUP_CONCAT(language.language)
        FROM hepline_session_plan
        JOIN helpline_receiver ON helpline_session_plan.receiver_id = helpline_receiver.receiver_id
        JOIN helpline_receiver_language ON 
        JOIN language ON helpline_reiver_language.language_id = and language.language_id
        WHERE helpline_session_plan.helpline_session_id = <helpline_session_id selected> AND helpline_session_plan.soft_deleted = 0
            
#### On click of Delete button for the Team Member row
     UPDATE 
     hepline_session_plan.soft_delete = 1,
     hepline_session_plan.soft_deleted_by_staff_id = session[staff_id}
     hepline_session_plan.soft_deleted_by_date_time = delete date and time
         
     Reload page with previous settings

### Form for Add Receiver Modal
    helpline_session_plan.receiver_id -> Select using Ajax helpline_receiver.full_name concated with heline_receiver.phone and helpline_receiver.email like it is done in               https://health4all.online/helpline/helpline_receivers_form 
    helpline_session.weekday -> Display list by Weekday full name
    helpline_session_plan.helpline_session_id -> Select helpline_session.session_name WHERE helpline_session.weekday = selected Weekday AND helpline_session.session_status = 1
    helpline_session_plan.helpline_session_role_id -> Select helpline_session_role.helpline_session_role
    -> on click of Submit, 
        Insert row into helpline_session_plan with created_by_staff_id and created_date_time values
        Reload Modal with Success Message " Team Member Added to Session Successfully" with empty fields
        Click Close button to close Modal and reload the Main Form with existing form settings.
    
  
# Helpline Call Details - View and Update
    https://health4all.online/helpline/detailed_report

## Listing of Call Category: 
    In form selection: based on selection of Helpline, list only call categories for the specific helpline
    In Edit Call Modal: based on the Helpline of the call, list only call categories for the specific helpline AND where helpline_call_category.status = 1
  
## Listing of Hospital 
    In Edit Call Modal: show list of hospital.hospital_short_name WHERE helpline_call.to_number = helpline.helpline AND helpline.helpline_id = hospital.helpline_id

## Report Fields (Label - Field)
    Serial number displayed as #
    Call ID - <helpline_call.call_id>
    Call - <call direction icon> <time length of call> <date and time of call>
    Team Member @ Helpline - Note - <Display Name - > <hepline name and number> <audio api> <helpline_call.note>
    Caller Type - 
    Language - 
    Hospital - <hospital.hospital_short_name>
    Department - 
    Call Category -
    Resolution Status -
    Emails - 

# Custom Form to Register Patients
    https://health4all.online/register/custom_form/

    Visit Type: Select visit_name list WHERE visit_name.hospital = current_hospital AND visit_name.use =  
  
# Appointemnts Status - Form/Report to update checkin status at Gate/Entry for apppointments

## DB
    ALTER TABLE patient_visit - add fields -> appointment_status.id, appointment_status_update_by(comment-staff_id), 
    appointment_status_update_time 
    ALTER TABLE visit_name - add fields -> hospital_id
    INSERT INTO user_function(user_function) VALUE user_function (appointments_status)
    CREATE appointment_status table (id, hospital_id, appointment_status)
    INSERT INTO appointment_status(appointment_status) VALUE (Checked In, Registered, No Show, Cancelled)

## Form/Report to View and Update Appointment Status
    https://health4all.online/reports/appointment_status
    Set default Search by Appointments
    Default From and To Dates set to current date
    Default From and To Times set to 12:00AM to 11:59PM
    Addional Form search options:
    Appointment Status, Health4All ID, OP Number, Manual ID, Phone,
    Department, Unit, Area, Visit Type (WHERE visit_type linked to hospital and use status = 1), Row per page
    
    Provide default Pagination
    
    (Exlcude following columns from https://health4all.online/reports/appointment
    Doctor consulted, Appoinment with, Summary Sent, View Summary)
    Display visit_name
    Display patient_id_manual
    Display appointment_status and update patientappointment_status.id
    Display and update appointment_status_update_by, appointment_status_update_time
    Display button "Update" 
    if patient_visit.appointment_status_id = (NULL OR 0) AND user access to appoinment_status user function = add
    if patient_visit.appointment_status_id = (NULL OR 0) AND user access to appoinment_status user function = edit
    else do not display "Update"
    
    Button "Update" action
    Open Modal 
      Select appointment_status values of that hospital, 
      Display Current Date/times with select date picker to alter date time if necessary
     Modal "Submit" action
      Update patient_visit.appointment_status_id, patient_visit.appointment_status_update_by, patient_visit.appointment_status_update_time
      
## SMS feature to convey appointments

## SMS feature to convey appointment rescheduling

## Feature Create appoinment quotas and validations for creating fresh appointments
