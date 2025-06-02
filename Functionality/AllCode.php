<?php 

include_once("Connection.php");
include_once("Loginfuncs.php");
include_once("Registrationfuncs.php");
include_once("Print.php");
function floatSecsToTime($floatSeconds) {
    // Get total seconds as int
    $secs = floor($floatSeconds);
    // Format as HH:MM:SS (TIME type in MySQL)
    return gmdate("H:i:s", $secs);
}


while(true){
    
    sleep(1);
}


?>