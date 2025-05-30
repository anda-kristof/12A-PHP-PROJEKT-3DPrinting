<?php 

$todo = $_GET["todo"] ?? "";
switch($todo){
    case "login":
        include_once("login.php");
        break;
    case "registration":
        include_once("registration.php");
        break;
}

?>

<div class="container mt-5 d-flex justify-content-between">
    <a href="?todo=login" class="btn btn-secondary rounded">Bejelentkezés</a>
    <a href="?todo=registration" class="btn btn-secondary rounded">Regisztráció</a>
</div>