<?php
ob_start();
session_start();

// Database configuration
$host = "localhost";
$username = "root";
$password = "";
$dbname = "vetcap_storage";

// Create a new connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
