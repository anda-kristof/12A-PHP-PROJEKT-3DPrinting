<div class="container-fluid py-5" style="background:linear-gradient(120deg, #1b2838 0%, #232b33 100%); min-height:100vh;">
  <div class="d-flex justify-content-center align-items-center" style="min-height:80vh;">
    <div class="card shadow-lg p-4" style="max-width:500px; width:100%; border-radius:22px; background:linear-gradient(120deg, #232b33 0%, #141d23 100%); color:#e0ffe0;">
      <h2 class="mb-4 text-center" style="font-family: 'Montserrat', sans-serif; color:#19ff19; letter-spacing:1px;">
        Új Modell Feltöltése
      </h2>
      <form method="POST" enctype="multipart/form-data" action="?todo=upload">
        <div class="mb-3">
          <label for="name" class="form-label">Név</label>
          <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($name ?? '') ?>" required maxlength="100" style="background:#181b1f; color:#e0ffe0; border:1.5px solid #19ff19;">
          <?php if(!empty($errors['name'])): ?>
            <div class="text-danger mt-1"><?= htmlspecialchars($errors['name']) ?></div>
          <?php endif; ?>
        </div>
        <div class="mb-3">
          <label for="volume" class="form-label">Térfogat (mm³)</label>
          <input type="number" class="form-control" id="volume" name="volume_mm" min="1" value="<?= htmlspecialchars($volume ?? '') ?>" required style="background:#181b1f; color:#e0ffe0; border:1.5px solid #19ff19;">
          <?php if(!empty($errors['volume_mm'])): ?>
            <div class="text-danger mt-1"><?= htmlspecialchars($errors['volume_mm']) ?></div>
          <?php endif; ?>
        </div>
        <div class="mb-3">
          <label for="maxsize" class="form-label">Maximális méret (mm)</label>
          <input type="number" class="form-control" id="maxsize" name="max_size_mm" min="1" value="<?= htmlspecialchars($maxsize ?? '') ?>" required style="background:#181b1f; color:#e0ffe0; border:1.5px solid #19ff19;">
          <?php if(!empty($errors['max_size_mm'])): ?>
            <div class="text-danger mt-1"><?= htmlspecialchars($errors['max_size_mm']) ?></div>
          <?php endif; ?>
        </div>
        <div class="mb-3">
          <label for="description" class="form-label">Leírás</label>
          <textarea class="form-control" id="description" name="description" rows="3" maxlength="400" style="background:#181b1f; color:#e0ffe0; border:1.5px solid #19ff19;"><?= htmlspecialchars($description ?? '') ?></textarea>
          <?php if(!empty($errors['description'])): ?>
            <div class="text-danger mt-1"><?= htmlspecialchars($errors['description']) ?></div>
          <?php endif; ?>
        </div>
        <div class="mb-3">
          <label for="recommended" class="form-label">Ajánlott anyag</label>
          <input type="text" class="form-control" id="recommended" name="recommended_material" maxlength="100" value="<?= htmlspecialchars($recommended ?? '') ?>" style="background:#181b1f; color:#e0ffe0; border:1.5px solid #19ff19;">
          <?php if(!empty($errors['recommended_material'])): ?>
            <div class="text-danger mt-1"><?= htmlspecialchars($errors['recommended_material']) ?></div>
          <?php endif; ?>
        </div>
        
        <button type="submit" class="btn w-100" style="background:#19ff19; color:#181b1f; font-weight:600; border-radius:16px; font-size:1.15rem; letter-spacing:1px;">
          Feltöltés
        </button>
      </form>
    </div>
  </div>
</div>
<link href="https://fonts.googleapis.com/css?family=Montserrat:600,400&display=swap" rel="stylesheet">