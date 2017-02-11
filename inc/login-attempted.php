<?php
if(isset($_GET["code"])||isset($_GET["email"])){//If we have a set code
  make_panel("Enter New Password", "reset-password", null, "appear", null);
}

//Confirm that the email us form was sent
if(isset($_GET["inquiry_sent_confirmation"])){
  make_panel("Inquiry Sent", "confirmation-inquiry-sent", null, "appear", null);
}

//Confirm that the ubsubscribe button in email was clicked
if(isset($_GET["unsubscribe_confirmation"])){
  make_panel("Unsubscribe", "confirmation-unsubscribe", null, "appear", null);
}

if(!$admin_query){//If not an admin query

  //Requesting an account confirmation
  if(isset($_GET["user_request_confirmation"])){
    make_panel("Account Request Confirmation", "confirmation-user-request", null, "appear", null);
  }

  //Requesting to reset an accounts password confirmation
  if(isset($_GET["request_reset_confirmation"])){
    make_panel("Email Sent", "confirmation-request-reset", null, "appear", null);
  }

  //Resetting an accounts password confirmation
  if(isset($_GET["reset_password_confirmation"])){
    make_panel("Password Reset Confirmation", "confirmation-reset-password", null, "appear", null);
  }

  if($confidential){
    if(!$user_logged_in){ header('Location: index.php?login=view&forward=' . $page); }
  }

  if($_GET['login'] === "view"){
    make_panel("Resident Log In", "login-residents", null, null, null);
    open_panel("login-residents");
  }
}
else
{  
  if(!$admin_logged_in){
    make_panel("Admin Log In", "login-admin", null, null, null);
    open_panel("login-admin");

  } else if($admin_logged_in){
    //Allocate edit buttons
    echo('<script type="text/javascript">allocateEditButtons();</script>');

    // Show control panel
    echo('<script type="text/javascript">showControlPanel();</script>');

    // Load admin panels
    include("inc/admin-panels.php");    

    // Modify all links
    echo('<script type="text/javascript">modifyLinks("admin");</script>');

  }
}
if(isset($login_errors)){
    open_panel('login-admin');
}
if($page == "forms.php"){
  make_panel("Upload Filled PDF", "add-filled-pdf", ".mail", null, null);
}
?>