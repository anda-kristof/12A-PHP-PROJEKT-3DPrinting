<?php 

include_once("Connection.php");

$conn = new Connection();
$users = $conn->getUsers();

function validLogin($users, $username, $password){
    foreach($users as $u){
        if($u->username == $username){
            if($u->password == $password){
                return "Hurray, you logged in !!!";
            }
        } 
    }
    return "You are an idiot, cant even remember your fucking password!!!";
}

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $username = trim($_POST["username"] ?? '');
    $password = $_POST["password"] ?? "";
    

    
}



?>

<div>
    <form method="POST" action="?todo=signin">
    <div class="my-3">
        <label for="username" class="form-label">Felhasználónév</label>
        <input type="text" name="username" id="username" class="form-control">
    </div>
     <div class="my-3">
        <label for="password" class="form-label">Jelszó</label>
        <input type="text" name="password" id="password" class="form-control">
    </div>
     <div class="my-3">
        <button type="submit">Bejelentkezés</button>
    </div>
    </form>
</div>