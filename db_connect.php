<?php
// db_connect.php

$servername = "localhost"; // Database server
$username = "root";         // Database username
$password = "";             // Database password
$dbname = "ludo_game";      // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
