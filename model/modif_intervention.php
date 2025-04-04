<?php
require_once "../bdd.php";


error_reporting(E_ALL);
ini_set('display_errors', 1);
if (isset($_POST['edit-btn-intervention']) && !empty($_POST['edit-btn-intervention'])) {
    $id = $_POST['edit-id-intervention'];
    $client = $_POST['edit-client'];
    $employe = $_POST['edit-employe'];
    $short_description_id = $_POST['edit-intervention-name'];
    $longDescription = $_POST['edit-longDescription'];
    $date = $_POST['edit-startDate']; // input date
    $heure = $_POST['edit-startHour']; // input time

//    echo "id : " . $id;
//    echo "<br>";
//    echo "client : " . $client;
//    echo "<br>";
//    echo "employe : " . $employe;
//    echo "<br>";
//    echo "short_description_id : " . $short_description_id;
//    echo "<br>";
//    echo "longDescription : " . $longDescription;
//    echo "<br>";
//    echo "date : " . $date;
//    echo "<br>";
//    echo "heure : " . $heure;

    $startDatetime = "$date $heure:00";
    $startTime = strtotime($startDatetime);

    // On récupère la durée de l’intervention (en heures)
    $stmt = $db->prepare("SELECT duration FROM intervention_category WHERE id = :id");
    $stmt->execute(['id' => $short_description_id]);
    $category = $stmt->fetch();

    if ($category) {
        $duree = $category['duration'];
        $endTime = $startTime + ($duree * 3600);

        // Mise à jour
        $update = $db->prepare("UPDATE intervention 
            SET start_time = :start_time, 
                end_time = :end_time,
                client_id = :client, 
                employee_id = :employee,
                short_description_id = :short_desc,
                long_description = :long_desc 
            WHERE id = :id");

       $update->execute([
            'start_time' => $startTime,
            'end_time' => $endTime,
            'client' => $client,
            'employee' => $employe,
            'short_desc' => $short_description_id,
            'long_desc' => $longDescription,
            'id' => $id
        ]);
    }
    
    header("Location: ". $_SERVER['HTTP_REFERER']);
}