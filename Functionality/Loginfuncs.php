<?php
function getUserFromLogin($users, $username, $password){
foreach($users as $u){
        if($u->username == $username){
            if($u->password == $password){
                return $u;
            }
        } 
    }
    return false;
}
function validLoginText($users, $username, $password){
    foreach($users as $u){
        if($u->username == $username){
            if($u->password == $password){
                return "Hurray, you logged in !!!";
            }
        } 
    }
    return "You are an idiot, cant even remember your fucking password!!!";
}

function validLogin($users, $username, $password){
    foreach($users as $u){
        if($u->username == $username){
            if($u->password == $password){
                return true;
            }
        } 
    }
    return false;
}
?>

  