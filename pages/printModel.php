<head><link href="https://fonts.googleapis.com/css?family=Montserrat:600,400&display=swap" rel="stylesheet"></head>
<div class="container">
    <div class="sidebar">
        <h2>3D Print Hub</h2>
        <nav>
            <a href="#" class="active">Printers</a>
            <a href="#">Filaments</a>
            <a href="#">Upload Model</a>
            <a href="#">History</a>
        </nav>
        <div class="settings">
            <strong>Settings</strong><br>
            <a href="#">Account</a> &nbsp;|&nbsp;
            <a href="#">Logout</a>
            <br><br>
            <span style="font-size: 0.86em;">&copy; 2025 3D Print Team</span>
        </div>
    </div>
    <div class="main-content">
        <div class="models-header">
            <h1>Elérhető Modellek</h1>
            <button class="upload-btn">+ Modell Feltöltése</button>
        </div>
        <div class="models-list">
            <?php 
            foreach($modells as $m){
                echo '<div class="model-card">
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
            </div>';
            }
            ?>
            
            <!-- Add more .model-card elements dynamically -->
        </div>
    </div>
</div>


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
        .sidebar nav {
            margin: 36px 0 32px 0;
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