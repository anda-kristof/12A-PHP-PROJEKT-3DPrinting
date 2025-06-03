<div class="addprinter-flexroot">
    <form method="POST" action="?todo=addprinter" autocomplete="off" id="addprinter-form" class="addprinter-form">
        <h1>Új nyomtató hozzáadása</h1>
        <div class="mb-4">
            <label for="printername" class="form-label">Nyomtató neve</label>
            <input type="text" name="printername" id="printername" class="form-control addprinter-input" autocomplete="off">
        </div>
        <div class="mb-4">
            <label for="printertype" class="form-label">Nyomtató típusa</label>
            <select name="printertype" id="printertype" class="form-control addprinter-input">
                <?php
                foreach ($printertypes as $pt) {
                    echo '<option value="' . $pt->printer_type_id . '" data-img="' . $pt->img . '" data-name="' . $pt->printer_type_name . '" data-speed="' . $pt->printing_speed . ' mm/s" data-plate="'.$pt->plate_length.'×'.$pt->plate_width.'×'.$pt->plate_height.' mm" data-materials="'.$pt->compatible_materials.'">' . $pt->printer_type_name . '</option>';
                }
                ?>

            </select>
        </div>
        <div class="mb-4 text-center d-flex gap-3 justify-content-center">
            <button class="addprinter-btn" type="submit">Hozzáadás</button>
            <a href="?todo=dashboard" class="cancel-btn">Mégse</a>
        </div>
    </form>
    <div class="addprinter-bigpreview" id="printer-preview">
        <img src="img/printer_types/prusa.png" alt="Prusa i3" id="preview-img">
        <h2 id="preview-name">Prusa i3</h2>
        <h3 id="preview-speed">Nyomtatási sebesség: 180 mm/s</h3>
        <div id="preview-plate" class="preview-row">Asztalméret: 250×210×210 mm</div>
        <div id="preview-materials" class="preview-row">Kompatibilis anyagok: PLA,ABS,PETG</div>
    </div>
</div>

