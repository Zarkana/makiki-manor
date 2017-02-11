<?php
//Process user request to reset password
if(isset($_POST['request_reset_submit']) || isset($_POST['request_reset_admin_submit'])){

  //collect form data
  extract($_POST);

  //very basic validation
  if($reset_email ==''){
    $_SESSION['reset-errors'] = 'Please enter your email address.<br>';
  }else{
    $stmt = $db->query("SELECT 1 FROM users WHERE `email` = '" . $reset_email . "'");
    if ($stmt->fetchColumn() > 0)//If there is an account to email
    {

      if(!isset($_SESSION['reset-errors'])){//If no errors

        try {
          $stmt = $db->prepare('SELECT memberID, first, last, email FROM users WHERE email = :email');
          $stmt->execute(array(':email' => trim(strtolower($reset_email))));                  
          $residents = $stmt->fetch();

          $to_send_email = false;          
          if(($residents['email'] != "") && !is_null($residents['email']) && ($residents['email'] != "false")){//If valid email
            $to_send_email = true;
          }
          
        } catch(PDOException $e) {
          echo $e->getMessage();
        }

        if($to_send_email){

          try {
            //TODO: generate a random code
            $reset_password_code = substr(md5(microtime()),rand(0,26),5);

            //insert into database
            $stmt = $db->prepare('UPDATE users SET reset = :reset WHERE email = :email') ;
            $stmt->execute(array(
              ':reset' => $reset_password_code,
              ':email' => trim(strtolower($reset_email))
            ));

          } catch(PDOException $e) {
            echo $e->getMessage();
          }

          require("functions/PHPMailer/class.phpmailer.php"); // path to the PHPMailerAutoload.php file
          require("functions/PHPMailer/class.smtp.php");

          define('GUSER', 'makikimanorcontact@gmail.com'); // GMail username
          define('GPWD', 'Makikimanor01'); // GMail password
          
          $emailBody = "Aloha " . ucfirst(strtolower($residents['first'])) . ",<br><br> This account's password has been requested to be reset.<br>Click the following link to continue resetting your password: <a href='http://www.makikimanor.com/index.php?code=" . $reset_password_code . "&email=" . $residents['email'] . "'>Reset Password</a><br>If this is not desired, no action is required.<br><br>Mahalo!";

          smtpmailer($reset_email, GUSER, "Administrator", "Password Reset Request", $emailBody, null, "support@makikimanor.com");

          header('Location: ' . $page . '?request_reset_confirmation=view');
        }      
      }
    }
    else
    {
      $_SESSION['reset-errors'] = 'There is no account at this email address.<br>';
    }
  }
}

//Process the complete reset password form
if(isset($_POST['reset_password_submit'])){

  //collect form data
  extract($_POST);

  //very basic validation  
    if(strlen($reset_password) > 0){
      if($reset_password != $reset_password_confirm){
        $_SESSION['reset-errors'] = 'Passwords do not match.<br>';
      }
    }else{
      if($reset_password ==''){
        $_SESSION['reset-errors'] = 'Please enter the password.<br>';
      }

      if($reset_password_confirm ==''){
        $_SESSION['reset-errors'] = 'Please confirm the password.<br>';
      }
    }

    $stmt = $db->query("SELECT * FROM users WHERE `email` = '" . $reset_password_email . "'");
    $resident = $stmt->fetch();
        
    if(!isset($_SESSION['reset-errors'])){//If no errors
    
      if($resident['reset'] != "false"){//If we are supposed to reset
        if($resident['reset'] == $reset_password_code){//If the reset code from database equals the one from email

          $hashedpassword = $user->create_hash($reset_password);//Create new hashed password
          try {
            
            //update reset and password
            $stmt = $db->prepare('UPDATE users SET reset = :reset, password = :password WHERE email = :email') ;
            $stmt->execute(array(
              ':reset' => "false",
              ':password' => $hashedpassword,
              ':email' => trim(strtolower($reset_password_email))
            ));
                        
            header('Location: ' . $page . '?reset_password_confirmation=view');

          } catch(PDOException $e) {
            echo $e->getMessage();
          }

        }else{
          $_SESSION['reset-errors'] = 'Codes dont match.<br>';  
        }
      }else{
        $_SESSION['reset-errors'] = 'Passwords not set for reset.<br>';
      }
    }
    else
    {
      $_SESSION['reset-errors'] = 'There is no account at this email address.<br>';
    }
  
}

//Process creating an account
if(isset($_POST['create_account_submit'])){

  //collect form data
  extract($_POST);

  //very basic validation
  if($create_first == ''){
    $_SESSION['create-errors'] = 'Please enter your first name.<br>';
  }

  if($create_last == ''){      
    $_SESSION['create-errors'] = 'Please enter your last name.<br>';
  }

  if($create_email == ''){
    $_SESSION['create-errors'] = 'Please enter your email address.<br>';
  }else{//If email field is not empty
    $stmt = $db->query("SELECT 1 FROM users WHERE `email` = '" . $create_email . "'");

    if ($stmt->fetchColumn() > 0)
    {
      $_SESSION['create-errors'] = 'Account already exists'; 
    }
  }

  if($create_unit ==''){
    $_SESSION['create-errors'] = 'Please enter your unit number.<br>';
  }

  if($create_password ==''){
    $_SESSION['create-errors'] = 'Please enter the password.<br>';
  }

  if($password_confirm ==''){
    $_SESSION['create-errors'] = 'Please confirm the password.<br>';
  }

  if($create_password != $password_confirm){
    $_SESSION['create-errors'] = 'Passwords do not match.<br>';
  }

  if(!isset($_SESSION['create-errors'])){
      $hashedpassword = $user->create_hash($create_password);

      try {
        //insert into database
        $stmt = $db->prepare('INSERT INTO users (first,last,password,email,unit,role,active) VALUES (:first, :last, :password, :email, :unit, :role, :active)');
        $stmt->execute(array(
            ':first' => trim(strtolower($create_first)),
            ':last' => trim(strtolower($create_last)),
            ':password' => $hashedpassword,
            ':email' => trim(strtolower($create_email)),
            ':unit' => $create_unit,
            ':role' => "tenant",
            ':active' => "false"
        ));
        
        //redirect to index page
        $last_insert_id = $db->lastInsertId();
        //TODO remove new pass query
        header('Location: ' . $page . '?user_request_confirmation=view');
        exit;

    } catch(PDOException $e) {
        echo $e->getMessage();
    }
  }
}


if(isset($message)){ echo $message; }

// Remove the login errors session variable
if(isset($_SESSION['login-errors'])){
  $login_errors = $_SESSION['login-errors'];
  unset($_SESSION['login-errors']);
};

// Remove the create errors session variable
if(isset($_SESSION['create-errors'])){
  $create_errors = $_SESSION['create-errors'];
  unset($_SESSION['create-errors']);
};  

// Remove the reset errors session variable
if(isset($_SESSION['reset-errors'])){
  $reset_errors = $_SESSION['reset-errors'];
  unset($_SESSION['reset-errors']);
}; 
?>