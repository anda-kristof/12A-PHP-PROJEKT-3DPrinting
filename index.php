<?php 

include_once("Functionality/AllCode.php");
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
        $models = $conn->getAllModels();
        $aktuser = $_SESSION['user'];
        $fprinters = $conn->getFreePrinters($aktuser->user_id);
        
        $userfilaments = $conn->getUserFilaments($aktuser->user_id);
        include_once("pages/printModel.php");
        break;
    case "print":
        $aktuser = $_SESSION['user'];
        if($_SERVER["REQUEST_METHOD"] === "POST"){
            $printerid = (int)$_POST["printer_id"];
            
            if($printerid != 0){
                $printer = $conn->getPrintersById($printerid);
            $printer_type = $conn-> getPrinterTypeOfPrinter($printer);
            $filamentid = (int)$_POST["filament_id"];
            $filament = $conn->getFilamentById($filamentid);
            $material = $conn->getMaterialOfFilament($filament);
            $modelid = (int)$_POST["model_id"];
            $model = $conn->getModelById($modelid);
            $grams = (((float)$material->density / 1000) * (float)$model->volume_mm) + 1;
            $floatsecs = ($model->volume_mm/$printer_type->printing_speed);
            $print_time = (floatSecsToTime($floatsecs));


            $errors = PrintValidate($printer_type->plate_length,$printer_type->plate_height, $printer_type->plate_width, $filament->filament_grams,$printerid, $material->name, $material->density,$printer_type->compatible_materials, $model->volume_mm, $model->recommended_material, $model->max_size_mm );}
            if(empty($errors)){
                if($printerid != 0){
                    $conn->Print($aktuser->user_id, $printerid, $filamentid, $print_time, $modelid, $grams );
                    include_once("pages/dashboard.php");

                }
            }
            else{
                include("pages/printModel.php");
            }
            if($printerid == 0){
                echo '<p class="bg-danger">Nincs szabad nyomtató</p>';
                include("pages/printModel.php");
            }
            
        }
        break;
    case "newupload":
        include_once("pages/uploadModel.php");
        break;

    case "upload":
    
    $user = $_SESSION['user'];
    $errors = [];
    if($_SERVER['REQUEST_METHOD'] === "POST"){
        
        $name = trim($_POST['name'] ?? "");
        $volume = isset($_POST['volume_mm']) ? (float)$_POST['volume_mm'] : 0;
        $maxsize = isset($_POST['max_size_mm']) ? (float)$_POST['max_size_mm'] : 0;
        $description = trim($_POST['description'] ?? "");
        $recommended = trim($_POST['recommended_material'] ?? "");

        
        if ($name === "" || strlen($name) > 100) {
            $errors['name'] = "Adj meg egy nevet, maximum 100 karakter!";
        }
        if ($volume <= 0) {
            $errors['volume_mm'] = "A térfogat csak pozitív szám lehet!";
        }
        if ($maxsize <= 0) {
            $errors['max_size_mm'] = "A maximális méret csak pozitív szám lehet!";
        }
        if (strlen($description) > 400) {
            $errors['description'] = "A leírás maximum 400 karakter lehet!";
        }
        if (strlen($recommended) > 100) {
            $errors['recommended_material'] = "Az ajánlott anyag maximum 100 karakter lehet!";
        }
       
        if ($recommended === "") {
            $errors['recommended_material'] = "Adj meg ajánlott anyagot!";
        }

        
        if (empty($errors)) {
            $conn->addModel($user->user_id, $name, $volume, $maxsize, $description, $recommended);
            include_once("pages/dashboard.php");
        } else {
            include("pages/uploadModel.php");
        }
    }
    break;
    case "dashboard":
        include_once("pages/dashboard.php");
    
}
    
    ?>
    
</div>
</body>
<script>
//     setInterval(function() {
//     fetch("checkjobs.php")
//       .then(r => r.json())
//       .then(data => { /* frissítsd a UI-t */ });
// }, 1000);



</script>
</html>