<?php 
session_start();




?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <title>Főoldal</title>
</head>
<body>
<div class="container">
    <?php
    $todo = $_GET["todo"] ?? "access";
switch($todo){
    case "login":
        include_once("pages/login.php");
        if($_SERVER["REQUEST_METHOD"] === "POST"){
    $username = trim($_POST["username"] ?? '');
    $password = $_POST["password"] ?? "";

    if(validLogin($users, $username, $password)){
        include_once("pages/dashboard.php");
        $_SESSION['user'] = getUserFromLogin($users, $username, $password);
    }
    

echo "<div class='alert alert-danger'>" . validLoginText($users, $username, $password) . "</div>";}
        break;
    case "registration":
        include_once("pages/registration.php");
        break;
    case "access":
        include_once("pages/access.php");
        break;
    case "models":
        include_once("pages/models.php");
        break;
    case "printers":
        include_once("pages/printers.php");
        break;
    case "newprinter":
        include_once("pages/newPrinter.php");
        break;
    case "newmaterial":
        include_once("pages/newMaterial.php");
        break;
    case "printmodel":
        include_once("pages/printModel.php");
        break;
    case "uploadmodel":
        include_once("pages/uploadModel.php");
        break;
    case "dashboard":
        include_once("pages/dashboard.php");
    
}
    
    ?>
    
</div>
</body>
</html>