<?php
abstract class get_field{
    
        public function get_Email(){
            
            return $this->email;
        }
        
        public function get_IdUser(){
            
            return $this->id_user;
        }
        
        public function get_FirstName(){
            
            return $this->first_name;
        }
        
        public function get_MiddleName(){
            
            return $this->middle_name;
        }
        
        public function get_LastName(){
            
            return $this->last_name;
        }
        
        public function get_Group_Name(){
            
            return $this->group_name;
        }
        
        public function get_Group_Id(){
            
            return $this->group_id;
        }
        
        public function get_Privilege(){
            
            return $this->privilege;
        }
        
        public function get_Code(){
            
            return $this->code;
        }
        
        public function get_Code_Id(){
            
            return $this->id_code;
        }
        public function Flag(){
            
            return $this->flag;
        }
        
        public function get_Username(){
            
            return $this->username;
        }
        
        public function A(){
            
            return $this->admin;
        }
        
        public function S(){
            
            return $this->student;
        }
        
        public function T(){
            
            return $this->teacher;
        }
        

        
}

?>
