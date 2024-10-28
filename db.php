<?php
$servername = "localhost"; // Database server, usually 'localhost'
$username = "root";        // Database username
$password = "";            // Database password
$dbname = "skilltest";   // Database name, ensure you create this in your MySQL

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
