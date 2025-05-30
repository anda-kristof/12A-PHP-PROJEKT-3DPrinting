<?php 

include_once("Classes.php");

class Connection{
    public $hostname = "localhost";
    public $username = "root";
    public $password = "";
    public $db = "12a_3dprinting";
    public $conn;

    function __construct(){
        $this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->db);
        if($this->conn->connect_error){
            die("Connection failed:" . $this->conn->connect_error);
        }
        $this->conn->set_charset("utf8mb4");
    }

    function getUsers(){
        $sql = "SELECT * FROM users";
        $result = $this->conn->query($sql);
        if(!$result){
            die("Query error!");
        }
        $users = [];
        while($row = $result->fetch_object()){
            $users[] = new User($row->user_id, $row->username, $row->password, $row->email);
        }
        return $users;
    }

    function getJobs(){
        $sql = "SELECT * FROM jobs";
        $result = $this->conn->query($sql);
        if(!$result){
            die("Query error!");
        }
        $jobs = [];
        while($row = $result->fetch_object()){
            $jobs[] = new Job($row->job_id, $row->user_id, $row->printer_id, $row->filament_id, $row->starts_time, $row->print_time, $row->status, $row->grams, $row->model_id);
        }
        return $jobs;
    }

    function getFilaments(){
        $sql = "SELECT * FROM filaments";
        $result = $this->conn->query($sql);
        if(!$result){
            die("Query error!");
        }
        $filaments = [];
        while($row = $result->fetch_object()){
            $filaments[] = new Filament($row->filament_id, $row->material_id, $row->filament_grams);
        }
        return $filaments;
    }

    function getMaterials(){
        $sql = "SELECT * FROM materials";
        $result = $this->conn->query($sql);
        if(!$result){
            die("Query error!");
        }
        $materials = [];
        while($row = $result->fetch_object()){
            $materials[] = new Material($row->material_id, $row->name, $row->color, $row->density, $row->img);
        }
        return $materials;
    }

    function getModels(){
        $sql = "SELECT * FROM models";
        $result = $this->conn->query($sql);
        if(!$result){
            die("Query error!");
        }
        $models = [];
        while($row = $result->fetch_object()){
            $models[] = new Model($row->model_id, $row->user_id, $row->name, $row->volume_mm, $row->max_size_mm, $row->description, $row->img, $row->recommended_material);
        }
        return $models;
    }


    function getPrinters(){
        $sql = "SELECT * FROM printers";
        $result = $this->conn->query($sql);
        if(!$result){
            die("Query error!");
        }
        $printers = [];
        while($row = $result->fetch_object()){
            $printers[] = new Printer($row->printer_id, $row->printer_type_id, $row->printer_name, $row->status, $row->job_id);
        }
        return $printers;
    }


    function getPrinterTypes(){
        $sql = "SELECT * FROM printer_types";
        $result = $this->conn->query($sql);
        if(!$result){
            die("Query error!");
        }
        $printer_types = [];
        while($row = $result->fetch_object()){
            $printer_types[] = new Printer_type($row->printer_type_id, $row->printer_type_name, $row->printing_speed, $row->plate_length, $row->plate_height, $row->plate_width, $row->compatible_materials, $row->img);
        }
        return $printer_types;
    }
}

?>