<?php
session_start();
require_once("Connection.php");
$conn = new Connection();

header('Content-Type: application/json');

$user_id = $_SESSION["user"]->user_id;

// Nyomtatók
ob_start();
$userprinters = $conn->getUserPrinters($user_id);
foreach ($userprinters as $p) {
    // Ide másold be a dashboard.php-ban használt kártya-generáló echo részt
}
$printers_html = ob_get_clean();

// Filamentek
ob_start();
$userfilaments = $conn->getUserFilaments($user_id);
foreach ($userfilaments as $f) {
    // Ide másold be a filament kártyák generálását
}
$filaments_html = ob_get_clean();

// Nyomtatások
ob_start();
$userjobs = $conn->getUserJobs($user_id);
foreach ($userjobs as $j) {
    // Ide másold be a nyomtatás kártyák generálását, progress bar számítással együtt
}
$jobs_html = ob_get_clean();

echo json_encode([
    'printers' => $printers_html,
    'filaments' => $filaments_html,
    'jobs' => $jobs_html
]);
?>