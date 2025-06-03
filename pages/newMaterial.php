<div class="filament-bg">
    <form action="?todo=addfilament" method="POST" class="filament-form" autocomplete="off">
        <h1 class="filament-title">Filament készlet bővítés</h1>
        <div class="materials-card-list">
            <?php foreach ($materials as $m):
    $imgWebPath = "img/materials/" . $m->img;
    $imgDiskPath = __DIR__ . "/img/materials/" . $m->img;

    
    echo "<!-- imgWebPath: $imgWebPath | imgDiskPath: $imgDiskPath | file_exists: " . (file_exists($imgDiskPath) ? 'igen' : 'nem') . " -->\n";
?>

            <label class="material-card">
                <input type="radio" name="material_id" id="material_id" value="<?= htmlspecialchars($m->material_id) ?>" required style="display:none;">
                <div class="material-card-inner">
                    <div class="material-img-wrap">
                        <?php if ($m->img && file_exists($imgDiskPath)): ?>
                            <img src="<?= $imgWebPath ?>" alt="<?= htmlspecialchars($m->name . ' ' . $m->color) ?>" class="material-img">
                        <?php else: ?>
                            <div class="material-img-placeholder"><?= strtoupper(substr($m->name,0,1)) ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="material-card-text">
                        <span class="material-name"><?= htmlspecialchars($m->name) ?></span>
                        <span class="material-color"><?= htmlspecialchars($m->color) ?></span>
                    </div>
                </div>
            </label>
            <?php endforeach; ?>
        </div>
        <div class="my-2">
            <label for="quantity" class="form-label">Hozzáadandó mennyiség (gramm)</label>
            <input type="number" class="form-control filament-input" name="quantity" id="quantity" min="1" max="10000" step="1" required>
        </div>
        <div class="my-2 filament-btn-row">
            <button type="submit" class="filament-btn">Hozzáadás</button>
            <a href="?todo=dashboard" class="filament-btn filament-btn-secondary">Vissza</a>
        </div>
    </form>
</div>

