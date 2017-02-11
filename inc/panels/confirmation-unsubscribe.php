<?php

//if form has been submitted process it
if(isset($_POST['unsubscribe_confirmation_submit'])){

    $_POST = array_map( 'stripslashes', $_POST );

    //collect form data
    extract($_POST);

    if(!isset($error)){

        try {
            //insert into database
            $stmt = $db->prepare('UPDATE users SET subscribed = :subscribed WHERE email = :email');
            $stmt->execute(array(
                ':subscribed' => "false",
                ':email' => trim(strtolower($unsubscribe_email))
            ));

            //redirect to index page
            header('Location: ' . $page);
            exit;

        } catch(PDOException $e) {
            echo $e->getMessage();
        }
    }
}

?>

<?php
    // try {

    //     $stmt = $db->prepare('SELECT email, sectionHeader, sectionContent FROM sections WHERE sectionID = :sectionID') ;
    //     $stmt->execute(array(':memberID' => 6));
    //     $row = $stmt->fetch(); 

    // } catch(PDOException $e) {
    //     echo $e->getMessage();
    // }

?>

<form action='' method='post'>
    <input name='unsubscribe_email' type='hidden' value='<?php echo $_GET['unsubscribe_email'];?>'>
	<br>
	<div id="confirmation-reset-password" class="temp" style="width: 80%; margin-left: 10%;">	
		<h3 class="confirmation-header">Unsubscribe</h3>
	    <p>Do you want to unsubscribe from all announcement emails?</p>
	    <p>You will still receive email's for important changes to your account.</p>
	</div>

    <p style="margin-left: 40%;"><input class="submit-button" name='unsubscribe_confirmation_submit' type='submit' value='Yes'></p>

</form>



