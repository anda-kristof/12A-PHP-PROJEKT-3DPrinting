<?php 

include_once("Functionality/AllCode.php");
session_start();
$conn = new Connection();
$users = $conn->getUsers(); 


?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="css/custom_navbar.css">
    <link rel="stylesheet" href="css/custom-dashboard.css">
    <title>Főoldal</title>
</head>
<body>
<div class="">
    <?php
    $todo = $_GET["todo"] ?? "access";
    
switch($todo){

    #login page
    case "login":
        include_once("pages/login.php");
       break;
    #login után
    case "signin":
    $errors = [];
    $username = '';
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = trim($_POST["username"] ?? '');
        $password = $_POST["password"] ?? "";
        
        if (empty($username)) {
            $errors['username'] = "Felhasználónév megadása kötelező!";
        }
        if (empty($password)) {
            $errors['password'] = "Jelszó megadása kötelező!";
        }
        
        if (empty($errors)) {
            if (validLogin($users, $username, $password)) {
                $_SESSION['user'] = getUserFromLogin($users, $username, $password);
                include_once("pages/dashboard.php");
            } else {
                $errors['general'] = validLoginText($users, $username, $password);
                include("pages/login.php");
            }
        } else {
            include("pages/login.php");
        }
    } else {
        include("pages/login.php");
    }
    break;
    #regisztráció page
    case "registration":
        include_once("pages/registration.php");
        break;
    # registráció után
    case "signup":
    $errors = [];
    $username = '';
    $email = '';
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $repassword = $_POST['repassword'] ?? '';
        $email = $_POST['email'] ?? '';
        $errors = validateSignUp($users, $username, $password, $repassword, $email, $errors);

        if (empty($errors)) {
            $conn->addUser($username, $password, $email);
            include_once('pages/login.php');
        } else {
            include('pages/registration.php');
        }
    } else {
        include('pages/registration.php');
    }
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
    case "deleteprinter":
        $aktprinterid = $_GET["aktprinterid"];
        $conn->deletePrinter($aktprinterid);
        include_once("pages/dashboard.php");
        break;
    case "newprinter":
        $printertypes = $conn->getPrinterTypes();
        include_once("pages/newPrinter.php");
        break;
    case "addprinter":
        
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']->user_id)) {
    // Hibakezelés: Nincs bejelentkezett felhasználó!
    die("Nincs bejelentkezve!");
}

$user_id = $_SESSION['user']->user_id;
        $errors = [];
        $aktuser = $_SESSION['user'];
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $printername = $_POST['printername'] ?? '';
            $printertype = $_POST['printertype'] ?? '';

            if($printername == ''){
                $errors['printername'] = "Adj nevet a nyomtatódnak!";
            }
            if(empty($errors)){
                $conn->addPrinter($printertype, $aktuser->user_id, $printername);
                include_once("pages/dashboard.php");
            }
            else{
                include("pages/newPrinter.php");
            }
        }
        break;
    case "newfilament":
        $materials = $conn->getMaterials();
        include_once("pages/newMaterial.php");
        break;
    case "addfilament":
        $aktuser = $_SESSION["user"];
        $errors = [];
        if($_SERVER['REQUEST_METHOD'] === "POST"){
            $matid = (int)($_POST["material_id"] ?? 0);
            $quantity = (int)($_POST["quantity"] ?? 0);
            if($matid == 0){
                $errors["material_id"] = "Jelöljön ki egy anyagot";
            }
            if($quantity<1){
                $errors["quantity"] = "Csak Pozitív mennyiséget vehetsz fel!";
            }
            if(empty($errors)){
                $conn->addFilament($aktuser->user_id, $matid, $quantity);
                include_once("pages/dashboard.php");
            }
            else{
                include("pages/newMaterial.php");
            }
        }
        break;
    case "newprint":
        $modells = $conn->getAllModels();
        $aktuser = $_SESSION['user'];
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