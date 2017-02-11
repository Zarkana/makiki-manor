
<?php
//if form has been submitted process it
if(isset($_POST['upload_filled_pdf_submit'])){

    //collect form data
    extract($_POST);

    //very basic validation
    if($your_email ==''){
        $error[] = 'Please enter the responses email.';
    }

    if(!isset($error)){

        try {
            
            if ($_FILES["file"]["type"] ==  "application/pdf") {
                if ($_FILES["file"]["error"] > 0) {
                    $error[] = "Return Code: " . $_FILES["file"]["error"] . "<br>";
                } else {

                    $filesize = $_FILES["file"]["size"] / 1024;
                    if($filesize < 1000){
                        move_uploaded_file($_FILES["file"]["tmp_name"],
                        "files/filled-forms/" . $_FILES["file"]["name"]);

                        $last_insert_id = $db->lastInsertId();
                        header('Location: www.google.com');
                          try {
                              $stmt = $db->prepare('SELECT memberID, first, last, email FROM users WHERE email = :email');
                              $stmt->execute(array(':email' => $_SESSION['user-email']));//TODO: make sure always getting this
                              $residents = $stmt->fetch();

                          } catch(PDOException $e) {
                              echo $e->getMessage();
                          }


                        require("functions/PHPMailer/class.phpmailer.php"); // path to the PHPMailerAutoload.php file.
                        require("functions/PHPMailer/class.smtp.php");

                        define('GUSER', 'makikimanorcontact@gmail.com'); // GMail username
                        define('GPWD', 'Makikimanor01'); // GMail password          
                      
                        $emailBody = "<table><tr><td>User: </td><td>" . $residents['email'] . "</td></tr><tr><td>Name: </td><td>" . $residents['first'] . " " . $residents['last'] . "</td></tr><tr><td>Reply To: </td><td>" . $your_email . "</td></tr><tr><td>Notes: </td><td>" . $additional_notes . "</td></tr><tr></tr></table>";

                        smtpmailer("residentmanager@makikimanor.com", $your_email, $residents['first'] + " " + $residents['last'], "Site: Filled Form", $emailBody, "files/filled-forms/" . $_FILES["file"]["name"], $your_email);
                      
                        //TODO delete file or warn that file wasn't sent

                        header('Location: ' . $current_url);
                        exit;
                    }
                    else{
                        $error[] = "File is larger than " . $filesize . "kb";
                    }                        
                    
                }

            } else {
                $error[] = "Wrong file type";
            }

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
        echo '<p class="error">'.$error.'</p>';
    }
}
?>

<form action='' method='post' enctype="multipart/form-data">
    <p style="margin-top: 0; margin-bottom: 5px;">
    <label>File</label><input id="file" name="file" type="file"><br>
    </p>
    <p style="margin-top: 0">
    <label>Reply To</label><br />
    <input id="email" class="input" name="your_email" type="text" value='<?php if(isset($error)){ echo $_POST['your_email'];}else{echo $_SESSION['user-email'];}?>' size="36"/><br />
    </p>
    <p>
    <label>Additional Notes</label><br />
    <input name='additional_notes' type='text' value='<?php if(isset($error)){ echo $_POST['additional_notes'];}?>' size="32">
    </p>

    <p><input class="upload submit-button" name='upload_filled_pdf_submit' type='submit' value='Mail'></p>

</form>
