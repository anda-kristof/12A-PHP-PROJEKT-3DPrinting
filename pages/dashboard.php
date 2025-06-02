<nav class="navbar navbar-expand-lg custom-navbar sticky-top" id="dashboard-navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Printers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Filaments</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Modellek
                    </a>
                    <ul class="dropdown-menu custom-dropdown">
                        <li><a class="dropdown-item" href="#">Modell feltöltése</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Online Modellek</a></li>

                    </ul>
                </li>

            </ul>
            <div class="navbar-user">
                <h3>Üdv, <?php echo $_SESSION["user"]->username; ?></h3>
            </div>
            <a href="?todo=access" class="btn btn-logout">Kijelentkezés</a>
        </div>
    </div>
</nav>
<div id="printers-dashboard-section">
    <h2>Nyomtatóim</h2>
    <div id="printers-dashboard-row">
        <?php
        $userprinters = $conn->getUserPrinters($_SESSION["user"]->user_id);
        foreach ($userprinters as $p) {
            echo '
       <div class="col col-lg-3 col-md-4 col-sm-6" >
         <div class="printers-dashboard-card">
          <img class="printers-dashboard-img" src="img/printer_types/' . $p->img . '" alt="printer">
          <div class="printers-dashboard-body">
            <h4 class="printers-dashboard-title">' . $p->printer_name . '</h4>
            <h5 class="printers-dashboard-type">' . $p->printer_type_name . '</h5>
            <h6 class="printers-dashboard-type">Állapot: ' . $p->status . '</h6>
            <p class="printers-dashboard-text">Printer speed: ' . $p->printing_speed . 'mm<sup>3</sup>/s</p>
            <p class="printers-dashboard-text">Plate size: ' . $p->plate_length . " x " . $p->plate_height . " x " . $p->plate_width . ' mm</p>
            <div class="printers-dashboard-btn-row">
              <a href="?todo=deleteprinter&aktprinterid=' . $p->printer_id . '" class="btn btn-danger m-1">Delete</a>
              <a href="?todo=printmodel&aktprinterid=' . $p->printer_id . '" class="btn btn-success m-1">Nyomtatás</a>
            </div>
          </div>
        </div>
       </div>';
        }
        ?>
    </div>
    <div class="d-flex justify-content-center my-4">
        <a href="?todo=newprinter" class="btn custom-dashboard-btn">Új nyomtató</a>
    </div>
</div>
<div id="printers-dashboard-section">
    <h2>Filamentek</h2>
    <div id="printers-dashboard-row">
        <?php
        $userfilaments = $conn->getUserFilaments($_SESSION["user"]->user_id);
        foreach ($userfilaments as $f) {
            echo '
       <div class="col col-lg-3 col-md-4 col-sm-6" >
         <div class="printers-dashboard-card">
          <img class="printers-dashboard-img" src="img/materials/' . $f->img . '" alt="printer">
          <div class="printers-dashboard-body">
            <h4 class="printers-dashboard-title">' . $f->name . '</h4>
            <h5 class="printers-dashboard-type">' . $f->color . '</h5>
            <p class="printers-dashboard-text">Elérhető mennyiség: ' . $f->filament_grams . ' g</p>
            
            
          </div>
        </div>
       </div>';
        }
        ?>
    </div>
    <div class="d-flex justify-content-center my-4">
        <a href="?todo=newfilament" class="btn custom-dashboard-btn">Filament hozzáadása</a>
    </div>
</div>
<div id="printers-dashboard-section">
    <h2>Nyomtatások</h2>
    <div id="printers-dashboard-row">
        <?php
$userjobs = $conn->getUserJobs($_SESSION["user"]->user_id);
foreach ($userjobs as $j) {
    // Progress bar számítás
    $progress = 0;
    if ($j->jobs_status == "finished") {
        $progress = 100;
    } elseif ($j->jobs_status == "queued") {
        $progress = 0;
    } elseif ($j->jobs_status == "printing") {
        // Eltelt idő százalék számítása (ha pontos progress kell)
        $start = strtotime($j->jobs_starts_time);
        $now = time();
        $print_seconds = strtotime($j->jobs_print_time) - strtotime('TODAY'); // csak idő, ezért TODAY-t vonunk ki
        $elapsed = $now - $start;
        if ($print_seconds > 0) {
            $progress = min(100, max(0, round($elapsed / $print_seconds * 100)));
        } else {
            $progress = 0;
        }
    }
    echo '
   <div class="col col-lg-3 col-md-4 col-sm-6">
     <div class="printers-dashboard-card">
      <img class="printers-dashboard-img" src="img/models/' . $j->models_img . '" alt="printer">
      <div class="printers-dashboard-body">
        <h4 class="printers-dashboard-title">' . $j->models_name . '</h4>
        <h4 class="printers-dashboard-title">Állapot:'  . $j->jobs_status . '</h4>
        <h4 class="printers-dashboard-title">Nyomtató:  ' . $j->printers_printer_name . '</h4>
        <h4 class="printers-dashboard-title">Anyag: ' . $j->materials_name . " " . $j->materials_color . '</h4>
        <p class="printers-dashboard-text">Elérhető mennyiség: ' . $j->filaments_filament_grams . ' g</p>
        <h5 class="printers-dashboard-type">' . $j->models_volume_mm . ' mm<sup>3</sup></h5>
        <div class="progress my-2">
          <div class="progress-bar" role="progressbar" style="width: '.$progress.'%;" aria-valuenow="'.$progress.'" aria-valuemin="0" aria-valuemax="100">'.$progress.'%</div>
        </div>
      </div>
    </div>
   </div>';
}
?>
    </div>
    <div class="d-flex justify-content-center my-4">
        <a href="?todo=newprint" class="btn custom-dashboard-btn">Új nyomtatás</a>
    </div>
</div>