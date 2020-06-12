<?php
class Staff_Applicant_Model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    function add_applicant(){
        $applicant_data = array();
        if($this->input->post('first_name')){
            $applicant_data['first_name'] = $this->input->post('first_name');
        }
        if($this->input->post('last_name')){
            $applicant_data['last_name'] = $this->input->post('last_name');
        }
        if($this->input->post('gender')){
            $applicant_data['gender'] = $this->input->post('gender');
        }
        if($this->input->post('date_of_birth')){
            $applicant_data['date_of_birth'] = date("Y-m-d",strtotime($this->input->post('date_of_birth')));
        }
        if($this->input->post('fathers_name')){
            $applicant_data['fathers_name'] = $this->input->post('fathers_name');
        }
        if($this->input->post('mothers_name')){
            $applicant_data['mothers_name'] = $this->input->post('mothers_name');
        }
        if($this->input->post('husbands_name')){
            $applicant_data['husbands_name'] = $this->input->post('husbands_name');
        }
        if($this->input->post('address')){
            $applicant_data['address'] = $this->input->post('address');
        }
        if($this->input->post('place')){
            $applicant_data['place'] = $this->input->post('place');
        }
        if($this->input->post('district_id')){
            $applicant_data['district_id'] = $this->input->post('district_id');
        }
        if($this->input->post('phone')){
            $applicant_data['phone'] = $this->input->post('phone');
        }
        if($this->input->post('phone_alternate')){
            $applicant_data['phone_alternate'] = $this->input->post('phone_alternate');
        }
        if($this->input->post('email')){
            $applicant_data['email'] = $this->input->post('email');
        }
        if($this->input->post('drive_id')){
            $applicant_data['drive_id'] = $this->input->post('drive_id');
        }        
        $this->db->insert('staff_applicant', $applicant_data);
        $applicant_id = $this->db->insert_id();
        
        $qualifications_data = array();        
        if($this->input->post('qualification_count')){
            for($i=1; $i < 11; $i++){                
                $qualification_id='';
                $applicant_college_id='';
                
                $qualification_to_date='';
                $qualification_from_date='';
                $registration_number ='';
                if($this->input->post('qualification_id'.$i)){                    
                    $qualification_id = $this->input->post('qualification_id'.$i);
                }
                if($this->input->post('applicant_college_id'.$i)){
                    $applicant_college_id = $this->input->post('applicant_college_id'.$i);
                }
                if($this->input->post('registration_number'.$i)){
                    $registration_number = $this->input->post('registration_number'.$i);
                }
                if($this->input->post('qualification_from_date'.$i)){
                    $qualification_from_date = $this->input->post('qualification_from_date'.$i);
                }
                if($this->input->post('qualification_to_date'.$i)){
                    $qualification_to_date = $this->input->post('qualification_to_date'.$i);
                }
                if($qualification_id>0){                    
                    $qualifications_data[] = array(
                        'applicant_id' => $applicant_id,
                        'qualification_id' => $qualification_id,
                        'college_id' => $applicant_college_id,
                        'registration_number' => $registration_number,
                        'from_date' => date("Y-m-d",strtotime($qualification_from_date)),
                        'to_date' => date("Y-m-d",strtotime($qualification_to_date))
                    );
                }
            }
        }
        
        $experiance_data = array();
        if($this->input->post('experiance_count')){
            for($i=1; $i < 11; $i++){                
                $hospital_id='';
                $staff_role_id='';
                $registration_number='';
                $experiance_to_date='';
                $experiance_from_date='';
                if($this->input->post('hospital_id'.$i)){                    
                    $hospital_id = $this->input->post('hospital_id'.$i);
                }
                if($this->input->post('staff_role_id'.$i)){
                    $staff_role_id = $this->input->post('staff_role_id'.$i);
                }                
                if($this->input->post('experiance_from_date'.$i)){
                    $experiance_from_date = $this->input->post('experiance_from_date'.$i);
                }
                if($this->input->post('experiance_to_date'.$i)){
                    $experiance_to_date = $this->input->post('experiance_to_date'.$i);
                }
                if($hospital_id>0){                    
                    $experiance_data[] = array(
                        'applicant_id' => $applicant_id,
                        'hospital_id' => $hospital_id,
                        'role_id' => $staff_role_id,                        
                        'from_date' => date("Y-m-d",strtotime($experiance_from_date)),
                        'to_date' => date("Y-m-d",strtotime($experiance_to_date))
                    );
                }                
                
            }
        }
        
