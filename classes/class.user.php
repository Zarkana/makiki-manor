<?php

class User{

    private $db;
    
    public function __construct($db){
        $this->db = $db; 
    }


    public function is_admin_logged_in(){
        if(isset($_SESSION['admin-loggedin']) && $_SESSION['admin-loggedin'] == true){
            return true;
        }        
    }

    public function is_residents_logged_in(){
        if(isset($_SESSION['residents-loggedin']) && $_SESSION['residents-loggedin'] == true){
            return true;
        }        
    }    

    public function get_role($email){
         try {

            $stmt = $this->db->prepare('SELECT role FROM users WHERE email = :email');
            $stmt->execute(array('email' => $email));
            
            $row = $stmt->fetch();

            return $row['role'];

        } catch(PDOException $e) {
            echo '<p class="error">'.$e->getMessage().'</p>';
        }             
    }  

    public function get_name($email){
         try {

            $stmt = $this->db->prepare('SELECT first FROM users WHERE email = :email');
            $stmt->execute(array('email' => $email));
            
            $row = $stmt->fetch();
            return $row['first'];

        } catch(PDOException $e) {
            echo '<p class="error">'.$e->getMessage().'</p>';
        }             
    }  

    public function get_active($email){
         try {
            $stmt = $this->db->prepare('SELECT active FROM users WHERE email = :email');
            $stmt->execute(array('email' => $email));
            
            $row = $stmt->fetch();
            return $row['active'];

        } catch(PDOException $e) {
            echo '<p class="error">'.$e->getMessage().'</p>';
        }             
    }      
    
    public function create_hash($value)
    {
        return $hash = crypt($value, '$2a$12'.substr(str_replace('+', '.', base64_encode(sha1(microtime(true), true))), 0, 22));
    }

    private function verify_hash($password,$hash)
    {        
        return $hash == crypt($password, $hash);
    }

    private function get_user_hash($email){    

        try {

            $stmt = $this->db->prepare('SELECT password FROM users WHERE email = :email');
            $stmt->execute(array('email' => $email));
            
            $row = $stmt->fetch();
            return $row['password'];

        } catch(PDOException $e) {
            echo '<p class="error">'.$e->getMessage().'</p>';
        }
    }

    public function default_password($first){    
        $encrypted = crypt($first, '$2a$12'.substr(str_replace('+', '.', base64_encode(sha1(microtime(true), true))), 0, 22));
        $half_encrypted = substr($encrypted, 0, -8);
        return $first . $half_encrypted;
    }

    public function login($email,$password){    

        $hashed = $this->get_user_hash($email);

        if($this->verify_hash($password,$hashed) == 1){            
            if($this->get_active($email) == "false"){
                return false;
            }
            $_SESSION['user-name'] = $this->get_name($email);
            $_SESSION['user-email'] = $email;
            switch($this->get_role($email))
            {                
                case "admin":
                    $_SESSION['admin-loggedin'] = true;
                    return true;                    
                case "tenant":
                    $_SESSION['residents-loggedin'] = true;    
                    return true;
                default:
                    return false;
                break;
            }
        
        }
    }    
        
    public function logout(){
        session_destroy();
    }
    
}

?>