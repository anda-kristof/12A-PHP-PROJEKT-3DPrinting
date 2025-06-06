<head>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:600,400&display=swap" rel="stylesheet">
</head>
<div class="container">
    <div class="sidebar">
        <h2>3D Print Hub</h2>
        <form class="sidebar-select-form">
            <label for="printer-select">Nyomtató:</label> <!--Csak idle nyomtatók -->
            <select id="printer-select" class="sidebar-select" name="printer_id">
                <?php
                     $fprinters = $conn->getFreePrinters($aktuser->user_id);
                     if(empty($fprinters)){
                        
    echo '<option value="0"  selected>'.'Nincs szabad nyomtató'.'</option>';
}
                 foreach($fprinters as $p){
                    if($p->status == "idle"){

                        if($_GET["aktprinterid"] || $_GET["aktprintername"]){
                            if($p->printer_id == (int)$_GET['aktprinterid']){
                                echo '<option value="'.$p->printer_id.'" selected>'.$p->printer_name.'</option>';
                            }
                            else{

                                echo '<option value="'.$p->printer_id.'">'.$p->printer_name.'</option>';
                            }
                        }
                        else{
                            echo '<option value="'.$p->printer_id.'">'.$p->printer_name.'</option>';
                        }
                    }
                    }
                    
                    ?>
                
            </select>
            <label for="filament-select">Filament:</label>
            <select id="filament-select" class="sidebar-select" name="filament_id">
                <?php 
                $userfilaments = $conn->getUserFilaments($aktuser->user_id);
        
                foreach($userfilaments as $f){
                    echo '<option value="'.$f->filament_id.'">'.$f->name.' - '.$f->color.'</option>';
                }
                ?>
               
            </select>
            <?php if (!empty($errors)): ?>
    <div class="alert alert-danger shadow-sm mt-3 mb-4" style="max-width: 600px; margin:auto;">
        <div class="d-flex align-items-center mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#dc3545" class="bi bi-exclamation-triangle flex-shrink-0 me-2" viewBox="0 0 16 16" aria-label="Error:">
                <path d="M7.938 2.016a.13.13 0 0 1 .125 0l6.857 11.856c.03.052.05.115.05.18 0 .18-.15.325-.33.325H1.36a.324.324 0 0 1-.33-.325c0-.065.019-.128.05-.18L7.938 2.016zm.823-1.447a1.13 1.13 0 0 0-1.623 0L.282 12.425A1.13 1.13 0 0 0 1.359 14h13.282a1.13 1.13 0 0 0 1.076-1.575L8.76.569zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
            </svg>
            <span class="fw-bold">Hiba történt:</span>
        </div>
        <ul class="mb-0 ps-4">
            <?php foreach ($errors as $err): ?>
                <li><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>
        </form>
        <nav>
            
            <a href="?todo=dashboard">Back to dashboard</a>
            
        </nav>
        <div class="settings">
            
            <a href="?todo=access">Logout</a>
            <br><br>
            <span style="font-size: 0.86em;">&copy; 2025 AK</span>
        </div>
    </div>
    <div class="main-content">
        <div class="models-header">
            <h1>Elérhető Modellek</h1>
            <a class="upload-btn btn" href="?todo=newupload" >+ Modell Feltöltése</a>
        </div>
        <div class="models-list">
            <?php 
            $models = $conn->getAllModels();
            foreach($models as $m){
                echo '<form class="print-form" method="POST" action="?todo=print">
  <input type="hidden" name="todo" value="print">
  <input type="hidden" name="model_id" value="'.$m->model_id.'">
  <input type="hidden" name="printer_id" value="">
  <input type="hidden" name="filament_id" value=""><div class="model-card">
                <img src="../12A-PHP-PROJEKT-3DPrinting/img/models/'.$m->img.'" alt="Model" class="model-img">
                <div class="model-content">
                    <div class="model-title">'.$m->name.'</div>
                    <div class="model-uploader">Feltöltő: '.$m->username.'</div>
                    <div class="model-meta">
                        <div>Anyag: '.$m->recommended_material.'</div>
                        <div>Térfogat: '.$m->volume_mm.'mm<sup>3</sup></div>
                        <div>Leírás: '.$m->description.'</div>
                    </div>
                    <div class="model-actions">
                        <button class="btn btn-primary">Print</button>
                    </div>
                </div>
            </div></form>';
            }
            ?>
        </div>
    </div>
