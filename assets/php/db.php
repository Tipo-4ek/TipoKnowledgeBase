<?php
$servername = "0.0.0.0";
$username = "username";
$password = "password";
$dbname = "db";


try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e) {
    // print_console ("Connection failed: " . $e->getMessage());
}
