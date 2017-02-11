<?php
// Initialize variables
$role;
$page = basename($_SERVER['PHP_SELF']);
$current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

//Process admin log in
if(isset($_POST['login_admin_submit'])){

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    if($user->login($email,$password)){ 
      $role = $user->get_role($email);

      if($role == "admin"){// Ensure proper credentials
        //logged in return to index page
        header('Location: ' . $page . '?cms=view');
        exit;
      }else{
        $_SESSION['login-errors'] = '<p class="error">Account has no administrator privileges</p>';
      }

    } else {
        $_SESSION['login-errors'] = '<p class="error">Wrong email or password</p>';
    }
}

//Process residents log in
if(isset($_POST['login_residents_submit'])){

  $email = trim($_POST['email']);
  $password = trim($_POST['password']);
  
  if($user->login($email,$password)){

    $role = $user->get_role($email);
    $forward = $_GET['forward'];
    
    //logged in return to index page
    if($_GET["cms"] != "view")
    {
      header('Location: ' . $forward);
    }
    else{
      header('Location: ' . $forward . '?cms=view');
    }
    exit;
    
  } else {
    if($user->get_active($email) == "false"){
      $_SESSION['login-errors'] = '<p class="error">Account has not been activated</p>';
    }else{
      $_SESSION['login-errors'] = '<p class="error">Wrong email or password</p>';
    }
  }
}

// Initialize user status variables
$admin_query = false;
$admin_logged_in = false;
$residents_logged_in = false;
$user_logged_in = false; 

// Set the admin_query variable from $_GET
if(isset($_GET['cms'])){
  if($_GET['cms'] === "view"){
    $admin_query = true;    
  }
}

// Set the logged in variable from $_GET
if($user->is_residents_logged_in()){
  $residents_logged_in = true;
  $user_logged_in = true; 
}

// Set the logged in variable from $_GET
if($user->is_admin_logged_in()){
  $admin_logged_in = true;
  $user_logged_in = true; 
}
?>