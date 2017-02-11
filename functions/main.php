<?php
$panel_background_exists = false;
function make_panel($title, $id, $location, $appear, $size){
	global $db;
	global $user;
	global $page;
	global $current_url;
	global $login_errors;
	global $create_errors;
	global $panel_background_exists;

	/*ONLY create a single panel background*/
	if(!$panel_background_exists)
	{
  	echo('<div class="panel-background"></div>');
		$panel_background_exists = true;
	}

	if($size == "page-panel"){//If page-panel
		echo('<div id="' . $id . '" class="panel page-panel">');		
	}else{ //If normal panel
		echo('<div id="' . $id . '" class="panel">');
	}
		echo('<div class="panel-bar">');
			echo('<h2>'. $title . '</h2>');
			echo('<div class="close"><div class="close-x"></div></div>');
		if($size == "page-panel"){
			/*CREATE the accent*/
			echo('<div class="accent-bar">');
 				echo('<div class="dropdown accent page-accent"></div>');
 			echo('</div>');
		}
		echo('</div>');
		echo('<div class="panel-content">');		

			// Will insert the panel file with the SAME name as the id
			include("inc/panels/" . $id . ".php");

		echo('</div>');
	echo('</div>');


	/*CREATE edit button*/
	/*If it's 1.null, 2.page panel or 3.set to appear, make no button*/
	if(!is_null($location) && $appear != "appear"){
		if($location == "#get-in-touch-paragraph"){
			// Hardcoded
			make_edit_button("outer", $id, $location);
		}else if($location == ".mail"){
			//Nothing
		}else{
			make_edit_button("inner", $id, $location);
		}
	} else if($appear == "appear"){/*If set to appear, appear*/
		open_panel($id);
	}
}

function make_edit_button($position, $form, $location){	
	echo('<div data-form="' . $form. '" data-location="' . $location. '" class="edit-button ' . $position . '", $location></div>');
}

function open_panel($id){
    echo '<script type="text/javascript">openPanel("'. $id .'");</script>';
}

function open_error_panels()
{
	if(isset($_SESSION['login-errors']) && $_GET['cms'] == 'view'){
		if($_SESSION['login-errors'] ){
			open_panel('login-admin');
		}	
	}else if(isset($_SESSION['login-errors'])){
		if($_SESSION['login-errors']){
			open_panel('login-residents');
		}
	}
}

function ordinal_suffix($num){
    $num = $num % 100; // protect against large numbers
    if($num < 11 || $num > 13){
         switch($num % 10){
            case 1: return 'st';
            case 2: return 'nd';
            case 3: return 'rd';
        }
    }
    return 'th';
}

function smtpmailer($to, $from, $from_name, $subject, $body, $attachmentPath, $replyToAddress) { 	
	global $error;
	$mail = new PHPMailer();  // create a new object
	$mail->IsSMTP(); // enable SMTP
	$mail->SMTPDebug = false;  // debugging: 1 = errors and messages, 2 = messages only
	$mail->do_debug = 0;
	$mail->SMTPAuth = true;  // authentication enabled
	$mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 465; 
	$mail->Username = GUSER;  
	$mail->Password = GPWD;
	$mail->addReplyTo($replyToAddress, $from_name);
	$mail->SetFrom($from, $from_name);
	$mail->Subject = $subject;
	//$mail->Body = $body;
	$mail->MsgHTML($body);
	$mail->AddAddress($to);
	if(false/*TODO*/){
		$mail->AddCC('person2@domain.com', 'Person Two');
	}	
	if(!is_null($attachmentPath)){
		$mail->AddAttachment($attachmentPath);
	}

	if(!$mail->Send()) {
		$error = 'Mail error: '.$mail->ErrorInfo; 		
		return false;
	} else {
		$error = 'Message sent!';
		return true;
	}	
}

?>	

