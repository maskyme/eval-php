<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "garage";
    
    try {
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    } 
    catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }