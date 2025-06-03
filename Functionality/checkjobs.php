<?php

require_once(__DIR__ . '/../Functionality/Classes.php'); 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}                                        
require_once(__DIR__ . '/../Functionality/Connection.php'); 

if (!isset($_SESSION['user']) || !is_object($_SESSION['user'])) {
    echo "<div style='color:red'>Nem vagy bejelentkezve!</div>";
    exit;
}
$user_id = $_SESSION['user']->user_id ?? null;
if ($user_id === null) {
    echo "<div style='color:red'>Nincs user_id!</div>";
    exit;
}

$conn = new Connection();
$user_id = $_SESSION['user']->user_id;


if (isset($_SESSION['user'])) {
    $conn = new Connection(); 
    $myprinters = $conn->getUserPrinters($_SESSION['user']->user_id);
    $myjobs = $conn->getUserJobs($_SESSION['user']->user_id);




    foreach ($myjobs as $j) {
    
    if ($j->jobs_status !== "printing") continue;

    $start = $j->jobs_starts_time;
    $print_time = $j->jobs_print_time;

    $start_dt = new DateTime($start);
    list($h, $m, $s) = explode(':', $print_time);
    $interval = new DateInterval("PT{$h}H{$m}M{$s}S");
    $end_dt = clone $start_dt;
    $end_dt->add($interval);
    $now = new DateTime();

    if ($end_dt <= $now) {
        
        $conn->setDoneJ($j->jobs_job_id);
        $conn->setDoneP($j->jobs_printer_id);
    }
}
}
