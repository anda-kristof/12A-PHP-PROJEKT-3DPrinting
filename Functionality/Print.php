<?php

function PrintValidate(




    $plate_length,
    $plate_height,
    $plate_width,
    $filament_grams,
$print_id,
    $material_name,
    $material_density,
    $compatible_materials,
    $volume_mm,
    $recommended_material,
    $max_size_mm
) {
    $errors = [];
    $model_grams = ($material_density / 1000) * $volume_mm;
    if ($filament_grams < $model_grams) {
        $errors["filament"] = "Nincs elég filamented";
    }
    if($print_id == 0){$errors["printer"] = "Nincs szabad nyomtató kiválasztva!";

    }
    if(!(str_contains($compatible_materials, $material_name))){$errors["printer"] = "A nyomtató nem kompatibilis a kiválasztott anyaggal!";

    }
    if ($material_name != $recommended_material) {
        $errors["filament"] = "Nem ajánlott anyag!";
    }
    if ($max_size_mm > $plate_height && $max_size_mm > $plate_width && $max_size_mm > $plate_length) {
        $errors["size"] = "Túl nagy modell ehhez a nyomtatóhoz!";
    }
    return $errors;
}
