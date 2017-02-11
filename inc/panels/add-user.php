
<p><a href="<?php echo $page ?>?cms=view&user=view">&larr; User Index</a></p>

<?php
//if form has been submitted process it
if(isset($_POST['add_user_submit'])){

    //collect form data
    extract($_POST);

    //very basic validation
    if($add_first ==''){
        $error[] = 'Please enter the first name.<br>';
    }      

    if(!isset($error)){
        $new_pass = $user->default_password($add_first);
        
        $hashedpassword = $user->create_hash($new_pass);

        try {                

            //insert into database
            $stmt = $db->prepare('INSERT INTO users (first,last,password,email,unit,role,active) VALUES (:first, :last, :password, :email, :unit, :role, :active)');
            $stmt->execute(array(
                ':first' => trim(strtolower($add_first)),
                ':last' => trim(strtolower($add_last)),
                ':password' => $hashedpassword,
                ':email' => trim(strtolower($add_email)),
                ':unit' => $add_unit,
                ':role' => $add_role,
                ':active' => "true"
            ));
            
            $last_insert_id = $db->lastInsertId();

            try {
              $stmt = $db->prepare('SELECT memberID, first, last, email FROM users WHERE email = :email');
              $stmt->execute(array(':email' => $add_email));                  
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
                $add_password_code = substr(md5(microtime()),rand(0,26),5);

                //insert into database
                $stmt = $db->prepare('UPDATE users SET reset = :reset WHERE email = :email') ;
                $stmt->execute(array(
                  ':reset' => $add_password_code,
                  ':email' => trim(strtolower($add_email))
                ));

              } catch(PDOException $e) {
                echo $e->getMessage();
              }

              require("functions/PHPMailer/class.phpmailer.php"); // path to the PHPMailerAutoload.php file
              require("functions/PHPMailer/class.smtp.php");

              define('GUSER', 'makikimanorcontact@gmail.com'); // GMail username
              define('GPWD', 'Makikimanor01'); // GMail password
              
              $emailBody = "Aloha " . ucfirst(strtolower($residents['first'])) . ",<br><br> This Makiki Manor account has been created for you by an administrator. Use your full email address as your accounts login username. <br>Click the following link to create your password: <a href='http://www.makikimanor.com/index.php?code=" . $add_password_code . "&email=" . $residents['email'] . "'>Set Password</a><br><br>Mahalo!";

              smtpmailer($add_email, GUSER, "Administrator", "Account Created", $emailBody, null, "support@makikimanor.com");

              header('Location: ' . $page . '?request_reset_confirmation=view');
            }          

            //redirect to index page            
            header('Location: ' . $current_url . '&user_add_confirmation=view&last_insert_id=' . $last_insert_id . '&action=added');
            exit;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }

    }

}

//check for any errors
if(isset($error)){
  foreach($error as $error){
    echo '<p class="error">'.$error.'</p>';
  }
}

?>

<form action='' method='post'>

  <p><label title="Will use this to login with.">Email</label><br />
  <input name='add_email' type='email' value='<?php if(isset($error)){ echo $_POST['add_email'];}?>'></p>
  
  <p><label title="For identification.">First Name</label><br />
  <input name='add_first' type='text' value='<?php if(isset($error)){ echo $_POST['add_first'];}?>'></p>

  <p><label title="For identification.">Last Name</label><br />
  <input name='add_last' type='text' value='<?php if(isset($error)){ echo $_POST['add_last'];}?>'></p>        

  <p><label title="For identification. Integer values only.">Unit #</label><br />
  <input name='add_unit' type="number" min="0" max="300" value='<?php if(isset($create_errors)){ echo $_POST['add_unit'];}?>'></p>
  
  <p><label title="Tenant roles can view confidential pages. Admin roles can edit pages.">Role</label><br />
  <select name="add_role">
    <option value="tenant" selected="selected">Tenant</option>
    <option value="admin">Admin</option>
  </select>
  </p>

  <p><input class="submit-button" name='add_user_submit' type='submit' value='Add User'></p>

</form>
