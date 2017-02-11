
<p><a href="<?php echo $page ?>?cms=view&user=view">&larr; User Index</a></p>

<?php

//if form has been submitted process it
if(isset($_POST['edit_user_submit'])){

    //collect form data
    extract($_POST);

    if( strlen($edit_password) > 0){

        //very basic validation
        if($edit_password ==''){
            $error[] = 'Please enter the password.<br>';
        }

        if($password_confirm ==''){
            $error[] = 'Please confirm the password.<br>';
        }

        if($edit_password != $password_confirm){
            $error[] = 'Passwords do not match.<br>';
        }

    }
    

    if($edit_email ==''){
        $error[] = 'Please enter the email address.<br>';
    }

    if(!isset($error)){

        try {

            if($edit_password != ''){
                $hashedpassword = $user->create_hash($edit_password);

                //update into database
                $stmt = $db->prepare('UPDATE users SET first = :first, last = :last, password = :password, email = :email, unit = :unit, role = :role, active = :active WHERE memberID = :memberID') ;
                $stmt->execute(array(
                    ':first' => trim(strtolower($edit_first)),
                    ':last' => trim(strtolower($edit_last)),
                    ':password' => $hashedpassword,
                    ':email' => trim(strtolower($edit_email)),
                    ':unit' => $edit_unit,
                    ':role' => $edit_role,                    
                    ':memberID' => $memberID,
                    ':active' => $edit_active
                ));

            } else {

                //update database
                $stmt = $db->prepare('UPDATE users SET first = :first, last = :last, email = :email, unit = :unit, role = :role, active = :active  WHERE memberID = :memberID') ;
                $stmt->execute(array(
                    ':first' => trim(strtolower($edit_first)),
                    ':last' => trim(strtolower($edit_last)),
                    ':email' => trim(strtolower($edit_email)),
                    ':unit' => $edit_unit,
                    ':role' => $edit_role,
                    ':memberID' => $memberID,
                    ':active' => $edit_active
                ));

            }

            /*TODO: can't we change row to edit vars above?*/
            /*Store temporary variables*/                
            $stmt = $db->query('SELECT memberID, first, last, email, unit, password, role, active FROM users WHERE memberID =' . $memberID);
            $row = $stmt->fetch();                
            $_SESSION['updated_user']['id'] = $memberID;
            $_SESSION['updated_user']['email'] = strtolower($row['email']);
            $_SESSION['updated_user']['first'] = ucfirst(strtolower($row['first']));
            $_SESSION['updated_user']['last'] = ucfirst(strtolower($row['last']));
            $_SESSION['updated_user']['unit'] = $row['unit'];
            $_SESSION['updated_user']['role'] = $row['role'];
            $_SESSION['updated_user']['active'] = $row['active'];
                
            /*Email to notify account is active*/
              try {                    

                  $stmt = $db->prepare('SELECT memberID, first, last, email FROM users WHERE email = :email');
                  $stmt->execute(array(':email' => $edit_email));                  
                  $residents = $stmt->fetch();

                  $send_email = false;
                  //If valid email
                  if(($residents['email'] != "") && !is_null($residents['email']) && ($residents['email'] != "false")){
                    //If account now active
                    if($old_active == "false" && $edit_active == "true"){                    
                        $send_email = true;
                    }
                  }
                  
              } catch(PDOException $e) {
                  echo $e->getMessage();
              }

              if($send_email){
                /*TODO: require once?*/
                require("functions/PHPMailer/class.phpmailer.php"); // path to the PHPMailerAutoload.php file.
                require("functions/PHPMailer/class.smtp.php");

                define('GUSER', 'makikimanorcontact@gmail.com'); // GMail username
                define('GPWD', 'Makikimanor01'); // GMail password          
              
                $emailBody = "Aloha " . ucfirst(strtolower($residents['first'])) . ",<br><br> This Makiki Manor account has been activated for you by an administrator. Use this email address as your username. <br><br>Mahalo!";
                smtpmailer($residents['email'], GUSER, $residents['first'] + " " + $residents['last'], "Makiki Manor Account Activated", $emailBody, null, "support@makikimanor.com");

                header('Location: ' . $current_url . '?inquiry_sent_confirmation=view');
              }


            //redirect to index page
            header('Location: ' . $page . '?cms=view&user_edit_confirmation=view');
            exit;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }

    }

}

?>


<?php
//check for any errors
if(isset($error)){
    foreach($error as $error){
        echo '<p class="error">'. $error .'</p>';
    }
}

    try {

        $stmt = $db->prepare('SELECT memberID, first, last, email, unit, role, active FROM users WHERE memberID = :memberID') ;
        $stmt->execute(array(':memberID' => $_GET['edit_user']));
        $row = $stmt->fetch(); 

    } catch(PDOException $e) {
        echo $e->getMessage();        
    }

?>

<form action='' method='post'>
    <input type='hidden' name='memberID' value='<?php echo $row['memberID'];?>'>
    <input type='hidden' name='old_active' value='<?php echo $row['active'];?>'>

    <p><label>Email</label><br />
    <input name='edit_email' title="Will use this to login with." type='email' value='<?php echo $row['email'];?>' required></p>

    <p><label title="For identification.">First Name</label><br />
    <input name='edit_first' type='text' value='<?php echo $row['first'];?>' required></p>

    <p><label title="For identification.">Last Name</label><br />
    <input name='edit_last' type='text' value='<?php echo $row['last'];?>'></p>        

    <p><label title="To manually change a users password.">Password (only to change)</label><br />
    <input name='edit_password' type='password' value='' min="4"></p>

    <p><label title="To confirm password matches.">Confirm Password</label><br />
    <input name='password_confirm' type='password' value=''></p>

    <p><label title="For identification. Integer values only.">Unit</label><br />
    <input name='edit_unit' type='text' value='<?php echo $row['unit'];?>'></p>
    <div style="display: inline-block;">
        <div style="float: left;">
        <label title="Tenant roles can view confidential pages. Admin roles can edit pages.">Role</label><br />
        <?php
        if($row['role']=="admin"){
            $tenant_selection = '';
            $admin_selection = 'selected="selected"';
        }else if($row['role']=="tenant"){
            $tenant_selection = 'selected="selected"';
            $admin_selection = '';
        }
        ?>   
        <select name='edit_role'>
            <option value="tenant" <?php echo($tenant_selection);?>>Tenant</option>
            <option value="admin" <?php echo($admin_selection);?>>Admin</option>
        </select>
        </div>
        <div  style="float: left; margin-left: 15px;">
        <?php
        if($row['active']=="true"){
            $false_selection = '';
            $true_selection = 'selected="selected"';
        }else if($row['row']=="false"){
            $false_selection = 'selected="selected"';
            $true_selection = '';
        }
        ?>     
        <label>Active</label><br>
        <select name='edit_active'>
            <option value="false" <?php echo($false_selection);?>>False</option>
            <option value="true" <?php echo($true_selection);?>>True</option>
        </select>    
        </div>
    </div>
    
    <p><input class="submit-button" name='edit_user_submit' type='submit' value='Update User'></p>

</form>
