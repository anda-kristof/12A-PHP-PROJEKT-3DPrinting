<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

header('Content-Type: application/json');
ini_set('display_errors', 0);

session_start();
require_once("../Functionality/Connection.php");


if (!isset($_SESSION['user'])) {
    echo json_encode([
        'printers' => '<div class="alert alert-danger">Nincs bejelentkezve!</div>',
        'filaments' => '',
        'jobs' => ''
    ]);
    exit;
}

$conn = new Connection();
$user_id = $_SESSION['user']->user_id;


$userprinters = $conn->getUserPrinters($user_id);
$printersHtml = "";
foreach ($userprinters as $p) {
    $printersHtml .= '
    <div class="col col-lg-3 col-md-4 col-sm-6">
        <div class="printers-dashboard-card">
            <img class="printers-dashboard-img"
                src="img/printer_types/' . htmlspecialchars($p->img) . '?v=' . time() . '"
                alt="printer">
            <div class="printers-dashboard-body">
                <h4 class="printers-dashboard-title">' . htmlspecialchars($p->printer_name) . '</h4>
                <h5 class="printers-dashboard-type">' . htmlspecialchars($p->printer_type_name) . '</h5>
                <h6 class="printers-dashboard-type">Állapot: ' . htmlspecialchars($p->status) . '</h6>
                <p class="printers-dashboard-text">Printer speed: ' . htmlspecialchars($p->printing_speed) . 'mm<sup>3</sup>/s</p>
                <p class="printers-dashboard-text">Plate size: ' . htmlspecialchars($p->plate_length) . " x " . htmlspecialchars($p->plate_height) . " x " . htmlspecialchars($p->plate_width) . ' mm</p>
                <div class="printers-dashboard-btn-row">
                    <a href="?todo=deleteprinter&aktprinterid=' . urlencode($p->printer_id) . '" class="btn btn-danger m-1">Delete</a>
                    <a href="?todo=printmodel&aktprinterid=' . urlencode($p->printer_id) . '" class="btn btn-success m-1">Nyomtatás</a>
                </div>
            </div>
        </div>
    </div>
    ';
}

$userfilaments = $conn->getUserFilaments($user_id);
$filamentsHtml = "";
foreach ($userfilaments as $f) {
    $filamentsHtml .= '
    <div class="col col-lg-3 col-md-4 col-sm-6">
        <div class="printers-dashboard-card">
            <img class="printers-dashboard-img"
                src="img/materials/' . htmlspecialchars($f->img) . '?v=' . time() . '"
                alt="filament">
            <div class="printers-dashboard-body">
                <h4 class="printers-dashboard-title">' . htmlspecialchars($f->name) . '</h4>
                <h5 class="printers-dashboard-type">' . htmlspecialchars($f->color) . '</h5>
                <p class="printers-dashboard-text">Elérhető mennyiség: ' . htmlspecialchars($f->filament_grams) . ' g</p>
            </div>
        </div>
    </div>
    ';
}


$userjobs = $conn->getUserJobs($user_id);
$jobsHtml = "";
foreach ($userjobs as $j) {
    // Progress bar számítás
    $progress = 0;
    if ($j->jobs_status == "finished") {
        $progress = 100;
    } elseif ($j->jobs_status == "queued") {
        $progress = 0;
    } elseif ($j->jobs_status == "printing") {
        $start = strtotime($j->jobs_starts_time);
        $now = time();
        $print_seconds = strtotime($j->jobs_print_time) - strtotime('TODAY');
        $elapsed = $now - $start;
        if ($print_seconds > 0) {
            $progress = min(100, max(0, round($elapsed / $print_seconds * 100)));
        } else {
            $progress = 0;
        }
    }
    $jobsHtml .= '
    <div class="col col-lg-3 col-md-4 col-sm-6">
        <div class="printers-dashboard-card">
            <img class="printers-dashboard-img"
                src="img/models/' . htmlspecialchars($j->models_img) . '?v=' . time() . '"
                alt="model">
            <div class="printers-dashboard-body">
                <h4 class="printers-dashboard-title">' . htmlspecialchars($j->models_name) . '</h4>
                <h4 class="printers-dashboard-title">Állapot: ' . htmlspecialchars($j->jobs_status) . '</h4>
                <h4 class="printers-dashboard-title">Nyomtató: ' . htmlspecialchars($j->printers_printer_name) . '</h4>
                <h4 class="printers-dashboard-title">Anyag: ' . htmlspecialchars($j->materials_name) . ' ' . htmlspecialchars($j->materials_color) . '</h4>
                <p class="printers-dashboard-text">Elérhető mennyiség: ' . htmlspecialchars($j->filaments_filament_grams) . ' g</p>
                <h5 class="printers-dashboard-type">' . htmlspecialchars($j->models_volume_mm) . ' mm<sup>3</sup></h5>
                <div class="progress my-2">
                    <div class="progress-bar" role="progressbar"
                        style="width: '.$progress.'%;" aria-valuenow="'.$progress.'"
                        aria-valuemin="0" aria-valuemax="100">'.$progress.'%</div>
                </div>
            </div>
        </div>
    </div>
    ';
}


echo json_encode([
    'printers' => $printersHtml,
    'filaments' => $filamentsHtml,
    'jobs' => $jobsHtml
]);
exit;