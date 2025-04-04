<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once "../bdd.php";

    $start_time = isset($_POST['start-time']) ? trim($_POST['start-time']) : '';
    $employee_id = isset($_POST['employee_id']) ? trim($_POST['employee_id']) : '';
    $client_id = isset($_POST['client_id']) ? trim($_POST['client_id']) : '';
    $short_description_id = isset($_POST['short_description_id']) ? trim($_POST['short_description_id']) : '';
}