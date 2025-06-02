<?php 
function validateSignUp($users, $username, $password, $repassword, $email, $errors)  {
    foreach($users as $u){
        if($u->username == $username){
            $errors['username'] = "Már foglalt felhasználónév!";
        }
        if($u->email == $email){
            $errors['email'] = "Ezzel az email címmel már regisztráltak!";

        }
    }
    if( strlen($username) == 0 || strlen($username)>30 || $username == ""){
         $errors['username'] = "Adjon meg egy érvényes Felhasználónevet 1-30 karakter között!";
    }
    if($email == "" || !filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['email'] = "Adjon meg egy érvényes email címet";
    }
    if($password == "" || strlen($password)<4 || strlen($password)>40){
                $errors['password'] = "Adjon meg egy érvényes jelszót";

    }
    if($repassword != $password){
        $errors['repassword'] = "A megadott jelszó nem egyezik!";
    }
    return $errors;
    
}

?>