<style>
body {
    background: linear-gradient(120deg, #181d23 0%, #232b33 100%);
    font-family: 'Segoe UI', Arial, sans-serif;
    min-height: 100vh;
    margin: 0;
}

.addprinter-flexroot {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    min-height: 92vh;
    gap: 5vw;
    padding-top: 6vh;
}

.addprinter-form {
    background: none;
    box-shadow: none;
    border-radius: 24px;
    padding: 36px 0 30px 0;
    width: 350px;
    margin-top: 0;
    animation: fadeInUp 0.9s cubic-bezier(.85,-0.25,.22,1.2);
    position: relative;
    overflow: visible;
}

.addprinter-form h1 {
    text-align: left;
    color: #1ed760;
    margin-bottom: 30px;
    font-weight: 700;
    letter-spacing: 1px;
    font-size: 2.1rem;
    z-index: 1;
    position: relative;
    text-shadow: 0 2px 16px #1ed76022, 0 1px 0 #222;
}

.form-label {
    color: #d6fad9;
    font-size: 1.02rem;
    margin-bottom: 6px;
    z-index: 1;
    position: relative;
    letter-spacing: .5px;
}

.addprinter-input {
    background: #23282f;
    border: 1.5px solid #1ed76033;
    border-radius: 8px;
    color: #d3f9e8 !important;
    font-size: 1.1rem;
    padding: 12px 14px;
    margin-bottom: 10px;
    transition: border 0.2s, box-shadow 0.2s;
    outline: none;
    z-index: 1;
    position: relative;
    width: 100%;
}

.addprinter-input:focus {
    border-color: #1ed760;
    box-shadow: 0 0 0 2px #1ed76044;
    background: #232b33;
}

.addprinter-btn {
    background: linear-gradient(90deg, #1ed760 30%, #0df2a9 100%);
    color: #232b33;
    font-weight: 700;
    font-size: 1.08rem;
    border: none;
    border-radius: 18px;
    padding: 13px 42px;
    box-shadow: 0 3px 14px 0 #1ed76044;
    letter-spacing: 1px;
    cursor: pointer;
    transition: background 0.22s, transform 0.16s, color 0.22s, box-shadow 0.21s;
    z-index: 1;
    position: relative;
    text-decoration: none;
    display: inline-block;
}

.addprinter-btn:hover, .addprinter-btn:active {
    background: linear-gradient(90deg, #13b455 30%, #0df2a9 100%);
    color: #fff;
    transform: translateY(-2px) scale(1.035);
    box-shadow: 0 6px 24px 0 #1ed76055;
}

.cancel-btn {
    background: transparent;
    border: 2px solid #1ed760;
    color: #1ed760;
    font-weight: 600;
    font-size: 1.08rem;
    border-radius: 18px;
    padding: 11px 38px;
    margin-left: 10px;
    letter-spacing: 1px;
    cursor: pointer;
    transition: background 0.23s, color 0.18s, border 0.18s;
    text-decoration: none;
    display: inline-block;
}

.cancel-btn:hover, .cancel-btn:active {
    background: #1ed760;
    color: #232b33;
    border-color: #1ed760;
    text-decoration: none;
}

.addprinter-bigpreview {
    margin-top: 0;
    background: rgba(22, 28, 32, 0.98);
    border-radius: 38px;
    box-shadow: 0 8px 40px 0 rgba(0,0,0,0.23);
    min-width: 400px;
    max-width: 480px;
    padding: 46px 28px 34px 28px;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: box-shadow 0.3s;
    border: 2px solid #1ed76022;
}

.addprinter-bigpreview img {
    width: 240px;
    height: 240px;
    object-fit: contain;
    border-radius: 28px;
    box-shadow: 0 4px 24px #1ed76033;
    background: #181d23;
    margin-bottom: 20px;
}

.addprinter-bigpreview h2 {
    color: #1ed760;
    margin-bottom: 10px;
    font-size: 1.85rem;
    letter-spacing: .7px;
    font-weight: 700;
    text-shadow: 0 2px 12px #1ed76022;
}

.addprinter-bigpreview h3,
.addprinter-bigpreview .preview-row {
    color: #d6fad9;
    font-size: 1.13rem;
    margin-bottom: 7px;
    font-weight: 500;
    text-align: center;
}

.addprinter-bigpreview .preview-row {
    font-size: 1.02rem;
    margin-bottom: 6px;
}

@keyframes fadeInUp {
    0% {
        opacity: 0;
        transform: translateY(60px);
    }
    100% {
        opacity: 1;
        transform: none;
    }
}

@media (max-width: 950px) {
    .addprinter-flexroot {
        flex-direction: column;
        align-items: center;
        gap: 30px;
        padding-top: 2vh;
    }
    .addprinter-form, .addprinter-bigpreview {
        width: 95vw;
        max-width: 490px;
    }
    .addprinter-bigpreview {
        min-width: 0;
    }
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const select = document.getElementById('printertype');
        const img = document.getElementById('preview-img');
        const name = document.getElementById('preview-name');
        const speed = document.getElementById('preview-speed');
        const plate = document.getElementById('preview-plate');
        const materials = document.getElementById('preview-materials');

        function updatePreview() {
            const option = select.options[select.selectedIndex];
            img.src = 'img/printer_types/' + option.getAttribute('data-img');
            img.alt = option.getAttribute('data-name');
            name.textContent = option.getAttribute('data-name');
            speed.textContent = 'Nyomtatási sebesség: ' + option.getAttribute('data-speed');
            plate.textContent = 'Asztalméret: ' + option.getAttribute('data-plate');
            materials.textContent = 'Kompatibilis anyagok: ' + option.getAttribute('data-materials');
        }
        select.addEventListener('change', updatePreview);
        updatePreview(); 
    });
</script>