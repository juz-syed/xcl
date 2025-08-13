<?php
$host = "localhost";
$user = "root";
$password = ""; 
$database = "xtreme_league"; 

$conn = new mysqli($host, $user, $password, $database);

// Connection check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
