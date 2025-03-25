<?php
$servername = "localhost"; // Change if using a remote DB
$username = "root"; // Your database username
$password = ""; // Your database password
$dbname = "online_quiz_maker"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
