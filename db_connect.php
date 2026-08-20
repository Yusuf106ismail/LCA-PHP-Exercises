<?php
$host = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "techvibe";
$port = 3307;

// Connect specifying port 3307 explicitly
$conn = new mysqli($host, $username, $password, $dbname, $port);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>

