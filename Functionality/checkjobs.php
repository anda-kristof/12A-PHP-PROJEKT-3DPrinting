<?php
// checkjobs.php
require_once(__DIR__ . '/../Functionality/Classes.php'); // 1. osztálydefiníciók
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}                                        // 2. session
require_once(__DIR__ . '/../Functionality/Connection.php'); // 3. többi include

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
    $conn = new Connection(); // vagy ahogy a te projektedben kell
    $myprinters = $conn->getUserPrinters($_SESSION['user']->user_id);
    $myjobs = $conn->getUserJobs($_SESSION['user']->user_id);




    foreach ($myjobs as $j) {
    // Csak a printing státuszú jobokkal foglalkozzunk!
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
        // Ha lejárt, akkor állítsd finished-re a jobot és idle-re a printert
        $conn->setDoneJ($j->jobs_job_id);
        $conn->setDoneP($j->jobs_printer_id);
    }
}
}
