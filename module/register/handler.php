<?php
    
    include 'get_field.php';
    
    class login extends get_field{
        protected   $usrename;
        protected   $id_user;
        protected   $flag;
        protected   $login;
        protected   $password;
        protected   $first_name;
        protected   $last_name;
        protected   $middle_name;
        protected   $group_id;
        protected   $group_name;
        protected   $privilege;
        protected   $email;
        protected   $code;
        protected   $id_code;
        protected   $id_teacher;
        protected   $db;
        protected   $dbj;
        protected   $admin = false;
        protected   $teacher = false;
        protected   $student = false;
        private $query = "SELECT 
            `users_login`.`id_code` as `id_code` ,
            `users_login`.`username` as `username`, 
            `users_login`.`email` as `email`,
            `users_login`.`privilege` as `privilege`,
            `users_login`.`id` as `id_user`,
            `code`.`code` as `code`, 
            `code`.`first_name` as `first_name`,
            `code`.`last_name` as `last_name`,
            `code`.`middle_name` as `middle_name`,
            `code`.`group_id` as `group_id`,
            `ktkt_journal`.`journal_group`.`group_name` as `group_name` 
            FROM `users_login` LEFT JOIN `code` ON `users_login`.`id_code` = `code`.`id`
           LEFT JOIN `ktkt_journal`.`journal_group` ON `ktkt_journal`.`journal_group`.`id`=`code`.`group_id`";
        
            private $query_user = "SELECT 
            `users_login`.`id` as `id`,     
            `users_login`.`username` as `username`, 
            `users_login`.`email` as `email`,
            `users_login`.`privilege` as `privilege`,
            `users_login`.`id` as `id_info`
            FROM `users_login` ";
        
        function __construct($db,$dbj) {
            $this->db = $db;
            $this->dbj = $dbj;
            if($this->cookie_test()){
            $this->password = mysqli_real_escape_string($this->db,$_COOKIE['password']);
            
            $this->login =     mysqli_real_escape_string($this->db,$_COOKIE['username']);
            
            $this->handler_login();
            $this->case_privilege();
            
            }
            
        }
        
        private function case_privilege(){
            
            switch ($this->privilege){
                case 1:
                    $this->student = true;
                break;
            
                case 2:
                    $this->teacher = true;
                break;
            
                 case 9999:
                    $this->admin = true;
                break;
            }
        }
        
        function handler_login()
        {    
           $result  = mysqli_query($this->db,"SELECT * FROM `users_login` WHERE `username` = '".$this->login."' AND `password` = '".$this->password."'  LIMIT 1")or die(mysqli_error($this->db));
           
           $row = mysqli_fetch_array($result);
           if(mysqli_num_rows($result)>0){
 
                if($row['id_code'] !=0){

                    $this->set_field_college();

                }elseif($row['id_code'] ==0){
                    
                    $this->set_simple_user();
                        
                }
                $this->id_user = $row['id'];
                $this->flag = true;
            }else{
                $this->flag = false;
            }
        
        }
        
        function cookie_test()
        { 
            if(!empty($_COOKIE['username']) && !empty($_COOKIE['password'])){
                
                return true;
                
            }else{
                
                return false;
            }
        }
        
        
        
        private function set_field_college(){
            $query = $this->query.'WHERE `users_login`.`username`= '."'".$this->login."'";
            $r = mysqli_num_rows(mysqli_query($this->db, $query))>0 ? mysqli_fetch_array(mysqli_query($this->db, $query)):false;
            if($r){
                          
                $this->id_code = $r['id_code'];
                $this->username = $r['username'];
                $this->code = $r['code'];
                $this->first_name = $r['first_name'];
                $this->last_name = $r['last_name'];
                $this->middle_name = $r['middle_name'];
                $this->group_id = $r['group_id'];
                $this->group_name = $r['group_name'];
                $this->email = $r['email'];
               
                if($r['privilege']==9999){
                    
                    $this->privilege=$r['privilege'];
                }else{
                                
                $query_privilege = "SELECT `privilege` FROM `code` WHERE `id`='{$this->id_code}'";         
                $this->privilege  = mysqli_fetch_array(mysqli_query($this->db, $query_privilege))['privilege'];
                }
            }
        }

        public function get_IdTeacher(){
            $query = "SELECT `id` FROM `journal_teacher` WHERE `id_code`='{$this->id_code}'";
            $result = mysqli_query($this->dbj, $query);
            return mysqli_fetch_array($result)['id'];
        }
        
        public function get_IdStudent(){
            
            $id_code = $this->id_code;
            
            $query = "SELECT `id` FROM `journal_student` WHERE `id_code`='$id_code'";
            
            $result = mysqli_query($this->dbj, $query)or die(mysqli_error($this->dbj));
            
            $fetch_field= mysqli_fetch_assoc($result)['id'];
            
            return $fetch_field;
        }
        
        public function get_NameUser($id){
            
            $query = "SELECT `username` FROM `id` WHERE `id`='$id'";
            
            $result = mysqli_query($this->dbj, $query)or die(mysqli_error($this->dbj));
            
            $name = mysqli_fetch_assoc($result)['username'];
            
            return $name;
        }
        
        private function set_simple_user(){
              $query = $this->query_user.'WHERE `users_login`.`username`= '."'".$this->login."'";
              mysqli_query($this->db, $query)or(die(mysqli_error($this->db)));
            $r = mysqli_num_rows(mysqli_query($this->db, $query))>0 ? mysqli_fetch_assoc(mysqli_query($this->db, $query)):false;
            $this->usename = $r['username'];
            $this->privilege = 0;
            
        }
        
        static public function set_color($privilage,$string){
            switch ($privilage){
                case 0: return "<div style='color:#000'>$string</div>";
                case 1: return "<div style='color:#6a91df'>$string</div>";
                case 2: return "<div style='color:#163c94'>$string</div>";    
                case 9999: return "<div style='color:red'>$string</div>";    
            }
        }
        

        
    }
         



