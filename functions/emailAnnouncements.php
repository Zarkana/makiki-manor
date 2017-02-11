
<?php
function emailAnnouncements($subject, $body/*, $attachmentPath*/){     
	global $db;
	global $user;
	global $page;
	global $current_url;
	global $login_errors;

	if(isset($_POST['add_ann_submit'])){
		/*		
		WARNING: The following code is dangerous, changing it may result in the server
		sending infinite emails to all residentss! Please, dear God in heaven, don't mess with it or
		a thousand ghosts of server admins will seek your demise. Thank You.
		*/
        try {
            $stmt = $db->query('SELECT memberID, first, last, email, active, subscribed FROM users ORDER BY first');
            $to_email = array();
            $i = 0;
            define("MAX_TO_EMAIL", 200);
            while($residents = $stmt->fetch()){
            	if(MAX_TO_EMAIL < $i){
            		exit;
            	}
            	//Valid email
            	if($residents['email'] != "" && !is_null($residents['email'])){
            		//Active account
            		if($residents['active'] == "true" && !is_null($residents['active'])){
            			//Subscribed account
	            		if(($residents['subscribed'] != "") && !is_null($residents['subscribed']) && ($residents['subscribed'] != "false") && ($residents['subscribed'] != false)){
			                $to_email[$i] = $residents;
			                $i++;
		            	}
	            	}
            	}
            }
        } catch(PDOException $e) {
            //echo $e->getMessage();
        }

		require("functions/PHPMailer/class.phpmailer.php"); // path to the PHPMailerAutoload.php file.
		require("functions/PHPMailer/class.smtp.php");

		define('GUSER', 'makikimanorcontact@gmail.com'); // GMail username
		define('GPWD', 'Makikimanor01'); // GMail password
		
		//smtpmailer("jsc940@gmail.com", GUSER, 'Makiki Manor', $subject, $body, null);
		define("MAX_SENT", 200);
		$j = 0;
		foreach ($to_email as $residents) {
			$temp_body = $body . "<br><br><a style='margin-left: 40%;' href='http://www.makikimanor.com/index.php?unsubscribe_confirmation=view&unsubscribe_email=" . $residents['email'] . "'>Unsubscribe</a>";
        	if(MAX_SENT < $j){
        		exit;        		
        	}
			smtpmailer($residents['email'], GUSER, 'Makiki Manor', $subject, $temp_body, null, "support@makikimanor.com");	
			$j++;
		}
	}
}
?>