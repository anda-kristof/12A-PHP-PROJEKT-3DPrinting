<?php

require_once(__DIR__ . '/../Functionality/Classes.php'); // 1. osztálydefiníciók
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}                                         // 2. session
require_once(__DIR__ . '/../Functionality/Connection.php'); // 3. többi include

if (!isset($_SESSION['user']) || !is_object($_SESSION['user'])) {
    echo "<div style='color:red'>Nem vagy bejelentkezve!</div>";
    exit;
}
$user_id = $_SESSION['user']->user_id ?? null;
if ($user_id === null) {
    echo "<div style='color:red'>Nincs user_id!</div>";
    exit;
}

$conn = new Connection();
$user_id = $_SESSION['user']->user_id;
// require_once(__DIR__ . '/../Functionality/checkjobs.php'); // 3. többi include


$html = '';
$html .= '
<nav class="navbar navbar-expand-lg custom-navbar sticky-top" id="dashboard-navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#printers-dashboard-section">Printers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#filafila">Filaments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#jobss">Models</a>
                </li>
            </ul>
            <div class="navbar-user">
                <h3>Üdv, ' . htmlspecialchars($_SESSION["user"]->username) . '</h3>
            </div>
            <a href="?todo=access" class="btn btn-logout">Kijelentkezés</a>
        </div>
    </div>
</nav>
';

// PRINTERS
$html .= '<div id="printers-dashboard-section">
    <h2>Nyomtatóim</h2>
    <div id="printers-dashboard-row">';
$userprinters = $conn->getUserPrinters($user_id);

foreach ($userprinters as $p) {
    $html .= '
       <div class="col col-lg-3 col-md-4 col-sm-6" >
         <div class="printers-dashboard-card">
          <img class="printers-dashboard-img" src="img/printer_types/' . htmlspecialchars($p->img) . '" alt="printer">
          <div class="printers-dashboard-body">
            <h4 class="printers-dashboard-title">' . htmlspecialchars($p->printer_name) . '</h4>
            <h5 class="printers-dashboard-type">' . htmlspecialchars($p->printer_type_name) . '</h5>
            <h6 class="printers-dashboard-type">Állapot: ' . htmlspecialchars($p->status) . '</h6>
            <p class="printers-dashboard-text">Printer speed: ' . htmlspecialchars($p->printing_speed) . 'mm<sup>3</sup>/s</p>
            <p class="printers-dashboard-text">Plate size: ' . htmlspecialchars($p->plate_length) . " x " . htmlspecialchars($p->plate_height) . " x " . htmlspecialchars($p->plate_width) . ' mm</p>
            <div class="printers-dashboard-btn-row">
              <a href="?todo=deleteprinter&aktprinterid=' . htmlspecialchars($p->printer_id) .'&aktprintername='.htmlspecialchars($p->printer_name).' " class="btn btn-danger m-1">Delete</a>
              <a href="?todo=newprint&aktprinterid=' . htmlspecialchars($p->printer_id) . '" class="btn btn-success m-1">Nyomtatás</a>
            </div>
          </div>
        </div>
       </div>';
}
$html .= '</div>
    <div class="d-flex justify-content-center my-4">
        <a href="?todo=newprinter" class="btn custom-dashboard-btn">Új nyomtató</a>
    </div>
</div>';

// FILAMENTS
$html .= '<div id="printers-dashboard-section">
    <h2 id="filafila">Filamentek</h2>
    <div id="printers-dashboard-row">';
$userfilaments = $conn->getUserFilaments($user_id);
foreach ($userfilaments as $f) {
    $html .= '
       <div class="col col-lg-3 col-md-4 col-sm-6" >
         <div class="printers-dashboard-card">
          <img class="printers-dashboard-img" src="img/materials/' . htmlspecialchars($f->img) . '" alt="filament">
          <div class="printers-dashboard-body">
            <h4 class="printers-dashboard-title">' . htmlspecialchars($f->name) . '</h4>
            <h5 class="printers-dashboard-type">' . htmlspecialchars($f->color) . '</h5>
            <p class="printers-dashboard-text">Elérhető mennyiség: ' . htmlspecialchars($f->filament_grams) . ' g</p>
          </div>
        </div>
       </div>';
}
$html .= '</div>
    <div class="d-flex justify-content-center my-4">
        <a href="?todo=newfilament" class="btn custom-dashboard-btn">Filament hozzáadása</a>
    </div>
</div>';

// JOBS
$html .= '<div id="printers-dashboard-section">
    <h2 id="jobss">Nyomtatások</h2>
    <div id="printers-dashboard-row">';
$userjobs = $conn->getUserJobs($user_id);
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
    $html .= '
   <div class="col col-lg-3 col-md-4 col-sm-6">
     <div class="printers-dashboard-card">
      <img class="printers-dashboard-img" src="img/models/' . htmlspecialchars($j->models_img) . '" alt="model">
      <div class="printers-dashboard-body">
        <h4 class="printers-dashboard-title">' . htmlspecialchars($j->models_name) . '</h4>
        <h4 class="printers-dashboard-title">Állapot: '  . htmlspecialchars($j->jobs_status) . '</h4>
        <h4 class="printers-dashboard-title">Nyomtató:  ' . htmlspecialchars($j->printers_printer_name) . '</h4>
        <h4 class="printers-dashboard-title">Anyag: ' . htmlspecialchars($j->materials_name) . " " . htmlspecialchars($j->materials_color) . '</h4>
        
        <h5 class="printers-dashboard-type">' . htmlspecialchars($j->models_volume_mm) . ' mm<sup>3</sup></h5>
        <div class="progress my-2">
          <div class="progress-bar" role="progressbar" style="width: '.$progress.'%;" aria-valuenow="'.$progress.'" aria-valuemin="0" aria-valuemax="100">'.$progress.'%</div>
        </div>
      </div>
    </div>
   </div>';
}
$html .= '</div>
    <div class="d-flex justify-content-center my-4">
        <a href="?todo=newprint" class="btn custom-dashboard-btn">Új nyomtatás</a>
        <a href="?todo=newupload" class="btn custom-dashboard-btn">+ Modell Feltöltése</a>
    </div>
</div>';

echo $html;
?>