<style>
.filament-bg {
    min-height: 100vh;
    width: 100vw;
    background: linear-gradient(120deg, #10151A 0%, #232b33 100%);
    display: flex;
    align-items: center;
    justify-content: center;
}
.filament-form {
    background: rgba(30, 37, 44, 0.98);
    border-radius: 38px;
    box-shadow: 0 8px 40px 0 #1ed76022;
    padding: 38px 34px 32px 34px;
    min-width: 410px;
    max-width: 440px;
    display: flex;
    flex-direction: column;
    align-items: center;
    animation: fadeInUp 0.8s cubic-bezier(.85,-0.25,.22,1.2);
    position: relative;
}
.filament-title {
    color: #1ed760;
    font-size: 2.1rem;
    font-weight: 700;
    margin-bottom: 18px;
    text-align: center;
    letter-spacing: 1.5px;
    text-shadow: 0 2px 18px #1ed76020, 0 1px 0 #222;
}
.materials-card-list {
    display: flex;
    flex-wrap: wrap;
    gap: 18px;
    justify-content: center;
    margin-bottom: 18px;
    max-height: 340px;
    overflow-y: auto;
    width: 100%;
}
.material-card {
    cursor: pointer;
    border-radius: 18px;
    background: linear-gradient(110deg,#1d2228 60%,#232b33 100%);
    box-shadow: 0 2px 12px #1ed76022;
    padding: 0;
    margin: 0;
    min-width: 112px;
    max-width: 128px;
    flex: 1 1 110px;
    transition: box-shadow 0.18s,border 0.18s,transform 0.18s;
    border: 2.5px solid transparent;
    display: block;
}
.material-card-inner {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 13px 10px 10px 10px;
}
.material-img-wrap {
    width: 66px;
    height: 66px;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
}
.material-img {
    width: 64px;
    height: 64px;
    object-fit: cover;
    border-radius: 12px;
    background: #181d23;
    box-shadow: 0 1px 8px #1ed76033;
}
.material-img-placeholder {
    width: 64px;
    height: 64px;
    border-radius: 12px;
    background: #23282f;
    color: #1ed760;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.2rem;
    font-weight: 800;
    box-shadow: 0 1px 8px #1ed76011;
}
.material-card-text {
    text-align: center;
    width: 100%;
}
.material-name {
    color: #1ed760;
    font-weight: 700;
    font-size: 1.08rem;
    display: block;
    margin-bottom: 2px;
}
.material-color {
    color: #c3e4cb;
    font-size: .97rem;
    font-weight: 500;
}
.material-card.selected {
    border: 2.5px solid #1ed760;
    box-shadow: 0 4px 22px #1ed76055;
    transform: translateY(-4px) scale(1.04);
}
.material-card:hover {
    box-shadow: 0 6px 24px #1ed76033;
    border: 2.5px solid #13b455;
    transform: translateY(-2px) scale(1.02);
}
.my-2 {
    margin-bottom: 18px;
    width: 100%;
}
.form-label {
    color: #d6fad9;
    font-size: 1.07rem;
    margin-bottom: 5px;
    display: block;
    font-weight: 500;
}
.filament-input,
.form-control {
    background: #23282f;
    border: 1.5px solid #1ed76033;
    border-radius: 10px;
    color: #d3f9e8 !important;
    font-size: 1.08rem;
    padding: 11px 14px;
    margin-top: 2px;
    width: 100%;
    outline: none;
    transition: border 0.2s, box-shadow 0.2s;
    box-shadow: 0 1px 6px #1ed76011;
}
.filament-input:focus {
    border-color: #1ed760;
    box-shadow: 0 0 0 2px #1ed76044;
    background: #232b33;
}
.filament-btn-row {
    display: flex;
    gap: 18px;
    justify-content: center;
}
.filament-btn {
    background: linear-gradient(90deg, #1ed760 10%, #0df2a9 90%);
    color: #232b33;
    font-weight: 700;
    font-size: 1.07rem;
    border: none;
    border-radius: 18px;
    padding: 13px 38px;
    box-shadow: 0 3px 14px 0 #1ed76044;
    cursor: pointer;
    transition: background 0.22s, transform 0.13s, color 0.21s, box-shadow 0.19s;
    text-decoration: none;
    outline: none;
    display: inline-block;
}
.filament-btn:hover, .filament-btn:active {
    background: linear-gradient(90deg, #13b455 20%, #0df2a9 100%);
    color: #fff;
    transform: translateY(-2px) scale(1.04);
    box-shadow: 0 6px 24px 0 #1ed76055;
}
.filament-btn-secondary {
    background: none;
    border: 2px solid #1ed760;
    color: #1ed760;
    padding: 11px 36px;
    transition: background 0.21s, color 0.12s, border 0.18s;
}
.filament-btn-secondary:hover, .filament-btn-secondary:active {
    background: #1ed760;
    color: #232b33;
    border-color: #1ed760;
    text-decoration: none;
}
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(60px);}
    100% { opacity: 1; transform: none;}
}
@media (max-width: 700px) {
    .filament-form {
        min-width: 0;
        width: 97vw;
        padding: 22px 5vw 24px 5vw;
        max-width: 100vw;
    }
    .materials-card-list {
        gap: 12px;
    }
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    const cards = document.querySelectorAll('.material-card');
    cards.forEach(card => {
        card.addEventListener('click', function() {
            cards.forEach(c => c.classList.remove('selected'));
            card.classList.add('selected');
            const radio = card.querySelector('input[type=radio]');
            if (radio) radio.checked = true;
        });
    });
    
    const checked = document.querySelector('.material-card input[type=radio]:checked');
    if (checked) checked.closest('.material-card').classList.add('selected');
});
</script>