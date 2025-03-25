<?php
header('Content-Type: application/json');
session_start();
include "OQ_database_conn.php"; // Ensure database connection

if (!isset($_POST['username']) || !isset($_POST['password'])) {
    echo json_encode(["success" => false, "message" => "Missing username or password"]);
    exit();
}

$username = $_POST['username'];
$password = $_POST['password'];

// Use a prepared statement to prevent SQL injection
$query = "SELECT * FROM registration WHERE username = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verify hashed password
    if (password_verify($password, $user['password'])) {
        $_SESSION['user'] = $username; // Store session for logged-in user
        echo json_encode(["success" => true, "message" => "Login successful"]);
    } else {
        echo json_encode(["success" => false, "message" => "Invalid username or password"]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid username or password"]);
}

$stmt->close();
$conn->close();
?>