        $this->db->trans_start();
        $this->db->insert_batch('staff_applicant_qualification', $qualifications_data);
        $this->db->insert_batch('staff_applicant_work_expriance', $experiance_data);
        $this->db->trans_complete();
        
        return $this->db->trans_status();
    }
    
    function update_applicant(){
        $applicant_data = array();
        if($this->input->post('first_name')){
            $applicant_data['first_name'] = $this->input->post('first_name');
        }
        if($this->input->post('last_name')){
            $applicant_data['last_name'] = $this->input->post('last_name');
        }
        if($this->input->post('gender')){
            $applicant_data['gender'] = $this->input->post('gender');
        }
        if($this->input->post('date_of_birth')){
            $applicant_data['date_of_birth'] = date("Y-m-d",strtotime($this->input->post('date_of_birth')));
        }
        if($this->input->post('fathers_name')){
            $applicant_data['fathers_name'] = $this->input->post('fathers_name');
        }
        if($this->input->post('mothers_name')){
            $applicant_data['mothers_name'] = $this->input->post('mothers_name');
        }
        if($this->input->post('husbands_name')){
            $applicant_data['husbands_name'] = $this->input->post('husbands_name');
        }
        if($this->input->post('address')){
            $applicant_data['address'] = $this->input->post('address');
        }
        if($this->input->post('place')){
            $applicant_data['place'] = $this->input->post('place');
        }
        if($this->input->post('district_id')){
            $applicant_data['district_id'] = $this->input->post('district_id');
        }
        if($this->input->post('phone')){
            $applicant_data['phone'] = $this->input->post('phone');
        }
        if($this->input->post('phone_alternate')){
            $applicant_data['phone_alternate'] = $this->input->post('phone_alternate');
        }
        if($this->input->post('email')){
            $applicant_data['email'] = $this->input->post('email');
        }
        if($this->input->post('drive_id')){
            $applicant_data['drive_id'] = $this->input->post('drive_id');
        }
        
        $applicant_id ='';
        if($this->input->post('applicant_id')){
            $applicant_id = $this->input->post('applicant_id');
        }else{
            return false;
        }        
        $this->db->where('applicant_id', $applicant_id);
        $this->db->update('staff_applicant', $applicant_data);        
        
        $qualifications_data = array();        
        if($this->input->post('qualification_count')){
            for($i=1; $i < 11; $i++){                
                $qualification_id='';
                $applicant_college_id='';
                
                $qualification_to_date='';
                $qualification_from_date='';
                $registration_number ='';
                if($this->input->post('qualification_id'.$i)){                    
                    $qualification_id = $this->input->post('qualification_id'.$i);
                }
                if($this->input->post('applicant_college_id'.$i)){
                    $applicant_college_id = $this->input->post('applicant_college_id'.$i);
                }
                if($this->input->post('registration_number'.$i)){
                    $registration_number = $this->input->post('registration_number'.$i);
                }
                if($this->input->post('qualification_from_date'.$i)){
                    $qualification_from_date = $this->input->post('qualification_from_date'.$i);
                }
                if($this->input->post('qualification_to_date'.$i)){
                    $qualification_to_date = $this->input->post('qualification_to_date'.$i);
                }
                if($qualification_id>0){                    
                    $qualifications_data[] = array(
                        'applicant_id' => $applicant_id,
                        'qualification_id' => $qualification_id,
                        'college_id' => $applicant_college_id,
                        'registration_number' => $registration_number,
                        'from_date' => date("Y-m-d",strtotime($qualification_from_date)),
                        'to_date' => date("Y-m-d",strtotime($qualification_to_date))
                    );
                }                
                
            }
        }
        
        $experiance_data = array();
        if($this->input->post('experiance_count')){
            for($i=1; $i < 11; $i++){                
                $hospital_id='';
                $staff_role_id='';
                $registration_number='';
                $experiance_to_date='';
                $experiance_from_date='';
                $experiance_years='';
                if($this->input->post('hospital_id'.$i)){                    
                    $hospital_id = $this->input->post('hospital_id'.$i);
                }
                if($this->input->post('staff_role_id'.$i)){
                    $staff_role_id = $this->input->post('staff_role_id'.$i);
                }
                if($this->input->post('experiance_years'.$i)){
                    $experiance_years = $this->input->post('experiance_years'.$i);
                }
                if($this->input->post('experiance_from_date'.$i)){
                    $experiance_from_date = $this->input->post('experiance_from_date'.$i);
                }
                if($this->input->post('experiance_to_date'.$i)){
                    $experiance_to_date = $this->input->post('experiance_to_date'.$i);
                }
                if($hospital_id>0){                    
                    $experiance_data[] = array(
                        'applicant_id' => $applicant_id,
                        'hospital_id' => $hospital_id,
                        'role_id' => $staff_role_id,
                        'experiance_years' => $experiance_years,
                        'from_date' => date("Y-m-d",strtotime($experiance_from_date)),
                        'to_date' => date("Y-m-d",strtotime($experiance_to_date))
                    );
                }                
                
            }
        }
        
        $this->db->trans_start();
        if(!empty($qualifications_data)){
            $this->db->insert_batch('staff_applicant_qualification', $qualifications_data);
        }
        if(!empty($experiance_data)){
            $this->db->insert_batch('staff_applicant_work_expriance', $experiance_data);
        }
        $this->db->trans_complete();        
        return $this->db->trans_status();
    }
    
    function add_evaluation(){
        $applicant_id ='';
        $drive_id   =''; 
        $parameter_size ='';
        if($this->input->post('applicant_id') && $this->input->post('drive_id') && $this->input->post('parameter_size')){
            $applicant_id = $this->input->post('applicant_id');
            $drive_id = $this->input->post('drive_id');
            $parameter_size = $this->input->post('parameter_size');
        }else{
            return false;
        }
        
        if($this->input->post('phone')){
            $applicant_data = array(
                'phone' => $this->input->post('phone')
            );
            $this->db->trans_start();
            $this->db->where('applicant_id', $applicant_id);
            $this->db->update('staff_applicant', $applicant_data);
            $this->db->trans_complete();
        }
        
        $evaluations = array();
        for($i=1; $i<=$parameter_size; $i++){
            $parameter = $this->input->post("parameter_".$applicant_id."-".$i);            
            if(!empty($parameter)){
                $post_var1 = "parameter_$applicant_id-$i";
                $post_var2 = "value_$applicant_id-$i";                
                $evaluations[] = array(
                    'applicant_id' => $applicant_id,
                    'drive_id' => $drive_id,
                    'parameter_id' => $this->input->post("$post_var1"),
                    'score' => $this->input->post("$post_var2")
                );               
            }
        }
        if(empty($evaluations)){
            return false;
        }
        $this->db->trans_start();
        $this->db->insert_batch('staff_applicant_score', $evaluations);       
        $this->db->trans_complete();
    }
    
    function get_applicant(){       //This for evaluation.
       $drive_id = '';
       $applicant_id = '';
        if($this->input->post('drive_id')){
            $drive_id = $this->input->post('drive_id');
            $this->db->where('staff_applicant.drive_id', $drive_id);
        }
        if($this->input->post('applicant_id')){
            $applicant_id = $this->input->post('applicant_id');
            $this->db->where('staff_applicant.applicant_id', $applicant_id);
        }
       
       $this->db->select('staff_applicant.*, staff_applicant_score.parameter_id, staff_applicant_score.score')
          ->from('staff_applicant')
          ->join('staff_applicant_score', 'staff_applicant_score.applicant_id = staff_applicant.applicant_id','left')          
          ->order_by('staff_applicant.applicant_id');                      
       $query = $this->db->get();
       
       $result = $query->result();
       if($result){
        return $result;       
       }else{
           return false;
       }
    }
    
    function get_applicants_detailed(){
        $drive_id = '';
        $applicant_id ='';
        if($this->input->post('drive_id')){
            $drive_id = $this->input->post('drive_id');
            $this->db->where('staff_applicant.drive_id', $drive_id);
        }
        if($this->input->post('applicant_id')){
            $applicant_id = $this->input->post('applicant_id');
            $this->db->where('staff_applicant.applicant_id', $applicant_id);
        }
       
       $this->db->select('staff_applicant.*, staff_applicant_score.parameter_id, staff_applicant_score.score, staff_applicant_qualification_master.qualification, staff_previous_hospital.hospital_id')
          ->from('staff_applicant')
          ->join('staff_applicant_score', 'staff_applicant_score.applicant_id = staff_applicant.applicant_id','left')
          ->join('staff_applicant_qualification', 'staff_applicant_qualification.applicant_id = staff_applicant.applicant_id','left')
          ->join('staff_applicant_qualification_master', 'staff_applicant_qualification_master.qualification_id = staff_applicant_qualification.qualification_id','left')
          ->join('staff_applicant_work_expriance', 'staff_applicant_work_expriance.applicant_id = staff_applicant.applicant_id','left')
          ->join('staff_previous_hospital', 'staff_previous_hospital.hospital_id = staff_applicant_work_expriance.hospital_id','left')          
          ->order_by('staff_applicant.applicant_id');                      
       $query = $this->db->get();
       
       $result = $query->result();
       if($result){
        return $result;       
       }else{
           return false;
       }
    }
    
    function get_experiance(){        
       $applicant_id = '';        
        if($this->input->post('applicant_id')){
            $applicant_id = $this->input->post('applicant_id');
            $this->db->where('staff_applicant.applicant_id', $applicant_id);
        }
       
       $this->db->select('staff_applicant_work_expriance.*, staff_previous_hospital.hospital_name')
          ->from('staff_applicant')
          ->join('staff_applicant_work_expriance', 'staff_applicant_work_expriance.applicant_id = staff_applicant.applicant_id','left')
         ->join('staff_previous_hospital', 'staff_previous_hospital.hospital_id = staff_applicant_work_expriance.hospital_id','left')
          ->order_by('staff_applicant.applicant_id');                      
       $query = $this->db->get();
       
       $result = $query->result();
       if($result){
        return $result;       
       }else{
           return false;
       }
    }
    
    function get_qualifications(){
       $applicant_id = '';
        if($this->input->post('applicant_id')){
            $applicant_id = $this->input->post('applicant_id');
            $this->db->where('staff_applicant.applicant_id', $applicant_id);
        }
       
       $this->db->select('staff_applicant_qualification.*, staff_applicant_qualification_master.qualification,staff_applicant_college.college_name')
          ->from('staff_applicant')
          ->join('staff_applicant_qualification', 'staff_applicant_qualification.applicant_id = staff_applicant.applicant_id','left')
          ->join('staff_applicant_college', 'staff_applicant_qualification.college_id = staff_applicant_college.college_id','left')
          ->join('staff_applicant_qualification_master', 'staff_applicant_qualification_master.qualification_id = staff_applicant_qualification.qualification_id','left');
          
       $query = $this->db->get();
       
       $result = $query->result();
       if($result){
        return $result;       
       }else{
           return false;
       }
    }    
}
