<?php
//include config
require_once('../inc/config.php');

//log user out
$user->logout();
header('Location: ../' . $page); 

?>