</div>
<script>
document.querySelectorAll('.print-form').forEach(function(form) {
  form.addEventListener('submit', function(e) {
    
    const printer = document.getElementById('printer-select');
    const filament = document.getElementById('filament-select');
    
    form.querySelector('input[name="printer_id"]').value = printer.value;
    form.querySelector('input[name="filament_id"]').value = filament.value;
   
  });
});
</script>

<style>
    :root {
        --bg-main: #0b0c10;
        --sidebar-bg: #111214;
        --sidebar-accent: #232b23;
        --primary: #19ff19;
        --primary-dark: #16c716;
        --card-bg: #181b1f;
        --text-main: #e0ffe0;
        --card-border: #19ff19;
        --shadow: 0 6px 24px 0 rgba(30,255,90,0.09);
        --inactive: #2b2e33;
        --meta: #81d481;
        --select-bg: #181b1f;
        --select-border: #19ff19;
        --select-hover: #232b23;
        --select-focus: #19ff19;
        --select-text: #e0ffe0;
        --select-arrow: #19ff19;
    }
    body {
        margin: 0;
        font-family: 'Montserrat', Arial, sans-serif;
        background: var(--bg-main);
        color: var(--text-main);
        min-height: 100vh;
    }
    .container {
        display: flex;
        min-height: 100vh;
    }
    .sidebar {
        width: 30vw;
        min-width: 240px;
        max-width: 400px;
        background: linear-gradient(135deg, var(--sidebar-bg) 80%, var(--sidebar-accent));
        color: var(--text-main);
        padding: 36px 26px 28px 30px;
        display: flex;
        flex-direction: column;
        box-shadow: 2px 0 20px 0 rgba(30,255,90,0.07);
    }
    .sidebar h2 {
        margin-top: 0;
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: 1px;
        color: var(--primary);
        text-shadow: 0 2px 10px #25ff3850;
    }
    .sidebar-select-form {
        display: flex;
        flex-direction: column;
        gap: 15px;
        margin-bottom: 38px;
    }
    .sidebar-select-form label {
        font-size: 1.01rem;
        color: var(--primary);
        margin-bottom: 2px;
        font-weight: 600;
    }
    .sidebar-select {
        background: var(--select-bg);
        color: var(--select-text);
        border: 2px solid var(--select-border);
        border-radius: 7px;
        padding: 10px 12px;
        font-size: 1rem;
        font-family: inherit;
        outline: none;
        box-shadow: none;
        appearance: none;
        margin-bottom: 0;
        transition: border 0.15s, box-shadow 0.15s, background 0.15s;
        position: relative;
    }
    .sidebar-select:focus, .sidebar-select:hover {
        border-color: var(--select-focus);
        background: var(--select-hover);
        box-shadow: 0 0 0 2px #19ff1930;
    }
    .sidebar-select option {
        background: #1c2221;
        color: var(--text-main);
    }
    
    .sidebar-select {
        background-image: url("data:image/svg+xml,%3Csvg width='16' height='16' fill='none' stroke='%2319ff19' stroke-width='2' viewBox='0 0 24 24'%3E%3Cpath d='M7 10l5 5 5-5'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 18px 18px;
        padding-right: 40px;
    }
    .sidebar nav {
        margin: 24px 0 32px 0;
        display: flex;
        flex-direction: column;
        gap: 22px;
    }
    .sidebar nav a {
        color: var(--text-main);
        text-decoration: none;
        font-size: 1.06rem;
        padding: 12px 16px;
        border-radius: 9px;
        background: transparent;
        transition: background 0.17s, color 0.17s;
    }
    .sidebar nav a.active,
    .sidebar nav a:hover {
        background: var(--primary);
        color: #0b0c10;
        font-weight: 600;
        box-shadow: 0 2px 6px #19ff1950;
    }
    .sidebar .settings {
        margin-top: auto;
        padding-top: 18px;
        border-top: 1px solid #222;
        font-size: 0.97rem;
        color: #7bf77b;
    }
    .sidebar .settings a {
        color: var(--primary);
        text-decoration: underline;
    }
    .main-content {
        flex: 1;
        min-width: 0;
        background: var(--bg-main);
        display: flex;
        flex-direction: column;
        padding: 48px 5vw 38px 5vw;
    }
    .models-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 36px;
    }
    .models-header h1 {
        margin: 0;
        font-size: 2.1rem;
        font-weight: 700;
        color: var(--primary);
        letter-spacing: 0.5px;
        text-shadow: 0 2px 10px #19ff1940;
    }
    .models-header .upload-btn {
        background: var(--primary);
        color: #000;
        border: none;
        border-radius: 7px;
        padding: 10px 24px;
        font-size: 1.08rem;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 3px 18px #19ff1930;
        transition: background 0.16s, color 0.16s;
    }
    .models-header .upload-btn:hover {
        background: var(--primary-dark);
        color: #fff;
    }
    .models-list {
        display: flex;
        flex-wrap: wrap;
        gap: 32px;
    }
    .model-card {
        background: var(--card-bg);
        border-radius: 15px;
        border: 2px solid var(--card-border);
        box-shadow: var(--shadow);
        width: 260px;
        display: flex;
        flex-direction: column;
        align-items: stretch;
        overflow: hidden;
        transition: transform 0.16s, box-shadow 0.16s, border-color 0.16s;
    }
    .model-card:hover {
        transform: translateY(-6px) scale(1.035);
        box-shadow: 0 16px 36px 0 #19ff1940;
        border-color: var(--primary-dark);
    }
    .model-img {
        width: 100%;
        height: 150px;
        object-fit: contain;
        background: #0e1f11;
        border-bottom: 1.5px solid var(--primary);
        display: block;
    }
    .model-content {
        padding: 18px 20px 20px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        flex: 1;
    }
    .model-title {
        font-size: 1.12rem;
        font-weight: 600;
        margin: 0 0 6px;
        color: var(--primary);
    }
    .model-uploader {
        font-size: 0.97rem;
        color: #34ff65;
        margin-bottom: 5px;
    }
    .model-meta {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        font-size: 0.93rem;
        color: var(--meta);
    }
    .model-actions {
        margin-top: 14px;
        display: flex;
        gap: 12px;
    }
    .btn {
        padding: 7px 17px;
        border-radius: 6px;
        border: none;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.14s, color 0.14s;
    }
    .btn-primary {
        background: var(--primary);
        color: #0b0c10;
    }
    .btn-primary:hover {
        background: var(--primary-dark);
        color: #fff;
    }
    .btn-secondary {
        background: #181b1f;
        border: 1.5px solid var(--primary);
        color: var(--primary);
    }
    .btn-secondary:hover {
        background: var(--primary);
        color: #000;
    }
    @media (max-width: 1000px) {
        .container { flex-direction: column; }
        .sidebar { width: 100vw; max-width: 100vw; border-radius: 0 0 22px 22px; }
        .main-content { padding: 28px 3vw; }
        .models-list { justify-content: center; }
    }
    @media (max-width: 600px) {
        .models-header { flex-direction: column; gap: 16px; }
        .main-content { padding: 14px 2vw; }
        .model-card { width: 97vw; }
    }
</style>