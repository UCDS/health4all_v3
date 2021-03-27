# Planning participants for Helpline Session https://health4all.online/helpline/session_plan
    Method to be avalaible only with those having view acces for user_function -> helpline_session_plan
    Diplay view access to this method in Header under "Help" Menu with sub menu "Helpline Plan"
  
## DB
    INSERT INTO user_function(user_function) VALUE user_function (helpline_session_plan)
    In settings: let users add, edit, delete or view based on user access set
    CREATE Tables -> helpline_session, helpline_session_role, helpline_receiver_language, helpline_session_plan
  
## Form selection fields: Helpline, Helpline Session, Session Role, Weekday, Radio Buttion (Summary or Detailed)
  
### Summary Report Fields (Label - Field) (apply default sort and filter)
    Serial number displayed as #
    Helpline - helpline.helpline
    Session - helpline_session.session_name
    Role - helpline_session_role.helpline_session_role
    Weekday - Count of helpline_session_plan.receiver_id for particular helpline, helpline_session, helpline_session_role, weekday 
    
    
  
  
# https://health4all.online/helpline/detailed_report

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

# Improving Custom Form to select customised Visit Types/Names specific to each hospital

## DB
  ALTER TABLE visit_name - add fields -> hospital_id, use(1 comment for in use and 0 for not in use)
  
## Improve Form https://health4all.online/register/custom_form/
  Visit Name drop down list criteria in the form: Select visit_name list WHERE visit_name.hospital = current_hospital AND visit_name.use = 1
  
  
# Appointemnts Status - New Report/Form to update appointment status, primarily to update chekin status at Gate/Entry for apppointments

## DB
  ALTER TABLE patient_visit - add fields -> appointment_status.id, appointment_status_update_by(comment-staff_id), appointment_status_update_time 
  ALTER TABLE visit_name - add fields -> hospital_id
  INSERT INTO user_function(user_function) VALUE user_function (appointments_status)
  CREATE appointment_status table (id, hospital_id, appointment_status)
  INSERT INTO appointment_status(appointment_status) VALUE (Checked In, Registered, No Show, Cancelled)

## Create New Report/Form View https://health4all.online/reports/appointment_status
  Set default Search by Appointments
  Add Form search option by Appointment Status, Phone and Manual Id
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
