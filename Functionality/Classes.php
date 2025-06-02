<?php 

class User{
    function __construct(public $user_id, public $username, public $password, public $email){

    }
}
class Material{
    function __construct(public $material_id, public $name, public $color, public $density, public $img){

    }
}
class Filament{
    function __construct(public $filament_id, public $material_id, public $user_id, public $filament_grams){

    }
}

class Printer_type{
    function __construct(public $printer_type_id, public $printer_type_name, public $printing_speed, public $plate_length, public $plate_height, public $plate_width, public $compatible_materials, public $img){

    }
}

class Printer{
    function __construct(public $printer_id, public $printer_type_id, public $printer_name, public $status, public $job_id){

    }
}

class Model{
    function __construct(public $model_id, public $user_id, public $name, public $volume_mm, public $max_size_mm, public $description, public $img, public $recommended_material){

    }
}

class Job{
    function __construct(public $job_id, public $user_id, public $printer_id, public $filament_id, public $starts_time, public $print_time, public $status, public $grams, public $model_id){

    }
}





?>