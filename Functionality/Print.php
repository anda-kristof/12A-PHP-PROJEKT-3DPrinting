<?php

function PrintValidate(




    $plate_length,
    $plate_height,
    $plate_width,
    $filament_grams,

    $material_name,
    $material_density,

    $volume_mm,
    $recommended_material,
    $max_size_mm
) {
    $errors = [];
    $model_grams = ($material_density / 1000) * $volume_mm;
    if ($filament_grams < $model_grams) {
        $errors["filament"] = "Nincs elég filamented";
    }
    if ($material_name != $recommended_material) {
        $errors["filament"] = "Nem ajánlott anyag!";
    }
    if ($max_size_mm > $plate_height && $max_size_mm > $plate_width && $max_size_mm > $plate_length) {
        $errors["size"] = "Túl nagy modell ehhez a nyomtatóhoz!";
    }
    return $errors;
}
