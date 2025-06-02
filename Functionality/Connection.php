<?php

include_once("Classes.php");

class Connection
{
    public $hostname = "localhost";
    public $username = "root";
    public $password = "";
    public $db = "12a_3dprinting";
    public $conn;

    function __construct()
    {
        $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->db);
        if ($this->conn->connect_error) {
            die("Connection failed:" . $this->conn->connect_error);
        }
        $this->conn->set_charset("utf8mb4");
    }

    function getUsers()
    {
        $sql = "SELECT * FROM users";
        $result = $this->conn->query($sql);
        if (!$result) {
            die("Query error!");
        }
        $users = [];
        while ($row = $result->fetch_object()) {
            $users[] = new User($row->user_id, $row->username, $row->password, $row->email);
        }
        return $users;
    }

    function getJobs()
    {
        $sql = "SELECT * FROM jobs";
        $result = $this->conn->query($sql);
        if (!$result) {
            die("Query error!");
        }
        $jobs = [];
        while ($row = $result->fetch_object()) {
            $jobs[] = new Job($row->job_id, $row->user_id, $row->printer_id, $row->filament_id, $row->starts_time, $row->print_time, $row->status, $row->grams, $row->model_id);
        }
        return $jobs;
    }

    function getFilaments()
    {
        $sql = "SELECT * FROM filaments";
        $result = $this->conn->query($sql);
        if (!$result) {
            die("Query error!");
        }
        $filaments = [];
        while ($row = $result->fetch_object()) {
            $filaments[] = new Filament($row->filament_id, $row->material_id, $row->user_id, $row->filament_grams);
        }
        return $filaments;
    }

    function getMaterials()
    {
        $sql = "SELECT * FROM materials";
        $result = $this->conn->query($sql);
        if (!$result) {
            die("Query error!");
        }
        $materials = [];
        while ($row = $result->fetch_object()) {
            $materials[] = new Material($row->material_id, $row->name, $row->color, $row->density, $row->img);
        }
        return $materials;
    }

    function getModels()
    {
        $sql = "SELECT * FROM models";
        $result = $this->conn->query($sql);
        if (!$result) {
            die("Query error!");
        }
        $models = [];
        while ($row = $result->fetch_object()) {
            $models[] = new Model($row->model_id, $row->user_id, $row->name, $row->volume_mm, $row->max_size_mm, $row->description, $row->img, $row->recommended_material);
        }
        return $models;
    }


    function getPrinters()
    {
        $sql = "SELECT * FROM printers";
        $result = $this->conn->query($sql);
        if (!$result) {
            die("Query error!");
        }
        $printers = [];
        while ($row = $result->fetch_object()) {
            $printers[] = new Printer($row->printer_id, $row->printer_type_id, $row->printer_name, $row->status, $row->job_id);
        }
        return $printers;
    }


    function getPrinterTypes()
    {
        $sql = "SELECT * FROM printer_types";
        $result = $this->conn->query($sql);
        if (!$result) {
            die("Query error!");
        }
        $printer_types = [];
        while ($row = $result->fetch_object()) {
            $printer_types[] = new Printer_type($row->printer_type_id, $row->printer_type_name, $row->printing_speed, $row->plate_length, $row->plate_height, $row->plate_width, $row->compatible_materials, $row->img);
        }
        return $printer_types;
    }

    function addUser($username, $password, $email)
    {
        $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
        $this->conn->query($sql);
    }

    function getUserPrinters($user_id)
    {
        $sql = "SELECT printers.*, printer_types.printer_type_name, printer_types.img, printer_types.printing_speed , printer_types.plate_width, printer_types.plate_height, printer_types.plate_length
        FROM printers JOIN printer_types ON printer_types.printer_type_id = printers.printer_type_id WHERE printers.user_id = $user_id
        ";
        $results = $this->conn->query($sql);
        if (!$results) {
            die("Some kind of error, no time to know what kind");
        }
        $userprinters = [];
        while ($row = $results->fetch_object()) {
            $userprinters[] = $row;
        }
        return $userprinters;
    }

    function getUserFilaments($user_id)
    {
        $sql = "SELECT filaments.*, materials.name, materials.color, materials.img, materials.density FROM filaments JOIN materials ON filaments.material_id = materials.material_id WHERE filaments.user_id = $user_id";
        $results = $this->conn->query($sql);
        if(!$results){
            die("Valami a filament lekérdezéseknél félrement". $this->conn->error);
        }
        $userfilaments = [];
        while($row = $results->fetch_object()){
            $userfilaments[] = $row;
        }
        return $userfilaments;
    }

    function getUserJobs($user_id){
        $sql = "SELECT
  -- jobs table
  jobs.job_id            AS jobs_job_id,
  jobs.user_id           AS jobs_user_id,
  jobs.printer_id        AS jobs_printer_id,
  jobs.filament_id       AS jobs_filament_id,
  jobs.starts_time       AS jobs_starts_time,
  jobs.print_time        AS jobs_print_time,
  jobs.status            AS jobs_status,
  jobs.grams             AS jobs_grams,
  jobs.model_id          AS jobs_model_id,

  -- printers table
  printers.printer_id         AS printers_printer_id,
  printers.printer_type_id    AS printers_printer_type_id,
  printers.user_id            AS printers_user_id,
  printers.printer_name       AS printers_printer_name,
  printers.status             AS printers_status,
  printers.job_id             AS printers_job_id,

  -- printer_types
  printer_types.printer_type_id        AS printer_types_printer_type_id,
  printer_types.printer_type_name      AS printer_types_printer_type_name,
  printer_types.printing_speed         AS printer_types_printing_speed,
  printer_types.plate_length           AS printer_types_plate_length,
  printer_types.plate_height           AS printer_types_plate_height,
  printer_types.plate_width            AS printer_types_plate_width,
  printer_types.compatible_materials   AS printer_types_compatible_materials,
  printer_types.img                    AS printer_types_img,

  -- filaments table
  filaments.filament_id        AS filaments_filament_id,
  filaments.material_id        AS filaments_material_id,
  filaments.user_id            AS filaments_user_id,
  filaments.filament_grams     AS filaments_filament_grams,

  -- materials table
  materials.material_id        AS materials_material_id,
  materials.name               AS materials_name,
  materials.color              AS materials_color,
  materials.density            AS materials_density,
  materials.img                AS materials_img,

  -- models table
  models.model_id              AS models_model_id,
  models.user_id               AS models_user_id,
  models.name                  AS models_name,
  models.volume_mm             AS models_volume_mm,
  models.max_size_mm           AS models_max_size_mm,
  models.description           AS models_description,
  models.img                   AS models_img,
  models.recommended_material  AS models_recommended_material

FROM jobs
INNER JOIN printers      ON printers.printer_id = jobs.printer_id
INNER JOIN printer_types ON printer_types.printer_type_id = printers.printer_type_id
INNER JOIN filaments     ON filaments.filament_id = jobs.filament_id
INNER JOIN materials     ON materials.material_id = filaments.material_id
INNER JOIN models        ON models.model_id = jobs.model_id
WHERE jobs.user_id = $user_id";
$results = $this->conn->query($sql);
if(!$results){
    die("query error:" . $this->conn->error);
}
$userjobs = [];
while($row = $results->fetch_object()){
    $userjobs[] = $row;
}
return $userjobs;
    }
}
