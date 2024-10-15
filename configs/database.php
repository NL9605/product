<?php
function database(){
    $host = "mysql:host=localhost:3306;dbname=Fan";
    $username = "root";
    $pass = "HTTN9605dtl";
    try {
        $conn = new PDO($host, $username, $pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //echo "Connected successfully";
    } catch (PDOException $ex) {
        //echo "connection failed: " . $ex->getMessage();
    }return $conn;
}
