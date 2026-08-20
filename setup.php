<?php
$host = "127.0.0.1";
$username = "root";
$password = "";
$port = 3307;

// First connect without specifying db to create database if missing
$conn = new mysqli($host, $username, $password, "", $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database
$sqlDb = "CREATE DATABASE IF NOT EXISTS techvibe";
if ($conn->query($sqlDb) === TRUE) {
    echo "Database 'techvibe' checked/created successfully.<br>";
} else {
    die("Error creating database: " . $conn->error);
}

$conn->select_db("techvibe");

// Create employees table
$sqlTable = "CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    department VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sqlTable) === TRUE) {
    echo "Table 'employees' checked/created successfully.<br>";
    echo "<a href='index.php'>Go to Application Index</a>";
} else {
    die("Error creating table: " . $conn->error);
}

$conn->close();
?>

