<?php
// checkjobs.php



if(isset($_SESSION['user'])){
    $conn = new Connection(); // vagy ahogy a te projektedben kell
    $myprinters = $conn->getUserPrinters($_SESSION['user']->id);
    $myjobs = $conn->getUserJobs($_SESSION['user']->id);

    foreach($myprinters as $p){
        $conn->setDoneP($p->printer_id);
    }
    foreach($myjobs as $j){
        $conn->setDoneJ($j->job_id);
    }
}