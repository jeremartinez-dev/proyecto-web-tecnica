<?php
$host = "localhost";
$user = "root"; 
$pass = "";     
$dbname = "escuela_db";

try {
    $conn = new mysqli($host, $user, $pass, $dbname);
    if ($conn->connect_error) {
        die("Error de conexión: " . $conn->connect_error);
    }
} catch (Exception $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
