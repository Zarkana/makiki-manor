<?php
ob_start();
session_start();

//local database credentials
// define('DBHOST','localhost');
// define('DBUSER','root');
// define('DBPASS','');
// define('DBNAME','makiki_manor');

//server database credentials
define('DBHOST','localhost');
define('DBUSER','nalani_makiki');
define('DBPASS','makiki1130');
define('DBNAME','nalani_makikimanor');

$db = new PDO("mysql:host=".DBHOST.";dbname=".DBNAME, DBUSER, DBPASS);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//set timezone
date_default_timezone_set('Pacific/Honolulu');

//load classes as needed
function __autoload($class) {
   
   $class = strtolower($class);

    //if call from within assets adjust the path
   $classpath = 'classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
    }     
    
    //if call from within admin adjust the path
   $classpath = '../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
    }
    
    //if call from within admin adjust the path
   $classpath = '../../classes/class.'.$class . '.php';
   if ( file_exists($classpath)) {
      require_once $classpath;
    }         
     
}

$user = new User($db); 
?>